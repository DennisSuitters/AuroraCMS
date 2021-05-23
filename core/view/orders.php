<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Orders
 * @package    core/view/orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Allow Single Order to be viewed without being logged in.
 * @changes    v0.1.2 Add Parsing for Payment Options.
 * @changes    v0.1.2 Tidy up code and reduce footprint.
 */
require'core/puconverter.php';
if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==false)$html=preg_replace('~<orderlist>.*?<\/orderlist>~is','',$html,1);
if(stristr($html,'<order>')){
  preg_match('/<order>([\w\W]*?)<\/order>/',$html,$matches);
  $order=$matches[1];
  $html=preg_replace('~<order>.*?<\/order>~is','<order>',$html,1);
}
if(stristr($html,'<items>')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $items=$matches[1];
  $output='';
  $zebra=1;
  $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `cid`=:cid AND `status`!='archived' ORDER BY `ti` DESC");
  $s->execute([':cid'=>$_SESSION['uid']]);
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $item=$items;
    $item=preg_replace([
      '/<print zebra>/',
      '/<print order=[\"\']?ordernumber[\"\']?>/',
      '/<print order=[\"\']?status[\"\']?>/',
      '/<print order=[\"\']?date[\"\']?>/',
      '/<print order=[\"\']?duedate[\"\']?>/',
      '/<print link>/'
    ],[
      'zebra'.$zebra,
      $r['qid'].$r['iid'],
      ucfirst($r['status']),
      $r['iid_ti']>0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']),
      date($config['dateFormat'],$r['due_ti']),
      URL.'orders/'.$r['qid'].$r['iid'].'/'
    ],$item);
    $output.=$item;
    $zebra=$zebra==2?$zebra=1:$zebra=2;
  }
  $html=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}
