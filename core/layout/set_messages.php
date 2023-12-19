<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Messages
 * @package    core/layout/set_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='38'");
$sv->execute();
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='32'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
                <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Webmail</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">AutoReply</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Signature</label>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <div class="form-row">
              <input id="storeMessages" data-dbid="1" data-dbt="config" data-dbc="storemessages" data-dbb="0" type="checkbox"<?=($config['storemessages']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="storeMessages">Store Contact Form Messages</label>
            </div>
            <div class="form-text">If no entries are made, an input text box will be used instead of a dropdown.<br>If email's are left blank, the messages will be sent to the site email set in <a href="<?= URL.$settings['system']['admin'];?>/preferences/contact#email">Preferences</a>.</div>
            <div class="row">
              <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md pl-2">Subject</div>
                  <div class="col-12 col-md pl-2">Email</div>
                </div>
              </article>
            </div>
            <?php if($user['options'][7]==1){?>
              <form class="row" target="sp" method="post" action="core/add_subject.php">
                <div class="col-12 col-md">
                  <input id="sub" name="sub" type="text" value="" placeholder="Enter a Subject...">
                </div>
                <div class="col-12 col-md">
                  <div class="form-row">
                    <input id="eml" name="eml" type="text" value="" placeholder="Enter an Email...">
                    <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                  </div>
                </div>
              </form>
            <?php }?>
            <div id="subjects">
              <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='subject' ORDER BY `title` ASC");
              $ss->execute();
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div class="row" id="l_<?=$rs['id'];?>">
                  <div class="col-12 col-md">
                    <div class="input-text"><?=$rs['title'];?></div>
                  </div>
                  <div class="col-12 col-md">
                    <div class="form-row">
                      <div class="input-text col-md"><?=$rs['url'];?></div>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$rs['id'];?>">
                        <input name="t" type="hidden" value="choices">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <label for="message_check_interval" class="mt-0">Check for new Messages every</label>
            <div class="form-row">
              <select id="message_check_interval"<?=($user['options'][7]==1?' onchange="update(`1`,`config`,`message_check_interval`,$(this).val(),`select`);"':' disabled');?>>
                <option value="0"<?=$config['message_check_interval']==0?' selected':'';?>>Disable Checking</option>
                <option value="1"<?=$config['message_check_interval']==1?' selected':'';?>>Every time Messages is opened</option>
                <option value="300"<?=$config['message_check_interval']==300?' selected':'';?>>5 Minutes</option>
                <option value="600"<?=$config['message_check_interval']==600?' selected':'';?>>10 Minutes</option>
                <option value="900"<?=$config['message_check_interval']==900?' selected':'';?>>15 Minutes</option>
                <option value="1800"<?=$config['message_check_interval']==1800?' selected':'';?>>30 Minutes</option>
                <option value="3600"<?=$config['message_check_interval']==3600?' selected':'';?>>1 Hour</option>
              </select>
            </div>
            <div class="form-row mt-3">
              <input id="deleteRetrievedMessages" data-dbid="1" data-dbt="login" data-dbc="options" data-dbb="9" type="checkbox"<?=($user['options'][9]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="deleteRetrievedMessages">Delete Retrieved Messages</label>
            </div>
            <legend class="mt-3">Mailboxes</legend>
            <div class="row">
              <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md pl-2">Type</div>
                  <div class="col-12 col-md pl-2">Port</div>
                  <div class="col-12 col-md pl-2">Flag</div>
                  <div class="col-12 col-md pl-2">Server</div>
                  <div class="col-12 col-md pl-2">Username</div>
                  <div class="col-12 col-md pl-2">Password</div>
                </div>
              </article>
            </div>
            <?php if($user['options'][7]==1){?>
              <form class="row" target="sp" method="post" action="core/add_mailbox.php">
                <input name="uid" type="hidden" value="<?=$user['id'];?>">
                <div class="col-12 col-md">
                  <select id="type" name="t" onchange="changePort($(this).val());">
                    <option value="imap">IMAP</option>
                    <option value="pop3">POP3</option>
                  </select>
                </div>
                <div class="col-12 col-md">
                  <input id="port" name="port" type="text" value="143">
                </div>
                <div class="col-12 col-md">
                  <select id="flag" name="f">
                    <option value="novalidate-cert">novalidate-cert</option>
                    <option value="validate-cert">validate-cert</option>
                    <option value="norsh">norsh</option>
                    <option value="ssl">ssl</option>
                    <option value="notls">notls</option>
                    <option value="tls">tls</option>
                  </select>
                </div>
                <div class="col-12 col-md">
                  <input id="url" name="url" type="text" value="" placeholder="Enter a Server">
                </div>
                <div class="col-12 col-md">
                  <input id="mailusr" name="mailusr" type="text" value="" placeholder="Enter a Username...">
                </div>
                <div class="col-12 col-md">
                  <div class="form-row">
                    <input id="mailpwd" name="mailpwd" type="text" value="" placeholder="Enter a Password">
                    <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
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
            <?php }?>
            <div id="mailboxes">
              <?php $sm=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='mailbox' AND `uid`=:uid ORDER BY `url`");
              $sm->execute([':uid'=>$user['id']]);
              while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
                <div class="row" id="l_<?=$rm['id'];?>">
                  <div class="col-12 col-md">
                    <select id="type<?=$rm['id'];?>"<?=($user['options'][7]==1?' onchange="update(`'.$rm['id'].'`,`choices`,`type`,$(this).val());"':' disabled');?>>
                      <option value="imap"<?=$rm['type']=='imap'?' selected':'';?>>IMAP</option>
                      <option value="pop3"<?=$rm['type']=='pop3'?' selected':'';?>>POP3</option>
                    </select>
                  </div>
                  <div class="col-12 col-md">
                    <input id="port<?=$rm['id'];?>" type="text" value="<?=$rm['port'];?>"<?=($user['options'][7]==1?' onchange="update(`'.$rm['id'].'`,`choices`,`port`,$(this).val());"':' disabled');?>>
                  </div>
                  <div class="col-12 col-md">
                    <select id="flag"<?=($user['options'][7]==1?' onchange="update(`'.$rm['id'].'`,`choices`,`flag`,$(this).val(),`select`);"':' disabled');?>>
                      <option value="novalidate-cert"<?=$rm['flag']=='novalidate-cert'?' selected':'';?>>novalidate-cert</option>
                      <option value="validate-cert"<?=$rm['flag']=='validate-cert'?' selected':'';?>>validate-cert</option>
                      <option value="norsh"<?=$rm['flag']=='norsh'?' selected':'';?>>norsh</option>
                      <option value="ssl"<?=$rm['flag']=='ssl'?' selected':'';?>>ssl</option>
                      <option value="notls"<?=$rm['flag']=='notls'?' selected':'';?>>notls</option>
                      <option value="tls"<?=$rm['flag']=='tls'?' selected':'';?>>tls</option>
                    </select>
                  </div>
                  <div class="col-12 col-md">
                    <input id="url<?=$rm['id'];?>" name="url" type="text" value="<?=$rm['url'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Server" onchange="update(`'.$rm['id'].'`,`choices`,`url`,$(this).val());"':' disabled');?>>
                  </div>
                  <div class="col-12 col-md">
                    <input id="mailusr<?=$rm['id'];?>" name="mailusr" type="text" value="<?=$rm['username'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Username..." onchange="update(`'.$rm['id'].'`,`choices`,`username`,$(this).val());"':' disabled');?>>
                  </div>
                  <div class="col-12 col-md">
                    <div class="form-row">
                      <input id="mailpwd<?=$rm['id'];?>" name="mailpwd" type="text" value="<?=$rm['password'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Password..." onchange="update(`'.$rm['id'].'`,`choices`,`password`,$(this).val());"':' disabled');?>>
                      <?php if($user['options'][7]==1){?>
                        <form target="sp" action="core/purge.php">
                          <input name="id" type="hidden" value="<?=$rm['id'];?>">
                          <input name="t" type="hidden" value="choices">
                          <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                        </form>
                      <?php }?>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
          <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
            <label for="aRS" class="mt-0">Subject</label>
            <?php if($user['options'][7]==1){?>
              <div class="form-text">Tokens:
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aRS','{business}');return false;">{business}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aRS','{date}');return false;">{date}</a>
              </div>
            <?php }?>
            <div class="form-row">
              <input class="textinput" id="aRS" type="text" value="<?=$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject"<?=($user['options'][7]==1?' placeholder="Enter an Auto Reply Email Subject"':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="saveaRS" data-dbid="aRS" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="aRL" onclick="$('#aRL').summernote({focus:true});">Body</label>
            <div class="row">
              <?php if($user['options'][7]==1){?>
                <div class="form-text">Tokens:
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{business}');return false;">{business}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{date}');return false;">{date}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{name}');return false;">{name}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{subject}');return false;">{subject}</a>
                </div>
                <form class="w-100" method="post" target="sp" action="core/update.php">
                  <input name="id" type="hidden" value="1">
                  <input name="t" type="hidden" value="config">
                  <input name="c" type="hidden" value="contactAutoReplyLayout">
                  <textarea class="summernote" id="aRL" name="da"><?= rawurldecode($config['contactAutoReplyLayout']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin mt-3">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-viewport-area">
                        <div class="note-editable">
                          <?= rawurldecode($config['contactAutoReplyLayout']);?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
          <div class="tab1-4 border p-3" data-tabod="tab1-4" role="tabpanel">
            <div class="row mt-1">
              <?php if($user['options'][7]==1){?>
                <form class="w-100" method="post" target="sp" action="core/update.php">
                  <input name="id" type="hidden" value="1">
                  <input name="t" type="hidden" value="config">
                  <input name="c" type="hidden" value="email_signature">
                  <textarea class="summernote" id="email_signature" name="da"><?= rawurldecode($config['email_signature']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-viewport-area">
                        <div class="note-editable">
                          <?= rawurldecode($config['email_signature']);?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
