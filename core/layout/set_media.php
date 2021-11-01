<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Media
 * @package    core/layout/set_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
 <section id="content">
   <div class="content-title-wrapper mb-0">
     <div class="content-title">
       <div class="content-title-heading">
         <div class="content-title-icon"><?= svg2('users','i-3x');?></div>
         <div>Media Settings</div>
         <div class="content-title-actions">
           <?php if(isset($_SERVER['HTTP_REFERER'])){?>
             <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="tooltip" aria-label="Back"><?= svg2('back');?></a>
           <?php }?>
           <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
         </div>
       </div>
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
         <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/media';?>">Media</a></li>
         <li class="breadcrumb-item active">Settings</li>
       </ol>
     </div>
   </div>
   <div class="container-fluid p-0">
     <div class="card border-radius-0 px-4 py-3 overflow-visible">
       <legend id="mediaProcessing" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaProcessing" data-tooltip="tooltip" aria-label="PermaLink to Enable Image Processing Checkbox">&#128279;</a>':'';?>Image Processing</legend>
       <div class="row mt-3">
         <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#imageResizing" data-tooltip="tooltip" aria-label="PermaLink to Enable Image Resizing Checkbox">&#128279;</a>':'';?>
         <input id="mediaResizing" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="2" type="checkbox"<?=$config['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
         <label for="mediaResizing" id="configoptions21">Image Resizing</label>
       </div>
       <small class="form-text text-right">Uploaded Images larger than the above size will be resized to their long edge. If either value is '0', resizing will be disabled.</small>
       <div class="row">
         <div class="col-12 col-md-6 pr-md-3">
           <label id="mediaMaxWidth" for="mediaMaxWidth"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxWidth" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Width">&#128279;</a>':'';?>Max Width</label>
           <div class="form-row">
             <input class="textinput" id="mMW" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidth" type="text" value="<?=$config['mediaMaxWidth'];?>">
             <button class="save" id="savemMW" data-dbid="mMW" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
           </div>
         </div>
         <div class="col-12 col-md-6 pl-md-3">
           <label id="mediaMaxHeight" for="mediaMaxHeight"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxHeight" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Height">&#128279;</a>':'';?>Max Height</label>
           <div class="form-row">
             <input class="textinput" id="mMH" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeight" type="text" value="<?=$config['mediaMaxHeight'];?>">
             <button class="save" id="savemMH" data-dbid="mMH" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-12 col-md-6 pr-md-3">
           <label id="mediaMaxWidthThumb" for="mediaMaxWidthThumb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxWidthThumb" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Width Thumb">&#128279;</a>':'';?>Max Thumb Width</label>
           <div class="form-row">
             <input class="textinput" id="mMWT" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidthThumb" type="text" value="<?=$config['mediaMaxWidthThumb'];?>">
             <button class="save" id="savemMWT" data-dbid="mMWT" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
           </div>
         </div>
         <div class="col-12 col-md-6 pl-md-3">
           <label id="mediaMaxHeightThumb" for="mediaMaxHeightThumb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaMaxHeight" data-tooltip="tooltip" aria-label="PermaLink to Image Maximum Height">&#128279;</a>':'';?>Max Thumb Height</label>
           <div class="form-row">
             <input class="textinput" id="mMHT" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeightThumb" type="text" value="<?=$config['mediaMaxHeightThumb'];?>">
             <button class="save" id="savemMHT" data-dbid="mMHT" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
           </div>
         </div>
       </div>
       <label id="mediaQuality" for="mediaQuality"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#mediaQuality" data-tooltip="tooltip" aria-label="PermaLink to Image Quality">&#128279;</a>':'';?>Image Quality</label>
       <div class="form-row">
         <input class="textinput" id="mQ" data-dbid="1" data-dbt="config" data-dbc="mediaQuality" type="text" value="<?=$config['mediaQuality'];?>">
         <button class="save" id="savemQ" data-dbid="mQ" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
       </div>
       <?php require'core/layout/footer.php';?>
     </div>
   </div>
 </section>
</main>
