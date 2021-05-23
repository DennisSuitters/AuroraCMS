<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Blacklist
 * @package    core/add_blacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$i=1;
$sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`='seotips'");
$sc->execute();
echo'<div style="width:75vw;height:75vh;overflow-y:auto;">';
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
  echo'<div class="row m-2">'.
    '<div class="col-1-5 pr-4"><strong>'.$i.'</strong></div>'.
    '<div class="col-11">'.
      $rc['notes'].
    '</div>'.
  '</div>';
  $i++;
}
echo'</div>';
