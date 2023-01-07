<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.21
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$seo=[
  'heading' => '',
  'seoTitle' => '',
  'seoDescription' => '',
  'fileALT' => '',
  'notes' => ''
];
$seoerrors=0;
if($r['seoTitle']==''){
  $seoerrors++;
  $seo['seoTitle'] = '<br>The <strong><a href="javascript:seoLink(`seoTitle`,`tab1-4`);">Meta Title</a></strong> is empty, while AuroraCMS tries to autofill this entry when building the page, it is better to fill in this information yourself!';
}elseif(strlen($r['seoTitle'])<50){
  $seoerrors++;
  $seo['seoTitle'] = '<br>The <strong><a href="javascript:seoLink(`seoTitle`,`tab1-4`);">Meta Title</a></strong> is less than <strong>50</strong> characters!';
}elseif(strlen($r['seoTitle'])>70){
  $seoerrors++;
  $seo['seoTitle'] = '<br>The <strong><a href="javascript:seoLink(`seoTitle`,`tab1-4`);">Meta Title</a></strong> is longer than <strong>70</strong> characters!';
}
if($r['seoDescription']==''){
  $seoerrors++;
  $seo['seoDescription'] = '<br> The <strong><a href="javascript:seoLink(`seoDescription`,`tab1-4`);">Meta Description</a></strong> is empty, while AuroraCMS tries to autofill this entry when build the page, it is better to fill in this information yourself!';
}elseif(strlen($r['seoDescription'])<1){
  $seoerrors++;
  $seo['seoDescription'] = '<br>The <strong><a href="javascript:seoLink(`seoDescription`,`tab1-4`);">Meta Description</a></strong> is empty!';
}elseif(strlen($r['seoDescription'])>160){
  $seoerrors++;
  $seo['seoDescription'] = '<br>The <strong><a href="javascript:seoLink(`seoDescription`,`tab1-4`);">Meta Description</a></strong> is longer than <strong>160</strong> characters!';
}
if($r['cover']!=''&&strlen($r['fileALT'])<1){
  $seoerrors++;
  $seo['fileALT'] = '<br>The <strong><a href="javascript:seoLink(`fileALT`,`tab1-2`);">Image ALT</a></strong> text is empty!';
}
if(strip_tags($r['notes'])==''){
  $seoerrors++;
  $seo['notes'] = '<br>The <strong><a href="javascript:seoLink(`notesda`,`tab1-1`);">Description</a></strong> is empty. At least <strong>100</strong> characters is recommended!';
}elseif(strlen(strip_tags($r['notes']))<100){
  $seoerrors++;
  $seo['notes'] = '<br>The <strong><a href="javascript:seoLink(`notesda`,`tab1-1`);">Description</a></strong> Text is less than <strong>100</strong> Characters!';
}
preg_match('~<h1>([^{]*)</h1>~i',$r['notes'],$h1);
if(isset($h1[1])){
  $seoerrors++;
  $seo['notesHeading'] = '<br>Do not use <strong>H1</strong> headings in the <strong><a href="javascript:seoLink(`notesda`,`tab1-1`);">Description</a></strong> Text, as AuroraCMS uses the <strong>Heading</strong> Field to place H1 headings on page, and uses them for other areas for SEO!';
}
if($r['heading']==''){
  $seoerrors++;
  $seo['heading'] = '<br>The <strong><a href="javascript:seoLink(`heading`,`tab1-1`);">Heading</a></strong> Field is empty, this is what is used for your H1 heading!';
}?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid p-0">
      <div class="row p-2">
      <div class="card col-12 col-sm mt-3 p-4 border-radius-0 bg-white border-0 shadow overflow-visible order-2 order-sm-1">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
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
                <?php if(isset($_SERVER['HTTP_REFERER'])){?>
                  <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>
                <?php }?>
                <button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <?=$seoerrors>0?'<div class="alert alert-warning">There are '.$seoerrors.' things that could affect the SEO of this page!!! (Each item is highlighted.)'.
            $seo['heading'].
            $seo['notesHeading'].
            $seo['notes'].
            $seo['fileALT'].
            $seo['seoTitle'].
            $seo['seoDescription'].
          '</div>':'';?>
          <input class="tab-control" id="tab1-1" name="tabs" type="radio">
          <label for="tab1-1">Content</label>
          <?=$r['file']!='offline'?'<input class="tab-control" id="tab1-2" name="tabs" type="radio"><label for="tab1-2">Images</label>':'';?>
          <?=$r['file']=='index'||$r['file']=='about'||$r['file']=='biography'||$r['file']=='gallery'?'<input id="tab1-3" class="tab-control" name="tabs" type="radio"><label for="tab1-3">Media</label>':'';?>
          <?=$r['file']!='activate'&&$r['file']!='offline'?'<input class="tab-control" id="tab1-4" name="tabs" type="radio"><label for="tab1-4">SEO</label>':'';?>
          <?=$r['file']!='activate'&&$r['file']!='comingsoon'&&$r['file']!='maintenance'?'<input id="tab1-5" class="tab-control" name="tabs" type="radio"><label for="tab1-5">Settings</label>':'';?>
