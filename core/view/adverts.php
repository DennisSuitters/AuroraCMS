<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Adverts
 * @package    core/view/adverts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(stristr($html,'<settings')){
	preg_match('/<settings.*orientation=[\"\'](.+?)[\"\'].*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
	$orientation=isset($matches[1])&&$matches[1]!=''?$matches[1]:'horizontal';
	$count=isset($matches[2])&&$matches[2]!=0?$matches[2]:1;
}else{
	$orientation='horizontal';
	$count=1;
}
preg_match('/<advert>([\w\W]*?)<\/advert>/',$html,$matches);
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
$html=preg_replace([
	'~<settings.*?>~is',
	$adc>0?'/<[\/]?adverts>/':'~<adverts>.*?<\/adverts>~is',
	'~<advert>.*?<\/advert>~is'
],[
	'',
	'',
	$advertitems
],$html);
$content.=$html;
