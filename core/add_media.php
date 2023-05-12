<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Media
 * @package    core/add_media.php
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
define('ADMINNOIMAGE','core/images/noimage-sm.jpg');
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$t=filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW);
$fu=filter_input(INPUT_POST,'fu',FILTER_UNSAFE_RAW);
if($fu!=''){
	if($t=='pages'||$t=='content'){
		$file_list=explode(',',$fu);
		foreach($file_list as $file){
			if(stristr($file,'youtu')){
      	preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$file,$vidMatch);
				$thumb='https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg';
			}else
				$thumb='';
			$q=$db->prepare("INSERT IGNORE INTO `".$prefix."media` (`rid`,`pid`,`file`,`thumb`,`ti`) VALUES (:rid,:pid,:file,:thumb,:ti)");
			$q->execute([
				':rid'=>$rid,
				':pid'=>$id,
				':file'=>$file,
				':thumb'=>$thumb,
				':ti'=>time()
			]);
			$iid=$db->lastInsertId();
			$q=$db->prepare("UPDATE `".$prefix."media` SET `ord`=:ord WHERE `id`=:id");
			$q->execute([
				':id'=>$iid,
				':ord'=>$iid+1
			]);
			echo'<script>'.
						'window.top.window.$("#mi").append(`<div id="mi_'.$iid.'" class="card stats gallery col-12 col-sm-3 m-0 border-0">';
						if(stristr($file,'youtu')){
							preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$file,$vidMatch);
							echo'<div class="note-video-wrapper video" data-fancybox="media" href="'.$file.'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
								'<img class="note-video-clip" src="'.$thumb.'">'.
								'<div class="play"></div>'.
							'</div>';
						}elseif(stristr($file,'vimeo')){
							preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$file,$vidMatch);
							echo'<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.
								($r['options'][0]==1?'autoplay=1&':'').
								($r['options'][1]==1?'loop=1&':'').
								($r['options'][2]==1?'controls=1&':'controls=0&').
									'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>'.
							'<script src="https://player.vimeo.com/api/player.js"></script>';
						}else
							echo'<a data-fancybox="media" href="'.$file.'"><img src="'.$thumb.'" alt="Media '.$iid.'"></a>';

						echo'<div class="btn-group tools">'.
								'<div class="btn" data-tooltip="right" aria-label="0 views"><small>0</small></div>'.
								'<a href="'.URL.$settings['system']['admin'].'/media/edit/'.$iid.'" role="button"><i class="i">edit</i></a>'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$iid.'\',\'media\');"><i class="i">trash</i></button>'.
								'<div class="btn handle" data-tooltip="left" aria-label="Drag to Reorder" onclick="return false;"><i class="i">drag</i></div>'.
							'</div>'.
						'</div>`);'.
						'window.top.window.$().fancybox({selector:`[data-fancybox="media"]`});'.
					'</script>';
		}
	}
}
