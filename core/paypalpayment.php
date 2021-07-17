<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - PayPal Order Manipulator
 * @package    core/paypaltransaction.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$ti=time();
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
$txnid=filter_input(INPUT_POST,'txnid',FILTER_SANITIZE_STRING);
$paidAmount=filter_input(INPUT_POST,'amount',FILTER_SANITIZE_NUMBER_INT);
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING;
$msg='error';
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
$s->execute([':id'=>$id]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
  $su->execute([':uid'=>$r['cid']]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);
  $st=$db->prepare("UPDATE `".$prefix."orders` SET `paid_via`=:paid_via,`txn_id`=:txn_id,`paid_email`=:paid_email,`paid_name`=:paid_name,`paid_amount`=:paid_amount,`payment_status`=:payment_status,`paid_ti`=:paid_ti,`status`=:status WHERE `id`=:id");
  $st->execute([
    ':id'=>$r['id'],
    ':paid_via'=>'paypal',
    ':txn_id'=>$txnid,
    ':paid_email'=>$email,
    ':paid_name'=>$name,
    ':paid_amount'=>$paidAmount,
    ':payment_status'=>'paid',
    ':paid_ti'=>time(),
    ':status'=>'paid'
  ]);
  $sp=$db->prepare("SELECT `id`,`points`,`quantity` WHERE `oid`=:oid");
  $sp->execute([':oid'=>$r['id']]);
  $points=0;
  while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
    if($rp['points']>0)$points=$points+($rp['points']*$rp['quantity']);
  }
  $sc=$db->prepare("UPDATE `".$prefix."login` SET `spent`=:spent,`points`=:points`pti`=:pti WHERE `id`=:id");
  $sc->execute([
    ':id'=>$ru['id'],
    ':spent'=>$ru['spent']+$paidAmount,
    ':points'=>$ru['points']+$points,
    ':pti'=>time()
  ]);
  $msg='success';
}
echo$msg;
