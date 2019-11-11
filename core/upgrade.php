<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Upgrade
 * @package    core/upgrade.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
ini_set('max_execution_time',60);
require'db.php';
$config=$db->query("SELECT language,update_url,development FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if($config['development']==1){
  error_reporting(E_ALL);
  ini_set('display_errors','On');
}else{
  error_reporting(E_ALL);
  ini_set('display_errors','Off');
  ini_set('log_errors','On');
  ini_set('error_log','..'.DS.'media'.DS.'cache'.DS.'error.log');
}
echo'<script>'.
  'window.top.window.$(`#updateheading`).html(`System Updates...`);'.
  'window.top.window.$(`#update`).html(``);';
$settings=parse_ini_file('config.ini',TRUE);
$gV=file_get_contents($config['update_url'].'versions');
$update=0;
$uL='';
$found=true;
$vL=explode("\n",$gV);
foreach($vL as $aV){
  if($aV=='')continue;
  if($aV<$settings['system']['version'])continue;
  if(!is_file('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip')){
  echo'window.top.window.$(`#update`).append(`<div class="alert alert-info" role="alert">Downloading New Update!...</div>`);';
   if(false===file_get_contents($config['update_url'].$aV.".zip",0,null,0,1)){
    $found=false;
    echo'window.top.window.$(`#update`).append(`<div class="alert alert-danger" role="alert">File does not exist on remote server!...</div>`);';
  }else{
    $newUpdate=file_get_contents($config['update_url'].$aV.'.zip');
    if(!is_dir('..'.DS.'media'.DS.'updates'.DS))
      mkdir('..'.DS.'media'.DS.'updates'.DS);
    $dlHandler=fopen('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip','w');
    if(!fwrite($dlHandler,$newUpdate)){
      $found=false;
      echo'window.top.window.$(`#update`).append(`<div class="alert alert-danger" role="alert">Could not save new update. Aborted!!!</div>`);';
      exit();
    }
    fclose($dlHandler);
    echo'window.top.window.$(`#update`).append(`<div class="alert alert-success" role="alert">Update Downloaded and Saved!...</div>`);';
    }
  }else{
    echo'window.top.window.$(`#update`).append(`<div class="alert alert-info" role="alert">Update already Downloaded!...</div>`);';
  }
if($found==true){
  $zipHandle=zip_open('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip');
  $html='<ul>';
  while($aF=zip_read($zipHandle)){
    $thisFileName=zip_entry_name($aF);
    $thisFileDir=dirname($thisFileName);
    if(substr($thisFileName,-1,1)=='/')continue;
    if(!is_dir('..'.DS.$thisFileDir)){
      mkdir('..'.DS.$thisFileDir );
      $html.='<li>Created Directory '.$thisFileDir.'</li>';
    }
    if(!is_dir('..'.DS.$thisFileName)){
      $html.='<li>'.$thisFileName.'...........';
      $contents=zip_entry_read($aF,zip_entry_filesize($aF));
      $updateThis='';
      if($thisFileName=='core'.DS.'upgrade.sql'){
        $prefix=$settings['database']['prefix'];
  			$sql=file_get_contents('core'.DS.'upgrade.sql');
  			$sql=str_replace([
  					"CREATE TABLE `",
  					"INSERT INTO `",
  					"ALTER TABLE `"
  				],[
  					"CREATE TABLE `".$prefix,
  					"INSERT INTO `".$prefix,
  					"ALTER TABLE `".$prefix
  				],$sql);
  			$q=$db->exec($sql);
  			$e=$db->errorInfo();
        $upgradeExec=fopen('doupgrade.php','w');
        fwrite($upgradeExec,$contents);
        fclose($upgradeExec);
        include('doupgrade.php');
        unlink('doupgrade.php');
        $html.=' <strong class="text-success">SQL EXECUTED</strong></li>';
      }else{
        $updateThis=fopen('..'.DS.$thisFileName,'w');
        fwrite($updateThis,$contents);
        fclose($updateThis);
        unset($contents);
        $html.=' <strong class="text-success">UPDATED</strong></li>';
      }
    }
  }
  echo'window.top.window.$(`#update`).append(`'.$html.'`);';
  $updated=TRUE;
  $txt='[database]'.PHP_EOL;
  $txt.='driver = '.$settings['database']['driver'].PHP_EOL;
  $txt.='host = '.$settings['database']['host'].PHP_EOL;
  if(isset($settings['database']['port'])=='')
    $txt.=';port = 3306'.PHP_EOL;
  else
    $txt.='port = '.$settings['database']['post'].PHP_EOL;
  $txt.='schema = '.$settings['database']['schema'].PHP_EOL;
  $txt.='username = '.$settings['database']['username'].PHP_EOL;
  $txt.='password = '.$settings['database']['password'].PHP_EOL;
  $txt.='[system]'.PHP_EOL;
  $txt.='version = '.time().PHP_EOL;
  $txt.='url = '.$settings['system']['url'].PHP_EOL;
  $txt.='admin = '.$settings['system']['admin'].PHP_EOL;
  if(file_exists('config.ini'))unlink('config.ini');
  $oFH=fopen("config.ini",'w');
  fwrite($oFH,$txt);
  fclose($oFH);
  echo'window.top.window.$(`#update`).append(`<div class="alert alert-success" role="alert">Configuration Updated!</div>`);';
  }else{
  echo'window.top.window.$(`#update`).append(`<div class="alert alert-danger" role="alert">Could not find latest Update!</div>`);';
  }
}
$su=$db->prepare("UPDATE config SET uti=:uti WHERE id='1'");
$su->execute([':uti'=>time()]);
echo'</script>';
