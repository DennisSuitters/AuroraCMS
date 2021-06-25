<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Login
 * @package    core/login.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!isset($act))$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
if($act=='logout'){
  $_SESSION['loggedin']=false;
  $_SESSION['rank']=0;
  $params=session_get_cookie_params();
  setcookie(session_name(),'',time()-42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
  session_destroy();
}elseif($act=='login'||(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)){
  $username=isset($_POST['username'])?filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING):$_SESSION['username'];
  $password=isset($_POST['password'])?filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING):$_SESSION['password'];
  $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `username`=:username AND `activate`='' AND `active`='1' LIMIT 1");
  $q->execute([':username'=>$username]);
  $user=$q->fetch(PDO::FETCH_ASSOC);
  if($user['id']!=0){
    if(password_verify($password,$user['password'])){
      $_SESSION['username']=$user['username'];
      $_SESSION['password']=$password;
      $_SESSION['uid']=$user['id'];
      $_SESSION['rank']=$user['rank'];
      $_SESSION['options']=$user['options'];
      $_SESSION['loggedin']=true;
      date_default_timezone_set($user['timezone']=='default'?$config['timezone']:$user['timezone']);
    }else{
      $_SESSION['loggedin']=false;
      $_SESSION['rank']=0;
      $_SESSION['options']=0;
    }
  }else{
    $_SESSION['loggedin']=false;
    $_SESSION['rank']=0;
    $_SESSION['options']=0;
  }
}else{
  $_SESSION['loggedin']=false;
  $_SESSION['rank']=0;
  $_SESSION['options']=0;
}
if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
  $q=$db->prepare("UPDATE `".$prefix."login` SET `lti`=:lti,`userAgent`=:userAgent,`userIP`=:userIP WHERE `id`=:id");
  $q->execute([
    ':lti'=>time(),
    ':id'=>$_SESSION['uid'],
    ':userAgent'=>$_SERVER['HTTP_USER_AGENT'],
    ':userIP'=>isset($_SERVER['REMOTE_ADDR'])?($_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR']):'127.0.0.1'
  ]);
}
