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
if($page['notes']!=''){
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<\/?pagenotes>/',
		'/<print currentdate>/'
	],[
		(isset($_SESSION['rank'])&&$_SESSION['rank']>899?
		'<form id="note-form" target="sp" enctype="multipart/form-data" method="post" action="core/update.php">'.
			'<input type="hidden" name="id" value="'.$page['id'].'">'.
			'<input type="hidden" name="t" value="menu">'.
			'<input type="hidden" name="c" value="notes">'.
			'<textarea class="editable" name="da">'.rawurldecode($page['notes']).'</textarea>'.
		'</form>':rawurldecode($page['notes'])),
		'',
		date('Y-m-d',time())
	],$html);
}else
	$html=preg_replace('~<pagenotes>.*?<\/pagenotes>~is','',$html,1);
$sql=$db->query("SELECT * FROM `".$prefix."content` WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
if($sql->rowCount()>0){
	$bookable='';
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$bookable.='<option value="'.$row['id'].'"'.($row['id']==$args[0]?' selected':'').'>'.ucfirst(htmlspecialchars($row['contentType'],ENT_QUOTES,'UTF-8')).($row['code']!=''?':'.htmlspecialchars($row['code'],ENT_QUOTES,'UTF-8'):'').':'.htmlspecialchars($row['title'],ENT_QUOTES,'UTF-8').'</option>';
	}
	$html=preg_replace([
		'/<serviceoptions>/',
		'/<bookservices>/',
		'/<\/bookservices>/'
	],[
		$bookable,
		'',
		''
	],$html);
}else$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
$content.=$html;
