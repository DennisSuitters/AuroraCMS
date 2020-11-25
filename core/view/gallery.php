<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Gallery
 * @package    core/view/gallery.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
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
 $breadit=preg_replace([
   '/<print breadcrumb=[\"\']?title[\"\']?>/'
 ],[
   htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8')
 ],$breadcurrent);
 $jsonld.='{'.
   '"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.urlencode($page['contentType']).'/'.urlencode($r['urlSlug']).'","name":"'.htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8').'"}}]}</script>';
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
if($page['notes']!=''){
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<[\/]?pagenotes>/'
	],[
		rawurldecode($page['notes']),
		''
	],$html);
}else{
	$html=preg_replace([
    '~<pagenotes>.*?<\/pagenotes>~is'
  ],[
    ''
  ],$html,1);
}
$gals='';
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $gal=$matches[1];
  $s=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `pid`=:pid AND `rank`<=:rank ORDER BY `ord` ASC");
  $s->execute([
		':pid'=>10,
		':rank'=>$_SESSION['rank']
	]);
  $output='';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $items=$gal;
    $items=preg_replace([
			'/<print thumb=[\"\']?srcset[\"\']?>/',
			'/<print lightbox=[\"\']?srcset[\"\']?>/',
			'/<print media=[\"\']?thumb[\"\']?>/',
      '/<print media=[\"\']?file[\"\']?>/',
			'/<print media=[\"\']?fileALT[\"\']?>/',
      '/<print media=[\"\']?title[\"\']?>/',
      '/<print media=[\"\']?caption[\"\']?>/',
      '/<print media=[\"\']?attributionImageName[\"\']?>/',
      '/<print media=[\"\']?attributionImageURL[\"\']?>/'
    ],[
			' srcset="media/thumbs/'.basename($r['file']).' '.$config['mediaMaxWidthThumb'].'w,media/sm/'.basename($r['file']).' 400w" ',
      'media/'.basename($r['file']).' '.$config['mediaMaxWidth'].'w,'.(file_exists('media/lg/'.basename($r['file']))?'media/lg/'.basename($r['file']).' 1000w,':'').(file_exists('media/md/'.basename($r['file']))?'media/md/'.basename($r['file']).' 600w':''),
      'media/thumbs/'.basename($r['file']),
      $r['file'],
			htmlspecialchars(($r['fileALT']!=''?$r['fileALT']:$r['title']),ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['attributionImageName'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['attributionImageURL'],ENT_QUOTES,'UTF-8')
    ],$items);
    if($r['attributionImageName']!=''&&$r['attributionImageURL']!=''){
      $items=preg_replace('/<[\/]?attribution>/','',$items);
    }else
			$items=preg_replace('~<attribution>.*?<\/attribution>~is','',$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}else
	$gals='';
$content.=$gals;
