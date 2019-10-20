<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Remove SEO Meta/Title/Caption/Description.
 * @changes    v0.0.4 Fix Tooltips.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">SEO</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label class="col-form-label col-sm-2">sitemap.xml</label>
          <div class="input-group col-sm-10">
            <div class="input-group-text col">
              <a target="_blank" href="<?php echo URL.'sitemap.xml';?>"><?php echo URL.'sitemap.xml';?></a>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">humans.txt</label>
          <div class="input-group col-sm-10">
            <div class="input-group-text col">
              <a target="_blank" id="humans" href="<?php echo URL.'humans.txt';?>"><?php echo URL.'humans.txt';?></a>
            </div>
          </div>
        </div>
        <hr>
        <h4>SEO Analytics</h4>
        <div class="form-group row">
          <label for="ga_verification" class="col-form-label col-sm-2">Google Verification</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="Enter Google Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savega_verification" class="btn btn-secondary save" data-dbid="ga_verification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</div>
        <div class="form-group row">
          <label for="ga_tracking" class="col-form-label col-sm-2">Google UA Code</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ga_tracking" class="form-control textinput" value="<?php echo$config['ga_tracking'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" placeholder="Enter Google UA Code...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savega_tracking" class="btn btn-secondary save" data-dbid="ga_tracking" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_msvalidate" class="col-form-label col-sm-2">Microsoft Validate</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_msvalidate" class="form-control textinput" value="<?php echo$config['seo_msvalidate'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" placeholder="Enter Microsoft Site Validation Code...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseo_msvalidate" class="btn btn-secondary save" data-dbid="seo_msvalidate" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_yandexverification" class="col-form-label col-sm-2">Yandex Verification</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_yandexverification" class="form-control textinput" value="<?php echo$config['seo_yandexverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" placeholder="Enter Yandex Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseo_yandexverification" class="btn btn-secondary save" data-dbid="seo_yandexverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_alexaverification" class="col-form-label col-sm-2">Alexa Verification</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_alexaverification" class="form-control textinput" value="<?php echo$config['seo_alexaverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" placeholder="Enter Alexa Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseo_alexaverification" class="btn btn-secondary save" data-dbid="seo_alexaverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_domainverify" class="col-form-label col-sm-2">Domain Verify</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_domainverify" class="form-control textinput" value="<?php echo$config['seo_domainverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" placeholder="Enter Domain Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseo_domainverify" class="btn btn-secondary save" data-dbid="seo_domainverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_domainverify" class="col-form-label col-sm-2">Pinterest Verify</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_pinterestverify" class="form-control textinput" value="<?php echo$config['seo_pinterestverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_pinterestverify" placeholder="Enter Pinterest Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseo_pinterestverify" class="btn btn-secondary save" data-dbid="seo_pinterestverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <hr>
        <h4>GEO Location</h4>
        <div class="form-group row">
          <label for="geo_region" class="col-form-label col-sm-2">Region</label>
          <div class="input-group col-sm-10">
            <input type="text" id="geo_region" class="form-control textinput" value="<?php echo$config['geo_region'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_region" placeholder="Enter Region...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savegeo_region" class="btn btn-secondary save" data-dbid="geo_region" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_placename" class="col-form-label col-sm-2">Placename</label>
          <div class="input-group col-sm-10">
            <input type="text" id="geo_placename" class="form-control textinput" value="<?php echo$config['geo_placename'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_placename" placeholder="Enter a Placename...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savegeo_placename" class="btn btn-secondary save" data-dbid="geo_placename" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_position" class="col-form-label col-sm-2">Position</label>
          <div class="input-group col-sm-10">
            <input type="text" id="geo_position" class="form-control textinput" value="<?php echo$config['geo_position'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_position" placeholder="Enter a Position...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savegeo_position" class="btn btn-secondary save" data-dbid="geo_position" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
