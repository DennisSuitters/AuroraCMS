<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Header
 * @package    core/layout/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div id="back-to-top"></div>
<header class="aurora">
  <a class="brand" href="<?= URL.$settings['system']['admin'];?>/"><img src="core/images/auroracms.svg" alt="AuroraCMS"></a>
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
    <h5 class="mt-3 text-white"><?=$user['name']!=''?$user['name']:$user['username'];?></h5>
    <h6 class="text-white"><?= ucfirst(rank($user['rank']));?></h6>
  </div>
  <nav class="horizontal" id="notifications">
    <ul>
      <li class="text-center" data-tooltip="tooltip" aria-label="Notifications">
        <input id="notification-checkbox" type="checkbox">
        <label class="badge mt-0 text-white" data-badge="<?=$navStat>0?$navStat:'';?>" for="notification-checkbox"><?= svg2('bell','i-2x');?></label>
        <ul id="nav-stat-list">
          <li class="dropdown-heading py-2">Notifications</li>
          <?=($nc['cnt']>0?'<li><span class="badger badge-primary">'.$nc['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/comments"> Comments</a></li>':'').
          ($nr['cnt']>0?'<li><span class="badger badge-primary">'.$nr['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/reviews"> Reviews</a></li>':'').
          ($nm['cnt']>0?'<li><span class="badger badge-primary">'.$nm['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/messages"> Messages</a></li>':'').
          ($po['cnt']>0?'<li><span class="badger badge-primary align-self-end">'.$po['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/orders/pending"> Orders</a></li>':'').
          ($nb['cnt']>0?'<li><span class="badger badge-primary">'.$nb['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/bookings"> Bookings</a></li>':'').
          ($nu['cnt']>0?'<li><span class="badger badge-primary">'.$nu['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/accounts"> Users</a></li>':'').
          ($nt['cnt']>0?'<li><span class="badger badge-primary">'.$nt['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/content/type/testimonials"> Testimonials</a></li>':'').
          ($nou['cnt']>0?'<li><span class="badger badge-primary">'.$nou['cnt'].'</span><a href="'.URL.$settings['system']['admin'].'/accounts"> Active Users</a></li>':'');?>
        </ul>
      </li>
      <li data-tooltip="tooltip" aria-label="View Site">
        <a href="<?= URL;?>"><?= svg2('browser-general','i-2x');?></a>
      </li>
      <li data-tooltip="tooltip" aria-label="Logout">
        <a href="<?= URL.$settings['system']['admin'].'/logout';?>"><?= svg2('sign-out','i-2x');?></a>
      </li>
    </ul>
    <div class="date"><?= date($config['dateFormat'],time());?></div>
  </nav>
</header>
