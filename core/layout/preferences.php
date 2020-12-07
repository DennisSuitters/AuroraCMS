<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences
 * @package    core/layout/preferences.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]==''){?>
  <main>
    <section id="content">
      <div class="content-title-wrapper mb-0">
        <div class="content-title">
          <div class="content-title-heading">
            <div class="content-title-icon"><?php svg('settings','i-3x');?></div>
            <div>Preferences</div>
            <div class="content-title-actions"></div>
          </div>
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">Preferences</li>
          </ol>
        </div>
      </div>
      <div class="container-fluid p-0">
        <div class="card border-radius-0 shadow p-3">
          <div class="row">
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/theme';?>" aria-label="Go to Theme Preferences">
              <span class="h5">Theme</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('theme','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/contact';?>" aria-label="Go to Contact Preferences">
              <span class="h5">Contact</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('address-card','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/social';?>" aria-label="Go to Social Preferences">
              <span class="h5">Social</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('user-group','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/interface';?>" aria-label="Go to Interface Preferences">
              <span class="h5">Interface</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('sliders','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/seo';?>" aria-label="Go to SEO Preferences">
              <span class="h5">SEO</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('plugin-seo','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>" aria-label="Go to Activity">
              <span class="h5">Activity</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('activity','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>" aria-label="Go to Tracker">
              <span class="h5">Tracker</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('tracker','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/security';?>" aria-label="Go to Security Preferences">
              <span class="h5">Security</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('security','i-5x');?></span>
            </a>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-md-1" href="<?php echo URL.$settings['system']['admin'].'/preferences/database';?>" aria-label="Go to Database Preferences">
              <span class="h5">Database</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><?php svg('database','i-5x');?></span>
            </a>
          </div>
          <?php include'core/layout/footer.php';?>
        </div>
      </div>
    </section>
  </main>
<?php }else
  include'core'.DS.'layout'.DS.'pref_'.$args[0].'.php';
