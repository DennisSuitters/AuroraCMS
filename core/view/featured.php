<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Featured
 * @package    core/view/featured.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
if($page['sliderOptions'][0]==1){
	preg_match('/<settings itemcount="([\w\W]*?)" contenttype="([\w\W]*?)" order="([\w\W]*?)">/',$html,$matches);
	$html=preg_replace('~<settings.*?>~is','',$html,1);
	$itemCount=$matches[1];
	$limit=', '.$matches[1];
	if($itemCount==0){
		$itemCount=$config['showItems'];
		$limit='';
	}
	$contentType=$matches[2];
	$cT=$matches[2];
	if($contentType=='all'||$contentType=='mixed')$contentType='%';
	if($matches[3]=='asc'||$matches[3]=='ASC'){
		$order='id ASC';
		$arrayOrder='asc';
	}elseif($matches[3]=='rand'||$matches[3]=='random'){
		$order='RAND()';
		$arrayOrder='random';
	}else{
		$order='id DESC';
		$arrayOrder='desc';
	}
	preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
	$it=$matches[1];
	$items='';
	$fi=0;
	$featuredfiles=array();
	if($cT!='folder'){
		$sf=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `file`!='' AND `thumb`!='' AND `featured`='1' AND `internal`!='1' AND `status`='published' AND `rank`<=:rank ORDER BY $order $limit");
		$sf->execute([':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0]);
		while($f=$sf->fetch(PDO::FETCH_ASSOC)){
			if(isset($_SESSION['rank'])){
				if($f['rank']>$_SESSION['rank'])continue;
			}
			$filechk=basename($f['file']);
			if(file_exists('media/'.$filechk)){
				$featuredfiles[]=[
					'id'=>$f['id'],
					'carousel'=>'',
					'filehtml'=>'',
					'options'=>$f['options'],
					'contentType'=>$f['contentType'],
					'rank'=>$f['rank'],
					'urlSlug'=>$f['urlSlug'],
					'thumb'=>$f['thumb'],
					'file'=>$f['file'],
					'fileALT'=>$f['fileALT'],
					'title'=>$f['title'],
					'link'=>$f['contentType'].'/'.$f['urlSlug'].'/',
					'seoCaption'=>$f['seoCaption'],
					'attributionImageTitle'=>$f['attributionImageTitle'],
					'attributionImageName'=>$f['attributionImageName'],
					'attributionImageURL'=>$f['attributionImageURL'],
					'notes'=>$f['notes'],
					'seoDescription'=>$f['seoDescription'],
					'coming'=>$f['coming'],
					'rrp'=>$f['rrp'],
					'rCost'=>$f['rCost'],
					'cost'=>$f['cost'],
					'dCost'=>$f['dCost'],
					'stockStatus'=>$f['stockStatus'],
					'ti'=>$f['ti']
				];
			}
		}
	}
	if($cT=='all'||$cT=='mixed'||$cT=='folder'){
		if(file_exists('media/carousel/')){
			foreach(glob('media/carousel/*.*')as$file){
				$fileinfo=pathinfo($file);
				$filetime=filemtime($file);
				if($file=='.'||$file=='..')continue;
				$filename=basename($file,'.'.$fileinfo['extension']);
				if($fileinfo['extension']=='jpg'||$fileinfo['extension']=='jpeg'||$fileinfo['extension']=='png'||$fileinfo['extension']=='webp'){
					if(!in_array('media/carousel/'.$filename.'.html',$featuredfiles)){
						$filehtml=file_exists('media/carousel/'.$filename.'.html')?file_get_contents('media/carousel/'.$filename.'.html'):'';
						$featuredfiles[]=[
							'id'=>time(),
							'carousel'=>$filehtml!=''?'filehtml':'folder',
							'filehtml'=>$filehtml,
							'options'=>00000000000000000000000000000000,
							'contentType'=>'carousel',
							'rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0,
							'urlSlug'=>'',
							'thumb'=>$file,
							'file'=>$file,
							'fileALT'=>basename(rtrim($file),3),
							'title'=>basename(rtrim($file),3),
							'link'=>'nolink',
							'seoCaption'=>'',
							'attributionImageTitle'=>isset($r['attributionImageTitle'])?$r['attributionImageTitle']:'',
							'attributionImageName'=>isset($r['attributionImageName'])?$r['attributionImageName']:'',
							'attributionImageURL'=>isset($r['attributionImageURL'])?$r['attributionImageURL']:'',
							'notes'=>'',
							'seoDescription'=>'',
							'coming'=>0,
							'rrp'=>0,
							'rCost'=>0,
							'cost'=>0,
							'dCost'=>0,
							'stockStatus'=>'',
							'ti'=>$filetime
						];
					}
				}
			}
		}
	}
	if(count($featuredfiles)>0){
		if($arrayOrder=='random')shuffle($featuredfiles);
		elseif($arrayOrder=='asc')asort($featuredfiles);
		else arsort($featuredfiles);
		$showCarousel=true;
		$ord1=rand(1,2);
		$ord2=$ord1==1?2:1;
		foreach($featuredfiles as $f){
			$item=$it;
			$sideCost='';
			if($f['carousel']=='filehtml'){
				$item=$f['filehtml'];
			}else{
				if((isset($f['options'][0])&&$f['options'][0]==1)||$f['cost']!=''){
					if($f['stockStatus']=='pre-order')$sideCost.='<div class="pre-order">Pre-Order</div>';
					elseif(isset($f['coming'][0])&&$f['coming'][0]==1)$sideCost.='<div class="sold">Coming Soon</div>';
					else{
						if($f['stockStatus']=='sold out')$sideCost.='<div class="sold d-inline">';
						$sideCost.=$f['rrp']!=0?'<span class="rrp d-inline mr-5">RRP &#36;'.$f['rrp'].'</span>':'';
						$sideCost.=(is_numeric($f['cost'])&&$f['cost']!=0?'<span class="cost d-inline mr-5'.($f['rCost']!=0?' strike':'').'">'.(is_numeric($f['cost'])?'&#36;':'').htmlspecialchars($f['cost'],ENT_QUOTES,'UTF-8').'</span>'.($f['rCost']!=0?'<span class="reduced d-inline mr-5">&#36;'.$f['rCost'].'</span>':''):'<span>'.htmlspecialchars($f['cost'],ENT_QUOTES,'UTF-8').'</span>');
						if($f['stockStatus']=='sold out')$sideCost.='</div>';
					}
				}
				$f['notes']=isset($r['seoDescription'])&&$r['seoDescription']?$f['seoDescription']:strip_tags($f['notes']);
				$f['notes']=substr(rawurldecode($f['notes']),0,300).'...';
				$item=preg_replace([
					'/<print link>/',
					'/<print content=[\"\']?title[\"\']?>/',
					'/<print content=[\"\']?contentType[\"\']?>/',
					'/<print content=[\"\']?rank[\'"\']?>/',
					'/<print content=[\"\']?cssrank[\'"\']?>/',
					'/<print content=[\"\']?cost[\"\']?>/',
					'/<print content=[\"\']?id[\"\']?>/',
					'/<print content=[\"\']?thumb[\"\']?>/',
					'/<print content=[\"\']?image[\"\']?>/',
					'/<print content=[\"\']?alt[\"\']?>/',
					'/<print content=[\"\']?caption[\"\']?>/',
					'/<\/?thumb>/',
					'/<rand>/',
					'/<ord1>/',
					'/<ord2>/',
					'/<carousel>/',
					$f['attributionImageName']!=''&&$f['attributionImageURL']!=''?'/<\/?attribution>/':'~<attribution>.*?<\/attribution>~is',
					'/<print media=[\"\']?attributionName[\"\']?>/',
					'/<print media=[\"\']?attributionURL[\"\']?>/',
					'/<print content=[\"\']?notes[\"\']?>/',
					'/<\/?caption>/'
				],[
					$f['urlSlug']!=''?URL.$f['contentType'].'/'.$f['urlSlug']:'',
					$f['title'],
					$f['contentType']=='carousel'?'':$f['contentType'],
					$f['contentType']=='carousel'?'':($f['rank']>300?ucwords(str_replace('-',' ',rank($f['rank']))):''),
					rank($f['rank']),
					$sideCost,
					$f['id'],
					$f['thumb'],
					$page['sliderOptions'][6]==1?'<img src="'.$f['file'].'" alt="'.$f['fileALT']!=''?$f['fileALT']:str_replace('-',' ',basename($f['file'])).'">':'',
					$f['fileALT']!=''?$f['fileALT']:str_replace('-',' ',basename($f['file'])),
					$f['seoCaption']!=''?$f['seoCaption']:$f['notes'],
					'',
					$f['carousel']=='folder'?'':'rot'.rand(1,6),
					$ord1,
					$ord2,
					$f['carousel'],
					'',
					htmlspecialchars($f['attributionImageName'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($f['attributionImageURL'],ENT_QUOTES,'UTF-8'),
					$f['notes']!=''?htmlspecialchars(strip_tags(rawurldecode($f['notes'])),ENT_QUOTES,'UTF-8'):'',
					''
				],$item);
			}
			$items.=$item;
			$ord1=$ord1==1?2:1;
			$ord2=$ord2==1?2:1;
		}
		$html=preg_replace([
			'~<items>.*?<\/items>~is',
			'/<div class="swiper-button-prev"><\/div>/',
			'/<div class="swiper-button-next"><\/div>/',
			'/<div class="swiper-pagination"><\/div>/',
			'/<div class="swiper-scrollbar"><\/div>/'
		],[
			$items,
			$page['sliderOptions'][3]==1?'<div class="swiper-button-prev"></div>':'',
			$page['sliderOptions'][3]==1?'<div class="swiper-button-next"></div>':'',
			$page['sliderOptions'][4]==1?'<div class="swiper-pagination"></div>':'',
			$page['sliderOptions'][5]==1?'<div class="swiper-scrollbar"></div>':'',
		],$html);
		$content.=$html;
	}
}
