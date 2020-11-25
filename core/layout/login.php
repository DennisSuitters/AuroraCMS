<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Login
 * @package    core/layout/login.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
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
    <meta name="description" content="Administration <?php echo($config['business']!=''?' for '.$config['business']:'');?> - AuroraCMS">
    <title>Administration <?php echo($config['business']!=''?' for '.$config['business']:'');?> - AuroraCMS</title>
    <base href="<?php echo URL;?>">
    <link rel="manifest" href="<?php echo URL;?>core/manifestadmin.php">
    <meta name="theme-color" content="#000000">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="<?php echo$config['language'];?>" href="<?php echo URL;?>">
    <link rel="icon" href="<?php echo$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo'core'.DS.'css'.DS.'style.css';?>">
  </head>
  <body class="<?php if(isset($_COOKIE['theme'])&&$_COOKIE['theme']!=''){echo' '.$_COOKIE['theme'];}?>">
    <main>
      <div class="row position-relative">
        <div class="col-12 col-md-6 p-0 m-0 vert-shadow d-none d-md-block <?php currentSeason();?>">
          <time class="logindate mr-3" datetime="<?php echo date("Y-m-d\TH:i:s");?>"><?php echo date($config['dateFormat']);?></time>
        </div>
        <div class="col-12 col-md-6 mt-5 p-5">
          <noscript><div class="alert alert-danger" role="alert">Javascript MUST BE ENABLED for AuroraCMS to function correctly!</div></noscript>
          <img class="login-logo m-4" src="core/images/auroracms.svg" alt="AuroraCMS">
          <form id="login" method="post" action="<?php echo (requestSameDomain()==true?$_SERVER['HTTP_REFERER']:rtrim($settings['system']['admin'],'/').'/dashboard');?>" accept-charset="UTF-8">
            <input name="act" type="hidden" value="login">
            <div class="row mt-3">
              <label for="username">Username</label>
              <input id="username" name="username" type="text" placeholder="Username..." required aria-required="true" aria-label="Username">
            </div>
            <div class="row mt-3">
              <label for="password">Password</label>
              <input id="password" name="password" type="password" placeholder="Password..." autocomplete="off" required aria-required="true" aria-label="Password">
            </div>
            <div class="row mt-4">
              <button type="submit" aria-label="Sign In">Sign In</button>
            </div>
          </form>
          <form class="d-none" id="panel-rst" target="rstfeedback" method="post" action="core/rst.php" accept-charset="UTF-8">
            <input name="emailtrap" type="hidden" value="none">
            <div class="row mt-3" data-tooltip="tooltip" data-title="Enter Email Associcated With Account">
              <input id="rst" name="rst" type="text" value="" autocomplete="off" placeholder="Enter an Email..." required aria-required="true" aria-label="Enter Email Associated with Account">
            </div>
            <div class="row mt-4">
              <button id="rstbusy" type="submit" aria-label="Send Reset Password Email">Send</button>
            </div>
            <div class="form-row" id="rstfeedback"></div>
          </form>
          <div class="row mt-4">
            <button data-tooltip="tooltip" data-title="Click to show Password Reset Field" aria-label="Reset Password" onclick="$('#login,#panel-rst,.btn-message').toggleClass('d-none');"><span class="btn-message">Reset Password</span><span class="btn-message d-none">I remembered, take me back to Login</span></button>
          </div>
          <div class="row mt-5 text-center">
            <a href="<?php echo URL;?>">&larr; Back to <?php echo$config['business']!=''?$config['business']:'Main Site';?></a>
          </div>
          <div class="row mt-4">
            <?php include'core/layout/footer.php';?>
          </div>
        </div>
      </div>
    </main>
    <script src="<?php echo'core'.DS.'js'.DS.'jquery.min.js';?>"></script>
    <script src="<?php echo'core'.DS.'js'.DS.'js.js';?>"></script>
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
