<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Message Actions
 * @package    core/messageactions.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'act',FILTER_UNSAFE_RAW);
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
$ti=time();
if($act=='delete'){
  $items=explode(',',$da);
  foreach($items as $item => $value){
    $q=$db->prepare("DELETE FROM `".$prefix."messages` WHERE `id`=:id");
    $q->execute([':id'=>$value]);
  }
  echo'delete';
}
if($act=='unread'||$act=='read'){
  $items=explode(',',$da);
  foreach($items as $item => $value){
    $q=$db->prepare("UPDATE `".$prefix."messages` SET `status`=:status WHERE `id`=:id");
    $q->execute([
      ':id'=>$value,
      ':status'=>$act
    ]);
  }
  echo$act;
}
if($act=='important'||$act=='unimportant'){
  $items=explode(',',$da);
  foreach($items as $item => $value){
    $q=$db->prepare("UPDATE `".$prefix."messages` SET `important`=:imp WHERE `id`=:id");
    $q->execute([
      ':id'=>$value,
      ':imp'=>($act=='important'?1:0)
    ]);
  }
  echo$act;
}
