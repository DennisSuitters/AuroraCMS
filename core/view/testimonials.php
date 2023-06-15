<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Bookings
 * @package    core/view/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.25
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(stristr($html,'<settings')){
	preg_match('/<settings.*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
	$count=isset($matches[1])&&$matches[1]!=0?$matches[1]:$config['showItems'];
}else
	$count=$config['showItems'];
require'inc-cover.php';
require'inc-breadcrumbs.php';
$html=preg_replace([
	'~<settings.*?>~is',
	'/<print page=[\"\']?heading[\"\']?>/',
	'/<print page=[\"\']?notes[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
	'/<g-recaptcha>/'
],[
	'',
	htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
	$page['notes'],
	'',
	$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':'',
],$html);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
if($count==0)$count='all';
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
				if($ru['avatar']!=''&&file_exists('media/avatar/'.$ru['avatar']))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media/avatar/'.$ru['avatar'],$items);
				elseif($r['file']&&file_exists('media/avatar/'.basename($r['file'])))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media/avatar/'.basename($r['file']),$items);
				elseif(stristr($ru['gravatar'],'@'))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','http://gravatar.com/avatar/'.md5($ru['gravatar']),$items);
				elseif(stristr($ru['gravatar'],'gravatar.com'))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$ru['gravatar'],$items);
				else
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
			}elseif($r['file']&&file_exists('media/avatar/'.basename($r['file'])))
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media/avatar/'.basename($r['file']),$items);
			elseif($r['file']!='')
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$r['file'],$items);
			else
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
		}
		$jsonld='';
		if(stristr($items,'<json-ld-testimonial>')){
			$jsonld='<script type="application/ld+json">'.
			'{'.
				'"@context":"https://schema.org/",'.
				'"@type":"Review",'.
				'"itemReviewed":{'.
					'"@type":"localBusiness",'.
					'"image":"'.THEME.'/images/logo.png'.'",'.
					'"name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'",'.
					'"telephone":"'.htmlspecialchars(($config['phone']!=''?$config['phone']:$config['mobile']),ENT_QUOTES,'UTF-8').'",'.
					'"address":{'.
						'"@type":"PostalAddress",'.
						'"streetAddress":"'.htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8').'",'.
						'"addressLocality":"'.htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8').'",'.
						'"addressRegion":"'.htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8').'",'.
						'"postalCode":"'.htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8').'",'.
						'"addressCountry":"'.htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8').'"'.
					'}'.
				'},'.
				'"name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'",'.
				'"author":{'.
					'"@type":"Person",'.
					'"name":"'.htmlspecialchars(($r['name']!=''?$r['name']:'Anonymous').($r['name']!=''&&$r['business']!=''?' : ':'').($r['business']!=''?$r['business']:''),ENT_QUOTES,'UTF-8').'"'.
				'},'.
				'"datePublished":"'.date('Y-m-d',$r['ti']).'",'.
				'"reviewBody":"'.$r['notes'].'",'.
				'"reviewRating":{'.
					'"@type":"Rating",'.
					'"bestRating":"5",'.
					'"ratingValue":"'.$r['rating'].'",'.
					'"worstRating":"1"'.
				'}'.
			'}</script>';
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
			($view=='index'?substr(strip_tags($r['notes']),0,600):strip_tags($r['notes'])),
			$r['business']!=''?htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8'):'',
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
