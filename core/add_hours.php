<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Category Option
 * @package    core/add_hours.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$from=filter_input(INPUT_POST,'from',FILTER_SANITIZE_STRING);
$to=filter_input(INPUT_POST,'to',FILTER_SANITIZE_STRING);
$timefrom=filter_input(INPUT_POST,'timefrom',FILTER_SANITIZE_NUMBER_INT);
$timeto=filter_input(INPUT_POST,'timeto',FILTER_SANITIZE_NUMBER_INT);
$info=filter_input(INPUT_POST,'info',FILTER_SANITIZE_STRING);
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
							'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete">'.svg2('trash').'</button>&nbsp;&nbsp;'.svg2('drag','handle').
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
