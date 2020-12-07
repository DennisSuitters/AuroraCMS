<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content - Edit
 * @package    core/layout/edit_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('content','i-3x');?></div>
          <div>Content Edit</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/add/'.$r['contentType'];?>" role="button" aria-label="Back"><?php svg('back');?></a>
            <button class="<?php echo($r['status']=='published'?'':'hidden');?>" data-social-share="<?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?php echo $r['metaDescription']?$r['metaDescription']:$r['title'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><?php svg('share');?></button>
            <?php echo$user['options'][0]==1?'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/add/'.$r['contentType'].'" role="button" aria-label="Add '.ucfirst($r['contentType']).'">'.svg2('add').'</a>':'';?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content/type/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']).(in_array($r['contentType'],array('article'))?'s':'');?></a></li>
          <li class="breadcrumb-item active"><?php echo$user['options'][1]==1?'Edit':'View';?></li>
          <li class="breadcrumb-item active"><?php echo$r['title'];?></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">Content</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Images</label>
          <?php echo$r['contentType']!='testimonials'?'<input class="tab-control" id="tab1-3" name="tabs" type="radio">'.
            '<label for="tab1-3">Media</label>':'';?>
          <?php echo$r['contentType']=='inventory'?'<input class="tab-control" id="tab1-4" name="tabs" type="radio">'.
            '<label for="tab1-4">Options</label>':'';?>
          <?php echo$r['contentType']=='article'?'<input class="tab-control" id="tab1-5" name="tabs" type="radio">'.
            '<label for="tab1-5">Comments</label>':'';?>
          <?php echo$r['contentType']=='inventory'||$r['contentType']=='service'?'<input class="tab-control" id="tab1-6" name="tabs" type="radio">'.
            '<label for="tab1-6">Reviews</label>':'';?>
          <?php echo$r['contentType']=='article'||$r['contentType']=='inventory'||$r['contentType']=='service'?'<input class="tab-control" id="tab1-7" name="tabs" type="radio">'.
            '<label for="tab1-7">Related</label>':'';?>
          <?php echo$r['contentType']!='testimonials'&&$r['contentType']!='proofs'?'<input class="tab-control" id="tab1-8" name="tabs" type="radio">'.
            '<label for="tab1-8">SEO</label>':'';?>
          <input class="tab-control" id="tab1-9" name="tabs" type="radio">
          <label for="tab1-9">Settings</label>
