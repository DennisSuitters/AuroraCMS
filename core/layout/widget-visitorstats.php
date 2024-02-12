<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Visitor Stats
 * @package    core/layout/widget-visitorstats.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="row justify-content-center">
  <?php $sm=$db->prepare("SELECT SUM(`views`) AS `views`, SUM(`views_direct`) AS `direct`, SUM(`views_google`) AS `google`, SUM(`views_duckduckgo`) AS `duckduckgo`, SUM(`views_bing`) AS `bing`, SUM(`views_facebook`) AS `facebook`, SUM(`views_instagram`) AS `instagram`, SUM(`views_twitter`) AS `twitter`, SUM(`views_linkedin`) AS `linkedin` FROM `".$prefix."content`");
  $sm->execute();
  $rm=$sm->fetch(PDO::FETCH_ASSOC);
  $sm2=$db->prepare("SELECT SUM(`views`) AS `views`, SUM(`views_direct`) AS `direct`, SUM(`views_google`) AS `google`, SUM(`views_duckduckgo`) AS `duckduckgo`, SUM(`views_bing`) AS `bing`, SUM(`views_facebook`) AS `facebook`, SUM(`views_instagram`) AS `instagram`, SUM(`views_twitter`) AS `twitter`, SUM(`views_linkedin`) AS `linkedin` FROM `".$prefix."menu`");
  $sm2->execute();
  $rm2=$sm2->fetch(PDO::FETCH_ASSOC);?>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">Direct</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-www"><?=short_number($rm['direct'] + $rm2['direct']);?></span>
    </span>
    <span class="icon"><i class="i i-5x">browser-general</i></span>
  </div>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">Google</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-facebook"><?=short_number($rm['google'] + $rm2['google']);?></span>
    </span>
    <span class="icon"><i class="i i-social social-google i-5x">social-google</i></span>
  </div>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">DuckDuckGo</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-duckduckgo"><?=short_number($rm['duckduckgo'] + $rm2['duckduckgo']);?></span>
    </span>
    <span class="icon"><i class="i i-social social-duckduckgo i-5x">social-duckduckgo</i></span>
  </div>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">Bing</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-bing"><?=short_number($rm['bing'] + $rm2['bing']);?></span>
    </span>
    <span class="icon"><i class="i i-social social-bing i-5x">social-bing</i></span>
  </div>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">Facebook</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-facebook"><?=short_number($rm['facebook'] + $rm2['facebook']);?></span>
    </span>
    <span class="icon"><i class="i i-social social-facebook i-5x">social-facebook</i></span>
  </div>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">Instagram</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-instagram"><?=short_number($rm['instagram'] + $rm2['instagram']);?></span>
    </span>
    <span class="icon"><i class="i i-social social-instagram i-5x">social-instagram</i></span>
  </div>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">Twitter</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-facebook"><?=short_number($rm['twitter'] + $rm2['twitter']);?></span>
    </span>
    <span class="icon"><i class="i i-social social-twitter i-5x">social-twitter</i></span>
  </div>
  <div class="card stats col-11 col-sm m-0 p-2 m-1 text-center">
    <span class="h6 text-muted">Linkedin</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="social-linkedin"><?=short_number($rm['linkedin'] + $rm2['linkedin']);?></span>
    </span>
    <span class="icon"><i class="i i-social social-linkedin i-5x">social-linkedin</i></span>
  </div>
