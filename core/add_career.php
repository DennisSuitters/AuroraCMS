<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Career
 * @package    core/add_career.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$title=isset($_POST['title'])?filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'title',FILTER_SANITIZE_STRING);
$business=isset($_POST['business'])?filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'business',FILTER_SANITIZE_STRING);
$tis=isset($_POST['tisx'])?filter_input(INPUT_POST,'tisx',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'tisx',FILTER_SANITIZE_STRING);
$tie=isset($_POST['tiex'])?filter_input(INPUT_POST,'tiex',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'tiex',FILTER_SANITIZE_STRING);
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$si=session_id();
$ti=time();
$s=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`cid`,`contentType`,`title`,`business`,`notes`,`tis`,`tie`,`ti`) VALUES (:cid,'career',:title,:business,:notes,:tis,:tie,:ti)");
$s->execute([
  ':cid'=>$id,
  ':title'=>$title,
  ':business'=>$business,
  ':notes'=>$da,
  ':tis'=>$tis,
  ':tie'=>$tie,
  ':ti'=>$ti
]);
$id=$db->lastInsertId();
echo'<script>'.
			'window.top.window.$("#careers").append(`<div id="l_'.$id.'">'.
				'<div class="row">'.
					'<div class="col-12 col-md-3 pr-md-1">'.
						'<label>Career Title</label>'.
						'<div class="form-row">'.
							'<div class="form-text">'.$title.'</div>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-3 pr-md-1">'.
						'<label>Career Business</label>'.
						'<div class="form-row">'.
							'<div class="form-text">'.$business.'</div>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-3 pr-md-1">'.
						'<label>Start Date</label>'.
						'<div class="form-row">'.
							'<div class="form-text">'.
								($tis==0?'Current':date('Y-M',$tis)).
							'</div>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-3">'.
						'<label>End Date</label>'.
						'<div class="form-row">'.
							'<div class="form-text">'.
								($tie==0?'Current':date('Y-M',$tie)).
							'</div>'.
						'</div>'.
					'</div>'.
				'</div>'.
				'<div class="row mt-3">'.
					'<label>Career Notes</label>'.
					'<div class="col-12 col-md-11">'.
						'<div class="form-row">'.
							'<div class="form-text">'.$da.'</div>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-md-1">'.
						'<button class="btn-block trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$id.'`,`content`);">'.svg2('trash').'</button>'.
					'</div>'.
					'<hr>'.
				'</div>'.
			'</div>`);'.
		'</script>';
