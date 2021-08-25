<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - FAQ
 * @package    core/view/faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/pagination.php';
use auroraCMS\Paginator;
if(stristr($html,'<cover>')){
	$coverHTML='';
	$iscover=false;
	if($page['coverVideo']!=''){
		$cover=basename(rawurldecode($page['coverVideo']));
		if(stristr($page['coverVideo'],'youtu')){
			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$page['coverVideo'],$vidMatch);
			$coverHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$vidMatch[0].'?playsinline=1&fs=0&modestbranding=1&'.
				($page['options'][0]==1?'autoplay=1&mute=1&':'').
				($page['options'][1]==1?'loop=1&':'').
				($page['options'][2]==1?'controls=1&':'controls=0&').
			'" frameborder="0" allow="accelerometer;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe></div>';
 	}elseif(stristr($page['coverVideo'],'vimeo')){
			preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$page['coverVideo'],$vidMatch);
			$coverHTML='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$vidMatch[5].'?'.
				($page['options'][0]==1?'autoplay=1&':'').
				($page['options'][1]==1?'loop=1&':'').
				($page['options'][2]==1?'controls=1&':'controls=0&').
			'" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
		}else
			$coverHTML='<div class="embed-responsive embed-responsive-16by9"><video class="embed-responsive-item" preload autoplay loop muted><source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video></div>';
	}
	if($page['cover']!=''&&$coverHTML==''){
		$cover=basename($page['cover']);
		if(file_exists('media/'.$cover)){
			$coverHTML='<img srcset="'.
			(file_exists('media/'.$cover)?'<img srcset="'.
				(file_exists('media/'.basename($cover))?'media/'.'lg/'.$cover.' '.$config['mediaMaxWidth'].'w,':'').
				(file_exists('media/'.'lg/'.basename($cover))?'media/'.'lg/'.$cover.' 1000w,':'').
				(file_exists('media/'.'md/'.basename($cover))?'media/'.'md/'.$cover.' 600w,':'').
				(file_exists('media/'.'sm/'.basename($cover))?'media/'.'sm/'.$cover.' 400w,':'').
				(file_exists('media/'.'thumbs/'.basename($cover))?'media/'.'thumbs/'.$cover.' '.$config['mediaMaxWidthThumb'].'w':'').
			'" src="media/'.$cover.'" loading="lazy" alt="'.$page['title'].' Cover Image">'.
				($page['attributionImageTitle']!=''?
					'<figcaption>'.
						$page['attributionImageTitle'].
						($page['attributionImageName']!=''?
							' by '.
								($page['attributionImageURL']!=''?'<a target="_blank" href="'.$page['attributionImageURL'].'">':'').
								$page['attributionImageName'].
								($page['attributionImageURL']!=''?'</a>':'')
						:'').
					'</figcaption>'
				:'')
			:'');
			$iscover=true;
		}
	}
	$html=preg_replace([
		$coverHTML==''?'~<cover>.*?</cover>~is':'/<[\/]?cover>/',
		'/<print page=[\"\']?coverItem[\"\']?>/'
	],[
		'',
		$coverHTML
	],$html);
}
if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsoni=1;
  $jsonld='<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"'.URL.'","name":"Home"}},';
  $breadit=preg_replace([
   '/<print breadcrumb=[\"\']?url[\"\']?>/',
   '/<print breadcrumb=[\"\']?title[\"\']?>/'
  ],[
   URL,
   'Home'
  ],$breaditem);
  $breaditems=$breadit;
  $jsoni++;
  $breadit=preg_replace('/<print breadcrumb=[\"\']?title[\"\']?>/',htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8'),$breadcurrent);
  $jsonld.='{"@type":"ListItem","position":'.$jsoni.',"item":{"@id":"'.
    URL.urlencode($page['contentType']).'/","name":"'.
    htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8').'"}}]}</script>';
  $breaditems.=$breadit;
  $html=preg_replace([
    '/<[\/]?breadcrumb>/',
    '/<json-ld-breadcrumb>/',
    '~<breaditems>.*?<\/breaditems>~is',
    '~<breadcurrent>.*?<\/breadcurrent>~is'
  ],[
    '',
    $jsonld,
    $breaditems,
    ''
  ],$html);
}
$html=preg_replace([
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<print page=[\"\']?notes[\"\']?>/',
],[
  '',
	rawurldecode($page['notes']),
],$html);
$forum='';
$cid=isset($_GET['cid'])?filter_input(INPUT_GET,'cid',FILTER_SANITIZE_NUMBER_INT):0;
$tid=isset($_GET['tid'])?filter_input(INPUT_GET,'tid',FILTER_SANITIZE_NUMBER_INT):0;
$pid=isset($_GET['pid'])?filter_input(INPUT_GET,'pid',FILTER_SANITIZE_NUMBER_INT):0;
$act=isset($_GET['act'])?filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
$p=isset($_GET['p'])?filter_input(INPUT_GET,'p',FILTER_SANITIZE_NUMBER_INT):1;
if($act=='search'){
	$st=isset($_POST['s'])?filter_input(INPUT_POST,'s',FILTER_SANITIZE_STRING):'';
	preg_match('/<searchitem>([\w\W]*?)<\/searchitem>/',$html,$matches);
	$item=$matches[1];
	$searchitems='';
	$q=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE LOWER(`notes`) LIKE LOWER(:st) OR LOWER(`title`) LIKE (:st) AND `rank`<=:rank");
	$q->execute([
		':st'=>'%'.$st.'%',
		':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
	]);
	if($st==''){
		$searchitems='<div class="alert alert-info mt-3" role="alert">A Search Term was not entered.</div>';
	}else{
		if($q->rowCount()>0){
			while($rs=$q->fetch(PDO::FETCH_ASSOC)){
				$items=$item;
				if($rs['pid']!=0){
					$ss=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `id`=:id");
					$ss->execute([':id'=>$rs['pid']]);
					$rss=$ss->fetch(PDO::FETCH_ASSOC);
				}
				if((isset($rs['notes'])&&$rs['notes']=='')||(isset($rss['notes'])&&$rss['notes']==''))continue;
				$searchlink=URL.'forum/?cid='.
					(isset($rss['cid'])?$rss['cid']:$rs['cid']).'&tid='.
					(isset($rss['tid'])?$rss['tid']:$rs['tid']).'&pid='.
					(isset($rss['id'])?$rss['id']:$rs['pid']);
				$searchnotes=snippet($st,$rs['notes']);
				$searchtitle=$rs['title']==''?$rss['title']:$rs['title'];
				$items=preg_replace([
					'/<print search=[\"\']?link[\"\']?>/',
					'/<print search=[\"\']?title[\"\']?>/',
					'/<print search=[\"\']?notes[\"\']?>/'
				],[
					$searchlink,
					$searchtitle,
					$searchnotes
				],$items);
				$searchitems.=$items;
			}
		}else{
			$searchitems='<div class="alert alert-info mt-3" role="alert">No results found for the Search Tem that was entered.</div>';
		}
	}
	$html=preg_replace([
		'/<[\/]?search>/',
		'~<searchitem>.*?<\/searchitem>~is',
		'~<categories>.*?<\/categories>~is',
		'~<topic>.*?<\/topic>~is',
		'~<posts>.*?<\/posts>~is',
		'~<postpage>.*?<\/postpage>~is',
		'~<newpost>.*?<\/newpost>~is',
		'/<print forum=[\"\']?link[\"\']?>/',
		'/<print search=[\"\']?search[\"\']?>/'
	],[
		'',
		$searchitems,
		'',
		'',
		'',
		'',
		'',
		URL.'forum',
		$st
	],$html);
}
if($pid==0&&$tid==0&&$cid==0&&$act==''){ // Category
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `rank`<=:rank ORDER BY `pin` DESC, `ord` ASC");
	$sc->execute([':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0]);
	preg_match('/<categoryheader>([\w\W]*?)<\/categoryheader>/',$html,$matches);
	$categories=$matches[1];
	preg_match('/<category>([\w\W]*?)<\/category>/',$html,$matches);
	$item=$matches[1];
	while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
		$tops=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `cid`=:cid");
		$tops->execute([':cid'=>$rc['id']]);
		$psts=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid");
		$psts->execute([':cid'=>$rc['id']]);
		$lst=$db->prepare("SELECT `id`,`title`,`tid`,`uid`,`ti` FROM `".$prefix."forumPosts` WHERE `cid`=:cid");
		$lst->execute(['cid'=>$rc['id']]);
		$lstget=$lst->fetch(PDO::FETCH_ASSOC);
		$lstu=$db->prepare("SELECT `username`,`name` FROM `".$prefix."login` WHERE `id`=:uid");
		$lstu->execute([':uid'=>isset($lstget['uid'])?$lstget['uid']:0]);
		$lastuser=$lstu->fetch(PDO::FETCH_ASSOC);
		$items=$item;
		$items=preg_replace([
			'/<print category=[\"\']?icon[\"\']?>/',
			'/<print category=[\"\']?pinned[\"\']?>/',
			'/<print category=[\"\']?link[\"\']?>/',
			'/<print category=[\"\']?title[\"\']?>/',
			'/<print category=[\"\']?notes[\"\']?>/',
			'/<print topics=[\"\']?count[\"\']?>/',
			'/<print posts=[\"\']?count[\"\']?>/',
			'/<print post=[\"\']?last[\"\']?>/'
		],[
			svg2('forum-category','i-3x i-color-muted'),
			$rc['pin']==1?svg2('pin','i-color-success'):'',
			URL.'forum?cid='.$rc['id'],
			$rc['title'],
			$rc['notes'],
			$tops->rowCount(),
			$psts->rowCount(),
			$lst->rowCount()>0?'<a href="'.URL.'forum?cid='.$rc['id'].'&tid='.$lstget['tid'].'&pid='.$lstget['id'].'">'.$lstget['title'].'</a> by '.($lastuser['name']==''?$lastuser['username']:$lastuser['name']).'<br>'.date($config['dateFormat'],$lstget['ti']):'No Posts Yet'
		],$items);
		$categories.=$items;
	}
	$html=preg_replace([
		'~<search>.*?<\/search>~is',
		'~<categories>.*?<\/categories>~is',
		'~<topic>.*?<\/topic>~is',
		'~<posts>.*?<\/posts>~is',
		'~<postpage>.*?<\/postpage>~is',
		'~<newpost>.*?<\/newpost>~is'
	],[
		'',
		$categories,
		'',
		'',
		''
	],$html);
}
if($pid==0&&$tid==0&&$cid>0&&$act==''){ // Topics
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `id`=:id");
	$sc->execute([':id'=>$cid]);
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	$st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `cid`=:cid AND `rank`<=:rank ORDER BY `pin` DESC, `ord` ASC");
	$st->execute([
		':cid'=>$cid,
		':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0]);
	preg_match('/<topics>([\w\W]*?)<\/topics>/',$html,$matches);
	$item=$matches[1];
	$topics='';
	while($rt=$st->fetch(PDO::FETCH_ASSOC)){
		$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `tid`=:tid AND `cid`=:cid");
		$sp->execute([':tid'=>$rt['id'],':cid'=>$cid]);
		$lst=$db->prepare("SELECT `id`,`title`,`tid`,`uid`,`ti` FROM `".$prefix."forumPosts` WHERE `tid`=:tid");
		$lst->execute(['tid'=>$rt['id']]);
		$lstget=$lst->fetch(PDO::FETCH_ASSOC);
		$lstu=$db->prepare("SELECT `username`,`name` FROM `".$prefix."login` WHERE `id`=:uid");
		$lstu->execute([':uid'=>isset($lstget['uid'])?$lstget['uid']:0]);
		$lastuser=$lstu->fetch(PDO::FETCH_ASSOC);
		$items=$item;
		$items=preg_replace([
			'/<print topic=[\"\']?icon[\"\']?>/',
			'/<print topic=[\"\']?link[\"\']?>/',
			'/<print topic=[\"\']?pinned[\"\']?>/',
			'/<print topic=[\"\']?title[\"\']?>/',
			'/<print topic=[\"\']?notes[\"\']?>/',
			'/<print posts=[\"\']?count[\"\']?>/',
			'/<print post=[\"\']?last[\"\']?>/',
		],[
			svg2('forum-category','i-3x i-color-muted'),
			URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'],
			$rt['pin']==1?svg2('pin','i-color-success'):'',
			$rt['title'],
			$rt['notes'],
			$sp->rowCount(),
			$lst->rowCount()>0?
				'<a href="'.URL.'forum?cid='.$rc['id'].'&tid='.$lstget['tid'].'&pid='.$lstget['id'].'">'.$lstget['title'].'</a>'.
				' by '.($lastuser['name']==''?$lastuser['username']:$lastuser['name']).'<br>'.
				date($config['dateFormat'],$lstget['ti']):'No Posts Yet',
		],$items);
		$topics.=$items;
	}
	$html=preg_replace([
		'~<search>.*?<\/search>~is',
		'~<categories>.*?<\/categories>~is',
		'/<[\/]?topic>/',
		'/<print forum=[\"\']?link[\"\']?>/',
		'/<print category=[\"\']?title[\"\']?>/',
		'/<print category=[\"\']?notes[\"\']?>/',
		'~<topics>.*?<\/topics>~is',
		'~<posts>.*?<\/posts>~is',
		'~<postpage>.*?<\/postpage>~is',
		'~<newpost>.*?<\/newpost>~is',
	],[
		'',
		'',
		'',
		URL.'forum/',
		$rc['title'],
		$rc['notes'],
		$topics,
		'',
		'',
		''
	],$html);
}
if($pid==0&&$tid!=0&&$act==''){ // Posts
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `id`=:id");
	$sc->execute([':id'=>$cid]);
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	$st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `id`=:id");
	$st->execute([':id'=>$tid]);
	$rt=$st->fetch(PDO::FETCH_ASSOC);
	$sl=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0");
	$sl->execute([':cid'=>$cid,':tid'=>$tid]);

	$totalItems = $sl->rowCount();
	$itemsPerPage=$config['showItems'];
	$currentPage=$p==0?1:$p;
	$urlPattern=URL.'forum?cid='.$cid.'&tid='.$tid.'&p=(:num)';

	$pagination=new Paginator($totalItems,$itemsPerPage,$currentPage,$urlPattern);
	$from=$p==0||$p==1?0:($p - 1) * $itemsPerPage;
	$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0 AND `rank`<=:rank ORDER BY `pin` DESC, `views` DESC, `ti` DESC LIMIT $from,$itemsPerPage");
	$sp->execute([
		':cid'=>$cid,
		':tid'=>$tid,
		':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
	]);
	preg_match('/<post>([\w\W]*?)<\/post>/',$html,$matches);
	$item=$matches[1];
	$posts='';
	while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
		$sa=$db->prepare("SELECT `id`,`username`,`name`,`avatar` FROM `".$prefix."login` WHERE `id`=:id");
		$sa->execute([':id'=>$rp['uid']]);
		$ra=$sa->fetch(PDO::FETCH_ASSOC);
		$sco=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `pid`=:pid");
		$sco->execute([':pid'=>$rp['id']]);
		$items=$item;
		preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i',$rp['notes'],$image);
		if(isset($image[1])&&$image[1]!=''){
			$avatar=$image[1];
		}else{
			$avatar=URL.'media/avatar/'.$ra['avatar'];
		}
		$items=preg_replace([
			'/<print post=[\"\']?id[\"\']?>/',
			'/<print post=[\"\']?icon[\"\']?>/',
			'/<print post=[\"\']?link[\"\']?>/',
			'/<print post=[\"\']?pinned[\"\']?>/',
			'/<print post=[\"\']?title[\"\']?>/',
			'/<print post=[\"\']?date[\"\']?>/',
			'/<print post=[\"\']?author[\"\']?>/',
			'/<print post=[\"\']?replies[\"\']?>/',
			'/<print post=[\"\']?views[\"\']?>/',
			'/<print post=[\"\']?last[\"\']?>/',
			isset($_SESSION['rank'])&&$_SESSION['rank']>599?'/<[\/]?toolbar>/':'~<toolbar>.*?<\/toolbar>~is',
			'/<print post=[\"\']?checked[\"\']?>/'
		],[
			$rp['id'],
			'<img class="forum-topic-avatar" src="'.$avatar.'">',
			URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'].'&pid='.$rp['id'],
			$rp['pin']==1?svg2('pin','i-color-success'):'',
			$rp['title'],
			date($config['dateFormat'],$rp['ti']),
			$ra['name']==''?$ra['username']:$ra['name'],
			$sco->rowCount(),
			$rp['views'],
			'No Posts',
			'',
			$rp['pin']==1?' checked':''
		],$items);
		$posts.=$items;
	}
	$html=preg_replace([
		'~<search>.*?<\/search>~is',
		'~<categories>.*?<\/categories>~is',
		'~<topic>.*?<\/topic>~is',
		'/<print forum=[\"\']?link[\"\']?>/',
		'/<print category=[\"\']?link[\"\']?>/',
		'/<print category=[\"\']?title[\"\']?>/',
		'/<print topic=[\"\']?title[\"\']?>/',
		'/<print newpostlink>/',
		'/<[\/]?posts>/',
		'/<pagination>/',
		'~<post>.*?<\/post>~is',
		'~<postpage>.*?<\/postpage>~is',
		'~<newpost>.*?<\/newpost>~is',
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?'/<[\/]?newpostbtn>/':'~<newpostbtn>.*?<\/newpostbtn>~is'
	],[
		'',
		'',
		'',
		URL.'forum/',
		URL.'forum?cid='.$rc['id'],
		$rc['title'],
		$rt['title'],
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'].'&act=new',
		'',
		$pagination,
		$posts,
		'',
		'',
		'',
	],$html);
}
if($pid!=0&&$act==''){ // Post
	$sup=$db->prepare("UPDATE `".$prefix."forumPosts` SET `views`=`views` + 1 WHERE `id`=:id");
	$sup->execute([':id'=>$pid]);
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `id`=:id");
	$sc->execute([':id'=>$cid]);
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	$st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `id`=:id");
	$st->execute([':id'=>$tid]);
	$rt=$st->fetch(PDO::FETCH_ASSOC);
	$sr=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `id`=:pid");
	$sr->execute([':cid'=>$cid,':tid'=>$tid,':pid'=>$pid]);
	$rr=$sr->fetch(PDO::FETCH_ASSOC);
	preg_match('/<replies>([\w\W]*?)<\/replies>/',$html,$matches);
	$item=$matches[1];
	$posts='';
	$posttitle=$rr['title'];
	if($p == 1){
		$ssu=$db->prepare("SELECT `id`,`rank`,`username`,`name`,`avatar`,`gravatar`,`email_signature`,`ti` FROM `".$prefix."login` WHERE `id`=:id");
		$ssu->execute([':id'=>$rr['uid']]);
		$rru=$ssu->fetch(PDO::FETCH_ASSOC);
		$sp=$db->prepare("SELECT COUNT(`id`) as 'cnt' FROM `".$prefix."forumPosts` WHERE `uid`=:uid");
		$sp->execute([':uid'=>$rr['uid']]);
		$rp=$sp->fetch(PDO::FETCH_ASSOC);
		$posts=preg_replace([
			'/<print post=[\"\']?id[\"\']?>/',
			'/<print post=[\"\']?postid[\"\']?>/',
			'/<print post=[\"\']?vote[\"\']?>/',
			'/<print post=[\"\']?title[\"\']?>/',
			'/<print post=[\"\']?date[\"\']?>/',
			'/<print post=[\"\']?notes[\"\']?>/',
			'/<print user=[\"\']?signature[\"\']?>/',
			'/<print user=[\"\']?avatar[\"\']?>/',
			'/<print user=[\"\']?name[\"\']?>/',
			'/<print user=[\"\']?rank[\"\']?>/',
			'/<print user=[\"\']?posts[\"\']?>/',
			'/<print user=[\"\']?time[\"\']?>/',
			'~<toolbar>.*?<\/toolbar>~is'
		],[
			$rr['id'],
			$rr['id'],
			$rr['vote']==0?'Vote':$rr['vote'],
			$rr['title'],
			date($config['dateFormat'],$rr['ti']),
			$rr['notes'],
			$rru['email_signature']!=''?'<hr>'.$rru['email_signature']:'',
			'<img src="'.(file_exists('media/avatar/'.$rru['avatar'])?'media/avatar/'.$rru['avatar']:NOAVATAR).'" class="forum-avatar m-3" alt="'.($rru['name']==''?$rru['username']:$rru['name']).'">',
			$rru['name']==''?$rru['username']:$rru['name'],
			'<span class="badger badge-'.rank($rru['rank']).'">'.ucwords(rank(str_replace('-',' ',$rru['rank']))).'</span>',
			$rp['cnt'],
			date($config['dateFormat'],$rru['ti']),
			''
		],$item);
	}
	$sl=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `pid`=:pid");
	$sl->execute([':pid'=>$pid]);
	$totalItems = $sl->rowCount();
	$itemsPerPage = $config['showItems'];
	$currentPage = $p;
	$urlPattern = URL.'forum?cid='.$cid.'&tid='.$tid.'&pid='.$pid.'&p=(:num)';
	$pagination = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
	$from=$p==0?0:($p - 1) * $itemsPerPage;

	$sr=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `pid`=:pid ORDER BY `ti` ASC LIMIT $from,$itemsPerPage");
	$sr->execute([':pid'=>$pid]);
	while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
		$ssu=$db->prepare("SELECT `id`,`rank`,`username`,`name`,`avatar`,`gravatar`,`email_signature`,`ti` FROM `".$prefix."login` WHERE `id`=:id");
		$ssu->execute([':id'=>$rr['uid']]);
		$rru=$ssu->fetch(PDO::FETCH_ASSOC);
		$sp=$db->prepare("SELECT COUNT(`id`) as 'cnt' FROM `".$prefix."forumPosts` WHERE `uid`=:uid");
		$sp->execute([':uid'=>$rr['uid']]);
		$rp=$sp->fetch(PDO::FETCH_ASSOC);
		$items=$item;
		$items=preg_replace([
			'/<print post=[\"\']?id[\"\']?>/',
			'/<print post=[\"\']?postid[\"\']?>/',
			'/<print post=[\"\']?vote[\"\']?>/',
			'/<print post=[\"\']?title[\"\']?>/',
			'/<print post=[\"\']?date[\"\']?>/',
			'/<print post=[\"\']?notes[\"\']?>/',
			'/<print user=[\"\']?signature[\"\']?>/',
			'/<print user=[\"\']?avatar[\"\']?>/',
			'/<print user=[\"\']?name[\"\']?>/',
			'/<print user=[\"\']?rank[\"\']?>/',
			'/<print user=[\"\']?posts[\"\']?>/',
			'/<print user=[\"\']?time[\"\']?>/',
			isset($_SESSION['rank'])&&$_SESSION['rank']>599?'/<[\/]?toolbar>/':'~<toolbar>.*?<\/toolbar>~is'
		],[
			$rr['id'],
			$rr['id'],
			$rr['vote']==0?'Vote':$rr['vote'],
			'<span class="text-muted">Re: '.$rt['title'].'</span>',
			date($config['dateFormat'],$rr['ti']),
			$rr['notes'],
			$rru['email_signature'],
			'<img src="'.(file_exists('media/avatar/'.$rru['avatar'])?'media/avatar/'.$rru['avatar']:NOAVATAR).'" class="forum-avatar m-3" alt="'.($rru['name']==''?$rru['username']:$rru['name']).'">',
			$rru['name']==''?$rru['username']:$rru['name'],
			'<span class="badger badge-'.rank($rru['rank']).'">'.ucwords(rank(str_replace('-',' ',$rru['rank']))).'</span>',
			$rp['cnt'],
			date($config['dateFormat'],$rru['ti']),
			''
		],$items);
		$posts.=$items;
	}
	$html=preg_replace([
		'~<search>.*?<\/search>~is',
		'~<categories>.*?<\/categories>~is',
		'~<topic>.*?<\/topic>~is',
		'~<posts>.*?<\/posts>~is',
		'~<newpost>.*?<\/newpost>~is',
		'/<print forum=[\"\']?link[\"\']?>/',
		'/<print category=[\"\']?link[\"\']?>/',
		'/<print category=[\"\']?title[\"\']?>/',
		'/<print topic=[\"\']?link[\"\']?>/',
		'/<print topic=[\"\']?title[\"\']?>/',
		'/<print post=[\"\']?title[\"\']?>/',
		'/<print replyurl>/',
		'/<[\/]?postpage>/',
		'/<pagination>/',
		'~<replies>.*?<\/replies>~is',
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?'/<[\/]?replyform>/':'~<replyform>.*?<\/replyform>~is',
		'/<print pid>/',
		'/<print uid>/',
		'/<print rank>/'
	],[
		'',
		'',
		'',
		'',
		'',
		URL.'forum/',
		URL.'forum?cid='.$rc['id'],
		$rc['title'],
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'],
		$rt['title'],
		$posttitle,
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'].'&pid='.$pid.'&act=reply',
		'',
		$pagination,
		$posts,
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?'':'<div class="alert alert-info" role="alert">An account is required to post replies</div>',
		$pid,
		isset($_SESSION['uid'])?$_SESSION['uid']:0,
		$rt['rank']
	],$html);
}
if($act=='new'){
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `id`=:id");
	$sc->execute([':id'=>$cid]);
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	$st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `id`=:id");
	$st->execute([':id'=>$tid]);
	$rt=$st->fetch(PDO::FETCH_ASSOC);
	$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
	$su->execute([':id'=>$_SESSION['uid']]);
	$ru=$su->fetch(PDO::FETCH_ASSOC);
	$html=preg_replace([
		'~<search>.*?<\/search>~is',
		'~<categories>.*?<\/categories>~is',
		'~<topic>.*?<\/topic>~is',
		'~<posts>.*?<\/posts>~is',
		'~<postpage>.*?<\/postpage>~is',
		'/<[\/]?newpost>/',
		'/<print forum=[\"\']?link[\"\']?>/',
		'/<print category=[\"\']?link[\"\']?>/',
		'/<print category=[\"\']?title[\"\']?>/',
		'/<print topic=[\"\']?link[\"\']?>/',
		'/<print topic=[\"\']?title[\"\']?>/',
		'/<print cid>/',
		'/<print tid>/',
		'/<print uid>/',
		'/<print rank>/',
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?'/<[\/]?newpostform>/':'~<newpostform>.*?<\/newpostform>~is'
	],[
		'',
		'',
		'',
		'',
		'',
		'',
		URL.'forum/',
		URL.'forum?cid='.$rc['id'],
		$rc['title'],
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'],
		$rt['title'],
		$rc['id'],
		$rt['id'],
		$_SESSION['uid'],
		$rt['rank'],
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?'':'<div class="alert alert-info" role="alert">An active account, and being logged in is required to create new posts.</div>'
	],$html);
}

$sl=$db->prepare("SELECT `id`,`rank`,`username`,`name` FROM `".$prefix."login` WHERE `lti`>:lti");
$sl->execute([':lti'=>$ti - 300]);
$usersonline='';
$i=$sl->rowCount();
$ii=0;
if($i>0){
	while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
		$ii++;
		$usersonline.='<span class="badger badge-'.rank($rl['rank']).'">'.($rl['name']==''?$rl['username']:$rl['name']).'</span>'.($ii<$i?', ':'');
	}
}
$rl=$sl->fetch(PDO::FETCH_ASSOC);
$st=$db->prepare("SELECT COUNT(*) AS 'topics' FROM `".$prefix."forumTopics`");
$st->execute();
$rt=$st->fetch(PDO::FETCH_ASSOC);
$sp=$db->prepare("SELECT COUNT(*) AS 'posts' FROM `".$prefix."forumPosts` WHERE `pid`=0");
$sp->execute();
$rp=$sp->fetch(PDO::FETCH_ASSOC);
$sm=$db->prepare("SELECT COUNT(*) AS 'members' FROM `".$prefix."login` WHERE `active`=1");
$sm->execute();
$rm=$sm->fetch(PDO::FETCH_ASSOC);
$html=preg_replace([
	'/<print stats=[\"\']?online[\"\']?>/',
	'/<print stats=[\"\']?users[\"\']?>/',
	'/<print total=[\"\']?topics[\"\']?>/',
	'/<print total=[\"\']?posts[\"\']?>/',
	'/<print total=[\"\']?members[\"\']?>/'
],[
	$i,
	$usersonline==''?'No Registered Users':$usersonline,
	$rt['topics'],
	$rp['posts'],
	$rm['members']
],$html);
if(stristr($html,'<sideposts>')){
	preg_match('/<sidepostitems>([\w\W]*?)<\/sidepostitems>/',$html,$matches);
	$sideitem=$matches[1];
	$ss=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `id`!=:pid AND `pid`=0 AND `rank`<=:rank ORDER BY `views` DESC LIMIT 0,5");
	$ss->execute([
		':pid'=>$pid,
		':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
	]);
	$items='';
	while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
		$su=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
		$su->execute([':id'=>$rs['uid']]);
		$ru=$su->fetch(PDO::FETCH_ASSOC);
		$item=preg_replace([
			'/<print post=[\"\']?link[\"\']?>/',
			'/<print post=[\"\']?title[\"\']?>/',
			'/<print post=[\"\']?user[\"\']?>/'
		],[
			URL.'forum?cid='.$rs['cid'].'&tid='.$rs['tid'].'&pid='.$rs['id'],
			$rs['title'],
			$ru['name']==''?$ru['username']:$ru['name']
		],$sideitem);
		$items.=$item;
	}
	$html=preg_replace([
		$ss->rowCount()>0?'/<[\/]?sideposts>/':'~<sideposts>.*?<\/sideposts>~is',
		'~<sidepostitems>.*?<\/sidepostitems>~is'
	],[
		'',
		$items
	],$html);
}
$content.=$html;
