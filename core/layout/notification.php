<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages
 * @package    core/layout/pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='56'")->execute();
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
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_notification.php';
else{
  if(isset($args[0])&&$args[0]=='edit')
    $show='item';
  if($show=='notification'){?>
    <main>
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
        <div class="container-fluid">
          <div class="card mt-3 bg-transparent border-0 overflow-visible">
            <div class="card-actions">
              <div class="row">
                <div class="col-12 col-sm">
                  <ol class="breadcrumb m-0 pl-0 pt-0">
                    <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Notifications</a></li>
                  </ol>
                </div>
                <div class="col-12 col-sm-2 text-right">
                  <div class="btn-group d-inline">
                    <?=$user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/notification/add" role="button" data-tooltip="left" aria-label="Add Notification"><i class="i">add</i></a>':'';?>
                  </div>
                </div>
              </div>
            </div>
            <section class="col-12 col-sm overflow-visible list">
              <div class="row sticky-top">
                <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header shadow sticky-top">
                  <div class="row">
                    <div class="col-12 col-md-1"></div>
                    <div class="col-12 col-md pl-4">Title</div>
                    <div class="col-12 col-md-1 text-center">Active</div>
                    <div class="col-12 col-md-2"></div>
                  </div>
                </article>
              </div>
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `contentType`='notification' ORDER BY `id` ASC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <article class="card zebra m-0 p-0 overflow-visible card-list item" id="l_<?=$r['id'];?>">
                  <div class="row">
                    <div class="col-12 col-md-1">
                      <?php echo$r['cover']!=''?'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['cover'].'"><img class="img-rounded" style="max-width:128px;height:64px;" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>':'';?>
                    </div>
                    <div class="col-12 col-md pl-4 py-2">
                      <a href="<?= URL.$settings['system']['admin'].'/notification/edit/'.$r['id'];?>"><?=$r['title'];?></a>
                    </div>
                    <div class="col-12 col-md-1 text-center my-4">
                      <?='<input id="active'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled').'>';?>
                    </div>
                    <div class="col-12 col-md-2 pt-3 pr-2 text-right" id="controls_<?=$r['id'];?>">
                      <div class="btn-group" role="group">
                        <?='<a role="button" href="'.URL.$settings['system']['admin'].'/notification/edit/'.$r['id'].'" data-tooltip="tooltip" aria-label="'.($user['options'][1]==1?'Edit':'View').' Notification"><i class="i">'.($user['options'][1]==1?'edit':'view').'</i></a>'.
                        ($user['options'][1]==1?'<button class="purge" id="purge'.$r['id'].'" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`menu`);"><i class="i">delete</i></button>':'');?>
                      </div>
                    </div>
                  </div>
                </article>
              <?php }?>
            </section>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </section>
    </main>
  <?php }
}
if($show=='item')
  require'core/layout/edit_notification.php';
