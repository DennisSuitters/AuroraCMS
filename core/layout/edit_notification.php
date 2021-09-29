<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.1
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
          <div class="content-title-icon"><?= svg2('notification','i-3x');?></div>
          <div>Edit Notification: <?=$r['title'];?></div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?= svg2('back');?></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/notification';?>">Notifications</a></li>
          <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
          <li class="breadcrumb-item active breadcrumb-dropdown"><?=$r['title'];?></li>
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
          <?=$r['file']!='comingsoon'&&$r['file']!='maintenance'?'<input id="tab1-5" class="tab-control" name="tabs" type="radio"><label for="tab1-5">Settings</label>':'';?>
<?php /* Content */ ?>
          <div class="tab1-1 border-top p-3" data-tabid="tab1-1" role="tabpanel">
            <label id="pageTitle" for="title"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageTitle" aria-label="PermaLink to Page Title Field">&#128279;</a>':'';?>Title</label>
            <div class="form-row">
              <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="title" type="text" value="<?=$r['title'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?> onkeyup="genurl();$('#titleupdate').text($(this).val());">
              <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-tooltip="tooltip" data-dbid="title" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label id="notificationAnimation" for="animation"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/notification/edit/'.$r['id'].'#notificationAnimation" aria-label="PermaLink to Page Access Selector">&#128279;</a>':'';?>Animation</label>
            <div class="form-row">
              <select id="animation" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="heading" onchange="update('<?=$r['id'];?>','menu','heading',$(this).val(),'select');"<?=$user['options'][5]==1?'':' disabled';?>>
                <option value=""<?=$r['heading']==''?' selected':'';?>>None</option>
                <option value="bounce-in-bottom"<?=$r['heading']=='bounce-in-bottom'?' selected':'';?>>Bounce In Bottom</option>
                <option value="slide-in-bottom"<?=$r['heading']=='slide-in-bottom'?' selected':'';?>>Slide In Bottom</option>
                <option value="fade-in-bottom"<?=$r['heading']=='fade-in-bottom'?' selected':''?>>Fade In Bottom</option>
              </select>
            </div>
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
            <label id="pageImageALT" for="fileALT"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageImageALT" aria-label="PermaLink to Page Cover Image ALT Field">&#128279;</a>':'';?>Image ALT</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><?= svg2('seo');?></button>
              <input class="textinput" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Image ALT Test..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-tooltip="tooltip" data-dbid="fileALT" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
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
              <?php }?>
            </div>
          <?php }?>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
