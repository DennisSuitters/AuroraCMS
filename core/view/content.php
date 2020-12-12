<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Content
 * @package    core/view/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$show='categories';
$status='published';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$itemCount=$config['showItems'];
if($view=='newsletters'){
	if($args[0]=='unsubscribe'&&isset($args[1])){
		$s=$db->prepare("DELETE FROM `".$prefix."subscribers` WHERE `hash`=:hash");
		$s->execute([
			':hash'=>$args[1]
		]);
		$notification=$theme['settings']['notification_unsubscribe'];
	}
}
if(isset($_POST['act'])=='sort')
	$sort=isset($_POST['sort'])?filter_input(INPUT_POST,'sort',FILTER_SANITIZE_STRING):'';
else
	$sort=$config['defaultOrder']!=''?$config['defaultOrder']:'';

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
if($view=='page')
	$show='';
elseif($view=='search'){
	if(isset($args[0])&&$args[0]!='')
		$search='%'.html_entity_decode(str_replace('-','%',$args[0])).'%';
	elseif(isset($_POST['search'])&&$_POST['search']!='')
		$search='%'.html_entity_decode(str_replace('-','%',filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING))).'%';
	else
		$search='%';
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`code`) LIKE LOWER(:search) OR LOWER(`brand`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`category_1`) LIKE LOWER(:search) OR LOWER(`category_2`) LIKE LOWER(:search) OR LOWER(`category_3`) LIKE LOWER(:search) OR LOWER(`category_4`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`tags`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) AND `status`=:status AND `rank` <= :rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder));
	$s->execute([
		':search'=>$search,
		':status'=>$status,
		':rank'=>$_SESSION['rank']
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
	if(stristr($contentType,'|')){
		$ctarray=explode('|',$contentType);
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType1 OR `contentType` LIKE :contentType2 OR `contentType` LIkE :contentType3 OR `contentType` LIKE :contentType4 AND `contentType` NOT LIKE 'message%' AND `contentType` NOT LIKE 'testimonial%' AND `contentType` NOT LIKE 'proof%' AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `featured` DESC, `ti` DESC":$sortOrder)." LIMIT $itemCount");
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
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `contentType` NOT LIKE 'message%' AND `contentType` NOT LIKE 'testimonial%' AND `contentType` NOT LIKE 'proof%' AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `featured` DESC, `ti` DESC":$sortOrder)." LIMIT $itemCount");
		$s->execute([
			':contentType'=>$contentType,
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
	}
}elseif($view=='bookings')
	$id=(isset($args[0])?(int)$args[0]:0);
elseif(isset($args[1])&&strlen($args[1])==2){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `ti`<:ti AND `rank`<=:rank ORDER BY `ti` ASC");
	$s->execute([
		':contentType'=>$view,
		':ti'=>DateTime::createFromFormat('!d/m/Y','01/'.$args[1].'/'.$args[0])->getTimestamp(),
		':rank'=>$_SESSION['rank']
	]);
	$show='categories';
}elseif(isset($args[0])&&strlen($args[0])==4&&is_numeric($args[0])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `ti`>:ti AND `rank`<=:rank ORDER BY `ti` ASC");
	$tim=strtotime('01-Jan-'.$args[0]);
	$s->execute([
		':contentType'=>$view,
		':ti'=>DateTime::createFromFormat('!d/m/Y','01/01/'.$args[0])->getTimestamp(),
		':rank'=>$_SESSION['rank']
	]);
	$show='categories';
}elseif(isset($args[0])&&$args[0]=='category'){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[1])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[2])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':category_3'=>html_entity_decode(str_replace('-',' ',$args[2])),
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[3])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder=''?" ORDER BY `ti` DESC":$sortOrder));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':category_3'=>html_entity_decode(str_replace('-',' ',$args[2])),
		':category_4'=>html_entity_decode(str_replace('-',' ',$args[3])),
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
}elseif(isset($args[0])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder=''?" ORDER BY `ti` DESC":$sortOrder));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':status'=>$status,
		':ti'=>time(),
		':rank'=>$_SESSION['rank']
	]);
	if($s->rowCount()<1){
		if($view=='proofs'){
			$status='%';
			if($_SESSION['loggedin']==false)
				die();
		}
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`urlSlug`) LIKE LOWER(:urlSlug) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder==''?" ORDER BY `ti` DESC":$sortOrder));
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
			$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE 'proofs' AND `uid`=:uid AND `rank`<=:rank ORDER BY `ord` ASC, `ti` DESC");
			$s->execute([
				':uid'=>$_SESSION['uid'],
				':rank'=>$_SESSION['rank']
			]);
		}
	}else{
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank".($sortOrder=''?" ORDER BY `ti` DESC":$sortOrder)." LIMIT $itemCount");
		$s->execute([
			':contentType'=>$view,
			':status'=>$status,
			':ti'=>time(),
			':rank'=>$_SESSION['rank']
		]);
	}
}
if($show=='categories'){
	require_once'core/parser_items.php';
}
if($view=='testimonials')
	$show='';
if($show=='item'){
	require_once'core/parser_item.php';
}
if($view=='login'){
	$html=preg_replace('/<print url>/',URL,$html,1);
	if($config['options'][3]==1)
		$html=preg_replace('/<\/?signup?>/','',$html);
	else
		$html=preg_replace('~<signup>.*?<\/signup>~is','',$html,1);
}
$content.=$html;
