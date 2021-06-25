<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Restore Backup
 * @package    core/restorebackup.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$fu=$_FILES['fu'];
if(isset($_FILES['fu'])){
  $file='../media/backup/'.basename($_FILES['fu']['name']);
  if(move_uploaded_file($_FILES['fu']['tmp_name'],$file)){
    $sql=file_get_contents($file);
    if(stristr($file,'.sql.gz'))$sql=gzinflate(substr($sql,10,-8));
    $q=$db->exec($sql);
    $e=$db->errorInfo();
    if(is_null($e[2])){
      echo'<script>'.
        'window.top.window.$("#backup_info").html("");'.
        'window.top.window.toastr["success"]("Resture from Backup Successfull!");'.
      '</script>';
    }else{
      echo'<script>'.
        'window.top.window.$("#backup_info").html("");'.
        'window.top.window.toastr["error"]("There was an issue Restoring the Backup!<br>'.$e[2].'");'.
      '</script>';
    }
  }
}
