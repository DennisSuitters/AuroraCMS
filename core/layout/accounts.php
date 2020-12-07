<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts
 * @package    core/layout/accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * class, style, id, name, list, data-*, target, rel, src, for, type, method, action, href, value, title, alt, placeholder, role, required, aria-*, onEvents
 * Back, Fullscreen, Settings, Print, Email, Send, Add, SaveAll
 */
if($args[0]=='add'){
  $type=filter_input(INPUT_GET,'type',FILTER_SANITIZE_STRING);
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`active`,`timezone`,`ti`) VALUES ('1','default',:ti)");
  $q->execute([
    ':ti'=>time()
  ]);
  $args[1]=$db->lastInsertId();
  $q=$db->prepare("UPDATE `".$prefix."login` SET `username`=:username WHERE `id`=:id");
  $q->execute([
    ':username'=>'User '.$args[1],
    ':id'=>$args[1]
  ]);
  $args[0]='edit';
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/accounts/edit/'.$args[1].'");/*]]>*/</script>';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_accounts.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_accounts.php';
else{
  if($args[0]=='type'){
    if(isset($args[1])){
      $rank=0;
      if($args[1]=='subscriber')$rank=100;
      if($args[1]=='member')$rank=200;
      if($args[1]=='client')$rank=300;
      if($args[1]=='contributor')$rank=400;
      if($args[1]=='author')$rank=500;
      if($args[1]=='editor')$rank=600;
      if($args[1]=='moderator')$rank=700;
      if($args[1]=='manager')$rank=800;
      if($args[1]=='administrator')$rank=900;
      if($args[1]=='developer')$rank=1000;
    }
    $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `rank`=:rank ORDER BY `ti` DESC");
    $s->execute([
      ':rank'=>$rank
    ]);
  }else{
    if($user['options'][5]==1){
      $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `rank`<:rank ORDER BY `ti` DESC");
      $s->execute([
        ':rank'=>$_SESSION['rank']+1
      ]);
    }else{
      $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
      $s->execute([
        ':id'=>$user['id']
      ]);
    }
  }?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('users','i-3x');?></div>
          <div>Accounts</div>
          <div class="content-title-actions">
            <?php echo$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings" role="button" aria-label="Accounts Settings">'.svg2('settings').'</a>':'&nbsp;';
            echo$user['options'][0]==1?'&nbsp;<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/add" role="button" aria-label="Add">'.svg2('add').'</a>':'&nbsp;';?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Accounts</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow">
        <table class="table-zebra">
          <thead>
            <tr>
              <th></th>
              <th>Username/Name</th>
              <th class="text-center d-none d-sm-table-cell">Rank</th>
              <th class="text-center d-none d-sm-table-cell">Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>">
                <td class="align-middle">
                  <img class="avatar" src="<?php if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))echo'media'.DS.'avatar'.DS.basename($r['avatar']);
                  elseif($r['gravatar']!='')echo$r['gravatar'];
                  else echo ADMINNOAVATAR;?>" alt="<?php echo$r['username'];?>">
                </td>
                <td class="align-middle">
                  <a href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" aria-label="Edit <?php echo$r['name']==''?$r['username']:$r['name'];?>"><?php echo$r['username'].':'.$r['name'];?></a><br>
                  <small class="text-muted"><small><?php echo _agologgedin($r['lti']);?></small></small>
                </td>
                <td class="text-center align-middle d-none d-sm-table-cell"><?php echo ucfirst(rank($r['rank']));?></td>
                <td class="text-center align-middle d-none d-sm-table-cell"><?php echo$r['active'][0]==1?'Active':$r['status']!=''?ucfirst($r['status']):'Inactive';?></td>
                <td class="align-middle" id="controls_<?php echo$r['id'];?>">
                  <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                    <div class="btn-group" role="group" aria-label="Item Controls">
                      <a class="btn" data-tooltip="tooltip" href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" role="button" aria-label="Edit"><?php svg('edit');?></a>
                      <?php if($user['options'][0]==1){?>
                        <button class="btn<?php echo$r['status']!='delete'?' d-none':'';?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?php echo$r['id'];?>','login','status','unpublished');"><?php svg('untrash');?></button>
                        <button class="btn trash<?php echo$r['status']=='delete'?' d-none':'';?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?php echo$r['id'];?>','login','status','delete');"><?php svg('trash');?></button>
                        <button class="btn trash<?php echo$r['status']!='delete'?' d-none':'';?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?php echo$r['id'];?>','login');"><?php svg('purge');?></button>
                      <?php }?>
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
<?php }
