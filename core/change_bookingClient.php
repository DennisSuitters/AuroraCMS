<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Change Booking Client
 * @package    core/change_bookingClient.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$bid=filter_input(INPUT_GET,'bid',FILTER_SANITIZE_NUMBER_INT);
$w=filter_input(INPUT_GET,'w',FILTER_SANITIZE_STRING);
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
  if($w=='booking'){
    $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
    $q->execute([':id'=>$id]);
    $c=$q->fetch(PDO::FETCH_ASSOC);
  }
  if($w=='noaccount'){
    $q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $q->execute([':id'=>$id]);
    $c=$q->fetch(PDO::FETCH_ASSOC);
  }
}
$q=$db->prepare("UPDATE `".$prefix."content` SET  `cid`=:cid,`business`=:business,`name`=:name,`address`=:address,`suburb`=:suburb,`state`=:state,`city`=:city,`postcode`=:postcode,`email`=:email,`phone`=:phone,`mobile`=:mobile WHERE `id`=:id");
$q->execute([
  ':cid'=>$id,
  ':business'=>$c['business'],
  ':name'=>$c['name'],
  ':address'=>$c['address'],
  ':suburb'=>$c['suburb'],
  ':state'=>$c['state'],
  ':city'=>$c['city'],
  ':postcode'=>$c['postcode'],
  ':email'=>$c['email'],
  ':phone'=>$c['phone'],
  ':mobile'=>$c['mobile'],
  ':id'=>$bid
]);
echo'<script>'.
  'window.top.window.$("#business").val("'.$c['business'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#name").val("'.$c['name'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#address").val("'.$c['address'].'").data("dbid","'.$c['id'].'");'.
  'window.top.window.$("#suburb").val("'.$c['suburb'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#state").val("'.$c['state'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#city").val("'.$c['city'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#postcode").val("'.$c['postcode'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#email").val("'.$c['email'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#phone").val("'.$c['phone'].'").data("dbid",'.$c['id'].');'.
  'window.top.window.$("#mobile").val("'.$c['mobile'].'").data("dbid",'.$c['id'].');'.
'</script>';
