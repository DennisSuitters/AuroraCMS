<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('plugin-seo','i-3x');?></div>
          <div>Preferences - SEO</div>
          <div class="content-title-actions">
            <button data-tooltip="tooltip" data-title="Toggle Fullscreen" aria-label"Toggle Fullscreen" onclick="toggleFullscreen();"><?php svg('fullscreen');?></button>
            <button class="saveall" data-tooltip="tooltip" data-title="Save All Edited Fields"><?php echo svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">SEO</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <?php if($user['rank']>899){?>
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Settings</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Helper Information</label>
            <div class="tab1-1 border-top p-3" role="tabpanel">
        <?php }?>
        <label>sitemap.xml</label>
        <div class="form-row">
          <div class="input-text col-12">
            <a target="_blank" href="<?php echo URL.'sitemap.xml';?>"><?php echo URL.'sitemap.xml';?></a>
          </div>
        </div>
        <label>humans.txt</label>
        <div class="form-row">
          <div class="input-text col-12">
            <a id="humans" target="_blank" href="<?php echo URL.'humans.txt';?>"><?php echo URL.'humans.txt';?></a>
          </div>
        </div>
        <hr>
        <legend>SEO Analytics</legend>
        <label for="ga_verification">Google&nbsp;Verification</label>
        <div class="form-row">
          <input class="textinput" id="ga_verification" data-dbid="1" data-dbt="config" data-dbc="ga_verification" type="text" value="<?php echo$config['ga_verification'];?>" placeholder="Enter Google Site Verification Code...">
          <button class="save" id="savega_verification" data-tooltip="tooltip" data-title="Save" data-dbid="ga_verification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="form-row mt-3">
          <label for="ga_tracking">Google&nbsp;UA&nbsp;Code</label>
          <small class="form-text text-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</small>
        </div>
        <div class="form-row">
          <input class="textinput" id="ga_tracking" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" type="text" value="<?php echo$config['ga_tracking'];?>" placeholder="Enter Google UA Code...">
          <button class="save" id="savega_tracking" data-tooltip="tooltip" data-title="Save" data-dbid="ga_tracking" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="seo_msvalidate">Microsoft Validate</label>
        <div class="form-row">
          <input class="textinput" id="seo_msvalidate" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" type="text" value="<?php echo$config['seo_msvalidate'];?>" placeholder="Enter Microsoft Site Validation Code...">
          <button class="save" id="saveseo_msvalidate" data-tooltip="tooltip" data-title="Save" data-dbid="seo_msvalidate" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="seo_yandexverification">Yandex Verification</label>
        <div class="form-row">
          <input class="textinput" id="seo_yandexverification" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" type="text" value="<?php echo$config['seo_yandexverification'];?>" placeholder="Enter Yandex Site Verification Code...">
          <button class="save" id="saveseo_yandexverification" data-tooltip="tooltip" data-title="Save" data-dbid="seo_yandexverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="seo_alexaverification">Alexa Verification</label>
        <div class="form-row">
          <input class="textinput" id="seo_alexaverification" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" type="text" value="<?php echo$config['seo_alexaverification'];?>" placeholder="Enter Alexa Site Verification Code...">
          <button class="save" id="saveseo_alexaverification" data-tooltip="tooltip" data-title="Save" data-dbid="seo_alexaverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="seo_domainverify">Domain Verify</label>
        <div class="form-row">
          <input class="textinput" id="seo_domainverify" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" type="text" value="<?php echo$config['seo_domainverify'];?>" placeholder="Enter Domain Verification Code...">
          <button class="save" id="saveseo_domainverify" data-tooltip="tooltip" data-title="Save" data-dbid="seo_domainverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="seo_domainverify">Pinterest Verify</label>
        <div class="form-row">
          <input class="textinput" id="seo_pinterestverify" data-dbid="1" data-dbt="config" data-dbc="seo_pinterestverify" type="text" value="<?php echo$config['seo_pinterestverify'];?>" placeholder="Enter Pinterest Verification Code...">
          <button class="save" id="saveseo_pinterestverify" data-tooltip="tooltip" data-title="Save" data-dbid="seo_pinterestverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <hr>
        <legend>GEO Location</legend>
        <label for="geo_region">Region</label>
        <div class="form-row">
          <input class="textinput" id="geo_region" data-dbid="1" data-dbt="config" data-dbc="geo_region" type="text" value="<?php echo$config['geo_region'];?>" placeholder="Enter Region...">
          <button class="save" id="savegeo_region" data-tooltip="tooltip" data-title="Save" data-dbid="geo_region" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="geo_placename">Placename</label>
        <div class="form-row">
          <input class="textinput" id="geo_placename" data-dbid="1" data-dbt="config" data-dbc="geo_placename" type="text" value="<?php echo$config['geo_placename'];?>" placeholder="Enter a Placename...">
          <button class="save" id="savegeo_placename" data-tooltip="tooltip" data-title="Save" data-dbid="geo_placename" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="geo_position">Position</label>
        <div class="form-row">
          <input class="textinput" id="geo_position" data-dbid="1" data-dbt="config" data-dbc="geo_position" type="text" value="<?php echo$config['geo_position'];?>" placeholder="Enter a Position...">
          <button class="save" id="savegeo_position" data-tooltip="tooltip" data-title="Save" data-dbid="geo_position" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <?php if($user['rank']>899){?>
        </div>
        <div class="tab1-2 border-top p-3" role="tabpanel">
          <?php $sh=$db->query("SELECT * FROM `".$prefix."seo` ORDER BY `ti` DESC");
          while($rh=$sh->fetch(PDO::FETCH_ASSOC)){?>
            <details>
              <summary>
                <span class="summary-title"><?php echo$rh['title'];?></span>
              </summary>
              <div class="summary-content">
                <div class="btn-group float-right">
                  <button data-fancybox data-type="ajax" data-src="core/layout/edit_seo.php?id=<?php echo$rh['id'];?>"><?php svg('edit');?></button>
                </div>
                <h3><?php echo$rh['title'];?></h3>
                <div>
                  <small>
                    Type: <?php echo$rh['type'];?><br>
                    Last Edited: <?php echo date($config['dateFormat'],$rh['ti']);?>
                  </small>
                </div>
                <div class="p-2">
                  <?php echo strip_tags(substr($rh['notes'],0,200));?>
                </div>
              </div>
            </details>
          <?php }?>
        </div>
      </div>
    <?php }?>
    <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
