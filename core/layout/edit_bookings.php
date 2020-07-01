<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Bookings - Edit
 * @package    core/layout/edit_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.11
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 */
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$sr=$db->prepare("SELECT contentType FROM `".$prefix."content` where id=:id");
$sr->execute([':id'=>$r['rid']]);
$rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
    <li class="breadcrumb-item active"><span id="bookingname"><?php echo$r['name'];?></span>:<span id="bookingbusiness"><?php echo$r['business'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
<?php if($user['options'][0]==1||$user['options'][2]==1){?>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_booking.php?id=<?php echo$r['id'];?>');return false;" data-tooltip="tooltip" data-placement="left" data-title="Email Booking" aria-label="Email"><?php svg('email-send');?></a>
<?php }?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="tis" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Booked For</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>"<?php echo$user['options'][2]==1?'':'value="'.date($config['dateFormat'],$r['tis']).'" readonly';?>>
            <input type="hidden" id="tisx" value="<?php echo$r['tis'];?>">
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savetis" class="btn btn-secondary save" data-dbid="tis" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="tie" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Booking End</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" data-datetime="<?php echo date($config['dateFormat'],($r['tie']!=0?$r['tie']:$r['tis']));?>" autocomplete="off"<?php echo$user['options'][2]==1?'':' value="'.date($config['dateFormat'],($r['tie']!=0?$r['tie']:$r['tis'])).'" readonly';?>>
            <input type="hidden" id="tiex" value="<?php echo$r['tie'];?>">
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savetie" class="btn btn-secondary save" data-dbid="tie" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="status" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Status</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status"<?php echo$user['options'][2]==0?' disabled':'';?>>
              <option value="unconfirmed"<?php echo$r['status']=='unconfirmed'?' selected':'';?>>Unconfirmed</option>
              <option value="confirmed"<?php echo$r['status']=='confirmed'?' selected':'';?>>Confirmed</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="cid" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Client</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <select id="cid" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid"<?php echo$user['options'][2]==0?' disabled':'';?>>
              <option value="0"<?php echo$r['cid']=='0'?' selected':'';?>>Select a Client...</option>
<?php $q=$db->query("SELECT id,business,username,name FROM `".$prefix."login` WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Email</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="email" class="form-control textinput" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email"<?php echo$user['options'][2]==1?' placeholder="Enter an Email..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Phone</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="phone" class="form-control textinput" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone"<?php echo$user['options'][2]==1?' placeholder="Enter a Phone..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Name</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="name" class="form-control textinput" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" onkeyup="$('#bookingname').html($(this).val());"<?php echo$user['options'][2]==1?' placeholder="Enter a Name..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="business" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Business</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="business" class="form-control textinput" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" onkeyup="$('#bookingbusiness').html($(this).val());"<?php echo$user['options'][2]==1?' placeholder="Enter a Business..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Address</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address"<?php echo$user['options'][2]==1?' placeholder="Enter an Address..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="suburb" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Suburb</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb"<?php echo$user['options'][2]==1?' placeholder="Enter a Suburb..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">City</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city"<?php echo$user['options'][2]==1?' placeholder="Enter a City..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="state" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">State</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state"<?php echo$user['options'][2]==1?' placeholder="Enter a State..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="postcode" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Postcode</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode"<?php echo$user['options'][2]==1?' placeholder="Enter a Postcode..."':' readonly';?>>
            <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group row">
          <label for="rid" class="control-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Service</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rid"<?php echo$user['options'][2]==0?' disabled':'';?>>
              <option value="0">Select an Item...</option>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM `".$prefix."content` WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
while($row=$sql->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$row['id'].'"'.($r['rid']==$row['id']?' selected':'').'>'.ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'].'</option>';?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="notes" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Notes</label>
          <div class=" col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <div class="card-header p-0">
            <?php echo$user['options'][2]==1?'<form id="summernote" method="post" target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$r['id'].'"><input type="hidden" name="t" value="content"><input type="hidden" name="c" value="notes"><textarea id="notes" class="summernote" name="da">'.rawurldecode($r['notes']).'</textarea></form>':'<div class="form-control" style="background:#fff;color:#000">'.rawurldecode($r['notes']).'</div>';?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
