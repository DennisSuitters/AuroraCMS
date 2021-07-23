<?php
require'../db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
define('STRIPE_PUBLISHABLE_KEY',$config['stripe_publishkey']);
define('STRIPE_SECRET_KEY',$config['stripe_secretkey']);
define('STRIPE_WEBHOOK_SECRET','');
require'../stripe/init.php';
$oid=$_GET['oid'];
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`=:oid OR `iid`=:oid");
$s->execute([':oid'=>$oid]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$su->execute([':id'=>$r['cid']]);
$ru=$su->fetch(PDO::FETCH_ASSOC);
$stripe=new \Stripe\StripeClient([
  'api_key'=>STRIPE_SECRET_KEY,
  'stripe_version'=>'2020-08-27',
]);
try{
  $paymentIntent = $stripe->paymentIntents->create([
    'payment_method_types'=>['card','afterpay_clearpay'],
    'amount'=>round($r['total'] * 100),
    'currency'=>'aud',
    'payment_method_options'=>[
      'afterpay_clearpay'=>[
        'reference'=>$oid,
      ],
    ],
  ]);
}catch(\Stripe\Exception\ApiErrorException $e){
  http_response_code(400);
  error_log($e->getError()->message);
  echo'<h4>Error</h4>'.
  '<p>Failed to create a PaymentIntent</p>'.
  '<p>Please check the server logs for more information</p>';
  exit;
}catch(Exception $e){
  error_log($e);
  http_response_code(500);
  exit;
}?>
<script src="https://js.stripe.com/v3/"></script>
<script src="utils.js"></script>
<script>
  document.addEventListener('DOMContentLoaded',async()=>{
    const stripe=Stripe('<?= STRIPE_PUBLISHABLE_KEY;?>',{
      apiVersion:'2020-08-27',
    });
    const paymentForm=document.querySelector('#payment-form');
    paymentForm.addEventListener('submit',async(e)=>{
      e.preventDefault();
      const {error,paymentIntent}=await stripe.confirmAfterpayClearpayPayment(
        '<?=$paymentIntent->client_secret;?>',{
          payment_method:{
            billing_details:{
              name:document.querySelector('#afterpay_name').value,
              email:document.querySelector('#afterpay_email').value,
              address:{
                line1:document.querySelector('#afterpay_line1').value,
                line2:document.querySelector('#afterpay_line2').value,
                city:document.querySelector('#afterpay_city').value,
                state:document.querySelector('#afterpay_state').value,
                postal_code:document.querySelector('#afterpay_postal_code').value,
                country:document.querySelector('#afterpay_country').value,
              }
            },
          },
          shipping:{
            name:document.querySelector('#afterpay_shipping_name').value,
            address:{
              line1:document.querySelector('#afterpay_shipping_line1').value,
              line2:document.querySelector('#afterpay_shipping_line2').value,
              city:document.querySelector('#afterpay_shipping_city').value,
              state:document.querySelector('#afterpay_shipping_state').value,
              postal_code:document.querySelector('#afterpay_shipping_postal_code').value,
              country:document.querySelector('#afterpay_shipping_country').value,
            }
          },
          return_url:`core/afterpay/return.php?oid=`.$oid,
        },
      );
      if(error){
        addMessage(error.message);
        return;
      }
      addMessage(`Payment (${paymentIntent.id}): ${paymentIntent.status}`);
    });
  });
</script>
<div class="popup-payment p-2">
  <h4 class="mt-3 mb-2 text-center">Pay via <img src="core/images/afterpay.svg" alt="Afterpay"></h4>
  <div class="row">
    <div class="col-12 col-sm-6 m-0 p-0">
      <form id="payment-form">
        <fieldset class="m-1">
          <legend class="m-0 p-0">Billing</legend>
          <label for="afterpay_name" class="mt-0 mb-0">Name</label>
          <input id="afterpay_name" value="<?=$ru['name']!=''?$ru['name']:'';?>" placeholder="Enter a Name..." required aria-required="true">
          <label for="afterpay_email" class="mt-1 mb-0">Email</label>
          <input type="email" id="afterpay_email" value="<?=$ru['email']!=''?$ru['email']:'';?>" placeholder="Enter an Email..." required  aria-required="true">
          <label for="afterpay_line1" class="mt-1 mb-0">Address Line 1</label>
          <input id="afterpay_line1" value="<?=$ru['address']!=''?$ru['address']:'';?>" placeholder="Enter an Address..." required aria-required="true">
          <label for="afterpay_line2" class="mt-1 mb-0">Address Line 2</label>
          <input id="afterpay_line2" value="" placeholder="Enter Extra Address Info if needed...">
          <label for="afterpay_city" class="mt-1 mb-0">City</label>
          <input id="afterpay_city" value="<?=$ru['city']!=''?$ru['city']:'';?>" placeholder="Enter a City...">
          <label for="afterpay_state" class="mt-1 mb-0">State</label>
          <input id="afterpay_state" value="<?=$ru['state']!=''?$ru['state']:'';?>" placeholder="Enter a State...">
          <label for="afterpay_postal_code" class="mt-1 mb-0">Postal code</label>
          <input id="afterpay_postal_code" value="<?=$ru['postcode']!=0?$ru['postcode']:'';?>" placeholder="Enter a Postcode...">
          <label for="afterpay_country" class="mt-1 mb-0">Country</label>
          <select id="afterpay_country">
            <option value="AU">Australia</option>
            <option value="NZ">New Zealand</option>
            <option value="UK">United Kingdom</option>
            <option value="US">United States</option>
          </select>
        </fieldset>
      </div>
      <div class="col-12 col-sm-6">
        <fieldset class="m-1">
          <legend class="m-0 p-0">Shipping</legend>
          <label for="afterpay_shipping_name" class="mt-0 mb-0">Name</label>
          <input id="afterpay_shipping_name" value="<?=$ru['name']!=''?$ru['name']:'';?>" placeholder="Enter a Name..." required aria-required="true">
          <label for="afterpay_shipping_line1" class="mt-1 mb-0">Address Line 1</label>
          <input id="afterpay_shipping_line1" value="<?=$ru['address']!=''?$ru['address']:'';?>" placeholder="Enter an Address..." required aria-required="true">
          <label for="afterpay_shipping_line2" class="mt-1 mb-0">Address Line 2</label>
          <input id="afterpay_shipping_line2" value="" placeholder="Enter Extra Address Info if needed...">
          <label for="afterpay_shipping_city" class="mt-1 mb-0">City</label>
          <input id="afterpay_shipping_city" value="<?=$ru['city']!=''?$ru['city']:'';?>" placeholder="Enter a City...">
          <label for="afterpay_shipping_state" class="mt-1 mb-0">State</label>
          <input id="afterpay_shipping_state" value="<?=$ru['state']!=''?$ru['state']:'';?>" placeholder="Enter a State...">
          <label for="afterpay_shipping_postal_code" class="mt-1 mb-0">Postal code</label>
          <input id="afterpay_shipping_postal_code" value="<?=$ru['postcode']!=0?$ru['postcode']:'';?>" placeholder="Enter a Postcode...">
          <label for="afterpay_shipping_country" class="mt-1 mb-0">Country</label>
          <select id="afterpay_shipping_country">
            <option value="AU">Australia</option>
            <option value="NZ">New Zealand</option>
            <option value="UK">United Kingdom</option>
            <option value="US">United States</option>
          </select>
        </fieldset>
        <button id="submit" class="btn-block mt-3">Pay</button>
      </div>
    </form>
  <div id="messages" role="alert" style="display: none;"></div>
</div>
