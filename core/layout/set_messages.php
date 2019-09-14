<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Messages
 * @package    core/layout/set_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Option to not store messages.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <legend>Contact Form</legend>
        <div class="form-group row">
          <div class="input-group col-sm-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="storemessages0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="storemessages" data-dbb="0"<?php echo$config['storemessages']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="storemessages0" class="col-form-label col-sm-6">Store Contact Form Messages</label>
        </div>
        <div class="help-block small text-muted text-right">If no entries are made, an input text box will be used instead of a dropdown. If email's are left blank, the messages will be sent to the site email set in <a href="<?php echo URL.$settings['system']['admin'];?>/preferences/contact#email">Preferences</a>.</div>
        <form target="sp" method="post" action="core/add_data.php">
          <input type="hidden" name="act" value="add_subject">
          <div class="form-group row">
            <div class="input-group">
              <label for="sub" class="input-group-text">Subject</label>
              <input type="text" id="sub" class="form-control" name="sub" value="" placeholder="Enter a Subject...">
              <label for="eml" class="input-group-text">Email</label>
              <input type="text" id="eml" class="form-control" name="eml" value="" placeholder="Enter an Email...">
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="Add" aria-label="Add"><?php svg('add');?></button></div>
            </div>
          </div>
        </form>
        <div id="subjects">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group">
              <div class="input-group-text">Subject</div>
              <input type="text" id="sub<?php echo$r['id'];?>" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','subject','title',$(this).val());">
              <div class="input-group-text">Email</div>
              <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','subject','url',$(this).val());">
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
        <legend>Webmail</legend>
        <div class="form-group row">
          <div class="input-group">
            <label for="message_check_interval" class="input-group-text">Check for new Messages every</label>
            <select id="message_check_interval" class="form-control" onchange="update('1','config','message_check_interval',$(this).val());">
              <option value="0"<?php echo$config['message_check_interval']==0?' selected="selected"':'';?>>Disable Checking</option>
              <option value="1"<?php echo$config['message_check_interval']==1?' selected="selected"':'';?>>Every time Messages is opened</option>
              <option value="300"<?php echo$config['message_check_interval']==300?' selected="selected"':'';?>>5 Minutes</option>
              <option value="600"<?php echo$config['message_check_interval']==600?' selected="selected"':'';?>>10 Minutes</option>
              <option value="900"<?php echo$config['message_check_interval']==900?' selected="selected"':'';?>>15 Minutes</option>
              <option value="1800"<?php echo$config['message_check_interval']==1800?' selected="selected"':'';?>>30 Minutes</option>
              <option value="3600"<?php echo$config['message_check_interval']==3600?' selected="selected"':'';?>>1 Hour</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="input-group col-sm-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options9" class="switch-input" data-dbid="1" data-dbt="login" data-dbc="options" data-dbb="9"<?php echo$user['options']{9}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options9" class="col-form-label col-sm-4">Delete Messages When Retrieved</label>
        </div>
        <h4>Mailboxes</h4>
        <form target="sp" method="post" action="core/add_mailbox.php">
          <input type="hidden" name="uid" value="<?php echo$user['id'];?>">
          <div class="form-group row">
            <div class="input-group">
              <label for="type" class="input-group-text">Type</label>
              <select id="type" class="form-control" name="t" onchange="changePort($(this).val());">
                <option value="imap">IMAP</option>
                <option value="pop3">POP3</option>
              </select>
              <label for="port" class="input-group-text">Port</label>
              <input type="text" id="port" class="form-control" name="port" value="143">
              <label for="flag" class="input-group-text">Flag</label>
              <select id="flag" class="form-control" name="f">
                <option value="novalidate-cert">novalidate-cert</option>
                <option value="validate-cert">validate-cert</option>
                <option value="norsh">norsh</option>
                <option value="ssl">ssl</option>
                <option value="notls">notls</option>
                <option value="tls">tls</option>
              </select>
            </div>
            <div class="input-group">
              <label for="url" class="input-group-text">Server</label>
              <input type="text" id="url" class="form-control" name="url" value="" placeholder="Enter a Server">
              <label for="mailusr" class="input-group-text">Username</label>
              <input type="text" id="mailusr" class="form-control" name="mailusr" value="" placeholder="Enter a Username...">
              <label for="mailpwd" class="input-group-text">Password</label>
              <input type="text" id="mailpwd" class="form-control" name="mailpwd" value="" placeholder="Enter a Password">
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="Add" aria-label="Add"><?php svg('add');?></button></div>
            </div>
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
        <hr>
        <div id="mailboxes">
