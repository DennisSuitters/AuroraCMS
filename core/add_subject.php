<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Subject
 * @package    core/add_subject.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
require'sanitise.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$sub=filter_input(INPUT_POST,'sub',FILTER_UNSAFE_RAW);
$eml=filter_input(INPUT_POST,'eml',FILTER_UNSAFE_RAW);
if($sub=='')echo'<script>window.top.window.toastr["error"]("Not all Fields were filled in!");</script>';
else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`title`,`url`) VALUES ('subject',:title,:url)");
	$q->execute([
		':title'=>kses($sub,array()),
		':url'=>kses($eml,array())
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
		echo'<script>'.
					'window.top.window.$("#subjects").append(`<div id="l_'.$id.'" class="row add-item">'.
						'<div class="col-12 col-md">'.
							'<div class="input-text">'.$sub.'</div>'.
						'</div>'.
						'<div class="col-12 col-md">'.
							'<div class="form-row">'.
								'<div class="input-text col-md">'.$eml.'</div>'.
								'<form target="sp" action="core/purge.php">'.
									'<input name="id" type="hidden" value="'.$id.'">'.
									'<input name="t" type="hidden" value="choices">'.
									'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
								'</form>'.
							'</div>'.
						'</div>'.
					'</div>`);'.
				'</script>';
	}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Data!");</script>';
}
