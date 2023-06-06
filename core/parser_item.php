<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Parser Item
 * @package    core/parser_item.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
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
$skip=false;
if($r['rank']-1 < $_SESSION['rank'])
  $skip=false;
else
  $skip=true;
if(isset($r['options'][2])&&$r['options'][2]==1){
  if($_SESSION['rank']>399)
    $skip=false;
  elseif($_SESSION['rank']==$r['rank'])
    $skip=false;
  else
    $skip=true;
}
if($skip==false){
  if($config['gst']>0){
    $gst=$r['cost']*($config['gst']/100);
    $gst=$r['cost']+$gst;
    $r['cost']=number_format((float)$gst,2,'.','');
    $gst=$r['rCost']*($config['gst']/100);
    $gst=$r['rCost']+$gst;
    $r['rCost']=number_format((float)$gst,2,'.','');
  }
  $seoTitle=escaper($r['seoTitle']==''?$r['title']:$r['seoTitle']);
  $metaRobots=$r['metaRobots']==''?$r['metaRobots']:$page['metaRobots'];
  $seoCaption=escaper($r['seoCaption']==''?$r['seoCaption']:$page['seoCaption']);
  $seoDescription=escaper($r['seoDescription']!=''?$r['seoDescription']:($r['seoCaption']!=''?$r['seoCaption']:substr(strip_tags($r['notes']),0,160)));
  $seoKeywords=$r['seoKeywords']==''?$r['seoKeywords']:$page['seoKeywords'];
  $su=$db->prepare("UPDATE `".$prefix."content` SET `views`=:views WHERE `id`=:id");
  $su->execute([
    ':views'=>$r['views']+1,
    ':id'=>$r['id']
  ]);
  $us=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
  $us->execute([':uid'=>$r['uid']]);
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
  $contentTime=isset($r['eti'])&&$r['eti']>$r['ti']?$r['eti']:(isset($r['ti'])?$r['ti']:0);
  if(stristr($html,'<breadcrumb>')){
    $jsoni=2;
    preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
    $breaditem=$matches[1];
    preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
    $breadcurrent=$matches[1];
    $jsonld='<script type="application/ld+json">{'.
      '"@context":"http://schema.org",'.
      '"@type":"BreadcrumbList",'.
      '"itemListElement":[{'.
        '"@type":"ListItem",'.
        '"position":1,'.
        '"item":{'.
          '"@id":"'.URL.'",'.
          '"name":"Home"'.
        '}'.
      '},';
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
    if($r['title']!=''){
      $breadit=preg_replace([
        '/<print breadcrumb=[\"\']?url[\"\']?>/',
        '/<print breadcrumb=[\"\']?title[\"\']?>/'
      ],[
        URL.urlencode($page['contentType']),
        htmlspecialchars(ucwords($page['title']),ENT_QUOTES,'UTF-8')
      ],$breaditem);
    }else
      $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars(ucwords($page['title']),ENT_QUOTES,'UTF-8'),$breadcurrent);
    $jsonld.=
    '{'.
      '"@type":"ListItem",'.
      '"position":2,'.
      '"item":{'.
        '"@id":"'.URL.urlencode($page['contentType']).'",'.
        '"name":"'.htmlspecialchars(ucwords($page['title']),ENT_QUOTES,'UTF-8').'"'.
      '}'.
    '},';
    $breaditems.=$breadit;
    if($r['category_1']!=''){
      $jsoni++;
      if($r['category_1']!=''){
        $breadit=preg_replace([
          '/<print breadcrumb=[\"\']?url[\"\']?>/',
          '/<print breadcrumb=[\"\']?title[\"\']?>/'
        ],[
          URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))),
          htmlspecialchars(ucwords($r['category_1']),ENT_QUOTES,'UTF-8')
        ],$breaditem);
      }else
        $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars(ucwords($r['category_1']),ENT_QUOTES,'UTF-8'),$breadcurrent);
      $jsonld.=
      '{'.
        '"@type":"ListItem",'.
        '"position":'.$jsoni.','.
        '"item":{'.
          '"@id":"'.URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))).'",'.
          '"name":"'.ucwords($r['category_1']).'"'.
        '}'.
      '},';
      $breaditems.=$breadit;
    }
    if($r['category_2']!=''){
      $jsoni++;
      if($r['category_2']!=''){
        $breadit=preg_replace([
          '/<print breadcrumb=[\"\']?url[\"\']?>/',
          '/<print breadcrumb=[\"\']?title[\"\']?>/'
        ],[
          URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_2']))),
          htmlspecialchars(ucwords($r['category_2']),ENT_QUOTES,'UTF-8')
        ],$breaditem);
      }else
        $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars(ucwords($r['category_2']),ENT_QUOTES,'UTF-8'),$breadcurrent);
      $jsonld.=
      '{'.
        '"@type":"ListItem",'.
        '"position":'.$jsoni.','.
        '"item":{'.
          '"@id":"'.URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_2']))).'",'.
          '"name":"'.ucwords($r['category_2']).'"'.
        '}'.
      '},';
      $breaditems.=$breadit;
    }
    if($r['category_3']!=''){
      $jsoni++;
      if($r['category_3']!=''){
        $breadit=preg_replace([
          '/<print breadcrumb=[\"\']?url[\"\']?>/',
          '/<print breadcrumb=[\"\']?title[\"\']?>/'
        ],[
          URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_2']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_3']))),
          htmlspecialchars(ucwords($r['category_3']),ENT_QUOTES,'UTF-8')
        ],$breaditem);
      }else
        $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars(ucwords($r['category_3']),ENT_QUOTES,'UTF-8'),$breadcurrent);
      $jsonld.=
      '{'.
        '"@type":"ListItem",'.
        '"position":'.$jsoni.','.
        '"item":{'.
          '"@id":"'.URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_2']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_3']))).'",'.
          '"name":"'.ucwords($r['category_3']).'"'.
        '}'.
      '},';
      $breaditems.=$breadit;
    }
    if($r['category_4']!=''){
      $jsoni++;
      if($r['category_3']!=''){
        $breadit=preg_replace([
          '/<print breadcrumb=[\"\']?url[\"\']?>/',
          '/<print breadcrumb=[\"\']?title[\"\']?>/'
        ],[
          URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_2']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_3']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_4']))),
          htmlspecialchars(ucwords($r['category_4']),ENT_QUOTES,'UTF-8')
        ],$breaditem);
      }else
        $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars(ucwords($r['category_4']),ENT_QUOTES,'UTF-8'),$breadcurrent);
      $jsonld.=
      '{'.
        '"@type":"ListItem",'.
        '"position":'.$jsoni.','.
        '"item":{'.
          '"@id":"'.URL.urlencode($page['contentType']).'/'.urlencode(str_replace(' ','-',strtolower($r['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_2']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_3']))).'/'.urlencode(str_replace(' ','-',strtolower($r['category_4']))).'",'.
          '"name":"'.ucwords($r['category_4']).'"'.
        '}'.
      '},';
      $breaditems.=$breadit;
    }
    $jsoni++;
    if($r['title']!=''){
      $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars(ucwords($r['title']),ENT_QUOTES,'UTF-8'),$breadcurrent);
      $jsonld.=
      '{'.
        '"@type":"ListItem",'.
        '"position":'.$jsoni.','.
        '"item":{'.
          '"@id":"'.URL.urlencode($page['contentType']).'/'.urlencode($r['urlSlug']).'",'.
          '"name":"'.ucwords($r['title']).'"'.
        '}'.
      '}]}</script>';
      $breaditems.=$breadit;
    }
    $html=preg_replace([
      '/<[\/]?breadcrumb>/',
      '/<json-ld-breadcrumb>/',
      '~<breadcurrent>.*?<\/breadcurrent>~is',
      '~<breaditems>.*?<\/breaditems>~is'
    ],[
      '',
      $jsonld,
      $breaditems
    ],$html);
  }
  if(stristr($html,'<cover>')){
  	$coverHTML='';
  	$iscover=false;
  	if($page['coverVideo']!=''){
  		$cover=basename(rawurldecode($page['coverVideo']));
  		if(stristr($page['coverVideo'],'youtu')){
  			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$page['coverVideo'],$vidMatch);
  			$coverHTML='<div class="embed-responsive embed-responsive-16by9">'.
          '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.
  				($page['options'][0]==1?'autoplay=1&mute=1&':'').
  				($page['options'][1]==1?'loop=1&':'').
  				($page['options'][2]==1?'controls=1&':'controls=0&').
          '" frameborder="0" allow="accelerometer;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>'.
        '</div>';
    	}elseif(stristr($page['coverVideo'],'vimeo')){
  			preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$page['coverVideo'],$vidMatch);
  			$coverHTML='<div class="embed-responsive embed-responsive-16by9">'.
          '<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.
  				($page['options'][0]==1?'autoplay=1&':'').
  				($page['options'][1]==1?'loop=1&':'').
  				($page['options'][2]==1?'controls=1&':'controls=0&').
  			  '" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>'.
        '</div>'.
        '<script src="https://player.vimeo.com/api/player.js"></script>';
  		}else{
  			$coverHTML='<div class="embed-responsive embed-responsive-16by9">'.
          '<video class="embed-responsive-item" preload autoplay loop muted>'.
            '<source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4">'.
          '</video>'.
        '</div>';
      }
  	}
  	if($page['cover']!=''&&$coverHTML==''){
  		$cover=basename($page['cover']);
			$coverHTML=($page['cover']?'<img srcset="'.
				(file_exists('media/lg/'.basename($cover))?'media/lg/'.$cover.' 1000w,':'').
				(file_exists('media/md/'.basename($cover))?'media/md/'.$cover.' 600w,':'').
				(file_exists('media/sm/'.basename($cover))?'media/sm/'.$cover.' 400w,':'').
				(file_exists('media/sm/'.basename($cover))?'media/sm/'.$cover.' '.$config['mediaMaxWidthThumb'].'w':'').
			'" sizes="(min-width: '.$config['mediaMaxWidth'].'px) '.$config['mediaMaxWidth'].'px" src="'.$page['cover'].'" alt="'.$page['title'].' Cover Image">'.
				($page['attributionImageTitle']!=''?
					'<figcaption>'.
						$page['attributionImageTitle'].
						($page['attributionImageName']!=''?
							' by '.
								($page['attributionImageURL']!=''?'<a target="_blank" href="'.$page['attributionImageURL'].'" rel="noopener noreferrer">':'').
								$page['attributionImageName'].
								($page['attributionImageURL']!=''?'</a>':'')
						:'').(stristr($page['attributionImageURL'],'unsplash.com')?' on <a target="_blank" href="https://unsplash.com/?utm_source='.$config['unsplash_appname'].'&utm_medium=referral">Unsplash</a>':'').
					'</figcaption>'
				:'')
			:'');
			$iscover=true;
  	}
  	$html=preg_replace([
  		$coverHTML==''?'~<cover>.*?</cover>~is':'/<[\/]?cover>/',
  		'/<print page=[\"\']?coverItem[\"\']?>/'
  	],[
  		'',
  		$coverHTML
  	],$html);
  }
  if($r['videoURL']!=''){
    $html=preg_replace([
      '/<[\/]?videoviewer>/',
      '~<image>.*?<\/image>~is'
    ],'',$html);
    if($r['videoURL']!=''){
      $cover=basename(rawurldecode($r['videoURL']));
      if(stristr($r['videoURL'],'youtu')){
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$r['videoURL'],$vidMatch);
        $videoHTML='<div class="embed-responsive embed-responsive-16by9">'.
          '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.
            ($r['options'][4]==1?'autoplay=1&':'').
            ($r['options'][5]==1?'loop=1&':'').
            ($page['options'][6]==1?'controls=1&':'controls=0&').
          '" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'.
        '</div>';
      }elseif(stristr($r['videoURL'],'vimeo')){
        preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$r['videoURL'],$vidMatch);
        $videoHTML='<div class="embed-responsive embed-responsive-16by9">'.
          '<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.
            ($r['options'][4]==1?'autoplay=1&':'').
            ($r['options'][5]==1?'loop=1&':'').
            ($r['options'][6]==1?'controls=1&':'controls=0&').
          '" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>'.
        '</div>'.
        '<script src="https://player.vimeo.com/api/player.js"></script>';
      }else{
        $videoHTML='<div class="embed-responsive embed-responsive-16by9">'.
          '<video class="embed-responsive-item" preload autoplay loop muted><source src="'.htmlspecialchars($r['videoURL'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video>'.
        '</div>';
      }
      $html=preg_replace(
        '/<print content=[\"\']?video[\"\']?>/',
        $videoHTML,
        $html
      );
    }else
      $html=preg_replace('/<print content=[\"\']?video[\"\']?>/','',$html);
  }elseif($r['file']==''){
    $r['file']=rawurldecode($r['file']);
    $html=preg_replace([
      '~<image>.*?<\/image>~is',
      '~<videoviewer>.*?<\/videoviewer>~is'
    ],'',$html);
    if($r['fileURL']!='')
      $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['fileURL'],$html);
    elseif($r['file']!='')
      $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['file'],$html);
    else
      $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',NOIMAGE,$html);
    $html=preg_replace([
      '/<print content=[\"\']?imageALT[\"\']?>/',
      '/<print content=[\"\']?rank[\'"\']?>/',
      '/<print content=[\"\']?cssrank[\'"\']?>/'
    ],[
      htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8'),
      $r['rank']>300?ucwords(str_replace('-',' ',rank($r['rank']))):'',
      rank($r['rank'])
    ],$html);
  }else{
    $r['file']=rawurldecode($r['file']);
    $html=preg_replace('~<videoviewer>.*?<\/videoviewer>~is','',$html);
    if($r['fileURL'])
      $html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['fileURL'],$html);
    elseif($r['file']!=''){
      $html=preg_replace([
        '/<[\/]?image>/',
        '/<print content=[\"\']?srcset[\"\']?>/',
        '/<print content=[\"\']?image[\"\']?>/',
        '/<print content=[\"\']?figcaption[\"\']?>/',
        '/<print content=[\"\']?imageALT[\"\']?>/',
        '/<print content=[\"\']?rank[\'"\']?>/',
        '/<print content=[\"\']?cssrank[\'"\']?>/'
      ],[
        '',
        'srcset="'.
          ($r['file']!=''&&file_exists('media/'.basename($r['file']))?'media/'.basename($r['file'].' '.$config['mediaMaxWidth'].'w,'):'').
          ($r['file']!=''&&file_exists('media/lg/'.basename($r['file']))?'media/lg/'.basename($r['file'].' 1000w,'):'').
          ($r['file']!=''&&file_exists('media/md/'.basename($r['file']))?'media/md/'.basename($r['file'].' 600w,'):'').
          ($r['file']!=''&&file_exists('media/sm/'.basename($r['file']))?'media/sm/'.basename($r['file'].' 400w'):'').'" sizes="(min-width: '.$config['mediaMaxWidth'].'px) '.$config['mediaMaxWidth'].'px" ',
        $r['file']!=''?$r['file']:NOIMAGE,
        ($r['attributionImageTitle']!=''?$r['attributionImageTitle']:'').
          ($r['attributionImageName']!=''?' by '.($r['attributionImageURL']!=''?'<a href="'.$r['attributionImageURL'].'">'.$r['attributionImageName'].'</a>':$r['attributionImageName']).
          (stristr($r['attributionImageURL'],'unsplash.com')?' on <a href="https://unsplash.com/?utm_source='.$config['unsplash_appname'].'&utm_medium=referral">Unsplash</a>':''):''),
        htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8'),
        $r['rank']>300?ucwords(str_replace('-',' ',rank($r['rank']))):'',
        rank($r['rank'])
      ],$html);
    }else
      $html=preg_replace('~<image>.*?<\/image>~is','',$html);
  }

  if(stristr($html,'<item')){
    preg_match('/<item>([\w\W]*?)<\/item>/',$html,$matches);
    $item=$matches[1];
    if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)
      $item=preg_replace('~<purchasewarning>.*?</purchasewarning>~is','',$item,1);
    else{
      if($r['contentType']=='inventory')
        $item=preg_replace($config['options'][30]!=1?'~<purchasewarning>.*?</purchasewarning>~is':'/<[\/]?purchasewarning>/','',$item);
      else
        $item=preg_replace('~<purchasewarning>.*?</purchasewarning>~is','',$item);
    }
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
        if($config['options'][5]==0){
          $mediaitems=$mediaitem;
          $r['file']=rawurldecode($r['file']);
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
            $r['id'],
            'srcset="'.
              ($r['file']!=''&&file_exists('media/sm/'.basename($r['file']))?'media/sm/'.basename($r['file']).' '.$config['mediaMaxWidthThumb'].'w,':'').
              ($r['file']!=''&&file_exists('media/md/'.basename($r['file']))?'media/md/'.basename($r['file']).' 600w,':'').
              ($r['file']!=''&&file_exists('media/sm/'.basename($r['file']))?'media/sm/'.basename($r['file']).' 400w':'').'" sizes="(min-width: '.$config['mediaMaxWidth'].'px) '.$config['mediaMaxWidth'].'px" ',
            ($r['file']!=''&&file_exists('media/'.basename($rm['file']))?'media/'.basename($r['file']).' '.$config['mediaMaxWidth'].'w, ':'').
              ($r['file']!=''&&file_exists('media/lg/'.basename($r['file']))?'media/lg/'.basename($r['file']).' 1000w,':'').
              ($r['file']!=''&&file_exists('media/md/'.basename($r['file']))?'media/md/'.basename($r['file']).' 600w,':'').
              ($r['file']!=''&&file_exists('media/sm/'.basename($r['file']))?'media/sm/'.basename($r['file']).' 400w':''),
            $r['thumb']!=''?$r['thumb']:NOIMAGESM,
            $r['file']!=''?$r['file']:NOIMAGE,
            htmlspecialchars(($r['title']!=''?$r['title']:$r['title'].': Image '.$r['id']),ENT_QUOTES,'UTF-8'),
            htmlspecialchars(($r['fileALT']!=''?$r['fileALT']:basename($r['file'])),ENT_QUOTES,'UTF-8'),
            isset($r['title'])&&$r['title']!=''?htmlspecialchars(($r['title']!=''?basename($r['title']):basename($r['file'])),ENT_QUOTES,'UTF-8'):basename($r['file'])
          ],$mediaitems);
          $mediaoutput.=$mediaitems;
        }
        while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
          $mediaitems=$mediaitem;
          if($rm['file']=='')continue;
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
              ($rm['file']!=''&&file_exists('media/sm/'.basename($rm['file']))?'media/sm/'.basename($rm['file']).' '.$config['mediaMaxWidthThumb'].'w,':'').
              ($rm['file']!=''&&file_exists('media/md/'.basename($rm['file']))?'media/md/'.basename($rm['file']).' 600w,':'').
              ($rm['file']!=''&&file_exists('media/sm/'.basename($rm['file']))?'media/sm/'.basename($rm['file']).' 400w':'').'" sizes="(min-width: '.$config['mediaMaxWidth'].'px) '.$config['mediaMaxWidth'].'px" ',
            ($rm['file']!=''&&file_exists('media/'.basename($rm['file']))?'media/'.basename($rm['file']).' '.$config['mediaMaxWidth'].'w, ':'').
              ($rm['file']!=''&&file_exists('media/lg/'.basename($rm['file']))?'media/lg/'.basename($rm['file']).' 1000w,':'').
              ($rm['file']!=''&&file_exists('media/md/'.basename($rm['file']))?'media/md/'.basename($rm['file']).' 600w,':'').
              ($rm['file']!=''&&file_exists('media/sm/'.basename($rm['file']))?'media/sm/'.basename($rm['file']).' 400w':''),
            $rm['thumb']!=''?$rm['thumb']:$rm['file'],
            $rm['file']!=''?$rm['file']:NOIMAGE,
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
    if($show=='item'&&($view=='service'||$view=='inventory'||$view=='events'||$view=='activities')){
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
      }
    }else
      $item=preg_replace(['~<service.*?>.*?<\/service>~is',($r['coming']==1?'~<inventory>.*?<\/inventory>~is':'/<[\/]?inventory>/')],'',$item,1);
    $address=$edit=$contentQuantity='';
    $showCountdown=false;
    if(isset($r['contentType'])&&($r['contentType']=='events')){
      $item=preg_replace([
        $r['options'][3]==1?'/<[\/]?countdown>/':'~<countdown>.*?<\/countdown>~is',
        '/<print countdown=[\"\']?contentType[\"\']?>/',
        '/<print countdown=[\"\']?tie[\"\']?>/'
      ],[
        '',
        rtrim($r['contentType'],'s'),
        date('Y-m-d h:i',$r['tis'])
      ],$item);
      if($r['options'][3]==1)$showCountdown=true;
    }else
      $item=preg_replace('~<countdown>.*?<\/countdown>~is','',$item);

    if($r['contentType']=='article'){
      if(stristr($item,'<list>')){
        $sl=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `rid`=:rid AND `contentType`='list' ORDER BY `ord` ASC, `ti` ASC");
        $sl->execute([':rid'=>$r['id']]);
        if($sl->rowCount()>0){
          preg_match('/<listitems>([\w\W]*?)<\/listitems>/',$item,$matches);
          $listitem=$matches[1];
          $lout='';
          while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
            $listmediaitems='';
            $slm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `rid`=:rid ORDER BY `ord` ASC, `ti` ASC LIMIT 4");
            $slm->execute([':rid'=>$rl['id']]);
            $sli=0;
            if($slm->rowCount()>0){
              while($rlm=$slm->fetch(PDO::FETCH_ASSOC)){
                if(stristr($rlm['file'],'youtu')){
                  preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$rlm['file'],$vidMatch);
                  $listmediaitems.='<div class="note-video-wrapper video" data-fancybox="list" href="'.$rlm['file'].'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
                    '<img class="note-video-clip" src="https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg" alt="'.$rlm['title'].'">'.
                    '<div class="play"></div>'.
                  '</div>';
                }elseif(stristr($rlm['file'],'vimeo')){
                  preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$rlm['file'],$vidMatch);
                  $listmediaitems.='<div class="note-video-wrapper video" data-fancybox="list" href="'.$rlm['file'].'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'">'.
                    '<img class="note-video-clip" src="https://vumbnail.com/'.$vidMatch[5].'.jpg">'.
                    '<div class="play"></div>'.
                  '</div>';
                }elseif(stristr($rl['urlSlug'],'twitter')){
                  $listmediaitems.='<a target="_blank" src="'.$rl['urlSlug'].'" href="'.$rl['urlSlug'].'"><img src="'.$rlm['thumb'].'" alt="'.$lh.'"></a>';
                }else
                  $listmediaitems.='<a data-fancybox="list" href="'.$rlm['file'].'" data-caption="&lt;h5&gt;'.$rl['title'].'&lt;/h5&gt;'.$rl['notes'].'"><img src="'.$rlm['file'].'" alt="'.$rl['title'].'"></a>';

                $sli++;
              }
            }
            $out=preg_replace([
              '/<print list=[\"\']?id[\"\']?>/',
              '/<print list=[\"\']?code[\"\']?>/',
              ($rl['title']!=''?'/<[\/]?listheading>/':'~<listheading>.*?<\/listheading>~is'),
              '/<print list=[\"\']?heading[\"\']?>/',
              '/<print list=[\"\']?caption[\"\']?>/',
              '/<print list=[\"\']?notes[\"\']?>/',
              '/<print list=[\"\']?url[\"\']?>/',
              '/<print list=[\"\']?permalink[\"\']?>/',
              '/<print list=[\"\']?imagecount[\"\']?>/',
              ($listmediaitems!=''?'/<[\/]?listmedia>/':'~<listmedia>.*?<\/listmedia>~is'),
              '/<listmediaitems>/'
            ],[
              $rl['id'],
              ($rl['code']!=''?$rl['code']:'list'.$rl['id']),
              '',
              $rl['title'],
              htmlspecialchars($rl['notes'],ENT_QUOTES),
              $rl['notes'],
              ($rl['url']!=''?' <a href="'.$rl['url'].'">More...</a>':''),
              URL.$r['contentType'].'/'.$r['urlSlug'].'#'.($rl['code']!=''?$rl['code']:'list'.$rl['id']),
              $sli,
              '',
              $listmediaitems,
            ],$listitem);
            $lout.=$out;
          }
          $item=preg_replace([
            '~<listitems>.*?<\/listitems>~is',
            '/<[\/]?list>/'
          ],[
            $lout,
            ''
          ],$item);
        }else
          $item=preg_replace('~<list>.*?<\/list>~is','',$item);
      }
    }else
      $item=preg_replace('~<list>.*?<\/list>~is','',$item);

    if($r['contentType']=='course'){
      preg_match('/<moduleitems>([\w\W]*?)<\/moduleitems>/',$item,$matches);
      $moduleitem=$matches[1];
      $scm=$db->prepare("SELECT * FROM `".$prefix."modules` WHERE `rid`=:rid ORDER BY `ord` ASC");
      $scm->execute([':rid'=>$r['id']]);
      $mout='';
      $mti=0;
      while($rcm=$scm->fetch(PDO::FETCH_ASSOC)){
        $mti=$mti + $rcm['tti'];
        $out=preg_replace([
          '/<print module=[\"\']?title[\"\']?>/',
          $rcm['tti']>0?'/<print module=[\"\']?time[\"\']?>/':'~<moduletime>.*?<\/moduletime>~is',
          '/<print module=[\"\']?caption[\"\']?>/'
        ],[
          $rcm['title'],
          $rcm['tti']>0?secondsToWords($rcm['tti']):'',
          $rcm['caption']
        ],$moduleitem);
        $mout.=$out;
      }
      $item=preg_replace([
        '/<[\/]?coursemodules>/',
        '~<moduleitems>.*?<\/moduleitems>~is',
        $mti > 0?'/<[\/]?totaltime>/':'~<totaltime>.*?<\/totaltime>~is',
        '/<print module=[\"\']?totaltime[\"\']?>/'
      ],[
        '',
        $mout,
        '',
        secondsToWords($mti),
      ],$item);
    }else
      $item=preg_replace('~<coursemodules>.*?<\/coursemodules>~is','',$item);

    $itemQuantity='';
    if($r['coming']==1&&$r['contentType']=='inventory'){
      $itemQuantity='Coming Soon';
    }else{
      if(is_numeric($r['quantity'])){
        $itemQuantity=$r['stockStatus']=='quantity'?($r['quantity']==0?'Out Of Stock':'In Stock'):($r['stockStatus']=='none'?'':ucwords($r['stockStatus']));
      }
    }
    if(isset($r['contentType'])&&($r['contentType']=='inventory'||$r['contentType']=='activities')){
      $item=preg_replace([
        ($r['coming']==1?'~<quantity>.*?<\/quantity>~is':'/<[\/]?quantity>/'),
  			'/<print content=[\"\']?quantitycolor[\"\']?>/',
        '/<print content=[\"\']?quantity[\"\']?>/',
        '/<print content=[\"\']?stock[\"\']?>/',
        '/<print content=[\"\']?cartonQuantity[\"\']?>/',
  			$r['points']>0&&$config['options'][0]==1?'/<[\/]?points>/':'~<points>.*?<\/points>~is',
  			'/<print content=[\"\']?points[\"\']?>/'
      ],[
        '',
  			str_replace(' ','-',strtolower($itemQuantity)),
        $r['stockStatus']=='quantity'?($r['quantity']==0?'out of stock':'in stock'):($r['stockStatus']!='none'?'':$r['stockStatus']),
        ($r['contentType']!='activities'?($r['stockStatus']=='quantity'?($r['quantity']>0?'in stock':'out of stock'):($r['stockStatus']=='none'?'':$r['stockStatus'])).'.':''),
        ($r['stockStatus']=='in stock'?$r['quantity'].' '.$r['stockStatus']:'').($r['cartonQuantity']>0?' ('.$r['cartonQuantity'].'per carton.)':''),
  			'',
  			number_format((float)$r['points'])
      ],$item);
    }else
      $item=preg_replace('~<quantity>.*?<\/quantity>~is','',$item);
    $uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
