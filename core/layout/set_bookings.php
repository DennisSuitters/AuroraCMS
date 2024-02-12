<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Bookings
 * @package    core/layout/set_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id` IN ('32','40')")->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group d-inline">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <?='<input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>'.
          '<label for="tab1-1">General</label>'.
          '<input class="tab-control" id="tab1-2" name="tabs" type="radio">'.
          '<label for="tab1-2">Agreement</label>'.
          '<input class="tab-control" id="tab1-3" name="tabs" type="radio">'.
          '<label for="tab1-3">Notes</label>'.
          '<input class="tab-control" id="tab1-4" name="tabs" type="radio">'.
          '<label for="tab1-4">Email</label>'.
          '<input class="tab-control" id="tab1-5" name="tabs" type="radio">'.
          '<label for="tab1-5">AutoReply</label>';?>
<?php /* General */ ?>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <div class="form-row">
              <input id="createEventInvoice" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="6" type="checkbox"<?=($config['options'][6]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="createEventInvoice">Create Invoice when Event is Booked.</label>
            </div>
            <div class="form-row">
              <input id="createServiceInvoice" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="29" type="checkbox"<?=($config['options'][29]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="createServiceInvoice">Create Invoice when Service is Booked.</label>
            </div>
            <label for="bookingBuffer">Buffer Time</label>
            <div class="form-row">
              <select id="bookingBuffer" data-dbid="1" data-dbt="config" data-dbc="bookingBuffer"<?=($user['options'][7]==1?' onchange="update(`1`,`config`,`bookingBuffer`,$(this).val(),`select`);"':' disabled');?>>
                <option value="0"<?=$config['bookingBuffer']==0?' selected':'';?>>No Buffer Time</option>
                <option value="600"<?=$config['bookingBuffer']==600?' selected':'';?>>10 Minutes</option>
                <option value="900"<?=$config['bookingBuffer']==900?' selected':'';?>>15 Minutes</option>
                <option value="1800"<?=$config['bookingBuffer']==1800?' selected':'';?>>30 Minutes</option>
                <option value="3600"<?=$config['bookingBuffer']==3600?' selected':'';?>>1 Hour</option>
                <option value="7200"<?=$config['bookingBuffer']==7200?' selected':'';?>>2 Hour</option>
                <option value="10800"<?=$config['bookingBuffer']==10800?' selected':'';?>>3 Hours</option>
                <option value="21600"<?=$config['bookingBuffer']==21600?' selected':'';?>>6 Hours</option>
                <option value="43200"<?=$config['bookingBuffer']==43200?' selected':'';?>>12 Hours</option>
                <option value="86400"<?=$config['bookingBuffer']==86400?' selected':'';?>>24 Hours</option>
              </select>
            </div>
            <div class="form-row mt-3 mb-2">
              <input id="setArchiveBookings" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="25" type="checkbox"<?=($config['options'][25]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="setArchiveBookings">Archive Bookings when Converted to Invoice</label>
            </div>
          </div>
<?php /* Agreement */ ?>
          <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
            <div class="row">
              <?php if($user['options'][7]==1){?>
                <form class="w-100" method="post" target="sp" action="core/update.php">
                  <input name="id" type="hidden" value="1">
                  <input name="t" type="hidden" value="config">
                  <input name="c" type="hidden" value="bookingAgreement">
                  <textarea class="summernote" name="da"><?= rawurldecode($config['bookingAgreement']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-viewport-area">
                        <div class="note-editable">
                          <?= rawurldecode($config['bookingAgreement']);?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
<?php /* Notes */ ?>
          <div class="tab1-3 border p-3" data-tabid="tab1-3" role="tabpanel">
            <div class="row">
              <?php if($user['options'][7]==1){?>
                <form class="w-100" method="post" target="sp" action="core/update.php">
                  <input name="id" type="hidden" value="1">
                  <input name="t" type="hidden" value="config">
                  <input name="c" type="hidden" value="bookingNoteTemplate">
                  <textarea class="summernote" name="da"><?= rawurldecode($config['bookingNoteTemplate']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-viewport-area">
                        <div class="note-editable">
                          <?= rawurldecode($config['bookingNoteTemplate']);?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
<?php /* Email */ ?>
          <div class="tab1-4 border p-3" data-tabid="tab1-4" role="tabpanel">
            <div class="form-row">
              <input id="setBookingReadReceipt" data-dbid="1" data-dbt="config" data-dbc="bookingEmailReadNotification" data-dbb="0" type="checkbox"<?=($config['bookingEmailReadNotification']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="setBookingReadReceipt">Read Reciept</label>
            </div>
            <label for="bES">Subject</label>
            <?php if($user['options'][7]==1){?>
              <div class="form-text">Tokens:
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('bES','{business}');return false;">{business}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('bES','{name}');return false;">{name}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('bES','{first}');return false;">{first}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('bES','{last}');return false;">{last}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('bES','{date}');return false;">{date}</a>
              </div>
            <?php }?>
            <div class="form-row">
              <input class="textinput" id="bES" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject" type="text" value="<?=$config['bookingEmailSubject'];?>"<?=($user['options'][7]==1?' placeholder="Enter an Email Booking Subject..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savebES" data-dbid="bES" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="bEL" onclick="$('#bEL').summernote({focus:true});">Body</label>
            <div class="row">
              <?php if($user['options'][7]==1){?>
                <div class="form-text">Tokens:
                  <a class="badger badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{business}');return false;">{business}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{name}');return false;">{name}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{first}');return false;">{first}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{last}');return false;">{last}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{date}');return false;">{date}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{service}');return false;">{service}</a>
                </div>
                <form class="w-100" method="post" target="sp" action="core/update.php">
                  <input name="id" type="hidden" value="1">
                  <input name="t" type="hidden" value="config">
                  <input name="c" type="hidden" value="bookingEmailLayout">
                  <textarea class="summernote" id="bEL" name="da"><?= rawurldecode($config['bookingEmailLayout']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-viewport-area">
                        <div class="note-editable">
                          <?= rawurldecode($config['bookingEmailLayout']);?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
<?php /* AutoReply */ ?>
          <div class="tab1-5 border p-3" data-tabid="tab1-5" role="tabpanel">
            <label for="aRS" class="mt-0">Subject</label>
            <?php if($user['options'][7]==1){?>
              <div class="form-text">Tokens:
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aRS','{business}');return false;">{business}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aRS','{name}');return false;">{name}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aRS','{first}');return false;">{first}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aRS','{last}');return false;">{last}</a>
                <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aRS','{date}');return false;">{date}</a>
              </div>
            <?php }?>
            <div class="form-row">
              <input class="textinput" id="aRS" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplySubject" type="text" value="<?=$config['bookingAutoReplySubject'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Booking Auto Reply Subject..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savebaRS" data-dbid="aRS" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
            <label for="bookingAttachment">File Attachment</label>
            <div class="form-row">
              <input id="bookingAttachment" name="feature_image" data-dbid="1" data-dbt="config" data-dbc="bookingsAttachment" type="text" value="<?=$config['bookingAttachment'];?>"<?=($user['options'][7]==1?'':' disabled');?>>
              <?=($user['options'][7]==1?'<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`1`,`config`,`bookingAttachment`);"><i class="i">browse-media</i></button>'.
              '<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate(`1`,`config`,`bookingAttachment`,``);"><i class="i">trash</i></button>':'');?>
            </div>
            <label for="aRL" onclick="$('#aRL').summernote({focus:true});">Body</label>
            <div class="row">
              <?php if($user['options'][7]==1){?>
                <div class="form-text">Tokens:
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{business}');return false;">{business}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{name}');return false;">{name}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{first}');return false;">{first}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{last}');return false;">{last}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{date}');return false;">{date}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{service}');return false;">{service}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{event}');return false;">{event}</a>
                  <a class="badger badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{externalLink}');return false;">{externalLink}</a>
                </div>
                <form class="w-100" method="post" target="sp" action="core/update.php">
                  <input name="id" type="hidden" value="1">
                  <input name="t" type="hidden" value="config">
                  <input name="c" type="hidden" value="bookingAutoReplyLayout">
                  <textarea class="summernote" id="aRL" name="da"><?= rawurldecode($config['bookingAutoReplyLayout']);?></textarea>
                </form>
              <?php }else{?>
                <div class="note-admin mt-3">
                  <div class="note-editor note-frame">
                    <div class="note-editing-area">
                      <div class="note-viewport-area">
                        <div class="note-editable">
                          <?= rawurldecode($config['bookingAutoReplyLayout']);?>
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
