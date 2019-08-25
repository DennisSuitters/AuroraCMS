<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Security
 * @package    core/layout/pref_security.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Add Reason to Blacklist
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Security</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div id="update" class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-security-settings" class="nav-item"><a class="nav-link active" href="#tab-security-settings" aria-controls="tab-security-settings" role="tab" data-toggle="tab">Settings</a></li>
          <li id="nav-security-filters" class="nav-item"><a class="nav-link" href="#tab-security-filters" aria-controls="tab-security-filter" role="tab" data-toggle="tab">Filters</a></li>
          <li id="nav-security-blacklist" class="nav-item"><a class="nav-link" href="#tab-security-blacklist" aria-controls="tab-security-blacklist" role="tab" data-toggle="tab">Blacklist</a></li>
          <li id="nav-security-whitelist" class="nav-item"><a class="nav-link" href="#tab-security-whitelist" aria-controls="tab-security-whitelist" role="tab" data-toggle="tab">Whitelist</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-security-settings" name="tab-security-settings" class="tab-pane active">
            <h4>Administration Access Page</h4>
            <form target="sp" method="post" action="core/change_adminaccess.php">
              <div class="form-group row">
                <label for="adminfolder" class="col-form-label col-sm-2">Access Folder</label>
                <div class="input-group col-sm-10">
                  <div id="adminaccess" class="input-group-text">
                    <a href="<?php echo URL.$settings['system']['admin'];?>"><?php echo URL;?></a>
                  </div>
                  <input type="text" id="adminfolder" class="form-control" name="adminfolder" value="<?php echo$settings['system']['admin'];?>" placeholder="This entry must NOT be blank..." required aria-required="true">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Update</button>
                  </div>
                  <div class="help-block col small">Changing the access folder for the Administration area may log you out.</div>
                </div>
              </div>
            </form>
            <div class="form-group row">
              <label for="php_options5" class="col-form-label col-sm-2">Wordpress Attacks</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options5" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="5"<?php echo$config['php_options']{5}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                <div class="help-block col small text-right">Enabling Wordpress Attacks will allow LibreCMS to look out for known Wordpres attack vectors such as the 'xmlrpc.php' and '?author=' brute force attempts and Auto Blacklist the origin IP.</div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options6" class="col-form-label col-sm-2">30 Day Blacklist</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options6" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="6"<?php echo$config['php_options']{6}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                <div class="help-block col small text-right">Enabling 30 Day Blacklist, removes Blacklisted IP's after 30 Days.</div>
              </div>
            </div>
            <h4>Project Honey Pot</h4>
<?php if($config['php_APIkey']==''){?>
            <div class="form-group">
              <div class="well">We recommend signing up to Project Honey Pot to take full advantage of protecting your website from spammers, and in turn help Project Honey Pot protect other sites. You can find more information at <a target="_blank" href="http://www.projecthoneypot.org?rf=113735">Project Honey Pot</a>.</div>
            </div>
<?php }?>
            <div class="form-group row">
              <label for="php_options0" class="col-form-label col-sm-2">Enable Monitoring</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="0"<?php echo$config['php_options']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options3" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot.">Auto Blacklist</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options3" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="3"<?php echo$config['php_options']{3}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></label>
                <div class="help-block col small text-right">Auto Blacklisting requires an API Key to be entered below.<br>Auto Blacklisting filters IP's against Project Honey Pot's http:BL for public facing pages with data entry.</div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options4" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot.">Block Blacklisted IP's</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options4" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="4"<?php echo$config['php_options']{4}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_APIkey" class="col-form-label col-sm-2">PHP API Key</label>
              <div class="input-group col-sm-10">
                <input type="text" id="php_APIkey" class="form-control textinput" value="<?php echo$config['php_APIkey'];?>" data-dbid="1" data-dbt="config" data-dbc="php_APIkey" placeholder="Enter a Project Honey Pot API Key...">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savephp_APIkey" class="btn btn-secondary save" data-dbid="php_APIkey" data-style="zoom-in" role="button" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_honeypot" class="col-form-label col-sm-2">Honey Pot</label>
              <div class="input-group col-sm-10">
                <div id="php_honeypot_link" class="input-group-text col">
                  <?php echo$config['php_honeypot']!=''?'<a target="_blank" href="'.$config['php_honeypot'].'">'.$config['php_honeypot'].'</a>':'Honey Pot File Not Uploaded...';?>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-secondary" onclick="elfinderDialog('1','config','php_honeypot');" data-tooltip="tooltip" title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-secondary trash" onclick="updateButtons('1','config','php_honeypot','');" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options2" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Quick Link.">Quick Link</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options2" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="2"<?php echo$config['php_options']{2}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></label>
              </div>
            </div>
            <div class="form-group row text-right">
              <div class="col-form-label col-sm-2"></div>
              <div class="col-12 col-sm-10">
                <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();$('#php_quicklink_save').removeClass('btn-danger');">
                  <input type="hidden" name="id" value="1">
                  <input type="hidden" name="t" value="config">
                  <input type="hidden" name="c" value="php_quicklink">
                  <div class="input-group card-header p-2 mb-0">
                    <button type="submit" id="php_quicklink_save" class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-placement="bottom" title="Save" aria-label="Save"><?php svg('save');?></button>
                  </div>
                  <div class="input-group">
                    <textarea id="php_quicklink" class="form-control" style="height:100px" name="da" onkeyup="$('#php_quicklink_save').addClass('btn-danger');"><?php echo $config['php_quicklink'];?></textarea>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div id="tab-security-filters" name="tab-security-filters" class="tab-pane">
            <legend>Filter Settings</legend>
            <div class="form-group row">
              <label for="spamfilter0" class="col-form-label col-sm-2">Filter Forms</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="spamfilter0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="0"<?php echo$config['spamfilter']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="spamfilter1" class="col-form-label col-sm-2">Auto Blacklist</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="spamfilter1" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="1"<?php echo$config['spamfilter']{1}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <legend>Filters</legend>
            <div class="card-body">
              <div class="help-block small text-muted text-right">Any regular expression syntax can be used (without the deliminiters). All keywords are case insensitive. Lines starting with '#' are ignored.</div>
              <form target="sp" method="post" action="core/updateblacklist.php">
                <div class="input-group">
                  <div class="input-group-text">File</div>
                  <select id="filesEditSelect" class="form-control" name="file">
                    <?php $fileDefault=($user['rank']==1000?'index.txt':'index.txt');
                    $files=array();
                    foreach(glob("core".DS."blacklists".DS."*.{txt}",GLOB_BRACE)as$file){
                      echo'<option value="'.$file.'"';
                      if(stristr($file,$fileDefault)){
                        echo' selected="selected"';
                        $fileDefault=$file;
                      }
                      echo'>'.basename($file).'</option>';
                    }?>
                  </select>
                  <div class="input-group-append">
                    <button id="filesEditLoad" class="btn btn-secondary" onclick="Pace.restart();">Load</button>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group card-header p-2 mb-0">
                    <button id="codeSave" class="btn btn-secondary btn-sm" onclick="populateTextarea();" data-tooltip="tooltip" data-placement="bottom" title="Save" aria-label="Save"><?php svg('save');?></button>
                  </div>
                </div>
                <div class="form-group" style="margin-top:-15px">
