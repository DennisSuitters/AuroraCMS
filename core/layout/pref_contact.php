<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Contact
 * @package    core/layout/pref_contact.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.18 Adjust Editable Fields for transitioning to new Styling and better Mobile Device layout.
 * @changes    v0.0.19 Fix Business Hours Selections to clear values.
 * @changes    v0.0.19 Add Drag to Reorder Business Hours items.
 * @changes    v0.0.19 Change Select for Additional Info to Text Input with Datalist.
 * @changes    v0.0.19 Add Save All button.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Contact</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a href="#" class="btn btn-ghost-normal saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields"><?php echo svg('save');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <fieldset>
          <legend>Business Hours</legend>
          <div class="form-group row">
            <div class="col-12 col-md-4">
              <div class="row">
                <div class="input-group col-3 col-md-4">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options19" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="19"<?php echo$config['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options19" class="col-form-label">Business Hours</label>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="row">
                <div class="input-group col-3 col-md-4">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options20" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="20"<?php echo$config['options'][20]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options20" class="col-form-label">Use Short Day Names</label>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="row">
                <div class="input-group col-3 col-md-4">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options21" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="21"<?php echo$config['options'][21]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options21" class="col-form-label">User 24 Hour Digits</label>
              </div>
            </div>
          </div>
          <form target="sp" method="post" action="core/add_data.php">
            <input type="hidden" name="user" value="0">
            <input type="hidden" name="act" value="add_hours">
            <div class="form-group row px-0">
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 pr-xl-0">
                <div class="input-group-prepend">
                  <label for="from" class="input-group-text">From </label>
                </div>
                <select id="from" class="form-control" name="from">
                  <option value="">No day</option>
                  <option value="monday">Monday</option>
                  <option value="tuesday">Tueday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>
                </select>
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 px-xl-0">
                <div class="input-group-prepend">
                  <label for="to" class="input-group-text">To</label>
                </div>
                <select id="to" class="form-control" name="to">
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
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 px-xl-0">
                <div class="input-group-prepend">
                  <label for="hourstimefrom" class="input-group-text">Time From</label>
                </div>
                <input id="hourstimefrom" type="time" class="form-control" name="timefrom">
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 px-xl-0">
                <div class="input-group-prepend">
                  <label for="hourstimeto" class="input-group-text">Time To</label>
                </div>
                <input id="hourstimeto" type="time" class="form-control" name="timeto">
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-3 px-xl-0">
                <div class="input-group-prepend">
                  <label for="hoursinfo" class="input-group-text">Aditional Text</label>
                </div>
                <input id="hoursinfo" class="form-control" name="info" list="hrsinfo">
                <datalist id="hrsinfo">
                  <option>Closed</option>
                  <option>By Appointment</option>
                  <option>Call for Assistance</option>
                  <option>Call for Help</option>
                  <option>Call for a Quote</option>
                  <option>Call to book</option>
                </datalist>
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-1 pl-xl-0">
                <div class="btn-group">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Clear Values" aria-label="Clear Values" onclick="$('#from,#to,#hourstimefrom,#hourstimeto,#hoursinfo').val('');return false;"><?php svg('eraser');?></button>
                  <button class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button>
                </div>
              </div>
            </div>
          </form>
          <div id="hours">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='hours' ORDER BY ord ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="form-group row px-0 item">
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 pr-xl-0">
                <div class="input-group-prepend">
                  <div class="input-group-text">From</div>
                </div>
                <input type="text" class="form-control" value="<?php echo ucfirst($rs['username']);?>" readonly>
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 px-xl-0">
                <div class="input-group-prepend">
                  <div class="input-group-text">To</div>
                </div>
                <input type="text" class="form-control" value="<?php echo ucfirst($rs['password']);?>" readonly>
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 px-xl-0">
                <div class="input-group-prepend">
                  <div class="input-group-text">Time From</div>
                </div>
                <input type="text" class="form-control" value="<?php echo $rs['tis'];?>" readonly>
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-2 px-xl-0">
                <div class="input-group-prepend">
                  <div class="input-group-text">Time To</div>
                </div>
                <input type="text" class="form-control" value="<?php echo $rs['tie'];?>" readonly>
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-3 px-xl-0">
                <div class="input-group-prepend">
                  <div class="input-group-text">Additional Info</div>
                </div>
                <input type="text" class="form-control" value="<?php echo $rs['title'];?>" readonly>
              </div>
              <div class="input-group col-12 col-md-6 col-lg-4 col-xl-1 pl-xl-0">
                <div class="btn-group">
                  <div class="btn btn-secondary" data-tooltip="tooltip" data-title="Drag to Reorder"><?php echo svg('drag');?></div>
                  <form target="sp" action="core/purge.php">
                    <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                    <input type="hidden" name="t" value="choices">
                    <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php echo svg('trash');?></button>
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
        </fieldset>
        <hr>
        <div class="form-group row">
          <div class="col-12 col-md-4">
            <div class="row">
              <div class="input-group col-3 col-md-4">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options22" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="22"<?php echo$config['options'][22]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options22" class="col-form-label">Display Address</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <div class="input-group col-3 col-md-4">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options23" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="23"<?php echo$config['options'][23]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options23" class="col-form-label">Display Email</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <div class="input-group col-3 col-md-4">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options24" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="24"<?php echo$config['options'][24]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options24" class="col-form-label">Display Phone Numbers</label>
            </div>
          </div>
        </div>
        <div id="businessErrorBlock" class="alert alert-danger<?php echo$config['business']!=''?' hidden':'';?>" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Bookings will NOT function currectly.</div>
        <div id="emailErrorBlock" class="alert alert-danger<?php echo$config['email']!=''?' hidden':'';?>" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly.</div>
        <div class="row">
          <div id="businessHasError" class="form-group<?php echo($config['business']==''?' has-error':'');?> col-12 col-md-4">
            <label for="business">Business</label>
            <div class="input-group">
              <input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="Enter a Business...">
              <div class="input-group-append">
                <button id="savebusiness" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="business" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-md-4">
            <label for="abn">ABN</label>
            <div class="input-group">
              <input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="Enter an ABN...">
              <div class="input-group-append">
                <button id="saveabn" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="abn" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div id="emailHasError" class="form-group<?php echo$config['email']==''?' has-error':'';?> col-12 col-md-4">
            <label for="email">Email</label>
            <div class="input-group">
              <input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
              <div class="input-group-append">
                <button id="saveemail" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="email" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-12 col-md-6">
            <label for="phone">Phone</label>
            <div class="input-group">
              <input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="Enter a Phone...">
              <div class="input-group-append">
                <button id="savephone" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="phone" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-md-6">
            <label for="mobile">Mobile</label>
            <div class="input-group">
              <input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="Enter a Mobile...">
              <div class="input-group-append">
                <button id="savemobile" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="mobile" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <div class="input-group">
            <input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="Enter an Address...">
            <div class="input-group-append">
              <button id="saveaddress" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="address" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-12 col-md-3">
            <label for="suburb">Suburb</label>
            <div class="input-group">
              <input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="Enter a Suburb...">
              <div class="input-group-append">
                <button id="savesuburb" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="suburb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-md-3">
            <label for="city">City</label>
            <div class="input-group">
              <input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="Enter a City...">
              <div class="input-group-append">
                <button id="savecity" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="city" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-md-3">
            <label for="state">State</label>
            <div class="input-group">
              <input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="Enter a State...">
              <div class="input-group-append">
                <button id="savestate" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="state" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-md-3">
            <label for="postcode">Postcode</label>
            <div class="input-group">
              <input type="text" id="postcode" class="form-control textinput" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="Enter a Postcode...">
              <div class="input-group-append">
                <button id="savepostcode" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="postcode" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="country">Country</label>
          <div class="input-group">
            <input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="Enter a Country...">
            <div class="input-group-append">
              <button id="savecountry" class="btn btn-secondary save" data-tooltip="tooltip" data-title="Save" data-dbid="country" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
