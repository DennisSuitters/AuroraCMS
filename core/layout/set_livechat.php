<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Live Chat
 * @package    core/layout/set_livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/livechat';?>">Live Chat</a></li>
    <li class="breadcrumb-item active"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <div class="input-group col-sm-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options13" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="13"<?php echo$config['options']{13}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options13" class="col-form-label col-sm-3">Enable Chat</label>
          <div class="input-group col-sm-7">
            <div class="input-group-text">
              Remove Messages
            </div>
            <select id="chatAutoRemove" class="form-control" onchange="update('1','config','chatAutoRemove',$(this).val());" data-dbid="1" data-dbt="config" data-dbc="chatAutoRemove">
              <option value="0"<?php echo$config['chatAutoRemove']==0?' selected="Selected"':'';?>>Never</option>
              <option value="86400"<?php echo$config['chatAutoRemove']==86400?' selected="Selected"':'';?>>Older than 24 Hours</option>
              <option value="172800"<?php echo$config['chatAutoRemove']==172800?' selected="Selected"':'';?>>Older than 2 Days</option>
              <option value="604800"<?php echo$config['chatAutoRemove']==604800?' selected="Selected"':'';?>>Older than 7 Days</option>
              <option value="1209600"<?php echo$config['chatAutoRemove']==1209600?' selected="Selected"':'';?>>Older than 14 Days</option>
              <option value="2592000"<?php echo$config['chatAutoRemove']==2592000?' selected="Selected"':'';?>>Older than 30 Days</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="input-group col-sm-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options14" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="14"<?php echo$config['options']{14}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options14" class="col-form-label col-sm-10">Use Embedded Messenger</label>
        </div>
        <div class="form-group row">
          <label for="php_honeypot" class="col-form-label col-sm-2">Embedded Messenger Code</label>
          <div class="col-12 col-sm-10">
            <form target="sp" method="post" action="core/update.php" onsubmit="$('#messengerFBCode_save').removeClass('btn-danger');">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="messengerFBCode">
              <div class="input-group card-header p-2 mb-0">
                <button type="submit" id="messengerFBCode_save" class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-placement="bottom" data-title="Save" aria-label="Save"><?php svg('save');?></button>
              </div>
              <div class="input-group">
                <textarea id="messengerFBCode" class="form-control" style="height:300px" name="da" onkeyup="$('#messengerFBCode_save').addClass('btn-danger');"><?php echo $config['messengerFBCode'];?></textarea>
              </div>
            </form>
            <small class="help-block">Follow the instructions in the below links to add an Embedded Messaging Service:<br>
              <a target="_blank" href="https://developers.facebook.com/docs/messenger-platform/discovery/customer-chat-plugin#steps">Facebook Messenger</a>.
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
