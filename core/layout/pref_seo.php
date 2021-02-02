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
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
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
        <label id="prefSitemap"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSitemap" aria-label="PermaLink to Preferences Sitemap">&#128279;</a>':'';?>sitemap.xml</label>
        <div class="form-row">
          <div class="input-text col-12">
            <a target="_blank" href="<?php echo URL.'sitemap.xml';?>"><?php echo URL.'sitemap.xml';?></a>
          </div>
        </div>
        <label id="prefHumans"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefHumans" aria-label="PermaLink to Preferences Humans">&#128279;</a>':'';?>humans.txt</label>
        <div class="form-row">
          <div class="input-text col-12">
            <a id="humans" target="_blank" href="<?php echo URL.'humans.txt';?>"><?php echo URL.'humans.txt';?></a>
          </div>
        </div>
        <hr>
        <legend>SEO Analytics</legend>
        <label id="prefGoogleVerification" for="ga_verification"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefGoogleVerification" aria-label="PermaLink to Preferences Google Verification Field">&#128279;</a>':'';?>Google&nbsp;Verification</label>
        <div class="form-row">
          <input class="textinput" id="ga_verification" data-dbid="1" data-dbt="config" data-dbc="ga_verification" type="text" value="<?php echo$config['ga_verification'];?>" placeholder="Enter Google Site Verification Code...">
          <button class="save" id="savega_verification" data-tooltip="tooltip" data-dbid="ga_verification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="form-row mt-3">
          <label id="prefGoogleUACode" for="ga_tracking"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefGoogleUACode" aria-label="PermaLink to Preferences Google UA Code Field">&#128279;</a>':'';?>Google&nbsp;UA&nbsp;Code</label>
          <small class="form-text text-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</small>
        </div>
        <div class="form-row">
          <input class="textinput" id="ga_tracking" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" type="text" value="<?php echo$config['ga_tracking'];?>" placeholder="Enter Google UA Code...">
          <button class="save" id="savega_tracking" data-tooltip="tooltip" data-dbid="ga_tracking" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label id="prefMicrosoftValidate" for="seo_msvalidate"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefMicrosoftValidate" aria-label="PermaLink to Preferences Microsoft Validate Field">&#128279;</a>':'';?>Microsoft Validate</label>
        <div class="form-row">
          <input class="textinput" id="seo_msvalidate" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" type="text" value="<?php echo$config['seo_msvalidate'];?>" placeholder="Enter Microsoft Site Validation Code...">
          <button class="save" id="saveseo_msvalidate" data-tooltip="tooltip" data-dbid="seo_msvalidate" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label id="prefYandexVerification" for="seo_yandexverification"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefYandexVerification" aria-label="PermaLink to Preferences Yandex Verification Field">&#128279;</a>':'';?>Yandex Verification</label>
        <div class="form-row">
          <input class="textinput" id="seo_yandexverification" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" type="text" value="<?php echo$config['seo_yandexverification'];?>" placeholder="Enter Yandex Site Verification Code...">
          <button class="save" id="saveseo_yandexverification" data-tooltip="tooltip" data-dbid="seo_yandexverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label id="prefAlexaVerification" for="seo_alexaverification"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefAlexaVerification" aria-label="PermaLink to Preferences Alexa Verification Field">&#128279;</a>':'';?>Alexa Verification</label>
        <div class="form-row">
          <input class="textinput" id="seo_alexaverification" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" type="text" value="<?php echo$config['seo_alexaverification'];?>" placeholder="Enter Alexa Site Verification Code...">
          <button class="save" id="saveseo_alexaverification" data-tooltip="tooltip" data-dbid="seo_alexaverification" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label id="prefDomainVerify" for="seo_domainverify"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefDomainVerify" aria-label="PermaLink to Preferences Domain Verify Field">&#128279;</a>':'';?>Domain Verify</label>
        <div class="form-row">
          <input class="textinput" id="seo_domainverify" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" type="text" value="<?php echo$config['seo_domainverify'];?>" placeholder="Enter Domain Verification Code...">
          <button class="save" id="saveseo_domainverify" data-tooltip="tooltip" data-dbid="seo_domainverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label id="prefPinterestVerify" for="seo_domainverify"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefPinterestVerify" aria-label="PermaLink to Preferences Pinterest Verify Field">&#128279;</a>':'';?>Pinterest Verify</label>
        <div class="form-row">
          <input class="textinput" id="seo_pinterestverify" data-dbid="1" data-dbt="config" data-dbc="seo_pinterestverify" type="text" value="<?php echo$config['seo_pinterestverify'];?>" placeholder="Enter Pinterest Verification Code...">
          <button class="save" id="saveseo_pinterestverify" data-tooltip="tooltip" data-dbid="seo_pinterestverify" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <hr>
        <legend>Default SEO Fallback Information</legend>
        <div class="form-text text-muted small">The Fallback Information will be used on pages when the relevant Fields in the Content is empty.</div>
        <label id="prefSEOTitle" for="seoTitle"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSEOTitle" aria-label="PermaLink to Preferences SEO Title Field">&#128279;</a>':'';?>SEO Title</label>
        <div class="form-row">
          <input class="textinput" id="seoTitle" data-dbid="1" data-dbt="config" data-dbc="seoTitle" type="text" value="<?php echo$config['seoTitle'];?>" placeholder="Enter SEO Title...">
          <button class="save" id="saveseoTitle" data-tooltip="tooltip" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label id="prefSEODescription" for="seoDescription"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/seo#prefSEODescription" aria-label="PermaLink to Preferences SEO Description Field">&#128279;</a>':'';?>SEO Description</label>
        <div class="form-row">
          <input class="textinput" id="seoDescription" data-dbid="1" data-dbt="config" data-dbc="seoDescription" type="text" value="<?php echo$config['seoDescription'];?>" placeholder="Enter an SEO Description...">
          <button class="save" id="saveseoDescription" data-tooltip="tooltip" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