/*    if($uid!=0){
      $su=$db->prepare("SELECT `options`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
      $su->execute([':id'=>$uid]);
      $ru=$su->fetch(PDO::FETCH_ASSOC);
      if($config['options'][30]==1){
        if(($r['rank']>300||$r['rank']<400)&&($ru['rank']>300||$ru['rank']<400)&&$ru['options'][19]!=1)
          $item=preg_replace('~<addtocart>.*?<\/addtocart>~is','',$item);
      }
    } */
    if($config['options'][30]==1){
      if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)
        $item=preg_replace('/<[\/]?addtocart>/','',$item);
      else
        $item=preg_replace('~<addtocart>.*?<\/addtocart>~is',$theme['settings']['accounttopurchase'],$item);
    }else{
      $item=preg_replace([
        $r['stockStatus']=='out of stock'?'~<addtocart>.*?<\/addtocart>~is':'/<[\/]?addtocart>/'
      ],[
        ''
      ],$item);
    }
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
        $item=preg_replace('~<size>.*?<\/size>~is','',$item);
    }
    if(stristr($item,'<brand>')){
      if($r['width']!=''&&$r['height']!=''&&$r['length']!=''){
        $sb=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='brand' AND `id`=:id");
        $sb->execute([':id'=>$r['brand']]);
        $rb=$sb->fetch(PDO::FETCH_ASSOC);
        $rb['icon']=rawurldecode($rb['icon']);
        $brand='';
        if(isset($rb['url']))
          $brand=$rb['url']!=''?'<a href="'.$rb['url'].'">':'';
        if(isset($rb['title']))
          $brand.=$rb['icon']==''?$rb['title']:'<img src="'.$rb['icon'].'" alt="'.$rb['title'].'" title="'.$rb['title'].'">';
        if(isset($rb['url']))
          $brand.=$rb['url']!=''?'</a>':'';
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
      $scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='option' AND `rid`=:id ORDER BY `title` ASC");
      $scq->execute([':id'=>isset($r['id'])?$r['id']:$page['id']]);
      if($scq->rowCount()>0){
        $choices='<select class="choices form-control" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());">'.
          '<option value="0">Select an Option</option>';
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

    if(stristr($item,'<map>')){
      $item=preg_replace([
        (isset($r['options'][7])&&$r['options'][7]==1&&$r['geo_position']!=''&&$config['mapapikey']!=''?'/<\/map>/':'~<map>.*?<\/map>~is'),
        '/<map>/'
      ],[
        (isset($r['options'][7])&&$r['options'][7]==1&&$r['geo_position']!=''&&$config['mapapikey']!=''?'<link rel="stylesheet" type="text/css" href="core/js/leaflet/leaflet.css"><script src="core/js/leaflet/leaflet.js"></script><script>var map=L.map("map").setView(['.$r['geo_position'].'],13);L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='.$config['mapapikey'].'",{attribution:`Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>`,maxZoom:18,id:"mapbox/streets-v11",tileSize:512,zoomOffset:-1,accessToken:`'.$config['mapapikey'].'`}).addTo(map);var marker=L.marker(['.$r['geo_position'].'],{draggable:false}).addTo(map);'.($r['title']==''?'':'var popupHtml=`<strong>'.$r['title'].'</strong>'.($r['address']==''?'':'<br><small>'.$r['address'].'<br>'.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].',<br>'.$r['country'].'</small>').'`;marker.bindPopup(popupHtml,{closeButton:false,closeOnClick:false,closeOnEscapeKey:false,autoClose:false}).openPopup();').'marker.off("click");</script>':''),
        ''
      ],$item);
    }
    if(stristr($item,'<json-ld>')){
      $r['schemaType']=isset($r['schemaType'])?$r['schemaType']:$page['schemaType'];
      $r['notes']=isset($r['notes'])?$r['notes']:$page['notes'];
      $r['business']=isset($r['business'])?$r['business']:$config['business'];
      $r['pti']=isset($r['pti'])?$r['pti']:$page['ti'];
      $r['ti']=isset($r['ti'])?$r['ti']:$page['ti'];
      $r['eti']=isset($r['eti'])?$r['eti']:$page['eti'];
      $jsonld='<script type="application/ld+json">{"@context":"http://schema.org/",';
      if($r['schemaType']=='blogPosting'){
        $jsonld.=
        '"@type":"BlogPosting",'.
        '"headline":"'.$r['title'].'",'.
        '"alternativeHeadline":"'.$r['title'].'",'.
        '"image":{'.
          '"@type":"ImageObject",'.
          '"url":"'.($r['file']!=''?$r['file']:FAVICON).'"'.
        '},'.
        '"editor":"'.($ua['name']!=''?$ua['name']:$ua['username']).'",'.
        '"genre":"'.($r['category_1']!=''?$r['category_1']:'None').($r['category_2']!=''?' > '.$r['category_2']:'').($r['category_3']!=''?' > '.$r['category_3']:'').($r['category_4']!=''?' > '.$r['category_4']:'').'",'.
        '"mainEntityOfPage":"True",'.
        '"keywords":"'.$seoKeywords.'",'.
        '"wordcount":"'.strlen(strip_tags($r['notes'])).'",'.
        '"publisher":{'.
          '"@type":"Organization",'.
          '"name":"'.$config['business'].'",'.
          '"logo":{'.
            '"@type":"ImageObject",'.
            '"url":"'.URL.FAVICON.'",'.
            '"width":"400",'.
            '"height":"55"'.
          '}'.
        '},'.
        '"url":"'.$canonical.'",'.
        '"datePublished":"'.date('Y-m-d',$r['pti']).'",'.
        '"dateCreated":"'.date('Y-m-d',$r['ti']).'",'.
        '"dateModified":"'.date('Y-m-d',$r['eti']).'",'.
        '"description":"'.escaper($seoDescription).'",'.
        '"articleBody":"'.escaper(strip_tags($r['notes'])).'",'.
        '"author":{'.
          '"@type":"Person",'.
          '"name":"'.($ua['name']!=''?$ua['name']:$ua['username']).'"'.
        '}';
      }elseif($r['schemaType']=='Product'){
        $jsonld.=
        '"@type":"Product",'.
        '"name":"'.$r['title'].'",'.
        '"image":{'.
          '"@type":"ImageObject",'.
          '"url":"'.($r['file']!=''?$r['file']:FAVICON).'"'.
        '},'.
        '"description":"'.escaper($seoDescription!=''?$seoDescription:strip_tags($r['notes'])).'",'.
        '"mpn":"'.($r['barcode']==''?$r['id']:$r['barcode']).'",'.
        '"sku":"'.($r['fccid']==''?$r['id']:$r['fccid']).'",'.
        '"brand":{"@type":"Brand","name":"'.($r['brand']!=''?$r['brand']:$config['business']).'"},';
        $jss=$db->prepare("SELECT AVG(`cid`) as rate, COUNT(`id`) as cnt FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid AND `status`='approved'");
        $jss->execute([':rid'=>$r['id']]);
        $jrr=$jss->fetch(PDO::FETCH_ASSOC);
        if($jrr['cnt']>0){
          $jsonld.=
          '"aggregateRating":{'.
            '"@type":"aggregateRating",'.
            '"ratingValue":"'.($jrr['rate']==''?'1':$jrr['rate']).'",'.
            '"reviewCount":"'.($jrr['cnt']==0?'1':$jrr['cnt']).'"'.
          '},';
        }
        $jss=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid AND `status`='approved' ORDER BY `ti` DESC");
        $jss->execute([':rid'=>$r['id']]);
        if($jss->rowCount()>0){
          $rc=1;
          $jsonld.='"review":[';
          while($jrr=$jss->fetch(PDO::FETCH_ASSOC)){
            $jsonld.='{'.
              '"@type":"Review",'.
              '"reviewRating":{'.
                '"@type":"Rating",'.
                '"ratingValue":"'.$jrr['cid'].'"'.
              '},'.
              '"name":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'",'.
              '"author":{'.
                '"@type":"Person",'.
                '"name":"'.htmlspecialchars($jrr['name'],ENT_QUOTES,'UTF-8').'"'.
              '},'.
              '"datePublished":"'.date('Y-m-d',$jrr['ti']).'",'.
              '"reviewBody":"'.strip_tags($jrr['notes']).'",'.
              '"publisher":{'.
                '"@type":"Organization",'.
                '"name":"'.htmlspecialchars($jrr['name'],ENT_QUOTES,'UTF-8').'"'.
              '}'.
            '}'.($rc < $jss->rowCount()?',':'');
            $rc++;
          }
          $jsonld.='],';
        }
        $jsonld.='"offers":{'.
          '"@type":"Offer",'.
          '"url":"'.$canonical.'",';
        if(is_numeric($r['cost'])||is_numeric($r['rCost'])){
          if(is_numeric($r['rCost'])&&$r['rCost']!=0){
            $jsonld.='"priceCurrency":"AUD",'.
              '"price":"'.$r['rCost'].'",'.
              '"priceValidUntil":"'.date('Y-m-d',strtotime('+6 month',time())).'",';
          }elseif(is_numeric($r['cost'])&&$r['cost']!=0){
            $jsonld.='"priceCurrency":"AUD",'.
              '"price":"'.$r['cost'].'",'.
              '"priceValidUntil":"'.date('Y-m-d',strtotime('+6 month',time())).'",';
          }
        }
        if($r['stockStatus']!='none'){
          if($r['stockStatus']!=''){
            $jsonld.='"availability":"'.($r['stockStatus']=='quantity'?($r['quantity']>0?'http://schema.org/InStock':'http://schema.org/OutOfStock'):'http://schema.org/'.str_replace(' ','',ucwords($r['stockStatus']))).'",'.
          '"seller":{'.
            '"@type":"Organization",'.
            '"name":"'.$config['business'].'"'.
            '}'.
          '}';
          }
        }
      }elseif($r['schemaType']=='Service'){
        $jsonld.=
        '"@type":"Service",'.
        '"serviceType":"'.$r['category_1'].'",'.
        '"provider":{'.
          '"@type":"LocalBusiness",'.
          '"name":"'.$config['business'].'",'.
          '"address":"'.$config['address'].', '.$config['state'].', '.$config['postcode'].'",'.
          '"telephone":"'.($config['phone']!=''?$config['phone']:$config['mobile']).'",'.
          '"priceRange":"'.($r['rCost']!=0?$r['rCost']:$r['cost']).'",'.
          '"image":"'.($r['file']!=''?$r['file']:URL.FAVICON).'"'.
        '},'.
        '"areaServed":{'.
          '"@type":"State",'.
          '"name":"All"'.
        '}';
      }else{
        $jsonld.=
        '"@type":"'.$r['schemaType'].'",'.
        '"headline":"'.$r['title'].'",'.
        '"alternativeHeadline":"'.$r['title'].'",'.
        '"image":{'.
          '"@type":"ImageObject",'.
          '"url":"'.($r['file']!=''?$r['file']:FAVICON).'"'.
        '},'.
        '"author":"'.(isset($ua['name'])&&$ua['name']!=''?$ua['name']:(isset($ua['username'])&&$ua['username']!=''?$ua['username']:'')).'",'.
        '"genre":"'.($r['category_1']!=''?$r['category_1']:'None').($r['category_2']!=''?' > '.$r['category_2']:'').($r['category_3']!=''?' > '.$r['category_3']:'').($r['category_4']!=''?' > '.$r['category_4']:'').'",'.
        '"keywords":"'.$seoKeywords.'",'.
        '"wordcount":"'.strlen(strip_tags(escaper($r['notes']))).'",'.
        '"publisher":{'.
          '"@type":"Organization",'.
          '"name":"'.$config['business'].'"'.
        '},'.
        '"url":"'.$canonical.'/",'.
        '"datePublished":"'.date('Y-m-d',$r['pti']).'",'.
        '"dateCreated":"'.date('Y-m-d',$r['ti']).'",'.
        '"dateModified":"'.date('Y-m-d',$r['eti']).'",'.
        '"description":"'.escaper(strip_tags(rawurldecode($seoDescription))).'",'.
        '"articleBody":"'.escaper(strip_tags($r['notes'])).'"';
      }
      $jsonld.='}</script>';
      $item=str_replace('<json-ld>',$jsonld,$item);
    }
    $sidecat=isset($r['category_1'])&&$r['category_1']!=''?$r['category_1']:'';
    $item=preg_replace([
      '/<print author=[\"\']?name[\"\']?>/'
    ],[
      isset($ua['name'])&&$ua['name']!=''?htmlspecialchars($ua['name'],ENT_QUOTES,'UTF-8'):(isset($ua['username'])&&$ua['username']!=''?htmlspecialchars($ua['username'],ENT_QUOTES,'UTF-8'):'')
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
        $sr->execute([':id'=>$r['id']]);
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
            if($si->rowCount()>0){
              $ri=$si->fetch(PDO::FETCH_ASSOC);
              $ri['thumb']=rawurldecode($ri['thumb']);
              if($ri['thumb']=='')$ri['thumb']=NOIMAGESM;
              $relatedQuantity='';
              if(isset($ri['quantity'])&&is_numeric($ri['quantity'])&&$ri['quantity']!=0)
                $relatedQuantity.=$ri['stockStatus']=='quantity'?($ri['quantity']==0?'<div class="quantity">Out Of Stock</div>':'<div class="quantity">'.htmlspecialchars($ri['quantity'],ENT_QUOTES,'UTF-8').' <span class="quantity-text">In Stock</span></div>'):($ri['stockStatus']=='none'?'':'<div class="quantity">'.ucwords($ri['stockStatus']).'</div>');
              $relateditem=preg_replace([
                '/<print related=[\"\']?linktitle[\"\']?>/',
                '/<print thumb=[\"\']?srcset[\"\']?>/',
                '/<print related=[\"\']?thumb[\"\']?>/',
                '/<print related=[\"\']?imageALT[\"\']?>/',
                '/<print related=[\"\']?title[\"\']?>/',
                '/<print related=[\"\']?contentType[\"\']?>/',
                '/<print related=[\"\']?quantity[\"\']?>/',
                '/<print related=[\"\']?rank[\'"\']?>/',
                '/<print related=[\"\']?cssrank[\'"\']?>/',
              ],[
                isset($ri['contentType'])?URL.$ri['contentType'].'/'.urlencode(str_replace(' ','-',strtolower($ri['urlSlug']))).'/':'',
                (isset($ri['file'])?'srcset="'.($ri['file']!=''&&file_exists('media/sm/'.basename($ri['thumb']))?'media/sm/'.basename($ri['thumb']).' '.$config['mediaMaxWidthThumb'].'w,':'').($ri['file']!=''&&file_exists('media/md/'.basename($ri['thumb']))?'media/md/'.basename($ri['thumb']).' 600w,':'').($ri['file']!=''&&file_exists('media/sm/'.basename($ri['thumb']))?'media/sm/'.basename($ri['thumb']).' 400w':'').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" ':''),
                isset($ri['thumb'])&&$ri['thumb']!=''?$ri['thumb']:NOIMAGESM,
                isset($ri['fileALT'])?htmlspecialchars($ri['fileALT']!=''?$ri['fileALT']:$ri['title'],ENT_QUOTES,'UTF-8'):'',
                isset($ri['title'])?htmlspecialchars($ri['title'],ENT_QUOTES,'UTF-8'):'',
                isset($ri['contentType'])?$ri['contentType']:'',
                $relatedQuantity,
                $ri['rank']>300?ucwords(str_replace('-',' ',rank($ri['rank']))):'',
                rank($ri['rank'])
              ],$relateditem);
              $relitems.=$relateditem;
            }
          }
          $related=preg_replace('~<relitems>.*?<\/relitems>~is',$relitems,$related,1);
          $item=preg_replace('~<related.*>.*?<\/related>~is',$related,$item,1);
        }else
          $item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
      }else
        $item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
    }else
      $item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
  /* Downloads */
    if(stristr($item,'<downloads')){
      preg_match('/<downloads>([\w\W]*?)<\/downloads>/',$item,$matches);
      $downloads=$matches[1];
      preg_match('/<downloaditems>([\w\W]*?)<\/downloaditems>/',$downloads,$matches);
      $ditem=$matches[1];
      $ditems='';
      $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='download' AND `password`='0' AND `rid`=:rid ORDER BY `url` ASC, `title` ASC");
      $sd->execute([':rid'=>$r['id']]);
      if($sd->rowCount()>0){
        while($rd=$sd->fetch(PDO::FETCH_ASSOC)){
          $di=$ditem;
          $di=preg_replace([
            '/<print download=[\"\']?url[\"\']?>/',
            '/<print download=[\"\']?title[\"\']?>/'
          ],[
            URL.'downloads/'.$rd['url'],
            $rd['title']!=''?$rd['title']:$rd['url']
          ],$di);
          $ditems.=$di;
        }
        $item=preg_replace([
          '/<[\/]?downloads>/',
          '~<downloaditems>.*?<\/downloaditems>~is',
        ],[
          '',
          $ditems
        ],$item,1);
      }else
        $item=preg_replace('~<downloads>.*?<\/downloads>~is','',$item,1);
    }
  /* Reviews */
    if($view!='page'&&stristr($item,'<review')){
      preg_match('/<review>([\w\W]*?)<\/review>/',$item,$matches);
      $review=$matches[1];
      $sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review' AND `status`='approved' AND `rid`=:rid");
      $sr->execute([':rid'=>isset($r['id'])?$r['id']:$page['id']]);
      $reviews='';
      while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
        $reviewitem=$review;
        if(stristr($reviewitem,'<json-ld-review>')){
          $jsonldreview='<script type="application/ld+json">{'.
            '"@context":"https://schema.org/",'.
            '"@type":"Review",'.
            '"itemReviewed":{'.
              '"@type":"Product",'.
              '"image":"'.($r['file']!=''?$r['file']:FAVICON).'",'.
              '"name":"'.$r['title'].'"'.
            '},'.
            '"reviewRating":{'.
              '"@type":"Rating",'.
              '"ratingValue":"'.$rr['cid'].'"'.
            '},'.
            '"name":"'.$r['title'].'",'.
            '"author":{'.
              '"@type":"Person",'.
              '"name":"'.($rr['name']!=''?$rr['name']:'Anonymous').'"'.
            '},'.
            '"datePublished":"'.date('Y-m-d',$rr['ti']).'",'.
            '"reviewBody":"'.$rr['notes'].'",'.
            '"publisher":{'.
              '"@type":"Organization",'.
              '"name":"'.$config['business'].'"'.
            '}'.
          '}</script>';
        }
        $reviewitem=str_replace('<json-ld-review>',$jsonldreview,$reviewitem);
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
    require'core/parser.php';
    $authorHTML='';
    if(isset($r['contentType'])&&($r['contentType']=='article'||$r['contentType']=='portfolio'))
      $item=preg_replace('~<controls>.*?<\/controls>~is','',$item,1);
    $html=preg_replace([
      '~<settings.*?>~is',
      '~<more>.*?<\/more>~is',
      '/<print page=[\"\']?notes[\"\']?>/',
      '/<print config=[\"\']?business[\"\']?>/',
      '/<print view>/'
    ],[
      '',
      '',
      '',
      ucwords($config['business']),
      $view,
    ],$html);
    if($view=='article'||$view=='events'||$view=='news'||$view=='proofs'){
      $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`=:contentType AND `rid`=:rid AND `status`!='unapproved' ORDER BY `ti` ASC");
      $sc->execute([
        ':contentType'=>$view,
        ':rid'=>$r['id']
      ]);
      if($sc->rowCount()>0||$r['options'][1]==1){
        if(file_exists(THEME.'/comments.html')){
          $comments=$commentsHTML='';
          $commentsHTML=file_get_contents(THEME.'/comments.html');
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
            require'core/parser.php';
            $comments.=$comment;
          }
          $commentsHTML=preg_replace('~<items>.*?<\/items>~is',$comments,$commentsHTML,1);
          $commentsHTML=preg_replace([
            $r['options'][1]==1?'/<\/?comment>/':'~<comment>.*?<\/comment>~is',
            '~<items>.*?<\/items>~is',
            '/<g-recaptcha>/'
          ],[
            '',
            '',
            $config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':''
          ],$commentsHTML);
          $item=preg_replace('/<comments>/',$commentsHTML,$item,1);
        }else
          $item.='Comments for this post are Enabled, but no <strong>"'.THEME.'/comments.html"</strong> template file exists';
      }else
        $item=preg_replace('/<comments>/','',$item,1);
    }else
      $item=preg_replace('/<comments>/','',$item,1);
    $html=preg_replace('~<item>.*?<\/item>~is',$item,$html,1);
  }
}else{
  $html=preg_replace([
    '~<item>.*?<\/item>~is',
    '~<category-nav>.*?<\/category-nav>~is',
    '~<eventsitems.*>.*?<\/eventitems>~is',
  ],[
    '<article class="card col-12 col-sm"><div class="alert alert-info" role="alert">This content is not available to your account ranking.</div></article>',
    '',
    ''
  ],$html);
}
