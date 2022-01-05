<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts - Edit
 * @package    core/layout/edit_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([':id'=>$args[1]]);
$r=$q->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon">
            <?php if($r['gravatar']!='')echo'<img src="https://www.gravatar.com/avatar/'.md5($r['gravatar']).'" alt="'.$r['username'].($r['name']!=''?':'.$r['name']:'').'">';
            elseif($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))echo'<img src="media/avatar/'.$r['avatar'].'" alt="'.$r['username'].($r['name']!=''?':'.$r['name']:'').'">';
            else svg('user','i-3x');?></div>
          <div>Edit Account <?=$r['username'].':'.$r['name'];?></div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="tooltip" aria-label="Back"><?= svg2('back');?></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
          <li class="breadcrumb-item active">Edit</li>
          <li class="breadcrumb-item active"><span id="usersusername"><?=$r['username'];?></span>:<span id="usersname"><?=$r['name'];?></span></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Contact</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Images</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Proofs</label>
          <input class="tab-control" id="tab1-5" name="tabs" type="radio">
          <label for="tab1-5">Social</label>
          <input class="tab-control" id="tab1-6" name="tabs" type="radio">
          <label for="tab1-6">Messages</label>
          <input class="tab-control" id="tab1-7" name="tabs" type="radio">
          <label for="tab1-7">Settings</label>
