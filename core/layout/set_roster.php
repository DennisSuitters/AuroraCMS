<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Roster
 * @package    core/layout/set_roster.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id` IN ('32','40')")->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/roster';?>">Roster</a></li>
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group d-inline">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <div class="tab1-1 border p-3">
            <div class="row">
              <div class="col-12 col-sm">
                <label for="rosterExtraShifts">Display Extra Shifts</label>
                <div class="form-row">
                  <select id="rosterExtraShifts" data-dbid="1" data-dbt="login" data-dbc="rosterExtraShifts"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`rosterExtraShifts`,$(this).val(),`select`);"':' disabled';?>>
                    <option value="true"<?=($config['rosterExtraShifts']=='true'?' selected':'');?>>Yes</option>
                    <option value="false"<?=($config['rosterExtraShifts']=='false'?' selected':'');?>>No</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-sm pl-sm-3">
                <label for="rosterDayName">Display Day Name</label>
                <div class="form-row">
                  <select id="rosterDayName" data-dbid="1" data-dbt="login" data-dbc="rosterDayName"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`rosterDayName`,$(this).val(),`select`);"':' disabled';?>>
                    <option value="l"<?=($config['rosterDayName']=='l'?' selected':'');?>>Fullname (<?=date('l',time());?>)</option>
                    <option value="D"<?=($config['rosterDayName']=='D'?' selected':'');?>>Short name (<?=date('D',time());?>)</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-sm pl-sm-3">
                <label for="rosterTimeDisplay">Display Times as</label>
                <div class="form-row">
                  <select id="rosterTimeDisplay" data-dbid="1" data-dbt="login" data-dbc="rosterTimeDisplay"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`rosterTimeDisplay`,$(this).val(),`select`);"':' disabled';?>>
                    <option value="H:i"<?=($config['rosterTimeDisplay']=='H:i'?' selected':'');?>>24-hour Format (<?=date('H:i',time());?>)</option>
                    <option value="g:ia"<?=($config['rosterTimeDisplay']=='g:ia'?' selected':'');?>>12-hour Format (<?=date('g:ia',time());?>)</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-sm pl-sm-3">
                <label for="rosterShowWeeks">Number of Weeks to Show</label>
                <div class="form-row">
                  <select id="rosterShowWeeks" data-dbid="1" data-dbt="login" data-dbc="rosterShowWeeks"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`rosterShowWeeks`,$(this).val(),`select`);"':' disabled';?>>
                    <option value="1"<?=($user['rosterShowWeeks']=='1'?' selected':'');?>>1 Week</option>
                    <option value="2"<?=($user['rosterShowWeeks']=='2'?' selected':'');?>>2 Weeks</option>
                    <option value="4"<?=($user['rosterShowWeeks']=='4'?' selected':'');?>>4 Weeks</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
