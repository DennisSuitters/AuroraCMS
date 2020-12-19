<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Subject
 * @package    core/add_subject.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
require'sanitise.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$sub=filter_input(INPUT_POST,'sub',FILTER_SANITIZE_STRING);
$eml=filter_input(INPUT_POST,'eml',FILTER_SANITIZE_STRING);
if($sub==''){
	echo'<script>window.top.window.toastr["error"]("Not all Fields were filled in!");</script>';
}else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`title`,`url`) VALUES ('subject',:title,:url)");
	$q->execute([
		':title'=>kses($sub,array()),
		':url'=>kses($eml,array())
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
		echo'<script>'.
					'window.top.window.$("#subjects").append(`<div id="l_'.$id.'" class="form-row mt-1">'.
						'<div class="input-text">Subject</div>'.
						'<input id="sub'.$id.'" name="da" type="text" value="'.$sub.'">'.
						'<div class="input-text">Email</div>'.
						'<input id="eml'.$id.'" name="da" type="text" value="'.$eml.'">'.
						'<form target="sp" action="core/purge.php">'.
							'<input name="id" type="hidden" value="'.$id.'">'.
							'<input name="t" type="hidden" value="choices">'.
							'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete">'.svg2('trash').'</button>'.
						'</form>'.
					'</div>`);'.
				'</script>';
	}else{
		echo'<script>window.top.window.toastr["error"]("There was an issue adding the Data!");</script>';
	}
}
