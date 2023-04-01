<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Paylist
 * @package    core/add_playlist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$ti=time();
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
	if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
	if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$fu=filter_input(INPUT_POST,'fu',FILTER_UNSAFE_RAW);
if($fu!=''){
	$file_list=explode(',',$fu);
	$vidarray=[
		'rid'=>$rid,
		'width'=>'',
		'a_name'=>'',
		'a_url'=>'',
		'version'=>'',
		'p_url'=>'',
		'p_name'=>'',
		'th_width'=>'',
		'th_url'=>'',
		'height'=>'',
		'th_height'=>'',
		'html'=>'',
		'url'=>'',
		'embed_url'=>'',
		'type'=>'',
		'title'=>'',
		'notes'=>'',
		'dt'=>date('c',$ti),
		'ti'=>$ti
	];
	foreach($file_list as $file){
		if(stristr($file,'youtu')){
			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$file,$vidMatch);
			$video='https://www.youtube.com/embed/'.$vidMatch[0];
			if($config['gd_api']!=''){
				$vidinfo = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=".$vidMatch[0]."&key=".$config['gd_api']);
				$vidinfo_json = json_decode($vidinfo,true);
				$vidinfo2 = file_get_contents("https://noembed.com/embed?url=".$file);
				$vidinfo_json2 = json_decode($vidinfo2, true);
				$vidarray=[
					'width'=>$vidinfo_json2['width'],
					'a_name'=>$vidinfo_json['items'][0]['snippet']['channelTitle'],
					'a_url'=>$vidinfo_json2['author_url'],
					'version'=>$vidinfo_json2['version'],
					'p_url'=>$vidinfo_json2['provider_url'],
					'p_name'=>$vidinfo_json2['provider_name'],
					'th_width'=>$vidinfo_json['items'][0]['snippet']['thumbnails']['maxres']['height'],
					'th_url'=>$vidinfo_json['items'][0]['snippet']['thumbnails']['maxres']['url'],
					'height'=>$vidinfo_json2['height'],
					'th_height'=>$vidinfo_json['items'][0]['snippet']['thumbnails']['maxres']['high'],
					'html'=>$vidinfo_json2['html'],
					'url'=>$vidinfo_json2['url'],
					'embed_url'=>$video,
					'type'=>$vidinfo_json2['type'],
					'title'=>$vidinfo_json['items'][0]['snippet']['title'],
					'notes'=>$vidinfo_json['items'][0]['snippet']['description'],
					'dt'=>$vidinfo_json['items'][0]['snippet']['publishedAt']
				];
			}else{
				$vidinfo = file_get_contents("https://noembed.com/embed?url=".$file);
				$vidinfo_json = json_decode($vidinfo, true);
				$vidarray=[
					'width'=>$vidinfo_json['width'],
					'a_name'=>$vidinfo_json['author_name'],
					'a_url'=>$vidinfo_json['author_url'],
					'version'=>$vidinfo_json['version'],
					'p_url'=>$vidinfo_json['provider_url'],
					'p_name'=>$vidinfo_json['provider_name'],
					'th_width'=>$vidinfo_json['thumbnail_width'],
					'th_url'=>$vidinfo_json['thumbnail_url'],
					'height'=>$vidinfo_json['height'],
					'th_height'=>$vidinfo_json['thumbnail_height'],
					'html'=>$vidinfo_json['html'],
					'url'=>$vidinfo_json['url'],
					'embed_url'=>$video,
					'type'=>$vidinfo_json['type']!=''?$vidinfo_json['type']:'Video',
					'title'=>$vidinfo_json['title'],
					'notes'=>$vidinfo_json['title']
				];
			}
		}elseif(stristr($file,'vimeo')){
			preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$file,$vidMatch);
			$video='https://player.vimeo.com/video/'.$vidMatch[5];
			$vidinfo = file_get_contents("https://noembed.com/embed?url=".$file);
			$vidinfo_json = json_decode($vidinfo, true);
			$vidarray=[
				'width'=>$vidinfo_json['width'],
				'a_name'=>$vidinfo_json['author_name'],
				'a_url'=>$vidinfo_json['author_url'],
				'version'=>$vidinfo_json['version'],
				'p_url'=>$vidinfo_json['provider_url'],
				'p_name'=>$vidinfo_json['provider_name'],
				'th_width'=>$vidinfo_json['thumbnail_width'],
				'th_url'=>$vidinfo_json['thumbnail_url'],
				'height'=>$vidinfo_json['height'],
				'th_height'=>$vidinfo_json['thumbnail_height'],
				'html'=>$vidinfo_json['html'],
				'url'=>$vidinfo_json['url'],
				'embed_url'=>$video,
				'type'=>$vidinfo_json['type']!=''?$vidinfo_json['type']:'Video',
				'title'=>$vidinfo_json['title'],
				'notes'=>$vidinfo_json['title']
			];
		}else{
			$video=$file;
			$vidinfo = file_get_contents("https://noembed.com/embed?url=".$file);
			$vidinfo_json = json_decode($vidinfo, true);
			$vidarray=[
				'width'=>$vidinfo_json['width'],
				'a_name'=>$vidinfo_json['author_name'],
				'a_url'=>$vidinfo_json['author_url'],
				'version'=>$vidinfo_json['version'],
				'p_url'=>$vidinfo_json['provider_url'],
				'p_name'=>$vidinfo_json['provider_name'],
				'th_width'=>$vidinfo_json['thumbnail_width'],
				'th_url'=>$vidinfo_json['thumbnail_url'],
				'height'=>$vidinfo_json['height'],
				'th_height'=>$vidinfo_json['thumbnail_height'],
				'html'=>$vidinfo_json['html'],
				'url'=>$vidinfo_json['url'],
				'embed_url'=>$video,
				'type'=>$vidinfo_json['type'],
				'title'=>$vidinfo_json['title'],
				'notes'=>$vidinfo_json['title']
			];
		}
		$q=$db->prepare("INSERT IGNORE INTO `".$prefix."playlist`
		(`rid`,`width`,`author_name`,`author_url`,`version`,`provider_url`,`provider_name`,`thumbnail_width`,`thumbnail_url`,`height`,`thumbnail_height`,`html`,`url`,`embed_url`,`type`,`title`,`notes`,`dt`,`ti`) VALUES
		(:rid,:width,:a_name,:a_url,:version,:p_url,:p_name,:th_width,:th_url,:height,:th_height,:html,:url,:embed_url,:type,:title,:notes,:dt,:ti)");
		$q->execute([
			':rid'=>$rid,
			':width'=>$vidarray['width'],
			':a_name'=>isset($vidarray['a_name'])&&$vidarray['a_name']!=''?$vidarray['a_name']:'',
			':a_url'=>$vidarray['a_url'],
			':version'=>$vidarray['version'],
			':p_url'=>$vidarray['p_url'],
			':p_name'=>$vidarray['p_name'],
			':th_width'=>$vidarray['th_width'],
			':th_url'=>$vidarray['th_url'],
			':height'=>$vidarray['height'],
			':th_height'=>$vidarray['th_height'],
			':html'=>$vidarray['html'],
			':url'=>$vidarray['url'],
			':embed_url'=>$video,
			':type'=>$vidarray['type'],
			':title'=>$vidarray['title'],
			':notes'=>$vidarray['notes'],
			':dt'=>$vidarray['dt']!=''?$vidarray['dt']:date('c',$ti),
			':ti'=>isset($vidarray['ti'])&&$vidarray['ti']!=0?$vidarray['ti']:$ti
		]);
		$iid=$db->lastInsertId();
		$q=$db->prepare("UPDATE `".$prefix."playlist` SET `ord`=:ord WHERE `id`=:id");
		$q->execute([
			':id'=>$iid,
			':ord'=>$iid+1
		]);
		echo'<script>'.
					'window.top.window.$("#pi").append(`<div class="play items card gallery col-6 col-sm-3 m-0 border-0" id="pi_'.$iid.'">'.
						'<img src="'.$vidarray['th_url'].'">'.
						'<div class="btn-group tools">'.
							'<a href="'.URL.$settings['system']['admin'].'/playlist/edit/'.$iid.'" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
							'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$iid.'\',\'playlist\');"><i class="i">trash</i></button>'.
							'<div class="handle btn" data-tooltip="left" aria-label="Drag to Reorder"><i class="i">drag</i></div>'.
						'</div>'.
					'</div>`);'.
				'</script>';
	}
}
