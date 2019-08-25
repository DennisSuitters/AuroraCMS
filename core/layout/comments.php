<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Comments
 * @package    core/layout/comments.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Comments</li>
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
                      <th>Comment</th>
                      <th>In Response To</th>
                      <th>Submitted On</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="l_comments">
<?php  
  $s=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType='article' AND status='unapproved'");
  $s->execute();
  $scnt=$s->rowCount();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $su=$db->prepare("SELECT id,username,name,rank FROM `".$prefix."login` WHERE id=:uid");
    $su->execute([
      ':uid'=>$r['uid']
    ]);
    ?>
                    <tr id="l_<?php echo$r['id'];?>">
                      <td class="">
<?php if($su->rowCount()==1){
  $ru=$su->fetch(PDO::FETCH_ASSOC);
  echo$ru['username'].($ru['name']!=''?':'.$ru['name']:'').'<br><small><small>'.rank($ru['rank']).'</small></small>';
}else{
  echo'<a href="mailto:'.$ru['email'].'">'.$ru['email'].'</a>';
}?>
                      </td>
                      <td class="small"><?php echo strip_tags($r['notes']);?></td>
                      <td class="">
<?php
  $sc=$db->prepare("SELECT id,title FROM `".$prefix."content` WHERE id=:id");
  $sc->execute([
    ':id'=>$r['rid']
  ]);
  $rc=$sc->fetch(PDO::FETCH_ASSOC);
  echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$rc['id'].'#tab-content-comments">'.$rc['title'].'</a>';
?>
                      </td>
                      <td class="small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                      <td class="align-top">
                        <div id="controls-<?php echo$r['id'];?>" class="btn-group float-right">
<?php $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
  $scc->execute([':ip'=>$r['ip']]);
  if($scc->rowCount()<1){?>
                          <form id="blacklist<?php echo$r['id'];?>" class="d-inline-block" target="sp" method="post" action="core/add_commentblacklist.php">
                            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                            <button class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="Add IP to Blacklist" aria-label="Add IP to Blacklist"><?php svg('security');?></button>
                          </form>
<?php }?>
                          <button id="approve_<?php echo$r['id'];?>" class="btn btn-secondary btn-sm add<?php echo$r['status']!='unapproved'?' hidden':'';?>" onclick="update('<?php echo$r['id'];?>','comments','status','approved')" data-tooltip="tooltip" title="Approve" aria-label="Approve"><?php svg('approve');?></button>
                          <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$r['id'];?>','comments')" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
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