<?php if($config['hoster'][0]==1){?>
          <input class="tab-control" id="tab1-8" name="tabs" type="radio">
          <label for="tab1-8">Hosting/Website Payments</label>
<?php }?>
<?php /* Tab 1 General */?>
          <div class="tab1-1 border-top p-3" data-tabid="tab1-1" role="tabpanel">
            <?=$user['rank']==1000?'<div class="row">'.
              '<div id="accountIP" class="col-12">'.
                ($user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountIP" data-tooltip="tooltip" aria-label="PermaLink to Account IP Field">&#128279;</a>':'').
                '<div class="form-text text-muted">'.
                  '<small>IP: '.$r['userIP'].' | '.$r['userAgent'].'</small>'.
                '</div>'.
              '</div>'.
            '</div>':'';?>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label id="accountDateCreated" for="ti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountDateCreated" data-tooltip="tooltip" aria-label="PermaLink to Created Field">&#128279;</a>':'';?>Created</label>
                <div class="form-row">
                  <input id="ti" type="text" value="<?= date($config['dateFormat'],$r['ti']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label id="accountLastLogin" for="lti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountLastLogin" data-tooltip="tooltip" aria-label="PermaLink to Last Login Field">&#128279;</a>':'';?>Last Login</label>
                <div class="form-row">
                  <input id="lti" type="text" value="<?= _ago($r['lti']);?>" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label id="accountUsername" for="username"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountUsername" data-tooltip="tooltip" aria-label="PermaLink to Username Field">&#128279;</a>':'';?>Username</label>
                <div class="form-row">
                  <input class="textinput" id="username" type="text" value="<?=$r['username'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="saveusername" data-dbid="username" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <div class="alert alert-danger d-none" id="uerror" role="alert">Username already exists!</div>
                <label id="accountEmail" for="email"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountEmail" data-tooltip="tooltip" aria-label="PermaLink to Email Field">&#128279;</a>':'';?>Email</label>
                <div class="form-row">
                  <input class="textinput" id="email" type="text" value="<?=$r['email'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="saveemail" data-dbid="email" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
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
}else$purchaseLimit=$r['purchaseLimit'];
if($purchaseLimit==0||$purchaseLimit=='')$purchaseLimit='Unlimited';?>
            <div class="row">
              <div class="col-12 col-sm-6 pr-2">
                <label id="accountpurchaseLimit" for="purchaseLimit"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountpurchaseLimit" data-tooltip="tooltip" aria-label="PermaLink to Purchase Limit Field">&#128279;</a>':'';?>Purchase Limit Override</label>
                <div class="form-row">
                  <input class="textinput" id="purchaseLimit" type="number" value="<?=$r['purchaseLimit'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="purchaseLimit"<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savepurchaseLimit" data-dbid="purchaseLimit" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
                <small class="form-text">(Set to "0" or no value to use default for this account level, currently allowed to purchase <?=$purchaseLimit;?> items.)</small>
              </div>
              <div class="col-12 col-sm-6 pl-2">
                <label id="accountPurchaseTime" for="purchaseTime"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountPurchaseTime" data-tooltip="tooltip" aria-label="PermaLink to Purchase Time Selector">&#128279;</a>':'';?>Wholesale Purchase Time</label>
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
              <div class="col-12 col-sm-4 pr-2">
                <label id="accountpti" for="pti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountpti" data-tooltip="tooltip" aria-label="PermaLink to Last Purchase Date">&#128279;</a>':'';?>Last Purchase Date</label>
                <div class="form-row">
                  <?=$r['pti']==0?'Has Not Purchased Yet':date($config['dateFormat'],$r['pti']).' ('._ago($r['pti']).')';?>
                </div>
              </div>
              <div class="col-12 col-sm-4 pl-2">
                <label id="accountSpent" for="spent"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountSpent" data-tooltip="tooltip" aria-label="PermaLink to Spent Field">&#128279;</a>':'';?>Spent</label>
                <div class="form-row">
                  <div class="input-text">$</div>
                  <input class="textinput" id="spent" type="number" value="<?=$r['spent'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="spent"<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savespent" data-dbid="spent" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-sm-4 pl-2">
                <label id="accountPoints" for="points"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountPoints" data-tooltip="tooltip" aria-label="PermaLink to Points Earned Field">&#128279;</a>':'';?>Points Earned</label>
                <div class="form-row">
                  <input class="textinput" id="points" type="number" value="<?=$r['points'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="points"<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savepoints" data-dbid="points" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
            </div>
            <hr>
            <legend role="heading">Subject Tags</legend>
            <label id="accountTags" for="tags"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountTags" data-tooltip="tooltip" aria-label="PermaLink to Tags Field">&#128279;</a>':'';?>Tags</label>
            <div class="form-row">
              <input class="textinput" id="tags" type="text" value="<?=$r['tags'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="tags"<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="savetags" data-dbid="tags" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
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
          <div class="tab1-2 border-top p-3" data-tabid="tab1-2" role="tabpanel">
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label id="accountName" for="name"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountName" data-tooltip="tooltip" aria-label="PermaLink to Name Field">&#128279;</a>':'';?>Name</label>
                <div class="form-row">
                  <input class="textinput" id="name" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="name" type="text" value="<?=$r['name'];?>" placeholder="Enter a Name..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savename" data-dbid="name" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label id="accountBusiness" for="business"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountBusiness" data-tooltip="tooltip" aria-label="PermaLink to Business Field">&#128279;</a>':'';?>Business</label>
                <div class="form-row">
                  <input class="textinput" id="business" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="business" type="text" value="<?=$r['business'];?>" placeholder="Enter a Business..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savebusiness" data-dbid="business" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
            </div>
            <label id="accountURL" for="url"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountURL" data-tooltip="tooltip" aria-label="PermaLink to URL Field">&#128279;</a>':'';?>URL</label>
            <div class="form-row">
              <input class="textinput" id="url" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="url" type="text" value="<?=$r['url'];?>" placeholder="Enter a URL..."<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="saveurl" data-dbid="url" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label id="accountPhone" for="phone"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountPhone" data-tooltip="tooltip" aria-label="PermaLink to Phone Field">&#128279;</a>':'';?>Phone</label>
                <div class="form-row">
                  <input class="textinput" id="phone" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="phone" type="text" value="<?=$r['phone'];?>" placeholder="Enter a Phone..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savephone" data-dbid="phone" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label id="accountMobile" for="mobile"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountMobile" data-tooltip="tooltip" aria-label="PermaLink to Mobile Field">&#128279;</a>':'';?>Mobile</label>
                <div class="form-row">
                  <input class="textinput" id="mobile" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="mobile" type="text" value="<?=$r['mobile'];?>" placeholder="Enter a Mobile..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savemobile" data-dbid="mobile" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label id="accountAddress" for="address"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountAddress" data-tooltip="tooltip" aria-label="PermaLink to Address Field">&#128279;</a>':'';?>Address</label>
                <div class="form-row">
                  <input class="textinput" id="address" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="address" type="text" value="<?=$r['address'];?>" placeholder="Enter an Address..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="saveaddress" data-dbid="address" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label id="accountSuburb" for="suburb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountSuburb" data-tooltip="tooltip" aria-label="PermaLink to Suburb Field">&#128279;</a>':'';?>Suburb</label>
                <div class="form-row">
                  <input class="textinput" id="suburb" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="suburb" type="text" value="<?=$r['suburb'];?>" placeholder="Enter a Suburb..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savesuburb" data-dbid="suburb" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label id="accountCity" for="city"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountCity" data-tooltip="tooltip" aria-label="PermaLink to City Field">&#128279;</a>':'';?>City</label>
                <div class="form-row">
                  <input class="textinput" id="city" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="city" type="text" value="<?=$r['city'];?>" placeholder="Enter a City..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savecity" data-dbid="city" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label id="accountState" for="state"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountState" data-tooltip="tooltip" aria-label="PermaLink to State Field">&#128279;</a>':'';?>State</label>
                <div class="form-row">
                  <input class="textinput" id="state" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="state" type="text" value="<?=$r['state'];?>" placeholder="Enter a State..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savestate" data-dbid="state" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label id="accountPostcode" for="postcode"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountPostcode" data-tooltip="tooltip" aria-label="PermaLink to Postcode Field">&#128279;</a>':'';?>Postcode</label>
                <div class="form-row">
                  <input class="textinput" id="postcode" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="postcode" type="text" value="<?=$r['postcode']!=0?$r['postcode']:'';?>" placeholder="Enter a Postcode..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savepostcode" data-dbid="postcode" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label id="accountCountry" for="country"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountCountry" data-tooltip="tooltip" aria-label="PermaLink to Country Field">&#128279;</a>':'';?>Country</label>
                <div class="form-row">
                  <input class="textinput" id="country" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="country" type="text" value="<?=$r['country'];?>" placeholder="Enter a Country..."<?=$user['options'][5]==1?'':' readonly';?>>
                  <?=$user['options'][5]==1?'<button class="save" id="savecountry" data-dbid="country" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <input id="bio0" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="bio" data-dbb="0" type="checkbox"<?=($r['bio'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginbio0<?=$r['id'];?>" for="bio0">Enable Bio</label>
            </div>
            <label id="accountCaption" for="caption"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountCaption" data-tooltip="tooltip" aria-label="PermaLink to Caption Field">&#128279;</a>':'';?>Caption</label>
            <div class="form-row">
              <input class="textinput" id="caption" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="caption" type="text" value="<?=$r['caption'];?>" placeholder="Enter a Caption..."<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="savecaption" data-dbid="caption" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
            <label id="accountNotes" for="notes"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountNotes" data-tooltip="tooltip" aria-label="PermaLink to Bio Notes">&#128279;</a>':'';?>Bio Notes</label>
            <div class="row">
              <?=$user['options'][5]==1?'<form target="sp" method="post" action="core/update.php">'.
                '<input name="id" type="hidden" value="'.$r['id'].'">'.
                '<input name="t" type="hidden" value="login">'.
                '<input name="c" type="hidden" value="notes">'.
                '<textarea class="summernote" id="notes" name="da">'.rawurldecode($r['notes']).'</textarea></form>'
              :
              '<textarea class="field">'.rawurldecode($r['notes']).'</textarea>';?>
            </div>
            <div class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountsContact" data-tooltip="tooltip" aria-label="PermaLink to Accounts Contact Checkbox">&#128279;</a>':'';?>
              <input id="accountsContact" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="accountsContact" data-dbb="0" type="checkbox"<?=($r['accountsContact'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginaccountsContact0<?=$r['id'];?>" for="accountsContact">Accounts Contact</label>
              <small class="help-text">Set this to indicate Accounts that belong to the Accounts Payable Person</small>
            </div>
          </div>
<?php /* Tab 3 Images */ ?>
          <div class="tab1-3 border-top p-3" data-tabid="tab1-3" role="tabpanel">
            <label id="accountAvatar" for="avatar"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountAvatar" data-tooltip="tooltip" aria-label="PermaLink to Avatar Field">&#128279;</a>':'';?>Avatar</label>
            <form class="form-row p-0" target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <input type="text" value="<?=$r['avatar'];?>" readonly>
              <?php if($user['options'][5]==1){?>
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <input name="act" type="hidden" value="add_avatar">
                <div class="btn">
                  <label for="avatarfu" data-tooltip="tooltip" aria-label="Browse Computer for Files."><?php svg('browse-computer');?>
                    <input class="hidden" id="avatarfu" name="fu" type="file" onchange="form.submit();">
                  </label>
                </div>
              <?php }?>
              <img class="img-avatar border-radious-0" src="<?php if($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))echo'media/avatar/'.basename($r['avatar']);
              elseif($r['gravatar']!='')echo$r['gravatar'];
              else echo ADMINNOAVATAR;?>" alt="<?=$r['username'];?>">
              <?=$user['options'][5]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`login`,`avatar`,``);">'.svg2('trash').'</button>':'';?>
            </form>
            <div class="form-row mt-3">
              <label id="accountGravatar" for="gravatar"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountGravatar" data-tooltip="tooltip" aria-label="PermaLink to Gravatar Field">&#128279;</a>':'';?>Gravatar</label>
              <div class="form-text text-right"><a target="_blank" href="http://www.gravatar.com/">Gravatar</a> link will override any image uploaded as your Avatar.</div>
            </div>
            <div class="form-row">
              <input class="textinput" id="gravatar" type="text" value="<?=$r['gravatar'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter a Gravatar Link..."<?=$user['options'][5]==1?'':' readonly';?>>
              <?=$user['options'][5]==1?'<button class="save" id="savegravatar" data-dbid="gravatar" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
<?php /* Tab 3 Proofs */ ?>
          <div class="tab1-4 border-top p-3" data-tabid="tab1-4" role="tabpanel">
            <div class="form-row" id="mi">
              <?php $sm=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='proofs' AND `uid`=:id ORDER BY `ord` ASC");
              $sm->execute([
                ':id'=>$r['id']
              ]);
              while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                if(file_exists('media/md/'.basename($rm['file'])))
                  $thumb='media/md/'.basename($rm['file']);
                else
                  $thumb=ADMINNOIMAGEMD;?>
                <div class="card stats col-6 col-md-3 m-1" id="mi_<?=$rm['id'];?>">
                  <div class="btn-group float-right">
                    <a class="btn" href="<?= URL.$settings['system']['admin'].'/content/edit/'.$rm['id'];?>"><?= svg2('edit');?></a>
                    <?php $scn=$sccn=0;
                    $sc=$db->prepare("SELECT COUNT(`rid`) as cnt FROM `".$prefix."comments` WHERE `rid`=:rid AND `contentType`='proofs'");
                    $sc->execute([
                      ':rid'=>$rm['id']
                    ]);
                    $scn=$sc->fetch(PDO::FETCH_ASSOC);
                    $scc=$db->prepare("SELECT COUNT(`rid`) as cnt FROM `".$prefix."comments` WHERE `rid`=:rid AND `status`!='approved'");
                    $scc->execute([
                      ':rid'=>$rm['id']
                    ]);
                    $sccn=$scc->fetch(PDO::FETCH_ASSOC);?>
                    <a class="btn<?=$sccn['cnt']>0?' add':'';?>" href="<?= URL.$settings['system']['admin'].'/content/edit/'.$rm['id'].'#d43';?>"<?=($sccn['cnt']>0?' data-tooltip="tooltip" aria-label="'.$sccn['cnt'].' New Comments"':'');?> aria-label="View Comments"><?= svg2('comments').'&nbsp;'.$scn['cnt'];?></a>
                    <?=$user['options'][5]==1?'<span class="btn handle" data-tooltip="tooltip" aria-label="Drag to ReOrder this item">'.svg2('drag').'</span>':'';?>
                  </div>
                  <a data-fancybox="media" data-type="image" data-caption="<?=($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?=$rm['file'];?>"><img src="<?=$thumb;?>" alt="Media <?=$rm['id'];?>"></a>
                </div>
              <?php }?>
              <div class="ghost"></div>
            </div>
            <?php if($user['options'][1]==1){?>
              <script>
                $('#mi').sortable({
                  items:"#mi",
                  handle:'.handle',
                  placeholder:".ghost",
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
  <?php /* Tab 4 Social */ ?>
          <div class="tab1-5 border-top p-3" data-tabid="tab1-5" role="tabpanel">
            <?php if($user['options'][0]==1||$user['options'][5]==1){?>
              <form class="form-row p-0" target="sp" method="post" action="core/add_data.php">
                <input name="user" type="hidden" value="<?=$r['id'];?>">
                <input name="act" type="hidden" value="add_social">
                <div class="input-text">Network</div>
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
                <div class="input-text">URL</div>
                <input id="socialurl" name="url" type="text" value="" placeholder="Enter a URL...">
                <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('plus');?></button>
              </form>
            <?php }?>
            <div class="mt-3" id="social">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=:uid ORDER BY `icon` ASC");
              $ss->execute([':uid'=>$r['id']]);
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <form class="form-row" id="l_<?=$rs['id'];?>" target="sp" action="core/purge.php" role="form">
                  <div class="input-text" aria-label="<?= ucfirst($rs['icon']);?>"><?= ucfirst($rs['icon']);?></div>
                  <input type="text" value="<?=$rs['url'];?>" readonly>
                  <?php if($user['options'][0]==1||$user['options'][5]==1){?>
                    <input name="id" type="hidden" value="<?=$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?= svg2('trash');?></button>
                  <?php }?>
                </form>
              <?php }?>
            </div>
          </div>
  <?php /* Tab 6 Messages */ ?>
          <div class="tab1-6 border-top p-3" data-tabid="tab1-6" role="tabpanel">
            <label id="accountEmailSignature" for="email_signature"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountEmailSignature" data-tooltip="tooltip" aria-label="PermaLink to Email Signature">&#128279;</a>':'';?>Email Signature</label>
            <div class="row">
              <?=$user['options'][5]==1?'<form target="sp" method="post" action="core/update.php">'.
                '<input name="id" type="hidden" value="'.$r['id'].'">'.
                '<input name="t" type="hidden" value="login">'.
                '<input name="c" type="hidden" value="email_signature">'.
                '<textarea class="summernote" id="email_signature" name="da">'.rawurldecode($r['email_signature']).'</textarea></form>'
              :
              '<textarea class="field">'.rawurldecode($r['email_signature']).'</textarea>';?>
            </div>
          </div>
  <?php /* Tab 7 Settings */ ?>
          <div class="tab1-7 border-top p-3" data-tabid="tab1-7" role="tabpanel">
            <label id="accountAdminTheme" for="theme"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountAdminTheme" data-tooltip="tooltip" aria-label="PermaLink to Administration Theme Selector">&#128279;</a>':'';?>Administration Theme</label>
            <select id="theme" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="theme"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','theme',$(this).val(),'select');setTheme($(this).val());">
              <option value="">Light</option>
              <option value="dark"<?=$r['theme']=='dark'?' selected':'';?>>Dark</option>
            </select>
            <script>
              function setTheme(theme){
                $('body').attr('data-theme',theme);
                document.cookie='theme=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            		Cookies.set('theme',theme,{expires:14});
              }
            </script>
            <label id="accountTimezone" for="timezone"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountTimezone" data-tooltip="tooltip" aria-label="PermaLink to Timezone Selector">&#128279;</a>':'';?>Timezone</label>
            <select id="timezone" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="timezone"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','timezone',$(this).val(),'select');">
              <option value="default">System Default</option>
              <?php $o=[
                'Australia/Perth'      => "(GMT+08:00) Perth",
                'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
                'Australia/Darwin'     => "(GMT+09:30) Darwin",
                'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
                'Australia/Canberra'   => "(GMT+10:00) Canberra",
                'Australia/Hobart'     => "(GMT+10:00) Hobart",
                'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
                'Australia/Sydney'     => "(GMT+10:00) Sydney"
              ];
              foreach($o as$tz=>$label)echo'<option value="'.$tz.'"'.($tz==$r['timezone']?' selected':'').'>'.$tz.'</option>';?>
              </select>
            <?php if($user['id']==$r['id']||$user['options'][5]==1){?>
              <form target="sp" method="post" action="core/update.php" onsubmit="$('.page-block').addClass('d-block');">
                <label id="accountPassword" for="password"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountPassword" data-tooltip="tooltip" aria-label="PermaLink to Password Field">&#128279;</a>':'';?>Password</label>
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <input name="t" type="hidden" value="login">
                <input name="c" type="hidden" value="password">
                <div class="form-row">
                  <input id="password" name="da" type="password" value="" placeholder="Enter a  New Password..." onkeyup="$('#passButton').addClass('btn-danger');">
                  <button id="passButton" type="submit">Update&nbsp;Password</button>
                </div>
              </form>
            <?php }?>
            <div class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountActive" data-tooltip="tooltip" aria-label="PermaLink to Active Checkbox">&#128279;</a>':'';?>
              <input id="accountActive" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="active" data-dbb="0" type="checkbox"<?=($r['active'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="accountActive" id="loginactive0<?=$r['id'];?>">Active</label>
            </div>
            <label id="accountRank" for="rank"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountRank" data-tooltip="tooltip" aria-label="PermaLink to Rank Selector">&#128279;</a>':'';?>Rank</label>
            <select id="rank" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="rank"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$r['id'];?>','login','rank',$(this).val(),'select');">
              <option value="0"<?=$r['rank']==0?' selected':'';?>>Visitor</option>
              <option value="100"<?=$r['rank']==100?' selected':'';?>>Subscriber</option>
              <option value="200"<?=$r['rank']==200?' selected':'';?>>Member</option>
              <option value="210"<?=$r['rank']==210?' selected':'';?>>Member Silver</option>
              <option value="220"<?=$r['rank']==220?' selected':'';?>>Member Bronze</option>
              <option value="230"<?=$r['rank']==230?' selected':'';?>>Member Gold</option>
              <option value="240"<?=$r['rank']==240?' selected':'';?>>Member Platinum</option>
              <option value="300"<?=$r['rank']==300?' selected':'';?>>Client</option>
              <option value="310"<?=$r['rank']==310?' selected':'';?>>Wholesaler Silver</option>
              <option value="320"<?=$r['rank']==320?' selected':'';?>>Wholesaler Bronze</option>
              <option value="330"<?=$r['rank']==330?' selected':'';?>>Wholesaler Gold</option>
              <option value="340"<?=$r['rank']==340?' selected':'';?>>Wholesaler Platinum</option>
              <option value="400"<?=$r['rank']==400?' selected':'';?>>Contributor</option>
              <option value="500"<?=$r['rank']==500?' selected':'';?>>Author</option>
              <option value="600"<?=$r['rank']==600?' selected':'';?>>Editor</option>
              <option value="700"<?=$r['rank']==700?' selected':'';?>>Moderator</option>
              <option value="800"<?=$r['rank']==800?' selected':'';?>>Manager</option>
              <option value="900"<?=$r['rank']==900?' selected':'';?>>Administrator</option>
              <?=$user['rank']==1000?'<option value="1000"'.($r['rank']==1000?' selected':'').'>Developer</option>':'';?>
            </select>
            <hr>
            <legend>Account Permissions</legend>
            <div class="row mt-3">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountWholesalerAccepted" data-tooltip="tooltip" aria-label="PermaLink to Wholesaler Accepted Checkbox">&#128279;</a>':'';?>
              <input id="accountWholesalerAccepted" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="19" type="checkbox"<?=($r['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="accountWholesalerAccepted0<?=$r['id'];?>" for="accountWholesalerAccepted">Wholesaler Accepted to Purchase</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountForumBanned" data-tooltip="tooltip" aria-label="PermaLink to Forum Banned Checkbox">&#128279;</a>':'';?>
              <input id="accountForumBanned" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="20" type="checkbox"<?=($r['options'][20]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="accountForumBanned" id="loginforumbanned20<?=$r['id'];?>">Banned From Posting or Replying on Forum</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#loginForumHelpResponder" data-tooltip="tooltip" aria-label="PermaLink to Forum Help Responder">&#128279;</a>':'';?>
              <input id="loginForumHelpResponder" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="helpResponder" data-dbb="0" type="checkbox"<?=($r['helpResponder'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginForumHelpResponder0<?=$r['id'];?>" for="loginForumHelpResponder">Forum Help Ticket Responder (Receives Urgent Emails).</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountNewsletterSubscriber" data-tooltip="tooltip" aria-label="PermaLink to Newsletter Subscriber Checkbox">&#128279;</a>':'';?>
              <input id="accountNewsletterSubscriber" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0" type="checkbox"<?=($r['newsletter'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginnewsletter0<?=$r['id'];?>" for="accountNewsletterSubscriber">Newsletter Subscriber</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountAddRemoveContent" data-tooltip="tooltip" aria-label="PermaLink to Add or Remove Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountAddRemoveContent" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0" type="checkbox"<?=($r['options'][0]==1?' checked aria-checked="true"':' aria-checkd="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions0<?=$r['id'];?>" for="accountAddRemoveContent">Add or Remove Content</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountEditContent" data-tooltip="tooltip" aria-label="PermaLink to Edit Content Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountEditContent" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1" type="checkbox"<?=($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions1<?=$r['id'];?>" for="accountEditContent">Edit Content</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountAddEditBookings" data-tooltip="tooltip" aria-label="PermaLink to Add or Edit Bookings Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountAddEditBookings" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2" type="checkbox"<?=($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions2<?=$r['id'];?>" for="accountAddEditBookings">Add or Edit Bookings</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountViewEditMessages" data-tooltip="tooltip" aria-label="PermaLink to Message Viewing or Editing Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountViewEditMessages" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3" type="checkbox"<?=($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions3<?=$r['id'];?>" for="accountViewEditMessages">Messages Viewing or Editing</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountViewEditOrders" data-tooltip="tooltip" aria-label="PermaLink to Add or Orders Viewing or Editing Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountViewEditOrders" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4" type="checkbox"<?=($r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions4<?=$r['id'];?>" for="accountViewEditOrders">Orders Viewing or Editing</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountViewEditAccounts" data-tooltip="tooltip" aria-label="PermaLink to View orEdit Users Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountViewEditAccounts" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="5" type="checkbox"<?=($r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions5<?=$r['id'];?>" for="accountViewEditAccounts">User Accounts Viewing or Editing</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountEditSEO" data-tooltip="tooltip" aria-label="PermaLink to SEO Editing Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountEditSEO" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6" type="checkbox"<?=($r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions6<?=$r['id'];?>" for="accountEditSEO">SEO Editing</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountViewEditPreferences" data-tooltip="tooltip" aria-label="PermaLink to View or Edit Preferences Permissions Checkbox">&#128279;</a>':'';?>
              <input id="accountViewEditPreferences" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7" type="checkbox"<?=($r['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions7<?=$r['id'];?>" for="accountViewEditPreferences">Preferences Viewing or Editing</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountLiveChatNotifications" data-tooltip="tooltip" aria-label="PermaLink to Email LiveChat Notifications Checkbox">&#128279;</a>':'';?>
              <input id="accountLiveChatNotifications" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="liveChatNotification" data-dbb="0" type="checkbox"<?=($r['liveChatNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginliveChatNotification0<?=$r['id'];?>" for="accountLiveChatNotifications">Email LiveChat notifications</label>
            </div>
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/accounts/edit/'.$r['id'].'#accountTrackIP" data-tooltip="tooltip" aria-label="PermaLink to Do Not Track IP Checkbox">&#128279;</a>':'';?>
              <input id="accountTrackIP" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="18" type="checkbox"<?=($r['options'][18]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label id="loginoptions18<?=$r['id'];?>" for="accountTrackIP">Do Not Track IP</label>
            </div>
            <?php if($user['rank']>899){?>
              <?php if($user['rank']==1000||$config['options'][17]==1){?>
              <legend class="mt-3">Media Permissions</legend>
                <div class="row mt-3">
                  <input id="options17" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="17" type="checkbox"<?=($r['options'][17]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions17<?=$r['id'];?>" for="options17">Allow this Administrator to change below Permissions</label>
                </div>
              <?php }
              if($r['options'][17]==1||$user['rank']==1000){?>
                <div class="row">
                  <input id="options16" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="16" type="checkbox"<?=($r['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions16<?=$r['id'];?>" for="options16">Hide Folders</label>
                </div>
                <div class="row">
                  <input id="options10" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="10" type="checkbox"<?=($r['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions10<?=$r['id'];?>" for="options10">Create Folders</label>
                </div>
                <div class="row">
                  <input id="options11" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="11" type="checkbox"<?=($r['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions11<?=$r['id'];?>" for="options11">Read Files</label>
                </div>
                <div class="row">
                  <input id="options12" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="12" type="checkbox"<?=($r['options'][12]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions12<?=$r['id'];?>" for="options12">Write Files</label>
                </div>
                <div class="row">
                  <input id="options13" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="13" type="checkbox"<?=($r['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions13<?=$r['id'];?>" for="options13">Extract Archives</label>
                </div>
                <div class="row">
                  <input id="options14" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="14" type="checkbox"<?=($r['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions14<?=$r['id'];?>" for="options14">Create Archives</label>
                </div>
                <div class="row">
                  <input id="options15" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="15" type="checkbox"<?=($r['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label id="loginoptions15<?=$r['id'];?>" for="options15">Upload Files (pdf,doc,php)</label>
                </div>
              <?php }?>
            </div>
          <?php }?>
<?php if($config['hoster'][0]==1){?>
          <div class="tab1-8 border-top p-3" data-tabid="tab1-8" role="tabpanel">
            <legend>Hosting Payments</legend>
            <div class="row">
              <div class="col-12 col-sm-4 pr-sm-3">
                <label for="hostCost">Hosting Cost</label>
                <div class="form-row">
                  <input class="textinput" id="hostCost" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="hostCost" type="text" value="<?=$r['hostCost'];?>" placeholder="Enter a Cost...">
                  <button class="save" id="savehostCost" data-dbid="hostCost" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
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
                  <button class="save" id="savesiteCost" data-dbid="siteCost" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
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
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
