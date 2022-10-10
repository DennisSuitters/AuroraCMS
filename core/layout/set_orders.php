<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Orders
 * @package    core/layout/set_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * https://auspost.com.au/forms/pacpcs-registration.html
 * https://github.com/fontis/auspost-api-php
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid p-2">
      <div class="card mt-3 p-4 border-radius-0 bg-white border-0 shadow overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
                <li class="breadcrumb-item active">Settings</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?php if(isset($_SERVER['HTTP_REFERER'])){?>
                  <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>
                <?php }?>
                <button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save</i></button>
              </div>
            </div>
          </div>
        </div>
        <legend id="postageOptions" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#postageOptions" data-tooltip="tooltip" aria-label="PermaLink to Postage Options Section">&#128279;</a>':'';?>Postage Options</legend>
        <form target="sp" method="post" action="core/add_postoption.php">
          <div class="form-row">
            <div class="input-text">Code</div>
            <input id="pco" name="c" type="text" value="" placeholder="Enter Code..." list="post_code_options" oninput="getPostCodeOption();">
            <datalist id="post_code_options">
              <option label="Australia Post Regular Post" data-title="Australia Post Regular Post" value="AUS_PARCEL_REGULAR">
              <option label="Australia Post Express Post" data-title="Australia Post Express Post" value="AUS_PARCEL_EXPRESS">
            </datalist>
            <script>
              function getPostCodeOption(){
                var selectedTitle = document.getElementById("pco").value;
                document.querySelector('#post_title').value = document.querySelector(`#post_code_options option[value='${selectedTitle}']`).dataset.title;
              }
            </script>
            <div class="input-text">Title</div>
            <input id="post_title" name="t" type="text" value="" placeholder="Enter an Option...">

            <div class="input-text">Cost</div>
            <input name="v" type="text" value="" placeholder="Enter Cost...">
            <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
          </div>
        </form>
        <div id="postoption">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' AND `uid`=0 ORDER BY `title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div class="form-row mt-1" id="l_<?=$rs['id'];?>">
              <div class="input-text">Code</div>
              <input id="c<?=$rs['id'];?>" name="code" type="text" value="<?=$rs['type'];?>" readonly>
              <div class="input-text">Title</div>
              <input id="t<?=$rs['id'];?>" name="service" type="text" value="<?=$rs['title'];?>" readonly>
              <div class="input-text">Cost</div>
              <input id="v<?=$rs['id'];?>" name="cost" type="text" value="<?=$rs['value']!=0?$rs['value']:'';?>" readonly>
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?=$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend id="trackingOptions" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#trackingOptions" data-tooltip="tooltip" aria-label="PermaLink to Postage Tracking Options Section">&#128279;</a>':'';?>Postage Tracking Options</legend>
        <form target="sp" method="post" action="core/add_trackoption.php">
          <div class="form-row">
            <div class="input-text">Service</div>
            <input name="s" type="text" value="" placeholder="Enter a Service...">
            <div class="input-text">URL</div>
            <input name="u" type="text" value="" placeholder="Enter a URL...">
            <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
          </div>
        </form>
        <div id="trackoption">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='trackoption' AND `uid`=0 ORDER BY `title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div class="form-row mt-1" id="l_<?=$rs['id'];?>">
              <div class="input-text">Service</div>
              <input id="s<?=$rs['id'];?>" name="service" type="text" value="<?=$rs['type'];?>" readonly>
              <div class="input-text">URL</div>
              <input id="u<?=$rs['id'];?>" name="service" type="text" value="<?=$rs['title'];?>" readonly>
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?=$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend id="australiaPost"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#australiaPost" data-tooltip="tooltip" aria-label="PermaLink to Australia Post Section">&#128279;</a>':'';?>Australia Post</legend>
        <div id="australiaPostAPIKey" class="form-row">
          <label for="austPostAPIKey"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#australiaPostAPIKey" data-tooltip="tooltip" aria-label="PermaLink to Australia Post API Key">&#128279;</a>':'';?>API&nbsp;Key</label>
          <small class="form-text text-right">Visit <a target="_blank" href="https://auspost.com.au/forms/pacpcs-registration.html">AustPost API</a> to regsiter and get an API Key.</small>
        </div>
        <div class="form-row">
          <input class="textinput" id="austPostAPIKey" data-dbid="1" data-dbt="config" data-dbc="austPostAPIKey" type="text" value="<?=$config['austPostAPIKey'];?>" placeholder="Enter your Australia Post API Code...">
          <button class="save" id="saveaustPostAPIKey" data-dbid="austPostAPIKey" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <legend id="paymentOptions" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#paymentOptions" data-tooltip="tooltip" aria-label="PermaLink to Payment Options Section">&#128279;</a>':'';?>Payment Options</legend>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#displayPaymentOptions" data-tooltip="tooltip" aria-label="PermaLink to Display Payment Options Checkbox">&#128279;</a>':'';?>
          <input id="displayPaymentOptions" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="7" type="checkbox"<?=$config['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="displayPaymentOptions" id="configoptions71">Display Payment Options Logo's (Logo's should be contained within the Template tags).</label>
        </div>
<?php /* Payment Options to Pay Orders */?>
        <div class="form-row mt-3">
          <label id="payOptions"><?=$user['rank']>899?'<a class="permalink" data-tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#payOptions" data-tooltip="tooltip" aria-label="Permalink to Payment Options Section">&#128279;</a>':''?>Payment&nbsp;Options</label>
          <small class="form-text text-right">A value of `0` disables the Surcharge being added to the Order.</small>
        </div>
        <form target="sp" method="post" action="core/add_payoption.php">
          <div class="form-row">
            <div class="input-text">Option</div>
            <input name="t" type="text" value="" placeholder="Enter Option...">
            <div class="input-text">Surcharge</div>
            <select class="col-3" name="m">
              <option value="1">Add %</option>
              <option value="2">Add $</option>
            </select>
            <input name="v" type="number" value="0">
            <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
          </div>
        </form>
        <div id="payoptionl">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='payoption' AND `uid`=0");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?=$rs['id'];?>" class="form-row mt-1">
              <div class="input-text">Option</div>
              <input type="text" value="<?=$rs['title'];?>" readonly>
              <div class="input-text">Surcharge</div>
              <input class="col-3" type="text" value="<?=$rs['type']==2?'Add $':'Add %';?>" readonly>
              <input type="text" value="<?=$rs['value'];?>" readonly>
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?=$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" type="submit" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
              </form>
            </div>
          <?php }?>
        </div>
        <label id="orderGST" for="gst"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#orderGST" data-tooltip="tooltip" aria-label="PermaLink to GST">&#128279;</a>':'';?>Add&nbsp;GST&nbsp;as&nbsp;Percentage</label>
        <div class="form-row">
          <input class="textinput" id="gst" data-dbid="1" data-dbt="config" data-dbc="gst" type="number" value="<?=$config['gst'];?>" placeholder="Enter a GST Value...">
          <button class="save" id="savegst" data-dbid="gst" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <hr>
        <legend id="discountRanges"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#discountRanges" data-tooltip="tooltip" aria-label="PermaLink to Discount Ranges Options Section">&#128279;</a>':'';?>Discount Ranges</legend>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#discountRangeCalculations" data-tooltip="tooltip" aria-label="PermaLink to Discount Ranges Calculations Checkbox">&#128279;</a>':'';?>
          <input id="discountRangeCalculations" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="26" type="checkbox"<?=$config['options'][26]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="discountRangeCalculations" id="configoptions261">Discount Range Calculations</label>
        </div>
        <form target="sp" method="post" action="core/add_discountrange.php">
          <div class="form-row">
            <div class="input-text">From $</div>
            <input name="f" type="number" value="" placeholder="Enter Code...">
            <div class="input-text">To $</div>
            <input name="t" type="number" value="" placeholder="Enter an Option...">
            <div class="input-text">Method</div>
            <select name="m">
              <option value="1">$ Off</option>
              <option value="2">&#37; Off</option>
            </select>
            <div class="input-text">Value</div>
            <input name="v" type="number" value="" placeholder="Enter Cost...">
            <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
          </div>
        </form>
        <div class="mt-1" id="discountrange">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `uid`=0 ORDER BY `t` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?=$rs['id'];?>" class="form-row">
              <div class="input-text">From &#36;</div>
              <input type="number" value="<?=$rs['f'];?>" readonly>
              <div class="input-text">To &#36;</div>
              <input type="number" value="<?=$rs['t'];?>" readonly>
              <div class="input-text">Method</div>
              <input type="text" value="<?=$rs['value']==2?'&#37; Off':'&#36; Off';?>" readonly>
              <div class="input-text">Value</div>
              <input type="number" value="<?=$rs['cost'];?>" readonly>
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?=$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend id="banking"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#banking" data-tooltip="tooltip" aria-label="PermaLink to Banking Section">&#128279;</a>':'';?>Banking</legend>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-3">
            <label id="bankName" for="bank"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#bankName" data-tooltip="tooltip" aria-label="PermaLink to Bank">&#128279;</a>':'';?>Bank</label>
            <div class="form-row">
              <input class="textinput" id="bank" data-dbid="1" data-dbt="config" data-dbc="bank" type="text" value="<?=$config['bank'];?>" placeholder="Enter Bank...">
              <button class="save" id="savebank" data-dbid="bank" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-3">
            <label id="accountName" for="bankAccountName"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#accountName" data-tooltip="tooltip" aria-label="PermaLink to Account Name">&#128279;</a>':'';?>Account Name</label>
            <div class="form-row">
              <input class="textinput" id="bankAccountName" data-dbid="1" data-dbt="config" data-dbc="bankAccountName" type="text" value="<?=$config['bankAccountName'];?>" placeholder="Enter an Account Name...">
              <button class="save" id="savebankAccountName" data-dbid="bankAccountName" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-3">
            <label id="accountNumber" for="bankAccountNumber"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#accountNumber" data-tooltip="tooltip" aria-label="PermaLink to Account Number">&#128279;</a>':'';?>Account Number</label>
            <div class="form-row">
              <input class="textinput" id="bankAccountNumber" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" type="text" value="<?=$config['bankAccountNumber'];?>" placeholder="Enter an Account Number...">
              <button class="save" id="savebankAccountNumber" data-dbid="bankAccountNumber" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-3">
            <label id="accountBSB" for="bankBSB"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#accountBSB" data-tooltip="tooltip" aria-label="PermaLink to Account BSB">&#128279;</a>':'';?>BSB</label>
            <div class="form-row">
              <input class="textinput" id="bankBSB" data-dbid="1" data-dbt="config" data-dbc="bankBSB" type="text" value="<?=$config['bankBSB'];?>" placeholder="Enter a BSB...">
              <button class="save" id="savebankBSB" data-dbid="bankBSB" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
          </div>
        </div>
        <hr>
        <legend id="paypal"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#paypal" data-tooltip="tooltip" aria-label="PermaLink to Pay Pal Section">&#128279;</a>':'';?>PayPal</legend>
        <div id="paypalID" class="form-row">
          <label for="payPalClientID"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#paypalID" data-tooltip="tooltip" aria-label="PermaLink to Pay Pal Client ID">&#128279;</a>':'';?>Client&nbsp;ID</label>
          <?php if($config['payPalClientID']==''||$config['payPalSecret']==''){?>
            <small class="form-text text-right">You will need to a <a target="_blank" href="https://www.paypal.com/au/business">PayPal Business</a> Account to get a Client ID.</small>
          <?php }?>
        </div>
        <div class="form-row">
          <input class="textinput" id="payPalClientID" data-dbid="1" data-dbt="config" data-dbc="payPalClientID" type="text" value="<?=$config['payPalClientID'];?>" placeholder="Enter a PayPal Client ID...">
          <button class="save" id="savepayPalClientID" data-dbid="payPalClientID" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
<?php /*
        <div class="form-group row">
          <label for="payPalSecret" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">PayPal Secret</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="payPalSecret" class="form-control textinput" value="<?=$config['payPalSecret'];?>" data-dbid="1" data-dbt="config" data-dbc="payPalSecret" placeholder="Enter a PayPal Secret...">
            <div class="input-group-append"><button id="savepayPalSecret" class="btn btn-secondary save" data-dbid="payPalSecret" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ipn" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">IPN</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="ipn" class="form-control" value="Not Yet Implemented" readonly data-tooltip="tooltip" aria-label="Not Yet Implemented">
          </div>
        </div> */ ?>
        <legend id="stripe" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#stripe" data-tooltip="tooltip" aria-label="PermaLink to Stripe Section">&#128279;</a>':'';?>Stripe</legend>
        <div id="stripePublishKey" class="form-row">
          <label id="stripePublishKey" for="stripe_publishkey"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#stripePublishKey" data-tooltip="tooltip" aria-label="PermaLink to Stripe Publish Key">&#128279;</a>':'';?>Publish&nbsp;Key</label>
          <?php if($config['payPalClientID']==''||$config['payPalSecret']==''){?>
            <small class="form-text text-right">You will need to a <a target="_blank" href="https://stripe.com/">Stripe</a> Account to get a Publish Key.</small>
          <?php }?>
        </div>
        <div class="form-row">
          <input class="textinput" id="stripe_publishkey" data-dbid="1" data-dbt="config" data-dbc="stripe_publishkey" type="text" value="<?=$config['stripe_publishkey'];?>" placeholder="Enter a Stripe Publish Key...">
          <button class="save" id="savestripe_publishkey" data-dbid="stripe_publishkey" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <label id="stripeSecretKey" for="stripe_secretkey"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#stripeSecretKey" data-tooltip="tooltip" aria-label="PermaLink to Stripe Secret Key">&#128279;</a>':'';?>Secret&nbsp;Key</label>
        <div class="form-row">
          <input class="textinput" id="stripe_secretkey" data-dbid="1" data-dbt="config" data-dbc="stripe_secretkey" type="text" value="<?=$config['stripe_secretkey'];?>" placeholder="Enter a Stripe Secret Key...">
          <button class="save" id="savestripe_secretkey" data-dbid="stripe_secretkey" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#enableAfterpay" data-tooltip="tooltip" aria-label="PermaLink to Enable AfterPay Checkbox">&#128279;</a>':'';?>
          <input id="enableAfterpay" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="16" type="checkbox"<?=$config['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="enableAfterpay" id="configoptions161">Enable AfterPay</label>
        </div>
        <hr>
        <legend id="orderProcessing"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#orderProcessing" data-tooltip="tooltip" aria-label="PermaLink to Order Processing Section">&#128279;</a>':'';?>Order Processing</legend>
        <div class="form-row">
          <div class="input-text">Allow</div>
          <select id="orderPayti" data-dbid="1" data-dbt="config" data-dbc="orderPayti" onchange="update('1','config','orderPayti',$(this).val(),'select');">
            <option value="0"<?=$config['orderPayti']==0?' selected':'';?>>0 Days</option>
            <option value="604800"<?=$config['orderPayti']==604800?' selected':'';?>>7 Days</option>
            <option value="1209600"<?=$config['orderPayti']==1209600?' selected':'';?>>14 Days</option>
            <option value="1814400"<?=$config['orderPayti']==1814400?' selected':'';?>>21 Days</option>
            <option value="2592000"<?=$config['orderPayti']==2592000?' selected':'';?>>30 Days</option>
            <div class="dot-pulse"></div>
          </select>
          <div class="input-text">for Payments</div>
        </div>
        <div id="orderEmailNotes" class="form-row mt-3">
          <label for="oEN"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#orderEmailNotes" data-tooltip="tooltip" aria-label="PermaLink to Order Email Notes">&#128279;</a>':'';?>Order&nbsp;Notes</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{order_number}');return false;">{order_number}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="orderEmailNotes">
            <textarea class="summernote" id="oEN" name="da"><?= rawurldecode($config['orderEmailNotes']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="emailLayout"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#emailLayout" data-tooltip="tooltip" aria-label="PermaLink to Email Layout">&#128279;</a>':'';?>Email Layout</legend>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#readNotification" data-tooltip="tooltip" aria-label="PermaLink to Email Read Notification Checkbox">&#128279;</a>':'';?>
          <input id="readNotification" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0" type="checkbox"<?=$config['orderEmailReadNotification']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="readNotification" id="configorderEmailReadNotification01">Read Reciept</label>
        </div>
        <div id="orderEmailSubject" class="form-row mt-3">
          <label for="oES"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#orderEmailSubject" data-tooltip="tooltip" aria-label="PermaLink to Order Email Subject">&#128279;</a>':'';?>Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{order_number}');return false;">{order_number}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="oES" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject" type="text" value="<?=$config['orderEmailSubject'];?>">
          <button class="save" id="saveoES" data-dbid="oES" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <div id="orderEmailLayout" class="form-row mt-3">
          <label for="oEL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/orders/settings#orderEmailLayout" data-tooltip="tooltip" aria-label="PermaLink to Order Email Notes">&#128279;</a>':'';?>Layout</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{order_number}');return false;">{order_number}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{notes}');return false;">{notes}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="orderEmailLayout">
            <textarea class="summernote" id="oEL" name="da"><?= rawurldecode($config['orderEmailLayout']);?></textarea>
          </form>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
