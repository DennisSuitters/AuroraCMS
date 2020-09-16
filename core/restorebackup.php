<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Restore Backup
 * @package    core/restorebackup.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.10 Fix Toastr Notifications.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
echo"<script>window.top.window.$('#backup_info').html('');";
$getcfg=true;
require'db.php';
$fu=$_FILES['fu'];
if(isset($_FILES['fu'])){
  $file='..'.DS.'media'.DS.'backup'.DS.basename($_FILES['fu']['name']);
  if(move_uploaded_file($_FILES['fu']['tmp_name'],$file)){
    $sql=file_get_contents($file);
    if(stristr($file,'.sql.gz'))$sql=gzinflate(substr($sql,10,-8));
    $q=$db->exec($sql);
    $e=$db->errorInfo();
    if(is_null($e[2])){?>
  window.top.window.toastr["success"]("Resture from Backup Successfull!");
<?php }else{?>
  window.top.window.toastr["error"]("There was an issue Restoring the Backup!<br><?php echo$e[2];?>");
<?php }
  }
}
echo'</script>';
