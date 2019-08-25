<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Featured Right
 * @package    core/view/featured-right.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(stristr($html,'<events')){
	preg_match('/<events>([\w\W]*?)<\/events>/',$html,$matches);
	$event=$matches[1];
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE 'events' AND internal!='1' AND status='published' ORDER BY ti DESC LIMIT 2");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$event;
		if($r['seoCaption']=='')$r['seoCaption']=strip_tags($r['notes']);
		$items=preg_replace([
			'/<print content=[\"\']?schematype[\"\']?>/',
			'/<print content=[\"\']?title[\"\']?>/',
			'/<print metaDate>/',
			'/<print time>/',
			'/<print link>/',
			'/<print content=[\"\']?caption[\"\']?>/'
		],
		[
			$r['schemaType'],
			htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
			date($config['dateFormat'],$r['tis']),
			date($config['dateFormat'],$r['tis']),
			URL.'events/'.$r['urlSlug'],
			htmlspecialchars(preg_replace('/\s+?(\S+)?$/','',substr($r['seoCaption'],0,151)),ENT_QUOTES,'UTF-8')
		],$items);
		$output.=$items;
	}
	$html=preg_replace('~<events>.*?<\/events>~is',$output,$html,1);
}
if(stristr($html,'<news')){
	preg_match('/<news>([\w\W]*?)<\/news>/',$html,$matches);
	$news=$matches[1];
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE 'news' AND internal!='1' AND status='published' ORDER BY ti DESC LIMIT 2");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$news;
		if($r['seoCaption']=='')
			$r['seoCaption']=strip_tags($r['notes']);
		$items=preg_replace([
			'/<print content=[\"\']?schemaType[\"\']?>/',
			'/<print content=[\"\']?title[\"\']?>/',
			'/<print metaDate>/',
			'/<print time>/',
			'/<print link>/',
			'/<print content=[\"\']?caption[\"\']?>/'
		],[
			$r['schemaType'],
			htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
			date($config['dateFormat'],$r['tis']),
			date($config['dateFormat'],$r['tis']),
			URL.'news/'.$r['urlSlug'],
			htmlspecialchars(preg_replace('/\s+?(\S+)?$/','',substr($r['seoCaption'],0,151)),ENT_QUOTES,'UTF-8')
		],$items);
		$output.=$items;
	}
	$html=preg_replace('~<news>.*?<\/news>~is',$output,$html,1);
}
$content.=$html;
