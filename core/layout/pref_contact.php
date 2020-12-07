<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Contact
 * @package    core/layout/pref_contact.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('address-card','i-3x');?></div>
          <div>Preferences - Contact</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php echo svg('save');?></a>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Contact</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <legend>Business Hours</legend>
        <div class="row mt-3">
          <div class="col-12 col-md-4">
            <div class="row">
              <input id="options19" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="19" type="checkbox"<?php echo$config['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="options19">Business Hours</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <input id="options20" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="20" type="checkbox"<?php echo$config['options'][20]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="options20">Use Short Day Names</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <input id="options21" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="21" type="checkbox"<?php echo$config['options'][21]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="options21">User 24 Hour Digits</label>
            </div>
          </div>
        </div>
        <form class="row" target="sp" method="post" action="core/add_hours.php">
          <input name="user" type="hidden" value="0">
          <input name="act" type="hidden" value="add_hours">
          <div class="col-12 col-md-2">
            <label for="from">From </label>
            <div class="form-row">
              <select id="from" name="from">
                <option value="">No day</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-2">
            <label for="to">To</label>
            <div class="form-row">
              <select id="to" name="to">
                <option value="">No day</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-2">
            <label for="hourstimefrom">Time From</label>
            <div class="form-row">
              <input id="hourstimefrom" type="time" name="timefrom">
            </div>
          </div>
          <div class="col-12 col-md-2">
            <label for="hourstimeto">Time To</label>
            <div class="form-row">
              <input id="hourstimeto" type="time" name="timeto">
            </div>
          </div>
          <div class="col-12 col-md-3">
            <label for="hoursinfo">Aditional Text</label>
            <div class="form-row">
              <input id="hoursinfo" name="info" list="hrsinfo">
              <datalist id="hrsinfo">
                <option>Closed</option>
                <option>By Appointment</option>
                <option>Call for Assistance</option>
                <option>Call for Help</option>
                <option>Call for a Quote</option>
                <option>Call to book</option>
              </datalist>
            </div>
          </div>
          <div class="col-12 col-md-1">
            <label>&nbsp;</label>
            <div class="form-row">
              <button class="trash" data-tooltip="tooltip" aria-label="Clear Values" onclick="$('#from,#to,#hourstimefrom,#hourstimeto,#hoursinfo').val('');return false;"><?php svg('eraser');?></button>
              <button class="add" data-tooltip="tooltip" aria-label="Add"><?php svg('add');?></button>
            </div>
          </div>
        </form>
        <div class="mt-3" id="hours">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='hours' ORDER BY `ord` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="row item mt-1">
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?php echo ucfirst($rs['username']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?php echo ucfirst($rs['password']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?php echo $rs['tis'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?php echo $rs['tie'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-row">
                  <input type="text" value="<?php echo $rs['title'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-1">
                <div class="form-row">
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><?php echo svg('trash');?></button>
                    &nbsp;&nbsp;<?php svg('drag','handle');?>
                  </form>
                </div>
              </div>
            </div>
          <?php }?>
          <div class="ghost hidden"></div>
        </div>
        <?php if($user['options'][1]==1){?>
          <script>
            $('#hours').sortable({
              items:"div.item",
              handle:'.handle',
              placeholder:".ghost",
              helper:fixWidthHelper,
              axis:"y",
              update:function(e,ui){
                var order=$("#hours").sortable("serialize");
                $.ajax({
                  type:"POST",
                  dataType:"json",
                  url:"core/reorderhours.php",
                  data:order
                });
              }
            }).disableSelection();
            function fixWidthHelper(e,ui){
              ui.children().each(function(){
                $(this).width($(this).width());
              });
              return ui;
            }
          </script>
        <?php }?>
        <div class="row mt-5">
          <div class="col-12 col-md-4">
            <div class="row">
              <input id="options22" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="22" type="checkbox"<?php echo$config['options'][22]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="options22">Display Address</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <input id="options23" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="23" type="checkbox"<?php echo$config['options'][23]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="options23">Display Email</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <input id="options24" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="24" type="checkbox"<?php echo$config['options'][24]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="options24">Display Phone Numbers</label>
            </div>
          </div>
        </div>
        <div class="alert alert-danger<?php echo$config['business']!=''?' hidden':'';?>" id="businessErrorBlock" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Bookings will NOT function currectly.</div>
        <div class="alert alert-danger<?php echo$config['email']!=''?' hidden':'';?>" id="emailErrorBlock" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly.</div>
        <div class="row mt-3">
          <div class="col-12 col-md-4 pr-md-2" id="businessHasError">
            <label for="business">Business</label>
            <div class="form-row">
              <input class="textinput" id="business" data-dbid="1" data-dbt="config" data-dbc="business" type="text" value="<?php echo$config['business'];?>" placeholder="Enter a Business...">
              <button class="save" id="savebusiness" data-tooltip="tooltip" data-dbid="business" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-4 pr-md-2">
            <label for="abn">ABN</label>
            <div class="form-row">
              <input class="textinput" id="abn" data-dbid="1" data-dbt="config" data-dbc="abn" type="text" value="<?php echo$config['abn'];?>" placeholder="Enter an ABN...">
              <button class="save" id="saveabn" data-tooltip="tooltip" data-dbid="abn" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div id="emailHasError" class="col-12 col-md-4">
            <label for="email">Email</label>
            <div class="form-row">
              <input class="textinput" id="email" data-dbid="1" data-dbt="config" data-dbc="email" type="text" value="<?php echo$config['email'];?>" placeholder="Enter an Email...">
              <button class="save" id="saveemail" data-tooltip="tooltip" data-dbid="email" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 pr-md-1">
            <label for="phone">Phone</label>
            <div class="form-row">
              <input class="textinput" id="phone" data-dbid="1" data-dbt="config" data-dbc="phone" type="text" value="<?php echo$config['phone'];?>" placeholder="Enter a Phone...">
              <button class="save" id="savephone" data-tooltip="tooltip" data-dbid="phone" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-6 pl-md-1">
            <label for="mobile">Mobile</label>
            <div class="form-row">
              <input class="textinput" id="mobile" data-dbid="1" data-dbt="config" data-dbc="mobile" type="text" value="<?php echo$config['mobile'];?>" placeholder="Enter a Mobile...">
              <button class="save" id="savemobile" data-tooltip="tooltip" data-dbid="mobile" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <label for="address" class="">Address</label>
        <div class="form-row">
          <input class="textinput" id="address" data-dbid="1" data-dbt="config" data-dbc="address" type="text" value="<?php echo$config['address'];?>" placeholder="Enter an Address...">
          <button class="save" id="saveaddress" data-tooltip="tooltip" data-dbid="address" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="row">
          <div class="col-12 col-md-3 pr-md-1">
            <label for="suburb">Suburb</label>
            <div class="form-row">
              <input class="textinput" id="suburb" data-dbid="1" data-dbt="config" data-dbc="suburb" type="text" value="<?php echo$config['suburb'];?>" placeholder="Enter a Suburb...">
              <button class="save" id="savesuburb" data-tooltip="tooltip" data-dbid="suburb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-3 pl-md-1 pr-md-1">
            <label for="city">City</label>
            <div class="form-row">
              <input class="textinput" id="city" data-dbid="1" data-dbt="config" data-dbc="city" type="text" value="<?php echo$config['city'];?>" placeholder="Enter a City...">
              <button class="save" id="savecity" data-tooltip="tooltip" data-dbid="city" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-3 pl-md-1 pr-md-1">
            <label for="state">State</label>
            <div class="form-row">
              <input class="textinput" id="state" data-dbid="1" data-dbt="config" data-dbc="state" type="text" value="<?php echo$config['state'];?>" placeholder="Enter a State...">
              <button class="save" id="savestate" data-tooltip="tooltip" data-dbid="state" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-3 pl-md-1">
            <label for="postcode">Postcode</label>
            <div class="form-row">
              <input class="textinput" id="postcode" data-dbid="1" data-dbt="config" data-dbc="postcode" type="text" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" placeholder="Enter a Postcode...">
              <button class="save" id="savepostcode" data-tooltip="tooltip" data-dbid="postcode" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <label for="country">Country</label>
        <div class="form-row">
          <input class="textinput" id="country" data-dbid="1" data-dbt="config" data-dbc="country" type="text" value="<?php echo$config['country'];?>" placeholder="Enter a Country...">
          <button class="save" id="savecountry" data-tooltip="tooltip" data-dbid="country" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
