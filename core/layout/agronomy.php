<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Livestock
 * @package    core/layout/livestock.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_livestock.php';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active">Agronomy</li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=($user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/agronomy/settings" role="button" aria-label="Agronomy Settings"><i class="i">settings</i></a>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-5 col-lg-4 col-xl-3 col-xxl-2">
              <div class="tabs" role="tablist">
                <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
                <label for="tab1-1">
                  <small>Areas</small>
                  <?=($user['options'][0]==1?'<button class="btn-sm add" data-fancybox data-type="ajax" data-src="" data-tooltip="left" href="core/layout/agronomyarea-add.php" role="button" aria-label="Add Area"><i class="i">add</i></button>':'');?>
                </label>
                <input class="tab-control" id="tab1-2" name="tabs" type="radio">
                <label for="tab1-2" class="small">
                  <small>Livestock</small>
                  <?=($user['options'][0]==1?'<button class="btn-sm add mr-0" data-fancybox data-type="ajax" data-src="" data-tooltip="left" href="core/layout/agronomylivestock-add.php" role="button" aria-label="Add Livestock"><i class="i">add</i></button>':'');?>
                </label>
                <input class="tab-control" id="tab1-3" name="tabs" type="radio">
                <label for="tab1-3" class="small">
                  <small>Cropping</small>
                  <?=($user['options'][0]==1?'<button class="btn-sm add mr-0" data-fancybox data-type="ajax" data-src="" data-tooltip="left" href="core/layout/agronomycrop-add.php" role="button" aria-label="Add Crop"><i class="i">add</i></button>':'');?>
                </label>
                <div id="agronomy_areas" class="tab1-1 border-top" data-tabid="tab1-1" role="tabpanel">
                  <div id="l_0" class="card my-1 p-2 overflow-visible">
                    <h6>Pasture Name <span class="small text-muted">(Code)</span></h6>
                    <div class="row">
                      <div class="col-4 small text-center">
                        <small>Type</small><br>
                        <i class="a a-3x"><?= svg('area-pasture');?></i>
                      </div>
                      <div class="col-4 small text-center">
                        <small>Condition</small><br>
                        <i class="a a-3x"><?= svg('agronomy');?></i>
                      </div>
                      <div class="col-4 small text-center">
                        <small>Activity</small><br>
                        <i class="a a-3x"><?= svg('activity-grazing');?></i>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 text-left m-0 p-0">
                        <a class="btn btn-sm" href="" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                      </div>
                      <div class="col-6 text-right m-0 p-0">
                        <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('0','agronomy_areas');"><i class="i">trash</i></button>
                      </div>
                    </div>
                  </div>
                  <?php $sa=$db->prepare("SELECT * FROM `".$prefix."agronomy_areas` ORDER BY `ti` ASC");
                  $sa->execute();
                  while($ra=$sa->fetch(PDO::FETCH_ASSOC)){?>
                    <div id="l_<?=$ra['id'];?>" class="card my-1 p-2 small overflow-visible">
                      <h6><?=$ra['name'];?></h6>
                      <?=($ra['code']!=''?'<div class="small">Code: '.$ra['code'].'</div>':'');?>
                      <div class="row">
                        <div class="col-4">
                          <div class="small text-center">Type</div>
                          <div class="text-center">
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="small text-center">Stock</div>
                          <div class="text-center">
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="small text-center">Activity</div>
                          <div class="text-center">
                          </div>
                        </div>
                      </div>
                      <div class="row m-0 p-0">
                        <div class="col-6 text-left m-0 p-0">
                          <a class="btn btn-sm" href="" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                        </div>
                        <div class="col-6 text-right m-0 p-0">
                          <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$ra['id'];?>','agronomy_areas');"><i class="i">trash</i></button>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
                <div id="agronomy_livestock" class="tab1-2 border-top" data-tabid="tab1-2" role="tabpanel">
                  <div id="l_0" class="card my-1 p-2 small overflow-visible">
                    <h6>Rowena <span class="small text-muted">(Code)</span></h6>
                    <div class="row">
                      <div class="col-4">
                        <div class="small text-center">Type</div>
                        <div class="text-center">
                          <i class="a a-4x"><?= svg('animal-sheep');?></i>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="small text-center">Stock</div>
                        <div class="text-center">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="small text-center">Activity</div>
                        <div class="text-center">
                        </div>
                      </div>
                    </div>
                    <div class="row m-0 p-0">
                      <div class="col-6 text-left m-0 p-0">
                        <a class="btn btn-sm" href="" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                      </div>
                      <div class="col-6 text-right m-0 p-0">
                        <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$rl['id'];?>','agronomy_livestock');"><i class="i">trash</i></button>
                      </div>
                    </div>
                  </div>
                  <?php $sl=$db->prepare("SELECT * FROM `".$prefix."agronomy_livestock` ORDER BY `ti` ASC");
                  $sl->execute();
                  while($rl=$sl->fetch(PDO::FETCH_ASSOC)){?>
                    <div id="l_<?=$rl['id'];?>" class="card my-1 p-2 small overflow-visible">
                      <h6><?=$rl['name'];?></h6>
                      <?=($rl['code']!=''?'<div class="small">Code: '.$rl['code'].'</div>':'');?>
                      <div class="row">
                        <div class="col-4">
                          <div class="small text-center">Type</div>
                          <div class="text-center">
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="small text-center">Stock</div>
                          <div class="text-center">
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="small text-center">Activity</div>
                          <div class="text-center">
                          </div>
                        </div>
                      </div>
                      <div class="row m-0 p-0">
                        <div class="col-6 text-left m-0 p-0">
                          <a class="btn btn-sm" href="" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                        </div>
                        <div class="col-6 text-right m-0 p-0">
                          <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$rl['id'];?>','agronomy_livestock');"><i class="i">trash</i></button>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
                <div id="agronomy_crops" class="tab1-3 border-top" data-tabid="tab1-3" role="tabpanel">
                </div>
              </div>
            </div>
            <div class="col-sm m-1">
              <div id="map" style="height:100vh;"></div>
            </div>
          </div>
          <script>
            <?php if($config['geo_position']==''){?>
              navigator.geolocation.getCurrentPosition(
                function(position){
                  var map=L.map('map').setView([position.coords.latitude,position.coords.longitude],13);
                  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
                    attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom:20,
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
                  var marker=L.marker([position.coords.latitude,position.coords.longitude],{draggable:<?=($user['options'][7]==1?'true':'false');?>,}).addTo(map);
                  window.top.window.toastr["info"]("Best location guess has been made from your browser location API!");
                  window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
<?php /*                  var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
                  marker.bindPopup(popupHtml).openPopup(); */ ?>
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
                  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
                    attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom:19,
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
                  var marker=L.marker([-24.287,136.406],{draggable:<?=($user['options'][7]==1?'true':'false');?>,}).addTo(map);
                  window.top.window.toastr["info"]("Unable to get your location via browser, location has been set so you can choose!");
<?php /*                  window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
                  var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
                  marker.bindPopup(popupHtml).openPopup(); */ ?>
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
              var map=L.map('map').setView([<?=$config['geo_position'];?>],19);
              L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
                attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom:19,
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
              var marker=L.marker([<?=$config['geo_position'];?>],{draggable:<?=($user['options'][7]==1?'true':'false');?>,}).addTo(map);
<?php /*              var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
              marker.bindPopup(popupHtml).openPopup(); */?>
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
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
