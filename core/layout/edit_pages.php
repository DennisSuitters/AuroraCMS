<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options
 * @changes    v0.0.3 Adjust editable fields for Coming Soon and Maintenance pages.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.13 Add Lorem Generator for Administrators.
 * @changes    v0.0.15 Add Display Block Elements in Editor Button.
 * @changes    v0.0.15 Add Check to Current Item in Dropdown.
 * @changes    v0.0.15 Fix truncating file extensions for 3 or 4 character length extensions.
 * @changes    v0.0.15 Add Edit Media information button.
 * @changes    v0.0.17 Add Access levels for content.
 * @changes    v0.0.17 Add better options for Videos.
 * @changes    v0.0.17 Fix incorrect field and database selection for SubMenu selection.
 * @changes    v0.0.17 Add SEO Helper buttons.
 * @changes    v0.0.18 Add Text Statistics.
 * @changes    v0.0.18 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 */
require'core'.DS.'TextStatistics'.DS.'Maths.php';
require'core'.DS.'TextStatistics'.DS.'Pluralise.php';
require'core'.DS.'TextStatistics'.DS.'Resource.php';
require'core'.DS.'TextStatistics'.DS.'Syllables.php';
require'core'.DS.'TextStatistics'.DS.'Text.php';
require'core'.DS.'TextStatistics'.DS.'TextStatistics.php';
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE id=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
    <li class="breadcrumb-item"><?php echo$user['options'][1]==1?'Edit':'View';?></li>
    <li class="breadcrumb-item active">
      <span id="titleupdate"><?php echo$r['title'];?></span>
<?php $so=$db->prepare("SELECT id,title,active,ord FROM `".$prefix."menu` WHERE active=:act ORDER BY ord ASC");
$so->execute([':act'=>1]);
if($so->rowCount()>0){
      echo'<a class="btn btn-ghost-normal dropdown-toggle m-0 p-0 pl-2 pr-2 text-white" data-toggle="dropdown" href="'.URL.$settings['system']['admin'].'/pages'.'" aria-haspopup="true" aria-expanded="false"></a><div class="dropdown-menu">';
      while($ro=$so->fetch(PDO::FETCH_ASSOC))echo'<a class="dropdown-item small pt-1 pb-1 text-white'.($ro['id']==$r['id']?' active':'').'" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'">'.($ro['id']==$r['id']?'&check;&nbsp;':'&nbsp;&nbsp;&nbsp;').$ro['title'].'</a>';
      echo'</div>';
}?>
    </li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid row">
    <div class="card col-12 col-md-9 order-2 order-md-1 px-0">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-pages-content" aria-controls="tab-pages-content" role="tab" data-toggle="tab">Content</a></li>
          <?php echo$r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'?'<li role="presentation" class="nav-item"><a class="nav-link" href="#tab-pages-images" aria-controls="tab-pages-images" role="tab" data-toggle="tab">Images</a></li>'.
          '<li role="presentation" class="nav-item"><a class="nav-link" href="#tab-pages-media" aria-controls="tab-pages-media" role="tab" data-toggle="tab">Media</a></li>':'';?>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-pages-seo" aria-controls="tab-pages-seo" role="tab" data-toggle="tab">SEO</a></li>
          <?php echo$r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'?'<li role="presentation" class="nav-item"><a class="nav-link" href="#tab-pages-settings" aria-controls="tab-pages-settings" role="tab" data-toggle="tab">Settings</a></li>':'';?>
        </ul>
        <div class="tab-content">
          <div id="tab-pages-content" class="tab-pane active" role="tabpanel">
<?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
            <div class="form-group">
              <label for="title">Title</label>
              <div class="input-group">
                <div class="input-group-prepend">
