<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update
 * @package    core/update.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2021 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
require'sanitise.php';
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
function sluggify($url){
	$url=strtolower($url);
	$url=strip_tags($url);
	$url=stripslashes($url);
	$url=html_entity_decode($url);
	$url=str_replace('\'','',$url);
	$match='/[^a-z0-9]+/';
	$replace='-';
	$url=preg_replace($match,$replace,$url);
	$url=trim($url,'-');
	return$url;
}
$e='';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
if($tbl=='seo'||
	$tbl=='content'||
	$tbl=='menu'||
	$tbl=='config'||
	$tbl=='login'||
	$tbl=='orders'&&
		$col=='tis'||
		$col=='tie'||
		$col=='pti'||
		$col=='paid_ti'||
		$col=='notes'||
		$col=='notes2'||
		$col=='PasswordResetLayout'||
		$col=='orderEmailLayout'||
		$col=='orderEmailNotes'||
		$col=='passwordResetLayout'||
		$col=='accountActivationLayout'||
		$col=='bookingEmailLayout'||
		$col=='bookingAutoReplyLayout'||$col=='contactAutoReplyLayout'||$col=='dateFormat'||$col=='newslettersOptOutLayout'||$col=='php_quicklink'||$col=='ga_tracking'||$col=='messengerFBCode'||$col=='signature'){
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
	if($col=='messengerFBCode')$da=rawurldecode($da);
}else{
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
  $da=kses($da,array());
}
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$si=session_id();
$ti=time();
if($col!='messengerFBCode'){
	$s=$db->prepare("SELECT * FROM `".$prefix.$tbl."` WHERE `id`=:id");
	$s->execute([':id'=>$id]);
	$r=$s->fetch(PDO::FETCH_ASSOC);
	$oldda=$r[$col];
}
if($tbl=='content'&&$col=='status'&&$da=='published'){
	if($ti>time())$status='unpublished';else$status='published';
  $q=$db->prepare("UPDATE `".$prefix."content` SET `status`=:status WHERE `id`=:id");
  $q->execute([
		':status'=>$status,
    ':id' =>$id
  ]);
}
if($tbl=='content'&&$col=='title'){
	$slug=sluggify($da);
	$ss=$db->prepare("UPDATE `".$prefix.$tbl."` SET `urlSlug`=:slug WHERE `id`=:id");
	$ss->execute([
		':id'=>$id,
		':slug'=>$slug
	]);
}
if($tbl=='content'){
	if($col=='tis'||$col=='tie'||$col=='pti')echo"(".date($config['dateFormat'],$da).")";
}
if($tbl=='config'||$tbl=='login'||$tbl=='orders'||$tbl=='orderitems'||$tbl=='messages')$r['contentType']='';
$log=[
  'uid'=>0,
  'rid'=>$id,
  'username'=>'',
  'name'=>'',
  'view'=>$r['contentType'],
  'contentType'=>$r['contentType'],
  'refTable'=>$tbl,
  'refColumn'=>$col,
  'oldda'=>$oldda,
  'newda'=>$da,
  'action'=>'update',
  'ti'=>$ti
];
if($r['contentType']=='booking')$log['view']=$r['contentType'].'s';
if(isset($_SESSION['uid'])){
  $uid=(int)$_SESSION['uid'];
  $q=$db->prepare("SELECT `rank`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $q->execute([':id'=>$uid]);
  $u=$q->fetch(PDO::FETCH_ASSOC);
  $login_user=$u['name']!=''?$u['name']:$u['username'];
  $log['uid']=$uid;
	$log['username']=$u['username'];
	$log['name']=$u['name'];
}else{
  $uid=0;
  $u['rank']=0;
  $login_user="Anonymous";
}
if($tbl=='login'&&$col=='password'){
  $da=password_hash($da,PASSWORD_DEFAULT);
  $log['action']='update password';
  $log['oldda']='';
  $log['newda']='';
}
if($tbl=='content'||$tbl=='menu'){
  $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET `eti`=:ti,`login_user`=:login_user WHERE `id`=:id");
  $q->execute([
    ':ti'=>$ti,
    ':login_user'=>$login_user,
    ':id'=>$id
  ]);
}
if($tbl=='seo'){
  $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET `ti`=:ti WHERE `id`=:id");
  $q->execute([
    ':ti'=>$ti,
    ':id'=>$id
  ]);
}
if(($col=='cost'||$col=='rCost')){
	if($da==0){
		$gst=0;
	}else{
  	$gst=$da*($config['gst']/100);
		$gst=$da+$gst;
		$gst=number_format((float)$gst,2,'.','');
	}
	echo'<script>window.top.window.$("#gst'.$col.'").html("'.$gst.'");</script>';
}
if($tbl=='login'&&$col=='rank'){
	$q=$db->prepare("UPDATE `".$prefix."login` SET `pti`=:pti,`rank`=:rank WHERE `id`=:id");
	$q->execute([
		':id'=>$id,
		':pti'=>$ti,
		':rank'=>$da
	]);
}elseif($tbl=='login'&&$col=='username'){
  $uc1=$db->prepare("SELECT `username` FROM `".$prefix."login` WHERE `username`=:da");
  $uc1->execute([':da'=>$da]);
  if($uc1->rowCount()<1){
    $q=$db->prepare("UPDATE `".$prefix."login` SET `username`=:da WHERE `id`=:id");
    $q->execute([
      ':da'=>$da,
      ':id'=>$id
    ]);
		echo'<script>window.top.window.$("#uerror").addClass("d-none");</script>';
	}else{
    $uc2=$db->prepare("SELECT `username` FROM `".$prefix."login` WHERE `id`=:id");
    $uc2->execute([':id'=>$id]);
    $uc=$uc2->fetch(PDO::FETCH_ASSOC);
		echo'<script>window.top.window.$("#uerror").removeClass("d-none");</script>';
	}
}else{
  $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET `".$col."`=:da WHERE `id`=:id");
  $q->execute([
    ':da'=>$da,
    ':id'=>$id
  ]);
}
if($tbl=='login'&&$col=='email'){
	$h=$db->prepare("UPDATE `".$prefix."login` SET `hash`=:hash WHERE `id`=:id");
	$h->execute([
    ':hash'=>md5($da),
    ':id'=>$id
  ]);
}
$e=$db->errorInfo();
if($tbl=='orders'&&$col=='status'&&$da=='archived'){
  $r=$db->query("SELECT MAX(`id`) as id FROM `".$prefix."orders`")->fetch();
  $oid=strtoupper('A').date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
  $q=$db->prepare("UPDATE `".$prefix."orders` SET `aid`=:aid,`aid_ti`=:aid_ti WHERE `id`=:id");
  $q->execute([
    ':aid'=>$oid,
    ':aid_ti'=>$ti,
    ':id'=>$id
  ]);
}
if($tbl=='orders'&&$col=='status'&&$da=='paid'){
	$q=$db->prepare("SELECT `id`,`cid`,`total`,`points` FROM `".$prefix."orders` WHERE `id`=:id");
	$q->execute([':id'=>$id]);
	$r=$q->fetch(PDO::FETCH_ASSOC);
	$sp=$db->prepare("SELECT `quantity`,`points` FROM `".$prefix."orderitems` WHERE `oid`=:id");
	$sp->execute([
		':id'=>$r['id']
	]);
	$points=0;
	while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
		if($rp['points']>0)$points=$points+($rp['points'] * $rp['quantity']);
	}
	$s=$db->prepare("SELECT `spent` FROM `".$prefix."login` WHERE `id`=:uid");
	$s->execute([':uid'=>$r['cid']]);
	$ru=$s->fetch(PDO::FETCH_ASSOC);
	$ru['spent']=$ru['spent']+$r['total'];
	$s=$db->prepare("UPDATE `".$prefix."login` SET `spent`=:spent,`points`=`points`+:points,`pti`=:pti WHERE `id`=:cid");
	$s->execute([
		':spent'=>$ru['spent'],
		':points'=>$points,
		':pti'=>$ti,
		':cid'=>$r['cid']
	]);
}
if(is_null($e[2])){
	if($tbl=='orders'&&$col=='due_ti')echo'<script>window.top.window.$("#due_ti").val(`'.date($config['dateFormat'],$da).'`);</script>';
	if($tbl=='content'&&$col=='file'&&$da==''){
		if(file_exists('../media/file_'.$id.'.jpeg'))unlink('../media/file_'.$id.'.jpeg');
    if(file_exists('../media/file_'.$id.'.jpg'))unlink('../media/file_'.$id.'.jpg');
    if(file_exists('../media/file_'.$id.'.png'))unlink('../media/file_'.$id.'.png');
    if(file_exists('../media/file_'.$id.'.gif'))unlink('../media/file_'.$id.'.gif');
		if(file_exists('../media/file_'.$id.'.tif'))unlink('../media/file_'.$id.'.tif');
	}
	if($tbl=='config'&&$col=='php_honeypot')echo'<script>window.top.window.$("#php_honeypot_link").html(`'.($da!=''?'<a target="_blank" href="'.$da.'">'.$da.'</a>':'Honey Pot File Not Uploaded').'`);</script>';
	if($tbl=='login'&&$col=='gravatar'){
    if($da==''){
      $sav=$db->prepare("SELECT `avatar` FROM `".$prefix."login` WHERE `id`=:id");
      $sav->execute([':id'=>$id]);
      $av=$sav->fetch(PDO::FETCH_ASSOC);
      if($av['avatar']!=''&&file_exists('../media/avatar/'.$av['avatar']))$avatar='media/avatar/'.$av['avatar'];
			else$avatar='images/noavatar.jpg';
    }else{
			$avatar=$da;
			echo'<script>window.top.window.$("#avatar").attr("src",`'.$avatar.'?'.time().'`);</script>';
		}
	}
}
echo'<script>window.top.window.$(".page-block").removeClass("d-block");</script>';
if($col=='status'){
	if($da=='archived')echo'<script>window.top.window.$("#l_'.$id.'").slideUp(500,function(){$(this).remove()});</script>';
	if($tbl!='comments'||$da=='delete'||$da=='')echo'<script>window.top.window.statusSet(`'.$id.'`,`'.$da.'`);</script>';
	if($da=='delete')echo'<script>window.top.window.$("#l_'.$id.'").addClass("danger");</script>';
	else echo'<script>window.top.window.$("#l_'.$id.'").removeClass("danger");</script>';
}
if($col=='password')echo'<script>window.top.window.$("#passButton").removeClass("btn-danger");window.top.window.$(".page-block").removeClass("d-block");</script>';
if($config['options'][12]==1){
	$s=$db->prepare("INSERT IGNORE INTO `".$prefix."logs` (`uid`,`rid`,`username`,`name`,`view`,`contentType`,`refTable`,`refColumn`,`oldda`,`newda`,`action`,`ti`) VALUES (:uid,:rid,:username,:name,:view,:contentType,:refTable,:refColumn,:oldda,:newda,:action,:ti)");
	$s->execute([
	  ':uid'=>$log['uid'],
	  ':rid'=>$log['rid'],
	  ':username'=>$log['username'],
	  ':name'=>$log['name'],
	  ':view'=>$log['view'],
	  ':contentType'=>$log['contentType'],
	  ':refTable'=>$log['refTable'],
	  ':refColumn'=>$log['refColumn'],
	  ':oldda'=>$log['oldda'],
	  ':newda'=>$log['newda'],
	  ':action'=>$log['action'],
	  ':ti'=>$log['ti']
	]);
}
