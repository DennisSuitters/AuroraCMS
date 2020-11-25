<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - quickview.php
 * @package    core/quickview.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
define('UNICODE','UTF-8');
$getcfg=true;
require'db.php';
if(isset($_GET['theme'])&&file_exists('layout'.DS.$_GET['theme']))
$config['theme']=$_GET['theme'];
define('THEME','layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
if(file_exists('..'.DS.THEME.DS.'images'.DS.'noimage.png'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.png');
elseif(file_exists('..'.DS.THEME.DS.'images'.DS.'noimage.gif'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.gif');
elseif(file_exists('..'.DS.THEME.DS.'images'.DS.'noimage.jpg'))
	define('NOIMAGE',THEME.DS.'images'.DS.'noimage.jpg');
else
	define('NOIMAGE','core'.DS.'images'.DS.'noimage.jpg');
$id=isset($_GET['id'])?$_GET['id']:'';
if(file_exists('..'.DS.THEME.DS.'quickview.html')){
  $html=file_get_contents('..'.DS.THEME.DS.'quickview.html');
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
  $s->execute([
		':id'=>$id
	]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    if(stristr($html,'<quickviewthumbs>')){
      preg_match('/<quickviewthumbs>([\w\W]*?)<\/quickviewthumbs>/',$html,$matches);
      $thumbsitem=$matches[1];
      $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `rid`=:id ORDER BY `ord` ASC");
      $sm->execute([
				':id'=>$r['id']
			]);
      $thumbsitems=$item='';
      if($sm->rowCount()>0){
        while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
          $item=$thumbsitem;
          $item=preg_replace([
            '/<print thumbs=[\"\']?thumb[\"\']?>/',
            '/<print thumbs=[\"\']?image[\"\']?>/',
            '/<print thumbs=[\"\']?imageALT[\"\']?>/'
          ],[
            $rm['file'],
            $rm['file'],
            $rm['fileALT']
          ],$item);
          $thumbsitems.=$item;
        }
        $html=preg_replace([
					'/<[\/]?quickviewallthumbs>/',
					'~<quickviewthumbs>.*?<\/quickviewthumbs>~is'
				],[
					'',
					$thumbsitems
				],$html);
      }else
        $html=preg_replace('~<quickviewallthumbs>.*?<\/quickviewallthumbs>~is','',$html);
    }else
			$html=preg_replace('~<quickviewallthumbs>.*?<\/quickviewallthumbs>~is','',$html);
    if($r['file']=='')$r['file']=NOIMAGE;
    $sideCost='';
		if($r['options'][0]==1){
			if($r['stockStatus']=='sold out')
				$sideCost.='<div class="sold">';
			$sideCost.=($r['rrp']!=0?'<span class="rrp">RRP &#36;'.$r['rrp'].'</span>':'');
			$sideCost.=(is_numeric($r['cost'])&&$r['cost']!=0?'<span class="cost'.($r['rCost']!=0?' strike':'').'">'.(is_numeric($r['cost'])?'&#36;':'').htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>'.($r['rCost']!=0?'<span class="reduced">&#36;'.$r['rCost'].'</span>':''):'<span>'.htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>');
			if($r['stockStatus']=='sold out')
				$sideCost.='</div>';
		}
    if($r['stockStatus']=='out of stock')$r['quantity']=0;
    if($r['stockStatus']=='pre-order')$r['quantity']=0;
		$choices='';
		if(stristr($html,'<choices>')&&$r['stockStatus']=='quantity'||$r['stockStatus']=='in stock'||$r['stockStatus']=='pre-order'||$r['stockStatus']=='available'){
			$scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:id ORDER BY `title` ASC");
			$scq->execute([
				':id'=>$r['id']
			]);
			if($scq->rowCount()>0){
				$choices='<select class="choices" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
				while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
					if($rcq['ti']==0)continue;
					$choices.='<option value="'.$rcq['id'].'">'.$rcq['title'].':'.$rcq['ti'].'</option>';
				}
				$choices.='</select>';
				$html=str_replace('<choices>',$choices,$html);
			}else
				$html=str_replace('<choices>','',$html);
		}else
			$html=preg_replace('<choices>','',$html);
		if($r['brand']!=0){
    	$sb=$db->prepare("SELECT `id`,`title`,`url`,`icon` FROM `".$prefix."choices` WHERE `contentType`='brand' AND `id`=:id");
    	$sb->execute([
				':id'=>$r['brand']
			]);
    	$rb=$sb->fetch(PDO::FETCH_ASSOC);
    	$brand=($rb['url']!=''?'<a href="'.$rb['url'].'">':'').($rb['icon']==''?$rb['title']:'<img src="'.$rb['icon'].'" alt="'.$rb['title'].'" title="'.$rb['title'].'">').($rb['url']!=''?'</a>':'');
		}else
			$brand='';
    $html=preg_replace([
      '/<print content=[\"\']?image[\"\']?>/',
			'/<print content=[\"\']?imageALT[\"\']?>/',
      '/<print content=[\"\']?id[\"\']?>/',
      '/<print content=[\"\']?quantity[\"\']?>/',
      '/<print content=[\"\']?stockStatus[\"\']?>/',
      '/<print content=[\"\']?cost[\"\']?>/',
			'/<choices>/',
      $r['itemCondition']==''?'~<condition>.*?<\/condition>~is':'/<[\/]?condition>/',
			'/<print content=[\"\']?condition[\"\']?>/',
			$r['weight']==''?'~<weight>.*?<\/weight>~is':'/<[\/]?weight>/',
      '/<print content=[\"\']?weight[\"\']?>/',
			$r['width']==''&&$r['height']==''&&$r['length']==''?'~<size>.*?<\/size>~is':'/<[\/]?size>/',
      '/<print content=[\"\']?width[\"\']?>/',
      '/<print content=[\"\']?height[\"\']?>/',
      '/<print content=[\"\']?length[\"\']?>/',
			$r['brand']==0?'~<brand>.*?<\/brand>~is':'/<[\/]?brand>/',
      '/<print brand>/',
      '/<print content=[\"\']?title[\"\']?>/',
      '/<print content=[\"\']?notes[\"\']?>/',
			'/<print URLENCODED_URL>/'
    ],[
      $r['file'],
			$r['fileALT'],
      $r['id'],
      ($r['stockStatus']=='quantity'?($r['quantity']>0?'in stock':'out of stock'):($r['stockStatus']=='none'?'':$r['stockStatus'])),
      $r['stockStatus']=='quantity'?($r['quantity']==0?'out of stock':'in stock'):($r['stockStatus']=='none'?'':$r['stockStatus']),
      $sideCost,
			$choices,
			'',
      ucfirst($r['itemCondition']),
			'',
      $r['weight'].$r['weightunit'],
			'',
      $r['width']!=''?$r['width'].$r['widthunit']:'',
      $r['height']!=''?$r['height'].$r['heightunit']:'',
      $r['length']!=''?$r['length'].$r['lengthunit']:'',
			'',
      $brand,
      $r['title'],
      $r['notes'],
			urlencode(URL.$r['contentType'].'/'.$r['urlSlug'])
    ],$html);
    print $html;
  }else
    echo 'There was an issue finding the content!';
}else
  echo 'Quick View template does not exist!';
