<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Restore Item
 * @package    core/restore.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<script>';
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$uid=$_SESSION['uid'];
$s=$db->prepare("SELECT * FROM `".$prefix."logs` WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$tbl=$r['refTable'];
$col=$r['refColumn'];
$sl=$db->prepare("UPDATE `".$prefix.$tbl."` SET $col=:da WHERE id=:id");
$sl->execute([
  ':da'=>$r['oldda'],
  ':id'=>$r['rid']
]);
if($col=='notes'){?>
  if(window.top.window.$('.summernote')){
    window.top.window.$('.summernote').summernote('code','<?php echo rawurldecode($r['oldda']);?>');
  }
<?php }else{?>
  if(window.top.window.$('#<?php echo$col;?>')){
    window.top.window.$('#<?php echo$col;?>').val('<?php echo$r['oldda'];?>');
  }
<?php }?>
  window.top.window.Pace.stop();
<?php
echo'</script>';
