<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Newsletters
 * @package    core/layout/newsletters.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]=='add'){
  $q=$db->prepare("INSERT INTO `".$prefix."content` (contentType,status,ti) VALUES ('newsletters','unpublished',:ti)");
  $q->execute([':ti'=>$ti]);
  $args[1]=$db->lastInsertId();
  $args[0]='edit';
  echo'<script>history.replaceState("","","'.URL.$settings['system']['admin'].'/newsletters/edit/'.$args[1].'");</script>';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_newsletters.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_newsletters.php';
else{
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType=:contentType ORDER BY ti DESC, title ASC");
  $s->execute([':contentType'=>'newsletters']);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active">Newsletters</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/newsletters/add';?>" data-tooltip="tooltip" data-placement="left" title="Add" aria-label="Add"><?php svg('add');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-newsletters-newsletters" aria-controls="tab-newsletters-newsletters" role="tab" data-toggle="tab">Newsletters</a></li>
          <li role="presentation" class="nat-item"><a class="nav-link" href="#tab-newsletters-subscribers" aria-controls="tab-newsletters-subscribers" role="tab" data-toggle="tab">Subscribers</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-newsletters-newsletters" role="tabpanel">
            <div id="notification"></div>
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-xs-5">Subject</th>
                    <th class="col-xs-2 text-center">Created</th>
                    <th class="col-xs-2 text-center">Published</th>
                    <th class="col-xs-3"></th>
                  </tr>
                </thead>
                <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>" class="item">
                    <td><a href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
                    <td class="text-center"><?php echo date($config['dateFormat'],$ti);?></td>
                    <td class="text-center"><?php echo$r['status']=='unpublished'?'Unpublished':date($config['dateFormat'],$r['tis']);?></td>
                    <td id="controls_<?php echo$r['id'];?>">
                      <div class="btn-group float-right">
                        <button class="btn btn-secondary" onclick="Pace.restart();$('#sp').load('core/newsletter.php?id=<?php echo$r['id'];?>&act=');" data-tooltip="tooltip" title="Send Newsletters" aria-label="Send Newsletters"><?php svg('email-send');?></button>
                        <a class="btn btn-secondary" href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>" data-tooltip="tooltip" title="Edit" aria-label="Edit"><?php svg('edit');?></a>
<?php   if($r['rank']!=1000){?>
                        <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="Restore" aria-label="Restore"><?php svg('untrash');?></button>
                        <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                        <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-tooltip="tooltip" title="Purge" aria-label="Purge"><?php svg('purge');?></button>
<?php   }?>
                      </div>
                    </td>
                  </tr>
<?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane" id="tab-newsletters-subscribers" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-xs-9">Email</th>
                    <th class="col-xs-3 text-right">Subscribed</th>
                  </tr>
                </thead>
                <tbody>
<?php $s=$db->prepare("SELECT id,email,newsletter FROM `".$prefix."login` WHERE newsletter=1 ORDER BY email ASC, username ASC, name ASC");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr>
                    <td><?php echo$r['email'];?></td>
                    <td class="text-right">
                      <div class="checkbox checkbox-success">
                        <label class="switch switch-label switch-success"><input type="checkbox" id="newsletter<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0"<?php echo$r['newsletter']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                      </div>
                    </td>
                  </tr>
<?php }?>
                </tbody>
              </table>
              <table class="table table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-xs-6">Email</th>
                    <th class="col-xs-3">Date Signed Up</th>
                    <th class="col-xs-3"></th>
                  </tr>
                </thead>
                <tbody>
<?php $s=$db->prepare("SELECT id,email,ti FROM `".$prefix."subscribers` ORDER BY email ASC");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="s_<?php echo$r['id'];?>" class="item">
                    <td><?php echo$r['email'];?></td>
                    <td><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-right">
<?php if($user['rank']>899){?>
                      <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','subscribers')" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
<?php }?>
                    </td>
                  </tr>
<?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
<?php }?>
    </div>
  </div>
</main>
