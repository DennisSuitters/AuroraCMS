<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Change Order Client
 * @package    core/change_orderClient.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
function rank($txt){
	if($txt==0)return'visitor';
	if($txt==100)return'subscriber';
	if($txt==200)return'member';
	if($txt==210)return'member-silver';
	if($txt==220)return'member-bronze';
	if($txt==230)return'member-gold';
	if($txt==240)return'member-platinum';
	if($txt==300)return'client';
	if($txt==310)return'wholesale-silver';
	if($txt==320)return'wholesale-bronze';
	if($txt==330)return'wholesale-gold';
	if($txt==340)return'wholesale-platinum';
	if($txt==400)return'contributor';
	if($txt==500)return'author';
	if($txt==600)return'editor';
	if($txt==700)return'moderator';
	if($txt==800)return'manager';
	if($txt==900)return'administrator';
	if($txt==1000)return'developer';
}
function _ago($time){
	if($time==0)$timeDiff='Never';
	else{
		$fromTime=$time;
		$timeDiff=floor(abs(time()-$fromTime)/60);
		if($timeDiff<2)$timeDiff='Just Now';
		elseif($timeDiff>2&&$timeDiff<60)$timeDiff=floor(abs($timeDiff)).' Minutes Ago';
		elseif($timeDiff>60&&$timeDiff<120)$timeDiff=floor(abs($timeDiff/60)).' Hour Ago';
		elseif($timeDiff<1440)$timeDiff=floor(abs($timeDiff/60)).' Hours Ago';
		elseif($timeDiff>1440&&$timeDiff<2880)$timeDiff=floor(abs($timeDiff/1440)).' Day Ago';
		elseif($timeDiff>2880)$timeDiff=floor(abs($timeDiff/1440)).' Days Ago';
	}
	return$timeDiff;
}
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
$q=$db->prepare("UPDATE `".$prefix."orders` SET `cid`=:cid WHERE `id`=:oid");
$q->execute([
  ':cid'=>$id,
  ':oid'=>$oid
]);
if($id==0){
  $client=[
    'id'=>0,
    'options'=>00000000000000000000000000000000,
    'rank'=>0,
    'purchaseLimit'=>0,
    'spent'=>0,
    'points'=>0,
    'pti'=>0,
    'username'=>'',
    'name'=>'',
    'business'=>'',
    'email'=>'',
    'phone'=>'',
    'mobile'=>'',
    'address'=>'',
    'suburb'=>'',
    'city'=>'',
    'state'=>'',
    'postcode'=>0
  ];
}else{
  $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
  $q->execute([':id'=>$id]);
  $client=$q->fetch(PDO::FETCH_ASSOC);
}
if($client['purchaseLimit']==0){
  if($client['rank']==200)$client['purchaseLimit']=$config['memberLimit'];
  if($client['rank']==210)$client['purchaseLimit']=$config['memberLimitSilver'];
  if($client['rank']==220)$client['purchaseLimit']=$config['memberLimitBronze'];
  if($client['rank']==230)$client['purchaseLimit']=$config['memberLimitGold'];
  if($client['rank']==240)$client['purchaseLimit']=$config['memberLimitPurchase'];
  if($client['rank']==310)$client['purchaseLimit']=$config['memberLimitSilver'];
  if($client['rank']==320)$client['purchaseLimit']=$config['memberLimitBronze'];
  if($client['rank']==330)$client['purchaseLimit']=$config['memberLimitGold'];
  if($client['rank']==340)$client['purchaseLimit']=$config['memberLimitPlatinum'];
  if($client['purchaseLimit']==0)$client['purchaseLimit']='No Limit';
}
echo'<script>'.
      'window.top.window.$("#to").html(`<strong>'.$client['username'].($client['name']!=''?' ['.$client['name'].']':'').'<br>'.
        ($client['business']!=''?' -> '.$client['business'].'<br>':'').'</strong>'.
        '<small>'.
          ($client['email']!=''?'Email: '.$client['email'].'<br>':'').
          ($client['phone']!=''?'Phone: '.$client['phone'].'<br>':'').
          ($client['mobile']!=''?'Mobile: '.$client['mobile'].'<br>':'').
          $client['address'].', '.$client['suburb'].', '.$client['city'].'<br>'.
          $client['state'].', '.($client['postcode']!=0?', '.$client['postcode']:'').
        '</small>`);'.
      'window.top.window.$("#clientRank").html(`'.ucwords(rank($client['rank'])).'`);'.
      'window.top.window.$("#clientRank").removeClass().addClass(`badger badge-'.rank($client['rank']).'`);'.
      'window.top.window.$("#clientPurchaseLimit").html(`'.$client['purchaseLimit'].'`);'.
      'window.top.window.$("#clientSpent").html(`'.$client['spent'].'`);'.
      'window.top.window.$("#clientPoints").html(`'.number_format((float)$client['points']).'`);'.
      'window.top.window.$("#clientpti").html(`'.($client['pti']==0?'Never':_ago($client['pti'])).'`);'.
    '</script>';
