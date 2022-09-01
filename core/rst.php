<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Reset Password
 * @package    core/rst.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
require'projecthoneypot/class.projecthoneypot.php';
require'spamfilter/class.spamfilter.php';
$theme=parse_ini_file('../layout/'.$config['theme'].'/theme.ini',true);
$ti=time();
$not=['spammer'=>false,'target'=>'reset','element'=>'','action'=>'','class'=>'','text'=>'','reason'=>''];
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$hash=md5($ip);
if($not['spammer']==false){
  $act=filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW);
  if($act=='reset_password'){
    if($config['php_options'][3]==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
      $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
      if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)$not=['spammer'=>true,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Create Account Form found Blacklisted IP via Project Honey Pot'];
    }
    if($not['spammer']==false){
      $email=filter_input(INPUT_POST,'email',FILTER_UNSAFE_RAW);
      if($config['spamfilter'][0]==1&&$not['spammer']==false&&$ip!='127.0.0.1'){
        $filter=new SpamFilter();
        $result=$filter->check_text($email.' '.$username);
        if($result)$not=['spammer'=>true,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Sign Up Form, Spam Detected via Form Field Data.'];
      }
      if($not['spammer']==false){
        $s=$db->prepare("SELECT `id`,`name`,`email` FROM `".$prefix."login` WHERE `email`=:email LIMIT 1");
        $s->execute([':email'=>$email]);
        $c=$s->fetch(PDO::FETCH_ASSOC);
        if($s->rowCount()>0){
          $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
          $password=substr(str_shuffle($chars),0,8);
          $hash=password_hash($password,PASSWORD_DEFAULT);
          $us=$db->prepare("UPDATE `".$prefix."login` SET `password`=:password WHERE `id`=:id");
          $us->execute([
            ':password'=>$hash,
            ':id'=>$c['id']
          ]);
          require'phpmailer/PHPMailer.php';
          require'phpmailer/SMTP.php';
          require'phpmailer/Exception.php';
      	  $mail = new PHPMailer\PHPMailer\PHPMailer;
      	  $mail->isSendmail();
        	$toname=$c['name'];
        	$mail->SetFrom($config['email'],$config['business']);
        	$mail->AddAddress($c['email']);
        	$mail->IsHTML(true);
          $subject=str_replace([
            '{business}',
            '{date}'
          ],[
            $config['business'],
            date($config['dateFormat'],time())
          ],$config['passwordResetSubject']);
        	$mail->Subject=($subject!=''?$subject:'Password Reset from '.$config['business']);
          $name=explode(' ',$c['name']);
          $layout=rawurldecode($config['passwordResetLayout']);
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
            $name[0],
            end($name),
            date($config['dateFormat'],time()),
            $password
          ],$layout);
        	$mail->Body=($msg=''?$msg:'Hello '.($c['name']!=''?$name[0]:$c['username']).',<br>Your new Password is: '.$password.'<br>We recommend changing this when you login<br>Regards,<br>'.$config['business'].'<br>');
        	$mail->AltBody=($msg=''?$msg:'Hello '.$name[0].',<br>Your new Password is: '.$password.'<br>We recommend changing this when you login<br>Regards,<br>'.$config['business'].'<br>');
        	if($mail->Send())$not=['spammer'=>false,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Check your Email for a generated Password.<br>Don\'t forget to change your password when you login next','reason'=>''];
          else$not=['spammer'=>false,'target'=>'reset','element'=>'div','action'=>'replace','alert'=>'not alert alert-danger','text'=>'Problem Sending to Email Provided!','reason'=>''];
        }else$not=['spammer'=>false,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-info','text'=>'Account Not Found!','reason'=>''];
      }
    }else{
      $r=rand(0,10);
      switch($r){
        case 0:
          $out='No doubt you thought that was terribly clever.';
          break;
        case 1:
          $out='You’ve attempted logic. Not all attempts succeed.';
          break;
        case 2:
          $out='Either your educators have failed you, or you have failed them.';
        default:
          $out='Go Away!';
      }
      $not=['spammer'=>true,'target'=>'reset','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>$out,'reason'=>''];
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
