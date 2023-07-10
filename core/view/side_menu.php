<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Side Menu
 * @package    core/view/side_menu.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
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
				if($r['coming']==1)$sideCost.='<div class="sold">Coming Soon</div>';
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
			($r['coming']==1?'~<quantity>.*?<\/quantity>~is':'/<[\/]?quantity>/'),
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
			if(stristr($sideTemp,'<choices>')){
				$soc=$db->prepare("SELECT DISTINCT(`category`) AS 'category' FROM `".$prefix."choices` WHERE `rid`=:rid AND `contentType`='option' AND `status`='available' ORDER BY `ord` ASC");
				$soc->execute([':rid'=>$r['id']]);
				if($soc->rowCount()>0){
					$options=$oco=$oc2='';
					while($roc=$soc->fetch(PDO::FETCH_ASSOC)){
						$soi=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:rid AND `category`=:cat AND `contentType`='option' AND `status`='available' ORDER BY `ord` ASC");
						$soi->execute([
							':cat'=>$roc['category'],
							':rid'=>$r['id']
						]);
						if($soi->rowCount()>0){
							$options.='<div class="col-12 mt-3">'.
							'<div class="h3 text-left m-0 p-0">'.$roc['category'].'</div>'.
							'<div class="row">'.
								'<div class="col-12 m-0 p-0 pl-2 text-left">'.
									'<select id="'.strtolower(str_replace(' ','',$roc['category'])).'options" name="options[]">'.
										'<option value="">Select '.($roc['category']==''?'an ':'a ').$roc['category'].' Option</option>';
							while($roi=$soi->fetch(PDO::FETCH_ASSOC)){
								if($roi['oid']!=0){
									$soic=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
									$soic->execute([':id'=>$roi['oid']]);
									$roic=$soic->fetch(PDO::FETCH_ASSOC);
									if($roi['quantity']==''){
										$roi['quantity']=$roic['quantity'];
									}
									if($roi['cost']==''){
										if($roic['cost']!=0)$roi['cost']=$roic['cost'];
										if($roic['rCost']!=0)$roi['cost']=$roic['rCost'];
										if(isset($user['rank'])){
											if($user['rank']>300&&$user['rank']<400){
												if(isset($user['options'])&&$user['options'][19]==1){
													if($roic['dCost']!=0)$roi['cost']=$roic['dCost'];
												}
											}
										}
									}
								}
								if($roi['quantity']!=''){
									$options.='<option value="'.$roi['id'].'">'.$roi['title'].($roi['cost']>0||$roi['cost']!=''?' - &dollar;'.$roi['cost']:'').'</option>';
								}
							}
							$options.='</select>'.
											'</div>'.
										'</div>'.
									'</div>';
						}
					}
					$sideTemp=preg_replace('/<choices>/',$options,$sideTemp);
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
					($r['coming']==1?'~<inventory>.*?<\/inventory>~is':'/<[\/]?inventory>/'),
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
			if($cr['file']==''){
				if($ci['thumb']!='')
					$cr['file']=$ci['thumb'];
				else
					$cr['file']=NOIMAGE;
			}
			$cartitem=preg_replace([
				'/<print cartageitem=[\"\']?thumb[\"\']?>/',
				'/<print cartageitem=[\"\']?title[\"\']?>/',
				'/<print cartageitem=[\"\']?quantity[\"\']?>/',
				'/<print cartageitem=[\"\']?cost[\"\']?>/'
			],[
				$cr['file'],
				$cr['title'],
				$cr['quantity'],
				$cr['cost']
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
	$sideTemp=preg_replace($r['active']==1?'/<[\/]?newsletters>/':'/<newsletters>([\w\W]*?)<\/newsletters>/','',$sideTemp,1);
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
			(stristr($r['thumb'],'unsplash')?'':'srcset="'.($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'media/sm/'.basename($r['thumb']).' '.$config['mediaMaxWidthThumb'].'w,':NOIMAGESM.' '.$config['mediaMaxWidthThumb'].'w,').($r['thumb']!=''&&file_exists('media/md/'.basename($r['thumb']))?'media/md/'.basename($r['thumb']).' 600w,':NOIMAGE.' 600w,').($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'media/sm/'.basename($r['thumb']).' 400w':NOIMAGESM.' 400w').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px" '),
			$r['thumb']!=''?$r['thumb']:NOIMAGESM,
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

	if(stristr($sideTemp,'<adverts')){
		preg_match('/<adverts.*orientation=[\"\'](.+?)[\"\'].*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
		$orientation=isset($matches[1])&&$matches[1]!=''?$matches[1]:'horizontal';
		$count=isset($matches[2])&&$matches[2]!=0?$matches[2]:1;
	}else{
		$orientation='horizontal';
		$count=1;
	}
	preg_match('/<advert>([\w\W]*?)<\/advert>/',$sideTemp,$matches);
	$item=$matches[1];
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='advert' AND `status`='published' AND `length`=:o AND `status`='published' ORDER BY RAND()");
	$s->execute([
		':o'=>($orientation=='vertical'?'v':'h')
	]);
	$i=1;
	$items=$advertitems='';
	$adc=$s->rowCount();
	if($adc>0){
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			if($i>$count)continue;
			if($r['quantity']>0&&$r['views']>=$r['quantity'])continue;
			if($r['tis']>0&&$ti<$r['tis'])continue;
			if($r['tie']>0&&$ti>$r['tie'])continue;
			$adurl=parse_url($r['url'],PHP_URL_HOST);
			$adurl=str_replace('www.','',$adurl);
			$sa=$db->prepare("UPDATE `".$prefix."content` SET `views`=`views`+1 WHERE `id`=:id");
			$sa->execute([':id'=>$r['id']]);
			$items=$item;
			$items=preg_replace([
				'/<print advert=[\"\']?id[\"\']?>/',
				'/<print advert=[\"\']?url[\"\']?>/',
				'/<print advert=[\"\']?shorturl[\"\']?>/',
				'/<print advert=[\"\']?image[\"\']?>/',
				'/<print advert=[\"\']?alt[\"\']?>/',
				'/<print advert=[\"\']?notes[\"\']?>/'
			],[
				$r['id'],
				$r['url'],
				$adurl,
				$r['file'],
				'Advertisement for '.$r['title'],
				'<h4>About This Ad</h4>'.($r['cost']==''||$r['cost']==0?'<p>This is a Free Advertisment that conforms to the Australia Advertising Laws set out by the <a target="_blank" href="https://www.accc.gov.au/accc-book/printer-friendly/29527" rel="nofollow noreferrer">ACCC</a></p>':'<p>This is a Paid advertisement that conforms to the Australian Advertising Laws set out by the <a target="_blank" href="https://www.accc.gov.au/accc-book/printer-friendly/29527" rel="nofollow noreferrer">ACCC</a></p>').'<p>If you would like to have an Ad placement, or have a complaint, please use our contact form to get in touch.</p><p>Our Ads are displayed randomly with only the impression and click-through count recorded, they are not selected on your viewing habits or other Privacy Violation methods.</p><p><small>Psssst, if you are running a non-profit or charity we might place your Ad for free.</small><br><br></p>',
			],$items);
			$i++;
			$advertitems.=$items;
		}
	}
	$sideTemp=preg_replace([
		$adc>0?'/<[\/]?adverts.*?>/':'~<adverts.*?>.*?<\/adverts>~is',
		'~<advert>.*?<\/advert>~is'
	],[
		'',
		$advertitems
	],$sideTemp);
}
$content.=$sideTemp;
