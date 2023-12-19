<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Agronomy - Edit Area
 * @package    core/layout/edit_agronomyarea.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_agronomy.php';
else{
  $sa=$db->prepare("SELECT * FROM `".$prefix."agronomy_areas` WHERE `id`=:id");
  $sa->execute([':id'=>$args[1]]);
  $ra=$sa->fetch(PDO::FETCH_ASSOC);?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/agronomy';?>">Agronomy</a></li>
                  <li class="breadcrumb-item active">Edit</i>
                  <li class="breadcrumb-item active breadcrumb-dropdown p-0 pl-3 m-0">
                    <?php $ss=$db->prepare("SELECT `id`,`name` FROM `".$prefix."agronomy_areas` WHERE `id`!=:id ORDER BY `id` ASC");
                    $ss->execute([':id'=>$ra['id']]);
                    echo$ra['name'].
                    '<span class="breadcrumb-dropdown mx-2"><i class="i pt-1">chevron-down</i></span>'.
                    '<ol class="breadcrumb-dropper">';
                      while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
                        echo'<li><a href="'.URL.$settings['system']['admin'].'/agronomy/area/'.$rs['id'].'">'.$rs['name'].'</a></li>';
                      }
                    echo'</ol>';
                    $sp=$db->prepare("SELECT `id` AS `prev` FROM `".$prefix."agronomy_areas` WHERE `id`<:id ORDER BY `id` DESC LIMIT 1");
                    $sp->execute([':id'=>$ra['id']]);
                    $prev=$sp->fetch(PDO::FETCH_ASSOC);
                    $sn=$db->prepare("SELECT `id` AS `next` FROM `".$prefix."agronomy_areas` WHERE `id`>:id ORDER BY `id` ASC LIMIT 1");
                    $sn->execute([':id'=>$ra['id']]);
                    $next=$sn->fetch(PDO::FETCH_ASSOC);
                    echo'<a class="btn btn-sm btn-ghost"'.($sp->rowCount()>0?' href="'.URL.$settings['system']['admin'].'/agronomy/area/'.$prev['prev'].'" data-tooltip="tooltip" aria-label="Go to previous Livestock."':' disabled="true"').'><i class="i'.($sp->rowCount()>0?'':' text-muted').'">arrow-left</i></a>'.
                    '<a class="btn btn-sm btn-ghost"'.($sn->rowCount()>0?' href="'.URL.$settings['system']['admin'].'/agronomy/area/'.$next['next'].'" data-tooltip="tooltip" aria-label="Go to next Livestock."':' disabled="true"').'><i class="i'.($sn->rowCount()>0?'':' text-muted').'">arrow-right</i></a>';?>
                  </li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                  ($user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/agronomy/settings" role="button" aria-label="Agronomy Settings"><i class="i">settings</i></a>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-5 col-lg-4 col-xl-3 col-xxl-2">
              <label class="mt-0" for="name">Name</label>
              <div class="form-row">
                <input class="textinput" id="name" data-dbid="<?=$ra['id'];?>" data-dbt="agronomy_areas" data-dbc="name" type="text" value="<?=$ra['name'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?> onkeyup="updatePopup('name',$(this).val());">
                <?=$user['options'][1]==1?'<button class="save" id="savename" data-dbid="name" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label for="color">Color</label>
              <div class="form-row">
                <input class="textinput p-0" id="color" data-dbid="<?=$ra['id'];?>" data-dbt="agronomy_areas" data-dbc="color" type="color" value="<?=($ra['color']==''?'#3388ff':$ra['color']);?>"<?=$user['options'][1]==1?' placeholder="Select a Color..."':' readonly';?> oninput="polygonColor($(this).val());">
                <?=$user['options'][1]==1?'<button class="save" id="savecolor" data-dbid="color" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label for="code">Code</label>
              <div class="form-row">
                <input class="textinput" id="code" data-dbid="<?=$ra['id'];?>" data-dbt="agronomy_areas" data-dbc="code" type="text" value="<?=$ra['code'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Code..."':' readonly';?> onkeyup="updatePopup('code',$(this).val());">
                <?=$user['options'][1]==1?'<button class="save" id="savecode" data-dbid="code" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <label for="type">Type</label>
              <div class="form-row">
                <input class="textinput" id="type" list="agronomy_types" data-dbid="<?=$ra['id'];?>" data-dbt="agronomy_areas" data-dbc="type" type="text" value="<?=$ra['type'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Type..."':' readonly';?> onkeyup="updatePopup('type',$(this).val());">
                <?=$user['options'][1]==1?'<button class="save" id="savetype" data-dbid="type" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                <datalist id="agronomy_types">
                <?php $s=$db->prepare("SELECT DISTINCT `type` FROM `".$prefix."agronomy_areas` WHERE `type`!='' ORDER BY `type` ASC ");
                $s->execute();
                echo
                  '<option value="Barbecue"/>'.
                  '<option value="Barn"/>'.
                  '<option value="Beehive"/>'.
                  '<option value="Coup"/>'.
                  '<option value="Crop"/>'.
                  '<option value="Dam"/>'.
                  '<option value="Firewood"/>'.
                  '<option value="Forage"/>'.
                  '<option value="Forest"/>'.
                  '<option value="Fuel"/>'.
                  '<option value="Grazing"/>'.
                  '<option value="Greenhouse"/>'.
                  '<option value="House"/>'.
                  '<option value="Jungle"/>'.
                  '<option value="Paddock"/>'.
                  '<option value="Pasture"/>'.
                  '<option value="Pen"/>'.
                  '<option value="Sawmill"/>'.
                  '<option value="Shed"/>'.
                  '<option value="Silo"/>'.
                  '<option value="Silvopasture"/>'.
                  '<option value="Stable"/>'.
                  '<option value="Swamp"/>'.
                  '<option value="Water"/>'.
                  '<option value="Wind Turbine"/>'.
                  '<option value="Woodland"/>';
                if($s->rowCount()>0){
                  while($r=$s->fetch(PDO::FETCH_ASSOC)){
                    if($r['type']=='Barbecue')continue;
                    if($r['type']=='Barn')continue;
                    if($r['type']=='Beehive')continue;
                    if($r['type']=='Coup')continue;
                    if($r['type']=='Crop')continue;
                    if($r['type']=='Dam')continue;
                    if($r['type']=='Forage')continue;
                    if($r['type']=='Forest')continue;
                    if($r['type']=='Grazing')continue;
                    if($r['type']=='Greenhouse')continue;
                    if($r['type']=='House')continue;
                    if($r['type']=='Jungle')continue;
                    if($r['type']=='Paddock')continue;
                    if($r['type']=='Pasture')continue;
                    if($r['type']=='Pen')continue;
                    if($r['type']=='Sawmill')continue;
                    if($r['type']=='Shed')continue;
                    if($r['type']=='Silo')continue;
                    if($r['type']=='Silvopasture')continue;
                    if($r['type']=='Stable')continue;
                    if($r['type']=='Swamp')continue;
                    if($r['type']=='Water')continue;
                    if($r['type']=='Wind Turbine')continue;
                    if($r['type']=='Woodland')continue;
                    echo'<option value="'.$r['type'].'"/>';
                  }
                }?>
                </datalist>
              </div>
              <label for="condition">Condition</label>
              <div class="form-row">
                <input class="textinput" id="condition" list="agronomy_conditions" data-dbid="<?=$ra['id'];?>" data-dbt="agronomy_areas" data-dbc="condition" type="text" value="<?=$ra['condition'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Condition..."':' readonly';?> onkeyup="updatePopup('condition',$(this).val());">
                <?=$user['options'][1]==1?'<button class="save" id="savecondition" data-dbid="condition" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                <datalist id="agronomy_conditions">
                  <?php $s=$db->prepare("SELECT DISTINCT `condition` FROM `".$prefix."agronomy_areas` WHERE `condition`!='' ORDER BY `condition` ASC ");
                  $s->execute();
                  echo
                    '<option value="Arable"/>'.
                    '<option value="Arid"/>'.
                    '<option value="Degraded"/>'.
                    '<option value="Desertified"/>'.
                    '<option value="Dry"/>'.
                    '<option value="Dusty"/>'.
                    '<option value="Fallow"/>'.
                    '<option value="NonArable"/>'.
                    '<option value="Swamp"/>'.
                    '<option value="Wet"/>'.
                    '<option value="Wetland"/>';
                  if($s->rowCount()>0){
                    while($r=$s->fetch(PDO::FETCH_ASSOC)){
                      if($r['condition']=='Arable')continue;
                      if($r['condition']=='Arid')continue;
                      if($r['condition']=='Degraded')continue;
                      if($r['condition']=='Desertified')continue;
                      if($r['condition']=='Dry')continue;
                      if($r['condition']=='Dusty')continue;
                      if($r['condition']=='Fallow')continue;
                      if($r['condition']=='NonArable')continue;
                      if($r['condition']=='Swamp')continue;
                      if($r['condition']=='Wet')continue;
                      if($r['condition']=='Wetland')continue;
                      echo'<option value="'.$r['condition'].'"/>';
                    }
                  }?>
                </datalist>
              </div>
              <label for="activity">Activity</label>
              <div class="form-row">
                <input class="textinput" id="activity" list="agronomy_activity" data-dbid="<?=$ra['id'];?>" data-dbt="agronomy_areas" data-dbc="activity" type="text" value="<?=$ra['activity'];?>"<?=$user['options'][1]==1?' placeholder="Enter an Activity..."':' readonly';?> onkeyup="updatePopup('activity',$(this).val());">
                <?=$user['options'][1]==1?'<button class="save" id="saveactivity" data-dbid="activity" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                <datalist id="agronomy_activity">
                  <?php $s=$db->prepare("SELECT DISTINCT `activity` FROM `".$prefix."agronomy_areas` WHERE `activity`!='' ORDER BY `activity` ASC");
                  $s->execute();
                  echo'<option value="Cultivating"/>'.
                    '<option value="Grazing"/>'.
                    '<option value="Growing"/>'.
                    '<option value="Irrigation"/>'.
                    '<option value="Resting"/>';
                  if($s->rowCount()>0){
                    while($r=$s->fetch(PDO::FETCH_ASSOC)){
                      if($r['activity']=='Cultivating')continue;
                      if($r['activity']=='Grazing')continue;
                      if($r['activity']=='Growing')continue;
                      if($r['activity']=='Irrigation')continue;
                      if($r['activity']=='Resting')continue;
                      echo'<option value="'.$r['activity'].'"/>';
                    }
                  }?>
                </datalist>
              </div>
              <label for="notes">Notes</label>
              <div class="form-row">
                <div class="input-text" data-el="notes" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter Notes..."><?=$ra['notes'];?></div>
                <input class="textinput d-none" id="notes" data-dbid="<?=$ra['id'];?>" data-dbt="agronomy_areas" data-dbc="notes" type="text" value="<?=$ra['notes'];?>">
                <button class="save" id="savenotes" data-dbid="notes" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
              </div>
              <input type="hidden" id="areageolayout<?=$ra['id'];?>" value="<?=$ra['geo_layout'];?>">
            </div>
            <div class="col-sm m-1">
              <div id="map" style="height:100vh;"></div>
            </div>
          </div>
          <script src="core/js/leaflet/leaflet.draw.js"></script>
          <link rel="stylesheet" type="text/css" href="core/js/leaflet/leaflet.draw.css" media="all">
          <script>
            function updatePopup(el,txt){
              if(txt!=''){
                if(el!='code'){
                  txto='<strong>';
                  if(el=='type')txto+='Type';
                  if(el=='condition')txto+='Condition';
                  if(el=='activity')txto+='Activity';
                  txt=txto+':</strong> '+txt;
                }
              }
              $('#popup'+el).html(txt);
            }
<?php
             if($ra['geo_position']==''){?>
              navigator.geolocation.getCurrentPosition(
                function(position){
                  var map=L.map('map').setView([position.coords.latitude,position.coords.longitude],13);
                  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
                    attribution:'',
                    maxZoom:20,
                    id:'mapbox/streets-v11',
                    tileSize:512,
                    zoomOffset:-1,
                    accessToken:'<?=$config['mapapikey'];?>'
                  }).addTo(map);
                  map.attributionControl.setPrefix('');
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
                  marker.on('dragend',function(event){
                    var marker=event.target;
                    var position=marker.getLatLng();
                    update('<?=$ra['id'];?>','agronomy_areas','geo_position',position.lat+','+position.lng);
                    window.top.window.toastr["success"]("Map Marker position updated!");
                    marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                    map.panTo(new L.LatLng(position.lat,position.lng))
                  });
                },
                function(){
                  var map=L.map('map').setView([<?=$config['geo_position'];?>],4);
                  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
                    attribution:'',
                    maxZoom:19,
                    id:'mapbox/streets-v11',
                    tileSize:512,
                    zoomOffset:-1,
                    accessToken:'<?=$config['mapapikey'];?>'
                  }).addTo(map);
                  map.attributionControl.setPrefix('');
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
                  window.top.window.toastr["info"]("Unable to get your location via browser, location has been set so you can choose!");
                  marker.on('dragend',function(event){
                    var marker=event.target;
                    var position=marker.getLatLng();
                    update('<?=$ra['id'];?>','agronomy_areas','geo_position',position.lat+','+position.lng);
                    window.top.window.toastr["success"]("Map Marker position updated!");
                    marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                    map.panTo(new L.LatLng(position.lat,position.lng))
                  });
                }
              );
            <?php }else{?>
              var map=L.map('map').setView([<?=$ra['geo_position'];?>],19);
              // https://tile.openstreetmap.org/{z}/{x}/{y}.png
              L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
                attribution:'',
                maxZoom:19,
                id:'mapbox/streets-v11',
                tileSize:512,
                zoomOffset:-1,
                accessToken:'<?=$config['mapapikey'];?>'
              }).addTo(map);
              map.attributionControl.setPrefix('');
              var myIcon=L.icon({
                iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                iconSize:[38,95],
                iconAnchor:[22,94],
                popupAnchor:[-3,-76],
                shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                shadowSize:[68,95],
                shadowAnchor:[22,94]
              });
