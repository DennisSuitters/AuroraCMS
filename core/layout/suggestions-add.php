<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Add Suggestions
 * @package    core/layout/suggestions-add.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'../db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'c',FILTER_UNSAFE_RAW);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');?>
<div class="fancybox-ajax">
  <h6 class="bg-dark p-2">Add an Editing Suggestion</h6>
  <div class="m-3" id="suggestions_add">
    <form id="suggestionsform" method="post" action="core/add_suggestion.php">
      <input name="id" type="hidden" value="<?=$id;?>">
      <input name="t" type="hidden" value="<?=$t;?>">
      <input name="c" type="hidden" value="<?=$c;?>">
      <?php if($c!='notes'){?>
        <label for="suggestedit">Suggested Edit</label>
        <div class="form-row">
          <input id="suggestedit" name="da" type="text" value="" placeholder="Enter a Suggestion...">
        </div>
      <?php }else{?>
        <div class="form-row">
          <div class="alert alert-info" role="alert">Edit the content within the Editor before adding this suggestion, just don't save the content.</div>
          <textarea class="d-none" id="suggestda" name="da"></textarea>
        </div>
      <?php }?>
      <label for="suggestreason">Reason</label>
      <div class="form-row">
        <input id="suggestreason" name="dar" type="text" value="" placeholder="Enter a Reason...">
      </div>
      <div class="form-row mt-4">
        <button class="btn-block add" type="submit">Add Suggestion</button>
      </div>
    </form>
  </div>
</div>
<script>
  <?php if($c=='notes'){?>
    $('#suggestda').html($('#notes').summernote('code'));
  <?php }?>
  $("#suggestionsform").submit(function(){
    $.post($(this).attr("action"),$(this).serialize(),function(data){
      $("#suggestions_add").html(data);
    });
    return false;
  });
</script>
