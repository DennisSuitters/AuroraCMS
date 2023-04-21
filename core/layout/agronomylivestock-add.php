<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Add Agronomy Livestock
 * @package    core/layout/agronomylivestock-add.php
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
  <h5>Add Livestock</h5>
  <iframe id="sp" name="sp" class="d-none"></iframe>
  <form id="agronmyform" target="sp" method="post" action="core/add_agronomylivestock.php">
    <div class="quickedit">
      <label for="agronomycode">Code</label>
      <div class="form-row">
        <input type="text" id="agronomycode" name="code" value="" placeholder="Enter a Code...">
      </div>
      <label for="agronomyname">Name</label>
      <div class="form-row">
        <input type="text" id="agronmyname" name="name" value="" placeholder="Enter a Name...">
      </div>
      <div class="row">
        <div class="col-12 col-sm-6">
          <label for="agronomytype">Type</label>
          <div class="form-row">
            <input type="text" id="agronomytype" list="agronomy_species" name="type" value="" placeholder="Select or Enter a Species..." onchange="repopulateBreed($(this).val());">
            <?php $s=$db->prepare("SELECT DISTINCT `species` FROM `".$prefix."agronomy_livestock` WHERE `species`!='' ORDER BY `species` ASC ");
            $s->execute();
            echo'<datalist id="agronomy_species">'.
              '<option value="Alpaca"/>'.
              '<option value="Bee"/>'.
              '<option value="Bovine"/>'.
              '<option value="Camel"/>'.
              '<option value="Cat"/>'.
              '<option value="Cattle"/>'.
              '<option value="Cow"/>'.
              '<option value="Chicken"/>'.
              '<option value="Deer"/>'.
              '<option value="Dog"/>'.
              '<option value="Donkey"/>'.
              '<option value="Duck"/>'.
              '<option value="Elk"/>'.
              '<option value="Fowl"/>'.
              '<option value="Goat"/>'.
              '<option value="Horse"/>'.
              '<option value="Llama"/>'.
              '<option value="Mule"/>'.
              '<option value="Pig"/>'.
              '<option value="Quails"/>'.
              '<option value="Rabbit"/>'.
              '<option value="Sheep"/>'.
              '<option value="Swine"/>'.
              '<option value="Zebra"/>';
            if($s->rowCount()>0){
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                if($r['species']=='Alpaca')continue;
                if($r['species']=='Bee')continue;
                if($r['species']=='Bovine')continue;
                if($r['species']=='Camel')continue;
                if($r['species']=='Cat')continue;
                if($r['species']=='Cattle')continue;
                if($r['species']=='Cow')continue;
                if($r['species']=='Chicken')continue;
                if($r['species']=='Deer')continue;
                if($r['species']=='Dog')continue;
                if($r['species']=='Donkey')continue;
                if($r['species']=='Duck')continue;
                if($r['species']=='Elk')continue;
                if($r['species']=='Fowl')continue;
                if($r['species']=='Goat')continue;
                if($r['species']=='Horse')continue;
                if($r['species']=='Llama')continue;
                if($r['species']=='Mule')continue;
                if($r['species']=='Pig')continue;
                if($r['species']=='Quails')continue;
                if($r['species']=='Rabbit')continue;
                if($r['species']=='Sheep')continue;
                if($r['species']=='Swine')continue;
                if($r['species']=='Zebra')continue;
                echo'<option value="'.$r['species'].'"/>';
              }
            }
            echo'</datalist>';?>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <label for="agronomybreed">Breed</label>
          <div class="form-row">
            <input type="text" id="agronomybreed" list="agronomy_breed" name="breed" value="" placeholder="Select or Enter a Breed...">
            <datalist id="agronomy_breed">
            </datalist>
          </div>
        </div>
      </div>
      <label for="agronomysex">Sex</label>
      <div class="form-row">
        <select id="agronomysex" name="sex">
          <option value="">Select a Sex</option>
          <option value="f">Female</option>
          <option value="m">Male</option>
        </select>
      </div>
      <div class="row">
        <div class="col-12 col-sm-6">
          <label for="agronomydob">Birthed</label>
          <div class="form-row">
            <input type="date" id="agronomydob" name="dob" value="">
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <label for="agronomydod">Died</label>
          <div class="form-row">
            <input type="date" id="agronomydod" name="dod" value="">
          </div>
        </div>
      </div>
      <label for="agronomynotes">Notes</label>
      <div class="form-row">
        <textarea name="notes"></textarea>
      </div>
    </div>
    <div class="form-row justify-content-end">
      <button class="add" type="submit">Add Livestock</button>
    </div>
  </form>
</div>
<script>
  function repopulateBreed(b){
    console.log(b);
    var opt;
    if(b=='Alpaca'){
      opt='<option value="Alpaca 1"/>'+
          '<option value="Alpaca 2">';
    }
    if(b=='Bee'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Bovine'){
      opt='<option value="Bovine 1"/>'+
          '<option value="Bovine 2">';
    }
    if(b=='Camel'){
      opt='<option value="Camel 1"/>'+
          '<option value="Camel 2">';
    }
    if(b=='Cat'){
      opt='<option value="Cat 1"/>'+
          '<option value="Cat 2">';
    }
    if(b=='Cattle'){
      opt='<option value="Cattle 1"/>'+
          '<option value="Cattle 2">';
    }
    if(b=='Cow'){
      opt='<option value="Cow 1"/>'+
          '<option value="Cow 2">';
    }
    if(b=='Chicken'){
      opt='<option value="Cow 1"/>'+
          '<option value="Cow 2">';
    }
    if(b=='Deer'){
      opt='<option value="Deer 1"/>'+
          '<option value="Deer 2">';
    }
    if(b=='Dog'){
      opt='<option value="Dog 1"/>'+
          '<option value="Dog 2">';
    }
    if(b=='Donkey'){
      opt='<option value="Donkey 1"/>'+
          '<option value="Donkey 2">';
    }
    if(b=='Duck'){
      opt='<option value="Duck 1"/>'+
          '<option value="Duck 2">';
    }
    if(b=='Elk'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Fowl'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Goat'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Horse'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Llama'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Mule'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Pig'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Quails'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Rabbit'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Sheep'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Swine'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    if(b=='Zebra'){
      opt='<option value="Bee 1"/>'+
          '<option value="Bee 2">';
    }
    $('#agronomy_breed').html(opt);
  }
</script>
<?php /*
<?php $s=$db->prepare("SELECT DISTINCT `breed` FROM `".$prefix."agronomy_livestock` WHERE `breed`!='' ORDER BY `breed` ASC ");
$s->execute();
echo'<datalist id="agronomy_breed">'.
  '<option value="Bovine"/>'.
  '<option value="Cattle"/>'.
  '<option value="Sheep"/>'.
  '<option value="Fowl"/>';
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if($r['breed']=='Bovine')continue;
    if($r['breed']=='Cattle')continue;
    if($r['breed']=='Sheep')continue;
    if($r['breed']=='Fowl')continue;
    echo'<option value="'.$r['breed'].'"/>';
  }
}
echo'</datalist>';?>
*/ ?>
