<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Mailbox
 * @package    core/add_mailbox.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
define('ADMINNOAVATAR','core'.DS.'images'.DS.'libre-gui-noavatar.svg');
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
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
echo'<script>'.
  'window.top.window.$("#mailboxes").append(\'<div id="l'.$id.'" class="form-group row">'.
		'<div class="input-group">'.
			'<label for="type'.$id.'" class="input-group-text">Type</label>'.
			'<input type="text" id="type'.$id.'" class="form-control" value="'.strtoupper($type).'" readonly>'.
			'<label for="port'.$id.'" class="input-group-text">Port</label>'.
			'<input type="text" id="port'.$id.'" class="form-control" value="'.$port.'" readonly>'.
			'<label for="flag'.$id.'" class="input-group-text">Flag</label>'.
			'<input type="text" id="flag'.$id.'" class="form-control" value="'.$flag.'" readonly>'.
		'</div>'.
		'<div class="input-group">'.
			'<label for="url'.$id.'" class="input-group-text">Server</label>'.
			'<input type="text" id="url'.$id.'" class="form-control" value="'.$url.'" readonly>'.
			'<label for="mailusr'.$id.'" class="input-group-text">Username</label>'.
			'<input type="text" id="mailusr'.$id.'" class="form-control" value="'.$mailusr.'" readonly>'.
			'<label for="mailpwd'.$id.'" class="input-group-text">Password</label>'.
			'<input type="text" id="mailpwd'.$id.'" class="form-control" value="'.$mailpwd.'" readonly>'.
			'<div class="input-group-append">'.
				'<form target="sp" action="core/purge.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
				'</form>'.
			'</div>'.
		'</div>'.
	'</div>\');'.
'</script>';
}
