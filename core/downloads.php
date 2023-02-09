<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Downloads
 * @package    core/downloads.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/db.php';
$config=$db->query("SELECT `development`,`seoTitle`,`theme` FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$ti=time();
$file=isset($args[0])?$args[0]:'';
$oc=isset($_GET['oc'])?filter_input(INPUT_GET,'oc',FILTER_SANITIZE_STRING):'';
if($file!=''){
  $s=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='download' AND `url`=:file");
  $s->execute([':file'=>$file]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    if($r['password']==1){
      $so=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `iid`=:iid");
      $so->execute([':iid'=>$oc]);
      if($so->rowCount()>0){
        $ro=$so->fetch(PDO::FETCH_ASSOC);
        if($r['tie']==0){
          SendFileDownload($r['url']);
        }else{
          $tichk=$ro['iid_ti'] + $r['tie'];
          if($ti < $tichk){
            SendFileDownload($r['url']);
          }else
            echo'File has expired, or is no longer available';
        }
      }else
        echo'File has expired, or is no longer available';
    }else
      SendFileDownload($r['url']);
  }else
    echo'File has expired, or is no longer available';
}else
  echo'No file/s to download';
function SendFileDownload($file){
  header("Content-Type: application/octet-stream"); // 1
  header('Content-Disposition: attachment; filename='.basename($file));
  header("Content-Type: application/download"); // 2
  readfile('media/downloads/'.$file);
}
