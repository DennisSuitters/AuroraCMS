<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts - Edit
 * @package    core/layout/edit_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options.
 * @changes    v0.0.2 Add Description for Profiles and Meta-Description data.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.6 Add option to make user receive LiveChat email Notifications.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.11 Add Administrator and Developer setting per user elFinder Media Permissions.
 * @changes    v0.0.11 Update Password change interaction.
 * @changes    v0.0.19 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 * @changes    v0.0.19 Add Save All button.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
*/
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([
  ':id'=>$args[1]
]);
$r=$q->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active"><span id="usersusername"><?php echo$r['username'];?></span>:<span id="usersname"><?php echo$r['name'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" role="button" aria-label="Back"><?php svg('back');?></a>
        <a href="#" class="btn btn-ghost-normal saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields"><?php echo svg('save');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-account-general" class="nav-item" role="presentation"><a class="nav-link active" href="#account-general" aria-controls="account-general" role="tab" data-toggle="tab">General</a></li>
          <li id="nav-account-images" class="nav-item" role="presentation"><a class="nav-link" href="#account-images" aria-controls="account-images" role="tab" data-toggle="tab">Images</a></li>
          <li id="nav-account-proofs" class="nav-item" role="presentation"><a class="nav-link" href="#account-proofs" aria-controls="account-proofs" role="tab" data-toggle="tab">Proofs</a></li>
          <li id="nav-account-social" class="nav-item" role="presentation"><a class="nav-link" href="#account-social" aria-controls="account-social" role="tab" data-toggle="tab">Social</a></li>
          <li id="nav-account-profile" class="nav-item" role="presentation"><a class="nav-link" href="#account-profile" aria-controls="account-social" role="tab" data-toggle="tab">Profile</a></li>
          <li id="nav-account-messages" class="nav-itm" role="presentation"><a class="nav-link" href="#account-messages" aria-controls="account-messages" role="tab" data-toggle="tab">Messages</a></li>
          <li id="nav-account-settings" class="nav-item" role="presentation"><a class="nav-link" href="#account-settings" aria-controls="account-settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
          <div id="account-general" class="tab-pane active" role="tabpanel">
            <div class="row">
              <div class="form-group col-12 col-sm-6">
                <label for="ti">Created</label>
                <div class="input-group">
                  <input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
                </div>
              </div>
              <div class="form-group col-12 col-sm-6">
                <label for="lti">Last Login</label>
                <div class="input-group">
                  <input type="text" id="lti" class="form-control" value="<?php echo _ago($r['lti']);?>" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-12 col-sm-6">
                <label for="username">Username</label>
                <div class="input-group">
                  <input type="text" id="username" class="form-control textinput" value="<?php echo$r['username'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="saveusername" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="username" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
                <div id="uerror" class="alert alert-danger col-sm-10 float-right d-none" role="alert">Username already exists!</div>
              </div>
              <div class="form-group col-12 col-sm-6">
                <label for="email">Email</label>
                <div class="input-group">
                  <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="saveemail" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="email" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <hr>
            <legend role="heading">Orders Information</legend>
            <div class="row">
              <div class="form-group col-12 col-sm-6">
                <label for="spent">Spent</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                  </div>
                  <input type="number" id="spent" class="form-control textinput" value="<?php echo$r['spent'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="spent"<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savespent" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="spent" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-images">
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <div class="form-group">
                <label for="avatar">Avatar</label>
                <div class="input-group">
                  <input type="text" class="form-control" value="<?php echo$r['avatar'];?>" readonly>
                  <div class="input-group-append">
                  <?php echo$user['options'][5]==1?'<input type="hidden" name="id" value="'.$r['id'].'">'.
                    '<input type="hidden" name="act" value="add_avatar">'.
                    '<div class="btn btn-secondary custom-file" data-tooltip="tooltip" data-title="Browse Computer for Files.">'.
                      '<input id="avatarfu" type="file" class="custom-file-input hidden" name="fu" onchange="form.submit()">'.
                      '<label for="avatarfu" aria-label="Browse Computer for Files.">'.svg2('browse-computer').'</label>'.
                    '</div>':'';?>
                    <div class="input-group-text p-0">
                      <img class="img-avatar img-fluid m-0 bg-white" style="border-radius:0" src="<?php if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))echo'media'.DS.'avatar'.DS.basename($r['avatar']);
                      elseif($r['gravatar']!='')echo$r['gravatar'];
                      else echo ADMINNOAVATAR;?>" alt="<?php echo$r['username'];?>">
                    </div>
                    <?php echo$user['options'][5]==1?'<button class="btn btn-secondary trash" onclick="imageUpdate(`'.$r['id'].'`,`login`,`avatar`,``);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>':'';?>
                  </div>
                </div>
              </div>
            </form>
            <div class="form-group">
              <label for="gravatar">Gravatar</label>
              <div class="form-text small text-muted float-right"><a target="_blank" href="http://www.gravatar.com/">Gravatar</a> link will override any image uploaded as your Avatar.</div>
              <div class="input-group">
                <input type="text" id="gravatar" class="form-control textinput" value="<?php echo$r['gravatar'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter a Gravatar Link..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savegravatar" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="gravatar" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
              </div>
            </div>
          </div>
          <div id="account-proofs" class="tab-pane" role="tabpanel">
            <div id="mi" class="row">
              <?php $sm=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='proofs' AND `uid`=:id ORDER BY `ord` ASC");
              $sm->execute([
                ':id'=>$r['id']
              ]);
              while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                if(file_exists('media/thumbs/'.substr(basename($rm['file']),0,-4).'.png'))
                  $thumb='media/thumbs/'.substr(basename($rm['file']),0,-4).'.png';
                else
                  $thumb=ADMINNOIMAGE;?>
                <div id="mi_<?php echo$rm['id'];?>" class="media-gallery d-inline-block col-6 col-sm-2 position-relative p-0 m-1 mt-0">
                  <div class="card bg-dark m-0">
                    <img src="<?php echo$thumb;?>" class="card-img" alt="Proof <?php echo$rm['id'];?>">
                    <div id="card-title<?php echo$rm['id'];?>" class="card-footer"><?php echo$rm['title'];?></div>
                  </div>
                  <div class="controls btn-group">
                    <a class="btn btn-secondary btn-sm" href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$rm['id'];?>"><?php svg('edit');?></a>
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
                    <a class="btn btn-secondary btn-sm<?php echo$sccn['cnt']>0?' btn-success':'';?>" href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$rm['id'].'#d43';?>"<?php echo($sccn['cnt']>0?' data-tooltip="tooltip" data-title="'.$sccn['cnt'].' New Comments"':'');?> aria-label="View Comments"><?php svg('comments').'&nbsp;'.$scn['cnt'];?></a>
                    <?php echo$user['options'][5]==1?'<span class="handle btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="Drag to ReOrder this item" aria-label="Drag to ReOrder this item">'.svg2('drag').'</span>':'';?>
                  </div>
                </div>
              <?php }?>
            </div>
            <?php if($user['options'][1]==1){?>
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
          <div role="tabpanel" class="tab-pane" id="account-social">
            <?php if($user['options'][0]==1||$user['options'][5]==1){?>
              <form target="sp" method="post" action="core/add_data.php">
                <div class="form-group row">
                  <input type="hidden" name="user" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="act" value="add_social">
                  <div class="input-group col-sm-12">
                    <label for="icon" class="input-group-text">Network</label>
                    <select id="icon" class="form-control" name="icon">
                      <option value="">Select a Social Network...</option>
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
                      <option value="discord">Discord</option>
                      <option value="discourse">Discourse</option>
                      <option value="disqus">Disqus</option>
                      <option value="dribbble">Dribbble</option>
                      <option value="dropbox">Dropbox</option>
                      <option value="envato">Envato</option>
                      <option value="etsy">Etsy</option>
                      <option value="facebook">Facebook</option>
                      <option value="feedburner">Feedburner</option>
                      <option value="flickr">Flickr</option>
                      <option value="forrst">Forrst</option>
                      <option value="github">GitHub</option>
                      <option value="gitlab">GitLab</option>
                      <option value="google-plus">Google+</option>
                      <option value="gravatar">Gravatar</option>
                      <option value="hackernews">Hackernews</option>
                      <option value="icq">ICQ</option>
                      <option value="instagram">Instagram</option>
                      <option value="kickstarter">Kickstarter</option>
                      <option value="last-fm">Last FM</option>
                      <option value="lego">Lego</option>
                      <option value="linkedin">Linkedin</option>
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
                      <option value="twitter">Twitter</option>
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
                      <option value="youtube">YouTube</option>
                      <option value="zerply">Zerply</option>
                      <option value="zune">Zune</option>
                    </select>
                    <label for="socialurl" class="input-group-text">URL</label>
                    <input type="text" id="socialurl" class="form-control" name="url" value="" placeholder="Enter a URL...">
                    <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('plus');?></button></div>
                  </div>
                </div>
              </form>
            <?php }?>
            <div id="social">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=:uid ORDER BY `icon` ASC");
              $ss->execute([
                ':uid'=>$r['id']
              ]);
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?php echo$rs['id'];?>" class="form-group row">
                  <div class="input-group col-sm-12">
                    <div class="input-group-text"><span class="libre-social" data-tooltip="tooltip" data-title="<?php echo ucfirst($rs['icon']);?>" aria-label="<?php echo ucfirst($rs['icon']);?>"><?php svg('social-'.$rs['icon']);?></span></div>
                    <input type="text" class="form-control" value="<?php echo$rs['url'];?>" readonly>
                    <?php if($user['options'][0]==1||$user['options'][5]==1){?>
                      <div class="input-group-append">
                        <form target="sp" action="core/purge.php" role="form">
                          <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                          <input type="hidden" name="t" value="choices">
                          <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                        </form>
                      </div>
                    <?php }?>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-profile">
            <ul class="nav nav-tabs" role="tablist">
              <li id="nav-profile-bio" class="nav-item" role="presentation">
                <a class="nav-link active" href="#profile-bio" aria-controls="profile-bio" role="tab" data-toggle="tab">BIO</a>
              </li>
              <li id="nav-profile-career" class="nav-item" role="presentation">
                <a class="nav-link" href="#profile-career" aria-controls="profile-career" role="tab" data-toggle="tab">Career</a>
              </li>
              <li id="nav-profile-edu" class="nav-item" role="presentation">
                <a class="nav-link" href="#profile-edu" aria-controls="profile-edu" role="tab" data-toggle="tab">Education</a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="profile-bio" aria-labelledby="profile-bio">
                <legend role="heading">BIO</legend>
                <div class="form-group">
                  <label>Profile Link</label>
                  <div class="input-group">
                    <a class="form-control" target="_blank" href="<?php echo URL.'profile/'.str_replace(' ','-',$r['name']);?>"><?php echo URL.'profile/'.str_replace(' ','-',$r['name']);?></a>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="0"<?php echo($r['bio_options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                  <label for="bio_options0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable</label>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="1"<?php echo($r['bio_options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                  <label for="bio_options1" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Show Address</label>
                </div>
                <div class="row">
                  <div class="form-group col-12 col-sm-6">
                    <label for="name">Name</label>
                    <div class="input-group">
                      <input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="name" placeholder="Enter a Name..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savename" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="name" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                  <div class="form-group col-12 col-sm-6">
                    <label for="business">Business</label>
                    <div class="input-group">
                      <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="business" placeholder="Enter a Business..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savebusiness" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="business" data-style="zoom-in" role="button" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="url">URL</label>
                  <div class="input-group">
                    <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="url" placeholder="Enter a URL..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                    <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="saveurl" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="url" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-12 col-sm-6">
                    <label for="phone">Phone</label>
                    <div class="input-group">
                      <input type="text" id="phone" class="form-control textinput" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="phone" placeholder="Enter a Phone..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savephone" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="phone" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                  <div class="form-group col-12 col-sm-6">
                    <label for="mobile">Mobile</label>
                    <div class="input-group">
                      <input type="text" id="mobile" class="form-control textinput" value="<?php echo$r['mobile'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="mobile" placeholder="Enter a Mobile..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savemobile" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="mobile" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <div class="input-group">
                    <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="address" placeholder="Enter an Address..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                    <?php echo$user['options'][5]==1?'<div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-12 col-sm-3">
                    <label for="suburb">Suburb</label>
                    <div class="input-group">
                      <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="suburb" placeholder="Enter a Suburb..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savesuburb" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="suburb" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                  <div class="form-group col-12 col-sm-3">
                    <label for="city">City</label>
                    <div class="input-group">
                      <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="city" placeholder="Enter a City..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savecity" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="city" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                  <div class="form-group col-12 col-sm-3">
                    <label for="state">State</label>
                    <div class="input-group">
                      <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="state" placeholder="Enter a State..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savestate" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="state" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                  <div class="form-group col-12 col-sm-3">
                    <label for="postcode">Postcode</label>
                    <div class="input-group">
                      <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="postcode" placeholder="Enter a Postcode..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savepostcode" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="postcode" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="country">Country</label>
                  <div class="input-group">
                    <input type="text" id="country" class="form-control textinput" name="country" value="<?php echo$r['country'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="country" placeholder="Enter a Country..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                    <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savecountry" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="country" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="caption">Caption</label>
                  <div class="input-group">
                    <input type="text" id="caption" class="form-control textinput" name="caption" value="<?php echo$r['caption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="caption" placeholder="Enter a Caption..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                    <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="savecaption" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="caption" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="caption">Description</label>
                  <div class="form-text text-muted small float-right">This is used for the Meta-Description for SEO Purposes on the page</div>
                  <div class="input-group">
                    <input type="text" id="seoDescription" class="form-control textinput" name="seoDescription" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="seoDescription" placeholder="Enter a Description..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                    <?php echo$user['options'][5]==1?'<div class="input-group-append"><button id="saveseoDescription" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="notes">About</label>
                  <div class="card">
                    <div class="card-header p-0">
                      <?php echo$user['options'][5]==1?'<form method="post" target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$r['id'].'"><input type="hidden" name="t" value="login"><input type="hidden" name="c" value="notes"><textarea id="notes" class="form-control summernote" name="da">'.rawurldecode($r['notes']).'</textarea></form>':'<textarea class="form-control" style="background-color:#fff;color:#000;">'.rawurldecode($r['notes']).'</textarea>';?>
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile-career" aria-labelledby="profile-career">
                <legend role="heading">Career</legend>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options2" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="2"<?php echo($r['bio_options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                  <label for="bio_options2" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable</label>
                </div>
                <div class="form-group">
                  <label for="resume_notes">Resume Notes</label>
                  <div class="card">
                    <div class="card-header p-0">
                      <?php echo$user['options'][5]==1?'<form method="post" target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$r['id'].'"><input type="hidden" name="t" value="login"><input type="hidden" name="c" value="resume_notes"><textarea id="resume_notes" class="form-control summernote" name="da">'.rawurldecode($r['resume_notes']).'</textarea></form>':'<textarea class="form-control" style="background-color:#fff;color:#000;">'.rawurldecode($r['resume_notes']).'</textarea>';?>
                    </div>
                  </div>
                </div>
                <?php if($user['options'][5]==1){?>
                  <legend>Add an Entry</legend>
                  <form target="sp" method="post" action="core/add_career.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <div class="form-group row">
                      <div class="col-4">
                        <input type="text" class="form-control" value="" name="title" placeholder="Title..." required aria-required="true" aria-label="Career Title">
                      </div>
                      <div class="col-4">
                        <input type="text" class="form-control" value="" name="business" placeholder="Business..." required aria-required="true" aria-label="Career Business">
                      </div>
                      <div class="col-2">
                        <input type="text" id="ctis" class="form-control" value="" name="tis" placeholder="Date Start..." autocomplete="off">
                        <input type="hidden" id="ctisx" name="tisx" value="0">
                      </div>
                      <div class="col-2">
                        <input type="text" id="ctie" class="form-control" value="" name="tie" placeholder="Date End..." autocomplete="off">
                        <input type="hidden" id="ctiex" name="tiex" value="0">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col">
                        <textarea name="da" class="cnote" required aria-required="true" aria-label="Career Notes"></textarea>
                      </div>
                      <div class="col-1">
                        <button type="submit" class="btn btn-secondary add" aria-label="Add Career" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
                      </div>
                    </div>
                  </form>
                  <script>
                    $('#ctis').daterangepicker({
                      singleDatePicker:true,
                      linkedCalendars:false,
                      autoUpdateInput:false,
                      showDropdowns:true,
                      showCustomRangeLabel:false,
                      timePicker:false,
                      startDate:"<?php echo date($config['dateFormat'],time());?>",
                      locale:{
                        format:'MMM Do,YYYY h:mm A'
                      }
                    },function(start){
                      $('#ctisx').val(start.unix());
                    });
                    $('#ctis').on('apply.daterangepicker',function(start,picker){
                      $('#ctis').val(picker.startDate.format('YYYY-MMM'));
                    });
                    $('#ctie').daterangepicker({
                      singleDatePicker:true,
                      linkedCalendars:false,
                      autoUpdateInput:false,
                      showDropdowns:true,
                      showCustomRangeLabel:false,
                      timePicker:false,
                      startDate:"<?php echo date($config['dateFormat'],time());?>",
                      locale:{
                        format:'MMM Do,YYYY h:mm A'
                      }
                    },function(start){
                      $('#ctiex').val(start.unix());
                    });
                    $('#ctie').on('apply.daterangepicker',function(start,picker){
                      $('#ctie').val(picker.startDate.format('YYYY-MMM'));
                    });
                    $('.cnote').summernote({
                      toolbar:[],
                      placeholder:'Enter Notes...'
                    });
                  </script>
                  <hr>
                <?php }?>
                <div id="careers">
                  <?php $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='career' AND `cid`=:cid ORDER BY `tis` ASC");
                  $sc->execute([
                    ':cid'=>$user['id']
                  ]);
                  while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                    <div id="l_<?php echo$rc['id'];?>">
                      <div class="form-group row">
                        <div class="col-4">
                          <input type="text" class="form-control" value="<?php echo$rc['title'];?>" readonly>
                        </div>
                        <div class="col-4">
                          <input type="text" class="form-control" value="<?php echo$rc['business'];?>" readonly>
                        </div>
                        <div class="col-2">
                          <input type="text" class="form-control" value="<?php echo $rc['tis']==0?'Current':date('Y-M',$rc['tis']);?>" readonly>
                        </div>
                        <div class="col-2">
                          <input type="text" class="form-control" value="<?php echo $rc['tie']==0?'Current':date('Y-M',$rc['tie']);?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col">
                          <div class="form-control"><?php echo$rc['notes'];?></div>
                        </div>
                        <div class="col-1">
                          <?php echo$user['options'][5]==1||$user['options'][0]==1?'<button class="btn btn-secondary trash" onclick="purge(`'.$rc['id'].'`,`content`)" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>':'';?>
                        </div>
                      </div>
                      <hr>
                    </div>
                  <?php }?>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile-edu" aria-labelledby="profile-edu">
                <legend>Education</legend>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options3" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="3"<?php echo($r['bio_options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                  <label for="bio_options3" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable</label>
                </div>
                <?php if($user['options'][5]==1||$user['options'][0]==1){?>
                  <legend>Add an Entry</legend>
                  <form target="sp" method="post" action="core/add_education.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <div class="form-group row">
                      <div class="col-4">
                        <input type="text" class="form-control" value="" name="title" placeholder="Title..." required aria-required="true" aria-label="Title">
                      </div>
                      <div class="col-4">
                        <input type="text" class="form-control" value="" name="business" placeholder="Institute..." required aria-required="true" aria-label="Institute">
                      </div>
                      <div class="col-2">
                        <input type="text" id="etis" class="form-control" value="" name="tis" placeholder="Date Start..." autocomplete="off">
                        <input type="hidden" id="etisx" name="tisx" value="0">
                      </div>
                      <div class="col-2">
                        <input type="text" id="etie" class="form-control" value="" name="tie" placeholder="Date End..." autocomplete="off">
                        <input type="hidden" id="etiex" name="tiex" value="0">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col">
                        <textarea name="da" class="enote" required aria-required="true"></textarea>
                      </div>
                      <div class="col-1">
                        <button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
                      </div>
                    </div>
                  </form>
                  <script>
                    $('#etis').daterangepicker({
                      singleDatePicker:true,
                      linkedCalendars:false,
                      autoUpdateInput:false,
                      showDropdowns:true,
                      showCustomRangeLabel:false,
                      timePicker:false,
                      startDate:"<?php echo date($config['dateFormat'],time());?>",
                      locale:{
                        format:'MMM Do,YYYY h:mm A'
                      }
                    },function(start){
                      $('#etisx').val(start.unix());
                    });
                    $('#etis').on('apply.daterangepicker',function(start,picker){
                      $('#etis').val(picker.startDate.format('YYYY-MMM'));
                    });
                    $('#etie').daterangepicker({
                      singleDatePicker:true,
                      linkedCalendars:false,
                      autoUpdateInput:false,
                      showDropdowns:true,
                      showCustomRangeLabel:false,
                      timePicker:false,
                      startDate:"<?php echo date($config['dateFormat'],time());?>",
                      locale:{
                        format:'MMM Do,YYYY h:mm A'
                      }
                    },function(start){
                      $('#etiex').val(start.unix());
                    });
                    $('#etie').on('apply.daterangepicker',function(start,picker){
                      $('#etie').val(picker.startDate.format('YYYY-MMM'));
                    });
                    $('.enote').summernote({
                      toolbar:[],
                      placeholder:'Enter Notes...'
                    });
                  </script>
                  <hr>
                <?php }?>
                <div id="education">
                  <?php $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='education' AND `cid`=:cid ORDER BY `tis` ASC");
                  $sc->execute([
                    ':cid'=>$user['id']
                  ]);
                  while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                    <div id="l_<?php echo$rc['id'];?>">
                      <div class="form-group row">
                        <div class="col-4">
                          <input type="text" class="form-control" value="<?php echo$rc['title'];?>" readonly>
                        </div>
                        <div class="col-4">
                          <input type="text" class="form-control" value="<?php echo$rc['business'];?>" readonly>
                        </div>
                        <div class="col-2">
                          <input type="text" class="form-control" value="<?php echo $rc['tis']==0?'Current':date('Y-M',$rc['tis']);?>" readonly>
                        </div>
                        <div class="col-2">
                          <input type="text" class="form-control" value="<?php echo $rc['tie']==0?'Current':date('Y-M',$rc['tie']);?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col">
                          <div class="form-control" readonly><?php echo$rc['notes'];?></div>
                        </div>
                        <div class="col-1">
                          <?php echo$user['options'][5]==1||$user['options'][0]==1?'<button class="btn btn-secondary trash" onclick="purge(`'.$rc['id'].'`,`content`)" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>':'';?>
                        </div>
                      </div>
                      <hr>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-messages">
            <div class="form-group">
              <label for="email_signature">Email Signature</label>
              <div class="card">
                <div class="card-header p-0">
                  <?php echo$user['options'][5]==1?'<form method="post" target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$r['id'].'"><input type="hidden" name="t" value="login"><input type="hidden" name="c" value="email_signature"><textarea id="email_signature" class="form-control summernote" name="da">'.rawurldecode($r['email_signature']).'</textarea></form>':'<textarea class="form-control" style="background-color:#fff;color:#000;">'.rawurldecode($r['email_signature']).'</textarea>';?>
                </div>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-settings">
<?php /*            <div class="form-group">
              <label for="theme">Administration Theme</label>
              <select id="theme" class="form-control" onchange="update('<?php echo$r['id'];?>','login','theme',$(this).val());setTheme($(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="theme"<?php echo$user['options'][5]==1?'':' disabled';?>>
                <option value="none">Default</option>
                <option value="scifi"<?php echo$r['theme']=='scifi'?' selected':'';?>>SciFi</option>
              </select>
            </div>
            <script>
              function setTheme(theme){
                $('body').removeClass('scifi');
                $('body').addClass(theme);
                document.cookie = 'theme=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            		Cookies.set('theme',theme,{expires:14});
              }
            </script> */ ?>
            <div class="form-group">
              <label for="timezone">Timezone</label>
              <div class="input-group">
                <select id="timezone" class="form-control" onchange="update('<?php echo$r['id'];?>','login','timezone',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="timezone"<?php echo$user['options'][5]==1?'':' disabled';?>>
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
                  foreach($o as$tz=>$label)echo'<option value="'.$tz.'"'.($tz==$r['timezone']?' selected="selected"':'').'>'.$tz.'</option>';?>
                </select>
              </div>
            </div>
            <?php if($user['id']==$r['id']||$user['options'][5]==1){?>
              <form target="sp" method="post" action="core/update.php" onsubmit="$('.page-block').addClass('d-block');">
                <div class="form-group">
                  <label for="password">Password</label>
                  <div class="input-group">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="t" value="login">
                    <input type="hidden" name="c" value="password">
                    <input type="password" id="password" class="form-control" name="da" value="" placeholder="Enter a  New Password..." onkeyup="$('#passButton').addClass('btn-danger');">
                    <div class="input-group-append"><button id="passButton" type="submit" class="btn btn-secondary">Update Password</button></div>
                  </div>
                </div>
              </form>
            <?php }?>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="active" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="active" data-dbb="0"<?php echo($r['active'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="active" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Active</label>
            </div>
            <div class="form-group">
              <label for="rank">Rank</label>
              <div class="input-group">
                <select id="rank" class="form-control" onchange="update('<?php echo$r['id'];?>','login','rank',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="rank"<?php echo$user['options'][5]==1?'':' disabled';?>>
                  <option value="0"<?php echo($r['rank']==0?' selected':'');?>>Visitor</option>
                  <option value="100"<?php echo($r['rank']==100?' selected':'');?>>Subscriber</option>
                  <option value="200"<?php echo($r['rank']==200?' selected':'');?>>Member</option>
                  <option value="300"<?php echo($r['rank']==300?' selected':'');?>>Client</option>
                  <option value="400"<?php echo($r['rank']==400?' selected':'');?>>Contributor</option>
                  <option value="500"<?php echo($r['rank']==500?' selected':'');?>>Author</option>
                  <option value="600"<?php echo($r['rank']==600?' selected':'');?>>Editor</option>
                  <option value="700"<?php echo($r['rank']==700?' selected':'');?>>Moderator</option>
                  <option value="800"<?php echo($r['rank']==800?' selected':'');?>>Manager</option>
                  <option value="900"<?php echo($r['rank']==900?' selected':'');?>>Administrator</option>
                  <?php echo($user['rank']==1000?'<option value="1000"'.($r['rank']==1000?' selected':'').'>Developer</option>':'');?>
                </select>
              </div>
            </div>
            <hr>
            <legend>Account Permissions</legend>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="newsletter" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0"<?php echo($r['newsletter'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="newsletter" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10" data-tooltip="tooltip" data-title="Toggle Newsletter Subscription.">Newsletter Subscriber</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0"<?php echo($r['options'][0]==1?' checked aria-checked="true"':' aria-checkd="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Add or Remove Content</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1"<?php echo($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options1" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Edit Content</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options2" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2"<?php echo($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options2" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Add or Edit Bookings</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options3" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3"<?php echo($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options3" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Message Viewing or Editing</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options4" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4"<?php echo($r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options4" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Orders Viewing or Editing</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options5" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="5"<?php echo($r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options5" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">User Accounts Viewing or Editing</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options6" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6"<?php echo($r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options6" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">SEO Editing</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options7" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7"<?php echo($r['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options7" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Preferences Viewing or Editing</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success">
                  <input type="checkbox" id="liveChatNotification0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="liveChatNotification" data-dbb="0"<?php echo($r['liveChatNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                </label>
              </div>
              <label for="liveChatNotification0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Email LiveChat notifications</label>
            </div>
            <div class="form-group row">
              <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                <label class="switch switch-label switch-success">
                  <input type="checkbox" id="options8" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="8"<?php echo($r['options'][8]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                </label>
              </div>
              <label for="options8" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">System Utilization Viewing</label>
            </div>
            <?php if($user['rank']>899){?>
              <legend>Media Permissions</legend>
              <?php if($user['rank']==1000){?>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options17" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="17"<?php echo($r['options'][17]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options17" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Allow this Administrator to change below Permissions</label>
                </div>
              <?php }
              if($r['options'][17]==1||$user['rank']==1000){?>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options16" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="16"<?php echo($r['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options16" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Hide Folders</label>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options10" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="10"<?php echo($r['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options10" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Create Folders</label>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options11" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="11"<?php echo($r['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options11" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Read Files</label>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options12" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="12"<?php echo($r['options'][12]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options12" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Write Files</label>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options13" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="13"<?php echo($r['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options13" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Extract Archives</label>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options14" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="14"<?php echo($r['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options14" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Create Archives</label>
                </div>
                <div class="form-group row">
                  <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                    <label class="switch switch-label switch-success">
                      <input type="checkbox" id="options15" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="15"<?php echo($r['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                      <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                    </label>
                  </div>
                  <label for="options15" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Upload Files (pdf,doc,php)</label>
                </div>
              <?php }?>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</main>
