<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Scheduler
 * @package    core/layout/scheduler.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.11
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options
 * @changes    v0.0.3 Add AutoPublish
 * @changes    v0.0.3 Fix Actions
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active">Scheduler</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div id="calendar-view" class="col">
          <small>Legend: <span class="badge badge-success" data-tooltip="tooltip" data-title="Content items that have already been Published.">Published</span> <span class="badge badge-danger" data-tooltip="tooltip" data-title="Content items that have NOT been Published.">Unpublished</span> <span class="badge badge-warning" data-tooltip="tooltip" data-title="Content items that are set to AutoPublish.">AutoPublish</span></small>
          <div class="float-right">
            <small>View: <a class="badge badge-<?php echo !isset($args[1])?'success':'secondary';?>" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>">All</a>
<?php $s=$db->query("SELECT DISTINCT(contentType) as contentType FROM `".$prefix."content` WHERE contentType!='booking' ORDER BY contentType ASC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <a class="badge badge-<?php echo isset($args[1])&&$args[1]==$r['contentType']?'success':'secondary';?>" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']);?></a>&nbsp;
<?php }?>
            </small>
          </div>
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  var $contextMenu=$("#contextMenu");
  $('#calendar').fullCalendar({
    header:{
      left:'prev,next',
      center:'title',
      right:'month,basicWeek,basicDay'
    },
    eventLimit:true,
    selectable:true,
    editable:<?php echo$user['options'][1]==1?'true':'false';?>,
    height:$(window).height()*0.83,
    events:[
<?php //$args[1]=!isset($args[1])||$args[1]==''?'%':$args[1];
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType");
$s->execute([':contentType'=>!isset($args[1])||$args[1]==''?'%':$args[1]]);
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
      {
        id:'<?php echo$r['id'];?>',
        title:`<?php echo$r['title'];?>`,
        start:`<?php echo date("Y-m-d H:i:s",$r['pti']);?>`,
        allDay:true,
        color:'<?php if($r['status']=='published')echo'#4dbd74';elseif($r['status']=='autopublish')echo'#ffc107';else echo'#f86c6b';?>',
        description:`<?php echo ucfirst($r['contentType']).`: `.$r['title'];?>`,
        status:`<?php echo$r['status'];?>`,
        views:`<?php echo$r['views'];?>`
      },
<?php	}?>
    ],
    eventMouseover:function(event,domEvent,view){
      var layer='<div id="events-layer" class="btn-group float-right">'+
<?php if($user['options'][1]==1){?>
        '<button id="edbut'+event.id+'" class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="Edit" aria-label="Edit"><?php svg('edit');?></button>'+
        '<button id="delbut'+event.id+'" class="btn btn-secondary btn-sm trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>'+
<?php }else{?>
        '<button id="edbut'+event.id+'" class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-title="View" aria-label="View"><?php svg('view');?></button>'+
<?php }?>
        '</div>';
      var content=event.description+'<br>Publish Date: '+$.fullCalendar.moment(event.start).format('Do MMM YYYY, k:mm')+'<br>Views: '+event.views;
      var el=$(this);
      el.append(layer);
      if(event.eventend!=''||event.eventend!=null||event.eventend!=0){
        var eventEndClass='eventEnd';
        $('[data-date="'+moment(event.eventend).format('YYYY-MM-DD')+'"]').addClass(eventEndClass);
      }
      $("#cbut"+event.id).click(function(){
        $("#cbut"+event.id).remove();
        $("#events-layer").remove();
        event.color="#4dbd74";
        event.status="published";
        updateButtons(event.id,"content","status","confirmed");
        $("#calendar").fullCalendar("updateEvent",event);
      });
      $("#delbut"+event.id).click(function(){
        $('#calendar').fullCalendar('removeEvents',event.id);
        window.top.window.purge(event.id,"content");
        window.top.window.$(el).remove();
        window.top.window.$(".popover").remove();
      });
      $("#edbut"+event.id).click(function(){
        window.location="<?php echo$settings['system']['admin'];?>/content/edit/"+event.id;
      });
      $(this).popover({
        title:event.title,
        placement:"top",
        html:true,
        container:"body",
        content:content,
      }).popover("show");
    },
    eventMouseout:function(event){
      $("#events-layer").remove();
      $(this).not(event).popover("hide");
      var eventEndClass='eventEnd';
      if(event.status=='published')eventEndClass='eventEndConfirmed';
      $('[data-date="'+moment(event.eventend).format('YYYY-MM-DD')+'"]').removeClass(eventEndClass);
      $('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
    },
    dayClick:function(date,jsEvent,view){
      if(view.name=='month'||view.name=='basicWeek'){
        $('#calendar').fullCalendar('changeView','basicDay');
        $('#calendar').fullCalendar('gotoDate',date);
      }
    },
    eventDrop:function(event){
      updateButtons(event.id,"content","pti",event.start.unix());
      if(event.start.unix()>moment().unix()){
        if(event.status=='autopublish'){
          updateButtons(event.id,"content","status",'autopublish');
          event.color="#ffc107";
          event.status='autopublish';
        }
        if(event.status=='unpublished'){
          updateButtons(event.id,"content","status",'unpublished');
          event.color="#f86c6b";
          event.status='unpublished';
        }
        if(event.status=='published'){
          updateButtons(event.id,"content","status",'unpublished');
          event.color="#f86c6b";
          event.status='unpublished';
        }
      }
      if(event.start.unix()<moment().unix()){
        if(event.status=='autopublish'){
          updateButtons(event.id,"content","status",'autopublish');
          event.color='#4dbd74';
          event.status='published';
        }
        if(event.status=='unpublished'){
          updateButtons(event.id,"content","status",'unpublished');
          event.color='#f86c6b';
          event.status='unpublished';
        }
      }
      $("#calendar").fullCalendar("updateEvent",event);
    }
  });
  $(window).resize(function(){
    var calHeight=$(window).height()*0.83;
    $('#calendar').fullCalendar('option','height',calHeight);
  });
</script>
