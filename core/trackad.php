<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Track Advert Clicks
 * @package    core/tracktel.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$id=isset($_POST['id'])?$_POST['id']:0;
if($id>0){
  $s=$db->prepare("UPDATE `".$prefix."content` SET `lti`=`lti`+1 WHERE `id`=:id");
  $s->execute([':id'=>$id]);
}
