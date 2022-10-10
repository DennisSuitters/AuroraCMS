<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Media
 * @package    core/add_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
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
define('ADMINNOIMAGE','core/images/noimage-sm.jpg');
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$t=filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW);
$fu=filter_input(INPUT_POST,'fu',FILTER_UNSAFE_RAW);
if($fu!=''){
	if($t=='pages'||$t=='content'){
		$file_list=explode(',',$fu);
		foreach($file_list as $file){
			$q=$db->prepare("INSERT IGNORE INTO `".$prefix."media` (`rid`,`pid`,`file`,`ti`) VALUES (:rid,:pid,:file,:ti)");
			$q->execute([
				':rid'=>$rid,
				':pid'=>$id,
				':file'=>$file,
				':ti'=>time()
			]);
			$iid=$db->lastInsertId();
			$q=$db->prepare("UPDATE `".$prefix."media` SET `ord`=:ord WHERE `id`=:id");
			$q->execute([
				':id'=>$iid,
				':ord'=>$iid+1
			]);
			if(file_exists('media/sm/'.basename($rm['file'])))
				$thumb='media/sm/'.basename($rm['file']);
			elseif(file_exists('media/'.basename($rm['file'])))
				$thumb='media/'.basename($rm['file']);
			else
				$thumb=ADMINNOIMAGE;
			echo'<script>'.
						'window.top.window.$("#mi").append(`<div id="mi_'.$iid.'" class="card stats col-6 swing-in-top-fwd">'.
							'<div class="btn-group float-right">'.
								'<div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item" onclick="return false;"><i class="i">drag</i></div>'.
								'<div class="btn" data-tooltip="tooltip" aria-label="Viewed 0 times"><i class="i">view</i> &nbsp;0</div>'.
								'<a class="btn" href="'.URL.$settings['system']['admin'].'/media/edit/'.$iid.'"><i class="i">edit</i></a>'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$iid.'\',\'media\');"><i class="i">trash</i></button>'.
							'</div>'.
							'<a class="card bg-dark m-0" data-fancybox="media" data-caption="" href="'.$file.'" style="display:flex;max-height:150px;">'.
								'<img src="'.$file.'" alt="Media '.$iid.'" style="object-fit:cover;object-position:center;">'.
							'</a>'.
						'</div>`);'.
						'window.top.window.$().fancybox({selector:`[data-fancybox="media"]`});'.
					'</script>';
		}
	}
}
