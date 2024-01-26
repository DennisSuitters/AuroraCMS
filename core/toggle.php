<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Toggle
 * @package    core/toggle.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=isset($_GET['id'])?filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$bit=isset($_GET['b'])?filter_input(INPUT_GET,'b',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_POST,'b',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_GET['t'])?filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW);
$col=isset($_GET['c'])?filter_input(INPUT_GET,'c',FILTER_UNSAFE_RAW):filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW);
$ti=time();
if(($tbl!='NaN'&&$col!='NaN')||($tbl!=''&&$col!='')){
  if(in_array($tbl,[
    'cart',
    'choices',
    'comments',
    'config',
    'content',
    'forumCategory',
    'forumPosts',
    'forumTopics',
    'iplist',
    'locations',
    'login',
    'logs',
    'media',
    'menu',
    'messages',
    'orderitems',
    'orders',
    'rewards',
    'sidebar',
    'subscribers',
    'suggestions',
    'tracker',
    'widgets'
  ])&&in_array($col,[
    'accountsContact',
    'active',
    'agreementCheck',
    'bio',
    'bio_options',
    'bookable',
    'bookingEmailReadNotification',
    'checklist',
    'coming',
    'comingsoon',
    'development',
    'featured',
    'fomo',
    'fomoFullname',
    'fomoOptions',
    'forumOptions',
    'help',
    'helpResponder',
    'highlight',
    'hold',
    'hoster',
    'iconsColor',
    'important',
    'internal',
    'liveChatNotification',
    'maintenance',
    'mediaOptions',
    'method',
    'newsletter',
    'newslettersEmbedImages',
    'options',
    'orderEmailReadNotification',
    'permanent',
    'php_options',
    'pin',
    'price',
    'process',
    'recurring',
    'sliderOptions',
    'spamfilter',
    'starred',
    'storemessages',
    'suggestions',
    'status'
  ])){
    $q=$db->prepare("SELECT `".$col."` as c FROM `".$prefix.$tbl."` WHERE `id`=:id");
    $q->execute([':id'=>$id]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    if(!in_array($col,['bio_options','options','forumOptions','php_options','sliderOptions','mediaOptions','fomoOptions','process'])){
      $r['c']=$r['c']==1?0:1;
    }else{
      $r['c'][$bit]=($r['c'][$bit]==1?0:1);
    }
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
