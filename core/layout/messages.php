<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Messages
 * @package    core/layout/messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
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
                <div class="col-12 col-sm-2 text-right">
                  <div class="btn-group">
                    <?=$user['options'][7]==1?'<a class="btn" href="'.URL.$settings['system']['admin'].'/messages/settings" data-tooltip="left" aria-label="Messages Settings"><i class="i">settings</i></a>':'';?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
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
              <div class="messages-menu col-12 col-sm-2">
                <?=$user['options'][0]==1?'<a class="btn mb-2" href="'.URL.$settings['system']['admin'].'/messages/compose">Compose</a><br>':'';?>
                <a class="link mb-1<?=(isset($args[0])?'':' active');?>" href="<?= URL.$settings['system']['admin'].'/messages';?>"><i class="i">inbox</i> Inbox</a><br>
                <a class="link badge mb-1<?=(isset($args[0])&&$args[0]=='unread'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/unread';?>" data-badge="<?=$ur['cnt']>0?$ur['cnt']:'';?>"><i class="i">email</i> Unread</a><br>
                <a class="link mb-1<?=(isset($args[0])&&$args[0]=='sent'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/sent';?>"><i class="i">email-send</i> Sent</a><br>
                <a class="link mb-1<?=(isset($args[0])&&$args[0]=='important'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/important';?>"><i class="i">bookmark</i> Important</a><br>
                <a class="link badge mb-1<?=(isset($args[0])&&$args[0]=='spam'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/spam';?>" data-badge="<?=$sp['cnt']>0?$sp['cnt']:'';?>"><i class="i">email-spam</i> Spam</a>
                <div class="alert alert-warning col-12 text-center m-0 d-none" id="checkmessages">Checking for new Messages!!!</div>
              </div>
              <div class="col-12 col-sm-10 pl-3">
                <table class="table-zebra">
                  <thead>
                    <tr>
                      <th class="col-1"><input type="checkbox"></th>
                      <th class="text-left">
                        From<br>
                        <small>Subject</small>
                      </th>
                      <th class="align-top">Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                      <tr class="<?=$r['status']=='unread'?' font-weight-bold':' font-weight-light';?>" id="l_<?=$r['id'];?>">
                        <td class="col-1">
                          <input name="message[]" type="checkbox">
                        </td>
                        <td class="text-left">
                          <a href="<?= URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>">
                            <span class="from"><?=$r['from_name']!=''?$r['from_name'].'<small> &lt;'.$r['from_email'].'&gt;</small>':'&lt;'.$r['from_email'].'&gt;';?></span><br>
                            <small class="subject"><?=$r['subject'];?></small>
                          </a>
                        </td>
                        <td>
                          <span class="date"><?= date('M j \a\t G:i',$r['ti']);?></span>
                        </td>
                        <td class="align-middle" id="controls_<?=$r['id'];?>">
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
                                <button class="purge trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','messages')"><i class="i">trash</i></button>
                              <?php }?>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
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
                  $('#checkmessages').addClass('d-none');
                }
              });
            };
            window.setInterval(f,<?=$config['message_check_interval'];?>*1000);
            f();
          });
        <?php }?>
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
