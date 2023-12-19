<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Payments
 * @package    core/layout/payments.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='55'");
$sv->execute();
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_dashboard.php';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid kanban-board">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <ol class="breadcrumb m-0 pl-0 pt-0">
              <li class="breadcrumb-item active">Payments</li>
            </ol>
          </div>
          <?php if($user['rank']<1000){?>
            <div class="alert alert-info" role="alert">This Page is not available to your Account Rank</div>
          <?php }else{?>
            <div class="row">
              <div class="col-4">
                <div class="card m-1">
                  <div class="card-header bg-danger text-danger font-weight-bold p-2">Overdue</div>
                  <div class="card-body p-1 overflow-y" data-dbda="overdue">
                    <div id="overdue">
                      <?php $ti=time();
                      $sh=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `hostStatus`='overdue' OR `siteStatus`='overdue' ORDER BY `hti` DESC, `sti` DESC");
                      $sh->execute();
                      while($rh=$sh->fetch(PDO::FETCH_ASSOC)){
                        if($rh['accountsContact']==0)continue;
                        if($rh['hostStatus']=='overdue'){
                          $days=0;
                          if($rh['hti'] < $ti){
                            $days=ceil(abs($ti - $rh['hti']) / 86400);
                          }?>
                          <article class="kanban-item m-0 my-1 p-1 grab" id="hostitem<?=$rh['id'];?>" data-dbid="<?=$rh['id'];?>" data-dbt="login" data-dbc="hostStatus" draggable="true">
                            <h5>
                              <?=($rh['business']!=''?$rh['business']:($r['url']!=''?$r['url']:''));?>
                              <a class="btn-xs p-1 float-right" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$rh['id'].'#tab1-8';?>" role="button"><i class="i">edit</i></a>
                            </h5>
                            <p class="small">
                              Hosting is <strong><?=$days;?></strong> days overdue.<br>
                              Was due <strong><?= date($config['dateFormat'],$rh['hti']);?></strong>.
                            </p>
                          </article>
                        <?php }
                        if($rh['siteStatus']=='overdue'&&$rh['siteCost']>0){
                          $days=0;
                          if($rh['sti'] < $ti){
                            $days=ceil(abs($ti - $rh['sti']) / 86400);
                          }?>
                          <article class="kanban-item m-0 my-1 p-1 grab" id="siteitem<?=$rh['id'];?>" data-dbid="<?=$rh['id'];?>" data-dbt="login" data-dbc="siteStatus" draggable="true">
                            <h5>
                              <?=($rh['business']!=''?$rh['business']:($r['url']!=''?$r['url']:''));?>
                              <a class="btn-xs p-1 float-right" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$rh['id'].'#tab1-8';?>" role="button"><i class="i">edit</i></a>
                            </h5>
                            <p class="small">
                              Site Payment is <strong><?=$days;?></strong> days overdue with <strong>$<?=$rh['siteCost'];?></strong> remaining.<br>
                              Was due <strong><?= date($config['dateFormat'],$rh['sti']);?></strong>.
                            </p>
                          </article>
                        <?php }
                      }?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="card m-1">
                  <div class="card-header bg-warning text-warning font-weight-bold p-2">Outstanding</div>
                  <div class="card-body p-1 overflow-y" data-dbda="outstanding">
                    <div id="outstanding">
                      <?php $sh=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `hostStatus`='outstanding' OR `siteStatus`='outstanding' ORDER BY `hti` DESC, `sti` DESC");
                      $sh->execute();
                      while($rh=$sh->fetch(PDO::FETCH_ASSOC)){
                        if($rh['accountsContact']==0)continue;
                        if($rh['hostStatus']=='outstanding'){
                          $days=0;
                          if($rh['hti'] > $ti){
                            $days=ceil(abs($rh['hti'] - $ti) / 86400);
                          }?>
                          <article class="kanban-item m-0 my-1 p-1 grab" id="hostitem<?=$rh['id'];?>" data-dbid="<?=$rh['id'];?>" data-dbt="login" data-dbc="hostStatus" draggable="true">
                            <h5>
                              <?=($rh['business']!=''?$rh['business']:($r['url']!=''?$r['url']:''));?>
                              <a class="btn-xs p-1 float-right" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$rh['id'].'#tab1-8';?>" role="button"><i class="i">edit</i></a>
                            </h5>
                            <p class="small">
                              Hosting is due in <strong><?=$days;?></strong> days.<br>
                              Due on <strong><?= date($config['dateFormat'],$rh['hti']);?></strong>.
                            </p>
                          </article>
                        <?php }
                        if($rh['siteStatus']=='outstanding'&&$rh['siteCost']>0){
                          $days=0;
                          if($rh['sti'] > $ti){
                            $days=ceil(abs($rh['sti'] - $ti) / 86400);
                          }?>
                          <article class="kanban-item m-0 my-1 p-1 grab" id="siteitem<?=$rh['id'];?>" data-dbid="<?=$rh['id'];?>" data-dbt="login" data-dbc="siteStatus" draggable="true">
                            <h5>
                              <?=($rh['business']!=''?$rh['business']:($r['url']!=''?$r['url']:''));?>
                              <a class="btn-xs p-1 float-right" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$rh['id'].'#tab1-8';?>" role="button"><i class="i">edit</i></a>
                            </h5>
                            <p class="small">
                              Site Payment is due in <strong><?=$days;?></strong> days, with <strong>$<?=$rh['siteCost'];?></strong> remaining.<br>
                              Due on <strong><?= date($config['dateFormat'],$rh['sti']);?></strong>.
                            </p>
                          </article>
                        <?php }
                      }?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="card m-1">
                  <div class="card-header bg-success text-success font-weight-bold p-2">Paid</div>
                  <div class="card-body p-1 overflow-y" data-dbda="paid">
                    <div id="paid">
                      <?php $sh=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `hostStatus`='paid' OR `siteStatus`='paid' ORDER BY `hti` DESC, `sti` DESC");
                      $sh->execute();
                      while($rh=$sh->fetch(PDO::FETCH_ASSOC)){
                        if($rh['accountsContact']==0)continue;
                        if($rh['hostStatus']=='paid'){
                          $days=0;
                          if($rh['hti'] > $ti){
                            $days=ceil(abs($ti - $rh['hti']) / 86400);
                          }?>
                          <article class="kanban-item m-0 my-1 p-1 grab" id="hostitem<?=$rh['id'];?>" data-dbid="<?=$rh['id'];?>" data-dbt="login" data-dbc="hostStatus" draggable="true">
                            <h5>
                              <?=($rh['business']!=''?$rh['business']:($r['url']!=''?$r['url']:''));?>
                              <a class="btn-xs p-1 float-right" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$rh['id'].'#tab1-8';?>" role="button"><i class="i">edit</i></a>
                            </h5>
                            <p class="small">
                              Hosting is due in <strong><?=$days;?></strong> days.<br>
                              Due on <strong><?= date($config['dateFormat'],$rh['hti']);?></strong>.
                            </p>
                          </article>
                        <?php }
                        if($rh['siteStatus']=='paid'){?>
                          <article class="kanban-item m-0 my-1 p-1 grab" id="siteitem<?=$rh['id'];?>" data-dbid="<?=$rh['id'];?>" data-dbt="login" data-dbc="siteStatus" draggable="true">
                            <h5>
                              <?=($rh['business']!=''?$rh['business']:($r['url']!=''?$r['url']:''));?>
                              <a class="btn-xs p-1 float-right" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$rh['id'].'#tab1-8';?>" role="button"><i class="i">edit</i></a>
                            </h5>
                            <p class="small">
                              Site Payment has been paid in full.<br>
                            </p>
                          </article>
                        <?php }
                      }?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
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
