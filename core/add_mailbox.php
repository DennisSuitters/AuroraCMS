<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Mailbox
 * @package    core/add_mailbox.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
define('ADMINNOAVATAR','core'.DS.'images'.DS.'libre-gui-noavatar.svg');
function svg($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$uid=isset($_POST['uid'])?filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT):'';
$type=$_POST['t'];
$port=isset($_POST['port'])?filter_input(INPUT_POST,'port',FILTER_SANITIZE_NUMBER_INT):'';
$flag=isset($_POST['f'])?filter_input(INPUT_POST,'f',FILTER_SANITIZE_STRING):'';
$url=isset($_POST['url'])?filter_input(INPUT_POST,'url',FILTER_SANITIZE_STRING):'';
$mailusr=isset($_POST['mailusr'])?filter_input(INPUT_POST,'mailusr',FILTER_SANITIZE_STRING):'';
$mailpwd=isset($_POST['mailpwd'])?filter_input(INPUT_POST,'mailpwd',FILTER_SANITIZE_STRING):'';
if($port!=''&&$url!=''&&$mailusr!=''&&$mailpwd!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`uid`,`contentType`,`type`,`port`,`flag`,`url`,`username`,`password`) VALUES (:uid,'mailbox',:type,:port,:flag,:url,:username,:password)");
  $s->execute([
		':uid'=>$uid,
		':type'=>$type,
		':port'=>$port,
		':flag'=>$flag,
		':url'=>$url,
		':username'=>$mailusr,
		':password'=>$mailpwd
	]);
  $id=$db->lastInsertId();
	echo'<script>window.top.window.$("#mailboxes").append(\'<div id="l'.$id.'" class="form-row mt-1"><div class="input-text">Type</div><input type="text" value="'.strtoupper($type).'" readonly><div class="input-text">Port</div><input type="text" value="'.$port.'" readonly><div class="input-text">Flag</div><input type="text" value="'.$flag.'" readonly><div class="input-text">Server</div><input type="text" value="'.$url.'" readonly><div class="input-text">Username</div><input type="text" value="'.$mailusr.'" readonly><div class="input-text">Password</div><input type="text" value="'.$mailpwd.'" readonly><form target="sp" action="core/purge.php"><input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="t" value="choices"><button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg('trash').'</button></form></div>\');</script>';
}else
	echo'<script>window.top.window.toastr["error"]("Not all fields were entered!");</script>';
