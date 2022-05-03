<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Comments
 * @package    core/layout/comments.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">comments</i></div>
          <div>Comments</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Comments</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0">
        <table class="table-zebra">
          <thead>
            <tr>
              <th>Author</th>
              <th>Comment</th>
              <th>In Response To</th>
              <th>Submitted On</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="l_comments">
            <?php $s=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE `contentType`='article' AND `status`='unapproved'");
            $s->execute();
            $scnt=$s->rowCount();
            while($r=$s->fetch(PDO::FETCH_ASSOC)){
              $su=$db->prepare("SELECT `id`,`username`,`name`,`rank` FROM `".$prefix."login` WHERE `id`=:uid");
              $su->execute([':uid'=>$r['uid']]);?>
              <tr id="l_<?=$r['id'];?>">
                <td>
                  <?php if($su->rowCount()==1){
                    $ru=$su->fetch(PDO::FETCH_ASSOC);
                    echo$ru['username'].($ru['name']!=''?':'.$ru['name']:'').'<br><small><small>'.rank($ru['rank']).'</small></small>';
                  }else echo isset($ru['email'])&&$ru['email']!=''?'<a href="mailto:'.$ru['email'].'">'.$ru['email'].'</a>':'Nonexistent User';?>
                </td>
                <td class="small"><?= strip_tags($r['notes']);?></td>
                <td>
                  <?php $sc=$db->prepare("SELECT `id`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $sc->execute([':id'=>$r['rid']]);
                  $rc=$sc->fetch(PDO::FETCH_ASSOC);
                  echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rc['id'].'#tab-content-comments">'.$rc['title'].'</a>';?>
                </td>
                <td class="small"><?= date($config['dateFormat'],$r['ti']);?></td>
                <td class="align-middle" id="controls_<?=$r['id'];?>">
                  <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group" role="group">
                      <?php if($user['options'][0]==1){
                        $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                        $scc->execute([':ip'=>$r['ip']]);
                        if($scc->rowCount()<1){?>
                          <form class="d-inline-block" id="blacklist<?=$r['id'];?>" target="sp" method="post" action="core/add_commentblacklist.php">
                            <input name="id" type="hidden" value="<?=$r['id'];?>">
                            <button data-tooltip="tooltip" aria-label="Add IP to Blacklist"><i class="i">security</i></button>
                          </form>
                        <?php }?>
                        <button class="add<?=$r['status']!='unapproved'?' hidden':'';?>" id="approve_<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Approve" onclick="update('<?=$r['id'];?>','comments','status','approved');"><i class="i">approve</i></button>
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','comments');"><i class="i">trash</i></button>
                      <?php }?>
                    </div>
                  </div>
                </td>
              </tr>
            <?php }
            if($scnt>20){?>
              <tr id="more_20">
                <td colspan="5">
                  <div class="form-row">
                    <button class="btn-block" onclick="more('comments','20','<?=(isset($args[1])&&$args[1]!=''?$args[1]:'');?>');">More</button>
                  </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
