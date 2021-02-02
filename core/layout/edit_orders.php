<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Orders - Edit
 * @package    core/layout/edit_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
$q->execute([
  ':id'=>$id
]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([
  ':id'=>$r['cid']
]);
$client=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([
  ':id'=>$r['uid']
]);
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
    <section id="content">
      <div class="content-title-wrapper mb-0">
        <div class="content-title">
          <div class="content-title-heading">
            <div class="content-title-icon"><?php svg('order','i-3x');?></div>
            <div>Edit Order <?php echo$r['qid'].$r['iid'];?></div>
            <div class="content-title-actions">
              <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?php svg('back');?></a>
              <button data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');return false;"><?php svg('print');?></button>
              <button data-tooltip="tooltip" aria-label="Email Order" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');return false;"><?php svg('email-send');?></button>
              <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></button>
            </div>
          </div>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
            <li class="breadcrumb-item">
              <?php if(isset($r['aid'])&&$r['aid']!='')
                echo'<a href="'.URL.$settings['system']['admin'].'/orders/archived">Archived</a>';
              elseif(isset($r['iid'])&&$r['iid']!='')
                echo'<a href="'.URL.$settings['system']['admin'].'/orders/invoices">Invoices</a>';
              elseif($r['qid']!='')
                echo'<a href="'.URL.$settings['system']['admin'].'/orders/quotes">Quotes</a>';?>
            </li>
            <li class="breadcrumb-item active"><span id="ordertitle"><?php echo$r['qid'].$r['iid'];?></span></li>
          </ol>
        </div>
      </div>
      <div class="container-fluid p-0">
        <div class="card border-radius-0 shadow px-4 py-3">
          <div class="row">
            <div class="col-12">
              <h4>Details</h4>
              <div class="form-row">
                <div class="input-text">Order #</div>
                <input id="detailsordernumber" type="text" value="<?php echo$r['iid']==''?$r['qid']:$r['iid'];?>" readonly aria-label="Order Number">
                <div class="input-text">Created</div>
                <input id="detailscreated" type="text" value="<?php echo$r['iid_ti']!=0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']);?>" readonly aria-label="Date Created">
                <div class="input-text">Due</div>
                <input id="due_ti" type="date" value="<?php echo date('Y-m-d',$r['due_ti']);?>"<?php if($r['status']!='archived'){?> autocomplete="off" aria-label="Order Due Date" onchange="update(`<?php echo$r['id'];?>`,`orders`,`due_ti`,getTimestamp(`due_ti`));"<?php }?>>
                <div class="input-text">Status</div>
                <?php if($r['status']=='archived')
                  echo'<input type="text" value="Archived" readonly>';
                else{?>
                  <select id="status" data-tooltip="tooltip" aria-label="Order Status" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());">
                    <option value="pending"<?php echo$r['status']=='pending'?' selected':'';?>>Pending</option>
                    <option value="overdue"<?php echo$r['status']=='overdue'?' selected':'';?>>Overdue</option>
                    <option value="cancelled"<?php echo$r['status']=='cancelled'?' selected':'';?>>Cancelled</option>
                    <option value="paid"<?php echo$r['status']=='paid'?' selected':'';?>>Paid</option>
                  </select>
                <?php }?>
              </div>
            </div>
          </div>
          <hr>
          <div class="row mt-3">
            <div class="col-12 col-md-6">
              <h4>From</h4>
              <p>
                <?php echo'<strong>'.$config['business'].'</strong><br>'.
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
            <div class="col-12 col-md-6 text-right">
              <h4>To</h4>
              <p id="to">
                <?php echo'<strong>'.$client['username'].($client['name']!=''?' ['.$client['name'].']':'').'<br>'.
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
                  <select id="changeClient" data-tooltip="tooltip" aria-label="Select a Client..." onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');">
                    <option value="0"<?php echo($r['cid']=='0'?' selected':'');?>>None</option>
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
                <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                <input name="t" type="hidden" value="orderitems">
                <input name="c" type="hidden" value="">
                <div class="input-text">Inventory/Services</div>
                <select name="da" data-tooltip="tooltip" aria-label="Select Product, Service or Empty Entry">
                  <option value="0">Add Empty Entry...</option>
                  <option value="neg">Add Deducation Entry...</option>
                  <?php $s=$db->query("SELECT `id`,`contentType`,`code`,`cost`,`title` FROM `".$prefix."content` WHERE `contentType`='inventory' OR `contentType`='service' OR `contentType`='events' ORDER BY `code` ASC");
                  if($s->rowCount()>0){
                    while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';
                  }?>
                </select>
                <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?php svg('add');?></button>
              </form>
              <div class="row">
                <small class="form-text text-muted">Note: Adding or removing items does not recalculate Postage Costs, you will need to do that manually with the selection below</small>
              </div>
              <?php $sp=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' ORDER BY `title` ASC");
              $sp->execute();
              if($sp->rowCount()>0){?>
                <form class="form-row" target="sp" method="post" action="core/updateorder.php">
                  <input name="act" type="hidden" value="addpostoption">
                  <input name="id" type="hidden" value="<?php echo$r['id'];?>">
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
                <tr>
                  <th></th>
                  <th>Code</th>
                  <th class="col text-left">Title</th>
                  <th class="col-sm-2">Option</th>
                  <th class="col-sm-1 text-center">Quantity</th>
                  <th class="col-sm-2 text-center">Cost</th>
                  <th class="col-sm-1 text-right">Total</th>
                  <th class="col-sm-1"></th>
                </tr>
              </thead>
              <tbody id="updateorder">
                <?php $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `ti` ASC,`title` ASC");
                $s->execute([
                  ':oid'=>$r['id']
                ]);
                $total=0;
                while($oi=$s->fetch(PDO::FETCH_ASSOC)){
                  $is=$db->prepare("SELECT `id`,`thumb`,`file`,`fileURL`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $is->execute([
                    ':id'=>$oi['iid']
                  ]);
                  $i=$is->fetch(PDO::FETCH_ASSOC);
                  $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
                  $sc->execute([
                    ':id'=>$oi['cid']
                  ]);
                  $c=$sc->fetch(PDO::FETCH_ASSOC);
                  $image='';
                  if($i['thumb']!=''&&file_exists('media/'.basename($i['thumb'])))
                    $image='<img class="img-fluid" style="max-width:24px;height:24px" src="media/'.basename($i['thumb']).'" alt="'.$i['title'].'">';
                  elseif($i['file']!=''&&file_exists('media/'.basename($i['file'])))
                    $image='<img class="img-fluid" style="max-width:24px;height:24px" src="media/'.basename($i['file']).'" alt="'.$i['title'].'">';
                  elseif($i['fileURL']!='')
                    $image='<img class="img-fluid" style="max-width:24px;height:24px" src="'.$i['fileURL'].'" alt="'.$i['title'].'">';
                  else
                    $image='';?>
                  <tr>
                    <td class="text-center align-middle"><?php echo$image;?></td>
                    <td class="text-left align-middle small"><?php echo$i['code'];?></td>
                    <td class="text-left align-middle">
                      <?php if($oi['iid']!=0)
                        echo$i['title'];
                      else{?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="title">
                          <input name="id" type="hidden" value="<?php echo$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="title">
                          <input name="da" type="text" value="<?php echo$oi['title'];?>">
                        </form>
                      <?php }?>
                    </td>
                    <td class="text-left align-middle"><?php echo$c['title'];?></td>
                    <td class="text-center align-middle">
                      <?php if($oi['iid']!=0){?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="quantity">
                          <input name="id" type="hidden" value="<?php echo$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="quantity">
                          <input class="text-center" name="da" type="text" value="<?php echo$oi['quantity'];?>"<?php echo$r['status']=='archived'?' readonly':'';?>>
                        </form>
                      <?php }else{
                        if($oi['iid']!=0)echo$oi['quantity'];
                      }?>
                    </td>
                    <td class="text-right align-middle">
                      <?php if($oi['iid']!=0){?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="cost">
                          <input name="id" type="hidden" value="<?php echo$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="cost">
                          <input class="text-center" style="min-width:80px" name="da" value="<?php echo$oi['cost'];?>"<?php echo$r['status']=='archived'?' readonly':'';?>>
                        </form>
                      <?php }elseif($oi['iid']!=0)
                        echo$oi['cost'];?>
                    </td>
                    <td class="text-right align-middle"><?php echo$oi['iid']!=0?$oi['cost']*$oi['quantity']:'';?></td>
                    <td class="text-right">
                      <form target="sp" method="post" action="core/updateorder.php">
                        <input name="act" type="hidden" value="trash">
                        <input name="id" type="hidden" value="<?php echo$oi['id'];?>">
                        <input name="t" type="hidden" value="orderitems">
                        <input name="c" type="hidden" value="quantity">
                        <input name="da" type="hidden" value="0">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
                      </form>
                    </td>
                  </tr>
                  <?php if($oi['iid']!=0)
                    $total=$total+($oi['cost']*$oi['quantity']);
                    $total=number_format((float)$total, 2, '.', '');
                  }
                  $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
                  $sr->execute([
                    ':rid'=>$r['rid']
                  ]);
                  $reward=$sr->fetch(PDO::FETCH_ASSOC);?>
                  <tr>
                    <td class="text-right align-middle" colspan="3"><strong>Rewards Code</strong></td>
                    <td class="text-center" colspan="2">
                      <form class="form-row" id="rewardsinput" target="sp" method="post" action="core/updateorder.php">
                        <input name="act" type="hidden" value="reward">
                        <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                        <input name="t" type="hidden" value="orders">
                        <input name="c" type="hidden" value="rid">
                        <input id="rewardselect" name="da" type="text" value="<?php echo$sr->rowCount()==1?$reward['code']:'';?>" onchange="$('#rewardsinput:first').submit();">
                        <?php $ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `code` ASC, `title` ASC");
                        $ssr->execute();
                        if($ssr->rowCount()>0){?>
                          <select onchange="$('#rewardselect').val($(this).val());$('#rewardsinput:first').submit();">
                            <option value="">Select a Code</option>
                            <?php while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){?>
                              <option value="<?php echo$srr['code'];?>"<?php echo$srr['code']==$reward['code']?' selected':'';?>><?php echo$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off';?></option>
                            <?php }?>
                          </select>
                        <?php }?>
                      </form>
                    </td>
                    <td class="text-center align-middle">
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
                        $total=number_format((float)$total, 2, '.', '');
                        echo' Off';
                      }?>
                    </td>
                    <td class="text-right align-middle"><strong><?php echo$total;?></strong></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php if($usr['spent']>0&&$config['options'][26]==1){
                    $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
                    $sd->execute([
                      ':f'=>$usr['spent'],
                      ':t'=>$usr['spent']
                    ]);
                    if($sd->rowCount()>0){
                      $rd=$sd->fetch(PDO::FETCH_ASSOC);
                      if($rd['value']==2)
                        $total=$total*($rd['cost']/100);
                      else
                        $total=$total-$rd['cost'];
                      $total=number_format((float)$total, 2, '.', '');?>
                      <tr>
                        <td class="text-right" colspan="6"><strong>Spent Discount <?php echo($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost']).' Off';?></strong></td>
                        <td class="text-right align-middle"><strong><?php echo$total;?></strong></td>
                        <td>&nbsp;</td>
                      </tr>
                    <?php }
                  }
                  if($config['gst']>0){
                    $gst=$total*($config['gst']/100);
                    $gst=number_format((float)$gst, 2, '.', '');
                    $total=$total+$gst;
                    $total=number_format((float)$total, 2, '.', ''); ?>
                    <tr>
                      <td class="text-right" colspan="6"><strong><?php echo$config['gst'].'% GST $'.$gst;?></strong></td>
                      <td class="total text-right border-top border-bottom"><strong><?php echo$total;?></strong></td>
                      <td>&nbsp;</td>
                    </tr>
                  <?php }?>
                  <tr>
                    <td class="text-right align-middle" colspan="2"><strong>Shipping</strong></td>
                    <td class="text-right align-middle" colspan="4">
                      <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                        <input name="act" type="hidden" value="postoption">
                        <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                        <input name="t" type="hidden" value="orders">
                        <input name="c" type="hidden" value="postageOption">
                        <input name="da" type="text" value="<?php echo$r['postageOption'];?>">
                      </form>
                    </td>
                    <td class="text-right pl-0 pr-0">
                      <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                        <input name="act" type="hidden" value="postcost">
                        <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                        <input name="t" type="hidden" value="orders">
                        <input name="c" type="hidden" value="postageCost">
                        <input class="text-right" name="da" type="text" value="<?php echo$r['postageCost'];$total=$total+$r['postageCost'];?>">
                          <?php $total=number_format((float)$total, 2, '.', '');?>
                      </form>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right" colspan="6"><strong>Total</strong></td>
                    <td class="total text-right border-top border-bottom"><strong><?php echo$total;?></strong></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php $su=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE `id`=:id");
                  $su->execute([
                    ':id'=>$r['id'],
                    ':total'=>$total
                  ]);
                  $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
                  $sn->execute([
                    ':oid'=>$r['id']
                  ]);
                  if($sn->rowCount()>0){
                     while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
                       echo'<tr>'.
                        '<td class="small align-middle" colspan="2"><small>'.date($config['dateFormat'],$rn['ti']).'</td>'.
                        '<td class="align-middle" colspan="4">'.
                          '<form target="sp" method="post" action="core/updateorder.php">'.
                            '<input name="act" type="hidden" value="title">'.
                            '<input name="id" type="hidden" value="'.$rn['id'].'">'.
                            '<input name="t" type="hidden" value="orderitems">'.
                            '<input name="c" type="hidden" value="title">'.
                            '<input name="da" type="text" value="'.$rn['title'].'">'.
                          '</form>'.
                        '</td>'.
                        '<td class="text-right align-middle">'.
                          '<form target="sp" method="post" action="core/updateorder.php">'.
                            '<input name="act" type="hidden" value="cost">'.
                            '<input name="id" type="hidden" value="'.$rn['id'].'">'.
                            '<input name="t" type="hidden" value="orderitems">'.
                            '<input name="c" type="hidden" value="cost">'.
                            '<input class="text-center" style="min-width:80px" name="da" value="'.$rn['cost'].'">'.
                          '</form>'.
                        '</td>'.
                        '<td>'.
                          '<form target="sp" method="post" action="core/updateorder.php">'.
                            '<input name="act" type="hidden" value="trash">'.
                            '<input name="id" type="hidden" value="'.$rn['id'].'">'.
                            '<input name="t" type="hidden" value="orderitems">'.
                            '<input name="c" type="hidden" value="quantity">'.
                            '<input name="da" type="hidden" value="0">'.
                            '<button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
                          '</form>'.
                        '</td>'.
                      '</tr>';
                      $total=$total-$rn['cost'];
                    }
                    $total=number_format((float)$total,2,'.','');
                    echo'<tr>'.
                      '<td class="text-right" colspan="6"><strong>Total</strong></td>'.
                      '<td class="total text-right border-top border-bottom"><strong>'.$total.'</td>'.
                      '<td></td>'.
                    '</tr>';
                  }?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-6">
              <?php if($r['status']!='archived'&&$user['rank']>699){?>
                <form target="sp" method="post" action="core/update.php">
                  <input name="id" type="hidden" value="<?php echo$r['id'];?>">
                  <input name="t" type="hidden" value="orders">
                  <input name="c" type="hidden" value="notes">
                  <textarea class="summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
                </form>
              <?php }else
                echo'<div class="well">'.$r['notes'].'</div>';?>
            </div>
            <?php require'core/layout/footer.php';?>
          </div>
        </div>
      </section>
    </main>
<?php }
