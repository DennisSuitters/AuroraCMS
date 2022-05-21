<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Brand Option
 * @package    core/add_brand.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$ci=isset($_POST['ci'])?filter_input(INPUT_POST,'ci',FILTER_UNSAFE_RAW):'';
if($ci!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."seo` (`contentType`,`notes`) VALUES ('seotips',:ci)");
  $s->execute([':ci'=>$ci]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#seotips").append(`'.
					'<div id="l_'.$id.'">'.
						'<div class="row">'.
							'<div class="form-text col-11">'.$ci.'</div>'.
							'<form class="col-1 text-right" target="sp" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$id.'">'.
								'<input name="t" type="hidden" value="seo">'.
								'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
							'</form>'.
						'</div>'.
						'<hr>'.
					'</div>'.
				'`);'.
				'window.top.window.toastr["success"]("SEO Tip added!");'.
			'</script>';
}else	echo'<script>window.top.window.toastr["error"]("No Text was entered!");</script>';
