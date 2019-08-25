<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
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
        <div class="help-block small text-muted text-right">Options for Meta Robots: <span data-tooltip="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="tooltip" title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="tooltip" title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="tooltip" title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
        <div class="form-group row">
          <label for="metaRobots" class="col-form-label col-sm-2">Meta Robots</label>
          <div class="input-group col-sm-10">
            <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$config['metaRobots'];?>" data-dbid="1" data-dbt="config" data-dbc="metaRobots" placeholder="Enter Meta Robots Options...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-form-label col-sm-2"></div>
          <div class="input-group col-sm-10">
            <div class="card col-12 bg-white">
              <div class="card-body">
                <div id="google-title" data-tooltip="tooltip" data-placement="left" title="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser.  This text is used as the default if fields are empty in the Pages or Content areas.">
                  <?php echo$config['seoTitle'];?>
                </div>
                <div id="google-link">
                  <?php echo URL;?>
                </div>
                <div id="google-description" data-tooltip="tooltip" data-placement="left" title="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. This text is used as the default if fields are empty in the Pages or Content areas.">
                  <?php echo$config['seoDescription'];?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="help-block small text-right">The recommended character count for Title's is 70.</div>
        <div class="form-group row">
          <label for="seoTitle" class="col-form-label col-sm-2">Meta Title</label>
          <div class="input-group col-sm-10">
<?php $cntc=70-strlen($config['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoTitlecnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></div>
            <div class="input-group-append">
              <button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="Remove Stop Words" aria-label="Remove Stop Words"><?php svg('magic');?></button>
            </div>
            <?php if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoTitle']);
              echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip"tooltip" title="Suggestions"><button class="btn btn-secondary suggestion" data-dbgid="seoTitle" aria-label="Suggestions">'.svg2('lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="Enter a Meta Title...">
            <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoTitle" role="button" aria-label="Add Suggestions">'.svg2('idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right">The recommended character count for Captions is 100.</div>
        <div class="form-group row">
          <label for="seoCaption" class="col-form-label col-sm-2">Meta Caption</label>
          <div class="input-group col-sm-10">
<?php $cntc=160-strlen($config['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoCaptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo $cnt;?></div>
            <?php if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoCaption']);
              echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="Suggestions"><button class="btn btn-default suggestion" data-dbgid="seoCaption" aria-label="Suggestions">'.svg2('lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="Enter a Meta Caption...">
            <?php echo$user['rank']>899?'<div class="input-group-prepend" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoCaption" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right">The recommended character count for Descriptions is 160.</div>
        <div class="form-group row">
          <label for="seoDescription" class="col-form-label col-sm-2">Meta Description</label>
          <div class="input-group col-sm-10">
<?php $cntc=160-strlen($config['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoDescriptioncnt" class="input-group-text text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></div>
            <?php if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoDescription']);
              echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Suggestions"><button class="btn btn-secondary suggestion" data-dbgid="seoDescription" aria-label="Suggestions">'.svg2('lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="Enter a Meta Description...">
            <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoDescription" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seoKeywords" class="control-label col-sm-2">SEO Keywords</label>
          <div class="input-group col-sm-10">
<?php       if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoKeywords']);
              echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="Suggestions"><button class="btn btn-secondary suggestion" data-dbgid="seoKeywords" aria-label="Suggestions">'.svg2('lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="Enter Keywords...">
            <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoKeywords" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <hr>
        <h4>SEO Analytics</h4>
        <div class="form-group row">
          <label for="ga_verification" class="col-form-label col-sm-2">Google Verification</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="Enter Google Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savega_verification" class="btn btn-secondary save" data-dbid="ga_verification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</div>
        <div class="form-group row">
          <label for="ga_tracking" class="col-form-label col-sm-2">Google Tracking Code (UA)</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ga_tracking" class="form-control textinput" value="<?php echo$config['ga_tracking'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" placeholder="Enter Google UA Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savega_tracking" class="btn btn-secondary save" data-dbid="ga_tracking" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_msvalidate" class="col-form-label col-sm-2">Microsoft Validate</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_msvalidate" class="form-control textinput" value="<?php echo$config['seo_msvalidate'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" placeholder="Enter Microsoft Site Validation Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_msvalidate" class="btn btn-secondary save" data-dbid="seo_msvalidate" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_yandexverification" class="col-form-label col-sm-2">Yandex Verification</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_yandexverification" class="form-control textinput" value="<?php echo$config['seo_yandexverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" placeholder="Enter Yandex Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_yandexverification" class="btn btn-secondary save" data-dbid="seo_yandexverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_alexaverification" class="col-form-label col-sm-2">Alexa Verification</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_alexaverification" class="form-control textinput" value="<?php echo$config['seo_alexaverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" placeholder="Enter Alexa Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_alexaverification" class="btn btn-secondary save" data-dbid="seo_alexaverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_domainverify" class="col-form-label col-sm-2">Domain Verify</label>
          <div class="input-group col-sm-10">
            <input type="text" id="seo_domainverify" class="form-control textinput" value="<?php echo$config['seo_domainverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" placeholder="Enter Domain Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_domainverify" class="btn btn-secondary save" data-dbid="seo_domainverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <hr>
        <h4>GEO Location</h4>
        <div class="form-group row">
          <label for="geo_region" class="col-form-label col-sm-2">Region</label>
          <div class="input-group col-sm-10">
            <input type="text" id="geo_region" class="form-control textinput" value="<?php echo$config['geo_region'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_region" placeholder="Enter Region...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savegeo_region" class="btn btn-secondary save" data-dbid="geo_region" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_placename" class="col-form-label col-sm-2">Placename</label>
          <div class="input-group col-sm-10">
            <input type="text" id="geo_placename" class="form-control textinput" value="<?php echo$config['geo_placename'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_placename" placeholder="Enter a Placename...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savegeo_placename" class="btn btn-secondary save" data-dbid="geo_placename" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_position" class="col-form-label col-sm-2">Position</label>
          <div class="input-group col-sm-10">
            <input type="text" id="geo_position" class="form-control textinput" value="<?php echo$config['geo_position'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_position" placeholder="Enter a Position...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savegeo_position" class="btn btn-secondary save" data-dbid="geo_position" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
