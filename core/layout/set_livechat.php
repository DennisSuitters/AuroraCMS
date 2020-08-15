<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Live Chat
 * @package    core/layout/set_livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.6 Make Facebook Messenger integration easier.
 * @changes    v0.0.6 Add toggle option to email nominated Users to alert of new chat messages.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.18 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/livechat';?>">Live Chat</a></li>
    <li class="breadcrumb-item active"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
        <a href="#" class="btn btn-ghost-normal saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields"><?php echo svg('save');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options13" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="13"<?php echo$config['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options13" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable Chat</label>
        </div>
        <div class="form-group">
          <label for="chatAutoRemove">Remove Messages</label>
          <div class="input-group">
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
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options15" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="15"<?php echo$config['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options15" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Email new LiveChat notifications to nominated accounts.</label>
        </div>
        <hr>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options14" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="14"<?php echo$config['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options14" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Facebook Messenger</label>
        </div>
<?php if($config['messengerFBCode']==''){?>
        <div class="form-group row">
          <div class="alert alert-info">
            To find your Page ID and fully enable Messenger:<br>
            1. From News Feed, click Pages in the left side menu.<br>
            2. Click your Page name to go to your Page.<br>
            3. Click About in the left column. If you don't see About in the left column, click See More.<br>
            4. Scroll down to find your Page ID below More Info, copy the ID, then place in the Page ID textbox below, and save.<br>
            5. Before Messenger will work, you must "Whitelist" your Websites domain name. In the your pages "Settings", go to the "Advanced Messaging" Tab.<br>
            6. Scroll down to find "White-listed Domains", and enter your domain name including the https:// protocol.
          </div>
        </div>
<?php }?>
        <div class="form-group">
          <label for="messengerFBCode">Page ID</label>
          <div class="input-group">
            <input type="text" id="messengerFBCode" class="form-control textinput" value="<?php echo$config['messengerFBCode'];?>" data-dbid="1" data-dbt="config" data-dbc="messengerFBCode" placeholder="Enter Page ID...">
            <div class="input-group-append">
              <button id="savemessengerFBCode" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="messengerFBCode" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="messengerFBGreeting">Greeting</label>
          <div class="input-group">
            <input type="text" id="messengerFBGreeting" class="form-control textinput" value="<?php echo$config['messengerFBGreeting'];?>" data-dbid="1" data-dbt="config" data-dbc="messengerFBGreeting" placeholder="Enter Greeting...">
            <div class="input-group-append">
              <button id="savemessengerFBGreeting" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="messengerFBGreeting" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="messengerFBColor">Colour</label>
          <div class="input-group">
            <select name="colorpicker" id="messengerFBColor" class="form-control"<?php echo$user['options'][1]==0?' disabled':'';?> onchange="update('1','config','messengerFBColor',$(this).val());" data-dbid="1" data-dbt="config" data-dbc="messengerFBColor"<?php echo$user['options'][1]==1?'':' disabled';?>>
              <option value="#7bd148"<?php echo$config['messengerFBColor']=='#7bd148'?' selected="selected"':'';?>>Green</option>
              <option value="#5484ed"<?php echo$config['messengerFBColor']=='#5484ed'?' selected="selected"':'';?>>Bold blue</option>
              <option value="#a4bdfc"<?php echo$config['messengerFBColor']=='#a4bdfc'?' selected="selected"':'';?>>Blue</option>
              <option value="#46d6db"<?php echo$config['messengerFBColor']=='#46d6db'?' selected="selected"':'';?>>Turquoise</option>
              <option value="#7ae7bf"<?php echo$config['messengerFBColor']=='#7ae7bf'?' selected="selected"':'';?>>Light green</option>
              <option value="#51b749"<?php echo$config['messengerFBColor']=='#51b749'?' selected="selected"':'';?>>Bold green</option>
              <option value="#fbd75b"<?php echo$config['messengerFBColor']=='#fbd75b'?' selected="selected"':'';?>>Yellow</option>
              <option value="#ffb878"<?php echo$config['messengerFBColor']=='#ffb878'?' selected="selected"':'';?>>Orange</option>
              <option value="#ff887c"<?php echo$config['messengerFBColor']=='#ff887c'?' selected="selected"':'';?>>Red</option>
              <option value="#dc2127"<?php echo$config['messengerFBColor']=='#dc2127'?' selected="selected"':'';?>>Bold red</option>
              <option value="#dbadff"<?php echo$config['messengerFBColor']=='#dbadff'?' selected="selected"':'';?>>Purple</option>
              <option value="#e1e1e1"<?php echo$config['messengerFBColor']=='#e1e1e1'?' selected="selected"':'';?>>Gray</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
