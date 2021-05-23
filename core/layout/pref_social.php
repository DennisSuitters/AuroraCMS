<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Social
 * @package    core/layout/pref_social.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('user-group','i-3x');?></div>
          <div>Preferences - Social</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Social Networking</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="row mt-3">
          <input id="options9" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="9" type="checkbox"<?=$config['options'][9]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options9" id="configoptions9">Show RSS Feed Icon</label>
        </div>
        <form class="row" target="sp" method="post" action="core/add_social.php">
          <input name="user" type="hidden" value="0">
          <div class="col-12 col-md-3">
            <label for="icon">Network</label>
            <div class="form-row">
              <select id="icon" name="icon">
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
          </div>
          <div class="col-12 col-md-8">
            <label for="url">URL</label>
            <div class="form-row">
              <input id="url" name="url" type="text" value="" placeholder="Enter a URL...">
            </div>
          </div>
          <div class="col-12 col-md-1">
            <label>&nbsp;</label>
            <div class="form-row">
              <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
            </div>
          </div>
        </form>
        <div class="mt-3" id="social">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=0 ORDER BY `icon` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div class="row mt-1" id="l_<?=$rs['id'];?>">
              <div class="col-12 col-md-3">
                <div class="form-row">
                  <div class="input-text col-12" data-tooltip="tooltip" aria-label="<?= ucfirst($rs['icon']);?>"><?= svg2('social-'.$rs['icon'],'i-social').'&nbsp;&nbsp'.ucfirst($rs['icon']);?></div>
                </div>
              </div>
              <div class="col-12 col-md-8">
                <div class="form-row">
                  <input type="text" value="<?=$rs['url'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-1">
                <div class="form-row">
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?=$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><?= svg2('trash');?></button>
                  </form>
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
