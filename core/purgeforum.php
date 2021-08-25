<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Purge Forum Items
 * @package    core/purge.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING):0;
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
if($t=='forumTopics'){
  $sp=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `tid`=:tid");
  $sp->execute([':tid'=>$id]);
  if($sp->rowCount()>0){
    echo'<script>'.
      'window.top.window.toastr["error"]("All Posts need be removed before this Topic can be removed.");'.
    '</script>';
  }else{
    $s=$db->prepare("DELETE FROM `".$prefix."forumTopics` WHERE `id`=:id");
    $s->execute([':id'=>$id]);
    echo'<script>'.
      'window.top.window.$("#topic_'.$id.'").addClass("zoom-out");'.
      'window.top.window.setTimeout(function(){window.top.window.$("#topic_'.$id.'").remove();},500);'.
    '</script>';
  }
}
if($t=='forumCategory'){
  $s=$db->prepare("SELECT `id` FROM `".$prefix."forumTopics` WHERE `cid`=:cid");
  $s->execute([':cid'=>$id]);
  if($s->rowCount()>0){
    echo'<script>'.
      'window.top.window.toastr["error"]("All Topics need be removed before this Category can be removed.");'.
    '</script>';
  }else{
    $s=$db->prepare("DELETE FROM `".$prefix."forumCategory` WHERE `id`=:id");
    $s->execute([':id'=>$id]);
    echo'<script>'.
      'window.top.window.$("#cats_'.$id.'").addClass("zoom-out");'.
      'window.top.window.setTimeout(function(){window.top.window.$("#cats_'.$id.'").remove();},500);'.
    '</script>';
  }
}
