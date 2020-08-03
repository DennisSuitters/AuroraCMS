<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Error
 * @package    core/view/error.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.16 Reduce preg_replace parsing strings.
 * @changes    v0.0.18 Reformat source for legibility.
 */
$rank=0;
$notification='';
if(stristr($html,'<items')){
  if(stristr($html,'<settings')){
    preg_match('/<settings.*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
    $count=isset($matches[1])&&$matches[1]!=0?$matches[1]:$config['showItems'];
  }
  $html=preg_replace('/<settings.*>/','',$html);
  $counti=1;
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE status='published' AND internal!='1' ORDER BY rand()");
  $s->execute();
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $item=$matches[1];
  $output='';
  $si=1;
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $filechk=$noimage;
    $thumbchk=$noimage;
    if($r['contentType']=='testimonials'||$r['contentType']=='proofs')continue;
    $sr=$db->prepare("SELECT active FROM `".$prefix."menu` WHERE contentType=:contentType");
    $sr->execute([':contentType'=>$r['contentType']]);
    $pr=$sr->fetch(PDO::FETCH_ASSOC);
    if($pr['active']!=1)continue;
    if($r['status']!=$status)continue;
    $items=$item;
    $contentType=$r['contentType'];
    if($r['fileURL']!=''&&($r['thumb']==''||$r['file']=='')){
      $filechk=$r['fileURL'];
      $shareImage=$r['fileURL'];
    }else{
      if($r['thumb']!=''&&file_exists('media'.DS.'thumbs'.basename($r['thumb'])))
        $shareImage='media'.DS.'thumbs'.basename($r['thumb']);
      elseif($r['file']!=''&&file_exists('media'.DS.basename($r['file'])))
        $shareImage='media'.DS.basename($r['file']);
      else
        $shareImage=URL.NOIMAGE;
    }
    if($si==1)$si++;
    $su=$db->prepare("SELECT id,username,name FROM login WHERE id=:id");
    $su->execute([':id'=>$r['uid']]);
    $ua=$su->fetch(PDO::FETCH_ASSOC);
    $items=preg_replace([
      '/<print content=[\"\']?thumb[\"\']?>/',
      '/<print content=[\"\']?image[\"\']?>/',
      '/<print content=[\"\']?imageALT[\"\']?>/',
      '/<print content=[\"\']?file[\"\']?>/',
      '/<print content=[\"\']?title[\"\']?>/',
      '/<print profileLink>/',
      '/<print content=[\"\']?linktitle[\"\']?>/',
      '/<print content=[\"\']?author[\"\']?>/',
      '/<print content=[\"\']?dateCreated[\"\']?>/',
      '/<print content=[\"\']?datePublished[\"\']?>/',
      '/<print content=[\"\']?dateEdited[\"\']?>/',
      '/<print date=[\"\']?day[\"\']?>/',
      '/<print date=[\"\']?month[\"\']?>/',
      '/<print date=[\"\']?year[\"\']?>/',
      '/<print content=[\"\']?contentType[\"\']?>/',
      '/<print content=[\"\']?notes[\"\']?>/'
    ],[
      $shareImage,
      $shareImage,
      htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8'),
      $shareImage,
      htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
      URL.'profile/'.strtolower(str_replace(' ','-',htmlspecialchars($r['login_user'],ENT_QUOTES,'UTF-8'))).'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
      URL.$r['contentType'].'/'.$r['urlSlug'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
      htmlspecialchars(($ua['name']!=''?$ua['name']:$ua['username']),ENT_QUOTES,'UTF-8'),
      date($config['dateFormat'],$r['ti']),
      date($theme['settings']['dateFormat'],$r['pti']),
      date($theme['settings']['dateFormat'],$r['eti']),
      date('j',$r['tis']!=0?$r['tis']:$r['ti']),
      date('M',$r['tis']!=0?$r['tis']:$r['ti']),
      date('Y',$r['tis']!=0?$r['tis']:$r['ti']),
      $r['contentType'],
      ($view=='index'?substr(htmlspecialchars(strip_tags($r['notes']),ENT_QUOTES,'UTF-8'),0,300).'...':htmlspecialchars(strip_tags($r['notes']),ENT_QUOTES,'UTF-8'))
    ],$items);
    $r['notes']=strip_tags($r['notes']);
    if($r['contentType']=='testimonials'||$r['contentType']=='testimonial'){
      if(stristr($items,'<controls>'))
        $items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
      $controls='';
    }else{
      if(stristr($items,'<view>')){
        $items=preg_replace([
          '/<print content=[\"\']?linktitle[\"\']?>/',
          '/<print content=[\"\']?title[\"\']?>/',
          '/<[\/]?view>/'
        ],[
          URL.$r['contentType'].'/'.$r['urlSlug'].'/',
          htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
          ''
        ],$items);
      }
      if($r['contentType']=='service'||$r['contentType']=='events'){
        if($r['bookable']==1){
          if(stristr($items,'<service')){
            $items=preg_replace([
              '/<print content=[\"\']?bookservice[\"\']?>/',
              '/<[\/]?service>/',
              '~<inventory>.*?<\/inventory>~is'
            ],[
              $r['id'],
              '',
              ''
            ],$items);
          }
        }else{
          $items=preg_replace([
            '/<[\/]?inventory>/',
            '~<service.*?>.*?<\/service>~is'
          ],'',$items,1);
        }
      }else{
        $items=preg_replace([
          '/<[\/]?inventory>/',
          '~<service.*?>.*?<\/service>~is'
        ],'',$items,1);
      }
      if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
        if(stristr($items,'<inventory')){
          $items=preg_replace([
            '/<[\/]?inventory>/',
            '~<service>.*?<\/service>~is'
          ],'',$items);
        }elseif(stristr($items,'<inventory')&&$r['contentType']!='inventory'&&!is_numeric($r['cost']))
          $items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
      }else
        $items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
      $items=preg_replace('/<[\/]?controls>/','',$items);
    }
    require'core'.DS.'parser.php';
    $output.=$items;
    $counti++;
    if($counti>$count)break;
  }
  $html=preg_replace([
    '~<items>.*?<\/items>~is',
    '~<item>.*?<\/item>~is'
  ],[
    $output,
    ''
  ],$html,1);
}else
  $html=preg_replace('~<items>.*?<\/items>~is','',$html,1);
$html=preg_replace([
  '~<item>.*?<\/item>~is',
  '/<[\/]?items>/'
],'',$html);
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$seoTitle='404 Error'.($config['business']!=''?' - '.$config['business']:'');
$metaRobots='index,follow';
$seoCaption='';
$seoDescription='404 Error - Page has moved or non-existant';
$seoKeywords='';
$content.=$html;
