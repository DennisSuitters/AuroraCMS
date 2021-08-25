<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Forum Post
 * @package    core/forum_post.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.9
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
define('THEME','layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
if(file_exists(THEME.'/images/noavatar-md.png'))define('NOAVATAR',THEME.'/images/noavatar-md.png');
elseif(file_exists(THEME.'/images/noavatar-md.gif'))define('NOAVATAR',THEME.'/images/noavatar-md.gif');
elseif(file_exists(THEME.'/images/noavatar.jpg'))define('NOAVATAR',THEME.'/images/noavatar.jpg');
else define('NOAVATAR','core/images/noavatar.jpg');
define('ADMINNOAVATAR','core/images/noavatar.jpg');
function rank($txt){
	if($txt==0)return'visitor';
	if($txt==100)return'subscriber';
	if($txt==200)return'member';
	if($txt==210)return'member-silver';
	if($txt==220)return'member-bronze';
	if($txt==230)return'member-gold';
	if($txt==240)return'member-platinum';
	if($txt==300)return'client';
	if($txt==310)return'wholesale-silver';
	if($txt==320)return'wholesale-bronze';
	if($txt==330)return'wholesale-gold';
	if($txt==340)return'wholesale-platinum';
	if($txt==400)return'contributor';
	if($txt==500)return'author';
	if($txt==600)return'editor';
	if($txt==700)return'moderator';
	if($txt==800)return'manager';
	if($txt==900)return'administrator';
	if($txt==1000)return'developer';
}
$cid=isset($_POST['cid'])?filter_input(INPUT_POST,'cid',FILTER_SANITIZE_NUMBER_INT):0;
$tid=isset($_POST['tid'])?filter_input(INPUT_POST,'tid',FILTER_SANITIZE_NUMBER_INT):0;
$uid=isset($_POST['uid'])?filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT):0;
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
$rank=isset($_POST['r'])?filter_input(INPUT_POST,'r',FILTER_SANITIZE_NUMBER_INT):0;
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):'';
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
if($t==''||$da==''){
  echo'<script>';
  echo'window.top.window.$("#newpost").parent().find(".alert").remove();';
  if($t==''){
    echo'window.top.window.$("#newpost").prepend(`'.
      '<div class="alert alert-info text-center" role="alert">'.
        'A title was not entered.'.
      '</div>'.
    '`);';
  }
  if($da==''){
    echo'window.top.window.$("#newpost").prepend(`'.
      '<div class="alert alert-info text-center" role="alert">'.
        'The text area can not be empty.'.
      '</div>'.
    '`);';
  }
  echo'window.top.window.$("#forumbusy").removeClass("d-block");';
  echo'</script>';
}else{
  $ti=time();
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."forumPosts` (`rank`,`cid`,`tid`,`pid`,`uid`,`title`,`notes`,`ti`) VALUES (:rank,:cid,:tid,:pid,:uid,:title,:notes,:ti)");
  $s->execute([
    ':rank'=>$rank,
  	':cid'=>$cid,
  	':tid'=>$tid,
    ':pid'=>0,
    ':uid'=>$uid,
  	':title'=>$t,
    ':notes'=>$da,
    ':ti'=>$ti
  ]);
  $id=$db->lastInsertId();
  echo'<script>'.
    'window.top.window.$("#newpost").html(`'.
  		'<div class="alert alert-success text-center" role="alert">'.
  			'Your Post has been added.<br>'.
  			'This page will redirect to your post, or you can click <a href="'.URL.'forum?cid='.$cid.'&tid='.$tid.'&pid='.$id.'">here</a> to view it.'.
  		'</div>'.
  	'`);'.
  //	'window.parent.window.location.href = "'.URL.'forum?cid='.$cid.'&tid='.$tis.'&pid='.$id.'";'.
  //	'window.top.window.setTimeout(function(){window.top.window.location.href = "'.URL.'forum?cid='.$cid.'&tid='.$tis.'&pid='.$id.'";},5000);'.
  '</script>';
}
