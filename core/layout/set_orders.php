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
            <a class="btn" data-tooltip="tooltip" data-title="Back" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <button data-tooltip="tooltip" data-title="Toggle Fullscreen" aria-label"Toggle Fullscreen" onclick="toggleFullscreen();"><?php svg('fullscreen');?></button>
            <button class="saveall" data-tooltip="tooltip" data-title="Save All Edited Fields" aria-label="Save All Edited Fields"><?php svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <legend class="mt-3">Postage Options</legend>
        <form target="sp" method="post" action="core/add_postoption.php">
          <div class="form-row">
            <div class="input-text">Code</div>
            <input id="c" name="c" type="text" value="" placeholder="Enter Code...">
            <div class="input-text">Title</div>
            <input id="t" name="t" type="text" value="" placeholder="Enter an Option...">
            <div class="input-text">Cost</div>
            <input id="v" name="v" type="text" value="" placeholder="Enter Cost...">
            <button class="add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
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
                <button class="trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend>Australia Post</legend>
        <div class="form-row">
          <label for="austPostAPIKey">API&nbsp;Key</label>
          <small class="form-text text-right">Visit <a target="_blank" href="https://auspost.com.au/forms/pacpcs-registration.html">AustPost API</a> to regsiter and get an API Key.</small>
        </div>
        <div class="form-row">
          <input class="textinput" id="austPostAPIKey" data-dbid="1" data-dbt="config" data-dbc="austPostAPIKey" type="text" value="<?php echo$config['austPostAPIKey'];?>" placeholder="Enter your Australia Post API Code...">
          <button class="save" id="saveaustPostAPIKey" data-tooltip="tooltip" data-title="Save" data-dbid="austPostAPIKey" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <legend class="mt-3">Payment Options</legend>
        <div class="row">
          <input id="options7" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="7" type="checkbox"<?php echo$config['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options7">Display Payment Options Logo's (Logo's should be contained within the Template tags).</label>
        </div>
        <label for="gst">GST</label>
        <div class="form-row">
          <input class="textinput" id="gst" data-dbid="1" data-dbt="config" data-dbc="gst" type="number" value="<?php echo$config['gst'];?>" placeholder="Enter a GST Value...">
          <button class="save" id="savegst" data-tooltip="tooltip" data-title="Save" data-dbid="gst" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <hr>
        <legend>Account Discount Ranges</legend>
        <div class="row">
          <input id="options26" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="26" type="checkbox"<?php echo$config['options'][26]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options26">Discount Range Calculations.</label>
        </div>
        <form target="sp" method="post" action="core/add_discountrange.php">
          <div class="form-row">
            <div class="input-text">From $</div>
            <input id="f" name="f" type="number" value="" placeholder="Enter Code...">
            <div class="input-text">To $</div>
            <input id="t" name="t" type="number" value="" placeholder="Enter an Option...">
            <div class="input-text">Method</div>
            <select id="m" name="m">
              <option value="1">$ Off</option>
              <option value="2">&#37; Off</option>
            </select>
            <div class="input-text">Value</div>
            <input id="v" name="v" type="number" value="" placeholder="Enter Cost...">
            <button class="add" data-tooltip="tooltip" data-title="Add" type="submit" aria-label="Add"><?php svg('add');?></button>
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
                <button class="trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend>Banking</legend>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-1">
            <label for="bank">Bank</label>
            <div class="form-row">
              <input class="textinput" id="bank" data-dbid="1" data-dbt="config" data-dbc="bank" type="text" value="<?php echo$config['bank'];?>" placeholder="Enter Bank...">
              <button class="save" id="savebank" data-tooltip="tooltip" data-title="Save" data-dbid="bank" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label for="bankAccountName">Account Name</label>
            <div class="form-row">
              <input class="textinput" id="bankAccountName" data-dbid="1" data-dbt="config" data-dbc="bankAccountName" type="text" value="<?php echo$config['bankAccountName'];?>" placeholder="Enter an Account Name...">
              <button class="save" id="savebankAccountName" data-tooltip="tooltip" data-title="Save" data-dbid="bankAccountName" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-1">
            <label for="bankAccountNumber">Account Number</label>
            <div class="form-row">
              <input class="textinput" id="bankAccountNumber" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" type="text" value="<?php echo$config['bankAccountNumber'];?>" placeholder="Enter an Account Number...">
              <button class="save" id="savebankAccountNumber" data-tooltip="tooltip" data-title="Save" data-dbid="bankAccountNumber" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label for="bankBSB">BSB</label>
            <div class="form-row">
              <input class="textinput" id="bankBSB" data-dbid="1" data-dbt="config" data-dbc="bankBSB" type="text" value="<?php echo$config['bankBSB'];?>" placeholder="Enter a BSB...">
              <button class="save" id="savebankBSB" data-tooltip="tooltip" data-title="Save" data-dbid="bankBSB" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <hr>
        <legend>PayPal</legend>
        <div class="form-row">
          <label for="payPalClientID">Client&nbsp;ID</label>
          <?php if($config['payPalClientID']==''||$config['payPalSecret']==''){?>
            <small class="form-text text-right">You will need to a PayPal Business Account to get a Client ID.</small>
          <?php }?>
        </div>
        <div class="form-row">
          <input class="textinput" id="payPalClientID" data-dbid="1" data-dbt="config" data-dbc="payPalClientID" type="text" value="<?php echo$config['payPalClientID'];?>" placeholder="Enter a PayPal Client ID...">
          <button class="save" id="savepayPalClientID" data-tooltip="tooltip" data-title="Save" data-dbid="payPalClientID" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
<?php /*
        <div class="form-group row">
          <label for="payPalSecret" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">PayPal Secret</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="payPalSecret" class="form-control textinput" value="<?php echo$config['payPalSecret'];?>" data-dbid="1" data-dbt="config" data-dbc="payPalSecret" placeholder="Enter a PayPal Secret...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savepayPalSecret" class="btn btn-secondary save" data-dbid="payPalSecret" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ipn" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">IPN</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="ipn" class="form-control" value="Not Yet Implemented" readonly data-tooltip="tooltip" data-title="Not Yet Implemented">
          </div>
        </div> */ ?>
        <hr>
        <legend>Order Processing</legend>
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
        <div class="form-row mt-3">
          <label for="orderEmailNotes">Order&nbsp;Notes</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{order_number}');return false;">{order_number}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="orderEmailNotes">
            <textarea class="summernote" id="orderEmailNotes" name="da"><?php echo rawurldecode($config['orderEmailNotes']);?></textarea>
          </form>
        </div>
        <hr>
        <legend>Email Layout</legend>
        <div class="row">
          <input id="orderEmailReadNotification" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0" type="checkbox"<?php echo$config['orderEmailReadNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="orderEmailReadNotification">Read Reciept</label>
        </div>
        <div class="form-row mt-3">
          <label for="orderEmailSubject">Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{order_number}');return false;">{order_number}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="orderEmailSubject" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject" type="text" value="<?php echo$config['orderEmailSubject'];?>">
          <button class="save" id="saveorderEmailSubject" data-tooltip="tooltip" data-title="Save" data-dbid="orderEmailSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="form-row mt-3">
          <label for="orderEmailLayout">Layout</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{order_number}');return false;">{order_number}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{notes}');return false;">{notes}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="orderEmailLayout">
            <textarea class="summernote" id="orderEmailLayout" name="da"><?php echo rawurldecode($config['orderEmailLayout']);?></textarea>
          </form>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
