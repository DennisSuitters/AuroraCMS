<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Get Email Messages
 * @package    core/get_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
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
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
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
								'<button data-tooltip="tooltip" aria-label="Add to Whitelist"><i class="i">whitelist</i></button>'.
							'</form>';
		}
  	$scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
    $scc->execute([':ip'=>$r['ip']]);
    if($scc->rowCount()<1){
		  		echo'<form id="blacklist'.$r['id'].'" target="sp" method="post" action="core/add_messageblacklist.php" style="display:inline-block;">'.
								'<input name="id" type="hidden" value="'.$r['id'].'">';
								'<button data-tooltip="tooltip" aria-label="Add to Blacklist"><i class="i">email-spam</i></button>'.
							'</form>';
		}
					echo'<form target="sp" method="post" action="core/purge.php">'.
								'<input name="id" type="hidden" value="'.$r['id'].'">'.
								'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$r['id'].'`,`messages`);"><i class="i">purge</i></button>'.
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
