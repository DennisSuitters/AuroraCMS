<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Include Category Nav
 * @package    core/view/inc-categorynav.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($config['options'][31]==1&&stristr($html,'<category-nav>')){
	$sc1=$db->prepare("SELECT DISTINCT(`category_1`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND `category_1`!='' AND `status`='published' GROUP BY `category_1` ORDER BY `category_1` ASC");
	$sc1->execute([':contentType'=>$view]);
	$catlist='';
	if($sc1->rowCount()>0){
		while($rc1=$sc1->fetch(PDO::FETCH_ASSOC)){
			$sc2=$db->prepare("SELECT DISTINCT(`category_2`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND LOWER(`category_1`) LIKE LOWER(:category1) AND `category_2`!='' GROUP BY `category_2` AND `status`='published' ORDER BY `category_2` ASC");
			$sc2->execute([
				':contentType'=>$view,
				':category1'=>$rc1['category_1']
			]);
			$cat1=isset($args[0])&&$args[0]!=''?$args[0]:'';
			$rcc1=urlencode(str_replace(' ','-',strtolower($rc1['category_1'])));
			$catlist.='<li'.($cat1==$rcc1?' class="open"':'').'>'.($sc2->rowCount()>0?'<a class="opener" role="button" tabindex="0" aria-label="Open/Close Category '.$rc1['category_1'].'">&nbsp;</a>':'').'<a href="'.URL.$view.'/'.urlencode(str_replace(' ','-',strtolower($rc1['category_1']))).'">'.ucwords($rc1['category_1']).'</a>';
			while($rc2=$sc2->fetch(PDO::FETCH_ASSOC)){
				$sc3=$db->prepare("SELECT DISTINCT(`category_3`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND LOWER(`category_1`) LIKE LOWER(:category1) AND LOWER(`category_2`) LIKE LOWER(:category2) AND `category_3`!='' GROUP BY `category_3` AND `status`='published' ORDER BY `category_3` ASC");
				$sc3->execute([
					':contentType'=>$view,
					':category1'=>$rc1['category_1'],
					':category2'=>$rc2['category_2']
				]);
				$cat2=isset($args[1])&&$args[1]!=''?$args[1]:'';
				$rcc2=urlencode(str_replace(' ','-',strtolower($rc2['category_2'])));
				$catlist.='<ul><li'.($cat2==$rcc2?' class="open"':'').'>'.($sc3->rowCount()>0?'<a class="opener" role="button" tabindex="0" aria-label="Open/Close Category '.$rc2['category_2'].'">&nbsp;</a>':'').'<a href="'.URL.$view.'/'.urlencode(str_replace(' ','-',strtolower($rc1['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($rc2['category_2']))).'">'.ucwords($rc2['category_2']).'</a>'."\r\n";
				while($rc3=$sc3->fetch(PDO::FETCH_ASSOC)){
					$sc4=$db->prepare("SELECT DISTINCT(`category_4`) FROM `".$prefix."content` WHERE `contentType`=:contentType AND LOWER(`category_1`) LIKE LOWER(:category1) AND LOWER(`category_2`) LIKE LOWER(:category2) AND LOWER(`category_3`) LIKE LOWER(:category3) AND `category_4`!='' GROUP BY `category_4` AND `status`='published' ORDER BY `category_4` ASC");
					$sc4->execute([
						':contentType'=>$view,
						':category1'=>$rc1['category_1'],
						':category2'=>$rc2['category_2'],
						':category3'=>$rc3['category_3']
					]);
					$cat3=isset($args[2])&&$args[2]!=''?$args[2]:'';
					$rcc3=urlencode(str_replace(' ','-',strtolower($rc3['category_3'])));
					$catlist.='<ul><li'.($cat3==$rcc3?' class="open"':'').'>'.($sc4->rowCount()!=0?'<a class="opener" role="button" tabindex="0" aria-label="Open/Close Category '.$rc3['category_3'].'">&nbsp;</a>':'').'<a href="'.URL.$view.'/'.urlencode(str_replace(' ','-',strtolower($rc1['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($rc2['category_2']))).'/'.urlencode(str_replace(' ','-',strtolower($rc3['category_3']))).'">'.ucwords($rc3['category_3']).'</a>';
					while($rc4=$sc4->fetch(PDO::FETCH_ASSOC)){
						$cat4=isset($args[3])&&$args[3]!=''?$args[3]:'';
						$catlist.='<ul><li><a href="'.URL.$view.'/'.urlencode(str_replace(' ','-',strtolower($rc1['category_1']))).'/'.urlencode(str_replace(' ','-',strtolower($rc2['category_2']))).'/'.urlencode(str_replace(' ','-',strtolower($rc3['category_3']))).'/'.urlencode(str_replace(' ','-',strtolower($rc4['category_4']))).'">'.ucwords($rc4['category_4']).'</a></li></ul>';
					}
					$catlist.='</li></ul>'."\r\n";
				}
				$catlist.='</li></ul>'."\r\n";
			}
				$catlist.='</li>'."\r\n";
		}
		$html=preg_replace([
			'/<\/?category-nav>/',
			'/<catlist>/'
		],[
			'',
			$catlist
		],$html);
	}else
		$html=preg_replace('~<category-nav>.*?<\/category-nav>~is','',$html);
}else
	$html=preg_replace('~<category-nav>.*?<\/category-nav>~is','',$html);
