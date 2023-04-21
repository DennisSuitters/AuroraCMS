<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Agronomy Area
 * @package    core/add_agronomyarea.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW):'';
$condition=isset($_POST['condition'])?filter_input(INPUT_POST,'condition',FILTER_UNSAFE_RAW):'';
$type=isset($_POST['type'])?filter_input(INPUT_POST,'type',FILTER_UNSAFE_RAW):'';
$code=isset($_POST['code'])?filter_input(INPUT_POST,'code',FILTER_UNSAFE_RAW):'';
$activity=isset($_POST['activity'])?filter_input(INPUT_POST,'activity',FILTER_UNSAFE_RAW):'';
$notes=isset($_POST['notes'])?filter_input(INPUT_POST,'notes',FILTER_UNSAFE_RAW):'';
$ti=time();
if($name!=''||$type!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."agronomy_areas` (`type`,`code`,`name`,`condition`,`activity`,`notes`,`ti`) VALUES (:type,:code,:name,:condition,:activity,:notes,:ti)");
  $s->execute([
		':type'=>$type,
    ':code'=>$code,
    ':name'=>$name,
    ':condition'=>$condition,
    ':activity'=>$activity,
    ':notes'=>$notes,
    ':ti'=>$ti
	]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#agronomy_areas").append(`'.
          '<div id="l_'.$id.'" class="card my-1 p-2">'.
            '<h6>'.$name.'</h6>'.
            ($code!=''?'<div class="small">Code: '.$code.'</div>':'').
            ($type!=''?'<div class="small">Type: '.$type.'</div>':'').
            ($condition!=''?'<div class="small">Condition: '.$condition.'</div>':'').
            ($activity!=''?'<div class="small">Activity: '.$activity.'</div>':'').
            '<div class="row m-0 p-0">'.
              '<div class="col-6 text-left m-0 p-0">'.
                '<a class="btn btn-sm" href="" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
              '</div>'.
              '<div class="col-6 text-right m-0 p-0">'.
                '<button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
              '</div>'.
            '</div>'.
          '</div>`);'.
			'</script>';
      echo'<script>window.top.window.toastr["success"]("'.$name.' Added!");</script>';
}else{
  $msg=($name==''?"A Name wasn\'t entered!":'').
  ($type==''?($name==''?'<br>':'')."A Type wasn\'t entered!":'');
  echo'<script>window.top.window.toastr["error"]("'.$msg.'");</script>';
}
