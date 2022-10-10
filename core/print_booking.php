<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Print Booking
 * @package    core/print_booking.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$bookingid='booking'.$r['id'];
$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$s->execute([':id'=>$r['cid']]);
$c=$s->fetch(PDO::FETCH_ASSOC);
if($r['rid']!=0){
  $sql=$db->prepare("SELECT `id`,`contentType`,`code`,`title`,`assoc` FROM `".$prefix."content` WHERE `id`=:id");
  $sql->execute([':id'=>$r['rid']]);
  $srv=$sql->fetch(PDO::FETCH_ASSOC);
}else$srv='';
$st=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:uid");
$st->execute([':uid'=>$r['uid']]);
$rt=$st->fetch(PDO::FETCH_ASSOC);
$ti=time();
$head='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
  '<html xmlns="http://www.w3.org/1999/xhtml">'.
    '<head>'.
      '<title>View Booking for Printing</title>'.
      '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.
      '<style type="text/css">'.
          '.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}body,td,input,textarea,select{margin:unset;font-family:unset}input,textarea,select{font-size:unset}@media screen and (max-width: 600px){table.row th.col-lg-1,table.row th.col-lg-2,table.row th.col-lg-3,table.row th.col-lg-4,table.row th.col-lg-5,table.row th.col-lg-6,table.row th.col-lg-7,table.row th.col-lg-8,table.row th.col-lg-9,table.row th.col-lg-10,table.row th.col-lg-11,table.row th.col-lg-12{display:block;width:100% !important}.d-mobile{display:block !important}.d-desktop{display:none !important}.w-lg-25{width:auto !important}.w-lg-25>tbody>tr>td{width:auto !important}.w-lg-50{width:auto !important}.w-lg-50>tbody>tr>td{width:auto !important}.w-lg-75{width:auto !important}.w-lg-75>tbody>tr>td{width:auto !important}.w-lg-100{width:auto !important}.w-lg-100>tbody>tr>td{width:auto !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.w-25{width:25% !important}.w-25>tbody>tr>td{width:25% !important}.w-50{width:50% !important}.w-50>tbody>tr>td{width:50% !important}.w-75{width:75% !important}.w-75>tbody>tr>td{width:75% !important}.w-100{width:100% !important}.w-100>tbody>tr>td{width:100% !important}.w-auto{width:auto !important}.w-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:0 !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:0 !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:0 !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:0 !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:0 !important}.p-lg-2>tbody>tr>td{padding:0 !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:0 !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:0 !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:0 !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:0 !important}.p-lg-3>tbody>tr>td{padding:0 !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:0 !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:0 !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:0 !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:0 !important}.p-lg-4>tbody>tr>td{padding:0 !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:0 !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:0 !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:0 !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:0 !important}.p-lg-5>tbody>tr>td{padding:0 !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:0 !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:0 !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:0 !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:0 !important}.p-0>tbody>tr>td{padding:0 !important}.pt-0>tbody>tr>td,.py-0>tbody>tr>td{padding-top:0 !important}.pr-0>tbody>tr>td,.px-0>tbody>tr>td{padding-right:0 !important}.pb-0>tbody>tr>td,.py-0>tbody>tr>td{padding-bottom:0 !important}.pl-0>tbody>tr>td,.px-0>tbody>tr>td{padding-left:0 !important}.p-1>tbody>tr>td{padding:4px !important}.pt-1>tbody>tr>td,.py-1>tbody>tr>td{padding-top:4px !important}.pr-1>tbody>tr>td,.px-1>tbody>tr>td{padding-right:4px !important}.pb-1>tbody>tr>td,.py-1>tbody>tr>td{padding-bottom:4px !important}.pl-1>tbody>tr>td,.px-1>tbody>tr>td{padding-left:4px !important}.p-2>tbody>tr>td{padding:8px !important}.pt-2>tbody>tr>td,.py-2>tbody>tr>td{padding-top:8px !important}.pr-2>tbody>tr>td,.px-2>tbody>tr>td{padding-right:8px !important}.pb-2>tbody>tr>td,.py-2>tbody>tr>td{padding-bottom:8px !important}.pl-2>tbody>tr>td,.px-2>tbody>tr>td{padding-left:8px !important}.p-3>tbody>tr>td{padding:16px !important}.pt-3>tbody>tr>td,.py-3>tbody>tr>td{padding-top:16px !important}.pr-3>tbody>tr>td,.px-3>tbody>tr>td{padding-right:16px !important}.pb-3>tbody>tr>td,.py-3>tbody>tr>td{padding-bottom:16px !important}.pl-3>tbody>tr>td,.px-3>tbody>tr>td{padding-left:16px !important}.p-4>tbody>tr>td{padding:24px !important}.pt-4>tbody>tr>td,.py-4>tbody>tr>td{padding-top:24px !important}.pr-4>tbody>tr>td,.px-4>tbody>tr>td{padding-right:24px !important}.pb-4>tbody>tr>td,.py-4>tbody>tr>td{padding-bottom:24px !important}.pl-4>tbody>tr>td,.px-4>tbody>tr>td{padding-left:24px !important}.p-5>tbody>tr>td{padding:48px !important}.pt-5>tbody>tr>td,.py-5>tbody>tr>td{padding-top:48px !important}.pr-5>tbody>tr>td,.px-5>tbody>tr>td{padding-right:48px !important}.pb-5>tbody>tr>td,.py-5>tbody>tr>td{padding-bottom:48px !important}.pl-5>tbody>tr>td,.px-5>tbody>tr>td{padding-left:48px !important}.s-lg-1>tbody>tr>td,.s-lg-2>tbody>tr>td,.s-lg-3>tbody>tr>td,.s-lg-4>tbody>tr>td,.s-lg-5>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}@media yahoo{.d-mobile{display:none !important}.d-desktop{display:block !important}.w-lg-25{width:25% !important}.w-lg-25>tbody>tr>td{width:25% !important}.w-lg-50{width:50% !important}.w-lg-50>tbody>tr>td{width:50% !important}.w-lg-75{width:75% !important}.w-lg-75>tbody>tr>td{width:75% !important}.w-lg-100{width:100% !important}.w-lg-100>tbody>tr>td{width:100% !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:4px !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:4px !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:4px !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:4px !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:4px !important}.p-lg-2>tbody>tr>td{padding:8px !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:8px !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:8px !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:8px !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:8px !important}.p-lg-3>tbody>tr>td{padding:16px !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:16px !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:16px !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:16px !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:16px !important}.p-lg-4>tbody>tr>td{padding:24px !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:24px !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:24px !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:24px !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:24px !important}.p-lg-5>tbody>tr>td{padding:48px !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:48px !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:48px !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:48px !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:48px !important}.s-lg-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-lg-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-lg-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-lg-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-lg-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-lg-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}'.
      '</style>'.
    '</head>'.
    '<body style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border: 0;" bgcolor="#ffffff">';
