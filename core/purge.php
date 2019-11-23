<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Purge Content Items
 * @package    core/purge.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.5 Add Removal of Live Chat conversations.
 */
echo'<script>';
if(session_status()==PHP_SESSION_NONE)session_start();
$getcfg=false;
require'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
$el='l_';
if($id!=0&&$tbl!='logs'&&$tbl!='livechat'){
  $s=$db->prepare("SELECT * FROM ".$prefix.$tbl." WHERE id=:id");
  $s->execute([':id'=>$id]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($tbl=='config'||$tbl=='login')$r['contentType']='';
  $nda='';
  foreach($r as$o)$nda.=$o.'|';
}
if($tbl=='suggestions'){
  $s=$db->prepare("SELECT * FROM `".$prefix."suggestions` WHERE id=:id");
  $s->execute([':id'=>$id]);
  if($s->rowCount()==1){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    $ss=$db->prepare("UPDATE ".$prefix.$r['t']." SET suggestions=0 WHERE id=:id");
    $ss->execute([':id'=>$r['rid']]);
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
if($id==0&&$tbl=='pageviews'){
  $q=$db->query("UPDATE menu SET views='0'");
  $q->execute();
  $id='';
}
if($id==0&&$tbl=='contentviews'){
  $q=$db->prepare("UPDATE content SET views='0' WHERE contentType=:contentType");
  $q->execute([':contentType'=>$col]);
  $id='';
}
if($tbl=='orders'){
  $q=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE oid=:oid");
  $q->execute([':oid'=>$id]);
}
if($id!=0&&$id!='activity'){
  $q=$db->prepare("DELETE FROM `".$prefix.$tbl."` WHERE id=:id");
  $q->execute([':id'=>$id]);
  if($tbl=='media')$el='media_items_';
}
if($tbl=='livechat'){
  $q=$db->prepare("DELETE FROM `".$prefix."livechat` WHERE sid=:sid");
  $q->execute([':sid'=>$col]);?>
  window.top.window.$('#l_<?php echo$id;?>').removeClass('active');
  window.top.window.$('#l_<?php echo$id;?>').remove();
  window.top.window.$('#chatTitle').html('&nbsp;');
  window.top.window.$('#chatScreen').html('');
  window.top.window.$('#chatsid,#chataid,#chatemail,#chatname').val('');
  window.top.window.$('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
<?php }
if($tbl=='errorlog'){
  unlink('..'.DS.'media'.DS.'cache'.DS.'error.log');
  $el='l_';
  $id=0;
}
if($tbl=='choices'){?>
  window.top.window.$('#l_<?php echo$id;?>').addClass('animated zoomOut');
  window.top.window.setTimeout(function(){window.top.window.$('#l_<?php echo$id;?>').remove();},500);
  window.top.window.$('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
<?php }
echo'</script>';