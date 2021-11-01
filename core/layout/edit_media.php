<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media - Edit
 * @package    core/layout/edit_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('content','i-3x');?></div>
          <div>Media Edit</div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="tooltip" aria-label="Back"><?= svg2('back');?></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></a>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Media</a></li>
          <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
          <li class="breadcrumb-item active"><?=$r['title'];?></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <div class="row">
          <div class="col-12 col-md-10 order-1 order-md-1 mb-4 mb-md-0">
            <label id="mediaTitle" for="title"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaTitle" data-tooltip="tooltip" aria-label="PermaLink to Media Title Field">&#128279;</a>':'';?>Title</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title" data-tooltip="tooltip" aria-label="SEO Title Information"><?= svg2('seo');?></button>
              <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="title" data-bs="trash" type="text" value="<?=$r['title'];?>"<?=$user['options'][1]==1?' placeholder="Media Item Title...."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label id="mediaImageALT" for="fileALT"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaImageALT" data-tooltip="tooltip" aria-label="PermaLink to Media Image ALT Field">&#128279;</a>':'';?>Image ALT</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><?= svg2('seo');?></button>
              <input class="textinput" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Image ALT Text..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-dbid="fileALT" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-md-2 order-1 order-md-2 mb-4 mb-md-0">
            <?php if(file_exists('media/sm/'.basename($r['file'])))$thumb='media/sm/'.basename($r['file']);
            else$thumb=NOIMAGE;?>
            <a class="card bg-dark m-2" data-fancybox="media" href="<?=$r['file'];?>">
              <img src="<?=$thumb;?>" alt="Media <?=$r['id'];?>">
            </a>
          </div>
        </div>
        <label id="mediaTags" for="tags"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaTags" data-tooltip="tooltip" aria-label="PermaLink to Media Tags Field">&#128279;</a>':'';?>Tags</label>
        <div class="form-row">
          <input class="textinput" id="tags" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="tags" type="text" value="<?=$r['tags'];?>"<?=$user['options'][1]==1?' placeholder="Enter Tags..."':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="savetags" data-dbid="tags" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaDateCreated" for="ti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaDateCreated" data-tooltip="tooltip" aria-label="PermaLink to Media Date Created Field">&#128279;</a>':'';?>Created</label>
        <div class="form-row">
          <input id="ti" type="text" value="<?= date($config['dateFormat'],$r['ti']);?>" readonly>
        </div>
        <label id="mediaViews" for="views"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaViews" data-tooltip="tooltip" aria-label="PermaLink to Media Views Field">&#128279;</a>':'';?>Views</label>
        <div class="form-row">
          <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`media`,`views`,`0`);">'.svg2('eraser').'</button>'.
          '<button class="save" id="saveviews" data-dbid="views" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-3">
            <label id="mediaCategoryOne" for="category_1"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaCategoryOne" data-tooltip="tooltip" aria-label="PermaLink to Media Category One Field">&#128279;</a>':'';?>Category One</label>
            <div class="form-row">
              <input class="textinput" id="category_1" list="category_1_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_1" type="text" value="<?=$r['category_1'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
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
          </div>
          <div class="col-12 col-sm-6 pl-3">
            <label id="mediaCategoryTwo" for="category_2"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaCategoryTwo" data-tooltip="tooltip" aria-label="PermaLink to Media Category Two Field">&#128279;</a>':'';?>Category Two</label>
            <div class="form-row">
              <input class="textinput" id="category_2" list="category_2_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_2" type="text" value="<?=$r['category_2'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
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
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-3">
            <label id="mediaCategoryThree" for="category_3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaCategoryThree" data-tooltip="tooltip" aria-label="PermaLink to Media Category Three Field">&#128279;</a>':'';?>Category Three</label>
            <div class="form-row">
              <input class="textinput" id="category_3" list="category_3_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_3" type="text" value="<?=$r['category_3'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
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
          </div>
          <div class="col-12 col-sm-6 pl-3">
            <label id="mediaCategoryFour" for="category_4"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaCategoryFour" data-tooltip="tooltip" aria-label="PermaLink to Media Category Four Field">&#128279;</a>':'';?>Category Four</label>
            <div class="form-row">
              <input class="textinput" id="category_4" list="category_4_options" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="category_4" type="text" value="<?=$r['category_4'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
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
          </div>
        </div>
        <legend class="mt-3">EXIF Information</legend>
        <label id="mediaEXIFFilename" for="exifFilename"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFFilename" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF Filename Field">&#128279;</a>':'';?>Original Filename</label>
        <div class="form-row">
          <input class="textinput" id="exifFilename" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifFilename" type="text" value="<?=$r['exifFilename'];?>"<?=$user['options'][1]==1?' placeholder="Original Filename..."':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifFilename" data-dbid="exifFilename" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaEXIFCamera" for="exifCamera"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFCamera" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF Camera Field">&#128279;</a>':'';?>Camera</label>
        <div class="form-row">
          <input class="textinput" id="exifCamera" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifCamera" type="text" value="<?=$r['exifCamera'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Camera"':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifCamera" data-dbid="exifCamera" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaEXIFLens" for="exifLens"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFLens" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF Lens Field">&#128279;</a>':'';?>Lens</label>
        <div class="form-row">
          <input class="textinput" id="exifLens" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifLens" type="text" value="<?=$r['exifLens'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifLens" data-dbid="exifLens" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaEXIFAperture" for="exifAperture"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFAperture" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF Aperture Field">&#128279;</a>':'';?>Aperture</label>
        <div class="form-row">
          <input class="textinput" id="exifAperture" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifAperture" type="text" value="<?=$r['exifAperture'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifAperture" data-dbid="exifAperture" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaEXIFFocalLength" for="exifFocalLength"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFFocalLength" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF Focal Length Field">&#128279;</a>':'';?>Focal Length</label>
        <div class="form-row">
          <input class="textinput" id="exifFocalLength" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifFocalLength" type="text" value="<?=$r['exifFocalLength'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifFocalLength" data-dbid="exifFocalLength" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaEXIFShutterSpeed" for="exifShutterSpeed"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFShutterSpeed" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF Shutter Speed Field">&#128279;</a>':'';?>Shutter Speed</label>
        <div class="form-row">
          <input class="textinput" id="exifShutterSpeed" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifShutterSpeed" type="text" value="<?=$r['exifShutterSpeed'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifShutterSpeed" data-dbid="exifShutterSpeed" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaEXIFISO" for="exifISO"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFISO" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF ISO Field">&#128279;</a>':'';?>ISO</label>
        <div class="form-row">
          <input class="textinput" id="exifISO" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifISO" type="text" value="<?=$r['exifISO'];?>"<?=$user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifISO" data-dbid="exifISO" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaEXIFDateTaken" for="exifti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaEXIFDateTaken" data-tooltip="tooltip" aria-label="PermaLink to Media EXIF Date Taken Field">&#128279;</a>':'';?>Date&nbsp;Taken</label>
        <div class="form-row">
          <input class="textinput" id="exifti" data-dbid="<?=$r['id'];?>" data-dbt="media" data-dbc="exifti" type="text" value="<?=$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>"<?=$user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly';?>>
          <?=$user['options'][1]==1?'<button class="save" id="saveexifti" data-dbid="exifti" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <legend class="mt-3">Image Attribution</legend>
        <label id="mediaAttributionImageName" for="attributionImageName"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediaAttributionImageName" data-tooltip="tooltip" aria-label="PermaLink to Media Image Attribution Name Field">&#128279;</a>':'';?>Name</label>
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
          echo$user['options'][1]==1?'<button class="save" id="saveattributionImageName" data-dbid="attributionImageName" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <label id="mediaAttributionImageURL" for="attributionImageURL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/edit/'.$r['id'].'#mediAttributionImageURL" data-tooltip="tooltip" aria-label="PermaLink to Media Image Attribution URL Field">&#128279;</a>':'';?>URL</label>
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
          echo$user['options'][1]==1?'<button class="save" id="saveattributionImageURL" data-dbid="attributionImageURL" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
