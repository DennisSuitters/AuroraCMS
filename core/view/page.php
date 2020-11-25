<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Page
 * @package    core/view/page.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$html=str_replace('<print view>',$view,$html);
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `contentType`=:contentType AND LOWER(`title`)=LOWER(:title)");
$s->execute([
  ':contentType'=>$view,
  ':title'=>str_replace('-',' ',$args[0])
]);
$r=$s->fetch(PDO::FETCH_ASSOC);
if(stristr($html,'<print page="coverVideo">')){
  if($r['coverVideo']!=''){
    $cover=basename($r['coverVideo']);
    if(stristr($r['coverVideo'],'youtu')){
      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$r['coverVideo'],$vidMatch);
      $videoHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.($r['options'][0]==1?'autoplay=1&':'').($r['options'][1]==1?'loop=1&':'').($r['options'][2]==1?'controls=1&':'controls=0&').'" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
    }elseif(stristr($r['coverVideo'],'vimeo')){
      preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$r['coverVideo'],$vidMatch);
      $videoHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.($r['options'][0]==1?'autoplay=1&':'').($r['options'][1]==1?'loop=1&':'').($r['options'][2]==1?'controls=1&':'controls=0&').'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
    }else
      $videoHTML='<div class="embed-responsive embed-responsive-16by9"><video class="embed-responsive-item" preload autoplay loop muted><source src="'.htmlspecialchars($r['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video></div>';
    $html=preg_replace(
      '/<print page=[\"\']?coverVideo[\"\']?>/',
      $videoHTML,
      $html
    );
  }else
    $html=preg_replace('/<print page=[\"\']?coverVideo[\"\']?>/','',$html);
}
if(stristr($html,'<print page=cover>')){
  if($r['cover']!=''||$r['coverURL']!=''){
    $cover=basename($r['cover']);
    $coverLink='';
    if(isset($r['cover'])&&$r['cover']!='')
      $coverLink.='media'.DS.$cover;
    elseif($r['coverURL']!='')
      $coverLink.=$r['coverURL'];
    $html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','background-image:url('.htmlspecialchars($coverLink,ENT_QUOTES,'UTF-8').');',$html);
  }else
    $html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','',$html);
}
if(preg_match('/<print page=[\"\']?cover[\"\']?>/',$html)){
  if($r['cover']!=''||$r['coverURL']!=''){
    $cover=basename($r['cover']);
    list($width,$height)=getimagesize($r['cover']);
    $coverHTML='<img src="';
    if(file_exists('media'.DS.$cover))
      $coverHTML.=htmlspecialchars($r['cover'],ENT_QUOTES,'UTF-8');
    elseif($r['coverURL']!='')
      $coverHTML.=htmlspecialchars($r['coverURL'],ENT_QUOTES,'UTF-8');
    $coverHTML.='" alt="';
    if($r['attributionImageTitle']==''&&$r['attributionImageName']==''&&$r['attributionImageURL']==''){
      if($r['attributionImageTitle'])
        $coverHTML.=$r['attributionImageTitle'].$r['attributionImageName']!=''?' - ':'';
      if($r['attributionImageName'])
        $coverHTML.=$r['attributionImageName'].$r['attributionImageURL']!=''?' - ':'';
      if($r['attributionImageURL'])
        $coverHTML.=htmlspecialchars($r['attributionImageURL'],ENT_QUOTES,'UTF-8');
    }else
      $coverHTML.=$r['seoTitle']!=''?$r['seoTitle']:$config['seoTitle'];
    if($r['seoTitle']==''&&$config['seoTitle']=='')
      $coverHTML.=htmlspecialchars(basename($r['cover']),ENT_QUOTES,'UTF-8');
    $coverHTML.='">';
  }else
    $coverHTML='';
  $html=preg_replace([
    '/<print page=[\"\']?cover[\"\']?>/',
    '/<print page=[\"\']?fileALT[\"\']?>/'
  ],[
    $coverHTML,
    htmlspecialchars($r['fileALT'],ENT_QUOTES,'UTF-8')
  ],$html);
}
if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
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
$html=preg_replace([
  '/<print content=[\"\']?title[\"\']?>/',
  '/<print content=[\"\']?notes[\"\']?>/',
  '/<print content=[\"\']?schemaType[\"\']?>/',
  '/<cost>([\w\W]*?)<\/cost>/',
  '/<review>([\w\W]*?)<\/review>/',
  '/<author>([\w\W]*?)<\/author>/',
  '/<settings([\w\W]*?)>/',
  '/<print page=[\"\']?notes[\"\']?>/',
  '/<items>([\w\W]*?)<\/items>/',
  '/<more>([\w\W]*?)<\/more>/',
  '/<[\/]?item>/'
],[
  $r['title'],
  rawurldecode($page['notes']),
  $r['contentType'],
  '',
  '',
  '',
  '',
  '',
  '',
  ''
],$html);
$items=$html;
include'core'.DS.'parser.php';
$html=$items;
$seoTitle=empty($r['seoTitle'])?trim(htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8')):htmlspecialchars($r['seoTitle'],ENT_QUOTES,'UTF-8');
$metaRobots=!empty($r['metaRobots'])?htmlspecialchars($r['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
$seoCaption=!empty($r['seoCaption'])?htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
$seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
$seoDescription=!empty($r['seoDescription'])?htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
$seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
$seoKeywords=!empty($r['seoKeywods'])?htmlspecialchars($r['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');
$seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;
$content.=$html;
