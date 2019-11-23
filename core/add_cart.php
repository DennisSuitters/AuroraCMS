<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Cart Item
 * @package    core/add_cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.7 Add Parsing for RRP and Reduced Cost Prices.
 */
require'db.php';
$iid=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$cid=filter_input(INPUT_GET,'cid',FILTER_SANITIZE_NUMBER_INT);
$ti=time();
$sc=$db->prepare("SELECT id FROM `".$prefix."cart` WHERE iid=:iid AND cid=:cid AND si=:si");
$sc->execute([
  ':iid'=>$iid,
  ':cid'=>$cid,
  ':si'=>SESSIONID
]);
if($sc->rowCount()>0){
  $q=$db->prepare("UPDATE `".$prefix."cart` SET quantity=quantity+1 WHERE iid=:iid AND si=:si");
  $q->execute([
    ':iid'=>$iid,
    ':si'=>SESSIONID
  ]);
}else{
  if(isset($iid)&&$iid!=0){
    $q=$db->prepare("SELECT cost,rCost FROM `".$prefix."content` WHERE id=:id");
    $q->execute([':id'=>$iid]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    if(is_numeric($r['cost'])){
      if($r['cost']!=0)$r['cost']=$r['rCost'];
      $q=$db->prepare("INSERT INTO `".$prefix."cart` (iid,cid,quantity,cost,si,ti) VALUES (:iid,:cid,'1',:cost,:si,:ti)");
      $q->execute([
        ':iid'=>$iid,
        ':cid'=>$cid,
        ':cost'=>$r['cost'],
        ':si'=>SESSIONID,
        ':ti'=>$ti
      ]);
    }
  }
}
$q=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
$q->execute([':si'=>SESSIONID]);
$r=$q->fetch(PDO::FETCH_ASSOC);
echo$r['quantity'];