<?php /*
        <label for="seoCaption">SEO Caption</label>
        <div class="form-row">
          <input class="textinput" id="seoCaption" data-dbid="1" data-dbt="config" data-dbc="seoCaption" type="text" value="<?php echo$config['seoCaption'];?>" placeholder="Enter an SEO Caption...">
          <button class="save" id="saveseoCaption" data-tooltip="tooltip" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
*/ ?>
        <?php if($user['rank']>899){?>
        </div>
        <div class="tab1-2 border-top p-3" data-tabid="tab1-2" role="tabpanel">
          <?php $sh=$db->query("SELECT * FROM `".$prefix."seo` WHERE `contentType`='all' ORDER BY `ti` DESC");
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
          <legend>Assitant Random SEO Tips</legend>
          <form class="row" target="sp" method="post" action="core/add_clippyseo.php">
            <input name="user" type="hidden" value="0">
            <input name="act" type="hidden" value="add_clippyseo">
            <div class="row">
              <div class="col-12 col-md-6">
                <label for="at">Animation Type </label>
                <div class="form-row">
                  <select id="at" name="at">
                    <option value="none">No Animation</option>
                    <option value="Alert">Alert</option>
                    <option value="CheckingSomething">Checking Something</option>
                    <option value="EmptyTrash">Empty Trash</option>
                    <option value="Explain">Explain</option>
                    <option value="GestureDown">Gesture Down</option>
                    <option value="GestureLeft">Gesture Left</option>
                    <option value="GestureRight">Gesture Right</option>
                    <option value="GestureUp">Gesture Up</option>
                    <option value="GetArtsy">Get Artsy</option>
                    <option value="GetAttention">Get Attention</option>
                    <option value="GetTechy">Get Techy</option>
                    <option value="GetWizardly">Get Wizardly</option>
                    <option value="GoodBye">Goodbye</option>
                    <option value="Greeting">Greeting</option>
                    <option value="Hearing_1">Hearing</option>
                    <option value="Hide">Hide</option>
                    <option value="Idle_1">Idle</option>
                    <option value="IdleAtom">Idle Atom</option>
                    <option value="IdleEyeBrowRaise">Idle Eyebrow Raise</option>
                    <option value="IdleFingerTap">Idle Finger Tap</option>
                    <option value="IdleHeadScratch">Idle Head Scratch</option>
                    <option value="IdleRopePile">Idle Rope Pile</option>
                    <option value="IdleSideToSide">Idle Side To Side</option>
                    <option value="IdleSnooze">Idle Snooze</option>
                    <option value="LookDown">Look Down</option>
                    <option value="LookDownLeft">Look Down Left</option>
                    <option value="LookDownRight">Look Down Right</option>
                    <option value="LookLeft">Look Left</option>
                    <option value="LookRight">Look Right</option>
                    <option value="LookUp">Look Up</option>
                    <option value="LookUpLeft">Look Up Left</option>
                    <option value="LookUpRight">Look Up Right</option>
                    <option value="Print">Print</option>
                    <option value="Processing">Processing</option>
                    <option value="RestPose">Rest Pose</option>
                    <option value="Save">Save</option>
                    <option value="Searching">Searching</option>
                    <option value="SendMail">Send Mail</option>
                    <option value="Show">Show</option>
                    <option value="Thinking">Thinking</option>
                    <option value="Wave">Wave</option>
                    <option value="Writing">Writing</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label for="when">Before or After</label>
                <div class="form-row">
                  <select id="when" name="w">
                    <option value="before">Before</option>
                    <option value="after">After</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-row">
                  <input id="ci" name="ci" placeholder="Enter SEO Tip Text...">
                  <button class="add" data-tooltip="tooltip" aria-label="Add"><?php svg('add');?></button>
                </div>
              </div>
            </div>
          </form>
          <hr>
          <div id="clippyseo">
<?php $sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`=:cT");
$sc->execute([':cT'=>'clippy']);
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rc['id'];?>">
              <div class="row">
                <div class="col-12 col-md-6">
                  <label for="at<?php echo$rc['id'];?>">Animation Type </label>
                  <div class="form-row">
                    <select id="at<?php echo$rc['id'];?>" onchange="update(`<?php echo$rc['id'];?>`,`seo`,`type`,$(this).val());">
                      <option value="none"<?php echo($rc['type']=='none'?' selected':'');?>>No Animation</option>
                      <option value="Alert"<?php echo($rc['type']=='Alert'?' selected':'');?>>Alert</option>
                      <option value="CheckingSomething"<?php echo($rc['type']=='CheckingSomething'?' selected':'');?>>Checking Something</option>
                      <option value="EmptyTrash"<?php echo($rc['type']=='EmptyTrash'?' selected':'');?>>Empty Trash</option>
                      <option value="Explain"<?php echo($rc['type']=='Explain'?' selected':'');?>>Explain</option>
                      <option value="GestureDown"<?php echo($rc['type']=='GestureDown'?' selected':'');?>>Gesture Down</option>
                      <option value="GestureLeft"<?php echo($rc['type']=='GestureLeft'?' selected':'');?>>Gesture Left</option>
                      <option value="GestureRight"<?php echo($rc['type']=='GestureRight'?' selected':'');?>>Gesture Right</option>
                      <option value="GestureUp"<?php echo($rc['type']=='GestureUp'?' selected':'');?>>Gesture Up</option>
                      <option value="GetArtsy"<?php echo($rc['type']=='GetArtsy'?' selected':'');?>>Get Artsy</option>
                      <option value="GetAttention"<?php echo($rc['type']=='GetAttention'?' selected':'');?>>Get Attention</option>
                      <option value="GetTechy"<?php echo($rc['type']=='GetTechy'?' selected':'');?>>Get Techy</option>
                      <option value="GetWizardly"<?php echo($rc['type']=='GetWizardly'?' selected':'');?>>Get Wizardly</option>
                      <option value="GoodBye"<?php echo($rc['type']=='GoodBye'?' selected':'');?>>Goodbye</option>
                      <option value="Greeting"<?php echo($rc['type']=='Greeting'?' selected':'');?>>Greeting</option>
                      <option value="Hearing_1"<?php echo($rc['type']=='Hearing_1'?' selected':'');?>>Hearing</option>
                      <option value="Hide"<?php echo($rc['type']=='Hide'?' selected':'');?>>Hide</option>
                      <option value="Idle_1"<?php echo($rc['type']=='Idle_1'?' selected':'');?>>Idle</option>
                      <option value="IdleAtom"<?php echo($rc['type']=='IdleAtom'?' selected':'');?>>Idle Atom</option>
                      <option value="IdleEyeBrowRaise"<?php echo($rc['type']=='IdleEyeBrowRaise'?' selected':'');?>>Idle Eyebrow Raise</option>
                      <option value="IdleFingerTap"<?php echo($rc['type']=='IdleFingerTap'?' selected':'');?>>Idle Finger Tap</option>
                      <option value="IdleHeadScratch"<?php echo($rc['type']=='IdleHeadScratch'?' selected':'');?>>Idle Head Scratch</option>
                      <option value="IdleRopePile"<?php echo($rc['type']=='IdleRopePile'?' selected':'');?>>Idle Rope Pile</option>
                      <option value="IdleSideToSide"<?php echo($rc['type']=='IdleSideToSide'?' selected':'');?>>Idle Side To Side</option>
                      <option value="IdleSnooze"<?php echo($rc['type']=='IdleSnooze'?' selected':'');?>>Idle Snooze</option>
                      <option value="LookDown"<?php echo($rc['type']=='LookDown'?' selected':'');?>>Look Down</option>
                      <option value="LookDownLeft"<?php echo($rc['type']=='LookDownLeft'?' selected':'');?>>Look Down Left</option>
                      <option value="LookDownRight"<?php echo($rc['type']=='LookDownRight'?' selected':'');?>>Look Down Right</option>
                      <option value="LookLeft"<?php echo($rc['type']=='LookLeft'?' selected':'');?>>Look Left</option>
                      <option value="LookRight"<?php echo($rc['type']=='LookRight'?' selected':'');?>>Look Right</option>
                      <option value="LookUp"<?php echo($rc['type']=='LookUp'?' selected':'');?>>Look Up</option>
                      <option value="LookUpLeft"<?php echo($rc['type']=='LookUpLeft'?' selected':'');?>>Look Up Left</option>
                      <option value="LookUpRight"<?php echo($rc['type']=='LookUpRight'?' selected':'');?>>Look Up Right</option>
                      <option value="Print"<?php echo($rc['type']=='Print'?' selected':'');?>>Print</option>
                      <option value="Processing"<?php echo($rc['type']=='Processing'?' selected':'');?>>Processing</option>
                      <option value="RestPose"<?php echo($rc['type']=='RestPose'?' selected':'');?>>Rest Pose</option>
                      <option value="Save"<?php echo($rc['type']=='Save'?' selected':'');?>>Save</option>
                      <option value="Searching"<?php echo($rc['type']=='Searching'?' selected':'');?>>Searching</option>
                      <option value="SendMail"<?php echo($rc['type']=='SendMail'?' selected':'');?>>Send Mail</option>
                      <option value="Show"<?php echo($rc['type']=='Show'?' selected':'');?>>Show</option>
                      <option value="Thinking"<?php echo($rc['type']=='Thinking'?' selected':'');?>>Thinking</option>
                      <option value="Wave"<?php echo($rc['type']=='Wave'?' selected':'');?>>Wave</option>
                      <option value="Writing"<?php echo($rc['type']=='Writing'?' selected':'');?>>Writing</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <label for="when<?php echo$rc['id'];?>">Before or After</label>
                  <div class="form-row">
                    <select id="when<?php echo$rc['id'];?>" onchange="update(`<?php echo$rc['id'];?>`,`seo`,`title`,$(this).val());">
                      <option value="before"<?php echo($rc['title']=='before'?' selected':'');?>>Before</option>
                      <option value="after"<?php echo($rc['title']=='after'?' selected':'');?>>After</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-row">
                    <div class="form-text"><?php echo$rc['notes'];?></div>
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?php echo$rc['id'];?>`,'seo');"><?php svg('trash');?></button>
                  </div>
                </div>
              </div>
              <hr>
            </div>
<?php }?>
          </div>
        </div>
      </div>
    <?php }?>
    <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
