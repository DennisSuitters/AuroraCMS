<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Career
 * @package    core/add_career.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
include'sanitise.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$code=filter_input(INPUT_POST,'code',FILTER_UNSAFE_RAW);
$title=filter_input(INPUT_POST,'title',FILTER_UNSAFE_RAW);
$method=filter_input(INPUT_POST,'method',FILTER_SANITIZE_NUMBER_INT);
$value=filter_input(INPUT_POST,'value',FILTER_SANITIZE_NUMBER_INT);
$quantity=filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_NUMBER_INT);
$tis=filter_input(INPUT_POST,'tisx',FILTER_UNSAFE_RAW);
$tie=filter_input(INPUT_POST,'tiex',FILTER_UNSAFE_RAW);
if($code!=''&&$title!=''&&$value!=0&&$quantity!=0){
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."rewards` (`code`,`title`,`method`,`value`,`quantity`,`tis`,`tie`,`ti`) VALUES (:code,:title,:method,:value,:quantity,:tis,:tie,:ti)");
	$q->execute([
		':code'=>$code,
		':title'=>$title,
		':method'=>$method,
		':value'=>$value,
		':quantity'=>$quantity,
		':tis'=>$tis,
		':tie'=>$tie,
		':ti'=>$ti
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
		echo'<script>'.
					'window.top.window.$("#rewards").append(`<tr id="l_'.$id.'">'.
						'<td class="small text-center">'.$code.'</td>'.
						'<td class="small text-center">'.$title.'</td>'.
						'<td class="small text-center">'.($method==0?'% Off':'$ Off').'</td>'.
						'<td class="small text-center">'.$value.'</td>'.
						'<td class="small text-center">'.$quantity.'</td>'.
						'<td class="small text-center">'.($tis!=0?date($config['dateFormat'],$tis):'').'</td>'.
						'<td class="small text-center">'.($tie!=0?date($config['dateFormat'],$tie):'').'</td>'.
						'<td>'.
							'<form target="sp" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$id.'">'.
								'<input name="t" type="hidden" value="rewards">'.
								'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
							'</form>'.
						'</td>'.
					'</tr>`);'.
				'</script>';
	}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Reward!");</script>';
}else echo'<script>window.top.window.toastr["error"]("Some required fields are empty!");</script>';
