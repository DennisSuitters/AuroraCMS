<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Link
 * @package    core/add_link.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$r=isset($_POST['r'])?filter_input(INPUT_POST,'r',FILTER_SANITIZE_NUMBER_INT):0;
$a=isset($_POST['a'])?filter_input(INPUT_POST,'a',FILTER_SANITIZE_NUMBER_INT):0;
$l=isset($_POST['l'])?filter_input(INPUT_POST,'l',FILTER_UNSAFE_RAW):'';
if($l==''){
	echo'<script>window.top.window.toastr["error"](`A Link/URL is required!`);</script>';
}
if($t==''){
	echo'<script>window.top.window.toastr["error"](`A Title is required!`);</script>';
}
if($t!=''&&$l!=''){
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`url`,`title`,`password`,`tie`,`ti`) VALUES (:rid,'link',:file,:title,:p,:tie,:ti)");
		$q->execute([
			':rid'=>$id,
			':file'=>$l,
			':title'=>$t,
			':p'=>$r,
			':tie'=>$a,
			':ti'=>time()
			]);
			$iid=$db->lastInsertId();
			$q=$db->prepare("UPDATE `".$prefix."choices` SET `ord`=:ord WHERE `id`=:id");
			$q->execute([
				':id'=>$iid,
				':ord'=>$iid+1
			]);
			echo'<script>'.
				'window.top.window.$("#links").append(`<div class="row mt-1 add-item" id="l_'.$iid.'">'.
					'<div class="form-row">'.
						'<div class="input-text border-right-0 border-bottom-0">'.
						'<label>Title:</label>'.
					'</div>'.
						'<input class="border-bottom-0 border-left-0" type="text" name="t" value="'.$t.'" placeholder="Title..." readonly>'.
					'</div>';
			if($r==1){
				echo'<div class="form-row">'.
					'<div class="input-text border-right-0 border-bottom-0">'.
						'<label>Requires Order</label>&nbsp;<input type="checkbox" name="r" checked disabled>'.
					'</div>'.
					'<div class="input-text border-right-0 border-bottom-0 border-left-0 pr-0">'.
						'<label>and&nbsp;is&nbsp;available&nbsp;for:</label>'.
					'</div>'.
					'<select class="border-bottom-0 border-left-0" id="downloada" name="a" onchange="update(\`'.$iid.'\`,\`choices\`,\`tie\`,$(this).val(),\`select\`);">'.
						'<option value="0"'.($a==0?' selected':'').'>Forever</option>'.
						'<option value="3600"'.($a==3600?' selected':'').'>1 Hour</option>'.
						'<option value="7200"'.($a==7200?' selected':'').'>2 Hours</option>'.
						'<option value="14400"'.($a==14400?' selected':'').'>4 Hours</option>'.
						'<option value="28800"'.($a==28800?' selected':'').'>8 Hours</option>'.
						'<option value="86400"'.($a==86400?' selected':'').'>24 Hours</option>'.
						'<option value="172800"'.($a==172800?' selected':'').'>48 Hours</option>'.
						'<option value="604800"'.($a==604800?' selected':'').'>1 Week</option>'.
						'<option value="1209600"'.($a==1209600?' selected':'').'>2 Weeks</option>'.
						'<option value="2592000"'.($a==2592000?' selected':'').'>1 Month</option>'.
						'<option value="7776000"'.($a==7776000?' selected':'').'>3 Months</option>'.
						'<option value="15552000"'.($a==15552000?' selected':'').'>6 Months</option>'.
						'<option value="31536000"'.($a==31536000?' selected':'').'>1 Year</option>'.
    			'</select>'.
				'</div>';
			}
			echo'<div class="form-row">'.
				'<div class="input-text col-sm">'.
					'<a target="_blank" href="'.$l.'">'.$l.'</a>'.
				'</div>'.
	  		'<form target="sp" action="core/purge.php">'.
    			'<input name="id" type="hidden" value="'.$iid.'">'.
    			'<input name="t" type="hidden" value="choices">'.
    			'<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
  			'</form>'.
			'</div>`);</script>';
}
