<?php
define('DS',DIRECTORY_SEPARATOR);
include_once dirname(__FILE__).DS.'autoload.php';
include_once dirname(__FILE__).DS.'elFinderConnector.class.php';
include_once dirname(__FILE__).DS.'elFinder.class.php';
include_once dirname(__FILE__).DS.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DS.'elFinderVolumeLocalFileSystem.class.php';
$settings=parse_ini_file('..'.DS.'..'.DS.'..'.DS.'core'.DS.'config.ini',TRUE);
$prefix=$settings['database']['prefix'];
$dns=((!empty($settings['database']['driver']))?($settings['database']['driver']):'').((!empty($settings['database']['host']))?(':host='.$settings['database']['host']):'').((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').((!empty($settings['database']['schema']))?(';dbname='.$settings['database']['schema']):'');
$db=new PDO($dns, $settings['database']['username'],$settings['database']['password']);
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if ((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL', 'https://');else define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
function access($attr,$path,$data,$volume){
  return strpos(basename($path),'.')===0? !($attr=='read'||$attr=='write'):null;
}
$mediaEnable=($config['options'][2]==0)?false:true;
if($config['mediaMaxWidth']==0 && $mediaEnable==true)$mediaEnable==false;
if($config['mediaMaxHeight']==0 && $mediaEnable==true)$mediaEnable==false;
$opts=array(
  'bind' => array(
    'upload.presave' => array(
      'Plugin.AutoResize.onUpLoadPreSave'
    ),
    'mkdir.pre mkfile.pre rename.pre' => array(
      'Plugin.Sanitizer.cmdPreprocess'
    ),
    'upload.presave' => array(
      'Plugin.Sanitizer.onUploadPreSave'
    )
  ),
  'plugin' => array(
    'Sanitizer' => array(
      'enable' => true,
      'targets' => array('\\','/',':','*','?','"','<','>','|',' '),
      'replace' => '-'
    ),
    'AutoResize' => array(
      'enable'       => $mediaEnable,
      'maxWidth'     => $config['mediaMaxWidth'],
      'maxHeight'    => $config['mediaMaxHeight'],
      'quality'      => $config['mediaQuality'],
      'preserveExif' => false,
      'forceEffect'  => false,
      'targetType'   => IMG_GIF|IMG_JPG|IMG_PNG,
      'offDropWith'  => null,
      'onDropWith'   => null
    )
  ),
  'roots' => array(
    array(
      'imgLib'      => 'gd',
      'driver'      => 'LocalFileSystem',
      'path'        => $_SERVER["DOCUMENT_ROOT"] . DS . $settings['system']['url'] . DS . 'media' . DS,
//      'path'=>$_SERVER["DOCUMENT_ROOT"].DS.$settings['system']['url'].DS,
      'URL'         => URL . 'media' . DS,
//      'URL'=>URL,
      'tmbPath'     => $_SERVER["DOCUMENT_ROOT"] . DS . $settings['system']['url'] . DS . 'media' . DS . 'thumbs' . DS,
      'tmbURL'      => URL . 'media' . DS . 'thumbs' . DS,
      'tmbSize'     => $config['mediaMaxWidthThumb'],
      'uploadDeny'  => array(
        'all'
      ),
      'uploadAllow' => array(
        'image',
        'text/plain',
        'text/html',
        'application/pdf',
        'application/x-php',
        'text/x-php'
      ),
      'uploadOrder' => array(
        'deny',
        'allow'
      ),
      'accessControl' => 'access',
      'attributes'    => array(
        array(
          'pattern' => '!^/core|layout|index.php!',
          'hidden'  => true
        )
      ),
      'disabled' => array(
        'extract',
        'archive',
        'mkdir'
      )
    )
  )
);
$connector=new elFinderConnector(new elFinder($opts));
$connector->run();
