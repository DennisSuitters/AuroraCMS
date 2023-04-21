<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
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
                <li class="breadcrumb-item active">Settings</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="m-4">
          <legend id="relatedContentSection"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#relatedContentSection" data-tooltip="tooltip" aria-label="PermaLink to Content Related Content Section">&#128279;</a>':'';?>Related Content</legend>
          <div class="row">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#enableRelated" data-tooltip="tooltip" aria-label="PermaLink to Enable Related Content Checkbox">&#128279;</a>':'';?>
            <input id="enableRelated" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?=($config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
            <label for="enableRelated" id="configoptions111">Enable Related Content</label>
          </div>
          <div class="row">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#displaySimilar" data-tooltip="tooltip" aria-label="PermaLink to Content Display Similar Content Checkbox">&#128279;</a>':'';?>
            <input id="displaySimilar" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10" type="checkbox"<?=($config['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
            <label for="displaySimilar" id="configoptions101">Display Similar Category if no Related Content items are selected</label>
          </div>
          <label id="contentDefaultOrder" for="defaultOrder"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#contentDefaultOrder" data-tooltip="tooltip" aria-label="PermaLink to Content Display Order Selector">&#128279;</a>':'';?>Default Order for Content Items</label>
          <div class="form-row">
            <select id="defaultOrder" data-dbid="1" data-dbt="config" data-dbc="defaultOrder"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`defaultOrder`,$(this).val(),`select`);"':' disabled';?>>
              <option value="new"<?=$config['defaultOrder']=='new'?' selected':'';?>>Newest</option>
              <option value="old"<?=$config['defaultOrder']=='old'?' selected':'';?>>Oldest</option>
              <option value="namea"<?=$config['defaultOrder']=='namea'?' selected':'';?>>Name: A-Z</option>
              <option value="namez"<?=$config['defaultOrder']=='namez'?' selected':'';?>>Name: Z-A</option>
              <option value="view"<?=$config['defaultOrder']=='view'?' selected':'';?>>Most viewed</option>
            </select>
          </div>
          <label id="itemCount" for="showItems"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#itemCount" data-tooltip="tooltip" aria-label="PermaLink to Content Item Count Field">&#128279;</a>':'';?>Item Count</label>
          <?=($user['options'][7]==1?'<small class="form-text text-muted">\'0\' to Disable and display all items.</small>':'');?>
          <div class="form-row">
            <input class="textinput" id="showItems" data-dbid="1" data-dbt="config" data-dbc="showItems" type="text" value="<?=$config['showItems'];?>"<?=($user['options'][7]==1?' placeholder="Enter Item Count..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="saveshowItems" data-dbid="showItems" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="searchItemCount" for="searchItems"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#searchItemCount" data-tooltip="tooltip" aria-label="PermaLink to Search Item Count Field">&#128279;</a>':'';?>Search Items Count</label>
          <?=($user['options'][7]==1?'<small class="form-text text-muted">\'0\' to Default to 10 items.</small>':'');?>
          <div class="form-row">
            <input class="textinput" id="searchItems" data-dbid="1" data-dbt="config" data-dbc="searchItems" type="text" value="<?=$config['searchItems'];?>"<?=($user['options'][7]==1?' placeholder="Enter Search Items Count..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesearchItems" data-dbid="searchItems" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <div class="row mt-3">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#enableSalesPeriods" data-tooltip="tooltip" aria-label="PermaLink to Calculate Sales Periods Checkbox">&#128279;</a>':'';?>
            <input id="enableSalesPeriods" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="28" type="checkbox"<?=($config['options'][28]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
            <label for="enableSalesPeriods" id="configoptions281">Calculate Sales Periods</label>
          </div>
          <label id="saleHeadingValentineField" for="saleHeadingvalentine"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingValentineField" data-tooltip="tooltip" aria-label="PermaLink to Valentine Sale Heading Field">&#128279;</a>':'';?>Valentine Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadingvalentine" data-dbid="1" data-dbt="config" data-dbc="saleHeadingvalentine" type="text" value="<?=$config['saleHeadingvalentine'];?>"<?=($user['options'][7]==1?' placeholder="Enter Valentine Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingvalentine" data-dbid="saleHeadingvalentine" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="saleHeadingEasterField" for="saleHeadingeaster"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingEasterField" data-tooltip="tooltip" aria-label="PermaLink to Easter Sale Heading Field">&#128279;</a>':'';?>Easter Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadingeaster" data-dbid="1" data-dbt="config" data-dbc="saleHeadingeaster" type="text" value="<?=$config['saleHeadingeaster'];?>"<?=($user['options'][7]==1?' placeholder="Enter Easter Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingeaster" data-dbid="saleHeadingeaster" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="saleHeadingMothersDayField" for="saleHeadingmothersday"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingMothersDayField" data-tooltip="tooltip" aria-label="PermaLink to Mother\'s Day Sale Heading Field">&#128279;</a>':'';?>Mother's Day Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadingmothersday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingmothersday" type="text" value="<?=$config['saleHeadingmothersday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Mother\'s Day Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingmothersday" data-dbid="saleHeadingmothersday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="saleHeadingFathersDayField" for="saleHeadingfathersday"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingFathersDayField" data-tooltip="tooltip" aria-label="PermaLink to Father\'s Day Sale Heading Field">&#128279;</a>':'';?>Father's Day Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadingfathersday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingfathersday" type="text" value="<?=$config['saleHeadingfathersday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Father\'s Day Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingfathersday" data-dbid="saleHeadingfathersday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="saleHeadingBlackFridayField" for="saleHeadingblackfriday"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingBlackFridayField" data-tooltip="tooltip" aria-label="PermaLink to Black Friday Sale Heading Field">&#128279;</a>':'';?>Black Friday Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadingblackfriday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingblackfriday" type="text" value="<?=$config['saleHeadingblackfriday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Black Friday Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingblackfriday" data-dbid="saleHeadingblackfriday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="saleHeadingHalloweenField" for="saleHeadinghalloween"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingHalloweenField" data-tooltip="tooltip" aria-label="PermaLink to Halloween Sale Heading Field">&#128279;</a>':'';?>Halloween Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadinghalloween" data-dbid="1" data-dbt="config" data-dbc="saleHeadinghalloween" type="text" value="<?=$config['saleHeadinghalloween'];?>"<?=($user['options'][7]==1?' placeholder="Enter Halloween Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadinghalloween" data-dbid="saleHeadinghalloween" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="saleHeadingSmallBusinessDayField" for="saleHeadingsmallbusinessday"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingSmallBusinessDayField" data-tooltip="tooltip" aria-label="PermaLink to Small Business Day Sale Heading Field">&#128279;</a>':'';?>Small Business Day Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadingsmallbusinessday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingsmallbusinessday" type="text" value="<?=$config['saleHeadingsmallbusinessday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Small Business Day Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingsmallbusinessday" data-dbid="saleHeadingsmallbusinessday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <label id="saleHeadingChristmasField" for="saleHeadingchristmas"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#saleHeadingChristmasField" data-tooltip="tooltip" aria-label="PermaLink to Christmas Sale Heading Field">&#128279;</a>':'';?>Christmas Sale Heading</label>
          <div class="form-row">
            <input class="textinput" id="saleHeadingchristmas" data-dbid="1" data-dbt="config" data-dbc="saleHeadingchristmas" type="text" value="<?=$config['saleHeadingchristmas'];?>"<?=($user['options'][7]==1?' placeholder="Enter Christmas Sale Heading..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingchristmas" data-dbid="saleHeadingchristmas" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <div class="row mt-3">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#enableQuickView" data-tooltip="tooltip" aria-label="PermaLink to Content Quick View Checkbox">&#128279;</a>':'';?>
            <input id="enableQuickView" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="5" type="checkbox"<?=($config['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
            <label for="enableQuickView" id="configoptions51">Quick View for Products &amp; Gallery</label>
          </div>
          <label id="fallbackStatus" for="inventoryFallbackStatus"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#fallbackStatus" data-tooltip="tooltip" aria-label="PermaLink to Inventory Fallback Status Selector">&#128279;</a>':'';?>Fallback Status</label>
          <div class="form-row">
            <select id="inventoryFallbackStatus"<?=($user['options'][7]==1?' data-tooltip="tooltip" aria-label="Change Fallback Stock Status" onchange="update(`1`,`config`,`inventoryFallbackStatus`,$(this).val(),`select`);"':' disabled');?> >
              <option value="out of stock"<?=$config['inventoryFallbackStatus']=='out of stock'?' selected':'';?>>Out Of Stock</option>
              <option value="back order"<?=$config['inventoryFallbackStatus']=='back order'?' selected':'';?>>Back Order</option>
              <option value="pre order"<?=$config['inventoryFallbackStatus']=='pre-order'?' selected':'';?>>Pre Order</option>
              <option value="sold out"<?=$config['inventoryFallbackStatus']=='sold out'?' selected':'';?>>Sold Out</option>
              <option value="none"<?=($config['inventoryFallbackStatus']=='none'||$config['inventoryFallbackStatus']==''?' selected':'');?>>No Display</option>
            </select>
          </div>
          <legend id="categoriesSection" class="mt-3 mb-0"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#categoriesSection" data-tooltip="tooltip" aria-label="PermaLink to Categories Section">&#128279;</a>':'';?>Categories</legend>
          <div class="row mt-3">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#enableCategoryNavigation" data-tooltip="tooltip" aria-label="PermaLink to Category Navigation Checkbox">&#128279;</a>':'';?>
            <input id="enableCategoryNavigation" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="31" type="checkbox"<?=($config['options'][31]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
            <label for="enableCategoryNavigation" id="configoptions311">Category Navigation</label>
          </div>
          <?php if($user['options'][7]==1){?>
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
                    <button onclick="elfinderDialog('1','category','icon');return false;" data-tooltip="tooltip" aria-label="Open Media Manager"><i class="i">browse-media</i></button>
                    <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </div>
              </div>
            </form>
          <?php }else{?>
            <div class="row">
              <div class="col-12 col-md-6"><label>Category</label></div>
              <div class="col-12 col-md-5"><label>Content</label></div>
              <div class="col-12 col-md-1">&nbsp;</div>
            </div>
          <?php }?>
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
                    <?php echo$rs['icon']!=''&&file_exists('media/'.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-fancybox="lightbox"><img src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img src="'.ADMINNOIMAGE.'" alt="No Image">';
                    if($user['options'][7]==1){?>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$rs['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    <?php }?>
                  </div>
                </div>
              </div>
            <?php }?>
          </div>
          <legend id="brandSection" class="mt-3 mb-0"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#brandSection" data-tooltip="tooltip" aria-label="PermaLink to Brands Section">&#128279;</a>':'';?>Brands</legend>
          <?php if($user['options'][7]==1){?>
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
                    <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('1','brand','brandicon');return false;"><i class="i">browse-media</i></button>
                    <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </div>
              </div>
            </form>
          <?php }else{?>
            <div class="row">
              <div class="col-12 col-md-6"><label>Brand</label></div>
              <div class="col-12 col-md-5"><label>URL</label></div>
              <div class="col-12 col-md-1">&nbsp;</div>
            </div>
          <?php }?>
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
                    <?php echo$rs['icon']!=''&&file_exists('media/'.basename($rs['icon']))?'<a href="'.$rs['icon'].'" data-fancybox="lightbox"><img src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img src="'.ADMINNOIMAGE.'" alt="No Image">';
                    if($user['options'][7]==1){?>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$rs['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="trash" type="submit" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    <?php }?>
                  </div>
                </div>
              </div>
            <?php }?>
          </div>
          <legend id="templateSection" class="mt-3 mb-0"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#templateSection" data-tooltip="tooltip" aria-label="PermaLink to Template Section">&#128279;</a>':'';?>Template Defaults</legend>
          <label id="templateQTYField" for="templateQTY"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#templateQTYField" data-tooltip="tooltip" aria-label="PermaLink to Item Template Quantity Field">&#128279;</a>':'';?>Item Template Quantity</label>
          <?=($user['options'][7]==1?'<small class="form-text text-muted">\'0\' to Disable.</small>':'');?>
          <div class="form-row">
            <input class="textinput" id="templateQTY" data-dbid="1" data-dbt="config" data-dbc="templateQTY" type="text" value="<?=$config['templateQTY'];?>"<?=($user['options'][7]==1?' placeholder="Enter Template Item Quantity..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button class="save" id="savetemplateQTY" data-dbid="templateQTY" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
          </div>
          <section class="content overflow-visible theme-chooser mt-5" id="templates">
            <article class="card col-6 col-sm-2 m-1 m-sm-2 overflow-visible theme<?=$config['templateID']==0?' theme-selected':'';?>" id="l_0" data-template="0">
              <figure class="card-image">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 180" fill="none"></svg>
                <div class="image-toolbar overflow-visible">
                  <i class="i icon enable text-white i-4x pt-2 pr-1">approve</i>
                </div>
              </figure>
              <div class="card-header line-clamp">
                Theme Generated
              </div>
              <div class="card-body no-clamp">
                <p class="small"><small>This selection uses the item template in the theme file.</small></p>
              </div>
            </article>
            <?php $st=$db->prepare("SELECT * FROM `".$prefix."templates` WHERE `contentType`='all' ORDER BY `contentType` ASC, `section` ASC");
            $st->execute();
            while($rt=$st->fetch(PDO::FETCH_ASSOC)){?>
              <article class="card col-6 col-sm-2 m-1 m-sm-2 overflow-visible theme<?=$rt['id']==$config['templateID']?' theme-selected':'';?>" id="l_<?=$rt['id'];?>" data-template="<?=$rt['id'];?>">
                <figure class="card-image position-relative overflow-visible">
                  <?=$rt['image'];?>
                  <div class="image-toolbar overflow-visible">
                    <i class="i icon enable text-white i-4x pt-2 pr-1">approve</i>
                  </div>
                </figure>
                <div class="card-header line-clamp">
                  <?=$rt['title'];?>
                </div>
                <div class="card-body no-clamp">
                  <p class="small"><small><?=$rt['notes'];?></small></p>
                </div>
              </article>
            <?php }?>
          </section>
          <?php if($user['options'][7]==1){?>
            <script>
              $(".theme-chooser").not(".disabled").find("figure.card-image").on("click",function(){
                $('#templates .theme').removeClass("theme-selected");
                $(this).parent('article').addClass("theme-selected");
                $('#notheme').addClass("hidden");
                $.ajax({
                  type:"GET",
                  url:"core/update.php",
                  data:{
                    id:"1",
                    t:"config",
                    c:"templateID",
                    da:$(this).parent('article').attr("data-template")
                  }
                });
              });
            </script>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
