<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Main Core of Whole System
 * @package    core/core.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
if(isset($_GET['theme'])&&file_exists('layout'.DS.$_GET['theme']))$config['theme']=$_GET['theme'];
define('THEME','layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
if($config['php_options']{6}==1){
	$s=$db->prepare("DELETE FROM `".$prefix."iplist` WHERE ti<:ti");
	$s->execute([':ti'=>time()-2592000]);
}
if($config['php_options']{5}==1){
	if(stristr($_SERVER['REQUEST_URI'],'xmlrpc.php')||stristr($_SERVER['REQUEST_URI'],'wp-admin')||stristr($_SERVER['REQUEST_URI'],'wp-login')||stristr($_SERVER['REQUEST_URI'],'wp-content')||stristr($_SERVER['REQUEST_URI'],'wp-plugin')||(isset($_GET['author']) && $_GET['author']!='')){
		require'core'.DS.'xmlrpc.php';
		die();
	}
}
if(stristr($_SERVER['REQUEST_URI'],'magento')){
	echo'Nope NOT Magento!<br>';
	require'core'.DS.'xmlrpc.php';
	die();
}
if(stristr($_SERVER['REQUEST_URI'],'.aspx')){
	echo'Nope doesn\'t run on ASP, blergh!<br>';
	require'core'.DS.'xmlrpc.php';
	die();
}
define('UNICODE','UTF-8');
if(file_exists(THEME.DS.'images'.DS.'favicon.png')){
	define('FAVICON',THEME.DS.'images'.DS.'favicon.png');
	define('FAVICONTYPE','image/png');
}elseif(file_exists(THEME.DS.'images'.DS.'favicon.gif')){
	define('FAVICON',THEME.DS.'images'.DS.'favicon.gif');
	define('FAVICONTYPE','image/gif');
}elseif(file_exists(THEME.DS.'images'.DS.'favicon.jpg')){
	define('FAVICON',THEME.DS.'images'.DS.'favicon.jpg');
	define('FAVICONTYPE','image/jpg');
}elseif(file_exists(THEME.DS.'images'.DS.'favicon.ico')){
	define('FAVICON',THEME.DS.'images'.DS.'favicon.ico');
	define('FAVICONTYPE','image/ico');
}else{
	define('FAVICON','core'.DS.'images'.DS.'favicon.png');
	define('FAVICONTYPE','image/png');
}
if(file_exists(THEME.DS.'images'.DS.'noimage.png'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.png');
elseif(file_exists(THEME.DS.'images'.DS.'noimage.gif'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.gif');
elseif(file_exists(THEME.DS.'images'.DS.'noimage.jpg'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.jpg');
else
	define('NOIMAGE','core'.DS.'images'.DS.'noimage.jpg');
define('ADMINNOIMAGE','core'.DS.'images'.DS.'noimage.png');
if(file_exists(THEME.DS.'images'.DS.'noavatar.png'))
	define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.png');
elseif(file_exists(THEME.DS.'images'.DS.'noavatar.gif'))
	define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.gif');
elseif(file_exists(THEME.DS.'images'.DS.'noavatar.jpg'))
	define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.jpg');
else
	define('NOAVATAR','core'.DS.'images'.DS.'noavatar.jpg');
define('ADMINNOAVATAR','core'.DS.'images'.DS.'i-noavatar.svg');
require'login.php';
function rank($txt){
	if($txt==0)return'visitor';
	if($txt==100)return'subscriber';
	if($txt==200)return'member';
	if($txt==300)return'client';
	if($txt==400)return'contributor';
	if($txt==500)return'author';
	if($txt==600)return'editor';
	if($txt==700)return'moderator';
	if($txt==800)return'manager';
	if($txt==900)return'administrator';
	if($txt==1000)return'developer';
}
function svg($svg,$class=null,$size=null){
	if($svg=='auroracms'||$svg=='auroracms-white')
		echo file_get_contents('core'.DS.'images'.DS.$svg.'.svg');
	else
		echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('core'.DS.'images'.DS.'i-'.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('core'.DS.'images'.DS.'i-'.$svg.'.svg').'</i>';
}
function frontsvg($svg){
	if(file_exists(THEME.DS.'svg'.DS.$svg.'.svg'))
		return file_get_contents(THEME.DS.'svg'.DS.$svg.'.svg');
	elseif(file_exists('..'.DS.THEME.'svg'.DS.$svg.'.svg'))
		return file_get_contents('..'.DS.THEME.DS.'svg'.DS.$svg.'.svg');
	elseif(file_exists('..'.DS.THEME.'svg'.DS.$svg.'.svg'))
		return file_get_contents('..'.DS.THEME.'svg'.DS.$svg.'.svg');
	elseif(file_exists('..'.DS.'..'.DS.THEME.'svg'.DS.$svg.'.svg'))
		return file_get_contents('..'.DS.'..'.DS.THEME.'svg'.DS.$svg.'.svg');
	else
		return'No Such File: '.$svg;
}
function microid($identity,$service,$algorithm='sha1'){
	$microid=substr($identity,0,strpos($identity,':'))."+".substr($service,0,strpos($service,':')).":".strtolower($algorithm).":";
	if(function_exists('hash')){
		if(in_array(strtolower($algorithm),hash_algos()))
			return$microid.=hash($algorithm,hash($algorithm,$identity).hash($algorithm,$service));
	}
	if(function_exists('mhash')){
		$hash_method=@constant('MHASH_'.strtoupper($algorithm));
		if($hash_method!=null){
			$identity_hash=bin2hex(mhash($hash_method,$identity));
			$service_hash=bin2hex(mhash($hash_method,$service));
			return$microid.=bin2hex(mhash($hash_method,$identity_hash.$service_hash));
		}
	}
	if(function_exists($algorithm))
		return$microid.=$algorithm($algorithm($identity).$algorithm($service));
}
function _ago($time){
	if($time==0)
		$timeDiff='Never';
	else{
		$fromTime=$time;
		$timeDiff=floor(abs(time()-$fromTime)/60);
		if($timeDiff<2)
			$timeDiff='Just Now';
		elseif($timeDiff>2&&$timeDiff<60)
			$timeDiff=floor(abs($timeDiff)).' Minutes Ago';
		elseif($timeDiff>60&&$timeDiff<120)
			$timeDiff=floor(abs($timeDiff/60)).' Hour Ago';
		elseif($timeDiff<1440)
			$timeDiff=floor(abs($timeDiff/60)).' Hours Ago';
		elseif($timeDiff>1440&&$timeDiff<2880)
			$timeDiff=floor(abs($timeDiff/1440)).' Day Ago';
		elseif($timeDiff>2880)
			$timeDiff=floor(abs($timeDiff/1440)).' Days Ago';
	}
	return$timeDiff;
}
function elapsed_time($b=0,$e=0){
  if($b==0)$b=$_SERVER["REQUEST_TIME_FLOAT"];
  $b=explode(' ',$b);
  if($e==0)$e=microtime();
  $e=explode(' ',$e);
  @$td=($e[0]+$e[1])-($b[0]+$b[1]);
  $b='';
  $tt=[
    'd'=>(int)($td / 86400),
    'h'=>$td / 3600 % 24,
    'm'=>$td / 60 % 60,
    's'=>$td % 60
	];
  if((int)$td>30){
    foreach($tt as$u=>$ti){
      if($ti>0)$b.="$ti$u ";
    }
  }else$b=number_format($td,3).'s';
  return trim($b);
}
function size_format($f,$p=2){
  $us=array('','K','M','G','T','P','E','Z','Y');
  foreach($us as$iU => $u){
    if($f>1024)
      $f/=1024;
    else
      break;
  }
  return round($f,$p).$us[$iU].'B';
}
function getmemstats(){
  $memfree=0;
  if(shell_exec('cat /proc/meminfo')){
    $memfree=shell_exec('grep MemFree /proc/meminfo | awk \'{print $2}\'');
    $membuffers=shell_exec('grep Buffers /proc/meminfo | awk \'{print $2}\'');
    $memcached=shell_exec('grep Cached /proc/meminfo | awk \'{print $2}\'');
    $memfree=(int)$memfree+(int)$membuffers+(int)$memcached;
  }
  if(!($memtotal=shell_exec('grep MemTotal /proc/meminfo | awk \'{print $2}\'')))$memtotal=0;
  $memtotal=(int)$memtotal;
  $memused=$memtotal-$memfree;
  $mempercent=0;
  if($memtotal>0)$mempercent=100-(round($memfree/$memtotal*100));
  $memfree=size_format($memfree*1024);
  $mem = [
    'percent'=>$mempercent,
    'total'=>$memtotal*1024,
    'used'=>$memused*1024
  ];
  return$mem;
}
function getload(){
	$loads=sys_getloadavg();
	$core_nums=trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
	$load=round($loads[0]/($core_nums+1)*100,2);
	return$load;
}
function gpc(){
  static $ver,$runs=0;
  if(is_null($ver))$ver=version_compare(PHP_VERSION,'5.3.0','>=');
  if($runs++>0){
    if($ver)clearstatcache(true,'/proc');
    else clearstatcache();
  }
  $stat=stat('/proc');
  return((false!==$stat && isset($stat[3]))?$stat[3]:0);
}
function num_cpu():int{
	if(defined('PHP_WINDOWS_VERSION_MAJOR')){
		$str=trim(shell_exec ('wmic cpu get NumberOfCores 2>&1'));
		if(!preg_match('/(\d+)/',$str,$matches))throw new \RuntimeException('wmic failed to get number of cpu cores on windows!');
		return((int)$matches[1]);
	}
	$ret=@shell_exec('nproc');
	if(is_string($ret)){
		$ret=trim($ret);
		if(false!==($tmp=filter_var($ret,FILTER_VALIDATE_INT)))return$tmp;
	}
	if(is_readable('/proc/cpuinfo')){
		$cpuinfo=file_get_contents('/proc/cpuinfo');
		$count=substr_count($cpuinfo,'processor');
		if($count>0)return$count;
	}
	throw new \LogicException('failed to detect number of CPUs!');
}
function tomoment($f){
  $r=['d'=>'DD','D'=>'ddd','j'=>'D','l'=>'dddd','N'=>'E','S'=>'o','w'=>'e','z'=>'DDD','W'=>'W','F'=>'MMMM','m'=>'MM','M'=>'MMM','n'=>'M','t'=>'','L'=>'','o'=>'YYYY','Y'=>'YYYY','y'=>'YY','a'=>'a','A'=>'A','B'=>'','g'=>'h','G'=>'H','h'=>'hh','H'=>'HH','i'=>'mm','s'=>'ss','u'=>'SSS','e'=>'zz','I'=>'','O'=>'','P'=>'','T'=>'','Z'=>'','c'=>'','r'=>'','U'=>'X'];
  return strtr($f,$r);
}
function url_encode($str){
	$str=trim(strtolower($str));
	$str=str_replace(array('%2D','%2D','%2D','%2D','!','*',"'","(",")",";",":","@","&","=","+","$",",","/","?","#","[","]",' '),array(chr(149),chr(150),chr(151),chr(45),'%21','%2A',"%27","%28","%29","%3B","%3A","%40","%26","%3D","%2B","%24","%2C","%2F","%3F","%23","%5B","%5D",'-'),$str);
	return$str;
}
function sluggify($url){
	$url=strtolower($url);
	$url=strip_tags($url);
	$url=stripslashes($url);
	$url=html_entity_decode($url);
	$url=str_replace('\'','',$url);
	$match='/[^a-z0-9]+/';
	$replace='-';
	$url=preg_replace($match,$replace,$url);
	$url=trim($url,'-');
	return$url;
}
function escaper($val){
  return str_replace(array("\\","/","\"","\n","\r","\t","\x08","\x0c"),array("\\\\","\\/","\\\"","\\n","\\r","\\t","\\f","\\b"),$val);
}
class internal{
	function humans($args=false){
		require'core'.DS.'humans.php';
	}
	function sitemap($args=false){
		require'core'.DS.'sitemap.php';
	}
	function robots($args=false){
		require'core'.DS.'robots.php';
	}
	function rss($args=false){
		require'core'.DS.'rss.php';
	}
	function manifest($args=false){
		require'core'.DS.'manifest.php';
	}
	function manifestadmin($args=false){
		require'core'.DS.'manifestadmin.php';
	}
}
class admin{
	function favicon(){
		return'core'.DS.'images'.DS.'favicon.png';
	}
	function noimage(){
		return'core'.DS.'images'.DS.'noimage.jpg';
	}
	function noavatar(){
		return'core'.DS.'images'.DS.'noavatar.jpg';
	}
	function accounts($args=false){
		$view='accounts';
		require'admin.php';
	}
	function activity($args=false){
		$view='activity';
		require'admin.php';
	}
	function add($args=false){
		$view='add';
		require'admin.php';
	}
	function bookings($args=false){
		$view='bookings';
		require'admin.php';
	}
	function comments($args=false){
		$view='comments';
		require'admin.php';
	}
	function content($args=false){
		$view='content';
		require'admin.php';
	}
	function dashboard($args=false){
		$view='dashboard';
		require'admin.php';
	}
	function logout($args=false){
		$act='logout';
		$view='';
		require'admin.php';
	}
	function media($args=false){
		$view='media';
		require'admin.php';
	}
	function messages($args=false){
		$view='messages';
		require'admin.php';
	}
	function newsletters($args=false){
		$view='newsletters';
		require'admin.php';
	}
	function orders($args=false){
		$view='orders';
		require'admin.php';
	}
	function reviews($args=false){
		$view='reviews';
		require'admin.php';
	}
  function rewards($args=false){
    $view='rewards';
    require'admin.php';
  }
	function pages($args=false){
		$view='pages';
		require'admin.php';
	}
	function preferences($args=false){
		$view='preferences';
		require'admin.php';
	}
	function security($args=false){
		$view='security';
		require'admin.php';
	}
	function search($args=false){
		$view='search';
		require'admin.php';
	}
  function tracker($args=false){
    $view='tracker';
    require'admin.php';
  }
}
class front{
	function about($args=false){
		$view='aboutus';
		require'process.php';
	}
	function aboutus($args=false){
		$view='aboutus';
		require'process.php';
	}
	function article($args=false){
		$view='article';
		require'process.php';
	}
	function articles($args=false){
		$view='article';
		require'process.php';
	}
	function booking($args=false){
		$view='bookings';
		require'process.php';
	}
	function bookings($args=false){
		$view='bookings';
		require'process.php';
	}
	function cart($args=false){
		$view='cart';
		require'process.php';
	}
	function contactus($args=false){
		$view='contactus';
		require'process.php';
	}
  function distributors($args=false){
    $view='distributors';
    require'process.php';
  }
	function error($args=false){
		$view='error';
		$headerType=$_SERVER["SERVER_PROTOCOL"]." 404 Not Found";
		require'process.php';
	}
	function event($args=false){
		$view='events';
		require'process.php';
	}
	function events($args=false){
		$view='events';
		require'process.php';
	}
	function gallery($args=false){
		$view='gallery';
		require'process.php';
	}
	function index($args=false){
		$view='index';
		require'process.php';
	}
	function inventory($args=false){
		$view='inventory';
		require'process.php';
	}
	function login($args=false){
		$view='login';
		require'process.php';
	}
	function logout($args=false){
		$act='logout';
		$view='index';
		require'process.php';
	}
	function news($args=false){
		$view='news';
		require'process.php';
	}
	function order($args=false){
		$view='orders';
		require'process.php';
	}
	function orders($args=false){
		$view='orders';
		require'process.php';
	}
	function portfolio($args=false){
		$view='portfolio';
		require'process.php';
	}
	function profile($args=false){
		$view='profile';
		require'process.php';
	}
	function proof($args=false){
		$view='proofs';
		require'process.php';
	}
	function proofs($args=false){
		$view='proofs';
		require'process.php';
	}
	function search($args=false){
		$view='search';
		require'process.php';
	}
	function service($args=false){
		$view='service';
		require'process.php';
	}
	function services($args=false){
		$view='service';
		require'process.php';
	}
	function settings($args=false){
		$view='settings';
		require'process.php';
	}
	function sitemap($args=false){
		$view='sitemap';
		require'process.php';
	}
	function testimonial($args=false){
		$view='testimonials';
		require'process.php';
	}
	function testimonials($args=false){
		$view='testimonials';
		require'process.php';
	}
	function tos($args=false){
		$view='tos';
		require'process.php';
	}
	function newsletters($args=false){
		$view='newsletters';
		require'process.php';
	}
	function page($args=false){
		$view='page';
		require'process.php';
	}
}
$route=new router();
$routes=[
  $settings['system']['admin'].'/add'=>['admin','add'],
	$settings['system']['admin'].'/accounts'=>['admin','accounts'],
	$settings['system']['admin'].'/activity'=>['admin','activity'],
	$settings['system']['admin'].'/bookings'=>['admin','bookings'],
	$settings['system']['admin'].'/comments'=>['admin','comments'],
	$settings['system']['admin'].'/content'=>['admin','content'],
	$settings['system']['admin'].'/dashboard'=>['admin','dashboard'],
	$settings['system']['admin'].'/logout'=>['admin','logout'],
	$settings['system']['admin'].'/media'=>['admin','media'],
	$settings['system']['admin'].'/messages'=>['admin','messages'],
	$settings['system']['admin'].'/newsletters'=>['admin','newsletters'],
	$settings['system']['admin'].'/orders'=>['admin','orders'],
  $settings['system']['admin'].'/rewards'=>['admin','rewards'],
	$settings['system']['admin'].'/pages'=>['admin','pages'],
	$settings['system']['admin'].'/preferences'=>['admin','preferences'],
	$settings['system']['admin'].'/reviews'=>['admin','reviews'],
	$settings['system']['admin'].'/search'=>['admin','search'],
	$settings['system']['admin'].'/security'=>['admin','security'],
  $settings['system']['admin'].'/tracker'=>['admin','tracker'],
	$settings['system']['admin']=>['admin','dashboard'],
	$settings['system']['admin'].'/manifest.json'=>['internal','manifestadmin'],
	'humans.txt'=>['internal','humans'],
	'sitemap.xml'=>['internal','sitemap'],
	'robots.txt'=>['internal','robots'],
	'rss'=>['internal','rss'],
	'manifest.json'=>['internal','manifest'],
	'error'=>['front','error'],
	'index'=>['front','index'],
	'home'=>['front','index'],
	'sitemap'=>['front','sitemap'],
	'orders'=>['front','orders'],
	'profile'=>['front','profile'],
	'proofs'=>['front','proofs'],
	'login'=>['front','login'],
	'settings'=>['front','settings'],
	'logout'=>['front','logout'],
  ''=>['front','index']
];
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE active=1");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	if(method_exists('front',$r['contentType']))
		$routes[$r['contentType']]=['front',$r['contentType']];
  else
		$routes[$r['contentType']]=['front','content'];
}
$route->setRoutes($routes);
$route->routeURL(preg_replace("|/$|","",filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)));
class router{
	protected $route_match=false;
	protected $route_call=false;
	protected $route_call_args=false;
	protected $routes=array();
	public function setRoutes($routes){
		$this->routes=$routes;
	}
	public function routeURL($url=false){
		if(isset($this->routes[$url])){
			$this->route_match=$url;
			$this->route_call=$this->routes[$url];
			$this->callRoute();
			return true;
		}
		foreach($this->routes as$path=>$call){
			if(empty($path))
				continue;
			preg_match("|{$path}/(.*)$|i",$url,$match);
			if(!empty($match[1])){
				$this->route_match=$path;
				$this->route_call=$call;
				$this->route_call_args=explode("/",$match[1]);
				$this->callRoute();
				return true;
			}
		}
		if($this->route_call===false){
			if(!empty($this->routes['error'])){
				$this->route_call=$this->routes['error'];
				$this->callRoute();
				return true;
			}
		}
	}
	private function callRoute(){
		$call=$this->route_call;
		if(is_array($call)){
			$call_obj=new $call[0]();
			$call_obj->{$call[1]}($this->route_call_args);
		}else
			$call($this->route_call_args);
	}
}
