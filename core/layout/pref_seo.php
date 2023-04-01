<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
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
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Settings</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Helper Information</label>
            <div class="tab1-1 border p-4" data-tabid="tab1-1" role="tabpanel">
              <label id="prefSitemap"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSitemap" data-tooltip="tooltip" aria-label="PermaLink to Preferences Sitemap">&#128279;</a>':'';?>sitemap.xml</label>
              <div class="form-row">
                <div class="input-text col-12">
                  <a target="_blank" href="<?= URL.'sitemap.xml';?>"><?= URL.'sitemap.xml';?></a>
                </div>
              </div>
              <label id="prefHumans"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefHumans" data-tooltip="tooltip" aria-label="PermaLink to Preferences Humans">&#128279;</a>':'';?>humans.txt</label>
              <div class="form-row">
                <div class="input-text col-12">
                  <a id="humans" target="_blank" href="<?= URL.'humans.txt';?>"><?= URL.'humans.txt';?></a>
                </div>
              </div>
              <hr>
              <legend>Webmaster Tools verification</legend>
              <div class="form-row mt-3">
                <label id="prefGoogleVerification" for="ga_verification"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefGoogleVerification" data-tooltip="tooltip" aria-label="PermaLink to Preferences Google Verification Field">&#128279;</a>':'';?>Google&nbsp;Verification&nbsp;code</label>
                <?=($user['options'][7]==1?'<small class="form-text text-right">Get your Google verification code in <a target="_blank" href="https://www.google.com/webmasters/verification/verification?hl=en&tid=alternate&siteUrl=http%3A%2F%2Flocalhost%2Fwordpress/">Google Search Console</a>.</small>':'');?>
              </div>
              <div class="form-row">
                <input class="textinput" id="ga_verification" data-dbid="1" data-dbt="config" data-dbc="ga_verification" type="text" value="<?=$config['ga_verification'];?>"<?=($user['options'][7]==1?' placeholder="Enter Google Site Verification Code..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button class="save" id="savega_verification" data-dbid="ga_verification" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <div class="form-row mt-3">
                <label id="prefGoogleUACode" for="ga_tracking"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefGoogleUACode" data-tooltip="tooltip" aria-label="PermaLink to Preferences Google UA Code Field">&#128279;</a>':'';?>Google&nbsp;UA&nbsp;code</label>
                <?=($user['options'][7]==1?'<small class="form-text text-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</small>':'');?>
              </div>
              <div class="form-row">
                <input class="textinput" id="ga_tracking" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" type="text" value="<?=$config['ga_tracking'];?>"<?=($user['options'][7]==1?' placeholder="Enter Google UA Code..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button class="save" id="savega_tracking" data-dbid="ga_tracking" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <label id="prefGoogleTagManagerCode" for="ga_tagmanager"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefGoogleTagManagerCode" data-tooltip="tooltip" aria-label="PermaLink to Preferences Google Tag Manager Code Field">&#128279;</a>':'';?>Google&nbsp;Tag&nbsp;Manager&nbsp;code</label>
              <div class="form-row">
                <input class="textinput" id="ga_tagmanager" data-dbid="1" data-dbt="config" data-dbc="ga_tagmanager" type="text" value="<?=$config['ga_tagmanager'];?>"<?=($user['options'][7]==1?' placeholder="Enter Google Tag Manager Code..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button class="save" id="savega_tagmanager" data-dbid="ga_tagmanager" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <div class="form-row mt-3">
                <label id="prefBingverification" for="seo_msvalidate"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefBingVerification" data-tooltip="tooltip" aria-label="PermaLink to Preferences Microsoft Validate Field">&#128279;</a>':'';?>Bing&nbsp;Verification&nbsp;code</label>
                <?=($user['options'][7]==1?'<small class="form-text text-right">Get your Bing verification code in <a target="_blank" href="https://www.bing.com/toolbox/webmaster/#/Dashboard/?url=localhost%2Fwordpress">Bing Webmaster Tools</a></small>':'');?>
              </div>
              <div class="form-row">
                <input class="textinput" id="seo_msvalidate" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" type="text" value="<?=$config['seo_msvalidate'];?>"<?=($user['options'][7]==1?' placeholder="Enter Bing Webmaster Tools verification Code..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button class="save" id="saveseo_msvalidate" data-dbid="seo_msvalidate" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <div class="form-row mt-3">
                <label id="prefYandexVerification" for="seo_yandexverification"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefYandexVerification" data-tooltip="tooltip" aria-label="PermaLink to Preferences Yandex Verification Code Field...">&#128279;</a>':'';?>Yandex&nbsp;Verification&nbsp;code</label>
                <?=($user['options'][7]==1?'<small class="form-text text-right">Get your Yandex verification in <a target="_blank" href="https://webmaster.yandex.com/sites/add/">Yandex Webmaster Tools</a></small>':'');?>
              </div>
              <div class="form-row">
                <input class="textinput" id="seo_yandexverification" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" type="text" value="<?=$config['seo_yandexverification'];?>"<?=($user['options'][7]==1?' placeholder="Enter Yandex Site Verification Code..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button class="save" id="saveseo_yandexverification" data-dbid="seo_yandexverification" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <label id="prefDomainVerify" for="seo_domainverify"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefDomainVerify" data-tooltip="tooltip" aria-label="PermaLink to Preferences Domain Verify Field">&#128279;</a>':'';?>Domain Verify</label>
              <div class="form-row">
                <input class="textinput" id="seo_domainverify" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" type="text" value="<?=$config['seo_domainverify'];?>"<?=($user['options'][7]==1?' placeholder="Enter Domain Verification Code..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button class="save" id="saveseo_domainverify" data-dbid="seo_domainverify" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <label id="prefPinterestVerify" for="seo_domainverify"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefPinterestVerify" data-tooltip="tooltip" aria-label="PermaLink to Preferences Pinterest Verify Field">&#128279;</a>':'';?>Pinterest&nbsp;Verification</label>
              <div class="form-row">
                <input class="textinput" id="seo_pinterestverify" data-dbid="1" data-dbt="config" data-dbc="seo_pinterestverify" type="text" value="<?=$config['seo_pinterestverify'];?>"<?=($user['options'][7]==1?' placeholder="Enter Pinterest Verification Code..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button class="save" id="saveseo_pinterestverify" data-dbid="seo_pinterestverify" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <hr>
              <legend>Default SEO Fallback Information</legend>
              <div class="form-text text-muted small">The Fallback Information will be used on pages when the relevant Fields in the Content is empty.</div>
              <label id="prefSEOTitle" for="seoTitle"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSEOTitle" data-tooltip="tooltip" aria-label="PermaLink to Preferences SEO Title Field">&#128279;</a>':'';?>SEO Title</label>
              <div class="form-row">
                <div class="input-text" data-el="seoTitle" contenteditable="<?=($user['options'][7]==1?'true':'false');?>" data-placeholder="Enter SEO Title..."><?=$config['seoTitle'];?></div>
                <?=($user['options'][7]==1?'<input class="textinput d-none" id="seoTitle" data-dbid="1" data-dbt="config" data-dbc="seoTitle" type="text" value="'.$config['seoTitle'].'">'.
                '<button class="save" id="saveseoTitle" data-dbid="seoTitle" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <label id="prefSEODescription" for="seoDescription"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSEODescription" data-tooltip="tooltip" aria-label="PermaLink to Preferences SEO Description Field">&#128279;</a>':'';?>SEO Description</label>
              <div class="form-row">
                <div class="input-text" data-el="seoDescription" contenteditable="<?=($user['options'][7]==1?'true':'false');?>" data-placeholder="Enter an SEO Description..."><?=$config['seoDescription'];?></div>
                <?=($user['options'][7]==1?'<input class="textinput d-none" id="seoDescription" data-dbid="1" data-dbt="config" data-dbc="seoDescription" type="text" value="'.$config['seoDescription'].'">'.
                '<button class="save" id="saveseoDescription" data-dbid="seoDescription" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
<?php /*
              <label for="seoCaption">SEO Caption</label>
              <div class="form-row">
                <input class="textinput" id="seoCaption" data-dbid="1" data-dbt="config" data-dbc="seoCaption" type="text" value="<?=$config['seoCaption'];?>" placeholder="Enter an SEO Caption...">
                <button class="save" id="saveseoCaption" data-dbid="seoCaption" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
              </div>
*/ ?>
            </div>
            <div class="tab1-2 border p-4" data-tabid="tab1-2" role="tabpanel">
              <?php $sh=$db->query("SELECT * FROM `".$prefix."seo` WHERE `contentType`='all' ORDER BY `ti` DESC");
              while($rh=$sh->fetch(PDO::FETCH_ASSOC)){?>
                <details>
                  <summary>
                    <span class="summary-title"><?=$rh['title'];?></span>
                  </summary>
                  <div class="summary-content">
                    <div class="btn-group float-right">
                      <button data-fancybox data-type="ajax" data-src="core/layout/edit_seo.php?id=<?=$rh['id'];?>"><i class="i">edit</i></button>
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
              <?php if($user['options'][7]==1){?>
                <form class="row" target="sp" method="post" action="core/add_seotips.php">
                  <input name="user" type="hidden" value="0">
                  <input name="act" type="hidden" value="add_clippyseo">
                  <input name="at" type="hidden" value="none">
                  <input name="w" type="hidden" value="before">
                  <div class="form-row">
                    <div class="input-text" data-el="ci" contenteditable="true" data-placeholder="Enter SEO Tip Text..."></div>
                    <input class="d-none" type="text" id="ci" name="ci" placeholder="Enter SEO Tip Text...">
                    <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </form>
                <hr>
              <?php }?>
              <div id="seotips">
                <?php $sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`=:cT");
                $sc->execute([':cT'=>'seotips']);
                while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                  <div id="l_<?=$rc['id'];?>">
                    <div class="row">
                      <div class="form-text col"><?=$rc['notes'];?></div>
                      <?=($user['options'][7]==1?'<div class="col-1 text-right"><button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$rc['id'].'`,`seo`);"><i class="i">trash</i></button></div>':'');?>
                    </div>
                    <hr>
                  </div>
                <?php }?>
              </div>
            </div>
          </div>
        <?php }?>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
