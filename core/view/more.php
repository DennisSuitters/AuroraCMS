<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - More
 * @package    core/view/more.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'../db.php';
define('SESSIONID',session_id());
define('THEME','layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$contentType=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$view=isset($_POST['v'])?filter_input(INPUT_POST,'v',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'v',FILTER_SANITIZE_STRING);
$show='categories';
$i=isset($_POST['i'])?filter_input(INPUT_POST,'i',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'i',FILTER_SANITIZE_NUMBER_INT);
$html=file_exists('../../layout/'.$config['theme'].'/'.$view.'.html')?file_get_contents('../../layout/'.$config['theme'].'/'.$view.'.html'):file_get_contents('../../layout/'.$config['theme'].'/content.html');
$itemCount=$config['showItems'];
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType AND `status` LIKE :status AND `internal`!='1' AND `pti`<:ti AND `rank`<=:rank ORDER BY `ti` DESC LIMIT $i,$itemCount");
$s->execute([
  ':contentType'=>$contentType,
  ':status'=>'published',
  ':ti'=>time(),
  ':rank'=>$_SESSION['rank']
]);
if(stristr($html,'<more')){
  preg_match('/<more>([\w\W]*?)<\/more>/',$html,$matches);
  $more=$matches[1];
  $more=preg_replace([
    '/<print view>/',
    '/<print contentType>/',
    '/<print config=[\"\']?showItems[\"\']?>/',
  ],[
    $view,
    $contentType,
    $itemCount+$i
  ],$more);
}else
  $more='';
if($s->rowCount()<=$itemCount)
  $more='';
if(stristr($html,'<items>')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $item=$matches[1];
  $output='';
  $si=1;
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $items=$item;
    $contentType=$r['contentType'];
    if($si==1){
      $filechk=basename($r['file']);
      $thumbchk=basename($r['thumb']);
      if($r['file']!=''&&file_exists('media/'.$filechk))
        $shareImage=$r['file'];
      elseif($r['thumb']!=''&&file_exists('media/'.$thumbchk))
        $shareImage=$r['thumb'];
      $si++;
    }
    if(preg_match('/<print content=[\"\']?thumb[\"\']?>/',$items)){
      $r['thumb']=str_replace(URL,'',$r['thumb']);
      $items=$r['thumb']?preg_replace('/<print content=[\"\']?thumb[\"\']?>/',$r['thumb'],$items):preg_replace('/<print content=[\"\']?thumb[\"\']?>/','layout/'.$config['theme'].'/images/noimage.jpg',$items);
    }
    $items=preg_replace('/<print content=[\"\']?alttitle[\"\']?>/',$r['title'],$items);
    $r['notes']=strip_tags($r['notes']);
    if($r['contentType']=='testimonials'||$r['contentType']=='testimonial'){
      if(stristr($items,'<controls>'))
        $items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
      $controls='';
    }else{
      if(stristr($items,'<view>')){
        $items=preg_replace([
          '/<print content=[\"\']?linktitle[\"\']?>/',
          '/<print content=[\"\']?title[\"\']?>/',
          '/<[\/]?view>/'
        ],[
          URL.$r['contentType'].'/'.$r['urlSlug'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
          $r['title'],
          ''
        ],$items);
      }
      if($r['contentType']=='service'){
        if($r['bookable']==1){
          if(stristr($items,'<service>')){
            $items=preg_replace([
              '/<print content=[\"\']?bookservice[\"\']?>/',
              '/<[\/]?service>/',
              '~<inventory>.*?<\/inventory>~is'
            ],[
              URL.'bookings/'.$r['id'].'/'.(isset($_GET['theme'])?'?theme='.$_GET['theme']:''),
              '',
              ''
            ],$items);
          }
        }else
          $items=preg_replace('~<service.*?>.*?<\/service>~is','',$items,1);
      }else
        $items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
      if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
        if(stristr($items,'<inventory>')){
          $items=preg_replace([
            '/<[\/]?inventory>/',
            '~<service>.*?<\/service>~is'
          ],'',$items);
        }elseif(stristr($items,'<inventory>')&&$r['contentType']!='inventory'&&!is_numeric($r['cost']))
          $items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
      }else
        $items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
      $items=preg_replace('/<[\/]?controls>/','',$items);
    }
    require'../parser.php';
    $output.=$items;
  }
$html=$output;
}
print$html.$more;
