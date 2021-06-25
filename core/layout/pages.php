<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages
 * @package    core/layout/pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='pages';
if($args[0]=='add'){
  $ti=time();
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."menu` (`rank`,`uid`,`mid`,`login_user`,`title`,`seoTitle`,`file`,`contentType`,`schemaType`,`menu`,`active`,`ord`,`eti`) VALUES ('0',:uid,'0',:login_user,:title,'','page','page','Article','other','0',:ord,:eti)");
  $q->execute([
    ':uid'=>$user['id'],
    ':login_user'=>(isset($user['name'])?$user['name']:$user['username']),
    ':title'=>'New Page '.$ti.'',
    ':ord'=>$ti,
    ':eti'=>$ti]);
  $id=$db->lastInsertId();
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;?>
  <script>history.replaceState('','','<?= URL.$settings['system']['admin'].'/pages/edit/'.$args[1];?>');</script>
<?php }
if($args[0]=='settings')require'core/layout/set_pages.php';
else{
  if($args[0]=='edit')$show='item';
  if($show=='pages'){?>
  <main>
    <section id="content">
      <div class="content-title-wrapper">
        <div class="content-title">
          <div class="content-title-heading">
            <div class="content-title-icon"><?php svg('content','i-3x');?></div>
            <div>Pages</div>
            <div class="content-title-actions">
              <?=$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/settings" role="button" aria-label="Pages Settings">'.svg2('settings').'</a>':'';?>
              <?=$user['options'][0]==1?'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/pages/add" role="button" aria-label="Add Page">'.svg2('add').'</a>':'';?>
            </div>
          </div>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
            <li class="breadcrumb-item active">Pages</li>
          </ol>
        </div>
      </div>
      <div class="container-fluid p-0">
        <div class="card border-radius-0 shadow overflow-visible">
          <table class="table-zebra">
            <thead>
              <tr>
                <th class="col"></th>
                <th class="col-6">
                  Title<span class="ml-5 small">Submenu</span>
                </th>
                <th class="col text-center">Menu</th>
                <th class="col text-center">Views<?=$user['options'][1]==1?' <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Clear All Page Views" onclick="$(`[data-views=\'views\']`).text(`0`);purge(`0`,`pageviews`);">'.svg2('eraser').'</button>':'';?></th>
                <th class="col text-center">Active</th>
                <th class="col"></th>
                <th class="col"></th>
              </tr>
            </thead>
            <tbody id="sortable">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `mid`=0 AND `menu`!='none' ORDER BY FIELD(`menu`,'head','footer','account','other'), `ord` ASC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <tr class="item subsortable" id="l_<?=$r['id'];?>">
                  <td>
<?php if($r['cover']!=''){
  $imgcheck=basename($r['cover']);
  if(file_exists('media/lg/'.$imgcheck)&&file_exists('media/sm/'.$imgcheck))echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="media/lg/'.$imgcheck.'"><img class="img-rounded" style="max-width:32px;height:32px;" src="media/sm/'.$imgcheck.'" alt="'.$r['title'].'"></a>';
}?>
                  </td>
                  <td class="align-top">
                    <a href="<?= URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"><?=$r['title'];?></a>
                    <?php if($user['options'][1]==1){
                      $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=:id");
                      $ss->execute([':id'=>$r['id']]);
                      $rs=$ss->fetch(PDO::FETCH_ASSOC);
                      echo$rs['cnt']>0?'<span class="text-info" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions">'.svg2('lightbulb').'</span>':'';
                    }
                    echo'<br><small class="text-muted">Available to '.($r['rank']==0?'Everyone':ucfirst(rank($r['rank'])).' and above').'</small>';
                    $sm=$db->prepare("SELECT `id`,`rank`,`title`,`contentType`,`active`,`views` FROM `".$prefix."menu` WHERE `mid`=:mid ORDER BY `ord` ASC");
                    $sm->execute([':mid'=>$r['id']]);
                    if($sm->rowCount()>0){?>
                      <div class="d-block ml-5" id="subsortable_<?=$r['id'];?>">
                        <?php while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
                          <div class="item zebra border-bottom position-relative" style="position:relative;" id="l_<?=$rm['id'];?>">
                            <a href="<?= URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'];?>"><?=$rm['title'];?></a>
                            <?='<br><small class="text-muted">Page Available to '.($rm['rank']==0?'Everyone':ucfirst(rank($rm['rank'])).' and above').'</small>';?>
                            <span style="position:absolute;top:0;right:0;" id="controls_<?=$rm['id'];?>" role="group">
                              <?=$user['options'][0]==1?'<button class="btn trash align-top" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views'.$rm['id'].'`).text(`0`);update(`'.$rm['id'].'`,`menu`,`views`,`0`);"><span id="views'.$rm['id'].'">'.$rm['views'].'</span></button>':$rm['views'];?>
                              <?=$r['contentType']!='index'?'<input id="active'.$rm['id'].'" data-dbid="'.$rm['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($rm['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled').'>':'';?>
                              <a class="btn btn-sm"<?=$user['options'][1]==1?' data-tooltip="tooltip" role="button" aria-label="Edit"':' data-tooltip="tooltip" role="button" aria-label="View"';?>" href="<?= URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'];?>"><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                              <?=$user['options'][0]==1&&$rm['contentType']=='page'?'<button class="btn trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$rm['id'].'\',\'menu\');">'.svg2('trash').'</button>':'';?>
                              <?php svg('drag','subhandle');?>
                            </span>
                          </div>
                        <?php }?>
                        <div class="ghost2 hidden"></div>
                      </div>
                      <?php if($user['options'][1]==1){?>
                        <script>
                          $('#subsortable_<?=$r['id'];?>').sortable({
                            items:"div.item",
                            handle:".subhandle",
                            placeholder:".ghost2",
                            helper:fixWidthHelper,
                            axis:"y",
                            update:function(e,ui){
                              var order=$("#subsortable_<?=$r['id'];?>").sortable("serialize");
                              $.ajax({
                                type:"POST",
                                dataType:"json",
                                url:"core/reordersub.php",
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
                      <?php }
                    }
                    $sm=$db->prepare("SELECT `id`,`rank`,`title`,`contentType`,`active`,`views` FROM `".$prefix."content` WHERE `mid`!=0 AND `mid`=:mid ORDER BY `title` ASC");
                    $sm->execute([':mid'=>$r['id']]);
                    if($sm->rowCount()>0){?>
                      <div class="d-block ml-5">
                        <?php while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
                          <div class="zebra border-bottom position-relative" style="position:relative;">
                            <a href="<?= URL.$settings['system']['admin'].'/content/edit/'.$rm['id'];?>"><?=$rm['title'];?></a>
                            <?='<br><small class="text-muted">'.ucfirst($rm['contentType']).' Available to '.($rm['rank']==0?'Everyone':ucfirst(rank($rm['rank'])).' and above').'</small>';?>
                            <span style="position:absolute;top:0;right:0;" id="controls_<?=$rm['id'];?>" role="group">
                              <?=$user['options'][0]==1?'<button class="btn-sm trash align-top" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views'.$rm['id'].'`).text(`0`);update(`'.$rm['id'].'`,`menu`,`views`,`0`);"><span id="views'.$rm['id'].'">'.$rm['views'].'</span></button>':$rm['views'];?>
                              <span class="i" style="width:24px;">&nbsp;</span>
                              <a class="btn-sm" href="<?= URL.$settings['system']['admin'].'/content/edit/'.$rm['id'];?>"<?=$user['options'][1]==1?' data-tooltip="tooltip" role="button" aria-label="Edit"':' data-tooltip="tooltip" role=button aria-label="View"';?>"><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                              <?=$user['options'][0]==1&&$rm['contentType']=='page'?'<button class="btn-sm trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$rm['id'].'\',\'menu\');">'.svg2('trash').'</button>':'';?>
                              <span class="i">&nbsp;</span>
                            </span>
                          </div>
                        <?php }?>
                      </div>
                    <?php }?>
                  </td>
                  <td class="align-middle text-center small"><?= ucfirst($r['menu']);?></td>
                  <td class="align-middle text-center">
                    <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views'.$r['id'].'`).text(`0`);updateButtons(`'.$r['id'].'`,`menu`,`views`,`0`);"><span id="views'.$r['id'].'" data-views="views">'.$r['views'].'</span></button>':'<span class="badger badge-danger">'.$r['views'].'</span>';?>
                  </td>
                  <td class="align-middle text-center" id="menuactive0<?=$r['id'];?>">
                    <?=$r['contentType']!='index'?'<input id="active'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled').'>':'';?>
                  </td>
                  <td id="controls_<?=$r['id'];?>" class="align-middle">
                    <div class="btn-toolbar float-right" role="toolbar">
                      <div class="btn-group" role="group">
                        <?php if($r['active']==1){?><button data-social-share="<?= URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/');?>" data-social-desc="<?= $r['seoDescription']?$r['seoDescription']:$r['title'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><?php svg('share');?></button><?php }?>
                        <a class="btn" href="<?= URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"<?=$user['options'][1]==1?' data-tooltip="tooltip" role="button" aria-label="Edit"':' data-tooltip="tooltip" role="button" aria-label="View"';?>"><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                        <?=$user['options'][0]==1&&$r['contentType']=='page'?'<button class="btn purge trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$r['id'].'\',\'menu\');">'.svg2('trash').'</button>':'';?>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle"><?php svg('drag','orderhandle');?></td>
                </tr>
              <?php }?>
              <tr class="border-top" id="l_23">
                <td></td>
                <td class="align-middle">
                  <a href="<?= URL.$settings['system']['admin'].'/pages/edit/23';?>">Coming Soon</a>
                  <?php if($user['options'][1]==1){
                    $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=23");
                    $ss->execute();
                    $rs=$ss->fetch(PDO::FETCH_ASSOC);
                    echo$rs['cnt']>0?'<span class="badge badge-pill badge-success" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions">'.$rs['cnt'].' '.svg2('lightbulb').'</span>':'';
                  }?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td id="controls_" class="align-middle">
                  <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                    <div class="btn-group" role="group" aria-label="Item Controls">
                      <a class="btn" href="<?= URL.$settings['system']['admin'].'/pages/edit/23';?>"<?=$user['options'][1]==1?' data-tooltip="tooltip" role="button" aria-label="Edit"':' data-tooltip="tooltip" role="button" aria-label="View"';?>"><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                    </div>
                  </div>
                </td>
                <td></td>
              </tr>
              <tr id="l_24">
                <td></td>
                <td class="align-middle">
                  <a href="<?= URL.$settings['system']['admin'].'/pages/edit/24';?>">Maintenance</a>
                  <?php if($user['options'][1]==1){
                    $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=24");
                    $ss->execute();
                    $rs=$ss->fetch(PDO::FETCH_ASSOC);
                    echo$rs['cnt']>0?'<span class="badge badge-pill badge-success" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions">'.$rs['cnt'].' '.svg2('lightbulb').'</span>':'';
                  }?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td id="controls_" class="align-middle">
                  <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                    <div class="btn-group" role="group" aria-label="Item Controls">
                      <a class="btn" href="<?= URL.$settings['system']['admin'].'/pages/edit/24';?>"<?=$user['options'][1]==1?' data-tooltip="tooltip" role="button" aria-label="Edit"':' data-tooltip="tooltip" role="button" aria-label="View"';?>"><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                    </div>
                  </div>
                </td>
                <td></td>
              </tr>
              <tr class="ghost hidden">
                <td colspan="4">&nbsp;</td>
              </tr>
            </tbody>
          </table>
          <?php require'core/layout/footer.php';?>
        </div>
      </div>
    </section>
  </main>
  <?php if($user['options'][1]==1){?>
    <script>
      $('#sortable').sortable({
        items:"tr.item",
        handle:'.orderhandle',
        placeholder:".ghost",
        helper:fixWidthHelper,
        axis:"y",
        update:function(e,ui){
          var order=$("#sortable").sortable("serialize");
          $.ajax({
            type:"POST",
            dataType:"json",
            url:"core/reorder.php",
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
<?php }
}
if($show=='item')require'core/layout/edit_pages.php';
