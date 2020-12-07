<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Reviews
 * @package    core/layout/reviews.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content" class="main">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('review','i-3x');?></div>
          <div>Reviews</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Reviews</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow">
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
            <?php $s=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='review' AND `status`='unapproved'");
            $s->execute();
            $scnt=$s->rowCount();
            while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>">
                <td class=""><?php echo'<a href="mailto:'.$r['email'].'">'.($r['name']!=''?$r['name']:'Anonymous').'</a>';?></td>
                <td class="small">
                  <span class="rat d-block d-sm-inline-block">
                    <span<?php echo($r['cid']>=1?' class="set"':'');?>></span>
                    <span<?php echo($r['cid']>=2?' class="set"':'');?>></span>
                    <span<?php echo($r['cid']>=3?' class="set"':'');?>></span>
                    <span<?php echo($r['cid']>=4?' class="set"':'');?>></span>
                    <span<?php echo($r['cid']==5?' class="set"':'');?>></span>
                  </span><br>
                  <small><?php echo strip_tags($r['notes']);?></small>
                </td>
                <td>
                  <?php $sc=$db->prepare("SELECT `id`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $sc->execute([
                    ':id'=>$r['rid']
                  ]);
                  $rc=$sc->fetch(PDO::FETCH_ASSOC);
                  echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rc['id'].'#tab-content-reviews">'.$rc['title'].'</a>';?>
                </td>
                <td class="small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                <td class="align-top">
                  <div class="btn-group float-right" id="controls-<?php echo$r['id'];?>">
                    <button class="btn<?php echo$r['status']=='approved'?' hidden':'';?>" id="approve_<?php echo$r['id'];?>" data-tooltip="tooltip" onclick="update('<?php echo$r['id'];?>','comments','status','approved');" aria-label="Approve"><?php svg('approve');?></button>
                    <button class="btn trash" data-tooltip="tooltip" onclick="purge('<?php echo$r['id'];?>','comments');" aria-label="Delete"><?php svg('trash');?></button>
                  </div>
                </td>
              </tr>
            <?php }
            if($scnt>20){?>
              <tr id="more_20">
                <td colspan="5">
                  <div class="form-group">
                    <div class="input-group">
                      <button class="btn-block" onclick="more('comments','20','<?php echo(isset($args[1])&&$args[1]!=''?$args[1]:'');?>');">More</button>
                    </div>
                  </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
