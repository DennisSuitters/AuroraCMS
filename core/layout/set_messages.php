<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Messages
 * @package    core/layout/set_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">inbox</i></div>
          <div>Messages Settings</div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="tooltip" aria-label="Back"><i class="i">back</i></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><i class="i">save</i></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <legend id="contactForm" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#contactForm" data-tooltip="tooltip" aria-label="PermaLink to Contact Form Section">&#128279;</a>':'';?>Contact Form</legend>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#storeMessages" data-tooltip="tooltip" aria-label="PermaLink to Enable Store Messages Checkbox">&#128279;</a>':'';?>
          <input id="storeMessages" data-dbid="1" data-dbt="config" data-dbc="storemessages" data-dbb="0" type="checkbox"<?=$config['storemessages'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="storeMessages" id="configstoremessages01">Store Contact Form Messages</label>
        </div>
        <div class="form-row mt-3">
          <small class="form-text text-right">If no entries are made, an input text box will be used instead of a dropdown. If email's are left blank, the messages will be sent to the site email set in <a href="<?= URL.$settings['system']['admin'];?>/preferences/contact#email">Preferences</a>.</small>
        </div>
        <form target="sp" method="post" action="core/add_subject.php">
          <div class="form-row">
            <div class="input-text">Subject</div>
            <input id="sub" name="sub" type="text" value="" placeholder="Enter a Subject...">
            <div class="input-text">Email</div>
            <input id="eml" name="eml" type="text" value="" placeholder="Enter an Email...">
            <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
          </div>
        </form>
        <div id="subjects">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='subject' ORDER BY `title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div class="form-row mt-1" id="l_<?=$rs['id'];?>">
              <div class="input-text">Subject</div>
              <input id="sub<?=$r['id'];?>" type="text" value="<?=$rs['title'];?>" onchange="update('<?=$rs['id'];?>','subject','title',$(this).val());">
              <div class="input-text">Email</div>
              <input type="text" value="<?=$rs['url'];?>" onchange="update('<?=$rs['id'];?>','subject','url',$(this).val());">
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?=$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend id="webmailSection" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/media/settings#webmailSection" data-tooltip="tooltip" aria-label="PermaLink to Webmail Section">&#128279;</a>':'';?>Webmail</legend>
        <label id="messageCheckInterval" for="message_check_interval"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#messageCheckInterval" data-tooltip="tooltip" aria-label="PermaLink to Message Check Interval">&#128279;</a>':'';?>Check for new Messages every</label>
        <div class="form-row">
          <select id="message_check_interval" onchange="update('1','config','message_check_interval',$(this).val(),'select');">
            <option value="0"<?=$config['message_check_interval']==0?' selected':'';?>>Disable Checking</option>
            <option value="1"<?=$config['message_check_interval']==1?' selected':'';?>>Every time Messages is opened</option>
            <option value="300"<?=$config['message_check_interval']==300?' selected':'';?>>5 Minutes</option>
            <option value="600"<?=$config['message_check_interval']==600?' selected':'';?>>10 Minutes</option>
            <option value="900"<?=$config['message_check_interval']==900?' selected':'';?>>15 Minutes</option>
            <option value="1800"<?=$config['message_check_interval']==1800?' selected':'';?>>30 Minutes</option>
            <option value="3600"<?=$config['message_check_interval']==3600?' selected':'';?>>1 Hour</option>
          </select>
        </div>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#deleteRetrievedMessages" data-tooltip="tooltip" aria-label="PermaLink to Delete Retrieved Messages Checkbox">&#128279;</a>':'';?>
          <input id="deleteRetrievedMessages" data-dbid="1" data-dbt="login" data-dbc="options" data-dbb="9" type="checkbox"<?=$user['options'][9]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="deleteRetrievedMessages" id="loginoptions91">Delete Retrieved Messages</label>
        </div>
        <legend id="mailboxes" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#mailboxes" data-tooltip="tooltip" aria-label="PermaLink to Mailboxes Section">&#128279;</a>':'';?>Mailboxes</legend>
        <form target="sp" method="post" action="core/add_mailbox.php">
          <input name="uid" type="hidden" value="<?=$user['id'];?>">
          <div class="form-row">
            <div class="input-text">Type</div>
            <select id="type" name="t" onchange="changePort($(this).val());">
              <option value="imap">IMAP</option>
              <option value="pop3">POP3</option>
            </select>
            <div class="input-text">Port</div>
            <input id="port" name="port" type="text" value="143">
            <div class="input-text">Flag</div>
            <select id="flag" name="f">
              <option value="novalidate-cert">novalidate-cert</option>
              <option value="validate-cert">validate-cert</option>
              <option value="norsh">norsh</option>
              <option value="ssl">ssl</option>
              <option value="notls">notls</option>
              <option value="tls">tls</option>
            </select>
            <div class="input-text">Server</div>
            <input id="url" name="url" type="text" value="" placeholder="Enter a Server">
            <div class="input-text">Username</div>
            <input id="mailusr" name="mailusr" type="text" value="" placeholder="Enter a Username...">
            <div class="input-text">Password</div>
            <input id="mailpwd" name="mailpwd" type="text" value="" placeholder="Enter a Password">
            <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
          </div>
        </form>
        <script>
          function changePort(v){
            if(v=='pop3'){
              $('#port').val('110');
            }else{
              $('#port').val('143');
            }
          }
        </script>
        <div id="mailboxes">
          <?php $sm=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='mailbox' AND `uid`=:uid ORDER BY `url`");
          $sm->execute([':uid'=>$user['id']]);
          while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
            <div class="form-row mt-1" id="l_<?=$rm['id'];?>">
              <div class="input-text">Type</div>
              <select id="type<?=$rm['id'];?>" onchange="update(`<?=$rm['id'];?>`,`choices`,`type`,$(this).val());">
                <option value="imap"<?=$rm['type']=='imap'?' selected':'';?>>IMAP</option>
                <option value="pop3"<?=$rm['type']=='pop3'?' selected':'';?>>POP3</option>
              </select>
              <div class="input-text">Port</div>
              <input id="port<?=$rm['id'];?>" type="text" value="<?=$rm['port'];?>" onchange="update(`<?=$rm['id'];?>`,`choices`,`port`,$(this).val());">
              <div class="input-text">Flag</div>
              <select id="flag" onchange="update(`<?=$rm['id'];?>`,`choices`,`flag`,$(this).val(),'select');">
                <option value="novalidate-cert"<?=$rm['flag']=='novalidate-cert'?' selected':'';?>>novalidate-cert</option>
                <option value="validate-cert"<?=$rm['flag']=='validate-cert'?' selected':'';?>>validate-cert</option>
                <option value="norsh"<?=$rm['flag']=='norsh'?' selected':'';?>>norsh</option>
                <option value="ssl"<?=$rm['flag']=='ssl'?' selected':'';?>>ssl</option>
                <option value="notls"<?=$rm['flag']=='notls'?' selected':'';?>>notls</option>
                <option value="tls"<?=$rm['flag']=='tls'?' selected':'';?>>tls</option>
              </select>
              <div class="input-text">Server</div>
              <input id="url<?=$rm['id'];?>" name="url" type="text" value="<?=$rm['url'];?>" placeholder="Enter a Server" onchange="update(`<?=$rm['id'];?>`,`choices`,`url`,$(this).val());">
              <div class="input-text">Username</div>
              <input id="mailusr<?=$rm['id'];?>" name="mailusr" type="text" value="<?=$rm['username'];?>" placeholder="Enter a Username..." onchange="update(`<?=$rm['id'];?>`,`choices`,`username`,$(this).val());">
              <div class="input-text">Password</div>
              <input id="mailpwd<?=$rm['id'];?>" name="mailpwd" type="text" value="<?=$rm['password'];?>" placeholder="Enter a Password..." onchange="update(`<?=$rm['id'];?>`,`choices`,`password`,$(this).val());">
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?=$rm['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend id="autoreplyEmail" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#autoreplyEmail" data-tooltip="tooltip" aria-label="PermaLink to AutoReply Email Section">&#128279;</a>':'';?>AutoReply Email</legend>
        <div id="autoreplySubject" class="form-row">
          <label for="contactAutoReplySubject"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#autoreplySubject" data-tooltip="tooltip" aria-label="PermaLink to Delete Retrieved Messages Checkbox">&#128279;</a>':'';?>Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('aRS','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('aRS','{date}');return false;">{date}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="aRS" type="text" value="<?=$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject">
          <button class="save" id="saveaRS" data-dbid="aRS" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
        </div>
        <div id="autoreplyLayout" class="form-row mt-3">
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{subject}');return false;">{subject}</a>
          </small>
        </div>
        <div class="form-row">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#autoreplyLayout" data-tooltip="tooltip" aria-label="PermaLink to AutoReply Layout">&#128279;</a>':'';?>
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="contactAutoReplyLayout">
            <textarea class="summernote" id="aRL" name="da"><?= rawurldecode($config['contactAutoReplyLayout']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="emailSignature" class="mt-3"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/messages/settings#emailSignature" data-tooltip="tooltip" aria-label="PermaLink to Email Signature">&#128279;</a>':'';?>Email Signature</legend>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="email_signature">
            <textarea class="summernote" id="email_signature" name="da"><?= rawurldecode($config['email_signature']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
