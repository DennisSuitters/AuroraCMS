<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Download
 * @package    core/add_download.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.16
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
$r=isset($_POST['r'])?filter_input(INPUT_POST,'r',FILTER_SANITIZE_NUMBER_INT):0;
$a=isset($_POST['a'])?filter_input(INPUT_POST,'a',FILTER_SANITIZE_NUMBER_INT):0;
$fu=$_FILES['fu'];
if(isset($_FILES['fu'])){
	$ft=$_FILES['fu']['type'];
	if(in_array($ft,[
'audio/aac','audio/midi','audio/mpeg','audio/ogg','audio/wav','audio/x-midi',
'application/epub+zip','application/gzip','application/java-archive','application/msword','application/ogg','application/pdf','application/rtf','application/vnd.amazon.ebook','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/vnd.oasis.opendocument.presentation','application/vnd.oasis.opendocument.spreadsheet','application/vnd.oasis.opendocument.text','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.rar','application/x-7z-compressed','application/x-bzip','application/x-bzip2','application/x-freearc','application/x-tar','application/zip',
'text/plain','video/mp4','video/mpeg','video/ogg'
	])){
		$tp='../media/downloads/'.basename($_FILES['fu']['name']);
		$file=basename($_FILES['fu']['name']);
		if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
			$q=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`url`,`title`,`password`,`tie`,`ti`) VALUES (:rid,'download',:file,:title,:p,:tie,:ti)");
			$q->execute([
				':rid'=>$id,
				':file'=>$file,
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
						'window.top.window.$("#downloads").append(`<div class="row mt-1" id="l_'.$iid.'">'.
							'<div class="form-row">'.
								'<input type="text" name="t" value="'.$t.'" readonly>';
				if($r==1){
								echo'<div class="input-text">'.
									'<label>Requires Order</label>&nbsp;<input type="checkbox" name="r" checked disabled>'.
								'<label>&nbsp;and is Available for </label>';
								if($a==3600)echo' 1 Hour';
			          if($a==7200)echo' 2 Hours';
			          if($a==14400)echo' 4 Hours';
			          if($a==28800)echo' 8 Hours';
			          if($a==86400)echo' 24 Hours';
			          if($a==172800)echo' 48 Hours';
			          if($a==604800)echo' 1 Week';
			          if($a==1209600)echo' 2 Weeks';
			          if($a==2592000)echo' 1 Month';
			          if($a==7776000)echo' 3 Months';
			          if($a==15552000)echo' 6 Months';
			          if($a==31536000)echo' 1 Year';
								echo'</div>';
				}
				echo'</div>'.
							'<div class="form-row">'.
				      	'<input id="url'.$iid.'" name="url" type="text" value="'.$file.'" readonly>'.
				      	'<form target="sp" action="core/purge.php">'.
				        	'<input name="id" type="hidden" value="'.$iid.'">'.
				        	'<input name="t" type="hidden" value="choices">'.
				        	'<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
				      	'</form>'.
							'</div>'.
				    '</div>`);'.
					'</script>';
		}else{
			echo'window.top.window.toastr["error"]("An error occured while uploading the file!");';
		}
	}else{
		echo'window.top.window.toastr["error"]("Filetype not allowed!");';
	}
}
