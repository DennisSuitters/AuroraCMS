<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Side Menu
 * @package    core/view/side_menu.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sideTemp='';
if(file_exists(THEME.'/side_courses.html')){
	$sideTemp=file_get_contents(THEME.'/side_courses.html');
	$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
	$ru=[
		'options'=>'00000000000000000000000000000000',
		'rank'=>0
	];
	if($uid!=0){
		$su=$db->prepare("SELECT `options`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
		$su->execute([':id'=>$uid]);
		$ru=$su->fetch(PDO::FETCH_ASSOC);
	}else $sideTemp='';
	$sortOptions=
		'<option value="new"'.(isset($sort)&&$sort=='new'?' selected':'').'>Newest</option>'.
		'<option value="old"'.(isset($sort)&&$sort=='old'?' selected':'').'>Oldest</option>'.
		'<option value="namea"'.(isset($sort)&&$sort=='namea'?' selected':'').'>Name: A-Z</option>'.
		'<option value="namez"'.(isset($sort)&&$sort=='namez'?' selected':'').'>Name: Z-A</option>'.
		'<option value="best"'.(isset($sort)&&$sort=='best'?' selected':'').'>Best Selling</option>'.
		'<option value="view"'.(isset($sort)&&$sort=='view'?' selected':'').'>Most viewed</option>'.
		'<option value="priceh"'.(isset($sort)&&$sort=='priceh'?' selected':'').'>Price: High to low</option>'.
		'<option value="pricel"'.(isset($sort)&&$sort=='pricel'?' selected':'').'>Price: Low to High</option>';
	$sct=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."courseTrack` WHERE `complete`='done' AND `uid`=:uid");
	$sct->execute([
		':uid'=>$user['id']
	]);
	$rct=$sct->fetch(PDO::FETCH_ASSOC);
	$sideTemp=preg_replace([
		isset($args[0])?'~<sort>.*?<\/sort>~is':'/<[\/]?sort>/',
		isset($args[0])?'~<stats>.*?<\/stats>~is':'/<[\/]?stats>/',
		'/<print sort=[\"\']?self[\"\/]?>/',
		'/<sortOptions>/',
		$config['showItems']>0?'/<[\/]?showItems>/':'~<showItems>.*?<\/showItems>~is',
		'/<itemCount>/',
		'/<print stats=[\"\']?complete[\"\']?>/'
	],[
		'',
		'',
		(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://").$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		$sortOptions,
		'',
		$config['showItems'],
		$rct['cnt']
	],$sideTemp);
}
$content.=$sideTemp;
