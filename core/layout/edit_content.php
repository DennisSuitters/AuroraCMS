<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content - Edit
 * @package    core/layout/edit_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$r=$s->fetch(PDO::FETCH_ASSOC);
$sv=$db->prepare("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `contentType`=:cT");
$sv->execute([':cT'=>$r['contentType']]);
$seo=[
  'contentNotesHeading' => '',
  'contentNotes' => '',
  'contentImagesNotes' => '',
  'contentcnt' => 0,
  'notescnt' => 0,
  'seoTitle' => '',
  'seoDescription' => '',
  'seocnt' => 0,
  'imagesALT' => '',
  'imagescnt' => 0,
  'imagesFile' => ''
];
if(!in_array($r['contentType'],['testimonials','list'])){
  if($r['seoTitle']==''){
    $seo['seoTitle']='<div>The <strong>Meta Title</strong> is empty, while AuroraCMS tries to autofill this entry when building the page, it is better to fill in this information yourself!</div>';
    $seo['seocnt']++;
  }elseif(strlen($r['seoTitle'])<20){
    $seo['seoTitle']='<div>The <strong>Meta Title</strong> is less than <strong>50</strong> characters!</div>';
    $seo['seocnt']++;
  }elseif(strlen($r['seoTitle'])>70){
    $seo['seoTitle']='<div>The <strong>Meta Title</strong> is longer than <strong>70</strong> characters!</div>';
    $seo['seocnt']++;
  }
  if($r['seoDescription']==''){
    $seo['seoDescription']='<div>The <strong>Meta Description</strong> is empty, while AuroraCMS tries to autofill this entry when building the page, it is better to fill in this information yourself!</div>';
    $seo['seocnt']++;
  }elseif(strlen($r['seoDescription'])<70){
    $seo['seoDescription']='<div>The <strong>Meta Description</strong> is less than <strong>70</strong> characters!</div>';
    $seo['seocnt']++;
  }elseif(strlen($r['seoDescription'])>160){
    $seo['seoDescription']='<div>The <strong>Meta Description</strong> is longer than <strong>160</strong> characters!</div>';
    $seo['seocnt']++;
  }
  if($r['file']!=''){
    if(strlen($r['fileALT'])<1){
      $seo['imagesALT']='<div>The <strong>Image ALT</strong> text is empty!</div>';
      $seo['imagescnt']++;
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
    $seo['contentNotesHeading']='<div>Do not use <strong>H1</strong> headings in the <strong>Description</strong> Text, as AuroraCMS uses the <strong>Title</strong> Field to place H1 headings on page, and uses them for other areas for SEO!</div>';
    $seo['contentcnt']++;
  }
}?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="row">
        <div class="card col-12 mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-6">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
                  <li class="breadcrumb-item active"><?=($r['contentType']!='list'?'<a href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).(in_array($r['contentType'],array('article'))?'s':'').'</a>':'List');?></li>
                  <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                  <li class="breadcrumb-item active"><?=$r['title'];?></li>
                </ol>
              </div>
              <div class="col-12 col-sm-6 text-right">
                <div class="btn-group d-inline">
                  <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                  '<button class="'.($r['status']=='published'?'':'hidden').'" data-social-share="'.URL.$r['contentType'].'/'.$r['urlSlug'].'" data-social-desc="'.($r['seoDescription']?$r['seoDescription']:$r['title']).'" data-tooltip="left" aria-label="Share on Social Media"><i class="i">share</i></button>'.
                  ($user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/add/'.$r['contentType'].'" role="button" data-tooltip="left" aria-label="Add '.ucfirst($r['contentType']).'"><i class="i">add</i></a>':'').
                  ($user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/copy/'.$r['contentType'].'/'.$r['id'].'" role="button" data-tooltip="left" aria-label="Duplicate '.ucfirst($r['contentType']).'"><i class="i">copy</i></a>':'').
                  ($user['options'][1]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="tabs" role="tablist">
            <?='<input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>'.
            '<label for="tab1-1"'.($seo['contentcnt']>0?' class="badge" data-badge="'.$seo['contentcnt'].'"':'').'>'.($seo['contentcnt']>0?'<span data-tooltip="tooltip" title aria-label="There'.($seo['contentcnt']>1?' are '.$seo['contentcnt'].' SEO related issues!':' is 1 SEO related issue!').'">Content</span>':'Content').'</label>'.
            (in_array($r['contentType'],['event','inventory','service','events','activities'])?'<input class="tab-control" id="tab1-2" name="tabs" type="radio"><label for="tab1-2">Pricing</label>':'').
            '<input class="tab-control" id="tab1-3" name="tabs" type="radio"><label for="tab1-3"'.($seo['imagescnt']>0?' class="badge" data-badge="'.$seo['imagescnt'].'"':'').'>'.($seo['imagescnt']>0?'<span data-tooltip="tooltip" aria-label="There'.($seo['imagescnt']>1?' are '.$seo['imagescnt'].' SEO related issues!':' is 1 SEO related issue!').'">Media</span>':'Media').'</label>'.
            ($r['contentType']=='inventory'?'<input class="tab-control" id="tab1-4" name="tabs" type="radio"><label for="tab1-4">Options</label>':'').
            ($r['contentType']=='article'?'<input class="tab-control" id="tab1-5" name="tabs" type="radio"><label for="tab1-5">Comments</label>':'').
            (in_array($r['contentType'],['inventory','activities','service'])?'<input class="tab-control" id="tab1-6" name="tabs" type="radio"><label for="tab1-6">Reviews</label>':'').
            (in_array($r['contentType'],['article','inventory','service'])?'<input class="tab-control" id="tab1-7" name="tabs" type="radio"><label for="tab1-7">Related</label>':'').
            (!in_array($r['contentType'],['testimonials','proofs','list'])?'<input class="tab-control" id="tab1-8" name="tabs" type="radio"><label for="tab1-8" id="seo"'.($seo['seocnt']>0?' class="badge" data-badge="'.$seo['seocnt'].'"':'').'>'.($seo['seocnt']>0?'<span data-tooltip="tooltip" aria-label="There'.($seo['seocnt']>1?' are '.$seo['seocnt'].' SEO related issues!':' is 1 SEO related issue!').'">SEO</span>':'SEO').'</label>':'').
            ($r['contentType']!='list'?'<input class="tab-control" id="tab1-9" name="tabs" type="radio"><label for="tab1-9">Settings</label>':'').
            ($r['contentType']=='events'?'<input class="tab-control" id="tab1-10" name="tabs" type="radio"><label for="tab1-10">Bookings</label>':'').
            (!in_array($r['contentType'],['testimonials','list'])?'<input class="tab-control" id="tab1-11" name="tabs" type="radio"><label for="tab1-11">Template</label>':'').
            ($r['contentType']=='inventory'?'<input class="tab-control" id="tab1-12" name="tabs" type="radio"><label for="tab1-12">Purchases</label>':'').
            (in_array($r['contentType'],['events','inventory','service','course','article'])?'<input class="tab-control" id="tab1-15" name="tabs" type="radio"><label for="tab1-15" data-tooltip="tooltip" aria-label="Frequently Asked Questions">FAQ</label>':'').
            ($r['contentType']=='article'?'<input class="tab-control" id="tab1-13" name="tabs" type="radio"><label for="tab1-13">List</label>':'').
            (in_array($r['contentType'],['inventory','courses'])?'<input class="tab-control" id="tab1-14" name="tabs" type="radio"><label for="tab1-14">Analytics</label>':'');?>
<?php /* Content */?>
            <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
              <label for="title" class="mt-0">Title</label>
              <div class="form-row">
                <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information. Note: Content MUST contain a Title, to be able to generate a URL Slug or the content won't be accessible. This Title is also used For H1 Headings on pages."><i class="i">seo</i></button>
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
                <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Generate Aussie Lorem Ipsum Title" onclick="ipsuMe(`title`);genurl();$(`#titleupdate`).text($(`#title`).val());$(`#savetitle`).addClass(`btn-danger`);return false;"><i class="i">loremipsum</i></button>'.
                '<button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id='.$r['id'].'&t=content&c=title" data-tooltip="tooltip" aria-label="Add Suggestion"><i class="i">idea</i></button>'.
                '<button class="analyzeTitle" data-test="title" data-tooltip="tooltip" aria-label="Analyze Title Text"><i class="i">seo</i></button>'.
                '<button class="save" id="savetitle" data-dbid="title" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
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
              <?php if($r['contentType']=='list'){?>
                <label for="urlSlug">URL</label>
                <div class="form-row">
                  <input class="textinput" id="urlSlug" type="text" value="<?=$r['urlSlug'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="urlSlug" data-bs="trash"<?=$user['options'][1]==1?' placeholder="URL..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="saveurlSlug" data-dbid="urlSlug" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              <?php }else{?>
                <label for="genurl">URL Slug</label>
                <div class="form-row">
                  <div class="input-text col-12">
                    <a id="genurl" target="_blank" href="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>"><?= URL.$r['contentType'].'/'.$r['urlSlug'];?></a>
                  </div>
                </div>
              <?php }
              if($r['contentType']!='list'){?>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label for="ti">Created</label>
                    <div class="form-row">
                      <input id="ti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['ti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`ti`,getTimestamp(`ti`),`select`);"':' readonly';?>>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 pl-sm-3">
                    <label for="pti">Published On <span class="labeldate" id="labeldatepti">(<?= date($config['dateFormat'],$r['pti']);?>)</span></label>
                    <div class="form-row">
                      <input id="pti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['pti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`pti`,getTimestamp(`pti`),`select`);"':' readonly';?>>
                    </div>
                  </div>
                </div>
              <?php }
              if($r['contentType']=='proofs'){?>
                <label for="cid">Client</label>
                <div class="form-row">
                  <select id="cid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="cid" onchange="update('<?=$r['id'];?>','content','cid',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
                    <option value="0">Select a Client</option>
                    <?php $cs=$db->query("SELECT * FROM `".$prefix."login` ORDER BY name ASC, username ASC");
                    if($cs->rowCount()>0){
                      while($cr=$cs->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$cr['id'].'"'.($r['cid']==$cr['id']?' selected':'').'>'.$cr['username'].':'.$cr['name'].'</option>';
                    }?>
                  </select>
                </div>
              <?php }
              if($r['contentType']!='list'){?>
                <label for="uid" class="mt-0">Author</label>
                <div class="form-row">
                  <select id="uid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="uid"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','content','uid',$(this).val(),'select');">
                    <?php $su=$db->query("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `username`!='' AND `status`!='delete' ORDER BY `username` ASC, `name` ASC");
                    while($ru=$su->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$ru['id'].'"'.($ru['id']==$r['uid']?' selected':'').'>'.$ru['username'].':'.$ru['name'].'</option>';?>
                  </select>
                </div>
                <?php if($r['contentType']=='article'){?>
                  <label for="cuid">Co-Author's</label>
                  <div class="form-row">
                    <div class="input-text col-12" id="coauthors">&nbsp;
                      <?php $sc=$db->prepare("SELECT `id`,`username`,`name`,`avatar`,`gravatar`,`rank` FROM `".$prefix."login` WHERE `rank` > 399 ORDER BY `name` ASC, `username` ASC");
                      $sc->execute();
                      $coptions='';
                      $ca=explode(",",$r['cuid']);
                      while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
                        $aimg=($rc['avatar']!=''?'media/avatar/'.$rc['avatar']:NOAVATAR);
                        if(in_array($rc['id'],$ca)){
                          echo'<span id="coauthors'.$rc['id'].'" class="badger badge-'.rank($rc['rank']).' mr-2 cursor-default" id="cuid'.$rc['id'].'"><img class="mr-2" src="'.$aimg.'" style="max-width:16px;height:16px;">'.($rc['name']!=''?$rc['name']:$rc['username']).'<i class="i pl-2 cursor-pointer" onclick="removeCoauthor(`'.$rc['id'].'`);">close</i></span>';
                        }
                        $coptions.='<option id="cuidopt'.$rc['id'].'" value="'.$rc['id'].'" data-authorname="'.($rc['name']!=''?$rc['name']:$rc['username']).'" data-authorimg="'.$aimg.'" data-authorrank="'.rank($rc['rank']).'">'.
                          ($rc['name']!=''?$rc['name']:$rc['username']).
                        '</option>';
                      }?>
                    </div>
                  </div>
                  <div class="form-row">
                    <input id="cuid" type="hidden" value="<?=$r['cuid'];?>">
                    <select onchange="modifyCoauthor($(this).val());">
                      <option value="0">Select a User to add as a Co-Author</option>
                      <option value="clear">Clear All</option>
                      <hr>
                      <?=$coptions;?>
                    </select>
                  </div>
                  <script>
                    function removeValue(list,value){
                      return list.replace(new RegExp(",?"+value+",?"),function(match){
                        var first_comma=match.charAt(0)===',',second_comma;
                        if(first_comma&&(second_comma=match.charAt(match.length- 1)===',')){
                          return',';
                        }
                        return'';
                      });
                    };
                    function removeCoauthor(id){
                      var authors=removeValue($('#cuid').val(),id);
                      $('#cuid').val(authors);
                      $('#coauthors'+id).remove();
                      update(<?=$r['id'];?>,'content','cuid',authors);
                    }
                    function modifyCoauthor(id){
                      if(id=='0')return false;
                      if(id=='clear'){
                        $('#coauthors').html('&nbsp;');
                        $('#cuid').val('');
                        update(<?=$r['id'];?>,'content','cuid','');
                      }else{
                        var uid=$('#uid').val()
                        if(uid==id){
                          toastr["warning"]("User is already set as the Lead Author!");
                        }else{
                          var ids=$('#cuid').val();
                          var authorname=$('#cuidopt'+id).data('authorname');
                          var authorimg=$('#cuidopt'+id).data('authorimg');
                          var authorrank=$('#cuidopt'+id).data('authorrank');
                          if(ids.split(",").indexOf(id.toString()) === -1){
                            if(ids.length > 0){
                              ids+=',';
                            }
                            ids+=id;
                            update(<?=$r['id'];?>,'content','cuid',ids);
                            $('#cuid').val(ids);
                            $('#coauthors').append('<span id="coauthors'+id+'" class="badger badge-'+authorrank+' mr-2 cursor-default"><img class="mr-2" src="'+authorimg+'" style="max-width:16px;height:16px;">'+authorname+'<i class="i pl-2 cursor-pointer" onclick="removeCoauthor(`'+id+'`);">close</i></span>');
                          }else{
                            toastr["warning"](authorname+" is already added as a Co-Author!");
                          }
                        }
                      }
                    }
                  </script>
                <?php }
              }?>
              <div class="row">
                <?php if($r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']!='list'){?>
                  <div class="col-12 col-sm pr-sm-3">
                    <label for="code">Code</label>
                    <div class="form-row">
                      <input class="textinput" id="code" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="code" type="text" value="<?=$r['code'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Code..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savecode" data-dbid="code" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                <?php }
                if($r['contentType']=='inventory'){?>
                  <div class="col-12 col-sm pr-sm-3">
                    <label for="barcode">Barcode</label>
                    <div class="form-row">
                      <input class="textinput" id="barcode" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="barcode" type="text" value="<?=$r['barcode'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Barcode..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savebarcode" data-dbid="barcode" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm">
                    <label for="fccid">FCCID<?=$user['options'][1]==1?'<i class="i ml-3" data-tooltip="tooltip" aria-label="Visit https://fccid.io/ for more information or to look up an FCC ID.">help</i>':'';?></label>
                    <div class="form-row">
                      <input class="textinput" id="fccid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="fccid" type="text" value="<?=$r['fccid'];?>"<?=$user['options'][1]==1?' placeholder="Enter an FCCID..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savefccid" data-dbid="fccid" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                <?php }?>
              </div>
              <?php if($r['contentType']=='inventory'){?>
                <label for="brand">Brand</label>
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
                    <label for="tis">Event Start <span class="labeldate" id="labeldatetis"><?= $r['tis']>0?date($config['dateFormat'],$r['tis']):'';?></span></label>
                    <div class="form-row">
                      <input id="tis" type="datetime-local" value="<?=$r['tis']!=0?date('Y-m-d\TH:i',$r['tis']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tis`,getTimestamp(`tis`));"':' readonly';?>>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4 pr-md-3">
                    <label for="tie">Event End <span class="labeldate" id="labeldatetie"><?= $r['tie']>0?date($config['dateFormat'],$r['tie']):'';?></span></label>
                    <div class="form-row">
                      <input id="tie" type="datetime-local" value="<?=$r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tie`,getTimestamp(`tie`));"':' readonly';?>>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4 pl-md-3">
                    <div class="form-row mt-5">
                      <input id="<?=$r['contentType'];?>showCountdown" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="3" type="checkbox"<?=($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <label for="<?=$r['contentType'];?>showCountdown" id="contentoptions3<?=$r['id'];?>">Show Countdown</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6 pr-sm-3">
                    <label for="address">Address</label>
                    <div class="form-row">
                      <input class="textinput" id="address" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="address" type="text" value="<?=$r['address'];?>"<?=($user['options'][1]==1?' placeholder="Enter an Address..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="saveaddress" data-dbid="address" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="suburb">Suburb</label>
                    <div class="form-row">
                      <input class="textinput" id="suburb" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="suburb" type="text" value="<?=$r['suburb'];?>"<?=($user['options'][1]==1?' placeholder="Enter a Suburb..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savesuburb" data-dbid="suburb" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-3 pr-sm-3">
                    <label for="city">City</label>
                    <div class="form-row">
                      <input class="textinput" id="city" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="city" type="text" value="<?=$r['city'];?>"<?=($user['options'][1]==1?' placeholder="Enter a City..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savecity" data-dbid="city" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-3 pl-sm-3 pr-sm-3">
                    <label for="state">State</label>
                    <div class="form-row">
                      <input class="textinput" id="state" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="state" type="text" value="<?=$r['state'];?>"<?=($user['options'][1]==1?' placeholder="Enter a State..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savestate" data-dbid="state" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-md-3 pr-sm-3">
                    <label for="postcode">Postcode</label>
                    <div class="form-row">
                      <input class="textinput" id="postcode" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="postcode" type="text" value="<?=$r['postcode']!=0?$r['postcode']:'';?>"<?=($user['options'][1]==1?' placeholder="Enter a Postcode..."':' readonly');?>>
                      <?=($user['options'][1]==1?'<button class="save" id="savepostcode" data-dbid="postcode" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-3 pl-sm-3">
                    <label for="country">Country</label>
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
                  <div class="col-12 col-sm-4">
                    <label for="name">Name</label>
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
                  <div class="col-12 col-sm-4 pl-sm-3">
                    <label for="email">Email</label>
                    <div class="form-row">
                      <input class="textinput" id="email" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="email" type="text" value="<?=$r['email'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Email..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="saveemail" data-dbid="email" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4 pl-sm-3">
                    <label for="business">Business</label>
                    <div class="form-row">
                      <input class="textinput" id="business" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="business" type="text" value="<?=$r['business'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Business..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savebusiness" data-dbid="business" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6 pr-md-3">
                    <label for="url">URL</label>
                    <div class="form-row">
                      <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="url" type="text" value="<?=$r['url'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="saveurl" data-dbid="url" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 pl-md-3 p-0 pb-2">
                    <label class="mb-0" for="rating">Rating</label>
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
              if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='event'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
                <div class="row">
                  <div class="col-12 col-sm">
                    <label for="category_1">Category One</label>
                    <div class="form-row">
                      <input class="textinput" id="category_1" list="category_1_options" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="category_1" type="text" value="<?=$r['category_1'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Category or Select from List..."':' readonly';?>>
                      <?php if($user['options'][1]==1){
                        $sc=$db->prepare("SELECT DISTINCT `title` FROM `".$prefix."choices` WHERE `title`!='' AND `contentType`='category' AND `url`=:url ORDER BY `title` ASC");
                        $sc->execute([':url'=>$r['contentType']]);
                        if($sc->rowCount()>0){
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['title'].'"/>';
                        }
                        $sc=$db->query("SELECT DISTINCT `category_1` FROM `".$prefix."content` WHERE `category_1`!='' ORDER BY `category_1` ASC");
                        if($sc->rowCount()>0){
                          echo'<datalist id="category_1_options">';
                            while($rc=$sc->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rc['category_1'].'"/>';
                          echo'</datalist>';
                        }
                        echo'<button class="save" id="savecategory_1" data-dbid="category_1" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>';
                      }?>
                    </div>
                  </div>
                  <div class="col-12 col-sm pl-sm-3">
                    <label for="category_2">Category Two</label>
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
                  <div class="col-12 col-sm pl-sm-3">
                    <label for="category_3">Category Three</label>
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
                  <div class="col-12 col-sm pl-sm-3">
                    <label for="category_4">Category Four</label>
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
                <div class="row">
                  <label for="tags">Tags</label>
                  <div class="form-row">
                    <input class="textinput" id="tags" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="tags" type="text" value="<?=$r['tags'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Tag or Select from List..."':' readonly';?>>
                    <?=($user['options'][1]==1?'<button class="save" id="savetags" data-dbid="tags" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                  </div>
                  <script>
                    var input=document.querySelector('#tags');
                    tagify=new Tagify(input,{
                      whitelist:[
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
                          foreach($tags as $t)echo'"'.$t.'",';
                        }?>
                      ],
                      maxTags:10,
                      dropdown:{
                        maxItems:20,
                        classname:"tags-look",
                        enabled:0,
                        closeOnSelect:false
                      },
                      originalInputValueFormat:valuesArr => valuesArr.map(item => item.value).join(',')
                    });
                  </script>
                </div>
              <?php }
              if($r['contentType']=='events'){?>
                <div class="col-12">
                  <label for="exturl">External URL</label>
                  <div class="form-row">
                    <input class="textinput" id="exturl" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="exturl" type="text" value="<?=$r['exturl'];?>" placeholder="Enter an External URL (Zoom or other Service)...">
                    <?=$user['options'][1]==1?'<button class="save" id="saveexturl" data-dbid="exturl" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                </div>
              <?php }?>
              <div class="row mt-4<?=$seo['contentNotes']!=''||$seo['contentNotesHeading']!=''||$seo['contentImagesNotes']!=''?' border-danger border-2':'';?>">
                <?php echo($seo['contentNotes']!=''||$seo['contentNotesHeading']||$seo['contentImagesNotes']!=''?'<div class="alert alert-warning m-0">'.$seo['contentNotesHeading'].$seo['contentNotes'].$seo['contentImagesNotes'].'</div>':'');
                if($user['options'][1]==1){?>
                  <div class="wysiwyg-toolbar">
                    <div class="btn-group d-flex justify-content-end">
                      <?php if($r['suggestions']==1){
                        $ss=$db->prepare("SELECT `rid` FROM `".$prefix."suggestions` WHERE `rid`=:rid AND `t`=:t AND `c`=:c");
                        $ss->execute([
                          ':rid'=>$r['id'],
                          ':t'=>'content',
                          ':c'=>'notes'
                        ]);
                        echo$ss->rowCount()>0?'<button data-fancybox data-type="ajax" data-src="core/layout/suggestions.php?id='.$r['id'].'&t=content&c=notes" data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i text-success">lightbulb</i></button>':'';
                      }?>
                      <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Content.md" data-type="content" data-tooltip="tooltip" aria-label="SEO Content Information"><i class="i">seo</i></button>
                      <button data-tooltip="tooltip" aria-label="Show Element Blocks" onclick="$(`.note-editable`).toggleClass(`note-show-block`);return false;"><i class="i">blocks</i></button>
                      <input class="col-1" id="ipsumc" value="5">
                      <button data-tooltip="tooltip" aria-label="Add Aussie Lorem Ipsum" onclick="ipsuMe(`editor`,$(`#ipsumc`).val());return false;"><i class="i">loremipsum</i></button>
                      <button data-fancybox data-type="ajax" data-src="core/layout/suggestions-add.php?id=<?=$r['id'];?>&t=content&c=notes" data-tooltip="tooltip" aria-label="Add Suggestions"><i class="i">idea</i></button>
                    </div>
                  </div>
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
                        <div class="note-editable"><?= rawurldecode($r['notes']);?></div>
                      </div>
                    </div>
                  </div>
                <?php }?>
              </div>
              <div class="form-text small text-muted">Edited: <?=($r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user']);?></div>
            </div>
<?php /* Pricing */?>
            <?php if($r['contentType']=='event'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='events'||$r['contentType']=='activities'){?>
              <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
                <div class="tabs3" role="tablist">
                  <?='<input class="tab-control" id="tab3-1" name="tabs3" type="radio" checked>'.
                  '<label for="tab3-1">Prices</label>'.
                  (in_array($r['contentType'],['activities','events','inventory','service'])?'<input class="tab-control" id="tab3-2" name="tabs3" type="radio"><label for="tab3-2">Expenses</label>':'');?>
<?php /* Prices */ ?>
                  <div class="tab3-1 border p-3 pt-0" data-tabid="tab3-1" role="tabpanel">
                    <div class="form-row">
                      <input id="<?=$r['contentType'];?>showCost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0" type="checkbox"<?=($r['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <label for="<?=$r['contentType'];?>showCost">Show Cost</label>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm">
                        <label for="cost">Cost</label>
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
                          <?=($user['options'][1]==1?
                            (in_array($r['contentType'],['activities','events','inventory','services'])?
                              '<button data-dbid="'.$r['id'].'" data-tooltip="tooltip" aria-label="Calculate Cost from Expense + Wholesale'.($config['gst']>0?' + GST':'').'" onclick="calcCost();"><i class="i">recalculate-expenses</i></button>'
                            :
                              '').
                            '<button class="save" id="savecost" data-dbid="cost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                          :
                            '');?>
                        </div>
                      </div>
                      <?php if(in_array($r['contentType'],['activities','events','inventory','service'])){?>
                        <div class="col-12 col-sm pl-sm-3">
                          <div class="form-row">
                            <label for="expense" data-tooltip="tooltip" aria-label="Expenses Total Cost">Expense</label>
                          </div>
                          <div class="form-row">
                            <div class="input-text">$</div>
                            <input class="textinput" id="expense" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="expense" type="text" value="<?=$r['expense'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Expenses Value..."':' readonly';?>>
                            <?=($user['options'][1]==1?
                              '<button class="expense" data-dbid="'.$r['id'].'" data-tooltip="tooltip" aria-label="Recalculate Expense" onclick="recalcExpense();"><i class="i">recalculate-expenses</i></button>'.
                              '<button class="save" id="saveexpense" data-dbid="expense" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                            :
                              '');?>
                          </div>
                        </div>
                      <?php }
                      if($r['contentType']!='activities'){?>
                        <div class="col-12 col-sm pl-sm-3">
                          <label for="rrp" data-tooltip="tooltip" aria-label="Recommended Retail Price">RRP</label>
                          <div class="form-row">
                            <div class="input-text">$</div>
                            <input class="textinput" id="rrp" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rrp" type="text" value="<?=$r['rrp'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Recommended Retail Cost..."':' readonly';?>>
                            <?=$user['options'][1]==1?'<button class="save" id="saverrp" data-dbid="rrp" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                      <?php }?>
                      <div class="col-12 col-sm pl-sm-3">
                        <label for="rCost">Reduced Cost</label>
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
                      <?php if(!in_array($r['contentType'],['activities','events'])){?>
                        <div class="col-12 col-sm pl-sm-3">
                          <label for="dCost">Wholesale Cost</label>
                          <div class="form-row">
                            <div class="input-text">$</div>
                            <input class="textinput" id="dCost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="dCost" type="text" value="<?=$r['dCost'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Wholesale Cost..."':' readonly';?>>
                            <?=$user['options'][1]==1?'<button class="save" id="savedCost" data-dbid="dCost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                      <?php }?>
                      <script>
                        function recalcExpense(){
                          var total=[].slice
                            .call(document.querySelectorAll('#expenses [data-total]'))
                            .map(el => Number(el.getAttribute('data-total')))
                            .reduce((a,b)=>{
                              return a + b;
                            });
                          $('#expense').val((Math.round(total * 100) / 100).toFixed(2));
                          update(`<?=$r['id'];?>`,`content`,`expense`,total);
                        }
                        function calcCost(){
                          <?php if(isset($config['gst'])&&is_numeric($config['gst'])){?>
                            var gst=<?php echo$config['gst'];?>;
                          <?php }else{?>
                            var gst=0;
                          <?php }?>
                          var expense=parseInt($('#expense').val());
                          if(expense==0){
                            toastr["error"](`Expense requires a value!`);
                          }else{
                            var wholesale=parseInt($('#dCost').val());
                            var total=expense + wholesale;
                            var totalgst=total + (total * (gst / 100));
                            $('#cost').val((Math.round(total * 100) / 100).toFixed(2));
                            $('#gstcost').text((Math.round(totalgst * 100) / 100).toFixed(2));
                            update(`<?=$r['id'];?>`,`content`,`cost`,total);
                          }
                        }
                      </script>
                    </div>
                    <?php if(in_array($r['contentType'],['activities','inventory'])){?>
                      <div class="row">
                        <div class="col-12 col-sm">
                          <label for="quantity">Quantity</label>
                          <div class="form-row">
                            <input class="textinput" id="quantity" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="quantity" type="text" value="<?=$r['quantity'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Quantity..."':' readonly';?>>
                            <?=$user['options'][1]==1?'<button class="save" id="savequantity" data-dbid="quantity" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                        <?php if($r['contentType']=='inventory'){?>
                          <div class="col-12 col-sm pl-sm-3">
                            <label for="cartonQuantity">Carton Quantity</label>
                            <div class="form-row">
                              <input class="textinput" id="cartonQuantity" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="cartonQuantity" type="text" value="<?=$r['cartonQuantity'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Carton Quantity..."':' readonly';?>>
                              <?=$user['options'][1]==1?'<button class="save" id="savecartonQuantity" data-dbid="cartonQuantity" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                            </div>
                          </div>
                        <?php }?>
                        <div class="col-12 col-sm pl-sm-3">
                          <label for="points">Points Value</label>
                          <div class="form-row">
                            <input class="textinput" id="points" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="points" type="text" value="<?=$r['points'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Points Value..."':' readonly';?>>
                            <?=$user['options'][1]==1?'<button class="save" id="savepoints" data-dbid="points" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                      </div>
                    <?php }
                    if($r['contentType']=='inventory'){?>
                      <label for="sale">Associate with Sale Period</label>
                      <div class="form-row">
                        <select id="sale"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Sale"':' disabled';?> onchange="update('<?=$r['id'];?>','content','sale',$(this).val(),'select');">
                          <option value=""<?=$r['sale']==''?' selected':''?>>No Holiday</option>
                          <?php $ssa=$db->prepare("SELECT DISTINCT(`code`) FROM `".$prefix."choices` WHERE `contentType`='sales' ORDER BY `code` ASC");
                          $ssa->execute();
                          while($rsa=$ssa->fetch(PDO::FETCH_ASSOC)){
                            echo'<option value="'.$rsa['code'].'"'.($r['sale']==$rsa['code']?' selected':'').'>'.$rsa['code'].'</option>';
                          }?>
                        </select>
                      </div>
                    <?php }
                    if($r['contentType']=='inventory'){?>
                      <div class="row">
                        <div class="col-12 col-sm">
                          <label for="stockStatus">Stock Status</label>
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
                          <label for="itemCondition">Condition</label>
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
                    <?php }
                    if($r['contentType']=='inventory'){?>
                      <div class="row">
                        <div class="col-12 col-sm">
                          <label for="weight">Weight</label>
                          <div class="form-row">
                            <input class="textinput" id="weight" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="weight" type="text" value="<?=$r['weight'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Weight..."':' readonly';?>>
                            <select id="weightunit" onchange="update('<?=$r['id'];?>','content','weightunit',$(this).val(),'select');"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Weight Unit"':' disabled';?>>
                              <option value="mg"<?=$r['weightunit']=='mg'?' selected':'';?>>mg (Milligrams)</option>
                              <option value="g"<?=$r['weightunit']=='g'?' selected':'';?>>g (Grams)</option>
                              <option value="kg"<?=$r['weightunit']=='kg'?' selected':'';?>>kg (Kilograms)</option>
                              <option value="lb"<?=$r['weightunit']=='lb'?' selected':'';?>>lb (Pound)</option>
                              <option value="t"<?=$r['weightunit']=='t'?' selected':'';?>>t (Tonne)</option>
                            </select>
                            <?=$user['options'][1]==1?'<button class="save" id="saveweight"  data-dbid="weight" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                        <div class="col-12 col-sm pl-sm-3">
                          <label for="width">Width</label>
                          <div class="form-row">
                            <input class="textinput" id="width" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="width" type="text" value="<?=$r['width'];?>"<?=$user['options'][1]==1?' placeholder="Width"':' readonly';?>>
                            <select id="widthunit"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Width Unit"':' disabled';?> onchange="update('<?=$r['id'];?>','content','widthunit',$(this).val(),'select');">
                              <option value="um"<?=$r['widthunit']=='um'?' selected':'';?>>um (Micrometre)</option>
                              <option value="mm"<?=$r['widthunit']=='mm'?' selected':'';?>>mm (Millimetre)</option>
                              <option value="cm"<?=$r['widthunit']=='cm'?' selected':'';?>>cm (Centimetre)</option>
                              <option value="in"<?=$r['widthunit']=='in'?' selected':'';?>>in (Inch)</option>
                              <option value="ft"<?=$r['widthunit']=='ft'?' selected':'';?>>ft (Foot)</option>
                              <option value="m"<?=$r['widthunit']=='m'?' selected':'';?>>m (Metre)</option>
                              <option value="km"<?=$r['widthunit']=='km'?' selected':'';?>>km (Kilometre)</option>
                              <option value="mi"<?=$r['widthunit']=='mi'?' selected':'';?>>mi (Mile)</option>
                              <option value="nm"<?=$r['widthunit']=='nm'?' selected':'';?>>nm (Nanomatre)</option>
                              <option value="yard"<?=$r['widthunit']=='yd'?' selected':'';?>>yd (Yard)</option>
                            </select>
                            <?=$user['options'][1]==1?'<button class="save" id="savewidth" data-dbid="width" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                        <div class="col-12 col-sm pl-sm-3">
                          <label for="height">Height</label>
                          <div class="form-row">
                            <input class="textinput" id="height" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="height"<?=$user['options'][1]==1?' placeholder="Height"':' readonly';?> type="text" value="<?=$r['height'];?>">
                            <select id="heightunit"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Height Unit"':' disabled';?> onchange="update('<?=$r['id'];?>','content','heightunit',$(this).val(),'select');">
                              <option value="um"<?=$r['heightunit']=='um'?' selected':'';?>>um (Micrometre)</option>
                              <option value="mm"<?=$r['heightunit']=='mm'?' selected':'';?>>mm (Millimetre)</option>
                              <option value="cm"<?=$r['heightunit']=='cm'?' selected':'';?>>cm (Centimetre)</option>
                              <option value="in"<?=$r['heightunit']=='in'?' selected':'';?>>in (Inch)</option>
                              <option value="ft"<?=$r['heightunit']=='ft'?' selected':'';?>>ft (Foot)</option>
                              <option value="m"<?=$r['heightunit']=='m'?' selected':'';?>>m (Metre)</option>
                              <option value="km"<?=$r['heightunit']=='km'?' selected':'';?>>km (Kilometre)</option>
                              <option value="mi"<?=$r['heightunit']=='mi'?' selected':'';?>>mi (Mile)</option>
                              <option value="nm"<?=$r['heightunit']=='nm'?' selected':'';?>>nm (Nanomatre)</option>
                              <option value="yard"<?=$r['heightunit']=='yd'?' selected':'';?>>yd (Yard)</option>
                            </select>
                            <?=$user['options'][1]==1?'<button class="save" id="saveheight" data-dbid="height" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                        <div class="col-12 col-sm pl-sm-3">
                          <label for="length">Length</label>
                          <div class="form-row">
                            <input class="textinput" id="length" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="length" type="text" value="<?=$r['length'];?>"<?=$user['options'][1]==1?' placeholder="Length"':' readonly';?>>
                            <select id="lengthunit"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Length Unit"':' disabled';?> onchange="update('<?=$r['id'];?>','content','lengthunit',$(this).val(),'select');">
                              <option value="um"<?=$r['lengthunit']=='um'?' selected':'';?>>um (Micrometre)</option>
                              <option value="mm"<?=$r['lengthunit']=='mm'?' selected':'';?>>mm (Millimetre)</option>
                              <option value="cm"<?=$r['lengthunit']=='cm'?' selected':'';?>>cm (Centimetre)</option>
                              <option value="in"<?=$r['lengthunit']=='in'?' selected':'';?>>in (Inch)</option>
                              <option value="ft"<?=$r['lengthunit']=='ft'?' selected':'';?>>ft (Foot)</option>
                              <option value="m"<?=$r['lengthunit']=='m'?' selected':'';?>>m (Metre)</option>
                              <option value="km"<?=$r['lengthunit']=='km'?' selected':'';?>>km (Kilometre)</option>
                              <option value="mi"<?=$r['lengthunit']=='mi'?' selected':'';?>>mi (Mile)</option>
                              <option value="nm"<?=$r['lengthunit']=='nm'?' selected':'';?>>nm (Nanomatre)</option>
                              <option value="yard"<?=$r['lengthunit']=='yd'?' selected':'';?>>yd (Yard)</option>
                            </select>
                            <?=$user['options'][1]==1?'<button class="save" id="savelength" data-dbid="length" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                          </div>
                        </div>
                      </div>
                    <?php }?>
              </div>
<?php /* Expenses */ ?>
                  <?php if(in_array($r['contentType'],['activities','events','inventory','service'])){?>
                    <div class="tab3-2 border" data-tabid="tab3-2" role="tabpanel">
                      <div class="row sticky-top">
                        <article class="card mb-0 p-0 overflow-visible card-list card-list-header shadow">
                          <div class="row m-0 p-0 py-2">
                            <div class="col-12 col-md-2 pl-2">Code</div>
                            <div class="col-12 col-md-2 pl-2">Brand</div>
                            <div class="col-12 col-md pl-2">Title</div>
                            <div class="col-12 col-md pl-2">Cost</div>
                            <div class="col-12 col-md-2 pl-2">Quantity</div>
                          </div>
                          <?php if($user['options'][1]==1){?>
                            <div class="row m-0 p-0">
                              <div class="col-12">
                                <select onchange="fillExpense($(this).val());">
                                  <option value="0">Select an Expense to AutoFill (Selecting this will clear values)...</option>
                                  <?php $se=$db->prepare("SELECT `id`,`code`,`category`,`title`,`cost`,`quantity` FROM `".$prefix."choices` WHERE `contentType`='expense' AND `code`!=:code GROUP BY (`code`) ORDER BY `type` ASC,`title` ASC");
                                  $se->execute([
                                    ':code'=>'wage-'.$user['id']
                                  ]);
                                  while($re=$se->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$re['code'].'|'.$re['category'].'|'.$re['title'].'|'.$re['cost'].'">Code:'.$re['type'].' | Brand:'.$re['category'].' | Title:'.$re['title'].' | Cost:'.$re['cost'].'</option>';
                                  $se=$db->prepare("SELECT `id`,`username`,`name`,`rate` FROM `".$prefix."login` WHERE `rate`!=0 ORDER BY `name` ASC, `username` ASC");
                                  $se->execute();
                                  while($re=$se->fetch(PDO::FETCH_ASSOC))echo'<option value="wage-'.$user['id'].'||Pay Rate for '.($re['name']!=''?$re['name']:$re['username']).'|'.$re['rate'].'">Code:wage-'.$user['id'].' Pay Rate for '.($re['name']!=''?$re['name']:$re['username']).' Rate: &dollar;'.$re['rate'].'</option>';?>
                                </select>
                              </div>
                            </div>
                            <script>
                              function fillExpense(id){
                                if(id==0){
                                  $('#ecode,#ebrand,#etitle,#ecost').val('');
                                }else{
                                  var expense=id.split("|");
                                  $('#ecode').val(expense[0]);
                                  $('#ebrand').val(expense[1]);
                                  $('#etitle').val(expense[2]);
                                  $('#ecost').val(expense[3]);
                                }
                              }
                            </script>
                            <form class="row m-0 p-0" target="sp" method="POST" action="core/add_expense.php">
                              <input name="rid" type="hidden" value="<?=$r['id'];?>">
                              <div class="col-12 col-md-2">
                                <input type="text" id="ecode" name="c" value="" placeholder="Enter a Code...">
                              </div>
                              <div class="col-12 col-md-2">
                                <input type="text" id="ebrand" name="b" value="" placeholder="Enter a Brand...">
                              </div>
                              <div class="col-12 col-md">
                                <input type="text" id="etitle" name="t" value="" placeholder="Enter a Title...">
                              </div>
                              <div class="col-12 col-md">
                                <input type="text" id="ecost" name="cost" value="" placeholder="Enter a Cost...">
                              </div>
                              <div class="col-12 col-md-2">
                                <div class="form-row">
                                  <input type="text" id="equantity" name="q" value="" placeholder="Enter a Quantity...">
                                  <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                                </div>
                              </div>
                            </form>
                          <?php }?>
                        </article>
                      </div>
                      <div id="expenses">
                        <?php $se=$db->prepare("SELECT `id`,`code`,`category`,`title`,`cost`,`quantity` FROM `".$prefix."choices` WHERE `contentType`='expense' AND `rid`=:rid ORDER BY `type` ASC, `title` ASC");
                        $se->execute([':rid'=>$r['id']]);
                        if($se->rowCount()>0){
                          while($re=$se->fetch(PDO::FETCH_ASSOC)){?>
                            <article id="l_<?=$re['id'];?>" class="card col-12 zebra mb-0 p-0 overflow-visible card-list item shadow" data-cost="<?=$re['cost'];?>" data-total="<?=((float)$re['cost'] * (float)$re['quantity']);?>">
                              <div class="row">
                                <div class="col-12 col-md-2">
                                  <div class="input-text"><?=$re['code'];?>&nbsp;</div>
                                </div>
                                <div class="col-12 col-md-2">
                                  <div class="input-text"><?=$re['category'];?>&nbsp;</div>
                                </div>
                                <div class="col-12 col-md">
                                  <div class="input-text"><?=$re['title'];?>&nbsp;</div>
                                </div>
                                <div class="col-12 col-md">
                                  <div class="input-text col-12">&dollar;<?=$re['cost'];?></div>
                                </div>
                                <div class="col-12 col-md-2">
                                  <div class="form-row">
                                    <div class="input-text col-12"><?=trim(trim($re['quantity'],0),'.');?></div>
                                    <form target="sp" action="core/purge.php">
                          						<input name="id" type="hidden" value="<?=$re['id'];?>">
                          						<input name="t" type="hidden" value="choices">
                          						<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                        						</form>
                                  </div>
                                </div>
                              </div>
                            </article>
                          <?php }
                        }?>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            <?php }?>
<?php /* Media */?>
            <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
              <div class="tabs2" role="tablist">
                <?='<input class="tab-control" id="tab2-1" name="tabs2" type="radio" checked>'.
                '<label for="tab2-1">Images</label>'.
                (!in_array($r['contentType'],['testimonials'])?'<input class="tab-control" id="tab2-2" name="tabs2" type="radio"><label for="tab2-2">Video</label>':'').
                (!in_array($r['contentType'],['activities','events','list','testimonials'])?
                  '<input class="tab-control" id="tab2-3" name="tabs2" type="radio"><label for="tab2-3">Downloadable Media</label>'.
                  '<input class="tab-control" id="tab2-4" name="tabs2" type="radio"><label for="tab2-4">Linked Services/Content</label>'
                :'');?>
                <div class="tab2-1 border p-3" data-tabid="tab2-1" role="tabpanel">
                  <div id="error"></div>
                  <?php if($r['contentType']!='list'){
                    if($r['contentType']=='testimonials'){?>
                      <div class="alert alert-info<?=$r['cid']==0?' hidden':'';?>" id="tstavinfo" role="alert">Currently using the Avatar associated with the selected Client Account.</div>
                      <?php if($user['options'][1]==1){?>
                        <form target="sp" method="post" action="core/add_data.php" enctype="multipart/form-data">
                          <label for="avatar" class="mt-0">Avatar</label>
                          <div class="form-row">
                            <img id="tstavatar" src="<?=$r['file']!=''&&file_exists('media/avatar/'.basename($r['file']))?'media/avatar/'.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar">
                            <input id="av" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="avatar" type="text" value="<?=$r['file'];?>" readonly>
                            <input name="id" type="hidden" value="<?=$r['id'];?>">
                            <input name="act" type="hidden" value="add_tstavatar">
                            <div class="custom-file" data-tooltip="tooltip" aria-label="Browse Computer for Image">
                              <input class="custom-file-input hidden" id="avatarfu" name="fu" type="file" onchange="form.submit();">
                              <label for="avatarfu" class="m-0"><i class="i">browse-computer</i></label>
                            </div>
                            <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate('<?=$r['id'];?>','content','file','');"><i class="i">trash</i></button>
                          </div>
                        </form>
                      <?php }else{?>
                        <label for="avatar" class="mt-0">Avatar</label>
                        <div class="form-row">
                          <img id="tstavatar" src="<?=$r['file']!=''&&file_exists('media/avatar/'.basename($r['file']))?'media/avatar/'.basename($r['file']):ADMINNOAVATAR;?>"  alt="Avatar">
                          <input id="av" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="avatar" type="text" value="<?=$r['file'];?>" readonly>
                        </div>
                      <?php }
                    }
                    if($r['contentType']!='testimonials'){?>
                      <label for="file" class="mt-0">Image</label>
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
                        echo($r['file']!=''?'<a data-fancybox="'.$r['contentType'].$r['id'].'" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img id="fileimage" src="'.$r['file'].'" alt="'.$r['contentType'].': '.$r['title'].'"></a>':'<img id="fileimage" src="'.ADMINNOIMAGE.'" alt="No Image">').
                        '<input class="textinput" id="file" type="text" value="'.$r['file'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="file"'.($user['options'][1]==1?' placeholder="Select an image from the button options..."':' disabled').'>'.
                        ($user['options'][1]==1?
                          '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`file`);"><i class="i">browse-media</i></button>'.
                          ($config['mediaOptions'][0]==1?'<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id='.$r['id'].'&t=content&c=file" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>':'').
                          ($config['mediaOptions'][2]==1?'<button class="openimageeditor" data-tooltip="tooltip" aria-label="Edit Image" data-imageeditor="editfile" data-image="'.$r['file'].'" data-name="'.$r['title'].'" data-alt="'.$r['fileALT'].'" data-w="'.$w.'" data-id="'.$r['id'].'" data-t="content" data-c="file"><i class="i">magic</i></button>':'').
                          '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`file`,``);"><i class="i">trash</i></button>'.
                          '<button class="save" id="savefile" data-dbid="file" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                        :
                          '');?>
                      </div>
                      <div id="editfile"></div>
                      <label for="thumb">Thumbnail</label>
                      <div class="form-row">
                        <?php $w='';
                        if(stristr($r['thumb'],'/thumbs/'))$w='thumbs';
                        if(stristr($r['thumb'],'/lg/'))$w='lg';
                        if(stristr($r['thumb'],'/md/'))$w='md';
                        if(stristr($r['thumb'],'/sm/'))$w='sm';
                        echo($r['thumb']!=''?'<a data-fancybox="thumb'.$r['id'].'" data-caption="Thumbnail: '.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['thumb'].'"><img id="thumbimage" src="'.$r['thumb'].'" alt="Thumbnail: '.$r['title'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">').
                        '<input class="textinput" id="thumb" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="thumb" type="text" value="'.$r['thumb'].'"'.($user['options'][1]==1?' placeholder="Select an image from the button options..."':' disabled').'>'.
                        ($user['options'][1]==1?
                          '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`thumb`);"><i class="i">browse-media</i></button>'.
                          ($config['mediaOptions'][0]==1?'<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id='.$r['id'].'&t=content&c=thumb" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>':'').
                          ($config['mediaOptions'][2]==1?'<button class="openimageeditor" data-tooltip="tooltip" aria-label="Edit Thumbnail Image" data-imageeditor="editthumb" data-image="'.$r['thumb'].'" data-name="'.$r['title'].'" data-alt="'.$r['fileALT'].'" data-w="'.$w.'" data-id="'.$r['id'].'" data-t="content" data-c="thumb"><i class="i">magic</i></button>':'').
                          '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`thumb`,``);"><i class="i">trash</i></button>'.
                          '<button class="save" id="savethumb" data-dbid="thumb" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
                        :
                          '');?>
                      </div>
                      <div id="editthumb"></div>
                      <label for="fileALT">Image ALT</label>
                      <?=($seo['imagesALT']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.$seo['imagesALT'].'</div>':'');?>
                      <div class="form-row<?=($seo['imagesALT']!=''?' border-danger border-2 border-top-0':'');?>">
                        <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Image-Alt-Text.md" data-type="alt" data-tooltip="tooltip" aria-label="SEO Image Alt Information"><i class="i">seo</i></button>
                        <div class="input-text" data-el="fileALT" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter an Image ALT Text..."><?=$r['fileALT'];?></div>
                        <input class="textinput d-none" id="fileALT" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="fileALT" type="text" value="<?=$r['fileALT'];?>">
                        <?=($user['options'][1]==1?'<button class="save" id="savefileALT" data-tooltip="tooltip" aria-label="Save" data-dbid="fileALT" data-style="zoom-in"><i class="i">save</i></button>':'');?>
                      </div>
                      <legend class="mt-3">Image Attribution</legend>
                      <label for="attributionImageTitle">Title</label>
                      <div class="form-row">
                        <input class="textinput" id="attributionImageTitle" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" type="text" value="<?=$r['attributionImageTitle'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Title..."':' readonly';?>>
                        <?=($user['options'][1]==1?'<button class="save" id="saveattributionImageTitle" data-dbid="attributionImageTitle" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="attributionImageName">Name</label>
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
                        echo($user['options'][1]==1?'<button class="save" id="saveattributionImageName" data-dbid="attributionImageName" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="attributionImageURL">URL</label>
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
                        echo($user['options'][1]==1?'<button class="save" id="saveattributionImageURL" data-dbid="attributionImageURL" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <legend class="mt-3">EXIF Information</legend>
                      <label for="exifFilename">Original Filename</label>
                      <?=($user['options'][1]==1?'<div class="form-text">Using the "Magic Wand" button will attempt to get the EXIF Information embedded in the Uploaded Image.</div>':'');?>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifFilename`);"><i class="i">magic</i></button>':'').
                        '<input class="textinput" id="exifFilename" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifFilename" type="text" value="'.$r['exifFilename'].'"'.($user['options'][1]==1?' placeholder="Original Filename..."':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifFilename" data-dbid="exifFilename" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="exifCamera">Camera</label>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifCamera`);"><i class="i">magic</i></button>':'').
                        '<input class="textinput" id="exifCamera" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifCamera" type="text" value="'.$r['exifCamera'].'"'.($user['options'][1]==1?' placeholder="Enter a Camera"':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifCamera" data-dbid="exifCamera" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="exifLens">Lens</label>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifLens`);"><i class="i">magic</i></button>':'').
                        '<input type="text" id="exifLens" class="textinput" value="'.$r['exifLens'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifLens"'.($user['options'][1]==1?' placeholder="Enter a Lens..."':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifLens" data-dbid="exifLens" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="exifAperture">Aperture</label>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifAperture`);"><i class="i">magic</i></button>':'').
                        '<input class="textinput" id="exifAperture" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifAperture" type="text" value="'.$r['exifAperture'].'"'.($user['options'][1]==1?' placeholder="Enter an Aperture..."':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifAperture" data-dbid="exifAperture" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="exifFocalLength">Focal Length</label>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifFocalLength`);"><i class="i">magic</i></button>':'').
                        '<input class="textinput" id="exifFocalLength" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifFocalLength" type="text" value="'.$r['exifFocalLength'].'"'.($user['options'][1]==1?' placeholder="Enter a Focal Length..."':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifFocalLength" data-dbid="exifFocalLength" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="exifShutterSpeed">Shutter Speed</label>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifShutterSpeed`);"><i class="i">magic</i></button>':'').
                        '<input class="textinput" id="exifShutterSpeed" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifShutterSpeed" type="text" value="'.$r['exifShutterSpeed'].'"'.($user['options'][1]==1?' placeholder="Enter a Shutter Speed..."':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifShutterSpeed" data-dbid="exifShutterSpeed" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="exifISO">ISO</label>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifISO`);"><i class="i">magic</i></button>':'').
                        '<input class="textinput" id="exifISO" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifISO" type="text" value="'.$r['exifISO'].'"'.($user['options'][1]==1?' placeholder="Enter an ISO..."':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifISO" data-dbid="exifISO" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                      <label for="exifti">Taken</label>
                      <div class="form-row">
                        <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Get EXIF Information" onclick="getExif(`'.$r['id'].'`,`content`,`exifti`);"><i class="i">magic</i></button>':'').
                        '<input class="textinput" id="exifti" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="exifti" type="text" value="'.($r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'').'"'.($user['options'][1]==1?' placeholder="Select the Date/Time Image was Taken... (fix)"':' readonly').'>'.
                        ($user['options'][1]==1?'<button class="save" id="saveexifti" data-dbid="exifti" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                      </div>
                    <?php }
                  }?>
                  <legend class="mt-3">On Page Media</legend>
                  <form class="form-row" target="sp" method="post" action="core/add_media.php" enctype="multipart/form-data">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="rid" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="content">
                    <input id="mediafile" name="fu" type="text" value="" placeholder="Enter a URL, or Select Images using the Media Manager...">
                    <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','media','mediafile');return false;"><i class="i">browse-media</i></button>
                    <button class="add" data-tooltip="tooltip" aria-label="Add" type="submit"><i class="i">add</i></button>
                  </form>
                  <div class="row mt-3" id="mi">
                    <?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `file`!='' AND `pid`=:id ORDER BY `ord` ASC");
                    $sm->execute([':id'=>$r['id']]);
                    if($sm->rowCount()>0){
                      while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
                        <div id="mi_<?=$rm['id'];?>" class="card stats gallery col-12 col-sm-3 m-0 border-0">
                          <?php if(stristr($rm['file'],'youtu')){
                            preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$rm['file'],$vidMatch);
                            echo'<div class="note-video-wrapper video" style="padding-bottom:67%;" data-fancybox="media" href="'.$rm['file'].'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'"><img class="note-video-clip" src="'.$rm['thumb'].'"><div class="play"></div></div>';
                          }elseif(stristr($rm['file'],'vimeo')){
                            preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$rm['file'],$vidMatch);
                            echo'<div class="note-video-wrapper video" style="padding-bottom:67%;" data-fancybox="media" href="'.$rm['file'].'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'"><img class="note-video-clip" src="'.$rm['thumb'].'"><div class="play"></div></div>';
                          }else
                            echo'<a data-fancybox="media" href="'.$rm['file'].'"><img   src="'.$rm['thumb'].'" alt="'.$rm['title'].'"></a>';?>
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
                <?php if(!in_array($r['contentType'],['testimonials','list'])){?>
                  <div class="tab2-2 border p-3" data-tabid="tab2-2" role="tabpanel">
                    <label for="videoURL" class="mt-0">Video URL</label>
                    <div class="form-row">
                      <input class="textinput" id="videoURL" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="videoURL" type="text" value="<?=$r['videoURL'];?>">
                      <?=($user['options'][1]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`videoURL`);"><i class="i">browse-media</i></button><button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`'.$r['id'].'`,`content`,`videoURL`,``);"><i class="i">trash</i></button><button class="save" id="savevideoURL" data-dbid="videoURL" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                    </div>
                    <div class="form-row mt-3">
                      <input id="options4" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="4" type="checkbox"<?=($r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <label for="options4">AutoPlay Video</label>
                    </div>
                    <div class="form-row">
                      <input id="options5" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="5" type="checkbox"<?=($r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <label for="options5">Loop Video</label>
                    </div>
                    <div class="form-row">
                      <input id="options6" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="6" type="checkbox"<?=($r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <label for="options6">Show Controls</label>
                    </div>
                  </div>
                <?php }
                if(!in_array($r['contentType'],['activities','events','list','testimonials'])){?>
                  <div class="tab2-3 border" data-tabid="tab2-3" role="tabpanel">
                    <?php if($user['options'][1]==1){
                      if($r['contentType']!='list'){?>
                        <div class="sticky-top">
                          <form class="row" target="sp" method="post" action="core/add_download.php" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?=$r['id'];?>">
                            <div class="form-row">
                              <div class="input-text">Title</div>
                              <input type="text" name="t" value="" placeholder="Enter a Title, leave empty to use filename...">
                            </div>
                            <?php if($r['contentType']=='inventory'){?>
                              <div class="form-row">
                                <div class="input-text border-top-0 border-right-0 border-bottom-0">Requires Order</div>
                                <div class="input-text2 pt-2 border-0"><input type="checkbox" name="r" value="1"></div>
                                <div class="input-text border-0">and is available for download for</div>
                                <select class="border-top-0 border-bottom-0 border-left-0" id="downloada" name="a">
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
                        </div>
                        <div id="downloads">
                          <?php $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='download' AND `rid`=:id");
                          $sd->execute([':id'=>$r['id']]);
                          if($sd->rowCount()>0){
                            while($rd=$sd->fetch(PDO::FETCH_ASSOC)){?>
                              <div class="row" id="l_<?=$rd['id'];?>">
                                <div class="form-row">
                                  <div class="input-text">Title</div>
                                  <input type="text" name="t" value="<?=$rd['title'];?>" placeholder="Uses Filename in place of title..." readonly>
                                </div>
                                <?php if($r['contentType']=='inventory'){?>
                                  <div class="form-row">
                                    <div class="input-text border-top-0 border-right-0 border-bottom-0">Requires Order</div>
                                    <div class="input-text2 pt-2 border-0"><input type="checkbox" name="r"<?=$rd['password']==1?' checked':''?> disabled></div>
                                    <div class="input-text border-0">and is available for download for</div>
                                    <select class="borde-top-0 border-bottom-0 border-left-0" id="downloada" name="a" onchange="update('<?=$rd['id'];?>','choices','tie',$(this).val(),'select');">
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
                      <?php }
                    }?>
                  </div>
                <?php }
                if(!in_array($r['contentType'],['activities','events','list','testimonials'])){?>
                  <div class="tab2-4 border" data-tabid="tab2-4" role="tabpanel">
                    <div class="sticky-top">
                      <form class="row" target="sp" method="post" action="core/add_link.php">
                        <input name="id" type="hidden" value="<?=$r['id'];?>">
                        <div class="form-row">
                          <div class="input-text">Title</div>
                          <input type="text" name="t" value="" placeholder="Enter a Title...">
                        </div>
                        <?php if($r['contentType']=='inventory'){?>
                          <div class="form-row">
                            <div class="input-text border-top-0 border-right-0 border-bottom-0">Requires Order</div>
                            <div class="input-text2 pt-2 border-0"><input type="checkbox" name="r" value="1"></div>
                            <div class="input-text border-0">and is available for</div>
                            <select class="border-top-0 border-bottom-0 border-left-0" id="linka" name="a">
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
                    </div>
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
                                  <label>and is available for download for:</label>
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
                  </div>
                <?php }?>
              </div>
            </div>
<?php /* Options */ ?>
            <div class="tab1-4 border p-3" data-tabid="tab1-4" role="tabpanel">
              <?php if($user['options'][1]==1){?>
                <form target="sp" method="post" action="core/add_option.php">
                  <input name="rid" type="hidden" value="<?=$r['id'];?>">
                  <?php $so=$db->prepare("SELECT `id`,`title`,`code` FROM `".$prefix."content` WHERE `contentType`='inventory' AND `id`!=:id ORDER BY `code` ASC, `title` ASC");
                  $so->execute([':id'=>$r['id']]);
                  if($so->rowCount()>0){?>
                    <div class="row">
                      <div class="col-12 col-sm-4">
                        <label for="ooid" class="m-2">Link to Inventory Item</label>
                      </div>
                      <div class="col-12 col-sm">
                        <select id="ooid" name="oid" onchange="selectInvOption($(this).val(),$('#ooid'+$(this).val()).attr('data-title'));">
                          <option id="ooid0" value="0" data-title="">Select or Clear an Inventory Item to Link to this Option</option>
                          <?php while($ro=$so->fetch(PDO::FETCH_ASSOC)){
                            echo'<option id="ooid'.$ro['id'].'" value="'.$ro['id'].'" data-title="'.$ro['title'].'">'.($ro['code']!=''?$ro['code'].':':'').$ro['title'].'</option>';
                          }?>
                        </select>
                      </div>
                    </div>
                  <?php }?>
                  <div class="row">
                    <div class="col-12 col-sm-2">
                      <label for="otitle"class="m-2">Title</label>
                    </div>
                    <div class="col-12 col-sm-10">
                      <input id="otitle" name="ttl" type="text" value="" placeholder="Enter a Title...">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-2">
                      <label for="ocategory"class="m-2">Category</label>
                    </div>
                    <div class="col-12 col-sm-10">
                      <input id="ocategory" name="cat" type="text" value="" placeholder="Category for Options Grouping...">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-2">
                      <label for="oqty" class="m-2">Quantity</label>
                    </div>
                    <div class="col-12 col-sm-10">
                      <input id="oqty" name="qty" type="text" value="" placeholder="Set to 0 or leave empty to use Linked Product Quantity...">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-2">
                      <label for="ocost" class="m-2">Cost</label>
                    </div>
                    <div class="col-12 col-sm-10">
                      <input id="ocost" name="cost" type="text" value="" placeholder="Set to 0 or leave empty to use Linked Product Cost...">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-2">
                      <label for="oimage" class="m-2">Image/Video</label>
                    </div>
                    <div class="col-12 col-sm-10">
                      <div class="form-row">
                        <input id="oimage" name="oi" type="text" value="" placeholder="Leave empty to use Linked Product image...">
                        <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`oimage`);return false;"><i class="i">browse-media</i></button>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-2">
                      <label for="ostatus" class="m-2">Status</label>
                    </div>
                    <div class="col-12 col-sm-10">
                      <select id="ostatus" name="status">
                        <option value="unavailable">Unavailable</option>
                        <option value="available">Available</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-2">
                      <label for="oda" class="m-2">Notes</label>
                    </div>
                    <div class="col-12 col-sm-10">
                      <textarea id="oda" name="da" placeholder="Leave empty to use Linked Product Text..."></textarea>
                    </div>
                  </div>
                  <div class="text-right">
                    <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </form>
                <script>
                  function selectInvOption(id,da){
                    if(id==0){
                      $('#otitle,#oqty,#ocost,#oimage,#oda').val('');
                    }else{
                      $('#otitle').val(da);
                    }
                  }
                  </script>
                <?php }?>
                <div id="options" class="row m-1">
                  <?php $so=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `rid`=:rid ORDER BY `ord` ASC");
                  $so->execute([':rid'=>$r['id']]);
                  if($so->rowCount()>0){
                    while($ro=$so->fetch(PDO::FETCH_ASSOC)){
                      if($ro['oid']!=0){
                        $soo=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
                        $soo->execute([':id'=>$ro['oid']]);
                        $roo=$soo->fetch(PDO::FETCH_ASSOC);
                      }?>
                      <div id="l_<?=$ro['id'];?>" class="card col-12 mx-0 my-1 m-sm-1 overflow-visible">
                        <div class="row">
                          <?=($ro['file']!=''?
                            '<div class="col-12 col-sm-3 list-images-1 overflow-hidden"><a data-fancybox href="'.$ro['file'].'"><img src="'.$ro['file'].'"></a></div>'
                          :
                            (isset($roo['file'])&&$roo['file']!=''?
                              '<div class="col-12 col-sm-3 list-images-1 overflow-hidden"><a data-fancybox href="'.$roo['file'].'"><img src="'.($roo['thumb']!=''?$roo['thumb']:$roo['file']).'"></a></div>'
                            :
                              '')
                          );?>
                          <div class="card-footer col-12 col-sm m-0 p-1">
                            <div class="row m-0 p-0">
                              <div class="col-12 small m-0 p-0">
                                <div class="col-12">
                                  <select class="status <?=$ro['status'];?>" onchange="update('<?=$ro['id'];?>','choices','status',$(this).val(),'select');$(this).removeClass().addClass('status '+$(this).val());changeShareStatus($(this).val());"<?=$user['options'][1]==1?'':' disabled';?>>
                                    <option class="unavailable" value="unavailable"<?=$ro['status']=='unavailable'?' selected':'';?>>Unavailable</option>
                                    <option class="available" value="available"<?=$ro['status']=='available'?' selected':'';?>>Available</option>
                                  </select>
                                </div>
                                <?=($ro['category']!=''?'<div class="h6 col-12">Category: '.$ro['category'].'</div>':'');?>
                                <div class="h6 col-12">Title: <?=$ro['title'];?></div>
                                <?=($ro['quantity']>0?
                                  '<div class="col-12">Quantity: '.$ro['quantity'].'</div>'
                                :
                                  (isset($roo['quantity'])&&$roo['quantity']>0?
                                    '<div class="col-12">Quantity: '.$roo['quantity'].' (Linked)</div>'
                                  :
                                    '')
                                );?>
                                <div class="row">
                                  <?=($ro['cost']>0?
                                    '<div class="col-12">$'.$ro['cost'].'</div>'
                                  :
                                    (isset($roo['rrp'])&&$roo['rrp']>0?
                                      '<div class="col-12 col-sm-6">RRP $'.$roo['rrp'].' (Linked)</div>'
                                    :
                                      '').
                                    (isset($roo['cost'])&&$roo['cost']>0?
                                      '<div class="col-12 col-sm-6">Cost $'.$roo['cost'].' (Linked)</div>'
                                    :
                                      '').
                                    (isset($roo['rCost'])&&$roo['rCost']>0?
                                      '<div class="col-12 col-sm-6">Reduced $'.$roo['rCost'].' (Linked)</div>'
                                    :
                                      '').
                                    (isset($roo['dCost'])&&$roo['dCost']>0?
                                      '<div class="col-12 col-sm-6">Wholesale $'.$roo['dCost'].' (Linked)</div>'
                                    :
                                      '')
                                  );?>
                                </div>
                                <?=($ro['notes']!=''?
                                  '<div id="listmore'.$ro['id'].'" class="'.(strlen($ro['notes'])>100?'list-more ':'').'col-12">'.$ro['notes'].'</div>'.
                                  (strlen($ro['notes'])>100?
                                    '<div class="col-12"><button class="btn-block p-0 mb-3" onclick="$(`#listmore'.$ro['id'].'`).toggleClass(`list-more`);$(`.list-arrow-'.$ro['id'].'`).toggleClass(`d-none`);"><i class="i list-arrow-'.$ro['id'].'">down</i><i class="i list-arrow-'.$ro['id'].' d-none">up</i></button></div>'
                                  :
                                    '')
                                :
                                  (isset($roo['notes'])&&$roo['notes']!=''?
                                    '<div id="listmore'.$ro['id'].'" class="'.(strlen($roo['notes'])>100?'list-more '
                                  :
                                    '').
                                  'col-12">'.$roo['notes'].'</div>'.
                                  (strlen($roo['notes'])>100?
                                    '<div class="col-12"><button class="btn-block p-0 mb-3" onclick="$(`#listmore'.$ro['id'].'`).toggleClass(`list-more`);$(`.list-arrow-'.$ro['id'].'`).toggleClass(`d-none`);"><i class="i list-arrow-'.$ro['id'].'">down</i><i class="i list-arrow-'.$ro['id'].' d-none">up</i></button></div>'
                                  :
                                    '')
                                  :
                                    '')
                                );?>
                              </div>
                              <?php if($user['options'][0]==1){?>
                                <div class="col-12 text-right">
                                  <button class="btn-sm trash" id="purge<?=$ro['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$ro['id'];?>','choices')"><i class="i">trash</i></button>
                                  <span class="btn btn-sm orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>
                                </div>
                              <?php }?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php }?>
                    <div class="ghost hidden">&nbsp;</div>
                    <script>
                      $('#options').sortable({
                        items:".card",
                        handle:'.orderhandle',
                        placeholder:".ghost",
                        helper:fixWidthHelper,
                        axis:"y",
                        update:function(e,ui){
                          var order=$("#options").sortable("serialize");
                          $.ajax({
                            type:"POST",
                            dataType:"json",
                            url:"core/reorderoptions.php",
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
<?php /* Comments */ ?>
            <div class="tab1-5 border" data-tabid="tab1-5" role="tabpanel">
              <div class="form-row p-3">
                <input id="options1" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1" type="checkbox"<?=($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="options1">Enable</label>
              </div>
              <div class="row sticky-top">
                <article class="card mb-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                  <div class="row">
                    <div class="col-12 col-md-2 pl-2">Author</div>
                    <div class="col-12 col-md-4">Comment</div>
                    <div class="col-12 col-md-2">Submitted On</div>
                    <div class="col-12 col-md"></div>
                  </div>
                </article>
              </div>
              <div id="comments">
                <?php $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`=:contentType AND `rid`=:rid ORDER BY `ti` ASC");
                $sc->execute([
                  ':contentType'=>$r['contentType'],
                  ':rid'=>$r['id']
                ]);
                while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                  <div class="row" id="l_<?=$rc['id'];?>">
                    <article class="card zebra mb-0 p-0 py-2 overflow-visible card-list shadow<?=$rc['status']=='unapproved'?' bg-danger':'';?>">
                      <div class="row">
                        <div class="col-12 col-md-2 pl-2 align-top small">
                          <?php $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                          $su->execute([':id'=>$rc['uid']]);
                          if($su->rowCount()==1){
                            $ru=$su->fetch(PDO::FETCH_ASSOC);
                            echo$ru['username'].($ru['name']!=''?':'.$ru['name']:'').'<br><small><small>'.rank($ru['rank']).'</small></small>';
                          }else echo isset($ru['email'])&&$ru['email']!=''?'<a href="mailto:'.$ru['email'].'">'.$ru['email'].'</a>':'Nonexistent User';?>
                        </div>
                        <div class="col-12 col-md-4 small"><?= strip_tags($rc['notes']);?></div>
                        <div class="col-12 col-md-2 text-center small"><?= date($config['dateFormat'],$rc['ti']);?></div>
                        <div class="col-12 col-md pr-2 text-right">
                          <?php if($user['options'][1]==1){?>
                            <div class="btn-group" id="controls-<?=$rc['id'];?>" role="group">
                              <?php if(isset($ru['rank'])&&$ru['rank']<700){
                                $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                                $scc->execute([':ip'=>$rc['ip']]);
                                if($scc->rowCount()<1){?>
                                  <form class="d-inline-block" id="blacklist<?=$rc['id'];?>" target="sp" method="post" action="core/add_commentblacklist.php">
                                    <input name="id" type="hidden" value="<?=$rc['id'];?>">
                                    <button data-tooltip="tooltip" aria-label="Add IP to Blacklist"><i class="i">security</i></button>
                                  </form>
                                <?php }
                              }?>
                              <button class="add<?=$rc['status']!='unapproved'?' hidden':'';?>" id="approve_<?=$rc['id'];?>" onclick="update('<?=$rc['id'];?>','comments','status','approved');" data-tooltip="tooltip" aria-label="Approve"><i class="i">approve</i></button>
                              <button class="trash" onclick="purge('<?=$rc['id'];?>','comments');" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                            </div>
                          <?php }?>
                        </div>
                      </div>
                    </article>
                  </div>
                <?php }?>
              </div>
              <?php if($user['options'][1]==1){?>
                <div class="row p-3">
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
                      <button class="btn-block add" data-tooltip="tooltip" aria-label="Add Comment">Add Comment</button>
                    </div>
                  </form>
                </div>
              <?php }?>
            </div>
<?php /* Reviews */ ?>
            <div class="tab1-6 border" data-tabid="tab1-6" role="tabpanel">
              <div class="row sticky-top">
                <article class="card mb-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                  <div class="row">
                    <div class="col-12 col-md-2 pl-2">Author</div>
                    <div class="col-12 col-md-4">Review</div>
                    <div class="col-12 col-md-2">Rating</div>
                    <div class="col-12 col-md-2 text-center">Submitted On</div>
                    <div class="col-12 col-md-2"></div>
                  </div>
                </article>
              </div>
              <?php $sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid ORDER BY `ti` DESC");
              $sr->execute([':rid'=>$r['id']]);
              if($sr->rowCount()>0){
                while($rr=$sr->fetch(PDO::FETCH_ASSOC)){?>
                  <div class="row">
                    <article class="card zebra mt-2 mb-0 p-0 overflow-visible card-list shadow <?=$rr['status']=='unapproved'?' danger':'';?>" id="l_<?=$rr['id'];?>">
                      <div class="row">
                        <div class="col-12 col-md-2 align-middle p-2 small">
                          <?=($rr['name']==''?'Anonymous':$rr['name']);?>
                        </div>
                        <div class="col-12 col-md-4 pt-2 small">
                          <?= strip_tags($rr['notes']);?>
                        </div>
                        <div class="col-12 col-md-2 pt-2">
                          <span class="rating small">
                            <span<?=$rr['cid']>=1?' class="set"':'';?>></span>
                            <span<?=$rr['cid']>=2?' class="set"':'';?>></span>
                            <span<?=$rr['cid']>=3?' class="set"':'';?>></span>
                            <span<?=$rr['cid']>=4?' class="set"':'';?>></span>
                            <span<?=$rr['cid']==5?' class="set"':'';?>></span>
                          </span>
                        </div>
                        <div class="col-12 col-md-2 pt-2 small text-center"><?= date($config['dateFormat'],$rr['ti']);?></div>
                        <div class="col-12 col-md py-2 pr-2 text-right">
                          <?php if($user['options'][1]==1){?>
                            <div class="btn-group" id="controls-<?=$rr['id'];?>" role="group">
                              <button class="add<?=$rr['status']=='approved'?' hidden':'';?>" id="approve_<?=$rr['id'];?>" onclick="update('<?=$rr['id'];?>','comments','status','approved');" data-tooltip="tooltip" aria-label="Approve"><i class="i">approve</i></button>
                              <button class="trash" onclick="purge('<?=$rr['id'];?>','comments');" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                            </div>
                          <?php }?>
                        </div>
                      </div>
                    </article>
                  </div>
                <?php }
              }?>
            </div>
<?php /* Related */ ?>
            <?php if($r['contentType']=='article'||$r['contentType']=='inventory'||$r['contentType']=='service'){?>
              <div class="tab1-7 border" data-tabid="tab1-7" role="tabpanel">
                <div class="sticky-top">
                  <div class="row">
                    <article class="card mb-0 p-0 overflow-visible card-list card-list-header bg-white shadow">
                      <div class="row">
                        <div class="col-12 col-md">
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
                        </div>
                      </div>
                    </article>
                  </div>
                </div>
                <div id="relateditems">
                  <?php $sr=$db->prepare("SELECT `id`,`rid` FROM `".$prefix."choices` WHERE `uid`=:id AND `contentType`='related' ORDER BY `ti` ASC");
                  $sr->execute([':id'=>$r['id']]);
                  while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
                    $si=$db->prepare("SELECT `contentType`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                    $si->execute([':id'=>$rr['rid']]);
                    $ri=$si->fetch(PDO::FETCH_ASSOC);?>
                    <div class="row" id="l_<?=$rr['id'];?>">
                      <div class="col-12">
                        <div class="form-row">
                          <div class="input-text col-12"><?= ucfirst($ri['contentType']).': '.$ri['title'];?></div>
                          <?php if($user['options'][1]==1){?>
                            <form target="sp" action="core/purge.php">
                              <input name="id" type="hidden" value="<?=$rr['id'];?>">
                              <input name="t" type="hidden" value="choices">
                              <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                            </form>
                          <?php }?>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            <?php }
/* SEO */
            if($r['contentType']!='testimonials'&&$r['contentType']!='proofs'){?>
              <div class="tab1-8 border p-3" data-tabid="tab1-8" role="tabpanel">
                <label for="metaRobots" class="mt-0">Meta&nbsp;Robots</label>
                <?php if($user['options'][1]==1){?>
                  <div class="form-text">Options for Meta Robots: <span data-tooltip="left" data-tooltip="tooltip" aria-label="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="left" data-tooltip="tooltip" aria-label="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
                  <?php }?>
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
                <label for="schemaType">Schema Type</label>
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
                  <div id="google-title" data-tooltip="tooltip" aria-label="This is the underlined clickable link in search results and comes from the text that is displayed in the Tab in the Browser. If the Meta Title is empty below the information is then tried to be used from the Pages Meta Title, if that is empty then an auto-generated text will be used from the text in the Title, the content type, and Business Name, otherwise this text is made up from Meta Title, content type, and business name."><?=($r['seoTitle']!=''?$r['seoTitle']:$r['title']);?></div>
                  <div id="google-link"><?= URL.$r['contentType'].'/'.$r['urlSlug'];?></div>
                  <div id="google-description" data-tooltip="tooltip" aria-label="This is what shows up in the search results under your clickable link. This is quite important, and is the first piece of text your customers will read about your brand. If the Meta Description below is empty, the page Meta Description will be used, if that is empty a truncated version of your content text with the HTML tags removed will be used. If that is empty then the text is taken from the default text set in preferences."><?=($r['seoDescription']!=''?$r['seoDescription']:$config['seoDescription']);?></div>
                </div>
                <label for="seoTitle">Meta Title</label>
                <div class="form-text">The recommended character count for Titles is a minimum of 20 and maximum of 70.</div>
                <?=$seo['seoTitle']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['seoTitle'],'<strong>').'</div>':'';?>
                <div class="form-row<?=$seo['seoTitle']!=''?' border-danger border-2 border-top-0':'';?>">
                  <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Title.md" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
                  <div id="seoTitlecnt" class="input-text<?= strlen($r['seoTitle'])<20||strlen($r['seoTitle'])>70?' bg-danger text-white':'';?>"><?= strlen($r['seoTitle']);?></div>
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
                <label for="seoDescription">Meta Description</label>
                <div class="form-text">The recommended character count for Descriptions is a minimum of 70 and a maximum of 160.</div>
                <?=$seo['seoDescription']!=''?'<div class="alert alert-warning m-0 border-danger border-2 border-bottom-0">'.strip_tags($seo['seoDescription'],'<strong>').'</div>':'';?>
                <div class="form-row<?=$seo['seoDescription']!=''?' border-danger border-2 border-top-0':'';?>">
                  <button data-fancybox data-type="ajax" data-src="https://raw.githubusercontent.com/wiki/DiemenDesign/AuroraCMS/SEO-Meta-Description.md" data-tooltip="tooltip" aria-label="SEO Meta Description Information"><i class="i">seo</i></button>
                  <div id="seoDescriptioncnt" class="input-text<?= strlen($r['seoDescription'])<50||strlen($r['seoDescription'])>160?' bg-danger text-white':'';?>"><?= strlen($r['seoDescription']);?></div>
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
              </div>
            <?php }
/* Settings */ ?>
            <div class="tab1-9 border p-3" data-tabid="tab1-9" role="tabpanel">
              <div class="row">
                <div class="col-12 col-sm-6 pr-md-3">
                  <label for="status" class="mt-0">Status</label>
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
                  <label for="rank" class="mt-0">Access</label>
                  <div class="form-row">
                    <select id="rank" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rank"<?=$user['options'][1]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','content','rank',$(this).val(),'select');toggleRank($(this).val());">
                      <option value="0"<?=$r['rank']==0?' selected':'';?>>Available to Everyone</option>
                      <option value="100"<?=$r['rank']==100?' selected':'';?>>Subscriber and above</option>
                      <option value="200"<?=$r['rank']==200?' selected':'';?>>Member and above</option>
                      <option value="210"<?=$r['rank']==210?' selected':'';?>>Member Bronze and above</option>
                      <option value="220"<?=$r['rank']==220?' selected':'';?>>Member Silver and above</option>
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
                  <label for="contentType">contentType</label>
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
                  <label for="mid">SubMenu</label>
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
              <div class="form-row mt-3">
                <input id="pin" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="pin" data-dbb="0" type="checkbox"<?=($r['pin']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="pin">Pinned</label>
              </div>
              <?php if($r['contentType']=='inventory'||$r['contentType']=='service'){?>
                <div class="form-row">
                  <input id="price" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="price" data-dbb="0" type="checkbox"<?=($r['price']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="price">Appear on Pricing Page</label>
                </div>
              <?php }
              if($r['contentType']=='inventory'){?>
                <div class="form-row">
                  <input id="coming" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="coming" data-dbb="0" type="checkbox"<?=($r['coming']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="coming">Coming Soon</label>
                </div>
              <?php }
              if($r['contentType']!='proofs'){?>
                <div class="form-row<?=$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs'?' hidden':'';?>">
                  <input id="<?=$r['contentType'];?>Featured" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0" type="checkbox"<?=($r['featured']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="<?=$r['contentType'];?>Featured">Featured</label>
                </div>
              <?php }?>
              <div class="form-row">
                <input id="<?=$r['contentType'];?>Internal" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0" type="checkbox"<?=($r['internal']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label for="<?=$r['contentType'];?>Internal">Internal</label>
              </div>
              <?php if($r['contentType']=='service'||$r['contentType']=='events'||$r['contentType']=='activities'){?>
                <div class="form-row">
                  <input id="<?=$r['contentType'];?>Bookable" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0" type="checkbox"<?=($r['bookable']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                  <label for="<?=$r['contentType'];?>Bookable">Bookable</label>
                </div>
              <?php }
              if($r['contentType']=='events'){?>
                <div class="col-12">
                  <div class="form-row">
                    <input id="enableMap" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="7" type="checkbox"<?=($r['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                    <label for="enableMap">Enable Map Display</label>
                  </div>
                </div>
                <?php if($config['mapapikey']==''){?>
                  <div class="alert alert-info mt-3">
                    There is currently no Map API Key entered on the <a href="<?= URL.$settings['system']['admin'].'/preferences/contact';?>">Preferences -> Contact</a> page, to allow Maps to be displayed on pages.<br>
                    Maps are displayed with the help of the Leaflet addon for it's ease of use.<br>
                    To obtain an API Key to access Mapping, please register at <a href="https://account.mapbox.com/access-tokens/">Map Box</a>.
                  </div>
                <?php }else{?>
                  <div class="form-text">Drag the map marker to update your Location.</div>
                  <div class="col-12 mt-3">
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
              <div class="tab1-10 border p-3" data-tabid="tab1-10" role="tabpanel">
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
                      echo'<div class="input-text col-12 col-sm">Booking Status:&nbsp;<span class="badger badge-'.$rbb['status'].'">'.ucwords($rbb['status']).'</span></div><a class="btn" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$rbb['id'].'" data-tooltip="tooltip" aria-label="Go to Booking"><i class="i">calendar</i></a></div>';
                    }
                  }?>
                </div>
              </div>
            <?php }
/* Templates */
            if($r['contentType']!='testimonials'){?>
              <div class="tab1-11 border p-3" data-tabid="tab1-11" role="tabpanel">
                <section class="content overflow-visible theme-chooser" id="templates">
                  <article class="card m-1 m-sm-2 card-list theme<?=$r['templatelist']==0?' theme-selected':'';?>" id="l_0" data-template="0">
                    <figure class="card-image">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 180" fill="none"></svg>
                      <div class="image-toolbar overflow-visible"><i class="i icon enable text-white i-4x pt-2 pr-1">approve</i></div>
                    </figure>
                    <div class="card-header line-clamp">Theme Generated</div>
                    <div class="card-body no-clamp">
                      <p class="small"><small>This selection uses the item template in the theme file.</small></p>
                    </div>
                  </article>
                  <?php $st=$db->prepare("SELECT * FROM `".$prefix."templates` WHERE `contentType`='all' ORDER BY `contentType` ASC, `section` ASC");
                  $st->execute();
                  while($rt=$st->fetch(PDO::FETCH_ASSOC)){?>
                    <article class="card m-1 m-sm-2 card-list theme<?=$rt['id']==$r['templatelist']?' theme-selected':'';?>" id="l_<?=$rt['id'];?>" data-template="<?=$rt['id'];?>">
                      <figure class="card-image">
                        <?=$rt['image'];?>
                        <div class="image-toolbar overflow-visible"><i class="i icon enable text-white i-4x pt-2 pr-1">approve</i></div>
                      </figure>
                      <div class="card-header line-clamp"><?=$rt['title'];?></div>
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
/* Purchases */
            if($r['contentType']=='inventory'){?>
              <div class="tab1-12 border" data-tabid="tab1-12" role="tabpanel">
                <div class="row sticky-top">
                  <article class="card mb-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                    <div class="row">
                      <div class="col-12 col-md text-center">Order Number</div>
                      <div class="col-12 col-md text-center">Date</div>
                      <div class="col-12 col-md text-center">Status</div>
                      <div class="col-12 col-md"></div>
                    </div>
                  </article>
                </div>
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
                      <article class="card zebra m-0 mb-0 p-2 border-0 overflow-visible shadow" id="l_<?=$ro['id'];?>">
                        <div class="row">
                          <div class="col-md pt-2 text-center">
                            <a href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$ro['id']?>"><?=($ro['aid']!=''?$ro['aid'].'<br>':'').$ro['qid'].$ro['iid'];?></a>
                          </div>
                          <div class="col-md pt-2 text-center">
                            Date:&nbsp;<?=' '.date($config['dateFormat'],($ro['iid_ti']==0?$ro['qid_ti']:$ro['iid_ti']));?><br>
                            <small>Due:&nbsp;<?=$ro['due_ti']>0?date($config['dateFormat'],$ro['due_ti']):'';?></small>
                          </div>
                          <div class="col-md pt-2 text-center">
                            <span class="badger badge-<?=$ro['status'];?> badge-2x"><?= ucfirst($ro['status']);?></span>
                          </div>
                          <div class="col-md">
                            <div id="controls_<?=$ro['id'];?>" class="justify-content-end">
                              <div class="btn-group float-right" role="group">
                                <button class="print" data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/email_order.php?id=<?=$ro['id'];?>&act=print');"><i class="i">print</i></button>
                                <?=(isset($ru['email'])&&$ru['email']!=''?'<button class="email" data-tooltip="tooltip" aria-label="Email Order" onclick="$(\'#sp\').load(\'core/email_order.php?id='.$ro['id'].'&act=\');"><i class="i">email-send</i></button>':'');?>
                                <a class="<?=$user['options'][0]==1?' rounded-right':'';echo$ro['status']=='delete'?' d-none':'';?>" href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$ro['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                                <?=($user['options'][0]==1?'<button class="add'.($ro['status']!='delete'?' d-none':'').'" id="untrash'.$ro['id'].'" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons(`'.$ro['id'].'`,`orders`,`status`,``);"><i class="i">untrash</i></button><button class="trash'.($ro['status']=='delete'?' d-none':'').'" id="delete'.$ro['id'].'" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons(`'.$ro['id'].'`,`orders`,`status`,`delete`);"><i class="i">trash</i></button><button class="purge'.($ro['status']!='delete'?' d-none':'').'" id="purge'.$ro['id'].'" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$ro['id'].'`,`orders`)"><i class="i">purge</i></button><button class="quickeditbtn" data-qeid="'.$ro['id'].'" data-qet="orders" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><i class="i">down</i><i class="i d-none">up</i></button>':'');?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </article>
                      <div class="quickedit" id="quickedit<?=$ro['id'];?>"></div>
                    <?php }
                  }?>
                </section>
              </div>
            <?php }
/* FAQ */
            if(in_array($r['contentType'],['events','inventory','service','course','article'])){?>
              <div class="tab1-15 border" data-tabid="tab1-15" role="tabpanel">
                <div class="row">
                  <article class="card mb-0 p-0 overflow-visible card-list card-list-header shadow">
                    <div class="row py-2">
                      <div class="col-12 col-md pl-2">Question</div>
                      <div class="col-12 col-md-1 text-center">Open</div>
                    </div>
                    <?php if($user['options'][1]==1){?>
                      <form target="sp" method="post" action="core/add_contentfaq.php">
                        <input name="rid" type="hidden" value="<?=$r['id'];?>">
                        <input name="c" type="hidden" value="<?=$r['contentType'];?>">
                        <div class="row">
                          <div class="col-12 col-md">
                            <input id="title" name="t" type="text" value="" placeholder="Enter FAQ Title/Question...">
                          </div>
                          <div class="col-12 col-md-1 py-2 text-center">
                            <input id="open" name="open" type="checkbox" value="1" checked>
                          </div>
                        </div>
                        <div class="row py-2">
                          <div class="col-12 col-md pl-2">Answer</div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-md">
                            <textarea class="summernote2" id="da" name="da"></textarea>
                          </div>
                          <div class="col-12 col-md-1 text-right align-bottom">
                            <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                          </div>
                        </div>
                      </form>
                      <script>
                        $('.summernote2').summernote({
                          placeholder:'Enter Answer...',
                          toolbar:[
                            ['insert',['link']],
                          ],
                          linkList:[
                            <?php $sl=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `mid`=0 AND `menu`!='none' AND `active`=1 ORDER BY FIELD(`menu`,'head','footer','account','other'), `ord` ASC");
                            $sl->execute();
                            while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
                              echo'['.
                                '"'.$rl['title'].'",'.
                                '"'.URL.$rl['contentType'].'/'.$rl['url'].'",'.
                                '"'.ucwords($rl['contentType']).' - '.$rl['title'].'",'.
                              '],';
                            }
                            $sl=$db->query("SELECT `id`,`title`,`urlSlug`,`contentType` FROM `".$prefix."content` WHERE `contentType`!='testimonials' AND `contentType`!='faq' AND `contentType`!='booking' AND `status`='published' ORDER BY `contentType` ASC");
                            $sl->execute();
                            while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
                              echo'['.
                                '"'.$rl['title'].'",'.
                                '"'.URL.$rl['contentType'].'/'.$rl['urlSlug'].'/",'.
                                '"'.ucwords($rl['contentType']).' - '.$rl['title'].'",'.
                              '],';
                            }?>
                          ],
                          callbacks:{
                            onInit:function(){
                              $('body > .note-popover').appendTo(".note-editing-area");
                            }
                          }
                        });
                      </script>
                    <?php }?>
                  </article>
                </div>
                <div id="faqs">
                  <?php $sf=$db->prepare("SELECT `id`,`title`,`notes`,`value` FROM `".$prefix."choices` WHERE `rid`=:rid AND `contentType`='faq' AND `type`=:cT ORDER BY `ord` ASC, `ti` ASC");
                  $sf->execute([
                    ':rid'=>$r['id'],
                    ':cT'=>$r['contentType']
                  ]);
                  while($rf=$sf->fetch(PDO::FETCH_ASSOC)){?>
                    <div class="card mt-1" id="l_<?=$rf['id'];?>">
                      <div class="row p-2">
                        <details open>
                          <summary>
                            <?=$rf['title'];?>
                            <div class="col-3 float-right text-right">
                              <input id="faqvalue0<?=$rf['id'];?>" data-dbid="<?=$rf['id'];?>" data-dbt="choices" data-dbc="value" data-dbb="0" type="checkbox"<?=($rf['value']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                              <label for="faqvalue0<?=$rf['id'];?>">Display as Open</label>
                              <?=($user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$rf['id'].'`,`choices`);"><i class="i">trash</i></button><span class="btn orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>':'');?>
                            </div>
                          </summary>
                          <div class="ml-4">
                            <?=strip_tags($rf['notes']);?>
                          </div>
                        </details>
                      </div>
                    </div>
                  <?php }?>
                </div>
                <script>
                  $('#faqs').sortable({
                    items:".card",
                    handle:'.orderhandle',
                    placeholder:".ghost",
                    helper:fixWidthHelper,
                    axis:"y",
                    update:function(e,ui){
                      var order=$("#faqs").sortable("serialize");
                      $.ajax({
                        type:"POST",
                        dataType:"json",
                        url:"core/reorderfaq.php",
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
              </div>
            <?php }
/* List */
            if($r['contentType']=='article'){?>
              <div class="tab1-13 border" data-tabid="tab1-13" role="tabpanel">
                <?php if($user['options'][1]==1){?>
                  <form target="sp" method="post" enctype="multipart/form-data" action="core/add_list.php">
                    <input name="rid" type="hidden" value="<?=$r['id'];?>">
                    <div class="row">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label for="lh" class="m-2">Heading</label>
                          </div>
                          <div class="col-8">
                            <input id="lh" name="lh" type="text" value="" placeholder="Heading...">
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label for="lu" class="m-2">URL</label>
                          </div>
                          <div class="col-8">
                            <input id="lu" name="lu" type="text" value="" placeholder="URL...">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label for="limage" class="m-2">Image/Video</label>
                          </div>
                          <div class="col-8">
                            <div class="form-row">
                              <input id="limage" name="li" type="text" value="" placeholder="Image/Video...">
                              <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage`);return false;"><i class="i">browse-media</i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label for="limage2" class="m-2">Image/Video 2</label>
                          </div>
                          <div class="col-8">
                            <div class="form-row">
                              <input id="limage2" name="li2" type="text" value="" placeholder="Image/Video 2...">
                              <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage2`);return false;"><i class="i">browse-media</i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label for="limage3" class="m-2">Image/Video 3</label>
                          </div>
                          <div class="col-8">
                            <div class="form-row">
                              <input id="limage3" name="li3" type="text" value="" placeholder="Image/Video 3...">
                              <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage3`);return false;"><i class="i">browse-media</i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label for="limage4" class="m-2">Image/Video 4</label>
                          </div>
                          <div class="col-8">
                            <div class="form-row">
                              <input id="limage4" name="li4" type="text" value="" placeholder="Image/Video 4...">
                              <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`<?=$r['id'];?>`,`content`,`limage4`);return false;"><i class="i">browse-media</i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <label for="lda" class="m-2">Notes</label>
                      </div>
                      <div class="col-10">
                        <textarea id="lda" name="lda" style="height:200px;"></textarea>
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
                    <div id="l_<?=$rl['id'];?>" class="card col-12 mx-0 my-1 m-sm-1 overflow-visible add-item">
                      <div class="row">
                        <?php $slm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE `rid`=:id ORDER BY `ord` ASC, `ti` ASC LIMIT 4");
                        $slm->execute([':id'=>$rl['id']]);
                        $slmc=$slm->rowCount();
                        if($slmc>0){
                          echo'<div class="col-12 col-sm-3 list-images-'.$slmc.' overflow-hidden">';
                          while($rlm=$slm->fetch(PDO::FETCH_ASSOC)){
                            if(stristr($rlm['file'],'youtu')){
                              preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$rlm['file'],$vidMatch);
                              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$rlm['file'].'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'"><img class="note-video-clip" src="media/sm/'.basename($rlm['thumb']).'"><div class="play"></div></div>';
                            }elseif(stristr($rlm['file'],'vimeo')){
                              preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$rlm['file'],$vidMatch);
                              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$rlm['file'].'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'"><img class="note-video-clip" src="https://vumbnail.com/'.$vidMatch[5].'.jpg"><div class="play"></div></div>';
                            }elseif(stristr($rl['urlSlug'],'twitter')){
                              echo'<a target="_blank" href="'.$rl['urlSlug'].'"><img src="media/sm/'.basename($rlm['thumb']).'" alt="'.$rl['title'].'"></a>';
                            }else
                              echo'<a data-fancybox="list" href="'.$rlm['file'].'"><img src="media/sm/'.basename($rlm['thumb']).'" alt="'.$rl['title'].'"></a>';
                          }
                          echo'</div>';
                        }?>
                        <div class="card-footer col-12 col-sm m-0 p-1">
                          <div class="row m-0 p-0">
                            <div class="col-12 small m-0 p-0">
                              <?=($rl['title']!=''?'<div class="h6 col-12">'.$rl['title'].'</div>':'').$rl['notes'].($rl['urlSlug']!=''?' <a target="_blank" href="'.$rl['urlSlug'].'">More...</a>':'');?>
                            </div>
                            <?php if($user['options'][0]==1){?>
                              <div class="col-12 text-right">
                                <a class="btn" href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$rl['id'];?>" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                                <button class="btn trash" id="purge<?=$rl['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$rl['id'];?>','content')"><i class="i">trash</i></button>
                                <span class="btn orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>
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
              <?php }
              $smurl=$r['urlSlug'];
/* Analytics */ ?>
            <div class="tab1-14 border p-3" data-tabid="tab1-14" role="tabpanel">
<?php         if($config['options'][11]==1){
                $week1start=strtotime("last sunday midnight this week");
                $week1end=strtotime("saturday this week");
                $sv=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='content' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                $sv->execute([
                  ':rid'=>$r['id'],
                  ':ti1'=>$week1start,
                  ':ti2'=>$week1end
                ]);
                $rv=$sv->fetch(PDO::FETCH_ASSOC);
                $previous_week = strtotime("-1 week +1 day",$ti);
                $week2start = strtotime("last sunday midnight",$previous_week);
                $week2end = strtotime("next saturday",$week2start);
                $sv2=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='content' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                $sv2->execute([
                  ':rid'=>$r['id'],
                  ':ti1'=>$week2start,
                  ':ti2'=>$week2end
                ]);
                $rv2=$sv2->fetch(PDO::FETCH_ASSOC);?>
                <div class="row mt-3 justify-content-center">
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Direct</span>
                    <span class="px-0 py-1">
                      <span class="text-3x" id="social-direct"><?=short_number($rv['direct']);?></span>
                      <?=($rv2['direct']>0?($rv['direct']<$rv2['direct']?'<small class="text-danger">&darr;'.short_number($rv2['direct'] - $rv['direct']).'</small>':'').($rv2['direct']<$rv['direct']?'<small class="text-success">&uarr;'.short_number($rv['direct'] - $rv2['direct']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-5x">browser-general</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Google</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-google"><?=short_number($rv['google']);?></span>
                      <?=($rv2['google']>0?($rv['google']<$rv2['google']?'<small class="text-danger">&darr;'.short_number($rv2['google'] - $rv['google']).'</small>':'').($rv2['google']<$rv['google']?'<small class="text-success">&uarr;'.short_number($rv['google'] - $rv2['google']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-google i-5x">social-google</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">DuckDuckGo</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-duckduckgo"><?=short_number($rv['duckduckgo']);?></span>
                      <?=($rv2['duckduckgo']>0?($rv['duckduckgo']<$rv2['duckduckgo']?'<small class="text-danger">&darr;'.short_number($rv2['duckduckgo'] - $rv['duckduckgo']).'</small>':'').($rv2['duckduckgo']<$rv['duckduckgo']?'<small class="text-success">&uarr;'.short_number($rv['duckduckgo'] - $rv2['duckduckgo']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-duckduckgo i-5x">social-duckduckgo</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Bing</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-bing"><?=short_number($rv['bing']);?></span>
                      <?=($rv2['bing']>0?($rv['bing']<$rv2['bing']?'<small class="text-danger">&darr;'.short_number($rv2['bing'] - $rv['bing']).'</small>':'').($rv2['bing']<$rv['bing']?'<small class="text-success">&uarr;'.short_number($rv['bing'] - $rv2['bing']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-bing i-5x">social-bing</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Reddit</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-reddit"><?=short_number($rv['reddit']);?></span>
                      <?=($rv2['reddit']>0?($rv['reddit']<$rv2['reddit']?'<small class="text-danger">&darr;'.short_number($rv2['reddit'] - $rv['reddit']).'</small>':'').($rv2['reddit']<$rv['reddit']?'<small class="text-success">&uarr;'.short_number($rv['reddit'] - $rv2['reddit']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-reddit i-5x">social-reddit</i></span>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Facebook</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-facebook"><?=short_number($rv['facebook']);?></span>
                      <?=($rv2['facebook']>0?($rv['facebook']<$rv2['facebook']?'<small class="text-danger">&darr;'.short_number($rv2['facebook'] - $rv['facebook']).'</small>':'').($rv2['facebook']<$rv['facebook']?'<small class="text-success">&uarr;'.short_number($rv['facebook'] - $rv2['facebook']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-facebook i-5x">social-facebook</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Threads</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-threads"><?=short_number($rv['threads']);?></span>
                      <?=($rv2['threads']>0?($rv['threads']<$rv2['threads']?'<small class="text-danger">&darr;'.short_number($rv2['threads'] - $rv['threads']).'</small>':'').($rv2['threads']<$rv['threads']?'<small class="text-success">&uarr;'.short_number($rv['threads'] - $rv2['threads']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-threads i-5x">social-threads</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Instagram</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-instagram"><?=short_number($rv['instagram']);?></span>
                      <?=($rv2['instagram']>0?($rv['instagram']<$rv2['instagram']?'<small class="text-danger">&darr;'.short_number($rv2['instagram'] - $rv['instagram']).'</small>':'').($rv2['instagram']<$rv['instagram']?'<small class="text-success">&uarr;'.short_number($rv['instagram'] - $rv2['instagram']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-instagram i-5x">social-instagram</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Twitter</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-twitter"><?=short_number($rv['twitter']);?></span>
                      <?=($rv2['twitter']>0?($rv['twitter']<$rv2['twitter']?'<small class="text-danger">&darr;'.short_number($rv2['twitter'] - $rv['twitter']).'</small>':'').($rv2['twitter']<$rv['twitter']?'<small class="text-success">&uarr;'.short_number($rv['twitter'] - $rv2['twitter']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-twitter i-5x">social-twitter</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Linkedin</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="social-linkedin"><?=short_number($rv['linkedin']);?></span>
                      <?=($rv2['linkedin']>0?($rv['linkedin']<$rv2['linkedin']?'<small class="text-danger">&darr;'.short_number($rv2['linkedin'] - $rv['linkedin']).'</small>':'').($rv2['linkedin']<$rv['linkedin']?'<small class="text-success">&uarr;'.short_number($rv['linkedin'] - $rv2['linkedin']).'</small>':''):'');?>
                    </span>
                    <span class="icon"><i class="i i-social social-linkedin i-5x">social-linkedin</i></span>
                  </div>
                </div>
              <?php }?>
              <div class="row mt-3 justify-content-center">
                <?php if($r['contentType']=='inventory'){?>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Earnings</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="analytics-earnings">0</span>
                    </span>
                    <span class="icon"><i class="i i-5x">money</i></span>
                  </div>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Net Profit</span>
                    <span class="px-0 py-2">
                      <span class="text-3x" id="analytics-profit">0</span>
                    </span>
                    <span class="icon"><i class="i i-5x">money</i></span>
                  </div>
                  <?php $ss=$db->prepare("SELECT SUM(`quantity`) AS `cnt` FROM `".$prefix."orderitems` WHERE `iid`=:iid");
                  $ss->execute([
                    ':iid'=>$r['id']
                  ]);
                  $rs=$ss->fetch(PDO::FETCH_ASSOC);?>
                  <div class="card stats col-11 col-sm p-1 m-1 text-center">
                    <span class="h6 text-muted">Total Sales</span>
                    <span class="px-0 py-2">
                      <span class="text-3x"><?=number_format($rs['cnt']);?></span>
                    </span>
                    <span class="icon"><i class="i i-5x">shipping</i></span>
                  </div>
                <?php }?>
              </div>
              <?php if($r['contentType']=='inventory'){?>
                <div class="row mt-4">
                  <div class="col-12 col-sm-6 pr-sm-2">
                    <?php include'core/layout/widget-inventoryitemstats.php';?>
                  </div>
                  <div class="col-12 col-sm-6 mt-4 mt-sm-0 pl-sm-2">
                    <?php include'core/layout/widget-inventoryitemprofit.php';?>
                  </div>
                </div>
              <?php }?>
              <div class="row mt-4">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require'core/layout/footer.php';?>
  </section>
</main>
