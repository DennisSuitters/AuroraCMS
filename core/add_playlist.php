<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Paylist
 * @package    core/add_playlist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.6
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
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$fu=filter_input(INPUT_POST,'fu',FILTER_SANITIZE_STRING);
if($fu!=''){
	$file_list=explode(',',$fu);
	foreach($file_list as $file){
		if(stristr($file,'youtu')){
			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$file,$vidMatch);
			$video='https://www.youtube.com/embed/'.$vidMatch[0];
		}elseif(stristr($file,'vimeo')){
			preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$file,$vidMatch);
			$video='https://player.vimeo.com/video/'.$vidMatch[5];
		}else{
			$video=$file;
		}
		$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`url`,`ti`) VALUES (:rid,'playlist',:url,:ti)");
		$q->execute([
			':rid'=>$rid,
			':url'=>$video,
			':ti'=>time()
		]);
		$iid=$db->lastInsertId();
		$q=$db->prepare("UPDATE `".$prefix."choices` SET `ord`=:ord WHERE `id`=:id");
		$q->execute([
			':id'=>$iid,
			':ord'=>$iid+1
		]);
		echo'<script>'.
					'window.top.window.$("#pi").append(`<div class="play items col-11 col-sm-4 p-3 mx-auto" id="pi_'.$iid.'">'.
						'<iframe width="100%" height="300" src="'.$video.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'.
							'<div class="btn-group float-right">'.
								'<div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item">'.svg2('drag').'</div>'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$iid.'\',\'playlist\');">'.svg2('trash').'</button>'.
							'</div>'.
					'</div>`);'.
				'</script>';
	}
}
