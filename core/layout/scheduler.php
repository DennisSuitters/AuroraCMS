<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Scheduler
 * @package    core/layout/scheduler.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
            <li class="breadcrumb-item active">Scheduler</li>
          </ol>
        </div>
        <div class="row">
          <div class="col-12 col-md-4">
            <small>Legend:
              <span class="badger badge-success" data-tooltip="tooltip" aria-label="Content items that have already been Published.">Published</span>
              <span class="badger badge-danger" data-tooltip="tooltip" aria-label="Content items that have NOT been Published.">Unpublished</span>
              <span class="badger badge-warning" data-tooltip="tooltip" aria-label="Content items that are set to AutoPublish.">AutoPublish</span>
            </small>
          </div>
          <div class="col-12 col-md-8 text-right">
            <small>View:
              <a class="badger badge-<?= !isset($args[1])?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'].'/content/scheduler';?>" data-tooltip="tooltip" aria-label="Display All Content">All</a>&nbsp;
              <?php $s=$db->query("SELECT DISTINCT(`contentType`) AS contentType FROM `".$prefix."content` WHERE `contentType`!='booking' ORDER BY `contentType` ASC");
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <a class="badger badge-<?= isset($args[1])&&$args[1]==$r['contentType']?'success':'secondary';?>" href="<?= URL.$settings['system']['admin'].'/content/scheduler/'.$r['contentType'];?>" data-tooltip="tooltip" aria-label="Display <?= ucfirst($r['contentType']);?> Items"><?= ucfirst($r['contentType']);?></a>&nbsp;
              <?php }?>
            </small>
          </div>
        </div>
        <div id="calendar-view" class="row mt-3">
          <div id="calendar"></div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
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
      <?php if($user['options'][1]==1){?>editable:true,<?php }?>
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
            customHtml:`<div class="badger badge-<?=$eColor;?> events-layer text-left" data-contentType="<?= ucfirst($r['contentType']);?>">`+
              `<?=$r['title'];?>`+
              `<div class="events-buttons" role="toolbar" data-tooltip="tooltip" aria-label="Item Toolbar Controls">`+
                `<div class="btn-group" role="group" data-tooltip="tooltip" aria-label="Item Controls">`+
                <?php if($user['options'][1]==1){?>
                  `<a class="btn btn-sm" id="edbut<?=$r['id'];?>" href="<?=$settings['system']['admin'].'/content/edit/'.$r['id'];?>" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>`+
                  `<button class="btn-sm trash" id="delbut<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','content');$(this).closest('.events-layer').remove();"><i class="i">trash</i></button>`+
                <?php }else{?>
                  `<a class="btn btn-sm" id="edbut<?=$r['id'];?>" href="<?=$settings['system']['admin'].'/content/edit/'.$r['id'];?>" data-tooltip="tooltip" aria-label="View"><i class="i">view</i></a>`+
                <?php }?>
                `</div>`+
              `</div>`+
            `</div>`
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
