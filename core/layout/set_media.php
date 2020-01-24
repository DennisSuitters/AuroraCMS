<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Media
 * @package    core/layout/set_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.11
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/media';?>">Media</a></li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h4 class="page-header">Image Processing</h4>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options2" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="2"<?php echo$config['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options2" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Image Resizing</label>
        </div>
        <div class="help-block text-muted small text-right">Uploaded Images larger than the above size will be resized to their long edge. If either value is '0', resizing will be disabled.</div>
        <div class="form-group row">
          <label for="mediaMaxWidth" class="control-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Max Width</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="mediaMaxWidth" class="form-control textinput" value="<?php echo$config['mediaMaxWidth'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidth">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savemediaMaxWidth" class="btn btn-secondary save" data-dbid="mediaMaxWidth" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaMaxHeight" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Max Height</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="mediaMaxHeight" class="form-control textinput" value="<?php echo$config['mediaMaxHeight'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeight">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savemediaMaxHeight" class="btn btn-secondary save" data-dbid="mediaMaxHeight" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaMaxWidthThumb" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Max Thumb Width</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="mediaMaxWidthThumb" class="form-control textinput" value="<?php echo$config['mediaMaxWidthThumb'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidthThumb">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savemediaMaxWidthThumb" class="btn btn-secondary save" data-dbid="mediaMaxWidthThumb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaMaxHeightThumb" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Max Thumb Height</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="mediaMaxHeightThumb" class="form-control textinput" value="<?php echo$config['mediaMaxHeightThumb'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeightThumb">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savemediaMaxHeightThumb" class="btn btn-secondary save" data-dbid="mediaMaxHeightThumb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaQuality" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Image Quality</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="mediaQuality" class="form-control textinput" value="<?php echo$config['mediaQuality'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaQuality">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savemediaQuality" class="btn btn-secondary save" data-dbid="mediaQuality" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
