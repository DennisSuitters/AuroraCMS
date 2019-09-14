<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Featured Left
 * @package    core/view/feature-left.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Make sure all links end with /
 */
if(stristr($html,'<categories')){
	preg_match('/<categories>([\w\W]*?)<\/categories>/',$html,$matches);
	$cat=$matches[1];
	$s=$db->prepare("SELECT DISTINCT category_1 FROM `".$prefix."content` WHERE contentType LIKE 'inventory' AND internal!='1' AND status='published' ORDER BY category_1 ASC");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$cat;
		$items=preg_replace([
			'/<print content=[\"\']?link[\"\']?>/',
			'/<print content=[\"\']?category_1[\"\']?>/'
		],[
			URL.htmlspecialchars('inventory/'.urlencode(str_replace(' ','-',$r['category_1'])),ENT_QUOTES,'UTF-8').'/',
			htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8')
		],$items);
		$output.=$items;
	}
	$cats=preg_replace('~<categories>.*?<\/categories>~is',$output,$html,1);
}else
	$cats='';
$content.=$cats;
