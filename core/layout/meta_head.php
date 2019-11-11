<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Meta-Head contains <head> and Stylesheet logic and JS Links
 *
 * @category   Administration - Meta-Head
 * @package    core/layout/meta_head.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.2
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
    <title>Administration <?php echo($config['business']!=''?' for '.$config['business']:'');?> - AuroraCMS</title>
    <base href="<?php echo URL;?>">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="<?php echo$config['language'];?>" href="<?php echo URL;?>">
    <link rel="icon" href="<?php echo URL.$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'bootstrap.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'jquery-ui.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'elfinder'.DS.'css'.DS.'elfinder.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'fullcalendar.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'jquery.fancybox.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'jquery.simplecolorpicker.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'i.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'codemirror.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'daterangepicker.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'aurora.css';?>">
<?php if(file_exists(THEME.DS.'css'.DS.'admin.css'))echo'<link rel="stylesheet" type="text/css" href="'.THEME.DS.'css'.DS.'admin.css">';?>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery-ui.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'bootstrap.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'summernote-lite.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'plugin'.DS.'summernote'.DS.'summernote-save-button.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'codemirror.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'plugin'.DS.'elfinder'.DS.'elfinder.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'elfinder'.DS.'js'.DS.'elfinder.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'aurora.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.fancybox.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.simplecolorpicker.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'moment.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'fullcalendar.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'daterangepicker.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'js.js';?>"></script>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
