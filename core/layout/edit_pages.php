<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('pages','i-3x');?></div>
          <div>Edit Page: <?=$r['title'];?></div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?= svg2('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
          <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
          <li class="breadcrumb-item active breadcrumb-dropdown">
            <span id="titleupdate"><?=$r['title'];?></span><span class="breadcrumb-dropdown ml-2"><?= svg2('chevron-down');?></span>
            <ul class="breadcrumb-dropper">
<?php $sd=$db->prepare("SELECT `id`,`title` FROM `".$prefix."menu` WHERE `menu`!='none' AND `id`!=:id ORDER BY FIELD(`menu`,'head','footer','account','other'), `ord` ASC");
$sd->execute([':id'=>$r['id']]);
while($rd=$sd->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$rd['id'].'">'.$rd['title'].'</a></li>';?>
            </ul>
          </li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-3 py-3 overflow-visible">
        <div class="tabs" role="tablist">
          <input id="tab1-1" class="tab-control" name="tabs" type="radio">
          <label for="tab1-1">Content</label>
          <input id="tab1-2" class="tab-control" name="tabs" type="radio">
          <label for="tab1-2">Images</label>
          <?=$r['file']!='index'&&$r['file']!='comingsoon'&&$r['file']!='maintenance'?'<input id="tab1-3" class="tab-control" name="tabs" type="radio"><label for="tab1-3">Media</label>':'';?>
          <input id="tab1-4" class="tab-control" name="tabs" type="radio">
          <label for="tab1-4">SEO</label>
          <?=$r['file']!='comingsoon'&&$r['file']!='maintenance'?'<input id="tab1-5" class="tab-control" name="tabs" type="radio"><label for="tab1-5">Settings</label>':'';?>
<?php /* Content */ ?>
          <div class="tab1-1 border-top p-3" data-tabid="tab1-1" role="tabpanel">
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label id="pageTitle" for="title"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageTitle" aria-label="PermaLink to Page Title Field">&#128279;</a>':'';?>Title</label>
              <div class="form-row">
                <?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'menu',
                    ':c'=>'title'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=title" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                }?>
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><?= svg2('seo');?></button>
                <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="title" type="text" value="<?=$r['title'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?> onkeyup="genurl();$('#titleupdate').text($(this).val());">
                <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=title" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
                '<button class="save" id="savetitle" data-tooltip="tooltip" data-dbid="title" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
<?php if($r['contentType']!='index'){?>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?= URL.($r['contentType']=='page'?$r['contentType'].'/':'');?>"+data.replace(/ /g,"-");
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                }
              </script>
<?php }?>
              <label id="pageURLSlug" for="urlSlug"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageURLSlug" aria-label="PermaLink to Page URL Slug">&#128279;</a>':'';?>URL Slug</label>
              <div class="form-row">
                <div id="urlSlug" class="input-text col-12">
                  <a id="genurl" target="_blank" href=<?= '"'.URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/').'">'.URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/').'</a>';?>
                </div>
              </div>
            <?php }?>
            <div id="pageNotes" class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageNotes" aria-label="PermaLink to Page Content Editor">&#128279;</a>':'';?>
              <?php if($user['options'][1]==1){
                echo'<div class="wysiwyg-toolbar">'.
                  '<div class="btn-group d-flex justify-content-end">';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'menu',
                    ':c'=>'notes'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=notes" data-tooltip="tooltip" data-dbgid="notesda" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                }
                echo'<button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Content.md" data-type="content" data-tooltip="tooltip" aria-label="SEO Content Information">'.svg2('seo').'</button>'.
                    '<button data-tooltip="tooltip" aria-label="Show Element Blocks" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;">'.svg2('blocks').'</button>'.
                    '<input class="col-1" id="ipsumc" value="5">'.
                    '<button data-tooltip="tooltip" aria-label="Add Aussie Lorem Ipsum" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;">'.svg2('loremipsum').'</button>'.
                    '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=notes" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
                  '</div>'.
                '</div>';?>
                <div id="notesda" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                <form id="summernote" method="post" target="sp" action="core/update.php" enctype="multipart/form-data">
                  <input name="id" type="hidden" value="<?=$r['id'];?>">
                  <input name="t" type="hidden" value="menu">
                  <input name="c" type="hidden" value="notes">
                  <textarea class="summernote" id="notes" name="da" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="notes"><?= rawurldecode($r['notes']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-editable">
                        <?= rawurldecode($r['notes']);?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
            <div class="form-row">
              <small class="form-text">Edited: <?=$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></small>
            </div>
          </div>
<?php /* Images */ ?>
          <div class="tab1-2 border-top p-3" data-tabid="tab1-2" role="tabpanel">
            <legend class="mt-3">Cover</legend>
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label id="pageCoverURL" for="coverURL"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageCoverURL" aria-label="PermaLink to Page Cover Image URL Field">&#128279;</a>':'';?>Cover&nbsp;Image&nbsp;URL</label>
              <div class="form-row">
                <input class="image" id="coverURL" type="text" value="<?=$r['coverURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter Cover URL..."':' readonly';?> onchange="coverUpdate('<?=$r['id'];?>','menu','coverURL',$(this).val());">
                <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverURL`,``);">'.svg2('trash').'</button>':'';?>
              </div>
            <?php }?>
            <label id="pageCoverImage" for="cover"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageCoverImage" aria-label="PermaLink to Page Cover Image Field">&#128279;</a>':'';?>Image</label>
            <div class="form-row">
              <input id="cover" name="feature_image" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="cover" type="text" value="<?=$r['cover'];?>" readonly onchange="coverUpdate('<?=$r['id'];?>','menu','cover',$(this).val());">
              <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`cover`);">'.svg2('browse-media').'</button>':'';
              if($r['cover']!='')echo'<a data-fancybox="cover" data-type="image" href="'.$r['cover'].'"><img class="bg-white" id="coverimage" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL']!='')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL']!='')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              else echo'<img id="coverimage" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';
              echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,``);">'.svg2('trash').'</button>':'';?>
            </div>
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label id="pageImageALT" for="fileALT"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageImageALT" aria-label="PermaLink to Page Cover Image ALT Field">&#128279;</a>':'';?>Image ALT</label>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><?= svg2('seo');?></button>
                <input class="textinput" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Image ALT Test..."':' readonly';?>>
                <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-tooltip="tooltip" data-dbid="fileALT" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label id="pageVideoURL" for="coverVideo"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoURL" aria-label="PermaLink to Page Cover Video Field">&#128279;</a>':'';?>Video URL</label>
              <div class="form-row">
                <input id="coverVideo" name="feature_image" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" type="text" value="<?=$r['coverVideo'];?>">
                <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`coverVideo`);">'.svg2('browse-media').'</button>'.
                '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverVideo`,``);">'.svg2('trash').'</button>':'';?>
                <?=$user['options'][1]==1?'<button class="save" id="savecoverVideo" data-tooltip="tooltip" data-dbid="coverVideo" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <div class="row mt-3">
                <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoAutoplay" aria-label="PermaLink to Page Video AutoPlay Checkbox">&#128279;</a>':'';?>
                <input id="pageVideoAutoplay" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="0" type="checkbox"<?=$r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="pageVideoAutoplay" id="menuoptions0<?=$r['id'];?>">AutoPlay Cover Video</label>
              </div>
              <div class="row">
                <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoLoop" aria-label="PermaLink to Page Cover Image">&#128279;</a>':'';?>
                <input id="pageVideoLoop" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="1" type="checkbox"<?=$r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="pageVideoLoop" id="menuoptions1<?=$r['id'];?>">Loop Cover Video</label>
              </div>
              <div class="row">
                <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoControls" aria-label="PermaLink to Page Video Show Controls Checkbox">&#128279;</a>':'';?>
                <input id="pageVideoControls" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="2" type="checkbox"<?=$r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="pageVideoControls" id="menuoptions2<?=$r['id'];?>">Show Controls</label>
              </div>
              <legend class="mt-3">Image Attribution</legend>
              <label id="pageAttributionImageTitle" for="attributionImageTitle"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAttributionImageTitle" aria-label="PermaLink to Page Image Attribution Title Field">&#128279;</a>':'';?>Title</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageTitle" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" type="text" value="<?=$r['attributionImageTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                <?=$user['options'][1]==1?'<button class="save" id="saveattributionImageTitle" data-tooltip="tooltip" data-dbid="attributionImageTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label id="pageAttributionImageName" for="attributionImageName"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAttributionImageName" aria-label="PermaLink to Page Image Attribution Name Field">&#128279;</a>':'';?>Name</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageName" list="attributionImageTitle_option" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" type="text" value="<?=$r['attributionImageName'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                <?php if($user['options'][1]==1){
                  $s=$db->query("SELECT DISTINCT `attributionImageTitle` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."login` ORDER BY `name` ASC");
                  if($s->rowCount()>0){?>
                    <datalist id="attributionImageTitle_option">
                      <?php while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                    </datalist>
                  <?php }
                  echo'<button class="save" id="saveattributionImageName" data-tooltip="tooltip" data-dbid="attributionImageName" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';
                }?>
              </div>
              <label id="pageAttributionImageURL" for="attributionImageURL"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAttributionImageURL" aria-label="PermaLink to Page Image Attribution URL Field">&#128279;</a>':'';?>URL</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" type="text" value="<?=$r['attributionImageURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                <?php if($user['options'][1]==1){
                  $s=$db->query("SELECT DISTINCT `attributionImageURL` AS url FROM `".$prefix."content` ORDER BY `url` ASC");
                  if($s->rowCount()>0){?>
                    <datalist id="attributionImageURL_option">
                      <?php while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                    </datalist>
                  <?php }
                  echo'<button class="save" id="saveattributionImageURL" data-tooltip="tooltip" data-dbid="attributionImageURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';
                }?>
              </div>
            <?php }?>
          </div>
<?php /* Media */
          if($r['file']!='index'||$r['file']!='comingsoon'&&$r['file']!='maintenance'){?>
            <div class="tab1-3 border-top p-3" data-tabid="tab1-3" role="tabpanel">
              <?php if($user['options'][1]==1){?>
                <form class="form-row" target="sp" method="post" action="core/add_media.php" enctype="multipart/form-data">
                  <input name="id" type="hidden" value="<?=$r['id'];?>">
                  <input name="rid" type="hidden" value="0">
                  <input name="t" type="hidden" value="pages">
                  <input id="mediafile" name="fu" type="text" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                  <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','media','mediafile');return false;"><?= svg2('browse-media');?></button>
                  <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?= svg2('add');?></button>
                </form>
              <?php }?>
              <div class="row mt-3" id="mi">
                <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `rid`=0 AND `pid`=:id ORDER BY `ord` ASC");
                $sm->execute([':id'=>$r['id']]);
                if($sm->rowCount()>0){
                  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                    if(file_exists('media/sm/'.basename($rm['file'])))$thumb='media/sm/'.basename($rm['file']);
                    else $thumb=ADMINNOIMAGE;?>
                    <div class="card stats col-6 col-md-3 m-1" id="mi_<?=$rm['id'];?>">
                      <?php if($user['options'][1]==1){?>
                        <div class="btn-group float-right">
                          <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item"><?= svg2('drag');?></div>
                          <div class="btn" data-tooltip="tooltip" aria-label="Viewed <?=$rm['views'];?> times"><small><?=$rm['views'];?></small></div>
                          <a class="btn" href="<?= URL.$settings['system']['admin'].'/media/edit/'.$rm['id'];?>" data-tooltip="tooltip" role="button" aria-label="Edit"><?= svg2('edit');?></a>
                          <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?=$rm['id'];?>`,`media`);"><?= svg2('trash');?></button>
                        </div>
                      <?php }?>
                      <a data-fancybox data-type="image" data-caption="<?=($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?=$rm['file'];?>">
                        <img src="<?=$thumb;?>" alt="Media <?=$rm['id'];?>">
                      </a>
                    </div>
                  <?php }?>
                  <script>
                    $('#mi').sortable({
                      items:".card.stats",
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
                <?php }?>
              </div>
            </div>
          <?php }
