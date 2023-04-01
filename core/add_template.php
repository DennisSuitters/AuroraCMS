<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Template
 * @package    core/add_template.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):'';
$s=isset($_POST['s'])?filter_input(INPUT_POST,'s',FILTER_UNSAFE_RAW):'';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$htm=isset($_POST['htm'])?filter_input(INPUT_POST,'htm',FILTER_UNSAFE_RAW):'';
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):'';
$i=isset($_POST['i'])?filter_input(INPUT_POST,'i',FILTER_UNSAFE_RAW):'';
if($t!=''&&$i!=''&&$htm!=''&&$da!=''){
//  if(stristr($i,'<svg')){
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."templates` (`contentType`,`section`,`title`,`html`,`notes`,`image`) VALUES (:c,:s,:t,:htm,:da,:i)");
    $q->execute([
      ':c'=>$c,
      ':s'=>$s,
      ':t'=>$t,
      ':htm'=>$htm,
      ':da'=>$da,
      ':i'=>$i
    ]);
    $id=$db->lastInsertId();
  	echo'<script>'.
  				'window.top.window.$("#templates").append(`'.
  					'<article class="card card-list" id="l_'.$id.'">'.
              '<div class="card-image">'.
                $i.
              '</div>'.
  						'<div class="card-header line-clamp">'.
                $t.
              '</div>'.
              '<div class="card-body no-clamp">'.
                '<p class="small"><small>'.$da.'</small></p>'.
              '</div>'.
              '<div class="card-footer">'.
                '<div id="controls_'.$id.'">'.
                  '<div class="btn-toolbar float-right" role="toolbar">'.
                    '<div class="btn-group" role="group">'.
                      '<form class="float-right" target="sp" action="core/purge.php">'.
                      '<input name="id" type="hidden" value="'.$id.'">'.
                      '<input name="t" type="hidden" value="templates">'.
                      '<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
                    '</form>'.
                  '</div>'.
                '</div>'.
              '</div>'.
            '</article>'.
  				'`);'.
  				'window.top.window.toastr["success"]("Template added!");'.
  			'</script>';
//  }else{
//    echo'<script>window.top.window.toastr["error"]("Whatever was put into the SVG Thumbnail field was not a valid SVG Image!");</script>';
//  }
}else{
  if($t=='')echo'<script>window.top.window.toastr["error"]("No Title was entered!");</script>';
  if($i=='')echo'<script>window.top.window.toastr["error"]("No SVG Icon was entered!");</script>';
  if($htm=='')echo'<script>window.top.window.toastr["error"]("No HTML Markup was entered!");</script>';
  if($da=='')echo'<script>window.top.window.toastr["error"]("No Description Text was entered!");</script>';
}
