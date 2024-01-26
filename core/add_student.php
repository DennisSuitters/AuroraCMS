<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Course Student
 * @package    core/add_student.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
function rank($txt){
	if($txt==0)return'visitor';
	if($txt==100)return'subscriber';
	if($txt==200)return'member';
	if($txt==210)return'member-silver';
	if($txt==220)return'member-bronze';
	if($txt==230)return'member-gold';
	if($txt==240)return'member-platinum';
	if($txt==300)return'client';
	if($txt==310)return'wholesale';
	if($txt==320)return'wholesale-bronze';
	if($txt==330)return'wholesale-silver';
	if($txt==340)return'wholesale-gold';
	if($txt==350)return'wholesale-platinum';
	if($txt==400)return'contributor';
	if($txt==500)return'author';
	if($txt==600)return'editor';
	if($txt==700)return'moderator';
	if($txt==800)return'manager';
	if($txt==900)return'administrator';
	if($txt==1000)return'developer';
}
$ti=time();
$cid=filter_input(INPUT_POST,'cid',FILTER_SANITIZE_NUMBER_INT);
$uid=filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT);
if($uid!=0){
  $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
  $sc->execute([':id'=>$cid]);
  $rc=$sc->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([':id'=>$uid]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."courseTrack` (`rid`,`uid`,`complete`,`progress`,`attempts`,`score`,`ti`) VALUES (:rid,:uid,'',0,:attempts,0,:ti)");
  $s->execute([
    ':rid'=>$cid,
    ':uid'=>$uid,
    ':attempts'=>$rc['attempts'],
    ':ti'=>$ti
  ]);
  $id=$db->lastInsertId();
  $avatar='core/images/noavatar.jpg';
  if($ru['avatar']!=''&&file_exists('../media/avatar/'.basename($ru['avatar'])))$avatar='media/avatar/'.basename($ru['avatar']);
  elseif($ru['gravatar']!='')$avatar=$ru['gravatar'];
   echo'<script>'.
    'window.top.window.$("#students").append(`<article id="student_'.$id.'" class="card mx-2 mt-3 mb-0 overflow-visible card-list item add-item">'.
      '<div class="card-image overflow-visible">'.
        '<img src="'.$avatar.'" alt="" style="max-width:92px;">'.
        '<span class="status badger badge-'.rank($ru['rank']).'">'.ucwords(str_replace('-',' ',rank($ru['rank']))).'</span>'.
      '</div>'.
      '<div class="card-header overflow-visible pt-2 line-clamp">'.
        $ru['username'].':'.$ru['name'].'<br><br>'.
        'Not Started'.
      '</div>'.
      '<div class="card-footer">'.
        '<div id="controls_'.$id.'">'.
          '<div class="btn-toolbar float-right" role="toolbar">'.
            '<div class="btn-group" role="group">'.
              '<button class="purge" id="purge'.$id.'" data-tooltip="tooltip" aria-label="Purge" onclick="purge(\''.$id.'\',\'courseTrack\');"><i class="i">trash</i></button>'.
            '</div>'.
          '</div>'.
        '</div>'.
      '</div>'.
		'</article>`);'.
	'</script>';
}else
  echo'<script>window.top.window.toastr["error"](`You didn\'t select an Account to add as a Student!`);</script>';
