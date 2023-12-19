<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Add Agronomy Livestock
 * @package    core/layout/agronomylivestock-add.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
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
<div class="fancybox-ajax p-2 shadow-lg">
  <h5>Add Livestock</h5>
  <iframe class="d-none" id="sp" name="sp"></iframe>
  <form id="agronmyform" target="sp" method="post" action="core/add_agronomylivestock.php">
    <div class="quickedit">
      <label for="agronomycode">Code</label>
      <div class="form-row">
        <input id="agronomycode" name="code" type="text" value="" placeholder="Enter a Code...">
      </div>
      <label for="agronomyname">Name</label>
      <div class="form-row">
        <input id="agronmyname" name="name" type="text" value="" placeholder="Enter a Name...">
      </div>
      <div class="row">
        <div class="col-12 col-sm-6">
          <label for="agronomyspecies">Species</label>
          <div class="form-row">
            <input id="agronomyspecies" name="species" list="agronomy_species" type="text" value="" placeholder="Select or Enter a Species..." onchange="repopulateBreed($(this).val());">
            <?php $s=$db->prepare("SELECT DISTINCT `species` FROM `".$prefix."agronomy_livestock` WHERE `species`!='' ORDER BY `species` ASC ");
            $s->execute();
            echo'<datalist id="agronomy_species">'.
                '<option value="Alpaca"/>'.
                '<option value="Bee"/>'.
                '<option value="Bovine"/>'.
                '<option value="Camel"/>'.
                '<option value="Cattle"/>'.
                '<option value="Cow"/>'.
                '<option value="Chicken"/>'.
                '<option value="Deer"/>'.
                '<option value="Dog"/>'.
                '<option value="Donkey"/>'.
                '<option value="Duck"/>'.
                '<option value="Elk"/>'.
                '<option value="Fowl"/>'.
                '<option value="Goose"/>'.
                '<option value="Goat"/>'.
                '<option value="Guineafowl"/>'.
                '<option value="Horse"/>'.
                '<option value="Llama"/>'.
                '<option value="Mule"/>'.
                '<option value="Peacock"/>'.
                '<option value="Pig"/>'.
                '<option value="Quails"/>'.
                '<option value="Rabbit"/>'.
                '<option value="Sheep"/>'.
                '<option value="Swine"/>';
            if($s->rowCount()>0){
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                if($r['species']=='Alpaca')continue;
                if($r['species']=='Bee')continue;
                if($r['species']=='Bovine')continue;
                if($r['species']=='Camel')continue;
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
                if($r['species']=='Goose')continue;
                if($r['species']=='Guineafowl')continue;
                if($r['species']=='Horse')continue;
                if($r['species']=='Llama')continue;
                if($r['species']=='Mule')continue;
                if($r['species']=='Peacock')continue;
                if($r['species']=='Pig')continue;
                if($r['species']=='Quails')continue;
                if($r['species']=='Rabbit')continue;
                if($r['species']=='Sheep')continue;
                if($r['species']=='Swine')continue;
                echo'<option value="'.$r['species'].'"/>';
              }
            }
            echo'</datalist>';?>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <label for="agronomybreed">Breed</label>
          <div class="form-row">
            <input id="agronomybreed" name="breed" list="agronomy_breed" type="text" value="" placeholder="Select or Enter a Breed...">
            <datalist id="agronomy_breed"></datalist>
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
          <label for="agronomyarea">Area</label>
          <div class="form-row">
            <select id="agronomyarea" name="aid">
              <option value="0">Select an Area...</option>
              <?php $sa=$db->query("SELECT `id`,`name` FROM `".$prefix."agronomy_areas` ORDER BY `name` ASC, `ti` ASC");
              $sa->execute();
              while($ra=$sa->fetch(PDO::FETCH_ASSOC)){
                echo'<option value="'.$ra['id'].'">'.$ra['name'].'</option>';
              }?>
            </select>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <label for="agronomyact">Activity</label>
          <div class="form-row">
            <input id="agronomyact" name="act" list="agronomy_act" type="text" value="" placeholder="Select or Enter an Activity...">
            <?php $s=$db->prepare("SELECT DISTINCT `activity` FROM `".$prefix."agronomy_livestock` WHERE `activity`!='' ORDER BY `activity` ASC ");
            $s->execute();
            echo'<datalist id="agronomy_act">'.
              '<opiton value="Birthing"/>'.
              '<option value="Grazing"/>'.
              '<option value="Resting"/>';
              if($s->rowCount()>0){
                while($r=$s->fetch(PDO::FETCH_ASSOC)){
                  if($r['activity']=='Birthing')continue;
                  if($r['activity']=='Grazing')continue;
                  if($r['activity']=='Resting')continue;
                  echo'<option value="'.$r['activity'].'"/>';
                }
              }
            echo'</datalist>';?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-6">
          <label for="agronomydob">Birthed</label>
          <div class="form-row">
            <input id="agronomydob" name="dob" type="date" value="">
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <label for="agronomydod">Died</label>
          <div class="form-row">
            <input id="agronomydod" name="dod" type="date" value="">
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
    var opt;
    switch(b){
    case'Alpaca':
      opt='<option value="Huacaya"/>'+
          '<option value="Suri">';
      break;
    case'Bee':
      opt='<option value="Carniolan"/>'+
          '<option value="Carpenter"/>'+
          '<option value="Caucasian"/>'+
          '<option value="Cuckoo"/>'+
          '<option value="Italian"/>'+
          '<option value="Quasihesma"/>'+
          '<option value="Teddy Bear"/>';
      break;
    case'Camel':
      opt='<option value="Alxa"/>'+
          '<option value="Bikaneri"/>'+
          '<option value="Jaisalmeri"/>'+
          '<option value="Kharai"/>'+
          '<option value="Kohi"/>'+
          '<option value="Majaheem"/>'+
          '<option value="Ouled Sidi Cheikh"/>'+
          '<option value="Targui"/>';
      break;
    case'Bovine':
    case'Cattle':
    case'Cow':
      opt='<option value="Aberdeen Angus">'+
          '<option value="Adaptaur">'+
          '<option value="Angus">'+
          '<option value="Ankole-Watusi">'+
          '<option value="Aussie Red">'+
          '<option value="Australian Braford">'+
          '<option value="Australian Brangus">'+
          '<option value="Australian Charbray">'+
          '<option value="Australian Lowline">'+
          '<option value="Ayrshire">'+
          '<option value="Beefmaster">'+
          '<option value="Belted Galloway"/>'+
          '<option value="Brahman">'+
          '<option value="Brown Swiss">'+
          '<option value="Charolais">'+
          '<option value="Chianina">'+
          '<option value="Dexter">'+
          '<option value="Galloway">'+
          '<option value="Gelbvieh">'+
          '<option value="Guernsey">'+
          '<option value="Hereford">'+
          '<option value="Holstein Friesian">'+
          '<option value="Illawara">'+
          '<option value="Jersey">'+
          '<option value="Limousin">'+
          '<option value="Milking Shorthorn">'+
          '<option value="Murray Grey">'+
          '<option value="Piedmontese">'+
          '<option value="Red Angus">'+
          '<option value="Red Poll">'+
          '<option value="Scottish Higland">'+
          '<option value="Shorthorn">'+
          '<option value="Simmental">'+
          '<option value="Texas Longhorn">'+
          '<option value="Watusi">';
      break;
    case'Chicken':
      opt='<option value="Silkie"/>'+
          '<option value="Brahma"/>'+
          '<option value="Plymouth Rock"/>'+
          '<option value="Sussex"/>'+
          '<option value="Ayam"/>'+
          '<option value="Leghorn"/>'+
          '<option value="Ameraucana"/>'+
          '<option value="Indian Game"/>'+
          '<option value="Ayam Kampong"/>'+
          '<option value="Polish"/>'+
          '<option value="Rhode Island Red"/>'+
          '<option value="Orpington"/>'+
          '<option value="Asil"/>'+
          '<option value="Marans"/>'+
          '<option value="ISA Brown"/>'+
          '<option value="Australorp"/>'+
          '<option value="Japanese Bantam"/>'+
          '<option value="Wyandotte"/>'+
          '<option value="Araucana"/>'+
          '<option value="Shamo"/>'+
          '<option value="Cochin"/>'+
          '<option value="Frizzle"/>'+
          '<option value="Padovana"/>'+
          '<option value="Lohmann Brown"/>'+
          '<option value="Indian Giant"/>'+
          '<option value="Kuroiler"/>'+
          '<option value="Kadaknath"/>'+
          '<option value="Dong Tao"/>'+
          '<option value="Scots Dumpy"/>'+
          '<option value="Serama"/>'+
          '<option value="Jersey Giant"/>'+
          '<option value="Welsummer"/>'+
          '<option value="Legbar"/>'+
          '<option value="Sasso"/>'+
          '<option value="Barneveldar"/>'+
          '<option value="Bielefelder Kennhuhn"/>'+
          '<option value="Fayoumi"/>'+
          '<option value="New Hampshire Red"/>'+
          '<option value="Vorwerk Chicken"/>'+
          '<option value="Faverolles"/>'+
          '<option value="Amrock"/>'+
          '<option value="Sebright"/>'+
          '<option value="Hyline"/>'+
          '<option value="Minorca"/>'+
          '<option value="Ga Noi"/>'+
          '<option value="Booted Bantam"/>'+
          '<option value="Sundheimer"/>'+
          '<option value="Lakenvelder">';
      break;
    case'Deer':
      opt='<option value="Barasingha"/>'+
          '<option value="Brocket"/>'+
          '<option value="Chinese muntjac"/>'+
          '<option value="Chital"/>'+
          '<option value="Elaphurus davidianus"/>'+
          '<option value="Eld\'s deer"/>'+
          '<option value="Elk"/>'+
          '<option value="Fallow deer"/>'+
          '<option value="Hog deer"/>'+
          '<option value="Indian muntjac"/>'+
          '<option value="Marsh deer"/>'+
          '<option value="Moose"/>'+
          '<option value="Muntjac"/>'+
          '<option value="Mule deer"/>'+
          '<option value="Pudu"/>'+
          '<option value="Red deer"/>'+
          '<option value="Roe deer"/>'+
          '<option value="Reindeer"/>'+
          '<option value="Rusa deer"/>'+
          '<option value="Sambar"/>'+
          '<option value="Sika deer"/>'+
          '<option value="Tufted deer"/>'+
          '<option value="Water deer"/>'+
          '<option value="White-tailed deer"/>';
      break;
    case'Donkey':
    case"Mule":
      opt='<option value="Abyssinian"/>'+
          '<option value="American Mammoth Jackstock"/>'+
          '<option value="Amiatina"/>'+
          '<option value="Andalusian"/>'+
          '<option value="Âne pie d\'Irlande"/>'+
          '<option value="Asinara"/>'+
          '<option value="Asno de las Encartaciones"/>'+
          '<option value="Balearic"/>'+
          '<option value="Balkan"/>'+
          '<option value="Baudet du Poitou"/>'+
          '<option value="Burro da Ilha Graciosa"/>'+
          '<option value="Burro de Miranda"/>'+
          '<option value="Bourbonnais"/>'+
          '<option value="Castel Morrone donkey"/>'+
          '<option value="Catalan"/>'+
          '<option value="Corsican"/>'+
          '<option value="Cotentin"/>'+
          '<option value="Fariñeiro"/>'+
          '<option value="Grand Noir du Berry"/>'+
          '<option value="Grigio Siciliano"/>'+
          '<option value="Irish"/>'+
          '<option value="Jumento nordestino"/>'+
          '<option value="Majorera"/>'+
          '<option value="Maltese"/>'+
          '<option value="Martina Franca"/>'+
          '<option value="Miniature"/>'+
          '<option value="Norman"/>'+
          '<option value="Normand"/>'+
          '<option value="Pantesco"/>'+
          '<option value="Parlagi szamár"/>'+
          '<option value="Pega"/>'+
          '<option value="Provence"/>'+
          '<option value="Pyrenean"/>'+
          '<option value="Ragusano"/>'+
          '<option value="Romagnolo"/>'+
          '<option value="Sardinian"/>'+
          '<option value="Thüringer Waldesel"/>'+
          '<option value="Turkmenian kulan"/>'+
          '<option value="Zamorano-Leonés"/>';
      break;
    case'Duck':
      opt=
          '<option value="Abacot Ranger"/>'+
          '<option value="Alabio"/>'+
          '<option value="American Pekin"/>'+
          '<option value="Ancona"/>'+
          '<option value="Australian Call"/>'+
          '<option value="Australian Spotted"/>'+
          '<option value="Aylesbury"/>'+
          '<option value="Bali"/>'+
          '<option value="Blekinge"/>'+
          '<option value="Call"/>'+
          '<option value="Cayuga"/>'+
          '<option value="Cherry Valley"/>'+
          '<option value="Crested"/>'+
          '<option value="Duclair"/>'+
          '<option value="East Indie"/>'+
          '<option value="Elizabeth"/>'+
          '<option value="Forest"/>'+
          '<option value="German Pekin"/>'+
          '<option value="Golden Cascade"/>'+
          '<option value="Hook Bill"/>'+
          '<option value="Indian Runner"/>'+
          '<option value="Khaki Campbell"/>'+
          '<option value="Magpie"/>'+
          '<option value="Mulard"/>'+
          '<option value="Muscovy"/>'+
          '<option value="Orpington"/>'+
          '<option value="Pomeranian"/>'+
          '<option value="Rouen"/>'+
          '<option value="Saxony"/>'+
          '<option value="Shetland"/>'+
          '<option value="Silver Appleyard"/>'+
          '<option value="Swedish Blue"/>'+
          '<option value="Swedish Yellow"/>'+
          '<option value="Welsh Harlequin"/>';
      break;
    case'Goose':
      opt='<option value="African"/>'+
          '<option value="Alsatian"/>'+
          '<option value="American Buff Goose"/>'+
          '<option value="Brecon Buff Goose"/>'+
          '<option value="Chinese"/>'+
          '<option value="Cotton Patch"/>'+
          '<option value="Danish Landrace"/>'+
          '<option value="Emden"/>'+
          '<option value="Hungarian"/>'+
          '<option value="Italian"/>'+
          '<option value="Landes"/>'+
          '<option value="Normandy"/>'+
          '<option value="Öland"/>'+
          '<option value="Oie de Touraine"/>'+
          '<option value="Pilgrim"/>'+
          '<option value="Pomeranian"/>'+
          '<option value="Roman"/>'+
          '<option value="Scania"/>'+
          '<option value="Sebastopol"/>'+
          '<option value="Shetland"/>'+
          '<option value="Slovak White"/>'+
          '<option value="Steinbacher Goose"/>'+
          '<option value="Suchovy"/>'+
          '<option value="Toulouse"/>'+
          '<option value="Tula Fighting Goose"/>'+
          '<option value="Twente"/>'+
          '<option value="Vištinės"/>';
      break;
    case'Goat':
      opt='<option value="Alpine"/>'+
          '<option value="American Lamancha"/>'+
          '<option value="American Pygmy"/>'+
          '<option value="Anatolian Black Goat"/>'+
          '<option value="Anglo-Nubian"/>'+
          '<option value="Angora"/>'+
          '<option value="Australian Cashmere"/>'+
          '<option value="Australian Miniature"/>'+
          '<option value="Bagot"/>'+
          '<option value="Barbari"/>'+
          '<option value="Beetal"/>'+
          '<option value="Black Bengal"/>'+
          '<option value="Boer"/>'+
          '<option value="British Alpine"/>'+
          '<option value="Cameroon Dwarf"/>'+
          '<option value="Chamois Coloured"/>'+
          '<option value="Changthangi"/>'+
          '<option value="Damascus"/>'+
          '<option value="Dutch Landrace"/>'+
          '<option value="Fainting"/>'+
          '<option value="Girgentana"/>'+
          '<option value="Golden Guernsey"/>'+
          '<option value="Hejazi"/>'+
          '<option value="Jamnapari"/>'+
          '<option value="Jonica"/>'+
          '<option value="Kalahari Red"/>'+
          '<option value="Kamori"/>'+
          '<option value="Kiko"/>'+
          '<option value="Kinder"/>'+
          '<option value="Maltese"/>'+
          '<option value="Marota"/>'+
          '<option value="Murciana"/>'+
          '<option value="Nigerian Dwarf"/>'+
          '<option value="Nigora Goat"/>'+
          '<option value="Oberhasli"/>'+
          '<option value="Peacock"/>'+
          '<option value="Pygmy"/>'+
          '<option value="Pygora"/>'+
          '<option value="Rove"/>'+
          '<option value="Saanen"/>'+
          '<option value="Sirohi"/>'+
          '<option value="Somali"/>'+
          '<option value="Spanish"/>'+
          '<option value="Tauernscheck"/>'+
          '<option value="Thuringian"/>'+
          '<option value="Toggenburger"/>'+
          '<option value="Valais Blackneck"/>'+
          '<option value="West African Dwarf"/>';
      break;
    case'Guineafowl':
      opt='<option value="Cinnamon"/>'+
          '<option value="Cream"/>'+
          '<option value="Lavender"/>'+
          '<option value="Pearl"/>'+
          '<option value="Pied"/>'+
          '<option value="Silver"/>'+
          '<option value="White"/>';
      break;
    case'Horse':
      opt='<option value="Akhal-Teke"/>'+
          '<option value="American Paint Horse"/>'+
          '<option value="American Quarter Horse"/>'+
          '<option value="American Saddlebred"/>'+
          '<option value="Andalusian"/>'+
          '<option value="Appaloosa"/>'+
          '<option value="Arabian"/>'+
          '<option value="Ardennais"/>'+
          '<option value="Belgian Draught"/>'+
          '<option value="Belgian Warmblood"/>'+
          '<option value="Black Forest Horse"/>'+
          '<option value="Breton"/>'+
          '<option value="Brumby"/>'+
          '<option value="Clydesdale"/>'+
          '<option value="Cob"/>'+
          '<option value="Criollo"/>'+
          '<option value="Dartmoor Pony"/>'+
          '<option value="Dutch Warmblood"/>'+
          '<option value="Falabella"/>'+
          '<option value="Ferghana"/>'+
          '<option value="Fjord"/>'+
          '<option value="Friesian"/>'+
          '<option value="Galineers Cob"/>'+
          '<option value="Kandachime"/>'+
          '<option value="Haflinger"/>'+
          '<option value="Hanoverian"/>'+
          '<option value="Holsteiner"/>'+
          '<option value="Icelandic"/>'+
          '<option value="Irish Sport Horse"/>'+
          '<option value="Knabstrupper"/>'+
          '<option value="Konik"/>'+
          '<option value="Lipizzan"/>'+
          '<option value="Lusitano"/>'+
          '<option value="Mangalarga Marchador"/>'+
          '<option value="Marwari"/>'+
          '<option value="Missouri Fox Trotter"/>'+
          '<option value="Mongolian"/>'+
          '<option value="Morgan"/>'+
          '<option value="Mustang"/>'+
          '<option value="Noriker"/>'+
          '<option value="Percheron"/>'+
          '<option value="Peruvian Paso"/>'+
          '<option value="Rahvan"/>'+
          '<option value="Shetland Pony"/>'+
          '<option value="Shire"/>'+
          '<option value="Standardbred"/>'+
          '<option value="Thoroughbred"/>'+
          '<option value="Trakehner"/>'+
          '<option value="Turkoman"/>'+
          '<option value="Welsh Cob"/>';
      break;
    case'Llama':
      opt='<option value="Alpaca"/>'+
          '<option value="Guanaco"/>'+
          '<option value="Suri alpaca"/>'+
          '<option value="Vicuña"/>';
      break;
    case'Peacock':
      opt='<option value="Congo"/>'+
          '<option value="Green"/>'+
          '<option value="Indian"/>'+
          '<option value="Phasianidae"/>';
      break;
    case'Pig':
    case'Swine':
      opt='<option value="Agū"/>'+
          '<option value="American Landrace"/>'+
          '<option value="American Yorkshire"/>'+
          '<option value="Angeln Saddleback"/>'+
          '<option value="Bentheim Black Pied"/>'+
          '<option value="Berkshire"/>'+
          '<option value="Black Ass Limousin"/>'+
          '<option value="Black Iberian"/>'+
          '<option value="British Saddleback"/>'+
          '<option value="Canarian Black"/>'+
          '<option value="Chato Murciano"/>'+
          '<option value="Chester White"/>'+
          '<option value="Choctaw Hog"/>'+
          '<option value="Cinta Senese"/>'+
          '<option value="Danish Landrace"/>'+
          '<option value="Danish Protest Pig"/>'+
          '<option value="Duroc"/>'+
          '<option value="Enviropig"/>'+
          '<option value="Euskal Txerria"/>'+
          '<option value="Gascon"/>'+
          '<option value="Gloucestershire Old Spots"/>'+
          '<option value="Göttingen Minipig"/>'+
          '<option value="Hampshire"/>'+
          '<option value="Hereford Hog"/>'+
          '<option value="Guinea Hog"/>'+
          '<option value="Jeju Black"/>'+
          '<option value="Kunekune"/>'+
          '<option value="Large Black"/>'+
          '<option value="Large White"/>'+
          '<option value="Lincolnshire Curly Coat"/>'+
          '<option value="Mangalica"/>'+
          '<option value="Meidam"/>'+
          '<option value="Meishan"/>'+
          '<option value="Middle White"/>'+
          '<option value="Moura"/>'+
          '<option value="Mulefoot"/>'+
          '<option value="Nustrale Pig"/>'+
          '<option value="Ossabaw Island Hog"/>'+
          '<option value="Oxford Sandy and Black"/>'+
          '<option value="Piétrain"/>'+
          '<option value="Poland China"/>'+
          '<option value="Porco-monteiro"/>'+
          '<option value="Red Wattle Hog"/>'+
          '<option value="Swabian-Hall"/>'+
          '<option value="Tamworth"/>'+
          '<option value="Tokyo-X"/>'+
          '<option value="Vietnamese Pot-bellied"/>'+
          '<option value="Złotnicka Spotted"/>';
      break;
    case'Rabbit':
      opt='<option value="American"/>'+
          '<option value="American Fuzzy Lop"/>'+
          '<option value="Angora"/>'+
          '<option value="Argenté"/>'+
          '<option value="Belgian Hare"/>'+
          '<option value="Beveren"/>'+
          '<option value="Californian"/>'+
          '<option value="Checkered Giant"/>'+
          '<option value="Cinnamon"/>'+
          '<option value="Dutch"/>'+
          '<option value="Dwarf Hotot"/>'+
          '<option value="English Lop"/>'+
          '<option value="English Spot"/>'+
          '<option value="Flemish Giant"/>'+
          '<option value="Florida White"/>'+
          '<option value="French Angora"/>'+
          '<option value="French Lop"/>'+
          '<option value="Golden Glavcot"/>'+
          '<option value="Gotland"/>'+
          '<option value="Grand Chinchilla"/>'+
          '<option value="Harlequin"/>'+
          '<option value="Havana"/>'+
          '<option value="Himalayan"/>'+
          '<option value="Himalayan Cat"/>'+
          '<option value="Holland Lop"/>'+
          '<option value="Hulstlander"/>'+
          '<option value="Jersey Wooly"/>'+
          '<option value="Lilac"/>'+
          '<option value="Lionhead"/>'+
          '<option value="Meissner Lop"/>'+
          '<option value="Mini Lop"/>'+
          '<option value="Mini Rex"/>'+
          '<option value="Mini Satin Rabbit"/>'+
          '<option value="Netherland Dwarf"/>'+
          '<option value="New Zealand"/>'+
          '<option value="New Zealand Red"/>'+
          '<option value="Palomino"/>'+
          '<option value="Polish"/>'+
          '<option value="Plush Lop"/>'+
          '<option value="Rex"/>'+
          '<option value="Rhenish Warmblood"/>'+
          '<option value="Rhinelander"/>'+
          '<option value="Satin Rabbit"/>'+
          '<option value="Silver"/>'+
          '<option value="Silver Fox"/>'+
          '<option value="Silver Marten"/>'+
          '<option value="Tan"/>'+
          '<option value="Thrianta"/>'+
          '<option value="Thuringer"/>'+
          '<option value="Velveteen Lop"/>';
      break;
    case'Sheep':
      opt='<option value="American Blackbelly"/>'+
          '<option value="Assaf"/>'+
          '<option value="Australian White"/>'+
          '<option value="Awassi"/>'+
          '<option value="Badger Face Welsh Mountain"/>'+
          '<option value="Barbados Black Belly"/>'+
          '<option value="Beltex"/>'+
          '<option value="Cameroon"/>'+
          '<option value="Cheviot"/>'+
          '<option value="Comeback"/>'+
          '<option value="Corriedale"/>'+
          '<option value="Dorper"/>'+
          '<option value="Dorset Horn"/>'+
          '<option value="Fries Melkschaap"/>'+
          '<option value="Harri"/>'+
          '<option value="Hampshire Down"/>'+
          '<option value="Herdwick"/>'+
          '<option value="Île-de-France"/>'+
          '<option value="Jacob"/>'+
          '<option value="Karakul"/>'+
          '<option value="Katahdin"/>'+
          '<option value="Lacaune"/>'+
          '<option value="Ladoum"/>'+
          '<option value="Lonk"/>'+
          '<option value="Meatmaster"/>'+
          '<option value="Merino"/>'+
          '<option value="Montadale"/>'+
          '<option value="Najdi"/>'+
          '<option value="Navajo-Churro"/>'+
          '<option value="Ouessant"/>'+
          '<option value="Pelibüey"/>'+
          '<option value="Priangan"/>'+
          '<option value="Poll Dorset"/>'+
          '<option value="Polypay"/>'+
          '<option value="Racka"/>'+
          '<option value="Rambouillet"/>'+
          '<option value="Romanov"/>'+
          '<option value="Romney"/>'+
          '<option value="Ryeland"/>'+
          '<option value="Santa Inês"/>'+
          '<option value="Scottish Blackface"/>'+
          '<option value="Shetland"/>'+
          '<option value="Shropshire"/>'+
          '<option value="Soay"/>'+
          '<option value="Southdown"/>'+
          '<option value="Suffolk"/>'+
          '<option value="Texel"/>'+
          '<option value="Valais Blacknose"/>'+
          '<option value="Wiltipoll"/>'+
          '<option value="Wiltshire Horn"/>'+
          '<option value="Zwartbles"/>';
      break;
    }
    $('#agronomy_breed').html(opt);
  }
</script>
