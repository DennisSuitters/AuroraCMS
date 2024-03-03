<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Roster
 * @package    core/layout/roster.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='67'");
$sv->execute();
if($view=='add'){
  $ti=time();
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."roster` (`title`,`tis`,`tie`,`status`,`ti`) VALUES (:title,:tis,:tie,'available',:ti)");
  $q->execute([
    ':title'=>date('l',$ti).' Shift',
    ':tis'=>$ti,
    ':tie'=>$ti,
    ':ti'=>$ti,
  ]);
  $id=$db->lastInsertId();
  $view='roster';
  $args[0]='edit';
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/roster/edit/'.$id.'");/*]]>*/</script>';
}elseif(isset($args[1]))$id=$args[1];
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_roster.php';
elseif(isset($args[0])&&$args[0]=='edit')
  require'core/layout/edit_roster.php';
else{
  $s=$db->prepare("SELECT * FROM `".$prefix."roster`");
  $s->execute();?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-6">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active">Roster <?= isset($args[0])&&$args[0]!=''?' / '.$args[0]:'';?></li>
                </ol>
              </div>
              <div class="col-12 col-sm-6 text-right">
                <div class="btn-group d-inline">
                  <?=($user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/roster/settings" role="button" aria-label="Roster Settings"><i class="i">settings</i></a>':'').
                  ($user['options'][2]==1?'<a class="add" data-tooltip="left" href="'.URL.$settings['system']['admin'].'/add/roster" role="button" aria-label="Add Roster Shift"><i class="i">add</i></a>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3" id="calendar-view">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </section>
  </main>
  <script>
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
      editable:false,
      height:'100vh',
      selectable:false,
      nowIndicator:true,
      dayMaxEvents:true,
      events:[
        <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
          $ru=[
            'id' => 0,
            'username' => '',
            'name' => 'Shift Available',
            'rank' => ''
          ];
          if($r['uid']!=0){
            $su=$db->prepare("SELECT `id`,`username`,`name`,`rank` FROM `".$prefix."login` WHERE `id`=:id");
            $su->execute([':id'=>$r['uid']]);
            $ru=$su->fetch(PDO::FETCH_ASSOC);
          }
          $eColor='success';
          if($r['status']=='accepted')
            $eColor='warning';
          elseif($r['status']=='available')
            $eColor='secondary';?>
          {
            id:'<?=$r['id'];?>',
            title:`<?=($ru['name']!=''?$ru['name']:$ru['username']);?>`,
            start:'<?= date("Y-m-d H:i:s",$r['tis']);?>',
            <?=$r['tie']>$r['tis']?'end: \''.date("Y-m-d H:i:s",$r['tie']).'\',':'';?>
            allDay:false,
            customHtml:`<div class="badger badge-<?=$eColor;?> events-layer text-left" data-tooltip="tooltip" aria-label="<?=date('H:s',$r['tis']).'-'.date('H:s',$r['tie']);?>"><?=($ru['name']!=''?$ru['name']:$ru['username']);?><div class="events-buttons" role="toolbar"><div class="btn-group" role="group">` +
            <?php if($user['options'][2]==1){?>
              `<a class="btn-sm" id="edbut<?=$r['id'];?>" data-tooltip="bottom" href="<?=$settings['system']['admin'].'/roster/edit/'.$r['id'];?>" role="button" aria-label="Edit"><i class="i">edit</i></a>`+
              `<button class="btn-sm trash" id="delbut<?=$r['id'];?>" data-tooltip="bottom" aria-label="Delete" onclick="purge('<?=$r['id'];?>','roster');$(this).closest('.events-layer').remove();"><i class="i">trash</i></button>`+
            <?php }else{?>
              '<a class="btn btn-sm" id="edbut<?=$r['id'];?>" data-tooltip="bottom" href="<?=$settings['system']['admin'].'/roster/edit/'.$r['id'];?>" aria-label="View"><i class="i">view</i></a>'+
            <?php }?>
            `</div></div></div>`
          },
          <?php	}?>
        ],
        eventContent:function(eventInfo){
          return{html:eventInfo.event.extendedProps.customHtml}
        },
        eventDrop:function(eventInfo){
          update(eventInfo.event.id,"roster","ti",(eventInfo.event.start.getTime() / 1000));
        },
      });
      calendar.render();
      function deleteEvent(id){
        var event=calendar.getEventById(id);
        event.remove();
      }
    </script>
  <?php }