<?php           if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'title']);
                  echo$ss->rowCount()>0?'<button class="btn btn-secondary suggestions" data-tooltip="tooltip" data-title="Editing Suggestions" data-dbgid="title" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                }?>
                  <button class="btn btn-secondary seohelper" data-tooltip="tooltip" data-title="SEO Title Information" data-type="title" aria-label="SEO Title Information"><?php svg('seo');?></button>
                </div>
                <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" onkeyup="genurl();$('#titleupdate').text($(this).val());"<?php echo$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary addsuggestion" data-dbgid="title" data-tooltip="tooltip" data-placement="top" data-title="Add Suggestion" aria-label="Add Suggestion">'.svg2('idea').'</button><button id="savetitle" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="title" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'');?>"+data.replace(/ /g,"-");
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                }
              </script>
            </div>
            <div class="form-group">
              <label for="genurl">URL Slug</label>
              <div class="input-group">
                <div class="input-group-text form-control text-truncate">
                  <a id="genurl" target="_blank" href="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>"><?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?></a>
                </div>
              </div>
            </div>
<?php }?>
            <div class="form-group mb-5">
              <div class="card-header position-relative p-0">
<?php           if($user['options'][1]==1){
                  if($r['suggestions']==1){
                    $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                    $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'notes']);
                    echo$ss->rowCount()>0?'<button class="btn btn-secondary btn-sm suggestions" data-tooltip="tooltip" data-title="Editing Suggestions" data-dbgid="notesda" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                  }
                  echo'<div class="btn-group d-flex justify-content-end">'.
                    '<button class="btn btn-secondary seohelper" data-type="content" data-tooltip="tooltip" data-title="SEO Content Information" aria-label="SEO Content Information">'.svg2('seo').'</button>'.
                    '<button class="btn btn-secondary btn-sm" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;" data-tooltip="tooltip" data-title="Show Element Blocks" aria-label="Show Element Blocks">'.svg2('blocks').'</button>'.
                    '<input id="ipsumc" class="form-control" style="width:40px;" value="5">'.
                    '<button class="btn btn-secondary btn-sm" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;" data-tooltip="tooltip" data-title="Add Aussie Lorem Ipsum" aria-label="Add Aussie Lorem Ipsum">'.svg2('loremipsum').'</button>'.
                    '<button class="btn btn-secondary btn-sm addsuggestion" data-dbgid="notesda" data-tooltip="tooltip" data-title="Add Suggestion" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
                  '</div>';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="menu">
                  <input type="hidden" name="c" value="notes">
                  <div class="note-admin disable-block">
                    <textarea id="notes" class="summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
                  </div>
                </form>
<?php           }else{?>
                <div class="note-admin">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-editable">
                        <?php echo rawurldecode($r['notes']);?>
                      </div>
                    </div>
                  </div>
                </div>
<?php           }?>
              </div>
              <div class="form-text small text-muted float-right">Edited: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
            </div>
          </div>

