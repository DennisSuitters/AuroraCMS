<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - PayPal Order Manipulator
 * @package    core/paypaltransaction.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$ti=time();
$error='';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$name=filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW);
$email=filter_input(INPUT_POST,'email',FILTER_UNSAFE_RAW);
$txnid=filter_input(INPUT_POST,'txnid',FILTER_UNSAFE_RAW);
$paidAmount=filter_input(INPUT_POST,'amount',FILTER_SANITIZE_NUMBER_INT);
$act=filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW;
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id AND `status`!='archived'");
$s->execute([':id'=>$id]);
$payment_id=0;
$statusMsg='';
$ordStatus='error';
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
}else
  $error='<div class="alert alert-danger">Order Does NOT Exist!</div>';
if($error==''){
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
  $su->execute([':uid'=>$r['cid']]);
  if($su->rowCount()>0){
    $ru=$su->fetch(PDO::FETCH_ASSOC);
  }else
    $error='<div class="alert alert-danger">User Does NOT Exist!</div>';
}
if($error==''){
  $st=$db->prepare("UPDATE `".$prefix."orders` SET `paid_via`=:paid_via,`txn_id`=:txn_id,`paid_email`=:paid_email,`paid_name`=:paid_name,`paid_amount`=:paid_amount,`payment_status`=:payment_status,`paid_ti`=:paid_ti,`status`=:status WHERE `id`=:id");
  $st->execute([
    ':id'=>$r['id'],
    ':paid_via'=>'paypal',
    ':txn_id'=>$txnid,
    ':paid_email'=>$email,
    ':paid_name'=>$name,
    ':paid_amount'=>$paidAmount,
    ':payment_status'=>'paid',
    ':paid_ti'=>time(),
    ':status'=>'paid'
  ]);
  $payment_id=$r['id'];
  $sp=$db->prepare("SELECT `id`,`points`,`quantity` FROM `".$prefix."content` WHERE `id`=:id");
  $sp->execute([':id'=>$r['id']]);
  $points=0;
  while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
    if($rp['points']>0)$points=$points+($rp['points']*$rp['quantity']);
  }
  $sc=$db->prepare("UPDATE `".$prefix."login` SET `spent`=:spent,`points`=:points`pti`=:pti WHERE `id`=:id");
  $sc->execute([
    ':id'=>$ru['id'],
    ':spent'=>$ru['spent']+$paidAmount,
    ':points'=>$ru['points']+$points,
    ':pti'=>$ti
  ]);
  $ordStatus="success";
  $statusMsg="Your Payment has been Successfull!";
  $i=1;
  if($ru['email']!=''){
    require'phpmailer/PHPmailer.php';
    require'phpmailer/SMTP.php';
    require'phpmailer/Exception.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    $mail->isSendMail();
    $mail->SetFrom($config['email'],$config['business']);
    $mail->AddAddress($ru['email']);
    $mail->isHTML(true);
    $mail->Subject='Payment Confirmation from '.$config['business'];
    $name=explode(' ',$ru['name']);
    $msgd='';
    $msgl='';
    $msge='';
    $msgc='';
    $msg=($config['orderEmailLayout']!=''?$config['orderEmailLayout']:'<p>Hi {first},</p><p>Thank you for your payment.</p>{downloads}{links}{events}{courses}<p>You can view your invoice here: {order_link}</p><p>Kind Regards,<br />{business}</p>');
    $soi=$db->prepare("SELECT `iid` FROM `".$prefix."orderitems` WHERE `oid`=:oid");
    $soi->execute([':oid'=>$r['iid']]);
    while($roi=$soi->fetch(PDO::FETCH_ASSOC)){
      $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:id AND `contentType`='download'");
      $sd->execute([':id'=>$roi['iid']]);
      if($sd->rowCount()>0){
        while($rd=$sd->fetch(PDO::FETCH_ASSOC)){
          $msgd.='Test Link for <a href="'.URL.'downloads/'.$rd['url'].'?oc='.$r['iid'].'">'.($rd['title']!=''?$rd['title']:$rd['url']).'</a> available';
          if($rd['tie']==0)$msgd.=' forever';
          if($rd['tie']==3600)$msgd.=' for 1 Hour';
          if($rd['tie']==7200)$msgd.=' for 2 Hours';
          if($rd['tie']==14400)$msgd.=' for 4 Hours';
          if($rd['tie']==28800)$msgd.=' for 8 Hours';
          if($rd['tie']==86400)$msgd.=' for 24 Hours';
          if($rd['tie']==172800)$msgd.=' for 48 Hours';
          if($rd['tie']==604800)$msgd.=' for 1 Week';
          if($rd['tie']==1209600)$msgd.=' for 2 Weeks';
          if($rd['tie']==2592000)$msgd.=' for 1 Month';
          if($rd['tie']==7776000)$msgd.=' for 3 Months';
          if($rd['tie']==15552000)$msgd.=' for 6 Months';
          if($rd['tie']==31536000)$msgd.=' for 1 Year';
          $msgd.='<br>';
          $i++;
        }
      }
      $sl=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:id AND `contentType`='link'");
      $sl->execute([':id'=>$roi['iid']]);
      if($sl->rowCount()>0){
        while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
          $msgl.='Link for <a href="'.$rl['url'].'">'.$rl['url'].'</a> available';
          if($rl['tie']==0)$msgl.=' forever';
          if($rl['tie']==3600)$msgl.=' for 1 Hour';
          if($rl['tie']==7200)$msgl.=' for 2 Hours';
          if($rl['tie']==14400)$msgl.=' for 4 Hours';
          if($rl['tie']==28800)$msgl.=' for 8 Hours';
          if($rl['tie']==86400)$msgl.=' for 24 Hours';
          if($rl['tie']==172800)$msgl.=' for 48 Hours';
          if($rl['tie']==604800)$msgl.=' for 1 Week';
          if($rl['tie']==1209600)$msgl.=' for 2 Weeks';
          if($rl['tie']==2592000)$msgl.=' for 1 Month';
          if($rl['tie']==7776000)$msgl.=' for 3 Months';
          if($rl['tie']==15552000)$msgl.=' for 6 Months';
          if($rl['tie']==31536000)$msgl.=' for 1 Year';
          $msgl.='<br>';
          $i++;
        }
      }
      $se=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
      $se->execute([':id'=>$roi['iid']]);
      if($se->rowCount()>0){
        while($re=$se->fetch(PDO::FETCH_ASSOC)){
          if($re['contentType']=='event'){
            $msge.='Link for '.$re['title'].'<br /><a href="'.$re['exturl'].'">'.$re['title'].'</a><br />';
          }
          if($re['contentType']=='course'){
            $sct=$db->prepare("INSERT INTO `".$prefix."courseTrack` (`rid`,`uid`,`complete`,`progress`,`attempts`,`score`,`ti`) VALUES (:rid,:uid,'',0,:attempts,0,:ti)");
            $sct->execute([
              ':rid'=>$re['id'],
              ':uid'=>$ru['id'],
              ':attempts'=>$re['attempts'],
              ':ti'=>$ti
            ]);
            $msgc='<p>To access the Course/s purchased, it is required to be logged in. You can view purchased Courses via the "Courses" option in the logged in menu area.</p>';
          }
          $i++;
        }
      }
    }
    $msg=str_replace([
      '{first}',
      '{last}',
      '{name}',
      '{downloads}',
      '{links}',
      '{events}',
      '{courses}',
      '{order_link}',
      '{business}',
    ],[
      $name[0],
      $name[1],
      $ru['name'],
      ($msgd!=''?'<p>Please use the link/s below to access your downloadable purchases:<br />'.$msgd.'</p>':''),
      ($msgl!=''?'<p>Please use the link/s below to access your purchased links:<br />'.$msgl.'</p>':''),
      ($msge!=''?$msge:''),
      ($msgc!=''?$msgc:''),
      '<a href="'.URL.'orders/'.$r['iid'].'">#'.$r['iid'].'</a>',
      $config['business']
    ],$msg);
    $mail->Body=$msg;
    $mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
    if($mail->Send()){
      $msg='eventpaidlink';
    }
  }
}else
  $statusMsg="Your Payment has Failed!";
$html='';
$el='payment-info';
if($error==''){
  if($payment_id>0){
    $html.='<article class="col-12 text-center"><div class="alert alert-success">'.
      $statusMsg.
      ($msgd!=''?'<br>Download links to your purchase are within the Confirmation Email that has been sent to the email associated with your account':'').
      ($msgl!=''?'<br>Links associated with your purchase are within the Confirmation Email that has been sent to the email associated with your account':'').
      ($msge!=''?'<br>Event links to your purchase are within the Confirmation Email that has been sent to the email associated with your account':'').
      ($msgc!=''?'<br>You can access purchased Course/s via the Courses link in the logged in bar at the top of the page when logged in.</br>':'').
      '<br><br>'.
      '<a href="'.URL.'orders" class="btn-link">Back to Order Page</a>'.
    '</div>';
  }else{
    $html.='<div class="alert alert-danger">'.
      'There was an Issue Processing Your Payment!<br><br>'.
      '<a href="'.URL.'orders" class="btn-link">Back to Order Page</a>'.
    '</div>';
  }
}else{
  $el='payment-info';
  $html=$error;
}
echo'<script>window.top.window.document.getElementById("payment-info").innerHTML = `'.$html.'`;</script>';
