<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Category Option
 * @package    core/add_category.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$icon=filter_input(INPUT_POST,'icon',FILTER_UNSAFE_RAW);
$ct=filter_input(INPUT_POST,'ct',FILTER_UNSAFE_RAW);
$cat=filter_input(INPUT_POST,'cat',FILTER_UNSAFE_RAW);
if($cat!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`icon`,`url`,`title`) VALUES ('category',:icon,:url,:title)");
  $s->execute([
		':icon'=>$icon,
		':url'=>$ct,
		':title'=>$cat
	]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#category").append(`<div id="l_'.$id.'" class="row add-item">'.
					'<div class="col-12 col-md">'.
						'<div class="input-text">'.$cat.'</div>'.
					'</div>'.
					'<div class="col-12 col-md">'.
						'<div class="input-text">'.$ct.'</div>'.
					'</div>'.
					'<div class="col-12 col-md-1">'.
						'<div class="form-row">'.
							($icon!=''?
								'<a data-fancybox="lightbox" href="'.$icon.'"><img src="'.$icon.'" alt="Thumbnail"></a>'
							:
								'<img src="core/images/noimage-sm.jpg" alt="No Image">'
							).
							'<form target="sp" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$id.'">'.
								'<input name="t" type="hidden" value="choices">'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
							'</form>'.
						'</div>'.
					'</div>'.
				'</div>`);'.
			'</script>';
}else
  echo'<script>window.top.window.toastr["error"]("The Category field must contain data!");</script>';
