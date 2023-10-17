<?php
/**
* AuroraCMS - Copyright (C) Diemen Design 2019
*
* @category   Administration - Preferences - Security
* @package    core/layout/pref_security.php
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
                <li class="breadcrumb-item active">Security</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">Settings</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Filters</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Blacklist</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Whitelist</label>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <legend>Administration Access Page</legend>
            <form target="sp" method="post" action="core/change_adminaccess.php">
              <label for="adminfolder">Access Folder</label>
              <?=($user['options'][7]==1?'<div class="form-text">Changing the access folder for the Administration area may log you out.</div>':'');?>
              <div class="form-row mt-1">
                <div class="input-text" id="adminaccess">
                  <a href="<?= URL.$settings['system']['admin'];?>"><?= URL;?></a>
                </div>
                <input id="adminfolder" name="adminfolder" type="text" value="<?=$settings['system']['admin'];?>"<?=($user['options'][7]==1?' placeholder="This entry must NOT be blank..." required aria-required="true"':' disabled');?>>
                <?=($user['options'][7]==1?'<button type="submit">Update</button>':'');?>
              </div>
            </form>
            <div class="form-row mt-3">
              <input id="prefAttackScreen" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="5" type="checkbox"<?=($config['php_options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefAttackScreen">Screen Against Attacks</label>
            </div>
            <div class="form-row">
              <input id="pref30DayBlacklist" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="6" type="checkbox"<?=($config['php_options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="pref30DayBlacklist">30 Day Blacklist</label>
            </div>
            <legend>Google reCaptcha v2 for Forms</legend>
            <?=($user['options'][7]==1?'<div class="form-text">To use Google ReCaptcha v2 the Client Key needs to have an API Key, for v3 both API Keys need to be filled in. You can acquire these at <a target="_blank" href="https://www.google.com/recaptcha/about/">Google ReCaptcha About Page</a>.</div>':'');?>
            <label for="reCaptchaClient">reCaptcha Client Key</label>
            <div class="form-row">
              <input class="textinput" id="reCaptchaClient" data-dbid="1" data-dbt="config" data-dbc="reCaptchaClient" type="text" value="<?=$config['reCaptchaClient'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Google ReCaptcha API Client Key..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savereCaptchaClient" data-dbid="reCaptchaClient" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="reCaptchaSecret">reCaptcha Secret Key</label>
            <div class="form-row">
              <input class="textinput" id="reCaptchaSecret" data-dbid="1" data-dbt="config" data-dbc="reCaptchaServer" type="text" value="<?=$config['reCaptchaServer'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Google ReCaptcha API Secret Key..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savereCaptchaSecret" data-dbid="reCaptchaSecret" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <legend class="mt-3">Project Honey Pot</legend>
            <?=($config['php_APIkey']==''&&$user['options'][7]==1?'<div class="form-text">We recommend signing up to Project Honey Pot to take full advantage of protecting your website from spammers, and in turn help Project Honey Pot protect other sites. You can find more information at <a target="_blank" href="http://www.projecthoneypot.org?rf=113735">Project Honey Pot</a>.</div>':'');?>
            <div class="form-row mt-3">
              <input id="prefEnablePHP" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="0" type="checkbox"<?=($config['php_options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefEnablePHP">Enable Project Honey Pot</label>
            </div>
            <div class="form-row">
              <input id="prefAutoBlacklist" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="3" type="checkbox"<?=($config['php_options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefAutoBlacklist">Auto Blacklist</label>
            </div>
            <div class="form-row">
              <input id="prefBlockBlacklistIP" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="4" type="checkbox"<?=($config['php_options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefBlockBlacklistIP">Block Blacklisted IP's</label>
            </div>
            <label for="php_APIkey">PHP API Key</label>
            <div class="form-row">
              <input class="textinput" id="php_APIkey" data-dbid="1" data-dbt="config" data-dbc="php_APIkey" type="text" value="<?=$config['php_APIkey'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Project Honey Pot API Key..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savephp_APIkey" data-dbid="php_APIkey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="php_honeypot">Honey Pot</label>
            <div class="form-row">
              <div class="input-text col-12" id="php_honeypot_link">
                <?=$config['php_honeypot']!=''?'<a target="_blank" href="'.$config['php_honeypot'].'">'.$config['php_honeypot'].'</a>':'Honey Pot File Not Uploaded...';?>
              </div>
              <?=($user['options'][7]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`1`,`config`,`php_honeypot`);"><i class="i">browse-media</i></button>'.
              '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons(`1`,`config`,`php_honeypot`,``);"><i class="i">trash</i></button>':'');?>
            </div>
            <div class="form-row mt-3 mb-1">
              <input id="prefPHPQuickLink" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="2" type="checkbox"<?=($config['php_options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefPHPQuickLink">Quick Link</label>
            </div>
            <?php if($user['options'][7]==1){?>
              <form target="sp" method="post" action="core/update.php" onsubmit="$('#php_quicklink_save').removeClass('btn-danger');">
                <input name="id" type="hidden" value="1">
                <input name="t" type="hidden" value="config">
                <input name="c" type="hidden" value="php_quicklink">
                <div class="wysiwyg-toolbar col-12">
                  <button id="php_quicklink_save" data-placement="bottom" type="submit" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                </div>
                <div class="form-row col-12">
                  <textarea style="height:100px" id="php_quicklink" name="da" onkeyup="$('#php_quicklink_save').addClass('btn-danger');"><?=$config['php_quicklink'];?></textarea>
                </div>
              </form>
            <?php }else{?>
              <div class="note-admin">
                <div class="note-editor note-frame">
                  <div class="note-editing-area">
                    <div class="note-viewport-area">
                      <div class="note-editable">
                        <pre><?=$config['php_quicklink'];?></pre>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php }?>
          </div>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <legend>Filter Settings</legend>
            <div class="form-row mt-3">
              <input id="prefFilterForms" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="0" type="checkbox"<?=($config['spamfilter']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefFilterForms">Filter Forms</label>
            </div>
            <label for="formMinTime">Form Minimum Time</label>
            <div class="form-row">
              <input class="textinput" id="formMinTime" data-dbid="1" data-dbt="config" data-dbc="formMinTime" type="text" value="<?=$config['formMinTime'];?>"<?=($user['options']==1?') placeholder="Enter a Time in Seconds..."':' disabled');?>>
              <div class="input-text">seconds</div>
              <?=($user['options'][7]==1?'<button class="save" id="saveformMinTime" data-dbid="formMinTime" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="formMaxTime">Form Maximum Time</label>
            <div class="form-row">
              <input class="textinput" id="formMaxTime" data-dbid="1" data-dbt="config" data-dbc="formMaxTime" type="text" value="<?=$config['formMaxTime'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Time in Minutes..."':' disabled');?>>
              <div class="input-text">minutes</div>
              <?=($user['options'][7]==1?'<button class="save" id="saveformMaxTime" data-dbid="formMaxTime" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          <?php if($user['options'][7]==1){?>
            <label>Form Filters</label>
            <div class="form-text">Any regular expression syntax can be used (without the deliminiters). All keywords are case insensitive. Lines starting with '#' are ignored.</div>
            <form target="sp" method="post" action="core/updateblacklist.php">
              <div class="form-row">
                <div class="input-text">File</div>
                <select id="filesEditSelect" name="file">
                  <?php $fileDefault=$user['rank']==1000?'index.txt':'index.txt';
                  $files=array();
                  foreach(glob("core/blacklists/*.{txt}",GLOB_BRACE)as$file){
                    echo'<option value="'.$file.'"';
                    if(stristr($file,$fileDefault)){
                      echo' selected';
                      $fileDefault=$file;
                    }
                    echo'>'.basename($file).'</option>';
                  }?>
                </select>
                <button id="filesEditLoad">Load</button>
              </div>
              <div class="wysiwyg-toolbar">
                <button id="codeSave" data-placement="bottom" data-tooltip="tooltip" aria-label="Save" onclick="populateTextarea();"><i class="i">save</i></button>
              </div>
              <div class="row col-12">
                <?php $code=file_get_contents($fileDefault);?>
                <textarea id="code" name="code"><?=$code;?></textarea>
              </div>
            </form>
            <script>
              $(document).ready(function(){
                var editor=CodeMirror.fromTextArea(document.getElementById("code"),{
                  lineNumbers:true,
                  lineWrapping:true,
                  mode:"text/html",
                  theme:"base16-dark",
                  autoRefresh:true
                });
                var charWidth=editor.defaultCharWidth(),basePadding=4;
                editor.refresh();
                $('#filesEditLoad').on({
                  click:function(event){
                    event.preventDefault();
                    var url=$('#filesEditSelect').val();
                    $.ajax({
                      url:url+'?<?= time();?>',
                      dataType:"text",
                      success:function(data){
                        editor.setValue(data).refresh();
                      }
                    });
                  }
                });
              });
            </script>
          <?php }?>
          </div>
          <div class="tab1-3 border" data-tabid="tab1-3" role="tabpanel">
            <div class="sticky-top">
              <div class="row">
                <article class="card py-1 overflow-visible card-list card-list-header shadow">
                  <div class="row">
                    <div class="col-12 col-md-2 text-center">Permanent</div>
                    <div class="col-12 col-md-2 text-center">Date Blacklisted</div>
                    <div class="col-12 col-md-2 text-center">Date Captured</div>
                    <div class="col-12 col-md-2 text-center">IP</div>
                    <div class="col-12 col-md">Reason</div>
                    <div class="col-12 col-md-2 text-right pr-2">
                      <?=($user['options'][7]==1?'<button class="btn-sm purge" data-tooltip="tooltip" aria-label="Purge All" onclick="purge(`0`,`iplist`);return false;"><i class="i">purge</i></button>':'');?>
                    </div>
                  </div>
                </article>
              </div>
            </div>
            <div id="l_iplist">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."iplist` ORDER BY `ti` DESC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <article class="card col-12 zebra m-0 p-0 border-0 overflow-visible card-list item shadow subsortable" id="l_<?=$rm1['id'];?>">
                  <div class="row">
                    <div class="col-12 col-md-2 text-center pt-3">
                      <input data-dbid="<?=$r['id'];?>" data-dbt="iplist" data-dbc="permanent" data-dbb="0" type="checkbox"<?=$r['permanent']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                    </div>
                    <div class="col-12 col-md-2 text-center pt-3 small">
                      <?= date($config['dateFormat'],$r['ti']);?>
                    </div>
                    <div class="col-12 col-md-2 text-center pt-3 small">
                      <?= date($config['dateFormat'],$r['oti']);?>
                    </div>
                    <div class="col-12 col-md-2 text-center pt-3 small">
                      <?='<strong>'.$r['ip'].'</strong>';?>
                    </div>
                    <div class="col-12 col-md text-left pt-3 small">
                      <?=$r['reason'];?>
                    </div>
                    <div class="col-12 col-md-2 text-right py-2 pr-2">
                      <a class="btn" target="_blank" href="https://www.projecthoneypot.org/ip_<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><i class="i">brand-projecthoneypot</i></a>
                      <a class="btn" target="_blank" href="https://dnschecker.org/ip-location.php?ip=<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><i class="i">search</i></a>
                      <?=($user['options'][7]==1?'<button class="purge" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`iplist`);return false;"><i class="i">purge</i></button>':'');?>
                    </div>
                  </div>
                </article>
              <?php }?>
            </div>
          </div>
          <div class="tab1-4 border" data-tabid="tab1-4" role="tabpanel">
            <div class="sticky-top">
              <div class="row">
                <article class="card py-1 overflow-visible card-list card-list-header shadow">
                  <div class="row">
                    <div class="col-12 col-md-2 text-center">Date Whitelisted</div>
                    <div class="col-12 col-md text-center">Email</div>
                    <div class="col-12 col-md-2 text-center">IP</div>
                    <div class="col-12 col-md-2 text-right pr-2">
                      <?=($user['options'][7]==1?'<button class="btn-sm purge" data-tooltip="tooltip" aria-label="Purge All" onclick="purge(`0`,`whitelist`);return false;"><i class="i">purge</i></button>':'');?>
                    </div>
                  </div>
                </article>
              </div>
            </div>
            <div id="l_whitelist">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."whitelist` ORDER BY `ti` DESC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <article class="card col-12 zebra m-0 p-0 border-0 overflow-visible card-list item shadow subsortable" id="l_<?=$rm1['id'];?>">
                  <div class="row">
                    <div class="col-12 col-md text-center pt-3 small"><?= date($config['dateFormat'],$r['ti']);?></div>
                    <div class="col-12 col-md text-center pt-3 small"><?=$r['email'];?></div>
                    <div class="col-12 col-md text-center pt-3 small"><?='<strong>'.$r['ip'].'</strong>';?></div>
                    <div class="col-12 col-md-2 text-right py-2 pr-2">
                      <a class="btn" target="_blank" href="https://www.projecthoneypot.org/ip_<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><i class="i">brand-projecthoneypot</i></a>
                      <a class="btn" target="_blank" href="https://dnschecker.org/ip-location.php?ip=<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><i class="i">search</i></a>
                      <?=($user['options'][7]==1?'<button class="purge" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`whitelist`);return false;"><i class="i">purge</i></button>':'');?>
                    </div>
                  </div>
                </article>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
