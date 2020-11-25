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
             <a class="btn" data-tooltip="tooltip" data-placement="left" data-title="Back" href="<?php echo$_SERVER['HTTP_REFERER'];?>" aria-label="Back"><?php svg('back');?></a>
             <button data-tooltip="tooltip" data-title="Toggle Fullscreen" aria-label"Toggle Fullscreen" onclick="toggleFullscreen();"><?php svg('fullscreen');?></button>
             <button class="saveall" data-tooltip="tooltip" data-placement="left" data-title="Save All Edited Fields" aria-label="Save All Edited Fields"><?php svg('save');?></button>
           </div>
         </div>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
           <li class="breadcrumb-item active">Settings</li>
         </ol>
       </div>
     </div>
     <div class="container-fluid p-0">
       <div class="card border-radius-0 shadow p-3">
         <div class="row mt-3">
          <input id="options25" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="25" type="checkbox"<?php echo$config['options'][25]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options25">Archive Bookings when Converted to Invoice</label>
        </div>
        <legend class="mt-3">Booking Agreement Template</legend>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingAgreement">
            <textarea class="summernote" id="bookingNoteLayout" name="da"><?php echo rawurldecode($config['bookingAgreement']);?></textarea>
          </form>
        </div>
        <legend class="mt-3">Booking Notes Template</legend>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingNoteTemplate">
            <textarea class="summernote" id="bookingNoteLayout" name="da"><?php echo rawurldecode($config['bookingNoteTemplate']);?></textarea>
          </form>
        </div>
        <legend class="mt-3">Email Layout</legend>
        <div class="row">
          <input id="bookingEmailReadNotification" data-dbid="1" data-dbt="config" data-dbc="bookingEmailReadNotification" data-dbb="0" type="checkbox"<?php echo$config['bookingEmailReadNotification'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="bookingEmailReadNotification">Read Reciept</label>
        </div>
        <div class="form-row mt-3">
          <label for="bookingEmailSubject">Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{date}');return false;">{date}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="bookingEmailSubject" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject" type="text" value="<?php echo$config['bookingEmailSubject'];?>">
          <button class="save" id="savebookingEmailSubject" data-tooltip="tooltip" data-title="Save" data-dbid="bookingEmailSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <div class="form-row mt-3">
          <small class="form-text small text-muted text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{service}');return false;">{service}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingEmailLayout">
            <textarea class="summernote" id="bookingEmailLayout" name="da"><?php echo rawurldecode($config['bookingEmailLayout']);?></textarea>
          </form>
        </div>
        <legend class="mt-3">AutoReply Email</legend>
        <div class="form-row">
          <label for="bookingAutoReplySubject">Subject</label>
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{date}');return false;">{date}</a>
          </small>
        </div>
        <div class="form-row">
          <input class="textinput" id="bookingAutoReplySubject" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplySubject" type="text" value="<?php echo$config['bookingAutoReplySubject'];?>">
          <button class="save" id="savebookingAutoReplySubject" data-tooltip="tooltip" data-title="Save" data-dbid="bookingAutoReplySubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button>
        </div>
        <label for="bookingAttachment">File Attachment</label>
        <div class="form-row">
          <input id="bookingAttachment" name="feature_image" data-dbid="1" data-dbt="config" data-dbc="bookingsAttachment" type="text" value="<?php echo$config['bookingAttachment'];?>" readonly>
          <button data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager" onclick="elfinderDialog('1','config','bookingAttachment');"><?php svg('browse-media');?></button>
          <button class="trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete" onclick="coverUpdate('1','config','bookingAttachment','');"><?php svg('trash');?></button>
        </div>
        <div class="form-row mt-3">
          <small class="form-text text-right">Tokens:
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
            <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{service}');return false;">{service}</a>
          </small>
        </div>
        <div class="form-row">
          <form class="w-100" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="bookingAutoReplyLayout">
            <textarea class="summernote" id="orderEmailLayout" name="da"><?php echo rawurldecode($config['bookingAutoReplyLayout']);?></textarea>
          </form>
        </div>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
