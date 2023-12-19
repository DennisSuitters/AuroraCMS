<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Sale Period
 * @package    core/add_saleperiod.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$p=filter_input(INPUT_POST,'p',FILTER_UNSAFE_RAW);
$c=filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW);
$tis=filter_input(INPUT_POST,'tisx',FILTER_UNSAFE_RAW);
$tie=filter_input(INPUT_POST,'tiex',FILTER_UNSAFE_RAW);
$ti=time();
if($p!=''&&$tis!=0&&$tie!=0){
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`code`,`type`,`tis`,`tie`,`ti`) VALUES (:contentType,:code,:class,:tis,:tie,:ti)");
	$q->execute([
		':contentType'=>'sales',
    ':code'=>$p,
		':class'=>$c,
		':tis'=>$tis,
		':tie'=>$tie,
		':ti'=>$ti
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
		echo'<script>'.
					'window.top.window.$("#saleperiods").append(`<div class="card zebra border-0 add-item" id="l_'.$id.'">'.
						'<div class="row">'.
            	'<div class="col-12 col-md pl-2 py-2">'.$p.'</div>'.
            	'<div class="col-12 col-md pl-2 py-2">'.$c.'</div>'.
            	'<div class="col-12 col-md pl-2 py-2">'.date($config['dateFormat'],$tis).'</div>'.
            	'<div class="col-12 col-md pl-2">'.
								'<div class="d-inline-block py-2">'.date($config['dateFormat'],$tie).'</div>'.
								'<div class="float-right">'.
              		'<form target="sp" action="core/purge.php">'.
                		'<input name="id" type="hidden" value="'.$id.'">'.
                		'<input name="t" type="hidden" value="choices">'.
                		'<button class="trash" type="submit" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
              		'</form>'.
								'</div>'.
							'</div>'.
            '</div>'.
					'</div>`);'.
				'</script>';
	}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Sale Period!");</script>';
}else echo'<script>window.top.window.toastr["error"]("Some required fields are empty!");</script>';
