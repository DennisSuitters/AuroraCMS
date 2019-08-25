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
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(session_status()==PHP_SESSION_NONE){
  session_start();
  define('SESSIONID',session_id());
}
if(file_exists('..'.DS.'..'.DS.'core'.DS.'config.ini'))
  $settings=parse_ini_file('..'.DS.'..'.DS.'core'.DS.'config.ini',TRUE);
elseif(file_exists('..'.DS.'core'.DS.'config.ini'))
  $settings=parse_ini_file('..'.DS.'core'.DS.'config.ini',TRUE);
elseif(file_exists('core'.DS.'config.ini'))
  $settings=parse_ini_file('core'.DS.'config.ini',TRUE);
elseif(file_exists('config.ini'))
  $settings=parse_ini_file('config.ini',TRUE);
else{
  require(ROOT_DIR.DS.'core'.DS.'layout'.DS.'install.php');
  die();
}
$prefix=$settings['database']['prefix'];
try{
  $dns=((!empty($settings['database']['driver']))?($settings['database']['driver']):'').((!empty($settings['database']['host']))?(':host='.$settings['database']['host']):'').((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').((!empty($settings['database']['schema']))?(';dbname='.$settings['database']['schema']):'');
  $db=new PDO($dns,$settings['database']['username'],$settings['database']['password']);
  $db->exec("set names utf8");
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  if(isset($getcfg)&&$getcfg==true){
    $config=$db->query("SELECT * FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    date_default_timezone_set($config['timezone']);
    if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
      if(!defined('PROTOCOL'))define('PROTOCOL','https://');
    }else{
      if(!defined('PROTOCOL'))define('PROTOCOL','http://');
    }
    if($config['development']==1){
      error_reporting(E_ALL);
      ini_set('display_errors','On');
    }else{
      error_reporting(E_ALL);
      ini_set('display_errors','Off');
      ini_set('log_errors','On');
      ini_set('error_log','..'.DS.'media'.DS.'cache'.DS.'error.log');
    }
    if(session_status()==PHP_SESSION_NONE){
      session_start();
      define('SESSIONID',session_id());
    }
  }
}catch(PDOException $e){
  require'core'.DS.'layout'.DS.'install.php';
  die();
}
