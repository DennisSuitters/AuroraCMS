<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$seo=[
  'contentHeading' => '',
  'contentNotesHeading' => '',
  'contentNotes' => '',
  'contentImagesNotes' => '',
  'contentcnt' => 0,
  'seoTitle' => '',
  'seoDescription' => '',
  'seocnt' => 0,
  'imagesALT' => '',
  'imagescnt' => 0,
  'imagesCover' => ''
];
$seoerrors=0;
if($r['seoTitle']==''){
  $seo['seoTitle']='<div>The <strong>Meta Title</strong> is empty, while AuroraCMS tries to autofill this entry when building the page, it is better to fill in this information yourself!</div>';
  $seo['seocnt']++;
}elseif(strlen($r['seoTitle'])<50){
  $seo['seoTitle']='<div>The <strong>Meta Title</strong> is less than <strong>50</strong> characters!</div>';
  $seo['seocnt']++;
}elseif(strlen($r['seoTitle'])>70){
  $seo['seoTitle']='<div>The <strong>Meta Title</strong> is longer than <strong>70</strong> characters!</div>';
  $seo['seocnt']++;
}
if($r['seoDescription']==''){
  $seo['seoDescription']='<div>The <strong>Meta Description</strong> is empty, while AuroraCMS tries to autofill this entry when build the page, it is better to fill in this information yourself!</div>';
  $seo['seocnt']++;
}elseif(strlen($r['seoDescription'])<1){
  $seo['seoDescription']='<div>The <strong>Meta Description</strong> is empty!</div>';
  $seo['seocnt']++;
}elseif(strlen($r['seoDescription'])>160){
  $seo['seoDescription']='<div>The <strong>Meta Description</strong> is longer than <strong>160</strong> characters!</div>';
  $seo['seocnt']++;
}
if($r['cover']!=''){
  if(strlen($r['fileALT'])<1){
    $seo['imagesALT']='<div>The <strong>Image ALT</strong> text is empty!</div>';
    $seo['imagescnt']++;
  }
  list($width,$height,$type,$attr)=@getimagesize($r['cover']);
  if($width==null||$height==null){
    $seo['imagescnt']++;
    $seo['imagesCover']='<div>The <strong>Cover Image</strong> is broken!</div>';
  }
}
if(strip_tags($r['notes'])==''){
  $seo['contentNotes']='<div>The <strong>Description</strong> is empty. At least <strong>100</strong> characters is recommended!</div>';
  $seo['contentcnt']++;
}elseif(strlen(strip_tags($r['notes']))<100){
  $seo['contentNotes']='<div>The <strong>Description</strong> test is less than <strong>100</strong> characters!</div>';
  $seo['contentcnt']++;
}
preg_match('~<h1>([^{]*)</h1>~i',$r['notes'],$h1);
if(isset($h1[1])){
  $seo['contentNotesHeading']='<div>Do not use <strong>H1</strong> headings in the <strong>Description</strong> Text, as AuroraCMS uses the <strong>Heading</strong> Field to place H1 headings on page, and uses them for other areas for SEO!</div>';
  $seo['contentcnt']++;
}
if($r['heading']==''){
  $seo['contentHeading']='<div>The <strong>Heading</strong> Field is empty, this is what is used for your H1 heading!</div>';
  $seo['contentcnt']++;
}
preg_match_all('~src="\K[^"]+~',$r['notes'],$imgs);
if($imgs!=''){
  $imagescnt=0;
  foreach($imgs[0] as $img){
    list($width,$height,$type,$attr)=@getimagesize($img);
    if($width==null||$height==null){
      $seo['contentcnt']++;
      $imagescnt++;
    }
    if($imagescnt>0){
      $seo['contentImagesNotes']='<div>There are <strong>Broken Images</strong> within the Description Text!</div>';
    }
  }
}?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="row">
      <div class="card col-12 mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
                <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                <li class="breadcrumb-item active breadcrumb-dropdown">
                  <span id="titleupdate"><?=$r['title'];?></span><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                  <ul class="breadcrumb-dropper">
                    <?php $sd=$db->prepare("SELECT `id`,`title` FROM `".$prefix."menu` WHERE `menu`!='none' AND `file`!='notification' AND `id`!=:id ORDER BY FIELD(`menu`,'head','footer','account','other'), `ord` ASC");
                    $sd->execute([':id'=>$r['id']]);
                    while($rd=$sd->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$rd['id'].'">'.$rd['title'].'</a></li>';?>
                  </ul>
                </li>
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
          <?='<input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>'.
          '<label for="tab1-1"'.($seo['contentcnt']>0?' class="badge" data-badge="'.$seo['contentcnt'].'"':'').'>'.($seo['contentcnt']>0?'<span data-tooltip="tooltip" title aria-label="There'.($seo['contentcnt']>1?' are '.$seo['contentcnt'].' SEO related issues!':' is 1 SEO related issue!').'">Content</span>':'Content').'</label>'.
          '<input class="tab-control" id="tab1-2" name="tabs" type="radio"><label for="tab1-2"'.($seo['imagescnt']>0?' class="badge" data-badge="'.$seo['imagescnt'].'"':'').'>'.($seo['imagescnt']>0?'<span data-tooltip="tooltip" aria-label="There'.($seo['imagescnt']>1?' are '.$seo['imagescnt'].' SEO related issues!':' is 1 SEO related issue!').'">Media</span>':'Media').'</label>'.
          ($r['file']=='pricing'?'<input id="tab1-3" class="tab-control" name="tabs" type="radio"><label for="tab1-3">Price Items</label>':'').
          ($r['file']!='activate'&&$r['file']!='offline'?'<input class="tab-control" id="tab1-4" name="tabs" type="radio"><label for="tab1-4"'.($seo['seocnt']>0?' class="badge" data-badge="'.$seo['seocnt'].'"':'').'>'.($seo['seocnt']>0?'<span data-tooltip="tooltip" aria-label="There'.($seo['seocnt']>1?' are '.$seo['seocnt'].' SEO related issues!':' is 1 SEO related issue!').'">SEO</span>':'SEO').'</label>':'').
          ($r['file']!='activate'&&$r['file']!='comingsoon'&&$r['file']!='maintenance'?'<input id="tab1-5" class="tab-control" name="tabs" type="radio"><label for="tab1-5">Settings</label>':'');?>
<?php /* Content */ ?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'&&$r['contentType']!='offline'){?>
              <label for="title" class="mt-0">Menu Title</label>
              <div class="form-row">
                <?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'menu',
                    ':c'=>'title'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=title" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }?>
                <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="title" type="text" value="<?=$r['title'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?> onkeyup="genurl();$('#titleupdate').text($(this).val());">
                <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
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
              <label for="urlSlug">URL Slug</label>
              <div class="form-row">
                <div class="input-text col-12" id="urlSlug">
                  <a id="genurl" target="_blank" href=<?= '"'.URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/').'">'.URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/').'</a>';?>
                </div>
              </div>
            <?php }?>
            <label for="heading">Page Heading</label>
            <div class="form-text">This text is normally used in the &lt;h1&gt; heading tag. If left empty, the SEO Meta Title will be used, otherwise an auto-generated text will be used.</div>
            <?=$seo['contentHeading']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['contentHeading'],'<strong>').'</div>':'';?>
            <div class="form-row<?=$seo['contentHeading']!=''?' border-danger border-2 border-top-0':'';?>">
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'menu',
                  ':c'=>'title'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=title" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
              }?>
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
              <div class="input-text" data-el="heading" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter a Heading..."><?=$r['heading'];?></div>
              <input class="textinput d-none" id="heading" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="heading" type="text" value="<?=$r['heading'];?>">
              <?=($user['options'][1]==1?
                '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=title" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                '<button class="analyzeTitle" data-test="heading" data-tooltip="tooltip" aria-label="Analyze Page Heading Text"><i class="i">seo</i></button>'.
                '<button class="save" id="saveheading" data-dbid="heading" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
              :
                '');?>
            </div>
            <?php if($r['contentType']=='comingsoon'){?>
              <div class="col-12 col-sm-4">
                <label for="tie">Countdown Clock <span class="labeldate" id="labeldatetie"><?= $r['tie']>0?date($config['dateFormat'],$r['tie']):'';?></span></label>
                <div class="form-row">
                  <input id="tie" type="datetime-local" value="<?=$r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`menu`,`tie`,getTimestamp(`tie`));"':' readonly';?>>
                  <button class="trash" data-tooltip="tooltip" aria-label="Clear Date" onclick="$(`#tie`).val(`0`);updateButtons(`<?=$r['id'];?>`,`menu`,`tie`,`0`);"><i class="i">eraser</i></button>
                </div>
              </div>
            <?php }?>
            <div class="row mt-3<?=$seo['contentNotes']!=''||$seo['contentNotesHeading']!=''||$seo['contentImagesNotes']!=''?' border-danger border-2':'';?>" id="pageNotes">
              <?php if($user['options'][1]==1){
                echo'<div class="wysiwyg-toolbar"><div class="btn-group d-flex justify-content-end">';
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
                '</div></div>'.
                ($seo['contentNotes']!=''||$seo['contentNotesHeading']!=''||$seo['contentImagesNotes']!=''?'<div class="alert alert-warning m-0">'.$seo['contentNotesHeading'].$seo['contentNotes'].$seo['contentImagesNotes'].'</div>':'');?>
                <div id="notesda" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                <form id="summernote" data-dbid="summernote" method="post" target="sp" action="core/update.php" enctype="multipart/form-data">
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
            <div class="form-text">Edited: <?=$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
          </div>
<?php /* Media */?>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <div class="tabs2" role="tablist">
              <input class="tab-control" id="tab2-1" name="tabs2" type="radio" checked>
              <label for="tab2-1">Images</label>
              <?=($r['file']=='index'?'<input class="tab-control" id="tab2-2" name="tabs2" type="radio"><label for="tab2-2">Featured Content</label>':'');?>
              <input class="tab-control" id="tab2-3" name="tabs2" type="radio">
              <label for="tab2-3">Video</label>
              <input class="tab-control" id="tab2-4" name="tabs2" type="radio">
              <label for="tab2-4">On Page Media</label>
              <div class="tab2-1 border p-3" data-tabid="tab2-1" role="tabpanel">
                <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
                  <label for="coverURL" class="mt-0">Cover Image URL</label>
                  <div class="form-row mb-3">
                    <input class="image" id="coverURL" type="text" value="<?=$r['coverURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter Cover URL..."':' readonly';?> onchange="coverUpdate('<?=$r['id'];?>','menu','coverURL',$(this).val());">
                    <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverURL`,``);"><i class="i">trash</i></button>':'';?>
                  </div>
                <?php }?>
                <label for="cover" class="mt-0">Image</label>
                <?=($seo['imagesCover']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.$seo['imagesCover'].'</div>':'');?>
                <div class="form-row<?=($seo['imagesCover']!=''?' border-danger border-2 border-top-0':'');?>">
                  <?php $w='';
                  if(stristr($r['cover'],'/thumbs/'))$w='thumbs';
                  if(stristr($r['cover'],'/lg/'))$w='lg';
                  if(stristr($r['cover'],'/md/'))$w='md';
                  if(stristr($r['cover'],'/sm/'))$w='sm';
                  if($r['cover']!='')
                    echo'<a data-fancybox="cover" data-type="image" href="'.$r['cover'].'"><img class="bg-white" id="coverimage" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
                  elseif($r['coverURL']!='')
                    echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                  elseif($r['coverURL']!='')
                    echo'<a data-fancybox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                  else
                    echo'<img id="coverimage" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';?>
                  <input id="cover" name="feature_image" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="cover" type="text" value="<?=$r['cover'];?>"<?=($user['options'][1]==1?' onchange="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,$(this).val());" placeholder="Select an image from the button options..."':' disabled');?>>
                  <?=($user['options'][1]==1?
                    '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`cover`);"><i class="i">browse-media</i></button>'.
                    ($config['mediaOptions'][0]==1?
                      '<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id='.$r['id'].'&t=menu&c=cover" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>'
                    :
                      '').
                    ($config['mediaOptions'][2]==1?
                      '<button class="openimageeditor" data-tooltip="tooltip" aria-label="Edit Image" data-imageeditor="editcover" data-image="'.$r['cover'].'" data-name="'.$r['title'].'" data-alt="'.$r['fileALT'].'" data-w="'.$w.'" data-id="'.$r['id'].'" data-t="menu" data-c="cover"><i class="i">magic</i></button>'
                    :
                      '').
                    '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,``);"><i class="i">trash</i></button>'.
                    '<button class="save" id="savecover" data-dbid="cover" data-style="zoom-n" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                  :
                    '');?>
                </div>
                <div id="editcover"></div>
                <label for="fileALT">Image ALT</label>
                <?=$seo['imagesALT']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['imagesALT'],'<strong>').'</div>':'';?>
                <div class="form-row<?=$r['cover']!=''&&$seo['imagesALT']!=''?' border-danger border-2 border-top-0':'';?>">
                  <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><i class="i">seo</i></button>
                  <div class="input-text" data-el="fileALT" contenteditable="<?=$user['options'][1]==1?'true':'false';?>"><?=$r['fileALT'];?></div>
                  <input class="textinput d-none" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>">
                  <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-dbid="fileALT" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <legend class="mt-3">Image Attribution</legend>
                <label for="attributionImageTitle">Title</label>
                <div class="form-row">
                  <input class="textinput" id="attributionImageTitle" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" type="text" value="<?=$r['attributionImageTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="saveattributionImageTitle" data-dbid="attributionImageTitle" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <label for="attributionImageName">Name</label>
                <div class="form-row">
                  <input class="textinput" id="attributionImageName" list="attributionImageTitle_option" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" type="text" value="<?=$r['attributionImageName'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                  <?php if($user['options'][1]==1){
                    $s=$db->query("SELECT DISTINCT `attributionImageTitle` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."login` ORDER BY `name` ASC");
                    if($s->rowCount()>0){?>
                      <datalist id="attributionImageTitle_option">
                        <?php while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                      </datalist>
                    <?php }
                    echo'<button class="save" id="saveattributionImageName" data-dbid="attributionImageName" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                  }?>
                </div>
                <label for="attributionImageURL">URL</label>
                <div class="form-row">
                  <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" type="text" value="<?=$r['attributionImageURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                  <?php if($user['options'][1]==1){
                    $s=$db->query("SELECT DISTINCT `attributionImageURL` AS url FROM `".$prefix."content` ORDER BY `url` ASC");
                    if($s->rowCount()>0){?>
                      <datalist id="attributionImageURL_option">
                        <?php while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                      </datalist>
                    <?php }
                    echo'<button class="save" id="saveattributionImageURL" data-dbid="attributionImageURL" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                  }?>
                </div>
              </div>
              <?php if($r['file']=='index'){?>
                <div class="tab2-2 border p-3" data-tabid="tab2-2" role="tabpanel">
                  <div class="form-row">
                    <input id="enableSlider" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="0" type="checkbox"<?=($r['sliderOptions'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="enableSlider">Enable</label>
                  </div>
                  <label for="sliderDirection">Direction</label>
                  <div class="form-row">
                    <select id="sliderDirection" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderDirection" onchange="update('<?=$r['id'];?>','menu','sliderDirection',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
                      <option value="horizontal"<?=$r['sliderDirection']=='horizontal'?' selected':'';?>>Horizontal (default)</option>
                      <option value="vertical"<?=$r['sliderDirection']=='vertical'?' selected':'';?>>Vertical</option>
                    </select>
                  </div>
                  <label for="sliderEffect">Effect</label>
                  <div class="form-row">
                    <select id="sliderEffect" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderEffect" onchange="update('<?=$r['id'];?>','menu','sliderEffect',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
                      <option value="slide"<?=$r['sliderEffect']=='slide'?' selected':'';?>>Slide (default)</option>
                      <option value="fade"<?=$r['sliderEffect']=='fade'?' selected':'';?>>Fade</option>
                      <option value="cube"<?=$r['sliderEffect']=='cube'?' selected':'';?>>Cube</option>
                      <option value="coverflow"<?=$r['sliderEffect']=='coverflow'?' selected':'';?>>Coverflow</option>
                      <option value="flip"<?=$r['sliderEffect']=='flip'?' selected':'';?>>Flip</option>
                      <option value="creative"<?=$r['sliderEffect']=='creative'?' selected':'';?>>Creative</option>
                      <option value="cards"<?=$r['sliderEffect']=='cards'?' selected':'';?>>Cards</option>
                    </select>
                  </div>
                  <div class="form-row mt-3">
                    <input id="sliderLoop" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="1" type="checkbox"<?=($r['sliderOptions'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="sliderLoop">Loop</label>
                  </div>
                  <label for="sliderSpeed">Speed</label>
                  <div class="form-row">
                    <input class="textinput" id="sliderSpeed" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderSpeed" type="number" value="<?=$r['sliderSpeed'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Slider Speed..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="savedsliderSpeed" data-dbid="sliderSpeed" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label for="sliderAutoplayDelay">Autoplay Delay</label>
                  <div class="form-row">
                    <input class="textinput" id="sliderAutoplayDelay" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderAutoplayDelay" type="number" value="<?=$r['sliderAutoplayDelay'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Slider Autoplay Delay..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="savedsliderAutoplayDelay" data-dbid="sliderAutoplayDelay" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <div class="form-row mt-3">
                    <input id="sliderDisableOnInteraction" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="2" type="checkbox"<?=($r['sliderOptions'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="sliderDisableOnInteraction">Disable On Interaction</label>
                  </div>
                  <div class="form-row">
                    <input id="sliderNavigation" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="3" type="checkbox"<?=($r['sliderOptions'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="sliderNavigation">Navigation</label>
                  </div>
                  <div class="form-row">
                    <input id="sliderPagination" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="4" type="checkbox"<?=($r['sliderOptions'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="sliderPagination">Pagination</label>
                  </div>
                  <div class="form-row">
                    <input id="sliderScrollbar" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="5" type="checkbox"<?=($r['sliderOptions'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="sliderScrollbar">Scrollbar</label>
                  </div>
                  <div class="form-row">
                    <input id="sliderContentBackground" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="6" type="checkbox"<?=($r['sliderOptions'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="sliderContentBackground">Use Content Image as Background</label>
                  </div>
                </div>
              <?php }?>
              <div class="tab2-3 border p-3" data-tabid="tab2-3" role="tabpanel">
                <label for="coverVideo" class="mt-0">Video URL</label>
                <div class="form-row">
                  <input id="coverVideo" name="feature_image" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" type="text" value="<?=$r['coverVideo'];?>">
                  <?=($user['options'][1]==1?
                    '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`coverVideo`);"><i class="i">browse-media</i></button>'.
                    '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverVideo`,``);"><i class="i">trash</i></button>'.
                    '<button class="save" id="savecoverVideo" data-dbid="coverVideo" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                  :
                    '');?>
                </div>
                <div class="form-row mt-3">
                  <input id="videoAutoplay" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="0" type="checkbox"<?=($r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="videoAutoplay">AutoPlay Cover Video</label>
                </div>
                <div class="form-row">
                  <input id="videoLoop" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="1" type="checkbox"<?=($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="videoLoop">Loop Cover Video</label>
                </div>
                <div class="form-row">
                  <input id="videoControls" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="2" type="checkbox"<?=($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="videoControls">Show Controls</label>
                </div>
                <?php if($r['file']=='index'||$r['file']=='about'||$r['file']=='biography'||$r['file']=='gallery'){?>
                  <legend class="mt-3">Video Playlist</legend>
                  <?php if($user['options'][1]==1){?>
                    <div class="form-text text-muted small">Videos will only show up on this page if the theme template contains the playlist elements.</div>
                    <form class="form-row" target="sp" method="post" action="core/add_playlist.php">
                      <input name="rid" type="hidden" value="<?=$r['id'];?>">
                      <input name="fu" type="text" value="" placeholder="Enter one or more Video URL's (comma separated)...">
                      <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                    </form>
                  <?php }?>
                  <div class="row mt-3" id="pi">
                    <?php $sp=$db->prepare("SELECT * FROM `".$prefix."playlist` WHERE `rid`=:rid ORDER BY `ord` ASC");
                    $sp->execute([':rid'=>$r['id']]);
                    if($sp->rowCount()>0){
                      while($rp=$sp->fetch(PDO::FETCH_ASSOC)){?>
                        <div class="play items card gallery col-6 col-sm-3 m-0 border-0" id="pi_<?=$rp['id'];?>">
                          <img src="<?=$rp['thumbnail_url'];?>">
                          <div class="btn-group tools">
                            <a class="btn" href="<?= URL.$settings['system']['admin'].'/playlist/edit/'.$rp['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                            <?php if($user['options'][1]==1){?>
                              <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?=$rp['id'];?>`,`playlist`);"><i class="i">trash</i></button>
                              <div class="handle btn" data-tooltip="left" aria-label="Drag to Reorder"><i class="i">drag</i></div>
                            <?php }?>
                          </div>
                        </div>
                      <?php }?>
                      <script>
                        $('#pi').sortable({
                          items:".play.items",
                          placeholder:"ghost",
                          helper:fixWidthHelper,
                          update:function(e,ui){
                            var order=$("#pi").sortable("serialize");
                            $.ajax({
                              type:"POST",
                              dataType:"json",
                              url:"core/reorderplaylist.php",
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
                <?php }?>
              </div>
<?php /* On Page Media */ ?>
              <div class="tab2-4 border p-3" data-tabid="tab2-4" role="tabpanel">
                <?php if($user['options'][1]==1){?>
                  <form class="form-row" target="sp" method="post" action="core/add_media.php" enctype="multipart/form-data">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="rid" type="hidden" value="0">
                    <input name="t" type="hidden" value="pages">
                    <input id="mediafile" name="fu" type="text" value="" placeholder="Enter one or more URL's (comma separated), or Select Images using the Media Manager...">
                    <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','media','mediafile');return false;"><i class="i">browse-media</i></button>
                    <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </form>
                <?php }?>
                <div class="row mt-3 justify-content-center" id="mi">
                  <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `rid`=0 AND `pid`=:id ORDER BY `ord` ASC");
                  $sm->execute([':id'=>$r['id']]);
                  if($sm->rowCount()>0){
                    while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                      if(file_exists('media/sm/'.basename($rm['file'])))
                        $thumb='media/sm/'.basename($rm['file']);
                      elseif($rm['file']!='')
                        $thumb=$rm['file'];
                      else
                        $thumb=ADMINNOIMAGE;?>
                      <div id="mi_<?=$rm['id'];?>" class="card stats gallery col-12 col-sm-3 m-0 border-0">
                        <a data-fancybox="media" data-type="image" data-caption="<?=($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?=$rm['file'];?>">
                          <img src="<?=$thumb;?>" alt="Media <?=$rm['id'];?>">
                        </a>
                        <div class="btn-group tools">
                          <div class="btn" data-tooltip="right" aria-label="<?=$rm['views'];?> views"><small><?=$rm['views'];?></small></div>
                          <?=($user['options'][1]==1?
                            '<a href="'.URL.$settings['system']['admin'].'/media/edit/'.$rm['id'].'" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
                            '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$rm['id'].'`,`media`);"><i class="i">trash</i></button>'.
                            '<div class="handle btn" data-tooltip="left" aria-label="Drag to Reorder"><i class="i">drag</i></div>'
                          :
                            '');?>
                        </div>
                      </div>
                    <?php }
                  }?>
                </div>
                <?php if($user['options'][1]==1){?>
                  <div class="ghost"></div>
                  <script>
                    $('#mi').sortable({
                      items:".card.stats",
                      placeholder:"ghost",
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
          </div>
<?php /* Price Items */
          if($r['file']=='pricing'){?>
            <div class="tab1-3 border" data-tabid="tab1-3" role="tabpanel">
              <section class="row list" id="prices">
                <?php $sp=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `price`='1' ORDER BY `priceord` ASC");
                $sp->execute();
                while($rp=$sp->fetch(PDO::FETCH_ASSOC)){?>
                  <article class="card zebra m-0 p-2 border-0" id="l_<?=$rp['id'];?>">
                    <div class="row">
                      <div class="col-sm"><?=$rp['title'];?></div>
                      <div class="col-sm">
                        <div class="form-row">
                          <input id="highlight<?=$rp['id'];?>" data-dbid="<?=$rp['id'];?>" data-dbt="content" data-dbc="highlight" data-dbb="0" type="checkbox"<?=($rp['highlight']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                          <label for="highlight<?=$rp['id'];?>">Highlighted</label>
                        </div>
                      </div>
                      <div class="col-sm">
                        <div id="controls_<?=$rp['id'];?>" class="justify-content-end">
                          <div class="btn-group float-right" role="group">
                            <span class="btn btn-sm pricehandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-row">
                          <div class="input-text">Highlight Text</div>
                          <input class="textinput" id="highlighttext<?=$rp['id'];?>" data-dbid="<?=$rp['id'];?>" data-dbt="content" data-dbc="highlighttext" type="text" value="<?=$rp['highlighttext'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Highlight Text..."':' readonly';?>>
                          <?=$user['options'][1]==1?'<button class="save" id="savehighlighttext'.$rp['id'].'" data-dbid="highlighttext'.$rp['id'].'" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                        </div>
                      </div>
                      <div class="col-12">
                        <form target="sp" method="post" action="core/add_pricelist.php">
                          <input type="hidden" name="rid" value="<?=$rp['id'];?>">
                          <div class="form-row">
                            <div class="input-text">Item</div>
                            <input type="text" name="t" value="">
                            <button class="btn add" type="submit"><i class="i">add</i></button>
                          </div>
                        </form>
                      </div>
                      <div id="pricelist<?=$rp['id'];?>">
                        <?php $spl=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='price' AND `rid`=:rid ORDER BY `ord` ASC");
                        $spl->execute([':rid'=>$rp['id']]);
                        while($rpl=$spl->fetch(PDO::FETCH_ASSOC)){?>
                          <div id="l_<?=$rpl['id'];?>" class="col-12">
                            <div class="form-row">
                              <div class="input-text">Item</div>
                              <input type="text" name="t" value="<?=$rpl['title'];?>">
                              <form target="sp" method="post" action="core/purge.php">
                                <input type="hidden" name="id" value="<?=$rpl['id'];?>">
                                <input type="hidden" name="t" value="choices">
                                <button class="btn trash" type="submit"><i class="i">trash</i></button>
                              </form>
                            </div>
                          </div>
                        <?php }?>
                      </div>
                    </div>
                  </article>
                <?php }?>
                <article class="ghost hidden">&nbsp;</article>
                <script>
                  $('#prices').sortable({
                    items:".card",
                    handle:'.pricehandle',
                    placeholder:".ghost",
                    helper:fixWidthHelper,
                    axis:"y",
                    update:function(e,ui){
                      var order=$("#prices").sortable("serialize");
                      $.ajax({
                        type:"POST",
                        dataType:"json",
                        url:"core/reorderprices.php",
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
              </section>
            </div>
          <?php }
/* SEO */
          if($r['contentType']!='activate'&&$r['contentType']!='offline'){?>
            <div class="tab1-4 border p-3" data-tabid="tab1-4" role="tabpanel">
              <label for="views" class="mt-0">Views</label>
              <div class="form-row">
                <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
                <?=($user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`menu`,`views`,`0`);"><i class="i">eraser</i></button><button class="save" id="saveviews" data-dbid="views" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <label for="metaRobots">Meta Robots</label>
              <div class="form-text">Options for Meta Robots: <span data-tooltip="left" data-tooltip="tooltip" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Robots.md" data-tooltip="tooltip" aria-label="SEO Meta Robots Information"><i class="i">seo</i></button>
                <input class="textinput" id="metaRobots" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" type="text" value="<?=$r['metaRobots'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
                <?=($user['options'][1]==1?'<button class="save" id="savemetaRobots" data-dbid="metaRobots" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <div class="card google-result mt-3 p-3 overflow-visible" id="pageSearchResult">
                <div id="google-title" data-tooltip="tooltip" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name."><?=$r['seoTitle'];?></div>
                <div id="google-link"><?= URL;?></div>
                <div id="google-description" data-tooltip="tooltip" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences."><?=$r['seoDescription'];?></div>
              </div>
              <label for="seoTitle">Meta Title</label>
              <div class="form-text">The recommended character count for Titles is a minimum of 50 and maximum of 70.</div>
              <?=($seo['seoTitle']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['seoTitle'],'<strong>').'</div>':'');?>
              <div class="form-row<?=$seo['seoTitle']!=''?' border-danger border-2 border-top-0':'';?>">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
                <div id="seoTitlecnt" class="input-text text-success<?= strlen($r['seoTitle'])<1||strlen($r['seoTitle'])>65?' text-danger':'';?>"><?= strlen($r['seoTitle']);?></div>
                <?php if($user['options'][1]==1){
                  echo'<button onclick="removeStopWords(`seoTitle`,$(`#seoTitle`).val());" data-tooltip="tooltip" aria-label="Remove Stop Words"><i class="i">magic</i></button>';
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'menu',
                    ':c'=>'seoTitle'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoTitle" data-data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }?>
                <div class="input-text" data-el="seoTitle" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter a Meta Title..."><?=$r['seoTitle'];?></div>
                <input class="textinput d-none" id="seoTitle" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" type="text" value="<?=$r['seoTitle'];?>">
                <?=($user['options'][1]==1?
                  '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoTitle" data-data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                  '<button class="analyzeTitle" data-test="seoTitle" data-tooltip="tooltip" aria-label="Analyze Meta Title Text"><i class="i">seo</i></button>'.
                  '<button class="save" id="saveseoTitle" data-dbid="seoTitle" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                :
                  '');?>
              </div>
              <label for="seoDescription">Meta Description</label>
              <div class="form-text">The recommended character count for Descriptions is a minimum of 50 and a maximum of 160.</div>
              <?=$seo['seoDescription']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['seoDescription'],'<strong>').'</div>':'';?>
              <div class="form-row<?=$seo['seoDescription']!=''?' border-danger border-2 border-top-0':'';?>">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Description.md" data-tooltip="tooltip" aria-label="SEO Meta Description Information"><i class="i">seo</i></button>
                <div id="seoDescriptioncnt" class="input-text text-success<?= strlen($r['seoDescription'])<50||strlen($r['seoDescription'])>160?' text-danger':'';?>"><?= strlen($r['seoDescription']);?></div>
                <?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'menu',
                    ':c'=>'seoDescription'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoDescription" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }?>
                <div class="input-text" data-el="seoDescription" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter a Meta Description..."><?=$r['seoDescription'];?></div>
                <input class="textinput d-none" id="seoDescription" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" type="text" value="<?=$r['seoDescription'];?>">
                <?=($user['options'][1]==1?
                  '<button data-fancybox data-type="ajax" data-src="core/layout.suggestions-add.php?id='.$r['id'].'&t=menu&c=seoDescription" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                  '<button class="save" id="saveseoDescription" data-dbid="seoDescription" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                :
                  '');?>
              </div>
            </div>
          <?php }
/* Settings */
          if($r['file']!='activate'&&$r['file']!='comingsoon'&&$r['file']!='maintenance'){?>
            <div class="tab1-5 border p-3" data-tabid="tab1-5" role="tabpanel">
              <?php if($r['file']!='index'&&$r['file']!='offline'){?>
                <div class="form-row">
                  <input id="active" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"<?=($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="active">Active</label>
                </div>
              <?php }
              if($r['file']=='offline'){?>
                <div class="form-row">
                  <input id="prefPWA" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="18" type="checkbox"<?=$config['options'][18]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label for="prefPWA">Enable Offline Page (Progressive Web Application).</label>
                </div>
              <?php }
              if($r['file']!='index'&&$r['file']!='offline'){?>
                <label for="rank">Access</label>
                <div class="form-row">
                  <select id="rank" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="rank" onchange="update('<?=$r['id'];?>','menu','rank',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
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
                    <?=($user['rank']>400?'<option value="500"'.($r['rank']==500?' selected':'').'>Author and above</option>':'').
                    ($user['rank']>500?'<option value="600"'.($r['rank']==600?' selected':'').'>Editor and above</option>':'').
                    ($user['rank']>600?'<option value="700"'.($r['rank']==700?' selected':'').'>Moderator and above</option>':'').
                    ($user['rank']>700?'<option value="800"'.($r['rank']==800?' selected':'').'>Manager and above</option>':'').
                    ($user['rank']>800?'<option value="900"'.($r['rank']==900?' selected':'').'>Administrator and above</option>':'');?>
                  </select>
                </div>
                <?php if($user['rank']>999){?>
                  <label for="contentType">contentType</label>
                  <div class="form-text">
                    <?php $sct=$db->prepare("SELECT DISTINCT(`contentType`) FROM `".$prefix."content` WHERE `contentType`!='' ORDER BY contentType ASC");
                    $sct->execute();
                    while($rct=$sct->fetch(PDO::FETCH_ASSOC))echo$rct['contentType'].' ';?>
                  </div>
                  <div class="form-row">
                    <input class="textinput" id="contentType" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="contentType" type="text" value="<?=$r['contentType'];?>" placeholder="">
                    <button class="save" id="savecontentType" data-dbid="contentType" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                  </div>
                <?php }?>
                <label for="url">URL Type</label>
                  <div class="form-text">Leave Blank for auto-generated URL's. Enter a URL to link to another service. Or use <span class="badger badge-secondary click" style="cursor:pointer;" onclick="$('#url').val('#<?=$r['contentType'];?>');update('<?=$r['id'];?>','menu','url',$('#url').val());">#<?=$r['contentType'];?></span> to link to Anchor on same page.</div>
                  <div class="form-row">
                    <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="url" type="text" value="<?=$r['url'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveurl" data-dbid="url" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <?php if($r['menu']=='head'||$r['menu']=='other'||$r['menu']=='footer'||$user['rank']>999){?>
                    <div class="row">
                      <div class="col-12 col-md-6 pr-md-1">
                        <label for="menu">Menu</label>
                        <div class="form-row">
                          <select id="menu"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','menu','menu',$(this).val(),'select');">
                            <option value="head"<?=$r['menu']=='head'?' selected':'';?>>Head</option>
                            <option value="other"<?=$r['menu']=='other'?' selected':'';?>>Other</option>
                            <option value="footer"<?=$r['menu']=='footer'?' selected':'';?>>Footer</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-12 col-md-6 pl-md-1">
                        <label for="mid">SubMenu</label>
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
                  <?php }
                }?>
              </div>
            <?php }?>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
