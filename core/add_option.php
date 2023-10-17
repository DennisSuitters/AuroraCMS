<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Option
 * @package    core/add_option.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$ti=time();
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$oid=filter_input(INPUT_POST,'oid',FILTER_SANITIZE_NUMBER_INT);
$title=filter_input(INPUT_POST,'ttl',FILTER_UNSAFE_RAW);
$cat=filter_input(INPUT_POST,'cat',FILTER_UNSAFE_RAW);
$qty=filter_input(INPUT_POST,'qty',FILTER_SANITIZE_NUMBER_INT);
$cost=filter_input(INPUT_POST,'cost',FILTER_UNSAFE_RAW);
$image=filter_input(INPUT_POST,'oi',FILTER_UNSAFE_RAW);
$status=filter_input(INPUT_POST,'status',FILTER_UNSAFE_RAW);
$da=filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW);
if($title==''){
	echo'<script>'.
		'window.top.window.toastr["error"]("The Title field must contain text!");'.
		'window.top.window.$(`#otitle`).focus();'.
	'</script>';
}else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`oid`,`contentType`,`title`,`category`,`quantity`,`cost`,`file`,`status`,`notes`,`ti`) VALUES (:rid,:oid,'option',:title,:category,:quantity,:cost,:file,:status,:notes,:ti)");
	$q->execute([
		':rid'=>$rid,
		':oid'=>$oid,
		':title'=>$title,
		':category'=>$cat,
		':quantity'=>$qty,
		':cost'=>$cost,
		':file'=>$image,
		':status'=>$status,
		':notes'=>$da,
		':ti'=>$ti
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
		$s=$db->prepare("UPDATE `".$prefix."choices` SET `ord`=:id WHERE `id`=:id");
		$s->execute([':id'=>$id]);
		if($oid!=0){
			$soo=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
			$soo->execute([':id'=>$oid]);
			$roo=$soo->fetch(PDO::FETCH_ASSOC);
		}
		echo'<script>window.top.window.$("#options").append(`<div id="l_'.$id.'" class="card col-12 mx-0 my-1 m-sm-1 overflow-visible add-item"><div class="row">'.($image!=''?'<div class="col-12 col-sm-3 list-images-1 overflow-hidden"><a data-fancybox href="'.$image.'"><img src="'.$image.'"></a></div>':(isset($roo['file'])&&$roo['file']!=''?'<div class="col-12 col-sm-3 list-images-1 overflow-hidden"><a data-fancybox href="'.$roo['file'].'"><img src="'.($roo['thumb']!=''?$roo['thumb']:$roo['file']).'"></a></div>':'')).'<div class="card-footer col-12 col-sm m-0 p-1"><div class="row m-0 p-0"><div class="col-12 small m-0 p-0"><div class="col-12"><select class="status '.$status.'" onchange="update(\`'.$id.'\`,\`choices\`,\`status\`,$(this).val(),\`select\`);$(this).removeClass().addClass(\`status \`+$(this).val());changeShareStatus($(this).val());"><option class="unavailable" value="unavailable"'.($status=='unavailable'?' selected':'').'>Unavailable</option><option class="available" value="available"'.($status=='available'?' selected':'').'>Available</option></select></div>'.($cat!=''?'<div class="h6 col-12">Category: '.$cat.'</div>':'').'<div class="h6 col-12">Title: '.$title.'</div>'.($qty>0?'<div class="col-12">Quantity: '.$qty.'</div>':(isset($roo['quantity'])&&$roo['quantity']>0?'<div class="col-12">Quantity: '.$roo['quantity'].' (Linked)</div>':'')).'<div class="row">'.($cost>0?'<div class="col-12">$'.$cost.'</div>':(isset($roo['rrp'])&&$roo['rrp']>0?'<div class="col-12 col-sm-6">RRP $'.$roo['rrp'].' (Linked)</div>':'').(isset($roo['cost'])&&$roo['cost']>0?'<div class="col-12 col-sm-6">Cost $'.$roo['cost'].' (Linked)</div>':'').(isset($roo['rCost'])&&$roo['rCost']>0?'<div class="col-12 col-sm-6">Reduced $'.$roo['rCost'].' (Linked)</div>':'').(isset($roo['dCost'])&&$roo['dCost']>0?'<div class="col-12 col-sm-6">Wholesale $'.$roo['dCost'].' (Linked)</div>':'')).'</div>'.($da!=''?'<div id="listmore'.$id.'" class="'.(strlen($da)>100?'list-more ':'').'col-12">'.$da.'</div>'.(strlen($da)>100?'<div class="col-12"><button class="btn-block p-0 mb-3" onclick="$(\`#listmore'.$id.'\`).toggleClass(\`list-more\`);$(\`.list-arrow-'.$id.'\`).toggleClass(\`d-none\`);"><i class="i list-arrow-'.$id.'">down</i><i class="i list-arrow-'.$id.' d-none">up</i></button></div>':''):(isset($roo['notes'])&&$roo['notes']!=''?'<div id="listmore'.$id.'" class="'.(strlen($roo['notes'])>100?'list-more ':'').'col-12">'.$roo['notes'].'</div>'.(strlen($roo['notes'])>100?'<div class="col-12"><button class="btn-block p-0 mb-3" onclick="$(\`#listmore'.$id.'\`).toggleClass(\`list-more\`);$(\`.list-arrow-'.$id.'\`).toggleClass(\`d-none\`);"><i class="i list-arrow-'.$id.'">down</i><i class="i list-arrow-'.$id.' d-none">up</i></button></div>':''):'')).'</div><div class="col-12 text-right"><form class="d-inline" target="sp" action="core/purge.php"><input name="id" type="hidden" value="'.$id.'"><input name="t" type="hidden" value="choices"><button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button></form><span class="btn btn-sm orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span></div></div></div></div></div>`);</script>';
	}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Data!");</script>';
}
