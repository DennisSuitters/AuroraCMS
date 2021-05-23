<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Blacklist
 * @package    core/add_blacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    Fix URL Slug reference going to brokwn URL.
 */
header('Content-type:text/xml');
require'db.php';
$config=$db->query("SELECT `comingsoon`,`maintenance` FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
echo'<?xml version="1.0" encoding="UTF-8"?>'.
  '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
if($config['comingsoon'][0]==1||$config['maintenance'][0]==1){
  echo'<url>'.
    '<loc>'.URL.'</loc>'.
    '<changefreq>daily</changefreq>'.
    '<priority>0.64</priority>'.
  '</url>';
}else{
  $s=$db->query("SELECT `contentType` FROM `".$prefix."menu` WHERE `active`='1' AND `contentType`!='proofs' AND `contentType`!='orders' AND `contentType`!='settings' AND `contentType`!='comingsoon' AND `contentType`!='maintenance'");
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<url>'.
      '<loc>'.URL.($r['contentType']=='index'?'':$r['contentType'].'/').'</loc>'.
      '<changefreq>daily</changefreq>'.
      '<priority>0.64</priority>'.
    '</url>';
    $s2=$db->prepare("SELECT `contentType`,`title`,`urlSlug` FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='testimonials' AND `status`='published' AND `internal`!='1' ORDER BY ti DESC");
    $s2->execute([
      ':contentType'=>$r['contentType']
    ]);
    while($r2=$s2->fetch(PDO::FETCH_ASSOC)){
      echo'<url>'.
        '<loc>'.URL.$r['contentType'].'/'.$r2['urlSlug'].'/'.'</loc>'.
        '<changefreq>daily</changefreq>'.
        '<priority>0.64</priority>'.
      '</url>';
    }
  }
}
echo'</urlset>';
