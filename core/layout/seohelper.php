<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - SEO Helper
 * @package    core/layout/seohelper_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require_once'..'.DS.'db.php';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `type`=:t");
$s->execute([
  ':t'=>$t
]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  echo'<h4>'.$r['title'].'</h4>';
  echo$r['notes'];
}else
  echo$t.' not found';?>
