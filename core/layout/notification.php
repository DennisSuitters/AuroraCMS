<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages
 * @package    core/layout/pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.12
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
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid p-2">
        <div class="card mt-3 p-4 border-radius-0 bg-white shadow border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Notifications</a></li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=$user['options'][0]==1?'<a class="btn add" href="'.URL.$settings['system']['admin'].'/notification/add" role="button" data-tooltip="left" aria-label="Add Notification"><i class="i">add</i></a>':'';?>
                </div>
              </div>
            </div>
          </div>
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
                      <a class="btn" href="<?= URL.$settings['system']['admin'].'/notification/edit/'.$r['id'];?>"<?=$user['options'][1]==1?' role="button" data-tooltip="tooltip" aria-label="Edit Notification"':' role="button" data-tooltip="tooltip" aria-label="View Notification"';?>"><?=$user['options'][1]==1?'<i class="i">edit</i>':'<i class="i">view</i>';?></a>
                      <?=$user['options'][0]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$r['id'].'\',\'menu\');"><i class="i">trash</i></button>':'';?>
                    </div>
                  </div>
                </td>
              </tr>
<?php }?>
            </tbody>
          </table>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
}
if($show=='item')require'core/layout/edit_notification.php';
