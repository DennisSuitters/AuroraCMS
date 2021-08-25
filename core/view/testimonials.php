<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Bookings
 * @package    core/view/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(stristr($html,'<settings')){
	preg_match('/<settings.*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
	$count=isset($matches[1])&&$matches[1]!=0?$matches[1]:$config['showItems'];
}else$count=$config['showItems'];
if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsoni=2;
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
	$jsonld.='{"@type":"ListItem","position":2,"item":{"@id":"'.URL.urlencode($page['contentType']).'","name":"'.htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8').'"}}';
	$breaditems.=$breadit;
	$html=preg_replace([
		'/<[\/]?breadcrumb>/',
		'/<json-ld-breadcrumb>/',
		'~<breaditems>.*?<\/breaditems>~is',
		'~<breadcurrent>.*?<\/breadcurrent>~is'
	],[
		'',
		$jsonld.']}</script>',
		$breaditems,
		''
	],$html);
}
if(stristr($html,'<print page="coverItem">')){
 if($page['coverVideo']!=''){
   $cover=basename($page['coverVideo']);
   if(stristr($page['coverVideo'],'youtu')){
     preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$page['coverVideo'],$vidMatch);
     $videoHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.($page['options'][0]==1?'autoplay=1&':'').($page['options'][1]==1?'loop=1&':'').($page['options'][2]==1?'controls=1&':'controls=0&').'" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
   }elseif(stristr($page['coverVideo'],'vimeo')){
     preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$page['coverVideo'],$vidMatch);
     $videoHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.($page['options'][0]==1?'autoplay=1&':'').($page['options'][1]==1?'loop=1&':'').($page['options'][2]==1?'controls=1&':'controls=0&').'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
   }else$videoHTML='<div class="embed-responsive embed-responsive-16by9"><video class="embed-responsive-item" preload autoplay loop muted><source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video></div>';
 }
 if($page['cover']!=''||$page['coverURL']!=''){
   $cover=basename($page['cover']);
   list($width,$height)=getimagesize($page['cover']);
   $coverHTML='<img src="';
   if(file_exists('media/'.$cover))$coverHTML.=htmlspecialchars($page['cover'],ENT_QUOTES,'UTF-8');
   elseif($page['coverURL']!='')$coverHTML.=htmlspecialchars($page['coverURL'],ENT_QUOTES,'UTF-8');
   $coverHTML.='" alt="';
   if($page['attributionImageTitle']==''&&$page['attributionImageName']==''&&$page['attributionImageURL']==''){
     if($page['attributionImageTitle'])$coverHTML.=$page['attributionImageTitle'].$page['attributionImageName']!=''?' - ':'';
     if($page['attributionImageName'])$coverHTML.=$page['attributionImageName'].$page['attributionImageURL']!=''?' - ':'';
     if($page['attributionImageURL'])$coverHTML.=htmlspecialchars($page['attributionImageURL'],ENT_QUOTES,'UTF-8');
   }else$coverHTML.=$page['seoTitle']!=''?$page['seoTitle']:$config['seoTitle'];
   if($page['seoTitle']==''&&$config['seoTitle']=='')$coverHTML.=htmlspecialchars(basename($page['cover']),ENT_QUOTES,'UTF-8');
   $coverHTML.='">';
 }else$coverHTML='';
 $html=preg_replace([
   '/<[\/]?cover>/',
   '/<print page=[\"\']?coverItem[\"\']?>/',
   '/<print page=[\"\']?fileALT[\"\']?>/'
 ],[
   '',
   $coverHTML,
   htmlspecialchars($page['fileALT'],ENT_QUOTES,'UTF-8')
 ],$html);
}else
  $html=preg_replace('~<cover>.*?</cover>~is','',$html);

