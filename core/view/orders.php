<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Orders
 * @package    core/view/orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.16
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.8 Add PayPal Parser.
 * @changes    v0.0.15 Fix incorrect variable $r['postageCost'] line 182
 * @changes    v0.0.15 Add GST Calculation and Template Parser.
 * @changes    v0.0.16 Reduce preg_replace parsing strings.
 */
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
if($_SESSION['loggedin']==false)$html=$theme['settings']['page_not_found'];
else{
  if(stristr($html,'<order')){
    preg_match('/<order>([\w\W]*?)<\/order>/',$html,$matches);
    $order=$matches[1];
    $html=preg_replace('~<order>.*?<\/order>~is','<order>',$html,1);
  }
  if(stristr($html,'<items')){
    preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
    $items=$matches[1];
    $output='';
    $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE uid=:uid AND status!='archived' ORDER BY ti DESC");
    $s->execute([':uid'=>$_SESSION['uid']]);
    while($r=$s->fetch(PDO::FETCH_ASSOC)){
      $item=$items;
      $item=preg_replace([
        '/<print order=[\"\']?ordernumber[\"\']?>/',
        '/<print order=[\"\']?status[\"\']?>/'
      ],[
        $r['qid'].$r['iid'],
        ucfirst($r['status'])
      ],$item);
      $item=$r['iid_ti']>0?preg_replace('/<print order=[\"\']?date[\"\']?>/',date($config['dateFormat'],$r['iid_ti']),$item):preg_replace('/<print order=[\"\']?date[\"\']?>/',date($config['dateFormat'],$r['qid_ti']),$item);
      $item=preg_replace([
        '/<print order=[\"\']?duedate[\"\']?>/',
        '/<print link>/'
      ],[
        date($config['dateFormat'],$r['due_ti']),
        URL.'orders/'.$r['qid'].$r['iid'].'/'
      ],$item);
      $output.=$item;
    }
    $html=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
  }
  if(isset($args[0])&&$args[0]!=''){
    preg_match('/<items>([\w\W]*?)<\/items>/',$order,$matches);
    $orderItem=$matches[1];
    $order=preg_replace('~<items>.*?<\/items>~is','<orderitems>',$order,1);
    $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE qid=:id OR iid=:id AND status!='archived' AND uid=:uid");
    $s->execute([
      ':id'=>$args[0],
      ':uid'=>$_SESSION['uid']
    ]);
    if($s->rowCount()>0){
      $r=$s->fetch(PDO::FETCH_ASSOC);
      $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:uid");
      $su->execute([':uid'=>$_SESSION['uid']]);
      $ru=$su->fetch(PDO::FETCH_ASSOC);
      $order=$r['iid_ti']>0?preg_replace('/<print order=[\"\']?date[\"\']?>/',date($config['dateFormat'],$r['iid_ti']),$order):preg_replace('/<print order=[\"\']?date[\"\']?>/',date($config['dateFormat'],$r['qid_ti']),$order);
      $order=preg_replace([
        '/<print order=[\"\']?notes[\"\']?>/',
        '/<print config=[\"\']?business[\"\']?>/',
        '/<print config=[\"\']?abn[\"\']?>/',
        '/<print config=[\"\']?address[\"\']?>/',
        '/<print config=[\"\']?suburb[\"\']?>/',
        '/<print config=[\"\']?city[\"\']?>/',
        '/<print config=[\"\']?state[\"\']?>/',
        '/<print config=[\"\']?postcode[\"\']?>/',
        '/<print config=[\"\']?email[\"\']?>/',
        '/<print config=[\"\']?phone[\"\']?>/',
        '/<print config=[\"\']?mobile[\"\']?>/',
        '/<print config=[\"\']?bank[\"\']?>/',
        '/<print config=[\"\']?bankAccountName[\"\']?>/',
        '/<print config=[\"\']?bankAccountNumber[\"\']?>/',
        '/<print config=[\"\']?bankBSB[\"\']?>/',
        '/<print user=[\"\']?name[\"\']?>/',
        '/<print user=[\"\']?business[\"\']?>/',
        '/<print user=[\"\']?address[\"\']?>/',
        '/<print user=[\"\']?suburb[\"\']?>/',
        '/<print user=[\"\']?city[\"\']?>/',
        '/<print user=[\"\']?state[\"\']?>/',
        '/<print user=[\"\']?postcode[\"\']?>/',
        '/<print user=[\"\']?email[\"\']?>/',
        '/<print user=[\"\']?phone[\"\']?>/',
        '/<print user=[\"\']?mobile[\"\']?>/',
        '/<print order=[\"\']?ordernumber[\"\']?>/',
        '/<print order=[\"\']?duedate[\"\']?>/',
        '/<print order=[\"\']?status[\"\']?>/'
      ],[
        rawurldecode($r['notes']),
        htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['abn'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['city'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
        $config['postcode']==0?'':htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bank'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bankAccountName'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bankAccountNumber'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bankBSB'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['name']!=''?$ru['name']:$ru['business'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['business']!=''?$ru['business']:$ru['name'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['address'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['suburb'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['city'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['state'],ENT_QUOTES,'UTF-8'),
        $ru['postcode']==0?'':htmlspecialchars($ru['postcode'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['email'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['phone'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['mobile'],ENT_QUOTES,'UTF-8'),
        $r['qid'].$r['iid'],
        date($config['dateFormat'],$r['due_ti']),
        htmlspecialchars($r['status'],ENT_QUOTES,'UTF-8'),
      ],$order);
      $ois=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid");
      $ois->execute([':oid'=>$r['id']]);
      $outitems='';
      $total=0;
      while($oir=$ois->fetch(PDO::FETCH_ASSOC)){
        $is=$db->prepare("SELECT id,code,title FROM `".$prefix."content` WHERE id=:id");
				$is->execute([':id'=>$oir['iid']]);
				$i=$is->fetch(PDO::FETCH_ASSOC);
        $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
        $sc->execute([':id'=>$oir['cid']]);
        $c=$sc->fetch(PDO::FETCH_ASSOC);
        $item=$orderItem;
        $item=preg_replace([
          '/<print orderitem=[\"\']?code[\"\']?>/',
          '/<print orderitem=[\"\']?title[\"\']?>/',
          '/<print choice>/',
          '/<print orderitem=[\"\']?quantity[\"\']?>/',
          '/<print orderitem=[\"\']?cost[\"\']?>/',
          '/<print orderitem=[\"\']?subtotal[\"\']?>/'
        ],[
          htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($c['title'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($oir['quantity'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($oir['cost'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($oir['cost']*$oir['quantity'],ENT_QUOTES,'UTF-8')
        ],$item);
        $total=$total+($oir['cost']*$oir['quantity']);
        $outitems.=$item;
      }
      $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE id=:id");
      $sr->execute([':id'=>$r['rid']]);
      if($sr->rowCount()>0){
        $reward=$sr->fetch(PDO::FETCH_ASSOC);
        if($reward['method']==1)$total=$total-$reward['value'];
        else$total=($total*((100-$reward['value'])/100));
        $total=number_format((float)$total, 2, '.', '');
        $order=preg_replace([
          '/<print rewards=[\"\']?code[\"\']?>/',
          '/<print rewards=[\"\']?method[\"\']?>/',
          '/<print rewards=[\"\']?value[\"\']?>/',
          '/<[\/]?rewards>/'
        ],[
          $reward['code'],
          $reward['method']==1?'$'.$reward['value'].' Off':$reward['value'].'% Off',
          $total,
          ''
        ],$order);
      }else$order=preg_replace('~<rewards>.*?<\/rewards>~is','',$order,1);
      if($config['gst']>0){
        $gst=$total*($config['gst']/100);
        $gst=number_format((float)$gst, 2, '.', '');
        $order=preg_replace([
          '/<print order=[\"\']?gst[\"\']?>/',
          '/<[\/]?gst>/'
        ],[
          $gst,
          ''
        ],$order);
        $total=$total+$gst;
        $total=number_format((float)$total, 2, '.', '');
      }else$order=preg_replace('~<gst>.*?<\/gst>~is','',$order,1);
      if($r['postageCost']>0){
        $order=preg_replace([
          '/<print order=[\"\']?postageOption[\"\']?>/',
          '/<print order=[\"\']?postageCost[\"\']?>/',
          '/<[\/]?postage>/'
        ],[
          $r['postageOption'],
          $r['postageCost'],
          ''
        ],$order);
        $total=$total+$r['postageCost'];
        $total=number_format((float)$total, 2, '.', '');
      }else$order=preg_replace('~<postage>.*?<\/postage>~is','',$order,1);
      $order=preg_replace([
        '/<print order=[\"\']?total[\"\']?>/',
        '/<print order=[\"\']?id[\"\']?>/',
        '~<orderitems>~is'
      ],[
        $total,
        $r['id'],
        $outitems
      ],$order);
      $html=preg_replace('~<order>~is',$order,$html,1);
      if(stristr($html,'<print paypal>')&&$r['iid']==''&&$r['status']!='paid'){
        $html=preg_replace([
          '/<print paypal>/'
        ],[
          '<div id="paypal-button-container"></div>'.
          '<script src="https://www.paypal.com/sdk/js?client-id='.$config['payPalClientID'].'&currency=AUD" data-sdk-integration-source="button-factory"></script>'.
          '<script>'.
            'paypal.Buttons({'.
              'style:{'.
                'shape:"rect",'.
                'color:"gold",'.
                'layout:"horizontal",'.
                'label:"pay",'.
              '},'.
              'createOrder:function(data,actions){'.
                'return actions.order.create({'.
                  'purchase_units:[{'.
                    'amount:{'.
                      'value:"'.$total.'"'.
                    '}'.
                  '}]'.
                '});'.
              '},'.
              'Approve: function(data, actions) {'.
                'return actions.order.capture().then(function(details) {'.
                  'alert("Transaction completed by "+details.payer.name.given_name+"!");'.
                '});'.
              '}'.
            '}).render("#paypal-button-container");'.
          '</script>',

/*          '<script src="https://www.paypal.com/sdk/js?client-id='.$config['payPalClientID'].'"></script>'.
          '<div id="paypal-button-container"></div>'.
          '<script>paypal.Buttons({'.
            'createOrder:function(data,actions){'.
              'return actions.order.create({'.
                'purchase_units:[{'.
                  'amount:{'.
                    'currency_code:`AUD`,'.
                    'value:`'.$total.'`'.
                  '}'.
                '}]'.
              '});'.
            '},'.
            'onApprove:function(data,actions){'.
              '$.ajax({'.
                'type:"POST",'.
        					'url:"core/paymenttransaction.php",'.
        					'data:{'.
        						'id:"'.$r['id'].'",'.
        						'act:"paid",'.
        					'}'.
        				'}).done(function(msg){'.
                  '$("#paymenttransaction").html(msg).removeClass("d-none").addClass("alert alert-success");'.
        				'});'.
              '},'.
              'onCancel:function(){'.
                '$.ajax({'.
                  'type:"POST",'.
                  'url:"core/paymenttransaction.php",'.
                  'data:{'.
                    'id:"'.$r['id'].'",'.
                    'act:"cancelled",'.
                  '}'.
                '}).done(function(msg){'.
                  '$("#paymenttransaction").html(msg).removeClass("d-none").addClass("alert alert-danger");'.
                '});'.
              '},'.
              'onError:function(){'.
                '$.ajax({'.
                  'type:"POST",'.
                  'url:"core/paymenttransaction.php",'.
                  'data:{'.
                    'id:"'.$r['id'].'",'.
                    'act:"error",'.
                  '}'.
                '}).done(function(msg){'.
                  '$("#paymenttransaction").html(msg).removeClass("d-none").addClass("alert alert-danger");'.
                '});'.
              '},'.
            '}).render(`#paypal-button-container`);'.
          '</script>', */
        ],$html);
      }else$html=str_replace('<print paypal>','',$html);
    }else$html=preg_replace('~<order>~is','',$html,1);
  }else$html=preg_replace('~<order>~is','',$html,1);
}
$content.=$html;
