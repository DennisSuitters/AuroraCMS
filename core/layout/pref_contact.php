<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Contact
 * @package    core/layout/pref_contact.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('address-card','i-3x');?></div>
          <div>Preferences - Contact</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></a>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Contact</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <legend id="prefBusinessHoursSection"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefBusinessHoursSection" data-tooltip="tooltip" aria-label="PermaLink to Preferences Business Hours Section">&#128279;</a>':'';?>Business Hours</legend>
        <div class="row mt-3">
          <div class="col-12 col-md-4">
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefBusinessHours" data-tooltip="tooltip" aria-label="PermaLink to Preferences Business Hours Checkbox">&#128279;</a>':'';?>
              <input id="prefBusinessHours" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="19" type="checkbox"<?=$config['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="prefBusinessHours" id="configoptions191">Business Hours</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefShortDayNames" data-tooltip="tooltip" aria-label="PermaLink to Preferences Short Day Names Checkbox">&#128279;</a>':'';?>
              <input id="prefShortDayNames" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="20" type="checkbox"<?=$config['options'][20]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="prefShortDayNames" id="configoptions201">Use Short Day Names</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#pref24HourDigits" data-tooltip="tooltip" aria-label="PermaLink to Preferences 24 Hour Digits Checkbox">&#128279;</a>':'';?>
              <input id="pref24HourDigits" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="21" type="checkbox"<?=$config['options'][21]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label for="pref24HourDigits" id="configoptions211">Use 24 Hour Digits</label>
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
              <input id="hourstimefrom" name="timefrom" type="time">
            </div>
          </div>
          <div class="col-12 col-md-2">
            <label for="hourstimeto">Time To</label>
            <div class="form-row">
              <input id="hourstimeto" name="timeto" type="time">
            </div>
          </div>
          <div class="col-12 col-md-3">
            <label for="hoursinfo">Additional Text</label>
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
              <button class="trash" data-tooltip="tooltip" aria-label="Clear Values" onclick="$('#from,#to,#hourstimefrom,#hourstimeto,#hoursinfo').val('');return false;"><?= svg2('eraser');?></button>
              <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
            </div>
          </div>
        </form>
        <div class="mt-3" id="hours">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='hours' ORDER BY `ord` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?=$rs['id'];?>" class="row item mt-1">
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?= ucfirst($rs['username']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?= ucfirst($rs['password']);?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?= $rs['tis'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="form-row">
                  <input type="text" value="<?= $rs['tie'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-row">
                  <input type="text" value="<?= $rs['title'];?>" readonly>
                </div>
              </div>
              <div class="col-12 col-md-1">
                <div class="form-row">
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?=$rs['id'];?>">
                    <input name="t" type="hidden" value="choices">
                    <button class="purge trash" type="submit" data-tooltip="tooltip" aria-label="Delete"><?= svg2('trash');?></button>
                    &nbsp;&nbsp;<?= svg2('drag','handle');?>
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
        <hr>
        <legend>Business Contact Details</legend>
        <div class="row mt-5">
          <div class="col-12 col-md-4">
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefDisplayAddress" data-tooltip="tooltip" aria-label="PermaLink to Preferences Display Address Checkbox">&#128279;</a>':'';?>
              <input id="prefDisplayAddress" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="22" type="checkbox"<?=$config['options'][22]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configoptions221" for="prefDisplayAddress">Display Address</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefDisplayEmail" data-tooltip="tooltip" aria-label="PermaLink to Preferences Display Email Checkbox">&#128279;</a>':'';?>
              <input id="prefDisplayEmail" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="23" type="checkbox"<?=$config['options'][23]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configoptions231" for="prefDisplayEmail">Display Email</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefDisplayPhone" data-tooltip="tooltip" aria-label="PermaLink to Preferences Display Phone Checkbox">&#128279;</a>':'';?>
              <input id="prefDisplayPhone" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="24" type="checkbox"<?=$config['options'][24]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
              <label id="configoptions241" for="prefDisplayPhone">Display Phone Numbers</label>
            </div>
          </div>
        </div>
        <div class="alert alert-danger<?=$config['business']!=''?' hidden':'';?>" id="businessErrorBlock" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Bookings will NOT function currectly.</div>
        <div class="alert alert-danger<?=$config['email']!=''?' hidden':'';?>" id="emailErrorBlock" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly.</div>
        <div class="row mt-3">
          <div class="col-12 col-md-4 pr-md-2" id="businessHasError">
            <label id="prefBusinessName" for="business"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefBusinessName" data-tooltip="tooltip" aria-label="PermaLink to Preferences Business Name Field">&#128279;</a>':'';?>Business&nbsp;Name</label>
            <div class="form-row">
              <input class="textinput" id="business" data-dbid="1" data-dbt="config" data-dbc="business" type="text" value="<?=$config['business'];?>" placeholder="Enter a Business Name...">
              <button class="save" id="savebusiness" data-dbid="business" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-4 pr-md-2">
            <label id="prefABN" for="abn"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefABN" data-tooltip="tooltip" aria-label="PermaLink to Preferences ABN Field">&#128279;</a>':'';?>ABN</label>
            <div class="form-row">
              <input class="textinput" id="abn" data-dbid="1" data-dbt="config" data-dbc="abn" type="text" value="<?=$config['abn'];?>" placeholder="Enter an ABN...">
              <button class="save" id="saveabn" data-dbid="abn" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-4" id="emailHasError">
            <label id="prefEmail" for="email"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefEmail" data-tooltip="tooltip" aria-label="PermaLink to Preferences Email Field">&#128279;</a>':'';?>Email</label>
            <div class="form-row">
              <input class="textinput" id="email" data-dbid="1" data-dbt="config" data-dbc="email" type="text" value="<?=$config['email'];?>" placeholder="Enter an Email...">
              <button class="save" id="saveemail" data-dbid="email" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 pr-md-1">
            <label id="prefPhone" for="phone"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefPhone" data-tooltip="tooltip" aria-label="PermaLink to Preferences Phone Field">&#128279;</a>':'';?>Phone</label>
            <div class="form-row">
              <input class="textinput" id="phone" data-dbid="1" data-dbt="config" data-dbc="phone" type="text" value="<?=$config['phone'];?>" placeholder="Enter a Phone...">
              <button class="save" id="savephone" data-dbid="phone" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-6 pl-md-1">
            <label id="prefMobile" for="mobile"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefMobile" data-tooltip="tooltip" aria-label="PermaLink to Preferences Mobile Field">&#128279;</a>':'';?>Mobile</label>
            <div class="form-row">
              <input class="textinput" id="mobile" data-dbid="1" data-dbt="config" data-dbc="mobile" type="text" value="<?=$config['mobile'];?>" placeholder="Enter a Mobile...">
              <button class="save" id="savemobile" data-dbid="mobile" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
        </div>
        <label id="prefAddress" for="address"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefAddress" data-tooltip="tooltip" aria-label="PermaLink to Preferences Address Field">&#128279;</a>':'';?>Address</label>
        <div class="form-row">
          <input class="textinput" id="address" data-dbid="1" data-dbt="config" data-dbc="address" type="text" value="<?=$config['address'];?>" placeholder="Enter an Address...">
          <button class="save" id="saveaddress" data-dbid="address" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div class="row">
          <div class="col-12 col-md-3 pr-md-1">
            <label id="prefSuburb" for="suburb"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefSuburb" data-tooltip="tooltip" aria-label="PermaLink to Preferences Suburb Field">&#128279;</a>':'';?>Suburb</label>
            <div class="form-row">
              <input class="textinput" id="suburb" data-dbid="1" data-dbt="config" data-dbc="suburb" type="text" value="<?=$config['suburb'];?>" placeholder="Enter a Suburb...">
              <button class="save" id="savesuburb" data-dbid="suburb" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-3 pl-md-1 pr-md-1">
            <label id="prefCity" for="city"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefCity" data-tooltip="tooltip" aria-label="PermaLink to Preferences City Field">&#128279;</a>':'';?>City</label>
            <div class="form-row">
              <input class="textinput" id="city" data-dbid="1" data-dbt="config" data-dbc="city" type="text" value="<?=$config['city'];?>" placeholder="Enter a City...">
              <button class="save" id="savecity" data-dbid="city" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-3 pl-md-1 pr-md-1">
            <label id="prefState" for="state"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefState" data-tooltip="tooltip" aria-label="PermaLink to Preferences State Field">&#128279;</a>':'';?>State</label>
            <div class="form-row">
              <input class="textinput" id="state" data-dbid="1" data-dbt="config" data-dbc="state" type="text" value="<?=$config['state'];?>" placeholder="Enter a State...">
              <button class="save" id="savestate" data-dbid="state" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-12 col-md-3 pl-md-1">
            <label id="prefPostcode" for="postcode"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefPostcode" data-tooltip="tooltip" aria-label="PermaLink to Preferences Postcode Field">&#128279;</a>':'';?>Postcode</label>
            <div class="form-row">
              <input class="textinput" id="postcode" data-dbid="1" data-dbt="config" data-dbc="postcode" type="text" value="<?=$config['postcode']!=0?$config['postcode']:'';?>" placeholder="Enter a Postcode...">
              <button class="save" id="savepostcode" data-dbid="postcode" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
        </div>
        <label id="prefCountry" for="country"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefCountry" data-tooltip="tooltip" aria-label="PermaLink to Preferences Country Field">&#128279;</a>':'';?>Country</label>
        <div class="form-row">
          <input class="textinput" id="country" data-dbid="1" data-dbt="config" data-dbc="country" type="text" value="<?=$config['country'];?>" placeholder="Enter a Country...">
          <button class="save" id="savecountry" data-dbid="country" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="prefMapAPIKey" for="mapapikey"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefMapAPIKey" data-tooltip="tooltip" aria-label="PermaLink to Preferences Map API Key Field">&#128279;</a>':'';?>Map Box API Key</label>
        <div class="form-row">
          <input class="textinput" id="mapapikey" data-dbid="1" data-dbt="config" data-dbc="mapapikey" type="text" value="<?=$config['mapapikey'];?>" placeholder="Enter an API Key from Map Box...">
          <button class="save" id="savemapapikey" data-dbid="mapapikey" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div class="col-12 mt-3">
          <div class="row">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/contact#prefMapDisplay" data-tooltip="tooltip" aria-label="PermaLink to Preferences Map Display Checkbox">&#128279;</a>':'';?>
            <input id="prefMapDisplay" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="27" type="checkbox"<?=$config['options'][27]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="prefMapDisplay" id="configoptions271">Enable Map Display</label>
          </div>
        </div>
<?php if($config['mapapikey']==''){?>
        <div class="col-12">
          There is currently no Map API Key entered above, to allow Maps to be displayed on pages.<br>
          Maps are displayed with the help of the Leaflet addon for it's ease of use.<br>
          To obtain an API Key to access Mapping, please register at <a href="https://account.mapbox.com/access-tokens/">Map Box</a>.
        </div>
<?php }else{?>
        <div class="col-12">
          <div class="form-text">Drag the map marker to update your Location.</div>
        </div>
        <div class="col-12">
          <div class="row" style="height:600px;" id="map"></div>
        </div>
        <script>
        <?php if($config['geo_position']==''){?>
          navigator.geolocation.getCurrentPosition(
            function(position){
              var map=L.map('map').setView([position.coords.latitude,position.coords.longitude],13);
              L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom:18,
                id:'mapbox/streets-v11',
                tileSize:512,
                zoomOffset:-1,
                accessToken:'<?=$config['mapapikey'];?>'
              }).addTo(map);
              var myIcon=L.icon({
                iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                iconSize:[38,95],
                iconAnchor:[22,94],
                popupAnchor:[-3,-76],
                shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                shadowSize:[68,95],
                shadowAnchor:[22,94]
              });
              var marker=L.marker([position.coords.latitude,position.coords.longitude],{draggable:true,}).addTo(map);
              window.top.window.toastr["info"]("Best location guess has been made from your browser location API!");
              window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
              var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
              marker.bindPopup(popupHtml).openPopup();
              marker.on('dragend',function(event){
                var marker=event.target;
                var position=marker.getLatLng();
                update('1','config','geo_position',position.lat+','+position.lng);
                window.top.window.toastr["success"]("Map Marker position updated!");
                marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                map.panTo(new L.LatLng(position.lat,position.lng))
              });
            },
            function(){
              var map=L.map('map').setView([-24.287,136.406],4);
              L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom:18,
                id:'mapbox/streets-v11',
                tileSize:512,
                zoomOffset:-1,
                accessToken:'<?=$config['mapapikey'];?>'
              }).addTo(map);
              var myIcon=L.icon({
                iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                iconSize:[38,95],
                iconAnchor:[22,94],
                popupAnchor:[-3,-76],
                shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                shadowSize:[68,95],
                shadowAnchor:[22,94]
              });
              var marker=L.marker([-24.287,136.406],{draggable:true,}).addTo(map);
              window.top.window.toastr["info"]("Unable to get your location via browser, location has been set so you can choose!");
              window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
              var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
              marker.bindPopup(popupHtml).openPopup();
              marker.on('dragend',function(event){
                var marker=event.target;
                var position=marker.getLatLng();
                update('1','config','geo_position',position.lat+','+position.lng);
                window.top.window.toastr["success"]("Map Marker position updated!");
                marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                map.panTo(new L.LatLng(position.lat,position.lng))
              });
            }
          );
        <?php }else{?>
          var map=L.map('map').setView([<?=$config['geo_position'];?>],13);
          L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
            attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom:18,
            id:'mapbox/streets-v11',
            tileSize:512,
            zoomOffset:-1,
            accessToken:'<?=$config['mapapikey'];?>'
          }).addTo(map);
          var myIcon=L.icon({
            iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
            iconSize:[38,95],
            iconAnchor:[22,94],
            popupAnchor:[-3,-76],
            shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
            shadowSize:[68,95],
            shadowAnchor:[22,94]
          });
          var marker=L.marker([<?=$config['geo_position'];?>],{draggable:true,}).addTo(map);
          var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
          marker.bindPopup(popupHtml).openPopup();
          marker.on('dragend',function(event){
            var marker=event.target;
            var position=marker.getLatLng();
            update('1','config','geo_position',position.lat+','+position.lng);
            window.top.window.toastr["success"]("Map Marker position updated!");
            marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
            map.panTo(new L.LatLng(position.lat,position.lng))
          });
        <?php }?>
        </script>
<?php }
        require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
