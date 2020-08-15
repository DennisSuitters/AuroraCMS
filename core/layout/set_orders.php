<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Orders
 * @package    core/layout/set_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.8 Add PayPal Client ID and Secret.
 * @changes    v0.0.9 Add Option Toggle to Display Payment Options.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.15 Add GST value editing.
 * @changes    v0.0.15 Add AustPost API Cost retreival.
 * @changes    v0.0.17 Fix WYSIWYG Editor Layout.
 * @changes    v0.0.18 Adjust AustPost API and adding Post Options.
 * @changes    v0.0.18 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 * @changes    v0.0.19 Add Save All button.
 * @changes    v0.0.19 Add Discount Range editor.
 * https://auspost.com.au/forms/pacpcs-registration.html
 * https://github.com/fontis/auspost-api-php
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
        <a href="#" class="btn btn-ghost-normal saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields"><?php echo svg('save');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <legend>Postage Options</legend>
        <form target="sp" method="post" action="core/add_postoption.php">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Code</div>
              </div>
              <input type="text" id="c" class="form-control" name="c" value="" placeholder="Enter Code...">
              <div class="input-group-append">
                <div class="input-group-text">Title</div>
              </div>
              <input type="text" id="t" class="form-control" name="t" value="" placeholder="Enter an Option...">
              <div class="input-group-append">
                <div class="input-group-text">Cost</div>
              </div>
              <input type="text" id="v" class="form-control" name="v" value="" placeholder="Enter Cost...">
              <div class="input-group-append">
                <button class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="postoption">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='postoption' AND uid=0 ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Code</div>
              </div>
              <input type="text" id="c<?php echo$rs['id'];?>" class="form-control" name="code" value="<?php echo$rs['type'];?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">title</div>
              </div>
              <input type="text" id="t<?php echo$rs['id'];?>" class="form-control" name="service" value="<?php echo$rs['title'];?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">Cost</div>
              </div>
              <input type="text" id="v<?php echo$rs['id'];?>" class="form-control" name="cost" value="<?php echo$rs['value']!=0?$rs['value']:'';?>" readonly>
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
        <legend>Australia Post</legend>
        <div class="form-group">
          <label for="austPostAPIKey">API Key</label>
          <div class="form-text small text-muted float-right">Visit <a target="_blank" href="https://auspost.com.au/forms/pacpcs-registration.html">AustPost API</a> to regsiter and get an API Key.</div>
          <div class="input-group">
            <input type="text" id="austPostAPIKey" class="form-control textinput" value="<?php echo$config['austPostAPIKey'];?>"data-dbid="1" data-dbt="config" data-dbc="austPostAPIKey" placeholder="Enter your Australia Post API Code...">
            <div class="input-group-append">
              <button id="saveaustPostAPIKey" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="austPostAPIKey" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <legend>Payment Options</legend>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options7" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="7"<?php echo$config['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options7" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Display Payment Options Logo's (Logo's should be contained within the Template tags).</label>
        </div>
        <div class="form-group">
          <label for="gst">GST</label>
          <div class="input-group">
            <input type="number" id="gst" class="form-control textinput" value="<?php echo$config['gst'];?>"data-dbid="1" data-dbt="config" data-dbc="gst" placeholder="Enter a GST Value...">
            <div class="input-group-append">
              <button id="savegst" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="gst" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <hr>
        <legend>Account Discount Ranges</legend>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options26" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="26"<?php echo$config['options'][26]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options26" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Discount Range Calculations.</label>
        </div>
        <form target="sp" method="post" action="core/add_discountrange.php">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">From $</div>
              </div>
              <input type="number" id="f" class="form-control" name="f" value="" placeholder="Enter Code...">
              <div class="input-group-append">
                <div class="input-group-text">To $</div>
              </div>
              <input type="number" id="t" class="form-control" name="t" value="" placeholder="Enter an Option...">
              <div class="input-group-append">
                <div class="input-group-text">Method</div>
              </div>
              <select id="m" class="form-control" name="m">
                <option value="1">$ Off</option>
                <option value="2">&#37; Off</option>
              </select>
              <div class="input-group-append">
                <div class="input-group-text">Value</div>
              </div>
              <input type="number" id="v" class="form-control" name="v" value="" placeholder="Enter Cost...">
              <div class="input-group-append">
                <button class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="discountrange">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='discountrange' AND uid=0 ORDER BY t ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">From &#36;</div>
              </div>
              <input type="number" class="form-control" value="<?php echo$rs['f'];?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">To &#36;</div>
              </div>
              <input type="number" class="form-control" value="<?php echo$rs['t'];?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">Method</div>
              </div>
              <input type="text" class="form-control" value="<?php echo$rs['value']==2?'&#37; Off':'&#36; Off';?>" readonly>
              <input type="number" class="form-control" value="<?php echo$rs['cost'];?>" readonly>
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>

        <hr>
        <legend>Banking</legend>
        <div class="row">
          <div class="form-group col-12 col-sm-6">
            <label for="bank">Bank</label>
            <div class="input-group">
              <input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="Enter Bank...">
              <div class="input-group-append">
                <button id="savebank" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="bank" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-sm-6">
            <label for="bankAccountName">Account Name</label>
            <div class="input-group">
              <input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="Enter an Account Name...">
              <div class="input-group-append">
                <button id="savebankAccountName" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="bankAccountName" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-12 col-sm-6">
            <label for="bankAccountNumber">Account Number</label>
            <div class="input-group">
              <input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="Enter an Account Number...">
              <div class="input-group-append">
                <button id="savebankAccountNumber" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="bankAccountNumber" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-sm-6">
            <label for="bankBSB">BSB</label>
            <div class="input-group">
              <input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="Enter a BSB...">
              <div class="input-group-append">
                <button id="savebankBSB" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="bankBSB" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <legend>PayPal</legend>
        <div class="form-group">
          <label for="payPalClientID">Client ID</label>
