<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add FAQ Item
 * @package    core/add_faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):'';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$open=isset($_POST['open'])?filter_input(INPUT_POST,'open',FILTER_SANITIZE_NUMBER_INT):0;
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):'';
if($t!=''||$da!=''){
  if($open==1)
    $opt="0000000001000000";
  else
    $opt="0000000000000000";
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`title`,`options`,`category_1`,`contentType`,`notes`,`ti`) VALUES (:title,:options,:category,'faq',:da,:ti)");
  $s->execute([
    ':title'=>$t,
    ':options'=>$opt,
    ':category'=>$c,
    ':da'=>$da,
    ':ti'=>time()
  ]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#faqs").append(`'.
					'<div id="l_'.$id.'">'.
						'<div class="row">'.
              '<h5>'.$c.'</h5>'.
							'<details'.($open==1?' open':'').'>'.
								'<summary>'.
									$t.
									'<form class="float-right" target="sp" action="core/purge.php">'.
										'<input name="id" type="hidden" value="'.$id.'">'.
										'<input name="t" type="hidden" value="content">'.
										'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
									'</form>'.
								'</summary>'.
								'<p>'.$da.'</p>'.
							'</details>'.
						'</div>'.
						'<hr>'.
					'</div>'.
				'`);'.
				'window.top.window.toastr["success"]("FAQ added!");'.
			'</script>';
}else{
  if($t==''&&$da==''){
    echo'<script>window.top.window.toastr["error"]("No Question or Answer Text was entered!");</script>';
  }else{
    if($t=='')echo'<script>window.top.window.toastr["error"]("No Question Text was entered!");</script>';
    if($da=='')echo'<script>window.top.window.toastr["error"]("No Answer Text was entered!");</script>';
  }
}
