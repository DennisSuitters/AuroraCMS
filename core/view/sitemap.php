<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Sitemap
 * @package    core/view/sitemap.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$html=preg_replace([
	'/<print page=[\"\']?notes[\"\']?>/'
],[
	rawurldecode($page['notes'])
],$html);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s=$db->query("SELECT * FROM `".$prefix."content` WHERE contentType!='' AND internal!='1' AND status='published' ORDER BY contentType ASC, ti DESC");
$items=$sitemapitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		$sitemaplinks='';
		$items=preg_replace('/<print content=[\"\']?contentType[\"\']?>/',ucfirst($r['contentType']),$items);
		$sitemaplinks.='<a href="'.$r['contentType'].'/'.$r['urlSlug'].'">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</a><br>';
		$items=preg_replace([
			'/<print links>/',
		],[
			$sitemaplinks,
		],$items);
		$sitemapitems.=$items;
	}
}
$html=preg_replace('~<items>.*?<\/items>~is',$sitemapitems,$html,1);
$content.=$html;
