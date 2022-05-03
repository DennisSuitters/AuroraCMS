<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Forum
 * @package    core/layout/set_forum.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">forum</i></div>
          <div>Forum Settings</div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="tooltip" aria-label="Back"><i class="i">back</i></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><i class="i">save</i></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/forum';?>">Forum</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <legend id="forumNotifications"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/forum/settings#forumNotifications" data-tooltip="tooltip" aria-label="PermaLink to Forum Notifcations Section">&#128279;</a>':'';?>Forum Notifications</legend>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/forum/settings#forumEnableHelpNotifications" data-tooltip="tooltip" aria-label="PermaLink to Enable Forum Email Notifications Checkbox">&#128279;</a>':'';?>
          <input id="helpTicketEmailNotifications" data-dbid="1" data-dbt="config" data-dbc="forumOptions" data-dbb="0" type="checkbox"<?=$config['forumOptions'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="helpTicketEmailNotifications" id="helpTicketEmailNotifications0">Help Ticket Email Notifications</label>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
