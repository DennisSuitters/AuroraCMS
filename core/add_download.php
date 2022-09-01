<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Download
 * @package    core/add_download.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
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
						'<div class="input-text border-right-0 border-bottom-0">'.
							'<label>Title:</label>'.
						'</div>'.
						'<input class="border-bottom-0 border-left-0" type="text" name="t" value="'.$t.'" placeholder="Uses Filename in place of title..." readonly>'.
					'</div>';
					if($r==1){
						echo'<div class="form-row">'.
							'<div class="input-text border-right-0 border-bottom-0">'.
								'<label>Requires Order</label>&nbsp;<input type="checkbox" name="r" checked disabled>'.
							'</div>'.
							'<div class="input-text border-right-0 border-bottom-0 border-left-0 pr-0">'.
								'<label>and&nbsp;is&nbsp;available&nbsp;for&nbsp;download&nbsp;for:</label>'.
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
			echo'<script>window.top.window.toastr["error"](`An error occured while uploading the file!`);</script>';
		}
	}else{
		echo'<script>window.top.window.toastr["error"]("Filetype not allowed!");</script>';
	}
}
