<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Content Question
 * @package    core/add_contentquestion.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT):0;
$q=isset($_POST['q'])?filter_input(INPUT_POST,'q',FILTER_UNSAFE_RAW):'';
if($q!=''||$rid!=0){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."contentQuestions` (`rid`,`question`,`ti`) VALUES (:rid,:question,:ti)");
  $s->execute([
    ':rid'=>$rid,
    ':question'=>$q,
    ':ti'=>time()
  ]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#questions").append(`'.
					'<div id="l_'.$id.'" class="row add-item">'.
            '<div class="col-12">'.
              '<div class="form-row">'.
                '<div class="input-text col-12">'.$q.'</div>'.
                '<form target="sp" action="core/purge.php">'.
                  '<input name="id" type="hidden" value="'.$id.'">'.
                  '<input name="t" type="hidden" value="contentQuestions">'.
                  '<button class="trash"><i class="i">trash</i></button>'.
                '</form>'.
              '</div>'.
            '</div>'.
          '</div>'.
				'`);'.
				'window.top.window.toastr["success"]("Question added!");'.
			'</script>';
}else{
  if($q==''&&$da==''){
    echo'<script>window.top.window.toastr["error"]("No Question or Related Content was entered!");</script>';
  }else{
    if($q=='')echo'<script>window.top.window.toastr["error"]("No Question Text was entered!");</script>';
    if($rid=='')echo'<script>window.top.window.toastr["error"]("No Content ID was sent!");</script>';
  }
}
