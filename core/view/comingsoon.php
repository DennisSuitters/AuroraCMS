<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Coming Soon
 * @package    core/view/comingsoon.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/sanitize/HTMLPurifier.php';
$purify=new HTMLPurifier(HTMLPurifier_Config::createDefault());
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `contentType`='comingsoon'");
$s->execute();
$page=$s->fetch(PDO::FETCH_ASSOC);
if(!isset($canonical)||$canonical=='')$canonical=($view=='index'?URL:URL.$view.'/');
if($page['cover']!='')
  $image=$page['cover'];
elseif(file_exists(THEME.'/images/unavailable.png'))
  $image=URL.THEME.'/images/unavaliable.png';
elseif(file_exists(THEME.'/images/unavailable.jpg'))
  $image=URL.THEME.'/images/unavailable.jpg';
else
  $image='core/images/unavailable.png';
$html=preg_replace([
  '/<print background>/',
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
  '/<google_analytics>/',
  '/<print page=[\"\']?heading[\"\']?>/',
  '/<print page=[\"\']?notes[\"\']?>/',
  $page['tie']>0?'/<[\/]?countdown>/':'~<countdown>.*?<\/countdown>~is',
  '/<print countdown=[\"\']?tie[\"\']?>/',
  '/<countdownscript>/'
],[
  'background:none url('.$image.') !important;background-repeat:no-repeat;background-size:cover;background-position:center;',
  THEME,
  htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8'),
  htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8'),
  htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8'),
  URL,
  $favicon,
  htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
  $page['metaRobots']!=''?trim(htmlspecialchars($page['metaRobots'],ENT_QUOTES,'UTF-8')):'index,follow',
  htmlspecialchars($page['seoTitle'],ENT_QUOTES,'UTF-8'),
  htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8'),
  htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8'),
  htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8'),
  htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8'),
  htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8'),
  $canonical,
  URL,
  $view,
  $view=='inventory'?'product':$view,
  $shareImage,
  FAVICON,
  microid($config['email'],$canonical),
  isset($page['login_user'])?$page['login_user']:htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
  THEME,
  ($config['ga_verification']!=''?'<meta name="google-site-verification" content="'.$config['ga_verification'].'">':'').
    ($config['seo_msvalidate']!='<meta name="msvalidate.01" content="'.$config['seo_msvalidate'].'">'?'':'').
    ($config['seo_yandexverification']!='<meta name="yandex-verification" content="'.$config['seo_yandexverification'].'">'?'':'').
    ($config['seo_alexaverification']!=''?'<meta name="alexaVerifyID" content="'.$config['seo_alexaverification'].'">':'').
    ($config['seo_pinterestverify']!=''?'<meta name="p:domain_verify" content="'.$config['seo_pinterestverify'].'">':''),
  ($config['geo_region']!=''?'<meta name="geo.region" content="'.$config['geo_region'].'">':'').
    ($config['geo_placename']!=''?'<meta name="geo.placename" content="'.$config['geo_placename'].'">':'').
    ($config['geo_position']!=''?'<meta name="geo.position" content="'.$config['geo_position'].'"><meta name="ICBM" content="'.$config['geo_position'].'">':''),
  ($config['ga_tracking']!=''?'<script async src="https://www.googletagmanager.com/gtag/js?id='.$config['ga_tracking'].'"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag(\'js\',new Date());gtag(\'config\',\''.$config['ga_tracking'].'\');</script>':''),
  htmlspecialchars(($page['heading']!=''?$page['heading']:$page['seoTitle']),ENT_QUOTES,'UTF-8'),
  $purify->purify($page['notes']),
  '',
  date('Y-m-d h:i',$page['tie']),
  stristr($html,'<countdownscript')?'<script>countdown();</script>':'',
],$html);
require'inc-buildsocial.php';
$content.=$html;
