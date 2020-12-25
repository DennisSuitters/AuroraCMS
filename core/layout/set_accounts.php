<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
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
          <div>Accounts Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="row">
          <input id="options3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3" type="checkbox"<?php echo$config['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options3" data-tooltip="tooltip" aria-label="Allow Users to Create Accounts.">Allow Account Sign Ups</label>
        </div>
        <hr>
        <legend>Password Reset Email Layout</legend>
        <div class="form-row">
          <label for="passwordResetSubject">Subject</label>
          <div class="form-text text-right">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret('passwordResetSubject','{business}');return false;">{business}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret('passwordResetSubject','{date}');return false;">{date}</a></div>
        </div>
        <div class="form-row">
          <input class="textinput" id="passwordResetSubject" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject" type="text" value="<?php echo$config['passwordResetSubject'];?>">
          <button class="save" id="savepasswordResetSubject" data-tooltip="tooltip" data-dbid="passwordResetSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="form-row mt-3">
          <label for="passwordResetLayout">Layout</label>
          <div class="form-text text-right">
            Tokens:
            <a class="badger badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{password}');return false;">{password}</a>
          </div>
        </div>
        <div class="row">
          <form method="post" target="sp" class="p-0" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="passwordResetLayout">
            <textarea class="summernote" id="passwordResetLayout" name="da"><?php echo rawurldecode($config['passwordResetLayout']);?></textarea>
          </form>
        </div>
        <hr>
        <legend>Sign Up Emails</legend>
        <div class="form-row">
          <label for="accountActivationSubject">Subject</label>
          <div class="form-text text-right">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret('accountActivationSubject','{username}');return false;">{username}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret('accountActivationSubject','{site}');return false;">{site}</a></div>
        </div>
        <div class="form-row">
          <input class="textinput" id="accountActivationSubject" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject" type="text" value="<?php echo$config['accountActivationSubject'];?>">
          <button class="save" id="saveaccountActivationSubject" data-tooltip="tooltip" data-dbid="accountActivationSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="form-row mt-3">
          <label for="accountActivationLayout">Layout</label>
          <div class="form-text text-right">Tokens:
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{username}');return false;">{username}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{password}');return false;">{password}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{site}');return false;">{site}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{activation_link}');return false;">{activation_link}</a>
          </div>
        </div>
        <div class="row">
          <form class="p-0" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="accountActivationLayout">
            <textarea class="summernote" id="accountActivationLayout" name="da"><?php echo rawurldecode($config['accountActivationLayout']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
