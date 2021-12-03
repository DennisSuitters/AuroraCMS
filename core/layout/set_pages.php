<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Pages
 * @package    core/layout/set_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('content','i-3x');?></div>
          <div>Page <br class="d-block d-sm-none">Settings</div>
          <div class="content-title-actions">
            <?= isset($_SERVER['HTTP_REFERER'])?'<a class="btn" href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="tooltip" aria-label="Back">'.svg2('back').'</a>':'';?>
            <button class="btn saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
          <li class="breadcrumb-item active"><strong>Settings</strong></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <?php if(!file_exists('layout/'.$config['theme'].'/theme.ini'))echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
        else{?>
          <legend id="quickPageEdit"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/settings#quickPageEdit" data-tooltip="tooltip" aria-label="PermaLink to Quick Page Edit Section">&#128279;</a>':'';?>Quick Page Edit</legend>
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
              <button id="codeSave" data-tooltip="tooltip" aria-label="Save" onclick="populateTextarea();"><?= svg2('save');?></button>
            </div>
            <div class="form-row">
              <?php $code=file_get_contents($fileDefault);?>
              <textarea id="code" name="code"><?=$code;?></textarea>
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
                  url:url+'?<?= time();?>',
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
