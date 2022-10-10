<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Contact Us Message
 * @package    core/add_contactus.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
require'projecthoneypot/class.projecthoneypot.php';
require'spamfilter/class.spamfilter.php';
$theme=parse_ini_file('../layout/'.$config['theme'].'/theme.ini',true);
$ti=time();
$not=['spammer'=>false,'target'=>'','element'=>'','action'=>'','class'=>'','text'=>'','reason'=>''];
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$hash=md5($ip);
$timecode=$_POST[$hash];
if($timecode!=''){
  $timecheck=$ti - base64_decode($timecode);
  if($config['formMinTime']!=0){
    if($timecheck < $config['formMinTime'])$not=['spammer'=>true,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert-alert-danger','text'=>'Woah, too quick, blacklisted!','reason'=>'Contact Form filled in too quickly! ('.$config['formMinTime'].' seconds)'];
  }
  if($config['formMaxTime']!=0){
    if($timecheck > ($config['formMaxTime']*60))$not=['spammer'=>true,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Way too long to fill out a form!','reason'=>'Contact Form Exceeded time allowed! ('.$config['formMaxTime'].' minutes)'];
  }
}
if($config['reCaptchaServer']!=''){
  if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha)$not=['spammer'=>true,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'reCaptcha failed, maybe the setup is wrong!','reason'=>''];
    else{
      $responseKeys=json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($config['reCaptchaServer']).'&response='.urlencode($captcha)),true);
      if($responseKeys["success"])$not=['spammer'=>true,'target'=>'','element'=>'','action'=>'none','class'=>'','text'=>'','reason'=>'Contact Form reCaptcha Failed'];
    }
  }
}
if($not['spammer']==false){
  $act=filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW);
  if($act=='add_message'){
    if($config['php_options'][3]==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
      $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
      if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)$not=['spam'=>true,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Contact found Blacklisted IP via Project Honey Pot'];
    }
    if($_POST['fullname'.$hash]==''){
      $email=filter_input(INPUT_POST,'email',FILTER_UNSAFE_RAW);
      $name=filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW);
      $subject=filter_input(INPUT_POST,'subject',FILTER_UNSAFE_RAW);
  		$notes=filter_input(INPUT_POST,'notes',FILTER_UNSAFE_RAW);
      if($config['spamfilter']==1&&$note['spammer']==false&&$ip='127.0.0.1'){
        $filter=new SpamFilter();
        $result=$filter->check_email($email);
        if($result)$not=['spammer'=>true,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Contact Form, Spam Detected via Form Field Data.'];
        $result=$filter->check_text($subject.' '.$name.' '.$notes);
        if($result)$not=['spammer'=>true,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Contact Form, Spam Detected via Form Field Data.'];
      }
      if($not['spammer']==false&&$email!=''){
    		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    			$ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
    			$ss->execute([':id'=>$subject]);
    			if($ss->rowCount()==1){
    				$rs=$ss->fetch(PDO::FETCH_ASSOC);
    				$subject=$rs['title'];
    				if($rs['url']!='')$config['email']=$rs['url'];
    			}
          if($config['storemessages']==1){
            $q=$db->prepare("INSERT IGNORE INTO `".$prefix."messages` (`uid`,`ip`,`folder`,`to_email`,`to_name`,`from_email`,`from_name`,`subject`,`status`,`notes_raw`,`ti`) VALUES ('0',:ip,:folder,:to_email,:to_name,:from_email,:from_name,:subject,:status,:notes_raw,:ti)");
    			  $q->execute([
    					':ip'=>$ip,
              ':folder'=>'INBOX',
              ':to_email'=>$config['email'],
              ':to_name'=>$config['business'],
              ':from_email'=>$email,
              ':from_name'=>$name,
              ':subject'=>$subject,
              ':status'=>'unread',
              ':notes_raw'=>$notes,
              ':ti'=>time()
            ]);
    			  $id=$db->lastInsertId();
    			  $e=$db->errorInfo();
          }
  				if($config['email']!=''){
  					if($not['spammer']==false){
              require'phpmailer/PHPMailer.php';
              require'phpmailer/SMTP.php';
              require'phpmailer/Exception.php';
  						$mail = new PHPMailer\PHPMailer\PHPMailer;
              $mail->isSendmail();
    					$mail->SetFrom($email, $name);
  						$toname=$config['email'];
  						$mail->AddAddress($config['email']);
  						$mail->IsHTML(true);
  						$mail->Subject='Contact Email via '.$config['business'].': '.$subject;
  						$msg='Message Date: '.date($config['dateFormat'],$ti).'<br />'.
  								 'Subject: '.$subject.'<br />'.
  								 'Name: '.$name.'<br />'.
  								 'Email: '.$email.'<br />'.
  								 'Message: '.$notes;
  						$mail->Body=$msg;
  						$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
  						if($mail->Send())$not=['spammer'=>false,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Thank You for Contacting Us.','reason'=>''];
  						else$not=['spammer'=>false,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was an Issue Sending Your Message. But we have a record of your contact, so never fear, we still got your message.','reason'=>''];
  						$mail2=new PHPMailer;
  						$mail2->isSendmail();
  						$mail2->SetFrom($config['email'],$config['business']);
  						$toname=$email;
  						$mail2->AddAddress($email);
  						$mail2->IsHTML(true);
  						$subject=$config['contactAutoReplySubject']!=''?$config['contactAutoReplySubject']:'{business} Contact Confirmation on {date}';
  						$subject=str_replace([
  							'{business}',
  							'{date}'
  						],[
  							$config['business'],
  							date($config['dateFormat'],$ti)
  						],$subject);
  						$mail2->Subject=$subject;
  						$msg2=$config['contactAutoReplyLayout']!=''?rawurldecode($config['contactAutoReplyLayout']):'<p>Hi {first},</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>';
  						$n=explode(' ',$name);
  						$namefirst=$n[0];
  						$namelast=end($n);
  						$msg2=str_replace([
  							'{business}',
  							'{date}',
  							'{name}',
  							'{first}',
  							'{last}',
  							'{subject}'
  						],[
  							$config['business']!=''?$config['business']:'us',
  							date($config['dateFormat'],$ti),
  							$name,
  							$namefirst,
  							$namelast,
  							$subject
  						],$msg2);
  						$mail2->Body=$msg2;
  						$mail2->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
  						if($mail2->Send())
                $not=['spammer'=>false,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Thank You for Contacting Us.','reason'=>''];
              else
                $not=['spammer'=>false,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was an Issue Sending Your Message. But we have a record of your contact, so never fear, we still got your message.','reason'=>''];
    				}
    			}else
            $not=['spammer'=>false,'target'=>'contact','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was an Issue Sending Your Message. But we have a record of your contact, so never fear, we still got your message.','reason'=>''];
    		}
      }
  	}
    echo(isset($not)?$not['target'].'|'.$not['element'].'|'.$not['action'].'|'.$not['class'].'|'.$not['text']:'');
  }
}
if($not['spammer']==true&&$not['reason']!=''){
  $sc=$db->prepare("SELECT `id` FROM `".$prefix."iplist` WHERE `ip`=:ip");
  $sc->execute([':ip'=>$ip]);
  if($sc->rowCount()<1){
    $s=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`reason`,`ti`) VALUES (:ip,:oti,:reason,:ti)");
    $s->execute([':ip'=>$ip,':oti'=>$ti,':reason'=>$not['reason'],':ti'=>$ti]);
  }
}
