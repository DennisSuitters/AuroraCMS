<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update Cartage
 * @package    core/update_cartage.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
$getcfg=true;
require'db.php';
define('SESSIONID',session_id());
define('THEME','..'.DS.'layout'.DS.$config['theme']);
if(file_exists('layout'.DS.$config['theme'].DS.'images'.DS.'noimage.png'))
	define('NOIMAGE','layout'.DS.$config['theme'].DS.'images'.DS.'noimage.png');
elseif(file_exists('layout'.DS.$config['theme'].DS.'images'.DS.'noimage.gif'))
	define('NOIMAGE','layout'.DS.$config['theme'].DS.'images'.DS.'noimage.gif');
elseif(file_exists('layout'.DS.$config['theme'].DS.'images'.DS.'noimage.jpg'))
	define('NOIMAGE','layout'.DS.$config['theme'].DS.'images'.DS.'noimage.jpg');
else
	define('NOIMAGE','core'.DS.'images'.DS.'noimage.png');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$cq=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si ORDER BY `ti` DESC");
$cq->execute([
	':si'=>SESSIONID
]);
if($cq->rowCount()>0){
  $cartitem=$cartage='';
  while($cr=$cq->fetch(PDO::FETCH_ASSOC)){
    $cs=$db->prepare("SELECT * from `".$prefix."content` WHERE `id`=:id");
    $cs->execute([
			':id'=>$cr['iid']
		]);
    $ci=$cs->fetch(PDO::FETCH_ASSOC);
    $cartitem=$theme['settings']['cartage_menu'];
    if($ci['thumb']=='')$ci['thumb']=NOIMAGE;
    $cartitem=preg_replace([
      '/<print cartageitem=[\"\']?thumb[\"\']?>/',
      '/<print cartageitem=[\"\']?title[\"\']?>/',
      '/<print cartageitem=[\"\']?quantity[\"\']?>/'
    ],[
      $ci['thumb'],
      $ci['title'],
      $cr['quantity']
    ],$cartitem);
    $cartage.=$cartitem;
  }
  echo$cartage;
}
