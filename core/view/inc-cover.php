<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Include - Cover
 * @package    core/view/inc-cover.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.16
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(stristr($html,'<cover>')){
	$coverHTML='';
	$iscover=false;
	if($page['coverVideo']!=''){
		$cover=basename(rawurldecode($page['coverVideo']));
		if(stristr($page['coverVideo'],'youtu')){
			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$page['coverVideo'],$vidMatch);
			$coverHTML='<div class="embed-responsive embed-responsive-16by9">'.
				'<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.
					($page['options'][0]==1?'autoplay=1&mute=1&':'').
					($page['options'][1]==1?'loop=1&':'').
					($page['options'][2]==1?'controls=1&':'controls=0&').
				'" frameborder="0" allow="accelerometer;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>'.
			'</div>';
 		}elseif(stristr($page['coverVideo'],'vimeo')){
			preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$page['coverVideo'],$vidMatch);
			$coverHTML='<div class="embed-responsive embed-responsive-16by9">'.
				'<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.
					($page['options'][0]==1?'autoplay=1&':'').
					($page['options'][1]==1?'loop=1&':'').
					($page['options'][2]==1?'controls=1&':'controls=0&').
				'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>'.
			'</div>'.
			'<script src="https://player.vimeo.com/api/player.js"></script>';
		}else{
			$coverHTML='<div class="embed-responsive embed-responsive-16by9">'.
				'<video class="embed-responsive-item" preload autoplay loop muted>'.
					'<source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4">'.
				'</video>'.
			'</div>';
		}
	}
	if($page['cover']!=''&&$coverHTML==''){
		$cover=basename($page['cover']);
		if(file_exists('media/'.$cover)){
			$coverHTML='<img srcset="'.
			(file_exists('media/'.$cover)?'<img srcset="'.
				(file_exists('media/'.basename($cover))?'media/lg/'.$cover.' '.$config['mediaMaxWidth'].'w,':'').
				(file_exists('media/lg/'.basename($cover))?'media/lg/'.$cover.' 1000w,':'').
				(file_exists('media/md/'.basename($cover))?'media/md/'.$cover.' 600w,':'').
				(file_exists('media/sm/'.basename($cover))?'media/sm/'.$cover.' 400w,':'').
				(file_exists('media/sm/'.basename($cover))?'media/sm/'.$cover.' '.$config['mediaMaxWidthThumb'].'w':'').
			'" src="media/'.$cover.'" sizes="(min-width: '.$config['mediaMaxWidth'].'px) '.$config['mediaMaxWidth'].'px" loading="lazy" alt="'.$page['title'].' Cover Image">'.
				($page['attributionImageTitle']!=''?
					'<figcaption>'.
						$page['attributionImageTitle'].
						($page['attributionImageName']!=''?
							' by '.
								($page['attributionImageURL']!=''?'<a target="_blank" href="'.$page['attributionImageURL'].'">':'').
								$page['attributionImageName'].
								($page['attributionImageURL']!=''?'</a>':'')
						:'').
					'</figcaption>'
				:'')
			:'');
			$iscover=true;
		}
	}
	$html=preg_replace([
		$coverHTML==''?'~<cover>.*?</cover>~is':'/<[\/]?cover>/',
		'/<print page=[\"\']?coverItem[\"\']?>/'
	],[
		'',
		$coverHTML
	],$html);
}
