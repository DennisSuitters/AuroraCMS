<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Biography
 * @package    core/view/biography.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.12
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'inc-cover.php';
require'inc-breadcrumbs.php';
if(stristr($html,'<playlist')){
	$sp=$db->prepare("SELECT * FROM `".$prefix."playlist` WHERE `rid`=:rid ORDER BY ord ASC");
	$sp->execute([
		':rid'=>$page['id']
	]);
	$playlistoutput='';
	if($sp->rowCount()>0){
		preg_match('/<playlistitem>([\w\W]*?)<\/playlistitem>/',$html,$match);
		$pli=$match[1];
		$playlistoutput='';
		while($pr=$sp->fetch(PDO::FETCH_ASSOC)){
			$bpli='';
			$bpli=preg_replace([
				'/<json-ld>/',
				'/<print playlist=[\"\']?title[\"\']?>/',
				'/<print playlist=[\"\']?thumbnail_url[\"\']?>/',
				'/<print playlist=[\"\']?url[\"\']?>/',
				'/<print playlist=[\"\']?embedurl[\"\']?>/',
				'/<print playlist=[\"\']?notes[\"\']?>/'
			],[
				'<script type="application/ld+json">{'.
					'"@content":"https://schema.org",'.
					'"@type":"VideoObject",'.
					'"name":"'.$pr['title'].'",'.
					'"description":"'.($pr['notes']!=''?strip_tags($pr['notes']):$pr['title']).'",'.
					'"thumbnailUrl":['.
						'"'.$pr['thumbnail_url'].'"'.
					']'.
					'"uploadDate":"'.$pr['dt'].'"'.
				'}</script>',
				$pr['title'],
				$pr['thumbnail_url'],
				$pr['url'],
				$pr['embed_url'],
				$pr['notes']
			],$pli);
			$playlistoutput.=$bpli;
		}
		$html=preg_replace([
			'/<[\/]?playlist>/',
			'~<playlistitem>.*?<\/playlistitem>~is'
		],[
			'',
			$playlistoutput
		],$html);
	}else{
		$html=preg_replace('~<playlist>.*?<\/playlist>~is','',$html);
	}
}
$html=preg_replace([
	'/<print page=[\"\']?heading[\"\']?>/',
	$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<print page=[\"\']?notes[\"\']?>/',
],[
	$page['heading']==''?$page['seoTitle']:$page['heading'],
  '',
	$page['notes'],
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
			$caption,
			$r['notes']
    ],$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}
$content.=$gals;
