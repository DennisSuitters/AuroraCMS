<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Media
 * @package    core/layout/set_media.php
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
         <div>Media Settings</div>
         <div class="content-title-actions">
           <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
           <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php svg('save');?></button>
         </div>
       </div>
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
         <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/media';?>">Media</a></li>
         <li class="breadcrumb-item active">Settings</li>
       </ol>
     </div>
   </div>
   <div class="container-fluid p-0">
     <div class="card border-radius-0 shadow p-3">
       <legend class="mt-3">Image Processing</legend>
       <div class="row mt-3">
         <input id="options2" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="2" type="checkbox"<?php echo$config['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
         <label for="options2">Image Resizing</label>
       </div>
       <small class="form-text text-right">Uploaded Images larger than the above size will be resized to their long edge. If either value is '0', resizing will be disabled.</small>
       <div class="row">
         <div class="col-12 col-md-6 pr-md-1">
           <label for="mediaMaxWidth">Max Width</label>
           <div class="form-row">
             <input class="textinput" id="mediaMaxWidth" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidth" type="text" value="<?php echo$config['mediaMaxWidth'];?>">
             <button class="save" id="savemediaMaxWidth" data-tooltip="tooltip" data-dbid="mediaMaxWidth" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
           </div>
         </div>
         <div class="col-12 col-md-6 pl-md-1">
           <label for="mediaMaxHeight">Max Height</label>
           <div class="form-row">
             <input class="textinput" id="mediaMaxHeight" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeight" type="text" value="<?php echo$config['mediaMaxHeight'];?>">
             <button class="save" id="savemediaMaxHeight" data-tooltip="tooltip" data-dbid="mediaMaxHeight" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-12 col-md-6 pr-md-1">
           <label for="mediaMaxWidthThumb">Max Thumb Width</label>
           <div class="form-row">
             <input class="textinput" id="mediaMaxWidthThumb" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidthThumb" type="text" value="<?php echo$config['mediaMaxWidthThumb'];?>">
             <button class="save" id="savemediaMaxWidthThumb" data-tooltip="tooltip" data-dbid="mediaMaxWidthThumb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
           </div>
         </div>
         <div class="col-12 col-md-6 pl-md-1">
           <label for="mediaMaxHeightThumb">Max Thumb Height</label>
           <div class="form-row">
             <input class="textinput" id="mediaMaxHeightThumb" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeightThumb" type="text" value="<?php echo$config['mediaMaxHeightThumb'];?>">
             <button class="save" id="savemediaMaxHeightThumb" data-tooltip="tooltip" data-dbid="mediaMaxHeightThumb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
           </div>
         </div>
       </div>
       <label for="mediaQuality">Image Quality</label>
       <div class="form-row">
         <input class="textinput" id="mediaQuality" data-dbid="1" data-dbt="config" data-dbc="mediaQuality" type="text" value="<?php echo$config['mediaQuality'];?>">
         <button class="save" id="savemediaQuality" data-tooltip="tooltip" data-dbid="mediaQuality" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
       </div>
       <?php require'core/layout/footer.php';?>
     </div>
   </div>
 </section>
</main>
