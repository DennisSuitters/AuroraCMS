<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Add Suggestions
 * @package    core/layout/suggestions-add.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'..'.DS.'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');?>
<div id="suggestions_add">
  <form id="suggestionsform" method="post" action="core/add_suggestion.php">
    <input type="hidden" name="id" value="<?php echo$id;?>">
    <input type="hidden" name="t" value="<?php echo$t;?>">
    <input type="hidden" name="c" value="<?php echo$c;?>">
    <?php if($c!='notes'){?>
      <div class="form-group">
        <label for="suggestedit">Suggested Edit</label>
        <div class="input-group">
          <input id="suggestedit" class="form-control" name="da" value="" placeholder="Enter a Suggestion...">
        </div>
      </div>
    <?php }else{?>
      <div class="form-group">
        <div class="alert alert-info" role="alert">Edit the content within the Editor before adding this suggestion, just don't save the content.</div>
        <textarea id="suggestda" name="da" class="d-none"></textarea>
      </div>
    <?php }?>
    <div class="form-group">
      <label for="suggestreason">Reason</label>
      <div class="input-group">
        <input id="suggestreason" class="form-control" name="dar" value="" placeholder="Enter a Reason...">
      </div>
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary add">Add Suggestion</button>
    </div>
  </form>
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
