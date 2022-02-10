<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Gallery
 * @package    core/view/gallery.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/sanitize/HTMLPurifier.php';
$purify=new HTMLPurifier(HTMLPurifier_Config::createDefault());
require'inc-cover.php';
require'inc-breadcrumbs.php';
$html=preg_replace([
	'/<print page=[\"\']?heading[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<print page=[\"\']?notes[\"\']?>/',
],[
	$page['heading']==''?$page['seoTitle']:$page['heading'],
  '',
	$purify->purify($page['notes']),
],$html);
$gals='';
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $gal=$matches[1];
  $s=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `pid`=:pid AND `rank`<=:rank ORDER BY `ord` ASC");
  $s->execute([
		':pid'=>10,
		':rank'=>$_SESSION['rank']
	]);
  $output='';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if(!file_exists('media/thumbs/'.basename($r['file'])))continue;
    $items=$gal;
		$caption=$r['fileALT']!=''?$r['fileALT']:ucwords(str_replace('-',' ',basename($r['file'])));
    $items=preg_replace([
			'/<print thumb=[\"\']?srcset[\"\']?>/',
			'/<print lightbox=[\"\']?srcset[\"\']?>/',
			'/<print media=[\"\']?thumb[\"\']?>/',
      '/<print media=[\"\']?file[\"\']?>/',
			'/<print media=[\"\']?fileALT[\"\']?>/',
      '/<print media=[\"\']?title[\"\']?>/',
      '/<print media=[\"\']?caption[\"\']?>/',
      '/<print media=[\"\']?attributionImageName[\"\']?>/',
      '/<print media=[\"\']?attributionImageURL[\"\']?>/'
    ],[
			' srcset="'.
				($r['file']!=''&&file_exists('media/sm/'.basename($r['file']))?'media/sm/'.basename($r['file']).' '.$config['mediaMaxWidthThumb'].'w,':NOIMAGESM.' '.$config['mediaMaxWidthThumb'].'w,').
				($r['file']!=''&&file_exists('media/md/'.basename($r['file']))?'media/md/'.basename($r['file']).' 600w,':NOIMAGE.' 600w,').
				($r['file']!=''&&file_exists('media/sm/'.basename($r['file']))?'media/sm/'.basename($r['file']).' 400w':NOIMAGESM.' 400w').'" sizes="(min-width: '.$config['mediaMaxWidthThumb'].'px) '.$config['mediaMaxWidthThumb'].'px"',
      'media/'.basename($r['file']).' '.$config['mediaMaxWidth'].'w,'.(file_exists('media/lg/'.basename($r['file']))?'media/lg/'.basename($r['file']).' 1000w,':'').(file_exists('media/md/'.basename($r['file']))?'media/md/'.basename($r['file']).' 600w':''),
      'media/sm/'.basename($r['file']),
      $r['file'],
			htmlspecialchars($caption,ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['attributionImageName'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['attributionImageURL'],ENT_QUOTES,'UTF-8')
    ],$items);
    $items=$r['attributionImageName']!=''&&$r['attributionImageURL']!=''?preg_replace('/<[\/]?attribution>/','',$items):preg_replace('~<attribution>.*?<\/attribution>~is','',$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}
$content.=$gals;
