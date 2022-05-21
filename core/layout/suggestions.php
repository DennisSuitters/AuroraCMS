<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Suggestions
 * @package    core/layout/suggestions.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'../db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'c',FILTER_UNSAFE_RAW);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$s=$db->prepare("SELECT * FROM `".$prefix."suggestions` WHERE `rid`=:id AND `t`=:t AND `c`=:c ORDER BY `ti` DESC");
$s->execute([
  ':id'=>$id,
  ':t'=>$t,
  ':c'=>$c
]);
echo'<div class="fancybox-ajax">';
if($s->rowCount()>0){?>
  <h6 class="bg-dark p-2">Suggestions</h6>
  <table class="table-zebra">
    <thead>
      <tr>
        <th class="text-center">Data</th>
        <th class="text-center">Date</th>
        <th class="text-right"></th>
      </tr>
    </thead>
    <tbody id="l_activity">
      <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
        <tr id="l_<?=$r['id'];?>">
          <td>
            <?='Suggestion: '.$c=='notes'?'Data too large to display.':$r['notes'].'<br>';?>
            <small><?='Reason: '.$r['reason'];?></small>
          </td>
          <td class="small text-center"><small><?= date($config['dateFormat'], $r['ti']);?></small></td>
          <td class="text-right">
            <div class="btn-group">
              <button class="add" data-tooltip="tooltip" aria-label="Approve" onclick="suggest('<?=$r['id'];?>');"><i class="i">add</i></button>
              <button class="trash" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','suggestions');"><i class="i">trash</i></button>
            </div>
          </td>
        </tr>
      <?php }?>
    </tbody>
  </table>
<?php }else echo'No Results Found...';
echo'</div>';
