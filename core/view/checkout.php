<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Checkout
 * @package    core/view/checkout.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/puconverter.php';
require'core/phpmailer/PHPMailer.php';
require'core/phpmailer/SMTP.php';
require'core/phpmailer/Exception.php';
$html=preg_replace([
  '/<print page=[\"\']?heading[\"\']?>/',
  '/<print page=[\"\']?notes[\"\']?>/',
  $page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is'
],[
  htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
  $page['notes'],
  ''
],$html);
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`=:id AND `status`!='archived' AND `status`!='paid'");
$s->execute([':id'=>$args[0]]);
$r=$s->fetch(PDO::FETCH_ASSOC);
if($s->rowCount()==1){
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
  $su->execute([':uid'=>$r['cid']]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);
  if($r['total']==0){
    $st=$db->prepare("UPDATE `".$prefix."orders` SET `iid`=:iid,`iid_ti`=:iid_ti,`qid`='',`qid_ti`='0',`paid_via`=:paid_via,`txn_id`=:txn_id,`paid_email`=:paid_email,`paid_name`=:paid_name,`paid_amount`=:paid_amount,`payment_status`=:payment_status,`paid_ti`=:paid_ti,`status`=:status WHERE `id`=:id");
    $r['iid']='I'.date("ymd",$ti).sprintf("%06d",$r['id'],6);
    $st->execute([
      ':id'=>$r['id'],
      ':iid'=>$r['iid'],
      ':iid_ti'=>$ti,
      ':paid_via'=>'',
      ':txn_id'=>'',
      ':paid_email'=>'',
      ':paid_name'=>'',
      ':paid_amount'=>'',
      ':payment_status'=>'paid',
      ':paid_ti'=>time(),
      ':status'=>'paid'
    ]);
    $payment_id=$r['id'];
    $sp=$db->prepare("SELECT `id`,`points`,`quantity` FROM `".$prefix."content` WHERE `id`=:id");
    $sp->execute([':id'=>$r['id']]);
    $points=0;
    while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
      if($rp['points']>0)
        $points=$points+($rp['points']*$rp['quantity']);
    }
    $sc=$db->prepare("UPDATE `".$prefix."login` SET `spent`=:spent,`points`=:points,`pti`=:pti WHERE `id`=:id");
    $sc->execute([
      ':id'=>$ru['id'],
      ':spent'=>$ru['spent'],
      ':points'=>$ru['points']+$points,
      ':pti'=>$ti
    ]);
    $ordStatus="success";
    $statusMsg="Your Payment has been Successful!";
    $i=1;
    if($ru['email']!=''){
      $mail = new PHPMailer\PHPMailer\PHPMailer;
      $mail->isSendMail();
      $mail->SetFrom($config['email'],$config['business']);
      $mail->AddAddress($ru['email']);
      $mail->isHTML(true);
      $mail->Subject='Payment Confirmation from '.$config['business'];
      $name=explode(' ',$ru['name']);
      $msgd=$msgl=$msge=$msgc='';
      $msg=($config['orderEmailLayout']!=''?$config['orderEmailLayout']:'<p>Hi {first},</p><p>Thank you for your payment.</p>{downloads}{links}{events}{courses}<p>You can view your invoice here: {order_link}</p><p>Kind Regards,<br />{business}</p>');
      $soi=$db->prepare("SELECT `iid` FROM `".$prefix."orderitems` WHERE `oid`=:oid");
      $soi->execute([':oid'=>$r['id']]);
      while($roi=$soi->fetch(PDO::FETCH_ASSOC)){
        $sd=$db->prepare("SELECT `contentType`,`title`,`url`,`tie` FROM `".$prefix."choices` WHERE `contentType`='download' AND `rid`=:id");
        $sd->execute([':id'=>$roi['iid']]);
        if($sd->rowCount()>0){
          while($rd=$sd->fetch(PDO::FETCH_ASSOC)){
            $msgd.='Link for <a href="'.URL.'downloads/'.$rd['url'].'?oc='.$r['iid'].'">'.($rd['title']!=''?$rd['title']:$rd['url']).'</a> available';
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
        $sl=$db->prepare("SELECT `contentType`,`title`,`url`,`tie` FROM `".$prefix."choices` WHERE `contentType`='link' AND `rid`=:id");
        $sl->execute([':id'=>$roi['iid']]);
        if($sl->rowCount()>0){
          while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
            $msgl.='Link for <a href="'.$rl['url'].'">'.($rl['title']!=''?$rl['title']:$rl['url']).'</a> available';
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
              $msgc='<p>To access the Course/s purchased, it is required to be logged in. You can view purchased Courses via the "Courses" in the logged in menu area.</p>';
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
    $html=preg_replace([
      '/<print checkout=[\"\']?orderid[\"\']?>/',
      '/<error>/',
      '~<paypal>.*?</paypal>~is',
      '~<direct>.*?</direct>~is',
      '~<stripe>.*?</stripe>~is',
    ],[
      $r['iid'],
      '<div class="alert alert-success">Order #'.$r['iid'].' has a total cost of &dollar;0.00, has been converted to an invoice, with a confirmation email sent for access to purchased content!</div>',
      '',
      '',
      ''
    ],$html);
  }else{
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
      $config['options'][16]==1?'/<[\/]?afterpay>/':'~<afterpay>.*?</afterpay>~is',
      $config['stripe_publishkey']==''?'~<stripe>.*?</stripe>~is':'/<[\/]?stripe>/',
      '/<print checkout=[\"\']?total[\"\']?>/',
      '/<print order=[\"\']?id[\"\']?>/',
      '/<print checkout=[\"\']?orderid[\"\']?>/',
      '/<print stripe=[\"\']?publishkey[\"\']?>/',
    ],[
      '',
      '',
      htmlspecialchars($config['bank'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['bankAccountName'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['bankAccountNumber'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['bankBSB'],ENT_QUOTES,'UTF-8'),
      '',
      $config['payPalClientID'],
      URL,
      '',
      '',
      $r['total'],
      $r['id'],
      $r['qid'].$r['iid'],
      $config['stripe_publishkey'],
    ],$html);
  }
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