<?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
          <div id="tab-pages-images" class="tab-pane" role="tabpanel">
            <fieldset class="control-fieldset">
              <legend class="control-legend">Cover</legend>
              <div class="form-group">
                <label for="coverURL">URL</label>
                <div class="input-group">
                  <input type="text" id="coverURL" class="form-control image" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());"<?php echo$user['options'][1]==1?' placeholder="Enter Cover URL..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverURL`,``);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button></div>':'';?>
                </div>
              </div>
              <div class="form-group">
                <label for="cover">Image</label>
                <div class="input-group">
                  <input type="text" id="cover" class="form-control" name="feature_image" value="<?php echo$r['cover'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="cover" onchange="coverUpdate('<?php echo$r['id'];?>','menu','cover',$(this).val());" readonly>
                  <div class="input-group-append">
                    <?php echo$user['options'][1]==1?'<button class="btn btn-secondary" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`cover`);" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager">'.svg2('browse-media').'</button>':'';?>
                    <?php if($r['cover']!='')echo'<a data-fancybox="cover" data-type="image" href="'.$r['cover'].'"><img id="coverimage" class="bg-white" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
                    elseif($r['coverURL']!='')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                    elseif($r['coverURL'] != '')echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                    else echo'<img id="coverimage" class="bg-white" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';?>
                    <?php echo$user['options'][1]==1?'<button class="btn btn-secondary trash" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,``);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>':'';?>
                  </div>
                </div>
              </div>
              <div id="tab-content-images-7" class="form-group">
                <label for="exifFilename">Image ALT</label>
                <div class="input-group">
                  <div class="input-group-prepend"><button class="btn btn-secondary seohelper" data-tooltip="tooltip" data-title="SEO Image Alt Information" data-type="alt" aria-label="SEO Image Alt Information"><?php svg('seo');?></button></div>
                  <input type="text" id="fileALT" class="form-control textinput" value="<?php echo$r['fileALT'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="fileALT"<?php echo$user['options'][1]==1?' placeholder="Enter an Image ALT Test..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append"><button id="savefileALT" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="fileALT" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div class="form-group">
                <label for="coverVideo">Video URL</label>
                <div class="input-group">
                  <input type="text" id="coverVideo" class="form-control" name="feature_image" value="<?php echo$r['coverVideo'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="coverVideo">
                  <div class="input-group-append">
                    <?php echo$user['options'][1]==1?'<button class="btn btn-secondary" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`coverVideo`);" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager">'.svg2('browse-media').'</button><button class="btn btn-secondary trash" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverVideo`,``);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>':'';?>
                    <?php echo$user['options'][1]==1?'<button id="savecoverVideo" class="btn btn-secondary save"" data-tooltip="tooltip" data-title="Save" data-dbid="coverVideo" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="0"<?php echo$r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">AutoPlay Cover Video</label>
              </div>
              <div class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="1"<?php echo$r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options1" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Loop Cover Video</label>
              </div>
              <div class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options2" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="2"<?php echo$r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options2" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Show Controls</label>
              </div>
            </fieldset>
            <fieldset class="control-fieldset">
              <legend class="control-legend" role="heading">Image Attribution</legend>
              <div class="form-group">
                <label for="attributionImageTitle">Title</label>
                <div class="input-group">
                  <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle"<?php echo$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append"><button id="saveattributionImageTitle" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="attributionImageTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div class="form-group">
                <label for="attributionImageName">Name</label>
                <div class="input-group">
                  <input type="text" id="attributionImageName" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
