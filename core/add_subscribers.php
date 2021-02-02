<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Subscriber
 * @package    core/add_subscriber.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
$ti=time();
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$emls=isset($_POST['emails'])?filter_input(INPUT_POST,'emails',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'emails',FILTER_SANITIZE_STRING);
$emails=explode(",",$emls);
foreach($emails as $eml){
  if(filter_var($eml,FILTER_VALIDATE_EMAIL)){
    $q=$db->prepare("SELECT `id` FROM `".$prefix."subscribers` WHERE `email`=:email");
    $q->execute([
      ':email'=>$eml
    ]);
    if($q->rowCount()<1){
      $ti=time();
      $q=$db->prepare("INSERT IGNORE INTO `".$prefix."subscribers` (`email`,`hash`,`ti`) VALUES (:email,:hash,:ti)");
      $q->execute([
        ':email'=>$eml,
        ':hash'=>md5($eml),
        ':ti'=>$ti
      ]);
      $id=$db->lastInsertId();
      echo'<script>'.
        'window.top.window.$(`#subs`).append(`<tr id="l_'.$id.'" class="item">'.
          '<td>'.$eml.'</td>'.
          '<td>'.date($config['dateFormat'],$ti).'</td>'.
          '<td class="align-middle">'.
            '<div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">'.
              '<div class="btn-group" role="group" aria-label="Item Controls">'.
                '<form target="sp" method="post" action="core/purge.php">'.
  								'<input name="id" type="hidden" value="'.$id.'">'.
  								'<input name="t" type="hidden" value="subscribers">'.
  								'<button class="trash" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
  							'</form>'.
              '</div>'.
            '</div>'.
          '</td>'.
        '</tr>`);'.
      '</script>';
    }else
      echo'<script>window.top.window.toastr["error"]("&quot;'.$eml.'&quot; is already Subscribed!");</script>';
  }else
    echo'<script>window.top.window.toastr["error"]("&quot;'.$eml.'&quot; is not a valid email!");</script>';
}
