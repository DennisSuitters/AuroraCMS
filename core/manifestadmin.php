<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Manifest Generator
 * @package    core/manifestadmin.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type: application/json');
$getcfg=true;
require'db.php';
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(!defined('URL'))define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
echo json_encode([
  "name"=>'LibreCMS',
  "gcm_user_visible_only"=>true,
  "short_name"=>'LibreCMS',
  "description"=>'Administration Area for LibreCMS',
  "start_url"=>URL.$settings['system']['admin'],
  "display"=>"standalone",
  "orientation"=>"portrait",
  "background_color"=>'#000',
  "theme_color"=>"#f0f0f0",
  "icons"=>[
    [
      "src"=>'images'.DS.'favicon.png',
      "sizes"=>"64x64",
      "type"=>'image/png'
    ],
  ]
]);
