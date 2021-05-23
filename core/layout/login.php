<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Login
 * @package    core/layout/login.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */?>
<!DOCTYPE html>
<!--
     AuroraCMS - Administration - Copyright (C) Diemen Design 2019
          the MIT Licensed Open Source Content Management System.

     Project Maintained at https://github.com/DiemenDesign/AuroraCMS
-->
<html lang="en" id="AuroraCMS">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="AuroraCMS">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="application-name" content="AuroraCMS">
    <meta name="description" content="Administration <?=($config['business']!=''?' for '.$config['business']:'');?> - AuroraCMS">
    <title>Administration <?=($config['business']!=''?' for '.$config['business']:'');?> - AuroraCMS</title>
    <base href="<?= URL;?>">
    <link rel="manifest" href="<?= URL;?>core/manifestadmin.php">
    <meta name="theme-color" content="#000000">
    <link rel="alternate" media="handheld" href="<?= URL;?>">
    <link rel="alternate" hreflang="<?=$config['language'];?>" href="<?= URL;?>">
    <link rel="icon" href="<?=$favicon;?>">
    <link rel="apple-touch-icon" href="<?= URL.$favicon;?>">
    <Link rel="stylesheet" type="text/css" href="core/css/style.css">
  </head>
  <body class="aurora<?=(isset($_COOKIE['theme'])&&$_COOKIE['theme']!='')?' '.$_COOKIE['theme']:''?>">
    <main class="row">
      <div class="col-12 col-sm-3 mx-auto mt-0 mt-sm-5 p-5 p-sm-0">
        <noscript><div class="alert alert-danger" role="alert">Javascript MUST BE ENABLED for AuroraCMS to function correctly!</div></noscript>
        <div class="m-4">
          <img class="login-logo" src="core/images/auroracms-white.svg" alt="AuroraCMS">
          <div class="tagline">THE AUSTRALIAN CONTENT MANAGEMENT SYSTEM</div>
        </div>
        <form id="login" method="post" action="<?=(isset($_SERVER['HTTP_REFERER'])&&stristr($_SERVER['REQUEST_URI'],'logout')?$_SERVER['HTTP_REFERER']:URL.$settings['system']['admin'].'/dashboard');?>" accept-charset="UTF-8">
          <input name="act" type="hidden" value="login">
          <div class="row mt-3">
            <label for="username" class="text-white text-md-black">Username</label>
            <input id="username" name="username" type="text" placeholder="Username..." required aria-required="true" aria-label="Username">
          </div>
          <div class="row mt-3">
            <label for="password" class="text-white text-md-black">Password</label>
            <input id="password" name="password" type="password" placeholder="Password..." autocomplete="off" required aria-required="true" aria-label="Password">
          </div>
          <div class="row mt-4">
            <button type="submit" aria-label="Sign In">Sign In</button>
          </div>
        </form>
        <form class="d-none" id="panel-rst" target="rstfeedback" method="post" action="core/rst.php" accept-charset="UTF-8">
          <input name="emailtrap" type="hidden" value="none">
          <div class="row mt-3">
            <label for="rst" class="text-white text-md-black">Enter Email Associated with Account</label>
            <input id="rst" name="rst" type="email" value="" autocomplete="off" placeholder="Enter an Email..." required aria-required="true">
          </div>
          <div class="row mt-4">
            <button id="rstbusy" type="submit" aria-label="Send Reset Password Email">Send</button>
          </div>
          <div class="form-row" id="rstfeedback"></div>
        </form>
        <div class="row mt-4">
          <button onclick="$('#login,#panel-rst,.btn-message').toggleClass('d-none');"><span class="btn-message">Reset Password</span><span class="btn-message d-none">I remembered, take me back to Login</span></button>
        </div>
        <div class="row mt-4 text-center">
          <a href="<?= URL;?>">&larr; Back to <?=$config['business']!=''?$config['business']:'Main Site';?></a>
        </div>
        <div class="row mt-4">
          <footer class="footer text-center">
            <a href="https://github.com/DiemenDesign/AuroraCMS" title="Project Source Hosted on GitHub, where you can also report Issues."><img class="tasmanian" src="core/images/octocat.svg" alt="GitHub Octocat."></a> <a href="https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE" title="AuroraCMS is MIT Licensed."><img class="tasmanian" src="core/images/mit.svg" alt="AuroraCMS is MIT Licensed."></a> <img class="tasmanian" src="core/images/tasmania.svg" data-tooltip="tooltip" alt="Made in Tasmania for Australian Businesses." title="Made in Tasmania for Australian Businesses.">
          </footer>
        </div>
      </div>
    </main>
    <script src="core/js/jquery/jquery.min.js"></script>
    <script src="core/js/aurora.min.js"></script>
    <script>
      if('serviceWorker' in navigator){
        window.addEventListener('load',()=>{
          navigator.serviceWorker.register('core/js/service-worker-admin.php',{
            scope:'/'
          }).then((reg)=>{
            console.log('[AuroraCMS] Administration Service worker registered.',reg);
          });
        });
      }
    </script>
  </body>
</html>
