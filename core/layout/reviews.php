<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Reviews
 * @package    core/layout/reviews.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item active">Reviews</li>
          </ol>
        </div>
        <section class="content mt-3 overflow-visible list">
          <article class="card mb-0 p-0 overflow-visible card-list card-list-header shadow sticky-top">
            <div class="row">
              <div class="col-12 col-md-2 align-middle pl-2 py-1">Author</div>
              <div class="col-12 col-md-2 align-middle py-1">Review</div>
              <div class="col-12 col-md-2 align-middle py-1">Rating</div>
              <div class="col-12 col-md-2 align-middle py-1">In Response To</div>
              <div class="col-12 col-md-2 align-middle py-1 text-center">Submitted On</div>
              <div class="col-12 col-md-2"></div>
            </div>
          </article>
          <?php $s=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review'");
          $s->execute();
          $scnt=$s->rowCount();
          while($r=$s->fetch(PDO::FETCH_ASSOC)){
            $sc=$db->prepare("SELECT `id`,`title` FROM `".$prefix."content` WHERE `id`=:id");
            $sc->execute([':id'=>$r['rid']]);
            if($sc->rowCount()>0){
              $rc=$sc->fetch(PDO::FETCH_ASSOC);?>
              <article class="card zebra mt-2 mb-0 p-0 overflow-visible card-list item shadow" id="l_<?=$r['id'];?>">
                <div class="row">
                  <div class="col-12 col-md-2 pt-2 align-top small"><?='<a href="mailto:'.$r['email'].'">'.($r['name']!=''?$r['name']:'Anonymous').'</a>';?></div>
                  <div class="col-12 col-md-2 pt-2 small">
                    <?= strip_tags($r['notes']);?>
                  </div>
                  <div class="col-12 col-md-2 pt-1">
                    <span class="rating small">
                      <span<?=$r['cid']>=1?' class="set"':'';?>></span>
                      <span<?=$r['cid']>=2?' class="set"':'';?>></span>
                      <span<?=$r['cid']>=3?' class="set"':'';?>></span>
                      <span<?=$r['cid']>=4?' class="set"':'';?>></span>
                      <span<?=$r['cid']==5?' class="set"':'';?>></span>
                    </span>
                  </div>
                  <div class="col-12 col-md-2 pt-2 small">
                    <?='<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rc['id'].'#tab1-6">'.$rc['title'].'</a>';?>
                  </div>
                  <div class="col-12 col-md-2 pt-2 text-center small"><?= date($config['dateFormat'],$r['ti']);?></div>
                  <div class="col-12 col-md-2 py-2 pr-2 text-right">
                    <div class="btn-group" id="controls-<?=$r['id'];?>" role="group">
                      <?=($user['options'][0]==1?'<button class="add'.($r['status']=='approved'?' hidden':'').'" id="approve_'.$r['id'].'" onclick="update(`'.$r['id'].'`,`comments`,`status`,`approved`);" data-tooltip="tooltip" aria-label="Approve"><i class="i">approve</i></button>'.
                      '<button class="trash" onclick="purge(`'.$r['id'].'`,`comments`);" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>':'');?>
                    </div>
                  </div>
                </div>
              </article>
            <?php }
          }?>
        </section>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
