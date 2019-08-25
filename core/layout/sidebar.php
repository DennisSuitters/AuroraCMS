<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Sidebar Menu
 * @package    core/layout/set_sidebar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Move Settings Links into Menu.
 */?>
  <div id="sidebar" class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item<?php echo($view=='dashboard'?' active':'');?>">
          <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>"><?php svg('dashboard','nav-icon');?> Dashboard</a>
        </li>
        <li class="nav-item nav-dropdown<?php echo($view=='media'||$view=='pages'||$view=='content'||$view=='rewards'||$view=='newsletters'?' open':'');?>">
          <a class="nav-link nav-dropdown-toggle" href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php svg('content','nav-icon');?> Content</a>
          <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/content/settings';?>" data-tooltip="tooltip" title="Content Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link<?php echo($view=='media'?' active':'');?>" href="<?php echo URL.$settings['system']['admin'].'/media';?>"><?php svg('picture','nav-icon ml-2');?> Media</a>
              <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/media/settings';?>" data-tooltip="tooltip" title="Media Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link<?php echo($view=='pages'?' active':'');?>" href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php svg('content','nav-icon ml-2');?> Pages</a>
              <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/pages/settings';?>" data-tooltip="tooltip" title="Pages Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>"><?php svg('calendar-time','nav-icon ml-2');?> Scheduler</a>
            </li>
            <li class="nav-item">
              <a id="menu-article" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/article';?>"><?php svg('content','nav-icon ml-2');?> Articles</a>
            </li>
            <li class="nav-item">
              <a id="menu-portfolio" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/portfolio';?>"><?php svg('portfolio','nav-icon ml-2');?> Portfolio</a>
            </li>
            <li class="nav-item">
              <a id="menu-events" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/events';?>"><?php svg('calendar','nav-icon ml-2');?> Events</a>
            </li>
            <li class="nav-item">
              <a id="menu-news" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/news';?>"><?php svg('email-read','nav-icon ml-2');?> News</a></li>
            <li class="nav-item">
              <a id="menu-testimonials" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>"><?php svg('testimonial','nav-icon ml-2');?> Testimonials</a>
            </li>
            <li class="nav-item">
              <a id="menu-inventory" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/inventory';?>"><?php svg('shipping','nav-icon ml-2');?> Inventory</a></li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/rewards';?>"><?php svg('credit-card','nav-icon ml-2');?> Rewards</a>
            </li>
            <li class="nav-item">
              <a id="menu-service" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/service';?>"><?php svg('service','nav-icon ml-2');?> Services</a>
            </li>
            <li class="nav-item">
              <a id="menu-proofs" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/proofs';?>"><?php svg('proof','nav-icon ml-2');?> Proofs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>"><?php svg('newspaper','nav-icon ml-2');?> Newsletters</a>
              <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/newsletters/settings';?>" data-tooltip="tooltip" title="Newsletters Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('inbox','nav-icon');?> Messages</a>
          <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/messages/settings';?>" data-tooltip="tooltip" title="Messages Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php svg('calendar','nav-icon');?> Bookings</a>
          <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/bookings/settings';?>" data-tooltip="tooltip" title="Bookings Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="<?php echo URL.$settings['system']['admin'].'/orders';?>"><?php svg('order','nav-icon');?> Orders</a>
          <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/orders/settings';?>" data-tooltip="tooltip" title="Orders Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders';?>"><?php svg('order-quote','nav-icon ml-2');?> All</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/quotes';?>"><?php svg('order-quote','nav-icon ml-2');?> Quotes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/invoices';?>"><?php svg('order-invoice','nav-icon ml-2');?> Invoices</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/pending';?>"><?php svg('order-pending','nav-icon ml-2');?> Pending</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/recurring';?>"><?php svg('order-recurring','nav-icon ml-2');?> Recurring</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/archived';?>"><?php svg('order-archived','nav-icon ml-2');?> Archived</a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php svg('users','nav-icon');?> Accounts</a>
          <a class="nav-settings" href="<?php echo URL.$settings['system']['admin'].'/accounts/settings';?>" data-tooltip="tooltip" title="Accounts Settings" data-placement="right"><?php svg('settings','nav-icon');?></a>
        </li>
<?php if($user['options'][7]==1){?>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php svg('settings','nav-icon');?> Preferences</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/theme';?>"><?php svg('theme','nav-icon ml-2');?> Theme</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/contact';?>"><?php svg('address-card','nav-icon ml-2');?> Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/social';?>"><?php svg('user-group','nav-icon ml-2');?> Social</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/interface';?>"><?php svg('sliders','nav-icon ml-2');?> Interface</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/seo';?>"><?php svg('plugin-seo','nav-icon ml-2');?> SEO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>"><?php svg('activity','nav-icon ml-2');?> Activity</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>"><?php svg('tracker','nav-icon ml-2');?> Tracker</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/security';?>"><?php svg('security','nav-icon ml-2');?> Security</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/database';?>"><?php svg('database','nav-icon ml-2');?> Database</a></li>
          </ul>
        </li>
<?php }
if($user['options']{8}==1){?>
        <li class="nav-divider"></li>
        <li class="nav-title">System Utilization</li>
        <li class="nav-item px-3 d-compact-none d-minimized-none">
          <div class="text-uppercase mb-1">
            <small><b>CPU Usage</b></small>
          </div>
          <div class="progress progress-xs">
            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo getload();?>%" aria-valuenow="<?php echo getload();?>" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <small><?php echo gpc();?> Processes. <?php echo num_cpu();?> Cores.</small>
        </li>
<?php $mem=getmemstats();?>
        <li class="nav-item px-3 d-compact-none d-minimized-none">
          <div class="text-uppercase mb-1">
            <small><b>Memory Usage</b></small>
          </div>
          <div class="progress progress-xs">
            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo$mem['percent'];?>%" aria-valuenow="<?php echo$mem['percent'];?>" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <small><?php echo size_format($mem['used']).'/'.size_format($mem['total']);?></small>
        </li>
        <li class="nav-item px-3 d-compact-none d-minimized-none">
          <div class="text-uppercase">
            <small><b>Server Uptime</b></small>
          </div>
          <small><?php echo shell_exec('uptime -p');?></small>
        </li>
<?php }?>
      </ul>
    </nav>
    <div class="sidebar-minimizer"></div>
  </div>
