<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Header
 * @package    core/layout/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div id="back-to-top"></div>
<header class="aurora">
  <nav>
    <ul class="nav-left">
      <li>
        <button class="nav-toggle" type="button" aria-label="Show/Hide Sidebar" aria-expanded="true">
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </a>
      </li>
      <li>
        <a class="brand" href="<?= URL.$settings['system']['admin'];?>/"><img src="core/images/auroracms.svg" alt="AuroraCMS"></a>
      </li>
    </ul>
    <ul class="ml-auto">
      <li class="d-none d-md-inline-block">
        <form class="form-row" method="post" action="<?= URL.$settings['system']['admin'].'/search';?>">
          <input name="s" type="text" placeholder="Enter a Search Term...">
          <button type="submit" data-tooltip="bottom" aria-label="Search"><i class="i i-2x">search</i></button>
        </form>
      </li>
      <li class="badge text-center" id="nav-stat" aria-label="Notifications" data-badge="<?=$navStat>0?$navStat:'';?>">
        <input class="d-none" id="notification-checkbox" type="checkbox">
        <label class="mt-0 text-white" for="notification-checkbox"><i class="i i-2x">bell</i></label>
        <ul class="p-0" id="nav-stat-list">
          <li class="dropdown-heading py-2">Notifications</li>
          <?=($nc['cnt']>0?'<li><span class="badger badge-primary">'.$nc['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/comments"> Comments</a></li>':'').
          ($nr['cnt']>0?'<li><span class="badger badge-primary">'.$nr['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/reviews"> Reviews</a></li>':'').
          ($nm['cnt']>0?'<li><span class="badger badge-primary">'.$nm['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/messages"> Messages</a></li>':'').
          ($po['cnt']>0?'<li><span class="badger badge-primary">'.$po['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/orders/pending"> Orders</a></li>':'').
          ($nb['cnt']>0?'<li><span class="badger badge-primary">'.$nb['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/bookings"> Bookings</a></li>':'').
          ($nu['cnt']>0?'<li><span class="badger badge-primary">'.$nu['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/accounts"> Users</a></li>':'').
          ($nt['cnt']>0?'<li><span class="badger badge-primary">'.$nt['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/content/type/testimonials"> Testimonials</a></li>':'').
          ($nou['cnt']>0?'<li><span class="badger badge-primary">'.$nou['cnt'].'</span>&nbsp;&nbsp;<a href="'.URL.$settings['system']['admin'].'/accounts"> Active Users</a></li>':'');?>
        </ul>
      </li>
      <li>
        <div id="account" data-tooltip="bottom" aria-label="Logged in as <?= ucfirst(rank($user['rank']));?> | <?=$user['name']!=''?$user['name']:$user['username'];?>">
          <a class="img-avatar" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>" aria-label="Account"><img class="img-avatar" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.basename($user['avatar'])))echo'media/avatar/'.basename($user['avatar']);
          elseif($user['gravatar']!=''){
            if(stristr($user['gravatar'],'@')) echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
            elseif(stristr($user['gravatar'],'gravatar.com/avatar/')) echo$user['gravatar'];
            else echo ADMINNOAVATAR;
          }else echo ADMINNOAVATAR;?>" alt="<?=$user['username'];?>"></a>
        </div>
      </li>
      <li data-tooltip="bottom" aria-label="View Site">
        <a href="<?= URL;?>" class="text-white"><i class="i i-2x">browser-general</i></a>
      </li>
      <li data-tooltip="bottom" aria-label="Logout">
        <a href="<?= URL.$settings['system']['admin'].'/logout';?>" class="text-white"><i class="i i-2x">sign-out</i></a>
      </li>
    </ul>
  </nav>
</header>
