<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Live Chat
 * @package    core/layout/livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_livechat.php';
else{?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">chat</i></div>
          <div>Live Chat</div>
          <div class="content-title-actions">
            <?=$user['options'][7]==1?'<a class="btn" href="'.URL.$settings['system']['admin'].'/livechat/settings" role="button"  data-tooltip="tooltip" aria-label="Live Chat Settings"><i class="i">settings</i></a>':'';?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Live Chat</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 p-3">
        <div class="row chat">
          <input id="chatactive" type="hidden" value="0">
          <div class="chatList card col-12 col-md-4" id="chatList">
            <?php $s=$db->prepare("SELECT * FROM `".$prefix."livechat` WHERE `who`!='admin' GROUP BY `sid` ORDER BY `ti` ASC");
            $s->execute();
            while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <span class="chatListItem list-group-item list-group-item-action border-top-0 border-right-0 border-left-0 border-bottom" id="l_<?=$r['id'];?>" data-sid="<?=$r['sid'];?>" data-chatname="<?=$r['name'];?>" data-chatemail="<?=$r['email'];?>">
                <span class="btn-group float-right">
                  <?php $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                  $scc->execute([':ip'=>$r['ip']]);
                  if($scc->rowCount()<1){?>
                    <form id="blacklist<?=$r['id'];?>" target="sp" method="post" action="core/add_blacklist.php">
                      <input name="id" type="hidden" value="<?=$r['id'];?>">
                      <input name="t" type="hidden" value="livechat">
                      <input name="r" type="hidden" value="Added Manually via Live Chat">
                      <button  data-tooltip="tooltip" aria-label="Add to Blacklist"><i class="i">security</i></button>
                    </form>
                  <?php } ?>
                  <form target="sp" method="get" action="core/purge.php">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="livechat">
                    <input name="c" type="hidden" value="<?=$r['sid'];?>">
                    <button class="trash"  data-tooltip="tooltip" aria-label="Delete" onclick="javascript:clearTimeout(chatTimer);"><i class="i">trash</i></button>
                  </form>
                </span>
                <small><?=$r['name'];?></small><br>
                <small><?=$r['email'];?></small><br>
                <small><small><?= date($config['dateFormat'],$r['ti']);?></small></small>
                <?=$r['status']=='unseen'?'<span class="btn-group float-right"><small class="badger badge-danger">Unread</small></span>':'<span class="btn-group float-right"><small class="badger badge-success">Read</small></span>';?>
              </span>
            <?php }?>
          </div>
          <div class="col-12 col-md-8">
            <div class="card chatBody">
              <div class="card-header" id="chatTitle">&nbsp;</div>
              <div class="card-body p-0" id="chatBody">
                <input id="chatsid" type="hidden" value="">
                <input id="chatwho" type="hidden" value="admin">
                <input id="chataid" type="hidden" value="<?=$user['id'];?>">
                <input id="chatemail" type="hidden" value="<?=$user['email'];?>">
                <input id="chatname" type="hidden" value="<?= $user['name']!=''?$user['name']:$user['username'];?>">
                <div class="card-content" style="height:54vh;" id="chatScreen" data-empty="Select a Message Thread on the left!"></div>
              </div>
              <div class="card-footer p-0 border-0">
                <div class="form-row">
                  <input id="chatmessage" type="text">
                  <button id="chatButton"> Send </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<script>
  function updateChat(seen){
    chatTimer=null;
    $.ajax({
      type:"POST",
      url:"core/chat.php",
      data:{
        sid:$('#chatsid').val(),
        seen:seen
      }
    }).done(function(data){
      if(data!='none'){
        $("#chatScreen").html(data);
        document.getElementById('chatScreen').scrollTop=9999999;
      }
    });
    clearTimeout(chatTimer);
    chatTimer=setTimeout(function(){
      updateChat();
    },2500);
  }
  function updateChatList(){
    chatListTimer=null;
    $.ajax({
      type:"POST",
      url:"core/chatlist.php",
      data:{
        sid:$('#chatactive').val()
      }
    }).done(function(data){
      if(data!='none'){
        $("#chatList").html(data);
      }
    });
    clearTimeout(chatListTimer);
    chatListTimer=setTimeout(function(){
      updateChatList();
    },2500);
  }
  $(document).ready(function(){
    updateChatList();
    $(".chatListItem").click(function(e){
      $('#chatsid').val($(this).data('sid'));
      $('#chatactive').val($(this).data('sid'));
      $('#chatTitle').html('Chat with <span id="chatTitleName">'+$(this).data('chatname')+'</span> <small id="chatTitleEmail"><a href="mailto:'+$(this).data('chatemail')+'">&lt;'+$(this).data('chatemail')+'&gt;</a></small>');
      $(".chatListItem").removeClass('active');
      $(this).addClass('active');
      updateChat('seen');
    });
    $("#chatButton").click(function(){
      $.ajax({
        type:"POST",
        url:"core/chat.php",
        data:{
          aid:$('#chataid').val(),
          sid:$('#chatsid').val(),
          who:$('#chatwho').val(),
          name:$('#chatname').val(),
          email:$('#chatemail').val(),
          message:$("#chatmessage").val()
        }
      }).done(function(data){
        $("#chatScreen").html(data);
        document.getElementById('chatScreen').scrollTop=9999999;
        $("#chatmessage").val("");
        updateChat('seen');
      });
    });
  });
</script>
<?php }
