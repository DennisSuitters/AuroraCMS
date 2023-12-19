<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Remove Contact
 * @package    core/removecontact.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'id',FILTER_UNSAFE_RAW);
$s=$db->prepare("DELETE FROM `".$prefix."login` WHERE `id`=:id");
$s->execute([':id'=>$id]);
$s=$db->prepare("DELETE FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=:id");
$s->execute([':id'=>$id]);
echo'<script>'.
  'window.top.window.$("#contactListItem'.$id.'").addClass("remove-item");'.
  'window.top.window.setTimeout(function(){window.top.window.$("#contactListItem'.$id.'").remove();},500);'.
  'window.top.window.$("#l_'.$id.'").addClass("remove-item");'.
  'window.top.window.setTimeout(function(){window.top.window.$("#l_'.$id.'").remove();},500);'.
'</script>';
