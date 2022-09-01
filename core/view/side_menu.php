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
if(file_exists(THEME.'/side_menu.html')){
	$sideTemp=file_get_contents(THEME.'/side_menu.html');
	$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
	$ru=[
		'options'=>'00000000000000000000000000000000',
		'rank'=>0
	];
	if($uid!=0){
		$su=$db->prepare("SELECT `options`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
		$su->execute([':id'=>$uid]);
		$ru=$su->fetch(PDO::FETCH_ASSOC);
	}
	$site_url=URL.$view.(isset($r['urlSlug'])?'/'.$r['urlSlug']:
		(isset($args[0])&&$args[0]!=''?'/'.$args[0]:'').
		(isset($args[1])&&$args[1]!=''?'/'.$args[1]:'').
		(isset($args[2])&&$args[2]!=''?'/'.$args[2]:'').
		(isset($args[3])&&$args[3]!=''?'/'.$args[3]:''));
	$sideTemp=preg_replace([
		'/<share>/',
		'/<print adminlink>/',
		isset($_SESSION['rank'])&&$_SESSION['rank']>899&&isset($r['id'])?'/<[\/]?admin>/':'~<admin>.*?<\/admin>~is'
	],[
		'<a target="_blank" href="http://www.facebook.com/sharer.php?u='.$site_url.'" title="Share to Facebook" rel="noopener noreferrer"><i class="i i-3x i-social social-facebook m-1">social-facebook</i></a>'.
		'<a target="_blank" href="https://twitter.com/share?url='.$site_url.'&amp;text='.urlencode((isset($r['title'])&&$r['title']!=''?$r['title']:$page['title'])).'&amp;hashtags='.urlencode((isset($r['tags'])&&$r['tags']!=''?$r['tags']:$config['business'])).'" title="Share to Twitter" rel="noopener noreferrer"><i class="i i-3x i-social social-twitter m-1">social-twitter</i></a>'.
		'<a target="_blank" href="javascript:void((function()%7Bvar%20e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.setAttribute(\'charset\',\'UTF-8\');e.setAttribute(\'src\',\'http://assets.pinterest.com/js/pinmarklet.js?r=\'+Math.random()*99999999);document.body.appendChild(e)%7D)());" title="Share to Pinterest" rel="noopener noreferrer"><i class="i i-3x i-social social-pinterest m-1">social-pinterest</i></a>'.
		'<a target="_blank" href="http://www.stumbleupon.com/submit?url='.$site_url.'&amp;title='.urlencode($config['business']).'" title="Share to Stumbleupon" rel="noopener noreferrer"><i class="i i-3x i-social social-stumbleupon m-1">social-stumbleupon</i></a>'.
		'<a target="_blank" href="http://reddit.com/submit?url='.$site_url.'&amp;title='.urlencode($config['business']).'" title="Share to Reddit" rel="noopener noreferrer"><i class="i i-3x i-social social-reddit m-1">social-reddit</i></a>'.
		'<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$site_url.'" title="Share to Linkedin" rel="noopener noreferrer"><i class="i i-3x i-social social-linkedin m-1">social-linkedin</i></a>',
		isset($_SESSION['rank'])&&$_SESSION['rank']>899&&isset($r['id'])?URL.$settings['system']['admin'].'/content/edit/'.$r['id']:'',
		''
	],$sideTemp);
	if($show=='item')
		$sideTemp=preg_replace('~<sort>.*?<\/sort>~is','',$sideTemp);
	if($show=='item'&&($view=='service'||$view=='inventory'||$view=='events'||$view=='activities'||$view=='course')){
		$sideCost='';
		if($r['options'][0]==1){
			if(is_numeric($r['cost'])&&$r['cost']!=0){
				if($r['coming'][0]==1)$sideCost.='<div class="sold">Coming Soon</div>';
			}
			if($r['stockStatus']=='out of stock'||$r['stockStatus']=='pre order'||$r['stockStatus']=='back order')
				$r['quantity']=0;
			if(isset($user['rank'])&&$user['rank']>799){
				$sideCost=
					'<div class="sold">'.
						($r['rrp']>0?'<div><abbr title="Recommended Retail Price">RRP</abbr> &#36;'.$r['rrp'].'</div>':'').
						($r['cost']>0?'<div>Cost &#36;'.$r['cost'].'</div>':'').
						($r['rCost']>0?'<div>Reduced Cost &#36;'.$r['rCost'].'</div>':'').
						($r['dCost']>0?'<div>Wholesale &#36;'.$r['dCost'].'</div>':'').
					'</div>';
			}elseif(isset($user['rank'])&&$user['rank']>300&&$user['rank']<400){
				$sideCost=
					'<div class="sold">'.
						($r['rrp']>0?'<div class="rrp"><abbr title="Recommended Retail Price">RRP</abbr> &#36;'.$r['rrp'].'</div>':'').
						($r['dCost']>0?'<div class="cost">&#36;'.$r['dCost'].'</div>':'').
					'</div>';
			}else{
				$sideCost.=
					'<div class="sold">'.
						($r['rrp']>0?'<div class="rrp"><abbr title="Recommended Retail Price">RRP</abbr> &#36;'.$r['rrp'].'</div>':'').
						($r['cost']>0?'<div class="cost'.($r['rCost']>0?' strike':'').'">&#36;'.$r['cost'].'</div>':'').
						($r['rCost']>0?'<div class="cost">&#36;'.$r['rCost'].'</div>':'').
					'</div>';
			}
		}

		if(isset($_SESSION['rank'])){
			if($_SESSION['rank']>309&&$_SESSION['rank']<349){
				if($r['rank']!=$_SESSION['rank']){
					$sideTemp=preg_replace('~<addtocart>.*?<\/addtocart>~is','',$sideTemp);
				}
			}
		}
		if($config['options'][30]==1){
			if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)
				$sideTemp=preg_replace('/<[\/]?addtocart>/','',$sideTemp);
			else
				$sideTemp=preg_replace('~<addtocart>.*?<\/addtocart>~is',$theme['settings']['accounttopurchase'],$sideTemp);
		}else
			$sideTemp=preg_replace('/<[\/]?addtocart>/','',$sideTemp);
		$sideQuantity='';
		$quantity='';
		$sideTemp=preg_replace([
			($r['coming'][0]==1?'~<quantity>.*?<\/quantity>~is':'/<[\/]?quantity>/'),
			'/<print content=[\"\']?quantity[\"\']?>/',
			'/<print content=[\"\']?stock[\"\']?>/',
			$r['itemCondition']!=''?'/<[\/]?condition>/':'~<condition>.*?<\/condition>~is',
			'/<print content=[\"\']?condition[\"\']?>/',
			$r['weight']!=''?'/<[\/]?weight>/':'~<weight>.*?<\/weight>~is',
			'/<print content=[\"\']?weight[\"\']?>/',
			($r['width']!=''&&$r['height']!=''&&$r['length']!=''?'/<[\/]?size>/':'~<size>.*?<\/size>~is'),
			'/<print content=[\"\']?width[\"\']?>/',
			'/<print content=[\"\']?height[\"\']?>/',
			'/<print content=[\"\']?length[\"\']?>/',
			'/<print content=[\"\']?stockStatus[\"\']?>/',
			'/<print content=[\"\']?cost[\"\']?>/',
			'/<print content=[\"\']?id[\"\']?>/',
			$r['points']>0&&$config['options'][0]==1?'/<[\/]?points>/':'~<points>.*?<\/points>~is',
			'/<print content=[\"\']?points[\"\']?>/'
		],[
			'',
			($r['contentType']=='course'?($r['attempts']==0?'':$r['attempts'].' attempts are available with this course'):($r['quantity']==0?($r['stockStatus']=='sold out'?'<div class="qauntity">Sold Out</div>':''):$r['quantity'])),
			($r['stockStatus']=='quantity'?($r['quantity']>0?'in stock':'out of stock'):($r['stockStatus']=='none'?'':$r['stockStatus'])).'.'.($r['cartonQuantity']>0?' ('.$r['cartonQuantity'].'per carton.)':''),
			'',
			$r['itemCondition'],
			'',
			$r['weight'].$r['weightunit'],
			'',
			$r['width'].$r['widthunit'],
			$r['height'].$r['heightunit'],
			$r['length'].$r['lengthunit'],
			$r['stockStatus']=='quantity'?($r['quantity']==0?'out of stock':'in stock'):($r['stockStatus']!='none'?'':$r['stockStatus']),
			$sideCost,
			$r['id'],
			'',
			number_format((float)$r['points'])
		],$sideTemp);
		if(isset($r['contentType'])&&$r['contentType']=='inventory'){
			if(stristr($sideTemp,'<brand>')){
				if($r['brand']!=0){
					$sb=$db->prepare("SELECT `id`,`title`,`url`,`icon` FROM `".$prefix."choices` WHERE `contentType`='brand' AND `id`=:id");
					$sb->execute([':id'=>$r['brand']]);
					$rb=$sb->fetch(PDO::FETCH_ASSOC);
					$brand=($rb['url']!=''?'<a href="'.$rb['url'].'">':'').($rb['icon']==''?$rb['title']:'<img src="'.$rb['icon'].'" alt="'.$rb['title'].'" title="'.$rb['title'].'">').($rb['url']!=''?'</a>':'');
					$sideTemp=preg_replace([
						'/<[\/]?brand>/',
						'/<print brand>/',
					],[
						'',
						$brand,
					],$sideTemp);
				}else
					$sideTemp=preg_replace('~<brand>.*?<\/brand>~is','',$sideTemp);
			}
			if(stristr($sideTemp,'<choices>')&&$r['stockStatus']=='quantity'||$r['stockStatus']=='in stock'||$r['stockStatus']=='pre order'||$r['stockStatus']=='back order'||$r['stockStatus']=='available'){
				$scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='option' AND `rid`=:id ORDER BY `title` ASC");
				$scq->execute([':id'=>$r['id']]);
				if($scq->rowCount()>0){
					$choices='<select class="choices form-control" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
					while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
						if($rcq['ti']==0)continue;
						$choices.='<option value="'.$rcq['id'].'">'.$rcq['title'].':'.$rcq['ti'].'</option>';
					}
					$choices.='</select>';
					$sideTemp=preg_replace('/<choices>/',$choices,$sideTemp);
				}else
					$sideTemp=preg_replace('/<choices>/','',$sideTemp);
			}else{
				$sideTemp=preg_replace([
					'/<choices>/',
					'~<inventory>.*?<\/inventory>~is'
				],
				'',
				$sideTemp);
			}
		}else{
			$sideTemp=preg_replace([
				'/<[\/]?choices>/',
				'~<brand>.*?<\/brand>~is',
				'~<quantity>.*?<\/quantity>~is'
			],
				''
			,$sideTemp);
		}
		if($r['contentType']=='service'||$r['contentType']=='events'||$r['contentType']=='activities'||$r['contentType']=='course'){
			if($r['bookable']==1){
				if(stristr($sideTemp,'<service>')){
					$sideTemp=preg_replace([
						'/<[\/]?service>/',
						'~<inventory>.*?<\/inventory>~is',
						'/<print content=[\"\']?bookservice[\"\']?>/'
					],[
						'',
						'',
						$r['id']
					],$sideTemp);
				}
			}else
				$sideTemp=preg_replace('~<service.*?>.*?<\/service>~is','',$sideTemp,1);
		}else
			$sideTemp=preg_replace('~<service.*?>.*?<\/service>~is','',$sideTemp,1);
		if($r['contentType']=='inventory'||$r['contentType']=='course'&&is_numeric($r['cost'])){
			if(stristr($sideTemp,'<inventory>')){
				$sideTemp=preg_replace([
					($r['coming'][0]==1?'~<inventory>.*?<\/inventory>~is':'/<[\/]?inventory>/'),
					'~<service>.*?<\/service>~is'
				],'',$sideTemp);
			}elseif(stristr($sideTemp,'<inventory>')&&$r['contentType']!='inventory'||$r['contentType']!='course')
				$sideTemp=preg_replace('~<inventory>.*?<\/inventory>~is','',$sideTemp,1);
		}else
			$sideTemp=preg_replace('~<inventory>.*?<\/inventory>~is','',$sideTemp,1);
		$sideTemp=preg_replace([
			$sideCost==''?'/<controls>([\w\W]*?)<\/controls>/':'/<[\/]?controls>/',
			'/<[\/]?review>/'
		],'',$sideTemp);
	}else{
		$sideTemp=preg_replace([
			'/<controls>([\w\W]*?)<\/controls>/',
			'/<review>([\w\W]*?)<\/review>/',
		],'',$sideTemp,1);
		if(stristr($sideTemp,'<sort>')){
			if($show=='item')
				$sideTemp=preg_replace('~<sort>.*?<\/sort>~is','',$sideTemp);
			elseif($view=='course'||$view=='inventory'||$view=='service'||$view=='article'||$view=='news'||$view=='events'||$view=='portfolio'||$view=='gallery'){
				$sortOptions='';
				if($view=='inventory'||$view=='course'){
					$sortOptions=
						'<option value="new"'.(isset($sort)&&$sort=='new'?' selected':'').'>Newest</option>'.
						'<option value="old"'.(isset($sort)&&$sort=='old'?' selected':'').'>Oldest</option>'.
						'<option value="namea"'.(isset($sort)&&$sort=='namea'?' selected':'').'>Name: A-Z</option>'.
						'<option value="namez"'.(isset($sort)&&$sort=='namez'?' selected':'').'>Name: Z-A</option>'.
						'<option value="best"'.(isset($sort)&&$sort=='best'?' selected':'').'>Best Selling</option>'.
						'<option value="view"'.(isset($sort)&&$sort=='view'?' selected':'').'>Most viewed</option>'.
						'<option value="priceh"'.(isset($sort)&&$sort=='priceh'?' selected':'').'>Price: High to low</option>'.
						'<option value="pricel"'.(isset($sort)&&$sort=='pricel'?' selected':'').'>Price: Low to High</option>';
				}
				if($view=='service'){
					$sortOptions=
						'<option value="new"'.(isset($sort)&&$sort=='new'?' selected':'').'>Newest</option>'.
						'<option value="old"'.(isset($sort)&&$sort=='old'?' selected':'').'>Oldest</option>'.
						'<option value="namea"'.(isset($sort)&&$sort=='namea'?' selected':'').'>Name: A-Z</option>'.
						'<option value="namez"'.(isset($sort)&&$sort=='namez'?' selected':'').'>Name: Z-A</option>'.
						'<option value="view"'.(isset($sort)&&$sort=='view'?' selected':'').'>Most viewed</option>'.
						'<option value="priceh"'.(isset($sort)&&$sort=='priceh'?' selected':'').'>Price: High to low</option>'.
						'<option value="pricel"'.(isset($sort)&&$sort=='pricel'?' selected':'').'>Price: Low to High</option>';
				}
				if($view=='article'||$view=='news'||$view=='events'){
					$sortOptions=
						'<option value="new"'.(isset($sort)&&$sort=='new'?' selected':'').'>Newest</option>'.
						'<option value="old"'.(isset($sort)&&$sort=='old'?' selected':'').'>Oldest</option>'.
						'<option value="namea"'.(isset($sort)&&$sort=='namea'?' selected':'').'>Name: A-Z</option>'.
						'<option value="namez"'.(isset($sort)&&$sort=='namez'?' selected':'').'>Name: Z-A</option>'.
						'<option value="view"'.(isset($sort)&&$sort=='view'?' selected':'').'>Most viewed</option>';
				}
				if($view=='portfolio'||$view=='gallery'){
					$sortOptions=
						'<option value="new"'.(isset($sort)&&$sort=='new'?' selected':'').'>Newest</option>'.
						'<option value="old"'.(isset($sort)&&$sort=='old'?' selected':'').'>Oldest</option>'.
						'<option value="namea"'.(isset($sort)&&$sort=='namea'?' selected':'').'>Name: A-Z</option>'.
						'<option value="namez"'.(isset($sort)&&$sort=='namez'?' selected':'').'>Name: Z-A</option>'.
						'<option value="view"'.(isset($sort)&&$sort=='view'?' selected':'').'>Most viewed</option>';
				}
				$sideTemp=preg_replace([
					'/<[\/]?sort>/',
					'/<print sort=[\"\']?self[\"\/]?>/',
					'/<sortOptions>/',
					$config['showItems']>0?'/<[\/]?showItems>/':'~<showItems>.*?<\/showItems>~is',
					'/<itemCount>/'
				],[
					'',
					(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://").$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
					$sortOptions,
					'',
					$config['showItems']
				],$sideTemp);
			}else
				$sideTemp=preg_replace('~<sort>.*?<\/sort>~is','',$sideTemp);
		}
	}
	$cq=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si ORDER BY `ti` DESC");
	$cq->execute([':si'=>SESSIONID]);
	if($cq->rowCount()>0){
		$cartitem=$cartage='';
		while($cr=$cq->fetch(PDO::FETCH_ASSOC)){
			$cs=$db->prepare("SELECT * from `".$prefix."content` WHERE `id`=:id");
			$cs->execute([':id'=>$cr['iid']]);
			$ci=$cs->fetch(PDO::FETCH_ASSOC);
			$cartitem=$theme['settings']['cartage_menu'];
			if($ci['thumb']=='')
				$ci['thumb']=NOIMAGE;
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
		$sideTemp=preg_replace('/<cartageitems>/',$cartage,$sideTemp);
	}else{
		$sideTemp=preg_replace([
			'/<cartageitems>/',
			'/<cartagedisplay>/',
		],[
			isset($cartage)?$cartage:'',
			'd-none'
		],$sideTemp);
	}
	preg_match('/<item>([\w\W]*?)<\/item>/',$sideTemp,$matches);
	$outside=isset($matches[1])?$matches[1]:'';
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
	$sideTemp=preg_replace('/<g-recaptcha>/',$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':'',$sideTemp);
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
			if($matches[2]=='current')
				$contentType=strtolower($view);
			if($matches[2]=='all'||$matches[2]=='')
				$contentType=$heading='';
		}else
			$contentType='';
	}
	$r=$db->query("SELECT * FROM `".$prefix."menu` WHERE `id`=17")->fetch(PDO::FETCH_ASSOC);
	$sideTemp=preg_replace($r['active'][0]==1?'/<[\/]?newsletters>/':'/<newsletters>([\w\W]*?)<\/newsletters>/','',$sideTemp,1);
	preg_match('/<items>([\w\W]*?)<\/items>/',$outside,$matches);
	$insides=isset($matches[1])?$matches[1]:'';
	if(isset($sidecat)&&$sidecat!=''){
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `category_1` LIKE :cat AND `internal`=0 AND `status`='published'".($contentType=='events'?" AND `tis`>$ti":'').$sqlrank.($contentType!='events'?" ORDER BY `featured` DESC, `views` DESC, `ti` DESC":" ORDER BY `tis` ASC, `ti` DESC").$show);
		$s->execute([
			':contentType'=>$contentType,
			':cat'=>$sidecat
		]);
	}else{
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `internal`='0' AND `status`='published'".($contentType=='events'?" AND `tis`>$ti":'').$sqlrank.($contentType!='events'?" ORDER BY `featured` DESC, `views` DESC, `ti` DESC":" ORDER BY `tis` ASC, `ti` DESC").$show);
		$s->execute([
			':contentType'=>$contentType
		]);
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
		$items=preg_replace([
			'/<print content=[\"\']?srcset[\"\']?>/',
			'/<print content=[\"\']?thumb[\"\']?>/',
			'/<print content=[\"\']?imageALT[\"\']?>/',
			'/<print content=[\"\']?linktitle[\"\']?>/',
			'/<print content=[\"\']?contentType[\"\']?>/',
			'/<print content=[\"\']?schemaType[\"\']?>/',
			'/<print metaDate>/',
			'/<print content=[\"\']?title[\"\']?>/',
			'/<print time>/',
			'/<print content=[\"\']?caption[\"\']?>/'
		],[
			'srcset="'.
				($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'media/sm/'.basename($r['thumb']).' '.$config['mediaMaxWidthThumb'].'w,':NOIMAGESM.' '.$config['mediaMaxWidthThumb'].'w,').
				($r['thumb']!=''&&file_exists('media/md/'.basename($r['thumb']))?'media/md/'.basename($r['thumb']).' 600w,':NOIMAGE.' 600w,').
				($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'media/sm/'.basename($r['thumb']).' 400w':NOIMAGESM.' 400w').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" ',
			($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'media/sm/'.basename($r['thumb']):NOIMAGESM),
			htmlspecialchars($r['fileALT']!=''?$r['fileALT']:$r['title'],ENT_QUOTES,'UTF-8'),
			URL.$r['contentType'].'/'.$r['urlSlug'].'/',
			ucwords($r['contentType']),
			$r['schemaType'],
			date('Y-m-d',$r['ti']),
			htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
			$time,
			$r['seoCaption']!=''?htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'):substr(strip_tags($r['notes']),0,100).'...'
		],$items);
		$output.=$items;
	}
	$outside=preg_replace([
		'~<items>.*?<\/items>~is',
		'~<settings.*?>~is'
	],[
		$output,
		''
	],$outside,1);
	$sideTemp=preg_replace('~<item>.*?<\/item>~is',$outside,$sideTemp,1);
}
$content.=$sideTemp;
