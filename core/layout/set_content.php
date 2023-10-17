<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
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
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Inventory</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Notifications</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Templates</label>
<?php /* Tab 1 General */ ?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <label for="defaultOrder">Default Order for Content Items</label>
            <div class="form-row">
              <select id="defaultOrder" data-dbid="1" data-dbt="config" data-dbc="defaultOrder"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`defaultOrder`,$(this).val(),`select`);"':' disabled';?>>
                <option value="new"<?=$config['defaultOrder']=='new'?' selected':'';?>>Newest</option>
                <option value="old"<?=$config['defaultOrder']=='old'?' selected':'';?>>Oldest</option>
                <option value="namea"<?=$config['defaultOrder']=='namea'?' selected':'';?>>Name: A-Z</option>
                <option value="namez"<?=$config['defaultOrder']=='namez'?' selected':'';?>>Name: Z-A</option>
                <option value="view"<?=$config['defaultOrder']=='view'?' selected':'';?>>Most viewed</option>
              </select>
            </div>
            <label for="showItems">Item Count</label>
            <?=($user['options'][7]==1?'<div class="form-text">\'0\' to Disable and display all items. &lt;settings itemCount="[num/all]"&gt; overrides this setting.</div>':'');?>
            <div class="form-row">
              <input class="textinput" id="showItems" data-dbid="1" data-dbt="config" data-dbc="showItems" type="text" value="<?=$config['showItems'];?>"<?=($user['options'][7]==1?' placeholder="Enter Item Count..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="saveshowItems" data-dbid="showItems" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="searchItems">Search Items Count</label>
            <?=($user['options'][7]==1?'<div class="form-text">\'0\' to Default to 10 items.</div>':'');?>
            <div class="form-row">
              <input class="textinput" id="searchItems" data-dbid="1" data-dbt="config" data-dbc="searchItems" type="text" value="<?=$config['searchItems'];?>"<?=($user['options'][7]==1?' placeholder="Enter Search Items Count..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesearchItems" data-dbid="searchItems" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <hr>
            <legend>Related Content</legend>
            <div class="form-row mt-1">
              <input id="enableRelated" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?=($config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="enableRelated">Enable Related Content</label>
            </div>
            <div class="form-row">
              <input id="displaySimilar" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10" type="checkbox"<?=($config['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="displaySimilar">Display Similar Category if no Related Content items are selected</label>
            </div>
            <hr>
            <legend>Categories</legend>
            <div class="form-row mb-1">
              <input id="enableCategoryNavigation" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="31" type="checkbox"<?=($config['options'][31]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="enableCategoryNavigation">Category Navigation</label>
            </div>
            <div class="sticky-top">
              <div class="row">
                <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                  <div class="row">
                    <div class="col-12 col-md pl-2">Category</div>
                    <div class="col-12 col-md pl-2">Content Type</div>
                    <div class="col-12 col-md-1 pl-2">Icon</div>
                  </div>
                </article>
              </div>
              <?php if($user['options'][7]==1){?>
                <form class="row" target="sp" method="post" action="core/add_category.php">
                  <div class="col-12 col-md">
                    <input id="cat" name="cat" type="text" placeholder="Enter or Select a Category...">
                  </div>
                  <div class="col-12 col-md">
                    <select id="ct" name="ct">
                      <?php $sc=$db->prepare("SELECT DISTINCT(`contentType`) FROM `".$prefix."content` WHERE `contentType`!='' ORDER BY contentType ASC");
                      $sc->execute();
                      while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['contentType'].'">'.ucfirst($rc['contentType']).'</option>';?>
                    </select>
                  </div>
                  <div class="col-12 col-md-1">
                    <div class="form-row">
                      <input id="icon" name="icon" type="hidden" value="" readonly>
                      <button onclick="elfinderDialog('1','category','icon');return false;" data-tooltip="tooltip" aria-label="Open Media Manager"><i class="i">browse-media</i></button>
                      <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                    </div>
                  </div>
                </form>
              <?php }?>
            </div>
            <div id="category">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='category' ORDER BY `contentType` ASC,`title` ASC");
              $ss->execute();
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?=$rs['id'];?>" class="row">
                  <div class="col-12 col-md">
                    <div class="input-text"><?=$rs['title'];?></div>
                  </div>
                  <div class="col-12 col-md">
                    <div class="input-text"><?=$rs['url'];?></div>
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
          </div>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <div class="form-row mt-3">
              <input id="enableQuickView" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="5" type="checkbox"<?=($config['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="enableQuickView">Quick View for Products &amp; Gallery</label>
            </div>
            <label for="inventoryFallbackStatus">Fallback Status</label>
            <div class="form-row">
              <select id="inventoryFallbackStatus"<?=($user['options'][7]==1?' data-tooltip="tooltip" aria-label="Change Fallback Stock Status" onchange="update(`1`,`config`,`inventoryFallbackStatus`,$(this).val(),`select`);"':' disabled');?> >
                <option value="out of stock"<?=$config['inventoryFallbackStatus']=='out of stock'?' selected':'';?>>Out Of Stock</option>
                <option value="back order"<?=$config['inventoryFallbackStatus']=='back order'?' selected':'';?>>Back Order</option>
                <option value="pre order"<?=$config['inventoryFallbackStatus']=='pre-order'?' selected':'';?>>Pre Order</option>
                <option value="sold out"<?=$config['inventoryFallbackStatus']=='sold out'?' selected':'';?>>Sold Out</option>
                <option value="none"<?=($config['inventoryFallbackStatus']=='none'||$config['inventoryFallbackStatus']==''?' selected':'');?>>No Display</option>
              </select>
            </div>
            <hr>
            <legend>Brands</legend>
            <div class="sticky-top">
              <div class="row">
                <article class="card py-1 overflow-visible card-list card-list-header shadow">
                  <div class="row">
                    <div class="col-12 col-md pl-2">Brand</div>
                    <div class="col-12 col-md pl-2">URL</div>
                  </div>
                </article>
              </div>
              <?php if($user['options'][7]==1){?>
                <form class="row" target="sp" method="post" action="core/add_brand.php">
                  <div class="col-12 col-md">
                    <input id="brandtitle" name="brandtitle" type="text" placeholder="Enter a Brand...">
                  </div>
                  <div class="col-12 col-md">
                    <div class="form-row">
                      <input class="col-md" id="brandurl" name="brandurl" type="text" placeholder="Enter a URL...">
                      <input id="brandicon" name="brandicon" type="hidden" value="" readonly>
                      <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('1','brand','brandicon');return false;"><i class="i">browse-media</i></button>
                      <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                    </div>
                  </div>
                </form>
              <?php }?>
            </div>
            <div id="brand">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='brand' ORDER BY `title` ASC");
              $ss->execute();
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?=$rs['id'];?>" class="row">
                  <div class="col-12 col-md">
                    <div class="input-text"><?=$rs['title'];?></div>
                  </div>
                  <div class="col-12 col-md">
                    <div class="form-row">
                      <div class="input-text col-md"><?=$rs['url'];?></div>
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
            <hr>
            <legend>Sales Periods</legend>
            <div class="form-row mt-3">
              <input id="enableSalesPeriods" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="28" type="checkbox"<?=($config['options'][28]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="enableSalesPeriods">Calculate Sales Periods</label>
            </div>
            <label for="saleHeadingvalentine">Valentine Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingvalentine" data-dbid="1" data-dbt="config" data-dbc="saleHeadingvalentine" type="text" value="<?=$config['saleHeadingvalentine'];?>"<?=($user['options'][7]==1?' placeholder="Enter Valentine Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingvalentine" data-dbid="saleHeadingvalentine" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadingeaster">Easter Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingeaster" data-dbid="1" data-dbt="config" data-dbc="saleHeadingeaster" type="text" value="<?=$config['saleHeadingeaster'];?>"<?=($user['options'][7]==1?' placeholder="Enter Easter Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingeaster" data-dbid="saleHeadingeaster" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadingmothersday">Mother's Day Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingmothersday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingmothersday" type="text" value="<?=$config['saleHeadingmothersday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Mother\'s Day Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingmothersday" data-dbid="saleHeadingmothersday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadingfathersday">Father's Day Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingfathersday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingfathersday" type="text" value="<?=$config['saleHeadingfathersday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Father\'s Day Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingfathersday" data-dbid="saleHeadingfathersday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadingblackfriday">Black Friday Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingblackfriday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingblackfriday" type="text" value="<?=$config['saleHeadingblackfriday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Black Friday Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingblackfriday" data-dbid="saleHeadingblackfriday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadinghalloween">Halloween Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadinghalloween" data-dbid="1" data-dbt="config" data-dbc="saleHeadinghalloween" type="text" value="<?=$config['saleHeadinghalloween'];?>"<?=($user['options'][7]==1?' placeholder="Enter Halloween Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadinghalloween" data-dbid="saleHeadinghalloween" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadingsmallbusinessday">Small Business Day Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingsmallbusinessday" data-dbid="1" data-dbt="config" data-dbc="saleHeadingsmallbusinessday" type="text" value="<?=$config['saleHeadingsmallbusinessday'];?>"<?=($user['options'][7]==1?' placeholder="Enter Small Business Day Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingsmallbusinessday" data-dbid="saleHeadingsmallbusinessday" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadingchristmas">Christmas Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingchristmas" data-dbid="1" data-dbt="config" data-dbc="saleHeadingchristmas" type="text" value="<?=$config['saleHeadingchristmas'];?>"<?=($user['options'][7]==1?' placeholder="Enter Christmas Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingchristmas" data-dbid="saleHeadingchristmas" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="saleHeadingEOFY">End Of Financial Year Sale Heading</label>
            <div class="form-row">
              <input class="textinput" id="saleHeadingEOFY" data-dbid="1" data-dbt="config" data-dbc="saleHeadingEOFY" type="text" value="<?=$config['saleHeadingEOFY'];?>"<?=($user['options'][7]==1?' placeholder="Enter End Of Financial Year Sale Heading..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesaleHeadingEOFY" data-dbid="saleHeadingEOFY" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
<? /* FOMO Notifications */?>
          <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
            <legend class="mt-3">FOMO Notifications</legend>
            <div class="row mt-2">
              <div class="col-12 col-md-4 pr-3">
                <div class="form-row">
                  <input id="enablefomo" data-dbid="1" data-dbt="config" data-dbc="fomo" data-dbb="0" type="checkbox"<?=($config['fomo']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label for="enablefomo">Enable</label>
                </div>
              </div>
              <div class="col-12 col-md-4 pr-3">
                <div class="form-row">
                  <input id="fomoOptions7" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="7" type="checkbox"<?=($config['fomoOptions'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label for="fomoOptions7">Show State</label>
                </div>
              </div>
              <div class="col-12 col-md-4 pr-3">
                <input id="fomoFullname" data-dbid="1" data-dbt="config" data-dbc="fomoFullname" data-dbb="0" type="checkbox"<?=($config['fomoFullname']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                <label for="fomoFullname">Show Full State Name</label>
              </div>
            </div>
            <div class="row">
              <label>Display FOMO Content Types</label>
              <div class="col-12 col-md-6 pr-3">
                <div class="form-row">
                  <div class="input-text col-4">Activities</div>
                  <select id="fomoActivitiesState" data-dbid="1" data-dbt="config" data-dbc="fomoActivitiesState"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoActivitiesState`,$(this).val(),`select`);"':' disabled';?>>
                    <option value=""<?=$config['fomoActivitiesState']==''?' selected':'';?>>Disabled</option>
                    <option value="All"<?=$config['fomoActivitiesState']=='All'?' selected':'';?>>All</option>
                    <option value="ACT"<?=$config['fomoActivitiesState']=='ACT'?' selected':'';?>>ACT (Australian Capital Territory)</option>
                    <option value="NSW"<?=$config['fomoActivitiesState']=='NSW'?' selected':'';?>>NSW (New South Wales)</option>
                    <option value="NT"<?=$config['fomoActivitiesState']=='NT'?' selected':'';?>>NT (Northern Territory)</option>
                    <option value="QLD"<?=$config['fomoActivitiesState']=='QLD'?' selected':'';?>>QLD (Queensland)</option>
                    <option value="SA"<?=$config['fomoActivitiesState']=='SA'?' selected':'';?>>SA (South Australia)</option>
                    <option value="TAS"<?=$config['fomoActivitiesState']=='TAS'?' selected':'';?>>TAS (Tasmania)</option>
                    <option value="VIC"<?=$config['fomoActivitiesState']=='VIC'?' selected':'';?>>VIC (Victoria)</option>
                    <option value="WA"<?=$config['fomoActivitiesState']=='WA'?' selected':'';?>>WA (Western Australia)</option>
                  </select>
                </div>
              </div>

              <div class="col-12 col-md-6">
                <div class="form-row">
                  <div class="input-text col-4">Courses</div>
                  <select id="fomoCoursesState" data-dbid="1" data-dbt="config" data-dbc="fomoCoursesState"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoCoursesState`,$(this).val(),`select`);"':' disabled';?>>
                    <option value=""<?=$config['fomoCoursesState']==''?' selected':'';?>>Disabled</option>
                    <option value="All"<?=$config['fomoCoursesState']=='All'?' selected':'';?>>All</option>
                    <option value="ACT"<?=$config['fomoCoursesState']=='ACT'?' selected':'';?>>ACT (Australian Capital Territory)</option>
                    <option value="NSW"<?=$config['fomoCoursesState']=='NSW'?' selected':'';?>>NSW (New South Wales)</option>
                    <option value="NT"<?=$config['fomoCoursesState']=='NT'?' selected':'';?>>NT (Northern Territory)</option>
                    <option value="QLD"<?=$config['fomoCoursesState']=='QLD'?' selected':'';?>>QLD (Queensland)</option>
                    <option value="SA"<?=$config['fomoCoursesState']=='SA'?' selected':'';?>>SA (South Australia)</option>
                    <option value="TAS"<?=$config['fomoCoursesState']=='TAS'?' selected':'';?>>TAS (Tasmania)</option>
                    <option value="VIC"<?=$config['fomoCoursesState']=='VIC'?' selected':'';?>>VIC (Victoria)</option>
                    <option value="WA"<?=$config['fomoCoursesState']=='WA'?' selected':'';?>>WA (Western Australia)</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6 pr-3">
                <div class="form-row">
                  <div class="input-text col-4">Events</div>
                  <select id="fomoEventsState" data-dbid="1" data-dbt="config" data-dbc="fomoEventsState"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoEventsState`,$(this).val(),`select`);"':' disabled';?>>
                    <option value=""<?=$config['fomoEventsState']==''?' selected':'';?>>Disabled</option>
                    <option value="All"<?=$config['fomoEventsState']=='All'?' selected':'';?>>All</option>
                    <option value="ACT"<?=$config['fomoEventsState']=='ACT'?' selected':'';?>>Australian Capital Territory</option>
                    <option value="NSW"<?=$config['fomoEventsState']=='NSW'?' selected':'';?>>New South Wales</option>
                    <option value="NT"<?=$config['fomoEventsState']=='NT'?' selected':'';?>>Northern Territory</option>
                    <option value="QLD"<?=$config['fomoEventsState']=='QLD'?' selected':'';?>>Queensland</option>
                    <option value="SA"<?=$config['fomoEventsState']=='SA'?' selected':'';?>>South Australia</option>
                    <option value="TAS"<?=$config['fomoEventsState']=='TAS'?' selected':'';?>>Tasmania</option>
                    <option value="VIC"<?=$config['fomoEventsState']=='VIC'?' selected':'';?>>Victoria</option>
                    <option value="WA"<?=$config['fomoEventsState']=='WA'?' selected':'';?>>Western Australia</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-row">
                  <div class="input-text col-4">Inventory</div>
                  <select id="fomoInventoryState" data-dbid="1" data-dbt="config" data-dbc="fomoInventoryState"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoInventoryState`,$(this).val(),`select`);"':' disabled';?>>
                    <option value=""<?=$config['fomoInventoryState']==''?' selected':'';?>>Disabled</option>
                    <option value="All"<?=$config['fomoInventoryState']=='All'?' selected':'';?>>All</option>
                    <option value="ACT"<?=$config['fomoInventoryState']=='ACT'?' selected':'';?>>Australian Capital Territory</option>
                    <option value="NSW"<?=$config['fomoInventoryState']=='NSW'?' selected':'';?>>New South Wales</option>
                    <option value="NT"<?=$config['fomoInventoryState']=='NT'?' selected':'';?>>Northern Territory</option>
                    <option value="QLD"<?=$config['fomoInventoryState']=='QLD'?' selected':'';?>>Queensland</option>
                    <option value="SA"<?=$config['fomoInventoryState']=='SA'?' selected':'';?>>South Australia</option>
                    <option value="TAS"<?=$config['fomoInventoryState']=='TAS'?' selected':'';?>>Tasmania</option>
                    <option value="VIC"<?=$config['fomoInventoryState']=='VIC'?' selected':'';?>>Victoria</option>
                    <option value="WA"<?=$config['fomoInventoryState']=='WA'?' selected':'';?>>Western Australia</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6 pr-3">
                <div class="form-row">
                  <div class="input-text col-4">Services</div>
                  <select id="fomoServicesState" data-dbid="1" data-dbt="config" data-dbc="fomoServicesState"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoServicesState`,$(this).val(),`select`);"':' disabled';?>>
                    <option value=""<?=$config['fomoServicesState']==''?' selected':'';?>>Disabled</option>
                    <option value="All"<?=$config['fomoServicesState']=='All'?' selected':'';?>>All</option>
                    <option value="ACT"<?=$config['fomoServicesState']=='ACT'?' selected':'';?>>Australian Capital Territory</option>
                    <option value="NSW"<?=$config['fomoServicesState']=='NSW'?' selected':'';?>>New South Wales</option>
                    <option value="NT"<?=$config['fomoServicesState']=='NT'?' selected':'';?>>Northern Territory</option>
                    <option value="QLD"<?=$config['fomoServicesState']=='QLD'?' selected':'';?>>Queensland</option>
                    <option value="SA"<?=$config['fomoServicesState']=='SA'?' selected':'';?>>South Australia</option>
                    <option value="TAS"<?=$config['fomoServicesState']=='TAS'?' selected':'';?>>Tasmania</option>
                    <option value="VIC"<?=$config['fomoServicesState']=='VIC'?' selected':'';?>>Victoria</option>
                    <option value="WA"<?=$config['fomoServicesState']=='WA'?' selected':'';?>>Western Australia</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-row">
                  <div class="input-text col-4">Testimonials</div>
                  <select id="fomoTestimonialsState" data-dbid="1" data-dbt="config" data-dbc="fomoTestimonialsState"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoTestimonialsState`,$(this).val(),`select`);"':' disabled';?>>
                    <option value=""<?=$config['fomoTestimonialsState']=='none'?' selected':'';?>>Disabled</option>
                    <option value="enabled"<?=$config['fomoTestimonialsState']=='enabled'?' selected':'';?>>Enabled</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 pr-3">
                <label for="fomostyle">Style</label>
                <div class="form-row">
                  <select id="fomostyle" data-dbid="1" data-dbt="config" data-dbc="fomoStyle"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoStyle`,$(this).val(),`select`);updateFomoStyle($(this).val());"':' disabled';?>>
                    <option value=""<?=($config['fomoStyle']==''?' selected':'');?>>Default</option>
                    <option value="rounded"<?=($config['fomoStyle']=='rounded'?' selected':'');?>>Rounded</option>
                    <option value="separated"<?=($config['fomoStyle']=='separated'?' selected':'');?>>Separated</option>
                    <option value="giant"<?=($config['fomoStyle']=='giant'?' selected':'');?>>Giant</option>
                    <option value="comic"<?=($config['fomoStyle']=='comic'?' selected':'');?>>Comic</option>
                    <option value="thought"<?=($config['fomoStyle']=='thought'?' selected':'');?>>Thought</option>
                    <option value="yell"<?=($config['fomoStyle']=='yell'?' selected':'');?>>Yell</option>
                  </select>
                  <script>
                    function updateFomoStyle(s){
                      document.querySelector(`.fomo`).classList.remove(`fomo-rounded`,`fomo-separated`,`fomo-giant`,`fomo-comic`,`fomo-thought`,`fomo-yell`);
                      if(s!=''){
                        document.querySelector(`.fomo`).classList.add(`fomo-`+s);
                      }
                    }
                  </script>
                </div>
              </div>
              <div class="col-12 col-md-4 pr-3">
                <label for="fomoIn">Entrance Animation</label>
                <div class="form-row">
                  <select id="defaultOrder" data-dbid="1" data-dbt="config" data-dbc="fomoIn"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoIn`,$(this).val(),`select`);"':' disabled';?>>
                    <option value="slide-in-bottom"<?=$config['fomoIn']=='slide-in-bottom'?' selected':'';?>>Slide In Bottom</option>
                    <option value="slide-in-left"<?=$config['fomoIn']=='slide-in-left'?' selected':'';?>>Slide In Left</option>
                    <option value="slide-in-blurred-left"<?=$config['fomoIn']=='slide-in-blurred-left'?' selected':'';?>>Slide In Blurred Left</option>
                    <option value="bounce-in-bottom"<?=$config['fomoIn']=='bounce-in-bottom'?' selected':'';?>>Bounce In Bottom</option>
                    <option value="bounce-in-left"<?=$config['fomoIn']=='bounce-in-left'?' selected':'';?>>Bounce In Left</option>
                    <option value="fade-in-bottom"<?=$config['fomoIn']=='fade-in-bottom'?' selected':'';?>>Fade In Bottom</option>
                    <option value="fade-in-left"<?=$config['fomoIn']=='fade-in-left'?' selected':'';?>>Fade In Left</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <label for="fomoOut">Exit Animation</label>
                <div class="form-row">
                  <select id="defaultOrder" data-dbid="1" data-dbt="config" data-dbc="fomoOut"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoOut`,$(this).val(),`select`);"':' disabled';?>>
                    <option value="slide-out-bottom"<?=$config['fomoOut']=='slide-out-bottom'?' selected':'';?>>Slide Out Bottom</option>
                    <option value="slide-out-left"<?=$config['fomoOut']=='slide-out-left'?' selected':'';?>>Slide Out Left</option>
                    <option value="slide-out-blurred-left"<?=$config['fomoOut']=='slide-out-blurred-left'?' selected':'';?>>Slide Out Blurred Left</option>
                    <option value="fade-out-bottom"<?=$config['fomoOut']=='fade-out-bottom'?' selected':'';?>>Fade Out Bottom</option>
                    <option value="fade-out-left"<?=$config['fomoOut']=='fade-out-left'?' selected':'';?>>Fade Out Left</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="fomo fomo-admin<?=($config['fomoStyle']!=''?' fomo-'.$config['fomoStyle']:'');?>">
                <div class="fomo-image"><img src="<?= NOIMAGE;?>" alt="Sample Image"></div>
                <div class="fomo-text">
                  <div class="fomo-who">Someone in Somewhere, Anywhere, State, purchased</div>
                  <div class="fomo-heading">Example Heading</div>
                  <div class="fomo-timeago">About 4 hours ago.</div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12">
                <label for="fomoState">Edit State Locations</label>
                <div class="form-row">
                  <select id="fomoState" data-dbid="1" data-dbt="config" data-dbc="fomoState"<?=$user['options'][7]==1?'':' disabled';?>>
                    <option value="All">All</option>
                    <option value="ACT">ACT (Australian Capital Territory)</option>
                    <option value="NSW">NSW (New South Wales)</option>
                    <option value="NT">NT (Northern Territory)</option>
                    <option value="QLD">QLD (Queensland)</option>
                    <option value="SA">SA (South Australia)</option>
                    <option value="TAS">TAS (Tasmania)</option>
                    <option value="VIC">VIC (Victoria)</option>
                    <option value="WA">WA (Western Australia)</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="card overflow-visible">
                  <div id="locationsShow" class="col-12 p-3 d-none"></div>
                  <div class="col-12">
                    <div class="row p-3">
                      <button class="btn" data-tooltip="bottom" aria-label="Show/Hide Areas"  onclick="editLocations($('#fomoState').val());"><i class="i fomoarrow">down</i><i class="i fomoarrow d-none">up</i></button>
                    </div>
                  </div>
                </div>
              </div>
              <script>
                function editLocations(s,a){
                  if($("#locationsShow").hasClass("d-none")){
                    $('#locationsShow').html('<div class="row"><div class="col-12 text-center"><i class="i i-spin">spinner</i></div></div>');
                    $("#locationsShow").removeClass('d-none');
                    fetch('core/edit_postcodes.php',{
                      method:"POST",
                      headers:{"Content-type":"application/x-www-form-urlencoded; charset=UTF-8"},
                      body:'st='+s
                    }).then(function(response){
                      return response.text();
                    }).then(function(r){
                      $('#locationsShow').html(r);
                      $(".fomoarrow").toggleClass('d-none');
                    });
                  }else{
                    $("#locationsShow").addClass('d-none');
                    $('#locationsShow').empty();
                    $(".fomoarrow").toggleClass('d-none');
                  }
                }
              </script>
            </div>
          </div>
<?php /* Templates */ ?>
          <div class="tab1-4 border p-3" data-tabid="tab1-4" role="tabpanel">
            <label for="templateQTY" class="mt-3">Item Template Quantity</label>
            <?=($user['options'][7]==1?'<div class="form-text">\'0\' to Disable.</div>':'');?>
            <div class="form-row">
              <input class="textinput" id="templateQTY" data-dbid="1" data-dbt="config" data-dbc="templateQTY" type="text" value="<?=$config['templateQTY'];?>"<?=($user['options'][7]==1?' placeholder="Enter Template Item Quantity..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savetemplateQTY" data-dbid="templateQTY" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <section class="content overflow-visible theme-chooser mt-3" id="templates">
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
                  <div class="card-header line-clamp"><?=$rt['title'];?></div>
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
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
