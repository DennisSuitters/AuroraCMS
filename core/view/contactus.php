<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Contact Us
 * @package    core/view/contactus.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
require'inc-cover.php';
require'inc-breadcrumbs.php';
$html=preg_replace([
	'/<print page=[\"\']?heading[\"\']?>/',
	'/<print page=[\"\']?notes[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?</pagenotes>~is'
],[
	htmlspecialchars($page['heading']==''?$page['seoTitle']:$page['heading'],ENT_QUOTES,'UTF-8'),
	$page['notes'],
	''
],$html);
require'inc-hours.php';
if(stristr($html,'<email>')){
	$html=preg_replace([
		$config['options'][23]==1?'/<[\/]?email>/':'~<email>.*?<\/email>~is',
		'/<print config=[\"\']?email[\"\']?>/'
	],[
		'',
		'<a href="contactus">'.htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8').'</a>'
	],$html);
}
if(stristr($html,'<contact>')){
	$html=preg_replace([
		$config['options'][22]==1?'/<[\/]?contact>/':'~<contact>.*?<\/contact>~is',
		'/<print config=[\"\']?business[\"\']?>/',
		'/<print config=[\"\']?address[\"\']?>/',
		'/<print config=[\"\']?suburb[\"\']?>/',
		'/<print config=[\"\']?postcode[\"\']?>/',
		'/<print config=[\"\']?state[\"\']?>/',
		'/<print config=[\"\']?country[\"\']?>/',
	],[
		'',
		htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
		$config['postcode']==0?'':htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8')
	],$html);
}
if(stristr($html,'<phone>')){
	$html=preg_replace([
		$config['options'][24]==1?'/<[\/]?phone>/':'~<phone>.*?<\/phone>~is',
		'/<print config=[\"\']?phone[\"\']?>/',
		'/<print config=[\"\']?mobile[\"\']?>/'
	],[
		'',
		$config['phone']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['phone']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8').'</a>':'',
		$config['mobile']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['mobile']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8').'</a>':''
	],$html);
}
if(stristr($html,'<map>')){
  $html=preg_replace($config['options'][27]==1&&$config['geo_position']!=''&&$config['mapapikey']!=''?'/<[\/]?map>/':'~<map>.*?<\/map>~is','',$html);
}
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
$html=preg_replace('/<g-recaptcha>/',$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':'',$html);
require'core/parser.php';
$content.=$html;
