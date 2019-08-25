<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences
 * @package    core/layout/preferences.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Adjust Links Layout Items
 */
if($args[0]==''){?>
  <main id="content" class="main">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Preferences</li>
    </ol>
    <div class="container-fluid">
      <div class="row">
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/theme';?>" aria-label="Go to Theme Preferences">
          <span class="card">
            <span class="card-header h5">Theme</span>
            <span class="card-body card-text text-center pt-0"><?php svg('theme','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/contact';?>" aria-label="Go to Contact Preferences">
          <span class="card">
            <span class="card-header h5">Contact</span>
            <span class="card-body card-text text-center pt-0"><?php svg('address-card','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/social';?>" aria-label="Go to Social Preferences">
          <span class="card">
            <span class="card-header h5">Social</span>
            <span class="card-body card-text text-center pt-0"><?php svg('user-group','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/interface';?>" aria-label="Go to Interface Preferences">
          <span class="card">
            <span class="card-header h5">Interface</span>
            <span class="card-body card-text text-center pt-0"><?php svg('sliders','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/seo';?>" aria-label="Go to SEO Preferences">
          <span class="card">
            <span class="card-header h5">SEO</span>
            <span class="card-body card-text text-center pt-0"><?php svg('plugin-seo','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>" aria-label="Go to Activity">
          <span class="card">
            <span class="card-header h5">Activity</span>
            <span class="card-body card-text text-center pt-0"><?php svg('activity','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>" aria-label="Go to Tracker">
          <span class="card">
            <span class="card-header h5">Tracker</span>
            <span class="card-body card-text text-center pt-0"><?php svg('tracker','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/security';?>" aria-label="Go to Security Preferences">
          <span class="card">
            <span class="card-header h5">Security</span>
            <span class="card-body card-text text-center pt-0"><?php svg('security','i-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/database';?>" aria-label="Go to Database Preferences">
          <span class="card">
            <span class="card-header h5">Database</span>
            <span class="card-body card-text text-center pt-0"><?php svg('database','i-5x');?></span>
          </span>
        </a>
      </div>
    </div>
  </main>
<?php }else
  include'core'.DS.'layout'.DS.'pref_'.$args[0].'.php';
