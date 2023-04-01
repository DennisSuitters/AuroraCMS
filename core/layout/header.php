<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Header
 * @package    core/layout/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<header id="back-to-top" class="aurora">
  <nav>
    <ul class="nav-left">
      <li>
        <button class="btn btn-ghost nav-toggle" type="button" aria-label="Show/Hide Sidebar" aria-expanded="true">
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </a>
      </li>
      <li>
        <a class="brand" href="<?= URL.$settings['system']['admin'];?>/" data-tooltip="right" aria-label="AuroraCMS"><img class="auroracmslogo" src="core/images/favicon-64.jpg" alt="AuroraCMS"></a>
      </li>
    </ul>
    <ul class="ml-auto mt-3">
      <li class="text-center px-3" data-tooltip="bottom" aria-label="Search">
        <a href="<?= URL.$settings['system']['admin'].'/search';?>"><i class="i i-3x">search</i></a>
      </li>
      <li class="badge text-center" id="nav-stat" aria-label="Notifications" data-badge="<?=$navStat>0?$navStat:'';?>">
        <input class="d-none" id="notification-checkbox" type="checkbox">
        <label class="m-0" for="notification-checkbox"><i class="i i-3x">bell</i></label>
        <ul class="p-0" id="nav-stat-list">
          <li class="dropdown-heading py-2">Notifications</li>
          <?=($nc['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/comments"><span class="badger badge-primary mr-2">'.$nc['cnt'].'</span>Comments</a></li>':'').
          ($nr['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/reviews"><span class="badger badge-primary mr-2">'.$nr['cnt'].'</span>Reviews</a></li>':'').
          ($nm['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/messages"><span class="badger badge-primary mr-2">'.$nm['cnt'].'</span>Messages</a></li>':'').
          ($po['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/orders/pending"><span class="badger badge-primary mr-2">'.$po['cnt'].'</span>Orders</a></li>':'').
          ($nb['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/bookings"><span class="badger badge-primary mr-2">'.$nb['cnt'].'</span>Bookings</a></li>':'').
          ($nu['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts"><span class="badger badge-primary mr-2">'.$nu['cnt'].'</span>Users</a></li>':'').
          ($nt['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/content/type/testimonials"><span class="badger badge-primary mr-2">'.$nt['cnt'].'</span>Testimonials</a></li>':'').
          ($nou['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts"><span class="badger badge-primary mr-2">'.$nou['cnt'].'</span>Active Users</a></li>':'');?>
        </ul>
      </li>
      <li data-tooltip="bottom" aria-label="View Site">
        <a href="<?= URL;?>"><i class="i i-3x">browser-general</i></a>
      </li>
      <li class="text-center ml-3" id="nav-accounts" data-tooltip="bottom" aria-label="Account Settings">
        <input class="d-none" id="header-account-checkbox" type="checkbox">
        <label class="m-0" for="header-account-checkbox">
          <span class="d-inline" id="account">
            <img class="img-avatar" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.basename($user['avatar'])))echo'media/avatar/'.basename($user['avatar']);
              elseif($user['gravatar']!=''){
                if(stristr($user['gravatar'],'@')) echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
              elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))  echo$user['gravatar'];
              else echo ADMINNOAVATAR;
            }else echo ADMINNOAVATAR;?>" alt="<?=$user['username'];?>">
          </span>
        </label>
        <ul class="p-0" id="nav-account-list">
          <li class="text-center p-3" style="background:linear-gradient(0,rgba(28,28,28,.6),rgba(28,28,28,0)32.45%),radial-gradient(100% 100% at 0 100%,#3c164d 0,rgba(60,22,77,0)100%),radial-gradient(100% 100% at 100% 100%,#4d0119 0,rgba(77,1,25,0)100%),radial-gradient(100% 100% at 100% 0,#38004d 0,rgba(56,0,77,0)100%),radial-gradient(100% 100% at 0 0,#4d3c0d 0,rgba(77,60,13,0)100%);">
            <img class="img-avatar m-3" style="width:80px;height:80px;max-width:initial;max-height:80px;" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.basename($user['avatar'])))echo'media/avatar/'.basename($user['avatar']);
              elseif($user['gravatar']!=''){
                if(stristr($user['gravatar'],'@')) echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
              elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))  echo$user['gravatar'];
              else echo ADMINNOAVATAR;
            }else echo ADMINNOAVATAR;?>" alt="<?=$user['username'];?>"><br>
            <span class="d-inline-block"><strong class="d-block"><?=$user['name']==''?$user['username']:$user['name'];?></strong>
              <small><?= ucwords(rank($user['rank']));?></small>
            </span>
          </li>
          <li><a class="p-2 px-3" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>">My Account</a></li>
          <li><a class="p-2 px-3" target="_blank" href="https://github.com/DiemenDesign/AuroraCMS/issues">Support</a></li>
          <li><a class="p-2 px-3" href="<?= URL.$settings['system']['admin'].'/logout';?>">Logout</a></li>
          <li class="dropdown-heading">&nbsp;</li>
          <li><a class="p-2 px-3" href="https://github.com/DiemenDesign/AuroraCMS">AuroraCMS Home Page</a></li>
          <li><a class="p-2 px-3" href="https://github.com/DiemenDesign/AuroraCMS/issues">Report an issue</a></li>
          <li><a class="p-2 px-3" href="https://github.com/DiemenDesign/AuroraCMS/wiki">Documentation</a></li>
        </ul>
      </li>
      <li data-tooltip="bottom" aria-label="Switch to Theme Mode">
        <button class="btn btn-ghost" onclick="toggleTheme();">
          <?php if(!isset($_COOKIE['admintheme'])){$_COOKIE['admintheme']='light';}?>
          <i class="i theme-mode<?=(isset($_COOKIE['admintheme'])&&$_COOKIE['admintheme']=='dark'?' d-none':'');?>">dark-mode</i>
          <i class="i theme-mode<?=(isset($_COOKIE['admintheme'])&&$_COOKIE['admintheme']=='light'?' d-none':'');?>">light-mode</i>
        </button>
      </li>
    </ul>
  </nav>
</header>
