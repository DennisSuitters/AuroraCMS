<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Sale
 * @package    core/view/sale.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sIs='';
$saleClass='';
if(stristr($html,'<saleItems')&&$config['options'][28]==1){
	if(stristr($html,'<settings')){
		preg_match('/<settings.*itemCount=[\"\'](.+?)[\"\'].*>/',$html,$matches);
		$count=isset($matches[1])&&$matches[1]!=0?$matches[1]:$config['showItems'];
	}else
		$count=$config['showItems'];
  preg_match('/<saleItems>([\w\W]*?)<\/saleItems>/',$html,$matches);
  $item=$matches[1];
	$ssa=$db->prepare("SELECT `code`,`type`,`title`,`tis`,`tie` FROM `".$prefix."choices` WHERE `contentType`='sales' AND :ti BETWEEN `tis` AND `tie`");
	$ssa->execute([
		':ti'=>time()
	]);
	if($ssa->rowCount()>0){
		$rsa=$ssa->fetch(PDO::FETCH_ASSOC);
		$html=preg_replace([
			'/<[\/]?salePeriod>/',
			'~<settings.*?>~is',
			'/<print saleHeading>/',
			'/<print sale>/'
		],[
			'',
			'',
			$config['saleHeading'],
			$rsa['type']
		],$html);
		$saleClass.=' '.$rsa['type'];
		$ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='inventory' AND `sale`=:sale AND `rank`<=:rank AND `status`='published'");
		$ss->execute([
			':sale'=>$rsa['code'],
			':rank'=>isset($_SESSION['rank'])?$_SESSION['rank']:0
		]);
		if($ss->rowCount()>0){
			$out='';
  		while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
    		$items=$item;
				if($config['gst']>0){
	    		$gst=$rs['cost']*($config['gst']/100);
	    		$gst=$rs['cost']+$gst;
	    		$rs['cost']=number_format((float)$gst,2,'.','');
	    		$gst=$rs['rCost']*($config['gst']/100);
	    		$gst=$rs['rCost']+$gst;
	    		$rs['rCost']=number_format((float)$gst,2,'.','');
	  		}
    		$items=preg_replace([
					'/<json-ld>/',
					$config['options'][5]==1?'/<[\/]?quickview>/':'~<quickview>.*?<\/quickview>~is',
					'/<print content=[\"\']?id[\"\']?>/',
					'/<print content=[\"\']?thumb[\"\']?>/',
					'/<print content=[\"\']?imageALT[\"\']?>/',
      		'/<print content=[\"\']?linktitle[\"\']?>/',
      		'/<print content=[\"\']?title[\"\']?>/',
					'/<print content=[\"\']?cost[\"\']?>/',
      		'/<print content=[\"\']?notes[\"\']?>/'
    		],[
					'<script type="application/ld+json">{'.
						'"@context":"http://schema.org/",'.
						'"@type":"Product",'.
        		'"name":"'.$rs['title'].'",'.
        		'"image":{'.
          		'"@type":"ImageObject",'.
          		'"url":"'.($rs['file']!=''&&file_exists('media/'.basename($rs['file']))?'media/'.basename($rs['file']):FAVICON).'"'.
        		'},'.
        		'"description":"'.($seoDescription!=''?$seoDescription:strip_tags(escaper($rs['notes']))).'",'.
        		'"mpn":"'.($rs['barcode']==''?$rs['id']:$rs['barcode']).'",'.
        		'"sku":"'.($rs['fccid']==''?$rs['id']:$rs['fccid']).'",'.
        		'"brand":"'.($rs['brand']!=''?$rs['brand']:$config['business']).'",'.
						'"offers":{'.
							'"@type":"Offer",'.
							'"url":"'.URL.$view.'/'.$rs['urlSlug'].'/'.'",'.
							(is_numeric($rs['cost'])||is_numeric($rs['rCost'])?
							'"priceCurrency":"AUD",'.
							'"price":"'.($rs['rCost']!=0?$rs['rCost']:($rs['cost']==''?0:$rs['cost'])).'",'.
							'"priceValidUntil":"'.date('Y-m-d',strtotime('+6 month',time())).'",':'').
							'"availability":"'.($rs['stockStatus']=='quantity'?($rs['quantity']==0?'http://schema.org/OutOfStock':'http://schema.org/InStock'):($rs['stockStatus']=='none'?'http://schema.org/OutOfStock':'http://schema.org/'.str_replace(' ','',ucwords($rs['stockStatus'])))).'",'.
							'"seller":{'.
								'"@type":"Organization",'.
								'"name":"'.$config['business'].'"'.
							'}'.
						'}'.
					'}</script>',
					'',
					$rs['id'],
      		$rs['thumb']!=''?$rs['thumb']:NOIMAGESM,
      		$rs['fileALT']==''?$rs['title']:$rs['fileALT'],
      		URL.$rs['contentType'].'/'.$rs['urlSlug'].'/',
      		htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
					$rs['rCost']!=0?'&dollar;'.$rs['rCost']:($rs['cost']!=''&&$rs['cost']!=0?'&dollar;'.$rs['cost']:''),
					$rs['notes'],
    		],$items);
  			$out.=$items;
  		}
		}
		$sIs=preg_replace('~<saleItems>.*?<\/saleItems>~is',$out,$html,1);
	}else
		$html=preg_replace('~<salePeriod>.*?<\/salePeriod>~is','',$html,1);
	$content.=$sIs;
}
