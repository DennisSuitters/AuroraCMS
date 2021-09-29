<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages
 * @package    core/layout/pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='notification';
if(isset($args[0])&&$args[0]=='add'){
  $ti=time();
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."menu` (`title`,`seoTitle`,`file`,`contentType`,`schemaType`,`menu`,`active`,`ord`,`eti`) VALUES (:title,'','notification','notification','Article','notification','0',:ord,:eti)");
  $q->execute([
    ':title'=>'Notification '.$ti.'',
    ':ord'=>$ti,
    ':eti'=>$ti]);
  $id=$db->lastInsertId();
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;?>
  <script>history.replaceState('','','<?= URL.$settings['system']['admin'].'/notification/edit/'.$args[1];?>');</script>
<?php }
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_notification.php';
else{
  if(isset($args[0])&&$args[0]=='edit')$show='item';
  if($show=='notification'){?>
  <main>
    <section id="content">
      <div class="content-title-wrapper">
        <div class="content-title">
          <div class="content-title-heading">
            <div class="content-title-icon"><?php svg('notification','i-3x');?></div>
            <div>Pages</div>
            <div class="content-title-actions">
              <?=$user['options'][0]==1?'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/notification/add" role="button" aria-label="Add Notification">'.svg2('add').'</a>':'';?>
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
                <th class="col-9">Notifications</th>
                <th class="col text-center">Active</th>
                <th class="col"></th>
              <tr>
            </thead>
            <tbody id="sortable">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `file`='notification' ORDER BY `id` ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?=$r['id'];?>">
                <td class="align-middle text-center">
                  <?php if($r['cover']!=''){
                    $imgcheck=basename($r['cover']);
                    if(file_exists('media/lg/'.$imgcheck)&&file_exists('media/sm/'.$imgcheck))echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="media/lg/'.$imgcheck.'"><img class="img-rounded" style="max-width:32px;height:32px;" src="media/sm/'.$imgcheck.'" alt="'.$r['title'].'"></a>';
                  }?>
                </td>
                <td class="align-middle"><a href="<?= URL.$settings['system']['admin'].'/notification/edit/'.$r['id'];?>"><?=$r['title'];?></a></td>
                <td class="align-middle text-center" id="menuactive0<?=$r['id'];?>">
                  <?=$r['contentType']!='index'?'<input id="active'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled').'>':'';?>
                </td>
                <td id="controls_<?=$r['id'];?>" class="align-middle">
                  <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                    <div class="btn-group" role="group" aria-label="Item Controls">
                      <a class="btn" href="<?= URL.$settings['system']['admin'].'/notification/edit/'.$r['id'];?>"<?=$user['options'][1]==1?' data-tooltip="tooltip" role="button" aria-label="Edit Notification"':' data-tooltip="tooltip" role="button" aria-label="View Notification"';?>"><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                      <?=$user['options'][0]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$r['id'].'\',\'menu\');">'.svg2('trash').'</button>':'';?>
                    </div>
                  </div>
                </td>
              </tr>
<?php }?>
            </tbody>
          </table>
          <?php require'core/layout/footer.php';?>
        </div>
      </div>
    </section>
  </main>
<?php }
}
if($show=='item')require'core/layout/edit_notification.php';
