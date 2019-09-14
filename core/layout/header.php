<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Header
 * @package    core/layout/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Move Settings Links into Menu.
 * @changes    v0.0.2 Add Permissions Options
 */?>
<header class="app-header navbar">
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" data-toggle="sidebar-show" aria-controls="sidebar" role="presentation" aria-label="Toggle Navigation Sidebar"><span class="sr-only">Toggle Sidebar</span><span class="navbar-toggler-icon"></span></button>
  <a class="navbar-brand ml-sm-3" data-toggle="dropdown" href="<?php echo URL.$settings['system']['admin'];?>" role="button" aria-label="AuroraCMS" aria-haspopup="true" aria-expanded="false"><i><?php svg('auroracms-white');?></i></a>
  <div class="dropdown-menu dropdown-menu-left dropdown-menu-lg">
    <div class="dropdown-header text-center">
      <div class="small">
        AuroraCMS <small><?php if(file_exists('VERSION'))include'VERSION';?></small> is an Australian <a target="_blank" href="https://github.com/DiemenDesign/LibreCMS/blob/master/LICENSE">MIT Licensed</a><br>Open Source Content<br>and Business Management System.<br><br>Built with love<br>using <a href="http://getbootstrap.com/">Bootstrap</a>, <a href="https://jquery.com/">jQuery</a>, and <a href="http://www.php.net/">PHP</a>.<br>Coded with <a href="https://atom.io/">Atom</a> and <a href="https://www.linuxmint.com/">Linux Mint</a>.
      </div>
    </div>
    <div class="divider"></div>
    <a class="dropdown-item" target="_blank" href="https://github.com/DiemenDesign/AuroraCMS"><?php svg('social-github');?> Project</a>
    <a class="dropdown-item" target="_blank" href="https://github.com/DiemenDesign/AuroraCMS/issues"><?php svg('exclamation-circle');?> GitHub Issues</a>
    <a class="dropdown-item" target="_blank" href="https://github.com/DiemenDesign/AuroraCMS/wiki"><?php svg('book');?> Documentation</a>
  </div>
  <button class="navbar-toggler sidebar-toggler ml-sm-5 d-md-down-none" type="button" data-toggle="sidebar-lg-show" aria-controls="sidebar" role="presentation" aria-label="Toggle Navigation Sidebar"><span class="sr-only">Toggle Sidebar</span><span class="navbar-toggler-icon"></span></button>
  <ul class="nav navbar-nav ml-auto">
    <li class="nav-item"><a class="nav-link" href="#" role="button" data-tooltip="tooltip" data-placement="left" title="Search" onclick="$('#searchbox').toggleClass('d-none');return false;"><?php svg('search');?></a></li>
    <li class="nav-item dropdown d-none d-sm-block">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" data-tooltip="tooltip" data-placement="left" title="Notifications"><?php svg('bell');?><span id="nav-stat" class="badge badge-pill badge-danger"><?php echo($navStat>0?$navStat:'');?></span></a>
      <div id="nav-stat-list" class="dropdown-menu dropdown-menu-right dropdown-menu-lg shadow">
        <div class="dropdown-header text-center"><strong>Notifications</strong></div>
<?php   echo$nc['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/content">'.svg2('comments').' Comments<span id="nav-nc" class="badge badge-info">'.$nc['cnt'].'</span></a>':'';
        echo$nr['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/content">'.svg2('review').' Reviews<span id="nav-nr" class="badge badge-info">'.$nr['cnt'].'</span></a>':'';
        echo$nm['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/messages">'.svg2('inbox').' Messages<span id="nav-nm" class="badge badge-info">'.$nm['cnt'].'</span></a>':'';
        echo$po['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/orders/pending">'.svg2('order').' Orders<span id="nav-po" class="badge badge-info">'.$po['cnt'].'</span></a>':'';
        echo$nb['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/bookings">'.svg2('calendar').' Bookings<span id="nav-nb" class="badge badge-info">'.$nb['cnt'].'</span></a>':'';
        echo$nu['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('users').' Users<span id="nav-nu" class="badge badge-info">'.$nu['cnt'].'</span></a>':'';
        echo$nt['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/content/type/testimonials">'.svg2('testimonial').' Testimonials<span id="nav-nt" class="badge badge-info">'.$nt['cnt'].'</span></a>':'';
        echo$nou['cnt']>0?'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('users').' Active Users<span id="nav-nou" class="badge badge-info">'.$nou['cnt'].'</span></a>':'';?>
      </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" data-tooltip="tooltip" data-placement="left" title="Account"><img class="img-avatar bg-white" src="<?php if($user['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($user['avatar'])))
        echo'media'.DS.'avatar'.DS.basename($user['avatar']);
      elseif($user['gravatar']!=''){
        if(stristr($user['gravatar'],'@'))
          echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
        elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))
          echo$user['gravatar'];
        else
          echo ADMINNOAVATAR;
      }else
        echo ADMINNOAVATAR;?>" alt="<?php echo$user['username'];?>"></a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-header text-center"><strong>Account</strong></div>
        <a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>"><?php svg('user-settings');?> Settings</a>
        <a class="dropdown-item" href="<?php echo URL.'vcard/'.$user['username'];?>"><?php svg('address-card');?> vCard</a>
        <div class="divider"></div>
        <a class="dropdown-item" href="<?php echo URL;?>"><?php svg('browser-general');?> View Site</a>
        <div class="divider"></div>
        <a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'].'/logout';?>"><?php svg('sign-out');?> Logout</a>
      </div>
    </li>
  </ul>
</header>
<div class="app-body">
