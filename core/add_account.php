<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Create New Account
 * @package    core/add_newaccount.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
require'projecthoneypot/class.projecthoneypot.php';
require'spamfilter/class.spamfilter.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$theme=parse_ini_file('../layout/'.$config['theme'].'/theme.ini',true);
$ti=time();
$not=['spammer'=>false,'target'=>'','element'=>'','action'=>'','class'=>'','text'=>'','reason'=>''];
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$hash=md5($ip);
$timecode=$_POST[$hash];
if($timecode!=''){
  $timecheck=$ti - base64_decode($timecode);
  if($config['formMinTime']!=0){
    if($timecheck < $config['formMinTime'])
      $not=['spammer'=>true,'target'=>'signup','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Woah, too quick, blacklisted!','reason'=>'Create Account Form filled in too quickly! ('.$config['formMinTime'].' seconds)'];
  }
  if($config['formMaxTime']!=0){
    if($timecheck > ($config['formMaxTime']*60))
      $not=['spammer'=>true,'target'=>'signup','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Way too long to fill out a form!','reason'=>'Create Account Form Exceeded time allowed! ('.$config['formMaxTime'].' minutes)'];
  }
}
if($config['reCaptchaServer']!=''){
  if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha)$not=['spammer'=>false,'target'=>'signup','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'reCaptcha failed, maybe the setup is wrong!','reason'=>''];
    else{
      $responseKeys=json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($config['reCaptchaServer']).'&response='.urlencode($captcha)),true);
      if($responseKeys["success"])$not=['spammer'=>true,'target'=>'','element'=>'','action'=>'none','class'=>'','text'=>'','reason'=>'Create Account Form reCaptcha Failed'];
    }
  }
}
if($not['spammer']==false){
  $act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
  if($act=='add_account'){
    if($config['php_options'][3]==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
      $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
      if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)
        $not=['spammer'=>true,'target'=>'signup','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Create Account Form found Blacklisted IP via Project Honey Pot'];
    }
    if($_POST['fullname'.$hash]==''){
      $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
      $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
      if($config['spamfilter'][0]==1&&$not['spammer']==false&&$ip!='127.0.0.1'){
        $filter=new SpamFilter();
        $result=$filter->check_text($email.' '.$username);
        if($result)$not=['spammer'=>true,'target'=>'signup','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Sign Up Form, Spam Detected via Form Field Data.'];
      }
      if($not['spammer']==false&&$email!=''){
        $s=$db->prepare("SELECT `email` FROM `".$prefix."login` WHERE `email`=:email");
        $s->execute([':email'=>$email]);
        if($s->rowCount()>0)$not=['spammer'=>false,'target'=>'signupemail','element'=>'div','action'=>'after','class'=>'not mt-3 alert alert-info','text'=>'Email is Already in Use!','reason'=>''];
      }else$not=['spammer'=>false,'target'=>'signupemail','element'=>'div','action'=>'after','class'=>'not mt-3 alert alert-info','text'=>'Email can NOT be blank','reason'=>''];
      if($not['spammer']==false){
        if(isset($_POST['terms'])&&$_POST['terms']=='yes'){
          if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
            if(!defined('PROTOCOL'))define('PROTOCOL','https://');
          }else{
            if(!defined('PROTOCOL'))define('PROTOCOL','http://');
          }
          if($username!=''){
            $s=$db->prepare("SELECT `username` FROM `".$prefix."login` WHERE `username`=:username LIMIT 1");
            $s->execute([':username'=>$username]);
            $r=$s->fetch(PDO::FETCH_ASSOC);
            if($s->rowCount()>0)$not=['spammer'=>false,'target'=>'signupusername','element'=>'div','action'=>'after','class'=>'not mt-3 alert alert-danger','text'=>'Username Already Exists!','reason'=>''];
            else{
              $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
              $password=substr(str_shuffle($chars),0,8);
              $hashpwd=password_hash($password,PASSWORD_DEFAULT);
              $activate=md5(time());
              $us=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`username`,`password`,`email`,`hash`,`activate`,`active`,`ti`) VALUES (:username,:password,:email,:hash,:activate,:active,:ti)");
              $us->execute([
                ':username'=>$username,
                ':password'=>$hashpwd,
                ':email'=>$email,
                ':hash'=>md5($email),
                ':activate'=>$activate,
                ':active'=>0,
                ':ti'=>time()
              ]);
              require'phpmailer/class.phpmailer.php';
              $mail=new PHPMailer;
            	$mail->isSendmail();
            	$toname=$username;
            	$mail->SetFrom($config['email'],$config['business']);
            	$mail->AddAddress($email);
            	$mail->IsHTML(true);
              $subject=isset($config['accountActivationSubject'])&&$config['accountActivationSubject']!=''?$config['accountActivationSubject']:'Account Activation for {username} from {site}.';
              $subject=str_replace([
                '{username}',
                '{site}'
              ],[
                $username,
                $config['business']
              ],$subject);
            	$mail->Subject=$subject;
            	$msg=isset($config['accountActivationLayout'])&&$config['accountActivationLayout']!=''?$config['accountActivationLayout']:'<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>The Username you signed up with is: {username}<br>The AutoGenerated Password is: {password}</p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>';
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
            	if($mail->Send())$not=['spammer'=>false,'target'=>'signup','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Check the provided Email for Activation Details!','reason'=>''];
              else$not=['spammer'=>false,'target'=>'signup','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Problem Sending Email','reason'=>''];
            }
          }else$not=['spammer'=>false,'target'=>'signupusername','element'=>'div','action'=>'after','class'=>'not mt-3 alert alert-danger','text'=>'Must have a Username!','reason'=>''];
        }else$not=['spammer'=>false,'target'=>'signuptermsblock','element'=>'div','action'=>'after','class'=>'not alert alert-warning','text'=>'You Must agree to the Terms Of Service to Sign Up!','reason'=>''];
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
