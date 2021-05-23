<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
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
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('plugin-seo','i-3x');?></div>
          <div>Preferences - SEO</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">SEO</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <?php if($user['rank']>899){?>
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Settings</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Helper Information</label>
            <div class="tab1-1 border-top p-3" data-tabid="tab1-1" role="tabpanel">
        <?php }?>
        <label id="prefSitemap"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSitemap" aria-label="PermaLink to Preferences Sitemap">&#128279;</a>':'';?>sitemap.xml</label>
        <div class="form-row">
          <div class="input-text col-12">
            <a target="_blank" href="<?= URL.'sitemap.xml';?>"><?= URL.'sitemap.xml';?></a>
          </div>
        </div>
        <label id="prefHumans"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefHumans" aria-label="PermaLink to Preferences Humans">&#128279;</a>':'';?>humans.txt</label>
        <div class="form-row">
          <div class="input-text col-12">
            <a id="humans" target="_blank" href="<?= URL.'humans.txt';?>"><?= URL.'humans.txt';?></a>
          </div>
        </div>
        <hr>
        <legend>SEO Analytics</legend>
        <label id="prefGoogleVerification" for="ga_verification"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefGoogleVerification" aria-label="PermaLink to Preferences Google Verification Field">&#128279;</a>':'';?>Google&nbsp;Verification</label>
        <div class="form-row">
          <input class="textinput" id="ga_verification" data-dbid="1" data-dbt="config" data-dbc="ga_verification" type="text" value="<?=$config['ga_verification'];?>" placeholder="Enter Google Site Verification Code...">
          <button class="save" id="savega_verification" data-tooltip="tooltip" data-dbid="ga_verification" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div class="form-row mt-3">
          <label id="prefGoogleUACode" for="ga_tracking"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefGoogleUACode" aria-label="PermaLink to Preferences Google UA Code Field">&#128279;</a>':'';?>Google&nbsp;UA&nbsp;Code</label>
          <small class="form-text text-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</small>
        </div>
        <div class="form-row">
          <input class="textinput" id="ga_tracking" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" type="text" value="<?=$config['ga_tracking'];?>" placeholder="Enter Google UA Code...">
          <button class="save" id="savega_tracking" data-tooltip="tooltip" data-dbid="ga_tracking" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="prefMicrosoftValidate" for="seo_msvalidate"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefMicrosoftValidate" aria-label="PermaLink to Preferences Microsoft Validate Field">&#128279;</a>':'';?>Microsoft Validate</label>
        <div class="form-row">
          <input class="textinput" id="seo_msvalidate" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" type="text" value="<?=$config['seo_msvalidate'];?>" placeholder="Enter Microsoft Site Validation Code...">
          <button class="save" id="saveseo_msvalidate" data-tooltip="tooltip" data-dbid="seo_msvalidate" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="prefYandexVerification" for="seo_yandexverification"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefYandexVerification" aria-label="PermaLink to Preferences Yandex Verification Field">&#128279;</a>':'';?>Yandex Verification</label>
        <div class="form-row">
          <input class="textinput" id="seo_yandexverification" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" type="text" value="<?=$config['seo_yandexverification'];?>" placeholder="Enter Yandex Site Verification Code...">
          <button class="save" id="saveseo_yandexverification" data-tooltip="tooltip" data-dbid="seo_yandexverification" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="prefAlexaVerification" for="seo_alexaverification"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefAlexaVerification" aria-label="PermaLink to Preferences Alexa Verification Field">&#128279;</a>':'';?>Alexa Verification</label>
        <div class="form-row">
          <input class="textinput" id="seo_alexaverification" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" type="text" value="<?=$config['seo_alexaverification'];?>" placeholder="Enter Alexa Site Verification Code...">
          <button class="save" id="saveseo_alexaverification" data-tooltip="tooltip" data-dbid="seo_alexaverification" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="prefDomainVerify" for="seo_domainverify"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefDomainVerify" aria-label="PermaLink to Preferences Domain Verify Field">&#128279;</a>':'';?>Domain Verify</label>
        <div class="form-row">
          <input class="textinput" id="seo_domainverify" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" type="text" value="<?=$config['seo_domainverify'];?>" placeholder="Enter Domain Verification Code...">
          <button class="save" id="saveseo_domainverify" data-tooltip="tooltip" data-dbid="seo_domainverify" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="prefPinterestVerify" for="seo_domainverify"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefPinterestVerify" aria-label="PermaLink to Preferences Pinterest Verify Field">&#128279;</a>':'';?>Pinterest Verify</label>
        <div class="form-row">
          <input class="textinput" id="seo_pinterestverify" data-dbid="1" data-dbt="config" data-dbc="seo_pinterestverify" type="text" value="<?=$config['seo_pinterestverify'];?>" placeholder="Enter Pinterest Verification Code...">
          <button class="save" id="saveseo_pinterestverify" data-tooltip="tooltip" data-dbid="seo_pinterestverify" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <hr>
        <legend>Default SEO Fallback Information</legend>
        <div class="form-text text-muted small">The Fallback Information will be used on pages when the relevant Fields in the Content is empty.</div>
        <label id="prefSEOTitle" for="seoTitle"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSEOTitle" aria-label="PermaLink to Preferences SEO Title Field">&#128279;</a>':'';?>SEO Title</label>
        <div class="form-row">
          <input class="textinput" id="seoTitle" data-dbid="1" data-dbt="config" data-dbc="seoTitle" type="text" value="<?=$config['seoTitle'];?>" placeholder="Enter SEO Title...">
          <button class="save" id="saveseoTitle" data-tooltip="tooltip" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="prefSEODescription" for="seoDescription"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSEODescription" aria-label="PermaLink to Preferences SEO Description Field">&#128279;</a>':'';?>SEO Description</label>
        <div class="form-row">
          <input class="textinput" id="seoDescription" data-dbid="1" data-dbt="config" data-dbc="seoDescription" type="text" value="<?=$config['seoDescription'];?>" placeholder="Enter an SEO Description...">
          <button class="save" id="saveseoDescription" data-tooltip="tooltip" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
