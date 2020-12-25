<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - PayPal Order Manipulator
 * @package    core/paypaltransaction.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$theme=parse_ini_file('../layout/'.$config['theme'].'/theme.ini',true);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
$si=session_id();
$ti=time();
if(in_array($act,['paid','cancelled','error'])){
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `status`=:status WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':status'=>$act
  ]);
  switch($act){
    case'paid':
      echo$theme['settings']['payment_success'];
    break;
    case'cancelled':
      echo$theme['settings']['payment_cancelled'];
    break;
    default:
      echo$theme['settings']['payment_error'];
  }
}
