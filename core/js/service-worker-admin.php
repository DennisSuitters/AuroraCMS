<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Interface
 * @package    core/js/service-worker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type: application/javascript');
header('Service-Worker-Allowed:/');
$getcfg=true;
require'../db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(!defined('URL'))define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$html=file_get_contents('..'.DS.'layout'.DS.'offline.html');
$html=preg_replace([
  '/<print url>/',
  '/<print seo=[\'\"]title[\'\"]?>/',
  '/<print background>/',
  '/<print logo>/'
],[
  URL,
  $config['business'].' - Administration - AuroraCMS',
  'data:'.mime_content_type('..'.DS.'images'.DS.'loginbg-dark.jpeg').';base64,'.base64_encode(file_get_contents('..'.DS.'images'.DS.'loginbg-dark.jpeg')),
 'data:'.mime_content_type('..'.DS.'images'.DS.'auroracms-white.svg').';base64,'.base64_encode(file_get_contents('..'.DS.'images'.DS.'auroracms-white.svg'))
],$html);
?>

const CACHE="AuroraCMSv0-0-9";
const offlineFallbackPage=`<?php echo$html;?>`;
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
      console.log("[AuroraCMS] Offline page updated from refreshOffline event: "+response.url);
      return cache.put(offlinePageRequest,response);
    });
  });
});
