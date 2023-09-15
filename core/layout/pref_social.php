<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Social
 * @package    core/layout/pref_social.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
            <li class="breadcrumb-item active">Social Networking</li>
          </ol>
        </div>
        <div class="form-row">
          <input id="options9" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="9" type="checkbox"<?=($config['options'][9]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
          <label class="p-0 mt-0 ml-3" for="options9" id="configoptions9">Show RSS Feed Icon</label>
        </div>
        <div class="sticky-top">
          <div class="row">
            <article class="card mb-0 p-0 overflow-visible card-list card-list-header bg-white shadow">
              <div class="row">
                <div class="col-12 col-md-3 align-middle pl-2 py-1">Social Network</div>
                <div class="col-12 col-md-9 align-middle pl-2 py-1">URL</div>
              </div>
            </article>
          </div>
          <?php if($user['options'][7]==1){?>
            <form class="row m-0 p-0" target="sp" method="post" action="core/add_social.php">
              <input name="user" type="hidden" value="0">
              <input name="act" type="hidden" value="add_social">
              <div class="col-12 col-md-3">
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
                  <option value="livejournal">LiveJournal</option>
                  <option value="lynda">Lynda</option>
                  <option value="massroots">Massroots</option>
                  <option value="medium">Medium</option>
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
                </select>
              </div>
              <div class="col-12 col-md-9">
                <div class="form-row">
                  <input id="url" name="url" type="text" value="" placeholder="Enter a URL...">
                  <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                </div>
              </div>
            </form>
          <?php }?>
        </div>
        <div id="social">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='social' AND `uid`=0 ORDER BY `icon` ASC");
          $ss->execute();
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
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
