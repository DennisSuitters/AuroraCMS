<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Orders - Edit
 * @package    core/layout/edit_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.15
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.15 Add GST Calculation.
 */
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE id=:id");
$q->execute([':id'=>$id]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$q->execute([':id'=>$r['cid']]);
$client=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$q->execute([':id'=>$r['uid']]);
$usr=$q->fetch(PDO::FETCH_ASSOC);
if($r['notes']==''){
  $r['notes']=$config['orderEmailNotes'];
  $q=$db->prepare("UPDATE `".$prefix."orders` SET notes=:notes WHERE id=:id");
  $q->execute([
    ':notes'=>$config['orderEmailNotes'],
    ':id'=>$r['id']
  ]);
}
if($error==1)echo'<div class="alert alert-danger" role="alert">'.$e[0].'</div>';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
    <li class="breadcrumb-item">
<?php if(isset($r['aid'])&&$r['aid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/archived">Archived</a>';
      elseif(isset($r['iid'])&&$r['iid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/invoices">Invoices</a>';
      elseif($r['qid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/quotes">Quotes</a>';?>
    </li>
    <li class="breadcrumb-item active"><span id="ordertitle"><?php echo$r['qid'].$r['iid'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');return false;" data-tooltip="tooltip" data-placement="left" data-title="Print Order" aria-label="Print Order"><?php svg('print');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');return false;" data-tooltip="tooltip" data-placement="left" data-title="Email Order" aria-label="Email Order"><?php svg('email-send');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="invoice">
          <div class="row">
            <div class="col-sm-4 border-right">
              <label for="fromfrom" class="h2">From</label>
              <div class="form-group">
                <input type="text" id="fromfrom" class="form-control" name="fromfrom" value="<?php echo$config['business'];?>" readonly>
              </div>
              <div class="form-group row">
                <label for="fromabn" class="col-form-label col-sm-3"><small>ABN</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromabn" class="form-control form-control-sm" name="fromabn" value="<?php echo$config['abn'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="fromaddress" class="col-form-label col-sm-3"><small>Address</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromaddress" class="form-control form-control-sm" name="fromaddress" value="<?php echo$config['address'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="fromsuburb" class="col-form-label col-sm-3"><small>Suburb</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromsuburb" class="form-control form-control-sm" name="fromsuburb" value="<?php echo$config['suburb'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="fromcity" class="col-form-label col-sm-3"><small>City</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromcity" class="form-control form-control-sm" name="fromcity" value="<?php echo$config['city'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="fromstate" class="col-form-label col-sm-3"><small>State</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromstate" class="form-control form-control-sm" name="fromstate" value="<?php echo$config['state'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="frompostcode" class="col-form-label col-sm-3"><small>Postcode</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="frompostcode" class="form-control form-control-sm" name="frompostcode" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="fromemail" class="col-form-label col-sm-3"><small>Email</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromemail" class="form-control form-control-sm" name="fromemail" value="<?php echo$config['email'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="fromphone" class="col-form-label col-sm-3"><small>Phone</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromphone" class="form-control form-control-sm" name="fromphone" value="<?php echo$config['phone'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="frommobile" class="col-form-label col-sm-3"><small>Mobile</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="frommobile" class="form-control form-control-sm" name="frommobile" value="<?php echo$config['mobile'];?>" readonly>
                </div>
              </div>
            </div>
            <div class="col-sm-4 border-right">
              <label for="client_business" class="h2">To</label>
              <div class="form-group">
                <input type="text" id="client_business" class="form-control" name="client_business" value="<?php echo$client['username'];echo$client['name']!=''?' ['.$client['name'].']':'';echo$client['business']!=''?' -> '.$client['business']:'';?>" placeholder="Username, Business or Name..." readonly>
              </div>
              <div class="form-group row">
                <label for="address" class="col-form-label col-sm-3"><small>Address</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="address" class="form-control form-control-sm textinput oce" value="<?php echo$client['address'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="address" data-bs="btn-danger" placeholder="Enter an Address..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                  <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="saveaddress" class="btn btn-secondary btn-sm save" data-dbid="address" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="suburb" class="col-form-label col-sm-3"><small>Suburb</small></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="suburb" class="form-control form-control-sm textinput oce" value="<?php echo$client['suburb'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="suburb" data-bs="btn-danger" placeholder="Enter a Suburb..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                  <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savesuburb" class="btn btn-secondary btn-sm save" data-dbid="suburb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
                </div>
              </div>
            <div class="form-group row">
              <label for="city" class="col-form-label col-sm-3"><small>City</small></label>
              <div class="input-group col-sm-9">
                <input type="text" id="city" class="form-control form-control-sm textinput oce" value="<?php echo$client['city'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="city" data-bs="btn-danger" placeholder="Enter a City..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savecity" class="btn btn-secondary btn-sm save" data-dbid="city" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="state" class="col-form-label col-sm-3"><small>State</small></label>
              <div class="input-group col-sm-9">
                <input type="text" id="state" class="form-control form-control-sm textinput oce" value="<?php echo$client['state'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="state" data-bs="btn-danger" placeholder="Enter a State..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savestate" class="btn btn-secondary btn-sm save" data-dbid="state" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="postcode" class="col-form-label col-sm-3"><small>Postcode</small></label>
              <div class="input-group col-sm-9">
                <input type="text" id="postcode" class="form-control form-control-sm textinput oce" value="<?php echo$client['postcode']!=0?$client['postcode']:'';?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="postcode" data-bs="btn-danger" placeholder="Enter a Postcode..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <?php if($r['status']!='archived'){?><div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savepostcode" class="btn btn-secondary btn-sm save" data-dbid="postcode" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div><?php }?>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-form-label col-sm-3"><small>Email</small></label>
              <div class="input-group col-sm-9">
                <input type="text" id="email" class="form-control form-control-sm textinput oce" value="<?php echo$client['email'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="email" data-bs="btn-danger" placeholder="Enter an Email..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="saveemail" class="btn btn-secondary btn-sm save" data-dbid="email" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="phone" class="col-form-label col-sm-3"><small>Phone</small></label>
              <div class="input-group col-sm-9">
                <input type="text" id="phone" class="form-control form-control-sm textinput oce" value="<?php echo$client['phone'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="phone" data-bs="btn-danger" placeholder="Enter a Phone..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savephone" class="btn btn-secondary btn-sm save" data-dbid="phone" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="mobile" class="col-form-label col-sm-3"><small>Mobile</small></label>
              <div class="input-group col-sm-9">
                <input type="text" id="mobile" class="form-control form-control-sm textinput oce" value="<?php echo$client['mobile'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="mobile" data-bs="btn-danger" placeholder="Enter a Mobile..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savemobile" class="btn btn-secondary btn-sm save" data-dbid="mobile" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
              </div>
            </div>
<?php if($r['status']!='archived'){?>
            <div class="form-group row">
              <label for="changeClient" class="col-form-label col-sm-3"><small>Client</small></label>
              <div class="input-group col-sm-9">
                <select id="changeClient" class="form-control form-control-sm" onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');" data-tooltip="tooltip" data-title="Select a Client...">
                  <option value="0"<?php echo($r['cid']=='0'?' selected':'');?>>None</option>
                  <?php $q=$db->query("SELECT id,business,username,name FROM `".$prefix."login` WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($r['cid']==$rs['id']?' selected':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business'].'</option>':'');?>
                  </select>
                </div>
                <small class="alert alert-info ocehelp mt-2<?php echo$client['id']!=0?' hidden':'';?>" role="alert"><small>To edit Client details her you must first create an Account for the Client or Select an already existing Client above.</small></small>
              </div>
<?php }?>
            </div>
            <div class="col-sm-4">
              <h1 class="h2">Details</h1>
              <div class="form-group row">
                <label for="detailsordernumber" class="col-form-label col-sm-3">Order #</label>
                <div class="input-group col-sm-9">
                  <input type="text" id="detailsordernumber" class="form-control form-control-sm" name="ordernumber" value="<?php echo$r['iid']==''?$r['qid']:$r['iid'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="detailscreated" class="col-form-label col-sm-3">Created</label>
                <div class="input-group col-sm-9">
                  <input type="text" id="detailscreated" class="form-control form-control-sm" name="created" value="<?php echo$r['iid_ti']!=0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']);?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Due</label>
                <div class="input-group col-sm-9">
                  <input type="text" id="due_ti" class="form-control form-control-sm" data-datetime="<?php echo date($config['dateFormat'],$r['due_ti']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="orders" data-dbc="due_ti" autocomplete="off">
                  <input type="hidden" id="due_tix" value="<?php echo$r['due_ti'];?>">
<?php if($r['status']!='archived'){?>
                  <div class="input-group-append">
                    <div class="dropdown">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" data-title="Extend Due Date" aria-label="Extend Due Date"><?php svg('add');?></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+604800;?>');return false;">7 Days</a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1209600;?>');return false;">14 Days</a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1814400;?>');return false;">21 Days</a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+2592000;?>');return false;">30 Days</a>
                      </div>
                    </div>
                  </div>
                  <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savedue_ti" class="btn btn-secondary btn-sm save" data-dbid="due_ti" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
<?php }?>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Status</label>
                <div class="input-group col-sm-9">
<?php if($r['status']=='archived')echo'<input type="text" class="form-control form-control-sm" value="Archived" readonly>';
else{?>
                  <select id="status" class="form-control form-control-sm" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());" data-tooltip="tooltip" data-title="Change Order Status">
                    <option value="pending"<?php echo$r['status']=='pending'?' selected':'';?>>Pending</option>
                    <option value="overdue"<?php echo$r['status']=='overdue'?' selected':'';?>>Overdue</option>
                    <option value="cancelled"<?php echo$r['status']=='cancelled'?' selected':'';?>>Cancelled</option>
                    <option value="paid"<?php echo$r['status']=='paid'?' selected':'';?>>Paid</option>
                  </select>
<?php }?>
                </div>
              </div>
            </div>
          </div>
<?php if($r['status']!='archived'){?>
          <form target="sp" method="POST" action="core/updateorder.php">
            <input type="hidden" name="act" value="additem">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="orderitems">
            <input type="hidden" name="c" value="">
            <div class="form-group row">
              <div class="input-group col">
                <div class="input-group-text">Inventory/Services</div>
                <select class="form-control" name="da" data-tooltip="tooltip" data-title="Select Product, Service or Empty Entry">
                  <option value="0">Add Empty Entry...</option>
                  <?php $s=$db->query("SELECT id,contentType,code,cost,title FROM `".$prefix."content` WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';?>
                </select>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
                </div>
              </div>
            </div>
          </form>
<?php $sp=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='postoption' ORDER BY title ASC");
$sp->execute();
if($sp->rowCount()>0){?>
          <form target="sp" method="POST" action="core/updateorder.php">
            <input type="hidden" name="act" value="addpostoption">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="orders">
            <input type="hidden" name="c" value="postageOption">
            <div class="form-group row">
              <div class="input-group col">
                <div class="input-group-text">Postage Options</div>
                <select class="form-control" name="da" data-tooltip="tooltip" data-title="Select Postage Option or Empty Entry">
                  <option value="0">Clear Postage Option and Cost</option>
                  <?php while($rp=$sp->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rp['id'].'">'.$rp['title'].':$'.$rp['value'].'</option>';?>
                </select>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
                </div>
              </div>
            </div>
          </form>
<?php }
}?>
          <div class="table-responsive">
            <table class="table table-condensed table-borderless">
              <thead class="thead-light">
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
<?php $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
$s->execute([':oid'=>$r['id']]);
$total=0;
while($oi=$s->fetch(PDO::FETCH_ASSOC)){
$is=$db->prepare("SELECT id,thumb,file,fileURL,code,title FROM `".$prefix."content` WHERE id=:id");
$is->execute([':id'=>$oi['iid']]);
$i=$is->fetch(PDO::FETCH_ASSOC);
$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
$sc->execute([':id'=>$oi['cid']]);
$c=$sc->fetch(PDO::FETCH_ASSOC);
$image='';
if($i['thumb']!=''&&file_exists('media'.DS.basename($i['thumb'])))$image='<img class="img-fluid" style="max-width:24px;height:24px" src="media'.DS.basename($i['thumb']).'" alt="'.$i['title'].'">';
elseif($i['file']!=''&&file_exists('media'.DS.basename($i['file'])))$image='<img class="img-fluid" style="max-width:24px;height:24px" src="media'.DS.basename($i['file']).'" alt="'.$i['title'].'">';
elseif($i['fileURL']!='')$image='<img class="img-fluid" style="max-width:24px;height:24px" src="'.$i['fileURL'].'" alt="'.$i['title'].'">';
else$image='';
?>
                <tr>
                  <td class="text-center align-middle"><?php echo$image;?></td>
                  <td class="text-left align-middle small"><?php echo$i['code'];?></td>
                  <td class="text-left align-middle">
<?php if($oi['iid']!=0)echo$i['title'];
else{?>
                    <form target="sp" method="POST" action="core/updateorder.php">
                      <input type="hidden" name="act" value="title">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="title">
                      <input type="text" class="form-control" name="da" value="<?php echo$oi['title'];?>">
                    </form>
<?php }?>
                  </td>
                  <td class="text-left align-middle"><?php echo$c['title'];?></td>
                  <td class="text-center align-middle">
<?php if($oi['iid']!=0){?>
                    <form target="sp" method="POST" action="core/updateorder.php">
                      <input type="hidden" name="act" value="quantity">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="quantity">
                      <input type="text" class="form-control text-center" name="da" value="<?php echo$oi['quantity'];?>"<?php echo$r['status']=='archived'?' readonly':'';?>>
                    </form>
<?php }else{
if($oi['iid']!=0)echo$oi['quantity'];
}?>
                  </td>
                  <td class="text-right align-middle">
<?php if($oi['iid']!=0){?>
                    <form target="sp" method="POST" action="core/updateorder.php">
                      <input type="hidden" name="act" value="cost">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="cost">
                      <input class="form-control text-center" style="min-width:80px" name="da" value="<?php echo$oi['cost'];?>"<?php echo$r['status']=='archived'?' readonly':'';?>>
                    </form>
<?php }elseif($oi['iid']!=0)echo$oi['cost'];?>
                  </td>
                  <td class="text-right align-middle"><?php echo$oi['iid']!=0?$oi['cost']*$oi['quantity']:'';?></td>
                  <td class="text-right">
                    <form target="sp" method="POST" action="core/updateorder.php">
                      <input type="hidden" name="act" value="trash">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="quantity">
                      <input type="hidden" name="da" value="0">
                      <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                    </form>
                  </td>
                </tr>
<?php if($oi['iid']!=0)
  $total=$total+($oi['cost']*$oi['quantity']);
  $total=number_format((float)$total, 2, '.', '');
}
$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE id=:rid");
$sr->execute([':rid'=>$r['rid']]);
$reward=$sr->fetch(PDO::FETCH_ASSOC);?>
                <tr>
                  <td colspan="3" class="text-right align-middle"><strong>Rewards Code</strong></td>
                  <td colspan="2" class="text-center">
                    <form id="rewardsinput" target="sp" method="POST" action="core/updateorder.php">
                      <div class="form-group row">
                        <div class="input-group">
                          <input type="hidden" name="act" value="reward">
                          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                          <input type="hidden" name="t" value="orders">
                          <input type="hidden" name="c" value="rid">
                          <input type="text" id="rewardselect" class="form-control" name="da" value="<?php echo$sr->rowCount()==1?$reward['code']:'';?>">
<?php $ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY code ASC, title ASC");
$ssr->execute();
if($ssr->rowCount()>0){?>
                          <div class="input-group-append">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu">
<?php while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){?>
                              <a class="dropdown-item" href="#" onclick="$('#rewardselect').val('<?php echo$srr['code'];?>');$('#rewardsinput:first' ).submit();return false;">
                                <?php echo$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off';?>
                              </a>
<?php }?>
                            </div>
                          </div>
<?php }?>
                        </div>
                      </div>
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
<?php if($config['gst']>0){
  $gst=$total*($config['gst']/100);
  $gst=number_format((float)$gst, 2, '.', '');?>
                <tr>
                  <td colspan="6" class="text-right"><strong>GST</strong></td>
                  <td class="total text-right border-top border-bottom"><strong><?php echo$gst;?></strong></td>
                  <td></td>
                </tr>
<?php
  $total=$total+$gst;
  $total=number_format((float)$total, 2, '.', '');
}?>
                <tr>
                  <td class="text-right align-middle"><strong>Postage</strong></td>
                  <td colspan="5" class="text-right align-middle">
                    <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                      <input type="hidden" name="act" value="postoption">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="t" value="orders">
                      <input type="hidden" name="c" value="postageOption">
                      <input type="text" class="form-control" name="da" value="<?php echo$r['postageOption'];?>">
                    </form>
                  </td>
                  <td class="text-right pl-0 pr-0">
                    <form target="sp" method="POST" action="core/updateorder.php" onchange="$(this).submit();">
                      <input type="hidden" name="act" value="postcost">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="t" value="orders">
                      <input type="hidden" name="c" value="postageCost">
                      <input type="text" class="form-control text-right" name="da" value="<?php echo$r['postageCost'];$total=$total+$r['postageCost'];?>">
<?php $total=number_format((float)$total, 2, '.', '');?>
                    </form>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="6" class="text-right"><strong>Total</strong></td>
                  <td class="total text-right border-top border-bottom"><strong><?php echo$total;?></strong></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-sm-6">
<?php if($r['status']!='archived'&&$user['rank']>699){?>
            <form target="sp" method="POST" action="core/update.php">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="orders">
              <input type="hidden" name="c" value="notes">
              <textarea class="summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
            </form>
<?php }else echo'<div class="well">'.$r['notes'].'</div>';?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php }
