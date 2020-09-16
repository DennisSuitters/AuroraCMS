<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Bookings - Edit
 * @package    core/layout/edit_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.18 Add extra editing fields for Job accounting.
 * @changes    v0.0.19 Add Save All button.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
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
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
    <li class="breadcrumb-item active"><span id="bookingname"><?php echo$r['name'];?></span>:<span id="bookingbusiness"><?php echo$r['business'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
        <a href="#" class="btn btn-ghost-normal" onclick="$('#sp').load('core/print_booking.php?id=<?php echo$r['id'];?>');return false;" data-tooltip="tooltip" data-title="Print Order" aria-label="Print Order"><?php svg('print');?></a>
        <?php if($user['options'][0]==1||$user['options'][2]==1){?>
          <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_booking.php?id=<?php echo$r['id'];?>');return false;" data-tooltip="tooltip" data-placement="left" data-title="Email Booking" aria-label="Email"><?php svg('email-send');?></a>
        <?php }?>
        <a href="#" class="btn btn-ghost-normal saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields"><?php echo svg('save');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="row">
      <div class="card col-12">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-4">
              <div class="form-group row">
                <label for="tis" class="col-form-label col-12 col-sm-3 px-0">Booked</label>
                <div class="input-group col-12 col-sm-9">
                  <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>"<?php echo$user['options'][2]==1?'':'value="'.date($config['dateFormat'],$r['tis']).'" readonly';?>>
                  <input type="hidden" id="tisx" value="<?php echo$r['tis'];?>">
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savetis" class="btn btn-secondary save" data-dbid="tis" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="form-group row">
                <label for="tie" class="col-form-label col-12 col-sm-4 px-0">To</label>
                <div class="input-group col-12 col-sm-8">
                  <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" data-datetime="<?php echo date($config['dateFormat'],($r['tie']!=0?$r['tie']:$r['tis']));?>" autocomplete="off"<?php echo$user['options'][2]==1?'':' value="'.date($config['dateFormat'],($r['tie']!=0?$r['tie']:$r['tis'])).'" readonly';?>>
                  <input type="hidden" id="tiex" value="<?php echo$r['tie'];?>">
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savetie" class="btn btn-secondary save" data-dbid="tie" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="form-group row">
                <label for="status" class="col-form-label col-12 col-sm-4 px-0">Status</label>
                <div class="input-group col-12 col-sm-8">
                  <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status"<?php echo$user['options'][2]==0?' disabled':'';?>>
                    <option value="unconfirmed"<?php echo$r['status']=='unconfirmed'?' selected':'';?>>Unconfirmed</option>
                    <option value="confirmed"<?php echo$r['status']=='confirmed'?' selected':'';?>>Confirmed</option>
                    <option value="in-progress"<?php echo$r['status']=='in-progress'?' selected':'';?>>In Progress</option>
                    <option value="complete"<?php echo$r['status']=='complete'?' selected':'';?>>Complete</option>
                    <option value="archived"<?php echo$r['status']=='archived'?' selected':'';?>>Archived</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="cid" class="col-form-label col-12 col-sm-2 px-0">Client</label>
                <div class="input-group col-12 col-sm-10">
                  <select id="cid" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid"<?php echo$user['options'][2]==0?' disabled':'';?>>
                    <option value="0"<?php echo$r['cid']=='0'?' selected':'';?>>Select an Account Client...</option>
                    <?php $q=$db->query("SELECT `id`,`business`,`username`,`name` FROM `".$prefix."login` WHERE `status`!='delete' AND `status`!='suspended' AND `active`!='0' AND `id`!='0'");
                    if($q->rowCount()>0){
                      while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';
                    }?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="cid2" class="col-form-label col-12 col-sm-4 px-0">No Account Clients</label>
                <div class="input-group col-12 col-sm-8">
                  <select id="cid2" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'noaccount');" data-dbt="content" data-dbc="cid"<?php echo$user['options'][2]==0?' disabled':'';?>>
                    <option value="0"<?php echo$r['cid']=='0'?' selected':'';?>>Select Client without Account...</option>
                    <?php $q=$db->query("SELECT `id`,`business`,`name` FROM `".$prefix."content` WHERE `contentType`='booking'");
                    if($q->rowCount()>0){
                      while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['business'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';
                    }?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-form-label col-12 col-sm-1 px-0">Email</label>
            <div class="input-group col-12 col-sm-11">
              <input type="text" id="email" class="form-control textinput" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email"<?php echo$user['options'][2]==1?' placeholder="Enter an Email..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="phone" class="col-form-label col-12 col-sm-2 px-0">Phone</label>
                <div class="input-group col-12 col-sm-10">
                  <input type="text" id="phone" class="form-control textinput" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone"<?php echo$user['options'][2]==1?' placeholder="Enter a Phone Number..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="mobile" class="col-form-label col-12 col-sm-2 px-0">Mobile</label>
                <div class="input-group col-12 col-sm-10">
                  <input type="text" id="mobile" class="form-control textinput" name="mobile" value="<?php echo$r['mobile'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="mobile"<?php echo$user['options'][2]==1?' placeholder="Enter a Phone Number..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savemobile" class="btn btn-secondary save" data-dbid="mobile" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="name" class="col-form-label col-12 col-sm-2 px-0">Name</label>
                <div class="input-group col-12 col-sm-10">
                  <input type="text" id="name" class="form-control textinput" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" onkeyup="$('#bookingname').html($(this).val());"<?php echo$user['options'][2]==1?' placeholder="Enter a Name..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="business" class="col-form-label col-12 col-sm-3 px-0">Business</label>
                <div class="input-group col-12 col-sm-9">
                  <input type="text" id="business" class="form-control textinput" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" onkeyup="$('#bookingbusiness').html($(this).val());"<?php echo$user['options'][2]==1?' placeholder="Enter a Business..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="address" class="col-form-label col-12 col-sm-1 px-0">Address</label>
            <div class="input-group col-12 col-sm-11">
              <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address"<?php echo$user['options'][2]==1?' placeholder="Enter an Address..."':' readonly';?>>
              <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-3">
              <div class="form-group row">
                <label for="suburb" class="col-form-label col-12 col-sm-4 px-0">Suburb</label>
                <div class="input-group col-12 col-sm-7">
                  <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb"<?php echo$user['options'][2]==1?' placeholder="Enter a Suburb..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3">
              <div class="form-group row">
                <label for="city" class="col-form-label col-12 col-sm-3 px-0">City</label>
                <div class="input-group col-12 col-sm-9">
                  <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city"<?php echo$user['options'][2]==1?' placeholder="Enter a City..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3">
              <div class="form-group row">
                <label for="state" class="col-form-label col-12 col-sm-3 px-0">State</label>
                <div class="input-group col-12 col-sm-9">
                  <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state"<?php echo$user['options'][2]==1?' placeholder="Enter a State..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3">
              <div class="form-group row">
                <label for="postcode" class="col-form-label col-12 col-sm-5 px-0">Postcode</label>
                <div class="input-group col-12 col-sm-7">
                  <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode"<?php echo$user['options'][2]==1?' placeholder="Enter a Postcode..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="rid" class="col-form-label col-12 col-sm-1 px-0">Service</label>
            <div class="input-group col-12 col-sm-11">
              <select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rid"<?php echo$user['options'][2]==0?' disabled':'';?>>
                <option value="0">Select an Item...</option>
                <?php $sql=$db->query("SELECT `id`,`contentType`,`code`,`title`,`assoc` FROM `".$prefix."content` WHERE `bookable`='1' AND `title`!='' AND `status`='published' AND `internal`!='1' ORDER BY `code` ASC,`title` ASC");
                if($sql->rowCount()>0){
                  while($row=$sql->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$row['id'].'"'.($r['rid']==$row['id']?' selected':'').'>'.ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'].'</option>';?>
                }?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="notes" class="col-form-label col-12 col-sm-2 px-0">Notes</label>
                <div class="input-group col-12 col-sm-10">
                  <?php echo$user['options'][2]==1?'<form id="summernote" class="w-100" method="post" target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$r['id'].'"><input type="hidden" name="t" value="content"><input type="hidden" name="c" value="notes"><textarea id="notes" class="notes" name="da">'.rawurldecode(($r['notes']==''?$config['bookingNoteTemplate']:$r['notes'])).'</textarea></form>':'<div class="form-control" style="background:#fff;color:#000">'.rawurldecode($r['notes']).'</div>';?>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="notes2" class="col-form-label col-12 col-sm-2 px-0">Result</label>
                <div class="input-group col-12 col-sm-10">
                  <?php echo$user['options'][2]==1?'<form id="summernote2" class="w-100" method="post" target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$r['id'].'"><input type="hidden" name="t" value="content"><input type="hidden" name="c" value="notes2"><textarea id="notes2" class="notes" name="da">'.rawurldecode($r['notes2']).'</textarea></form>':'<div class="form-control" style="background:#fff;color:#000">'.rawurldecode($r['notes2']).'</div>';?>
                </div>
              </div>
            </div>
          </div>
          <?php if($config['bookingAgreement']!=''){?>
            <div class="form-inline row">
              <div class="input-group col-12 col-sm-11 offset-sm-1">
                <div class="input-group-text w-10">
                  <input id="agreementCheck" type="checkbox" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="agreementCheck" data-dbb="0"<?php echo$r['agreementCheck'][0]==1?' checked aria-checked="true"':' aria-checked="fale"';?>>
                </div>
                <label for="agreementCheck" class="input-group-text col text-wrap">
                  <?php echo$config['bookingAgreement'];?>
                </label>
              </div>
            </div>
          <?php }?>
          <div class="form-group row">
            <label for="signature" class="col-form-label col-12 col-sm-1 px-0">Signature</label>
            <div class="input-group col-12 col-sm-11">
              <div id="signature" class="form-control" onmouseup="saveSignature(`<?php echo$r['id'];?>`,`content`,`signature`);"></div>
              <div class="input-group-append">
                <button class="btn btn-secondary trash" onclick="clearSignature(`<?php echo$r['id'];?>`,`content`,`signature`);">Reset</button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="tech" class="col-form-label col-12 col-sm-2 px-0">Technician</label>
                <div class="input-group col-12 col-sm-10">
                  <select id="tech" class="form-control" onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="uid"<?php echo$user['options'][2]==0?' disabled':'';?>>
                    <option value="0">Select a Technician</option>
                    <?php $st=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `rank`>499 ORDER BY `name` ASC");
                    $st->execute();
                    if($st->rowCount()>0){
                      while($rt=$st->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rt['id'].'"'.($rt['id']==$r['uid']?' selected':'').'>'.$rt['username'].'['.$r['name'].']</option>';
                    }?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group row">
                <label for="tech" class="col-form-label col-12 col-sm-2 px-0">Hours</label>
                <div class="input-group col-12 col-sm-10">
                  <input type="text" id="cost" class="form-control textinput" name="cost" value="<?php echo$r['cost']!=0?$r['cost']:'';?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost"<?php echo$user['options'][2]==1?' placeholder="Enter Hours..."':' readonly';?>>
                  <?php echo$user['options'][2]==1?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savecost" class="btn btn-secondary save" data-dbid="cost" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button></div>':'';?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="core/js/jSignature.min.js"></script>
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
    (function(factory){
      if(typeof define==='function'&&define.amd){
        define(['jquery'],factory);
      }else if(typeof module==='object'&&module.exports){
        module.exports=factory(require('jquery'));
      }else{
        factory(window.jQuery);
      }
    }(function($){
      $.extend($.summernote.plugins,{
        'checkbox':function(context){
          var self=this;
          var ui=$.summernote.ui;
          this.createCheckbox=function(){
            var elem=document.createElement('input');
            elem.type="checkbox";
              return elem;
          }
          this.initialize=function(){
            var layoutInfo =context.layoutInfo;
            var $editor=layoutInfo.editor;
            $editor.click(function(event){
              if (event.target.type&&event.target.type=='checkbox'){
                var checked=$(event.target).is(':checked');
                $(event.target).attr('checked',checked);
                context.invoke('insertText','');
              }
            });
          };
        }
      });
    }));
    $('.notes').summernote({
      isNotSplitEdgePoint:true,
      tabsize:2,
      lang:'en-US',
      toolbar:
        [
          ['save',['save']],
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