<?php /*
        <label for="seoCaption">SEO Caption</label>
        <div class="form-row">
          <input class="textinput" id="seoCaption" data-dbid="1" data-dbt="config" data-dbc="seoCaption" type="text" value="<?=$config['seoCaption'];?>" placeholder="Enter an SEO Caption...">
          <button class="save" id="saveseoCaption" data-tooltip="tooltip" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
*/ ?>
        <?php if($user['rank']>899){?>
        </div>
        <div class="tab1-2 border-top p-3" data-tabid="tab1-2" role="tabpanel">
          <?php $sh=$db->query("SELECT * FROM `".$prefix."seo` WHERE `contentType`='all' ORDER BY `ti` DESC");
          while($rh=$sh->fetch(PDO::FETCH_ASSOC)){?>
            <details>
              <summary>
                <span class="summary-title"><?=$rh['title'];?></span>
              </summary>
              <div class="summary-content">
                <div class="btn-group float-right">
                  <button data-fancybox data-type="ajax" data-src="core/layout/edit_seo.php?id=<?=$rh['id'];?>"><?= svg2('edit');?></button>
                </div>
                <h3><?=$rh['title'];?></h3>
                <div>
                  <small>
                    Type: <?=$rh['type'];?><br>
                    Last Edited: <?= date($config['dateFormat'],$rh['ti']);?>
                  </small>
                </div>
                <div class="p-2">
                  <?= strip_tags(substr($rh['notes'],0,200));?>
                </div>
              </div>
            </details>
          <?php }?>
          <legend>SEO Tips</legend>
          <form class="row" target="sp" method="post" action="core/add_seotips.php">
            <input name="user" type="hidden" value="0">
            <input name="act" type="hidden" value="add_clippyseo">
            <input name="at" type="hidden" value="none">
            <input name="w" type="hidden" value="before">
            <div class="form-row">
              <input id="ci" name="ci" placeholder="Enter SEO Tip Text...">
              <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
            </div>
          </form>
          <hr>
          <div id="seotips">
<?php $sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`=:cT");
$sc->execute([':cT'=>'seotips']);
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?=$rc['id'];?>">
              <div class="row">
                <div class="form-text col-11"><?=$rc['notes'];?></div>
                <div class="col-1 text-right">
                  <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?=$rc['id'];?>`,'seo');"><?= svg2('trash');?></button>
                </div>
              </div>
              <hr>
            </div>
<?php }?>
          </div>
        </div>
      </div>
<?php }
require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
