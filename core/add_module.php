<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Module
 * @package    core/add_module.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
	if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
	if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$t=filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW);
if($t!=''){
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."modules` (`rid`,`title`,`ti`) VALUES (:rid,:t,:ti)");
		$q->execute([
			':rid'=>$rid,
			':t'=>$t,
			':ti'=>time()
		]);
		$iid=$db->lastInsertId();
		$q=$db->prepare("UPDATE `".$prefix."modules` SET `ord`=:ord WHERE `id`=:id");
		$q->execute([
			':id'=>$iid,
			':ord'=>$iid+1
		]);
		echo'<script>'.
			'window.top.window.$("#modules").append(`<li class="module mb-2" id="modules_'.$iid.'">'.
				'<div class="form-row">'.
					'<input type="text" value="'.$t.'" readonly>'.
					'<a href="'.URL.$settings['system']['admin'].'/course/module/'.$iid.'" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
					'<button data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$iid.'\',\'modules\');"><i class="i">trash</i></button>'.
					'<div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item" onclick="return false;"><i class="i">drag</i></div>'.
				'</div>'.
			'</li>`);'.
	'</script>';
}
