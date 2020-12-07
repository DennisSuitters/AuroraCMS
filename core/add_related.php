<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Related
 * @package    core/add_related.php
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
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'rid',FILTER_SANITIZE_NUMBER_INT);
echo'<script>';
if($id==$rid){?>
window.top.window.toastr["warning"]("Item can't be related to itself!");
<?php	}else{
	if($rid!=0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."choices` WHERE `contentType`='related' AND `uid`=:id  AND `rid`=:rid");
		$s->execute([
			':id'=>$id,
			':rid'=>$rid
		]);
		if($s->rowCount()==0){
			$ss=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`uid`,`rid`,`contentType`,`ti`) VALUES (:id,:rid,'related',:ti)");
			$ss->execute([
				':id'=>$id,
				':rid'=>$rid,
				':ti'=>time()
			]);
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){
				$si=$db->prepare("SELECT `id`,`contentType`,`title` FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([
					':id'=>$rid
				]);
				$ri=$si->fetch(PDO::FETCH_ASSOC);?>
window.top.window.$('#relateditems').append('<?php echo'<div id="l_'.$id.'" class="form-row mt-1"><input type="text" value="'.ucfirst($ri['contentType']).': '.$ri['title'].'" readonly><form target="sp" action="core/purge.php"><input name="id" type="hidden" value="'.$id.'"><input name="t" type="hidden" value="choices"><button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg('trash').'</button></form></div>';?>');
<?php }else{?>
window.top.window.toastr["error"]("There was an issue adding the Data!");
<?php }
}else{?>
window.top.window.toastr["warning"]("Item is already related!");
<?php	}
}else{?>
window.top.window.toastr["warning"]("You need to select in Item to Relate!");
<?php }
}
echo'</script>';
