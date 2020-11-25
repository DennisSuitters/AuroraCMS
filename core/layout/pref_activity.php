<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Activity
 * @package    core/layout/pref_activity.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('activity','i-3x');?></div>
          <div>Preferences - Activity</div>
          <div class="content-title-actions">
            <button data-tooltip="tooltip" data-title="Toggle Fullscreen" aria-label"Toggle Fullscreen" onclick="toggleFullscreen();"><?php svg('fullscreen');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Activity</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow overflow-visible">
        <?php echo$config['options'][12]!=1?'<div class="alert alert-info">Administration Activity Tracking is Disabled.</div>':'';
        if($config['options'][12]==1){?>
          <table class="table-zebra">
            <thead>
              <tr>
                <th class="col--5"></th>
                <th class="col-2-5"></th>
                <th class="col-7"></th>
                <th class="col-2">
                  <div class="btn-group float-right">
                    <button class="trash" data-tooltip="tooltip" data-title="Purge All" onclick="purge('0','logs');return false;"><?php svg('purge');?></button>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody id="l_logs">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."logs` ORDER BY `ti` DESC");
              $s->execute();
              $i=1;
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                $action='';
                if($r['refTable']=='content'){
                  $sql=$db->prepare("SELECT * FROM ".$prefix.$r['refTable']." WHERE `id`=:rid");
                  $sql->execute([
                    ':rid'=>$r['rid']
                  ]);
                  $c=$sql->fetch(PDO::FETCH_ASSOC);
                }
                if($r['uid']!=0){
                  $su=$db->prepare("SELECT `id`,`username`,`avatar`,`gravatar`,`name`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
                  $su->execute([
                    ':id'=>$r['uid']
                  ]);
                  $u=$su->fetch(PDO::FETCH_ASSOC);
                }else$u=['id'=>0,'username'=>'Anonymous','avatar'=>'','gravatar'=>'','name'=>'Anonymous','rank'=>1000];
                $action.='<strong>Action:</strong> ';
                if($r['action']=='create')$action.=' <span class="badger badge-success">Created</span><br>';
                if($r['action']=='update')$action.=' <span class="badger badge-success">Updated</span><br>';
                if($r['action']=='purge')$action.=' <span class="badger badge-danger">Purged</span><br>';
                if(isset($c['title'])&&$c['title']!='')$action.='<strong>Title:</strong> '.$c['title'].'<br>'.($r['action']=='update'?'<strong>Table:</strong> '.$r['refTable'].'<br>':'').'<strong>Column:</strong> '.$r['refColumn'].'<br>'.'<strong>Data:</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>'.'<strong>Changed To:</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
                if(isset($u['avatar'])&&$u['avatar']!='')$image=file_exists('media'.DS.'avatar'.DS.basename($u['avatar']))?'media'.DS.'avatar'.DS.basename($u['avatar']):NOAVATAR;
                elseif(isset($u['gravatar'])&&$u['gravatar']!='')$image=$u['gravatar'];
                else$image=NOAVATAR;?>
                <tr id="l_<?php echo$r['id'];?>">
                  <td><img src="<?php echo$image;?>" alt="Picture"></td>
                  <td class="small"><?php echo _ago($r['ti']).' <strong>by</strong> '.($u['name']==''?$u['username']:$u['name']);?></td>
                  <td class="small"><?php echo$action;?></td>
                  <td class="align-top" id="controls_<?php echo$r['id'];?>">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                      <div class="btn-group" role="group" aria-label="Item Controls">
                        <?php echo$r['action']=='update'?'<button data-tooltip="tooltip" data-title="Restore" aria-label="Restore" onclick="restore(\''.$r['id'].'\');">'.svg2('undo').'</button>':'';?>
                        <button class="trash" data-tooltip="tooltip" data-title="Purge" aria-label="Purge" onclick="purge('<?php echo$r['id'];?>','logs');"><?php svg('trash');?></button>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        <?php }?>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
