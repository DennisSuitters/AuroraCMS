<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Blacklist
 * @package    core/add_blacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-type:text/xml');
require'db.php';
$config=$db->query("SELECT `comingsoon`,`maintenance` FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
echo'<?xml version="1.0" encoding="UTF-8"?>';?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php
if($config['comingsoon'][0]==1||$config['maintenance'][0]==1){?>
  <url>
    <loc><?php echo URL;?></loc>
    <changefreq>daily</changefreq>
    <priority>0.64</priority>
  </url>
<?php }else{
  $s=$db->query("SELECT `contentType` FROM `".$prefix."menu` WHERE `active`='1' AND `contentType`!='proofs' AND `contentType`!='orders' AND `contentType`!='settings' AND `contentType`!='comingsoon' AND `contentType`!='maintenance'");
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
  <url>
    <loc><?php echo URL.($r['contentType']=='index'?'':$r['contentType'].'/');?></loc>
    <changefreq>daily</changefreq>
    <priority>0.64</priority>
  </url>
<?php $s2=$db->prepare("SELECT `contentType`,`title` FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='testimonials' AND `status`='published' AND `internal`!='1' ORDER BY ti DESC");
    $s2->execute([
      ':contentType'=>$r['contentType']
    ]);
    while($r2=$s2->fetch(PDO::FETCH_ASSOC)){?>
  <url>
    <loc><?php echo URL.$r['contentType'].'/'.url_encode($r2['title']).'/';?></loc>
    <changefreq>daily</changefreq>
    <priority>0.64</priority>
  </url>
<?php }
  }
}?>
</urlset>
