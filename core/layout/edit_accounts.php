<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts - Edit
 * @package    core/layout/edit_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([
  ':id'=>$args[1]
]);
$r=$q->fetch(PDO::FETCH_ASSOC);?>
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
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
          <li class="breadcrumb-item active">Edit</li>
          <li class="breadcrumb-item active"><span id="usersusername"><?php echo$r['username'];?></span>:<span id="usersname"><?php echo$r['name'];?></span></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Images</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Proofs</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Social</label>
          <input class="tab-control" id="tab1-5" name="tabs" type="radio">
          <label for="tab1-5">Profile</label>
          <input class="tab-control" id="tab1-6" name="tabs" type="radio">
          <label for="tab1-6">Messages</label>
          <input class="tab-control" id="tab1-7" name="tabs" type="radio">
          <label for="tab1-7">Settings</label>
<?php /* Tab 1 General */?>
          <div class="tab1-1 border-top p-3" role="tabpanel">
            <?php echo$user['rank']==1000?'<div class="row">'.
              '<div class="col-12">'.
                '<div class="form-text text-muted">'.
                  '<small>IP: '.$r['userIP'].' | '.$r['userAgent'].'</small>'.
                '</div>'.
              '</div>'.
            '</div>':'';?>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="ti">Created</label>
                <div class="form-row">
                  <input id="ti" type="text" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <label for="lti">Last Login</label>
                <div class="form-row">
                  <input id="lti" type="text" value="<?php echo _ago($r['lti']);?>" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-2">
                <label for="username">Username</label>
                <div class="form-row">
                  <input class="textinput" id="username" type="text" value="<?php echo$r['username'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<button class="save" id="saveusername" data-tooltip="tooltip" data-dbid="username" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-2">
                <div class="alert alert-danger d-none" id="uerror" role="alert">Username already exists!</div>
                <label for="email">Email</label>
                <div class="form-row">
                  <input class="textinput" id="email" type="text" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<button class="save" id="saveemail" data-tooltip="tooltip" data-dbid="email" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
              </div>
            </div>
            <hr>
            <legend role="heading">Orders Information</legend>
            <label for="spent">Spent</label>
            <div class="form-row">
              <div class="input-text">$</div>
              <input class="textinput" id="spent" type="number" value="<?php echo$r['spent'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="spent"<?php echo$user['options'][5]==1?'':' readonly';?>>
              <?php echo$user['options'][5]==1?'<button class="save" id="savespent" data-tooltip="tooltip" data-dbid="spent" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
<?php /* Tab 2 Images */ ?>
          <div class="tab1-2 border-top p-3" role="tabpanel">
            <label for="avatar">Avatar</label>
            <form class="form-row p-0" target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <input type="text" value="<?php echo$r['avatar'];?>" readonly>
              <?php if($user['options'][5]==1){?>
                <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                <input name="act" type="hidden" value="add_avatar">
                <div class="btn">
                  <label for="avatarfu" data-tooltip="tooltip" aria-label="Browse Computer for Files."><?php svg('browse-computer');?>
                    <input class="hidden" id="avatarfu" name="fu" type="file" onchange="form.submit();">
                  </label>
                </div>
              <?php }?>
              <img class="img-avatar" style="border-radius:0" src="<?php if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))echo'media'.DS.'avatar'.DS.basename($r['avatar']);
              elseif($r['gravatar']!='')echo$r['gravatar'];
              else echo ADMINNOAVATAR;?>" alt="<?php echo$r['username'];?>">
              <?php echo$user['options'][5]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="imageUpdate(`'.$r['id'].'`,`login`,`avatar`,``);">'.svg2('trash').'</button>':'';?>
            </form>
            <div class="form-row mt-3">
              <label for="gravatar">Gravatar</label>
              <div class="form-text text-right"><a target="_blank" href="http://www.gravatar.com/">Gravatar</a> link will override any image uploaded as your Avatar.</div>
            </div>
            <div class="form-row">
              <input class="textinput" id="gravatar" type="text" value="<?php echo$r['gravatar'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter a Gravatar Link..."<?php echo$user['options'][5]==1?'':' readonly';?>>
              <?php echo$user['options'][5]==1?'<button class="save" id="savegravatar" data-tooltip="tooltip" data-dbid="gravatar" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
