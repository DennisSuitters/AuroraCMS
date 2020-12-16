<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Booking
 * @package    core/add_booking.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
include'projecthoneypot/class.projecthoneypot.php';
include'spamfilter/class.spamfilter.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$error=0;
$notification=$blacklisted='';
$ti=time();
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$spam=FALSE;
if($act=='add_booking'){
	if($config['php_options'][3]==1&&$config['php_APIkey']!=''){
    $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
    if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1){
      $blacklisted=$theme['settings']['blacklist'];
			$spam=TRUE;
			$sc=$db->prepare("SELECT `id` FROM `".$prefix."iplist` WHERE `ip`=:ip");
			$sc->execute([
				':ip'=>$ip
			]);
			if($sc->rowCount()<1){
	      $s=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`reason`,`ti`) VALUES (:ip,:oti,:reason,:ti)");
	      $s->execute([
          ':ip'=>$ip,
          ':oti'=>$ti,
					':reason'=>'Booking Form found Blacklisted IP (PHP)',
          ':ti'=>$ti
        ]);
			}
    }
	}
	if($_POST['emailtrap']=='none'){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
		$business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
		$address=filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
		$suburb=filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_STRING);
		$city=filter_input(INPUT_POST,'city',FILTER_SANITIZE_STRING);
		$state=filter_input(INPUT_POST,'state',FILTER_SANITIZE_STRING);
		$postcode=filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING);
		$phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
		$notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
		$tis=filter_input(INPUT_POST,'tis',FILTER_SANITIZE_STRING);
		$tim=filter_input(INPUT_POST,'tim',FILTER_SANITIZE_STRING);
		$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_STRING):0;
		if($config['spamfilter'][0]==1&&$spam==FALSE){
			$filter=new SpamFilter();
			$result=$filter->check_email($email);
			if($result){
				$blacklisted=$theme['settings']['blacklist'];
				$spam=TRUE;
			}
			$result=$filter->check_text($name.' '.$business.' '.$address.' '.$suburb.' '.$city.' '.$state.' '.$postcode.' '.$phone.' '.$notes);
			if($result){
				$blacklisted=$theme['settings']['blacklist'];
				$spam=TRUE;
			}
			if($config['spamfilter'][1]==1&&$spam==TRUE){
				$sc=$db->prepare("SELECT `id` FROM `".$prefix."iplist` WHERE `ip`=:ip");
				$sc->execute([
					':ip'=>$ip
				]);
				if($sc->rowCount()<1){
					$s=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`reason`,`ti`) VALUES (:ip,:oti,:reason,:ti)");
					$s->execute([
						':ip'=>$ip,
						':oti'=>$ti,
						':reason'=>'Spam detected from Input via Booking Form',
						':ti'=>$ti
					]);
				}
			}
		}
		if($spam==FALSE){
			if(filter_var($email,FILTER_VALIDATE_EMAIL)){
				$tis=$tis==0?$ti:strtotime($tis.$tim);
				if($rid!=0){
					$s=$db->prepare("SELECT `id`,`tie` FROM `".$prefix."content` WHERE `id`=:id");
					$s->execute([
						':id'=>$rid
					]);
					$r=$s->fetch(PDO::FETCH_ASSOC);
					$tie=$r['tie'];
				}else
					$tie=0;
				$q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`rid`,`contentType`,`name`,`email`,`business`,`address`,`suburb`,`city`,`state`,`postcode`,`phone`,`notes`,`status`,`tis`,`tie`,`ti`) VALUES (:rid,:contentType,:name,:email,:business,:address,:suburb,:city,:state,:postcode,:phone,:notes,:status,:tis,:tie,:ti)");
				$q->execute([
					':rid'=>$rid,
					':contentType'=>'booking',
					':name'=>$name,
					':email'=>$email,
					':business'=>$business,
					':address'=>$address,
					':suburb'=>$suburb,
					':city'=>$city,
					':state'=>$state,
					':postcode'=>$postcode,
					':phone'=>$phone,
					':notes'=>$notes,
					':status'=>'unconfirmed',
					':tis'=>$tis,
					':tie'=>$tie,
					':ti'=>$ti
				]);
				$e=$db->errorInfo();
				if(is_null($e[2])){
					if($config['email']!=''){
						require'phpmailer/class.phpmailer.php';
						$mail=new PHPMailer;
						$mail->isSendmail();
						$mail->SetFrom($email,$name);
						$toname=$config['email'];
						$mail->AddAddress($config['email']);
						$mail->IsHTML(true);
						$subject=str_replace([
							'{business}',
							'{name}'
						],[
							$name,
							$business
						],'Booking Created by {name} for {business}');
						$mail->Subject=$subject;
						$msg='Booking Date: '.date($config['dateFormat'],$tis).'<br />';
						if($rid!=0){
							$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
							$s->execute([
								':id'=>$rid
							]);
							$r=$s->fetch(PDO::FETCH_ASSOC);
							$msg.='Booked: '.ucfirst(rtrim($r['contentType'],'s')).' - '.$r['title'];
						}
						$msg.='Name: '.$name.'<br />'.
									'Email: '.$email.'<br />'.
									'Business: '.$business.'<br />'.
									'Address: '.$address.'<br />'.
									'Suburb: '.$suburb.'<br />'.
									'City: '.$city.'<br />'.
									'State: '.$state.'<br />'.
									'Postcode: '.$postcode.'<br />'.
									'Phone: '.$phone.'<br />'.
									'Notes: '.$notes;
						$mail->Body=$msg;
						$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
						if($mail->Send())$notification=$theme['settings']['booking_success'];
					}
					if($email!=''){
						$mail2=new PHPMailer;
						$mail2->isSendmail();
						$mail2->SetFrom($config['email'], $config['business']);
						$toname=$email;
						$mail2->AddAddress($email);
						if($config['bookingAttachment']!='')$mail2->AddAttachment('..'.DS.'media'.DS.basename($config['bookingAttachment']));
						$mail2->IsHTML(true);
						$namee=explode(' ',$name);
						$subject=isset($config['bookingAutoReplySubject'])&&$config['bookingAutoReplySubject']!=''?$config['bookingAutoReplySubject']:'Booking Confirmation from {business}';
						$subject=str_replace([
							'{business}',
							'{name}',
							'{first}',
							'{last}',
							'{date}'
						],[
							$config['business'],
							$name,
							$namee[0],
							end($namee),
							date($config['dateFormat'],$ti)
						],$subject);
						$mail2->Subject=$subject;
						$msg2=isset($config['bookingAutoReplyLayout'])&&$config['bookingAutoReplyLayout']!=''?rawurldecode($config['bookingAutoReplyLayout']):'Thank you for your Booking,<br />Someone will be in touch to confirm your Booking time.<br />Regards,<br />{business}';
						$bookingDate=$tis!=0?date($config['dateFormat'],$tis):'';
						$bookingService=$rid!=0?ucfirst(rtrim($r['contentType'],'s')).' - '.$r['title']:'';
	          $namee=explode(' ',$name);
						$msg2=str_replace([
							'{business}',
							'{name}',
							'{first}',
							'{last}',
							'{date}',
							'{booking_date}',
							'{service}'
						],[
							$config['business'],
							$name,
							$namee[0],
							end($namee),
							date($config['dateFormat'],$ti),
							$bookingDate,
							$bookingService
						],$msg2);
						$mail2->Body=$msg2;
						$mail2->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg2));
						if($mail2->Send())$notification=$theme['settings']['booking_success'];
						else$notification=$theme['settings']['booking_error'];
					}
				}else$notification=$theme['settings']['booking_error'];
			}
		}
	}
}
echo$blacklisted.$notification;
