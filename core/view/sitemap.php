<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Sitemap
 * @package    core/view/sitemap.php
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
 $breadit=preg_replace([
   '/<print breadcrumb=[\"\']?title[\"\']?>/'
 ],[
   htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8')
 ],$breadcurrent);
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

$html=preg_replace('/<print page=[\"\']?notes[\"\']?>/',rawurldecode($page['notes']),$html);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`!='' AND `internal`!='1' AND `status`='published' AND `rank`<=:rank ORDER BY `contentType` ASC, `ti` DESC");
$s->execute([
	':rank'=>$_SESSION['rank']
]);
$items=$sitemapitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		$sitemaplinks='';
		$items=preg_replace('/<print content=[\"\']?contentType[\"\']?>/',ucfirst($r['contentType']),$items);
		$sitemaplinks.='<a href="'.$r['contentType'].'/'.$r['urlSlug'].'/">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</a><br>';
		$items=preg_replace('/<print links>/',$sitemaplinks,$items);
		$sitemapitems.=$items;
	}
}
$html=preg_replace('~<items>.*?<\/items>~is',$sitemapitems,$html,1);
$content.=$html;
