<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Discount Range
 * @package    core/add_discountrange.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$f=isset($_POST['f'])?filter_input(INPUT_POST,'f',FILTER_SANITIZE_STRING):'';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
$m=isset($_POST['m'])?filter_input(INPUT_POST,'m',FILTER_SANITIZE_STRING):1;
$v=isset($_POST['v'])?filter_input(INPUT_POST,'v',FILTER_SANITIZE_STRING):0;
if($f!=''&&$t!=''&&$v!=0){
  $s=$db->prepare("INSERT INTO `".$prefix."choices` (contentType,f,t,value,cost) VALUES ('discountrange',:f,:t,:m,:cost)");
  $s->execute([
		':f'=>$f,
		':t'=>$t,
    ':m'=>$m,
		':cost'=>$v
	]);
  if($v==0)$v='';
  $id=$db->lastInsertId();
echo'<script>'.
  'window.top.window.$("#discountrange").append(`<div id="l_'.$id.'" class="form-group">'.
		'<div class="input-group">'.
			'<div class="input-group-prepend">'.
				'<div class="input-group-text">From &#36;</div>'.
			'</div>'.
			'<input type="number" class="form-control" value="'.$f.'" readonly>'.
			'<div class="input-group-append">'.
				'<div class="input-group-text">To &#36;</div>'.
			'</div>'.
			'<input type="number" class="form-control" value="'.$t.'" readonly>'.
			'<div class="input-group-append">'.
				'<div class="input-group-text">Method</div>'.
			'</div>'.
			'<input type="text" class="form-control" value="'.($m==2?'&#37; Off':'&#36; Off').'" readonly>'.
			'<div class="input-group-append">'.
				'<div class="input-group-text">Value</div>'.
			'</div>'.
			'<input type="number" class="form-control" value="'.$v.'" readonly>'.
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
