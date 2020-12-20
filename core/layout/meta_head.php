<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Meta-Head
 * @package    core/layout/meta_head.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    Add test in Administration Header to test if admin.css exists,
 *             and add if it does. This is for the WYSIWYG Editor to make text
 *             look the same in the Editor as it does on the Main Site.
 */?>
<!DOCTYPE HTML>
<!--
     AuroraCMS - Administration - Copyright (C) Diemen Design 2019
          the Australian MIT Licensed Open Source Content Management System.

     Project Maintained at https://github.com/DiemenDesign/AuroraCMS
-->
<html lang="en" id="AuroraCMS">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="AuroraCMS">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo(isset($navStat)&&$navStat>0?'('.$navStat.') ':'');?>Administration <?php echo($config['business']!=''?' for '.$config['business']:'');?> - AuroraCMS</title>
    <base href="<?php echo URL;?>">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="<?php echo$config['language'];?>" href="<?php echo URL;?>">
    <link rel="manifest" href="<?php echo URL.'core'.DS.'manifestadmin.php';?>">
    <link rel="icon" href="<?php echo$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo$favicon;?>">
    <Link rel="stylesheet" type="text/css" href="core/css/style.css">
    <link rel="stylesheet" type="text/css" href="core/js/jquery/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="core/elfinder/css/elfinder.min.css">
    <link rel="stylesheet" type="text/css" href="core/js/simplecolorpicker/jquery.simplecolorpicker.css">
    <link rel="stylesheet" type="text/css" href="core/js/codemirror/codemirror.css">
    <link rel="stylesheet" type="text/css" href="core/js/leaflet/leaflet.css">
    <script src="core/js/jquery/jquery.min.js"></script>
    <script src="core/js/jquery/jquery-ui.min.js"></script>
    <script src="core/js/summernote/summernote.js"></script>
    <script src="core/js/summernote/plugin/summernote-save-button/summernote-save-button.js"></script>
    <script src="core/js/summernote/plugin/summernote-classes/summernote-classes.js"></script>
    <script src="core/js/summernote/plugin/summernote-checkbox/summernote-checkbox.js"></script>
    <script src="core/js/codemirror/codemirror.js"></script>
    <script src="core/js/summernote/plugin/elfinder/elfinder.js"></script>
    <script src="core/elfinder/js/elfinder.min.js"></script>
    <script src="core/js/simplecolorpicker/jquery.simplecolorpicker.js"></script>
    <script src="core/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="core/js/fancybox/jquery.fancybox.min.js"></script>
    <script src="core/js/leaflet/leaflet.js"></script>
    <script src="core/js/aurora.min.js"></script>
  </head>
  <body class="<?php if(isset($_COOKIE['theme'])&&$_COOKIE['theme']!=''){echo' '.$_COOKIE['theme'];}if($config['development'][0]==1&&$user['rank']>999)echo' development" data-width="" data-height="" onload="$(`body`).attr(`data-width`,$(window).width());$(`body`).attr(`data-height`,$(window).height());" onresize="$(`body`).attr(`data-width`,$(window).width());$(`body`).attr(`data-height`,$(window).height());"';?>">
  <?php if($config['development'][0]==1&&$user['rank']>999)echo'<div class="development"></div><div class="developmentbottom"></div>';?>
