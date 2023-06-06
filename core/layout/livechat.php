<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Live Chat
 * @package    core/layout/livechat.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_livechat.php';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active">Live Chat</li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=$user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/livechat/settings" role="button"  data-tooltip="left" aria-label="Live Chat Settings"><i class="i">settings</i></a>':'';?>
                </div>
              </div>
            </div>
          </div>
          <div class="row chat">
            <input id="chatactive" type="hidden" value="0">
            <div class="col-12 col-md-4 px-3">
              <div class="form-row mb-3">
                <input id="filter-input" type="text" value="" placeholder="Search for People, Email..." onkeyup="filterTextInput2();">
              </div>
              <div id="chatList" class="chatList card overflow-visible">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."livechat` WHERE `who`!='admin' GROUP BY `sid` ORDER BY `ti` ASC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <span class="chatListItem list-group-item list-group-item-action border-top-0 border-right-0 border-left-0 border-bottom" id="l_<?=$r['id'];?>" data-sid="<?=$r['sid'];?>" data-chatname="<?=$r['name'];?>" data-chatemail="<?=$r['email'];?>" data-content="<?=$r['name'].' '.$r['email'];?>">
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
                    <?php }?>
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
                    <div class="input-text" data-el="chatmessage" contenteditable="true"></div>
                    <input class="d-none" id="chatmessage" type="text">
                    <button id="chatButton"> Send </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php require'core/layout/footer.php';?>
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
