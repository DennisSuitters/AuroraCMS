<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Orders
 * @package    core/layout/orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($user['options'][4]==1){
  $uid=isset($_SESSION['uid'])?$_SESSION['uid']:$uid=0;
  $error=0;
  $ti=time();
  $oid='';
  if(isset($args[1]))$id=$args[1];
  if(isset($args[0])&&$args[0]=='duplicate'){
    $sd=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
    $sd->execute([':id'=>$id]);
    $rd=$sd->fetch(PDO::FETCH_ASSOC);
    $s=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`cid`,`uid`,`contentType`,`due_ti`,`notes`,`status`,`recurring`,`ti`) VALUES (:cid,:uid,:contentType,:due_ti,:notes,:status,:recurring,:ti)");
    $s->execute([
      ':cid'=>$rd['cid'],
      ':uid'=>$uid,
      ':contentType'=>$rd['contentType'],
      ':due_ti'=>$ti+$config['orderPayti'],
      ':notes'=>$rd['notes'],
      ':status'=>'outstanding',
      ':recurring'=>$rd['recurring'],
      ':ti'=>$ti
    ]);
    $iid=$db->lastInsertId();
    if($rd['qid']!=''){
      $rd['qid']='Q'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
      $qid_ti=$ti+$config['orderPayti'];
    }else$qid_ti=0;
    if($rd['iid']!=''){
      $rd['iid']='I'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
      $iid_ti=$ti+$config['orderPayti'];
    }else$iid_ti=0;
    $s=$db->prepare("UPDATE `".$prefix."orders` SET `qid`=:qid,`qid_ti`=:qid_ti,`iid`=:iid,`iid_ti`=:iid_ti WHERE `id`=:id");
    $s->execute([
      ':qid'=>$rd['qid'],
      ':qid_ti'=>$qid_ti,
      ':iid'=>$rd['iid'],
      ':iid_ti'=>$iid_ti,
      ':id'=>$iid
    ]);
    $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid");
    $s->execute([':oid'=>$id]);
    while($r=$s->fetch(PDO::FETCH_ASSOC)){
      $so=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`title`,`quantity`,`cost`,`status`,`ti`) VALUES (:oid,:iid,:title,:quantity,:cost,:status,:ti)");
      $so->execute([
        ':oid'=>$iid,
        ':iid'=>$r['iid'],
        ':title'=>$r['title'],
        ':quantity'=>$r['quantity'],
        ':cost'=>$r['cost'],
        ':status'=>$r['status'],
        ':ti'=>$ti
      ]);
    }
    $aid='A'.date("ymd",$ti).sprintf("%06d",$id,6);
    $s=$db->prepare("UPDATE `".$prefix."orders` SET `aid`=:aid,`aid_ti`=:aid_ti WHERE `id`=:id");
    $s->execute([
      ':aid'=>$aid,
      ':aid_ti'=>$ti,
      ':id'=>$id
    ]);
    $args[0]='all';
  }
  if(isset($args[0])&&$args[0]=='addquote'||$args[0]=='addinvoice'){
    $r=$db->query("SELECT MAX(`id`) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
    $dti=$ti+$config['orderPayti'];
    if(isset($args[0])&&$args[0]=='addquote'){
      $oid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
      $q=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`uid`,`qid`,`qid_ti`,`due_ti`,`status`) VALUES (:uid,:qid,:qid_ti,:due_ti,'pending')");
      $q->execute([
        ':uid'=>$uid,
        ':qid'=>$oid,
        ':qid_ti'=>$ti,
        ':due_ti'=>$dti
      ]);
    }
    if(isset($args[0])&&$args[0]=='addinvoice'){
      $oid='I'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
      $s=$db->prepare("INSERT IGNORE INTO `".$prefix."orders` (`uid`,`iid`,`iid_ti`,`due_ti`,`status`) VALUES (:uid,:iid,:iid_ti,:due_ti,'pending')");
      $s->execute([
        ':uid'=>$uid,
        ':iid'=>$oid,
        ':iid_ti'=>$ti,
        ':due_ti'=>$dti
      ]);
    }
    $id=$db->lastInsertId();
    $e=$db->errorInfo();
    $args[0]='edit';?>
    <script>history.replaceState('','','<?= URL.$settings['system']['admin'].'/orders/edit/'.$id;?>');</script>
  <?php }
  if(isset($args[0])&&$args[0]=='to_invoice'){
    $q=$db->prepare("SELECT `qid` FROM `".$prefix."orders` WHERE `id`=:id");
    $q->execute([':id'=>$id]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    $q=$db->prepare("UPDATE `".$prefix."orders` SET `iid`=:iid,`iid_ti`=:iid_ti,`qid`='',`qid_ti`='0' WHERE `id`=:id");
    $q->execute([
      ':iid'=>'I'.date("ymd",$ti).sprintf("%06d",$id,6),
      ':iid_ti'=>$ti,
      ':id'=>$id
    ]);
    $args[0]='invoices';
  }
  if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_orders.php';
  elseif(isset($args[0])&&$args[0]=='edit')require'core/layout/edit_orders.php';
  else{
    if(isset($args[0])&&$args[0]=='all'||$args[0]==''){
      $sort="all";
      if($user['rank']==300){
        $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `aid`='' AND `cid`=:cid ORDER BY `ti` DESC");
        $s->execute([':cid'=>$user['id']]);
      }else{
        $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `aid`='' ORDER BY `ti` DESC");
        $s->execute();
      }
    }
    if(isset($args[0])&&$args[0]=='quotes'){
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`!='' AND `iid`='' AND `aid`='' ORDER BY `ti` DESC");
      $s->execute();
    }
    if(isset($args[0])&&$args[0]=='invoices'){
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`='' AND `iid`!='' ORDER BY `ti` DESC");
      $s->execute();
    }
    if(isset($args[0])&&$args[0]=='archived'){
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `aid`!='' ORDER BY `ti` DESC");
      $s->execute();
    }
    if(isset($args[0])&&$args[0]=='pending'){
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `status`='pending' ORDER BY `ti` DESC");
      $s->execute();
    }
    if(isset($args[0])&&$args[0]=='recurring'){
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `recurring`='1' ORDER BY `ti` DESC");
      $s->execute();
    }
    if(isset($args[0])&&$args[0]=='overdue'){
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `status`='overdue' ORDER BY `ti` DESC");
      $s->execute();
    }?>
    <main>
      <section id="content">
        <div class="content-title-wrapper">
          <div class="content-title">
            <div class="content-title-heading">
              <div class="content-title-icon"><?= svg2('order','i-3x');?></div>
              <div>Orders</div>
              <div class="content-title-actions">
                <?=$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings" role="button" aria-label="Orders Settings">'.svg2('settings').'</a>':'';?>
                <?php if(isset($args[0])&&$args[0]!=''){
                  if($user['options'][4]==1){
                    if(isset($args[0])&&$args[0]=='quotes')echo'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/addquote" role="button" aria-label="Add Quote">'.svg2('add').'</a>';
                    if(isset($args[0])&&$args[0]=='invoices')echo'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/addinvoice" role="button" aria-label="Add Invoice">'.svg2('add').'</a>';
                  }
                }?>
              </div>
            </div>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><?= isset($args[0])&&$args[0]!=''?'<a href="'.URL.$settings['system']['admin'].'/orders">Orders</a>':'Orders';?></li>
              <li class="breadcrumb-item active"><?= isset($args[0])&&$args[0]!=''?ucfirst($args[0]):'All';?></li>
            </ol>
          </div>
        </div>
        <div class="container-fluid p-0">
          <div class="card border-radius-0 overflow-visible shadow">
            <div id="notifications" role="alert"></div>
            <table class="table-zebra" id="stupidtable">
              <thead>
                <tr>
                  <th></th>
                  <th>Order Number</th>
                  <th>Client</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
                  if($r['due_ti']<$ti&&$r['status']!='paid'){
                    $us=$db->prepare("UPDATE `".$prefix."orders` SET `status`='overdue' WHERE `id`=:id AND `status`!='paid'");
                    $us->execute([':id'=>$r['id']]);
                    $r['status']='overdue';
                  }
                  $cs=$db->prepare("SELECT `username`,`name`,`email`,`business`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
                  $cs->execute([':id'=>$r['cid']]);
                  $c=$cs->fetch(PDO::FETCH_ASSOC);?>
                  <tr id="l_<?=$r['id'];?>">
                    <td class="align-middle"><button class="btn-ghost quickeditbtn" data-qeid="<?=$r['id'];?>" data-qet="orders" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><?= svg2('plus').svg2('close','d-none');?></button></td>
                    <td class="align-middle">
                      <a href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$r['id'];?>"><?=$r['aid']!=''?$r['aid'].'<br>':'';echo$r['qid'].$r['iid'];?></a>
                    </td>
                    <td class="align-middle">
                      <?php
                      if(isset($c['username'])&&isset($c['name'])){
                        echo$c['username'].(isset($c['name'])&&$c['name']!=''?' ['.$c['name'].']':'').
                          ':'.
                          ($c['name']!=''&&$c['business']!=''?'<br>':'').
                          ($c['business']!=''?$c['business']:'').
                          (($c['rank']>200&&$c['rank']<300)||($c['rank']>300&&$c['rank']<400)?'<br><small class="badger badge-'.rank($c['rank']).'">'.ucwords(str_replace('-',' ',rank($c['rank']))).'</small>':'');
                      }?>
                    </td>
                    <td class="align-middle">
                      <?=' '.date($config['dateFormat'],($r['iid_ti']==0?$r['qid_ti']:$r['iid_ti']));?><br>
                      <small>Due: <?= date($config['dateFormat'],$r['due_ti']);?></small>
                    </td>
                    <td class="align-middle">
                      <span class="badger badge-<?= $r['status'];?> badge-2x"><?= ucfirst($r['status']);?></span>
                    </td>
                    <td class="align-middle" id="controls_<?=$r['id'];?>">
                      <div class="btn-toolbar float-right" role="toolbar">
                        <div class="btn-group " role="group">
                          <?php if($user['options'][0]==1){
                            echo$r['qid']!=''&&$r['aid']==''?'<a class="btn'.($r['status']=='delete'?' d-none':'').'" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/to_invoice/'.$r['id'].'" role="button" aria-label="Convert to Invoice">'.svg2('order-quotetoinvoice').'</a>':'';
                            echo$r['aid']==''?'<button class="btn archive'.($r['status']=='delete'?' d-none':'').'" data-tooltip="tooltip" aria-label="Archive" onclick="update(\''.$r['id'].'\',\'orders\',\'status\',\'archived\');">'.svg2('archive').'</button>':'';
                          }?>
                          <button class="btn print" data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/email_order.php?id=<?=$r['id'];?>&act=print');"><?= svg2('print');?></button>
                          <?= isset($c['email'])&&$c['email']!=''?'<button class="email" data-tooltip="tooltip" aria-label="Email Order" onclick="$(\'#sp\').load(\'core/email_order.php?id='.$r['id'].'&act=\');">'.svg2('email-send').'</button>':'';
                          echo$user['options'][0]==1?'<a class="btn'.($r['status']=='delete'?' d-none':'').'" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/duplicate/'.$r['id'].'" role="button" aria-label="Duplicate">'.svg2('copy').'</a>':'';?>
                          <a class="btn<?=$user['options'][0]==1?' rounded-right':'';echo$r['status']=='delete'?' d-none':'';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$r['id'];?>" role="button" aria-label="Edit"><?= svg2('edit');?></a>
                          <?php if($user['options'][0]==1){?>
                            <button class="btn add<?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','orders','status','');"><?= svg2('untrash');?></button>
                            <button class="btn trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','orders','status','delete');"><?php svg('trash');?></button>
                            <button class="btn purge trash<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','orders')"><?= svg2('purge');?></button>
                          <?php }?>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr class="quickedit d-none" id="quickedit<?=$r['id'];?>"></tr>
                <?php }?>
              </tbody>
            </table>
            <div class="col-12 mt-0 text-right">
              <small>View:
                <a class="badger badge-<?= !isset($args[0])?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/orders" aria-label="Display All Orders">All</a>&nbsp;
                <a class="badger badge-<?= isset($args[0])&&$args[0]=='quotes'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/orders/quotes" aria-label="Display Quote Orders">Quotes</a>&nbsp;
                <a class="badger badge-<?= !isset($args[0])&&$args[0]=='invoices'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/orders/invoices" aria-label="Display Invoices Orders">Invoices</a>&nbsp;
                <a class="badger badge-<?= !isset($args[0])&&$args[0]=='pending'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/orders/pending" aria-label="Display Pending Orders">Pending</a>&nbsp;
                <a class="badger badge-<?= !isset($args[0])&&$args[0]=='recurring'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/orders/recurring" aria-label="Display Recurring Orders">Recurring</a>&nbsp;
                <a class="badger badge-<?= !isset($args[0])&&$args[0]=='overdue'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/orders/overdue" aria-label="Display Overdue Orders">Overdue</a>&nbsp;
                <a class="badger badge-<?= !isset($args[0])&&$args[0]=='archived'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/orders/archived" aria-label="Display Archived Items">Archived</a>&nbsp;
              </small>
            </div>
            <?php require'core/layout/footer.php';?>
          </div>
        </div>
      </div>
    </section>
<?php }
  }else{?>
    <main>
      <section id="content">
        <div class="content-title-wrapper">
          <div class="content-title">
            <div class="content-title-heading">
              <div class="content-title-icon"><?= svg2('order','i-3x');?></div>
              <div>Orders</div>
              <div class="content-title-actions">
                <button data-tooltip="tooltip" aria-label="Toggle Fullscreen" onclick="toggleFullscreen();"><?= svg2('fullscreen');?></button>
                <?=$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/settings" role="button" aria-label="Orders Settings">'.svg2('settings').'</a>':'';?>
                <?php if($args[0]!=''){
                  if($user['options'][4]==1){
                    if($args[0]=='quotes')echo'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/addquote" role="button" aria-label="Add Quote">'.svg2('add').'</a>';
                    if($args[0]=='invoices')echo'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/orders/addinvoice" role="button" aria-label="Add Invoice">'.svg2('add').'</a>';
                  }
                }?>
              </div>
            </div>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><?= isset($args[0])&&$args[0]!=''?'<a href="'.URL.$settings['system']['admin'].'/orders">Orders</a>':'Orders';?></li>
              <li class="breadcrumb-item active"><?=$args[0]!=''?ucfirst($args[0]):'All';?></li>
            </ol>
          </div>
        </div>
        <div class="container-fluid p-0">
          <div class="card border-radius-0 shadow">
            <div class="alert alert-info" role="alert">You don't have permissions to View this Area!</div>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </section>
    </main>
<?php }
