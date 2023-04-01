<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Quick Edit
 * @package    core/quickedit.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$rank=isset($_SESSION['rank'])?$_SESSION['rank']:400;
function rank($rank){
  if($rank==0)return"Visitor";
  if($rank==100)return"Subscriber";
  if($rank==200)return"Member";
  if($rank==210)return"Member Bronze";
  if($rank==220)return"Member Silver";
  if($rank==230)return"Member Gold";
  if($rank==240)return"Member Platinum";
  if($rank==300)return"Client";
  if($rank==310)return"Wholesaler";
  if($rank==320)return"Wholesaler Bronze";
  if($rank==330)return"Wholesaler Silver";
  if($rank==340)return"Wholesaler Gold";
  if($rank==350)return"Wholesaler Platinum";
  if($rank==400)return"Contributor";
  if($rank==500)return"Author";
  if($rank==600)return"Editor";
  if($rank==700)return"Moderator";
  if($rank==800)return"Manager";
  if($rank==900)return"Administrator";
  if($rank==1000)return"Developer";
}
function rankclass($rank){
  if($rank==0)return"visitor";
  if($rank==100)return"subscriber";
  if($rank==200)return"member";
  if($rank==210)return"member-bronze";
  if($rank==220)return"member-silver";
  if($rank==230)return"member-gold";
  if($rank==240)return"member-platinum";
  if($rank==300)return"client";
  if($rank==310)return"wholesale";
  if($rank==320)return"wholesale-bronze";
  if($rank==330)return"wholesale-silver";
  if($rank==340)return"wholesale-gold";
  if($rank==350)return"wholesale-platinum";
  if($rank==400)return"contributor";
  if($rank==500)return"author";
  if($rank==600)return"editor";
  if($rank==700)return"moderator";
  if($rank==800)return"manager";
  if($rank==900)return"administrator";
  if($rank==1000)return"developer";
}
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
if($t=='content'||$t=='login'||$t=='orders'){
	$s=$db->prepare("SELECT * FROM `".$prefix.$t."` WHERE id=:id");
	$s->execute([':id'=>$id]);
	$r=$s->fetch(PDO::FETCH_ASSOC);
	if(!isset($r['id']))$r['id']=0;
	if(!isset($r['contentType']))$r['contentType']='';
	if(!isset($r['urlSlug']))$r['urlSlug']='';
	if(!isset($r['ti']))$r['ti']=0;
	if(!isset($r['pti']))$r['pti']=0;
	if(!isset($r['eti']))$r['eti']=0;
	if(!isset($r['status']))$r['status']='';
	if(!isset($r['rank']))$r['rank']=0;
  if($t=='login'){
    echo'<div class="row">'.
      '<div class="col-12 col-sm-4 p-1">';
        if($r['name']!=''&&$r['bio_options'][0]==1){
          echo'<div class="row">'.
            '<label for="qeprofilelink'.$r['id'].'">Profile Link</label>'.
            '<div class="form-row">'.
              '<a id="qeprofilelink'.$r['id'].'" target="_blank" href="'.URL.'profile/'.str_replace(' ','-',$r['name']).'">'.URL.'profile/'.str_replace(' ','-',$r['name']).'</a>'.
            '</div>'.
          '</div>';
        }
        echo'<div class="row">'.
          '<div class="col-12 col-sm-6 pr-1">'.
            '<label for="qename'.$r['id'].'">Name</label>'.
            '<div class="form-row">'.
              '<input class="qetextinput" id="qename'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="name" type="text" value="'.$r['name'].'" placeholder="Enter a Name...">'.
              '<button class="qesave" id="qesavename'.$r['id'].'" data-tooltip="tooltip" data-dbid="qename'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
          '<div class="col-12 col-sm-6 pl-1">'.
            '<label for="qebusiness'.$r['id'].'">Business</label>'.
            '<div class="form-row">'.
              '<input class="qetextinput" id="qebusiness'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="business" type="text" value="'.$r['business'].'" placeholder="Enter a Business...">'.
              '<button class="qesave" id="qesavebusiness'.$r['id'].'" data-tooltip="tooltip" data-dbid="qebusiness'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
        '</div>'.
        '<div class="row">'.
          '<label for="qeemail'.$r['id'].'">Email</label>'.
          '<div class="form-row">';
            $sm=$db->prepare("SELECT id FROM `".$prefix."choices` WHERE `contentType`='mailbox'");
            $sm->execute();
            if($sm->rowCount()>0){
              $email=URL.$settings['system']['admin'].'/messages/compose/';
              $emailwin=false;
            }else{
              $email='mailto:';
              $emailwin=true;
            }
            echo'<input class="qetextinput" id="qeemail'.$r['id'].'" type="text" value="'.$r['email'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="email" placeholder="Enter an Email...">'.
            '<button data-tooltip="tooltip" aria-label="Send Email" onclick="window.open(`'.$email.'`+$(`#qeemail'.$r['id'].'`).val(),'.($emailwin==true?'`_blank`':'`_self`').');"><i class="i">email-send</i></button>'.
            '<button class="qesave" id="qesaveemail'.$r['id'].'" data-tooltip="tooltip" data-dbid="qeemail'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
          '</div>'.
        '</div>'.
        '<div class="row">'.
          '<label for="qeurl'.$r['id'].'">URL</label>'.
          '<div class="form-row">'.
            '<input class="qetextinput" id="qeurl'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="url" type="text" value="'.$r['url'].'" placeholder="Enter a URL...">'.
            '<button data-tooltip="tooltip" aria-label="Open URL in New Window" onclick="window.open($(`#qeurl'.$r['id'].'`).val(),`_blank`);"><i class="i">new-window</i></button>'.
            '<button class="qesave" id="qesaveurl'.$r['id'].'" data-tooltip="tooltip" data-dbid="qeurl'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
          '</div>'.
        '</div>'.
        '<div class="row">'.
          '<div class="col-12 col-sm-6 pr-1">'.
            '<label for="qephone'.$r['id'].'">Phone</label>'.
            '<div class="form-row">'.
              '<input class="qetextinput" id="qephone'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="phone" type="text" value="'.$r['phone'].'" placeholder="Enter a Phone...">'.
              '<button class="qesave" id="qesavephone'.$r['id'].'" data-tooltip="tooltip" data-dbid="qephone'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
          '<div class="col-12 col-sm-6 pl-1">'.
            '<label for="qemobile'.$r['id'].'">Mobile</label>'.
            '<div class="form-row">'.
              '<input class="qetextinput" id="qemobile'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="mobile" type="text" value="'.$r['mobile'].'" placeholder="Enter a Mobile...">'.
              '<button class="save" id="qesavemobile'.$r['id'].'" data-tooltip="tooltip" data-dbid="qemobile'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
        '</div>'.
      '</div>'.
      '<div class="col-12 col-sm-4 p-1">'.
        '<div class="row">'.
          '<label for="qeaddress'.$r['id'].'">Address</label>'.
          '<div class="form-row">'.
            '<input class="qetextinput" id="qeaddress'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="address" type="text" value="'.$r['address'].'" placeholder="Enter an Address...">'.
            '<button class="qesave" id="qesaveaddress'.$r['id'].'" data-tooltip="tooltip" data-dbid="qeaddress'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
          '</div>'.
        '</div>'.
        '<div class="row">'.
          '<div class="col-12 col-sm-6 pr-1">'.
            '<label for="qesuburb'.$r['id'].'">Suburb</label>'.
            '<div class="form-row">'.
              '<input class="qetextinput" id="qesuburb'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="suburb" type="text" value="'.$r['suburb'].'" placeholder="Enter a Suburb...">'.
              '<button class="qesave" id="qesavesuburb'.$r['id'].'" data-tooltip="tooltip" data-dbid="qesuburb'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
          '<div class="col-12 col-sm-6 pl-1">'.
            '<label for="qecity'.$r['id'].'">City</label>'.
            '<div class="form-row">'.
              '<input class="qetextinput" id="qecity'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="city" type="text" value="'.$r['city'].'" placeholder="Enter a City...">'.
              '<button class="qesave" id="qesavecity'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecity'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
        '</div>'.
        '<div class="row">'.
        '<div class="col-12 col-sm-6 pr-1">'.
          '<label for="qestate'.$r['id'].'">State</label>'.
          '<div class="form-row">'.
            '<input class="qetextinput" id="qestate'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="state" type="text" value="'.$r['state'].'" placeholder="Enter a State...">'.
            '<button class="qesave" id="qesavestate'.$r['id'].'" data-tooltip="tooltip" data-dbid="qestate'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
          '</div>'.
        '</div>'.
        '<div class="col-12 col-sm-6 pl-1">'.
          '<label for="qepostcode'.$r['id'].'">Postcode</label>'.
          '<div class="form-row">'.
            '<input class="qetextinput" id="qepostcode'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="postcode" type="text" value="'.($r['postcode']!=0?$r['postcode']:'').'" placeholder="Enter a Postcode...">'.
            '<button class="qesave" id="qesavepostcode'.$r['id'].'" data-tooltip="tooltip" data-dbid="qepostcode'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
          '</div>'.
        '</div>'.
      '</div>'.
      '<div class="row">'.
        '<label for="qecountry'.$r['id'].'">Country</label>'.
        '<div class="form-row">'.
          '<input class="qetextinput" id="qecountry'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="country" type="text" value="'.$r['country'].'" placeholder="Enter a Country...">'.
          '<button class="qesave" id="qesavecountry'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecountry'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
        '</div>'.
      '</div>'.
      '<div class="row">'.
        '<label for="qetags'.$r['id'].'">Tags</label>'.
        '<div class="form-row">'.
          '<input class="qetextinput" id="qetags'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="'.$t.'" data-dbc="tags" type="text" value="'.$r['tags'].'" placeholder="Enter Tags...">'.
          '<button class="qesave" id="qesavetags'.$r['id'].'" data-tooltip="tooltip" data-dbid="qetags'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
        '</div>';
        $tags=array();
        $st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
        echo'<select id="tags_options" onchange="qeaddTag(`'.$r['id'].'`,$(this).val());">'.
          '<option value="none">Clear All</option>';
          if($st->rowCount()>0){
            while($rt=$st->fetch(PDO::FETCH_ASSOC)){
              $tagslist=explode(",",$rt['tags']);
              foreach($tagslist as$ts)$tgs[]=$ts;
            }
            $tags=array_unique($tgs);
            asort($tags);
            foreach($tags as$ts)echo'<option value="'.$ts.'">'.$ts.'</option>';
          }
        echo'</select>'.
      '</div>'.
    '</div>'.
    '<div class="col-12 col-sm-4 p-1">'.
      '<div class="row">'.
        '<label for="qeti'.$r['id'].'">Created</label>'.
        '<input id="qeti'.$r['id'].'" type="text" value="'.date($config['dateFormat'],$r['ti']).'" readonly>'.
      '</div>'.
      '<div class="row">'.
        '<label for="qerank'.$r['id'].'">Rank</label>'.
        '<select id="qerank'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="rank" onchange="update(`'.$r['id'].'`,`login`,`rank`,$(this).val());$(`#accountrank'.$r['id'].'`).text(rank($(this).val()));$(`#accountrank'.$r['id'].'`).removeClass().addClass(`badger badge-`+rankclass($(this).val()));">'.
          '<option value="0"'.($r['rank']==0?' selected':'').'>Visitor</option>'.
          '<option value="100"'.($r['rank']==100?' selected':'').'>Subscriber</option>'.
          '<option value="200"'.($r['rank']==200?' selected':'').'>Member</option>'.
          '<option value="210"'.($r['rank']==210?' selected':'').'>Member Bronze</option>'.
          '<option value="220"'.($r['rank']==220?' selected':'').'>Member Silver</option>'.
          '<option value="230"'.($r['rank']==230?' selected':'').'>Member Gold</option>'.
          '<option value="240"'.($r['rank']==240?' selected':'').'>Member Platinum</option>'.
          '<option value="300"'.($r['rank']==300?' selected':'').'>Client</option>'.
          '<option value="310"'.($r['rank']==310?' selected':'').'>Wholesaler</option>'.
          '<option value="320"'.($r['rank']==320?' selected':'').'>Wholesaler Bronze</option>'.
          '<option value="330"'.($r['rank']==330?' selected':'').'>Wholesaler Silver</option>'.
          '<option value="340"'.($r['rank']==340?' selected':'').'>Wholesaler Gold</option>'.
          '<option value="350"'.($r['rank']==350?' selected':'').'>Wholesaler Platinum</option>'.
          '<option value="400"'.($r['rank']==400?' selected':'').'>Contributor</option>'.
          '<option value="500"'.($r['rank']==500?' selected':'').'>Author</option>'.
          '<option value="600"'.($r['rank']==600?' selected':'').'>Editor</option>'.
          '<option value="700"'.($r['rank']==700?' selected':'').'>Moderator</option>'.
          '<option value="800"'.($r['rank']==800?' selected':'').'>Manager</option>'.
          '<option value="900"'.($r['rank']==900?' selected':'').'>Administrator</option>'.
          ($rank==1000?'<option value="1000"'.($r['rank']==1000?' selected':'').'>Developer</option>':'').
        '</select>'.
      '</div>'.
      '<div id="aWT'.$r['id'].'" class="row'.($r['rank']<301||$r['rank']>399?' d-none':'').'">'.
        '<input id="accountWholesaler'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="options" data-dbb="19" type="checkbox"'.($r['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"').' onclick="$(\'#wholesaler'.$r['id'].'\').toggleClass(\'d-none\');">'.
        '<label for="accountWholesaler'.$r['id'].'" id="loginnewsletter0'.$r['id'].'">Wholesaler Accepted to Purchase</label>'.
      '</div>'.
      '<div class="row">'.
        '<label for="qespent'.$r['id'].'">Spent</label>'.
        '<div class="form-row">'.
          '<div class="input-text">$</div>'.
          '<input class="qetextinput" id="qespent'.$r['id'].'" type="number" value="'.$r['spent'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="spent">'.
          '<button class="qesave" id="qesavespent'.$r['id'].'" data-tooltip="tooltip" data-dbid="qespent'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
        '</div>'.
      '</div>'.
      '<div class="row">'.
        '<label for="qepoints'.$r['id'].'">Points Earned</label>'.
        '<div class="form-row">'.
          '<input class="qetextinput" id="qepoints'.$r['id'].'" type="number" value="'.$r['points'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="points">'.
          '<button class="qesave" id="qesavepoints'.$r['id'].'" data-tooltip="tooltip" data-dbid="qepoints'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
        '</div>'.
      '</div>'.
      '<div class="row">'.
        'User is'.($r['newsletter']==1?'':' not').' a Newsletter Subscriber'.
      '</div>'.
      '<div class="row">'.
        'IP: '.$r['userIP'].
      '</div>'.
      '<div class="row">'.
        'Browser Info: '.$r['userAgent'].
      '</div>'.
    '</div>'.
  '</div>';
  }

if($t=='content'){
  echo'<div class="row">'.
    '<div class="col-12 col-sm-4 p-1">'.
      '<div class="row">'.
        '<label for="qegenurl'.$r['id'].'">URL Slug</label>'.
        '<div class="form-row col-12">'.
          '<a id="qegenurl'.$r['id'].'" target="_blank" href="'.URL.$r['contentType'].'/'.$r['urlSlug'].'">'.URL.$r['contentType'].'/'.$r['urlSlug'].' <i class="i">new-window</i></a>'.
        '</div>'.
      '</div>';
      if($r['contentType']=='inventory'||$r['contentType']=='service'){
        echo'<div class="row">'.
          '<div class="col-6 pr-1">'.
            '<label for="qerrp'.$r['id'].'" data-tooltip="tooltip" aria-label="Recommended Retail Price">RRP</label>'.
            '<div class="form-row">'.
              '<div class="input-text">$</div>'.
              '<input class="qetextinput" id="qerrp'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="rrp" type="text" value="'.$r['rrp'].'">'.
              '<button class="qesave" id="qesaverrp'.$r['id'].'" data-tooltip="tooltip" data-dbid="qerrp'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
          '<div class="col-6 pl-1">'.
            '<label for="qecost'.$r['id'].'">Cost</label>'.
            '<div class="form-row">'.
              '<div class="input-text">$</div>'.
              '<input class="qetextinput" id="qecost'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="cost" type="text" value="'.$r['cost'].'" placeholder="Enter a Cost...">'.
              '<button class="qesave" id="qesavecost'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecost'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
        '</div>'.
        '<div class="row">'.
          '<div class="col-6 pr-1">'.
            '<label for="qerCost'.$r['id'].'">Reduced Cost</label>'.
            '<div class="form-row">'.
              '<div class="input-text">$</div>'.
              '<input class="qetextinput" id="qerCost'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="rCost" type="text" value="'.$r['rCost'].'" placeholder="Enter a Reduced Cost...">'.
              '<button class="qesave" id="qesaverCost'.$r['id'].'" data-tooltip="tooltip" data-dbid="qerCost'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
          '<div class="col-6 pl-1">'.
            '<label for="qedCost'.$r['id'].'">Distributor Cost</label>'.
            '<div class="form-row">'.
              '<div class="input-text">$</div>'.
              '<input class="qetextinput" id="qedCost'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="dCost" type="text" value="'.$r['dCost'].'" placeholder="Enter a Distributor Cost...">'.
              '<button class="qesave" id="qesavedCost'.$r['id'].'" data-tooltip="tooltip" data-dbid="qedCost'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
            '</div>'.
          '</div>'.
        '</div>';
      }
      if($r['contentType']=='inventory'){
        echo'<div class="row">'.
          '<label for="qequantity'.$r['id'].'">Quantity</label>'.
          '<div class="form-row">'.
            '<input class="qetextinput" id="qequantity'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="quantity" type="text" value="'.$r['quantity'].'">'.
            '<button class="qesave" id="qesavequantity'.$r['id'].'" data-tooltip="tooltip" data-dbid="qequantity'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
          '</div>'.
        '</div>'.
        '<div class="row">'.
          '<label for="qestockStatus'.$r['id'].'">Stock Status</label>'.
            '<select id="qestockStatus'.$r['id'].'" onchange="update(`'.$r['id'].'`,`content`,`stockStatus`,$(this).val());">'.
              '<option value="quantity"'.($r['stockStatus']=='quantity'?' selected':'').'>Dependant on Quantity (In Stock/Out Of Stock)</option>'.
              '<option value="in stock"'.($r['stockStatus']=='in stock'?' selected':'').'>In Stock</option>'.
              '<option value="out of stock"'.($r['stockStatus']=='out of stock'?' selected':'').'>Out Of Stock</option>'.
              '<option value="back order"'.($r['stockStatus']=='back order'?' selected':'').'>Back Order</option>'.
              '<option value="pre order"'.($r['stockStatus']=='pre order'?' selected':'').'>Pre Order</option>'.
              '<option value="available"'.($r['stockStatus']=='available'?' selected':'').'>Available</option>'.
              '<option value="sold out"'.($r['stockStatus']=='sold out'?' selected':'').'>Sold Out</option>'.
              '<option value="none"'.($r['stockStatus']=='none'||$r['stockStatus']==''?' selected':'').'>No Display</option>'.
            '</select>'.
          '</div>';
        }
        echo'</div>'.
        '<div class="col-12 col-sm-4 p-1">';
          if($r['contentType']=='events'){
            echo'<div class="row">'.
              '<label for="qetis'.$r['id'].'">Event Start <span class="labeldate small ml-2" id="labeldatetis'.$r['id'].'">('.date($config['dateFormat'],$r['tis']).')</span></label>'.
              '<input id="qetis'.$r['id'].'" type="datetime-local" value="'.($r['tis']!=0?date('Y-m-d\TH:i',$r['tis']):'').'" autocomplete="off" onchange="update(`'.$r['id'].'`,`content`,`tis`,getTimestamp(`qetis'.$r['id'].'`));">'.
            '</div>'.
            '<div class="row">'.
              '<label for="qetie'.$r['id'].'">Event End <span class="labeldate small ml-2" id="labeldatetie'.$r['id'].'">('.date($config['dateFormat'],$r['tie']).')</span></label>'.
              '<input id="qetie'.$r['id'].'" type="datetime-local" value="'.($r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'').'" autocomplete="off" onchange="update(`'.$r['id'].'`,`content`,`tie`,getTimestamp(`qetie'.$r['id'].'`));">'.
            '</div>';
          }
          if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){
            echo'<div class="row">'.
              '<label for="qecategory_1'.$r['id'].'">Category One</label>'.
              '<div class="form-row">'.
                '<input class="qetextinput" id="qecategory_1'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_1" type="text" value="'.$r['category_1'].'">'.
                '<button class="qesave" id="qesavecategory_1'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_1'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label for="qecategory_2'.$r['id'].'">Category Two</label>'.
              '<div class="form-row">'.
                '<input class="qetextinput" id="qecategory_2'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_2" type="text" value="'.$r['category_2'].'">'.
                '<button class="qesave" id="qesavecategory_2'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_2'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label for="qecategory_3'.$r['id'].'">Category Three</label>'.
              '<div class="form-row">'.
                '<input class="qetextinput" id="qecategory_3'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_3" type="text" value="'.$r['category_3'].'">'.
                '<button class="qesave" id="qesavecategory_3'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_3'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label for="qecategory_4'.$r['id'].'">Category Four</label>'.
              '<div class="form-row">'.
                '<input class="qetextinput" id="qecategory_4'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_4" type="text" value="'.$r['category_4'].'">'.
                '<button class="qesave" id="qesavecategory_4'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_4'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
              '</div>'.
            '</div>'.
            '<div class="row">'.
              '<label for="qetags'.$r['id'].'">Tags</label>'.
              '<div class="form-row">'.
                '<input class="qetextinput" id="qetags'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="'.$t.'" data-dbc="tags" type="text" value="'.$r['tags'].'" placeholder="Enter Tags...">'.
                '<button class="qesave" id="qesavetags'.$r['id'].'" data-tooltip="tooltip" data-dbid="qetags'.$r['id'].'" aria-label="Save"><i class="i">save</i></button>'.
              '</div>';
              $st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
              echo'<select id="tags_options" onchange="qeaddTag(`'.$r['id'].'`,$(this).val());">'.
                '<option value="none">Clear All</option>';
                if($st->rowCount()>0){
                  while($rt=$st->fetch(PDO::FETCH_ASSOC)){
                    $tagslist=explode(",",$rt['tags']);
                    foreach($tagslist as$ts)echo'<option value="'.$ts.'">'.$ts.'</option>';
                  }
                }
              echo'</select>'.
            '</div>';
          }
          echo'</div>'.
          '<div class="col-12 col-sm-4 p-1">'.
            '<div class="row">'.
              '<label for="qeti'.$r['id'].'">Created</label>'.
              '<input id="qeti'.$r['id'].'" type="text" value="'.date($config['dateFormat'],$r['ti']).'" readonly>'.
            '</div>'.
            '<div class="row">'.
            '<label for="qepti'.$r['id'].'">Published On <span class="labeldate small ml-2" id="labeldatepti'.$r['id'].'">('.date($config['dateFormat'],$r['pti']).')</span></label>'.
            '<input id="qepti'.$r['id'].'" type="datetime-local" value="'.date('Y-m-d\TH:i',$r['pti']).'" autocomplete="off" onchange="update(`'.$r['id'].'`,`content`,`pti`,getTimestamp(`qepti'.$r['id'].'`));">'.
          '</div>'.
          '<div class="row">'.
            '<label for="qestatus'.$r['id'].'">Status</label>'.
            '<select id="qestatus'.$r['id'].'" onchange="update(`'.$r['id'].'`,`content`,`status`,$(this).val());statusSet(`'.$r['id'].'`,$(this).val());">'.
              '<option value="unpublished"'.($r['status']=='unpublished'?' selected':'').'>Unpublished</option>'.
              '<option value="autopublish"'.($r['status']=='autopublish'?' selected':'').'>AutoPublish</option>'.
              '<option value="published"'.($r['status']=='published'?' selected':'').'>Published</option>'.
              '<option value="delete"'.($r['status']=='delete'?' selected':'').'>Delete</option>'.
              '<option value="archived"'.($r['status']=='archived'?' selected':'').'>Archived</option>'.
            '</select>'.
          '</div>'.
          '<div class="row">'.
            '<label for="qerank'.$r['id'].'">Access</label>'.
            '<select id="qerank'.$r['id'].'" onchange="update(`'.$r['id'].'`,`content`,`rank`,$(this).val());$(`#rank'.$r['id'].'`).html($(this).find(`:selected`).text());">'.
              '<option value="0"'.($r['rank']==0?' selected':'').'>Available to Everyone</option>'.
              '<option value="100"'.($r['rank']==100?' selected':'').'>Available to Subscriber and Above</option>'.
              '<option value="200"'.($r['rank']==200?' selected':'').'>Available to Member and Above</option>'.
              '<option value="200"'.($r['rank']==200?' selected':'').'>Available to Member and Above</option>'.
              '<option value="210"'.($r['rank']==210?' selected':'').'>Available to Member Bronze and Above</option>'.
              '<option value="220"'.($r['rank']==220?' selected':'').'>Available to Member Silver and Above</option>'.
              '<option value="230"'.($r['rank']==230?' selected':'').'>Available to Member Gold and Above</option>'.
              '<option value="240"'.($r['rank']==240?' selected':'').'>Available to Member Platinum and Above</option>'.
              '<option value="300"'.($r['rank']==300?' selected':'').'>Available to Client and Above</option>'.
              '<option value="310"'.($r['rank']==310?' selected':'').'>Available to Wholesaler and Above</option>'.
              '<option value="320"'.($r['rank']==320?' selected':'').'>Available to Wholesaler Bronze and Above</option>'.
              '<option value="330"'.($r['rank']==330?' selected':'').'>Available to Wholesaler Silver and Above</option>'.
              '<option value="340"'.($r['rank']==340?' selected':'').'>Available to Wholesaler Gold and Above</option>'.
              '<option value="350"'.($r['rank']==350?' selected':'').'>Available to Wholesaler Platinum and Above</option>'.
              '<option value="400"'.($r['rank']==400?' selected':'').'>Available to Contributor and Above</option>'.
              '<option value="500"'.($r['rank']==500?' selected':'').'>Available to Author and Above</option>'.
              '<option value="600"'.($r['rank']==600?' selected':'').'>Available to Editor and Above</option>'.
              '<option value="700"'.($r['rank']==700?' selected':'').'>Available to Moderator and Above</option>'.
              '<option value="800"'.($r['rank']==800?' selected':'').'>Available to Manager and Above</option>'.
              '<option value="900"'.($r['rank']==900?' selected':'').'>Available to Administrator and Above</option>'.
            '</select>'.
          '</div>'.
          '<div class="row">'.
            '<label for="qelastedited'.$r['id'].'">Last Edited</label>'.
            '<div class="col-12">'.
              ($r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user']).
            '</div>'.
          '</div>'.
        '</div>'.
      '</div>'.
    '</div>';
}
if($t=='orders'){
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([':id'=>$r['uid']]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);
  $track=['title'=>'none'];
  if($r['trackOption']!=0){
    $st=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
    $st->execute([':id'=>$r['trackOption']]);
    $track=$st->fetch(PDO::FETCH_ASSOC);
  }
  echo'<div class="mx-auto p-2 border-0 orderstheme">'.
    '<section class="row">'.
      '<article class="col-12 col-sm mx-0 px-0 py-0 pl-1 border-right text-left">'.
        '<h3>To</h3>'.
        '<div class="ml-2">'.
          $ru['name'].'<br>'.
          $ru['address'].', '.$ru['suburb'].'<br>'.
          $ru['city'].', '.$ru['state'].', '.$ru['postcode'].'<br>'.
          'Email: '.$ru['email'].'<br>'.
          ($ru['phone']!=''?'Phone: '.$ru['phone'].'<br>':'').
          ($ru['mobile']!=''?'Mobile: '.$ru['mobile']:'').
        '</div>'.
      '</article>'.
      '<article class="col-12 col-sm mx-0 px-0 py-0 pl-1 text-left">'.
        '<div class="">'.
          '<strong>Paid Via: </strong>'.ucwords($r['paid_via']).'<br>'.
          '<strong>Transaction ID: </strong>'.$r['txn_id'].'<br>'.
          '<strong>Date Paid: </strong>'.($r['paid_ti']!=0?date($config['dateFormat'],$r['paid_ti']):'<span class="badger badge-danger">Unpaid</span>').'<br>'.
          '<strong>Paid Name: </strong>'.$r['paid_name'].'<br>'.
          '<strong>Paid Email: </strong>'.$r['paid_email'].'<br>'.
          ($track['title']!='none'?'<strong>Tracking Details</strong><br><strong>Service: '.$track['title'].'<br><strong>Tracking Number: </strong>'.$track['trackNumber'].'<br>':'').
        '</div>'.
      '</article>'.
    '</section>'.
    '<section class="row m-0">'.
      '<article class="m-0 p-0">'.
        '<table class="table zebra text-black">'.
          '<thead>'.
            '<tr class="bg-black text-white">'.
              '<th class="col-1 text-left">Code</th>'.
              '<th class="col-auto text-left">Title</th>'.
              '<th class="col-auto text-left">Option</th>'.
              '<th class="col-1 text-center">Qty</th>'.
              '<th class="col-1 text-right">Cost</th>'.
              '<th class="text-center" title="Goods &amp; Services Tax">GST</th>'.
              '<th class="col-1 text-right">Total</th>'.
            '</tr>'.
          '</thead>'.
          '<tbody>';
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `status` ASC, `ti` ASC,`title` ASC");
  $ss->execute([':oid'=>$r['id']]);
  $total=0;
  while($oi=$ss->fetch(PDO::FETCH_ASSOC)){
    $is=$db->prepare("SELECT `id`,`thumb`,`file`,`fileURL`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
    $is->execute([':id'=>$oi['iid']]);
    $i=$is->fetch(PDO::FETCH_ASSOC);
    $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
    $sc->execute([':id'=>$oi['cid']]);
    $c=$sc->fetch(PDO::FETCH_ASSOC);
        echo'<tr class="'.($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?'bg-warning':'').'">'.
              '<td class="text-left align-middle small px-0">'.(isset($i['code'])?$i['code']:'').'</td>'.
              '<td class="text-left align-middle px-0">'.($oi['status']=='back order'||$oi['status']=='pre order'||$oi['status']=='out of stock'?ucwords($oi['status']).': ':'').$oi['title'].'</td>'.
              '<td class="text-left align-middle px-0">'.(isset($c['title'])?$c['title']:'').'</td>'.
              '<td class="text-center align-middle px-0">'.($r['iid']!=0?$oi['quantity']:'').'</td>'.
              '<td class="text-right align-middle">'.($r['iid_ti']!=0?number_format((float)$oi['cost'],2,'.',''):'').'</td>'.
              '<td class="text-right align-middle">';
              $gst=0;
              if($oi['status']!='pre order'||$oi['status']!='back order'){
                if($config['gst']>0){
                  $gst=$oi['cost']*($config['gst']/100);
                  if($oi['quantity']>1)$gst=$gst*$oi['quantity'];
                  $gst=number_format((float)$gst,2,'.','');
                }
                echo$gst>0?$gst:'';
              }
              echo'</td>'.
              '<td class="text-right align-middle">';
              if($oi['status']!='pre order'||$oi['status']!='back order'){
                echo$oi['iid']!=0?number_format((float)$oi['cost']*$oi['quantity']+$gst,2,'.',''):'';
              }else{
                echo'<small>'.($oi['status']=='pre order'?'Pre Order':'Back Order').'</small>';
              }
              echo'</td>'.
            '</tr>';
            if($oi['status']!='pre order'||$oi['status']!='back order'){
              if($oi['iid']!=0){
                $total=$total+($oi['cost']*$oi['quantity'])+$gst;
                $total=number_format((float)$total,2,'.','');
              }
            }
          }
          if($r['rid']>0){
            $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
            $sr->execute([':rid'=>$r['rid']]);
            $reward=$sr->fetch(PDO::FETCH_ASSOC);
            echo'<tr>'.
              '<td class="text-right align-middle px-0 font-weight-bold">Rewards</td>'.
              '<td colspan="5" class="text-right align-middle">Code: '.($reward['method']==1?'$':'%').' Off</td>'.
              '<td class="text-right">'.$reward['value'].'</td>'.
              '<td class="align-middle px-0" colspan="3">'.$reward['code'].'</td>'.
              '<td class="text-center align-middle px-0">';
                if($sr->rowCount()==1){
                  if($reward['method']==1){
                    echo'$';
                    $total=$total-$reward['value'];
                  }
                  echo$reward['value'];
                  if($reward['method']==0){
                    echo'%';
                    $total=($total*((100-$reward['value'])/100));
                  }
                  $total=number_format((float)$total,2,'.','');
                  echo' Off';
                }
              '</td>'.
              '<td class="text-right align-middle">'.(isset($reward['value'])?($reward['value']>0?$total:''):'').'</td>'.
            '</tr>';
          }

          if($config['options'][26]==1){
            $dedtot=0;
            $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
            $sd->execute([
              ':f'=>$ru['spent'],
              ':t'=>$ru['spent']
            ]);
            if($sd->rowCount()>0){
              $rd=$sd->fetch(PDO::FETCH_ASSOC);
              if($rd['value']==1)$dedtot=$rd['cost'];
              if($rd['value']==2)$dedtot=$total*($rd['cost']/100);
              $total=$total - $dedtot;
            echo'<tr>'.
              '<td colspan="2" class="align-middle text-right font-px-0 weight-bold">Spent</td>'.
              '<td colspan="5" class="align-middle text-right px-0">&#36;'.$ru['spent'].' within Discount Range &#36;'.$rd['f'].'-&#36;'.$rd['t'].' granting '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost'].' Off').'</td>'.
              '<td colspan="5" class="align-middle text-right">-'.$dedtot.'</td>'.
            '</tr>';
          }
        }

        if($r['postageOption']!=''){
          echo'<tr>'.
            '<td class="text-right align-middle font-weight-bolod">Shipping</td>'.
            '<td colspan="5" class="text-right align-middle">'.$r['postageOption'].'</td>'.
            '<td class="text-right align-middle">'.$r['postageCost'].'</td>'.
          '</tr>';
          if($r['postageCost']>0){
            $total=$total+$r['postageCost'];
            $total=number((float)$total,2,'.','');
          }
        }
          echo'</tbody>'.
          '<tfoot>'.
            '<tr>'.
              '<td colspan="6" class="text-right align-middle font-weight-bold">Total</td>'.
              '<td class="total align-middle">'.$total.'</td>'.
            '</tr>';

  $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
  $sn->execute([':oid'=>$r['id']]);
  if($sn->rowCount()>0){
    while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
            echo'<tr>'.
              '<td colspan="2" class="small align-middle">'.date($config['dateFormat'],$rn['ti']).'</td>'.
              '<td colspan="4" class="align-middle">'.$rn['title'].'</td>'.
              '<td class="align-middle text-right">-'.number_format((float)$rn['cost'],2,'.','').'</td>'.
            '</tr>';
            $total=$total-$rn['cost'];
            $total=number_format((float)$total,2,'.','');
    }
            echo'<tr>'.
              '<td colspan="6" class="text-right font-weight-bold">Balance</td>'.
              '<td class="total">'.$total.'</td>'.
            '</tr>';
  }
          echo'</tfoot>'.
        '</table>'.
      '</article>'.
    '</section>'.
  '</div>';
}
echo'<script>'.
  '$(".qetextinput").on({'.
    'blur:function(event){'.
      'event.preventDefault();'.
    '},'.
    'keydown:function(event){'.
      'var id=$(this).data("dbid");'.
      'if(event.keyCode==46||event.keyCode==8){'.
        '$(this).trigger(`keypress`);'.
      '}'.
    '},'.
    'keyup:function(event){'.
      'if(event.which==9){'.
        'var id=$(this).data("dbid");'.
        'var da=$(this).val();'.
        '$(this).trigger(`keypress`);'.
        '$(this).next("input").focus();'.
      '}'.
    '},'.
    'keypress:function(event){'.
			'var id=$(this).data("dbid");'.
      'var save=$(this).data("dbc");'.
      '$("#qesave"+save+id).addClass("btn-danger");'.
      'console.log("keypress");'.
      'if(event.which==13){'.
        'event.preventDefault();'.
      '}'.
    '},'.
    'change:function(event){'.
			'var id=$(this).data("dbid");'.
      'var save=$(this).data("dbc");'.
      '$("#qesave"+save+id).addClass("btn-danger");'.
      'console.log("change");'.
    '}'.
  '});'.
  '$(".qesave").click(function(e){'.
	  'e.preventDefault();'.
	 	'var l=Ladda.create(this);'.
    'var el=$(this).data("dbid");'.
    'var id=$("#"+el).data("dbid"),'.
        't=$("#"+el).data("dbt"),'.
        'c=$("#"+el).data("dbc"),'.
        'da=$("#"+el).val();'.
	 	'l.start();'.
    '$("#"+el).attr("disabled","disabled");'.
    '$.ajax({'.
      'type:"GET",'.
      'url:"core/update.php",'.
      'data:{'.
        'id:id,'.
        't:t,'.
        'c:c,'.
        'da:da'.
      '}'.
    '}).done(function(msg){'.
      'l.stop();'.
      '$("#"+el).removeAttr("disabled");'.
      '$("#"+el).removeClass("unsaved");'.
      '$("#qesave"+c+id).removeClass("btn-danger");'.
    '});'.
	 	'return false;'.
	'});'.
	'function qeaddTag(id,t){'.
		'var eltags=$("#qetags"+id).val();'.
		'if(!eltags.includes(t)){'.
			'if(eltags.length > 0){'.
				'eltags+=",";'.
			'}'.
			'if(t=="none"){'.
				'eltags="";'.
			'}else{'.
				'eltags+=t;'.
			'}'.
			'$("#qetags"+id).val(eltags);'.
			'$("#qetags"+id).trigger("change");'.
		'}'.
	'}'.
	'function rank(rank){'.
		'if(rank==0){return "Visitor";}'.
		'if(rank==100){return "Subscriber";}'.
		'if(rank==200){return "Member";}'.
		'if(rank==210){return "Member Bronze";}'.
		'if(rank==220){return "Member Silver";}'.
		'if(rank==230){return "Member Gold";}'.
		'if(rank==240){return "Member Platinum";}'.
		'if(rank==300){return "Client";}'.
		'if(rank==310){return "Wholesaler";}'.
		'if(rank==320){return "Wholesaler Bronze";}'.
		'if(rank==330){return "Wholesaler Silver";}'.
		'if(rank==340){return "Wholesaler Gold";}'.
		'if(rank==350){return "Wholesaler Platinum";}'.
		'if(rank==400){return "Contributor";}'.
		'if(rank==500){return "Author";}'.
		'if(rank==600){return "Editor";}'.
		'if(rank==700){return "Moderator";}'.
		'if(rank==800){return "Manager";}'.
		'if(rank==900){return "Administrator";}'.
		'if(rank==1000){return "Developer";}'.
	'}'.
	'function rankclass(rank){'.
		'if(rank==0){return "visitor";}'.
		'if(rank==100){return "subscriber";}'.
		'if(rank==200){return "member";}'.
		'if(rank==210){return "member-bronze";}'.
		'if(rank==220){return "member-silver";}'.
		'if(rank==230){return "member-gold";}'.
		'if(rank==240){return "member-platinum";}'.
		'if(rank==300){return "client";}'.
		'if(rank==310){return "wholesale";}'.
		'if(rank==320){return "wholesale-bronze";}'.
		'if(rank==330){return "wholesale-silver";}'.
		'if(rank==340){return "wholesale-gold";}'.
		'if(rank==350){return "wholesale-platinum";}'.
		'if(rank==400){return "contributor";}'.
		'if(rank==500){return "author";}'.
		'if(rank==600){return "editor";}'.
		'if(rank==700){return "moderator";}'.
		'if(rank==800){return "manager";}'.
		'if(rank==900){return "administrator";}'.
		'if(rank==1000){return "developer";}'.
	'}'.
'</script>';
}
