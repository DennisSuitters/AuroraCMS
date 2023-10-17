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
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/newsletters';?>">Newsletters</a></li>
                <li class="breadcrumb-item active">Settings</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <input id="embedImages" data-dbid="1" data-dbt="config" data-dbc="newslettersEmbedImages" data-dbb="0" type="checkbox"<?=($config['newslettersEmbedImages']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label for="embedImages">Embed&nbsp;Images</label>
        </div>
        <?=($user['options'][7]==1?'<div class="form-text">Enable if your hosting doesn\'t support remote image access.</div>':'');?>
        <label for="newslettersSendMax">Send Max</label>
        <?=($user['options'][7]==1?'<small class="form-text text-muted">Maximum Emails to Send in one Instance. \'0\' uses the Default of \'50\'.</small>':'');?>
        <div class="form-row">
          <input class="textinput" id="newslettersSendMax" type="text" value="<?=$config['newslettersSendMax'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendMax"<?=($user['options'][7]==1?'':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savenewslettersSendMax" data-dbid="newslettersSendMax" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <label for="newslettersSendDelay">Send Delay</label>
        <?=($user['options'][7]==1?'<div class="form-text">Seconds to Delay between Email Sends. \'0\' uses the default of \'1\' second.</div>':'');?>
        <div class="form-row">
          <input class="textinput" id="newslettersSendDelay" data-dbid="1" data-dbt="config" data-dbc="newslettersSendDelay" type="text" value="<?=$config['newslettersSendDelay'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savenewslettersSendDelay" data-placement="top" data-dbid="newslettersSendDelay" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <legend class="mt-3">Opt Out Message</legend>
        <?php if($user['options'][7]==1){?>
          <div class="form-text">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#optOutLayout').summernote('insertText','{optOutLink}');return false;">{optOutLink}</a>
          </div>
          <div class="row">
            <form method="post" target="sp" action="core/update.php">
              <input name="id" type="hidden" value="1">
              <input name="t" type="hidden" value="config">
              <input name="c" type="hidden" value="newslettersOptOutLayout">
              <textarea class="summernote" id="optOutLayout" name="da"><?= rawurldecode($config['newslettersOptOutLayout']);?></textarea>
            </form>
          </div>
        <?php }else{?>
          <div class="row">
            <div class="note-admin">
              <div class="note-editor note-frame">
                <div class="note-editing-area">
                  <div class="note-viewport-area">
                    <div class="note-editable">
                      <?= rawurldecode($config['newslettersOptOutLayout']);?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }?>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
