<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Question
 * @package    core/add_question.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
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
$ct=filter_input(INPUT_POST,'ct',FILTER_SANITIZE_STRING);
$a=filter_input(INPUT_POST,'a',FILTER_SANITIZE_NUMBER_INT);
$t=filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW);
if($t!=''){
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."module_questions` (`rid`,`type`,`check_answer`,`title`) VALUES (:rid,:ct,:a,:title)");
		$q->execute([
			':rid'=>$rid,
			':ct'=>$ct,
			':a'=>$a,
			':title'=>$t
		]);
		$iid=$db->lastInsertId();
		$q=$db->prepare("UPDATE `".$prefix."module_questions` SET `ord`=:ord WHERE `id`=:id");
		$q->execute([
			':id'=>$iid,
			':ord'=>$iid+1
		]);
		echo'<script>'.
			'window.top.window.$("#questions").append(`<li class="question mb-2" id="questions_'.$iid.'">'.
				'<div class="form-row">'.
					'<div class="input-text">'.ucwords($ct).'</div>'.
					'<div class="input-text">Answer <input type="checkbox"'.($a==1?' checked':'').' disabled></div>'.
					'<div class="input-text">Question:</div>'.
					'<input type="text" value="'.$t.'" readonly>'.
					'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$iid.'\',\'module_questions\');"><i class="i">trash</i></button>'.
					'<div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item" onclick="return false;"><i class="i">drag</i></div>'.
				'</div>'.
			'</li>`);'.
	'</script>';
}
