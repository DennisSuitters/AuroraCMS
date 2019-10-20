<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update Order
 * @package    core/updateorder.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 */
echo'<script>';
if(session_status()==PHP_SESSION_NONE)session_start();
$getcfg=true;
require'db.php';
define('THEME','layout'.DS.$config['theme']);
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
if(file_exists(THEME.DS.'images'.DS.'noimage.png'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.png');
elseif(file_exists(THEME.DS.'images'.DS.'noimage.gif'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.gif');
elseif(file_exists(THEME.DS.'images'.DS.'noimage.jpg'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.jpg');
else
	define('NOIMAGE','core'.DS.'images'.DS.'noimage.jpg');
if($act=='additem'){
	if($da!=0){
		$q=$db->prepare("SELECT title,cost FROM `".$prefix."content` WHERE id=:id");
		$q->execute([':id'=>$da]);
		$r=$q->fetch(PDO::FETCH_ASSOC);
		if($r['cost']==''||!is_numeric($r['cost']))$r['cost']=0;
	}else{
    $r=[
      'title'=>'',
      'cost'=>0
    ];
  }
	$q=$db->prepare("INSERT INTO `".$prefix."orderitems` (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
	$q->execute([
    ':oid'=>$id,
    ':iid'=>$da,
    ':title'=>$r['title'],
    ':cost'=>$r['cost'],
    ':ti'=>time()
  ]);
}
if($act=='title'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE id=:id");
  $ss->execute([':id'=>$id]);
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orderitems` SET title=:title WHERE id=:id");
  $s->execute([
    ':id'=>$id,
    ':title'=>$da
  ]);
  $id=$r['oid'];
}
if($act=='quantity'||$act=='trash'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE id=:id");
  $ss->execute([':id'=>$id]);
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  if($da==0){
    $s=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE id=:id");
    $s->execute([':id'=>$id]);
  }else{
    $s=$db->prepare("UPDATE `".$prefix."orderitems` SET quantity=:quantity WHERE id=:id");
    $s->execute([
      ':quantity'=>$da,
      ':id'=>$id
    ]);
  }
  $id=$r['oid'];
}
if($act=='cost'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE id=:id");
  $ss->execute([':id'=>$id]);
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orderitems` SET cost=:cost WHERE id=:id");
  $s->execute([
    ':cost'=>$da,
    ':id'=>$id
  ]);
  $id=$r['oid'];
}
if($act=='reward'){
  $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE code=:code");
  $sr->execute([':code'=>$da]);
  $reward=$sr->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orders` SET rid=:rid WHERE id=:id");
  $s->execute([
    ':rid'=>$reward['id'],
    ':id'=>$id
  ]);
}
if($act=='addpostoption'){
	if($da==0){
		$rc=[
			'title'=>'',
			'value'=>0
		];
	}else{
		$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='postoption' AND id=:id");
		$sc->execute([':id'=>$da]);
		$rc=$sc->fetch(PDO::FETCH_ASSOC);
	}
	$s=$db->prepare("UPDATE `".$prefix."orders` SET postageOption=:postoption, postageCost=:postcost WHERE id=:id");
	$s->execute([
		':id'=>$id,
		':postoption'=>$rc['title'],
		':postcost'=>$rc['value']
	]);
}
if($act=='postoption'){
	$s=$db->prepare("UPDATE `".$prefix."orders` SET postageOption=:postoption WHERE id=:id");
	$s->execute([
		':postoption'=>$da,
		':id'=>$id
	]);
}
if($act=='postcost'){
  $s=$db->prepare("UPDATE `".$prefix."orders` SET postageCost=:postcost WHERE id=:id");
  $s->execute([
    ':postcost'=>$da,
    ':id'=>$id
  ]);
}
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
$si->execute([':oid'=>$r['id']]);
$total=0;
$html='';
while($oi=$si->fetch(PDO::FETCH_ASSOC)){
  $is=$db->prepare("SELECT id,thumb,file,fileURL,code,title FROM `".$prefix."content` WHERE id=:id");
  $is->execute([':id'=>$oi['iid']]);
  $i=$is->fetch(PDO::FETCH_ASSOC);
  $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
  $sc->execute([':id'=>$oi['cid']]);
  $c=$sc->fetch(PDO::FETCH_ASSOC);
	$image='';
	if($i['thumb']!=''&&file_exists('media'.DS.basename($i['thumb'])))
		$image='media'.DS.basename($i['thumb']);
	elseif($i['file']!=''&&file_exists('media'.DS.basename($i['file'])))
		$image='media'.DS.basename($i['file']);
	elseif($i['fileURL']!='')
		$image=$i['fileURL'];
	else
		$image='';
  $html.='<tr>'.
					'<td class="text-center align-middle"><img class="img-fluid" style="max-width:24px;height:24px;" src="'.$image.'" alt="'.$c['title'].'"></td>'.
    			'<td class="text-left align-middle">'.$i['code'].'</td>'.
    			'<td class="text-left align-middle">'.
						($oi['iid']!=0?$i['title']:'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();"><input type="hidden" name="act" value="title"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="title"><input type="text" class="form-control" name="da" value="'.$oi['title'].'"></form>').
					'</td>'.
    			'<td class="text-left align-middle">'.$c['title'].'</td>'.
					'<td class="text-center align-middle">'.
						($oi['iid']!=0?'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();"><input type="hidden" name="act" value="quantity"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'"'.($r['status']=='archived'?' readonly':'').'></form>':($oi['iid']!=0?$oi['quantity']:'')).
    			'</td>'.
					'<td class="text-right align-middle">'.
  					($oi['iid'] != 0?'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();"><input type="hidden" name="act" value="cost"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" style="min-width:80px" name="da" value="'.$oi['cost'].'"'.($r['status']=='archived'?' readonly':'').'></form>':($oi['iid'] != 0?$oi['cost']:'')).
    			'</td>'.
    			'<td class="text-right align-middle">'.($oi['iid']!=0?$oi['cost']*$oi['quantity']:'').'</td>'.
					'<td class="text-right">'.
						'<form target="sp" method="post" action="core/updateorder.php" onsubmit="Pace.restart();">'.
							'<input type="hidden" name="act" value="trash">'.
							'<input type="hidden" name="id" value="'.$oi['id'].'">'.
							'<input type="hidden" name="t" value="orderitems">'.
							'<input type="hidden" name="c" value="quantity">'.
							'<input type="hidden" name="da" value="0">'.
							'<button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
						'</form>'.
					'</td>'.
				'</tr>';
  if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
}
$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE id=:rid");
$sr->execute([':rid'=>$r['rid']]);
$reward=$sr->fetch(PDO::FETCH_ASSOC);
  $html.='<tr>'.
					'<td colspan="3" class="text-right align-middle"><strong>Rewards Code</strong></td>'.
					'<td colpsan="2" class="text-center">'.
						'<form id="rewardsinput" target="sp" method="post" action="core/updateorder.php" onsubmit="Pace.restart();">'.
							'<div class="form-group row">'.
								'<div class="input-group">'.
									'<input type="hidden" name="act" value="reward">'.
									'<input type="hidden" name="id" value="'.$r['id'].'">'.
									'<input type="hidden" name="t" value="orders">'.
									'<input type="hidden" name="c" value="rid">'.
									'<input type="text" id="rewardselect" class="form-control" name="da" value="'.($sr->rowCount()==1?$reward['code']:'').'">';
$ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY code ASC, title ASC");
$ssr->execute();
if($ssr->rowCount()>0){
					$html.='<div class="input-group-append">'.
										'<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>'.
										'<div class="dropdown-menu">';
	while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){
								$html.='<a class="dropdown-item" href="#" onclick="$(`#rewardselect`).val(`'.$srr['code'].'`);$(`#rewardsinput:first`).submit();return false;">';
									$html.=$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off';
								$html.='</a>';
	}
							$html.='</div>'.
									'</div>';
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
			  $html.=' Off';
			}
    	$html.='</td>'.
							'<td class="text-right align-middle"><strong>'.$total.'</strong></td>'.
							'<td>&nbsp;</td>'.
						'</tr>'.
						'<tr>'.
							'<td class="text-right align-middle"><strong>Postage</strong></td>'.
							'<td colspan="5" class="text-right align-middle">'.
								'<form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();" onsubmit="Pace.restart();">'.
									'<input type="hidden" name="act" value="postoption">'.
									'<input type="hidden" name="id" value="'.$r['id'].'">'.
									'<input type="hidden" name="t" value="orders">'.
									'<input type="hidden" name="c" value="postageOption">'.
									'<input type="text" class="form-control" name="da" value="'.$r['postageOption'].'">'.
								'</form>'.
							'</td>'.
							'<td class="text-right pl-0 pr-0">'.
								'<form target="sp" method="POST" action="core/updateorder.php" onchange="$(this).submit();" onsubmit="Pace.restart();">'.
									'<input type="hidden" name="act" value="postcost">'.
									'<input type="hidden" name="id" value="'.$r['id'].'">'.
									'<input type="hidden" name="t" value="orders">'.
									'<input type="hidden" name="c" value="postage">'.
									'<input type="text" class="form-control text-right" style="min-width:70px" name="da" value="'.$r['postageCost'].'">';
									$total=$total+$r['postageCost'];
					$html.='</form>'.
							'</td>'.
							'<td>&nbsp;</td>'.
						'</tr>'.
						'<tr">'.
							'<td colspan="6" class="text-right"><strong>Total</strong></td>'.
							'<td class="total text-right border-top"><strong>'.$total.'</strong></td>'.
							'<td>&nbsp;</td>'.
						'</tr>';?>
  window.top.window.$('#updateorder').html('<?php echo$html;?>');
  window.top.window.Pace.stop();
<?php
echo'</script>';
