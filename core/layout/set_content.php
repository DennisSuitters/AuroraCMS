<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Content</li>
    <li class="breadcrumb-item active"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="showItems" class="col-form-label col-sm-2">Item Count</label>
          <div class="input-group col-sm-10">
            <input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="Enter Item Count...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveshowItems" class="btn btn-secondary save" data-dbid="showItems" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <legend>Categories</legend>
        <form target="sp" method="POST" action="core/add_category.php">
          <div class="form-group row">
            <div class="input-group col">
              <label for="cat" class="input-group-text">Category</label>
              <input type="text" id="cat" class="form-control" name="cat" placeholder="Enter a Category..." required aria-required="true">
              <label for="ct" class="input-group-text">Content</label>
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
              <div class="input-group-text">Image</div>
              <input type="text" id="icon" class="form-control" name="icon" value="" readonly>
              <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('1','category','icon');return false;" data-tooltip="tooltip" title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="Add" aria-label="Add"><?php svg('add');?></button></div>
            </div>
          </div>
        </form>
        <div id="category">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='category' ORDER BY url ASC, title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group col">
              <label for="cat<?php echo$rs['id'];?>" class="input-group-text">Category</label>
              <input type="text" id="cat<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['title'];?>" readonly>
              <label for="ct<?php echo$rs['id'];?>" class="input-group-text">Content</label>
              <input type="text" id="ct<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['url'];?>" readonly>
              <div class="input-group-text">Image</div>
              <div class="input-group-append img"><?php echo$rs['icon']!=''&&file_exists('media'.DS.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-lightbox="lightbox"><img id="thumbimage" src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img id="thumbimage" src="core/images/noimage.png" alt="No Image">';?></div>
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
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
