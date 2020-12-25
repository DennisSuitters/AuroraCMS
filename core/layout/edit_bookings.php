<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Bookings - Edit
 * @package    core/layout/edit_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
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
          <div class="content-title-icon"><?php svg('calendar','i-3x');?></div>
          <div>Bookings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <a class="btn" data-tooltip="tooltip" href="#" aria-label="Print Order" onclick="$('#sp').load('core/print_booking.php?id=<?php echo$r['id'];?>');return false;"><?php svg('print');?></a>
            <?php if($user['options'][0]==1||$user['options'][2]==1){?>
              <a class="btn" data-tooltip="tooltip" href="#" aria-label="Email Booking" onclick="$('#sp').load('core/email_booking.php?id=<?php echo$r['id'];?>');return false;"><?php svg('email-send');?></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
          <li class="breadcrumb-item active"><span id="bookingname"><?php echo$r['name'];?></span>:<span id="bookingbusiness"><?php echo$r['business'];?></span></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="row">
          <div class="col-12 col-md-4 pr-md-2">
            <label for="tis">Booked</label>
            <div class="form-row">
              <input id="tis" type="datetime-local" value="<?php echo date('Y-m-d\TH:i',$r['tis']);?>" autocomplete="off" onchange="update(`<?php echo$r['id'];?>`,`content`,`tis`,getTimestamp(`tis`));">
            </div>
          </div>
          <div class="col-12 col-sm-4 pr-2">
            <label for="tie">To</label>
            <div class="form-row">
              <input id="tie" type="datetime-local" value="<?php echo date('Y-m-d\TH:i',($r['tie']==0?$r['tis']:$r['tie']));?>" autocomplete="off" onchange="update(`<?php echo$r['id'];?>`,`content`,`tie`,getTimestamp(`tie`));">
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <label for="status">Status</label>
            <div class="form-row">
              <select id="status" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status"<?php echo$user['options'][2]==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());">
                <option value="unconfirmed"<?php echo$r['status']=='unconfirmed'?' selected':'';?>>Unconfirmed</option>
                <option value="confirmed"<?php echo$r['status']=='confirmed'?' selected':'';?>>Confirmed</option>
                <option value="in-progress"<?php echo$r['status']=='in-progress'?' selected':'';?>>In Progress</option>
                <option value="complete"<?php echo$r['status']=='complete'?' selected':'';?>>Complete</option>
                <option value="archived"<?php echo$r['status']=='archived'?' selected':'';?>>Archived</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-1">
            <label for="cid">Client</label>
            <div class="form-row">
              <select id="cid" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid"<?php echo$user['options'][2]==0?' disabled':'';?> onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');">
                <option value="0"<?php echo$r['cid']=='0'?' selected':'';?>>Select an Account Client...</option>
                <?php $q=$db->query("SELECT `id`,`business`,`username`,`name` FROM `".$prefix."login` WHERE `status`!='delete' AND `status`!='suspended' AND `active`!='0' AND `id`!='0'");
                if($q->rowCount()>0){
                  while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';
                }?>
              </select>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label for="cid2">No Account Clients</label>
            <div class="form-row">
              <select id="cid2" data-dbt="content" data-dbc="cid"<?php echo$user['options'][2]==0?' disabled':'';?> onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'noaccount');">
                <option value="0"<?php echo$r['cid']=='0'?' selected':'';?>>Select Client without Account...</option>
                <?php $q=$db->query("SELECT `id`,`business`,`name` FROM `".$prefix."content` WHERE `contentType`='booking'");
                if($q->rowCount()>0){
                  while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['business'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';
                }?>
              </select>
            </div>
          </div>
        </div>
        <label for="email">Email</label>
        <div class="form-row">
          <input class="textinput" id="email" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" type="text" value="<?php echo$r['email'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter an Email..."':' readonly';?>>
          <?php echo$user['options'][2]==1?'<button class="save" id="saveemail" data-dbid="email" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 pr-md-1">
            <label for="phone">Phone</label>
            <div class="form-row">
              <input class="textinput" id="phone" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" type="text" value="<?php echo$r['phone'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter a Phone Number..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<button class="save" id="savephone" data-dbid="phone" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label for="mobile">Mobile</label>
            <div class="form-row">
              <input class="textinput" id="mobile" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="mobile" type="text" value="<?php echo$r['mobile'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter a Phone Number..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<button class="save" id="savemobile" data-dbid="mobile" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-1">
            <label for="name">Name</label>
            <div class="form-row">
              <input class="textinput" id="name" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" type="text" value="<?php echo$r['name'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter a Name..."':' readonly';?> onkeyup="$('#bookingname').html($(this).val());">
              <?php echo$user['options'][2]==1?'<button class="save" id="savename" data-dbid="name" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label for="business">Business</label>
            <div class="form-row">
              <input class="textinput" id="business" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" type="text" value="<?php echo$r['business'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter a Business..."':' readonly';?> onkeyup="$('#bookingbusiness').html($(this).val());">
              <?php echo$user['options'][2]==1?'<button class="save" id="savebusiness" data-dbid="business" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        </div>
        <label for="address">Address</label>
        <div class="form-row">
          <input class="textinput" id="address" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" type="text" value="<?php echo$r['address'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter an Address..."':' readonly';?>>
          <?php echo$user['options'][2]==1?'<button class="save" id="saveaddress" data-dbid="address" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
        </div>
        <div class="row">
          <div class="col-12 col-sm-3 pr-md-2">
            <label for="suburb">Suburb</label>
            <div class="form-row">
              <input class="textinput" id="suburb" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" type="text" value="<?php echo$r['suburb'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter a Suburb..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<button class="save" id="savesuburb" data-dbid="suburb" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-3 pr-md-2">
            <label for="city">City</label>
            <div class="form-row">
              <input class="textinput" id="city" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" type="text" value="<?php echo$r['city'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter a City..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<button class="save" id="savecity" data-dbid="city" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-3 pr-md-2">
            <label for="state">State</label>
            <div class="form-row">
              <input class="textinput" id="state" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" type="text" value="<?php echo$r['state'];?>"<?php echo$user['options'][2]==1?' placeholder="Enter a State..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<button class="save" id="savestate" data-dbid="state" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
          <div class="col-12 col-sm-3">
            <label for="postcode">Postcode</label>
            <div class="form-row">
              <input class="textinput" id="postcode" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" type="text" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>"<?php echo$user['options'][2]==1?' placeholder="Enter a Postcode..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<button class="save" id="savepostcode" data-dbid="postcode" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
            </div>
          </div>
        </div>
        <label for="rid" class="col-form-label col-12 col-sm-1 px-0">Service</label>
        <div class="form-row">
          <select id="rid" name="rid" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rid"<?php echo$user['options'][2]==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());">
            <option value="0">Select an Item...</option>
<?php $sql=$db->query("SELECT `id`,`contentType`,`code`,`title`,`assoc` FROM `".$prefix."content` WHERE `bookable`='1' AND `title`!='' AND `status`='published' AND `internal`!='1' ORDER BY `code` ASC,`title` ASC");
            if($sql->rowCount()>0){
              while($row=$sql->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$row['id'].'"'.($r['rid']==$row['id']?' selected':'').'>'.ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'].'</option>';
            }?>
          </select>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 pr-md-1">
            <label for="notes">Notes</label>
            <div class="form-row">
              <?php echo$user['options'][2]==1?'<form class="w-100" id="summernote" target="sp" method="post" action="core/update.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="content"><input name="c" type="hidden" value="notes"><textarea class="notes" id="notes" name="da">'.rawurldecode(($r['notes']==''?$config['bookingNoteTemplate']:$r['notes'])).'</textarea></form>':'<div class="form-control" style="background:#fff;color:#000">'.rawurldecode($r['notes']).'</div>';?>
            </div>
          </div>
          <div class="col-12 col-sm-6 pl-md-1">
            <label for="notes2">Result</label>
            <div class="form-row">
              <?php echo$user['options'][2]==1?'<form class="w-100" id="summernote2" target="sp" method="post" action="core/update.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="content"><input name="c" type="hidden" value="notes2"><textarea class="notes" id="notes2" name="da">'.rawurldecode($r['notes2']).'</textarea></form>':'<div class="form-control" style="background:#fff;color:#000">'.rawurldecode($r['notes2']).'</div>';?>
            </div>
          </div>
        </div>
        <hr>
        <?php if($config['bookingAgreement']!=''){?>
          <div class="row mt-3">
            <input id="agreementCheck" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="agreementCheck" data-dbb="0" type="checkbox"<?php echo$r['agreementCheck'][0]==1?' checked aria-checked="true"':' aria-checked="fale"';?>>
            <label for="agreementCheck">
              <?php echo$config['bookingAgreement'];?>
            </label>
          </div>
        <?php }?>
        <label for="signature" class="mt-3">Signature</label>
        <div class="row">
          <div class="col-12 col-md-11">
            <div class="form-row">
              <div class="form-text border" id="signature" onmouseup="saveSignature(`<?php echo$r['id'];?>`,`content`,`signature`);"></div>
            </div>
          </div>
          <div class="col-12 col-md-1">
            <button class="btn-block trash" onclick="clearSignature(`<?php echo$r['id'];?>`,`content`,`signature`);">Reset</button>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 col-md-6 pr-md-1">
            <label for="tech">Technician</label>
            <div class="form-row">
              <select id="tech" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="uid"<?php echo$user['options'][2]==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());">
                <option value="0">Select a Technician</option>
                <?php $st=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `rank`>499 ORDER BY `name` ASC");
                $st->execute();
                if($st->rowCount()>0){
                  while($rt=$st->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rt['id'].'"'.($rt['id']==$r['uid']?' selected':'').'>'.$rt['username'].'['.$r['name'].']</option>';
                }?>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-6 pl-md-1">
            <label for="tech">Hours</label>
            <div class="form-row">
              <input class="textinput" id="cost" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" type="text" value="<?php echo$r['cost']!=0?$r['cost']:'';?>"<?php echo$user['options'][2]==1?' placeholder="Enter Hours..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<button class="save" id="savecost" data-dbid="cost" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save">'.svg2('save').'</button>':'';?>
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
    var datapair = $("#signature").jSignature("getData", "default");
    $.ajax({
  		type:"POST",
  		url:"core/update.php",
  		data:{
  			id:id,
  			t:t,
  			c:c,
  			da:datapair
  		}
  	}).done(function(msg){

  	});
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
    $("#signature").jSignature("importData",'<?php echo$r['signature'];?>');
<?php }?>
  });
</script>
