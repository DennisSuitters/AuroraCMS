<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Messages
 * @package    core/layout/set_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('inbox','i-3x');?></div>
          <div>Messages Settings</div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php svg('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <legend class="mt-3">Contact Form</legend>
        <div class="row">
          <input id="storemessages0" data-dbid="1" data-dbt="config" data-dbc="storemessages" data-dbb="0" type="checkbox"<?php echo$config['storemessages'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="storemessages0">Store Contact Form Messages</label>
        </div>
        <div class="form-row mt-3">
          <small class="form-text text-right">If no entries are made, an input text box will be used instead of a dropdown. If email's are left blank, the messages will be sent to the site email set in <a href="<?php echo URL.$settings['system']['admin'];?>/preferences/contact#email">Preferences</a>.</small>
        </div>
        <form target="sp" method="post" action="core/add_subject.php">
          <div class="form-row">
            <div class="input-text">Subject</div>
            <input id="sub" name="sub" type="text" value="" placeholder="Enter a Subject...">
            <div class="input-text">Email</div>
            <input id="eml" name="eml" type="text" value="" placeholder="Enter an Email...">
            <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?php svg('add');?></button>
          </div>
        </form>
        <div id="subjects">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='subject' ORDER BY `title` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div class="form-row mt-1" id="l_<?php echo$rs['id'];?>">
              <div class="input-text">Subject</div>
              <input id="sub<?php echo$r['id'];?>" type="text" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','subject','title',$(this).val());">
              <div class="input-text">Email</div>
              <input type="text" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','subject','url',$(this).val());">
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?php echo$rs['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend class="mt-3">Webmail</legend>
        <label for="message_check_interval">Check for new Messages every</label>
        <div class="form-row">
          <select id="message_check_interval" onchange="update('1','config','message_check_interval',$(this).val());">
            <option value="0"<?php echo$config['message_check_interval']==0?' selected="selected"':'';?>>Disable Checking</option>
            <option value="1"<?php echo$config['message_check_interval']==1?' selected="selected"':'';?>>Every time Messages is opened</option>
            <option value="300"<?php echo$config['message_check_interval']==300?' selected="selected"':'';?>>5 Minutes</option>
            <option value="600"<?php echo$config['message_check_interval']==600?' selected="selected"':'';?>>10 Minutes</option>
            <option value="900"<?php echo$config['message_check_interval']==900?' selected="selected"':'';?>>15 Minutes</option>
            <option value="1800"<?php echo$config['message_check_interval']==1800?' selected="selected"':'';?>>30 Minutes</option>
            <option value="3600"<?php echo$config['message_check_interval']==3600?' selected="selected"':'';?>>1 Hour</option>
          </select>
        </div>
        <div class="row mt-3">
          <input id="options9" data-dbid="1" data-dbt="login" data-dbc="options" data-dbb="9" type="checkbox"<?php echo$user['options'][9]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options9">Delete Messages When Retrieved</label>
        </div>
        <legend class="mt-3">Mailboxes</legend>
        <form target="sp" method="post" action="core/add_mailbox.php">
          <input name="uid" type="hidden" value="<?php echo$user['id'];?>">
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
            <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?php svg('add');?></button>
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
          $sm->execute([
            ':uid'=>$user['id']
          ]);
          while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
            <div class="form-row mt-1" id="l_<?php echo$rm['id'];?>">
              <div class="input-text">Type</div>
              <select id="type<?php echo$rm['id'];?>" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`type`,$(this).val());">
                <option value="imap"<?php echo$rm['type']=='imap'?' selected="selected"':'';?>>IMAP</option>
                <option value="pop3"<?php echo$rm['type']=='pop3'?' selected="selected"':'';?>>POP3</option>
              </select>
              <div class="input-text">Port</div>
              <input id="port<?php echo$rm['id'];?>" type="text" value="<?php echo$rm['port'];?>" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`port`,$(this).val());">
              <div class="input-text">Flag</div>
              <select id="flag" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`flag`,$(this).val());">
                <option value="novalidate-cert"<?php echo$rm['flag']=='novalidate-cert'?' selected="selected"':'';?>>novalidate-cert</option>
                <option value="validate-cert"<?php echo$rm['flag']=='validate-cert'?' selected="selected"':'';?>>validate-cert</option>
                <option value="norsh"<?php echo$rm['flag']=='norsh'?' selected="selected"':'';?>>norsh</option>
                <option value="ssl"<?php echo$rm['flag']=='ssl'?' selected="selected"':'';?>>ssl</option>
                <option value="notls"<?php echo$rm['flag']=='notls'?' selected="selected"':'';?>>notls</option>
                <option value="tls"<?php echo$rm['flag']=='tls'?' selected="selected"':'';?>>tls</option>
              </select>
              <div class="input-text">Server</div>
              <input id="url<?php echo$rm['id'];?>" name="url" type="text" value="<?php echo$rm['url'];?>" placeholder="Enter a Server" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`url`,$(this).val());">
              <div class="input-text">Username</div>
              <input id="mailusr<?php echo$rm['id'];?>" name="mailusr" type="text" value="<?php echo$rm['username'];?>" placeholder="Enter a Username..." onchange="update(`<?php echo$rm['id'];?>`,`choices`,`username`,$(this).val());">
              <div class="input-text">Password</div>
              <input id="mailpwd<?php echo$rm['id'];?>" name="mailpwd" type="text" value="<?php echo$rm['password'];?>" placeholder="Enter a Password..." onchange="update(`<?php echo$rm['id'];?>`,`choices`,`password`,$(this).val());">
              <form target="sp" action="core/purge.php">
                <input name="id" type="hidden" value="<?php echo$rm['id'];?>">
                <input name="t" type="hidden" value="choices">
                <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?php svg('trash');?></button>
              </form>
            </div>
          <?php }?>
        </div>
        <hr>
        <legend class="mt-3">AutoReply Email</legend>
        <div class="form-row">
          <label for="contactAutoReplySubject">Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{date}');return false;">{date}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="contactAutoReplySubject" type="text" value="<?php echo$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject">
          <button class="save" id="savecontactAutoReplySubject" data-tooltip="tooltip" data-dbid="contactAutoReplySubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="form-row mt-3">
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{subject}');return false;">{subject}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="contactAutoReplyLayout">
            <textarea class="summernote" id="contactAutoReplyLayout" name="da"><?php echo rawurldecode($config['contactAutoReplyLayout']);?></textarea>
          </form>
        </div>
        <hr>
        <legend class="mt-3">Email Signature</legend>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="email_signature">
            <textarea class="summernote" id="email_signature" name="da"><?php echo rawurldecode($config['email_signature']);?></textarea>
          </form>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
