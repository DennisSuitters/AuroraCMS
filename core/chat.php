<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Chat - Chat interaction script
 * @package    core/chat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
include'class.projecthoneypot.php';
include'class.spamfilter.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$ti=time();
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if($config['chatAutoRemove']!=0){
	$s=$db->prepare("DELETE FROM `".$prefix."livechat` WHERE ti < :ti");
	$s->execute([':ti'=>$ti - $config['chatAutoRemove']]);
}
define('THEME','layout'.DS.$config['theme']);
if(file_exists(THEME.DS.'images'.DS.'noavatar.png'))
	define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.png');
elseif(file_exists(THEME.DS.'images'.DS.'noavatar.gif'))
	define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.gif');
elseif(file_exists(THEME.DS.'images'.DS.'noavatar.jpg'))
	define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.jpg');
else
	define('NOAVATAR','core'.DS.'images'.DS.'i-noavatar.svg');
define('ADMINNOAVATAR','core'.DS.'images'.DS.'i-noavatar.svg');
$aid=isset($_POST['aid'])?$_POST['aid']:0;
$sid=isset($_POST['sid'])?$_POST['sid']:0;
$who=isset($_POST['who'])?$_POST['who']:'none';
$name=isset($_POST['name'])?$_POST['name']:'';
$email=isset($_POST['email'])?$_POST['email']:'';
$message=isset($_POST['message'])?$_POST['message']:'';
$ip=$who=='page'?$_SERVER['REMOTE_ADDR']:'admin';
$ua=$who=='page'?$_SERVER['HTTP_USER_AGENT']:'admin';
$spam=FALSE;
$blacklisted='';
if($message != "" && $message != "|*|*|*|*|*|"){
	$q=$db->prepare("SELECT id FROM `".$prefix."livechat` WHERE who='admin' AND notes=:notes");
	$q->execute([':notes'=>'Hello, how can we assist you?']);
	if($q->rowCount()==0){
		if($who=='page'){
			if($config['spamfilter']{0}==1&&$spam==FALSE&&$ip!='admin'){
				$filter=new SpamFilter();
				$result=$filter->check_text($name.' '.$message);
				if($result){
					$blacklisted=$theme['settings']['blacklist'];
					$spam=TRUE;
					if($config['spamfilter']{1}==1){
						$sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
						$sc->execute([':ip'=>$ip]);
						if($sc->rowCount()<1){
							$s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,reason,ti) VALUES (:ip,:oti,:reason,:ti)");
							$s->execute([
								':ip'=>$ip,
								':oti'=>$ti,
								':reason'=>'Spam detected from Live Chat Input',
								':ti'=>$ti
							]);
						}
						echo$blacklisted;
					}
				}
			}
		}
		if($spam==FALSE){
		  $s=$db->prepare("INSERT INTO `".$prefix."livechat` (aid,sid,who,name,email,notes,ip,user_agent,ti) VALUES (:aid,:sid,:who,:name,:email,:notes,:ip,:ua,:ti)");
		  $s->execute([
		    ':aid'=>$aid,
		    ':sid'=>$sid,
		    ':who'=>$who,
		    ':name'=>$name,
		    ':email'=>$email,
		    ':notes'=>$message,
		    ':ip'=>$ip,
		    ':ua'=>$ua,
		    ':ti'=>$ti
		  ]);
		}
	}
}
if($message == "|*|*|*|*|*|"){
	if($config['php_options']{3}==1&&$config['php_APIkey']!=''&&$ip!='admin'){
		$h=new ProjectHoneyPot($ip,$config['php_APIkey']);
		if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1){
			$blacklisted=$theme['settings']['blacklist'];
			$spam=TRUE;
			$sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
			$sc->execute([':ip'=>$ip]);
			if($sc->rowCount()<1){
				$s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,reason,ti) VALUES (:ip,:oti,:reason,:ti)");
				$s->execute([
					':ip'=>$ip,
					':oti'=>$ti,
					':reason'=>'Live Chat found Blacklisted IP (PHP)',
					':ti'=>$ti
				]);
			}
			echo$blacklisted;
		}
	}
	if($config['spamfilter']{0}==1&&$spam==FALSE&&$ip!='admin'){
		$filter=new SpamFilter();
		$result=$filter->check_email($email);
		if($result){
			$blacklisted=$theme['settings']['blacklist'];
			$spam=TRUE;
			$sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
			$sc->execute([':ip'=>$ip]);
			if($sc->rowCount()<1){
				$s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,reason,ti) VALUES (:ip,:oti,:reason,:ti)");
				$s->execute([
					':ip'=>$ip,
					':oti'=>$ti,
					':reason'=>'Live Chat found Bad Email',
					':ti'=>$ti
				]);
			}
			echo$blacklisted;
		}
	}
	if($spam==FALSE){
		$cuati=time()-1440;
		$cua=$db->prepare("SELECT id FROM `".$prefix."login` WHERE rank>699 AND active=1 AND lti>:lti");
		$cua->execute([':lti'=>$cuati]);
		if($cua->rowCount()<1){
			echo'<ul>'.
						'<li class="admin">'.
							'<p>'.
								'There is currently not anyone available to answer your queries, however you may leave a message here so a representative can back to you.'.
							'</p>'.
						'</li>'.
					'</ul>';
		}else{
			if($message != ''){
				$s=$db->prepare("SELECT sid FROM `".$prefix."livechat` WHERE sid=:sid");
				$s->execute([':sid'=>$sid]);
				if($s->rowCount()<1){
					echo'available';
				}
			}
		}
	}
}
if($spam==FALSE){
	$s=$db->prepare("SELECT * FROM `".$prefix."livechat` WHERE sid=:sid ORDER BY ti ASC");
	$s->execute([':sid'=>$sid]);
	if($s->rowCount()>0){
	  while($r=$s->fetch(PDO::FETCH_ASSOC)){
			if($r['who']!='admin'){
				$scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
	      $scc->execute([':ip'=>$r['ip']]);
	      if($scc->rowCount()>0)header('Location:'.$_SERVER['PHP_SELF']);
			}
	    if($r['notes']=='|*|*|*|*|*|')continue;
	    echo'<ul>'.
	      		'<li class="'.$r['who'].'">';
	    if($r['aid']!=0){
	      $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:aid");
	      $su->execute([':aid'=>$r['aid']]);
	      $ru=$su->fetch(PDO::FETCH_ASSOC);
		        	echo'<img class="bg-white" src="';
				if($ru['avatar']!='')
			        echo'media'.DS.'avatar'.DS.basename($ru['avatar']);
	      elseif($ru['gravatar']!=''){
	        if(stristr($ru['gravatar'],'@'))
		          echo'http://gravatar.com/avatar/'.md5($ru['gravatar']);
	        elseif(stristr($ru['gravatar'],'gravatar.com/avatar/'))
		          echo$ru['gravatar'];
	        else
		          echo ADMINNOAVATAR;
	      }else
			        echo ADMINNOAVATAR;
						echo'"/>';
	    }else
		        echo'<img class="bg-white" src="'.NOAVATAR.'"/>';
		        echo'<p>'.
		          		'<small class="d-block">'.$r['name'].' <small>'.date($config['dateFormat'],$r['ti']).'</small></small>'.
			          		$r['notes'].
		        		'</p>'.
		      		'</li>'.
		    		'</ul>';
	  }
	}
}
