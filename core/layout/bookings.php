<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Bookings
 * @package    core/layout/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
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
}elseif(isset($args[1]))
  $id=$args[1];
if($args[0]=='settings')
  require'core/layout/set_bookings.php';
elseif($args[0]=='edit')
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
  	$sort=isset($_POST['booksort'])?filter_input(INPUT_POST,'booksort',FILTER_SANITIZE_STRING):'';
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
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('calendar','i-3x');?></div>
          <div>Bookings</div>
          <div class="content-title-actions">
            <?php echo$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/bookings/settings" role="button" aria-label="Bookings Settings">'.svg2('settings').'</a>':'';?>
            <button class="<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>" data-tooltip="tooltip" aria-label="Switch to Table View" onclick="toggleCalendar();return false;"><?php svg('table');?></button>
            <button class="<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' d-none':'');?>" data-tooltip="tooltip" aria-label="Switch to Calendar View" onclick="toggleCalendar();return false;"><?php svg('calendar');?></button>
            <?php echo$user['options'][2]==1?'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/add/bookings" role="button" aria-label="Add">'.svg2('add').'</a>':'';?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Bookings <?php echo isset($args[0])&&$args[0]!=''?' / '.$args[0]:'';?></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow overflow-visible">
        <div class="row p-3">
          <div class="col-12 col-sm-6">
            <small>Legend:
              <a class="badger badge-secondary" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/bookings/';?>" aria-label="View All Bookings">All</a>
              <a class="badger badge-danger" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/bookings/unconfirmed';?>" aria-label="View Unconfirmed Bookings">Unconfirmed</a>
              <a class="badger badge-success" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/bookings/confirmed';?>" aria-label="View Confirmed Bookings">Confirmed</a>
              <a class="badger badge-warning" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/bookings/in-progress';?>" aria-label="View In Progress Bookings">In Progress</a>
              <a class="badger badge-info" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/bookings/complete';?>" aria-label="View Complete Bookings">Complete</a>
              <a class="badger badge-secondary" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'].'/bookings/archived';?>" aria-label="View Archived Bookings">Archived</a>
            </small>
          </div>
          <div class="col-12 col-sm-6">
            <form class="form-row" method="post" action="">
              <input id="booksearch" name="booksearch" value="<?php echo(isset($_POST['booksearch'])&&$_POST['booksearch']!=''?$_POST['booksearch']:'');?>" placeholder="Business/Name to Find">
              <select id="bookingsort" name="booksort">
                <option value="">Select Display Order</option>
                <option value="new"<?php echo(isset($_POST['booksort'])&&$_POST['booksort']=='new'?' selected':'');?>>Date Old to New</option>
                <option value="old"<?php echo(isset($_POST['booksort'])&&$_POST['booksort']=='old'?' selected':'');?>>Date New to Old</option>
              </select>
              <button type="submit">Go</button>
            </form>
          </div>
        </div>
        <div class="row p-3<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>" id="calendar-view">
          <div id="calendar"></div>
        </div>
        <table class="table-zebra<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' d-none':'');?>">
          <thead>
              <tr>
                <th class="d-table-cell d-sm-none"></th>
                <th class="d-none d-sm-table-cell">Created</th>
                <th class="d-none d-sm-table-cell">Start/End</th>
                <th class="d-none d-sm-table-cell">Details</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="bookings">
              <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <tr class="<?php
                if($r['status']=='confirmed')
                  echo'bg-success';
                elseif($r['status']=='in-progess')
                  echo'bg-warning';
                elseif($r['status']=='complete')
                  echo'bg-info';
                elseif($r['status']=='delete')
                  echo' bg-danger';
                elseif($r['status']=='archived')
                  echo' bg-info';
                elseif($r['status']=='unpublished')
                  echo' bg-warning';?>" id="l_<?php echo$r['id'];?>">
                  <td class="d-table-cell d-sm-none">
                    <?php echo date($config['dateFormat'],$r['ti']).'<br>Start: '.date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?'<br>End: ' . date($config['dateFormat'], $r['tie']):'').($r['business']!=''?'<br>Business: '.$r['business']:'').($r['name']!=''?'<br>Name: '.$r['name']:'').($r['email']!=''?'<br>Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a>':'').($r['phone']!=''?'<br>Phone: '.$r['phone']:'');?>
                  </td>
                  <td class="d-none d-sm-table-cell"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                  <td class="d-none d-sm-table-cell"><?php echo date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?date($config['dateFormat'], $r['tie']):'');?></td>
                  <td class="d-none d-sm-table-cell"><?php echo ($r['business']!=''?'Business: '.$r['business'].'<br>':'').($r['name']!=''?'Name: '.$r['name'].'<br>':'').($r['email']!=''?'Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>':'').($r['phone']!=''?'Phone: '.$r['phone'].'<br>':'');?></td>
                  <td class="align-middle" id="controls_<?php echo$r['id'];?>">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                      <div class="btn-group" role="group" aria-label="Item Controls">
                        <a class="btn" data-tooltip="tooltip" href="<?php echo URL.$settings['system']['admin'];?>/bookings/edit/<?php echo$r['id'];?>" role="button" aria-label="Edit"><?php svg('edit');?></a>
                        <button data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/print_booking.php?id=<?php echo$r['id'];?>');"><?php svg('print');?></button>
                        <button class="btn" data-tooltip="tooltip" aria-label="Copy Booking to Invoice" onclick="$('#sp').load('core/bookingtoinvoice.php?id=<?php echo$r['id'];?>');"><?php svg('bookingtoinvoice');?></button>
                        <?php if($user['options'][0]==1){?>
                          <button class="btn<?php echo($r['status']!='delete'?' d-none':'');?>" id="untrash<?php echo$r['id'];?>" data-tooltip="tooltip" role="button" aria-label="Restore" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished');"><?php svg('untrash');?></button>
                          <button class="btn trash<?php echo($r['status']=='delete'?' d-none':'');?>" id="delete<?php echo$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete');"><?php svg('trash');?></button>
                          <button class="btn trash<?php echo($r['status']!='delete'?' d-none':'');?>" id="purge<?php echo$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?php echo $r['id'];?>','content');"><?php svg('purge');?></button>
                        <?php }?>
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
    </div>
  </section>
