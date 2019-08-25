<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Category Option
 * @package    core/add_category.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
define('ADMINNOAVATAR','core'.DS.'images'.DS.'i-noavatar.svg');
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
//$cat=isset($_POST['cat'])?filter_input(INPUT_POST['cat'],FILTER_SANITIZE_STRING):'';
$cat=filter_var($_POST['cat'],FILTER_SANITIZE_STRING);
$ct=isset($_POST['ct'])?filter_input(INPUT_POST,'ct',FILTER_SANITIZE_STRING):'';
$icon=isset($_POST['icon'])?filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING):'';
if($cat!=''){
  $s=$db->prepare("INSERT INTO `".$prefix."choices` (contentType,icon,url,title) VALUES ('category',:icon,:c,:t)");
  $s->execute([
		':c'=>$ct,
		':icon'=>$icon,
		':t'=>$cat
	]);
  $id=$db->lastInsertId();?>
<script>
  window.top.window.$('#category').append('<div id="l_<?php echo$id;?>" class="form-group row"><div class="input-group col"><label for="cat<?php echo$id;?>" class="input-group-text">Category</label><input type="text" id="cat<?php echo$id;?>" class="form-control" value="<?php echo$cat;?>" readonly><label for="ct<?php echo$id;?>" class="input-group-text">Content</label><input type="text" id="ct<?php echo$id;?>" class="form-control" value="<?php echo$ct;?>" readonly><div class="input-group-text">Image</div><div class="input-group-append img"><?php echo$icon!=''?'<a href="'.$icon.'" data-lightbox="lightbox"><img id="thumbimage" src="'.$icon.'" alt="Thumbnail"></a>':'<img id="thumbimage" src="core/images/noimage.png" alt="No Image">';?></div><div class="input-group-append"><form target="sp" action="core/purge.php"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button></form></div></div></div>');
</script>
<?php }
