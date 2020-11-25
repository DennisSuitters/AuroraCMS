<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Sidebar Menu
 * @package    core/layout/set_sidebar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<aside class="border-right" id="sidebar">
  <nav>
    <ul>
      <li class="<?php echo($view=='dashboard'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>"><?php svg('dashboard','i-2x mr-4');?> Dashboard</a></li>
      <li class="<?php echo($view=='livechat'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/livechat';?>"><?php svg('chat','i-2x mr-4');?> Live Chat</a></li>
      <li class="<?php echo($view=='media'||$view=='pages'||$view=='content'||$view=='rewards'?' open':'');?>">
        <a class="opener" href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php svg('content','i-2x mr-4');?> Content</a>
        <span class="arrow<?php echo($view=='media'||$view=='pages'||$view=='content'||$view=='rewards'||$view=='newsletters'?' open':'');?>"><?php svg('arrow-up');?></span>
        <ul>
          <?php if($user['options'][0]==1){?>
            <li class="<?php echo($view=='media'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/media';?>"><?php svg('picture','i-2x mr-4');?> Media</a></li>
          <?php }?>
          <li class="<?php echo($view=='pages'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php svg('content','i-2x mr-4');?> Pages</a></li>
          <li class="<?php echo($args[0]=='scheduler'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>"><?php svg('calendar-time','i-2x mr-4');?> Scheduler</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='article'?' active':'');?>"><a id="menu-article" href="<?php echo URL.$settings['system']['admin'].'/content/type/article';?>"><?php svg('content','i-2x mr-4');?> Articles</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='portfolio'?' active':'');?>"><a id="menu-portfolio" href="<?php echo URL.$settings['system']['admin'].'/content/type/portfolio';?>"><?php svg('portfolio','i-2x mr-4');?> Portfolio</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='events'?' active':'');?>"><a id="menu-events" href="<?php echo URL.$settings['system']['admin'].'/content/type/events';?>"><?php svg('calendar','i-2x mr-4');?> Events</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='news'?' active':'');?>"><a id="menu-news" href="<?php echo URL.$settings['system']['admin'].'/content/type/news';?>"><?php svg('email-read','i-2x mr-4');?> News</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='testimonials'?' active':'');?>"><a id="menu-testimonials" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>"><?php svg('testimonial','i-2x mr-4');?> Testimonials</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='inventory'?' active':'');?>"><a id="menu-inventory" href="<?php echo URL.$settings['system']['admin'].'/content/type/inventory';?>"><?php svg('shipping','i-2x mr-4');?> Inventory</a></li>
          <li class="<?php echo($view=='rewards'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/rewards';?>"><?php svg('credit-card','i-2x mr-4');?> Rewards</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='service'?' active':'');?>"><a id="menu-service" href="<?php echo URL.$settings['system']['admin'].'/content/type/service';?>"><?php svg('service','i-2x mr-4');?> Services</a></li>
          <li class="<?php echo(isset($args[1])&&$args[1]=='proofs'?' active':'');?>"><a id="menu-proofs" href="<?php echo URL.$settings['system']['admin'].'/content/type/proofs';?>"><?php svg('proof','i-2x mr-4');?> Proofs</a></li>
        </ul>
      </li>
      <?php if($user['options'][3]==1){?>
        <li class="<?php echo($view=='messages'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('inbox','i-2x mr-4');?> Messages</a></li>
      <?php }?>
      <li class="<?php echo($view=='newsletters'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>"><?php svg('newspaper','i-2x mr-4');?> Newsletters</a></li>
      <li class="<?php echo($view=='bookings'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php svg('calendar','i-2x mr-4');?> Bookings</a></li>
      <?php if($user['options'][4]==1){?>
        <li class="<?php echo$view=='orders'?' open':'';?>">
          <a class="opener" href="<?php echo URL.$settings['system']['admin'].'/orders';?>"><?php svg('order','i-2x mr-4');?> Orders</a>
          <span class="arrow<?php echo$view=='orders'?' open':'';?>"><?php svg('arrow-up');?></span>
          <ul>
            <li class="<?php echo($view=='orders'&&$args[0]==''?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>"><?php svg('order-quote','i-2x mr-4');?> All</a></li>
            <li class="<?php echo($args[0]=='quotes'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/orders/quotes';?>"><?php svg('order-quote','i-2x mr-4');?> Quotes</a></li>
            <li class="<?php echo($args[0]=='invoices'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/orders/invoices';?>"><?php svg('order-invoice','i-2x mr-4');?> Invoices</a></li>
            <li class="<?php echo($args[0]=='pending'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/orders/pending';?>"><?php svg('order-pending','i-2x mr-4');?> Pending</a></li>
            <li class="<?php echo($args[0]=='recurring'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/orders/recurring';?>"><?php svg('order-recurring','i-2x mr-4');?> Recurring</a></li>
            <li class="<?php echo($args[0]=='archived'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/orders/archived';?>"><?php svg('order-archived','i-2x mr-4');?> Archived</a></li>
          </ul>
        </li>
      <?php }?>
      <li class="<?php echo($view=='accounts'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php svg('users','i-2x mr-4');?> Accounts</a></li>
      <?php if($user['options'][7]==1){?>
        <li class="<?php echo($view=='preferences'?' open':'');?>">
          <a class="opener" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php svg('settings','i-2x mr-4');?> Preferences</a>
          <span class="arrow<?php echo($view=='preferences'?' open':'');?>"><?php svg('arrow-up');?></span>
          <ul>
            <li class="<?php echo($args[0]=='theme'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/theme';?>"><?php svg('theme','i-2x mr-4');?> Theme</a></li>
            <li class="<?php echo($args[0]=='contact'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/contact';?>"><?php svg('address-card','i-2x mr-4');?> Contact</a></li>
            <li class="<?php echo($args[0]=='social'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/social';?>"><?php svg('user-group','i-2x mr-4');?> Social</a></li>
            <li class="<?php echo($args[0]=='interface'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/interface';?>"><?php svg('sliders','i-2x mr-4');?> Interface</a></li>
            <li class="<?php echo($args[0]=='seo'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/seo';?>"><?php svg('plugin-seo','i-2x mr-4');?> SEO</a></li>
            <li class="<?php echo($args[0]=='activity'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>"><?php svg('activity','i-2x mr-4');?> Activity</a></li>
            <li class="<?php echo($args[0]=='tracker'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>"><?php svg('tracker','i-2x mr-4');?> Tracker</a></li>
            <li class="<?php echo($args[0]=='cart'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/cart';?>"><?php svg('shop-cart','i-2x mr-4');?> Cart</a></li>
            <li class="<?php echo($args[0]=='security'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/security';?>"><?php svg('security','i-2x mr-4');?> Security</a></li>
            <li class="<?php echo($args[0]=='database'?' active':'');?>"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/database';?>"><?php svg('database','i-2x mr-4');?> Database</a></li>
          </ul>
        </li>
      <?php }?>
    </ul>
  </nav>
</aside>
