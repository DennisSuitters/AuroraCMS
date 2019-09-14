<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Header
 * @package    core/view/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Make sure all links end with /
 */
if(isset($_SESSION['rank'])&&$_SESSION['rank']>0){
	$su=$db->prepare("SELECT avatar,gravatar,rank,name FROM `".$prefix."login` WHERE id=:uid");
	$su->execute([':uid'=>$_SESSION['uid']]);
	$user=$su->fetch(PDO::FETCH_ASSOC);
	$html=$view=='proofs'||$view=='proof'?preg_replace('/<print active=[\"\']?proofs[\"\']?>/',' active',$html):preg_replace('/<print active=[\"\']?proofs[\"\']?>/','',$html);
	$html=$view=='orders'||$view=='order'?preg_replace('/<print active=[\"\']?orders[\"\']?>/',' active',$html):preg_replace('/<print active=[\"\']?orders[\"\']?>/','',$html);
	$html=$view=='settings'?preg_replace('/<print active=[\"\']?settings[\"\']?>/',' active',$html):preg_replace('/<print active=[\"\']?settings[\"\']?>/','',$html);
	if(preg_match('/<print user=[\"\']?avatar[\"\']?>/',$html)){
		if(isset($user)&&$user['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$user['avatar']))
			$html=preg_replace('/<print user=[\"\']?avatar[\"\']?>/','media'.DS.'avatar'.DS.$user['avatar'],$html);
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
	if($user['rank']>399){
		$html=preg_replace([
			'/<[\/]?accountmenu>/',
			'/<[\/]?administration>/',
			'/<print administrationLink>/'
		],[
			'',
			'',
			URL.$settings['system']['admin'].'/'
		],$html);
	}else{
		$html=preg_replace([
			'/<[\/]?accountmenu>/',
			'~<administration>.*?<\/administration>~is'
		],'',$html);
	}
//	if($user['bio_options']{0}==1){
		$html=preg_replace([
			'/<print user=[\"\']?name[\"\']?>/',
			'/<[\/]?profile>/'
		],[
			str_replace(' ','-',$user['name']),
			''
		],$html);
//	}else
//		$html=preg_replace('~<profile>.*?<\/profile>~is','',$html,1);
		if(isset($user['rank'])&&$user['rank']>899){
			$html=preg_replace(['/<[\/]?seohelper>/'],'',$html);
		}else{
			$html=preg_replace('~<seohelper>.*?<\/seohelper>~is','',$html,1);
		}
}else
	$html=preg_replace('~<accountmenu>.*?<\/accountmenu>~is','',$html,1);
$html=preg_replace([
	'/<print view>/',
	'/<print config=[\"\']?seoTitle[\"\']?>/',
	'/<print meta=[\"\']?url[\"\']?>/'
],[
	$view,
	$config['seoTitle'],
	URL
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
	$s=$db->query("SELECT * FROM `".$prefix."menu` WHERE menu='head' AND mid=0 AND active=1 ORDER BY ord ASC");
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$menuURL='';
		if($r['contentType']!='index'){
			if(isset($r['url'][0])&&$r['url'][0]=='#')
				$menuURL.=URL.$r['url'].'/';
			elseif(isset($r['url'])&&filter_var($r['url'],FILTER_VALIDATE_URL))
				$menuURL.=$r['url'];
			else{
				$menuURL.=URL.$r['contentType'].'/';
				if(!in_array(
					$r['contentType'],
					[
						'aboutus',
						'article',
						'bookings',
						'cart',
						'contactus',
						'distributors',
						'events',
						'gallery',
						'inventory',
						'news',
						'newsletters',
						'portfolio',
						'proofs',
						'search',
						'service',
						'testimonials',
						'tos'
					],
					true)
				)$menuURL.='/'.str_replace(' ','-',strtolower($r['title'])).'/';
			}
		}else
			$menuURL.=URL;
		$sm=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE mid=:mid AND active=1 ORDER BY ord ASC");
		$sm->execute([':mid'=>$r['id']]);
		$smc=$sm->rowCount();
		$menuItem=$nondropDown;
		if($smc>0)$menuItem=$dropDown;
		$menuItem=preg_replace([
			'/<print active=[\"\']?menu[\"\']?>/',
			'/<print menu=[\"\']?url[\"\']?>/',
			'/<print rel=[\"\']?contentType[\"\']?>/',
			'/<print menu=[\"\']?title[\"\']?>/'
		],[
			$r['contentType']==$view?$theme['settings']['settings_activeClass']:'',
			$menuURL,
			$r['contentType'],
			$r['title']
		],$menuItem);
		if($smc>0){
			$submenu='';
			$item=$subMenuItem;
			$item=preg_replace([
				'/<print submenu=[\"\']?url[\"\']?>/',
				'/<print rel=[\"\']?contentType[\"\']?>/',
				'/<print submenu=[\"\']?title[\"\']?>/'
			],[
				$menuURL,
				$r['contentType'],
				$r['title']
			],$item);
			$submenu.=$item;
			while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
				$item=$subMenuItem;
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
							[
								'aboutus',
								'article',
								'bookings',
								'cart',
								'contactus',
								'distributors',
								'events',
								'gallery',
								'inventory',
								'news',
								'newsletters',
								'portfolio',
								'proofs',
								'search',
								'service',
								'testimonials',
								'tos'
							],
							true)
						)$subURL.='/'.str_replace(' ','-',strtolower($rm['title'])).'/';
					}
				}
				$item=preg_replace([
					'/<print submenu=[\"\']?url[\"\']?>/',
					'/<print rel=[\"\']?contentType[\"\']?>/',
					'/<print submenu=[\"\']?title[\"\']?>/'
				],[
					$subURL,
					$rm['contentType'],
					$rm['title']
				],$item);
				$submenu.=$item;
			}
			$menuItem=preg_replace('~<subMenuItem>.*?<\/subMenuItem>~is',$submenu,$menuItem,1);
		}
		$cart='';
		if($r['contentType']=='cart'){
			$dti=$ti-86400;
			$crtq=$db->prepare("DELETE FROM `".$prefix."cart` WHERE ti<:ti");
			$crtq->execute([':ti'=>$dti]);
			$crtq=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
			$crtq->execute([':si'=>SESSIONID]);
			$crtr=$crtq->fetch(PDO::FETCH_ASSOC);
			$cart=$theme['settings']['cart_menu'];
			$cart=preg_replace('/<print cart=[\"\']?quantity[\"\']?>/',$crtr['quantity'],$cart);
		}
		$menuItem=str_replace('<menuCart>',$cart,$menuItem);
		$htmlMenu.=$menuItem;
	}
	if($menuLogin!=''){
		$menuLogin=preg_replace('/<print url>/',URL,$menuLogin,1);
		if(isset($_SESSION['rank'])&&$_SESSION['rank']>0)
			$menuLogin='';
		else{
			if($config['options']{3}==0)
				$menuLogin=preg_replace('~<signup>.*?<\/signup>~is','',$menuLogin,1);
			else
				$menuLogin=preg_replace(
					[
						'/<signup>/',
						'/<\/signup>/'
					],
					'',
					$menuLogin,1
				);
			$htmlMenu.=$menuLogin;
		}
	}
	$html=preg_replace('~<buildMenu>.*?<\/buildMenu>~is',$htmlMenu,$html,1);
}
if(stristr($html,'<buildSocial')){
	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
	$htmlSocial=$matches[1];
	$socialItems='';
	$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
	if($s->rowCount()>0){
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$buildSocial=$htmlSocial;
			$buildSocial=str_replace([
				'<print sociallink>',
				'<print socialicon>',
				'<print rel=label>'
			],[
				$r['url'],
				frontsvg('libre-social-'.$r['icon']),
				ucfirst($r['icon'])
			],$buildSocial);
			$socialItems.=$buildSocial;
		}
	}else
		$socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
	if($config['options']{9}==1){
		$html=str_replace([
			'<rss>',
			'</rss>'
		],'',$html);
		$html=$page['contentType']=='article'||$page['contentType']=='portfolio'||$page['contentType']=='event'||$page['contentType']=='news'||$page['contentType']=='inventory'||$page['contentType']=='service'?str_replace('<print rsslink>','rss/'.$page['contentType'],$html):str_replace('<print rsslink>','rss',$html);
		$html=str_replace('<print rssicon>',frontsvg('libre-social-rss'),$html);
	}else
		$html=preg_replace('~<rss>.*?<\/rss>~is','',$html,1);
}
if(isset($_GET['activate'])&&$_GET['activate']!=''){
	$activate=filter_input(INPUT_GET,'activate',FILTER_SANITIZE_STRING);
	$sa=$db->prepare("UPDATE `".$prefix."login` SET active='1',activate='',rank='100' WHERE activate=:activate");
	$sa->execute([':activate'=>$activate]);
	$html=$sa->rowCount()>0?str_replace('<activation>',$theme['settings']['activation_success'],$html):str_replace('<activation>',$theme['settings']['activation_error'],$html);
}else
	$html=str_replace('<activation>','',$html);
$html=preg_replace([
	'/<print config=[\"\']?business[\"\']?>/',
	'/<print config=[\"\']?address[\"\']?>/',
	'/<print config=[\"\']?suburb[\"\']?>/',
	'/<print config=[\"\']?postcode[\"\']?>/',
	'/<print config=[\"\']?country[\"\']?>/',
	'/<print config=[\"\']?email[\"\']?>/',
	'/<print config=[\"\']?phone[\"\']?>/',
	'/<print config=[\"\']?mobile[\"\']?>/'
],[
	htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
	$config['postcode']==0?'':htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),
	$config['phone']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['phone']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8').'</a>':'',
	$config['mobile']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['mobile']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8').'</a>':''
],$html);
$content.=$html;
