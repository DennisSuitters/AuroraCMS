<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update Order
 * @package    core/updateorder.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<script>';
if(session_status()==PHP_SESSION_NONE)session_start();
$getcfg=true;
require'db.php';
require'puconverter.php';
define('THEME','layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
$ti=time();
if(file_exists(THEME.'/images/noimage.png'))
	define('NOIMAGE',THEME.'/images/noimage.png');
elseif(file_exists(THEME.'/images/noimage.gif'))
	define('NOIMAGE',THEME.'/images/noimage.gif');
elseif(file_exists(THEME.'/images/noimage.jpg'))
	define('NOIMAGE',THEME.'/images/noimage.jpg');
else
	define('NOIMAGE','core/images/noimage.jpg');
if($act=='additem'){
	if($da!=0){
		$q=$db->prepare("SELECT `title`,`cost`,`rCost` FROM `".$prefix."content` WHERE `id`=:id");
		$q->execute([
			':id'=>$da
		]);
		$r=$q->fetch(PDO::FETCH_ASSOC);
		if($r['cost']==''||!is_numeric($r['cost']))$r['cost']=0;
		if($r['rCost']!=0)$r['cost']=$r['rCost'];
	}elseif($da=='neg'){
		$r=[
			'title'=>'',
			'cost'=>0,
			'status'=>'neg'
		];
	}else{
    $r=[
      'title'=>'',
      'cost'=>0,
			'status'=>''
    ];
  }
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,:iid,:title,'1',:cost,:status,:ti)");
	$q->execute([
    ':oid'=>$id,
    ':iid'=>$da,
    ':title'=>$r['title'],
    ':cost'=>$r['cost'],
		':status'=>isset($r['status'])&&$r['status']!=''?$r['status']:'',
    ':ti'=>time()
  ]);
}
if($act=='title'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `id`=:id");
  $ss->execute([
		':id'=>$id
	]);
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
  $ss->execute([
		':id'=>$id
	]);
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  if($da==0){
    $s=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE `id`=:id");
    $s->execute([
			':id'=>$id
		]);
  }else{
    $s=$db->prepare("UPDATE `".$prefix."orderitems` SET `quantity`=:quantity WHERE `id`=:id");
    $s->execute([
      ':quantity'=>$da,
      ':id'=>$id
    ]);
  }
  $id=$r['oid'];
}
if($act=='cost'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `id`=:id");
  $ss->execute([
		':id'=>$id
	]);
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orderitems` SET `cost`=:cost WHERE `id`=:id");
  $s->execute([
    ':cost'=>$da,
    ':id'=>$id
  ]);
  $id=$r['oid'];
}
if($act=='reward'){
	if($da=='')
		$reward['id']=0;
	else{
  	$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `code`=:code");
  	$sr->execute([
			':code'=>$da
		]);
  	$reward=$sr->fetch(PDO::FETCH_ASSOC);
	}
  $s=$db->prepare("UPDATE `".$prefix."orders` SET `rid`=:rid WHERE `id`=:id");
  $s->execute([
    ':rid'=>$reward['id'],
    ':id'=>$id
  ]);
}
if($act=='addpostoption'){
	if($da==0){
		$rc=[
			'id'=>0,
			'type'=>'',
			'title'=>'',
			'value'=>0
		];
	}else{
		$sc=$db->prepare("SELECT `id`,`type`,`title`,`value` FROM `".$prefix."choices` WHERE `contentType`='postoption' AND `id`=:id");
		$sc->execute([
			':id'=>$da
		]);
		$rc=$sc->fetch(PDO::FETCH_ASSOC);
	}
	if($config['austPostAPIKey']!=''&&stristr($rc['type'],'AUS_')){
		$apiKey=$config['austPostAPIKey'];
		$totalweight=$weight=$dimW=$dimL=$dimH=0;
		$os=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
		$os->execute([
			':id'=>$id
		]);
		$oir=$os->fetch(PDO::FETCH_ASSOC);
		$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
		$su->execute([
			':uid'=>$oir['uid']
		]);
		$ru=$su->fetch(PDO::FETCH_ASSOC);
		$si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:id");
		$si->execute([
			':id'=>$id
		]);
		while($ri=$si->fetch(PDO::FETCH_ASSOC)){
			$sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:sid");
			$sc->execute([
				':sid'=>$ri['iid']
			]);
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
		':postageCode'=>$rc['id'],
		':postageOption'=>$rc['title'],
		':postagCost'=>$rc['value']
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
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
$s->execute([
	':id'=>$id
]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `ti` ASC,`title` ASC");
$si->execute([
	':oid'=>$r['id']
]);
$total=0;
$html='';
while($oi=$si->fetch(PDO::FETCH_ASSOC)){
  $is=$db->prepare("SELECT `id`,`thumb`,`file`,`fileURL`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
  $is->execute([
		':id'=>$oi['iid']
	]);
  $i=$is->fetch(PDO::FETCH_ASSOC);
  $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
  $sc->execute([
		':id'=>$oi['cid']
	]);
  $c=$sc->fetch(PDO::FETCH_ASSOC);
	$image='';
	if($i['thumb']!=''&&file_exists('../media/'.basename($i['thumb'])))
		$image='<img class="img-fluid" style="max-width:24px;height:24px" src="media/'.basename($i['thumb']).'" alt="'.$i['title'].'">';
	elseif($i['file']!=''&&file_exists('../media/'.basename($i['file'])))
		$image='<img class="img-fluid" style="max-width:24px;height:24px" src="media/'.basename($i['file']).'" alt="'.$i['title'].'">';
	elseif($i['fileURL']!='')
		$image='<img class="img-fluid" style="max-width:24px;height:24px" src="'.$i['fileURL'].'" alt="'.$i['title'].'">';
	else
		$image='';
  $html.='<tr>'.
					'<td class="text-center align-middle">'.$image.'</td>'.
    			'<td class="text-left align-middle">'.$i['code'].'</td>'.
    			'<td class="text-left align-middle">'.
						($oi['iid']!=0?$i['title']:'<form target="sp" method="post" action="core/updateorder.php"><input name="act" type="hidden" value="title"><input name="id" type="hidden" value="'.$oi['id'].'"><input name="t" type="hidden" value="orderitems"><input name="c" type="hidden" value="title"><input name="da" type="text" value="'.$oi['title'].'"></form>').
					'</td>'.
    			'<td class="text-left align-middle">'.$c['title'].'</td>'.
					'<td class="text-center align-middle">'.
						($oi['iid']!=0?'<form target="sp" method="post" action="core/updateorder.php"><input name="act" type="hidden" value="quantity"><input name="id" type="hidden" value="'.$oi['id'].'"><input name="t" type="hidden" value="orderitems"><input name="c" type="hidden" value="quantity"><input name="da" class="text-center" value="'.$oi['quantity'].'"'.($r['status']=='archived'?' readonly':'').'></form>':($oi['iid']!=0?$oi['quantity']:'')).
    			'</td>'.
					'<td class="text-right align-middle">'.
  					($oi['iid'] != 0?'<form target="sp" method="post" action="core/updateorder.php"><input name="act" type="hidden" value="cost"><input name="id" type="hidden" value="'.$oi['id'].'"><input name="t" type="hidden" value="orderitems"><input name="c" type="hidden" value="cost"><input class="text-center" style="min-width:80px" name="da" value="'.$oi['cost'].'"'.($r['status']=='archived'?' readonly':'').'></form>':($oi['iid'] != 0?$oi['cost']:'')).
    			'</td>'.
    			'<td class="text-right align-middle">'.($oi['iid']!=0?$oi['cost']*$oi['quantity']:'').'</td>'.
					'<td class="text-right">'.
						'<form target="sp" method="post" action="core/updateorder.php">'.
							'<input name="act" type="hidden" value="trash">'.
							'<input name="id" type="hidden" value="'.$oi['id'].'">'.
							'<input name="t" type="hidden" value="orderitems">'.
							'<input name="c" type="hidden" value="quantity">'.
							'<input name="da" type="hidden" value="0">'.
							'<button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
						'</form>'.
					'</td>'.
				'</tr>';
  if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
}
$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
$sr->execute([
	':rid'=>$r['rid']
]);
$reward=$sr->fetch(PDO::FETCH_ASSOC);
  $html.='<tr>'.
					'<td colspan="3" class="text-right align-middle"><strong>Rewards Code</strong></td>'.
					'<td colspan="2" class="text-center">'.
						'<form id="rewardsinput" class="form-row" target="sp" method="post" action="core/updateorder.php">'.
							'<input name="act" type="hidden" value="reward">'.
							'<input name="id" type="hidden" value="'.$r['id'].'">'.
							'<input name="t" type="hidden" value="orders">'.
							'<input name="c" type="hidden" value="rid">'.
							'<input id="rewardselect" name="da" type="text" value="'.($sr->rowCount()==1?$reward['code']:'').'">';
$ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `code` ASC,`title` ASC");
$ssr->execute();
if($ssr->rowCount()>0){
			$html.='<select onchange="$(`#rewardselect`).val($(this).val());$(`#rewardsinput:first`).submit();">';
	while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){
						$html.='<option value="'.$srr['code'].'">';
							$html.=$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off';
						$html.='</option>';
	}
							$html.='</select>';
}
					$html.='</div>'.
							'</div>'.
						'</form>'.
					'</td>'.
					'<td class="text-center align-middle">';
			if($sr->rowCount()==1){
			  if($reward['method']==1){
			    $html.='$';
			    $total=$total-$reward['value'];
			  }
			  $html.=$reward['value'];
			  if($reward['method']==0){
			    $html.='%';
			    $total=($total*((100-$reward['value'])/100));
			  }
				$total=number_format((float)$total, 2, '.', '');
			  $html.=' Off';
			}
    	$html.='</td>'.
							'<td class="text-right align-middle"><strong>'.$total.'</strong></td>'.
							'<td>&nbsp;</td>'.
						'</tr>';
			if($config['options'][26]==1){
				$us=$db->prepare("SELECT `spent` FROM `".$prefix."login` WHERE `id`=:uid");
				$us->execute([
					':uid'=>$r['uid']
				]);
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
						  if($rd['value']==2)
						    $total=$total*($rd['cost']/100);
						  else
						    $total=$total-$rd['cost'];
			  			$total=number_format((float)$total, 2, '.', '');
				$html.='<tr>'.
              	'<td colspan="6" class="text-right"><strong>Spent Discount '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost']).' Off</strong></td>'.
                '<td class="text-right align-middle"><strong>'.$total.'</strong></td>'.
                '<td>&nbsp;</td>'.
              '</tr>';
						}
					}
				}
			}
			if($config['gst']>0){
			  $gst=$total*($config['gst']/100);
			  $gst=number_format((float)$gst, 2, '.', '');
				$total=$total+$gst;
				$total=number_format((float)$total, 2, '.', '');
				$html.='<tr>'.
								'<td colspan="6" class="text-right"><strong>'.$config['gst'].'% GST $'.$gst.'</strong></td>'.
								'<td class="total text-right border-top border-bottom"><strong>'.$total.'</strong></td>'.
								'<td>&nbsp;</td>'.
							'</tr>';
			}
			$html.='<tr>'.
							'<td colspan="2" class="text-right align-middle"><strong>Shipping</strong></td>'.
							'<td colspan="4" class="text-right align-middle">'.
								'<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
									'<input name="act" type="hidden" value="postoption">'.
									'<input name="id" type="hidden" value="'.$r['id'].'">'.
									'<input name="t" type="hidden" value="orders">'.
									'<input name="c" type="hidden" value="postageOption">'.
									'<input name="da" type="text" value="'.$r['postageOption'].'">'.
								'</form>'.
							'</td>'.
							'<td class="text-right pl-0 pr-0">'.
								'<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">'.
									'<input name="act" type="hidden" value="postcost">'.
									'<input name="id" type="hidden" value="'.$r['id'].'">'.
									'<input name="t" type="hidden" value="orders">'.
									'<input name="c" type="hidden" value="postage">'.
									'<input class="text-right" style="min-width:70px" name="da" type="text" value="'.$r['postageCost'].'">';
									$total=$total+$r['postageCost'];
									$total=number_format((float)$total, 2, '.', '');
					$html.='</form>'.
							'</td>'.
							'<td>&nbsp;</td>'.
						'</tr>'.
						'<tr">'.
							'<td colspan="6" class="text-right"><strong>Total</strong></td>'.
							'<td class="total text-right border-top"><strong>'.$total.'</strong></td>'.
							'<td>&nbsp;</td>'.
						'</tr>';
$sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
$sn->execute([
	':oid'=>$r['id']
]);
if($sn->rowCount()>0){
	while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
					$html.='<tr><td colspan="2" class="small align-middle">'.
									'<small>'.date($config['dateFormat'],$rn['ti']).
								'</td>'.
								'<td colspan="4" class="align-middle">'.
									'<form target="sp" method="post" action="core/updateorder.php">'.
										'<input name="act" type="hidden" value="title">'.
										'<input name="id" type="hidden" value="'.$rn['id'].'">'.
										'<input name="t" type="hidden" value="orderitems">'.
										'<input name="c" type="hidden" value="title">'.
										'<input name="da" type="text" value="'.$rn['title'].'">'.
									'</form>'.
								'</td>'.
								'<td class="text-right align-middle">'.
									'<form target="sp" method="post" action="core/updateorder.php">'.
										'<input name="act" type="hidden" value="cost">'.
										'<input name="id" type="hidden" value="'.$rn['id'].'">'.
										'<input name="t" type="hidden" value="orderitems">'.
										'<input name="c" type="hidden" value="cost">'.
										'<input class="text-center" style="min-width:80px" name="da" value="'.$rn['cost'].'">'.
									'</form>'.
								'</td>'.
								'<td>'.
									'<form target="sp" method="post" action="core/updateorder.php">'.
										'<input name="act" type="hidden" value="trash">'.
										'<input name="id" type="hidden" value="'.$rn['id'].'">'.
										'<input name="t" type="hidden" value="orderitems">'.
										'<input name="c" type="hidden" value="quantity">'.
										'<input name="da" type="hidden" value="0">'.
										'<button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
									'</form>'.
								'</td></tr>';
		$total=$total-$rn['cost'];
							}
		$total=number_format((float)$total,2,'.','');
				$html.='<tr>'.
								'<td colspan="6" class="text-right"><strong>Total</strong></td>'.
								'<td class="total text-right border-top border-bottom"><strong>'.$total.'</td>'.
								'<td></td>'.
							'</tr>';
}
echo'<script>'.
  'window.top.window.$("#updateorder").html(`'.$html.'`);'.
	'window.top.window.$(".page-block").removeClass("d-block");'.
'</script>';
