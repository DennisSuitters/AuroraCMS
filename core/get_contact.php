<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Get Contact
 * @package    core/get_contact.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
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
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
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
function _agologgedin($time){
	if($time==0)$timeDiff='Never';
	else{
		$fromTime=$time;
		$timeDiff=floor(abs(time()-$fromTime)/60);
		if($timeDiff<2)$timeDiff='Online Now';
		elseif($timeDiff>2&&$timeDiff<60)$timeDiff=floor(abs($timeDiff)).' Minutes Ago';
		elseif($timeDiff>60&&$timeDiff<120)$timeDiff=floor(abs($timeDiff/60)).' Hour Ago';
		elseif($timeDiff<1440)$timeDiff=floor(abs($timeDiff/60)).' Hours Ago';
		elseif($timeDiff>1440&&$timeDiff<2880)$timeDiff=floor(abs($timeDiff/1440)).' Day Ago';
		elseif($timeDiff>2880)$timeDiff=floor(abs($timeDiff/1440)).' Days Ago';
	}
	return$timeDiff;
}
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$edit=filter_input(INPUT_GET,'edit',FILTER_SANITIZE_NUMBER_INT);
$del=filter_input(INPUT_GET,'del',FILTER_SANITIZE_NUMBER_INT);
$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$su->execute([':id'=>$id]);
if($su->rowCount()>0){
  $user=$su->fetch(PDO::FETCH_ASSOC);
  echo'<div id="l_'.$id.'"><div class="row border-bottom p-2">'.
    '<div class="col py-2">'.
      '<strong>Contact Details</strong>'.
    '</div>'.
    '<div class="col-2 text-right">'.
      '<div class="btn-group">'.
        ($edit==1?'<a class="btn" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'].'#tab1-2" data-tooltip="left" aria-label="Edit"><i class="i">edit</i></a>':'').
        ($del==1?'<form target="sp" method="post" action="core/removecontact.php"><input type="hidden" name="id" value="'.$user['id'].'"><button class="trash" type="submit" data-tooltip="left" aria-label="Delete"><i class="i">delete</i></button></form>':'').
      '</div>'.
    '</div>'.
  '</div>'.
  '<div class="row">'.
    '<div class="col-2 p-3">'.
      '<img class="rounded" src="'.($user['avatar']!=''?'media/avatar/'.$user['avatar']:'core/images/noavatar.jpg').'" style="width:80px;max-height:80px;">'.
    '</div>'.
    '<div class="col p-3 pt-4">'.
      '<div class=""><strong>'.($user['name']!=''?$user['name']:$user['username']).'</strong></div>'.
      ($user['jobtitle']!=''?'<div class="text-muted">'.$user['jobtitle'].'</div>':'').
      ($user['business']!=''?'<div class="text-muted">'.$user['business'].'</div>':'').
    '</div>'.
    '<div class="col p-3">'.
      '<div class="small text-muted">Account Details</div>'.
      '<div><span class="badger badge-'.rank($user['rank']).'">'.ucwords(str_replace('-',' ',rank($user['rank']))).'</span></div>'.
      ($user['spent']!=0?'<div class="small"><span class="text-muted">Spent: </span>&dollar;'.$user['spent'].'</div>':'').
      ($user['points']!=0?'<div class="small"><span class="text-muted">Points: </span>'.$user['points'].'</div>':'').
      ($user['lti']!=0?'<div class="small"><span class="text-muted">Active: </span>'._agologgedin($user['lti']).'</div>':'').
    '</div>'.
    '<div class="col p-3">'.
      '<div class="small text-muted">Social Media</div>';
      $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=:uid ORDER BY `icon` ASC");
      $ss->execute([':uid'=>$user['id']]);
      while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
        echo'<a class="m-1" href="'.$rs['url'].'"><i class="i i-3x i-social social-'.$rs['icon'].'">social-'.$rs['icon'].'</i></a>';
      }
    echo'</div>'.
  '</div>'.
  '<div class="row">'.
    '<div class="col p-3">'.
      '<div class="small text-muted">Phone Numbers</div>'.
      ($user['phone']!=''?'<div><a class="text-black" href="tel:'.$user['phone'].'">'.$user['phone'].'</a></div>':'').
      ($user['mobile']!=''?'<div><a class="text-black" href="tel:'.$user['mobile'].'">'.$user['mobile'].'</a></div>':'').
    '</div>'.
    '<div class="col p-3">'.
      '<div class="small text-muted">Email</div>'.
      ($user['email']!=''?'<div><a class="text-black" href="mailto:'.$user['email'].'">'.$user['email'].'</a></div>':'').
    '</div>'.
    '<div class="col p-3">'.
      '<div class="small text-muted">Address</div>'.
      ($user['address']!=''?'<div>'.$user['address'].',</div>':'').
      ($user['suburb']!=''?'<div>'.$user['suburb'].','.($user['postcode']!=0?' '.$user['postcode'].',':'').'</div>':'').
      ($user['state']!=''?'<div>'.$user['state'].','.($user['country']!=''?' '.$user['country']:'').'</div>':'').
    '</div>'.
  '</div>'.
  '<div class="row">'.
    '<div class="col-12 px-3 pb-3">'.
      '<div class="small text-muted">Notes</div>'.
      ($user['notes']!=''?$user['notes']:'').
    '</div>'.
  '</div></div>';
}else
  echo'failed';
