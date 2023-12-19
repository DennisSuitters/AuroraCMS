<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Bookings
 * @package    core/layout/bookings.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='20'");
$sv->execute();
if($view=='add'){
  $ti=time();
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`uid`,`contentType`,`status`,`ti`,`tis`) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
  $q->execute([
    ':uid'=>$user['id'],
    ':ti'=>$ti,
    ':tis'=>$ti
  ]);
  $id=$db->lastInsertId();
  $view='bookings';
  $args[0]='edit';
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/bookings/edit/'.$id.'");/*]]>*/</script>';
}elseif(isset($args[1]))$id=$args[1];
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_bookings.php';
elseif(isset($args[0])&&$args[0]=='edit')
  require'core/layout/edit_bookings.php';
else{
  $sortOrder='';
  $bookSearch=isset($_POST['booksearch'])?" AND LOWER(`name`) LIKE '%".str_replace(' ','%',strtolower($_POST['booksearch']))."%' OR LOWER(`business`) LIKE '%".str_replace(' ','%',strtolower($_POST['booksearch']))."%'":'';
//    $bookSearch=str_replace(' ','%',$_POST['booksearch']);
  if(isset($args[0])&&$args[0]=='archived')
    $bookStatus=isset($args[0])?" AND `status`='archived'":'';
  elseif(isset($args[0])&&$args[0]!='')
    $bookStatus=isset($args[0])?" AND `status`='".$args[0]."' AND `status`!='archived'":'';
  else
    $bookStatus=" AND `status`!='archived'";
  if(isset($_POST['booksort'])){
  	$sort=isset($_POST['booksort'])?filter_input(INPUT_POST,'booksort',FILTER_UNSAFE_RAW):'';
  	$sortOrder=" ORDER BY ";
  	if($sort=="")$sortOrder.="`ti` DESC";
  	if($sort=="new")$sortOrder.="`ti` ASC";
  	if($sort=="old")$sortOrder.="`ti` DESC";
  }
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='booking'".$bookSearch.$bookStatus.$sortOrder);
  $s->execute();
  $s2=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='booking'".$bookSearch.$bookStatus.$sortOrder);
  $s2->execute();?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-4">
                <ol class="breadcrumb m-0 p-0">
                  <li class="breadcrumb-item active">Bookings <?= isset($args[0])&&$args[0]!=''?' / '.$args[0]:'';?></li>
                </ol>
              </div>
              <div class="col-12 col-sm-8">
                <div class="row">
                  <div class="btn-group">
                    <form class="form-row" method="post" action="">
                      <input id="booksearch" name="booksearch" value="<?=(isset($_POST['booksearch'])&&$_POST['booksearch']!=''?$_POST['booksearch']:'');?>" placeholder="Business/Name to Find">
                      <select id="bookingsort" name="booksort">
                        <option value="">Select Display Order</option>
                        <option value="new"<?=(isset($_POST['booksort'])&&$_POST['booksort']=='new'?' selected':'');?>>Date Old to New</option>
                        <option value="old"<?=(isset($_POST['booksort'])&&$_POST['booksort']=='old'?' selected':'');?>>Date New to Old</option>
                      </select>
                      <button type="submit">Go</button>
                      <?=$user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/bookings/settings" role="button" aria-label="Bookings Settings"><i class="i">settings</i></a>':'';?>
                      <button class="calview <?=(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>" data-tooltip="left" aria-label="Switch to Table View" onclick="toggleBookingView();return false;"><i class="i">table</i></button>
                      <button class="calview<?=(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='calendar')?' d-none':'');?>" data-tooltip="left" aria-label="Switch to Calendar View" onclick="toggleBookingView();return false;"><i class="i">calendar</i></button>
                      <?=($user['options'][2]==1?'<a class="add" data-tooltip="left" href="'.URL.$settings['system']['admin'].'/add/bookings" role="button" aria-label="Add"><i class="i">add</i></a>':'');?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">Legend:
              <a class="badger badge-secondary" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/bookings/';?>" aria-label="View All Bookings">All</a>
              <a class="badger badge-danger" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/bookings/unconfirmed';?>" aria-label="View Unconfirmed Bookings">Unconfirmed</a>
              <a class="badger badge-success" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/bookings/confirmed';?>" aria-label="View Confirmed Bookings">Confirmed</a>
              <a class="badger badge-warning" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/bookings/in-progress';?>" aria-label="View In Progress Bookings">In Progress</a>
              <a class="badger badge-info" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/bookings/complete';?>" aria-label="View Complete Bookings">Complete</a>
              <a class="badger badge-secondary" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/bookings/archived';?>" aria-label="View Archived Bookings">Archived</a>
            </div>
          </div>
          <div id="list-view" class="mt-3<?=(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' d-none':'');?>">
            <div class="row sticky-top">
              <article class="card py-2 overflow-visible card-list card-list-header shadow">
                <div class="row">
                  <div class="col-12 col-md"></div>
                  <div class="col-12 col-md pl-2">Created</div>
                  <div class="col-12 col-md pl-2">Start/End</div>
                  <div class="col-12 col-md pl-2">Details</div>
                  <div class="col-12 col-md"></div>
                </div>
              </article>
            </div>
            <div class="row" id="bookings">
              <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <article class="card py-3 overflow-visible card-list small shadow<?php
                  if($r['status']=='confirmed')echo' bg-success';
                  elseif($r['status']=='in-progess')echo' bg-warning';
                  elseif($r['status']=='complete')echo' bg-info';
                  elseif($r['status']=='delete')echo' bg-danger';
                  elseif($r['status']=='archived')echo' bg-info';
                  elseif($r['status']=='unpublished')echo' bg-warning';?>" id="l_<?=$r['id'];?>">
                  <div class="row">
                    <div class="col-12 col-md pl-2">
                      <?= date($config['dateFormat'],$r['ti']).'<br>'.
                      'Start: '.date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?'<br>End: '.
                      date($config['dateFormat'], $r['tie']):'').($r['business']!=''?'<br>'.
                      'Business: '.$r['business']:'').
                      ($r['name']!=''?'<br>Name: '.$r['name']:'').
                      ($r['email']!=''?'<br>Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a>':'').
                      ($r['phone']!=''?'<br>Phone: '.$r['phone']:'');?>
                    </div>
                    <div class="col-12 col-md"><?= date($config['dateFormat'],$r['ti']);?></div>
                    <div class="col-12 col-md">
                      <?= date($config['dateFormat'],$r['tis']).
                      ($r['tie']>$r['tis']?date($config['dateFormat'], $r['tie']):'');?>
                    </div>
                    <div class="col-12 col-md">
                      <?=($r['business']!=''?'Business: '.$r['business'].'<br>':'').
                      ($r['name']!=''?'Name: '.$r['name'].'<br>':'').
                      ($r['email']!=''?'Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>':'').
                      ($r['phone']!=''?'Phone: '.$r['phone'].'<br>':'');?>
                    </div>
                    <div class="col-12 col-md">
                      <div class="btn-group" role="group">
                        <a data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/bookings/edit/<?=$r['id'];?>" role="button" aria-label="<?=$user['options'][2]==1?'Edit':'View';?>"><i class="i"><?=$user['options'][2]==1?'edit':'view';?></i></a>
                        <button data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/print_booking.php?id=<?=$r['id'];?>');"><i class="i">print</i></button>
                        <?php if($user['options'][2]==1){?>
                          <button data-tooltip="tooltip" aria-label="Copy Booking to Job List" onclick="$('#sp').load('core/bookingtojoblist.php?id=<?=$r['id'];?>');"><i class="i">joblist</i></button>
                          <button data-tooltip="tooltip" aria-label="Copy Booking to Invoice" onclick="$('#sp').load('core/bookingtoinvoice.php?id=<?=$r['id'];?>');"><i class="i">bookingtoinvoice</i></button>
                          <button class="<?=($r['status']!='delete'?' d-none':'');?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','content','status','unpublished');"><i class="i">untrash</i></button>
                          <button class="trash<?=($r['status']=='delete'?' d-none':'');?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','content','status','delete');"><i class="i">trash</i></button>
                          <button class="purge<?=($r['status']!='delete'?' d-none':'');?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','content');"><i class="i">purge</i></button>
                        <?php }?>
                      </div>
                    </div>
                  </div>
                </article>
              <?php }?>
            </div>
          </div>
          <div class="row mt-3<?=(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>" id="calendar-view">
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
      <?php if($user['options'][2]==1){?>editable:true,<?php }?>
      height:'100vh',
      selectable:false,
      nowIndicator:true,
      dayMaxEvents:true,
      events:[
        <?php while($r=$s2->fetch(PDO::FETCH_ASSOC)){
          $eColor='danger';
          if($r['status']=='confirmed')
            $eColor='success';
          elseif($r['status']=='in-progress')
            $eColor='warning';
          elseif($r['status']=='complete')
            $eColor='info';
          elseif($r['status']=='archived')
            $eColor='secondary';?>
          {
            id:'<?=$r['id'];?>',
            title:`<?=($r['business']!=''?$r['business']:'').($r['name']!=''?($r['business']!=''?' | ':'').$r['name']:'').($r['business']==''&&$r['name']==''?'Booking '.$r['id']:'');?>`,
            start:'<?= date("Y-m-d H:i:s",$r['tis']);?>',
            <?=$r['tie']>$r['tis']?'end: \''.date("Y-m-d H:i:s",$r['tie']).'\',':'';?>
            allDay:false,
            customHtml:`<div class="badger badge-<?=$eColor;?> events-layer text-left"><?=($r['business']!=''?$r['business']:'').($r['name']!=''?($r['business']!=''?' | ':'').$r['name']:'').($r['business']==''&&$r['name']==''?'Booking '.$r['id']:'');?><div class="events-buttons" role="toolbar"><div class="btn-group" role="group">` +
            <?php if($user['options'][2]==1){?>
              `<button class="btn-sm" id="prbut<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Print Booking" onclick="$('#sp').load('core/print_booking.php?id=<?=$r['id'];?>');"><i class="i">print</i></button>`+
              `<a class="btn-sm" id="edbut<?=$r['id'];?>" data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/bookings/edit/'.$r['id'];?>" role="button" aria-label="Edit"><i class="i">edit</i></a>`+
              `<button class="btn-sm" id="jlbut<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Copy Booking to Job List" onclick="$('#sp').load('core/bookingtojoblist.php?id=<?=$r['id'];?>');"><i class="i">joblist</i></button>`+
              `<button class="btn btn-sm" id="bibut<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Copy Booking to Invoice" onclick="$('#sp').load('core/bookingtoinvoice.php?id=<?=$r['id'];?>');"><i class="i">bookingtoinvoice</i></button>`+
              `<button class="btn-sm trash" id="delbut<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','content');$(this).closest('.events-layer').remove();"><i class="i">trash</i></button>`+
            <?php }else{?>
              '<a class="btn btn-sm" id="edbut<?=$r['id'];?>" data-tooltip="tooltip" href="<?=$settings['system']['admin'].'/bookings/edit/'.$r['id'];?>" aria-label="View"><i class="i">view</i></a>'+
            <?php }?>
            `</div></div></div>`
          },
          <?php	}?>
        ],
        eventContent:function(eventInfo){
          return{html:eventInfo.event.extendedProps.customHtml}
        },
        eventDrop:function(eventInfo){
          update(eventInfo.event.id,"content","tis",(eventInfo.event.start.getTime() / 1000));
        },
      });
      calendar.render();
      function deleteEvent(id){
        var event=calendar.getEventById(id);
        event.remove();
      }
    </script>
  <?php }
