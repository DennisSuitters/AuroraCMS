<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Bookings
 * @package    core/view/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.1
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
if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsonld='<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"'.URL.'","name":"Home"}},';
  $breadit=preg_replace([
    '/<print breadcrumb=[\"\']?url[\"\']?>/',
    '/<print breadcrumb=[\"\']?title[\"\']?>/'
  ],[
    URL,
    'Home'
  ],$breaditem);
  $breaditems=$breadit;
  $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8'),$breadcurrent);
  $jsonld.='{"@type":"ListItem","position":2,"item":{"@id":"'.URL.urlencode($page['contentType']).'","name":"'.htmlspecialchars(ucfirst($page['title']),ENT_QUOTES,'UTF-8').'"}}]}</script>';
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
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$html=preg_replace([
	'/<print page=[\"\']?heading[\"\']?>/',
  $page['notes']!=''?'/<print page=[\"\']?notes[\"\']?>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<[\/]?pagenotes>/',
  '/<g-recaptcha>/'
],[
	$page['heading']==''?$page['seoTitle']:$page['heading'],
	rawurldecode($page['notes']),
  '',
  $config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''&&stristr($html,'g-recaptcha')?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':''
],$html);
$eventDate=0;
if(stristr($html,'<items>')){
  $sb=$db->query("SELECT * FROM `".$prefix."content` WHERE `bookable`='1' AND `title`!='' AND `status`='published' AND `internal`!='1' ORDER BY `code` ASC, `title` ASC");
  if($sb->rowCount()>0){
    preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
    $item=$matches[1];
    $output='';
    while($rb=$sb->fetch(PDO::FETCH_ASSOC)){
      if($rb['tie']>0){
        if(time()>$rb['tie'])continue;
      }
      if(isset($args[0])&&$args[0]==$rb['id'])$eventDate=$rb['tis'];
      $items=$item;
      $items=preg_replace([
        '/<print id>/',
        '/<print content=[\"\']?thumb[\"\']?>/',
        '/<print content=[\"\']?imageALT[\"\']?>/',
        '/<print content=[\"\']?title[\"\']?>/',
        '/<itemChecked>/',
        '/<itemHidden>/'
      ],[
        $rb['id'],
        $rb['file']!=''&&file_exists('media/'.'thumbs'.basename($rb['file']))?'media/'.'thumbs/'.basename($rb['file']):NOIMAGESM,
        $rb['fileALT']!=''?$rb['fileeALT']:$rb['title'],
        $rb['title'],
        isset($args[0])&&$args[0]==$rb['id']?'checked':'',
        isset($args[0])&&$args[0]!=$rb['id']?'d-none':''
      ],$items);
      $output.=$items;
    }
    $html=preg_replace([
      '~<items>.*?<\/items>~is',
      '~<serviceselect>.*?<\/serviceselect>~is',
      '/<[\/]?bookservices>/'
    ],[
      $output,
      '',
      '',
      ''
    ],$html);
  }else$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
}else{
  $sb=$db->query("SELECT * FROM `".$prefix."content` WHERE `bookable`='1' AND `title`!='' AND `status`='published' AND `internal`!='1' ORDER BY `code` ASC, `title` ASC");
  if($sb->rowCount()>0){
    $bookable='';
    while($rb=$sb->fetch(PDO::FETCH_ASSOC)){
      $bookable.='<option value="'.$rb['id'].'"'.($rb['id']==$args[0]?' selected':'').'>'.htmlspecialchars(ucfirst($rb['contentType']),ENT_QUOTES,'UTF-8').($rb['code']!=''?':'.htmlspecialchars($rb['code'],ENT_QUOTES,'UTF-8'):'').':'.htmlspecialchars($rb['title'],ENT_QUOTES,'UTF-8').'</option>';
    }
    $html=preg_replace([
      '/<serviceoptions>/',
      '/<[\/]?bookservices>/'
    ],[
      $bookable,
      ''
    ],$html);
  }else$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
}
$html=preg_replace([
  '/<print currentdate>/',
  '/<itemreadonly>/'
],[
  ($eventDate>0?date('Y-m-d\TH:i',$eventDate):date('Y-m-d\TH:i',time())),
  ($eventDate>0?'readonly':'')
],$html);
$content.=$html;
