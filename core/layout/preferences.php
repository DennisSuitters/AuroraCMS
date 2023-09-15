<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences
 * @package    core/layout/preferences.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!isset($args[0]) || $args[0]==''){?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 p-4 bg-transparent border-0 overflow-visible">
          <div class="row">
            <?php $sp=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `view`='preferences' AND `active`=1 ORDER BY `ord` ASC");
            $sp->execute();
            while($rp=$sp->fetch(PDO::FETCH_ASSOC)){?>
              <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/'.$rp['view'].'/'.$rp['contentType'];?>" aria-label="Go to <?=$rp['title'];?> Preferences">
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
<?php }else require'core/layout/pref_'.$args[0].'.php';