$html='<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr>'.
            '<td class="col-4">'.
                '<strong>Booked: </strong>'.date($config['dateFormat'],$r['tis']).
            '</td>'.
            '<td class="col-4">'.
                '<strong>To </strong>'.date($config['dateFormat'],($r['tie']!=0?$r['tie']:$r['tis'])).
            '</td>'.
            '<td class="col-4">'.
                '<strong>Status: </strong>'.ucfirst($r['status']).
            '</td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr>'.
            '<td class="col-12"><strong>Email: </strong>'.$r['email'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr>'.
            '<td class="col-6"><strong>Phone: </strong>'.$r['phone'].'</td>'.
            '<td class="col-6"><strong>Mobile: </strong>'.$r['mobile'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr>'.
            '<td class="col-6"><strong>Name: </strong>'.$r['name'].'</td>'.
            '<td class="col-6"><strong>Business: </strong>'.$r['business'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr>'.
            '<td class="col-12"><strong>Address: </strong>'.$r['address'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr>'.
            '<td class="col-3"><strong>Suburb: </strong>'.$r['suburb'].'</td>'.
            '<td class="col-3"><strong>City: </strong>'.$r['city'].'</td>'.
            '<td class="col-3"><strong>State: </strong>'.$r['state'].'</td>'.
            '<td class="col-3"><strong>Postcode: </strong>'.$r['postcode'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr>'.
            '<td class="col-12"><strong>Service: </strong>'.($r['rid']!=0?$srv['title']:'').'</td>'.
          '</tr>'.
          '<tr>'.
            '<td class="col-12"></td>'.
          '</tr>'.
          '<tr>'.
            '<td class="col-12"></td>'.
          '</tr>'.
          '<tr>'.
            '<td class="col-12"></td>'.
          '</tr>'.
          '<tr>'.
            '<td class="col-12"></td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto; width: 595px;">'.
          '<tr rowspan="6">'.
            '<td class="col-6" style="vertical-align: top;"><strong>Notes:</strong><br />'.$r['notes'].'</td>'.
            '<td class="col-6" style="vertical-align: top;"><strong>Result:</strong><br />'.$r['notes2'].'</td>'.
          '</tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:595px;">'.
          '<tr><td colspan="2"></td></tr>'.
          '<tr><td colspan="2"></td></tr>'.
          '<tr>'.
            '<td class="col-2" style="text-align: center; vertical-align: top;"><input type="checkbox"'.($r['agreementCheck']==1?' checked="checked" aria-checked="true"':' aria-checked="false"').'></td>'.
            '<td class="col-10">'.$config['bookingAgreement'].'</td>'.
          '</tr>'.
          '<tr><td colspan="2"></td></tr>'.
          '<tr><td colspan="2"></td></tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:595px;">'.
          '<tr>'.
            '<td><strong>Signature</strong></td>'.
          '</tr>'.
          '<tr>'.
            '<td>'.($r['signature']!=''?'<img src="'.$r['signature'].'" style="width: 595px;max-height: 80px;">':'<img src="images/emptysig.png" height="80">').'</td>'.
          '</tr>'.
        '</table>'.
        '<table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 0 auto;width:595px;">'.
          '<tr>'.
            '<td><strong>Technician: </strong>'.($rt['name']==''?$r['username']:$r['name']).'</td>'.
            '<td><strong>Hours: </strong>'.$r['cost'].'</td>'.
          '</tr>'.
        '</table>'.
  '</body>';
echo'<script>'.
  'var win = window.top.open("","Print Order","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=595,height=842");'.
  'win.top.document.body.innerHTML = `'.$head.$html.'`;'.
'</script>';
