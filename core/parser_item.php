<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Parser Item
 * @package    core/parser_item.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
$html=preg_replace([
  '~<contentitems>.*?<\/contentitems>~is',
  '~<section data-content="content-items">.*?<\/section>~is',
  '~<pagenotes>.*?<\/pagenotes>~is',
  '~<sort>.*?<\/sort>~is',
  '~<items>.*?<\/items>~is'
],'',$html,1);
$r=$s->fetch(PDO::FETCH_ASSOC);
$seoTitle=$r['seoTitle']==''?$r['title']:$r['seoTitle'];
$metaRobots=$r['metaRobots']==''?$r['metaRobots']:$page['metaRobots'];
$seoCaption=$r['seoCaption']==''?$r['seoCaption']:$page['seoCaption'];
$seoDescription=$r['seoDescription']!=''?$r['seoDescription']:($r['seoCaption']!=''?$r['seoCaption']:substr(strip_tags($r['notes']),0,160));
$seoKeywords=$r['seoKeywords']==''?$r['seoKeywords']:$page['seoKeywords'];
$su=$db->prepare("UPDATE `".$prefix."content` SET `views`=:views WHERE `id`=:id");
$su->execute([
  ':views'=>$r['views']+1,
  ':id'=>$r['id']
]);
$us=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
$us->execute([
  ':uid'=>$r['uid']
]);
$ua=$us->fetch(PDO::FETCH_ASSOC);
if($r['fileURL']!='')
  $shareImage=$r['fileURL'];
elseif($r['file']!='')
  $shareImage=rawurldecode($r['file']);
elseif($r['thumb']!='')
  $shareImage=rawurldecode($r['thumb']);
else
  $shareImage=URL.NOIMAGE;
