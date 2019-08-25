<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts
 * @package    core/layout/accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]=='add'){
  $type=filter_input(INPUT_GET,'type',FILTER_SANITIZE_STRING);
  $q=$db->prepare("INSERT INTO `".$prefix."login` (options,active,ti) VALUES ('00000000','1',:ti)")->execute(array(':ti'=>time()));
  $args[1]=$db->lastInsertId();
  $q=$db->prepare("UPDATE `".$prefix."login` SET username=:username WHERE id=:id");
  $q->execute([':username'=>'User '.$args[1],':id'=>$args[1]]);
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
    $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE rank=:rank ORDER BY ti DESC");
    $s->execute([':rank'=>$rank]);
  }else{
    $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE rank<:rank ORDER BY ti DESC");
    $s->execute([':rank'=>$_SESSION['rank']+1]);
  }?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Accounts</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/accounts/add';?>" data-tooltip="tooltip" data-placement="left" title="Add" role="button" aria-label="Add"><?php svg('add');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-striped table-hover">
            <thead>
              <tr>
                <th></th>
                <th>Username/Name</th>
                <th class="text-center">Last Login</th>
                <th class="text-center">Rank</th>
                <th class="text-center">Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>">
                <td class="align-middle">
                  <img class="img-fluid img-circle bg-white" style="max-width:32px;height:32px;" src="<?php if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))echo'media'.DS.'avatar'.DS.basename($r['avatar']);elseif($r['avatar']!='')echo$r['avatar'];elseif($r['gravatar']!='')echo$r['gravatar'];else echo ADMINNOAVATAR;?>" alt="<?php echo$r['username'];?>">
                </td>
                <td class="align-middle">
                  <a href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" aria-label="Edit <?php echo$r['name']==''?$r['username']:$r['name'];?>"><?php echo$r['username'].':'.$r['name'];?></a>
                  <?php echo$user['rank']==1000?'<div class="small d-none d-sm-block"><small>IP: '.$r['userIP'].'<br>'.$r['userAgent'].'</small></div>':'';?>
                </td>
                <td class="text-center align-middle"<?php echo$r['lti']!=0&&$user['rank']==1000?' data-tooltip="tooltip" title="'.date($config['dateFormat'],$r['lti']).'""':'';?>><?php echo _ago($r['lti']);?></td>
                <td class="text-center align-middle"><?php echo ucfirst(rank($r['rank']));?></td>
                <td class="text-center align-middle"><?php echo$r['active']{0}==1?'Active':$r['status']!=''?ucfirst($r['status']):'Inactive';?></td>
                <td id="controls_<?php echo$r['id'];?>" class="align-middle">
                  <div class="btn-group pull-right">
                    <a class="btn btn-secondary" href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" data-tooltip="tooltip" title="Edit" role="button" aria-label="Edit"><?php svg('edit');?></a>
<?php if($r['rank']!=1000){?>
                    <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','unpublished')" data-tooltip="tooltip" title="Restore" aria-label="Restore"><?php svg('untrash');?></button>
                    <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','delete')" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                    <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','login')" data-tooltip="tooltip" title="Purge" aria-label="Purge"><?php svg('purge');?></button>
<?php }?>
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
</main>
<?php }
