<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Interface
 * @package    core/layout/pref_interface.php
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
          <div class="content-title-icon"><?php svg('sliders','i-3x');?></div>
          <div>Preferences - Interface</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Interface</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <?php if($user['rank']>999){?>
          <div class="row mt-3">
            <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefDevLock" aria-label="PermaLink to Preferences Developer Lock Checkbox">&#128279;</a>':'';?>
            <input id="prefDevLock" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="17" type="checkbox"<?php echo$config['options'][17]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="prefDevLock">Developer Lock Down</label>
          </div>
        <?php }?>
        <div class="row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefGDPR" aria-label="PermaLink to Preferences GDPR Banner Checkbox">&#128279;</a>':'';?>
          <input id="prefGDPR" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="8" type="checkbox"<?php echo$config['options'][8]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="prefGDPR">Display GDPR Banner.</label>
        </div>
        <div class="row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefPWA" aria-label="PermaLink to Preferences PWA (Progressive Web Application) Checkbox">&#128279;</a>':'';?>
          <input id="prefPWA" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="18" type="checkbox"<?php echo$config['options'][18]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="prefPWA">Enable Offline Page (Progressive Web Application).</label>
        </div>
        <?php if($user['rank']>999){?>
          <div class="row">
            <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefDevMode" aria-label="PermaLink to Preferences Development Mode Checkbox">&#128279;</a>':'';?>
            <input id="prefDevMode" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0" type="checkbox"<?php echo$config['development'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="prefDevMode">Development Mode</label>
          </div>
        <?php }
        if($user['rank']==1000||$config['options'][17]==0){?>
          <div class="row">
            <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefComingSoon" aria-label="PermaLink to Preferences Coming Soon Mode Checkbox">&#128279;</a>':'';?>
            <input id="prefComingSoon" data-dbid="1" data-dbt="config" data-dbc="comingsoon" data-dbb="0" type="checkbox"<?php echo$config['comingsoon'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="prefComingSoon">Coming Soon Mode</label>
          </div>
          <div class="row">
            <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefMaintenance" aria-label="PermaLink to Preferences Maintenance Mode Checkbox">&#128279;</a>':'';?>
            <input id="prefMaintenance" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0" type="checkbox"<?php echo$config['maintenance'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="prefMaintenance">Maintenance Mode</label>
          </div>
          <div class="row">
            <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefAdminActivityTracking" aria-label="PermaLink to Preferences Administration Activity Tracking Checkbox">&#128279;</a>':'';?>
            <input id="prefAdminActivityTracking" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="12" type="checkbox"<?php echo$config['options'][12]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="prefAdminActivityTracking">Admin Activity Tracking</label>
          </div>
          <div class="row">
            <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefTooltips" aria-label="PermaLink to Preferences Enable Tooltips Checkbox">&#128279;</a>':'';?>
            <input id="prefTooltips" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4" type="checkbox"<?php echo$config['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="prefTooltips">Enable Tooltips</label>
          </div>
          <div class="row">
            <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefAssitant" aria-label="PermaLink to Preferences Enable Assitanct Checkbox">&#128279;</a>':'';?>
            <input id="prefAssitant" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="28" type="checkbox"<?php echo$config['options'][28]==1?' checked aria-checked="true"':' aria-checked="false"';?> onchange="toggleAssistant();">
            <label for="prefAssistant">Enable&nbsp;<select class="col-2 p-0" onchange="update('1','config','seoKeywords',$(this).val());">
              <option value="Clippy"<?php echo$config['seoKeywords']=='Clippy'?' selected':'';?>>Clippy</option>
              <option value="Genius"<?php echo$config['seoKeywords']=='Genius'?' selected':'';?>>Genius</option>
              <option value="Links"<?php echo$config['seoKeywords']=='Links'?' selected':'';?>>Links</option>
              <option value="Merlin"<?php echo$config['seoKeywords']=='Merlin'?' selected':'';?>>Merlin</option>
            </select>&nbsp;Assistant</label>
          </div>
          <script>
            function toggleAssistant(){
              if($('#options28').is(':checked') === false) {
                clippy.load('Clippy', function(agent){
                  agent.play("Goodbye");
                });
              }
              if($('#options28').is(':checked') === true) {
                clippy.load('Clippy', function(agent){
                  agent.show();
                  agent.play("Greeting");
                });
              }
            }
          </script>
<?php /* Fix
          <label for="uti_freq">Update Frequency</label>
          <div class="form-row">
            <select class="form-control" id="uti_freq" onchange="update('1','config','uti_freq',$(this).val());">
              <option value="0"<?php echo$config['uti_freq']==0?' selected':'';?>>Never</option>
              <option value="3600"<?php echo$config['uti_freq']==3600?' selected':'';?>>Hourly</option>
              <option value="84600"<?php echo$config['uti_freq']==84600?' selected':'';?>>Daily</option>
              <option value="604800"<?php echo$config['uti_freq']==604800?' selected':'';?>>Weekly</option>
              <option value="2629743"<?php echo$config['uti_freq']==2629743?' selected':'';?>>Monthly</option>
            </select>
            <button onclick="$('#updatecheck').removeClass('hidden').load('core/layout/updatecheck.php');">Check&nbsp;Now</button>
          </div>
          <div id="updatecheck" class="form-row d-none">
            <div class="col alert alert-warning" role="alert"><?php svg('spinner','animated infinite spin').' Checking for new updates!';?></div>
          </div>
          <label for="update_url">Update URL</label>
          <div class="form-row">
            <input id="update_url" class="textinput" data-dbid="1" data-dbt="config" data-dbc="update_url" type="text" value="<?php echo$config['update_url'];?>" placeholder="Enter an Update URL...">
            <button class="save" id="saveupdate_url" data-tooltip="tooltip" data-dbid="update_url" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
          </div>
*/ ?>
          <div class="form-row mt-3">
            <label id="prefIdleTime" for="idleTime"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefIdleTime" aria-label="PermaLink to Preferences Idle Timeout Field">&#128279;</a>':'';?>Idle&nbsp;Timeout</label>
            <small class="form-text text-right">'0' Disables Idle Timeout.</small>
          </div>
          <div class="form-row">
            <input class="textinput" id="idleTime" data-dbid="1" data-dbt="config" data-dbc="idleTime" type="text" value="<?php echo$config['idleTime'];?>" placeholder="Enter a Time in Minutes...">
            <div class="input-text">Minutes</div>
            <button class="save" id="saveidleTime" data-tooltip="tooltip" data-dbid="idleTime" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
          </div>
          <div class="form-row mt-3">
            <label id="prefDateFormat" for="dateFormat"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefDateFormat" aria-label="PermaLink to Preferences Date Format Field">&#128279;</a>':'';?>Date/Time&nbsp;Format</label>
            <small class="form-text text-right">For information on Date Format Characters click <a target="_blank" href="http://php.net/manual/en/function.date.php#refsect1-function.date-parameters">here</a>.</small>
          </div>
          <div class="form-row">
            <input class="textinput" id="dateFormat" data-dbid="1" data-dbt="config" data-dbc="dateFormat" type="text" value="<?php echo$config['dateFormat'];?>" placeholder="Enter a Date/Time Format...">
            <div class="input-text"><?php echo date($config['dateFormat'],time());?></div>
            <button class="save" id="savedateFormat" data-tooltip="tooltip" data-dbid="dateFormat" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
          </div>
          <label id="prefTimezone" for="timezone"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefTimezone" aria-label="PermaLink to Preferences Timezone Selector">&#128279;</a>':'';?>Timezone</label>
          <div class="form-row">
            <select id="timezone" data-dbid="1" data-dbt="config" data-dbc="timezone" onchange="update('1','config','timezone',$(this).val());">
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
              foreach($o as$tz=>$label)echo'<option value="'.$tz.'"'.($tz==$config['timezone']?' selected="selected"':'').'>'.$tz.'</option>';?>
            </select>
          </div>
        <?php }?>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
