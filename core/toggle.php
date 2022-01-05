<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Toggle
 * @package    core/toggle.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=isset($_GET['id'])?filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$bit=isset($_GET['b'])?filter_input(INPUT_GET,'b',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_POST,'b',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_GET['t'])?filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
$col=isset($_GET['c'])?filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING);
$ti=time();
if(($tbl!='NaN'&&$col!='NaN')||($tbl!=''&&$col!='')){
  if(in_array($tbl,['cart','choices','comments','config','content','iplist','login','logs','media','menu','messages','orderitems','orders','rewards','subscribers','suggestions','tracker','forumCategory','forumTopics','forumPosts','sidebar'])&&in_array($col,['active','bio_options','bookable','bookingEmailReadNotification','comingsoon','development','coming','featured','important','internal','liveChatNotification','maintenance','method','newsletter','newslettersEmbedImages','options','forumOptions','orderEmailReadNotification','php_options','help','pin','recurring','spamfilter','starred','storemessages','suggestions','checklist','agreementCheck','pin','helpResponder','accountsContact','hoster','sliderOptions','bio'])){
    $q=$db->prepare("SELECT `".$col."` as c FROM `".$prefix.$tbl."` WHERE `id`=:id");
    $q->execute([':id'=>$id]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    $r['c'][$bit]=$r['c'][$bit]==1?0:1;
    $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET `".$col."`=:c WHERE `id`=:id");
    $q->execute([
      ':c'=>$r['c'],
      ':id'=>$id
    ]);
    if($tbl=='login'&&$col=='active'){
      $q=$db->prepare("UPDATE `".$prefix."login` SET `activate`='' WHERE `id`=:id");
      $q->execute([':id'=>$id]);
    }
  }
}
if($tbl!='messages'||$col!='pin')echo'<script>window.top.window.$("#'.$tbl.$col.$bit.'").remove();";</script>';
