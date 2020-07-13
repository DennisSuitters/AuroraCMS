<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content - Edit
 * @package    core/layout/edit_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.17
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.3 Add Permissions Options.
 * @changes    v0.0.3 Add AutoPublish Options to Status.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.7 Add Editing of RRP and Reduced Cost options.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.12 Fix Save Button for Image and Thumbnail selection not showing unsaved changes.
 * @changes    v0.0.12 Add Options for using Panoramic Photo's.
 * @changes    v0.0.12 Fix Multiple Media Adding.
 * @changes    v0.0.13 Add Lorem Ipsum Generator for Administrators.
 * @changes    v0.0.15 Add Display Block Elements in Editor Button.
 * @changes    v0.0.15 Add Check to Current Item in Dropdown.
 * @changes    v0.0.15 Add SEO Pre-Publish Checklist.
 * @changes    v0.0.15 Add Add Content Button next to back button for quickly adding next content item.
 * @changes    v0.0.15 Fix truncating file extensions for 3 or 4 character length extensions.
 * @changes    v0.0.15 Add Edit Media information button.
 * @changes    v0.0.15 Add Weight and Size Fields for Postage Calculation.
 * @changes    v0.0.16 Change Brand Textbox to Select Box to choose Brand from added options.
 * @changes    v0.0.16 Add Condition Option.
 * @changes    v0.0.17 Add Access levels for content.
 * @changes    v0.0.17 Add better options for Videos.
 * @changes    v0.0.17 Add SEO Helper buttons.
 */
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content/type/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']).(in_array($r['contentType'],array('article'))?'s':'');?></a></li>
    <li class="breadcrumb-item"><?php echo$user['options'][1]==1?'Edit':'View';?></li>
    <li class="breadcrumb-item active">
      <span id="titleupdate"><?php echo$r['title'];?></span>
<?php $so=$db->prepare("SELECT id,title,active,ord FROM `".$prefix."content` WHERE lower(contentType) LIKE lower(:contentType) ORDER BY title ASC");
$so->execute([':contentType'=>$r['contentType']]);
if($so->rowCount()>0){
      echo'<a class="btn btn-ghost-normal dropdown-toggle m-0 p-0 pl-2 pr-2 text-white" data-toggle="dropdown" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'" role="button" aria-label="Quick Content Selection" aria-haspopup="true" aria-expanded="false"></a><div class="dropdown-menu">';
      while($ro=$so->fetch(PDO::FETCH_ASSOC))echo'<a class="dropdown-item small pt-1 pb-1 text-white'.($ro['id']==$r['id']?' active':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$ro['id'].'">'.($ro['id']==$r['id']?'&check;&nbsp;':'&nbsp;&nbsp;&nbsp;').$ro['title'].'</a>';
      echo'</div>';
}?>
    </li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/add/'.$r['contentType'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" role="button" aria-label="Back"><?php svg('back');?></a>
        <?php echo$user['options'][0]==1?'<a class="btn btn-ghost-normal add" href="'.URL.$settings['system']['admin'].'/add/'.$r['contentType'].'" data-tooltip="tooltip" data-placement="left" data-title="Add '.ucfirst($r['contentType']).'" role="button" aria-label="Add">'.svg2('add').'</a>':'';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid row">
    <div class="card col-12 col-md-9 order-2 order-md-1">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-content-content" class="nav-item" role="presentation">
            <a class="nav-link active" href="#tab-content-content" aria-controls="tab-content-content" role="tab" data-toggle="tab">Content</a>
          </li>
          <li id="nav-content-images" class="nav-item" role="presentation">
            <a class="nav-link" href="#tab-content-images" aria-controls="tab-content-images" role="tab" data-toggle="tab">Images</a>
          </li>
          <?php echo$r['contentType']!='testimonials'?'<li id="nav-content-media" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-media" aria-controls="tab-content-media" role="tab" data-toggle="tab">Media</a></li>':'';
          echo$r['contentType']=='inventory'?'<li id="nav-content-options" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-options" aria-controls="tab-content-options" role="tab" data-toggle="tab">Options</a></li>':'';
          echo$r['contentType']=='article'?'<li id="nav-content-comments" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-comments" aria-controls="tab-content-comments" role="tab" data-toggle="tab">Comments</a></li>':'';
          echo$r['contentType']=='inventory'||$r['contentType']=='service'?'<li id="nav-content-reviews" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-reviews" aria-controls="tab-content-reviews" role="tab" data-toggle="tab">Reviews</a></li>':'';
          echo$r['contentType']=='article'||$r['contentType']=='inventory'||$r['contentType']=='service'?'<li id="nav-content-related" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-related" aria-controls="tab-content-related" role="tab" data-toggle="tab">Related</a></li>':'';
          echo$r['contentType']!='testimonials'&&$r['contentType']!='proofs'?'<li id="nav-content-seo" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-seo" aria-controls="tab-content-seo" role="tab" data-toggle="tab">SEO</a></li>':'';?>
          <li id="nav-content-settings" class="nav-item" role="presentation">
            <a class="nav-link" href="#tab-content-settings" aria-controls="tab-content-settings" role="tab" data-toggle="tab">Settings</a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="tab-content-content" class="tab-pane active" role="tabpanel">
            <?php echo$user['options'][1]==1?'<div class="help-block small text-muted text-right">Content MUST contain a Title, to be able to generate a URL Slug or the content won\'t be accessible.</div>':'';?>
            <div id="nav-content-content-1" class="form-group row">
              <label for="title" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Title</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'title']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" data-title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="title" role="button" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                }?>
                <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Title Information"><button class="btn btn-secondary seohelper" data-type="title" aria-label="SEO Title Information"><?php svg('seo');?></button></div>
                <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="btn-danger" onkeyup="genurl();$('#titleupdate').text($(this).val());"<?php echo$user['options'][1]==1?' placeholder="Content MUST contain a Title, to be able to generate a URL Slug or the content won\'t be accessible...."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary" onclick="ipsuMe(`title`);genurl();$(`#titleupdate`).text($(`#title`).val());$(`#savetitle`).addClass(`btn-danger`);return false;">'.svg2('loremipsum').'</button></div><div class="input-group-btn" data-tooltip="tooltip" data-title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="title" aria-label="Add Suggestion">'.svg2('idea').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in" role="button" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?php echo URL.$r['contentType'];?>/"+slugify(data);
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                  $('#google-link').text(url);
                }
                function slugify(str){
                  str=str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g,' ').toLowerCase();
                  str=str.replace(/^\s+|\s+$/gm,'');
                  str=str.replace(/\s+/g,'-');
                  return str;
                }
              </script>
            </div>
            <div id="nav-content-content-2" class="form-group row">
              <label class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">URL Slug</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-text text-truncate col-sm-12">
                  <a id="genurl" target="_blank" href="<?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?>"><?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?></a>
                </div>
              </div>
            </div>
            <div id="nav-content-content-3" class="form-group row">
              <label for="ti" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Created</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
              </div>
            </div>
            <div id="nav-content-content-4" class="form-group row">
              <label for="pti" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Published On</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="pti" class="form-control textinput" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="pti" value="<?php echo date('M n, Y g:i A',$r['pti']);?>"<?php echo$user['options'][1]==1?'':' readonly';?>>
                <input type="hidden" id="ptix" value="<?php echo$r['pti'];?>">
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savepti" class="btn btn-secondary save" data-dbid="pti" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div id="nav-content-content-5" class="form-group row">
              <label for="eti" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Edited</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="eti" class="form-control" value="<?php echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>" readonly>
              </div>
            </div>
