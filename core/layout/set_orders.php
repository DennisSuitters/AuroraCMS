<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Orders
 * @package    core/layout/set_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * https://auspost.com.au/forms/pacpcs-registration.html
 * https://github.com/fontis/auspost-api-php
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='41'");
$sv->execute();
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='32'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
                <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                '<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save</i></button>';?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <?='<input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>'.
          '<label for="tab1-1">Shipping</label>'.
          '<input class="tab-control" id="tab1-2" name="tabs" type="radio">'.
          '<label for="tab1-2">Payment</label>'.
          '<input class="tab-control" id="tab1-3" name="tabs" type="radio">'.
          '<label for="tab1-3">Processing</label>';?>
<?php /* Tab 1 Postage */ ?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <legend>Holding Options</legend>
            <div class="row">
              <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md pl-2">Pickup Location</div>
                  <div class="col-12 col-md pl-2">Postcode From</div>
                  <div class="col-12 col-md pl-2">Postcode To</div>
                  <div class="col-12 col-md pl-2" data-tooltip="tooltip" aria-label="Percentage Requirement to Hold Order">% Payment Requirement</div>
                  <div class="col-12 col-md pl-2">Date Cutoff</div>
                </div>
              </article>
            </div>
            <?php if($user['options'][7]==1){?>
              <form class="row" target="sp" method="post" action="core/add_holdoption.php">
                <div class="col-12 col-md">
                  <input id="loc" name="loc" type="text" value="" placeholder="Enter Pickup Location...">
                </div>
                <div class="col-12 col-md">
                  <input id="pcfrom" name="pcfrom" type="text" value="" placeholder="Enter Postcode From...">
                </div>
                <div class="col-12 col-md">
                  <input id="pcto" name="pcto" type="text" value="" placeholder="Enter Postcode From...">
                </div>
                <div class="col-12 col-md">
                  <input id="req" name="req" type="text" value="" placholder="% Requirement...">
                </div>
                <div class="col-12 col-md">
                  <div class="form-row">
                    <input id="tie" name="tie" type="date" value="" onchange="$(`#tiex`).val(getTimestamp(`tie`));">
                    <input id="tiex" name="tiex" type="hidden" value="0">
                    <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </div>
              </form>
            <?php }?>
            <div id="holdoptions">
              <?php $sh=$db->prepare("SELECT `id`,`title`,`postcodeFrom`,`postcodeFrom`,`value`,`tie` FROM `".$prefix."choices` WHERE `contentType`='holdoption' ORDER BY `title` ASC");
              $sh->execute();
              while($rh=$sh->fetch(PDO::FETCH_ASSOC)){?>
                <article id="l_<?=$rh['id'];?>" class="card col-12 zebra m-0 p-0 overflow-visible card-list item shadow">
                  <div class="row">
                    <div class="col-12 col-md pl-2 pt-2"><?=$rh['title'];?></div>
                    <div class="col-12 col-md pl-2 pt-2"><?=$rh['postcodeFrom'];?>&nbsp;</div>
                    <div class="col-12 col-md pl-2 pt-2"><?=$rh['postcodeTo'];?>&nbsp;</div>
                    <div class="col-12 col-md pl-2 pt-2"><?=($rh['value']>0?$rh['value'].'% Required':'No Requirement');?></div>
                    <div class="col-12 col-md pl-2">
                      <span class="d-inline-block mt-2"><?=($rh['tie']>0?date($config['dateFormat'],$rh['tie']):'No Cutoff');?></span>
                      <form class="btn-group float-right" target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$rh['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="purge" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    </div>
                  </div>
                </article>
              <?php }?>
            </div>
            <hr>
            <legend>Shipping Options</legend>
            <div class="row">
              <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md pl-2">Code</div>
                  <div class="col-12 col-md pl-2">Title</div>
                  <div class="col-12 col-md pl-2">Cost</div>
                </div>
              </article>
            </div>
            <?php if($user['options'][7]==1){?>
              <form class="row" target="sp" method="post" action="core/add_postoption.php">
                <div class="col-12 col-md">
                  <input id="pco" name="c" type="text" value="" placeholder="Enter Code..." list="post_code_options" oninput="getPostCodeOption();">
                  <datalist id="post_code_options">
                    <option label="Australia Post Regular Post" data-title="Australia Post Regular Post" value="AUS_PARCEL_REGULAR">
                    <option label="Australia Post Express Post" data-title="Australia Post Express Post" value="AUS_PARCEL_EXPRESS">
                  </datalist>
                  <script>
                    function getPostCodeOption(){
                      var selectedTitle=document.getElementById("pco").value;
                      document.querySelector('#post_title').value=document.querySelector(`#post_code_options option[value='${selectedTitle}']`).dataset.title;
                    }
                  </script>
                </div>
                <div class="col-12 col-md">
                  <input id="post_title" name="t" type="text" value="" placeholder="Enter an Option...">
                </div>
                <div class="col-12 col-md">
                  <div class="form-row">
                    <input name="v" type="text" value="" placeholder="Enter Cost...">
                    <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </div>
              </form>
            <?php }?>
            <div id="postoption">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' AND `uid`=0 ORDER BY `title` ASC");
              $ss->execute();
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div class="row" id="l_<?=$rs['id'];?>">
                  <div class="col-12 col-md">
                    <div class="input-text"><?=$rs['type'];?></div>
                  </div>
                  <div class="col-12 col-md">
                    <div class="input-text"><?=$rs['title'];?></div>
                  </div>
                  <div class="col-12 col-md">
                    <div class="form-row">
                      <div class="input-text col-md"><?=$rs['value']!=0?$rs['value']:'';?></div>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$rs['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
            <hr>
            <legend>Tracking Options</legend>
            <div class="row">
              <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md pl-2">Service</div>
                  <div class="col-12 col-md pl-2">URL</div>
                </div>
              </article>
            </div>
            <?php if($user['options'][7]==1){?>
              <form class="row" target="sp" method="post" action="core/add_trackoption.php">
                <div class="col-12 col-md">
                  <input name="s" type="text" value="" placeholder="Enter a Service...">
                </div>
                <div class="col-12 col-md">
                  <div class="form-row">
                    <input name="u" type="text" value="" placeholder="Enter a URL...">
                    <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </div>
              </form>
            <?php }?>
            <div id="trackoption">
              <?php $ss=$db->prepare("SELECT `id`,`title`,`url` FROM `".$prefix."choices` WHERE `contentType`='trackoption' AND `uid`=0 ORDER BY `title` ASC");
              $ss->execute();
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div class="row" id="l_<?=$rs['id'];?>">
                  <div class="col-12 col-md">
                    <div class="input-text"><?=($rs['title']!=''?$rs['title']:'&nbsp;');?></div>
                  </div>
                  <div class="col-12 col-md">
                    <div class="form-row">
                      <div class="input-text col-md"><?=$rs['url'];?></div>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$rs['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
            <hr>
            <legend>Australia Post</legend>
            <label for="austPostAPIKey">APIKey</label>
            <div class="form-text">Visit <a target="_blank" href="https://auspost.com.au/forms/pacpcs-registration.html">AustPost API</a> to regsiter and get an API Key.</div>
            <div class="form-row">
              <input class="textinput" id="austPostAPIKey" data-dbid="1" data-dbt="config" data-dbc="austPostAPIKey" type="text" value="<?=$config['austPostAPIKey'];?>" placeholder="Enter your Australia Post API Code...">
              <button class="save" id="saveaustPostAPIKey" data-dbid="austPostAPIKey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
          </div>
<?php /* Tab 2 Payment */ ?>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <div class="form-row">
              <input id="displayPaymentOptions" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="7" type="checkbox"<?=$config['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="displayPaymentOptions" id="configoptions71">Display Payment Options Logo's (Logo's should be contained within the Template tags).</label>
            </div>
            <hr>
            <legend>Payment Options to Pay Orders</legend>
            <div class="form-text">A value of `0` disables the Surcharge being added to the Order.</div>
            <div class="row">
              <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md pl-2">Option</div>
                  <div class="col-12 col-md-2 pl-2">Method</div>
                  <div class="col-12 col-md-2 pl-2">Value</div>
                </div>
              </article>
            </div>
            <?php if($user['options'][7]==1){?>
              <form class="row" target="sp" method="post" action="core/add_payoption.php">
                <div class="col-12 col-md">
                  <input name="t" type="text" value="" placeholder="Enter Option...">
                </div>
                <div class="col-12 col-md-2">
                  <select name="m">
                    <option value="1">Add %</option>
                    <option value="2">Add $</option>
                  </select>
                </div>
                <div class="col-12 col-md-2">
                  <div class="form-row">
                    <input name="v" type="number" value="0">
                    <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </div>
              </form>
            <?php }?>
            <div id="payoptionl">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='payoption' AND `uid`=0");
              $ss->execute();
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?=$rs['id'];?>" class="row">
                  <div class="col-12 col-md">
                    <div class="input-text"><?=$rs['title'];?></div>
                  </div>
                  <div class="col-12 col-md-2">
                    <div class="input-text"><?=$rs['type']==2?'Add $':'Add %';?></div>
                  </div>
                  <div class="col-12 col-md-2">
                    <div class="form-row">
                      <div class="input-text col-md"><?=$rs['value'];?></div>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$rs['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="trash" type="submit" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
            <label for="gst">Add GST as Percentage</label>
            <div class="form-row">
              <input class="textinput" id="gst" data-dbid="1" data-dbt="config" data-dbc="gst" type="number" value="<?=$config['gst'];?>" placeholder="Enter a GST Value...">
              <button class="save" id="savegst" data-dbid="gst" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <hr>
            <legend>Banking</legend>
            <div class="row">
              <div class="col-12 col-md pr-md-3">
                <label for="bank">Bank</label>
                <div class="form-row">
                  <input class="textinput" id="bank" data-dbid="1" data-dbt="config" data-dbc="bank" type="text" value="<?=$config['bank'];?>" placeholder="Enter Bank...">
                  <button class="save" id="savebank" data-dbid="bank" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                </div>
              </div>
              <div class="col-12 col-md">
                <label for="bankAccountName">Account Name</label>
                <div class="form-row">
                  <input class="textinput" id="bankAccountName" data-dbid="1" data-dbt="config" data-dbc="bankAccountName" type="text" value="<?=$config['bankAccountName'];?>" placeholder="Enter an Account Name...">
                  <button class="save" id="savebankAccountName" data-dbid="bankAccountName" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md pr-md-3">
                <label for="bankAccountNumber">Account Number</label>
                <div class="form-row">
                  <input class="textinput" id="bankAccountNumber" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" type="text" value="<?=$config['bankAccountNumber'];?>" placeholder="Enter an Account Number...">
                  <button class="save" id="savebankAccountNumber" data-dbid="bankAccountNumber" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                </div>
              </div>
              <div class="col-12 col-md">
                <label for="bankBSB">BSB</label>
                <div class="form-row">
                  <input class="textinput" id="bankBSB" data-dbid="1" data-dbt="config" data-dbc="bankBSB" type="text" value="<?=$config['bankBSB'];?>" placeholder="Enter a BSB...">
                  <button class="save" id="savebankBSB" data-dbid="bankBSB" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                </div>
              </div>
            </div>
            <hr>
            <legend>PayPal</legend>
            <label for="payPalClientID">Client&nbsp;ID</label>
            <?=($config['payPalClientID']==''||$config['payPalSecret']==''?'<div class="form-text">You will need to a <a target="_blank" href="https://www.paypal.com/au/business">PayPal Business</a> Account to get a Client ID.</div>':'');?>
            <div class="form-row">
              <input class="textinput" id="payPalClientID" data-dbid="1" data-dbt="config" data-dbc="payPalClientID" type="text" value="<?=$config['payPalClientID'];?>" placeholder="Enter a PayPal Client ID...">
              <button class="save" id="savepayPalClientID" data-dbid="payPalClientID" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
    <?php /*
            <div class="form-group row">
              <label for="payPalSecret" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">PayPal Secret</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="payPalSecret" class="form-control textinput" value="<?=$config['payPalSecret'];?>" data-dbid="1" data-dbt="config" data-dbc="payPalSecret" placeholder="Enter a PayPal Secret...">
                <div class="input-group-append"><button id="savepayPalSecret" class="btn btn-secondary save" data-dbid="payPalSecret" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="ipn" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">IPN</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="ipn" class="form-control" value="Not Yet Implemented" readonly data-tooltip="tooltip" aria-label="Not Yet Implemented">
              </div>
            </div> */ ?>
            <hr>
            <legend>Stripe</legend>
            <label for="stripe_publishkey">Publish Key</label>
            <?=($config['payPalClientID']==''||$config['payPalSecret']==''?'<div class="form-text">You will need to a <a target="_blank" href="https://stripe.com/">Stripe</a> Account to get a Publish Key.</div>':'');?>
            <div class="form-row">
              <input class="textinput" id="stripe_publishkey" data-dbid="1" data-dbt="config" data-dbc="stripe_publishkey" type="text" value="<?=$config['stripe_publishkey'];?>" placeholder="Enter a Stripe Publish Key...">
              <button class="save" id="savestripe_publishkey" data-dbid="stripe_publishkey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <label for="stripe_secretkey">Secret Key</label>
            <div class="form-row">
              <input class="textinput" id="stripe_secretkey" data-dbid="1" data-dbt="config" data-dbc="stripe_secretkey" type="text" value="<?=$config['stripe_secretkey'];?>" placeholder="Enter a Stripe Secret Key...">
              <button class="save" id="savestripe_secretkey" data-dbid="stripe_secretkey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <div class="form-row mt-3">
              <input id="enableAfterpay" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="16" type="checkbox"<?=$config['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="enableAfterpay">Enable AfterPay</label>
            </div>
          </div>
<?php /* Order Processing */ ?>
          <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
            <div class="form-row">
              <div class="input-text">Allow</div>
              <select id="orderPayti" data-dbid="1" data-dbt="config" data-dbc="orderPayti" onchange="update('1','config','orderPayti',$(this).val(),'select');">
                <option value="0"<?=$config['orderPayti']==0?' selected':'';?>>0 Days</option>
                <option value="604800"<?=$config['orderPayti']==604800?' selected':'';?>>7 Days</option>
                <option value="1209600"<?=$config['orderPayti']==1209600?' selected':'';?>>14 Days</option>
                <option value="1814400"<?=$config['orderPayti']==1814400?' selected':'';?>>21 Days</option>
                <option value="2592000"<?=$config['orderPayti']==2592000?' selected':'';?>>30 Days</option>
              </select>
              <div class="input-text">for Payments</div>
            </div>
            <label for="oEN" onclick="$('#oEN').summernote({focus:true});">Order Notes</label>
            <?php if($user['options'][7]==1){?>
              <div class="form-text">Tokens:
                <a class="badger badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{name}');return false;">{name}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{first}');return false;">{first}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{last}');return false;">{last}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{date}');return false;">{date}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEN').summernote('insertText','{order_number}');return false;">{order_number}</a>
              </div>
              <div class="row">
                <form method="post" target="sp" action="core/update.php">
                  <input name="id" type="hidden" value="1">
                  <input name="t" type="hidden" value="config">
                  <input name="c" type="hidden" value="orderEmailNotes">
                  <textarea class="summernote" id="oEN" name="da"><?= rawurldecode($config['orderEmailNotes']);?></textarea>
                </form>
              </div>
            <?php }else{?>

            <?php }?>
            <hr>
            <legend>Email Layout</legend>
            <div class="form-row mt-2">
              <input id="readNotification" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0" type="checkbox"<?=$config['orderEmailReadNotification']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="readNotification">Read Reciept</label>
            </div>
            <label for="oES">Subject</label>
            <?php if($user['options'][7]==1){?>
              <div class="form-text">Tokens:
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('oES','{name}');return false;">{name}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('oES','{first}');return false;">{first}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('oES','{last}');return false;">{last}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('oES','{date}');return false;">{date}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('oES','{order_number}');return false;">{order_number}</a>
              </div>
            <?php }?>
            <div class="form-row">
              <input class="textinput" id="oES" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject" type="text" value="<?=$config['orderEmailSubject'];?>">
              <button class="save" id="saveoES" data-dbid="oES" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <label for="oEL" onclick="$('#oEL').summernote({focus:true});">Body</label>
            <?php if($user['options'][7]==1){?>
              <div class="form-text">Tokens:
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{name}');return false;">{name}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{first}');return false;">{first}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{last}');return false;">{last}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{business}');return false;">{business}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{date}');return false;">{date}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{order_number}');return false;">{order_number}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{downloads}');return false;">{downloads}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{courses}');return false;">{courses}</a>
                <a class="badger badge-secondary" href="#" onclick="$('#oEL').summernote('insertText','{notes}');return false;">{notes}</a>
              </div>
            <?php }?>
            <div class="row">
              <form method="post" target="sp" action="core/update.php">
                <input name="id" type="hidden" value="1">
                <input name="t" type="hidden" value="config">
                <input name="c" type="hidden" value="orderEmailLayout">
                <textarea class="summernote" id="oEL" name="da"><?= rawurldecode($config['orderEmailLayout']);?></textarea>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
