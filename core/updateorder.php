<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update Order
 * @package    core/updateorder.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
require'puconverter.php';
define('THEME','layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'act',FILTER_UNSAFE_RAW);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'c',FILTER_UNSAFE_RAW);
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
$ti=time();
if($act=='removeItems'){
  $items=explode(',',$da);
  foreach($items as $item => $value){
    $q=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE `id`=:id");
    $q->execute([':id'=>$value]);
  }
  echo'<script>window.top.window.$("#action").val("0");</script>';
}
if($act=='newQuote'){
  $items=explode(',',$da);
  $sg=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
  $sg->execute([':id'=>$id]);
  $rg=$sg->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`cid`,`uid`,`iid`,`iid_ti`,`due_ti`,`notes`,`status`,`postageCode`,`postageOption`,`postageCost`,`payOption`,`payMethod`,`payCost`,`recurring`) VALUES (:cid,:uid,:iid,:iid_ti,:due_ti,:notes,:status,:postageCode,:postageOption,:postageCost,:payOption,:payMethod,:payCost,:recurring)");
  $s->execute([
    ':cid'=>$rg['cid'],
    ':uid'=>$rg['uid'],
    ':iid'=>'',
    ':iid_ti'=>0,
    ':due_ti'=>$ti + $config['orderPayti'],
    ':notes'=>$rg['notes'],
    ':status'=>$rg['status'],
    ':postageCode'=>$rg['postageCode'],
    ':postageOption'=>$rg['postageOption'],
    ':postageCost'=>$rg['postageCost'],
    ':payOption'=>$rg['payOption'],
    ':payMethod'=>$rg['payMethod'],
    ':payCost'=>$rg['payCost'],
    ':recurring'=>$rg['recurring']
  ]);
  $iid=$db->lastInsertId();
  $qid='Q'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
  $qid_ti=$ti+$config['orderPayti'];
  $q=$db->prepare("UPDATE `".$prefix."orders` SET `qid`=:qid,`qid_ti`=:qid_ti WHERE `id`=:id");
  $q->execute([
    ':id'=>$iid,
    ':qid'=>$qid,
    ':qid_ti'=>$ti
  ]);
  foreach($items as $item => $value){
    $q=$db->prepare("UPDATE `".$prefix."orderitems` SET `oid`=:oiid WHERE `id`=:id ");
    $q->execute([
      ':id'=>$value,
      ':oiid'=>$iid
    ]);
  }
  echo'<script>'.
    'window.top.window.$("#action").val("0");'.
    'window.top.window.toastr["success"]("New Quote '.$qid.' created!");'.
  '</script>';
}
if($act=='newInvoice'){
  $items=explode(',',$da);
  $sg=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
  $sg->execute([':id'=>$id]);
  $rg=$sg->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`cid`,`uid`,`qid`,`qid_ti`,`due_ti`,`notes`,`status`,`postageCode`,`postageOption`,`postageCost`,`payOption`,`payMethod`,`payCost`,`recurring`) VALUES (:cid,:uid,:qid,:qid_ti,:due_ti,:notes,:status,:postageCode,:postageOption,:postageCost,:payOption,:payMethod,:payCost,:recurring)");
  $s->execute([
    ':cid'=>$rg['cid'],
    ':uid'=>$rg['uid'],
    ':qid'=>'',
    ':qid_ti'=>0,
    ':due_ti'=>$ti + $config['orderPayti'],
    ':notes'=>$rg['notes'],
    ':status'=>$rg['status'],
    ':postageCode'=>$rg['postageCode'],
    ':postageOption'=>$rg['postageOption'],
    ':postageCost'=>$rg['postageCost'],
    ':payOption'=>$rg['payOption'],
    ':payMethod'=>$rg['payMethod'],
    ':payCost'=>$rg['payCost'],
    ':recurring'=>$rg['recurring']
  ]);
  $iid=$db->lastInsertId();
  $oid='I'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
  $oid_ti=$ti+$config['orderPayti'];
  $q=$db->prepare("UPDATE `".$prefix."orders` SET `iid`=:iid,`iid_ti`=:iid_ti WHERE `id`=:id");
  $q->execute([
    ':id'=>$iid,
    ':iid'=>$oid,
    ':iid_ti'=>$ti
  ]);
  foreach($items as $item => $value){
    $q=$db->prepare("UPDATE `".$prefix."orderitems` SET `oid`=:oiid WHERE `id`=:id ");
    $q->execute([
      ':id'=>$value,
      ':oiid'=>$iid
    ]);
  }
  echo'<script>'.
    'window.top.window.$("#action").val("0");'.
    'window.top.window.toastr["success"]("Invoice '.$oid.' Created!");'.
  '</script>';
}
if($act=='statusAvailable'){
  $items=explode(',', $da);
  foreach($items as $item => $value){
    $q=$db->prepare("UPDATE `".$prefix."orderitems` SET `status`='' WHERE `id`=:id");
    $q->execute([':id'=>$value]);
  }
  echo'<script>window.top.window.$("#action").val("0");</script>';
}
if($act=='statusPreorder'){
  $items=explode(',', $da);
  foreach($items as $item => $value){
    $q=$db->prepare("UPDATE `".$prefix."orderitems` SET `status`='pre order' WHERE `id`=:id");
    $q->execute([':id'=>$value]);
  }
  echo'<script>window.top.window.$("#action").val("0");</script>';
}
if($act=='statusBackorder'){
  $items=explode(',', $da);
  foreach($items as $item => $value){
    $q=$db->prepare("UPDATE `".$prefix."orderitems` SET `status`='back order' WHERE `id`=:id");
    $q->execute([':id'=>$value]);
  }
  echo'<script>window.top.window.$("#action").val("0");</script>';
}
if($act=='additem'){
	if(is_numeric($da)&&$da!=0){
    $so=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
    $so->execute([':id'=>$id]);
    $ro=$so->fetch(PDO::FETCH_ASSOC);
		$sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
		$sc->execute([':id'=>$da]);
		$rc=$sc->fetch(PDO::FETCH_ASSOC);
    $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
    $su->execute([':id'=>$ro['uid']]);
    $ru=$su->fetch(PDO::FETCH_ASSOC);
    if($rc['cost']=='')$rc['cost']=0;
    if($rc['rCost']!=0)$rc['cost']=$rc['rCost'];
    if($rc['dCost']!=0){
      if($ru['options'][19]==1)$rc['cost']=$rc['dCost'];
    }
    if($ro['iid_ti']!=0&&$rc['contentType']=='inventory'){
      $rc['quantity']=$rc['quantity'] - 1;
      if($rc['quantity']<1){
        $rc['quantity']=0;
        $rc['stockStatus']=$config['inventoryFallbackStatus'];
      }
      $q=$db->prepare("UPDATE `".$prefix."content` SET `quantity`=:quantity,`stockStatus`=:sS WHERE `id`=:id");
      $q->execute([
        ':id'=>$rc['id'],
        ':quantity'=>$rc['quantity'],
        ':sS'=>$rc['stockStatus']
      ]);
    }
	}elseif($da=='neg'){
		$rc=[
			'title'=>'',
			'cost'=>0,
			'stockStatus'=>'neg'
		];
	}else{
    $rc=[
      'title'=>'',
      'cost'=>0,
			'stockStatus'=>''
    ];
  }
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,:iid,:title,'1',:cost,:status,:ti)");
	$q->execute([
    ':oid'=>$id,
    ':iid'=>$da,
    ':title'=>$rc['title'],
    ':cost'=>$rc['cost'],
		':status'=>$rc['stockStatus'],
    ':ti'=>time()
  ]);
}
if($act=='addrate'){
  if(is_numeric($da)&&$da!=0){
    $su=$db->prepare("SELECT `id`,`username`,`name`,`rate` FROM `".$prefix."login` WHERE `id`=:id");
    $su->execute([':id'=>$da]);
    $ru=$su->fetch(PDO::FETCH_ASSOC);
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`contentType`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,'rate',:title,1,:cost,'in stock',:ti)");
    $q->execute([
      ':oid'=>$id,
      ':title'=>'Labour ('.($ru['name']!=''?$ru['name']:$ru['username']).').',
      ':cost'=>$ru['rate'],
      ':ti'=>$ti
    ]);
  }
}
if($act=='addoption'){
  if($da!=0){
    $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
    $sc->execute([':id'=>$da]);
    $rc=$sc->fetch(PDO::FETCH_ASSOC);
    if($rc['quantity']=='')$rc['quantity']=0;
    if($rc['rid']>0){
      $so=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
      $so->execute([':id'=>$id]);
      $ro=$so->fetch(PDO::FETCH_ASSOC);
      $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
      $su->execute([':id'=>$ro['uid']]);
      $ru=$su->fetch(PDO::FETCH_ASSOC);
      $si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
      $si->execute([':id'=>$rc['rid']]);
      $ri=$si->fetch(PDO::FETCH_ASSOC);
      if($rc['cost']==0)$rc['cost']=0;
      if($rc['cost']==0){
        if($ri['rCost']!=0)$rc['cost']=$ri['rCost'];
        if($ri['dCost']!=0){
          if($ru['options'][19]==1)$rc['cost']=$ri['dCost'];
        }
      }
      if($rc['quantity']==0){
        $ri['quantity']=$ri['quantity'] - 1;
        if($ri['quantity']<1){
          $ri['quantity']=0;
          $ri['stockStatus']=$config['inventoryFallbackStatus'];
        }
        $q=$db->prepare("UPDATE `".$prefix."content` SET `quantity`=:quantity,`stockStatus`=:stockStatus WHERE `id`=:id");
        $q->execute([
          ':id'=>$ro['id'],
          ':quantity'=>$ri['quantity'],
          ':stockStatus'=>$ri['stockStatus']
        ]);
        $rc['quantity']=$ri['quantity'];
      }
      $q=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,:iid,:title,'1',:cost,:status,:ti)");
      $q->execute([
        ':oid'=>$id,
        ':iid'=>$da,
        ':title'=>$rc['title'],
        ':cost'=>$rc['cost'],
        ':status'=>$ri['stockStatus'],
        ':ti'=>time()
      ]);
    }else{
      if($rc['quantity']>0){
        $rc['quantity']=$rc['quantity'] - 1;
        if($rc['quantity']<1){
          $rc['quantity']=0;
        }
      }
      $q=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,:iid,:title,'1',:cost,:status,:ti)");
      $q->execute([
        ':oid'=>$id,
        ':iid'=>$da,
        ':title'=>$rc['title'],
        ':cost'=>$rc['cost'],
        ':status'=>$rc['status'],
        ':ti'=>time()
      ]);
      if($rc['quantity']>0){
        $rc['quantity']=$rc['quantity'] - 1;
        if($rc['quantity']<0){
          $rc['quantity']=0;
          $rc['status']='unavailable';
        }
      }
      $q=$db->prepare("UPDATE `".$prefix."choices` SET `quantity`=:quantity,`status`=:status WHERE `id`=:id");
      $q->execute([
        ':id'=>$da,
        ':quantity'=>$rc['quantity'],
        ':status'=>$rc['status']
      ]);
    }
  }
}
if($act=='title'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `id`=:id");
  $ss->execute([':id'=>$id]);
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orderitems` SET `title`=:title WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':title'=>$da
  ]);
  $id=$r['oid'];
}
if($act=='quantity'||$act=='trash'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `id`=:id");
  $ss->execute([':id'=>$id]);
  $rs=$ss->fetch(PDO::FETCH_ASSOC);
  if($da==0){
    $s=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE `id`=:id");
    $s->execute([':id'=>$id]);
  }else{
    $s=$db->prepare("UPDATE `".$prefix."orderitems` SET `quantity`=:quantity WHERE `id`=:id");
    $s->execute([
      ':quantity'=>$da,
      ':id'=>$id
    ]);
  }
  $id=$rs['oid'];
}
if($act=='cost'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `id`=:id");
  $ss->execute([':id'=>$id]);
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orderitems` SET `cost`=:cost WHERE `id`=:id");
  $s->execute([
    ':cost'=>$da,
    ':id'=>$id
  ]);
  $id=$r['oid'];
}
if($act=='reward'){
	if($da=='')$reward['id']=0;
	else{
  	$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `code`=:code");
  	$sr->execute([':code'=>$da]);
  	$reward=$sr->fetch(PDO::FETCH_ASSOC);
	}
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `rid`=:rid WHERE `id`=:id");
  $s->execute([
    ':rid'=>$reward['id'],
    ':id'=>$id
  ]);
}
if($act=='postselect'){
	if($da!=0){
		$rc=[
			'id'=>0,
			'type'=>$da,
			'title'=>'',
			'value'=>0
		];
	}elseif(is_numeric($da)){
		$sc=$db->prepare("SELECT `id`,`type`,`title`,`value` FROM `".$prefix."choices` WHERE `contentType`='postoption' AND `id`=:id");
		$sc->execute([':id'=>$da]);
		$rc=$sc->fetch(PDO::FETCH_ASSOC);
	}
	if($config['austPostAPIKey']!=''&&($rc['type']=='AUS_PARCEL_REGULAR'||$rc['type']=='AUS_PARCEL_EXPRESS')){
		$apiKey=$config['austPostAPIKey'];
		$totalweight=$weight=$dimW=$dimL=$dimH=0;
		$os=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
		$os->execute([':id'=>$id]);
		$oir=$os->fetch(PDO::FETCH_ASSOC);
		$si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:id");
		$si->execute([':id'=>$id]);
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
			"service_code"=>$rc['type']
		);
		$calculateRateURL='https://digitalapi.auspost.com.au/postage/parcel/domestic/calculate.json?' .
		http_build_query($queryParams);
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$calculateRateURL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('AUTH-KEY: '.$apiKey));
		$rawBody=curl_exec($ch);
		if($rawBody!=''){
			$priceJSON=json_decode($rawBody,true);
			$rc=[
				'id'=>$rc['id'],
				'type'=>$rc['type'],
				'title'=>$rc['title'],
				'value'=>isset($priceJSON['postage_result']['total_cost'])?$priceJSON['postage_result']['total_cost']:0
			];
		}else{
			$rc=[
				'id'=>$rc['id'],
				'type'=>$rc['type'],
				'title'=>'An Error Ocurred!',
				'value'=>0
			];
		}
	}
	$s=$db->prepare("UPDATE `".$prefix."orders` SET `postageCode`=:postageCode,`postageOption`=:postageOption,`postageCost`=:postagCost WHERE `id`=:id");
	$s->execute([
		':id'=>$id,
		':postageCode'=>isset($r['id'])?$rc['id']:'',
		':postageOption'=>isset($rc['title'])?$rc['title']:'',
		':postagCost'=>isset($rc['value'])&&$rc['value']>0?$rc['value']:0
	]);
}
if($act=='postoption'){
	$s=$db->prepare("UPDATE `".$prefix."orders` SET `postageCode`=:postageCode,`postageOption`=:postageOption WHERE `id`=:id");
	$s->execute([
		':postageCode'=>0,
		':postageOption'=>$da,
		':id'=>$id
	]);
}
if($act=='postcost'){
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `postageCode`=:postageCode,`postageCost`=:postageCost WHERE `id`=:id");
  $s->execute([
		':postageCode'=>0,
    ':postageCost'=>$da,
    ':id'=>$id
  ]);
}
if($act=='payselect'){
  if($da==0){
    $rp=[
      'id'=>0,
      'title'=>'Empty',
      'type'=>1,
      'value'=>0
    ];
  }else{
    $sp=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='payoption' AND `id`=:id");
    $sp->execute([':id'=>$da]);
    if($sp->rowCount()>0)$rp=$sp->fetch(PDO::FETCH_ASSOC);
  }
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `payOption`=:payO,`payMethod`=:payM,`payCost`=:payC WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':payO'=>$rp['title'],
    ':payM'=>$rp['type'],
    ':payC'=>$rp['value']
  ]);
}
if($act=='paytext'){
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `payOption`=:payO WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':payO'=>$da
  ]);
}
if($act=='paymethod'){
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `payMethod`=:payM WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':payM'=>$da
  ]);
}
if($act=='paycost'){
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `payCost`=:payC WHERE `id`=:id");
  $s->execute([
    ':id'=>$id,
    ':payC'=>$da
  ]);
}
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `status` ASC, `ti` ASC,`title` ASC");
$si->execute([':oid'=>$r['id']]);
$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
$su->execute([':uid'=>$r['cid']]);
$user=$su->fetch(PDO::FETCH_ASSOC);
$total=0;
$html='';
while($oi=$si->fetch(PDO::FETCH_ASSOC)){
  $is=$db->prepare("SELECT `id`,`thumb`,`file`,`fileURL`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
  $is->execute([':id'=>$oi['iid']]);
  $i=$is->fetch(PDO::FETCH_ASSOC);
  $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
  $sc->execute([':id'=>$oi['cid']]);
  $c=$sc->fetch(PDO::FETCH_ASSOC);
  $html.='<tr class="'.($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?'bg-warning':'').'">'.
    '<td class="align-top d-table-cell pt-3"><input type="checkbox" class="orderitems" name="item" value="'.$oi['id'].'"></td>'.
    '<td class="text-left align-top d-table-cell small pt-3 px-0">'.$i['code'].'</td>'.
    '<td class="text-left align-top d-table-cell px-0">'.
      ($r['iid_ti']!=0?
        ($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?
          ucwords($oi['status']).': '
        :
          '').
        $oi['title']
      :
        '<form target="sp" method="post" action="core/updateorder.php">'.
          '<input name="act" type="hidden" value="title">'.
          '<input name="id" type="hidden" value="'.$oi['id'].'">'.
          '<input name="t" type="hidden" value="orderitems">'.
          '<input name="c" type="hidden" value="title">'.
          '<input name="da" type="text" value="'.($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?ucwords($oi['status']).': ':'').$oi['title'].'">'.
        '</form>'
      );
      $scq=$db->prepare("SELECT * FROM `".$prefix."orderQuestions` WHERE `rid`=:rid ORDER BY `ti` ASC");
      $scq->execute([':rid'=>$oi['id']]);
      if($scq->rowCount()>0){
        while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
          $html.='<div class="small">'.
            '<strong>'.$rcq['question'].'</strong>'.
            ' '.$rcq['answer'].
          '</div>';
        }
      }
    $html.='</td>'.
    '<td class="text-left align-top d-table-cell pt-3 px-0">'.(isset($c['title'])?$c['title']:'').'</td>'.
    '<td class="text-center align-top d-table-cell px-0">'.
      '<form target="sp" method="post" action="core/updateorder.php">'.
        '<input name="act" type="hidden" value="quantity">'.
        '<input name="id" type="hidden" value="'.$oi['id'].'">'.
        '<input name="t" type="hidden" value="orderitems">'.
        '<input name="c" type="hidden" value="quantity">'.
        '<input name="da" class="text-center" value="'.($oi['contentType']=='rate'?rtrim(rtrim($oi['quantity'],0),'.'):round($oi['quantity'])).'"'.($r['status']=='archived'?' readonly':'').'>'.
      '</form>'.
    '</td>'.
    '<td class="text-right align-top d-table-cell px-0">'.
      ($oi['iid_ti']!=0?
        ($oi['iid']!=0?
          $oi['cost']
        :
          '')
      :
        '<form target="sp" method="post" action="core/updateorder.php">'.
          '<input name="act" type="hidden" value="cost">'.
          '<input name="id" type="hidden" value="'.$oi['id'].'">'.
          '<input name="t" type="hidden" value="orderitems">'.
          '<input name="c" type="hidden" value="cost">'.
          '<input class="text-center" style="min-width:80px" name="da" value="'.$oi['cost'].'"'.($r['status']=='archived'?' readonly':'').'>'.
        '</form>'
      ).
    '</td>'.
    '<td class="text-right align-top d-table-cell pt-3 px-0">&nbsp;';
      $gst=0;
      if($oi['status']!='pre-order'){
        if($config['gst']>0){
          $gst=$oi['cost']*($config['gst']/100);
          if($oi['quantity']>1)$gst=$gst*$oi['quantity'];
          $gst=number_format((float)$gst,2,'.','');
        }
        $html.=$gst>0?$gst:'';
      }
    $html.='</td>';
    if($oi['contentType']=='rate'){
      $total=$total+($oi['cost']*$oi['quantity'])+$gst;
      $total=number_format((float)$total,2,'.','');
    }
    $html.='<td class="text-right align-top d-table-cell pt-3 px-0">';
      if($oi['status']!='pre-order'){
        $html.=number_format((float)$oi['cost']*$oi['quantity']+$gst,2,'.','');
      }else{
        $html.='<small>Pre-Order</small>';
      }
    $html.='</td>'.
    '<td class="align-top d-table-cell text-right px-0">'.
      '<form target="sp" method="post" action="core/updateorder.php">'.
        '<input name="act" type="hidden" value="trash">'.
        '<input name="id" type="hidden" value="'.$oi['id'].'">'.
        '<input name="t" type="hidden" value="orderitems">'.
        '<input name="c" type="hidden" value="quantity">'.
        '<input name="da" type="hidden" value="0">'.
        '<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
      '</form>'.
    '</td>'.
  '</tr>';
  if($oi['status']!='pre order'||$oi['status']!='back order'){
    if($oi['iid']!=0){
      $total=$total+($oi['cost']*$oi['quantity'])+$gst;
      $total=number_format((float)$total,2,'.','');
    }
  }
}
$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
$sr->execute([':rid'=>$r['rid']]);
$reward=$sr->fetch(PDO::FETCH_ASSOC);
$html.='<tr>'.
  '<td colspan="2" class="text-right align-middle d-table-cell px-0"><div class="input-text">Rewards</div></td>'.
  '<form id="rewardsinput" class="form-row" target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
    '<td colspan="1" class="text-center px-0">'.
      '<input name="act" type="hidden" value="reward">'.
      '<input name="id" type="hidden" value="'.$r['id'].'">'.
      '<input name="t" type="hidden" value="orders">'.
      '<input name="c" type="hidden" value="rid">';
      $ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `code` ASC,`title` ASC");
      $ssr->execute();
      if($ssr->rowCount()>0){
        $html.='<select onchange="$(\'#rewardselect\').val($(this).val())">'.
          '<option value="">Rewards Codes</option>';
          while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){
            $html.='<option value="'.$srr['code'].'"'.($srr['code']==$reward['code']?' selected="selected"':'').'>'.$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off'.'</option>';
          }
        $html.='</select>';
      }
    $html.='</td>'.
    '<td class="align-middle d-table-cell px-0" colspan="3">'.
      '<input id="rewardselect" name="da" type="text" value="'.($ssr->rowCount()==1?$reward['code']:'').'" onchange="$(\'#rewardsinput:first\').submit();">'.
    '</td>'.
  '</form>'.
