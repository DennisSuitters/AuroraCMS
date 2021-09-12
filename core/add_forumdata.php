<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Forum Data
 * @package    core/add_forumdata.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
function rank($txt){
	if($txt==0)return'visitor';
	if($txt==100)return'subscriber';
	if($txt==200)return'member';
	if($txt==210)return'member-silver';
	if($txt==220)return'member-bronze';
	if($txt==230)return'member-gold';
	if($txt==240)return'member-platinum';
	if($txt==300)return'client';
	if($txt==310)return'wholesale-silver';
	if($txt==320)return'wholesale-bronze';
	if($txt==330)return'wholesale-gold';
	if($txt==340)return'wholesale-platinum';
	if($txt==400)return'contributor';
	if($txt==500)return'author';
	if($txt==600)return'editor';
	if($txt==700)return'moderator';
	if($txt==800)return'manager';
	if($txt==900)return'administrator';
	if($txt==1000)return'developer';
}
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if($act=='category'){
  $t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):'';
	$rank=isset($_POST['rank'])?filter_input(INPUT_POST,'rank',FILTER_SANITIZE_STRING):0;
	$help=isset($_POST['help'])?1:0;
	$el='#cats';
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."forumCategory` (`rank`,`title`,`notes`,`help`,`ti`) VALUES (:rank,:title,:notes,:help,:ti)");
  $s->execute([
		':rank'=>$rank,
    ':title'=>$t,
    ':notes'=>$da,
		':help'=>$help,
    ':ti'=>time()
  ]);
	$id=$db->lastInsertId();
	$s=$db->prepare("UPDATE `".$prefix."forumCategory` SET `ord`=:ord WHERE `id`=:id");
	$s->execute([
		':id'=>$id,
		':ord'=>$id
	]);
	$html='<div id="cats_'.$id.'" class="item row mb-3 border-1 bg-white">'.
		'<div class="card col-12 border-0">'.
			'<div class="form-row">'.
				'<form class="d-inline-flex" target="sp" method="post" action="core/update.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="forumCategory">'.
					'<input type="hidden" name="c" value="title">'.
					'<div class="input-text">'.svg2('drag','cathandle').'</div>'.
					'<div class="input-text">Category</div>'.
					'<input type="text" name="da" value="'.$t.'" placeholder="Enter a Category...">'.
					'<button class="save d-inline-flex" data-tooltip="tooltip" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
				'</form>'.
				'<form class="d-inline-flex" target="sp" method="post" action="core/update.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="forumCategory">'.
					'<input type="hidden" name="c" value="notes">'.
					'<div class="input-text">Description</div>'.
					'<input type="text" name="da" value="'.$da.'" placeholder="Enter a Description...">'.
					'<button class="save" data-tooltip="tooltip" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
				'</form>'.
				'<div class="input-text">'.
					'<form class="d-inline-flex" target="sp" method="post" action="core/toggle.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="b" value="0">'.
						'<input type="hidden" name="t" value="forumCategory">'.
						'<input type="hidden" name="c" value="help">'.
						'<label for="help'.$id.'">Help: </label><input type="checkbox" id="help'.$id.'"'.($help==1?' checked':'').' onchange="this.form.submit();">'.
					'</form>'.
				'</div>'.
				'<div class="input-text">'.
					'<form class="d-inline-flex" target="sp" method="post" action="core/toggle.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="b" value="0">'.
						'<input type="hidden" name="t" value="forumCategory">'.
						'<input type="hidden" name="c" value="pin">'.
						'<label for="pin'.$id.'">Pin: </label><input type="checkbox" id="pin'.$id.'" onchange="this.form.submit();">'.
					'</form>'.
				'</div>'.
				'<form class="d-inline-flex" target="sp" method="post" action="core/purgeforum.php">'.
					'<input type="hidden" name="t" value="forumCategory">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
				'</form>'.
			'</div>'.
			'<small class="badger badge-'.rank($rank).'">Available to '.ucwords(($rank==0?'everyone':str_replace('-',' ',rank($rank)))).'</small>'.
		'</div>'.
		'<div id="topics_'.$id.'" class="card-body ml-3 mt-3">'.
			'<form target="sp" method="post" action="core/add_forumdata.php">'.
				'<input type="hidden" name="act" value="topic">'.
				'<input type="hidden" name="id" value="'.$id.'">'.
				'<input type="hidden" name="rank" value="'.$rank.'">'.
				'<div class="form-row">'.
					'<div class="input-text">Topic</div>'.
					'<input type="text" name="t" value="" placeholder="Enter a Topic Title...">'.
					'<div class="input-text">Description</div>'.
					'<input type="text" name="da" value="" placeholder="Enter a Short Description...">'.
					'<button class="add" data-tooltip="tooltip" aria-label="Add">'.svg2('add').'</button>'.
				'</div>'.
			'</form>'.
		'</div>'.
	'</div>';
}
if($act=='topic'){
  $cid=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):0;
  $t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):'';
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):'';
	$rank=isset($_POST['rank'])?filter_input(INPUT_POST,'rank',FILTER_SANITIZE_STRING):0;
	$help=isset($_POST['help'])?filter_input(INPUT_POST,'help',FILTER_SANITIZE_NUMBER_INT):0;
	$el='#topics_'.$cid;
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."forumTopics` (`rank`,`cid`,`title`,`notes`,`help`,`ti`) VALUES (:rank,:cid,:title,:notes,:help,:ti)");
  $s->execute([
		':rank'=>$rank,
		':cid'=>$cid,
    ':title'=>$t,
    ':notes'=>$da,
		':help'=>$help,
    ':ti'=>time()
  ]);
	$id=$db->lastInsertId();
	$s=$db->prepare("UPDATE `".$prefix."forumTopics` SET `ord`=:ord WHERE `id`=:id");
	$s->execute([
		':id'=>$id,
		':ord'=>$id
	]);
	$html='<div id="topic_'.$id.'" class="item row mt-3 bg-white">'.
    '<div class="card col-12">'.
			'<div class="form-row">'.
				'<form class="d-inline-flex" target="sp" method="post" action="core/update.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="forumTopics">'.
					'<input type="hidden" name="c" value="title">'.
					'<div class="input-text">'.svg2('drag','subhandle').'</div>'.
					'<div class="input-text">Topic</div>'.
					'<input class="text-input" type="text" name="da" value="'.$t.'" placeholder="Enter a Topic...">'.
					'<button class="save d-inline-flex" data-tooltip="tooltip" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
				'</form>'.
				'<form class="d-inline-flex" target="sp" method="post" action="core/update.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="forumTopics">'.
					'<input type="hidden" name="c" value="notes">'.
					'<div class="input-text">Description</div>'.
					'<input type="text" name="da" value="'.$da.'" placeholder="Enter a Description...">'.
					'<button class="save d-inline-flex" data-tooltip="tooltip" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
				'</form>'.
				'<div class="input-text">'.
					'<form class="d-inline-flex" target="sp" method="post" action="core/toggle.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="b" value="0">'.
						'<input type="hidden" name="t" value="forumTopics">'.
						'<input type="hidden" name="c" value="pin">'.
						'<label for="pin'.$id.'">Pin: </label><input type="checkbox" id="pin'.$id.'" onchange="this.form.submit();">'.
					'</form>'.
				'</div>'.
				'<form class="d-inline-flex" target="sp" method="post" action="core/purgeforum.php">'.
					'<input type="hidden" name="t" value="forumTopics">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
				'</form>'.
			'</div>'.
    '</div>'.
		'<div class="ghost2 hidden"></div>'.
  '</div>';
}
echo'<script>'.
	'window.top.window.$("'.$el.'").append(`'.$html.'`);'.
	'window.top.window.toastr["success"]("'.ucwords($act).' Added");';
if($act=='topic'){
	echo'window.top.window.$("#cd_'.$cid.'").addClass("d-none");';
}
echo'</script>';
