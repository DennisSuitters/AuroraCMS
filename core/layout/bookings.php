<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Bookings
 * @package    core/layout/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options
 * @changes    v0.0.4 Fix Tooltips
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.18 Add extra status indicators and sorting.
 * @changes    v0.0.18 Fix Cookies for toggling between Table and Calendar views not sticking.
 * @changes    v0.0.19 Add Print Booking Button.
 */
if($view=='add'){
  $ti=time();
  $q=$db->prepare("INSERT INTO `".$prefix."content` (uid,contentType,status,ti,tis) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
  $q->execute([':uid'=>$user['id'],':ti'=>$ti,':tis'=>$ti]);
  $id=$db->lastInsertId();
  $view='bookings';
  $args[0]='edit';
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/bookings/edit/'.$id.'");/*]]>*/</script>';
}elseif(isset($args[1]))$id=$args[1];
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_bookings.php';
elseif($args[0]=='edit')include'core'.DS.'layout'.DS.'edit_bookings.php';
else{
  $sortOrder='';
  $bookSearch=isset($_POST['booksearch'])?" AND LOWER(name) LIKE '%".str_replace(' ','%',strtolower($_POST['booksearch']))."%' OR LOWER(business) LIKE '%".str_replace(' ','%',strtolower($_POST['booksearch']))."%'":'';
//    $bookSearch=str_replace(' ','%',$_POST['booksearch']);
  if(isset($args[0])&&$args[0]=='archived')
    $bookStatus=isset($args[0])?" AND status='archived'":'';
  elseif(isset($args[0])&&$args[0]!='')
    $bookStatus=isset($args[0])?" AND status='".$args[0]."' AND status!='archived'":'';
  else
    $bookStatus=" AND status!='archived'";
  if(isset($_POST['booksort'])){
  	$sort=isset($_POST['booksort'])?filter_input(INPUT_POST,'booksort',FILTER_SANITIZE_STRING):'';
  	$sortOrder=" ORDER BY ";
  	if($sort=="")$sortOrder.="ti DESC";
  	if($sort=="new")$sortOrder.="ti ASC";
  	if($sort=="old")$sortOrder.="ti DESC";
  }

  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='booking'".$bookSearch.$bookStatus.$sortOrder);
  $s->execute();
  $s2=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='booking'".$bookSearch.$bookStatus.$sortOrder);
  $s2->execute();?>
<main id="content" class="main">
  <ol class="breadcrumb shadow">
    <li class="breadcrumb-item active">Bookings <?php echo isset($args[0])&&$args[0]!=''?' / '.$args[0]:'';?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <?php echo$user['options'][2]==1?'<a class="btn btn-ghost-normal add" href="'.URL.$settings['system']['admin'].'/add/bookings" data-tooltip="tooltip" data-placement="left" data-title="Add" role="button" aria-label="Add">'.svg2('add').'</a>':'';?>
        <a href="#" class="btn btn-ghost-normal info<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>" onclick="toggleCalendar();return false;" data-tooltip="tooltip" data-placement="left" data-title="Switch to Table View" role="button" aria-label="Switch to Table View"><?php svg('table');?></a>
        <a href="#" class="btn btn-ghost-normal info<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' d-none':'');?>" onclick="toggleCalendar();return false;" data-tooltip="tooltip" data-placement="left" data-title="Switch to Calendar View" role="button" aria-label="Switch to Calendar View"><?php svg('calendar');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="row">
    <div class="card col">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <small>Legend:
              <a class="badge badge-secondary" href="<?php echo URL.$settings['system']['admin'].'/bookings/';?>" data-tooltip="tooltip" data-title="All Bookings">All</a>
              <a class="badge badge-danger" href="<?php echo URL.$settings['system']['admin'].'/bookings/unconfirmed';?>" data-tooltip="tooltip" data-title="Bookings that have NOT been Confirmed">Unconfirmed</a>
              <a class="badge badge-success" href="<?php echo URL.$settings['system']['admin'].'/bookings/confirmed';?>" data-tooltip="tooltip" data-title="Bookings that have been Confirmed">Confirmed</a>
              <a class="badge badge-warning" href="<?php echo URL.$settings['system']['admin'].'/bookings/in-progress';?>" data-tooltip="tooltip" data-title="Booking that is in Progress">In Progress</a>
              <a class="badge badge-info" href="<?php echo URL.$settings['system']['admin'].'/bookings/complete';?>" data-tooltip="tooltip" data-title="Booking that is Complete">Complete</a>
              <a class="badge badge-secondary" href="<?php echo URL.$settings['system']['admin'].'/bookings/archived';?>" data-tooltip="tooltip" data-title="Booking that is Archived">Archived</a>
            </small>
          </div>
          <div class="col-12 col-sm-6">
            <form method="post" class="form-inline float-center float-sm-right" action="">
              <div class="input-group input-group-sm">
                <small class="input-group-prepend">
                  <small class="input-group-text">Find</small>
                </small>
                <input id="booksearch" name="booksearch" class="form-control form-control-sm" value="<?php echo(isset($_POST['booksearch'])&&$_POST['booksearch']!=''?$_POST['booksearch']:'');?>" placeholder="Business/Name to Find">
                <div class="input-group-append">
                  <select id="bookingsort" class="form-control form-control-sm" name="booksort">
                    <option value="">Select Display Order</option>
                    <option value="new"<?php echo(isset($_POST['booksort'])&&$_POST['booksort']=='new'?' selected':'');?>>Date Old to New</option>
                    <option value="old"<?php echo(isset($_POST['booksort'])&&$_POST['booksort']=='old'?' selected':'');?>>Date New to Old</option>
                  </select>
                </div>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-secondary btn-sm">Go</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
        <div id="calendar-view" class="<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>">
          <div id="calendar"></div>
        </div>
        <div id="table-view" class="table-responsive<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' d-none':'');?>">
          <table class="table table-condensed table-striped table-hover">
            <thead>
              <tr>
                <th class="w-75 d-table-cell d-sm-none"></th>
                <th class="w-5 d-none d-sm-table-cell">Created</th>
                <th class="w-5 d-none d-sm-table-cell">Start/End</th>
                <th class="d-none d-sm-table-cell">Details</th>
                <th class="w-5"></th>
              </tr>
            </thead>
            <tbody id="bookings">
<?php
while($r=$s->fetch(PDO::FETCH_ASSOC)){
$eColor='bg-danger';
if($r['status']=='confirmed')
  $eColor='bg-success';
elseif($r['status']=='in-progress')
  $eColor='bg-warning text-dark';
elseif($r['status']=='complete')
  $eColor='bg-info text-dark';
elseif($r['status']=='archived')
  $eColor='bg-secondary';?>
              <tr id="l_<?php echo$r['id'];?>" class="<?php echo$eColor;?>">
                <td class="d-table-cell d-sm-none">
                  <?php echo date($config['dateFormat'],$r['ti']).'<br>Start: '.date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?'<br>End: ' . date($config['dateFormat'], $r['tie']):'').($r['business']!=''?'<br>Business: '.$r['business']:'').($r['name']!=''?'<br>Name: '.$r['name']:'').($r['email']!=''?'<br>Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a>':'').($r['phone']!=''?'<br>Phone: '.$r['phone']:'');?>
                </td>
                <td class="d-none d-sm-table-cell">
                  <?php echo date($config['dateFormat'],$r['ti']);?></td>
                <td class="d-none d-sm-table-cell">
                  <?php echo date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?date($config['dateFormat'], $r['tie']):'');?>
                </td>
                <td class="d-none d-sm-table-cell">
                  <?php echo ($r['business']!=''?'Business: '.$r['business'].'<br>':'').($r['name']!=''?'Name: '.$r['name'].'<br>':'').($r['email']!=''?'Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>':'').($r['phone']!=''?'Phone: '.$r['phone'].'<br>':'');?>
                </td>
                <td id="controls_<?php echo$r['id'];?>">
                  <div clss="btn-toolbar float-right" role="toolbar" aria-label="Item Toolbar Controls">
                    <div class="btn-group" role="group" aria-label="Item Controls">
                      <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/bookings/edit/<?php echo$r['id'];?>" data-tooltip="tooltip" data-title="Edit" role="button" aria-label="Edit"><?php svg('edit');?></a>
                      <button class="btn btn-secondary" onclick="$('#sp').load('core/print_booking.php?id=<?php echo$r['id'];?>');" data-tooltip="tooltip" data-title="Print Order" aria-label="Print Order"><?php svg('print');?></button>
                      <button class="btn btn-secondary" onclick="$('#sp').load('core/bookingtoinvoice.php?id=<?php echo$r['id'];?>');" data-tooltip="tooltip" data-title="Copy Booking to Invoice" aria-label="Copy Booking to Invoice"><?php svg('bookingtoinvoice');?></button>
<?php if($user['options'][0]==1){?>
                      <button class="btn btn-secondary<?php echo($r['status']!='delete'?' d-none':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" data-title="Restore" role="button" aria-label="Restore"><?php svg('untrash');?></button>
                      <button class="btn btn-secondary rounded-right trash<?php echo($r['status']=='delete'?' d-none':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                      <button class="btn btn-secondary rounded-right trash<?php echo($r['status']!='delete'?' d-none':'');?>" onclick="purge('<?php echo $r['id'];?>','content')" data-tooltip="tooltip" data-title="Purge" aria-label="Purge"><?php svg('purge');?></button>
<?php }?>
                    </div>
                  </div>
                </td>
              </tr>
<?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
<?php if($args[0]!='add'||$args[0]!='edit'){?>
  var $contextMenu=$("#contextMenu");
  $('#calendar').fullCalendar({
    header:{
      left:'prev,next',
      center:'title',
      right:'month,basicWeek,basicDay'
    },
    eventLimit:true,
    selectable:true,
<?php if($user['options'][2]==1){?>editable:true,<?php }?>
    height:$(window).height()*0.83,
    eventRender:function(event,element){
      element.bind('dblclick',function(){
        window.location="<?php echo$settings['system']['admin'];?>/bookings/edit/"+event.id;
      });
    },
    events:[
<?php
while($r=$s2->fetch(PDO::FETCH_ASSOC)){
  $eColor='#f86c6b'; // bg-danger
  if($r['status']=='confirmed')
    $eColor='#4dbd74'; // bg-success
  elseif($r['status']=='in-progress')
    $eColor='#ffc107'; // bg-warning
  elseif($r['status']=='complete')
    $eColor='#63c2de'; // bg-info
  elseif($r['status']=='archived')
    $eColor='#73818f'; // bg-secondary?>
      {
        id:'<?php echo$r['id'];?>',
        title:`<?php echo($r['business']!=''?$r['business']:'').($r['name']!=''?($r['business']!=''?' | ':'').$r['name']:'').($r['business']==''&&$r['name']==''?'Booking '.$r['id']:'');?>`,
        start:'<?php echo date("Y-m-d H:i:s",$r['tis']);?>',
<?php echo$r['tie']>$r['tis']?'eventend: \''.date("Y-m-d H:i:s",$r['tie']).'\',':'';?>
        allDay:false,
        color:'<?php echo$eColor;?>',
        description:'<?php echo($r['business']!=''?'Business: '.$r['business'].'<br>':'').($r['name']!=''?'Name: '.$r['name'].'<br>':'').($r['email']!=''?'Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>':'').($r['phone']!=''?'Phone: '.$r['phone'].'<br>':'');?>',
        status:'<?php echo$r['status'];?>',
      },
<?php	}?>
    ],
    eventMouseover:function(event,domEvent,view){
      var layer='<div id="events-layer" class="btn-group float-right">';
<?php if($user['options'][2]==1){?>
      layer+=`<button id="prbut`+event.id+`" class="btn btn-secondary btn-xs" data-tooltip="tooltip" data-title="Print Order" aria-label="Print Order"><?php svg('print');?></button>`;
      layer+='<button id="edbut'+event.id+'" class="btn btn-secondary btn-xs" data-tooltip="tooltip" data-title="Edit" aria-label="Edit"><?php svg('edit');?></button>';
      layer+='<button id="bibut'+event.id+'" class="btn btn-secondary btn-xs" data-tooltip="tooltip" data-title="Copy Booking to Invoice" aria-label="Copy Booking to Invoice"><?php svg('bookingtoinvoice');?></button>';
      layer+='<button id="delbut'+event.id+'" class="btn btn-secondary btn-xs trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button></div>';
<?php }else{?>
      layer+='<button id="edbut'+event.id+'" class="btn btn-secondary btn-xs" data-tooltip="tooltip" data-title="View" aria-label="View"><?php svg('view');?></button>';
<?php }?>
      var content="Start: "+$.fullCalendar.moment(event.start).format('HH:mm');
<?php echo$r['tie']>$r['tis']?'content+=\'<br>End: \'+$.fullCalendar.moment(event.eventend).format(\'HH:mm\');':'';?>
      if(event.description!='')content+='<br>'+event.description;
      var el=$(this);
      el.append(layer);
      if(event.eventend!=''||event.eventend!=null||event.eventend!=0){
        var eventEndClass='eventEnd';
        if(event.status=='confirmed')eventEndClass='eventEndConfirmed';
        $('[data-date="'+moment(event.eventend).format('YYYY-MM-DD')+'"]').addClass(eventEndClass);
      }
      $("#prbut"+event.id).click(function(){
         $('#sp').load('core/print_booking.php?id='+event.id);
      });
      $("#bibut"+event.id).click(function(){
        $('#sp').load('core/bookingtoinvoice.php?id='+event.id);
<?php if($config['options'][25]==1){?>
        $('#calendar').fullCalendar('removeEvents',event.id);
        window.top.window.purge(event.id,"content");
        window.top.window.$(el).remove();
        window.top.window.$(".popover").remove();
<?php }?>
      });
      $("#delbut"+event.id).click(function(){
        $('#calendar').fullCalendar('removeEvents',event.id);
        window.top.window.purge(event.id,"content");
        window.top.window.$(el).remove();
        window.top.window.$(".popover").remove();
      });
      $("#edbut"+event.id).click(function(){
        window.location="<?php echo$settings['system']['admin'];?>/bookings/edit/"+event.id;
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
      if(event.status=='confirmed')eventEndClass='eventEndConfirmed';
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
      updateButtons(event.id,"content","tis",event.start.unix());
    }
  });
  $(window).resize(function(){
    var calHeight=$(window).height()*0.83;
    $('#calendar').fullCalendar('option','height',calHeight);
  });
<?php }?>
</script>
<?php }
