<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Sitemap
 * @package    core/sitemap.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    Fix URL Slug reference going to brokwn URL.
 */
header('Content-type:text/xml');
require'db.php';
$config=$db->query("SELECT `comingsoon`,`maintenance` FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
echo'<?xml version="1.0" encoding="UTF-8"?>'.
  '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
if($config['comingsoon']==1||$config['maintenance']==1){
  echo'<url>'.
    '<loc>'.URL.'</loc>'.
    '<changefreq>daily</changefreq>'.
    '<priority>0.5</priority>'.
  '</url>';
}else{
  $s1=$db->query("SELECT `contentType`,`title`,`metaRobots`,`rank` FROM `".$prefix."menu` WHERE `active`='1' AND `contentType`!='proofx' AND `contentType`!='orders' AND `contentType`!='settings' AND `contentType`!='comingsoon' AND `contentType`!='maintenance' AND `contentType`!='offline' AND `contentType` !='checkout' AND `contentType`!='activate' AND `contentType`!='notification' ORDER BY `ord` ASC");
  while($r1=$s1->fetch(PDO::FETCH_ASSOC)){
    if(stristr($r1['metaRobots'],'noindex'))continue;
    if(stristr($r1['metaRobots'],'nofollow'))continue;
    if(stristr($r1['metaRobots'],'noimageindex'))continue;
    if(stristr($r1['metaRobots'],'noarchive'))continue;
    if(stristr($r1['metaRobots'],'nocache'))continue;
    if(stristr($r1['metaRobots'],'nosnippet'))continue;
    if(stristr($r1['metaRobots'],'noodp'))continue;
    if(stristr($r1['metaRobots'],'noydir'))continue;
    if($r1['rank']<100){
      echo'<url>'.
        '<loc>'.URL.($r1['contentType']=='index'?'':$r1['contentType'].'/').($r1['contentType']==='page'&&$r1['title']!=''?str_replace(' ','-',strtolower($r1['title'])):'').'</loc>'.
        '<changefreq>daily</changefreq>'.
        '<priority>0.64</priority>'.
      '</url>';
      $s2=$db->prepare("SELECT `rank`,`contentType`,`title`,`urlSlug`,`metaRobots`,`rank` FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='testimonials' AND `status`='published' AND `internal`!='1' ORDER BY `ti` DESC");
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
        if($r2['rank']<100){
          echo'<url>'.
            '<loc>'.URL.$r1['contentType'].'/'.strtolower($r2['urlSlug']).'/'.'</loc>'.
            '<changefreq>daily</changefreq>'.
            '<priority>0.64</priority>'.
          '</url>';
        }
      }
    }
  }
}
echo'</urlset>';
