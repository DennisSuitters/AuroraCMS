<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Comments
 * @package    core/layout/comments.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item active">Comments</li>
          </ol>
        </div>
        <section class="content overflow-visible list">
          <article class="card mb-0 p-0 py-2 overflow-visible card-list card-list-header shadow sticky-top">
            <div class="row">
              <div class="col-12 col-md-2 align-middle pl-2">Author</div>
              <div class="col-12 col-md-4 align-middle">Comment</div>
              <div class="col-12 col-md-2 align-middle">In Response To</div>
              <div class="col-12 col-md-2 align-middle text-center">Submitted On</div>
              <div class="col-12 col-md align-middle"></div>
            </div>
          </article>
          <?php $s=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='article' AND `status`='unapproved'");
          $s->execute();
          while($r=$s->fetch(PDO::FETCH_ASSOC)){
            $su=$db->prepare("SELECT `id`,`username`,`name`,`rank` FROM `".$prefix."login` WHERE `id`=:uid");
            $su->execute([':uid'=>$r['uid']]);?>
            <article class="card zebra mb-0 p-0 py-2 overflow-visible card-list item shadow" id="l_<?=$r['id'];?>">
              <div class="row">
                <div class="col-12 col-md-2 pl-2 align-top small">
                  <?php if($su->rowCount()==1){
                    $ru=$su->fetch(PDO::FETCH_ASSOC);
                    echo$ru['username'].($ru['name']!=''?':'.$ru['name']:'').'<br><small><small>'.rank($ru['rank']).'</small></small>';
                  }else echo isset($ru['email'])&&$ru['email']!=''?'<a href="mailto:'.$ru['email'].'">'.$ru['email'].'</a>':'Nonexistent User';?>
                </div>
                <div class="col-12 col-md-4 align-top small"><?= strip_tags($r['notes']);?></div>
                <div class="col-12 col-md-2 align-top small">
                  <?php $sc=$db->prepare("SELECT `id`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $sc->execute([':id'=>$r['rid']]);
                  $rc=$sc->fetch(PDO::FETCH_ASSOC);
                  echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rc['id'].'#tab1-5">'.$rc['title'].'</a>';?>
                </div>
                <div class="col-12 col-md-2 text-center small"><?= date($config['dateFormat'],$r['ti']);?></div>
                <div class="col-12 col-md pr-2 text-right">
                  <div class="btn-group" id="controls_<?=$r['id'];?>" role="group">
                    <?php if($user['options'][0]==1){
                      $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                      $scc->execute([':ip'=>$r['ip']]);
                      if($scc->rowCount()<1){?>
                        <form class="d-inline-block" id="blacklist<?=$r['id'];?>" target="sp" method="post" action="core/add_commentblacklist.php">
                          <input name="id" type="hidden" value="<?=$r['id'];?>">
                          <button data-tooltip="tooltip" aria-label="Add IP to Blacklist"><i class="i">blacklist-add</i></button>
                        </form>
                      <?php }?>
                      <button class="add<?=$r['status']!='unapproved'?' hidden':'';?>" id="approve_<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Approve" onclick="update('<?=$r['id'];?>','comments','status','approved');"><i class="i">approve</i></button>
                      <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','comments');"><i class="i">trash</i></button>
                    <?php }?>
                  </div>
                </div>
              </div>
            </article>
          <?php }?>
        </section>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
