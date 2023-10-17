<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card col-12 col-sm mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/notification';?>">Notifications</a></li>
                <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                <li class="breadcrumb-item active breadcrumb-dropdown"><?=$r['title'];?></li>
              </ol>
            </div>
            <div class="col-12 col-sm-2 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][1]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio">
          <label for="tab1-1">Content</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Images</label>
          <?=$r['file']!='comingsoon'&&$r['file']!='maintenance'?'<input id="tab1-3" class="tab-control" name="tabs" type="radio"><label for="tab1-3">Settings</label>':'';?>
<?php /* Content */ ?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <label for="title">Title</label>
            <div class="form-row">
              <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="title" type="text" value="<?=$r['title'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?> onkeyup="genurl();$('#titleupdate').text($(this).val());">
              <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="animation">Animation</label>
            <div class="form-row">
              <select id="animation" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="heading"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`menu`,`heading`,$(this).val(),`select`);"':' disabled';?>>
                <option value=""<?=$r['heading']==''?' selected':'';?>>None</option>
                <option value="bounce-in-bottom"<?=$r['heading']=='bounce-in-bottom'?' selected':'';?>>Bounce In Bottom</option>
                <option value="slide-in-bottom"<?=$r['heading']=='slide-in-bottom'?' selected':'';?>>Slide In Bottom</option>
                <option value="fade-in-bottom"<?=$r['heading']=='fade-in-bottom'?' selected':''?>>Fade In Bottom</option>
              </select>
            </div>
            <div id="pageNotes" class="row mt-3">
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
                      echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=notes" data-dbgid="notesda" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                    }
                    echo'<button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Content.md" data-type="content" data-tooltip="tooltip" aria-label="SEO Content Information"><i class="i">seo</i></button>'.
                    '<button data-tooltip="tooltip" aria-label="Show Element Blocks" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;"><i class="i">blocks</i></button>'.
                    '<input class="col-1" id="ipsumc" value="5">'.
                    '<button data-tooltip="tooltip" aria-label="Add Aussie Lorem Ipsum" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;"><i class="i">loremipsum</i></button>'.
                    '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=notes" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
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
                      <div class="note-viewport-area">
                        <div class="note-editable">
                          <?= rawurldecode($r['notes']);?>
                        </div>
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
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <legend>Cover</legend>
            <label for="cover">Image</label>
            <div class="form-row">
              <?php $w='';
              if(stristr($r['cover'],'/thumbs/'))$w='thumbs';
              if(stristr($r['cover'],'/lg/'))$w='lg';
              if(stristr($r['cover'],'/md/'))$w='md';
              if(stristr($r['cover'],'/sm/'))$w='sm';
              if($r['cover']!='')echo'<a data-fancybox="cover" data-type="image" href="'.$r['cover'].'"><img class="bg-white" id="coverimage" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL']!='')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL']!='')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              else echo'<img id="coverimage" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';?>
              <input id="cover" name="feature_image" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="cover" type="text" value="<?=$r['cover'];?>"<?=($user['options'][1]==1?' onchange="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,$(this).val());" placeholder="Select an image from the button options..."':' disabled');?>>
              <?php echo($user['options'][1]==1?
                '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`cover`);"><i class="i">browse-media</i></button>'.
                ($config['mediaOptions'][0]==1?'<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id='.$r['id'].'&t=menu&c=cover" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>':'').
                ($config['mediaOptions'][2]==1?'<button class="openimageeditor" data-tooltip="tooltip" aria-label="Edit Image" data-imageeditor="editcover" data-image="'.$r['cover'].'" data-name="'.$r['title'].'" data-alt="'.$r['fileALT'].'" data-w="'.$w.'" data-id="'.$r['id'].'" data-t="menu" data-c="cover"><i class="i">magic</i></button>':'').
                '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,``);"><i class="i">trash</i></button>'.
                '<button class="save" id="savecover" data-dbid="cover" data-style="zoom-n" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
              :
                '');?>
            </div>
            <div id="editcover"></div>
            <label for="fileALT">Image ALT</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><i class="i">seo</i></button>
              <input class="textinput" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Image ALT Test..."':' disabled';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-dbid="fileALT" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
          </div>
<?php /* Settings */
          if($r['file']!='comingsoon'&&$r['file']!='maintenance'){?>
            <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
              <?php if($r['file']!='index'){?>
                <div class="form-row">
                  <input id="notificationActive" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"<?=($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="notificationActive">Active</label>
                </div>
              <?php }?>
            </div>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
