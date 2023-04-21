<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Agronomy Livestock
 * @package    core/add_agronomylivestock.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$ti=time();
$code=isset($_POST['code'])?filter_input(INPUT_POST,'code',FILTER_UNSAFE_RAW):'';
$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW):'';
$type=isset($_POST['type'])?filter_input(INPUT_POST,'type',FILTER_UNSAFE_RAW):'';
$breed=isset($_POST['breed'])?filter_input(INPUT_POST,'breed',FILTER_UNSAFE_RAW):'';
$sex=isset($_POST['sex'])?filter_input(INPUT_POST,'sex',FILTER_UNSAFE_RAW):'';
$dob=isset($_POST['dob'])?filter_input(INPUT_POST,'dob',FILTER_UNSAFE_RAW):$ti;
$dod=isset($_POST['dod'])?filter_input(INPUT_POST,'dod',FILTER_UNSAFE_RAW):0;
$notes=isset($_POST['notes'])?filter_input(INPUT_POST,'notes',FILTER_UNSAFE_RAW):'';
if($name!=''||$type!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."agronomy_livestock` (`code`,`name`,`type`,`breed`,`sex`,`dob`,`dod`,`notes`) VALUES (:code,:name,:type,:breed,:sex,:dob,:dod,:notes)");
  $s->execute([
		':code'=>$code,
    ':name'=>$name,
    ':type'=>$type,
    ':breed'=>$breed,
    ':sex'=>$sex,
    ':dob'=>$dob,
    ':dod'=>$dod,
    ':notes'=>$notes
	]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#agronomy_areas").append(`'.
          '<div id="l_'.$id.'" class="card col-12 col-sm-2 m-1 p-2">'.
            '<h6>'.$name.'</h6>'.
            ($code!=''?'<div class="small">Code: '.$code.'</div>':'').
            ($type!=''?'<div class="small">Type: '.$type.'</div>':'').
            ($condition!=''?'<div class="small">Condition: '.$condition.'</div>':'').
            ($activity!=''?'<div class="small">Activity: '.$activity.'</div>':'').
            '<div class="card-footer">'.

            '</div>'.
          '</div>`);'.
			'</script>';
      echo'<script>window.top.window.toastr["success"]("'.$name.' Added!");</script>';
}else{
  $msg=($name==''?"A Name wasn\'t entered!":'').
  ($type==''?($name==''?'<br>':'')."A Type wasn\'t entered!":'');
  echo'<script>window.top.window.toastr["error"]("'.$msg.'");</script>';
}
