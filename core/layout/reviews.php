<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Reviews
 * @package    core/layout/reviews.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Reviews</li>
  </ol>
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <div class="table">
                <table class="table-striped table-hover col-12">
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
                        <td class="">
                          <?php $sc=$db->prepare("SELECT `id`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                          $sc->execute([
                            ':id'=>$r['rid']
                          ]);
                          $rc=$sc->fetch(PDO::FETCH_ASSOC);
                          echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rc['id'].'#tab-content-reviews">'.$rc['title'].'</a>';?>
                        </td>
                        <td class="small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                        <td class="align-top">
                          <div id="controls-<?php echo$r['id'];?>" class="btn-group float-right">
                            <button id="approve_<?php echo$r['id'];?>" class="btn btn-secondary btn-sm<?php echo$r['status']=='approved'?' hidden':'';?>" onclick="update('<?php echo$r['id'];?>','comments','status','approved')" data-tooltip="tooltip" data-title="Approve" aria-label="Approve"><?php svg('approve');?></button>
                            <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$r['id'];?>','comments')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                          </div>
                        </td>
                      </tr>
                    <?php }
                    if($scnt>20){?>
                      <tr id="more_20">
                        <td colspan="5">
                          <div class="form-group">
                            <div class="input-group">
                              <button class="btn btn-secondary btn-block" onclick="more('comments','20','<?php echo(isset($args[1])&&$args[1]!=''?$args[1]:'');?>');">More</button>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
