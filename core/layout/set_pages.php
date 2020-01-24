<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Pages
 * @package    core/layout/set_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.11
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Add options for Website Voice service.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
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
        <legend>Website Voice</legend>
<?php if($config['wv_site_id']==''){?>
        <div class="alert alert-info">
          <a target="_blank" class="alert-link" href="https://websitevoice.com/convert-text-to-audio-free">Website Voice</a> allows you to add a narrator to your Website to allow visually impaired visitors and those who wish to listen to your content read to them.<br>
          To full-enable Website Voice, visit the link above and sign-up for free. You can optionally pay for the service to enable extra features.<br>
          Once signed-up copy and paste the <code>WV_SITE_ID</code> into the field below, and enable the option. The Service will be automatically added to your site pages.
        </div>
<?php }?>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options16" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="16"<?php echo$config['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options16" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable Website Voice</label>
        </div>
        <div class="form-group row">
          <label for="update_url" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">WV_SITE_ID</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="wv_site_id" class="form-control textinput" value="<?php echo$config['wv_site_id'];?>" data-dbid="1" data-dbt="config" data-dbc="wv_site_id" placeholder="Enter Website Voice ID...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savewv_site_id" class="btn btn-secondary save" data-dbid="wv_site_id" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <hr>
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
