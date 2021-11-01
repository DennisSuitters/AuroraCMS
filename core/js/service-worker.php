<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Interface
 * @package    core/js/service-worker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type: application/javascript');
header('Service-Worker-Allowed:/');
require'../db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$page=$db->query("SELECT heading,notes FROM `".$prefix."menu` WHERE `contentType`='offline'")->fetch(PDO::FETCH_ASSOC);
//if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
if(file_exists('../../core/config.ini'))$settings=parse_ini_file('../../core/config.ini',TRUE);
elseif(file_exists('../core/config.ini'))$settings=parse_ini_file('../core/config.ini',TRUE);
elseif(file_exists('core/config.ini'))$settings=parse_ini_file('core/config.ini',TRUE);
elseif(file_exists('config.ini'))$settings=parse_ini_file('config.ini',TRUE);
else{
  require ROOT_DIR.'/core/layout/install.php';
  die();
}
if(!defined('THEME'))define('THEME','../../layout/'.$config['theme']);
if(!defined('URL'))define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$html=file_get_contents(THEME."/offline.html");
$logo=THEME.'/images/offlinelogo.png';
if(file_exists(THEME.'/images/offlinelogo.jpg'))
  $logo=THEME.'/images/offlinelogo.jpg';
elseif(file_exists(THEME.'/images/offlinelogo.png'))
  $logo=THEME.'/images/offlinelogo.png';
elseif(file_exists(THEME.'/images/offlinelogo.jpg'))
  $logo=THEME.'/images/offlinelogo.jpg';
elseif(file_exists(THEME.'/images/offlinelogo.svg'))
  $logo=THEME.'/images/offlinelogo.svg';
else$logo=THEME.'/images/offlinelogo.png';
$html=preg_replace([
  '/<print seo=[\'\"]?title[\'\"]?>/',
  '/<print css=[\'\"]?offline[\'\"]?>/',
  '/<print logo=[\'\"]?image[\'\"]?>/',
  '/<print logo=[\'\"]?alt[\'\"]?>/',
  '/<print config=[\'\"]?email[\'\"]?>/',
  '/<print config=[\'\"]?phone[\'\"]?>/',
  '/<print config=[\'\"]?mobile[\'\"]?>/',
  '/<print config=[\'\"]?address[\'\"]?>/',
  '/<print page=[\"\']?heading[\"\']?>/',
  '/<print page=[\"\']?notes[\"\']?>/'
],[
  ($config['business']!=''?$config['business']:'AuroraCMS Offline'),
  file_get_contents(THEME.'/css/offline.css'),
  'data:'.mime_content_type($logo).';base64,'.base64_encode(file_get_contents($logo)),
  ($config['business']!=''?$config['business']:'AuroraCMS Offline Logo'),
  ($config['email']!=''?'Email: <a href="mailto:'.$config['email'].'">'.$config['email'].'</a>':''),
  ($config['phone']!=''?'Phone: <a href="tel:'.$config['phone'].'">'.$config['phone'].'</a>':''),
  ($config['mobile']!=''?'Mobile: <a href="tel:'.$config['mobile'].'">'.$config['mobile'].'</a>':''),
  ($config['address']!=''?'Address: '.$config['address'].', '.$config['suburb'].', '.$config['state'].', '.$config['postcode'].', '.$config['country']:''),
  $page['heading'],
  $page['notes']
],$html);?>
const CACHE=`<?=$config['business'];?>`;
const offlineFallbackPage=`<?=$html;?>`;
const offlineFallbackPages=["/",];
self.addEventListener("install",function(event){
  console.log("[AuroraCMS] Install Event processing");
  event.waitUntil(
    caches.open(CACHE).then(function(cache){
      console.log("[AuroraCMS] Cached offline page during install");
      return cache.addAll(offlineFallbackPages);
    })
  );
});
self.addEventListener('fetch',event=>{
  if(event.request.method!=="GET")return;
  event.respondWith(
    fetch(event.request).catch(()=>{
      return new Response(offlineFallbackPage,{
        headers:{'Content-Type':'text/html'}
      });
    })
  )
});
self.addEventListener("refreshOffline",function(){
  const offlinePageRequest=new Request(offlineFallbackPage);
  return fetch(offlineFallbackPage).then(function(response){
    return caches.open(CACHE).then(function(cache){
      console.log("[AuroraCMS] Offline page updated from refreshOffline event:"+response.url);
      return cache.put(offlinePageRequest,response);
    });
  });
});