$canonical=URL.$view.'/'.$r['urlSlug'].'/';
$contentTime=isset($r['eti'])&&($r['eti']>$r['ti'])?$r['eti']:isset($r['ti'])?$r['ti']:0;
if(stristr($html,'<breadcrumb>')){
  $jsoni=2;
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsonld='<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"'.URL.'","name":"Home"}},';
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  $breadit=preg_replace([
    '/<active>/',
    '/<print breadcrumb=[\"\']?url[\"\']?>/',
    '/<print breadcrumb=[\"\']?title[\"\']?>/'
  ],[
    '',
    URL,
    'Home'
  ],$breaditem);
  $breaditems=$breadit;
  if($r['title']!=''||$r['category_1']!=''){
    $breadit=preg_replace([
      '/<print breadcrumb=[\"\']?url[\"\']?>/',
      '/<print breadcrumb=[\"\']?title[\"\']?>/'
    ],[
      URL.urlencode($page['contentType']),
      htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8')
    ],$breaditem);
  }else{
    $breadit=preg_replace([
      '/<print breadcrumb=[\"\']?title[\"\']?>/'
    ],[
      htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8')
    ],$breadcurrent);
  }
  $jsonld.='{"@type":"ListItem","position":2,"item":{"@id":"'.URL.urlencode($page['contentType']).'","name":"'.htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8').'"}},';
  $breaditems.=$breadit;
  if($r['category_1']!=''){
    $jsoni++;
    if($r['category_1']!=''){
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?url[\"\']?>/',
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])),
        htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8')
      ],$breaditem);
    }else{
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8')
      ],$breadcurrent);
    }
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])).'","name":"'.htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8').'"}},';
    $breaditems.=$breadit;
  }
  if($r['category_2']!=''){
    $jsoni++;
    if($r['category_2']!=''){
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?url[\"\']?>/',
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])).'/'.str_replace(' ','-',urlencode($r['category_2'])),
        htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8')
      ],$breaditem);
    }else{
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8')
      ],$breadcurrent);
    }
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])).'/'.str_replace(' ','-',urlencode($r['category_2'])).'","name":"'.htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8').'"}},';
    $breaditems.=$breadit;
  }
  if($r['category_3']!=''){
    $jsoni++;
    if($r['category_3']!=''){
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?url[\"\']?>/',
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])).'/'.str_replace(' ','-',urlencode($r['category_2'])).'/'.str_replace(' ','-',urlencode($r['category_3'])),
        htmlspecialchars($r['category_3'],ENT_QUOTES,'UTF-8')
      ],$breaditem);
    }else{
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        htmlspecialchars($r['category_3'],ENT_QUOTES,'UTF-8')
      ],$breadcurrent);
    }
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])).'/'.str_replace(' ','-',urlencode($r['category_2'])).'/'.str_replace(' ','-',urlencode($r['category_3'])).'","name":"'.htmlspecialchars($r['category_3'],ENT_QUOTES,'UTF-8').'"}},';
    $breaditems.=$breadit;
  }
  if($r['category_4']!=''){
    $jsoni++;
    if($r['category_3']!=''){
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?url[\"\']?>/',
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])).'/'.str_replace(' ','-',urlencode($r['category_2'])).'/'.str_replace(' ','-',urlencode($r['category_3'])).'/'.str_replace(' ','-',urlencode($r['category_4'])),
        htmlspecialchars($r['category_4'],ENT_QUOTES,'UTF-8')
      ],$breaditem);
    }else{
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        htmlspecialchars($r['category_4'],ENT_QUOTES,'UTF-8')
      ],$breadcurrent);
    }
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.urlencode($page['contentType']).'/'.str_replace(' ','-',urlencode($r['category_1'])).'/'.str_replace(' ','-',urlencode($r['category_2'])).'/'.str_replace(' ','-',urlencode($r['category_3'])).'/'.str_replace(' ','-',urlencode($r['category_4'])).'","name": "'.htmlspecialchars($r['category_4'],ENT_QUOTES,'UTF-8').'"}},';
    $breaditems.=$breadit;
  }
  $jsoni++;
  if($r['title']!=''){
    $breadit=preg_replace([
      '/<print breadcrumb=[\"\']?title[\"\']?>/'
    ],[
      htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8')
    ],$breadcurrent);
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.urlencode($page['contentType']).'/'.urlencode($r['urlSlug']).'","name":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'"}}]}</script>';
    $breaditems.=$breadit;
  }
  $html=preg_replace([
    '/<[\/]?breadcrumb>/',
    '/<json-ld-breadcrumb>/',
    '~<breaditems>.*?<\/breaditems>~is'
  ],[
    '',
    $jsonld,
    $breaditems
  ],$html);
}
if(stristr($html,'<cover>')){
  if($r['fileURL']){
    $html=preg_replace([
      '/<[\/]?cover>/',
      '/<print page=[\"\']?coverItem[\"\']?>/'
    ],[
      '',
      '<img src="'.$r['fileURL'].'" alt="'.($r['fileALT']!=''?$r['fileALT']:$r['attributionImageTitle']).'">'
    ],$html);
  }elseif($r['file']){
    $r['file']=rawurldecode($r['file']);
    $html=preg_replace([
      '/<[\/]?cover>/',
      '/<print page=[\"\']?coverItem[\"\']?>/'
    ],[
      '',
      '<img srcset="'.($r['file']!=''&&file_exists('media'.DS.basename($r['file']))?'media'.DS.basename($r['file']).' '.$config['mediaMaxWidth'].'w,':'').($r['file']!=''&&file_exists('media'.DS.'lg'.DS.basename($r['file']))?'media'.DS.'lg'.DS.basename($r['file']).' 1000w,':'').($r['file']!=''&&file_exists('media'.DS.'md'.DS.basename($r['file']))?'media'.DS.'md'.DS.basename($r['file']).' 600w,':'').($r['file']!=''&&file_exists('media'.DS.'sm'.DS.basename($r['file']))?'media'.DS.'sm'.DS.basename($r['file']).' 400w':'').'" src="'.$r['file'].'" alt="'.($r['fileALT']!=''?$r['fileALT']:$r['attributionImageTitle']).'">'
    ],$html);
  }elseif($page['file']){
    $page['file']=rawurldecode($page['file']);
    $html=preg_replace([
      '/<[\/]?cover>/',
      '/<print page=[\"\']?coverItem[\"\']?>/'
    ],[
      '',
      '<img srcset="'.($page['file']!=''&&file_exists('media'.DS.basename($page['file']))?'media'.DS.basename($page['file']).' '.$config['mediaMaxWidth'].'w,':'').($page['file']!=''&&file_exists('media'.DS.'lg'.DS.basename($page['file']))?'media'.DS.'lg'.DS.basename($page['file']).' 1000w,':'').($page['file']!=''&&file_exists('media'.DS.'md'.DS.basename($page['file']))?'media'.DS.'md'.DS.basename($page['file']).' 600w,':'').($page['file']!=''&&file_exists('media'.DS.'sm'.DS.basename($page['file']))?'media'.DS.'sm'.DS.basename($page['file']).' 400w':'').'" src="'.$page['file'].'" alt="'.($page['fileALT']!=''?$page['fileALT']:$page['attributionImageTitle']).'">'
    ],$html);
  }elseif($page['coverURL']){
    $html=preg_replace([
      '/<[\/]?cover>/',
      '/<print page=[\"\']?coverItem[\"\']?>/'
    ],[
      '',
      '<img src="'.$page['coverURL'].'" alt="'.($r['fileALT']!=''?$r['fileALT']:$r['attributionImageTitle']).'">'
    ],$html);
  }else
    $html=preg_replace('~<cover>.*?<\/cover>~is','',$html);
}
if($r['videoURL']!=''){
  $html=preg_replace([
    '/<[\/]?videoviewer>/',
    '~<image>.*?<\/image>~is',
    '~<panoramic>.*?<\/panoramic>~is',
    '~<360viewer>.*?<\/360viewer>~is'
  ],'',$html);
  if($r['videoURL']!=''){
    $cover=basename(rawurldecode($r['videoURL']));
    if(stristr($r['videoURL'],'youtu')){
      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$r['videoURL'],$vidMatch);
      $videoHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.($r['options'][4]==1?'autoplay=1&':'').($r['options'][5]==1?'loop=1&':'').($page['options'][6]==1?'controls=1&':'controls=0&').'" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
    }elseif(stristr($r['videoURL'],'vimeo')){
      preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$r['videoURL'],$vidMatch);
      $videoHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.($r['options'][4]==1?'autoplay=1&':'').($r['options'][5]==1?'loop=1&':'').($r['options'][6]==1?'controls=1&':'controls=0&').'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
    }else
      $videoHTML='<div class="embed-responsive embed-responsive-16by9"><video class="embed-responsive-item" preload autoplay loop muted><source src="'.htmlspecialchars($r['videoURL'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video></div>';
    $html=preg_replace(
      '/<print content=[\"\']?video[\"\']?>/',
      $videoHTML,
      $html
    );
  }else
    $html=preg_replace('/<print content=[\"\']?video[\"\']?>/','',$html);
}elseif($r['options'][3]==1&&$r['file']!=''){
  $r['file']=rawurldecode($r['file']);
  $html=preg_replace([
    '/<[\/]?360viewer>/',
    '~<image>.*?<\/image>~is',
    '~<panoramic>.*?<\/panoramic>~is',
    '~<videoviewer>.*?<\/videoviewer>~is'
  ],'',$html);
  if($r['fileURL'])
    $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['fileURL'],$html);
  elseif($r['file']&&file_exists('media'.DS.basename($r['file'])))
    $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['file'],$html);
  else
    $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',NOIMAGE,$html);
  $html=preg_replace('/<print content=[\"\']?imageALT[\"\']?>/',htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8'),$html);
}elseif($r['options'][2]==1&&$r['file']!=''){
  $r['file']=rawurldecode($r['file']);
  $html=preg_replace([
    '/<[\/]?panoramic>/',
    '~<image>.*?<\/image>~is',
    '~<360viewer>.*?<\/360viewer>~is',
    '~<videoviewer>.*?<\/videoviewer>~is'
  ],'',$html);
  if($r['fileURL'])
    $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['fileURL'],$html);
  elseif($r['file']&&file_exists('media'.DS.basename($r['file'])))
    $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['file'],$html);
  else
    $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',NOIMAGE,$html);
  $html=preg_replace('/<print content=[\"\']?imageALT[\"\']?>/',htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8'),$html);
}else{
  $r['file']=rawurldecode($r['file']);
  $html=preg_replace([
    '~<panoramic>.*?<\/panoramic>~is',
    '~<360viewer>.*?<\/360viewer>~is',
    '~<videoviewer>.*?<\/videoviewer>~is'
  ],'',$html);
  if($r['fileURL']){
    $html=preg_replace([
      '/<print content=[\"\']?image[\"\']?>/'
    ],[
      $r['fileURL']
    ],$html);
  }elseif($r['file']!=''&&file_exists('media'.DS.basename($r['file']))){
    $caption='';
    if($r['attributionImageTitle']!='')$caption.=$r['attributionImageTitle'];
    if($r['attributionImageName']!=''){
      $caption.=$caption!=''?' by ':'';
      if($r['attributionImageURL']!='')$caption.='<a href="'.$r['attributionImageURL'].'" target="_blank">';
      $caption.=$r['attributionImageName'];
      if($r['attributionImageURL']!='')$caption.='</a>';
    }
    $html=preg_replace([
      '/<[\/]?image>/',
      '/<print content=[\"\']?srcset[\"\']?>/',
      '/<print content=[\"\']?image[\"\']?>/',
      '/<print content=[\"\']?figcaption[\"\']?>/',
      '/<print content=[\"\']?imageALT[\"\']?>/'
    ],[
      '',
      'srcset="'.($r['file']!=''&&file_exists('media'.DS.basename($r['file']))?'media'.DS.basename($r['file'].' '.$config['mediaMaxWidth'].'w,'):'').($r['file']!=''&&file_exists('media'.DS.'lg'.DS.basename($r['file']))?'media'.DS.'lg'.DS.basename($r['file'].' 1000w,'):'').($r['file']!=''&&file_exists('media'.DS.'md'.DS.basename($r['file']))?'media'.DS.'md'.DS.basename($r['file'].' 600w,'):'').($r['file']!=''&&file_exists('media'.DS.'sm'.DS.basename($r['file']))?'media'.DS.'sm'.DS.basename($r['file'].' 400w'):'').'" ',
      ($r['file']!=''&&file_exists('media'.DS.basename($r['file']))?'media'.DS.basename($r['file']):NOIMAGE),
      $caption,
      htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8')
    ],$html);
  }else{
    $html=preg_replace([
      '~<image>.*?<\/image>~is'
    ],[
      ''
    ],$html);
  }
}
if(stristr($html,'<item')){
  preg_match('/<item>([\w\W]*?)<\/item>/',$html,$matches);
  $item=$matches[1];
  if(stristr($item,'<mediaitems')){
    $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `pid`=:pid AND `rid`=:rid AND `rank`<=:rank ORDER BY `ord` ASC");
    $sm->execute([
      ':pid'=>isset($r['id'])?$r['id']:$page['id'],
      ':rid'=>$r['id'],
      ':rank'=>$_SESSION['rank']
    ]);
    if($sm->rowCount()>0){
      preg_match('/<mediaitems>([\w\W]*?)<\/mediaitems>/',$item,$matches2);
      $media=$matches2[1];
      preg_match('/<mediaimages>([\w\W]*?)<\/mediaimages>/',$item,$matches3);
      $mediaitem=$matches3[1];
      $mediaoutput='';
      while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
        $mediaitems=$mediaitem;
        if(!file_exists('media/thumbs/'.basename($rm['file'])))continue;
        $rm['file']=rawurldecode($rm['file']);
        $mediaitems=preg_replace([
          '/<print media=[\"\']?id[\"\']?>/',
          '/<print thumb=[\"\']?srcset[\"\']?>/',
          '/<print lightbox=[\"\']?srcset[\"\']?>/',
          '/<print media=[\"\']?thumb[\"\']?>/',
          '/<print media=[\"\']?file[\"\']?>/',
          '/<print media=[\"\']?caption[\"\']?>/',
          '/<print media=[\"\']?fileALT[\"\']?>/',
          '/<print media=[\"\']?title[\"\']?>/'
        ],[
          $rm['id'],
          'srcset="'.
            ($rm['file']!=''&&file_exists('media'.DS.'thumbs'.DS.basename($rm['file']))?'media'.DS.'thumbs'.DS.basename($rm['file']).' '.$config['mediaMaxWidthThumb'].'w,':'').
            ($rm['file']!=''&&file_exists('media'.DS.'md'.DS.basename($rm['file']))?'media'.DS.'md'.DS.basename($rm['file']).' 600w,':'').
            ($rm['file']!=''&&file_exists('media'.DS.'sm'.DS.basename($rm['file']))?'media'.DS.'sm'.DS.basename($rm['file']).' 400w':'').'" ',
          ($rm['file']!=''&&file_exists('media'.DS.basename($rm['file']))?'media'.DS.basename($rm['file']).' '.$config['mediaMaxWidth'].'w, ':'').
            ($rm['file']!=''&&file_exists('media'.DS.'lg'.DS.basename($rm['file']))?'media'.DS.'lg'.DS.basename($rm['file']).' 1000w,':'').
            ($rm['file']!=''&&file_exists('media'.DS.'md'.DS.basename($rm['file']))?'media'.DS.'md'.DS.basename($rm['file']).' 600w,':'').
            ($rm['file']!=''&&file_exists('media'.DS.'sm'.DS.basename($rm['file']))?'media'.DS.'sm'.DS.basename($rm['file']).' 400w':''),
          ($rm['file']!=''&&file_exists('media'.DS.'thumbs'.DS.basename($rm['file']))?'media'.DS.'thumbs'.DS.basename($rm['file']):NOIMAGESM),
          $rm['file'],
          htmlspecialchars(($rm['title']!=''?$rm['title']:$r['title'].': Image '.$rm['id']),ENT_QUOTES,'UTF-8'),
          htmlspecialchars(($rm['fileALT']!=''?$rm['fileALT']:basename($rm['file'])),ENT_QUOTES,'UTF-8'),
          isset($rm['title'])&&$rm['title']!=''?htmlspecialchars(($rm['title']!=''?basename($rm['title']):basename($rm['file'])),ENT_QUOTES,'UTF-8'):basename($rm['file'])
        ],$mediaitems);
        $mediaoutput.=$mediaitems;
      }
      $item=preg_replace([
        '~<mediaimages>.*?<\/mediaimages>~is',
        '/<[\/]?mediaitems>/'
      ],[
        $mediaoutput,
        ''
      ],$item,1);
    }else
      $item=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$item,1);
  }
  if(isset($r['contentType'])&&($r['contentType']=='service'||$r['contentType']=='events')){
    if($r['bookable']==1){
      if(stristr($item,'<service>')){
        $item=preg_replace([
          '/<[\/]?service>/',
          '~<inventory>.*?<\/inventory>~is',
          '/<print content=[\"\']?bookservice[\"\']?>/'
        ],[
          '',
          '',
          $r['id']
        ],$item);
      }
    }else{
      $item=preg_replace([
        '~<service.*?>.*?<\/service>~is',
        '~<inventory>.*?<\/inventory>~is'
      ],'',$item,1);
    }
  }else{
    $item=preg_replace([
      '~<service.*?>.*?<\/service>~is',
      '/<[\/]?inventory>/'
    ],'',$item,1);
  }
  $address=$edit=$contentQuantity='';
  if(isset($r['contentType'])&&($r['contentType']=='inventory')){
    $item=preg_replace([
      '/<[\/]?quantity>/',
      '/<print content=[\"\']?quantity[\"\']?>/',
      '/<print content=[\"\']?stock[\"\']?>/'
    ],[
      '',
      ($r['quantity']==0?'out of stock':$r['quantity']),
      ($r['stockStatus']=='quantity'?($r['quantity']>0?'in stock':'out of stock'):($r['stockStatus']=='none'?'':$r['stockStatus']))
    ],$item);
  }else
    $item=preg_replace('~<quantity>.*?<\/quantity>~is','',$item);
  if(stristr($item,'<condition>')){
    if($r['itemCondition']!=''){
      $item=preg_replace([
        '/<[\/]?condition>/',
        '/<print content=[\"\']?condition[\"\']?>/'
      ],[
        '',
        $r['itemCondition'],
      ],$item);
    }else
      $item=preg_replace('~<condition>.*?<\/condition>~is','',$item);
  }
  if(stristr($item,'<weight>')){
    if($r['weight']!=''){
      $item=preg_replace([
        '/<[\/]?weight>/',
        '/<print content=[\"\']?weight[\"\']?>/'
      ],[
        '',
        $r['weight'].$r['weightunit'],
      ],$item);
    }else
      $item=preg_replace('~<weight>.*?<\/weight>~is','',$item);
  }
  if(stristr($item,'<size>')){
    if($r['width']!=''&&$r['height']!=''&&$r['length']!=''){
      $item=preg_replace([
        '/<[\/]?size>/',
        '/<print content=[\"\']?width[\"\']?>/',
        '/<print content=[\"\']?height[\"\']?>/',
        '/<print content=[\"\']?length[\"\']?>/'
      ],[
        '',
        $r['width'].$r['widthunit'],
        $r['height'].$r['heightunit'],
        $r['length'].$r['lengthunit']
      ],$item);
    }else
      $item=str_replace('~<size>.*?<\/size>~is','',$item);
  }
  if(stristr($item,'<brand>')){
    if($r['width']!=''&&$r['height']!=''&&$r['length']!=''){
      $sb=$db->prepare("SELECT `id`,`title`,`url`,`icon` FROM `".$prefix."choices` WHERE `contentType`='brand' AND `id`=:id");
      $sb->execute([
        ':id'=>$r['brand']
      ]);
      $rb=$sb->fetch(PDO::FETCH_ASSOC);
      $rb['icon']=rawurldecode($rb['icon']);
      $brand=($rb['url']!=''?'<a href="'.$rb['url'].'">':'').($rb['icon']==''?$rb['title']:'<img src="media'.DS.basename($rb['icon']).'" alt="'.$rb['title'].'" title="'.$rb['title'].'">').($rb['url']!=''?'</a>':'');
      $item=preg_replace([
        '/<[\/]?brand>/',
        '/<print brand>/',
      ],[
        '',
        $brand,
      ],$item);
    }else
      $item=preg_replace('~<brand>.*?<\/brand>~is','',$item);
  }
  if(stristr($item,'<choices')){
    $scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:id ORDER BY `title` ASC");
    $scq->execute([
      ':id'=>isset($r['id'])?$r['id']:$page['id']
    ]);
    if($scq->rowCount()>0){
      $choices='<select class="choices form-control" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
      while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
        if($rcq['ti']==0)continue;
        $choices.='<option value="'.$rcq['id'].'">'.htmlspecialchars($rcq['title'],ENT_QUOTES,'UTF-8').':'.$rcq['ti'].'</option>';
      }
      $choices.='</select>';
      $item=str_replace('<choices>',$choices,$item);
    }else
      $item=str_replace('<choices>','',$item);
  }else
    $item=str_replace('<choices>','',$item);
  if(stristr($item,'<json-ld>')){
    $r['schemaType']=isset($r['schemaType'])?$r['schemaType']:$page['schemaType'];
    $r['notes']=isset($r['notes'])?$r['notes']:$page['notes'];
    $r['business']=isset($r['business'])?$r['business']:$config['business'];
    $r['pti']=isset($r['pti'])?$r['pti']:$page['ti'];
    $r['ti']=isset($r['ti'])?$r['ti']:$page['ti'];
    $r['eti']=isset($r['eti'])?$r['eti']:$page['eti'];
    $jsonld='<script type="application/ld+json">{"@context":"http://schema.org/",';
    if($r['schemaType']=='blogPosting'){
      $jsonld.='"@type":"BlogPosting","headline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'","alternativeHeadline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'","image":{"@type":"ImageObject","url":"';
      if($r['file']!=''&&file_exists('media/'.basename($r['file'])))
        $jsonld.='media'.DS.basename($r['file']).'"';
      else
        $jsonld.=FAVICON.'"';
      $jsonld.='},"editor":"'.htmlspecialchars(($ua['name']!=''?$ua['name']:$ua['username']),ENT_QUOTES,'UTF-8').'","genre":"'.($r['category_1']!=''?htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8'):'None').($r['category_2']!=''?' > '.htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8'):'').($r['category_3']!=''?' > '.htmlspecialchars($r['category_3'],ENT_QUOTES,'UTF-8'):'').($r['category_4']!=''?' > '.htmlspecialchars($r['category_4'],ENT_QUOTES,'UTF-8'):'').'","mainEntityOfPage":"True","keywords":"'.htmlspecialchars($seoKeywords,ENT_QUOTES,'UTF-8').'","wordcount":"'.htmlspecialchars(strlen(strip_tags($r['notes'])),ENT_QUOTES,'UTF-8').'","publisher":{"@type":"Organization","name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'","logo":{"@type":"ImageObject","url":"'.URL.FAVICON.'","width":"400","height":"55"}},"url":"'.$canonical.'","datePublished":"'.date('Y-m-d',$r['pti']).'","dateCreated":"'.date('Y-m-d',$r['ti']).'","dateModified":"'.date('Y-m-d',$r['eti']).'","description":"'.htmlspecialchars($seoDescription,ENT_QUOTES,'UTF-8').'","articleBody":"'.htmlspecialchars(strip_tags($r['notes']),ENT_QUOTES,'UTF-8').'","author":{"@type":"Person","name":"'.($ua['name']!=''?htmlspecialchars($ua['name'],ENT_QUOTES,'UTF-8'):htmlspecialchars($ua['username'],ENT_QUOTES,'UTF-8')).'"}';
    }elseif($r['schemaType']=='Product'){
      $jsonld.='"@type":"Product","name":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'","image":{"@type":"ImageObject","url":"';
      if($r['file']!=''&&file_exists('media'.DS.basename($r['file'])))
        $jsonld.='media'.DS.basename($r['file']).'"';
      else
        $jsonld.=FAVICON.'"';
      $jsonld.='},"description":"'.($seoDescription!=''?htmlspecialchars($seoDescription,ENT_QUOTES,'UTF-8'):htmlspecialchars(strip_tags(escaper($r['notes'])),ENT_QUOTES,'UTF-8')).'","mpn":"'.($r['barcode']==''?$r['id']:htmlspecialchars($r['barcode'],ENT_QUOTES,'UTF-8')).'","sku":"'.($r['fccid']==''?$r['id']:htmlspecialchars($r['fccid'],ENT_QUOTES,'UTF-8')).'","brand":{"@type":"Thing","name":"'.htmlspecialchars($r['brand'],ENT_QUOTES,'UTF-8').'"},';
      $jss=$db->prepare("SELECT AVG(`cid`) as rate,COUNT(`id`) as cnt FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid AND status='approved'");
      $jss->execute([
        ':rid'=>$r['id']
      ]);
      $jrr=$jss->fetch(PDO::FETCH_ASSOC);
      $jsonld.='"aggregateRating":{"@type":"aggregateRating","ratingValue":"'.($jrr['rate']==''?'1':$jrr['rate']).'","reviewCount":"'.($jrr['cnt']==0?'1':$jrr['cnt']).'"},"offers":{"@type":"Offer","url":"'.$canonical.'","priceCurrency":"AUD","price":"'.($r['rCost']!=0?$r['rCost']:($r['cost']==''?0:$r['cost'])).'","priceValidUntil":"'.date('Y-m-d',strtotime('+6 month',time())).'","availability":"'.($r['stockStatus']=='quantity'?($r['quantity']==0?'OutOfStock':'In Stock'):($r['stockStatus']=='none'?'OutOfStock':'InStock')).'","seller":{"@type":"Organization","name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'"}}';
    }elseif($r['schemaType']=='Service')
      $jsonld.='"@type":"Service","serviceType":"'.htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8').'","provider":{"@type":"LocalBusiness","name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'","address":"'.htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8').', '.htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8').', '.htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8').'","telephone":"'.($config['phone']!=''?htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'):htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')).'","priceRange":"'.htmlspecialchars(($r['rCost']!=0?$r['rCost']:$r['cost']),ENT_QUOTES,'UTF-8').'","image":"'.($r['file']!=''?$r['file']:URL.FAVICON).'"},"areaServed":{"@type":"State","name":"All"}';
    else{
      $jsonld.='"@type":"'.$r['schemaType'].'","headline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'","alternativeHeadline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'","image":{"@type":"ImageObject","url":"';
      if($r['file']!=''&&file_exists('media/'.basename($r['file'])))
        $jsonld.='media'.DS.basename($r['file']).'"';
      else
        $jsonld.=FAVICON.'"';
      $jsonld.='},"author":"'.($ua['name']!=''?htmlspecialchars($ua['name'],ENT_QUOTES,'UTF-8'):htmlspecialchars($ua['username'],ENT_QUOTES,'UTF-8')).'","genre":"'.($r['category_1']!=''?htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8'):'None').($r['category_2']!=''?' > '.htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8'):'').($r['category_3']!=''?' > '.htmlspecialchars($r['category_3'],ENT_QUOTES,'UTF-8'):'').($r['category_4']!=''?' > '.htmlspecialchars($r['category_4'],ENT_QUOTES,'UTF-8'):'').'","keywords":"'.htmlspecialchars($seoKeywords,ENT_QUOTES,'UTF-8').'","wordcount":"'.htmlspecialchars(strlen(strip_tags(escaper($r['notes']))),ENT_QUOTES,'UTF-8').'","publisher":{"@type":"Organization","name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'"},"url":"'.$canonical.'/","datePublished":"'.date('Y-m-d',$r['pti']).'","dateCreated":"'.date('Y-m-d',$r['ti']).'","dateModified":"'.date('Y-m-d',$r['eti']).'","description":"'.htmlspecialchars(strip_tags(rawurldecode($seoDescription)),ENT_QUOTES,'UTF-8').'","articleBody":"'.htmlspecialchars(strip_tags(escaper($r['notes'])),ENT_QUOTES,'UTF-8').'"';
    }
    $jsonld.='}</script>';
    $item=str_replace('<json-ld>',$jsonld,$item);
  }
  $sidecat=isset($r['category_1'])&&$r['category_1']!=''?$r['category_1']:'';
  $item=preg_replace([
    '/<print author=[\"\']?link[\"\']?>/',
    '/<print author=[\"\']?name[\"\']?>/'
  ],[
    URL.'profile/'.strtolower(str_replace(' ','-',htmlspecialchars($r['login_user'],ENT_QUOTES,'UTF-8'))).'/',
    $ua['name']!=''?htmlspecialchars($ua['name'],ENT_QUOTES,'UTF-8'):htmlspecialchars($ua['username'],ENT_QUOTES,'UTF-8')
  ],$item);
