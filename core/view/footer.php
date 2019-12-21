<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Footer
 * @package    core/view/footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Make sure all links end with /
 * @changes    v0.0.5 Add parsing Live Chat markup.
 * @changes    v0.0.6 Fix Doubling up of the Embedded Messaging.
 * @changes    v0.0.9 Add Payment Options Display Parsing.
 */
if(isset($_SESSION['rank'])&&$_SESSION['rank']>0)
	$link='<li><a href="logout/">Logout</a></li>';
else{
	if($config['options']{3}==1)
		$link_x=' or Sign Up';
	else{
		$link_x='';
		$html=preg_replace('~<block signup>.*?<\/block signup>~is','',$html,1);
	}
	$link='<li><a href="login/">Login'.$link_x.'</a></li>';
}
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$html=isset($_SESSION['rank'])&&$_SESSION['rank']>899?str_replace('<administration>','<li><a target="_blank" href="'.$settings['system']['admin'].'/">Administration</a></li>',$html):str_replace('<administration>','',$html);
$html=preg_replace([
	'/<print year>/',
	'/<print theme=[\"\']?title[\"\']?>/',
	'/<print theme=[\"\']?creator[\"\']?>/',
	'/<print theme=[\"\']?creator_url[\"\']?>/',
	'/<print theme=[\"\']?creator_url_title[\"\']?>/',
	'/<login>/',
	'/<print config=[\"\']?seoDescription[\"\']?>/',
	'/<print config=[\"\']?business[\"\']?>/',
	'/<print config=[\"\']?abn[\"\']?>/',
	'/<print config=[\"\']?address[\"\']?>/',
	'/<print config=[\"\']?suburb[\"\']?>/',
	'/<print config=[\"\']?postcode[\"\']?>/',
	'/<print config=[\"\']?country[\"\']?>/',
	'/<print config=[\"\']?email[\"\']?>/',
	'/<print config=[\"\']?phone[\"\']?>/',
	'/<print config=[\"\']?mobile[\"\']?>/',
	'/<print hosting>/',
	'/<print honey_pot_link>/',
	'/<print honey_pot_quick_link>/'
],[
	date('Y',time()),
	htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator_url_title'],ENT_QUOTES,'UTF-8'),
	$link,
	htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
	$config['abn']!=''?htmlspecialchars('ABN '.$config['abn'],ENT_QUOTES,'UTF-8'):'',
	htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars(str_replace(' ','',$config['phone']),ENT_QUOTES,'UTF-8'),
	htmlspecialchars(str_replace(' ','',$config['mobile']),ENT_QUOTES,'UTF-8'),
	isset($theme['hosting'])&&$theme['hosting']!=''?'Hosting by <a target="_blank" href="'.$theme['hosting_url'].'">'.$theme['hosting'].'</a><br>':'',
	$config['php_options']{0}==1?' Protected by <a href="http://www.projecthoneypot.org?rf=113735"><img src="'.URL.'layout/'.$config['theme'].'/images/phpot.gif" alt="Stop Spam Harvesters, Join Project Honey Pot"></a><br>':'',
	$config['php_options']{0}==1&&$config['php_options']{2}==1&&$config['php_quicklink']!=''?$config['php_quicklink']:''
],$html);
if(stristr($html,'<subjectText>')){
	$s=$db >prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
	$s->execute();
	if($s->rowCount()>0){
		$html=preg_replace([
			'~<subjectText>.*?<\/subjectText>~is',
			'/<subjectSelect>/',
			'/<\/subjectSelect>/'
		],'',$html);
		$options='';
		while($r=$s->fetch(PDO::FETCH_ASSOC))
			$options.='<option value="'.$r['id'].'">'.$r['title'].'</option>';
		$html=str_replace('<subjectOptions>',$options,$html);
	}else{
		$html=preg_replace([
			'~<subjectSelect>.*?<\/subjectSelect>~is',
			'/<subjectText>/',
			'/<\/subjectText>/'
		],'',$html);
	}
}
if(stristr($html,'<buildMenu')){
	$s=$db->query("SELECT * FROM `".$prefix."menu` WHERE menu='footer' AND mid=0 AND active=1 ORDER BY ord ASC");
	preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
	$htmlMenu=$matches[1];
	$menu='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$buildMenu=$htmlMenu;
/*		if($r['contentType']=='page'&&$r['title']==$activeTitle)
			$buildMenu=preg_replace('/<print active=[\"\']?menu[\"\']?>/',' active',$buildMenu);
		else */
		if($view==$r['contentType']||$view==$r['contentType'].'s')
			$buildMenu=preg_replace('/<print active=[\"\']?menu[\"\']?>/',' active',$buildMenu);
		else
			$buildMenu=preg_replace('/<print active=[\"\']?menu[\"\']?>/','',$buildMenu);
		if($r['contentType']!='index'){
			if(isset($r['url'][0])&&$r['url'][0]=='#')
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.$r['url'].'/',$buildMenu);
			elseif(filter_var($r['url'],FILTER_VALIDATE_URL))
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',$r['url'].'/',$buildMenu);
			elseif($r['contentType']=='page'&&$r['title']!='')
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.strtolower($r['contentType']).'/'.str_replace(' ','-',$r['title']).'/',$buildMenu);
			else
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.$r['contentType'].'/',$buildMenu);
			$buildMenu=preg_replace('/<print rel=[\"\']?contentType[\"\']?>/',strtolower($r['contentType']),$buildMenu);
		}else{
			$buildMenu=preg_replace([
				'/<print menu=[\"\']?url[\"\']?>/',
				'/<print rel=[\"\']?contentType[\"\']?>/'
			],[
				URL.'/',
				'home'
			],$buildMenu);
		}
		$buildMenu=preg_replace('/<print menu=[\"\']?title[\"\']?>/',$r['title'],$buildMenu);
		$buildMenu=$r['contentType']=='cart'?str_replace('<menuCart>',$cart,$buildMenu):str_replace('<menuCart>','',$buildMenu);
		$menu.=$buildMenu;
	}
	$html=preg_replace([
		'/<buildMenu>/',
		'~<buildMenu>.*?<\/buildMenu>~is'
	],[
		$menu.'<buildMenu>',
		''
	],$html);
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
				'<print rel=label>',
				'<print socialicon>'
			],[
				$r['url'],
				ucfirst($r['icon']),
				frontsvg('libre-social-'.$r['icon'])
			],$buildSocial);
			$socialItems.=$buildSocial;
		}
	}else$socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
	if($config['options']{9}==1){
		$html=str_replace([
			'<rss>',
			'</rss>'
		],'',$html);
		$html=$page['contentType']=='article'||$page['contentType']=='portfolio'||$page['contentType']=='event'||$page['contentType']=='news'||$page['contentType']=='inventory'||$page['contentType']=='service'?str_replace('<print rsslink>','rss/'.$page['contentType'].'/',$html):str_replace('<print rsslink>','rss',$html);
		$html=str_replace('<print rssicon>',frontsvg('libre-social-rss'),$html);
	}else
		$html=preg_replace('~<rss>.*?<\/rss>~is','',$html,1);
}
if(stristr($html,'<paymentoptions>')){
	if($config['options']{7}==1)
		$html=preg_replace('/<\/paymentoptions>/','',$html,1);
	else
		$html=preg_replace('~<paymentoptions>.*?<\/paymentoptions>~is','',$html,1);
}
if(stristr($html,'<chat')){
	if(isset($_SESSION['rank'])&&$_SESSION['rank']<100){
		if($config['options']{13}==1){
			if($config['options']{14}==1&&$config['messengerFBCode']!=''){
				$html=preg_replace('~<chat>.*?<\/chat>~is','',$html,1);
			}else{
				$html=preg_replace([
					'/<chat>/',
					'/<\/chat>/',
					'/<print sid>/'
				],[
					'',
					'',
					SESSIONID
				],$html);
			}
		}else
			$html=preg_replace('~<chat>.*?<\/chat>~is','',$html,1);
	}else
		$html=preg_replace('~<chat>.*?<\/chat>~is','',$html,1);
}
$content.=$html;
