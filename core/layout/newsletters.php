<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Newsletters
 * @package    core/layout/newsletters.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='19'")->execute();
if(isset($args[0])&&$args[0]=='add'){
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`contentType`,`status`,`ti`) VALUES ('newsletters','unpublished',:ti)");
  $q->execute([':ti'=>$ti]);
  $args[1]=$db->lastInsertId();
  $args[0]='edit';
  echo'<script>history.replaceState("","","'.URL.$settings['system']['admin'].'/newsletters/edit/'.$args[1].'");</script>';
}
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_newsletters.php';
elseif(isset($args[0])&&$args[0]=='edit')
  require'core/layout/edit_newsletters.php';
else{
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType ORDER BY `ti` DESC, `title` ASC");
  $s->execute([':contentType'=>'newsletters']);?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active">Newsletters</li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group d-inline">
                  <?=($user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/newsletters/settings" role="button" data-tooltip="left" aria-label="Newsletters Settings"><i class="i">settings</i></a>':'').
                  ($user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/newsletters/add" role="button" data-tooltip="left" aria-label="Add"><i class="i">add</i></a>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Newsletters</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Subscribers</label>
<?php /* Newsletters */ ?>
            <div class="tab1-1 border" role="tabpanel">
              <div id="notification"></div>
              <table class="table-zebra">
                <thead>
                  <tr>
                    <th>Subject</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Published</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr class="item" id="l_<?=$r['id'];?>">
                      <td class="align-middle d-table-cell"><a href="<?=$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>"><?=$r['title'];?></a></td>
                      <td class="text-center align-middle d-table-cell"><?= date($config['dateFormat'],$ti);?></td>
                      <td class="text-center align-middle d-table-cell"><?=$r['status']=='unpublished'?'Unpublished':date($config['dateFormat'],$r['tis']);?></td>
                      <td class="align-middle d-table-cell" id="controls_<?=$r['id'];?>">
                        <div class="btn-toolbar float-right" role="toolbar">
                          <div class="btn-group" role="group">
                            <?=$user['options'][1]==1?'<button class="email" data-tooltip="tooltip" aria-label="Send Newsletters" onclick="$(`#sp`).load(`core/newsletter.php?id='.$r['id'].'&act=`);"><i class="i">email-send</i></button>':'';?>
                            <a<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Edit"':' data-tooltip="tooltip" aria-label="View"';?> href="<?=$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>" role="button"><?=$user['options'][1]==1?'<i class="i">edit</i>':'<i class="i">view</i>';?></a>
                            <?php if($user['options'][0]==1){?>
                              <button class="<?=$r['status']!='delete'?' d-none':'';?>" onclick="updateButtons('<?=$r['id'];?>','content','status','unpublished');" data-tooltip="tooltip" aria-label="Restore"><i class="i">untrash</i></button>
                              <button class="trash<?=$r['status']=='delete'?' d-none':'';?>" onclick="updateButtons('<?=$r['id'];?>','content','status','delete');" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                              <button class="purge<?=$r['status']!='delete'?' d-none':'';?>" onclick="purge('<?=$r['id'];?>','content');" data-tooltip="tooltip" aria-label="Purge"><i class="i">purge</i></button>
                            <?php }?>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
            <div class="tab1-2 border" role="tabpanel">
              <table class="table-zebra">
                <thead>
                  <tr>
                    <th>Email</th>
                    <th class="text-right">Subscribed</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $s=$db->prepare("SELECT `id`,`email`,`newsletter` FROM `".$prefix."login` WHERE `newsletter`=1 ORDER BY `email` ASC, `username` ASC, `name` ASC");
                  $s->execute();
                  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                      <td class="align-middle"><?=$r['email'];?></td>
                      <td class="text-right align-middle">
                        <input id="newsletter<?=$r['id'];?>" data-dbid="<?=$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0" type="checkbox"<?=($r['newsletter']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][0]==1?'':' disabled');?>>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
              <?php if($user['options'][0]==1){?>
                <form target="sp" method="post" action="core/add_subscribers.php">
                  <div class="form-row">
                    <div class="input-text">Email/s</div>
                    <input id="eml" name="emails" type="text" value="" placeholder="Enter Email/s (Comma Seperated)...">
                    <button class="add" type="submit" role="button" data-tooltip="tooltip" aria-label="Add Subscriber/s"><i class="i">add</i></button>
                  </div>
                </form>
              <?php }?>
              <table class="table-zebra">
                <thead>
                  <tr>
                    <th class="col-6">Email</th>
                    <th class="col-3">Date Signed Up</th>
                    <th class="col-3"></th>
                  </tr>
                </thead>
                <tbody id="subs">
                  <?php $s=$db->prepare("SELECT `id`,`email`,`ti` FROM `".$prefix."subscribers` ORDER BY `email` ASC");
                  $s->execute();
                  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr id="l_<?=$r['id'];?>" class="item">
                      <td><?=$r['email'];?></td>
                      <td><?= date($config['dateFormat'],$r['ti']);?></td>
                      <td class="align-middle">
                        <div class="btn-toolbar float-right" role="toolbar" data-tooltip="tooltip" aria-label="Item Toolbar Controls">
                          <div class="btn-group" role="group" data-tooltip="tooltip" aria-label="Item Controls">
                            <?=$user['options'][0]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$r['id'].'`,`subscribers`);"><i class="i">trash</i></button>':'';?>
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
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
