<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Database
 * @package    core/layout/pref_database.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('database','i-3x');?></div>
          <div>Preferences - Database</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Database</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <legend id="databaseOptions"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/security#databaseOptions" aria-label="PermaLink to Preferences Database Options">&#128279;</a>':'';?>Database Options</legend>
        <form target="sp" method="post" action="core/changeprefix.php">
          <label id="tablePrefix" for="prefix"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/security#tablePrefix" aria-label="PermaLink to Database Table Prefix Field">&#128279;</a>':'';?>Table Prefix</label>
          <div class="form-row">
            <input class="textinput" id="prefix" name="dbprefix" type="text" value="<?=$prefix;?>" placeholder="Enter a Table Prefix...">
            <button type="submit" onclick="$('body').append('<div id=blocker><div></div></div>');">Update</button>
          </div>
        </form>
        <legend id="databaseBackupSection" class="mt-3"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/preferences/security#databaseBackupSection" aria-label="PermaLink to Preferences Database Backup/Restore">&#128279;</a>':'';?>Database Backup/Restore</legend>
        <div id="backup" name="backup">
          <div id="backup_info">
            <?php $tid=$ti-2592000;
            if($config['backup_ti']<$tid)echo$config['backup_ti']==0?'<div class="alert alert-info" role="alert">A Backup has yet to be performed.</div>':'<div class="alert alert-danger" role="alert">It has been more than 30 days since a Backup has been performed.</div>';?>
          </div>
          <form target="sp" method="post" action="core/backup.php">
            <div class="form-row">
              <label>Backup</label>
              <small class="form-text text-right">Note: Only the database is backed up.</text>
            </div>
            <div class="form-row">
              <button class="btn-block saveall" type="submit">Perform Backup</button>
            </div>
          </form>
          <div id="backups">
            <?php foreach(glob("media/backup/*") as$file){
              $filename=basename($file);
              $filename=rtrim($filename,'.sql.gz');?>
              <div id="l_<?=$filename;?>" class="form-row mt-1">
                <a class="btn col-12" href="<?=$file;?>">Click to Download <?= ltrim($file,'media/backup/');?></a>
                <button class="trash" aria-label="Delete" onclick="removeBackup('<?=$filename;?>');"><?= svg2('trash');?></button>
              </div>
            <?php }?>
          </div>
          <form target="sp" method="post" enctype="multipart/form-data" action="core/restorebackup.php">
            <label>Restore</label>
            <div class="form-row">
              <input class="custom-file-input" id="restorefu" type="file" name="fu" accept="application/sql">
              <button type="submit">Restore</button>
            </div>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
