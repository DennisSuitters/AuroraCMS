<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media
 * @package    core/layout/media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='34'");
$sv->execute();
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_media.php';
elseif(isset($args[0])&&$args[0]=='edit')require'core/layout/edit_media.php';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pt-0">
                  <li class="breadcrumb-item active">Media</li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=$user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/media/settings" role="button" data-tooltip="left" aria-label="Media Settings"><i class="i">settings</i></a>':'';?>
                </div>
              </div>
            </div>
          </div>
          <?=$user['options'][0]==1?'<div class="row"><div id="elfinder" style="width:100%;"></div></div>':'<div class="alert alert-info" role="alert">You Don\'t Have Permissions To Use This Area</div>';?>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
