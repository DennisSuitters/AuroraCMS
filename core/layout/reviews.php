<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Reviews
 * @package    core/layout/reviews.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
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
        <table class="table-zebra">
          <thead>
            <tr>
              <th>Author</th>
              <th>Review</th>
              <th>In Response To</th>
              <th>Submitted On</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="l_comments">
            <?php $s=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review'");
            $s->execute();
            $scnt=$s->rowCount();
            while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?=$r['id'];?>">
                <td class="align-middle"><?='<a href="mailto:'.$r['email'].'">'.($r['name']!=''?$r['name']:'Anonymous').'</a>';?></td>
                <td class="align-middle small">
                  <span class="rating d-block d-sm-inline-block">
                    <span<?=$r['cid']>=1?' class="set"':'';?>></span>
                    <span<?=$r['cid']>=2?' class="set"':'';?>></span>
                    <span<?=$r['cid']>=3?' class="set"':'';?>></span>
                    <span<?=$r['cid']>=4?' class="set"':'';?>></span>
                    <span<?=$r['cid']==5?' class="set"':'';?>></span>
                  </span><br>
                  <small><?= strip_tags($r['notes']);?></small>
                </td>
                <td class="align-middle">
                  <?php $sc=$db->prepare("SELECT `id`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $sc->execute([':id'=>$r['rid']]);
                  $rc=$sc->fetch(PDO::FETCH_ASSOC);
                  echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rc['id'].'#tab1-6">'.$rc['title'].'</a>';?>
                </td>
                <td class="align-middle small"><?= date($config['dateFormat'],$r['ti']);?></td>
                <td class="align-middle">
                  <div class="btn-group float-right" id="controls-<?=$r['id'];?>">
                    <button class="btn add<?=$r['status']=='approved'?' hidden':'';?>" id="approve_<?=$r['id'];?>" onclick="update('<?=$r['id'];?>','comments','status','approved');" data-tooltip="tooltip" aria-label="Approve"><i class="i">approve</i></button>
                    <button class="btn trash" onclick="purge('<?=$r['id'];?>','comments');" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                  </div>
                </td>
              </tr>
            <?php }
            if($scnt>20){?>
              <tr id="more_20">
                <td colspan="5">
                  <div class="form-group">
                    <div class="input-group">
                      <button class="btn-block" onclick="more('comments','20','<?= isset($args[1])&&$args[1]!=''?$args[1]:'';?>');">More</button>
                    </div>
                  </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
