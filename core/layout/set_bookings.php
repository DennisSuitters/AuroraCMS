<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Bookings
 * @package    core/layout/set_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 */?>
<main id="content" class="main position-relative">
  <ol class="breadcrumb shadow">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <legend>Email Layout</legend>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="bookingEmailReadNotification" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="bookingEmailReadNotification" data-dbb="0"<?php echo$config['bookingEmailReadNotification']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="bookingEmailReadNotification" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Read Reciept</label>
        </div>
        <div class="help-block text-right"><small>Tokens:</small>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{business}');return false;">{business}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{name}');return false;">{name}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{first}');return false;">{first}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{last}');return false;">{last}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{date}');return false;">{date}</a>
        </div>
        <div class="form-group row">
          <label for="bookingEmailSubject" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Subject</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="bookingEmailSubject" class="form-control textinput" value="<?php echo$config['bookingEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" data-title="Save"><button id="savebookingEmailSubject" class="btn btn-secondary save" data-dbid="bookingEmailSubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bookingEmailLayout" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Layout</label>
          <div class="input-group card-header col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10 p-0">
            <div class="col text-right"><small>Tokens:</small>
              <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{business}');return false;">{business}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{name}');return false;">{name}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{first}');return false;">{first}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{last}');return false;">{last}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{date}');return false;">{date}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{service}');return false;">{service}</a>
            </div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="bookingEmailLayout">
              <textarea id="bookingEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingEmailLayout']);?></textarea>
            </form>
          </div>
        </div>
        <hr>
        <legend>AutoReply Email</legend>
        <div class="help-block text-right"><small>Tokens:</small>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{business}');return false;">{business}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{name}');return false;">{name}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{first}');return false;">{first}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{last}');return false;">{last}</a>
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{date}');return false;">{date}</a>
        </div>
        <div class="form-group row">
          <label for="bookingAutoReplySubject" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Subject</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="bookingAutoReplySubject" class="form-control textinput" value="<?php echo$config['bookingAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplySubject">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savebookingAutoReplySubject" class="btn btn-secondary save" data-dbid="bookingAutoReplySubject" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bookingAttachment" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">File Attachment</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="bookingAttachment" class="form-control" name="feature_image" value="<?php echo$config['bookingAttachment'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingsAttachment" readonly>
            <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('1','config','bookingAttachment');" data-tooltip="tooltip" data-title="Open Media Manager" aria-label="Open Media Manager"><?php svg('browse-media');?></button></div>
            <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('1','config','bookingAttachment','');" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bookingAutoReplyLayout" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Layout</label>
          <div class="input-group card-header col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10 p-0">
            <div class="col text-right"><small>Tokens:</small>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{business}');return false;">{business}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{name}');return false;">{name}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{first}');return false;">{first}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{last}');return false;">{last}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{date}');return false;">{date}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{booking_date}');return false;">{booking_date}</a>
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{service}');return false;">{service}</a>
            </div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="bookingAutoReplyLayout">
              <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingAutoReplyLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
