<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content - Browse Unsplash
 * @package    core/layout/edit_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$f=isset($_GET['f'])?filter_input(INPUT_GET,'f',FILTER_UNSAFE_RAW):'';
require'db.php';
$config=$db->query("SELECT mediaOptions,mediaMaxWidth,mediaMaxWidthThumb,unsplash_appname,unsplash_publickey,unsplash_secretkey FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
  if($config['mediaOptions'][0]==1){?>
    <div class="container">
      <div id="editimage" class="d-block"></div>
    </div>
    <style>
      .fancybox-container {
        z-index:1200;
      }
      .fancybox-button {
        display:none;
      }
    </style>
    <script>
      var f=$('.<?=$f;?>').val();
      var imageeditor=$('#editimage');
      var file=$('.<?=$f;?>').val();
      if($('.<?=$f;?>').val().length>0){
        const {TABS,TOOLS}=FilerobotImageEditor;
        const config={
          zIndex:20000,
          source:$('.<?=$f;?>').val(),
          onSave:(editedImageObject,designState)=>{
            var url=`<?= URL;?>media/`;
            if(editedImageObject.fullName.match(/\.(jpeg)$/i)){
              filename=editedImageObject.fullName.replace(/\.[^/.]+$/,"")+'.jpg';
            }else{
              filename=editedImageObject.fullName;
            }
            $.ajax({
              type:"POST",
              url:'core/savebase64.php',
              data:{
                filename:filename,
                imgBase64:editedImageObject.imageBase64
              }
            }).done(function(){
              $('.<?=$f;?>').val(url+filename);
            });
          },
          annotationsCommon:{
            fill:'#ffffff',
          },
          Crop:{
            ratio:'custom',
          },
          Rotate:{angle:90,componentType:'slider'},
          tabsIds:[TABS.ADJUST,TABS.FINETUNE,TABS.FILTERS,TABS.WATERMARK,TABS.DRAW,TABS.RESIZE,TABS.ANNOTATE,],
          defaultTabId:TABS.ADJUST,
          defaultToolId:TOOLS.TEXT,
          observePluginContainerSize:false,
        };
        const filerobotImageEditor=new FilerobotImageEditor(
          document.querySelector('#editimage'),
          config,
        );
        filerobotImageEditor.render({
          onClose:(closingReason)=>{
            filerobotImageEditor.terminate();
            $.fancybox.close();
          },
        });
        $.fancybox({
          dragToClose: false,
          Carousel: {
            Panzoom: {
              touch: false,
            },
          },
        })
      } else {
        toastr["info"](`Save the image to update the field data to allow opening in editor!`);
      }
    </script>
  <?php }else{
    echo'<div class="container p-5">'.
      ($config['mediaOptions'][0]==0?'<div class="alert alert-warning">The Unsplash Search Browser is not enabled.</div>':'').
    '</div>';
  }
