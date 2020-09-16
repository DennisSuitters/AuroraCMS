<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Remove SEO Meta/Title/Caption/Description.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.17 Add Administration Tabs and editable SEO Helper Info.
 * @changes    v0.0.18 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 * @changes    v0.0.19 Add Save All button.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">SEO</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a href="#" class="btn btn-ghost-normal saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields"><?php echo svg('save');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <?php if($user['rank']>899){?>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-seo-settings" aria-controls="tab-seo-settings" role="tab" data-toggle="tab">Settings</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-seo-helper" aria-controls="tab-seo-helper" role="tab" data-toggle="tab">Helper Information</a></li>
          </ul>
          <div class="tab-content">
            <div id="tab-seo-settings" class="tab-pane active" role="tabpanel">
        <?php }?>
              <div class="form-group">
                <label>sitemap.xml</label>
                <div class="input-group">
                  <div class="input-group-text col">
                    <a target="_blank" href="<?php echo URL.'sitemap.xml';?>"><?php echo URL.'sitemap.xml';?></a>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>humans.txt</label>
                <div class="input-group">
                  <div class="input-group-text col">
                    <a target="_blank" id="humans" href="<?php echo URL.'humans.txt';?>"><?php echo URL.'humans.txt';?></a>
                  </div>
                </div>
              </div>
              <hr>
              <legend>SEO Analytics</legend>
              <div class="form-group">
                <label for="ga_verification">Google Verification</label>
                <div class="input-group">
                  <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="Enter Google Site Verification Code...">
                  <div class="input-group-append">
                    <button id="savega_verification" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="ga_verification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="ga_tracking">Google UA Code</label>
                <div class="form-text small text-muted float-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</div>
                <div class="input-group">
                  <input type="text" id="ga_tracking" class="form-control textinput" value="<?php echo$config['ga_tracking'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" placeholder="Enter Google UA Code...">
                  <div class="input-group-append">
                    <button id="savega_tracking" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="ga_tracking" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="seo_msvalidate">Microsoft Validate</label>
                <div class="input-group">
                  <input type="text" id="seo_msvalidate" class="form-control textinput" value="<?php echo$config['seo_msvalidate'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" placeholder="Enter Microsoft Site Validation Code...">
                  <div class="input-group-append">
                    <button id="saveseo_msvalidate" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seo_msvalidate" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="seo_yandexverification">Yandex Verification</label>
                <div class="input-group">
                  <input type="text" id="seo_yandexverification" class="form-control textinput" value="<?php echo$config['seo_yandexverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" placeholder="Enter Yandex Site Verification Code...">
                  <div class="input-group-append">
                    <button id="saveseo_yandexverification" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seo_yandexverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="seo_alexaverification">Alexa Verification</label>
                <div class="input-group">
                  <input type="text" id="seo_alexaverification" class="form-control textinput" value="<?php echo$config['seo_alexaverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" placeholder="Enter Alexa Site Verification Code...">
                  <div class="input-group-append">
                    <button id="saveseo_alexaverification" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seo_alexaverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="seo_domainverify">Domain Verify</label>
                <div class="input-group">
                  <input type="text" id="seo_domainverify" class="form-control textinput" value="<?php echo$config['seo_domainverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" placeholder="Enter Domain Verification Code...">
                  <div class="input-group-append">
                    <button id="saveseo_domainverify" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seo_domainverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="seo_domainverify">Pinterest Verify</label>
                <div class="input-group">
                  <input type="text" id="seo_pinterestverify" class="form-control textinput" value="<?php echo$config['seo_pinterestverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_pinterestverify" placeholder="Enter Pinterest Verification Code...">
                  <div class="input-group-append">
                    <button id="saveseo_pinterestverify" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seo_pinterestverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <hr>
              <legend>GEO Location</legend>
              <div class="form-group">
                <label for="geo_region">Region</label>
                <div class="input-group">
                  <input type="text" id="geo_region" class="form-control textinput" value="<?php echo$config['geo_region'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_region" placeholder="Enter Region...">
                  <div class="input-group-append">
                    <button id="savegeo_region" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="geo_region" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="geo_placename">Placename</label>
                <div class="input-group">
                  <input type="text" id="geo_placename" class="form-control textinput" value="<?php echo$config['geo_placename'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_placename" placeholder="Enter a Placename...">
                  <div class="input-group-append">
                    <button id="savegeo_placename" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="geo_placename" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="geo_position">Position</label>
                <div class="input-group">
                  <input type="text" id="geo_position" class="form-control textinput" value="<?php echo$config['geo_position'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_position" placeholder="Enter a Position...">
                  <div class="input-group-append">
                    <button id="savegeo_position" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="geo_position" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
              </div>
            <?php if($user['rank']>899){?>
            </div>
            <div id="tab-seo-helper" class="tab-pane" role="tabpanel">
              <?php $sh=$db->query("SELECT * FROM `".$prefix."seo` ORDER BY `ti` DESC");
              while($rh=$sh->fetch(PDO::FETCH_ASSOC)){?>
                <details class="border">
                  <summary>
                    <span class="summary-title"><?php echo$rh['title'];?></span>
                    <div class="summary-chevron-up">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                  </summary>
                  <div class="summary-content">
                    <div class="btn-group float-right">
                      <button class="btn btn-secondary editseo" data-dbid="<?php echo$rh['id'];?>"><?php svg('edit');?></button>
                    </div>
                    <h3><?php echo$rh['title'];?></h3>
                    <div>
                      <small>
                        Type: <?php echo$rh['type'];?><br>
                        Last Edited: <?php echo date($config['dateFormat'],$rh['ti']);?>
                      </small>
                    </div>
                    <div class="form-control p-2">
                      <?php echo strip_tags(substr($rh['notes'],0,200));?>
                    </div>
                  </div>
                  <div class="summary-chevron-down">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                  </div>
                </details>
              <?php }?>
            </div>
          </div>
        <?php }?>
      </div>
    </div>
  </div>
</main>
