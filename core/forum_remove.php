<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Remove Forum Items
 * @package    core/forum_remove.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW):'';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):0;
if($act=='reply'){
  $s=$db->prepare("DELETE FROM `".$prefix."forumPosts` WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  echo'<script>'.
    'window.top.window.$("#post'.$id.'").addClass("zoom-out");'.
    'window.top.window.setTimeout(function(){window.top.window.$("#post'.$id.'").remove();},500);'.
  '</script>';
}
if($act=='post'){
  $sp=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `pid`=:id");
  $sp->execute([':id'=>$id]);
  if($sp->rowCount()>0){
    echo'<script>'.
      'window.top.window.$("#notifications").parent().find(".alert").remove();'.
      'window.top.window.$("#notification'.$id.'").html(`'.
        '<div class="alert alert-info">The <strong>'.$sp->rowCount().'</strong> replies need to be removed before the post can be removed.'.
      '`)'.
    '</script>';
  }else{
    $s=$db->prepare("DELETE FROM `".$prefix."forumPosts` WHERE `id`=:id");
    $s->execute([':id'=>$id]);
    echo'<script>'.
      'window.top.window.$("#notifications").parent().find(".alert").remove();'.
      'window.top.window.$("#post'.$id.'").addClass("zoom-out");'.
      'window.top.window.setTimeout(function(){window.top.window.$("#post'.$id.'").remove();},500);'.
    '</script>';
  }
}
