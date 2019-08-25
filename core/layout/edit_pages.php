<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE id=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active">
      <span id="titleupdate"><?php echo$r['title'];?></span>
<?php $so=$db->prepare("SELECT id,title FROM menu WHERE id!=:id ORDER BY ord ASC, title ASC");
$so->execute([
  ':id'=>$r['id']
]);
if($so->rowCount()>0){
      echo'<a class="btn btn-ghost-normal dropdown-toggle m-0 p-0 pl-2 pr-2 text-white" data-toggle="dropdown" href="'.URL.$settings['system']['admin'].'/pages'.'" aria-haspopup="true" aria-expanded="false"></a><div class="dropdown-menu">';
  while($ro=$so->fetch(PDO::FETCH_ASSOC)){
        echo'<a class="dropdown-item small pt-1 pb-1" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'">'.$ro['title'].'</a>';
  }
      echo'</div>';
}?>
    </li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-page-content" aria-controls="tab-page-content" role="tab" data-toggle="tab">Content</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-images" aria-controls="tab-page-images" role="tab" data-toggle="tab">Images</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-media" aria-controls="tab-page-media" role="tab" data-toggle="tab">Media</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-seo" aria-controls="tab-page-seo" role="tab" data-toggle="tab">SEO</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-settings" aria-controls="tab-page-settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-page-content" class="tab-pane active" role="tabpanel">
            <div class="form-group row">
              <label for="title" class="col-form-label col-sm-2">Title</label>
              <div class="input-group col-sm-10">
<?php           if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'title']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="title" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" placeholder="Enter a Title..." onkeyup="genurl();$('#titleupdate').text($(this).val());">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-secondary addsuggestion hidden-xs" data-dbgid="title" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
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
            <div class="form-group row">
              <label class="col-form-label col-sm-2">URL Slug</label>
              <div class="input-group col-sm-10">
                <div class="input-group-text text-truncate col-sm-12">
                  <a id="genurl" target="_blank" href="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>"><?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?></a>
                </div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">Edited: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
            <div class="form-group row">
              <div class="card-header col-12 position-relative p-0">