'</td>'.
'<td class="text-center align-middle px-0">';
  if($sr->rowCount()==1){
    if($reward['method']==1){
      $html.='&dollar;';
      $total=$total-$reward['value'];
    }
    $html.=$reward['value'];
    if($reward['method']==0){
      $html.='%';
      $total=($total*((100-$reward['value'])/100));
    }
    $total=number_format((float)$total,2,'.','');
    $html.=' Off';
  }
  $html.='</td>'.
  '<td class="text-right align-middle d-table-cell px-0">'.(isset($reward['value'])&&$reward['value']>0?$total:'').'</td>'.
  '<td>&nbsp;</td>'.
'</tr>';

if($config['options'][26]==1){
  $dedtot=0;
  $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
  $sd->execute([
    ':f'=>$user['spent'],
    ':t'=>$user['spent']
  ]);
  if($sd->rowCount()>0){
    $rd=$sd->fetch(PDO::FETCH_ASSOC);
    if($rd['value']==1)$dedtot=$rd['cost'];
    if($rd['value']==2)$dedtot=$total*($rd['cost']/100);
    $total=$total - $dedtot;
    $html.='<tr>'.
      '<td class="align-middle d-table-cell text-right px-0" colspan="2"><div class="input-text">Spent</div></td>'.
      '<td class="align-middle d-table-cell" colspan="5">&#36;'.$user['spent'].' within Discount Range &#36;'.$rd['f'].'-&#36;'.$rd['t'].' granting '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost'].' Off').'</td>'.
      '<td class="text-right align-middle d-table-cell px-0">-'.$dedtot.'</td>'.
      '<td>&nbsp;</td>'.
    '</tr>';
  }
}
$html.='<tr>'.
	'<td class="text-right align-middle d-table-cell px-0" colspan="2"><div class="input-text">Shipping</div></td>'.
  '<td class="align-middle d-table-cell px-0" colspan="1">'.
    '<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
      '<input type="hidden" name="act" value="postageupdate">'.
      '<input type="hidden" name="id" value="'.$r['id'].'">'.
      '<input type="hidden" name="t" value="orders">'.
      '<input type="hidden" name="c" value="postageCode">'.
      '<select name="da">'.
        '<option value="">Shipping Options</option>'.
        '<option value="AUS_PARCEL_REGULAR">Australia Post Regular Post</option>'.
        '<option value="AUS_PARCEL_EXPRESS">Australia Post Express Post</option>';
        $spo=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postageoption' ORDER BY `title` ASC");
        if($spo->rowCount()>0){
          while($rpo=$spo->fetch(PDO::FETCH_ASSOC))$html.='<option value="'.$rpo['id'].'">'.$rpo['title'].'</option>';
        }
      $html.='</select>'.
    '</form>'.
  '</td>'.
	'<td class="text-right align-middle d-table-cell px-0" colspan="4">'.
    '<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
      '<input name="act" type="hidden" value="postoption">'.
      '<input name="id" type="hidden" value="'.$r['id'].'">'.
      '<input name="t" type="hidden" value="orders">'.
      '<input name="c" type="hidden" value="postageOption">'.
      '<input name="da" type="text" value="'.$r['postageOption'].'">'.
    '</form>'.
	'</td>'.
	'<td class="text-right px-0">'.
		'<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
			'<input name="act" type="hidden" value="postcost">'.
			'<input name="id" type="hidden" value="'.$r['id'].'">'.
			'<input name="t" type="hidden" value="orders">'.
			'<input name="c" type="hidden" value="postage">'.
			'<input class="text-right" name="da" type="text" value="'.$r['postageCost'].'">';
      $total=$total+$r['postageCost'];
      $total=number_format((float)$total,2,'.','');
		$html.='</form>'.
	'</td>'.
	'<td></td>'.
