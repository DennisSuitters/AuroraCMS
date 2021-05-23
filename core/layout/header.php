<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Header
 * @package    core/layout/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.1 Fix Notification links going to incorrect pages.
 * @changes    v0.1.2 Use PHP short codes where possible.
 */?>
<div id="back-to-top"></div>
<header class="aurora">
  <a class="brand" href="<?= URL.$settings['system']['admin'];?>/"><img src="core/images/auroracms-white.svg" alt="AuroraCMS"></a>
  <nav>
    <ul class="nav-left">
      <li>
        <a class="nav-toggle" href="javascript:void(0);">
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </a>
      </li>
    </ul>
    <ul class="ml-auto d-none d-md-block">
      <li id="searchbox">
        <form class="form-row" method="post" action="<?= URL.$settings['system']['admin'].'/search';?>">
          <input name="s" type="text" placeholder="What are you looking for?">
          <button type="submit">Go</button>
        </form>
      </li>
      <li id="searchbtn">
        <button data-tooltip="left" aria-label="Search" onclick="$('#searchbox').toggleClass('show');return false;"><?= svg2('search');?></button>
      </li>
    </ul>
  </nav>
  <div class="account" id="account">
    <a class="img-avatar" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>" aria-label="Account"><img class="img-avatar" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.basename($user['avatar'])))echo'media/avatar/'.basename($user['avatar']);
    elseif($user['gravatar']!=''){
      if(stristr($user['gravatar'],'@')) echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
      elseif(stristr($user['gravatar'],'gravatar.com/avatar/')) echo$user['gravatar'];
      else echo ADMINNOAVATAR;
    }else echo ADMINNOAVATAR;?>" alt="<?=$user['username'];?>"></a>
    <h5 class="mt-3"><?=$user['name']!=''?$user['name']:$user['username'];?></h5>
    <h6><?= ucfirst(rank($user['rank']));?></h6>
    <nav>
      <ul>
        <li>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><div class="dropdown-header text-center"><strong>Account</strong></div></li>
            <li><a class="dropdown-item" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>"><?= svg2('user-settings');?> Settings</a></li>
            <li><a class="dropdown-item" href="<?= URL.'vcard/'.$user['username'];?>"><?= svg2('address-card');?> vCard</a>
            <li class="divider"></li>
            <li><a class="dropdown-item" href="<?= URL;?>"><?= svg2('browser-general');?> View Site</a></li>
            <li class="divider"></li>
            <li><a class="dropdown-item" href="<?= URL.$settings['system']['admin'].'/logout';?>"><?= svg2('sign-out');?> Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
  <nav class="horizontal" id="notifications">
    <ul>
      <li data-tooltip="right" aria-label="Notifications">
        <input id="notification-checkbox" type="checkbox">
        <label class="badge ml-4" data-badge="<?=$navStat>0?$navStat:'';?>" for="notification-checkbox"><?= svg2('bell','i-2x');?></label>
        <ul id="nav-stat-list">
          <li class="dropdown-heading py-2">Notifications</li>
          <?=($nc['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/comments">'.svg2('comments').' Comments<span class="badger badge-primary">'.$nc['cnt'].'</span></a></li>':'').
          ($nr['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/reviews">'.svg2('review').' Reviews<span class="badger badge-primary">'.$nr['cnt'].'</span></a></li>':'').
          ($nm['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/messages">'.svg2('inbox').' Messages<span class="badger badge-primary">'.$nm['cnt'].'</span></a></li>':'').
          ($po['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/orders/pending">'.svg2('order').' Orders<span class="badger badge-primary">'.$po['cnt'].'</span></a></li>':'').
          ($nb['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/bookings">'.svg2('calendar').' Bookings<span class="badger badge-primary">'.$nb['cnt'].'</span></a></li>':'').
          ($nu['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('users').' Users<span class="badger badge-primary">'.$nu['cnt'].'</span></a></li>':'').
          ($nt['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/content/type/testimonials">'.svg2('testimonial').' Testimonials<span class="badger badge-primary">'.$nt['cnt'].'</span></a></li>':'').
          ($nou['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('users').' Active Users<span class="badger badge-primary">'.$nou['cnt'].'</span></a></li>':'');?>
        </ul>
      </li>
      <li data-tooltip="right" aria-label="View Site">
        <a href="<?= URL;?>"><?= svg2('browser-general','i-2x');?></a>
      </li>
      <li data-tooltip="right" aria-label="Logout">
        <a href="<?= URL.$settings['system']['admin'].'/logout';?>"><?= svg2('sign-out','i-2x');?></a>
      </li>
    </ul>
    <div class="date"><?= date($config['dateFormat'],time());?></div>
  </nav>
</header>
