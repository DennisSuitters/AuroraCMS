<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Activity
 * @package    core/layout/activity.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='49'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
            <li class="breadcrumb-item active">Activity</li>
          </ol>
        </div>
        <div class="tabs">
          <div class="border">
            <div class="p-3">
              <div class="form-row">
                <input id="prefAdminActivityTracking" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="12" type="checkbox"<?=($config['options'][12]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                <label for="prefAdminActivityTracking">Admin Activity Tracking</label>
              </div>
            </div>
            <div class="row sticky-top">
              <article class="card py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md-1 text-center pl-1">When</div>
                  <div class="col-12 col-md-2 text-center">User</div>
                  <div class="col-12 col-md-1 text-center">Action</div>
                  <div class="col-12 col-md-1 text-center">dbID</div>
                  <div class="col-12 col-md-1 text-center">Table</div>
                  <div class="col-12 col-md-2 text-center">Column</div>
                  <div class="col-12 col-md pl-2">Data</div>
                  <div class="col-12 col-md-1 pr-2 text-right">
                    <?=($user['options'][7]==1?'<button class="purge btn-sm" data-tooltip="tooltip" aria-label="Purge All" onclick="purge(`0`,`logs`);return false;"><i class="i">purge</i></button>':'');?>
                  </div>
                </div>
              </article>
            </div>
            <div id="l_logs">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."logs` ORDER BY `ti` DESC");
              $s->execute();
              $i=1;
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                $action=[
                  'id'=>$r['id'],
                  'action'=>'',
                  'table'=>'',
                  'column'=>'',
                  'data'=>''
                ];
                if($r['uid']!=0){
                  $su=$db->prepare("SELECT `id`,`username`,`avatar`,`gravatar`,`name`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
                  $su->execute([':id'=>$r['uid']]);
                  $u=$su->fetch(PDO::FETCH_ASSOC);
                }else
                  $u=['id'=>0,'username'=>'Anonymous','avatar'=>'','gravatar'=>'','name'=>'Anonymous','rank'=>1000];
                if($r['action']=='create')$action['action']='<span class="badger badge-success">Created</span>';
                if($r['action']=='update')$action['action']='<span class="badger badge-success">Updated</span><br>';
                if($r['action']=='purge')$action['action']='<span class="badger badge-danger">Purged</span><br>';
                $action['table']=($r['action']=='update'?$r['refTable']:'');
                $action['column']=$r['refColumn'];
                $action['data']='<div><strong>Data:</strong>';
                $action['data'].=(stristr($r['oldda'],'data:image')?'<img src="'.$r['oldda'].'">':strip_tags(rawurldecode(substr($r['oldda'],0,300))));
                $action['data'].='</div>'.
                  '<div><strong>Changed To:</strong>';
                $action['data'].=(stristr($r['newda'],'data:image')?'<img src="'.$r['newda'].'">':strip_tags(rawurldecode(substr($r['newda'],0,300))));
                $action['data'].='</div>';?>
                <article id="l_<?=$r['id'];?>" class="card col-12 zebra mb-0 p-0 overflow-visible card-list item shadow">
                  <div class="row">
                    <div class="col-12 col-md-1 py-2 pl-1 text-center small"><?= _ago($r['ti']);?></div>
                    <div class="col-12 col-md-2 py-2 text-center small"><?=($u['name']==''?$u['username']:$u['name']);?></div>
                    <div class="col-12 col-md-1 py-2 text-center small"><?=$action['action'];?></div>
                    <div class="col-12 col-md-1 py-2 text-center small"><?=$action['id'];?></div>
                    <div class="col-12 col-md-1 py-2 text-center small"><?=$action['table'];?></div>
                    <div class="col-12 col-md-2 py-2 text-center small"><?=$action['column'];?></div>
                    <div class="col-12 col-md-3 py-2 pl-2 small text-wrap"><?=$action['data'];?></div>
                    <div class="col-12 col-md-1 py-2 pr-2 text-right" id="controls_<?=$r['id'];?>">
                      <div class="btn-group" role="group">
                        <?=($user['options'][7]==1?
                          ($r['action']=='update'?
                            '<button class="restore" data-tooltip="tooltip" aria-label="Restore" onclick="restore(`'.$r['id'].'`);"><i class="i">restore</i></button>'
                          :
                            '').
                          '<button class="trash" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`logs`);"><i class="i">trash</i></button>'
                        :
                          '');?>
                      </div>
                    </div>
                  </div>
                </article>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
