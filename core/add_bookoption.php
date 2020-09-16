<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Booking Option
 * @package    core/add_bookoption.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
$type=isset($_POST['type'])?filter_input(INPUT_POST,'type',FILTER_SANITIZE_STRING):0;
if($t!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`title`,`type`,`ti`) VALUES (0,'bookoption',:t,:type,:ti)");
  $s->execute([
		':t'=>$t,
		':type'=>$type,
		':ti'=>time()
	]);
  $id=$db->lastInsertId();
echo'<script>'.
  'window.top.window.$("#bookoption").append(`<div id="l_'.$id.'" class="form-group row">'.
		'<div class="input-group col">'.
			'<span class="input-group-text">Title</span>'.
			'<input type="text" class="form-control" name="service" value="'.$t.'" readonly>'.
			'<span class="input-group-text">Type</span>'.
			'<input type="text" class="form-control" name="cost" value="'.($type=='checkbox'?'Checkbox':'Text Input').'" readonly>'.
			'<div class="input-group-append">'.
				'<form target="sp" action="core/purge.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete"" aria-label="Delete">'.svg2('trash').'</button>'.
				'</form>'.
			'</div>'.
		'</div>'.
	'</div>`);'.
'</script>';
}
