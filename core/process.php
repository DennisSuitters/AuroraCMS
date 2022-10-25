<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Process Pages
 * @package    core/process.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/db.php';
if(isset($headerType))header($headerType);
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
if(file_exists(THEME.'/theme.ini'))$theme=parse_ini_file(THEME.'/theme.ini',TRUE);
else{
  echo'A Website Theme has not been set.';
  die();
}
$ip=isset($_SERVER['REMOTE_ADDR'])?($_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR']):'127.0.0.1';
$ti=time();
$show=$html=$head=$content=$foot='';
$css=THEME.'/css/';
$favicon=FAVICON;
if(file_exists(THEME.'/images/favicon-512.png'))
	$shareImage=URL.THEME.'/images/favicon-512.png';
elseif(file_exists(THEME.'/images/favicon-512.gif'))
	$shareImage=URL.THEME.'/images/favicon-512.gif';
elseif(file_exists(THEME.'/images/favicon-512.jpg'))
	$shareImage=URL.THEME.'/images/favicon-512.jpg';
elseif(file_exists(THEME.'/images/favicon-512.ico'))
	$shareImage=URL.THEME.'/images/favicon-512.ico';
else
	$shareImage=URL.'core/images/shareicon.jpg';

$noimage=NOIMAGE;
$noavatar=NOAVATAR;
if($view=='page'){
  $sp=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `contentType`=:contentType AND LOWER(`title`)=LOWER(:title)");
  $sp->execute([
    ':contentType'=>$view,
    ':title'=>str_replace('-',' ',strtolower($args[0]))
  ]);
}else{
  $sp=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `contentType`=:contentType");
  $sp->execute([
    ':contentType'=>$view==''?'index':$view
  ]);
}
$page=$sp->fetch(PDO::FETCH_ASSOC);
$seoTitle=isset($page['seoTitle'])?$page['seoTitle']:'';
$metaRobots=isset($page['metaRobots'])?$page['metaRobots']:'';
$seoCaption=isset($page['seoCaption'])?$page['seoCaption']:'';
$seoDescription=isset($r['seoDescription'])?$r['seoDescription']:$page['seoDescription'];
$seoKeywords=isset($page['seoKeywords'])?$page['seoKeywords']:'';
if(isset($page['id'])){
  $pu=$db->prepare("UPDATE `".$prefix."menu` SET `views`=`views`+1 WHERE `id`=:id");
  $pu->execute([':id'=>$page['id']]);
}
if(isset($act)&&$act=='logout')require'core/login.php';
require'core/cart_quantity.php';
$status=isset($_SESSON['rank'])&&$_SESSION['rank']>699?"%":"published";
if($config['php_options'][4]==1){
  $sb=$db->prepare("SELECT * FROM `".$prefix."iplist` WHERE `ip`=:ip");
  $sb->execute([':ip'=>$ip]);
  if($sb->rowCount()>0){
    $sbr=$sb->fetch(PDO::FETCH_ASSOC);
    echo'The IP "<strong>'.$ip.'</strong>" has been Blacklisted for suspicious activity.';
    die();
  }
}
if($config['comingsoon']==1&&(isset($_SESSION['rank'])&&$_SESSION['rank']<400)){
    if(file_exists(THEME.'/comingsoon.html'))$template=file_get_contents(THEME.'/comingsoon.html');
    else{
      require'core/view/comingsoon.php';
      die();
    }
}elseif($config['maintenance']==1&&(isset($_SESSION['rank'])&&$_SESSION['rank']<400)){
  if(file_exists(THEME.'/maintenance.html'))$template=file_get_contents(THEME.'/maintenance.html');
  else{
  	require'core/view/maintenance.php';
    die();
  }
}elseif(file_exists(THEME.'/'.$view.'.html'))$template=file_get_contents(THEME.'/'.$view.'.html');
elseif(file_exists(THEME.'/default.html'))$template=file_get_contents(THEME.'/default.html');
else$template=file_get_contents(THEME.'/content.html');
$newDom=new DOMDocument();
@$newDom->loadHTML($template);
$tag=$newDom->getElementsByTagName('block');
foreach($tag as$tag1){
  $include=$tag1->getAttribute('include');
  $inbed=$tag1->getAttribute('inbed');
  if($include!=''){
    $include=rtrim($include,'.html');
    $html=file_exists(THEME.'/'.$include.'.html')?file_get_contents(THEME.'/'.$include.'.html'):'';
    if(file_exists(THEME.'view/'.$include.'.php'))require THEME.'view/'.$include.'.php';
    elseif(file_exists('core/view/'.$include.'.php'))require'core/view/'.$include.'.php';
    else require'core/view/content.php';
    $req=$include;
  }
  if($inbed!=''){
    preg_match('/<block inbed="'.$inbed.'">([\w\W]*?)<\/block>/',$template,$matches);
    $html=isset($matches[1])?$matches[1]:'';
    if($view=='cart')$inbed='cart';
    if($view=='sitemap')$inbed='sitemap';
    if($view=='settings')$inbed='settings';
    if($view=='page')$inbed='page';
    if(file_exists(THEME.'view/'.$inbed.'.php'))require THEME.'view/'.$inbed.'.php';
    elseif(file_exists('core/view/'.$inbed.'.php'))require'core/view/'.$inbed.'.php';
    else require'core/view/content.php';
    $req=$inbed;
  }
}
$contentTime=(!isset($contentTime)?((isset($page['eti'])&&$page['eti'])>(isset($config['ti'])&&$config['ti'])?$page['eti']:$config['ti']):$contentTime);
if(!isset($canonical)||$canonical=='')$canonical=($view=='index'?URL:URL.$view.'/');
if($view=='page')$canonical.=str_replace(' ','-',$page['title']);
if($seoTitle==''){
  if($page['seoTitle']=='')$seoTitle=$page['title'];
  else$seoTitle=$page['seoTitle'];
}
if($seoTitle=='')$seoTitle.=$view=='index'?'Home':'';
if($metaRobots==''){
  if($page['metaRobots']=='')$metaRobots=$config['metaRobots'];
  elseif(in_array($view,['proofs','orders','settings'],true))$metaRobots='noindex,nofollow';
  else$metaRobots=$page['metaRobots'];
}
$seoCaption=isset($seoCaption)&&$seoCaption==''?(isset($page['seoCaption'])?$page['seoCaption']:''):'';
if($seoDescription==''){
  if($page['seoDescription']=='')$seoDescription=substr(strip_tags($page['notes']),0,160);
  else$seoDescription=$page['seoDescription'];
}
if(isset($seoKeywords)&&$seoKeywords==''){
  $seoKeywords=isset($page['seoKeywords'])&&$page['seoKeywords']==''?(isset($config['seoKeywords'])?$config['seoKeywords']:''):(isset($page['seoKeywords'])?$page['seoKeywords']:'');
}
$rss='';
if(isset($args[0])){
  if($args[0]!='index'||$args[0]!='bookings'||$args[0]!='contactus'||$args[0]!='cart'||$args[0]!='proofs'||$args[0]!='settings'||$args[0]!='accounts'){}else$rss=$view;
}
$head=preg_replace([
  '/<print config=[\"\']?business[\"\']?>/',
  '/<print theme=[\"\']?title[\"\']?>/',
  '/<print theme=[\"\']?creator[\"\']?>/',
  '/<print theme=[\"\']?creatorurl[\"\']?>/',
  '/<print meta=[\"\']?metaRobots[\"\']?>/',
  '/<print meta=[\"\']?seoTitle[\"\']?>/',
  '/<print meta=[\"\']?seoCaption[\"\']?>/',
  '/<print meta=[\"\']?seoDescription[\"\']?>/',
  '/<print meta=[\"\']?seoAbstract[\"\']?>/',
  '/<print meta=[\"\']?seoSummary[\"\']?>/',
  '/<print meta=[\"\']?seoKeywords[\"\']?>/',
  '/<print meta=[\"\']?dateAtom[\"\']?>/',
  '/<print meta=[\"\']?canonical[\"\']?>/',
  '/<print meta=[\"\']?url[\"\']?>/',
  '/<print meta=[\"\']?view[\"\']?>/',
  '/<print meta=[\"\']?rss[\"\']?>/',
  '/<print meta=[\"\']?ogType[\"\']?>/',
  '/<print meta=[\"\']?shareImage[\"\']?>/',
  '/<print meta=[\"\']?favicon[\"\']?>/',
  '/<print microid>/',
  '/<print meta=[\"\']?author[\"\']?>/',
  '/<print theme>/',
  '/<print site_verifications>/',
	'/<print geo>/',
  '/<print sale>/'
],[
  trim($config['business']),
  trim($theme['title']),
  trim($theme['creator']),
  trim($theme['creator_url']),
  trim($metaRobots),
  trim($seoTitle),
  trim($seoCaption),
  trim($seoDescription),
  trim($seoCaption),
  trim($seoDescription),
  trim($seoKeywords),
  $contentTime,
  $canonical,
  URL,
  $view,
  URL.'rss/'.$rss,
  $view=='inventory'?'product':$view,
  stristr($shareImage,'noimage')?FAVICON:$shareImage,
  FAVICON,
  microid($config['email'],$canonical),
  isset($r['name'])?$r['name']:$config['business'],
  THEME,
  ($config['ga_verification']!=''?'<meta name="google-site-verification" content="'.$config['ga_verification'].'">':'').
    ($config['seo_msvalidate']!=''?'<meta name="msvalidate.01" content="'.$config['seo_msvalidate'].'">':'').
    ($config['seo_yandexverification']!=''?'<meta name="yandex-verification" content="'.$config['seo_yandexverification'].'">':'').
    ($config['seo_alexaverification']!=''?'<meta name="alexaVerifyID" content="'.$config['seo_alexaverification'].'">':'').
    ($config['seo_pinterestverify']!=''?'<meta name="p:domain_verify" content="'.$config['seo_pinterestverify'].'">':''),
  ($config['geo_region']!=''?'<meta name="geo.region" content="'.$config['geo_region'].'">':'').
    ($config['geo_placename']!=''?'<meta name="geo.placename" content="'.$config['geo_placename'].'">':'').
    ($config['geo_position']!=''?'<meta name="geo.position" content="'.$config['geo_position'].'"><meta name="ICBM" content="'.$config['geo_position'].'">':''),
    ($config['options'][28]==1?(isset($sale['class'])?' '.$sale['class']:''):'')
],$head);
if(stristr($head,'<css')){
  preg_match('/<css file=[\"\']([\w\W]*?)[\"\']>/',$head,$cssfilematch);
  $cssfile=$cssfilematch[1];
  $css=file_get_contents(THEME.'/css/'.$cssfile);
  if(stristr($css,'@import url')){
    $imp=explode("@import",$css);
    for($i=0;$i<sizeof($imp)-1;$i++){
      $tmp=str_replace(array("url(",");","/*"),"",$imp[$i]);
      $tmp=str_replace(array('"',"'"),'',$tmp);
      $css.=file_get_contents(THEME.'/css/'.trim($tmp));
    }
    $css=preg_replace([
      '#/\*(?:.(?!/)|[^\*](?=/)|(?<!\*)/)*\*/#s',
      "/^\s*@import url.*\R*/m",
      "/@import[^;]+;/"
    ],'',$css);
  }
  $head=preg_replace('~<css.*?>~is','<style>'.$css.'</style>',$head);
}
if($view=='login'){
  if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
    $content=preg_replace([
      '/<[\/]?loggedin>/',
      '~<notloggedin>.*?<\/notloggedin>~is'
    ],'',$content);
  }else{
    if(stristr($content,'<print page="terms-of-service">')){
      $cs=$db->prepare("SELECT notes FROM `".$prefix."menu` WHERE LOWER(`title`)=LOWER(:title) AND `active`=1");
      $cs->execute([':title'=>'terms of service']);
      $cp=$cs->fetch(PDO::FETCH_ASSOC);
      $content=preg_replace([
        '~<loggedin>.*?<\/loggedin>~is',
        '/<[\/]?notloggedin>/',
        '/<print page=[\'\"]?terms-of-service[\'\"]?>/'
      ],[
        '',
        '',
        $cp['notes']
      ],$content);
    }
  }
}
$content=preg_replace([
  '/<serviceworker>/',
  '/<print hash>/',
  '/<print timecode>/'
],[
  ($config['options'][18]==1?'<script>if(`serviceWorker` in navigator){window.addEventListener(`load`,()=>{navigator.serviceWorker.register(`core/js/service-worker.php`,{scope:`/`}).then((reg)=>{console.log(`[AuroraCMS] Service worker registered.`,reg);});});}</script>':''),
  md5($ip),
  base64_encode(time())
],$content);
$schemaWebsite='<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebSite","url":"'.$canonical.'","name":"'.$seoTitle.'","author":{"@type":"Person","name":"'.(isset($r['name'])&&$r['name']?$r['name']:$config['business']).'"},"description":"'.htmlspecialchars($seoDescription,ENT_QUOTES).'","publisher":"'.$seoTitle.'","potentialAction":{"@type":"SearchAction","target":"'.URL.'search/{search_term}","query-input":"required name=search_term"}}</script>';
$schemaOrganization='<script type="application/ld+json">{"@context":"http://schema.org","@type":"Organization","name":"'.$config['business'].'","url":"'.URL.'"';
if($config['phone']!=''||$config['mobile']!=''){
  $schemaOrganization.=',"contactPoint":[{"@type":"ContactPoint","telephone":"'.($config['phone']!=''?$config['phone']:$config['mobile']).'","contactType":"customer service"}]';
}
if($config['address']!=''){
  $schemaOrganization.=',"address":{"@type":"PostalAddress","streetAddress":"'.$config['address'].'"'.
    ($config['city']!=''?',"addressLocality":"'.$config['city'].'"':'').
    ($config['suburb']!=''?',"addressRegion":"'.$config['suburb'].'"':'').
    ($config['postcode']!=''||$config['postcode']>0?',"postalCode":"'.$config['postcode'].'"':'').
    ($config['country']!=''?',"addressCountry":"'.$config['country'].'"':'').
  '}';
}
$sO=$db->query("SELECT `url` FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=0 ORDER BY `url` ASC");
if($sO->rowCount()>0){
  $schemaOrganization.=',"sameAs":[';
  $scnt=$sO->rowCount() - 1;
  while($rO=$sO->fetch(PDO::FETCH_ASSOC)){
    $schemaOrganization.='"'.$rO['url'].'"'.($scnt>0?',':'');
    $scnt--;
  }
  $schemaOrganization.=']';
}
$schemaOrganization.='}</script>';
$head=preg_replace([
  '/<google_analytics>/',
  '/<google_tagmanager>/',
  '/<google_tagmanager-noscript>/',
  '/<schemaWebsite>/',
  '/<schemaOrganization>/'
],[
  (isset($config['ga_tracking'])&&$config['ga_tracking']!=''?'<script async src="/core/js/googleanalytics/gtag/js.js?id='.$config['ga_tracking'].'"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag(\'js\',new Date());gtag(\'config\',\''.$config['ga_tracking'].'\');</script>':''),
  (isset($config['ga_tagmanager'])&&$config['ga_tagmanager']!=''?'<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);})(window,document,\'script\',\'dataLayer\',\''.$config['ga_tagmanager'].'\');</script>':''),
  (isset($config['ga_tagmanager'])&&$config['ga_tagmanager']!=''?'<noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$config['ga_tagmanager'].'"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>':''),
  $schemaWebsite,
  $schemaOrganization
],$head);
print$head.$content;
$ws=$db->prepare("SELECT `options` FROM `".$prefix."login` WHERE `userIP`=:ip");
$ws->execute([':ip'=>$ip]);
if($ws->rowCount()>0)$wr=$ws->fetch(PDO::FETCH_ASSOC);
else$wr=Array('options'=>'00000000000000000000000000000000');
if($wr['options'][18]==0){
  if($config['options'][11]==1){
    $current_page=PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(!isset($_SESSION['current_page'])||(isset($_SESSION['current_page'])&&(stristr($_SESSION['current_page'],'search')||$_SESSION['current_page']!=$current_page))){
      if(!stristr($current_page,'/core/')||
        !stristr($current_page,'/admin/')||
        !stristr($current_page,'/layout/')||
        !stristr($current_page,'/media/')||
        !stristr($current_page,'.js')||
        !stristr($current_page,'.css')||
        !stristr($current_page,'.map')||
        !stristr($current_page,'.jpg')||
        !stristr($current_page,'.jpeg')||
        !stristr($current_page,'.png')||
        !stristr($current_page,'.gif')||
        !stristr($current_page,'.svg')||
        !stristr($current_page,'.webp')
      ){
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        $clienthints=getallheaders();
        $s=$db->prepare("INSERT IGNORE INTO `".$prefix."tracker` (`pid`,`urlDest`,`urlFrom`,`userAgent`,`keywords`,`ip`,`host`,`browser`,`device`,`viewportwidth`,`os`,`sid`,`ti`) VALUES (:pid,:urlDest,:urlFrom,:userAgent,:keywords,:ip,:host,:browser,:device,:viewportwidth,:os,:sid,:ti)");
        $hr=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        $s->execute([
          ':pid'=>isset($page['id'])?$page['id']:0,
          ':urlDest'=>$current_page,
          ':urlFrom'=>$hr,
          ':userAgent'=>(isset($clienthints['User-Agent'])?$clienthints['User-Agent']:$_SERVER['HTTP_USER_AGENT']),
          ':keywords'=>isset($search)&&($search!='%'||$search!='')?ltrim(rtrim(str_replace([' ','%'],',',$search),','),','):'',
          ':ip'=>$ip,
          ':host'=>(isset($clienthints['Host'])?$clienthints['Host']:$ip),
          ':browser'=>getBrowser($useragent,$clienthints),
          ':device'=>getDevice($useragent,$clienthints),
          ':viewportwidth'=>(isset($clienthints['viewport-width'])?$clienthints['viewport-width']:'N/A'),
          ':os'=>getOS($useragent,$clienthints),
          ':sid'=>session_id(),
          ':ti'=>time()
        ]);
        $_SESSION['current_page']=$current_page;
      }
    }
  }
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
