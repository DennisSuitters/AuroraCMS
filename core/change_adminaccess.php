<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Change Admin Access Folder
 * @package    core/change_adminaccess.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$adminfolder=isset($_POST['adminfolder'])?filter_input(INPUT_POST,'adminfolder',FILTER_SANITIZE_STRING):'';
if($adminfolder==''){
  echo'<script>'.
    'window.top.window.$("#adminfolder").addClass("is-invalid");'.
    'window.top.window.toastr["info"]("Folder must NOT be blank!");'.
    'window.top.window.toastr["error"]("Change not saved!");'.
  '</script>';
}else{
  $s=$db->prepare("SELECT `id` FROM `".$prefix."menu` WHERE `file` LIKE :file");
  $s->execute([':file'=>$adminfolder]);
  if($s->rowCount()>0){
    echo'<script>'.
      'window.top.window.$("#adminfolder").addClass("is-invalid");'.
      'window.top.window.toastr["info"]("Folder must NOT be the same as an already existing Page!");'.
      'window.top.window.toastr["error"]("Change not saved!")'.
    '</script>';
  }elseif($adminfolder==$settings['system']['admin']){
    echo'<script>'.
      'window.top.window.$("#adminaccess").html(`<a href="'.URL.$settings['system']['admin'].'">'.URL.'</a>`);'.
      'window.top.window.$("#adminfolder").removeClass("is-invalid");'.
      'window.top.window.toastr["info"]("Administration Access Folder Still The Same!");'.
    '</script>';
  }else{
    $txt='[database]'.PHP_EOL.
      'prefix = '.$settings['database']['prefix'].PHP_EOL.
      'driver = '.$settings['database']['driver'].PHP_EOL.
      'host = '.$settings['database']['host'].PHP_EOL.
      (isset($settings['database']['port'])==''?';port = 3306'.PHP_EOL:'port = '.$settings['database']['port'].PHP_EOL).
      'schema = '.$settings['database']['schema'].PHP_EOL.
      'username = '.$settings['database']['username'].PHP_EOL.
      'password = '.$settings['database']['password'].PHP_EOL.
      '[system]'.PHP_EOL.
      'devmode = '.$settings['system']['devmode'].PHP_EOL.
      'version = '.$settings['system']['version'].PHP_EOL.
      'url = '.$settings['system']['url'].PHP_EOL.
      'admin = '.$adminfolder.PHP_EOL;
    if(file_exists('config.ini'))
      unlink('config.ini');
    $oFH=fopen("config.ini",'w');
    fwrite($oFH,$txt);
    fclose($oFH);
    echo'<script>'.
      'window.top.window.$("#adminaccess").html(`<a href="'.URL.$adminfolder.'">'.URL.'</a>`);'.
      'window.top.window.$("#adminfolder").addClass("is-valid");'.
      'window.top.window.toastr["success"]("Administration Access Folder Updated!");'.
    '</script>';
  }
}
