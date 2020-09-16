<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Live Chat
 * @package    core/layout/livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.6 Add Read Status.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_livechat.php';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Live Chat</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="row chat">
          <div class="col-3 pr-0 d-flex" style="overflow:hidden;overflow-y:auto;">
            <div class="card chatList flex-fill">
              <div class="card-body p-0 border-0">
                <input id="chatactive" type="hidden" value="0">
                <div id="chatList" class="list-group">
                  <?php $s=$db->prepare("SELECT * FROM `".$prefix."livechat` WHERE `who`!='admin' GROUP BY `sid` ORDER BY `ti` ASC");
                  $s->execute();
                  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <span id="l_<?php echo$r['id'];?>" class="chatListItem list-group-item list-group-item-action border-top-0 border-right-0 border-left-0 border-bottom bg-dark" data-sid="<?php echo$r['sid'];?>" data-chatname="<?php echo$r['name'];?>" data-chatemail="<?php echo$r['email'];?>">
                      <span class="btn-group float-right">
                        <?php $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                        $scc->execute([
                          ':ip'=>$r['ip']
                        ]);
                        if($scc->rowCount()<1){?>
                          <form id="blacklist<?php echo$r['id'];?>" target="sp" method="post" action="core/add_blacklist.php">
                            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                            <input type="hidden" name="t" value="livechat">
                            <input type="hidden" name="r" value="Added Manually via Live Chat">
                            <button class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="Add to Blacklist" aria-label="Add to Blacklist"><?php echo svg2('security');?></button>
                          </form>
                        <?php } ?>
                        <form target="sp" method="GET" action="core/purge.php">
                          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                          <input type="hidden" name="t" value="livechat">
                          <input type="hidden" name="c" value="<?php echo$r['sid'];?>">
                          <button class="btn btn-secondary btn-sm trash" onclick="javascript:clearTimeout(chatTimer);" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                        </form>
                      </span>
                      <small><?php echo$r['name'];?></small><br>
                      <small><?php echo$r['email'];?></small><br>
                      <small><small><?php echo date($config['dateFormat'],$r['ti']);?></small></small>
                      <?php echo$r['status']=='unseen'?'<span class="btn-group float-right"><span class="badge badge-danger">Unread</span></span>':'<span class="btn-group float-right"><span class="badge badge-success">Read</span></span>';?>
                    </span>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>
          <div class="col pl-0">
            <div class="card chatBody">
              <div id="chatTitle" class="card-header">&nbsp;</div>
              <div id="chatBody" class="card-body p-0">
                <input id="chatsid" type="hidden" value="">
                <input id="chatwho" type="hidden" value="admin">
                <input id="chataid" type="hidden" value="<?php echo$user['id'];?>">
                <input id="chatemail" type="hidden" value="<?php echo$user['email'];?>">
                <input id="chatname" type="hidden" value="<?php echo $user['name']!=''?$user['name']:$user['username'];?>">
                <div id="chatScreen" class="card-content" style="height:54vh;" data-empty="Select a Message Thread on the left!"></div>
              </div>
              <div class="card-footer p-0 border-0">
                <div class="input-group">
                  <input id="chatmessage" type="text" class="form-control">
                  <div class="input-group-append">
                    <button id="chatButton" class="btn btn-secondary"> Send </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
    }, 2500);
  }
  function updateChatList(){
    chatListTimer=null;
    $.ajax({
      type:"POST",
      url:"core/chatlist.php",
      data:{
        sid: $('#chatactive').val()
      }
    }).done(function(data){
      if(data!='none'){
        $("#chatList").html(data);
      }
    });
    clearTimeout(chatListTimer);
    chatListTimer=setTimeout(function(){
      updateChatList();
    }, 2500);
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
          aid: $('#chataid').val(),
          sid: $('#chatsid').val(),
          who: $('#chatwho').val(),
          name: $('#chatname').val(),
          email: $('#chatemail').val(),
          message: $("#chatmessage").val()
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
