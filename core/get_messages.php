<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Get Email Messages
 * @package    core/get_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Tidy up code and reduce footprint.
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$uid=$_SESSION['uid'];
$su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
$su->execute([':uid'=>$uid]);
$user=$su->fetch(PDO::FETCH_ASSOC);
$mhtml=$blacklisted='';
require'imapreader/Email.php';
require'imapreader/EmailAttachment.php';
require'imapreader/Reader.php';
require'spamfilter/class.spamfilter.php';
function strip_html_tags($t,$l=400){
  $t=preg_replace([
    '@<head[^>]*?>.*?</head>@siu',
    '@<style[^>]*?>.*?</style>@siu',
    '@<script[^>]*?.*?</script>@siu',
    '@<object[^>]*?.*?</object>@siu',
    '@<embed[^>]*?.*?</embed>@siu',
    '@<applet[^>]*?.*?</applet>@siu',
    '@<noframes[^>]*?.*?</noframes>@siu',
    '@<noscript[^>]*?.*?</noscript>@siu',
    '@<noembed[^>]*?.*?</noembed>@siu',
    '@</?((address)|(blockquote)|(center)|(del))@iu',
    '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
    '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
    '@</?((table)|(th)|(td)|(caption))@iu',
    '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
    '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
    '@</?((frameset)|(frame)|(iframe))@iu',
  ],[
    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
    "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
    "\n\$0", "\n\$0",
  ],$t);
  $t=strip_tags($t);
  $t=trim(preg_replace('/[\t\n\r\s]+/',' ',$t));
  return substr($t,0,$l);
}
$theme=parse_ini_file('../layout/'.$config['theme'].'/theme.ini',true);
$folder='INBOX';
$status='unread';
$tis=time();
if($config['message_check_interval']!=0){
  $sm=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `uid`=:uid AND `contentType`='mailbox' AND `ti`<:ti ORDER BY `url` ASC");
  $sm->execute([
    ':uid'=>$user['id'],
    ':ti'=>time()-$config['message_check_interval']
  ]);
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
    try{
      $ss=$db->prepare("UPDATE `".$prefix."choices` SET `ti`=:ti WHERE `id`=:id");
      $ss->execute([
				':id'=>$rm['id'],
				':ti'=>time()
			]);
      $imap=new Reader('{'.$rm['url'].':'.$rm['port'].'/'.$rm['flag'].'}', $rm['username'], $rm['password'], '../media/email/');
      if($rm['ti']==0)$imap->all()->get();
      else$imap->limit(10)->unread()->get();
      foreach($imap->emails() as$email){
        $folder='INBOX';
        $status='unread';
        if($config['spamfilter'][0]==1){
          $filter=new SpamFilter();
          $result=$filter->check_email($email->fromEmail());
          if($result)$folder='spam';
          $result=$filter->check_text($email->subject().' '.($email->html()!=''?$email->html():$email->plain()));
          if($result)$folder='spam';
        }
        $attachments='';
        if($email->hasAttachments()){
          foreach($email->attachments() as$attachment)$attachments.=($attachments!=''?',':'').$attachment->filePath();
        }
        if($email->isAnswered())$status='read';
        if($email->isDeleted())$status='trash';
				$emailHTML=$email->html()!=''?$email->html():$email->plain();
				if(is_base64_string($emailHTML))$emailHTML=base64_decode($emailHTML);
        $s=$db->prepare("INSERT IGNORE INTO `".$prefix."messages` (`mid`,`folder`,`to_email`,`to_name`,`from_email`,`subject`,`status`,`notes_html`,`attachments`,`email_date`,`size`,`ti`) VALUES (:mid,:folder,:to_email,:to_name,:from_email,:subject,:status,:notes_html,:attachments,:email_date,:size,:ti)");
        $s->execute([
          ':mid'=>$email->id(),
          ':folder'=>$folder,
          ':to_email'=>stristr($rm['username'],'@')?$rm['username']:$rm['url'],
          ':to_name'=>$user['name'],
          ':from_email'=>$email->fromEmail(),
          ':subject'=>$email->subject(),
          ':status'=>$status,
          ':notes_html'=>$emailHTML,
          ':attachments'=>$attachments,
          ':email_date'=>strtotime($email->date()),
          ':size'=>$email->size(),
          ':ti'=>time()
        ]);
        if($user['options'][9]==1)$imap->deleteEmail($email->id());
      }
    }catch(Exception $e){
			echo'<script>window.top.window.$("#allmessages").html(`<div class="alert alert-danger">'.$e->getMessage().'</div>`);</script>';
		}
  }
	$fol=isset($_GET['folder'])?$_GET['folder']:'INBOX';
  $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `folder`=:folder AND `ti`>:tis ORDER BY `ti` DESC, `subject` ASC");
  $s->execute([
		':tis'=>$tis,
		':folder'=>$fol
	]);
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<li id="l_'.$r['id'].'" class="message animated fadeIn unread">'.
					'<div class="actions">'.
						'<div class="btn-group-vertical">';
      $scc=$db->prepare("SELECT `email` FROM `".$prefix."whitelist` WHERE `email`=:email");
      $scc->execute([':email'=>$r['from_email']]);
      if($scc->rowCount()<1){
		  		echo'<form id="whitelist'.$r['id'].'" target="sp" method="post" action="core/add_messagewhitelist.php">'.
								'<input name="id" type="hidden" value="'.$r['id'].'">'.
								'<button data-tooltip="tooltip" aria-label="Add to Whitelist"><i class="i"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="M 1.8659929,3.0963517 C 4.8143266,1.3677616 6.9839148,0.99927167 6.9839148,0.99927167 c 0,0 0.0023,3.5e-4 0.0055,9.6003e-4 0.0033,-6.1003e-4 0.0055,-9.6003e-4 0.0055,-9.6003e-4 0,0 -0.011,12.00000033 0,12.00000033 -0.0019,-3.5e-4 -0.0036,-9.6e-4 -0.0055,-10e-4 -0.0019,3.5e-4 -0.0036,9.6e-4 -0.0055,10e-4 C 1.4751699,11.823072 1.8659929,3.0963517 1.8659929,3.0963517 Z M 6.9835418,1.7402516 c -0.4826472,0.10437 -2.1774312,0.53826 -4.3878043,1.7781601 0.0096,1.61164 0.285353,7.7100603 4.3878043,8.7349403 l 0,-10.5131004 z M 12.123424,3.09708 C 9.1750899,1.36849 7.0055019,1 7.0055019,1 c 0,0 -0.0023,3.5e-4 -0.0055,9.6e-4 C 6.9967019,1.00035 6.9945019,1 6.9945019,1 c 0,0 0.011,12 0,12 0.0019,-3.5e-4 0.0036,-9.6e-4 0.0055,-10e-4 0.0019,3.5e-4 0.0036,9.6e-4 0.0055,10e-4 C 12.514247,11.8238 12.123424,3.09708 12.123424,3.09708 Z M 7.0058749,1.74098 c 0.482647,0.10437 2.177431,0.53826 4.3878041,1.77816 -0.0096,1.61164 -0.285353,7.71006 -4.3878041,8.73494 l 0,-10.5131 z"/></svg></i></button>'.
							'</form>';
		}
  	$scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
    $scc->execute([':ip'=>$r['ip']]);
    if($scc->rowCount()<1){
		  		echo'<form id="blacklist'.$r['id'].'" target="sp" method="post" action="core/add_messageblacklist.php" style="display:inline-block;">'.
								'<input name="id" type="hidden" value="'.$r['id'].'">';
								'<button data-tooltip="tooltip" aria-label="Add to Blacklist"><i class="i"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="M 12.123424,3.09708 C 9.1750899,1.36849 7.0055019,1 7.0055019,1 c 0,0 -0.0023,3.5e-4 -0.0055,9.6e-4 C 6.9967019,1.00035 6.9945019,1 6.9945019,1 c 0,0 -2.169706,0.36849 -5.117921,2.09708 0,0 -0.390942,8.72672 5.117921,9.90292 0.0019,-3.5e-4 0.0036,-9.6e-4 0.0055,-10e-4 0.0019,3.5e-4 0.0036,9.6e-4 0.0055,10e-4 C 12.514247,11.8238 12.123424,3.09708 12.123424,3.09708 Z M 7.0058749,1.74098 c 0.482647,0.10437 2.177431,0.53826 4.3878041,1.77816 -0.0096,1.61164 -0.285353,7.71006 -4.3878041,8.73494 l 0,-10.5131 0,0 z"/></svg></i></button>'.
							'</form>';
		}
					echo'<form target="sp" method="post" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$r['id'].'">'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$r['id'].'`,`messages`);"><i class="i"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 5.4999377,5.7501979 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795074,0.0705 H 4.7499064 q -0.1095045,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 h 0.5000209 q 0.1095045,0 0.1795074,0.070503 0.070003,0.070503 0.070503,0.1795075 z m 2.0000833,0 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795075,0.0705 H 6.7499898 q -0.1095046,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 h 0.5000208 q 0.1095046,0 0.1795075,0.070503 0.070003,0.070503 0.070503,0.1795075 z m 2.0000833,0 v 4.5001871 q 0,0.109505 -0.070503,0.179508 -0.070503,0.07 -0.1795075,0.0705 H 8.7500731 q -0.1095046,0 -0.1795075,-0.0705 -0.070003,-0.0705 -0.070503,-0.179508 V 5.7501979 q 0,-0.1095045 0.070503,-0.1795075 0.070503,-0.070003 0.1795075,-0.070503 H 9.250094 q 0.1095046,0 0.1795075,0.070503 0.070003,0.070503 0.070503,0.1795075 z M 10.500146,11.406934 V 4.000625 H 3.4998543 v 7.406309 q 0,0.172007 0.054502,0.316513 0.054502,0.144506 0.1135047,0.211009 0.059003,0.0665 0.082004,0.0665 h 6.500271 q 0.0235,0 0.082,-0.0665 0.0585,-0.0665 0.113504,-0.211009 0.055,-0.144506 0.0545,-0.316513 z M 5.2499273,3.0000833 H 8.7500731 L 8.3750575,2.0860453 Q 8.3205552,2.0155423 8.2420519,2.0000417 H 5.7654487 q -0.078003,0.015501 -0.1330055,0.086004 z m 7.2503017,0.2500105 v 0.5000208 q 0,0.1095046 -0.0705,0.1795075 -0.0705,0.070003 -0.179507,0.070503 h -0.750031 v 7.4063089 q 0,0.648527 -0.367016,1.121046 Q 10.766157,13 10.250136,13 H 3.7498648 Q 3.2343433,13 2.866828,12.542981 2.4993126,12.085962 2.4998127,11.437435 V 3.999625 H 1.7497814 q -0.1095046,0 -0.1795075,-0.070503 Q 1.500271,3.8586191 1.499771,3.7496146 V 3.2495937 q 0,-0.1095045 0.070503,-0.1795074 0.070503,-0.070003 0.1795075,-0.070503 H 4.163882 L 4.7109048,1.695029 Q 4.8279097,1.4060169 5.1329224,1.2030085 5.4379351,1 5.7499481,1 H 8.2500523 Q 8.5625653,1 8.867078,1.2030085 9.1715907,1.4060169 9.2890956,1.695029 l 0.5470227,1.3045543 h 2.4141007 q 0.109504,0 0.179507,0.070503 0.07,0.070503 0.0705,0.1795074 z"/></svg></i></button>'.
							'</form>'.
						'</div>'.
					'</div>'.
					'<a href="'.URL.$settings['system']['admin'].'/messages/view/'.$r['id'].'">'.
						'<span class="header">'.
							'<span class="to">To: '.($r['to_name']!=''?$r['to_name'].'<small> &lt;'.$r['to_email'].'&gt;</small>':'&lt;'.$r['to_email'].'&gt;').'</span>'.
							'<span class="date">'.date('M j \a\t G:i',$r['ti']).'</span>'.
						'</span>'.
						'<span class="header">'.
							'<span class="form">From: '.($r['from_name']!=''?$r['from_name'].'<small> &lt;'.$r['from_email'].'&gt;</small>':'&lt;'.$r['from_email'].'&gt;').'</span>'.
						'</span>'.
						'<span class="title d-block">'.$r['subject'].'</span>'.
						'<span class="description d-block text-wrap">'.strip_html_tags($r['notes_html']).'</span>'.
					'</a>'.
				'</li>';
		$ur=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."messages` WHERE `status`='unread' AND `folder`='INBOX'")->fetch(PDO::FETCH_ASSOC);
		$sp=$db->query("SELECT COUNT(`folder`) AS cnt FROM `".$prefix."messages` WHERE `folder`='spam' AND `status`='unread'")->fetch(PDO::FETCH_ASSOC);
		echo'<script>';
			if($ur['cnt']>0)echo'$(`#unreadbadge`).html("'.$ur['cnt'].'");';
			if($sp['cnt']>0)echo'$(`#spambadge`).html("'.$sp['cnt'].'");';
		echo'</script>';
  }
}
function is_base64_string($s){
  if(($b=base64_decode($s,true))===false)return false;
  $e=mb_detect_encoding($b);
  if(in_array($e, array('UTF-8','ASCII')))return true;else return false;
}
