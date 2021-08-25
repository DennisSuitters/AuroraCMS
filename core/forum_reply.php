<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Comment
 * @package    core/add_comment.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
define('THEME','layout'.DS.$config['theme']);
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
$pid=isset($_POST['pid'])?filter_input(INPUT_POST,'pid',FILTER_SANITIZE_NUMBER_INT):0;
$uid=isset($_POST['uid'])?filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT):0;
$rank=isset($_POST['r'])?filter_input(INPUT_POST,'r',FILTER_SANITIZE_NUMBER_INT):0;
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):'';
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$ti=time();
if($da==''){
	echo'<script>';
  echo'window.top.window.$("#addreply").parent().find(".alert").remove();';
  if($da==''){
    echo'window.top.window.$("#addreply").prepend(`'.
      '<div class="alert alert-info text-center" role="alert">'.
        'The text area can not be empty.'.
      '</div>'.
    '`);';
  }
  echo'window.top.window.$("#forumbusy").removeClass("d-block");';
  echo'</script>';
}else{
	$s=$db->prepare("INSERT IGNORE INTO `".$prefix."forumPosts` (`rank`,`pid`,`uid`,`notes`,`ti`) VALUES (:rank,:pid,:uid,:notes,:ti)");
	$s->execute([
		':rank'=>$rank,
	  ':pid'=>$pid,
	  ':uid'=>$uid,
	  ':notes'=>$da,
	  ':ti'=>$ti
	]);
	$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
	$su->execute([':uid'=>$uid]);
	$ru=$su->fetch(PDO::FETCH_ASSOC);
	$sp=$db->prepare("SELECT COUNT(`id`) as 'cnt' FROM `".$prefix."forumPosts` WHERE `uid`=:uid");
	$sp->execute([':uid'=>$uid]);
	$rp=$sp->fetch(PDO::FETCH_ASSOC);
	echo'<script>'.
	  'window.top.window.$("#addreply").html(`<article class="card col-12 m-0 mb-1">'.
	    '<div class="row">'.
	      '<div class="col-sm p-3">'.
	      '<small class="text-muted">'.date($config['dateFormat'],$ti).'</small>'.
	      '<div class="p-3">'.
	        $da.
	      '</div>'.
	        ($ru['email_signature']!=''?'<hr>'.$ru['email_signature']:'').
	      '</div>'.
	      '<div class="col-sm-3 position-relative">'.
	        '<img src="'.(file_exists('../media/avatar/'.$ru['avatar'])?'media/avatar/'.$ru['avatar']:NOAVATAR).'" class="forum-avatar m-3" alt="'.($ru['name']==''?$ru['username']:$ru['name']).'">'.
	        '<small class="d-block">'.($ru['name']==''?$ru['username']:$ru['name']).'</small>'.
	        '<small class="d-block">'.ucwords(rank(str_replace('-',' ',$ru['rank']))).'</small>'.
	        '<small class="d-block">Posts: '.$rp['cnt'].'</small>'.
	        '<small class="d-block">Member since: '.date($config['dateFormat'],$ru['ti']).'</small>'.
	      '</div>'.
	    '</div>'.
	  '</article>`);'.
	'</script>';
}
