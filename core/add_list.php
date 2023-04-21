<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add List
 * @package    core/add_list.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$rid=filter_input(INPUT_POST,'rid',FILTER_UNSAFE_RAW);
$lid=filter_input(INPUT_POST,'lid',FILTER_UNSAFE_RAW);
$lh=filter_input(INPUT_POST,'lh',FILTER_UNSAFE_RAW);
$li=filter_input(INPUT_POST,'li',FILTER_UNSAFE_RAW);
$lu=filter_input(INPUT_POST,'lu',FILTER_UNSAFE_RAW);
$lda=filter_input(INPUT_POST,'lda',FILTER_UNSAFE_RAW);
$ti=time();
if($lda=='')echo'<script>window.top.window.toastr["error"]("The Notes field must contain data!");</script>';
else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`rid`,`code`,`contentType`,`title`,`file`,`urlSlug`,`notes`,`ti`) VALUES (:rid,:lid,'list',:title,:file,:url,:notes,:ti)");
	$q->execute([
		':rid'=>$rid,
		':lid'=>$lid,
		':title'=>$lh,
		':file'=>$li,
		':url'=>$lu,
		':notes'=>$lda,
		':ti'=>$ti
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
		$s=$db->prepare("UPDATE `".$prefix."content` SET `ord`=:id WHERE `id`=:id");
		$s->execute([':id'=>$id]);
		echo'<script>'.
					'window.top.window.$("#list").append(`<div id="l_'.$id.'" class="card col-12 mx-0 my-1 m-sm-1 overflow-visible">'.
						'<div class="row">'.
							($li!=''?'<div class="card-image col-12 col-sm-2 h-auto"><img src="'.$li.'" style="max-height:100px;" alt="'.$lh.'"></div>':'').
							'<div class="card-footer col-12 col-sm m-0 p-1">'.
								'<div class="row m-0 p-0">'.
									'<div class="col-12 small m-0 p-0">'.
										($lh!=''?'<div class="h6 col-12">'.$lh.'</div>':'').
										$lda.
										($lu!=''?' <a target="_blank" href="'.$lu.'">More...</a>':'').
									'</div>'.
									'<div class="col-12 text-right">'.
										'<a class="btn-sm" href="'.URL.$settings['system']['admin'].'/content/edit/'.$id.'" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
										'<form class="d-inline" target="sp" action="core/purge.php">'.
											'<input name="id" type="hidden" value="'.$id.'">'.
											'<input name="t" type="hidden" value="content">'.
											'<button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
										'</form>'.
										'<span class="btn btn-sm orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>'.
									'</div>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>`);'.
				'</script>';
	}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Data!");</script>';
}
