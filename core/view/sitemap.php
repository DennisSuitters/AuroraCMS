<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Sitemap
 * @package    core/view/sitemap.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.21
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
include'inc-breadcrumbs.php';
$rank=isset($_SESSION['rank'])?$_SESSION['rank']+1:1;
$html=preg_replace([
  '/<print page=[\"\']?heading[\"\']?>/',
  '/<print page=[\"\']?notes[\"\']?>/'
],[
  htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
  $page['notes']
],$html);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s1=$db->query("SELECT `contentType`,`title`,`metaRobots`,`active` FROM `".$prefix."menu` WHERE `active`='1' AND `contentType`!='proofs' AND `contentType`!='orders' AND `contentType`!='settings' AND `contentType`!='comingsoon' AND `contentType`!='maintenance' AND `contentType`!='offline' AND `contentType`!='checkout' AND `contentType`!='cart' AND `contentType`!='activate' AND `contentType`!='notification' ORDER BY `ord` ASC");
$items=$sitemapitems='';
while($r1=$s1->fetch(PDO::FETCH_ASSOC)){
  if(stristr($r1['metaRobots'],'noindex'))continue;
  if(stristr($r1['metaRobots'],'nofollow'))continue;
  if(stristr($r1['metaRobots'],'noimageindex'))continue;
  if(stristr($r1['metaRobots'],'noarchive'))continue;
  if(stristr($r1['metaRobots'],'nocache'))continue;
  if(stristr($r1['metaRobots'],'nosnippet'))continue;
  if(stristr($r1['metaRobots'],'noodp'))continue;
  if(stristr($r1['metaRobots'],'noydir'))continue;
  $items=$item;
  $sitemaplinks='';
  $items=preg_replace(
    '/<print content=[\"\']?contentType[\"\']?>/',
    '<a href="'.URL.$r1['contentType'].($r1['contentType']=='page'?'/'.str_replace(' ','-',strtolower(htmlspecialchars($r1['title'],ENT_QUOTES,'UTF-8'))):'').'">'.($r1['contentType']=='page'?ucwords(htmlspecialchars($r1['title'],ENT_QUOTES,'UTF-8')):ucwords($r1['contentType'])).'</a>',
  $items);
  $s2=$db->prepare("SELECT `rank`,`contentType`,`title`,`urlSlug`,`metaRobots`,`rank`,`active` FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='testimonials' AND `status`='published' AND `internal`!='1' ORDER BY `ti` DESC");
  $s2->execute([':contentType'=>$r1['contentType']]);
  while($r2=$s2->fetch(PDO::FETCH_ASSOC)){
    if(stristr($r2['metaRobots'],'noindex'))continue;
    if(stristr($r2['metaRobots'],'nofollow'))continue;
    if(stristr($r2['metaRobots'],'noimageindex'))continue;
    if(stristr($r2['metaRobots'],'noarchive'))continue;
    if(stristr($r2['metaRobots'],'nocache'))continue;
    if(stristr($r2['metaRobots'],'nosnippet'))continue;
    if(stristr($r2['metaRobots'],'noodp'))continue;
    if(stristr($r2['metaRobots'],'noydir'))continue;
    if($r2['rank']<$rank){
      $sitemaplinks.='<a href="'.$r1['contentType'].'/'.$r2['urlSlug'].'/">'.htmlspecialchars($r2['title'],ENT_QUOTES,'UTF-8').'</a><br>';
    }
  }
  $items=preg_replace('/<print links>/',$sitemaplinks,$items);
	$sitemapitems.=$items;
}
$html=preg_replace('~<items>.*?<\/items>~is',$sitemapitems,$html,1);
$content.=$html;
