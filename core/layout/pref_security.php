<?php
/**
* AuroraCMS - Copyright (C) Diemen Design 2019
*
* @category   Administration - Preferences - Security
* @package    core/layout/pref_security.php
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
          <div class="content-title-icon"><?php svg('security','i-3x');?></div>
          <div>Preferences - Security</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Security</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">Settings</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Filters</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Blacklist</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Whitelist</label>
          <div class="tab1-1 border-top p-3" role="tabpanel">
            <legend>Administration Access Page</legend>
            <form target="sp" method="post" action="core/change_adminaccess.php">
              <div class="form-row">
                <label for="adminfolder">Access&nbsp;Folder</label>
                <small class="form-text text-right">Changing the access folder for the Administration area may log you out.</small>
              </div>
              <div class="form-row">
                <div class="input-text" id="adminaccess">
                  <a href="<?php echo URL.$settings['system']['admin'];?>"><?php echo URL;?></a>
                </div>
                <input id="adminfolder" name="adminfolder" type="text" value="<?php echo$settings['system']['admin'];?>" placeholder="This entry must NOT be blank..." required aria-required="true">
                <button type="submit">Update</button>
              </div>
            </form>
            <div class="row mt-3">
              <inputid="php_options5" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="5" type="checkbox" <?php echo$config['php_options'][5]==1?' checked':'';?>>
              <label for="php_options5">Screen Against Attacks</label>
            </div>
            <div class="row">
              <input id="php_options6" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="6" type="checkbox"<?php echo$config['php_options'][6]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="php_options6">30 Day Blacklist</label>
            </div>
            <legend class="mt-3">Project Honey Pot</legend>
            <?php if($config['php_APIkey']==''){?>
              <div class="form-row">
                <div class="form-text">We recommend signing up to Project Honey Pot to take full advantage of protecting your website from spammers, and in turn help Project Honey Pot protect other sites. You can find more information at <a target="_blank" href="http://www.projecthoneypot.org?rf=113735">Project Honey Pot</a>.</div>
              </div>
            <?php }?>
            <div class="row mt-3">
              <input id="php_options0" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="0" type="checkbox"<?php echo$config['php_options'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="php_options0">Enable Monitoring</label>
            </div>
            <div class="row">
              <input id="php_options3" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="3" type="checkbox"<?php echo$config['php_options'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="php_options3">Auto Blacklist</label>
            </div>
            <div class="row">
              <input id="php_options4" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="4" type="checkbox"<?php echo$config['php_options'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="php_options4">Block Blacklisted IP's</label>
            </div>
            <label for="php_APIkey">PHP API Key</label>
            <div class="form-row">
              <input class="textinput" id="php_APIkey" data-dbid="1" data-dbt="config" data-dbc="php_APIkey" type="text" value="<?php echo$config['php_APIkey'];?>" placeholder="Enter a Project Honey Pot API Key...">
              <button class="save" id="savephp_APIkey" data-dbid="php_APIkey" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?php svg('save');?></button>
            </div>
            <label for="php_honeypot">Honey Pot</label>
            <div class="form-row">
              <div class="input-text col-12" id="php_honeypot_link">
                <?php echo$config['php_honeypot']!=''?'<a target="_blank" href="'.$config['php_honeypot'].'">'.$config['php_honeypot'].'</a>':'Honey Pot File Not Uploaded...';?>
              </div>
              <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('1','config','php_honeypot');"><?php svg('browse-media');?></button>
              <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('1','config','php_honeypot','');"><?php svg('trash');?></button>
            </div>
            <div class="row mt-3">
              <input id="php_options2" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="2" type="checkbox"<?php echo$config['php_options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="php_options2">Quick Link</label>
            </div>
            <form target="sp" method="post" action="core/update.php" onsubmit="$('#php_quicklink_save').removeClass('btn-danger');">
              <input name="id" type="hidden" value="1">
              <input name="t" type="hidden" value="config">
              <input name="c" type="hidden" value="php_quicklink">
              <div class="wysiwyg-toolbar col-12">
                <button id="php_quicklink_save" data-tooltip="tooltip" data-placement="bottom" type="submit" aria-label="Save"><?php svg('save');?></button>
              </div>
              <div class="form-row col-12">
                <textarea style="height:100px" id="php_quicklink" name="da" onkeyup="$('#php_quicklink_save').addClass('btn-danger');"><?php echo $config['php_quicklink'];?></textarea>
              </div>
            </form>
          </div>
          <div class="tab1-2 border-top p-3" role="tabpanel">
            <legend>Filter Settings</legend>
            <div class="row">
              <input id="spamfilter0" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="0" type="checkbox"<?php echo$config['spamfilter'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="spamfilter0">Filter Forms</label>
            </div>
            <div class="row">
              <input id="spamfilter1" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="1" type="checkbox"<?php echo$config['spamfilter'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="spamfilter1">Auto Blacklist</label>
            </div>
            <legend>Filters</legend>
            <div class="form-row">
              <div class="help-text text-right">Any regular expression syntax can be used (without the deliminiters). All keywords are case insensitive. Lines starting with '#' are ignored.</div>
            </div>
            <form target="sp" method="post" action="core/updateblacklist.php">
              <div class="form-row">
                <div class="input-text">File</div>
                <select id="filesEditSelect" name="file">
                  <?php $fileDefault=($user['rank']==1000?'index.txt':'index.txt');
                  $files=array();
                  foreach(glob("core/blacklists/*.{txt}",GLOB_BRACE)as$file){
                    echo'<option value="'.$file.'"';
                    if(stristr($file,$fileDefault)){
                      echo' selected="selected"';
                      $fileDefault=$file;
                    }
                    echo'>'.basename($file).'</option>';
                  }?>
                </select>
                <button id="filesEditLoad">Load</button>
              </div>
              <div class="wysiwyg-toolbar">
                <button id="codeSave" data-tooltip="tooltip" data-placement="bottom" aria-label="Save" onclick="populateTextarea();"><?php svg('save');?></button>
              </div>
              <div class="row col-12">
                <?php $code=file_get_contents($fileDefault);?>
                <textarea id="code" name="code"><?php echo$code;?></textarea>
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
                      url:url+'?<?php echo time();?>',
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
          <div class="tab1-3 border-top py-3" role="tabpanel">
            <table class="table-zebra">
              <thead>
                <tr>
                  <th class="text-center">Date Blacklisted</th>
                  <th class="text-center">Date Captured</th>
                  <th class="text-center">IP</th>
                  <th class="text-center">Reason</th>
                  <th class="">
                    <div class="btn-group float-right">
                      <button class="purge trash" data-tooltip="tooltip" aria-label="Purge All" onclick="purge('0','iplist');return false;"><?php svg('purge');?></button>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody id="l_iplist">
                <?php $s=$db->prepare("SELECT * FROM `".$prefix."iplist` ORDER BY `ti` DESC");
                $s->execute();
                while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>">
                    <td class="text-center small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-center small"><?php echo date($config['dateFormat'],$r['oti']);?></td>
                    <td class="text-center small"><?php echo'<strong>'.$r['ip'].'</strong>';?></td>
                    <td class="text-left small"><?php echo$r['reason'];?></td>
                    <td id="controls_<?php echo$r['id'];?>">
                      <div class="btn-group float-right">
                        <a class="btn" target="_blank" data-tooltip="tooltip" href="https://www.projecthoneypot.org/ip_<?php echo$r['ip'];?>" role="button" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><?php echo svg2('brand-projecthoneypot');?></a>
                        <a class="btn" target="_blank" data-tooltip="tooltip" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>" role="button" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><?php echo svg2('search');?></a>
                        <button class="purge trash" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?php echo$r['id'];?>','iplist');return false;"><?php svg('purge');?></button>
                      </div>
                    </td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <div class="tab1-4 border-top py-3" role="tabpanel">
            <table class="table-zebra">
              <thead>
                <tr>
                  <th class="text-center">Date Whitelisted</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">IP</th>
                  <th class="">
                    <div class="btn-group float-right">
                      <button class="purge trash" data-tooltip="tooltip" aria-label="Purge All" onclick="purge('0','whitelist');return false;"><?php svg('purge');?></button>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody id="l_whitelist">
                <?php $s=$db->prepare("SELECT * FROM `".$prefix."whitelist` ORDER BY `ti` DESC");
                $s->execute();
                while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>">
                    <td class="text-center small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-center small"><?php echo$r['email'];?></td>
                    <td class="text-center small"><?php echo'<strong>'.$r['ip'].'</strong>';?></td>
                    <td id="controls_<?php echo$r['id'];?>">
                      <div class="btn-group float-right">
                        <a class="btn" target="_blank" data-tooltip="tooltip" href="https://www.projecthoneypot.org/ip_<?php echo$r['ip'];?>" role="button" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><?php echo svg2('brand-projecthoneypot');?></a>
                        <a class="btn" target="_blank" data-tooltip="tooltip" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>" role="button" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><?php echo svg2('search');?></a>
                        <button class="purge trash" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?php echo$r['id'];?>','whitelist');return false;"><?php svg('purge');?></button>
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