<?php /* Tab 3 Proofs */ ?>
          <div class="tab1-3 border-top p-3" role="tabpanel">
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
                <div class="card stats col-6 col-md-3 m-1" id="mi_<?php echo$rm['id'];?>">
                  <div class="btn-group float-right">
                    <a class="btn" href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$rm['id'];?>"><?php svg('edit');?></a>
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
                    <a class="btn<?php echo$sccn['cnt']>0?' add':'';?>" href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$rm['id'].'#d43';?>"<?php echo($sccn['cnt']>0?' data-tooltip="tooltip" aria-label="'.$sccn['cnt'].' New Comments"':'');?> aria-label="View Comments"><?php svg('comments').'&nbsp;'.$scn['cnt'];?></a>
                    <?php echo$user['options'][5]==1?'<span class="btn handle" data-tooltip="tooltip" aria-label="Drag to ReOrder this item">'.svg2('drag').'</span>':'';?>
                  </div>
                  <a data-fancybox="media" data-type="image" data-caption="<?php echo($rm['title']!=''?'Using Media Title: '.$rm['title']:'Using Content Title: '.$r['title']).($rm['fileALT']!=''?'<br>ALT: '.$rm['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>');?>" href="<?php echo$rm['file'];?>">
                    <img src="<?php echo$thumb;?>" alt="Media <?php echo$rm['id'];?>">
                  </a>
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
          <div class="tab1-4 border-top p-3" role="tabpanel">
            <?php if($user['options'][0]==1||$user['options'][5]==1){?>
              <form class="form-row p-0" target="sp" method="post" action="core/add_data.php">
                <input name="user" type="hidden" value="<?php echo$r['id'];?>">
                <input name="act" type="hidden" value="add_social">
                <div class="input-text">Network</div>
                <select name="icon">
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
                <div class="input-text">URL</div>
                <input id="socialurl" name="url" type="text" value="" placeholder="Enter a URL...">
                <button class="add" data-tooltip="tooltip" aria-label="Add"><?php svg('plus');?></button>
              </form>
            <?php }?>
            <div class="mt-3" id="social">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=:uid ORDER BY `icon` ASC");
              $ss->execute([
                ':uid'=>$r['id']
              ]);
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <form class="form-row" id="l_<?php echo$rs['id'];?>" target="sp" action="core/purge.php" role="form">
                  <div class="input-text" aria-label="<?php echo ucfirst($rs['icon']);?>"><?php echo ucfirst($rs['icon']);?></div>
                  <input type="text" value="<?php echo$rs['url'];?>" readonly>
                  <?php if($user['options'][0]==1||$user['options'][5]==1){?>
                    <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
                  <?php }?>
                </form>
              <?php }?>
            </div>
          </div>
  <?php /* Tab 5 Profile */ ?>
          <div class="tab1-5 border-top p-3" role="tabpanel">
            <div class="tabs2" role="tablist">
              <input class="tab2-control" id="tab2-1" name="tabs2" type="radio" checked>
              <label for="tab2-1">BIO</label>
              <input class="tab2-control" id="tab2-2" name="tabs2" type="radio">
              <label for="tab2-2">Career</label>
              <input class="tab2-control" id="tab2-3" name="tabs2" type="radio">
              <label for="tab2-3">Education</label>
              <div class="tab2-1 border-top p-3" role="tabpanel">
                <legend role="heading">BIO</legend>
                <label>Profile Link</label>
                <div class="form-row">
                  <div class="input-text col-12">
                    <a target="_blank" href="<?php echo URL.'profile/'.str_replace(' ','-',$r['name']);?>"><?php echo URL.'profile/'.str_replace(' ','-',$r['name']);?></a>
                  </div>
                </div>
                <div class="row mt-3">
                  <input id="bio_options0" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="0" type="checkbox"<?php echo($r['bio_options'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="bio_options0">Enable</label>
                </div>
                <div class="row">
                  <input id="bio_options1" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="1" type="checkbox"<?php echo($r['bio_options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="bio_options1">Show Address</label>
                </div>
                <div class="row">
                  <div class="col-12 col-md-6 pr-md-2">
                    <label for="name">Name</label>
                    <div class="form-row">
                      <input class="textinput" id="name" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="name" type="text" value="<?php echo$r['name'];?>" placeholder="Enter a Name..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savename" data-tooltip="tooltip" data-dbid="name" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 pl-md-2">
                    <label for="business">Business</label>
                    <div class="form-row">
                      <input class="textinput" id="business" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="business" type="text" value="<?php echo$r['business'];?>" placeholder="Enter a Business..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savebusiness" data-tooltip="tooltip" data-dbid="business" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                </div>
                <label for="url">URL</label>
                <div class="form-row">
                  <input class="textinput" id="url" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="url" type="text" value="<?php echo$r['url'];?>" placeholder="Enter a URL..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<button class="save" id="saveurl" data-tooltip="tooltip" data-dbid="url" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
                <div class="row">
                  <div class="col-12 col-md-6 pr-md-2">
                    <label for="phone">Phone</label>
                    <div class="form-row">
                      <input class="textinput" id="phone" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="phone" type="text" value="<?php echo$r['phone'];?>" placeholder="Enter a Phone..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savephone" data-tooltip="tooltip" data-dbid="phone" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 pl-md-2">
                    <label for="mobile">Mobile</label>
                    <div class="form-row">
                      <input class="textinput" id="mobile" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="mobile" type="text" value="<?php echo$r['mobile'];?>" placeholder="Enter a Mobile..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savemobile" data-tooltip="tooltip" data-dbid="mobile" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-6 pr-md-2">
                    <label for="address">Address</label>
                    <div class="form-row">
                      <input class="textinput" id="address" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="address" type="text" value="<?php echo$r['address'];?>" placeholder="Enter an Address..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="saveaddress" data-tooltip="tooltip" data-dbid="address" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 pl-md-2">
                    <label for="suburb">Suburb</label>
                    <div class="form-row">
                      <input class="textinput" id="suburb" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="suburb" type="text" value="<?php echo$r['suburb'];?>" placeholder="Enter a Suburb..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savesuburb" data-tooltip="tooltip" data-dbid="suburb" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-6 pr-md-2">
                    <label for="city">City</label>
                    <div class="form-row">
                      <input class="textinput" id="city" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="city" type="text" value="<?php echo$r['city'];?>" placeholder="Enter a City..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savecity" data-tooltip="tooltip" data-dbid="city" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 pl-md-2">
                    <label for="state">State</label>
                    <div class="form-row">
                      <input class="textinput" id="state" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="state" type="text" value="<?php echo$r['state'];?>" placeholder="Enter a State..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savestate" data-tooltip="tooltip" data-dbid="state" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-6 pr-md-2">
                    <label for="postcode">Postcode</label>
                    <div class="form-row">
                      <input class="textinput" id="postcode" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="postcode" type="text" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>" placeholder="Enter a Postcode..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savepostcode" data-tooltip="tooltip" data-dbid="postcode" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 pl-md-2">
                    <label for="country">Country</label>
                    <div class="form-row">
                      <input class="textinput" id="country" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="country" type="text" value="<?php echo$r['country'];?>" placeholder="Enter a Country..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                      <?php echo$user['options'][5]==1?'<button class="save" id="savecountry" data-tooltip="tooltip" data-dbid="country" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                    </div>
                  </div>
                </div>
                <label for="caption">Caption</label>
                <div class="form-row">
                  <input class="textinput" id="caption" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="caption" type="text" value="<?php echo$r['caption'];?>" placeholder="Enter a Caption..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<button class="save" id="savecaption" data-tooltip="tooltip" data-dbid="caption" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
                <div class="form-row mt-3">
                  <label for="caption">Description</label>
                  <div class="form-text text-right">This is used for the Meta-Description for SEO Purposes on the page</div>
                </div>
                <div class="form-row">
                  <input class="textinput" id="seoDescription" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="seoDescription" type="text" value="<?php echo$r['seoDescription'];?>" placeholder="Enter a Description..."<?php echo$user['options'][5]==1?'':' readonly';?>>
                  <?php echo$user['options'][5]==1?'<button class="save" id="saveseoDescription" data-tooltip="tooltip" data-dbid="seoDescription" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>':'';?>
                </div>
                <label for="notes">About</label>
                <div class="row">
                  <?php echo$user['options'][5]==1 ?
                  '<form class="p-0" target="sp" method="post" action="core/update.php">'.
                    '<input name="id" type="hidden" value="'.$r['id'].'">'.
                    '<input name="t" type="hidden" value="login">'.
                    '<input name="c" type="hidden" value="notes">'.
                    '<textarea class="summernote" id="notes" name="da">'.rawurldecode($r['notes']).'</textarea>'.
                  '</form>'
                  :
                    '<textarea style="background-color:#fff;color:#000;">'.rawurldecode($r['notes']).'</textarea>';?>
                </div>
              </div>
              <div class="tab2-2 border-top p-3" role="tabpanel">
                <legend role="heading">Career</legend>
                <div class="row mt-3">
                  <input id="bio_options2" type="checkbox" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="2"<?php echo($r['bio_options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="bio_options2">Enable</label>
                </div>
                <label for="resume_notes">Resume Notes</label>
                <div class="row">
                  <?php echo$user['options'][5]==1 ?
                    '<form class="p-0" target="sp" method="post" action="core/update.php">'.
                      '<input name="id" type="hidden" value="'.$r['id'].'">'.
                      '<input name="t" type="hidden" value="login">'.
                      '<input name="c" type="hidden" value="resume_notes">'.
                      '<textarea class="summernote" id="resume_notes" name="da">'.rawurldecode($r['resume_notes']).'</textarea>'.
                    '</form>'
                    :
                    '<textarea style="background-color:#fff;color:#000;">'.rawurldecode($r['resume_notes']).'</textarea>';?>
                </div>
                <?php if($user['options'][5]==1){?>
                  <hr>
                  <legend>Add an Entry</legend>
                  <form target="sp" method="post" action="core/add_career.php">
                    <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                    <div class="row">
                      <div class="col-12 col-md-3 pr-md-1">
                        <label for="career-title">Career Title</label>
                        <div class="form-row">
                          <input id="career-title" name="title" type="text" value="" placeholder="Title..." required aria-required="true" aria-label="Career Title">
                        </div>
                      </div>
                      <div class="col-12 col-md-3 pr-md-1">
                        <label for="career-business">Career Business</label>
                        <div class="form-row">
                          <input id="career-business" name="business" type="text" value="" placeholder="Business..." required aria-required="true" aria-label="Career Business">
                        </div>
                      </div>
                      <div class="col-12 col-md-3 pr-md-1">
                        <label for="ctis">Start Date</label>
                        <div class="form-row">
                          <input id="ctis" name="tis" type="date" value="" placeholder="Date Start..." autocomplete="off" aria-label="Start Date" onchange="$('#ctisx').val(getTimestamp('ctis'));">
                          <input id="ctisx" name="tisx" type="hidden" value="0">
                        </div>
                      </div>
                      <div class="col-12 col-md-3">
                        <label for="ctie">End Date</label>
                        <div class="form-row">
                          <input id="ctie" name="tie" type="date" value="" placeholder="Date End..." autocomplete="off" aria-label="End Date" onchange="$('#ctiex').val(getTimestamp('ctie'));">
                          <input id="ctiex" name="tiex" type="hidden" value="0">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <label for="career-notes">Career Notes</label>
                      <div class="col-12 col-md-11">
                        <textarea id="career-notes" name="da" required aria-required="true" aria-label="Career Notes"></textarea>
                      </div>
                      <div class="col-12 col-md-1">
                        <button class="btn-block add" data-tooltip="tooltip" type="submit" aria-label="Add Career"><?php svg('add');?></button>
                      </div>
                    </div>
                  </form>
                  <script>
                    $('#career-notes').summernote({
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
                      <div  class="row">
                        <div class="col-12 col-md-3 pr-md-1">
                          <label>Career Title</label>
                          <div class="form-row">
                            <div class="form-text"><?php echo$rc['title'];?></div>
                          </div>
                        </div>
                        <div class="col-12 col-md-3 pr-md-1">
                          <label>Career Business</label>
                          <div class="form-row">
                            <div class="form-text"><?php echo$rc['business'];?></div>
                          </div>
                        </div>
                        <div class="col-12 col-md-3 pr-md-1">
                          <label>Start Date</label>
                          <div class="form-row">
                            <div class="form-text"><?php echo $rc['tis']==0?'Current':date('Y-M',$rc['tis']);?></div>
                          </div>
                        </div>
                        <div class="col-12 col-md-3">
                          <label>End Date</label>
                          <div class="form-row">
                            <div class="form-text"><?php echo $rc['tie']==0?'Current':date('Y-M',$rc['tie']);?></div>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <label>Career Notes</label>
                        <div class="col-12 col-md-11">
                          <div class="form-row">
                            <div class="form-text"><?php echo$rc['notes'];?></div>
                          </div>
                        </div>
                        <div class="col-12 col-md-1">
                          <?php echo$user['options'][5]==1||$user['options'][0]==1?'<button class="btn-block trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$rc['id'].'`,`content`);">'.svg2('trash').'</button>':'';?>
                        </div>
                      </div>
                      <hr>
                    </div>
                  <?php }?>
                </div>
              </div>
              <div class="tab2-3 border-top p-3" role="tabpanel">
                <legend>Education</legend>
                <div class="row mt-3">
                  <input id="bio_options3" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="3" type="checkbox"<?php echo($r['bio_options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="bio_options3">Enable</label>
                </div>
                <?php if($user['options'][5]==1||$user['options'][0]==1){?>
                  <hr>
                  <legend>Add an Entry</legend>
                  <form target="sp" method="post" action="core/add_education.php">
                    <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                    <div class="row">
                      <div class="col-12 col-md-3 pr-md-1">
                        <label for="edutitle">Title</label>
                        <div class="form-row">
                          <input id="edutitle" name="title" type="text" value="" placeholder="Title..." required aria-required="true" aria-label="Title">
                        </div>
                      </div>
                      <div class="col-12 col-md-3 pr-md-1">
                        <label for="eduinst">Institution</label>
                        <div class="form-row">
                          <input id="eduinst" name="business" type="text" value="" placeholder="Institute..." required aria-required="true" aria-label="Institute">
                        </div>
                      </div>
                      <div class="col-12 col-md-3 pr-md-1">
                        <label for="etis">Start Date</label>
                        <div class="form-row">
                          <input id="etis" name="tis" type="date" value="" placeholder="Date Start..." autocomplete="off" onchange="$('#etisx').val(getTimestamp('etis'));">
                          <input id="etisx" name="tisx" type="hidden" value="0">
                        </div>
                      </div>
                      <div class="col-12 col-md-3">
                        <label for="etie">End Date</label>
                        <div class="form-row">
                          <input id="etie" name="tie" type="date" value="" placeholder="Date End..." autocomplete="off" onchange="$('#etiex').val(getTimestamp('etis'));">
                          <input id="etiex" name="tiex" type="hidden" value="0">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <label for="edu-notes">Education Notes</label>
                      <div class="col-12 col-md-11">
                        <textarea id="edu-notes" name="da" required aria-required="true"></textarea>
                      </div>
                      <div class="col-12 col-md-1">
                        <button class="btn-block add" data-tooltip="tooltip" type="submit" aria-label="Add"><?php svg('add');?></button>
                      </div>
                    </div>
                  </form>
                  <script>
                    $('#edu-notes').summernote({
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
                      <div class="row">
                        <div class="col-12 col-md-3 pr-md-1">
                          <label>Education Title</label>
                          <div class="form-row">
                            <div class="form-text">
                              <?php echo$rc['title'];?>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-3 pr-md-1">
                          <label>Institution</label>
                          <div class="form-row">
                            <div class="form-text">
                              <?php echo$rc['business'];?>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-3 pr-md-1">
                          <label>Start Date</label>
                          <div class="form-row">
                            <div class="form-text">
                              <?php echo $rc['tis']==0?'Current':date('Y-M',$rc['tis']);?>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-3">
                          <label>End Date</label>
                          <div class="form-row">
                            <div class="form-text">
                              <?php echo $rc['tie']==0?'Current':date('Y-M',$rc['tie']);?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <label>Education Notes</label>
                        <div class="col-12 col-md-11">
                          <div class="form-row">
                            <div class="form-text"><?php echo$rc['notes'];?></div>
                          </div>
                        </div>
                        <div class="col-12 col-md-1">
                          <?php echo$user['options'][5]==1||$user['options'][0]==1?'<button class="btn-block trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$rc['id'].'`,`content`);">'.svg2('trash').'</button>':'';?>
                        </div>
                        <hr>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>
  <?php /* Tab 6 Messages */ ?>
          <div class="tab1-6 border-top p-3" role="tabpanel">
            <label for="email_signature">Email Signature</label>
            <div class="row">
              <?php echo$user['options'][5]==1?'<form target="sp" method="post" action="core/update.php">'.
                '<input name="id" type="hidden" value="'.$r['id'].'">'.
                '<input name="t" type="hidden" value="login">'.
                '<input name="c" type="hidden" value="email_signature">'.
                '<textarea class="summernote" id="email_signature" name="da">'.rawurldecode($r['email_signature']).'</textarea></form>'
              :
                '<textarea style="background-color:#fff;color:#000;">'.rawurldecode($r['email_signature']).'</textarea>';?>
            </div>
          </div>
  <?php /* Tab 7 Settings */ ?>
          <div class="tab1-7 border-top p-3" role="tabpanel">
            <label for="theme">Administration Theme</label>
            <div class="form-row">
              <select id="theme" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="theme"<?php echo$user['options'][5]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','login','theme',$(this).val());setTheme($(this).val());">
                <option value="none">Light</option>
                <option value="dark"<?php echo$r['theme']=='dark'?' selected':'';?>>Dark</option>
              </select>
            </div>
            <script>
              function setTheme(theme){
                $('body').removeClass('dark');
                $('body').addClass(theme);
                document.cookie = 'theme=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            		Cookies.set('theme',theme,{expires:14});
              }
            </script>
            <label for="timezone">Timezone</label>
            <div class="form-row">
              <select id="timezone" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="timezone"<?php echo$user['options'][5]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','login','timezone',$(this).val());">
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
            <?php if($user['id']==$r['id']||$user['options'][5]==1){?>
              <form target="sp" method="post" action="core/update.php" onsubmit="$('.page-block').addClass('d-block');">
                <label for="password">Password</label>
                <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                <input name="t" type="hidden" value="login">
                <input name="c" type="hidden" value="password">
                <div class="form-row">
                  <input id="password" name="da" type="password" value="" placeholder="Enter a  New Password..." onkeyup="$('#passButton').addClass('btn-danger');">
                  <button id="passButton" type="submit">Update&nbsp;Password</button>
                </div>
              </form>
            <?php }?>
            <div class="row mt-3">
              <input id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="active" data-dbb="0" type="checkbox"<?php echo($r['active'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="active">Active</label>
            </div>
            <label for="rank">Rank</label>
            <div class="form-row">
              <select id="rank" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="rank"<?php echo$user['options'][5]==1?'':' disabled';?> onchange="update('<?php echo$r['id'];?>','login','rank',$(this).val());">
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
            <hr>
            <legend>Account Permissions</legend>
            <div class="row mt-3">
              <input id="newsletter" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0" type="checkbox"<?php echo($r['newsletter'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="newsletter">Newsletter Subscriber</label>
            </div>
            <div class="row">
              <input id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0" type="checkbox"<?php echo($r['options'][0]==1?' checked aria-checked="true"':' aria-checkd="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options0">Add or Remove Content</label>
            </div>
            <div class="row">
              <input id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1" type="checkbox"<?php echo($r['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options1">Edit Content</label>
            </div>
            <div class="row">
              <input id="options2" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2" type="checkbox"<?php echo($r['options'][2]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options2">Add or Edit Bookings</label>
            </div>
            <div class="row">
              <input id="options3" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3" type="checkbox"<?php echo($r['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options3">Message Viewing or Editing</label>
            </div>
            <div class="row">
              <input id="options4" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4" type="checkbox"<?php echo($r['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options4">Orders Viewing or Editing</label>
            </div>
            <div class="row">
              <input id="options5" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="5" type="checkbox"<?php echo($r['options'][5]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options5">User Accounts Viewing or Editing</label>
            </div>
            <div class="row">
              <input id="options6" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6" type="checkbox"<?php echo($r['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options6">SEO Editing</label>
            </div>
            <div class="row">
              <input id="options7" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7" type="checkbox"<?php echo($r['options'][7]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options7">Preferences Viewing or Editing</label>
            </div>
            <div class="row">
              <input id="liveChatNotification0" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="liveChatNotification" data-dbb="0" type="checkbox"<?php echo($r['liveChatNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="liveChatNotification0">Email LiveChat notifications</label>
            </div>
            <div class="row">
              <input id="options8" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="8" type="checkbox"<?php echo($r['options'][8]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
              <label for="options8">System Utilization Viewing</label>
            </div>
            <?php if($user['rank']>899){?>
              <legend class="mt-3">Media Permissions</legend>
              <?php if($user['rank']==1000){?>
                <div class="row mt-3">
                  <input id="options17" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="17" type="checkbox"<?php echo($r['options'][17]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options17">Allow this Administrator to change below Permissions</label>
                </div>
              <?php }
              if($r['options'][17]==1||$user['rank']==1000){?>
                <div class="row">
                  <input id="options16" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="16" type="checkbox"<?php echo($r['options'][16]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options16">Hide Folders</label>
                </div>
                <div class="row">
                  <input id="options10" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="10" type="checkbox"<?php echo($r['options'][10]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options10">Create Folders</label>
                </div>
                <div class="row">
                  <input id="options11" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="11" type="checkbox"<?php echo($r['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options11">Read Files</label>
                </div>
                <div class="row">
                  <input id="options12" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="12" type="checkbox"<?php echo($r['options'][12]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options12">Write Files</label>
                </div>
                <div class="row">
                  <input id="options13" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="13" type="checkbox"<?php echo($r['options'][13]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options13">Extract Archives</label>
                </div>
                <div class="row">
                  <input id="options14" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="14" type="checkbox"<?php echo($r['options'][14]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options14">Create Archives</label>
                </div>
                <div class="row">
                  <input id="options15" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="15" type="checkbox"<?php echo($r['options'][15]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options15">Upload Files (pdf,doc,php)</label>
                </div>
              <?php }?>
            </div>
          <?php }?>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
