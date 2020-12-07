<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media - Edit
 * @package    core/layout/edit_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `id`=:id");
$s->execute([
  ':id'=>$args[1]
]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('content','i-3x');?></div>
          <div>Media Edit</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/add/'.$r['contentType'];?>" role="button" aria-label="Back"><?php svg('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></a>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Media</a></li>
          <li class="breadcrumb-item active"><?php echo$user['options'][1]==1?'Edit':'View';?></li>
          <li class="breadcrumb-item active"><?php echo$r['title'];?></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="row">
          <div class="col-12 col-md-10 order-1 order-md-1 mb-4 mb-md-0">
            <label for="title">Title</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title" data-tooltip="tooltip" aria-label="SEO Title Information"><?php svg('seo');?></button>
              <input class="textinput" id="title" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="title" data-bs="trash" type="text" value="<?php echo$r['title'];?>"<?php echo$user['options'][1]==1?' placeholder="Media Item Title...."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label for="exifFilename">Image ALT</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><?php svg('seo');?></button>
              <input class="textinput" id="fileALT" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="fileALT" type="text" value="<?php echo$r['fileALT'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an Image ALT Text..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button class="save" id="savefileALT" data-dbid="fileALT" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-md-2 order-1 order-md-2 mb-4 mb-md-0">
            <?php if(file_exists('media/sm/'.basename($r['file'])))
              $thumb='media/sm/'.basename($r['file']);
            else
              $thumb=NOIMAGE;?>
            <a class="card bg-dark m-2" data-fancybox="media" href="<?php echo$r['file'];?>">
              <img src="<?php echo$thumb;?>" alt="Media <?php echo$r['id'];?>">
            </a>
          </div>
        </div>
        <label for="tags">Tags</label>
        <div class="form-row">
          <input class="textinput" id="tags" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="tags" type="text" value="<?php echo$r['tags'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter Tags..."':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="savetags" data-dbid="tags" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="ti">Created</label>
        <div class="form-row">
          <input id="ti" type="text" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
        </div>
        <label for="views">Views</label>
        <div class="form-row">
          <input class="textinput" id="views" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="views" type="number" value="<?php echo$r['views'];?>"<?php echo$user['options'][1]==1?'':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`media`,`views`,`0`);">'.svg2('eraser').'</button>'.
          '<button class="save" id="saveviews" data-dbid="views" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="category_1">Category One</label>
        <div class="form-row">
          <input class="textinput" id="category_1" list="category_1_options" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_1" type="text" value="<?php echo$r['category_1'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
          <?php if($user['options'][1]==1){
            $sc=$db->query("SELECT DISTINCT `category_1` FROM `".$prefix."media` WHERE `category_1`!='' ORDER BY `category_1` ASC");
            if($sc->rowCount()>0){
              echo'<datalist id="category_1_options">';
              while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
              echo'</datalist>';
            }
            echo'<button class="save" id="savecategory_1" data-dbid="category_1" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>';
          }?>
        </div>
        <label for="category_2">Category Two</label>
        <div class="form-row">
          <input class="textinput" id="category_2" list="category_2_options" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_2" type="text" value="<?php echo$r['category_2'];?>"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
          <?php if($user['options'][1]==1){
            $sc=$db->query("SELECT DISTINCT `category_2` FROM `".$prefix."content` WHERE `category_2`!='' ORDER BY `category_2` ASC");
            if($sc->rowCount()>0){
              echo'<datalist id="category_2_options">';
              while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_2'].'"/>';
              echo'</datalist>';
            }
            echo'<button class="save" id="savecategory_2" data-dbid="category_2" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>';
          }?>
        </div>
        <label for="category_3">Category Three</label>
        <div class="form-row">
          <input class="textinput" id="category_3" list="category_3_options" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_3" type="text" value="<?php echo$r['category_3'];?>"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
          <?php if($user['options'][1]==1){
            $sc=$db->query("SELECT DISTINCT `category_3` FROM `".$prefix."media` WHERE `category_3`!='' ORDER BY `category_3` ASC");
            if($sc->rowCount()>0){
              echo'<datalist id="category_3_options">';
              while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_3'].'"/>';
              echo'</datalist>';
            }
            echo'<button class="save" id="savecategory_3" data-dbid="category_3" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>';
          }?>
        </div>
        <label for="category_4">Category Four</label>
        <div class="form-row">
          <input class="textinput" id="category_4" list="category_4_options" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_4" type="text" value="<?php echo$r['category_4'];?>"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
          <?php if($user['options'][1]==1){
            $sc=$db->query("SELECT DISTINCT `category_4` FROM `".$prefix."media` WHERE `category_4`!='' ORDER BY `category_4` ASC");
            if($sc->rowCount()>0){
              echo'<datalist id="category_4_options">';
              while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_4'].'"/>';
              echo'</datalist>';
            }
            echo'<button class="save" id="savecategory_4" data-dbid="category_4" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>';
          }?>
        </div>
        <legend class="mt-3">EXIF Information</legend>
        <label for="exifFilename">Original Filename</label>
        <div class="form-row">
          <input class="textinput" id="exifFilename" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifFilename" type="text" value="<?php echo$r['exifFilename'];?>"<?php echo$user['options'][1]==1?' placeholder="Original Filename..."':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifFilename" data-dbid="exifFilename" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="exifCamera">Camera</label>
        <div class="form-row">
          <input class="textinput" id="exifCamera" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifCamera" type="text" value="<?php echo$r['exifCamera'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Camera"':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifCamera" data-dbid="exifCamera" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="exifLens">Lens</label>
        <div class="form-row">
          <input class="textinput" id="exifLens" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifLens" type="text" value="<?php echo$r['exifLens'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifLens" data-dbid="exifLens" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="exifAperture">Aperture</label>
        <div class="form-row">
          <input class="textinput" id="exifAperture" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifAperture" type="text" value="<?php echo$r['exifAperture'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifAperture" data-dbid="exifAperture" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="exifFocalLength">Focal Length</label>
        <div class="form-row">
          <input class="textinput" id="exifFocalLength" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifFocalLength" type="text" value="<?php echo$r['exifFocalLength'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifFocalLength" data-dbid="exifFocalLength" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="exifShutterSpeed">Shutter Speed</label>
        <div class="form-row">
          <input class="textinput" id="exifShutterSpeed" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifShutterSpeed" type="text" value="<?php echo$r['exifShutterSpeed'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifShutterSpeed" data-dbid="exifShutterSpeed" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="exifISO">ISO</label>
        <div class="form-row">
          <input class="textinput" id="exifISO" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifISO" type="text" value="<?php echo$r['exifISO'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifISO" data-dbid="exifISO" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="exifti">Taken</label>
        <div class="form-row">
          <input class="textinput" id="exifti" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifti" type="text" value="<?php echo$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>"<?php echo$user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly';?>>
          <?php echo$user['options'][1]==1?'<button class="save" id="saveexifti" data-dbid="exifti" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <legend class="mt-3">Image Attribution</legend>
        <label for="attributionImageName">Name</label>
        <div class="form-row">
          <input class="textinput" id="attributionImageName" list="attributionImageName_option" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="attributionImageName" type="text" value="<?php echo$r['attributionImageName'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
          <?php if($user['options'][1]==1){
            $s=$db->query("SELECT DISTINCT `attributionImageName` AS name FROM `".$prefix."media` UNION SELECT DISTINCT `name` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` AS name FROM `".$prefix."login` ORDER BY `name` ASC");
            if($s->rowCount()>0){
              echo'<datalist id="attributionImageName_option">';
              while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
              echo'</datalist>';
            }
          }
          echo$user['options'][1]==1?'<button class="save" id="saveattributionImageName" data-dbid="attributionImageName" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label for="attributionImageURL">URL</label>
        <div class="form-row">
          <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="attributionImageURL" type="text" value="<?php echo$r['attributionImageURL'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
          <?php if($user['options'][1]==1){
            $s=$db->query("SELECT DISTINCT `attributionImageURL` AS url FROM `".$prefix."media` ORDER BY `attributionImageURL` ASC");
            if($s->rowCount()>0){
              echo'<datalist id="attributionImageURL_option">';
              while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';
              echo'</datalist>';
            }
          }
          echo$user['options'][1]==1?'<button class="save" id="saveattributionImageURL" data-dbid="attributionImageURL" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
