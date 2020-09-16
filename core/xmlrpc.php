<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - XMLRPC Blacklister
 * @package    core/xmlrpc.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$ti=time();
echo'Thank you for giving the system an excuse to Blacklist your IP... <strong>'.$ip.'</strong>';
$s=$db->prepare("DELETE FROM `".$prefix."iplist` WHERE `ti`<:ti");
$s->execute([
  ':ti'=>time()-2592000]
);
$s=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE `ip`=:ip");
$s->execute([
  ':ip'=>$ip
]);
if($s->rowCount()<1){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`ti`) VALUES (:ip,:oti,:ti)");
  $sql->execute([
    ':ip'=>$ip,
    ':oti'=>$ti,
    ':ti'=>time()
  ]);
}
