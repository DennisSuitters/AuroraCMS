<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media - Edit
 * @package    core/layout/edit_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."playlist` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 p-4 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Playlist</a></li>
                <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                <li class="breadcrumb-item active"><?=$r['title'];?></li>
              </ol>
            </div>
            <div class="col-12 col-sm-2 text-right">
              <div class="btn-group">
                <?php if(isset($_SERVER['HTTP_REFERER'])){?>
                  <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>
                <?php }?>
                <button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields"><i class="i">save-all</i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-9 order-1 order-md-1 mb-4 mb-md-0">
            <label id="playlistTitle" for="title"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/playlist/edit/'.$r['id'].'#playlistTitle" data-tooltip="tooltip" aria-label="PermaLink to Playlist Title Field">&#128279;</a>':'';?>Title</label>
            <div class="form-row">
              <button data-fancybox data-type="ajax" data-src="core/layout/seohelper.php?t=title" data-tooltip="tooltip" aria-label="SEO Title Information"><i class="i">seo</i></button>
              <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="playlist" data-dbc="title" data-bs="trash" type="text" value="<?=$r['title'];?>"<?=$user['options'][1]==1?' placeholder="Playlist Item Title...."':' readonly';?>>
              <?=$user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
            </div>
            <label id="playlistDateCreated" for="dt"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/playlist/edit/'.$r['id'].'#playlistDateCreated" data-tooltip="tooltip" aria-label="PermaLink to Playlist Date Created Field">&#128279;</a>':'';?>Published&nbsp;Date</label>
            <div class="form-row">
              <input id="dt" type="text" value="<?=$r['dt'];?>" readonly>
            </div>
          </div>
          <div class="col-12 col-sm-3 order-1 order-md-2 mb-4 mb-md-0">
            <div class="card m-3">
              <figure class="card-image">
                <a data-fancybox="playlist" href="<?=$r['thumbnail_url'];?>">
                  <img src="<?=$r['thumbnail_url'];?>" alt="Playlist <?=$r['id'];?>">
                </a>
              </figure>
            </div>
          </div>
        </div>
        <label id="playlistDateCreated" for="ti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/playlist/edit/'.$r['id'].'#playlistDateCreated" data-tooltip="tooltip" aria-label="PermaLink to Playlist Date Created Field">&#128279;</a>':'';?>Created</label>
        <div class="form-row">
          <input id="ti" type="text" value="<?= date($config['dateFormat'],$r['ti']);?>" readonly>
        </div>
        <label id="playlistProviderName" for="provider"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/playlist/edit/'.$r['id'].'#playlistProviderName" data-tooltip="tooltip" aria-label="PermaLink to Playlist Provider Name Field">&#128279;</a>':'';?>Provider&nbsp;Name</label>
        <div class="form-row">
          <input id="provider_name" type="text" value="<?=$r['provider_name'];?>" readonly>
        </div>
        <form target="sp" method="post" action="core/update.php">
          <input type="hidden" name="id" value="<?=$r['id'];?>">
          <input type="hidden" name="t" value="playlist">
          <input type="hidden" name="c" value="notes">
          <div class="wysiwyg-toolbar mt-4">
            <button id="savenotes" data-dbid="notes" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
          </div>
          <div class="form-row">
            <textarea id="notes" style="min-height:200px;" name="da"><?=$r['notes'];?></textarea>
          </div>
        </form>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
