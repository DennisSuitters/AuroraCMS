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
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$title=filter_var($_POST['brandtitle'],FILTER_UNSAFE_RAW);
$url=isset($_POST['brandurl'])?filter_input(INPUT_POST,'brandurl',FILTER_UNSAFE_RAW):'';
$icon=isset($_POST['brandicon'])?filter_input(INPUT_POST,'brandicon',FILTER_UNSAFE_RAW):'';
if($title!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`icon`,`url`,`title`) VALUES ('brand',:icon,:url,:title)");
  $s->execute([
		':url'=>$url,
		':icon'=>$icon,
		':title'=>$title
	]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#brand").append(`<div id="l_'.$id.'" class="row">'.
					'<div class="col-12 col-md-6">'.
						'<div class="form-row">'.
							'<input id="title'.$id.'" type="text" value="'.$title.'" readonly>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-5">'.
						'<div class="form-row">'.
							'<input id="url'.$id.'" type="text" value="'.$url.'" readonly>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-1">'.
						'<div class="form-row">'.
							($icon!=''?
								'<a data-fancybox="lightbox" href="'.$icon.'"><img id="thumbimage" src="'.$icon.'" alt="Thumbnail"></a>'
							:
								'<img id="thumbimage" src="core/images/noimage-sm.jpg" alt="No Image">'
							).
							'<form target="sp" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$id.'">'.
								'<input name="t" type="hidden" value="choices">'.
								'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
							'</form>'.
						'</div>'.
					'</div>'.
				'</div>`);'.
			'</script>';
}else echo'<script>window.top.window.toastr["error"]("A Title wasn`t entered");</script>';
