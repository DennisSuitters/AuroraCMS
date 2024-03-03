<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Roster - Edit
 * @package    core/layout/edit_roster.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `id`=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/roster';?>">Roster</a></li>
                <li class="breadcrumb-item active"><span id="rostertitle"><?=$r['title'];?></span></li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group d-inline">
                <?=(isset($_SERVER['HTTP_REFERER'])?'<a class="btn" href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                ($user['options'][2]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs border p-3">
          <div class="row">
            <div class="col-12 col-sm">
              <label for="name" class="mt-0">Shift Title</label>
              <div class="form-row">
                <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="roster" data-dbc="title" type="text" value="<?=$r['title'];?>"<?=$user['options'][2]==1?' placeholder="Enter a Shift Title..."':' readonly';?> onkeyup="$('#rostertitle').html($(this).val());">
                <?=$user['options'][2]==1?'<button class="save" id="savename" data-dbid="name" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
              </div>
            </div>
            <div class="col-12 col-sm pl-sm-3">
              <label for="status" class="mt-sm-0">Status</label>
              <div class="form-row">
                <select id="status" data-dbid="<?=$r['id'];?>" data-dbt="roster" data-dbc="status" onchange="update('<?=$r['id'];?>','roster','status',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
                  <option value="available"<?=($r['status']=='available'?' selected':'');?>>Available</option>
                  <option value="accepted"<?=($r['status']=='accepted'?' selected':'');?>>Accepted</option>
                  <option value="rostered"<?=($r['status']=='rostered'?' selected':'');?>>Rostered</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm">
              <label for="tis">Date From <span class="labeldate" id="labeldatetis">(<?= date($config['dateFormat'],$r['tis']);?>)</span></label>
              <div class="form-row">
                <input id="tis" type="datetime-local" value="<?= date('Y-m-d\TH:i',$r['tis']);?>" autocomplete="off" onchange="update(`<?=$r['id'];?>`,`roster`,`tis`,getTimestamp(`tis`),`select`);"<?=$user['options'][2]==1?'':' disabled';?>>
              </div>
            </div>
            <div class="col-12 col-sm pl-sm-3">
              <label for="tie">Date To <span class="labeldate" id="labeldatetie">(<?= date($config['dateFormat'],($r['tie']==0?$r['tis']:$r['tie']));?>)</span></label>
              <div class="form-row">
                <input id="tie" type="datetime-local" value="<?= date('Y-m-d\TH:i',($r['tie']==0?$r['tis']:$r['tie']));?>" autocomplete="off" onchange="update(`<?=$r['id'];?>`,`roster`,`tie`,getTimestamp(`tie`),`select`);"<?=$user['options'][2]==1?'':' disabled';?>>
              </div>
            </div>
          </div>
          <?php $se=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `employee`=1 ORDER BY `name` ASC, `username` ASC");
          $se->execute();?>
          <label for="uid">Employee</label>
          <div class="form-row">
            <select id="uid" data-dbid="<?=$r['id'];?>" data-dbt="roster" data-dbc="uid" onchange="update('<?=$r['id'];?>','roster','uid',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
              <option value="0">Select an Employee...</option>
              <?php while($re=$se->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$re['id'].'"'.($r['uid']==$re['id']?' selected':'').'>'.($re['name']!=''?$re['name']:$re['username']).'</option>';?>
            </select>
          </div>
          <label for="notes">Notes</label>
          <div class="form-row">
            <?=($user['options'][2]==1?
              '<form class="w-100" id="summernote" target="sp" method="post" action="core/update.php">'.
                '<input name="id" type="hidden" value="'.$r['id'].'">'.
                '<input name="t" type="hidden" value="roster">'.
                '<input name="c" type="hidden" value="notes">'.
                '<textarea class="notes" id="notes" name="da">'.rawurldecode($r['notes']).'</textarea>'.
              '</form>'
            :
              ($r['notes']!=''?
                '<div class="note-admin w-100">'.
                  '<div class="note-editor note-frame">'.
                    '<div class="note-editing-area">'.
                      '<div class="note-viewport-area">'.
                        '<div class="note-editable">'.rawurldecode($r['notes']).'</div>'.
                      '</div>'.
                    '</div>'.
                  '</div>'.
                '</div>'
              :
                ''
              )
            );?>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
<script>
  $(document).ready(function(){
    $('.notes').summernote({
      isNotSplitEdgePoint:true,
      tabsize:2,
      lang:'en-US',
      toolbar:
        [
          ['save',['save']],
          ['checkbox',['checkbox']],
          ['para',['ul','ol']],
          ['view',['fullscreen','codeview']]
        ],
        callbacks:{
          onInit:function(){
            $('body > .note-popover').appendTo(".note-editing-area");
          }
        }
    });
  });
</script>