<?php /* Content */ ?>
          <div class="tab1-1 border-top p-4" data-tabid="tab1-1" role="tabpanel">
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'&&$r['contentType']!='offline'){?>
              <label id="menuTitle" for="title"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#menuTitle" data-tooltip="tooltip" aria-label="PermaLink to Menu Title Field">&#128279;</a>':'';?>Menu Title</label>
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
                <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
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
              <label id="pageURLSlug" for="urlSlug"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageURLSlug" data-tooltip="tooltip" aria-label="PermaLink to Page URL Slug">&#128279;</a>':'';?>URL Slug</label>
              <div class="form-row">
                <div class="input-text col-12" id="urlSlug">
                  <a id="genurl" target="_blank" href=<?= '"'.URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/').'">'.URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/').'</a>';?>
                </div>
              </div>
            <?php }?>
            <div class="form-row mt-3">
              <label id="pageHeading" for="heading"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageHeading" data-tooltip="tooltip" aria-label="PermaLink to Page Heading Field">&#128279;</a>':'';?>Page&nbsp;Heading</label>
              <small class="form-text text-right">This text is normally used in the &lt;h1&gt; heading tag. If left empty, the SEO Meta Title will be used, otherwise an auto-generated text will be used.</small>
            </div>
            <?=$seo['heading']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['heading'],'<strong>').'</div>':'';?>
            <div class="form-row<?=$seo['heading']!=''?' border-danger border-2 border-top-0':'';?>">
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
              <input class="textinput" id="heading" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="heading" type="text" value="<?=$r['heading'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Heading..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=title" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="analyzeTitle" data-test="heading" data-tooltip="tooltip" aria-label="Analyze Page Heading Text"><i class="i">seo</i></button>'.
              '<button class="save" id="saveheading" data-dbid="heading" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
