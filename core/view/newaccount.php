<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Create New Account
 * @package    core/view/newaccount.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require_once'..'.DS.'db.php';
$theme=parse_ini_file('..'.DS.'..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$notification=$blacklisted='';
include'..'.DS.'class.projecthoneypot.php';
include'..'.DS.'class.spamfilter.php';
$error=0;
$notification=$blacklisted='';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$ti=time();
$spam=FALSE;
if($config['php_options'][3]==1&&$config['php_APIkey']!=''){
  $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
  if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1){
    $blacklisted=$theme['settings']['blacklist'];
    $sc=$db->prepare("SELECT id FROM iplist WHERE ip=:ip");
    $sc->execute([':ip'=>$ip]);
    if($sc->rowCount()<1){
      $s=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`ti`) VALUES (:ip,:oti,:ti)");
      $s->execute([
        ':ip'=>$ip,
        ':oti'=>$ti,
        ':ti'=>$ti
      ]);
    }
  }
}
if(isset($_POST['emailtrap'])&&$_POST['emailtrap']=='none'){
  $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
  $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
  if($config['spamfilter'][0]==1&&$spam==FALSE){
    $filter=new SpamFilter();
    $result=$filter->check_text($email.' '.$username);
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
        $s=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`ti`) VALUES (:ip,:oti,:ti)");
        $s->execute([
          ':ip'=>$ip,
          ':oti'=>$ti,
          ':ti'=>$ti
        ]);
      }
    }
  }
  if($spam==FALSE){
    if(isset($_POST['terms'])&&$_POST['terms']=='yes'){
      define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url']);
      if($username!=''){
        $s=$db->prepare("SELECT `username` FROM `".$prefix."login` WHERE `username`=:username LIMIT 1");
        $s->execute([
          ':username'=>$username
        ]);
        $r=$s->fetch(PDO::FETCH_ASSOC);
        if($s->rowCount()>0)
          $notification.=$theme['settings]']['signup_erroruserexists'];
        else{
          $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
          $password=substr(str_shuffle($chars),0,8);
          $hash=password_hash($password,PASSWORD_DEFAULT);
          $activate=md5(time());
          $us=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`username`,`password`,`email`,`hash`,`activate`,`active`,`ti`) VALUES (:username,:password,:email,:hash,:activate,:active,:ti)");
          $us->execute([
            ':username'=>$username,
            ':password'=>$hash,
            ':email'=>$email,
            ':hash'=>md5($email),
            ':activate'=>$activate,
            ':active'=>0,
            ':ti'=>time()
          ]);
          include'..'.DS.'class.phpmailer.php';
          $mail=new PHPMailer;
        	$mail->isSendmail();
        	$toname=$username;
        	$mail->SetFrom($config['email'],$config['business']);
        	$mail->AddAddress($email);
        	$mail->IsHTML(true);
          $subject=isset($config['accountActivationSubject'])&&$config['accountActivationSubject']!=''?$config['accountActivationLayout']:'Account Activation for {username} from {site}.';
          $subject=str_replace([
            '{username}',
            '{site}'
          ],[
            $username,
            $config['business']
          ],$subject);
        	$mail->Subject=$subject;
        	$msg=isset($config['accountActivationLayout'])&&$config['accountActivationLayout']!=''?$config['accountActivationLayout']:'<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>';
          $msg=str_replace([
            '{username}',
            '{site}',
            '{activation_link}',
            '{password}'
          ],[
            $username,
            $config['business'],
            '<a href="'.URL.'?activate='.$activate.'">'.URL.'?activate='.$activate.'</a>',
            $password
          ],$msg);
        	$mail->Body=$msg;
        	$mail->AltBody=$msg;
        	if($mail->Send())
            $notification.=$theme['settings']['signup_success'];
          else
            $notification.=$theme['settings']['signup_error'];
        }
      }else
        $notification.=$theme['settings']['signup_errorusername'];
    }else
      $notification.=$theme['settings']['signup_erroremail'];
  }
}
echo$blacklisted.$notification;