<?php $code=file_get_contents($fileDefault);?>
                  <textarea id="code" name="code"><?php echo$code;?></textarea>
                </div>
              </form>
            </div>
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
                        Pace.restart();
                        editor.setValue(data).refresh();
                      }
                    });
                  }
                });
              });
              function populateTextarea(){
                Pace.restart();
              }
            </script>
          </div>
          <div id="tab-security-blacklist" name="tab-security-blacklist" class="tab-pane">
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-xs-3 text-center">Date Blacklisted</th>
                    <th class="col-xs-3 text-center">Date Captured</th>
                    <th class="col-xs-2 text-center">IP</th>
                    <th class="col-xs-3 text-center">Reason</th>
                    <th class="col-xs-2">
                      <div class="btn-group float-right">
                        <button class="btn btn-secondary btn-sm trash" onclick="purge('0','iplist');return false;" data-tooltip="tooltip" title="Purge All" aria-label="Purge All"><?php svg('purge');?></button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody id="l_iplist">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."iplist` ORDER BY ti DESC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>">
                    <td class="text-center small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-center small"><?php echo date($config['dateFormat'],$r['oti']);?></td>
                    <td class="text-center small"><?php echo'<strong>'.$r['ip'].'</strong>';?></td>
                    <td class="text-left small"><?php echo$r['reason'];?></td>
                    <td id="controls_<?php echo$r['id'];?>">
                      <div class="btn-group float-right">
                        <a class="btn btn-secondary" target="_blank" href="https://www.projecthoneypot.org/ip_<?php echo$r['ip'];?>" data-tooltip="tooltip" title="Lookup IP using Project Honey Pot (Opens in New Page)." role="button" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><?php echo svg2('brand-projecthoneypot');?></a>
                        <a class="btn btn-secondary" target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>" data-tooltip="tooltip" title="Lookup IP using IP Address Finder .com (Opens in New Page)." role="button" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><?php echo svg2('search');?></a>
                        <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','iplist');return false;" data-tooltip="tooltip" title="Purge" aria-label="Purge"><?php svg('purge');?></button>
                      </div>
                    </td>
                  </tr>
<?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <div id="tab-security-whitelist" name="tab-security-whitelist" class="tab-pane">
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-xs-3 text-center">Date Whitelisted</th>
                    <th class="col-xs-3 text-center">Email</th>
                    <th class="col-xs-3 text-center">IP</th>
                    <th class="col-xs-3">
                      <div class="btn-group float-right">
                        <button class="btn btn-secondary btn-sm trash" onclick="purge('0','whitelist');return false;" data-tooltip="tooltip" title="Purge All" aria-label="Purge All"><?php svg('purge');?></button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody id="l_whitelist">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."whitelist` ORDER BY ti DESC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>">
                    <td class="text-center small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-center small"><?php echo$r['email'];?></td>
                    <td class="text-center small"><?php echo'<strong>'.$r['ip'].'</strong>';?></td>
                    <td id="controls_<?php echo$r['id'];?>">
                      <div class="btn-group float-right">
                        <a class="btn btn-secondary" target="_blank" href="https://www.projecthoneypot.org/ip_<?php echo$r['ip'];?>" data-tooltip="tooltip" title="Lookup IP using Project Honey Pot (Opens in New Page)." role="button" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><?php echo svg2('brand-projecthoneypot');?></a>
                        <a class="btn btn-secondary" target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>" data-tooltip="tooltip" title="Lookup IP using IP Address Finder .com (Opens in New Page)." role="button" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><?php echo svg2('search');?></a>
                        <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','whitelist');return false;" data-tooltip="tooltip" title="Purge" aria-label="Purge"><?php svg('purge');?></button>
                      </div>
                    </td>
                  </tr>
<?php }?>
                </tbody>
              </table>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
