<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Roster
 * @package    core/view/roster.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if((isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)&&(isset($user)&&$user['rank']>0)){
	preg_match('/<rosteritems>([\w\W]*?)<\/rosteritems>/',$html,$match);
	$rosteritem=$match[1];
	$rosterhtml='';
	$rosterExtraShifts=($user['rosterExtraShifts']!='def'?$user['rosterExtraShifts']:$config['rosterExtraShifts']);
	$rosterDayName=($user['rosterDayName']!='def'?$user['rosterDayName']:$config['rosterDayName']);
	$rosterTimeDisplay=($user['rosterTimeDisplay']!='def'?$user['rosterTimeDisplay']:$config['rosterTimeDisplay']);
	$rostercnt=($user['rosterShowWeeks']==0?$config['rosterShowWeeks']:$user['rosterShowWeeks']);
	$week1mon=strtotime('monday this week');
	$week1tue=strtotime('tuesday this week');
	$week1wed=strtotime('wednesday this week');
	$week1thu=strtotime('thursday this week');
	$week1fri=strtotime('friday this week');
	$week1sat=strtotime('saturday this week');
	$week1sun=strtotime('sunday this week');
	$week2mon=strtotime('monday next week');
	$week2tue=strtotime('tuesday next week');
	$week2wed=strtotime('wednesday next week');
	$week2thu=strtotime('thursday next week');
	$week2fri=strtotime('friday next week');
	$week2sat=strtotime('saturday next week');
	$week2sun=strtotime('sunday next week');
	$week3mon=strtotime('monday this week +2 weeks');
	$week3tue=strtotime('tuesday this week +2 weeks');
	$week3wed=strtotime('wednesday this week +2 weeks');
	$week3thu=strtotime('thursday this week +2 weeks');
	$week3fri=strtotime('friday this week +2 weeks');
	$week3sat=strtotime('saturday this week +2 weeks');
	$week3sun=strtotime('sunday this week +2 weeks');
	$week4mon=strtotime('monday this week +3 weeks');
	$week4tue=strtotime('tuesday this week +3 weeks');
	$week4wed=strtotime('wednesday this week +3 weeks');
	$week4thu=strtotime('thursday this week +3 weeks');
	$week4fri=strtotime('friday this week +3 weeks');
	$week4sat=strtotime('saturday this week +3 weeks');
	$week4sun=strtotime('sunday this week +3 weeks');
	$week5mon=strtotime('monday this week +4 weeks');
	$ti=time();
	$d1=$d2=$d3=$d4=$d5=$d6=$d7='';
	$d1status=$d2status=$d3status=$d4status=$d5status=$d6status=$d7status='';
	$d1s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
	$d1s->execute([':uid'=>$user['id'],':tis'=>$week1mon,':tie'=>$week1tue]);
	$dc=1;
	if($d1s->rowCount()>0){
		while($d1r=$d1s->fetch(PDO::FETCH_ASSOC)){
			$d1.=date($rosterTimeDisplay,$d1r['tis']).'-'.date($rosterTimeDisplay,$d1r['tie']).($dc<$d1s->rowCount()?'<br>':'');
			$d1status=($d1r['status']=='accepted'?' bg-warning':'');
			$dc++;
		}
	}
	$d2s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
	$d2s->execute([':uid'=>$user['id'],':tis'=>$week1tue,':tie'=>$week1wed]);
	$dc=1;
	if($d2s->rowCount()>0){
		while($d2r=$d2s->fetch(PDO::FETCH_ASSOC)){
			$d2.=date($rosterTimeDisplay,$d2r['tis']).'-'.date($rosterTimeDisplay,$d2r['tie']).($dc<$d2s->rowCount()?'<br>':'');
			$d2status=($d2r['status']=='accepted'?' bg-warning':'');
			$dc++;
		}
	}
	$d3s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
	$d3s->execute([':uid'=>$user['id'],':tis'=>$week1wed,':tie'=>$week1thu]);
	$dc=1;
	if($d3s->rowCount()>0){
		while($d3r=$d3s->fetch(PDO::FETCH_ASSOC)){
			$d3.=date($rosterTimeDisplay,$d3r['tis']).'-'.date($rosterTimeDisplay,$d3r['tie']).($dc<$d3s->rowCount()?'<br>':'');
			$d3status=($d3r['status']=='accepted'?' bg-warning':'');
			$dc++;
		}
	}
	$d4s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
	$d4s->execute([':uid'=>$user['id'],':tis'=>$week1thu,':tie'=>$week1fri]);
	$dc=1;
	if($d4s->rowCount()>0){
		while($d4r=$d4s->fetch(PDO::FETCH_ASSOC)){
			$d4.=date($rosterTimeDisplay,$d4r['tis']).'-'.date($rosterTimeDisplay,$d4r['tie']).($dc<$d4s->rowCount()?'<br>':'');
			$d4status=($d4r['status']=='accepted'?' bg-warning':'');
			$dc++;
		}
	}
	$d5s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
	$d5s->execute([':uid'=>$user['id'],':tis'=>$week1fri,':tie'=>$week1sat]);
	$dc=1;
	if($d5s->rowCount()>0){
		while($d5r=$d5s->fetch(PDO::FETCH_ASSOC)){
			$d5.=date($rosterTimeDisplay,$d5r['tis']).'-'.date($rosterTimeDisplay,$d5r['tie']).($dc<$d5s->rowCount()?'<br>':'');
			$d5status=($d5r['status']=='accepted'?' bg-warning':'');
			$dc++;
		}
	}
	$d6s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
	$d6s->execute([':uid'=>$user['id'],':tis'=>$week1sat,':tie'=>$week1sun]);
	$dc=1;
	if($d6s->rowCount()>0){
		while($d6r=$d6s->fetch(PDO::FETCH_ASSOC)){
			$d6.=date($rosterTimeDisplay,$d6r['tis']).'-'.date($rosterTimeDisplay,$d6r['tie']).($dc<$d6s->rowCount()?'<br>':'');
			$d6status=($d6r['status']=='accepted'?' bg-warning':'');
			$dc++;
		}
	}
	$d7s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
	$d7s->execute([':uid'=>$user['id'],':tis'=>$week1sun,':tie'=>$week2mon]);
	$dc=1;
	if($d7s->rowCount()>0){
		while($d7r=$d7s->fetch(PDO::FETCH_ASSOC)){
			$d7.=date($rosterTimeDisplay,$d7r['tis']).'-'.date($rosterTimeDisplay,$d7r['tie']).($dc<$d7s->rowCount()?'<br>':'');
			$d7status=($d7r['status']=='accepted'?' bg-warning':'');
			$dc++;
		}
	}
	$rosterheader=date('jS',$week1mon);
	if(date('n',$week1mon) != date('m',$week1sun))
		$rosterheader.=' '.date('F',$week1mon).' - ';
	else
		$rosterheader.=' - ';
	$rosterheader.=date('jS',$week1sun).' '.date('F Y',$week1mon).', Week '.number_format(date('W',$week1mon));
	$rosterhtml.=preg_replace([
		'/<print roster=[\"\']?heading[\"\']?>/',
		'/<print roster=[\"\']?daynamemonday[\"\']?>/',
		'/<print roster=[\"\']?daynametuesday[\"\']?>/',
		'/<print roster=[\"\']?daynamewednesday[\"\']?>/',
		'/<print roster=[\"\']?daynamethursday[\"\']?>/',
		'/<print roster=[\"\']?daynamefriday[\"\']?>/',
		'/<print roster=[\"\']?daynamesaturday[\"\']?>/',
		'/<print roster=[\"\']?daynamesunday[\"\']?>/',
		'/<print roster=[\"\']?shiftmonday[\"\']?>/',
		'/<print roster=[\"\']?statusmonday[\"\']?>/',
		'/<print roster=[\"\']?shifttuesday[\"\']?>/',
		'/<print roster=[\"\']?statustuesday[\"\']?>/',
		'/<print roster=[\"\']?shiftwednesday[\"\']?>/',
		'/<print roster=[\"\']?statuswednesday[\"\']?>/',
		'/<print roster=[\"\']?shiftthursday[\"\']?>/',
		'/<print roster=[\"\']?statusthursday[\"\']?>/',
		'/<print roster=[\"\']?shiftfriday[\"\']?>/',
		'/<print roster=[\"\']?statusfriday[\"\']?>/',
		'/<print roster=[\"\']?shiftsaturday[\"\']?>/',
		'/<print roster=[\"\']?statussatday[\"\']?>/',
		'/<print roster=[\"\']?shiftsunday[\"\']?>/',
		'/<print roster=[\"\']?statussunday[\"\']?>/'
	],[
		$rosterheader,
		date($rosterDayName,$week1mon),
		date($rosterDayName,$week1tue),
		date($rosterDayName,$week1wed),
		date($rosterDayName,$week1thu),
		date($rosterDayName,$week1fri),
		date($rosterDayName,$week1sat),
		date($rosterDayName,$week1sun),
		($d1!=''?$d1:'&nbsp;'),
		$d1status,
		($d2!=''?$d2:'&nbsp;'),
		$d2status,
		($d3!=''?$d3:'&nbsp;'),
		$d3status,
		($d4!=''?$d4:'&nbsp;'),
		$d4status,
		($d5!=''?$d5:'&nbsp;'),
		$d5status,
		($d6!=''?$d6:'&nbsp;'),
		$d6status,
		($d7!=''?$d7:'&nbsp;'),
		$d7status,
	],$rosteritem);

	if($rostercnt>1){
		$d1=$d2=$d3=$d4=$d5=$d6=$d7='';
		$d1status=$d2status=$d3status=$d4status=$d5status=$d6status=$d7status='';
		$d1s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d1s->execute([':uid'=>$user['id'],':tis'=>$week2mon,':tie'=>$week2tue]);
		$dc=1;
		if($d1s->rowCount()>0){
			while($d1r=$d1s->fetch(PDO::FETCH_ASSOC)){
				$d1.=date($rosterTimeDisplay,$d1r['tis']).'-'.date($rosterTimeDisplay,$d1r['tie']).($dc<$d1s->rowCount()?'<br>':'');
				$d1status=($d1r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d2s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d2s->execute([':uid'=>$user['id'],':tis'=>$week2tue,':tie'=>$week2wed]);
		$dc=1;
		if($d2s->rowCount()>0){
			while($d2r=$d2s->fetch(PDO::FETCH_ASSOC)){
				$d2.=date($rosterTimeDisplay,$d2r['tis']).'-'.date($rosterTimeDisplay,$d2r['tie']).($dc<$d2s->rowCount()?'<br>':'');
				$d2status=($d2r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d3s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d3s->execute([':uid'=>$user['id'],':tis'=>$week2wed,':tie'=>$week2thu]);
		$dc=1;
		if($d3s->rowCount()>0){
			while($d3r=$d3s->fetch(PDO::FETCH_ASSOC)){
				$d3.=date($rosterTimeDisplay,$d3r['tis']).'-'.date($rosterTimeDisplay,$d3r['tie']).($dc<$d3s->rowCount()?'<br>':'');
				$d3status=($d3r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d4s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d4s->execute([':uid'=>$user['id'],':tis'=>$week2thu,':tie'=>$week2fri]);
		$dc=1;
		if($d4s->rowCount()>0){
			while($d4r=$d4s->fetch(PDO::FETCH_ASSOC)){
				$d4.=date($rosterTimeDisplay,$d4r['tis']).'-'.date($rosterTimeDisplay,$d4r['tie']).($dc<$d4s->rowCount()?'<br>':'');
				$d4status=($d4r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d5s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d5s->execute([':uid'=>$user['id'],':tis'=>$week2fri,':tie'=>$week2sat]);
		$dc=1;
		if($d5s->rowCount()>0){
			while($d5r=$d5s->fetch(PDO::FETCH_ASSOC)){
				$d5.=date($rosterTimeDisplay,$d5r['tis']).'-'.date($rosterTimeDisplay,$d5r['tie']).($dc<$d5s->rowCount()?'<br>':'');
				$d5status=($d5r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d6s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d6s->execute([':uid'=>$user['id'],':tis'=>$week2sat,':tie'=>$week2sun]);
		$dc=1;
		if($d6s->rowCount()>0){
			while($d6r=$d6s->fetch(PDO::FETCH_ASSOC)){
				$d6.=date($rosterTimeDisplay,$d6r['tis']).'-'.date($rosterTimeDisplay,$d6r['tie']).($dc<$d6s->rowCount()?'<br>':'');
				$d6status=($d6r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d7s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d7s->execute([':uid'=>$user['id'],':tis'=>$week2sun,':tie'=>$week3mon]);
		$dc=1;
		if($d7s->rowCount()>0){
			while($d7r=$d7s->fetch(PDO::FETCH_ASSOC)){
				$d7.=date($rosterTimeDisplay,$d7r['tis']).'-'.date($rosterTimeDisplay,$d7r['tie']).($dc<$d7s->rowCount()?'<br>':'');
				$d7status=($d7r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$rosterheader=date('jS',$week2mon);
		if(date('n',$week2mon) != date('m',$week2sun))
			$rosterheader.=' '.date('F',$week2mon).' - ';
		else
			$rosterheader.=' - ';
		$rosterheader.=date('jS',$week2sun).' '.date('F Y',$week2mon).', Week '.number_format(date('W',$week2mon));
		$rosterhtml.=preg_replace([
			'/<print roster=[\"\']?heading[\"\']?>/',
			'/<print roster=[\"\']?daynamemonday[\"\']?>/',
			'/<print roster=[\"\']?daynametuesday[\"\']?>/',
			'/<print roster=[\"\']?daynamewednesday[\"\']?>/',
			'/<print roster=[\"\']?daynamethursday[\"\']?>/',
			'/<print roster=[\"\']?daynamefriday[\"\']?>/',
			'/<print roster=[\"\']?daynamesaturday[\"\']?>/',
			'/<print roster=[\"\']?daynamesunday[\"\']?>/',
			'/<print roster=[\"\']?shiftmonday[\"\']?>/',
			'/<print roster=[\"\']?statusmonday[\"\']?>/',
			'/<print roster=[\"\']?shifttuesday[\"\']?>/',
			'/<print roster=[\"\']?statustuesday[\"\']?>/',
			'/<print roster=[\"\']?shiftwednesday[\"\']?>/',
			'/<print roster=[\"\']?statuswednesday[\"\']?>/',
			'/<print roster=[\"\']?shiftthursday[\"\']?>/',
			'/<print roster=[\"\']?statusthursday[\"\']?>/',
			'/<print roster=[\"\']?shiftfriday[\"\']?>/',
			'/<print roster=[\"\']?statusfriday[\"\']?>/',
			'/<print roster=[\"\']?shiftsaturday[\"\']?>/',
			'/<print roster=[\"\']?statussatday[\"\']?>/',
			'/<print roster=[\"\']?shiftsunday[\"\']?>/',
			'/<print roster=[\"\']?statussunday[\"\']?>/'
		],[
			$rosterheader,
			date($rosterDayName,$week2mon),
			date($rosterDayName,$week2tue),
			date($rosterDayName,$week2wed),
			date($rosterDayName,$week2thu),
			date($rosterDayName,$week2fri),
			date($rosterDayName,$week2sat),
			date($rosterDayName,$week2sun),
			($d1!=''?$d1:'&nbsp;'),
			$d1status,
			($d2!=''?$d2:'&nbsp;'),
			$d2status,
			($d3!=''?$d3:'&nbsp;'),
			$d3status,
			($d4!=''?$d4:'&nbsp;'),
			$d4status,
			($d5!=''?$d5:'&nbsp;'),
			$d5status,
			($d6!=''?$d6:'&nbsp;'),
			$d6status,
			($d7!=''?$d7:'&nbsp;'),
			$d7status,
		],$rosteritem);
	}

	if($rostercnt==4){
		$d1=$d2=$d3=$d4=$d5=$d6=$d7='';
		$d1status=$d2status=$d3status=$d4status=$d5status=$d6status=$d7status='';
		$d1s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d1s->execute([':uid'=>$user['id'],':tis'=>$week3mon,':tie'=>$week3tue]);
		$dc=1;
		if($d1s->rowCount()>0){
			while($d1r=$d1s->fetch(PDO::FETCH_ASSOC)){
				$d1.=date($rosterTimeDisplay,$d1r['tis']).'-'.date($rosterTimeDisplay,$d1r['tie']).($dc<$d1s->rowCount()?'<br>':'');
				$d1status=($d1r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d2s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d2s->execute([':uid'=>$user['id'],':tis'=>$week3tue,':tie'=>$week3wed]);
		$dc=1;
		if($d2s->rowCount()>0){
			while($d2r=$d2s->fetch(PDO::FETCH_ASSOC)){
				$d2.=date($rosterTimeDisplay,$d2r['tis']).'-'.date($rosterTimeDisplay,$d2r['tie']).($dc<$d2s->rowCount()?'<br>':'');
				$d2status=($d2r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d3s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d3s->execute([':uid'=>$user['id'],':tis'=>$week3wed,':tie'=>$week3thu]);
		$dc=1;
		if($d3s->rowCount()>0){
			while($d3r=$d3s->fetch(PDO::FETCH_ASSOC)){
				$d3.=date($rosterTimeDisplay,$d3r['tis']).'-'.date($rosterTimeDisplay,$d3r['tie']).($dc<$d3s->rowCount()?'<br>':'');
				$d3status=($d3r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d4s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d4s->execute([':uid'=>$user['id'],':tis'=>$week3thu,':tie'=>$week3fri]);
		$dc=1;
		if($d4s->rowCount()>0){
			while($d4r=$d4s->fetch(PDO::FETCH_ASSOC)){
				$d4.=date($rosterTimeDisplay,$d4r['tis']).'-'.date($rosterTimeDisplay,$d4r['tie']).($dc<$d4s->rowCount()?'<br>':'');
				$d4status=($d4r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d5s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d5s->execute([':uid'=>$user['id'],':tis'=>$week3fri,':tie'=>$week3sat]);
		$dc=1;
		if($d5s->rowCount()>0){
			while($d5r=$d5s->fetch(PDO::FETCH_ASSOC)){
				$d5.=date($rosterTimeDisplay,$d5r['tis']).'-'.date($rosterTimeDisplay,$d5r['tie']).($dc<$d5s->rowCount()?'<br>':'');
				$d5status=($d5r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d6s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d6s->execute([':uid'=>$user['id'],':tis'=>$week3sat,':tie'=>$week3sun]);
		$dc=1;
		if($d6s->rowCount()>0){
			while($d6r=$d6s->fetch(PDO::FETCH_ASSOC)){
				$d6.=date($rosterTimeDisplay,$d6r['tis']).'-'.date($rosterTimeDisplay,$d6r['tie']).($dc<$d6s->rowCount()?'<br>':'');
				$d6status=($d6r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d7s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d7s->execute([':uid'=>$user['id'],':tis'=>$week3sun,':tie'=>$week4mon]);
		$dc=1;
		if($d7s->rowCount()>0){
			while($d7r=$d7s->fetch(PDO::FETCH_ASSOC)){
				$d7.=date($rosterTimeDisplay,$d7r['tis']).'-'.date($rosterTimeDisplay,$d7r['tie']).($dc<$d7s->rowCount()?'<br>':'');
				$d7status=($d7r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$rosterheader=date('jS',$week3mon);
		if(date('n',$week3mon) != date('n',$week3sun))
			$rosterheader.=' '.date('F',$week3mon).' - ';
		else
			$rosterheader.=' - ';
		$rosterheader.=date('jS',$week3sun).' '.date('F Y',$week3sun).', Week '.number_format(date('W',$week3mon));
		$rosterhtml.=preg_replace([
			'/<print roster=[\"\']?heading[\"\']?>/',
			'/<print roster=[\"\']?daynamemonday[\"\']?>/',
			'/<print roster=[\"\']?daynametuesday[\"\']?>/',
			'/<print roster=[\"\']?daynamewednesday[\"\']?>/',
			'/<print roster=[\"\']?daynamethursday[\"\']?>/',
			'/<print roster=[\"\']?daynamefriday[\"\']?>/',
			'/<print roster=[\"\']?daynamesaturday[\"\']?>/',
			'/<print roster=[\"\']?daynamesunday[\"\']?>/',
			'/<print roster=[\"\']?shiftmonday[\"\']?>/',
			'/<print roster=[\"\']?statusmonday[\"\']?>/',
			'/<print roster=[\"\']?shifttuesday[\"\']?>/',
			'/<print roster=[\"\']?statustuesday[\"\']?>/',
			'/<print roster=[\"\']?shiftwednesday[\"\']?>/',
			'/<print roster=[\"\']?statuswednesday[\"\']?>/',
			'/<print roster=[\"\']?shiftthursday[\"\']?>/',
			'/<print roster=[\"\']?statusthursday[\"\']?>/',
			'/<print roster=[\"\']?shiftfriday[\"\']?>/',
			'/<print roster=[\"\']?statusfriday[\"\']?>/',
			'/<print roster=[\"\']?shiftsaturday[\"\']?>/',
			'/<print roster=[\"\']?statussatday[\"\']?>/',
			'/<print roster=[\"\']?shiftsunday[\"\']?>/',
			'/<print roster=[\"\']?statussunday[\"\']?>/'
		],[
			$rosterheader,
			date($rosterDayName,$week3mon),
			date($rosterDayName,$week3tue),
			date($rosterDayName,$week3wed),
			date($rosterDayName,$week3thu),
			date($rosterDayName,$week3fri),
			date($rosterDayName,$week3sat),
			date($rosterDayName,$week3sun),
			($d1!=''?$d1:'&nbsp;'),
			$d1status,
			($d2!=''?$d2:'&nbsp;'),
			$d2status,
			($d3!=''?$d3:'&nbsp;'),
			$d3status,
			($d4!=''?$d4:'&nbsp;'),
			$d4status,
			($d5!=''?$d5:'&nbsp;'),
			$d5status,
			($d6!=''?$d6:'&nbsp;'),
			$d6status,
			($d7!=''?$d7:'&nbsp;'),
			$d7status,
		],$rosteritem);

		$d1=$d2=$d3=$d4=$d5=$d6=$d7='';
		$d1status=$d2status=$d3status=$d4status=$d5status=$d6status=$d7status='';
		$d1s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d1s->execute([':uid'=>$user['id'],':tis'=>$week4mon,':tie'=>$week4tue]);
		$dc=1;
		if($d1s->rowCount()>0){
			while($d1r=$d1s->fetch(PDO::FETCH_ASSOC)){
				$d1.=date($rosterTimeDisplay,$d1r['tis']).'-'.date($rosterTimeDisplay,$d1r['tie']).($dc<$d1s->rowCount()?'<br>':'');
				$d1status=($d1r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d2s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d2s->execute([':uid'=>$user['id'],':tis'=>$week4tue,':tie'=>$week4wed]);
		$dc=1;
		if($d2s->rowCount()>0){
			while($d2r=$d2s->fetch(PDO::FETCH_ASSOC)){
				$d2.=date($rosterTimeDisplay,$d2r['tis']).'-'.date($rosterTimeDisplay,$d2r['tie']).($dc<$d2s->rowCount()?'<br>':'');
				$d2status=($d2r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d3s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d3s->execute([':uid'=>$user['id'],':tis'=>$week4wed,':tie'=>$week4thu]);
		$dc=1;
		if($d3s->rowCount()>0){
			while($d3r=$d3s->fetch(PDO::FETCH_ASSOC)){
				$d3.=date($rosterTimeDisplay,$d3r['tis']).'-'.date($rosterTimeDisplay,$d3r['tie']).($dc<$d3s->rowCount()?'<br>':'');
				$d3status=($d3r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d4s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d4s->execute([':uid'=>$user['id'],':tis'=>$week4thu,':tie'=>$week4fri]);
		$dc=1;
		if($d4s->rowCount()>0){
			while($d4r=$d4s->fetch(PDO::FETCH_ASSOC)){
				$d4.=date($rosterTimeDisplay,$d4r['tis']).'-'.date($rosterTimeDisplay,$d4r['tie']).($dc<$d4s->rowCount()?'<br>':'');
				$d4status=($d4r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d5s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d5s->execute([':uid'=>$user['id'],':tis'=>$week4fri,':tie'=>$week4sat]);
		$dc=1;
		if($d5s->rowCount()>0){
			while($d5r=$d5s->fetch(PDO::FETCH_ASSOC)){
				$d5.=date($rosterTimeDisplay,$d5r['tis']).'-'.date($rosterTimeDisplay,$d5r['tie']).($dc<$d5s->rowCount()?'<br>':'');
				$d5status=($d5r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d6s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d6s->execute([':uid'=>$user['id'],':tis'=>$week4sat,':tie'=>$week4sun]);
		$dc=1;
		if($d6s->rowCount()>0){
			while($d6r=$d6s->fetch(PDO::FETCH_ASSOC)){
				$d6.=date($rosterTimeDisplay,$d6r['tis']).'-'.date($rosterTimeDisplay,$d6r['tie']).($dc<$d6s->rowCount()?'<br>':'');
				$d6status=($d6r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$d7s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis`>:tis AND `tie`<:tie AND `uid`=:uid ORDER BY `tis` ASC");
		$d7s->execute([':uid'=>$user['id'],':tis'=>$week4sun,':tie'=>$week5mon]);
		$dc=1;
		if($d7s->rowCount()>0){
			while($d7r=$d7s->fetch(PDO::FETCH_ASSOC)){
				$d7.=date($rosterTimeDisplay,$d7r['tis']).'-'.date($rosterTimeDisplay,$d7r['tie']).($dc<$d7s->rowCount()?'<br>':'');
				$d7status=($d7r['status']=='accepted'?' bg-warning':'');
				$dc++;
			}
		}
		$rosterheader=date('jS',$week4mon);
		if(date('n',$week4mon) != date('n',$week4sun))
			$rosterheader.=' '.date('F',$week4mon).' - ';
		else
			$rosterheader.=' - ';
		$rosterheader.=date('jS',$week4sun).' '.date('F Y',$week4mon).', Week '.number_format(date('W',$week4mon));
		$rosterhtml.=preg_replace([
			'/<print roster=[\"\']?heading[\"\']?>/',
			'/<print roster=[\"\']?daynamemonday[\"\']?>/',
			'/<print roster=[\"\']?daynametuesday[\"\']?>/',
			'/<print roster=[\"\']?daynamewednesday[\"\']?>/',
			'/<print roster=[\"\']?daynamethursday[\"\']?>/',
			'/<print roster=[\"\']?daynamefriday[\"\']?>/',
			'/<print roster=[\"\']?daynamesaturday[\"\']?>/',
			'/<print roster=[\"\']?daynamesunday[\"\']?>/',
			'/<print roster=[\"\']?shiftmonday[\"\']?>/',
			'/<print roster=[\"\']?statusmonday[\"\']?>/',
			'/<print roster=[\"\']?shifttuesday[\"\']?>/',
			'/<print roster=[\"\']?statustuesday[\"\']?>/',
			'/<print roster=[\"\']?shiftwednesday[\"\']?>/',
			'/<print roster=[\"\']?statuswednesday[\"\']?>/',
			'/<print roster=[\"\']?shiftthursday[\"\']?>/',
			'/<print roster=[\"\']?statusthursday[\"\']?>/',
			'/<print roster=[\"\']?shiftfriday[\"\']?>/',
			'/<print roster=[\"\']?statusfriday[\"\']?>/',
			'/<print roster=[\"\']?shiftsaturday[\"\']?>/',
			'/<print roster=[\"\']?statussatday[\"\']?>/',
			'/<print roster=[\"\']?shiftsunday[\"\']?>/',
			'/<print roster=[\"\']?statussunday[\"\']?>/'
		],[
			$rosterheader,
			date($rosterDayName,$week4mon),
			date($rosterDayName,$week4tue),
			date($rosterDayName,$week4wed),
			date($rosterDayName,$week4thu),
			date($rosterDayName,$week4fri),
			date($rosterDayName,$week4sat),
			date($rosterDayName,$week4sun),
			($d1!=''?$d1:'&nbsp;'),
			$d1status,
			($d2!=''?$d2:'&nbsp;'),
			$d2status,
			($d3!=''?$d3:'&nbsp;'),
			$d3status,
			($d4!=''?$d4:'&nbsp;'),
			$d4status,
			($d5!=''?$d5:'&nbsp;'),
			$d5status,
			($d6!=''?$d6:'&nbsp;'),
			$d6status,
			($d7!=''?$d7:'&nbsp;'),
			$d7status,
		],$rosteritem);
	}
	$shifthtml='';
	if($rosterExtraShifts=='true'){
		$ss=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `tis` > :tis AND `status`='available'");
		$ss->execute([':tis'=>$ti]);
		if($ss->rowCount()>0){
			preg_match('/<shiftitems>([\w\W]*?)<\/shiftitems>/',$html,$match);
			$shiftitem=$match[1];
			while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
				$shifthtml.=preg_replace([
					'/<print user=[\"\']?id[\"\']?>/',
					'/<print shift=[\"\']?id[\"\']?>/',
					'/<print shift=[\"\']?date[\"\']?>/',
					'/<print shift=[\"\']?times[\"\']?>/',
					'/<print shift=[\"\']?notes[\"\']?>/'
				],[
					$user['id'],
					$rs['id'],
					date('jS F Y',$rs['tis']),
					date($rosterTimeDisplay,$rs['tis']).'-'.date($rosterTimeDisplay,$rs['tie']),
					strip_tags($rs['notes'])
				],$shiftitem);
			}
		}
	}
	$html=preg_replace([
		'/<[\/]?rosternotice>/',
		'/<print page=[\"\']?heading[\"\']?>/',
		($page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is'),
	  '/<print page=[\"\']?notes[\"\']?>/',
		'/<[\/]?roster>/',
		'~<rosteritems>.*?<\/rosteritems>~is',
		($shifthtml==''?'~<shift>.*?<\/shifts>~is':'/<[\/]?shifts>/'),
		'~<shiftitems>.*?<\/shiftitems>~is',
		'~<login>.*?<\/login>~is'
	],[
		'',
		htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
		'',
	  $page['notes'],
		'',
		$rosterhtml,
		'',
		$shifthtml,
		''
	],$html);
}else{
	$html=preg_replace([
		'~<rosternotice>.*?<\/rosternotice>~is',
		'~<roster>.*?<\/roster>~is',
		'~<shifts>.*?<\/shifts>~is',
		'/<[\/]?login>/',
		'/<print url>/',
	],[
		'',
		'',
		'',
		'',
		URL.'roster'
	],$html);
}
$content.=$html;
