<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media - Edit
 * @package    core/layout/edit_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.17
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.17 Add SEO Helper buttons.
 */
$s=$db->prepare("SELECT * FROM `".$prefix."media` WHERE id=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Media</a></li>
    <li class="breadcrumb-item"><?php echo$user['options'][1]==1?'Edit':'View';?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo $_SERVER['HTTP_REFERER'];?>#tab-<?php if(stristr($_SERVER['HTTP_REFERER'],'content')){echo'content';}else{echo'pages';}?>-media" data-tooltip="tooltip" data-placement="left" data-title="Back" role="button" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid row">
    <div class="card col-12">
      <div class="card-body">
        <div class="form-group row">
          <label for="title" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Title</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Title Information"><button class="btn btn-secondary seohelper" data-type="title" aria-label="SEO Title Information"><?php svg('seo');?></button></div>
            <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="title" data-bs="btn-danger"<?php echo$user['options'][1]==1?' placeholder="Media Item Title...."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save" aria-label="Save"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="exifFilename" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Image ALT</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Image Alt Information"><button class="btn btn-secondary seohelper" data-type="alt" aria-label="SEO Image Alt Information"><?php svg('seo');?></button></div>
            <input type="text" id="fileALT" class="form-control textinput" value="<?php echo$r['fileALT'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="fileALT"<?php echo$user['options'][1]==1?' placeholder="Enter an Image ALT Text..."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save" aria-label="Save"><button id="savefileALT" class="btn btn-secondary save" data-dbid="fileALT" data-style="zoom-in">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="tags" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Tags</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="tags"<?php echo$user['options'][1]==1?' placeholder="Enter Tags..."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savetags" class="btn btn-secondary save" data-dbid="tags" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="ti" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Created</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="views" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Views</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="views"<?php echo$user['options'][1]==1?'':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary trash" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`media`,`views`,`0`);" data-tooltip="tooltip" data-title="Clear" aria-label="Clear">'.svg2('eraser').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveviews" class="btn btn-secondary save" data-dbid="views" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="category_1" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category One</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_1"<?php echo$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
<?php if($user['options'][1]==1){
  echo'<datalist id="category_1_options">';
  $sc=$db->query("SELECT DISTINCT category_1 FROM `".$prefix."media` WHERE category_1!='' ORDER BY category_1 ASC");
  if($sc->rowCount()>0){
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
  }
  echo'</datalist>';
            echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_1" class="btn btn-secondary save" data-dbid="category_1" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
          </div>
        </div>
        <div class="form-group row">
          <label for="category_2" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category Two</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_2"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
<?php if($user['options'][1]==1){
  $sc=$db->query("SELECT DISTINCT category_2 FROM `".$prefix."content` WHERE category_2!='' ORDER BY category_2 ASC");
  if($sc->rowCount()>0){
    echo'<datalist id="category_2_options">';
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_2'].'"/>';
    echo'</datalist>';
  }
            echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_2" class="btn btn-secondary save" data-dbid="category_2" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
          </div>
        </div>
        <div class="form-group row">
          <label for="category_3" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category Three</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input id="category_3" list="category_3_options" type="text" class="form-control textinput" value="<?php echo$r['category_3'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_3"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
<?php if($user['options'][1]==1){
  $sc=$db->query("SELECT DISTINCT category_3 FROM `".$prefix."media` WHERE category_3!='' ORDER BY category_3 ASC");
  if($sc->rowCount()>0){
    echo'<datalist id="category_3_options">';
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_3'].'"/>';
    echo'</datalist>';
  }
            echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_3" class="btn btn-secondary save" data-dbid="category_3" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
          </div>
        </div>
        <div class="form-group row">
          <label for="category_4" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category Four</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input id="category_4" list="category_4_options" type="text" class="form-control textinput" value="<?php echo$r['category_4'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_4"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
<?php if($user['options'][1]==1){
  $sc=$db->query("SELECT DISTINCT category_4 FROM `".$prefix."media` WHERE category_4!='' ORDER BY category_4 ASC");
  if($sc->rowCount()>0){
    echo'<datalist id="category_4_options">';
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_4'].'"/>';
    echo'</datalist>';
  }
            echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_4" class="btn btn-secondary save" data-dbid="category_4" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
          </div>
        </div>
        <fieldset class="control-fieldset">
          <legend class="control-legend">EXIF Information</legend>
          <div class="form-group row">
            <label for="exifFilename" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Original Filename</label>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <input type="text" id="exifFilename" class="form-control textinput" value="<?php echo$r['exifFilename'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifFilename"<?php echo$user['options'][1]==1?' placeholder="Original Filename..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save" aria-label="Save"><button id="saveexifFilename" class="btn btn-secondary save" data-dbid="exifFilename" data-style="zoom-in">'.svg2('save').'</button></div>':'';?>
            </div>
          </div>
          <div class="form-group row">
            <label for="exifCamera" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Camera</label>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <input type="text" id="exifCamera" class="form-control textinput" value="<?php echo$r['exifCamera'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifCamera"<?php echo$user['options'][1]==1?' placeholder="Enter a Camera"':' readonly';?>>
              <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifCamera" class="btn btn-secondary save" data-dbid="exifCamera" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
            </div>
          </div>
        <div class="form-group row">
          <label for="exifLens" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Lens</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="exifLens" class="form-control textinput" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifLens"<?php echo$user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifLens" class="btn btn-secondary save" data-dbid="exifLens" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="exifAperture" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Aperture</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="exifAperture" class="form-control textinput" value="<?php echo$r['exifAperture'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifAperture"<?php echo$user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifAperture" class="btn btn-secondary save" data-dbid="exifAperture" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="exifFocalLength" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Focal Length</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="exifFocalLength" class="form-control textinput" value="<?php echo$r['exifFocalLength'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifFocalLength"<?php echo$user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifFocalLength" class="btn btn-secondary save" data-dbid="exifFocalLength" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="exifShutterSpeed" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Shutter Speed</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="exifShutterSpeed" class="form-control textinput" value="<?php echo$r['exifShutterSpeed'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifShutterSpeed"<?php echo$user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifShutterSpeed" class="btn btn-secondary save" data-dbid="exifShutterSpeed" data-style="zoom-in" role="button" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="exifISO" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">ISO</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="exifISO" class="form-control textinput" value="<?php echo$r['exifISO'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifISO"<?php echo$user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly';?>>
            <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifISO" class="btn btn-secondary save" data-dbid="exifISO" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
          <div class="form-group row">
            <label for="exifti" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Taken</label>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <input type="text" id="exifti" class="form-control textinput" value="<?php echo$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>"" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifti"<?php echo$user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly';?>>
              <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifti" class="btn btn-secondary save" data-dbid="exifti" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
            </div>
          </div>
        </fieldset>
        <fieldset class="control-fieldset">
          <legend class="control-legend">Image Attribution</legend>
          <div class="form-group row">
            <label for="attributionImageName" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Name</label>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <input type="text" id="attributionImageName" list="attributionImageName_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="attributionImageName"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
<?php if($user['options'][1]==1){
$s=$db->query("SELECT DISTINCT attributionImageName AS name FROM `".$prefix."media` UNION SELECT DISTINCT name AS name FROM content UNION SELECT DISTINCT name AS name FROM login ORDER BY name ASC");
  if($s->rowCount()>0){
              echo'<datalist id="attributionImageName_option">';
    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
              echo'</datalist>';
  }
}
              echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveattributionImageName" class="btn btn-secondary save" data-dbid="attributionImageName" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
            </div>
          </div>
          <div class="form-group row">
            <label for="attributionImageURL" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">URL</label>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="attributionImageURL"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
<?php if($user['options'][1]==1){
  $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."media` ORDER BY attributionImageURL ASC");
  if($s->rowCount()>0){
              echo'<datalist id="attributionImageURL_option">';
    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';
              echo'</datalist>';
  }
}
              echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveattributionImageURL" class="btn btn-secondary save" data-dbid="attributionImageURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</main>
