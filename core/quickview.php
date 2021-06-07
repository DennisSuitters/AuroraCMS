<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - quickview.php
 * @package    core/quickview.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Fix GST Calculation.
 */
define('UNICODE','UTF-8');
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if(isset($_GET['theme'])&&file_exists('layout/'.$_GET['theme']))$config['theme']=$_GET['theme'];
define('THEME','layout/'.$config['theme']);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
if(file_exists('../'.THEME.'/images/noimage.png'))define('NOIMAGE',THEME.'/images/noimage.png');
elseif(file_exists('../'.THEME.'/images/noimage.gif'))define('NOIMAGE',THEME.'/images/noimage.gif');
elseif(file_exists('../'.THEME.'/images/noimage.jpg'))define('NOIMAGE',THEME.'/images/noimage.jpg');
else define('NOIMAGE','core/images/noimage.jpg');
$id=isset($_GET['id'])?$_GET['id']:'';
if(file_exists('../'.THEME.'/quickview.html')){
  $html=file_get_contents('../'.THEME.'/quickview.html');
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    if($config['gst']>0){
      $gst=$r['cost']*($config['gst']/100);
      $r['cost']=$r['cost']+$gst;
      $r['cost']=number_format((float)$r['cost'],2,'.','');
      $gst=$r['rCost']*($config['gst']/100);
      $r['rCost']=$r['rCost']+$gst;
      $r['rCost']=number_format((float)$r['rCost'],2,'.','');
    }
    if(stristr($html,'<quickviewthumbs>')){
      preg_match('/<quickviewthumbs>([\w\W]*?)<\/quickviewthumbs>/',$html,$matches);
      $thumbsitem=$matches[1];
      $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `rid`=:id ORDER BY `ord` ASC");
      $sm->execute([':id'=>$r['id']]);
      $thumbsitems=$item='';
      if($sm->rowCount()>0){
				$html=preg_replace([
					'/<print quickviewwidth>/',
					'/<print empty>/'
				],[
					' col-sm-8',
					'col-12 col-sm m-0 p-3'
				],$html);
        while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
					if(basename($r['file'])==basename($rm['file']))continue;
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
      }else{
        $html=preg_replace([
					'~<quickviewallthumbs>.*?<\/quickviewallthumbs>~is',
					'/<print quickviewwidth>/',
					'/<print empty>/'
				],[
					'',
					' col-sm-6',
					' d-none'
				],$html);
			}
    }else$html=preg_replace('~<quickviewallthumbs>.*?<\/quickviewallthumbs>~is','',$html);
    if($r['file']=='')$r['file']=NOIMAGE;
    $sideCost='';
		if($r['options'][0]==1){
			if($r['coming'][0]==1)$sideCost.='<div class="sold">Coming Soon</div>';
			else{
				if($r['stockStatus']=='sold out')$sideCost.='<div class="sold">';
				$sideCost.=($r['rrp']!=0?'<span class="rrp">RRP &#36;'.$r['rrp'].'</span>':'');
				$sideCost.=(is_numeric($r['cost'])&&$r['cost']!=0?'<span class="cost'.($r['rCost']!=0?' strike':'').'">'.(is_numeric($r['cost'])?'&#36;':'').htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>'.($r['rCost']!=0?'<span class="reduced">&#36;'.$r['rCost'].'</span>':''):'<span>'.htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>');
				if($r['stockStatus']=='sold out')$sideCost.='</div>';
			}
		}
    if($r['stockStatus']=='out of stock'||$r['stockStatus']=='pre-order')$r['quantity']=0;
		$choices='';
		if(stristr($html,'<choices>')&&$r['stockStatus']=='quantity'||$r['stockStatus']=='in stock'||$r['stockStatus']=='pre-order'||$r['stockStatus']=='available'){
			$scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:id ORDER BY `title` ASC");
			$scq->execute([':id'=>$r['id']]);
			if($scq->rowCount()>0){
				$choices='<select class="choices" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
				while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
					if($rcq['ti']==0)continue;
					$choices.='<option value="'.$rcq['id'].'">'.$rcq['title'].':'.$rcq['ti'].'</option>';
				}
				$choices.='</select>';
				$html=str_replace('<choices>',$choices,$html);
			}else$html=str_replace('<choices>','',$html);
		}else$html=preg_replace('<choices>','',$html);
		if($r['brand']!=0){
    	$sb=$db->prepare("SELECT `id`,`title`,`url`,`icon` FROM `".$prefix."choices` WHERE `contentType`='brand' AND `id`=:id");
    	$sb->execute([':id'=>$r['brand']]);
    	$rb=$sb->fetch(PDO::FETCH_ASSOC);
    	$brand=($rb['url']!=''?'<a href="'.$rb['url'].'">':'').($rb['icon']==''?$rb['title']:'<img src="'.$rb['icon'].'" alt="'.$rb['title'].'" title="'.$rb['title'].'">').($rb['url']!=''?'</a>':'');
		}else$brand='';
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
			'/<print URLENCODED_URL>/',
			($r['coming'][0]==1?'~<addToCart>.*?<\/addToCart>~is':'/<[\/]?addTocart>/')
    ],[
      $r['file'],
			$r['fileALT'],
      $r['id'],
      ($r['coming'][0]!=1?($r['stockStatus']=='quantity'?($r['quantity']>0?'in stock':'out of stock'):($r['stockStatus']=='none'?'':$r['stockStatus'])):''),
      ($r['coming'][0]!=1?($r['stockStatus']=='quantity'?($r['quantity']==0?'out of stock':'in stock'):($r['stockStatus']=='none'?'':$r['stockStatus'])):''),
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
			urlencode(URL.$r['contentType'].'/'.$r['urlSlug']),
			''
    ],$html);
    print $html;
  }else echo'There was an issue finding the content!';
}else echo'Quick View template does not exist!';
