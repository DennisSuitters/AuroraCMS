<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Course - Edit
 * @package    core/layout/edit_course.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="row">
        <div class="card col-12 col-sm mt-3 bg-transparent border-0 overflow-visible order-2 order-sm-1">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-6">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/course';?>">Course</a></li>
                  <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                  <li class="breadcrumb-item active"><?=$r['title'];?></li>
                </ol>
              </div>
              <div class="col-12 col-sm-6 text-right">
                <div class="btn-group">
                  <?php if(isset($_SERVER['HTTP_REFERER'])){?>
                    <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>
                  <?php }?>
                  <button class="btn <?=$r['status']=='published'?'':'hidden';?>" data-social-share="<?= URL.'course/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" data-tooltip="left" aria-label="Share on Social Media"><i class="i">share</i></button>
                  <a class="btn add" href="<?= URL.$settings['system']['admin'];?>/add/course" role="button" data-tooltip="left" aria-label="Add Course"><i class="i">add</i></a>
                  <button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Content</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Images</label>
            <input class="tab-control" id="tab1-3" name="tabs" type="radio">
            <label for="tab1-3">Media</label>
            <input class="tab-control" id="tab1-8" name="tabs" type="radio">
            <label for="tab1-8">SEO</label>
            <input class="tab-control" id="tab1-9" name="tabs" type="radio">
            <label for="tab1-9">Settings</label>
            <input class="tab-control" id="tab1-10" name="tabs" type="radio">
            <label for="tab1-10">Modules</label>
            <input class="tab-control" id="tab1-11" name="tabs" type="radio">
            <label for="tab1-11">Certificate</label>
            <input class="tab-control" id="tab1-12" name="tabs" type="radio">
            <label for="tab1-12">Students</label>