<?php if($r['contentType']=='comingsoon'){?>
            <div class="col-12 col-sm-4">
              <label id="dateEnd" for="tie"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#dateEnd" data-tooltip="tooltip" aria-label="PermaLink to Coming Soon Live Date Field">&#128279;</a>':'';?>Countdown Clock&nbsp;<span class="labeldate" id="labeldatetie"><?= $r['tie']>0?date($config['dateFormat'],$r['tie']):'';?></span></label>
              <div class="form-row">
                <input id="tie" type="datetime-local" value="<?=$r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`menu`,`tie`,getTimestamp(`tie`));"':' readonly';?>>
                <button class="trash" data-tooltip="tooltip" aria-label="Clear Date" onclick="$(`#tie`).val(`0`);updateButtons(`<?=$r['id'];?>`,`menu`,`tie`,`0`);"><i class="i">eraser</i></button>
              </div>
            </div>
<?php }?>
            <div class="row mt-3<?=$seo['notes']!=''||$seo['notesHeading']!=''?' border-danger border-2':'';?>" id="pageNotes">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageNotes" data-tooltip="tooltip" aria-label="PermaLink to Page Content Editor">&#128279;</a>':'';?>
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
                <?=$seo['notes']!=''?'<div class="alert alert-warning m-0">'.strip_tags($seo['notes'],'<strong>').'</div>':'';?>
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
<?php if($r['contentType']!='offline'){?>
          <div class="tab1-2 border-top p-4" data-tabid="tab1-2" role="tabpanel">
            <legend>Cover</legend>
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label id="pageCoverURL" for="coverURL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageCoverURL" data-tooltip="tooltip" aria-label="PermaLink to Page Cover Image URL Field">&#128279;</a>':'';?>Cover&nbsp;Image&nbsp;URL</label>
              <div class="form-row">
                <input class="image" id="coverURL" type="text" value="<?=$r['coverURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter Cover URL..."':' readonly';?> onchange="coverUpdate('<?=$r['id'];?>','menu','coverURL',$(this).val());">
                <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverURL`,``);"><i class="i">trash</i></button>':'';?>
              </div>
            <?php }?>
            <label id="pageCoverImage" for="cover"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageCoverImage" data-tooltip="tooltip" aria-label="PermaLink to Page Cover Image Field">&#128279;</a>':'';?>Image</label>
            <div class="form-row">
              <input id="cover" name="feature_image" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="cover" type="text" value="<?=$r['cover'];?>" readonly onchange="coverUpdate('<?=$r['id'];?>','menu','cover',$(this).val());">
              <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`cover`);"><i class="i">browse-media</i></button>':'';
              if($r['cover']!='')echo'<a data-fancybox="cover" data-type="image" href="'.$r['cover'].'"><img class="bg-white" id="coverimage" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL']!='')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL']!='')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              else echo'<img id="coverimage" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';
              echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,``);"><i class="i">trash</i></button>':'';?>
            </div>
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label id="pageImageALT" for="fileALT"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageImageALT" data-tooltip="tooltip" aria-label="PermaLink to Page Cover Image ALT Field">&#128279;</a>':'';?>Image ALT</label>
              <?=$seo['fileALT']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['fileALT'],'<strong>').'</div>':'';?>
              <div class="form-row<?=$r['cover']!=''&&$seo['fileALT']!=''?' border-danger border-2 border-top-0':'';?>">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><i class="i">seo</i></button>
                <input class="textinput" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Image ALT Test..."':' readonly';?>>
                <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-dbid="fileALT" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label id="pageVideoURL" for="coverVideo"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoURL" data-tooltip="tooltip" aria-label="PermaLink to Page Cover Video Field">&#128279;</a>':'';?>Video URL</label>
              <div class="form-row">
                <input id="coverVideo" name="feature_image" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" type="text" value="<?=$r['coverVideo'];?>">
                <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`coverVideo`);"><i class="i">browse-media</i></button>'.
                '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverVideo`,``);"><i class="i">trash</i></button>':'';?>
                <?=$user['options'][1]==1?'<button class="save" id="savecoverVideo" data-dbid="coverVideo" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <div class="row mt-3">
                <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoAutoplay" data-tooltip="tooltip" aria-label="PermaLink to Page Video AutoPlay Checkbox">&#128279;</a>':'';?>
                <input id="pageVideoAutoplay" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="0" type="checkbox"<?=$r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label id="menuoptions0<?=$r['id'];?>" for="pageVideoAutoplay">AutoPlay Cover Video</label>
              </div>
              <div class="row">
                <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoLoop" data-tooltip="tooltip" aria-label="PermaLink to Page Cover Image">&#128279;</a>':'';?>
                <input id="pageVideoLoop" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="1" type="checkbox"<?=$r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label id="menuoptions1<?=$r['id'];?>" for="pageVideoLoop">Loop Cover Video</label>
              </div>
              <div class="row">
                <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageVideoControls" data-tooltip="tooltip" aria-label="PermaLink to Page Video Show Controls Checkbox">&#128279;</a>':'';?>
                <input id="pageVideoControls" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="2" type="checkbox"<?=$r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label id="menuoptions2<?=$r['id'];?>" for="pageVideoControls">Show Controls</label>
              </div>
              <legend class="mt-3">Image Attribution</legend>
              <label id="pageAttributionImageTitle" for="attributionImageTitle"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAttributionImageTitle" data-tooltip="tooltip" aria-label="PermaLink to Page Image Attribution Title Field">&#128279;</a>':'';?>Title</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageTitle" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" type="text" value="<?=$r['attributionImageTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                <?=$user['options'][1]==1?'<button class="save" id="saveattributionImageTitle" data-dbid="attributionImageTitle" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label id="pageAttributionImageName" for="attributionImageName"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAttributionImageName" data-tooltip="tooltip" aria-label="PermaLink to Page Image Attribution Name Field">&#128279;</a>':'';?>Name</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageName" list="attributionImageTitle_option" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" type="text" value="<?=$r['attributionImageName'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                <?php if($user['options'][1]==1){
                  $s=$db->query("SELECT DISTINCT `attributionImageTitle` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."login` ORDER BY `name` ASC");
                  if($s->rowCount()>0){?>
                    <datalist id="attributionImageTitle_option">
                      <?php while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                    </datalist>
                  <?php }
                  echo'<button class="save" id="saveattributionImageName" data-dbid="attributionImageName" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                }?>
              </div>
              <label id="pageAttributionImageURL" for="attributionImageURL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAttributionImageURL" data-tooltip="tooltip" aria-label="PermaLink to Page Image Attribution URL Field">&#128279;</a>':'';?>URL</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" type="text" value="<?=$r['attributionImageURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                <?php if($user['options'][1]==1){
                  $s=$db->query("SELECT DISTINCT `attributionImageURL` AS url FROM `".$prefix."content` ORDER BY `url` ASC");
                  if($s->rowCount()>0){?>
                    <datalist id="attributionImageURL_option">
                      <?php while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                    </datalist>
                  <?php }
                  echo'<button class="save" id="saveattributionImageURL" data-dbid="attributionImageURL" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                }?>
              </div>
            <?php }?>
          </div>
<?php }
/* Media */
          if($r['file']=='index'||$r['file']=='about'||$r['file']=='biography'||$r['file']=='gallery'){?>
            <div class="tab1-3 border-top p-4" data-tabid="tab1-3" role="tabpanel">
              <legend>Video Playlist</legend>
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
                    <div class="play items col-11 col-sm-4 p-3 mx-auto" id="pi_<?=$rp['id'];?>">
                      <?php if($user['options'][1]==1){?>
                        <div class="btn-group float-right">
                          <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item"><i class="i">drag</i></div>
                          <a class="btn" href="<?= URL.$settings['system']['admin'].'/playlist/edit/'.$rp['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                          <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?=$rp['id'];?>`,`playlist`);"><i class="i">trash</i></button>
                        </div>
                      <?php }?>
        							<img src="<?=$rp['thumbnail_url'];?>">
                      <?=$rp['title'];?>
        						</div>
                  <?php }?>
                  <script>
                    $('#pi').sortable({
                      items:".play.items",
                      placeholder:".ghost",
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
              <hr>
              <legend class="mt-3">Images for Media</legend>
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
              <div class="row mt-3" id="mi">
                <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `rid`=0 AND `pid`=:id ORDER BY `ord` ASC");
                $sm->execute([':id'=>$r['id']]);
                if($sm->rowCount()>0){
                  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                    if(file_exists('media/sm/'.basename($rm['file'])))
                      $thumb='media/sm/'.basename($rm['file']);
                    elseif(file_exists('media/'.basename($rm['file'])))
                      $thumb='media/'.basename($rm['file']);
                    else
                      $thumb=ADMINNOIMAGE;?>
                    <div id="mi_<?=$rm['id'];?>" class="card stats col-6">
                      <?php if($user['options'][1]==1){?>
                        <div class="btn-group float-right">
                          <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item"><i class="i">drag</i></div>
                          <div class="btn" data-tooltip="tooltip" aria-label="Viewed <?=$rm['views'];?> times"><small><?=$rm['views'];?></small></div>
                          <a class="btn" href="<?= URL.$settings['system']['admin'].'/media/edit/'.$rm['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                          <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?=$rm['id'];?>`,`media`);"><i class="i">trash</i></button>
                        </div>
                      <?php }?>
                      <a data-fancybox data-type="image" data-caption="<?=($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?=$rm['file'];?>" style="display:flex;max-height:150px;">
                        <img src="<?=$thumb;?>" alt="Media <?=$rm['id'];?>" style="object-fit:cover;object-position:center;">
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
/* SEO */
if($r['contentType']!='activate'&&$r['contentType']!='offline'){?>
          <div class="tab1-4 border-top p-4" data-tabid="tab1-4" role="tabpanel">
            <label id="pageViews" for="views"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageViews" data-tooltip="tooltip" aria-label="PermaLink to Page Views Field">&#128279;</a>':'';?>Views</label>
            <div class="form-row">
              <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`menu`,`views`,`0`);"><i class="i">eraser</i></button>'.
              '<button class="save" id="saveviews" data-dbid="views" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label id="pageMetaRobots" for="metaRobots"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMetaRobots" data-tooltip="tooltip" aria-label="PermaLink to Page Meta Robots Field">&#128279;</a>':'';?>Meta&nbsp;Robots</label>
              <small class="form-text text-right">Options for Meta Robots: <span data-tooltip="left" data-tooltip="tooltip" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Robots.md" data-tooltip="tooltip" aria-label="SEO Meta Robots Information"><i class="i">seo</i></button>
              <input class="textinput" id="metaRobots" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" type="text" value="<?=$r['metaRobots'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savemetaRobots" data-dbid="metaRobots" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <div class="card google-result mt-3 p-3 overflow-visible" id="pageSearchResult">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSearchResult" data-tooltip="tooltip" aria-label="PermaLink to Page Search Result">&#128279;</a>':'';?>
              <div id="google-title" data-tooltip="tooltip" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                <?=$r['seoTitle'];?>
              </div>
              <div id="google-link">
                <?= URL;?>
              </div>
              <div id="google-description" data-tooltip="tooltip" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                <?=$r['seoDescription'];?>
              </div>
            </div>
            <div class="form-row mt-3">
              <label id="pageMetaTitle" for="seoTitle"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMetaTitle" data-tooltip="tooltip" aria-label="PermaLink to Page Meta Title Field">&#128279;</a>':'';?>Meta&nbsp;Title</label>
              <small class="form-text text-right">The recommended character count for Titles is a minimum of 50 and maximum of 70.</small>
            </div>
            <?=$seo['seoTitle']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['seoTitle'],'<strong>').'</div>':'';?>
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
              <input class="textinput" id="seoTitle" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" type="text" value="<?=$r['seoTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Title..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoTitle" data-data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="analyzeTitle" data-test="seoTitle" data-tooltip="tooltip" aria-label="Analyze Meta Title Text"><i class="i">seo</i></button>'.
              '<button class="save" id="saveseoTitle" data-dbid="seoTitle" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
<?php /*
            <div class="form-row mt-3">
              <label for="seoCaption">Meta&nbsp;Caption</label>
              <small class="form-text text-right">The recommended character count for Captions is 100.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metacaption" data-tooltip="tooltip" aria-label="SEO Meta Caption Information"><i class="i">seo</i></button>
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
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoCaption" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
              }?>
              <input class="textinput" id="seoCaption" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" type="text" value="<?=$r['seoCaption'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Caption..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoCaption" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="save" id="saveseoCaption" data-dbid="seoCaption" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
*/ ?>
            <div class="form-row mt-3">
              <label id="pageMetaDescription" for="seoDescription"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMetaDescription" data-tooltip="tooltip" aria-label="PermaLink to Page Meta Description Field">&#128279;</a>':'';?>Meta&nbsp;Description</label>
              <small class="form-text text-right">The recommended character count for Descriptions is a minimum of 50 and a maximum of 160.</small>
            </div>
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
              <input class="textinput" id="seoDescription" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" type="text" value="<?=$r['seoDescription'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Description..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout.suggestions-add.php?id='.$r['id'].'&t=menu&c=seoDescription" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="save" id="saveseoDescription" data-dbid="seoDescription" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
<?php /*
            <label for="seoKeywords">Meta&nbsp;Keywords</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Keywords.md" data-tooltip="tooltip" aria-label="SEO Keywords Information"><i class="i">seo</i></button>
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'menu',
                  ':c'=>'seoKewords'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoKeywords" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
              }?>
              <input class="textinput" id="seoKeywords" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" type="text" value="<?=$r['seoKeywords'];?>"<?=$user['options'][1]==1?' placeholder="Enter Meta Keywords..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoKeywords" data-data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
              '<button class="save" id="saveseoKeywords" data-dbid="seoKeywords" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
*/ ?>
          </div>
<?php }
/* Settings */
          if($r['file']!='activate'&&$r['file']!='comingsoon'&&$r['file']!='maintenance'){?>
            <div class="tab1-5 border-top p-4" data-tabid="tab1-5" role="tabpanel">
              <?php if($r['file']!='index'&&$r['file']!='offline'){?>
                <div class="row">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageActive" data-tooltip="tooltip" aria-label="PermaLink to Page Active Checkbox">&#128279;</a>':'';?>
                  <input id="pageActive" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"<?=($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="pageActive" id="menuactive0<?=$r['id'];?>">Active</label>
                </div>
              <?php }
              if($r['file']=='offline'){?>
                <div class="row">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/interface#prefPWA" data-tooltip="tooltip" aria-label="PermaLink to Preferences PWA (Progressive Web Application) Checkbox">&#128279;</a>':'';?>
                  <input id="prefPWA" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="18" type="checkbox"<?=$config['options'][18]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="configoptions181" for="prefPWA">Enable Offline Page (Progressive Web Application).</label>
                </div>
              <?php }
              if($r['file']=='index'){?>
              <fieldset>
                <legend>Featured Content Slider</legend>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#enableSlider" data-tooltip="tooltip" aria-label="PermaLink to Slider Enable Checkbox">&#128279;</a>':'';?>
                  <input id="enableSlider" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="0" type="checkbox"<?=$r['sliderOptions'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="sliderOptions00" for="enableSlider">Enable</label>
                </div>
                <label id="pageSliderDirection" for="sliderDirection"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSliderDirection" data-tooltip="tooltip" aria-label="PermaLink to Page Slider Direction">&#128279;</a>':'';?>Direction</label>
                <div class="form-row">
                  <select id="sliderDirection" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderDirection" onchange="update('<?=$r['id'];?>','menu','sliderDirection',$(this).val(),'select');"<?=$user['options'][5]==1?'':' disabled';?>>
                    <option value="horizontal"<?=$r['sliderDirection']=='horizontal'?' selected':'';?>>Horizontal (default)</option>
                    <option value="vertical"<?=$r['sliderDirection']=='vertical'?' selected':'';?>>Vertical</option>
                  </select>
                </div>
                <label id="pageSliderEffect" for="sliderEffect"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSliderEffect" data-tooltip="tooltip" aria-label="PermaLink to Page Slider Effect">&#128279;</a>':'';?>Effect</label>
                <div class="form-row">
                  <select id="sliderEffect" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderEffect" onchange="update('<?=$r['id'];?>','menu','sliderEffect',$(this).val(),'select');"<?=$user['options'][5]==1?'':' disabled';?>>
                    <option value="slide"<?=$r['sliderEffect']=='slide'?' selected':'';?>>Slide (default)</option>
                    <option value="fade"<?=$r['sliderEffect']=='fade'?' selected':'';?>>Fade</option>
                    <option value="cube"<?=$r['sliderEffect']=='cube'?' selected':'';?>>Cube</option>
                    <option value="coverflow"<?=$r['sliderEffect']=='coverflow'?' selected':'';?>>Coverflow</option>
                    <option value="flip"<?=$r['sliderEffect']=='flip'?' selected':'';?>>Flip</option>
                    <option value="creative"<?=$r['sliderEffect']=='creative'?' selected':'';?>>Creative</option>
                    <option value="cards"<?=$r['sliderEffect']=='cards'?' selected':'';?>>Cards</option>
                  </select>
                </div>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#sliderLoop" data-tooltip="tooltip" aria-label="PermaLink to Slider Loop Checkbox">&#128279;</a>':'';?>
                  <input id="sliderLoop" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="1" type="checkbox"<?=$r['sliderOptions'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="sliderOptions01" for="sliderLoop">Loop</label>
                </div>
                <label id="pageSliderSpeed" for="dCost"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSliderSpeed" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Slider Speed Field">&#128279;</a>':'';?>Speed</label>
                <div class="form-row">
                  <input class="textinput" id="sliderSpeed" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderSpeed" type="number" value="<?=$r['sliderSpeed'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Slider Speed..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savedsliderSpeed" data-dbid="sliderSpeed" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <label id="pageSliderAutoplayDelay" for="sliderAutoplayDelay"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSliderAutoplayDelay" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' SliderAutoplayDelay">&#128279;</a>':'';?>Autoplay Delay</label>
                <div class="form-row">
                  <input class="textinput" id="sliderAutoplayDelay" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderAutoplayDelay" type="number" value="<?=$r['sliderAutoplayDelay'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Slider Autoplay Delay..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savedsliderAutoplayDelay" data-dbid="sliderAutoplayDelay" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#sliderDisableOnInteraction" data-tooltip="tooltip" aria-label="PermaLink to Slider Disable On Interaction Checkbox">&#128279;</a>':'';?>
                  <input id="sliderDisableOnInteraction" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="2" type="checkbox"<?=$r['sliderOptions'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="sliderOptions02" for="sliderDisableOnInteraction">Disable On Interaction</label>
                </div>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#sliderNavigation" data-tooltip="tooltip" aria-label="PermaLink to Slider Navigation Checkbox">&#128279;</a>':'';?>
                  <input id="sliderNavigation" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="3" type="checkbox"<?=$r['sliderOptions'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="sliderOptions03" for="sliderNavigation">Navigation</label>
                </div>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#sliderPagination" data-tooltip="tooltip" aria-label="PermaLink to Slider Pagination Checkbox">&#128279;</a>':'';?>
                  <input id="sliderPagination" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="4" type="checkbox"<?=$r['sliderOptions'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="sliderOptions04" for="sliderPagination">Pagination</label>
                </div>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#sliderscrollbar" data-tooltip="tooltip" aria-label="PermaLink to Slider Scrollbar Checkbox">&#128279;</a>':'';?>
                  <input id="sliderScrollbar" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="5" type="checkbox"<?=$r['sliderOptions'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="sliderOptions05" for="sliderScrollbar">Scrollbar</label>
                </div>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/settings#sliderContentBackground" data-tooltip="tooltip" aria-label="PermaLink to Slider Content Background Checkbox">&#128279;</a>':'';?>
                  <input id="sliderContentBackground" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="sliderOptions" data-dbb="6" type="checkbox"<?=$r['sliderOptions'][6]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                  <label id="sliderOptions06" for="sliderContentBackground">Use Content Image as Background</label>
                </div>
              </fieldset>
              <?php }
                if($r['file']!='index'&&$r['file']!='offline'){?>
                <label id="pageAccess" for="rank"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageAccess" data-tooltip="tooltip" aria-label="PermaLink to Page Access Selector">&#128279;</a>':'';?>Access</label>
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
                </div>
                <?php if($user['rank']>999){?>
                  <div class="form-row mt-3">
                    <label id="pageContentType" for="contentType"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageContentType" data-tooltip="tooltip" aria-label="PermaLink to Page Content Type Field">&#128279;</a>':'';?>contentType</label>
                    <small class="form-text text-right">
                      <?php $sct=$db->prepare("SELECT DISTINCT(`contentType`) FROM `".$prefix."content` WHERE `contentType`!='' ORDER BY contentType ASC");
                      $sct->execute();
                      while($rct=$sct->fetch(PDO::FETCH_ASSOC))echo$rct['contentType'].' ';?>
                    </small>
                  </div>
                  <div class="form-row">
                    <input class="textinput" id="contentType" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="contentType" type="text" value="<?=$r['contentType'];?>" placeholder="">
                    <button class="save" id="savecontentType" data-dbid="contentType" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                  </div>
                <?php }?>
                <div class="form-row mt-3">
                  <label id="pageURLType" for="url"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageURLType" data-tooltip="tooltip" aria-label="PermaLink to Page URL Type Field">&#128279;</a>':'';?>URL&nbsp;Type</label>
                  <small class="form-text text-right">Leave Blank for auto-generated URL's. Enter a URL to link to another service. Or use <code class="click" style="cursor:pointer;" onclick="$('#url').val('#<?=$r['contentType'];?>');update('<?=$r['id'];?>','menu','url',$('#url').val());"><small>#<?=$r['contentType'];?></small></code> to link to Anchor on same page.</small>
                </div>
                <div class="form-row">
                  <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="url" type="text" value="<?=$r['url'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="saveurl" data-dbid="url" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <?php if($r['menu']=='head'||$r['menu']=='other'||$r['menu']=='footer'||$user['rank']>999){?>
                  <div class="row">
                    <div class="col-12 col-md-6 pr-md-1">
                      <label id="pageMenu" for="menu"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageMenu" data-tooltip="tooltip" aria-label="PermaLink to Page Menu Selector">&#128279;</a>':'';?>Menu</label>
                      <div class="form-row">
                        <select id="menu"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','menu','menu',$(this).val(),'select');">
                          <option value="head"<?=$r['menu']=='head'?' selected':'';?>>Head</option>
                          <option value="other"<?=$r['menu']=='other'?' selected':'';?>>Other</option>
                          <option value="footer"<?=$r['menu']=='footer'?' selected':'';?>>Footer</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 pl-md-1">
                      <label id="pageSubMenu" for="mid"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'#pageSubMenu" data-tooltip="tooltip" aria-label="PermaLink to Page SubMenu Selector">&#128279;</a>':'';?>SubMenu</label>
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