<?php if($r['contentType']=='proofs'){?>
            <div id="nav-content-content-6" class="form-group row">
              <label for="cid" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Client</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="cid" class="form-control"<?php echo$user['options']{1}==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','cid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid"<?php echo$user['options'][1]==1?'':' disabled';?>>
                  <option value="0">Select a Client</option>
                  <?php $cs=$db->query("SELECT * FROM `".$prefix."login` ORDER BY name ASC, username ASC");while($cr=$cs->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$cr['id'].'"'.($r['cid']==$cr['id']?' selected':'').'>'.$cr['username'].':'.$cr['name'].'</option>';?>
                </select>
              </div>
            </div>
<?php }?>
            <div id="nav-content-content-7" class="form-group row">
              <label for="author" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Author</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="uid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="uid"<?php echo$user['options'][1]==1?'':' disabled';?>>
                  <?php $su=$db->query("SELECT id,username,name FROM `".$prefix."login` WHERE username!='' AND status!='delete' ORDER BY username ASC, name ASC");while($ru=$su->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$ru['id'].'"'.($ru['id']==$r['uid']?' selected':'').'>'.$ru['username'].':'.$ru['name'].'</option>';?>
                </select>
              </div>
            </div>
<?php if($r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-8" class="form-group row">
              <label for="code" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Code</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="code" class="form-control textinput" value="<?php echo$r['code'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code"<?php echo$user['options'][1]==1?' placeholder="Enter a Code..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecode" class="btn btn-secondary save" data-dbid="code" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='inventory'){?>
            <div id="nav-content-content-9" class="form-group row">
              <label for="barcode" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Barcode</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="barcode" class="form-control textinput" value="<?php echo$r['barcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="barcode"<?php echo$user['options'][1]==1?' placeholder="Enter a Barcode..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savebarcode" class="btn btn-secondary save" data-dbid="barcode" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='inventory'){?>
            <?php echo$user['options'][1]==1?'<div class="help-block small text-muted text-right"><a target="_blank" href="https://fccid.io/">fccid.io</a> for more information or to look up an FCC ID.</div>':'';?>
            <div id="nav-content-content-10" class="form-group row">
              <label for="fccid" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">FCCID</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="fccid" class="form-control textinput" value="<?php echo$r['fccid'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fccid"<?php echo$user['options'][1]==1?' placeholder="Enter an FCCID..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savefccid" class="btn btn-secondary save" data-dbid="fccid" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='inventory'){?>
            <div id="nav-content-content-11" class="form-group row">
              <label for="brand" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Brand</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="brand" class="form-control" onchange="update('<?php echo$r['id'];?>','content','brand',$(this).val());" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="brand"<?php echo$user['options'][1]==1?'':' disabled';?>>
                  <option value="">None</option>
<?php $s=$db->query("SELECT id,title FROM `".$prefix."choices` WHERE contentType='brand' ORDER BY title ASC");
if($s->rowCount()>0){
  while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['brand']?' selected':'').'>'.$rs['title'].'</option>';
}?>
                </select>
              </div>
            </div>
<?php }
if($r['contentType']=='event'){?>
            <div id="nav-content-content-12" class="form-group row">
              <label for="tis" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Event Start</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <?php echo$user['options'][1]==1?'<input type="text" id="tis" class="form-control" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="tis" data-datetime="'.date($config['dateFormat'],$r['tis']).'" autocomplete="off"><input type="hidden" id="tisx" value="'.$r['tis'].'"><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savetis" class="btn btn-secondary save" data-dbid="tis" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'<input type="text" class="form-control" value="'.date($config['dateFormat'],$r['tis']).'" readonly>';?>
              </div>
            </div>
<?php }
if($r['contentType']=='event'){?>
            <div id="nav-content-content-13" class="form-group row">
              <label for="tie" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Event End</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <?php echo$user['options'][1]==1?'<input type="text" id="tie" class="form-control" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="tie" data-datetime="'.date($config['dateFormat'],$r['tie']).'" autocomplete="off"><input type="hidden" id="tiex" value="'.$r['tie'].'"><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savetie" class="btn btn-secondary save" data-dbid="tie" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'<input type="text" class="form-control" value="'.date($config['dateFormat'],$r['tie']).'" readonly>';?>
              </div>
            </div>
<?php }
echo$r['ip']!=''?'<div class="help-block small text-right">'.$r['ip'].'</div>':'';
if($r['contentType']=='testimonials'){?>
            <div id="nav-content-content-14" class="form-group row">
              <label for="email" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Email</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email"<?php echo$user['options'][1]==1?' placeholder="Enter an Email..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='testimonials'){?>
            <div id="nav-content-content-15" class="form-group row">
              <label for="name" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Name</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="name" list="name_options" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
<?php if($user['options'][1]==1){
  $s=$db->query("SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");
  if($s->rowCount()>0){
    echo'<datalist id="name_options">';
    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
    echo'</datalist>';
  }
  echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
              </div>
            </div>
<?php }
if($r['contentType']=='testimonials'){?>
            <div id="nav-content-content-16" class="form-group row">
              <label for="url" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">URL</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveurl" class="btn btn-secondary save" data-dbid="url" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='testimonials'){?>
            <div id="nav-content-content-17" class="form-group row">
              <label for="business" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Business</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business"<?php echo$user['options'][1]==1?' placeholder="Enter a Business..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='event'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-18" class="form-group row">
              <label for="category_1" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category One</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1"<?php echo$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
<?php if($user['options'][1]==1){
  echo'<datalist id="category_1_options">';
  $sc=$db->prepare("SELECT DISTINCT title FROM `".$prefix."choices` WHERE title!='' AND contentType='category' AND url=:url ORDER BY title ASC");
  $sc->execute([':url'=>$r['contentType']]);
  if($sc->rowCount()>0){
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['title'].'"/>';
  }
  $sc=$db->query("SELECT DISTINCT category_1 FROM `".$prefix."content` WHERE category_1!='' ORDER BY category_1 ASC");
  if($sc->rowCount()>0){
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
  }
  echo'</datalist>';
                echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_1" class="btn btn-secondary save" data-dbid="category_1" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
              </div>
            </div>
<?php }
if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='event'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-19" class="form-group row">
              <label for="category_2" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category Two</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
<?php if($user['options'][1]==1){
  $sc=$db->query("SELECT DISTINCT category_2 FROM `".$prefix."content` WHERE category_2!='' ORDER BY category_2 ASC");
  if($sc->rowCount()>0){
    echo'<datalist id="category_2_options">';
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_2'].'"/>';
    echo'</datalist>';
  }
                echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_2" class="btn btn-secondary save" data-dbid="category_2" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
              </div>
            </div>
<?php }
if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='event'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-20" class="form-group row">
              <label for="category_3" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category Three</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input id="category_3" list="category_3_options" type="text" class="form-control textinput" value="<?php echo$r['category_3'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_3"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
<?php if($user['options'][1]==1){
  $sc=$db->query("SELECT DISTINCT category_3 FROM `".$prefix."content` WHERE category_3!='' ORDER BY category_3 ASC");
  if($sc->rowCount()>0){
    echo'<datalist id="category_3_options">';
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_3'].'"/>';
    echo'</datalist>';
  }
                echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_3" class="btn btn-secondary save" data-dbid="category_3" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
              </div>
            </div>
<?php }
if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='event'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-21" class="form-group row">
              <label for="category_4" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Category Four</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input id="category_4" list="category_4_options" type="text" class="form-control textinput" value="<?php echo$r['category_4'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_4"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
<?php if($user['options'][1]==1){
  $sc=$db->query("SELECT DISTINCT category_4 FROM `".$prefix."content` WHERE category_4!='' ORDER BY category_4 ASC");
  if($sc->rowCount()>0){
    echo'<datalist id="category_4_options">';
    while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_4'].'"/>';
    echo'</datalist>';
  }
                echo'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecategory_4" class="btn btn-secondary save" data-dbid="category_4" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>';
}?>
              </div>
            </div>
<?php }
if($r['contentType']=='event'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-22" class="form-group row">
              <label for="rrp" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">RRP</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-text">$</div>
                <input type="text" id="rrp" class="form-control textinput" value="<?php echo$r['rrp'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rrp"<?php echo$user['options'][1]==1?' placeholder="Enter a Recommended Retail Cost..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saverrp" class="btn btn-secondary save" data-dbid="rrp" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='event'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-23" class="form-group row">
              <label for="cost" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Cost</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-text">$</div>
                <input type="text" id="cost" class="form-control textinput" value="<?php echo$r['cost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost"<?php echo$user['options'][1]==1?' placeholder="Enter a Cost..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecost" class="btn btn-secondary save" data-dbid="cost" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='event'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-24" class="form-group row">
              <label for="rCost" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Reduced Cost</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-text">$</div>
                <input type="text" id="rCost" class="form-control textinput" value="<?php echo$r['rCost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rCost"<?php echo$user['options'][1]==1?' placeholder="Enter a Reduced Cost..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saverCost" class="btn btn-secondary save" data-dbid="rCost" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='event'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
            <div id="nav-content-content-25" class="form-group row">
              <label for="options0" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Show Cost</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0"<?php echo($r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
<?php }
if($r['contentType']=='inventory'){?>
            <div id="nav-content-content-26" class="form-group row">
              <label for="quantity" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Quantity</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="quantity" class="form-control textinput" value="<?php echo $r['quantity'];?>" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="quantity"<?php echo$user['options'][1]==1?' placeholder="Enter a Quantity..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savequantity" class="btn btn-secondary save" data-dbid="quantity" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>

            <div id="nav-content-content-27" class="form-group row">
              <label for="itemCondition" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Condition</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="itemCondition" class="form-control" onchange="update('<?php echo$r['id'];?>','content','itemCondition',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Change Condition"':' disabled';?>>
                  <option value=""<?php echo$r['itemCondition']==''?' selected':'';?>>None</option>
                  <option value="acceptable"<?php echo$r['itemCondition']=='acceptable'?' selected':'';?>>Acceptable</option>
                  <option value="brand new"<?php echo$r['itemCondition']=='brand new'?' selected':'';?>>Brand New</option>
                  <option value="certified pre-owned"<?php echo$r['itemCondition']=='certified pre-owned'?' selected':'';?>>Certified Pre-Owned</option>
                  <option value="damaged"<?php echo$r['itemCondition']=='damaged'?' selected':'';?>>Damaged</option>
                  <option value="excellent"<?php echo$r['itemCondition']=='excellent'?' selected':'';?>>Excellent</option>
                  <option value="fair"<?php echo$r['itemCondition']=='fair'?' selected':'';?>>Fair</option>
                  <option value="for parts"<?php echo$r['itemCondition']=='for parts'?' selected':'';?>>For Parts</option>
                  <option value="good"<?php echo$r['itemCondition']=='good'?' selected':'';?>>Good</option>
                  <option value="like new"<?php echo$r['itemCondition']=='like new'?' selected':'';?>>Like New</option>
                  <option value="mint"<?php echo$r['itemCondition']=='mint'?' selected':'';?>>Mint</option>
                  <option value="mint in box"<?php echo$r['itemCondition']=='mint in box'?' selected':'';?>>Mint In Box</option>
                  <option value="new"<?php echo$r['itemCondition']=='new'?' selected':'';?>>New</option>
                  <option value="new with box"<?php echo$r['itemCondition']=='new with box'?' selected':'';?>>New With Box</option>
                  <option value="new with defects"<?php echo$r['itemCondition']=='new with defects'?' selected':'';?>>New With Defects</option>
                  <option value="new with tags"<?php echo$r['itemCondition']=='new with tags'?' selected':'';?>>New With Tags</option>
                  <option value="new without box"<?php echo$r['itemCondition']=='new without box'?' selected':'';?>>New Without Box</option>
                  <option value="new without tags"<?php echo$r['itemCondition']=='new without tags'?' selected':'';?>>New Without Tags</option>
                  <option value="non functioning"<?php echo$r['itemCondition']=='non functioning'?' selected':'';?>>Non Functioning</option>
                  <option value="poor"<?php echo$r['itemCondition']=='poor'?' selected':'';?>>Poor</option>
                  <option value="pre-owned"<?php echo$r['itemCondition']=='pre-owned'?' selected':'';?>>Pre-Owned</option>
                  <option value="refurbished"<?php echo$r['itemCondition']=='refurbished'?' selected':'';?>>Refurbished</option>
                  <option value="remanufactured"<?php echo$r['itemCondition']=='remanufactured'?' selected':'';?>>Remanufactured</option>
                  <option value="seasoned"<?php echo$r['itemCondition']=='seasoned'?' selected':'';?>>Seasoned</option>
                  <option value="unseasoned"<?php echo$r['itemCondition']=='unseasoned'?' selected':'';?>>Unseasoned</option>
                  <option value="used"<?php echo$r['itemCondition']=='used'?' selected':'';?>>Used</option>
                  <option value="very good"<?php echo$r['itemCondition']=='very good'?' selected':'';?>>Very Good</option>
                </select>
              </div>
            </div>

            <div id="nav-content-content-28" class="form-group row">
              <label for="weight" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Weight</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="weight" class="form-control textinput" value="<?php echo $r['weight'];?>" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="weight"<?php echo$user['options'][1]==1?' placeholder="Enter a Weight..."':' readonly';?>>
                <select id="weightunit" class="form-control" onchange="update('<?php echo$r['id'];?>','content','weightunit',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Change Weight Unit"':' disabled';?>>
                  <option value="kg"<?php echo$r['weightunit']=='kg'?' selected':'';?>>Kilograms (kg)</option>
                  <option value="mg"<?php echo$r['weightunit']=='mg'?' selected':'';?>>Milligrams (mg)</option>
                  <option value="g"<?php echo$r['weightunit']=='g'?' selected':'';?>>Grams (g)</option>
                  <option value="lb"<?php echo$r['weightunit']=='lb'?' selected':'';?>>Pound (lb)</option>
                  <option value="t"<?php echo$r['weightunit']=='t'?' selected':'';?>>Tonne (t)</option>
                  <option value="Gt"<?php echo$r['weightunit']=='Gt'?' selected':'';?>>Gigatonne (Gt)</option>
                  <option value="Mt"<?php echo$r['weightunit']=='Mt'?' selected':'';?>>Megatonne (Mt)</option>
                  <option value="ug"<?php echo$r['weightunit']=='ug'?' selected':'';?>>Microgram (ug)</option>
                  <option value="ng"<?php echo$r['weightunit']=='ng'?' selected':'';?>>Nanogram (ng)</option>
                  <option value="pg"<?php echo$r['weightunit']=='pg'?' selected':'';?>>Picogram (pg)</option>
                  <option value="oz"<?php echo$r['weightunit']=='oz'?' selected':'';?>>Ounce (oz)</option>
                  <option value="cg"<?php echo$r['weightunit']=='cg'?' selected':'';?>>Centigram (cg)</option>
                  <option value="dg"<?php echo$r['weightunit']=='dg'?' selected':'';?>>Decigram (dg)</option>
                  <option value="dag"<?php echo$r['weightunit']=='dag'?' selected':'';?>>Dekagram (dag)</option>
                  <option value="hg"<?php echo$r['weightunit']=='hg'?' selected':'';?>>Hectogram (hg)</option>
                  <option value="dr"<?php echo$r['weightunit']=='dr'?' selected':'';?>>Dram (dr)</option>
                  <option value="grains"<?php echo$r['weightunit']=='grains'?' selected':'';?>>Grains (grains)</option>
                  <option value="cwt"<?php echo$r['weightunit']=='cwt'?' selected':'';?>>Hundredweight (cwt)</option>
                  <option value="dwt"<?php echo$r['weightunit']=='dwt'?' selected':'';?>>Pennyweight (dwt)</option>
                </select>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveweight" class="btn btn-secondary save" data-dbid="weight" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div id="nav-content-content-29" class="form-group row">
              <label for="Size" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Size</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-prepend">
                  <span class="input-group-text">Width</span>
                </div>
                <input type="text" id="width" class="form-control textinput" value="<?php echo $r['width'];?>" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="width"<?php echo$user['options'][1]==1?' placeholder="Width"':' readonly';?>>
                <select id="widthunit" class="form-control" onchange="update('<?php echo$r['id'];?>','content','widthunit',$(this).val());"<?php echo$user['options'][1]==1?'  data-tooltip="tooltip" data-title="Change Width Unit"':' disabled';?>>
                  <option value="mm"<?php echo$r['widthunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                  <option value="cm"<?php echo$r['widthunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                  <option value="in"<?php echo$r['widthunit']=='in'?' selected':'';?>>Inch (in)</option>
                  <option value="foot"<?php echo$r['widthunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                  <option value="m"<?php echo$r['widthunit']=='m'?' selected':'';?>>Metre (m)</option>
                  <option value="km"<?php echo$r['widthunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                  <option value="mi"<?php echo$r['widthunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                  <option value="angstrom"<?php echo$r['widthunit']=='angstrom'?' selected':'';?>>Angstrom (angstrom)</option>
                  <option value="AU"<?php echo$r['widthunit']=='AU'?' selected':'';?>>Astronimical Unit (AU)</option>
                  <option value="chain"<?php echo$r['widthunit']=='chain'?' selected':'';?>>Chain (chain)</option>
                  <option value="dam"<?php echo$r['widthunit']=='dam'?' selected':'';?>>Decametre (dam)</option>
                  <option value="dm"<?php echo$r['widthunit']=='dm'?' selected':'';?>>Decimetre (dm)</option>
                  <option value="fathom"<?php echo$r['widthunit']=='fathom'?' selected':'';?>>Fathom (fathom)</option>
                  <option value="furlong"<?php echo$r['widthunit']=='furlong'?' selected':'';?>>Furlong (furlong)</option>
                  <option value="Gly"<?php echo$r['widthunit']=='Gly'?' selected':'';?>>Gigalight-Year (Gly)</option>
                  <option value="Gm"<?php echo$r['widthunit']=='Gm'?' selected':'';?>>Gigametre (Gm)</option>
                  <option value="Gpc"<?php echo$r['widthunit']=='Gpc'?' selected':'';?>>Gigaparsec (Gpc)</option>
                  <option value="hand"<?php echo$r['widthunit']=='hand'?' selected':'';?>>Hand (hand)</option>
                  <option value="hm"<?php echo$r['widthunit']=='hm'?' selected':'';?>>Hectometre (hm)</option>
                  <option value="Kly"<?php echo$r['widthunit']=='Kly'?' selected':'';?>>Kilolight-Year (Kly)</option>
                  <option value="Kpc"<?php echo$r['widthunit']=='Kpc'?' selected':'';?>>Kiloparsec (Kpc)</option>
                  <option value="ly"<?php echo$r['widthunit']=='ly'?' selected':'';?>>Light-Year (ly)</option>
                  <option value="Mly"<?php echo$r['widthunit']=='Mly'?' selected':'';?>>Megalight-Year (Mly)</option>
                  <option value="Mm"<?php echo$r['widthunit']=='Mm'?' selected':'';?>>Megametre (Mm)</option>
                  <option value="Mpc"<?php echo$r['widthunit']=='Mpc'?' selected':'';?>>Megaparsec (Mpc)</option>
                  <option value="um"<?php echo$r['widthunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                  <option value="nm"<?php echo$r['widthunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                  <option value="nmi"<?php echo$r['widthunit']=='nmi'?' selected':'';?>>Nautical Mile (nmi)</option>
                  <option value="pc"<?php echo$r['widthunit']=='pc'?' selected':'';?>>Parsec (pc)</option>
                  <option value="perch"<?php echo$r['widthunit']=='perch'?' selected':'';?>>Perch (perch)</option>
                  <option value="pole"<?php echo$r['widthunit']=='pole'?' selected':'';?>>Pole (pole)</option>
                  <option value="rd"<?php echo$r['widthunit']=='rd'?' selected':'';?>>Rod (rd)</option>
                  <option value="yard"<?php echo$r['widthunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                </select>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savewidth" class="btn btn-secondary save" data-dbid="width" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div id="nav-content-content-30" class="form-group row">
              <div class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">&nbsp;</div>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-append">
                  <span class="input-group-text">Height</span>
                </div>
                <input type="text" id="height" class="form-control textinput" value="<?php echo $r['height'];?>" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="height"<?php echo$user['options'][1]==1?' placeholder="Height"':' readonly';?>>
                <select id="heightunit" class="form-control" onchange="update('<?php echo$r['id'];?>','content','heightunit',$(this).val());"<?php echo$user['options'][1]==1?'  data-tooltip="tooltip" data-title="Change Height Unit"':' disabled';?>>
                  <option value="mm"<?php echo$r['heightunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                  <option value="cm"<?php echo$r['heightunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                  <option value="in"<?php echo$r['heightunit']=='in'?' selected':'';?>>Inch (in)</option>
                  <option value="foot"<?php echo$r['heightunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                  <option value="m"<?php echo$r['heightunit']=='m'?' selected':'';?>>Metre (m)</option>
                  <option value="km"<?php echo$r['heightunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                  <option value="mi"<?php echo$r['heightunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                  <option value="angstrom"<?php echo$r['heightunit']=='angstrom'?' selected':'';?>>Angstrom (angstrom)</option>
                  <option value="AU"<?php echo$r['heightunit']=='AU'?' selected':'';?>>Astronimical Unit (AU)</option>
                  <option value="chain"<?php echo$r['heightunit']=='chain'?' selected':'';?>>Chain (chain)</option>
                  <option value="dam"<?php echo$r['heightunit']=='dam'?' selected':'';?>>Decametre (dam)</option>
                  <option value="dm"<?php echo$r['heightunit']=='dm'?' selected':'';?>>Decimetre (dm)</option>
                  <option value="fathom"<?php echo$r['heightunit']=='fathom'?' selected':'';?>>Fathom (fathom)</option>
                  <option value="furlong"<?php echo$r['heightunit']=='furlong'?' selected':'';?>>Furlong (furlong)</option>
                  <option value="Gly"<?php echo$r['heightunit']=='Gly'?' selected':'';?>>Gigalight-Year (Gly)</option>
                  <option value="Gm"<?php echo$r['heightunit']=='Gm'?' selected':'';?>>Gigametre (Gm)</option>
                  <option value="Gpc"<?php echo$r['heightunit']=='Gpc'?' selected':'';?>>Gigaparsec (Gpc)</option>
                  <option value="hand"<?php echo$r['heightunit']=='hand'?' selected':'';?>>Hand (hand)</option>
                  <option value="hm"<?php echo$r['heightunit']=='hm'?' selected':'';?>>Hectometre (hm)</option>
                  <option value="Kly"<?php echo$r['heightunit']=='Kly'?' selected':'';?>>Kilolight-Year (Kly)</option>
                  <option value="Kpc"<?php echo$r['heightunit']=='Kpc'?' selected':'';?>>Kiloparsec (Kpc)</option>
                  <option value="ly"<?php echo$r['heightunit']=='ly'?' selected':'';?>>Light-Year (ly)</option>
                  <option value="Mly"<?php echo$r['heightunit']=='Mly'?' selected':'';?>>Megalight-Year (Mly)</option>
                  <option value="Mm"<?php echo$r['heightunit']=='Mm'?' selected':'';?>>Megametre (Mm)</option>
                  <option value="Mpc"<?php echo$r['heightunit']=='Mpc'?' selected':'';?>>Megaparsec (Mpc)</option>
                  <option value="um"<?php echo$r['heightunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                  <option value="nm"<?php echo$r['heightunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                  <option value="nmi"<?php echo$r['heightunit']=='nmi'?' selected':'';?>>Nautical Mile (nmi)</option>
                  <option value="pc"<?php echo$r['heightunit']=='pc'?' selected':'';?>>Parsec (pc)</option>
                  <option value="perch"<?php echo$r['heightunit']=='perch'?' selected':'';?>>Perch (perch)</option>
                  <option value="pole"<?php echo$r['heightunit']=='pole'?' selected':'';?>>Pole (pole)</option>
                  <option value="rd"<?php echo$r['heightunit']=='rd'?' selected':'';?>>Rod (rd)</option>
                  <option value="yard"<?php echo$r['heightunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                </select>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveheight" class="btn btn-secondary save" data-dbid="height" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>

            <div id="nav-content-content-31" class="form-group row">
              <div class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">&nbsp;</div>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-append">
                  <span class="input-group-text">Length</span>
                </div>
                <input type="text" id="length" class="form-control textinput" value="<?php echo$r['length'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="length"<?php echo$user['options'][1]==1?' placeholder="Length"':' readonly';?>>
                <select id="lengthunit" class="form-control" onchange="update('<?php echo$r['id'];?>','content','lengthunit',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Change Length Unit"':' disabled';?>>
                  <option value="mm"<?php echo$r['lengthunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                  <option value="cm"<?php echo$r['lengthunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                  <option value="in"<?php echo$r['lengthunit']=='in'?' selected':'';?>>Inch (in)</option>
                  <option value="foot"<?php echo$r['lengthunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                  <option value="m"<?php echo$r['lengthunit']=='m'?' selected':'';?>>Metre (m)</option>
                  <option value="km"<?php echo$r['lengthunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                  <option value="mi"<?php echo$r['lengthunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                  <option value="angstrom"<?php echo$r['lengthunit']=='angstrom'?' selected':'';?>>Angstrom (angstrom)</option>
                  <option value="AU"<?php echo$r['lengthunit']=='AU'?' selected':'';?>>Astronimical Unit (AU)</option>
                  <option value="chain"<?php echo$r['lengthunit']=='chain'?' selected':'';?>>Chain (chain)</option>
                  <option value="dam"<?php echo$r['lengthunit']=='dam'?' selected':'';?>>Decametre (dam)</option>
                  <option value="dm"<?php echo$r['lengthunit']=='dm'?' selected':'';?>>Decimetre (dm)</option>
                  <option value="fathom"<?php echo$r['lengthunit']=='fathom'?' selected':'';?>>Fathom (fathom)</option>
                  <option value="furlong"<?php echo$r['lengthunit']=='furlong'?' selected':'';?>>Furlong (furlong)</option>
                  <option value="Gly"<?php echo$r['lengthunit']=='Gly'?' selected':'';?>>Gigalight-Year (Gly)</option>
                  <option value="Gm"<?php echo$r['lengthunit']=='Gm'?' selected':'';?>>Gigametre (Gm)</option>
                  <option value="Gpc"<?php echo$r['lengthunit']=='Gpc'?' selected':'';?>>Gigaparsec (Gpc)</option>
                  <option value="hand"<?php echo$r['lengthunit']=='hand'?' selected':'';?>>Hand (hand)</option>
                  <option value="hm"<?php echo$r['lengthunit']=='hm'?' selected':'';?>>Hectometre (hm)</option>
                  <option value="Kly"<?php echo$r['lengthunit']=='Kly'?' selected':'';?>>Kilolight-Year (Kly)</option>
                  <option value="Kpc"<?php echo$r['lengthunit']=='Kpc'?' selected':'';?>>Kiloparsec (Kpc)</option>
                  <option value="ly"<?php echo$r['lengthunit']=='ly'?' selected':'';?>>Light-Year (ly)</option>
                  <option value="Mly"<?php echo$r['lengthunit']=='Mly'?' selected':'';?>>Megalight-Year (Mly)</option>
                  <option value="Mm"<?php echo$r['lengthunit']=='Mm'?' selected':'';?>>Megametre (Mm)</option>
                  <option value="Mpc"<?php echo$r['lengthunit']=='Mpc'?' selected':'';?>>Megaparsec (Mpc)</option>
                  <option value="um"<?php echo$r['lengthunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                  <option value="nm"<?php echo$r['lengthunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                  <option value="nmi"<?php echo$r['lengthunit']=='nmi'?' selected':'';?>>Nautical Mile (nmi)</option>
                  <option value="pc"<?php echo$r['lengthunit']=='pc'?' selected':'';?>>Parsec (pc)</option>
                  <option value="perch"<?php echo$r['lengthunit']=='perch'?' selected':'';?>>Perch (perch)</option>
                  <option value="pole"<?php echo$r['lengthunit']=='pole'?' selected':'';?>>Pole (pole)</option>
                  <option value="rd"<?php echo$r['lengthunit']=='rd'?' selected':'';?>>Rod (rd)</option>
                  <option value="yard"<?php echo$r['lengthunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                </select>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savelength" class="btn btn-secondary save" data-dbid="length" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php }
if($r['contentType']=='inventory'){?>
            <div id="tab-content-content-32" class="form-group row">
              <label for="stockStatus" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Stock Status</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="stockStatus" class="form-control" onchange="update('<?php echo$r['id'];?>','content','stockStatus',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Change Stock Status"':' disabled';?>>
                  <option value="quantity"<?php echo$r['stockStatus']=='quantity'?' selected':''?>>Dependant on Quantity (In Stock/Out Of Stock)</option>
                  <option value="in stock"<?php echo$r['stockStatus']=='in stock'?' selected':'';?>>In Stock</option>
                  <option value="out of stock"<?php echo$r['stockStatus']=='out of stock'?' selected':'';?>>Out Of Stock</option>
                  <option value="pre-order"<?php echo$r['stockStatus']=='pre-order'?' selected':'';?>>Pre-Order</option>
                  <option value="available"<?php echo$r['stockStatus']=='available'?' selected':'';?>>Available</option>
                  <option value="sold out"<?php echo$r['stockStatus']=='sold out'?' selected':'';?>>Sold Out</option>
                  <option value="none"<?php echo($r['stockStatus']=='none'||$r['stockStatus']=='')?' selected':'';?>>No Display</option>
                </select>
              </div>
            </div>
<?php }?>
            <div class="help-block small text-muted text-right">Edited: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
            <div id="nav-content-content-33" class="form-group">
              <div class="card-header col-sm-12 position-relative p-0">
<?php           if($user['options'][1]==1){
                  if($r['suggestions']==1){
                    $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                    $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'notes']);
                    echo$ss->rowCount()>0?'<div data-tooltip="tooltip" data-title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="notesda" role="button" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                  }
                  echo'<div class="d-flex justify-content-end">'.
                    '<button class="btn btn-secondary seohelper" data-type="content" data-tooltip="tooltip" data-title="SEO Content Information" aria-label="SEO Content Information">'.svg2('seo').'</button>'.
                    '<button class="btn btn-secondary btn-sm" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;" data-tooltip="tooltip" data-title="Show Element Blocks" aria-label="Show Element Blocks">'.svg2('blocks').'</button>'.
                    '<input id="ipsumc" class="form-control" style="width:40px;" value="5">'.
                    '<button class="btn btn-secondary btn-sm" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;" data-tooltip="tooltip" data-title="Add Aussie Lorem Ipsum" aria-label="Add Aussie Lorem Ipsum">'.svg2('loremipsum').'</button>'.
                    '<button class="btn btn-secondary btn-sm addsuggestion" data-dbgid="notesda" data-tooltip="tooltip" data-title="Add Suggestion" aria-label="Add Suggestions">'.svg2('idea').'</button>'.
                  '</div>';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
                <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="content">
                  <input type="hidden" name="c" value="notes">
                  <div class="<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='proofs'?'note-admin ':'').$r['contentType'];?>">
                    <textarea id="notes" class="summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
                  </div>
                </form>
<?php           }else{?>
                <div class="<?php echo($r['contentType']=='article'?'note-admin ':'').$r['contentType'];?>">
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
            </div>
          </div>
<?php /* Images */ ?>
          <div id="tab-content-images" class="tab-pane" role="tabpanel">
            <div id="error"></div>
<?php if($r['contentType']=='testimonials'){?>
            <fieldset id="tab-content-images-1" class="control-fieldset">
              <div id="tstavinfo" class="alert alert-info<?php echo$r['cid']==0?' hidden':'';?>" role="alert">Currently using the Avatar associated with the selected Client Account.</div>
<?php if($user['options'][1]==1){?>
              <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
                <div class="form-group row">
                  <label for="avatar" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Avatar</label>
                  <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                    <input type="text" id="av" class="form-control" value="<?php echo$r['file'];?>" readonly data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="avatar">
                    <div class="input-group-append">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="act" value="add_tstavatar">
                      <div class="btn btn-secondary custom-file" data-tooltip="tooltip" data-title="Browse Computer for Image" aria-label="Browse Computer for Image">
                        <input id="avatarfu" type="file" class="custom-file-input hidden" name="fu" onchange="form.submit()">
                        <label for="avatarfu"><?php svg('browse-computer');?></label>
                      </div>
                    </div>
                    <div class="input-group-append bg-white"><img id="tstavatar" src="<?php echo$r['file']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['file']))?'media'.DS.'avatar'.DS.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar"></div>
                    <div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file','');" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button></div>
                  </div>
                </div>
              </form>
<?php }else{?>
              <div class="form-group row">
                <label for="avatar" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Avatar</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input type="text" id="av" class="form-control" value="<?php echo$r['file'];?>" readonly data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="avatar">
                  <div class="input-group-append bg-white"><img id="tstavatar" src="<?php echo$r['file']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['file']))?'media'.DS.'avatar'.DS.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar"></div>
                </div>
              </div>
<?php }?>
            </fieldset>
<?php }
if($r['contentType']!='testimonials'){?>
            <fieldset id="tab-content-images-2" class="control-fieldset">
              <div id="tab-content-images-3" class="form-group row">
                <label for="fileURL" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">URL</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input type="text" id="fileURL" class="form-control textinput" value="<?php echo$r['fileURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileURL"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                  <div class="input-group-append">
                    <?php echo$r['fileURL']!=''?'<a data-fancybox="thumb" href="'.$r['fileURL'].'"><img id="thumbimage" src="'.$r['fileURL'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  </div>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savefileURL" class="btn btn-secondary save" data-dbid="fileURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-4" class="form-group row">
                <label for="file" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Image</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input id="file" type="text" class="form-control textinput" value="<?php echo$r['file'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="file" readonly>
<?php if($user['options'][1]==1){?>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','content','file');" data-tooltip="tooltip" data-title="Open Media Manager" role="button" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
                  <form target="sp" method="post" action="core/magicimage.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="act" value="file">
                    <div class="input-group-append"><button class="btn btn-secondary" data-tooltip="tooltip" data-title="Resize Image (<?php echo$config['mediaMaxWidth'].'x'.$config['mediaMaxHeight'];?>)" aria-label="Resize Image"><?php svg('magic');?></button></div>
                  </form>
<?php }?>
                  <div class="input-group-append img">
                    <?php echo$r['file']!=''&&file_exists('media'.DS.basename($r['file']))?'<a data-fancybox="'.$r['contentType'].$r['id'].'" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img id="fileimage" src="'.$r['file'].'" alt="'.$r['contentType'].': '.$r['title'].'"></a>':'<img id="fileimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  </div>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate(`'.$r['id'].'`,`content`,`file`);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savefile" class="btn btn-secondary save" data-dbid="file" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="nav-content-images-5" class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options2" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="2"<?php echo($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options2" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable Panorama</label>
              </div>
              <div id="nav-content-images-5" class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options3" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="3"<?php echo($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options3" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable 360 Viewer</label>
              </div>
              <div id="tab-content-images-6" class="form-group row">
                <label for="thumb" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Thumbnail</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input id="thumb" type="text" class="form-control textinput" value="<?php echo$r['thumb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="thumb" readonly>
<?php if($user['options'][1]==1){?>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','content','thumb');"data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
                  <form target="sp" method="post" action="core/magicimage.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="act" value="thumb">
                    <div class="input-group-append"><button class="btn btn-secondary" data-tooltip="tooltip" data-title="Create Thumbnail From Above Image (<?php echo$config['mediaMaxWidthThumb'].'x'.$config['mediaMaxHeightThumb'];?>)" aria-label="Create Thumbnail From Above Image."><?php svg('magic');?></button></div>
                  </form>
<?php }?>
                  <div class="input-group-append img">
                    <?php echo$r['thumb']!=''&&file_exists('media'.DS.'thumbs'.DS.basename($r['thumb']))?'<a data-fancybox="thumb'.$r['id'].'" data-caption="Thumbnail: '.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['thumb'].'"><img id="thumbimage" src="'.$r['thumb'].'" alt="Thumbnail: '.$r['title'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  </div>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate(`'.$r['id'].'`,`content`,`thumb`);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savethumb" class="btn btn-secondary save" data-dbid="thumb" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-7" class="form-group row">
                <label for="exifFilename" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Image ALT</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Image Alt Information"><button class="btn btn-secondary seohelper" data-type="alt" aria-label="SEO Image Alt Information"><?php svg('seo');?></button></div>
                  <input type="text" id="fileALT" class="form-control textinput" value="<?php echo$r['fileALT'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileALT"<?php echo$user['options'][1]==1?' placeholder="Enter an Image ALT Text..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save" aria-label="Save"><button id="savefileALT" class="btn btn-secondary save" data-dbid="fileALT" data-style="zoom-in">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div class="form-group row">
                <label for="coverVideo" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Video URL</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input type="text" id="videoURL" class="form-control" name="videoURL" value="<?php echo$r['videoURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="videoURL">
                  <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`videoURL`);" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager">'.svg2('browse-media').'</button></div><div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate(`'.$r['id'].'`,`content`,`videoURL`,``);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button></div>':'';?>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savevideoURL" class="btn btn-secondary save" data-dbid="videoURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options4" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="4"<?php echo$r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options4" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">AutoPlay Video</label>
              </div>
              <div class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options5" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="5"<?php echo$r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options5" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Loop Video</label>
              </div>
              <div class="form-group row">
                <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options6" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="6"<?php echo$r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options6" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Show Controls</label>
              </div>
            </fieldset>
            <fieldset id="tab-content-images-8" class="control-fieldset">
              <legend class="control-legend">EXIF Information</legend>
              <?php echo$user['options'][1]==1?'<div class="help-block small text-muted text-right">Using the "Magic Wand" button will attempt to get the EXIF Information embedded in the Uploaded Image.</div>':'';?>
              <div id="tab-content-images-9" class="form-group row">
                <label for="exifFilename" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Original Filename</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifFilename`);" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifFilename" class="form-control textinput" value="<?php echo$r['exifFilename'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFilename"<?php echo$user['options'][1]==1?' placeholder="Original Filename..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save" aria-label="Save"><button id="saveexifFilename" class="btn btn-secondary save" data-dbid="exifFilename" data-style="zoom-in">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-10" class="form-group row">
                <label for="exifCamera" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Camera</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifCamera`);" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifCamera" class="form-control textinput" value="<?php echo$r['exifCamera'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifCamera"<?php echo$user['options'][1]==1?' placeholder="Enter a Camera"':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifCamera" class="btn btn-secondary save" data-dbid="exifCamera" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-11" class="form-group row">
                <label for="exifLens" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Lens</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifLens`);" role="button" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifLens" class="form-control textinput" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifLens"<?php echo$user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifLens" class="btn btn-secondary save" data-dbid="exifLens" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-12" class="form-group row">
                <label for="exifAperture" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Aperture</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifAperture`);" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifAperture" class="form-control textinput" value="<?php echo$r['exifAperture'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifAperture"<?php echo$user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifAperture" class="btn btn-secondary save" data-dbid="exifAperture" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-13" class="form-group row">
                <label for="exifFocalLength" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Focal Length</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifFocalLength`);" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifFocalLength" class="form-control textinput" value="<?php echo$r['exifFocalLength'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFocalLength"<?php echo$user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifFocalLength" class="btn btn-secondary save" data-dbid="exifFocalLength" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-14" class="form-group row">
                <label for="exifShutterSpeed" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Shutter Speed</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifShutterSpeed`);" role="button" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifShutterSpeed" class="form-control textinput" value="<?php echo$r['exifShutterSpeed'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifShutterSpeed"<?php echo$user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifShutterSpeed" class="btn btn-secondary save" data-dbid="exifShutterSpeed" data-style="zoom-in" role="button" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-15" class="form-group row">
                <label for="exifISO" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">ISO</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifISO`);" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifISO" class="form-control textinput" value="<?php echo$r['exifISO'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifISO"<?php echo$user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifISO" class="btn btn-secondary save" data-dbid="exifISO" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-16" class="form-group row">
                <label for="exifti" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Taken</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <?php echo$user['options'][1]==1?'<div class="input-group-btn"><button class="btn btn-secondary" onclick="getExif(`'.$r['id'].'`,`content`,`exifti`);" aria-label="Get EXIF Information">'.svg2('magic').'</button></div>':'';?>
                  <input type="text" id="exifti" class="form-control textinput" value="<?php echo$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>"" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifti"<?php echo$user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveexifti" class="btn btn-secondary save" data-dbid="exifti" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </fieldset>
            <fieldset id="tab-content-images-17" class="control-fieldset">
              <legend class="control-legend">Image Attribution</legend>
              <div id="tab-content-images-18" class="form-group row">
                <label for="attributionImageTitle" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Title</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle"<?php echo$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                  <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveattributionImageTitle" class="btn btn-secondary save" data-dbid="attributionImageTitle" data-style="zoom-in" role="button" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-19" class="form-group row">
                <label for="attributionImageName" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Name</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input type="text" id="attributionImageName" list="attributionImageName_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageName"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
<?php if($user['options'][1]==1){
  $s=$db->query("SELECT DISTINCT attributionImageName AS name FROM `".$prefix."content` UNION SELECT DISTINCT name AS name FROM content UNION SELECT DISTINCT name AS name FROM login ORDER BY name ASC");
  if($s->rowCount()>0){
    echo'<datalist id="attributionImageName_option">';
    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
    echo'</datalist>';
  }
}
                  echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveattributionImageName" class="btn btn-secondary save" data-dbid="attributionImageName" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
              <div id="tab-content-images-20" class="form-group row">
                <label for="attributionImageURL" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">URL</label>
                <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                  <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
<?php if($user['options'][1]==1){
  $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY attributionImageURL ASC");
  if($s->rowCount()>0){
    echo'<datalist id="attributionImageURL_option">';
    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';
    echo'</datalist>';
  }
}
                  echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveattributionImageURL" class="btn btn-secondary save" data-dbid="attributionImageURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </fieldset>
<?php }?>
          </div>
<?php /* Media */
if($r['contentType']!='testimonials'){?>
          <div id="tab-content-media" class="tab-pane" role="tabpanel">
<?php if($user['options'][1]==1){?>
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <input type="hidden" name="act" value="add_media">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="content">
              <div class="form-group">
                <div class="input-group">
                  <input id="mediafile" type="text" class="form-control" name="fu" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','media','mediafile');return false;" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
                  <div class="input-group-append"><button type="submit" class="btn btn-secondary add" onclick="" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button></div>
                </div>
              </div>
            </form>
<?php }?>
            <div class="container">
              <div id="mi" class="row">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND pid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
if($sm->rowCount()>0){
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
    if(file_exists('media/thumbs/'.preg_replace('/\\.[^.\\s]{3,4}$/','',basename($rm['file'])).'.png'))
      $thumb='media/thumbs/'.preg_replace('/\\.[^.\\s]{3,4}$/','',basename($rm['file'])).'.png';
    else
      $thumb=$rm['file'];?>
                <div id="mi_<?php echo$rm['id'];?>" class="media-gallery d-inline-block col-6 col-sm-2 position-relative p-0 m-1 mt-0">
                  <a data-fancybox="media" data-caption="<?php echo($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" class="card bg-dark m-0" href="<?php echo$rm['file'];?>">
                    <img src="<?php echo$thumb;?>" class="card-img" alt="Media <?php echo$rm['id'];?>">
                  </a>
<?php   if($user['options'][1]==1){?>
                  <div class="btn-group float-right">
                    <div class="handle btn btn-secondary btn-xs" onclick="return false;" data-tooltip="tooltip" data-title="Drag to ReOrder this item" aria-label="Drag to ReOrder this item"><?php svg('drag');?></div>
                    <a class="btn btn-secondary btn-xs" href="<?php echo URL.$settings['system']['admin'].'/media/edit/'.$rm['id'];?>"><?php svg('edit');?></a>
                    <button class="btn btn-secondary trash btn-xs" onclick="purge('<?php echo$rm['id'];?>','media')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                  </div>
<?php   }?>
                </div>
<?php }
if($user['options'][1]==1){?>
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
<?php }
}?>
              </div>
            </div>
          </div>
<?php }
/* Options */ ?>
          <div id="tab-content-options" class="tab-pane" role="tabpanel">
            <fieldset class="control-fieldset">
<?php if($user['options'][1]==1){?>
              <div id="tab-content-options-1" class="form-group">
                <form target="sp" method="post" action="core/add_data.php">
                  <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="act" value="add_option">
                  <div class="input-group">
                    <div class="input-group-text">Option</div>
                    <input type="text" class="form-control" name="ttl" value="" placeholder="Title">
                    <div class="input-group-text">Quantity</div>
                    <input type="text" class="form-control" name="qty" value="" placeholder="Quantity">
                    <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button></div>
                  </div>
                </form>
              </div>
<?php }?>
              <div id="itemoptions">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE rid=:rid ORDER BY title ASC");
$ss->execute([':rid'=>$r['id']]);
if($ss->rowCount()>0){
  while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?php echo $rs['id'];?>" class="form-group row">
                  <div class="input-group col-12">
                    <div class="input-group-text">Option</div>
                    <input type="text" class="form-control" value="<?php echo$rs['title'];?>"<?php echo$user['options'][1]==1?' onchange="update(`'.$rs['id'].'`,`choices`,`title`,$(this).val());" placeholder="Title"':' readonly';?>>
                    <div class="input-group-text">Quantity</div>
                    <input type="text" class="form-control" value="<?php echo$rs['ti'];?>"<?php echo$user['options'][1]==1?' onchange="update(`'.$rs['id'].'`,`choices`,`ti`,$(this).val());" placeholder="Quantity"':' readonly';?>>
<?php if($user['options'][1]==1){?>
                    <div class="input-group-append">
                      <form target="sp" action="core/purge.php">
                        <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                        <input type="hidden" name="t" value="choices">
                        <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                      </form>
                    </div>
<?php }?>
                  </div>
                </div>
<?php }
}?>
              </div>
            </fieldset>
          </div>
<?php /* Comments */ ?>
          <div id="tab-content-comments" class="tab-pane" role="tabpanel">
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1"<?php echo($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options1" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable</label>
            </div>
            <div id="comments" class="clearfix">
<?php $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");
$sc->execute([':contentType'=>$r['contentType'],':rid'=>$r['id']]);
if($user['options']{1}==1){
  while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
              <div id="l_<?php echo$rc['id'];?>" class="media mb-3 p-3 border-bottom border-dark<?php echo$rc['status']=='unapproved'?' danger':'';?>">
<?php $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
    $su->execute([':id'=>$rc['uid']]);
    $ru=$su->fetch(PDO::FETCH_ASSOC);?>
                <img class="align-self-start mr-3 bg-white img-circle" style="max-width:64px;height:64px;" src="<?php if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))echo'media'.DS.'avatar'.DS.$ru['avatar'];elseif($ru['gravatar']!='')echo md5($ru['gravatar']);else echo ADMINNOAVATAR;?>" alt="<?php echo$rc['name'];?>">
                <div class="media-body">
<?php if($user['options'][1]==1){?>
                  <div id="controls-<?php echo$rc['id'];?>" class="btn-group float-right">
<?php   $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
        $scc->execute([':ip'=>$rc['ip']]);
        if($scc->rowCount()<1){?>
                    <form id="blacklist<?php echo$rc['id'];?>" class="d-inline-block" target="sp" method="post" action="core/add_commentblacklist.php">
                      <input type="hidden" name="id" value="<?php echo$rc['id'];?>">
                      <button class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="Add IP to Blacklist" aria-label="Add IP to Blacklist"><?php echo svg2('security');?></button>
                    </form>
<?php   }?>
                    <button id="approve_<?php echo$rc['id'];?>" class="btn btn-secondary btn-sm add<?php echo$rc['status']!='unapproved'?' hidden':'';?>" onclick="update('<?php echo$rc['id'];?>','comments','status','approved')" data-tooltip="tooltip" data-title="Approve" aria-label="Approve"><?php svg('approve');?></button>
                    <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$rc['id'];?>','comments')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                  </div>
<?php }?>
                  <h6 class="media-heading">Name: <?php echo$rc['name']==''?'Anonymous':$rc['name'].' &lt;'.$rc['email'].'&gt;';?></h6>
                  <time class="small"><?php echo date($config['dateFormat'],$rc['ti']);?></time><br>
                  <?php echo strip_tags($rc['notes']);?>
                </div>
              </div>
<?php }
}?>
            </div>
<?php if($user['options'][1]==1){?>
            <iframe name="comments" id="comments" class="hidden"></iframe>
            <form role="form" target="comments" method="post" action="core/add_data.php">
              <input type="hidden" name="act" value="add_comment">
              <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
              <input type="hidden" name="contentType" value="<?php echo$r['contentType'];?>">
              <div class="form-group row">
                <label for="commentemail" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Email</label>
                <div class="input-group col-sm-10"><input type="text" id="commentemail" class="form-control" name="email" value="<?php echo$user['email'];?>"></div>
              </div>
              <div class="form-group row">
                <label for="commentname" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Name</label>
                <div class="input-group col-sm-10"><input type="text" id="commentname" class="form-control" name="name" value="<?php echo$user['name'];?>"></div>
              </div>
              <div class="form-group row">
                <label for="commentda" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Comment</label>
                <div class="input-group col-sm-10">
                  <textarea id="commentda" class="form-control" name="da" placeholder="Enter a Comment..." required></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2"></label>
                <div class="input-group col-sm-10">
                  <button class="btn btn-secondary btn-block add" aria-label="Add Comment');?>">Add Comment</button>
                </div>
              </div>
            </form>
<?php }?>
          </div>
<?php /* Reviews */ ?>
          <div id="tab-content-reviews" class="tab-pane" role="tabpanel">
<?php $sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid ORDER BY ti DESC");
$sr->execute([':rid'=>$r['id']]);
if($sr->rowCount()>0){
  while($rr=$sr->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rr['id'];?>" class="media<?php echo$rr['status']=='unapproved'?' danger':'';?>">
              <div class="media-body well p-1 p-sm-3 border-top border-dark">
<?php if($user['options'][1]==1){?>
                <div id="controls-<?php echo$rr['id'];?>" class="btn-group float-right" role="group">
                  <button id="approve_<?php echo$rr['id'];?>" class="btn btn-secondary btn-sm<?php echo$rr['status']=='approved'?' hidden':'';?>" onclick="update('<?php echo$rr['id'];?>','comments','status','approved')" data-tooltip="tooltip" data-title="Approve" aria-label="Approve"><?php svg('approve');?></button>
                  <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$rr['id'];?>','comments')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </div>
<?php }?>
                <h6 class="media-heading">
                  <span class="rat d-block d-sm-inline-block">
                    <span<?php echo($rr['cid']>=1?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']>=2?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']>=3?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']>=4?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']==5?' class="set"':'');?>></span>
                  </span>
                  <?php echo$rr['name']==''?'Anonymous':$rr['name'].' &lt;'.$rr['email'].'&gt; on '.date($config['dateFormat'],$rr['ti']);?>
                </h6>
                <p><?php echo$rr['notes'];?></p>
              </div>
            </div>
<?php }
}?>
          </div>
<?php /* Related */
if($r['contentType']=='article'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
          <div id="tab-content-related" class="tab-pane" role="tabpanel">
            <fieldset class="control-fieldset">
<?php   if($user['options'][1]==1){?>
              <div id="tab-content-related-1" class="form-group">
                <form target="sp" method="post" action="core/add_data.php">
                  <input type="hidden" name="act" value="add_related">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
<?php     $sr=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id!=:id AND contentType='article' OR contentType='inventory' OR contentType='service' ORDER BY contentType ASC, title ASC");
          $sr->execute([':id'=>$r['id']]);
          if($sr->rowCount()>0){?>
                  <div class="input-group">
                    <select id="schemaType" class="form-control" name="rid"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Select a Content Item to Relate to this one..."':' disabled';?>>
                      <option value="0">Select a Content Item to Relate to this one...</option>
<?php       while($rr=$sr->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rr['id'].'">'.$rr['contentType'].': '.$rr['title'].'</option>';?>
                    </select>
                    <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add"><?php svg('add');?></button></div>
                  </div>
<?php      }?>
                </form>
              </div>
<?php }?>
              <div id="relateditems">
<?php $sr=$db->prepare("SELECT id,rid FROM `".$prefix."choices` WHERE uid=:id AND contentType='related' ORDER BY ti ASC");
$sr->execute([':id'=>$r['id']]);
while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
  $si=$db->prepare("SELECT contentType,title FROM `".$prefix."content` WHERE id=:id");
  $si->execute([':id'=>$rr['rid']]);
  $ri=$si->fetch(PDO::FETCH_ASSOC);?>
                <div id="l_<?php echo $rr['id'];?>" class="form-group row">
                  <div class="input-group col-12">
                    <input type="text" class="form-control" value="<?php echo ucfirst($ri['contentType']).': '.$ri['title'];?>" readonly>
<?php if($user['options'][1]==1){?>
                    <div class="input-group-append">
                      <form target="sp" action="core/purge.php">
                        <input type="hidden" name="id" value="<?php echo$rr['id'];?>">
                        <input type="hidden" name="t" value="choices">
                        <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                      </form>
                    </div>
<?php }?>
                  </div>
                </div>

<?php }?>
              </div>
            </fieldset>
          </div>
<?php }
/* SEO */
if($r['contentType']!='testimonials'&&$r['contentType']!='proofs'){?>
          <div id="tab-content-seo" class="tab-pane" role="tabpanel">
            <div id="tab-content-seo-1" class="form-group row">
              <label for="views" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Views</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views"<?php echo$user['options'][1]==1?'':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append"><button class="btn btn-secondary trash" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`content`,`views`,`0`);" data-tooltip="tooltip" data-title="Clear" aria-label="Clear">'.svg2('eraser').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveviews" class="btn btn-secondary save" data-dbid="views" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
<?php if($user['options'][1]==1){?>
            <div class="help-block small text-muted text-right">Options for Meta Robots: <span data-tooltip="tooltip" data-title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="tooltip" data-title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="tooltip" data-title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="tooltip" data-title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="tooltip" data-title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="tooltip" data-title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="tooltip" data-title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="tooltip" data-title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="tooltip" data-title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="tooltip" data-title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="tooltip" data-title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
<?php }?>
            <div id="tab-content-seo-2" class="form-group row">
              <label for="metaRobots" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Meta Robots</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Meta Robots Information"><button class="btn btn-secondary seohelper" data-type="metarobots" aria-label="SEO Meta Robots Information"><?php svg('seo');?></button></div>
<?php           if($user['options'][1]==1){
                  if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'metaRobots']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" data-title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="metaRobots" aria-label="Editing Suggestions">'.svg2('lightbulb','','green').'</button></div>':'';
                  }
                }?>
                <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="metaRobots"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="metaRobots" role="button" aria-label="Add Suggestion">'.svg2('idea').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in" role="button" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div id="tab-content-seo-3" class="form-group row">
              <label for="schemaType" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Schema Type</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="schemaType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Schema for Microdata Content"':' disabled';?>>
                  <option value="blogPosting"<?php echo$r['schemaType']=='blogPosting'?' selected':'';?>>blogPosting for Articles</option>
                  <option value="Product"<?php echo$r['schemaType']=='Product'?' selected':'';?>>Product for Inventory</option>
                  <option value="Service"<?php echo$r['schemaType']=='Service'?' selected':'';?>>Service for Services</option>
                  <option value="ImageGallery"<?php echo$r['schemaType']=='ImageGallery'?' selected':'';?>>ImageGallery for Gallery Images</option>
                  <option value="Review"<?php echo$r['schemaType']=='Review'?' selected':'';?>>Review for Testimonials</option>
                  <option value="NewsArticle"<?php echo$r['schemaType']=='NewsArticle'?' selected':'';?>>NewsArticle for News</option>
                  <option value="Event"<?php echo$r['schemaType']=='Event'?' selected':'';?>>Event for Events</option>
                  <option value="CreativeWork"<?php echo$r['schemaType']=='CreativeWork'?' selected':'';?>>CreativeWork for Portfolio/Proofs</option>
                </select>
              </div>
            </div>
            <div id="tab-content-seo-4" class="form-group row">
              <div class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2"></div>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="card col-12 bg-white">
                  <div class="card-body">
                    <div id="google-title" data-tooltip="tooltip" data-placement="left" data-title="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below the information is then tried to be used from the Pages Meta Title, if that is empty then an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                      <?php echo($r['seoTitle']!=''?$r['seoTitle']:$r['title']).' | '.$config['business'];?>
                    </div>
                    <div id="google-link">
                      <?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?>
                    </div>
                    <div id="google-description" data-tooltip="tooltip" data-placement="left" data-title="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, the page Meta Description will be used, if that is empty a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                      <?php if($r['seoDescription']!='')echo$r['seoDescription'];
                      else echo$config['seoDescription'];?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php echo$user['options'][1]==1?'<div class="help-block small text-muted text-right">The recommended character count for Title\'s is 70.</div>':'';?>
            <div id="tab-content-seo-5" class="form-group row">
              <label for="seoTitle" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Meta Title</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Title Information"><button class="btn btn-secondary seohelper" data-type="title" aria-label="SEO Title Information"><?php svg('seo');?></button></div>
<?php $cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoTitlecnt" class="text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
<?php           if($user['options'][1]==1){?>
                <div class="input-group-prepend"><button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" data-title="Remove Stop Words" aria-label="Remove Stop Words"><?php svg('magic');?></button></div>
<?php             if($r['suggestions']==1){
                    $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                    $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoTitle']);
                    echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" data-title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoTitle" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                  }
                }?>
                <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoTitle"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Title..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoTitle" aria-label="Add Suggestion">'.svg2('idea').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <?php echo$user['options'][1]==1?'<div class="help-block small text-muted text-right">The recommended character count for Captions is 100.</div>':'';?>
            <div id="tab-content-seo-6" class="form-group row">
              <label for="seoCaption" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Meta Caption</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Meta Caption Information"><button class="btn btn-secondary seohelper" data-type="metacaption" aria-label="SEO Meta Caption Information"><?php svg('seo');?></button></div>
<?php $cntc=100-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoCaptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span></div>
<?php           if($user['options'][1]==1){
                  if($r['suggestions']==1){
                    $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                    $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoCaption']);
                    echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" data-title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoCaption" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                  }
                }?>
                <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoCaption"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Caption..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoCaption" aria-label="Add Suggestion">'.svg2('idea').'</button></div><div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <?php echo$user['options'][1]==1?'<div class="help-block small text-muted text-right">The recommended character count for Descriptions is 160.</div>':'';?>
            <div id="tab-content-seo-7" class="form-group row">
              <label for="seoDescription" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Meta Description</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Meta Description Information"><button class="btn btn-secondary seohelper" data-type="metadescription" aria-label="SEO Meta Description Information"><?php svg('seo');?></button></div>
<?php $cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoDescriptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span></div>
<?php           if($user['options'][1]==1){
                  if($r['suggestions']==1){
                    $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                    $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoDescription']);
                    echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" data-title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoDescription" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button></div>':'';
                  }
                }?>
                <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoDescription"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Description..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoDescription" aria-label="Add Suggestion">'.svg2('idea').'</button></div><div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div id="tab-content-seo-8" class="form-group row<?php echo$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="seoKeywords" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Keywords</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <div class="input-group-prepend" data-tooltip="tooltip" data-title="SEO Keywords Information"><button class="btn btn-secondary seohelper" data-type="keywords" aria-label="SEO Keywords Information"><?php svg('seo');?></button></div>
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoKeywords"<?php echo$user['options'][1]==1?' placeholder="Enter Keywords..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
            <div id="tab-content-seo-9" class="form-group row">
              <label for="tags" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Tags</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags"<?php echo$user['options'][1]==1?' placeholder="Enter Tags..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savetags" class="btn btn-secondary save" data-dbid="tags" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
          </div>
<?php }
/* Settings */ ?>
          <div id="tab-content-settings" class="tab-pane" role="tabpanel">
            <div id="tab-content-settings-1" class="form-group row">
              <label for="status" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Status</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Change Status"':' disabled';?>>
                  <option value="unpublished"<?php echo$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                  <option value="autopublish"<?php echo$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                  <option value="published"<?php echo$r['status']=='published'?' selected':'';?>>Published</option>
                  <option value="delete"<?php echo$r['status']=='delete'?' selected':'';?>>Delete</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="rank" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Access</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="rank" class="form-control" onchange="update('<?php echo$r['id'];?>','content','rank',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rank"<?php echo$user['options'][1]==1?'':' disabled';?>>
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
            <div id="tab-content-settings-2" class="form-group row">
              <label for="contentType" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">contentType</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="contentType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" data-title="Change the Type of Content this Item belongs to."':' disabled';?>>
                  <option value="article"<?php echo$r['contentType']=='article'?' selected':'';?>>Article</option>
                  <option value="portfolio"<?php echo$r['contentType']=='portfolio'?' selected':'';?>>Portfolio</option>
                  <option value="events"<?php echo$r['contentType']=='events'?' selected':'';?>>Event</option>
                  <option value="news"<?php echo$r['contentType']=='news'?' selected':'';?>>News</option>
                  <option value="testimonials"<?php echo$r['contentType']=='testimonials'?' selected':'';?>>Testimonial</option>
                  <option value="inventory"<?php echo$r['contentType']=='inventory'?' selected':'';?>>Inventory</option>
                  <option value="service"<?php echo$r['contentType']=='service'?' selected':'';?>>Service</option>
                  <option value="gallery"<?php echo$r['contentType']=='gallery'?' selected':'';?>>Gallery</option>
                  <option value="proofs"<?php echo$r['contentType']=='proofs'?' selected':'';?>>Proof</option>
                </select>
              </div>
            </div>
<?php if($r['contentType']!='proofs'){?>
            <div id="tab-content-settings-3" class="form-group row<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs'?' hidden':'';?>">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="featured0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0"<?php echo($r['featured'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="featured0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Featured</label>
            </div>
<?php }?>
            <div id="tab-content-settings-4" class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="internal0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0"<?php echo($r['internal']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="internal0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Internal</label>
            </div>
<?php if($r['contentType']=='service'){?>
            <div id="tab-content-settings-5" class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="bookable0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0"<?php echo($r['bookable']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="bookable0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Bookable</label>
            </div>
<?php }?>
            <div id="tab-content-settings-6" class="form-group row">
              <label for="mid" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">SubMenu</label>
              <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
                <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','mid',$(this).val());"<?php echo$user['options'][1]==1?'':' disabled';?>>
                  <option value="0"<?php if($r['mid']==0)echo' selected';?>>None</option>
                  <?php $sm=$db->prepare("SELECT id,title from menu WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");$sm->execute([':mid'=>$r['id']]);while($rm=$sm->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3 order-1 order-md-2">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">SEO Pre-Publish Checklist</h6>
          <div class="card-text">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="checklist" data-dbb="0"<?php echo$r['checklist'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist0">Title is Catchy</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist1" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="checklist" data-dbb="1"<?php echo$r['checklist'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist1">Category Selected</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist2" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="checklist" data-dbb="2"<?php echo$r['checklist'][2]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist2">Formatting Done</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist3" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="checklist" data-dbb="3"<?php echo$r['checklist'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist3">Spelling and Grammar</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist4" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="checklist" data-dbb="4"<?php echo$r['checklist'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist4">Image Added</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input striker" id="checklist5" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="checklist" data-dbb="5"<?php echo$r['checklist'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label class="form-check-label" for="checklist5">SEO Checked</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  $('#menu-<?php echo$r['contentType'];?>').addClass('active');
</script>
