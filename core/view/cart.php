<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Cart
 * @package    core/view/cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/sanitize/HTMLPurifier.php';
$purify=new HTMLPurifier(HTMLPurifier_Config::createDefault());
require'core/puconverter.php';
require'core/phpmailer/class.phpmailer.php';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$hash=md5($ip);
$html=preg_replace([
	'/<print page=[\"\']?heading[\"\']?>/',
	'/<print page=[\"\']?notes[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is'
],[
	htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
	$purify->purify($page['notes']),
	''
],$html);
$notification='';
$ti=time();
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
		    if($rank==210)$limit=$config['memberLimitSilver'];
		    if($rank==220)$limit=$config['memberLimitBronze'];
		    if($rank==230)$limit=$config['memberLimitGold'];
		    if($rank==240)$limit=$config['memberLimitPlatinum'];
		    if($rank==310)$limit=$config['wholesaleLimitSilver'];
		    if($rank==320)$limit=$config['wholesaleLimitBronze'];
		    if($rank==330)$limit=$config['wholesaleLimitGold'];
		    if($rank==340)$limit=$config['wholesaleLimitPlatinum'];
		  }
		  if($limit>0){
		    if($qty > $limit)$qty=$limit;
		  }
		}
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
		$rewards=filter_input(INPUT_POST,'rewards',FILTER_SANITIZE_STRING);
		$pid=filter_input(INPUT_POST,'pid',FILTER_SANITIZE_STRING);
		$postoption='';
		if($pid=='AUS_PARCEL_REGULAR')$postoption='Australia Post Regular Post'; // AUS_PARCEL_REGULAR
		if($pid=='AUS_PARCEL_EXPRESS')$postoption='Australia Post Express Post'; // AUS_PARCEL_EXPRESS
		$payoption=filter_input(INPUT_POST,'payoption',FILTER_SANITIZE_STRING);
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
			$s=$db->prepare("SELECT `id`,`status` FROM `".$prefix."login` WHERE `email`=:email");
			$s->execute([':email'=>$email]);
			if($s->rowCount()>0){
				$ru=$s->fetch(PDO::FETCH_ASSOC);
				if($ru['status']=='delete'||$ru['status']=='disabled')
					$notification.=preg_replace(['/<print alert>/','/<print text>/'],['danger','The account associated with the details provided has been suspended, or the email supplied is invalid.'],$theme['settings']['alert']);
				else
					$uid=$ru['id'];
			}else{
				$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
				$business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
				$address=filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
				$suburb=filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_STRING);
				$city=filter_input(INPUT_POST,'city',FILTER_SANITIZE_STRING);
				$state=filter_input(INPUT_POST,'state',FILTER_SANITIZE_STRING);
				$postcode=filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING);
				$country=filter_input(INPUT_POST,'country',FILTER_SANITIZE_STRING);
				$phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
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
				if($email!=''){
					$name=$name!=''?$name:$business;
					$mail=new PHPMailer;
					$mail->isSendmail();
					$mail->SetFrom($config['email'],$config['business']);
					$mail->AddAddress($email,$name);
					$mail->IsHTML(true);
					$mail->Subject='Order at '.$config['business'];
					$msg='Thank you for placing an Order at '.$config['business'].'<br />You can view your order after logging in using the below credentials.<br />Username: '.$username[0].$uid.'<br />Password: '.$pass.'<br />We suggest changing this once you log in to something you will more easily remember.';
					$mail->Body=$msg;
					$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));;
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
			$q=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`cid`,`uid`,`qid`,`qid_ti`,`due_ti`,`rid`,`status`,`postageCode`,`postageOption`,`payOption`,`payMethod`,`payCost`,`ti`) VALUES (:cid,:uid,:qid,:qid_ti,:due_ti,:rid,'pending',:postagecode,:postageoption,:payoption,:paymethod,:paycost,:ti)");
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
				':ti'=>$ti
			]);
			$oid=$db->lastInsertId();
			$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si");
			$s->execute([':si'=>SESSIONID]);
			while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$si=$db->prepare("SELECT `title`,`quantity`,`sold`,`points` FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([':id'=>$r['iid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$quantity=$i['quantity']-$r['quantity'];
				$sold=$i['quantity']+$r['quantity'];
				$qry=$db->prepare("UPDATE `".$prefix."content` SET `quantity`=:quantity,`sold`=:sold WHERE `id`=:id");
				$qry->execute([
					':quantity'=>$quantity<1?0:$quantity,
					':sold'=>$sold,
					':id'=>$r['iid']
				]);
				$sq=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`cid`,`title`,`quantity`,`cost`,`status`,`points`,`ti`) VALUES (:oid,:iid,:cid,:title,:quantity,:cost,:status,:points,:ti)");
				$sq->execute([
					':oid'=>$oid,
					':iid'=>$r['iid'],
					':cid'=>$r['cid'],
					':title'=>$i['title'],
					':quantity'=>$r['quantity'],
					':cost'=>$r['cost'],
					':status'=>$r['stockStatus'],
					':points'=>$r['points'],
					':ti'=>$ti
				]);
			}
			$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE `si`=:si");
			$q->execute([':si'=>SESSIONID]);
			$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
			if($config['email']!=''){
				$mail=new PHPMailer;
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
			$notification.=preg_replace(['/<print alert/','/<print text>/'],['success','Thank you for placing an Order, a representative will process your order as soon as humanly possible'],$theme['settings']['alert']);
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
				$image=NOIMAGE;
				$c=$sc->fetch(PDO::FETCH_ASSOC);
				if($i['thumb']!=''&&file_exists('media/thumbs/'.basename(strtolower($i['thumb']))))
					$image='media/thumbs/'.basename(strtolower($i['thumb']));
				elseif($i['fileURL']!='')
					$image=$i['fileURL'];
				elseif($i['file']!=''&&file_exists('media/'.basename($i['file'])))
					$image='media/'.basename($i['file']);
				else
					$image=NOIMAGE;
				$gst=0;
				if($config['gst']>0){
					$gst=$ci['cost']*($config['gst']/100);
					$gst=$gst*$ci['quantity'];
					$gst=number_format((float)$gst,2,'.','');
				}
				$total=$total+($ci['cost']*$ci['quantity'])+$gst;
				$total=number_format((float)$total,2,'.','');
				$cartitem=preg_replace([
					'/<print zebra>/',
					'/<print carturl>/',
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
					$image,
					htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
					($i['code']!=''?' : ':'').htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
					$i['weight'].$i['weightunit'],
					'W:'.$i['width'].$i['widthunit'].' x L:'.$i['length'].$i['lengthunit'].' H:'.$i['height'].$i['heightunit'],
					isset($c['title'])&&$c['title']!=''?' : '.htmlspecialchars($c['title'],ENT_QUOTES,'UTF-8'):'',
					$ci['id'],
					$ci['cost'],
					$ci['quantity'],
					$gst,
					$total
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
				'W: '.$dimW.'cm X L: '.$dimL.'cm X H: '.$dimH.'cm',
				$weight.'kg'.($weight>22?'<br><div class="alert alert-danger">As the weight of your items exceeds 22kg you will not be able to use Australia Post.</div>':''),
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
				if($user['rank']>300&&$user['rank']<400){
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
					$sco=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' ORDER BY `title` ASC");
					$sco->execute();
					$postageoptions='<option value="AUS_PARCEL_REGULAR">Australia Post Regular Post</option>'. // AUS_PARCEL_REGULAR
													'<option value="AUS_PARCEL_EXPRESS">Australia Post Express Post</option>'; // AUS_PARCEL_EXPRESS
					if($sco->rowCount()>0){
						while($rco=$sco->fetch(PDO::FETCH_ASSOC))$postageoptions.='<option value="'.$rco['id'].'">'.htmlspecialchars($rco['title'],ENT_QUOTES,'UTF-8').'</option>';
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
						'/<postoptions>/',
						'/<[\/]?postageoptions>/',
						'/<payoptions>/',
						'/<[\/]?emptycart>/'
					],[
						$sco->rowCount()>0?'':'<input type="hidden" name="payoption" value="0">',
						$postageoptions,
						'',
						$payoptions,
						''
					],$html);
				}
				if(isset($user['rank'])){
					$us=$db->prepare("SELECT `email` FROM `".$prefix."login` WHERE `id`=:id");
					$us->execute([':id'=>$uid]);
					$u=$us->fetch(PDO::FETCH_ASSOC);
				}
				$html=preg_replace(
					isset($user['rank'])&&$user['rank']>0?'~<loggedin>.*?<\/loggedin>~is':'/<[\/]?loggedin>/',
					isset($u['email'])&&$u['email']!=''?'<input type="hidden" name="email" value="'.$u['email'].'">':'',
				$html);
			}
		}else
			$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$theme['settings']['cart_empty'],$html,1);
	}
}
$content.=$html;
