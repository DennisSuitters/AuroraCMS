<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Blacklist
 * @package    core/add_blacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Add Reason to Blacklist.
 * @changes    v0.0.5 Add Chatlist IP to Blacklist.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$reason=isset($_POST['r'])?filter_input(INPUT_POST,'r',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'r',FILTER_SANITIZE_STRING);
if($t=='comments')$s=$db->prepare("SELECT ip,ti FROM `".$prefix."comments` WHERE id=:id");
elseif($t=='tracker')$s=$db->prepare("SELECT ip,ti FROM `".$prefix."tracker` WHERE id=:id");
elseif($t=='livechat')$s=$db->prepare("SELECT ip,ti FROM `".$prefix."livechat` WHERE id=:id");
$s->execute([':id'=>$id]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,reason,ti) VALUES (:ip,:oti,:reason,:ti)");
  $sql->execute([
    ':ip'=>$r['ip'],
    ':oti'=>$r['ti'],
    ':reason'=>$reason,
    ':ti'=>time()
  ]);
  echo'IP Added to Blacklist!';
}else echo'IP already exists in the Blacklist!';
echo'<script>window.top.window.$(`[data-tooltip="tooltip"]`).tooltip(`hide`);</script>';
