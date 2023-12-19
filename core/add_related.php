<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Related
 * @package    core/add_related.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'rid',FILTER_SANITIZE_NUMBER_INT);
if($id==$rid)echo'<script>window.top.window.toastr["warning"]("Item can\'t be related to itself!");</script>';
else{
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
				$si->execute([':id'=>$rid]);
				$ri=$si->fetch(PDO::FETCH_ASSOC);
				echo'<script>'.
							'window.top.window.$("#relateditems").append(`<div id="l_'.$id.'" class="form-row mt-1 add-item">'.
								'<input type="text" value="'.ucfirst($ri['contentType']).': '.$ri['title'].'" readonly>'.
								'<form target="sp" action="core/purge.php">'.
									'<input name="id" type="hidden" value="'.$id.'">'.
									'<input name="t" type="hidden" value="choices">'.
									'<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
								'</form>'.
							'</div>`);'.
						'</script>';
			}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Data!");</script>';
		}else echo'<script>window.top.window.toastr["warning"]("Item is already related!");</script>';
	}else echo'<script>window.top.window.toastr["warning"]("You need to select in Item to Relate!");</script>';
}
