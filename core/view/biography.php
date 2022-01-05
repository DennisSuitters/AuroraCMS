<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Biography
 * @package    core/view/biography.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.4
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
  $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `bio`=1 ORDER BY `ord` ASC");
  $s->execute();
  $output='';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$bioavatar=$r['avatar']!=''?'media/avatar/'.basename($r['avatar']):NOAVATAR;
    $items=$gal;
		$caption=$r['caption']!=''?$r['caption']:ucwords(str_replace('-',' ',basename($r['avatar'])));
    $items=preg_replace([
			'/<rand>/',
      '/<print bio=[\"\']?avatar[\"\']?>/',
			'/<print bio=[\"\']?imageALT[\"\']?>/',
      '/<print bio=[\"\']?name[\"\']?>/',
      '/<print bio=[\"\']?caption[\"\']?>/',
			'/<print bio=[\"\']?notes[\"\']?>/'
    ],[
			rand(1,6),
      $bioavatar,
      htmlspecialchars(($r['name']==''?$r['username']:$r['name']),ENT_QUOTES,'UTF-8'),
			htmlspecialchars(($r['name']==''?$r['username']:$r['name']),ENT_QUOTES,'UTF-8'),
			htmlspecialchars($caption,ENT_QUOTES,'UTF-8'),
			$purify->purify($r['notes'])
    ],$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}
$content.=$gals;
