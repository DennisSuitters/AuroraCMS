<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Settings
 * @package    core/view/settings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='';
$currentPassCSS=$matchPassCSS=$rosterNotification='';
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
	if(isset($act)){
		if($act=='updateRoster'){
			$uid=filter_input(INPUT_POST,'uid',FILTER_UNSAFE_RAW);
			$rES=filter_input(INPUT_POST,'rES',FILTER_UNSAFE_RAW);
			$rDN=filter_input(INPUT_POST,'rDN',FILTER_UNSAFE_RAW);
			$rTD=filter_input(INPUT_POST,'rTD',FILTER_UNSAFE_RAW);
			$rSW=filter_input(INPUT_POST,'rSW',FILTER_UNSAFE_RAW);
			$sr=$db->prepare("UPDATE `".$prefix."login` SET `rosterExtraShifts`=:rES, `rosterDayName`=:rDN, `rosterTimeDisplay`=:rTD, `rosterShowWeeks`=:rSW WHERE `id`=:uid");
			$sr->execute([
				':uid'=>$uid,
				':rES'=>$rES,
				':rDN'=>$rDN,
				':rTD'=>$rTD,
				':rSW'=>$rSW
			]);
			$rosterNotification='<div class="alert alert-success">Roster Settings Updated!</div>';
			$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
			$s->execute([':id'=>$_SESSION['uid']]);
			$user=$s->fetch(PDO::FETCH_ASSOC);
		}
		if($act=='updatePassword'){
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
		if($act=='updateAccount'){
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
				$html=preg_replace([
					'/<success accountHidden>/',
					'/<error accountHidden>/'
				],[
					' d-block',
					' d-none'
				],$html);
			}else{
				$html=preg_replace([
					'/<success accountHidden>/',
					'/<error accountHidden>/'
				],[
					' d-none',
					' d-block'
				],$html);
			}
		}else{
			$html=preg_replace([
				'/<success accountHidden>/',
				'/<error accountHidden>/'
			],
				' d-none'
			,$html);
		}
	}else{
		$html=preg_replace([
			'/<success accountHidden>/',
			'/<error accountHidden>/'
		],
			' d-none'
		,$html);
	}
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
		'/<print user=[\"\']?country[\"\']?>/',
		'/<error currentPassCSS>/',
		'/<error currentPassHidden>/',
		'/<error matchPassCSS>/',
		'/<error matchPassHidden>/',
		'/<success passUpdated>/',
		($user['employee']==1?'/<[\/]?employeeroster>/':'~<employeeroster>.*?<\/employeeroster>~is'),
		'/<rosterNotification>/',
		'/<rosterExtraShiftsOptions>/',
		'/<rosterDayNameOptions>/',
		'/<rosterTimeDisplayOptions>/',
		'/<rosterShowWeeksOptions>/',
		'/<print url>/'
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
		htmlspecialchars($user['country'],ENT_QUOTES,'UTF-8'),
		$currentPassCSS,
		$currentPassHidden,
		$matchPassCSS,
		$matchPassHidden,
		$success,
		'',
		$rosterNotification,
		'<option value="def"'.($user['rosterExtraShifts']=='def'?' selected':'').'>System Default ('.($config['rosterExtraShifts']=='true'?'Yes':'No').')</option>'.
			'<option value="true"'.($user['rosterExtraShifts']=='true'?' selected':'').'>Yes</option>'.
			'<option value="false"'.($user['rosterExtraShifts']=='false'?' selected':'').'>No</option>',
		'<option value="def"'.($user['rosterDayName']=='def'?' selected':'').'>System Default  ('.($config['rosterDayName']=='l'?'Fullname':'Short name').')</option>'.
			'<option value="l"'.($user['rosterDayName']=='l'?' selected':'').'>Fullname ('.date('l',time()).')</option>'.
			'<option value="D"'.($user['rosterDayName']=='D'?' selected':'').'>Short name ('.date('D',time()).')</option>',
		'<option value="def"'.($user['rosterTimeDisplay']=='def'?' selected':'').'>System Default ('.date($config['rosterTimeDisplay'],time()).')</option>'.
			'<option value="H:i"'.($user['rosterTimeDisplay']=='H:i'?' selected':'').'>24-hour Format ('.date('H:i',time()).')</option>'.
			'<option value="g:ia"'.($user['rosterTimeDisplay']=='g:ia'?' selected':'').'>12-hour Format ('.date('g:ia',time()).')</option>',
		'<option value="0"'.($user['rosterShowWeeks']=='0'?' selected':'').'>System Default ('.$config['rosterShowWeeks'].')</option>'.
			'<option value="1"'.($user['rosterShowWeeks']=='1'?' selected':'').'>1 Week</option>'.
			'<option value="2"'.($user['rosterShowWeeks']=='2'?' selected':'').'>2 Weeks</option>'.
			'<option value="4"'.($user['rosterShowWeeks']=='4'?' selected':'').'>4 Weeks</option>',
		URL
	],$html);
	if(stristr($html,'<orderitems')){
		preg_match('/<orderitems>([\w\W]*?)<\/orderitems>/',$html,$match);
		$items=$match[1];
		$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `cid`=:cid AND `status`!='archived' ORDER BY `ti` DESC");
	  $s->execute([':cid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
		$output='';
		if($s->rowCount()>0){
	  	while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$item=$items;
				$item=preg_replace([
					'/<print order=[\"\']?ordernumber[\"\']?>/',
	      	'/<print order=[\"\']?status[\"\']?>/',
					'/<print order=[\"\']?hold[\"\']?>/',
	      	'/<print order=[\"\']?date[\"\']?>/',
	      	'/<print order=[\"\']?duedate[\"\']?>/',
	      	'/<print link>/'
				],[
					$r['qid'].$r['iid'],
					$r['status'],
					($r['hold']==1?($r['process'][3]==1 || $r['process'][4]==1?'':'<br><span class="badger badge-info mt-1">Order Held For Pickup!</span>'):''),
		      ($r['iid_ti']>0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti'])),
	      	date($config['dateFormat'],$r['due_ti']),
		      URL.'orders/'.$r['qid'].$r['iid'].'/',
				],$item);
				$output.=$item;
			}
		}else $output='<div class="row"><div class="col-12 p-3 text-center text-3x">No Orders made via Your Account!</div></div>';
		$html=preg_replace('~<orderitems>.*?<\/orderitems>~is',$output,$html,1);
	}
	if(stristr($html,'<reviewitems')){
		preg_match('/<reviewitems>([\w\W]*?)<\/reviewitems>/',$html,$match);
		$items=$match[1];
		$s=$db->prepare("SELECT `id`,`rid`,`cid`,`notes`,`status` FROM `".$prefix."comments` WHERE `contentType`='review' AND `email`=:email");
	  $s->execute([':email'=>$user['email']]);
		$output='';
		if($s->rowCount()>0){
	  	while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$si=$db->prepare("SELECT `id`,`file`,`title` FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([':id'=>$r['rid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$item=$items;
				$item=preg_replace([
					'/<print content=[\"\']?image[\"\']?>/',
					'/<print content=[\"\']?title[\"\']?>/',
	      	'/<print review=[\"\']?rating[\"\']?>/',
					'/<print review=[\"\']?notes[\"\']?>/',
	      	'/<print review=[\"\']?status[\"\']?>/',
				],[
					($i['file']!=''?$i['file']:NOIMAGE),
					$i['title'],
					'<span class="rating small"><span'.($r['cid']>=1?' class="set"':'').'></span><span'.($r['cid']>=2?' class="set"':'').'></span><span'.($r['cid']>=3?' class="set"':'').'></span><span'.($r['cid']>=4?' class="set"':'').'></span><span'.($r['cid']==5?' class="set"':'').'></span></span>',
					'<div>'.strip_tags($r['notes']).'</div>',
					strtolower($r['status']),
				],$item);
				$output.=$item;
			}
		}else $output='<div class="row"><div class="col-12 p-3 text-center text-3x">No Reviews made via Your Account!</div></div>';
		$html=preg_replace('~<reviewitems>.*?<\/reviewitems>~is',$output,$html,1);
	}
	if(stristr($html,'<commentitems')){
		preg_match('/<commentitems>([\w\W]*?)<\/commentitems>/',$html,$match);
		$items=$match[1];
		$s=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='article' AND `uid`=:uid");
	  $s->execute([':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
		$output='';
		if($s->rowCount()>0){
	  	while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$si=$db->prepare("SELECT `file`,`title` FROM `".$prefix."content` WHERE `id`=:id");
				$si->execute([':id'=>$r['rid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$item=$items;
				$item=preg_replace([
					'/<print content=[\"\']?image[\"\']?>/',
					'/<print content=[\"\']?title[\"\']?>/',
					'/<print comment=[\"\']?notes[\"\']?>/',
	      	'/<print comment=[\"\']?status[\"\']?>/',
				],[
					($i['file']!=''?$i['file']:NOIMAGE),
					$i['title'],
					'<div>'.strip_tags($r['notes']).'</div>',
					strtolower($r['status']),
				],$item);
				$output.=$item;
			}
		}else $output='<div class="row"><div class="col-12 p-3 text-center text-3x">No Comments made via Your Account!</div></div>';
		$html=preg_replace('~<commentitems>.*?<\/commentitems>~is',$output,$html,1);
	}
	if(stristr($html,'<testimonialitems')){
		preg_match('/<testimonialitems>([\w\W]*?)<\/testimonialitems>/',$html,$match);
		$items=$match[1];
		$s=$db->prepare("SELECT `id`,`name`,`rating`,`notes`,`status` FROM `".$prefix."content` WHERE `contentType`='testimonials' AND `email`=:email");
	  $s->execute([':email'=>$user['email']]);
		$output='';
		if($s->rowCount()>0){
	  	while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$item=$items;
				$item=preg_replace([
					'/<print testimonial=[\"\']?name[\"\']?>/',
					'/<print testimonial=[\"\']?rating[\"\']?>/',
					'/<print testimonial=[\"\']?notes[\"\']?>/',
	      	'/<print testimonial=[\"\']?status[\"\']?>/',
				],[
					$r['name'],
					'<span class="rating small"><span'.($r['rating']>=1?' class="set"':'').'></span><span'.($r['rating']>=2?' class="set"':'').'></span><span'.($r['rating']>=3?' class="set"':'').'></span><span'.($r['rating']>=4?' class="set"':'').'></span><span'.($r['rating']==5?' class="set"':'').'></span></span>',
					'<div>'.strip_tags($r['notes']).'</div>',
					strtolower($r['status']),
				],$item);
				$output.=$item;
			}
		}else $output='<div class="row"><div class="col-12 p-3 text-center text-3x">No Testimonials made via Your Account!</div></div>';
		$html=preg_replace('~<testimonialitems>.*?<\/testimonialitems>~is',$output,$html,1);
	}
	if(stristr($html,'<rewarditems')){
		preg_match('/<rewarditems>([\w\W]*?)<\/rewarditems>/',$html,$match);
		$items=$match[1];
		$s=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `uid`=:uid");
	  $s->execute([':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
		$output='';
		if($s->rowCount()>0){
	  	while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$item=$items;
				$item=preg_replace([
					'/<print reward=[\"\']?code[\"\']?>/',
					'/<print reward=[\"\']?title[\"\']?>/',
					'/<print reward=[\"\']?method[\"\']?>/',
	      	'/<print reward=[\"\']?quantity[\"\']?>/',
					'/<print reward=[\"\']?tis[\"\']?>/',
					'/<print reward=[\"\']?tie[\"\']?>/'
				],[
					($r['code']!=''?'<div>Code: '.$r['code'].'</div>':''),
					'<div>'.$r['title'].'</div>',
					($r['method']==0?$r['value'].'% Off':'&dollar;'.$r['value'].' Off'),
					'<span title="Used">'.$r['used'].'</span>'.($r['quantity']>0?'/'.$r['quantity']:''),
					($r['tis']>0?'<div>Start: '.date($config['dateFormat'],$r['tis']).'</div>':''),
					($r['tie']>0?'<div>End: '.date($config['dateFormat'],$r['tie']).'</div>':'No Time Limit')
				],$item);
				$output.=$item;
			}
		}else $output='<div class="row"><div class="col-12 p-3 text-center text-3x">No Rewards are assigned to Your Account!</div></div>';
		$html=preg_replace('~<rewarditems>.*?<\/rewarditems>~is',$output,$html,1);
	}
	$sp=$db->prepare("SELECT COUNT(`pid`) AS `cnt` FROM `".$prefix."forumPosts` WHERE `pid`=0 AND `uid`=:uid");
	$sp->execute([':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
	$rp=$sp->fetch(PDO::FETCH_ASSOC);
	$sv=$db->prepare("SELECT SUM(`views`) AS `cnt` FROM `".$prefix."forumPosts` WHERE `pid`=0 AND `uid`=:uid");
	$sv->execute([':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
	$rv=$sv->fetch(PDO::FETCH_ASSOC);
	$sc=$db->prepare("SELECT COUNT(`pid`) AS `cnt` FROM `".$prefix."forumPosts` WHERE `pid`!=0 AND `uid`=:uid");
	$sc->execute([':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	$st=$db->prepare("SELECT COUNT(`tid`) AS `cnt` FROM `".$prefix."forumPosts` WHERE `tid`!=0 AND `uid`=:uid");
	$st->execute([':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
	$rt=$st->fetch(PDO::FETCH_ASSOC);
	$html=preg_replace([
		'/<print forum=[\"\']?posts[\"\']?>/',
		'/<print forum=[\"\']?comments[\"\']?>/',
		'/<print forum=[\"\']?views[\"\']?>/',
		'/<print forum=[\"\']?tickets[\"\']?>/'
	],[
		($rp['cnt']>0?short_number($rp['cnt']):0),
		($rc['cnt']>0?short_number($rc['cnt']):0),
		($rv['cnt']>0?short_number($rv['cnt']):0),
		($rt['cnt']>0?short_number($rt['cnt']):0)
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
