<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings
 * @package    core/layout/settings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='32'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 p-4 bg-transparent border-0 overflow-visible">
        <div class="row">
          <?php $sp=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `view`='settings' AND `contentType`!='dropdown' AND `active`=1".($config['mediaOptions'][3]==1?" ORDER BY `pin` DESC, `views` DESC, `ord` ASC, `title` ASC":" ORDER BY `pin` DESC, `ord` ASC, `title` ASC"));
          $sp->execute();
          while($rp=$sp->fetch(PDO::FETCH_ASSOC)){?>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/'.$rp['contentType'].'/'.$rp['view'];?>" aria-label="Go to <?=$rp['title'];?> Settings">
              <span class="h5"><?=$rp['title'];?></span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x"><?=$rp['icon'];?></i></span>
            </a>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
