<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Add Agronomy Area
 * @package    core/layout/agronomyarea-add.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'../db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');?>
<div class="fancybox-ajax p-2">
  <h5>Add an Agronomy Area</h5>
  <iframe id="sp" name="sp" class="d-none"></iframe>
  <form id="agronmyform" target="sp" method="post" action="core/add_agronomyarea.php">
    <div class="quickedit">
      <label for="agronomyareaname">Name</label>
      <div class="form-row">
        <input type="text" id="agronmyname" name="name" value="" placeholder="Enter a Name...">
      </div>
      <label for="agronomyareatype">Type</label>
      <div class="form-row">
        <input type="text" id="agronomytype" list="agronomy_types" name="type" value="" placeholder="Select or Enter a Type...">
        <?php $s=$db->prepare("SELECT DISTINCT `type` FROM `".$prefix."agronomy_areas` WHERE `type`!='' ORDER BY `type` ASC ");
        $s->execute();
        echo'<datalist id="agronomy_types">'.
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
          '<option value="Grazing"/'.
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
        }
        echo'</datalist>';?>
      </div>
      <label for="agronomycode">Code</label>
      <div class="form-row">
        <input type="text" id="agronomycode" name="code" value="" placeholder="Enter a Code...">
      </div>
      <div class="row">
        <div class="col-12 col-sm-6">
          <label for="agronomycondition">Condition</label>
          <div class="form-row">
            <input type="text" id="agronomycondition" list="agronomy_conditions" name="condition" value="" placeholder="Enter a Condition...">
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
                '<option value="wet"/>'.
                '<option value="Wetland"/>';
              if($s->rowCount()>0){
                while($r=$s->fetch(PDO::FETCH_ASSOC)){
                  if($r['type']=='Arable')continue;
                  if($r['type']=='Arid')continue;
                  if($r['type']=='Degraded')continue;
                  if($r['type']=='Desertified')continue;
                  if($r['type']=='Dry')continue;
                  if($r['type']=='Dusty')continue;
                  if($r['type']=='Fallow')continue;
                  if($r['type']=='NonArable')continue;
                  if($r['type']=='Swamp')continue;
                  if($r['type']=='wet')continue;
                  if($r['type']=='Wetland')continue;
                  echo'<option value="'.$r['type'].'"/>';
                }
              }?>
            </datalist>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <label for="agronomyactivity">Activity</label>
          <div class="form-row">
            <input type="text" id="agronomyactivity" list="agronomy_activity" name="activity" value="" placeholder="Enter an Activity...">
            <datalist id="agronomy_activity">
              <?php $s=$db->prepare("SELECT DISTINCT `activity` FROM `".$prefix."agronomy_areas` WHERE `activity`!='' ORDER BY `activity` ASC");
              $s->execute();
              echo
                '<option value="Cultivating"/>'.
                '<option value="Grazing"/>'.
                '<option value="Growing"/>'.
                '<option value="Irrigation"/>'.
                '<option value="Resting"/>';
              if($s->rowCount()>0){
                while($r=$s->fetch(PDO::FETCH_ASSOC)){
                  if($r['type']=='Cultivating')continue;
                  if($r['type']=='Grazing')continue;
                  if($r['type']=='Growing')continue;
                  if($r['type']=='Irrigation')continue;
                  if($r['type']=='Resting')continue;
                  echo'<option value="'.$r['type'].'"/>';
                }
              }?>
            </datalist>
          </div>
        </div>
      </div>
      <label for="agronomynotes">Notes</label>
      <div class="form-row">
        <textarea name="notes"></textarea>
      </div>
    </div>
    <div class="form-row justify-content-end">
      <button class="add" type="submit">Add Area</button>
    </div>
  </form>
</div>