<?php /* Content */?>
          <div class="tab1-1 border-top p-3" role="tabpanel">
            <div class="form-row mt-3">
              <label for="title">Title</label>
              <small class="form-text text-right">Content MUST contain a Title, to be able to generate a URL Slug or the content won\'t be accessible.</small>
            </div>
            <div class="form-row">
              <?php if($user['options'][1]==1){
                $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                $ss->execute([
                  ':rid'=>$r['id'],
                  ':t'=>'content',
                  ':c'=>'title'
                ]);
                echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=title" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
              }?>
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title"  data-tooltip="tooltip" aria-label="SEO Title Information"><?php svg('seo');?></button>
              <input class="textinput" id="title" type="text" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="trash" onkeyup="genurl();$('#titleupdate').text($(this).val());"<?php echo$user['options'][1]==1?' placeholder="Content MUST contain a Title, to be able to generate a URL Slug or the content won\'t be accessible...."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Generate Aussie Lorem Ipsum Title" onclick="ipsuMe(`title`);genurl();$(`#titleupdate`).text($(`#title`).val());$(`#savetitle`).addClass(`trash`);return false;">'.svg2('loremipsum').'</button>'.
              '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=title" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="savetitle" data-tooltip="tooltip" data-dbid="title" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <script>
              function genurl(){
                var data=$('#title').val().toLowerCase();
                var url="<?php echo URL.$r['contentType'];?>/"+slugify(data);
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
            <label for="genurl">URL Slug</label>
            <div class="form-row">
              <div class="input-text col-12">
                <a id="genurl" target="_blank" href="<?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?>"><?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?></a>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-1">
                <label for="ti">Created</label>
                <div class="form-row">
                  <input id="ti" type="text" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-sm-6 pl-md-1">
                <label for="pti">Published On</label>
                <div class="form-row">
                  <input id="pti" type="datetime-local" value="<?php echo date('Y-m-d\TH:i',$r['pti']);?>" autocomplete="off"<?php echo$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`pti`,getTimestamp(`pti`));"':' readonly';?>>
                </div>
              </div>
            </div>
            <?php if($r['contentType']=='proofs'){?>
              <label for="cid">Client</label>
              <div class="form-row">
                <select id="cid" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid" onchange="update('<?php echo$r['id'];?>','content','cid',$(this).val());"<?php echo$user['options'][1]==1?'':' disabled';?>>
                  <option value="0">Select a Client</option>
                  <?php $cs=$db->query("SELECT * FROM `".$prefix."login` ORDER BY name ASC, username ASC");
                  if($cs->rowCount()>0){
                    while($cr=$cs->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$cr['id'].'"'.($r['cid']==$cr['id']?' selected':'').'>'.$cr['username'].':'.$cr['name'].'</option>';
                  }?>
                </select>
              </div>
            <?php }?>
            <label for="author">Author</label>
            <div class="form-row">
              <select id="uid" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="uid"<?php echo$user['options'][1]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());">
                <?php $su=$db->query("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `username`!='' AND `status`!='delete' ORDER BY `username` ASC, `name` ASC");
                while($ru=$su->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$ru['id'].'"'.($ru['id']==$r['uid']?' selected':'').'>'.$ru['username'].':'.$ru['name'].'</option>';?>
              </select>
            </div>
            <?php if($r['contentType']=='inventory'||$r['contentType']=='service'){?>
              <label for="code">Code</label>
              <div class="form-row">
                <input class="textinput" id="code" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code" type="text" value="<?php echo$r['code'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Code..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="savecode" data-tooltip="tooltip" data-dbid="code" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
            <?php }
            if($r['contentType']=='inventory'){?>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-1">
                  <label for="barcode">Barcode</label>
                  <div class="form-row">
                    <input class="textinput" id="barcode" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="barcode" type="text" value="<?php echo$r['barcode'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Barcode..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savebarcode" data-tooltip="tooltip" data-dbid="barcode" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-1">
                  <label for="fccid">FCCID</label>
                  <div class="form-row">
                    <input class="textinput" id="fccid" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fccid" type="text" value="<?php echo$r['fccid'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an FCCID..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savefccid" data-tooltip="tooltip" data-dbid="fccid" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                  <?php echo$user['options'][1]==1?'<div class="form-text small text-muted float-right"><a target="_blank" href="https://fccid.io/">fccid.io</a> for more information or to look up an FCC ID.</div>':'';?>
                </div>
              </div>
              <label for="brand">Brand</label>
              <div class="form-row">
                <select id="brand" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="brand"<?php echo$user['options'][1]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','brand',$(this).val());">
                  <option value="">None</option>
                  <?php $s=$db->query("SELECT `id`,`title` FROM `".$prefix."choices` WHERE `contentType`='brand' ORDER BY `title` ASC");
                  if($s->rowCount()>0){
                    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['brand']?' selected':'').'>'.$rs['title'].'</option>';
                  }?>
                </select>
              </div>
            <?php }
            if($r['contentType']=='events'){?>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-1">
                  <label for="tis">Event Start</label>
                  <div class="form-row">
                    <input id="tis" type="datetime-local" value="<?php echo($r['tis']!=0?date('Y-m-d\TH:i',$r['tis']):'');?>" autocomplete="off"<?php echo$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tis`,getTimestamp(`tis`));"':' readonly';?>>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-1">
                  <label for="tie">Event End</label>
                  <div class="form-row">
                    <input id="tie" type="datetime-local" value="<?php echo($r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'');?>" autocomplete="off"<?php echo$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tie`,getTimestamp(`tie`));"':' readonly';?>>
                  </div>
                </div>
              </div>
            <?php }
            echo$r['ip']!=''?'<div class="form-text small text-right">'.$r['ip'].'</div>':'';
            if($r['contentType']=='testimonials'){?>
              <div class="row">
                <div class="col-12 col-sm-4 pr-md-2">
                  <label for="name">Name</label>
                  <div class="form-row">
                    <input class="textinput" id="name" list="name_options" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" type="text" value="<?php echo$r['name'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                    <?php if($user['options'][1]==1){
                      $s=$db->query("SELECT DISTINCT `name` FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."login` ORDER BY `name` ASC");
                      if($s->rowCount()>0){
                        echo'<datalist id="name_options">';
                        while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
                        echo'</datalist>';
                      }
                      echo'<button class="save" id="savename" data-tooltip="tooltip" data-dbid="name" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';
                    }?>
                  </div>
                </div>
                <div class="col-12 col-sm-4 pr-md-2">
                  <label for="email">Email</label>
                  <div class="form-row">
                    <input class="textinput" id="email" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" type="text" value="<?php echo$r['email'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an Email..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="saveemail" data-tooltip="tooltip" data-dbid="email" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <label for="business">Business</label>
                  <div class="form-row">
                    <input class="textinput" id="business" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" type="text" value="<?php echo$r['business'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Business..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savebusiness" data-tooltip="tooltip" data-dbid="business" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-1">
                  <label for="url">URL</label>
                  <div class="form-row">
                    <input class="textinput" id="url" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url" type="text" value="<?php echo$r['url'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="saveurl" data-tooltip="tooltip" data-dbid="url" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-1 p-0 pb-2">
                  <label for="rating" class="mb-0">Rating</label>
                  <div class="">
                    <span class="starRating">
                      <input id="rating5" name="rating" type="radio" value="5" onclick="update('<?php echo$r['id'];?>','content','rating','5');"<?php echo$r['rating']==5?' checked':'';?>>
                      <label for="rating5" title="Awesome!">5</label>
                      <input id="rating4" name="rating" type="radio" value="4" onclick="update('<?php echo$r['id'];?>','content','rating','4');"<?php echo$r['rating']==4?' checked':'';?>>
                      <label for="rating4" title="Great!">4</label>
                      <input id="rating3" name="rating" type="radio" value="3" onclick="update('<?php echo$r['id'];?>','content','rating','3');"<?php echo$r['rating']==3?' checked':'';?>>
                      <label for="rating3" title="Meh!">3</label>
                      <input id="rating2" name="rating" type="radio" value="2" onclick="update('<?php echo$r['id'];?>','content','rating','2');"<?php echo$r['rating']==2?' checked':'';?>>
                      <label for="rating2" title="So So!">2</label>
                      <input id="rating1" name="rating" type="radio" value="1" onclick="update('<?php echo$r['id'];?>','content','rating','1');"<?php echo$r['rating']==1?' checked':'';?>>
                      <label for="rating1" title="Bad!">1</label>
                    </span>
                  </div>
                </div>
              </div>
            <?php }
            if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='event'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-1">
                  <label for="category_1">Category One</label>
                  <div class="form-row">
                    <input class="textinput" id="category_1" list="category_1_options" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1" type="text" value="<?php echo$r['category_1'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                    <?php if($user['options'][1]==1){
                      echo'<datalist id="category_1_options">';
                      $sc=$db->prepare("SELECT DISTINCT `title` FROM `".$prefix."choices` WHERE `title`!='' AND `contentType`='category' AND `url`=:url ORDER BY `title` ASC");
                      $sc->execute([
                        ':url'=>$r['contentType']
                      ]);
                      if($sc->rowCount()>0){
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['title'].'"/>';
                      }
                      $sc=$db->query("SELECT DISTINCT `category_1` FROM `".$prefix."content` WHERE `category_1`!='' ORDER BY `category_1` ASC");
                      if($sc->rowCount()>0){
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
                      }
                      echo'</datalist>';
                      echo'<button class="save" id="savecategory_1" data-tooltip="tooltip" data-dbid="category_1" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';
                    }?>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-1">
                  <label for="category_2">Category Two</label>
                  <div class="form-row">
                    <input class="textinput" id="category_2" list="category_2_options" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2" type="text" value="<?php echo$r['category_2'];?>"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
                    <?php if($user['options'][1]==1){
                      $sc=$db->query("SELECT DISTINCT `category_2` FROM `".$prefix."content` WHERE `category_2`!='' ORDER BY `category_2` ASC");
                      if($sc->rowCount()>0){
                        echo'<datalist id="category_2_options">';
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_2'].'"/>';
                        echo'</datalist>';
                      }
                      echo'<button class="save" id="savecategory_2" data-tooltip="tooltip"  data-dbid="category_2" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';
                    }?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-1">
                  <label for="category_3">Category Three</label>
                  <div class="form-row">
                    <input class="textinput" id="category_3" list="category_3_options" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_3" type="text" value="<?php echo$r['category_3'];?>"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
                    <?php if($user['options'][1]==1){
                      $sc=$db->query("SELECT DISTINCT `category_3` FROM `".$prefix."content` WHERE `category_3`!='' ORDER BY `category_3` ASC");
                      if($sc->rowCount()>0){
                        echo'<datalist id="category_3_options">';
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_3'].'"/>';
                        echo'</datalist>';
                      }
                      echo'<button class="save" id="savecategory_3" data-tooltip="tooltip"  data-dbid="category_3" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';
                    }?>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-1">
                  <label for="category_4">Category Four</label>
                  <div class="form-row">
                    <input class="textinput" id="category_4" list="category_4_options" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_4" type="text" value="<?php echo$r['category_4'];?>"<?php echo($user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly');?>>
                    <?php if($user['options'][1]==1){
                      $sc=$db->query("SELECT DISTINCT `category_4` FROM `".$prefix."content` WHERE `category_4`!='' ORDER BY `category_4` ASC");
                      if($sc->rowCount()>0){
                        echo'<datalist id="category_4_options">';
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_4'].'"/>';
                        echo'</datalist>';
                      }
                      echo'<button class="save" id="savecategory_4" data-tooltip="tooltip"  data-dbid="category_4" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';
                    }?>
                  </div>
                </div>
              </div>
            <?php }
            if($r['contentType']=='event'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
              <div class="row mt-3">
                <input id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0" type="checkbox"<?php echo($r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="options0">Show Cost</label>
              </div>
              <div class="row">
                <div class="col-12 col-sm-3 pr-2">
                  <label for="rrp" data-tooltip="tooltip" aria-label="Recommended Retail Price">RRP</label>
                  <div class="form-row">
                    <div class="input-text">$</div>
                    <input class="textinput" id="rrp" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rrp" type="text" value="<?php echo$r['rrp'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Recommended Retail Cost..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="saverrp" data-tooltip="tooltip" data-dbid="rrp" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-3 pr-md-2">
                  <label for="cost">Cost</label>
                  <div class="form-row">
                    <div class="input-text">$</div>
                    <input class="textinput" id="cost" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" type="text" value="<?php echo$r['cost'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Cost..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savecost" data-tooltip="tooltip" data-dbid="cost" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-3 pr-md-2">
                  <label for="rCost">Reduced Cost</label>
                  <div class="form-row">
                    <div class="input-text">$</div>
                    <input class="textinput" id="rCost" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rCost" type="text" value="<?php echo$r['rCost'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Reduced Cost..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="saverCost" data-tooltip="tooltip" data-dbid="rCost" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <label for="rCost">Distributor Cost</label>
                  <div class="form-row">
                    <div class="input-text">$</div>
                    <input class="textinput" id="dCost" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="dCost" type="text" value="<?php echo$r['dCost'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Distributor Cost..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savedCost" data-tooltip="tooltip" data-dbid="dCost" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
              </div>
            <?php }
            if($r['contentType']=='inventory'){?>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-1">
                  <label for="quantity">Quantity</label>
                  <div class="form-row">
                    <input class="textinput" id="quantity" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="quantity" type="text" value="<?php echo $r['quantity'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Quantity..."':' readonly';?>>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savequantity" data-tooltip="tooltip" data-dbid="quantity" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-1">
                  <label for="itemCondition">Condition</label>
                  <div class="form-row">
                    <select id="itemCondition"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Condition"':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','itemCondition',$(this).val());">
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
              </div>
              <label for="stockStatus">Stock Status</label>
              <div class="form-row">
                <select id="stockStatus"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Stock Status"':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','stockStatus',$(this).val());">
                  <option value="quantity"<?php echo$r['stockStatus']=='quantity'?' selected':''?>>Dependant on Quantity (In Stock/Out Of Stock)</option>
                  <option value="in stock"<?php echo$r['stockStatus']=='in stock'?' selected':'';?>>In Stock</option>
                  <option value="out of stock"<?php echo$r['stockStatus']=='out of stock'?' selected':'';?>>Out Of Stock</option>
                  <option value="pre-order"<?php echo$r['stockStatus']=='pre-order'?' selected':'';?>>Pre-Order</option>
                  <option value="available"<?php echo$r['stockStatus']=='available'?' selected':'';?>>Available</option>
                  <option value="sold out"<?php echo$r['stockStatus']=='sold out'?' selected':'';?>>Sold Out</option>
                  <option value="none"<?php echo($r['stockStatus']=='none'||$r['stockStatus']=='')?' selected':'';?>>No Display</option>
                </select>
              </div>
              <label for="weight">Weight</label>
              <div class="form-row">
                <input class="textinput" id="weight" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="weight" type="text" value="<?php echo $r['weight'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Weight..."':' readonly';?>>
                <select id="weightunit" onchange="update('<?php echo$r['id'];?>','content','weightunit',$(this).val());"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Weight Unit"':' disabled';?>>
                  <option value="mg"<?php echo$r['weightunit']=='mg'?' selected':'';?>>Milligrams (mg)</option>
                  <option value="g"<?php echo$r['weightunit']=='g'?' selected':'';?>>Grams (g)</option>
                  <option value="kg"<?php echo$r['weightunit']=='kg'?' selected':'';?>>Kilograms (kg)</option>
                  <option value="lb"<?php echo$r['weightunit']=='lb'?' selected':'';?>>Pound (lb)</option>
                  <option value="t"<?php echo$r['weightunit']=='t'?' selected':'';?>>Tonne (t)</option>
                </select>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveweight" data-tooltip="tooltip"  data-dbid="weight" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="Size">Size</label>
              <div class="row">
                <div class="col-12 col-md-4 pr-md-2">
                  <div class="form-row">
                    <div class="input-text">Width</div>
                    <input class="textinput" id="width" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="width" type="text" value="<?php echo $r['width'];?>"<?php echo$user['options'][1]==1?' placeholder="Width"':' readonly';?>>
                    <select id="widthunit"<?php echo$user['options'][1]==1?'  data-tooltip="tooltip" aria-label="Change Width Unit"':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','widthunit',$(this).val());">
                      <option value="um"<?php echo$r['widthunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                      <option value="mm"<?php echo$r['widthunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                      <option value="cm"<?php echo$r['widthunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                      <option value="in"<?php echo$r['widthunit']=='in'?' selected':'';?>>Inch (in)</option>
                      <option value="ft"<?php echo$r['widthunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                      <option value="m"<?php echo$r['widthunit']=='m'?' selected':'';?>>Metre (m)</option>
                      <option value="km"<?php echo$r['widthunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                      <option value="mi"<?php echo$r['widthunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                      <option value="nm"<?php echo$r['widthunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                      <option value="yard"<?php echo$r['widthunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                    </select>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savewidth" data-dbid="width" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-md-4 pr-md-2">
                  <div class="form-row">
                    <div class="input-text">Height</div>
                    <input class="textinput" id="height" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="height"<?php echo$user['options'][1]==1?' placeholder="Height"':' readonly';?> type="text" value="<?php echo $r['height'];?>">
                    <select id="heightunit"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Height Unit"':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','heightunit',$(this).val());">
                      <option value="um"<?php echo$r['heightunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                      <option value="mm"<?php echo$r['heightunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                      <option value="cm"<?php echo$r['heightunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                      <option value="in"<?php echo$r['heightunit']=='in'?' selected':'';?>>Inch (in)</option>
                      <option value="ft"<?php echo$r['heightunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                      <option value="m"<?php echo$r['heightunit']=='m'?' selected':'';?>>Metre (m)</option>
                      <option value="km"<?php echo$r['heightunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                      <option value="mi"<?php echo$r['heightunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                      <option value="nm"<?php echo$r['heightunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                      <option value="yard"<?php echo$r['heightunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                    </select>
                    <?php echo$user['options'][1]==1?'<button class="save" id="saveheight" data-tooltip="tooltip" data-dbid="height" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="form-row">
                    <div class="input-text">Length</div>
                    <input class="textinput" id="length" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="length" type="text" value="<?php echo$r['length'];?>"<?php echo$user['options'][1]==1?' placeholder="Length"':' readonly';?>>
                    <select id="lengthunit"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Length Unit"':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','lengthunit',$(this).val());">
                      <option value="um"<?php echo$r['lengthunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                      <option value="mm"<?php echo$r['lengthunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                      <option value="cm"<?php echo$r['lengthunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                      <option value="in"<?php echo$r['lengthunit']=='in'?' selected':'';?>>Inch (in)</option>
                      <option value="ft"<?php echo$r['lengthunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                      <option value="m"<?php echo$r['lengthunit']=='m'?' selected':'';?>>Metre (m)</option>
                      <option value="km"<?php echo$r['lengthunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                      <option value="mi"<?php echo$r['lengthunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                      <option value="nm"<?php echo$r['lengthunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                      <option value="yard"<?php echo$r['lengthunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                    </select>
                    <?php echo$user['options'][1]==1?'<button class="save" id="savelength" data-tooltip="tooltip" data-dbid="length" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                  </div>
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
                        ':t'=>'content',
                        ':c'=>'notes'
                      ]);
                      echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=notes" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb','text-success').'</button>':'';
                    }
                    echo'<button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=content" data-type="content" data-tooltip="tooltip" aria-label="SEO Content Information">'.svg2('seo').'</button>'.
                    '<button data-tooltip="tooltip" aria-label="Show Element Blocks" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;">'.svg2('blocks').'</button>'.
                    '<input class="col-1" id="ipsumc" value="5">'.
                    '<button data-tooltip="tooltip" aria-label="Add Aussie Lorem Ipsum" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;">'.svg2('loremipsum').'</button>'.
                    '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=notes" data-tooltip="tooltip" aria-label="Add Suggestions">'.svg2('idea').'</button>'.
                  '</div>'.
                '</div>';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
                <form id="summernote" target="sp" method="post" action="core/update.php" enctype="multipart/form-data">
                  <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                  <input name="t" type="hidden" value="content">
                  <input name="c" type="hidden" value="notes">
                  <div class="<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='proofs'?'note-admin ':'').$r['contentType'];?>">
                    <textarea class="summernote" id="notes" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
                  </div>
                </form>
              <?php }else{?>
                <div class="<?php echo($r['contentType']=='article'?'note-admin ':'').$r['contentType'];?>">
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
            <div class="form-text small text-muted">Edited: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
          </div>
<?php /* Images */ ?>
          <div class="tab1-2 border-top p-3" role="tabpanel">
            <div id="error"></div>
            <?php if($r['contentType']=='testimonials'){?>
              <div class="alert alert-info<?php echo$r['cid']==0?' hidden':'';?>" id="tstavinfo" role="alert">Currently using the Avatar associated with the selected Client Account.</div>
              <?php if($user['options'][1]==1){?>
                <form target="sp" method="post" action="core/add_data.php" enctype="multipart/form-data">
                  <label for="avatar">Avatar</label>
                  <div class="form-row">
                    <input id="av" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="avatar" type="text" value="<?php echo$r['file'];?>" readonly>
                    <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                    <input name="act" type="hidden" value="add_tstavatar">
                    <div class="btn custom-file" data-tooltip="tooltip" aria-label="Browse Computer for Image">
                      <input class="custom-file-input hidden" id="avatarfu" type="file" name="fu" onchange="form.submit()">
                      <label for="avatarfu"><?php svg('browse-computer');?></label>
                    </div>
                    <img id="tstavatar" src="<?php echo$r['file']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['file']))?'media'.DS.'avatar'.DS.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar">
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate('<?php echo$r['id'];?>','content','file','');"><?php svg('trash');?></button>
                  </div>
                </form>
              <?php }else{?>
                <label for="avatar">Avatar</label>
                <div class="form-row">
                  <input id="av" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="avatar" type="text" value="<?php echo$r['file'];?>" readonly>
                  <img id="tstavatar" src="<?php echo$r['file']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['file']))?'media'.DS.'avatar'.DS.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar">
                </div>
              <?php }?>
          <?php }
          if($r['contentType']!='testimonials'){?>
            <label for="fileURL">URL</label>
            <div class="form-row">
                <input class="textinput" id="fileURL" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileURL" type="text" value="<?php echo$r['fileURL'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                <?php echo$r['fileURL']!=''?'<a data-fancybox="url" href="'.$r['fileURL'].'"><img id="urlimage" src="'.$r['fileURL'].'"></a>':'<img id="urlimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                <?php echo$user['options'][1]==1?'<button class="save" id="savefileURL" data-tooltip="tooltip" data-dbid="fileURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="file">Image</label>
              <div class="form-row">
                <input class="textinput" id="file" type="text" value="<?php echo$r['file'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="file" readonly>
                <?php if($user['options'][1]==1){?>
                  <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?php echo$r['id'];?>','content','file');"><?php svg('browse-media');?></button>
                <?php }
                echo$r['file']!=''&&file_exists('media'.DS.basename($r['file']))?'<a data-fancybox="'.$r['contentType'].$r['id'].'" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img id="fileimage" src="'.$r['file'].'" alt="'.$r['contentType'].': '.$r['title'].'"></a>':'<img id="fileimage" src="'.ADMINNOIMAGE.'" alt="No Image">';
                echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`file`,``);">'.svg2('trash').'</button>'.
                '<button class="save" id="savefile" data-tooltip="tooltip" data-dbid="file" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <div class="form-row mt-3">
                <input id="options2" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="2" type="checkbox"<?php echo($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="options2">&nbsp;&nbsp;Enable Panorama</label>
              </div>
              <div class="form-row">
                <input id="options3" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="3" type="checkbox"<?php echo($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="options3">&nbsp;&nbsp;Enable&nbsp;360&nbsp;Viewer</label>
                <small class="form-text text-right">Enable 360 Viewer before uploading image to avoid auto-resizing.</small>
              </div>
              <label for="thumb">Thumbnail</label>
              <div class="form-row">
                <input class="textinput" id="thumb" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="thumb" type="text" value="<?php echo$r['thumb'];?>">
                <?php if($user['options'][1]==1){?>
                  <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?php echo$r['id'];?>','content','thumb');"><?php svg('browse-media');?></button>
                <?php }
                echo$r['thumb']!=''&&file_exists('media'.DS.'thumbs'.DS.basename($r['thumb']))?'<a data-fancybox="thumb'.$r['id'].'" data-caption="Thumbnail: '.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['thumb'].'"><img id="thumbimage" src="'.$r['thumb'].'" alt="Thumbnail: '.$r['title'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';
                echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`thumb`,``);">'.svg2('trash').'</button>'.
                '<button class="save" id="savethumb" data-tooltip="tooltip" data-dbid="thumb" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifFilename">Image ALT</label>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=alt" data-type="alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><?php svg('seo');?></button>
                <input class="textinput" id="fileALT" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileALT" type="text" value="<?php echo$r['fileALT'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an Image ALT Text..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="savefileALT" data-tooltip="tooltip" aria-label="Save" data-dbid="fileALT" data-style="zoom-in">'.svg2('save').'</button>':'';?>
              </div>
              <label for="coverVideo">Video URL</label>
              <div class="form-row">
                <input class="textinput" id="videoURL" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="videoURL" type="text" value="<?php echo$r['videoURL'];?>">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`videoURL`);">'.svg2('browse-media').'</button>'.
                '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`content`,`videoURL`,``);">'.svg2('trash').'</button>'.
                '<button class="save" id="savevideoURL" data-tooltip="tooltip" data-dbid="videoURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <div class="row mt-3">
                <input id="options4" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="4" type="checkbox"<?php echo$r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="options4">AutoPlay Video</label>
              </div>
              <div class="row">
                <input id="options5" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="5" type="checkbox"<?php echo$r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="options5">Loop Video</label>
              </div>
              <div class="row">
                <input id="options6" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="6" type="checkbox"<?php echo$r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                <label for="options6">Show Controls</label>
              </div>
              <legend class="mt-3">EXIF Information</legend>
              <div class="form-row">
                <label for="exifFilename">Original&nbsp;Filename</label>
                <?php echo$user['options'][1]==1?'<small class="form-text text-right">Using the "Magic Wand" button will attempt to get the EXIF Information embedded in the Uploaded Image.</small>':'';?>
              </div>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifFilename`);">'.svg2('magic').'</button>':'';?>
                <input class="textinput" id="exifFilename" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFilename" type="text" value="<?php echo$r['exifFilename'];?>"<?php echo$user['options'][1]==1?' placeholder="Original Filename..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifFilename" data-tooltip="tooltip" data-dbid="exifFilename" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifCamera">Camera</label>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifCamera`);">'.svg2('magic').'</button>':'';?>
                <input class="textinput" id="exifCamera" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifCamera" type="text" value="<?php echo$r['exifCamera'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Camera"':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifCamera" data-tooltip="tooltip" data-dbid="exifCamera" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifLens">Lens</label>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifLens`);">'.svg2('magic').'</button>':'';?>
                <input type="text" id="exifLens" class="textinput" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifLens"<?php echo$user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifLens" data-tooltip="tooltip" data-dbid="exifLens" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifAperture">Aperture</label>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifAperture`);">'.svg2('magic').'</button>':'';?>
                <input class="textinput" id="exifAperture" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifAperture" type="text" value="<?php echo$r['exifAperture'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifAperture" data-tooltip="tooltip" data-dbid="exifAperture" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifFocalLength">Focal Length</label>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifFocalLength`);">'.svg2('magic').'</button>':'';?>
                <input class="textinput" id="exifFocalLength" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFocalLength" type="text" value="<?php echo$r['exifFocalLength'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifFocalLength" data-tooltip="tooltip" data-dbid="exifFocalLength" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifShutterSpeed">Shutter Speed</label>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifShutterSpeed`);">'.svg2('magic').'</button>':'';?>
                <input class="textinput" id="exifShutterSpeed" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifShutterSpeed" type="text" value="<?php echo$r['exifShutterSpeed'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifShutterSpeed" data-tooltip="tooltip" data-dbid="exifShutterSpeed" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifISO">ISO</label>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifISO`);">'.svg2('magic').'</button>':'';?>
                <input class="textinput" id="exifISO" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifISO" type="text" value="<?php echo$r['exifISO'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifISO" data-tooltip="tooltip" data-dbid="exifISO" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="exifti">Taken</label>
              <div class="form-row">
                <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifti`);">'.svg2('magic').'</button>':'';?>
                <input class="textinput" id="exifti" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifti" type="text" value="<?php echo$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>"<?php echo$user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveexifti" data-tooltip="tooltip" data-dbid="exifti" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <legend class="mt-3">Image Attribution</legend>
              <label for="attributionImageTitle">Title</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageTitle" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" type="text" value="<?php echo$r['attributionImageTitle'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                <?php echo$user['options'][1]==1?'<button class="save" id="saveattributionImageTitle" data-tooltip="tooltip" data-dbid="attributionImageTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="attributionImageName">Name</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageName" list="attributionImageName_option" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageName" type="text" value="<?php echo$r['attributionImageName'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                <?php if($user['options'][1]==1){
                  $s=$db->query("SELECT DISTINCT `attributionImageName` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` AS name FROM login ORDER BY `name` ASC");
                  if($s->rowCount()>0){
                    echo'<datalist id="attributionImageName_option">';
                    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
                    echo'</datalist>';
                  }
                }
                echo$user['options'][1]==1?'<button class="save" id="saveattributionImageName" data-tooltip="tooltip" data-dbid="attributionImageName" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
              <label for="attributionImageURL">URL</label>
              <div class="form-row">
                <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL" type="text" value="<?php echo$r['attributionImageURL'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                <?php if($user['options'][1]==1){
                  $s=$db->query("SELECT DISTINCT `attributionImageURL` AS url FROM `".$prefix."content` ORDER BY `attributionImageURL` ASC");
                  if($s->rowCount()>0){
                    echo'<datalist id="attributionImageURL_option">';
                    while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';
                    echo'</datalist>';
                  }
                }
                echo$user['options'][1]==1?'<button class="save" id="saveattributionImageURL" data-tooltip="tooltip" data-dbid="attributionImageURL" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
              </div>
          <?php }?>
          </div>
<?php /* Media */ ?>
          <?php if($r['contentType']!='testimonials'){?>
          <div class="tab1-3 border-top p-3" role="tabpanel">
            <?php if($user['options'][1]==1){?>
              <form class="form-row" target="sp" method="post" action="core/add_media.php" enctype="multipart/form-data">
                <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                <input name="rid" type="hidden" value="<?php echo$r['id'];?>">
                <input name="t" type="hidden" value="content">
                <input id="mediafile" name="fu" type="text" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?php echo$r['id'];?>','media','mediafile');return false;"><?php svg('browse-media');?></button>
                <button class="add" data-tooltip="tooltip" aria-label="Add" type="submit"><?php svg('add');?></button>
              </form>
            <?php }?>
            <div class="row mt-3" id="mi">
              <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `pid`=:id ORDER BY `ord` ASC");
              $sm->execute([
                ':id'=>$r['id']
              ]);
              if($sm->rowCount()>0){
                while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                  if(file_exists('media/md/'.basename($rm['file'])))
                    $thumb='media/md/'.basename($rm['file']);
                  else
                    $thumb=ADMINNOIMAGE;?>
                  <div class="card stats col-6 col-md-3 m-1" id="mi_<?php echo$rm['id'];?>">
                    <?php if($user['options'][1]==1){?>
                      <div class="btn-group float-right">
                        <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item"><?php svg('drag');?></div>
                        <div class="btn" data-tooltip="tooltip" aria-label="Viewed <?php echo$rm['views'];?> times"><?php svg('view');echo' '.$rm['views'];?></div>
                        <a class="btn" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/media/edit/'.$rm['id'];?>" aria-label="Edit"><?php svg('edit');?></a>
                        <button class="btn trash" onclick="purge('<?php echo$rm['id'];?>','media')" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
                      </div>
                    <?php }?>
                    <a data-fancybox="media" data-type="image" data-caption="<?php echo($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?php echo$rm['file'];?>">
                      <img src="<?php echo$thumb;?>" alt="Media <?php echo$rm['id'];?>">
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
        <?php }?>
<?php /* Options */ ?>
          <div class="tab1-4 border-top p-3" role="tabpanel">
            <?php if($user['options'][1]==1){?>
              <form target="sp" method="post" action="core/add_option.php">
                <input name="rid" type="hidden" value="<?php echo$r['id'];?>">
                <div class="form-row">
                  <div class="input-text">Option</div>
                  <input name="ttl" type="text" value="" placeholder="Title">
                  <div class="input-text">Quantity</div>
                  <input name="qty" type="text" value="" placeholder="Quantity">
                  <button class="add" data-tooltip="tooltip" aria-label="Add"><?php svg('add');?></button>
                </div>
              </form>
            <?php }?>
            <div id="itemoptions">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:rid ORDER BY `title` ASC");
              $ss->execute([
                ':rid'=>$r['id']
              ]);
              if($ss->rowCount()>0){
                while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                  <div class="form-row mt-1" id="l_<?php echo $rs['id'];?>">
                    <div class="input-text">Option</div>
                    <input type="text" value="<?php echo$rs['title'];?>"<?php echo$user['options'][1]==1?' onchange="update(`'.$rs['id'].'`,`choices`,`title`,$(this).val());" placeholder="Title"':' readonly';?>>
                    <div class="input-text">Quantity</div>
                    <input type="text" value="<?php echo$rs['ti'];?>"<?php echo$user['options'][1]==1?' onchange="update(`'.$rs['id'].'`,`choices`,`ti`,$(this).val());" placeholder="Quantity"':' readonly';?>>
                    <?php if($user['options'][1]==1){?>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
                      </form>
                    <?php }?>
                  </div>
                <?php }
              }?>
            </div>
          </div>
<?php /* Comments */ ?>
          <div class="tab1-5 border-top p-3" role="tabpanel">
            <div class="row mt-3">
              <input id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1" type="checkbox"<?php echo($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
              <label for="options1">Enable</label>
            </div>
            <div class="mt-3" id="comments">
              <?php $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`=:contentType AND `rid`=:rid ORDER BY `ti` ASC");
              $sc->execute([
                ':contentType'=>$r['contentType'],
                ':rid'=>$r['id']
              ]);
              if($user['options']{1}==1){
                while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                  <div class="row p-2 mt-1<?php echo$rc['status']=='unapproved'?' danger':'';?>" id="l_<?php echo$rc['id'];?>">
                    <?php $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                    $su->execute([
                      ':id'=>$rc['uid']
                    ]);
                    $ru=$su->fetch(PDO::FETCH_ASSOC);?>
                    <div class="col-1">
                      <img style="max-width:64px;height:64px;" src="<?php if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))echo'media'.DS.'avatar'.DS.$ru['avatar'];elseif($ru['gravatar']!='')echo md5($ru['gravatar']);else echo ADMINNOAVATAR;?>" alt="<?php echo$rc['name'];?>">
                    </div>
                    <div class="col-9">
                      <h6>Name: <?php echo$rc['name']==''?'Anonymous':$rc['name'].' &lt;'.$rc['email'].'&gt;';?></h6>
                      <time class="small"><?php echo date($config['dateFormat'],$rc['ti']);?></time><br>
                      <?php echo strip_tags($rc['notes']);?>
                    </div>
                    <?php if($user['options'][1]==1){?>
                      <div class="col-2 text-right align-top" id="controls-<?php echo$rc['id'];?>">
                        <?php $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                        $scc->execute([
                          ':ip'=>$rc['ip']
                        ]);
                        if($scc->rowCount()<1){?>
                          <form class="d-inline-block" id="blacklist<?php echo$rc['id'];?>" target="sp" method="post" action="core/add_commentblacklist.php">
                            <input name="id" type="hidden" value="<?php echo$rc['id'];?>">
                            <button data-tooltip="tooltip" aria-label="Add IP to Blacklist"><?php echo svg2('security');?></button>
                          </form>
                        <?php   }?>
                        <button class="add<?php echo$rc['status']!='unapproved'?' hidden':'';?>" id="approve_<?php echo$rc['id'];?>" data-tooltip="tooltip" onclick="update('<?php echo$rc['id'];?>','comments','status','approved');" aria-label="Approve"><?php svg('approve');?></button>
                        <button class="trash" data-tooltip="tooltip" onclick="purge('<?php echo$rc['id'];?>','comments');" aria-label="Delete"><?php svg('trash');?></button>
                      </div>
                    <?php }?>
                    <hr>
                  </div>
                <?php }
              }?>
            </div>
            <?php if($user['options'][1]==1){?>
              <iframe class="hidden" id="comments" name="comments"></iframe>
              <form target="comments" method="post" action="core/add_data.php">
                <input name="act" type="hidden" value="add_comment">
                <input name="rid" type="hidden" value="<?php echo$r['id'];?>">
                <input name="contentType" type="hidden" value="<?php echo$r['contentType'];?>">
                <label for="commentemail">Email</label>
                <div class="form-row">
                  <input id="commentemail" name="email" type="text" value="<?php echo$user['email'];?>">
                </div>
                <label for="commentname">Name</label>
                <div class="form-row">
                  <input id="commentname" name="name" type="text" value="<?php echo$user['name'];?>">
                </div>
                <label for="commentda">Comment</label>
                <div class="form-row">
                  <textarea id="commentda" name="da" placeholder="Enter a Comment..." required></textarea>
                </div>
                <div class="form-row">
                  <button class="btn-block add" aria-label="Add Comment');?>">Add Comment</button>
                </div>
              </form>
            <?php }?>
          </div>
<?php /* Reviews */ ?>
          <div class="tab1-6 border-top p-3" role="tabpanel">
            <?php $sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid ORDER BY `ti` DESC");
            $sr->execute([
              ':rid'=>$r['id']
            ]);
            if($sr->rowCount()>0){
              while($rr=$sr->fetch(PDO::FETCH_ASSOC)){?>
                <div class="media<?php echo$rr['status']=='unapproved'?' danger':'';?>" id="l_<?php echo$rr['id'];?>">
                  <div class="media-body well p-1 p-sm-3 border-top border-dark">
                    <?php if($user['options'][1]==1){?>
                      <div class="btn-group float-right" id="controls-<?php echo$rr['id'];?>" role="group">
                        <button class="<?php echo$rr['status']=='approved'?' hidden':'';?>" id="approve_<?php echo$rr['id'];?>" data-tooltip="tooltip" onclick="update('<?php echo$rr['id'];?>','comments','status','approved');" aria-label="Approve"><?php svg('approve');?></button>
                        <button class="trash" data-tooltip="tooltip" onclick="purge('<?php echo$rr['id'];?>','comments');" aria-label="Delete"><?php svg('trash');?></button>
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
<?php /* Related */ ?>
        <?php if($r['contentType']=='article'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
          <div class="tab1-7 border-top p-3" role="tabpanel">
            <?php if($user['options'][1]==1){?>
              <form target="sp" method="post" action="core/add_related.php">
                <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                <?php $sr=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`!=:id AND `contentType`='article' OR `contentType`='inventory' OR `contentType`='service' ORDER BY `contentType` ASC, `title` ASC");
                $sr->execute([
                  ':id'=>$r['id']
                ]);
                if($sr->rowCount()>0){?>
                  <div class="form-row">
                    <select id="schemaType" name="rid"<?php echo$user['options'][1]==1?' data-tooltip="tooltip"':' disabled';?> aria-label="Select a Content Item to Relate to this one...">
                      <option value="0">Select a Content Item to Relate to this one...</option>
                      <?php while($rr=$sr->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rr['id'].'">'.$rr['contentType'].': '.$rr['title'].'</option>';?>
                      </select>
                      <button class="add" data-tooltip="tooltip" aria-label="Add"><?php svg('add');?></button>
                    </div>
                <?php }?>
              </form>
            <?php }?>
            <div id="relateditems">
              <?php $sr=$db->prepare("SELECT `id`,`rid` FROM `".$prefix."choices` WHERE `uid`=:id AND `contentType`='related' ORDER BY `ti` ASC");
              $sr->execute([
                ':id'=>$r['id']
              ]);
              while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
                $si=$db->prepare("SELECT `contentType`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                $si->execute([
                  ':id'=>$rr['rid']
                ]);
                $ri=$si->fetch(PDO::FETCH_ASSOC);?>
                <div class="form-row mt-1" id="l_<?php echo $rr['id'];?>">
                  <input type="text" value="<?php echo ucfirst($ri['contentType']).': '.$ri['title'];?>" readonly>
                  <?php if($user['options'][1]==1){?>
                    <form target="sp" action="core/purge.php">
                      <input name="id" type="hidden" value="<?php echo$rr['id'];?>">
                      <input name="t" type="hidden" value="choices">
                      <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
                    </form>
                  <?php }?>
                </div>
              <?php }?>
            </div>
          </div>
        <?php }?>
