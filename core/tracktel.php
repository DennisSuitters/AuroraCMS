<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Track Telephone Clicks
 * @package    core/tracktel.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$ts=isset($_POST['ts'])?$_POST['ts']:0;
$ip=isset($_SERVER['REMOTE_ADDR'])?($_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR']):'127.0.0.1';
if($ts>0){
  $useragent=$_SERVER['HTTP_USER_AGENT'];
  $clienthints=getallheaders();
  $s=$db->prepare("UPDATE `".$prefix."tracker` SET `action`='Visit Click' WHERE `ip`=:ip AND `action`!='Call Click'");
  $s->execute([':ip'=>$ip]);
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."tracker` (`pid`,`urlDest`,`userAgent`,`ip`,`host`,`action`,`browser`,`device`,`viewportwidth`,`os`,`sid`,`ti`) VALUES (:pid,:urlDest,:userAgent,:ip,:host,:action,:browser,:device,:viewportwidth,:os,:sid,:ti)");
  $s->execute([
    ':pid'=>0,
    ':urlDest'=>(isset($_SESSION['current_page'])?$_SESSION['current_page']:''),
    ':userAgent'=>(isset($clienthints['User-Agent'])?$clienthints['User-Agent']:$_SERVER['HTTP_USER_AGENT']),
    ':ip'=>$ip,
    ':host'=>(isset($clienthints['Host'])?$clienthints['Host']:$ip),
    ':action'=>'Call Click',
    ':browser'=>getBrowser($useragent,$clienthints),
    ':device'=>getDevice($useragent,$clienthints),
    ':viewportwidth'=>(isset($clienthints['viewport-width'])?$clienthints['viewport-width']:'N/A'),
    ':os'=>getOS($useragent,$clienthints),
    ':sid'=>session_id(),
    ':ti'=>time()
  ]);
}
function getDevice($ua,$ch){
  $osd='Unknown';
  if(isset($ch['sec-ch-ua-mobile'])){
    $osd=trim($ch['sec-ch-ua-mobile'],'\'"');
    if($osd=='?0')$osd='Desktop';
    if($osd=='?1'){
      $osd='Mobile';
      if(isset($ch['sec-ch-ua-model'])&&$ch['sec-ch-ua-model']!=''){
        $osd=trim($ch['sec-ch-ua-model'],'\'"');
      }
    }
  }else{
    $ua=$_SERVER['HTTP_USER_AGENT'];
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
  }
  return$osd;
}
function getOS($ua,$ch){
  if(isset($ch['sec-ch-ua-platform']))
    $osp=trim($ch['sec-ch-ua-platform'],'\'"');
  else{
    $ua=$_SERVER['HTTP_USER_AGENT'];
    $osp="Unknown";
    $osa=[
      '/android/i'=>'Android',
      '/beos/i'=>'BeOS',
      '/blackberry/i'=>'BlackBerry',
      '/dillo/i'=>'Linux',
      '/dragonFly/i'=>'DragonFlyBSD',
      '/freebsd/i'=>'FreeBSD',
      '/ipad/i'=>'iPad',
      '/iphone/i'=>'iPhone',
      '/ipod/i'=>'iPod',
      '/iphone/i'=>'iPhone',
      '/linux/i'=>'Linux',
      '/mac os x/i'=>'Mac',
      '/mac_powerpc/i'=>'Mac',
      '/macintosh/i'=>'Mac',
      '/netbsd/i'=>'NetBSD',
      '/nokia/i'=>'Nokia',
      '/openbsd/i'=>'OpenBSD',
      '/opensolaris/i'=>'OpenSolaris',
      '/os\/2/i'=>'OS/2',
      '/palmos/i'=>'PalmOS',
      '/rebelmouse/i'=>'RebelMouse',
      '/sunos/i'=>'SunOS',
      '/ubuntu/i'=>'Ubuntu',
      '/unix/i'=>'UNIX',
      '/webos/i'=>'Mobile',
      '/windows nt 10/i'=>'Windows10',
      '/windows nt 6.4/i'=>'Windows10',
      '/windows nt 6.3/i'=>'Windows8.1',
      '/windows nt 6.2/i'=>'Windows8',
      '/windows nt 6.1/i'=>'Windows7',
      '/windows nt 6.0/i'=>'WindowsVista',
      '/windows nt 5.2/i'=>'WindowsXP',
      '/windows nt 5.1/i'=>'WindowsXP',
      '/windows xp/i'=>'WindowsXP',
      '/windows nt 5.01/i'=>'Windows2000',
      '/windows nt 5.0/i'=>'Windows2000',
      '/windows nt 5/i'=>'Windows2000',
      '/windows nt 4.0/i'=>'WindowsNT4.0',
      '/windows nt4.0/i'=>'WindowsNT4.0',
      '/windows nt/i'=>'WindowsNT',
      '/windows me/i'=>'WindowsMe',
      '/win98/i'=>'Windows98',
      '/win95/i'=>'Windows95',
      '/win16/i'=>'Windows16'
    ];
    foreach($osa as$r=>$v){
      if(preg_match($r,$ua)){
        $osp=$v;
        break;
      }
    }
  }
  return$osp;
}
function getBrowser($ua,$ch){
  $b='Unknown';
  if(isset($ch['sec-ch-ua']))$ua=$ch['sec-ch-ua'];
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