<?php           if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'notes']);
                  echo$ss->rowCount()>0?'<span data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary btn-sm suggestions" data-dbgid="notesda" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></span>':'';
                }
                echo$user['rank']>899?'<span class="d-flex justify-content-end" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary btn-sm addsuggestion" data-dbgid="notesda" aria-label="Add Suggestion">'.svg2('idea').'</button></span>':'';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="menu">
                  <input type="hidden" name="c" value="notes">
                  <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes" name="da" readonly><?php echo rawurldecode($r['notes']);?></textarea>
                </form>
              </div>
            </div>
          </div>
          <div id="tab-page-images" class="tab-pane" role="tabpanel">
            <fieldset class="control-fieldset">
              <legend class="control-legend">Cover</legend>
              <div class="form-group row">
                <label for="coverURL" class="col-form-label col-sm-2">URL</label>
                <div class="input-group col-sm-10">
                  <input type="text" id="coverURL" class="form-control image" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());" placeholder="Enter Cover URL...">
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverURL','');" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="cover" class="col-form-label col-sm-2">Image</label>
                <div class="input-group col-sm-10">
                  <input type="text" id="cover" class="form-control" name="feature_image" value="<?php echo$r['cover'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="cover" onchange="coverUpdate('<?php echo$r['id'];?>','menu','cover',$(this).val());" readonly>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','cover');" data-tooltip="tooltip" title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
                  <div class="input-group-append img">
                    <?php if($r['cover']!='')
                      echo'<a href="'.$r['cover'].'" data-fancybox="image"><img id="coverimage" class="bg-white" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
                    elseif($r['coverURL']!='')
                      echo'<a href="'.$r['coverURL'].'" data-fancybox="image"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                    elseif($r['coverURL'] != '')
                      echo'<a href="'.$r['coverURL'].'" data-fancybox="image"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                    else
                      echo'<img id="coverimage" class="bg-white" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';?>
                  </div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','cover','');" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-7" class="form-group row">
                <label for="exifFilename" class="col-form-label col-sm-2">Image ALT</label>
                <div class="input-group col-sm-10">
                  <input type="text" id="fileALT" class="form-control textinput" value="<?php echo$r['fileALT'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="fileALT" placeholder="Enter an Image ALT">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savefileALT" class="btn btn-secondary save" data-dbid="fileALT" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="coverVideo" class="col-form-label col-sm-2">Video URL</label>
                <div class="input-group col-sm-10">
                  <input type="text" id="coverVideo" class="form-control" name="feature_image" value="<?php echo$r['coverVideo'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" readonly>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','coverVideo');" data-tooltip="tooltip" title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverVideo','');" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button></div>
                </div>
              </div>
            </fieldset>
            <fieldset class="control-fieldset">
              <legend class="control-legend" role="heading">Image Attribution</legend>
              <div class="form-group row">
                <label for="attributionImageTitle" class="col-form-label col-sm-2">Title</label>
                <div class="input-group col-sm-10">
                  <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageTitle" class="btn btn-secondary save" data-dbid="attributionImageTitle" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="attributionImageName" class="col-form-label col-sm-2">Name</label>
                <div class="input-group col-sm-10">
                  <input type="text" id="attributionImageName" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" placeholder="Enter a Name...">
                  <datalist id="attributionImageTitle_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionImageTitle AS name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageName" class="btn btn-secondary save" data-dbid="attributionImageName" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="attributionImageURL" class="col-form-label col-sm-2">URL</label>
                <div class="input-group col-sm-10">
                  <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" placeholder="Enter a URL...">
                  <datalist id="attributionImageURL_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY url ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageURL" class="btn btn-secondary save" data-dbid="attributionImageURL" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
                </div>
              </div>
            </fieldset>
          </div>
          <div id="tab-page-media" class="tab-pane" role="tabpanel">
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <input type="hidden" name="act" value="add_media">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="pages">
              <div class="form-group">
                <div class="input-group">
                  <input id="file" type="text" class="form-control" name="fu" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','media','file');return false;" data-tooltip="tooltip" title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
                  <div class="input-group-append"><button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" title="Add" aria-label="Add"><?php svg('add');?></button></div>
                </div>
              </div>
            </form>
            <div class="container">
              <div id="mi" class="row">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND rid=0 AND pid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