<?php if($user['options'][1]==1){
                    $s=$db->query("SELECT DISTINCT attributionImageTitle AS name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");
  if($s->rowCount()>0){?>
                  <datalist id="attributionImageTitle_option">
<?php while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
<?php }
                  echo'<div class="input-group-append"><button id="saveattributionImageName" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="attributionImageName" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
                </div>
              </div>
              <div class="form-group">
                <label for="attributionImageURL">URL</label>
                <div class="input-group">
                  <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
<?php if($user['options'][1]==1){
  $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY url ASC");
    if($s->rowCount()>0){?>
                  <datalist id="attributionImageURL_option">
<?php  while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
<?php }
                  echo'<div class="input-group-append"><button id="saveattributionImageURL" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="attributionImageURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
                </div>
              </div>
            </fieldset>
          </div>
<?php }
if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
          <div id="tab-pages-media" class="tab-pane" role="tabpanel">
<?php if($user['options'][1]==1){?>
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <input type="hidden" name="act" value="add_media">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="rid" value="0">
              <input type="hidden" name="t" value="pages">
              <div class="form-group">
                <div class="input-group">
                  <input id="mediafile" type="text" class="form-control" name="fu" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                  <div class="input-group-append">
                    <button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','media','mediafile');return false;" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button>
                    <button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
                  </div>
                </div>
              </div>
            </form>
<?php }?>
            <div class="container">
              <div id="mi" class="row">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND rid=0 AND pid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
if($sm->rowCount()>0){
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
    if(file_exists('media/thumbs/'.preg_replace('/\\.[^.\\s]{3,4}$/','',basename($rm['file'])).'.png'))$thumb='media/thumbs/'.preg_replace('/\\.[^.\\s]{3,4}$/','',basename($rm['file'])).'.png';
    else$thumb=$rm['file'];?>
                <div id="mi_<?php echo$rm['id'];?>" class="media-gallery d-inline-block col-6 col-sm-2 position-relative p-0 m-1 mt-0">
                  <a data-fslightbox="media" data-type="image" class="card bg-dark m-0" href="<?php echo$rm['file'];?>">
                    <img src="<?php echo$thumb;?>" class="card-img" alt="Media <?php echo$rm['id'];?>">
                  </a>
<?php echo$user['options'][1]==1?'<div class="btn-group float-right"><div class="handle btn btn-secondary btn-xs" data-tooltip="tooltip" data-title="Drag to ReOrder this item" aria-label="Drag to ReOrder this item">'.svg2('drag').'</div><a class="btn btn-secondary btn-xs" href="'.URL.$settings['system']['admin'].'/media/edit/'.$rm['id'].'">'.svg2('edit').'</a><button class="btn btn-secondary trash btn-xs" onclick="purge(`'.$rm['id'].'`,`media`);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button></div>':'';?>
                </div>
<?php }?>
                <script>
                  $('#mi').sortable({
                    items:".media-gallery",
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
          </div>
<?php }?>
          <div id="tab-pages-seo" class="tab-pane" role="tabpanel">
            <div class="form-group">
              <label for="views">Views</label>
              <div class="input-group">
                <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views"<?php echo$user['options'][1]==1?'':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary trash" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`menu`,`views`,`0`);" data-tooltip="tooltip" data-title="Clear" aria-label="Clear">'.svg2('eraser').'</button><button id="saveviews" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="views" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div class="form-group">
              <label for="metaRobots">Meta Robots</label>
              <div class="form-block small text-muted float-right">Options for Meta Robots: <span data-tooltip="tooltip" data-title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="tooltip" data-title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="tooltip" data-title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="tooltip" data-title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="tooltip" data-title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="tooltip" data-title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="tooltip" data-title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="tooltip" data-title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="tooltip" data-title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="tooltip" data-title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="tooltip" data-title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <button class="btn btn-secondary seohelper" data-tooltip="tooltip" data-title="SEO Meta Robots Information" data-type="metarobots" aria-label="SEO Meta Robots Information"><?php svg('seo');?></button>
                </div>
                <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="metaRobots"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button id="savemetaRobots" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="metaRobots" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="card col-12 bg-white">
                  <div class="card-body">
                    <div id="google-title" data-tooltip="tooltip" data-placement="left" data-title="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                      <?php echo$r['seoTitle'].' | '.$config['business'];?>
                    </div>
                    <div id="google-link">
                      <?php echo URL;?>
                    </div>
                    <div id="google-description" data-tooltip="tooltip" data-placement="left" data-title="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                      <?php echo$r['seoDescription'];?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="seoTitle">Meta Title</label>
              <div class="form-text small text-muted float-right">The recommended character count for Title's is 70.</div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <button class="btn btn-secondary seohelper" data-tooltip="tooltip" data-title="SEO Title Information" data-type="title" aria-label="SEO Title Information"><?php svg('seo');?></button>
<?php $cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                  <div id="seoTitlecnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></div>
<?php if($user['options'][1]==1){
                  echo'<button class="btn btn-secondary" onclick="removeStopWords(`seoTitle`,$(`#seoTitle`).val());" data-tooltip="tooltip" data-title="Remove Stop Words" aria-label="Remove Stop Words">'.svg2('magic').'</button>';
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoTitle']);
                  echo$ss->rowCount()>0?'<button class="btn btn-secondary suggestions" data-tooltip="tooltip" data-title="Editing Suggestions" data-dbgid="seoTitle" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
  }?>
                </div>
                <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Title..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary addsuggestion" data-tooltip="tooltip" data-title="Add Suggestion" data-toggle="popover" data-dbgid="seoTitle" aria-label="Add Suggestion">'.svg2('idea').'</button><button id="saveseoTitle" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div class="form-group">
              <label for="seoCaption">Meta Caption</label>
              <div class="form-text small text-muted float-right">The recommended character count for Captions is 100.</div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <button class="btn btn-secondary seohelper" data-tooltip="tooltip" data-title="SEO Meta Caption Information" data-type="metacaption" aria-label="SEO Meta Caption Information"><?php svg('seo');?></button>
<?php $cntc=100-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                  <div id="seoCaptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></div>
<?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoCaption']);
                  echo$ss->rowCount()>0?'<button class="btn btn-secondary suggestions" data-tooltip="tooltip" data-title="Editing Suggestions" data-toggle="popover" data-dbgid="seoCaption" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
}?>
                </div>
                <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Caption..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary addsuggestion" data-tooltip="tooltip" data-title="Add Suggestion" data-toggle="popover" data-dbgid="seoCaption" aria-label="Add Suggestion">'.svg2('idea').'</button><button id="saveseoCaption" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div class="form-group">
              <label for="seoDescription">Meta Description</label>
              <div class="form-text small text-muted float-right">The recommended character count for Descriptions is 160.</div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <button class="btn btn-secondary seohelper" data-tooltip="tooltip" data-title="SEO Meta Description Information" data-type="metadescription" aria-label="SEO Meta Description Information"><?php svg('seo');?></button>
