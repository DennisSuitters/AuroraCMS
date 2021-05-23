<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Email Order
 * @package    core/email_order.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Deprecate PDF creation in favour of emailing and opening Invoice for payment and/or printing.
 * @changes    v0.1.2 Tidy up code and reduce footprint.
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
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
            '.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}body,td,input,textarea,select{margin:unset;font-family:unset}input,textarea,select{font-size:unset}@media screen and (max-width: 600px){table.row th.col-lg-1,table.row th.col-lg-2,table.row th.col-lg-3,table.row th.col-lg-4,table.row th.col-lg-5,table.row th.col-lg-6,table.row th.col-lg-7,table.row th.col-lg-8,table.row th.col-lg-9,table.row th.col-lg-10,table.row th.col-lg-11,table.row th.col-lg-12{display:block;width:100% !important}.d-mobile{display:block !important}.d-desktop{display:none !important}.w-lg-25{width:auto !important}.w-lg-25>tbody>tr>td{width:auto !important}.w-lg-50{width:auto !important}.w-lg-50>tbody>tr>td{width:auto !important}.w-lg-75{width:auto !important}.w-lg-75>tbody>tr>td{width:auto !important}.w-lg-100{width:auto !important}.w-lg-100>tbody>tr>td{width:auto !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.w-25{width:25% !important}.w-25>tbody>tr>td{width:25% !important}.w-50{width:50% !important}.w-50>tbody>tr>td{width:50% !important}.w-75{width:75% !important}.w-75>tbody>tr>td{width:75% !important}.w-100{width:100% !important}.w-100>tbody>tr>td{width:100% !important}.w-auto{width:auto !important}.w-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:0 !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:0 !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:0 !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:0 !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:0 !important}.p-lg-2>tbody>tr>td{padding:0 !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:0 !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:0 !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:0 !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:0 !important}.p-lg-3>tbody>tr>td{padding:0 !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:0 !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:0 !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:0 !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:0 !important}.p-lg-4>tbody>tr>td{padding:0 !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:0 !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:0 !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:0 !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:0 !important}.p-lg-5>tbody>tr>td{padding:0 !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:0 !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:0 !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:0 !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:0 !important}.p-0>tbody>tr>td{padding:0 !important}.pt-0>tbody>tr>td,.py-0>tbody>tr>td{padding-top:0 !important}.pr-0>tbody>tr>td,.px-0>tbody>tr>td{padding-right:0 !important}.pb-0>tbody>tr>td,.py-0>tbody>tr>td{padding-bottom:0 !important}.pl-0>tbody>tr>td,.px-0>tbody>tr>td{padding-left:0 !important}.p-1>tbody>tr>td{padding:4px !important}.pt-1>tbody>tr>td,.py-1>tbody>tr>td{padding-top:4px !important}.pr-1>tbody>tr>td,.px-1>tbody>tr>td{padding-right:4px !important}.pb-1>tbody>tr>td,.py-1>tbody>tr>td{padding-bottom:4px !important}.pl-1>tbody>tr>td,.px-1>tbody>tr>td{padding-left:4px !important}.p-2>tbody>tr>td{padding:8px !important}.pt-2>tbody>tr>td,.py-2>tbody>tr>td{padding-top:8px !important}.pr-2>tbody>tr>td,.px-2>tbody>tr>td{padding-right:8px !important}.pb-2>tbody>tr>td,.py-2>tbody>tr>td{padding-bottom:8px !important}.pl-2>tbody>tr>td,.px-2>tbody>tr>td{padding-left:8px !important}.p-3>tbody>tr>td{padding:16px !important}.pt-3>tbody>tr>td,.py-3>tbody>tr>td{padding-top:16px !important}.pr-3>tbody>tr>td,.px-3>tbody>tr>td{padding-right:16px !important}.pb-3>tbody>tr>td,.py-3>tbody>tr>td{padding-bottom:16px !important}.pl-3>tbody>tr>td,.px-3>tbody>tr>td{padding-left:16px !important}.p-4>tbody>tr>td{padding:24px !important}.pt-4>tbody>tr>td,.py-4>tbody>tr>td{padding-top:24px !important}.pr-4>tbody>tr>td,.px-4>tbody>tr>td{padding-right:24px !important}.pb-4>tbody>tr>td,.py-4>tbody>tr>td{padding-bottom:24px !important}.pl-4>tbody>tr>td,.px-4>tbody>tr>td{padding-left:24px !important}.p-5>tbody>tr>td{padding:48px !important}.pt-5>tbody>tr>td,.py-5>tbody>tr>td{padding-top:48px !important}.pr-5>tbody>tr>td,.px-5>tbody>tr>td{padding-right:48px !important}.pb-5>tbody>tr>td,.py-5>tbody>tr>td{padding-bottom:48px !important}.pl-5>tbody>tr>td,.px-5>tbody>tr>td{padding-left:48px !important}.s-lg-1>tbody>tr>td,.s-lg-2>tbody>tr>td,.s-lg-3>tbody>tr>td,.s-lg-4>tbody>tr>td,.s-lg-5>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}@media yahoo{.d-mobile{display:none !important}.d-desktop{display:block !important}.w-lg-25{width:25% !important}.w-lg-25>tbody>tr>td{width:25% !important}.w-lg-50{width:50% !important}.w-lg-50>tbody>tr>td{width:50% !important}.w-lg-75{width:75% !important}.w-lg-75>tbody>tr>td{width:75% !important}.w-lg-100{width:100% !important}.w-lg-100>tbody>tr>td{width:100% !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:4px !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:4px !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:4px !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:4px !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:4px !important}.p-lg-2>tbody>tr>td{padding:8px !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:8px !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:8px !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:8px !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:8px !important}.p-lg-3>tbody>tr>td{padding:16px !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:16px !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:16px !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:16px !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:16px !important}.p-lg-4>tbody>tr>td{padding:24px !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:24px !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:24px !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:24px !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:24px !important}.p-lg-5>tbody>tr>td{padding:48px !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:48px !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:48px !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:48px !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:48px !important}.s-lg-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-lg-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-lg-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-lg-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-lg-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-lg-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}'.
        '</style>'.
      '</head>'.
      '<body style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border: 0;" bgcolor="#ffffff">';
  $html='<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:595px;">'.
            '<tr>'.
              '<td class="col-4" style="vertical-align:top;">'.
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
              '<td class="col-4" style="vertical-align:top;">'.
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
          '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:595px;">'.
            '<thead style="background-color:#000000;color:#ffffff;">'.
              '<tr>'.
                '<th class="">Item Code</th>'.
                '<th class="">Title</th>'.
                '<th class="">Option</th>'.
                '<th class="text-center">Quantity</th>'.
                '<th class="text-right">Cost</th>'.
                '<th class="text-right">Total</th>'.
              '</tr>'.
            '</thead>'.
            '<tbody>';
  $i=13;
  $ot=$st=$pwc=0;
  $zeb=1;
  $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='delete' AND `status`!='neg'");
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
  	         '<td class="col-75"><small>'.$i['code'].'</small></td>'.
  	         '<td class="col-150"><small>'.($ro['title']==''?$i['title']:$ro['title']).'</small></td>'.
             '<td class="col-150"><small>'.$ch['title'].'</small></td>'.
             '<td class="col-50 text-center"><small>'.$ro['quantity'].'</small></td>'.
             '<td class="col-50 text-right"><small>'.$ro['cost'].'</small></td>'.
             '<td class="col-50 text-right">'.$st.'</td>'.
            '</tr>';
    $ot=$ot+$st;
    $ot=number_format((float)$ot, 2, '.', '');
    $zeb=($zeb==1?0:1);
  }
  $html.='</tbody>'.
          '<tfoot>';
  $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
  $sr->execute([':rid'=>$r['rid']]);
  if($sr->rowCount()>0){
  	$reward=$sr->fetch(PDO::FETCH_ASSOC);
  	$html.='<tr style="background-color:#f0f0f0">'.
              '<td colspan="4" class="text-right"><small>Rewards</small></td>'.
              '<td class="col-75 text-right"><small>';
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
            '<td class="col-75 text-right"><strong>'.$ot.'</strong></td>'.
          '</tr>';
  }
  if($config['gst']>0){
    $gst=$ot*($config['gst']/100);
    $gst=number_format((float)$gst, 2, '.', '');
    $html.='<tr style="background-color:#f0f0f0">'.
              '<td colspan="4">&nbsp;</td>'.
              '<td class="col-75 text-right">GST</td>'.
              '<td class="col-75 text-right"><strong>'.$gst.'</strong></td>'.
            '</tr>';
    $ot=$ot+$gst;
    $ot=number_format((float)$ot, 2, '.', '');
  }
  if($config['options'][26]==1&&isset($r['uid'])){
    $us=$db->prepare("SELECT `spent` FROM `".$prefix."login` WHERE `id`=:uid");
    $us->execute([':uid'=>$r['uid']]);
    if($us->rowCount()>0){
      $usr=$us->fetch(PDO::FETCH_ASSOC);
      if($usr['spent']>0){
        $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
        $sd->execute([
          ':f'=>$usr['spent'],
          ':t'=>$usr['spent']
        ]);
        if($sd->rowCount()>0){
          $rd=$sd->fetch(PDO::FETCH_ASSOC);
          if($rd['value']==2)$ot=$ot*($rd['cost']/100);
          else$ot=$ot-$rd['cost'];
          $ot=number_format((float)$ot, 2, '.', '');
    $html.='<tr style="background-color:#f0f0f0">'.
            '<td colspan="4" class="text-right">Spent Discount '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost']).' Off</td>'.
            '<td class="col-75 text-right"><strong>'.$ot.'</strong></td>'.
          '</tr>';
        }
      }
    }
  }
  if($r['postageCost']!=0||$r['postageOption']!=''){
  	$html.='<tr style="background-color:#f0f0f0">'.
              '<td colspan="4" class="text-right">Postage: '.$r['postageOption'].'</td>'.
              '<td class="col-75">&nbsp;</td>'.
              '<td class="col-75 text-right"><strong>'.($r['postageCost']!=0?$r['postageCost']:'').'</strong></td>'.
            '</tr>';
  	$ot=$ot+$r['postageCost'];
    $ot=number_format((float)$ot, 2, '.', '');
  }
  $html.='<tr style="background-color:#f0f0f0">'.
            '<td colspan="4">&nbsp;</td>'.
            '<td class="col-75 text-right"><strong>Total</strong></td>'.
            '<td class="col-75 text-right '.$r['status'].'"><strong>'.$ot.'</strong></td>'.
          '</tr>';
  $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
  $sn->execute([':oid'=>$r['id']]);
  if($sn->rowCount()>0){
  	while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
      $html.='<tr style="background-color:#f4f4f4;">'.
          '<td colspan="5" class="text-right">'.
            $rn['title'].' on '.date($config['dateFormat'],$rn['ti']).
          '</td>'.
          '<td class="col-75 text-right">-'.$rn['cost'].'</td>'.
        '</tr>';
      $ot=$ot-$rn['cost'];
    }
    $ot=number_format((float)$ot,2,'.','');
    $html.='<tr style="background-color:#f0f0f0">'.
      '<td colspan="4">&nbsp;</td>'.
      '<td class="col-75 text-right"><strong>Total</strong></td>'.
      '<td class="total text-right"><strong>'.$ot.'</strong></td>'.
    '</tr>';
  }
  $html.='</tfoot>'.
      '</table>'.
      '<br />'.
      '<br />'.
      '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:595px;">'.
        '<tbody>'.
          '<tr>'.
            '<td class="col-4" style="vertical-align:top;">'.
              '<h4>Notes</h4>'.
              '<p style="font-size:8px">'.rawurldecode($r['notes']).'</p>'.
            '</td>'.
            '<td class="col-4" style="vertical-align:top;">'.
              '<h4>Banking Details</h4>'.
              '<p>'.
                '<small>Bank: <strong>'.$config['bank'].'</strong><br />'.
                'Account Name: <strong>'.$config['bankAccountName'].'</strong><br />'.
                'Account Number: <strong>'.$config['bankAccountNumber'].'</strong><br />'.
                'BSB: <strong>'.$config['bankBSB'].'</strong></small>'.
              '</p>'.
            '</td>'.
            '<td class="col-4" style="vertical-align:top;">'.

            '</td>'.
          '</tr>'.
        '</tbody>'.
      '</table>'.
    '</body></html>';
if($act=='print'){
	echo'<script>'.
    'var win = window.top.open("","Print Order","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=595,height=842");'.
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
    URL.'/orders/'.$oid
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
