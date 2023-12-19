<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Meta-Head
 * @package    core/layout/meta_head.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<!DOCTYPE HTML>
<!--
     AuroraCMS - Administration - Copyright (C) Diemen Design 2022
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
    <title><?=(isset($navStat)&&$navStat>0?'('.$navStat.') ':'');?><?=($config['business']!=''?$config['business']:'');?> Administration</title>
    <base href="<?= URL;?>">
    <link rel="alternate" media="handheld" href="<?= URL;?>">
    <link rel="alternate" hreflang="<?=$config['language'];?>" href="<?= URL;?>">
    <link rel="manifest" href="<?= URL.'core/manifestadmin.php';?>">
    <link rel="icon" href="core/images/favicon-64.png">
    <link rel="apple-touch-icon" href="core/images/favicon-64.png">
    <Link rel="stylesheet" type="text/css" href="core/css/style.css" media="all">
    <script src="core/js/jquery/jquery.min.js"></script>
    <script src="core/js/jquery/jquery-ui.min.js"></script>
    <script src="core/js/summernote/summernote.min.js"></script>
    <script src="core/js/summernote/plugin/summernote-save-button/summernote-save-button.js"></script>
    <script src="core/js/summernote/plugin/summernote-cleaner/summernote-cleaner.js"></script>
    <script src="core/js/summernote/plugin/summernote-image-attributes/skunkworks/summernote-image-attributes.js"></script>
    <script src="core/js/summernote/plugin/summernote-image-captionit/summernote-image-captionit.js"></script>
    <script src="core/js/summernote/plugin/summernote-classes/summernote-classes.js"></script>
    <script src="core/js/summernote/plugin/summernote-checkbox/summernote-checkbox.js"></script>
    <script src="core/js/summernote/plugin/summernote-audio/summernote-audio.js"></script>
    <script src="core/js/summernote/plugin/summernote-text-findnreplace/summernote-text-findnreplace.js"></script>
    <script src="core/js/summernote/plugin/summernote-templates/summernote-templates.js"></script>
    <script src="core/js/summernote/plugin/summernote-cleaner/summernote-cleaner.js"></script>
    <script src="core/js/codemirror/codemirror.js"></script>
    <script src="core/js/summernote/plugin/elfinder/elfinder.js"></script>
    <script src="core/elfinder/js/elfinder.min.js"></script>
    <script src="core/js/simplecolorpicker/jquery.simplecolorpicker.js"></script>
    <script src="core/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="core/js/fancybox/jquery.fancybox.min.js"></script>
    <script src="core/js/leaflet/leaflet.js"></script>
    <script src="core/js/shuffle/shuffle.js"></script>
    <script src="core/js/chartjs/chart.umd.min.js"></script>
    <script src="core/js/filerobot/filerobot-image-editor.min.js"></script>
    <script src="core/js/tinysort/tinysort.min.js"></script>
    <script src="core/js/tagify/tagify.min.js"></script>
    <script src="core/js/aurora.min.js"></script>
  </head>
  <body class="<?=($config['options'][4]==0?'no-tooltip':'').($user['rank']==1000&&$config['development']==1?' dev':'');?>" data-width="" data-theme="<?= (isset($_COOKIE['admintheme'])&&$_COOKIE['admintheme']!='')?$_COOKIE['admintheme']:'';?>">
