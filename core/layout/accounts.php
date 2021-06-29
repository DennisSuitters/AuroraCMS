<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts
 * @package    core/layout/accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * class, style, id, name, list, data-*, target, rel, src, for, type, method, action, href, value, title, alt, placeholder, role, required, aria-*, onEvents
 * Header Toolbar: Back, Fullscreen, Settings, Print, Email, Send, Add, SaveAll
 * Button Toolbar: Edit, Restore (hidden), Delete, Purge (hidden)
 */
if($args[0]=='add'){
  $type=filter_input(INPUT_GET,'type',FILTER_SANITIZE_STRING);
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`active`,`timezone`,`ti`) VALUES ('1','default',:ti)");
  $q->execute([':ti'=>time()]);
  $args[1]=$db->lastInsertId();
  $q=$db->prepare("UPDATE `".$prefix."login` SET `username`=:username WHERE `id`=:id");
  $q->execute([
    ':username'=>'User '.$args[1],
    ':id'=>$args[1]
  ]);
  $args[0]='edit';
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/accounts/edit/'.$args[1].'");/*]]>*/</script>';
}
if($args[0]=='settings')require'core/layout/set_accounts.php';
elseif($args[0]=='edit')require'core/layout/edit_accounts.php';
else{
  if($args[0]=='type'){
    if(isset($args[1]))$rank=rank($args[1]);
    $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `rank`=:rank ORDER BY `ti` DESC");
    $s->execute([':rank'=>$rank]);
  }else{
    if($user['options'][5]==1){
      $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `rank`<:rank ORDER BY `ti` DESC");
      $s->execute([':rank'=>$_SESSION['rank']+1]);
    }else{
      $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
      $s->execute([':id'=>$user['id']]);
    }
  }?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('users','i-3x');?></div>
          <div>Accounts</div>
          <div class="content-title-actions">
            <?=($user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings" role="button" aria-label="Accounts Settings">'.svg2('settings').'</a>':'&nbsp;').($user['options'][0]==1?'&nbsp;<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/add" role="button" aria-label="Add">'.svg2('add').'</a>':'&nbsp;');?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Accounts</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow overflow-visible">
        <table class="table-zebra">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>Username/Name</th>
              <th class="text-center d-none d-sm-table-cell">Rank</th>
              <th class="text-center d-none d-sm-table-cell">Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?=$r['id'];?>">
                <td class="align-middle"><button class="btn-ghost quickeditbtn" data-qeid="<?=$r['id'];?>" data-qet="login" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><?= svg2('plus').svg2('close','d-none');?></button></td>
                <td class="align-middle">
                  <img class="avatar" src="<?php if($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))echo'media/avatar/'.basename($r['avatar']);
                  elseif($r['gravatar']!='')echo$r['gravatar'];
                  else echo ADMINNOAVATAR;?>" alt="<?=$r['username'];?>">
                </td>
                <td class="align-middle">
                  <a data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" aria-label="Edit <?=$r['username'].':'.$r['name'];?>"><?=$r['username'].':'.$r['name'];?></a><br>
                  <small class="text-muted"><small><?= _agologgedin($r['lti']);?></small></small>
                </td>
                <td class="text-center align-middle d-none d-sm-table-cell">
                  <?='<span id="accountrank'.$r['id'].'" class="badger badge-'.rank($r['rank']).'">'.ucwords(str_replace('-',' ',rank($r['rank']))).'</span><br><small class="'.($r['options'][19]!=1&&$r['rank']>301&&$r['rank']<400?'':' d-none').'" id="wholesaler'.$r['id'].'">Approval Pending</small>';?>
                </td>
                <td class="text-center align-middle d-none d-sm-table-cell"><?=$r['active'][0]==1?'Active':$r['status']!=''?ucfirst($r['status']):'Inactive';?></td>
                <td class="align-middle" id="controls_<?=$r['id'];?>">
                  <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group" role="group">
                      <a data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" role="button" aria-label="Edit<?=' '.$r['username'].':'.$r['name'];?>"><?= svg2('edit');?></a>
                      <?php if($user['options'][0]==1){?>
                        <button class="btn add<?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','login','status','unpublished');"><?= svg2('untrash');?></button>
                        <button class="btn trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','login','status','delete');"><?= svg2('trash');?></button>
                        <button class="btn purge trash<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','login');"><?= svg2('purge');?></button>
                      <?php }?>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="quickedit d-none" id="quickedit<?=$r['id'];?>"></tr>
            <?php }?>
          </tbody>
        </table>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php }
