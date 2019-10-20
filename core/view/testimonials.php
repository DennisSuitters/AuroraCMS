<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Bookings
 * @package    core/view/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Add Page Editing.
 */
if(stristr($html,'<settings')){
	preg_match('/<settings items="(.*?)">/',$html,$matches);
	$count=$matches[1];
}else$count=4;
$html=preg_replace([
	'~<settings.*?>~is'
],[
	''
],$html);
if($page['notes']!=''){
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<\/?pagenotes>/'
	],[
		(isset($_SESSION['rank'])&&$_SESSION['rank']>899?
		'<form id="note-form" target="sp" enctype="multipart/form-data" method="post" action="core/update.php">'.
			'<input type="hidden" name="id" value="'.$page['id'].'">'.
			'<input type="hidden" name="t" value="menu">'.
			'<input type="hidden" name="c" value="notes">'.
			'<textarea class="editable" name="da">'.rawurldecode($page['notes']).'</textarea>'.
		'</form>':rawurldecode($page['notes'])),
		''
	],$html);
}else
	$html=preg_replace('~<pagenotes>.*?<\/pagenotes>~is','',$html,1);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s=$db->query("SELECT * FROM `".$prefix."content` WHERE contentType='testimonials' AND status='published' ORDER BY ti DESC");
$i=0;
$items=$testitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		$items=$i==0?preg_replace('/<print content=[\"\']?active[\"\']?>/',' active', $items):preg_replace('/<print content=[\"\']?active[\"\']?>/','',$items);
		$items=preg_replace([
			'/<print content=[\"\']?schemaType[\"\']?>/',
			'/<print config=[\"\']?title[\"\']?>/',
			'/<print datePub>/'
		],[
			$r['schemaType'],
			htmlspecialchars($config['seoTitle'],ENT_QUOTES,'UTF-8'),
			date('Y-d-m',$r['ti'])
		],$items);
		if(preg_match('/<print content=[\"\']?avatar[\"\']?>/',$items)){
			if($r['cid']!=0){
				$su=$db->prepare("SELECT avatar,gravatar FROM `".$prefix."login` WHERE id=:id");
				$su->execute([':id'=>$r['cid']]);
				$ru=$su->fetch(PDO::FETCH_ASSOC);
				if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media'.DS.'avatar'.DS.$ru['avatar'],$items);
				elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media'.DS.'avatar'.DS.basename($r['file']),$items);
				elseif(stristr($ru['gravatar'],'@'))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','http://gravatar.com/avatar/'.md5($ru['gravatar']),$items);
				elseif(stristr($ru['gravatar'],'gravatar.com'))
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$ru['gravatar'],$items);
				else
					$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
			}elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/','media'.DS.'avatar'.DS.basename($r['file']),$items);
			elseif($r['file']!='')
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$r['file'],$items);
			else
				$items=preg_replace('/<print content=[\"\']?avatar[\"\']?>/',$noavatar,$items);
		}
		$jsonld='';
		if(stristr($items,'<json-ld-testimonial>')){
			$jsonld='<script type="application/ld+json">{'.
				'"@context":"https://schema.org/",'.
				'"@type":"Review",'.
				'"itemReviewed":{'.
			    '"@type":"localBusiness",'.
			    '"image":"'.URL.THEME.'/images/logo.png'.'",'.
			    '"name":"'.htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8').'",'.
			    '"telephone":"'.($config['phone']!=''?htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'):htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')).'",'.
					'"address":{'.
						'"@type":"PostalAddress",'.
						'"streetAddress":"'.htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8').'",'.
						'"addressLocality":"'.htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8').'",'.
						'"addressRegion":"'.htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8').'",'.
						'"postalCode":"'.htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8').'",'.
						'"addressCountry":"'.htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8').'"'.
					'}'.
			  '},'.
  			'"author":"'.($r['name']!=''?htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'):'Anonymous').($r['name']!=''&&$r['business']!=''?' : ':'').($r['business']!=''?htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8'):'').'",'.
  			'"datePublished":"'.date('Y-m-d',$r['ti']).'",'.
  			'"reviewBody":"'.htmlspecialchars(strip_tags(rawurldecode($r['notes'])),ENT_QUOTES,'UTF-8').'",'.
  			'"reviewRating":{'.
    			'"@type":"Rating",'.
    			'"bestRating":"5",'.
    			'"ratingValue":"5",'.
    			'"worstRating":"1"'.
  			'}'.
			'}</script>';
		}
		$items=preg_replace([
			'/<print content=[\"\']?notes[\"\']?>/',
			'/<print content=[\"\']?business[\"\']?>/',
			'/<print content=[\"\']?name[\"\']?>/',
			'/<json-ld-testimonial>/'
		],[
			($view=='index'?substr(strip_tags(rawurldecode($r['notes'])),0,600):strip_tags(rawurldecode($r['notes']))),
			$r['business']!=''?htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8'):'Anonymous',
			$r['name']!=''?htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'):'Anonymous',
			$jsonld
		],$items);
		$testitems.=$items;
		$i++;
	}
}
if($i>0){
	$html=str_replace([
		'<controls>',
		'</controls>'
	],'',$html);
}else
	$html=preg_replace('~<controls>.*?<\/controls>~is','',$html,1);
$html=preg_replace('~<items>.*?<\/items>~is',$testitems,$html,1);
$s=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
$s->execute();
if($s->rowCount()>0){
	$html=preg_replace([
		'~<subjectText>.*?<\/subjectText>~is',
		'/<subjectSelect>/',
		'/<\/subjectSelect>/'
	],'',$html);
	$options='';
	while($r=$s->fetch(PDO::FETCH_ASSOC))
		$options.='<option value="'.$r['id'].'">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</option>';
	$html=str_replace('<subjectOptions>',$options,$html);
}else{
	$html=preg_replace([
		'~<subjectSelect>.*?<\/subjectSelect>~is',
		'/<subjectText>/',
		'/<\/subjectText>/'
	],'',$html);
}
$content.=$html;
