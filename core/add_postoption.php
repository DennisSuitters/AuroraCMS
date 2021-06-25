<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Postage Option
 * @package    core/add_postoption.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):'';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
$v=isset($_POST['v'])?filter_input(INPUT_POST,'v',FILTER_SANITIZE_STRING):0;
if($t!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`type`,`title`,`value`) VALUES (0,'postoption',:c,:t,:v)");
  $s->execute([
		':c'=>$c,
		':t'=>$t,
		':v'=>$v
	]);
  if($v==0)$v='';
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#postoption").append(`<div id="l_'.$id.'" class="form-row mt-1">'.
					'<div class="input-text">Code</div>'.
					'<input name="service" type="text" value="'.$c.'" readonly>'.
					'<div class="input-text">Title</div>'.
					'<input name="service" type="text" value="'.$t.'" readonly>'.
					'<div class="input-text">Cost</div>'.
					'<input name="cost" type="text" value="'.$v.'" readonly>'.
					'<form target="sp" action="core/purge.php">'.
						'<input name="id" type="hidden" value="'.$id.'">'.
						'<input name="t" type="hidden" value="choices">'.
						'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete">'.svg2('trash').'</button>'.
					'</form>'.
				'</div>`);'.
			'</script>';
}
