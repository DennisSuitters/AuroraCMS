<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Media
 * @package    core/layout/set_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='34'");
$sv->execute();
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='32'");
$sv->execute();?>
<main>
 <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
   <div class="container-fluid">
     <div class="card mt-3 bg-transparent border-0 overflow-visible">
       <div class="card-actions">
         <div class="row">
           <div class="col-12 col-sm-6">
             <ol class="breadcrumb m-0 pl-0 pt-0">
               <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
               <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/media';?>">Media</a></li>
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
       <div class="tabs" role="tablist">
         <?='<input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>'.
         '<label for="tab1-1">General</label>'.
         '<input class="tab-control" id="tab1-2" name="tabs" type="radio">'.
         '<label for="tab1-2">Unsplash</label>';?>
         <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
           <legend class="mt-0">Image Processing</legend>
           <div class="form-text mt-1">Uploaded Images larger than the above size will be resized to their long edge. If either value is '0', resizing will be disabled.</div>
           <div class="form-row mt-2">
             <input id="mediaOptions2" data-dbid="1" data-dbt="config" data-dbc="mediaOptions" data-dbb="2" type="checkbox"<?=($config['mediaOptions'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
             <label for="mediaOptions2">On Page Image Editor</label>
           </div>
           <div class="form-row">
             <input id="mediaResizing" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="2" type="checkbox"<?=($config['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
             <label for="mediaResizing">Image Resizing</label>
           </div>
           <div class="row">
             <div class="col-12 col-md pr-md-3">
               <label for="mediaMaxWidth">Max Width</label>
               <div class="form-row">
                 <input class="textinput" id="mMW" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidth" type="text" value="<?=$config['mediaMaxWidth'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
                 <?=($user['options'][7]==1?'<button class="save" id="savemMW" data-dbid="mMW" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
               </div>
             </div>
             <div class="col-12 col-md pr-md-3">
               <label for="mediaMaxHeight">Max Height</label>
               <div class="form-row">
                 <input class="textinput" id="mMH" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeight" type="text" value="<?=$config['mediaMaxHeight'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
                 <?=($user['options'][7]==1?'<button class="save" id="savemMH" data-dbid="mMH" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
               </div>
             </div>
             <div class="col-12 col-md pr-md-3">
               <label for="mediaMaxWidthThumb">Max Thumb Width</label>
               <div class="form-row">
                 <input class="textinput" id="mMWT" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidthThumb" type="text" value="<?=$config['mediaMaxWidthThumb'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
                 <?=($user['options'][7]==1?'<button class="save" id="savemMWT" data-dbid="mMWT" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
               </div>
             </div>
             <div class="col-12 col-md pr-3">
               <label for="mediaMaxHeightThumb">Max Thumb Height</label>
               <div class="form-row">
                 <input class="textinput" id="mMHT" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeightThumb" type="text" value="<?=$config['mediaMaxHeightThumb'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
                 <?=($user['options'][7]==1?'<button class="save" id="savemMHT" data-dbid="mMHT" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
               </div>
             </div>
             <div class="col-12 col-md">
               <label for="mQ">Image Quality</label>
               <div class="form-row">
                 <input class="textinput" id="mQ" data-dbid="1" data-dbt="config" data-dbc="mediaQuality" type="text" value="<?=$config['mediaQuality'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
                 <?=($user['options'][7]==1?'<button class="save" id="savemQ" data-dbid="mQ" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
               </div>
             </div>
           </div>
         </div>
<?php /* Unsplash */ ?>
         <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
           <div class="form-row mt-0">
             <input id="mediaOptions0" data-dbid="1" data-dbt="config" data-dbc="mediaOptions" data-dbb="0" type="checkbox"<?=($config['mediaOptions'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
             <label for="mediaOptions0">Unsplash Search Browser</label>
           </div>
           <div class="form-row">
             <input id="mediaOptions1" data-dbid="1" data-dbt="config" data-dbc="mediaOptions" data-dbb="1" type="checkbox"<?=($config['mediaOptions'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
             <label for="mediaOptions1">Retrieve Thumbnail</label>
           </div>
           <label for="unsplash_appname">App Name</label>
           <div class="form-row">
             <input class="textinput" id="unsplash_appname" data-dbid="1" data-dbt="config" data-dbc="unsplash_appname" type="text" value="<?=$config['unsplash_appname'];?>"<?=($user['options'][7]==1?' placeholder="Unsplash Application Name"':' disabled');?>>
             <?=($user['options'][7]==1?'<button class="save" id="saveunsplash_appname" data-dbid="unsplash_appname" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
           </div>
           <label>API Public Key</label>
           <div class="form-row">
             <input class="textinput" id="unsplash_publickey" data-dbid="1" data-dbt="config" data-dbc="unsplash_publickey" type="text" value="<?=$config['unsplash_publickey'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
             <?=($user['options'][7]==1?'<button class="save" id="saveunsplash_publickey" data-dbid="unsplash_publickey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
           </div>
           <label>API Secret Key</label>
           <div class="form-row">
             <input class="textinput" id="unsplash_secretkey" data-dbid="1" data-dbt="config" data-dbc="unsplash_secretkey" type="text" value="<?=$config['unsplash_secretkey'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
             <?=($user['options'][7]==1?'<button class="save" id="saveunsplash_secretkey" data-dbid="unsplash_secretkey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
           </div>
         </div>
       </div>
     </div>
     <?php require'core/layout/footer.php';?>
   </div>
 </section>
</main>
