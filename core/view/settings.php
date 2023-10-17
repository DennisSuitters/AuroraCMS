<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Settings
 * @package    core/view/settings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='';
$currentPassCSS=$matchPassCSS='';
$currentPassHidden=$matchPassHidden=$successHidden=$success=$theme['settings']['hidden'];
$successShow=$theme['settings']['show'];
$act=filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW);
if(isset($_SESSION['uid'])&&$_SESSION['uid']>0){
	$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
	$s->execute([':id'=>$_SESSION['uid']]);
	$user=$s->fetch(PDO::FETCH_ASSOC);
}
if((isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)&&(isset($user)&&$user['rank']>0)){
	$html=preg_replace([
		'/<print page=[\"\']?heading[\"\']?>/',
	  '/<print page=[\"\']?notes[\"\']?>/',
		$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is'
	],[
		htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
	  $page['notes'],
		''
	],$html);
	if(isset($act)&&$act=='updatePassword'){
		if(isset($_POST['emailtrap'])&&$_POST['emailtrap']=='none'){
			$password=filter_input(INPUT_POST,'newPass',FILTER_UNSAFE_RAW);
			$hashpwd=password_hash($password,PASSWORD_DEFAULT);
			$su=$db->prepare("UPDATE `".$prefix."login` SET `password`=:hash WHERE `id`=:id");
			$su->execute([
				':hash'=>$hashpwd,
				':id'=>$user['id']
			]);
			$success='';
		}
	}
	if(isset($act)&&$act=='updateAccount'){
		$email=filter_input(INPUT_POST,'email',FILTER_UNSAFE_RAW);
		$name=filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW);
		$url=filter_input(INPUT_POST,'url',FILTER_UNSAFE_RAW);
		$business=filter_input(INPUT_POST,'business',FILTER_UNSAFE_RAW);
		$phone=filter_input(INPUT_POST,'phone',FILTER_UNSAFE_RAW);
		$mobile=filter_input(INPUT_POST,'mobile',FILTER_UNSAFE_RAW);
		$address=filter_input(INPUT_POST,'address',FILTER_UNSAFE_RAW);
		$suburb=filter_input(INPUT_POST,'suburb',FILTER_UNSAFE_RAW);
		$city=filter_input(INPUT_POST,'city',FILTER_UNSAFE_RAW);
		$state=filter_input(INPUT_POST,'state',FILTER_UNSAFE_RAW);
		$postcode=filter_input(INPUT_POST,'postcode',FILTER_UNSAFE_RAW);
		$country=filter_input(INPUT_POST,'country',FILTER_UNSAFE_RAW);
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
			':postcode'=>$postcode==''?0:$postcode,
			':country'=>$country,
			':id'=>$user['id']
		]);
		$e=$db->errorInfo();
		if(is_null($e[2])){
			$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
			$s->execute([':id'=>$user['id']]);
			$user=$s->fetch(PDO::FETCH_ASSOC);
			$html=str_replace([
				'<success accountHidden>',
				'<error accountHidden>'
			],[
				$theme['settings']['show'],
				$theme['settings']['hidden']
			],$html);
		}else{
			$html=str_replace([
				'<success accountHidden>',
				'<error accountHidden>'
			],[
				$theme['settings']['hidden'],
				$theme['settings']['show']
			],$html);
		}
	}else{
		$html=str_replace([
			'<success accountHidden>',
			'<error accountHidden>'
		],
			$theme['settings']['hidden']
		,$html);
	}
	$html=str_replace([
		'<error currentPassCSS>',
		'<error currentPassHidden>',
		'<error matchPassCSS>',
		'<error matchPassHidden>',
		'<success passUpdated>'
	],[
		$currentPassCSS,
		$currentPassHidden,
		$matchPassCSS,
		$matchPassHidden,
		$success
	],$html);
	$html=preg_replace([
		'/<print user=[\"\']?avatar[\"\']?>/',
		'/<print user=[\"\']?gravatar[\"\']?>/',
		'/<print user=[\"\']?ti[\"\']?>/',
		'/<print user=[\"\']?username[\"\']?>/',
		'/<print user=[\"\']?rank[\"\']?>/',
		'/<print user=[\"\']?id[\"\']?>/',
		'/<print user=[\"\']?spent[\"\']?>/',
		'/<print user=[\"\']?points[\"\']?>/',
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
		$user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar'])?'media/avatar/'.$user['avatar']:NOAVATAR,
		htmlspecialchars($user['gravatar'],ENT_QUOTES,'UTF-8'),
		date($config['dateFormat'],$user['ti']),
		htmlspecialchars($user['username'],ENT_QUOTES,'UTF-8'),
		ucwords(str_replace('-',' ',rank($user['rank']))).(($user['rank']>301||$user['rank']<399)&&$user['options'][19]==1?'':' (Approval Pending)'),
		htmlspecialchars($user['id'],ENT_QUOTES,'UTF-8'),
		number_format((float)$user['spent'],2,'.',''),
		number_format((float)$user['points']),
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
		$user['postcode']==0?'':htmlspecialchars($user['postcode'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($user['country'],ENT_QUOTES,'UTF-8')
	],$html);
	if(isset($act)&&$act=='deactivate'){
		$s=$db->prepare("UPDATE `".$prefix."login` SET `active`=0,`password`='',`status`='deactivated',`points`=0 WHERE `id`=:id");
		$s->execute([':id'=>$user['id']]);
		header("location:".URL);
	}
}else{
	if(file_exists(THEME.'/noaccess.html'))
		$html=file_get_contents(THEME.'/noaccess.html');
}
$content.=$html;
