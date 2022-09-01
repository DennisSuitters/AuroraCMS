<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Module - Edit
 * @package    core/layout/edit_module.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."modules` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid p-2">
      <div class="row">
        <div class="card col-12 col-sm mt-3 p-4 border-radius-0 bg-white border-0 shadow overflow-visible order-2 order-sm-1">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-6">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/course';?>">Courses</a></li>
                  <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                  <li class="breadcrumb-item active"><?=$r['title'];?></li>
                </ol>
              </div>
              <div class="col-12 col-sm-6 text-right">
                <div class="btn-group">
                  <?php if(isset($_SERVER['HTTP_REFERER'])){?>
                    <a class="btn" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>
                  <?php }?>
                  <button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Module</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Questions</label>
<?php /* Content */?>
            <div class="tab1-1 border-top p-4" data-tabid="tab1-1" role="tabpanel">
              <div class="form-row">
                <label id="moduleTitle" for="title"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/module/'.$r['id'].'#moduleTitle" data-tooltip="tooltip" aria-label="PermaLink to Module Title Field">&#128279;</a>':'';?>Title</label>
              </div>
              <div class="form-row">
                <input class="textinput" id="title" type="text" value="<?=$r['title'];?>" data-dbid="<?=$r['id'];?>" data-dbt="modules" data-dbc="title" data-bs="trash"<?=$user['options'][1]==1?'':' readonly';?>>
                <?=$user['options'][1]==1?
                '<button class="save" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <div class="form-row mt-3">
                <label id="moduleTime" for="tti"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/module/'.$r['id'].'#moduleTime" data-tooltip="tooltip" aria-label="PermaLink to Module Time Field">&#128279;</a>':'';?>Time to complete</label>
              </div>
              <div class="form-row">
                <select id="tti"<?=$user['options'][1]==1?' data-tooltip="tooltip" aria-label="Change Status"':' disabled';?> onchange="update('<?=$r['id'];?>','modules','tti',$(this).val(),'select');">
                  <option value="0"<?=$r['tti']==0?' selected':'';?>>Undetermined</option>
                  <option value="60"<?=$r['tti']==60?' selected':'';?>>1 Minute</option>
                  <option value="120"<?=$r['tti']==120?' selected':'';?>>2 Minutes</option>
                  <option value="300"<?=$r['tti']==300?' selected':'';?>>5 Minutes</option>
                  <option value="600"<?=$r['tti']==600?' selected':'';?>>10 Minutes</option>
                  <option value="900"<?=$r['tti']==900?' selected':'';?>>15 Minutes</option>
                  <option value="1800"<?=$r['tti']==1800?' selected':'';?>>30 Minutes</option>
                  <option value="2700"<?=$r['tti']==2700?' selected':'';?>>45 Minutes</option>
                  <option value="3600"<?=$r['tti']==3600?' selected':'';?>>1 Hour</option>
                  <option value="7200"<?=$r['tti']==7200?' selected':'';?>>2 Hours</option>
                  <option value="36000"<?=$r['tti']==36000?' selected':'';?>>10 Hours</option>
                  <option value="86400"<?=$r['tti']==86400?' selected':'';?>>1 Day</option>
                  <option value="172800"<?=$r['tti']==172800?' selected':'';?>>2 Days</option>
                  <option value="2592000"<?=$r['tti']==2592000?' selected':'';?>>1 Month</option>
                </select>
              </div>
              <div class="form-row mt-3">
                <label id="moduleCaption" for="title"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/module/'.$r['id'].'#moduleCaption" data-tooltip="tooltip" aria-label="PermaLink to Module Caption Field">&#128279;</a>':'';?>Caption</label>
              </div>
              <div class="form-row">
                <input class="textinput" id="caption" type="text" value="<?=$r['caption'];?>" data-dbid="<?=$r['id'];?>" data-dbt="modules" data-dbc="caption" data-bs="trash"<?=$user['options'][1]==1?'':' readonly';?>>
                <?=$user['options'][1]==1?
                '<button class="save" id="savecaption" data-dbid="caption" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <div class="row mt-3">
                <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'#summernote" data-tooltip="tooltip" aria-label="PermaLink to Course Notes">&#128279;</a>':'';?>
              </div>
              <div id="notesda" data-dbid="<?=$r['id'];?>" data-dbt="modules" data-dbc="notes"></div>
              <form id="summernote" target="sp" method="post" action="core/update.php" enctype="multipart/form-data">
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <input name="t" type="hidden" value="modules">
                <input name="c" type="hidden" value="notes">
                <textarea class="summernote" id="notes" data-dbid="<?=$r['id'];?>" data-dbt="modules" data-dbc="notes" name="da"><?= rawurldecode($r['notes']);?></textarea>
              </form>
            </div>
            <div class="tab1-2 border-top p-4" data-tabid="tab1-2" role="tabpanel">
              <div class="form-row">
                <label id="moduleQuestion" for="question"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/course/module/'.$r['id'].'#moduleQuestion" data-tooltip="tooltip" aria-label="PermaLink to Module Question Field">&#128279;</a>':'';?>Question</label>
              </div>
              <div class="form-row">
                <input class="textinput" id="question" type="text" value="<?=$r['question'];?>" data-dbid="<?=$r['id'];?>" data-dbt="modules" data-dbc="question" data-bs="trash"<?=$user['options'][1]==1?'':' readonly';?>>
                <?=$user['options'][1]==1?
                '<button class="save" id="savequestion" data-dbid="question" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
              <legend class="mt-3">Multiple-Choice Answers</legend>
              <form class="form-row" target="sp" method="post" action="core/add_question.php">
                <input name="rid" type="hidden" value="<?=$r['id'];?>">
                <select name="ct">
                  <option value="radio">Single Answer Option (Radio)</option>
                  <option value="checkbox">Multuple Answers Option (Checkbox)</option>
                </select>
                <div class="input-text">Correct Choice <input type="checkbox" name="a" value="1"></div>
                <input type="text" name="t" value="" placeholder="Enter Answer Selection...">
                <button class="add" data-tooltip="tooltip" aria-label="Add Answer" type="submit"><i class="i">add</i></button>
              </form>
              <hr>
              <ol id="questions" class="modules-list">