<?php $cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                  <div id="seoDescriptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></div>
<?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoDescription']);
                  echo$ss->rowCount()>0?'<button class="btn btn-secondary suggestions" data-tooltip="tooltip" data-title="Editing Suggestions" data-toggle="popover" data-dbgid="seoDescription" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
}?>
                </div>
                <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Description..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary addsuggestion" data-tooltip="tooltip" data-title="Add Suggestion" data-toggle="popover" data-dbgid="seoDescription" aria-label="Add Suggestion">'.svg2('idea').'</button><button id="saveseoDescription" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div class="form-group">
              <label for="seoKeywords">Meta Keywords</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <button class="btn btn-secondary seohelper" data-tooltip="tooltip" data-title="SEO Keywords Information" data-type="keywords" aria-label="SEO Keywords Information"><?php svg('seo');?></button>
<?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoKewords']);
                  echo$ss->rowCount()>0?'<button class="btn btn-secondary suggestions" data-tooltip="tooltip" data-title="Editing Suggestions" data-toggle="popover" data-dbgid="seoKeywords" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
}?>
                </div>
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords"<?php echo$user['options'][1]==1?' placeholder="Enter Meta Keywords..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary addsuggestion" data-tooltip="tooltip" data-title="Add Suggestion" data-toggle="popover" data-dbgid="seoKeywords" aria-label="Add Suggestion">'.svg2('idea').'</button><button id="saveseoKeywords" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seoKeywords" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
          </div>
