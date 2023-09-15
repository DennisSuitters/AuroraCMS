<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
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
            <?=($user['options'][7]==1?'<small class="form-text text-muted">\'0\' to Disable and display all items.</small>':'');?>
            <div class="form-row">
              <input class="textinput" id="showItems" data-dbid="1" data-dbt="config" data-dbc="showItems" type="text" value="<?=$config['showItems'];?>"<?=($user['options'][7]==1?' placeholder="Enter Item Count..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="saveshowItems" data-dbid="showItems" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="searchItems">Search Items Count</label>
            <?=($user['options'][7]==1?'<small class="form-text text-muted">\'0\' to Default to 10 items.</small>':'');?>
            <div class="form-row">
              <input class="textinput" id="searchItems" data-dbid="1" data-dbt="config" data-dbc="searchItems" type="text" value="<?=$config['searchItems'];?>"<?=($user['options'][7]==1?' placeholder="Enter Search Items Count..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesearchItems" data-dbid="searchItems" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <hr>
            <legend>Related Content</legend>
            <div class="form-row">
              <input id="enableRelated" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?=($config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label class="p-0 mt-0 ml-3" for="enableRelated">Enable Related Content</label>
            </div>
            <div class="form-row">
              <input id="displaySimilar" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10" type="checkbox"<?=($config['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label class="p-0 mt-0 ml-3" for="displaySimilar">Display Similar Category if no Related Content items are selected</label>
            </div>
            <hr>
            <legend>Categories</legend>
            <div class="form-row">
              <input id="enableCategoryNavigation" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="31" type="checkbox"<?=($config['options'][31]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label class="p-0 mt-0 ml-3" for="enableCategoryNavigation">Category Navigation</label>
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
                    <label for="ct">Content Type</label>
                    <div class="form-row">
                      <select id="ct" name="ct">
                        <?php $sc=$db->prepare("SELECT DISTINCT(`contentType`) FROM `".$prefix."content` WHERE `contentType`!='' ORDER BY contentType ASC");
                        $sc->execute();
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['contentType'].'">'.ucfirst($rc['contentType']).'</option>';?>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-1">
                    <label for="icon">Icon</label>
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
          </div>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <div class="form-row mt-3">
              <input id="enableQuickView" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="5" type="checkbox"<?=($config['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label class="p-0 mt-0 ml-3" for="enableQuickView">Quick View for Products &amp; Gallery</label>
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
            <legend class="mb-0">Brands</legend>
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
            <hr>
            <legend>Sales Periods</legend>
            <div class="form-row mt-3">
              <input id="enableSalesPeriods" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="28" type="checkbox"<?=($config['options'][28]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label class="p-0 mt-0 ml-3" for="enableSalesPeriods">Calculate Sales Periods</label>
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
            <legend>FOMO Notifications</legend>
            <div class="row">
              <div class="col-12 col-md-4 pr-3">
                <div class="form-row">
                  <input id="enablefomo" data-dbid="1" data-dbt="config" data-dbc="fomo" data-dbb="0" type="checkbox"<?=($config['fomo']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="enablefomo">Enable</label>
                </div>
              </div>
              <div class="col-12 col-md-4 pr-3">
                <div class="form-row">
                  <input id="fomoOptions7" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="7" type="checkbox"<?=($config['fomoOptions'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="fomoOptions7">Show State</label>
                </div>
              </div>
              <div class="col-12 col-md-4 pr-3">
                <input id="fomoFullname" data-dbid="1" data-dbt="config" data-dbc="fomoFullname" data-dbb="0" type="checkbox"<?=($config['fomoFullname']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                <label class="p-0 mt-0 ml-3" for="fomoFullname">Show Full State Name</label>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 pr-3">
                <label for="fomoState">State</label>
                <div class="form-row">
                  <select id="fomoState" data-dbid="1" data-dbt="config" data-dbc="fomoState"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoState`,$(this).val(),`select`);update(`1`,`config`,`fomoArea`,`all`,`select`);fomoState($(this).val());"':' disabled';?>>
                    <option value="All"<?=$config['fomoState']=='All'?' selected':'';?>>All</option>
                    <option value="ACT"<?=$config['fomoState']=='ACT'?' selected':'';?>>ACT (Australian Capital Territory)</option>
                    <option value="NSW"<?=$config['fomoState']=='NSW'?' selected':'';?>>NSW (New South Wales)</option>
                    <option value="NT"<?=$config['fomoState']=='NT'?' selected':'';?>>NT (Northern Territory)</option>
                    <option value="QLD"<?=$config['fomoState']=='QLD'?' selected':'';?>>QLD (Queensland)</option>
                    <option value="SA"<?=$config['fomoState']=='SA'?' selected':'';?>>SA (South Australia)</option>
                    <option value="TAS"<?=$config['fomoState']=='TAS'?' selected':'';?>>TAS (Tasmania)</option>
                    <option value="VIC"<?=$config['fomoState']=='VIC'?' selected':'';?>>VIC (Victoria)</option>
                    <option value="WA"<?=$config['fomoState']=='WA'?' selected':'';?>>WA (Western Australia)</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-4 pr-3">
                <label for="fomoArea">Areas</label>
                <div class="form-row">
                  <select id="fomoArea" data-dbid="1" data-dbt="config" data-dbc="fomoArea"<?=$user['options'][7]==1?' onchange="update(`1`,`config`,`fomoArea`,$(this).val(),`select`);"':' disabled';?>>
                    <option value="All">All</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <label for="fomoPostcodeFrom">Limit to Postcodes</label>
                <div class="form-row">
                  <input class="textinput" id="fomoPostcodeFrom" data-dbid="1" data-dbt="config" data-dbc="fomoPostcodeFrom" type="text" value="<?=$config['fomoPostcodeFrom'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Postcode From Value..."':' disabled');?>>
                  <?=($user['options'][7]==1?'<button class="save" id="savefomoPostcodeFrom" data-dbid="fomoPostcodeFrom" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                  <div class="input-text">to</div>
                  <input class="textinput" id="fomoPostcodeTo" data-dbid="1" data-dbt="config" data-dbc="fomoPostcodeTo" type="text" value="<?=$config['fomoPostcodeTo'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Postcode Value To..."':' disabled');?>>
                  <?=($user['options'][7]==1?'<button class="save" id="savefomoPostcodeTo" data-dbid="fomoPostcodeTo" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                </div>
              </div>
              <div class="row">
                <div class="card overflow-visible">
                  <div id="locationsShow" class="col-12 p-3 d-none"></div>
                  <div class="col-12">
                    <div class="row p-3">
                      <button class="btn" data-tooltip="bottom" aria-label="Show/Hide Areas"  onclick="editLocations($('#fomoState').val(),$('#fomoArea').val());"><i class="i fomoarrow">down</i><i class="i fomoarrow d-none">up</i></button>
                    </div>
                  </div>
                </div>
              </div>
              <script>
                function fomoState(s){
                  var d=['All'];
                  <?php $sp=$db->prepare("SELECT DISTINCT(`state`) FROM `".$prefix."locations` ORDER BY `state` ASC");
                  $sp->execute();
                  while($rp=$sp->fetch(PDO::FETCH_ASSOC)){?>
                    if(s=='<?=$rp['state'];?>'){
                      var d=[
                        "All",
                        <?php $sr=$db->prepare("SELECT DISTINCT(`area`) FROM `".$prefix."locations` WHERE `state`=:state ORDER BY `area` ASC");
                        $sr->execute([':state'=>$rp['state']]);
                        while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
                          echo($rr['area']!=''?'"'.$rr['area'].'",':'');
                        }?>
                      ];
                    }
                  <?php }?>
                  var option='';
                  for(var i=0;i<d.length;i++){
                    option+='<option value="'+d[i]+'">'+d[i]+'</option>';
                  }
                  $('#fomoArea').empty();
                  $('#fomoArea').append(option);
                }
                fomoState('<?=$config['fomoState'];?>');
                $(`#fomoArea option[value="<?=$config['fomoArea'];?>"]`).prop("selected",true);
                function editLocations(s,a){
                  if($("#locationsShow").hasClass("d-none")){
                    $('#locationsShow').html('<div class="row"><div class="col-12 text-center"><i class="i i-spin">spinner</i></div></div>');
                    $("#locationsShow").removeClass('d-none');
                    fetch('core/edit_postcodes.php',{
                      method:"POST",
                      headers:{"Content-type":"application/x-www-form-urlencoded; charset=UTF-8"},
                      body:'st='+s+'&s='+a+'&pcf='+$(`#fomoPostcodeFrom`).val()+'&pct='+$(`#fomoPostcodeTo`).val()
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
            <div class="row mt-3">
              <label>Display FOMO Content Types</label>
              <div class="col-6 col-md-2 pr-3">
                <div class="form-row">
                  <input id="fomoOptions0" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="0" type="checkbox"<?=($config['fomoOptions'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="fomoOptions0">Activities</label>
                </div>
              </div>
              <div class="col-6 col-md-2 pr-3">
                <div class="form-row">
                  <input id="fomoOptions1" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="1" type="checkbox"<?=($config['fomoOptions'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="fomoOptions1">Courses</label>
                </div>
              </div>
              <div class="col-6 col-md-2 pr-3">
                <div class="form-row">
                  <input id="fomoOptions2" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="2" type="checkbox"<?=($config['fomoOptions'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="fomoOptions2">Events</label>
                </div>
              </div>
              <div class="col-6 col-md-2 pr-3">
                <div class="form-row">
                  <input id="fomoOptions3" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="3" type="checkbox"<?=($config['fomoOptions'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="fomoOptions3">Inventory</label>
                </div>
              </div>
              <div class="col-6 col-md-2 pr-3">
                <div class="form-row">
                  <input id="fomoOptions4" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="4" type="checkbox"<?=($config['fomoOptions'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="fomoOptions4">Services</label>
                </div>
              </div>
              <div class="col-6 col-md-2 pr-3">
                <div class="form-row">
                  <input id="fomoOptions5" data-dbid="1" data-dbt="config" data-dbc="fomoOptions" data-dbb="5" type="checkbox"<?=($config['fomoOptions'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="fomoOptions5">Testimonials</label>
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
          </div>
<?php /* Templates */ ?>
          <div class="tab1-4 border p-3" data-tabid="tab1-4" role="tabpanel">
            <label class="mt-3" for="templateQTY">Item Template Quantity</label>
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
