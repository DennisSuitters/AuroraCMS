<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('content','i-3x');?></div>
          <div>Content Settings</div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?= svg2('back');?></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <legend id="relatedContentSection"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#relatedContentSection" aria-label="PermaLink to Content Related Content Section">&#128279;</a>':'';?>Related Content</legend>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#enableRelated" aria-label="PermaLink to Enable Related Content Checkbox">&#128279;</a>':'';?>
          <input id="enableRelated" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?=$config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="enableRelated" id="configoptions111">Enable Related Content</label>
        </div>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#displaySimilar" aria-label="PermaLink to Content Display Similar Content Checkbox">&#128279;</a>':'';?>
          <input id="displaySimilar" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10" type="checkbox"<?=$config['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="displaySimilar" id="configoptions101">Display Similar Category if no Related Content items are selected</label>
        </div>
        <label id="contentDefaultOrder" for="defaultOrder"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#contentDefaultOrder" aria-label="PermaLink to Content Display Order Selector">&#128279;</a>':'';?>Default Order for Content Items</label>
        <div class="form-row">
          <select id="defaultOrder" data-dbid="1" data-dbt="config" data-dbc="defaultOrder" onchange="update('1','config','defaultOrder',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
            <option value="new"<?=$config['defaultOrder']=='new'?' selected':'';?>>Newest</option>
            <option value="old"<?=$config['defaultOrder']=='old'?' selected':'';?>>Oldest</option>
            <option value="namea"<?=$config['defaultOrder']=='namea'?' selected':'';?>>Name: A-Z</option>
            <option value="namez"<?=$config['defaultOrder']=='namez'?' selected':'';?>>Name: Z-A</option>
            <option value="view"<?=$config['defaultOrder']=='view'?' selected':'';?>>Most viewed</option>
          </select>
        </div>
        <label id="itemCount" for="showItems"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#itemCount" aria-label="PermaLink to Content Item Count Field">&#128279;</a>':'';?>Item Count</label>
        <div class="form-row">
          <input class="textinput" id="showItems" data-dbid="1" data-dbt="config" data-dbc="showItems" type="text" value="<?=$config['showItems'];?>" placeholder="Enter Item Count...">
          <button class="save" id="saveshowItems" data-tooltip="tooltip" data-dbid="showItems" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <small class="form-text text-muted">'0' to Disable and display all items.</small>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#enableQuickView" aria-label="PermaLink to Content Quick View Checkbox">&#128279;</a>':'';?>
          <input id="enableQuickView" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="5" type="checkbox"<?=$config['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="enableQuickView" id="configoptions51">Quick View for Products</label>
        </div>
        <legend id="categoriesSection" class="mt-3 mb-0"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#categoriesSection" aria-label="PermaLink to Categories Section">&#128279;</a>':'';?>Categories</legend>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#enableCategoryNavigation" aria-label="PermaLink to Category Navigation Checkbox">&#128279;</a>':'';?>
          <input id="enableCategoryNavigation" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="31" type="checkbox"<?=$config['options'][31]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="enableCategoryNavigation" id="configoptions311">Category Navigation</label>
        </div>
        <form target="sp" method="post" action="core/add_category.php">
          <div class="row">
            <div class="col-12 col-md-6">
              <label for="cat">Category</label>
              <div class="form-row">
                <input id="cat" name="cat" type="text" placeholder="Enter or Select a Category..." required aria-required="true">
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
                <button data-tooltip="tooltip" onclick="elfinderDialog('1','category','icon');return false;" aria-label="Open Media Manager"><?= svg2('browse-media');?></button>
                <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?= svg2('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="category">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='category' ORDER BY `contentType` ASC,`title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?=$rs['id'];?>" class="row mt-1">
              <div class="col-12 col-md-6">
                <div class="form-row">
                  <input type="text" value="<?=$rs['title'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-5">
                <div class="form-row">
                  <input type="text" value="<?=$rs['url'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-1">
                <div class="form-row">
                  <?=$rs['icon']!=''&&file_exists('media/'.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-fancybox="lightbox"><img src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?=$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?= svg2('trash');?></button>
                  </form>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
        <legend id="brandSection" class="mt-3 mb-0"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#brandSection" aria-label="PermaLink to Brands Section">&#128279;</a>':'';?>Brands</legend>
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
                <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('1','brand','brandicon');return false;"><?= svg2('browse-media');?></button>
                <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?= svg2('add');?></button>
              </div>
            </div>
          </div>
        </form>
        <div id="brand">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='brand' ORDER BY `title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?=$rs['id'];?>" class="row mt-1">
              <div class="col-12 col-md-6">
                <div class="form-row">
                  <input id="title<?=$rs['id'];?>" type="text" value="<?=$rs['title'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-5">
                <div class="form-row">
                  <input id="url<?=$rs['id'];?>" type="text" value="<?=$rs['url'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-1">
                <div class="form-row">
                  <?=$rs['icon']!=''&&file_exists('media/'.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-fancybox="lightbox"><img src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?=$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><?= svg2('trash');?></button>
                  </form>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
