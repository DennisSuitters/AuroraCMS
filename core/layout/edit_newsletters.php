<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Newsletters - Edit
 * @package    core/layout/edit_newsletters.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 */
$q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
$q->execute([':id'=>$args[1]]);
$r=$q->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>">Newsletters</a></li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active" aria-current="page"><strong id="titleupdate"><?php echo$r['title'];?></strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" data-title="Back" aria-label="Back"><?php svg('back');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/newsletter.php?id=<?php echo$r['id'];?>&act=');return false;" data-tooltip="tooltip" data-placement="left" data-title="Send Newsletters" aria-label="Send Newsletters"><?php svg('email-send');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div id="notification" role="alert"></div>
        <div class="form-group row">
          <label for="title" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Subject</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" placeholder="Enter a Subject..." onkeyup="$('#titleupdate').text($(this).val());">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ti" class="control-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Created</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="ti" class="form-control" value="<?php echo date('M jS, Y g:i A',$r['ti']);?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="published" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Status</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo$user['options']{1}==0?' readonly':'';?>>
              <option value="unpublished"<?php echo$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
              <option value="published"<?php echo$r['status']=='published'?' selected':'';?>>Published</option>
              <option value="delete"<?php echo$r['status']=='delete'?' selected':'';?>>Delete</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2"></label>
          <div class="input-group card-header col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10 p-0">
            <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
            <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="content">
              <input type="hidden" name="c" value="notes">
              <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
