<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Orders - Edit
 * @package    core/layout/edit_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
$q->execute([':id'=>$id]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([':id'=>$r['cid']]);
if($q->rowCount()>0)
  $client=$q->fetch(PDO::FETCH_ASSOC);
else{
  $client=[
    'id'=>0,
    'options'=>00000000000000000000000000000000,
    'rank'=>0,
    'purchaseLimit'=>0,
    'spent'=>0,
    'points'=>0,
    'pti'=>0,
    'username'=>'',
    'name'=>'',
    'business'=>'',
    'email'=>'',
    'phone'=>'',
    'mobile'=>'',
    'address'=>'',
    'suburb'=>'',
    'city'=>'',
    'state'=>'',
    'postcode'=>0
  ];
}
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([':id'=>$r['uid']]);
$usr=$q->fetch(PDO::FETCH_ASSOC);
if($r['notes']==''){
  $r['notes']=$config['orderEmailNotes'];
  $q=$db->prepare("UPDATE `".$prefix."orders` SET `notes`=:notes WHERE `id`=:id");
  $q->execute([
    ':notes'=>$config['orderEmailNotes'],
    ':id'=>$r['id']
  ]);
}
if($error==1)
  echo'<div class="alert alert-danger" role="alert">'.$e[0].'</div>';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card col-12 col-sm mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
                  <li class="breadcrumb-item">
                    <?php if(isset($r['aid'])&&$r['aid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/archived">Archived</a>';
                    elseif(isset($r['iid'])&&$r['iid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/invoices">Invoices</a>';
                    elseif($r['qid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/quotes">Quotes</a>';?>
                  </li>
                  <li class="breadcrumb-item active"><span id="ordertitle"><?=$r['qid'].$r['iid'];?></span></li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                  '<button data-tooltip="left" aria-label="Print Order" onclick="$(`#sp`).load(`core/email_order.php?id='.$r['id'].'&act=print`);return false;"><i class="i">print</i></button>'.
                  '<button data-tooltip="left" aria-label="Email Order" onclick="$(`#sp`).load(`core/email_order.php?id='.$r['id'].'&act=`);return false;"><i class="i">email-send</i></button>'.
                  '<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>';?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h4>Details</h4>
              <div class="row">
                <div class="col-12 col-sm-3">
                  <div class="input-text border-bottom-left-radius-0 border-right-radius-0"><strong>Order #</strong><a target="_blank" href="<?= URL.'orders/'.($r['iid']==''?$r['qid']:$r['iid']);?>"><?=$r['iid']==''?$r['qid']:$r['iid'].' <i class="i">new-window</i>';?></a></div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="input-text border-radius-0"><strong>Created:</strong>&nbsp;<?=$r['iid_ti']!=0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']);?></div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="input-text py-0 border-radius-0"><strong>Due:</strong>&nbsp;
                    <input class="border-0" id="due_ti" type="date" value="<?= date('Y-m-d',$r['due_ti']);?>"<?php if($r['status']!='archived'){?> autocomplete="off" data-tooltip="tooltip" aria-label="Order Due Date" onchange="update(`<?=$r['id'];?>`,`orders`,`due_ti`,getTimestamp(`due_ti`));"<?php }?>>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <?php if($r['status']=='archived'||$r['status']=='paid')
                    echo'<div class="input-text border-left-radius-0 border-bottom-right-radius-0"><strong>Status:</strong>&nbsp;<span class="badger badge-'.$r['status'].'">'.ucfirst($r['status']).'</span>';
                  else{?>
                    <div class="input-text py-0 pr-0 border-left-radius-0 border-bottom-right-radius-0"><strong>Status:</strong>&nbsp;
                      <select class="border-0" id="status_<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Order Status" onchange="update('<?=$r['id'];?>','orders','status',$(this).val(),'select');">
                        <option value="pending"<?=$r['status']=='pending'?' selected':'';?>>Pending</option>
                        <option value="overdue"<?=$r['status']=='overdue'?' selected':'';?>>Overdue</option>
                        <option value="cancelled"<?=$r['status']=='cancelled'?' selected':'';?>>Cancelled</option>
                        <option value="paid"<?=$r['status']=='paid'?' selected':'';?>>Paid</option>
                      </select>
                    </div>
                  <?php }?>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm">
                  <div class="input-text border-top-left-radius-0 border-right-radius-0"><strong>Rank:</strong>&nbsp;<span id="clientRank" class="badger badge-<?= rank($client['rank']);?>"><?= ucwords(rank($client['rank']));?></span></div>
                </div>
                <div class="col-12 col-sm">
                  <div class="input-text border-radius-0">
                    <?php if($client['purchaseLimit']==0){
                      if($client['rank']==200)$client['purchaseLimit']=$config['memberLimit'];
                      if($client['rank']==210)$client['purchaseLimit']=$config['memberLimitSilver'];
                      if($client['rank']==220)$client['purchaseLimit']=$config['memberLimitBronze'];
                      if($client['rank']==230)$client['purchaseLimit']=$config['memberLimitGold'];
                      if($client['rank']==240)$client['purchaseLimit']=$config['memberLimitPurchase'];
                      if($client['rank']==310)$client['purchaseLimit']=$config['memberLimitSilver'];
                      if($client['rank']==320)$client['purchaseLimit']=$config['memberLimitBronze'];
                      if($client['rank']==330)$client['purchaseLimit']=$config['memberLimitGold'];
                      if($client['rank']==340)$client['purchaseLimit']=$config['memberLimitPlatinum'];
                      if($client['purchaseLimit']==0)$client['purchaseLimit']='No Limit';
                    }?>
                    <strong>Purchase Limit:</strong>&nbsp;<span id="clientPurchaseLimit"><?=$client['purchaseLimit'];?></span>
                  </div>
                </div>
                <div class="col-12 col-sm">
                  <div class="input-text border-radius-0"><strong>Spent:</strong>&nbsp;$<span id="clientSpent"><?=$client['spent'];?></span></div>
                </div>
                <div class="col-12 col-sm">
                  <div class="input-text border-radius-0"><strong>Points Earned:</strong>&nbsp;<span id="clientPoints"><?= number_format((float)$client['points']);?></span></div>
                </div>
                <div class="col-12 col-sm">
                  <div class="input-text border-left-radius-0 border-top-right-radius-0"><strong>Last Purchase:</strong>&nbsp;<span id="clientpti"><?= _ago($client['pti']);?></span></div>
                </div>
              </div>
              <legend class="mt-3 h5">Payment Details</legend>
              <?php if($r['status']=='paid'){?>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <div class="input-text border-bottom-left-radius-0 border-right-radius-0"><strong>Paid Via:</strong>&nbsp; <?= ucwords($r['paid_via']);?></div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="input-text border-left-radius-0 border-bottom-right-radius-0"><strong>Transaction ID:</strong>&nbsp;<?=$r['txn_id'];?></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="input-text border-top-left-radius-0 border-right-radius-0"><strong>Date Paid:</strong>&nbsp;<?=$r['paid_ti']>0?date($config['dateFormat'],$r['paid_ti']):'';?></div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="input-text border-radius-0"><strong>Name:</strong>&nbsp;<?=$r['paid_name'];?></div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="input-text border-left-radius-0 border-top-right-radius-0"><strong>Email:</strong>&nbsp;<?=$r['paid_email'];?></div>
                  </div>
                </div>
              <?php }else{?>
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="input-text py-0"><strong>Paid Via:</strong>&nbsp;
                      <select class="border-0" id="status" data-tooltip="tooltip" aria-label="Paid Via" onchange="update('<?=$r['id'];?>','orders','paid_via',$(this).val(),'select');">
                        <option value="">Select an Option</option>
                        <option value="bank deposit"<?=$r['paid_via']=='bank deposit'?' selected':'';?>>Bank Deposit</option>
                        <option value="bank transfer"<?=$r['paid_via']=='bank transfer'?' selected':'';?>>Bank Transfer</option>
                        <option value="cash"<?=$r['paid_via']=='cash'?' selected':'';?>>Cash</option>
                        <option value="cash on delivery"<?=$r['paid_via']=='cash on delivery'?' selected':'';?>>Cash On Delivery</option>
                        <option value="credit card"<?=$r['paid_via']=='credit card'?' selected':'';?>>Credit Card</option>
                        <option value="paypal"<?=$r['paid_via']=='paypal'?' selected':'';?>>PayPal</option>
                        <option value="stripe"<?=$r['paid_via']=='stripe'?' selected':'';?>>Stripe</option>
                        <option value="afterpay"<?=$r['paid_via']=='afterpay'?' selected':'';?>>AfterPay</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="input-text py-0"><strong>Transaction ID:</strong>&nbsp;
                      <input class="textinput border-0" id="txn_id" data-dbid="<?=$r['id'];?>" data-dbt="orders" data-dbc="txn_id" type="text" value="<?=$r['txn_id'];?>" placeholder="Enter a Transaction Code...">
                      <?=$user['options'][1]==1?'<button class="save border-0" id="savetxn_id" data-dbid="txn_id" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-md">
                    <div class="input-text py-0"><strong>Paid Date:</strong>&nbsp;
                      <input class="border-0" id="paid_ti" type="datetime-local" value="<?=$r['paid_ti']>0?date('Y-m-d\TH:i',$r['paid_ti']):'';?>" autocomplete="off" data-tooltip="tooltip" aria-label="Order Due Date" onchange="update(`<?=$r['id'];?>`,`orders`,`paid_ti`,getTimestamp(`paid_ti`));">
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md">
                    <div class="input-text py-0"></strong>Name:<strong>&nbsp;
                      <input class="textinput border-0" id="paid_name" data-dbid="<?=$r['id'];?>" data-dbt="orders" data-dbc="paid_name" type="text" value="<?=$r['paid_name'];?>" placeholder="Enter a Name...">
                      <?=$user['options'][1]==1?'<button class="save border-0" id="savepaid_name" data-dbid="paid_name" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md">
                    <div class="input-text py-0"></strong>Email:<strong>&nbsp;
                      <input class="textinput border-0" id="paid_email" data-dbid="<?=$r['id'];?>" data-dbt="orders" data-dbc="paid_email" type="text" value="<?=$r['paid_email'];?>" placeholder="Enter an Email...">
                      <?=$user['options'][1]==1?'<button class="save border-0" id="savepaid_email" data-dbid="paid_email" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                    </div>
                  </div>
                </div>
              <?php }?>
              <legend class="mt-3 h5">Tracking Details</legend>
              <div class="row">
                <div class="col-12 col-sm">
                  <div class="input-text py-0 pr-0 border-right-radius-0"><strong>Service</strong>&nbsp;
                    <select class="border-0" id="status" data-tooltip="tooltip" aria-label="Tracking Service" onchange="update('<?=$r['id'];?>','orders','trackOption',$(this).val(),'select');">
                      <option value="">Select a Tracking Service</option>
                      <?php $sto=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='trackoption' ORDER BY `title` ASC");
                      $sto->execute();
                      while($rto=$sto->fetch(PDO::FETCH_ASSOC)){
                        echo'<option value="'.$rto['id'].'"'.($rto['id']==$r['trackOption']?' selected':'').'>'.$rto['title'].'</option>';
                      }?>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-sm">
                  <div class="input-text py-0 pr-0 border-left-radius-0"><strong>Tracking #</strong>&nbsp;
                    <input class="textinput border-0" id="trackNumber" data-dbid="<?=$r['id'];?>" data-dbt="orders" data-dbc="trackNumber" type="text" value="<?=$r['trackNumber'];?>" placeholder="Enter a Tracking Number...">
                    <?=$user['options'][1]==1?'<button class="save border-0" id="savetrackNumber" data-dbid="trackNumber" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row mt-3">
            <div class="col-12 col-sm">
              <h4>From</h4>
              <p>
                <?='<strong>'.$config['business'].'</strong><br>'.
                '<small>'.
                  ($config['abn']!=''?'ABN: '.$config['abn'].'<br>':'').
                  ($config['email']!=''?'Email: '.$config['email'].'<br>':'').
                  ($config['phone']!=''?'Phone: '.$config['phone'].'<br>':'').
                  ($config['mobile']!=''?'Mobile: '.$config['mobile'].'<br>':'').
                  $config['address'].', '.$config['suburb'].', '.$config['city'].'<br>'.
                  $config['state'].($config['postcode']!=0?', '.$config['postcode']:'').
                '</small>';?>
              </p>
            </div>
            <div class="col-12 col-sm text-right">
              <h4>To</h4>
              <p id="to">
                <?='<strong>'.$client['username'].($client['name']!=''?' ['.$client['name'].']':'').'<br>'.
                ($client['business']!=''?' -> '.$client['business'].'<br>':'').'</strong>'.
                '<small>'.
                  ($client['email']!=''?'Email: '.$client['email'].'<br>':'').
                  ($client['phone']!=''?'Phone: '.$client['phone'].'<br>':'').
                  ($client['mobile']!=''?'Mobile: '.$client['mobile'].'<br>':'').
                  $client['address'].', '.$client['suburb'].', '.$client['city'].'<br>'.
                  $client['state'].', '.($client['postcode']!=0?', '.$client['postcode']:'').
                '</small>';?>
              </p>
              <?php if($r['status']!='archived'){?>
                <div class="form-row">
                  <div class="input-text">Client</div>
                  <select id="changeClient" data-tooltip="tooltip" aria-label="Select a Client..." onchange="changeClient($(this).val(),'<?=$r['id'];?>');">
                    <option value="0"<?=$r['cid']=='0'?' selected':'';?>>None</option>
                    <?php $q=$db->query("SELECT `id`,`business`,`username`,`name` FROM `".$prefix."login` WHERE `status`!='delete' AND `status`!='suspended' AND `id`!='0'");
                    if($q->rowCount()>0){
                      while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($r['cid']==$rs['id']?' selected':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business'].'</option>':'');
                    }?>
                  </select>
                </div>
              <?php }?>
            </div>
            <?php if($r['status']!='archived'){?>
              <form class="form-row" target="sp" method="post" action="core/updateorder.php">
                <input name="act" type="hidden" value="additem">
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <input name="t" type="hidden" value="orderitems">
                <input name="c" type="hidden" value="">
                <div class="input-text">Inventory/Services/Events/Courses</div>
                <select name="da" data-tooltip="tooltip" aria-label="Select Product, Service, Event or Empty Entry">
                  <option value="0">Add Empty Entry...</option>
                  <option value="neg">Add Deducation Entry...</option>
                  <?php $s=$db->query("SELECT `id`,`contentType`,`code`,`cost`,`title` FROM `".$prefix."content` WHERE `contentType`='inventory' OR `contentType`='service' OR `contentType`='events' OR `contentType`='course' OR `contentType`='advert' ORDER BY `contentType` ASC, `code` ASC");
                  if($s->rowCount()>0){
                    while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';
                  }?>
                </select>
                <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
              </form>
              <div class="row">
                <small class="form-text text-muted">Note: Adding or removing items does not recalculate Postage Costs, you will need to do that manually with the selection below</small>
              </div>
              <?php $sp=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' ORDER BY `title` ASC");
              $sp->execute();
              if($sp->rowCount()>0){?>
                <form class="form-row" target="sp" method="post" action="core/updateorder.php">
                  <input name="act" type="hidden" value="addpostoption">
                  <input name="id" type="hidden" value="<?=$r['id'];?>">
                  <input name="t" type="hidden" value="orders">
                  <input name="c" type="hidden" value="postageOption">
                  <div class="input-text">Postage Options</div>
                  <select name="da" data-tooltip="tooltip" aria-label="Select Postage Option or Empty Entry" onchange="$('.page-block').addClass('d-block');this.form.submit();">
                    <option value="0">Clear Postage Option and Cost</option>
                    <?php while($rp=$sp->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rp['id'].'">'.$rp['title'].($rp['value']>0?' : $'.$rp['value']:'').'</option>';?>
                  </select>
                </form>
              <?php }
            }?>
            <table class="table zebra">
              <thead>
                <tr class="bg-black text-white">
                  <th style="width:30px;">
                    <input type="checkbox" id="itemchecker" onclick="itemstoggle(this,'toggle');">
                  </th>
                  <th>Code</th>
                  <th class="col text-left">Title</th>
                  <th class="col-1">Option</th>
                  <th class="col-1 text-center">Quantity</th>
                  <th class="col-1 text-center">Cost</th>
                  <th class="col-1 text-right">GST</th>
                  <th class="col-1 text-right">Total</th>
                  <th class="col-1 align-middle">
                    <form target="sp" type="post" action="core/updateorder.php">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input id="actionda" name="da" type="hidden" value="">
                      <select class="pull-right text-black select-sm" id="action" name="act" onchange="actionItems();this.form.submit();">
                        <option value="0" selected hidden>Action</option>
                        <option value="removeItems">Remove Selected Items</option>
                        <option value="newQuote">Create New Quote with Selected Items</option>
                        <option value="newInvoice">Create New Invoice with Selected Items</option>
                        <option value="statusAvailable">Change Selected Items Status to "Available"</option>
                        <option value="statusPreorder">Change Selected Items Status to "Pre Order"</option>
                        <option value="statusBackorder">Change Selected Items Status to "Back Order"</option>
                      </select>
                    </form>
                    <script>
                      function actionItems(){
                        var items=$.map($('input[name="item"]:checked'),function(c){return c.value;});
                        $('#actionda').val(items);
                        $('#itemchecker').prop("checked",false);
                      }
                    </script>
                  </th>
                </tr>
              </thead>
              <tbody id="updateorder">
                <?php $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `status` ASC, `ti` ASC,`title` ASC");
                $s->execute([':oid'=>$r['id']]);
                $total=0;
                while($oi=$s->fetch(PDO::FETCH_ASSOC)){
                  $is=$db->prepare("SELECT `id`,`thumb`,`file`,`fileURL`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $is->execute([':id'=>$oi['iid']]);
                  $i=$is->fetch(PDO::FETCH_ASSOC);
                  $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
                  $sc->execute([':id'=>$oi['cid']]);
                  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
                  <tr class="<?=($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?'bg-warning':'');?>">
                    <td class="align-middle">
                      <input type="checkbox" class="orderitems" name="item" value="<?=$oi['id'];?>">
                    </td>
                    <td class="text-left align-middle small px-0"><?=(isset($i['code'])?$i['code']:'');?></td>
                    <td class="text-left align-middle px-0">
                      <?php if($r['iid_ti']!=0)
                        echo($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?ucwords($oi['status']).': ':'').$oi['title'];
                      else{?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="title">
                          <input name="id" type="hidden" value="<?=$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="title">
                          <input name="da" type="text" value="<?=($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?ucwords($oi['status']).': ':'').$oi['title'];?>">
                        </form>
                      <?php }?>
                    </td>
                    <td class="text-left align-middle px-0"><?= isset($c['title'])?$c['title']:'';?></td>
                    <td class="text-center align-middle px-0">
                      <?php if($oi['iid']!=0){?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="quantity">
                          <input name="id" type="hidden" value="<?=$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="quantity">
                          <input class="text-center" name="da" type="text" value="<?=$oi['quantity'];?>"<?=$r['status']=='archived'?' readonly':'';?>>
                        </form>
                      <?php }else{
                        if($r['iid']!=0)echo$oi['quantity'];
                      }?>
                    </td>
                    <td class="text-right align-middle px-0">
                      <?php if($r['iid_ti']!=0){
                        echo number_format((float)$oi['cost'],2,'.','');
                      }else{?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="cost">
                          <input name="id" type="hidden" value="<?=$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="cost">
                          <input class="text-center" style="min-width:80px" name="da" value="<?= number_format((float)$oi['cost'],2,'.','');?>"<?=$r['status']=='archived'?' readonly':'';?>>
                        </form>
                      <?php }?>
                    </td>
                    <td class="text-right align-middle px-0">
                      <?php $gst=0;
                      if($oi['status']!='pre order'||$oi['status']!='back order'){
                        if($config['gst']>0){
                          $gst=$oi['cost']*($config['gst']/100);
                          if($oi['quantity']>1)$gst=$gst*$oi['quantity'];
                          $gst=number_format((float)$gst,2,'.','');
                        }
                        echo$gst>0?$gst:'';
                      }?>
                    </td>
                    <td class="text-right align-middle px-0">
                      <?php if($oi['status']!='pre order'||$oi['status']!='back order'){
                        echo$oi['iid']!=0?number_format((float)$oi['cost']*$oi['quantity']+$gst,2,'.',''):'';
                      }else{
                        echo'<small>'.($oi['status']=='pre order'?'Pre Order':'Back Order').'</small>';
                      }?>
                    </td>
                    <td class="align-middle text-right px-0">
                      <form target="sp" method="post" action="core/updateorder.php">
                        <input name="act" type="hidden" value="trash">
                        <input name="id" type="hidden" value="<?=$oi['id'];?>">
                        <input name="t" type="hidden" value="orderitems">
                        <input name="c" type="hidden" value="quantity">
                        <input name="da" type="hidden" value="0">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    </td>
                  </tr>
                  <?php if($oi['status']!='pre order'||$oi['status']!='back order'){
                    if($oi['iid']!=0){
                      $total=$total+($oi['cost']*$oi['quantity'])+$gst;
                      $total=number_format((float)$total,2,'.','');
                    }
                  }
                }
                $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
                $sr->execute([':rid'=>$r['rid']]);
                $reward=$sr->fetch(PDO::FETCH_ASSOC);?>
                <tr>
                  <td class="text-right align-middle px-0" colspan="2"><div class="input-text">Rewards</div></td>
                  <form class="form-row" id="rewardsinput" target="sp" method="post" action="core/updateorder.php">
                    <td class="text-center px-0" colspan="1">
                      <input name="act" type="hidden" value="reward">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input name="t" type="hidden" value="orders">
                      <input name="c" type="hidden" value="rid">
                      <?php $ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `code` ASC, `title` ASC");
                      $ssr->execute();
                      if($ssr->rowCount()>0){?>
                        <select onchange="$('#rewardselect').val($(this).val());$('#rewardsinput:first').submit();">
                          <option value="">Rewards Codes</option>
                          <?php while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){?>
                            <option value="<?=$srr['code'];?>"<?=$srr['code']==$reward['code']?' selected':'';?>><?=$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off';?></option>
                          <?php }?>
                        </select>
                      <?php }?>
                    </td>
                    <td class="align-middle px-0" colspan="3">
                      <input id="rewardselect" name="da" type="text" value="<?=$sr->rowCount()==1?$reward['code']:'';?>" onchange="$('#rewardsinput:first').submit();">
                    </td>
                  </form>
                </td>
                <td class="text-center align-middle px-0">
                  <?php if($sr->rowCount()==1){
                    if($reward['method']==1){
                      echo'$';
                      $total=$total-$reward['value'];
                    }
                    echo$reward['value'];
                    if($reward['method']==0){
                      echo'%';
                      $total=($total*((100-$reward['value'])/100));
                    }
                    $total=number_format((float)$total,2,'.','');
                    echo' Off';
                  }?>
                </td>
                <td class="text-right align-middle px-0"><?=(isset($reward['value'])?($reward['value']>0?$total:''):'');?></td>
                <td>&nbsp;</td>
              </tr>
              <?php if($config['options'][26]==1){
                $dedtot=0;
                $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
                $sd->execute([
                  ':f'=>$client['spent'],
                  ':t'=>$client['spent']
                ]);
                if($sd->rowCount()>0){
                  $rd=$sd->fetch(PDO::FETCH_ASSOC);
                  if($rd['value']==1)$dedtot=$rd['cost'];
                  if($rd['value']==2)$dedtot=$total*($rd['cost']/100);
                  $total=$total - $dedtot;?>
                  <tr>
                    <td class="align-middle text-right px-0" colspan="2"><div class="input-text">Spent</div></td>
                    <td class="align-middle" colspan="5">&#36;<?=$client['spent'];?> within Discount Range &#36;<?=$rd['f'].'-&#36;'.$rd['t'];?> granting <?=($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost'].' Off');?></td>
                    <td class="text-right align-middle px-0">-<?=$dedtot;?></td>
                    <td>&nbsp;</td>
                  </tr>
                <?php }
              }?>
              <tr>
                <td class="text-right align-middle px-0" colspan="2"><div class="input-text">Shipping</div></td>
                <td class="align-middle px-0" colspan="1">
                  <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                    <input name="act" type="hidden" value="postselect">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="orders">
                    <input name="c" type="hidden" value="postageCode">
                    <select name="da">
                      <option value="">Shipping Options</option>
                      <option value="AUS_PARCEL_REGULAR">Australia Post Regular Post</option>
        							<option value="AUS_PARCEL_EXPRESS">Australia Post Express Post</option>
                      <?php $spo=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postageoption' ORDER BY `title` ASC");
                      if($spo->rowCount()>0){
                        while($rpo=$spo->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rpo['id'].'">'.$rpo['title'].'</option>';
                      }?>
                    </select>
                  </form>
                </td>
                <td class="text-right align-middle px-0" colspan="4">
                  <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                    <input name="act" type="hidden" value="postoption">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="orders">
                    <input name="c" type="hidden" value="postageOption">
                    <input name="da" type="text" value="<?=$r['postageOption'];?>">
                  </form>
                </td>
                <td class="text-right px-0">
                  <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                    <input name="act" type="hidden" value="postcost">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="orders">
                    <input name="c" type="hidden" value="postageCost">
                    <input class="text-right" name="da" type="text" value="<?=$r['postageCost'];?>">
                    <?php if($r['postageCost']>0){
                      $total=$total+$r['postageCost'];
                      $total=number_format((float)$total, 2, '.', '');
                    }?>
                  </form>
                </td>
                <td></td>
              </tr>
              <tr>
                <td class="text-right align-middle px-0" colspan="2"><div class="input-text">Payment</div></td>
                <td class="align-middle px-0" colspan="1">
                  <?php $spo=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='payoption' ORDER BY title ASC");
                  if($spo->rowCount()>0){?>
                    <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                      <input name="act" type="hidden" value="payselect">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input name="t" type="hidden" value="orders">
                      <input name="c" type="hidden" value="payOption">
                      <select name="da">
                        <option value="0">Payment Options</option>
                        <?php while($rpo=$spo->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rpo['id'].'">'.$rpo['title'].($rpo['value']!=0?' (Surcharge '.($rpo['type']==1?$rpo['value'].'%':'$'.$rpo['value']).')':'').'</option>';?>
                      </select>
                    </form>
                  <?php }?>
                </td>
                <td class="text-right align-middle px-0" colspan="3">
                  <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                    <input name="act" type="hidden"value="paytext">
                    <input name="id" type="hidden"value="<?=$r['id'];?>">
                    <input name="t" type="hidden"value="orders">
                    <input name="c" type="hidden"value="payOption">
                    <input name="da" type="text" value="<?=$r['payOption'];?>">
                  </form>
                </td>
                <td class="text-right align-middle px-0">
                  <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                    <input name="act" type="hidden" value="paymethod">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="orders">
                    <input name="c" type="hidden" value="payMethod">
                    <select class="pl-1 pr-1" name="da">
                      <option value="2"<?=$r['payMethod']==2?' selected':'';?>>Add &#36;</option>
                      <option vlaue="1"<?=$r['payMethod']==1?' selected':'';?>>Add &#37;</option>
                    </select>
                  </form>
                  <?php if($r['payMethod']==1){
                    $paytot=$total*($r['payCost']/100);
                  }else{
                    $paytot=$r['payCost'];
                  }?>
                </td>
                <td class="align-middle text-right px-0">
                  <?php if($r['payMethod']==2){?>
                    <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                      <input name="act" type="hidden" value="paycost">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input name="t" type="hidden" value="orders">
                      <input name="c" type="hidden" value="payCost">
                      <input class="text-right" name="da" type="text" value="<?= number_format((float)$paytot,2,'.','');?>">
                    </form>
                  <?php }else echo number_format((float)$paytot,2,'.','');
                  $total=$total+$paytot;
                  $total=number_format((float)$total,2,'.','');?>
                </td>
                <td></td>
              </tr>
              <tr>
                <td class="text-right font-weight-bold" colspan="7">Total</td>
                <td class="total text-right font-weight-bold border-2 border-black border-left-0 border-right-0 px-0"><?=$total;?></td>
                <td>&nbsp;</td>
              </tr>
              <?php $su=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE `id`=:id");
              $su->execute([
                ':id'=>$r['id'],
                ':total'=>$total
              ]);
              $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
              $sn->execute([':oid'=>$r['id']]);
              if($sn->rowCount()>0){
                while($rn=$sn->fetch(PDO::FETCH_ASSOC)){?>
                  <tr>
                    <td class="small align-middle px-0" colspan="2"><small><?= date($config['dateFormat'],$rn['ti']);?></small></td>
                    <td class="align-middle px-0" colspan="5">
                      <form target="sp" method="post" action="core/updateorder.php">
                        <input name="act" type="hidden" value="title">
                        <input name="id" type="hidden" value="<?=$rn['id'];?>">
                        <input name="t" type="hidden" value="orderitems">
                        <input name="c" type="hidden" value="title">
                        <div class="form-row">
                          <input name="da" type="text" value="<?=$rn['title'];?>">
                          <div class="input-text">minus</div>
                        </div>
                      </form>
                    </td>
                    <td class="text-right align-middle px-0">
                      <form target="sp" method="post" action="core/updateorder.php">
                        <input name="act" type="hidden" value="cost">
                        <input name="id" type="hidden" value="<?=$rn['id'];?>">
                        <input name="t" type="hidden" value="orderitems">
                        <input name="c" type="hidden" value="cost">
                        <input class="text-right" name="da" value="<?=$rn['cost'];?>">
                      </form>
                    </td>
                    <td class="text-right px-0">
                      <form target="sp" method="post" action="core/updateorder.php">
                        <input name="act" type="hidden" value="trash">
                        <input name="id" type="hidden" value="<?=$rn['id'];?>">
                        <input name="t" type="hidden" value="orderitems">
                        <input name="c" type="hidden" value="quantity">
                        <input name="da" type="hidden" value="0">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    </td>
                  </tr>
                  <?php $total=$total-$rn['cost'];
                }
                $total=number_format((float)$total,2,'.','');?>
                <tr>
                  <td class="text-right" colspan="7"><strong>Balance</strong></td>
                  <td class="total text-right border-2 border-black border-top border-bottom px-0"><strong><?=$total;?></td>
                  <td></td>
                </tr>
                <?php $so=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE id=:id");
                $so->execute([
                  ':id'=>$r['id'],
                  ':total'=>$total
                ]);
              }?>
            </tbody>
          </table>
        </div>
        <div class="col-12 col-md-6">
          <?php if($r['status']!='archived'&&$user['rank']>699){?>
            <form target="sp" method="post" action="core/update.php">
              <input name="id" type="hidden" value="<?=$r['id'];?>">
              <input name="t" type="hidden" value="orders">
              <input name="c" type="hidden" value="notes">
              <textarea class="summernote" name="da"><?= rawurldecode($r['notes']);?></textarea>
            </form>
          <?php }else
            echo'<div class="well">'.$r['notes'].'</div>';?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
<?php }
