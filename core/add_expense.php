<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Expense
 * @package    core/add_expense.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$code=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):'';
$brand=isset($_POST['b'])?filter_input(INPUT_POST,'b',FILTER_UNSAFE_RAW):'';
$title=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$cost=isset($_POST['cost'])?filter_input(INPUT_POST,'cost',FILTER_UNSAFE_RAW):0;
$quantity=isset($_POST['q'])?filter_input(INPUT_POST,'q',FILTER_UNSAFE_RAW):1;
if($cost==''){
	echo'<script>window.top.window.toastr["error"](`A Cost is required!`);</script>';
}
if($title==''){
	echo'<script>window.top.window.toastr["error"](`A Title is required!`);</script>';
}
if($title!=''&&$cost!=''){
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`code`,`category`,`title`,`cost`,`quantity`,`ti`) VALUES (:rid,'expense',:code,:brand,:title,:cost,:quantity,:ti)");
		$q->execute([
			':rid'=>$rid,
			':code'=>$code,
			':brand'=>$brand,
			':title'=>$title,
			':cost'=>$cost,
			':quantity'=>$quantity,
			':ti'=>time()
			]);
			$iid=$db->lastInsertId();
			echo'<script>'.
				'window.top.window.$("#expenses").append(`<article id="l_'.$iid.'" class="card col-12 zebra mb-0 p-0 overflow-visible card-list item shadow" data-cost="'.$cost.'" data-total="'.((float)$cost * (float)$quantity).'">'.
					'<div class="row">'.
						'<div class="col-12 col-md-2">'.
							'<div class="input-text">'.$code.'&nbsp;</div>'.
						'</div>'.
						'<div class="col-12 col-md-2">'.
							'<div class="input-text">'.$brand.'&nbsp;</div>'.
						'</div>'.
						'<div class="col-12 col-md">'.
							'<div class="input-text">'.$title.'</div>'.
						'</div>'.
						'<div class="col-12 col-md">'.
							'<div class="input-text col-12">'.$cost.'</div>'.
						'</div>'.
						'<div class="col-12 col-md-2 text-right">'.
							'<div class="form-row">'.
								'<div class="input-text col-12">'.rtrim(rtrim($quantity,0),'.').'</div>'.
		  					'<form target="sp" action="core/purge.php">'.
	    						'<input name="id" type="hidden" value="'.$iid.'">'.
	    						'<input name="t" type="hidden" value="choices">'.
	    						'<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
	  						'</form>'.
							'</div>'.
						'</div>'.
					'</div>'.
				'</article>`);'.
				'window.top.window.toastr["success"](`'.$title.' Added!`);'.
			'</script>';
}
