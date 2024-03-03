<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update Shift
 * @package    core/updateshift.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$ti=time();
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$uid=filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT);
if($id!=0&&$uid!=0){
  $s=$db->prepare("UPDATE `".$prefix."roster` SET `uid`=:uid, `status`='accepted' WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':uid'=>$uid
  ]);
  $e=$db->errorInfo();
  if(is_null($e[2])){
    echo'Thank you for accepting this available shift.<br>Someone will check there are no conflicts with the shift.<br>The shift will appear in your roster on the left.';
  }else
    echo'There was a Database issue!';
}else
  echo'The correct details were not passed!';
