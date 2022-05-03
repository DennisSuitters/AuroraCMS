<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Message Email to Whitelist
 * @package    core/add_messagewhitelist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT `from_email` FROM `".$prefix."messages` WHERE `id`=:id");
$s->execute([':id'=>$id]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $address=explode("@",$r['email_from']);
  $ip=gethostbyname($address[1]);
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."whitelist` (`ip`,`email`,`ti`) VALUES (:ip,:email,:ti)");
  $s->execute([
    ':ip'=>$ip,
    ':email'=>$r['from_email'],
    ':ti'=>time()
  ]);
  $s=$db->prepare("UPDATE `".$prefix."messages` SET `folder`='INBOX' WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  echo'<script>'.
				'window.top.window.$("#whitelist'.$id.'").addClass("d-none");'.
				'window.top.window.toastr["success"]("IP Added to Whitelist!");'.
			'</script>';
}
