<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Search
 * @package    core/layout/search.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='search';
$search=isset($_POST['s'])?$_POST['s']:'%';?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item active">Search</li>
          </ol>
        </div>
        <form method="post" action="<?= URL.$settings['system']['admin'].'/search';?>">
          <div class="form-row">
            <input name="s" type="text" value="<?= str_replace('%',' ',$search);?>" placeholder="What are you looking for?">
            <button type="submit"><i class="i">search</i></button>
          </div>
        </form>
        <div class="row pl-5">
          <?php $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`login_user`) LIKE LOWER(:search) OR LOWER(`contentType`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`barcode`) LIKE LOWER(:search) OR LOWER(`fccid`) LIKE LOWER(:search) OR LOWER(`code`) LIKE LOWER(:search) OR LOWER(`brand`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`category_1`) LIKE LOWER(:search) OR LOWER(`category_2`) LIKE LOWER(:search) OR LOWER(`category_3`) LIKE LOWER(:search) OR LOWER(`category_4`) LIKE LOWER(:search) OR LOWER(`name`) LIKE LOWER(:search) OR LOWER(`email`) LIKE LOWER(:search) OR LOWER(`business`) LIKE LOWER(:search) OR LOWER(`address`) LIKE LOWER(:search) OR LOWER(`suburb`) LIKE LOWER(:search) OR LOWER(`city`) LIKE LOWER(:search) OR LOWER(`state`) LIKE LOWER(:search) OR LOWER(`postcode`) LIKE LOWER(:search) OR LOWER(`phone`) LIKE LOWER(:search) OR LOWER(`mobile`) LIKE LOWER(:search) OR LOWER(`fileALT`) LIKE LOWER(:search) OR LOWER(`attributionImageTitle`) LIKE LOWER(:search) OR LOWER(`attributionImageName`) LIKE LOWER(:search) OR LOWER(`cost`) LIKE LOWER(:search) OR LOWER(`subject`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) OR LOWER(`attributionContentName`) LIKE LOWER(:search) OR LOWER(`tags`) LIKE LOWER(:search) OR LOWER(`seoTitle`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) ORDER BY `ti` DESC");
          $s->execute([':search'=>'%'.$search.'%']);
          while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <div class="contentType mt-4" id="google-title" data-contentType="<?=$r['contentType'];?>">
              <a href="<?= URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?=($r['seoTitle']!=''?$r['seoTitle']:$r['title']).' | '.$config['business'];?></a>
            </div>
            <div id="google-link">
              <?= URL.$r['contentType'].'/'.$r['urlSlug'];?>
            </div>
            <div id="google-description">
              <?=$r['seoDescription']!=''?$r['seoDescription']:$config['seoDescription'];?>
            </div>
          <?php }
          $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE LOWER(`login_user`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`seoTitle`) LIKE LOWER(:search) OR LOWER(`fileALT`) LIKE LOWER(:search) OR LOWER(`attributionImageTitle`) LIKE LOWER(:search) OR LOWER(`attributionImageName`) LIKE LOWER(:search) OR LOWER(`contentType`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) ORDER BY `ord` ASC");
          $s->execute([':search'=>'%'.$search.'%']);
          while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <div class="contentType mt-4" id="google-title" data-contentType="<?=$r['contentType'];?>">
              <a href="<?= URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?=($r['seoTitle']!=''?$r['seoTitle']:$r['title']).' | '.$config['business'];?></a>
            </div>
            <div id="google-link">
              <?= URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>
            </div>
            <div id="google-description">
              <?=$r['seoDescription']!=''?$r['seoDescription']:$config['seoDescription'];?>
            </div>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
