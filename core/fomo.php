<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - FOMO Notifications
 * @package    core/fomo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
header('Content-Type: application/json; charset=utf-8');
require'db.php';
$data=[
	'url'=>'None',
	'image'=>'',
	'who'=>'',
	'heading'=>'',
	'timeago'=>'',
	'style'=>'',
	'in'=>'',
	'out'=>''
];
$sqlrank='';
if(isset($_SESSION['rank'])){
	if(!$_SESSION['rank'] > 350 AND $_SESSION['rank'] > 309 || $_SESSION['rank'] < 351)
		$sqlrank=" AND `rank` > 309 AND `rank` < 351";
	else
		$sqlrank=" AND `rank` <= ".$_SESSION['rank'];
}
$config=$db->query("SELECT `theme`,`fomo`,`fomoStyle`,`fomoIn`,`fomoOut`,`fomoOptions`,`fomoActivitiesState`,`fomoCoursesState`,`fomoEventsState`,`fomoInventoryState`,`fomoServicesState`,`fomoTestimonialsState`,`fomoFullname` FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$cT='';
$cT.=($config['fomoActivitiesState']!=''?"`contentType`='activities'".($config['fomoCoursesState']!=''||$config['fomoEventsState']!=''||$config['fomoInventoryState']!=''||$config['fomoServicesState']!=''||$config['fomoTestimonialsState']!=''?" OR":""):"");
$cT.=($config['fomoCoursesState']!=''?"`contentType`='course'".($config['fomoEventsState']!=''||$config['fomoInventoryState']!=''||$config['fomoServicesState']!=''||$config['fomoTestimonialsState']!=''?" OR":""):"");
$cT.=($config['fomoEventsState']!=''?"`contentType`='events'".($config['fomoInventoryState']!=''||$config['fomoServicesState']!=''||$config['fomoTestimonialsState']!=''?" OR":""):"");
$cT.=($config['fomoInventoryState']!=''?"`contentType`='inventory'".($config['fomoServicesState']!=''||$config['fomoTestimonialsState']!=''?" OR":""):"");
$cT.=($config['fomoServicesState']!=''?"`contentType`='service'".($config['fomoTestimonialsState']!=''?" OR":""):"");
$cT.=($config['fomoTestimonialsState']!=''?"`contentType`='testimonials'":"");
$pC='';
$s=$db->prepare("SELECT `id`,`file`,`thumb`,`title`,`urlSlug`,`name`,`contentType`,`notes`,`quantity`,`status`,`stockStatus`,`eti`,`pti`,`ti` FROM `".$prefix."content` WHERE ".$cT." AND `status`='published'".$sqlrank." ORDER BY rand() LIMIT 1");
$s->execute();
if($s->rowCount()>0){
	$r=$s->fetch(PDO::FETCH_ASSOC);
	function timeago($time){
    $time_difference=time()- $time;
    if($time_difference<1){return'less than 1 second ago';}
    $condition=array(12 * 30 * 24 * 60 * 60=>'year',30 * 24 * 60 * 60=>'month',24 * 60 * 60=>'day',60 * 60=>'hour',60=>'minute',1=>'second');
    foreach($condition as$secs=>$str){
        $d=$time_difference / $secs;
				if($d>=1){$t=round($d);return'about '.$t.' '.$str.($t>1?'s':'').' ago';}
    }
	}
	function truncate($string,$length=100,$append="&hellip;") {
  	$string = trim($string);
  	if(strlen($string) > $length) {
    	$string = wordwrap($string, $length);
    	$string = explode("\n", $string, 2);
    	$string = $string[0] . $append;
  	}
  	return $string;
	}
	$e=rand(0,1);
	if($r['contentType']=='inventory'&&$r['quantity']<2)$e=1;
	$enq=[
	  'purchased',
	  'enquired about',
	];
	if($r['contentType']=='testimonials'){
		if($r['file']==''){
			if(file_exists('layout/'.$config['theme'].'/images/noavatar.jpg'))
				$r['file']='layout/'.$config['theme'].'/images/noavatar.jpg';
			elseif(file_exists('layout/'.$config['theme'].'/images/noavatar.png'))
				$r['file']='layout/'.$config['theme'].'/images/noavatar.png';
			elseif(file_exists('layout/'.$config['theme'].'/images/noavatar.gif'))
				$r['file']='layout/'.$config['theme'].'/images/noavatar.gif';
			elseif(file_exists('layout/'.$config['theme'].'/images/noavatar.gif'))
				$r['file']='layout/'.$config['theme'].'/images/noavatar.gif';
			elseif(file_exists('layout/'.$config['theme'].'/images/noavatar.webp'))
				$r['file']='layout/'.$config['theme'].'/images/noavatar.webp';
			else
				$r['file']='core/images/noavatar.jpg';
		}
		$data=[
		  'url'=>$r['contentType'],
		  'image'=>'', //$r['file'],
		  'who'=>($r['name']!=''?$r['name']:'Anonymous').' left a Testimonial',
		  'heading'=>truncate(strip_tags($r['notes']),70).'...',
		  'timeago'=>timeago($r['ti']).'.',
			'style'=>$config['fomoStyle'],
			'in'=>$config['fomoIn'],
			'out'=>$config['fomoOut']
		];
	}else{
		if($r['contentType']=='service'||$r['contentType']=='events'||$r['contentType']=='activity'){
		  $enq=[
		    'booked',
		    'enquired about',
		  ];
		}
		$area='';
		if($r['contentType']=='activities'){
			if($config['fomoActivitiesState']!='All'){
				$area.="LOWER(`state`) LIKE '%".strtolower($config['fomoActivitiesState'])."%' AND ";
			}
			$enq=[
				'enquired about',
				'enquired about',
			]
		}
		if($r['contentType']=='course'){
			if($config['fomoCoursesState']!='All'){
				$area.="LOWER(`state`) LIKE '%".strtolower($config['fomoCoursesState'])."%' AND ";
			}
		}
		if($r['contentType']=='events'){
			if($config['fomoEventsState']!='All'){
				$area.="LOWER(`state`) LIKE '%".strtolower($config['fomoEventsState'])."%' AND ";
			}
		}
		if($r['contentType']=='inventory'){
			if($config['fomoInventoryState']!='All'){
				$area.="LOWER(`state`) LIKE '%".strtolower($config['fomoInventoryState'])."%' AND ";
			}
		}
		if($r['contentType']=='service'){
			if($config['fomoServicesState']!='All'){
				$area.="LOWER(`state`) LIKE '%".strtolower($config['fomoServicesState'])."%' AND ";
			}
		}
		$rs=$db->prepare("SELECT * FROM `".$prefix."locations` WHERE ".$area." `active`='1' ORDER BY rand() LIMIT 1");
		$rs->execute();
		if($rs->rowCount()>0){
			$ra=$rs->fetch(PDO::FETCH_ASSOC);
			if($config['fomoFullname']==1){
			  $ra['state']=str_replace([
			    'ACT','NSW','NT','QLD','SA','TAS','VIC','WA'
			  ],[
			    'Australian Capital Territory','New South Wales','Northern Territory','Queensland','South Australia','Tasmania','Victoria','Western Australia'
			  ],$ra['state']);
			}
			$timeago=rand(0,20);
			$quantity='';
			if($r['contentType']=='inventory'){
				if($r['stockStatus']!='sold out'){
					if($r['quantity']>1&&$r['quantity']<6)$quantity=' Only '.$r['quantity'].' left.';
					if($r['quantity']==1)$quantity=' Only 1 in stock.';
				}
			}
			$data=[
			  'url'=>$r['contentType'].'/'.strtolower($r['urlSlug']),
			  'image'=>($r['thumb']!=''?$r['thumb']:$r['file']),
			  'who'=>'Someone in '.ucwords(strtolower($ra['area'])).($config['fomoOptions'][7]==1?', '.$ra['state']:'').', '.$enq[$e],
			  'heading'=>$r['title'],
			  'timeago'=>($timeago<5?'Just now':'About '.($timeago<15?'1 hour ago':rand(2,6).' hours ago')).'.'.$quantity,
				'style'=>$config['fomoStyle'],
				'in'=>$config['fomoIn'],
				'out'=>$config['fomoOut']
			];
		}
	}
}
echo json_encode($data);
