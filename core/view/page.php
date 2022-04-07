<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Page
 * @package    core/view/page.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/sanitize/HTMLPurifier.php';
$purify=new HTMLPurifier(HTMLPurifier_Config::createDefault());
$rank=0;
$notification='';
$html=str_replace('<print view>',$view,$html);
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
$items=$html;
require'core/parser.php';
$html=$items;
if(stristr($html,'<playlist')){
	$sp=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='playlist' AND `rid`=:rid ORDER BY ord ASC");
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
			preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",$pr['url'],$vidEmbed);
			$bpli=preg_replace([
				'/<print playlist=[\"\']?videoid[\"\']?>/',
				'/<print playlist=[\"\']?url[\"\']?>/'
			],[
				$vidEmbed[1],
				$pr['url']
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
$seoTitle=empty($page['seoTitle'])?trim(htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8')):htmlspecialchars($page['seoTitle'],ENT_QUOTES,'UTF-8');
$metaRobots=!empty($page['metaRobots'])?htmlspecialchars($page['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
$seoCaption=!empty($page['seoCaption'])?htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
$seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
$seoDescription=!empty($page['seoDescription'])?htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
$seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
$seoKeywords=!empty($page['seoKeywods'])?htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');
$seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;
$content.=$html;
