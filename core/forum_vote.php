<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Forum Vote
 * @package    core/forum_vote.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):0;
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if($uid!=0){
  $st=$db->prepare("SELECT * FROM `".$prefix."forumVoteTrack` WHERE `pid`=:id AND `uid`=:uid");
  $st->execute([
    ':id'=>$id,
    ':uid'=>$uid
  ]);
  if($st->rowCount()>0){
    $rt=$st->fetch(PDO::FETCH_ASSOC);
    if($rt['notes']=='up')$act='down';
    if($rt['notes']=='down')$act='up';
    $s=$db->prepare("DELETE FROM `".$prefix."forumVoteTrack` WHERE `id`=:id");
    $s->execute([':id'=>$rt['id']]);
  }
  if($act=='up'){
    $s=$db->prepare("INSERT IGNORE INTO `".$prefix."forumVoteTrack` (`pid`,`uid`,`notes`) VALUES (:pid,:uid,'up')");
    $s->execute([
      ':pid'=>$id,
      ':uid'=>$uid
    ]);
    $s=$db->prepare("UPDATE `".$prefix."forumPosts` SET `vote`=`vote` + 1 WHERE `id`=:id");
    $s->execute([':id'=>$id]);
  }
  if($act=='down'){
    $s=$db->prepare("INSERT IGNORE INTO `".$prefix."forumVoteTrack` (`pid`,`uid`,`notes`) VALUES (:pid,:uid,'down')");
    $s->execute([
      ':pid'=>$id,
      ':uid'=>$uid
    ]);
    $s=$db->prepare("UPDATE `".$prefix."forumPosts` SET `vote`=`vote` - 1 WHERE `id`=:id");
    $s->execute([':id'=>$id]);
  }
  $s=$db->prepare("SELECT `vote` FROM `".$prefix."forumPosts` WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($r['vote']<0){
    $r['vote']=0;
    $s=$db->prepare("UPDATE `".$prefix."forumPosts` SET `vote`=0 WHERE `id`=:id");
    $s->execute([':id'=>$id]);
  }
  echo'<script>'.
    'window.top.window.$("#forum-vote-number-'.$id.'").html(`'.($r['vote']<1?'Vote':$r['vote']).'`)'.
  '</script>';
}else{
  echo'<script>'.
    'window.top.window.alert("Only logged in user\'s can vote!");'.
  '</script>';
}
