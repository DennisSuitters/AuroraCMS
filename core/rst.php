<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Reset Password
 * @package    core/rst.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.11
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.11 Fix formatting of password reset email layouts.
 */
$getcfg=true;
require'db.php';
if(isset($_POST['emailtrap'])&&$_POST['emailtrap']=='none'){
  $eml=filter_input(INPUT_POST,'rst',FILTER_SANITIZE_STRING);
  $s=$db->prepare("SELECT id,name,email FROM `".$prefix."login` WHERE email=:email LIMIT 1");
  $s->execute([':email'=>$eml]);
  $c=$s->fetch(PDO::FETCH_ASSOC);
  if($s->rowCount()>0){
    $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
    $password=substr(str_shuffle($chars),0,8);
    $hash=password_hash($password,PASSWORD_DEFAULT);
    $us=$db->prepare("UPDATE `".$prefix."login` SET password=:password WHERE id=:id");
    $us->execute([
      ':password'=>$hash,
      ':id'=>$c['id']
    ]);
    require'class.phpmailer.php';
  	$mail=new PHPMailer;
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
  	if($mail->Send())echo'<div class="alert alert-success text-center">Check your Email!</div>';
    else echo'<div class="alert alert-danger text-center">Problem Sending Email!</div>';
  }else echo'<div class="alert alert-danger text-center">No Account Found!</div>';
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
  echo'<div class="alert alert-danger">'.$out.'</div>';
}
