<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Content
 * @package    core/view/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Add Parsing of Google reCaptcha.
 * @changes    v0.1.2 Check over and tidy up code.
 */
$rank=0;
$notification='';
$show='categories';
$status='published';
$itemCount=$config['showItems'];
if($view=='newsletters'){
	if($args[0]=='unsubscribe'&&isset($args[1])){
		$s=$db->prepare("DELETE FROM `".$prefix."subscribers` WHERE `hash`=:hash");
		$s->execute([':hash'=>$args[1]]);
		$notification=preg_replace(['/<print alert>/','/<print text>/'],['success','You are now Unsubscribed from our Newletters'],$theme['settings']['alert']);
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
}elseif($view=='bookings')$id=(isset($args[0])?(int)$args[0]:0);
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
			if($_SESSION['loggedin']==false)die();
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
if($view=='testimonials')$show='';
if($show=='categories')require'core/parser_items.php';
if($show=='item')require'core/parser_item.php';
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
