<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Brand Option
 * @package    core/add_brand.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
require'sanitise.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$user=filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
$icon=filter_input(INPUT_POST,'icon',FILTER_UNSAFE_RAW);
$url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
if(filter_var($url,FILTER_VALIDATE_URL)){
	if($icon=='none'||$url=='')echo'<script>window.top.window.toastr["error"]("Not all Fields were filled in!");</script>';
	else{
		$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`uid`,`contentType`,`icon`,`url`) VALUES (:uid,'social',:icon,:url)");
		$q->execute([
			':uid'=>kses($user,array()),
			':icon'=>$icon,
			':url'=>kses($url,array())
		]);
		$id=$db->lastInsertId();
		$e=$db->errorInfo();
		if(is_null($e[2])){
			echo'<script>'.
						'window.top.window.$("#social").append(`<div id="l_'.$id.'" class="row mt-1">'.
							'<div class="col-12 col-md-3">'.
								'<div class="form-row">'.
									'<div class="input-text col-12" data-tooltip="tooltip" aria-label="'.ucfirst($icon).'"><i class="i i-social i-2x social-'.$icon.'">social-'.$icon.'</i>&nbsp;&nbsp;'.ucfirst($icon).'</div>'.
								'</div>'.
							'</div>'.
							'<div class="col-12 col-md-8">'.
								'<div class="form-row">'.
									'<input type="text" value="'.$url.'" readonly>'.
								'</div>'.
							'</div>'.
							'<div class="col-12 col-md-1">'.
								'<div class="form-row">'.
									'<form target="sp" action="core/purge.php">'.
										'<input name="id" type="hidden" value="'.$id.'">'.
										'<input name="t" type="hidden" value="choices">'.
										'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
									'</form>'.
								'</div>'.
							'</div>'.
						'</div>`);'.
					'</script>';
		}
	}
}
