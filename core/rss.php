<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Core - RSS Generator
 * @package    core/rss.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type:application/rss+xml;charset=ISO-8859-1');
require'db.php';
$config=$db->query("SELECT `seoTitle`,`seoCaption` FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if($args[0]==''||$args[0]=='index')$args[0]='%_%';
$ti=time();
echo'<?xml version="1.0"?><rss version="2.0"><channel>'.
      '<title>'.$config['seoTitle'].'</title>'.
      '<description>'.$config['seoCaption'].'</description>'.
      '<link>'.URL.'</link>'.
      '<copyright>Copyright '.date('Y',$ti).' '.$config['seoTitle'].'</copyright>'.
      '<generator>AuroraCMS - https://github.com/DiemenDesign/AuroraCMS</generator>'.
      '<pubDate>'.strftime("%a, %d %b %Y %T %Z",$ti).'</pubDate>'.
      '<ttl>60</ttl>';
$deffiletype=image_type_to_mime_type(exif_imagetype(FAVICON));
$deflength=filesize(FAVICON);
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `contentType`!='testimonials' AND `status`='published' AND `internal`!='1' ORDER BY `ti` DESC LIMIT 25");
$s->execute([':contentType'=>$args[0]]);
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  if(stristr($r['metaRobots'],'noindex'))continue;
  if(stristr($r['metaRobots'],'nofollow'))continue;
  if(stristr($r['metaRobots'],'noimageindex'))continue;
  if(stristr($r['metaRobots'],'noarchive'))continue;
  if(stristr($r['metaRobots'],'nocache'))continue;
  if(stristr($r['metaRobots'],'nosnippet'))continue;
  if(stristr($r['metaRobots'],'noodp'))continue;
  if(stristr($r['metaRobots'],'noydir'))continue;
  if($r['rank']<100){
    $img=FAVICON;
    $filetype=$deffiletype;
    $length=$deflength;
    if($r['contentType']!='gallery'){
      if($r['thumb']!=''&&file_exists('media/'.$r['thumb'])&&!stristr('http',$r['thumb'])){
        $img=$r['thumb'];
        $filetype=image_type_to_mime_type(exif_imagetype($r['thumb']));
        $file=basename($r['thumb']);
        $length=filesize('media/'.$file);
      }elseif($r['file']&&file_exists('media/'.$r['file'])&&!stristr('http',$r['file'])){
        $img=$r['file'];
        $filetype=image_type_to_mime_type(exif_imagetype($r['file']));
        $file=basename($r['file']);
        $length=filesize('media/'.$file);
      }else{
        $match=preg_match('/(src=["\'](.*?)["\'])/',rawurldecode($r['notes']),$match);
        $split=preg_split('/["\']/',(string)$match[0]);
        if($split[0]!=''){
          $img=$split[0];
          $filetype=image_type_to_mime_type(exif_imagetype($img));
          $length=strlen($img);
        }
      }
    }else{
      if(file_exists('media/'.$r['thumb'])){
        $img='media/'.$r['thumb'];
        $filetype=image_type_to_mime_type(exif_imagetype('media/'.$r['thumb']));
        $length=filesize('media/'.$r['thumb']);
      }else{
        $img='media/'.$r['file'];
        $filetype=image_type_to_mime_type(exif_imagetype('media/'.$r['file']));
        $length=filesize('media/'.$r['file']);
      }
    }
    echo'<item>'.
      '<title>'.$r['title'].' - '.ucfirst((string)$r['contentType']).' - '.$config['seoTitle'].'</title>'.
      '<description>'.($r['seoCaption']==""?preg_replace('/\s+/',' ',strip_tags(rawurldecode($r['notes']))):(string)$r['seoCaption']).'</description>'.
      '<link>'.URL.$r['contentType'].'/'.strtolower($r['urlSlug']).'/'.'</link>'.
      '<pubDate>'.date('c',$r['ti']).'</pubDate>'.
      '<enclosure url="'.$img.'" length="'.$length.'" type="'.$filetype.'"/>'.
    '</item>';
  }
}
echo'</channel></rss>';
