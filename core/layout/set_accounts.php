<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid ">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
                <li class="breadcrumb-item active">Settings</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <input id="configoptions3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3" type="checkbox"<?=($config['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="configoptions3" data-tooltip="tooltip" aria-label="Allow Users to Create Accounts.">Allow Account Sign Ups</label>
        </div>
        <div class="form-row">
          <input id="configoptions30" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="30" type="checkbox"<?=($config['options'][30]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="configoptions30" data-tooltip="tooltip" aria-label="Must be Logged In to Purchase Products.">Must be Logged In to Purchase Products</label>
        </div>
        <div class="form-row">
          <input id="configiconsColor0" data-dbid="1" data-dbt="config" data-dbc="iconsColor" data-dbb="0" type="checkbox"<?=($config['iconsColor']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="configiconsColor0" data-tooltip="tooltip" aria-label="Check for Address Information for Logged in Account.">Check for Address Information for Logged in Account.</label>
        </div>
        <div class="form-row">
          <input id="configoptions0" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="0" type="checkbox"<?=($config['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="configoptions0" data-tooltip="tooltip" aria-label="Enable Points Value Display.">Display Points Value</label>
        </div>
        <?php if($user['options'][7]==1){?>
          <hr>
          <legend>Export Accounts Information</legend>
          <form class="row" target="sp" method="post" action="core/export_accounts.php">
            <div class="col-4 exports" style="display:none;">
              <div class="mt-5">
                <div class="form-row">
                  <input id="exportID" type="checkbox" name="id" value="1" checked>
                  <label for="exportID">ID</label>
                </div>
                <div class="form-row">
                  <input id="exportActive" type="checkbox" name="act" value="1" checked>
                  <label for="act">Active Account</label>
                </div>
                <div class="form-row">
                  <input id="exportDate" type="checkbox" name="dte" value="1" checked>
                  <label for="exportDate">Date</label>
                </div>
                <div class="form-row">
                  <input id="exportRank" type="checkbox" name="rnk" value="1" checked>
                  <label for="exportRank">Rank</label>
                </div>
                <div class="form-row">
                  <input id="exportUsername" type="checkbox" name="usr" value="1" checked>
                  <label for="exportUsername">Username</label>
                </div>
                <div class="form-row">
                  <input id="exportName" type="checkbox" name="nme" value="1" checked>
                  <label for="exportName">Name</label>
                </div>
                <div class="form-row">
                  <input id="exportEmail" type="checkbox" name="eml" value="1" checked>
                  <label for="exportEmail">Email</label>
                </div>
                <div class="form-row">
                  <input id="exportPhone" type="checkbox" name="phn" value="1" checked>
                  <label for="exportPhone">Phone</label>
                </div>
                <div class="form-row">
                  <input id="exportMobile" type="checkbox" name="mob" value="1" checked>
                  <label for="exportMobile">Mobile</label>
                </div>
                <div class="form-row">
                  <input id="exportWebsite" type="checkbox" name="url" value="1" checked>
                  <label for="exportWebsite">Website</label>
                </div>
                <div class="form-row">
                  <input id="exportBusiness" type="checkbox" name="bus" value="1" checked>
                  <label for="exportBusiness">Business</label>
                </div>
                <div class="form-row">
                  <input id="exportABN" type="checkbox" name="abn" value="1" checked>
                  <label for="exportABN">ABN</label>
                </div>
                <div class="form-row">
                  <input id="exportAddress" type="checkbox" name="adr" value="1" checked>
                  <label for="exportAddress">Address</label>
                </div>
                <div class="form-row">
                  <input id="exportSpent" type="checkbox" name="spnt" value="1" checked>
                  <label for="exportSpent">Spent</label>
                </div>
                <div class="form-row">
                  <input id="exportPoints" type="checkbox" name="pnts" value="1" checked>
                  <label for="exportPoints">Points</label>
                </div>
                <div class="form-row">
                  <input id="exportNewsletter" type="checkbox" name="nws" value="1" checked>
                  <label for="exportNewsletter">Newsletter Subscriber</label>
                </div>
              </div>
            </div>
            <div class="col-8">
              <div class="row m-0">
                <div class="col">
                  <label>&nbsp;</label>
                  <div class="form-row">
                    <button onclick="$('.exports').toggle('d-none');return false;"><span class="exports" style="display:none;">Hide</span><span class="exports">Show</span> Options</button>
                  </div>
                </div>
                <div class="col">
                  <label for="exportDeliminator">Deliminator</label>
                  <div class="form-row">
                    <select name="d">
                      <option value="0" selected>, (comma)</option>
                      <option value="1">| (pipe)</option>
                      <option value="2">; (semicolon)</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="exportFormat">Format</label>
                  <div class="form-row">
                    <select name="f">
                      <option value="0">CSV</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label>&nbsp;</label>
                  <div class="form-row">
                    <button type="submit">Export</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        <?php }?>
        <hr>
        <legend>Purchase Item Limits</legend>
        <div class="row">
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="memberLimit">Member Limit</label>
            <div class="form-row">
              <input class="textinput" id="memberLimit" data-dbid="1" data-dbt="config" data-dbc="memberLimit" type="number" value="<?=$config['memberLimit'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savememberLimit" data-dbid="memberLimit" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="memberLimitSilver">Member Silver Limit</label>
            <div class="form-row">
              <input class="textinput" id="memberLimitSilver" data-dbid="1" data-dbt="config" data-dbc="memberLimitSilver" type="number" value="<?=$config['memberLimitSilver'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savememberLimitSilver" data-dbid="memberLimitSilver" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="memberLimitBronze">Member Bronze Limit</label>
            <div class="form-row">
              <input class="textinput" id="memberLimitBronze" data-dbid="1" data-dbt="config" data-dbc="memberLimitBronze" type="number" value="<?=$config['memberLimitBronze'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savememberLimitBronze" data-dbid="memberLimitBronze" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="memberLimitGold">Member Gold Limit</label>
            <div class="form-row">
              <input class="textinput" id="memberLimitGold" data-dbid="1" data-dbt="config" data-dbc="memberLimitGold" type="number" value="<?=$config['memberLimitGold'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savememberLimitGold" data-dbid="memberLimitGold" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2">
            <label class="small" for="memberLimitPlatinum">Member Platinum Limit</label>
            <div class="form-row">
              <input class="textinput" id="memberLimitPlatinum" data-dbid="1" data-dbt="config" data-dbc="memberLimitPlatinum" type="number" value="<?=$config['memberLimitPlatinum'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savememberLimitPlatinum" data-dbid="memberLimitPlatinum" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleLimit">Wholesale Bronze Limit</label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimit" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimit" type="number" value="<?=$config['wholesaleLimit'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savewholesaleLimit" data-dbid="wholesaleLimit" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleLimitBronze">Wholesale Bronze Limit</label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitBronze" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitBronze" type="number" value="<?=$config['wholesaleLimitBronze'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savewholesaleLimitBronze" data-dbid="wholesaleLimitBronze" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleLimitSilver">Wholesale Silver Limit</label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitSilver" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitSilver" type="number" value="<?=$config['wholesaleLimitSilver'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savewholesaleLimitSilver" data-dbid="wholesaleLimitSilver" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleLimitGold">Wholesale Gold Limit</label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitGold" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitGold" type="number" value="<?=$config['wholesaleLimitGold'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savewholesaleLimitGold" data-dbid="wholesaleLimitGold" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-6 col-md-2">
            <label class="small" for="wholesaleLimitPlatinum">Wholesale Platinum Limit</label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitPlatinum" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitPlatinum" type="number" value="<?=$config['wholesaleLimitPlatinum'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savewholesaleLimitPlatinum" data-dbid="wholesaleLimitPlatinum" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
        </div>
        <legend class="mt-3">Wholesale Purchase Time Limits</legend>
        <div class="row">
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleTime">Wholesale Limit</label>
            <select id="wholesaleTime" data-dbid="1" data-dbt="login" data-dbc="wholesaleTime"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`wholesaleTime`,$(this).val(),`select`);"':' disabled';?>>
              <option value="0"<?=$config['wholesaleTime']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTime']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTime']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTime']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTime']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTime']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTime']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTime']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleTimeBronze">Wholesale Bronze Limit</label>
            <select id="wholesaleTimeBronze" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimeBronze"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`wholesaleTimeBronze`,$(this).val(),`select`);"':' disabled';?>>
              <option value="0"<?=$config['wholesaleTimeBronze']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimeBronze']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimeBronze']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimeBronze']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimeBronze']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimeBronze']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimeBronze']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimeBronze']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleTimeSilver">Wholesale Silver Limit</label>
            <select id="wholesaleTimeSilver" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimeSilver"<?=$user['options'][5]==1?' onchange="update(`1`,`config`,`wholesaleTimeSilver`,$(this).val(),`select`);"':' disabled';?>>
              <option value="0"<?=$config['wholesaleTimeSilver']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimeSilver']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimeSilver']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimeSilver']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimeSilver']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimeSilver']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimeSilver']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimeSilver']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
          <div class="col-6 col-md-2 mr-md-4">
            <label class="small" for="wholesaleTimeGold">Wholesale Gold Limit</label>
            <select id="wholesaleTimeGold" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimeGold"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`wholesaleTimeGold`,$(this).val(),`select`);"':' disabled';?>>
              <option value="0"<?=$config['wholesaleTimeGold']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimeGold']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimeGold']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimeGold']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimeGold']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimeGold']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimeGold']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimeGold']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="small" for="wholesaleTimePlatinum">Wholesale Platinum Limit</label>
            <select id="wholesaleTimePlatinum" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimePlatinum"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`wholesaleTimePlatinum`,$(this).val(),`select`);"':' disabled';?>>
              <option value="0"<?=$config['wholesaleTimePlatinum']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimePlatinum']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimePlatinum']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimePlatinum']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimePlatinum']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimePlatinum']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimePlatinum']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimePlatinum']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
        </div>
        <hr>
        <legend>Password Reset Email Layout</legend>
        <label for="pwdRstSub">Subject</label>
        <?=($user['options'][7]==1?'<div class="form-text">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret(`pwdRstSub`,`{business}`);return false;">{business}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret(`pwdRstSub`,`{date}`);return false;">{date}</a></div>':'');?>
        <div class="form-row">
          <input class="textinput" id="pwdRstSub" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject" type="text" value="<?=$config['passwordResetSubject'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Password Reset Email Subject..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savepwdRstSub" data-dbid="pwdRstSub" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <div class="row mt-3">
          <?php if($user['options'][7]==1){?>
            <div class="form-text">
              Tokens:
              <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{business}');return false;">{business}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{name}');return false;">{name}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{first}');return false;">{first}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{last}');return false;">{last}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{date}');return false;">{date}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{password}');return false;">{password}</a>
            </div>
            <form method="post" target="sp" class="p-0" action="core/update.php">
              <input name="id" type="hidden" value="1">
              <input name="t" type="hidden" value="config">
              <input name="c" type="hidden" value="passwordResetLayout">
              <textarea class="summernote" id="pRL" name="da"><?= rawurldecode($config['passwordResetLayout']);?></textarea>
            </form>
          <?php }else{?>
            <div class="note-admin">
              <div class="note-editor note-frame">
                <div class="note-editing-area">
                  <div class="note-viewport-area">
                    <div class="note-editable">
                      <?= rawurldecode($config['passwordResetLayout']);?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend>Sign Up Emails</legend>
        <label for="aS">Subject</label>
        <?=($user['options'][7]==1?'<div class="form-text">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret(`aS`,`{username}`);return false;">{username}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret(`aS`,`{site}`);return false;">{site}</a></div>':'');?>
        <div class="form-row">
          <input class="textinput" id="aS" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject" type="text" value="<?=$config['accountActivationSubject'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Sign Up Email Subject..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="saveaS" data-dbid="aS" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <div class="row mt-3">
          <?php if($user['options'][7]==1){?>
            <div class="form-text">Tokens:
              <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{username}');return false;">{username}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{password}');return false;">{password}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{site}');return false;">{site}</a>
              <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{activation_link}');return false;">{activation_link}</a>
            </div>
            <form class="p-0" method="post" target="sp" action="core/update.php">
              <input name="id" type="hidden" value="1">
              <input name="t" type="hidden" value="config">
              <input name="c" type="hidden" value="accountActivationLayout">
              <textarea class="summernote" id="accountActivationLayout" name="da"><?= rawurldecode($config['accountActivationLayout']);?></textarea>
            </form>
          <?php }else{?>
            <div class="note-admin">
              <div class="note-editor note-frame">
                <div class="note-editing-area">
                  <div class="note-viewport-area">
                    <div class="note-editable">
                      <?= rawurldecode($config['accountActivationLayout']);?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
