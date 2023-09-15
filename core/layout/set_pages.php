<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Pages
 * @package    core/layout/set_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
                <li class="breadcrumb-item active"><strong>Settings</strong></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <?php if($user['options'][7]==1){
          if(!file_exists('layout/'.$config['theme'].'/theme.ini'))
            echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
          else{?>
            <legend>Quick Page Edit</legend>
            <form target="sp" method="post" action="core/updatetheme.php" onsubmit="$('#codeSave').removeClass('btn-danger');">
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
                <button id="codeSave" data-tooltip="tooltip" aria-label="Save" onclick="populateTextarea();"><i class="i">save</i></button>
              </div>
              <div class="row">
                <?php $code=file_get_contents($fileDefault);?>
                <textarea id="code" name="code"><?=$code;?></textarea>
              </div>
            </form>
            <?php require'core/layout/footer.php';?>
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
          <?php }
        }?>
      </div>
    </div>
  </section>
</main>
<iframe class="d-none" id="sp" name="sp"></iframe>
