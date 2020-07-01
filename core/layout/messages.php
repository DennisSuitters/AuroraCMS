<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Messages
 * @package    core/layout/messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.11
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
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
  if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_messages.php';
  elseif($args[0]=='view'||$args[0]=='compose')include'core'.DS.'layout'.DS.'edit_messages.php';
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
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Messages</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
<?php
  if($folder=='INBOX'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE folder='INBOX' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='unread'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE status='unread' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='important'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE important=1 ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='sent'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE folder='sent' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='spam'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE folder='spam' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  $ur=$db->query("SELECT COUNT(status) AS cnt FROM `".$prefix."messages` WHERE status='unread' AND folder='INBOX'")->fetch(PDO::FETCH_ASSOC);
  $sp=$db->query("SELECT COUNT(folder) AS cnt FROM `".$prefix."messages` WHERE folder='spam' AND status='unread'")->fetch(PDO::FETCH_ASSOC);?>
        <div class="email-app mb-4">
          <nav>
            <?php echo$user['options'][0]==1?'<a class="btn btn-secondary btn-block" href="'.URL.$settings['system']['admin'].'/messages/compose">Compose</a>':'';?>
            <ul id="messagemenu" class="nav">
              <li id="nav_1" class="nav-item<?php echo$folder=='INBOX'?' active':'';?>">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages';?>">
                  <?php svg('inbox');?> Inbox
                </a>
              </li>
              <li id="nav_2" class="nav-item<?php echo$folder=='unread'?' active':'';?>">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/unread';?>">
                  <?php svg('email');?> Unread
                  <span id="unreadbadge" class="badge badge-warning"><?php echo$ur['cnt']>0?$ur['cnt']:'';?></span>
                </a>
              </li>
              <li id="nav_4" class="nav-item<?php echo$folder=='sent'?' active':'';?>">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/sent';?>">
                  <?php svg('email-send');?> Sent
                </a>
              </li>
              <li id="nav_6" class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/important';?>">
                  <?php svg('bookmark');?> Important
                </a>
              </li>
              <li id="nav_7" class="nav-item<?php echo$folder=='spam'?' active':'';?>">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/spam';?>">
                  <?php svg('email-spam');?> Spam
                  <span id="spambadge" class="badge badge-warning"><?php echo$sp['cnt']>0?$sp['cnt']:'';?></span>
                </a>
              </li>
            </ul>
          </nav>
          <div class="inbox col">
            <div style="height:20px;">
              <div id="checkmessages" class="badge badge-warning col-12 text-center d-none">Checking for new Messages!!!</div>
            </div>
            <ul id="allmessages" class="messages">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <li id="l_<?php echo$r['id'];?>" class="message animated fadeIn<?php echo' '.$r['status'];?>">
                <div class="actions">
                  <div class="btn-group-vertical">
<?php
if($user['options'][0]==1){
   $scc=$db->prepare("SELECT email FROM `".$prefix."whitelist` WHERE email=:email");
        $scc->execute([':email'=>$r['from_email']]);
        if($scc->rowCount()<1){?>
                    <form id="whitelist<?php echo$r['id'];?>" target="sp" method="post" action="core/add_messagewhitelist.php">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <button class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="Add to Whitelist" aria-label="Add to Whitelist"><?php echo svg2('whitelist');?></button>
                    </form>
<?php }
      $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
      $scc->execute([':ip'=>$r['ip']]);
      if($scc->rowCount()<1){?>
                    <form id="blacklist<?php echo$r['id'];?>" target="sp" method="post" action="core/add_messageblacklist.php">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <button class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="Add to Blacklist" aria-label="Add to Blacklist"><?php echo svg2('security');?></button>
                    </form>
<?php } ?>
                    <button class="btn btn-secondary btn-sm" onclick="update('<?php echo$r['id'];?>','messages','folder','spam');" data-tooltip="tooltip" data-title="Move to Spam Folder" aria-label="Move to Spam Folder"><?php svg('email-spam');?></button>
                    <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$r['id'];?>','messages')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                  </div>
<?php }?>
                </div>
                <a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>">
                  <span class="header">
                    <span class="to">To: <?php echo$r['to_name']!=''?$r['to_name'].'<small> &lt;'.$r['to_email'].'&gt;</small>':'&lt;'.$r['to_email'].'&gt;';?></span>
                    <span class="date"><?php echo date('M j \a\t G:i',$r['ti']);?></span>
                  </span>
                  <span class="header">
                    <span class="from">From: <?php echo$r['from_name']!=''?$r['from_name'].'<small> &lt;'.$r['from_email'].'&gt;</small>':'&lt;'.$r['from_email'].'&gt;';?></span>
                  </span>
                  <span class="title d-block">Subject: <?php echo$r['subject'];?></span>
<?php if($r['attachments']!=''){
  $attachments=explode(',',$r['attachments']);
  $att='';
  foreach($attachments as $attachment){
    $att.='<a target="_blank" href="'.$attachment.'">'.basename($attachment).'</a> ';
  }?>
                  <span class="title">Attachments: <?php echo$att;?></span>
<?php }
//  if($r['notes_html']=='')$r['notes_html']=$r['notes_plain'];
//  if($r['notes_html']=='')$r['notes_html']=$r['notes_raw'];
  if(is_base64_string($r['notes_html']))$r['notes_html']=base64_decode($r['notes_html']);?>
                  <span class="description d-block text-wrap"><?php echo strip_html_tags($r['notes_html']);?></span>
                </a>
              </li>
<?php }?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
<?php if($config['message_check_interval']!=0){?>
  $(document).ready(function(){
    var f=function(){
      $('#checkmessages').removeClass('d-none');
      $.ajax({
        url:"core/get_messages.php?folder=<?php echo$folder;?>",
        success:function(data){
          $('#allmessages').append(data);
          $('#checkmessages').addClass('d-none');
        }
      });
    };
    window.setInterval(f,<?php echo$config['message_check_interval'];?>*1000);
    f();
  });
<?php }?>
</script>
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
