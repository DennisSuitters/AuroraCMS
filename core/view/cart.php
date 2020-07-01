<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Cart
 * @package    core/view/cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.16
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Add Page Editing.
 * @changes    v0.0.15 Fix creating new accounts and sending new account details.
 * @changes    v0.0.16 Reduce preg_replace parsing strings.
 * @changes    v0.0.16 Add sold calculation and database update.
 */
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
require'core'.DS.'class.phpmailer.php';
if($page['notes']!=''){
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<[\/]?pagenotes>/'
	],[
		rawurldecode($page['notes']),
		''
	],$html);
}else$html=preg_replace('~<pagenotes>.*?<\/pagenotes>~is','',$html,1);
$notification='';
$ti=time();
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if($args[0]=='confirm'){
	if($_POST['emailtrap']=='none'){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$rewards=filter_input(INPUT_POST,'rewards',FILTER_SANITIZE_STRING);
		$po=filter_input(INPUT_POST,'postoption',FILTER_SANITIZE_STRING);
		$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$s=$db->prepare("SELECT id,status FROM `".$prefix."login` WHERE email=:email");
			$s->execute([':email'=>$email]);
			if($s->rowCount()>0){
				$ru=$s->fetch(PDO::FETCH_ASSOC);
				if($ru['status']=='delete'||$ru['status']=='disabled')$notification.=$theme['settings']['account_suspend'];
				else$uid=$ru['id'];
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
				$q=$db->prepare("INSERT INTO `".$prefix."login` (username,password,email,name,business,address,suburb,city,state,postcode,country,phone,status,active,language,timezone,rank,ti) VALUES (:username,:password,:email,:name,:business,:address,:suburb,:city,:state,:postcode,:country,:phone,'','1',:language,'default','200',:ti)");
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
				$q=$db->prepare("UPDATE `".$prefix."login` SET username=:username WHERE id=:id");
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
			$r=$db->query("SELECT MAX(id) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
			$sr=$db->prepare("SELECT id,quantity,tis,tie FROM `".$prefix."rewards` WHERE code=:code");
			$sr->execute([':code'=>$rewards]);
			if($sr->rowCount()>0){
				$reward=$sr->fetch(PDO::FETCH_ASSOC);
				if(!$reward['tis']>$ti&&!$reward['tie']<$ti)$rewards['id']=0;
				if($reward['quantity']<1)$reward['id']=0;
				else{
					$sr=$db->prepare("UPDATE `".$prefix."rewards` SET quantity=:quantity WHERE code=:code");
					$sr->execute([
						':quantity'=>$rewards['quantity']-1,
						':code'=>$rewards
					]);
				}
			}else$reward['id']=0;
			$dti=$ti+$config['orderPayti'];
			$qid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
			$postOption='';
			$postCost=0;
			if($po!=0){
				$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
				$sc->execute([':id'=>$po]);
				$rc=$sc->fetch(PDO::FETCH_ASSOC);
				$postOption=$rc['title'];
				$postCost=$rc['value'];
			}
			$q=$db->prepare("INSERT INTO `".$prefix."orders` (cid,uid,qid,qid_ti,due_ti,postageOption,postageCost,rid,status,ti) VALUES (:cid,:uid,:qid,:qid_ti,:due_ti,:postageOption,:postageCost,:rid,'pending',:ti)");
			$q->execute([
				':cid'=>$uid,
				':uid'=>(isset($uid)?$uid:0),
				':qid'=>$qid,
				':qid_ti'=>$ti,
				':due_ti'=>$dti,
				':postageOption'=>$postOption,
				':postageCost'=>$postCost,
				':rid'=>$reward['id'],
				':ti'=>$ti
			]);
			$oid=$db->lastInsertId();
			$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE si=:si");
			$s->execute([':si'=>SESSIONID]);
			while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$si=$db->prepare("SELECT title,quantity,sold FROM `".$prefix."content` WHERE id=:id");
				$si->execute([':id'=>$r['iid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$quantity=$i['quantity']-$r['quantity'];
				$sold=$i['quantity']+$r['quantity'];
				$qry=$db->prepare("UPDATE `".$prefix."content` SET quantity=:quantity, sold=:sold WHERE id=:id");
				$qry->execute([
					':quantity'=>$quantity,
					':sold'=>$sold,
					':id'=>$r['iid']
				]);
				$sq=$db->prepare("INSERT INTO `".$prefix."orderitems` (oid,iid,cid,title,quantity,cost,ti) VALUES (:oid,:iid,:cid,:title,:quantity,:cost,:ti)");
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
			$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE si=:si");
			$q->execute([':si'=>SESSIONID]);
			$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
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
		}else$notification.=$theme['settings']['cart_suspend'];
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$notification,$html,1);
	}else$html=preg_replace('~<emptycart>.*?<\/emptycart>~is','',$html,1);
}else{
	$total=0;
	if(stristr($html,'<items')){
		$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE si=:si ORDER BY ti DESC");
		$s->execute([':si'=>SESSIONID]);
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
		$cartloop=$matches[1];
		$cartitems='';
		if($s->rowCount()>0){
			while($ci=$s->fetch(PDO::FETCH_ASSOC)){
				$cartitem=$cartloop;
				$si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
				$si->execute([':id'=>$ci['iid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
				$sc->execute([':id'=>$ci['cid']]);
				$c=$sc->fetch(PDO::FETCH_ASSOC);
				if($i['thumb']!='')$image=$i['thumb'];
				elseif($i['fileURL']!='')$image=$i['fileURL'];
				elseif($i['file']!='')$image=$i['file'];
				else$image=NOIMAGE;
				$cartitem=preg_replace([
					'/<print content=[\"\']?image[\"\']?>/',
					'/<print content=[\"\']?code[\"\']?>/',
					'/<print content=[\"\']?title[\"\']?>/',
					'/<print choice>/',
					'/<print cart=[\"\']?id[\"\']?>/',
					'/<print cart=[\"\']?quantity[\"\']?>/',
					'/<print cart=[\"\']?cost[\"\']?>/',
					'/<print itemscalculate>/'
				],[
					$image,
					htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($c['title'],ENT_QUOTES,'UTF-8'),
					$ci['id'],
					htmlspecialchars($ci['quantity'],ENT_QUOTES,'UTF-8'),
					$ci['cost'],
					$ci['cost']*$ci['quantity']
				],$cartitem);
				$total=$total+($ci['cost']*$ci['quantity']);
				$cartitems.=$cartitem;
			}
			$total=$total+$ci['postageCost'];
			$html=preg_replace([
				'~<items>.*?<\/items>~is',
				'/<print totalcalculate>/'
			],[
		 		$cartitems,
				$total
			],$html);
			$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='postoption' ORDER BY title ASC");
			$sc->execute();
			$option='';
			if($sc->rowCount()>0){
				while($rc=$sc->fetch(PDO::FETCH_ASSOC))$option.='<option value="'.$rc['id'].'">'.$rc['title'].' (&#36;'.$rc['value'].')</option>';
				$html=preg_replace([
					'/<postoptions>/',
					'/<[\/]?postageoptions>/',
					'/<[\/]?emptycart>/'
				],[
					$option,
					'',
					''
				],$html,1);
			}else{
				$html=preg_replace([
					'~<postageoptions>.*?<\/postageoptions>~',
					'/<[\/]?postageoptions>/',
					'/<postoptions>/',
					'/<[\/]?emptycart>/'
				],[
					'<input type="hidden" name="postoption" value="0">',
					'',
					'',
					''
				],$html,1);
			}
			if(isset($user['id'])&&$user['id']>0)$html=preg_replace('~<loggedin>.*?<\/loggedin>~is','<input type="hidden" name="email" value="'.htmlspecialchars($user['email'],ENT_QUOTES,'UTF-8').'">',$html,1);
			else$html=preg_replace(['/<loggedin>/','/<\/loggedin>/'],'',$html);
		}else$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$theme['settings']['cart_empty'],$html,1);
	}
}
$content.=$html;
