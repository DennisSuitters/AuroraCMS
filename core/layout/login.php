<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Login
 * @package    core/layout/login.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<!DOCTYPE html>
<!--
  AuroraCMS - the MIT Licensed Open Source Content Management System.
  Built for Australian inhabitants of the Tau`ri.

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
    <link rel="icon" href="core/images/favicon-64.png">
    <link rel="apple-touch-icon" href="core/images/favicon-64.png">
    <Link rel="stylesheet" type="text/css" href="core/css/style.css">
  </head>
  <?php $sl=$db->prepare("SELECT * FROM `".$prefix."widgets` WHERE `ref`='loginimage' AND `file`!='' ORDER BY rand() LIMIT 1");
  $sl->execute();
  $timetofadein=1000;
  $bg='';
  $attribution='';
  if($sl->rowCount()>0){
    $rl=$sl->fetch(PDO::FETCH_ASSOC);
    $timetofadein=3000;
    $attribution=$rl['layout'];
    if($rl['file']!='')$bg=$rl['file'];
  }?>
  <body class="login-bg">
    <main class="row m-0 p-0 justify-content-center">
      <div class="card col-11 col-sm-6 col-md-6 col-lg-3 col-xl-4 col-xxl-3 m-0 my-5 p-5">
        <noscript><div class="alert alert-danger" role="alert">Javascript MUST BE ENABLED for AuroraCMS to function correctly!</div></noscript>
        <form id="login" method="post" action="<?=(isset($_SERVER['HTTP_REFERER'])&&stristr($_SERVER['REQUEST_URI'],'logout')?$_SERVER['HTTP_REFERER']:URL.$settings['system']['admin'].'/'.$config['defaultPage']);?>" accept-charset="UTF-8">
          <input name="act" type="hidden" value="login">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" placeholder="Username..." required aria-required="true" aria-label="Username">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Password..." autocomplete="off" required aria-required="true" aria-label="Password">
          <div class="row mt-4">
            <button type="submit" aria-label="Sign In">Sign In</button>
          </div>
        </form>
        <form class="d-none" id="panel-rst" target="rstfeedback" method="post" action="core/rst.php" accept-charset="UTF-8">
          <input name="emailtrap" type="hidden" value="">
          <input name="act" type="hidden" value="reset_password">
          <label for="rst">Enter Email Associated with Account</label>
          <input id="rst" name="email" type="email" value="" autocomplete="off" placeholder="Enter an Email..." required aria-required="true">
          <div class="row mt-4">
            <button class="btn-block" id="rstbusy" type="submit" aria-label="Send Reset Password Email">Send Reset Password Email</button>
            <div class="form-row mt-3 hideifempty" id="reset"></div>
          </div>
        </form>
        <div class="row mt-4">
          <button onclick="$('#login,#panel-rst,.btn-message').toggleClass('d-none');"><span class="btn-message">Reset Password</span><span class="btn-message d-none">I remembered, take me back to Login</span></button>
        </div>
        <div class="row mt-4 text-center">
          <a href="<?= URL;?>"><i class="i align-middle">arrow-left</i> Back to <?=$config['business']!=''?$config['business']:'Main Site';?></a>
        </div>
      </div>
    </main>
    <footer class="loginattribution"></footer>
    <script src="core/js/jquery/jquery.min.js"></script>
    <script src="core/js/aurora.min.js"></script>
<?php if($bg!=''){?>
    <script>
      $(document).ready(function(){
        setTimeout(function(){
          $('.login-bg').css("background-image","url(<?=$bg;?>)");
          $('.login-bg .card').css("box-shadow","0 22px 64px 8px rgba(0,0,0,1)");
          $('.loginattribution').html(`<?=$attribution;?>`);
        },<?=$timetofadein;?>);
      });
    </script>
<?php }?>
  </body>
</html>
