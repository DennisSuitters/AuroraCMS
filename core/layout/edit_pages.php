<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `id`=:id");
$s->execute([
  ':id'=>$args[1]
]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('users','i-3x');?></div>
          <div>Edit Account <?php echo$r['username'];?>:<?php echo$r['name'];?></div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?php svg('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
          <li class="breadcrumb-item active"><?php echo$user['options'][1]==1?'Edit':'View';?></li>
          <li class="breadcrumb-item active"><span id="titleupdate"><?php echo$r['title'];?></span></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="tabs" role="tablist">
          <input id="tab1-1" class="tab-control" name="tabs" type="radio" checked>
          <label for="tab1-1">Content</label>
          <input id="tab1-2" class="tab-control" name="tabs" type="radio">
          <label for="tab1-2">Images</label>
          <?php echo$r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'?'<input id="tab1-3" class="tab-control" name="tabs" type="radio"><label for="tab1-3">Media</label>':'';?>
          <input id="tab1-4" class="tab-control" name="tabs" type="radio">
          <label for="tab1-4">SEO</label>
          <?php echo$r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'?'<input id="tab1-5" class="tab-control" name="tabs" type="radio"><label for="tab1-5">Settings</label>':'';?>
<?php /* Content */ ?>
          <div class="tab1-1 border-top p-3" role="tabpanel">
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label for="title">Title</label>
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
                <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title" data-tooltip="tooltip" aria-label="SEO Title Information"><?php svg('seo');?></button>
                <input class="textinput" id="title" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" type="text" value="<?php echo$r['title'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?> onkeyup="genurl();$('#titleupdate').text($(this).val());">
                <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=title" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
                '<button class="save" id="savetitle" data-tooltip="tooltip" data-dbid="title" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'');?>"+data.replace(/ /g,"-");
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                }
              </script>
              <label for="genurl">URL Slug</label>
              <div class="form-row">
                <div class="input-text col-12">
                  <a id="genurl" target="_blank" href="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>"><?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?></a>
                </div>
              </div>
            <?php }?>
            <div class="row mt-3">
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
                echo'<button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=content" data-type="content" data-tooltip="tooltip" aria-label="SEO Content Information">'.svg2('seo').'</button>'.
                    '<button data-tooltip="tooltip" aria-label="Show Element Blocks" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;">'.svg2('blocks').'</button>'.
                    '<input class="col-1" id="ipsumc" value="5">'.
                    '<button data-tooltip="tooltip" aria-label="Add Aussie Lorem Ipsum" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;">'.svg2('loremipsum').'</button>'.
                    '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=notes" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
                  '</div>'.
                '</div>';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                <form id="summernote" method="post" target="sp" action="core/update.php" enctype="multipart/form-data">
                  <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                  <input name="t" type="hidden" value="menu">
                  <input name="c" type="hidden" value="notes">
                  <textarea class="summernote" id="notes" name="da" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"><?php echo rawurldecode($r['notes']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-editable">
                        <?php echo rawurldecode($r['notes']);?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
            <div class="form-row">
              <small class="form-text">Edited: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></small>
            </div>
          </div>
<?php /* Images */ ?>
          <div class="tab1-2 border-top p-3" role="tabpanel">
            <legend class="mt-3">Cover</legend>
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label for="coverURL">URL</label>
              <div class="form-row">
                <input class="image" id="coverURL" type="text" value="<?php echo$r['coverURL'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter Cover URL..."':' readonly';?> onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());">
                <?php echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverURL`,``);">'.svg2('trash').'</button>':'';?>
              </div>
            <?php }?>
            <label for="cover">Image</label>
            <div class="form-row">
              <input id="cover" name="feature_image" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="cover" type="text" value="<?php echo$r['cover'];?>" readonly onchange="coverUpdate('<?php echo$r['id'];?>','menu','cover',$(this).val());">
              <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`cover`);">'.svg2('browse-media').'</button>':'';
              if($r['cover']!='')
                echo'<a data-fancybox="cover" data-type="image" href="'.$r['cover'].'"><img class="bg-white" id="coverimage" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL']!='')
                echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              elseif($r['coverURL'] != '')
                echo'<a data-fslightbox="cover" data-type="image" href="'.$r['coverURL'].'"><img class="bg-white" id="coverimage" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
              else
                echo'<img id="coverimage" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';
              echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`cover`,``);">'.svg2('trash').'</button>':'';?>
            </div>
            <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
              <label for="exifFilename">Image ALT</label>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><?php svg('seo');?></button>
                <input class="textinput" id="fileALT" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="fileALT" type="text" value="<?php echo$r['fileALT'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an Image ALT Test..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="savefileALT" data-tooltip="tooltip" data-dbid="fileALT" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="coverVideo">Video URL</label>
              <div class="form-row">
                <input id="coverVideo" name="feature_image" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" type="text" value="<?php echo$r['coverVideo'];?>">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`menu`,`coverVideo`);">'.svg2('browse-media').'</button>'.
                '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`menu`,`coverVideo`,``);">'.svg2('trash').'</button>':'';?>
                <?php echo$user['options'][1]==1?'<button class="save" id="savecoverVideo" data-tooltip="tooltip" data-dbid="coverVideo" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <div class="row mt-3">
                <input id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="0" type="checkbox"<?php echo$r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="options0">AutoPlay Cover Video</label>
              </div>
              <div class="row">
                <input id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="1" type="checkbox"<?php echo$r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="options1">Loop Cover Video</label>
              </div>
              <div class="row">
                <input id="options2" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="options" data-dbb="2" type="checkbox"<?php echo$r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="options2">Show Controls</label>
              </div>
              <legend class="mt-3">Image Attribution</legend>
              <label for="attributionImageTitle">Title</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageTitle" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" type="text" value="<?php echo$r['attributionImageTitle'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveattributionImageTitle" data-tooltip="tooltip" data-dbid="attributionImageTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="attributionImageName">Name</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageName" list="attributionImageTitle_option" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" type="text" value="<?php echo$r['attributionImageName'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
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
              <label for="attributionImageURL">URL</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" type="text" value="<?php echo$r['attributionImageURL'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
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
<?php /* Media */ ?>
          <?php if($r['contentType']!='comingsoon'&&$r['contentType']!='maintenance'){?>
            <div class="tab1-3 border-top p-3" role="tabpanel">
              <?php if($user['options'][1]==1){?>
                <form class="form-row" target="sp" method="post" action="core/add_media.php" enctype="multipart/form-data">
                  <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                  <input name="rid" type="hidden" value="0">
                  <input name="t" type="hidden" value="pages">
                  <input id="mediafile" name="fu" type="text" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                  <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?php echo$r['id'];?>','media','mediafile');return false;"><?php svg('browse-media');?></button>
                  <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?php svg('add');?></button>
                </form>
              <?php }?>
              <div class="row mt-3" id="mi">
                <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `rid`=0 AND `pid`=:id ORDER BY `ord` ASC");
                $sm->execute([
                  ':id'=>$r['id']
                ]);
                if($sm->rowCount()>0){
                  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                    if(file_exists('media'.DS.'sm'.DS.basename($rm['file'])))
                      $thumb='media'.DS.'sm'.DS.basename($rm['file']);
                    else
                      $thumb=ADMINNOIMAGE;?>
                    <div class="card stats col-6 col-md-3 m-1" id="mi_<?php echo$rm['id'];?>">
                      <?php if($user['options'][1]==1){?>
                        <div class="btn-group float-right">
                          <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item"><?php svg('drag');?></div>
                          <div class="btn" data-tooltip="tooltip" aria-label="Viewed <?php echo$rm['views'];?> times"><small><?php echo$rm['views'];?></small></div>
                          <a class="btn" href="<?php echo URL.$settings['system']['admin'].'/media/edit/'.$rm['id'];?>" data-tooltip="tooltip" role="button" aria-label="Edit"><?php svg('edit');?></a>
                          <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?php echo$rm['id'];?>`,`media`);"><?php svg('trash');?></button>
                        </div>
                      <?php }?>
                      <a data-fancybox data-type="image" data-caption="<?php echo($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?php echo$rm['file'];?>">
                        <img src="<?php echo$thumb;?>" alt="Media <?php echo$rm['id'];?>">
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
          <?php }?>
