<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dataspy
 * @package    core/layout/dataspy.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
$tim=time();
require'../db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'c',FILTER_UNSAFE_RAW);
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
              <?php if($r['action']=='update'){?><button class="btn btn-secondary" data-tooltip="tooltip" aria-label="Restore" onclick="restore('<?=$r['id'];?>');"><i class="i">undo</i></button> <?php }?>
              <button class="btn btn-danger" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','logs');"><i class="i">purge</i></button>
            </div>
          </td>
        </tr>
      <?php }?>
    </tbody>
  </table>
<?php }else
echo'<div class="alert alert-info" role="alert">No Results Found!</div>';