/* SEO */ ?>
          <div class="tab1-4 border-top p-3" data-tabid="tab1-4" role="tabpanel">
            <label id="pageViews" for="views"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageViews" aria-label="PermaLink to Page Views Field">&#128279;</a>':'';?>Views</label>
            <div class="form-row">
              <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`menu`,`views`,`0`);">'.svg2('eraser').'</button>'.
              '<button class="save" id="saveviews" data-tooltip="tooltip" data-dbid="views" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label id="pageMetaRobots" for="metaRobots"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMetaRobots" aria-label="PermaLink to Page Meta Robots Field">&#128279;</a>':'';?>Meta&nbsp;Robots</label>
              <small class="form-text text-right">Options for Meta Robots: <span data-tooltip="left" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Robots.md" data-tooltip="tooltip" aria-label="SEO Meta Robots Information"><?= svg2('seo');?></button>
              <input class="textinput" id="metaRobots" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" type="text" value="<?=$r['metaRobots'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savemetaRobots" data-tooltip="tooltip" data-dbid="metaRobots" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="card google-result mt-3 p-3 overflow-visible" id="pageSearchResult">
              <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSearchResult" aria-label="PermaLink to Page Search Result">&#128279;</a>':'';?>
              <div id="google-title" data-tooltip="tooltip" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                <?=$r['seoTitle'].' | '.$config['business'];?>
              </div>
              <div id="google-link">
                <?= URL;?>
              </div>
              <div id="google-description" data-tooltip="tooltip" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                <?=$r['seoDescription'];?>
              </div>
            </div>
            <div class="form-row mt-3">
              <label id="pageMetaTitle" for="seoTitle"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMetaTitle" aria-label="PermaLink to Page Meta Title Field">&#128279;</a>':'';?>Meta&nbsp;Title</label>
              <small class="form-text text-right">The recommended character count for Title's is 70.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><?= svg2('seo');?></button>
              <?php $cntc=70-strlen($r['seoTitle']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else$cnt=number_format($cntc);?>
              <div class="input-text text-success<?=$cnt<0?' text-danger':'';?>" id="seoTitlecnt"><?=$cnt;?></div>
              <?php if($user['options'][1]==1){
                echo'<button data-tooltip="tooltip" onclick="removeStopWords(`seoTitle`,$(`#seoTitle`).val());" aria-label="Remove Stop Words">'.svg2('magic').'</button>';
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'menu',
                  ':c'=>'seoTitle'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoTitle" data-tooltip="tooltip" data-aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <input class="textinput" id="seoTitle" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" type="text" value="<?=$r['seoTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Title..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoTitle" data-tooltip="tooltip" data-aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoTitle" data-tooltip="tooltip" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
<?php /*
            <div class="form-row mt-3">
              <label for="seoCaption">Meta&nbsp;Caption</label>
              <small class="form-text text-right">The recommended character count for Captions is 100.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metacaption" data-tooltip="tooltip" aria-label="SEO Meta Caption Information"><?= svg2('seo');?></button>
              <?php $cntc=100-strlen($r['seoCaption']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text text-success<?=$cnt<0?' text-danger':'';?>" id="seoCaptioncnt"><?=$cnt;?></div>
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoCaption']);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoCaption" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <input class="textinput" id="seoCaption" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" type="text" value="<?=$r['seoCaption'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Caption..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoCaption" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoCaption" data-tooltip="tooltip" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
*/ ?>
            <div class="form-row mt-3">
              <label id="pageMetaDescription" for="seoDescription"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMetaDescription" aria-label="PermaLink to Page Meta Description Field">&#128279;</a>':'';?>Meta&nbsp;Description</label>
              <small class="form-text text-right">The recommended character count for Descriptions is 160.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Description.md" data-tooltip="tooltip" aria-label="SEO Meta Description Information"><?= svg2('seo');?></button>
              <?php $cntc=160-strlen($r['seoDescription']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else$cnt=number_format($cntc);?>
              <div class="input-text text-success<?=$cnt<0?' text-danger':'';?>" id="seoDescriptioncnt"><?=$cnt;?></div>
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'menu',
                  ':c'=>'seoDescription'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoDescription" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <input class="textinput" id="seoDescription" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" type="text" value="<?=$r['seoDescription'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Description..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout.suggestions-add.php?id='.$r['id'].'&t=menu&c=seoDescription" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoDescription" data-tooltip="tooltip" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
<?php /*
            <label for="seoKeywords">Meta&nbsp;Keywords</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Keywords.md" data-tooltip="tooltip" aria-label="SEO Keywords Information"><?= svg2('seo');?></button>
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'menu',
                  ':c'=>'seoKewords'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoKeywords" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <input class="textinput" id="seoKeywords" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" type="text" value="<?=$r['seoKeywords'];?>"<?=$user['options'][1]==1?' placeholder="Enter Meta Keywords..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoKeywords" data-tooltip="tooltip" data-aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoKeywords" data-tooltip="tooltip" data-dbid="seoKeywords" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
*/ ?>
          </div>
<?php /* Settings */
          if($r['file']!='comingsoon'&&$r['file']!='maintenance'){?>
            <div class="tab1-5 border-top p-3" data-tabid="tab1-5" role="tabpanel">
              <?php if($r['file']!='index'){?>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageActive" aria-label="PermaLink to Page Active Checkbox">&#128279;</a>':'';?>
                  <input id="pageActive" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"<?=($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="pageActive" id="menuactive0<?=$r['id'];?>">Active</label>
                </div>
              <?php }
              if($r['file']=='index'){?>
              <div class="row mt-3">
                <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings#enableSlider" aria-label="PermaLink to Slider Checkbox">&#128279;</a>':'';?>
                <input id="enableSlider" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="1" type="checkbox"<?=$config['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="enableSlider" id="configoptions11">Enable Content Slider</label>
              </div>
              <?php }
                if($r['file']!='index'){?>
                <label id="pageAccess" for="rank"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAccess" aria-label="PermaLink to Page Access Selector">&#128279;</a>':'';?>Access</label>
                <div class="form-row">
                  <select id="rank" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="rank" onchange="update('<?=$r['id'];?>','menu','rank',$(this).val(),'select');"<?=$user['options'][5]==1?'':' disabled';?>>
                    <option value="0"<?=$r['rank']==0?' selected':'';?>>Available to Everyone</option>
                    <option value="100"<?=$r['rank']==100?' selected':'';?>>Subscriber and above</option>
                    <option value="200"<?=$r['rank']==200?' selected':'';?>>Member and above</option>
                    <option value="210"<?=$r['rank']==210?' selected':'';?>>Member Silver and above</option>
                    <option value="220"<?=$r['rank']==220?' selected':'';?>>Member Bronze and above</option>
                    <option value="230"<?=$r['rank']==230?' selected':'';?>>Member Gold and above</option>
                    <option value="240"<?=$r['rank']==240?' selected':'';?>>Member Platinum and above</option>
                    <option value="300"<?=$r['rank']==300?' selected':'';?>>Client and above</option>
                    <option value="310"<?=$r['rank']==310?' selected':'';?>>Wholesaler Silver and above</option>
                    <option value="320"<?=$r['rank']==320?' selected':'';?>>Wholesaler Bronze and above</option>
                    <option value="330"<?=$r['rank']==330?' selected':'';?>>Wholesaler Gold and above</option>
                    <option value="340"<?=$r['rank']==340?' selected':'';?>>Wholesaler Platinum and above</option>
                    <option value="400"<?=$r['rank']==400?' selected':'';?>>Contributor and above</option>
                    <option value="500"<?=$r['rank']==500?' selected':'';?>>Author and above</option>
                    <option value="600"<?=$r['rank']==600?' selected':'';?>>Editor and above</option>
                    <option value="700"<?=$r['rank']==700?' selected':'';?>>Moderator and above</option>
                    <option value="800"<?=$r['rank']==800?' selected':'';?>>Manager and above</option>
                    <option value="900"<?=$r['rank']==900?' selected':'';?>>Administrator and above</option>
                  </select>
                </div>
                <?php if($user['rank']>999){?>
                  <div class="form-row mt-3">
                    <label id="pageContentType" for="contentType"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageContentType" aria-label="PermaLink to Page Content Type Field">&#128279;</a>':'';?>contentType</label>
                    <small class="form-text text-right">
                      <?php $sct=$db->prepare("SELECT DISTINCT(`contentType`) FROM `".$prefix."content` WHERE `contentType`!='' ORDER BY contentType ASC");
                      $sct->execute();
                      while($rct=$sct->fetch(PDO::FETCH_ASSOC))echo$rct['contentType'].' ';?>
                    </small>
                  </div>
                  <div class="form-row">
                    <input class="textinput" id="contentType" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="contentType" type="text" value="<?=$r['contentType'];?>" placeholder="">
                    <button class="save" id="savecontentType" data-dbid="contentType" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
                  </div>
                <?php }?>
                <div class="form-row mt-3">
                  <label id="pageURLType" for="url"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageURLType" aria-label="PermaLink to Page URL Type Field">&#128279;</a>':'';?>URL&nbsp;Type</label>
                  <small class="form-text text-right">Leave Blank for auto-generated URL's. Enter a URL to link to another service. Or use <code class="click" style="cursor:pointer;" onclick="$('#url').val('#<?=$r['contentType'];?>');update('<?=$r['id'];?>','menu','url',$('#url').val());"><small>#<?=$r['contentType'];?></small></code> to link to Anchor on same page.</small>
                </div>
                <div class="form-row">
                  <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="url" type="text" value="<?=$r['url'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="saveurl" data-tooltip="tooltip" data-dbid="url" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
                <?php if($r['menu']=='head'||$r['menu']=='other'||$r['menu']=='footer'||$user['rank']>999){?>
                  <div class="row">
                    <div class="col-12 col-md-6 pr-md-1">
                      <label id="pageMenu" for="menu"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMenu" aria-label="PermaLink to Page Menu Selector">&#128279;</a>':'';?>Menu</label>
                      <div class="form-row">
                        <select id="menu"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','menu','menu',$(this).val(),'select');">
                          <option value="head"<?=$r['menu']=='head'?' selected':'';?>>Head</option>
                          <option value="other"<?=$r['menu']=='other'?' selected':'';?>>Other</option>
                          <option value="footer"<?=$r['menu']=='footer'?' selected':'';?>>Footer</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 pl-md-1">
                      <label id="pageSubMenu" for="mid"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSubMenu" aria-label="PermaLink to Page SubMenu Selector">&#128279;</a>':'';?>SubMenu</label>
                      <div class="form-row">
                        <select id="mid"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','menu','mid',$(this).val(),'select');">
                          <option value="0"<?=$r['mid']==0?' selected':'';?>>None</option>
                          <?php $sm=$db->prepare("SELECT `id`,`title` from `".$prefix."menu` WHERE `mid`=0 AND `mid`!=:mid AND `active`=1 ORDER BY `ord` ASC, `title` ASC");
                          $sm->execute([':mid'=>$r['id']]);
                          if($sm->rowCount()>0){
                            while($rm=$sm->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                <?php }?>
              <?php }?>
            </div>
          <?php }?>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
