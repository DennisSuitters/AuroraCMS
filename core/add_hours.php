<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Category Option
 * @package    core/add_hours.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$from=filter_input(INPUT_POST,'from',FILTER_UNSAFE_RAW);
$to=filter_input(INPUT_POST,'to',FILTER_UNSAFE_RAW);
$timefrom=filter_input(INPUT_POST,'timefrom',FILTER_SANITIZE_NUMBER_INT);
$timeto=filter_input(INPUT_POST,'timeto',FILTER_SANITIZE_NUMBER_INT);
$info=filter_input(INPUT_POST,'info',FILTER_UNSAFE_RAW);
$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`uid`,`contentType`,`username`,`password`,`tis`,`tie`,`title`) VALUES (0,'hours',:f,:t,:tis,:tie,:info)");
$q->execute([
	':f'=>$from,
	':t'=>$to,
	':tis'=>$timefrom,
	':tie'=>$timeto,
	':info'=>$info
]);
$id=$db->lastInsertId();
echo'<script>'.
  		'window.top.window.$("#hours").append(`<div id="l_'.$id.'" class="row item mt-1">'.
				'<div class="col-12 col-md-2">'.
					'<div class="form-row">'.
						'<input type="text" value="'.ucfirst($from).'" readonly>'.
					'</div>'.
				'</div>'.
				'<div class="col-12 col-md-2">'.
					'<div class="form-row">'.
						'<input type="text" value="'.ucfirst($to).'" readonly>'.
					'</div>'.
				'</div>'.
				'<div class="col-12 col-md-2">'.
					'<div class="form-row">'.
						'<input type="text" value="'.$timefrom.'" readonly>'.
					'</div>'.
				'</div>'.
				'<div class="col-12 col-md-2">'.
					'<div class="input-group-prepend">'.
						'<input type="text" value="'.$timeto.'" readonly>'.
					'</div>'.
				'</div>'.
				'<div class="col-12 col-md-3">'.
					'<div class="form-row">'.
						'<input type="text" value="'.$info.'" readonly>'.
					'</div>'.
				'</div>'.
				'<div class="input-group col-12 col-md-1">'.
					'<div class="form-row">'.
						'<form target="sp" action="core/purge.php">'.
							'<input name="id" type="hidden" value="'.$id.'">'.
							'<input name="t" type="hidden" value="choices">'.
							'<button class="purge trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>&nbsp;&nbsp;<i class="i handle">drag</i>'.
						'</form>'.
					'</div>'.
				'</div>'.
			'</div>`);'.
			'$("#hours").sortable({'.
				'items:"div.item",'.
				'handle:".handle",'.
				'placeholder:".ghost",'.
				'helper:fixWidthHelper,'.
				'axis:"y",'.
				'update:function(e,ui){'.
					'var order=$("#hours").sortable("serialize");'.
					'$.ajax({'.
						'type:"POST",'.
						'dataType:"json",'.
						'url:"core/reorderhours.php",'.
						'data:order'.
					'});'.
				'}'.
			'}).disableSelection();'.
			'function fixWidthHelper(e,ui){'.
				'ui.children().each(function(){'.
					'$(this).width($(this).width());'.
				'});'.
				'return ui;'.
			'}'.
		'</script>';
