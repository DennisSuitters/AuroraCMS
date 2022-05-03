<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Messages - Edit
 * @package    core/layout/edit_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
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
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">inbox</i></div>
          <div>Messages Edit</div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="tooltip" aria-label="Back"><i class="i">back</i></a>
            <?php }?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
          <li class="breadcrumb-item"><?=$args[0]=='view'?'View':'Compose';?></li>
          <li class="breadcrumb-item active"><strong id="titleupdate"><?=$r['subject'];?></strong></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 p-3">
        <div class="row">
          <?php $ur=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."messages` WHERE `status`='unread' AND `folder`='INBOX'")->fetch(PDO::FETCH_ASSOC);
          $sp=$db->query("SELECT COUNT(`folder`) AS cnt FROM `".$prefix."messages` WHERE `folder`='spam' AND `status`='unread'")->fetch(PDO::FETCH_ASSOC);?>
          <div class="messages-menu col-12 col-md-2">
            <a class="btn mb-2" href="<?= URL.$settings['system']['admin'].'/messages/compose';?>">Compose</a><br>
            <a class="link mb-1" href="<?= URL.$settings['system']['admin'].'/messages';?>"><i class="i">inbox</i> Inbox</a><br>
            <a class="link badge mb-1" href="<?= URL.$settings['system']['admin'].'/messages/unread';?>" data-badge="<?=$ur['cnt']>0?$ur['cnt']:'';?>"><i class="i">email</i> Unread</a><br>
            <a class="link mb-1" href="<?= URL.$settings['system']['admin'].'/messages/sent';?>"><i class="i">email-send</i> Sent</a><br>
            <a class="link mb-1" href="<?= URL.$settings['system']['admin'].'/messages/important';?>"><i class="i">bookmark</i> Important</a><br>
            <a class="link badge mb-1" data-badge="<?=$sp['cnt']>0?$sp['cnt']:'';?>" href="<?= URL.$settings['system']['admin'].'/messages/spam';?>"><i class="i">email-spam</i> Spam</a>
          </div>
          <div class="col-12 col-md-10 pl-4">
            <form target="sp" method="post" action="core/email_message.php" enctype="multipart/form-data">
              <input name="id" type="hidden" value="<?=$r['id'];?>">
              <div class="row">
                <div class="col-12 text-right">
                  <div class="btn-group">
                    <?php if($args[0]!='compose'){?>
                      <button name="act" type="submit" value="reply">Reply</button>
                      <button name="act" type="submit" value="forward">Forward</button>
                    <?php }else{?>
                      <button name="act" type="submit" value="compose">Send</button>
                    <?php }?>
                  </div>
                </div>
              </div>
              <?php if($args[0]!='compose'){?>
              <label id="messageDateCreated" for="ti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/edit/'.$r['id'].'#messageDateCreated" data-tooltip="tooltip" aria-label="PermaLink to Message Date Created Field">&#128279;</a>':'';?>Created</label>
              <div class="form-row">
                <input id="ti" type="text" value="<?= isset($r['ti'])?date($config['dateFormat'],$r['ti']):date($config['dateFormat'],time());?>" readonly>
              </div>
              <?php }?>
              <label id="messageSubject" for="subject"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/edit/'.$r['id'].'#messageSubject" data-tooltip="tooltip" aria-label="PermaLink to Message Subject Field">&#128279;</a>':'';?>Subject</label>
              <div class="form-row">
                <input id="subject" name="subject" type="text" value="<?=$args[0]=='reply'?'Re: ':'';echo$args[0]!='compose'?$r['subject']:'';?>" placeholder="Enter a Subject" required data-tooltip="tooltip" aria-required="true">
              </div>
              <label id="messageTo" for="to_email"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/edit/'.$r['id'].'#messageTo" data-tooltip="tooltip" aria-label="PermaLink to Message To Email Field">&#128279;</a>':'';?>To</label>
              <div class="form-row">
                <input id="to_email" name="to_email" type="text" value="<?= isset($r)&&$r['to_email']!=''?$r['to_email']:'';?>" placeholder="Enter an Email..." required data-tooltip="tooltip" aria-required="true">
              </div>
              <label id="messageFrom" for="from_email"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/edit/'.$r['id'].'#messageFrom" data-tooltip="tooltip" aria-label="PermaLink to Message From Email Field">&#128279;</a>':'';?>From</label>
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
              <label id="messageAttachments" for="attachments"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/edit/'.$r['id'].'#messageAttachments" data-tooltip="tooltip" aria-label="PermaLink to Message Attachments">&#128279;</a>':'';?>Attachments</label>
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
                <label id="messageNotes" for="notes"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/edit/'.$r['id'].'#messageNotes" data-tooltip="tooltip" aria-label="PermaLink to Message">&#128279;</a>':'';?>Message</label>
                <div class="form-row">
                  <iframe id="notes" src="core/viewemail.php?id=<?=$r['id'];?>" width="100%" frameborder="0" scrolling="no" onload="this.style.height=this.contentDocument.body.scrollHeight+'px';" style="background:#fff;color:#000;"></iframe>
                </div>
              <?php }?>
              <label id="messageReply" for="bod"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/edit/'.$r['id'].'#messageReply" data-tooltip="tooltip" aria-label="PermaLink to Message">&#128279;</a>':'';?>Reply</label>
              <div class="form-row">
                <textarea id="bod" name="bod"></textarea>
              </div>
            </div>
          </form>
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
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
