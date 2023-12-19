<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Login Images
 * @package    core/add_loginimages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$lit=filter_input(INPUT_POST,'lit',FILTER_UNSAFE_RAW); // Image Title
$li=filter_input(INPUT_POST,'li',FILTER_UNSAFE_RAW); // Image URL
$lia=filter_input(INPUT_POST,'lia',FILTER_UNSAFE_RAW); // Author Name
$liau=filter_input(INPUT_POST,'liau',FILTER_UNSAFE_RAW); // Author URL
$lis=filter_input(INPUT_POST,'lis',FILTER_UNSAFE_RAW); // Service
$lisu=filter_input(INPUT_POST,'lisu',FILTER_UNSAFE_RAW); // Service URL
if($li=='')echo'<script>window.top.window.toastr["error"]("The Image field must contain data!");</script>';
else{
  $layout=($liau!=''?'Photo by&nbsp;<a href="'.$liau.'">'.$lia.'</a>&nbsp;on&nbsp;<a href="'.$lisu.'">'.$lis.'</a>':'');
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."widgets` (`ref`,`title`,`file`,`layout`) VALUES ('loginimage',:title,:file,:layout)");
	$q->execute([
    ':title'=>$lit,
		':file'=>$li,
    ':layout'=>$layout
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
		$s=$db->prepare("UPDATE `".$prefix."widgets` SET `ord`=:id WHERE `id`=:id");
		$s->execute([':id'=>$id]);
    echo'<script>'.
			'window.top.window.$("#loginimages").append(`<div id="li_'.$id.'" class="card stats gallery col-12 col-sm-3 m-0 border-0 add-item">'.
        '<a data-fancybox="loginimage" href="'.$li.'"><img src="'.$li.'" alt="'.$lit.'"></a>'.
        '<div class="btn-group tools">'.
          '<form class="d-inline" target="sp" action="core/purge.php">'.
            '<input name="id" type="hidden" value="'.$id.'">'.
            '<input name="t" type="hidden" value="widgets">'.
            '<button class="trash" data-tooltip="right" aria-label="Delete"><i class="i">trash</i></button>'.
          '</form>'.
          '<div class="btn handle" data-tooltip="left" aria-label="Drag to Reorder"><i class="i">drag</i></div>'.
        '</div>'.
			'</div>`);'.
		'</script>';
	}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Data!");</script>';
}