if(isset($args[0])&&$args[0]!=''){
  if(isset($_POST['act'])=='postupdate'){  // https://developers.auspost.com.au/apis/pac/tutorial/domestic-parcel
    $oid=filter_input(INPUT_POST,'oid',FILTER_SANITIZE_NUMBER_INT);
    $postoption=filter_input(INPUT_POST,'postoption',FILTER_SANITIZE_STRING);
    $sp=$db->prepare("SELECT `id`,`type`,`title`,`value` FROM `".$prefix."choices` WHERE `id`=:id");
    $sp->execute([':id'=>$postoption]);
    if($sp->rowCount()>0){$post=$sp->fetch(PDO::FETCH_ASSOC);
    }else{
      $post=[
        'id'=>$postoption,
        'type'=>'',
        'title'=>'',
        'value'=>0
      ];
    }
    if($config['austPostAPIKey']!=''&&stristr($post['type'],'AUS_')){
      $apiKey=$config['austPostAPIKey'];
      $totalWeight=$weight=$dimW=$dimL=$dimH=0;
      $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
      $su->execute([':uid'=>$_SESSION['uid']]);
      $ru=$su->fetch(PDO::FETCH_ASSOC);
      $si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:id");
      $si->execute([':id'=>$oid]);
      while($ri=$si->fetch(PDO::FETCH_ASSOC)){
        $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:sid");
        $sc->execute([':sid'=>$ri['iid']]);
        while($i=$sc->fetch(PDO::FETCH_ASSOC)){
          if($i['weightunit']!='kg')$i['weight']=weight_converter($i['weight'],$i['weightunit'],'kg');
  				$weight=$weight+($i['weight']*$ri['quantity']);
  				if($i['widthunit']!='cm')$i['width']=length_converter($i['width'],$i['widthunit'],'cm');
  				if($i['lengthunit']!='cm')$i['length']=length_converter($i['length'],$i['lengthunit'],'cm');
  				if($i['heightunit']!='cm')$i['height']=length_converter($i['height'],$i['heightunit'],'cm');
  				if($i['width']>$dimW)$dimW=$i['width'];
  				if($i['length']>$dimL)$dimL=$i['length'];
  				$dimH=$dimH+($i['height']*$ri['quantity']);
        }
      }
      $queryParams=array(
        "from_postcode"=>$config['postcode'],
        "to_postcode"=>$ru['postcode'],
        "length"=>$dimL,
        "width"=>$dimW,
        "height"=>$dimH,
        "weight"=>$weight,
        "service_code"=>$post['type']
      );
      $calculateRateURL='https://digitalapi.auspost.com.au/postage/parcel/domestic/calculate.json?' .
      http_build_query($queryParams);
      $ch=curl_init();
      curl_setopt($ch,CURLOPT_URL,$calculateRateURL);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch,CURLOPT_HTTPHEADER,array('AUTH-KEY: '.$apiKey));
      $rawBody=curl_exec($ch);
      $priceJSON=json_decode($rawBody,true);
      $post=[
        'id'=>$post['id'],
        'type'=>$post['type'],
        'title'=>$post['title'],
        'value'=>isset($priceJSON['postage_result']['total_cost'])?$priceJSON['postage_result']['total_cost']:0
      ];
    }
    $s=$db->prepare("UPDATE `".$prefix."orders` SET `postageCode`=:postageCode,`postageOption`=:postageOption,`postageCost`=:postageCost WHERE `id`=:id");
    $s->execute([
      ':postageCode'=>$post['id'],
      ':postageOption'=>$post['title'],
      ':postageCost'=>$post['value'],
      ':id'=>$oid
    ]);
  }
  preg_match('/<items>([\w\W]*?)<\/items>/',$order,$matches);
  $orderItem=$matches[1];
  $order=preg_replace('~<items>.*?<\/items>~is','<orderitems>',$order,1);
  $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`=:id OR `iid`=:id AND `status`!='archived'");
  $s->execute([':id'=>$args[0]]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
    $su->execute([':uid'=>$r['cid']]);
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
    $ois=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `ti` ASC");
    $ois->execute([':oid'=>$r['id']]);
    $outitems='';
    $total=$weight=$totalWeight=$dimW=$dimL=$dimH=0;
    $zebra=1;
    while($oir=$ois->fetch(PDO::FETCH_ASSOC)){
      $is=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
			$is->execute([':id'=>$oir['iid']]);
			$i=$is->fetch(PDO::FETCH_ASSOC);
      $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
      $sc->execute([':id'=>$oir['cid']]);
      $c=$sc->fetch(PDO::FETCH_ASSOC);
      $item=$orderItem;
      $item=preg_replace([
        '/<print zebra>/',
        '/<print orderitem=[\"\']?code[\"\']?>/',
        '/<print orderitem=[\"\']?title[\"\']?>/',
        '/<print weight>/',
        '/<print size>/',
        '/<print choice>/',
        '/<print orderitem=[\"\']?quantity[\"\']?>/',
        '/<print orderitem=[\"\']?cost[\"\']?>/',
        '/<print orderitem=[\"\']?subtotal[\"\']?>/'
      ],[
        'zebra'.$zebra,
        htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
        ($i['weight']==''?'':'<br><small class="text-muted">Weight: '.$i['weight'].$i['weightunit']),
        ($i['width']==''?'':'<br><small class="text-muted">W: '.$i['width'].$i['widthunit'].' L: '.$i['length'].$i['lengthunit'].' H: '.$i['height'].$i['heightunit'].'</small>'),
        htmlspecialchars($c['title'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($oir['quantity'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($oir['cost'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($oir['cost']*$oir['quantity'],ENT_QUOTES,'UTF-8')
      ],$item);
      $total=$total+($oir['cost']*$oir['quantity']);
      if($i['weightunit']!='kg')$i['weight']=weight_converter($i['weight'],$i['weightunit'],'kg');
			$weight=(int)$weight+((int)$i['weight']*(int)$oir['quantity']);
			if($i['widthunit']!='cm')$i['width']=length_converter($i['width'],$i['widthunit'],'cm');
			if($i['lengthunit']!='cm')$i['length']=length_converter($i['length'],$i['lengthunit'],'cm');
			if($i['heightunit']!='cm')$i['height']=length_converter($i['height'],$i['heightunit'],'cm');
			if($i['width']>$dimW)$dimW=$i['width'];
			if($i['length']>$dimL)$dimL=$i['length'];
			$dimH=(int)$dimH+((int)$i['height']*(int)$oir['quantity']);
      $outitems.=$item;
      $zebra=$zebra==2?$zebra=1:$zebra=2;
    }
    $order=preg_replace([
      '/<print dimensions>/',
      '/<print weight>/'
    ],[
      'W: '.$dimW.'cm X L: '.$dimL.'cm X H: '.$dimH.'cm',
      $weight.'kg'.($weight>22?'<br><div class="alert alert-danger">As the weight of your items exceeds 22kg you will not be able to use Australia Post.</div>':'')
    ],$order);
    $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:id");
    $sr->execute([':id'=>$r['rid']]);
    if($sr->rowCount()>0){
      $reward=$sr->fetch(PDO::FETCH_ASSOC);
      $total=$reward['method']==1?$total-$reward['value']:($total*((100-$reward['value'])/100));
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
    }else{
      $order=preg_replace([
        '/<print order=[\"\']?gst[\"\']?>/',
        '/<[\/]?gst>/'
      ],[
        'Incl',
        ''
      ],$order);
    }
    if($ru['spent']>0&&$config['options'][26]==1){
      if(stristr($order,'<discountRange>')){
        $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
        $sd->execute([
          ':f'=>$ru['spent'],
          ':t'=>$ru['spent']
        ]);
        if($sd->rowCount()>0){
          $rd=$sd->fetch(PDO::FETCH_ASSOC);
          $total=$rd['total']==2?$total*($rd['cost']/100):$total-$rd['cost'];
          $total=number_format((float)$total, 2, '.', '');
          $order=preg_replace([
            '/<[\/]?discountRange>/',
            '/<print discount=[\"\']?method[\"\']?>/',
            '/<print discount=[\"\']?total[\"\']?>/'
          ],[
            '',
            'Spent Discount '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost']).' Off',
            $total
          ],$order);
        }else$order=preg_replace('~<discountRange>.*?<\/discountRange>~is','',$order);
      }else$order=preg_replace('~<discountRange>.*?<\/discountRange>~is','',$order);
    }else$order=preg_replace('~<discountRange>.*?<\/discountRange>~is','',$order);
    $option='<option value="0">'.($r['postageCode']==0?($r['postageOption']!=''?$r['postageOption']:'Nothing Selected'):'Nothing Selected').'</option>';
    $sco=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' ORDER BY `title` ASC");
    $sco->execute();
    if($sco->rowCount()>0){
      while($rco=$sco->fetch(PDO::FETCH_ASSOC))$option.='<option value="'.$rco['id'].'"'.($r['postageCode']==$rco['id']?' selected':'').'>'.$rco['title'].'</option>';
    }
    $order=preg_replace([
      '/<print orderurl>/',
      '/<print order=[\"\']?oid[\"\']?>/',
      '/<postoptions>/',
      '/<print order=[\"\']?post[\"\']?>/'
    ],[
      URL.'orders/'.$r['qid'].$r['iid'].'/',
      $r['id'],
      $option,
      $r['postageCost']
    ],$order);
    $total=$total+$r['postageCost'];
    $total=number_format((float)$total, 2, '.', '');
    $order=preg_replace([
      '/<print order=[\"\']?total[\"\']?>/',
      '/<print order=[\"\']?id[\"\']?>/',
      '~<orderitems>~is'
    ],[
      $total,
      $r['id'],
      $outitems
    ],$order);
    if(stristr($order,'<orderDeduction>')){
      preg_match('/<orderDeduction>([\w\W]*?)<\/orderDeduction>/',$order,$matches);
      $deductionHTML=$matches[1];
      preg_match('/<deductionItems>([\w\W]*?)<\/deductionItems>/',$order,$matches);
      $deductionItem=$matches[1];
      $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid AND status='neg' ORDER BY ti ASC");
      $sn->execute([':oid'=>$r['id']]);
      $deductionItems=$deductionHTML='';
      if($sn->rowCount()>0){
    	   while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
	        $item=$deductionItem;
          $item=preg_replace([
            '/<print deduction=[\"\']?title[\"\']?>/',
            '/<print deduction=[\"\']?date[\"\']?>/',
            '/<print deduction=[\"\']?cost[\"\']?>/'
          ],[
            $rn['title'],
            date($config['dateFormat'],$rn['ti']),
            $rn['cost']
          ],$item);
          $deductionItems.=$item;
    		  $total=$total-$rn['cost'];
        }
  		  $total=number_format((float)$total,2,'.','');
        $deductionHTML=preg_replace([
          '~<deductionItems>.*?<\/deductionItems>~is',
          '/<print deduction=[\"\']?total[\"\']?>/'
        ],[
          $deductionItems,
          $total
        ],$deductionHTML);
      }
      $order=preg_replace('~<orderDeduction>.*?<\/orderDeduction>~is',$deductionHTML,$order);
    }
    $html=preg_replace('~<order>~is',$order,$html,1);
    $html=preg_replace([
      '/<print paypal>/'
    ],[
      (stristr($html,'<print paypal>')&&$r['status']!='paid'?
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
        '</script>':
      ''),
    ],$html);
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
  }else$html=preg_replace('~<order>~is','',$html,1);
}else$html=preg_replace('~<order>~is','',$html,1);
$content.=$html;