$html=preg_replace([
	'~<settings.*?>~is',
	'/<print page=[\"\']?notes[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
	'/<g-recaptcha>/'
],[
	'',
	rawurldecode($page['notes']),
	'',
	$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':'',
],$html);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s=$db->query("SELECT * FROM `".$prefix."content` WHERE `contentType`='testimonials' AND `status`='published' ORDER BY `ti` DESC".($count!='all'?" LIMIT 0,".$count:""));
$s->execute();
$i=0;
$items=$testitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['notes']=='')continue;
		if($r['rating']==0)$r['rating']=1;
		$items=$item;
		$items=preg_replace([
			'/<print content=[\"\']?active[\"\']?>/',
			'/<print content=[\"\']?schemaType[\"\']?>/',
			'/<print config=[\"\']?title[\"\']?>/',
			'/<print datePub>/'
		],[
			($i==0?' active':''),
			$r['schemaType'],
			htmlspecialchars($config['seoTitle'],ENT_QUOTES,'UTF-8'),
			date('Y-d-m',$r['ti'])
		],$items);
		if(preg_match('/<print content=[\"\']?avatar[\"\']?>/',$items)){
			if($r['cid']!=0){
				$su=$db->prepare("SELECT `avatar`,`gravatar` FROM `".$prefix."login` WHERE `id`=:id");
				$su->execute([':id'=>$r['cid']]);
				$ru=$su->fetch(PDO::FETCH_ASSOC);
				if($ru['avatar']!=''&&file_exists('media/avatar/'.$ru['avatar']))$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media/avatar/'.$ru['avatar'],$items);
				elseif($r['file']&&file_exists('media/avatar/'.basename($r['file'])))$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media/avatar/'.basename($r['file']),$items);
				elseif(stristr($ru['gravatar'],'@'))$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','http://gravatar.com/avatar/'.md5($ru['gravatar']),$items);
				elseif(stristr($ru['gravatar'],'gravatar.com'))$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$ru['gravatar'],$items);
				else$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
			}elseif($r['file']&&file_exists('media/avatar/'.basename($r['file'])))$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media/avatar/'.basename($r['file']),$items);
			elseif($r['file']!='')$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$r['file'],$items);
			else$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
		}
		$jsonld='';
		if(stristr($items,'<json-ld-testimonial>')){
			$jsonld='<script type="application/ld+json">{"@context":"https://schema.org/","@type":"Review","itemReviewed":{"@type":"localBusiness","image":"'.THEME.'/images/logo.png'.'","name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'","telephone":"'.($config['phone']!=''?htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'):htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')).'","address":{"@type":"PostalAddress","streetAddress":"'.htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8').'","addressLocality":"'.htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8').'","addressRegion":"'.htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8').'","postalCode":"'.htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8').'","addressCountry":"'.htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8').'"}},"author":"'.($r['name']!=''?htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'):'Anonymous').($r['name']!=''&&$r['business']!=''?' : ':'').($r['business']!=''?htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8'):'').'","datePublished":"'.date('Y-m-d',$r['ti']).'","reviewBody":"'.htmlspecialchars(strip_tags(rawurldecode($r['notes'])),ENT_QUOTES,'UTF-8').'","reviewRating":{"@type":"Rating","bestRating":"5","ratingValue":"'.$r['rating'].'","worstRating":"1"}}</script>';
		}
		$items=preg_replace([
			'/<print content=[\"\']?notes[\"\']?>/',
			'/<print content=[\"\']?business[\"\']?>/',
			'/<print content=[\"\']?name[\"\']?>/',
			'/<json-ld-testimonial>/',
			'/<print review=[\"\']?rating[\"\']?>/',
			'/<print review=[\"\']?set5[\"\']?>/',
			'/<print review=[\"\']?set4[\"\']?>/',
			'/<print review=[\"\']?set3[\"\']?>/',
			'/<print review=[\"\']?set2[\"\']?>/',
			'/<print review=[\"\']?set1[\"\']?>/'
		],[
			($view=='index'?substr(strip_tags(rawurldecode($r['notes'])),0,600):strip_tags(rawurldecode($r['notes']))),
			$r['business']!=''?htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8'):'Anonymous',
			$r['name']!=''?htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'):'Anonymous',
			$jsonld,
			$r['rating'],
			$r['rating']>=5?'set':'',
			$r['rating']>=4?'set':'',
			$r['rating']>=3?'set':'',
			$r['rating']>=2?'set':'',
			$r['rating']>=1?'set':''
		],$items);
		$testitems.=$items;
		$i++;
	}
}
$html=preg_replace([
	($i>0?'/<[\/]?controls>/':'~<controls>.*?<\/controls>~is'),
	'~<items>.*?<\/items>~is'
],[
	'',
	$testitems
],$html,1);
$s=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='subject' ORDER BY `title` ASC");
$s->execute();
if($s->rowCount()>0){
	$html=preg_replace([
		'~<subjectText>.*?<\/subjectText>~is',
		'/<[\/]?subjectSelect>/'
	],'',$html);
	$options='';
	while($r=$s->fetch(PDO::FETCH_ASSOC))$options.='<option value="'.$r['id'].'">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</option>';
	$html=str_replace('<subjectOptions>',$options,$html);
}else{
	$html=preg_replace([
		'~<subjectSelect>.*?<\/subjectSelect>~is',
		'/<[\/]?subjectText>/'
	],'',$html);
}
$content.=$html;
