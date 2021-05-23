<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('users','i-3x');?></div>
          <div>Accounts Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?= svg2('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#createAccounts" aria-label="PermaLink to Allow Account Signups Checkbox">&#128279;</a>':'';?>
          <input id="configoptions3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3" type="checkbox"<?=$config['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label id="configoptions31" for="configoptions3" data-tooltip="tooltip" aria-label="Allow Users to Create Accounts.">Allow Account Sign Ups</label>
        </div>
        <hr>
        <legend id="passwordResetSection"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#passwordResetSection" aria-label="PermaLink to Password Reset Section">&#128279;</a>':'';?>Password Reset Email Layout</legend>
        <div id="passwordResetSubject" class="form-row">
          <label for="pwdRstSub"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#passwordResetSubject" aria-label="PermaLink to Password Reset Subject Field">&#128279;</a>':'';?>Subject</label>
          <div class="form-text text-right">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret('pwdRstSub','{business}');return false;">{business}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret('pwdRstSub','{date}');return false;">{date}</a></div>
        </div>
        <div class="form-row">
          <input class="textinput" id="pwdRstSub" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject" type="text" value="<?=$config['passwordResetSubject'];?>">
          <button class="save" id="savepwdRstSub" data-tooltip="tooltip" data-dbid="pwdRstSub" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div id="passwordResetLayout" class="form-row mt-3">
          <div class="form-text text-right">
            Tokens:
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{password}');return false;">{password}</a>
          </div>
        </div>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#passwordResetLayout" aria-label="PermaLink to Password Reset Layout">&#128279;</a>':'';?>
          <form method="post" target="sp" class="p-0" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="passwordResetLayout">
            <textarea class="summernote" id="pRL" name="da"><?= rawurldecode($config['passwordResetLayout']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="signUpSection"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#signUpSection" aria-label="PermaLink to Sign Up Section">&#128279;</a>':'';?>Sign Up Emails</legend>
        <div id="activatationSubject" class="form-row">
          <label for="aS"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#activationSubject" aria-label="PermaLink to Account Activation Subject Field">&#128279;</a>':'';?>Subject</label>
          <div class="form-text text-right">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aS','{username}');return false;">{username}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aS','{site}');return false;">{site}</a></div>
        </div>
        <div class="form-row">
          <input class="textinput" id="aS" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject" type="text" value="<?=$config['accountActivationSubject'];?>">
          <button class="save" id="saveaS" data-tooltip="tooltip" data-dbid="aS" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div id="activationLayout" class="form-row mt-3">
          <div class="form-text text-right">Tokens:
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{username}');return false;">{username}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{password}');return false;">{password}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{site}');return false;">{site}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{activation_link}');return false;">{activation_link}</a>
          </div>
        </div>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#activationLayout" aria-label="PermaLink to Activation Layout">&#128279;</a>':'';?>
          <form class="p-0" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="accountActivationLayout">
            <textarea class="summernote" id="accountActivationLayout" name="da"><?= rawurldecode($config['accountActivationLayout']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