<?php /* SEO */ ?>
          <div class="tab1-4 border-top p-3" role="tabpanel">
            <label for="views">Views</label>
            <div class="form-row">
              <input class="textinput" id="views" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views" type="number" value="<?php echo$r['views'];?>"<?php echo$user['options'][1]==1?'':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`menu`,`views`,`0`);">'.svg2('eraser').'</button>'.
              '<button class="save" id="saveviews" data-tooltip="tooltip" data-dbid="views" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label for="metaRobots">Meta&nbsp;Robots</label>
              <small class="form-text text-right">Options for Meta Robots: <span data-tooltip="left" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metarobots" data-tooltip="tooltip" aria-label="SEO Meta Robots Information"><?php svg('seo');?></button>
              <input class="textinput" id="metaRobots" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" type="text" value="<?php echo$r['metaRobots'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button class="save" id="savemetaRobots" data-tooltip="tooltip" data-dbid="metaRobots" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="card google-result mt-3 p-3 overflow-visible">
              <div id="google-title" data-tooltip="left" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                <?php echo$r['seoTitle'].' | '.$config['business'];?>
              </div>
              <div id="google-link">
                <?php echo URL;?>
              </div>
              <div id="google-description" data-tooltip="left" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                <?php echo$r['seoDescription'];?>
              </div>
            </div>
            <div class="form-row mt-3">
              <label for="seoTitle">Meta&nbsp;Title</label>
              <small class="form-text text-right">The recommended character count for Title's is 70.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title" data-tooltip="tooltip" aria-label="SEO Title Information"><?php svg('seo');?></button>
              <?php $cntc=70-strlen($r['seoTitle']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text text-success<?php echo$cnt<0?' text-danger':'';?>" id="seoTitlecnt"><?php echo$cnt;?></div>
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
              <input class="textinput" id="seoTitle" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" type="text" value="<?php echo$r['seoTitle'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Title..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoTitle" data-tooltip="tooltip" data-aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoTitle" data-tooltip="tooltip" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label for="seoCaption">Meta&nbsp;Caption</label>
              <small class="form-text text-right">The recommended character count for Captions is 100.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metacaption" data-tooltip="tooltip" aria-label="SEO Meta Caption Information"><?php svg('seo');?></button>
              <?php $cntc=100-strlen($r['seoCaption']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text text-success<?php echo$cnt<0?' text-danger':'';?>" id="seoCaptioncnt"><?php echo$cnt;?></div>
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoCaption']);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoCaption" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <input class="textinput" id="seoCaption" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" type="text" value="<?php echo$r['seoCaption'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Caption..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoCaption" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoCaption" data-tooltip="tooltip" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label for="seoDescription">Meta&nbsp;Description</label>
              <small class="form-text text-right">The recommended character count for Descriptions is 160.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metadescription" data-tooltip="tooltip" aria-label="SEO Meta Description Information"><?php svg('seo');?></button>
              <?php $cntc=160-strlen($r['seoDescription']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text text-success<?php echo$cnt<0?' text-danger':'';?>" id="seoDescriptioncnt"><?php echo$cnt;?></div>
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'menu',
                  ':c'=>'seoDescription'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoDescription" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <input class="textinput" id="seoDescription" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" type="text" value="<?php echo$r['seoDescription'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Description..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout.suggestions-add.php?id='.$r['id'].'&t=menu&c=seoDescription" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoDescription" data-tooltip="tooltip" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label for="seoKeywords">Meta&nbsp;Keywords</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=keywords" data-tooltip="tooltip" aria-label="SEO Keywords Information"><?php svg('seo');?></button>
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'menu',
                  ':c'=>'seoKewords'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=menu&c=seoKeywords" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <input class="textinput" id="seoKeywords" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" type="text" value="<?php echo$r['seoKeywords'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter Meta Keywords..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=menu&c=seoKeywords" data-tooltip="tooltip" data-aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoKeywords" data-tooltip="tooltip" data-dbid="seoKeywords" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
<?php /* Settings */ ?>
          <?php if($r['contentType']!='comingsoon'&&['contentType']!='maintenance'){?>
            <div class="tab1-5 border-top p-3" role="tabpanel">
              <?php if($r['contentType']!='index'){?>
                <div class="row mt-3">
                  <input id="active<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"<?php echo($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="active">Active</label>
                </div>
                <label for="rank">Access</label>
                <div class="form-row">
                  <select id="rank" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="rank" onchange="update('<?php echo$r['id'];?>','menu','rank',$(this).val());"<?php echo$user['options'][5]==1?'':' disabled';?>>
                    <option value="0"<?php echo($r['rank']==0?' selected':'');?>>Available to Everyone</option>
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
                <?php if($user['rank']==1000){?>
                  <label for="contentType">contentType</label>
                  <div class="form-row">
                    <input class="textinput" id="contentType" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="contentType" type="text" value="<?php echo$r['contentType'];?>" placeholder="">
                    <button class="save" id="savecontentType" data-dbid="contentType" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?php svg('save');?></button>
                  </div>
                <?php }?>
                <div class="form-row mt-3">
                  <label for="url">URL&nbsp;Type</label>
                  <small class="form-text text-right">Leave Blank for auto-generated URL's. Enter a URL to link to another service. Or use <code class="click" style="cursor:pointer;" onclick="$('#url').val('#<?php echo$r['contentType'];?>');update('<?php echo$r['id'];?>','menu','url',$('#url').val());"><small>#<?php echo$r['contentType'];?></small></code> to link to Anchor on same page.</small>
                </div>
                <div class="form-row">
                  <input class="textinput" id="url" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="url" type="text" value="<?php echo$r['url'];?>"<?php echo$user['options'][1]==1?'':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<button class="save" id="saveurl" data-tooltip="tooltip" data-dbid="url" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              <?php }?>
              <div class="row">
                <div class="col-12 col-md-6 pr-md-1">
                  <label for="menu">Menu</label>
                  <div class="form-row">
                    <select id="menu"<?php echo$user['options'][1]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());">
                      <option value="head"<?php echo$r['menu']=='head'?' selected':'';?>>Head</option>
                      <option value="other"<?php echo$r['menu']=='other'?' selected':'';?>>Other</option>
                      <option value="footer"<?php echo$r['menu']=='footer'?' selected':'';?>>Footer</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-6 pl-md-1">
                  <label for="mid">SubMenu</label>
                  <div class="form-row">
                    <select id="mid"<?php echo$user['options'][1]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','menu','mid',$(this).val());">
                      <option value="0"<?php echo$r['mid']==0?' selected':'';?>>None</option>
                      <?php $sm=$db->prepare("SELECT `id`,`title` from `".$prefix."menu` WHERE `mid`=0 AND `mid`!=:mid AND `active`=1 ORDER BY `ord` ASC, `title` ASC");
                      $sm->execute([
                        ':mid'=>$r['id']
                      ]);
                      if($sm->rowCount()>0){
                        while($rm=$sm->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';
                      }?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
