<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Booking to Job List
 * @package    core/bookingtojoblist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$id=isset($_GET['id'])?$_GET['id']:0;
$ti=time();
if($id>0){
  $so=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
  $so->execute([':id'=>$id]);
  $ro=$so->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `email`=:email");
  $su->execute([':email'=>$ro['email']]);
  if($su->rowCount()>0){
    $user=$su->fetch(PDO::FETCH_ASSOC);
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`uid`,`login_user`,`title`,`contentType`,`status`,`tis`,`ti`) VALUES (:uid,:login_user,:title,'job','unconfirmed',:tis,:ti)");
    $q->execute([
      ':uid'=>$user['id'],
      ':login_user'=>(isset($user['name'])?$user['name']:$user['username']),
      ':title'=>($ro['business']!=''?$ro['business']:'Job '.$ti),
      ':tis'=>$ro['tis'],
      ':ti'=>$ti
    ]);
    $qid=$db->lastInsertId();
    echo'<script>window.top.window.toastr["success"](`Job item created!`);</script>';
  }else{
    echo'<script>window.top.window.toastr["error"](`There was an issue creating the Job entry!`);</script>';
  }
}else{
  echo'<script>window.top.window.toastr["error"](`Booking ID not found!`);</script>';
}
