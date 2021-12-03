<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Index - The Beginning
 * @package    index.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
ini_set('session.use_cookies',true);
ini_set('session.use_only_cookies',true);
ini_set('session.use_trans_sid',false);
ini_set('session.use_strict_mode',true);
ini_set('session.cookie_httponly',true);
ini_set('session.cookie_secure',true);
session_cache_limiter('');
header('X-Powered-By:AuroraCMS');
header("Strict-Transport-Security:max-age=31536000;includeSubDomains");
header("X-Frame-Options:SAMEORIGIN");
header("X-XSS-Protection:1;mode=block");
header("X-Content-Type-Options:nosniff");
header("Referrer-Policy:no-referrer-when-downgrade");
//header("Expires: ".gmdate("D, d M Y H:i:s", time() + 31536000) . " GMT"); // Cache for 1 year.
//header("Pragma: cache");
//header("Cache-Control: max-age=31536000"); // Cache max age for 1 year.
$whitelist=array('127.0.0.1','::1');
if(!in_array($_SERVER['REMOTE_ADDR'],$whitelist)){
  header("Content-Security_policy:default-src 'none';script-src 'self' www.google-analytics.com ajax.googleapis.com;connect-src 'self';img-src 'self';style-src 'self';base-uri 'self';form-action 'self';");
}
header("Permissions-Policy:camera=(),fullscreen=self,geolocation=*,microphone=self");
define('DS',DIRECTORY_SEPARATOR);
define('UNICODE','UTF-8');
define('ROOT_DIR',realpath(__DIR__));
if(extension_loaded('mbstring')){
  mb_internal_encoding("UTF-8");
  mb_http_output("UTF-8");
}else{
  echo'The "mbstring" module is required for AuroraCMS to function. Please install and/or enable this module.';
  die();
}
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
if(session_status()==PHP_SESSION_NONE){
  session_start();
  define('SESSIONID',session_id());
}
require'core'.DS.'core.php';
