<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences
 * @package    core/layout/preferences.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!isset($args[0]) || $args[0]==''){?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 p-4 bg-transparent border-0 overflow-visible">
          <div class="row">
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/theme';?>" aria-label="Go to Theme Preferences">
              <span class="h5">Theme</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">theme</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/contact';?>" aria-label="Go to Contact Preferences">
              <span class="h5">Contact</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">address-card</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/social';?>" aria-label="Go to Social Preferences">
              <span class="h5">Social</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">user-group</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/interface';?>" aria-label="Go to Interface Preferences">
              <span class="h5">Interface</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">sliders</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/seo';?>" aria-label="Go to SEO Preferences">
              <span class="h5">SEO</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">plugin-seo</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/activity';?>" aria-label="Go to Activity">
              <span class="h5">Activity</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">activity</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/tracker';?>" aria-label="Go to Tracker">
              <span class="h5">Tracker</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">tracker</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/security';?>" aria-label="Go to Security Preferences">
              <span class="h5">Security</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">security</i></span>
            </a>
            <a class="card stats col-6 col-sm-2 p-2 m-sm-3" href="<?= URL.$settings['system']['admin'].'/preferences/database';?>" aria-label="Go to Database Preferences">
              <span class="h5">Database</span>
              <span class="p-0">
                <span class="text-3x">&nbsp;</span>
              </span>
              <span class="icon"><i class="i i-5x">database</i></span>
            </a>
          </div>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }else require'core/layout/pref_'.$args[0].'.php';
