<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Bookings
 * @package    core/layout/set_bookings.php
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
           <div class="content-title-icon"><?php svg('calendar','i-3x');?></div>
           <div>Bookings Settings</div>
           <div class="content-title-actions">
             <a class="btn" data-tooltip="tooltip" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
             <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?php svg('save');?></button>
           </div>
         </div>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
           <li class="breadcrumb-item active">Settings</li>
         </ol>
       </div>
     </div>
     <div class="container-fluid p-0">
       <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
         <div class="row mt-3">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#setArchiveBookings" aria-label="PermaLink to Account Activation Layout">&#128279;</a>':'';?>
          <input id="setArchiveBookings" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="25" type="checkbox"<?php echo$config['options'][25]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="setArchiveBookings">Archive Bookings when Converted to Invoice</label>
        </div>
        <legend id="setBookingAgreementTemplate" class="mt-3"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#setBookingAgreementTemplate" aria-label="PermaLink to Booking Agreement Template">&#128279;</a>':'';?>Booking Agreement Template</legend>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingAgreement">
            <textarea class="summernote" id="bookingNoteLayout" name="da"><?php echo rawurldecode($config['bookingAgreement']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="setBookingNotesTemplate" class="mt-3"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#setBookingNotesTemplate" aria-label="PermaLink to Bookings Notes Template">&#128279;</a>':'';?>Booking Notes Template</legend>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingNoteTemplate">
            <textarea class="summernote" id="bookingNoteLayout" name="da"><?php echo rawurldecode($config['bookingNoteTemplate']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="setBookingEmailTemplate" class="mt-3"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#setBookingEmailTemplate" aria-label="PermaLink to Booking Email Template">&#128279;</a>':'';?>Email Layout</legend>
        <div class="row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#setBookingReadReceipt" aria-label="PermaLink to Booking Read Reciept Checkbox">&#128279;</a>':'';?>
          <input id="setBookingReadReceipt" data-dbid="1" data-dbt="config" data-dbc="bookingEmailReadNotification" data-dbb="0" type="checkbox"<?php echo$config['bookingEmailReadNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="setBookingReadReceipt">Read Reciept</label>
        </div>
        <div id="bookingEmailSubject" class="form-row mt-3">
          <label for="bookingEmailSubject"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#bookingEmailSubject" aria-label="PermaLink to Booking Email Subject">&#128279;</a>':'';?>Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bES','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bES','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bES','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bES','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bES','{date}');return false;">{date}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="bES" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject" type="text" value="<?php echo$config['bookingEmailSubject'];?>">
          <button class="save" id="savebES" data-tooltip="tooltip" data-dbid="bES" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div id="bookingEmailLayout" class="form-row mt-3">
          <div class="form-text small text-muted text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bEL').summernote('insertText','{service}');return false;">{service}</a>
          </div>
        </div>
        <div class="form-row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#bookingEmailLayout" aria-label="PermaLink to Booking Email Layout">&#128279;</a>':'';?>
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingEmailLayout">
            <textarea class="summernote" id="bEL" name="da"><?php echo rawurldecode($config['bookingEmailLayout']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="autoReplySection" class="mt-3"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#autoReplySection" aria-label="PermaLink to Booking Auto Reply Email">&#128279;</a>':'';?>AutoReply Email</legend>
        <div id="autoReplySubject" class="form-row">
          <label for="bARSubject"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#autoReplySubject" aria-label="PermaLink to Booking AutoReply Subject">&#128279;</a>':'';?>Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('aRS','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('aRS','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('aRS','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('aRS','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('aRS','{date}');return false;">{date}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="aRS" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplySubject" type="text" value="<?php echo$config['bookingAutoReplySubject'];?>">
          <button class="save" id="savebaRS" data-tooltip="tooltip" data-dbid="aRS" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label id="autoReplyAttachment" for="bookingAttachment"><?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#autoReplyAttachment" aria-label="PermaLink to AutoReply Attacment">&#128279;</a>':'';?>File Attachment</label>
        <div class="form-row">
          <input id="bookingAttachment" name="feature_image" data-dbid="1" data-dbt="config" data-dbc="bookingsAttachment" type="text" value="<?php echo$config['bookingAttachment'];?>" readonly>
          <button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog('1','config','bookingAttachment');"><?php svg('browse-media');?></button>
          <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="coverUpdate('1','config','bookingAttachment','');"><?php svg('trash');?></button>
        </div>
        <div id="bookingAutoReplyLayout" class="form-row mt-3">
          <div class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#aRL').summernote('insertText','{service}');return false;">{service}</a>
          </div>
        </div>
        <div class="form-row">
          <?php echo$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings#bookingAutoReplyLayout" aria-label="PermaLink to Booking AutoReply Layout">&#128279;</a>':'';?>
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingAutoReplyLayout">
            <textarea class="summernote" id="aRL" name="da"><?php echo rawurldecode($config['bookingAutoReplyLayout']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
