<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Live Chat
 * @package    core/layout/set_livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/livechat';?>">Live Chat</a></li>
                <li class="breadcrumb-item active"><strong>Settings</strong></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a class="btn" href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <input id="enableChat" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="13" type="checkbox"<?=($config['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="enableChat">Enable Live Chat</label>
        </div>
        <label for="chatAutoRemove">Remove Messages</label>
        <div class="form-row">
          <select id="chatAutoRemove" data-dbid="1" data-dbt="config" data-dbc="chatAutoRemove"<?=($user['options'][7]==1?' onchange="update(`1`,`config`,`chatAutoRemove`,$(this).val(),`select`);"':' disabled');?>>
            <option value="0"<?=$config['chatAutoRemove']==0?' selected':'';?>>Never</option>
            <option value="86400"<?=$config['chatAutoRemove']==86400?' selected':'';?>>Older than 24 Hours</option>
            <option value="172800"<?=$config['chatAutoRemove']==172800?' selected':'';?>>Older than 2 Days</option>
            <option value="604800"<?=$config['chatAutoRemove']==604800?' selected':'';?>>Older than 7 Days</option>
            <option value="1209600"<?=$config['chatAutoRemove']==1209600?' selected':'';?>>Older than 14 Days</option>
            <option value="2592000"<?=$config['chatAutoRemove']==2592000?' selected':'';?>>Older than 30 Days</option>
          </select>
        </div>
        <div class="form-row mt-3">
          <input id="chatNotifications" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="15" type="checkbox"<?=($config['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="chatNotifications">Email new LiveChat notifications to nominated accounts.</label>
        </div>
        <hr>
        <legend>Facebook On Site Chat Messenger</legend>
        <div class="form-row mt-3">
          <input id="facebookMessenger" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="14" type="checkbox"<?=($config['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="facebookMessenger" id="configoptions141">Enable</label>
        </div>
        <label for="messengerFBCode">Page ID</label>
        <?php if($user['options'][7]==1){
          if($config['messengerFBCode']==''){?>
            <div class="alert alert-info">
              To find your Page ID and fully enable Messenger:<br>
              1. From News Feed, click Pages in the left side menu.<br>
              2. Click your Page name to go to your Page.<br>
              3. Click About in the left column. If you don't see About in the left column, click See More.<br>
              4. Scroll down to find your Page ID below More Info, copy the ID, then place in the Page ID textbox below, and save.<br>
              5. Before Messenger will work, you must "Whitelist" your Websites domain name. In the your pages "Settings", go to the "Advanced Messaging" Tab.<br>
              6. Scroll down to find "White-listed Domains", and enter your domain name including the https:// protocol.
            </div>
          <?php }
        }?>
        <div class="form-row">
          <input class="textinput" id="messengerFBCode" data-dbid="1" data-dbt="config" data-dbc="messengerFBCode" type="text" value="<?=$config['messengerFBCode'];?>"<?=($user['options'][7]==1?' placeholder="Enter Page ID..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savemessengerFBCode" data-dbid="messengerFBCode" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <label for="messengerFBGreeting">Greeting</label>
        <div class="form-row">
          <input class="textinput" id="messengerFBGreeting" data-dbid="1" data-dbt="config" data-dbc="messengerFBGreeting" type="text" value="<?=$config['messengerFBGreeting'];?>"<?=($user['options'][7]==1?' placeholder="Enter Greeting..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savemessengerFBGreeting" data-dbid="messengerFBGreeting" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <label for="messengerFBColor">Colour</label>
        <div class="form-row">
          <select id="messengerFBColor" name="colorpicker"<?=$user['options'][1]==0?' disabled':'';?> onchange="update('1','config','messengerFBColor',$(this).val(),'select');" data-dbid="1" data-dbt="config" data-dbc="messengerFBColor"<?=$user['options'][7]==1?'':' disabled';?>>
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
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
