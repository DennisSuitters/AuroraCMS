<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Category Option
 * @package    core/add_hours.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$from=filter_input(INPUT_POST,'from',FILTER_UNSAFE_RAW);
$to=filter_input(INPUT_POST,'to',FILTER_UNSAFE_RAW);
$hrF=isset($_POST['hrfrom'])?filter_input(INPUT_POST,'hrfrom',FILTER_SANITIZE_NUMBER_INT):0;
$hrT=isset($_POST['hrto'])?filter_input(INPUT_POST,'hrto',FILTER_SANITIZE_NUMBER_INT):0;
$info=filter_input(INPUT_POST,'info',FILTER_UNSAFE_RAW);
$active=isset($_POST['active'])?filter_input(INPUT_POST,'active',FILTER_SANITIZE_NUMBER_INT):0;
if($from=='')
	echo'<script>window.top.window.toastr["error"]("The From field must contain data!");</script>';
else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`uid`,`contentType`,`username`,`password`,`tis`,`tie`,`title`,`status`) VALUES (0,'hours',:f,:t,:tis,:tie,:info,:active)");
	$q->execute([
		':f'=>$from,
		':t'=>$to,
		':tis'=>$hrF,
		':tie'=>$hrT,
		':info'=>$info,
		':active'=>$active
	]);
	$id=$db->lastInsertId();
	$s=$db->prepare("UPDATE `".$prefix."choices` SET `ord`=:id WHERE `id`=:id");
	$s->execute([':id'=>$id]);
	if($hrF>0){
		$hrF=str_pad($hrF,4,'0',STR_PAD_LEFT);
		if($config['options'][21]==1)
			$hourFrom=$hrF;
		else{
			$hourFromH=substr($hrF,0,2);
			$hourFromM=substr($hrF,3,4);
			$hourFrom=($hourFromH<12?ltrim($hourFromH,'0').($hourFromM>0?$hourFromM:'').'am':$hourFromH - 12 .($hourFromM>0?$hourFromM :'').'pm');
		}
	}else
		$hourFrom=0;
	if($hrT>0){
		$hrT=str_pad($hrT,4,'0',STR_PAD_LEFT);
		if($config['options'][21]==1)
			$hourTo=$hrT;
		else{
			$hourToH=substr($hrT,0,2);
			$hourToM=substr($hrT,3,4);
			$hourTo=($hourToH<12?ltrim($hourToH,'0').($hourToM>0?$hourToM:'').'am':$hourToH - 12 .($hourToM>0?$hourToM:'').'pm');
		}
	}else
		$hourTo=0;
	echo'<script>'.
	  		'window.top.window.$("#hours").append(`<article id="l_'.$id.'" class="card col-12 zebra mb-0 p-0 overflow-visible card-list item shadow add-item">'.
					'<div class="row">'.
						'<div class="col-12 col-md p-2">'.ucfirst($from).'&nbsp;</div>'.
						'<div class="col-12 col-md p-2">'.ucfirst($to).'&nbsp;</div>'.
						'<div class="col-12 col-md p-2">'.($hourFrom!=0?$hourFrom:'&nbsp;').'</div>'.
						'<div class="col-12 col-md p-2">'.($hourTo!=0?$hourTo:'&nbsp;').'</div>'.
						'<div class="col-12 col-md-3 p-2">'.$info.'&nbsp;</div>'.
						'<div class="col-12 col-md-1 p-2 text-center">'.
							'<input id="hoursactive'.$id.'" class="mx-auto" data-dbid="'.$id.'" data-dbt="choices" data-dbc="status" data-dbb="0" type="checkbox"'.($active==1?' checked aria-checked="true"':' aria-checked="false"').'>'.
						'</div>'.
						'<div class="col-12 col-md-1 text-right">'.
							'<div class="btn-group" role="group">'.
								'<form target="sp" action="core/purge.php">'.
									'<input name="id" type="hidden" value="'.$id.'">'.
									'<input name="t" type="hidden" value="choices">'.
									'<button class="purge" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
									'</form>'.
								'<span class="btn"><i class="i handle">drag</i></span>'.
							'</div>'.
						'</div>'.
					'</div>'.
				'</article>`);'.
				'window.top.window.toastr["success"]("Business Hours Added!");'.
				'$("#hours").sortable({'.
					'items:"article.item",'.
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
}
