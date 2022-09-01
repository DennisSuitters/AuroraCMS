<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Newletter
 * @package    core/newsletter.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
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
$theme=parse_ini_file(THEME.'/theme.ini',true);
$css=file_get_contents(THEME.'/css/newsletter.css');
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT `options`,`title`,`tags`,`notes` FROM `".$prefix."content` WHERE `id`=:id");
$s->execute([':id'=>$id]);
$news=$s->fetch(PDO::FETCH_ASSOC);
$u=$db->prepare("UPDATE `".$prefix."content` SET `status`=:status,`tis`=:tis WHERE `id`=:id");
$u->execute([
  ':status'=>'published',
  ':tis'=>time(),
  ':id'=>$id
]);
require'phpmailer/PHPMailer.php';
require'phpmailer/SMTP.php';
require'phpmailer/Exception.php';
if($config['email']!=''){
  $mail = new PHPMailer\PHPMailer\PHPMailer;
  $body=rawurldecode($news['notes']);
//  $body=preg_replace("[\]",'',$body);
  $mail->isSendmail();
  $mail->isHTML(true);
  $mail->SetFrom($config['email'],$config['business']);
  $mail->Subject=$news['title'];
  $mail->AltBody='To view this message, please use an HTML compatible email viewer! Or view online at '.URL.'newsletters/'.str_replace(' ','-',$news['title']);
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
  if($news['options'][8]==1){
    $tags=explode(",",$news['tags']);
    $tags_list=sprintf('"%s"',implode('","',$tags));
    $s=$db->prepare("SELECT DISTINCT `email`,`name`,`hash` FROM `".$prefix."subscribers` UNION SELECT DISTINCT `email`,`name`,`hash` FROM `".$prefix."login` WHERE `newsletter`=1 AND `tags` IN (".$tags_list.")");
    $s->execute();
  }else{
    $s=$db->prepare("SELECT DISTINCT `email`,`name`,`hash` FROM `".$prefix."subscribers` UNION SELECT DISTINCT `email`,`name`,`hash` FROM `".$prefix."login` WHERE `newsletter`=1");
    $s->execute();
  }
  $head='<!DOCTYPE html><head><style>'.$css.'</style></head><body>';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if(($sendCount % $betweenDelay)==0)sleep($sendDelay);
    $mail->AddAddress($r['email']);
    $optOut=$config['newslettersOptOutLayout'];
    $optOut=str_replace('{optOutLink}',URL.'newsletters/unsubscribe/'.$r['hash'],$optOut);
    $first=explode(' ',$r['name']);
    if($first[0]=='')$first=explode('@',$r['email']);
    $name=$first[0];
    $bodysend=str_replace('{name}',$name,$body);
    $mail->Body=$head.$body.$optOut.'</body></html>';
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
}else echo'<script>window.top.window.toastr("error")("No system Email has been set!");</script>';
