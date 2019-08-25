<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Comment IP to Blacklist
 * @package    core/add_commentblacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Add Reason to Blacklist
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT ip,ti FROM `".$prefix."comments` WHERE id=:id");
$s->execute([':id'=>$id]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,reason,ti) VALUES (:ip,:oti,:reason,:ti)");
  $sql->execute([
    ':ip'=>$r['ip'],
    ':oti'=>$r['ti'],
    ':reason'=>'IP Manually from Comments',
    ':ti'=>time()
  ]);
  echo'<script>window.top.window.$("#blacklist'.$id.'").addClass("hidden");</script>';
}
