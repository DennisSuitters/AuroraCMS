<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Checkout
 * @package    core/view/checkout.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/puconverter.php';
$html=preg_replace([
  $page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<print page=[\"\']?notes[\"\']?>/',
],[
  '',
  '',
  $page['notes']
],$html);
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`=:id OR `iid`=:id AND `status`!='archived'");
$s->execute([':id'=>$args[0]]);
$r=$s->fetch(PDO::FETCH_ASSOC);
if($s->rowCount()>0&&$r['status']!='paid'){
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
  $su->execute([':uid'=>$r['cid']]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);
  $html=preg_replace([
    '/<error>/',
    $config['bank']==''?'~<direct>.*?</direct>~is':'/<[\/]?direct>/',
    '/<print checkout=[\"\']?bank[\"\']?>/',
    '/<print checkout=[\"\']?accountName[\"\']?>/',
    '/<print checkout=[\"\']?accountNumber[\"\']?>/',
    '/<print checkout=[\"\']?accountBSB[\"\']?>/',
    $config['payPalClientID']==''?'~<paypal>.*?</paypal>~is':'/<[\/]?paypal>/',
    '/<print paypal=[\"\']?clientID[\"\']?>/',
    '/<print url>/',
    $config['stripe_publishkey']==''?'~<stripe>.*?</stripe>~is':'/<[\/]?stripe>/',
    '/<print checkout=[\"\']?total[\"\']?>/',
    '/<print orderid>/',
    '/<print checkout=[\"\']?orderid[\"\']?>/',
    '/<print stripe=[\"\']?publishkey[\"\']?>/',
  ],[
    '',
    '',
    $config['bank'],
    $config['bankAccountName'],
    $config['bankAccountNumber'],
    $config['bankBSB'],
    '',
    $config['payPalClientID'],
    URL,
    '',
    $r['total'],
    $r['id'],
    $r['qid'].$r['iid'],
    $config['stripe_publishkey'],
  ],$html);
}else{
  $html=preg_replace([
    '/<print checkout=[\"\']?orderid[\"\']?>/',
    '/<error>/',
    '~<paypal>.*?</paypal>~is',
    '~<direct>.*?</direct>~is',
    '~<stripe>.*?</stripe>~is',
  ],[
    $args[0],
    isset($r['status'])&&$r['status']=='paid'?'<div class="alert alert-success">Order #'.$args[0].' has already been Paid!</div>':'<div class="alert alert-info">There were No Orders found with the Order Number #'.$args[0].'!</div>',
    '',
    '',
    ''
  ],$html);
}
$content.=$html;
