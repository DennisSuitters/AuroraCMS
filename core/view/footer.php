<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Footer
 * @package    core/view/footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($_SESSION['rank'])&&$_SESSION['rank']>0)
	$link='<li><a href="logout/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:'').'">Logout</a></li>';
else{
	if($config['options'][3]==1)
		$link_x=' or Sign Up';
	else{
		$link_x='';
		$html=preg_replace('~<block signup>.*?<\/block signup>~is','',$html,1);
	}
	$link='<li><a href="login/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:'').'">Login'.$link_x.'</a></li>';
}
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$html=isset($_SESSION['rank'])&&$_SESSION['rank']>899?str_replace('<administration>','<li><a target="_blank" href="'.$settings['system']['admin'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:'').'">Administration</a></li>',$html):str_replace('<administration>','',$html);
if(stristr($html,'<hours>')){
	if($config['options'][19]==1){
		preg_match('/<buildHours>([\w\W]*?)<\/buildHours>/',$html,$matches);
		$htmlHours=$matches[1];
		$hoursItems='';
		$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='hours'");
		if($s->rowCount()>0){
			while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$buildHours=$htmlHours;
				if($r['tis']!=0){
					$r['tis']=str_pad($r['tis'],4,'0',STR_PAD_LEFT);
					if($config['options'][21]==1)
						$hourFrom=$r['tis'];
					else{
						$hourFromH=substr($r['tis'],0,2);
						$hourFromM=substr($r['tis'],3,4);
						$hourFrom=($hourFromH < 12 ? ltrim($hourFromH,'0') . ($hourFromM > 0 ? $hourFromM : '' ).'am' : $hourFromH - 12 . ($hourFromM > 0 ? $hourFromM : '') . 'pm');
					}
				}else
					$hourFrom='';
				if($r['tie']!=0){
					$r['tie']=str_pad($r['tie'],4,'0',STR_PAD_LEFT);
					if($config['options'][21]==1)
						$hourTo=$r['tie'];
					else{
						$hourToH=substr($r['tie'],0,2);
						$hourToM=substr($r['tie'],3,4);
						$hourTo=($hourToH < 12 ? ltrim($hourToH,'0') . ($hourToM > 0 ? $hourToM : '') . 'am' : $hourToH - 12 . ($hourToM > 0 ? $hourToM: '') . 'pm');
					}
				}else
					$hourTo='';
				$buildHours=preg_replace([
					'/<print dayfrom>/',
					'/<print dayto>/',
					'/<print timefrom>/',
					'/<print timeto>/',
					'/<print info>/'
				],[
					ucfirst(($config['options'][20]==1?substr($r['username'],0,3):$r['username'])),
					($r['password']==$r['username']?'':'-'.ucfirst(($config['options'][20]==1?substr($r['password'],0,3):$r['password']))),
					$hourFrom,
					($r['tie']>0?'-' . $hourTo : ''),
					($r['title']!=''?ucfirst($r['title']):'')
				],$buildHours);
				$hoursItems.=$buildHours;
			}
		}
		$html=preg_replace([
			'/<[\/]?hours>/',
			'~<buildHours>.*?<\/buildHours>~is'
		],[
			'',
			$hoursItems,
		],$html);
	}else
		$html=preg_replace('~<hours>.*?<\/hours>~is','',$html,1);
}
if(stristr($html,'<email>')){
	if($config['options'][23]==1){
		$html=preg_replace([
			'/<[\/]?email>/',
			'/<print config=[\"\']?email[\"\']?>/'
		],[
			'',
			'<a href="contactus/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:'').'">'.htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8').'</a>'
		],$html);
	}else
		$html=preg_replace('~<email>.*?<\/email>~is','',$html,1);
}
if(stristr($html,'<contact>')){
	if($config['options'][22]==1){
		$html=preg_replace([
			'/<[\/]?contact>/',
			'/<print config=[\"\']?business[\"\']?>/',
			'/<print config=[\"\']?address[\"\']?>/',
			'/<print config=[\"\']?suburb[\"\']?>/',
			'/<print config=[\"\']?postcode[\"\']?>/',
			'/<print config=[\"\']?country[\"\']?>/',
		],[
			'',
			htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
			$config['postcode']==0?'':htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8')
		],$html);
	}else
		$html=preg_replace('~<contact>.*?<\/contact>~is','',$html,1);
}
if(stristr($html,'<phone>')){
	if($config['options'][24]==1){
		$html=preg_replace([
			'/<[\/]?phone>/',
			'/<print config=[\"\']?phone[\"\']?>/',
			'/<print config=[\"\']?mobile[\"\']?>/'
		],[
			'',
			$config['phone']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['phone']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8').'</a>':'',
			$config['mobile']!=''?'<a href="tel:'.htmlspecialchars(str_replace(' ','',$config['mobile']),ENT_QUOTES,'UTF-8').'">'.htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8').'</a>':''
		],$html);
	}else
		$html=preg_replace('~<phone>.*?<\/phone>~is','',$html,1);
}
$html=preg_replace([
	'/<print year>/',
	'/<print config=[\"\']?business[\"\']?>/',
	'/<print theme=[\"\']?title[\"\']?>/',
	'/<print theme=[\"\']?creator[\"\']?>/',
	'/<print theme=[\"\']?creator_url[\"\']?>/',
	'/<print theme=[\"\']?creator_url_title[\"\']?>/',
	'/<login>/',
	'/<print config=[\"\']?seoDescription[\"\']?>/',
	'/<print config=[\"\']?abn[\"\']?>/',
	'/<print hosting>/',
	'/<print honey_pot_link>/',
	'/<print honey_pot_quick_link>/'
],[
	date('Y',time()),
	$config['business'],
	htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator_url_title'],ENT_QUOTES,'UTF-8'),
	$link,
	htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'),
	$config['abn']!=''?htmlspecialchars('ABN '.$config['abn'],ENT_QUOTES,'UTF-8'):'',
	isset($theme['hosting'])&&$theme['hosting']!=''?'Hosting by <a target="_blank" href="'.$theme['hosting_url'].'">'.$theme['hosting'].'</a><br>':'',
	$config['php_options'][0]==1?' Protected by <a href="http://www.projecthoneypot.org?rf=113735"><img src="layout/'.$config['theme'].'/images/phpot.gif" alt="Stop Spam Harvesters, Join Project Honey Pot"></a><br>':'',
	$config['php_options'][0]==1&&$config['php_options'][2]==1&&$config['php_quicklink']!=''?$config['php_quicklink']:''
],$html);
if(stristr($html,'<subjectText>')){
	$s=$db >prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='subject' ORDER BY `title` ASC");
	$s->execute();
	if($s->rowCount()>0){
		$html=preg_replace([
			'~<subjectText>.*?<\/subjectText>~is',
			'/<[\/]?subjectSelect>/'
		],'',$html);
		$options='';
		while($r=$s->fetch(PDO::FETCH_ASSOC))$options.='<option value="'.$r['id'].'">'.$r['title'].'</option>';
		$html=str_replace('<subjectOptions>',$options,$html);
	}else{
		$html=preg_replace([
			'~<subjectSelect>.*?<\/subjectSelect>~is',
			'/<[\/]?subjectText>/'
		],'',$html);
	}
}
if(stristr($html,'<buildMenu')){
	$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `menu`='footer' AND `mid`=0 AND `active`=1 AND `rank`<=:rank ORDER BY `ord` ASC");
	$s->execute([
		':rank'=>$_SESSION['rank']
	]);
	preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
	$htmlMenu=$matches[1];
	$menu='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$buildMenu=$htmlMenu;
		$buildMenu=$view==$r['contentType']||$view==$r['contentType'].'s'?preg_replace('/<print active=[\"\']?menu[\"\']?>/',' active',$buildMenu):preg_replace('/<print active=[\"\']?menu[\"\']?>/','',$buildMenu);
		if($r['contentType']!='index'){
			if(isset($r['url'][0])&&$r['url'][0]=='#')
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.$r['url'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),$buildMenu);
			elseif(filter_var($r['url'],FILTER_VALIDATE_URL))
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',$r['url'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),$buildMenu);
			elseif($r['contentType']=='page'&&$r['title']!='')
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.strtolower($r['contentType']).'/'.str_replace(' ','-',$r['title']).'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),$buildMenu);
			else
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.$r['contentType'].'/',$buildMenu);
			$buildMenu=preg_replace('/<print rel=[\"\']?contentType[\"\']?>/',strtolower($r['contentType']),$buildMenu);
		}else{
			$buildMenu=preg_replace([
				'/<print menu=[\"\']?url[\"\']?>/',
				'/<print rel=[\"\']?contentType[\"\']?>/'
			],[
				URL.'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
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
	$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=0 ORDER BY `icon` ASC");
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
				frontsvg('i-social-'.$r['icon'])
			],$buildSocial);
			$socialItems.=$buildSocial;
		}
	}else
		$socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
	if($config['options'][9]==1){
		$html=preg_replace('/<[\/]?rss>/','',$html);
		$html=$page['contentType']=='article'||$page['contentType']=='portfolio'||$page['contentType']=='event'||$page['contentType']=='news'||$page['contentType']=='inventory'||$page['contentType']=='service'?str_replace('<print rsslink>','rss/'.$page['contentType'].'/',$html):str_replace('<print rsslink>','rss',$html);
		$html=str_replace('<print rssicon>',frontsvg('i-social-rss'),$html);
	}else
		$html=preg_replace('~<rss>.*?<\/rss>~is','',$html,1);
}
if(stristr($html,'<paymentoptions>')){
	if($config['options'][7]==1){
		$html=preg_replace([
			'/<[\/]?paymentoptions>/',
			'/<print theme>/'
		],[
			'',
			THEME
		],$html);
	}else
		$html=preg_replace('~<paymentoptions>.*?<\/paymentoptions>~is','',$html,1);
}
if(stristr($html,'<chat')){
	if(isset($_SESSION['rank'])&&$_SESSION['rank']<100){
		if($config['options'][13]==1){
			if($config['options'][14]==1&&$config['messengerFBCode']!='')
				$html=preg_replace('~<chat>.*?<\/chat>~is','',$html,1);
			else{
				$html=preg_replace([
					'/<[\/]?chat>/',
					'/<print sid>/'
				],[
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
