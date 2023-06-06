<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Agronomy
 * @package    core/layout/agronomy.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 https://github.com/ProminentEdge/leaflet-measure-path

 agronomy_log
  id
  rid
  agtype
  weight
  height
  length
  stage
  behaviour
  preg scan data
  Feedlot growth rate data
  Condition scores
  Mid side sample
  geo_location
  notes
  ti
 */
if(isset($args[0])){
  if($args[0]=='area')
    require'core/layout/edit_agronomyarea.php';
  elseif($args[0]=='settings')
    require'core/layout/set_livestock.php';
}else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="alert alert-warning">The Agronomy section is still under development, use at your own peril.</div>
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
                  <?php $sa=$db->prepare("SELECT * FROM `".$prefix."agronomy_areas` ORDER BY `ti` ASC");
                  $sa->execute();
                  while($ra=$sa->fetch(PDO::FETCH_ASSOC)){?>
                    <div id="l_<?=$ra['id'];?>" class="card area my-1 p-2 small overflow-visible" data-dbid="<?=$ra['id'];?>">
                      <h6><?=$ra['name'].($ra['code']!=''?'<small class="ml-2">('.$ra['code'].')</small>':'');?></h6>
                      <div class="row">
                        <div class="col">
                          <div class="small text-center">Type</div>
                          <div class="text-center small" data-tooltip="tooltip" aria-label="<?=$ra['type'];?>">
                            <i class="i i-4x">area-<?= strtolower($ra['type']);?></i>
                            <div class="small"><?=$ra['type'];?></div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="small text-center">Stock</div>
                          <div class="text-center i-2x pt-3">
                            <?php $sl=$db->prepare("SELECT COUNT(DISTINCT `id`) AS cnt FROM `".$prefix."agronomy_livestock` WHERE `aid`=:aid");
                            $sl->execute([':aid'=>$ra['id']]);
                            $rl=$sl->fetch(PDO::FETCH_ASSOC);
                            echo short_number($rl['cnt']);?>
                          </div>
                        </div>
                        <div class="col">
                          <div class="small text-center">Condition</div>
                          <div class="text-center small" data-tooltip="tooltip" aria-label="<?=$ra['condition'];?>">
                            <i class="i i-4x">condition-<?= strtolower($ra['condition']);?></i>
                            <div class="small"><?=$ra['condition'];?></div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="small text-center">Activity</div>
                          <div class="text-center small" data-tooltip="tooltip" aria-label="<?=$ra['activity'];?>">
                            <i class="i i-4x">activity-<?= strtolower($ra['activity']);?></i>
                            <div class="small"><?=$ra['activity'];?></div>
                          </div>
                        </div>
                      </div>
                      <div class="row m-0 mt-3 p-0">
                        <div class="col-6 text-left m-0 p-0">
                          <a class="btn btn-sm" href="<?= URL.$settings['system']['admin'].'/agronomy/area/'.$ra['id'];?>" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>
                        </div>
                        <div class="col-6 text-right m-0 p-0">
                          <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$ra['id'];?>','agronomy_areas');"><i class="i">trash</i></button>
                        </div>
                      </div>
                    </div>
                  <?php }
                  /*?>
                  <script>
                    document.addEventListener('click',function(event){
                      if(event.target.closest(".area")){
                        var el=event.target.closest(".area");
                        event.preventDefault();
                        var elh=document.querySelectorAll(".area");
                        elh.forEach(function(elItem){elItem.classList.remove("area-selected");});
                        el.classList.add("area-selected");
                      }
                    });
                  </script>
                  */?>
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
                        <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('0','agronomy_livestock');"><i class="i">trash</i></button>
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
          <script src="core/js/leaflet/leaflet.draw.js"></script>
          <link rel="stylesheet" type="text/css" href="core/js/leaflet/leaflet.draw.css" media="all">
          <script>
              var map=L.map('map').setView([<?=$config['geo_position'];?>],19);
              L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
                attribution:'',
                maxZoom:19,
                id:'mapbox/streets-v11',
                tileSize:512,
                zoomOffset:-1,
                accessToken:'<?=$config['mapapikey'];?>'
              }).addTo(map);
              map.attributionControl.setPrefix('');
              var editableLayers=new L.FeatureGroup();
              map.addLayer(editableLayers);
              var agronomy=L.icon({iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png'});
<?php $sa=$db->prepare("SELECT * FROM `".$prefix."agronomy_areas` ORDER BY `ti` ASC");
$sa->execute();
while($ra=$sa->fetch(PDO::FETCH_ASSOC)){
              $area=str_replace('LatLng(','[',$ra['geo_layout']);
              $area=str_replace(')',']',$area);?>
              var area=[<?=$area;?>];
              var polygon<?=$ra['id'];?>=L.polygon(area,{color:'<?=($ra['color']!=''?$ra['color']:'#3388ff');?>',weight:1,fillColor:'<?=($ra['color']!=''?$ra['color']:'#3388ff');?>',fillOpacity:.15}).addTo(map);
              <?php if($ra['geo_position']!=''){?>
                var marker<?=$ra['id'];?>=L.marker([<?=$ra['geo_position'];?>],{icon:agronomy,draggable:false,}).addTo(map);
                var popupHtml<?=$ra['id'];?>=`<div>`+
                  `<strong id="popupname"><?=$ra['name'];?></strong><span class="small text-muted ml-2 hidewhenempty" id="popupcode"><?=$ra['code'];?></span>`+
                `</div>`+
                `<div class="small hidewhenempty" id="popuptype"><?=($ra['type']!=''?'<strong>Type: </strong>'.$ra['type']:'');?></div>`+
                `<div class="small hidewhenempty" id="popupcondition"><?=($ra['condition']!=''?'<strong>Condition: </strong>'.$ra['condition']:'');?></div>`+
                `<div class="small hidewhenempty" id="popupactivity"><?=($ra['activity']!=''?'<strong>Activity: </strong>'.$ra['activity']:'');?></div>`;
                var popup<?=$ra['id'];?>=L.popup({
                  closeOnClick:null,
                  closeButton:false,
                }).setContent(popupHtml<?=$ra['id'];?>);
                marker<?=$ra['id'];?>.bindPopup(popup<?=$ra['id'];?>,{autoClose:false}).addTo(map).openPopup();
              <?php }?>
<?php }?>
          </script>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
