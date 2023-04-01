<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Display More Tracking Items
 * @package    core/more_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function _ago($time){
	if($time==0)$timeDiff='Never';
	else{
		$fromTime=$time;
		$timeDiff=floor(abs(time()-$fromTime)/60);
		if($timeDiff<2)$timeDiff='Just Now';
		elseif($timeDiff>2&&$timeDiff<60)$timeDiff=floor(abs($timeDiff)).' Minutes Ago';
		elseif($timeDiff>60&&$timeDiff<120)$timeDiff=floor(abs($timeDiff/60)).' Hour Ago';
		elseif($timeDiff<1440)$timeDiff=floor(abs($timeDiff/60)).' Hours Ago';
		elseif($timeDiff>1440&&$timeDiff<2880)$timeDiff=floor(abs($timeDiff/1440)).' Day Ago';
		elseif($timeDiff>2880)$timeDiff=floor(abs($timeDiff/1440)).' Days Ago';
	}
	return$timeDiff;
}
function desiminateVisit($u){
  $status='ok';
	if(stristr($u,'aws/'))$status='Suspicious';
  if(stristr($u,'/wp'))$status='Suspicious';
  if(stristr($u,'/wordpress/'))$status='Suspicious';
  if(stristr($u,'old-wp'))$status='Suspicious';
  if(stristr($u,'xmlrpc.php'))$status='Suspicious';
  if(stristr($u,'dup-installer'))$status='Suspicious';
  if(stristr($u,'eval-stdin.php'))$status='Suspicious';
  if(stristr($u,'panels.txt'))$status='Suspicious';
  if(stristr($u,'?author='))$status='Suspicious';
  if(stristr($u,'.php'))$status='Suspicious';
  if(stristr($u,'.asp'))$status='Suspicious';
  if(stristr($u,'.aspx'))$status='Suspicious';
  if(stristr($u,'magento'))$status='Suspicious';
  if(stristr($u,'/modules/'))$status='Suspicious';
  if(stristr($u,'plesk'))$status='Suspicious';
  if(stristr($u,'/system/'))$status='Suspicious';
  if(stristr($u,'/umbraco'))$status='Suspicious';
  if(stristr($u,'/joomla'))$status='Suspicious';
  if(stristr($u,'wp-login'))$status='Suspicious';
	if(stristr($u,'/staging/'))$status='Suspicious';

  return($status=='ok'?'<span class="badger badge-success">OK</span>':'<span class="badger badge-danger">'.$status.'</span>');
}
function deseminateReferer($u){
  if($u==''){
    $out='<span class="badger badge-success">Direct</span>';
  }else{
    $pu=parse_url($u);
		$out=(isset($pu['host'])?$pu['host']:'<small>'.$u.'</small>').'<br>';
    if(stristr($u,'500px'))$out='<i class="i d-inline-table i-3x i-social 500px">social-500px</i><small class="d-flex pt-1 justify-content-center">500px</small>';
    if(stristr($u,'amazon'))$out='<i class="i d-inline-table i-3x i-social amazon">social-amazon</i><small class="d-flex pt-1 justify-content-center">Amazon</small>';
    if(stristr($u,'ahref')||stristr($u,'as16276'))$out='<i class="i d-inline-table i-3x i-social ahrefs">social-ahrefs</i><small class="d-flex pt-1 justify-content-center">AHrefs</small>';
    if(stristr($u,'aws'))$out='<i class="i d-inline-table i-3x i-social amazon">social-amazon</i><small class="d-flex pt-1 justify-content-center">Amazon</small>';
    if(stristr($u,'bing'))$out='<i class="i d-inline-table i-3x i-social bing">social-bing</i><small class="d-flex pt-1 justify-content-center">Bing</small>';
    if(stristr($u,'facebook'))$out='<i class="i d-inline-table i-3x i-social facebook">social-facebook</i><small class="d-flex pt-1 justify-content-center">Facebook</small>';
    if(stristr($u,'fbclid='))$out='<i class="i d-inline-table i-3x i-social facebook">social-facebook</i><small class="d-flex pt-1 justify-content-center">Facebook</small>';
    if(stristr($u,'msclkid='))$out='<i class="i d-inline-table i-3x i-social bing">social-bing</i><small class="d-flex pt-1 justify-content-center">Bing</small>';
    if(stristr($u,'github'))$out='<i class="i d-inline-table i-3x i-social github">social-github</i><small class="d-flex pt-1 justify-content-center">GitHub</small>';
    if(stristr($u,'google'))$out='<i class="i d-inline-table i-3x i-social google">social-google</i><small class="d-flex pt-1 justify-content-center">Google</small>';
    if(stristr($u,'gclid='))$out='<i class="i d-inline-table i-3x i-social google">social-google</i><small class="d-flex pt-1 justify-content-center">Google</small>';
    if(stristr($u,'instagram'))$out='<i class="i d-inline-table i-3x i-social instagram">social-instagram</i><small class="d-flex pt-1 justify-content-center">Instagram</small>';
    if(stristr($u,'duckduckgo'))$out='<i class="i d-inline-table i-3x i-social duckduckgo">social-duckduckgo</i><small class="d-flex pt-1 justify-content-center">DuckDuckGo</small>';
    if(stristr($u,'linkedin'))$out='<i class="i d-inline-table i-3x i-social linkedin">social-linkedin</i><small class="d-flex pt-1 justify-content-center">LinkedIn</small>';
    if(stristr($u,'reddit'))$out='<i class="i d-inline-table i-3x i-social reddit">social-reddit</i><small class="d-flex pt-1 justify-content-center">Reddit</small>';
    if(stristr($u,'telstra')||stristr($u,'as1221'))$out='<i class="i d-inline-table i-3x i-social telstra">social-telstra</i><small class="d-flex pt-1 justify-content-center">Telstra</small>';
    if(stristr($u,'youtube'))$out='<i class="i d-inline-table i-3x i-social youtube">social-youtube</i><small class="d-flex pt-1 justify-content-center">YouTube</small>';
    if(stristr($u,'twitter')||stristr($u,'t.co/'))$out='<i class="i d-inline-table i-3x i-social twitter">social-twitter</i><small class="d-flex pt-1 justify-content-center">Twitter</small>';
  }
	if($u=='Unknown')$out='<span class="badger badge-dark">'.$u.'</span><br>';
  return$out;
}
function getOSIcon($i){
	if(in_array($i,
    ['android',
    'apple',
    'beos',
    'bsd',
    'linux',
    'microsoft',
    'windows7',
    'windows8',
    'windows95',
    'windows98',
    'windows2000',
    'windowsme',
    'windowsvista',
    'windowsxp'],true
  ))return'<i class="i d-inline-table i-3x">os-'.$i.'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>';
  else
    return'<i class="i d-inline-table i-3x i-color-muted">os-general</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>';
}
function getBrowser($ua){
  $b='Unknown';
  $ba=[
    '/alexa/i'=>'Alexa',
    '/amaya/i'=>'Amaya',
    '/arora/i'=>'Arora',
    '/askjeeves/i'=>'AskJeeves',
    '/avant browser/i'=>'AvantBrowser',
    '/baidu/i'=>'Baiduspider',
    '/beamrise/i'=>'Beamrise',
    '/bingbot/i'=>'Bing',
    '/bolt/i'=>'BOLT',
    '/brave/i'=>'Brave',
    '/camino/i'=>'Camino',
    '/chimera/i'=>'Chimera',
    '/chrome/i'=>'Chrome',
    '/dillo/i'=>'Dillo',
    '/duckduckbot/i'=>'DuckDuckGo',
    '/edg/i'=>'Edge',
    '/epiphany/i'=>'Epiphany',
    '/eudoraWeb/i'=>'EudoraWeb',
    '/exabot/i'=>'Exabot',
    '/explorer/i'=>'Explorer',
    '/facebook/i'=>'Facebook',
    '/fastcrawler/i'=>'FastCrawler',
    '/firebird/i'=>'Firebird',
    '/firefox/i'=>'Firefox',
    '/galeon/i'=>'Galeon',
    '/geohasher/i'=>'GeoHasher',
    '/gigablast/i'=>'Gigablast',
    '/googlebot/i'=>'Google',
    '/hotjava/i'=>'HotJava',
    '/ibrowse/i'=>'IBrowse',
    '/icab/i'=>'iCab',
    '/iceape/i'=>'Iceape',
    '/iceweasel/i'=>'Iceweasel',
    '/infoseek/i'=>'InfoSeek',
    '/itunes/i'=>'iTunes',
    '/kindle/i'=>'Kindle',
    '/konqueror/i'=>'Konqueror',
    '/lynx/i'=>'Lynx',
    '/links/i'=>'Links',
    '/lycos/i'=>'Lycos',
    '/maxthon/i'=>'Maxthon',
    '/midori/i'=>'Midori',
    '/mobile/i'=>'Mobile',
    '/msie/i'=>'Explorer',
    '/msnbot/i'=>'MSN',
    '/namoroka/i'=>'Namoroka',
    '/netscape/i'=>'Netscape',
    '/netsurf/i'=>'NetSurf',
    '/omniWeb/i'=>'OmniWeb',
    '/opera/i'=>'Opera',
    '/opr/i'=>'Opera',
    '/phoenix/i'=>'Phoenix',
    '/qupzilla/i'=>'QupZilla',
    '/safari/i'=>'Safari',
    '/seamonkey/i'=>'Sea Monkey',
    '/shadowfox/i'=>'ShadowFox',
    '/shiira/i'=>'Shiira',
    '/silk/i'=>'Silk',
    '/slurp/i'=>'Inktomi',
    '/sogou/i'=>'Sogou',
    '/spinn3r/i'=>'Spinn3r',
    '/swiftfox/i'=>'Swiftfox',
    '/trident\/7.0/i'=>'Explorer',
    '/ucbrowser/i'=>'UCBrowser',
    '/uzbl/i'=>'Uzbl',
    '/vivaldi/i'=>'Vivaldi',
    '/wosbrowser/i'=>'wOSBrowser',
    '/yahoo/i'=>'Yahoo',
    '/yandex/i'=>'Yandex'
  ];
  foreach($ba as$r=>$v){
    if(preg_match($r,$ua)){
      $b=$v;
      break;
    }
  }
  return$b;
}
function getBrowserIcon($i){
	if(in_array($i,
    ['brave',
    'chrome',
    'edge',
    'explorer',
    'firefox',
    'opera',
    'safari'],true))return'<i class="i d-inline-table i-3x">browser-'.$i.'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>';
  else
    return'<i class="i d-inline-table i-3x i-color-muted">browser-general</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>';
}
function getDevice($ua){
  $osd='Unknown';
  $osa=[
    '/android/i'=>'Android',
    '/blackberry/i'=>'BlackBerry',
    '/ipad/i'=>'iPad',
    '/iphone/i'=>'iPhone',
    '/ipod/i'=>'iPod',
    '/iphone/i'=>'iPhone',
    '/nokia/i'=>'Nokia',
    '/webos/i'=>'Mobile',
  ];
  foreach($osa as$r=>$v){
    if(preg_match($r,$ua)){
      $osd=$v;
      break;
    }
  }
  return$osd;
}
function getDeviceIcon($i,$w){
	if($i!=''&&$i!='unknown'&&in_array($i,
    ['android',
    'desktop',
    'ipad',
    'iphone',
    'laptop',
    'mobile',
    'smartwatch',
    'tablet',
    'television'
    ],true))
    return'<i class="i d-inline-table i-3x">tech-'.$i.'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>'.(is_numeric($w)?'<span class="m-0 p-0" style="font-size:9px">'.$w.'</span><br>':'');
  else
    return'<i class="i d-inline-table i-3x i-color-muted">tech-unknown</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>'.(is_numeric($w)?'<span class="m-0 p-0" style="font-size:9px">'.$w.'</span><br>':'');
}
function getLocationInfoByIp($ip){
  $result=array(
    'countryCode'=>'',
    'countryName'=>'',
    'city'=>'',
    'region'=>'',
    'regionCode'=>''
  );
  if($ip=='127.0.0.1'){
    $result['countryCode']='localhost';
    $result['countryName']='localhost';
    $result['city']='dev';
    $result['region']='dev';
    $result['regionCode']='dev';
  }else{
    $ip_data=@json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
    if($ip_data && $ip_data->geoplugin_countryName!=null){
      $result['countryName']=$ip_data->geoplugin_countryName;
      $result['countryCode']=$ip_data->geoplugin_countryCode;
      $result['city']=$ip_data->geoplugin_city;
      $result['region']=$ip_data->geoplugin_region;
      $result['regionCode']=$ip_data->geoplugin_regionCode;
    }
  }
  return$result;
}
function getIspInfo($ip){
	$ipi=file_get_contents("https://ipinfo.io/".$ip);
	$ipij=json_decode($ipi,true);
	return$ipij;
}
function country2flag($countryCode){
	$code=strtoupper($code);
	if($code=='AD')return'🇦🇩';
	if($code=='AE')return'🇦🇪';
	if($code=='AF')return'🇦🇫';
	if($code=='AG')return'🇦🇬';
	if($code=='AI')return'🇦🇮';
	if($code=='AL')return'🇦🇱';
	if($code=='AM')return'🇦🇲';
	if($code=='AO')return'🇦🇴';
	if($code=='AQ')return'🇦🇶';
	if($code=='AR')return'🇦🇷';
	if($code=='AS')return'🇦🇸';
	if($code=='AT')return'🇦🇹';
	if($code=='AU')return'🇦🇺';
	if($code=='AW')return'🇦🇼';
	if($code=='AX')return'🇦🇽';
	if($code=='AZ')return'🇦🇿';
	if($code=='BA')return'🇧🇦';
	if($code=='BB')return'🇧🇧';
	if($code=='BD')return'🇧🇩';
	if($code=='BE')return'🇧🇪';
	if($code=='BF')return'🇧🇫';
	if($code=='BG')return'🇧🇬';
	if($code=='BH')return'🇧🇭';
	if($code=='BI')return'🇧🇮';
	if($code=='BJ')return'🇧🇯';
	if($code=='BL')return'🇧🇱';
	if($code=='BM')return'🇧🇲';
	if($code=='BN')return'🇧🇳';
	if($code=='BO')return'🇧🇴';
	if($code=='BQ')return'🇧🇶';
	if($code=='BR')return'🇧🇷';
	if($code=='BS')return'🇧🇸';
	if($code=='BT')return'🇧🇹';
	if($code=='BV')return'🇧🇻';
	if($code=='BW')return'🇧🇼';
	if($code=='BY')return'🇧🇾';
	if($code=='BZ')return'🇧🇿';
	if($code=='CA')return'🇨🇦';
	if($code=='CC')return'🇨🇨';
	if($code=='CD')return'🇨🇩';
	if($code=='CF')return'🇨🇫';
	if($code=='CG')return'🇨🇬';
	if($code=='CH')return'🇨🇭';
	if($code=='CI')return'🇨🇮';
	if($code=='CK')return'🇨🇰';
	if($code=='CL')return'🇨🇱';
	if($code=='CM')return'🇨🇲';
	if($code=='CN')return'🇨🇳';
	if($code=='CO')return'🇨🇴';
	if($code=='CR')return'🇨🇷';
	if($code=='CU')return'🇨🇺';
	if($code=='CV')return'🇨🇻';
	if($code=='CW')return'🇨🇼';
	if($code=='CX')return'🇨🇽';
	if($code=='CY')return'🇨🇾';
	if($code=='CZ')return'🇨🇿';
	if($code=='DE')return'🇩🇪';
	if($code=='DJ')return'🇩🇯';
	if($code=='DK')return'🇩🇰';
	if($code=='DM')return'🇩🇲';
	if($code=='DO')return'🇩🇴';
	if($code=='DZ')return'🇩🇿';
	if($code=='EC')return'🇪🇨';
	if($code=='EE')return'🇪🇪';
	if($code=='EG')return'🇪🇬';
	if($code=='EH')return'🇪🇭';
	if($code=='ER')return'🇪🇷';
	if($code=='ES')return'🇪🇸';
	if($code=='ET')return'🇪🇹';
	if($code=='FI')return'🇫🇮';
	if($code=='FJ')return'🇫🇯';
	if($code=='FK')return'🇫🇰';
	if($code=='FM')return'🇫🇲';
	if($code=='FO')return'🇫🇴';
	if($code=='FR')return'🇫🇷';
	if($code=='GA')return'🇬🇦';
	if($code=='GB')return'🇬🇧';
	if($code=='GD')return'🇬🇩';
	if($code=='GE')return'🇬🇪';
	if($code=='GF')return'🇬🇫';
	if($code=='GG')return'🇬🇬';
	if($code=='GH')return'🇬🇭';
	if($code=='GI')return'🇬🇮';
	if($code=='GL')return'🇬🇱';
	if($code=='GM')return'🇬🇲';
	if($code=='GN')return'🇬🇳';
	if($code=='GP')return'🇬🇵';
	if($code=='GQ')return'🇬🇶';
	if($code=='GR')return'🇬🇷';
	if($code=='GS')return'🇬🇸';
	if($code=='GT')return'🇬🇹';
	if($code=='GU')return'🇬🇺';
	if($code=='GW')return'🇬🇼';
	if($code=='GY')return'🇬🇾';
	if($code=='HK')return'🇭🇰';
	if($code=='HM')return'🇭🇲';
	if($code=='HN')return'🇭🇳';
	if($code=='HR')return'🇭🇷';
	if($code=='HT')return'🇭🇹';
	if($code=='HU')return'🇭🇺';
	if($code=='ID')return'🇮🇩';
	if($code=='IE')return'🇮🇪';
	if($code=='IL')return'🇮🇱';
	if($code=='IM')return'🇮🇲';
	if($code=='IN')return'🇮🇳';
	if($code=='IO')return'🇮🇴';
	if($code=='IQ')return'🇮🇶';
	if($code=='IR')return'🇮🇷';
	if($code=='IS')return'🇮🇸';
	if($code=='IT')return'🇮🇹';
	if($code=='JE')return'🇯🇪';
	if($code=='JM')return'🇯🇲';
	if($code=='JO')return'🇯🇴';
	if($code=='JP')return'🇯🇵';
	if($code=='KE')return'🇰🇪';
	if($code=='KG')return'🇰🇬';
	if($code=='KH')return'🇰🇭';
	if($code=='KI')return'🇰🇮';
	if($code=='KM')return'🇰🇲';
	if($code=='KN')return'🇰🇳';
	if($code=='KP')return'🇰🇵';
	if($code=='KR')return'🇰🇷';
	if($code=='KW')return'🇰🇼';
	if($code=='KY')return'🇰🇾';
	if($code=='KZ')return'🇰🇿';
	if($code=='LA')return'🇱🇦';
	if($code=='LB')return'🇱🇧';
	if($code=='LC')return'🇱🇨';
	if($code=='LI')return'🇱🇮';
	if($code=='LK')return'🇱🇰';
	if($code=='LR')return'🇱🇷';
	if($code=='LS')return'🇱🇸';
	if($code=='LT')return'🇱🇹';
	if($code=='LU')return'🇱🇺';
	if($code=='LV')return'🇱🇻';
	if($code=='LY')return'🇱🇾';
	if($code=='MA')return'🇲🇦';
	if($code=='MC')return'🇲🇨';
	if($code=='MD')return'🇲🇩';
	if($code=='ME')return'🇲🇪';
	if($code=='MF')return'🇲🇫';
	if($code=='MG')return'🇲🇬';
	if($code=='MH')return'🇲🇭';
	if($code=='MK')return'🇲🇰';
	if($code=='ML')return'🇲🇱';
	if($code=='MM')return'🇲🇲';
	if($code=='MN')return'🇲🇳';
	if($code=='MO')return'🇲🇴';
	if($code=='MP')return'🇲🇵';
	if($code=='MQ')return'🇲🇶';
	if($code=='MR')return'🇲🇷';
	if($code=='MS')return'🇲🇸';
	if($code=='MT')return'🇲🇹';
	if($code=='MU')return'🇲🇺';
	if($code=='MV')return'🇲🇻';
	if($code=='MW')return'🇲🇼';
	if($code=='MX')return'🇲🇽';
	if($code=='MY')return'🇲🇾';
	if($code=='MZ')return'🇲🇿';
	if($code=='NA')return'🇳🇦';
	if($code=='NC')return'🇳🇨';
	if($code=='NE')return'🇳🇪';
	if($code=='NF')return'🇳🇫';
	if($code=='NG')return'🇳🇬';
	if($code=='NI')return'🇳🇮';
	if($code=='NL')return'🇳🇱';
	if($code=='NO')return'🇳🇴';
	if($code=='NP')return'🇳🇵';
	if($code=='NR')return'🇳🇷';
	if($code=='NU')return'🇳🇺';
	if($code=='NZ')return'🇳🇿';
	if($code=='OM')return'🇴🇲';
	if($code=='PA')return'🇵🇦';
	if($code=='PE')return'🇵🇪';
	if($code=='PF')return'🇵🇫';
	if($code=='PG')return'🇵🇬';
	if($code=='PH')return'🇵🇭';
	if($code=='PK')return'🇵🇰';
	if($code=='PL')return'🇵🇱';
	if($code=='PM')return'🇵🇲';
	if($code=='PN')return'🇵🇳';
	if($code=='PR')return'🇵🇷';
	if($code=='PS')return'🇵🇸';
	if($code=='PT')return'🇵🇹';
	if($code=='PW')return'🇵🇼';
	if($code=='PY')return'🇵🇾';
	if($code=='QA')return'🇶🇦';
	if($code=='RE')return'🇷🇪';
	if($code=='RO')return'🇷🇴';
	if($code=='RS')return'🇷🇸';
	if($code=='RU')return'🇷🇺';
	if($code=='RW')return'🇷🇼';
	if($code=='SA')return'🇸🇦';
	if($code=='SB')return'🇸🇧';
	if($code=='SC')return'🇸🇨';
	if($code=='SD')return'🇸🇩';
	if($code=='SE')return'🇸🇪';
	if($code=='SG')return'🇸🇬';
	if($code=='SH')return'🇸🇭';
	if($code=='SI')return'🇸🇮';
	if($code=='SJ')return'🇸🇯';
	if($code=='SK')return'🇸🇰';
	if($code=='SL')return'🇸🇱';
	if($code=='SM')return'🇸🇲';
	if($code=='SN')return'🇸🇳';
	if($code=='SO')return'🇸🇴';
	if($code=='SR')return'🇸🇷';
	if($code=='SS')return'🇸🇸';
	if($code=='ST')return'🇸🇹';
	if($code=='SV')return'🇸🇻';
	if($code=='SX')return'🇸🇽';
	if($code=='SY')return'🇸🇾';
	if($code=='SZ')return'🇸🇿';
	if($code=='TC')return'🇹🇨';
	if($code=='TD')return'🇹🇩';
	if($code=='TF')return'🇹🇫';
	if($code=='TG')return'🇹🇬';
	if($code=='TH')return'🇹🇭';
	if($code=='TJ')return'🇹🇯';
	if($code=='TK')return'🇹🇰';
	if($code=='TL')return'🇹🇱';
	if($code=='TM')return'🇹🇲';
	if($code=='TN')return'🇹🇳';
	if($code=='TO')return'🇹🇴';
	if($code=='TR')return'🇹🇷';
	if($code=='TT')return'🇹🇹';
	if($code=='TV')return'🇹🇻';
	if($code=='TW')return'🇹🇼';
	if($code=='TZ')return'🇹🇿';
	if($code=='UA')return'🇺🇦';
	if($code=='UG')return'🇺🇬';
	if($code=='UM')return'🇺🇲';
	if($code=='US')return'🇺🇸';
	if($code=='UY')return'🇺🇾';
	if($code=='UZ')return'🇺🇿';
	if($code=='VA')return'🇻🇦';
	if($code=='VC')return'🇻🇨';
	if($code=='VE')return'🇻🇪';
	if($code=='VG')return'🇻🇬';
	if($code=='VI')return'🇻🇮';
	if($code=='VN')return'🇻🇳';
	if($code=='VU')return'🇻🇺';
	if($code=='WF')return'🇼🇫';
	if($code=='WS')return'🇼🇸';
	if($code=='XK')return'🇽🇰';
	if($code=='YE')return'🇾🇪';
	if($code=='YT')return'🇾🇹';
	if($code=='ZA')return'🇿🇦';
	if($code=='ZM')return'🇿🇲';
	if($code=='LOCALHOST')return'🏴‍☠️';
	return'🏴‍☠️';
}
$t=filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$c=filter_input(INPUT_GET,'c',FILTER_UNSAFE_RAW);
$b=filter_input(INPUT_GET,'b',FILTER_UNSAFE_RAW);
$s=$db->prepare("SELECT *, MAX(`ti`) AS `cti`, COUNT(`ip`) AS `v` FROM `".$prefix."tracker` GROUP BY `ip` ORDER BY `cti` DESC LIMIT $c,20");
$s->execute();
$c=$c+$c;
$trackercnt=$s->rowCount();
$cnt=$s->rowCount();
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['countryName']==''){
			$result=getLocationInfoByIp($r['ip']);
			$sc=$db->prepare("UPDATE `".$prefix."tracker` SET `countryName`=:cN,`countryCode`=:cC,`city`=:c,`region`=:r,`regionCode`=:rC WHERE `ip`=:ip");
			$sc->execute([
				':cN'=>$result['countryName'],
				':cC'=>$result['countryCode'],
				':c'=>$result['city'],
				':r'=>$result['region'],
				':rC'=>$result['regionCode'],
				':ip'=>$r['ip']
			]);
			$r['countryName']=$result['countryName'];
			$r['countryCode']=$result['countryCode'];
			$r['city']=$result['city'];
			$r['region']=$result['region'];
			$r['regionCode']=$result['regionCode'];
		}
		if($r['isp']==''){
			$isp=getIspInfo($r['ip']);
			$r['isp']=$isp['org']==''?'Unknown':$isp['org'];
			$si=$db->prepare("UPDATE `".$prefix."tracker` SET `isp`=:isp WHERE `ip`=:ip");
			$si->execute([
				':isp'=>$r['isp'],
				':ip'=>$r['ip']
			]);
		}
		if($r['browser']==''||$r['browser']=='Unknown'){
		  $r['browser']=getBrowser($r['userAgent']);
		  $sb=$db->prepare("UPDATE `".$prefix."tracker` SET `browser`=:browser WHERE `ip`=:ip");
		  $sb->execute([
		    ':browser'=>$r['browser'],
		    ':ip'=>$r['ip']
		  ]);
		}
		if($r['device']==''||$r['device']=='Unknown'){
		  $r['device']=getDevice($r['userAgent']);
		  $sd=$db->prepare("UPDATE `".$prefix."tracker` SET `device`=:device WHERE `ip`=:ip");
		  $sd->execute([
		    ':device'=>$r['device'],
		    ':ip'=>$r['ip']
		  ]);
		}
    echo'<tr class="small '.(isset($find)&&$find!=''?' findtracker':'').'" data-dbid="'.$r['id'].'" id="l_'.$r['id'].'" data-ip="'.$r['ip'].'">'.
			'<td class="text-center align-middle">'.
				$r['v'].'<br><small>'.date('D M d Y',$r['cti']).'<br>'.date('h:i:s A',$r['cti']).'</small>'.
			'</td>'.
			'<td class="text-center align-middle tracker-status">'.
				($r['status']=='blacklisted'?'<span class="badger badge-dark">Blacklisted</span>':desiminateVisit($r['urlDest'])).
			'</td>'.
			'<td class="text-center align-middle">'.
				($r['isp']!='Unkown'?deseminateReferer($r['isp']):'').deseminateReferer($r['urlFrom']).
			'</td>'.
			'<td class="text-center align-middle">'.
				'<small>'._ago($r['cti']),'</small>'.($r['action']=='Visit Click'||$r['action']=='Call Click'?'<br><span class="badger badge-success">Called from Site</span>':'').
			'</td>'.
			'<td class="align-middle pt-2 text-wrap">'.
				'<div class="mr-2 flag">'.
					country2flag($r['countryCode']).
				'</div>'.
				'<div class="d-inline-block">'.
					'<small>'.($r['countryName']==''?'Unresolved':$r['countryName']).' - <a target="_blank" href="https://dnschecker.org/ip-location.php?ip='.$r['ip'].'">'.$r['ip'].'</a></small>'.
					($r['city']!=''?'<br><small>'.$r['city'].($r['city']!=''&&$r['region']!=''?' - ':'').$r['region'].'</small>':'<br>').
					($r['isp']!='Unknown'?'<br><small>'.$r['isp'].'</small>':'').
				'</div>'.
			'</td>'.
			'<td class="text-center align-middle">'.
				'<div class="d-inline-block justify-content-center p-1 mr-1">'.
					getOSIcon(strtolower($r['os'])).
				'</div>'.
			'</td>'.
			'<td class="text-center align-middle">'.
				'<div class="d-inline-block justify-content-center p-1 ml-1">'.
          getBrowserIcon(strtolower($r['browser'])).
				'</div>'.
			'</td>'.
			'<td class="text-center align-middle">'.
      	getDeviceIcon(strtolower($r['device']),$r['viewportwidth']).
			'</td>'.
			'<td class="align-middle">'.
				'<div class="btn-group float-right">'.
					'<button data-fancybox data-type="ajax" data-src="core/layout/pathviewer.php?id='.$r['id'].'" data-tooltip="left" aria-label="View Visitor Path"><i class="i">seo-path</i></button>';
if($config['php_options'][0]==1){
						echo'<a class="btn" target="_blank" href="https://www.projecthoneypot.org/ip_'.$r['ip'].'" role="button" data-tooltip="left" aria-label="Lookup IP using Project Honey Pot (Opens in New Page)"><i class="i">brand-projecthoneypot</i></a>';
}
					echo($r['status']!='blacklisted'?'<button class="btn" data-btnip="'.$r['ip'].'" data-tooltip="left" aria-label="Add to Blacklist" onclick="trackertoblacklist(`'.$r['ip'].'`);"><i class="i">blacklist-add</i></button>':'').
					'<button class="trash" data-tooltip="left" aria-label="Remove all of this IP" onclick="purge(`'.$r['ip'].'`,`clearip`);"><i class="i">trash</i></button>'.
				'</div>'.
			'</td>'.
		'</tr>';
  }
	if($cnt>19&&$b==''){
      echo'<tr id="more_'.$c.'">'.
            '<td colspan="9">'.
              '<div class="form-row load-more justify-content-center">'.
                '<button class="btn-block btn-more" onclick="more(`tracker`,`'.$c.'`,`'.$b.'`);">More</button>'.
              '</div>'.
            '</td>'.
          '</tr>';
	}
}else echo'nomore';
