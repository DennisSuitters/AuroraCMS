<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Interface
 * @package    core/layout/pref_interface.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid p-2">
      <div class="card mt-3 p-4 border-radius-0 bg-white border-0 shadow overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
                <li class="breadcrumb-item active">Interface</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Sidebar Menu</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Widgets</label>
          <div class="tab1-1 border-top p-4" data-tabid="tab1-1" role="tabpanel">
          <?php if($user['rank']>999){?>
            <div class="row">
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
              <input id="prefDevMode" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0" type="checkbox"<?=$config['development']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configdevelopment01" for="prefDevMode">Development Mode</label>
            </div>
          <?php }
          if($user['rank']==1000||$config['options'][17]==0){?>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefComingSoon" data-tooltip="tooltip" aria-label="PermaLink to Preferences Coming Soon Mode Checkbox">&#128279;</a>':'';?>
              <input id="prefComingSoon" data-dbid="1" data-dbt="config" data-dbc="comingsoon" data-dbb="0" type="checkbox"<?=$config['comingsoon']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configcomingsoon01" for="prefComingSoon">Coming Soon Mode</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefMaintenance" data-tooltip="tooltip" aria-label="PermaLink to Preferences Maintenance Mode Checkbox">&#128279;</a>':'';?>
              <input id="prefMaintenance" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0" type="checkbox"<?=$config['maintenance']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
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
            <div class="form-row mt-3">
              <label id="prefhosterURL" for="hosterURL">Google&nbsp;Data&nbsp;API&nbsp;Key</label>
              <small class="form-text text-right">This existing key belongs to AuroraCMS, but can be changed if you want to use a private key. This key works for YouTubeAPI3.</small>
            </div>
            <div class="form-row">
              <input class="textinput" id="gd_api" data-dbid="1" data-dbt="config" data-dbc="gd_api" type="text" value="<?=$config['gd_api'];?>" placeholder="Enter a Google Data API Key...">
              <button class="save" id="savegd_api" data-dbid="gd_api" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
<?php if($user['rank']==1000){?>
            <div class="row mt-3">
              <input id="prefAdminHoster" data-dbid="1" data-dbt="config" data-dbc="hoster" data-dbb="0" type="checkbox"<?=$config['hoster']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="confighoster01" for="prefAdminHoster">Hoster Site, for managing Web Hosting Accounts</label>
            </div>
            <div class="form-row mt-3">
              <label id="prefhosterURL" for="hosterURL">Hoster&nbsp;URL</label>
              <small class="form-text text-right">This is the URL this Website contacts to retreive Hosting Account Information.</small>
            </div>
            <div class="form-row">
              <input class="textinput" id="hosterURL" data-dbid="1" data-dbt="config" data-dbc="hosterURL" type="text" value="<?=$config['hosterURL'];?>" placeholder="Enter a URL...">
              <button class="save" id="savehosterURL" data-dbid="hosterURL" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
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
              <div class="col alert alert-warning" role="alert"><i class="i animated infinite spin">spinner</i> Checking for new updates!';?></div>
            </div>
            <label for="update_url">Update URL</label>
            <div class="form-row">
              <input id="update_url" class="textinput" data-dbid="1" data-dbt="config" data-dbc="update_url" type="text" value="<?=$config['update_url'];?>" placeholder="Enter an Update URL...">
              <button class="save" id="saveupdate_url" data-dbid="update_url" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
  */ ?>
            <div class="form-row mt-3">
              <label id="prefIdleTime" for="idleTime"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefIdleTime" data-tooltip="tooltip" aria-label="PermaLink to Preferences Idle Timeout Field">&#128279;</a>':'';?>Idle&nbsp;Timeout</label>
              <small class="form-text text-right">'0' Disables Idle Timeout.</small>
            </div>
            <div class="form-row">
              <input class="textinput" id="idleTime" data-dbid="1" data-dbt="config" data-dbc="idleTime" type="text" value="<?=$config['idleTime'];?>" placeholder="Enter a Time in Minutes...">
              <div class="input-text">Minutes</div>
              <button class="save" id="saveidleTime" data-dbid="idleTime" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
            </div>
            <div class="form-row mt-3">
              <label id="prefDateFormat" for="dateFormat"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefDateFormat" data-tooltip="tooltip" aria-label="PermaLink to Preferences Date Format Field">&#128279;</a>':'';?>Date/Time&nbsp;Format</label>
            </div>
            <div class="form-row">
              <input class="textinput" id="dateFormat" data-dbid="1" data-dbt="config" data-dbc="dateFormat" type="text" value="<?=$config['dateFormat'];?>" placeholder="Enter a Date/Time Format...">
              <div class="input-text"><?= date($config['dateFormat'],time());?></div>
              <button class="save" id="savedateFormat" data-dbid="dateFormat" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
              <button onclick="$('#dateFormats,.datedisp').toggleClass('d-none');" data-tooltip="tooltip" aria-label="Date Format Options"><i class="i datedisp">chevron-down</i><i class="i datedisp d-none">chevron-up</i></button>
            </div>
            <div class="form-row mt-0 d-none" id="dateFormats">
              <table class="table border">
                <thead>
                  <tr class="bg-light">
                    <th>Format character</th>
                    <th>Description</th>
                    <th>Example returned values</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="bg-light">
                    <td colspan="3" class="text-center"><strong>Day</strong></td>
                  </tr>
                  <tr>
                    <td><i>d</i></td>
                    <td>Day of the month, 2 digits with leading zeros</td>
                    <td><i>01</i> to <i>31</i></td>
                  </tr>
                  <tr>
                    <td><i>D</i></td>
                    <td>A textual representation of a day, three letters</td>
                    <td><i>Mon</i> through <i>Sun</i></td>
                  </tr>
                  <tr>
                    <td><i>j</i></td>
                    <td>Day of the month without leading zeros</td>
                    <td><i>1</i> to <i>31</i></td>
                  </tr>
                  <tr>
                    <td><i>l</i> (lowercase ‘L’)</td>
                    <td>A full textual representation of the day of the week</td>
                    <td><i>Sunday</i> through <i>Saturday</i></td>
                  </tr>
                  <tr>
                    <td><i>N</i></td>
                    <td>ISO-8601 numeric representation of the day of the week.</td>
                    <td><i>1</i> (for Monday) through <i>7</i> (for Sunday)</td>
                  </tr>
                  <tr>
                    <td><i>S</i></td>
                    <td>English ordinal suffix for the day of the month, 2 characters</td>
                    <td><i>st</i>, <i>nd</i>, <i>rd</i> or<br><i>th</i>.  Works well with <i>j</i></td>
                  </tr>
                  <tr>
                    <td><i>w</i></td>
                    <td>Numeric representation of the day of the week</td>
                    <td><i>0</i> (for Sunday) through <i>6</i> (for Saturday)</td>
                  </tr>
                  <tr>
                    <td><i>z</i></td>
                    <td>The day of the year (starting from 0)</td>
                    <td><i>0</i> through <i>365</i></td>
                  </tr>
                  <tr class="bg-light">
                    <td colspan="3" class="text-center"><strong>Week</strong></td>
                  </tr>
                  <tr>
                    <td><i>W</i></td>
                    <td>ISO-8601 week number of year, weeks starting on Monday (added in PHP  4.1.0)</td>
                    <td>Example: <i>42</i> (the 42nd week in the year)</td>
                  </tr>
                  <tr class="bg-light">
                    <td colspan="3" class="text-center"><strong>Month</strong></td>
                  </tr>
                  <tr>
                    <td><i>F</i></td>
                    <td>A full textual representation of a month, such as January or March</td>
                    <td><i>January</i> through <i>December</i></td>
                  </tr>
                  <tr>
                    <td><i>m</i></td>
                    <td>Numeric representation of a month, with leading zeros</td>
                    <td><i>01</i> through <i>12</i></td>
                  </tr>
                  <tr>
                    <td><i>M</i></td>
                    <td>A short textual representation of a month, three letters</td>
                    <td><i>Jan</i> through <i>Dec</i></td>
                  </tr>
                  <tr>
                    <td><i>n</i></td>
                    <td>Numeric representation of a month, without leading zeros</td>
                    <td><i>1</i> through <i>12</i></td>
                  </tr>
                  <tr>
                    <td><i>t</i></td>
                    <td>Number of days in the given month</td>
                    <td><i>28</i> through <i>31</i></td>
                  </tr>
                  <tr class="bg-light">
                    <td colspan="3" class="text-center"><strong>Year</strong></td>
                  </tr>
                  <tr>
                    <td><i>L</i></td>
                    <td>Whether it’s a leap year</td>
                    <td><i>1</i> if it is a leap year, <i>0</i> otherwise.</td>
                  </tr>
                  <tr>
                    <td><i>o</i></td>
                    <td>ISO-8601 year number. This has the same value as<br>
                      <i>Y</i>, except that if the ISO week number<br>
                      (<i>W</i>) belongs to the previous or next year, that year<br>
                      is used instead. (added in PHP 5.1.0)</td>
                    <td>Examples: <i>1999</i> or <i>2003</i></td>
                  </tr>
                  <tr>
                    <td><i>Y</i></td>
                    <td>A full numeric representation of a year, 4 digits</td>
                    <td>Examples: <i>1999</i> or <i>2003</i></td>
                  </tr>
                  <tr>
                    <td><i>y</i></td>
                    <td>A two digit representation of a year</td>
                    <td>Examples: <i>99</i> or <i>03</i></td>
                  </tr>
                  <tr class="bg-light">
                    <td colspan="3" class="text-center"><strong>Time</strong></td>
                  </tr>
                  <tr>
                    <td><i>a</i></td>
                    <td>Lowercase Ante meridiem and Post meridiem</td>
                    <td><i>am</i> or <i>pm</i></td>
                  </tr>
                  <tr>
                    <td><i>A</i></td>
                    <td>Uppercase Ante meridiem and Post meridiem</td>
                    <td><i>AM</i> or <i>PM</i></td>
                  </tr>
                  <tr>
                    <td><i>B</i></td>
                    <td>Swatch Internet time</td>
                    <td><i>000</i> through <i>999</i></td>
                  </tr>
                  <tr>
                    <td><i>g</i></td>
                    <td>12-hour format of an hour without leading zeros</td>
                    <td><i>1</i> through <i>12</i></td>
                  </tr>
                  <tr>
                    <td><i>G</i></td>
                    <td>24-hour format of an hour without leading zeros</td>
                    <td><i>0</i> through <i>23</i></td>
                  </tr>
                  <tr>
                    <td><i>h</i></td>
                    <td>12-hour format of an hour with leading zeros</td>
                    <td><i>01</i> through <i>12</i></td>
                  </tr>
                  <tr>
                    <td><i>H</i></td>
                    <td>24-hour format of an hour with leading zeros</td>
                    <td><i>00</i> through <i>23</i></td>
                  </tr>
                  <tr>
                    <td><i>i</i></td>
                    <td>Minutes with leading zeros</td>
                    <td><i>00</i> to <i>59</i></td>
                  </tr>
                  <tr>
                    <td><i>s</i></td>
                    <td>Seconds, with leading zeros</td>
                    <td><i>00</i> through <i>59</i></td>
                  </tr>
                  <tr>
                    <td><i>u</i></td>
                    <td>Microseconds (added in PHP 5.2.2)</td>
                    <td>Example: <i>654321</i></td>
                  </tr>
                  <tr class="bg-light">
                    <td colspan="3" class="text-center"><strong>Timezone</strong></td>
                  </tr>
                  <tr>
                    <td><i>e</i></td>
                    <td>Timezone identifier (added in PHP 5.1.0)</td>
                    <td>Examples: <i>UTC</i>, <i>GMT</i>, <i>Atlantic/Azores</i></td>
                  </tr>
                  <tr>
                    <td><i>I</i> (capital i)</td>
                    <td>Whether or not the date is in daylight saving time</td>
                    <td><i>1</i> if Daylight Saving Time, <i>0</i> otherwise.</td>
                  </tr>
                  <tr>
                    <td><i>O</i></td>
                    <td>Difference to Greenwich time (GMT) in hours</td>
                    <td>Example: <i>+0200</i></td>
                  </tr>
                  <tr>
                    <td><i>P</i></td>
                    <td>Difference to Greenwich time (GMT) with colon between hours and minutes (added in PHP 5.1.3)</td>
                    <td>Example: <i>+02:00</i></td>
                  </tr>
                  <tr>
                    <td><i>T</i></td>
                    <td>Timezone abbreviation</td>
                    <td>Examples: <i>EST</i>, <i>MDT</i> …</td>
                  </tr>
                  <tr>
                    <td><i>Z</i></td>
                    <td>Timezone offset in seconds. The offset for timezones west of UTC is always<br>
                    negative, and for those east of UTC is always positive.</td>
                    <td><i>-43200</i> through <i>50400</i></td>
                  </tr>
                  <tr class="bg-light">
                    <td colspan="3" class="text-center"><strong>Full Date/Time</strong></td>
                  </tr>
                  <tr>
                    <td><i>c</i></td>
                    <td>ISO 8601 date (added in PHP 5)</td>
                    <td>2004-02-12T15:19:21+00:00</td>
                  </tr>
                  <tr>
                    <td><i>r</i></td>
                    <td><a class="link external" href="http://www.faqs.org/rfcs/rfc2822" rel="noopener">» RFC 2822</a> formatted date</td>
                    <td>Example: <i>Thu, 21 Dec 2000 16:01:07 +0200</i></td>
                  </tr>
                  <tr>
                    <td><i>U</i></td>
                    <td>Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)</td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>
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
          <div class="tab1-2 border-top p-4" data-tabid="tab1-2" role="tabpanel">
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
                        <button class="btn-ghost sidebardropdownbtn" data-sdid="<?=$rm1['id'];?>" data-tooltip="tooltip" aria-label="Open/Close Dropdown"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>
                      <?php }?>
                    </td>
                    <td class="pt-2">
                      <?=$rm1['title'];?>
                      <?php $sm2=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=:mid ORDER BY `ord` ASC");
                      $sm2->execute([':mid'=>$rm1['id']]);
                      if($sm2->rowCount()>0){?>
                        <div class="mt-2 d-none" id="sidebardropdown<?=$rm1['id'];?>">
                          <div class="row">
                            <div class="col-12 py-1">
                              <div class="row">
                                <strong class="col-7 pl-2 small">Title</strong>
                                <strong class="col-2 small text-center">Available To</strong>
                                <strong class="col-1 small text-center">Active</strong>
                                <strong class="col-2 small text-center">ReOrder</strong>
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
                                    <i class="i subhandle">drag</i>
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
                        <i class="i orderhandle">drag</i>
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
          <div class="tab1-3 border-top p-4" data-tabid="tab1-3" role="tabpanel">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center align-middle">Enable</th>
                  <th class="align-middle">Interface</th>
                  <th class="align-middle">Widget Title</th>
                </tr>
              </thead>
              <tbody>
<?php $sw=$db->prepare("SELECT * FROM `".$prefix."widgets` ORDER BY `ref` ASC, `ord` ASC");
$sw->execute();
while($rw=$sw->fetch(PDO::FETCH_ASSOC)){?>
            <tr>
              <td class="text-center align-middle">
                <input id="widget<?=$rw['id'];?>" data-dbid="<?=$rw['id'];?>" data-dbt="widgets" data-dbc="active" data-dbb="0" type="checkbox"<?=$rw['active']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              </td>
              <td class="align-middle"><?= ucfirst($rw['ref']);?></td>
              <td class="align-middle"><?=$rw['title'];?></td>
            </tr>
<?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php   require'core/layout/footer.php';?>
    </div>
  </section>
</main>
