<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Purge Content Items
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
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
$el='l_';
if($id!=0&&$tbl!='logs'&&$tbl!='livechat'&&$tbl!='forumCategory'||$tbl!='forumTopics'){
  $s=$db->prepare("SELECT * FROM `".$prefix.$tbl."` WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($tbl=='config'||$tbl=='login')$r['contentType']='';
  $nda='';
  foreach($r as$o)$nda.=$o.'|';
}
if($tbl=='suggestions'){
  $s=$db->prepare("SELECT * FROM `".$prefix."suggestions` WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  if($s->rowCount()==1){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    if($r['t']!=''){
      $ss=$db->prepare("UPDATE `".$prefix.$r['t']."` SET `suggestions`=0 WHERE `id`=:id");
      $ss->execute([':id'=>$r['rid']]);
    }
  }
}
if($id==0&&$tbl=='iplist'){
  $q=$db->query("DELETE FROM `".$prefix."iplist`");
  $q->execute();
  $id=='iplist';
}
if($id==0&&$tbl=='logs'){
  $q=$db->query("DELETE FROM `".$prefix."logs`");
  $q->execute();
  $id='timeline';
}
if($id==0&&$tbl=='tracker'){
  $q=$db->query("DELETE FROM `".$prefix."tracker`");
  $q->execute();
  $id='tracker';
}
if($id==0&&$tbl=='cart'){
  $q=$db->query("DELETE FROM `".$prefix."cart`");
  $q->execute();
  $id='cart';
}
if($id==0&&$tbl=='pageviews'){
  $q=$db->query("UPDATE `".$prefix."menu` SET `views`='0'");
  $q->execute();
  $id='';
}
if($id==0&&$tbl=='contentviews'){
  $q=$db->prepare("UPDATE `".$prefix."content` SET `views`='0' WHERE `contentType`=:contentType");
  $q->execute([':contentType'=>$col]);
  $id='';
}
if($tbl=='orders'){
  $q=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE `oid`=:oid");
  $q->execute([':oid'=>$id]);
}
if($id!=0&&$tbl=='seo'){
  $q=$db->prepare("DELETE FROM `".$prefix.$tbl."` WHERE `id`=:id");
  $q->execute([':id'=>$id]);
  $el='l_';
}
if($id!=0&&$id!='activity'){
  $q=$db->prepare("DELETE FROM `".$prefix.$tbl."` WHERE `id`=:id");
  $q->execute([':id'=>$id]);
  if($tbl=='media')$el='media_items_';
  echo'<script>'.
    'window.top.window.$("#l_'.$id.'").addClass("zoom-out");'.
    'window.top.window.setTimeout(function(){window.top.window.$("#l_'.$id.'").remove();},500);'.
  '</script>';
}
if($tbl=='livechat'){
  $q=$db->prepare("DELETE FROM `".$prefix."livechat` WHERE `sid`=:sid");
  $q->execute([':sid'=>$col]);
  echo'<script>'.
    'window.top.window.$("#l_'.$id.'").removeClass("active");'.
    'window.top.window.$("#l_'.$id.'").remove();'.
    'window.top.window.$("#chatTitle").html("&nbsp;");'.
    'window.top.window.$("#chatScreen").html("");'.
    'window.top.window.$("#chatsid,#chataid,#chatemail,#chatname").val("");'.
  '</script>';
}
if($tbl=='errorlog'){
  unlink('../media/cache/error.log');
  $el='l_';
  $id=0;
}
if($tbl=='choices'){
  echo'<script>'.
    'window.top.window.$("#l_'.$id.'").addClass("zoom-out");'.
    'window.top.window.setTimeout(function(){window.top.window.$("#l_'.$id.'").remove();},500);'.
  '</script>';
}