/* Related */
  if($view=='article'||$view=='inventory'||$view=='service'||$view=='portfolio'&&stristr($item,'<related')){
    if($config['options'][11]==1){
      preg_match('/<related.*itemCount=[\"\'](.+?)[\"\'].*>/',$item,$matches);
      if(!isset($matches[1]))
        $iC=$config['showItems'];
      elseif($matches[1]=='all')
        $iC='';
      elseif($matches[1]=='default')
        $iC=$config['showItems'];
      else
        $iC=$matches[1];
      $sr=$db->prepare("SELECT `rid` as id FROM `".$prefix."choices` WHERE `uid`=:id AND `contentType`='related' ORDER BY `title` ASC LIMIT $iC");
      $sr->execute([
        ':id'=>$r['id']
      ]);
      $go=false;
      if($sr->rowCount()>0)
        $go=true;
      else{
        if($config['options'][10]==1){
          if($r['category_1']!=''){
            $sr=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `id`!=:id AND `category_1` LIKE :cat AND `status`='published' AND `rank`<=:rank ORDER BY `title` ASC LIMIT $iC");
            $sr->execute([
              ':id'=>$r['id'],
              ':cat'=>$r['category_1'],
              ':rank'=>$_SESSION['rank']
            ]);
            if($sr->rowCount()>0)$go=true;
          }
        }
      }
      if($go=true){
        preg_match('/<related.*>([\w\W]*?)<\/related>/',$item,$matches);
        $related=$matches[1];
        preg_match('/<relitems>([\w\W]*?)<\/relitems>/',$related,$matches);
        $relitem=$matches[1];
        $relitems='';
        while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
          $relateditem=$relitem;
          $si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id AND `status`='published' AND `internal`=0 AND `rank`<=:rank");
          $si->execute([
            ':id'=>$rr['id'],
            ':rank'=>$_SESSION['rank']
          ]);
          $ri=$si->fetch(PDO::FETCH_ASSOC);
          $ri['thumb']=rawurldecode($ri['thumb']);
          if($ri['thumb']==''||!file_exists('media'.DS.'thumbs'.DS.basename($ri['thumb'])))$ri['thumb']=NOIMAGESM;
          $relatedQuantity='';
          if(is_numeric($ri['quantity'])&&$ri['quantity']!=0)
            $relatedQuantity.=$ri['stockStatus']=='quantity'?($ri['quantity']==0?'<div class="quantity">Out Of Stock</div>':'<div class="quantity">'.htmlspecialchars($ri['quantity'],ENT_QUOTES,'UTF-8').' <span class="quantity-text">In Stock</span></div>'):($ri['stockStatus']=='none'?'':'<div class="quantity">'.ucwords($ri['stockStatus']).'</div>');
          $relateditem=preg_replace([
            '/<print related=[\"\']?linktitle[\"\']?>/',
            '/<print thumb=[\"\']?srcset[\"\']?>/',
            '/<print related=[\"\']?thumb[\"\']?>/',
            '/<print related=[\"\']?imageALT[\"\']?>/',
            '/<print related=[\"\']?title[\"\']?>/',
            '/<print related=[\"\']?contentType[\"\']?>/',
            '/<print related=[\"\']?quantity[\"\']?>/'
          ],[
            URL.$ri['contentType'].'/'.$ri['urlSlug'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
            'srcset="'.($ri['file']!=''&&file_exists('media'.DS.'thumbs'.DS.basename($ri['thumb']))?'media'.DS.'thumbs'.DS.basename($ri['thumb']).' '.$config['mediaMaxWidthThumb'].'w,':'').($ri['file']!=''&&file_exists('media'.DS.'md'.DS.basename($ri['thumb']))?'media'.DS.'md'.DS.basename($ri['thumb']).' 600w,':'').($ri['file']!=''&&file_exists('media'.DS.'sm'.DS.basename($ri['thumb']))?'media'.DS.'sm'.DS.basename($ri['thumb']).' 400w':'').'" ',
            ($ri['file']!=''&&file_exists('media'.DS.'thumbs'.DS.basename($ri['thumb']))?'media'.DS.'thumbs'.DS.$ri['thumb']:NOIMAGESM),
            htmlspecialchars($ri['fileALT']!=''?$ri['fileALT']:$ri['title'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars($ri['title'],ENT_QUOTES,'UTF-8'),
            $ri['contentType'],
            $relatedQuantity
          ],$relateditem);
          $relitems.=$relateditem;
        }
        $related=preg_replace('~<relitems>.*?<\/relitems>~is',$relitems,$related,1);
        $item=preg_replace('~<related.*>.*?<\/related>~is',$related,$item,1);
      }else
        $item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
    }else
      $item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
  }else
    $item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
/* Reviews */
  if($view!='page'&&stristr($item,'<review')){
    preg_match('/<review>([\w\W]*?)<\/review>/',$item,$matches);
    $review=$matches[1];
    $sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review' AND `status`='approved' AND `rid`=:rid");
    $sr->execute([
      ':rid'=>isset($r['id'])?$r['id']:$page['id']
    ]);
    $reviews='';
    while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
      $reviewitem=$review;
      if(stristr($reviewitem,'<json-ld-review>')){
        $jsonldreview='<script type="application/ld+json">{"@context":"https://schema.org/","@type":"Review","itemReviewed":{"@type":"Product","image":"';
        if(file_exists('media'.DS.basename($r['file'])))
          $jsonldreview.='media'.DS.basename($r['file']);
        else
          $jsonldreview.=FAVICON;
        $jsonldreview.='","name":"'.$r['title'].'"},"reviewRating":{"@type":"Rating","ratingValue":"'.$rr['cid'].'"},"name":"'.$r['title'].'","author":{"@type":"Person","name":"'.($rr['name']!=''?$rr['name']:'Anonymous').'"},"datePublished":"'.date('Y-m-d',$rr['ti']).'","reviewBody":"'.$rr['notes'].'","publisher":{"@type":"Organization","name":"'.$config['business'].'"}}</script>';
        $reviewitem=str_replace('<json-ld-review>',$jsonldreview,$reviewitem);
      }
      $reviewitem=preg_replace('/<print review=[\"\']?rating[\"\']?>/',$rr['cid'],$reviewitem);
      $reviewitem=preg_replace([
        '/<print review=[\"\']?set5[\"\']?>/',
        '/<print review=[\"\']?set4[\"\']?>/',
        '/<print review=[\"\']?set3[\"\']?>/',
        '/<print review=[\"\']?set2[\"\']?>/',
        '/<print review=[\"\']?set1[\"\']?>/',
        '/<print review=[\"\']?name[\"\']?>/',
        '/<print review=[\"\']?dateAtom[\"\']?>/',
        '/<print review=[\"\']?datetime[\"\']?>/',
        '/<print review=[\"\']?date[\"\']?>/',
        '/<print review=[\"\']?review[\"\']?>/'
      ],[
        $rr['cid']>=5?'set':'',
        $rr['cid']>=4?'set':'',
        $rr['cid']>=3?'set':'',
        $rr['cid']>=2?'set':'',
        $rr['cid']>=1?'set':'',
        $rr['name']==''?'Anonymous':htmlspecialchars($rr['name'],ENT_QUOTES,'UTF-8'),
        date('Y-m-d',$rr['ti']),
        date('Y-m-d H:i:s',$rr['ti']),
        date($config['dateFormat'],$rr['ti']),
        htmlspecialchars(strip_tags($rr['notes']),ENT_QUOTES,'UTF-8')
      ],$reviewitem);
      $reviews.=$reviewitem;
    }
    $item=preg_replace('~<review>.*?<\/review>~is',$reviews,$item,1);
  }
  require'core'.DS.'parser.php';
  $authorHTML='';
  if(isset($r['contentType'])&&($r['contentType']=='article'||$r['contentType']=='portfolio'))$item=preg_replace('~<controls>.*?<\/controls>~is','',$item,1);
  $html=preg_replace([
    '~<settings.*?>~is',
    '~<more>.*?<\/more>~is',
    '/<print page=[\"\']?notes[\"\']?>/'
  ],'',$html);
  $html=str_replace('<print view>',$view,$html);
  if($view=='article'||$view=='events'||$view=='news'||$view=='proofs'){
    $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`=:contentType AND `rid`=:rid AND `status`!='unapproved' ORDER BY `ti` ASC");
    $sc->execute([
      ':contentType'=>$view,
      ':rid'=>$r['id']
    ]);
    if($sc->rowCount()>0||$r['options'][1]==1){
      if(file_exists(THEME.DS.'comments.html')){
        $comments=$commentsHTML='';
        $commentsHTML=file_get_contents(THEME.DS.'comments.html');
        $commentsHTML=preg_replace([
          '/<print content=[\"\']?id[\"\']?>/',
          '/<print content=[\"\']?contentType[\"\']?>/',
        ],[
          $r['id'],
          $r['contentType']
        ],$commentsHTML);
        $commentDOC=new DOMDocument();
        @$commentDOC->loadHTML($commentsHTML);
        preg_match('/<items>([\w\W]*?)<\/items>/',$commentsHTML,$matches);
        while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
          $comment=$matches[1];
          $rc['notes']=htmlspecialchars(strip_tags(rawurldecode($rc['notes'])),ENT_QUOTES,'UTF-8');
          $comment=preg_replace('/<print comments=[\"\']?datetime[\"\']?>/',date('Y-m-d',$rc['ti']),$comment,1);
          require'core'.DS.'parser.php';
          $comments.=$comment;
        }
        $commentsHTML=preg_replace('~<items>.*?<\/items>~is',$comments,$commentsHTML,1);
        $commentsHTML=$r['options'][1]==1?preg_replace('/<\/?comment>/','',$commentsHTML):preg_replace('~<comment>.*?<\/comment>~is','',$commentsHTML,1);
        $commentsHTML=preg_replace('~<items>.*?<\/items>~is','',$commentsHTML,1);
        $item=preg_replace('~<comments>~is',$commentsHTML,$item,1);
      }else
        $item.='Comments for this post is Enabled, but no <strong>"'.THEME.DS.'comments.html"</strong> template file exists';
    }
  }
  $html=preg_replace('~<item>.*?<\/item>~is',$item,$html,1);
}
