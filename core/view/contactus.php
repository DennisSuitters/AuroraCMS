<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Contact Us
 * @package    core/view/contactus.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Add Page Editing.
 */
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
if(stristr($html,'<address')){
	$html=preg_replace([
		'/<print config=[\"\']?address[\"\']?>/',
		'/<print config=[\"\']?state[\"\']?>/',
		'/<print config=[\"\']?suburb[\"\']?>/',
		'/<print config=[\"\']?country[\"\']?>/',
		'/<print config=[\"\']?postcode[\"\']?>/',
		'/<print config=[\"\']?phone[\"\']?>/',
		'/<print config=[\"\']?mobile[\"\']?>/'
	],[
		htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars(str_replace(' ','',$config['phone']),ENT_QUOTES,'UTF-8'),
		htmlspecialchars(str_replace(' ','',$config['mobile']),ENT_QUOTES,'UTF-8')
	],$html);
}
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
require'core'.DS.'parser.php';
$content.=$html;