<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Quick Edit
 * @package    core/quickedit.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$rank=isset($_SESSION['rank'])?$_SESSION['rank']:400;
function rank($rank){
  if($rank==0)return"Visitor";
  if($rank==100)return"Subscriber";
  if($rank==200)return"Member";
  if($rank==210)return"Member Bronze";
  if($rank==220)return"Member Silver";
  if($rank==230)return"Member Gold";
  if($rank==240)return"Member Platinum";
  if($rank==300)return"Client";
  if($rank==310)return"Wholesaler";
  if($rank==320)return"Wholesaler Bronze";
  if($rank==330)return"Wholesaler Silver";
  if($rank==340)return"Wholesaler Gold";
  if($rank==350)return"Wholesaler Platinum";
  if($rank==400)return"Contributor";
  if($rank==500)return"Author";
  if($rank==600)return"Editor";
  if($rank==700)return"Moderator";
  if($rank==800)return"Manager";
  if($rank==900)return"Administrator";
  if($rank==1000)return"Developer";
}
function rankclass($rank){
  if($rank==0)return"visitor";
  if($rank==100)return"subscriber";
  if($rank==200)return"member";
  if($rank==210)return"member-bronze";
  if($rank==220)return"member-silver";
  if($rank==230)return"member-gold";
  if($rank==240)return"member-platinum";
  if($rank==300)return"client";
  if($rank==310)return"wholesale";
  if($rank==320)return"wholesale-bronze";
  if($rank==330)return"wholesale-silver";
  if($rank==340)return"wholesale-gold";
  if($rank==350)return"wholesale-platinum";
  if($rank==400)return"contributor";
  if($rank==500)return"author";
  if($rank==600)return"editor";
  if($rank==700)return"moderator";
  if($rank==800)return"manager";
  if($rank==900)return"administrator";
  if($rank==1000)return"developer";
}
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$o=isset($_POST['o'])?filter_input(INPUT_POST,'o',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'o',FILTER_UNSAFE_RAW);
if($o=='modal'){
  echo'<div class="fancybox-ajax quickedit p-2">';
}
if($t=='content'||$t=='login'||$t=='orders'||$t=='agronomy_data'){
	$s=$db->prepare("SELECT * FROM `".$prefix.$t."` WHERE id=:id");
	$s->execute([':id'=>$id]);
	$r=$s->fetch(PDO::FETCH_ASSOC);
	if(!isset($r['id']))$r['id']=0;
	if(!isset($r['contentType']))$r['contentType']='';
	if(!isset($r['urlSlug']))$r['urlSlug']='';
	if(!isset($r['ti']))$r['ti']=0;
	if(!isset($r['pti']))$r['pti']=0;
	if(!isset($r['eti']))$r['eti']=0;
	if(!isset($r['status']))$r['status']='';
	if(!isset($r['rank']))$r['rank']=0;
  if($t=='login'){
    echo'<div class="row">'.
      '<div class="col-12">'.
        '<div class="row">'.
          '<div class="col-12 col-sm-4 p-1">'.
            '<div class="row">'.
              '<div class="col-12 col-sm-6 pr-2">'.
                '<label>Name</label>'.
                '<div class="input-text">'.$r['name'].'</div>'.
              '</div>'.
              '<div class="col-12 col-sm-6">'.
                '<label>Business</label>'.
                '<div class="input-text">'.$r['business'].'&nbsp;</div>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label>Email</label>'.
              '<div class="form-row">'.
                '<div class="input-text">'.
                  $r['email'].
                '</div>';
                $sm=$db->prepare("SELECT id FROM `".$prefix."choices` WHERE `contentType`='mailbox'");
                $sm->execute();
                if($sm->rowCount()>0){
                  $email=URL.$settings['system']['admin'].'/messages/compose/';
                  $emailwin=false;
                }else{
                  $email='mailto:';
                  $emailwin=true;
                }
                echo'<button class="mr-2" data-tooltip="tooltip" aria-label="Send Email" onclick="window.open(`'.$email.'`+$(`#qeemail'.$r['id'].'`).val(),'.($emailwin==true?'`_blank`':'`_self`').');"><i class="i">email-send</i></button>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label>URL</label>'.
              '<div class="input-text">'.'<a target="_blank" href="'.$r['url'].'">'.$r['url'].'</a>&nbsp;'.'</div>'.
            '</div>'.
            '<div class="row">'.
              '<div class="col-12 col-sm-6 pr-2">'.
                '<label>Phone</label>'.
                '<div class="input-text">'.$r['phone'].'&nbsp;</div>'.
              '</div>'.
              '<div class="col-12 col-sm-6">'.
                '<label>Mobile</label>'.
                '<div class="input-text">'.$r['mobile'].'&nbsp;</div>'.
              '</div>'.
            '</div>'.
          '</div>'.
          '<div class="col-12 col-sm-4 p-1">'.
            '<div class="row">'.
              '<label>Address</label>'.
              '<div class="input-text">'.$r['address'].'</div>'.
            '</div>'.
            '<div class="row">'.
              '<div class="col-12 col-sm-6 pr-2">'.
                '<label>Suburb</label>'.
                '<div class="input-text">'.$r['suburb'].'</div>'.
              '</div>'.
              '<div class="col-12 col-sm-6">'.
                '<label>City</label>'.
                '<div class="input-text">'.$r['city'].'</div>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<div class="col-12 col-sm-6 pr-2">'.
                '<label>State</label>'.
                '<div class="input-text">'.$r['state'].'</div>'.
              '</div>'.
              '<div class="col-12 col-sm-6">'.
                '<label>Postcode</label>'.
                '<div class="input-text">'.($r['postcode']!=0?$r['postcode']:'').'</div>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label>Country</label>'.
              '<div class="input-text">'.$r['country'].'</div>'.
            '</div>'.
            '<div class="row">'.
              '<label>Tags</label>'.
              '<div class="input-text">'.$r['tags'].'&nbsp;</div>'.
            '</div>'.
          '</div>'.
          '<div class="col-12 col-sm-4 p-1">'.
            '<div class="row">'.
              '<label>Created</label>'.
              '<div class="input-text">'.date($config['dateFormat'],$r['ti']).'</div>'.
            '</div>'.
            '<div class="row">'.
              '<label>Rank</label>'.
              '<div class="input-text">'.$r['rank'].'</div>'.
            '</div>'.
            '<div class="row'.($r['rank']<301||$r['rank']>399?' d-none':'').'">'.
              '<input'.($r['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"').' readonly>'.
              '<label>Wholesaler Accepted to Purchase</label>'.
            '</div>'.
            '<div class="row">'.
              '<label>Spent</label>'.
              '<div class="form-row">'.
                '<div class="input-text font-bold">$</div>'.
                '<div class="input-text">'.$r['spent'].'</div>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label>Points Earned</label>'.
              '<div class="input-text">'.$r['points'].'</div>'.
            '</div>'.
            '<div class="row'.($r['newsletter']==1?'':' d-none').'">'.
              '<label>User is a Newsletter Subscriber</label>'.
            '</div>'.
            '<div class="row">'.
              '<label>IP:</label>'.
              '<div class="input-text">'.$r['userIP'].'</div>'.
            '</div>'.
            '<div class="row">'.
              '<label>Browser Info:</label>'.
              $r['userAgent'].
            '</div>'.
          '</div>'.
        '</div>'.
      '</div>'.
    '</div>';
  }
  if($t=='content'){
    echo'<div class="row">'.
      '<div class="col-12">'.
        '<div class="row">'.
          '<div class="col-12 col-sm-4 p-1">'.
            '<div class="row">'.
              '<label>URL Slug</label>'.
              '<div class="input-text">'.
                '<a id="qegenurl'.$r['id'].'" target="_blank" href="'.URL.$r['contentType'].'/'.$r['urlSlug'].'">'.URL.$r['contentType'].'/'.$r['urlSlug'].' <i class="i">new-window</i></a>'.
              '</div>'.
            '</div>';
            if($r['contentType']=='inventory'||$r['contentType']=='service'){
              echo'<div class="row">'.
                '<div class="col-6 pr-1">'.
                  '<label data-tooltip="tooltip" aria-label="Recommended Retail Price">RRP</label>'.
                  '<div class="form-row">'.
                    '<div class="input-text font-bold">$</div>'.
                    '<div class="input-text col-12">'.$r['rrp'].'</div>'.
                  '</div>'.
                '</div>'.
                '<div class="col-6">'.
                  '<label>Cost</label>'.
                  '<div class="form-row">'.
                    '<div class="input-text font-bold">$</div>'.
                    '<div class="input-text col-12">'.$r['cost'].'</div>'.
                  '</div>'.
                '</div>'.
              '</div>'.
              '<div class="row">'.
                '<div class="col-6 pr-1">'.
                  '<label>Reduced Cost</label>'.
                  '<div class="form-row">'.
                    '<div class="input-text font-bold">$</div>'.
                    '<div class="input-text col-12">'.$r['rCost'].'</div>'.
                  '</div>'.
                '</div>'.
                '<div class="col-6">'.
                  '<label>Wholesale Cost</label>'.
                  '<div class="form-row">'.
                    '<div class="input-text font-bold">$</div>'.
                    '<div class="input-text col-12">'.$r['dCost'].'</div>'.
                  '</div>'.
                '</div>'.
              '</div>';
            }
            if($r['contentType']=='inventory'){
              echo'<div class="row">'.
                '<div class="col-6 pr-1">'.
                  '<label>Quantity</label>'.
                  '<div class="input-text">'.$r['quantity'].'</div>'.
                '</div>'.
                '<div class="col-6">'.
                  '<label>Carton Quantity</label>'.
                  '<div class="input-text">'.$r['cartonQuantity'].'</div>'.
                '</div>'.
              '</div>'.
              '<div class="row">'.
                '<label>Stock Status</label>'.
                '<div class="input-text">'.
                  ($r['stockStatus']=='quantity'?'Dependant on Quantity (In Stock/Out Of Stock)':'').
                  ($r['stockStatus']=='in stock'?'In Stock':'').
                  ($r['stockStatus']=='out of stock'?'Out Of Stock':'').
                  ($r['stockStatus']=='back order'?'Back Order':'').
                  ($r['stockStatus']=='pre order'?'Pre Order':'').
                  ($r['stockStatus']=='available'?'Available':'').
                  ($r['stockStatus']=='sold out'?'Sold Out':'').
                  ($r['stockStatus']=='none'||$r['stockStatus']==''?'No Display':'').
                '</div>'.
              '</div>';
            }
            echo'</div>'.
              '<div class="col-12 col-sm-4 p-1">';
                if($r['contentType']=='events'){
                  echo'<div class="row">'.
                    '<label>Event Start</label>'.
                    '<div class="input-text">'.date($config['dateFormat'],$r['tis']).'&nbsp;</div>'.
                  '</div>'.
                  '<div class="row">'.
                    '<label>Event End</label>'.
                    '<div class="input-text">'.($r['tie']!=0?date($config['dateFormat'],$r['tie']):'').'&nbsp;</div>'.
                  '</div>';
                }
                if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){
                  echo'<div class="row">'.
                    '<label>Category One</label>'.
                    '<div class="input-text">'.$r['category_1'].'&nbsp;</div>'.
                  '</div>'.
                  '<div class="row">'.
                    '<label>Category Two</label>'.
                    '<div class="input-text">'.$r['category_2'].'&nbsp;</div>'.
                  '</div>'.
                  '<div class="row">'.
                    '<label>Category Three</label>'.
                    '<div class="input-text">'.$r['category_3'].'&nbsp;</div>'.
                  '</div>'.
                  '<div class="row">'.
                    '<label>Category Four</label>'.
                    '<div class="input-text">'.$r['category_4'].'&nbsp;</div>'.
                  '</div>'.
                  '<div class="row">'.
                    '<label>Tags</label>'.
                    '<div class="input-text">'.$r['tags'].'&nbsp;</div>';
                  '</div>';
                }
              echo'</div>'.
            '</div>'.
            '<div class="col-12 col-sm-4 p-1">'.
              '<div class="row">'.
                '<label>Created</label>'.
                '<div class="input-text">'.date($config['dateFormat'],$r['ti']).'</div>'.
              '</div>'.
              '<div class="row">'.
                '<label>Published On</label>'.
                '<div class="input-text">'.date($config['dateFormat'],$r['pti']).'</div>'.
              '</div>'.
              '<div class="row">'.
                '<label>Status</label>'.
                '<div class="input-text">'.
                  ($r['status']=='unpublished'?'Unpublished':'').
                  ($r['status']=='autopublish'?'AutoPublish':'').
                  ($r['status']=='published'?'Published':'').
                  ($r['status']=='delete'?'Delete':'').
                  ($r['status']=='archived'?'Archived':'').
                '</div>'.
              '</div>'.
              '<div class="row">'.
                '<label>Access</label>'.
                '<div class="input-text">'.
                  ($r['rank']==0?'Available to <span class="badger badge-secondary mx-1">Everyone</span>':'').
                  ($r['rank']==100?'Available to <span class="badger badge-subscriber mx-1">Subscriber</span> and Above':'').
                  ($r['rank']==200?'Available to <span class="badger badge-member mx-1">Member</span> and Above':'').
                  ($r['rank']==210?'Available to <span class="badger badge-member-bronze mx-1">Member Bronze</span> and Above':'').
                  ($r['rank']==220?'Available to <span class="badger badge-member-silver mx-1">Member Silver</span> and Above':'').
                  ($r['rank']==230?'Available to <span class="badger badge-member-gold mx-1">Member Gold</span> and Above':'').
                  ($r['rank']==240?'Available to <span class="badger badge-member-platinum mx-1">Member Platinum</span> and Above':'').
                  ($r['rank']==300?'Available to <span class="badger badge-client mx-1">Client</span> and Above':'').
                  ($r['rank']==310?'Available to <span class="badger badge-wholesale mx-1">Wholesaler</span> and Above':'').
                  ($r['rank']==320?'Available to <span class="badger badge-wholesale-bronze mx-1">Wholesaler Bronze</span> and Above':'').
                  ($r['rank']==330?'Available to <span class="badger badge-wholesale-silver mx-1">Wholesaler Silver</span> and Above':'').
                  ($r['rank']==340?'Available to <span class="badger badge-wholesale-gold mx-1">Wholesaler Gold</span> and Above':'').
                  ($r['rank']==350?'Available to <span class="badger badge-wholesale-platinum mx-1">Wholesaler Platinum</span> and Above':'').
                  ($r['rank']==400?'Available to <span class="badger badge-contributor mx-1">Contributor</span> and Above':'').
                  ($r['rank']==500?'Available to <span class="badger badge-author mx-1">Author</span> and Above':'').
                  ($r['rank']==600?'Available to <span class="badger badge-editor mx-1">Editor</span> and Above':'').
                  ($r['rank']==700?'Available to <span class="badger badge-moderator mx-1">Moderator</span> and Above':'').
                  ($r['rank']==800?'Available to <span class="badger badge-manager mx-1">Manager</span> and Above':'').
                  ($r['rank']==900?'Available to <span class="badger badge-administrator mx-1">Administrator</span> and Above':'').
                '</div>'.
              '</div>'.
              '<div class="row">'.
                '<label>Last Edited</label>'.
                '<div class="input-text">'.($r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user']).'</div>'.
              '</div>'.
            '</div>'.
          '</div>'.
        '</div>'.
      '</div>'.
    '</div>';
  }
  if($t=='orders'){
    $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
    $su->execute([':id'=>$r['uid']]);
    $ru=$su->fetch(PDO::FETCH_ASSOC);
    $track=['title'=>''];
    if($r['trackOption']!=0){
      $st=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
      $st->execute([':id'=>$r['trackOption']]);
      $track=$st->fetch(PDO::FETCH_ASSOC);
    }
    echo'<div class="mx-auto p-2 border-0 orderstheme">'.
      '<section class="row">'.
        '<article class="col-12 col-sm mx-0 px-0 py-0 pl-1 border-right text-left">'.
          '<h3>To</h3>'.
          '<div class="ml-2">'.
            $ru['name'].'<br>'.
            $ru['address'].', '.$ru['suburb'].'<br>'.
            $ru['city'].', '.$ru['state'].', '.$ru['postcode'].'<br>'.
            'Email: '.$ru['email'].'<br>'.
            ($ru['phone']!=''?'Phone: '.$ru['phone'].'<br>':'').
            ($ru['mobile']!=''?'Mobile: '.$ru['mobile']:'').
          '</div>'.
        '</article>'.
        '<article class="col-12 col-sm mx-0 px-0 py-0 pl-1 text-left">'.
          '<div class="form-row">'.
            '<label class="col-3">Paid&nbsp;Via</label>'.
            '<div class="input-text border-0 bg-transparent">'.ucwords($r['paid_via']).'&nbsp;</div>'.
          '</div>'.
          '<div class="form-row">'.
            '<label class="col-3">Transaction&nbsp;ID</label>'.
            '<div class="input-text border-0 bg-transparent">'.$r['txn_id'].'&nbsp;</div>'.
          '</div>'.
          '<div class="form-row">'.
            '<label class="col-3">Date&nbsp;Paid</label>'.
            '<div class="input-text border-0 bg-transparent">'.($r['paid_ti']!=0?date($config['dateFormat'],$r['paid_ti']):'&nbsp;').'</div>'.
          '</div>'.
          '<div class="form-row">'.
            '<label class="col-3">Paid&nbsp;Name</label>'.
            '<div class="input-text border-0 bg-transparent">'.$r['paid_name'].'&nbsp;</div>'.
          '</div>'.
          '<div class="form-row">'.
            '<label class="col-3">Paid&nbsp;Email</label>'.
            '<div class="input-text border-0 bg-transparent">'.$r['paid_email'].'</div>'.
          '</div>'.
          ($track['title']!=''?
            '<div class="form-row">'.
              '<label>Tracking&nbsp;Details:</label>'.
            '</div>'.
            '<div class="form-row ml-3">'.
              '<label class="col-3">Service:</label>'.
              '<div class="input-text border-0 bg-transparent">'.$track['title'].'&nbsp;</div>'.
            '</div>'.
            '<div class="form-row ml-3">'.
              '<label class="col-3">Tracking&nbsp;Number:</label>'.
              '<div class="input-text border-0 bg-transparent">'.$track['trackNumber'].'&nbsp;<div>'.
            '</div>'
          :'').
        '</article>'.
      '</section>'.
      '<section class="row m-0">'.
        '<article class="m-0 p-0">'.
          '<table class="table zebra text-black">'.
            '<thead>'.
              '<tr class="bg-black text-white">'.
                '<th class="col-1 text-left">Code</th>'.
                '<th class="col-auto text-left">Title</th>'.
                '<th class="col-auto text-left">Option</th>'.
                '<th class="col-1 text-center">Qty</th>'.
                '<th class="col-1 text-right">Cost</th>'.
                '<th class="text-center" title="Goods &amp; Services Tax">GST</th>'.
                '<th class="col-1 text-right">Total</th>'.
              '</tr>'.
            '</thead>'.
            '<tbody>';
              $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `status` ASC, `ti` ASC,`title` ASC");
              $ss->execute([':oid'=>$r['id']]);
              $total=0;
              while($oi=$ss->fetch(PDO::FETCH_ASSOC)){
                $is=$db->prepare("SELECT `id`,`thumb`,`file`,`fileURL`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                $is->execute([':id'=>$oi['iid']]);
                $i=$is->fetch(PDO::FETCH_ASSOC);
                $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
                $sc->execute([':id'=>$oi['cid']]);
                $c=$sc->fetch(PDO::FETCH_ASSOC);
                echo'<tr class="'.($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?'bg-warning':'').'">'.
                  '<td class="text-left align-middle small px-0">'.(isset($i['code'])?$i['code']:'').'</td>'.
                  '<td class="text-left align-middle px-0">'.($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?ucwords($oi['status']).': ':'').$oi['title'].'</td>'.
                  '<td class="text-left align-middle px-0">'.(isset($c['title'])?$c['title']:'').'</td>'.
                  '<td class="text-center align-middle px-0">'.($r['iid']!=0?$oi['quantity']:'').'</td>'.
                  '<td class="text-right align-middle">'.($r['iid_ti']!=0?number_format((float)$oi['cost'],2,'.',''):'').'</td>'.
                  '<td class="text-right align-middle">';
                  $gst=0;
                  if($oi['status']!='pre order'||$oi['status']!='back order'){
                    if($config['gst']>0){
                      $gst=$oi['cost']*($config['gst']/100);
                      if($oi['quantity']>1)$gst=$gst*$oi['quantity'];
                      $gst=number_format((float)$gst,2,'.','');
                    }
                    echo$gst>0?$gst:'';
                  }
                  echo'</td>'.
                  '<td class="text-right align-middle">';
                    if($oi['status']!='pre order'||$oi['status']!='back order'){
                      echo$oi['iid']!=0?number_format((float)$oi['cost']*$oi['quantity']+$gst,2,'.',''):'';
                    }else{
                      echo'<small>'.($oi['status']=='pre order'?'Pre Order':'Back Order').'</small>';
                    }
                  echo'</td>'.
                '</tr>';
                if($oi['status']!='pre order'||$oi['status']!='back order'){
                  if($oi['iid']!=0){
                    $total=$total+($oi['cost']*$oi['quantity'])+$gst;
                    $total=number_format((float)$total,2,'.','');
                  }
                }
              }
              if($r['rid']>0){
                $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
                $sr->execute([':rid'=>$r['rid']]);
                $reward=$sr->fetch(PDO::FETCH_ASSOC);
                echo'<tr>'.
                  '<td class="text-right align-middle px-0 font-weight-bold">Rewards</td>'.
                  '<td colspan="5" class="text-right align-middle">Code: '.($reward['method']==1?'$':'%').' Off</td>'.
                  '<td class="text-right">'.$reward['value'].'</td>'.
                  '<td class="align-middle px-0" colspan="3">'.$reward['code'].'</td>'.
                  '<td class="text-center align-middle px-0">';
                    if($sr->rowCount()==1){
                      if($reward['method']==1){
                        echo'$';
                        $total=$total-$reward['value'];
                      }
                      echo$reward['value'];
                      if($reward['method']==0){
                        echo'%';
                        $total=($total*((100-$reward['value'])/100));
                      }
                      $total=number_format((float)$total,2,'.','');
                      echo' Off';
                    }
                  echo'</td>'.
                  '<td class="text-right align-middle">'.(isset($reward['value'])?($reward['value']>0?$total:''):'').'</td>'.
                '</tr>';
              }
              if($config['options'][26]==1){
                $dedtot=0;
                $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
                $sd->execute([
                  ':f'=>$ru['spent'],
                  ':t'=>$ru['spent']
                ]);
                if($sd->rowCount()>0){
                  $rd=$sd->fetch(PDO::FETCH_ASSOC);
                  if($rd['value']==1)$dedtot=$rd['cost'];
                  if($rd['value']==2)$dedtot=$total*($rd['cost']/100);
                  $total=$total - $dedtot;
                  echo'<tr>'.
                    '<td colspan="2" class="align-middle text-right font-px-0 weight-bold">Spent</td>'.
                    '<td colspan="5" class="align-middle text-right px-0">&#36;'.$ru['spent'].' within Discount Range &#36;'.$rd['f'].'-&#36;'.$rd['t'].' granting '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost'].' Off').'</td>'.
                    '<td colspan="5" class="align-middle text-right">-'.$dedtot.'</td>'.
                  '</tr>';
                }
              }
              if($r['postageOption']!=''){
                echo'<tr>'.
                  '<td class="text-right align-middle font-weight-bolod">Shipping</td>'.
                  '<td colspan="5" class="text-right align-middle">'.$r['postageOption'].'</td>'.
                  '<td class="text-right align-middle">'.$r['postageCost'].'</td>'.
                '</tr>';
                if($r['postageCost']>0){
                  $total=$total+$r['postageCost'];
                  $total=number((float)$total,2,'.','');
                }
              }
              echo'</tbody>'.
              '<tfoot>'.
                '<tr>'.
                  '<td colspan="6" class="text-right align-middle font-weight-bold">Total</td>'.
                  '<td class="total align-middle">'.$total.'</td>'.
                '</tr>';
                $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
                $sn->execute([':oid'=>$r['id']]);
                if($sn->rowCount()>0){
                  while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
                    echo'<tr>'.
                      '<td colspan="2" class="small align-middle">'.date($config['dateFormat'],$rn['ti']).'</td>'.
                      '<td colspan="4" class="align-middle">'.$rn['title'].'</td>'.
                      '<td class="align-middle text-right">-'.number_format((float)$rn['cost'],2,'.','').'</td>'.
                    '</tr>';
                    $total=$total-$rn['cost'];
                    $total=number_format((float)$total,2,'.','');
                  }
                  echo'<tr>'.
                    '<td colspan="6" class="text-right font-weight-bold">Balance</td>'.
                    '<td class="total">'.$total.'</td>'.
                  '</tr>';
                }
              echo'</tfoot>'.
            '</table>'.
          '</article>'.
        '</section>'.
      '</div>';
    }
  }
  if($t=='agronomy_data'){
    $sl=$db->prepare("SELECT * FROM `".$prefix."agronomy_livestock` WHERE `id`=:lid LIMIT 1");
    $sl->execute([':lid'=>$r['lid']]);
    $rl=$sl->fetch(PDO::FETCH_ASSOC);
/*
    Yield
    Yield Quality
*/
    echo'<div class="row p-0 m-0">'.
      '<div class="col-12">'.
        '<div class="row">'.
          '<div class="col-12 col-sm-5 p-1">'.
            '<div class="row">'.
              '<div class="col-12 col-sm-6 pr-2">'.
                '<label for="fibre_yield'.$r['id'].'">Fibre Yield</label>'.
                '<div class="form-row">'.
                  '<input class="textinput" id="fibre_yield'.$r['id'].'" type="text" value="'.$r['fibre_yield'].'" placeholder="Fibre Yield..." onkeyup="$(`#savefibre_yield'.$r['id'].'`).addClass(`btn-danger`);">'.
                  '<div class="input-text border-top border-bottom">Kgs</div>'.
                  '<button class="save" id="savefibre_yield'.$r['id'].'" data-dbid="fibre_yield'.$r['id'].'" data-tooltip="tooltip" aria-label="Save" onclick="update(`'.$r['id'].'`,`agronomy_data`,`fibre_yield`,$(`#fibre_yield'.$r['id'].'`).val());$(`#savefibre_yield'.$r['id'].'`).removeClass(`btn-danger`);"><i class="i">save</i></button>'.
                '</div>'.
              '</div>'.
              '<div class="col-12 col-sm-6">'.
                '<label for="fibre_quality">Fibre Quality</label>'.
                '<div class="form-row">'.
                  '<select id="fibre_quality" onchange="update(`'.$r['id'].'`,`agronomy_data`,`fibre_quality`,$(this).val());">'.
                    '<option value="">None</option>'.
                    '<option value="Bad">Bad</option>'.
                    '<option value="Mediocre">Mediocre</option>'.
                  '</select>'.
                '</div>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<div class="col-12 col-sm-6 pr-2">'.
                '<label for="milk_yield">Milk Yield</label>'.
                '<div class="form-row">'.
                  '<input class="textinput" id="milk_yield" type="text" value="'.$r['milk_yield'].'" placeholder="Milk Yield..." onkeyup="$(`#savemilk_yield`).addClass(`btn-danger`);">'.
                  '<div class="input-text">Litres</div>'.
                  '<button class="save" id="savemilk_yield" data-dbid="milk_yield" data-tooltip="tooltip" aria-label="Save" onclick="update(`'.$r['id'].'`,`agronomy_data`,`milk_yield`,$(`#milk_yield`).val());$(`#savemilk_yield`).removeClass(`btn-danger`);"><i class="i">save</i></button>'.
                '</div>'.
              '</div>'.
              '<div class="col-12 col-sm-6">'.
                '<label for="milk_quality">Milk Quality</label>'.
                '<div class="form-row">'.
                  '<input class="textinput" id="milk_quality" data-dbid="'.$r['id'].'" data-dbt="agronomy_data" data-dbc="milk_quality" type="text" value="'.$r['milk_quality'].'" placeholder="Milk Quality..." onkeyup="$(`#savemilk_quality`).addClass(`btn-danger`);">'.
                  '<button class="save" id="savemilk_quality" data-dbid="milk_quality" data-tooltip="tooltip" aria-label="Save" onclick="update(`'.$r['id'].'`,`agronomy_data`,`milk_quality`,$(`#milk_quality`).val());$(`#savemilk_quality`).removeClass(`btn-danger`);"><i class="i">save</i></button>'.
                '</div>'.
              '</div>'.
            '</div>'.
          '</div>'.
          '<div class="col-12 col-sm-5 p-1">'.
            'Growth Rate Data'.
          '</div>'.
          '<div class="col-12 col-sm-2 py-1">'.
            '<div class="float-right">'.
              '<form target="sp" method="post" action="core/purge.php">'.
                '<input type="hidden" name="id" value="'.$r['id'].'">'.
                '<input type="hidden" name="t" value="agronomy_data">'.
                '<button class="purge" data-toolip="tooltip" aria-label="Delete"><i class="i">purge</i></button>'.
              '</form>'.
            '</div>'.
          '</div>'.
        '</div>'.
        ($r['notes']!=''?
          '<div class="row">'.
            '<div class="col-12 px-2 pt-1">'.
              '<label for="notes'.$r['id'].'">Notes</label>'.
              $r['notes'].
            '</div>'.
          '</div>'
        :
          '').
      '</div>'.
    '</div>';

  }
  if($o=='modal'){
    echo'</div>';
  }
