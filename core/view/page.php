<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Page
 * @package    core/view/page.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.15
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$html=str_replace('<print view>',$view,$html);
if(!isset($args[0])){
  $page['id']=0;
  $page['cover']='';
  $page['notes']='';
  $page['seoTitle']='Pages List';
  $page['heading']=' ';
  $page['seoDescription']='Pages List of '.$config['business'];
  $sp=$db->query("SELECT * FROM `".$prefix."menu` WHERE `contentType`='page' AND `title`!='' AND `active`=1 ORDER BY `ord` ASC");
  while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
    $page['notes'].='<p><a href="'.URL.strtolower($rp['contentType']).'/'.str_replace(' ','-',$rp['title']).'/">'.$rp['title'].'</a></p>';
  }
}
require'inc-cover.php';
require'inc-breadcrumbs.php';
$page['notes']=preg_replace([
  '/{business}/',
  '/{url}/'
],[
  $config['business'],
  URL
],$page['notes']);
$html=preg_replace([
  '/<print page=[\"\']?heading[\"\']?>/',
  '/<print page=[\"\']?notes[\"\']?>/',
  '/<print content=[\"\']?schemaType[\"\']?>/',
  '/<cost>([\w\W]*?)<\/cost>/',
  '/<review>([\w\W]*?)<\/review>/',
  '/<author>([\w\W]*?)<\/author>/',
  '/<settings([\w\W]*?)>/',
  '/<items>([\w\W]*?)<\/items>/',
  '/<more>([\w\W]*?)<\/more>/',
  '/<[\/]?item>/'
],[
  htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
  $page['notes'],
  $page['contentType'],
  '',
  '',
  '',
  '',
  '',
  ''
],$html);
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
$seoTitle=empty($page['seoTitle'])?trim(escaper($page['title'])):escaper($page['seoTitle']);
$metaRobots=!empty($page['metaRobots'])?escaper($page['metaRobots']):'index,follow';
$seoCaption=!empty($page['seoCaption'])?escaper($page['seoCaption']):escaper($page['seoCaption']);
$seoCaption=empty($seoCaption)?escaper($config['seoCaption']):escaper($seoCaption);
$seoDescription=!empty($page['seoDescription'])?escaper($page['seoDescription']):escaper($page['seoDescription']);
$seoDescription=empty($seoDescrption)?escaper($config['seoDescription']):escaper($seoDescription);
$seoKeywords=!empty($page['seoKeywods'])?escaper($page['seoKeywords']):escaper($page['seoKeywords']);
$seoKeywords=empty($seoKeywords)?escaper($config['seoKeywords']):escaper($seoKeywords);
$content.=$html;
