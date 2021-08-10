<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - FAQ
 * @package    core/view/faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.8
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
			$coverHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.
				($page['options'][0]==1?'autoplay=1&mute=1&':'').
				($page['options'][1]==1?'loop=1&':'').
				($page['options'][2]==1?'controls=1&':'controls=0&').
			'" frameborder="0" allow="accelerometer;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe></div>';
 	}elseif(stristr($page['coverVideo'],'vimeo')){
			preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$page['coverVideo'],$vidMatch);
			$coverHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.
				($page['options'][0]==1?'autoplay=1&':'').
				($page['options'][1]==1?'loop=1&':'').
				($page['options'][2]==1?'controls=1&':'controls=0&').
			'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
		}else
			$coverHTML='<div class="embed-responsive embed-responsive-16by9"><video class="embed-responsive-item" preload autoplay loop muted><source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video></div>';
	}
	if($page['cover']!=''&&$coverHTML==''){
		$cover=basename($page['cover']);
		if(file_exists('media/'.$cover)){
			$coverHTML='<img srcset="'.
			(file_exists('media/'.$cover)?'<img srcset="'.
				(file_exists('media/'.basename($cover))?'media/'.'lg/'.$cover.' '.$config['mediaMaxWidth'].'w,':'').
				(file_exists('media/'.'lg/'.basename($cover))?'media/'.'lg/'.$cover.' 1000w,':'').
				(file_exists('media/'.'md/'.basename($cover))?'media/'.'md/'.$cover.' 600w,':'').
				(file_exists('media/'.'sm/'.basename($cover))?'media/'.'sm/'.$cover.' 400w,':'').
				(file_exists('media/'.'thumbs/'.basename($cover))?'media/'.'thumbs/'.$cover.' '.$config['mediaMaxWidthThumb'].'w':'').
			'" src="media/'.$cover.'" loading="lazy" alt="'.$page['title'].' Cover Image">'.
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
if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsoni=1;
  $jsonld='<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"'.URL.'","name":"Home"}},';
  $breadit=preg_replace([
   '/<print breadcrumb=[\"\']?url[\"\']?>/',
   '/<print breadcrumb=[\"\']?title[\"\']?>/'
  ],[
   URL,
   'Home'
  ],$breaditem);
  $breaditems=$breadit;
  $jsoni++;
  $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8'),$breadcurrent);
  $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.
    URL.urlencode($page['contentType']).'/","name":"'.
    htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8').'"}}]}</script>';
  $breaditems.=$breadit;
  $html=preg_replace([
    '/<[\/]?breadcrumb>/',
    '/<json-ld-breadcrumb>/',
    '~<breaditems>.*?<\/breaditems>~is',
    '~<breadcurrent>.*?<\/breadcurrent>~is'
  ],[
    '',
    $jsonld,
    $breaditems,
    ''
  ],$html);
}
$html=preg_replace([
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<print page=[\"\']?notes[\"\']?>/',
],[
  '',
	rawurldecode($page['notes']),
],$html);
$faqs='';
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $faq=$matches[1];
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='faq' ORDER BY `title` ASC");
  $s->execute();
	$i=$s->rowCount();
	$ii=0;
  $output='';
	$schema='<script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $faqs=$faq;
    $faqs=preg_replace([
			'/<print content=[\"\']?title[\"\']?>/',
			'/<print content=[\"\']?notes[\"\']?>/'
    ],[
      htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
      $r['notes']
    ],$faqs);
    $output.=$faqs;
		$ii++;
		$schema.='{"@type":"Question","name":"'.$r['title'].'","acceptedAnswer":{"@type":"Answer","text": "'.strip_tags($r['notes']).'"}}'.($ii<$i?',':'');
  }
	$schema.=']}</script>';
	$faqs=preg_replace('~<items>.*?<\/items>~is',$schema.$output,$html,1);
}
$content.=$faqs;
