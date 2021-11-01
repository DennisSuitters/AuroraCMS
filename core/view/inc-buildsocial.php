<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Include Build Social
 * @package    core/view/inc-buildsocial.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
 if(stristr($html,'<buildSocial')){
 	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
 	$htmlSocial=$matches[1];
 	$socialItems='';
 	$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=0 ORDER BY `icon` ASC");
 	if($s->rowCount()>0){
 		while($r=$s->fetch(PDO::FETCH_ASSOC)){
 			$buildSocial=$htmlSocial;
 			$buildSocial=str_replace([
 				'<print sociallink>',
 				'<print rel=label>',
 				'<print socialicon>'
 			],[
 				$r['url'],
 				ucfirst($r['icon']),
 				frontsvg('i-social-'.$r['icon'])
 			],$buildSocial);
 			$socialItems.=$buildSocial;
 		}
 	}else
 		$socialItems='';
 	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
 	if($config['options'][9]==1){
 		$html=preg_replace('/<[\/]?rss>/','',$html);
 		$html=$page['contentType']=='article'||$page['contentType']=='portfolio'||$page['contentType']=='event'||$page['contentType']=='news'||$page['contentType']=='inventory'||$page['contentType']=='service'?str_replace('<print rsslink>','rss/'.$page['contentType'].'/',$html):str_replace('<print rsslink>','rss',$html);
 		$html=str_replace('<print rssicon>',frontsvg('i-social-rss'),$html);
 	}else
 		$html=preg_replace('~<rss>.*?<\/rss>~is','',$html,1);
 }
