<?php
require'../stripe/init.php';
$paymentIntent=$stripe->paymentIntents->retrieve(
  $_GET['payment_intent'],
);
if($paymentIntent->status=='succeeded'){
  $st=$db->prepare("UPDATE `".$prefix."orders` SET `paid_via`=:paid_via,`txn_id`=:txn_id,`paid_amount`=:paid_amount,`payment_status`=:payment_status,`paid_ti`=:paid_ti,`status`=:status WHERE `id`=:id");
  $st->execute([
    ':id'=>$r['id'],
    ':paid_via'=>'stripe',
    ':txn_id'=>$paymentIntent->id,
    ':paid_amount'=>$paymentIntent->amount,
    ':payment_status'=>$paymentIntent->status,
    ':paid_ti'=>time(),
    ':status'=>$paymentIntent->status=='succeeded'?'paid':$r['status']
  ]);
}
if($paymentIntent->status=='success'){
  echo'<div class="p-2"><div class="alert alert-success">Payment using AfterPay Successful!</div></div>';
}else{
  echo'<div class="p-2"><div class="alert alert-danger">There was an issue processing your transaction!</div></div>';
}
