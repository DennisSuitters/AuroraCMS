<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Contact Us
 * @package    core/view/contactus.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
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
if($page['notes']!=''){
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<[\/]?pagenotes>/'
	],[
		rawurldecode($page['notes']),
		''
	],$html);
}else$html=preg_replace('~<pagenotes>.*?<\/pagenotes>~is','',$html,1);
if(stristr($html,'<hours>')){
	if($config['options'][19]==1){
		preg_match('/<buildHours>([\w\W]*?)<\/buildHours>/',$html,$matches);
		$htmlHours=$matches[1];
		$hoursItems='';
		$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='hours'");
		if($s->rowCount()>0){
			while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$buildHours=$htmlHours;
				if($r['tis']!=0){
					$r['tis']=str_pad($r['tis'],4,'0',STR_PAD_LEFT);
					if($config['options'][21]==1)$hourFrom=$r['tis'];
					else{
						$hourFromH=substr($r['tis'],0,2);
						$hourFromM=substr($r['tis'],3,4);
						$hourFrom=($hourFromH<12?ltrim($hourFromH,'0').($hourFromM>0?$hourFromM:'').'am':$hourFromH - 12 .($hourFromM>0?$hourFromM:'').'pm');
					}
				}else$hourFrom='';
				if($r['tie']!=0){
					$r['tie']=str_pad($r['tie'],4,'0',STR_PAD_LEFT);
					if($config['options'][21]==1)$hourTo=$r['tie'];
					else{
						$hourToH=substr($r['tie'],0,2);
						$hourToM=substr($r['tie'],3,4);
						$hourTo=($hourToH<12?ltrim($hourToH,'0').($hourToM>0?$hourToM:'').'am':$hourToH - 12 .($hourToM>0?$hourToM:'').'pm');
					}
				}else$hourTo='';
				$buildHours=preg_replace([
					'/<print dayfrom>/',
					'/<print dayto>/',
					'/<print timefrom>/',
					'/<print timeto>/',
					'/<print info>/'
				],[
					ucfirst(($config['options'][20]==1?substr($r['username'],0,3):$r['username'])),
					($r['password']==$r['username']?'':'-'.ucfirst(($config['options'][20]==1?substr($r['password'],0,3):$r['password']))),
					$hourFrom,
					($r['tie']>0?'-'.$hourTo:''),
					($r['title']!=''?htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'):'')
				],$buildHours);
				$hoursItems.=$buildHours;
			}
		}
		$html=preg_replace([
			'/<[\/]?hours>/',
			'~<buildHours>.*?<\/buildHours>~is'
		],[
			'',
			$hoursItems,
		],$html);
	}else$html=preg_replace('~<hours>.*?<\/hours>~is','',$html,1);
}
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
		'/<print config=[\"\']?country[\"\']?>/',
	],[
		'',
		htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
		$config['postcode']==0?'':htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
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
