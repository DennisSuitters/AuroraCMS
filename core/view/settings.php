<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Settings
 * @package    core/view/settings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$currentPassCSS=$matchPassCSS='';
$currentPassHidden=$matchPassHidden=$successHidden=$success=$theme['settings']['settings_hidden'];
$successShow=$theme['settings']['settings_show'];
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
if(isset($_SESSION['uid'])&&$_SESSION['uid']>0){
	$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
	$s->execute([
		':id'=>$_SESSION['uid']
	]);
	$user=$s->fetch(PDO::FETCH_ASSOC);
}
if((isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)&&(isset($user)&&$user['rank']>0)){
	if(isset($act)&&$act=='updatePassword'){
		if(isset($_POST['emailtrap'])&&$_POST['emailtrap']==''){
			$password=filter_input(INPUT_POST,'newPass',FILTER_SANITIZE_STRING);
			$hash=password_hash($password,PASSWORD_DEFAULT);
			$su=$db->prepare("UPDATE `".$prefix."login` SET `password`=:hash WHERE `id`=:id");
			$su->execute([
				':hash'=>$hash,
				':id'=>$user['id']
			]);
			$success='';
		}
	}
	if(isset($act)&&$act=='updateAccount'&&isset($_POST['emailTrap'])&&$_POST['emailTrap']==''){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
		$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
		$url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_STRING);
		$business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
		$phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
		$mobile=filter_input(INPUT_POST,'mobile',FILTER_SANITIZE_STRING);
		$address=filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
		$suburb=filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_STRING);
		$city=filter_input(INPUT_POST,'city',FILTER_SANITIZE_STRING);
		$state=filter_input(INPUT_POST,'state',FILTER_SANITIZE_STRING);
		$postcode=filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING);
		$country=filter_input(INPUT_POST,'country',FILTER_SANITIZE_STRING);
		$s=$db->prepare("UPDATE `".$prefix."login` SET `email`=:email,`name`=:name,`url`=:url,`business`=:business,`phone`=:phone,`mobile`=:mobile,`address`=:address,`suburb`=:suburb,`city`=:city,`state`=:state,`postcode`=:postcode,`country`=:country WHERE `id`=:id");
		$s->execute([
			':email'=>$email,
			':name'=>$name,
			':url'=>$url,
			':business'=>$business,
			':phone'=>$phone,
			':mobile'=>$mobile,
			':address'=>$address,
			':suburb'=>$suburb,
			':city'=>$city,
			':state'=>$state,
			':postcode'=>$postcode,
			':country'=>$country,
			':id'=>$user['id']
		]);
		$e=$db->errorInfo();
		if(is_null($e[2])){
			$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
			$s->execute([
				':id'=>$user['id']
			]);
			$user=$s->fetch(PDO::FETCH_ASSOC);
			if(stristr($html,'<success accountHidden>'))
				$html=str_replace('<success accountHidden>',$theme['settings']['settings_show'],$html);
			if(stristr($html,'<error accountHidden>'))
				$html=str_replace('<error accountHidden>',$theme['settings']['settings_hidden'],$html);
		}else{
			if(stristr($html,'<success accountHidden>'))
				$html=str_replace('<success accountHidden>',$theme['settings']['settings_hidden'],$html);
			if(stristr($html,'<error accountHidden>'))
				$html=str_replace('<error accountHidden>',$theme['settings']['settings_show'],$html);
		}
	}else{
		if(stristr($html,'<success accountHidden>'))
			$html=str_replace('<success accountHidden>',$theme['settings']['settings_hidden'],$html);
		if(stristr($html,'<error accountHidden>'))
			$html=str_replace('<error accountHidden>',$theme['settings']['settings_hidden'],$html);
	}
	if(stristr($html,'<error currentPassCSS>'))
		$html=str_replace('<error currentPassCSS>',$currentPassCSS,$html);
	if(stristr($html,'<error currentPassHidden>'))
		$html=str_replace('<error currentPassHidden>',$currentPassHidden,$html);
	if(stristr($html,'<error matchPassCSS>'))
		$html=str_replace('<error matchPassCSS>',$matchPassCSS,$html);
	if(stristr($html,'<error matchPassHidden>'))
		$html=str_replace('<error matchPassHidden>',$matchPassHidden,$html);
	if(stristr($html,'<success passUpdated>'))
		$html=str_replace('<success passUpdated>',$success,$html);
	$rank='Visitor';
	switch($user['rank']){
		case 100:
			$rank='Subscriber';
			break;
		case 200:
			$rank='Member';
			break;
		case 300:
			$rank='Client';
			break;
		case 400:
			$rank='Contributor';
			break;
		case 500:
			$rank='Moderator';
			break;
		case 600:
			$rank='Author';
			break;
		case 700:
			$rank='Editor';
			break;
		case 800:
			$rank='Manager';
			break;
		case 900:
			$rank='Administrator';
			break;
		case 1000:
			$rank='Developer';
			break;
		default:
			$rank='Visitor';
			break;
	}
	if($user['postcode']==0)
		$user['postcode']='';
	$html=preg_replace([
		'/<print user=[\"\']?gravatar[\"\']?>/',
		'/<print user=[\"\']?ti[\"\']?>/',
		'/<print user=[\"\']?username[\"\']?>/',
		'/<print user=[\"\']?rank[\"\']?>/',
		'/<print user=[\"\']?id[\"\']?>/',
		'/<print user=[\"\']?email[\"\']?>/',
		'/<print user=[\"\']?name[\"\']?>/',
		'/<print user=[\"\']?url[\"\']?>/',
		'/<print user=[\"\']?business[\"\']?>/',
		'/<print user=[\"\']?phone[\"\']?>/',
		'/<print user=[\"\']?mobile[\"\']?>/',
		'/<print user=[\"\']?address[\"\']?>/',
		'/<print user=[\"\']?suburb[\"\']?>/',
		'/<print user=[\"\']?city[\"\']?>/',
		'/<print user=[\"\']?state[\"\']?>/',
		'/<print user=[\"\']?postcode[\"\']?>/',
		'/<print user=[\"\']?country[\"\']?>/'
	],[
		htmlspecialchars($user['gravatar'],ENT_QUOTES,'UTF-8'),
		date($config['dateFormat'],$user['ti']),
		htmlspecialchars($user['username'],ENT_QUOTES,'UTF-8'),
		$rank,
		htmlspecialchars($user['id'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['email'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['name'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['url'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['business'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['phone'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['mobile'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['address'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['suburb'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['city'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['state'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['postcode'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['country'],ENT_QUOTES,'UTF-8')
	],$html);
}else{
	$html='';
	if(file_exists(THEME.DS.'noaccess.html'))
		$html=file_get_contents(THEME.DS.'noaccess.html');
}
$content.=$html;
