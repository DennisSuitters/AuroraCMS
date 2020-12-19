<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Newletter
 * @package    core/newsletter.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
define('THEME','../layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('ADMINURL',URL.$settings['system']['admin'].'/');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.'/theme.ini',true);
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT `title`,`notes` FROM `".$prefix."content` WHERE `id`=:id");
$s->execute([
  ':id'=>$id
]);
$news=$s->fetch(PDO::FETCH_ASSOC);
$u=$db->prepare("UPDATE `".$prefix."content` SET `status`=:status,`tis`=:tis WHERE `id`=:id");
$u->execute([
  ':status'=>'published',
  ':tis'=>time(),
  ':id'=>$id
]);
require'phpmailer/class.phpmailer.php';
if($config['email']!=''){
  $mail=new PHPMailer;
  $body=rawurldecode($news['notes']);
  $body=eregi_replace("[\]",'',$body);
  $mail->isSendmail();
  $mail->isHTML(true);
  $mail->SetFrom($config['email'],$config['business']);
  $mail->Subject=$news['title'];
  $mail->AltBody='To view this message, please use an HTML compatible email viewer!';
  if($config['newslettersEmbedImages'][0]==1){
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
        $mail->addEmbeddedImage('../media/'.$imgname,$imgid,$imgname);
        $body=str_replace($img,'<img alt="" src="cid:'.$imgid.'" style="border:none"/>',$body);
      }
    }
  }
  $betweenDelay=$config['newslettersSendMax']!=''||$config['newslettersSendMax']==0?$config['newslettersSendMax']:$betweenDelay=50;
  $sendCount=1;
  $sendDelay=$config['newslettersSendDelay']!=''||$config['newslettersSendDelay']==0?$config['newslettersSendDelay']:1;
  ignore_user_abort(true);
  set_time_limit(300);
  $s=$db->prepare("SELECT DISTINCT `email`,`hash` FROM `".$prefix."subscribers` UNION SELECT DISTINCT `email`,`hash` FROM `".$prefix."login` WHERE `newsletter`=1");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if(($sendCount % $betweenDelay)==0)sleep($sendDelay);
    $mail->AddAddress($r['email']);
    $optOut=$config['newslettersOptOutLayout'];
    $optOut=str_replace('{optOutLink}',URL.'newsletters/unsubscribe/'.$r['hash'],$optOut);
    $mail->Body=$body.$optOut;
    if($mail->Send()){
      $mail->clearAllRecipients();
      $sendCount++;
    }
  }
  if(!empty($mail->ErrorInfo)){
    echo'<script>'.
          'window.top.window.toastr("error")("'.$mail->ErrorInfo.'");'.
          'window.top.window.$("#block").css({"display":"none"});'.
        '</script>';
  }else{
    echo'<script>'.
      'window.top.window.toastr["success"]("Newsletters Sent Successfully!");'.
      'window.top.window.$("#block").css({"display":"none"})'.
    '</script>';
  }
}else
  echo'<script>window.top.window.toastr("error")("No system Email has been set!");</script>';
