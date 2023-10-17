<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts - Edit
 * @package    core/layout/edit_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([':id'=>$args[1]]);
$r=$q->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
                <li class="breadcrumb-item active">Edit</li>
                <li class="breadcrumb-item active"><span id="usersusername"><?=$r['username'];?></span>:<span id="usersname"><?=$r['name'];?></span></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][5]==1?'<button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Contact</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Media</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Proofs</label>
          <input class="tab-control" id="tab1-5" name="tabs" type="radio">
          <label for="tab1-5">Social</label>
          <input class="tab-control" id="tab1-6" name="tabs" type="radio">
          <label for="tab1-6">Messages</label>
          <?=($user['options'][4]==1?'<input class="tab-control" id="tab1-7" name="tabs" type="radio"><label for="tab1-7">Orders</label>':'');?>
          <input class="tab-control" id="tab1-8" name="tabs" type="radio">
          <label for="tab1-8">Settings</label>
          <?=($config['hoster']==1?'<input class="tab-control" id="tab1-9" name="tabs" type="radio"><label for="tab1-9">Hosting/Website Payments</label>':'');?>
<?php /* Tab 1 General */?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <?=($user['rank']==1000?'<div class="row"><div id="accountIP" class="col-12"><div class="form-text text-muted"><small>IP: '.$r['userIP'].' | '.$r['userAgent'].'</small></div></div></div>':'');?>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="ti">Created</label>
                <div class="form-row">
                  <input id="ti" type="text" value="<?= date($config['dateFormat'],$r['ti']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="lti">Last Login</label>
                <div class="form-row">
                  <input id="lti" type="text" value="<?= _ago($r['lti']);?>" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="username">Username</label>
                <div class="form-row">
                  <input class="textinput" id="username" type="text" value="<?=$r['username'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="saveusername" data-dbid="username" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <div class="alert alert-danger d-none" id="uerror" role="alert">Username already exists!</div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="email">Email</label>
                <div class="form-row">
                  <input class="textinput" id="email" type="text" value="<?=$r['email'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="saveemail" data-dbid="email" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
            <hr>
            <legend role="heading">Orders Information</legend>
            <?php $purchaseLimit=$config['memberLimit'];
            if($r['purchaseLimit']==0||$r['purchaseLimit']==''){
              if($r['rank']==200)$purchaseLimit=$config['memberLimit'];
              if($r['rank']==210)$purchaseLimit=$config['memberLimitSilver'];
              if($r['rank']==220)$purchaseLimit=$config['memberLimitBronze'];
              if($r['rank']==230)$purchaseLimit=$config['memberLimitGold'];
              if($r['rank']==240)$purchaseLimit=$config['memberLimitPlatinum'];
              if($r['rank']==310)$purchaseLimit=$config['memberLimitSilver'];
              if($r['rank']==320)$purchaseLimit=$config['memberLimitBronze'];
              if($r['rank']==330)$purchaseLimit=$config['memberLimitGold'];
              if($r['rank']==340)$purchaseLimit=$config['memberLimitPlatinum'];
            }else
              $purchaseLimit=$r['purchaseLimit'];
            if($purchaseLimit==0||$purchaseLimit=='')
              $purchaseLimit='Unlimited';?>
            <div class="row">
              <div class="col-12 col-sm-6 pr-md-3">
                <label for="purchaseLimit">Purchase Limit Override</label>
                <div class="form-row">
                  <input class="textinput" id="purchaseLimit" type="number" value="<?=$r['purchaseLimit'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="purchaseLimit"<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savepurchaseLimit" data-dbid="purchaseLimit" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
                <div class="form-text">(Set to "0" or no value to use default for this account level, currently allowed to purchase <?=$purchaseLimit;?> items.)</div>
              </div>
              <div class="col-12 col-sm-6">
                <label for="purchaseTime">Wholesale Purchase Time</label>
                <select id="purchaseTime" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="purchaseTime"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','purchaseTime',$(this).val(),'select');">
                  <option value="0"<?=$r['purchaseTime']==0?' selected':'';?>>Use System Default</option>
                  <option value="2629743"<?=$r['purchaseTime']==2629743?' selected':'';?>>1 Month</option>
                  <option value="5259486"<?=$r['purchaseTime']==5259486?' selected':'';?>>2 Months</option>
                  <option value="7889229"<?=$r['purchaseTime']==7889229?' selected':'';?>>3 Months</option>
                  <option value="15778458"<?=$r['purchaseTime']==15778458?' selected':'';?>>6 Months</option>
                  <option value="31556926"<?=$r['purchaseTime']==31556926?' selected':'';?>>1 Year</option>
                  <option value="63113852"<?=$r['purchaseTime']==63113852?' selected':'';?>>2 Years</option>
                  <option value="94670778"<?=$r['purchaseTime']==94670778?' selected':'';?>>3 Years</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="pti">Last Purchase Date</label>
                <div class="form-row">
                  <?=$r['pti']==0?'Has Not Purchased Yet':date($config['dateFormat'],$r['pti']).' ('.timeago($r['pti']).')';?>
                </div>
              </div>
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="spent">Spent</label>
                <div class="form-row">
                  <div class="input-text">$</div>
                  <input class="textinput" id="spent" type="number" value="<?=$r['spent'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="spent"<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savespent" data-dbid="spent" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <label for="points">Points Earned</label>
                <div class="form-row">
                  <input class="textinput" id="points" type="number" value="<?=$r['points'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="points"<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savepoints" data-dbid="points" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
            <hr>
            <legend role="heading">Subject Tags</legend>
            <label for="tags">Tags</label>
            <div class="form-row">
              <input class="textinput" id="tags" type="text" value="<?=$r['tags'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="tags"<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="savetags" data-dbid="tags" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <?php if($user['options'][1]==1){
              $tags=array();
              $st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
              if($st->rowCount()>0){
                while($rt=$st->fetch(PDO::FETCH_ASSOC)){
                  $tagslist=explode(",",$rt['tags']);
                  foreach($tagslist as$t){
                    $tgs[]=$t;
                  }
                }
              }
              if(!empty($tags)){
                $tags=array_unique($tgs);
                asort($tags);
              }
              echo'<select id="tags_options" onchange="addTag($(this).val());">'.
                '<option value="none">Clear All</option>';
                foreach($tags as$t)echo'<option value="'.$t.'">'.$t.'</option>';
              echo'</select>';
            }?>
          </div>
