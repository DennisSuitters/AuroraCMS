<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Agronomy Area
 * @package    core/add_agronomyarea.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
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
          '<div id="l_'.$id.'" class="card area my-1 p-2 small overflow-visible" data-dbid="'.$id.'">'.
            '<h6>'.$name.($code!=''?'<small class="ml-2">('.$code.')</small>':'').'</h6>'.
            '<div class="row">'.
              '<div class="col">'.
                '<div class="small text-center">Type</div>'.
                '<div class="small text-center" data-tooltip="tooltip" aria-label="'.$type.'">'.
                  '<i class="i i-4x">area-'.strtolower($type).'</i>'.
                  '<div class="small">'.$type.'</div>'.
                '</div>'.
              '</div>'.
              '<div class="col">'.
                '<div class="small text-center">Stock</div>'.
                '<div class="small text-center i-2x pt-3">'.
                  '<div id="stock'.$id.'" class="small" data-stock="0">0</div>'.
                '</div>'.
              '</div>'.
              '<div class="col">'.
                '<div class="small text-center">Condition</div>'.
                '<div class="small text-center" data-tooltip="tooltip" aria-label="'.$condition.'">'.
                  '<i class="i i-4x">condition-'.strtolower($condition).'</i>'.
                  '<div class="small">'.$condition.'</div>'.
                '</div>'.
              '</div>'.
              '<div class="col">'.
                '<div class="small text-center">Activity</div>'.
                '<div class="small text-center" data-tooltip="tooltip" aria-label="'.$activity.'">'.
                  '<i class="i i-4x">activity-'.strtolower($activity).'</i>'.
                  '<div class="small">'.$activity.'</div>'.
                '</div>'.
              '</div>'.
            '</div>'.
            '<div class="row m-0 mt-3 p-0">'.
              '<div class="col-6 text-left m-0 p-0">'.
                '<span class="btn btn-sm areahandle"><i class="i cursor-row-resize">drag</i></span>'.
                '<a class="btn btn-sm" href="'.URL.$settings['system']['admin'].'/agronomy/area/'.$id.'" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
              '</div>'.
              '<div class="col-6 text-right m-0 p-0">'.
                '<button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\`'.$id.'\`,\`agronomy_areas\`);"><i class="i">trash</i></button>'.
              '</div>'.
            '</div>'.
          '</div>`);'.
          'window.top.window.toastr["success"]("'.$name.' Added!");'.
			'</script>';
}else{
  $msg=($name==''?"A Name wasn\'t entered!":'').
  ($type==''?($name==''?'<br>':'')."A Type wasn\'t entered!":'');
  echo'<script>window.top.window.toastr["error"]("'.$msg.'");</script>';
}
