<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Pay Option
 * @package    core/add_payoption.php
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
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$m=isset($_POST['m'])?filter_input(INPUT_POST,'m',FILTER_UNSAFE_RAW):1;
$v=isset($_POST['v'])?filter_input(INPUT_POST,'v',FILTER_UNSAFE_RAW):0;
if($t!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`type`,`title`,`value`) VALUES (0,'payoption',:m,:t,:v)");
  $s->execute([
		':m'=>$m,
		':t'=>$t,
		':v'=>$v
	]);
  if($v==0)$v='';
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#payoptionl").append(`<div id="l_'.$id.'" class="form-row mt-1">'.
					'<div class="input-text">Option</div>'.
					'<input type="text" value="'.$t.'" readonly>'.
					'<div class="input-text">Surchage</div>'.
					'<input class="col-3" type="text" value="'.($m==2?'Add $':'Add %').'" readonly>'.
					'<input type="text" value="'.$v.'" readonly>'.
					'<form target="sp" action="core/purge.php">'.
						'<input name="id" type="hidden" value="'.$id.'">'.
						'<input name="t" type="hidden" value="choices">'.
						'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
					'</form>'.
				'</div>`);'.
			'</script>';
}
