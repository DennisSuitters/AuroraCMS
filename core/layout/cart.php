<?php
/**
* AuroraCMS - Copyright (C) Diemen Design 2019
*
* @category   Administration - Settings - Cart
* @package    core/layout/cart.php
* @author     Dennis Suitters <dennis@diemendesign.com.au>
* @copyright  2014-2019 Diemen Design
* @license    http://opensource.org/licenses/MIT  MIT License
* @version    0.2.26-1
* @link       https://github.com/DiemenDesign/AuroraCMS
* @notes      This PHP Script is designed to be executed using PHP 7+
*/
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='51'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
            <li class="breadcrumb-item active">Cart</li>
          </ol>
        </div>
        <div class="sticky-i10">
          <div class="row">
            <article class="card py-2 overflow-visible card-list card-list-header shadow">
              <div class="row">
                <div class="col-12 col-md-1 text-center">dbID</div>
                <div class="col-12 col-md pl-2">SID</div>
                <div class="col-12 col-md pl-2">Item</div>
                <div class="col-12 col-md-1 text-center">Quantity</div>
                <div class="col-12 col-md-1 text-center">Cost</div>
                <div class="col-12 col-md-2 pl-2">Date</div>
                <div class="col-12 col-md-1 pr-2 text-right">
                  <?=($user['options'][7]==1?'<button class="btn-sm purge" data-tooltip="left" aria-label="Purge All" onclick="purge(`0`,`cart`);return false;"><i class="i">purge</i></button>':'');?>
                </div>
              </div>
            </article>
          </div>
        </div>
        <div id="l_cart">
          <?php $s=$db->prepare("SELECT * FROM `".$prefix."cart` ORDER BY `ti` DESC");
          $s->execute();
          while($r=$s->fetch(PDO::FETCH_ASSOC)){
            $si=$db->prepare("SELECT `id`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
            $si->execute([':id'=>$r['iid']]);
            $ri=$si->fetch(PDO::FETCH_ASSOC);?>
            <article class="card col-12 zebra mb-0 p-0 overflow-visible card-list item shadow" id="l_<?=$r['id'];?>">
              <div class="row">
                <div class="col-12 col-md-1 pt-3 text-center small"><?= trim($r['id']);?></div>
                <div class="col-12 col-md pl-2 pt-3 small"><?= trim($r['si']);?></div>
                <div class="col-12 col-md pl-2 pt-3 small"><?=($ri['code']!=''?$ri['code'].' | ':'').$r['title'];?></div>
                <div class="col-12 col-md-1 pt-3 text-center small"><?=$r['quantity'];?></div>
                <div class="col-12 col-md-1 pt-3 text-center small"><?=$r['cost'];?></div>
                <div class="col-12 col-md-2 pl-2 pt-3 small"><?= date($config['dateFormat'],$r['ti']);?></div>
                <div class="col-12 col-md-1 pr-2 text-right">
                  <div class="btn-group" role="group">
                    <?=($user['options'][7]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$r['id'].'`,`cart`);"><i class="i">trash</i></button>':'');?>
                  </div>
                </div>
              </div>
            </article>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
