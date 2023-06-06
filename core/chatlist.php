<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Chat List - Chat List Update
 * @package    core/chatlist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$sid=$_POST['sid'];
$s=$db->prepare("SELECT * FROM `".$prefix."livechat` WHERE `who`!='admin' GROUP BY `sid` ORDER BY `ti` ASC");
$s->execute();
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<span class="chatListItem list-group-item list-group-item-action border-top-0 border-right-0 border-left-0 border-bottom" id="l_'.$r['id'].'" data-sid="'.$r['sid'].'" data-chatname="'.$r['name'].'" data-chatemail="'.$r['email'].'" data-content="'.$r['name'].' '.$r['email'].'"><span class="btn-group float-right">';
		$scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
		$scc->execute([':ip'=>$r['ip']]);
		if($scc->rowCount()<1)echo'<form id="blacklist'.$r['id'].'" target="sp" method="post" action="core/add_blacklist.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="livechat"><input name="r" type="hidden" value="Added Manually via Live Chat"><button data-tooltip="tooltip" aria-label="Add to Blacklist"><i class="i">security</i></button></form>';
  	echo'<form target="sp" method="get" action="core/purge.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="livechat"><input name="c" type="hidden" value="'.$r['sid'].'"><button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="javascript:clearTimeout(chatTimer);"><i class="i">trash</i></button></form></span><small>'.$r['name'].'</small><br><small>'.$r['email'].'</small><br><small><small>'.date($config['dateFormat'],$r['ti']).'</small></small>'.($r['status']=='unseen'?'<span class="btn-group float-right"><small class="badger badge-danger">Unread</small></span>':'<span class="btn-group float-right"><small class="badger badge-success">Read</small></span>').'</span>';
  }
}
echo'<script>'.
	'$(".chatListItem").removeClass("active");'.
	'$(`[data-sid="'.$sid.'"]`).addClass("active");'.
	'$(".chatListItem").click(function(e){'.
  	'$("#chatsid").val($(this).data("sid"));'.
  	'$("#chatactive").val($(this).data("sid"));'.
  	'$("#chatTitle").html(`Chat with <span id="chatTitleName">`+$(this).data("chatname")+`</span> <small id="chatTitleEmail"><a href="mailto:`+$(this).data("chatemail")+`">&lt;`+$(this).data("chatemail")+`&gt;</a></small>`);'.
  	'$(".chatListItem").removeClass("active");'.
  	'$(this).addClass("active");'.
  	'updateChat("seen");'.
	'});'.
  'filterTextInput2();'.
'</script>';
