<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Brand Option
 * @package    core/add_brand.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
define('ADMINNOAVATAR','core'.DS.'images'.DS.'i-noavatar.svg');
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
$title=filter_var($_POST['brandtitle'],FILTER_SANITIZE_STRING);
$url=isset($_POST['brandurl'])?filter_input(INPUT_POST,'brandurl',FILTER_SANITIZE_STRING):'';
$icon=isset($_POST['brandicon'])?filter_input(INPUT_POST,'brandicon',FILTER_SANITIZE_STRING):'';
if($title!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`icon`,`url`,`title`) VALUES ('brand',:icon,:url,:title)");
  $s->execute([
		':url'=>$url,
		':icon'=>$icon,
		':title'=>$title
	]);
  $id=$db->lastInsertId();?>
<script>
  window.top.window.$('#brand').append('<div id="l_<?php echo$id;?>" class="form-group row"><div class="input-group col"><label for="title<?php echo$id;?>" class="input-group-text">Brand</label><input type="text" id="title<?php echo$id;?>" class="form-control" value="<?php echo$title;?>" readonly><label for="url<?php echo$id;?>" class="input-group-text">URL</label><input type="text" id="url<?php echo$id;?>" class="form-control" value="<?php echo$url;?>" readonly><div class="input-group-text">Image</div><div class="input-group-append img"><?php echo$icon!=''?'<a href="'.$icon.'" data-lightbox="lightbox"><img id="thumbimage" src="'.$icon.'" alt="Thumbnail"></a>':'<img id="thumbimage" src="core/images/noimage.png" alt="No Image">';?></div><div class="input-group-append"><form target="sp" action="core/purge.php"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button></form></div></div></div>');
</script>
<?php }
