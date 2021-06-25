<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('users','i-3x');?></div>
          <div>Newsletters Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?= svg2('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/newsletters';?>">Newsletters</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <div class="form-row mt-3">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/settings#embedImages" aria-label="PermaLink to Embed Image Checkbox">&#128279;</a>':'';?>
          <input id="embedImages" data-dbid="1" data-dbt="config" data-dbc="newslettersEmbedImages" data-dbb="0" type="checkbox"<?=$config['newslettersEmbedImages'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="embedImages" id="confignewslettersEmbedImages01">&nbsp;&nbsp;Embed&nbsp;Images</label>
          <small class="form-text text-right">Enable if your hosting doesn't support remote image access.</small>
        </div>
        <div id="sendMax" class="form-row mt-3">
          <label for="newslettersSendMax"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/settings#sendMax" aria-label="PermaLink to Send Max">&#128279;</a>':'';?>Send&nbsp;Max</label>
          <small class="form-text text-right">Maximum Emails to Send in one Instance. '0' uses the Default of '50'.</small>
        </div>
        <div class="form-row mt-3">
          <input class="textinput" id="newslettersSendMax" type="text" value="<?=$config['newslettersSendMax'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendMax">
          <button class="save" id="savenewslettersSendMax" data-tooltip="tooltip" data-dbid="newslettersSendMax" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div id="sendDelay" class="form-row mt-3">
          <label id="sendDelay" for="newslettersSendDelay"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/settings#sendDelay" aria-label="PermaLink to Send Delay">&#128279;</a>':'';?>Send&nbsp;Delay</label>
          <small class="form-text text-right">Seconds to Delay between Email Sends. '0' uses the default of '1' second.</small>
        </div>
        <div class="form-row">
          <input class="textinput" id="newslettersSendDelay" data-dbid="1" data-dbt="config" data-dbc="newslettersSendDelay" type="text" value="<?=$config['newslettersSendDelay'];?>">
          <button class="save" id="savenewslettersSendDelay" data-tooltip="tooltip" data-placement="top" data-dbid="newslettersSendDelay" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <hr>
        <legend id="optOutMessage" class="mt-3"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/settings#optOutMessage" aria-label="PermaLink to Opt Out Message">&#128279;</a>':'';?>Opt Out Message</legend>
        <div class="form-row">
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#optOutLayout').summernote('insertText','{optOutLink}');return false;">{optOutLink}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="newslettersOptOutLayout">
            <textarea class="summernote" id="optOutLayout" name="da"><?= rawurldecode($config['newslettersOptOutLayout']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
