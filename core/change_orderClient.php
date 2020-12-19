<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Change Order Client
 * @package    core/change_orderClient.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
$q=$db->prepare("UPDATE `".$prefix."orders` SET `cid`=:cid WHERE `id`=:oid");
$q->execute([
  ':cid'=>$id,
  ':oid'=>$oid
]);
if($id==0){
  $c=[
    'id'=>0,
    'username'=>'',
    'name'=>'',
    'business'=>'',
    'address'=>'',
    'suburb'=>'',
    'state'=>'',
    'city'=>'',
    'postcode'=>'',
    'email'=>'',
    'phone'=>'',
    'mobile'=>''
  ];
}else{
  $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
  $q->execute([
    ':id'=>$id
  ]);
  $client=$q->fetch(PDO::FETCH_ASSOC);
}
echo'<script'.
      'window.top.window.$("#to").html(`<strong>'.$client['username'].($client['name']!=''?' ['.$client['name'].']':'').'<br>'.
        ($client['business']!=''?' -> '.$client['business'].'<br>':'').'</strong>'.
        '<small>'.
          ($client['email']!=''?'Email: '.$client['email'].'<br>':'').
          ($client['phone']!=''?'Phone: '.$client['phone'].'<br>':'').
          ($client['mobile']!=''?'Mobile: '.$client['mobile'].'<br>':'').
          $client['address'].', '.$client['suburb'].', '.$client['city'].'<br>'.
          $client['state'].', '.($client['postcode']!=0?', '.$client['postcode']:'').
        '</small>`);'.
    '</script>';