'</tr>';
$html.='<tr>'.
  '<td class="text-right align-middle d-table-cell px-0" colspan="2"><div class="input-text">Payment</div></td>'.
  '<td class="align-middle d-table-cell px-0" colspan="1">';
    $spo=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='payoption' ORDER BY title ASC");
    if($spo->rowCount()>0){
      $html.='<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
        '<input name="act" type="hidden" value="payselect">'.
        '<input name="id" type="hidden" value="'.$r['id'].'">'.
        '<input name="t" type="hidden" value="orders">'.
        '<input name="c" type="hidden" value="payOption">'.
        '<select name="da">'.
          '<option value="">Payment Options</option>';
          while($rpo=$spo->fetch(PDO::FETCH_ASSOC))$html.='<option value="'.$rpo['id'].'">'.$rpo['title'].($rpo['value']!=0?' (Surcharge '.($rpo['type']==1?$rpo['value'].'%':'$'.$rpo['value']).')':'').'</option>';
        $html.='</select>'.
      '</form>';
    }
  $html.='</td>'.
  '<td class="text-right align-middle d-table-cell px-0" colspan="3">'.
    '<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
      '<input type="hidden" name="act" value="paytext">'.
      '<input type="hidden" name="id" value="'.$r['id'].'">'.
      '<input type="hidden" name="t" value="orders">'.
      '<input type="hidden" name="c" value="payOption">'.
      '<input type="text" name="da" value="'.$r['payOption'].'">'.
    '</form>'.
  '</td>'.
  '<td class="text-right align-middle d-table-cell px-0">'.
    '<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
      '<input type="hidden" name="act" value="paymethod">'.
      '<input type="hidden" name="id" value="'.$r['id'].'">'.
      '<input type="hidden" name="t" value="orders">'.
      '<input type="hidden" name="c" value="payMethod">'.
      '<select name="da" class="pl-1 pr-1">'.
        '<option value="2"'.($r['payMethod']==2?' selected':'').'>Add &#36;</option>'.
        '<option vlaue="1"'.($r['payMethod']==1?' selected':'').'>Add &#37;</option>'.
      '</select>'.
    '</form>';
    if($r['payMethod']==1)
      $paytot=$total*($r['payCost']/100);
    else
      $paytot=$r['payCost'];
  $html.='</td>'.
  '<td class="align-middle d-table-cell text-right px-0">'.
    ($r['payMethod']==2?'<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
      '<input type="hidden" name="act" value="paycost">'.
      '<input type="hidden" name="id" value="'.$r['id'].'">'.
      '<input type="hidden" name="t" value="orders">'.
      '<input type="hidden" name="c" value="payCost">'.
      '<input type="text" class="text-right" name="da" value="'.number_format((float)$paytot,2,'.','').'">'.
    '</form>':number_format((float)$paytot,2,'.','')).
  '</td>';
  $total=$total+$paytot;
  $total=number_format((float)$total,2,'.','');
  $html.='<td></td>'.
