<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Database and User Login Mechanism used
 *             everywhere
 * @package    core/db.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(file_exists('../../../VERSION')){
  if(!defined('DS'))define('VERSION',trim(file_get_contents('../../../VERSION')));
}elseif(file_exists('../../VERSION')){
  if(!defined('DS'))define('VERSION',trim(file_get_contents('../../VERSION')));
}elseif(file_exists('../VERSION')){
  if(!defined('DS'))define('VERSION',trim(file_get_contents('../VERSION')));
}else{
  if(!defined('DS'))define('VERSION',trim(file_get_contents('VERSION')));
}
if(session_status()==PHP_SESSION_NONE){
  session_start();
  define('SESSIONID',session_id());
}
if(!isset($_SERVER['SCRIPT_URI'])){
  $_SERVER['SCRIPT_URI']=(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $pos=strrpos($_SERVER['SCRIPT_URI'],'/');
  if($pos!==false)$_SERVER['SCRIPT_URI']=substr($_SERVER['SCRIPT_URI'],0,$pos+1);
}
if(file_exists('../../core/config.ini'))$settings=parse_ini_file('../../core/config.ini',TRUE);
elseif(file_exists('../core/config.ini'))$settings=parse_ini_file('../core/config.ini',TRUE);
elseif(file_exists('core/config.ini'))$settings=parse_ini_file('core/config.ini',TRUE);
elseif(file_exists('config.ini'))$settings=parse_ini_file('config.ini',TRUE);
else{
  require ROOT_DIR.'/core/layout/install.php';
  die();
}
$prefix=$settings['database']['prefix'];
try{
  $dns=((!empty($settings['database']['driver']))?($settings['database']['driver']):'').((!empty($settings['database']['host']))?(':host='.$settings['database']['host']):'').((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').((!empty($settings['database']['schema']))?(';dbname='.$settings['database']['schema']):'');
  $db=new PDO($dns,$settings['database']['username'],$settings['database']['password']);
  $db->exec("set names utf8");
//  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  if($settings['system']['devmode']==true){
    error_reporting(E_ALL);
    ini_set('display_errors','On');
  }else{
    error_reporting(E_ALL);
    ini_set('display_errors','Off');
    ini_set('log_errors','On');
    ini_set('error_log','../media/cache/error.log');
  }
}catch(PDOException $e){
  require'core/layout/install.php';
  die();
}
