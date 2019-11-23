<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Database
 * @package    core/layout/pref_database.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Database</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <legend>Database Options</legend>
        <form target="sp" method="post" action="core/changeprefix.php">
          <div class="form-group row">
            <label for="prefix" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Table Prefix</label>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <input type="text" id="prefix" class="form-control textinput" name="dbprefix" value="<?php echo$prefix;?>" placeholder="Enter a Table Prefix...">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary" onclick="$('body').append('<div id=blocker><div></div></div>');">Update</button>
              </div>
            </div>
          </div>
        </form>
        <legend>Database Backup/Restore</legend>
        <div id="backup" name="backup">
          <div id="backup_info">
<?php $tid=$ti-2592000;
if($config['backup_ti']<$tid)
  echo$config['backup_ti']==0?'<div class="alert alert-info" role="alert">A Backup has yet to be performed.</div>':'<div class="alert alert-danger" role="alert">It has been more than 30 days since a Backup has been performed.</div>';?>
          </div>
          <form target="sp" method="post" action="core/backup.php">
            <div class="form-group row">
              <label class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Backup</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <button type="submit" class="btn btn-secondary btn-block">Perform Backup</button>
              </div>
            </div>
          </form>
          <div id="backups" class="form-group">
<?php foreach(glob("media".DS."backup".DS."*") as$file){
  $filename=basename($file);
  $filename=rtrim($filename,'.sql.gz');?>
            <div id="l_<?php echo$filename;?>" class="form-group row">
              <div class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2"></div>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <a class="btn btn-secondary col" href="<?php echo$file;?>">Click to Download <?php echo ltrim($file,'media'.DS.'backup'.DS);?></a>
                <div class="input-group-append">
                  <button class="btn btn-secondary trash" onclick="removeBackup('<?php echo$filename;?>')" aria-label="Delete"><?php svg('trash');?></button>
                </div>
              </div>
            </div>
<?php }?>
          </div>
          <form target="sp" method="post" enctype="multipart/form-data" action="core/restorebackup.php">
            <div class="form-group row">
              <label class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Restore</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="custom-file col">
                  <input id="restorefu" type="file" class="custom-file-input" name="fu" accept="application/sql">
                  <label class="custom-file-label" for="resturefu">Choose File</label>
                </div>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary">Restore</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
