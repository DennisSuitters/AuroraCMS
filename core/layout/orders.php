<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Orders
 * @package    core/layout/orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='41'");
$sv->execute();
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
    }else
      $qid_ti=0;
    if($rd['iid']!=''){
      $rd['iid']='I'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
      $iid_ti=$ti+$config['orderPayti'];
    }else
      $iid_ti=0;
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
    $q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
    $q->execute([':id'=>$id]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    $oi=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:id");
    $oi->execute([':id'=>$r['id']]);
    $or=$oi->fetch(PDO::FETCH_ASSOC);
    $si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $si->execute([':id'=>$or['iid']]);
    $ri=$si->fetch(PDO::FETCH_ASSOC);
    if($ri['contentType']=='inventory'){
      $qty=$ri['quantity'] - $or['quantity'];
      if($qty<0){
        $s=$db->prepare("UPDATE `".$prefix."content` SET `quantity`=0,`stockStatus`=:sS WHERE `id`=:id");
        $s->execute([
          ':sS'=>$config['inventoryFallbackStatus'],
          ':id'=>$or['iid']
        ]);
        $nqty = abs($ri['quantity'] - $or['quantity']);
        $sn=$db->prepare("INSERT IGNORE INTO `".$prefix."orderitems` (`oid`,`iid`,`cid`,`title`,`quantity`,`cost`,`status`,`points`,`ti`) VALUES (:id,:iid,:cid,:title,:quantity,:cost,:status,:points,:ti)");
        $sn->execute([
          ':id'=>$or['oid'],
          ':iid'=>$or['iid'],
          ':cid'=>$or['cid'],
          ':title'=>$or['title'],
          ':quantity'=>$nqty,
          ':cost'=>$or['cost'],
          ':status'=>$config['inventoryFallbackStatus'],
          ':points'=>0,
          ':ti'=>$or['ti']
        ]);
        $sn=$db->prepare("UPDATE `".$prefix."orderitems` SET `quantity`=:quantity WHERE `id`=:id");
        $sn->execute([
          ':quantity'=>abs($ri['quantity'] - $ro['quantity']),
          ':id'=>$or['id']
        ]);
      }
    }
    $qty=$ri['quantity'] - $or['quantity'];
    $qty2 = abs($qty);
    if($qty<1)$qty2=0;
    $sc=$db->prepare("UPDATE `".$prefix."content` SET `quantity`=:quantity,`stockStatus`=:status WHERE `id`=:id");
    $sc->execute([
      ':quantity'=>$qty2,
      ':id'=>$or['iid'],
      ':status'=>$ri['contentType']=='inventory'?($qty2==0?$config['inventoryFallbackStatus']:$ri['stockStatus']):$ri['stockStatus']
    ]);
    $q=$db->prepare("UPDATE `".$prefix."orders` SET `iid`=:iid,`iid_ti`=:iid_ti,`qid`='',`qid_ti`='0' WHERE `id`=:id");
    $q->execute([
      ':iid'=>'I'.date("ymd",$ti).sprintf("%06d",$id,6),
      ':iid_ti'=>$ti,
      ':id'=>$id
    ]);
    $args[0]='invoices';
  }
  if(isset($args[0])&&$args[0]=='settings')
    require'core/layout/set_orders.php';
  elseif(isset($args[0])&&$args[0]=='edit')
    require'core/layout/edit_orders.php';
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
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
        <div class="container-fluid">
          <div class="card mt-3 bg-transparent border-0 overflow-visible">
            <div class="card-actions">
              <div class="row">
                <div class="col-12 col-sm">
                  <ol class="breadcrumb m-0 pl-0 pt-0">
                    <li class="breadcrumb-item"><?= isset($args[0])&&$args[0]!=''?'<a href="'.URL.$settings['system']['admin'].'/orders">Orders</a>':'Orders';?></li>
                    <li class="breadcrumb-item active"><?= isset($args[0])&&$args[0]!=''?ucfirst($args[0]):'All';?></li>
                  </ol>
                  <div class="text-left">
                    <small>View:
                      <a class="badger badge-<?= !isset($args[0])?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'];?>/orders" data-tooltip="tooltip" aria-label="Display All Orders">All</a>&nbsp;
                      <a class="badger badge-<?= isset($args[0])&&$args[0]=='quotes'?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'];?>/orders/quotes" data-tooltip="tooltip" aria-label="Display Quote Orders">Quotes</a>&nbsp;
                      <a class="badger badge-<?= isset($args[0])&&$args[0]=='invoices'?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'];?>/orders/invoices" data-tooltip="tooltip" aria-label="Display Invoices Orders">Invoices</a>&nbsp;
                      <a class="badger badge-<?= isset($args[0])&&$args[0]=='pending'?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'];?>/orders/pending" data-tooltip="tooltip" aria-label="Display Pending Orders">Pending</a>&nbsp;
                      <a class="badger badge-<?= isset($args[0])&&$args[0]=='recurring'?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'];?>/orders/recurring" data-tooltip="tooltip" aria-label="Display Recurring Orders">Recurring</a>&nbsp;
                      <a class="badger badge-<?= isset($args[0])&&$args[0]=='overdue'?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'];?>/orders/overdue" data-tooltip="tooltip" aria-label="Display Overdue Orders">Overdue</a>&nbsp;
                      <a class="badger badge-<?= isset($args[0])&&$args[0]=='archived'?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'];?>/orders/archived" data-tooltip="tooltip" aria-label="Display Archived Items">Archived</a>
                    </small>
                  </div>
                </div>
                <div class="col-12 col-sm-6 text-right">
                  <div class="form-row justify-content-end">
                    <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
                    <div class="btn-group">
                      <?php echo$user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/orders/settings" role="button" data-tooltip="left" aria-label="Orders Settings"><i class="i">settings</i></a>':'';
                      if(isset($args[0])&&$args[0]!=''){
                        if($user['options'][4]==1){
                          echo(isset($args[0])&&$args[0]=='quotes'?'<a class="btn add" href="'.URL.$settings['system']['admin'].'/orders/addquote" role="button" data-tooltip="left" aria-label="Add Quote"><i class="i">add</i></a>':'').
                          (isset($args[0])&&$args[0]=='invoices'?'<a class="btn add" href="'.URL.$settings['system']['admin'].'/orders/addinvoice" role="button" data-tooltip="left" aria-label="Add Invoice"><i class="i">add</i></a>':'');
                        }
                      }?>
                    </div>
                  <div>
                </div>
              </div>
            </div>
            <div id="notifications" role="alert"></div>
            <section class="content mt-3 overflow-visible list" id="contentview">
              <article class="card mx-2 mt-2 mb-0 p-0 py-2 overflow-visible card-list card-list-header shadow sticky-top">
                <div class="row">
                  <div class="col-12 col-md-3 text-center">Order Number</div>
                  <div class="col-12 col-md-3 text-center">Date</div>
                  <div class="col-12 col-md-2 text-center">Status</div>
                  <div class="col-12 col-md"></div>
                </div>
              </article>
              <?php $zeb=0;
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                if($r['due_ti']<$ti&&$r['status']!='paid'){
                  $us=$db->prepare("UPDATE `".$prefix."orders` SET `status`='overdue' WHERE `id`=:id AND `status`!='paid'");
                  $us->execute([':id'=>$r['id']]);
                  $r['status']='overdue';
                }
                $cs=$db->prepare("SELECT `username`,`name`,`email`,`business`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
                $cs->execute([':id'=>$r['cid']]);
                $c=$cs->fetch(PDO::FETCH_ASSOC);?>
                <article class="card zebra mx-2 mt-2 mb-0 p-2 border-0 overflow-visible shadow" data-content="<?=($r['aid']!=''?'Archived '.$r['aid'].' | ':'').($r['qid']!=''?'Quote '.$r['qid']:'Invoice '.$r['iid']).' '.(isset($c['business'])&&$c['business']!=''?$c['business']:'').' '.(isset($c['name'])&&$c['name']!=''?$c['name']:$c['username']);?>" id="l_<?=$r['id'];?>">
                  <div class="col-3 overflow-visible">
                    <a href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$r['id'];?>"><?=$r['aid']!=''?$r['aid'].'<br>':'';echo$r['qid'].$r['iid'];?></a>
                    <div class="small">Client:&nbsp;
                      <?php if(isset($c['username'])&&isset($c['name'])){
                        echo$c['username'].(isset($c['name'])&&$c['name']!=''?' ['.$c['name'].']':'').
                          ':'.
                        ($c['name']!=''&&$c['business']!=''?'<br>':'').
                        ($c['business']!=''?$c['business']:'');
                      }?>
                    </div>
                  </div>
                  <div class="col-3 overflow-visible pt-2 line-clamp small">
                    <?=' '.date($config['dateFormat'],($r['iid_ti']==0?$r['qid_ti']:$r['iid_ti']));?><br>
                    <small>Due:&nbsp;<?= date($config['dateFormat'],$r['due_ti']);?></small>
                  </div>
                  <div class="col-2 p-2 align-middle justify-content-center">
                    <span class="badger badge-<?= $r['status'];?> badge-2x"><?= ucfirst($r['status']);?></span>
                  </div>
                  <div class="col-sm align-middle">
                    <div id="controls_<?=$r['id'];?>" class="justify-content-end">
                      <div class="btn-toolbar float-right" role="toolbar">
                        <?=($user['options'][4]==1?
                          ($r['qid']!=''&&$r['aid']==''?'<a class="'.($r['status']=='delete'?' d-none':'').'" href="'.URL.$settings['system']['admin'].'/orders/to_invoice/'.$r['id'].'" role="button" data-tooltip="tooltip" aria-label="Convert to Invoice"><i class="i">order-quotetoinvoice</i></a>':'').
                          ($r['aid']==''?'<button class="btn archive'.($r['status']=='delete'?' d-none':'').'" data-tooltip="tooltip" aria-label="Archive" onclick="update(\''.$r['id'].'\',\'orders\',\'status\',\'archived\');"><i class="i">archive</i></button>':'')
                        :'').
                        '<button class="print" data-tooltip="tooltip" aria-label="Print Order" onclick="$(`#sp`).load(`core/email_order.php?id='.$r['id'].'&act=print`);"><i class="i">print</i></button>'.
                        (isset($c['email'])&&$c['email']!=''?'<button class="email" data-tooltip="tooltip" aria-label="Email Order" onclick="$(\'#sp\').load(\'core/email_order.php?id='.$r['id'].'&act=\');"><i class="i">email-send</i></button>':'').
                        ($user['options'][0]==1?'<a class="'.($r['status']=='delete'?' d-none':'').'" href="'.URL.$settings['system']['admin'].'/orders/duplicate/'.$r['id'].'" role="button" data-tooltip="tooltip" aria-label="Duplicate"><i class="i">copy</i></a>':'').
                        '<a class="'.($user['options'][0]==1?' rounded-right':'').($r['status']=='delete'?' d-none':'').'" href="'.URL.$settings['system']['admin'].'/orders/edit/'.$r['id'].'" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
                        ($user['options'][4]==1?
                          '<button class="add'.($r['status']!='delete'?' d-none':'').'" id="untrash'.$r['id'].'" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons(`'.$r['id'].'`,`orders`,`status`,``);"><i class="i">untrash</i></button>'.
                          '<button class="trash'.($r['status']=='delete'?' d-none':'').'" id="delete'.$r['id'].'" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons(`'.$r['id'].'`,`orders`,`status`,`delete`);"><i class="i">trash</i></button>'.
                          '<button class="purge'.($r['status']!='delete'?' d-none':'').'" id="purge'.$r['id'].'" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`orders`)"><i class="i">purge</i></button>'.
                          '<button class="quickeditbtn" data-qeid="'.$r['id'].'" data-qet="orders" data-tooltip="left" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>'
                        :'');?>
                      </div>
                    </div>
                  </div>
                </article>
                <div class="quickedit" id="quickedit<?=$r['id'];?>"></div>
              <?php }?>
            </section>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </div>
    </section>
<?php }
  }else{?>
    <main>
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?> mr-3" id="content">
        <div class="content-title-wrapper bg-aurora">
          <div class="content-title">
            <div class="content-title-heading">
              <ol class="breadcrumb small">
                <li class="breadcrumb-item"><?= isset($args[0])&&$args[0]!=''?'<a href="'.URL.$settings['system']['admin'].'/orders">Orders</a>':'Orders';?></li>
                <li class="breadcrumb-item active"><?=$args[0]!=''?ucfirst($args[0]):'All';?></li>
              </ol>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="card mt-3 bg-transparent border-0">
            <div class="alert alert-info" role="alert">You don't have permissions to View this Area!</div>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </section>
    </main>
<?php }
