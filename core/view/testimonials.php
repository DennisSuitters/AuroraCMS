<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Bookings
 * @package    core/view/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Add Page Editing.
 * @changes    v0.0.14 Fix incorrect number of items returned from database.
 * @changes    v0.0.15 Add Star Rating parser.
 * @changes    v0.0.16 Reduce preg_replace parsing strings.
 * @changes    v0.0.18 Reformat source for legibility.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 * @changes    v0.0.20 Add parsing for Breadcrumbs.
 */
if(stristr($html,'<settings')){
	preg_match('/<settings.*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
	$count=isset($matches[1])&&$matches[1]!=0?$matches[1]:$config['showItems'];
}else
	$count=$config['showItems'];

if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsoni=2;
  $jsonld='<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"'.URL.'","'.$config['business'].'":"Home"}},';
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
  if($r['title']!=''||$args[0]!=''){
    $breadit=preg_replace([
      '/<print breadcrumb=[\"\']?url[\"\']?>/',
      '/<print breadcrumb=[\"\']?title[\"\']?>/'
    ],[
      URL.$page['contentType'],
      ucfirst($page['title'])
    ],$breaditem);
    $jsonld.='{"@type":"ListItem","position":2,"item":{"@id":"'.URL.$page['contentType'].'","name":"'.ucfirst($page['contentType']).'"}},';
    $breaditems.=$breadit;
  }else{
    $breadit=preg_replace([
      '/<print breadcrumb=[\"\']?title[\"\']?>/'
    ],[
      $page['title']
    ],$breadcurrent);
    $jsonld.='{"@type":"ListItem","position":2,"item":{"@id":"'.URL.$page['contentType'].'","name":"'.ucfirst($page['contentType']).'"}},';
    $breaditems.=$breadit;
  }
  if(isset($args[0])&&$args[0]!=''){
    $jsoni++;
		if($r['title']!=''||(isset($args[1])&&$args[1]!='')){
	    $breadit=preg_replace([
	      '/<print breadcrumb=[\"\']?url[\"\']?>/',
	      '/<print breadcrumb=[\"\']?title[\"\']?>/'
	    ],[
	      URL.$page['contentType'].'/'.str_replace(' ','-',$args[0]),
	      ucfirst($args[0])
	    ],$breaditem);
		}else{
			$breadit=preg_replace([
				'/<print breadcrumb=[\"\']?title[\"\']?>/'
			],[
				ucfirst($args[0])
			],$breadcurrent);
		}
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.$page['contentType'].'/'.str_replace(' ','-',$args[0]).'","name":"'.ucfirst($args[0]).'"}"}},';
    $breaditems.=$breadit;
  }
  if(isset($args[2])&&$args[2]!=''){
    $jsoni++;
		if($r['title']!=''||$args[2]!=''){
    	$breadit=preg_replace([
      	'/<print breadcrumb=[\"\']?url[\"\']?>/',
      	'/<print breadcrumb=[\"\']?title[\"\']?>/'
    	],[
      	URL.$page['contentType'].'/'.str_replace(' ','-',$args[1]).'/'.str_replace(' ','-',$args[2]),
      	ucfirst($args[2])
    	],$breaditem);
		}else{
			$breadit=preg_replace([
      	'/<print breadcrumb=[\"\']?title[\"\']?>/'
    	],[
      	ucfirst($args[2])
    	],$breadcurrent);
		}
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.$page['contentType'].'/'.str_replace(' ','-',$args[1]).'/'.str_replace(' ','-',$args[2]).'","name": "'.ucfirst($args[2]).'"}"}},';
    $breaditems.=$breadit;
  }
  if(isset($args[3])&&$args[3]!=''){
    $jsoni++;
		if($r['title']!=''||$args[3]!=''){
    	$breadit=preg_replace([
      	'/<print breadcrumb=[\"\']?url[\"\']?>/',
      	'/<print breadcrumb=[\"\']?title[\"\']?>/'
    	],[
      	URL.$page['contentType'].'/'.str_replace(' ','-',$args[1]).'/'.str_replace(' ','-',$args[2]).'/'.str_replace(' ','-',$args[3]),
      	ucfirst($args[3])
    	],$breaditem);
		}else{
			$breadit=preg_replace([
      	'/<print breadcrumb=[\"\']?title[\"\']?>/'
    	],[
      	ucfirst($args[3])
    	],$breadcurrent);
		}
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.$page['contentType'].'/'.str_replace(' ','-',$args[1]).'/'.str_replace(' ','-',$args[2]).'/'.str_replace(' ','-',$args[3]).'","name": "'.ucfirst($args[3]).'"}"}},';
    $breaditems.=$breadit;
  }
  if(isset($args[4])&&$args[4]!=''){
    $jsoni++;
		if($r['title']!=''||$args[4]!=''){
    	$breadit=preg_replace([
      	'/<print breadcrumb=[\"\']?url[\"\']?>/',
      	'/<print breadcrumb=[\"\']?title[\"\']?>/'
    	],[
      	URL.$page['contentType'].'/'.str_replace(' ','-',$args[1]).'/'.str_replace(' ','-',$args[2]).'/'.str_replace(' ','-',$args[3]).'/'.str_replace(' ','-',$args[4]),
      	ucfirst($args[4])
    	],$breaditem);
		}else{
			$breadit=preg_replace([
      	'/<print breadcrumb=[\"\']?title[\"\']?>/'
    	],[
      	ucfirst($args[4])
    	],$breadcurrent);
		}
    $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.URL.$page['contentType'].'/'.str_replace(' ','-',$args[1]).'/'.str_replace(' ','-',$args[2]).'/'.str_replace(' ','-',$args[3]).'/'.str_replace(' ','-',$args[4]).'","name": "'.ucfirst($args[4]).'"}"}},';
    $breaditems.=$breadit;
  }
  if($r['title']!=''){
    $jsoni++;
    $breadit=preg_replace([
      '/<print breadcrumb=[\"\']?title[\"\']?>/'
    ],[
      ucfirst($r['title'])
    ],$breadcurrent);
    $jsonld.='{'.
      '"@type":"ListItem",'.
      '"position":'.$jsoni.','.
      '"item":{'.
        '"@id":"'.URL.$page['contentType'].'/'.$r['urlSlug'].'",'.
        '"name": "'.$r['title'].'"}"}'.
      '},'.
      '}';
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


$html=preg_replace('~<settings.*?>~is','',$html);
if($page['notes']!=''){
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<[\/]?pagenotes>/'
	],[
		rawurldecode($page['notes']),
		''
	],$html);
}else
	$html=preg_replace('~<pagenotes>.*?<\/pagenotes>~is','',$html,1);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$sqltest="SELECT * FROM `".$prefix."content` WHERE `contentType`='testimonials' AND `status`='published' ORDER BY `ti` DESC".($count!='all'?" LIMIT 0,".$count:"");
