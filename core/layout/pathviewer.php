<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Path Viewer
 * @package    core/layout/pathviewer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'..'.DS.'db.php';
$idh=time();
echo'<div id="pathviewer'.$idh.'" class="table-responsive">';
define('URL', PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$sg=$db->prepare("SELECT `ip` FROM `".$prefix."tracker` WHERE `id`=:id");
$sg->execute([
  ':id'=>$id
]);
$gr=$sg->fetch(PDO::FETCH_ASSOC);
$s=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE `ip`=:ip ORDER BY `ti` ASC");
$s->execute([
  ':ip'=>$gr['ip']
]);
if($s->rowCount()>0){
echo'<div class="fancybox-ajax">'.
      '<h6 class="bg-dark p-2">'.$r['title'].'</h6>'.
      '<table class="table-zebra">'.
        '<thead>'.
          '<tr>'.
            '<th>URL From</th>'.
            '<th>URL Dest</th>'.
            '<th>Date</th>'.
            '<th>Browser/OS</th>'.
          '</tr>'.
        '</thead>'.
        '<tbody>';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<tr class="small">'.
      '<td>'.$r['urlFrom'].'</td>'.
      '<td>'.$r['urlDest'].'</td>'.
      '<td>'.date($config['dateFormat'],$r['ti']).'</td>'.
      '<td>'.$r['browser'].' using '.$r['os'].'</td>'.
    '</tr>';
  }
  echo'</tbody>'.
    '</table>';
}
echo'</div>';
