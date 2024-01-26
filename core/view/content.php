<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Content
 * @package    core/view/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$show='categories';
$status='published';
$rowCount=0;
$sqlLimit='';
$sqlrank='';
if(isset($_SESSION['rank'])){
	if(!$_SESSION['rank'] > 350 AND $_SESSION['rank'] > 309 || $_SESSION['rank'] < 351)
		$sqlrank=" AND `rank` > 309 AND `rank` < 351";
	else
		$sqlrank=" AND `rank` <= ".$_SESSION['rank'];
}
$itemPage=isset($_GET['page'])?$_GET['page']:0;
$config['showItems']=isset($_POST['itemCount'])&&$view!='index'?$_POST['itemCount']:$config['showItems'];
$config['showItems']=isset($_COOKIE['itemCount'])&&$view!='index'?$_COOKIE['itemCount']:$config['showItems'];
setcookie("itemCount",$config['showItems'],time()+86400);
if(stristr($html,'<settings')){
	preg_match('/<settings.*itemCount=[\"\'](.+?)[\"\'].*>/',$html,$match);
	$itemCount=(int)(isset($match[1])?
		($match[1]>0||$match[1]!='all'?$match[1]:$config['showItems'])
	:$config['showItems']);
	preg_match('/<settings.*contentType=[\"\'](.*?)[\"\'].*>/',$html,$match);
	$contentType=isset($match[1])&&($match[1]!='all')?$match[1]:'%';
}else{
	$itemCount=$config['showItems'];
	$contentType='%';
}
if($view=='newsletters'){
	if(isset($args[0])&&$args[0]=='unsubscribe'&&isset($args[1])){
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
if(isset($_POST['act'])=='sort')
	$sort=isset($_POST['sort'])?filter_input(INPUT_POST,'sort',FILTER_UNSAFE_RAW):'';
else
	$sort=$config['defaultOrder']!=''?$config['defaultOrder']:'';
$sortOrder=" ORDER BY ".($view=='events'||$view=='index'?"`tis` ASC, ":"`pin` DESC, ");
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
	if(isset($args[0])&&$args[0]!='')
		$search='%'.html_entity_decode(str_replace('-','%',$args[0])).'%';
	elseif(isset($_POST['search'])&&$_POST['search']!='')
		$search='%'.html_entity_decode(str_replace('-','%',filter_input(INPUT_POST,'search',FILTER_UNSAFE_RAW))).'%';
	else
		$search='%';
	$search=str_replace(' ','%',$search);
	$search=str_replace(',','%',$search);
	$config['searchItems']=isset($config['searchItems'])&&$config['searchItems']>0?$config['searchItems']:10;
	$itemCount=$config['searchItems'];
	$from=$itemPage==0?0:($itemPage - 1) * $itemCount;
	$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE LOWER(`code`) LIKE LOWER(:search) OR LOWER(`brand`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`category_1`) LIKE LOWER(:search) OR LOWER(`category_2`) LIKE LOWER(:search) OR LOWER(`category_3`) LIKE LOWER(:search) OR LOWER(`category_4`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`tags`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) AND `status`=:status".$sqlrank);
	$s->execute([
		':search'=>$search,
		':status'=>$status
	]);
	$rowCount=$s->rowCount();
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`code`) LIKE LOWER(:search) OR LOWER(`brand`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`category_1`) LIKE LOWER(:search) OR LOWER(`category_2`) LIKE LOWER(:search) OR LOWER(`category_3`) LIKE LOWER(:search) OR LOWER(`category_4`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`tags`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) AND `status`=:status".$sqlrank.($sortOrder==''?" ORDER BY `pin` DESC, `views` DESC, `ti` DESC":$sortOrder).$sqlLimit.($itemCount>0?" LIMIT ".$from.", ".$itemCount:""));
	$s->execute([
		':search'=>$search,
		':status'=>$status
	]);
}elseif($view=='index'){
	$contentType=$cat1='';
	if(stristr($html,'<settings')){
		preg_match('/<settings.*contentType=[\"\'](.*?)[\"\'].*>/',$html,$match);
		$contentType=isset($match[1])&&($match[1]!='all')?$match[1]:'%';
	}else{
		$contentType='%';
	}
	if(stristr($contentType,'|')){
		$ctarray=explode('|',$contentType);
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType1 OR `contentType` LIKE :contentType2 OR `contentType` LIkE :contentType3 OR `contentType` LIKE :contentType4 AND `contentType` NOT LIKE 'message%' AND `contentType` NOT LIKE 'testimonial%' AND `contentType` NOT LIKE 'proof%' AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank.($sortOrder==''?" ORDER BY `pin` DESC, `featured` DESC, `ti` DESC":$sortOrder).($itemCount>0?" LIMIT ".$itemCount:""));
		$s->execute([
			':contentType1'=>(isset($ctarray[0])?$ctarray[0]:'%'),
			':contentType2'=>(isset($ctarray[1])?$ctarray[1]:'%'),
			':contentType3'=>(isset($ctarray[2])?$ctarray[2]:'%'),
			':contentType4'=>(isset($ctarray[3])?$ctarray[3]:'%'),
			':status'=>$status,
			':ti'=>time()
		]);
	}else{
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `contentType` NOT LIKE 'message%' AND `contentType` NOT LIKE 'testimonial%' AND `contentType` NOT LIKE 'proof%' AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti ".$sqlrank.($sortOrder==''?" ORDER BY `pin` DESC, `featured` DESC, `ti` DESC":$sortOrder).($itemCount>0?" LIMIT ".$itemCount:""));
		$s->execute([
			':contentType'=>$contentType,
			':status'=>$status,
			':ti'=>time()
		]);
	}
}elseif(isset($args[0])&&$args[0]=='category'){
	if($itemCount>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank);
		$s->execute([
			':contentType'=>$view,
			':category_1'=>isset($args[1])?html_entity_decode(str_replace('-',' ',$args[1])):'%',
			':category_2'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
			':category_3'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
			':category_4'=>isset($args[4])?html_entity_decode(str_replace('-',' ',$args[4])):'%',
			':status'=>$status,
			':ti'=>time()
		]);
		$rowCount=$s->rowCount();
		$from=$itemPage==0?0:($itemPage -1) * $itemCount;
		$sqlLimit=" LIMIT ".$from.", ".$itemCount;
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank.($sortOrder==''?" ORDER BY `pin` DESC, `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>isset($args[1])?html_entity_decode(str_replace('-','%',$args[1])):'%',
		':category_2'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
		':category_3'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
		':category_4'=>isset($args[4])?html_entity_decode(str_replace('-',' ',$args[4])):'%',
		':status'=>$status,
		':ti'=>time()
	]);
}elseif(isset($args[1])){
	if($itemCount>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank);
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
			':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
			':category_3'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
			':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
			':status'=>$status,
			':ti'=>time()
		]);
		$rowCount=$s->rowCount();
		$from=$itemPage==0?0:($itemPage -1) * $itemCount;
		$sqlLimit=" LIMIT ".$from.", ".$itemCount;
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank.($sortOrder==''?" ORDER BY `pin` DESC, `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':category_3'=>isset($args[2])?html_entity_decode(str_replace('-',' ',$args[2])):'%',
		':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
		':status'=>$status,
		':ti'=>time()
	]);
}elseif(isset($args[2])){
	if($itemCount>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank);
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
			':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
			':category_3'=>html_entity_decode(str_replace('-',' ',$args[2])),
			':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
			':status'=>$status,
			':ti'=>time()
		]);
		$rowCount=$s->rowCount();
		$from=$itemPage==0?0:($itemPage -1) * $itemCount;
		$sqlLimit=" LIMIT ".$from.", ".$itemCount;
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank.($sortOrder==''?" ORDER BY `pin` DESC, `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':category_3'=>html_entity_decode(str_replace('-',' ',$args[2])),
		':category_4'=>isset($args[3])?html_entity_decode(str_replace('-',' ',$args[3])):'%',
		':status'=>$status,
		':ti'=>time()
	]);
}elseif(isset($args[3])){
	if($itemCount>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank);
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
			':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
			':category_3'=>html_entity_decode(str_replace('-',' ',$args[2])),
			':category_4'=>html_entity_decode(str_replace('-',' ',$args[3])),
			':status'=>$status,
			':ti'=>time()
		]);
		$rowCount=$s->rowCount();
		$from=$itemPage==0?0:($itemPage -1) * $itemCount;
		$sqlLimit=" LIMIT ".$from.", ".$itemCount;
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank.($sortOrder=''?" ORDER BY `pin` DESC, `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
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
	if($itemCount>0){
		$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank);
		$s->execute([
			':contentType'=>$view,
			':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
			':status'=>$status,
			':ti'=>time()
		]);
		$rowCount=$s->rowCount();
		$from=$itemPage==0?0:($itemPage -1) * $itemCount;
		$sqlLimit=" LIMIT ".$from.", ".$itemCount;
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`category_1`) LIKE LOWER(:category_1) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank.($sortOrder=''?" ORDER BY `pin` DESC, `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-','%',$args[0])),
		':status'=>$status,
		':ti'=>time()
	]);
	if($s->rowCount()<1){
		if($view=='proofs'){
			$status='%';
			if($_SESSION['loggedin']==false)die();
		}
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND LOWER(`urlSlug`) LIKE LOWER(:urlSlug) AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".($sortOrder==''?" ORDER BY `pin` DESC, `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
		$s->execute([
			':contentType'=>$view,
			':urlSlug'=>$args[0],
			':status'=>$status,
			':ti'=>time()
		]);
		if($s->rowCount()<1)header("Location: ".URL."error");
		$show='item';
	}
}else{
	if($view=='proofs'){
		if(isset($_SESSION['uid'])&&$_SESSION['uid']!=0){
			if($itemCount>0){
				$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE 'proofs' AND `uid`=:uid".$sqlrank." ORDER BY `pin` DESC, `ord` ASC, `ti` DESC");
				$s->execute([':uid'=>$_SESSION['uid']]);
				$rowCount=$s->rowCount();
				$from=$itemPage==0?0:($itemPage -1) * $itemCount;
				$sqlLimit=" LIMIT ".$from.", ".$itemCount;
			}
			$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE 'proofs' AND `uid`=:uid".$sqlrank." ORDER BY `pin` DESC, `ord` ASC, `ti` DESC".($sqlLimit!=''?$sqlLimit:''));
			$s->execute([':uid'=>$_SESSION['uid']]);
		}
	}else{
		if($itemCount>0){
			$s=$db->prepare("SELECT `id` FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `status` LIKE :status AND `internal`!='1' AND `pti` < :ti".$sqlrank);
			$s->execute([
				':contentType'=>$view,
				':status'=>$status,
				':ti'=>time()
			]);
			$rowCount=$s->rowCount();
			$from=$itemPage==0?0:($itemPage -1) * $itemCount;
			$sqlLimit=" LIMIT ".$from.", ".$itemCount;
		}
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti".$sqlrank.($sortOrder=''?" ORDER BY `pin` DESC, `ti` DESC":$sortOrder).($sqlLimit!=''?$sqlLimit:''));
		$s->execute([
			':contentType'=>$view,
			':status'=>$status,
			':ti'=>time()
		]);
	}
}
if($view=='testimonials')$show='';
if($show=='categories')require'core/parser_items.php';
if($show=='item'){
	require'core/parser_item.php';
	$args[0]=str_replace(' ','-',strtolower($r['category_1']));
	$args[1]=str_replace(' ','-',strtolower($r['category_2']));
	$args[2]=str_replace(' ','-',strtolower($r['category_3']));
	$args[3]=str_replace(' ','-',strtolower($r['category_4']));
}
require'inc-categorynav.php';
if(stristr($html,'<playlist')){
	$sp=$db->prepare("SELECT * FROM `".$prefix."playlist` WHERE `rid`=:rid ORDER BY ord ASC LIMIT 0,6");
	$sp->execute([
		':rid'=>$page['id']
	]);
	$playlistoutput='';
	if($sp->rowCount()>0){
		preg_match('/<playlistitem>([\w\W]*?)<\/playlistitem>/',$html,$match);
		$pli=$match[1];
		$playlistoutput='';
		while($pr=$sp->fetch(PDO::FETCH_ASSOC)){
			$bpli='';
			$bpli=preg_replace([
				'/<json-ld>/',
				'/<print playlist=[\"\']?title[\"\']?>/',
				'/<print playlist=[\"\']?thumbnail_url[\"\']?>/',
				'/<print playlist=[\"\']?url[\"\']?>/',
				'/<print playlist=[\"\']?embedurl[\"\']?>/',
				'/<print playlist=[\"\']?notes[\"\']?>/'
			],[
				'<script type="application/ld+json">{'.
					'"@content":"https://schema.org",'.
					'"@type":"VideoObject",'.
					'"name":"'.$pr['title'].'",'.
					'"description":"'.($pr['notes']!=''?strip_tags($pr['notes']):$pr['title']).'",'.
					'"thumbnailUrl":['.
						'"'.$pr['thumbnail_url'].'"'.
					']'.
					'"uploadDate":"'.$pr['dt'].'"'.
				'}</script>',
				$pr['title'],
				$pr['thumbnail_url']!=''?$pr['thumbnail_url']:NOIMAGE,
				$pr['url'],
				$pr['embed_url'],
				$pr['notes']
			],$pli);
			$playlistoutput.=$bpli;
		}
		$html=preg_replace([
			'/<[\/]?playlist>/',
			'~<playlistitem>.*?<\/playlistitem>~is'
		],[
			'',
			$playlistoutput
		],$html);
	}else{
		$html=preg_replace('~<playlist>.*?<\/playlist>~is','',$html);
	}
}
if(stristr($html,'<eventsitems')){
	preg_match('/<eventsitems.*?itemCount=[\"\'](.+?)[\"\'].*>/',$html,$match);
	$limit=isset($match[1])&&$match[1]==0?4:$match[1];
	preg_match('/<eventitem>([\w\W]*?)<\/eventitem>/',$html,$match);
	$eventitem=$match[1];
	$eventoutput='';
	$se=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :ct1 AND `status` LIKE :status AND `rank`<:rank OR `contentType` LIKE :ct2 AND `status` LIKE :status AND `rank`<:rank ORDER BY `tis` ASC LIMIT $limit");
	$se->execute([
		':ct1'=>'events',
		':ct2'=>'news',
		':status'=>'published',
		':rank'=>(isset($_SESSION['rank'])?$_SESSION['rank'] + 1:0)
	]);
	if($se->rowCount()>0){
		$eventcnt=0;
		while($re=$se->fetch(PDO::FETCH_ASSOC)){
			if($re['tis']>0&&$re['tis'] < time()){
				$eventcnt++;
				continue;
			}
			$eventitems=$eventitem;
			$re['file']=rawurldecode($re['file']);
			$eventitems=preg_replace([
				'/<print event=[\"\']?srcset[\"\']?>/',
				'/<print event=[\"\']?thumb[\"\']?>/',
				'/<print event=[\"\']?imageALT[\"\']?>/',
				'/<print event=[\"\']?contentType[\"\']?>/',
				'/<print event=[\"\']?linktitle[\"\']?>/',
				'/<print event=[\"\']?title[\"\']?>/',
				'/<print date=[\"\']?day[\"\']?>/',
				'/<print date=[\"\']?month[\"\']?>/',
				'/<print date=[\"\']?year[\"\']?>/'
			],[
				'srcset="'.
					($re['thumb']!=''&&file_exists('media/sm/'.basename($re['thumb']))?'media/sm/'.basename($re['thumb']).' '.$config['mediaMaxWidthThumb'].'w,':NOIMAGESM.' '.$config['mediaMaxWidthThumb'].'w,').
					($re['thumb']!=''&&file_exists('media/md/'.basename($re['thumb']))?'media/md/'.basename($re['thumb']).' 600w,':NOIMAGE.' 600w,').
					($re['thumb']!=''&&file_exists('media/sm/'.basename($re['thumb']))?'media/sm/'.basename($re['thumb']).' 400w':NOIMAGESM.' 400w').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" ',
				$re['thumb']!=''?$re['thumb']:NOIMAGESM,
				htmlspecialchars(($re['fileALT']!=''?$re['fileALT']:$re['title']),ENT_QUOTES,'UTF-8'),
				$re['contentType'],
				URL.$re['contentType'].'/'.$re['urlSlug'].'/',
				$re['title'],
				date('jS',($re['tis']==0?$re['ti']:$re['tis'])),
				date('F',($re['tis']==0?$re['ti']:$re['tis'])),
				date('Y',($re['tis']==0?$re['ti']:$re['tis']))
			],$eventitems);
			$eventoutput.=$eventitems;
		}
		$html=preg_replace([
			'~<eventitem>.*?<\/eventitem>~is',
			($eventcnt>0?'~<eventsitems.*?>.*?<\/eventsitems>~is':'/<[\/]?eventsitems.*?>/')
		],[
			$eventoutput.' '.$eventcnt,
			''
		],$html);
	}else
		$html=preg_replace('~<eventsitems.*?>.*?<\/eventsitems>~is','',$html,1);
}
if($view=='login'){
	$html=preg_replace([
		isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true?'/<\/?loggedin?>/':'/<\/?loggedout?>/',
		isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true?'~<loggedout>.*?<\/loggedout>~is':'~<loggedin>.*?<\/loggedin>~is',
		'/<print url>/',
		$config['options'][3]==1?'/<\/?signup?>/':'~<signup>.*?<\/signup>~is',
		'/<g-recaptcha>/'
	],[
		'',
		'',
		URL,
		'',
		$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':''
	],$html);
}
if(stristr($html,'<g-recaptcha>')){
	$html=preg_replace('/<g-recaptcha>/',($config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':''),$html);
}
$content.=$html;