<?php if($r['contentType']!='comingsoon'&&['contentType']!='maintenance'){?>
          <div id="tab-pages-settings" class="tab-pane" role="tabpanel">
<?php if($r['contentType']!='index'){?>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="active<?php echo$r['id'];?>" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php echo($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="active" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Active</label>
            </div>
            <div class="form-group">
              <label for="rank">Access</label>
              <div class="input-group">
                <select id="rank" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','rank',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="rank"<?php echo$user['options'][5]==1?'':' disabled';?>>
                  <option value="0"<?php echo($r['rank']==0?' selected':'');?>>Visitor and above</option>
                  <option value="100"<?php echo($r['rank']==100?' selected':'');?>>Subscriber and above</option>
                  <option value="200"<?php echo($r['rank']==200?' selected':'');?>>Member and above</option>
                  <option value="300"<?php echo($r['rank']==300?' selected':'');?>>Client and above</option>
                  <option value="400"<?php echo($r['rank']==400?' selected':'');?>>Contributor and above</option>
                  <option value="500"<?php echo($r['rank']==500?' selected':'');?>>Author and above</option>
                  <option value="600"<?php echo($r['rank']==600?' selected':'');?>>Editor and above</option>
                  <option value="700"<?php echo($r['rank']==700?' selected':'');?>>Moderator and above</option>
                  <option value="800"<?php echo($r['rank']==800?' selected':'');?>>Manager and above</option>
                  <option value="900"<?php echo($r['rank']==900?' selected':'');?>>Administrator and above</option>
                </select>
              </div>
            </div>
<?php if($user['rank']==1000){?>
            <div class="form-group">
              <label for="contentType">contentType</label>
              <div class="input-group">
                <input type="text" id="contentType" class="form-control textinput" value="<?php echo$r['contentType'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="contentType" placeholder="">
                <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecontentType" class="btn btn-secondary save" data-dbid="contentType" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
<?php }?>
            <div class="form-group">
              <label for="url">URL Type</label>
              <div class="form-text small text-muted float-right">Leave Blank for auto-generated URL's. Enter a URL to link to another service. Or use <code class="click" style="cursor:pointer;" onclick="$('#url').val('#<?php echo$r['contentType'];?>');update('<?php echo$r['id'];?>','menu','url',$('#url').val());">#<?php echo$r['contentType'];?></code> to have menu item link to Anchor with same name on same page.</div>
              <div class="input-group">
                <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="url"<?php echo$user['options'][1]==1?'':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button id="saveurl" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="url" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }?>
            <div class="form-group">
              <label for="menu">Menu</label>
              <div class="input-group">
                <select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());"<?php echo$user['options'][1]==1?'':' disabled';?>>
                  <option value="head"<?php echo$r['menu']=='head'?' selected':'';?>>Head</option>
                  <option value="other"<?php echo$r['menu']=='other'?' selected':'';?>>Other</option>
                  <option value="footer"<?php echo$r['menu']=='footer'?' selected':'';?>>Footer</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="mid">SubMenu</label>
              <div class="input-group">
                <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','mid',$(this).val());"<?php echo$user['options'][1]==1?'':' disabled';?>>
                  <option value="0"<?php echo$r['mid']==0?' selected':'';?>>None</option>
<?php $sm=$db->prepare("SELECT id,title from `".$prefix."menu` WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");
$sm->execute([
  ':mid'=>$r['id']
]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';?>
                </select>
              </div>
            </div>
          </div>
<?php }?>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3 order-1 order-md-2">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">SEO Pre-Publish Checklist</h6>
          <div class="card-text">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist2" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="checklist" data-dbb="2"<?php echo$r['checklist'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist2">Formatting Done</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist3" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="checklist" data-dbb="3"<?php echo$r['checklist'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist3">Spelling and Grammar</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist6" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="checklist" data-dbb="6"<?php echo$r['checklist'][6]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist6">Adequate Reading Level</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist4" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="checklist" data-dbb="4"<?php echo$r['checklist'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist4">Image Added</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist5" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="checklist" data-dbb="5"<?php echo$r['checklist'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist5">SEO Checked</label>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Reading Stats</h6>
          <div class="card-text">
<?php
use DaveChild\TextStatistics as TS;
$textStatistics = new TS\TextStatistics;
$text = rawurldecode($r['notes']);
$gunScore = $textStatistics->gunningFogScore($text);
$gunText = $gunScore.' - ';
$gunScore = round($gunScore);
if($gunScore == 0 || $gunScore == 1 || $gunScore == 2 || $gunScore == 3 || $gunScore == 4 || $gunScore == 5) $gunText .= '5th Grade and Lower.';
if($gunScore == 6) $gunText .= '6th Grade.';
if($gunScore == 7) $gunText .= '7th Grade.';
if($gunScore == 8) $gunText .= '8th Grade.';
if($gunScore == 9) $gunText .= 'High School Early Years.';
if($gunScore == 10) $gunText .= 'High School Middle Years.';
if($gunScore == 11 || $gunScore == 12) $gunText .= 'High School Senior.';
if($gunScore == 13 || $gunScore == 14 || $gunScore == 15) $gunText .= 'College Junior.';
if($gunScore == 16) $gunText .= 'College Senior.';
if($gunScore == 17 || $gunScore == 18 || $gunScore == 19 || $gunScore == 20) $gunText .= 'Post Graduate.';
if($gunScore > 20) $gunText .= 'Post Graduate Plus.';?>
            <div class="form-group">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Words</div>
                </div>
                <input type="text" id="textWordCount" class="form-control" value="<?php echo DaveChild\TextStatistics\Text::wordCount($text);?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Sentences</div>
                </div>
                <input type="text" id="textSentences" class="form-control" value="<?php echo DaveChild\TextStatistics\Text::sentenceCount($text);?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <div class="input-group-text">Reading Level</div>
                </div>
                <input type="text" id="textReadingLevel" class="form-control" value="<?php echo$gunText;?>" readonly>
              </div>
            </div>
          </div>
          <div class="form-text text-muted small">Text Stats are updated when editor content is saved.</div>
        </div>
      </div>
    </div>
  </div>
</main>