</main>
<script>
  <?php if($args[0]!='add'||$args[0]!='edit'){?>
    document.addEventListener('DOMContentLoaded',function(){
      var calendarEl=document.getElementById('calendar');
      var calendar=new FullCalendar.Calendar(calendarEl,{
        expandRows:true,
        headerToolbar:{
          left:'prev today',
          center:'title',
          right:'dayGridMonth,today next',
        },
        initialView:'dayGridMonth',
        navLinks:true,
        <?php if($user['options'][2]==1){?>editable:true,<?php }?>
        height:'auto',
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
            id:'<?php echo$r['id'];?>',
            title:`<?php echo($r['business']!=''?$r['business']:'').($r['name']!=''?($r['business']!=''?' | ':'').$r['name']:'').($r['business']==''&&$r['name']==''?'Booking '.$r['id']:'');?>`,
            start:'<?php echo date("Y-m-d H:i:s",$r['tis']);?>',
            <?php echo$r['tie']>$r['tis']?'end: \''.date("Y-m-d H:i:s",$r['tie']).'\',':'';?>
            allDay:false,
            customHtml:`<div class="badger badge-<?php echo$eColor;?> events-layer text-left"><?php echo($r['business']!=''?$r['business']:'').($r['name']!=''?($r['business']!=''?' | ':'').$r['name']:'').($r['business']==''&&$r['name']==''?'Booking '.$r['id']:'');?>` +
              '<div class="events-buttons" role="toolbar" aria-label="Item Toolbar Controls">' +
                '<div class="btn-group" role="group" aria-label="Item Controls">' +
<?php if($user['options'][2]==1){?>
                  `<button class="btn" id="prbut<?php echo$r['id'];?>" data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/print_booking.php?id=<?php echo$r['id'];?>');"><?php svg('print');?></button>` +
                  '<a class="btn" id="edbut<?php echo$r['id'];?>" data-tooltip="tooltip" href="<?php echo$settings['system']['admin'].'/bookings/edit/'.$r['id'];?>" role="button" aria-label="Edit"><?php svg('edit');?></a>' +
                  `<button class="btn" id="bibut<?php echo$r['id'];?>" data-tooltip="tooltip" aria-label="Copy Booking to Invoice" onclick="$('#sp').load('core/bookingtoinvoice.php?id=<?php echo$r['id'];?>');"><?php svg('bookingtoinvoice');?></button>` +
                  `<button class="btn trash" id="delbut<?php echo$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?php echo$r['id'];?>','content');$(this).closest('.events-layer').remove();"><?php svg('trash');?></button>` +
<?php }else{?>
                  '<a class="btn" id="edbut<?php echo$r['id'];?>" data-tooltip="tooltip" href="<?php echo$settings['system']['admin'].'/bookings/edit/'.$r['id'];?>" aria-label="View"><?php svg('view');?></a>' +
<?php }?>
                `</div>` +
              `</div>` +
            `</div>`
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
    });
<?php } ?>
</script>
<?php }
