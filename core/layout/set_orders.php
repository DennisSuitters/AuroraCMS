<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Orders
 * @package    core/layout/set_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * https://auspost.com.au/forms/pacpcs-registration.html
 * https://github.com/fontis/auspost-api-php
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('users','i-3x');?></div>
          <div>Orders Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <legend id="postageOptions" class="mt-3"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#postageOptions" aria-label="PermaLink to Postage Options Section">&#128279;</a>':'';?>Postage Options</legend>
        <form target="sp" method="post" action="core/add_postoption.php">
          <div class="form-row">
            <div class="input-text">Code</div>
            <input name="c" type="text" value="" placeholder="Enter Code...">
            <div class="input-text">Title</div>
            <input name="t" type="text" value="" placeholder="Enter an Option...">
            <div class="input-text">Cost</div>
            <input name="v" type="text" value="" placeholder="Enter Cost...">
            <button class="add" data-tooltip="tooltip" aria-label="Add"><?php svg('add');?></button>
          </div>
        </form>
        <div id="postoption">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' AND `uid`=0 ORDER BY `title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div class="form-row mt-1" id="l_<?php echo$rs['id'];?>">
              <div class="input-text">Code</div>
              <input id="c<?php echo$rs['id'];?>" name="code" type="text" value="<?php echo$rs['type'];?>" readonly>
              <div class="input-text">title</div>
              <input id="t<?php echo$rs['id'];?>" name="service" type="text" value="<?php echo$rs['title'];?>" readonly>
              <div class="input-text">Cost</div>
              <input id="v<?php echo$rs['id'];?>" name="cost" type="text" value="<?php echo$rs['value']!=0?$rs['value']:'';?>" readonly>
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend id="australiaPost"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#australiaPost" aria-label="PermaLink to Australia Post Section">&#128279;</a>':'';?>Australia Post</legend>
        <div id="australiaPostAPIKey" class="form-row">
          <label for="austPostAPIKey"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#australiaPostAPIKey" aria-label="PermaLink to Australia Post API Key">&#128279;</a>':'';?>API&nbsp;Key</label>
          <small class="form-text text-right">Visit <a target="_blank" href="https://auspost.com.au/forms/pacpcs-registration.html">AustPost API</a> to regsiter and get an API Key.</small>
        </div>
        <div class="form-row">
          <input class="textinput" id="austPostAPIKey" data-dbid="1" data-dbt="config" data-dbc="austPostAPIKey" type="text" value="<?php echo$config['austPostAPIKey'];?>" placeholder="Enter your Australia Post API Code...">
          <button class="save" id="saveaustPostAPIKey" data-tooltip="tooltip" data-dbid="austPostAPIKey" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <legend id="paymentOptions" class="mt-3"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#paymentOptions" aria-label="PermaLink to Payment Options Section">&#128279;</a>':'';?>Payment Options</legend>
        <div class="row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#displayPaymentOptions" aria-label="PermaLink to Display Payment Options Checkbox">&#128279;</a>':'';?>
          <input id="displayPaymentOptions" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="7" type="checkbox"<?php echo$config['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="displayPaymentOptions">Display Payment Options Logo's (Logo's should be contained within the Template tags).</label>
        </div>
        <label id="orderGST" for="gst"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#orderGST" aria-label="PermaLink to GST">&#128279;</a>':'';?>GST</label>
        <div class="form-row">
          <input class="textinput" id="gst" data-dbid="1" data-dbt="config" data-dbc="gst" type="number" value="<?php echo$config['gst'];?>" placeholder="Enter a GST Value...">
          <button class="save" id="savegst" data-tooltip="tooltip" data-dbid="gst" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <hr>
        <legend id="discountRanges"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#discountRanges" aria-label="PermaLink to Discount Ranges Options Section">&#128279;</a>':'';?>Discount Ranges</legend>
        <div class="row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#discountRangeCalculations" aria-label="PermaLink to Discount Ranges Calculations Checkbox">&#128279;</a>':'';?>
          <input id="discountRangeCalculations" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="26" type="checkbox"<?php echo$config['options'][26]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="discountRangeCalculations">Discount Range Calculations.</label>
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
            <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?php svg('add');?></button>
          </div>
        </form>
        <div class="mt-1" id="discountrange">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `uid`=0 ORDER BY `t` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="form-row">
              <div class="input-text">From &#36;</div>
              <input type="number" value="<?php echo$rs['f'];?>" readonly>
              <div class="input-text">To &#36;</div>
              <input type="number" value="<?php echo$rs['t'];?>" readonly>
              <div class="input-text">Method</div>
              <input type="text" value="<?php echo$rs['value']==2?'&#37; Off':'&#36; Off';?>" readonly>
              <div class="input-text">Value</div>
              <input type="number" value="<?php echo$rs['cost'];?>" readonly>
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend id="banking"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#banking" aria-label="PermaLink to Banking Section">&#128279;</a>':'';?>Banking</legend>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-3">
            <label id="bankName" for="bank"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#bankName" aria-label="PermaLink to Bank">&#128279;</a>':'';?>Bank</label>
            <div class="form-row">
              <input class="textinput" id="bank" data-dbid="1" data-dbt="config" data-dbc="bank" type="text" value="<?php echo$config['bank'];?>" placeholder="Enter Bank...">
              <button class="save" id="savebank" data-tooltip="tooltip" data-dbid="bank" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-3">
            <label id="accountName" for="bankAccountName"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#accountName" aria-label="PermaLink to Account Name">&#128279;</a>':'';?>Account Name</label>
            <div class="form-row">
              <input class="textinput" id="bankAccountName" data-dbid="1" data-dbt="config" data-dbc="bankAccountName" type="text" value="<?php echo$config['bankAccountName'];?>" placeholder="Enter an Account Name...">
              <button class="save" id="savebankAccountName" data-tooltip="tooltip" data-dbid="bankAccountName" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-3">
            <label id="accountNumber" for="bankAccountNumber"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#accountNumber" aria-label="PermaLink to Account Number">&#128279;</a>':'';?>Account Number</label>
            <div class="form-row">
              <input class="textinput" id="bankAccountNumber" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" type="text" value="<?php echo$config['bankAccountNumber'];?>" placeholder="Enter an Account Number...">
              <button class="save" id="savebankAccountNumber" data-tooltip="tooltip" data-dbid="bankAccountNumber" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-3">
            <label id="accountBSB" for="bankBSB"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#accountBSB" aria-label="PermaLink to Account BSB">&#128279;</a>':'';?>BSB</label>
            <div class="form-row">
              <input class="textinput" id="bankBSB" data-dbid="1" data-dbt="config" data-dbc="bankBSB" type="text" value="<?php echo$config['bankBSB'];?>" placeholder="Enter a BSB...">
              <button class="save" id="savebankBSB" data-tooltip="tooltip" data-dbid="bankBSB" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <hr>
        <legend id="paypal"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#paypal" aria-label="PermaLink to Pay Pal Section">&#128279;</a>':'';?>PayPal</legend>
        <div id="paypalID" class="form-row">
          <label for="payPalClientID"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#paypalID" aria-label="PermaLink to Pay Pal Client ID">&#128279;</a>':'';?>Client&nbsp;ID</label>
          <?php if($config['payPalClientID']==''||$config['payPalSecret']==''){?>
            <small class="form-text text-right">You will need to a PayPal Business Account to get a Client ID.</small>
          <?php }?>
        </div>
        <div class="form-row">
          <input class="textinput" id="payPalClientID" data-dbid="1" data-dbt="config" data-dbc="payPalClientID" type="text" value="<?php echo$config['payPalClientID'];?>" placeholder="Enter a PayPal Client ID...">
          <button class="save" id="savepayPalClientID" data-tooltip="tooltip" data-dbid="payPalClientID" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
<?php /*
        <div class="form-group row">
          <label for="payPalSecret" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">PayPal Secret</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="payPalSecret" class="form-control textinput" value="<?php echo$config['payPalSecret'];?>" data-dbid="1" data-dbt="config" data-dbc="payPalSecret" placeholder="Enter a PayPal Secret...">
            <div class="input-group-append" data-tooltip="tooltip"><button id="savepayPalSecret" class="btn btn-secondary save" data-dbid="payPalSecret" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ipn" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">IPN</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="ipn" class="form-control" value="Not Yet Implemented" readonly data-tooltip="tooltip" aria-label="Not Yet Implemented">
          </div>
        </div> */ ?>
        <hr>
        <legend id="orderProcessing"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#orderProcessing" aria-label="PermaLink to Order Processing Section">&#128279;</a>':'';?>Order Processing</legend>
        <div class="form-row">
          <div class="input-text">Allow</div>
          <select id="orderPayti" data-dbid="1" data-dbt="config" data-dbc="orderPayti" onchange="update('1','config','orderPayti',$(this).val());">
            <option value="0"<?php echo$config['orderPayti']==0?' selected':'';?>>0 Days</option>
            <option value="604800"<?php echo$config['orderPayti']==604800?' selected':'';?>>7 Days</option>
            <option value="1209600"<?php echo$config['orderPayti']==1209600?' selected':'';?>>14 Days</option>
            <option value="1814400"<?php echo$config['orderPayti']==1814400?' selected':'';?>>21 Days</option>
            <option value="2592000"<?php echo$config['orderPayti']==2592000?' selected':'';?>>30 Days</option>
          </select>
          <div class="input-text">for Payments</div>
        </div>
        <div id="orderEmailNotes" class="form-row mt-3">
          <label for="oEN"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#orderEmailNotes" aria-label="PermaLink to Order Email Notes">&#128279;</a>':'';?>Order&nbsp;Notes</label>
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
            <textarea class="summernote" id="oEN" name="da"><?php echo rawurldecode($config['orderEmailNotes']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="emailLayout"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#emailLayout" aria-label="PermaLink to Email Layout">&#128279;</a>':'';?>Email Layout</legend>
        <div class="row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#readNotification" aria-label="PermaLink to Email Read Notification Checkbox">&#128279;</a>':'';?>
          <input id="readNotification" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0" type="checkbox"<?php echo$config['orderEmailReadNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="readNotification">Read Reciept</label>
        </div>
        <div id="orderEmailSubject" class="form-row mt-3">
          <label for="oES"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#orderEmailSubject" aria-label="PermaLink to Order Email Subject">&#128279;</a>':'';?>Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('oES','{order_number}');return false;">{order_number}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="oES" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject" type="text" value="<?php echo$config['orderEmailSubject'];?>">
          <button class="save" id="saveoES" data-tooltip="tooltip" data-dbid="oES" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div id="orderEmailLayout" class="form-row mt-3">
          <label for="oEL"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings#orderEmailLayout" aria-label="PermaLink to Order Email Notes">&#128279;</a>':'';?>Layout</label>
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
            <textarea class="summernote" id="oEL" name="da"><?php echo rawurldecode($config['orderEmailLayout']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
