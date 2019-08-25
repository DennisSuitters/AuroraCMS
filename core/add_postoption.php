<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Postage Option
 * @package    core/add_postoption.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
$v=isset($_POST['v'])?filter_input(INPUT_POST,'v',FILTER_SANITIZE_STRING):0;
if($t!=''){
  $s=$db->prepare("INSERT INTO `".$prefix."choices` (rid,contentType,title,value) VALUES (0,'postoption',:t,:v)");
  $s->execute([':t'=>$t,':v'=>$v]);
  if($v==0)$v='';
  $id=$db->lastInsertId();
echo'<script>'.
  'window.top.window.$("#postoption").append(`<div id="l_'.$id.'" class="form-group row">'.
		'<div class="input-group col">'.
			'<span class="input-group-text">Service</span>'.
			'<input type="text" class="form-control" name="service" value="'.$t.'" readonly>'.
			'<span class="input-group-text">Cost</span>'.
			'<input type="text" class="form-control" name="cost" value="'.$v.'" readonly>'.
			'<div class="input-group-append">'.
				'<form target="sp" action="core/purge.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete"" aria-label="Delete">'.svg2('trash').'</button>'.
				'</form>'.
			'</div>'.
		'</div>'.
	'</div>`);'.
'</script>';
}
