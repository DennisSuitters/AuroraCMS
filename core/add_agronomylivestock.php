<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Agronomy Livestock
 * @package    core/add_agronomylivestock.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
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
$ti=time();
$code=isset($_POST['code'])?filter_input(INPUT_POST,'code',FILTER_UNSAFE_RAW):'';
$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW):'';
$species=isset($_POST['species'])?filter_input(INPUT_POST,'species',FILTER_UNSAFE_RAW):'';
$breed=isset($_POST['breed'])?filter_input(INPUT_POST,'breed',FILTER_UNSAFE_RAW):'';
$sex=isset($_POST['sex'])?filter_input(INPUT_POST,'sex',FILTER_UNSAFE_RAW):'';
$dob=isset($_POST['dob'])?filter_input(INPUT_POST,'dob',FILTER_UNSAFE_RAW):$ti;
$dod=isset($_POST['dod'])?filter_input(INPUT_POST,'dod',FILTER_UNSAFE_RAW):0;
$aid=isset($_POST['aid'])?filter_input(INPUT_POST,'aid',FILTER_UNSAFE_RAW):0;
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW):'';
$notes=isset($_POST['notes'])?filter_input(INPUT_POST,'notes',FILTER_UNSAFE_RAW):'';
if($name!=''&&$species!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."agronomy_livestock` (`code`,`name`,`species`,`breed`,`sex`,`dob`,`dod`,`aid`,`activity`,`notes`) VALUES (:code,:name,:species,:breed,:sex,:dob,:dod,:aid,:activity,:notes)");
  $s->execute([
		':code'=>$code,
    ':name'=>$name,
    ':species'=>$species,
    ':breed'=>$breed,
    ':sex'=>$sex,
    ':dob'=>$dob,
    ':dod'=>$dod,
    ':aid'=>$aid,
    ':activity'=>$act,
    ':notes'=>$notes
	]);
  $id=$db->lastInsertId();
  if($aid!=0){
    $saa=$db->prepare("SELECT * FROM `".$prefix."agronomy_areas` WHERE `id`=:aid");
    $saa->execute([':aid'=>$aid]);
    $raa=$saa->fetch(PDO::FETCH_ASSOC);
  }
	echo'<script>'.
				'window.top.window.$("#agronomy_livestock").append(`'.
          '<div id="l_'.$id.'" class="card my-1 p-2 small overflow-visible">'.
            '<h6>'.$name.'</h6>'.
            ($code!=''?'<div class="small">Code: '.$code.'</div>':'').
            '<div class="row">'.
              '<div class="col-4">'.
                '<div class="small text-center">Species</div>'.
                '<div class="text-center">'.
                  '<i class="i i-4x">animal-'.strtolower($species).'</i>'.
                  '<div class="small">'.ucwords($species).'</div>'.
                '</div>'.
              '</div>'.
              '<div class="col-4">'.
                '<div class="small text-center">Area</div>'.
                '<div class="text-center">'.
                  (isset($raa['type'])&&$raa['type']!=''?'<i class="i i-4x">area-'.strtolower($raa['type']).'</i>':'').
                  (isset($raa['name'])&&$raa['name']!=''?'<div class="small">'.$raa['name'].'</div>':'').
                '</div>'.
              '</div>'.
              '<div class="col-4">'.
                '<div class="small text-center">Activity</div>'.
                '<div class="text-center">'.
                  '<i class="i i-4x">activity-'.strtolower($act).'</i>'.
                  '<div class="small">'.ucwords($act).'</div>'.
                '</div>'.
              '</div>'.
              '<div class="row m-0 p-0">'.
                '<div class="col-6 text-left m-0 p-0">'.
                  '<a class="btn btn-sm" href="'.URL.$settings['system']['admin'].'/agronomy/livestock/'.$id.'" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
                '</div>'.
                '<div class="col-6 text-right m-0 p-0">'.
                  '<button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="window.top.window.decreaseLivestock(\`'.$id.'\`,\`agronomy_livestock\`,\`'.$aid.'\`);"><i class="i">trash</i></button>'.
                '</div>'.
              '</div>'.
            '</div>'.
          '</div>`);'.
			'</script>';
      echo'<script>'.
        'window.top.window.toastr["success"]("'.$name.' Added!");'.
        'var stock=window.top.window.$(`#stock'.$aid.'`).data(`stock`) + 1;'.
        'window.top.window.$(`#stock'.$aid.'`).data(`stock`,stock).html(stock);'.
      '</script>';
}else{
  $msg=($name==''?"A Name wasn\'t entered!":'').
    ($type==''?($name==''?'<br>':'')."A Type wasn\'t entered!":'');
  echo'<script>window.top.window.toastr["error"]("'.$msg.'");</script>';
}
