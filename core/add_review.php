<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Review Item
 * @package    core/add_review.php
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
    if($timecheck < $config['formMinTime'])$not=['spammer'=>true,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Woah, too quick, blacklisted!','reason'=>'Review Form filled in too quickly! ('.$config['formMinTime'].' seconds)'];
  }
  if($config['formMaxTime']!=0){
    if($timecheck > ($config['formMaxTime']*60))$not=['spammer'=>true,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Way too long to fill out a form!','reason'=>'Review Form Exceeded time allowed! ('.$config['formMaxTime'].' minutes)'];
  }
}
if($config['reCaptchaServer']!=''){
  if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha)$not=['spammer'=>false,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'reCaptcha failed, maybe the setup is wrong!','reason'=>''];
    else{
      $responseKeys=json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($config['reCaptchaServer']).'&response='.urlencode($captcha)),true);
      if($responseKeys["success"])$not=['spammer'=>true,'target'=>'','element'=>'','action'=>'none','alert'=>'','text'=>'','reason'=>'Review Form reCaptcha Failed'];
    }
  }
}
if($not['spammer']==false){
  if($config['php_options'][3]==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
    $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
    if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)$not=['spammer'=>true,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Review Form found Blacklisted IP via Project Honey Pot'];
  }
  if($_POST['fullname'.$hash]==''){
    $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    $rating=filter_input(INPUT_POST,'rating',FILTER_SANITIZE_NUMBER_INT);
    $email=filter_input(INPUT_POST,'email',FILTER_UNSAFE_RAW);
    $name=filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW);
    $review=filter_input(INPUT_POST,'review',FILTER_UNSAFE_RAW);
    if($config['spamfilter']==1&&$not['spammer']==false&&$ip!='127.0.0.1'){
      $filter=new SpamFilter();
      $result=$filter->check_email($email);
      if($result)$not=['spammer'=>true,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Review Form, Spam Detected via Form Field Data.'];
      $result=$filter->check_text($name.' '.$review);
      if($result)$not=['spammer'=>true,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Review Form, Spam Detected via Form Field Data.'];
    }
    if($not['spammer']==false){
      if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("INSERT IGNORE INTO `".$prefix."comments` (`contentType`,`rid`,`ip`,`email`,`name`,`notes`,`cid`,`status`,`ti`) VALUES ('review',:rid,:ip,:email,:name,:notes,:cid,'unapproved',:ti)");
        $q->execute([
          ':rid'=>$id,
          ':ip'=>$ip,
          ':email'=>$email,
          ':name'=>$name,
          ':notes'=>$review,
          ':cid'=>$rating,
          ':ti'=>time()
        ]);
        $e=$db->errorInfo();
        if(is_null($e[2]))$not=['spammer'=>false,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Thank you for your Review, it will be displayed once it has been Approved.','reason'=>''];
        else$not=['spammer'=>false,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-dangeri','text'=>'Spammers and Form Data Harvesters not welcome.','release'=>''];
      }
    }else$not=['spammer'=>true,'target'=>'review','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Spammers and Form Data Harvesters not welcome.','reason'=>'Review Form, Filter found spammy data!'];
  }
  echo(isset($not)?$not['target'].'|'.$not['element'].'|'.$not['action'].'|'.$not['class'].'|'.$not['text']:'');
}
if($not['spammer']==true&&$not['reason']!=''){
  $sc=$db->prepare("SELECT `id` FROM `".$prefix."iplist` WHERE `ip`=:ip");
  $sc->execute([':ip'=>$ip]);
  if($sc->rowCount()<1){
    $s=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`reason`,`ti`) VALUES (:ip,:oti,:reason,:ti)");
    $s->execute([':ip'=>$ip,':oti'=>$ti,':reason'=>$not['reason'],':ti'=>$ti]);
  }
}
