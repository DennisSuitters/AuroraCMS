<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Display More Tracking Items
 * @package    core/more_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function short_number($num){
  $units=['','K','M','B','T'];
  for ($i=0;$num>=1000;$i++){
    $num /= 1000;
  }
  return round($num,1).$units[$i];
}
$f=filter_input(INPUT_GET,'f',FILTER_UNSAFE_RAW);
$t=filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
if($t<$f){
  echo'<div class="alert alert-info text-center">End Date must be after Start Date!</div>';
}else{
  $sv=$db->prepare("SELECT * FROM `".$prefix."visit_tracker` WHERE `ti` >=:ti1 AND `ti` <= :ti2 ORDER BY `ti` DESC");
  $sv->execute([
    ':ti1'=>$f,
    ':ti2'=>$t
  ]);
  if($sv->rowCount()>0){
    while($rv=$sv->fetch(PDO::FETCH_ASSOC)){
	    if($rv['type']=='page'){
        $cs=$db->prepare("SELECT `id`,`title` FROM `".$prefix."menu` WHERE `id`=:id");
	    }else{
        $cs=$db->prepare("SELECT `id`,`title` FROM `".$prefix."content` WHERE `id`=:id");
	    }
      $cs->execute([':id'=>$rv['rid']]);
      $rs=$cs->fetch(PDO::FETCH_ASSOC);
      echo'<article id="l_'.$rv['id'].'" class="card zebra m-0 p-0 pt-2 overflow-visible card-list item shadow">'.
        '<div class="row pb-2">'.
          '<div class="col-2 pl-2 pb-2"><small>'.date($config['dateFormat'],$rv['ti']).'</small></div>'.
          '<div class="col-10 pl-2 pb-2"><small>'.$rs['title'].'</small></div>'.
          '<div class="col text-center"><button id="direct'.$rv['id'].'" class="btn trash" onclick="$(`#direct'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`direct`,`0`);">'.short_number($rv['direct']).'</button></div>'.
          '<div class="col text-center"><button id="bing'.$rv['id'].'" class="btn trash" onclick="$(`#bing'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`bing`,`0`);">'.short_number($rv['bing']).'</button></div>'.
          '<div class="col text-center"><button id="duckduckgo'.$rv['id'].'" class="btn trash" onclick="$(`#duckduckgo'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`duckduckgo`,`0`);">'.short_number($rv['duckduckgo']).'</button></div>'.
          '<div class="col text-center"><button id="facebook'.$rv['id'].'" class="btn trash" onclick="$(`#facebook'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`facebook`,`0`);">'.short_number($rv['facebook']).'</button></div>'.
          '<div class="col text-center"><button id="instagram'.$rv['id'].'" class="btn trash" onclick="$(`#instagram'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`instagram`,`0`);">'.short_number($rv['instagram']).'</button></div>'.
          '<div class="col text-center"><button id="google'.$rv['id'].'" class="btn trash" onclick="$(`#google'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`google`,`0`);">'.short_number($rv['google']).'</button></div>'.
          '<div class="col text-center"><button id="linkedin'.$rv['id'].'" class="btn trash" onclick="$(`#linkedin'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`linkedin`,`0`);">'.short_number($rv['linkedin']).'</button></div>'.
          '<div class="col text-center"><button id="reddit'.$rv['id'].'" class="btn trash" onclick="$(`#reddit'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`reddit`,`0`);">'.short_number($rv['reddit']).'</button></div>'.
          '<div class="col text-center"><button id="threads'.$rv['id'].'" class="btn trash" onclick="$(`#threads'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`threads`,`0`);">'.short_number($rv['threads']).'</button></div>'.
          '<div class="col text-center"><button id="twitter'.$rv['id'].'" class="btn trash" onclick="$(`#twitter'.$rv['id'].'`).text(`0`);updateButtons(`'.$rv['id'].'`,`visit_tracker`,`twitter`,`0`);">'.short_number($rv['twitter']).'</button></div>'.
          '<div class="col text-right pr-2">'.
            '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$rv['id'].'`,`visit_tracker`);"><i class="i">trash</i></button>'.
          '</div>'.
        '</div>'.
      '</article>';
    }
  }
}
