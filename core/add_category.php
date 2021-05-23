<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Category Option
 * @package    core/add_category.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Tidy up code and reduce footprint.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$cat=isset($_POST['cat'])?filter_input(INPUT_POST['cat'],FILTER_SANITIZE_STRING):'';
$ct=isset($_POST['ct'])?filter_input(INPUT_POST,'ct',FILTER_SANITIZE_STRING):'';
$icon=isset($_POST['icon'])?filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING):'';
if($cat!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`icon`,`url`,`title`) VALUES ('category',:icon,:c,:t)");
  $s->execute([
		':c'=>$ct,
		':icon'=>$icon,
		':t'=>$cat
	]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#category").append(`<div id="l_'.$id.'" class="row">'.
					'<div class="col-12 col-md-6">'.
						'<div class="form-row">'.
							'<input type="text" value="'.$cat.'" readonly>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-5">'.
						'<div class="form-row">'.
							'<input id="ct'.$id.'" type="text" value="'.$ct.'" readonly>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-1">'.
						'<div class="form-row">'.
							($icon!=''?
								'<a data-fancybox="lightbox" href="'.$icon.'"><img src="'.$icon.'" alt="Thumbnail"></a>'
							:
								'<img src="core/images/noimage-sm.jpg" alt="No Image">'.
							).
							'<form target="sp" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$id.'">'.
								'<input name="t" type="hidden" value="choices">'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
							'</form>'.
						'</div>'.
						'</div>'.
				'</div>`);'.
			'</script>';
}
