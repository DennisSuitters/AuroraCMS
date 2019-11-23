<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>">Newsletters</a></li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="newslettersEmbedImages" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="newslettersEmbedImages" data-dbb="0"<?php echo$config['newslettersEmbedImages']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="newslettersEmbedImages" class="col-form-label col-4 col-sm-5 col-md-5 col-lg-5 col-xl-2">Embed Images</label>
          <div class="input-group col">
            <div class="help-block text-muted small p-1">Enable if your hosting doesn't support remote image access.</div>
          </div>
        </div>
        <div class="form-group row">
          <div class="help-block text-muted small col-12 text-right">Maximum Emails to Send in one Instance. '0' uses the Default of '50'.</div>
          <label for="newslettersSendMax" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Send Max</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="newslettersSendMax" class="form-control textinput" value="<?php echo$config['newslettersSendMax'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendMax">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savenewslettersSendMax" class="btn btn-secondary save" data-dbid="newslettersSendMax" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-12 text-muted small text-right">Seconds to Delay between Email Sends. '0' uses the default of '1' second.</div>
          <label for="newslettersSendDelay" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Send Delay</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="newslettersSendDelay" class="form-control textinput" value="<?php echo$config['newslettersSendDelay'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendDelay">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savenewslettersSendDelay" class="btn btn-secondary save" data-dbid="newslettersSendDelay" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <hr>
        <legend>Opt Out Message</legend>
        <div class="form-group row">
          <label class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2"></label>
          <div class="input-group card-header col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10 p-0">
            <div class="col text-right"><small>Tokens:</small>
              <a class="badge badge-secondary" href="#" onclick="$('#optOutLayout').summernote('insertText','{optOutLink}');return false;">{optOutLink}</a>
            </div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="newslettersOptOutLayout">
              <textarea id="optOutLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['newslettersOptOutLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>