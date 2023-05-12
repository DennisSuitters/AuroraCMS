<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content - Edit
 * @package    core/layout/edit_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$r=$s->fetch(PDO::FETCH_ASSOC);
$seo=[
  'seoTitle' => '',
  'seoDescription' => '',
  'fileALT' => '',
  'notes' => '',
  'notesHeading' => ''
];
$seoerrors=0;
if($r['contentType']!='testimonials'){
  if($r['seoTitle']==''){
    $seoerrors++;
    $seo['seoTitle']='<br>The <strong><a href="javascript:seoLink(`seoTitle`,`tab1-8`);">Meta Title</a></strong> is empty, while AuroraCMS tries to autofill this entry when building the page, it is better to fill in this information yourself!';
  }elseif(strlen($r['seoTitle'])<50){
    $seoerrors++;
    $seo['seoTitle']='<br>The <strong><a href="javascript:seoLink(`seoTitle`,`tab1-8`);">Meta Title</a></strong> is less than <strong>50</strong> characters!';
  }elseif(strlen($r['seotitle'])>70){
    $seoerrors++;
    $seo['seoTitle']='<br>The <strong><a href="javascript:seoLink(`seoTitle`,`tab1-8`);">Meta Title</a></strong> is longer than <strong>70</strong> characters!';
  }
  if($r['seoDescription']==''){
    $seoerrors++;
    $seo['seoDescription']='<br> The <strong><a href="javascript:seoLink(`seoDescription`,`tab1-8`);">Meta Description</a></strong> is empty, while AuroraCMS tries to autofill this entry when building the page, it is better to fill in this information yourself!';
  }elseif(strlen($r['seoDescription'])<1){
    $seoerrors++;
    $seo['seoDescription']='<br>The <strong><a href="javascript:seoLink(`seoDescription`,`tab1-8`);">Meta Description</a></strong> is empty!';
  }elseif(strlen($r['seoDescription'])>160){
    $seoerrors++;
    $seo['seoDescription']='<br>The <strong><a href="javascript:seoLink(`seoDescription`,`tab1-8`);">Meta Description</a></strong> is longer than <strong>160</strong> characters!';
  }
  if(strlen($r['fileALT'])<1){
    $seoerrors++;
    $seo['fileALT']='<br>The <strong><a href="javascript:seoLink(`fileALT`,`tab1-2`);">Image ALT</a></strong> text is empty!';
  }
  if(strlen(strip_tags($r['notes']))<100){
    $seoerrors++;
    $seo['notes']='<br>The <strong><a href="javascript:seoLink(`notesda`,`tab1-1`);">Description</a></strong> is empty. At least <strong>100</strong> characters is recommended!';
  }
  preg_match('~<h1>([^{]*)</h1>~i',$r['notes'],$h1);
  if(isset($h1[1])){
    $seoerrors++;
    $seo['notesHeading']='<br>Do not use <strong>H1</strong> headings in the <strong><a href="javascript:seoLink(`notesda`,`tab1-1`);">Description</a></strong> Text, as AuroraCMS uses the <strong>Title</strong> Field to place H1 headings on page, and uses them for other areas for SEO!';
  }
}?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="row">
        <div class="card col-12 col-sm mt-3 bg-transparent border-0 overflow-visible order-2 order-sm-1">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-6">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
                  <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content/type/'.$r['contentType'];?>"><?= ucfirst($r['contentType']).(in_array($r['contentType'],array('article'))?'s':'');?></a></li>
                  <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                  <li class="breadcrumb-item active"><?=$r['title'];?></li>
                </ol>
              </div>
              <div class="col-12 col-sm-6 text-right">
                <div class="btn-group">
                  <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                  '<button class="'.($r['status']=='published'?'':'hidden').'" data-social-share="'.URL.$r['contentType'].'/'.$r['urlSlug'].'" data-social-desc="'.($r['seoDescription']?$r['seoDescription']:$r['title']).'" data-tooltip="left" aria-label="Share on Social Media"><i class="i">share</i></button>'.
                  ($user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/add/'.$r['contentType'].'" role="button" data-tooltip="left" aria-label="Add '.ucfirst($r['contentType']).'"><i class="i">add</i></a>':'').
                  ($user['options'][1]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="tabs" role="tablist">
            <?=($seoerrors>0?'<div class="alert alert-warning">There are <strong>'.$seoerrors.'</strong> things that could affect the SEO of this content!!! (Each item is highlighted.)'.
              $seo['notesHeading'].
              $seo['notes'].
              $seo['fileALT'].
              $seo['seoTitle'].
              $seo['seoDescription'].
            '</div>':'').
            '<input class="tab-control" id="tab1-1" name="tabs" type="radio" checked><label for="tab1-1">Content</label>'.
            '<input class="tab-control" id="tab1-2" name="tabs" type="radio"><label for="tab1-2">Images</label>'.
            ($r['contentType']!='testimonials'?'<input class="tab-control" id="tab1-3" name="tabs" type="radio"><label for="tab1-3">Media</label>':'').
            ($r['contentType']=='inventory'?'<input class="tab-control" id="tab1-4" name="tabs" type="radio"><label for="tab1-4">Options</label>':'').
            ($r['contentType']=='article'?'<input class="tab-control" id="tab1-5" name="tabs" type="radio"><label for="tab1-5">Comments</label>':'').
            ($r['contentType']=='inventory'||$r['contentType']=='service'?'<input class="tab-control" id="tab1-6" name="tabs" type="radio"><label for="tab1-6">Reviews</label>':'').
            ($r['contentType']=='article'||$r['contentType']=='inventory'||$r['contentType']=='service'?'<input class="tab-control" id="tab1-7" name="tabs" type="radio"><label for="tab1-7">Related</label>':'').
            ($r['contentType']!='testimonials'&&$r['contentType']!='proofs'?'<input class="tab-control" id="tab1-8" name="tabs" type="radio"><label for="tab1-8" id="seo">SEO</label>':'').
            '<input class="tab-control" id="tab1-9" name="tabs" type="radio"><label for="tab1-9">Settings</label>'.
            ($r['contentType']=='events'?'<input class="tab-control" id="tab1-10" name="tabs" type="radio"><label for="tab1-10">Bookings</label>':'').
            ($r['contentType']!='testimonials'?'<input class="tab-control" id="tab1-11" name="tabs" type="radio"><label for="tab1-11">Template</label>':'').
            ($r['contentType']=='inventory'?'<input class="tab-control" id="tab1-12" name="tabs" type="radio"><label for="tab1-12">Purchases</label>':'').
            ($r['contentType']=='article'?'<input class="tab-control" id="tab1-13" name="tabs" type="radio"><label for="tab1-13">List</label>':'');
/* Content */?>
            <div class="tab1-1 border p-4" data-tabid="tab1-1" role="tabpanel">
              <div class="form-row">
                <label id="<?=$r['contentType'];?>Title" for="title"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Title" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Title Field">&#128279;</a>':'';?>Title</label>
                <small class="form-text text-right">Content MUST contain a Title, to be able to generate a URL Slug or the content won't be accessible. This Title is also used For H1 Headings on pages.</small>
              </div>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
                <?php if($user['options'][1]==1){
                  $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                  $ss->execute([
                    ':rid'=>$r['id'],
                    ':t'=>'content',
                    ':c'=>'title'
                  ]);
                  echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=title" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                }?>
                <input class="textinput" id="title" type="text" value="<?=$r['title'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="trash" onkeyup="genurl();$('#titleupdate').text($(this).val());"<?=$user['options'][1]==1?' placeholder="Content MUST contain a Title, to be able to generate a URL Slug or the content won\'t be accessible...."':' readonly';?>>
                <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Generate Aussie Lorem Ipsum Title" onclick="ipsuMe(`title`);genurl();$(`#titleupdate`).text($(`#title`).val());$(`#savetitle`).addClass(`btn-danger`);return false;"><i class="i">loremipsum</i></button>'.
                '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=title" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                '<button class="analyzeTitle" data-test="title" data-tooltip="tooltip" aria-label="Analyze Title Text"><i class="i">seo</i></button>'.
                '<button class="save" id="savetitle" data-dbid="title" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?= URL.$r['contentType'];?>/"+slugify(data);
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
              <label id="<?=$r['contentType'];?>URLSlug" for="genurl"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'URLSlug" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' URL Slug">&#128279;</a>':'';?>URL Slug</label>
              <div class="form-row">
                <div class="input-text col-12">
                  <a id="genurl" target="_blank" href="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>"><?= URL.$r['contentType'].'/'.$r['urlSlug'].' <i class="i">new-window</i>';?></a>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-3">
                  <label id="<?=$r['contentType'];?>DateCreated" for="ti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'DateCreated" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Created Date">&#128279;</a>':'';?>Created</label>
                  <div class="form-row">
                    <input id="ti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['ti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`ti`,getTimestamp(`ti`),`select`);"':' readonly';?>>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-3">
                  <label id="<?=$r['contentType'];?>PublishedDate" for="pti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'PublishedDate" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Published Date Field">&#128279;</a>':'';?>Published On <span class="labeldate" id="labeldatepti">(<?= date($config['dateFormat'],$r['pti']);?>)</span></label>
                  <div class="form-row">
                    <input id="pti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['pti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`pti`,getTimestamp(`pti`),`select`);"':' readonly';?>>
                  </div>
                </div>
              </div>
              <?php if($r['contentType']=='proofs'){?>
                <label id="<?=$r['contentType'];?>Client" for="cid"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Client" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Client Field">&#128279;</a>':'';?>Client</label>
                <div class="form-row">
                  <select id="cid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="cid" onchange="update('<?=$r['id'];?>','content','cid',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
                    <option value="0">Select a Client</option>
                    <?php $cs=$db->query("SELECT * FROM `".$prefix."login` ORDER BY name ASC, username ASC");
                    if($cs->rowCount()>0){
                      while($cr=$cs->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$cr['id'].'"'.($r['cid']==$cr['id']?' selected':'').'>'.$cr['username'].':'.$cr['name'].'</option>';
                    }?>
                  </select>
                </div>
              <?php }?>
              <label id="<?=$r['contentType'];?>Author" for="uid"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Author" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Author Field">&#128279;</a>':'';?>Author</label>
              <div class="form-row">
                <select id="uid" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="uid"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','content','uid',$(this).val(),'select');">
                  <?php $su=$db->query("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `username`!='' AND `status`!='delete' ORDER BY `username` ASC, `name` ASC");
                  while($ru=$su->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$ru['id'].'"'.($ru['id']==$r['uid']?' selected':'').'>'.$ru['username'].':'.$ru['name'].'</option>';?>
                </select>
              </div>
              <?php if($r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='list'){?>
                <label id="<?=$r['contentType'];?>Code" for="code"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Code" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Code Field">&#128279;</a>':'';?>Code</label>
                <div class="form-row">
                  <input class="textinput" id="code" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="code" type="text" value="<?=$r['code'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Code..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savecode" data-dbid="code" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              <?php }
              if($r['contentType']=='inventory'){?>
                <div class="row">
                  <div class="col-12 col-sm-6 pr-md-3">
                    <label id="<?=$r['contentType'];?>Barcode" for="barcode"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Barcode" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Barcode Field">&#128279;</a>':'';?>Barcode</label>
                    <div class="form-row">
                      <input class="textinput" id="barcode" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="barcode" type="text" value="<?=$r['barcode'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Barcode..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savebarcode" data-dbid="barcode" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 pl-md-3">
                    <label id="<?=$r['contentType'];?>FCCID" for="fccid"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'FCCID" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' FCCID Field">&#128279;</a>':'';?>FCCID</label>
                    <div class="form-row">
                      <input class="textinput" id="fccid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="fccid" type="text" value="<?=$r['fccid'];?>"<?=$user['options'][1]==1?' placeholder="Enter an FCCID..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savefccid" data-dbid="fccid" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                    <?=$user['options'][1]==1?'<div class="form-text small text-muted float-right"><a target="_blank" href="https://fccid.io/">fccid.io</a> for more information or to look up an FCC ID.</div>':'';?>
                  </div>
                </div>
                <label id="<?=$r['contentType'];?>Brand" for="brand"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Brand" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Brand Field">&#128279;</a>':'';?>Brand</label>
                <div class="form-row">
                  <select id="brand" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="brand"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','content','brand',$(this).val(),'select');">
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
                  <div class="col-12 col-sm-4 pr-md-3">
                    <label id="<?=$r['contentType'];?>Start" for="tis"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Start" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Event Start Date Field">&#128279;</a>':'';?>Event Start <span class="labeldate" id="labeldatetis"><?= $r['tis']>0?date($config['dateFormat'],$r['tis']):'';?></span></label>
                    <div class="form-row">
                      <input id="tis" type="datetime-local" value="<?=$r['tis']!=0?date('Y-m-d\TH:i',$r['tis']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tis`,getTimestamp(`tis`));"':' readonly';?>>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4 pr-md-3">
                    <label id="<?=$r['contentType'];?>End" for="tie"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'End" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' End Date Field">&#128279;</a>':'';?>Event End <span class="labeldate" id="labeldatetie"><?= $r['tie']>0?date($config['dateFormat'],$r['tie']):'';?></span></label>
                    <div class="form-row">
                      <input id="tie" type="datetime-local" value="<?=$r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tie`,getTimestamp(`tie`));"':' readonly';?>>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4 pl-md-3">
                    <label>&nbsp;</label>
                    <div class="form-row">
                      <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'ShowCountdown" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Show Countdown Checkbox">&#128279;</a>':'';?>
                      <input id="<?=$r['contentType'];?>showCountdown" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="3" type="checkbox"<?=($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <label for="<?=$r['contentType'];?>showCountdown" id="contentoptions3<?=$r['id'];?>">&nbsp;Show Countdown</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6 pr-sm-3">
                    <label id="<?=$r['contentType'];?>Address" for="address"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Address" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Address Field">&#128279;</a>':'';?>Address</label>
                    <div class="form-row">
                      <input class="textinput" id="address" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="address" type="text" value="<?=$r['address'];?>"<?=($user['options'][1]==1?' placeholder="Enter an Address..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="saveaddress" data-dbid="address" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label id="<?=$r['contentType'];?>Suburb" for="suburb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Suburb" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Suburb Field">&#128279;</a>':'';?>Suburb</label>
                    <div class="form-row">
                      <input class="textinput" id="suburb" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="suburb" type="text" value="<?=$r['suburb'];?>"<?=($user['options'][1]==1?' placeholder="Enter a Suburb..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savesuburb" data-dbid="suburb" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-3 pr-sm-3">
                    <label id="<?=$r['contentType'];?>City" for="city"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'City" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' City Field">&#128279;</a>':'';?>City</label>
                    <div class="form-row">
                      <input class="textinput" id="city" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="city" type="text" value="<?=$r['city'];?>"<?=($user['options'][1]==1?' placeholder="Enter a City..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savecity" data-dbid="city" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-3 pl-sm-3 pr-sm-3">
                    <label id="<?=$r['contentType'];?>State" for="state"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'State" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' State Field">&#128279;</a>':'';?>State</label>
                    <div class="form-row">
                      <input class="textinput" id="state" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="state" type="text" value="<?=$r['state'];?>"<?=($user['options'][1]==1?' placeholder="Enter a State..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savestate" data-dbid="state" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-md-3 pr-sm-3">
                    <label id="<?=$r['contentType'];?>Postcode" for="postcode"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Postcode" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Postcode Field">&#128279;</a>':'';?>Postcode</label>
                    <div class="form-row">
                      <input class="textinput" id="postcode" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="postcode" type="text" value="<?=$r['postcode']!=0?$r['postcode']:'';?>"<?=($user['options'][1]==1?' placeholder="Enter a Postcode..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savepostcode" data-dbid="postcode" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-3 pl-sm-3">
                    <label id="<?=$r['contentType'];?>Country" for="country"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Country" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Country Field">&#128279;</a>':'';?>Country</label>
                    <div class="form-row">
                      <input class="textinput" id="country" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="country" type="text" value="<?=$r['country'];?>"<?=($user['options'][1]==1?' placeholder="Enter a Country..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savecountry" data-dbid="country" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                </div>
              <?php }
              echo($r['ip']!=''?'<div class="form-text small text-right">'.$r['ip'].'</div>':'');
              if($r['contentType']=='testimonials'){?>
                <div class="row">
                  <div class="col-12 col-sm-4 pr-md-3">
                    <label id="<?=$r['contentType'];?>Name" for="name"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Name" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Name Field">&#128279;</a>':'';?>Name</label>
                    <div class="form-row">
                      <input class="textinput" id="name" list="name_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="name" type="text" value="<?=$r['name'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        $s=$db->query("SELECT DISTINCT `name` FROM `".$prefix."content` UNION SELECT DISTINCT `name` FROM `".$prefix."login` ORDER BY `name` ASC");
                        if($s->rowCount()>0){
                          echo'<datalist id="name_options">';
                          while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
                          echo'</datalist>';
                        }
                        echo'<button class="save" id="savename" data-dbid="name" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4 pr-md-3">
                    <label id="<?=$r['contentType'];?>Email" for="email"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Email" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Email Field">&#128279;</a>':'';?>Email</label>
                    <div class="form-row">
                      <input class="textinput" id="email" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="email" type="text" value="<?=$r['email'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Email..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="saveemail" data-dbid="email" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <label id="<?=$r['contentType'];?>Business" for="business"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Business" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Business Field">&#128279;</a>':'';?>Business</label>
                    <div class="form-row">
                      <input class="textinput" id="business" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="business" type="text" value="<?=$r['business'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Business..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savebusiness" data-dbid="business" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6 pr-md-3">
                    <label id="<?=$r['contentType'];?>URL" for="url"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'URL" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' URL Field">&#128279;</a>':'';?>URL</label>
                    <div class="form-row">
                      <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="url" type="text" value="<?=$r['url'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="saveurl" data-dbid="url" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 pl-md-3 p-0 pb-2">
                    <label class="mb-0" id="<?=$r['contentType'];?>Rating" for="rating"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Rating" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Rating Selector">&#128279;</a>':'';?>Rating</label>
                    <div class="form-row">
                      <?php if($user['options'][1]==1){?>
                        <span class="starRating">
                          <input id="rating5" name="rating" type="radio" value="5" onclick="update('<?=$r['id'];?>','content','rating','5');"<?=$r['rating']==5?' checked':'';?>>
                          <label for="rating5" aria-label="Awesome!">5</label>
                          <input id="rating4" name="rating" type="radio" value="4" onclick="update('<?=$r['id'];?>','content','rating','4');"<?=$r['rating']==4?' checked':'';?>>
                          <label for="rating4" aria-label="Great!">4</label>
                          <input id="rating3" name="rating" type="radio" value="3" onclick="update('<?=$r['id'];?>','content','rating','3');"<?=$r['rating']==3?' checked':'';?>>
                          <label for="rating3" aria-label="Meh!">3</label>
                          <input id="rating2" name="rating" type="radio" value="2" onclick="update('<?=$r['id'];?>','content','rating','2');"<?=$r['rating']==2?' checked':'';?>>
                          <label for="rating2" aria-label="So So!">2</label>
                          <input id="rating1" name="rating" type="radio" value="1" onclick="update('<?=$r['id'];?>','content','rating','1');"<?=$r['rating']==1?' checked':'';?>>
                          <label for="rating1" aria-label="Bad!">1</label>
                        </span>
                      <?php }else{?>
                        <span class="rating i-4x">
                          <span<?=$r['rating']>=1?' class="set"':'';?>></span>
                          <span<?=$r['rating']>=2?' class="set"':'';?>></span>
                          <span<?=$r['rating']>=3?' class="set"':'';?>></span>
                          <span<?=$r['rating']>=4?' class="set"':'';?>></span>
                          <span<?=$r['rating']==5?' class="set"':'';?>></span>
                        </span>
                      <?php }?>
                    </div>
                  </div>
                </div>
              <?php }
              if($r['contentType']=='inventory'){?>
                <label id="<?=$r['contentType'];?>Sale" for="sale"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Sale" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Sale Selector">&#128279;</a>':'';?>Associate&nbsp;with&nbsp;Sale</label>
                <div class="form-row">
                  <select id="sale"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Sale"':' disabled';?> onchange="update('<?=$r['id'];?>','content','sale',$(this).val(),'select');">
                    <option value=""<?=$r['sale']==''?' selected':''?>>No Holiday</option>
                    <option value="valentine"<?=$r['sale']=='valentine'?' selected':''?>>Valentine's Day</option>
                    <option value="easter"<?=$r['sale']=='easter'?' selected':''?>>Easter</option>
                    <option value="mothersday"<?=$r['sale']=='mothersday'?' selected':''?>>Mother's Day</option>
                    <option value="fathersday"<?=$r['sale']=='fathersday'?' selected':''?>>Father's Day</option>
                    <option value="blackfriday"<?=$r['sale']=='blackfriday'?' selected':''?>>Black Friday</option>
                    <option value="halloween"<?=$r['sale']=='halloween'?' selected':''?>>Halloween</option>
                    <option value="smallbusinessday"<?=$r['sale']=='smallbusinessday'?' selected':''?>>Small Business Day</option>
                    <option value="christmas"<?=$r['sale']=='christmas'?' selected':''?>>Christmas</option>
                  </select>
                </div>
              <?php }
              if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='event'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
                <div class="row">
                  <div class="col-12 col-sm-6 pr-md-3">
                    <label id="<?=$r['contentType'];?>CategoryOne" for="category_1"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'CategoryOne" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Category One Field">&#128279;</a>':'';?>Category One</label>
                    <div class="form-row">
                      <input class="textinput" id="category_1" list="category_1_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="category_1" type="text" value="<?=$r['category_1'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        echo'<datalist id="category_1_options">';
                        $sc=$db->prepare("SELECT DISTINCT `title` FROM `".$prefix."choices` WHERE `title`!='' AND `contentType`='category' AND `url`=:url ORDER BY `title` ASC");
                        $sc->execute([':url'=>$r['contentType']]);
                        if($sc->rowCount()>0){
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['title'].'"/>';
                        }
                        $sc=$db->query("SELECT DISTINCT `category_1` FROM `".$prefix."content` WHERE `category_1`!='' ORDER BY `category_1` ASC");
                        if($sc->rowCount()>0){
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
                        }
                        echo'</datalist>'.
                        '<button class="save" id="savecategory_1" data-dbid="category_1" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 pl-md-3">
                    <label id="<?=$r['contentType'];?>CategoryTwo" for="category_2"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'CategoryTwo" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Category Two Field">&#128279;</a>':'';?>Category Two</label>
                    <div class="form-row">
                      <input class="textinput" id="category_2" list="category_2_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="category_2" type="text" value="<?=$r['category_2'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        $sc=$db->query("SELECT DISTINCT `category_2` FROM `".$prefix."content` WHERE `category_2`!='' ORDER BY `category_2` ASC");
                        if($sc->rowCount()>0){
                          echo'<datalist id="category_2_options">';
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_2'].'"/>';
                          echo'</datalist>';
                        }
                        echo'<button class="save" id="savecategory_2" data-dbid="category_2" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6 pr-md-3">
                    <label id="<?=$r['contentType'];?>CategoryThree" for="category_3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'CategoryThree" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Category Three Field">&#128279;</a>':'';?>Category Three</label>
                    <div class="form-row">
                      <input class="textinput" id="category_3" list="category_3_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="category_3" type="text" value="<?=$r['category_3'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        $sc=$db->query("SELECT DISTINCT `category_3` FROM `".$prefix."content` WHERE `category_3`!='' ORDER BY `category_3` ASC");
                        if($sc->rowCount()>0){
                          echo'<datalist id="category_3_options">';
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_3'].'"/>';
                          echo'</datalist>';
                        }
                        echo'<button class="save" id="savecategory_3" data-dbid="category_3" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 pl-md-3">
                    <label id="<?=$r['contentType'];?>CategoryFour" for="category_4"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'CategoryFour" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Category Four Field">&#128279;</a>':'';?>Category Four</label>
                    <div class="form-row">
                      <input class="textinput" id="category_4" list="category_4_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="category_4" type="text" value="<?=$r['category_4'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        $sc=$db->query("SELECT DISTINCT `category_4` FROM `".$prefix."content` WHERE `category_4`!='' ORDER BY `category_4` ASC");
                        if($sc->rowCount()>0){
                          echo'<datalist id="category_4_options">';
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_4'].'"/>';
                          echo'</datalist>';
                        }
                        echo'<button class="save" id="savecategory_4" data-dbid="category_4" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <label id="<?=$r['contentType'];?>tags" for="tags"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'tags" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Tags">&#128279;</a>':'';?>Tags</label>
                  <div class="form-row">
                    <input class="textinput" id="tags" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="tags" type="text" value="<?=$r['tags'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Tag or Select from List..."':' readonly';?>>
                    <?=($user['options'][1]==1?'<button class="save" id="savetags" data-dbid="tags" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                  </div>
                  <?php if($user['options'][1]==1){
                    $tags=array();
                    $st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
                    if($st->rowCount()>0){
                      while($rt=$st->fetch(PDO::FETCH_ASSOC)){
                        $tagslist=explode(",",$rt['tags']);
                        foreach($tagslist as $t)$tgs[]=$t;
                      }
                    }
                    if(isset($tgs)&&$tgs!='')$tags=array_unique($tgs);
                    asort($tags);
                    echo'<select id="tags_options" onchange="addTag($(this).val());">'.
                      '<option value="none">Clear All</option>';
                      foreach($tags as $t)echo'<option value="'.$t.'">'.$t.'</option>';
                      echo'</select>';
                    }?>
                  </div>
                <?php }
                if($r['contentType']=='event'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='events'||$r['contentType']=='activities'){?>
                  <div class="row mt-3">
                    <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'ShowCost" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Show Cost Checkbox">&#128279;</a>':'';?>
                    <input id="<?=$r['contentType'];?>showCost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0" type="checkbox"<?=($r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="<?=$r['contentType'];?>showCost" id="contentoptions0<?=$r['id'];?>">Show Cost</label>
                  </div>
                  <div class="row">
                    <?php if($r['contentType']!='activities'){?>
                      <div class="col-12 col-sm pr-3">
                        <label id="<?=$r['contentType'];?>RRP" for="rrp" data-tooltip="tooltip" aria-label="Recommended Retail Price"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'RRP" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' RRP (Recommended Retail Price) Field">&#128279;</a>':'';?>RRP</label>
                        <div class="form-row">
                          <div class="input-text">$</div>
                          <input class="textinput" id="rrp" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rrp" type="text" value="<?=$r['rrp'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Recommended Retail Cost..."':' readonly';?>>
                          <?=$user['options'][1]==1?'<button class="save" id="saverrp" data-dbid="rrp" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                        </div>
                      </div>
                    <?php }?>
                    <div class="col-12 col-sm">
                      <label id="<?=$r['contentType'];?>Cost" for="cost"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Cost" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Cost Field">&#128279;</a>':'';?>Cost</label>
                      <div class="form-row">
                        <div class="input-text">$</div>
                        <input class="textinput" id="cost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="cost" type="text" value="<?=$r['cost'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Cost..."':' readonly';?>>
                        <?php if($r['cost']==0)
                          $gst=0;
                        else{
                          if(isset($config['gst'])&&is_numeric($config['gst'])){
                            $gst=$r['cost'] * ($config['gst'] / 100);
                            $gst=$r['cost'] + $gst;
                            $gst=number_format((float)$gst,2,'.','');
                          }else
                            $gst=0;
                        }?>
                        <div class="input-text<?=$config['gst']==0?' d-none':'';?>" id="gstcost" data-gst="Incl. GST"><?=$gst;?></div>
                        <?=$user['options'][1]==1?'<button class="save" id="savecost" data-dbid="cost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                      </div>
                    </div>
                    <?php if($r['contentType']!='activities'){?>
                      <div class="col-12 col-sm pl-sm-3">
                        <label id="<?=$r['contentType'];?>ReducedCost" for="rCost"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'ReducedCost" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Reduced Cost Field">&#128279;</a>':'';?>Reduced Cost</label>
                        <div class="form-row">
                          <div class="input-text">$</div>
                          <input class="textinput" id="rCost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rCost" type="text" value="<?=$r['rCost'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Reduced Cost..."':' readonly';?>>
                          <?php if($r['cost']==0)
                            $gst=0;
                          else{
                            if(isset($config['gst'])&&is_numeric($config['gst'])){
                              $gst=$r['rCost']*($config['gst']/100);
                              $gst=$r['rCost']+$gst;
                              $gst=number_format((float)$gst,2,'.','');
                            }else
                              $gst=0;
                          }?>
                          <div class="input-text<?=$config['gst']==0?' d-none':'';?>" id="gstrCost" data-gst="Incl. GST"><?=$gst;?></div>
                          <?=$user['options'][1]==1?'<button class="save" id="saverCost" data-dbid="rCost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                        </div>
                      </div>
                      <div class="col-12 col-sm pl-sm-3">
                        <label id="<?=$r['contentType'];?>WholesaleCost" for="dCost"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'WholesaleCost" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Wholesale Cost Field">&#128279;</a>':'';?>Wholesale Cost</label>
                        <div class="form-row">
                          <div class="input-text">$</div>
                          <input class="textinput" id="dCost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="dCost" type="text" value="<?=$r['dCost'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Wholesale Cost..."':' readonly';?>>
                          <?=$user['options'][1]==1?'<button class="save" id="savedCost" data-dbid="dCost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                        </div>
                      </div>
                    <?php }?>
                  </div>
                <?php }
                if($r['contentType']=='events'){?>
                  <div class="col-12">
                    <label id="<?=$r['contentType'];?>exturl" for="exturl"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'exturl" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' External URL">&#128279;</a>':'';?>External URL</label>
                    <div class="form-row">
                      <input class="textinput" id="exturl" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exturl" type="text" value="<?=$r['exturl'];?>" placeholder="Enter an External URL (Zoom or other Service)...">
                      <?=$user['options'][1]==1?'<button class="save" id="saveexturl" data-dbid="exturl" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                <?php }
                if($r['contentType']=='inventory'||$r['contentType']=='activities'){?>
                  <div class="row">
                    <div class="col-12 col-sm-4">
                      <label id="<?=$r['contentType'];?>Quantity" for="quantity"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Quantity" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Quantity Field">&#128279;</a>':'';?>Quantity</label>
                      <div class="form-row">
                        <input class="textinput" id="quantity" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="quantity" type="text" value="<?=$r['quantity'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Quantity..."':' readonly';?>>
                        <?=$user['options'][1]==1?'<button class="save" id="savequantity" data-dbid="quantity" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4 pl-sm-3">
                      <label id="<?=$r['contentType'];?>cartonQuantity" for="cartonQuantity"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'cartonQuantity" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Carton Quantity Field">&#128279;</a>':'';?>Carton Quantity</label>
                      <div class="form-row">
                        <input class="textinput" id="cartonQuantity" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="cartonQuantity" type="text" value="<?=$r['cartonQuantity'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Carton Quantity..."':' readonly';?>>
                        <?=$user['options'][1]==1?'<button class="save" id="savecartonQuantity" data-dbid="cartonQuantity" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4 pl-sm-3">
                      <label id="<?=$r['contentType'];?>Points" for="points"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Points" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Points Value Field">&#128279;</a>':'';?>Points Value</label>
                      <div class="form-row">
                        <input class="textinput" id="points" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="points" type="text" value="<?=$r['points'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Points Value..."':' readonly';?>>
                        <?=$user['options'][1]==1?'<button class="save" id="savepoints" data-dbid="points" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm">
                      <label id="<?=$r['contentType'];?>StockStatus" for="stockStatus"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'StockStatus" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Stock Status Selector">&#128279;</a>':'';?>Stock Status</label>
                      <div class="form-row">
                        <select id="stockStatus"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Stock Status"':' disabled';?> onchange="update('<?=$r['id'];?>','content','stockStatus',$(this).val(),'select');">
                          <option value="quantity"<?=$r['stockStatus']=='quantity'?' selected':''?>>Dependant on Quantity (In Stock/Out Of Stock)</option>
                          <option value="back order"<?=$r['stockStatus']=='back order'?' selected':'';?>>Back Order</option>
                          <option value="discontinued"<?=$r['stockStatus']=='discontinued'?' selected':'';?>>Discontinued</option>
                          <option value="in stock"<?=$r['stockStatus']=='in stock'?' selected':'';?>>In Stock</option>
                          <option value="in store only"<?=$r['stockStatus']=='in store only'?' selected':'';?>>In Store Only</option>
                          <option value="limited availability"<?=$r['stockStatus']=='limited availability'?' selected':'';?>>Limited Availability</option>
                          <option value="online only"<?=$r['stockStatus']=='online only'?' selected':'';?>>Online Only</option>
                          <option value="out of stock"<?=$r['stockStatus']=='out of stock'?' selected':'';?>>Out Of Stock</option>
                          <option value="pre order"<?=$r['stockStatus']=='pre order'?' selected':'';?>>Pre Order</option>
                          <option value="pre sale"<?=$r['stockStatus']=='pre sale'?' selected':'';?>>Pre Sale</option>
                          <option value="sold out"<?=$r['stockStatus']=='sold out'?' selected':'';?>>Sold Out</option>
                          <option value="available"<?=$r['stockStatus']=='available'?' selected':'';?>>Available</option>
                          <option value="none"<?=($r['stockStatus']=='none'||$r['stockStatus']==''?' selected':'');?>>No Display</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm pl-sm-3">
                      <label id="<?=$r['contentType'];?>ItemCondition" for="itemCondition"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'ItemCondition" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Condition Selector">&#128279;</a>':'';?>Condition</label>
                      <div class="form-row">
                        <select id="itemCondition"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Condition"':' disabled';?> onchange="update('<?=$r['id'];?>','content','itemCondition',$(this).val(),'select');">
                          <option value=""<?=$r['itemCondition']==''?' selected':'';?>>None</option>
                          <option value="acceptable"<?=$r['itemCondition']=='acceptable'?' selected':'';?>>Acceptable</option>
                          <option value="brand new"<?=$r['itemCondition']=='brand new'?' selected':'';?>>Brand New</option>
                          <option value="certified pre-owned"<?=$r['itemCondition']=='certified pre-owned'?' selected':'';?>>Certified Pre-Owned</option>
                          <option value="damaged"<?=$r['itemCondition']=='damaged'?' selected':'';?>>Damaged</option>
                          <option value="excellent"<?=$r['itemCondition']=='excellent'?' selected':'';?>>Excellent</option>
                          <option value="fair"<?=$r['itemCondition']=='fair'?' selected':'';?>>Fair</option>
                          <option value="for parts"<?=$r['itemCondition']=='for parts'?' selected':'';?>>For Parts</option>
                          <option value="good"<?=$r['itemCondition']=='good'?' selected':'';?>>Good</option>
                          <option value="like new"<?=$r['itemCondition']=='like new'?' selected':'';?>>Like New</option>
                          <option value="mint"<?=$r['itemCondition']=='mint'?' selected':'';?>>Mint</option>
                          <option value="mint in box"<?=$r['itemCondition']=='mint in box'?' selected':'';?>>Mint In Box</option>
                          <option value="new"<?=$r['itemCondition']=='new'?' selected':'';?>>New</option>
                          <option value="new with box"<?=$r['itemCondition']=='new with box'?' selected':'';?>>New With Box</option>
                          <option value="new with defects"<?=$r['itemCondition']=='new with defects'?' selected':'';?>>New With Defects</option>
                          <option value="new with tags"<?=$r['itemCondition']=='new with tags'?' selected':'';?>>New With Tags</option>
                          <option value="new without box"<?=$r['itemCondition']=='new without box'?' selected':'';?>>New Without Box</option>
                          <option value="new without tags"<?=$r['itemCondition']=='new without tags'?' selected':'';?>>New Without Tags</option>
                          <option value="non functioning"<?=$r['itemCondition']=='non functioning'?' selected':'';?>>Non Functioning</option>
                          <option value="poor"<?=$r['itemCondition']=='poor'?' selected':'';?>>Poor</option>
                          <option value="pre-owned"<?=$r['itemCondition']=='pre-owned'?' selected':'';?>>Pre-Owned</option>
                          <option value="refurbished"<?=$r['itemCondition']=='refurbished'?' selected':'';?>>Refurbished</option>
                          <option value="remanufactured"<?=$r['itemCondition']=='remanufactured'?' selected':'';?>>Remanufactured</option>
                          <option value="seasoned"<?=$r['itemCondition']=='seasoned'?' selected':'';?>>Seasoned</option>
                          <option value="unseasoned"<?=$r['itemCondition']=='unseasoned'?' selected':'';?>>Unseasoned</option>
                          <option value="used"<?=$r['itemCondition']=='used'?' selected':'';?>>Used</option>
                          <option value="very good"<?=$r['itemCondition']=='very good'?' selected':'';?>>Very Good</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <label id="<?=$r['contentType'];?>Weight" for="weight"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Weight" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Weight Field">&#128279;</a>':'';?>Weight</label>
                  <div class="form-row">
                    <input class="textinput" id="weight" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="weight" type="text" value="<?=$r['weight'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Weight..."':' readonly';?>>
                    <select id="weightunit" onchange="update('<?=$r['id'];?>','content','weightunit',$(this).val(),'select');"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Weight Unit"':' disabled';?>>
                      <option value="mg"<?=$r['weightunit']=='mg'?' selected':'';?>>Milligrams (mg)</option>
                      <option value="g"<?=$r['weightunit']=='g'?' selected':'';?>>Grams (g)</option>
                      <option value="kg"<?=$r['weightunit']=='kg'?' selected':'';?>>Kilograms (kg)</option>
                      <option value="lb"<?=$r['weightunit']=='lb'?' selected':'';?>>Pound (lb)</option>
                      <option value="t"<?=$r['weightunit']=='t'?' selected':'';?>>Tonne (t)</option>
                    </select>
                    <?=$user['options'][1]==1?'<button class="save" id="saveweight"  data-dbid="weight" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>Size" for="size"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Size" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Size Fields">&#128279;</a>':'';?>Size</label>
                  <div class="row">
                    <div class="col-12 col-sm">
                      <div class="form-row">
                        <div class="input-text">Width</div>
                        <input class="textinput" id="width" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="width" type="text" value="<?=$r['width'];?>"<?=$user['options'][1]==1?' placeholder="Width"':' readonly';?>>
                        <select id="widthunit"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Width Unit"':' disabled';?> onchange="update('<?=$r['id'];?>','content','widthunit',$(this).val(),'select');">
                          <option value="um"<?=$r['widthunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                          <option value="mm"<?=$r['widthunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                          <option value="cm"<?=$r['widthunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                          <option value="in"<?=$r['widthunit']=='in'?' selected':'';?>>Inch (in)</option>
                          <option value="ft"<?=$r['widthunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                          <option value="m"<?=$r['widthunit']=='m'?' selected':'';?>>Metre (m)</option>
                          <option value="km"<?=$r['widthunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                          <option value="mi"<?=$r['widthunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                          <option value="nm"<?=$r['widthunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                          <option value="yard"<?=$r['widthunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                        </select>
                        <?=$user['options'][1]==1?'<button class="save" id="savewidth" data-dbid="width" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                      </div>
                    </div>
                    <div class="col-12 col-sm pl-sm-2">
                      <div class="form-row">
                        <div class="input-text">Height</div>
                        <input class="textinput" id="height" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="height"<?=$user['options'][1]==1?' placeholder="Height"':' readonly';?> type="text" value="<?=$r['height'];?>">
                        <select id="heightunit"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Height Unit"':' disabled';?> onchange="update('<?=$r['id'];?>','content','heightunit',$(this).val(),'select');">
                          <option value="um"<?=$r['heightunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                          <option value="mm"<?=$r['heightunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                          <option value="cm"<?=$r['heightunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                          <option value="in"<?=$r['heightunit']=='in'?' selected':'';?>>Inch (in)</option>
                          <option value="ft"<?=$r['heightunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                          <option value="m"<?=$r['heightunit']=='m'?' selected':'';?>>Metre (m)</option>
                          <option value="km"<?=$r['heightunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                          <option value="mi"<?=$r['heightunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                          <option value="nm"<?=$r['heightunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                          <option value="yard"<?=$r['heightunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                        </select>
                        <?=$user['options'][1]==1?'<button class="save" id="saveheight" data-dbid="height" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                      </div>
                    </div>
                    <div class="col-12 col-sm pl-sm-2">
                      <div class="form-row">
                        <div class="input-text">Length</div>
                        <input class="textinput" id="length" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="length" type="text" value="<?=$r['length'];?>"<?=$user['options'][1]==1?' placeholder="Length"':' readonly';?>>
                        <select id="lengthunit"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Length Unit"':' disabled';?> onchange="update('<?=$r['id'];?>','content','lengthunit',$(this).val(),'select');">
                          <option value="um"<?=$r['lengthunit']=='um'?' selected':'';?>>Micrometre (um)</option>
                          <option value="mm"<?=$r['lengthunit']=='mm'?' selected':'';?>>Millimetre (mm)</option>
                          <option value="cm"<?=$r['lengthunit']=='cm'?' selected':'';?>>Centimetre (cm)</option>
                          <option value="in"<?=$r['lengthunit']=='in'?' selected':'';?>>Inch (in)</option>
                          <option value="ft"<?=$r['lengthunit']=='ft'?' selected':'';?>>Foot (ft)</option>
                          <option value="m"<?=$r['lengthunit']=='m'?' selected':'';?>>Metre (m)</option>
                          <option value="km"<?=$r['lengthunit']=='km'?' selected':'';?>>Kilometre (km)</option>
                          <option value="mi"<?=$r['lengthunit']=='mi'?' selected':'';?>>Mile (mi)</option>
                          <option value="nm"<?=$r['lengthunit']=='nm'?' selected':'';?>>Nanomatre (nm)</option>
                          <option value="yard"<?=$r['lengthunit']=='yd'?' selected':'';?>>Yard (yd)</option>
                        </select>
                        <?=$user['options'][1]==1?'<button class="save" id="savelength" data-dbid="length" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                      </div>
                    </div>
                  </div>
                <?php }?>
                <div class="row mt-3<?=$seo['notes']!=''||$seo['notesHeading']!=''?' border-danger border-2':'';?>">
                  <?php echo$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#summernote" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Notes">&#128279;</a>':'';
                  if($user['options'][1]==1){
                    echo'<div class="wysiwyg-toolbar">'.
                      '<div class="btn-group d-flex justify-content-end">';
                        if($r['suggestions']==1){
                          $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                          $ss->execute([
                            ':rid'=>$r['id'],
                            ':t'=>'content',
                            ':c'=>'notes'
                          ]);
                          echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=notes" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i text-success">lightbulb</i></button>':'';
                        }
                        echo'<button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Content.md" data-type="content" data-tooltip="tooltip" aria-label="SEO Content Information"><i class="i">seo</i></button>'.
                        '<button data-tooltip="tooltip" aria-label="Show Element Blocks" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;"><i class="i">blocks</i></button>'.
                        '<input class="col-1" id="ipsumc" value="5">'.
                        '<button data-tooltip="tooltip" aria-label="Add Aussie Lorem Ipsum" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;"><i class="i">loremipsum</i></button>'.
                        '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=notes" data-tooltip="tooltip" aria-label="Add Suggestions"><i class="i">idea</i></button>'.
                      '</div>'.
                    '</div>'.
                    ($seo['notes']!=''?'<div class="alert alert-warning m-0">'.strip_tags($seo['notes'],'<strong>').'</div>':'');?>
                    <div id="notesda" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
                    <form id="summernote" target="sp" method="post" action="core/update.php" enctype="multipart/form-data">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input name="t" type="hidden" value="content">
                      <input name="c" type="hidden" value="notes">
                      <textarea class="summernote" id="notes" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?= rawurldecode($r['notes']);?></textarea>
                    </form>
                  <?php }else{?>
                    <div class="note-editor note-frame">
                      <div class="note-editing-area">
                        <div class="note-viewport-area">
                          <div class="note-editable">
                            <?= rawurldecode($r['notes']);?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
                <div class="form-text small text-muted">Edited: <?=$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
              </div>
<?php /* Images */ ?>
              <div class="tab1-2 border p-4" data-tabid="tab1-2" role="tabpanel">
                <div id="error"></div>
                <?php if($r['contentType']=='testimonials'){?>
                  <div class="alert alert-info<?=$r['cid']==0?' hidden':'';?>" id="tstavinfo" role="alert">Currently using the Avatar associated with the selected Client Account.</div>
                  <?php if($user['options'][1]==1){?>
                    <form target="sp" method="post" action="core/add_data.php" enctype="multipart/form-data">
                      <label id="<?=$r['contentType'];?>Avatar" for="avatar"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Avatar" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Avatar">&#128279;</a>':'';?>Avatar</label>
                      <div class="form-row">
                        <img id="tstavatar" src="<?=$r['file']!=''&&file_exists('media/avatar/'.basename($r['file']))?'media/avatar/'.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar">
                        <input id="av" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="avatar" type="text" value="<?=$r['file'];?>" readonly>
                        <input name="id" type="hidden" value="<?=$r['id'];?>">
                        <input name="act" type="hidden" value="add_tstavatar">
                        <div class="btn custom-file" data-tooltip="tooltip" aria-label="Browse Computer for Image">
                          <input class="custom-file-input hidden" id="avatarfu" name="fu" type="file" onchange="form.submit();">
                          <label for="avatarfu"><i class="i">browse-computer</i></label>
                        </div>
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate('<?=$r['id'];?>','content','file','');"><i class="i">trash</i></button>
                      </div>
                    </form>
                  <?php }else{?>
                    <label id="<?=$r['contentType'];?>Avatar" for="avatar"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Avatar" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Avatar">&#128279;</a>':'';?>Avatar</label>
                    <div class="form-row">
                      <img id="tstavatar" src="<?=$r['file']!=''&&file_exists('media/avatar/'.basename($r['file']))?'media/avatar/'.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar">
                      <input id="av" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="avatar" type="text" value="<?=$r['file'];?>" readonly>
                    </div>
                  <?php }
                }
                if($r['contentType']!='testimonials'){?>
                  <label id="<?=$r['contentType'];?>ImageURL for="fileURL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'ImageURL" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image URL Field">&#128279;</a>':'';?>URL</label>
                  <div class="form-row">
                    <?=$r['fileURL']!=''?'<a data-fancybox="url" href="'.$r['fileURL'].'"><img id="urlimage" src="'.$r['fileURL'].'"></a>':'<img id="urlimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                    <input class="textinput" id="fileURL" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="fileURL" type="text" value="<?=$r['fileURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="savefileURL" data-dbid="fileURL" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>Image" for="file"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Image" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image Field">&#128279;</a>':'';?>Image</label>
                  <div class="form-row">
                    <?php $w='';
                    if(stristr($r['file'],'youtu')){
                      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$r['file'],$vidMatch);
                      $r['file']='https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg';
                    }
                    if(stristr($r['file'],'/thumbs/'))$w='thumbs';
                    if(stristr($r['file'],'/lg/'))$w='lg';
                    if(stristr($r['file'],'/md/'))$w='md';
                    if(stristr($r['file'],'/sm/'))$w='sm';
                    echo($r['file']!=''?
                      '<a data-fancybox="'.$r['contentType'].$r['id'].'" data-caption="'.$r['title'].
                        ($r['fileALT']!=''?
                          '<br>ALT: '.$r['fileALT']
                            :
                          '<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>'
                        ).
                      '" href="'.$r['file'].'"><img id="fileimage" src="'.$r['file'].'" alt="'.$r['contentType'].': '.$r['title'].'"></a>'
                    :
                      '<img id="fileimage" src="'.ADMINNOIMAGE.'" alt="No Image">'
                    );?>
                    <input class="textinput" id="file" type="text" value="<?=$r['file'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="file"<?=($user['options'][1]==1?' placeholder="Select an image from the button options..."':' disabled');?>>
                    <?php
                    echo($user['options'][1]==1?
                      '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`file`);"><i class="i">browse-media</i></button>'.
                      ($config['mediaOptions'][0]==1?'<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id='.$r['id'].'&t=content&c=file" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>':'').
                      ($config['mediaOptions'][2]==1?'<button class="openimageeditor" data-tooltip="tooltip" aria-label="Edit Image" data-imageeditor="editfile" data-image="'.$r['file'].'" data-name="'.$r['title'].'" data-alt="'.$r['fileALT'].'" data-w="'.$w.'" data-id="'.$r['id'].'" data-t="content" data-c="file"><i class="i">magic</i></button>':'').
                      '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`file`,``);"><i class="i">trash</i></button><button class="save" id="savefile" data-dbid="file" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                    :
                      ''
                    );?>
                  </div>
                  <div id="editfile"></div>
                  <label id="<?=$r['contentType'];?>Thumbnail" for="thumb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Thumbnail" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Thumbnail Field">&#128279;</a>':'';?>Thumbnail</label>
                  <div class="form-row">
                    <?php $w='';
                    if(stristr($r['thumb'],'/thumbs/'))$w='thumbs';
                    if(stristr($r['thumb'],'/lg/'))$w='lg';
                    if(stristr($r['thumb'],'/md/'))$w='md';
                    if(stristr($r['thumb'],'/sm/'))$w='sm';
                    echo$r['thumb']!=''?
                      '<a data-fancybox="thumb'.$r['id'].'" data-caption="Thumbnail: '.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['thumb'].'"><img id="thumbimage" src="'.$r['thumb'].'" alt="Thumbnail: '.$r['title'].'"></a>'
                    :
                      '<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                    <input class="textinput" id="thumb" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="thumb" type="text" value="<?=$r['thumb'];?>"<?=($user['options'][1]==1?' placeholder="Select an image from the button options..."':' disabled');?>>
                    <?=($user['options'][1]==1?
                      '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`thumb`);"><i class="i">browse-media</i></button>'.
                      ($config['mediaOptions'][0]==1?'<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id='.$r['id'].'&t=content&c=thumb" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>':'').
                      ($config['mediaOptions'][2]==1?'<button class="openimageeditor" data-tooltip="tooltip" aria-label="Edit Thumbnail Image" data-imageeditor="editthumb" data-image="'.$r['thumb'].'" data-name="'.$r['title'].'" data-alt="'.$r['fileALT'].'" data-w="'.$w.'" data-id="'.$r['id'].'" data-t="content" data-c="thumb"><i class="i">magic</i></button>':'').
                      '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`thumb`,``);"><i class="i">trash</i></button><button class="save" id="savethumb" data-dbid="thumb" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                    :
                      ''
                    );?>
                  </div>
                  <div id="editthumb"></div>
                  <label id="<?=$r['contentType'];?>ImageALT" for="fileALT"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'ImageALT" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image Alt Field">&#128279;</a>':'';?>Image ALT</label>
                  <?=$seo['fileALT']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['fileALT'],'<strong>').'</div>':'';?>
                  <div class="form-row<?=$seo['fileALT']!=''?' border-danger border-2 border-top-0':'';?>">
                    <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-type="alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><i class="i">seo</i></button>
                    <div class="input-text" data-el="fileALT" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter an Image ALT Text..."><?=$r['fileALT'];?></div>
                    <input class="textinput d-none" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>">
                    <?=$user['options'][1]==1?'<button class="save" id="savefileALT" data-tooltip="tooltip" aria-label="Save" data-dbid="fileALT" data-style="zoom-in"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>VideoURL" for="videoURL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'VideoURL" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Video URL Field">&#128279;</a>':'';?>Video URL</label>
                  <div class="form-row">
                    <input class="textinput" id="videoURL" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="videoURL" type="text" value="<?=$r['videoURL'];?>">
                    <?=$user['options'][1]==1?
                      '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`videoURL`);"><i class="i">browse-media</i></button>'.
                      '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`content`,`videoURL`,``);"><i class="i">trash</i></button>'.
                      '<button class="save" id="savevideoURL" data-dbid="videoURL" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                    :
                      '';?>
                  </div>
                  <div class="row mt-3">
                    <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#options4" data-tooltip="tooltip" aria-label="PermaLink to '.$r['contentType'].' Video Autoplay Checkbox">&#128279;</a>':'';?>
                    <input id="options4" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="4" type="checkbox"<?=($r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label id="contentoptions4<?=$r['id'];?>" for="options4">AutoPlay Video</label>
                  </div>
                  <div class="row">
                    <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#options5" data-tooltip="tooltip" aria-label="PermaLink to '.$r['contentType'].' Video Loop Checkbox">&#128279;</a>':'';?>
                    <input id="options5" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="5" type="checkbox"<?=($r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label id="contentoptions5<?=$r['id'];?>" for="options5">Loop Video</label>
                  </div>
                  <div class="row">
                    <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#options6" data-tooltip="tooltip" aria-label="PermaLink to '.$r['contentType'].' Video Show Controls Checkbox">&#128279;</a>':'';?>
                    <input id="options6" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="6" type="checkbox"<?=($r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label id="contentoptions6<?=$r['id'];?>" for="options6">Show Controls</label>
                  </div>
                  <legend class="mt-3">EXIF Information</legend>
                  <div class="form-row">
                    <label id="<?=$r['contentType'];?>EXIFFilename" for="exifFilename"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFFilename" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Original Filename Field">&#128279;</a>':'';?>Original&nbsp;Filename</label>
                    <?=$user['options'][1]==1?'<small class="form-text text-right">Using the "Magic Wand" button will attempt to get the EXIF Information embedded in the Uploaded Image.</small>':'';?>
                  </div>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifFilename`);"><i class="i">magic</i></button>':'';?>
                    <input class="textinput" id="exifFilename" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifFilename" type="text" value="<?=$r['exifFilename'];?>"<?=$user['options'][1]==1?' placeholder="Original Filename..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifFilename" data-dbid="exifFilename" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>EXIFCamera" for="exifCamera"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFCamera" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image EXIF Camera Field">&#128279;</a>':'';?>Camera</label>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifCamera`);"><i class="i">magic</i></button>':'';?>
                    <input class="textinput" id="exifCamera" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifCamera" type="text" value="<?=$r['exifCamera'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Camera"':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifCamera" data-dbid="exifCamera" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>EXIFLens" for="exifLens"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFLens" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image EXIF Lens Field">&#128279;</a>':'';?>Lens</label>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifLens`);"><i class="i">magic</i></button>':'';?>
                    <input type="text" id="exifLens" class="textinput" value="<?=$r['exifLens'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifLens"<?=$user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifLens" data-dbid="exifLens" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>EXIFAperture" for="exifAperture"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFAperture" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image EXIF Aperture Field">&#128279;</a>':'';?>Aperture</label>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifAperture`);"><i class="i">magic</i></button>':'';?>
                    <input class="textinput" id="exifAperture" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifAperture" type="text" value="<?=$r['exifAperture'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifAperture" data-dbid="exifAperture" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>EXIFFocalLength" for="exifFocalLength"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFFocalLength" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image EXIF Focal Length Field">&#128279;</a>':'';?>Focal Length</label>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifFocalLength`);"><i class="i">magic</i></button>':'';?>
                    <input class="textinput" id="exifFocalLength" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifFocalLength" type="text" value="<?=$r['exifFocalLength'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifFocalLength" data-dbid="exifFocalLength" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>EXIFShutterSpeed" for="exifShutterSpeed"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFShutterSpeed" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image EXIF Shutter Speed Field">&#128279;</a>':'';?>Shutter Speed</label>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifShutterSpeed`);"><i class="i">magic</i></button>':'';?>
                    <input class="textinput" id="exifShutterSpeed" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifShutterSpeed" type="text" value="<?=$r['exifShutterSpeed'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifShutterSpeed" data-dbid="exifShutterSpeed" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>EXIFISO" for="exifISO"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFISO" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image EXIF ISO Field">&#128279;</a>':'';?>ISO</label>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifISO`);"><i class="i">magic</i></button>':'';?>
                    <input class="textinput" id="exifISO" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifISO" type="text" value="<?=$r['exifISO'];?>"<?=$user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifISO" data-dbid="exifISO" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>EXIFTaken" for="exifti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EXIFTaken" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image EXIF Date Taken Field">&#128279;</a>':'';?>Taken</label>
                  <div class="form-row">
                    <?=$user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifti`);"><i class="i">magic</i></button>':'';?>
                    <input class="textinput" id="exifti" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exifti" type="text" value="<?=$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>"<?=$user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveexifti" data-dbid="exifti" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <legend class="mt-3">Image Attribution</legend>
                  <label id="<?=$r['contentType'];?>AttributionImageTitle" for="attributionImageTitle"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'AttributionImageTitle" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image Attribution Title Field">&#128279;</a>':'';?>Title</label>
                  <div class="form-row">
                    <input class="textinput" id="attributionImageTitle" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" type="text" value="<?=$r['attributionImageTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="saveattributionImageTitle" data-dbid="attributionImageTitle" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>AttributionImageName" for="attributionImageName"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'AttributionImageName" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image Attribution Name Field">&#128279;</a>':'';?>Name</label>
                  <div class="form-row">
                    <input class="textinput" id="attributionImageName" list="attributionImageName_option" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="attributionImageName" type="text" value="<?=$r['attributionImageName'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                    <?php if($user['options'][1]==1){
                      $s=$db->query("SELECT DISTINCT `attributionImageName` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` AS name FROM `".$prefix."content` UNION SELECT DISTINCT `name` AS name FROM login ORDER BY `name` ASC");
                      if($s->rowCount()>0){
                        echo'<datalist id="attributionImageName_option">';
                        while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';
                        echo'</datalist>';
                      }
                    }
                    echo$user['options'][1]==1?'<button class="save" id="saveattributionImageName" data-dbid="attributionImageName" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>AttributionImageURL" for="attributionImageURL"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'AttributionImageURL" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Image Attribution URL Field">&#128279;</a>':'';?>URL</label>
                  <div class="form-row">
                    <input class="textinput" id="attributionImageURL" list="attributionImageURL_option" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL" type="text" value="<?=$r['attributionImageURL'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                    <?php if($user['options'][1]==1){
                      $s=$db->query("SELECT DISTINCT `attributionImageURL` AS url FROM `".$prefix."content` ORDER BY `attributionImageURL` ASC");
                      if($s->rowCount()>0){
                        echo'<datalist id="attributionImageURL_option">';
                        while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';
                        echo'</datalist>';
                      }
                    }
                    echo$user['options'][1]==1?'<button class="save" id="saveattributionImageURL" data-dbid="attributionImageURL" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                <?php }?>
              </div>
<?php /* Media */ ?>
              <?php if($r['contentType']!='testimonials'){?>
                <div class="tab1-3 border p-4" data-tabid="tab1-3" role="tabpanel">
                  <?php if($user['options'][1]==1){?>
                    <legend>Downloadable Media</legend>
                    <form class="row mb-3" target="sp" method="post" action="core/add_download.php" enctype="multipart/form-data">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <div class="form-row">
                        <div class="input-text border-right-0 border-bottom-0">
                          <label for="downloadt">Title:</label>
                        </div>
                        <input class="border-bottom-0 border-left-0" type="text" name="t" value="" placeholder="Enter a Title, leave empty to use filename...">
                      </div>
                      <?php if($r['contentType']=='inventory'){?>
                        <div class="form-row">
                          <div class="input-text border-right-0 border-bottom-0">
                            <label for="downloadr">Requires Order</label>&nbsp;<input id="downloadr" type="checkbox" name="r" value="1">
                          </div>
                          <div class="input-text border-right-0 border-bottom-0 border-left-0 pr-0">
                            <label for="downloada">and&nbsp;is&nbsp;available&nbsp;for&nbsp;download&nbsp;for:</label>
                          </div>
                          <select class="border-bottom-0 border-left-0" id="downloada" name="a">
                            <option value="0" selected>Forever</option>
                            <option value="3600">1 Hour</option>
                            <option value="7200">2 Hours</option>
                            <option value="14400">4 Hours</option>
                            <option value="28800">8 Hours</option>
                            <option value="86400">24 Hours</option>
                            <option value="172800">48 Hours</option>
                            <option value="604800">1 Week</option>
                            <option value="1209600">2 Weeks</option>
                            <option value="2592000">1 Month</option>
                            <option value="7776000">3 Months</option>
                            <option value="15552000">6 Months</option>
                            <option value="31536000">1 Year</option>
                          </select>
                        </div>
                      <?php }?>
                      <div class="form-row">
                        <input class="field" style="opacity:1;" id="downloadfu" name="fu" type="file" placeholder="Select File from your computer to upload..." onchange="$(`#downloadfile`).val($(this).val());">
                        <button class="add" data-tooltip="tooltip" aria-label="Add" type="submit"><i class="i">add</i></button>
                      </div>
                    </form>
                    <div id="downloads">
                      <?php $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='download' AND `rid`=:id");
                      $sd->execute([':id'=>$r['id']]);
                      if($sd->rowCount()>0){
                        while($rd=$sd->fetch(PDO::FETCH_ASSOC)){?>
                          <div class="row mt-1" id="l_<?=$rd['id'];?>">
                            <div class="form-row">
                              <div class="input-text border-right-0 border-bottom-0">
                                <label>Title:</label>
                              </div>
                              <input class="border-bottom-0 border-left-0" type="text" name="t" value="<?=$rd['title'];?>" placeholder="Uses Filename in place of title..." readonly>
                            </div>
                            <?php if($r['contentType']=='inventory'){?>
                              <div class="form-row">
                                <div class="input-text border-right-0 border-bottom-0">
                                  <label>Requires Order</label>&nbsp;<input type="checkbox" name="r"<?=$rd['password']==1?' checked':''?> disabled>
                                </div>
                                <div class="input-text border-right-0 border-bottom-0 border-left-0 pr-0">
                                  <label>and&nbsp;is&nbsp;available&nbsp;for&nbsp;download&nbsp;for:</label>
                                </div>
                                <select class="border-bottom-0 border-left-0" id="downloada" name="a" onchange="update('<?=$rd['id'];?>','choices','tie',$(this).val(),'select');">
                                  <option value="0"<?=($rd['tie']==0?' selected':'');?>>Forever</option>
                                  <option value="3600"<?=($rd['tie']==3600?' selected':'');?>>1 Hour</option>
                                  <option value="7200"<?=($rd['tie']==7200?' selected':'');?>>2 Hours</option>
                                  <option value="14400"<?=($rd['tie']==14400?' selected':'');?>>4 Hours</option>
                                  <option value="28800"<?=($rd['tie']==28800?' selected':'');?>>8 Hours</option>
                                  <option value="86400"<?=($rd['tie']==86400?' selected':'');?>>24 Hours</option>
                                  <option value="172800"<?=($rd['tie']==172800?' selected':'');?>>48 Hours</option>
                                  <option value="604800"<?=($rd['tie']==604800?' selected':'');?>>1 Week</option>
                                  <option value="1209600"<?=($rd['tie']==1209600?' selected':'');?>>2 Weeks</option>
                                  <option value="2592000"<?=($rd['tie']==2592000?' selected':'');?>>1 Month</option>
                                  <option value="7776000"<?=($rd['tie']==7776000?' selected':'');?>>3 Months</option>
                                  <option value="15552000"<?=($rd['tie']==15552000?' selected':'');?>>6 Months</option>
                                  <option value="31536000"<?=($rd['tie']==31536000?' selected':'');?>>1 Year</option>
                                </select>
                              </div>
                            <?php }?>
                            <div class="form-row">
                              <input id="url<?=$rd['id'];?>" name="url" type="text" value="<?=$rd['url'];?>">
                              <form target="sp" action="core/purge.php">
                                <input name="id" type="hidden" value="<?=$rd['id'];?>">
                                <input name="t" type="hidden" value="choices">
                                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                              </form>
                            </div>
                          </div>
                        <?php }
                      }?>
                    </div>
                    <hr>
                    <legend>Links to Services/Content</legend>
                    <form class="row mb-3" target="sp" method="post" action="core/add_link.php">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <div class="form-row">
                        <div class="input-text border-right-0 border-bottom-0">
                          <label for="linkt">Title:</label>
                        </div>
                        <input class="border-bottom-0 border-left-0" id="linkt" type="text" name="t" value="" placeholder="Enter a Title...">
                      </div>
                      <?php if($r['contentType']=='inventory'){?>
                        <div class="form-row">
                          <div class="input-text border-right-0 border-bottom-0">
                            <label for="downloadr">Requires Order</label>&nbsp;<input id="linkr" type="checkbox" name="r" value="1">
                          </div>
                          <div class="input-text border-right-0 border-bottom-0 border-left-0 pr-0">
                            <label for="linka">and&nbsp;is&nbsp;available&nbsp;for:</label>
                          </div>
                          <select class="border-bottom-0 border-left-0" id="linka" name="a">
                            <option value="0" selected>Forever</option>
                            <option value="3600">1 Hour</option>
                            <option value="7200">2 Hours</option>
                            <option value="14400">4 Hours</option>
                            <option value="28800">8 Hours</option>
                            <option value="86400">24 Hours</option>
                            <option value="172800">48 Hours</option>
                            <option value="604800">1 Week</option>
                            <option value="1209600">2 Weeks</option>
                            <option value="2592000">1 Month</option>
                            <option value="7776000">3 Months</option>
                            <option value="15552000">6 Months</option>
                            <option value="31536000">1 Year</option>
                          </select>
                        </div>
                      <?php }?>
                      <div class="form-row">
                        <input class="field" style="opacity:1;" id="downloadfu" name="l" type="text" placeholder="Enter Link to Service/Content...">
                        <button class="add" data-tooltip="tooltip" aria-label="Add" type="submit"><i class="i">add</i></button>
                      </div>
                    </form>
                    <div id="links">
                      <?php $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='link' AND `rid`=:id");
                      $sd->execute([':id'=>$r['id']]);
                      if($sd->rowCount()>0){
                        while($rd=$sd->fetch(PDO::FETCH_ASSOC)){?>
                          <div class="row mt-1" id="l_<?=$rd['id'];?>">
                            <div class="form-row">
                              <div class="input-text border-right-0 border-bottom-0">
                                <label>Title:</label>
                              </div>
                              <input class="border-bottom-0 border-left-0" type="text" name="t" value="<?=$rd['title'];?>" placeholder="Title..." readonly>
                            </div>
                            <?php if($r['contentType']=='inventory'){?>
                              <div class="form-row">
                                <div class="input-text border-right-0 border-bottom-0">
                                  <label>Requires Order</label>&nbsp;<input type="checkbox" name="r"<?=$rd['password']==1?' checked':''?> disabled>
                                </div>
                                <div class="input-text border-right-0 border-bottom-0 border-left-0 pr-0">
                                  <label>and&nbsp;is&nbsp;available&nbsp;for&nbsp;download&nbsp;for:</label>
                                </div>
                                <select class="border-bottom-0 border-left-0" id="downloada" name="a" onchange="update('<?=$rd['id'];?>','choices','tie',$(this).val(),'select');">
                                  <option value="0"<?=($rd['tie']==0?' selected':'');?>>Forever</option>
                                  <option value="3600"<?=($rd['tie']==3600?' selected':'');?>>1 Hour</option>
                                  <option value="7200"<?=($rd['tie']==7200?' selected':'');?>>2 Hours</option>
                                  <option value="14400"<?=($rd['tie']==14400?' selected':'');?>>4 Hours</option>
                                  <option value="28800"<?=($rd['tie']==28800?' selected':'');?>>8 Hours</option>
                                  <option value="86400"<?=($rd['tie']==86400?' selected':'');?>>24 Hours</option>
                                  <option value="172800"<?=($rd['tie']==172800?' selected':'');?>>48 Hours</option>
                                  <option value="604800"<?=($rd['tie']==604800?' selected':'');?>>1 Week</option>
                                  <option value="1209600"<?=($rd['tie']==1209600?' selected':'');?>>2 Weeks</option>
                                  <option value="2592000"<?=($rd['tie']==2592000?' selected':'');?>>1 Month</option>
                                  <option value="7776000"<?=($rd['tie']==7776000?' selected':'');?>>3 Months</option>
                                  <option value="15552000"<?=($rd['tie']==15552000?' selected':'');?>>6 Months</option>
                                  <option value="31536000"<?=($rd['tie']==31536000?' selected':'');?>>1 Year</option>
                                </select>
                              </div>
                            <?php }?>
                            <div class="form-row">
                              <div class="input-text col-sm">
                                <a target="_blank" href="<?=$rd['url'];?>"><?=$rd['url'];?></a>
                              </div>
                              <form target="sp" action="core/purge.php">
                                <input name="id" type="hidden" value="<?=$rd['id'];?>">
                                <input name="t" type="hidden" value="choices">
                                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                              </form>
                            </div>
                          </div>
                        <?php }
                      }?>
                    </div>
                    <hr>
                    <legend>On Page Media</legend>
                    <form class="form-row" target="sp" method="post" action="core/add_media.php" enctype="multipart/form-data">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input name="rid" type="hidden" value="<?=$r['id'];?>">
                      <input name="t" type="hidden" value="content">
                      <input id="mediafile" name="fu" type="text" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                      <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','media','mediafile');return false;"><i class="i">browse-media</i></button>
                      <button class="add" data-tooltip="tooltip" aria-label="Add" type="submit"><i class="i">add</i></button>
                    </form>
                  <?php }?>
                  <div class="row mt-3" id="mi">
                    <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `pid`=:id ORDER BY `ord` ASC");
                    $sm->execute([':id'=>$r['id']]);
                    if($sm->rowCount()>0){
                      while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                        echo'<div id="mi_'.$rm['id'].'" class="card stats gallery col-12 col-sm-3 m-0 border-0">';
                        if(stristr($rm['file'],'youtu')){
                          preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$rm['file'],$vidMatch);
                          echo'<div class="note-video-wrapper video" style="padding-bottom:67%;" data-fancybox="media" href="'.$rm['file'].'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
                            '<img class="note-video-clip" src="'.$rm['thumb'].'">'.
                            '<div class="play"></div>'.
                          '</div>';
                        }elseif(stristr($rm['file'],'vimeo')){
                          preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$rm['file'],$vidMatch);
                          echo'<div class="note-video-wrapper video" style="padding-bottom:67%;" data-fancybox="media" href="'.$rm['file'].'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'">'.
                            '<img class="note-video-clip" src="'.$rm['thumb'].'">'.
                            '<div class="play"></div>'.
                          '</div>';
                        }else
                          echo'<a data-fancybox="media" href="'.$rm['file'].'"><img src="'.$rm['thumb'].'" alt="'.$rm['title'].'"></a>';?>
                          <div class="btn-group tools">
                            <div class="btn" data-tooltip="right" aria-label="<?=$rm['views'];?> views"><small><?=$rm['views'];?></small></div>
                            <?php if($user['options'][1]==1){?>
                              <a href="<?= URL.$settings['system']['admin'].'/media/edit/'.$rm['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                              <button class="trash" onclick="purge('<?=$rm['id'];?>','media')" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                              <div class="btn handle" data-tooltip="left" aria-label="Drag to Reorder"><i class="i">drag</i></div>
                            <?php }?>
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
              <?php }?>
<?php /* Options */ ?>
              <div class="tab1-4 border p-4" data-tabid="tab1-4" role="tabpanel">
                <?php if($user['options'][1]==1){?>
                  <form target="sp" method="post" action="core/add_option.php">
                    <input name="rid" type="hidden" value="<?=$r['id'];?>">
                    <div class="form-row">
                      <div class="input-text">Option</div>
                      <input name="ttl" type="text" value="" placeholder="Title">
                      <div class="input-text">Quantity</div>
                      <input name="qty" type="text" value="" placeholder="Quantity">
                      <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                    </div>
                  </form>
                <?php }?>
                <div id="itemoptions">
                  <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:rid ORDER BY `title` ASC");
                  $ss->execute([':rid'=>$r['id']]);
                  if($ss->rowCount()>0){
                    while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                      <div class="form-row mt-1" id="l_<?=$rs['id'];?>">
                        <div class="input-text">Option</div>
                        <input type="text" value="<?=$rs['title'];?>"<?=$user['options'][1]==1?' onchange="update(`'.$rs['id'].'`,`choices`,`title`,$(this).val());" placeholder="Title"':' readonly';?>>
                        <div class="input-text">Quantity</div>
                        <input type="text" value="<?=$rs['ti'];?>"<?=$user['options'][1]==1?' onchange="update(`'.$rs['id'].'`,`choices`,`ti`,$(this).val());" placeholder="Quantity"':' readonly';?>>
                        <?php if($user['options'][1]==1){?>
                          <form target="sp" action="core/purge.php">
                            <input name="id" type="hidden" value="<?=$rs['id'];?>">
                            <input name="t" type="hidden" value="choices">
                            <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                          </form>
                        <?php }?>
                      </div>
                    <?php }
                  }?>
                </div>
              </div>
<?php /* Comments */ ?>
              <div class="tab1-5 border p-4" data-tabid="tab1-5" role="tabpanel">
                <div class="row">
                  <input id="options1" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1" type="checkbox"<?=($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label id="contentoptions1<?=$r['id'];?>" for="options1">Enable</label>
                </div>
                <div class="mt-3" id="comments">
                  <?php $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`=:contentType AND `rid`=:rid ORDER BY `ti` ASC");
                  $sc->execute([
                    ':contentType'=>$r['contentType'],
                    ':rid'=>$r['id']
                  ]);
                  if($user['options'][1]==1){
                    while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                      <div class="row p-2 mt-1<?=$rc['status']=='unapproved'?' danger':'';?>" id="l_<?=$rc['id'];?>">
                        <?php $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                        $su->execute([':id'=>$rc['uid']]);
                        $ru=$su->fetch(PDO::FETCH_ASSOC);?>
                        <div class="col-1">
                          <img style="max-width:64px;height:64px;" src="<?php if($ru['avatar']!=''&&file_exists('media/avatar/'.$ru['avatar']))echo'media/avatar/'.$ru['avatar'];elseif($ru['gravatar']!='')echo md5($ru['gravatar']);else echo ADMINNOAVATAR;?>" alt="<?=$rc['name'];?>">
                        </div>
                        <div class="col-sm pl-3">
                          <h6>Name: <?=$rc['name']==''?'Anonymous':$rc['name'].' &lt;'.$rc['email'].'&gt;';?></h6>
                          <time class="small"><?= date($config['dateFormat'],$rc['ti']);?></time><br>
                          <?= strip_tags($rc['notes']);?>
                        </div>
                        <?php if($user['options'][1]==1){?>
                          <div class="col-2-5 text-right align-top" id="controls-<?=$rc['id'];?>">
                            <?php $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                            $scc->execute([':ip'=>$rc['ip']]);
                            if($scc->rowCount()<1){?>
                              <form class="d-inline-block" id="blacklist<?=$rc['id'];?>" target="sp" method="post" action="core/add_commentblacklist.php">
                                <input name="id" type="hidden" value="<?=$rc['id'];?>">
                                <button data-tooltip="tooltip" aria-label="Add IP to Blacklist"><i class="i">security</i></button>
                              </form>
                            <?php }?>
                            <button class="add<?=$rc['status']!='unapproved'?' hidden':'';?>" id="approve_<?=$rc['id'];?>" onclick="update('<?=$rc['id'];?>','comments','status','approved');" data-tooltip="tooltip" aria-label="Approve"><i class="i">approve</i></button>
                            <button class="trash" onclick="purge('<?=$rc['id'];?>','comments');" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
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
                    <input name="rid" type="hidden" value="<?=$r['id'];?>">
                    <input name="contentType" type="hidden" value="<?=$r['contentType'];?>">
                    <label for="commentemail">Email</label>
                    <div class="form-row">
                      <input id="commentemail" name="email" type="text" value="<?=$user['email'];?>">
                    </div>
                    <label for="commentname">Name</label>
                    <div class="form-row">
                      <input id="commentname" name="name" type="text" value="<?=$user['name'];?>">
                    </div>
                    <label for="commentda">Comment</label>
                    <div class="form-row">
                      <textarea id="commentda" name="da" placeholder="Enter a Comment..." required></textarea>
                    </div>
                    <div class="form-row">
                      <button class="btn-block add" data-tooltip="tooltip" aria-label="Add Comment');?>">Add Comment</button>
                    </div>
                  </form>
                <?php }?>
              </div>
<?php /* Reviews */ ?>
              <div class="tab1-6 border p-4" data-tabid="tab1-6" role="tabpanel">
                <?php $sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid ORDER BY `ti` DESC");
                $sr->execute([':rid'=>$r['id']]);
                if($sr->rowCount()>0){
                  while($rr=$sr->fetch(PDO::FETCH_ASSOC)){?>
                    <div class="media<?=$rr['status']=='unapproved'?' danger':'';?>" id="l_<?=$rr['id'];?>">
                      <div class="media-body well p-1 m-0">
                        <?php if($user['options'][1]==1){?>
                          <div class="btn-group float-right" id="controls-<?=$rr['id'];?>" role="group">
                            <button class="add<?=$rr['status']=='approved'?' hidden':'';?>" id="approve_<?=$rr['id'];?>" onclick="update('<?=$rr['id'];?>','comments','status','approved');" data-tooltip="tooltip" aria-label="Approve"><i class="i">approve</i></button>
                            <button class="trash" onclick="purge('<?=$rr['id'];?>','comments');" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                          </div>
                        <?php }?>
                        <span class="rating d-block d-sm-inline-block">
                          <span<?=$rr['cid']>=1?' class="set"':'';?>></span>
                          <span<?=$rr['cid']>=2?' class="set"':'';?>></span>
                          <span<?=$rr['cid']>=3?' class="set"':'';?>></span>
                          <span<?=$rr['cid']>=4?' class="set"':'';?>></span>
                          <span<?=$rr['cid']==5?' class="set"':'';?>></span>
                        </span>
                        <h6 class="media-heading m-0"><?=($rr['name']==''?'Anonymous':$rr['name']);?></h6>
                        <div class="small text-muted ml-2"><?='&lt;'.$rr['email'].'&gt; on '.date($config['dateFormat'],$rr['ti']);?></div>
                        <p class="small m-0 ml-2 p-0"><?=$rr['notes'];?></p>
                      </div>
                      <hr class="m-0 p-0">
                    </div>
                  <?php }
                }?>
              </div>
<?php /* Related */ ?>
              <?php if($r['contentType']=='article'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
                <div class="tab1-7 border p-4"  data-tabid="tab1-7" role="tabpanel">
                  <?php if($user['options'][1]==1){?>
                    <form target="sp" method="post" action="core/add_related.php">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <?php $sr=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`!=:id AND `contentType`='article' OR `contentType`='inventory' OR `contentType`='service' ORDER BY `contentType` ASC, `title` ASC");
                      $sr->execute([':id'=>$r['id']]);
                      if($sr->rowCount()>0){?>
                        <div class="form-row">
                          <select id="rid" name="rid"<?=$user['options'][1]==1?' data-tooltip="tooltip"':' disabled';?> data-tooltip="tooltip" aria-label="Select a Content Item to Relate to this one...">
                            <option value="0">Select a Content Item to Relate to this one...</option>
                            <?php while($rr=$sr->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rr['id'].'">'.$rr['contentType'].': '.$rr['title'].'</option>';?>
                          </select>
                          <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                        </div>
                      <?php }?>
                    </form>
                  <?php }?>
                  <div id="relateditems">
                    <?php $sr=$db->prepare("SELECT `id`,`rid` FROM `".$prefix."choices` WHERE `uid`=:id AND `contentType`='related' ORDER BY `ti` ASC");
                    $sr->execute([':id'=>$r['id']]);
                    while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
                      $si=$db->prepare("SELECT `contentType`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                      $si->execute([':id'=>$rr['rid']]);
                      $ri=$si->fetch(PDO::FETCH_ASSOC);?>
                      <div class="form-row mt-1" id="l_<?=$rr['id'];?>">
                        <input type="text" value="<?= ucfirst($ri['contentType']).': '.$ri['title'];?>" readonly>
                        <?php if($user['options'][1]==1){?>
                          <form target="sp" action="core/purge.php">
                            <input name="id" type="hidden" value="<?=$rr['id'];?>">
                            <input name="t" type="hidden" value="choices">
                            <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                          </form>
                        <?php }?>
                      </div>
                    <?php }?>
                  </div>
                </div>
              <?php }
/* SEO */
              if($r['contentType']!='testimonials'&&$r['contentType']!='proofs'){?>
                <div class="tab1-8 border p-4" data-tabid="tab1-8" role="tabpanel">
                  <label id="<?=$r['contentType'];?>Views" for="views"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Views" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Views Field">&#128279;</a>':'';?>Views</label>
                  <div class="form-row">
                    <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`content`,`views`,`0`);"><i class="i">eraser</i></button>'.
                    '<button class="save" id="saveviews" data-dbid="views" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <div class="form-row mt-3">
                    <label id="<?=$r['contentType'];?>MetaRobots" for="metaRobots"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'MetaRobots" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Meta Robots Field">&#128279;</a>':'';?>Meta&nbsp;Robots</label>
                    <?php if($user['options'][1]==1){?>
                      <small class="form-text text-right">Options for Meta Robots: <span data-tooltip="left" data-tooltip="tooltip" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></small>
                    <?php }?>
                  </div>
                  <div class="form-row">
                    <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Robots.md" data-tooltip="tooltip" aria-label="SEO Meta Robots Information"><i class="i">seo</i></button>
                    <?php if($user['options'][1]==1){
                      if($r['suggestions']==1){
                        $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                        $ss->execute([
                          ':rid'=>$r['id'],
                          ':t'=>'content',
                          ':c'=>'metaRobots'
                        ]);
                        echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=metaRobots" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                      }
                    }?>
                    <input class="textinput" id="metaRobots" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="metaRobots" type="text" value="<?=$r['metaRobots'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Robots Option (Left empty the default will be `index,follow`)..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=metaRobots" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                    '<button class="save" id="savemetaRobots" data-dbid="metaRobots" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                  <label id="<?=$r['contentType'];?>SchemaType" for="schemaType"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'SchemaType" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Schema Type Selector">&#128279;</a>':'';?>Schema Type</label>
                  <div class="form-row">
                    <select id="schemaType"<?=$user['options'][1]==1?' data-tooltip="tooltip"':' disabled';?> data-tooltip="tooltip" aria-label="Schema for Microdata Content" onchange="update('<?=$r['id'];?>','content','schemaType',$(this).val(),'select');">
                      <option value="blogPosting"<?=$r['schemaType']=='blogPosting'?' selected':'';?>>blogPosting for Articles</option>
                      <option value="Product"<?=$r['schemaType']=='Product'?' selected':'';?>>Product for Inventory</option>
                      <option value="Service"<?=$r['schemaType']=='Service'?' selected':'';?>>Service for Services</option>
                      <option value="ImageGallery"<?=$r['schemaType']=='ImageGallery'?' selected':'';?>>ImageGallery for Gallery Images</option>
                      <option value="Review"<?=$r['schemaType']=='Review'?' selected':'';?>>Review for Testimonials</option>
                      <option value="NewsArticle"<?=$r['schemaType']=='NewsArticle'?' selected':'';?>>NewsArticle for News</option>
                      <option value="Event"<?=$r['schemaType']=='Event'?' selected':'';?>>Event for Events</option>
                      <option value="CreativeWork"<?=$r['schemaType']=='CreativeWork'?' selected':'';?>>CreativeWork for Portfolio/Proofs</option>
                    </select>
                  </div>
                  <div class="card google-result mt-3 p-3 overflow-visible" id="<?=$r['contentType'];?>SearchResult">
                    <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'SearchResult" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Search Result Example">&#128279;</a>':'';?>
                    <div id="google-title" data-tooltip="tooltip" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below the information is then tried to be used from the Pages Meta Title, if that is empty then an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name.">
                      <?=($r['seoTitle']!=''?$r['seoTitle']:$r['title']);?>
                    </div>
                    <div id="google-link">
                      <?= URL.$r['contentType'].'/'.$r['urlSlug'];?>
                    </div>
                    <div id="google-description" data-tooltip="tooltip" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, the page Meta Description will be used, if that is empty a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences.">
                      <?php if($r['seoDescription']!='')
                        echo$r['seoDescription'];
                      else
                        echo$config['seoDescription'];?>
                    </div>
                  </div>
                  <div class="form-row mt-3">
                    <label id="<?=$r['contentType'];?>SEOTitle" for="seoTitle"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'SEOTitle" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Meta Title Field">&#128279;</a>':'';?>Meta&nbsp;Title</label>
                    <small class="form-text text-right">The recommended character count for Titles is a minimum of 50 and maximum of 70.</small>
                  </div>
                  <?=$seo['seoTitle']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['seoTitle'],'<strong>').'</div>':'';?>
                  <div class="form-row<?=$seo['seoTitle']!=''?' border-danger border-2 border-top-0':'';?>">
                    <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
                    <div id="seoTitlecnt" class="input-text text-success<?= strlen($r['seoTitle'])<1||strlen($r['seoTitle'])>65?' text-danger':'';?>"><?= strlen($r['seoTitle']);?></div>
                    <?php if($user['options'][1]==1){?>
                      <button data-tooltip="tooltip" aria-label="Remove Stop Words" onclick="removeStopWords('seoTitle',$('#seoTitle').val());"><i class="i">magic</i></button>
                      <?php if($r['suggestions']==1){
                        $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                        $ss->execute([
                          ':rid'=>$r['id'],
                          ':t'=>'content',
                          ':c'=>'seoTitle'
                        ]);
                        echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=seoTitle" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                      }
                    }?>
                    <div class="input-text" data-el="seoTitle" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter a Meta Title..."><?=$r['seoTitle'];?></div>
                    <input class="textinput d-none" id="seoTitle" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="seoTitle" type="text" value="<?=$r['seoTitle'];?>">
                    <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=seoTitle" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                    '<button class="analyzeTitle" data-test="seoTitle" data-tooltip="tooltip" aria-label="Analyze Meta Title Text"><i class="i">seo</i></button>'.
                    '<button class="save" id="saveseoTitle" data-dbid="seoTitle" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
<?php /*
                  <div class="form-row mt-3">
                    <label for="seoCaption">Meta&nbsp;Caption</label>
                    <small class="form-text text-right">The recommended character count for Captions is 100.</small>
                  </div>
                  <div class="form-row mt-3">
                    <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=metacaption" data-tooltip="tooltip" aria-label="SEO Meta Caption Information"><i class="i">seo</i></button>
                    <?php $cntc=100-strlen($r['seoCaption']);
                    if($cntc<0){
                      $cnt=abs($cntc);
                      $cnt=number_format($cnt)*-1;
                    }else
                      $cnt=number_format($cntc);?>
                    <div class="input-text">
                      <span class="text-success<?=($cnt<0?' text-danger':'');?>" id="seoCaptioncnt"><?=$cnt;?></span>
                    </div>
                    <?php if($user['options'][1]==1){
                      if($r['suggestions']==1){
                        $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                        $ss->execute([
                          ':rid'=>$r['id'],
                          ':t'=>'content',
                          ':c'=>'seoCaption'
                        ]);
                        echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=seoCaption" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                      }
                    }?>
                    <input class="textinput" id="seoCaption" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="seoCaption" type="text" value="<?=$r['seoCaption'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Meta Caption..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=seoCaption" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                    '<button class="save" id="saveseoCaption" data-dbid="seoCaption" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
*/ ?>
                  <div class="form-row mt-3">
                    <label id="<?=$r['contentType'];?>SEODescription" for="seoDescription"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'SEODescription" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Meta Description Field">&#128279;</a>':'';?>Meta&nbsp;Description</label>
                    <small class="form-text text-right">The recommended character count for Descriptions is a minimum of 50 and a maximum of 160.</small>
                  </div>
                  <?=$seo['seoDescription']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['seoDescription'],'<strong>').'</div>':'';?>
                  <div class="form-row<?=$seo['seoDescription']!=''?' border-danger border-2 border-top-0':'';?>">
                    <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Description.md" data-tooltip="tooltip" aria-label="SEO Meta Description Information"><i class="i">seo</i></button>
                    <div id="seoDescriptioncnt" class="input-text text-success<?= strlen($r['seoDescription'])<50||strlen($r['seoDescription'])>160?' text-danger':'';?>"><?= strlen($r['seoDescription']);?></div>
                    <?php if($user['options'][1]==1){
                      if($r['suggestions']==1){
                        $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                        $ss->execute([
                          ':rid'=>$r['id'],
                          ':t'=>'content',
                          ':c'=>'seoDescription'
                        ]);
                        echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=seoDescription" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i">lightbulb</i></button>':'';
                      }
                    }?>
                    <div class="input-text" data-el="seoDescription" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter a Meta Description..."><?=$r['seoDescription'];?></div>
                    <input class="textinput d-none" id="seoDescription" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="seoDescription" type="text" value="<?=$r['seoDescription'];?>">
                    <?=$user['options'][1]==1?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=seoDescription" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                    '<button class="save" id="saveseoDescription" data-dbid="seoDescription" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
<?php /*
                  <label for="tags">Tags</label>
                  <div class="form-row">
                    <input class="textinput" id="tags" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="tags" type="text" value="<?=$r['tags'];?>"<?=$user['options'][1]==1?' placeholder="Enter Tags..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="savetags" data-dbid="tags" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
*/ ?>
              </div>
            <?php }
/* Settings */ ?>
            <div class="tab1-9 border p-4" data-tabid="tab1-9" role="tabpanel">
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-3">
                  <label id="<?=$r['contentType'];?>Status" for="status"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Status" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Status Selector">&#128279;</a>':'';?>Status</label>
                  <div class="form-row">
                    <select id="status"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Status"':' disabled';?> onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');changeShareStatus($(this).val());">
                      <option value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                      <option value="autopublish"<?=$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                      <option value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                      <option value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
                      <option value="archived"<?=$r['status']=='archived'?' selected':'';?>>Archived</option>
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
                <div class="col-12 col-sm-6 pl-md-3">
                  <label id="<?=$r['contentType'];?>Rank" for="rank"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Rank" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Access Selector">&#128279;</a>':'';?>Access</label>
                  <div class="form-row">
                    <select id="rank" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rank"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','content','rank',$(this).val(),'select');toggleRank($(this).val());">
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
                    <div class="input-text<?=$r['rank']>300&&$r['rank']<400?' ':' d-none';?>" id="contentRestrict">
                      <input id="restrict" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="2" type="checkbox"<?=($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      &nbsp;<label>Restrict</label>
                    </div>
                  </div>
                </div>
                <script>
                  function toggleRank(rank){
                    if(rank<301){
                      $('#contentRestrict').removeClass().addClass('input-text d-none');
                    }
                    if(rank>300&&rank<400){
                      $('#contentRestrict').removeClass().addClass('input-text');
                    }
                    if(rank>399){
                      $('#contentRestrict').removeClass('d-none').addClass('input-text d-none');
                    }
                  }
                </script>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-3">
                  <label id="<?=$r['contentType'];?>ContentType" for="contentType"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'ContentType" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Content Type Selector">&#128279;</a>':'';?>contentType</label>
                  <div class="form-row">
                    <select id="contentType"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change the Type of Content this Item belongs to."':' disabled';?> onchange="update('<?=$r['id'];?>','content','contentType',$(this).val(),'select');">
                      <option value="article"<?=$r['contentType']=='article'?' selected':'';?>>Article</option>
                      <option value="portfolio"<?=$r['contentType']=='portfolio'?' selected':'';?>>Portfolio</option>
                      <option value="events"<?=$r['contentType']=='events'?' selected':'';?>>Event</option>
                      <option value="news"<?=$r['contentType']=='news'?' selected':'';?>>News</option>
                      <option value="testimonials"<?=$r['contentType']=='testimonials'?' selected':'';?>>Testimonial</option>
                      <option value="inventory"<?=$r['contentType']=='inventory'?' selected':'';?>>Inventory</option>
                      <option value="service"<?=$r['contentType']=='service'?' selected':'';?>>Service</option>
                      <option value="gallery"<?=$r['contentType']=='gallery'?' selected':'';?>>Gallery</option>
                      <option value="proofs"<?=$r['contentType']=='proofs'?' selected':'';?>>Proof</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pl-md-3">
                  <label id="<?=$r['contentType'];?>SubMenu" for="mid"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'SubMenu" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Sub Menu Selector">&#128279;</a>':'';?>SubMenu</label>
                  <div class="form-row">
                    <select id="mid"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','content','mid',$(this).val(),'select');">
                      <option value="0"<?=$r['mid']==0?' selected':'';?>>None</option>
                      <?php $sm=$db->prepare("SELECT `id`,`title` from `".$prefix."menu` WHERE `mid`=0 AND `mid`!=:mid AND active=1 ORDER BY `ord` ASC, `title` ASC");
                      $sm->execute([':mid'=>$r['id']]);
                      if($sm->rowCount()>0){
                        while($rm=$sm->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';
                      }?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#pin" data-tooltip="tooltip" aria-label="PermaLink to '.$r['contentType'].' Pinned Checkbox">&#128279;</a>':'';?>
                <input id="pin" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="pin" data-dbb="0" type="checkbox"<?=($r['pin']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label id="contentpin0<?=$r['id'];?>" for="pin">Pinned</label>
              </div>
              <?php if($r['contentType']=='inventory'){?>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#coming" data-tooltip="tooltip" aria-label="PermaLink to '.$r['contentType'].' Coming Soon Checkbox">&#128279;</a>':'';?>
                  <input id="coming" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="coming" data-dbb="0" type="checkbox"<?=($r['coming']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label id="contentcoming0<?=$r['id'];?>" for="coming">Coming Soon</label>
                </div>
              <?php }
              if($r['contentType']!='proofs'){?>
                <div class="row mt-3<?=$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs'?' hidden':'';?>">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Featured" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Featured Checkbox">&#128279;</a>':'';?>
                  <input id="<?=$r['contentType'];?>Featured" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0" type="checkbox"<?=($r['featured']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label id="contentfeatured0<?=$r['id'];?>" for="<?=$r['contentType'];?>Featured">Featured</label>
                </div>
              <?php }?>
              <div class="row mt-3">
                <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Internal" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Internal Checkbox">&#128279;</a>':'';?>
                <input id="<?=$r['contentType'];?>Internal" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0" type="checkbox"<?=($r['internal']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label id="contentinternal0<?=$r['id'];?>" for="<?=$r['contentType'];?>Internal">Internal</label>
              </div>
              <?php if($r['contentType']=='service'||$r['contentType']=='events'||$r['contentType']=='activities'){?>
                <div class="row mt-3">
                  <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'Bookable" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Bookable Checkbox">&#128279;</a>':'';?>
                  <input id="<?=$r['contentType'];?>Bookable" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0" type="checkbox"<?=($r['bookable']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label id="contentbookable0<?=$r['id'];?>" for="<?=$r['contentType'];?>Bookable">Bookable</label>
                </div>
              <?php }
              if($r['contentType']=='events'){?>
                <div class="col-12 mt-3">
                  <div class="row">
                    <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#'.$r['contentType'].'EnableMap" data-tooltip="tooltip" aria-label="PermaLink to '.ucfirst($r['contentType']).' Enable Map Checkbox">&#128279;</a>':'';?>
                    <input id="<?=$r['contentType'];?>Map" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="7" type="checkbox"<?=($r['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label id="contentoptions7<?=$r['id'];?>" for="<?=$r['contentType'];?>EnableMap">Enable Map Display</label>
                  </div>
                </div>
                <?php if($config['mapapikey']==''){?>
                  <div class="col-12">
                    There is currently no Map API Key entered on the <a href="<?= URL.$settings['system']['admin'].'/preferences/contact';?>">Preferences -> Contact</a> page, to allow Maps to be displayed on pages.<br>
                    Maps are displayed with the help of the Leaflet addon for it's ease of use.<br>
                    To obtain an API Key to access Mapping, please register at <a href="https://account.mapbox.com/access-tokens/">Map Box</a>.
                  </div>
                <?php }else{?>
                  <div class="col-12">
                    <div class="form-text">Drag the map marker to update your Location.</div>
                  </div>
                  <div class="col-12">
                    <div class="row" style="width:100%;height:600px;" id="map"></div>
                  </div>
                  <script>
                    <?php if($r['geo_position']==''){?>
                      navigator.geolocation.getCurrentPosition(
                        function(position){
                          var map=L.map('map').setView([position.coords.latitude,position.coords.longitude],13);
                          L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                            attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom:18,
                            id:'mapbox/streets-v11',
                            tileSize:512,
                            zoomOffset:-1,
                            accessToken:'<?=$config['mapapikey'];?>'
                          }).addTo(map);
                          var myIcon=L.icon({
                            iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                            iconSize:[38,95],
                            iconAnchor:[22,94],
                            popupAnchor:[-3,-76],
                            shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                            shadowSize:[68,95],
                            shadowAnchor:[22,94]
                          });
                          var marker=L.marker([position.coords.latitude,position.coords.longitude],{draggable:<?=($user['options'][1]==1?'true':'false');?>,}).addTo(map);
                          window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
                          window.top.window.toastr["info"]("Best location guess has been made from your browser location API!");
                          var popupHtml=`<strong><?=($r['title']!=''?$r['title']:'<mark>Fill in Title Field</mark>');?></strong><small><?=($r['address']!=''?'<br>'.$r['address'].',<br>'.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].',<br>'.$r['country']:'');?></small>`;
                          marker.bindPopup(popupHtml).openPopup();
                          marker.on('dragend',function(event){
                            var marker=event.target;
                            var position=marker.getLatLng();
                            update(`<?=$r['id'];?>`,'content','geo_position',position.lat+','+position.lng);
                            window.top.window.toastr["success"]("Map Marker position updated!");
                            marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                            map.panTo(new L.LatLng(position.lat,position.lng))
                          });
                        },
                        function(){
                          var map=L.map('map').setView([-24.287,136.406],4);
                          L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                            attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom:18,
                            id:'mapbox/streets-v11',
                            tileSize:512,
                            zoomOffset:-1,
                            accessToken:'<?=$config['mapapikey'];?>'
                          }).addTo(map);
                          var myIcon=L.icon({
                            iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                            iconSize:[38,95],
                            iconAnchor:[22,94],
                            popupAnchor:[-3,-76],
                            shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                            shadowSize:[68,95],
                            shadowAnchor:[22,94]
                          });
                          var marker=L.marker([-24.287,136.406],{draggable:<?=($user['options'][1]==1?'true':'false');?>,}).addTo(map);
                          window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
                          window.top.window.toastr["info"]("Unable to get your location via browser, location has been set so you can choose!");
                          var popupHtml=`<strong><?=($r['title']!=''?$r['title']:'<mark>Fill in Title Field</mark>');?></strong><small><?=($r['address']!=''?'<br>'.$r['address'].',<br>'.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].',<br>'.$r['country']:'');?></small>`;
                          marker.bindPopup(popupHtml).openPopup();
                          marker.on('dragend',function(event){
                            var marker=event.target;
                            var position=marker.getLatLng();
                            update(`<?=$r['id'];?>`,'content','geo_position',position.lat+','+position.lng);
                            window.top.window.toastr["success"]("Map Marker position updated!");
                            marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                            map.panTo(new L.LatLng(position.lat,position.lng))
                          });
                        }
                      );
                    <?php }else{?>
                      var map=L.map('map').setView([<?=$r['geo_position'];?>],13);
                      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        maxZoom:18,
                        id:'mapbox/streets-v11',
                        tileSize:512,
                        zoomOffset:-1,
                        accessToken:'<?=$config['mapapikey'];?>'
                      }).addTo(map);
                      var myIcon=L.icon({
                        iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                        iconSize:[38,95],
                        iconAnchor:[22,94],
                        popupAnchor:[-3,-76],
                        shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                        shadowSize:[68,95],
                        shadowAnchor:[22,94]
                      });
                      var marker=L.marker([<?=$r['geo_position'];?>],{draggable:<?=($user['options'][1]==1?'true':'false');?>,}).addTo(map);
                      var popupHtml=`<strong><?=($r['title']!=''?$r['title']:'<mark>Fill in Title Field</mark>');?></strong><small><?=($r['address']!=''?'<br>'.$r['address'].',<br>'.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].',<br>'.$r['country']:'');?></small>`;
                      marker.bindPopup(popupHtml);
                      marker.on('dragend',function(event){
                        var marker=event.target;
                        var position=marker.getLatLng();
                        update(`<?=$r['id'];?>`,'content','geo_position',position.lat+','+position.lng);
                        window.top.window.toastr["success"]("Map Marker position updated!");
                        marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                        map.panTo(new L.LatLng(position.lat,position.lng))
                      });
                    <?php }?>
                    $("#tab1-9").on('click',function(){
                      map.invalidateSize(false);
                    });
                  </script>
                <?php }
                }?>
              </div>
<?php if($r['contentType']=='events'){?>
              <div class="tab1-10 border p-4" data-tabid="tab1-10" role="tabpanel">
                <div class="row">
                  <?php $sbb=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='booking' AND `rid`=:rid ORDER BY `ti` DESC");
                  $sbb->execute([':rid'=>$r['id']]);
                  if($sbb->rowCount()>0){
                    while($rbb=$sbb->fetch(PDO::FETCH_ASSOC)){
                      $sbu=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `email`=:email LIMIT 1");
                      $sbu->execute([':email'=>$rbb['email']]);
                      if($sbu->rowCount()>0){
                        $rbu=$sbu->fetch(PDO::FETCH_ASSOC);
                      }
                      echo'<div class="form-row col-12">'.
                        ($sbu->rowCount()>0?'':'<button class="btn add" data-tooltip="tooltip" aria-label="Create Account for Contacts"><i class="i">address-card</i></button>').
                        '<div class="input-text col-12 col-sm"><small>'.(isset($rbu['name'])?$rbu['name']:$rbb['name']).($rbb['business']!=''?' | '.$rbb['business']:'').'</small></div>'.
                        '<div class="input-text col-12 col-sm"><a href="mailto:'.$rbb['email'].'">'.$rbb['email'].'</a></div>';
                        if($rbb['category_1']!=''){
                          $sbo=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `iid`=:iid");
                          $sbo->execute([':iid'=>$rbb['category_1']]);
                          if($sbo->rowCount()>0){
                            $rbo=$sbo->fetch(PDO::FETCH_ASSOC);
                            echo'<div class="input-text col-12 col-sm">Order&nbsp;<a href="'.URL.$settings['system']['admin'].'/orders/edit/'.$rbo['id'].'">#'.$rbo['iid'].'</a>&nbsp;&nbsp;<span class="badger badge-'.$rbo['status'].'">'.ucwords($rbo['status']).'</span></div>';
                          }
                        }
                        echo'<div class="input-text col-12 col-sm">Booking Status:&nbsp;<span class="badger badge-'.$rbb['status'].'">'.ucwords($rbb['status']).'</span></div>'.
                        '<a class="btn" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$rbb['id'].'" data-tooltip="tooltip" aria-label="Go to Booking"><i class="i">calendar</i></a>'.
                      '</div>';
                    }
                  }?>
                </div>
              </div>
            <?php }
            if($r['contentType']!='testimonials'){?>
              <div class="tab1-11 border p-4" data-tabid="tab1-11" role="tabpanel">
                <section class="content overflow-visible theme-chooser" id="templates">
                  <article class="card col-12 col-sm-3 m-2 overflow-visible theme<?=$r['templatelist']==0?' theme-selected':'';?>" id="l_0" data-template="0">
                    <figure class="card-image">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 180" fill="none"></svg>
                      <div class="image-toolbar overflow-visible">
                        <i class="i icon enable text-white i-4x pt-2 pr-1">approve</i>
                      </div>
                    </figure>
                    <div class="card-header line-clamp">
                      Theme Generated
                    </div>
                    <div class="card-body no-clamp">
                      <p class="small"><small>This selection uses the item template in the theme file.</small></p>
                    </div>
                  </article>
                  <?php $st=$db->prepare("SELECT * FROM `".$prefix."templates` WHERE `contentType`='all' ORDER BY `contentType` ASC, `section` ASC");
                  $st->execute();
                  while($rt=$st->fetch(PDO::FETCH_ASSOC)){?>
                    <article class="card col-12 col-sm-3 m-2 overflow-visible theme<?=$rt['id']==$r['templatelist']?' theme-selected':'';?>" id="l_<?=$rt['id'];?>" data-template="<?=$rt['id'];?>">
                      <figure class="card-image position-relative overflow-visible">
                        <?=$rt['image'];?>
                        <div class="image-toolbar overflow-visible">
                          <i class="i icon enable text-white i-4x pt-2 pr-1">approve</i>
                        </div>
                      </figure>
                      <div class="card-header line-clamp">
                        <?=$rt['title'];?>
                      </div>
                      <div class="card-body no-clamp">
                        <p class="small"><small><?=$rt['notes'];?></small></p>
                      </div>
                    </article>
                  <?php }?>
                </section>
                <script>
                  $(".theme-chooser").not(".disabled").find("figure.card-image").on("click",function(){
                    $('#templates .theme').removeClass("theme-selected");
                    $(this).parent('article').addClass("theme-selected");
                    $('#notheme').addClass("hidden");
                    $.ajax({
                      type:"GET",
                      url:"core/update.php",
                      data:{
                        id:"<?=$r['id'];?>",
                        t:"content",
                        c:"templatelist",
                        da:$(this).parent('article').attr("data-template")
                      }
                    });
                  });
                </script>
              </div>
            <?php }
            if($r['contentType']=='inventory'){?>
              <div class="tab1-12 border" data-tabid="tab1-12" role="tabpanel">
                <section class="row list">
                  <?php $si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `iid`=:iid ORDER BY `ti` DESC");
                  $si->execute([':iid'=>$r['id']]);
                  while($ri=$si->fetch(PDO::FETCH_ASSOC)){
                    $so=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
                    $so->execute([':id'=>$ri['oid']]);
                    if($so->rowCount()>0){
                      $ro=$so->fetch(PDO::FETCH_ASSOC);
                      $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                      $su->execute([':id'=>$ro['uid']]);
                      $ru=$su->fetch(PDO::FETCH_ASSOC);?>
                      <article class="card zebra m-0 p-2 border-0 overflow-visible" id="l_<?=$ro['id'];?>">
                        <div class="row">
                          <div class="col-sm">
                            <a href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$ro['id']?>"><?=($ro['aid']!=''?$ro['aid'].'<br>':'').$ro['qid'].$ro['iid'];?></a>
                          </div>
                          <div class="col-sm small">
                            Date:&nbsp;<?=' '.date($config['dateFormat'],($ro['iid_ti']==0?$ro['qid_ti']:$ro['iid_ti']));?><br>
                            <small>Due:&nbsp;<?=$ro['due_ti']>0?date($config['dateFormat'],$ro['due_ti']):'';?></small>
                          </div>
                          <div class="col-sm text-center">
                            <span class="badger badge-<?=$ro['status'];?> badge-2x"><?= ucfirst($ro['status']);?></span>
                          </div>
                          <div class="col-sm">
                            <div id="controls_<?=$ro['id'];?>" class="justify-content-end">
                              <div class="btn-group float-right" role="group">
                                <button class="print" data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/email_order.php?id=<?=$ro['id'];?>&act=print');"><i class="i">print</i></button>
                                <?= isset($ru['email'])&&$ru['email']!=''?'<button class="email" data-tooltip="tooltip" aria-label="Email Order" onclick="$(\'#sp\').load(\'core/email_order.php?id='.$ro['id'].'&act=\');"><i class="i">email-send</i></button>':'';?>
                                <a class="<?=$user['options'][0]==1?' rounded-right':'';echo$ro['status']=='delete'?' d-none':'';?>" href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$ro['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                                <?php if($user['options'][0]==1){?>
                                  <button class="add<?=$ro['status']!='delete'?' d-none':'';?>" id="untrash<?=$ro['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$ro['id'];?>','orders','status','');"><i class="i">untrash</i></button>
                                  <button class="trash<?=$ro['status']=='delete'?' d-none':'';?>" id="delete<?=$ro['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$ro['id'];?>','orders','status','delete');"><i class="i">trash</i></button>
                                  <button class="purge<?=$ro['status']!='delete'?' d-none':'';?>" id="purge<?=$ro['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$ro['id'];?>','orders')"><i class="i">purge</i></button>
                                  <button class="quickeditbtn" data-qeid="<?=$ro['id'];?>" data-qet="orders" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>
                                <?php }?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </article>
                      <div class="quickedit d-none" id="quickedit<?=$ro['id'];?>"></div>
                    <?php }
                  }?>
                </section>
              </div>
            <?php }
/* List */
            if($r['contentType']=='article'){?>
              <div class="tab1-13 border" data-tabid="tab1-13" role="tabpanel">
                <?php if($user['options'][1]==1){?>
                  <form target="sp" method="post" action="core/add_list.php">
                    <input name="rid" type="hidden" value="<?=$r['id'];?>">
                    <div class="row">
                      <div class="col-2">
                        <label for="lid" class="m-2">Link ID</label>
                      </div>
                      <div class="col-10">
                        <input id="lid" name="lid" type="text" value="" placeholder="Link ID...">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="lh" class="m-2">Heading</label>
                      </div>
                      <div class="col-10">
                        <input id="lh" name="lh" type="text" value="" placeholder="Heading...">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="limage" class="m-2">Image/Video</label>
                      </div>
                      <div class="col-10">
                        <div class="form-row">
                          <input id="limage" name="li" type="text" value="" placeholder="Image/Video...">
                          <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage`);return false;"><i class="i">browse-media</i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="limage2" class="m-2">Image/Video 2</label>
                      </div>
                      <div class="col-10">
                        <div class="form-row">
                          <input id="limage2" name="li2" type="text" value="" placeholder="Image/Video 2...">
                          <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage2`);return false;"><i class="i">browse-media</i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="limage3" class="m-2">Image/Video 3</label>
                      </div>
                      <div class="col-10">
                        <div class="form-row">
                          <input id="limage3" name="li3" type="text" value="" placeholder="Image/Video 3...">
                          <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage3`);return false;"><i class="i">browse-media</i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="limage4" class="m-2">Image/Video 4</label>
                      </div>
                      <div class="col-10">
                        <div class="form-row">
                          <input id="limage4" name="li4" type="text" value="" placeholder="Image/Video 4...">
                          <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage4`);return false;"><i class="i">browse-media</i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="lu" class="m-2">URL</label>
                      </div>
                      <div class="col-10">
                        <input id="lu" name="lu" type="text" value="" placeholder="URL...">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="lda" class="m-2">Notes</label>
                      </div>
                      <div class="col-10">
                        <textarea id="lda" name="lda"></textarea>
                      </div>
                    </div>
                    <div class="text-right">
                      <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                    </div>
                  </form>
                <?php }?>
                <section id="list" class="row m-1">
                  <?php $sl=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='list' AND `rid`=:rid ORDER BY `ord` ASC, `ti` ASC");
                  $sl->execute([':rid'=>$r['id']]);
                  while($rl=$sl->fetch(PDO::FETCH_ASSOC)){?>
                    <div id="l_<?=$rl['id'];?>" class="card col-12 mx-0 my-1 m-sm-1 overflow-visible">
                      <div class="row">
                        <?php $slm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `rid`=:id ORDER BY `ord` ASC, `ti` ASC LIMIT 4");
                        $slm->execute([':id'=>$rl['id']]);
                        $slmc=$slm->rowCount();
                        if($slmc>0){
                          echo'<div class="col-12 col-sm-4 list-images-'.$slmc.' overflow-hidden">';
                          while($rlm=$slm->fetch(PDO::FETCH_ASSOC)){
                            if(stristr($rlm['file'],'youtu')){
                              preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$rlm['file'],$vidMatch);
                              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$rlm['file'].'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
                                '<img class="note-video-clip" src="'.$rlm['thumb'].'">'.
                                '<div class="play"></div>'.
                              '</div>';
                            }elseif(stristr($rlm['file'],'vimeo')){
                              preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$rlm['file'],$vidMatch);
                              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$rlm['file'].'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'">'.
                                '<img class="note-video-clip" src="https://vumbnail.com/'.$vidMatch[5].'.jpg">'.
                                '<div class="play"></div>'.
                              '</div>';
                            }else
                              echo'<a data-fancybox="list" href="'.$rlm['file'].'"><img src="'.$rlm['thumb'].'" alt="'.$lh.'"></a>';
                          }
                          echo'</div>';
                        }?>
                        <div class="card-footer col-12 col-sm m-0 p-1">
                          <div class="row m-0 p-0">
                            <div class="col-12 small m-0 p-0">
                              <?=($rl['title']!=''?'<div class="h6 col-12">'.$rl['title'].'</div>':'');?>
                              <?=$rl['notes'];?>
                              <?=($rl['urlSlug']!=''?' <a target="_blank" href="'.$rl['urlSlug'].'">More...</a>':'');?>
                            </div>
                            <?php if($user['options'][0]==1){?>
                              <div class="col-12 text-right">
                                <a class="btn-sm" href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$rl['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                                <button class="btn-sm trash" id="purge<?=$rl['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$rl['id'];?>','content')"><i class="i">trash</i></button>
                                <span class="btn btn-sm orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>
                              </div>
                            <?php }?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                  <div class="ghost hidden">&nbsp;</div>
                </section>
              </div>
              <script>
                $('#list').sortable({
                  items:".card",
                  handle:'.orderhandle',
                  placeholder:".ghost",
                  helper:fixWidthHelper,
                  axis:"y",
                  update:function(e,ui){
                    var order=$("#list").sortable("serialize");
                    $.ajax({
                      type:"POST",
                      dataType:"json",
                      url:"core/reorderlist.php",
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
