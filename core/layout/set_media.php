<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Media
 * @package    core/layout/set_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
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
               <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
               <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/media';?>">Media</a></li>
               <li class="breadcrumb-item active">Settings</li>
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
       <div class="m-4">
         <legend id="mediaProcessing" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaProcessing" data-tooltip="tooltip" aria-label="PermaLink to Enable Image Processing Checkbox">&#128279;</a>':'';?>Image Processing</legend>
         <div class="form-row mt-3">
           <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaOptions2" data-tooltip="tooltip" aria-label="PermaLink to Enable On Page Image Editor">&#128279;</a>':'';?>
           <input id="mediaOptions2" data-dbid="1" data-dbt="config" data-dbc="mediaOptions" data-dbb="2" type="checkbox"<?=($config['mediaOptions'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
           <label class="p-0 mt-0 ml-3" for="mediaOptions2" id="configmediaOptions2">On Page Image Editor</label>
         </div>
         <div class="form-row mt-3">
           <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#imageResizing" data-tooltip="tooltip" aria-label="PermaLink to Enable Image Resizing Checkbox">&#128279;</a>':'';?>
           <input id="mediaResizing" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="2" type="checkbox"<?=($config['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
           <label class="p-0 mt-0 ml-3" for="mediaResizing" id="configoptions21">Image Resizing</label>
         </div>
         <small class="form-text text-right">Uploaded Images larger than the above size will be resized to their long edge. If either value is '0', resizing will be disabled.</small>
         <div class="row">
           <div class="col-12 col-md-6 pr-md-3">
             <label id="mediaMaxWidth" for="mediaMaxWidth"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxWidth" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Width">&#128279;</a>':'';?>Max Width</label>
             <div class="form-row">
               <input class="textinput" id="mMW" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidth" type="text" value="<?=$config['mediaMaxWidth'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
               <?=($user['options'][7]==1?'<button class="save" id="savemMW" data-dbid="mMW" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
             </div>
           </div>
           <div class="col-12 col-md-6 pl-md-3">
             <label id="mediaMaxHeight" for="mediaMaxHeight"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxHeight" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Height">&#128279;</a>':'';?>Max Height</label>
             <div class="form-row">
               <input class="textinput" id="mMH" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeight" type="text" value="<?=$config['mediaMaxHeight'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
               <?=($user['options'][7]==1?'<button class="save" id="savemMH" data-dbid="mMH" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
             </div>
           </div>
         </div>
         <div class="row">
           <div class="col-12 col-md-6 pr-md-3">
             <label id="mediaMaxWidthThumb" for="mediaMaxWidthThumb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxWidthThumb" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Width Thumb">&#128279;</a>':'';?>Max Thumb Width</label>
             <div class="form-row">
               <input class="textinput" id="mMWT" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidthThumb" type="text" value="<?=$config['mediaMaxWidthThumb'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
               <?=($user['options'][7]==1?'<button class="save" id="savemMWT" data-dbid="mMWT" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
             </div>
           </div>
           <div class="col-12 col-md-6 pl-md-3">
             <label id="mediaMaxHeightThumb" for="mediaMaxHeightThumb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxHeight" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Height">&#128279;</a>':'';?>Max Thumb Height</label>
             <div class="form-row">
               <input class="textinput" id="mMHT" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeightThumb" type="text" value="<?=$config['mediaMaxHeightThumb'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
               <?=($user['options'][7]==1?'<button class="save" id="savemMHT" data-dbid="mMHT" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
             </div>
           </div>
         </div>
         <label id="mediaQuality" for="mQ"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaQuality" data-tooltip="tooltip" aria-label="PermaLink to Image Quality">&#128279;</a>':'';?>Image Quality</label>
         <div class="form-row">
           <input class="textinput" id="mQ" data-dbid="1" data-dbt="config" data-dbc="mediaQuality" type="text" value="<?=$config['mediaQuality'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
           <?=($user['options'][7]==1?'<button class="save" id="savemQ" data-dbid="mQ" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
         </div>
         <legend id="mediaUnsplash" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaUnsplash" data-tooltip="tooltip" aria-label="PermaLink to Unsplash Settings">&#128279;</a>':'';?>Unsplash</legend>
         <label id="mediaunsplash_appname" for="unsplash_appname"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaunsplash_appname" data-tooltip="tooltip" aria-label="PermaLink to Unsplash App Name">&#128279;</a>':'';?>App Name</label>
         <div class="form-row">
           <input class="textinput" id="unsplash_appname" data-dbid="1" data-dbt="config" data-dbc="unsplash_appname" type="text" value="<?=$config['unsplash_appname'];?>"<?=($user['options'][7]==1?' placeholder="Unsplash Application Name"':' disabled');?>>
           <?=($user['options'][7]==1?'<button class="save" id="saveunsplash_appname" data-dbid="unsplash_appname" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
         </div>
         <label id="mediaunsplash_publickey">API Public Key</label>
         <div class="form-row">
           <input class="textinput" id="unsplash_publickey" data-dbid="1" data-dbt="config" data-dbc="unsplash_publickey" type="text" value="<?=$config['unsplash_publickey'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
           <?=($user['options'][7]==1?'<button class="save" id="saveunsplash_publickey" data-dbid="unsplash_publickey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
         </div>
         <label id="mediaunsplash_secretkey">API Secret Key</label>
         <div class="form-row">
           <input class="textinput" id="unsplash_secretkey" data-dbid="1" data-dbt="config" data-dbc="unsplash_secretkey" type="text" value="<?=$config['unsplash_secretkey'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
           <?=($user['options'][7]==1?'<button class="save" id="saveunsplash_secretkey" data-dbid="unsplash_secretkey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
         </div>
         <div class="form-row mt-3">
           <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaOptions0" data-tooltip="tooltip" aria-label="PermaLink to Enable Unsplash Search Browser">&#128279;</a>':'';?>
           <input id="mediaOptions0" data-dbid="1" data-dbt="config" data-dbc="mediaOptions" data-dbb="0" type="checkbox"<?=($config['mediaOptions'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
           <label class="p-0 mt-0 ml-3" for="mediaOptions0" id="configmedioaOptions0">Unsplash Search Browser</label>
         </div>
         <div class="form-row mt-3">
           <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaOptions1" data-tooltip="tooltip" aria-label="PermaLink to Enable Get Thumbnail from Unsplash">&#128279;</a>':'';?>
           <input id="mediaOptions1" data-dbid="1" data-dbt="config" data-dbc="mediaOptions" data-dbb="1" type="checkbox"<?=($config['mediaOptions'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
           <label class="p-0 mt-0 ml-3" for="mediaOptions1" id="configmediaOptions1">Get Thumbnail</label>
         </div>
       </div>
     </div>
     <?php require'core/layout/footer.php';?>
   </div>
 </section>
</main>
