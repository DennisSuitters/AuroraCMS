<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Content FAQ Item
 * @package    core/add_contentfaq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT):0;
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):'';
$open=isset($_POST['open'])?filter_input(INPUT_POST,'open',FILTER_SANITIZE_NUMBER_INT):0;
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):'';
if($t!=''||$da!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`title`,`value`,`type`,`contentType`,`notes`,`ti`) VALUES (:rid,:title,:value,:type,'faq',:da,:ti)");
  $s->execute([
    ':rid'=>$rid,
    ':title'=>$t,
    ':value'=>($open==1?1:0),
    ':type'=>$c,
    ':da'=>$da,
    ':ti'=>time()
  ]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#faqs").append(`'.
					'<div class="card mt-1 add-item" id="l_'.$id.'">'.
						'<div class="row p-2">'.
							'<details open>'.
								'<summary>'.
									$t.
                  '<div class="col-3 float-right text-right">'.
                    '<div class="form-row">'.
                      '<input id="faqvalue0'.$id.'" data-dbid="'.$id.'" data-dbt="choices" data-dbc="value" data-dbb="0" type="checkbox"'.($open==1?' checked aria-checked="true"':' aria-checked="false"').'>'.
                      '<label for="faqvalue0'.$id.'">Display as Open</label>'.
                      '<form target="sp" action="core/purge.php">'.
                        '<input name="id" type="hidden" value="'.$id.'">'.
                        '<input name="t" type="hidden" value="choices">'.
                        '<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
                      '</form>'.
                      '<span class="btn orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>'.
                    '</div>'.
                  '</div>'.
                '</summary>'.
								'<div class="ml-4">'.
                  strip_tags($da).
                '</div>'.
							'</details>'.
						'</div>'.
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
