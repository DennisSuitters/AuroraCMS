<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Messages
 * @package    core/layout/messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.24
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
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
function is_base64_string($s){
 if(($b=base64_decode($s,TRUE))===FALSE)return FALSE;
 $e=mb_detect_encoding($b);
 if(in_array($e,array('UTF-8','ASCII')))return TRUE;else return FALSE;
}
if($user['options'][3]==1){
  if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_messages.php';
  elseif(isset($args[0])&&($args[0]=='view'||$args[0]=='compose'))require'core/layout/edit_messages.php';
  else{
    $folder="INBOX";
    if(isset($args[0])){
      if($args[0]=='unread')$folder='unread';
      if($args[0]=='trash')$folder='trash';
//     if($args[0]=='trash')$folder='DELETE';
      if($args[0]=='starred')$folder='starred';
      if($args[0]=='important')$folder='important';
      if($args[0]=='sent')$folder='sent';
      if($args[0]=='spam')$folder='spam';
    }?>
    <main>
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
        <div class="container-fluid">
          <div class="card mt-3 bg-transparent border-0 overflow-visible">
            <div class="card-actions">
              <div class="row">
                <div class="col-12 col-sm">
                  <ol class="breadcrumb m-0 pl-0 pt-0">
                    <li class="breadcrumb-item active">Messages</li>
                  </ol>
                </div>
                <div class="col-12 col-sm-6 text-right">
                  <div class="form-row justify-content-end">
                    <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
                    <div class="btn-group">
                      <?=$user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/messages/settings" role="button" data-tooltip="left" aria-label="Messages Settings"><i class="i">settings</i></a>':'';?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <?php if($folder=='INBOX'){
                $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `folder`='INBOX' ORDER BY `ti` DESC, `subject` ASC");
                $s->execute();
              }
              if($folder=='unread'){
                $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `status`='unread' ORDER BY `ti` DESC, `subject` ASC");
                $s->execute();
              }
              if($folder=='important'){
                $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `important`=1 ORDER BY `ti` DESC, `subject` ASC");
                $s->execute();
              }
              if($folder=='sent'){
                $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `folder`='sent' ORDER BY `ti` DESC, `subject` ASC");
                $s->execute();
              }
              if($folder=='spam'){
                $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `folder`='spam' ORDER BY `ti` DESC, `subject` ASC");
                $s->execute();
              }
              $ur=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."messages` WHERE `status`='unread' AND `folder`='INBOX'")->fetch(PDO::FETCH_ASSOC);
              $sp=$db->query("SELECT COUNT(`folder`) AS cnt FROM `".$prefix."messages` WHERE `folder`='spam' AND `status`='unread'")->fetch(PDO::FETCH_ASSOC);?>
              <div class="messages-menu col-12 col-sm-5 col-lg-4 col-xl-3 col-xxl-2 p-3 shadow">
                <?=$user['options'][0]==1?'<a class="btn-block mb-2" href="'.URL.$settings['system']['admin'].'/messages/compose" role="button">Compose New Email</a>':'';?>
                <nav class="mt-3">
                  <ul>
                    <li>
                      <a class="<?=(isset($args[0])?'':' active');?>" href="<?= URL.$settings['system']['admin'].'/messages';?>"><i class="i i-2x mr-2">inbox</i> Inbox</a>
                    </li>
                    <li>
                      <a class="<?=(isset($args[0])&&$args[0]=='unread'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/unread';?>">
                        <i class="i i-2x mr-2">email</i> Unread
                      </a>
                      <?=($ur['cnt']>0?'<span class="badge" data-badge="'.$ur['cnt'].'"></span>':'');?>
                    </li>
                    <li>
                      <a class="<?=(isset($args[0])&&$args[0]=='sent'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/sent';?>"><i class="i i-2x mr-2">email-send</i> Sent</a>
                    </li>
                    <li>
                      <a class="<?=(isset($args[0])&&$args[0]=='important'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/important';?>"><i class="i i-2x mr-2">bookmark</i> Important</a>
                    </li>
                    <li>
                      <a class="<?=(isset($args[0])&&$args[0]=='spam'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/spam';?>"><i class="i i-2x mr-2">email-spam</i> Spam</a>
                      <?=($sp['cnt']>0?'<span class="badge" data-badge="'.$sp['cnt'].'"></span>':'');?>
                    </li>
                  </ul>
                </nav>
                <div class="alert alert-warning col-12 text-center m-0 d-none" id="checkmessages">Checking for new Messages!!!</div>
              </div>
              <section class="col-12 col-sm ml-3 overflow-visible list" id="accountview">
                <article class="card overflow-visible card-list item m-0 px-2 py-3">
                  <span class="btn pl-1" data-tooltip="tooltip" aria-label="Select">
                    <input class="d-inline-block" type="checkbox" id="itemchecker" onclick="itemstoggle(this,'toggle');">
                    <ul class="breadcrumb d-inline-block m-0 p-0">
                      <li class="breadcrumb-item active breadcrumb-dropdown">
                        <span class="breadcrumb-dropdown ml-2" data-tooltip="tooltip" aria-label="Select"><i class="i mt-1">chevron-down</i></span>
                        <ul class="breadcrumb-dropper">
                          <li><a onclick="itemstoggle(this,'all');">All</a></li>
                          <li><a onclick="itemstoggle(this,'none');">None</a></li>
                          <li><a onclick="itemstoggle(this,'swap');">Swap</a></li>
                          <li><a onclick="itemstoggle(this,'read');">Read</a></li>
                          <li><a onclick="itemstoggle(this,'unread');">Unread</a></li>
                          <li><a onclick="itemstoggle(this,'important');">Important</a></li>
                        </ul>
                      </li>
                    </ul>
                  </span>
                  <button class="ml-2" data-tooltip="tooltip" aria-label="Refresh" onclick="refreshmessages();"><i class="i">reload</i></button>
                  <button class="ml-2" data-tooltip="tooltip" aria-label="Delete" onclick="actionItems('delete');"><i class="i">trash</i></button>
                  <input type="hidden" id="actionda" value=""/>
                  <script>
                  function actionItems(act){
                    var items=$.map($('input[name="item"]:checked'),function(c){return c.value;});
                    var ci=0;
                    for(var i=0,n=items.length;i<n;i++){
                      if(items[i].checked=true){
                        ci++;
                      }
                    }
                    if(ci==0){
                      toastr["error"]("No Messages have been selected!");
                    }else{
                      var items=$.map($('input[name="item"]:checked'),function(c){return c.value;});
                      $('#actionda').val(items);
                      var da=$('#actionda').val();
                      $.ajax({
                        type:"GET",
                        url:"core/messageactions.php",
                        data:{
                          act:act,
                          da:da
                        }
                      }).done(function(msg){
                        if(msg=='success'){
                          $('#actionda').val(items);
                          var items=$.map($('input[name="item"]:checked'),function(c){return c.value;});
                          if(act=='delete'){
                            for(var i=0,n=items.length;i<n;i++){
                              $(`#l_`+items[i]).remove();
                            }
                            $('#itemchecker').prop("checked",false);
                          }
                        }else{
                          toastr["error"]("There was an issue processing the request!");
                        }
                      });
                    }
                  }
                  </script>
                </article>
                <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <article id="l_<?=$r['id'];?>" class="card zebra overflow-visible card-list item m-0 px-3 py-2" data-content="<?=$r['from_name'].' '.$r['from_email'].' '.$r['subject'];?>" data-status="<?=$r['status'];?>">
                    <div class="row">
                      <div class="col-1 p-2">
                        <input type="checkbox" name="item" value="<?=$r['id'];?>" data-status="<?=$r['status'];?>">
                      </div>
                      <div class="col-1">
                        <input id="imp<?=$r['id'];?>" data-dbid="<?=$r['id'];?>" data-dbt="messages" data-dbc="important" data-dbb="0" type="checkbox" class="messages-important d-none"<?=($r['important']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                        <label class="m-0 mt-2 p-0" for="imp<?=$r['id'];?>"><i class="i i-2x">bookmark</i></label>
                      </div>
                      <div class="col-sm small">
                        <a href="<?= URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>"><?=$r['from_name']!=''?$r['from_name']:'&lt;'.$r['from_email'].'&gt;';?><br>
                        <small class="date"><?= date('M j \a\t G:i',$r['ti']);?></small>
                        </a>
                      </div>
                      <div class="col-sm small">
                        <a href="<?= URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>"><?=$r['subject'];?></a>
                      </div>
                      <div class="col-3">
                        <div id="controls_<?=$r['id'];?>">
                          <div class="btn-toolbar float-right" role="toolbar">
                            <div class="btn-group" role="group">
                              <?php if($user['options'][0]==1){
                                $scc=$db->prepare("SELECT `email` FROM `".$prefix."whitelist` WHERE `email`=:email");
                                $scc->execute([':email'=>$r['from_email']]);
                                if($scc->rowCount()<1){?>
                                  <form id="whitelist<?=$r['id'];?>" target="sp" method="post" action="core/add_messagewhitelist.php">
                                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                                    <button data-tooltip="tooltip" aria-label="Add to Whitelist"><i class="i">whitelist</i></button>
                                  </form>
                                <?php }
                                $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                                $scc->execute([':ip'=>$r['ip']]);
                                if($scc->rowCount()<1){?>
                                  <form id="blacklist<?=$r['id'];?>" target="sp" method="post" action="core/add_messageblacklist.php">
                                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                                    <button data-tooltip="tooltip" aria-label="Add to Blacklist"><i class="i">security</i></button>
                                  </form>
                                <?php }?>
                                <button data-tooltip="tooltip" aria-label="Move to Spam Folder" onclick="update('<?=$r['id'];?>','messages','folder','spam');"><i class="i">email-spam</i></button>
                                <button class="purge" data-tooltip="tooltip" aria-label="Delete"  onclick="purge('<?=$r['id'];?>','messages')"><i class="i">trash</i></button>
                              <?php }?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                <?php }?>
              </section>
            </div>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </section>
      <script>
        <?php if($config['message_check_interval']!=0){?>
          $(document).ready(function(){
            var f=function(){
              $('#checkmessages').removeClass('d-none');
              $.ajax({
                url:"core/get_messages.php?folder=<?=$folder;?>",
                success:function(data){
                  $('#allmessages').append(data);
                  setTimeout(function(){$('#checkmessages').addClass('d-none');},1000);
                }
              });
            };
            window.setInterval(f,<?=$config['message_check_interval'];?>*1000);
            f();
          });
        <?php }?>
        function refreshmessages(){
          var f=function(){
            $('#checkmessages').removeClass('d-none');
            $.ajax({
              url:"core/get_messages.php?folder=<?=$folder;?>",
              success:function(data){
                $('#allmessages').append(data);
                setTimeout(function(){$('#checkmessages').addClass('d-none');},1000);
              }
            });
          };
          window.setInterval(f,<?=$config['message_check_interval'];?>*1000);
          f();
        }
      </script>
    </main>
  <?php }
}else{?>
  <main id="content" class="main">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Messages</li>
    </ol>
    <div class="container-fluid">
      <div class="alert alert-info" role="alert">You don't have permissions to View this Area!</div>
    </div>
  </main>
<?php }
