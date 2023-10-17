<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Accounts
 * @package    core/layout/accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * class, style, id, name, list, data-*, target, rel, src, for, type, method, action, href, value, title, alt, placeholder, role, required, aria-*, onEvents
 * Header Toolbar: Back, Fullscreen, Settings, Print, Email, Send, Add, SaveAll
 * Button Toolbar: Edit, Restore (hidden), Delete, Purge (hidden)
 */
if(isset($args[0])&&$args[0]=='add'){
  $type=filter_input(INPUT_GET,'type',FILTER_UNSAFE_RAW);
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
    $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `rank`=:rank ORDER BY `ord` ASC, `ti` DESC");
    $s->execute([':rank'=>$rank]);
  }else{
    if($user['options'][5]==1){
      $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `rank`<:rank ORDER BY `ord` ASC, `ti` DESC");
      $s->execute([':rank'=>$_SESSION['rank']+1]);
    }else{
      $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id ORDER BY `ord` ASC, `ti` DESC");
      $s->execute([':id'=>$user['id']]);
    }
  }?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-6">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active">Accounts</li>
                </ol>
              </div>
              <div class="col-12 col-sm-6 text-right">
                <div class="form-row justify-content-end">
                  <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
                  <div class="btn-group">
                    <button class="accountview" data-tooltip="left" aria-label="View Accounts as Cards or List" onclick="toggleAccountView();return false;"><i class="i<?=($_COOKIE['accountview']=='list'?' d-none':'');?>">list</i><i class="i<?=($_COOKIE['accountview']=='cards'?' d-none':'');?>">cards</i></button>
                    <?=($user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/accounts/settings" role="button" data-tooltip="left" aria-label="Accounts Settings"><i class="i">settings</i></a>':'').
                    ($user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/accounts/add" role="button" data-tooltip="left" aria-label="Add"><i class="i">add</i></a>':'');?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <section class="content mt-3 overflow-visible<?= isset($_COOKIE['accountview'])&&$_COOKIE['accountview']=='list'?' list':'';?>" id="accountview">
            <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
              $avatarimg=ADMINNOAVATAR;
              if($r['avatar']!=''&&file_exists('media/avatar/'.basename($r['avatar'])))
              $avatarimg='media/avatar/'.basename($r['avatar']);
              elseif($r['gravatar']!='')
              $avatarimg=$r['gravatar'];?>
              <article class="card zebra col-6 col-md-5 col-lg-3 col-xxl-2 mx-0 mx-md-2 mt-2 mb-0 overflow-visible card-list item shadow" id="l_<?=$r['id'];?>" data-content="<?=$r['username'].' '.$r['name']?>">
                <div class="card-image overflow-visible">
                  <a data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" aria-label="Edit <?=$r['username'].':'.$r['name'];?>">
                    <img src="<?=$avatarimg;?>" alt="<?=$r['username'];?>">
                  </a>
                  <span class="status badger badge-<?= rank($r['rank']);?>" id="accountrank<?=$r['id'];?>"><?= ucwords(str_replace('-',' ',rank($r['rank'])));?></span>
                  <div class="image-toolbar">
                    <?=$r['active']==1?'<span class="badger badge-success">Active</span>':'<span class="badger badge-dark">'.($r['status']=='deactivated'?'Deactivated':'Inactive').'</span>';?>
                  </div>
                </div>
                <div class="card-header overflow-visible pt-2 line-clamp">
                  <a data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" aria-label="<?=($user['options'][1]==1?'Edit':'View').' '.$r['username'].':'.$r['name'];?>"><?=$r['username'].':'.$r['name'];?></a><br>
                  <small class="text-muted"><small><?= _agologgedin($r['lti']);?></small></small>
                  <?=$r['active']==1?'<br><span class="badger badge-success">Active</span>':'<br><span class="badger badge-dark">Inactive</span>';?>
                </div>
                <div class="card-footer">
                  <div id="controls_<?=$r['id'];?>">
                    <div class="btn-toolbar float-right" role="toolbar">
                      <div class="btn-group" role="group">
                        <a data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" role="button" aria-label="<?=($user['options'][1]==1?'Edit ':'View ').$r['username'].':'.$r['name'];?>"><i class="i"><?=$user['options'][1]==1?'edit':'view';?></i></a>
                        <?php if($user['options'][0]==1){?>
                          <button class="add<?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','login','status','unpublished');"><i class="i">untrash</i></button>
                          <button class="trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','login','status','delete');"><i class="i">trash</i></button>
                          <button class="purge<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','login');"><i class="i">purge</i></button>
                        <?php }
                        echo($user['options'][1]==1?'<button class="quickeditbtn" data-qeid="'.$r['id'].'" data-qet="login" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>'.
                        '<span class="btn orderhandle m-0" data-tooltip="tooltip" aria-label="Drag to ReOrder"><i class="i">drag</i></span>':'');?>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
              <div class="quickedit shadow" id="quickedit<?=$r['id'];?>"></div>
            <?php }?>
            <article class="ghost hidden"></article>
          </section>
        </div>
        <?php if($user['options'][1]==1){?>
          <script>
            $('#accountview').sortable({
              items:"article.item",
              handle:'.orderhandle',
              placeholder:"ghost",
              helper:fixWidthHelper,
              update:function(e,ui){
                var order=$("#accountview").sortable("serialize");
                $.ajax({
                  type:"POST",
                  dataType:"json",
                  url:"core/reorderaccounts.php",
                  data:order
                });
              }
            }).disableSelection();
            function fixWidthHelper(e,ui){
              ui.children().each(function(){
                $(this).width($(this).width());
              });
              return ui;
            }
          </script>
        <?php }?>
      </div>
      <?php require'core/layout/footer.php';?>
    </section>
  </main>
<?php }
