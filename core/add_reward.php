<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Reward
 * @package    core/add_reward.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
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
$ti=time();
$uid=isset($_POST['uid'])?filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT):0;
$code=filter_input(INPUT_POST,'code',FILTER_UNSAFE_RAW);
$title=filter_input(INPUT_POST,'title',FILTER_UNSAFE_RAW);
$method=filter_input(INPUT_POST,'method',FILTER_SANITIZE_NUMBER_INT);
$value=filter_input(INPUT_POST,'value',FILTER_SANITIZE_NUMBER_INT);
$quantity=filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_NUMBER_INT);
$tis=filter_input(INPUT_POST,'tisx',FILTER_UNSAFE_RAW);
$tie=filter_input(INPUT_POST,'tiex',FILTER_UNSAFE_RAW);
if($tis<$ti)$tis=0;
if($tie<$ti)$tie=0;
if($code!=''&&$title!=''&&$value!=0&&$quantity!=0){
	$q=$db->prepare("SELECT `code` FROM `".$prefix."rewards` WHERE `code`=:code");
	$q->execute([':code'=>$code]);
	if($q->rowCount()>0){
		echo'<script>window.top.window.toastr["error"]("A Reward with the Code <strong>'.$code.'</strong> already exists!");</script>';
	}else{
		$q=$db->prepare("INSERT IGNORE INTO `".$prefix."rewards` (`uid`,`code`,`title`,`method`,`value`,`quantity`,`used`,`tis`,`tie`,`ti`) VALUES (:uid,:code,:title,:method,:value,:quantity,0,:tis,:tie,:ti)");
		$q->execute([
			':uid'=>$uid,
			':code'=>$code,
			':title'=>$title,
			':method'=>$method,
			':value'=>$value,
			':quantity'=>$quantity,
			':tis'=>$tis,
			':tie'=>$tie,
			':ti'=>$ti
		]);
		$id=$db->lastInsertId();
		$e=$db->errorInfo();
		if(is_null($e[2])){
			if($uid>0){
				$su=$db->prepare("SELECT `id`,`username`,`name`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
				$su->execute([
					':id'=>$uid
				]);
				$ru=$su->fetch(PDO::FETCH_ASSOC);
			}
			echo'<script>'.
						'window.top.window.$("#rewards").append(`<div class="row" id="l_'.$id.'">'.
							'<article class="card zebra m-0 p-0 py-1 small overflow-visible card-list item shadow add-item">'.
								'<div class="row">'.
									'<div class="col-12 col-md pl-2">'.($uid>0?($ru['name']!=''?'<div data-tooltip="tooltip" aria-label="Name">'.$ru['name'].'</div>':'').'<div data-tooltip="tooltip" aria-label="Username">'.$ru['username'].'</div><div class="badger badge-'.rank($ru['rank']).'">'.ucwords(rank($ru['rank'])).'</div>':'<span class="badger badge-visitor mt-2">Anyone</span>').'</div>'.
									'<div class="col-12 col-md text-center pt-2">'.$code.'</div>'.
									'<div class="col-12 col-md text-center pt-2">'.$title.'</div>'.
									'<div class="col-12 col-md text-center pt-2">'.($method==0?'% Off':'$ Off').'</div>'.
									'<div class="col-12 col-md text-center pt-2">'.$value.'</div>'.
									'<div class="col-12 col-md text-center pt-2"><span data-tooltip="tooltip" aria-label="Used">0</span>'.($quantity>0?'/'.$quantity:'').'</div>'.
									'<div class="col-12 col-md-2 text-center pt-2">'.($tis!=0?date($config['dateFormat'],$tis):'').'</div>'.
									'<div class="col-12 col-md-2 text-center pt-2">'.($tie!=0?date($config['dateFormat'],$tie):'No Set Limit').'</div>'.
									'<div class="col-12 col-md-1 pr-2 text-right">'.
										'<form target="sp" action="core/purge.php">'.
											'<input name="id" type="hidden" value="'.$id.'">'.
											'<input name="t" type="hidden" value="rewards">'.
											'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
										'</form>'.
									'</did>'.
								'</div>'.
							'</article>'.
						'</div>`);'.
					'</script>';
		}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Reward!");</script>';
	}
}else echo'<script>window.top.window.toastr["error"]("Some required fields are empty!");</script>';
