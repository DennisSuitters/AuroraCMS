<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Messages
 * @package    core/layout/messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
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
      <section id="content" class="main">
        <div class="content-title-wrapper mb-0">
          <div class="content-title">
            <div class="content-title-heading">
              <div class="content-title-icon"><?= svg2('inbox','i-3x');?></div>
              <div>Messages</div>
              <div class="content-title-actions">
                <?=$user['options'][7]==1?'<a class="btn" href="'.URL.$settings['system']['admin'].'/messages/settings" data-tooltip="tooltip" aria-label="Messages Settings">'.svg2('settings').'</a>':'';?>
              </div>
            </div>
            <ol class="breadcrumb">
              <li class="breadcrumb-item active">Messages</li>
            </ol>
          </div>
        </div>
        <div class="container-fluid p-0">
          <div class="card border-radius-0 p-3">
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
              <div class="messages-menu col-12 col-md-2">
                <?=$user['options'][0]==1?'<a class="btn mb-2" href="'.URL.$settings['system']['admin'].'/messages/compose">Compose</a><br>':'';?>
                <a class="link mb-1<?=(isset($args[0])?'':' active');?>" href="<?= URL.$settings['system']['admin'].'/messages';?>"><?= svg2('inbox');?> Inbox</a><br>
                <a class="link badge mb-1<?=(isset($args[0])&&$args[0]=='unread'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/unread';?>" data-badge="<?=$ur['cnt']>0?$ur['cnt']:'';?>"><?= svg2('email');?> Unread</a><br>
                <a class="link mb-1<?=(isset($args[0])&&$args[0]=='sent'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/sent';?>"><?= svg2('email-send');?> Sent</a><br>
                <a class="link mb-1<?=(isset($args[0])&&$args[0]=='important'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/important';?>"><?= svg2('bookmark');?> Important</a><br>
                <a class="link badge mb-1<?=(isset($args[0])&&$args[0]=='spam'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/spam';?>" data-badge="<?=$sp['cnt']>0?$sp['cnt']:'';?>"><?= svg2('email-spam');?> Spam</a>
              </div>
              <div class="col-12 col-md-10 pl-3">
                <div class="alert alert-warning col-12 text-center d-none" id="checkmessages">Checking for new Messages!!!</div>
                <table class="table-zebra">
                  <thead>
                    <tr>
                      <th><input name="message[]" type="checkbox"></th>
                      <th>
                        From<br>
                        <small>Subject</small>
                      </th>
                      <th>Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                      <tr class="<?=$r['status']=='unread'?' font-weight-bold':' font-weight-light';?>" id="l_<?=$r['id'];?>">
                        <td>
                          <input name="message[]" type="checkbox">
                        </td>
                        <td>
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
                                    <button data-tooltip="tooltip" aria-label="Add to Whitelist"><?= svg2('whitelist');?></button>
                                  </form>
                                <?php }
                                $scc=$db->prepare("SELECT `ip` FROM `".$prefix."iplist` WHERE `ip`=:ip");
                                $scc->execute([':ip'=>$r['ip']]);
                                if($scc->rowCount()<1){?>
                                  <form id="blacklist<?=$r['id'];?>" target="sp" method="post" action="core/add_messageblacklist.php">
                                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                                    <button data-tooltip="tooltip" aria-label="Add to Blacklist"><?= svg2('security');?></button>
                                  </form>
                                <?php }?>
                                <button data-tooltip="tooltip" aria-label="Move to Spam Folder" onclick="update('<?=$r['id'];?>','messages','folder','spam');"><?= svg2('email-spam');?></button>
                                <button class="purge trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','messages')"><?= svg2('trash');?></button>
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
            <?php require'core/layout/footer.php';?>
          </div>
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
