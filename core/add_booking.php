<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Booking
 * @package    core/add_booking.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
require'projecthoneypot/class.projecthoneypot.php';
require'spamfilter/class.spamfilter.php';
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$theme=parse_ini_file('../layout/'.$config['theme'].'/theme.ini',true);
$paylink='';
$ti=time();
$not=['spammer'=>false,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Thank You for Making a Booking, a Representative will be in touch shortly!','reason'=>''];
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$hash=md5($ip);
$cid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
$timecode=$_POST[$hash];
if($timecode!=''){
  $timecheck=$ti - base64_decode($timecode);
  if($config['formMinTime']!=0){
    if($timecheck < $config['formMinTime'])$not=['spammer'=>true,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Woah, too quick, blacklisted!','reason'=>'Booking Form filled in too quickly! ('.$config['formMinTime'].' seconds)'];
  }
  if($config['formMaxTime']!=0){
    if($timecheck > ($config['formMaxTime']*60))$not=['spammer'=>true,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert-alert-danger','text'=>'Way too long to fill out a form!','reason'=>'Booking Form Exceeded time allowed! ('.$config['formMaxTime'].' minutes)'];
  }
}
if($config['reCaptchaServer']!=''){
  if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha)$not=['spammer'=>true,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'reCaptcha failed, maybe the setup is wrong!','reason'=>''];
    else{
      $responseKeys=json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($config['reCaptchaServer']).'&response='.urlencode($captcha)),true);
      if($responseKeys["success"])$not=['spammer'=>true,'target'=>'','element'=>'','action'=>'none','class'=>'','text'=>'','reason'=>'Booking Form reCaptcha Failed'];
    }
  }
}
if($not['spammer']==false){
  $act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
	if($act=='add_booking'){
		if($config['php_options'][3]==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
	    $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
	    if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)$not=['spammer'=>true,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Booking Form found Blacklisted IP via Project Honey Pot'];
		}
		if($_POST['fullname'.$hash]==''&&$not['spammer']==false){
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
			$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
			if($config['spamfilter'][0]==1&&$not['spammer']==false&&$ip='127.0.0.1'){
				$filter=new SpamFilter();
				$result=$filter->check_email($email);
				if($result)$not=['spammer'=>true,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Booking Form, Spam Detected via Form Field Data.'];
				$result=$filter->check_text($name.' '.$business.' '.$address.' '.$suburb.' '.$city.' '.$state.' '.$postcode.' '.$phone.' '.$notes);
				if($result)$not=['spammer'=>true,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Booking Form, Spam Detected via Form Field Data.'];
			}
			if($not['spammer']==false){
				if(filter_var($email,FILTER_VALIDATE_EMAIL)){
					$tis=$tis==0?$ti:strtotime($tis);
					if($rid!=0){
						$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
						$s->execute([':id'=>$rid]);
						$r=$s->fetch(PDO::FETCH_ASSOC);
						$tie=$r['tie'];
						if($tie==0)$tie=$tis;
					}else$tie=$tis;
	//				$tisday=date('l',$tis);
	//				$tist=date('HHII',$tis);
	//				$tiet=date('HHII',$tie);
	//				$sd=$db->prepare("SELECT `id`,`tis`,`tie` FROM `".$prefix."choices` WHERE `contentType`='hours' AND `username`=:tisday AND `tis` >= :tis AND `tie` <= :tie");
	//				$sd->execute([
	//					':tisday'=>strtolower($tisday),
	//					':tis'=>$tist,
	//					':tie'=>$tiet
	//				]);
	//				$sdr=$sd->fetch(PDO::FETCH_ASSOC);
	//				if($sdr['tis'] == 0 || $sdr['tis'] >= $tist || $sdr['tie'] <= $tiet){
	//	            $notification=preg_replace([
  //                '/<print alert>/',
  //                '/<print text>/'
  //              ],[
  //                'danger',
  //                'The Date or Time that was selected is outside of our Operating Hours, please select a different Date or Time.'
  //              ],$theme['settings']['alert']);
	//				}else{
          $cont='go';
          $sc=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` = :contentType AND `tis` > :tis AND `tie` < :tie");
          $sc->execute([
            ':contentType'=>'booking',
            ':tis'=>$tis-1,
            ':tie'=>$tie+$config['bookingBuffer']+1
          ]);
          if($sc->rowCount()>0&&$r['contentType']!='events'){
            $not=['spammer'=>false,'target'=>'tis','element'=>'div','action'=>'after','class'=>'not mt-3 alert alert-info','text'=>'Date or Time is already Booked, please select a different Date or Time.','reason'=>''];
            $cont='stop';
          }
					if($cont=='go'){
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
            $bid=$db->lastInsertId();
            if($config['options'][6]==1&&$r['contentType']=='events'){
/* If an Event is being booked, check if User exists with details given via form. */
              $qc=$db->prepare("SELECT `id` FROM `".$prefix."login` WHERE `email`=:email");
              $qc->execute([':email'=>$email]);
              if($qc->rowCount()>0){
                $qr=$qc->fetch(PDO::FETCH_ASSOC);
                $cid=$qr['id'];
              }else{
  /* Create account if it doesn't exist */
                $ql=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`name`,`email`,`business`,`address`,`suburb`,`city`,`state`,`postcode`,`phone`,`rank`,`status`,`ti`) VALUES (:name,:email,:business,:address,:suburb,:city,:state,:postcode,:phone,:rank,:status,:ti)");
                $ql->execute([
                  ':name'=>$name,
                  ':email'=>$email,
                  ':business'=>$business,
                  ':address'=>$address,
                  ':suburb'=>$suburb,
                  ':city'=>$city,
                  ':state'=>$state,
                  ':postcode'=>$postcode,
                  ':phone'=>$phone,
                  ':rank'=>200,
                  ':status'=>'unconfirmed',
                  ':ti'=>$ti
                ]);
                $cid=$db->lastInsertId();
              }
            }
  /* Create new Order ID */
            if($rid!=0&&$r['cost']>0){
              $oi=$db->query("SELECT MAX(`id`) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
              $dti=$ti+$config['orderPayti'];
              $oid='I'.date("ymd",$ti).sprintf("%06d",$oi['id']+1,6);
              $sbb=$db->prepare("UPDATE `".$prefix."content` SET `category_1`=:oid WHERE `id`=:id");
              $sbb->execute([
                ':oid'=>$oid,
                ':id'=>$bid
              ]);
/* Insert New Order for Event Payment */
              $iq=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`uid`,`cid`,`iid`,`iid_ti`,`due_ti`,`status`) VALUES (:uid,:cid,:iid,:iid_ti,:due_ti,'pending')");
              $iq->execute([
                ':uid'=>0,
                ':cid'=>$cid,
                ':iid'=>$oid,
                ':iid_ti'=>$ti,
                ':due_ti'=>$dti
              ]);
              $qid=$db->lastInsertId();
              $se=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`cid`,`title`,`quantity`,`cost`,`status`,`ti`) values (:oid,:iid,:cid,:title,:quantity,:cost,:status,:ti)");
              $se->execute([
                ':oid'=>$qid,
                ':iid'=>$r['id'],
                ':cid'=>$cid,
                ':title'=>$r['title'],
                ':quantity'=>1,
                ':cost'=>$r['cost'],
                ':status'=>'',
                ':ti'=>$ti
              ]);
              $paylink=$r['cost']!=''||$r['cost']>0?'<br>A Booking and Invoice has been created, you can pay online by using the link below to View the Invoice.<br><a href="'.URL.'orders/'.$oid.'">#'.$oid.'</a>':'';
            }
            if($r['contentType']=='events'&&$r['cost']==0){
              $not=['spammer'=>false,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'A Booking has been created for your attendance. A confirmation email has been sent to the email address you provided with details of how to access the Event.','reason'=>''];
            }
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
								$s->execute([':id'=>$rid]);
								$r=$s->fetch(PDO::FETCH_ASSOC);
								$msg.='Booked: '.ucfirst(rtrim($r['contentType'],'s')).' - '.$r['title'].'<br />';
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
							if($mail->Send()){
//                  $not=['spammer'=>false,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Thank You for Making a Booking, a Representative will be in touch shortly!','reason'=>''];
              }
						}
						if($email!=''){
							$mail2=new PHPMailer;
							$mail2->isSendmail();
							$mail2->SetFrom($config['email'], $config['business']);
							$toname=$email;
							$mail2->AddAddress($email);
							if($config['bookingAttachment']!='')$mail2->AddAttachment('../media/'.basename($config['bookingAttachment']));
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
                if(isset($config['bookingAutoReplyLayout'])&&$config['bookingAutoReplyLayout']!=''){
                  $msg2=rawurldecode($config['bookingAutoReplyLayout']);
                }else{
                  $msg2='Thank you for your Booking,<br />';
                  if($r['contentType']=='events'){
                    if($r['cost']>0){
                      $msg2.=$paylink;
                    }
                  }
                  if($r['contentType'=='service']){
                    $msg2.=$paylink.'Someone will be in touch to confirm your Booking time.<br />Regards,<br />{business}';
                  }
                }
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
									'{service}',
                  '{event}',
                  '{externalLink}'
								],[
									$config['business'],
									$name,
									$namee[0],
									end($namee),
									date($config['dateFormat'],$ti),
									$bookingDate,
									$bookingService,
                  $bookingService,
                  $r['contentType']=='events'&&$r['cost']==0&&$r['exturl']!=''?'As this is a Free Event, please find your link to the Event below:<br /><a href="'.$r['exturl'].'">'.$r['exturl'].'</a>':''
								],$msg2);
								$mail2->Body=$msg2;
								$mail2->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg2));
								if($mail2->Send()){
                  if($r['contentType']=='events'&&$r['cost']>0){
                    $not=['spammer'=>false,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Thank You for Making a Booking, a Representative will be in touch shortly!'.$paylink,'reason'=>''];
                  }
								}else
                  $not=['spammer'=>false,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was a problem adding the Booking!','reason'=>''];
								}
							}
	//				}
// 6LeohZcaAAAAALoOJB_iZ95NOrYg2RZDuxc75S9O
// 6LeohZcaAAAAAGhQ9qaDVbOpZegPAqiuQ1BobwLU
//
          }else
            $not=['spammer'=>false,'target'=>'booking','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was a problem adding the Booking!','reason'=>''];
			}
		}
	}
	echo(isset($not)?$not['target'].'|'.$not['element'].'|'.$not['action'].'|'.$not['class'].'|'.$not['text']:'');
}
if($not['spammer']==true&&$not['reason']!=''){
  $sc=$db->prepare("SELECT `id` FROM `".$prefix."iplist` WHERE `ip`=:ip");
  $sc->execute([':ip'=>$ip]);
  if($sc->rowCount()<1){
    $s=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`reason`,`ti`) VALUES (:ip,:oti,:reason,:ti)");
    $s->execute([':ip'=>$ip,':oti'=>$ti,':reason'=>$not['reason'],':ti'=>$ti]);
  }
}