<?php if($config['payPalClientID']==''||$config['payPalSecret']==''){?>
          <div class="form-text small text-muted float-right">You will need to a PayPal Business Account to get a Client ID.</div>
<?php }?>
          <div class="input-group">
            <input type="text" id="payPalClientID" class="form-control textinput" value="<?php echo$config['payPalClientID'];?>" data-dbid="1" data-dbt="config" data-dbc="payPalClientID" placeholder="Enter a PayPal Client ID...">
            <div class="input-group-append">
              <button id="savepayPalClientID" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="payPalClientID" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
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
        <div class="form-group">
          <label for="orderPayti">Allow</label>
          <div class="input-group">
            <select id="orderPayti" class="form-control" onchange="update('1','config','orderPayti',$(this).val());" data-dbid="1" data-dbt="config" data-dbc="orderPayti">
              <option value="0"<?php echo$config['orderPayti']==0?' selected':'';?>>0 Days</option>
              <option value="604800"<?php echo$config['orderPayti']==604800?' selected':'';?>>7 Days</option>
              <option value="1209600"<?php echo$config['orderPayti']==1209600?' selected':'';?>>14 Days</option>
              <option value="1814400"<?php echo$config['orderPayti']==1814400?' selected':'';?>>21 Days</option>
              <option value="2592000"<?php echo$config['orderPayti']==2592000?' selected':'';?>>30 Days</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">for Payments</div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="orderEmailNotes">Order Notes</label>
          <div class="input-group card-header p-0">
            <div class="col-12 form-text small text-muted text-right">Tokens:
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{name}');return false;">{name}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{first}');return false;">{first}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{last}');return false;">{last}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{date}');return false;">{date}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{order_number}');return false;">{order_number}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" class="w-100">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="orderEmailNotes">
              <textarea id="orderEmailNotes" class="form-control summernote" name="da"><?php echo rawurldecode($config['orderEmailNotes']);?></textarea>
            </form>
          </div>
        </div>
        <hr>
        <legend>Email Layout</legend>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="orderEmailReadNotification" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0" role="checkbox"<?php echo$config['orderEmailReadNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="orderEmailReadNotification" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Read Reciept</label>
        </div>
        <div class="form-group">
          <label for="orderEmailSubject">Subject</label>
          <div class="form-text small text-muted float-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{order_number}');return false;">{order_number}</a>
          </div>
          <div class="input-group">
            <input type="text" id="orderEmailSubject" class="form-control textinput" value="<?php echo$config['orderEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject">
            <div class="input-group-append">
              <button id="saveorderEmailSubject" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="orderEmailSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="orderEmailLayout">Layout</label>
          <div class="input-group card-header p-0">
            <div class="col-12 form-text small text-muted text-right">Tokens:
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{name}');return false;">{name}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{first}');return false;">{first}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{last}');return false;">{last}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{date}');return false;">{date}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{order_number}');return false;">{order_number}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{notes}');return false;">{notes}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" class="w-100">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="orderEmailLayout">
              <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['orderEmailLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
