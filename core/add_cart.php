<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Cart Item
 * @package    core/add_cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$iid=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$opt=$_POST['opt'];//filter_input(INPUT_POST,'opt',FILTER_UNSAFE_RAW);
$ti=time();
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
$rank=isset($_SESSION['rank'])?$_SESSION['rank']:0;
$limit=0;
$add=true;
if($rank!=0){
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([':id'=>$uid]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);
  if($ru['purchaseLimit']!=0)
    $limit=$ru['purchaseLimit'];
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
  $sc=$db->prepare("SELECT `id` FROM `".$prefix."cart` WHERE `iid`=:iid AND `si`=:si");
  $sc->execute([
    ':iid'=>$iid,
//    ':cid'=>$cid,
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
      $q=$db->prepare("SELECT `title`,`file`,`thumb`,`cost`,`rCost`,`dCost`,`stockStatus`,`points` FROM `".$prefix."content` WHERE `id`=:id");
      $q->execute([':id'=>$iid]);
      $r=$q->fetch(PDO::FETCH_ASSOC);
      if(is_numeric($r['cost'])||is_numeric($r['rCost'])||is_numeric($r['dCost'])){
        if($r['rCost']!=0)$r['cost']=$r['rCost'];
        if($rank>300||$rank<400){
          if(isset($ru['options'])&&$ru['options'][19]==1){
            if($r['dCost']!=0)$r['cost']=$r['dCost'];
          }
        }
        $q=$db->prepare("INSERT IGNORE INTO `".$prefix."cart` (`iid`,`contentType`,`title`,`file`,`quantity`,`cost`,`stockStatus`,`points`,`si`,`ti`) VALUES (:iid,'inventory',:title,:file,'1',:cost,:stockStatus,:points,:si,:ti)");
        $q->execute([
          ':iid'=>$iid,
          ':title'=>$r['title'],
          ':file'=>($r['thumb']!=''?$r['thumb']:$r['file']),
          ':cost'=>$r['cost'],
          ':stockStatus'=>$r['stockStatus'],
          ':points'=>$r['points'],
          ':si'=>SESSIONID,
          ':ti'=>$ti
        ]);
        $qid=$db->lastInsertId();

        if(!isset($_POST['answer'])){
          $scq=$db->prepare("SELECT * FROM `".$prefix."contentQuestions` WHERE `rid`=:rid ORDER BY `ti` ASC");
          $scq->execute([':rid'=>$iid]);
          while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
            $scb=$db->prepare("INSERT IGNORE INTO `".$prefix."orderQuestions` (`cid`,`rid`,`question`,`answer`,`ti`) VALUE (:cid,:rid,:question,:answer,:ti)");
            $scb->execute([
              ':cid'=>$iid,
              ':rid'=>$qid,
              ':question'=>$rcq['question'],
              ':answer'=>(isset($_POST['answer'.$rcq['id']])?$_POST['answer'.$rcq['id']]:''),
              ':ti'=>time()
            ]);
          }
        }
        if($opt!=''){
          $opts=explode(",",$opt);
          foreach($opts as $oid){
            $soi=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='option' AND `id`=:id");
            $soi->execute([':id'=>$oid]);
            while($roi=$soi->fetch(PDO::FETCH_ASSOC)){
              if($roi['oid']){
                $soic=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
                $soic->execute(['id'=>$roi['oid']]);
                $roic=$soic->fetch(PDO::FETCH_ASSOC);
                if($roi['quantity']==0||$roi['quantity']=='')$roi['quantity']=$roic['quantity'];
                if($roi['cost']==0||$roi['cost']==''){
                  if($roic['rrp']!=0)$roi['cost']=$roic['rrp'];
                  if($roic['cost']!=0)$roi['cost']=$roic['cost'];
                  if($roic['rCost']!=0)$roi['cost']=$roic['rCost'];
                  if($rank>300||$rank<400){
                    if($ru['options'][19]==1){
                      if($roic['dCost']!=0)$roi['cost']=$roic['dCost'];
                    }
                  }
                }
                if($roi['file']==''){
                  if($roic['thumb']!='')$roi['file']=($roic['thumb']!=''?$roic['thumb']:$roic['file']);
                }
                $roi['id']=$roic['id'];
              }
              $q=$db->prepare("INSERT IGNORE INTO `".$prefix."cart` (`iid`,`contentType`,`title`,`file`,`quantity`,`cost`,`stockStatus`,`points`,`si`,`ti`) VALUES (:iid,:contentType,:title,:file,'1',:cost,:stockStatus,:points,:si,:ti)");
              $q->execute([
                ':iid'=>$roi['id'],
                ':contentType'=>($roi['id']>0?'inventory':'option'),
                ':title'=>($roi['title']!=''?$roi['title']:(isset($roic['title'])?$roic['title']:'')),
                ':file'=>$roi['file'],
                ':cost'=>$roi['cost'],
                ':stockStatus'=>$roi['status'],
                ':points'=>(isset($roic['points'])?$roic['points']:0),
                ':si'=>SESSIONID,
                ':ti'=>$ti
              ]);
            }
          }
        }

      }
    }
  }
  $q=$db->prepare("SELECT SUM(`quantity`) as quantity FROM `".$prefix."cart` WHERE `si`=:si");
  $q->execute([':si'=>SESSIONID]);
  $r=$q->fetch(PDO::FETCH_ASSOC);
  echo$r['quantity'];
}
