<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Parser Items
 * @package    core/parser_items.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
$contentType=$view;
$rowItems=$s->rowCount();
$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
$skip=false;
if(stristr($html,'<settings')){
	preg_match('/<settings.*itemCount=[\"\'](.+?)[\"\'].*>/',$html,$match);
	$itemCount=(int)(isset($match[1])?
		($match[1]>0||$match[1]!='all'?$match[1]:$config['showItems'])
	:$config['showItems']);
	preg_match('/<settings.*contentType=[\"\'](.*?)[\"\'].*>/',$html,$match);
	$contentType=isset($match[1])&&($match[1]!='all')?$match[1]:'%';
	$html=preg_replace('~<settings.*?>~is','',$html,1);
}else{
	$itemCount=$config['showItems'];
	$contentType='%';
}
$html=preg_replace([
	'/<print view>/',
	'/<print content=[\"\']?category[\"\']?>/',
	'/<print search>/'
],[
	$view,
	isset($args[0])?($args[0]!=''?html_entity_decode((string)$args[0]):''):'',
	(isset($search)&&$search!=''?trim(str_replace('%',' ',(string)$search),' '):'')
],$html);
require'view/inc-breadcrumbs.php';
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
				'<video class="embed-responsive-item" preload autoplay loop muted><source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video>'.
			'</div>';
		}
	}
	if($page['cover']!=''&&$coverHTML==''){
		$cover=basename($page['cover']);
		$coverHTML='<img srcset="'.
			(file_exists('media/lg/'.basename($cover))?'media/lg/'.$cover.' 1000w,':'').
			(file_exists('media/md/'.basename($cover))?'media/md/'.$cover.' 600w,':'').
			(file_exists('media/sm/'.basename($cover))?'media/sm/'.$cover.' 400w,':'').
			(file_exists('media/sm/'.basename($cover))?'media/sm/'.$cover.' '.$config['mediaMaxWidthThumb'].'w':'').
		'" src="'.$page['cover'].'" sizes="(min-width: '.$config['mediaMaxWidth'].'px) '.$config['mediaMaxWidth'].'px" alt="'.$page['title'].' Cover Image">'.
		($page['attributionImageTitle']!=''?
			'<figcaption>'.
				($page['attributionImageTitle']!=''?$page['attributionImageTitle']:'').
				($page['attributionImageName']!=''?' by '.
						($page['attributionImageURL']!=''?'<a target="_blank" href="'.$page['attributionImageURL'].'" rel="noopener noreferrer">':'').
						$page['attributionImageName'].
						($page['attributionImageURL']!=''?'</a>':'').
				(stristr($page['attributionImageURL'],'unsplash.com')?' on <a target="_blank" href="https://unsplash.com/?utm_source='.$config['unsplash_appname'].'&utm_medium=referral">Unsplash</a>':''):'').
			'</figcaption>'
		:'');
		$iscover=true;
	}
	$html=preg_replace([
		$coverHTML==''?'~<cover>.*?</cover>~is':'/<[\/]?cover>/',
		'/<print page=[\"\']?coverItem[\"\']?>/'
	],[
		'',
		$coverHTML
	],$html);
}
if(stristr($html,'<map>')){
	$html=preg_replace([
		($config['options'][27]==1&&$config['geo_position']!=''&&$config['mapapikey']!=''?'/<\/map>/':'~<map>.*?<\/map>~is'),
		'/<map>/'
	],[
		($config['options'][27]==1&&$config['geo_position']!=''&&$config['mapapikey']!=''?'<script src="core/js/leaflet/leaflet.js"></script><script>var map=L.map("map",{zoomControl:false}).setView(['.$config['geo_position'].'],13);L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='.$config['mapapikey'].'",{attribution:`Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>`,id:"mapbox/streets-v11",tileSize:512,zoomOffset:-1,accessToken:`'.$config['mapapikey'].'`,}).addTo(map);var marker=L.marker(['.$config['geo_position'].'],{draggable:false}).addTo(map);'.($config['business']==''?'':'var popupHtml=`<strong>'.$config['business'].'</strong>'.($config['address']==''?'':'<br><small>'.$config['address'].'<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country'].'</small>').'`;marker.bindPopup(popupHtml,{closeButton:false,closeOnClick:false,closeOnEscapeKey:false,autoClose:false}).openPopup();').'map.dragging.disable();map.touchZoom.disable();map.doubleClickZoom.disable();map.scrollWheelZoom.disable();marker.off("click");</script>':''),
		''
	],$html);
}
if(stristr($html,'<mediaitems')){
	$sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `pid`=:pid AND `rid`=0 AND `rank`<=:rank ORDER BY `ord` ASC");
	$sm->execute([
		':pid'=>$page['id'],
		':rank'=>$_SESSION['rank']
	]);
	if($sm->rowCount()>0){
		preg_match('/<mediaitems>([\w\W]*?)<\/mediaitems>/',$html,$matches2);
		$media=$matches2[1];
		preg_match('/<mediaimages>([\w\W]*?)<\/mediaimages>/',$media,$matches3);
		$mediaitem=$matches3[1];
		$mediaoutput='';
		while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
			$mediaitems=$mediaitem;
			if($rm['file']=='')continue;
			$rm['file']=rawurldecode($rm['file']);
			$mediaitems=preg_replace([
				'/<print thumb=[\"\']?srcset[\"\']?>/',
				'/<print lightbox=[\"\']?srcset[\"\']?>/',
				'/<print media=[\"\']?thumb[\"\']?>/',
				'/<print media=[\"\']?file[\"\']?>/',
				'/<print media=[\"\']?caption[\"\']?>/',
				'/<print media=[\"\']?fileALT[\"\']?>/',
				'/<print media=[\"\']?title[\"\']?>/',
				'/<print media=[\"\']?category_1[\"\']?>/',
				'/<print media=[\"\']?category_2[\"\']?>/',
				'/<print media=[\"\']?category_3[\"\']?>/',
				'/<print media=[\"\']?category_4[\"\']?>/',
				'/<print media=[\"\']?attributionName[\"\']?>/',
				'/<print media=[\"\']?attributionURL[\"\']?>/',
				'/<print media=[\"\']?exifISO[\"\']?>/',
				'/<print media=[\"\']?exifAperture[\"\']?>/',
				'/<print media=[\"\']?exifFocalLength[\"\']?>/',
				'/<print media=[\"\']?exifShutterSpeed[\"\']?>/',
				'/<print media=[\"\']?exifCamera[\"\']?>/',
				'/<print media=[\"\']?exifLens[\"\']?>/',
				'/<print media=[\"\']?exifFilename[\"\']?>/',
				'/<print media=[\"\']?exifTime[\"\']?>/',
				'/<print media=[\"\']?seoTitle[\"\']?>/',
				'/<print media=[\"\']?caption[\"\']?>/',
				'/<print media=[\"\']?description[\"\']?>/'
			],[
				' srcset="'.
					(file_exists('media/sm/'.basename($rm['file']))?'media/sm/'.basename($rm['file']).' '.$config['mediaMaxWidthThumb'].'w,':'').
					(file_exists('media/md/'.basename($rm['file']))?'media/md/'.basename($rm['file']).' 600w,':'').
					(file_exists('media/sm/'.basename($rm['file']))?'media/sm/'.basename($rm['file']).' 400w':'').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" ',
				(file_exists('media/'.basename($rm['file']))?'media/'.basename($rm['file']).' '.$config['mediaMaxWidth'].'w,':'').
					(file_exists('media/lg/'.basename($rm['file']))?'media/lg/'.basename($rm['file']).' 1000w,':'').
					(file_exists('media/md/'.basename($rm['file']))?'media/md/'.basename($rm['file']).' 600w,':'').
					(file_exists('media/sm/'.basename($rm['file']))?'media/sm/'.basename($rm['file']).' 400w':''),
				$rm['thumb']!=''?$rm['thumb']:NOIMAGESM,
				$rm['file']!=''?$rm['file']:NOIMAGE,
				htmlspecialchars(($rm['title']!=''?$rm['title']:$r['title'].': Image '.$rm['id']),ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['fileALT']!=''?$rm['fileALT']:$rm['title'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['title'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['category_1'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['category_2'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['category_3'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['category_4'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['attributionImageName'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['attributionImageURL'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['exifISO'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['exifAperture'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['exifFocalLength'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['exifShutterSpeed'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['exifCamera'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['exifLens'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['exifFilename'],ENT_QUOTES,'UTF-8'),
				date($config['dateFormat'],$rm['exifti']),
				htmlspecialchars($rm['seoTitle'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['seoCaption'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rm['seoDescription'],ENT_QUOTES,'UTF-8')
			],$mediaitems);
			$mediaoutput.=$mediaitems;
		}
		$html=preg_replace([
			'~<mediaimages>.*?<\/mediaimages>~is',
			'/<[\/]?mediaitems>/'
		],[
			$mediaoutput,
			''
		],$html,1);
	}else
		$html=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$html,1);
}
if(stristr($html,'<sort>')){
	if($show=='item')
		$html=preg_replace('~<sort>.*?<\/sort>~is','',$html);
	elseif($view=='inventory'||$view=='service'||$view=='article'||$view=='news'||$view=='events'||$view=='portfolio'||$view=='gallery'){
		$sortOptions='<option value="new"'.(isset($sort)&&$sort=='new'?' selected':'').'>Newest</option>'.
								 '<option value="old"'.(isset($sort)&&$sort=='old'?' selected':'').'>Oldest</option>'.
								 '<option value="namea"'.(isset($sort)&&$sort=='namea'?' selected':'').'>Name: A-Z</option>'.
								 '<option value="namez"'.(isset($sort)&&$sort=='namez'?' selected':'').'>Name: Z-A</option>'.
								 '<option value="view"'.(isset($sort)&&$sort=='view'?' selected':'').'>Most viewed</option>';
		if($view=='inventory')
			$sortOptions='<option value="best"'.(isset($sort)&&$sort=='best'?' selected':'').'>Best Selling</option>'.
									 '<option value="priceh"'.(isset($sort)&&$sort=='priceh'?' selected':'').'>Price: High to low</option>'.
									 '<option value="pricel"'.(isset($sort)&&$sort=='pricel'?' selected':'').'>Price: Low to High</option>';
		if($view=='service')
			$sortOptions='<option value="priceh"'.(isset($sort)&&$sort=='priceh'?' selected':'').'>Price: High to low</option>'.
									 '<option value="pricel"'.(isset($sort)&&$sort=='pricel'?' selected':'').'>Price: Low to High</option>';
		$html=preg_replace([
			'/<[\/]?sort>/',
			'/<sortOptions>/'
		],[
			'',
			$sortOptions
		],$html);
	}else
		$html=preg_replace('~<sort>.*?<\/sort>~is','',$html);
}
$html=preg_replace([
	'/<print page=[\"\']?contentType[\"\']?>/',
	'/<notification>/',
	'/<print page=[\"\']?heading[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
	'/<print page=[\"\']?notes[\"\']?>/',
	'/<print content=[\"\']?seoTitle[\"\']?>/',
	'/<print config=[\"\']?business[\"\']?>/'
],[
	ucfirst($page['contentType']).($page['contentType']=='article'||$page['contentType']=='service'?'s':''),
	$notification,
	($page['heading']==''?$page['seoTitle']:$page['heading']),
	'',
	$page['notes'],
	$config['business']!=''?$config['business']:$config['seoTitle'],
	ucwords($config['business'])
],$html);
if(stristr($html,'<categories>')){
	$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='category' ORDER BY `title` ASC");
	$sc->execute();
	if($sc->rowCount()>0){
		preg_match('/<categories>([\w\W]*?)<\/categories>/',$html,$matches);
		$catitem=$matches[1];
		$catoutput='';
		while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
			$catitems=$catitem;
			$rc['icon']=rawurldecode($rc['icon']);
			$catitems=preg_replace([
				'/<print thumb=[\"\']?srcset[\"\']?>/',
				'/<print category=[\"\']?thumb[\"\']?>/',
				'/<print category=[\"\']?imageALT[\"\']?>/',
				'/<print category=[\"\']?link[\"\']?>/',
				'/<print category=[\"\']?title[\"\']?>/',
				'/<print category=[\"\']?category[\"\']?>/'
			],[
				'srcset="'.
					($rc['icon']!=''&&file_exists('media/sm/'.basename($rc['icon']))?'media/sm/'.basename($rc['icon']).' '.$config['mediaMaxWidthThumb'].'w,':'').
					($rc['icon']!=''&&file_exists('media/sm/'.basename($rc['icon']))?'media/sm/'.basename($rc['icon']).' 400w,':'').
					($rc['icon']!=''&&file_exists('media/md/'.basename($rc['icon']))?'media/md/'.basename($rc['icon']).' 600w':'').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" ',
				$rc['icon']!=''?$rc['icon']:NOIMAGESM,
				htmlspecialchars('Category '.$rc['title'],ENT_QUOTES,'UTF-8'),
				URL.$rc['url'].'/category/'.str_replace(' ','-',strtolower($rc['title'])).'/',
				htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8'),
				htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8')
			],$catitems);
			$catoutput.=$catitems;
		}
		$html=preg_replace('~<categories>.*?<\/categories>~is',$catoutput,$html,1);
	}else
		$html=preg_replace('~<categories>.*?<\/categories>~is','',$html,1);
}
if(stristr($html,'<eventsitems')){
	preg_match('/<eventsitems.*?itemCount=[\"\'](.+?)[\"\'].*>/',$html,$matches);
	$limit=isset($matches[1])&&$matches[1]==0?4:$matches[1];
	preg_match('/<eventitem>([\w\W]*?)<\/eventitem>/',$html,$matches);
	$eventitem=$matches[1];
	$eventoutput='';
	$se=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :ct1 AND `status` LIKE :status AND `rank`<:rank OR `contentType` LIKE :ct2 AND `status` LIKE :status AND `rank`<:rank ORDER BY `tis` ASC LIMIT $limit");
	$se->execute([
		':ct1'=>'events',
		':ct2'=>'news',
		':status'=>'published',
		':rank'=>(isset($_SESSION['rank'])?$_SESSION['rank'] + 1:0)
	]);
	if($se->rowCount()>0){
		$eventcnt=0;
		while($re=$se->fetch(PDO::FETCH_ASSOC)){
			if($re['tis']>0&&$re['tis'] < time()){
				$eventcnt++;
				continue;
			}
			$eventitems=$eventitem;
			$re['file']=rawurldecode($re['file']);
			$eventitems=preg_replace([
				'/<print event=[\"\']?srcset[\"\']?>/',
				'/<print event=[\"\']?thumb[\"\']?>/',
				'/<print event=[\"\']?imageALT[\"\']?>/',
				'/<print event=[\"\']?contentType[\"\']?>/',
				'/<print event=[\"\']?linktitle[\"\']?>/',
				'/<print event=[\"\']?title[\"\']?>/',
				'/<print date=[\"\']?day[\"\']?>/',
				'/<print date=[\"\']?month[\"\']?>/',
				'/<print date=[\"\']?year[\"\']?>/'
			],[
				'srcset="'.
					($re['thumb']!=''&&file_exists('media/sm/'.basename($re['thumb']))?'media/sm/'.basename($re['thumb']).' '.$config['mediaMaxWidthThumb'].'w,':NOIMAGESM.' '.$config['mediaMaxWidthThumb'].'w,').
					($re['thumb']!=''&&file_exists('media/md/'.basename($re['thumb']))?'media/md/'.basename($re['thumb']).' 600w,':NOIMAGE.' 600w,').
					($re['thumb']!=''&&file_exists('media/sm/'.basename($re['thumb']))?'media/sm/'.basename($re['thumb']).' 400w':NOIMAGESM.' 400w').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" ',
				$re['thumb']!=''?$re['thumb']:NOIMAGESM,
				htmlspecialchars($re['fileALT']!=''?$re['fileALT']:$re['title'],ENT_QUOTES,'UTF-8'),
				$re['contentType'],
				URL.$re['contentType'].'/'.$re['urlSlug'].'/',
				$re['title'],
				date('jS',($re['tis']==0?$re['ti']:$re['tis'])),
				date('F',($re['tis']==0?$re['ti']:$re['tis'])),
				date('Y',($re['tis']==0?$re['ti']:$re['tis']))
			],$eventitems);
			$eventoutput.=$eventitems;
		}
		$html=preg_replace([
			'~<eventitem>.*?<\/eventitem>~is',
			($eventcnt>0?'~<eventsitems.*?>.*?<\/eventsitems>~is':'/<[\/]?eventsitems.*?>/')
		],[
			$eventoutput,
			''
		],$html);
	}else
		$html=preg_replace('~<eventsitems.*?>.*?<\/eventsitems>~is','',$html,1);
}
if(stristr($html,'<items')){
	preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
	$item=$matches[1];
	$output='';
	$si=1;
	$tqty=$config['templateQTY'];
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['contentType']=='events'&&$r['tis']>0&&$r['tis']<time())continue;
		if($r['templatelist']>0&&$view!='search'){
			$st=$db->prepare("SELECT `html` FROM `".$prefix."templates` WHERE `id`=:id");
			$st->execute([':id'=>$r['templatelist']]);
			if($st->rowCount()>0){
				$rt=$st->fetch(PDO::FETCH_ASSOC);
				$items=$rt['html'];
			}
		}elseif($config['templateID']>0&&$tqty>0&&$view!='search'){
			$st=$db->prepare("SELECT `html` FROM `".$prefix."templates` WHERE `id`=:id");
			$st->execute([':id'=>$config['templateID']]);
			if($st->rowCount()>0){
				$rt=$st->fetch(PDO::FETCH_ASSOC);
				$items=$rt['html'];
				$tqty--;
			}
		}else{
			$items=$item;
		}
		if($view=='search'&&$r['contentType']=='testimonials'||$r['contentType']=='proofs'||$r['contentType']=='advert')continue;
		$sr=$db->prepare("SELECT `active` FROM `".$prefix."menu` WHERE `contentType`=:contentType");
		$sr->execute([':contentType'=>$r['contentType']]);
		$pr=$sr->fetch(PDO::FETCH_ASSOC);
		if($pr['active']!=1)continue;
		if($r['status']!=$status)continue;
		$contentType=$r['contentType'];
		if($si==1)$si++;
		$su=$db->prepare("SELECT `id`,`username`,`name` FROM `login` WHERE `id`=:id");
		$su->execute([':id'=>$r['uid']]);
		$ua=$su->fetch(PDO::FETCH_ASSOC);
		$itemQuantity='';
		if($r['coming']==1&&$r['contentType']=='inventory')
			$itemQuantity='Coming Soon';
		else{
			if(is_numeric($r['quantity']))
				$itemQuantity=$r['stockStatus']=='quantity'?($r['quantity']==0?'Out Of Stock':'In Stock'):($r['stockStatus']=='none'?'':ucwords((string)$r['stockStatus']));
		}
		$r['file']=trim(rawurldecode((string)$r['file']));
		$r['thumb']=trim(rawurldecode((string)$r['thumb']));
		$items=preg_replace([
			$r['contentType']=='inventory'&&$config['options'][5]==1?'/<[\/]?quickview>/':'~<quickview>.*?<\/quickview>~is',
			'/<print content=[\"\']?srcset[\"\']?>/',
			'/<print content=[\"\']?thumb[\"\']?>/',
			'/<print content=[\"\']?image[\"\']?>/',
			'/<print content=[\"\']?imageALT[\"\']?>/',
			'/<print content=[\"\']?file[\"\']?>/',
			'/<print content=[\"\']?title[\"\']?>/',
			'/<print profileLink>/',
			'/<print link=[\"\']?contentType[\"\']?>/',
			'/<print content=[\"\']?linktitle[\"\']?>/',
			'/<print content=[\"\']?author[\"\']?>/',
			'/<print content=[\"\']?dateCreated[\"\']?>/',
			'/<print content=[\"\']?datePublished[\"\']?>/',
			'/<print content=[\"\']?dateEdited[\"\']?>/',
			'/<print date=[\"\']?day[\"\']?>/',
			'/<print date=[\"\']?month[\"\']?>/',
			'/<print date=[\"\']?year[\"\']?>/',
			'/<print content=[\"\']?contentType[\"\']?>/',
			'/<print content=[\"\']?quantitycolor[\"\']?>/',
			'/<print content=[\"\']?quantity[\"\']?>/',
			'/<print content=[\"\']?rank[\'"\']?>/',
			'/<print content=[\"\']?cssrank[\'"\']?>/',
			'/<print content=[\"\']?notes[\"\']?>/'
		],[
			'',
		 	($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'srcset="'.
				($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'media/sm/'.basename($r['thumb']).' '.$config['mediaMaxWidthThumb'].'w,':NOIMAGESM.' '.$config['mediaMaxWidthThumb'].'w,').
				($r['thumb']!=''&&file_exists('media/md/'.basename($r['thumb']))?'media/md/'.basename($r['thumb']).' 600w,':$r['thumb'].' 600w,').
				($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'media/sm/'.basename($r['thumb']).' 400w':NOIMAGESM.' 400w').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" '
			:''),
			$r['thumb']!=''?$r['thumb']:NOIMAGESM,
			$r['file']!=''?$r['file']:NOIMAGE,
			htmlspecialchars($r['fileALT']!=''?(string)$r['fileALT']:(string)$r['title'],ENT_QUOTES,'UTF-8'),
			$r['file']!=''?$r['file']:NOIMAGE,
			$r['title'],
			URL.'profile/'.strtolower(str_replace(' ','-',(string)$r['login_user'])).'/',
			URL.str_replace(' ','-',(string)$r['contentType']),
			URL.$r['contentType'].'/'.$r['urlSlug'].'/',
			(isset($ua['name'])&&$ua['name']!=''?$ua['name']:(isset($ua['username'])&&$ua['username']!=''?$ua['username']:'Anonymous')),
			date($config['dateFormat'],$r['ti']),
			date($theme['settings']['dateFormat'],$r['pti']),
			date($theme['settings']['dateFormat'],$r['eti']),
			date('j',$r['tis']!=0?$r['tis']:$r['ti']),
			date('M',$r['tis']!=0?$r['tis']:$r['ti']),
			date('Y',$r['tis']!=0?$r['tis']:$r['ti']),
			$r['contentType'],
			str_replace(' ','-',strtolower($itemQuantity)),
			$itemQuantity,
			isset($r['rank'])&&$r['rank']>300?ucwords(str_replace('-',' ',rank($r['rank']))):'',
			rank($r['rank']),
			($view=='index'?substr(strip_tags($r['notes']),0,300):strip_tags($r['notes']))
		],$items); /* help */
		$r['notes']=strip_tags($r['notes']);
		if($r['contentType']=='testimonials'||$r['contentType']=='testimonial'){
			if(stristr($items,'<controls>'))$items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
			$controls='';
		}else{
			if(stristr($items,'<view>')){
				$items=preg_replace([
					'/<print content=[\"\']?linktitle[\"\']?>/',
					'/<print content=[\"\']?title[\"\']?>/',
					'/<[\/]?view>/'
				],[
					URL.$r['contentType'].'/'.$r['urlSlug'].'/',
					htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
					''
				],$items);
			}
			if($r['contentType']=='service'||$r['contentType']=='events'){
				if($r['bookable']==1){
					if(stristr($items,'<service')){
						$items=preg_replace([
							'/<print content=[\"\']?bookservice[\"\']?>/',
							'/<[\/]?service>/',
							'~<inventory>.*?<\/inventory>~is'
						],[
							$r['id'],
							'',
							''
						],$items);
					}
				}else
					$items=preg_replace(['/<[\/]?inventory>/','~<service.*?>.*?<\/service>~is'],'',$items,1);
			}else
				$items=preg_replace(['/<[\/]?inventory>/','~<service.*?>.*?<\/service>~is'],'',$items,1);
			if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
				if(stristr($items,'<inventory'))
					$items=preg_replace(['/<[\/]?inventory>/','~<service>.*?<\/service>~is'],'',$items);
				elseif(stristr($items,'<inventory')&&$r['contentType']!='inventory'&&!is_numeric($r['cost']))
					$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
			}else
				$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
			$items=preg_replace('/<[\/]?controls>/','',$items);
		}
		require'core/parser.php';
		$output.=$items;
	}
	$html=preg_replace([
		'~<items>.*?<\/items>~is',
		'~<item>.*?<\/item>~is'
	],[
		$output,
		''
	],$html,1);
}else
	$html=preg_replace('~<section data-content="content-items">.*?<\/section>~is','',$html,1);
$html=preg_replace([
	'~<item>.*?<\/item>~is',
	'/<[\/]?items>/',
	'/<[\/]?contentitems>/'
],'',$html);
if(stristr($html,'<pagination')){
	$pagination='';
	$totalItems=0;
	if($itemCount>0){
		require_once'core/pagination.php';
		$totalItems=$rowCount;
		$itemsPerPage=$itemCount;
		$currentPage=$itemPage==0?1:$itemPage;
		$urlPattern=URL.$view.'?page=(:num)';
		$pagination=new Paginator($totalItems,$itemsPerPage,$currentPage,$urlPattern);
	}
	$html=preg_replace([
		$totalItems>0?'/<\/?pagination>/':'~<pagination>.*?<\/pagination>~is',
		'/<paginationitems>/'
	],[
		'',
		$pagination
	],$html);
}
