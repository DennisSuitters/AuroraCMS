<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Gallery
 * @package    core/view/gallery.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Add Page Editing.
 */
if($page['notes']!=''){
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<\/?pagenotes>/'
	],[
		rawurldecode($page['notes']),
		''
	],$html);
}else
	$html=preg_replace('~<pagenotes>.*?<\/pagenotes>~is','',$html,1);
$gals='';
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $gal=$matches[1];
  $s=$db->prepare("SELECT * FROM `".$prefix."media` WHERE pid=:pid ORDER BY ord ASC");
  $s->execute([':pid'=>10]);
  $output='';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $items=$gal;
    $bname=basename(substr($r['file'],0,-4));
    $bname=rtrim($bname,'.');
    $items=preg_replace([
      '/<print media=[\"\']?thumb[\"\']?>/',
      '/<print media=[\"\']?file[\"\']?>/',
			'/<print media=[\"\']?fileALT[\"\']?>/',
      '/<print media=[\"\']?title[\"\']?>/',
      '/<print media=[\"\']?caption[\"\']?>/',
      '/<print media=[\"\']?attributionImageName[\"\']?>/',
      '/<print media=[\"\']?attributionImageURL[\"\']?>/'
    ],[
      URL.'media/thumbs/'.$bname.'.png',
      htmlspecialchars($r['file'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars(($r['fileALT']!=''?$r['fileALT']:$r['title']),ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['attributionImageName'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['attributionImageURL'],ENT_QUOTES,'UTF-8')
    ],$items);
    if($r['attributionImageName']!=''&&$r['attributionImageURL']!=''){
      $items=str_replace([
        '<attribution>',
        '</attribution>'
      ],'',$items);
    }else
      $items=preg_replace('~<attribution>.*?<\/attribution>~is','',$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}else
  $gals='';
$content.=$gals;
