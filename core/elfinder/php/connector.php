<?php
if(session_status()==PHP_SESSION_NONE){
  session_start();
  define('SESSIONID',session_id());
}
$uid=$_SESSION['uid'];
$view=isset($_GET['view'])&&$_GET['view']!=''?filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING):'';
define('DS',DIRECTORY_SEPARATOR);
include_once dirname(__FILE__).DS.'autoload.php';
include_once dirname(__FILE__).DS.'elFinderConnector.class.php';
include_once dirname(__FILE__).DS.'elFinder.class.php';
include_once dirname(__FILE__).DS.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DS.'elFinderVolumeLocalFileSystem.class.php';
$settings=parse_ini_file('..'.DS.'..'.DS.'..'.DS.'core'.DS.'config.ini',TRUE);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].DS);
$prefix=$settings['database']['prefix'];
$dns=((!empty($settings['database']['driver']))?($settings['database']['driver']):'').((!empty($settings['database']['host']))?(':host='.$settings['database']['host']):'').((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').((!empty($settings['database']['schema']))?(';dbname='.$settings['database']['schema']):'');
$db=new PDO($dns,$settings['database']['username'],$settings['database']['password']);
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$s=$db->prepare("SELECT options,rank FROM `".$prefix."login` WHERE id=:id");
$s->execute([':id'=>$uid]);
$user=$s->fetch(PDO::FETCH_ASSOC);
function access($attr,$path,$data,$volume){
  return strpos(basename($path),'.')===0?!($attr=='read'||$attr=='write'):null;
}
$mediaEnable=$config['options'][2]==1?true:false;
if($config['mediaMaxWidth']==0)$mediaEnable=false;
if($config['mediaMaxHeight']==0)$mediaEnable=false;
$folders='';
if($user['rank']==900){
  $folders.='!^/core|layout|';
  if($user['options'][16]==1)$folders.='avatar|backup|cache|email|updates|';
}
if($user['rank']==800)$folders.='!^/core|layout|avatar|backup|cache|carousel|email|updates|';
if($user['rank']==700)$folders.='!^/core|layout|avatar|backup|cache|carousel|email|updates|';
if($user['rank']==600)$folders.='!^/core|layout|avatar|backup|cache|carousel|email|updates|orders|';
if($user['rank']==500)$folders.='!^/core|layout|avatar|backup|cache|carousel|email|updates|orders|';
if($user['rank']==400)$folders.='!^/core|layout|avatar|backup|cache|carousel|email|updates|orders|';
$folders.='index.php!';
$opts=[
  'bind'=>[
    'upload.presave'=>[
      'Plugin.AutoResize.onUpLoadPreSave',
    ],
    'mkdir.pre mkfile.pre rename.pre'=>[
      'Plugin.Sanitizer.cmdPreprocess',
    ]
  ],
  'plugin'=>[
    'Sanitizer'=>[
      'enable'=>true,
      'targets'=>['\\','/',':','*','?','"','<','>','|',' '],
      'replace'=>'-',
    ],
    'AutoResize'=>[
      'enable'=>$mediaEnable,
      'maxWidth'=>$config['mediaMaxWidth'],
      'maxHeight'=>$config['mediaMaxHeight'],
      'quality'=>$config['mediaQuality'],
      'preserveExif'=>false,
      'forceEffect'=>false,
      'targetType'=>IMG_GIF|IMG_JPG|IMG_PNG,
      'offDropWith'=>null,
      'onDropWith'=>null,
    ]
  ],
  'roots'=>[
    [
      'imgLib'=>'gd',
      'driver'=>'LocalFileSystem',
      'path'=>$_SERVER["DOCUMENT_ROOT"].DS.$settings['system']['url'].DS.($user['rank']<1000?'media'.DS:''),
      'URL'=>URL.($user['rank']<1000?'media'.DS:''),
      'tmbPath'=>$_SERVER["DOCUMENT_ROOT"].DS.$settings['system']['url'].DS.'media'.DS.'thumbs'.DS,
      'tmbURL'=>URL.'media'.DS.'thumbs'.DS,
      'tmbSize'=>$config['mediaMaxWidthThumb'],
      'tmbBgColor'=>'transparent',
      'uploadDeny'=>[
        'all',
      ],
      'uploadAllow'=>[
        $user['options'][12]==1?'image':'',
        $user['options'][15]==1?'text/plain':'',
        $user['options'][15]==1?'text/html':'',
        $user['options'][15]==1?'application/pdf':'',
        $user['options'][15]==1?'application/x-php':'',
        $user['options'][15]==1?'text/x-php':'',
      ],
      'uploadOrder'=>[
        'deny',
        'allow'
      ],
      'accessControl'=>'access',
      'attributes'=>[
        [
          'pattern'=>$folders,
          'hidden'=>true,
          'read'=>$user['options'][11]==1?true:false,
          'write'=>$user['options'][12]==1?true:false,
        ]
      ],
      'disabled'=>[
        $user['options'][13]==0?'extract':'',
        $user['options'][14]==0?'archive':'',
        $user['options'][10]==0?'mkdir':'',
      ]
    ]
  ]
];
$connector=new elFinderConnector(new elFinder($opts));
$connector->run();
