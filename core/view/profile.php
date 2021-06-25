<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Profile
 * @package    core/view/profile.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$html=preg_replace([
  $page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<print page=[\"\']?notes[\"\']?>/',
],[
  '',
  $page['notes']
],$html);
if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsoni=2;
  $jsonld='<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"'.URL.'","name":"Home"}},';
  $breadit=preg_replace([
    '/<print breadcrumb=[\"\']?url[\"\']?>/',
    '/<print breadcrumb=[\"\']?title[\"\']?>/'
  ],[
    URL,
    'Home'
  ],$breaditem);
  $breaditems=$breadit;
  if($page['title']!=''||$args[0]!=''){
    $breadit=preg_replace([
      '/<print breadcrumb=[\"\']?url[\"\']?>/',
      '/<print breadcrumb=[\"\']?title[\"\']?>/'
    ],[
      URL.'profile',
      'Profile'
    ],$breaditem);
    $jsonld.='{"@type":"ListItem","position":2,"item":{"@id":"'.URL.'profile","name":"Profile"}},';
    $breaditems.=$breadit;
  }else{
    $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/','Profile',$breadcurrent);
    $jsonld.='{"@type":"ListItem","position":2,"item":{"@id":"'.URL.'profile","name":"Profile"}},';
    $breaditems.=$breadit;
  }
  if(isset($args[0])&&$args[0]!=''){
    $jsoni++;
		if($r['title']!=''||(isset($args[1])&&$args[1]!='')){
	    $breadit=preg_replace([
	      '/<print breadcrumb=[\"\']?url[\"\']?>/',
	      '/<print breadcrumb=[\"\']?title[\"\']?>/'
	    ],[
	      URL.'profile/'.str_replace(' ','-',urlencode($args[0])),
	      htmlspecialchars(ucfirst($args[0]),ENT_QUOTES,'UTF-8')
	    ],$breaditem);
		}else
			$breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars(ucfirst($args[0]),ENT_QUOTES,'UTF-8'),$breadcurrent);
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.'profile/'.str_replace(' ','-',urlencode($args[0])).'","name":"'.htmlspecialchars(ucfirst($args[0]),ENT_QUOTES,'UTF-8').'"}}';
    $breaditems.=$breadit;
  }
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
if($args[0]!=''){
  $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE LOWER(`name`)=LOWER(:name)");
  $s->execute([':name'=>str_replace('-',' ',$args[0])]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($r['bio_options'][0]==1){
    if($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))$r['avatar']='media/avatar/'.basename($r['avatar']);
    else$r['avatar']=NOAVATAR;
    $name=explode(' ',$r['name']);
    $html=preg_replace([
      '/<[\/]?profile>/',
      '~<profiles>.*?<\/profiles>~is',
      '/<print meta=[\"\']?seoTitle[\"\']?>/',
      '/<print meta=[\"\']?seoDescription[\"\']?>/',
      '/<print meta=[\"\']?url[\"\']?>/',
      '/<print meta=[\"\']?favicon[\"\']?>/',
      '/<print theme>/',
      '/<print meta=[\"\']?canonical[\"\']?>/',
      '/<print user=[\"\']?name[\"\']?>/',
      '/<print user=[\"\']?image[\"\']?>/',
      '/<print userMenu>/',
      '/<print user=[\"\']?caption[\"\']?>/',
      '/<print user=[\"\']?notes[\"\']?>/',
      '/<print user=[\"\']?url[\"\']?>/',
      '/<print config=[\"\']?url[\"\']?>/',
      '/<print config=[\"\']?business[\"\']?>/',
      '/<print firstName>/',
      '/<print lastName>/',
      '/<print username>/',
      '/<print site_verifications>/',
      '/<print year>/',
      '/<[\/]?proflie>/',
      '/<profiles>.*?<\/profiles>/'
    ],[
      '',
      '',
      htmlspecialchars($r['name'].' - Profile'.($config['business']!=''?' | '.$config['business']:''),ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8'),
      URL.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
      htmlspecialchars($r['avatar'],ENT_QUOTES,'UTF-8'),
      THEME,
      htmlspecialchars(URL.'profile/'.strtolower(str_replace(' ','-',urlencode($r['name']))),ENT_QUOTES,'UTF-8').'/',
      htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['avatar'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars(URL.'profile/'.strtolower(str_replace(' ','-',urlencode($r['name']))),ENT_QUOTES,'UTF-8').'/',
      htmlspecialchars($r['caption'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['notes'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['url'],ENT_QUOTES,'UTF-8'),
      URL.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
      htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
      $name[0],
      $name[1],
      $r['username'],
      ($config['ga_verification']!=''?'<meta name="google-site-verification" content="'.$config['ga_verification'].'">':'').
        ($config['seo_msvalidate']!='<meta name="msvalidate.01" content="'.$config['seo_msvalidate'].'">'?'':'').
        ($config['seo_yandexverification']!='<meta name="yandex-verification" content="'.$config['seo_yandexverification'].'">'?'':'').
        ($config['seo_alexaverification']!=''?'<meta name="alexaVerifyID" content="'.$config['seo_alexaverification'].'">':'').
        ($config['seo_pinterestverify']!=''?'<meta name="p:domain_verify" content="'.$config['seo_pinterestverify'].'">':''),
      date('Y',time()),
      '',
      ''
    ],$html);
    if(stristr($html,'<buildSocial')){
    	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
    	$item=$matches[1];
    	$items='';
    	$sl=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=:uid ORDER BY `icon` ASC");
      $sl->execute([':uid'=>$r['id']]);
    	if($sl->rowCount()>0){
    		while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
    			$build=$item;
    			$build=str_replace([
  					'<print sociallink>',
  					'<print socialicon>'
  				],[
  					htmlspecialchars($rl['url'],ENT_QUOTES,'UTF-8'),
  					frontsvg('i-social-'.$rl['icon'])
  				],$build);
  			  $items.=$build;
    		}
    	}else$items='';
    	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$items,$html,1);
    }
    if(stristr($html,'<resume')){
      preg_match('/<resume>([\w\W]*?)<\/resume>/',$html,$matches);
      $resume=$matches[1];
      if(stristr($resume,'<career')&&$r['bio_options'][2]==1){
        preg_match('/<career>([\w\W]*?)<\/career>/',$resume,$matches);
        $career=$matches[1];
        preg_match('/<item>([\w\W]*?)<\/item>/',$career,$matches);
        $item=$matches[1];
        $items='';
        $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='career' AND `cid`=:cid ORDER BY `tis` ASC");
        $ss->execute([':cid'=>$r['id']]);
        if($ss->rowCount()>0){
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
            $build=$item;
            if(stristr($build,'<print icon')){
              preg_match('/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',$build,$matches);
              $icon=$matches[1];
            }else$icon='';
            $build=preg_replace([
              '/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',
              '/<print career=[\"\']?title[\"\']?>/',
              '/<print career=[\"\']?business[\"\']?>/',
              '/<print career=[\"\']?tis[\"\']?>/',
              '/<print career=[\"\']?tie[\"\']?>/',
              '/<print career=[\"\']?notes[\"\']?>/'
            ],[
              $icon==''?'':frontsvg($icon),
              htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
              htmlspecialchars($rs['business'],ENT_QUOTES,'UTF-8'),
              $rs['tis']!=0?' / '.date('Y-M',$rs['tis']):' / Current',
              $rs['tie']!=0?' - '.date("Y-M",$rs['tie']):$rs['tis']==0?'':' - Current',
              $rs['notes']
            ],$build);
            $items.=$build;
          }
        }else$items='';
        $career=preg_replace('~<item>.*?<\/item>~is',$items,$career,1);
      }else$career='';
      if(stristr($resume,'<education')&&$r['bio_options'][3]==1){
        preg_match('/<education>([\w\W]*?)<\/education>/',$resume,$matches);
        $education=$matches[1];
        preg_match('/<item>([\w\W]*?)<\/item>/',$education,$matches);
        $item=$matches[1];
        $items='';
        $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='education' AND `cid`=:cid ORDER BY `tis` ASC");
        $ss->execute([':cid'=>$r['id']]);
        if($ss->rowCount()>0){
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
            $build=$item;
            if(stristr($build,'<print icon')){
              preg_match('/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',$build,$matches);
              $icon=$matches[1];
            }else$icon='';
            $build=preg_replace([
              '/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',
              '/<print education=[\"\']?title[\"\']?>/',
              '/<print education=[\"\']?institute[\"\']?>/',
              '/<print education=[\"\']?tis[\"\']?>/',
              '/<print education=[\"\']?tie[\"\']?>/',
              '/<print education=[\"\']?notes[\"\']?>/'
            ],[
              $icon==''?'':frontsvg($icon),
              htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
              htmlspecialchars($rs['business'],ENT_QUOTES,'UTF-8'),
              $rs['tis']!=0?' / '.date('Y-M',$rs['tis']):' / Current',
              $rs['tie']!=0?' - '.date("Y-M",$rs['tie']):$rs['tis']==0?'':' - Current',
              $rs['notes']
            ],$build);
            $items.=$build;
          }
        }else$items='';
        $education=preg_replace('~<item>.*?<\/item>~is',$items,$education,1);
      }else$education='';
      if($career!=''||$education!=''){
        $html=preg_replace([
          '/<print resume=[\"\']?notes[\"\']?>/',
          '~<career>.*?<\/career>~is',
          '~<education>.*?<\/education>~is',
          '/<[\/]?resumeMenu>/',
          '/<[\/]?resume>/',
          '~<resume>.*?<\/resume>~'
        ],[
          htmlspecialchars($r['resume_notes'],ENT_QUOTES,'UTF-8'),
          $career,
          $education,
          '',
          '',
          $resume
        ],$html,1);
      }
    }else{
      $html=preg_replace([
          '~<resume>.*?<\/resume>~is',
          '~<resumeMenu>.*?<\/resumeMenu>~is'
        ],
        '',
        $html,1);
    }
    if(stristr($html,'<content')){
      preg_match('/<content>([\w\W]*?)<\/content>/',$html,$matches);
      $profilecontent=$matches[1];
      preg_match('/<item>([\w\W]*?)<\/item>/',$profilecontent,$matches);
      $item=$matches[1];
      $items='';
      $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='article' AND `uid`=:uid AND `status`='published' ORDER BY `ti` DESC LIMIT 5");
      $ss->execute([':uid'=>$r['id']]);
      if($ss->rowCount()>0){
        while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
          if($rs['fileURL']!=''&&$rs['file']=='')$rs['file']=$fileURL;
          elseif($rs['fileURL']==''&&$rs['file']=='')$rs['file']=NOIMAGE;
          $build=$item;
          $build=preg_replace([
            '/<print content=[\"\']?image[\"\']?>/',
            '/<print content=[\"\']?fileALT[\"\']?>/',
            '/<print content=[\"\']?title[\"\']?>/',
            '/<print content=[\"\']?notes[\"\']?>/',
            '/<print content=[\"\']?link[\"\']?>/'
          ],[
            htmlspecialchars($rs['file'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars($rs['fileALT']!=''?$rs['fileALT']:$rs['attributionImageTitle']),
            htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars(strip_tags(substr($rs['notes'], 0, strrpos(substr($rs['notes'], 0, 400), ' '))),ENT_QUOTES,'UTF-8'),
            URL.'article/'.$rs['urlSlug'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:'')
          ],$build);
          $items.=$build;
        }
      }else$items='';
      $profilecontent=preg_replace('~<item>.*?<\/item>~is',$items,$profilecontent,1);
      $html=preg_replace([
        '~<content>.*?<\/content>~is',
        '/<[\/]?contentMenu>/',
      ],[
        $profilecontent,
        ''
      ],$html,1);
    }else{
      $html=preg_replace([
        '~<content>.*?<\/content>~is',
        '~<contentMenu>.*?<\/contentMenu>~is'
      ],'',$html,1);
    }
    if(stristr($html,'<contact')&&$r['bio_options'][1]==1){
      preg_match('/<contact>([\w\W]*?)<\/contact>/',$html,$matches);
      $contact=$matches[1];
      $contact=preg_replace([
        '/<print contact=[\"\']?phone[\"\']?>/',
        '/<print contact=[\"\']?mobile[\"\']?>/',
        '/<print contact=[\"\']?email[\"\']?>/',
        '/<print contact=[\"\']?address[\"\']?>/',
        '/<print contact=[\"\']?suburb[\"\']?>/',
        '/<print contact=[\"\']?state[\"\']?>/',
        '/<print contact=[\"\']?country[\"\']?>/',
        '/<print contact=[\"\']?postcode[\"\']?>/',
        '/<print contact=[\"\']?url[\"\']?>/'
      ],[
        htmlspecialchars($r['phone'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['mobile'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['email'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['address'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['suburb'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['state'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['country'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['postcode'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['url'],ENT_QUOTES,'UTF-8')
      ],$contact);
      $html=preg_replace('~<contact>.*?<\/contact>~is',$contact,$html,1);
    }else{
      $html=preg_replace([
          '~<contact>.*?<\/contact>~is',
          '~<contactMenu>.*?<\/contactMenu>~is'
        ],'',$html,1);
    }
    $items=$html;
    $html=$items;
    $doc=new DOMDocument();
    @$doc->loadHTML($html);
    $svgs=$doc->getElementsByTagName('icon');
    foreach($svgs as$svg){
      $icon=$svg->getAttribute('svg');
      $html=preg_replace('/<icon svg=[\"\']?'.$icon.'[\"\']?>/',frontsvg($icon),$html,1);
    }
    $seoTitle=empty($r['seoTitle'])?trim(htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8')):htmlspecialchars($r['seoTitle'],ENT_QUOTES,'UTF-8');
    $metaRobots=!empty($r['metaRobots'])?htmlspecialchars($r['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
    $seoCaption=!empty($r['seoCaption'])?htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
    $seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
    $seoDescription=!empty($r['seoDescription'])?htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
    $seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
    $seoKeywords=!empty($r['seoKeywods'])?htmlspecialchars($r['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');
    $seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;
    $content.=$html;
  }
}else{
  $html=preg_replace([
    '/<[\/]?profiles>/',
    '~<profile>.*?<\/profile>~is',
    '/<print meta=[\"\']?seoTitle[\"\']?>/',
    '/<print meta=[\"\']?url[\"\']?>/',
    '/<print meta=[\"\']?favicon[\"\']?>/',
    '/<print theme>/',
    '/<print meta=[\"\']?canonical[\"\']?>/'
  ],[
    '',
    '',
    htmlspecialchars('Profiles'.($config['business']!=''?' - '.$config['business']:''),ENT_QUOTES,'UTF-8'),
    URL.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
    FAVICON,
    THEME,
    URL.'profile/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:'')
  ],$html);
  $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `bio_options` LIKE '1%' ORDER BY `name` ASC");
  $s->execute();
  if($s->rowCount()>0){
    if(stristr($html,'<items')){
      preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
      $item=$matches[1];
      $items='';
      while($r=$s->fetch(PDO::FETCH_ASSOC)){
        if($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))$r['avatar']='media/avatar/'.basename($r['avatar']);
        elseif($r['gravatar']!='')$r['avatar']=$r['gravatar'];
        else$r['avatar']=NOAVATAR;
        $build=$item;
        $build=preg_replace([
          '/<print user=[\"\']?link[\"\']?>/',
          '/<print user=[\"\']?name[\"\']?>/',
          '/<print user=[\"\']?image[\"\']?>/',
          '/<print user=[\"\']?caption[\"\']?>/'
        ],[
          htmlspecialchars(URL.'profile/'.str_replace(' ','-',$r['name']),ENT_QUOTES,'UTF-8').'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
          htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($r['avatar'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($r['caption'],ENT_QUOTES,'UTF-8')
        ],$build);
        $items.=$build;
      }
    }else$items='';
    $html=preg_replace('~<items>.*?<\/items>~is',$items,$html,1);
  }
  $content.=$html;
}
