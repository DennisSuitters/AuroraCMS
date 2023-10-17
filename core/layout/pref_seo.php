<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
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
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
                <li class="breadcrumb-item active">SEO</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <?php if($user['rank']>899){?>
          <label>sitemap.xml</label>
          <div class="form-row">
            <div class="input-text col-12">
              <a target="_blank" href="<?= URL.'sitemap.xml';?>"><?= URL.'sitemap.xml';?></a>
            </div>
          </div>
          <label>humans.txt</label>
          <div class="form-row">
            <div class="input-text col-12">
              <a id="humans" target="_blank" href="<?= URL.'humans.txt';?>"><?= URL.'humans.txt';?></a>
            </div>
          </div>
          <hr>
          <legend>Webmaster Tools verification</legend>
          <label for="ga_verification">Google Verification code</label>
          <?=($user['options'][7]==1?'<div class="form-text">Get your Google verification code in <a target="_blank" href="https://www.google.com/webmasters/verification/verification?hl=en&tid=alternate&siteUrl=http%3A%2F%2Flocalhost%2Fwordpress/">Google Search Console</a>.</div>':'');?>
          <div class="form-row">
            <input class="textinput" id="ga_verification" data-dbid="1" data-dbt="config" data-dbc="ga_verification" type="text" value="<?=$config['ga_verification'];?>"<?=($user['options'][7]==1?' placeholder="Enter Google Site Verification Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savega_verification" data-dbid="ga_verification" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="ga_tracking">Google UA code</label>
          <?=($user['options'][7]==1?'<div class="form-text">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code. Only the UA code is required to enter below.</div>':'');?>
          <div class="form-row">
            <input class="textinput" id="ga_tracking" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" type="text" value="<?=$config['ga_tracking'];?>"<?=($user['options'][7]==1?' placeholder="Enter Google UA Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savega_tracking" data-dbid="ga_tracking" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="ga_tagmanager">Google Tag Manager code</label>
          <div class="form-row">
            <input class="textinput" id="ga_tagmanager" data-dbid="1" data-dbt="config" data-dbc="ga_tagmanager" type="text" value="<?=$config['ga_tagmanager'];?>"<?=($user['options'][7]==1?' placeholder="Enter Google Tag Manager Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savega_tagmanager" data-dbid="ga_tagmanager" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="seo_msvalidate">Bing Verification code</label>
          <?=($user['options'][7]==1?'<div class="form-text">Get your Bing verification code in <a target="_blank" href="https://www.bing.com/toolbox/webmaster/#/Dashboard/?url=localhost%2Fwordpress">Bing Webmaster Tools</a></div>':'');?>
          <div class="form-row">
            <input class="textinput" id="seo_msvalidate" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" type="text" value="<?=$config['seo_msvalidate'];?>"<?=($user['options'][7]==1?' placeholder="Enter Bing Webmaster Tools verification Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="saveseo_msvalidate" data-dbid="seo_msvalidate" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="seo_yandexverification">Yandex Verification code</label>
          <?=($user['options'][7]==1?'<div class="form-text">Get your Yandex verification in <a target="_blank" href="https://webmaster.yandex.com/sites/add/">Yandex Webmaster Tools</a></div>':'');?>
          <div class="form-row">
            <input class="textinput" id="seo_yandexverification" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" type="text" value="<?=$config['seo_yandexverification'];?>"<?=($user['options'][7]==1?' placeholder="Enter Yandex Site Verification Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="saveseo_yandexverification" data-dbid="seo_yandexverification" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="seo_domainverify">Domain Verify</label>
          <div class="form-row">
            <input class="textinput" id="seo_domainverify" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" type="text" value="<?=$config['seo_domainverify'];?>"<?=($user['options'][7]==1?' placeholder="Enter Domain Verification Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="saveseo_domainverify" data-dbid="seo_domainverify" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="seo_domainverify">Pinterest Verification</label>
          <div class="form-row">
            <input class="textinput" id="seo_pinterestverify" data-dbid="1" data-dbt="config" data-dbc="seo_pinterestverify" type="text" value="<?=$config['seo_pinterestverify'];?>"<?=($user['options'][7]==1?' placeholder="Enter Pinterest Verification Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="saveseo_pinterestverify" data-dbid="seo_pinterestverify" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="seo_ahrefsverify">AHref's Verification code</label>
          <?=($user['options'][7]==1?'<div class="form-text">Get your AHref\'s verification in <a target="_blank" href="https://ahrefs.com/">AHref\'s Tools</a></div>':'');?>
          <div class="form-row">
            <input class="textinput" id="seo_ahrefsverify" data-dbid="1" data-dbt="config" data-dbc="seo_ahrefsverify" type="text" value="<?=$config['seo_ahrefsverify'];?>"<?=($user['options'][7]==1?' placeholder="Enter AHref\'s Verification Code..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="saveseo_ahrefsverify" data-dbid="seo_ahrefsverify" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <hr>
          <legend>Default SEO Fallback Information</legend>
          <div class="form-text">The Fallback Information will be used on pages when the relevant Fields in the Content is empty.</div>
          <label for="seoTitle">SEO Title</label>
          <div class="form-row">
            <div class="input-text" data-el="seoTitle" contenteditable="<?=($user['options'][7]==1?'true':'false');?>" data-placeholder="Enter SEO Title..."><?=$config['seoTitle'];?></div>
            <?=($user['options'][7]==1?'<input class="textinput d-none" id="seoTitle" data-dbid="1" data-dbt="config" data-dbc="seoTitle" type="text" value="'.$config['seoTitle'].'">'.
            '<button class="save" id="saveseoTitle" data-dbid="seoTitle" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label for="seoDescription">SEO Description</label>
          <div class="form-row">
            <div class="input-text" data-el="seoDescription" contenteditable="<?=($user['options'][7]==1?'true':'false');?>" data-placeholder="Enter an SEO Description..."><?=$config['seoDescription'];?></div>
            <?=($user['options'][7]==1?'<input class="textinput d-none" id="seoDescription" data-dbid="1" data-dbt="config" data-dbc="seoDescription" type="text" value="'.$config['seoDescription'].'">'.
            '<button class="save" id="saveseoDescription" data-dbid="seoDescription" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
        </div>
      <?php }
      require'core/layout/footer.php';?>
    </div>
  </section>
</main>
