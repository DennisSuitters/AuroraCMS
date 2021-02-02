<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Pages
 * @package    core/layout/set_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('users','i-3x');?></div>
          <div>Page Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
          <li class="breadcrumb-item active"><strong>Settings</strong></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <legend id="websiteVoice" class="mt-3"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/settings#websiteVoice" aria-label="PermaLink to Website Voice Section">&#128279;</a>':'';?>Website Voice</legend>
        <?php if($config['wv_site_id']==''){?>
          <div class="alert alert-info" role="alert">
            <a class="alert-link" target="_blank" href="https://websitevoice.com/convert-text-to-audio-free">Website Voice</a> allows you to add a narrator to your Website to allow visually impaired visitors and those who wish to listen to your content read to them.<br>
            To full-enable Website Voice, visit the link above and sign-up for free. You can optionally pay for the service to enable extra features.<br>
            Once signed-up copy and paste the <code>WV_SITE_ID</code> into the field below, and enable the option. The Service will be automatically added to your site pages.
          </div>
        <?php }?>
        <div class="row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/settings#enableWebsiteVoice" aria-label="PermaLink to Wenable Website Voice Checkbox">&#128279;</a>':'';?>
          <input id="enableWebsiteVoice" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="16" type="checkbox"<?php echo$config['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="enableWebsiteVoice">Enable Website Voice</label>
        </div>
        <label id="websiteVoiceID" for="update_url"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/settings#websiteVoiceID" aria-label="PermaLink to Website Voice ID">&#128279;</a>':'';?>WV_SITE_ID</label>
        <div class="form-row">
          <input class="textinput" id="wv_site_id" data-dbid="1" data-dbt="config" data-dbc="wv_site_id" type="text" value="<?php echo$config['wv_site_id'];?>" placeholder="Enter Website Voice ID...">
          <button class="save" id="savewv_site_id" data-dbid="wv_site_id" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?php svg('save');?></button>
        </div>
        <hr>
        <?php if(!file_exists('layout/'.$config['theme'].'/theme.ini')){
          echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
        }else{?>
          <legend id="quickPageEdit"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/settings#quickPageEdit" aria-label="PermaLink to Quick Page Edit Section">&#128279;</a>':'';?>Quick Page Edit</legend>
          <form target="sp" method="post" action="core/updatetheme.php" onsubmit="$('#codeSave').removeClass('trash');">
            <label for="fileEditSelect">File:</label>
            <div class="form-row">
              <select id="filesEditSelect" name="file">
                <?php $fileDefault=($user['rank']==1000?'meta_head.html':'meta_head.html');
                $files=array();
                foreach(glob("layout/".$config['theme']."/*.{html}",GLOB_BRACE)as$file){
                  echo'<option value="'.$file.'"';
                  if(stristr($file,$fileDefault)){
                    echo' selected';
                    $fileDefault=$file;
                  }
                  echo'>'.basename($file).'</option>';
                }
                foreach(glob("media/carousel/*.{html}",GLOB_BRACE)as$file){
                  echo'<option value="'.$file.'"';
                  if(stristr($file,$fileDefault)){
                    echo' selected';
                    $fileDefault=$file;
                  }
                  echo'>'.basename($file).' (Carousel)</option>';
                }?>
              </select>
              <button id="filesEditLoad">Load</button>
            </div>
            <div class="wysiwyg-toolbar">
              <button id="codeSave" data-tooltip="tooltip" aria-label="Save" onclick="populateTextarea();"><?php svg('save');?></button>
            </div>
            <div class="form-row">
              <?php $code=file_get_contents($fileDefault);?>
              <textarea id="code" name="code"><?php echo$code;?></textarea>
            </div>
          </form>
          <?php require'core/layout/footer.php';?>
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
              $('#codeSave').addClass('trash');
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
  </section>
</main>
<iframe class="d-none" id="sp" name="sp"></iframe>
