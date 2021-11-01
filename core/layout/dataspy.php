<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dataspy
 * @package    core/layout/dataspy.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
$tim=time();
require'../db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$s=$db->prepare("SELECT * FROM `".$prefix."logs` WHERE `rid`=:id AND `refTable`=:t AND `refColumn`=:c ORDER BY `ti` DESC");
$s->execute([
  ':id'=>$id,
  ':t'=>$t,
  ':c'=>$c
]);
if($s->rowCount()>0){?>
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th class="text-center">User</th>
        <th class="text-center">Table</th>
        <th class="text-center">Column</th>
        <th class="text-center">contentType</th>
        <th class="text-center">Action</th>
        <th class="text-center">Date</th>
        <th class="text-center">Data</th>
        <th class="text-right"></th>
      </tr>
    </thead>
    <tbody id="l_activity">
      <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
        $r['oldda']=rawurldecode($r['oldda']);
        $r['newda']=rawurldecode($r['newda']);?>
        <tr id="l_<?=$r['id'];?>">
          <td class="small"><a href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$r['uid'];?>"><?=$r['username'].':'.$r['name'];?></a></td>
          <td class="text-center small"><?=$r['refTable'];?></td>
          <td class="text-center small"><?=$r['refColumn'];?></td>
          <td class="text-center small"><?=$r['contentType'];?></td>
          <td class="text-center small"><?=$r['action'];?></td>
          <td class="text-center small"><small><?= date($config['dateFormat'],$r['ti']);?></small></td>
          <td>
            <?php if($r['refColumn']=='notes'&&strlen($r['oldda'])>400&&strlen($r['newda'])>400)echo'<div><small>Dataset too large to display</small></div>';
            else{?>
              <div><small>From: <small><?= strlen($r['oldda'])>400?'Dataset too large to display':htmlspecialchars($r['oldda']);?></small></small></div>
              <div><small>To: <small><?= strlen($r['newda'])>400?'Dataset too large to display':htmlspecialchars($r['newda']);?></small></small></div>
            <?php }?>
          </td>
          <td class="text-right">
            <div class="btn-group">
              <?php if($r['action']=='update'){?><button class="btn btn-secondary" data-tooltip="tooltip" aria-label="Restore" onclick="restore('<?=$r['id'];?>');"><i class="i"><svg xmlns="http://www.w3.org/2000/svg" id="libre-undo" viewBox="0 0 14 14"><path d="m 7,11.5 c 1.86108,0 3.375,-1.513922 3.375,-3.375 C 10.375,6.263922 8.86108,4.75 7,4.75 V 7 L 3.25,4 7,1 v 2.25 c 2.68798,0 4.875,2.187023 4.875,4.875 C 11.875,10.812977 9.68798,13 7,13 4.31202,13 2.125,10.812977 2.125,8.125 h 1.5 C 3.625,9.986078 5.13892,11.5 7,11.5 z"/></svg></i></button> <?php }?>
              <button class="btn btn-secondary trash" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','logs');"><i class="i"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 5.4999377,5.7501979 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795074,0.0705 H 4.7499064 q -0.1095045,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 h 0.5000209 q 0.1095045,0 0.1795074,0.070503 0.070003,0.070503 0.070503,0.1795075 z m 2.0000833,0 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795075,0.0705 H 6.7499898 q -0.1095046,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 h 0.5000208 q 0.1095046,0 0.1795075,0.070503 0.070003,0.070503 0.070503,0.1795075 z m 2.0000833,0 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795075,0.0705 H 8.7500731 q -0.1095046,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 H 9.250094 q 0.1095046,0 0.1795075,0.070503 0.070003,0.070503 0.070503,0.1795075 z M 10.500146,11.406934 V 4.000625 H 3.4998543 v 7.406309 q 0,0.172007 0.054502,0.316513 0.054502,0.144506 0.1135047,0.211009 0.059003,0.0665 0.082004,0.0665 h 6.500271 q 0.0235,0 0.082,-0.0665 0.0585,-0.0665 0.113504,-0.211009 0.055,-0.144506 0.0545,-0.316513 z M 5.2499273,3.0000833 H 8.7500731 L 8.3750575,2.0860453 Q 8.3205552,2.0155423 8.2420519,2.0000417 H 5.7654487 q -0.078003,0.015501 -0.1330055,0.086004 z m 7.2503017,0.2500105 v 0.5000208 q 0,0.1095046 -0.0705,0.1795075 -0.0705,0.070003 -0.179507,0.070503 h -0.750031 v 7.4063089 q 0,0.648527 -0.367016,1.121046 Q 10.766157,13 10.250136,13 H 3.7498648 Q 3.2343433,13 2.866828,12.542981 2.4993126,12.085962 2.4998127,11.437435 V 3.999625 H 1.7497814 q -0.1095046,0 -0.1795075,-0.070503 Q 1.500271,3.8586191 1.499771,3.7496146 V 3.2495937 q 0,-0.1095045 0.070503,-0.1795074 0.070503,-0.070003 0.1795075,-0.070503 H 4.163882 L 4.7109048,1.695029 Q 4.8279097,1.4060169 5.1329224,1.2030085 5.4379351,1 5.7499481,1 H 8.2500523 Q 8.5625653,1 8.867078,1.2030085 9.1715907,1.4060169 9.2890956,1.695029 l 0.5470227,1.3045543 h 2.4141007 q 0.109504,0 0.179507,0.070503 0.07,0.070503 0.0705,0.1795074 z"/></i></svg></button>
            </div>
          </td>
        </tr>
      <?php }?>
    </tbody>
  </table>
<?php }else echo'<div class="alert alert-info" role="alert">No Results Found!</div>';