<?php /* Content */?>
            <div class="tab1-1 border-top p-4" data-tabid="tab1-1" role="tabpanel">
              <div class="form-row">
                <label id="courseTitle" for="title"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseTitle" data-tooltip="tooltip" aria-label="PermaLink to Course Title Field">&#128279;</a>':'';?>Title</label>
                <small class="form-text text-right">Course MUST contain a Title, to be able to generate a URL Slug or the content won't be accessible. This Title is also used For H1 Headings on pages.</small>
              </div>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
                <?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'course',
                    ':c'=>'title'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=course&c=title" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }?>
                <input class="textinput" id="title" type="text" value="<?=$r['title'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="trash" onkeyup="genurl();$('#titleupdate').text($(this).val());"<?=$user['options'][1]==1?' placeholder="Course MUST contain a Title, to be able to generate a URL Slug or the content won\'t be accessible...."':' readonly';?>>
                <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Generate Aussie Lorem Ipsum Title" onclick="ipsuMe(`title`);genurl();$(`#titleupdate`).text($(`#title`).val());$(`#savetitle`).addClass(`trash`);return false;"><i class="i">loremipsum</i></button>'.
                '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=course&c=title" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                '<button class="analyzeTitle" data-test="title" data-tooltip="tooltip" aria-label="Analyze Title Text"><i class="i">seo</i></button>'.
                '<button class="save" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?= URL;?>course/"+slugify(data);
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                  $('#google-link').text(url);
                  $("[data-social-share]").data("social-share",url);
                }
                function slugify(str){
                  str=str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g,' ').toLowerCase();
                  str=str.replace(/^\s+|\s+$/gm,'');
                  str=str.replace(/\s+/g,'-');
                  return str;
                }
              </script>
              <label id="courseURLSlug" for="genurl"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseURLSlug" data-tooltip="tooltip" aria-label="PermaLink to Course URL Slug">&#128279;</a>':'';?>URL Slug</label>
              <div class="form-row">
                <div class="input-text col-12">
                  <a id="genurl" target="_blank" href="<?= URL.'course/'.$r['urlSlug'];?>"><?= URL.'course/'.$r['urlSlug'].' <i class="i">new-window</i>';?></a>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-3">
                  <label id="courseDateCreated" for="ti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseDateCreated" data-tooltip="tooltip" aria-label="PermaLink to Course Created Date">&#128279;</a>':'';?>Created</label>
                  <div class="form-row">
                    <input id="ti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['ti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`ti`,getTimestamp(`ti`),`select`);"':' readonly';?>>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-3">
                  <label id="coursePublishedDate" for="pti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#coursePublishedDate" data-tooltip="tooltip" aria-label="PermaLink to Course Published Date Field">&#128279;</a>':'';?>Published On <span class="labeldate" id="labeldatepti">(<?= date($config['dateFormat'],$r['pti']);?>)</span></label>
                  <div class="form-row">
                    <input id="pti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['pti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`pti`,getTimestamp(`pti`),`select`);"':' readonly';?>>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-3">
                  <label id="courseCategoryOne" for="category_1"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseCategoryOne" data-tooltip="tooltip" aria-label="PermaLink to Course Category One Field">&#128279;</a>':'';?>Category One</label>
                  <div class="form-row">
                    <input class="textinput" id="category_1" list="category_1_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="category_1" type="text" value="<?=$r['category_1'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        echo'<datalist id="category_1_options">';
                        $sc=$db->prepare("SELECT DISTINCT `title` FROM `".$prefix."choices` WHERE `title`!='' AND `contentType`='category' AND `url`=:url ORDER BY `title` ASC");
                        $sc->execute([':url'=>'course']);
                        if($sc->rowCount()>0){
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['title'].'"/>';
                        }
                        $sc=$db->query("SELECT DISTINCT `category_1` FROM `".$prefix."content` WHERE `category_1`!='' ORDER BY `category_1` ASC");
                        if($sc->rowCount()>0){
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
                        }
                        echo'</datalist>'.
                        '<button class="save" id="savecategory_1" data-dbid="category_1" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 pl-md-3">
                    <label id="courseCategoryTwo" for="category_2"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseCategoryTwo" data-tooltip="tooltip" aria-label="PermaLink to Course Category Two Field">&#128279;</a>':'';?>Category Two</label>
                    <div class="form-row">
                      <input class="textinput" id="category_2" list="category_2_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="category_2" type="text" value="<?=$r['category_2'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        $sc=$db->query("SELECT DISTINCT `category_2` FROM `".$prefix."content` WHERE `category_2`!='' ORDER BY `category_2` ASC");
                        if($sc->rowCount()>0){
                          echo'<datalist id="category_2_options">';
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_2'].'"/>';
                          echo'</datalist>';
                        }
                        echo'<button class="save" id="savecategory_2" data-dbid="category_2" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseShowCost" data-tooltip="tooltip" aria-label="PermaLink to Course Show Cost Checkbox">&#128279;</a>':'';?>
                  <input id="courseshowCost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0" type="checkbox"<?=($r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="courseshowCost" id="courseoptions0<?=$r['id'];?>">Show Cost</label>
                </div>
                <div class="row">
                  <div class="col-12 col-sm">
                    <label id="courseCost" for="cost"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseCost" data-tooltip="tooltip" aria-label="PermaLink to Course Cost Field">&#128279;</a>':'';?>Cost</label>
                    <div class="form-row">
                      <div class="input-text">$</div>
                      <input class="textinput" id="cost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="cost" type="text" value="<?=$r['cost'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Cost..."':' readonly';?>>
                      <?php if($r['cost']==0)
                        $gst=0;
                      else{
                        if(isset($config['gst'])&&is_numeric($config['gst'])){
                          $gst=$r['cost'] * ($config['gst'] / 100);
                          $gst=$r['cost'] + $gst;
                          $gst=number_format((float)$gst,2,'.','');
                        }else $gst=0;
                      }?>
                      <div class="input-text<?=$config['gst']==0?' d-none':'';?>" id="gstcost" data-gst="Incl. GST"><?=$gst;?></div>
                      <?=$user['options'][1]==1?'<button class="save" id="savecost" data-dbid="cost" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm pl-sm-3">
                    <label id="courseReducedCost" for="rCost"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseReducedCost" data-tooltip="tooltip" aria-label="PermaLink to Course Reduced Cost Field">&#128279;</a>':'';?>Reduced Cost</label>
                    <div class="form-row">
                      <div class="input-text">$</div>
                      <input class="textinput" id="rCost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rCost" type="text" value="<?=$r['rCost'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Reduced Cost..."':' readonly';?>>
                      <?php if($r['cost']==0)
                        $gst=0;
                      else{
                        if(isset($config['gst'])&&is_numeric($config['gst'])){
                          $gst=$r['rCost']*($config['gst']/100);
                          $gst=$r['rCost']+$gst;
                          $gst=number_format((float)$gst,2,'.','');
                        }else $gst=0;
                      }?>
                      <div class="input-text<?=$config['gst']==0?' d-none':'';?>" id="gstrCost" data-gst="Incl. GST"><?=$gst;?></div>
                      <?=$user['options'][1]==1?'<button class="save" id="saverCost" data-dbid="rCost" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm">
                      <label id="courseRating" for="rating"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseRating" data-tooltip="tooltip" aria-label="PermaLink to Course Minimum Score to Pass Field">&#128279;</a>':'';?>Minimum Score to Pass</label>
                      <div class="form-row">
                        <input class="textinput" id="rating" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rating" type="number" value="<?=$r['rating'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Minimum Score to Pass this Course..."':' readonly';?>>
                        <?php if($user['options'][1]==1){
                          echo'<button class="save" id="saverating" data-dbid="rating" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                        }?>
                      </div>
                      <small class="form-text text-muted">'0' Disables Minimum Score.</small>
                    </div>
                    <div class="col-12 col-sm pl-sm-3">
                      <label id="courseAttempts" for="attempts"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseAttempts" data-tooltip="tooltip" aria-label="PermaLink to Course Attempts Field">&#128279;</a>':'';?>Attempts Allowed to Pass Course</label>
                      <div class="form-row">
                        <input class="textinput" id="attempts" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="attempts" type="text" value="<?=$r['attempts'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Number of Allowed Attempts..."':' readonly';?>>
                        <?php if($user['options'][1]==1){
                          echo'<button class="save" id="saveattempts" data-dbid="attempts" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                        }?>
                      </div>
                      <small class="form-text text-muted">'0' Disables Attempts Allowed.</small>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#summernote" data-tooltip="tooltip" aria-label="PermaLink to Course Notes">&#128279;</a>':'';?>
                    <?php if($user['options'][1]==1){
                      echo'<div class="wysiwyg-toolbar">'.
                        '<div class="btn-group d-flex justify-content-end">';
                        if($r['suggestions']==1){
                          $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                          $ss->execute([
                            ':rid'=>$r['id'],
                            ':t'=>'course',
                            ':c'=>'notes'
                          ]);
                          echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=course&c=notes" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i text-success">lightbulb</i></button>':'';
                        }
                        echo'<button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Content.md" data-type="content" data-tooltip="tooltip" aria-label="SEO Content Information"><i class="i">seo</i></button>'.
                        '<button data-tooltip="tooltip" aria-label="Show Element Blocks" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;"><i class="i">blocks</i></button>'.
                        '<input class="col-1" id="ipsumc" value="5">'.
                        '<button data-tooltip="tooltip" aria-label="Add Aussie Lorem Ipsum" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;"><i class="i">loremipsum</i></button>'.
                        '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=course&c=notes" data-tooltip="tooltip" aria-label="Add Suggestions"><i class="i">idea</i></button>'.
                      '</div>'.
                    '</div>';?>
                    <div id="notesda" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
                    <form id="summernote" target="sp" method="post" action="core/update.php" enctype="multipart/form-data">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input name="t" type="hidden" value="content">
                      <input name="c" type="hidden" value="notes">
                      <textarea class="summernote" id="notes" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?= rawurldecode($r['notes']);?></textarea>
                    </form>
                  <?php }else{?>
                    <div class="note-editor note-frame">
                      <div class="note-editing-area">
                        <div class="note-editable">
                          <?= rawurldecode($r['notes']);?>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
<?php /* Images */ ?>
            <div class="tab1-2 border-top p-4" data-tabid="tab1-2" role="tabpanel">
              <div id="error"></div>
              <label id="courseImageURL" for="fileURL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseImageURL" data-tooltip="tooltip" aria-label="PermaLink to Course Image URL Field">&#128279;</a>':'';?>URL</label>
              <div class="form-row">
                <input class="textinput" id="fileURL" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="fileURL" type="text" value="<?=$r['fileURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                <?=$r['fileURL']!=''?'<a data-fancybox="url" href="'.$r['fileURL'].'"><img id="urlimage" src="'.$r['fileURL'].'"></a>':'<img id="urlimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                <?=$user['options'][1]==1?'<button class="save" id="savefileURL" data-dbid="fileURL" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label id="courseImage" for="file"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseImage" data-tooltip="tooltip" aria-label="PermaLink to Course Image Field">&#128279;</a>':'';?>Image</label>
              <div class="form-row">
                <input class="textinput" id="file" type="text" value="<?=$r['file'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="file" readonly>
                <?php if($user['options'][1]==1){?>
                  <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','content','file');"><i class="i">browse-media</i></button>
                <?php }
                echo$r['file']!=''&&file_exists('media/'.basename($r['file']))?'<a data-fancybox="course'.$r['id'].'" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img id="fileimage" src="'.$r['file'].'" alt="Course: '.$r['title'].'"></a>':'<img id="fileimage" src="'.ADMINNOIMAGE.'" alt="No Image">';
                echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`file`,``);"><i class="i">trash</i></button>'.
                '<button class="save" id="savefile" data-dbid="file" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label id="courseThumbnail" for="thumb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseThumbnail" data-tooltip="tooltip" aria-label="PermaLink to Course Thumbnail Field">&#128279;</a>':'';?>Thumbnail</label>
              <div class="form-row">
                <input class="textinput" id="thumb" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="thumb" type="text" value="<?=$r['thumb'];?>">
                <?php if($user['options'][1]==1){?>
                  <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','content','thumb');"><i class="i">browse-media</i></button>
                <?php }
                echo$r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb']))?'<a data-fancybox="thumb'.$r['id'].'" data-caption="Thumbnail: '.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['thumb'].'"><img id="thumbimage" src="'.$r['thumb'].'" alt="Thumbnail: '.$r['title'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';
                echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`thumb`,``);"><i class="i">trash</i></button>'.
                '<button class="save" id="savethumb" data-dbid="thumb" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label id="courseImageALT" for="fileALT"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseImageALT" data-tooltip="tooltip" aria-label="PermaLink to Course Image Alt Field">&#128279;</a>':'';?>Image ALT</label>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-type="alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><i class="i">seo</i></button>
                <input class="textinput" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Image ALT Text..."':' readonly';?>>
                <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-tooltip="tooltip" aria-label="Save" data-dbid="fileALT" data-style="zoom-in"><i class="i">save</i></button>':'';?>
              </div>
            </div>
<?php /* Media */ ?>
            <div class="tab1-3 border-top p-4" data-tabid="tab1-3" role="tabpanel">
              <form class="form-row" target="sp" method="post" action="core/add_media.php" enctype="multipart/form-data">
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <input name="rid" type="hidden" value="<?=$r['id'];?>">
                <input name="t" type="hidden" value="content">
                <input id="mediafile" name="fu" type="text" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','media','mediafile');return false;"><i class="i">browse-media</i></button>
                <button class="add" data-tooltip="tooltip" aria-label="Add" type="submit"><i class="i">add</i></button>
              </form>
              <div class="row mt-3" id="mi">
              <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `pid`=:id ORDER BY `ord` ASC");
              $sm->execute([':id'=>$r['id']]);
              if($sm->rowCount()>0){
                while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                  if(file_exists('media/md/'.basename($rm['file'])))
                    $thumb='media/md/'.basename($rm['file']);
                  else
                    $thumb=ADMINNOIMAGE;?>
                  <div id="mi_<?=$rm['id'];?>" class="card stats col-6 col-sm m-1">
                    <?php if($user['options'][1]==1){?>
                      <div class="btn-group float-right">
                        <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item"><i class="i">drag</i></div>
                        <div class="btn" data-tooltip="tooltip" aria-label="Viewed <?=$rm['views'];?> times"><i class="i">view <?=$rm['views'];?></i></div>
                        <a class="btn" href="<?= URL.$settings['system']['admin'].'/media/edit/'.$rm['id'];?>" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                        <button class="btn trash" onclick="purge('<?=$rm['id'];?>','media')" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </div>
                    <?php }?>
                    <a data-fancybox="media" data-type="image" data-caption="<?=($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Course Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?=$rm['file'];?>" style="display:flex;max-height:150px;">
                      <img src="<?=$thumb;?>" alt="Media <?=$rm['id'];?>" style="object-fit:cover;object-position:center;">
                    </a>
                  </div>
                <?php }
                if($user['options'][1]==1){?>
                  <script>
                    $('#mi').sortable({
                      items:".card",
                      placeholder:".ghost",
                      helper:fixWidthHelper,
                      update:function(e,ui){
                        var order=$("#mi").sortable("serialize");
                        $.ajax({
                          type:"POST",
                          dataType:"json",
                          url:"core/reordermedia.php",
                          data:order
                        });
                      }
                    }).disableSelection();
                    function fixWidthHelper(e,ui){
                      ui.children().each(function(){
                        $(this).width($(this).width());
                      });
                      return ui;
                    }
                  </script>
              <?php }
              }?>
            </div>
          </div>
<?php /* SEO */?>
          <div class="tab1-8 border-top p-4" data-tabid="tab1-8" role="tabpanel">
            <label id="courseViews" for="views"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseViews" data-tooltip="tooltip" aria-label="PermaLink to Course Views Field">&#128279;</a>':'';?>Views</label>
            <div class="form-row">
              <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`content`,`views`,`0`);"><i class="i">eraser</i></button>'.
              '<button class="save" id="saveviews" data-dbid="views" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label id="courseMetaRobots" for="metaRobots"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseMetaRobots" data-tooltip="tooltip" aria-label="PermaLink to Course Meta Robots Field">&#128279;</a>':'';?>Meta&nbsp;Robots</label>
              <?php if($user['options'][1]==1){?>
                <small class="form-text text-right">Options for Meta Robots: <span data-tooltip="left" data-tooltip="tooltip" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></small>
              <?php }?>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Robots.md" data-tooltip="tooltip" aria-label="SEO Meta Robots Information"><i class="i">seo</i></button>
              <?php if($user['options'][1]==1){
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'course',
                    ':c'=>'metaRobots'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=course&c=metaRobots" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }
              }?>
              <input class="textinput" id="metaRobots" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="metaRobots" type="text" value="<?=$r['metaRobots'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=course&c=metaRobots" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="save" id="savemetaRobots" data-dbid="metaRobots" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <div class="card google-result mt-3 p-3 overflow-visible" id="courseSearchResult">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseSearchResult" data-tooltip="tooltip" aria-label="PermaLink to Course Search Result Example">&#128279;</a>':'';?>
              <div id="google-title" data-tooltip="tooltip" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below the information is then tried to be used from the Pages Meta Title, if that is empty then an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                <?=($r['seoTitle']!=''?$r['seoTitle']:$r['title']).' | '.$config['business'];?>
              </div>
              <div id="google-link">
                <?= URL.'course/'.$r['urlSlug'];?>
              </div>
              <div id="google-description" data-tooltip="tooltip" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, the page Meta Description will be used, if that is empty a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                <?php if($r['seoDescription']!='')
                  echo$r['seoDescription'];
                else
                  echo$config['seoDescription'];?>
              </div>
            </div>
            <div class="form-row mt-3">
              <label id="courseSEOTitle" for="seoTitle"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseSEOTitle" data-tooltip="tooltip" aria-label="PermaLink to Course Meta Title Field">&#128279;</a>':'';?>Meta&nbsp;Title</label>
              <small class="form-text text-right">The recommended character count for Title\'s is 65.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
              <?php $cntc=65-strlen($r['seoTitle']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text">
                <span class="text-success<?=$cnt<0?' text-danger':'';?>" id="seoTitlecnt"><?=$cnt;?></span>
              </div>
              <?php if($user['options'][1]==1){?>
                <button data-tooltip="tooltip" aria-label="Remove Stop Words" onclick="removeStopWords('seoTitle',$('#seoTitle').val());"><i class="i">magic</i></button>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'course',
                    ':c'=>'seoTitle'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=course&c=seoTitle" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }
              }?>
              <input class="textinput" id="seoTitle" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="seoTitle" type="text" value="<?=$r['seoTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Title..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=course&c=seoTitle" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="analyzeTitle" data-test="seoTitle" data-tooltip="tooltip" aria-label="Analyze Meta Title Text"><i class="i">seo</i></button>'.
              '<button class="save" id="saveseoTitle" data-dbid="seoTitle" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label id="courseSEODescription" for="seoDescription"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseSEODescription" data-tooltip="tooltip" aria-label="PermaLink to Course Meta Description Field">&#128279;</a>':'';?>Meta&nbsp;Description</label>
              <small class="form-text text-right">The recommended character count for Descriptions is 230.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Description.md" data-tooltip="tooltip" aria-label="SEO Meta Description Information"><i class="i">seo</i></button>
              <?php $cntc=230-strlen($r['seoDescription']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text">
                <span class="text-success<?=$cnt<0?' text-danger':'';?>" id="seoDescriptioncnt"><?=$cnt;?></span>
              </div>
              <?php if($user['options'][1]==1){
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'course',
                    ':c'=>'seoDescription'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=course&c=seoDescription" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }
              }?>
              <input class="textinput" id="seoDescription" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="seoDescription" type="text" value="<?=$r['seoDescription'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Description..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=course&c=seoDescription" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="save" id="saveseoDescription" data-dbid="seoDescription" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
          </div>
<?php /* Settings */ ?>
          <div class="tab1-9 border-top p-4" data-tabid="tab1-9" role="tabpanel">
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-3">
                <label id="courseStatus" for="status"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseStatus" data-tooltip="tooltip" aria-label="PermaLink to Course Status Selector">&#128279;</a>':'';?>Status</label>
                <div class="form-row">
                  <select id="status"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Status"':' disabled';?> onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');changeShareStatus($(this).val());">
                    <option value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                    <option value="autopublish"<?=$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                    <option value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                    <option value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
                    <option value="archived"<?=$r['status']=='archived'?' selected':'';?>>Archived</option>
                  </select>
                </div>
              </div>
              <script>
                function changeShareStatus(status){
                  if(status==='published'){
                    $("[data-social-share]").removeClass('hidden').data("social-share",$('#genurl').attr('href'));
                  }else{
                    $("[data-social-share]").addClass('hidden');
                  }
                }
              </script>
              <div class="col-12 col-sm-6 pl-md-3">
                <label id="courseRank" for="rank"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#courseRank" data-tooltip="tooltip" aria-label="PermaLink to Course Access Selector">&#128279;</a>':'';?>Access</label>
                <div class="form-row">
                  <select id="rank" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rank"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','content','rank',$(this).val(),'select');toggleRank($(this).val());">
                    <option value="0"<?=$r['rank']==0?' selected':'';?>>Available to Everyone</option>
                    <option value="100"<?=$r['rank']==100?' selected':'';?>>Subscriber and above</option>
                    <option value="200"<?=$r['rank']==200?' selected':'';?>>Member and above</option>
                    <option value="210"<?=$r['rank']==210?' selected':'';?>>Member Silver and above</option>
                    <option value="220"<?=$r['rank']==220?' selected':'';?>>Member Bronze and above</option>
                    <option value="230"<?=$r['rank']==230?' selected':'';?>>Member Gold and above</option>
                    <option value="240"<?=$r['rank']==240?' selected':'';?>>Member Platinum and above</option>
                    <option value="300"<?=$r['rank']==300?' selected':'';?>>Client and above</option>
                    <option value="310"<?=$r['rank']==310?' selected':'';?>>Wholesaler and above</option>
                    <option value="320"<?=$r['rank']==320?' selected':'';?>>Wholesaler Bronze and above</option>
                    <option value="330"<?=$r['rank']==330?' selected':'';?>>Wholesaler Silver and above</option>
                    <option value="340"<?=$r['rank']==340?' selected':'';?>>Wholesaler Gold and above</option>
                    <option value="350"<?=$r['rank']==350?' selected':'';?>>Wholesaler Platinum and above</option>
                    <option value="400"<?=$r['rank']==400?' selected':'';?>>Contributor and above</option>
                    <option value="500"<?=$r['rank']==500?' selected':'';?>>Author and above</option>
                    <option value="600"<?=$r['rank']==600?' selected':'';?>>Editor and above</option>
                    <option value="700"<?=$r['rank']==700?' selected':'';?>>Moderator and above</option>
                    <option value="800"<?=$r['rank']==800?' selected':'';?>>Manager and above</option>
                    <option value="900"<?=$r['rank']==900?' selected':'';?>>Administrator and above</option>
                  </select>
                  <div class="input-text<?=$r['rank']>300&&$r['rank']<400?' ':' d-none';?>" id="contentRestrict">
                    <input id="restrict" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="2" type="checkbox"<?=($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    &nbsp;<label>Restrict</label>
                  </div>
                </div>
              </div>
              <script>
                function toggleRank(rank){
                  if(rank<301){
                    $('#contentRestrict').removeClass().addClass('input-text d-none');
                  }
                  if(rank>300&&rank<400){
                    $('#contentRestrict').removeClass().addClass('input-text');
                  }
                  if(rank>399){
                    $('#contentRestrict').removeClass('d-none').addClass('input-text d-none');
                  }
                }
              </script>
            </div>
          </div>
<?php /* Modules */ ?>
          <div class="tab1-10 border-top p-4" data-tabid="tab1-10" role="tabpanel">
            <form class="form-row" target="sp" method="post" action="core/add_module.php">
              <input name="rid" type="hidden" value="<?=$r['id'];?>">
              <div class="input-text">Title:</div>
              <input type="text" name="t" value="" placeholder="Enter Module Title...">
              <button class="add" data-tooltip="tooltip" aria-label="Add" type="submit"><i class="i">add</i></button>
            </form>
            <hr>
            <ol id="modules" class="modules-list overflow-visible">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."modules` WHERE `rid`=:id ORDER BY `ord` ASC, `title` ASC");
$sm->execute([':id'=>$r['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
              <li class="module mb-2" id="modules_<?=$rm['id'];?>">
                <div class="form-row">
                  <div class="input-text col-sm ml-2"<?=$rm['caption']!=''?' data-tooltip="tooltip" aria-label="'.$rm['caption'].'"':'';?>><?=$rm['title'];?></div>
                  <a class="btn" href="<?= URL.$settings['system']['admin'];?>/course/module/<?=$rm['id'];?>" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                  <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$rm['id'];?>','modules');"><i class="i">trash</i></button>
                  <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item" onclick="return false;"><i class="i">drag</i></div>
                </div>
              </li>
<?php }?>
            </ol>
          </div>
<?php if($user['options'][1]==1){?>
            <script>
              $('#modules').sortable({
                items:".module",
                placeholder:".ghost",
                helper:fixWidthHelper,
                update:function(e,ui){
                  var order=$("#modules").sortable("serialize");
                  $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"core/reordermodules.php",
                    data:order
                  });
                }
              }).disableSelection();
              function fixWidthHelper(e,ui){
                ui.children().each(function(){
                  $(this).width($(this).width());
                });
                return ui;
              }
            </script>
        <?php }?>
<?php /* Certificate */ ?>
          <div class="tab1-11 border-top p-4" data-tabid="tab1-11" role="tabpanel">
            <div class="form-row justify-content-end">
              <div class="btn-group">
                <a class="btn" target="_blank" href="core/view_certificate.php?id=<?=$r['id'];?>">View Selected Certificate</a>
              </div>
            </div>
            <div class="row mt-3 certificate-chooser justify-content-center">
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==0?' certificate-selected':'';?>" data-certificate="0">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-0.png">
                </figure>
              </article>
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==1?' certificate-selected':'';?>" data-certificate="1">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-1.png">
                </figure>
              </article>
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==2?' certificate-selected':'';?>" data-certificate="2">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-2.png">
                </figure>
              </article>
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==3?' certificate-selected':'';?>" data-certificate="3">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-3.png">
                </figure>
              </article>
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==4?' certificate-selected':'';?>" data-certificate="4">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-4.png">
                </figure>
              </article>
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==5?' certificate-selected':'';?>" data-certificate="5">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-5.png">
                </figure>
              </article>
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==6?' certificate-selected':'';?>" data-certificate="6">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-6.png">
                </figure>
              </article>
              <article class="card col-6 col-sm-2-5 m-1 overflow-visible certificate<?=$r['cid']==7?' certificate-selected':'';?>" data-certificate="7">
                <figure class="card-image position-relative overflow-visible">
                  <img src="media/certificate/certificate-7.png">
                </figure>
              </article>
            </div>
            <script>
              $(".certificate-chooser").not(".disabled").find("figure.card-image").on("click",function(){
                $('.certificate-chooser .certificate').removeClass("certificate-selected");
                $(this).parent('article').addClass("certificate-selected");
                $.ajax({
                  type:"GET",
                  url:"core/update.php",
                  data:{
                    id:<?=$r['id'];?>,
                    t:"content",
                    c:"cid",
                    da:$(this).parent('article').attr("data-certificate")
                  }
                });
              });
            </script>
          </div>
<?php /* Students */ ?>
          <div class="tab1-12 border-top p-4" data-tabid="tab1-12" role="tabpanel">
            <div class="row">
              <form target="sp" method="post" action="core/add_student.php">
                <input type="hidden" name="cid" value="<?=$r['id'];?>">
                <div class="form-row">
                  <select name="uid">
                    <option value="0">Select Student to add to Course</option>
<?php $scu=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` ORDER BY `name` ASC, `username` ASC");
$scu->execute();
while($rcu=$scu->fetch(PDO::FETCH_ASSOC)){?>
                    <option value="<?=$rcu['id'];?>"><?=($rcu['name']!=''?$rcu['name']:$rcu['username']);?></option>
<?php }?>
                  </select>
                  <button type="submit" data-tooltip="tooltip" aria-label="Add Student"><i class="i">add</i></button>
                </div>
              </form>
            </div>
            <div class="form-row mt-3">
<?php $sct=$db->prepare("SELECT * FROM `".$prefix."courseTrack` WHERE `rid`=:rid");
$sct->execute([':rid'=>$r['id']]);?>
              <section class="content overflow-visible list" id="students">
                <?php while($rct=$sct->fetch(PDO::FETCH_ASSOC)){?>
                  <article id="student_<?=$rct['id'];?>" class="card mx-2 mt-3 mb-0 overflow-visible card-list item">
                    <?php $scu=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
                    $scu->execute([':uid'=>$rct['uid']]);
                    $rcu=$scu->fetch(PDO::FETCH_ASSOC);?>
                    <div class="card-image overflow-visible">
                      <img src="<?php if($rcu['avatar']!=''&&file_exists('media/avatar/'.basename($rcu['avatar'])))echo'media/avatar/'.basename($rcu['avatar']);
                      elseif($rcu['gravatar']!='')echo$rcu['gravatar'];
                      else echo ADMINNOAVATAR;?>" alt="<?=$rcu['username'];?>" style="max-width:92px;">
                      <span class="status badger badge-<?= rank($rcu['rank']);?>"><?= ucwords(str_replace('-',' ',rank($rcu['rank'])));?></span>
                    </div>
                    <div class="card-header overflow-visible pt-2 line-clamp">
<?php $mcs=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."modules` WHERE `id` < :id");
$mcs->execute([':id'=>$rct['complete']]);
$smc=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."modules` WHERE `rid`=:rid");
$smc->execute([':rid'=>$rct['rid']]);
$rmc=$smc->fetch(PDO::FETCH_ASSOC);
                      echo$rcu['username'].':'.$rcu['name'].'<br><br>';
                      echo$rct['complete']=='done'?'Complete<br>Score '.$rct['score'].'%':($mcs->rowCount()>0?$rct['progress'].' of '.$rmc['cnt'].' Modules Complete':'Not Started');?>
                    </div>
                    <div class="card-footer">
                      <div id="controls_<?=$rct['id'];?>">
                        <div class="btn-toolbar float-right" role="toolbar">
                          <div class="btn-group" role="group">
                            <?php if($user['options'][0]==1){?>
                              <button class="btn purge trash" id="purge<?=$rct['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$rct['id'];?>','courseTrack');"><i class="i">trash</i></button>
                            <?php }?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                <?php }?>
              </section>
            </div>
          </div>
        </div>
      </div>
<?php $sw=$db->prepare("SELECT * FROM `".$prefix."widgets` WHERE `ref`='content' AND `active`='1' ORDER BY ord ASC");
$sw->execute();
if($sw->rowCount()>0){
  echo'<div id="widgets" class="card col-12 col-sm-3 m-0 p-0 bg-transparent border-0 order-1 order-sm-2">';
  while($rw=$sw->fetch(PDO::FETCH_ASSOC)){
    include'core/layout/widget-'.$rw['file'];
  }
  echo'</div>';
}?>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>