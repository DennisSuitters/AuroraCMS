<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Reorder Submenu
 * @package    core/reordersub.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$i=0;
foreach($_POST['l'] as$id){
  $s=$db->prepare("UPDATE `".$prefix."menu` SET `ord`=:ord WHERE `id`=:id");
  $s->execute([
    ':ord'=>$i,
    ':id'=>$id
  ]);
  $i++;
}
