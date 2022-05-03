<?php
/**
* AuroraCMS - Copyright (C) Diemen Design 2019
*
* @category   Administration - Preferences - Security
* @package    core/layout/pref_security.php
* @author     Dennis Suitters <dennis@diemen.design>
* @copyright  2014-2019 Diemen Design
* @license    http://opensource.org/licenses/MIT  MIT License
* @version    0.2.10
* @link       https://github.com/DiemenDesign/AuroraCMS
* @notes      This PHP Script is designed to be executed using PHP 7+
*/?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">security</i></div>
          <div>Preferences - Security</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><i class="i">save</i></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Security</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">Settings</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Filters</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Blacklist</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Whitelist</label>
          <div class="tab1-1 border-top p-3" data-tabid="tab1-1" role="tabpanel">
            <legend>Administration Access Page</legend>
            <form target="sp" method="post" action="core/change_adminaccess.php">
              <div class="form-row">
                <label id="prefAdminAccess" for="adminfolder"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefAdminAccess" data-tooltip="tooltip" aria-label="PermaLink to Preferences Admin Access Field">&#128279;</a>':'';?>Access&nbsp;Folder</label>
                <small class="form-text text-right">Changing the access folder for the Administration area may log you out.</small>
              </div>
              <div class="form-row">
                <div class="input-text" id="adminaccess">
                  <a href="<?= URL.$settings['system']['admin'];?>"><?= URL;?></a>
                </div>
                <input id="adminfolder" name="adminfolder" type="text" value="<?=$settings['system']['admin'];?>" placeholder="This entry must NOT be blank..." required aria-required="true">
                <button type="submit">Update</button>
              </div>
            </form>
            <div class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefAttackScreen" data-tooltip="tooltip" aria-label="PermaLink to Preferences Screen Attacks Checkbox">&#128279;</a>':'';?>
              <input id="prefAttackScreen" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="5" type="checkbox"<?=$config['php_options'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configphp_options51" for="prefAttackScreen">Screen Against Attacks</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#pref30DayBlacklist" data-tooltip="tooltip" aria-label="PermaLink to Preferences Screen Attacks Checkbox">&#128279;</a>':'';?>
              <input id="pref30DayBlacklist" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="6" type="checkbox"<?=$config['php_options'][6]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configphp_options61" for="pref30DayBlacklist">30 Day Blacklist</label>
            </div>
            <legend class="mt-3">Google reCaptcha v2 for Forms</legend>
            <div class="form-row">
              <div class="form-text">To use Google ReCaptcha v2 the Client Key needs to have an API Key, for v3 both API Keys need to be filled in. You can acquire these at <a target="_blank" href="https://www.google.com/recaptcha/about/">Google ReCaptcha About Page</a>.</div>
            </div>
            <label id="prefreCaptchaClient" for="reCaptchaClient"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefreCaptchaClient" data-tooltip="tooltip" aria-label="PermaLink to Preferences Google ReCaptcha Client API Key Field">&#128279;</a>':'';?>reCaptcha Client Key</label>
            <div class="form-row">
              <input class="textinput" id="reCaptchaClient" data-dbid="1" data-dbt="config" data-dbc="reCaptchaClient" type="text" value="<?=$config['reCaptchaClient'];?>" placeholder="Enter a Google ReCaptcha API Client Key...">
              <button class="save" id="savereCaptchaClient" data-dbid="reCaptchaClient" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <label id="prefreCaptchaSecret" for="reCaptchaSecret"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefreCaptchaSecret" data-tooltip="tooltip" aria-label="PermaLink to Preferences Google ReCaptcha Server API Key Field">&#128279;</a>':'';?>reCaptcha Secret Key</label>
            <div class="form-row">
              <input class="textinput" id="reCaptchaSecret" data-dbid="1" data-dbt="config" data-dbc="reCaptchaServer" type="text" value="<?=$config['reCaptchaServer'];?>" placeholder="Enter a Google ReCaptcha API Secret Key...">
              <button class="save" id="savereCaptchaSecret" data-dbid="reCaptchaSecret" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <legend class="mt-3">Project Honey Pot</legend>
            <?php if($config['php_APIkey']==''){?>
              <div class="form-row">
                <div class="form-text">We recommend signing up to Project Honey Pot to take full advantage of protecting your website from spammers, and in turn help Project Honey Pot protect other sites. You can find more information at <a target="_blank" href="http://www.projecthoneypot.org?rf=113735">Project Honey Pot</a>.</div>
              </div>
            <?php }?>
            <div class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefEnablePHP" data-tooltip="tooltip" aria-label="PermaLink to Preferences Enable Project Honey Pot Checkbox">&#128279;</a>':'';?>
              <input id="prefEnablePHP" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="0" type="checkbox"<?=$config['php_options'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configphp_options01" for="prefEnablePHP">Enable Project Honey Pot</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefAutoBlacklist" data-tooltip="tooltip" aria-label="PermaLink to Preferences Auto Blacklist Checkbox">&#128279;</a>':'';?>
              <input id="prefAutoBlacklist" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="3" type="checkbox"<?=$config['php_options'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configphp_options31" for="prefAutoBlacklist">Auto Blacklist</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefBlockBlacklistIP" data-tooltip="tooltip" aria-label="PermaLink to Preferences Screen Attacks Checkbox">&#128279;</a>':'';?>
              <input id="prefBlockBlacklistIP" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="4" type="checkbox"<?=$config['php_options'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configphp_options41" for="prefBlockBlacklistIP">Block Blacklisted IP's</label>
            </div>
            <label id="prefPHPAPIKey" for="php_APIkey"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefPHPAPIKey" data-tooltip="tooltip" aria-label="PermaLink to Preferences Project Honey Pot API Key Field">&#128279;</a>':'';?>PHP API Key</label>
            <div class="form-row">
              <input class="textinput" id="php_APIkey" data-dbid="1" data-dbt="config" data-dbc="php_APIkey" type="text" value="<?=$config['php_APIkey'];?>" placeholder="Enter a Project Honey Pot API Key...">
              <button class="save" id="savephp_APIkey" data-dbid="php_APIkey" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <label id="prefPHPFile" for="php_honeypot"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefPHPFile" data-tooltip="tooltip" aria-label="PermaLink to Preferences Project Honey Pot File">&#128279;</a>':'';?>Honey Pot</label>
            <div class="form-row">
              <div class="input-text col-12" id="php_honeypot_link">
                <?=$config['php_honeypot']!=''?'<a target="_blank" href="'.$config['php_honeypot'].'">'.$config['php_honeypot'].'</a>':'Honey Pot File Not Uploaded...';?>
              </div>
              <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('1','config','php_honeypot');"><i class="i">browse-media</i></button>
              <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('1','config','php_honeypot','');"><i class="i">trash</i></button>
            </div>
            <div class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefAttackScreen" data-tooltip="tooltip" aria-label="PermaLink to Preferences Project Honey Pot Quick Link Checkbox">&#128279;</a>':'';?>
              <input id="prefPHPQuickLink" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="2" type="checkbox"<?=$config['php_options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configphp_options21" for="prefPHPQuickLink">Quick Link</label>
            </div>
            <form target="sp" method="post" action="core/update.php" onsubmit="$('#php_quicklink_save').removeClass('btn-danger');">
              <input name="id" type="hidden" value="1">
              <input name="t" type="hidden" value="config">
              <input name="c" type="hidden" value="php_quicklink">
              <div class="wysiwyg-toolbar col-12">
                <button id="php_quicklink_save" data-placement="bottom" type="submit" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
              </div>
              <div class="form-row col-12">
                <textarea style="height:100px" id="php_quicklink" name="da" onkeyup="$('#php_quicklink_save').addClass('btn-danger');"><?= $config['php_quicklink'];?></textarea>
              </div>
            </form>
          </div>
          <div class="tab1-2 border-top p-3" data-tabid="tab1-2" role="tabpanel">
            <legend>Filter Settings</legend>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefFilterForms" data-tooltip="tooltip" aria-label="PermaLink to Preferences Filter Forms Checkbox">&#128279;</a>':'';?>
              <input id="prefFilterForms" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="0" type="checkbox"<?=$config['spamfilter'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configspamfilter01" for="prefFilterForms">Filter Forms</label>
            </div>
            <label id="prefFormMinTime" for="formMinTime"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefFormMinTime" data-tooltip="tooltip" aria-label="PermaLink to Preferences Form Minimum Time for Visitors to Fill in Form in Seconds">&#128279;</a>':'';?>Form Minimum Time</label>
            <div class="form-row">
              <input class="textinput" id="formMinTime" data-dbid="1" data-dbt="config" data-dbc="formMinTime" type="text" value="<?=$config['formMinTime'];?>" placeholder="Enter a Time in Seconds...">
              <div class="input-text">seconds</div>
              <button class="save" id="saveformMinTime" data-dbid="formMinTime" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <label id="prefFormMaxTime" for="formMaxTime"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefFormMaxTime" data-tooltip="tooltip" aria-label="PermaLink to Preferences Form Maximum Time for Visitors to Fill in Form in Hours">&#128279;</a>':'';?>Form Maximum Time</label>
            <div class="form-row">
              <input class="textinput" id="formMaxTime" data-dbid="1" data-dbt="config" data-dbc="formMaxTime" type="text" value="<?=$config['formMaxTime'];?>" placeholder="Enter a Time in Minutes...">
              <div class="input-text">minutes</div>
              <button class="save" id="saveformMaxTime" data-dbid="formMaxTime" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <legend class="mt-3" id="prefFilters"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/security#prefFilters" data-tooltip="tooltip" aria-label="PermaLink to Preferences Filter Forms Checkbox">&#128279;</a>':'';?>Form Filters</legend>
            <div class="form-row">
              <div class="help-text text-right">Any regular expression syntax can be used (without the deliminiters). All keywords are case insensitive. Lines starting with '#' are ignored.</div>
            </div>
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
          </div>
          <div class="tab1-3 border-top py-3" data-tabid="tab1-3" role="tabpanel">
            <table class="table-zebra">
              <thead>
                <tr>
                  <th class="text-center">Permanent</th>
                  <th class="text-center">Date Blacklisted</th>
                  <th class="text-center">Date Captured</th>
                  <th class="text-center">IP</th>
                  <th class="text-center">Reason</th>
                  <th class="">
                    <div class="btn-group float-right">
                      <button class="purge trash" data-tooltip="tooltip" aria-label="Purge All" onclick="purge('0','iplist');return false;"><i class="i">purge</i></button>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody id="l_iplist">
                <?php $s=$db->prepare("SELECT * FROM `".$prefix."iplist` ORDER BY `ti` DESC");
                $s->execute();
                while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?=$r['id'];?>">
                    <td class="text-center align-middle">
                      <input data-dbid="<?=$r['id'];?>" data-dbt="iplist" data-dbc="permanent" data-dbb="0" type="checkbox"<?=$r['permanent'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                    </td>
                    <td class="text-center align-middle small"><?= date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-center align-middle small"><?= date($config['dateFormat'],$r['oti']);?></td>
                    <td class="text-center align-middle small"><?='<strong>'.$r['ip'].'</strong>';?></td>
                    <td class="text-left align-middle small"><?=$r['reason'];?></td>
                    <td id="controls_<?=$r['id'];?>">
                      <div class="btn-group float-right">
                        <a class="btn" target="_blank" href="https://www.projecthoneypot.org/ip_<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><i class="i">brand-projecthoneypot</i></a>
                        <a class="btn" target="_blank" href="https://dnschecker.org/ip-location.php?ip=<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><i class="i">search</i></a>
                        <button class="purge trash" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','iplist');return false;"><i class="i">purge</i></button>
                      </div>
                    </td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <div class="tab1-4 border-top py-3" data-tabid="tab1-4" role="tabpanel">
            <table class="table-zebra">
              <thead>
                <tr>
                  <th class="text-center">Date Whitelisted</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">IP</th>
                  <th class="">
                    <div class="btn-group float-right">
                      <button class="purge trash" data-tooltip="tooltip" aria-label="Purge All" onclick="purge('0','whitelist');return false;"><i class="i">purge</i></button>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody id="l_whitelist">
                <?php $s=$db->prepare("SELECT * FROM `".$prefix."whitelist` ORDER BY `ti` DESC");
                $s->execute();
                while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?=$r['id'];?>">
                    <td class="text-center align-middle small"><?= date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-center align-middle small"><?=$r['email'];?></td>
                    <td class="text-center align-middle small"><?='<strong>'.$r['ip'].'</strong>';?></td>
                    <td id="controls_<?=$r['id'];?>">
                      <div class="btn-group float-right">
                        <a class="btn" target="_blank" href="https://www.projecthoneypot.org/ip_<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><i class="i">brand-projecthoneypot</i></a>
                        <a class="btn" target="_blank" href="https://dnschecker.org/ip-location.php?ip=<?=$r['ip'];?>" role="button" data-tooltip="tooltip" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><i class="i">search</i></a>
                        <button class="purge trash" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','whitelist');return false;"><i class="i">purge</i></button>
                      </div>
                    </td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
