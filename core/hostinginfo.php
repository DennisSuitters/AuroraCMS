<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Hosting Info
 * @package    core/hostinginfo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$origin=isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:'*';
header("Access-Control-Allow-Headers: X-Requested-With");
header('Access-Control-Allow-Origin: '.$origin);
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json');
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$hash=isset($_GET['h'])?$_GET['h']:'';
if($hash!=''){
  $s=$db->prepare("SELECT `id`,`hti`,`hostCost`,`hostStatus`,`sti`,`siteCost`,`siteStatus`,`url` FROM `".$prefix."login` WHERE `infoHash`=:hash");
  $s->execute([
    ':hash'=>$hash
  ]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    $ti=time();
    $days=0;
    if($r['hti'] > $ti){
      $days = ceil(abs($r['hti'] - $ti) / 86400);
    }
    if($r['hti'] < $ti){
      $days = ceil(abs($ti - $r['hti']) / 86400);
      if($r['hostStatus']=='paid'){
        $su=$db->prepare("UPDATE `".$prefix."login` SET `hostStatus`='overdue' WHERE `id`=:id");
        $su->execute([
          ':id'=>$r['id']
        ]);
        $r['hostStatus']='overdue';
      }
    }
    echo json_encode(array(
      "hostCost" => $r['hostCost'],
      "hostDays" => $days,
      "hostDate" => date($config['dateFormat'],$r['hti']),
      "hostStatus" => $r['hostStatus'],
      "siteCost" => $r['siteCost'],
      "siteDate" => $r['sti']>0?date($config['dateFormat'],$r['sti']):0,
      "siteStatus" => $r['siteStatus']
    ));
  }
}
