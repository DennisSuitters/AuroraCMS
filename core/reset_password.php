<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Password Reset
 * @package    core/view/rstform.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
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
$ip=($_SERVER['REMOTE_ADDR']='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR']);
$hash=md5($ip);
$timecode=$_POST[$hash];
if($timecode!=''){
  $timecheck=$ti - base64_decode($timecode);
  if($config['formMinTime']!=0){
    if($timecheck < $config['formMinTime'])$not=['spammer'=>true,'target'=>'reset','element'=>'','action'=>'replace','class'=>'not alert alert-danger','text'=>'Woah, too quick, blacklisted!','reason'=>'Reset Password Form filled in too quickly! ('.$config['formMinTime'].' seconds)'];
  }
  if($config['formMaxTime']!=0){
    if($timecheck > ($config['formMaxTime']*60))$not=['spammer'=>true,'target'=>'reset','element'=>'','action'=>'replace','class'=>'not alert alert-danger','text'=>'Way too long to fill out a form!','reason'=>'Reset Password Form Exceeded time allowed! ('.$config['formMaxTime'].' minutes)'];
  }
}
if($config['reCaptchaServer']!=''){
  if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha)$not=['spammer'=>false,'target'=>'reset','element'=>'','action'=>'replace','class'=>'not alert alert-danger','text'=>'reCaptcha failed, maybe the setup is wrong!','reason'=>''];
    else{
      $responseKeys=json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($config['reCaptchaServer']).'&response='.urlencode($captcha)),true);
      if($responseKeys["success"])$not=['spammer'=>true,'target'=>'','element'=>'','action'=>'none','class'=>'','text'=>'','reason'=>'Reset Password Form reCaptcha Failed'];
    }
  }
}
if($not['spammer']==false){
  $act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
  if($act=='reset_password'){
    if($config['php_options'][3]==1&&$config['php_APIkey']!=''){
      $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
      if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)$not=['spammer'=>true,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Reset Password Form found Blacklisted IP via Project Honey Pot'];
    }
    if($_POST['fullname'.$hash]==''){
      $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
      if($config['spamfilter'][0]==1&&$not['spammer']==false){
        $filter=new SpamFilter();
        $result=$filter->check_email($email);
        if($result)$not=['spammer'=>true,'target'=>'resetemail','element'=>'div','action'=>'replace','class'=>'not mt-3 alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Reset Password Form, Spam Detected via Form Field Data.'];
      }
      if($not['spammer']==false){
        $s=$db->prepare("SELECT `id`,`name`,`email` FROM `".$prefix."login` WHERE `email`=:email LIMIT 1");
        $s->execute([':email'=>$email]);
        $c=$s->fetch(PDO::FETCH_ASSOC);
        if($s->rowCount()>0){
          $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
          $password=substr(str_shuffle($chars),0,8);
          $hashpwd=password_hash($password,PASSWORD_DEFAULT);
          $us=$db->prepare("UPDATE `".$prefix."login` SET `password`=:password WHERE `id`=:id");
          $us->execute([
            ':password'=>$hashpwd,
            ':id'=>$c['id']
          ]);
          require'phpmailer/class.phpmailer.php';
        	$mail=new PHPMailer;
        	$mail->isSendmail();
        	$toname=$c['name'];
        	$mail->SetFrom($config['email'],$config['business']);
        	$mail->AddAddress($c['email']);
        	$mail->IsHTML(true);
          $subject=isset($config['passwordResetSubject'])&&$config['passwordResetSubject']!=''?$config['passwordResetSubject']:'Password Reset for '.($c['name']!=''?$c['name']:$c['username']).' from {business}';
          $subject=str_replace([
            '{business}',
            '{date}'
          ],[
            $config['business'],
            date($config['dateFormat'],time())
          ],$subject);
        	$mail->Subject=$subject;
        	$msg=isset($config['passwordResetLayout'])&&$config['passwordResetLayout']!=''?rawurldecode($config['passwordResetLayout']):'<p>Hi {name},</p><p>A Password Reset was requested, it is now: {password}</p><p>We recommend changing the above password after logging in.</p>';
          $namee=explode(' ',$c['name']);
          $msg=str_replace([
            '{business}',
            '{name}',
            '{first}',
            '{last}',
            '{date}',
            '{password}'
          ],[
            $config['business'],
            $c['name'],
            $namee[0],
            end($namee),
            date($config['dateFormat'],time()),
            $password
          ],$msg);
        	$mail->Body=$msg;
        	$mail->AltBody=$msg;
        	if($mail->Send())$not=['spammer'=>false,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Check your Email!','reason'=>''];
          else$not=['spammer'=>false,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Problem Sending Email!','reason'=>''];
        }else$not=['spammer'=>false,'target'=>'resetemail','element'=>'div','action'=>'after','class'=>'not mt-3 alert alert-danger','text'=>'No Account Found!','reason'=>''];
      }
    }else$not=['spammer'=>false,'target'=>'resetemail','element'=>'div','action'=>'after','class'=>'not mt-3 alert alert-danger','text'=>'The Email provided is invalid!','reason'=>''];
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
