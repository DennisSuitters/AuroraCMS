<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add FAQ Item
 * @package    core/add_faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT `email`,`business`,`dateFormat` FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$u=isset($_POST['u'])?filter_input(INPUT_POST,'u',FILTER_SANITIZE_NUMBER_INT):0;
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):'';
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$ti=time();
if($u!=0||$da!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."suggestions` (`rid`,`uid`,`notes`,`popup`,`seen`,`ti`) VALUES (:rid,:uid,:da,1,0,:ti)");
  $s->execute([
    ':rid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0,
    ':uid'=>(int)$u,
    ':da'=>$da,
    ':ti'=>$ti
  ]);
  $id=$db->lastInsertId();
  $tu=$db->prepare("SELECT `id`,`email`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $tu->execute([
    ':id'=>(int)$u
  ]);
  $rt=$tu->fetch(PDO::FETCH_ASSOC);
  $fu=$db->prepare("SELECT `id`,`email`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $fu->execute([
    ':id'=>isset($_SESSION['uid'])?$_SESSION['uid']:0
  ]);
  $rf=$fu->fetch(PDO::FETCH_ASSOC);
  if($rt['email']!=''){
    require'phpmailer/class.phpmailer.php';
    $mail=new PHPMailer;
    $mail->isSendmail();
    $toname=$c['name'];
    $mail->SetFrom($config['email'],$config['business']);
    $mail->AddAddress($rt['email']);
    $mail->IsHTML(true);
    $mail->Subject='New Administration Message via '.($config['business']=''?'AuroraCMS':$config['business']);
    $name=explode(" ",$rt['name']);
    $mail->Body='Hello '.($name[0]==''?$rf['username']:$name[0]).', <br>A new message is available to be read when logging in to the Administration of the '.($config['business']==''?'AuroraCMS':$config['business']).' Website.';
    $mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
    if($mail->Send()){
      echo'<script>window.top.window.toastr["success"](`Notification Email was sent to '.$rt['email'].'`);</script>';
    }else{
      echo'<script>window.top.window.toastr["error"](`The was an issue sending a Notification Email to '.$rt['email'].'`);</script>';
    }
  }
	echo'<script>'.
				'window.top.window.$("#suggestions").prepend(`'.
					'<div id="l_'.$id.'">'.
						'<div class="row">'.
              '<h6 class="m-0 p-0">To: '.$rt['username'].($rt['name']!=''?':'.$rt['name']:'').' - From: '.$rf['username'].($rf['name']!=''?':'.$rf['name']:'').'</h6>'.
							'<details class="m-0">'.
								'<summary>'.
									'Created on '.date($config['dateFormat'],$ti).' and has <strong>NOT</strong> been seen.'.
									'<form class="float-right" target="sp" action="core/purge.php">'.
										'<input name="id" type="hidden" value="'.$id.'">'.
										'<input name="t" type="hidden" value="suggestions">'.
										'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 5.4999377,5.7501979 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795074,0.0705 H 4.7499064 q -0.1095045,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 h 0.5000209 q 0.1095045,0 0.1795074,0.070503 0.070003,0.070503 0.070503,0.1795075 z m 2.0000833,0 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795075,0.0705 H 6.7499898 q -0.1095046,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 h 0.5000208 q 0.1095046,0 0.1795075,0.070503 0.070003,0.070503 0.070503,0.1795075 z m 2.0000833,0 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795075,0.0705 H 8.7500731 q -0.1095046,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 H 9.250094 q 0.1095046,0 0.1795075,0.070503 0.070003,0.070503 0.070503,0.1795075 z M 10.500146,11.406934 V 4.000625 H 3.4998543 v 7.406309 q 0,0.172007 0.054502,0.316513 0.054502,0.144506 0.1135047,0.211009 0.059003,0.0665 0.082004,0.0665 h 6.500271 q 0.0235,0 0.082,-0.0665 0.0585,-0.0665 0.113504,-0.211009 0.055,-0.144506 0.0545,-0.316513 z M 5.2499273,3.0000833 H 8.7500731 L 8.3750575,2.0860453 Q 8.3205552,2.0155423 8.2420519,2.0000417 H 5.7654487 q -0.078003,0.015501 -0.1330055,0.086004 z m 7.2503017,0.2500105 v 0.5000208 q 0,0.1095046 -0.0705,0.1795075 -0.0705,0.070003 -0.179507,0.070503 h -0.750031 v 7.4063089 q 0,0.648527 -0.367016,1.121046 Q 10.766157,13 10.250136,13 H 3.7498648 Q 3.2343433,13 2.866828,12.542981 2.4993126,12.085962 2.4998127,11.437435 V 3.999625 H 1.7497814 q -0.1095046,0 -0.1795075,-0.070503 Q 1.500271,3.8586191 1.499771,3.7496146 V 3.2495937 q 0,-0.1095045 0.070503,-0.1795074 0.070503,-0.070003 0.1795075,-0.070503 H 4.163882 L 4.7109048,1.695029 Q 4.8279097,1.4060169 5.1329224,1.2030085 5.4379351,1 5.7499481,1 H 8.2500523 Q 8.5625653,1 8.867078,1.2030085 9.1715907,1.4060169 9.2890956,1.695029 l 0.5470227,1.3045543 h 2.4141007 q 0.109504,0 0.179507,0.070503 0.07,0.070503 0.0705,0.1795074 z"/></svg></i></button>'.
									'</form>'.
								'</summary>'.
								'<p>'.$da.'</p>'.
							'</details>'.
						'</div>'.
						'<hr>'.
					'</div>'.
				'`);'.
				'window.top.window.toastr["success"]("Suggestion added!");'.
			'</script>';
}else{
  if($u==0&&$da==''){
    echo'<script>window.top.window.toastr["error"]("No User was Selected or Suggestion Text was entered!");</script>';
  }else{
    if($u==0)echo'<script>window.top.window.toastr["error"]("No User was entered!");</script>';
    if($da=='')echo'<script>window.top.window.toastr["error"]("No Suggestion Text was entered!");</script>';
  }
}
