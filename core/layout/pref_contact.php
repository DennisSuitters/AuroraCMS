<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Contact
 * @package    core/layout/pref_contact.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Contact</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <fieldset>
          <legend>Business Hours</legend>
          <div class="form-group row">
            <div class="col-12 col-sm-4">
              <div class="row">
                <div class="input-group col-3">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options19" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="19"<?php echo$config['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options19" class="col-form-label">Business Hours</label>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="row">
                <div class="input-group col-3">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options20" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="20"<?php echo$config['options'][20]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options20" class="col-form-label">Use Short Day Names</label>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="row">
                <div class="input-group col-3">
                  <label class="switch switch-label switch-success"><input type="checkbox" id="options21" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="21"<?php echo$config['options'][21]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                </div>
                <label for="options21" class="col-form-label">User 24 Hour Digits</label>
              </div>
            </div>
          </div>
          <form target="sp" method="post" action="core/add_data.php">
            <input type="hidden" name="user" value="0">
            <input type="hidden" name="act" value="add_hours">
            <div class="form-group row">
              <div class="input-group col-12">
                <label for="from" class="input-group-text">From</label>
                <select id="from" class="form-control" name="from">
                  <option value="monday">Monday</option>
                  <option value="tuesday">Tueday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>
                </select>
                <label for="to" class="input-group-text">To</label>
                <select id="to" class="form-control" name="to">
                  <option value="monday">Monday</option>
                  <option value="tuesday">Tuesday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>
                </select>
                <label for="hourstimefrom" class="input-group-text">Time From</label>
                <input id="hourstimefrom" type="time" class="form-control" name="timefrom">
                <label for="hourstimeto" class="input-group-text">Time To</label>
                <input id="hourstimeto" type="time" class="form-control" name="timeto">
                <label for="hoursinfo" class="input-group-text">Aditional Text</label>
                <select id="hoursinfo" class="form-control" name="info">
                  <option value="">No Additional Information</option>
                  <option value="closed">Closed</option>
                  <option value="call for assistance">Call for Assistance</option>
                  <option value="call for help">Call for Help</option>
                  <option value="call for a quote">Call for a Quote</option>
                  <option value="call to book">Call to book</option>
                </select>
                <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button></div>
              </div>
            </div>
          </form>
          <div id="hours">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='hours' AND uid=0 ORDER BY icon ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="form-group row">
              <div class="input-group col-12">
                <div class="input-group-text">From</div>
                <input type="text" class="form-control" value="<?php echo ucfirst($rs['username']);?>" readonly>
                <div class="input-group-text">To</div>
                <input type="text" class="form-control" value="<?php echo ucfirst($rs['password']);?>" readonly>
                <div class="input-group-text">Time From</div>
                <input type="text" class="form-control" value="<?php echo $rs['tis'];?>" readonly>
                <div class="input-group-text">Time From</div>
                <input type="text" class="form-control" value="<?php echo $rs['tie'];?>" readonly>
                <div class="input-group-text">Additional Info</div>
                <input type="text" class="form-control" value="<?php echo $rs['title'];?>" readonly>
                <div class="input-group-append">
                  <form target="sp" action="core/purge.php">
                    <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                    <input type="hidden" name="t" value="choices">
                    <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php echo svg('trash');?></button>
                  </form>
                </div>
              </div>
            </div>
<?php }?>
          </div>
        </fieldset>
        <hr>
        <div class="form-group row">
          <div class="col-12 col-sm-4">
            <div class="row">
              <div class="input-group col-3">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options22" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="22"<?php echo$config['options'][22]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options22" class="col-form-label">Display Address</label>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="row">
              <div class="input-group col-3">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options23" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="23"<?php echo$config['options'][23]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options23" class="col-form-label">Display Email</label>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="row">
              <div class="input-group col-3">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options24" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="24"<?php echo$config['options'][24]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
              <label for="options24" class="col-form-label">Display Phone Numbers</label>
            </div>
          </div>
        </div>
        <div id="businessErrorBlock" class="alert alert-danger<?php echo$config['business']!=''?' hidden':'';?>" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Bookings will NOT function currectly.</div>
        <div id="businessHasError" class="form-group row<?php echo($config['business']==''?' has-error':'');?>">
          <label for="business" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Business</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="Enter a Business...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="abn" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">ABN</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="Enter an ABN...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveabn" class="btn btn-secondary save" data-dbid="abn" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div id="emailErrorBlock" class="alert alert-danger<?php echo$config['email']!=''?' hidden':'';?>" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly.</div>
        <div id="emailHasError" class="form-group row<?php echo$config['email']==''?' has-error':'';?>">
          <label for="email" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Email</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Phone</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="Enter a Phone...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mobile" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Mobile</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="Enter a Mobile...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savemobile" class="btn btn-secondary save" data-dbid="mobile" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Address</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="Enter an Address...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="suburb" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Suburb</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="Enter a Suburb...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">City</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="Enter a City...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="state" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">State</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="Enter a State...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="postcode" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Postcode</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="postcode" class="form-control textinput" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="Enter a Postcode...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="country" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Country</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="Enter a Country...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savecountry" class="btn btn-secondary save" data-dbid="country" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
