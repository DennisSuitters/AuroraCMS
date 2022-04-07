<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Cart Item
 * @package    core/add_cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$iid=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$cid=filter_input(INPUT_POST,'cid',FILTER_SANITIZE_NUMBER_INT);
$ti=time();
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:$_SESSION['uid'];
$rank=isset($_SESSION['rank'])?$_SESSION['rank']:0;
$limit=0;
$add=true;
if($rank!=0){
  $config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
  $us=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
  $us->execute([':id'=>$uid]);
  $user=$us->fetch(PDO::FETCH_ASSOC);
  if($user['purchaseLimit']!=0)
    $limit=$user['purchaseLimit'];
  else{
    if($rank==200)$limit=$config['memberLimit'];
    if($rank==210)$limit=$config['memberLimitSilver'];
    if($rank==220)$limit=$config['memberLimitBronze'];
    if($rank==230)$limit=$config['memberLimitGold'];
    if($rank==240)$limit=$config['memberLimitPlatinum'];
    if($rank==310)$limit=$config['wholesaleLimit'];
    if($rank==320)$limit=$config['wholesaleLimitBronze'];
    if($rank==330)$limit=$config['wholesaleLimitSilver'];
    if($rank==340)$limit=$config['wholesaleLimitGold'];
    if($rank==350)$limit=$config['wholesaleLimitPlatinum'];
  }
  $sr=$db->prepare("SELECT `rank` FROM `".$prefix."content` WHERE `id`=:id");
  $sr->execute([':id'=>$iid]);
  $rr=$sr->fetch(PDO::FETCH_ASSOC);
  if($rank>309&&$rank<359){
    if($rr['rank']!=$rank){
      $add=false;
      echo'wholesaleoutside';
    }
  }else{
    if($limit>0){
      $sc=$db->prepare("SELECT SUM(`quantity`) AS 'quantity' FROM `".$prefix."cart` WHERE `si`=:si");
      $sc->execute([':si'=>SESSIONID]);
      $rc=$sc->fetch(PDO::FETCH_ASSOC);
      if($rc['quantity']>=$limit){
        $add=false;
        echo'nomore';
      }
    }
  }
}

if($add==true){
  $sc=$db->prepare("SELECT `id` FROM `".$prefix."cart` WHERE `iid`=:iid AND `cid`=:cid AND `si`=:si");
  $sc->execute([
    ':iid'=>$iid,
    ':cid'=>$cid,
    ':si'=>SESSIONID
  ]);
  if($sc->rowCount()>0){
    $q=$db->prepare("UPDATE `".$prefix."cart` SET `quantity`=`quantity`+1 WHERE `iid`=:iid AND `si`=:si");
    $q->execute([
      ':iid'=>$iid,
      ':si'=>SESSIONID
    ]);
  }else{
    if(isset($iid)&&$iid!=0){
      $q=$db->prepare("SELECT `cost`,`rCost`,`dCost`,`stockStatus`,`points` FROM `".$prefix."content` WHERE `id`=:id");
      $q->execute([':id'=>$iid]);
      $r=$q->fetch(PDO::FETCH_ASSOC);
      if(is_numeric($r['cost'])||is_numeric($r['rCost'])||is_numeric($r['dCost'])){
        if($r['rCost']!=0)$r['cost']=$r['rCost'];
        if($rank>300||$rank<400){
          if($r['dCost']!=0)$r['cost']=$r['dCost'];
        }
        $q=$db->prepare("INSERT IGNORE INTO `".$prefix."cart` (`iid`,`cid`,`quantity`,`cost`,`stockStatus`,`points`,`si`,`ti`) VALUES (:iid,:cid,'1',:cost,:stockStatus,:points,:si,:ti)");
        $q->execute([
          ':iid'=>$iid,
          ':cid'=>$cid,
          ':cost'=>$r['cost'],
          ':stockStatus'=>$r['stockStatus'],
          ':points'=>$r['points'],
          ':si'=>SESSIONID,
          ':ti'=>$ti
        ]);

      }
    }
  }
  $q=$db->prepare("SELECT SUM(`quantity`) as quantity FROM `".$prefix."cart` WHERE `si`=:si");
  $q->execute([':si'=>SESSIONID]);
  $r=$q->fetch(PDO::FETCH_ASSOC);
  echo$r['quantity'];
}
