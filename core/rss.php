<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Core - RSS Generator
 * @package    core/rss.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type:application/rss+xml;charset=ISO-8859-1');
require'db.php';
$config=$db->query("SELECT `seoTitle`,`seoCaption` FROM `".$prefix."config"` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if($args[0]==''||$args[0]=='index')$args[0]='%_%';
$ti=time();
echo'<?xml version="1.0"?>';?>
<rss version="2.0">
  <channel>
    <title><?php echo$config['seoTitle'];?></title>
    <description><?php echo$config['seoCaption'];?></description>
    <link><?php echo URL;?></link>
    <copyright>Copyright <?php echo date('Y',$ti).' '.$config['seoTitle'];?></copyright>
    <generator>AuroraCMS - https://github.com/DiemenDesign/AuroraCMS</generator>
    <pubDate><?php echo strftime("%a, %d %b %Y %T %Z",$ti);?></pubDate>
    <ttl>60</ttl>
<?php $deffiletype=image_type_to_mime_type(exif_imagetype(FAVICON));
$deflength=filesize(FAVICON);
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `status`='published' AND `internal`!='1' ORDER BY `ti` DESC LIMIT 25");
$s->execute([
  ':contentType'=>$args[0]
]);
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $img=FAVICON;
  $filetype=$deffiletype;
  $length=$deflength;
  if($r['contentType']!='gallery'){
    if($r['thumb']!=''&&file_exists('media'.DS.$r['thumb'])&&!stristr('http',$r['thumb'])){
      $img=$r['thumb'];
      $filetype=image_type_to_mime_type(exif_imagetype($r['thumb']));
      $file=basename($r['thumb']);
      $length=filesize('media'.DS.$file);
    }elseif($r['file']&&file_exists('media'.DS.$r['file'])&&!stristr('http',$r['file'])){
      $img=$r['file'];
      $filetype=image_type_to_mime_type(exif_imagetype($r['file']));
      $file=basename($r['file']);
      $length=filesize('media'.DS.$file);
    }else{
      $match=preg_match('/(src=["\'](.*?)["\'])/',rawurldecode($r['notes']),$match);
      $split=preg_split('/["\']/',$match[0]);
      if($split[0]!=''){
        $img=$split[0];
        $filetype=image_type_to_mime_type(exif_imagetype($img));
        $length=strlen($img);
      }
    }
  }else{
    if(file_exists('media'.DS.$r['thumb'])){
      $img='media'.DS.$r['thumb'];
      $filetype=image_type_to_mime_type(exif_imagetype('media'.DS.$r['thumb']));
      $length=filesize('media'.DS.$r['thumb']);
    }else{
      $img='media'.DS.$r['file'];
      $filetype=image_type_to_mime_type(exif_imagetype('media'.DS.$r['file']));
      $length=filesize('media'.DS.$r['file']);
    }
  }?>
    <item>
      <title><?php echo$r['title'].' - '.ucfirst($r['contentType']).' - '.$config['seoTitle'];?></title>
      <description><?php echo($r['seoCaption']==""?strip_tags(rawurldecode($r['notes'])):$r['seoCaption']);?></description>
      <link><?php echo URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r['title'])).'/';?></link>
      <pubDate><?php echo strftime("%a, %d %b %Y %T %Z",$r['ti']);?></pubDate>
      <enclosure url="<?php echo$img;?>" length="<?php echo$length;?>" type="<?php echo$filetype;?>"/>
    </item>
<?php }?>
  </channel>
</rss>