if($sm->rowCount()>0){
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
    if(file_exists('media/thumbs/'.substr(basename($rm['file']),0,-4).'.png'))
      $thumb='media/thumbs/'.substr(basename($rm['file']),0,-4).'.png';
    else
      $thumb=$rm['file'];?>
                <div id="mi_<?php echo$rm['id'];?>" class="media-gallery d-inline-block col-6 col-sm-2 position-relative p-0 m-1 mt-0">
                  <a class="card bg-dark m-0" href="<?php echo$rm['file'];?>" data-fancybox="media">
                    <img src="<?php echo$thumb;?>" class="card-img" alt="Media <?php echo$rm['id'];?>">
                  </a>
                  <div class="btn-group float-right">
                    <div class="handle btn btn-secondary btn-sm" data-tooltip="tooltip" title="Drag to ReOrder this item" aria-label="Drag to ReOrder this item"><?php svg('drag');?></div>
                    <button class="btn btn-secondary trash btn-sm" onclick="purge('<?php echo$rm['id'];?>','media')" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                  </div>
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
          <div id="tab-page-seo" class="tab-pane" role="tabpanel">
            <div class="form-group row">
              <label for="views" class="col-form-label col-sm-2">Views</label>
              <div class="input-group col-sm-10">
                <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views">
                <div class="input-group-addon"><button class="btn btn-secondary trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','menu','views','0');" data-tooltip="tooltip" title="Clear" aria-label="Clear"><?php svg('eraser');?></button></div>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveviews" class="btn btn-secondary save" data-dbid="views" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">Options for Meta Robots: <span data-tooltip="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="tooltip" title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="tooltip" title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="tooltip" title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
            <div class="form-group row">
              <label for="metaRobots" class="col-form-label col-sm-2">Meta Robots</label>
              <div class="input-group col-sm-10">
                <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" placeholder="Enter a Meta Robots Options...">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-form-label col-sm-2"></div>
              <div class="input-group col-sm-10">
                <div class="card col-12 bg-white">
                  <div class="card-body">
                    <div id="google-title" data-tooltip="tooltip" data-placement="left" title="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
<?php if($r['seoTitle']!='')
  echo$r['seoTitle'];
else
  echo$r['title'].' - '.$config['business'];?>
                    </div>
                    <div id="google-link">
<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>
                    </div>
                    <div id="google-description" data-tooltip="tooltip" data-placement="left" title="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
<?php if($r['seoDescription']!='')
  echo$r['seoDescription'];
else
  echo$config['seoDescription'];?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Title's is 70.</div>
            <div class="form-group row">
              <label for="seoTitle" class="col-form-label col-sm-2">Meta Title</label>
              <div class="input-group col-sm-10">
<?php $cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend"><span id="seoTitlecnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <div class="input-group-prepend"><button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="Remove Stop Words" aria-label="Remove Stop Words"><?php svg('magic');?></button></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoTitle']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoTitle" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter a Meta Title...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoTitle" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Captions is 100.</div>
            <div class="form-group row">
              <label for="seoCaption" class="col-form-label col-sm-2">Meta Caption</label>
              <div class="input-group col-sm-10">
<?php $cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend"><span id="seoCaptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoCaption']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoCaption" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Meta Caption...">
                <?php echo$user['rank']>899?'<div class="input-group-btn" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoCaption" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Descriptions is 160.</div>
            <div class="form-group row">
              <label for="seoDescription" class="col-form-label col-sm-2">Meta Description</label>
              <div class="input-group col-sm-10">
<?php $cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend"><span id="seoDescriptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoDescription']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoDescription" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Meta Description...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoDescription" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="seoKeywords" class="col-form-label col-sm-2">Meta Keywords</label>
              <div class="input-group col-sm-10">
<?php           if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoKewords']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoKeywords" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Meta Keywords...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoKeywords" aria-label="Add Suggestion">'.svg2('idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
          </div>
          <div id="tab-page-settings" class="tab-pane" role="tabpanel">
<?php if($r['contentType']!='index'){?>
            <div class="form-group row">
              <label for="active" class="col-form-label col-sm-2">Active</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="active<?php echo$r['id'];?>" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" role="checkbox"<?php echo$r['active']==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
<?php if($user['rank']==1000){?>
            <div class="form-group row">
              <label for="seoKeywords" class="col-form-label col-sm-2">contentType</label>
              <div class="input-group col-sm-10">
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['contentType'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="contentType" placeholder="">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecontentType" class="btn btn-secondary save" data-dbid="contentType" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
<?php }?>
            <div class="help-block small text-muted text-right">Leave Blank for auto-generated URL's. Enter a URL to link to another service. Or use <code class="click" style="cursor:pointer;" onclick="$('#url').val('#<?php echo$r['contentType'];?>');update('<?php echo$r['id'];?>','menu','url',$('#url').val());pace.start();">#<?php echo$r['contentType'];?></code> to have menu item link to Anchor with same name on same page.</div>
            <div class="form-group row">
              <label for="url" class="col-form-label col-sm-2">URL Type</label>
              <div class="input-group col-sm-10">
                <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="url" placeholder="">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveurl" class="btn btn-secondary save" data-dbid="url" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
<?php }?>
            <div class="form-group row">
              <label for="menu" class="col-form-label col-sm-2">Menu</label>
              <div class="input-group col-sm-10">
                <select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());">
                  <option value="head"<?php echo$r['menu']=='head'?' selected':'';?>>Head</option>
                  <option value="other"<?php echo$r['menu']=='other'?' selected':'';?>>Other</option>
                  <option value="footer"<?php echo$r['menu']=='footer'?' selected':'';?>>Footer</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="mid" class="col-form-label col-sm-2">SubMenu</label>
              <div class="input-group col-sm-10">
                <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','mid','menu',$(this).val());">
                  <option value="0"<?php echo$r['mid']==0?' selected':'';?>>None</option>
<?php $sm=$db->prepare("SELECT id,title from `".$prefix."menu` WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");
$sm->execute([':mid'=>$r['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
