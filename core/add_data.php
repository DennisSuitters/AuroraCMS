<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Various Data Items
 * @package    core/add_data.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 */
$getcfg=true;
require'db.php';
echo'<script>';
include'zebra_image.php';
include'sanitise.php';
define('THEME','..'.DS.'layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images'.DS.'i-'.$svg.'.svg').'</i>';
}
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
if($act!=''){
  $uid=isset($_SESSION['uid'])?(int)$_SESSION['uid']:0;
  $ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
  $error=0;
  $ti=time();
  switch($act){
		case'add_reward':
			$code=filter_input(INPUT_POST,'code',FILTER_SANITIZE_STRING);
			$title=filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
			$method=filter_input(INPUT_POST,'method',FILTER_SANITIZE_NUMBER_INT);
			$value=filter_input(INPUT_POST,'value',FILTER_SANITIZE_NUMBER_INT);
			$quantity=filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_NUMBER_INT);
			$tis=filter_input(INPUT_POST,'tis',FILTER_SANITIZE_STRING);
			$tie=filter_input(INPUT_POST,'tie',FILTER_SANITIZE_STRING);
			$tis=$tis!=''?strtotime($tis):0;
			$tie=$tie!=''?strtotime($tie):0;
			$q=$db->prepare("INSERT INTO `".$prefix."rewards` (code,title,method,value,quantity,tis,tie,ti) VALUES (:code,:title,:method,:value,:quantity,:tis,:tie,:ti)");
			$q->execute([
        ':code'=>$code,
        ':title'=>$title,
        ':method'=>$method,
        ':value'=>$value,
        ':quantity'=>$quantity,
        ':tis'=>$tis,
        ':tie'=>$tie,
        ':ti'=>$ti
      ]);
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){?>
	window.top.window.$('#rewards').append('<?php
echo'<tr id="l_'.$id.'">'.
			'<td class="col-1 small text-center">'.$code.'</td>'.
			'<td class="col-4 small text-center">'.$title.'</td>'.
			'<td class="col-1 small text-center">'.($method==0?'% Off':'$ Off').'</td>'.
			'<td class="col-1 small text-center">'.$value.'</td>'.
			'<td class="col-1 small text-center">'.$quantity.'</td>'.
			'<td class="col-2 small text-center">'.($tis!=0?date($config['dateFormat'],$tis):'').'</td>'.
			'<td class="col-2 small text-center">'.($tie!=0?date($config['dateFormat'],$tie):'').'</td>'.
			'<td>'.
				'<form target="sp" action="core/purge.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="rewards">'.
					'<button class="btn btn-default btn-sm trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
				'</form>'.
			'</td>'.
		'</tr>';?>
');
<?php	}else{?>
  window.top.window.toastr["danger"]('There was an issue adding the Reward!');
<?php }
			break;
    case'add_dashrss':
      $url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
      if(filter_var($url,FILTER_VALIDATE_URL)){
        $q=$db->prepare("INSERT INTO `".$prefix."choices` (uid,contentType,url,ti) VALUES (:uid,'dashrss',:url,'0')");
        $q->execute([
          ':uid'=>$uid,
          ':url'=>$url
        ]);
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
  window.top.window.$('#rss').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-12">'.
				'<div class="input-group-addon">URL</div>'.
				'<form target="sp" method="post" action="core/update.php">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="url">'.
					'<input type="text"class="form-control" name="da" value="'.$url.'" placeholder="Enter a URL...">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.toastr["danger"]('There was an issue adding the RSS URL!');
<?php   }
      }
      break;
    case'add_social':
      $user=filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
      $icon=filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING);
      $url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
      if(filter_var($url,FILTER_VALIDATE_URL)){
        if($icon=='none'||$url==''){?>
  window.top.window.$.notify({type:'danger',icon:'',message:text:'Not all Fields were filled in!'});
<?php   }else{
          $q=$db->prepare("INSERT INTO `".$prefix."choices` (uid,contentType,icon,url) VALUES (:uid,'social',:icon,:url)");
          $q->execute([
            ':uid'=>kses($user,array()),
            ':icon'=>$icon,
            ':url'=>kses($url,array())
          ]);
          $id=$db->lastInsertId();
          $e=$db->errorInfo();
          if(is_null($e[2])){?>
  window.top.window.$('#social').append(`<?php
echo'<div id="l_'.$id.'" class="form-group row">'.
			'<div class="input-group col-12">'.
				'<div class="input-group-text" data-tooltip="tooltip" data-title="'.ucfirst($icon).'"><span class="social" aria-label="'.ucfirst($icon).'">'.svg2('social-'.$icon).'</span></div>'.
				'<input type="text" class="form-control" value="'.$url.'" placeholder="Enter a URL..." readonly>'.
				'<div class="input-group-append">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>`);
<?php     }else{?>
  window.top.window.toastr["danger"]('There was an issue adding the Social Networking Link!');
<?php     }
      	}
      }else{?>
  window.top.window.toastr["danger"]('The URL entered is not valid!');
<?php }
      break;
		case'add_option':
      $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
      $ttl=filter_input(INPUT_POST,'ttl',FILTER_SANITIZE_STRING);
			$qty=filter_input(INPUT_POST,'qty',FILTER_SANITIZE_NUMBER_INT);
      if($ttl==''){?>
	window.top.window.toastr["danger"]('Not all Fields were filled in!');
<?php }else{
        $q=$db->prepare("INSERT INTO `".$prefix."choices` (uid,rid,contentType,title,ti) VALUES (:uid,:rid,'option',:title,:ti)");
        $q->execute([
          ':uid'=>$uid,
          ':rid'=>$rid,
          ':title'=>kses($ttl,array()),
          ':ti'=>$qty
        ]);
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
	window.top.window.$('#itemoptions').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-12">'.
				'<span class="input-group-addon">Option</span>'.
				'<form target="sp" method="post">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="title">'.
					'<input type="text" class="form-control" name="da" value="'.$ttl.'" placeholder="Enter an Option...">'.
				'</form>'.
				'<span class="input-group-addon">Quantity</span>'.
				'<form target="sp" method="post">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="ti">'.
					'<input type="text" class="form-control" name="da" value="'.$qty.'" placeholder="Quantity">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
	window.top.window.toastr["danger"]('There was an issue adding the Data!');
<?php   }
      }
      break;
		case'add_related':
			$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
			$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'rid',FILTER_SANITIZE_NUMBER_INT);
			if($id==$rid){?>
	window.top.window.toastr["warning"]('Item can\'t be related to itself!');
<?php	}else{
				if($rid!=0){
				  $s=$db->prepare("SELECT id FROM `".$prefix."choices` WHERE contentType='related' AND rid=:rid");
				  $s->execute([
				    ':rid'=>$rid
				  ]);
				  if($s->rowCount()==0){
				    $ss=$db->prepare("INSERT INTO `".$prefix."choices` (uid,rid,contentType,ti) VALUES (:id,:rid,'related',:ti)");
				    $ss->execute([
				      ':id'=>$id,
				      ':rid'=>$rid,
				      ':ti'=>time()
				    ]);
						$id=$db->lastInsertId();
						$e=$db->errorInfo();
						if(is_null($e[2])){
							$si=$db->prepare("SELECT id,contentType,title FROM `".$prefix."content` WHERE id=:id");
							$si->execute([':id'=>$rid]);
							$ri=$si->fetch(PDO::FETCH_ASSOC);?>
		window.top.window.$('#relateditems').append('<?php
echo'<div id="l_'.$id.'" class="form-group row">'.
		'<div class="input-group col-12">'.
			'<input type="text" class="form-control" value="'.ucfirst($ri['contentType']).': '.$ri['title'].'" readonly>'.
			'<div class="input-group-append">'.
				'<form target="sp" action="core/purge.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
				'</form>'.
			'</div>'.
		'</div>'.
	'</div>';?>
');
<?php   			}else{?>
		window.top.window.toastr["danger"]('There was an issue adding the Data!');
<?php   		}
			  	}else{?>
	window.top.window.toastr["warning"]('Item is already related!');
<?php			}
				}else{?>
	window.top.window.toastr["warning"]('You need to select in Item to Relate!');
<?php		}
			}
			break;
    case'add_subject':
      $sub=filter_input(INPUT_POST,'sub',FILTER_SANITIZE_STRING);
      $eml=filter_input(INPUT_POST,'eml',FILTER_SANITIZE_STRING);
      if($sub==''){?>
  window.top.window.toastr["danger"]('Not all Fields were filled in!');
<?php }else{
        $q=$db->prepare("INSERT INTO `".$prefix."choices` (contentType,title,url) VALUES ('subject',:title,:url)");
        $q->execute([
          ':title'=>kses($sub,array()),
          ':url'=>kses($eml,array())
				]);
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
  window.top.window.$('#subjects').append('<?php
echo'<div id="l_'.$id.'" class="form-group row">'.
			'<div class="input-group">'.
				'<div class="input-group-text">Subject</div>'.
				'<input id="sub'.$id.'" type="text" class="form-control" name="da" value="'.$sub.'">'.
				'<div class="input-group-text">Email</div>'.
				'<input id="eml'.$id.'" type="text" class="form-control" name="da" value="'.$eml.'">'.
				'<div class="input-group-append">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.toastr["danger"]('There was an issue adding the Data!');
<?php   }
      }
      break;
    case'make_client':
      $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
      $q=$db->prepare("SELECT name,email,phone FROM `".$prefix."messages` WHERE id=:id");
      $q->execute([':id'=>$id]);
      $r=$q->fetch(PDO::FETCH_ASSOC);
      $q=$db->prepare("INSERT INTO `".$prefix."login` (name,email,phone,ti) VALUES (:name,:email,:phone,:ti)");
      $q->execute([
        ':name'=>$r['name'],
        ':email'=>$r['email'],
        ':phone'=>$r['phone'],
        ':ti'=>$ti
      ]);
      $e=$db->errorInfo();
      if(is_null($e[2])){?>
  window.top.window.toastr["success"]('Contact added as Client');
<?php }else{?>
  window.top.window.toastr["danger"]('There was an issue adding the Data!');
<?php }
      break;
    case'add_comment':
      $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
      $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
      if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE email=:email");
        $q->execute([':email'=>$email]);
        $c=$q->fetch(PDO::FETCH_ASSOC);
        $cid=$c['id']!=0?$c['id']:0;
        $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
        $contentType=filter_input(INPUT_POST,'contentType',FILTER_SANITIZE_STRING);
        $da=filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING);
        $status='approved';
        $q=$db->prepare("INSERT INTO `".$prefix."comments` (contentType,rid,uid,cid,ip,name,email,notes,status,ti) VALUES (:contentType,:rid,:uid,:cid,:ip,:name,:email,:notes,:status,:ti)");
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
					$avatar='core'.DS.'images'.DS.'noavatar.jpg';
          if($c['avatar']!=''&&file_exists('..'.DS.'media'.DS.$c['avatar']))
						$avatar='media'.DS.'avatar'.DS.$c['avatar'];
          elseif($c['gravatar']!=''){
            if(stristr($c['gravatar'],'@'))
							$avatar='http://gravatar.com/avatar/'.md5($c['gravatar']);
            elseif(stristr($c['gravatar'],'gravatar.com/avatar/'))
							$avatar=$c['gravatar'];
					}?>
	  window.top.window.$('#comments').append('<?php
echo'<div id="l_'.$id.'" class="media animated zoomIn">'.
			'<div class="media-left img-rounded col-1" style="margin:10px 15px;">'.
				'<img class="media-object img-fluid" alt="User" src="'.$avatar.'">'.
			'</div>'.
			'<div class="media-body">'.
				'<div class="well">'.
					'<div id="controls-'.$id.'" class="btn-group btn-comments">'.
						'<button class="btn btn-default btn-sm trash" onclick="purge(`'.$id.'`,`comments`);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
					'</div>'.
					'<h6 class="media-heading">'.$name.'</h6>'.
					'<time><small>'.date($config['dateFormat'],$ti).'</small></time><br>'.
					$da.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.toastr["danger"]('There was an issue adding the Data!');
<?php   }
      }else{?>
  window.top.window.toastr["danger"]('The Email enter is not valid!');
<?php }
      break;
    case'add_avatar':
		case'add_tstavatar':
      $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
      $tbl=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
      $tbl=kses($tbl,array());
      $col=filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING);
      $col=kses($col,array());
      $exif='none';
      $fu=$_FILES['fu'];
      if(isset($_FILES['fu'])){
        $ft=$_FILES['fu']['type'];
        if($ft=="image/jpeg"||$ft=="image/pjpeg"||$ft=="image/png"||$ft=="image/gif"){
          $tp='..'.DS.'media'.DS.basename($_FILES['fu']['name']);
          if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
            if($ft=="image/jpeg"||$ft=="image/pjpeg")
							$fn=$col.'_'.$id.'.jpg';
            if($ft=="image/png")
							$fn=$col.'_'.$id.'.png';
            if($ft=="image/gif")
							$fn=$col.'_'.$id.'.gif';
						if($act=='add_tstavatar'){
							$fn='tst'.$fn;
							$q=$db->prepare("UPDATE `".$prefix."content` SET file=:avatar WHERE id=:id");
						}else
							$q=$db->prepare("UPDATE `".$prefix."login` SET avatar=:avatar WHERE id=:id");
						$q->execute([
							':avatar'=>'avatar'.$fn,
							':id'=>$id
						]);
            $image=new Zebra_image();
            $image->source_path=$tp;
            $image->target_path='..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn;
            $image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);
            rename($tp,'..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn);
						if($act=='add_tstavatar'){?>
	window.top.window.$('#tstavatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
<?php 			}else{?>
  window.top.window.$('.img-avatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
<?php 			}
					}
        }
      }
			break;
    case'add_media':
      $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
      $t=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
      $fu=filter_input(INPUT_POST,'fu',FILTER_SANITIZE_STRING);
      if($fu!=''){
        if($t=='pages'||$t=='content'){
          $q=$db->prepare("INSERT INTO `".$prefix."media` (rid,pid,file,ti) VALUES (0,:pid,:file,:ti)");
          $q->execute([
            ':pid'=>$id,
            ':file'=>$fu,
            ':ti'=>time()
          ]);
          $iid=$db->lastInsertId();
          $q=$db->prepare("UPDATE `".$prefix."media` SET ord=:ord WHERE id=:id");
          $q->execute([
            ':id'=>$iid,
            ':ord'=>$iid+1
          ]);?>
  window.top.window.$('#mi').append('<?php
echo'<div id="mi_'.$iid.'" class="media-gallery d-inline-block col-6 col-sm-2 position-relative p-0 m-1 mt-0 animated zoomIn">'.
			'<a class="card bg-dark m-0" href="'.$fu.'" data-lightbox="media">'.
				'<img class="card-img" src="'.$fu.'" alt="Media '.$iid.'">'.
			'</a>'.
			'<div class="btn-group float-right">'.
				'<div class="handle btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="Drag to ReOrder this item" aria-label="Drag to ReOrder this item">'.svg2('drag').'</div>'.
				'<button class="btn btn-secondary trash btn-sm" onclick="purge(`'.$iid.'`,`media`)" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
			'</div>'.
		'</div>';?>
');
	window.top.window.$('[data-lightbox="media"]').simpleLightbox();
<?php   }
      }
      break;
    case'add_orderitem':
      $oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
      $iid=filter_input(INPUT_GET,'iid',FILTER_SANITIZE_NUMBER_INT);
      if($iid!=0){
        $q=$db->prepare("SELECT title,cost FROM `".$prefix."content` WHERE id=:id");
        $q->execute([':id'=>$iid]);
        $r=$q->fetch(PDO::FETCH_ASSOC);
				if($r['cost']==''||!is_numeric($r['cost']))$r['cost']=0;
      }else{
        $r=[
          'title'=>'',
          'cost'=>0
        ];
      }
      $q=$db->prepare("INSERT INTO `".$prefix."orderitems` (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
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
      $q->execute([':oid'=>$oid]);?>
  window.top.window.$('#updateorder').html('<?php
      while($oi=$q->fetch(PDO::FETCH_ASSOC)){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
        $s->execute([':id'=>$oi['iid']]);
        $i=$s->fetch(PDO::FETCH_ASSOC);
        echo'<tr>'.
							'<td class="text-left">'.$i['code'].'<div class="visible-xs">'.$i['title'].'</div></td>'.
							'<td class="text-left hidden-xs">'.$i['title'].'</td>'.
							'<td class="col-md-1 text-center">'.($oi['iid']!=0?'<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'"></form>':'').'</td>'.
							'<td class="col-md-1 text-right">'.($oi['iid']!=0?'<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" name="da" value="'.$oi['cost'].'"></form>':'').'</td>'.
							'<td class="text-right">'.($oi['iid']!=0?$oi['cost']*$oi['quantity']:'').'</td>'.
							'<td class="text-right">'.
								'<form target="sp" action="core/update.php">'.
									'<input type="hidden" name="id" value="'.$oi['id'].'">'.
									'<input type="hidden" name="t" value="orderitems">'.
									'<input type="hidden" name="c" value="quantity">'.
									'<input type="hidden" name="da" value="0">'.
									'<button class="btn btn-default trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete">'.svg2('trash').'</button>'.
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
  ?>');
<?php break;
  }
}
echo'</script>';
