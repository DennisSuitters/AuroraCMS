<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Get EXIF Image Information
 * @package    core/getexif.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Tidy up code and reduce footprint.
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
echo'<script>window.top.window.$("#notification").html("");</script>';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT `file` FROM ".$prefix."$t WHERE `id`=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
if($r['file']!=''){
  switch($c){
    case'exifFilename':
      $out=basename($r['file']);
      break;
    case'exifCamera':
      $out='Camera';
      break;
    case'exifLens':
      $out='Lens';
      break;
    case'exifAperture':
      $out='Aperture';
      break;
    case'exifFocalLength':
      $out='Focal Length';
      break;
    case'exifShutterSpeed':
      $out='Shutter Speed';
      break;
    case'exifISO':
      $out='ISO';
      break;
    case'exifti':
      $out=time();
      break;
    default:
      $out='nothing';
  }
  $s=$db->prepare("UPDATE ".$prefix."$t SET `".$c."`=:out WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':out'=>$out
  ]);
  echo'<script>window.top.window.$("#'.$c.'").val(`'.$out.'``);</script>';
}else echo'<script>window.top.window.toastr["info"](`There is no image to get the EXIF Info from!`);</script>';
