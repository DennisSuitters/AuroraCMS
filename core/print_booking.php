<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Print Booking
 * @package    core/print_booking.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
include'tcpdf'.DS.'tcpdf.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$r['notes']=preg_replace([
    '/<input type="checkbox" checked="checked">/',
    '/<input type="checkbox">/'
  ],[
    '<img class="checkbox" src="../core/images/checkbox-checked.png">',
    '<img class="checkbox" src="../core/images/checkbox.png">',
  ],$r['notes']);
$bookingid='booking'.$r['id'];
$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$s->execute([':id'=>$r['cid']]);
$c=$s->fetch(PDO::FETCH_ASSOC);
if($r['rid']!=0){
  $sql=$db->prepare("SELECT id,contentType,code,title,assoc FROM `".$prefix."content` WHERE id=:id");
  $sql->execute([':id'=>$r['rid']]);
  $srv=$sql->fetch(PDO::FETCH_ASSOC);
}else $srv='';
$st=$db->prepare("SELECT id,username,name FROM `".$prefix."login` WHERE id=:uid");
$st->execute([':uid'=>$r['uid']]);
$rt=$st->fetch(PDO::FETCH_ASSOC);
$ti=time();
$pdf=new TCPDF(PDF_PAGE_ORIENTATION,PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($config['business']);
$pdf->SetTitle('Booking ');
$pdf->SetSubject('Booking ');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('helvetica','',12);
$pdf->AddPage();
$html='<style>'.
        'body{margin:0;padding:0}'.
        'table{border:0;margin:0}'.
        'table,table tr{background-color:#fff;margin-bottom:10px!important}'.
        'table,table tr td{font-size:10px;height:15px}'.
        'table tr th{background-color:#000;color:#fff;font-size:10px}'.
        '.underline{border-bottom:1px solid #eee;height:15px}'.
        'h1,h2,h3,h4,h5,h6,p{margin:0}'.
        '.w-10{width:10%}'.
        '.w-33{width:33%}'.
        '.w-50{width:50%}'.
        '.w-75{width:75%}'.
        '.w-90{width:90%}'.
        '.w-100{width:100%}'.
        '.w-150{width:150px}'.
        '.w-250{width:250px}'.
        '.text-center{text-align:center}'.
        '.text-right{text-align:right}'.
        '.pending{color:#080}'.
        '.overdue{color:#800}'.
        'img.checkbox{margin:10px;width:12px;height:12px}'.
      '</style>'.
      '<body>';
$pdflogo='';
if(file_exists('..'.DS.'media'.DS.'bookingheading.png'))$pdflogo='..'.DS.'media'.DS.'bookingheading.png';
elseif(file_exists('..'.DS.'media'.DS.'bookingheading.jpg'))$pdflogo='..'.DS.'media'.DS.'bookingheading.jpg';
elseif(file_exists('..'.DS.'media'.DS.'bookingheading.gif'))$pdflogo='..'.DS.'media'.DS.'bookingheading.gif';
elseif(file_exists('..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'bookingheading.png'))$pdflogo='..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'bookingheading.png';
elseif(file_exists('..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'bookingheading.jpg'))$pdflogo='..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'bookingheading.jpg';
elseif(file_exists('..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'bookingheading.gif'))$pdflogo='..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'bookingheading.gif';
else$pdflogo='';
if($pdflogo!='')$html.='<table class="table"><tr><td style="text-align:right"><img src="'.$pdflogo.'"></td></tr></table>';
$html.='<table class="table">'.
          '<tr>'.
            '<td class="col-33">'.
                '<strong>Booked: </strong>'.date($config['dateFormat'],$r['tis']).
            '</td>'.
            '<td class="col-33">'.
                '<strong>To </strong>'.date($config['dateFormat'],($r['tie']!=0?$r['tie']:$r['tis'])).
            '</td>'.
            '<td class="col-33">'.
                '<strong>Status: </strong>'.ucfirst($r['status']).
            '</td>'.
          '</tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr>'.
            '<td class="w-100"><strong>Email: </strong>'.$r['email'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr>'.
            '<td class="w-50"><strong>Phone: </strong>'.$r['phone'].'</td>'.
            '<td class="w-50"><strong>Mobile: </strong>'.$r['mobile'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr>'.
            '<td class="w-50"><strong>Name: </strong>'.$r['name'].'</td>'.
            '<td class="w-50"><strong>Business: </strong>'.$r['business'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr>'.
            '<td class="w-100"><strong>Address: </strong>'.$r['address'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr>'.
            '<td class="w-25"><strong>Suburb: </strong>'.$r['suburb'].'</td>'.
            '<td class="w-25"><strong>City: </strong>'.$r['city'].'</td>'.
            '<td class="w-25"><strong>State: </strong>'.$r['state'].'</td>'.
            '<td class="w-25"><strong>Postcode: </strong>'.$r['postcode'].'</td>'.
          '</tr>'.
        '</table>'.
        '<table class="table w-100">'.
          '<tr>'.
            '<td class="w-100 underline"><strong>Service: </strong>'.($r['rid']!=0?$srv['title']:'').'</td>'.
          '</tr>'.
          '<tr>'.
            '<td class="w-100 underline"></td>'.
          '</tr>'.
          '<tr>'.
            '<td class="w-100 underline"></td>'.
          '</tr>'.
          '<tr>'.
            '<td class="w-100 underline"></td>'.
          '</tr>'.
          '<tr>'.
            '<td class="w-100 underline"></td>'.
          '</tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr rowspan="6">'.
            '<td class="w-50"><strong>Notes:</strong><br />'.$r['notes'].'</td>'.
            '<td class="w-50"><strong>Result:</strong><br />'.$r['notes2'].'</td>'.
          '</tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
          '<tr><td></td></tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr><td colspan="2" class="underline"></td></tr>'.
          '<tr><td colspan="2"></td></tr>'.
          '<tr>'.
            '<td class="w-10">'.($r['agreementCheck'][0]==1?'<img class="checkbox" src="../core/images/checkbox-checked.png">':'<img class="checkbox" src="../core/images/checkbox.png">').'</td>'.
            '<td class="w-90">'.$config['bookingAgreement'].'</td>'.
          '</tr>'.
          '<tr><td colspan="2" class="underline"></td></tr>'.
          '<tr><td colspan="2"></td></tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr>'.
            '<td><strong>Signature</strong></td>'.
          '</tr>'.
          '<tr>'.
            '<td>'.($r['signature']!=''?'<img src="@'.preg_replace('#^data:image/[^;]+;base64,#','',$r['signature']).'">':'<img src="../core/images/emptysig.png" height="80">').'</td>'.
          '</tr>'.
        '</table>'.
        '<table class="table">'.
          '<tr>'.
            '<td><strong>Technician: </strong>'.($rt['name']==''?$r['username']:$r['name']).'</td>'.
            '<td><strong>Hours: </strong>'.$r['cost'].'</td>'.
          '</tr>'.
        '</table>'.
  '</body>';
$pdf->writeHTML($html,true,false,true,false,'');
$pdf->Output(__DIR__.DS.'..'.DS.'media'.DS.'orders'.DS.$bookingid.'.pdf','F');
//chmod('..' .DS.'media'.DS.'orders'.DS.$bookingid.'.pdf',0777);
echo'<script>window.top.window.open(`media/orders/'.$bookingid.'.pdf`,`_blank`);</script>';
