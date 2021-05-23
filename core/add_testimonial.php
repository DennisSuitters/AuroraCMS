<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Testimonial
 * @package    core/add_testimonial.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Add Parsing of Google reCaptcha.
 * @changes    v0.1.2 Add parsing time duration field, and hidden encoded name field.
 * @changes    v0.1.2 Move adding to Blacklist SQL to end reducing to only one instance of the same code.
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
    if($timecheck < $config['formMinTime'])
      $not=['spammer'=>true,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Woah, too quick, blacklisted!','reason'=>'Testimonial Form filled in too quickly! ('.$config['formMinTime'].' seconds)'];
  }
  if($config['formMaxTime']!=0){
    if($timecheck > ($config['formMaxTime']*60))
      $not=['spammer'=>true,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Way too long to fill out a form!','reason'=>'Testimonial Form Exceeded time allowed! ('.$config['formMaxTime'].' minutes)'];
  }
}
if($config['reCaptchaServer']!=''){
  if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha)
      $not=['spammer'=>false,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'reCaptcha failed, maybe the setup is wrong!','reason'=>''];
    else{
      $responseKeys=json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($config['reCaptchaServer']).'&response='.urlencode($captcha)),true);
      if($responseKeys["success"])
        $not=['spammer'=>true,'target'=>'','element'=>'','action'=>'none','class'=>'','text'=>'','reason'=>'Testimonial Form reCaptcha Failed'];
    }
  }
}
if($not['spammer']==false){
  $act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
  if($act=='add_test'){
    if($config['php_options'][3]==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
      $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
      if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)
        $not=['spammer'=>true,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Testimonial Form found Blacklisted IP via Project Honey Pot'];
    }
    if($_POST['fullname'.$hash]==''){
      $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
      $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
      $business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
      $review=filter_input(INPUT_POST,'review',FILTER_SANITIZE_STRING);
      $rating=filter_input(INPUT_POST,'rating',FILTER_SANITIZE_NUMBER_INT);
      $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
      if($config['spamfilter'][0]==1&&$not['spammer']==false&&$ip!='127.0.0.1'){
        $filter=new SpamFilter();
        $result=$filter->check_email($email);
        if($result)
          $not=['spammer'=>true,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Testimonial Form, Spam Detected via Form Field Data.'];
        $result=$filter->check_text($name.' '.$business.' '.$review);
        if($result)
          $not=['spammer'=>true,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Testimonial Form, Spam Detected via Form Field Data.'];
      }
      if($not['spammer']==false){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
          $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`contentType`,`ip`,`title`,`email`,`name`,`business`,`notes`,`status`,`rating`,`ti`) VALUES ('testimonials',:ip,:title,:email,:name,:business,:notes,'unapproved',:rating,:ti)");
          $q->execute([
            ':ip'=>$ip,
            ':title'=>$name.' - '.$business,
            ':email'=>$email,
            ':name'=>$name,
            ':business'=>$business,
            ':notes'=>$review,
            ':rating'=>$rating,
            ':ti'=>time()
          ]);
          $e=$db->errorInfo();
          if(is_null($e[2]))
            $not=['spammer'=>false,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Thank you for your Testimonial, it will be appear once an Administrator Approves it.','reason'=>''];
          else
            $not=['scammer'=>false,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was an Issue adding your Testimonial!','reason'=>''];
        }else
          $not=['scammer'=>false,'target'=>'testimonialemail','element'=>'div','action'=>'after','class'=>'not alert alert-info','text'=>'The Email entered is not valid!','reason'=>''];
      }
    }else
      $not=['scam'=>true,'target'=>'testimonial','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text','Spammers and Email Harvesters not welcome.','reason'=>'Testimonial Form Honey Pot Field was populated with data, suspected Bot'];
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
