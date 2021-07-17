<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Scheduler
 * @package    core/layout/scheduler.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('calendar-time','i-3x');?></div>
          <div>Scheduler</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item active">Scheduler</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow overflow-visible">
        <div class="row p-3">
          <div class="col-12 col-md-4">
            <small>Legend:
              <span class="badger badge-success" data-tooltip="tooltip" aria-label="Content items that have already been Published.">Published</span>
              <span class="badger badge-danger" data-tooltip="tooltip" aria-label="Content items that have NOT been Published.">Unpublished</span>
              <span class="badger badge-warning" data-tooltip="tooltip" aria-label="Content items that are set to AutoPublish.">AutoPublish</span>
            </small>
          </div>
          <div class="col-12 col-md-8 text-right">
            <small>View:
              <a class="badger badge-<?= !isset($args[1])?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/scheduler';?>" aria-label="Display All Content">All</a>&nbsp;
              <?php $s=$db->query("SELECT DISTINCT(`contentType`) AS contentType FROM `".$prefix."content` WHERE `contentType`!='booking' ORDER BY `contentType` ASC");
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <a class="badger badge-<?= isset($args[1])&&$args[1]==$r['contentType']?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/scheduler/'.$r['contentType'];?>" aria-label="Display <?= ucfirst($r['contentType']);?> Items"><?= ucfirst($r['contentType']);?></a>&nbsp;
              <?php }?>
            </small>
          </div>
        </div>
        <div id="calendar-view" class="row p-3">
          <div id="calendar"></div>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType` LIKE :contentType");
$s->execute([':contentType'=>!isset($args[1])||$args[1]==''?'%':$args[1]]);?>
<script>
  document.addEventListener('DOMContentLoaded',function(){
    var calendarEl=document.getElementById('calendar');
    var calendar=new FullCalendar.Calendar(calendarEl,{
      expandRows:true,
      headerToolbar:{
        left:'prev,next today',
        center:'title',
        right:'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
      },
      initialView:'dayGridMonth',
      navLinks:true,
      <?php if($user['options'][2]==1){?>editable:true,<?php }?>
      height:'100vh',
      selectable:true,
      nowIndicator:true,
      dayMaxEvents:true,
      events:[
        <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
          $eColor='danger';
          if($r['status']=='published')
           $eColor='success';
          elseif($r['status']=='autopublish')
            $eColor='warning';
          elseif($r['status']=='archived')
            $eColor='secondary';?>
          {
            id:'<?=$r['id'];?>',
            title:`<?= ucfirst($r['contentType']).`: `.$r['title'];?>`,
            start:`<?= date("Y-m-d H:i:s",$r['pti']);?>`,
            allDay:true,
            customHtml:`<div class="badger badge-<?=$eColor;?> events-layer text-left" data-contentType="<?= ucfirst($r['contentType']);?>"><?=$r['title'];?><div class="events-buttons" role="toolbar" aria-label="Item Toolbar Controls"><div class="btn-group" role="group" aria-label="Item Controls">` +
<?php if($user['options'][2]==1){?>
                  `<a class="btn" id="edbut<?=$r['id'];?>" data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/content/edit/'.$r['id'];?>" aria-label="Edit"><?= svg2('edit');?></a><button class="btn trash" id="delbut<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','content');$(this).closest('.events-layer').remove();"><?= svg2('trash');?></button>` +
<?php }else{?>
                  '<a class="btn" id="edbut<?=$r['id'];?>" data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/content/edit/'.$r['id'];?>" aria-label="View"><?= svg2('view');?></a>' +
<?php }?>
                '</div></div></div>'
          },
        <?php	}?>
      ],
      eventContent:function(eventInfo){
        return{html:eventInfo.event.extendedProps.customHtml}
      },
      eventDrop: function(eventInfo){
        update(eventInfo.event.id,"content","pti",(eventInfo.event.start.getTime() / 1000));
      },
    });
    calendar.render();
    function deleteEvent(id){
      var event=calendar.getEventById(id);
      event.remove();
    }
  });
</script>
