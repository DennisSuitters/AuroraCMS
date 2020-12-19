<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Contact Us Message
 * @package    core/add_contactus.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
require'projecthoneypot/class.projecthoneypot.php';
require'spamfilter/class.spamfilter.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$error=0;
$notification=$blacklisted='';
$ti=time();
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$spam=FALSE;
if($act=='add_message'){
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
          ':reason'=>'Contact Form found Blacklisted IP (PHP)',
          ':ti'=>$ti
        ]);
			}
    }
  }
  if($_POST['emailtrap']=='none'){
    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
    $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
    $subject=filter_input(INPUT_POST,'subject',FILTER_SANITIZE_STRING);
		$notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
    if($config['spamfilter'][0]==1&&$spam==FALSE){
      $filter=new SpamFilter();
      $result=$filter->check_email($email);
      if($result){
        $blacklisted=$theme['settings']['blacklist'];
        $spam=TRUE;
      }
      $result=$filter->check_text($subject.' '.$name.' '.$notes);
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
            ':reason'=>'Spam detected from Input via Contact Form',
	          ':ti'=>$ti
	        ]);
  			}
      }
    }
    if($spam==FALSE){
  		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
  			$ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
  			$ss->execute([
          ':id'=>$subject
        ]);
  			if($ss->rowCount()==1){
  				$rs=$ss->fetch(PDO::FETCH_ASSOC);
  				$subject=$rs['title'];
  				if($rs['url']!='')
            $config['email']=$rs['url'];
  			}
        if($config['storemessages'][0]==1){
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
					if($error==0){
						require'phpmailer/class.phpmailer.php';
						$mail=new PHPMailer;
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
						if($mail->Send())
              $notification=$theme['settings']['contactus_success'];
						else
              $notification=$theme['settings']['contactus_error'];
						$mail2=new PHPMailer;
						$mail2->isSendmail();
						$mail2->SetFrom($config['email'],$config['business']);
						$toname=$email;
						$mail2->AddAddress($email);
						$mail2->IsHTML(true);
						$subject=isset($config['contactAutoReplySubject'])&&$config['contactAutoReplySubject']=''?$config['contactAutoReplySubject']:'{business} Contact Confirmation on {date}';
						$subject=str_replace([
							'{business}',
							'{date}'
						],[
							$config['business'],
							date($config['dateFormat'],$ti)
						],$subject);
						$mail2->Subject=$subject;
						$msg2=isset($config['contactAutoReplyLayout'])&&$config['contactAutoReplyLayout']!=''?rawurldecode($config['contactAutoReplyLayout']):'<p>Hi {first},</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>';
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
              $notification=$theme['settings']['contactus_success'];
						else
              $notification=$theme['settings']['contactus_error'];
  				}
  			}else
          $notification=$theme['settings']['contactus_error'];
  		}
    }
	}
  echo$blacklisted.$notification;
}
