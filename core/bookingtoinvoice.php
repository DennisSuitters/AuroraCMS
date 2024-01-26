<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Booking to Invoice
 * @package    core/bookingtoinvoice.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$id=isset($_GET['id'])?$_GET['id']:0;
$ti=time();
if($id>0){
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  $ro=$s->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("SELECT `id` FROM `".$prefix."login` WHERE `email`=:email");
  $s->execute([':email'=>$ro['email']]);
  if($s->rowCount()>0){
    $r=$db->query("SELECT MAX(`id`) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
    $dti=$ti+$config['orderPayti'];
    $oid='I'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`uid`,`cid`,`iid`,`iid_ti`,`due_ti`,`status`,`process`) VALUES (:uid,:cid,:iid,:iid_ti,:due_ti,'pending','1000000000000000')");
    $q->execute([
      ':uid'=>$ro['uid'],
      ':cid'=>$ro['cid'],
      ':iid'=>$oid,
      ':iid_ti'=>$ti,
      ':due_ti'=>$dti
    ]);
    $qid=$db->lastInsertId();
    $os=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $os->execute([':id'=>$ro['rid']]);
    if($os->rowCount()>0){
      while($oi=$os->fetch(PDO::FETCH_ASSOC)){
        $s=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`cid`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,:cid,:title,:quantity,:cost,:status,:ti)");
        $s->execute([
          ':oid'=>$qid,
          ':cid'=>$ro['uid'],
          ':title'=>$oi['title'],
          ':quantity'=>1,
          ':cost'=>$oi['cost'],
          ':status'=>'',
          ':ti'=>$ti
        ]);
      }
      echo'<script>window.top.window.toastr["success"](`Order Created!`);</script>';
    }
  }else{
    $su=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`username`,`rank`,`email`,`name`,`business`,`address`,`suburb`,`city`,`state`,`postcode`,`country`,`ti`) VALUES (:username,:rank,:email,:name,:business,:address,:suburb,:city,:state,:postcode,:country,:ti)");
    $uname=explode(' ',$ro['name']);
    $su->execute([
      ':username'=>$uname[0].$ti,
      ':rank'=>300,
      ':email'=>isset($ro['email'])&&$ro['email']!=''?$ro['email']:'',
      ':name'=>isset($ro['name'])&&$ro['name']!=''?$ro['name']:'',
      ':business'=>isset($ro['business'])&&$ro['business']!=''?$ro['business']:'',
      ':address'=>isset($ro['address'])&&$ro['address']!=''?$ro['address']:'',
      ':suburb'=>isset($ro['suburb'])&&$ro['suburb']!=''?$ro['suburb']:'',
      ':city'=>isset($ro['city'])&&$ro['city']!=''?$ro['city']:'',
      ':state'=>isset($ro['state'])&&$ro['state']!=''?$ro['state']:'',
      ':postcode'=>isset($ro['postcode'])&&$ro['postcode']!=''?$ro['postcode']:'',
      ':country'=>isset($ro['country'])&&$ro['country']!=''?$ro['country']:'',
      ':ti'=>$ti
    ]);
    $uid=$db->lastInsertId();
    $r=$db->query("SELECT MAX(`id`) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
    $dti=$ti+$config['orderPayti'];
    $oid='I'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`uid`,`cid`,`iid`,`iid_ti`,`due_ti`,`status`) VALUES (:uid,:cid,:iid,:iid_ti,:due_ti,'pending')");
    $q->execute([
      ':uid'=>$uid,
      ':cid'=>$ro['cid'],
      ':iid'=>$oid,
      ':iid_ti'=>$ti,
      ':due_ti'=>$dti
    ]);
    $qid=$db->lastInsertId();
    $os=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $os->execute([':id'=>$ro['rid']]);
    if($os->rowCount()>0){
      $oi=$os->fetch(PDO::FETCH_ASSOC);
      $s=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`cid`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,:cid,:title,:quantity,:cost,:status,:ti)");
      $s->execute([
        ':oid'=>$qid,
        ':cid'=>$ro['cid'],
        ':title'=>$oi['title'],
        ':quantity'=>1,
        ':cost'=>$oi['cost'],
        ':status'=>'',
        ':ti'=>$ti
      ]);
      echo'<script>window.top.window.toastr["success"](`Order and User Account Created!`);</script>';
    }
  }
  if($config['options'][25]==1){
    $s=$db->prepare("UPDATE `".$prefix."content` SET `status`='archived' WHERE `id`=:id");
    $s->execute([':id'=>$id]);
    echo'<script>'.
      'window.top.window.toastr["success"](`Booking Archived!`);'.
      'window.top.window.$("#l_'.$id.'").addClass("animated zoomOut");'.
      'window.top.window.setTimeout(function(){window.top.window.$("#l_'.$id.'").remove();},500);'.
    '</script>';
  }
}