<?php /* SEO */ ?>
        <?php if($r['contentType']!='testimonials'&&$r['contentType']!='proofs'){?>
          <div class="tab1-8 border-top p-3" role="tabpanel">
            <label for="views">Views</label>
            <div class="form-row">
              <input class="textinput" id="views" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views" type="number" value="<?php echo$r['views'];?>"<?php echo$user['options'][1]==1?'':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`content`,`views`,`0`);">'.svg2('eraser').'</button>'.
              '<button class="save" id="saveviews" data-tooltip="tooltip" data-dbid="views" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label for="metaRobots">Meta&nbsp;Robots</label>
              <?php if($user['options'][1]==1){?>
                <small class="form-text text-right">Options for Meta Robots: <span data-tooltip="left" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></small>
              <?php }?>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metarobots" data-tooltip="tooltip" aria-label="SEO Meta Robots Information"><?php svg('seo');?></button>
              <?php if($user['options'][1]==1){
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'content',
                    ':c'=>'metaRobots'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=metaRobots" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                }
              }?>
              <input class="textinput" id="metaRobots" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="metaRobots" type="text" value="<?php echo$r['metaRobots'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=metaRobots" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="savemetaRobots" data-tooltip="tooltip" data-dbid="metaRobots" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label for="schemaType">Schema Type</label>
            <div class="form-row">
              <select id="schemaType"<?php echo$user['options'][1]==1?' data-tooltip="tooltip"':' disabled';?> aria-label="Schema for Microdata Content" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());">
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
            <div class="card google-result mt-3 p-3 overflow-visible">
              <div id="google-title" data-tooltip="left" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below the information is then tried to be used from the Pages Meta Title, if that is empty then an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                <?php echo($r['seoTitle']!=''?$r['seoTitle']:$r['title']).' | '.$config['business'];?>
              </div>
              <div id="google-link">
                <?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?>
              </div>
              <div id="google-description" data-tooltip="left" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, the page Meta Description will be used, if that is empty a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                <?php if($r['seoDescription']!='')
                  echo$r['seoDescription'];
                else
                  echo$config['seoDescription'];?>
              </div>
            </div>
            <div class="form-row mt-3">
              <label for="seoTitle">Meta&nbsp;Title</label>
              <small class="form-text text-right">The recommended character count for Title\'s is 70.</small>
            </div>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title" data-tooltip="tooltip" aria-label="SEO Title Information"><?php svg('seo');?></button>
              <?php $cntc=70-strlen($r['seoTitle']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text">
                <span class="text-success<?php echo$cnt<0?' text-danger':'';?>" id="seoTitlecnt"><?php echo$cnt;?></span>
              </div>
              <?php if($user['options'][1]==1){?>
                <button data-tooltip="tooltip" aria-label="Remove Stop Words" onclick="removeStopWords('seoTitle',$('#seoTitle').val());"><?php svg('magic');?></button>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'content',
                    ':c'=>'seoTitle'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=seoTitle" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                }
              }?>
              <input class="textinput" id="seoTitle" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoTitle" type="text" value="<?php echo$r['seoTitle'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Title..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=seoTitle" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoTitle" data-tooltip="tooltip" data-dbid="seoTitle" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="form-row mt-3">
              <label for="seoCaption">Meta&nbsp;Caption</label>
              <small class="form-text text-right">The recommended character count for Captions is 100.</small>
            </div>
            <div class="form-row mt-3">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metacaption" data-tooltip="tooltip" aria-label="SEO Meta Caption Information"><?php svg('seo');?></button>
              <?php $cntc=100-strlen($r['seoCaption']);
              if($cntc<0){
                $cnt=abs($cntc);
                $cnt=number_format($cnt)*-1;
              }else
                $cnt=number_format($cntc);?>
              <div class="input-text">
                <span class="text-success<?php echo($cnt<0?' text-danger':'');?>" id="seoCaptioncnt"><?php echo$cnt;?></span>
              </div>
              <?php if($user['options'][1]==1){
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'content',
                    ':c'=>'seoCaption'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=seoCaption" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                }
              }?>
              <input class="textinput" id="seoCaption" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoCaption" type="text" value="<?php echo$r['seoCaption'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Caption..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=seoCaption" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
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
              <div class="input-text">
                <span class="text-success<?php echo($cnt<0?' text-danger':'');?>" id="seoDescriptioncnt"><?php echo$cnt;?></span>
              </div>
              <?php if($user['options'][1]==1){
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'content',
                    ':c'=>'seoDescription'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=seoDescription" data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb').'</button>':'';
                }
              }?>
              <input class="textinput" id="seoDescription" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoDescription" type="text" value="<?php echo$r['seoDescription'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter a Meta Description..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=seoDescription" data-tooltip="tooltip" aria-label="Add Suggestion">'.svg2('idea').'</button>'.
              '<button class="save" id="saveseoDescription" data-tooltip="tooltip" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label for="seoKeywords">Keywords</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=keywords" data-tooltip="tooltip" aria-label="SEO Keywords Information"><?php svg('seo');?></button>
              <input class="textinput" id="seoKeywords" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoKeywords" type="text" value="<?php echo$r['seoKeywords'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter Keywords..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button class="save" id="saveseoKeywords" data-tooltip="tooltip" data-dbid="seoKeywords" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label for="tags">Tags</label>
            <div class="form-row">
              <input class="textinput" id="tags" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags" type="text" value="<?php echo$r['tags'];?>"<?php echo$user['options'][1]==1?' placeholder="Enter Tags..."':' readonly';?>>
              <?php echo$user['options'][1]==1?'<button class="save" id="savetags" data-tooltip="tooltip" data-dbid="tags" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        <?php }?>
<?php /* Settings */ ?>
          <div class="tab1-9 border-top p-3" role="tabpanel">
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-1">
                <label for="status">Status</label>
                <div class="form-row">
                  <select id="status"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Status"':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());changeShareStatus($(this).val());">
                    <option value="unpublished"<?php echo$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                    <option value="autopublish"<?php echo$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                    <option value="published"<?php echo$r['status']=='published'?' selected':'';?>>Published</option>
                    <option value="delete"<?php echo$r['status']=='delete'?' selected':'';?>>Delete</option>
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
              <div class="col-12 col-sm-6 pl-md-1">
                <label for="rank">Access</label>
                <div class="form-row">
                  <select id="rank" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rank"<?php echo$user['options'][1]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','rank',$(this).val());">
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
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-1">
                <label for="contentType">contentType</label>
                <div class="form-row">
                  <select id="contentType"<?php echo$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change the Type of Content this Item belongs to."':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());">
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
              <div class="col-12 col-sm-6 pl-md-1">
                <label for="mid">SubMenu</label>
                <div class="form-row">
                  <select id="mid"<?php echo$user['options'][1]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','content','mid',$(this).val());">
                    <option value="0"<?php if($r['mid']==0)echo' selected';?>>None</option>
                    <?php $sm=$db->prepare("SELECT `id`,`title` from `".$prefix."menu` WHERE `mid`=0 AND `mid`!=:mid AND active=1 ORDER BY `ord` ASC, `title` ASC");
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
            <?php if($r['contentType']!='proofs'){?>
              <div class="row mt-3<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs'?' hidden':'';?>">
                <input id="featured0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0" type="checkbox"<?php echo($r['featured'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="featured0">Featured</label>
              </div>
            <?php }?>
            <div class="row mt-3">
              <input id="internal0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0" type="checkbox"<?php echo($r['internal']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
              <label for="internal0">Internal</label>
            </div>
            <?php if($r['contentType']=='service'){?>
              <div class="row">
                <input id="bookable0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0" type="checkbox"<?php echo($r['bookable']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="bookable0">Bookable</label>
              </div>
            <?php }?>
          </div>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
