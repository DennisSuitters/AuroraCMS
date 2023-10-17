<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Discount Range
 * @package    core/add_discountrange.php
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
$f=isset($_POST['f'])?filter_input(INPUT_POST,'f',FILTER_UNSAFE_RAW):'';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$m=isset($_POST['m'])?filter_input(INPUT_POST,'m',FILTER_UNSAFE_RAW):1;
$v=isset($_POST['v'])?filter_input(INPUT_POST,'v',FILTER_UNSAFE_RAW):0;
if($f!=''&&$t!=''&&$v!=0){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`contentType`,`f`,`t`,`value`,`cost`) VALUES ('discountrange',:f,:t,:m,:cost)");
  $s->execute([
		':f'=>$f,
		':t'=>$t,
    ':m'=>$m,
		':cost'=>$v
	]);
  if($v==0)$v='';
  $id=$db->lastInsertId();
	echo'<script>'.
        'window.top.window.$("#discountrange").append(`<div id="l_'.$id.'" class="row add-item">'.
          '<div class="col-12 col-md">'.
            '<div class="input-text">'.$f.'</div>'.
          '</div>'.
          '<div class="col-12 col-md">'.
            '<div class="input-text">'.$t.'</div>'.
          '</div>'.
          '<div class="col-12 col-md">'.
            '<div class="input-text">'.($m==2?'&#37; Off':'&#36; Off').'</div>'.
          '</div>'.
          '<div class="col-12 col-md">'.
            '<div class="form-row">'.
              '<div class="input-text col-md">'.$v.'</div>'.
              '<form target="sp" action="core/purge.php">'.
                '<input type="hidden" name="id" value="'.$id.'">'.
                '<input type="hidden" name="t" value="choices">'.
                '<button type="submit" class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
              '</form>'.
            '</div>'.
          '</div>'.
        '</div>`);'.
      '</script>';
}else echo'<script>window.top.window.toastr["error"]("Not all data was entered");</script>';
