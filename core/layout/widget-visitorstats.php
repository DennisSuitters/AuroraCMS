<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Visitor Stats
 * @package    core/layout/widget-visitorstats.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="item m-0 p-0 col-12" data-dbid="<?=$rw['id'];?>" id="l_<?=$rw['id'];?>">
  <div class="alert m-3 p-0 bg-transparent border-0">
    <div class="row">
      <?php if($config['hoster']==1&&$user['rank']==1000){
        $rh=$db->query("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."login` WHERE `hostStatus`='overdue'")->fetch(PDO::FETCH_ASSOC);
        if($rh['cnt']>0){?>
          <a class="card stats danger col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/payments';?>">
            <span class="h5">Hosting</span>
            <span class="p-0">
              <span class="text-3x" id="stats-messages"><?= number_format($rh['cnt']);?></span> <small><small>Overdue</small></small>
            </span>
            <span class="icon"><i class="i i-5x">hosting</i></span>
          </a>
        <?php }
        $rso=$db->query("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."login` WHERE `siteStatus`='overdue'")->fetch(PDO::FETCH_ASSOC);
        if($rso['cnt']>0){?>
          <a class="card stats danger col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/payments';?>">
            <span class="h5">Site Payments</span>
            <span class="p-0">
              <span class="text-3x" id="stats-messages"><?= number_format($rso['cnt']);?></span> <small><small>Overdue</small></small>
            </span>
            <span class="icon"><i class="i i-5x">hosting</i></span>
          </a>
        <?php }
        $rss=$db->query("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."login` WHERE `siteStatus`='outstanding'")->fetch(PDO::FETCH_ASSOC);
        if($rss['cnt']>0){?>
          <a class="card stats warning col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/payments';?>">
            <span class="icon"><i class="i i-5x">hosting</i></span>
            <span class="h5">Site Payments</span>
            <span class="p-0">
              <span class="text-3x" id="stats-messages"><?= number_format($rss['cnt']);?></span> <small><small>Oustanding</small></small>
            </span>
          </a>
        <?php }
      }
      $ss=$db->prepare("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."iplist` WHERE `ti`>=:ti");
      $ss->execute(['ti'=>time()-604800]);
      $sa=$ss->fetch(PDO::FETCH_ASSOC);
      $currentMonthStart=mktime(0, 0, 0, date("n"), 1);
      $pcs=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."tracker` WHERE `action`='Call Click' AND `ti`>:sD");
      $pcs->execute([':sD'=>$currentMonthStart -1]);
      $pc=$pcs->Fetch(PDO::FETCH_ASSOC);
      if($user['options'][3]==1){
        if(isset($nm['cnt'])&&$nm['cnt']>0){?>
          <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-2 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/messages';?>">
            <span class="h5">Messages</span>
            <span class="p-0">
              <span class="text-3x" id="stats-messages"><?= number_format($nm['cnt']);?></span> <small><small>New</small></small>
            </span>
            <span class="icon"><i class="i i-5x">inbox</i></span>
          </a>
        <?php }
      }
      if(isset($nb['cnt'])&&$nb['cnt']>0){?>
        <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/bookings';?>">
          <span class="h5">Bookings</span>
          <span class="p-0">
            <span class="text-3x" id="stats-bookings"><?= number_format($nb['cnt']);?></span> <small><small>New</small></small>
          </span>
          <span class="icon"><i class="i i-5x">calendar</i></span>
        </a>
      <?php }
      if(isset($pc['cnt'])&&$pc['cnt']>0){?>
        <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker?find=call';?>">
          <span class="h5">Calls from Site</span>
          <span class="p-0">
            <span class="text-3x" id="stats-reviews"><?= number_format($pc['cnt']);?></span> <small><small>This Month</small></small>
          </span>
          <span class="icon"><i class="i i-5x">tech-mobile</i></span>
        </a>
      <?php }
      if(isset($nc['cnt'])&&$nc['cnt']>0){?>
        <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/comments';?>">
          <span class="h5">Comments</span>
          <span class="p-0">
            <span class="text-3x" id="stats-comments"><?= number_format($nc['cnt']);?></span> <small><small>New</small></small>
          </span>
          <span class="icon"><i class="i i-5x">comments</i></span>
        </a>
      <?php }
      if(isset($nr['cnt'])&&$nr['cnt']>0){?>
        <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/reviews';?>">
          <span class="h5">Reviews</span>
          <span class="p-0">
            <span class="text-3x" id="stats-reviews"><?= number_format($nr['cnt']);?></span> <small><small>New</small></small>
          </span>
          <span class="icon"><i class="i i-5x">review</i></span>
        </a>
      <?php }
      if(isset($nt['cnt'])&&$nt['cnt']>0){?>
        <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/content/type/testimonials';?>">
          <span class="h5">Testimonials</span>
          <span class="p-0">
            <span class="text-3x" id="stats-testimonials"><?= number_format($nt['cnt']);?></span> <small><small>New</small></small>
          </span>
          <span class="icon"><i class="i i-5x">testimonial</i></span>
        </a>
      <?php }
      if($user['options'][4]==1){
        if(isset($po['cnt'])&&$po['cnt']>0){?>
          <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/orders';?>">
            <span class="h5">Orders</span>
            <span class="p-0">
              <span class="text-3x" id="stats-orders"><?= number_format($po['cnt']);?></span> <small><small>New</small></small>
            </span>
            <span class="icon"><i class="i i-5x">order</i></span>
          </a>
        <?php }
      }
      if($sa['cnt']>0){?>
        <a class="card stats col-6 col-sm-4 col-md-3 col-lg-5 col-xl-2 col-xxl-4 m-0 p-2 m-sm-1" href="<?= URL.$settings['system']['admin'].'/preferences/security#tab1-3';?>">
          <span class="h5">Blacklist</span>
          <span class="p-0">
            <span class="text-3x" id="browser-blacklist"><?= number_format($sa['cnt']);?></span> <small><small>Added Last 7 Days</small></small>
          </span>
          <span class="icon"><i class="i i-5x">security</i></span>
        </a>
      <?php }?>
    </div>
  </div>
</div>
