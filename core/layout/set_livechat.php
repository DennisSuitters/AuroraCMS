<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Live Chat
 * @package    core/layout/set_livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('users','i-3x');?></div>
          <div>Live Chat Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" data-title="Back" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <button data-tooltip="tooltip" data-title="Toggle Fullscreen" aria-label"Toggle Fullscreen" onclick="toggleFullscreen();"><?php svg('fullscreen');?></button>
            <button class="saveall" data-tooltip="tooltip" data-title="Save All Edited Fields" aria-label="Save All Edited Fields"><?php svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/livechat';?>">Live Chat</a></li>
          <li class="breadcrumb-item active"><strong>Settings</strong></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="row mt-3">
          <input id="options13" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="13" type="checkbox"<?php echo$config['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options13">Enable Chat</label>
        </div>
        <label for="chatAutoRemove">Remove Messages</label>
        <div class="form-row">
          <select id="chatAutoRemove" data-dbid="1" data-dbt="config" data-dbc="chatAutoRemove" onchange="update('1','config','chatAutoRemove',$(this).val());">
            <option value="0"<?php echo$config['chatAutoRemove']==0?' selected="Selected"':'';?>>Never</option>
            <option value="86400"<?php echo$config['chatAutoRemove']==86400?' selected="Selected"':'';?>>Older than 24 Hours</option>
            <option value="172800"<?php echo$config['chatAutoRemove']==172800?' selected="Selected"':'';?>>Older than 2 Days</option>
            <option value="604800"<?php echo$config['chatAutoRemove']==604800?' selected="Selected"':'';?>>Older than 7 Days</option>
            <option value="1209600"<?php echo$config['chatAutoRemove']==1209600?' selected="Selected"':'';?>>Older than 14 Days</option>
            <option value="2592000"<?php echo$config['chatAutoRemove']==2592000?' selected="Selected"':'';?>>Older than 30 Days</option>
          </select>
        </div>
        <div class="row mt-3">
          <input id="options15" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="15" type="checkbox"<?php echo$config['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options15">Email new LiveChat notifications to nominated accounts.</label>
        </div>
        <hr>
        <div class="row mt-3">
          <input id="options14" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="14" type="checkbox"<?php echo$config['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options14">Facebook Messenger</label>
        </div>
        <?php if($config['messengerFBCode']==''){?>
          <div class="alert alert-info">
            To find your Page ID and fully enable Messenger:<br>
            1. From News Feed, click Pages in the left side menu.<br>
            2. Click your Page name to go to your Page.<br>
            3. Click About in the left column. If you don't see About in the left column, click See More.<br>
            4. Scroll down to find your Page ID below More Info, copy the ID, then place in the Page ID textbox below, and save.<br>
            5. Before Messenger will work, you must "Whitelist" your Websites domain name. In the your pages "Settings", go to the "Advanced Messaging" Tab.<br>
            6. Scroll down to find "White-listed Domains", and enter your domain name including the https:// protocol.
          </div>
        <?php }?>
        <label for="messengerFBCode">Page ID</label>
        <div class="form-row">
          <input class="textinput" id="messengerFBCode" data-dbid="1" data-dbt="config" data-dbc="messengerFBCode" type="text" value="<?php echo$config['messengerFBCode'];?>" placeholder="Enter Page ID...">
          <button class="save" id="savemessengerFBCode" data-tooltip="tooltip" data-title="Save" data-dbid="messengerFBCode" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="messengerFBGreeting">Greeting</label>
        <div class="form-row">
          <input class="textinput" id="messengerFBGreeting" data-dbid="1" data-dbt="config" data-dbc="messengerFBGreeting" type="text" value="<?php echo$config['messengerFBGreeting'];?>" placeholder="Enter Greeting...">
          <button class="save" id="savemessengerFBGreeting" data-tooltip="tooltip" data-title="Save" data-dbid="messengerFBGreeting" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="messengerFBColor">Colour</label>
        <div class="form-row">
          <select id="messengerFBColor" name="colorpicker"<?php echo$user['options'][1]==0?' disabled':'';?> onchange="update('1','config','messengerFBColor',$(this).val());" data-dbid="1" data-dbt="config" data-dbc="messengerFBColor"<?php echo$user['options'][1]==1?'':' disabled';?>>
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
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
