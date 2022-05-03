<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Live Chat
 * @package    core/layout/set_livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">users</i></div>
          <div>Live Chat Settings</div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="tooltip" aria-label="Back"><i class="i">back</i></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><i class="i">save</i></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/livechat';?>">Live Chat</a></li>
          <li class="breadcrumb-item active"><strong>Settings</strong></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/livechat/settings#enableChat" data-tooltip="tooltip" aria-label="PermaLink to Enable Chat Checkbox">&#128279;</a>':'';?>
          <input id="enableChat" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="13" type="checkbox"<?=$config['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="enableChat" id="configoptions131">Enable Live Chat</label>
        </div>
        <label id="removeMessages" for="chatAutoRemove"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/livechat/settings#removeMessages" data-tooltip="tooltip" aria-label="PermaLink to Remove Messages Selector">&#128279;</a>':'';?>Remove Messages</label>
        <div class="form-row">
          <select id="chatAutoRemove" data-dbid="1" data-dbt="config" data-dbc="chatAutoRemove" onchange="update('1','config','chatAutoRemove',$(this).val(),'select');">
            <option value="0"<?=$config['chatAutoRemove']==0?' selected':'';?>>Never</option>
            <option value="86400"<?=$config['chatAutoRemove']==86400?' selected':'';?>>Older than 24 Hours</option>
            <option value="172800"<?=$config['chatAutoRemove']==172800?' selected':'';?>>Older than 2 Days</option>
            <option value="604800"<?=$config['chatAutoRemove']==604800?' selected':'';?>>Older than 7 Days</option>
            <option value="1209600"<?=$config['chatAutoRemove']==1209600?' selected':'';?>>Older than 14 Days</option>
            <option value="2592000"<?=$config['chatAutoRemove']==2592000?' selected':'';?>>Older than 30 Days</option>
          </select>
        </div>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/livechat/settings#chatNotifications" data-tooltip="tooltip" aria-label="PermaLink to Chat Notifications Checkbox">&#128279;</a>':'';?>
          <input id="chatNotifications" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="15" type="checkbox"<?=$config['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="chatNotifications" id="configoptions151">Email new LiveChat notifications to nominated accounts.</label>
        </div>
        <hr>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/livechat/settings#facebookMessenger" data-tooltip="tooltip" aria-label="PermaLink to Enable Facebook Messenger Checkbox">&#128279;</a>':'';?>
          <input id="facebookMessenger" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="14" type="checkbox"<?=$config['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="facebookMessenger" id="configoptions141">Facebook Messenger</label>
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
        <label id="facebookMessengerCode" for="messengerFBCode"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/livechat/settings#facebookMessengerCode" data-tooltip="tooltip" aria-label="PermaLink to Facebook Messenger Code">&#128279;</a>':'';?>Page ID</label>
        <div class="form-row">
          <input class="textinput" id="messengerFBCode" data-dbid="1" data-dbt="config" data-dbc="messengerFBCode" type="text" value="<?=$config['messengerFBCode'];?>" placeholder="Enter Page ID...">
          <button class="save" id="savemessengerFBCode" data-dbid="messengerFBCode" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <label id="facebookMessengerGreeting" for="messengerFBGreeting"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/livechat/settings#facebookMessengerGreeting" data-tooltip="tooltip" aria-label="PermaLink to Facebook Messenger Greeting">&#128279;</a>':'';?>Greeting</label>
        <div class="form-row">
          <input class="textinput" id="messengerFBGreeting" data-dbid="1" data-dbt="config" data-dbc="messengerFBGreeting" type="text" value="<?=$config['messengerFBGreeting'];?>" placeholder="Enter Greeting...">
          <button class="save" id="savemessengerFBGreeting" data-dbid="messengerFBGreeting" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <label id="facebookMessengerColor" for="messengerFBColor"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/livechat/settings#facebookMessengerColor" data-tooltip="tooltip" aria-label="PermaLink to Facebook Messenger Colour">&#128279;</a>':'';?>Colour</label>
        <div class="form-row">
          <select id="messengerFBColor" name="colorpicker"<?=$user['options'][1]==0?' disabled':'';?> onchange="update('1','config','messengerFBColor',$(this).val(),'select');" data-dbid="1" data-dbt="config" data-dbc="messengerFBColor"<?=$user['options'][1]==1?'':' disabled';?>>
            <option value="#7bd148"<?=$config['messengerFBColor']=='#7bd148'?' selected':'';?>>Green</option>
            <option value="#5484ed"<?=$config['messengerFBColor']=='#5484ed'?' selected':'';?>>Bold blue</option>
            <option value="#a4bdfc"<?=$config['messengerFBColor']=='#a4bdfc'?' selected':'';?>>Blue</option>
            <option value="#46d6db"<?=$config['messengerFBColor']=='#46d6db'?' selected':'';?>>Turquoise</option>
            <option value="#7ae7bf"<?=$config['messengerFBColor']=='#7ae7bf'?' selected':'';?>>Light green</option>
            <option value="#51b749"<?=$config['messengerFBColor']=='#51b749'?' selected':'';?>>Bold green</option>
            <option value="#fbd75b"<?=$config['messengerFBColor']=='#fbd75b'?' selected':'';?>>Yellow</option>
            <option value="#ffb878"<?=$config['messengerFBColor']=='#ffb878'?' selected':'';?>>Orange</option>
            <option value="#ff887c"<?=$config['messengerFBColor']=='#ff887c'?' selected':'';?>>Red</option>
            <option value="#dc2127"<?=$config['messengerFBColor']=='#dc2127'?' selected':'';?>>Bold red</option>
            <option value="#dbadff"<?=$config['messengerFBColor']=='#dbadff'?' selected':'';?>>Purple</option>
            <option value="#e1e1e1"<?=$config['messengerFBColor']=='#e1e1e1'?' selected':'';?>>Gray</option>
          </select>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
