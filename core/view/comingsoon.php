<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Coming Soon
 * @package    core/view/comingsoon.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.3 Fix content parsing to help with SEO Indexing.
 * @changes    v0.0.3 Add Forgotten Google Analytics tracking script.
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE contentType='comingsoon'");
$s->execute();
$page=$s->fetch(PDO::FETCH_ASSOC);
if(!isset($canonical)||$canonical=='')$canonical=($view=='index'?URL:URL.$view.'/');
$html=preg_replace([
  '/<print theme>/',
  '/<print theme=[\"\']?title[\"\']?>/',
  '/<print theme=[\"\']?creator[\"\']?>/',
  '/<print theme=[\"\']?creatorurl[\"\']?>/',
  '/<print url>/',
  '/<print meta=favicon>/',
  '/<print config=[\"\']?business[\"\']?>/',
  '/<print meta=[\"\']?metaRobots[\"\']?>/',
  '/<print meta=[\"\']?seoTitle[\"\']?>/',
  '/<print meta=[\"\']?seoCaption[\"\']?>/',
  '/<print meta=[\"\']?seoDescription[\"\']?>/',
  '/<print meta=[\"\']?seoAbstract[\"\']?>/',
  '/<print meta=[\"\']?seoSummary[\"\']?>/',
  '/<print meta=[\"\']?seoKeywords[\"\']?>/',
  '/<print meta=[\"\']?canonical[\"\']?>/',
  '/<print meta=[\"\']?url[\"\']?>/',
  '/<print meta=[\"\']?view[\"\']?>/',
  '/<print meta=[\"\']?ogType[\"\']?>/',
  '/<print meta=[\"\']?shareImage[\"\']?>/',
  '/<print meta=[\"\']?favicon[\"\']?>/',
  '/<print microid>/',
  '/<print meta=[\"\']?author[\"\']?>/',
  '/<print theme>/',
  '/<print site_verifications>/',
	'/<print geo>/',
  '/<print page=[\"\']?notes[\"\']?>/'
],[
  THEME,
  trim(htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8')),
  URL,
  $favicon,
  trim(htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8')),
  $page['metaRobots']!=''?trim(htmlspecialchars($page['metaRobots'],ENT_QUOTES,'UTF-8')):'index,follow',
  trim(htmlspecialchars($page['seoTitle'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8')),
  $canonical,
  URL,
  $view,
  $view=='inventory'?'product':$view,
  $shareImage,
  FAVICON,
  microid($config['email'],$canonical),
  isset($page['login_user'])?$page['login_user']:$config['business'],
  THEME,
  ($config['ga_verification']!=''?'<meta name="google-site-verification" content="'.$config['ga_verification'].'">':'').
    ($config['seo_msvalidate']!='<meta name="msvalidate.01" content="'.$config['seo_msvalidate'].'">'?'':'').
    ($config['seo_yandexverification']!='<meta name="yandex-verification" content="'.$config['seo_yandexverification'].'">'?'':'').
    ($config['seo_alexaverification']!=''?'<meta name="alexaVerifyID" content="'.$config['seo_alexaverification'].'">':'').
    ($config['seo_pinterestverify']!=''?'<meta name="p:domain_verify" content="'.$config['seo_pinterestverify'].'">':''),
  ($config['geo_region']!=''?'<meta name="geo.region" content="'.$config['geo_region'].'">':'').
    ($config['geo_placename']!=''?'<meta name="geo.placename" content="'.$config['geo_placename'].'">':'').
    ($config['geo_position']!=''?'<meta name="geo.position" content="'.$config['geo_position'].'"><meta name="ICBM" content="'.$config['geo_position'].'">':''),
  $page['notes']
],$html);
if($config['ga_tracking']!='')$html=str_replace('<google_analytics>','<script async src="https://www.googletagmanager.com/gtag/js?id='.$config['ga_tracking'].'"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag(\'js\',new Date());gtag(\'config\',\''.$config['ga_tracking'].'\');</script>',$html);
else$html=str_replace('<google_analytics>','',$html);
if(stristr($html,'<buildSocial')){
	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
	$htmlSocial=$matches[1];
	$socialItems='';
	$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
	if($s->rowCount()>0){
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$buildSocial=$htmlSocial;
			$buildSocial=str_replace([
				'<print sociallink>',
				'<print socialicon>'
			],[
				htmlspecialchars($r['url'],ENT_QUOTES,'UTF-8'),
				frontsvg('libre-social-'.$r['icon'])
			],$buildSocial);
			$socialItems.=$buildSocial;
		}
	}else$socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
}
$content.=$html;
