<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - Path Viewer
 * @package    core/layout/pathviewer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'../db.php';
$idh=time();
function testURL($u){
  $status='';
  if(stristr($u,'aws/'))$status='danger';
  if(stristr($u,'/wp'))$status='danger';
  if(stristr($u,'/wordpress/'))$status='danger';
  if(stristr($u,'old-wp'))$status='danger';
  if(stristr($u,'xmlrpc.php'))$status='danger';
  if(stristr($u,'dup-installer'))$status='danger';
  if(stristr($u,'eval-stdin.php'))$status='danger';
  if(stristr($u,'panels.txt'))$status='danger';
  if(stristr($u,'?author='))$status='danger';
  if(stristr($u,'.php'))$status='danger';
  if(stristr($u,'.asp'))$status='danger';
  if(stristr($u,'.aspx'))$status='danger';
  if(stristr($u,'mail.'))$status='danger';
  if(stristr($u,'magento'))$status='danger';
  if(stristr($u,'/modules/'))$status='danger';
  if(stristr($u,'plesk'))$status='danger';
  if(stristr($u,'/system/'))$status='danger';
  if(stristr($u,'/umbraco'))$status='danger';
  if(stristr($u,'/joomla'))$status='danger';
  if(stristr($u,'wp-login'))$status='danger';
	if(stristr($u,'/staging/'))$status='danger';
  return($status=='danger'?' text-'.$status:'');
}
function getOSIcon($i) {
  if(file_exists('../images/i-os-'.$i.'.svg'))
    return'<i class="i d-inline-table i-2x">'.file_get_contents('../images/i-os-'.$i.'.svg').'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>';
  else
    return'<i class="i d-inline-table i-2x i-color-muted">'.file_get_contents('../images/i-os-general.svg').'</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>';
}
function getBrowserIcon($i) {
  if(file_exists('../images/i-browser-'.$i.'.svg'))
    return'<i class="i d-inline-table i-2x">'.file_get_contents('../images/i-browser-'.$i.'.svg').'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>';
  else
    return'<i class="i d-inline-table i-2x i-color-muted">'.file_get_contents('../images/i-browser-general.svg').'</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>';
}
function getDeviceIcon($i,$w) {
  if($i!=''&&$i!='unknown'&&file_exists('../images/i-tech-'.$i.'.svg'))
    return'<i class="i d-inline-table i-2x">'.file_get_contents('../images/i-tech-'.$i.'.svg').'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>'.(is_numeric($w)?'<span class="m-0 p-0" style="font-size:9px">'.$w.'</span><br>':'');
  else
    return'<i class="i d-inline-table i-2x i-color-muted">'.file_get_contents('../images/i-tech-unknown.svg').'</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>'.(is_numeric($w)?'<span class="m-0 p-0" style="font-size:9px">'.$w.'</span><br>':'');
}
echo'<div id="pathviewer'.$idh.'" class="table-responsive">';
define('UNICODE','UTF-8');
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$sg=$db->prepare("SELECT `ip` FROM `".$prefix."tracker` WHERE `id`=:id");
$sg->execute([':id'=>$id]);
$gr=$sg->fetch(PDO::FETCH_ASSOC);
$s=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE `ip`=:ip ORDER BY `id` DESC");
$s->execute([':ip'=>$gr['ip']]);
if($s->rowCount()>0){
echo'<div class="">'.
      '<table class="table-zebra">'.
        '<thead>'.
          '<tr>'.
            '<th colspan="7"><h4>Path Viewer</h4></th>'.
          '</tr>'.
          '<tr class="small">'.
            '<th class="text-center align-middle text-uppercase">Date</th>'.
            '<th class="text-center align-middle text-uppercase">URL From</th>'.
            '<th class="text-center align-middle text-uppercase">URL Dest</th>'.
            '<th class="text-center align-middle text-uppercase">OS</th>'.
            '<th class="text-center align-middle text-uppercase">Browser</th>'.
            '<th class="text-center align-middle text-uppercase">Device</th>'.
            '<th class="text-center align-middle text-uppercase">Action</th>'.
          '</tr>'.
        '</thead>'.
        '<tbody>';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $testurlFrom=testURL($r['urlFrom']);
    $testurlDest=testURL($r['urlDest']);
    echo'<tr class="small">'.
      '<td class="text-center align-middle small">'.date('D M d Y',$r['ti']).'<br>'.date('h:i:s A',$r['ti']).'</td>'.
      '<td class="align-middle pt-2 small text-wrap'.$testurlFrom.'"><a target="_blank" href="'.$r['urlFrom'].'">'.$r['urlFrom'].'</a></td>'.
      '<td class="align-middle pt-2 small text-wrap'.$testurlDest.'">'.$r['urlDest'].'</td>'.
      '<td class="text-center align-middle">'.
        '<div class="d-inline-block justify-content-center p-1 mr-1">'.
          getOSIcon(strtolower($r['os'])).
        '</div>'.
      '</td>'.
      '<td class="text-center align-middle">'.
        '<div class="d-inline-block justify-content-center p-1 ml-1">'.
          getBrowserIcon(strtolower($r['browser'])).
        '</div>'.
      '</td>'.
      '<td class="text-center align-middle">'.
        getDeviceIcon(strtolower($r['device']),$r['viewportwidth']).
      '</td>'.
      '<td class="text-center align-middle">'.
        ($r['action']=='Call Click'?'Called':'Browsing').
      '</td>'.
    '</tr>';
  }
  echo'</tbody>'.
    '</table>';
}
echo'</div>';
