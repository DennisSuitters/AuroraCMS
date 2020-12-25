<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Cart
 * @package    core/view/cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$theme=parse_ini_file(THEME.'/theme.ini',true);
require'core/puconverter.php';
require'core/phpmailer/class.phpmailer.php';
$html=preg_replace([
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
	'/<print page=[\"\']?notes[\"\']?>/'
],[
	'',
	rawurldecode($page['notes'])
],$html);
$notification='';
$ti=time();
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if(isset($_POST['qid'])&&isset($_POST['qty'])){
	$qid=filter_input(INPUT_POST,'qid',FILTER_SANITIZE_NUMBER_INT);
	$qty=filter_input(INPUT_POST,'qty',FILTER_SANITIZE_NUMBER_INT);
	if($qty==0){
		$s=$db->prepare("DELETE FROM `".$prefix."cart` WHERE `id`=:id");
		$s->execute([
			':id'=>$qid
		]);
	}
	if($qty>0){
		$s=$db->prepare("UPDATE `".$prefix."cart` SET `quantity`=:quantity WHERE `id`=:id");
		$s->execute([
			':quantity'=>$qty,
			':id'=>$qid
		]);
	}
}
if($args[0]=='confirm'){
	if($_POST['emailtrap']=='none'){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$rewards=filter_input(INPUT_POST,'rewards',FILTER_SANITIZE_STRING);
		$postoption=filter_input(INPUT_POST,'postoption',FILTER_SANITIZE_STRING);
		$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$s=$db->prepare("SELECT `id`,`status` FROM `".$prefix."login` WHERE `email`=:email");
			$s->execute([
				':email'=>$email
			]);
			if($s->rowCount()>0){
				$ru=$s->fetch(PDO::FETCH_ASSOC);
				if($ru['status']=='delete'||$ru['status']=='disabled')
					$notification.=$theme['settings']['account_suspend'];
				else
					$uid=$ru['id'];
			}else{
				$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING):'';
				$business=isset($_POST['business'])?filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING):'';
				$address=isset($_POST['address'])?filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING):'';
				$suburb=isset($_POST['suburb'])?filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_STRING):'';
				$city=isset($_POST['city'])?filter_input(INPUT_POST,'city',FILTER_SANITIZE_STRING):'';
				$state=isset($_POST['state'])?filter_input(INPUT_POST,'state',FILTER_SANITIZE_STRING):'';
				$postcode=isset($_POST['postcode'])?filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING):'';
				$country=isset($_POST['country'])?filter_input(INPUT_POST,'country',FILTER_SANITIZE_STRING):'';
				$phone=isset($_POST['phone'])?filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING):'';
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
			$sr->execute([
				':code'=>$rewards
			]);
			if($sr->rowCount()>0){
				$reward=$sr->fetch(PDO::FETCH_ASSOC);
				if(!$reward['tis']>$ti&&!$reward['tie']<$ti)
					$rewards['id']=0;
				if($reward['quantity']<1)
					$reward['id']=0;
				else{
					$sr=$db->prepare("UPDATE `".$prefix."rewards` SET `quantity`=:quantity WHERE `code`=:code");
					$sr->execute([
						':quantity'=>$rewards['quantity']-1,
						':code'=>$rewards
					]);
				}
			}else
				$reward['id']=0;
			$dti=$ti+$config['orderPayti'];
			$qid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
			$q=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`cid`,`uid`,`qid`,`qid_ti`,`due_ti`,`rid`,`status`,`postOption`,`ti`) VALUES (:cid,:uid,:qid,:qid_ti,:due_ti,:rid,'pending',:postoption,:ti)");
			$q->execute([
				':cid'=>$uid,
				':uid'=>(isset($uid)?$uid:0),
				':qid'=>$qid,
				':qid_ti'=>$ti,
				':due_ti'=>$dti,
				':rid'=>$reward['id'],
				':postoption'=>$postoption,
				':ti'=>$ti
			]);
			$oid=$db->lastInsertId();
			$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si");
			$s->execute([
				':si'=>SESSIONID
			]);
			while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$si=$db->prepare("SELECT `title`,`quantity`,`sold` FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([
					':id'=>$r['iid']
				]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$quantity=$i['quantity']-$r['quantity'];
				$sold=$i['quantity']+$r['quantity'];
				$qry=$db->prepare("UPDATE `".$prefix."content` SET `quantity`=:quantity,`sold`=:sold WHERE `id`=:id");
				$qry->execute([
					':quantity'=>$quantity,
					':sold'=>$sold,
					':id'=>$r['iid']
				]);
				$sq=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`cid`,`title`,`quantity`,`cost`,`ti`) VALUES (:oid,:iid,:cid,:title,:quantity,:cost,:ti)");
				$sq->execute([
					':oid'=>$oid,
					':iid'=>$r['iid'],
					':cid'=>$r['cid'],
					':title'=>$i['title'],
					':quantity'=>$r['quantity'],
					':cost'=>$r['cost'],
					':ti'=>$ti
				]);
			}
			$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE `si`=:si");
			$q->execute([
				':si'=>SESSIONID
			]);
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
			$notification.=$theme['settings']['cart_success'];
		}else
			$notification.=$theme['settings']['cart_suspend'];
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$notification,$html,1);
	}else
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is','',$html,1);
}else{
	$total=0;
	if(stristr($html,'<items')){
		$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si ORDER BY `ti` DESC");
		$s->execute([
			':si'=>SESSIONID
		]);
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
		$cartloop=$matches[1];
		$cartitems='';
		$zebra=1;
		if($s->rowCount()>0){
			$totalWeight=$weight=$dimW=$dimL=$dimH=0;
			while($ci=$s->fetch(PDO::FETCH_ASSOC)){
				$cartitem=$cartloop;
				$si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([
					':id'=>$ci['iid']
				]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
				$sc->execute([
					':id'=>$ci['cid']
				]);
				$c=$sc->fetch(PDO::FETCH_ASSOC);
				if($i['thumb']!='')
					$image=$i['thumb'];
				elseif($i['fileURL']!='')
					$image=$i['fileURL'];
				elseif($i['file']!='')
					$image=$i['file'];
				else
					$image=NOIMAGE;
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
					'/<print cart=[\"\']?quantity[\"\']?>/',
					'/<print cart=[\"\']?cost[\"\']?>/',
					'/<print itemscalculate>/'
				],[
					'zebra'.$zebra,
					URL.'cart',
					$image,
					htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
					($i['code']!=''?' : ':'').htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
					$i['weight'].$i['weightunit'],
					'W:'.$i['width'].$i['widthunit'].' x L:'.$i['length'].$i['lengthunit'].' H:'.$i['height'].$i['heightunit'],
					$c['title']!=''?' : '.$c['title']:'',
					$ci['id'],
					htmlspecialchars($ci['quantity'],ENT_QUOTES,'UTF-8'),
					$ci['cost'],
					$ci['cost']*$ci['quantity']
				],$cartitem);
				$total=$total+($ci['cost']*$ci['quantity']);
				$cartitems.=$cartitem;
				if($i['weightunit']!='kg')
					$i['weight']=weight_converter($i['weight'],$i['weightunit'],'kg');
				$weight=$weight+($i['weight']*$ci['quantity']);
				if($i['widthunit']!='cm')
					$i['width']=length_converter($i['width'],$i['widthunit'],'cm');
				if($i['lengthunit']!='cm')
					$i['length']=length_converter($i['length'],$i['lengthunit'],'cm');
				if($i['heightunit']!='cm')
					$i['height']=length_converter($i['height'],$i['heightunit'],'cm');
				if($i['width']>$dimW)
					$dimW=$i['width'];
				if($i['length']>$dimL)
					$dimL=$i['length'];
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
			$sco=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' ORDER BY `title` ASC");
			$sco->execute();
			$option='<option value="1000">Australia Post Regular Post</option>'. // AUS_PARCEL_REGULAR
							'<option value="1001">Australia Post Express Post</option>'; // AUS_PARCEL_EXPRESS
			if($sco->rowCount()>0){
				while($rco=$sco->fetch(PDO::FETCH_ASSOC))$option.='<option value="'.$rco['id'].'">'.$rco['title'].'</option>';
			}
			$html=preg_replace([
				'/<postoptions>/',
				'/<[\/]?postageoptions>/',
				'/<[\/]?emptycart>/'
			],[
				$option,
				'',
				''
			],$html);
			$html=preg_replace(isset($user['rank'])&&$user['rank']>0?'~<loggedin>.*?<\/loggedin>~is':'/<[\/]?loggedin>/','',$html);
		}else
			$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$theme['settings']['cart_empty'],$html,1);
	}
}
$content.=$html;