<?php if($ra['geo_position']!=''){?>
              var marker=L.marker([<?=$ra['geo_position'];?>],{draggable:<?=($user['options'][7]==1?'true':'false');?>,}).addTo(map);
              var popupHtml=`<div>`+
                `<strong id="popupname"><?=$ra['name'];?></strong><span class="small text-muted ml-2 hidewhenempty" id="popupcode"><?=$ra['code'];?></span>`+
              `</div>`+
              `<div class="small hidewhenempty" id="popuptype"><?=($ra['type']!=''?'<strong>Type: </strong>'.$ra['type']:'');?></div>`+
              `<div class="small hidewhenempty" id="popupcondition"><?=($ra['condition']!=''?'<strong>Condition: </strong>'.$ra['condition']:'');?></div>`+
              `<div class="small hidewhenempty" id="popupactivity"><?=($ra['activity']!=''?'<strong>Activity: </strong>'.$ra['activity']:'');?></div>`+
              <?php $sl=$db->prepare("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."agronomy_livestock` WHERE `aid`=:aid");
              $sl->execute([':aid'=>$ra['id']]);
              $rl=$sl->fetch(PDO::FETCH_ASSOC);?>
              `<div class="small hidewhenempty" id="popupstock"><?=($rl['cnt']>0?'<strong>Stock: </strong>'.$rl['cnt']:'');?></div>`;
              var popup=L.popup({
                closeOnClick:null,
                closeButton:false
              }).setContent(popupHtml);
              marker.bindPopup(popup).openPopup();
<?php }?>
              marker.on('dragend',function(event){
                var marker=event.target;
                var position=marker.getLatLng();
                update('<?=$ra['id'];?>','agronomy_areas','geo_position',position.lat+','+position.lng);
                window.top.window.toastr["success"]("Map Marker position updated!");
                marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                map.panTo(new L.LatLng(position.lat,position.lng))
              });
              var editableLayers=new L.FeatureGroup();
              map.addLayer(editableLayers);
              var drawPluginOptions={
                position:'topleft',
                draw:{
                  polygon:{
                    allowIntersection:false, // Restricts shapes to simple polygons
                    drawError:{
                      color:'#3388ff', // Color the shape will turn when intersects
                      message:'<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
                    },
                    shapeOptions:{
                      color:'#3388ff'
                    }
                  },
                  // disable toolbar item by setting it to false
                  polyline:false,
                  circle:false, // Turns off this drawing tool
                  rectangle:false,
                  marker:false,
                },
                edit:{
                  featureGroup:editableLayers, //REQUIRED!!
                  remove:true
                }
              };

              // Initialise the draw control and pass it the FeatureGroup of editable layers
              var drawControl=new L.Control.Draw(drawPluginOptions);
              map.addControl(drawControl);

              var editableLayers=new L.FeatureGroup();
              map.addLayer(editableLayers);

              map.on('draw:created',function(e){
                var type=e.layerType,
                layer=e.layer;
          //      if(type==='marker'){
          //        layer.bindPopup('A popup!');
          //      }
                if(type==='polygon'){
                  $('#areageolayout<?=$ra['id'];?>').val(layer.getLatLngs());
                  update('<?=$ra['id'];?>','agronomy_areas','geo_layout',$('#areageolayout<?=$ra['id'];?>').val());
                }
                editableLayers.addLayer(layer);
              });
              <?php $area=str_replace('LatLng(','[',$ra['geo_layout']);
              $area=str_replace(')',']',$area);
              $ra['color']=($ra['color']==''?'#3388ff':$ra['color']);?>
              var polygon=L.polygon([<?=$area;?>],{color:'<?=$ra['color'];?>',weight:1,fillColor:'<?=$ra['color'];?>',fillOpacity:.15}).addTo(map);
            <?php }?>
            function polygonColor(col){
              polygon.setStyle({
                color:col,
                fillColor:col
              });
            }
          </script>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
