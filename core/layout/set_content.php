<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Related Item Categories Checkbox
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.16 Add Brand/Manufacturer Items.
 * @changes    v0.0.18 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Content</li>
    <li class="breadcrumb-item active"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
        <a href="#" class="btn btn-ghost-normal saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields"><?php echo svg('save');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <legend>Related Content</legend>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options11" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11"<?php echo$config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options11" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable Related Content</label>
        </div>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options10" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10"<?php echo$config['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options10" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Display Similar Category if no Related Content items are selected</label>
        </div>
        <div class="form-group">
          <label for="showItems">Item Count</label>
          <div class="input-group">
            <input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="Enter Item Count...">
            <div class="input-group-append">
              <button id="saveshowItems" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="showItems" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <legend>Categories</legend>
        <form target="sp" method="POST" action="core/add_category.php">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Category</div>
              </div>
              <input type="text" id="cat" class="form-control" name="cat" placeholder="Enter a Category..." required aria-required="true">
              <div class="input-group-append">
                <div class="input-group-text">Content</div>
              </div>
              <select id="ct" class="form-control" name="ct">
                <option value="inventory">Inventory</option>
                <option value="services">Service</option>
                <option value="article">Article</option>
                <option value="gallery">Gallery</option>
                <option value="portfolio">Portfolio</option>
                <option value="proof">Proof</option>
                <option value="news">News</option>
                <option value="event">Event</option>
              </select>
              <div class="input-group-append">
                <div class="input-group-text">Image</div>
                <input type="hidden" id="icon" class="form-control" name="icon" value="" readonly>
                <button class="btn btn-secondary" onclick="elfinderDialog('1','category','icon');return false;" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button>
                <button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="category">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='category' ORDER BY url ASC, title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Category</div>
              </div>
              <input type="text" id="cat<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['title'];?>" readonly>
              <div class="input-group-prepend">
                <div class="input-group-text">Content</div>
              </div>
              <input type="text" id="ct<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['url'];?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">Image</div>
              </div>
              <div class="input-group-append">
                <?php echo$rs['icon']!=''&&file_exists('media'.DS.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-fancybox="lightbox"><img id="thumbimage" src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img id="thumbimage" src="core/images/noimage.png" alt="No Image">';?>
              </div>
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
        <legend>Brands</legend>
        <form target="sp" method="POST" action="core/add_brand.php">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Brand</div>
              </div>
              <input type="text" id="brandtitle" class="form-control" name="brandtitle" placeholder="Enter a Brand..." required aria-required="true">
              <div class="input-group-append">
                <div class="input-group-text">URL</div>
              </div>
              <input type="text" id="brandurl" class="form-control" name="brandurl" placeholder="Enter a URL...">
              <div class="input-group-text">Image</div>
              <div class="input-group-append">
                <input type="hidden" id="brandicon" class="form-control" name="brandicon" value="" readonly>
                <button class="btn btn-secondary" onclick="elfinderDialog('1','brand','brandicon');return false;" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button>
                <button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="brand">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='brand' ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">Brand</div>
              </div>
              <input type="text" id="title<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['title'];?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">URL</div>
              </div>
              <input type="text" id="url<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['url'];?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">Image</div>
              </div>
              <div class="input-group-append">
                <?php echo$rs['icon']!=''&&file_exists('media'.DS.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-lightbox="lightbox"><img id="thumbimage" src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img id="thumbimage" src="core/images/noimage.png" alt="No Image">';?>
              </div>
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
      </div>
    </div>
  </div>
</main>
