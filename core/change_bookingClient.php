<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Change Booking Client
 * @package    core/change_bookingClient.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<script>';
require_once'db.php';
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
    $q->execute([
      ':id'=>$id
    ]);
    $c=$q->fetch(PDO::FETCH_ASSOC);
  }
  if($w=='noaccount'){
    $q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $q->execute([
      ':id'=>$id
    ]);
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
]);?>
  window.top.window.$('#business').val('<?php echo$c['business'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#name').val('<?php echo$c['name'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#address').val('<?php echo$c['address'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#suburb').val('<?php echo$c['suburb'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#state').val('<?php echo$c['state'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#city').val('<?php echo$c['city'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#postcode').val('<?php echo$c['postcode'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#email').val('<?php echo$c['email'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#phone').val('<?php echo$c['phone'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#mobile').val('<?php echo$c['mobile'];?>').data("dbid",<?php echo$c['id'];?>);
<?php
echo'</script>';
