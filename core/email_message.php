<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Email Messages
 * @package    core/email_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.25
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
define('THEME','../layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('ADMINURL',URL.$settings['system']['admin'].'/');
define('UNICODE','UTF-8');
if(isset($_SESSION['uid'])&&$_SESSION['uid']!=0){
  $su=$db->prepare("SELECT `email_signature` FROM `".$prefix."login` WHERE `id`=:uid");
  $su->execute([':uid'=>$_SESSION['uid']]);
  $user=$su->fetch(PDO::FETCH_ASSOC);
}
$theme=parse_ini_file(THEME.'/theme.ini',true);
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$act=filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW);
$subject=filter_input(INPUT_POST,'subject',FILTER_UNSAFE_RAW);
$to=filter_input(INPUT_POST,'to_email',FILTER_UNSAFE_RAW);
$from=filter_input(INPUT_POST,'from_email',FILTER_UNSAFE_RAW);
$atts=filter_input(INPUT_POST,'atts',FILTER_UNSAFE_RAW);
$body=(isset($_POST['bod'])?$_POST['bod']:'').'<br>'.($user['email_signature']!=''?$user['email_signature']:$config['email_signature']).'<br>';
$msgbody=$body;
if($to!=''){
  require'phpmailer/PHPMailer.php';
  require'phpmailer/SMTP.php';
  require'phpmailer/Exception.php';
  if($id!=0){
    $ms=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `id`=:id");
    $ms->execute([':id'=>$id]);
    if($ms->rowCount()>0)$mr=$ms->fetch(PDO::FETCH_ASSOC);
  }
  $mail=new PHPMailer\PHPMailer\PHPMailer;
  $mail->isSendmail();
  $mail->isHTML(true);
  if($act=='reply'){
    $from2=$to;
    $to2=$from;
    $from=$from2;
    $to=$to2;
    $body=$body.$mr['notes_html'];
    $msgbody=$body;
    $subject='Re: '.$subject;
  }
  if($act=='forward'){
    $body=$body.$mr['notes_html'];
    $msgbody=$body;
    $subject='Fw: '.$subject;
  }
  $fs=$db->prepare("SELECT `id`,`name`,`email`,`business` FROM `".$prefix."login` WHERE `email`=:email");
  $fs->execute([':email'=>$from]);
  if($fs->rowCount()>0){
    $fr=$fs->fetch(PDO::FETCH_ASSOC);
    $fr['name']!=''?$fr['name']:$fr['business'];
    $fr['email']!=''?$fr['email']:$config['email'];
    $mail->SetFrom($fr['email'],$fr['name']);
  }else$mail->AddReplyTo($from,$config['business']);
  $mto=explode(",",$to);
  if(isset($mto[1])&&$mto[1]!=''){
    foreach($mto as$to2){
      $ts=$db->prepare("SELECT `id`,`name`,`email`,`business` FROM `".$prefix."login` WHERE `email`=:email");
      $ts->execute([':email'=>$to2]);
      if($ts->rowCount()>0){
        $tr=$ts->fetch(PDO::FETCH_ASSOC);
        $toname=$tr['name']!=''?$tr['name']:$tr['business'];
        $mail->AddAddress($tr['email'],$toname);
      }else$mail->AddAddress($to2);
    }
  }else$mail->AddAddress($to);
  if($atts!=''){
    $attachments=explode(",",$atts);
    foreach($attachments as $attachment)$mail->addAttachment('../media/'.basename($attachment));
  }
  $mail->Subject=$subject;
  preg_match_all('/<img.*?>/',$body,$matches);
  if(isset($matches[0])){
    $i=1001;
    foreach($matches[0] as$img){
      $imgid='img'.($i++);
      preg_match('/src="(.*?)"/',$body,$m);
      if(!isset($m[1]))continue;
      $arr=parse_url($m[1]);
      if(!isset($arr['host'])||!isset($arr['path']))continue;
      $imgname=basename($m[1]);
      $mail->addEmbeddedImage('../media/'.$imgname,$imgid);
      $body=str_replace($img,'<img alt="" src="cid:'.$imgid.'" style="border:none"/>',$body);
    }
  }
  $mail->Body=$body;
  if($mail->Send()){
    $s=$db->prepare("INSERT IGNORE INTO `".$prefix."messages` (`folder`,`to_email`,`to_name`,`from_email`,`from_name`,`subject`,`status`,`notes_html`,`attachments`,`email_date`,`ti`) VALUES ('sent',:to_email,:to_name,:from_email,:from_name,:subject,'read',:notes_html,:attachments,:email_date,:ti)");
    $ti=time();
    $s->execute([
      ':to_email'=>$to,
      ':to_name'=>'',
      ':from_email'=>$from,
      ':from_name'=>'',
      ':subject'=>$subject,
      ':notes_html'=>$msgbody,
      ':attachments'=>$atts,
      ':email_date'=>$ti,
      ':ti'=>$ti
    ]);
  }
  if(!empty($mail->ErrorInfo)){
    echo'<script>window.top.window.toastr["error"](`'.$mail->ErrorInfo.'`);</script>';
    exit();
  }else echo'<script>window.top.window.location.href="'.ADMINURL.'messages/";</script>';
}
