<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Price List Item
 * @package    core/add_pricelist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$t=filter_var($_POST['t'],FILTER_UNSAFE_RAW);
if($t!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`title`,`code`) VALUES (:rid,'price',:title,:code)");
  $s->execute([
    ':rid'=>$rid,
		':title'=>$t,
    ':code'=>$h
	]);
  $id=$db->lastInsertId();
  $s=$db->prepare("UPDATE `".$prefix."choices` SET `ord`=:id WHERE `id`=:id");
  $s->execute([':id'=>$id]);
	echo'<script>'.
				'window.top.window.$("#pricelist'.$rid.'").append(`<div id="l_'.$id.'" class="col-12">'.
          '<div class="form-row">'.
            '<div class="input-text">Item</div>'.
              '<input type="text" name="t" value="'.$t.'">'.
              '<form target="sp" method="post" action="core/purge.php">'.
                '<input type="hidden" name="id" value="'.$id.'">'.
                '<input type="hidden" name="t" value="choices">'.
                '<button class="btn trash" type="submit"><i class="i">trash</i></button>'.
              '</form>'.
            '</div>'.
          '</div>`);'.
			'</script>';
}else echo'<script>window.top.window.toastr["error"]("A Title wasn`t entered");</script>';
