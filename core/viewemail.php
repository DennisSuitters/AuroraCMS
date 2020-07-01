<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - View Email
 * @package    core/viewemail.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
if($id!=0){
  $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE id=:id");
  $s->execute([':id'=>$id]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($r['notes_html']=='')$r['notes_html']=$r['notes_plain'];
  if($r['notes_html']=='')$r['notes_html']=$r['notes_raw'];
  if(is_base64_string($r['notes_html']))$r['notes_html']=base64_decode($r['notes_html']);
  print quoted_printable_decode($r['notes_html']);
}
function is_base64_string($s){
  if(($b=base64_decode($s,TRUE))===FALSE)return FALSE;
  $e=mb_detect_encoding($b);
  if(in_array($e,array('UTF-8','ASCII')))return TRUE;
  else return FALSE;
}
