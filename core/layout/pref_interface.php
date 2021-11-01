<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Interface
 * @package    core/layout/pref_interface.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('sliders','i-3x');?></div>
          <div>Preferences - Interface</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Interface</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Sidebar Menu</label>
          <div class="tab1-1 border-top p-3" data-tabid="tab1-1" role="tabpanel">
          <?php if($user['rank']>999){?>
            <div class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefDevLock" data-tooltip="tooltip" aria-label="PermaLink to Preferences Developer Lock Checkbox">&#128279;</a>':'';?>
              <input id="prefDevLock" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="17" type="checkbox"<?=$config['options'][17]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configoptions171" for="prefDevLock">Developer Lock Down</label>
            </div>
          <?php }?>
          <div class="row">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefGDPR" data-tooltip="tooltip" aria-label="PermaLink to Preferences GDPR Banner Checkbox">&#128279;</a>':'';?>
            <input id="prefGDPR" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="8" type="checkbox"<?=$config['options'][8]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label id="configoptions81" for="prefGDPR">Display GDPR Banner.</label>
          </div>
          <div class="row">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefPWA" data-tooltip="tooltip" aria-label="PermaLink to Preferences PWA (Progressive Web Application) Checkbox">&#128279;</a>':'';?>
            <input id="prefPWA" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="18" type="checkbox"<?=$config['options'][18]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label id="configoptions181" for="prefPWA">Enable Offline Page (Progressive Web Application).</label>
          </div>
          <?php if($user['rank']>999){?>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefDevMode" data-tooltip="tooltip" aria-label="PermaLink to Preferences Development Mode Checkbox">&#128279;</a>':'';?>
              <input id="prefDevMode" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0" type="checkbox"<?=$config['development'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configdevelopment01" for="prefDevMode">Development Mode</label>
            </div>
          <?php }
          if($user['rank']==1000||$config['options'][17]==0){?>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefComingSoon" data-tooltip="tooltip" aria-label="PermaLink to Preferences Coming Soon Mode Checkbox">&#128279;</a>':'';?>
              <input id="prefComingSoon" data-dbid="1" data-dbt="config" data-dbc="comingsoon" data-dbb="0" type="checkbox"<?=$config['comingsoon'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configcomingsoon01" for="prefComingSoon">Coming Soon Mode</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefMaintenance" data-tooltip="tooltip" aria-label="PermaLink to Preferences Maintenance Mode Checkbox">&#128279;</a>':'';?>
              <input id="prefMaintenance" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0" type="checkbox"<?=$config['maintenance'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configmaintenance01" for="prefMaintenance">Maintenance Mode</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefAdminActivityTracking" data-tooltip="tooltip" aria-label="PermaLink to Preferences Administration Activity Tracking Checkbox">&#128279;</a>':'';?>
              <input id="prefAdminActivityTracking" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="12" type="checkbox"<?=$config['options'][12]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configoptions121" for="prefAdminActivityTracking">Admin Activity Tracking</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefTooltips" data-tooltip="tooltip" aria-label="PermaLink to Preferences Enable Tooltips Checkbox">&#128279;</a>':'';?>
              <input id="prefTooltips" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4" type="checkbox"<?=$config['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?> onchange="$('body').toggleClass('no-tooltip');">
              <label id="configoptions41" for="prefTooltips">Enable Tooltips</label>
            </div>
<?php if($user['rank']==1000){?>
            <div class="row">
              <input id="prefAdminHoster" data-dbid="1" data-dbt="config" data-dbc="hoster" data-dbb="0" type="checkbox"<?=$config['hoster'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="confighoster01" for="prefAdminHoster">Hoster Site, for managing Web Hosting Accounts</label>
            </div>
            <div class="form-row mt-3">
              <label id="prefhosterURL" for="hosterURL">Hoster&nbsp;URL</label>
              <small class="form-text text-right">This is the URL this Website contacts to retreive Hosting Account Information.</small>
            </div>
            <div class="form-row">
              <input class="textinput" id="hosterURL" data-dbid="1" data-dbt="config" data-dbc="hosterURL" type="text" value="<?=$config['hosterURL'];?>" placeholder="Enter a URL...">
              <button class="save" id="savehosterURL" data-dbid="hosterURL" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
<?php }?>
  <?php /* Fix
            <label for="uti_freq">Update Frequency</label>
            <div class="form-row">
              <select class="form-control" id="uti_freq" onchange="update('1','config','uti_freq',$(this).val(),'select');">
                <option value="0"<?=$config['uti_freq']==0?' selected':'';?>>Never</option>
                <option value="3600"<?=$config['uti_freq']==3600?' selected':'';?>>Hourly</option>
                <option value="84600"<?=$config['uti_freq']==84600?' selected':'';?>>Daily</option>
                <option value="604800"<?=$config['uti_freq']==604800?' selected':'';?>>Weekly</option>
                <option value="2629743"<?=$config['uti_freq']==2629743?' selected':'';?>>Monthly</option>
              </select>
              <button onclick="$('#updatecheck').removeClass('hidden').load('core/layout/updatecheck.php');">Check&nbsp;Now</button>
            </div>
            <div id="updatecheck" class="form-row d-none">
              <div class="col alert alert-warning" role="alert"><?= svg2('spinner','animated infinite spin').' Checking for new updates!';?></div>
            </div>
            <label for="update_url">Update URL</label>
            <div class="form-row">
              <input id="update_url" class="textinput" data-dbid="1" data-dbt="config" data-dbc="update_url" type="text" value="<?=$config['update_url'];?>" placeholder="Enter an Update URL...">
              <button class="save" id="saveupdate_url" data-dbid="update_url" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
  */ ?>
            <div class="form-row mt-3">
              <label id="prefIdleTime" for="idleTime"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefIdleTime" data-tooltip="tooltip" aria-label="PermaLink to Preferences Idle Timeout Field">&#128279;</a>':'';?>Idle&nbsp;Timeout</label>
              <small class="form-text text-right">'0' Disables Idle Timeout.</small>
            </div>
            <div class="form-row">
              <input class="textinput" id="idleTime" data-dbid="1" data-dbt="config" data-dbc="idleTime" type="text" value="<?=$config['idleTime'];?>" placeholder="Enter a Time in Minutes...">
              <div class="input-text">Minutes</div>
              <button class="save" id="saveidleTime" data-dbid="idleTime" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
            <div class="form-row mt-3">
              <label id="prefDateFormat" for="dateFormat"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefDateFormat" data-tooltip="tooltip" aria-label="PermaLink to Preferences Date Format Field">&#128279;</a>':'';?>Date/Time&nbsp;Format</label>
              <small class="form-text text-right">For information on Date Format Characters click <a target="_blank" href="https://www.php.net/manual/en/datetime.formats.php">here</a>.</small>
            </div>
            <div class="form-row">
              <input class="textinput" id="dateFormat" data-dbid="1" data-dbt="config" data-dbc="dateFormat" type="text" value="<?=$config['dateFormat'];?>" placeholder="Enter a Date/Time Format...">
              <div class="input-text"><?= date($config['dateFormat'],time());?></div>
              <button class="save" id="savedateFormat" data-dbid="dateFormat" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
            <label id="prefTimezone" for="timezone"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefTimezone" data-tooltip="tooltip" aria-label="PermaLink to Preferences Timezone Selector">&#128279;</a>':'';?>Timezone</label>
            <div class="form-row">
              <select id="timezone" data-dbid="1" data-dbt="config" data-dbc="timezone" onchange="update('1','config','timezone',$(this).val(),'select');">
                <?php function get_timezones(){
                  $o=array();
                  $t_zones=timezone_identifiers_list();
                  foreach($t_zones as$a){
                    $t='';
                    try{
                      $zone=new DateTimeZone($a);
                      $seconds=$zone->getOffset(new DateTime("now",$zone));
                      $hours=sprintf("%+02d",intval($seconds/3600));
                      $minutes=sprintf("%02d",($seconds%3600)/60);
                      $t=$a." [ $hours:$minutes ]" ;
                      $o[$a]=$t;
                    }
                    catch(Exception $e){}
                  }
                  ksort($o);
                  return$o;
                }
                $o=get_timezones();
                foreach($o as$tz=>$label)echo'<option value="'.$tz.'"'.($tz==$config['timezone']?' selected':'').'>'.$tz.'</option>';?>
              </select>
            </div>
          <?php }?>
          </div>
          <div class="tab1-2 border-top p-3" data-tabid="tab1-2" role="tabpanel">
<?php $sm1=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=0 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
$sm1->execute([
  ':r'=>$user['rank']
]);?>
            <table class="table-zebra">
              <thead>
                <tr>
                  <th class="w-5"></th>
                  <th class="col">Title</th>
                  <th class="col-2 text-center">Available To</th>
                  <th class="col-1 text-center">Active</th>
                  <th class="col-1 text-center">Default</th>
                  <th class="col-1 text-center">ReOrder</th>
                </tr>
              </thead>
              <tbody id="sortable">
                <?php while($rm1=$sm1->fetch(PDO::FETCH_ASSOC)){?>
                  <tr class="item subsortable" id="l_<?=$rm1['id'];?>">
                    <td class="px-2 py-0 m-0 text-center">
                      <?php if($rm1['contentType']=='dropdown'){?>
                        <button class="btn-ghost sidebardropdownbtn" data-sdid="<?=$rm1['id'];?>" data-tooltip="tooltip" aria-label="Open/Close Dropdown"><?php svg('chevron-down').svg('chevron-up','d-none');?></button>
                      <?php }?>
                    </td>
                    <td class="pt-2">
                      <?=$rm1['title'];?>
                      <?php $sm2=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=:mid ORDER BY `ord` ASC");
                      $sm2->execute([':mid'=>$rm1['id']]);
                      if($sm2->rowCount()>0){?>
                        <div class="mt-2 d-none" id="sidebardropdown<?=$rm1['id'];?>">
                          <div class="row">
                            <div class="col-12 py-1 bg-dark">
                              <div class="row">
                                <span class="col-7 pl-2 small">Title</span>
                                <span class="col-2 small text-center">Available To</span>
                                <span class="col-1 small text-center">Active</span>
                                <span class="col-2 small text-center">ReOrder</span>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="subsortable_<?=$rm1['id'];?>">
                            <?php while($rm2=$sm2->fetch(PDO::FETCH_ASSOC)){?>
                              <div class="item zebra border-bottom col-12 py-1 position-relative" style="position:relative;" id="l_<?=$rm2['id'];?>">
                                <div class="row">
                                  <span class="col-7 pl-2 pt-1 small">
                                    <?=$rm2['title'];?>
                                  </span>
                                  <span class="col-2 small text-center">
                                    <select class="select-sm" id="rank" data-dbid="<?=$rm2['id'];?>" data-dbt="sidebar" data-dbc="rank"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$rm2['id'];?>','sidebar','rank',$(this).val(),'select');">
                                      <option value="400"<?=$rm2['rank']==400?' selected':'';?>>Contributor</option>
                                      <option value="500"<?=$rm2['rank']==500?' selected':'';?>>Author</option>
                                      <option value="600"<?=$rm2['rank']==600?' selected':'';?>>Editor</option>
                                      <option value="700"<?=$rm2['rank']==700?' selected':'';?>>Moderator</option>
                                      <option value="800"<?=$rm2['rank']==800?' selected':'';?>>Manager</option>
                                      <option value="900"<?=$rm2['rank']==900?' selected':'';?>>Administrator</option>
                                      <?=$user['rank']==1000?'<option value="1000"'.($rm2['rank']==1000?' selected':'').'>Developer</option>':'';?>
                                    </select>
                                  </span>
                                  <span class="col-1 text-center" id="controls_<?=$rm2['id'];?>" role="group">
                                    <input id="active<?=$rm2['id'];?>" data-dbid="<?=$rm2['id'];?>" data-dbt="sidebar" data-dbc="active" data-dbb="0" type="checkbox"<?=($rm2['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                                  </span>
                                  <span class="col-2 text-center">
                                    <?php svg('drag','subhandle');?>
                                  </span>
                                </div>
                              </div>
                            <?php }?>
                            <div class="ghost2 hidden"></div>
                          </div>
                          <?php if($user['options'][1]==1){?>
                            <script>
                              $('#subsortable_<?=$rm1['id'];?>').sortable({
                                items:"div.item",
                                handle:".subhandle",
                                placeholder:".ghost2",
                                helper:fixWidthHelper,
                                axis:"y",
                                update:function(e,ui){
                                  var order=$("#subsortable_<?=$rm1['id'];?>").sortable("serialize");
                                  $.ajax({
                                    type:"POST",
                                    dataType:"json",
                                    url:"core/reordersidebarsub.php",
                                    data:order
                                  });
                                }
                              }).disableSelection();
                              function fixWidthHelper(e,ui){
                                ui.children().each(function(){
                                  $(this).width($(this).width());
                                });
                                return ui;
                              }
                            </script>
                          <?php }
                          }?>
                        </div>
                    </td>
                    <td class="px-2 py-1 text-center">
                      <select class="select-sm" id="rank" data-dbid="<?=$rm1['id'];?>" data-dbt="sidebar" data-dbc="rank"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$rm1['id'];?>','sidebar','rank',$(this).val(),'select');">
                        <option value="400"<?=$rm1['rank']==400?' selected':'';?>>Contributor</option>
                        <option value="500"<?=$rm1['rank']==500?' selected':'';?>>Author</option>
                        <option value="600"<?=$rm1['rank']==600?' selected':'';?>>Editor</option>
                        <option value="700"<?=$rm1['rank']==700?' selected':'';?>>Moderator</option>
                        <option value="800"<?=$rm1['rank']==800?' selected':'';?>>Manager</option>
                        <option value="900"<?=$rm1['rank']==900?' selected':'';?>>Administrator</option>
                        <?=$user['rank']==1000?'<option value="1000"'.($rm1['rank']==1000?' selected':'').'>Developer</option>':'';?>
                      </select>
                    </td>
                    <td class="px-2 py-1 text-center">
                      <?php if($rm1['contentType']!='dashboard'){?>
                        <input id="active<?=$rm1['id'];?>" data-dbid="<?=$rm1['id'];?>" data-dbt="sidebar" data-dbc="active" data-dbb="0" type="checkbox"<?=($rm1['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <?php }?>
                    </td>
                    <td class="px-2 py-1 text-center">
                      <input class="defaultPage" id="default<?=$rm1['id'];?>" data-default="<?=$rm1['view'];?>" type="radio" name="default[]"<?=($config['defaultPage']==$rm1['view']?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    </td>
                    <td class="px-2 py-1 text-center">
                      <?php if($rm1['contentType']!='dashboard'){?>
                        <?= svg('drag','orderhandle');?>
                      <?php }?>
                    </td>
                  </tr>
                <?php }?>
                <tr class="ghost hidden">
                  <td colspan="3">&nbsp;</td>
                </tr>
              </tbody>
            </table>
            <?php if($user['options'][1]==1){?>
              <script>
                $('#sortable').sortable({
                  items:"tr.item",
                  handle:'.orderhandle',
                  placeholder:".ghost",
                  helper:fixWidthHelper,
                  axis:"y",
                  update:function(e,ui){
                    var order=$("#sortable").sortable("serialize");
                    $.ajax({
                      type:"POST",
                      dataType:"json",
                      url:"core/reordersidebar.php",
                      data:order
                    });
                  }
                }).disableSelection();
                function fixWidthHelper(e,ui){
                  ui.children().each(function(){
                    $(this).width($(this).width());
                  });
                  return ui;
                }
              </script>
            <?php }?>
          </div>
        </div>
<?php   require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
