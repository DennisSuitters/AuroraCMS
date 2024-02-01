<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Adverts - Edit
 * @package    core/layout/edit_adverts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='62'");
$sv->execute();
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/adverts';?>">Adverts</a></li>
                <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                <li class="breadcrumb-item active"><?=$r['title'];?></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'');?>
                <button class="<?=$r['status']=='published'?'':'hidden';?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" data-tooltip="left" aria-label="Share on Social Media"><i class="i">share</i></button>
                <?=($user['options'][0]==1?'<a class="btn add" href="'.URL.$settings['system']['admin'].'/add/advert" role="button" data-tooltip="left" aria-label="Add '.ucfirst($r['contentType']).'"><i class="i">add</i></a>':'').
                ($user['options'][1]==1?'<button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <?='<input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>'.
          '<label for="tab1-1">General</label>'.
          '<input class="tab-control" id="tab1-2" name="tabs" type="radio">'.
          '<label for="tab1-2">Media</label>'.
          '<input class="tab-control" id="tab1-3" name="tabs" type="radio">'.
          '<label for="tab1-3">Settings</label>';?>
<?php /* General */?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <label for="title" class="mt-0">Title</label>
            <div class="form-row">
              <input class="textinput" id="title" type="text" value="<?=$r['title'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="trash" placeholder="Enter a Title...."<?=$user['options'][1]==1?'':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="url">URL</label>
            <div class="form-row">
              <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="url" type="text" value="<?=$r['url'];?>"<?=$user['options'][1]==1?' placeholder="Enter a URL..."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="saveurl" data-dbid="url" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <div class="row">
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="ti">Created</label>
                <div class="form-row">
                  <input id="ti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['ti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`ti`,getTimestamp(`ti`),`select`);"':' readonly';?>>
                </div>
              </div>
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="tis">Display Start Date <span class="labeldate" id="labeldatetis"><?= $r['tis']>0?date($config['dateFormat'],$r['tis']):'';?></span></label>
                <div class="form-row">
                  <input id="tis" type="datetime-local" value="<?=$r['tis']!=0?date('Y-m-d\TH:i',$r['tis']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tis`,getTimestamp(`tis`));"':' readonly';?>>
                </div>
              </div>
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="tie">Display End Date <span class="labeldate" id="labeldatetie"><?= $r['tie']>0?date($config['dateFormat'],$r['tie']):'';?></span></label>
                <div class="form-row">
                  <input id="tie" type="datetime-local" value="<?=$r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'';?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`content`,`tie`,getTimestamp(`tie`));"':' readonly';?>>
                </div>
              </div>
            </div>
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
            <div class="row">
              <div class="col-12 col-sm-3">
                <label for="cost">Cost per Month</label>
                <div class="form-row">
                  <div class="input-text">$</div>
                  <input class="textinput" id="cost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="cost" type="text" value="<?=$r['cost'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Cost..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savecost" data-dbid="cost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-sm-3 pl-sm-2">
                <label for="views">Impressions</label>
                <div class="form-row">
                  <input class="textinput" id="views" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="views" type="number" value="<?=$r['views'];?>"<?=$user['options'][1]==1?'':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views`).val(`0`);update(`'.$r['id'].'`,`content`,`views`,`0`);"><i class="i">eraser</i></button>'.
                  '<button class="save" id="saveviews" data-dbid="views" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-sm-3 pl-sm-2">
                <label for="quantity">Max Impressions</label>
                <div class="form-row">
                  <input class="textinput" id="quantity" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="quantity" type="text" value="<?=$r['quantity'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Quantity..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savequantity" data-dbid="quantity" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-sm-3 pl-sm-2">
                <label for="quantity">Clicks</label>
                <div class="form-row">
                  <input class="textinput" id="lti" data-dbid="<?= $r['id'];?>" data-dbt="content" data-dbc="lti" type="text" value="<?=$r['lti'];?>"<?=$user['options'][1]==1?' placeholder="Clicks..."':' readonly';?>>
                  <?=$user['options'][1]==1?'<button class="save" id="savelti" data-dbid="lti" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
          </div>
<?php /* Media */ ?>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <label for="file" class="mt-0">Image</label>
            <div class="form-row">
              <?php $w='';
              if(stristr($r['file'],'/thumbs/'))$w='thumbs';
              if(stristr($r['file'],'/lg/'))$w='lg';
              if(stristr($r['file'],'/md/'))$w='md';
              if(stristr($r['file'],'/sm/'))$w='sm';
              echo($r['file']!=''?
                '<a data-fancybox="'.$r['contentType'].$r['id'].'" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img id="fileimage" src="'.$r['file'].'" alt="'.$r['contentType'].': '.$r['title'].'"></a>'
              :
                '<img id="fileimage" src="'.ADMINNOIMAGE.'" alt="No Image">'
              );?>
              <input class="textinput" id="file" type="text" value="<?=$r['file'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="file"<?=($user['options'][1]==1?'':' readonly');?>>
              <?=($user['options'][1]==1?
                '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`'.$r['id'].'`,`content`,`file`);"><i class="i">browse-media</i></button>'.
                ($config['mediaOptions'][0]==1?'<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id='.$r['id'].'&t=content&c=file" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>':'').
                ($config['mediaOptions'][2]==1?'<button class="openimageeditor" data-tooltip="tooltip" aria-label="Edit Image" data-imageeditor="editfile" data-image="'.$r['file'].'" data-name="'.$r['title'].'" data-alt="'.$r['fileALT'].'" data-w="'.$w.'" data-id="'.$r['id'].'" data-t="content" data-c="file"><i class="i">magic</i></button>':'').
                '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`content`,`file`,``);"><i class="i">trash</i></button><button class="save" id="savefile" data-dbid="file" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>'
              :
                '');?>
            </div>
            <div id="editfile"></div>
            <div class="row">
              <div class="col-12 col-sm">
                <div class="row">
                  <div class="col-12 col-sm pr-sm-3">
                    <label for="length">Orientation</label>
                    <div class="form-row">
                      <select id="length" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="length" onchange="update('<?=$r['id'];?>','content','length',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
                        <option value="h"<?=$r['subject']=='h'?' selected':'';?>>Horizontal</option>
                        <option value="v"<?=$r['subject']=='v'?' selected':'';?>>Vertical</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-sm pr-sm-3">
                    <label for="width">Width</label>
                    <div class="form-row">
                      <input class="textinput" id="width" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="width" type="text" value="<?=$r['width'];?>"<?=$user['options'][1]==1?' placeholder="Width"':' readonly';?>>
                      <?=$user['options'][1]==1?'<button class="save" id="savewidth" data-dbid="width" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm">
                    <label for="height">Height</label>
                    <div class="form-row">
                      <input class="textinput" id="height" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="height"<?=$user['options'][1]==1?' placeholder="Height"':' readonly';?> type="text" value="<?=$r['height'];?>">
                      <?=$user['options'][1]==1?'<button class="save" id="saveheight" data-dbid="height" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<?php /* Settings */ ?>
          <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-3">
                <label for="status" class="mt-0">Status</label>
                <div class="form-row">
                  <select id="status"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Status"':' disabled';?> onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');">
                    <option value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                    <option value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-sm-6 pl-md-3">
                <label for="rank" class="mt-0">Access</label>
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
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