<?php $sq=$db->prepare("SELECT * FROM `".$prefix."module_questions` WHERE `rid`=:id ORDER BY `ord` ASC, `title` ASC");
$sq->execute([':id'=>$r['id']]);
while($rq=$sq->fetch(PDO::FETCH_ASSOC)){?>
                <li class="question mb-2" id="questions_<?=$rq['id'];?>">
                  <div class="form-row">
                    <div class="input-text"><?= ucwords($rq['type']);?></div>
                    <div class="input-text">Choice <input type="checkbox"<?=($rq['check_answer'][0]==1?' checked':'');?> disabled></div>
                    <div class="input-text">Answer:</div>
                    <input type="text" value="<?=$rq['title'];?>" readonly>
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$rq['id'];?>','module_questions');"><i class="i">trash</i></button>
                    <div class="handle btn" data-tooltip="tooltip" aria-label="Drag to ReOrder this item" onclick="return false;"><i class="i">drag</i></div>
                  </div>
                </li>
<?php }?>
              </ol>
            </div>
<?php if($user['options'][1]==1){?>
            <script>
              $('#questions').sortable({
                items:".question",
                placeholder:".ghost",
                helper:fixWidthHelper,
                update:function(e,ui){
                  var order=$("#questions").sortable("serialize");
                  $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"core/reorderquestions.php",
                    data:order
                  });
                }
              }).disableSelection();
              function fixWidthHelper(e,ui){
                ui.children().each(function(){
                  $(this).width($(this).width());
                });
                return ui;
              }
            </script>
        <?php }?>
        </div>
      </div>
<?php $sw=$db->prepare("SELECT * FROM `".$prefix."widgets` WHERE `ref`='content' AND `active`='1' ORDER BY ord ASC");
$sw->execute();
if($sw->rowCount()>0){
  echo'<div id="widgets" class="card col-12 col-sm-3 m-0 p-0 bg-transparent border-0 order-1 order-sm-2">';
  while($rw=$sw->fetch(PDO::FETCH_ASSOC)){
    include'core/layout/widget-'.$rw['file'];
  }
  echo'</div>';
}?>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