<?php $sm=$db->prepare("SELECT * FROM choices WHERE contentType='mailbox' AND uid=:uid ORDER BY url");
$sm->execute([':uid'=>$user['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rm['id'];?>" class="form-group row">
            <div class="input-group">
              <label for="type<?php echo$rm['id'];?>" class="input-group-text">Type</label>
              <select id="type<?php echo$rm['id'];?>" class="form-control" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`type`,$(this).val());">
                <option value="imap"<?php echo$rm['type']=='imap'?' selected="selected"':'';?>>IMAP</option>
                <option value="pop3"<?php echo$rm['type']=='pop3'?' selected="selected"':'';?>>POP3</option>
              </select>
              <label for="port<?php echo$rm['id'];?>" class="input-group-text">Port</label>
              <input type="text" id="port<?php echo$rm['id'];?>" class="form-control" value="<?php echo$rm['port'];?>" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`port`,$(this).val());">
              <label for="flag<?php echo$rm['id'];?>" class="input-group-text">Flag</label>
              <select id="flag" class="form-control" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`flag`,$(this).val());">
                <option value="novalidate-cert"<?php echo$rm['flag']=='novalidate-cert'?' selected="selected"':'';?>>novalidate-cert</option>
                <option value="validate-cert"<?php echo$rm['flag']=='validate-cert'?' selected="selected"':'';?>>validate-cert</option>
                <option value="norsh"<?php echo$rm['flag']=='norsh'?' selected="selected"':'';?>>norsh</option>
                <option value="ssl"<?php echo$rm['flag']=='ssl'?' selected="selected"':'';?>>ssl</option>
                <option value="notls"<?php echo$rm['flag']=='notls'?' selected="selected"':'';?>>notls</option>
                <option value="tls"<?php echo$rm['flag']=='tls'?' selected="selected"':'';?>>tls</option>
              </select>
            </div>
            <div class="input-group">
              <label for="url<?php echo$rm['id'];?>" class="input-group-text">Server</label>
              <input type="text" id="url<?php echo$rm['id'];?>" class="form-control" name="url" value="<?php echo$rm['url'];?>" placeholder="Enter a Server" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`url`,$(this).val());">
              <label for="mailusr<?php echo$rm['id'];?>" class="input-group-text">Username</label>
              <input type="text" id="mailusr<?php echo$rm['id'];?>" class="form-control" name="mailusr" value="<?php echo$rm['username'];?>" placeholder="Enter a Username..." onchange="update(`<?php echo$rm['id'];?>`,`choices`,`username`,$(this).val());">
              <label for="mailpwd<?php echo$rm['id'];?>" class="input-group-text">Password</label>
              <input type="text" id="mailpwd<?php echo$rm['id'];?>" class="form-control" name="mailpwd" value="<?php echo$rm['password'];?>" placeholder="Enter a Password..." onchange="update(`<?php echo$rm['id'];?>`,`choices`,`password`,$(this).val());">
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rm['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
        <legend>AutoReply Email</legend>
        <div class="col-12 text-right"><small>Tokens:</small> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{business}');return false;">{business}</a> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{date}');return false;">{date}</a>
        </div>
        <div class="form-group row">
          <label for="contactAutoReplySubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <input type="text" id="contactAutoReplySubject" class="form-control textinput" value="<?php echo$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecontactAutoReplySubject" class="btn btn-secondary save" data-dbid="contactAutoReplySubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="contactAutoReplyLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="input-group card-header col-sm-10 p-0">
            <div class="col text-right"><small>Tokens:</small> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{business}');return false;">{business}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{date}');return false;">{date}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{name}');return false;">{name}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{subject}');return false;">{subject}</a>
            </div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="contactAutoReplyLayout">
              <textarea id="contactAutoReplyLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['contactAutoReplyLayout']);?></textarea>
            </form>
          </div>
        </div>
        <hr>
        <legend>Email Signature</legend>
        <div role="tabpanel" class="tab-pane" id="account-messages">
          <div class="form-group row">
            <label for="email_signature" class="col-form-label col-sm-2">Signature</label>
            <div class="col-sm-10">
              <div class="card-header p-0">
                <form method="post" target="sp" action="core/update.php">
                  <input type="hidden" name="id" value="1">
                  <input type="hidden" name="t" value="config">
                  <input type="hidden" name="c" value="email_signature">
                  <textarea id="email_signature" class="form-control summernote" name="da"><?php echo rawurldecode($config['email_signature']);?></textarea>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
