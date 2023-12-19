<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Location
 * @package    core/add_location.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$postcode=filter_input(INPUT_POST,'postcode',FILTER_UNSAFE_RAW);
$state=filter_input(INPUT_POST,'state',FILTER_UNSAFE_RAW);
$area=filter_input(INPUT_POST,'area',FILTER_UNSAFE_RAW);
$in=filter_input(INPUT_POST,'in',FILTER_UNSAFE_RAW);
$ti=time();
if($postcode==''||$area==''){
  echo'<script>'.
    ($postcode==''?'window.top.window.toastr["error"]("The Postcode Field must contain data!");':'').
    ($area==''?'window.top.window.toastr["error"]("The Area Field must contain data!");':'').
  '</script>';
}else{
  $q=$db->prepare("SELECT `id` FROM `".$prefix."locations` WHERE `postcode`=:postcode AND `area`=:area");
  $q->execute([
    ':postcode'=>$postcode,
    ':area'=>$area
  ]);
  if($q->rowCount()>0){
    echo'<script>window.top.window.toastr["warning"]("'.$area.' already exists!");</script>';
  }else{
  	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."locations` (`area`,`state`,`postcode`,`active`) VALUES (:area,:state,:postcode,:active)");
  	$q->execute([
  		':area'=>$area,
      ':state'=>$state,
      ':postcode'=>$postcode,
  		':active'=>($in==1?1:0)
  	]);
  	$id=$db->lastInsertId();
  	$e=$db->errorInfo();
    echo'<script>'.
  		'window.top.window.$("#locationsitems").append(`<div id="l_'.$id.'" class="locationitem row border-bottom add-item" data-postcode="'.$postcode.'" data-area="'.$area.'" data-content="'.$postcode.' '.$area.'">'.
        '<div class="col-2">'.
          '<form class="form-row" target="sp" method="post" action="core/update.php">'.
            '<input type="hidden" name="id" value="'.$id.'">'.
            '<input type="hidden" name="t" value="locations">'.
            '<input type="hidden" name="c" value="postcode">'.
            '<input type="text" name="da" value="'.$postcode.'">'.
            '<button type="submit"><i class="i">save</i></button>'.
          '</form>'.
        '</div>'.
        '<div class="col-8">'.
  				'<form class="form-row" target="sp" method="post" action="core/update.php">'.
  					'<input type="hidden" name="id" value="'.$id.'">'.
  					'<input type="hidden" name="t" value="locations">'.
  					'<input type="hidden" name="c" value="area">'.
  					'<input type="text" name="da" value="'.$area.'">'.
  					'<button type="submit"><i class="i">save</i></button>'.
  				'</form>'.
  			'</div>'.
        '<div class="col-1 text-center p-2">'.
          '<input id="locations'.$id.'" data-dbid="'.$id.'" data-dbt="locations" data-dbc="active" type="checkbox"'.($in==1?' checked':'').'>'.
        '</div>'.
        '<div class="col-1 text-right">'.
          '<a class="btn" href="https://www.google.com/maps/place/'.str_replace(' ','+',$area).'+'.$state.'+'.$postcode.'" target="child" data-tooltip="tooltip" aria-label="View Location in Google Maps"><i class="i">map</i></a>'.
          '<button class="trash" onclick="purge(\`'.$id.'\`,\`locations\`);"><i class="i">trash</i></button>'.
        '</div>'.
  		'</div>`);'.
      'window.top.window.toastr["success"]("'.$area.' added!")'.
  	'</script>';
  }
}
