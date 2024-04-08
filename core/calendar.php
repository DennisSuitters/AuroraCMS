<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Calendar
 * @package    core/calendar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    Fix URL Slug reference going to brokwn URL.
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$uid=isset($_GET['uid'])?filter_input(INPUT_GET,'uid',FILTER_SANITIZE_NUMBER_INT):0;
$type=isset($_GET['type'])?filter_input(INPUT_GET,'type',FILTER_UNSAFE_RAW):'';
if(in_array($type,['roster','bookings'])){
  $ics="BEGIN:VCALENDAR\r\n".
    "VERSION:2.0\r\n".
    "PRODID;X-RICAL-TZSOURCE=TZINFO:-//".($config['business']!=''?$config['business']:'AuroraCMS')." ".ucfirst($type)." Manager//NONSGML AuroraCMS ICS Output//EN\r\n".
    "NAME:".$config['business']." ".ucfirst($type)."\r\n".
    "X-WR-CALNAME:".$config['business']." ".ucfirst($type)."\r\n".
    "TIMEZONE-ID:".$config['timezone']."\r\n".
    "X-WR-TIMEZONE:".$config['timezone']."\r\n".
    "REFRESH-INTERVAL;VALUE=DURATION:PT0:15H\r\n".
    "X-PUBLISHED-TTL:PT0:15H\r\n".
    "COLOR:255:64:0\r\n".
    "CALSCALE:GREGORIAN\r\n";
  if($type=='roster'){
    if($uid!=0){
      $s=$db->prepare("SELECT * FROM `".$prefix."roster` WHERE `uid`=:uid");
      $s->execute([':uid'=>$uid]);
    }else{
      $s=$db->prepare("SELECT * FROM `".$prefix."roster`");
      $s->execute();
    }
    while($r=$s->fetch(PDO::FETCH_ASSOC)){
      if($r['UUID']==''){
        $r['UUID']=uuidv4();
        $su=$db->prepare("UPDATE `".$prefix."roster` SET `UUID`=:UUID WHERE `id`=:id");
        $su->execute([
          ':UUID'=>$r['UUID'],
          ':id'=>$r['id']
        ]);
      }
      if($r['uid']!=0){
        $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
        $su->execute([':id'=>$r['uid']]);
        $ru=$su->fetch(PDO::FETCH_ASSOC);
      }else{
        $ru=[
          'id'=>0,
          'name'=>'Unassigned',
          'business'=>'',
          'address'=>'',
          'phone'=>0,
          'mobile'=>0
        ];
      }
      $r['notes']=str_replace('<br>','\n',$r['notes']);
      $ics.="BEGIN:VEVENT\r\n".
        "UID:".$r['UUID']."\r\n".
        'DTSTART;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['tis']).'T'.date('His',$r['tis'])."\r\n".
        'DTEND;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['tie']).'T'.date('His',$r['tie'])."\r\n".
        'DTSTAMP;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['ti']).'T'.date('His',$r['ti'])."\r\n".
        "SEQUENCE:".$r['sid']."\r\n".
        'LAST-MODIFIED;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['eti']).'T'.date('His',$r['eti'])."\r\n".
        "SUMMARY:".$r['title'].($r['uid']!=0?' Assigned to '.$ru['name']:' Unassigned')."\r\n".
        "DESCRIPTION:".strip_tags($r['notes']).
          ($ru['name']=='Unassigned'?'\nShift Unassigned':'\nAssigned to '.$ru['name']).
          ($ru['phone']!=''?'\nPhone: '.$ru['phone']:'').
          ($ru['mobile']!=''?'\nMobile: '.$ru['mobile']:'').
          ($ru['email']!=''?'\nEmail: '.$ru['email']:'').
          "\r\n".
        "END:VEVENT\r\n";
    }
  }
  if($type=='bookings'){
    $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='booking' ORDER BY `tis` DESC");
    $s->execute();
    while($r=$s->fetch(PDO::FETCH_ASSOC)){
      if($r['UUID']==''){
        $r['UUID']=uuidv4();
        $su=$db->prepare("UPDATE `".$prefix."content` SET `UUID`=:UUID WHERE `id`=:id");
        $su->execute([
          ':UUID'=>$r['UUID'],
          ':id'=>$r['id']
        ]);
      }
      if($r['uid']!=0){
        $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
        $su->execute([':id'=>$r['uid']]);
        $ru=$su->fetch(PDO::FETCH_ASSOC);
      }else{
        $ru=[
          'id'=>0,
          'name'=>'Unassigned',
          'business'=>'',
          'address'=>'',
          'phone'=>0,
          'mobile'=>0
        ];
      }
      if($r['rid']!=0){
        $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
        $sc->execute([':id'=>$r['rid']]);
        $rc=$sc->fetch(PDO::FETCH_ASSOC);
      }
      $questions='';
      $sq=$db->prepare("SELECT * FROM `".$prefix."orderQuestions` WHERE `cid`=:cid ORDER BY `ti` ASC");
      $sq->execute([':cid'=>$rc['id']]);
      if($sq->rowCount()>0){
        while($rq=$sq->fetch(PDO::FETCH_ASSOC)){
          $questions.='/n'.$rq['question'].': '.$rq['answer'];
        }
      }
      $r['notes']=str_replace('<br>','\n',$r['notes']);
      $ics.="BEGIN:VEVENT\r\n".
        "UID:".$r['UUID']."\r\n".
        'DTSTART;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['tis']).'T'.date('His',$r['tis'])."\r\n".
        'DTEND;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['tie']).'T'.date('His',$r['tie'])."\r\n".
        'DTSTAMP;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['ti']).'T'.date('His',$r['ti'])."\r\n".
        "SEQUENCE:".$r['sid']."\r\n".
        'LAST-MODIFIED;TZID="/'.$config['timezone'].'":'.date('Ymd',$r['eti']).'T'.date('His',$r['eti'])."\r\n".
        "SUMMARY:".ucfirst($r['status']).($r['uid']!=0?' for '.$ru['name']:' Unassigned')."\r\n".
        "DESCRIPTION:".
          ($r['rid']!=0?($r['contentType']=='events'?'Event':'Service')." Booked: ".$rc['title']:'').
          ($ru['name']=='Unassigned'?'\nNo User Added':'\nBooked by '.$ru['name']).
          strip_tags($r['notes']).
          ($ru['phone']!=''?'\nPhone: '.$ru['phone']:'').
          ($ru['mobile']!=''?'\nMobile: '.$ru['mobile']:'').
          ($ru['email']!=''?'\nEmail: '.$ru['email']:'').
          ($questions!=''?$questions:'')."\n".
          "\r\n".
        "END:VEVENT\r\n";
    }
  }
  $ics.="END:VCALENDAR";
}else
  echo'Output type is not recognised!';
header('Content-type:text/calendar;charset=utf-8');
header('Content-Disposition:inline;filename=calendar.ics');
header("Cache-Control:no-cache,must-revalidate");
header("Expires:Sat, 26 Jul 1997 05:00:00 GMT");
echo $ics;
exit;
