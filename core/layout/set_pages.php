<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Pages
 * @package    core/layout/set_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
    <li class="breadcrumb-item active"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
<?php if(!file_exists('layout'.DS.$config['theme'].DS.'theme.ini')){
  echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
}else{?>
        <form target="sp" method="post" action="core/updatetheme.php">
          <div class="input-group">
            <label for="fileEditSelect" class="input-group-text">File:</label>
            <select id="filesEditSelect" class="custom-select" name="file">
<?php $fileDefault=($user['rank']==1000?'meta_head.html':'meta_head.html');
  $files=array();
  foreach(glob("layout".DS.$config['theme'].DS."*.{html}",GLOB_BRACE)as$file){
    echo'<option value="'.$file.'"';
    if(stristr($file,$fileDefault)){
      echo' selected';
      $fileDefault=$file;
    }
    echo'>'.basename($file).'</option>';
  }
  foreach(glob("media".DS."carousel".DS."*.{html}",GLOB_BRACE)as$file){
    echo'<option value="'.$file.'"';
    if(stristr($file,$fileDefault)){
      echo' selected';
      $fileDefault=$file;
    }
    echo'>'.basename($file).' (Carousel)</option>';
  }?>
            </select>
            <div class="input-group-append">
              <button id="filesEditLoad" class="btn btn-secondary">Load</button>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group card-header p-2 mb-0">
              <button id="codeSave" class="btn btn-secondary" onclick="populateTextarea();$(this).removeClass('btn-danger');" data-tooltip="tooltip" data-placement="bottom" data-title="Save" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="form-group" style="margin-top:-15px">
<?php $code=file_get_contents($fileDefault);?>
            <textarea id="code" name="code"><?php echo$code;?></textarea>
          </div>
        </form>
      </div>
      <script>
        $(document).ready(function (){
          var editor=CodeMirror.fromTextArea(document.getElementById("code"),{
            lineNumbers:true,
            lineWrapping:true,
            mode:"text/html",
            theme:"base16-dark",
            autoRefresh:true
          });
          var charWidth=editor.defaultCharWidth(),basePadding=4;
          editor.refresh();
          editor.on('change',function(cMirror){
            $('#codeSave').addClass('btn-danger');
          });
          $('#filesEditLoad').on({
            click:function(event){
              event.preventDefault();
              var url=$('#filesEditSelect').val();
              $.ajax({
                url:url+'?<?php echo time();?>',
                dataType:"text",
                success:function(data){
                  editor.setValue(data);
                }
              });
            }
          });
        });
      </script>
<?php }?>
    </div>
  </div>
</main>
<iframe id="sp" name="sp" class="d-none"></iframe>
