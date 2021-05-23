<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Bookings - Edit
 * @package    core/layout/edit_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
$s->execute([
  ':id'=>$id
]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$sr=$db->prepare("SELECT `contentType` FROM `".$prefix."content` where `id`=:id");
$sr->execute([
  ':id'=>$r['rid']
]);
$rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('calendar','i-3x');?></div>
          <div>Booking</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?= svg2('back');?></a>
            <a class="btn" data-tooltip="tooltip" href="#" aria-label="Print Order" onclick="$('#sp').load('core/print_booking.php?id=<?=$r['id'];?>');return false;"><?= svg2('print');?></a>
            <?php if($user['options'][0]==1||$user['options'][2]==1){?>
              <a class="btn" data-tooltip="tooltip" href="#" aria-label="Email Booking" onclick="$('#sp').load('core/email_booking.php?id=<?=$r['id'];?>');return false;"><?= svg2('email-send');?></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
          <li class="breadcrumb-item active"><span id="bookingname"><?=$r['name'];?></span>:<span id="bookingbusiness"><?=$r['business'];?></span></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <div class="row">
          <div class="col-12 col-md-4 pr-md-3">
            <label id="contenttis" for="tis"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingFor" aria-label="PermaLink to Booked For Date Field">&#128279;</a>':'';?>Booked <span class="labeldate" id="labeldatetis">(<?= date($config['dateFormat'],$r['tis']);?>)</span></label>
            <div class="form-row">
              <input id="tis" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['tis']);?>" autocomplete="off" onchange="update(`<?=$r['id'];?>`,`content`,`tis`,getTimestamp(`tis`),`select`);">
            </div>
          </div>
          <div class="col-12 col-sm-4 pr-3">
            <label id="contenttie" for="tie"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingTo" aria-label="PermaLink to Booked To Date Field">&#128279;</a>':'';?>To <span class="labeldate" id="labeldatetie">(<?= date($config['dateFormat'],$r['tie']);?>)</span></label>
            <div class="form-row">
              <input id="tie" type="datetime-local" value="<?= date('Y-m-d\TH:i',($r['tie']==0?$r['tis']:$r['tie']));?>" autocomplete="off" onchange="update(`<?=$r['id'];?>`,`content`,`tie`,getTimestamp(`tie`),`select`);">
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <label id="contentstatus" for="status"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingStatus" aria-label="PermaLink to Booking Status Selector">&#128279;</a>':'';?>Status</label>
            <div class="form-row">
              <select id="status" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="status"<?=$user['options'][2]==0?' disabled':'';?> onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');">
                <option value="unconfirmed"<?=$r['status']=='unconfirmed'?' selected':'';?>>Unconfirmed</option>
                <option value="confirmed"<?=$r['status']=='confirmed'?' selected':'';?>>Confirmed</option>
                <option value="in-progress"<?=$r['status']=='in-progress'?' selected':'';?>>In Progress</option>
                <option value="complete"<?=$r['status']=='complete'?' selected':'';?>>Complete</option>
                <option value="archived"<?=$r['status']=='archived'?' selected':'';?>>Archived</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-3">
            <label id="contentcid" for="cid"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingClient" aria-label="PermaLink to Client Selector">&#128279;</a>':'';?>Client</label>
            <div class="form-row">
              <select id="cid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="cid"<?=$user['options'][2]==0?' disabled':'';?> onchange="changeClient($(this).val(),<?=$r['id'];?>,'booking','select');">
                <option value="0"<?=$r['cid']=='0'?' selected':'';?>>Select an Account Client...</option>
                <?php $q=$db->query("SELECT `id`,`business`,`username`,`name` FROM `".$prefix."login` WHERE `status`!='delete' AND `status`!='suspended' AND `active`!='0' AND `id`!='0'");
                if($q->rowCount()>0){
                  while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';
                }?>
              </select>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label id="bookingNoClient" for="cid2"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingNoClient" aria-label="PermaLink to No Account Clients Selector">&#128279;</a>':'';?>No Account Clients</label>
            <div class="form-row">
              <select id="cid2" data-dbt="content" data-dbc="cid"<?=$user['options'][2]==0?' disabled':'';?> onchange="changeClient($(this).val(),<?=$r['id'];?>,'noaccount','select');">
                <option value="0"<?=$r['cid']=='0'?' selected':'';?>>Select Client without Account...</option>
                <?php $q=$db->query("SELECT `id`,`business`,`name` FROM `".$prefix."content` WHERE `contentType`='booking'");
                if($q->rowCount()>0){
                  while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['business'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';
                }?>
              </select>
            </div>
          </div>
        </div>
        <label id="bookingEmail" for="email"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingEmail" aria-label="PermaLink to Booking Email Field">&#128279;</a>':'';?>Email</label>
        <div class="form-row">
          <input class="textinput" id="email" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="email" type="text" value="<?=$r['email'];?>"<?=$user['options'][2]==1?' placeholder="Enter an Email..."':' readonly';?>>
          <?=$user['options'][2]==1?'<button class="save" id="saveemail" data-dbid="email" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 pr-md-3">
            <label id="bookingPhone" for="phone"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingPhone" aria-label="PermaLink to Booking Phone Field">&#128279;</a>':'';?>Phone</label>
            <div class="form-row">
              <input class="textinput" id="phone" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="phone" type="text" value="<?=$r['phone'];?>"<?=$user['options'][2]==1?' placeholder="Enter a Phone Number..."':' readonly';?>>
              <?=$user['options'][2]==1?'<button class="save" id="savephone" data-dbid="phone" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-3">
            <label id="bookingMobile" for="mobile"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingMobile" aria-label="PermaLink to Booking Mobile Field">&#128279;</a>':'';?>Mobile</label>
            <div class="form-row">
              <input class="textinput" id="mobile" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="mobile" type="text" value="<?=$r['mobile'];?>"<?=$user['options'][2]==1?' placeholder="Enter a Phone Number..."':' readonly';?>>
              <?=$user['options'][2]==1?'<button class="save" id="savemobile" data-dbid="mobile" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-3">
            <label id="bookingName" for="name"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingName" aria-label="PermaLink to Booking Name Field">&#128279;</a>':'';?>Name</label>
            <div class="form-row">
              <input class="textinput" id="name" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="name" type="text" value="<?=$r['name'];?>"<?=$user['options'][2]==1?' placeholder="Enter a Name..."':' readonly';?> onkeyup="$('#bookingname').html($(this).val());">
              <?=$user['options'][2]==1?'<button class="save" id="savename" data-dbid="name" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-3">
            <label id="bookingBusiness" for="business"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingBusiness" aria-label="PermaLink to Booking Buiness Field">&#128279;</a>':'';?>Business</label>
            <div class="form-row">
              <input class="textinput" id="business" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="business" type="text" value="<?=$r['business'];?>"<?=$user['options'][2]==1?' placeholder="Enter a Business..."':' readonly';?> onkeyup="$('#bookingbusiness').html($(this).val());">
              <?=$user['options'][2]==1?'<button class="save" id="savebusiness" data-dbid="business" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        </div>
        <label id="bookingAddress" for="address"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingAddress" aria-label="PermaLink to Booking Address Field">&#128279;</a>':'';?>Address</label>
        <div class="form-row">
          <input class="textinput" id="address" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="address" type="text" value="<?=$r['address'];?>"<?=$user['options'][2]==1?' placeholder="Enter an Address..."':' readonly';?>>
          <?=$user['options'][2]==1?'<button class="save" id="saveaddress" data-dbid="address" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <div class="row">
          <div class="col-12 col-sm-3 pr-md-3">
            <label id="bookingSuburb" for="suburb"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingSuburb" aria-label="PermaLink to Booking Suburb Field">&#128279;</a>':'';?>Suburb</label>
            <div class="form-row">
              <input class="textinput" id="suburb" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="suburb" type="text" value="<?=$r['suburb'];?>"<?=$user['options'][2]==1?' placeholder="Enter a Suburb..."':' readonly';?>>
              <?=$user['options'][2]==1?'<button class="save" id="savesuburb" data-dbid="suburb" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-3 pr-md-3">
            <label id="bookingCity" for="city"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingCity" aria-label="PermaLink to Booking City Field">&#128279;</a>':'';?>City</label>
            <div class="form-row">
              <input class="textinput" id="city" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="city" type="text" value="<?=$r['city'];?>"<?=$user['options'][2]==1?' placeholder="Enter a City..."':' readonly';?>>
              <?=$user['options'][2]==1?'<button class="save" id="savecity" data-dbid="city" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-3 pr-md-3">
            <label id="bookingState" for="state"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingState" aria-label="PermaLink to Booking State Field">&#128279;</a>':'';?>State</label>
            <div class="form-row">
              <input class="textinput" id="state" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="state" type="text" value="<?=$r['state'];?>"<?=$user['options'][2]==1?' placeholder="Enter a State..."':' readonly';?>>
              <?=$user['options'][2]==1?'<button class="save" id="savestate" data-dbid="state" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-3">
            <label id="bookingPostcode" for="postcode"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingPostcode" aria-label="PermaLink to Booking Postcode Field">&#128279;</a>':'';?>Postcode</label>
            <div class="form-row">
              <input class="textinput" id="postcode" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="postcode" type="text" value="<?=$r['postcode']!=0?$r['postcode']:'';?>"<?=$user['options'][2]==1?' placeholder="Enter a Postcode..."':' readonly';?>>
              <?=$user['options'][2]==1?'<button class="save" id="savepostcode" data-dbid="postcode" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        </div>
        <label id="bookingService" for="rid" class="col-form-label col-12 col-sm-1 px-0"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingService" aria-label="PermaLink to Booking Service Selector">&#128279;</a>':'';?>Service</label>
        <div class="form-row">
          <select id="rid" name="rid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="rid"<?=$user['options'][2]==0?' disabled':'';?> onchange="update('<?=$r['id'];?>','content','rid',$(this).val(),'select');">
            <option value="0">Select an Item...</option>
<?php $sql=$db->query("SELECT `id`,`contentType`,`code`,`title`,`assoc` FROM `".$prefix."content` WHERE `bookable`='1' AND `title`!='' AND `status`='published' AND `internal`!='1' ORDER BY `code` ASC,`title` ASC");
            if($sql->rowCount()>0){
              while($row=$sql->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$row['id'].'"'.($r['rid']==$row['id']?' selected':'').'>'.ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'].'</option>';
            }?>
          </select>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-1">
            <label id="bookingNotes" for="notes"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingNotes" aria-label="PermaLink to Booking Notes">&#128279;</a>':'';?>Notes</label>
            <div class="form-row">
              <?=$user['options'][2]==1?'<form class="w-100" id="summernote" target="sp" method="post" action="core/update.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="content"><input name="c" type="hidden" value="notes"><textarea class="notes" id="notes" name="da">'.rawurldecode(($r['notes']==''?$config['bookingNoteTemplate']:$r['notes'])).'</textarea></form>':'<div class="form-control" style="background:#fff;color:#000">'.rawurldecode($r['notes']).'</div>';?>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label id="bookingResult" for="notes2"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingResult" aria-label="PermaLink to Booking Result">&#128279;</a>':'';?>Result</label>
            <div class="form-row">
              <?=$user['options'][2]==1?'<form class="w-100" id="summernote2" target="sp" method="post" action="core/update.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="content"><input name="c" type="hidden" value="notes2"><textarea class="notes" id="notes2" name="da">'.rawurldecode($r['notes2']).'</textarea></form>':'<div class="form-control" style="background:#fff;color:#000">'.rawurldecode($r['notes2']).'</div>';?>
            </div>
          </div>
        </div>
        <hr>
        <?php if($config['bookingAgreement']!=''){?>
          <div class="row mt-3">
            <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#agreementCheck" aria-label="PermaLink to Booking Agreement Confirmation Checkbox">&#128279;</a>':'';?>
            <input id="agreementCheck" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="agreementCheck" data-dbb="0" type="checkbox"<?=$r['agreementCheck'][0]==1?' checked aria-checked="true"':' aria-checked="fale"';?>>
            <label for="agreementCheck" id="contentagreementCheck0<?=$r['id'];?>"><?=$config['bookingAgreement'];?></label>
          </div>
        <?php }?>
        <label id="bookingSignature" for="signature" class="mt-3"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingSignature" aria-label="PermaLink to Booking Signature">&#128279;</a>':'';?>Signature</label>
        <div class="row">
          <div class="col-12 col-md-11">
            <div class="form-row">
              <div class="form-text border" id="signature" onmouseup="saveSignature(`<?=$r['id'];?>`,`content`,`signature`);"></div>
            </div>
          </div>
          <div class="col-12 col-md-1">
            <button class="btn-block trash" onclick="clearSignature(`<?=$r['id'];?>`,`content`,`signature`);">Reset</button>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 col-md-6 pr-md-1">
            <label id="bookingTechnician" for="uid"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingTechnician" aria-label="PermaLink to Booking Technician Selector">&#128279;</a>':'';?>Technician</label>
            <div class="form-row">
              <select id="uid" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="uid"<?=$user['options'][2]==0?' disabled':'';?> onchange="update('<?=$r['id'];?>','content','uid',$(this).val(),'select');">
                <option value="0">Select a Technician</option>
                <?php $st=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `rank`>499 ORDER BY `name` ASC");
                $st->execute();
                if($st->rowCount()>0){
                  while($rt=$st->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rt['id'].'"'.($rt['id']==$r['uid']?' selected':'').'>'.$rt['username'].'['.$r['name'].']</option>';
                }?>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-6 pl-md-3">
            <label id="bookingHours" for="cost"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/edit/'.$r['id'].'#bookingHours" aria-label="PermaLink to Booking Hours Field">&#128279;</a>':'';?>Hours</label>
            <div class="form-row">
              <input class="textinput" id="cost" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="cost" type="text" value="<?=$r['cost']!=0?$r['cost']:'';?>"<?=$user['options'][2]==1?' placeholder="Enter Hours..."':' readonly';?>>
              <?=$user['options'][2]==1?'<button class="save" id="savecost" data-dbid="cost" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<script src="core/js/jSignature/jSignature.min.js"></script>
<script>
  function saveSignature(id,t,c){
    var datapair=$("#signature").jSignature("getData","default");
    $.ajax({
  		type:"POST",
  		url:"core/update.php",
  		data:{
  			id:id,
  			t:t,
  			c:c,
  			da:datapair
  		}
  	}).done(function(msg){});
  }
  function clearSignature(id,t,c){
    $("#signature").jSignature("clear");
    $.ajax({
      type:"POST",
      url:"core/update.php",
      data:{
        id:id,
        t:t,
        c:c,
        da:''
      }
    }).done(function(msg){});
  }
  $(document).ready(function(){
    $('.notes').summernote({
      isNotSplitEdgePoint:true,
      tabsize:2,
      lang:'en-US',
      toolbar:
        [
          ['save',['save']],
          ['checkbox',['checkbox']],
          ['para',['ul','ol']],
          ['view',['fullscreen','codeview']]
        ],
        callbacks:{
          onInit:function(){
            $('body > .note-popover').appendTo(".note-editing-area");
          }
        }
    });
    $("#signature").jSignature({color:"#000"});
<?php if($r['signature']!=''){?>
    $("#signature").jSignature("importData",'<?=$r['signature'];?>');
<?php }?>
  });
</script>
