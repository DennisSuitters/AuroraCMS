<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Sidebar Menu
 * @package    core/layout/set_sidebar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Add Settings to Menu for easier access.
 * @changes    v0.1.2 Use PHP short codes where possible.
 */
echo'<aside class="border-right" id="sidebar">'.
  '<nav>'.
    '<ul>'.
      '<li class="'.($view=='dashboard'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/dashboard">'.svg2('dashboard','i-2x mr-4').' Dashboard</a></li>'.
      '<li class="'.($args[0]!='settings'&&$view=='livechat'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/livechat">'.svg2('chat','i-2x mr-4').' Live Chat</a></li>'.
      '<li class="'.($args[0]!='settings'&&($view=='media'||$view=='pages'||$view=='content'||$view=='rewards')?' open':'').'">'.
        '<a class="opener" href="'.URL.$settings['system']['admin'].'/content">'.svg2('content','i-2x mr-4').' Content</a>'.
        '<span class="arrow'.($args[0]!='settings'&&($view=='media'||$view=='pages'||$view=='content'||$view=='rewards')?' open':'').'">'.svg2('arrow-up').'</span>'.
        '<ul>';
          if($user['options'][0]==1){
            echo'<li class="'.($args[0]!='settings'&&$view=='media'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/media">'.svg2('picture','i-2x mr-4').' Media</a></li>';
          }
          echo'<li class="'.($args[0]!='settings'&&$view=='pages'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/pages">'.svg2('content','i-2x mr-4').' Pages</a></li>'.
          '<li class="'.($args[0]!='settings'&&$args[0]=='scheduler'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/content/scheduler">'.svg2('calendar-time','i-2x mr-4').' Scheduler</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='article'?' active':'').'"><a id="menu-article" href="'.URL.$settings['system']['admin'].'/content/type/article">'.svg2('content','i-2x mr-4').' Articles</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='portfolio'?' active':'').'"><a id="menu-portfolio" href="'.URL.$settings['system']['admin'].'/content/type/portfolio">'.svg2('portfolio','i-2x mr-4').' Portfolio</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='events'?' active':'').'"><a id="menu-events" href="'.URL.$settings['system']['admin'].'/content/type/events">'.svg2('calendar','i-2x mr-4').' Events</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='news'?' active':'').'"><a id="menu-news" href="'.URL.$settings['system']['admin'].'/content/type/news'.'">'.svg2('email-read','i-2x mr-4').' News</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='testimonials'?' active':'').'"><a id="menu-testimonials" href="'.URL.$settings['system']['admin'].'/content/type/testimonials">'.svg2('testimonial','i-2x mr-4').' Testimonials</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='inventory'?' active':'').'"><a id="menu-inventory" href="'.URL.$settings['system']['admin'].'/content/type/inventory">'.svg2('shipping','i-2x mr-4').' Inventory</a></li>'.
          '<li class="'.($args[0]!='settings'&&$view=='rewards'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/rewards">'.svg2('credit-card','i-2x mr-4').' Rewards</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='service'?' active':'').'"><a id="menu-service" href="'.URL.$settings['system']['admin'].'/content/type/service">'.svg2('service','i-2x mr-4').' Services</a></li>'.
          '<li class="'.($args[0]!='settings'&&isset($args[1])&&$args[1]=='proofs'?' active':'').'"><a id="menu-proofs" href="'.URL.$settings['system']['admin'].'/content/type/proofs">'.svg2('proof','i-2x mr-4').' Proofs</a></li>'.
        '</ul>'.
      '</li>';
      if($user['options'][3]==1){
        echo'<li class="'.($args[0]!='settings'&&$view=='messages'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/messages">'.svg2('inbox','i-2x mr-4').' Messages</a></li>';
      }
      echo'<li class="'.($args[0]!='settings'&&$view=='newsletters'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/newsletters">'.svg2('newspaper','i-2x mr-4').' Newsletters</a></li>'.
      '<li class="'.($args[0]!='settings'&&$view=='bookings'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/bookings">'.svg2('calendar','i-2x mr-4').' Bookings</a></li>';
      if($user['options'][4]==1){
        echo'<li class="'.($args[0]!='settings'&&$view=='orders'?' open':'').'">'.
        '<a class="opener" href="'.URL.$settings['system']['admin'].'/orders">'.svg2('order','i-2x mr-4').' Orders</a>'.
        '<span class="arrow'.($args[0]!='settings'&&$view=='orders'?' open':'').'">'.svg2('arrow-up').'</span>'.
        '<ul>'.
          '<li class="'.($args[0]!='settings'&&$view=='orders'&&$args[0]==''?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders">'.svg2('order-quote','i-2x mr-4').' All</a></li>'.
          '<li class="'.($args[0]!='settings'&&$args[0]=='quotes'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders/quotes">'.svg2('order-quote','i-2x mr-4').' Quotes</a></li>'.
          '<li class="'.($args[0]!='settings'&&$args[0]=='invoices'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders/invoices">'.svg2('order-invoice','i-2x mr-4').' Invoices</a></li>'.
          '<li class="'.($args[0]!='settings'&&$args[0]=='pending'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders/pending">'.svg2('order-pending','i-2x mr-4').' Pending</a></li>'.
          '<li class="'.($args[0]!='settings'&&$args[0]=='recurring'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders/recurring">'.svg2('order-recurring','i-2x mr-4').' Recurring</a></li>'.
          '<li class="'.($args[0]!='settings'&&$args[0]=='overdue'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders/overdue">'.svg2('order-pending','i-2x mr-4').' Overdue</a></li>'.
          '<li class="'.($args[0]!='settings'&&$args[0]=='archived'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders/archived">'.svg2('order-archived','i-2x mr-4').' Archived</a></li>'.
        '</ul>'.
      '</li>';
    }
    echo'<li class="'.($args[0]!='settings'&&$view=='accounts'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('users','i-2x mr-4').' Accounts</a></li>'.
    '<li class="'.($args[0]!='settings'&&$view=='comments'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/comments">'.svg2('comments','i-2x mr-4').' Comments</a></li>'.
    '<li class="'.($args[0]!='settings'&&$view=='reviews'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/reviews">'.svg2('review','i-2x mr-4').' Reviews</a></li>';
    if($user['options'][7]==1){
      echo'<li class="'.($args[0]=='settings'?' open':'').'">'.
        '<a class="opener" href="'.URL.$settings['system']['admin'].'/settings">'.svg2('settings','i-2x mr-4').' Settings</a>'.
        '<span class="arrow'.($args[0]=='settings'?' open':'').'">'.svg2('arrow-up').'</span>'.
        '<ul>'.
          '<li class="'.($args[0]=='settings'&&$view=='livechat'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/livechat/settings">'.svg2('chat','i-2x mr-4').' Live Chat</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='media'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/media/settings">'.svg2('picture','i-2x mr-4').' Media</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='pages'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/pages/settings">'.svg2('content','i-2x mr-4').' Pages</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='content'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/content/settings">'.svg2('content','i-2x mr-4').' Content</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='messages'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/messages/settings">'.svg2('inbox','i-2x mr-4').' Messages</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='newsletters'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/newsletters/settings">'.svg2('newspaper','i-2x mr-4').' Newsletters</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='bookings'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/bookings/settings">'.svg2('calendar','i-2x mr-4').' Bookings</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='orders'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/orders/settings">'.svg2('order','i-2x mr-4').' Orders</a></li>'.
          '<li class="'.($args[0]=='settings'&&$view=='accounts'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/accounts/settings">'.svg2('users','i-2x mr-4').' Accounts</a></li>'.
        '</ul>'.
      '</li>'.
      '<li class="'.($view=='preferences'?' open':'').'">'.
        '<a class="opener" href="'.URL.$settings['system']['admin'].'/preferences">'.svg2('settings','i-2x mr-4').' Preferences</a>'.
        '<span class="arrow'.($view=='preferences'?' open':'').'">'.svg2('arrow-up').'</span>'.
        '<ul>'.
          '<li class="'.($args[0]=='theme'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/theme">'.svg2('theme','i-2x mr-4').' Theme</a></li>'.
          '<li class="'.($args[0]=='contact'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/contact">'.svg2('address-card','i-2x mr-4').' Contact</a></li>'.
          '<li class="'.($args[0]=='social'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/social">'.svg2('user-group','i-2x mr-4').' Social</a></li>'.
          '<li class="'.($args[0]=='interface'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/interface">'.svg2('sliders','i-2x mr-4').' Interface</a></li>'.
          '<li class="'.($args[0]=='seo'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/seo">'.svg2('plugin-seo','i-2x mr-4').' SEO</a></li>'.
          '<li class="'.($args[0]=='activity'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/activity">'.svg2('activity','i-2x mr-4').' Activity</a></li>'.
          '<li class="'.($args[0]=='tracker'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/tracker">'.svg2('tracker','i-2x mr-4').' Tracker</a></li>'.
          '<li class="'.($args[0]=='cart'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/cart">'.svg2('shop-cart','i-2x mr-4').' Cart</a></li>'.
          '<li class="'.($args[0]=='security'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/security">'.svg2('security','i-2x mr-4').' Security</a></li>'.
          '<li class="'.($args[0]=='database'?' active':'').'"><a href="'.URL.$settings['system']['admin'].'/preferences/database">'.svg2('database','i-2x mr-4').' Database</a></li>'.
        '</ul>'.
      '</li>';
    }
    echo'</ul>'.
  '</nav>'.
'</aside>';
