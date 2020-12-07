<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Search
 * @package    core/layout/search.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='search';
$search=isset($_POST['s'])?$_POST['s']:'%';?>
<main>
  <section id="content" class="main">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('search','i-3x');?></div>
          <div>Search</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Search</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <form method="post" action="<?php echo URL.$settings['system']['admin'].'/search';?>">
          <div class="form-row">
            <input name="s" type="text" value="<?php echo str_replace('%',' ',$search);?>" placeholder="What are you looking for?">
            <button type="submit">Go</button>
          </div>
        </form>
        <div class="row pl-5">
          <?php $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`login_user`) LIKE LOWER(:search) OR LOWER(`contentType`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`barcode`) LIKE LOWER(:search) OR LOWER(`fccid`) LIKE LOWER(:search) OR LOWER(`code`) LIKE LOWER(:search) OR LOWER(`brand`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`category_1`) LIKE LOWER(:search) OR LOWER(`category_2`) LIKE LOWER(:search) OR LOWER(`category_3`) LIKE LOWER(:search) OR LOWER(`category_4`) LIKE LOWER(:search) OR LOWER(`name`) LIKE LOWER(:search) OR LOWER(`email`) LIKE LOWER(:search) OR LOWER(`business`) LIKE LOWER(:search) OR LOWER(`address`) LIKE LOWER(:search) OR LOWER(`suburb`) LIKE LOWER(:search) OR LOWER(`city`) LIKE LOWER(:search) OR LOWER(`state`) LIKE LOWER(:search) OR LOWER(`postcode`) LIKE LOWER(:search) OR LOWER(`phone`) LIKE LOWER(:search) OR LOWER(`mobile`) LIKE LOWER(:search) OR LOWER(`fileALT`) LIKE LOWER(:search) OR LOWER(`attributionImageTitle`) LIKE LOWER(:search) OR LOWER(`attributionImageName`) LIKE LOWER(:search) OR LOWER(`cost`) LIKE LOWER(:search) OR LOWER(`subject`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) OR LOWER(`attributionContentName`) LIKE LOWER(:search) OR LOWER(`tags`) LIKE LOWER(:search) OR LOWER(`seoTitle`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) ORDER BY `ti` DESC");
          $s->execute([
            ':search'=>'%'.$search.'%'
          ]);
          while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <div class="contentType mt-4" id="google-title" data-contentType="<?php echo$r['contentType'];?>">
              <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?php echo($r['seoTitle']!=''?$r['seoTitle']:$r['title']).' | '.$config['business'];?></a>
            </div>
            <div id="google-link">
              <?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?>
            </div>
            <div id="google-description">
              <?php if($r['seoDescription']!='')
                echo$r['seoDescription'];
              else
                echo$config['seoDescription'];?>
            </div>
          <?php }
          $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE LOWER(`login_user`) LIKE LOWER(:search) OR LOWER(`title`) LIKE LOWER(:search) OR LOWER(`seoTitle`) LIKE LOWER(:search) OR LOWER(`fileALT`) LIKE LOWER(:search) OR LOWER(`attributionImageTitle`) LIKE LOWER(:search) OR LOWER(`attributionImageName`) LIKE LOWER(:search) OR LOWER(`contentType`) LIKE LOWER(:search) OR LOWER(`seoKeywords`) LIKE LOWER(:search) OR LOWER(`seoDescription`) LIKE LOWER(:search) OR LOWER(`seoCaption`) LIKE LOWER(:search) OR LOWER(`notes`) LIKE LOWER(:search) ORDER BY `ord` ASC");
          $s->execute([
            ':search'=>'%'.$search.'%'
          ]);
          while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <div class="contentType mt-4" id="google-title" data-contentType="<?php echo$r['contentType'];?>">
              <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?php echo($r['seoTitle']!=''?$r['seoTitle']:$r['title']).' | '.$config['business'];?></a>
            </div>
            <div id="google-link">
              <?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>
            </div>
            <div id="google-description">
              <?php if($r['seoDescription']!='')
                echo$r['seoDescription'];
              else
                echo$config['seoDescription'];?>
            </div>
          <?php }?>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
