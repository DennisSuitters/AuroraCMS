<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Content
 * @package    core/view/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$show='categories';
$status='published';
$rowCount=0;
$sqlLimit='';
$itemPage=isset($_GET['page'])?$_GET['page']:0;
if($config['showItems']>0){
	if(isset($_POST['itemCount'])){
		$config['showItems']=$_POST['itemCount'];
	}elseif(isset($_COOKIE['itemCount'])){
		$config['showItems']=$_COOKIE['itemCount'];
	}
}
setcookie("itemCount",$config['showItems'],time()+86400);
if($view=='newsletters'){
	if($args[0]=='unsubscribe'&&isset($args[1])){
		$s=$db->prepare("DELETE FROM `".$prefix."subscribers` WHERE `hash`=:hash");
		$s->execute([':hash'=>$args[1]]);
		$notification=preg_replace([
			'/<print alert>/',
			'/<print text>/'
		],[
			'success',
			'You are now Unsubscribed from our Newletters'
		],$theme['settings']['alert']);
	}
}
if(isset($_POST['act'])=='sort')$sort=isset($_POST['sort'])?filter_input(INPUT_POST,'sort',FILTER_SANITIZE_STRING):'';
else$sort=$config['defaultOrder']!=''?$config['defaultOrder']:'';
$sortOrder=" ORDER BY ";
if($sort=="")$sortOrder.="`ti` DESC ";
if($sort=="new")$sortOrder.="`ti` DESC ";
if($sort=="old")$sortOrder.="`ti` ASC ";
if($sort=="namea")$sortOrder.="`title` ASC ";
if($sort=="namez")$sortOrder.="`title` DESC ";
if($sort=="best")$sortOrder.="`sold` DESC ";
if($sort=="view")$sortOrder.="`views` DESC ";
if($sort=="priceh")$sortOrder.="`cost` DESC ";
if($sort=="pricel")$sortOrder.="`cost` ASC ";
if($view=='page')$show='';
elseif($view=='search'){
	if(isset($args[0])&&$args[0]!='')$search='%'.html_entity_decode(str_replace('-','%',$args[0])).'%';
	elseif(isset($_POST['search'])&&$_POST['search']!='')$search='%'.html_entity_decode(str_replace('-','%',filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING))).'%';
	else$search='%';
	if($config['showItems']>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE LOWER(`code`) LIKE LOWER(:search) OR LOWER(`brand`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`category_1`) LIKE LOWER(:search) OR LOWER(`category_2`) LIKE LOWER(:search) OR LOWER(`category_3`) LIKE LOWER(:search) OR LOWER(`category_4`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`tags`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) AND `status`=:status AND `rank` <= :rank");
		$s->execute([
			':search'=>$search,
			':status'=>$status,
			':rank'=>$_SESSION['rank']
		]);
		$rowCount=$s->rowCount();
		$sqlLimit=" LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`code`) LIKE LOWER(:search) OR LOWER(`brand`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`category_1`) LIKE LOWER(:search) OR LOWER(`category_2`) LIKE LOWER(:search) OR LOWER(`category_3`) LIKE LOWER(:search) OR LOWER(`category_4`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`tags`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) AND `status`=:status AND `rank` <= :rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':search'=>$search,
		':status'=>$status,
		':rank'=>$_SESSION['rank']
	]);
}elseif($view=='index'){
	$contentType=$cat1='';
	if(stristr($html,'<settings')){
		preg_match('/<settings.*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
		$itemCount=isset($matches[1])&&$matches[1]!=0?$matches[1]:$config['showItems'];
		preg_match('/<settings.*contenttype=[\"\'](.*?)[\"\'].*>/',$html,$matches);
		$contentType=isset($matches[1])&&($matches[1]!='all')?$matches[1]:'%';
	}
	if(stristr($contentType,'|')){
		$ctarray=explode('|',$contentType);
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType1 OR `contentType` LIKE :contentType2 OR `contentType` LIkE :contentType3 OR `contentType` LIKE :contentType4 AND `contentType` NOT LIKE 'message%' AND `contentType` NOT LIKE 'testimonial%' AND `contentType` NOT LIKE 'proof%' AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank` <= :rank".($sortOrder==''?" ORDER BY `featured` DESC, `ti` DESC":$sortOrder)." LIMIT ".$itemCount);
		$s->execute([
			':contentType1'=>(isset($ctarray[0])?$ctarray[0]:''),
			':contentType2'=>(isset($ctarray[1])?$ctarray[1]:''),
			':contentType3'=>(isset($ctarray[2])?$ctarray[2]:''),
			':contentType4'=>(isset($ctarray[3])?$ctarray[3]:''),
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
	}else{
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `contentType` NOT LIKE 'message%' AND `contentType` NOT LIKE 'testimonial%' AND `contentType` NOT LIKE 'proof%' AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `featured` DESC, `ti` DESC":$sortOrder)." LIMIT ".$itemCount);
		$s->execute([
			':contentType'=>$contentType,
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
	}
}elseif(isset($args[0])&&$args[0]=='category'){
	if($config['showItems']>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank");
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-',' ',$args[1])),
			':category_2'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
			':category_3'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
			':category_4'=>isset($args[4])?html_entity_decode(str_replace('-',' ',$args[4])):'%',
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
		$rowCount=$s->rowCount();
		$sqlLimit=" LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-','%',$args[1])),
		':category_2'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
		':category_3'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
		':category_4'=>isset($args[4])?html_entity_decode(str_replace('-',' ',$args[4])):'%',
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[1])){
	if($config['showItems']>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank");
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
			':category_2'=>html_entity_decode(str_replace('-','%',$args[1])),
			':category_3'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
			':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
		$rowCount=$s->rowCount();
		$sqlLimit="LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-','%',$args[1])),
		':category_3'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
		':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[2])){
	if($config['showItems']>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank");
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
			':category_2'=>html_entity_decode(str_replace('-','%',$args[1])),
			':category_3'=>html_entity_decode(str_replace('-','%',$args[2])),
			':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
		$rowCount=$s->rowCount();
		$sqlLimit=" LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-','%',$args[1])),
		':category_3'=>html_entity_decode(str_replace('-','%',$args[2])),
		':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[3])){
	if($config['showItems']>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank");
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
			':category_2'=>html_entity_decode(str_replace('-','%',$args[1])),
			':category_3'=>html_entity_decode(str_replace('-','%',$args[2])),
			':category_4'=>html_entity_decode(str_replace('-','%',$args[3])),
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
		$rowCount=$s->rowCount();
		$sqlLimit=" LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder=''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-','%',$args[1])),
		':category_3'=>html_entity_decode(str_replace('-','%',$args[2])),
		':category_4'=>html_entity_decode(str_replace('-','%',$args[3])),
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[0])){
	if($config['showItems']>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank");
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
		$rowCount=$s->rowCount();
		$sqlLimit=" LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder=''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
	if($s->rowCount()<1){
		if($view=='proofs'){
			$status='%';
			if($_SESSION['loggedin']==false)die();
		}
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`urlSlug`) LIKE LOWER(:urlSlug) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
		$s->execute([
			':contentType'=>$view,
			':urlSlug'=>$args[0],
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
		$show='item';
	}
}else{
	if($view=='proofs'){
		if(isset($_SESSION['uid'])&&$_SESSION['uid']!=0){
			if($config['showItems']>0){
				$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE 'proofs' AND `uid`=:uid AND `rank`<=:rank ORDER BY `ord` ASC, `ti` DESC");
				$s->execute([
					':uid'=>$_SESSION['uid'],
					':rank'=>$_SESSION['rank']
				]);
				$rowCount=$s->rowCount();
				$sqlLimit=" LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
			}
			$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE 'proofs' AND `uid`=:uid AND `rank`<=:rank ORDER BY `ord` ASC, `ti` DESC".($sqlLimit!=''?$sqlLimit:''));
			$s->execute([
				':uid'=>$_SESSION['uid'],
				':rank'=>$_SESSION['rank']
			]);
		}
	}else{
		if($config['showItems']>0){
			$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder=''?" ORDER BY `ti` DESC":$sortOrder));
			$s->execute([
				':contentType'=>$view,
				':status'=>$status,
				':ti'=>time(),
				':rank'=>$_SESSION['rank']
			]);
			$rowCount=$s->rowCount();
			$sqlLimit=" LIMIT ".$itemPage * $config['showItems'].", ".$config['showItems'];
		}
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder=''?" ORDER BY `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
		$s->execute([
			':contentType'=>$view,
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
	}
}
if($view=='testimonials')$show='';
if($show=='categories')require'core/parser_items.php';
if($show=='item'){
	require'core/parser_item.php';
	$args[0]=$r['category_1'];
	$args[1]=$r['category_2'];
	$args[2]=$r['category_3'];
	$args[3]=$r['category_4'];
}
if($config['options'][31]==1&&stristr($html,'<category-nav>')){
	$cat1=isset($args[0])&&$args[0]!=''?$args[0]:'';
	$cat2=isset($args[1])&&$args[1]!=''?$args[1]:'';
	$cat3=isset($args[2])&&$args[2]!=''?$args[2]:'';
	$cat4=isset($args[3])&&$args[3]!=''?$args[3]:'';
	$sc1=$db->prepare("SELECT DISTINCT(`category_1`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND `category_1`!='' GROUP BY `category_1` ORDER BY `category_1` ASC");
	$sc1->execute([':contentType'=>$view]);
	$catlist='';
	if($sc1->rowCount()>0){
		while($rc1=$sc1->fetch(PDO::FETCH_ASSOC)){
			$sc2=$db->prepare("SELECT DISTINCT(`category_2`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND LOWER(`category_1`) LIKE LOWER(:category1) AND `category_2`!='' GROUP BY `category_2` ORDER BY `category_2` ASC");
			$sc2->execute([
				':contentType'=>$view,
				':category1'=>$rc1['category_1']
			]);
			$catlist.='<li'.($cat1==$rc1['category_1']?' class="open"':'').'>'.($sc2->rowCount()>0?'<a class="opener" role="button" tabindex="0">&nbsp;</a>':'').'<a href="'.URL.$view.'/'.str_replace(' ','-',$rc1['category_1']).'">'.ucfirst($rc1['category_1']).'</a>';
			while($rc2=$sc2->fetch(PDO::FETCH_ASSOC)){
				$sc3=$db->prepare("SELECT DISTINCT(`category_3`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND LOWER(`category_1`) LIKE LOWER(:category1) AND LOWER(`category_2`) LIKE LOWER(:category2) AND `category_3`!='' GROUP BY `category_3` ORDER BY `category_3` ASC");
				$sc3->execute([
					':contentType'=>$view,
					':category1'=>$rc1['category_1'],
					':category2'=>$rc2['category_2']
				]);
				$catlist.='<ul><li'.($cat2==$rc2['category_2']?' class="open"':'').'>'.($sc3->rowCount()>0?'<a class="opener" role="button" tabindex="0">&nbsp;</a>':'').'<a href="'.URL.$view.'/'.str_replace(' ','-',$rc1['category_1'].'/'.$rc2['category_2']).'">'.ucfirst($rc2['category_2']).'</a>'."\r\n";
				while($rc3=$sc3->fetch(PDO::FETCH_ASSOC)){
					$sc4=$db->prepare("SELECT DISTINCT(`category_4`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND LOWER(`category_1`) LIKE LOWER(:category1) AND LOWER(`category_2`) LIKE LOWER(:category2) AND LOWER(`category_3`) LIKE LOWER(:category3) AND `category_4`!='' GROUP BY `category_4` ORDER BY `category_4` ASC");
					$sc4->execute([
						':contentType'=>$view,
						':category1'=>$rc1['category_1'],
						':category2'=>$rc2['category_2'],
						':category3'=>$rc3['category_3']
					]);
					$catlist.='<ul><li'.($cat3==$rc3['category_3']?' class="open"':'').'>'.($sc4->rowCount()!=0?'<a class="opener" role="button" tabindex="0">&nbsp;</a>':'').'<a href="'.URL.$view.'/'.str_replace(' ','-',$rc1['category_1'].'/'.$rc2['category_2'].'/'.$rc3['category_3']).'">'.ucfirst($rc3['category_3']).'</a>';
					while($rc4=$sc4->fetch(PDO::FETCH_ASSOC)){
						$catlist.='<ul><li><a href="'.URL.$view.'/'.str_replace(' ','-',$rc1['category_1'].'/'.$rc2['category_2'].'/'.$rc3['category_3'].'/'.$rc4['category_4']).'">'.ucfirst($rc4['category_4']).'</a></li></ul>';
					}
					$catlist.='</li></ul>'."\r\n";
				}
				$catlist.='</li></ul>'."\r\n";
			}
				$catlist.='</li>'."\r\n";
		}
		$html=preg_replace([
			'/<\/?category-nav>/',
			'/<catlist>/'
		],[
			'',
			$catlist
		],$html);
	}else$html=preg_replace('~<category-nav>.*?<\/category-nav>~is','',$html);
}else$html=preg_replace('~<category-nav>.*?<\/category-nav>~is','',$html);
if($view=='login'){
	if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
		$html=preg_replace([
			'/<\/?loggedin?>/',
			'~<loggedout>.*?<\/loggedout>~is'
		],'',$html);
	}else{
		$html=preg_replace([
			'/<\/?loggedout?>/',
			'~<loggedin>.*?<\/loggedin>~is'
		],'',$html);
	}
	$html=preg_replace([
		'/<print url>/',
		$config['options'][3]==1?'/<\/?signup?>/':'~<signup>.*?<\/signup>~is',
		'/<g-recaptcha>/'
	],[
		URL,
		'',
		$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':''
	],$html);
}
$content.=$html;
