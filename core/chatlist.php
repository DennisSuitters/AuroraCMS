<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Chat List - Chat List Update
 * @package    core/chatlist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('..'.DS.'core'.DS.'images'.DS.'i-'.$svg.'.svg').'</i>';
}
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$sid=$_POST['sid'];
$s=$db->prepare("SELECT * FROM `".$prefix."livechat` WHERE `who`!='admin' GROUP BY `sid` ORDER BY `ti` ASC");
$s->execute();
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<span class="chatListItem list-group-item list-group-item-action border-top-0 border-right-0 border-left-0 border-bottom" id="l_'.$r['id'].'" data-sid="'.$r['sid'].'" data-chatname="'.$r['name'].'" data-chatemail="'.$r['email'].'"><span class="btn-group float-right">';
		$scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
		$scc->execute([
			':ip'=>$r['ip']
		]);
		if($scc->rowCount()<1){
    	echo'<form id="blacklist'.$r['id'].'" target="sp" method="post" action="core/add_blacklist.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="livechat"><input name="r" type="hidden" value="Added Manually via Live Chat"><button data-tooltip="tooltip" aria-label="Add to Blacklist">'.svg2('security').'</button></form>';
		}
  	echo'<form target="sp" method="get" action="core/purge.php"><input name="id" type="hidden" value="'.$r['id'].'"><input name="t" type="hidden" value="livechat"><input name="c" type="hidden" value="'.$r['sid'].'"><button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="javascript:clearTimeout(chatTimer);">'.svg2('trash').'</button></form></span><small>'.$r['name'].'</small><br><small>'.$r['email'].'</small><br><small><small>'.date($config['dateFormat'],$r['ti']).'</small></small>'.($r['status']=='unseen'?'<span class="btn-group float-right"><small class="badger badge-danger">Unread</small></span>':'<span class="btn-group float-right"><small class="badger badge-success">Read</small></span>').'</span>';
  }
}?>
<script>
$(".chatListItem").removeClass('active');
$('[data-sid="<?php echo$sid;?>"]').addClass('active');
$(".chatListItem").click(function(e){
  $('#chatsid').val($(this).data('sid'));
  $('#chatactive').val($(this).data('sid'));
  $('#chatTitle').html('Chat with <span id="chatTitleName">'+$(this).data('chatname')+'</span> <small id="chatTitleEmail"><a href="mailto:'+$(this).data('chatemail')+'">&lt;'+$(this).data('chatemail')+'&gt;</a></small>');
  $(".chatListItem").removeClass('active');
  $(this).addClass('active');
  updateChat('seen');
});
</script>
