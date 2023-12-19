<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Livestock Data
 * @package    core/add_livestockdata.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT `dateFormat` FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$ti=time();
$lid=isset($_POST['lid'])?filter_input(INPUT_POST,'lid',FILTER_UNSAFE_RAW):0;
$aid=isset($_POST['aid'])?filter_input(INPUT_POST,'aid',FILTER_UNSAFE_RAW):0;
$activity=isset($_POST['activity'])?filter_input(INPUT_POST,'activity',FILTER_UNSAFE_RAW):'';
$med=isset($_POST['med'])?filter_input(INPUT_POST,'med',FILTER_UNSAFE_RAW):'';
$weight=isset($_POST['weight'])?filter_input(INPUT_POST,'weight',FILTER_UNSAFE_RAW):'';
$height=isset($_POST['height'])?filter_input(INPUT_POST,'height',FILTER_UNSAFE_RAW):'';
$length=isset($_POST['length'])?filter_input(INPUT_POST,'length',FILTER_UNSAFE_RAW):'';
$behaviour=isset($_POST['behaviour'])?filter_input(INPUT_POST,'behaviour',FILTER_UNSAFE_RAW):'';
$cs=isset($_POST['cs'])?filter_input(INPUT_POST,'cs',FILTER_UNSAFE_RAW):'';
$notes=isset($_POST['notes'])?filter_input(INPUT_POST,'notes',FILTER_UNSAFE_RAW):'';
$lti=isset($_POST['ltix'])?filter_input(INPUT_POST,'ltix',FILTER_UNSAFE_RAW):$ti;
$area='';
if($aid!=0){
  $saa=$db->prepare("SELECT `name` FROM `".$prefix."agronomy_areas` WHERE `id`=:aid");
  $saa->execute([':aid'=>$aid]);
  $raa=$saa->fetch(PDO::FETCH_ASSOC);
  $area=$raa['name'];
}
$s=$db->prepare("INSERT IGNORE INTO `".$prefix."agronomy_data` (`lid`,`aid`,`area`,`activity`,`medication`,`weight`,`height`,`length`,`behaviour`,`condition_score`,`notes`,`lti`,`ti`) VALUES (:lid,:aid,:area,:activity,:med,:weight,:height,:length,:behaviour,:cs,:notes,:lti,:ti)");
$s->execute([
  ':lid'=>$lid,
	':aid'=>$aid,
  ':area'=>$area,
  ':activity'=>$activity,
  ':med'=>$med,
  ':weight'=>$weight,
  ':height'=>$height,
  ':length'=>$length,
  ':behaviour'=>$behaviour,
  ':cs'=>$cs,
  ':notes'=>$notes,
  ':lti'=>$lti,
  ':ti'=>$ti
]);
$id=$db->lastInsertId();
echo'<script>window.top.window.$("#agronomy_data").prepend(`'.
  '<article id="l_'.$id.'" class="card col-12 zebra mt-2 mb-0 p-2 border-0 overflow-visible shadow">'.
    '<div class="row">'.
      '<div class="col-12 pl-2 small">'.date($config['dateFormat'],$lti).'</div>'.
    '</div>'.
    '<div class="row">'.
      '<div class="col-12 col-md pl-1">'.$area.'</div>'.
      '<div class="col-12 col-md pl-1">'.str_replace(',',',<br>',$activity).'</div>'.
      '<div class="col-12 col-md pl-1">'.str_replace(',',',<br>',$med).'</div>'.
      '<div class="col-12 col-md pl-1">'.$weight.'</div>'.
      '<div class="col-12 col-md pl-1">'.$height.'</div>'.
      '<div class="col-12 col-md pl-1">'.$length.'</div>'.
      '<div class="col-12 col-md pl-1">'.$behaviour.'</div>'.
      '<div class="col-12 col-md pl-1">'.$cs.'</div>'.
    '</div>'.
    '<div class="row">'.
      '<div class="col-12 col-md pl-2 pt-1">'.
        ($notes!=''?'<small>Notes:</small><br>'.$notes:'').
        '<div class="float-right">'.
          '<button class="quickeditbtn" data-qeid="'.$id.'" data-qet="agronomy_data" data-tooltip="left" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>'.
        '</div>'.
      '</div>'.
    '</div>'.
    '<div class="quickedit" id="quickedit'.$id.'"></div>'.
  '</article>`);'.
'</script>';