$s=$db->query($sqltest);
$i=0;
$items=$testitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		$items=$i==0?preg_replace('/<print content=[\"\']?active[\"\']?>/',' active', $items):preg_replace('/<print content=[\"\']?active[\"\']?>/','',$items);
		$items=preg_replace([
			'/<print content=[\"\']?schemaType[\"\']?>/',
			'/<print config=[\"\']?title[\"\']?>/',
			'/<print datePub>/'
		],[
			$r['schemaType'],
			htmlspecialchars($config['seoTitle'],ENT_QUOTES,'UTF-8'),
			date('Y-d-m',$r['ti'])
		],$items);
		if(preg_match('/<print content=[\"\']?avatar[\"\']?>/',$items)){
			if($r['cid']!=0){
				$su=$db->prepare("SELECT `avatar`,`gravatar` FROM `".$prefix."login` WHERE `id`=:id");
				$su->execute([
					':id'=>$r['cid']
				]);
				$ru=$su->fetch(PDO::FETCH_ASSOC);
				if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media'.DS.'avatar'.DS.$ru['avatar'],$items);
				elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media'.DS.'avatar'.DS.basename($r['file']),$items);
				elseif(stristr($ru['gravatar'],'@'))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','http://gravatar.com/avatar/'.md5($ru['gravatar']),$items);
				elseif(stristr($ru['gravatar'],'gravatar.com'))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$ru['gravatar'],$items);
				else
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
			}elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media'.DS.'avatar'.DS.basename($r['file']),$items);
			elseif($r['file']!='')
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$r['file'],$items);
			else
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
		}
		$jsonld='';
		if(stristr($items,'<json-ld-testimonial>')){
			$jsonld='<script type="application/ld+json">{"@context":"https://schema.org/","@type":"Review","itemReviewed":{"@type":"localBusiness","image":"'.THEME.'/images/logo.png'.'","name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'","telephone":"'.($config['phone']!=''?htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'):htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')).'","address":{"@type":"PostalAddress","streetAddress":"'.htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8').'","addressLocality":"'.htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8').'","addressRegion":"'.htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8').'","postalCode":"'.htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8').'","addressCountry":"'.htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8').'"}},"author":"'.($r['name']!=''?htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'):'Anonymous').($r['name']!=''&&$r['business']!=''?' : ':'').($r['business']!=''?htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8'):'').'","datePublished":"'.date('Y-m-d',$r['ti']).'","reviewBody":"'.htmlspecialchars(strip_tags(rawurldecode($r['notes'])),ENT_QUOTES,'UTF-8').'","reviewRating":{"@type":"Rating","bestRating":"5","ratingValue":"5","worstRating":"1"}}</script>';
		}
		$items=preg_replace([
			'/<print content=[\"\']?notes[\"\']?>/',
			'/<print content=[\"\']?business[\"\']?>/',
			'/<print content=[\"\']?name[\"\']?>/',
			'/<json-ld-testimonial>/',
			'/<print review=[\"\']?rating[\"\']?>/',
			'/<print review=[\"\']?set5[\"\']?>/',
			'/<print review=[\"\']?set4[\"\']?>/',
			'/<print review=[\"\']?set3[\"\']?>/',
			'/<print review=[\"\']?set2[\"\']?>/',
			'/<print review=[\"\']?set1[\"\']?>/'
		],[
			($view=='index'?substr(strip_tags(rawurldecode($r['notes'])),0,600):strip_tags(rawurldecode($r['notes']))),
			$r['business']!=''?htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8'):'Anonymous',
			$r['name']!=''?htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'):'Anonymous',
			$jsonld,
			$r['rating'],
			$r['rating']>=5?'set':'',
			$r['rating']>=4?'set':'',
			$r['rating']>=3?'set':'',
			$r['rating']>=2?'set':'',
			$r['rating']>=1?'set':''
		],$items);
		$testitems.=$items;
		$i++;
	}
}
if($i>0)$html=preg_replace('/<[\/]?controls>/','',$html);
else$html=preg_replace('~<controls>.*?<\/controls>~is','',$html,1);
$html=preg_replace('~<items>.*?<\/items>~is',$testitems,$html,1);
$s=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='subject' ORDER BY `title` ASC");
$s->execute();
if($s->rowCount()>0){
	$html=preg_replace([
		'~<subjectText>.*?<\/subjectText>~is',
		'/<[\/]?subjectSelect>/'
	],'',$html);
	$options='';
	while($r=$s->fetch(PDO::FETCH_ASSOC))$options.='<option value="'.$r['id'].'">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</option>';
	$html=str_replace('<subjectOptions>',$options,$html);
}else{
	$html=preg_replace([
		'~<subjectSelect>.*?<\/subjectSelect>~is',
		'/<[\/]?subjectText>/'
	],'',$html);
}
$content.=$html;
