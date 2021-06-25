<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Email Order
 * @package    core/email_order.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$w=filter_input(INPUT_GET,'w',FILTER_SANITIZE_STRING);
$act=filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
$q->execute([':id'=>$id]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$r['notes']=rawurldecode($r['notes']);
$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$s->execute([':id'=>$r['cid']]);
$c=$s->fetch(PDO::FETCH_ASSOC);
$ti=time();
if($r['qid']!='')$oid=$r['qid'];
if($r['iid']!='')$oid=$r['iid'];
  $head='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
    '<html xmlns="http://www.w3.org/1999/xhtml">'.
      '<head>'.
        '<title>View Order #'.$oid.'</title>'.
        '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.
        '<style type="text/css">'.
            '@media print{body{-webkit-print-color-adjust:exact;color-adjust:exact;border: 0 none !important;color: #000 !important}body * {visibility: hidden}#section-to-print a {color: #00f !important}#section-to-print a[href^="http"]::after{content: " (" attr(href)") "}#section-to-print{position: absolute;margin: 0 0 0 0;top: 0;left: 0}#section-to-print *{visibility: visible !important;text-shadow: none !important}#section-to-print.orderstheme.col-11{width: 100%}#section-to-print article.col-12{width: 33%}#section-to-print table thead tr th{background-color: #000 !important;color: #fff !important}#section-to-print h1,#section-to-print h2,#section-to-print h3,#section-to-print h4,#section-to-print h5,#section-to-print h6 {font-family: Arial !important;color: #000 !important;text-shadow: none !important;}#section-to-print #paypal-button-container{display: none !important}}#section-to-print {font-family: Arial !important;font-size: 1rem !important;width: 800px !important;background-color: #fff !important;text-shadow: none !important}@media (max-width: 360px){#section-to-print {width: auto !important}}#section-to-print h1,#section-to-print .h1,#section-to-print h2,#section-to-print .h2,#section-to-print h3,#section-to-print .h3,#section-to-print h4,#section-to-print .h4,#section-to-print h5,#section-to-print .h5,#section-to-print h6,#section-to-print .h6{font-family: Arial !important;color: #000 !important;text-shadow: none !important;margin-top: 0 !important;margin-bottom: .5rem !important;font-weight: 500 !important;line-height: 1.2 !important}#section-to-print h1,#section-to-print .h1{font-size: calc(1.375rem + 1.5vw) !important}#section-to-print h2,#section-to-print .h2{font-size: calc(1.325rem + .9vw) !important}#section-to-print h3,#section-to-print .h3{font-size: calc(1.3rem + .6vw) !important}#section-to-print h4,#section-to-print .h4{font-size: calc(1.275rem + .3vw) !important}#section-to-print h5,#section-to-print .h5{font-size: 1.25rem !important}#section-to-print h6,#section-to-print .h6 {font-size: 1rem !important}#section-to-print table thead tr th{background-color: #000 !important;color: #fff !important}@media (min-width:1200px){#section-to-print h1,#section-to-print .h1{font-size: 2.5rem !important}#section-to-print h2,#section-to-print .h2{font-size: 2rem !important}#section-to-print h3,#section-to-print .h3{font-size: 1.75rem !important}#section-to-print h4,#section-to-print .h4{font-size: 1.5rem!important}}'.
        '</style>'.
      '</head>'.
      '<body style="outline:0;width:100%;min-width:100%;height:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:Helvetica,Arial,sans-serif;line-height:24px;font-weight:normal;font-size:16px;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;color:#000000;margin:0 auto;padding:0;border:0;" bgcolor="#ffffff">';
  $html='<div style="width:800px;height:30px;text-align:right;">'.
          '<button class="float-right mr-1" onclick="window.print();" aria-label="Print">Print</button>'.
        '</div>'.
        '<div id="section-to-print">'.
          '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:800px;">'.
            '<tr>'.
              '<td class="col-4" style="width:33%;vertical-align:top;">'.
                '<h3>From</h3>'.
                '<p>'.
                  '<strong>'.$config['business'].'</strong><br />ABN: <strong>'.$config['abn'].'</strong><br />'.
                  $config['address'].', '.$config['suburb'].',<br />'.$config['city'].', '.$config['state'].', '.$config['postcode'].
                '</p>'.
              '</td>'.
              '<td class="col-4" style="vertical-align:top;">'.
                '<h3>To</h3>'.
                '<p>'.
                  '<strong>'.$c['business'] . '</strong><br />'.
                  $c['name'].'<br />'.$c['address'].', '.$c['suburb'].',<br />'.$c['city'].', '.$c['state'].', '.$c['postcode'].
                '</p>'.
              '</td>'.
              '<td class="col-4" style="width:33%;vertical-align:top;">'.
                '<h3>Details</h3>'.
                '<p>'.
                  '<small>Order <strong>#'.$r['qid'] . $r['iid'].'</strong><br />'.
                  'Order Date: <strong>'.date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']) . '</strong><br />'.
                  'Due Date: <strong class="'.$r['status'].'">'.date($config['dateFormat'], $r['due_ti']) . '</strong><br />'.
                  'Status: <strong class="'.$r['status'].'"'.($r['status']=='overdue'?' style="color: red;"':'').'>'.ucfirst($r['status']).'</strong></small>'.
                '</p>'.
              '</td>'.
            '</tr>'.
          '</table>'.
          '<br />'.
          '<br />'.
          '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:800px;">'.
            '<thead style="background-color:#000000;color:#ffffff;">'.
              '<tr>'.
                '<th class="">Code</th>'.
                '<th class="">Title</th>'.
                '<th class="">Option</th>'.
                '<th style="text-align:center;">Qty</th>'.
                '<th style="text-align:right;">Cost</th>'.
                '<th style="text-align:center;">GST</th>'.
                '<th style="text-align:right;">Total</th>'.
              '</tr>'.
            '</thead>'.
            '<tbody>';
  $i=13;
  $ot=$st=$pwc=0;
  $zeb=1;
  $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='delete' AND `status`!='neg' ORDER BY `status` ASC, `ti` ASC, `title` ASC");
  $s->execute([':oid'=>$id]);
  while($ro=$s->fetch(PDO::FETCH_ASSOC)){
  	$si=$db->prepare("SELECT `code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
  	$si->execute([':id'=>$ro['iid']]);
  	$i=$si->fetch(PDO::FETCH_ASSOC);
  	$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
  	$sc->execute([':id'=>$ro['cid']]);
  	$ch=$sc->fetch(PDO::FETCH_ASSOC);
    $st=$ro['cost']*$ro['quantity'];
  	$html.='<tr'.($zeb==1?' style="background-color:#f4f4f4;"':' style="backgroound-color:#fff;"').'>'.
  	         '<td><small>'.$i['code'].'</small></td>'.
  	         '<td><small>'.($ro['title']==''?$i['title']:$ro['title']).'</small></td>'.
             '<td><small>'.$ch['title'].'</small></td>'.
             '<td style="text-align:center;"><small>'.$ro['quantity'].'</small></td>'.
             '<td style="text-align:right;"><small>'.$ro['cost'].'</small></td>'.
             '<td style="text-align:center;"><small>';
             $gst=0;
             if($ro['status']!='pre-order'){
               if($config['gst']>0){
                  $gst=$ro['cost']*($config['gst']/100);
                  if($ro['quantity']>1)$gst=$gst*$ro['quantity'];
                  $gst=number_format((float)$gst,2,'.','');
               }
               $html.=($gst>0?$gst:'').'</small>';
             }
             $html.='</td>'.
             '<td style="text-align:right;">';
             if($ro['status']!='pre-order'){
               $html.=number_format((float)$st+$gst,2,'.','');
               $ot=$ot+$st+$gst;
               $ot=number_format((float)$ot,2,'.','');
             }else$html.='<small>Pre-Order</small>';
              $html.='</td>'.
            '</tr>';
    $zeb=($zeb==1?0:1);
  }
  $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
  $sr->execute([':rid'=>$r['rid']]);
  if($sr->rowCount()>0){
  	$reward=$sr->fetch(PDO::FETCH_ASSOC);
  	$html.='<tr style="background-color:#f0f0f0">'.
              '<td colspan="2" style="text-align:right;"><strong><small>Rewards Code</small></strong></td>'.
              '<td style="text-align:center;" colspan="4"><small>';
  	if($reward['method']==1){
      $html.='$';
      $ot=$o-$reward['value'];
    }
    $html.=$reward['value'];
    if($reward['method']==0){
      $html.='%';
      $ot=($ot*((100-$reward['value'])/100));
    }
    $ot=number_format((float)$ot, 2, '.', '');
    $html.=' Off</small></td>'.
            '<td style="text-align:right;">'.($reward['value']>0?$ot:'').'</td>'.
          '</tr>';
  }
  if($config['options'][26]==1){
    $dedtot=0;
    $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
    $sd->execute([
      ':f'=>$c['spent'],
      ':t'=>$c['spent']
    ]);
    if($sd->rowCount()>0){
      $rd=$sd->fetch(PDO::FETCH_ASSOC);
      if($rd['value']==1)$dedtot=$rd['cost'];
      if($rd['value']==2)$dedtot=$ot*($rd['cost']/100);
      $ot=$ot - $dedtot;
  $html.='<tr>'.
    '<td colspan="6"><small>Spent over &#36;'.$rd['f'].' discount of '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost'].' Off').'</small></td>'.
    '<td style="text-align:right;">-'.$dedtot.'</td>'.
  '</tr>';
    }
  }
  if($r['postageCost']!=0||$r['postageOption']!=''){
  	$html.='<tr style="background-color:#f0f0f0">'.
              '<td colspan="6"><small>Shipping Option: '.$r['postageOption'].'<?small></td>'.
              '<td style="text-align:right;">'.($r['postageCost']!=0?$r['postageCost']:'').'</td>'.
            '</tr>';
  	$ot=$ot+$r['postageCost'];
    $ot=number_format((float)$ot,2,'.','');
  }
  if($r['payCost']!=0||$r['payOption']!=''){
    $paytot=0;
    if($r['payMethod']==1)$paytot=$ot*($r['payCost']/100);
    if($r['payMethod']==2)$paytot=$r['payCost'];
    $html.='<tr style="background-color:#f0f0f0">'.
              '<td colspan="6" class="text-right"><small>Payment Option: '.$r['payOption'].($r['payMethod']==1&&$r['payCost']>0?' ('.number_format((float)$r['payCost'],1,'.','').'&#37; Surcharge)':'').'</small></td>'.
              '<td style="text-align:right;">'.($paytot!=0?number_format((float)$paytot,2,'.',''):'').'</td>'.
            '</tr>';
    $ot=$ot+$paytot;
    $ot=number_format((float)$ot, 2, '.', '');
  }
  $html.='<tr style="background-color:#f0f0f0">'.
            '<td colspan="5">&nbsp;</td>'.
            '<td style="text-align:right;"><strong>Total</strong></td>'.
            '<td style="text-align:right;border-top:1px solid #000;border-bottom:1px solid #000;"><strong>'.$ot.'</strong></td>'.
          '</tr>';
  $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
  $sn->execute([':oid'=>$r['id']]);
  if($sn->rowCount()>0){
  	while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
      $html.='<tr style="background-color:#f4f4f4;">'.
          '<td colspan="6""><small>'.$rn['title'].' on '.date($config['dateFormat'],$rn['ti']).'</small></td>'.
          '<td style="text-align:right;">-'.$rn['cost'].'</td>'.
        '</tr>';
      $ot=$ot-$rn['cost'];
    }
    $ot=number_format((float)$ot,2,'.','');
    $html.='<tr style="background-color:#f0f0f0">'.
      '<td colspan="5">&nbsp;</td>'.
      '<td style="text-align:right;"><strong>Balance</strong></td>'.
      '<td style="text-align:right;border-top:1px solid #000;border-bottom:1px solid #000;"><strong>'.$ot.'</strong></td>'.
    '</tr>';
  }
  $html.='</tfoot>'.
      '</table>'.
      '<br />'.
      '<br />'.
      '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;">'.
        '<tbody>'.
          '<tr>'.
            '<td style="width:33%;vertical-align:top;">'.
              '<h4>Notes</h4>'.
              '<p style="font-size:8px">'.rawurldecode($r['notes']).'</p>'.
            '</td>'.
            '<td style="width:33%;vertical-align:top;">'.
              '<h4>Banking Details</h4>'.
              '<p>'.
                '<small>Bank: <strong>'.$config['bank'].'</strong><br />'.
                'Account Name: <strong>'.$config['bankAccountName'].'</strong><br />'.
                'Account Number: <strong>'.$config['bankAccountNumber'].'</strong><br />'.
                'BSB: <strong>'.$config['bankBSB'].'</strong></small>'.
              '</p>'.
            '</td>'.
            '<td style="width:33%;vertical-align:top;">'.

            '</td>'.
          '</tr>'.
        '</tbody>'.
      '</table></div>'.
    '</body></html>';
if($act=='print'){
	echo'<script>'.
    'var win = window.top.open("","Print Order","toolbar=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,innerWidth=810,innerHeight=800");'.
    'win.top.document.body.innerHTML = `'.$head.$html.'`;'.
  '</script>';
}else{
	require'phpmailer/class.phpmailer.php';
	$mail=new PHPMailer;
	$mail->isSendmail();
	$toname=$c['name']!=''?$c['name']:$c['business'];
	$mail->SetFrom($config['email'],$config['business']);
	$mail->AddAddress($c['email']);
	$mail->IsHTML(true);
  if($config['orderEmailReadNotification'][0]==1){
    $mail->AddCustomHeader("X-Confirm-Reading-To:".$config['email']);
    $mail->AddCustomHeader("Return-receipt-to:".$config['email']);
    $mail->AddCustomHeader("Disposition-Notification-To:".$config['email']);
    $mail->ConfirmReadingTo=$config['email'];
  }
  $namee=explode(' ',$c['name']);
  $subject=isset($config['orderEmailSubject'])&&$config['orderEmailSubject']!=''?$config['orderEmailSubject']:'Order {order_number} from {business}';
  $subject=str_replace([
    '{business}',
    '{name}',
    '{first}',
    '{last}',
    '{date}',
    '{order_number}'
  ],[
    $config['business'],
    $c['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['ti']),
    $oid
  ],$subject);
	$mail->Subject=$subject;
	$msg=isset($config['orderEmailLayout'])&&$config['orderEmailLayout']!=''?rawurldecode($config['orderEmailLayout']):'<P>Hello {first},</p><p>Please find below Order {order_number} for payment.</p><p>To make a payment, refer to the Bank Details, or click the link directly below to pay via a Payment Gateway through our Website.</p><p><a href="{order_link}">{order_link}</a></p><hr>';
  $msg=str_replace([
    '{business}',
    '{name}',
    '{first}',
    '{last}',
    '{date}',
    '{order_number}',
    '{order_link}'
  ],[
    $config['business'],
    $c['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['ti']),
    $oid,
    URL.'orders/'.$oid
  ],$msg);
	$mail->Body=$head.$msg.$html;
	$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
	if($mail->Send()){
    $alertmsg=str_replace('{business}',$c['business']!=''?$c['business']:$c['name'],'The Order to {business} was Sent Successfully!');
    echo'<script>window.top.window.toastr["success"](`'.$alertmsg.'`);</script>';
  }else{
    $alertmsg=str_replace('{business}',$c['business']!=''?$c['business']:$c['name'],'There was an issue sending the Order to {business}!');
    echo'<script>window.top.window.toastr["error"](`'.$alertmsg.'`);</script>';
  }
}
