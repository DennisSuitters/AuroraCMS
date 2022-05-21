<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Comment
 * @package    core/add_comment.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('THEME','layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
if(file_exists(THEME.'/images/noavatar-md.png'))define('NOAVATAR',THEME.'/images/noavatar-md.png');
elseif(file_exists(THEME.'/images/noavatar-md.gif'))define('NOAVATAR',THEME.'/images/noavatar-md.gif');
elseif(file_exists(THEME.'/images/noavatar.jpg'))define('NOAVATAR',THEME.'/images/noavatar.jpg');
else define('NOAVATAR','core/images/noavatar.jpg');
define('ADMINNOAVATAR','core/images/noavatar.jpg');
function rank($txt){
	if($txt==0)return'visitor';
	if($txt==100)return'subscriber';
	if($txt==200)return'member';
	if($txt==210)return'member-silver';
	if($txt==220)return'member-bronze';
	if($txt==230)return'member-gold';
	if($txt==240)return'member-platinum';
	if($txt==300)return'client';
  if($txt==310)return'wholesale';
  if($txt==320)return'wholesale-bronze';
	if($txt==330)return'wholesale-silver';
	if($txt==340)return'wholesale-gold';
	if($txt==350)return'wholesale-platinum';
	if($txt==400)return'contributor';
	if($txt==500)return'author';
	if($txt==600)return'editor';
	if($txt==700)return'moderator';
	if($txt==800)return'manager';
	if($txt==900)return'administrator';
	if($txt==1000)return'developer';
}
$cid=isset($_POST['cid'])?filter_input(INPUT_POST,'cid',FILTER_SANITIZE_NUMBER_INT):0;
$tid=isset($_POST['tid'])?filter_input(INPUT_POST,'tid',FILTER_SANITIZE_NUMBER_INT):0;
$pid=isset($_POST['pid'])?filter_input(INPUT_POST,'pid',FILTER_SANITIZE_NUMBER_INT):0;
$uid=isset($_POST['uid'])?filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT):0;
$h=isset($_POST['h'])?filter_input(INPUT_POST,'h',FILTER_SANITIZE_NUMBER_INT):0;
$rank=isset($_POST['r'])?filter_input(INPUT_POST,'r',FILTER_SANITIZE_NUMBER_INT):0;
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):'';
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$ti=time();
if($da==''){
	echo'<script>';
  echo'window.top.window.$("#addreply").parent().find(".alert").remove();';
  if($da==''){
    echo'window.top.window.$("#addreply").prepend(`'.
      '<div class="alert alert-info text-center" role="alert">'.
        'The text area can not be empty.'.
      '</div>'.
    '`);';
  }
  echo'window.top.window.$("#forumbusy").removeClass("d-block");';
  echo'</script>';
}else{
	$emojijson=file_get_contents('images/emojis/emojis.json');
	$data=json_decode($emojijson,true);
	foreach($data as $val => $key){
		$da=str_replace(':'.$val.':','<img class="emoji-img-inline" src="'.$key.'" alt="'.$val.'" title="'.$val.'">',$da);
	}
	$s=$db->prepare("INSERT IGNORE INTO `".$prefix."forumPosts` (`rank`,`pid`,`uid`,`notes`,`help`,`ti`) VALUES (:rank,:pid,:uid,:notes,:help,:ti)");
	$s->execute([
		':rank'=>$rank,
	  ':pid'=>$pid,
	  ':uid'=>$uid,
	  ':notes'=>$da,
		':help'=>$h,
	  ':ti'=>$ti
	]);
	$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
	$su->execute([':uid'=>$uid]);
	$ru=$su->fetch(PDO::FETCH_ASSOC);
	$sp=$db->prepare("SELECT COUNT(`id`) as 'cnt' FROM `".$prefix."forumPosts` WHERE `uid`=:uid");
	$sp->execute([':uid'=>$uid]);
	$rp=$sp->fetch(PDO::FETCH_ASSOC);
	$spt=$db->prepare("DELETE FROM `".$prefix."forumPostTrack` WHERE `pid`=:pid");
	$spt->execute([':pid'=>$pid]);
	$spt=$db->prepare("INSERT INTO `".$prefix."forumPostTrack` (`cid`,`tid`,`pid`,`uid`,`notes`) VALUES (:cid,:tid,:pid,:uid,'read')");
	$spt->execute([
		':cid'=>$cid,
		':tid'=>$tid,
		':pid'=>$pid,
		':uid'=>$uid
	]);
	if($ru['avatar']!=''&&file_exists('media/avatar/'.basename($ru['avatar']))){
		$avatar='<img src="media/avatar/'.basename($ru['avatar']).'" class="forum-avatar m-3" alt="'.($ru['name']==''?$ru['username']:$ru['name']).'">';
	}else{
		$avatar='<img src="'.NOAVATAR.'" class="forum-avatar m-3" alt="'.($ru['name']==''?$ru['username']:$ru['name']).'">';
	}
	echo'<script>'.
	  'window.top.window.$("#addreply").html(`<article class="card col-12 m-0 mb-1">'.
	    '<div class="row">'.
	      '<div class="col-sm p-3">'.
	      '<small class="text-muted">'.date($config['dateFormat'],$ti).'</small>'.
	      '<div class="forum-post p-3">'.
	        $da.
	      '</div>'.
	        ($ru['email_signature']!=''?'<hr>'.$ru['email_signature']:'').
	      '</div>'.
	      '<div class="col-sm-2 position-relative">'.
	        $avatar.
	        '<small class="d-block">'.($ru['name']==''?$ru['username']:$ru['name']).'</small>'.
	        '<small class="d-block">'.ucwords(rank(str_replace('-',' ',$ru['rank']))).'</small>'.
	        '<small class="d-block">Posts: '.$rp['cnt'].'</small>'.
	        '<small class="d-block">Member since: '.date($config['dateFormat'],$ru['ti']).'</small>'.
	      '</div>'.
	    '</div>'.
	  '</article>`);'.
	'</script>';
	$st=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `id`=:id");
	$st->execute([':id'=>$pid]);
	$rt=$st->fetch(PDO::FETCH_ASSOC);
	if($h==1&&$config['forumOptions'][0]==1){
		require'phpmailer/class.phpmailer.php';
		$gsu=$db->prepare("SELECT `uid`,`pid` FROM `".$prefix."forumPosts` WHERE `pid`=:pid AND `uid`!=:uid ORDER BY `ti` DESC LIMIT 1");
		$gsu->execute([
			':pid'=>$pid,
			':uid'=>$uid
		]);
		$gru=$gsu->fetch(PDO::FETCH_ASSOC);
		if($gsu->rowCount()==0||$gru['pid']==0){
			$gsu=$db->prepare("SELECT `uid`,`pid` FROM `".$prefix."forumPosts` WHERE `id`=:pid AND `uid`!=:uid ORDER BY `ti` DESC LIMIT 1");
			$gsu->execute([
				':pid'=>$pid,
				':uid'=>$uid
			]);
			$gru=$gsu->fetch(PDO::FETCH_ASSOC);
		}
		$su=$db->prepare("SELECT `id`,`username`,`name`,`email` FROM `".$prefix."login` WHERE id=:uid");
		$su->execute([':uid'=>$gru['uid']]);
		if($su->rowCount()>0){
			$ru=$su->fetch(PDO::FETCH_ASSOC);
			if($ru['email']!=''){
				$subject='Reply to Ticket '.$pid.': '.$rt['title'];
				$body='There has been a new Reply to Ticket <strong>'.$pid.'</strong> on '.date($config['dateFormat'],$ti).'.<br>'.
					'Status: <strong>'.ucwords($rt['status']).'</strong><br>'.
					'Title: '.$rt['title'].'<br>'.
					'Reply: '.filter_var($da,FILTER_UNSAFE_RAW).'<br>'.
					'URL: <a href="'.URL.'forum?cid='.$cid.'&tid='.$tid.'&pid='.$pid.'">'.URL.'forum?cid='.$cid.'&tid='.$tid.'&pid='.$pid.'</a>';
				$mail=new PHPMailer;
				$mail->isHTML(true);
				$mail->SetFrom($config['email'],$config['business']);
				$mail->Subject=$subject;
				$mail->AltBody=$body;
				$mail->AddAddress($ru['email']);
				$mail->Body=$body;
				if($mail->Send()){}else{
					echo'<script>'.
						'window.top.window.$("#addreply").prepend(`<div class="alert alert-danger">'.
							'There was an issue sending the Email Notification!'.
						'</div>`);'.
					'</script>';
				}
			}else{
				echo'<script>'.
					'window.top.window.$("#addreply").prepend(`<div class="alert alert-info">'.
						'No Email is set for the Recipient!'.
					'</div>`);'.
				'</script>';
			}
		}
	}else{
		echo'<script>'.
			'window.top.window.$("#addreply").prepend(`<div class="alert alert-info">'.
				'Email Notifications are disabled, you will need to return later to check for replies!'.
			'</div>`);'.
		'</script>';
	}
}
