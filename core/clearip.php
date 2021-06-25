<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Clear IP
 * @package    core/clearip.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$s=$db->prepare("DELETE FROM `".$prefix."tracker` WHERE `ip`=:id");
$s->execute([':id'=>$id]);
