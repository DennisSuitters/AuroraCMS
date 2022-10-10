<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - FAQ
 * @package    core/view/faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/pagination.php';
include'inc-cover.php';
include'inc-breadcrumbs.php';
if(stristr($html,'<breadcrumb>')){
  preg_match('/<breaditems>([\w\W]*?)<\/breaditems>/',$html,$matches);
  $breaditem=$matches[1];
  preg_match('/<breadcurrent>([\w\W]*?)<\/breadcurrent>/',$html,$matches);
  $breadcurrent=$matches[1];
  $jsoni=1;
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
  $jsonld.=
	'{'.
		'"@type":"ListItem",'.
		'"position":'.$jsoni.','.
		'"item":{'.
			'"@id":"'.URL.urlencode($page['contentType']).'/",'.
			'"name":"'.htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8').'"'.
		'}'.
	'}]}</script>';
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
	$page['notes'],
],$html);
$forum='';
$cid=isset($_GET['cid'])?filter_input(INPUT_GET,'cid',FILTER_SANITIZE_NUMBER_INT):0;
$tid=isset($_GET['tid'])?filter_input(INPUT_GET,'tid',FILTER_SANITIZE_NUMBER_INT):0;
$pid=isset($_GET['pid'])?filter_input(INPUT_GET,'pid',FILTER_SANITIZE_NUMBER_INT):0;
$act=isset($_GET['act'])?filter_input(INPUT_GET,'act',FILTER_UNSAFE_RAW):filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW);
$p=isset($_GET['p'])?filter_input(INPUT_GET,'p',FILTER_SANITIZE_NUMBER_INT):1;
if($act=='search'){
	$st=isset($_GET['s'])?filter_input(INPUT_GET,'s',FILTER_UNSAFE_RAW):'';
	preg_match('/<searchitem>([\w\W]*?)<\/searchitem>/',$html,$matches);
	$item=$matches[1];
	$searchitems='';
	if(isset($_SESSION['rank'])&&$_SESSION['rank']>699){
		$q=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE LOWER(`notes`) LIKE LOWER(:st) OR LOWER(`title`) LIKE (:st) AND `rank`<=:rank");
	}else{
		$q=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE LOWER(`notes`) LIKE LOWER(:st) OR LOWER(`title`) LIKE (:st) AND `rank`<=:rank AND `help`='0'");
	}
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
					($rs['pid']!=0?$rs['pid']:$rss['id']);
				$searchnotes=snippet($st,$rs['notes']);
				$searchtitle=$rs['title']==''?$rss['title']:$rs['title'];
				$items=preg_replace([
					'/<print search=[\"\']?link[\"\']?>/',
					'/<print search=[\"\']?title[\"\']?>/',
					'/<print search=[\"\']?notes[\"\']?>/'
				],[
					$searchlink,
					htmlspecialchars($searchtitle,ENT_QUOTES,'UTF-8'),
					$searchnotes
				],$items);
				$searchitems.=$items;
			}
		}else
			$searchitems='<div class="alert alert-info mt-3" role="alert">No results found for the Search Tem that was entered.</div>';
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
if($pid==0&&$tid==0&&$cid==0){ // Category
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `rank`<=:rank ORDER BY `pin` DESC, `ord` ASC");
	$sc->execute([':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0]);
	preg_match('/<categoryheader>([\w\W]*?)<\/categoryheader>/',$html,$matches);
	$categories=$matches[1];
	preg_match('/<category>([\w\W]*?)<\/category>/',$html,$matches);
	$item=$matches[1];
	while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
		$tops=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `cid`=:cid");
		$tops->execute([':cid'=>$rc['id']]);
		$rtops=$tops->fetch(PDO::FETCH_ASSOC);
		$psts=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `pid`=0");
		$psts->execute([':cid'=>$rc['id']]);
		$rpsts=$psts->fetch(PDO::FETCH_ASSOC);
		$spt=$db->prepare("SELECT * FROM `".$prefix."forumPostTrack` WHERE `cid`=:cid AND `uid`=:uid");
		$spt->execute([
			':cid'=>$rc['id'],
			':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0
		]);
		$lst=$db->prepare("SELECT `id`,`title`,`tid`,`uid`,`help`,`ti` FROM `".$prefix."forumPosts` WHERE `cid`=:cid");
		$lst->execute(['cid'=>$rc['id']]);
		$lstget=$lst->fetch(PDO::FETCH_ASSOC);
		$lstu=$db->prepare("SELECT `username`,`name` FROM `".$prefix."login` WHERE `id`=:uid");
		$lstu->execute([':uid'=>isset($lstget['uid'])?$lstget['uid']:0]);
		$lastuser=$lstu->fetch(PDO::FETCH_ASSOC);
		$items=$item;
		$lastinfo=$lst->rowCount()>0?(
      $lstget['help']==0?'<a href="'.URL.'forum?cid='.
        $rc['id'].'&tid='.
        $lstget['tid'].'&pid='.
        $lstget['id'].'">':'').
        $lstget['title'].
        ($lstget['help']==0?'</a>':'').
        '<br>by '.
        (isset($lastuser['name'])&&$lastuser['name']==''?
          $lastuser['username']:
          (isset($lastuser['name'])?$lastuser['name']:'Anonymous')).' '.
          (isset($lstget['ti'])?date('jS, M Y',$lstget['ti']):'No Posts Yet'):'No Posts Yet';
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
			'<i class="i i-4x'.($psts->rowCount()>$spt->rowCount()&&(isset($_SESSION['uid'])&&$_SESSION['uid']>0)?' forum-unread':' forum-read').'">forum-category</i>',
			$rc['pin']==1?'<i class="i text-success">pin</i>':'',
			URL.'forum?cid='.$rc['id'],
			htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8'),
			$rc['notes'],
			$tops->rowCount(),
			$psts->rowCount(),
			$lastinfo
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
		'/<print help>/',
		'/<statusselect>/',
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
		htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8'),
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'],
		htmlspecialchars($rt['title'],ENT_QUOTES,'UTF-8'),
		$rc['id'],
		$rt['id'],
		$_SESSION['uid'],
		$rt['rank'],
		$rt['help'],
		$rt['help']==0?'':
			'<div class="form-row">'.
				'<select name="st">'.
					'<option value="not-urgent">Not Urgent</option>'.
					'<option value="urgent">Urgent</option>'.
				'</select>'.
			'</div>',
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?'':'<div class="alert alert-info" role="alert">An active account, and being logged in is required to create new posts.</div>'
	],$html);
}
if($pid==0&&$tid==0&&$cid>0){ // Topics
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `id`=:id");
	$sc->execute([':id'=>$cid]);
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	$st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `cid`=:cid AND `rank`<=:rank ORDER BY `pin` DESC, `ord` ASC");
	$st->execute([
		':cid'=>$cid,
		':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
	]);
	preg_match('/<topics>([\w\W]*?)<\/topics>/',$html,$matches);
	$item=$matches[1];
	$topics='';
	while($rt=$st->fetch(PDO::FETCH_ASSOC)){
		$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid");
		$sp->execute([
			':cid'=>$rt['cid'],
			':tid'=>$rt['id']
		]);
		$rp=$sp->fetch(PDO::FETCH_ASSOC);
		$lst=$db->prepare("SELECT `id`,`title`,`cid`,`tid`,`uid`,`help`,`ti` FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0");
		$lst->execute([
			':cid'=>$rt['cid'],
			':tid'=>isset($rt['id'])?$rt['id']:0
		]);
		$lstget=$lst->fetch(PDO::FETCH_ASSOC);
		$spt=$db->prepare("SELECT * FROM `".$prefix."forumPostTrack` WHERE `tid`=:tid AND `uid`=:uid");
		$spt->execute([
			':tid'=>$rt['id'],
			':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0
		]);
		$lstu=$db->prepare("SELECT `username`,`name` FROM `".$prefix."login` WHERE `id`=:uid");
		$lstu->execute([':uid'=>isset($lstget['uid'])?$lstget['uid']:0]);
		$lastuser=$lstu->fetch(PDO::FETCH_ASSOC);
		$items=$item;
		$lastinfo=$lst->rowCount()>0?($lstget['help']==0?'<a href="'.URL.'forum?cid='.$rc['id'].'&tid='.$lstget['tid'].'&pid='.$lstget['id'].'">':'').$lstget['title'].($lstget['help']==0?'</a>':'').' by '.($lastuser['name']==''?$lastuser['username']:$lastuser['name']).'<br>'.date($config['dateFormat'],$lstget['ti']):'No Posts Yet';
		$items=preg_replace([
			'/<print topic=[\"\']?icon[\"\']?>/',
			'/<print topic=[\"\']?link[\"\']?>/',
			'/<print topic=[\"\']?pinned[\"\']?>/',
			'/<print topic=[\"\']?title[\"\']?>/',
			'/<print topic=[\"\']?notes[\"\']?>/',
			'/<print posts=[\"\']?count[\"\']?>/',
			'/<print post=[\"\']?last[\"\']?>/',
		],[
			'<i class="i i-4x'.($spt->rowCount()<$sp->rowCount()&&(isset($_SESSION['uid'])&&$_SESSION['uid'])>0?' forum-unread':' forum-read').'">forum-category</i>',
			URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'],
			$rt['pin']==1?'<i class="i text-success">pin</i>':'',
			htmlspecialchars($rt['title'],ENT_QUOTES,'UTF-8'),
			$rt['notes'],
			$sp->rowCount(),
			$lastinfo
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
		htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8'),
		$rc['notes'],
		$topics,
		'',
		'',
		''
	],$html);
}
if($pid==0&&$tid!=0){ // Posts
	$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` WHERE `id`=:id");
	$sc->execute([':id'=>$cid]);
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	$st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `id`=:id");
	$st->execute([':id'=>$tid]);
	$rt=$st->fetch(PDO::FETCH_ASSOC);
	if(isset($_SESSION['rank'])&&$_SESSION['rank']>0){
		if($_SESSION['rank']>599){
			$sl=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0");
			$sl->execute([
				':cid'=>$cid,
				':tid'=>$tid
			]);
			$totalItems=$sl->rowCount();
			$itemsPerPage=$config['showItems'];
			$currentPage=$p==0?1:$p;
			$from=$p==0||$p==1?0:($p - 1) * $itemsPerPage;
			$urlPattern=URL.'forum?cid='.$cid.'&tid='.$tid.'&p=(:num)';
			$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0 ORDER BY `pin` DESC, `views` DESC, `ti` DESC LIMIT $from,$itemsPerPage");
			$sp->execute([
				':cid'=>$cid,
				':tid'=>$tid
			]);
		}else{
			$sl=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0 AND `help`=:help");
			$sl->execute([
				':cid'=>$cid,
				':tid'=>$tid,
				':help'=>$rt['help']
			]);
			$totalItems=$sl->rowCount();
			$itemsPerPage=$config['showItems'];
			$currentPage=$p==0?1:$p;
			$from=$p==0||$p==1?0:($p - 1) * $itemsPerPage;
			$urlPattern=URL.'forum?cid='.$cid.'&tid='.$tid.'&p=(:num)';
			$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0 AND `help`=:help ORDER BY `pin` DESC, `views` DESC, `ti` DESC LIMIT $from,$itemsPerPage");
			$sp->execute([
				':cid'=>$cid,
				':tid'=>$tid,
				':help'=>$rt['help']
			]);
		}
	}else{
		$sl=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0 AND `help`=0");
		$sl->execute([
			':cid'=>$cid,
			':tid'=>$tid
		]);
		$totalItems = $sl->rowCount();
		$itemsPerPage=$config['showItems'];
		$currentPage=$p==0?1:$p;
		$from=$p==0||$p==1?0:($p - 1) * $itemsPerPage;
		$urlPattern=URL.'forum?cid='.$cid.'&tid='.$tid.'&p=(:num)';
		$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=0 AND `help`=0 AND `rank`<=:rank ORDER BY `pin` DESC, `views` DESC, `ti` DESC LIMIT $from,$itemsPerPage");
		$sp->execute([
			':cid'=>$cid,
			':tid'=>$tid,
			':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
		]);
	}
	$pagination=new Paginator($totalItems,$itemsPerPage,$currentPage,$urlPattern);
	preg_match('/<post>([\w\W]*?)<\/post>/',$html,$matches);
	$item=$matches[1];
	$posts='';
	while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
		$spt=$db->prepare("SELECT * FROM `".$prefix."forumPostTrack` WHERE `pid`=:pid AND `uid`=:uid");
		$spt->execute([
			':pid'=>$rp['id'],
			':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0
		]);
		$sa=$db->prepare("SELECT `id`,`username`,`name`,`avatar` FROM `".$prefix."login` WHERE `id`=:id");
		$sa->execute([':id'=>$rp['uid']]);
		$ra=$sa->fetch(PDO::FETCH_ASSOC);
		$sco=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `pid`=:pid");
		$sco->execute([':pid'=>$rp['id']]);
		$lp=$db->prepare("SELECT `uid`,`ti` FROM `".$prefix."forumPosts` WHERE `pid`=:pid ORDER BY `ti` DESC LIMIT 1");
		$lp->execute([':pid'=>$rp['id']]);
		if($lp->rowCount()>0){
			$lr=$lp->fetch(PDO::FETCH_ASSOC);
			$lid=$lr['uid'];
			$lti=$lr['ti'];
		}else{
			$lid=$rp['uid'];
			$lti=$rp['ti'];
		}
		$lsu=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
		$lsu->execute([':id'=>$lid]);
		$lsr=$lsu->fetch(PDO::FETCH_ASSOC);
		$last='<small>'.($lsr['name']==''?$lsr['username']:$lsr['name']).' on '.date($config['dateFormat'],$lti).'</small>';
		$items=$item;
		preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i',$rp['notes'],$image);
		if(isset($image[1])&&$image[1]!=''){
			$avatar='<img class="forum-topic-avatar '.($spt->rowCount()==0&&(isset($_SESSION['uid'])&&$_SESSION['uid'])>0?'forum-unread':'forum-read').'" src="'.$image[1].'">';
		}else{
			if($ra['avatar']!='')
				$avatar='<img class="forum-topic-avatar '.($spt->rowCount()==0&&(isset($_SESSION['uid'])&&$_SESSION['uid'])>0?'forum-unread':'forum-read').'" src="'.URL.'media/avatar/'.$ra['avatar'].'">';
			else
				$avatar='<i class="i i-4x'.($spt->rowCount()==0&&$_SESSION['uid']>0?' forum-unread':' forum-read').'>forum-category</i>';
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
			'/<selectstatus>/',
			isset($_SESSION['rank'])&&$_SESSION['rank']>599?'/<[\/]?toolbar>/':'~<toolbar>.*?<\/toolbar>~is',
			'/<print post=[\"\']?checked[\"\']?>/'
		],[
			$rp['id'],
			$avatar,
			URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'].'&pid='.$rp['id'],
			$rp['pin']==1?'<i class="i text-success">pin</i>':'',
			htmlspecialchars($rp['title'],ENT_QUOTES,'UTF-8'),
			date($config['dateFormat'],$rp['ti']),
			$ra['name']==''?$ra['username']:$ra['name'],
			$sco->rowCount(),
			$rp['views'],
			$last,
			$rp['help']==1?'<div class="status '.$rp['status'].'">'.ucwords(str_replace('-',' ',$rp['status'])).'</div>':'',
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
		'/<bannednotification>/',
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?(isset($_SESSION['options'])&&$_SESSION['options'][20]==1?'~<newpostbtn>.*?<\/newpostbtn>~is':'/<[\/]?newpostbtn>/'):'~<newpostbtn>.*?<\/newpostbtn>~is'
	],[
		'',
		'',
		'',
		URL.'forum/',
		URL.'forum?cid='.$rc['id'],
		htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($rt['title'],ENT_QUOTES,'UTF-8'),
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'].'&act=new',
		'',
		$pagination,
		$posts,
		'',
		'',
		isset($_SESSION['options'][20])&&$_SESSION['options'][20]==1?'<div class="alert alert-info" role="alert">Your Account has been suspended from making Posts!</div>':'',
		'',
	],$html);
}
if($pid!=0){ // Post
	if(isset($_SESSION['uid'])&&$_SESSION['uid']>0){
		$sct=$db->prepare("SELECT * FROM `".$prefix."forumPostTrack` WHERE `cid`=:cid AND `tid`=:tid AND `pid`=:pid AND `uid`=:uid");
		$sct->execute([
			':cid'=>$cid,
			':tid'=>$tid,
			':pid'=>$pid,
			':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0
		]);
		if($sct->rowCount()==0){
			$sut=$db->prepare("INSERT INTO `".$prefix."forumPostTrack` (`cid`,`tid`,`pid`,`uid`,`notes`) VALUES (:cid,:tid,:pid,:uid,'read')");
			$sut->execute([
				':cid'=>$cid,
				':tid'=>$tid,
				':pid'=>$pid,
				':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0
			]);
		}
	}
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
	$posttitle=htmlspecialchars($rr['title'],ENT_QUOTES,'UTF-8');
	$skip=0;
	if($rr['help']==1){
		if($_SESSION['rank']>599){
		}else{
			if(isset($_SESSION['uid'])&&$_SESSION['uid']==$rr['uid']){
			}else{
				$skip=1;
				$posts='<div class="alert alert-info" role="alert">You need to be logged in to view Tickets!</div>';
				$html=preg_replace('~<replyform>.*?<\/replyform>~is','',$html);
			}
		}
	}
	if($skip==0){
		if($p == 1){
			$ssu=$db->prepare("SELECT `id`,`rank`,`username`,`name`,`avatar`,`gravatar`,`email_signature`,`ti` FROM `".$prefix."login` WHERE `id`=:id");
			$ssu->execute([':id'=>$rr['uid']]);
			$rru=$ssu->fetch(PDO::FETCH_ASSOC);
			if($rru['avatar']!=''&&file_exists('media/avatar/'.basename($rru['avatar'])))
				$avatar='<img src="media/avatar/'.basename($rru['avatar']).'" class="forum-avatar m-3" alt="'.($rru['name']==''?$rru['username']:$rru['name']).'">';
			else
				$avatar='<img src="'.NOAVATAR.'" class="forum-avatar m-3" alt="'.($rru['name']==''?$rru['username']:$rru['name']).'">';
			$sp=$db->prepare("SELECT COUNT(`id`) as 'cnt' FROM `".$prefix."forumPosts` WHERE `uid`=:uid");
			$sp->execute([':uid'=>$rr['uid']]);
			$rp=$sp->fetch(PDO::FETCH_ASSOC);
			$status=$rr['status'];
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
				'/<selectstatus>/',
				'~<toolbar>.*?<\/toolbar>~is',
				isset($_SESSION['uid'])&&$_SESSION['uid']>0?'/<[\/]?usertoolbar>/':'~<usertoolbar>.*?<\/usertoolbar>~is'
			],[
				$rr['id'],
				$rr['id'],
				$rr['vote']==0?'Vote':$rr['vote'],
				htmlspecialchars($rr['title'],ENT_QUOTES,'UTF-8'),
				date($config['dateFormat'],$rr['ti']),
				$rr['notes'],
				$rru['email_signature']!=''?'<hr>'.$rru['email_signature']:'',
				$avatar,
				$rru['name']==''?$rru['username']:$rru['name'],
				'<span class="badger badge-'.rank($rru['rank']).'">'.ucwords(rank(str_replace('-',' ',$rru['rank']))).'</span>',
				$rp['cnt'],
				date($config['dateFormat'],$rru['ti']),
				$rr['help']==1?(isset($_SESSION['rank'])&&$_SESSION['rank']>599?'<form target="sp" method="post" action="core/update.php">'.
						'<input type="hidden" name="id" value="'.$pid.'">'.
						'<input type="hidden" name="t" value="forumPosts">'.
						'<input type="hidden" name="c" value="status">'.
						'<select class="status '.$rr['status'].'" name="da" onchange="$(this).removeClass().addClass(`status `+$(this).val());this.form.submit();">'.
						'<option class="urgent" value="urgent"'.($rr['status']=='urgent'?' selected':'').'>Urgent</option>'.
						'<option class="in-progress" value="in-progress"'.($rr['status']=='in-progress'?' selected':'').'>In Progress</option>'.
						'<option class="closed" value="closed"'.($rr['status']=='closed'?' selected':'').'>Closed</option>'.
					'</select></form>':'<span class="status '.$rr['status'].'">'.ucwords(str_replace('-',' ',$rr['status'])).'</span>'):'',
				'',
				''
			],$item);
		}
		$sl=$db->prepare("SELECT `id` FROM `".$prefix."forumPosts` WHERE `pid`=:pid");
		$sl->execute([':pid'=>$pid]);
		$totalItems=$sl->rowCount();
		$itemsPerPage=$config['showItems'];
		$currentPage=$p;
		$urlPattern=URL.'forum?cid='.$cid.'&tid='.$tid.'&pid='.$pid.'&p=(:num)';
		$pagination=new Paginator($totalItems,$itemsPerPage,$currentPage,$urlPattern);
		$from=$p==0?0:($p - 1) * $itemsPerPage;
		$sr=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `pid`=:pid ORDER BY `ti` ASC LIMIT $from,$itemsPerPage");
		$sr->execute([':pid'=>$pid]);
		while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
			$ssu=$db->prepare("SELECT `id`,`rank`,`options`,`username`,`name`,`avatar`,`gravatar`,`email_signature`,`ti` FROM `".$prefix."login` WHERE `id`=:id");
			$ssu->execute([':id'=>$rr['uid']]);
			$rru=$ssu->fetch(PDO::FETCH_ASSOC);
			if($rru['avatar']!=''&&file_exists('media/avatar/'.basename($rru['avatar'])))
				$avatar='<img src="media/avatar/'.basename($rru['avatar']).'" class="forum-avatar m-3" alt="'.($rru['name']==''?$rru['username']:$rru['name']).'">';
			else
				$avatar='<img src="'.NOAVATAR.'" class="forum-avatar m-3" alt="'.($rru['name']==''?$rru['username']:$rru['name']).'">';
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
				'/<selectstatus>/',
				'/<print user=[\"\']?id[\"\']?>/',
				'/<print banchecked>/',
				isset($_SESSION['rank'])&&$_SESSION['rank']>599?'/<[\/]?toolbar>/':'~<toolbar>.*?<\/toolbar>~is',
				$rru['rank']<600?'/<[\/]?banuser>/':'~<banuser>.*?<\/banuser>~is',
				isset($_SESSION['uid'])&&$_SESSION['uid']>0?'/<[\/]?usertoolbar>/':'~<usertoolbar>.*?<\/usertoolbar>~is'
			],[
				$rr['id'],
				$rr['id'],
				$rr['vote']==0?'Vote':$rr['vote'],
				'<span class="text-muted">Re: '.$rt['title'].'</span>',
				date($config['dateFormat'],$rr['ti']),
				$rr['notes'],
				htmlspecialchars($rru['email_signature'],ENT_QUOTES,'UTF-8'),
				$avatar,
				$rru['name']==''?$rru['username']:$rru['name'],
				'<span class="badger badge-'.rank($rru['rank']).'">'.ucwords(rank(str_replace('-',' ',$rru['rank']))).'</span>',
				$rp['cnt'],
				isset($rru['ti'])?date($config['dateFormat'],$rru['ti']):'',
				'',
				isset($rru['id'])?$rru['id']:0,
				isset($rru['options'][20])&&$rru['options'][20]==1?' checked':'',
				'',
				'',
				'',
				''
			],$items);
			$posts.=$items;
		}
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
		'/<bannednotification>/',
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?(isset($_SESSION['options'])&&$_SESSION['options'][20]==1||$status=='closed'?'~<replyform>.*?<\/replyform>~is':'/<[\/]?replyform>/'):'~<replyform>.*?<\/replyform>~is',
		'/<print cid>/',
		'/<print tid>/',
		'/<print pid>/',
		'/<print uid>/',
		'/<print rank>/',
		'/<print help>/'
	],[
		'',
		'',
		'',
		'',
		'',
		URL.'forum/',
		URL.'forum?cid='.$rc['id'],
		htmlspecialchars($rc['title'],ENT_QUOTES,'UTF-8'),
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'],
		htmlspecialchars($rt['title'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($posttitle,ENT_QUOTES,'UTF-8'),
		URL.'forum?cid='.$rc['id'].'&tid='.$rt['id'].'&pid='.$pid.'&act=reply',
		'',
		$pagination,
		$posts,
		isset($_SESSION['options'][20])&&$_SESSION['options'][20]==1?'<div class="alert alert-info" role="alert">Your Account has been suspended from making Replies!</div>':'',
		isset($_SESSION['uid'])&&$_SESSION['uid']>0?'':'<div class="alert alert-info" role="alert">An account is required to post replies</div>',
		$cid,
		$tid,
		$pid,
		isset($_SESSION['uid'])?$_SESSION['uid']:0,
		$rt['rank'],
		$rt['help']
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
	$ss=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `id`!=:pid AND `pid`=0 AND `help`=0 AND `rank`<=:rank ORDER BY `views` DESC LIMIT 0,5");
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
			htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
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
