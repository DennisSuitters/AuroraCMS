<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Job List
 * @package    core/layout/joblist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='joblist';
if(isset($args[0])&&$args[0]=='add'){
  $ti=time();
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`uid`,`login_user`,`title`,`contentType`,`status`,`tis`,`ti`) VALUES (:uid,:login_user,:title,'job','unconfirmed',:tis,:ti)");
  $q->execute([
    ':uid'=>$user['id'],
    ':login_user'=>(isset($user['name'])?$user['name']:$user['username']),
    ':title'=>'Job '.$ti.'',
    ':tis'=>$ti,
    ':ti'=>$ti]
  );
  $id=$db->lastInsertId();
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;?>
  <script>history.replaceState('','','<?= URL.$settings['system']['admin'].'/joblist/edit/'.$args[1];?>');</script>
<?php }elseif(isset($args[1]))
  $id=$args[1];
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_joblist.php';
else{
  if(isset($args[0])&&$args[0]=='edit')
    $show='item';
  if($show=='joblist'){?>
    <main>
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
        <div class="container-fluid kanban-board">
          <div class="card mt-3 bg-transparent border-0 overflow-visible">
            <div class="card-actions">
              <div class="row">
                <div class="col-12 col-sm">
                  <ol class="breadcrumb m-0 pl-0 pt-0">
                    <li class="breadcrumb-item active">Job List</li>
                  </ol>
                </div>
                <div class="col-12 col-sm-2 text-right">
                  <div class="btn-group">
                    <?=$user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/joblist/add" role="button" data-tooltip="left" aria-label="Add Job"><i class="i">add</i></a>':'';?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="alert alert-info d-block d-sm-none" role="alert"></div>
              <div class="col-sm-3">
                <div class="card m-1">
                  <div class="card-header bg-danger text-danger font-weight-bold p-2">Unconfirmed</div>
                  <div class="card-body p-1 overflow-y" data-dbda="unconfirmed">
                    <div id="unconfirmed">
                      <?php $ti=time();
                      $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='job' AND `status`='unconfirmed' ORDER BY `ti` DESC");
                      $s->execute();
                      while($r=$s->fetch(PDO::FETCH_ASSOC)){
                        if($r['rid']!=0){
                          $is=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
                          $is->execute([':id'=>$r['rid']]);
                          if($is->rowCount()>0){
                            $ri=$is->fetch(PDO::FETCH_ASSOC);
                          }
                        }?>
                        <article class="kanban-item m-0 my-1 p-1 grab" id="l_<?=$r['id'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="status" draggable="true">
                          <h5>
                            <?=($r['business']!=''?$r['business']:($r['url']!=''?$r['url']:''));?>
                            <a class="btn-sm float-right" href="<?= URL.$settings['system']['admin'].'/joblist/edit/'.$r['id'];?>" role="button" data-tooltip="left" aria-label="Edit"><i class="i">edit</i></a>
                          </h5>
                          <p class="small">
                            <?=($r['email']!=''?'Email <strong><a href="mailto:'.$r['email'].'">'.$r['email'].'</a></strong>':'').
                            ($r['phone']!=''?'<br>Phone <strong><a href="tel:'.$r['phone'].'">'.$r['phone'].'</a></strong>':'').
                            ($r['mobile']!=''?'<br>Mobile <strong><a href="tel:'.$r['mobile'].'">'.$r['mobile'].'</a></strong>':'').
                            ($r['address']!=''?'<br>Address <strong><a target="_blank" href="https://www.google.com/maps/place/'.str_replace(' ','+',$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode']).'">'.$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].'</a></strong>':'').
                            '<br>Start <strong>'.date($config['dateFormat'],$r['tis']).'</strong><br>'.
                            ($r['tie']>0?'End <strong>'.date($config['dateFormat'],$r['tie']).'</strong><br>':'').
                            ($r['rid']!=0&&isset($ri['id'])?'Booked <strong>'.$ri['title'].'</strong>':'').
                            '<button class="btn-sm purge float-right" id="purge'.$r['id'].'" data-tooltip="left" aria-label="Delete" onclick="purge(`'.$r['id'].'`,`content`);"><i class="i">trash</i></button>';?>
                          </p>
                        </article>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="card m-1">
                  <div class="card-header bg-warning text-warning font-weight-bold p-2">Confirmed</div>
                  <div class="card-body p-1 overflow-y" data-dbda="confirmed">
                    <div id="confirmed">
                      <?php $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='job' AND `status`='confirmed' ORDER BY `ti` DESC");
                      $s->execute();
                      while($r=$s->fetch(PDO::FETCH_ASSOC)){
                        if($r['rid']!=0){
                          $is=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
                          $is->execute([':id'=>$r['rid']]);
                          if($is->rowCount()>0){
                            $ri=$is->fetch(PDO::FETCH_ASSOC);
                          }
                        }?>
                        <article class="kanban-item m-0 my-1 p-1 grab" id="l_<?=$r['id'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="status" draggable="true">
                          <h5>
                            <?=($r['business']!=''?$r['business']:($r['url']!=''?$r['url']:''));?>
                            <a class="btn-sm p-1 float-right" href="<?= URL.$settings['system']['admin'].'/joblist/edit/'.$r['id'];?>" role="button" data-tooltip="left" aria-label="Edit"><i class="i">edit</i></a>
                          </h5>
                          <p class="small">
                            <?=($r['email']!=''?'Email <strong><a href="mailto:'.$r['email'].'">'.$r['email'].'</a></strong>':'').
                            ($r['phone']!=''?'<br>Phone <strong><a href="tel:'.$r['phone'].'">'.$r['phone'].'</a></strong>':'').
                            ($r['mobile']!=''?'<br>Mobile <strong><a href="tel:'.$r['mobile'].'">'.$r['mobile'].'</a></strong>':'').
                            ($r['address']!=''?'<br>Address <strong><a target="_blank" href="https://www.google.com/maps/place/'.str_replace(' ','+',$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode']).'">'.$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].'</a></strong>':'').
                            '<br>Start <strong>'.date($config['dateFormat'],$r['tis']).'</strong><br>'.
                            ($r['tie']>0?'End <strong>'.date($config['dateFormat'],$r['tie']).'</strong><br>':'').
                            ($r['rid']!=0&&isset($ri['id'])?'Booked <strong>'.$ri['title'].'</strong>':'').
                            '<button class="btn-sm p-1 purge float-right" id="purge'.$r['id'].'" data-tooltip="left" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`content`);"><i class="i">trash</i></button>';?>'
                          </p>
                        </article>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="card m-1">
                  <div class="card-header bg-info text-info font-weight-bold p-2">In Progress</div>
                  <div class="card-body p-1 overflow-y" data-dbda="in-progress">
                    <div id="in-progress">
                      <?php $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='job' AND `status`='in-progress' ORDER BY `ti` DESC");
                      $s->execute();
                      while($r=$s->fetch(PDO::FETCH_ASSOC)){
                        if($r['rid']!=0){
                          $is=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
                          $is->execute([':id'=>$r['rid']]);
                          if($is->rowCount()>0){
                            $ri=$is->fetch(PDO::FETCH_ASSOC);
                          }
                        }?>
                        <article class="kanban-item m-0 my-1 p-1 grab" id="l_<?=$r['id'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="status" draggable="true">
                          <h5>
                            <?=($r['business']!=''?$r['business']:($r['url']!=''?$r['url']:''));?>
                            <a class="btn-sm p-1 float-right" href="<?= URL.$settings['system']['admin'].'/joblist/edit/'.$r['id'];?>" role="button" data-tooltip="left" aria-label="Edit"><i class="i">edit</i></a>
                          </h5>
                          <p class="small">
                            <?=($r['email']!=''?'Email <strong><a href="mailto:'.$r['email'].'">'.$r['email'].'</a></strong>':'').
                            ($r['phone']!=''?'<br>Phone <strong><a href="tel:'.$r['phone'].'">'.$r['phone'].'</a></strong>':'').
                            ($r['mobile']!=''?'<br>Mobile <strong><a href="tel:'.$r['mobile'].'">'.$r['mobile'].'</a></strong>':'').
                            ($r['address']!=''?'<br>Address <strong><a target="_blank" href="https://www.google.com/maps/place/'.str_replace(' ','+',$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode']).'">'.$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].'</a></strong>':'').
                            '<br>Start <strong>'.date($config['dateFormat'],$r['tis']).'</strong><br>'.
                            ($r['tie']>0?'End <strong>'.date($config['dateFormat'],$r['tie']).'</strong><br>':'').
                            ($r['rid']!=0&&isset($ri['id'])?'Booked <strong>'.$ri['title'].'</strong>':'').
                            '<button class="btn-sm p-1 purge float-right" id="purge'.$r['id'].'" data-tooltip="left" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`content`);"><i class="i">trash</i></button>';?>
                          </p>
                        </article>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="card m-1">
                  <div class="card-header bg-success text-success font-weight-bold p-2">Complete</div>
                  <div class="card-body p-1 overflow-y" data-dbda="complete">
                    <div id="complete">
                      <?php $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='job' AND `status`='complete' ORDER BY `ti` DESC");
                      $s->execute();
                      while($r=$s->fetch(PDO::FETCH_ASSOC)){
                        if($r['rid']!=0){
                          $is=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
                          $is->execute([':id'=>$r['rid']]);
                          if($is->rowCount()>0){
                            $ri=$is->fetch(PDO::FETCH_ASSOC);
                          }
                        }?>
                        <article class="kanban-item m-0 my-1 p-1 grab" id="l_<?=$r['id'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="status" draggable="true">
                          <h5>
                            <?=($r['business']!=''?$r['business']:($r['url']!=''?$r['url']:''));?>
                            <a class="btn-sm p-1 float-right" href="<?= URL.$settings['system']['admin'].'/joblist/edit/'.$r['id'];?>" role="button" data-tooltip="left" aria-label="Edit"><i class="i">edit</i></a>
                          </h5>
                          <p class="small">
                            <?=($r['email']!=''?'Email <strong><a href="mailto:'.$r['email'].'">'.$r['email'].'</a></strong>':'').
                            ($r['phone']!=''?'<br>Phone <strong><a href="tel:'.$r['phone'].'">'.$r['phone'].'</a></strong>':'').
                            ($r['mobile']!=''?'<br>Mobile <strong><a href="tel:'.$r['mobile'].'">'.$r['mobile'].'</a></strong>':'').
                            ($r['address']!=''?'<br>Address <strong><a target="_blank" href="https://www.google.com/maps/place/'.str_replace(' ','+',$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode']).'">'.$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].'</a></strong>':'').
                            '<br>Start <strong>'.date($config['dateFormat'],$r['tis']).'</strong><br>'.
                            ($r['tie']>0?'End <strong>'.date($config['dateFormat'],$r['tie']).'</strong><br>':'').
                            ($r['rid']!=0&&isset($ri['id'])?'Booked <strong>'.$ri['title'].'</strong>':'').
                            '<button class="btn-sm p-1 purge float-right" id="purge'.$r['id'].'" data-tooltip="left" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`content`);"><i class="i">trash</i></button>';?>
                          </p>
                        </article>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm">
                <div class="card m-1">
                  <div class="card-header bg-dark text-white font-weight-bold p-2">Archived</div>
                  <div class="card-body p-1 overflow-y" data-dbda="archived">
                    <div id="archived">
                      <?php $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='job' AND `status`='archived' ORDER BY `ti` DESC");
                      $s->execute();
                      while($r=$s->fetch(PDO::FETCH_ASSOC)){
                        if($r['rid']!=0){
                          $is=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
                          $is->execute([':id'=>$r['rid']]);
                          if($is->rowCount()>0){
                            $ri=$is->fetch(PDO::FETCH_ASSOC);
                          }
                        }?>
                        <article class="kanban-item m-0 my-1 p-1 grab" id="l_<?=$r['id'];?>" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="status" draggable="true">
                          <h5>
                            <?=($r['business']!=''?$r['business']:($r['url']!=''?$r['url']:''));?>
                            <a class="btn-xs p-1 float-right" href="<?= URL.$settings['system']['admin'].'/joblist/edit/'.$r['id'];?>" role="button" data-tooltip="left" aria-label="Edit"><i class="i">edit</i></a>
                          </h5>
                          <p class="small">
                            <?=($r['email']!=''?'Email <strong><a href="mailto:'.$r['email'].'">'.$r['email'].'</a></strong>':'').
                            ($r['phone']!=''?'<br>Phone <strong><a href="tel:'.$r['phone'].'">'.$r['phone'].'</a></strong>':'').
                            ($r['mobile']!=''?'<br>Mobile <strong><a href="tel:'.$r['mobile'].'">'.$r['mobile'].'</a></strong>':'').
                            ($r['address']!=''?'<br>Address <strong><a target="_blank" href="https://www.google.com/maps/place/'.str_replace(' ','+',$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode']).'">'.$r['address'].', '.$r['suburb'].', '.$r['city'].', '.$r['state'].', '.$r['postcode'].'</a></strong>':'').
                            '<br>Start <strong>'.date($config['dateFormat'],$r['tis']).'</strong><br>'.
                            ($r['tie']>0?'End <strong>'.date($config['dateFormat'],$r['tie']).'</strong><br>':'').
                            ($r['rid']!=0&&isset($ri['id'])?'Booked <strong>'.$ri['title'].'</strong>':'').
                            '<button class="btn-sm p-1 purge float-right" id="purge'.$r['id'].'" data-tooltip="left" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`content`);"><i class="i">trash</i></button>';?>
                          </p>
                        </article>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </section>
      <script>
        $(function(){
          var kanbanCol=$('.card-body');
          kanbanCol.css('height',(window.innerHeight - 50) + 'px');
          kanbanCol.css('max-height',(window.innerHeight - 50) + 'px');
          draggableInit();
          $('.card-header').click(function(){
            var $panelBody=$(this).parent().children('.card-body');
            $panelBody.slideToggle();
          });
        });
        function draggableInit(){
          var sourceId;
          $('[draggable=true]').bind('dragstart',function(event){
            sourceId=$(this).parent().attr('id');
            $(this).addClass('dragging').width($(this).width());
            event.originalEvent.dataTransfer.setData("text/plain",event.target.getAttribute('id'));
          });
          $('.card-body').bind('dragover',function(event){event.preventDefault();});
          $('.card-body').bind('drop',function(event){
            $(this).removeClass('dragging');
            var children=$(this).children();
            var targetId=children.attr('id');
            if(sourceId!=targetId){
              var elementId=event.originalEvent.dataTransfer.getData("text/plain");
              var element=document.getElementById(elementId);
              var dbid=$(element).data('dbid');
              var dbt=$(element).data('dbt');
              var dbc=$(element).data('dbc');
              var dbda=$(this).data('dbda');
              children.prepend(element);
              $.ajax({
                type:"GET",
                url:"core/update.php",
                data:{
                  id:dbid,
                  t:dbt,
                  c:dbc,
                  da:dbda
                }
              }).done(function(msg){});
            }
            event.preventDefault();
          });
        }
      </script>
    </main>
  <?php }
  }
  if($show=='item')require'core/layout/edit_joblist.php';
