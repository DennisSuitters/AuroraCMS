<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Header
 * @package    core/view/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($_SESSION['rank'])&&$_SESSION['rank']>0){
	$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
	$su->execute([':uid'=>$_SESSION['uid']]);
	$user=$su->fetch(PDO::FETCH_ASSOC);
	preg_match('/<accountMenuItems>([\w\W]*?)<\/accountMenuItems>/',$html,$matches);
	$accountMenuItem=$matches[1];
	$sa=$db->prepare("SELECT `id`,`contentType`,`title` FROM `".$prefix."menu` WHERE `menu`='account' AND `mid`=0 AND `active`=1 AND `rank`>'299' ORDER BY `ord` ASC");
	$sa->execute();
	$items='';
	if($sa->rowCount()>0){
		while($ra=$sa->fetch(PDO::FETCH_ASSOC)){
			$item=$accountMenuItem;
			$item=preg_replace([
				'/<print active>/',
				'/<print account=[\"\']?url[\"\']?>/',
				'/<print account=[\"\']?title[\"\']?>/'
			],[
				$view==$ra['contentType']?' active':'',
				URL.$ra['contentType'].'/',
				$ra['title']
			],$item);
			$items.=$item;
		}
	}
	$html=preg_replace('~<accountMenuItems>.*?<\/accountMenuItems>~is',$items,$html,1);
	if(preg_match('/<print user=[\"\']?avatar[\"\']?>/',$html)){
		if(isset($user)&&$user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))$html=preg_replace('/<print user=[\"\']?avatar[\"\']?>/','media/avatar/'.$user['avatar'],$html);
		elseif(isset($user)&&$user['gravatar']!=''){
			if(stristr('@',$user['gravatar']))
				$html=preg_replace('/<print user=[\"\']?avatar[\"\']?>/','http://gravatar.com/avatar/'.md5($user['gravatar']),$html);
			elseif(stristr('gravatar.com/avatar/'))
				$html=preg_replace('/<print user=[\"\']?avatar[\"\']?>/',$user['gravatar'],$html);
			else
				$html=preg_replace('/<print user=[\"\']?avatar[\"\']?>/',$noavatar,$html);
		}else
			$html=preg_replace('/<print user=[\"\']?avatar[\"\']?>/',$noavatar,$html);
	}
	$html=preg_replace([
		$user['rank']>399?'/<[\/]?accountmenu>/':'/<[\/]?accountmenu>/',
		$user['rank']>399?'/<[\/]?administration>/':'~<administration>.*?<\/administration>~is',
		'/<print administrationLink>/',
		'/<print user=[\"\']?name[\"\']?>/',
		'/<print user=[\"\']?cssrank[\"\']?>/',
		'/<print user=[\"\']?rank[\"\']?>/',
		'/<print user=[\"\']?points[\"\']?>/',
		'/<print currenturl>/',
		'/<accountnotification>/'
	],[
		'',
		'',
		URL.$settings['system']['admin'].'/',
		str_replace(' ','-',$user['name']),
		rank($user['rank']),
		($user['points']>0?' | '.number_format((float)$user['points']).' Points Earned':''),
		($user['name']!=''?$user['name']:$user['username']).' ('.ucwords(str_replace('-',' ',rank($user['rank']))).')',
		$_SERVER['REQUEST_URI'],
		$user['rank']<301?($config['iconsColor'][0]==1&&$user['address']==''||$user['suburb']==''||$user['city']==''||$user['country']==''||$user['state']==''||$user['postcode']==0?'<div class="alert alert-info m-0">There is missing Address Information that is required for calculating Shipping Costs, and Destination. Please go to your <a href="'.URL.'settings#address">Settings</a> to update the information.</div>':''):''
	],$html);
}else{
	$html=preg_replace([
		'~<accountmenu>.*?<\/accountmenu>~is',
		'/<accountnotification>/'
	],'',$html);
}
$html=preg_replace([
	'/<print view>/',
	'/<print config=[\"\']?seoTitle[\"\']?>/',
	'/<print config=[\"\']?business[\"\']?>/',
	'/<print meta=[\"\']?url[\"\']?>/',
	'/<print page=[\"\']?title[\"\']?>/'
],[
	$view,
	$config['seoTitle'],
	$config['business'],
	URL,
	$page['title']
],$html);
if(stristr($html,'<buildMenu')){
	preg_match('/<nondropDown>([\w\W]*?)<\/nondropDown>/',$html,$matches);
	$nondropDown=$matches[1];
	preg_match('/<dropDown>([\w\W]*?)<\/dropDown>/',$html,$matches);
	$dropDown=$matches[1];
	preg_match('/<subMenuItem>([\w\W]*?)<\/subMenuItem>/',$dropDown,$matches);
	$subMenuItem=$matches[1];
	if(stristr($html,'<menuLogin')){
		preg_match('/<menuLogin>([\w\W]*?)<\/menuLogin>/',$html,$matches);
		$menuLogin=$matches[1];
	}else
		$menuLogin='';
	$htmlMenu='';
	$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `menu`='head' AND `mid`=0 AND `active`=1 AND `rank`<=:rank ORDER BY `ord` ASC");
	$s->execute([':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0]);
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$menuURL='';
		if($r['contentType']=='cart'&&$config['options'][30]==1&&(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==false))continue;
		if($r['contentType']!='index'){
			if(isset($r['url'][0])&&$r['url'][0]=='#')
				$menuURL.=URL.$r['url'];
			elseif(isset($r['url'])&&$r['url']!='')
				$menuURL.=$r['url'];
			else{
				$menuURL.=URL.$r['contentType'].'/';
				if(!in_array(
					$r['contentType'],
					['aboutus','activities','article','biography','bookings','cart','contactus','distributors',
					'events','forum','gallery','inventory','news','newsletters','portfolio',
					'proofs','search','service','testimonials','tos'],
					true)
				)$menuURL.=str_replace(' ','-',strtolower($r['title'])).'/';
			}
		}else
			$menuURL.=URL;
		$sm=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `mid`=:id AND `active`=1 AND `rank`<=:rank ORDER BY `ord` ASC");
		$sm->execute([
			':id'=>$r['id'],
			':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
		]);
		$smc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `mid`=:id AND `status`='published' AND `rank`<=:rank ORDER BY `title` ASC");
		$smc->execute([
			':id'=>$r['id'],
			':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
		]);
		$menuItem=$nondropDown;
		if($sm->rowCount()>0||$smc->rowCount()>0)
			$menuItem=$dropDown;
		$menuItem=preg_replace([
			'/<print header>/',
			'/<print active=[\"\']?menu[\"\']?>/',
			'/<print menu=[\"\']?url[\"\']?>/',
			'/<print rel=[\"\']?contentType[\"\']?>/',
			'/<print menu=[\"\']?title[\"\']?>/'
		],[
			'',
			$page['id']==$r['id']?$theme['settings']['activeClass']:'',
			$menuURL,
			$r['contentType'],
			$r['title']
		],$menuItem);
		$submenu='';
		if($sm->rowCount()>0){
			while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
				$mitem=$subMenuItem;
				$subURL='';
				if($rm['contentType']!='index'){
					if(isset($rm['url'][0])&&$rm['url'][0]=='#')
						$subURL.=URL.$rm['url'].'/';
					elseif(isset($rm['url'])&&filter_var($rm['url'],FILTER_VALIDATE_URL))
						$subURL.=$rm['url'].'/';
					else{
						$subURL.=URL.$rm['contentType'].'/';
						if(!in_array(
							$rm['contentType'],
							['aboutus','article','biography','bookings','cart','contactus','distributors',
							'events','gallery','inventory','news','newsletters','portfolio',
							'proofs','search','service','testimonials','tos'],
							true)
						)$subURL.=str_replace(' ','-',strtolower($rm['title'])).'/';
					}
				}
				$mitem=preg_replace([
					'/<print header>/',
					'/<print submenu=[\"\']?url[\"\']?>/',
					'/<print rel=[\"\']?contentType[\"\']?>/',
					'/<print submenu=[\"\']?title[\"\']?>/',
					'/<print content=[\"\']?image[\"\']?>/'
				],[
					'',
					$subURL,
					$rm['contentType'],
					$rm['title'],
					''
				],$mitem);
				$submenu.=$mitem;
			}
		}
		if($smc->rowCount()>0){
			$ih=0;
			while($rm=$smc->fetch(PDO::FETCH_ASSOC)){
				$menuimage='';
				if($rm['thumb']!='')
					$menuimage=$rm['thumb'];
				$mitem=$subMenuItem;
				$subURL='';
				if($rm['contentType']!='index'){
					if(isset($rm['url'][0])&&$rm['url'][0]=='#')
						$subURL.=URL.$rm['url'].'/';
					elseif(isset($rm['url'])&&filter_var($rm['url'],FILTER_VALIDATE_URL))
						$subURL.=$rm['url'].'/';
					else{
						$subURL.=URL.$rm['contentType'].'/';
						$subURL.=str_replace(' ','-',strtolower($rm['title'])).'/';
					}
				}
				$mitem=preg_replace([
					'/<print header>/',
					'/<print submenu=[\"\']?url[\"\']?>/',
					'/<print rel=[\"\']?contentType[\"\']?>/',
					'/<print submenu=[\"\']?title[\"\']?>/',
					'/<print content=[\"\']?image[\"\']?>/'
				],[
					$ih==0?'<li class="dropdown-header">Products</li>':'',
					$subURL,
					$rm['contentType'],
					$rm['title'],
					$menuimage!=''?'<img src="'.$menuimage.'" alt="'.$rm['title'].'">':''
				],$mitem);
				$ih++;
				$submenu.=$mitem;
			}
		}
		if($sm->rowCount()>0||$smc->rowCount()>0)
			$menuItem=preg_replace('~<subMenuItem>.*?<\/subMenuItem>~is',$submenu,$menuItem,1);
		$cart='';
		if($r['contentType']=='cart'){
			$dti=$ti-86400;
			$crtq=$db->prepare("DELETE FROM `".$prefix."cart` WHERE `ti`<:ti");
			$crtq->execute([':ti'=>$dti]);
			$crtq=$db->prepare("SELECT SUM(`quantity`) as quantity FROM `".$prefix."cart` WHERE `si`=:si");
			$crtq->execute([':si'=>SESSIONID]);
			$crtr=$crtq->fetch(PDO::FETCH_ASSOC);
			$cart=$theme['settings']['cart_menu'];
			$cart=preg_replace('/<print cart=[\"\']?quantity[\"\']?>/',$crtr['quantity'],$cart);
		}
		$menuItem=str_replace('<menuCart>',$cart,$menuItem);
		$htmlMenu.=$menuItem;
	}
	if($menuLogin!=''){
		$menuLogin=preg_replace([
			'/<print url>/',
			'/<print urlself>/'
		],[
			URL,
			rtrim($_SERVER['REQUEST_URI'],'logout')
		],$menuLogin);
		if(isset($_SESSION['rank'])&&$_SESSION['rank']>0)
			$menuLogin='';
		else{
			$menuLogin=preg_replace($config['options'][3]==0?'~<signup>.*?<\/signup>~is':'/<[\/]?signup>/','',$menuLogin);
			$htmlMenu.=$menuLogin;
		}
	}
	$html=preg_replace([
		'~<buildMenu>.*?<\/buildMenu>~is',
		'/<print cart=[\"\']?quantity[\"\']?>/'
	],[
		$htmlMenu,
		(isset($crtr)&&$crtr['quantity']>0?$crtr['quantity']:'')
	],$html,1);
}
include'inc-buildsocial.php';
include'inc-hours.php';
$html=preg_replace([
	'/<print page=[\"\']?contentType[\"\']?>/',
	'/<rand>/',
	stristr($html,'<email>')&&$config['options'][23]==1?'/<[\/]?email>/':'~<email>.*?<\/email>~is',
	stristr($html,'<contact>')&&$config['options'][22]==1?'/<[\/]?contact>/':'~<contact>.*?<\/contact>~is',
	stristr($html,'<phone>')&&$config['options'][24]==1?'/<[\/]?phone>/':'~<phone>.*?<\/phone>~is',
	'/<print config=[\"\']?email[\"\']?>/',
	'/<print config=[\"\']?business[\"\']?>/',
	'/<print config=[\"\']?address[\"\']?>/',
	'/<print config=[\"\']?suburb[\"\']?>/',
	'/<print config=[\"\']?postcode[\"\']?>/',
	'/<print config=[\"\']?country[\"\']?>/',
	'/<print config=[\"\']?phone[\"\']?>/',
	'/<print config=[\"\']?mobile[\"\']?>/',
	'/<print theme>/'
],[
	$page['contentType'],
	rand(1,10),
	'',
	'',
	'',
	'<a href="contactus/">'.htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8').'</a>',
	htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
	$config['postcode']==0?'':htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
	$config['phone']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['phone']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8').'</a>':'',
	$config['mobile']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['mobile']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8').'</a>':'',
	THEME
],$html);
$content.=$html;
