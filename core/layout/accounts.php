<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts
 * @package    core/layout/accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * class, style, id, name, list, data-*, target, rel, src, for, type, method, action, href, value, title, alt, placeholder, role, required, aria-*, onEvents
 * Header Toolbar: Back, Fullscreen, Settings, Print, Email, Send, Add, SaveAll
 * Button Toolbar: Edit, Restore (hidden), Delete, Purge (hidden)
 */
if(isset($args[0])&&$args[0]=='add'){
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
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_accounts.php';
elseif(isset($args[0])&&$args[0]=='edit')require'core/layout/edit_accounts.php';
else{
  if(isset($args[0])&&$args[0]=='type'){
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
            <button class="accountview" data-tooltip="tooltip" aria-label="View Accounts as Cards or List" onclick="toggleAccountView();return false;"><?= svg2('list',($_COOKIE['accountview']=='list'?'d-none':'')).svg2('cards',($_COOKIE['accountview']=='cards'?'d-none':''));?></button>
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
        <div class="row p-3">
          <div class="col-12 col-sm-6 ml-sm-auto">
            <div class="form-row">
              <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
            </div>
          </div>
        </div>
        <section id="accountview" class="content overflow-visible<?= isset($_COOKIE['accountview'])&&$_COOKIE['accountview']=='list'?' list':'';?>">
          <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <article class="card overflow-visible card-list" data-content="<?=$r['username'].' '.$r['name']?>" id="l_<?=$r['id'];?>">
              <div class="card-image overflow-visible">
                <a href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" aria-label="Edit <?=$r['username'].':'.$r['name'];?>"><img src="<?php if($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))echo'media/avatar/'.basename($r['avatar']);
                elseif($r['gravatar']!='')echo$r['gravatar'];
                else echo ADMINNOAVATAR;?>" alt="<?=$r['username'];?>"></a>
                <?='<span id="accountrank'.$r['id'].'" class="status badger badge-'.rank($r['rank']).'">'.ucwords(str_replace('-',' ',rank($r['rank']))).'</span>';?>
                <div class="image-toolbar">
                  <?=$r['active'][0]==1?'<span class="badger badge-success">Active</span>':'<span class="badger badge-dark">Inactive</span>';?>
                </div>
              </div>
              <div class="card-header overflow-visible pt-2 line-clamp">
                <a data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" aria-label="Edit <?=$r['username'].':'.$r['name'];?>"><?=$r['username'].':'.$r['name'];?></a><br>
                <small class="text-muted"><small><?= _agologgedin($r['lti']);?></small></small>
                <?=$r['active'][0]==1?'<br><span class="badger badge-success">Active</span>':'<br><span class="badger badge-dark">Inactive</span>';?>
              </div>
              <div class="card-footer">
                <div id="controls_<?=$r['id'];?>">
                  <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group" role="group">
                      <a data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" role="button" aria-label="Edit<?=' '.$r['username'].':'.$r['name'];?>"><?= svg2('edit');?></a>
                      <?php if($user['options'][0]==1){?>
                        <button class="btn add<?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','login','status','unpublished');"><?= svg2('untrash');?></button>
                        <button class="btn trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','login','status','delete');"><?= svg2('trash');?></button>
                        <button class="btn purge trash<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','login');"><?= svg2('purge');?></button>
                        <button class="btn-ghost quickeditbtn" data-qeid="<?=$r['id'];?>" data-qet="login" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><?php svg('chevron-down').svg('chevron-up','d-none');?></button>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
            </article>
            <div class="quickedit d-none" id="quickedit<?=$r['id'];?>"></div>
          <?php }?>
        </section>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php }
