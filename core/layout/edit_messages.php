<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Messages - Edit
 * @package    core/layout/edit_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.25
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
if($args[0]!='compose'){
  $q=$db->prepare("UPDATE `".$prefix."messages` SET `status`='read' WHERE `id`=:id");
  $q->execute([':id'=>$args[1]]);
  $q=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `id`=:id");
  $q->execute([':id'=>$args[1]]);
  $r=$q->fetch(PDO::FETCH_ASSOC);
}else{
  $r=[
    'id'=>0,
    'subject'=>'',
    'to_name'=>'',
    'to_email'=>(isset($args[1])&&$args[1]!=''?$args[1]:''),
    'from_name'=>'',
    'from_email'=>'',
    'attachments'=>'',
    'notes_html'=>''
  ];
}?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
                <li class="breadcrumb-item"><?=$args[0]=='view'?'View':'Compose';?></li>
                <li class="breadcrumb-item active"><strong id="titleupdate"><?=$r['subject'];?></strong></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <?php
          $ur=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."messages` WHERE `status`='unread' AND `folder`='INBOX'")->fetch(PDO::FETCH_ASSOC);
          $sp=$db->query("SELECT COUNT(`folder`) AS cnt FROM `".$prefix."messages` WHERE `folder`='spam' AND `status`='unread'")->fetch(PDO::FETCH_ASSOC);?>
          <div class="messages-menu col-12 col-sm-5 col-lg-4 col-xl-3 col-xxl-2 p-3 border">
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
                  <a class="<?=(isset($args[0])&&$args[0]=='read'?' active':'');?>" href="<?= URL.$settings['system']['admin'].'/messages/read';?>">
                    <i class="i i-2x mr-2">email-read</i> Read
                  </a>
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
          </div>
          <section class="col-12 col-sm ml-3 overflow-visible list">
            <article class="card overflow-visible card-list m-0 px-3 py-2">
              <form target="sp" method="post" action="core/email_message.php" enctype="multipart/form-data">
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <div class="row">
                  <div class="col-12 text-right">
                    <div class="btn-group">
                      <?php if($args[0]!='compose'){?>
                        <button name="act" type="submit" value="reply" data-tooltip="tooltip" aria-label="Reply"><i class="i">email-reply</i></button>
                        <button name="act" type="submit" value="forward" data-tooltip="tooltip" aria-label="Forward"><i class="i">email-forward</i></button>
                      <?php }else{?>
                        <button name="act" type="submit" value="compose" data-tooltip="tooltip" aria-label="Send"><i class="i">email-send</i></button>
                      <?php }?>
                    </div>
                  </div>
                </div>
                <?php if($args[0]!='compose'){?>
                  <label id="messageDateCreated" for="ti">Created</label>
                  <div class="form-row">
                    <input id="ti" type="text" value="<?= isset($r['ti'])?date($config['dateFormat'],$r['ti']):date($config['dateFormat'],time());?>" readonly>
                  </div>
                <?php }?>
                <label id="messageSubject" for="subject">Subject</label>
                <div class="form-row">
                  <input id="subject" name="subject" type="text" value="<?=$args[0]=='reply'?'Re: ':'';echo$args[0]!='compose'?$r['subject']:'';?>" placeholder="Enter a Subject" required data-tooltip="tooltip" aria-required="true">
                </div>
                <label id="messageTo" for="to_email">To</label>
                <div class="form-row">
                  <input id="to_email" name="to_email" type="text" value="<?= isset($r)&&$r['to_email']!=''?$r['to_email']:'';?>" placeholder="Enter an Email..." required data-tooltip="tooltip" aria-required="true">
                </div>
                <label id="messageFrom" for="from_email">From</label>
                <div class="form-row">
                  <?php if($args[0]=='compose'){?>
                    <select id="from_email" name="from_email">
                      <?php if($config['email']!=''){?>
                        <option value="<?=$config['email'];?>"><?=$config['business'].' &lt;'.$config['email'].'&gt;';?></option>
                      <?php }?>
                      <option value="<?=$user['email'];?>"><?=$user['name'].' &lt;'.$user['email'].'&gt;';?></option>
                    </select>
                  <?php }else{?>
                    <input id="from_email" name="from_email" type="text" value="<?=$args[0]=='compose'?$user['email']:$r['from_email'];?>" required data-tooltip="tooltip" aria-required="true">
                  <?php }?>
                </div>
                <label id="messageAttachments" for="attachments">Attachments</label>
                <div class="form-row">
                  <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?=$r['id'];?>','messages','attachments');return false;"><i class="i">browse-media</i></button>
                </div>
                <div id="attachments">
                  <?php if($r['attachments']!=''){
                    $atts='';
                    $ti=time();
                    $attachments=explode(',',$r['attachments']);
                    foreach($attachments as$attachment){
                      $atts.=($atts!=''?',':'').$attachment;
                      $attimg='file';
                      if(preg_match("/\.(gif|png|jpg|jpeg|bmp|webp|svg)$/",$attachment))$attimg=$attachment;
                      if(preg_match("/\.(pdf)$/",$attachment))$attimg='file-pdf';
                      if(preg_match("/\.(zip|zipx|tar|gz|rar|7zip|7z|bz2)$/",$attachment))$attimg='file-archive';
                      if(preg_match("/\.(doc|docx|xls)$/",$attachment))$attimg='file-docs';?>
                      <div class="form-row mt-1" id="a_<?=$ti;?>">
                        <i class="i i-4x"><?=$attimg;?></i>
                        <div class="input-text col-12">
                          <a data-tooltip="tooltip" aria-label="<?= basename($attachment);?>" target="_blank" href="<?=$attachment;?>"><?= basename($attachment);?></a>
                        </div>
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="attRemove('<?=$ti;?>');return false;"><i class="i">trash</i></button>
                      </div>
                    <?php }
                  }?>
                </div>
                <input id="atts" name="atts" type="hidden" value="<?=$r['attachments'];?>">
                <script>
                  function attRemove(id){
                    var href=$('#a_'+id+' a').attr('href');
                    var atts=$("#atts").val();
                    $('#atts').val(atts.replace(href,''));
                    $('#a_'+id).remove();
                  }
                </script>
                <?php if($args[0]!='compose'){?>
                  <label id="messageNotes" for="notes">Message</label>
                  <div class="form-row note-editor note-frame">
                    <iframe id="notes" src="core/viewemail.php?id=<?=$r['id'];?>" width="100%" frameborder="0" scrolling="no" onload="this.style.height=this.contentDocument.body.scrollHeight+'px';" style="background:#fff;color:#000;"></iframe>
                  </div>
                <?php }?>
                <label id="messageReply" for="bod">Reply</label>
                <div class="row">
                  <textarea id="bod" name="bod"></textarea>
                </div>
              </div>
            </form>
          </article>
          <script>
            $('#bod').summernote({
              height:100,
              tabsize:2,
              lang:'en-US',
              toolbar:
                [
        //        ['auroraCMS',['accessibility','findnreplace','cleaner','seo']],
                  ['style',['style']],
                  ['font',['bold','italic','underline','clear']],
                  ['fontname',['fontname']],
                  ['fontsize',['fontsize']],
                  ['color',['color']],
                  ['para',['ul','ol','paragraph']],
                  ['height',['height']],
                  ['table',['table']],
                  ['insert',['videoAttributes','elfinder','link','hr']],
                  ['view',['fullscreen','codeview']],
                  ['help',['help']]
                ],
                callbacks:{
                  onInit:function(){
                    $('body > .note-popover').appendTo(".note-editing-area");
                  }
                }
            });
          </script>
        </section>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
