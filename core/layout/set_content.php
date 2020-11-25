<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
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
          <div>Content Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" data-title="Back" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <button data-tooltip="tooltip" data-title="Toggle Fullscreen" aria-label"Toggle Fullscreen" onclick="toggleFullscreen();"><?php svg('fullscreen');?></button>
            <button class="saveall" data-tooltip="tooltip" data-title="Save All Edited Fields" aria-label="Save All Edited Fields"><?php svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <legend>Related Content</legend>
        <div class="row">
          <input id="options11" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?php echo$config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options11">Enable Related Content</label>
        </div>
        <div class="row">
          <input id="options10" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10" type="checkbox"<?php echo$config['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options10">Display Similar Category if no Related Content items are selected</label>
        </div>
        <label for="showItems">Item Count</label>
        <div class="form-row">
          <input class="textinput" id="showItems" data-dbid="1" data-dbt="config" data-dbc="showItems" type="text" value="<?php echo$config['showItems'];?>" placeholder="Enter Item Count...">
          <button class="save" id="saveshowItems" data-tooltip="tooltip" data-title="Save" data-dbid="showItems" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="row mt-3">
          <input id="options5" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="5" type="checkbox"<?php echo$config['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options5">Quick View for Products</label>
        </div>
        <legend class="mt-3 mb-0">Categories</legend>
        <form target="sp" method="POST" action="core/add_category.php">
          <div class="row">
            <div class="col-12 col-md-6">
              <label for="cat">Category</label>
              <div class="form-row">
                <input id="cat" name="cat" type="text" placeholder="Enter a Category..." required aria-required="true">
              </div>
            </div>
            <div class="col-12 col-md-5">
              <label for="ct">Content</label>
              <div class="form-row">
                <select id="ct" name="ct">
<?php $sc=$db->prepare("SELECT DISTINCT(`contentType`) FROM `".$prefix."content` WHERE `contentType`!='' ORDER BY contentType ASC");
$sc->execute();
while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['contentType'].'">'.ucfirst($rc['contentType']).'</option>';?>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-1">
              <label for="icon">&nbsp;</label>
              <div class="form-row">
                <input id="icon" name="icon" type="hidden" value="" readonly>
                <button data-tooltip="tooltip" data-title="Open Media Manager" onclick="elfinderDialog('1','category','icon');return false;" aria-label="Add Image via Media Manager"><?php svg('browse-media');?></button>
                <button class="add" data-tooltip="tooltip" data-title="Add" type="submit" aria-label="Add"><?php svg('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="category">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='category' ORDER BY `url` ASC,`title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="row mt-1">
              <div class="col-12 col-md-6">
                <div class="form-row">
                  <input type="text" value="<?php echo$rs['title'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-5">
                <div class="form-row">
                  <input type="text" value="<?php echo$rs['url'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-1">
                <div class="form-row">
                  <?php echo$rs['icon']!=''&&file_exists('media'.DS.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-fancybox="lightbox"><img src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                  </form>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
        <legend class="mt-3 mb-0">Brands</legend>
        <form target="sp" method="post" action="core/add_brand.php">
          <div class="row">
            <div class="col-12 col-md-6">
              <label dor="brandtitle">Brand</label>
              <div class="form-row">
                <input id="brandtitle" name="brandtitle" type="text" placeholder="Enter a Brand..." required aria-required="true">
              </div>
            </div>
            <div class="col-12 col-md-5">
              <label for="brandurl">URL</label>
              <div class="form-row">
                <input id="brandurl" name="brandurl" type="text" placeholder="Enter a URL...">
              </div>
            </div>
            <div class="col-12 col-md-1">
              <label for="brandicon">&nbsp;</label>
              <div class="form-row">
                <input id="brandicon" name="brandicon" type="hidden" value="" readonly>
                <button data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Add Image via Media Manager" onclick="elfinderDialog('1','brand','brandicon');return false;"><?php svg('browse-media');?></button>
                <button class="add" data-tooltip="tooltip" data-title="Add" type="submit" aria-label="Add"><?php svg('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="brand">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='brand' ORDER BY `title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="row mt-1">
              <div class="col-12 col-md-6">
                <div class="form-row">
                  <input id="title<?php echo$rs['id'];?>" type="text" value="<?php echo$rs['title'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-5">
                <div class="form-row">
                  <input id="url<?php echo$rs['id'];?>" type="text" value="<?php echo$rs['url'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-1">
                <div class="form-row">
                  <?php echo$rs['icon']!=''&&file_exists('media'.DS.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-fancybox="lightbox"><img src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" data-title="Delete" type="submit" aria-label="Delete"><?php svg('trash');?></button>
                  </form>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
