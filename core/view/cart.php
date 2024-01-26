<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Cart
 * @package    core/view/cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/puconverter.php';
require'core/phpmailer/PHPMailer.php';
require'core/phpmailer/SMTP.php';
require'core/phpmailer/Exception.php';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$hash=md5($ip);
$html=preg_replace([
	'/<print page=[\"\']?heading[\"\']?>/',
	'/<print page=[\"\']?notes[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is'
],[
	htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
	$page['notes'],
	''
],$html);
$notification='';
$ti=time();
$overquantity=false;
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if(isset($_POST['qid'])&&isset($_POST['qty'])){
	$qid=filter_input(INPUT_POST,'qid',FILTER_SANITIZE_NUMBER_INT);
	$qty=filter_input(INPUT_POST,'qty',FILTER_SANITIZE_NUMBER_INT);
	if($qty==0){
		$s=$db->prepare("DELETE FROM `".$prefix."cart` WHERE `id`=:id");
		$s->execute([':id'=>$qid]);
	}
	if($qty>0){
		$rank=isset($_SESSION['rank'])?$_SESSION['rank']:0;
		$limit=0;
		if($rank!=0){
		  $us=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
		  $us->execute([':id'=>$uid]);
		  $user=$us->fetch(PDO::FETCH_ASSOC);
		  if($user['purchaseLimit']!=0)
		    $limit=$user['purchaseLimit'];
		  else{
		    if($rank==200)$limit=$config['memberLimit'];
				if($rank==210)$limit=$config['memberLimitBronze'];
		    if($rank==220)$limit=$config['memberLimitSilver'];
		    if($rank==230)$limit=$config['memberLimitGold'];
		    if($rank==240)$limit=$config['memberLimitPlatinum'];
				if($rank==310)$limit=$config['wholesaleLimit'];
		    if($rank==320)$limit=$config['wholesaleLimitBronze'];
				if($rank==330)$limit=$config['wholesaleLimitSilver'];
		    if($rank==340)$limit=$config['wholesaleLimitGold'];
		    if($rank==350)$limit=$config['wholesaleLimitPlatinum'];
		  }
		  if($limit>0){
		    if($qty > $limit)$qty=$limit;
		  }
		}
		$sc=$db->prepare("SELECT `iid` FROM `".$prefix."cart` WHERE `id`=:id");
		$sc->execute([
			':id'=>$qid
		]);
		$rc=$sc->fetch(PDO::FETCH_ASSOC);
		$si=$db->prepare("SELECT `quantity` FROM `".$prefix."content` WHERE `id`=:id");
		$si->execute([
			':id'=>$rc['iid']
		]);
		$ri=$si->fetch(PDO::FETCH_ASSOC);
		if($qty>$ri['quantity'])$overquantity=true;
		$s=$db->prepare("UPDATE `".$prefix."cart` SET `quantity`=:quantity WHERE `id`=:id");
		$s->execute([
			':quantity'=>$qty,
			':id'=>$qid
		]);
	}
}
if(isset($args[0])&&$args[0]=='confirm'){
	if($_POST['fullname'.$hash]==''){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$rewards=filter_input(INPUT_POST,'rewards',FILTER_UNSAFE_RAW);
		$pid=filter_input(INPUT_POST,'pid',FILTER_UNSAFE_RAW);
		$hid=isset($_POST['hid'])?filter_input(INPUT_POST,'hid',FILTER_UNSAFE_RAW):0;
		$postoption='';
		if($pid=='AUS_PARCEL_REGULAR')$postoption='Australia Post Regular Post'; // AUS_PARCEL_REGULAR
		if($pid=='AUS_PARCEL_EXPRESS')$postoption='Australia Post Express Post'; // AUS_PARCEL_EXPRESS
		$payoption=filter_input(INPUT_POST,'payoption',FILTER_UNSAFE_RAW);
		if($payoption!=0){
			$spo=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
			$spo->execute([':id'=>$payoption]);
			$po=$spo->fetch(PDO::FETCH_ASSOC);
		}else{
			$po=[
				'id'=>0,
				'type'=>0,
				'title'=>'',
				'value'=>0
			];
		}
		$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `email`=:email");
			$s->execute([':email'=>$email]);
			if($s->rowCount()>0){
				$ru=$s->fetch(PDO::FETCH_ASSOC);
				if($ru['status']=='delete'||$ru['status']=='disabled')
					$notification.=preg_replace(['/<print alert>/','/<print text>/'],['danger','The account associated with the details provided has been suspended, or the email supplied is invalid.'],$theme['settings']['alert']);
				else
					$uid=$ru['id'];
			}else{
				$name=filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW);
				$business=filter_input(INPUT_POST,'business',FILTER_UNSAFE_RAW);
				$address=filter_input(INPUT_POST,'address',FILTER_UNSAFE_RAW);
				$suburb=filter_input(INPUT_POST,'suburb',FILTER_UNSAFE_RAW);
				$city=filter_input(INPUT_POST,'city',FILTER_UNSAFE_RAW);
				$state=filter_input(INPUT_POST,'state',FILTER_UNSAFE_RAW);
				$postcode=filter_input(INPUT_POST,'postcode',FILTER_UNSAFE_RAW);
				$country=filter_input(INPUT_POST,'country',FILTER_UNSAFE_RAW);
				$phone=filter_input(INPUT_POST,'phone',FILTER_UNSAFE_RAW);
				$username=explode('@',$email);
				$q=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`username`,`password`,`email`,`name`,`business`,`address`,`suburb`,`city`,`state`,`postcode`,`country`,`phone`,`status`,`active`,`language`,`timezone`,`rank`,`ti`) VALUES (:username,:password,:email,:name,:business,:address,:suburb,:city,:state,:postcode,:country,:phone,'','1',:language,'default','200',:ti)");
				$chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    	$pass=substr(str_shuffle($chars),0,8);
				$password=password_hash($pass,PASSWORD_DEFAULT);
				$q->execute([
					':username'=>$username[0],
					':password'=>$password,
					':email'=>$email,
					':name'=>$name,
					':business'=>$business,
					':address'=>$address,
					':suburb'=>$suburb,
					':city'=>$city,
					':state'=>$state,
					':postcode'=>$postcode,
					':country'=>$country,
					':phone'=>$phone,
					':language'=>$config['language'],
					':ti'=>$ti
				]);
				$uid=$db->lastInsertId();
				$q=$db->prepare("UPDATE `".$prefix."login` SET `username`=:username WHERE `id`=:id");
				$q->execute([
					':id'=>$uid,
					':username'=>$username[0].$uid
				]);
				if($email!=''&&$config['options'][3]==1){
					$name=$name!=''?$name:$business;
					$mail = new PHPMailer\PHPMailer\PHPMailer;
					$mail->isSendmail();
					$mail->SetFrom($config['email'],$config['business']);
					$mail->AddAddress($email,$name);
					$mail->IsHTML(true);
					$mail->Subject='Order at '.$config['business'];
					$msg='Thank you for placing an Order at '.$config['business'].'<br />You can view your order after logging in using the below credentials.<br />Username: '.$username[0].$uid.'<br />Password: '.$pass.'<br />We suggest changing this once you log in to something you will more easily remember.';
					$mail->Body=$msg;
					$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
					if($mail->Send()){}
				}
			}
			$r=$db->query("SELECT MAX(`id`) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
			$sr=$db->prepare("SELECT `id`,`quantity`,`tis`,`tie` FROM `".$prefix."rewards` WHERE `code`=:code");
			$sr->execute([':code'=>$rewards]);
			if($sr->rowCount()>0){
				$reward=$sr->fetch(PDO::FETCH_ASSOC);
				if(!$reward['tis']>$ti&&!$reward['tie']<$ti)$rewards['id']=0;
				if($reward['quantity']<1)
					$reward['id']=0;
				else{
					$sr=$db->prepare("UPDATE `".$prefix."rewards` SET `quantity`=:quantity WHERE `code`=:code");
					$sr->execute([
						':quantity'=>$rewards['quantity']-1,
						':code'=>$rewards
					]);
				}
			}else$reward['id']=0;
			$dti=$ti+$config['orderPayti'];
			$qid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
			$q=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`cid`,`uid`,`qid`,`qid_ti`,`due_ti`,`rid`,`status`,`postageCode`,`postageOption`,`payOption`,`payMethod`,`payCost`,`process`,`hold`,`hold_event`,`ti`) VALUES (:cid,:uid,:qid,:qid_ti,:due_ti,:rid,'pending',:postagecode,:postageoption,:payoption,:paymethod,:paycost,:process,:hold,:hid,:ti)");
			$q->execute([
				':cid'=>$uid,
				':uid'=>(isset($uid)?$uid:0),
				':qid'=>$qid,
				':qid_ti'=>$ti,
				':due_ti'=>$dti,
				':rid'=>$reward['id'],
				':postagecode'=>$po['id'],
				':postageoption'=>$postoption,
				':payoption'=>$po['title'],
				':paymethod'=>$po['type'],
				':paycost'=>$po['value'],
				':process'=>'1000000000000000',
				':hold'=>($hid>0?1:0),
				':hid'=>($hid>0?$hid:''),
				':ti'=>$ti
			]);
			$oid=$db->lastInsertId();
			$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si");
			$s->execute([':si'=>SESSIONID]);
			$total=0;
			while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([':id'=>$r['iid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$quantity=$i['quantity']-$r['quantity'];
				$sold=$i['quantity']+$r['quantity'];
				$gst=0;
				if($i['status']!='pre order'||$i['status']!='back order'){
					if($config['gst']>0){
						$gst=$i['cost']*($config['gst']/100);
						if($i['quantity']>1)
							$gst=$gst*$r['quantity'];
						$gst=number_format((float)$gst, 2, '.', '');
					}
				}
				if($i['status']!='pre order'||$i['status']!='back order')
	        $total=$total+($r['cost']*$r['quantity'])+$gst;
				$qry=$db->prepare("UPDATE `".$prefix."content` SET `quantity`=:quantity,`sold`=:sold WHERE `id`=:id");
				$qry->execute([
					':quantity'=>$quantity<1?0:$quantity,
					':sold'=>$sold,
					':id'=>$r['iid']
				]);
				$sq=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`cid`,`contentType`,`title`,`file`,`quantity`,`cost`,`status`,`points`,`ti`) VALUES (:oid,:iid,:cid,:contentType,:title,:file,:quantity,:cost,:status,:points,:ti)");
				$sq->execute([
					':oid'=>$oid,
					':iid'=>$r['iid'],
					':cid'=>$r['cid'],
					':contentType'=>$r['contentType'],
					':title'=>$r['title'],
					':file'=>$r['file'],
					':quantity'=>$r['quantity'],
					':cost'=>$r['cost'],
					':status'=>$r['stockStatus'],
					':points'=>$r['points'],
					':ti'=>$ti
				]);
			}
			$q=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE `id`=:id");
			$q->execute([
				':id'=>$oid,
				':total'=>$total
			]);
			$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE `si`=:si");
			$q->execute([':si'=>SESSIONID]);
			$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
			if($config['email']!=''){
				$mail = new PHPMailer\PHPMailer\PHPMailer;
				$mail->isSendmail();
				$mail->SetFrom($config['email'],$config['business']);
				$mail->AddAddress($config['email']);
				$mail->IsHTML(true);
				$mail->Subject='New Order was Created at '.$config['business'];
				$msg='New Order was Created at '.$config['business'].'<br />'.'Order #'.$qid;
				$mail->Body=$msg;
				$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));;
				if($mail->Send()){}
			}
			if($hid>0){
				$sh=$db->prepare("SELECT `title`,`value` FROM `".$prefix."choices` WHERE `id`=:id");
				$sh->execute([':id'=>$hid]);
				$rh=$sh->fetch(PDO::FETCH_ASSOC);
			}
			$notification.=preg_replace([
				'/<print alert>/',
				'/<print text>/'
			],[
				'success',
				'Thank you for placing an Order.<br>Once payment is made, you will receive an invoice, containing links to content associated with your purchase.<br><br>'.
					(isset($qid)&&$qid!=0?'You can use this link to view your order:<br><a href="'.URL.'orders/'.$qid.'">Order #'.$qid.'</a><br><br>':'').
					($hid>0?'Your Order has be flagged as being Held for Pickup at '.$rh['title'].'.'.($rh['value']>0?' '.$rh['value'].'% payment is Required to Hold Orders.':'').'<br><br>':'').
					'<a class="btn" href="'.URL.'checkout/'.$qid.'">Proceed to Checkout</a>'
			],$theme['settings']['alert']);
		}else
			$notification.=preg_replace(['/<print alert>/','/<print text>/'],['danger','The account associated with the details provided has been suspended, or the email supplied is invalid.'],$theme['settings']['alert']);
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$notification,$html,1);
	}else
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is','',$html,1);
}else{
	$total=0;
	if(stristr($html,'<items')){
		$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si ORDER BY `ti` DESC");
		$s->execute([':si'=>SESSIONID]);
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
		$cartloop=$matches[1];
		$cartitems='';
		$zebra=1;
		if($s->rowCount()>0){
			$totalWeight=$weight=$dimW=$dimL=$dimH=0;
			while($ci=$s->fetch(PDO::FETCH_ASSOC)){
				$cartitem=$cartloop;
				$si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([':id'=>$ci['iid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
				$sc->execute([':id'=>$ci['cid']]);
				$c=$sc->fetch(PDO::FETCH_ASSOC);
				$gst=0;
				if($config['gst']>0){
					$gst=$ci['cost']*($config['gst']/100);
					$gst=$gst*$ci['quantity'];
					$gst=number_format((float)$gst,2,'.','');
				}
				$total=$total+($ci['cost']*$ci['quantity'])+$gst;
				$itemtotal=($ci['cost']*$ci['quantity'])+$gst;
				$total=number_format((float)$total,2,'.','');
				$cartitem=preg_replace([
					'/<print zebra>/',
					'/<print carturl>/',
					'/<print content=[\"\']?id[\"\']?>/',
					'/<print content=[\"\']?image[\"\']?>/',
					'/<print content=[\"\']?code[\"\']?>/',
					'/<print content=[\"\']?title[\"\']?>/',
					'/<print content=[\"\']?weight[\"\']?>/',
					'/<print content=[\"\']?dimensions[\"\']?>/',
					'/<print choice>/',
					'/<print cart=[\"\']?id[\"\']?>/',
					'/<print cart=[\"\']?cost[\"\']?>/',
					'/<print cart=[\"\']?quantity[\"\']?>/',
					'/<print cart=[\"\']?gst[\"\']?>/',
					'/<print itemscalculate>/'
				],[
					'zebra'.$zebra,
					URL.'cart',
					$i['id'],
					($i['file']!=''?$i['file']:NOIMAGE),
					($i['code']!=''?$i['code']:''),
					$i['title'],
					$i['weight']>0?'Weight: '.$i['weight'].$i['weightunit'].'<br>':'',
					($i['width']>0||$i['length']>0||$i['height']>0?'Dimensions:'.
						($i['width']>0?' W:'.$i['width'].$i['widthunit']:'').
						($i['length']>0?' L:'.$i['length'].$i['lengthunit']:'').
						($i['height']>0?' H:'.$i['height'].$i['heightunit']:'')
					:''),
					($i['id']==$ci['id']?$ci['title']:''),
					$ci['id'],
					number_format((float)$ci['cost'],2,'.',''),
					$ci['quantity'],
					$gst,
					number_format((float)$itemtotal,2,'.','')
				],$cartitem);
				$cartitems.=$cartitem;
				if($i['weightunit']!='kg')$i['weight']=weight_converter($i['weight'],$i['weightunit'],'kg');
				$weight=$weight + (is_numeric($i['weight'])?$i['weight'] * $ci['quantity']:0);
				if($i['widthunit']!='cm')$i['width']=length_converter($i['width'],$i['widthunit'],'cm');
				if($i['lengthunit']!='cm')$i['length']=length_converter($i['length'],$i['lengthunit'],'cm');
				if($i['heightunit']!='cm')$i['height']=length_converter($i['height'],$i['heightunit'],'cm');
				if($i['width']>$dimW)$dimW=$i['width'];
				if($i['length']>$dimL)$dimL=$i['length'];
				$dimH=$dimH+($i['height']*$ci['quantity']);
				$zebra=$zebra==2?$zebra=1:$zebra=2;
			}
			$html=preg_replace([
				'~<items>.*?<\/items>~is',
				'/<print dimensions>/',
				'/<print weight>/',
				'/<print totalcalculate>/'
			],[
		 		$cartitems,
				($dimW>0||$dimL>0||$dimH>0?'Estimated Dimensions:'.
					($dimW>0?' W: '.$dimW.'cm':'').
					($dimL>0?' L: '.$dimL.'cm':'').
					($dimH>0?' H: '.$dimH.'cm':'')
				:''),
				($weight>0?'Total Weight: '.$weight.'kg'.($weight>22?'<br><div class="alert alert-danger">As the weight of your items exceeds 22kg you will not be able to use Australia Post.</div>':''):''),
				$total
			],$html);

			$suser=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
			$suser->execute([':id'=>$uid]);
			$ruser=$suser->fetch(PDO::FETCH_ASSOC);
			if(($config['options'][30]==1&&$ruser['rank']<310)&&($ruser['address']==''||$ruser['city']==''||$ruser['suburb']==''||$ruser['country']==''||$ruser['state']==''||$ruser['postcode']==0)){
				$html=preg_replace([
					'~<noaddress>.*?<\/noaddress>~is',
					'/<[\/]?emptycart>/'
				],[
					'<a class="btn btn-block" href="'.URL.'settings#address">Please Update your Address details for Shipping.</a>',
					''
				],$html);
			}else{
				if(isset($user['rank'])&&$user['rank']>300&&$user['rank']<400){
					$html=preg_replace([
						'~<postageoptions>.*?<\/postageoptions>~is',
						'/<[\/]?emptycart>/',
						'/<[\/]?noaddress>/'
					],[
						'<input type="hidden" name="payoption" value="0">',
						'',
						''
					],
						$html);
				}else{
					$spo=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' ORDER BY `title` ASC");
					$spo->execute();
					$postageoptions='';
//					$postageoptions='<option value="AUS_PARCEL_REGULAR">Australia Post Regular Post</option>'. // AUS_PARCEL_REGULAR
//						'<option value="AUS_PARCEL_EXPRESS">Australia Post Express Post</option>'; // AUS_PARCEL_EXPRESS
					if($spo->rowCount()>0){
						while($rpo=$spo->fetch(PDO::FETCH_ASSOC))$postageoptions.='<option value="'.$rpo['id'].'">'.htmlspecialchars($rpo['title'],ENT_QUOTES,'UTF-8').'</option>';
					}
					$sco=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='payoption' ORDER BY `title` ASC");
					$sco->execute();
					$payoptions='';
					if($sco->rowCount()>0){
						$payoptions.='<option value="0">Select an Option</option>';
						while($rco=$sco->fetch(PDO::FETCH_ASSOC)){
							$payoptions.='<option value="'.$rco['id'].'">'.htmlspecialchars($rco['title'],ENT_QUOTES,'UTF-8').($rco['type']!=0&&$rco['value']!=0?($rco['type']==1?' (Surcharge of '.$rco['value'].'&#37;)':' (Surcharge of &#36;'.$rco['value'].')'):'').'</option>';
						}
					}
					$html=preg_replace([
						$sco->rowCount()>0?'/<[\/]?paymentoptions>/':'~<paymentoptions>.*?<\/paymentoptions>~is',
						$spo->rowCount()>0?'/<[\/]?postageoptions>/':'~<postageoptions>.*?<\/postageoptions>~is',
						'/<postoptions>/',
						'/<payoptions>/',
						'/<[\/]?emptycart>/',
						'/<[\/]?noaddress>/'
					],[
						$sco->rowCount()>0?'':'<input type="hidden" name="payoption" value="0">',
						$spo->rowCount()>0?'':'<input type="hidden" name="postoption" value="0">',
						$postageoptions,
						$payoptions,
						'',
						''
					],$html);

					$sh=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='holdoption' ORDER BY `title` ASC");
					$sh->execute();
					$opts='';
					while($rh=$sh->fetch(PDO::FETCH_ASSOC)){
						if($rh['tie']!=0&&$rh['tie']<$ti)continue;
						$opts.='<option value="'.$rh['id'].'">'.ucwords($rh['title']).'.'.($rh['value']>0?' '.$rh['value'].'% Required to Hold Order':'').'</option>';
					}
					$html=preg_replace([
						($opts!=''?'/<[\/]?holdingoptions>/':'~<holdingoptions>.*?<\/holdingoptions>~is'),
						'/<holdoptions>/'
					],[
						'',
						$opts
					],$html);
				}
				if(isset($user['rank'])){
					$us=$db->prepare("SELECT `email` FROM `".$prefix."login` WHERE `id`=:id");
					$us->execute([':id'=>$uid]);
					$u=$us->fetch(PDO::FETCH_ASSOC);
				}
				$html=preg_replace([
					($overquantity==true?'/<[\/]?overquantity>/':'~<overquantity>.*?<\/overquantity>~is'),
					isset($user['rank'])&&$user['rank']>0?'~<loggedin>.*?<\/loggedin>~is':'/<[\/]?loggedin>/',
				],[
					'',
					isset($u['email'])&&$u['email']!=''?'<input type="hidden" name="email" value="'.$u['email'].'">':'',
				],$html);
			}
		}else
			$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$theme['settings']['cart_empty'],$html,1);
	}
}
$content.=$html;
