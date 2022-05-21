<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Tracker To Blacklist
 * @package    core/trackertoblacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$ip=isset($_POST['ip'])?filter_input(INPUT_POST,'ip',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'ip',FILTER_UNSAFE_RAW);
if($ip!=''){
  $s=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE `ip`=:ip ORDER BY `ti` DESC LIMIT 1");
  $s->execute([
    ':ip'=>$ip
  ]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    $sq=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`reason`,`permanent`,`ti`) VALUES (:ip,:oti,:reason,1,:ti)");
    $sq->execute([
      ':ip'=>$ip,
      ':oti'=>$r['ti'],
      ':reason'=>'Added via Visitor Tracker',
      ':ti'=>time()
    ]);
    $sq=$db->prepare("UPDATE `".$prefix."tracker` SET `status`='blacklisted' WHERE `ip`=:ip");
    $sq->execute([':ip'=>$ip]);
    echo'success';
  }else echo'error';
}else echo'error';
