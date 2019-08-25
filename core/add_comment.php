<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Comment
 * @package    core/add_comment.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Add Reason to Blacklist
 */
$getcfg=true;
require'db.php';
include'class.projecthoneypot.php';
include'class.spamfilter.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$error=0;
$notification=$blacklisted='';
$ti=time();
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$spam=FALSE;
if($act=='add_comment'){
  if($config['php_options']{3}==1&&$config['php_APIkey']!=''&&$ip!='127.0.0.1'){
    $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
    if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1){
      $blacklisted=$theme['settings']['blacklist'];
			$sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
			$sc->execute([':ip'=>$ip]);
			if($sc->rowCount()<1){
	      $s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,reason,ti) VALUES (:ip,:oti,:reason,:ti)");
	      $s->execute([
          ':ip'=>$ip,
          ':oti'=>$ti,
          ':reason'=>'Comments Form found Blacklisted IP (PHP)',
          ':ti'=>$ti
        ]);
			}
    }
  }
  if($_POST['emailtrap']=='none'){
    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
    $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
    $contentType=filter_input(INPUT_POST,'ct',FILTER_SANITIZE_STRING);
    $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
    $notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
    if($config['spamfilter']{0}==1&&$spam==FALSE&&$ip!='127.0.0.1'){
      $filter=new SpamFilter();
      $result=$filter->check_email($email);
      if($result){
        $blacklisted=$theme['settings']['blacklist'];
        $spam=TRUE;
      }
      $result=$filter->check_text($name.' '.$notes);
      if($result){
        $blacklisted=$theme['settings']['blacklist'];
        $spam=TRUE;
      }
      if($config['spamfilter']{1}==1&&$spam==TRUE&&$ip!='127.0.0.1'){
        $sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
        $sc->execute([':ip'=>$ip]);
        if($sc->rowCount()<1){
          $s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,reason,ti) VALUES (:ip,:oti,:reason,:ti)");
          $s->execute([
            ':ip'=>$ip,
            ':oti'=>$ti,
            ':reason'=>'Spam detected from Input via Comments Form',
            ':ti'=>$ti
          ]);
        }
      }
    }
    if($spam==FALSE){
      if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("SELECT id,name,email,avatar,gravatar FROM `".$prefix."login` WHERE email=:email");
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
        $q=$db->prepare("INSERT INTO `".$prefix."comments` (contentType,rid,uid,ip,avatar,gravatar,email,name,notes,status,ti) VALUES (:contentType,:rid,:uid,:ip,:avatar,:gravatar,:email,:name,:notes,:status,:ti)");
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
            $q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
            $q->execute([':id'=>$rid]);
            $r=$q->fetch(PDO::FETCH_ASSOC);
            require'class.phpmailer.php';
            $mail=new PHPMailer;
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
            $mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));;
            if($mail->Send())
              $notification=$theme['settings']['comment_success'];
            else
              $notification=$theme['settings']['comment_error'];
          }
        }else
          $notification=$theme['settings']['comment_error'];
      }
    }
  }
  echo$blacklisted.$notification;
}
