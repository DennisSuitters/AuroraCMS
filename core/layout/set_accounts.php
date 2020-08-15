<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.17 Fix WYSIWYG Editor Layout.
 * @changes    v0.0.18 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
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
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options3" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3"<?php echo$config['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options3" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10" data-tooltip="tooltip" data-title="Allow Users to Create Accounts.">Allow Account Sign Ups</label>
        </div>
        <hr/>
        <legend>Password Reset Email Layout</legend>
        <div class="form-group">
          <label for="passwordResetSubject">Subject</label>
          <div class="form-text small text-muted float-right">Tokens: <a class="badge badge-secondary" href="#" onclick="insertAtCaret('passwordResetSubject','{business}');return false;">{business}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('passwordResetSubject','{date}');return false;">{date}</a></div>
          <div class="input-group">
            <input type="text" id="passwordResetSubject" class="form-control textinput" value="<?php echo$config['passwordResetSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject">
            <div class="input-group-append">
              <button id="savepasswordResetSubject" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="passwordResetSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="passwordResetLayout">Layout</label>
          <div class="input-group card-header p-0">
            <div class="col-12 form-text small text-muted text-right">Tokens:
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{business}');return false;">{business}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{name}');return false;">{name}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{first}');return false;">{first}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{last}');return false;">{last}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{date}');return false;">{date}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{password}');return false;">{password}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" class="w-100">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="passwordResetLayout">
              <textarea id="passwordResetLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['passwordResetLayout']);?></textarea>
            </form>
          </div>
        </div>
        <hr>
        <legend>Sign Up Emails</legend>
        <div class="form-group">
          <label for="accountActivationSubject">Subject</label>
          <div class="form-text small text-muted float-right">Tokens: <a class="badge badge-secondary" href="#" onclick="insertAtCaret('accountActivationSubject','{username}');return false;">{username}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('accountActivationSubject','{site}');return false;">{site}</a></div>
          <div class="input-group">
            <input type="text" id="accountActivationSubject" class="form-control textinput" value="<?php echo$config['accountActivationSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject">
            <div class="input-group-append">
              <button id="saveaccountActivationSubject" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="accountActivationSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="accountActivationLayout">Layout</label>
          <div class="input-group card-header p-0">
            <div class="col-12 form-text small text-muted text-right">Tokens:
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{username}');return false;">{username}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{password}');return false;">{password}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{site}');return false;">{site}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{activation_link}');return false;">{activation_link}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" class="w-100">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="accountActivationLayout">
              <textarea id="accountActivationLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['accountActivationLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
