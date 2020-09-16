<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Increase Views
 * @package    core/views_increase.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
$col=filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING);
if(($tbl!='NaN'&&$col!='NaN')||($tbl!=''&&$col!='')){
  if(in_array($tbl,['content','media','menu'])){
    $q=$db->prepare("SELECT `views` FROM `".$prefix.$tbl."` WHERE `id`=:id");
    $q->execute([
      ':id'=>$id
    ]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    $r['views']=$r['views'] + 1;
    $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET `views`=:views WHERE `id`=:id");
    $q->execute([
      ':views'=>$r['views'],
      ':id'=>$id
    ]);
  }
}
