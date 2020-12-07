<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Media
 * @package    core/add_media.php
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
function svg($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
$t=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
$fu=filter_input(INPUT_POST,'fu',FILTER_SANITIZE_STRING);
echo'<script>';
if($fu!=''){
	if($t=='pages'||$t=='content'){
		$file_list=explode(',',$fu);
		foreach($file_list as $file){
			$q=$db->prepare("INSERT IGNORE INTO `".$prefix."media` (`rid`,`pid`,`file`,`ti`) VALUES (:rid,:pid,:file,:ti)");
			$q->execute([
				':rid'=>$rid,
				':pid'=>$id,
				':file'=>$file,
				':ti'=>time()
			]);
			$iid=$db->lastInsertId();
			$q=$db->prepare("UPDATE `".$prefix."media` SET `ord`=:ord WHERE `id`=:id");
			$q->execute([
				':id'=>$iid,
				':ord'=>$iid+1
			]);
			$thumb='media/sm/'.basename($file);?>
window.top.window.$('#mi').append('<?php
echo'<div class="card stats col-6 col-md-3 m-1 swing-in-top-fwd" id="mi_'.$iid.'">'.
	'<div class="btn-group float-right">'.
		'<div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item" onclick="return false;">'.svg('drag').'</div>'.
		'<div class="btn" data-tooltip="tooltip" aria-label="Viewed 0 times">'.svg('view').' &nbsp;0</div>'.
		'<a class="btn" href="'.URL.$settings['system']['admin'].'/media/edit/'.$iid.'">'.svg('edit').'</a>'.
		'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$iid.'`,`media`);">'.svg('trash').'</button>'.
		'</div>'.
		'<a class="card bg-dark m-0" data-fancybox="media" data-caption="" href="'.$file.'">'.
			'<img src="'.$thumb.'" alt="Media '.$iid.'">'.
		'</a>'.
	'</div>';?>
');
window.top.window.$().fancybox({selector:'[data-fancybox="media"]'});
<?php }
	}
}
echo'</script>';
