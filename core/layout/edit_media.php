<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media - Edit
 * @package    core/layout/edit_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Media</a></li>
                <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                <li class="breadcrumb-item active"><?=$r['title'];?></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                '<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></a>';?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <div class="row">
              <div class="col-12 col-sm-9 order-1 order-md-1 mb-4 mb-md-0">
                <label for="title" class="mt-0">Title</label>
                <div class="form-row">
                  <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
                  <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="title" data-bs="trash" type="text" value="<?=$r['title'];?>"<?=$user['options'][1]==1?' placeholder="Media Item Title...."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <label for="fileALT">Image ALT</label>
                <div class="form-row">
                  <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><i class="i">seo</i></button>
                  <input class="textinput" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Image ALT Text..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-dbid="fileALT" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-sm-3 order-1 order-md-2 mb-4 mb-md-0">
                <?php if(file_exists('media/sm/'.basename($r['file'])))
                  $thumb='media/sm/'.basename($r['file']);
                elseif($r['file']!='')
                  $thumb=$r['file'];
                else
                  $thumb=NOIMAGE;?>
                <div class="card m-1">
                  <figure class="card-image" style="height:9.5rem;">
                    <a data-fancybox="media" href="<?=$r['file'];?>">
                      <img src="<?=$thumb;?>" alt="Media <?=$r['id'];?>">
                    </a>
                  </figure>
                </div>
              </div>
            </div>
            <label for="tags">Tags</label>
            <div class="form-row">
              <input class="textinput" id="tags" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="tags" type="text" value="<?=$r['tags'];?>"<?=$user['options'][1]==1?' placeholder="Enter Tags..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savetags" data-dbid="tags" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="ti">Created</label>
            <div class="form-row">
              <input id="ti" type="text" value="<?= date($config['dateFormat'],$r['ti']);?>" readonly>
            </div>
            <label for="views">Views</label>
            <div class="form-row">
              <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
              <?=($user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`media`,`views`,`0`);"><i class="i">eraser</i></button>'.
              '<button class="save" id="saveviews" data-dbid="views" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-3">
                <label for="category_1">Category One</label>
                <div class="form-row">
                  <input class="textinput" id="category_1" list="category_1_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_1" type="text" value="<?=$r['category_1'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                  <?php if($user['options'][1]==1){
                    $sc=$db->query("SELECT DISTINCT `category_1` FROM `".$prefix."media` WHERE `category_1`!='' ORDER BY `category_1` ASC");
                    if($sc->rowCount()>0){
                      echo'<datalist id="category_1_options">';
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
                      echo'</datalist>';
                    }
                    echo'<button class="save" id="savecategory_1" data-dbid="category_1" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                  }?>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <label for="category_2">Category Two</label>
                <div class="form-row">
                  <input class="textinput" id="category_2" list="category_2_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_2" type="text" value="<?=$r['category_2'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                  <?php if($user['options'][1]==1){
                    $sc=$db->query("SELECT DISTINCT `category_2` FROM `".$prefix."content` WHERE `category_2`!='' ORDER BY `category_2` ASC");
                    if($sc->rowCount()>0){
                      echo'<datalist id="category_2_options">';
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_2'].'"/>';
                      echo'</datalist>';
                    }
                    echo'<button class="save" id="savecategory_2" data-dbid="category_2" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                  }?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-3">
                <label for="category_3">Category Three</label>
                <div class="form-row">
                  <input class="textinput" id="category_3" list="category_3_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_3" type="text" value="<?=$r['category_3'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                  <?php if($user['options'][1]==1){
                    $sc=$db->query("SELECT DISTINCT `category_3` FROM `".$prefix."media` WHERE `category_3`!='' ORDER BY `category_3` ASC");
                    if($sc->rowCount()>0){
                      echo'<datalist id="category_3_options">';
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_3'].'"/>';
                      echo'</datalist>';
                    }
                    echo'<button class="save" id="savecategory_3" data-dbid="category_3" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                  }?>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <label for="category_4">Category Four</label>
                <div class="form-row">
                  <input class="textinput" id="category_4" list="category_4_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_4" type="text" value="<?=$r['category_4'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                  <?php if($user['options'][1]==1){
                    $sc=$db->query("SELECT DISTINCT `category_4` FROM `".$prefix."media` WHERE `category_4`!='' ORDER BY `category_4` ASC");
                    if($sc->rowCount()>0){
                      echo'<datalist id="category_4_options">';
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_4'].'"/>';
                      echo'</datalist>';
                    }
                    echo'<button class="save" id="savecategory_4" data-dbid="category_4" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                  }?>
                </div>
              </div>
            </div>
            <legend class="mt-3">EXIF Information</legend>
            <label for="exifFilename">Original Filename</label>
            <div class="form-row">
              <input class="textinput" id="exifFilename" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifFilename" type="text" value="<?=$r['exifFilename'];?>"<?=$user['options'][1]==1?' placeholder="Original Filename..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifFilename" data-dbid="exifFilename" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="exifCamera">Camera</label>
            <div class="form-row">
              <input class="textinput" id="exifCamera" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifCamera" type="text" value="<?=$r['exifCamera'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Camera"':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifCamera" data-dbid="exifCamera" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="exifLens">Lens</label>
            <div class="form-row">
              <input class="textinput" id="exifLens" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifLens" type="text" value="<?=$r['exifLens'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifLens" data-dbid="exifLens" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="exifAperture">Aperture</label>
            <div class="form-row">
              <input class="textinput" id="exifAperture" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifAperture" type="text" value="<?=$r['exifAperture'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifAperture" data-dbid="exifAperture" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="exifFocalLength">Focal Length</label>
            <div class="form-row">
              <input class="textinput" id="exifFocalLength" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifFocalLength" type="text" value="<?=$r['exifFocalLength'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifFocalLength" data-dbid="exifFocalLength" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="exifShutterSpeed">Shutter Speed</label>
            <div class="form-row">
              <input class="textinput" id="exifShutterSpeed" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifShutterSpeed" type="text" value="<?=$r['exifShutterSpeed'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifShutterSpeed" data-dbid="exifShutterSpeed" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="exifISO">ISO</label>
            <div class="form-row">
              <input class="textinput" id="exifISO" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifISO" type="text" value="<?=$r['exifISO'];?>"<?=$user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifISO" data-dbid="exifISO" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="exifti">Date Taken</label>
            <div class="form-row">
              <input class="textinput" id="exifti" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifti" type="text" value="<?=$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>"<?=$user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveexifti" data-dbid="exifti" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <legend class="mt-3">Image Attribution</legend>
            <label for="attributionImageName">Name</label>
            <div class="form-row">
              <input class="textinput" id="attributionImageName" list="attributionImageName_option" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="attributionImageName" type="text" value="<?=$r['attributionImageName'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
              <?php if($user['options'][1]==1){
                $s=$db->query("SELECT DISTINCT `attributionImageName` AS name FROM `".$prefix."media` UNION SELECT DISTINCT `name` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` AS name FROM `".$prefix."login` ORDER BY `name` ASC");
                if($s->rowCount()>0){
                  echo'<datalist id="attributionImageName_option">';
                    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
                  echo'</datalist>';
                }
              }
              echo$user['options'][1]==1?'<button class="save" id="saveattributionImageName" data-dbid="attributionImageName" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="attributionImageURL">URL</label>
            <div class="form-row">
              <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="attributionImageURL" type="text" value="<?=$r['attributionImageURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
              <?php if($user['options'][1]==1){
                $s=$db->query("SELECT DISTINCT `attributionImageURL` AS url FROM `".$prefix."media` ORDER BY `attributionImageURL` ASC");
                if($s->rowCount()>0){
                  echo'<datalist id="attributionImageURL_option">';
                    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';
                  echo'</datalist>';
                }
              }
              echo$user['options'][1]==1?'<button class="save" id="saveattributionImageURL" data-dbid="attributionImageURL" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
