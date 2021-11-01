<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Footer
 * @package    core/view/footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'inc-hours.php';
$html=preg_replace([
	'~<block signup>.*?<\/block signup>~is',
	'/<administration>/',
	'/<login>/',
	($config['options'][27]==1&&$config['geo_position']!=''&&$config['mapapikey']!=''?'/<\/map>/':'~<map>.*?<\/map>~is'),
	'/<map>/',
	stristr($html,'<email>')&&$config['options'][23]==1?'/<[\/]?email>/':'~<email>.*?<\/email>~is',
	stristr($html,'<contact>')&&$config['options'][22]==1?'/<[\/]?contact>/':'~<contact>.*?<\/contact>~is',
	stristr($html,'<phone>')&&$config['options'][24]==1?'/<[\/]?phone>/':'~<phone>.*?<\/phone>~is',
	$config['options'][22]==1||$config['options'][24]==1?'/<[\/]?address>/':'~<address>.*?<\/address>~is',
	$config['options'][7]==1?'/<[\/]?paymentoptions>/':'~<paymentoptions>.*?<\/paymentoptions>~is',
	$config['payPalClientID']==''&&$config['stripe_publishkey']==''&&$config['options'][16]==0?'~<paymentoptions>.*?<\/paymentoptions>~is':'/<[\/]?paymentoptions>/',
	'/<print config=[\"\']?email[\"\']?>/',
	'/<print config=[\"\']?business[\"\']?>/',
	'/<print config=[\"\']?address[\"\']?>/',
	'/<print config=[\"\']?suburb[\"\']?>/',
	'/<print config=[\"\']?postcode[\"\']?>/',
	'/<print config=[\"\']?country[\"\']?>/',
	'/<print config=[\"\']?phone[\"\']?>/',
	'/<print config=[\"\']?mobile[\"\']?>/',
	'/<print url>/',
	'/<print year>/',
	'/<print config=[\"\']?business[\"\']?>/',
	'/<print theme=[\"\']?title[\"\']?>/',
	'/<print theme=[\"\']?creator[\"\']?>/',
	'/<print theme=[\"\']?creator_url[\"\']?>/',
	'/<print theme=[\"\']?creator_url_title[\"\']?>/',
	'/<print config=[\"\']?seoDescription[\"\']?>/',
	'/<print config=[\"\']?abn[\"\']?>/',
	'/<print theme="design">/',
	'/<print theme="hosting">/',
	'/<print honey_pot_quick_link>/',
	'/<print theme>/',
	$config['payPalClientID']==''?'~<paypal>.*?</paypal>~is':'/<[\/]?paypal>/',
	$config['options'][16]==0?'~<afterpay>.*?</afterpay>~is':'/<[\/]?afterpay>/',
	$config['stripe_publishkey']==''?'~<creditcards>.*?</creditcards>~is':'/<[\/]?creditcards>/'
],[
	$config['options'][3]==1?'':'',
	isset($_SESSION['rank'])&&$_SESSION['rank']>899?'<li role="menuitem"><a target="_blank" href="'.$settings['system']['admin'].'/">Administration</a></li>':'',
	isset($_SESSION['rank'])&&$_SESSION['rank']>0?'':'<li role="menuitem"><a href="login/">Login'.($config['options'][3]==1?' or Sign Up':'').'</a></li>',
	($config['options'][27]==1&&$config['geo_position']!=''&&$config['mapapikey']!=''?'<script src="core/js/leaflet/leaflet.js"></script><script>var map=L.map("map",{zoomControl:false}).setView(['.$config['geo_position'].'],13);L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='.$config['mapapikey'].'",{attribution:`Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>`,id:"mapbox/streets-v11",tileSize:512,zoomOffset:-1,accessToken:`'.$config['mapapikey'].'`,}).addTo(map);var marker=L.marker(['.$config['geo_position'].'],{draggable:false}).addTo(map);'.($config['business']==''?'':'var popupHtml=`<strong>'.$config['business'].'</strong>'.($config['address']==''?'':'<br><small>'.$config['address'].'<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country'].'</small>').'`;marker.bindPopup(popupHtml,{closeButton:false,closeOnClick:false,closeOnEscapeKey:false,autoClose:false}).openPopup();').'map.dragging.disable();map.touchZoom.disable();map.doubleClickZoom.disable();map.scrollWheelZoom.disable();marker.off("click");</script>':''),
	'',
	'',
	'',
	'',
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
	$_SERVER['REQUEST_URI'],
	date('Y',time()),
	$config['business'],
	htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator_url_title'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'),
	$config['abn']!=''?htmlspecialchars('ABN '.$config['abn'],ENT_QUOTES,'UTF-8'):'',
	'<span>Website Design by <a href="'.$theme['creator_url'].'" rel="noopener no referrer">'.$theme['creator'].'</a></span>',
	isset($theme['hosting'])&&$theme['hosting']!=''?'<span>Hosting by <a target="_blank" href="'.$theme['hosting_url'].'" rel="noopener no referrer">'.$theme['hosting'].'</a></span>':'',
	$config['php_options'][0]==1&&$config['php_options'][2]==1&&$config['php_quicklink']!=''?$config['php_quicklink']:'',
	THEME,
	'',
	'',
	''
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
	$s->execute([':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0]);
	preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
	$htmlMenu=$matches[1];
	$menu='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['contentType']=='cart'&&$config['options'][30]==1&&(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==false))continue;
		$buildMenu=$htmlMenu;
		if($r['contentType']!='index'){
			if(isset($r['url'][0])&&$r['url'][0]=='#')
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.$r['url'].'/',$buildMenu);
			elseif(filter_var($r['url'],FILTER_VALIDATE_URL))
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',$r['url'].'/',$buildMenu);
			elseif($r['contentType']=='page'&&$r['title']!='')
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.strtolower($r['contentType']).'/'.str_replace(' ','-',$r['title']).'/',$buildMenu);
			else
				$buildMenu=preg_replace('/<print menu=[\"\']?url[\"\']?>/',URL.$r['contentType'].'/',$buildMenu);
			$buildMenu=preg_replace([
				'/<print active=[\"\']?menu[\"\']?>/',
				'/<print rel=[\"\']?contentType[\"\']?>/'
			],[
				$page['id']==$r['id']?$theme['settings']['activeClass']:'',
				strtolower($r['contentType'])
			],$buildMenu);
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
require'inc-buildsocial.php';
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
