<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Newsletters
 * @package    core/layout/newsletters.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]=='add'){
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`contentType`,`status`,`ti`) VALUES ('newsletters','unpublished',:ti)");
  $q->execute([
    ':ti'=>$ti
  ]);
  $args[1]=$db->lastInsertId();
  $args[0]='edit';
  echo'<script>history.replaceState("","","'.URL.$settings['system']['admin'].'/newsletters/edit/'.$args[1].'");</script>';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_newsletters.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_newsletters.php';
else{
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType ORDER BY `ti` DESC, `title` ASC");
  $s->execute([
    ':contentType'=>'newsletters'
  ]);?>
  <main>
    <section id="content">
      <div class="content-title-wrapper mb-0">
        <div class="content-title">
          <div class="content-title-heading">
            <div class="content-title-icon"><?php svg('newspaper','i-3x');?></div>
            <div>Newsletters</div>
            <div class="content-title-actions">
              <button data-tooltip="tooltip" data-title="Toggle Fullscreen" aria-label"Toggle Fullscreen" onclick="toggleFullscreen();"><?php svg('fullscreen');?></button>
              <?php echo$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" data-title="Newsletters Settings" href="'.URL.$settings['system']['admin'].'/newsletters/settings" role="button" aria-label="Newsletters Settings">'.svg2('settings').'</a>':'';?>
              <?php echo$user['options'][0]==1?'<a class="btn add" data-tooltip="tooltip" data-title="Add" href="'.URL.$settings['system']['admin'].'/newsletters/add" role="button" aria-label="Add">'.svg2('add').'</a>':'';?>
            </div>
          </div>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
            <li class="breadcrumb-item active">Newsletters</li>
          </ol>
        </div>
      </div>
      <div class="container-fluid p-0">
        <div class="card border-radius-0 shadow p-3">
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Newsletters</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Subscribers</label>
<?php /* Newsletters */ ?>
            <div class="tab1-1 border-top" role="tabpanel">
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
                    <tr class="item" id="l_<?php echo$r['id'];?>">
                      <td class="align-middle"><a href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
                      <td class="text-center align-middle"><?php echo date($config['dateFormat'],$ti);?></td>
                      <td class="text-center align-middle"><?php echo$r['status']=='unpublished'?'Unpublished':date($config['dateFormat'],$r['tis']);?></td>
                      <td class="align-middle" id="controls_<?php echo$r['id'];?>">
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                          <div class="btn-group" role="group" aria-label="Item Controls">
                            <?php echo$user['options'][1]==1?'<button data-tooltip="tooltip" data-title="Send Newsletters" aria-label="Send Newsletters" onclick="$(`#sp`).load(`core/newsletter.php?id='.$r['id'].'&act=`);">'.svg2('email-send').'</button>':'';?>
                            <a class="btn" data-tooltip="tooltip"<?php echo$user['options'][1]==1?' data-title="Edit" aria-label="Edit"':' data-title="View" aria-label="View"';?> href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>" role="button"><?php echo$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                            <?php if($user['options'][0]==1){?>
                              <button class="<?php echo$r['status']!='delete'?' hidden':'';?>" data-tooltip="tooltip" data-title="Restore" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished');" aria-label="Restore"><?php svg('untrash');?></button>
                              <button class="trash<?php echo$r['status']=='delete'?' hidden':'';?>" data-tooltip="tooltip" data-title="Delete" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete');" aria-label="Delete"><?php svg('trash');?></button>
                              <button class="trash<?php echo$r['status']!='delete'?' hidden':'';?>" data-tooltip="tooltip" data-title="Purge" onclick="purge('<?php echo$r['id'];?>','content');" aria-label="Purge"><?php svg('purge');?></button>
                            <?php }?>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
            <div class="tab1-2 border-top" role="tabpanel">
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
                      <td class="align-middle"><?php echo$r['email'];?></td>
                      <td class="text-right align-middle">
                        <input id="newsletter<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0" type="checkbox"<?php echo($r['newsletter'][0]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][0]==1?'':' disabled');?>>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
              <table class="table-zebra">
                <thead>
                  <tr>
                    <th class="col-xs-6">Email</th>
                    <th class="col-xs-3">Date Signed Up</th>
                    <th class="col-xs-3"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $s=$db->prepare("SELECT `id`,`email`,`ti` FROM `".$prefix."subscribers` ORDER BY `email` ASC");
                  $s->execute();
                  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr id="s_<?php echo$r['id'];?>" class="item">
                      <td><?php echo$r['email'];?></td>
                      <td><?php echo date($config['dateFormat'],$r['ti']);?></td>
                      <td class="align-middle">
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                          <div class="btn-group" role="group" aria-label="Item Controls">
                            <?php echo$user['options'][0]==1?'<button class="trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete" onclick="purge(`'.$r['id'].'`,`subscribers`);">'.svg2('trash').'</button>':'';?>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <?php include'core/layout/footer.php';?>
          <?php }?>
        </div>
      </div>
    </section>
  </main>
