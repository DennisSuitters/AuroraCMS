<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Page
 * @package    core/view/page.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$activation='<div class="alert alert-warning">There was an issue Activating your account, or an Activation token was not supplied!</div>';
$activated=false;
if(isset($_GET['activate'])&&$_GET['activate']!=''){
	$activate=filter_input(INPUT_GET,'activate',FILTER_UNSAFE_RAW);
	$sa=$db->prepare("UPDATE `".$prefix."login` SET `active`='1',`activate`='',`rank`='200' WHERE `activate`=:activate");
	$sa->execute([':activate'=>$activate]);
  if($sa->rowCount()>0){
	   $activation=preg_replace([
       '/<print alert>/',
       '/<print text>/'
     ],[
       'success',
       'Your Account is now Active!'
     ],$theme['settings']['alert']);
		 $activated=true;
  }else{
    $activation=preg_replace([
      '/<print alert>/',
      '/<print text>/'
    ],[
      'danger',
      'There was an Issue Activating your Account! If you believe this an error, please <a href="'.URL.'contactus/">contact</a> us.'
    ],$theme['settings']['alert']);
  }
}
$html=str_replace('<print view>',$view,$html);
require'inc-cover.php';
require'inc-breadcrumbs.php';
$html=preg_replace([
  '/<activation>/',
  '/<print page=[\"\']?heading[\"\']?>/',
  '/<print page=[\"\']?notes[\"\']?>/',
  '/<print content=[\"\']?schemaType[\"\']?>/',
	$activated==true?'/<[\/]?success>/':'~<success>.*?<\/success>~is',
	'/<print url>/'
],[
  $activation,
  htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
  $page['notes'],
  $page['contentType'],
	'',
	URL
],$html);
$items=$html;
require'core/parser.php';
$html=$items;
$seoTitle=empty($page['seoTitle'])?trim(htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8')):htmlspecialchars($page['seoTitle'],ENT_QUOTES,'UTF-8');
$metaRobots=!empty($page['metaRobots'])?htmlspecialchars($page['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
$seoCaption=!empty($page['seoCaption'])?htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
$seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
$seoDescription=!empty($page['seoDescription'])?htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
$seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
$seoKeywords=!empty($page['seoKeywods'])?htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');
$seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;
$content.=$html;
