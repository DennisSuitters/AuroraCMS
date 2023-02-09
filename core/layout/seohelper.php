<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - SEO Helper
 * @package    core/layout/seohelper_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'../db.php';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$s=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `type`=:t");
$s->execute([':t'=>$t]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  echo'<div class="fancybox-ajax m-5">'.
    '<h6 class="p-2">'.$r['title'].'</h6>'.
    '<div class="m-3">'.
      $r['notes'].
    '</div>'.
  '</div>';
}else
  echo$t.' not found';?>