'</tr>';
$html.='<tr>'.
	'<td class="text-right" colspan="7"><strong>Total</strong></td>'.
	'<td class="total text-right font-weight-bold border-2 border-black border-left-0 border-right-0 px-0 d-table-cell"><strong>'.$total.'</strong></td>'.
	'<td></td>'.
'</tr>';
$sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
$sn->execute([':oid'=>$r['id']]);
if($sn->rowCount()>0){
	while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
    $html.='<tr>'.
      '<td class="small align-middle d-table-cell px-0" colspan="2"><small>'.date($config['dateFormat'],$rn['ti']).'</small></td>'.
      '<td class="align-middle d-table-cell px-0" colspan="5">'.
        '<form target="sp" method="post" action="core/updateorder.php">'.
          '<input name="act" type="hidden" value="title">'.
          '<input name="id" type="hidden" value="'.$rn['id'].'">'.
          '<input name="t" type="hidden" value="orderitems">'.
          '<input name="c" type="hidden" value="title">'.
          '<div class="form-row">'.
            '<input name="da" type="text" value="'.$rn['title'].'">'.
            '<div class="input-text">minus</div>'.
          '</div>'.
        '</form>'.
      '</td>'.
      '<td class="text-right align-middle d-table-cell px-0">'.
        '<form target="sp" method="post" action="core/updateorder.php">'.
          '<input name="act" type="hidden" value="cost">'.
          '<input name="id" type="hidden" value="'.$rn['id'].'">'.
          '<input name="t" type="hidden" value="orderitems">'.
          '<input name="c" type="hidden" value="cost">'.
          '<input class="text-right" name="da" value="'.$rn['cost'].'">'.
        '</form>'.
      '</td>'.
      '<td class="text-right px-0">'.
        '<form target="sp" method="post" action="core/updateorder.php">'.
          '<input name="act" type="hidden" value="trash">'.
          '<input name="id" type="hidden" value="'.$rn['id'].'">'.
          '<input name="t" type="hidden" value="orderitems">'.
          '<input name="c" type="hidden" value="quantity">'.
          '<input name="da" type="hidden" value="0">'.
          '<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
        '</form>'.
      '</td>'.
    '</tr>';
    $total=$total-$rn['cost'];
    $total=number_format((float)$total,2,'.','');
  }
  $html.='<tr>'.
    '<td class="text-right" colspan="7"><strong>Balance</strong></td>'.
    '<td class="total text-right font-weight-bold border-2 border-black border-left-0 border-right-0 px-0 d-table-cell"><strong>'.$total.'</td>'.
    '<td></td>'.
  '</tr>';
  $so=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE id=:id");
  $so->execute([
    ':id'=>$r['id'],
    ':total'=>$total
  ]);
}
echo'<script>'.
  'window.top.window.$("#updateorder").html(`'.$html.'`);'.
	'window.top.window.$(".page-block").removeClass("d-block");'.
'</script>';
