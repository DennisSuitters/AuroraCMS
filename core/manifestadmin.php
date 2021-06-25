<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Manifest Generator
 * @package    core/manifestadmin.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type: application/json');
require'db.php';
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
if(!defined('URL'))define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('FAVICON','images/favicon.png');
define('FAVICONTYPE','image/png');
echo json_encode([
  "name"=>'AuroraCMS',
  "gcm_user_visible_only"=>true,
  "short_name"=>'AuroraCMS',
  "description"=>'Administration Area for AuroraCMS',
  "start_url"=>'/',
  "display"=>"standalone",
  "background_color"=>'#000',
  "theme_color"=>"#000000",
  "icons"=>[
    [
      "src"=>FAVICON,
      "sizes"=>"64x64",
      "type"=>FAVICONTYPE
    ],
  ]
]);
