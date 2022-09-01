<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Footer
 * @package    core/view/footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
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
	'/<print config=[\"\']?state[\"\']?>/',
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
	htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
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
if(stristr($html,'<chat>')){
	if(isset($_SESSION['rank'])&&$_SESSION['rank']<100){
		if($config['options'][13]==1){
			$html=preg_replace('/<chat>/',$config['options'][14]==1&&$config['messengerFBCode']!=''?'':'<div class="chat card icon col-12 col-sm-6 col-md-5 col-lg-4 mr-0 mr-sm-2"><div class="row"><div id="chatHeader" class="card-header py-1"><div class="chat-icon"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 1.1977945,11.7849 c 0,-0.01 0.228478,-0.5695 0.507728,-1.2507 0.27925,-0.6813 0.516078,-1.2606 0.526283,-1.2873 0.01536,-0.04 -0.02166,-0.093 -0.215101,-0.3053 -0.545911,-0.5998 -0.863184,-1.2301 -0.986383,-1.9596 -0.04503,-0.2666 -0.03886,-0.8611 0.01157,-1.1148 0.217334,-1.0931 0.906439,-2.0274 2.007326,-2.7213 0.742642,-0.4681 1.687527,-0.7895 2.681699,-0.9122 0.324022,-0.04 1.277147,-0.04 1.608906,0 1.98101,0.2397 3.5960045,1.2206 4.3432485,2.6379 0.156364,0.2965 0.2274,0.4831 0.304309,0.7991 0.08024,0.3297 0.100873,0.5 0.05854,0.4833 C 12.02829,6.144 11.918744,6.104 11.80248,6.058 11.686216,6.012 11.500027,5.9472 11.388727,5.914 L 11.186364,5.853 11.135084,5.6949 C 10.745551,4.4941 9.3740975,3.4849 7.7156215,3.1787 7.2891215,3.0997 7.0111925,3.076 6.5294935,3.0763 c -0.990966,0 -1.805078,0.1812 -2.620015,0.5815 -1.123826,0.552 -1.85825,1.3993 -2.056221,2.3723 -0.03695,0.1816 -0.03695,0.6875 0,0.869 0.07909,0.3887 0.276016,0.8275 0.512979,1.143 0.645798,0.8597 1.794726,1.5136 3.024104,1.721 0.129182,0.022 0.257155,0.044 0.284384,0.049 0.03381,0.01 0.06271,0.045 0.09114,0.1219 0.06432,0.173 0.192941,0.4103 0.331005,0.6108 0.09801,0.1423 0.117318,0.1841 0.08796,0.1905 -0.05172,0.011 -0.537393,-0.038 -0.79449,-0.081 -0.469136,-0.078 -0.957072,-0.2104 -1.346275,-0.3646 -0.09454,-0.037 -0.179095,-0.064 -0.187901,-0.059 -0.0088,0 -0.605008,0.359 -1.324894,0.7872 -0.719884,0.4282 -1.314417,0.7784 -1.321182,0.7784 -0.0068,0 -0.0123,-0.01 -0.0123,-0.012 z m 10.6276215,-0.4906 -0.61124,-0.3142 -0.187342,0.069 C 9.4084035,11.6418 7.4309985,11.169 6.5464665,9.9777 6.2291725,9.5504 6.0832345,9.1247 6.0832345,8.6265 c 0,-0.6205 0.219039,-1.1141 0.714868,-1.611 0.624969,-0.6264 1.44706,-0.9761 2.449352,-1.042 1.7644935,-0.116 3.3321285,0.7972 3.6984045,2.1545 0.07257,0.2689 0.07212,0.7427 -9.56e-4,1.0152 -0.102403,0.3819 -0.303852,0.7404 -0.583201,1.0381 -0.0812,0.086 -0.142991,0.1711 -0.137316,0.1879 0.0057,0.017 0.05886,0.2842 0.118178,0.5942 0.05932,0.3101 0.113403,0.5823 0.120177,0.6049 0.0068,0.022 0.0037,0.041 -0.0069,0.041 -0.01056,-2e-4 -0.294256,-0.1417 -0.630438,-0.3144 z M 10.005824,10.7289 C 10.606875,10.6579 11.106101,10.479 11.567611,10.169 11.764624,10.0367 12.08061,9.7239 12.202788,9.5404 12.990255,8.3576 12.09778,6.9608 10.31102,6.5797 9.9727215,6.5077 9.1996555,6.5017 8.8430385,6.5677 c -0.975129,0.1819 -1.784604,0.7236 -2.102702,1.407 -0.188148,0.4042 -0.193126,0.888 -0.01332,1.2946 0.441682,0.9988 1.854366,1.6275 3.2788055,1.4594 z M 8.1515265,8.9741 c -0.140061,-0.073 -0.194947,-0.1543 -0.206325,-0.3059 -0.02911,-0.3877 0.44359,-0.5474 0.679029,-0.2294 0.218726,0.2955 -0.144124,0.7063 -0.472704,0.5353 z m 1.217807,0 c -0.350022,-0.1822 -0.218248,-0.6977 0.178336,-0.6977 0.214552,0 0.364059,0.1551 0.364059,0.3778 0,0.1404 -0.07281,0.2513 -0.210684,0.3209 -0.132127,0.067 -0.201899,0.067 -0.331711,0 z m 1.2850595,0.03 c -0.149248,-0.047 -0.24947,-0.1953 -0.249335,-0.369 2.81e-4,-0.3707 0.461397,-0.4967 0.689801,-0.1884 0.06466,0.087 0.06568,0.2808 0.0021,0.3885 -0.08354,0.1415 -0.285132,0.2184 -0.442524,0.1689 z"/></svg></div><i class="i close chat-open" title="Open Live Chat"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 12.85856,9.482625 -1.23573,1.22829 q -0.14144,0.14144 -0.33499,0.14144 -0.19355,0 -0.33499,-0.14144 L 7,6.758065 3.04715,10.710915 q -0.14144,0.14144 -0.33499,0.14144 -0.19355,0 -0.33499,-0.14144 L 1.14144,9.482625 Q 1,9.341185 1,9.143915 1,8.946645 1.14144,8.805205 L 6.66501,3.289075 Q 6.80645,3.147645 7,3.147645 q 0.19355,0 0.33499,0.14143 l 5.52357,5.51613 Q 13,8.946645 13,9.143915 q 0,0.19727 -0.14144,0.33871 z"/></svg></i><i class="i close chat-close d-none" title="Close Live Chat"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 12,10.047142 q 0,0.3367 -0.235692,0.572383 l -1.144783,1.144783 Q 10.383842,12 10.047142,12 9.7104417,12 9.47475,11.764308 L 7,9.289558 4.52525,11.764308 Q 4.2895583,12 3.9528583,12 3.6161583,12 3.380475,11.764308 L 2.2356917,10.619525 Q 2,10.383842 2,10.047142 2,9.710442 2.2356917,9.47475 L 4.7104417,7 2.2356917,4.52525 Q 2,4.2895583 2,3.9528583 2,3.6161583 2.2356917,3.380475 L 3.380475,2.2356917 Q 3.6161583,2 3.9528583,2 4.2895583,2 4.52525,2.2356917 L 7,4.7104417 9.47475,2.2356917 Q 9.7104417,2 10.047142,2 q 0.3367,0 0.572383,0.2356917 L 11.764308,3.380475 Q 12,3.6161583 12,3.9528583 12,4.2895583 11.764308,4.52525 L 9.2895583,7 11.764308,9.47475 Q 12,9.710442 12,10.047142 z"/></svg></i></div></div><div id="chatBody" class="card-body d-block d-none"><input id="chatsid" type="hidden" value="'.SESSIONID.'"><input id="chatwho" type="hidden" value="page"><div class="chathideme"><div class="row"><label for="chatName">Name</label><input id="chatName" type="text" value="" placeholder="Name..." required aria-required="true"><div id="chatNameError" class="alert alert-danger d-none">Name is invalid or empty...</div><label for="chatEmail">Email</label><input id="chatEmail" type="text" value="" placeholder="Email..." required aria-required="true"><div id="chatEmailError" class="alert alert-danger d-none">Email is invalid or empty...</div><button id="startChat" class="btn-block mt-3">Start Chat</button></div></div><div id="chatScreen" class="chatunhideme d-none"></div><div class="chatunhideme d-none"><div class="form-row"><input id="chatMessage" type="text"><button id="chatButton">Send</button></div></div></div></div>',$html);
		}else
			$html=preg_replace('/<chat>/','',$html,1);
	}else
		$html=preg_replace('/<chat>/','',$html,1);
}
$content.=$html;
