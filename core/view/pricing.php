<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Pricing
 * @package    core/view/pricing.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 *
 */
$html=preg_replace([
 '/<print page=[\"\']?heading[\"\']?>/',
 '/<print page=[\"\']?notes[\"\']?>/',
 $page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is'
],[
 htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
 $page['notes'],
 ''
],$html);
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$match);
  $items=$match[1];
  $output='';
  $sp=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `price`='1' AND `status`='published' ORDER BY `priceord` ASC");
  $sp->execute();
  while($rp=$sp->fetch(PDO::FETCH_ASSOC)){
    $spl=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='price' AND `rid`=:rid ORDER BY `ord` ASC");
    $spl->execute([':rid'=>$rp['id']]);
    $list=$highlight='';
    if($spl->rowCount()>0){
      $list.='<ul>';
      while($rpl=$spl->fetch(PDO::FETCH_ASSOC)){
        $list.='<li>'.$rpl['title'].'</li>';
      }
      $list.='</ul>';
    }
    if($rp['highlighttext']!='')$highlight=$rp['highlighttext'];
    $cost=0;
    if($rp['cost']!=0)$cost=$rp['cost'];
    if($rp['rCost']!=0)$cost=$rp['rCost'];
    if(isset($user)&&$user['options'][19]==1){
      if($rp['dCost']!=0)$cost=$rp['dCost'];
    }
    $out=preg_replace([
      '/<print content=[\"\']?id[\"\']?>/',
      '/<highlight>/',
      ($rp['thumb']!=''||$rp['file']!=''?'/<print content=[\"\']?image[\"\']?>/':'~<figure.*?>.*?</figure>~is'),
      '/<print content=[\"\']?title[\"\']?>/',
      '/<print content=[\"\']?cost[\"\']?>/',
      '/<print content=[\"\']?list[\"\']?>/',
      '/<print content=[\"\']?link[\"\']?>/'
    ],[
      $rp['id'],
      ($rp['highlight']==1?' border-1 border-success"  data-highlight="'.$highlight.'':' mx-3'),
      ($rp['thumb']!=''||$rp['thumb']!=''?($rp['thumb']!=''?$rp['thumb']:$rp['file']):''),
      $rp['title'],
      ($cost==0?'FREE':'&dollar;'.floatval($cost)),
      $list,
      URL.$rp['contentType'].'/'.strtolower(str_replace(' ','-',$rp['title']))
    ],$items);
    $output.=$out;
  }
  $html=preg_replace('~<items>.*?<\/items>~is',$output,$html);
}
$content.=$html;
