<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Option
 * @package    core/add_option.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$ttl=filter_input(INPUT_POST,'ttl',FILTER_SANITIZE_STRING);
$qty=filter_input(INPUT_POST,'qty',FILTER_SANITIZE_NUMBER_INT);
echo'<script>';
if($ttl==''||$qty==''){?>
	window.top.window.toastr["error"]("Not all Fields were filled in!");
<?php }else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`uid`,`rid`,`contentType`,`title`,`ti`) VALUES (:uid,:rid,'option',:title,:ti)");
	$q->execute([
		':uid'=>$uid,
		':rid'=>$rid,
		':title'=>$ttl,
		':ti'=>$qty
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){?>
	window.top.window.$('#itemoptions').append('<?php echo'<div id="l_'.$id.'" class="form-row mt-1"><div class="input-text">Option</div><input type="text" name="da" value="'.$ttl.'" readonly><div class="input-text">Quantity</div><input name="da" type="text" value="'.$qty.'" placeholder="Quantity" readonly><form target="sp" action="core/purge.php"><input name="id" type="hidden" value="'.$id.'"><input name="t" type="hidden" value="choices"><button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg('trash').'</button></form></div>';?>');
<?php }else{?>
	window.top.window.toastr["error"]("There was an issue adding the Data!");
<?php }
}
echo'</script>';
