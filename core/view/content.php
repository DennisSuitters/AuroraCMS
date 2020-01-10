<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Content
 * @package    core/view/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Related Content Processing
 * @changes    v0.0.2 Make sure all links end with /
 * @changes    v0.0.3 Add parsing of <print view>
 * @changes    v0.0.3 Fix Image for JSON-LD Schema to fall back to Favicon.
 * @changes    v0.0.4 Adjust SQL for Related Items so only Published Content is selected.
 * @changes    v0.0.4 Add Front End Editing.
 * @changes    v0.0.7 Add Parsing for RRP and Reduced Cost Prices.
 * @changes    v0.0.8 Fix missing SQL prefix from SQL Query at line 326
 * @changes    v0.0.10 Replace {} to [] for PHP7.4 Compatibilty.
 */
$rank=0;
$notification='';
$show='categories';
$status='published';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$itemCount=$config['showItems'];
if($view=='newsletters'){
	if($args[0]=='unsubscribe'&&isset($args[1])){
		$s=$db->prepare("DELETE FROM `".$prefix."subscribers` WHERE hash=:hash");
		$s->execute([':hash'=>$args[1]]);
		$notification=$theme['settings']['notification_unsubscribe'];
	}
}
if($view=='page')
	$show='';
elseif($view=='search'){
	if(isset($args[0])&&$args[0]!='')
		$search='%'.html_entity_decode(str_replace('-','%',$args[0])).'%';
	elseif(isset($_POST['search'])&&$_POST['search']!='')
		$search='%'.html_entity_decode(str_replace('-','%',filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING))).'%';
	else
		$search='%';
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(code) LIKE LOWER(:search) OR LOWER(brand) LIKE LOWER(:search) OR LOWER(title) LIKE LOWER(:search) OR LOWER(category_1) LIKE LOWER(:search) OR LOWER(category_2) LIKE LOWER(:search) OR LOWER(category_3) LIKE LOWER(:search) OR LOWER(category_4) LIKE LOWER(:search) OR LOWER(seoKeywords) LIKE LOWER(:search) OR LOWER(tags) LIKE LOWER(:search) OR LOWER(seoCaption) LIKE LOWER(:search) OR LOWER(seoDescription) LIKE LOWER(:search) OR LOWER(notes) LIKE LOWER(:search) AND status=:status ORDER BY ti DESC");
	$s->execute([
		':search'=>$search,
		':status'=>$status
	]);
}elseif($view=='index'){
	$contentType=$cat1='';
	$itemCount=$config['showItems'];
	if(stristr($html,'<settings')){
		preg_match('/<settings.*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
		$itemCount=isset($matches[1])&&$matches[1]!=0?$matches[1]:$config['showItems'];
		preg_match('/<settings.*contenttype=[\"\'](.*?)[\"\'].*>/',$html,$matches);
		$contentType=isset($matches[1])&&($matches[1]!='all')?$matches[1]:'%';
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND contentType NOT LIKE 'message%' AND contentType NOT LIKE 'testimonial%' AND contentType NOT LIKE 'proof%' AND status LIKE :status AND internal!='1' AND pti < :ti	ORDER BY featured DESC, ti DESC LIMIT $itemCount");
	$s->execute([
		':contentType'=>$contentType,
		':status'=>$status,
		':ti'=>time()
	]);
}elseif($view=='bookings')
	$id=(isset($args[0])?(int)$args[0]:0);
elseif(isset($args[1])&&strlen($args[1])==2){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND ti < :ti ORDER BY ti ASC");
	$s->execute([
		':contentType'=>$view,
		':ti'=>DateTime::createFromFormat('!d/m/Y','01/'.$args[1].'/'.$args[0])->getTimestamp()
	]);
	$show='categories';
}elseif(isset($args[0])&&strlen($args[0])==4){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND ti>:ti ORDER BY ti ASC");
	$tim=strtotime('01-Jan-'.$args[0]);
	$s->execute([
		':contentType'=>$view,
		':ti'=>DateTime::createFromFormat('!d/m/Y','01/01/'.$args[0])->getTimestamp()
	]);
	$show='categories';
}elseif(isset($args[1])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':status'=>$status,
		':ti'=>time()
	]);
}elseif(isset($args[2])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND LOWER(category_3) LIKE LOWER(:category_3) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':category_3'=>html_entity_decode(str_replace('-',' ',$args[2])),
		':status'=>$status,
		':ti'=>time()
	]);
}elseif(isset($args[3])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND LOWER(category_3) LIKE LOWER(:category_3) AND LOWER(category_4) LIKE LOWER(:category_4) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':category_3'=>html_entity_decode(str_replace('-',' ',$args[2])),
		':category_4'=>html_entity_decode(str_replace('-',' ',$args[3])),
		':status'=>$status,
		':ti'=>time()
	]);
}elseif(isset($args[0])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':status'=>$status,
		':ti'=>time()
	]);
	if($s->rowCount()<1){
		if($view=='proofs'){
			$status='%';
			if($_SESSION['loggedin']==false)
				die();
		}
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(urlSlug) LIKE LOWER(:urlSlug) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
		$s->execute([
			':contentType'=>$view,
			':urlSlug'=>$args[0],
			':status'=>$status,
			':ti'=>time()
		]);
		$show='item';
	}
}else{
	if($view=='proofs'){
		if(isset($_SESSION['uid'])&&$_SESSION['uid']!=0){
			$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE 'proofs' AND uid=:uid ORDER BY ord ASC, ti DESC");
			$s->execute([':uid'=>$_SESSION['uid']]);
		}
	}else{
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC LIMIT $itemCount");
		$s->execute([
			':contentType'=>$view,
			':status'=>$status,
			':ti'=>time()
		]);
	}
}
if($show=='categories'){
	$contentType=$view;
	$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	if(stristr($html,'<settings')){
		$matches=preg_match_all('/<settings items="(.*?)" contenttype="(.*?)">/',$html,$matches);
		$count=$matches[0];
		$html=preg_replace('~<settings.*?>~is','',$html,1);
	}else
		$count=1;
	$html=preg_replace([
		'/<print view>/',
		'/<print content=[\"\']?category[\"\']?>/'
	],[
		$view,
		$args[0]!=''?html_entity_decode($args[0]):''
	],$html);
	if(stristr($html,'<print page="coverVideo">')){
		if($page['coverVideo']!=''){
			$cover=basename($page['coverVideo']);
			$html=preg_replace(
				'/<print page=[\"\']?coverVideo[\"\']?>/',
				'<video preload autoplay loop muted><source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video>',
				$html
			);
		}else
			$html=preg_replace('/<print page=[\"\']?coverVideo[\"\']?>/','',$html);
	}
	if(stristr($html,'<print page=cover>')){
		if($page['cover']!=''||$page['coverURL']!=''){
			$cover=basename($page['cover']);
			$coverLink='';
			if(isset($page['cover'])&&$page['cover']!='')
				$coverLink.='media'.DS.$cover;
			elseif($page['coverURL']!='')
				$coverLink.=$page['coverURL'];
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','background-image:url('.htmlspecialchars($coverLink,ENT_QUOTES,'UTF-8').');',$html);
		}else
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','',$html);
	}
	if(preg_match('/<print page=[\"\']?cover[\"\']?>/',$html)){
		if($page['cover']!=''||$page['coverURL']!=''){
			$cover=basename($page['cover']);
			list($width,$height)=getimagesize($page['cover']);
			$coverHTML='<img src="';
			if(file_exists('media'.DS.$cover))
				$coverHTML.=htmlspecialchars($page['cover'],ENT_QUOTES,'UTF-8');
			elseif($page['coverURL']!='')
				$coverHTML.=htmlspecialchars($page['coverURL'],ENT_QUOTES,'UTF-8');
			$coverHTML.='" alt="';
			if($page['attributionImageTitle']==''&&$page['attributionImageName']==''&&$page['attributionImageURL']==''){
				if($page['attributionImageTitle'])$coverHTML.=$page['attributionImageTitle'].$page['attributionImageName']!=''?' - ':'';
				if($page['attributionImageName'])$coverHTML.=$page['attributionImageName'].$page['attributionImageURL']!=''?' - ':'';
				if($page['attributionImageURL'])$coverHTML.=htmlspecialchars($page['attributionImageURL'],ENT_QUOTES,'UTF-8');
			}else
				$coverHTML.=$page['seoTitle']!=''?$page['seoTitle']:$config['seoTitle'];
			if($page['seoTitle']==''&&$config['seoTitle']=='')
				$coverHTML.=htmlspecialchars(basename($page['cover']),ENT_QUOTES,'UTF-8');
			$coverHTML.='">';
		}else
			$coverHTML='';
		$html=preg_replace(
			[
				'/<print page=[\"\']?cover[\"\']?>/',
				'/<print page=[\"\']?fileALT[\"\']?>/'
			],[
				$coverHTML,
				htmlspecialchars($page['fileALT'],ENT_QUOTES,'UTF-8')
			],
			$html);
	}
	$html=preg_replace([
		'/<print page=[\"\']?contentType[\"\']?>/',
		'/<notification>/'
	],[
		htmlspecialchars(ucfirst($page['contentType']),ENT_QUOTES,'UTF-8').($page['contentType']=='article'||$page['contentType']=='service'?'s':''),
		$notification
	],$html);
	if($page['notes']!=''){
		if(isset($_SESSION['rank'])&&$_SESSION['rank']>899){
			$html=preg_replace([
				'/<print page=[\"\']?notes[\"\']?>/',
				'/<\/?pagenotes>/'
			],[
				'<form id="note-form" target="sp" enctype="multipart/form-data" method="post" action="core/update.php">'.
					'<input type="hidden" name="id" value="'.$page['id'].'">'.
					'<input type="hidden" name="t" value="menu">'.
					'<input type="hidden" name="c" value="notes">'.
					'<textarea class="editable" name="da">'.rawurldecode($page['notes']).'</textarea>'.
				'</form>',
				''
			],$html);
		}else{
			$html=preg_replace([
				'/<print page=[\"\']?notes[\"\']?>/',
				'/<\/?pagenotes>/'
			],[
				rawurldecode($page['notes']),
				''
			],$html);
		}
	}else
		$html=preg_replace('~<pagenotes>.*?<\/pagenotes>~is','',$html,1);
	$html=$config['business']?preg_replace('/<print content=[\"\']?seoTitle[\"\']?>/',htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),$html):preg_replace('/<print content=[\"\']?seoTitle[\"\']?>/',htmlspecialchars($config['seoTitle'],ENT_QUOTES,'UTF-8'),$html);
	if(stristr($html,'<mediaitems')){
		$sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE pid=:pid AND rid=0 ORDER BY ord ASC");
		$sm->execute([':pid'=>$page['id']]);
		if($sm->rowCount()>0){
			preg_match('/<mediaitems>([\w\W]*?)<\/mediaitems>/',$html,$matches2);
			$media=$matches2[1];
			preg_match('/<mediaimages>([\w\W]*?)<\/mediaimages>/',$media,$matches3);
			$mediaitem=$matches3[1];
			$mediaoutput='';
			while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
				if(!file_exists('media'.DS.basename($rm['file'])))continue;
				$mediaitems=$mediaitem;
				list($width,$height)=getimagesize($rm['file']);
				$tags='';
				if($rm['tags']!=''){
					$mediatags=explode(',',$rm['tags']);
					foreach($mediatags as$mt)$tags.='#'.htmlspecialchars($mt,ENT_QUOTES,'UTF-8').' ';
				}
				$mediaitems=preg_replace([
					'/<print media=[\"\']?image[\"\']?>/',
					'/<print media=[\"\']?fileALT[\"\']?>/',
					'/<print media=[\"\']?width[\"\']?>/',
					'/<print media=[\"\']?height[\"\']?>/',
					'/<print media=[\"\']?title[\"\']?>/',
					'/<print media=[\"\']?category_1[\"\']?>/',
					'/<print media=[\"\']?category_2[\"\']?>/',
					'/<print media=[\"\']?category_3[\"\']?>/',
					'/<print media=[\"\']?category_4[\"\']?>/',
					'/<print media=[\"\']?attributionName[\"\']?>/',
					'/<print media=[\"\']?attributionURL[\"\']?>/',
					'/<print media=[\"\']?exifISO[\"\']?>/',
					'/<print media=[\"\']?exifAperture[\"\']?>/',
					'/<print media=[\"\']?exifFocalLength[\"\']?>/',
					'/<print media=[\"\']?exifShutterSpeed[\"\']?>/',
					'/<print media=[\"\']?exifCamera[\"\']?>/',
					'/<print media=[\"\']?exifLens[\"\']?>/',
					'/<print media=[\"\']?exifFilename[\"\']?>/',
					'/<print media=[\"\']?exifTime[\"\']?>/',
					'/<print media=[\"\']?tags[\"\']?>/',
					'/<print media=[\"\']?seoTitle[\"\']?>/',
					'/<print media=[\"\']?caption[\"\']?>/',
					'/<print media=[\"\']?description[\"\']?>/'
				],[
					htmlspecialchars($rm['file'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['fileALT']!=''?$rm['fileALT']:$rm['title'],ENT_QUOTES,'UTF-8'),
					$width,
					$height,
					htmlspecialchars($rm['title'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['category_1'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['category_2'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['category_3'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['category_4'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['attributionImageName'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['attributionImageURL'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifISO'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifAperture'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifFocalLength'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifShutterSpeed'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifCamera'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifLens'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifFilename'],ENT_QUOTES,'UTF-8'),
					date($config['dateFormat'],$rm['exifti']),
					$tags,
					htmlspecialchars($rm['seoTitle'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['seoCaption'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['seoDescription'],ENT_QUOTES,'UTF-8')
				],$mediaitems);
				$mediaoutput.=$mediaitems;
			}
			$html=preg_replace('~<mediaimages>.*?<\/mediaimages>~is',$mediaoutput,$html,1);
		}else
			$html=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$html,1);
	}
	if(stristr($html,'<categories')){
		$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='category' ORDER BY title ASC");
		$sc->execute();
		if($sc->rowCount()>0){
			preg_match('/<categories>([\w\W]*?)<\/categories>/',$html,$matches);
			$catitem=$matches[1];
			$catoutput='';
			while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
				$catitems=$catitem;
				if($rc['icon']!=''||!file_exists('media'.DS.basename($rc['icon'])))$rc['icon']=$noimage;
				$catitems=preg_replace([
					'/<print category=[\"\']?image[\"\']?>/',
					'/<print category=[\"\']?imageALT[\"\']?>/',
					'/<print category=[\"\']?link[\"\']?>/',
					'/<print category=[\"\']?title[\"\']?>/'
				],[
					htmlspecialchars($rc['icon'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars('Category '.$rc['title'],ENT_QUOTES,'UTF-8'),
					URL.$rc['url'].'/'.str_replace(' ','-',$rc['title']).'/',
					htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8')
				],$catitems);
				$catoutput.=$catitems;
			}
			$html=preg_replace('~<categories>.*?<\/categories>~is',$catoutput,$html,1);
		}else
			$html=preg_replace('~<categories>.*?<\/categories>~is','',$html,1);
	}
	if(stristr($html,'<items')){
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
		$item=$matches[1];
		$output='';
		$si=1;
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$filechk=$noimage;
			$thumbchk=$noimage;
			if($view=='search'){
				if($r['contentType']=='testimonials'||$r['contentType']=='proofs')continue;
			}
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
				URL.'profile/'.strtolower(str_replace(' ','-',htmlspecialchars($r['login_user'],ENT_QUOTES,'UTF-8'))).'/',
				URL.$r['contentType'].'/'.$r['urlSlug'].'/',
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
						'/<view>/',
						'/<\/view>/'
					],[
						URL.$r['contentType'].'/'.$r['urlSlug'].'/',
						htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
						'',
						''
					],$items);
				}
				if($r['contentType']=='service'||$r['contentType']=='events'){
					if($r['bookable']==1){
						if(stristr($items,'<service')){
							$items=preg_replace([
								'/<print content=[\"\']?bookservice[\"\']?>/',
								'/<service>/',
								'/<\/service>/',
								'~<inventory>.*?<\/inventory>~is'
							],[
								$r['id'],
								'',
								'',
								''
							],$items);
						}
					}else{
						$items=preg_replace([
							'/<inventory>/',
							'/<\/inventory>/',
							'~<service.*?>.*?<\/service>~is'
						],'',$items,1);
					}
				}else{
					$items=preg_replace([
						'/<inventory>/',
						'/<\/inventory>/',
						'~<service.*?>.*?<\/service>~is'
					],'',$items,1);
				}
				if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
					if(stristr($items,'<inventory')){
						$items=preg_replace([
							'/<inventory>/',
							'/<\/inventory>/',
							'~<service>.*?<\/service>~is'
						],'',$items);
					}elseif(stristr($items,'<inventory')&&$r['contentType']!='inventory'&&!is_numeric($r['cost']))
						$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				}else
					$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				$items=preg_replace([
					'/<controls>/',
					'/<\/controls>/'
				],'',$items);
			}
			require'core'.DS.'parser.php';
			$output.=$items;
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
		'/<items>/',
		'/<\/items>/'
	],'',$html);
	if(stristr($html,'<more>')){
		if($s->rowCount()<=$config['showItems'])
			$html=preg_replace('~<more>.*?<\/more>~is','',$html,1);
		else{
			$html=preg_replace([
				'/<more>/',
				'/<\/more>/',
				'/<print view>/',
				'/<print contentType>/',
				'/<print config=[\"\']?showItems[\"\']?>/'
			],[
				'',
				'',
				$view,
				$contentType,
				$config['showItems']
			],$html);
		}
	}
}
if($view=='testimonials')$show='';
if($show=='item'){
	$html=preg_replace([
		'~<items>.*?<\/items>~is',
		'~<pagenotes>.*?<\/pagenotes>~is'
	],[
		''
	],$html,1);
	$r=$s->fetch(PDO::FETCH_ASSOC);
	$seoTitle=$r['seoTitle']==''?$r['title']:$r['seoTitle'];
	$metaRobots=$r['metaRobots']==''?$r['metaRobots']:$page['metaRobots'];
	$seoCaption=$r['seoCaption']==''?$r['seoCaption']:$page['seoCaption'];
	$seoDescription=$r['seoDescription']!=''?$r['seoDescription']:($r['seoCaption']!=''?$r['seoCaption']:substr(strip_tags($r['notes']),0,160));
	$seoKeywords=$r['seoKeywords']==''?$r['seoKeywords']:$page['seoKeywords'];
	$su=$db->prepare("UPDATE `".$prefix."content` SET views=:views WHERE id=:id");
	$su->execute([
		':views'=>$r['views']+1,
		':id'=>$r['id']
	]);
	$us=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:uid");
	$us->execute([
		':uid'=>$r['uid']
	]);
	$ua=$us->fetch(PDO::FETCH_ASSOC);
	if($r['fileURL']!='')
		$shareImage=$r['fileURL'];
	elseif($r['file']!='')
		$shareImage=$r['file'];
	elseif($r['thumb']!='')
		$shareImage=$r['thumb'];
	else
		$shareImage=URL.NOIMAGE;
	$canonical=URL.$view.'/'.$r['urlSlug'].'/';
	$contentTime=isset($r['eti'])&&($r['eti']>$r['ti'])?$r['eti']:isset($r['ti'])?$r['ti']:0;
	if(preg_match('/<print page=[\"\']?cover[\"\']?>/',$html)){
		if($r['fileURL'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img class="img-fluid" src="'.$r['fileURL'].'" alt="'.($r['fileALT']!=''?$r['fileALT']:$r['attributionImageTitle']).'">',$html);
		elseif($r['file'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img class="img-fluid" src="'.$r['file'].'" alt="'.($r['fileALT']!=''?$r['fileALT']:$r['attributionImageTitle']).'">',$html);
		elseif($page['cover'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img src="'.$page['cover'].'" alt="'.($r['fileALT']!=''?$r['fileALT']:$r['attributionImageTitle']).'">',$html);
		elseif($page['coverURL'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img src="'.$page['coverURL'].'" alt="'.($r['fileALT']!=''?$r['fileALT']:$r['attributionImageTitle']).'">',$html);
		else
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','',$html);
	}
	if(preg_match('/<print content=[\"\']?image[\"\']?>/',$html)){
		if($r['fileURL'])
			$html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['fileURL'],$html);
		elseif($r['file']&&file_exists('media'.DS.basename($r['file'])))
			$html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['file'],$html);
		else
			$html=preg_replace('/<print content=[\"\']?image[\"\']?>/',NOIMAGE,$html);
	}
	$html=preg_replace([
			'/<print content=[\"\']?imageALT[\"\']?>/'
		],[
			htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8')
		],$html);
	if(stristr($html,'<item')){
		preg_match('/<item>([\w\W]*?)<\/item>/',$html,$matches);
		$item=$matches[1];
		if(stristr($item,'<mediaitems')){
			$sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE pid=:id ORDER BY ord ASC");
			$sm->execute([':id'=>isset($r['id'])?$r['id']:$page['id']]);
			if($sm->rowCount()>0){
				preg_match('/<mediaitems>([\w\W]*?)<\/mediaitems>/',$item,$matches2);
				$media=$matches2[1];
				preg_match('/<mediaimages>([\w\W]*?)<\/mediaimages>/',$media,$matches3);
				$mediaitem=$matches3[1];
				$mediaoutput='';
				while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
					if(!file_exists('media'.DS.basename($rm['file'])))continue;
					$mediaitems=$mediaitem;
					list($width,$height)=getimagesize($rm['file']);
					$tags='';
					if($rm['tags']!=''){
						$mediatags=explode(',',$rm['tags']);
						foreach($mediatags as$mt)$tags.='#'.htmlspecialchars($mt,ENT_QUOTES,'UTF-8').' ';
					}
					$bname=basename(substr($rm['file'],0,-4));
					$bname=rtrim($bname,'.');
					$mediaitems=preg_replace([
						'/<print media=[\"\']?thumb[\"\']?>/',
						'/<print media=[\"\']?file[\"\']?>/',
						'/<print media=[\"\']?fileALT[\"\']?>/',
						'/<print media=[\"\']?width[\"\']?>/',
						'/<print media=[\"\']?height[\"\']?>/',
						'/<print media=[\"\']?title[\"\']?>/',
						'/<print media=[\"\']?category_1[\"\']?>/',
						'/<print media=[\"\']?category_2[\"\']?>/',
						'/<print media=[\"\']?category_3[\"\']?>/',
						'/<print media=[\"\']?category_4[\"\']?>/',
						'/<print media=[\"\']?attributionName[\"\']?>/',
						'/<print media=[\"\']?attributionURL[\"\']?>/',
						'/<print media=[\"\']?exifISO[\"\']?>/',
						'/<print media=[\"\']?exifAperture[\"\']?>/',
						'/<print media=[\"\']?exifFocalLength[\"\']?>/',
						'/<print media=[\"\']?exifShutterSpeed[\"\']?>/',
						'/<print media=[\"\']?exifCamera[\"\']?>/',
						'/<print media=[\"\']?exifLens[\"\']?>/',
						'/<print media=[\"\']?exifFilename[\"\']?>/',
						'/<print media=[\"\']?exifTime[\"\']?>/',
						'/<print media=[\"\']?tags[\"\']?>/',
						'/<print media=[\"\']?seoTitle[\"\']?>/',
						'/<print media=[\"\']?caption[\"\']?>/',
						'/<print media=[\"\']?description[\"\']?>/'
					],[
						URL.'media/thumbs/'.$bname.'.png',
						htmlspecialchars($rm['file'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars(($rm['fileALT']!=''?$rm['fileALT']:$bname),ENT_QUOTES,'UTF-8'),
						$width,
						$height,
						htmlspecialchars(($rm['title']!=''?$rm['title']:$bname),ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['category_1'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['category_2'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['category_3'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['category_4'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['attributionImageName'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['attributionImageURL'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifISO'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifAperture'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifFocalLength'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifShutterSpeed'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifCamera'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifLens'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifFilename'],ENT_QUOTES,'UTF-8'),
						date($config['dateFormat'],$rm['exifti']),
						$tags,
						htmlspecialchars($rm['seoTitle'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['seoCaption'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['seoDescription'],ENT_QUOTES,'UTF-8')
					],$mediaitems);
					$mediaoutput.=$mediaitems;
				}
				$item=preg_replace([
					'/<mediaitems>/',
					'/<\/mediaitems>/',
					'~<mediaimages>.*?<\/mediaimages>~is'
				],[
					'',
					'',
					$mediaoutput
				],$item);
			}else
				$item=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$item,1);
		}else
			$item=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$item,1);
		if(isset($r['contentType'])&&($r['contentType']=='service'||$r['contentType']=='events')){
			if($r['bookable']==1){
				if(stristr($item,'<service>')){
					$item=preg_replace([
						'/<service>/',
						'/<\/service>/',
						'~<inventory>.*?<\/inventory>~is',
						'/<print content=[\"\']?bookservice[\"\']?>/'
					],[
						'',
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
				'~<inventory>.*?<\/inventory>~is'
			],'',$item,1);
		}
		$address=$edit=$contentQuantity='';
		if(isset($r['contentType'])&&($r['contentType']=='inventory')){
			if(is_numeric($r['quantity'])&&$r['quantity']!=0){
				$contentQuantity.=$r['stockStatus']=='quantity'?($r['quantity']==0?'<div class="quantity">Out Of Stock</div>':'<div class="quantity">'.htmlspecialchars($r['quantity'],ENT_QUOTES,'UTF-8').' <span class="quantity-text">In Stock</span></div>'):($r['stockStatus']=='none'?'':'<div class="quantity">'.ucwords($r['stockStatus']).'</div>');
			}
			$item=preg_replace([
				'/<print content=[\"\']?quantity[\"\']?>/'
			],[
				$contentQuantity
			],$item);
		}else
			$item=preg_replace('/<print content=[\"\']?quantity[\"\']?>/','',$item);
		if(stristr($item,'<choices')){
			$scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE rid=:id ORDER BY title ASC");
			$scq->execute([':id'=>isset($r['id'])?$r['id']:$page['id']]);
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
			$jsonld='<script type="application/ld+json">{'.
				'"@context":"http://schema.org/",';
			if($r['schemaType']=='blogPosting'){
				$jsonld.='"@type":"BlogPosting",'.
					'"headline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'",'.
					'"alternativeHeadline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'",'.
					'"image":{'.
						'"@type":"ImageObject",'.
						'"url":"';
				if($r['file']!=''&&file_exists('media/'.basename($r['file'])))
					$jsonld.=$r['file'].'"';
				else
					$jsonld.=URL.FAVICON.'"';
				$jsonld.='},'.
					'"editor":"'.htmlspecialchars(($ua['name']!=''?$ua['name']:$ua['username']),ENT_QUOTES,'UTF-8').'",'.
					'"genre":"'.($r['category_1']!=''?htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8'):'None').($r['category_2']!=''?' > '.htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8'):'').($r['category_3']!=''?' > '.htmlspecialchars($r['category_3'],ENT_QUOTES,'UTF-8'):'').($r['category_4']!=''?' > '.htmlspecialchars($r['category_4'],ENT_QUOTES,'UTF-8'):'').'",'.
					'"mainEntityOfPage":"True",'.
					'"keywords":"'.htmlspecialchars($seoKeywords,ENT_QUOTES,'UTF-8').'",'.
					'"wordcount":"'.htmlspecialchars(strlen(strip_tags($r['notes'])),ENT_QUOTES,'UTF-8').'",'.
					'"publisher":{'.
						'"@type":"Organization",'.
						'"name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'",'.
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
					'"description":"'.htmlspecialchars($seoDescription,ENT_QUOTES,'UTF-8').'",'.
					'"articleBody":"'.htmlspecialchars(strip_tags($r['notes']),ENT_QUOTES,'UTF-8').'",'.
					'"author":{'.
						'"@type":"Person",'.
						'"name":"'.($ua['name']!=''?htmlspecialchars($ua['name'],ENT_QUOTES,'UTF-8'):htmlspecialchars($ua['username'],ENT_QUOTES,'UTF-8')).'"'.
				 	'}';
			}elseif($r['schemaType']=='Product'){
				$jsonld.='"@type":"Product",'.
  				'"name":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'",'.
					'"image":{'.
						'"@type":"ImageObject",'.
						'"url":"';
				if($r['file']!=''&&file_exists('media/'.basename($r['file'])))
					$jsonld.=$r['file'].'"';
				else
					$jsonld.=URL.FAVICON.'"';
				$jsonld.='},'.
  				'"description":"'.($seoDescription!=''?htmlspecialchars($seoDescription,ENT_QUOTES,'UTF-8'):htmlspecialchars(strip_tags(escaper($r['notes'])),ENT_QUOTES,'UTF-8')).'",'.
  				'"mpn":"'.($r['barcode']==''?$r['id']:htmlspecialchars($r['barcode'],ENT_QUOTES,'UTF-8')).'",'.
					'"sku":"'.($r['fccid']==''?$r['id']:htmlspecialchars($r['fccid'],ENT_QUOTES,'UTF-8')).'",'.
  				'"brand":{'.
    				'"@type":"Thing",'.
    				'"name":"'.htmlspecialchars($r['brand'],ENT_QUOTES,'UTF-8').'"'.
  				'},';
				$jss=$db->prepare("SELECT AVG(cid) as rate,COUNT(id) as cnt FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid AND status='approved'");
				$jss->execute([
					':rid'=>$r['id']
				]);
				$jrr=$jss->fetch(PDO::FETCH_ASSOC);
  			$jsonld.='"aggregateRating":{'.
    				'"@type":"aggregateRating",'.
    				'"ratingValue":"'.($jrr['rate']==''?'1':$jrr['rate']).'",'.
    				'"reviewCount":"'.($jrr['cnt']==0?'1':$jrr['cnt']).'"'.
  				'},'.
  				'"offers":{'.
    				'"@type":"Offer",'.
						'"url":"'.$canonical.'",'.
    				'"priceCurrency":"AUD",'.
    				'"price":"'.($r['rCost']!=0?$r['rCost']:($r['cost']==''?0:$r['cost'])).'",'.
    				'"priceValidUntil":"'.date('Y-m-d',strtotime('+6 month',time())).'",'.
    				'"availability":"'.($r['stockStatus']=='quantity'?($r['quantity']==0?'OutOfStock':'In Stock'):($r['stockStatus']=='none'?'OutOfStock':'InStock')).'",'.
    				'"seller":{'.
      				'"@type":"Organization",'.
      				'"name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'"'.
    				'}'.
  				'}';
			}elseif($r['schemaType']=='Service'){
					$jsonld.='"@type":"Service",'.
  				'"serviceType":"'.htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8').'",'.
  				'"provider":{'.
    				'"@type":"LocalBusiness",'.
    				'"name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'",'.
						'"address":"'.htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8').', '.htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8').', '.htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8').'",'.
						'"telephone":"'.($config['phone']!=''?htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'):htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')).'",'.
						'"priceRange":"'.htmlspecialchars(($r['rCost']!=0?$r['rCost']:$r['cost']),ENT_QUOTES,'UTF-8').'",'.
						'"image":"'.($r['file']!=''?$r['file']:URL.FAVICON).'"'.
  				'},'.
  				'"areaServed":{'.
    				'"@type":"State",'.
    				'"name":"All"'.
  				'}';
			}else{
				$jsonld.='"@type":"'.$r['schemaType'].'",'.
					'"headline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'",'.
					'"alternativeHeadline":"'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'",'.
					'"image":{'.
						'"@type":"ImageObject",'.
						'"url":"';
				if($r['file']!=''&&file_exists('media/'.basename($r['file'])))
					$jsonld.=$r['file'].'"';
				else
					$jsonld.=URL.FAVICON.'"';
				$jsonld.='},'.
					'"author":"'.($ua['name']!=''?htmlspecialchars($ua['name'],ENT_QUOTES,'UTF-8'):htmlspecialchars($ua['username'],ENT_QUOTES,'UTF-8')).'",'.
					'"genre":"'.($r['category_1']!=''?htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8'):'None').($r['category_2']!=''?' > '.htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8'):'').($r['category_3']!=''?' > '.htmlspecialchars($r['category_3'],ENT_QUOTES,'UTF-8'):'').($r['category_4']!=''?' > '.htmlspecialchars($r['category_4'],ENT_QUOTES,'UTF-8'):'').'",'.
					'"keywords":"'.htmlspecialchars($seoKeywords,ENT_QUOTES,'UTF-8').'",'.
					'"wordcount":"'.htmlspecialchars(strlen(strip_tags(escaper($r['notes']))),ENT_QUOTES,'UTF-8').'",'.
					'"publisher":{'.
						'"@type":"Organization",'.
						'"name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'"'.
					'},'.
					'"url":"'.$canonical.'/",'.
					'"datePublished":"'.date('Y-m-d',$r['pti']).'",'.
					'"dateCreated":"'.date('Y-m-d',$r['ti']).'",'.
					'"dateModified":"'.date('Y-m-d',$r['eti']).'",'.
					'"description":"'.htmlspecialchars(strip_tags(rawurldecode($seoDescription)),ENT_QUOTES,'UTF-8').'",'.
					'"articleBody":"'.htmlspecialchars(strip_tags(escaper($r['notes'])),ENT_QUOTES,'UTF-8').'"';
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
				if(!isset($matches[1]))$iC=$config['showItems'];
				elseif($matches[1]=='all')$iC='';
				elseif($matches[1]=='default')$iC=$config['showItems'];
				else$iC=$matches[1];
				$sr=$db->prepare("SELECT rid as id FROM `".$prefix."choices` WHERE uid=:id AND contentType='related' ORDER BY title ASC LIMIT $iC");
				$sr->execute([':id'=>$r['id']]);
				$go=false;
				if($sr->rowCount()>0){
					$go=true;
				}else{
					if($config['options'][10]==1){
						if($r['category_1']!=''){
							$sr=$db->prepare("SELECT id FROM `".$prefix."content` WHERE id!=:id AND category_1 LIKE :cat AND status='published' ORDER BY title ASC LIMIT $iC");
							$sr->execute([
								':id'=>$r['id'],
								':cat'=>$r['category_1']
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
						$si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id AND status='published' AND internal=0");
						$si->execute([':id'=>$rr['id']]);
						$ri=$si->fetch(PDO::FETCH_ASSOC);
						if($ri['fileURL']!=''&&($ri['thumb']==''||$ri['file']=='')){
							$relatedImage=$ri['fileURL'];
						}else{
							if($ri['thumb']!=''&&file_exists('media'.DS.'thumbs'.basename($ri['thumb'])))
								$relatedImage='media'.DS.'thumbs'.basename($ri['thumb']);
							elseif($ri['file']!=''&&file_exists('media'.DS.basename($ri['file'])))
								$relatedImage='media'.DS.basename($ri['file']);
							else
								$relatedImage=URL.NOIMAGE;
						}
						$relateditem=preg_replace([
							'/<print related=[\"\']?linktitle[\"\']?>/',
							'/<print related=[\"\']?thumb[\"\']?>/',
							'/<print related=[\"\']?imageALT[\"\']?>/',
							'/<print related=[\"\']?title[\"\']?>/',
							'/<print related=[\"\']?contentType[\"\']?>/'
						],[
							URL.$ri['contentType'].'/'.$ri['urlSlug'].'/',
							$relatedImage,
							htmlspecialchars($ri['fileALT']!=''?$ri['fileALT']:$ri['title'],ENT_QUOTES,'UTF-8'),
							htmlspecialchars($ri['title'],ENT_QUOTES,'UTF-8'),
							$ri['contentType']
						],$relateditem);
						$relitems.=$relateditem;
					}
					$related=preg_replace('~<relitems>.*?<\/relitems>~is',$relitems,$related,1);
					$item=preg_replace('~<related.*>.*?<\/related>~is',$related,$item,1);
				}else{
					$item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
				}
			}else{
				$item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
			}
		}else{
			$item=preg_replace('~<related.*>.*?<\/related>~is','',$item,1);
		}
/* Reviews */
		if($view!='page'&&stristr($item,'<review')){
			preg_match('/<review>([\w\W]*?)<\/review>/',$item,$matches);
			$review=$matches[1];
			$sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType='review' AND status='approved' AND rid=:rid");
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
							'"image":"';
							if(file_exists('media'.DS.basename($r['file'])))
								$jsonldreview.=$r['file'];
							else
								$jsonldreview.=URL.FAVICON;
					$jsonldreview.='",'.
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
		if(isset($r['contentType'])&&($r['contentType']=='article'||$r['contentType']=='portfolio'))
			$item=preg_replace('~<controls>.*?<\/controls>~is','',$item,1);
		$html=preg_replace([
			'~<settings.*?>~is',
			'~<items>.*?<\/items>~is',
			'~<more>.*?<\/more>~is',
			'/<print page=[\"\']?notes[\"\']?>/'
		],'',$html);
		$html=str_replace('<print view>',$view,$html);
		if($view=='article'||$view=='events'||$view=='news'||$view=='proofs'){
			$sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType=:contentType AND rid=:rid AND status!='unapproved' ORDER BY ti ASC");
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
						$comment=preg_replace([
							'/<print comments=[\"\']?datetime[\"\']?>/'
						],[
							date('Y-m-d',$rc['ti'])
						],$comment,1);
						require'core'.DS.'parser.php';
						$comments.=$comment;
					}
					$commentsHTML=preg_replace('~<items>.*?<\/items>~is',$comments,$commentsHTML,1);
					$commentsHTML=$r['options'][1]==1?preg_replace('/<\/?comment>/','',$commentsHTML):preg_replace('~<comment>.*?<\/comment>~is','',$commentsHTML,1);
					$commentsHTML=preg_replace('~<items>.*?<\/items>~is','',$commentsHTML,1);
					$item.=$commentsHTML;
				}else
					$item.='Comments for this post is Enabled, but no <strong>"'.THEME.DS.'comments.html"</strong> template file exists';
			}
		}
		$html=preg_replace('~<item>.*?<\/item>~is',$item,$html,1);
	}
}
if($view=='login'){
	$html=preg_replace('/<print url>/',URL,$html,1);
	if($config['options'][3]==1)
		$html=preg_replace('/<\/?signup?>/','',$html);
	else
		$html=preg_replace('~<signup>.*?<\/signup>~is','',$html,1);
}
$content.=$html;