</div>
<div class="row justify-content-center">
  <?php if($config['hoster']==1&&$user['rank']==1000){
    $rh=$db->query("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."login` WHERE `hostStatus`='overdue'")->fetch(PDO::FETCH_ASSOC);
    if($rh['cnt']>0){?>
      <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/payments';?>">
        <span class="h6 text-muted">Hosting</span>
        <span class="px-0 py-2">
          <span class="text-3x" id="stats-messages"><?= number_format($rh['cnt']);?></span>
          <small class="d-block text-muted"><small>Overdue</small></small>
        </span>
        <span class="icon"><i class="i i-5x">hosting</i></span>
      </a>
    <?php }
    $rso=$db->query("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."login` WHERE `siteStatus`='overdue'")->fetch(PDO::FETCH_ASSOC);
    if($rso['cnt']>0){?>
      <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/payments';?>">
        <span class="h6 text-muted">Site Payments</span>
        <span class="px-0 py-2">
          <span class="text-3x" id="stats-messages"><?= number_format($rso['cnt']);?></span>
          <small class="d-block text-muted"><small>Overdue</small></small>
        </span>
        <span class="icon"><i class="i i-5x">hosting</i></span>
      </a>
    <?php }
    $rss=$db->query("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."login` WHERE `siteStatus`='outstanding'")->fetch(PDO::FETCH_ASSOC);
    if($rss['cnt']>0){?>
      <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/payments';?>">
        <span class="h6 text-muted">Site Payments</span>
        <span class="px-0 py-2">
          <span class="text-3x" id="stats-messages"><?= number_format($rss['cnt']);?></span>
          <small class="d-block text-muted"><small>Oustanding</small></small>
        </span>
        <span class="icon"><i class="i i-5x">hosting</i></span>
      </a>
    <?php }
  }
  $ss=$db->prepare("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."iplist` WHERE `ti`>=:ti");
  $ss->execute(['ti'=>time()-604800]);
  $sa=$ss->fetch(PDO::FETCH_ASSOC);
  $currentMonthStart=mktime(0, 0, 0, date("n"), 1);
  if($user['options'][3]==1){?>
    <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/messages';?>">
      <span class="h6 text-muted">Messages</span>
      <span class="px-0 py-2">
        <span class="text-3x" id="stats-messages"><?=(isset($nm['cnt'])?short_number($nm['cnt']):0);?></span>
        <small class="d-block text-muted"><small>New</small></small>
      </span>
      <span class="icon"><i class="i i-5x">inbox</i></span>
    </a>
  <?php }?>
  <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/bookings';?>">
    <span class="h6 text-muted">Bookings</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="stats-bookings"><?=(isset($nb['cnt'])?short_number($nb['cnt']):0);?></span>
      <small class="d-block text-muted"><small>New</small></small>
    </span>
    <span class="icon"><i class="i i-5x">calendar</i></span>
  </a>
  <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/comments';?>">
    <span class="h6 text-muted">Comments</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="stats-comments"><?=(isset($nc['cnt'])?short_number($nc['cnt']):0);?></span>
      <small class="d-block text-muted"><small>New</small></small>
    </span>
    <span class="icon"><i class="i i-5x">comments</i></span>
  </a>
  <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/reviews';?>">
    <span class="h6 text-muted">Reviews</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="stats-reviews"><?=(isset($nr['cnt'])?short_number($nr['cnt']):0);?></span>
      <small class="d-block text-muted"><small>New</small></small>
    </span>
    <span class="icon"><i class="i i-5x">review</i></span>
  </a>
  <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/content/type/testimonials';?>">
    <span class="h6 text-muted">Testimonials</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="stats-testimonials"><?=(isset($nt['cnt'])?short_number($nt['cnt']):0);?></span>
      <small class="d-block text-muted"><small>New</small></small>
    </span>
    <span class="icon"><i class="i i-5x">testimonial</i></span>
  </a>
  <?php if($user['options'][4]==1){?>
    <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/orders';?>">
      <span class="h6 text-muted">Orders</span>
      <span class="px-0 py-2">
        <span class="text-3x" id="stats-orders"><?=(isset($po['cnt'])?short_number($po['cnt']):0);?></span>
        <small class="d-block text-muted"><small>New</small></small>
      </span>
      <span class="icon"><i class="i i-5x">order</i></span>
    </a>
  <?php }?>
  <a class="card stats col-11 col-sm m-0 p-2 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/security/settings#tab1-3';?>">
    <span class="h6 text-muted">Blacklist</span>
    <span class="px-0 py-2">
      <span class="text-3x" id="browser-blacklist"><?=(isset($sa['cnt'])?short_number($sa['cnt']):0);?></span>
      <small class="d-block text-muted"><small>Added Last 7 Days</small></small>
    </span>
    <span class="icon"><i class="i i-5x">security</i></span>
  </a>
</div>
