<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Hold Option
 * @package    core/add_holdoption.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$loc=isset($_POST['loc'])?filter_input(INPUT_POST,'loc',FILTER_UNSAFE_RAW):'';
$pcF=isset($_POST['pcfrom'])?filter_input(INPUT_POST,'pcfrom',FILTER_SANITIZE_NUMBER_INT):0;
$pcT=isset($_POST['pcto'])?filter_input(INPUT_POST,'pcto',FILTER_SANITIZE_NUMBER_INT):0;
$tie=isset($_POST['tiex'])?filter_input(INPUT_POST,'tiex',FILTER_SANITIZE_NUMBER_INT):0;
$req=isset($_POST['req'])?filter_input(INPUT_POST,'req',FILTER_SANITIZE_NUMBER_INT):0;
$ti=time();
if($loc=='')
	echo'<script>window.top.window.toastr["error"]("The Pickup Location contain data!");</script>';
else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (
		`uid`,`contentType`,`title`,`value`,`postcodeFrom`,`postcodeTo`,`tie`,`ti`) VALUES (0,'holdoption',:loc,:value,:pcF,:pcT,:tie,:ti)");
	$q->execute([
		':loc'=>$loc,
		':value'=>$req,
		':pcF'=>$pcF,
		':pcT'=>$pcT,
		':tie'=>$tie,
		':ti'=>$ti
	]);
	$id=$db->lastInsertId();
	$s=$db->prepare("UPDATE `".$prefix."choices` SET `ord`=:id WHERE `id`=:id");
	$s->execute([':id'=>$id]);
	echo'<script>'.
	  		'window.top.window.$("#holdoptions").append(`<article id="l_'.$id.'" class="card col-12 zebra m-0 p-0 overflow-visible card-list item shadow add-item">'.
					'<div class="row">'.
						'<div class="col-12 col-md pl-2 pt-2">'.$loc.'</div>'.
						'<div class="col-12 col-md pl-2 pt-2">'.$pcF.'</div>'.
						'<div class="col-12 col-md pl-2 pt-2">'.$pcT.'</div>'.
						'<div class="col-12 col-md pl-2 pt-2">'.($req>0?$req.'% Required':'No Requirement').'</div>'.
						'<div class="col-12 col-md pl-2">'.
							'<span class="d-inline-block mt-2">'.date($config['dateFormat'],$tie).'</span>'.
							'<form class="btn-group float-right" target="sp" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$id.'">'.
								'<input name="t" type="hidden" value="choices">'.
								'<button class="purge" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
							'</form>'.
						'</div>'.
					'</div>'.
				'</article>`);'.
			'</script>';
}
