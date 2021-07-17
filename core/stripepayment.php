<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Stripe Order Manipulator
 * @package    core/stripetransaction.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$error='';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$orderID=filter_input(INPUT_POST,'orderID',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`=:id OR `iid`=:id AND `status`!='archived'");
$s->execute([':id'=>$orderID]);
$payment_id=0;
$statusMsg='';
$ordStatus='error';
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
}else$error='<div class="alert alert-danger">Order Does NOT Exist!</div>';
if($error==''){
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
  $su->execute([':uid'=>$r['cid']]);
  if($su->rowCount()>0){
    $ru=$su->fetch(PDO::FETCH_ASSOC);
  }else$error='<div class="alert alert-danger">User Does Not Exist!</div>';
}
if($error==''){
  $itemName=$r['qid'].$r['iid'];
  $itemNumber=$r['qid'].$r['iid'];
  $itemPrice=$r['total'];
  $currency="AUD";
  define('STRIPE_PUBLISHABLE_KEY',$config['stripe_publishkey']);
  define('STRIPE_API_KEY',$config['stripe_secretkey']);
  if(!empty($_POST['stripeToken'])){
    $token=$_POST['stripeToken'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    require'stripe/init.php';
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
    try{
      $customer = \Stripe\Customer::create([
        'email'=>$email,
        'source'=>$token
      ]);
    }catch(Exception $e){
      $api_error=$e->getMessage();
    }
    if(empty($api_error)&&$customer){
      $itemPriceCents=($itemPrice*100);
      try{
        $charge = \Stripe\Charge::create([
          'shipping'=>[
            'name'=>$ru['name'],
            'address'=>[
              'line1'=>$ru['address'],
              'city'=>$ru['city'],
              'state'=>$ru['state'],
              'country'=>$ru['country'],
              'postal_code'=>$ru['postcode'],
            ],
          ],
          'customer'=>$customer->id,
          'amount'=>$itemPriceCents,
          'currency'=>$currency,
          'description'=>$itemName
        ],
      );
      }catch(Exception $e){
        $api_error=$e->getMessage();
      }
      if(empty($api_error)&&$charge){
        $chargeJson=$charge->jsonSerialize();
        if($chargeJson['amount_refunded']==0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured']==1){
          $transactionID=$chargeJson['balance_transaction'];
          $paidAmount=$chargeJson['amount'];
          $paidAmount=($paidAmount/100);
          $paidCurrency=$chargeJson['currency'];
          $payment_status=$chargeJson['status'];
          if($payment_status=='succeeded'){
            $st=$db->prepare("UPDATE `".$prefix."orders` SET `paid_via`=:paid_via,`txn_id`=:txn_id,`paid_email`=:paid_email,`paid_name`=:paid_name,`paid_amount`=:paid_amount,`payment_status`=:payment_status,`paid_ti`=:paid_ti,`status`=:status WHERE `id`=:id");
            $st->execute([
              ':id'=>$r['id'],
              ':paid_via'=>'stripe',
              ':txn_id'=>$transactionID,
              ':paid_email'=>$email,
              ':paid_name'=>$name,
              ':paid_amount'=>$paidAmount,
              ':payment_status'=>($payment_status=='succeeded'?'paid':'error'),
              ':paid_ti'=>time(),
              ':status'=>($payment_status=='succeeded'?'paid':$r['status'])
            ]);
            $payment_id=$r['id'];
            $sp=$db->prepare("SELECT `id`,`points`,`quantity` WHERE `oid`=:oid");
            $sp->execute([':oid'=>$r['id']]);
            $points=0;
            while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
              if($rp['points']>0)$points=$points+($rp['points']*$rp['quantity']);
            }
            $sc=$db->prepare("UPDATE `".$prefix."login` SET `spent`=:spent,`points`=:points,`pti`=:pti WHERE `id`=:id");
            $sc->execute([
              ':id'=>$ru['id'],
              ':spent'=>$ru['spent']+$paidAmount,
              ':points'=>$ru['points']+$points,
              ':pti'=>time()
            ]);
            $ordStatus="success";
            $statusMsg="Your Payment has been Successful!";
          }else
            $statusMsg="Your Payment has Failed!";
        }else
          $statusMsg="Transaction Failed!";
      }else
        $statusMsg="Charge creation failed! $api_error";
    }else
      $statusMsg="Invalid card details! $api_error";
  }else
    $statusMsg="Error on form submission.";
}
$html='';
if($error==''){
  if($payment_id>0){
    $el='payment-info';
    $html.='<article class="col-12 col-sm-6 text-center"><div class="alert alert-success">'.
      $statusMsg.'<br><br>'.
      '<a href="'.URL.'orders" class="btn-link">Back to Order Page</a>'.
    '</div>';
  }else{
    $el='paymentFrm';
    $html.='<div class="alert alert-danger">'.
      'There was an Issue Processing Your Payment!<br><br>'.
      '<a href="'.URL.'orders" class="btn-link">Back to Order Page</a>'.
    '</div>';
  }
}else{
  $el='paymentFrm';
  $html=$error;
}
echo'<script>window.top.window.$("#'.$el.'").html(`'.$html.'`);</script>';
