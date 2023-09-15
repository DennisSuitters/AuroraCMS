<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Comment
 * @package    core/add_comment.php
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
    if($timecheck < $config['formMinTime'])
      $not=['spammer'=>true,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-info','text'=>'Woah, too quick, blacklisted!','reason'=>'Comment Form filled in too quickly! ('.$config['formMinTime'].' seconds)'];
  }
  if($config['formMaxTime']!=0){
    if($timecheck > ($config['formMaxTime']*60))$not=['spammer'=>true,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-info','text'=>'Way too long to fill out a form!','reason'=>'Comment Form Exceeded time allowed! ('.$config['formMaxTime'].' minutes)'];
  }
}
if($config['reCaptchaServer']!=''){
  if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha)$not=['spammer'=>true,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'reCaptcha failed, maybe the setup is wrong!','reason'=>''];
    else{
      $responseKeys=json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($config['reCaptchaServer']).'&response='.urlencode($captcha)),true);
      if($responseKeys["success"])
        $not=['spammer'=>true,'target'=>'','element'=>'','action'=>'none','class'=>'','text'=>'','reason'=>'Comment Form reCaptcha Failed'];
    }
  }
}
if($not['spammer']==false){
  $act=filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW);
  if($act=='add_comment'){
    if($config['php_options'][3]==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
      $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
      if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1)$not=['spammer'=>true,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'Your IP is classified as Malicious and has been added to our Blacklist, for more information visit the Project Honey Pot website.','reason'=>'Comment Form found Blacklisted IP via Project Honey Pot'];
    }
    if($_POST['fullname'.$hash]==''){
      $email=filter_input(INPUT_POST,'email',FILTER_UNSAFE_RAW);
      $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
      $contentType=filter_input(INPUT_POST,'ct',FILTER_UNSAFE_RAW);
      $name=filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW);
      $notes=filter_input(INPUT_POST,'notes',FILTER_UNSAFE_RAW);
      if($config['spamfilter']==1&&$not['spammer']==false&&$ip!='127.0.0.1'){
        $filter=new SpamFilter();
        $result=$filter->check_email($email);
        if($result)$not=['spammer'=>true,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Comment Form, Spam Detected via Form Field Data.'];
        $result=$filter->check_text($name.' '.$notes);
        if($result)$not=['spammer'=>true,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'The data entered into the Form fields has been detected by our Filters as Spammy.','reason'=>'Comment Form, Spam Detected via Form Field Data.'];
      }
      if($not['spammer']==false&&$email!=''){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
          $q=$db->prepare("SELECT `id`,`name`,`email`,`avatar`,`gravatar` FROM `".$prefix."login` WHERE email=:email");
          $q->execute([':email'=>$email]);
          $u=$q->fetch(PDO::FETCH_ASSOC);
          if($u['email']==''){
            $u=[
              'id'=>'0',
              'name'=>$name,
              'email'=>$email,
              'avatar'=>'',
              'gravatar'=>''
            ];
          }
          $q=$db->prepare("INSERT IGNORE INTO `".$prefix."comments` (`contentType`,`rid`,`uid`,`ip`,`avatar`,`gravatar`,`email`,`name`,`notes`,`status`,`ti`) VALUES (:contentType,:rid,:uid,:ip,:avatar,:gravatar,:email,:name,:notes,:status,:ti)");
          $q->execute([
            ':contentType'=>$contentType,
            ':rid'=>$rid,
            ':uid'=>$u['id'],
            ':ip'=>$ip,
            ':avatar'=>$u['avatar'],
            ':gravatar'=>$u['gravatar'],
            ':email'=>$u['email'],
            ':name'=>$u['name'],
            ':notes'=>$notes,
            ':status'=>'unapproved',
            ':ti'=>$ti
          ]);
          $id=$db->lastInsertId();
          $e=$db->errorInfo();
          if(is_null($e[2])){
            if($config['email']!=''){
              $q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
              $q->execute([':id'=>$rid]);
              $r=$q->fetch(PDO::FETCH_ASSOC);
              require'phpmailer/PHPMailer.php';
              require'phpmailer/SMTP.php';
              require'phpmailer/Exception.php';
              $mail = new PHPMailer\PHPMailer\PHPMailer;
              $mail->isSendmail();
              $mail->SetFrom($email,$name);
              $toname=$config['email'];
              $mail->AddAddress($config['email']);
              $mail->IsHTML(true);
              $mail->Subject='Comment on '.ucfirst($r['contentType']).': '.$r['title'];
              $msg='A comment was made on '.ucfirst($r['contentType']).': '.$r['title'].
                   'Name: '.$name.'<br />'.
                   'Email: '.$email.'<br />'.
                   'Comment: '.$notes;
              $mail->Body=$msg;
              $mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
              if($mail->Send())$not=['spammer'=>false,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Comment will be Appear once Approved.','reason'=>''];
              else$not=['spammer'=>false,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was an Issue adding your Comment.','reason'=>''];
            }else$not=['spammer'=>false,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-success','text'=>'Comment will be Appear once Approved.','reason'=>''];
          }else$not=['spammer'=>false,'target'=>'comment','element'=>'div','action'=>'replace','class'=>'not alert alert-danger','text'=>'There was an Issue adding your Comment.','reason'=>''];
        }
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
