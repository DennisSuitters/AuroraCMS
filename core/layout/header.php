<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Header
 * @package    core/layout/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div id="back-to-top"></div>
<header class="<?php currentSeason();?>">
  <a class="brand" href="<?php echo URL.$settings['system']['admin'];?>/"><img src="core/images/auroracms-white.svg" alt="AuroraCMS"></a>
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
        <form class="form-row" method="post" action="<?php echo URL.$settings['system']['admin'].'/search';?>">
          <input name="s" type="text" placeholder="What are you looking for?">
          <button type="submit">Go</button>
        </form>
      </li>
      <li id="searchbtn">
        <button data-tooltip="left" aria-label="Search" onclick="$('#searchbox').toggleClass('show');return false;"><?php svg('search');?></button>
      </li>
    </ul>
  </nav>
  <div class="account" id="account">
    <a class="img-avatar" href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>" aria-label="Account"><img class="img-avatar" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.basename($user['avatar'])))echo'media/avatar/'.basename($user['avatar']);
    elseif($user['gravatar']!=''){
      if(stristr($user['gravatar'],'@')) echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
      elseif(stristr($user['gravatar'],'gravatar.com/avatar/')) echo$user['gravatar'];
      else echo ADMINNOAVATAR;
    }else echo ADMINNOAVATAR;?>" alt="<?php echo$user['username'];?>"></a>
    <h5 class="mt-3"><?php echo$user['name']!=''?$user['name']:$user['username'];?></h5>
    <h6><?php echo ucfirst(rank($user['rank']));?></h6>
    <nav>
      <ul>
        <li>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><div class="dropdown-header text-center"><strong>Account</strong></div></li>
            <li><a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>"><?php svg('user-settings');?> Settings</a></li>
            <li><a class="dropdown-item" href="<?php echo URL.'vcard/'.$user['username'];?>"><?php svg('address-card');?> vCard</a>
            <li class="divider"></li>
            <li><a class="dropdown-item" href="<?php echo URL;?>"><?php svg('browser-general');?> View Site</a></li>
            <li class="divider"></li>
            <li><a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'].'/logout';?>"><?php svg('sign-out');?> Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
  <nav class="horizontal" id="notifications">
    <ul>
      <li data-tooltip="right" aria-label="Notifications">
        <input id="notification-checkbox" type="checkbox">
        <label class="badge ml-4" data-badge="<?php echo($navStat>0?$navStat:'');?>" for="notification-checkbox"><?php svg('bell','i-2x');?></label>
        <ul id="nav-stat-list">
          <li class="dropdown-heading py-2">Notifications</li>
          <?php echo$nc['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/content">'.svg2('comments').' Comments<span class="badger badge-primary">'.$nc['cnt'].'</span></a></li>':'';
          echo$nr['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/content">'.svg2('review').' Reviews<span class="badger badge-primary">'.$nr['cnt'].'</span></a></li>':'';
          echo$nm['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/messages">'.svg2('inbox').' Messages<span class="badger badge-primary">'.$nm['cnt'].'</span></a></li>':'';
          echo$po['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/orders/pending">'.svg2('order').' Orders<span class="badger badge-primary">'.$po['cnt'].'</span></a></li>':'';
          echo$nb['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/bookings">'.svg2('calendar').' Bookings<span class="badger badge-primary">'.$nb['cnt'].'</span></a></li>':'';
          echo$nu['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('users').' Users<span class="badger badge-primary">'.$nu['cnt'].'</span></a></li>':'';
          echo$nt['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/content/type/testimonials">'.svg2('testimonial').' Testimonials<span class="badger badge-primary">'.$nt['cnt'].'</span></a></li>':'';
          echo$nou['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('users').' Active Users<span class="badger badge-primary">'.$nou['cnt'].'</span></a></li>':'';?>
        </ul>
      </li>
      <li data-tooltip="right" aria-label="View Site">
        <a href="<?php echo URL;?>"><?php svg('browser-general','i-2x');?></a>
      </li>
      <li data-tooltip="right" aria-label="Logout">
        <a href="<?php echo URL.$settings['system']['admin'].'/logout';?>"><?php svg('sign-out','i-2x');?></a>
      </li>
    </ul>
  </nav>
</header>
