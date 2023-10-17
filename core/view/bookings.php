<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Bookings
 * @package    core/view/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'inc-cover.php';
require'inc-breadcrumbs.php';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$eventDate=0;
if(stristr($html,'<items>')){
  $sb=$db->query("SELECT * FROM `".$prefix."content` WHERE `bookable`='1' AND `title`!='' AND `status`='published' AND `internal`!='1' ORDER BY `code` ASC, `title` ASC");
  if($sb->rowCount()>0){
    preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
    $item=$matches[1];
    $output='';
    while($rb=$sb->fetch(PDO::FETCH_ASSOC)){
      if($rb['tie']>0){
        if(time()>$rb['tie'])continue;
      }
      if(isset($args[0])&&$args[0]==$rb['id'])$eventDate=$rb['tis'];
      $items=$item;
      $items=preg_replace([
        '/<print id>/',
        '/<print content=[\"\']?thumb[\"\']?>/',
        '/<print content=[\"\']?imageALT[\"\']?>/',
        '/<print content=[\"\']?title[\"\']?>/',
        '/<itemChecked>/',
        '/<itemHidden>/'
      ],[
        $rb['id'],
        file_exists('media/sm/'.basename($rb['file']))&&$rb['file']!=''?'media/sm/'.basename($rb['file']):NOIMAGESM,
        htmlspecialchars(($rb['fileALT']!=''?$rb['fileALT']:$rb['title']),ENT_QUOTES,'UTF-8'),
        htmlspecialchars($rb['title'],ENT_QUOTES,'UTF-8'),
        isset($args[0])&&$args[0]==$rb['id']?'checked':'',
        isset($args[0])&&$args[0]!=$rb['id']?'d-none':''
      ],$items);
      $output.=$items;
    }
    $html=preg_replace([
      '~<items>.*?<\/items>~is',
      '~<serviceselect>.*?<\/serviceselect>~is',
      '/<[\/]?bookservices>/'
    ],[
      $output,
      '',
      '',
      ''
    ],$html);
  }else
		$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
}else{
  $sb=$db->query("SELECT * FROM `".$prefix."content` WHERE `bookable`='1' AND `title`!='' AND `status`='published' AND `internal`!='1' ORDER BY `code` ASC, `title` ASC");
  if($sb->rowCount()>0){
    $bookable='';
    while($rb=$sb->fetch(PDO::FETCH_ASSOC)){
      $bookable.='<option value="'.$rb['id'].'"'.($rb['id']==$args[0]?' selected':'').'>'.ucwords($rb['contentType']).htmlspecialchars(($rb['code']!=''?':'.$rb['code']:$rb['title']),ENT_QUOTES,'UTF-8').'</option>';
    }
    $html=preg_replace([
      '/<serviceoptions>/',
      '/<[\/]?bookservices>/'
    ],[
      $bookable,
      ''
    ],$html);
  }else
		$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
}
$html=preg_replace([
	'/<print page=[\"\']?heading[\"\']?>/',
  $page['notes']!=''?'/<print page=[\"\']?notes[\"\']?>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<[\/]?pagenotes>/',
  '/<g-recaptcha>/',
	'/<print currentdate>/',
	'/<itemreadonly>/'
],[
	htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
	$page['notes'],
  '',
  $config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''&&stristr($html,'g-recaptcha')?'<div class="g-recaptcha" data-sitekey="'.$config['reCaptchaClient'].'"></div>':'',
	($eventDate>0?date('Y-m-d\TH:i',$eventDate):date('Y-m-d\TH:i',time())),
	($eventDate>0?'readonly':'')
],$html);
$content.=$html;
