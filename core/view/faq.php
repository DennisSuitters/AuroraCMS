<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - FAQ
 * @package    core/view/faq.php
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
$faqs='';
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $faq=$matches[1];
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='faq' ORDER BY `title` ASC");
  $s->execute();
	$i=$s->rowCount();
	$ii=0;
  $output='';
	$schema='<script type="application/ld+json">{'.
		'"@context":"https://schema.org",'.
		'"@type":"FAQPage",'.
		'"mainEntity":[';
	$sc=$db->prepare("SELECT DISTINCT(`category_1`) FROM `".$prefix."content` WHERE `contentType`='faq' ORDER BY `category_1` ASC");
	$sc->execute();
	while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='faq' AND `category_1`=:category ORDER BY `title` ASC");
	  $s->execute([':category'=>$rc['category_1']]);
		$output.=$rc['category_1']!=''?'<h2 class="h3">'.$rc['category_1'].'</h2>':'';
	  while($r=$s->fetch(PDO::FETCH_ASSOC)){
	    $faqs=$faq;
	    $faqs=preg_replace([
				'/<print details=[\"\']?open[\"\']?>/',
				'/<print content=[\"\']?title[\"\']?>/',
				'/<print content=[\"\']?notes[\"\']?>/'
	    ],[
				$r['options'][9]==1?' open':'',
	      $r['title'],
	      $r['notes']
	    ],$faqs);
	    $output.=$faqs;
			$ii++;
			$schema.='{'.
				'"@type":"Question",'.
				'"name":"'.$r['title'].'",'.
				'"acceptedAnswer":{'.
					'"@type":"Answer",'.
					'"text": "'.strip_tags($r['notes']).'"'.
				'}'.
			'}'.($ii<$i?',':'');
	  }
	}
	$schema.=']}</script>';
	$faqs=preg_replace('~<items>.*?<\/items>~is',$schema.$output,$html,1);
}
$content.=$faqs;
