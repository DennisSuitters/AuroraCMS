<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Database
 * @package    core/layout/database.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='52'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 mt-3 pl-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
            <li class="breadcrumb-item active">Database</li>
          </ol>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">Options</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Export</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Restore</label>
<?php /* Options */ ?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <form target="sp" method="post" action="core/changeprefix.php">
              <label class="mt-0" for="prefix">Table Prefix</label>
              <div class="form-row">
                <input class="textinput" id="prefix" name="dbprefix" type="text" value="<?=$prefix;?>"<?=($user['options'][7]==1?' placeholder="Enter a Table Prefix..."':' disabled');?>>
                <?=($user['options'][7]==1?'<button type="submit" onclick="$(`body`).append(`<div id=blocker><div></div></div>`);">Update</button>':'');?>
              </div>
            </form>
          </div>
<?php /* Export */ ?>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <legend class="mt-0">Database Export</legend>
            <div id="backup" name="backup">
              <div id="backup_info">
                <?php $tid=$ti-2592000;
                if($config['backup_ti']<$tid)echo$config['backup_ti']==0?'<div class="alert alert-info" role="alert">A Backup has yet to be performed.</div>':'<div class="alert alert-danger" role="alert">It has been more than 30 days since a Backup has been performed.</div>';?>
              </div>
              <form target="sp" method="post" action="core/backup.php" onsubmit="$('.page-block').addClass('d-block');">
                <div class="form-row">
                  <label>Backup</label>
                </div>
                <?=($user['options'][7]==1?'<div class="form-text">Note: Only the database is backed up.</div>':'');?>
                <div class="form-row">
                  <?=($user['options'][7]==1?'<button class="btn-block" type="submit">Perform Backup</button>':'');?>
                </div>
              </form>
            </div>
            <?php if($user['options'][7]==1){?>
              <hr>
              <legend>Export Accounts Information</legend>
              <form class="row" target="sp" method="post" action="core/export_accounts.php">
                <div class="col-4 exports" style="display:none;">
                  <div class="mt-5">
                    <div class="form-row">
                      <input id="exportID" type="checkbox" name="id" value="1" checked>
                      <label for="exportID">ID</label>
                    </div>
                    <div class="form-row">
                      <input id="exportActive" type="checkbox" name="act" value="1" checked>
                      <label for="act">Active Account</label>
                    </div>
                    <div class="form-row">
                      <input id="exportDate" type="checkbox" name="dte" value="1" checked>
                      <label for="exportDate">Date</label>
                    </div>
                    <div class="form-row">
                      <input id="exportRank" type="checkbox" name="rnk" value="1" checked>
                      <label for="exportRank">Rank</label>
                    </div>
                    <div class="form-row">
                      <input id="exportUsername" type="checkbox" name="usr" value="1" checked>
                      <label for="exportUsername">Username</label>
                    </div>
                    <div class="form-row">
                      <input id="exportName" type="checkbox" name="nme" value="1" checked>
                      <label for="exportName">Name</label>
                    </div>
                    <div class="form-row">
                      <input id="exportEmail" type="checkbox" name="eml" value="1" checked>
                      <label for="exportEmail">Email</label>
                    </div>
                    <div class="form-row">
                      <input id="exportPhone" type="checkbox" name="phn" value="1" checked>
                      <label for="exportPhone">Phone</label>
                    </div>
                    <div class="form-row">
                      <input id="exportMobile" type="checkbox" name="mob" value="1" checked>
                      <label for="exportMobile">Mobile</label>
                    </div>
                    <div class="form-row">
                      <input id="exportWebsite" type="checkbox" name="url" value="1" checked>
                      <label for="exportWebsite">Website</label>
                    </div>
                    <div class="form-row">
                      <input id="exportBusiness" type="checkbox" name="bus" value="1" checked>
                      <label for="exportBusiness">Business</label>
                    </div>
                    <div class="form-row">
                      <input id="exportABN" type="checkbox" name="abn" value="1" checked>
                      <label for="exportABN">ABN</label>
                    </div>
                    <div class="form-row">
                      <input id="exportAddress" type="checkbox" name="adr" value="1" checked>
                      <label for="exportAddress">Address</label>
                    </div>
                    <div class="form-row">
                      <input id="exportSpent" type="checkbox" name="spnt" value="1" checked>
                      <label for="exportSpent">Spent</label>
                    </div>
                    <div class="form-row">
                      <input id="exportPoints" type="checkbox" name="pnts" value="1" checked>
                      <label for="exportPoints">Points</label>
                    </div>
                    <div class="form-row">
                      <input id="exportNewsletter" type="checkbox" name="nws" value="1" checked>
                      <label for="exportNewsletter">Newsletter Subscriber</label>
                    </div>
                  </div>
                </div>
                <div class="col-8">
                  <div class="row m-0">
                    <div class="col">
                      <label>&nbsp;</label>
                      <div class="form-row">
                        <button onclick="$('.exports').toggle('d-none');return false;"><span class="exports d-none">Hide</span><span class="exports">Show</span> Options</button>
                      </div>
                    </div>
                    <div class="col">
                      <label for="exportDeliminator">Deliminator</label>
                      <div class="form-row">
                        <select name="d">
                          <option value="0" selected>, (comma)</option>
                          <option value="1">| (pipe)</option>
                          <option value="2">; (semicolon)</option>
                        </select>
                      </div>
                    </div>
                    <div class="col">
                      <label for="exportFormat">Format</label>
                      <div class="form-row">
                        <select name="f">
                          <option value="0">CSV</option>
                        </select>
                      </div>
                    </div>
                    <div class="col">
                      <label>&nbsp;</label>
                      <div class="form-row">
                        <button type="submit">Export</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            <?php }?>
          </div>
<?php /* Restore */ ?>
          <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
            <div id="backups">
              <?php foreach(glob("media/backup/*") as$file){
                $filename=basename($file);
                $filename=rtrim($filename,'.sql.gz');?>
                <div id="l_<?=$filename;?>" class="form-row mt-2">
                  <?=($user['options'][7]==1?'<a class="btn btn-block" href="'.$file.'">Click to Download <?= ltrim($file,`media/backup/`);?></a>':'<div class="input-text">'.$file.'</div>').
                  ($user['options'][7]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="removeBackup(`'.$filename.'`);"><i class="i">trash</i></button>':'');?>
                </div>
              <?php }?>
            </div>
            <?php if($user['options'][7]==1){?>
              <div class="alert alert-info mt-3">
                To restore a Database Backup, you will need to upload the .sql/.sql.gz file to PHPMyAdmin or other Database Configuration tool.
              </div>
            <?php }?>
<?php /*
            <form class="mt-3" target="sp" method="post" action="core/restorebackup.php" enctype="multipart/form-data">
              <div class="custom-file">
                <input class="custom-file-input hidden" id="fu" type="file" name="fu" onchange="$(`.page-block`).addClass(`d-block`);form.submit();">
                <label for="fu" class="btn add">Choose File and Restore Database</label>
              </div>
            </form>
*/?>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
