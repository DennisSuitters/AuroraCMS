<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Various Data Items
 * @package    core/add_data.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
require'zebraimage/zebra_image.php';
require'sanitise.php';
define('THEME','../layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.'/theme.ini',true);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'act',FILTER_UNSAFE_RAW);
echo'<script>';
if($act!=''){
  $uid=isset($_SESSION['uid'])?(int)$_SESSION['uid']:0;
  $ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
  $error=0;
  $ti=time();
  switch($act){
    case'make_client':
      $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
      $q=$db->prepare("SELECT `name`,`email`,`phone` FROM `".$prefix."messages` WHERE `id`=:id");
      $q->execute([':id'=>$id]);
      $r=$q->fetch(PDO::FETCH_ASSOC);
      $q=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`name`,`email`,`phone`,`ti`) VALUES (:name,:email,:phone,:ti)");
      $q->execute([
        ':name'=>$r['name'],
        ':email'=>$r['email'],
        ':phone'=>$r['phone'],
        ':ti'=>$ti
      ]);
      $e=$db->errorInfo();
      if(is_null($e[2]))echo'window.top.window.toastr["success"]("Contact added as Client");';
			else echo'window.top.window.toastr["error"]("There was an issue adding the Data!");';
      break;
    case'add_comment':
      $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
      $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
      if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `email`=:email");
        $q->execute([':email'=>$email]);
        $c=$q->fetch(PDO::FETCH_ASSOC);
        $cid=$c['id']!=0?$c['id']:0;
        $name=filter_input(INPUT_POST,'name',FILTER_UNSAFE_RAW);
        $contentType=filter_input(INPUT_POST,'contentType',FILTER_UNSAFE_RAW);
        $da=filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW);
        $status='approved';
        $q=$db->prepare("INSERT IGNORE INTO `".$prefix."comments` (`contentType`,`rid`,`uid`,`cid`,`ip`,`name`,`email`,`notes`,`status`,`ti`) VALUES (:contentType,:rid,:uid,:cid,:ip,:name,:email,:notes,:status,:ti)");
        $q->execute([
          ':contentType'=>$contentType,
          ':rid'=>$rid,
          ':uid'=>$uid,
          ':cid'=>$cid,
          ':ip'=>$ip,
          ':name'=>$name,
          ':email'=>$email,
          ':notes'=>$da,
          ':status'=>$status,
          ':ti'=>$ti
        ]);
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){
					$avatar='core/images/noavatar.jpg';
          if($c['avatar']!=''&&file_exists('../media/'.$c['avatar']))$avatar='media/avatar/'.$c['avatar'];
          elseif($c['gravatar']!=''){
            if(stristr($c['gravatar'],'@'))$avatar='http://gravatar.com/avatar/'.md5($c['gravatar']);
            elseif(stristr($c['gravatar'],'gravatar.com/avatar/'))$avatar=$c['gravatar'];
					}
	  			echo'window.top.window.$("#comments").append(`<div id="l_'.$id.'" class="row p-2 mt-1 swing-in-top-fwd">'.
						'<div class="col-1">'.
							'<img style="max-width:64px;height:64px;" alt="User" src="'.$avatar.'">'.
						'</div>'.
						'<div class="col-9">'.
							'<h6 class="media-heading">'.$name.'</h6>'.
							'<time><small>'.date($config['dateFormat'],$ti).'</small></time><br>'.
							$da.
						'</div>'.
						'<div class="col-2 text-right align-top" id="controls-'.$id.'">'.
							'<form target="sp" method="post" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$id.'">'.
								'<input name="t" type="hidden" value="comments">'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
							'</form>'.
						'</div>'.
					'</div>`);';
   			}else echo'window.top.window.toastr["error"]("There was an issue adding the Data!");';
      }else echo'window.top.window.toastr["error"]("The Email enter is not valid!");';
      break;
    case'add_avatar':
		case'add_tstavatar':
      $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
      $tbl=filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW);
      $tbl=kses($tbl,array());
      $col=filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW);
      $col=kses($col,array());
      $exif='none';
      $fu=$_FILES['fu'];
      if(isset($_FILES['fu'])){
        $ft=$_FILES['fu']['type'];
        if($ft=="image/jpeg"||$ft=="image/pjpeg"||$ft=="image/png"||$ft=="image/gif"){
          $tp='../media/'.basename($_FILES['fu']['name']);
          if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
            if($ft=="image/jpeg"||$ft=="image/pjpeg")$fn=$col.'_'.$id.'.jpg';
            if($ft=="image/png")$fn=$col.'_'.$id.'.png';
            if($ft=="image/gif")$fn=$col.'_'.$id.'.gif';
						if($act=='add_tstavatar'){
							$fn='tst'.$fn;
							$q=$db->prepare("UPDATE `".$prefix."content` SET `file`=:avatar WHERE `id`=:id");
						}else$q=$db->prepare("UPDATE `".$prefix."login` SET `avatar`=:avatar WHERE `id`=:id");
						$q->execute([
							':avatar'=>'avatar'.$fn,
							':id'=>$id
						]);
            $image=new Zebra_image();
            $image->source_path=$tp;
            $image->target_path='../media/avatar/avatar'.$fn;
            $image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);
            rename($tp,'../media/avatar/avatar'.$fn);
						if($act=='add_tstavatar')echo'window.top.window.$("#tstavatar").attr("src","media/avatar/avatar'.$fn.'?'.time().'");';
 						else echo'window.top.window.$(".img-avatar").attr("src","media/avatar/avatar'.$fn.'?'.time().'");';
					}
        }
      }
			break;
    case'add_orderitem':
      $oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
      $iid=filter_input(INPUT_GET,'iid',FILTER_SANITIZE_NUMBER_INT);
      if($iid!=0){
        $q=$db->prepare("SELECT `title`,`cost` FROM `".$prefix."content` WHERE `id`=:id");
        $q->execute([':id'=>$iid]);
        $r=$q->fetch(PDO::FETCH_ASSOC);
				if($r['cost']==''||!is_numeric($r['cost']))$r['cost']=0;
      }else{
        $r=[
          'title'=>'',
          'cost'=>0
        ];
      }
      $q=$db->prepare("INSERT INTO `".$prefix."orderitems` (`oid`,`iid`,`title`,`quantity`,`cost`,`ti`) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
      $q->execute([
        ':oid'=>$oid,
        ':iid'=>$iid,
        ':title'=>$r['title'],
        ':cost'=>$r['cost'],
        ':ti'=>time()
      ]);
      $total=0;
      $html='';
      $q=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
      $q->execute([':oid'=>$oid]);
  		echo'window.top.window.$("#updateorder").html(`';
      while($oi=$q->fetch(PDO::FETCH_ASSOC)){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
        $s->execute([':id'=>$oi['iid']]);
        $i=$s->fetch(PDO::FETCH_ASSOC);
        echo'<tr>'.
							'<td class="text-left">'.$i['code'].'<div class="visible-xs">'.$i['title'].'</div></td>'.
							'<td class="text-left hidden-xs">'.$i['title'].'</td>'.
							'<td class="col-md-1 text-center">'.($oi['iid']!=0?'<form target="sp" action="core/update.php"><input name="id" type="hidden" value="'.$oi['id'].'"><input name="t" type="hidden" value="orderitems"><input name="c" type="hidden" value="quantity"><input class="text-center" name="da" value="'.$oi['quantity'].'"></form>':'').'</td>'.
							'<td class="col-md-1 text-right">'.($oi['iid']!=0?'<form target="sp" action="core/update.php"><input name="id" type="hidden" value="'.$oi['id'].'"><input name="t" type="hidden" value="orderitems"><input name="c" type="hidden" value="cost"><input class="text-center" name="da" value="'.$oi['cost'].'"></form>':'').'</td>'.
							'<td class="text-right">'.($oi['iid']!=0?$oi['cost']*$oi['quantity']:'').'</td>'.
							'<td class="text-right">'.
								'<form target="sp" action="core/update.php">'.
									'<input name="id" type="hidden" value="'.$oi['id'].'">'.
									'<input name="t" type="hidden" value="orderitems">'.
									'<input name="c" type="hidden" value="quantity">'.
									'<input name="da" type="hidden" value="0">'.
									'<button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
								'</form>'.
							'</td>'.
						'</tr>';
        $total=$total+($oi['cost']*$oi['quantity']);
      }
      echo'<tr>'.
				'<td colspan="3">&nbsp;</td>'.
				'<td class="text-right"><strong>Total</strong></td>'.
				'<td class="text-right"><strong>'.$total.'</strong></td>'.
				'<td role="cell">&nbsp;</td>'.
			'</tr>';
  	echo'`);';
		break;
  }
}
echo'</script>';