<?php /* Tab 2 Contact */ ?>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="name">Name</label>
                <div class="form-row">
                  <input class="textinput" id="name" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="name" type="text" value="<?=$r['name'];?>" placeholder="Enter a Name..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savename" data-dbid="name" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="business">Business</label>
                <div class="form-row">
                  <input class="textinput" id="business" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="business" type="text" value="<?=$r['business'];?>" placeholder="Enter a Business..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savebusiness" data-dbid="business" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
            <label for="url">URL</label>
            <div class="form-row">
              <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="url" type="text" value="<?=$r['url'];?>" placeholder="Enter a URL..."<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="saveurl" data-dbid="url" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="phone">Phone</label>
                <div class="form-row">
                  <input class="textinput" id="phone" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="phone" type="text" value="<?=$r['phone'];?>" placeholder="Enter a Phone..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savephone" data-dbid="phone" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="mobile">Mobile</label>
                <div class="form-row">
                  <input class="textinput" id="mobile" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="mobile" type="text" value="<?=$r['mobile'];?>" placeholder="Enter a Mobile..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savemobile" data-dbid="mobile" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="address">Address</label>
                <div class="form-row">
                  <input class="textinput" id="address" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="address" type="text" value="<?=$r['address'];?>" placeholder="Enter an Address..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="saveaddress" data-dbid="address" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="suburb">Suburb</label>
                <div class="form-row">
                  <input class="textinput" id="suburb" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="suburb" type="text" value="<?=$r['suburb'];?>" placeholder="Enter a Suburb..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savesuburb" data-dbid="suburb" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="city">City</label>
                <div class="form-row">
                  <input class="textinput" id="city" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="city" type="text" value="<?=$r['city'];?>" placeholder="Enter a City..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savecity" data-dbid="city" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="state">State</label>
                <div class="form-row">
                  <input class="textinput" id="state" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="state" type="text" value="<?=$r['state'];?>" placeholder="Enter a State..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savestate" data-dbid="state" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="postcode">Postcode</label>
                <div class="form-row">
                  <input class="textinput" id="postcode" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="postcode" type="text" value="<?=$r['postcode']!=0?$r['postcode']:'';?>" placeholder="Enter a Postcode..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savepostcode" data-dbid="postcode" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="country">Country</label>
                <div class="form-row">
                  <input class="textinput" id="country" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="country" type="text" value="<?=$r['country'];?>" placeholder="Enter a Country..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savecountry" data-dbid="country" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                </div>
              </div>
            </div>
            <div class="form-row mt-3">
              <input data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="bio" data-dbb="0" type="checkbox"<?=($r['bio']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginbio0<?=$r['id'];?>" for="bio0">Enable Bio</label>
            </div>
            <label for="caption">Caption</label>
            <div class="form-row">
              <input class="textinput" id="caption" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="caption" type="text" value="<?=$r['caption'];?>" placeholder="Enter a Caption..."<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="savecaption" data-dbid="caption" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label for="notes">Bio Notes</label>
            <div class="row">
              <?=($user['options'][5]==1?
                '<form target="sp" method="post" action="core/update.php">'.
                  '<input name="id" type="hidden" value="'.$r['id'].'">'.
                  '<input name="t" type="hidden" value="login">'.
                  '<input name="c" type="hidden" value="notes">'.
                  '<textarea class="summernote" id="notes" name="da">'.rawurldecode($r['notes']).'</textarea>'.
                '</form>'
              :
                '<textarea class="field" disabled>'.rawurldecode($r['notes']).'</textarea>'
              );?>
            </div>
            <div class="form-row mt-3">
              <input id="accountsContact" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="accountsContact" data-dbb="0" type="checkbox"<?=($r['accountsContact']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="accountsContact">Accounts&nbsp;Contact</label>
              <div class="form-text ml-2 mt-1">Set this to indicate Accounts that belong to the Accounts Payable Person</div>
            </div>
          </div>
<?php /* Tab 3 Media */ ?>
          <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <label for="avatar">Avatar</label>
              <div class="form-row">
                <img class="img-avatar border-radius-0" src="<?php if($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))
                  echo'media/avatar/'.basename($r['avatar']);
                elseif($r['gravatar']!='')
                  echo$r['gravatar'];
                else
                  echo ADMINNOAVATAR;?>" alt="<?=$r['username'];?>">
                <input type="text" value="<?=$r['avatar'];?>" readonly>
                <?=($user['options'][5]==1?'<input name="id" type="hidden" value="'.$r['id'].'"><input name="act" type="hidden" value="add_avatar"><div class="btn"><label class="m-0" for="avatarfu" data-tooltip="tooltip" aria-label="Browse Computer for Files."><i class="i">browse-computer</i><input class="hidden" id="avatarfu" name="fu" type="file" onchange="form.submit();"></label></div><button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`login`,`avatar`,``);"><i class="i">trash</i></button>':'');?>
              </div>
            </form>
            <label for="gravatar">Gravatar</label>
            <div class="form-text"><a target="_blank" href="http://www.gravatar.com/">Gravatar</a> link will override any image uploaded as your Avatar.</div>
            <div class="form-row">
              <input class="textinput" id="gravatar" type="text" value="<?=$r['gravatar'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter a Gravatar Link..."<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="savegravatar" data-dbid="gravatar" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
          </div>
<?php /* Tab 4 Proofs */ ?>
          <div class="tab1-4 border p-3" data-tabid="tab1-4" role="tabpanel">
            <div class="row" id="mi">
              <?php $sm=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='proofs' AND `uid`=:id ORDER BY `ord` ASC");
              $sm->execute([':id'=>$r['id']]);
              while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                if(file_exists('media/sm/'.basename($rm['file'])))
                  $thumb='media/md/'.basename($rm['file']);
                elseif($rm['file']!='')
                  $thumb=$rm['file'];
                else
                  $thumb=ADMINNOIMAGE;
                $scn=$sccn=0;
                $sc=$db->prepare("SELECT COUNT(`rid`) as cnt FROM `".$prefix."comments` WHERE `rid`=:rid AND `contentType`='proofs'");
                $sc->execute([':rid'=>$rm['id']]);
                $scn=$sc->fetch(PDO::FETCH_ASSOC);
                $scc=$db->prepare("SELECT COUNT(`rid`) as cnt FROM `".$prefix."comments` WHERE `rid`=:rid AND `status`!='approved'");
                $scc->execute([':rid'=>$rm['id']]);
                $sccn=$scc->fetch(PDO::FETCH_ASSOC);?>
                <div id="mi_<?=$rm['id'];?>" class="card stats gallery col-12 col-sm-3 m-0 border-0">
                  <a data-fancybox="media" data-type="image" data-caption="<?=($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?=$rm['file'];?>">
                    <img src="<?=$thumb;?>" alt="Media <?=$rm['id'];?>">
                  </a>
                  <div class="btn-group tools">
                    <a class="btn" data-tooltip="right" href="<?= URL.$settings['system']['admin'].'/content/edit/'.$rm['id'].'#d43';?>"<?=($sccn['cnt']>0?' data-tooltip="tooltip" aria-label="'.$sccn['cnt'].' Comments"':'');?> aria-label="Comments"><?=$scn['cnt'];?></a>
                    <?=($user['options'][1]==1?'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rm['id'].'" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a><div class="btn handle" data-tooltip="left" aria-label="Drag to Reorder"><i class="i">drag</i></div>':'');?>
                  </div>
                </div>
              <?php }?>
              <div class="ghost"></div>
            </div>
            <?php if($user['options'][1]==1){?>
              <script>
                $('#mi').sortable({
                  items:"#mi",
                  handle:'.handle',
                  placeholder:"ghost",
                  helper:fixWidthHelper,
                  update:function(e,ui){
                    var order=$("#mi").sortable("serialize");
                    $.ajax({
                      type:"POST",
                      dataType:"json",
                      url:"core/reorderproofs.php",
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
<?php /* Tab 5 Social */ ?>
          <div class="tab1-5 border" data-tabid="tab1-5" role="tabpanel">
            <div class="sticky-top">
              <div class="row">
                <article class="card mb-0 p-0 py-2 overflow-visible card-list card-list-header bg-white shadow">
                  <div class="row">
                    <div class="col-12 col-md-3 pl-2">Social Network</div>
                    <div class="col-12 col-md-9 pl-2">URL</div>
                  </div>
                </article>
              </div>
              <?php if($user['options'][0]==1||$user['options'][5]==1){?>
                <form class="row m-0 p-0" target="sp" method="post" action="core/add_social.php">
                  <input name="user" type="hidden" value="<?=$r['id'];?>">
                  <input name="act" type="hidden" value="add_social">
                  <div class="col-12 col-md-3">
                    <select name="icon">
                      <option value="">Select a Social Network...</option>
                      <option value="discord">Discord</option>
                      <option value="facebook">Facebook</option>
                      <option value="github">GitHub</option>
                      <option value="instagram">Instagram</option>
                      <option value="linkedin">Linkedin</option>
                      <option value="twitter">Twitter</option>
                      <option value="youtube">YouTube</option>
                      <option value="500px">500px</option>
                      <option value="aboutme">About Me</option>
                      <option value="airbnb">AirBNB</option>
                      <option value="amazon">Amazon</option>
                      <option value="behance">Behance</option>
                      <option value="bitcoin">Bitcoin</option>
                      <option value="blogger">Blogger</option>
                      <option value="buffer">Buffer</option>
                      <option value="cargo">Cargo</option>
                      <option value="codepen">Codepen</option>
                      <option value="coroflot">Coroflot</option>
                      <option value="creattica">Creattica</option>
                      <option value="delicious">Delcicious</option>
                      <option value="deviantart">DeviantArt</option>
                      <option value="diaspora">Diaspora</option>
                      <option value="digg">Digg</option>
                      <option value="discourse">Discourse</option>
                      <option value="disqus">Disqus</option>
                      <option value="dribbble">Dribbble</option>
                      <option value="dropbox">Dropbox</option>
                      <option value="envato">Envato</option>
                      <option value="etsy">Etsy</option>
                      <option value="feedburner">Feedburner</option>
                      <option value="flickr">Flickr</option>
                      <option value="forrst">Forrst</option>
                      <option value="gitlab">GitLab</option>
                      <option value="gravatar">Gravatar</option>
                      <option value="hackernews">Hackernews</option>
                      <option value="icq">ICQ</option>
                      <option value="kickstarter">Kickstarter</option>
                      <option value="last-fm">Last FM</option>
                      <option value="lego">Lego</option>
                      <option value="lynda">Lynda</option>
                      <option value="massroots">Massroots</option>
                      <option value="medium">Medium</option>
                      <option value="myspace">MySpace</option>
                      <option value="netlify">Netlify</option>
                      <option value="ovh">OVH</option>
                      <option value="paypal">Paypal</option>
                      <option value="periscope">Periscope</option>
                      <option value="picasa">Picasa</option>
                      <option value="pinterest">Pinterest</option>
                      <option value="play-store">Play Store</option>
                      <option value="quora">Quora</option>
                      <option value="redbubble">Red Bubble</option>
                      <option value="reddit">Reddit</option>
                      <option value="sharethis">Sharethis</option>
                      <option value="skype">Skype</option>
                      <option value="snapchat">Snapchat</option>
                      <option value="soundcloud">Soundcloud</option>
                      <option value="stackoverflow">Stackoverflow</option>
                      <option value="steam">Steam</option>
                      <option value="stumbleupon">StumbleUpon</option>
                      <option value="tsu">TSU</option>
                      <option value="tumblr">Tumblr</option>
                      <option value="twitch">Twitch</option>
                      <option value="ubiquiti">Ubiquiti</option>
                      <option value="unsplash">Unsplash</option>
                      <option value="vimeo">Vimeo</option>
                      <option value="vine">Vine</option>
                      <option value="whatsapp">Whatsapp</option>
                      <option value="wikipedia">Wikipedia</option>
                      <option value="windows-store">Windows Store</option>
                      <option value="xbox-live">Xbox Live</option>
                      <option value="yahoo">Yahoo</option>
                      <option value="yelp">Yelp</option>
                      <option value="zerply">Zerply</option>
                      <option value="zune">Zune</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-9">
                    <div class="form-row">
                      <input id="socialurl" name="url" type="text" value="" placeholder="Enter a URL...">
                      <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">plus</i></button>
                    </div>
                  </div>
                </form>
              <?php }?>
            </div>
            <div id="social">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=:uid ORDER BY `icon` ASC");
              $ss->execute([':uid'=>$r['id']]);
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div class="row" id="l_<?=$rs['id'];?>">
                  <div class="col-12 col-md-3">
                    <div class="input-text col-12" data-tooltip="tooltip" aria-label="<?= ucfirst($rs['icon']);?>"><i class="i i-social i-2x social-<?=$rs['icon'];?>">social-<?=$rs['icon'].'</i>&nbsp;&nbsp'.ucfirst($rs['icon']);?></div>
                  </div>
                  <div class="col-12 col-md-9">
                    <div class="form-row">
                      <div class="input-text col-md"><?=$rs['url'];?></div>
                      <?php if($user['options'][7]==1){?>
                        <form target="sp" action="core/purge.php">
                          <input name="id" type="hidden" value="<?=$rs['id'];?>">
                          <input name="t" type="hidden" value="choices">
                          <button class="trash" type="submit" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                        </form>
                      <?php }?>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
<?php /* Tab 6 Messages */ ?>
          <div class="tab1-6 border p-3" data-tabid="tab1-6" role="tabpanel">
            <label for="email_signature">Email Signature</label>
            <div class="row">
              <?=($user['options'][5]==1?'<form target="sp" method="post" action="core/update.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="login"><input name="c" type="hidden" value="email_signature"><textarea class="summernote" id="email_signature" name="da">'.rawurldecode($r['email_signature']).'</textarea></form>':'<textarea class="field" disabled>'.rawurldecode($r['email_signature']).'</textarea>');?>
            </div>
          </div>
<?php /* Tab 7 Orders */ ?>
          <?php if($user['options'][4]==1){?>
            <div class="tab1-7 border" data-tabid="tab1-7" role="tabpanel">
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
                <?php $so=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `cid`=:cid ORDER BY `ti` DESC");
                $so->execute([':cid'=>$r['id']]);
                while($ro=$so->fetch(PDO::FETCH_ASSOC)){?>
                  <article class="card zebra m-0 mt-2 mb-0 p-2 border-0 overflow-visible shadow" id="l_<?=$ro['id'];?>">
                    <div class="col-md pt-2 text-center">
                      <a href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$ro['id']?>"><?=($ro['aid']!=''?$ro['aid'].'<br>':'').$ro['qid'].$ro['iid'];?></a>
                    </div>
                    <div class="col-md pt-2 text-center">
                      Date:&nbsp;<?=' '.date($config['dateFormat'],($ro['iid_ti']==0?$ro['qid_ti']:$ro['iid_ti']));?><br>
                      <small>Due:&nbsp;<?= date($config['dateFormat'],$ro['due_ti']);?></small>
                    </div>
                    <div class="col-md pt-2 text-center">
                      <span class="badger badge-<?=$ro['status'];?> badge-2x"><?= ucfirst($ro['status']);?></span>
                    </div>
                    <div class="col-md text-right">
                      <div class="btn-group" role="group">
                        <?='<button class="btn print" data-tooltip="tooltip" aria-label="Print Order" onclick="$(`#sp`).load(`core/email_order.php?id='.$ro['id'].'&act=print`);"><i class="i">print</i></button>'.(isset($r['email'])&&$r['email']!=''?'<button class="email" data-tooltip="tooltip" aria-label="Email Order" onclick="$(`#sp`).load(`core/email_order.php?id='.$ro['id'].'&act=`);"><i class="i">email-send</i></button>':'').'<a class="rounded-right '.($ro['status']=='delete'?' d-none':'').'" href="'.URL.$settings['system']['admin'].'/orders/edit/'.$ro['id'].'" role="button" data-tooltip="tooltip" aria-label="Edit Order"><i class="i">edit</i></a><button class="add'.($ro['status']!='delete'?' d-none':'').'" id="untrash'.$ro['id'].'" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons(`'.$ro['id'].'`,`orders`,`status`,``);"><i class="i">untrash</i></button><button class="trash'.($ro['status']=='delete'?' d-none':'').'" id="delete'.$ro['id'].'" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons(`'.$ro['id'].'`,`orders`,`status`,`delete`);"><i class="i">trash</i></button><button class="purge'.($ro['status']!='delete'?' d-none':'').'" id="purge'.$ro['id'].'" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$ro['id'].'`,`orders`);"><i class="i">purge</i></button><button class="quickeditbtn" data-qeid="'.$ro['id'].'" data-qet="orders" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>';?>
                      </div>
                    </div>
                  </article>
                  <div class="quickedit" id="quickedit<?=$ro['id'];?>"></div>
                <?php }?>
              </section>
            </div>
          <?php }
/* Tab 7 Settings */ ?>
          <div class="tab1-8 border p-3" data-tabid="tab1-8" role="tabpanel">
            <label for="timezone">Timezone</label>
            <select id="timezone" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="timezone"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','timezone',$(this).val(),'select');">
              <option value="default">System Default</option>
              <?php $o=[
                'Australia/Perth'=>"(GMT+08:00) Perth",
                'Australia/Adelaide'=>"(GMT+09:30) Adelaide",
                'Australia/Darwin'=>"(GMT+09:30) Darwin",
                'Australia/Brisbane'=>"(GMT+10:00) Brisbane",
                'Australia/Canberra'=>"(GMT+10:00) Canberra",
                'Australia/Hobart'=>"(GMT+10:00) Hobart",
                'Australia/Melbourne'=>"(GMT+10:00) Melbourne",
                'Australia/Sydney'=>"(GMT+10:00) Sydney"
              ];
              foreach($o as$tz=>$label)echo'<option value="'.$tz.'"'.($tz==$r['timezone']?' selected':'').'>'.$tz.'</option>';?>
            </select>
            <?php if($user['id']==$r['id']||$user['options'][5]==1){?>
              <form target="sp" method="post" action="core/update.php" onsubmit="$('.page-block').addClass('d-block');">
                <label for="password">Password</label>
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <input name="t" type="hidden" value="login">
                <input name="c" type="hidden" value="password">
                <div class="form-row">
                  <input id="password" name="da" type="password" value="" placeholder="Enter a  New Password..." onkeyup="$('#passButton').addClass('btn-danger');">
                  <button id="passButton" type="submit">Update&nbsp;Password</button>
                </div>
              </form>
            <?php }?>
            <div class="form-row mt-3">
              <input id="active" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="active" data-dbb="0" type="checkbox"<?=($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="active">Active</label>
            </div>
            <label for="rank">Rank</label>
            <select id="rank" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="rank"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','rank',$(this).val(),'select');">
              <option value="0"<?=$r['rank']==0?' selected':'';?>>Visitor</option>
              <option value="100"<?=$r['rank']==100?' selected':'';?>>Subscriber</option>
              <option value="200"<?=$r['rank']==200?' selected':'';?>>Member</option>
              <option value="210"<?=$r['rank']==210?' selected':'';?>>Member Silver</option>
              <option value="220"<?=$r['rank']==220?' selected':'';?>>Member Bronze</option>
              <option value="230"<?=$r['rank']==230?' selected':'';?>>Member Gold</option>
              <option value="240"<?=$r['rank']==240?' selected':'';?>>Member Platinum</option>
              <option value="300"<?=$r['rank']==300?' selected':'';?>>Client</option>
              <option value="310"<?=$r['rank']==310?' selected':'';?>>Wholesaler</option>
              <option value="320"<?=$r['rank']==320?' selected':'';?>>Wholesaler Bronze</option>
              <option value="330"<?=$r['rank']==330?' selected':'';?>>Wholesaler Silver</option>
              <option value="340"<?=$r['rank']==340?' selected':'';?>>Wholesaler Gold</option>
              <option value="350"<?=$r['rank']==350?' selected':'';?>>Wholesaler Platinum</option>
              <option value="400"<?=$r['rank']==400?' selected':'';?>>Contributor</option>
              <?=($user['rank']>400?'<option value="500"'.($r['rank']==500?' selected':'').'>Author</option>':'').
              ($user['rank']>500?'<option value="600"'.($r['rank']==600?' selected':'').'>Editor</option>':'').
              ($user['rank']>600?'<option value="700"'.($r['rank']==700?' selected':'').'>Moderator</option>':'').
              ($user['rank']>700?'<option value="800"'.($r['rank']==800?' selected':'').'>Manager</option>':'').
              ($user['rank']>800?'<option value="900"'.($r['rank']==900?' selected':'').'>Administrator</option>':'').
              ($user['rank']==1000?'<option value="1000"'.($r['rank']==1000?' selected':'').'>Developer</option>':'');?>
            </select>
            <hr>
            <legend>Account Permissions</legend>
            <div class="form-row mt-3">
              <input id="wholesalerAccepted" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="19" type="checkbox"<?=($r['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="wholesalerAccepted">Wholesaler Accepted to Purchase</label>
            </div>
            <div class="form-row">
              <input id="forumBanned" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="20" type="checkbox"<?=($r['options'][20]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="forumBanned">Banned From Posting or Replying on Forum</label>
            </div>
            <div class="form-row">
              <input id="forumHelpResponder" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="helpResponder" data-dbb="0" type="checkbox"<?=($r['helpResponder']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="forumHelpResponder">Forum Help Ticket Responder (Receives Urgent Emails).</label>
            </div>
            <div class="form-row">
              <input id="newsletterSubscriber" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0" type="checkbox"<?=($r['newsletter']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="newsletterSubscriber">Newsletter Subscriber</label>
            </div>
            <div class="form-row">
              <input id="addRemoveContent" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0" type="checkbox"<?=($r['options'][0]==1?' checked aria-checked="true"':' aria-checkd="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="addRemoveContent">Add or Remove Content</label>
            </div>
            <div class="form-row">
              <input id="editContent" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1" type="checkbox"<?=($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="editContent">Edit Content</label>
            </div>
            <div class="form-row">
              <input id="addEditBookings" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2" type="checkbox"<?=($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="addEditBookings">Add or Edit Bookings</label>
            </div>
            <div class="form-row">
              <input id="viewEditMessages" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3" type="checkbox"<?=($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="viewEditMessages">Messages Viewing or Editing</label>
            </div>
            <div class="form-row">
              <input id="viewEditOrders" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4" type="checkbox"<?=($r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="viewEditOrders">Orders Viewing or Editing</label>
            </div>
            <div class="form-row">
              <input id="viewEditAccounts" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="5" type="checkbox"<?=($r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="viewEditAccounts">User Accounts Viewing or Editing</label>
            </div>
            <div class="form-row">
              <input id="editSEO" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6" type="checkbox"<?=($r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="editSEO">SEO Editing</label>
            </div>
            <div class="form-row">
              <input id="viewEditPreferences" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7" type="checkbox"<?=($r['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="viewEditPreferences">Preferences/Settings Viewing or Editing</label>
            </div>
            <div class="form-row">
              <input id="liveChatNotifications" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="liveChatNotification" data-dbb="0" type="checkbox"<?=($r['liveChatNotification']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="liveChatNotifications">Email LiveChat notifications</label>
            </div>
            <div class="form-row">
              <input id="trackIP" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="18" type="checkbox"<?=($r['options'][18]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="trackIP">Do Not Track IP</label>
            </div>
            <?php if($user['rank']>899){?>
              <?php if($user['rank']==1000||$config['options'][17]==1){?>
                <legend class="mt-3">Media Permissions</legend>
                <div class="form-row mt-3">
                  <input id="options17" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="17" type="checkbox"<?=($r['options'][17]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label class="p-0 mt-0 ml-3" for="options17">Allow this Administrator to change below Permissions</label>
                </div>
              <?php }
              if($r['options'][17]==1||$user['rank']==1000){?>
                <div class="form-row">
                  <input id="options16" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="16" type="checkbox"<?=($r['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options16">Hide Folders</label>
                </div>
                <div class="form-row">
                  <input id="options10" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="10" type="checkbox"<?=($r['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options10">Create Folders</label>
                </div>
                <div class="form-row">
                  <input id="options11" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="11" type="checkbox"<?=($r['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options11">Read Files</label>
                </div>
                <div class="form-row">
                  <input id="options12" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="12" type="checkbox"<?=($r['options'][12]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options12">Write Files</label>
                </div>
                <div class="form-row">
                  <input id="options13" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="13" type="checkbox"<?=($r['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options13">Extract Archives</label>
                </div>
                <div class="form-row">
                  <input id="options14" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="14" type="checkbox"<?=($r['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options14">Create Archives</label>
                </div>
                <div class="form-row">
                  <input id="options15" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="15" type="checkbox"<?=($r['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options15">Upload Files (pdf,doc,php)</label>
                </div>
              <?php }?>
            </div>
          <?php }
/* Tab 1-9 Hosting */
          if($config['hoster']==1){?>
            <div class="tab1-9 border p-3" data-tabid="tab1-9" role="tabpanel">
              <legend>Hosting Payments</legend>
              <div class="row">
                <div class="col-12 col-sm-4 pr-sm-3">
                  <label for="hostCost">Hosting Cost</label>
                  <div class="form-row">
                    <input class="textinput" id="hostCost" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="hostCost" type="text" value="<?=$r['hostCost'];?>" placeholder="Enter a Cost...">
                    <button class="save" id="savehostCost" data-dbid="hostCost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                  </div>
                </div>
                <div class="col-12 col-sm-4 pr-sm-3">
                  <label for="hti">Due On <span class="labeldate" id="labeldatehti">(<?= date($config['dateFormat'],$r['hti']);?>)</span></label>
                  <div class="form-row">
                    <input id="hti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['hti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`login`,`hti`,getTimestamp(`hti`),`select`);"':' readonly';?>>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <label for="hostStatus">Hosting Status</label>
                  <div class="form-row">
                    <select id="hostStatus" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="hostStatus"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','hostStatus',$(this).val(),'select');">
                      <option value="paid"<?=$r['hostStatus']=='paid'?' selected':'';?>>Paid</option>
                      <option value="outstanding"<?=$r['siteStatus']=='outstanding'?' selected':'';?>>Outstanding</option>
                      <option value="overdue"<?=$r['hostStatus']=='overdue'?' selected':'';?>>Overdue</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <legend class="mt-3">Site Payments</legend>
              <div class="row">
                <div class="col-12 col-sm-4 pr-sm-3">
                  <label for="hostCost">Site Payments</label>
                  <div class="form-row">
                    <input class="textinput" id="siteCost" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="siteCost" type="text" value="<?=$r['siteCost'];?>" placeholder="Enter a Cost...">
                    <button class="save" id="savesiteCost" data-dbid="siteCost" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
                  </div>
                </div>
                <div class="col-12 col-sm-4 pr-sm-3">
                  <label for="sti">Due On <span class="labeldate" id="labeldatehti">(<?= date($config['dateFormat'],$r['sti']);?>)</span></label>
                  <div class="form-row">
                    <input id="sti" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['sti']);?>" autocomplete="off"<?=$user['options'][1]==1?' onchange="update(`'.$r['id'].'`,`login`,`sti`,getTimestamp(`sti`),`select`);"':' readonly';?>>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <label for="siteStatus">Payment Status</label>
                  <div class="form-row">
                    <select id="siteStatus" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="siteStatus"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','siteStatus',$(this).val(),'select');">
                      <option value="paid"<?=$r['siteStatus']=='paid'?' selected':'';?>>Paid</option>
                      <option value="outstanding"<?=$r['siteStatus']=='outstanding'?' selected':'';?>>Outstanding</option>
                      <option value="overdue"<?=$r['siteStatus']=='overdue'?' selected':'';?>>Overdue</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
