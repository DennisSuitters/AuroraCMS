<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Messages - Edit
 * @package    core/layout/edit_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
if($args[0]!='compose'){
  $q=$db->prepare("UPDATE `".$prefix."messages` SET `status`='read' WHERE `id`=:id");
  $q->execute([
    ':id'=>$args[1]
  ]);
  $q=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE `id`=:id");
  $q->execute([
    ':id'=>$args[1]
  ]);
  $r=$q->fetch(PDO::FETCH_ASSOC);
}else{
  $r=[
    'id'=>0,
    'subject'=>'',
    'to_name'=>'',
    'to_email'=>'',
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
          <div class="content-title-icon"><?php svg('inbox','i-3x');?></div>
          <div>Messages Edit</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" data-placement="left" href="<?php echo$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?php svg('back');?></a>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
          <li class="breadcrumb-item"><?php echo$args[0]=='view'?'View':'Compose';?></li>
          <li class="breadcrumb-item active"><strong id="titleupdate"><?php echo$r['subject'];?></strong></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <div class="row">
          <?php $ur=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."messages` WHERE `status`='unread' AND `folder`='INBOX'")->fetch(PDO::FETCH_ASSOC);
          $sp=$db->query("SELECT COUNT(`folder`) AS cnt FROM `".$prefix."messages` WHERE `folder`='spam' AND `status`='unread'")->fetch(PDO::FETCH_ASSOC);?>
          <div class="messages-menu col-12 col-md-2">
            <a class="btn mb-2" href="<?php echo URL.$settings['system']['admin'].'/messages/compose';?>">Compose</a><br>
            <a class="link mb-1" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('inbox');?> Inbox</a><br>
            <a class="link badge mb-1" href="<?php echo URL.$settings['system']['admin'].'/messages/unread';?>" data-badge="<?php echo$ur['cnt']>0?$ur['cnt']:'';?>"><?php svg('email');?> Unread</a><br>
            <a class="link mb-1" href="<?php echo URL.$settings['system']['admin'].'/messages/sent';?>"><?php svg('email-send');?> Sent</a><br>
            <a class="link mb-1" href="<?php echo URL.$settings['system']['admin'].'/messages/important';?>"><?php svg('bookmark');?> Important</a><br>
            <a class="link badge mb-1" data-badge="<?php echo$sp['cnt']>0?$sp['cnt']:'';?>" href="<?php echo URL.$settings['system']['admin'].'/messages/spam';?>"><?php svg('email-spam');?> Spam</a>
          </div>
          <div class="col-12 col-md-10 pl-3">
            <form target="sp" method="post" action="core/email_message.php" enctype="multipart/form-data">
              <input name="id" type="hidden" value="<?php echo$r['id'];?>">
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
              <label for="ti">Created</label>
              <div class="form-row">
                <input id="ti" type="text" value="<?php echo isset($r['ti'])?date($config['dateFormat'],$r['ti']):date($config['dateFormat'],time());?>" readonly>
              </div>
              <?php }?>
              <label for="subject">Subject</label>
              <div class="form-row">
                <input id="subject" name="subject" type="text" value="<?php echo$args[0]=='reply'?'Re: ':'';echo$args[0]!='compose'?$r['subject']:'';?>" placeholder="Enter a Subject" required aria-required="true">
              </div>
              <label for="to_email">To</label>
              <div class="form-row">
                <input id="to_email" name="to_email" type="text" value="<?php echo(isset($r)&&$r['to_email']!=''?$r['to_email']:'');?>" placeholder="Enter an Email..." required aria-required="true">
              </div>
              <label for="from_email">From</label>
              <div class="form-row">
                <?php if($args[0]=='compose'){?>
                  <select id="from_email" name="from_email">
                    <?php if($config['email']!=''){?>
                      <option value="<?php echo$config['email'];?>"><?php echo$config['business'].' &lt;'.$config['email'].'&gt;';?></option>
                    <?php }?>
                    <option value="<?php echo$user['email'];?>"><?php echo$user['name'].' &lt;'.$user['email'].'&gt;';?></option>
                  </select>
                <?php }else{?>
                  <input id="from_email" name="from_email" type="text" value="<?php echo$args[0]=='compose'?$user['email']:$r['from_email'];?>" required aria-required="true">
                <?php }?>
              </div>
              <label>Attachments</label>
              <div class="form-row">
                <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('<?php echo$r['id'];?>','messages','attachments');return false;"><?php svg('browse-media');?></button>
              </div>
              <div id="attachments">
                <?php if($r['attachments']!=''){
                  $atts='';
                  $ti=time();
                  $attachments=explode(',',$r['attachments']);
                  foreach($attachments as$attachment){
                    $atts.=($atts!=''?',':'').$attachment;
                    $attimg='core/images/i-file.svg';
                    if(preg_match("/\.(gif|png|jpg|jpeg|bmp|webp|svg)$/",$attachment))
                      $attimg=$attachment;
                    if(preg_match("/\.(pdf)$/",$attachment))
                      $attimg='core/images/i-file-pdf.svg';
                    if(preg_match("/\.(zip|zipx|tar|gz|rar|7zip|7z|bz2)$/",$attachment))
                      $attimg='core/images/i-file-archive.svg';
                    if(preg_match("/\.(doc|docx|xls)$/",$attachment))
                      $attimg='core/images/i-file-docs.svg';?>
                    <div class="form-row mt-1" id="a_<?php echo$ti;?>">
                      <img src="<?php echo$attimg;?>" alt="<?php echo basename($attachment);?>">
                      <div class="input-text col-12">
                        <a aria-label="<?php echo basename($attachment);?>" target="_blank" href="<?php echo$attachment;?>"><?php echo basename($attachment);?></a>
                      </div>
                      <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="attRemove('<?php echo$ti;?>');return false;"><?php svg('trash');?></button>
                    </div>
                  <?php }
                }?>
              </div>
              <input id="atts" name="atts" type="hidden" value="<?php echo$r['attachments'];?>">
              <script>
                function attRemove(id){
                  var href=$('#a_'+id+' a').attr('href');
                  var atts=$("#atts").val();
                  $('#atts').val(atts.replace(href,''));
                  $('#a_'+id).remove();
                }
              </script>
              <?php if($args[0]!='compose'){?>
                <label for="order_notes">Message</label>
                <div class="form-row">
                  <iframe id="order_notes" src="core/viewemail.php?id=<?php echo$r['id'];?>" width="100%" frameborder="0" scrolling="no" onload="this.style.height=this.contentDocument.body.scrollHeight+'px';" style="background:#fff;color:#000;"></iframe>
                </div>
              <?php }?>
              <label for="bod">Reply</label>
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
