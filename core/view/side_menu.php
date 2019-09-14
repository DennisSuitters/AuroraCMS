<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Side Menu
 * @package    core/view/side_menu.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Display Items according to primary documents category
 * @changes    v0.0.2 Make sure all links end with /
 */
if(file_exists(THEME.DS.'side_menu.html')){
	$sideTemp=file_get_contents(THEME.DS.'side_menu.html');
	if($show=='item'&&($view=='service'||$view=='inventory'||$view=='events')){
		$sideCost=is_numeric($r['cost'])&&$r['cost']!=0?'<span class="cost">'.(is_numeric($r['cost'])?'&#36;':'').htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>':'<span>'.htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>';
		$sideTemp=preg_replace([
			'/<print content=[\"\']?stockStatus[\"\']?>/',
			'/<print content=[\"\']?cost[\"\']?>/',
			'/<print content=[\"\']?id[\"\']?>/'
		],[
			$r['stockStatus']=='quantity'?($r['quantity']==0?'out of stock':'in stock'):($r['stockStatus']=='none'?'':$r['stockStatus']),
			$sideCost,
			$r['id']
		],$sideTemp);
		$sideQuantity='';
		if($r['contentType']=='inventory'){
			if(is_numeric($r['quantity'])&&$r['quantity']!=0)
				$sideQuantity.=$r['stockStatus']=='quantity'?($r['quantity']==0?'<div class="quantity">Out Of Stock</div>':'<div class="quantity">'.htmlspecialchars($r['quantity'],ENT_QUOTES,'UTF-8').' <span class="quantity-text">In Stock</span></div>'):($r['stockStatus']=='none'?'':'<div class="quantity">'.ucfirst($r['stockStatus']).'</div>');
			$sideTemp=preg_replace([
				'/<print content=[\"\']?quantity[\"\']?>/'
			],$r['stockStatus']=='out of stock'?'':$sideQuantity,$sideTemp);
			if(stristr($sideTemp,'<choices>')){
				$scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE rid=:id ORDER BY title ASC");
				$scq->execute([':id'=>$r['id']]);
				if($scq->rowCount()>0){
					$choices='<select class="choices form-control" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
					while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
						if($rcq['ti']==0)continue;
						$choices.='<option value="'.$rcq['id'].'">'.$rcq['title'].':'.$rcq['ti'].'</option>';
					}
					$choices.='</select>';
					$sideTemp=str_replace('<choices>',$choices,$sideTemp);
				}else
					$sideTemp=str_replace('<choices>','',$sideTemp);
			}else
				$sideTemp=str_replace('<choices>','',$sideTemp);
		}else
			$sideTemp=preg_replace('/<print content=[\"\']?quantity[\"\']?>/','',$sideTemp);
		if($r['contentType']=='service'||$r['contentType']=='events'){
			if($r['bookable']==1){
				if(stristr($sideTemp,'<service>')){
					$sideTemp=preg_replace([
						'/<service>/',
						'/<\/service>/',
						'/<print content=[\"\']?bookservice[\"\']?>/',
						'~<inventory>.*?<\/inventory>~is'
					],[
						'',
						'',
						$r['id'],
						''
					],$sideTemp);
				}
			}else
				$sideTemp=preg_replace('~<service.*?>.*?<\/service>~is','',$sideTemp,1);
		}else
			$sideTemp=preg_replace('~<service.*?>.*?<\/service>~is','',$sideTemp,1);
		if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
			if(stristr($sideTemp,'<inventory>')){
				$sideTemp=preg_replace([
					'/<inventory>/',
					'/<\/inventory>/',
					'~<service>.*?<\/service>~is'
				],'',$sideTemp);
			}elseif(stristr($sideTemp,'<inventory>')&&$r['contentType']!='inventory')
				$sideTemp=preg_replace('~<inventory>.*?<\/inventory>~is','',$sideTemp,1);
		}else
			$sideTemp=preg_replace('~<inventory>.*?<\/inventory>~is','',$sideTemp,1);
		$sideTemp=str_replace([
			'<controls>',
			'</controls>',
			'<review>',
			'</review>'
		],'',$sideTemp);
	}else{
		$sideTemp=preg_replace([
			'/<controls>([\w\W]*?)<\/controls>/',
			'/<review>([\w\W]*?)<\/review>/',
		],'',$sideTemp,1);
	}
	preg_match('/<item>([\w\W]*?)<\/item>/',$sideTemp,$matches);
	$outside=$matches[1];
	$show='';
	$contentType=$view;
	if(stristr($outside,'<heading>')){
		preg_match('/<heading>([\w\W]*?)<\/heading>/',$outside,$matches);
		if($matches[1]!=''){
			$heading=$matches[1];
			$heading=str_replace([
				'<print viewlink>',
				'<print view>'
			],[
				URL.$view.'/',
				ucfirst($view)
			],$heading);
		}else
			$heading='';
		$outside=preg_replace('~<heading>.*?<\/heading>~is',$heading,$outside,1);
	}
	if(stristr($sideTemp,'<settings')){
		preg_match('/<settings items="(.*?)" contenttype="(.*?)">/',$outside,$matches);
		if(isset($matches[1])){
			if($matches[1]=='all'||$matches[1]=='')
				$show='';
			elseif($matches[1]=='limit')
				$show=' LIMIT '.$config['showItems'];
			else
				$show=' LIMIT '.$matches[1];
		}else
			$show='';
		if(isset($matches[2])){
			if($matches[2]=='current')$contentType=strtolower($view);
			if($matches[2]=='all'||$matches[2]=='')$contentType=$heading='';
		}else
			$contentType='';
	}
	$r=$db->query("SELECT * FROM `".$prefix."menu` WHERE id=17")->fetch(PDO::FETCH_ASSOC);
	if($r['active']{0}==1){
		$sideTemp=str_replace([
			'<newsletters>',
			'</newsletters>'
		],'',$sideTemp);
	}else
		$sideTemp=preg_replace('/<newsletters>([\w\W]*?)<\/newsletters>/','',$sideTemp,1);
	preg_match('/<items>([\w\W]*?)<\/items>/',$outside,$matches);
	$insides=$matches[1];	
	if(isset($sidecat)&&$sidecat!=''){
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND category_1 LIKE :cat AND internal=0 AND status='published' ORDER BY featured DESC, ti DESC $show");
		$s->execute([
			':contentType'=>$contentType,
			':cat'=>$sidecat
		]);
	}else{
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND internal='0' AND status='published' ORDER BY featured DESC, ti DESC $show");
		$s->execute([':contentType'=>$contentType]);
	}
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['contentType']=='gallery'){
			preg_match('/<media>([\w\W]*?)<\/media>/',$insides,$matches);
			$inside=$matches[1];
		}else
			$inside=preg_replace('/<media>([\w\W]*?)<\/media>/','',$insides,1);
		$items=$inside;
		$time='<time datetime="'.date('Y-m-d',$r['ti']).'">'.date($config['dateFormat'],$r['ti']).'</time>';
		if($r['contentType']=='events'||$r['contentType']=='news'){
			if($r['tis']!=0){
				$time='<time datetime="'.date('Y-m-d',$r['tis']).'">'.date('dS M H:i',$r['tis']).'</time>';
				if($r['tie']!=0)
					$time.=' &rarr; <time datetime="'.date('Y-m-d',$r['tie']).'">'.date('dS M H:i',$r['tie']).'</time>';
			}
		}
		$caption=$r['seoCaption']!=''?$r['seoCaption']:substr(strip_tags(rawurldecode($r['notes'])),0,100).'...';
		$items=preg_replace([
			'/<print content=[\"\']?thumb[\"\']?>/',
			'/<print link>/',
			'/<print content=[\"\']?schemaType[\"\']?>/',
			'/<print metaDate>/',
			'/<print content=[\"\']?title[\"\']?>/',
			'/<print time>/',
			'/<print content=[\"\']?caption[\"\']?>/'
		],[
			htmlspecialchars($r['thumb'],ENT_QUOTES,'UTF-8'),
			URL.$r['contentType'].'/'.$r['urlSlug'].'/',
			htmlspecialchars($r['schemaType'],ENT_QUOTES,'UTF-8'),
			date('Y-m-d',$r['ti']),
			htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
			$time,
			htmlspecialchars($caption,ENT_QUOTES,'UTF-8')
		],$items);
		$output.=$items;
	}
	$outside=preg_replace([
		'~<items>.*?<\/items>~is',
		'~<settings.*?>~is'
	],[
		$output,
		'',
	],$outside,1);
	$sideTemp=preg_replace('~<item>.*?<\/item>~is',$outside,$sideTemp,1);
}else
	$sideTemp='';
$content.=$sideTemp;
