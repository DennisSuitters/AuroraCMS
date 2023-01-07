<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard
 * @package    core/layout/dashboard.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.21
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_dashboard.php';
else{?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid p-2">
      <div class="card mt-3 border-radius-0 bg-aurora border-0">
        <?php $curHr=date('G');
        $msg='<h5 class="welcome-message">';
        if($curHr<12)$msg.='Good Morning ';
        elseif($curHr<18)$msg.='Good Afternoon ';
        else$msg.='Good Evening ';
        $msg.=($user['name']!=''?strtok($user['name'], " "):$user['username']).'!'."<br>The date is ".date($config['dateFormat'])."</h5>";
        echo$msg;
        if($user['accountsContact']==1&&$config['hosterURL']!=''){
          echo'<div id="hostinginfo"></div>';
        }
        echo($config['maintenance']==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Maintenance Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#maintenance">Set Now</a></div>':'').($config['comingsoon']==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Coming Soon Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#comingsoon">Set Now</a></div>':'');
        if(!file_exists('layout/'.$config['theme'].'/theme.ini'))echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
        $tid=$ti-2592000;
        if($config['business']=='')echo'<div class="alert alert-danger" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Booking will NOT function currectly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#business">Set Now</a></div>';
        if($config['email']=='')echo$config['email']==''?'<div class="alert alert-danger" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#email">Set Now</a></div>':'';
$pageerrors=$contenterrors=0;

$sseo=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."menu` WHERE `cover`!='' AND `fileALT`='' AND `active`=1");
$sseo->execute();
$rseo=$sseo->fetch(PDO::FETCH_ASSOC);
$pageerrors=$pageerrors+$rseo['cnt'];
$sseo=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."menu` WHERE CHAR_LENGTH(`seoTitle`) < 50 OR CHAR_LENGTH(`seoTitle`) > 70");
$sseo->execute();
$rseo=$sseo->fetch(PDO::FETCH_ASSOC);
$pageerrors=$pageerrors+$rseo['cnt'];
$sseo=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."menu` WHERE CHAR_LENGTH(`seoDescription`) < 50 OR CHAR_LENGTH(`seoDescription`) > 160");
$sseo->execute();
$rseo=$sseo->fetch(PDO::FETCH_ASSOC);
$pageerrors=$pageerrors+$rseo['cnt'];
$sseo=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."menu` WHERE `heading`=''");
$sseo->execute();
$rseo=$sseo->fetch(PDO::FETCH_ASSOC);
$pageerrors=$pageerrors+$rseo['cnt'];
$sseo=$db->prepare("SELECT `notes` FROM `".$prefix."menu` WHERE `notes`!=''");
$sseo->execute();
while($rseo=$sseo->fetch(PDO::FETCH_ASSOC)){
  if(strlen(strip_tags($rseo['notes']))<100)$pageerrors++;
  preg_match('~<h1>([^{]*)</h1>~i',$rseo['notes'],$h1);
  if(isset($h1[1])){
    $pageerrors++;
  }
}

$sseo=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."content` WHERE `file`!='' AND `fileALT`='' AND `contentType` NOT LIKE 'testimonial%'");
$sseo->execute();
$rseo=$sseo->fetch(PDO::FETCH_ASSOC);
$contenterrors=$contenterrors+$rseo['cnt'];
$sseo=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."content` WHERE CHAR_LENGTH(`seoTitle`) < 50 OR CHAR_LENGTH(`seoTitle`) > 70 AND `contentType` NOT LIKE 'testimonial%'");
$sseo->execute();
$rseo=$sseo->fetch(PDO::FETCH_ASSOC);
$contenterrors=$contenterrors+$rseo['cnt'];
$sseo=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."content` WHERE CHAR_LENGTH(`seoDescription`) < 50 OR CHAR_LENGTH(`seoDescription`) > 160 AND `contentType` NOT LIKE 'testimonial%'");
$sseo->execute();
$rseo=$sseo->fetch(PDO::FETCH_ASSOC);
$contenterrors=$contenterrors+$rseo['cnt'];
$sseo=$db->prepare("SELECT `notes` FROM `".$prefix."content` WHERE `notes`!='' AND `contentType` NOT LIKE 'testimonial%'");
$sseo->execute();
while($rseo=$sseo->fetch(PDO::FETCH_ASSOC)){
  if(strlen(strip_tags($rseo['notes']))<100)$contenterrors++;
  preg_match('~<h1>([^{]*)</h1>~i',$rseo['notes'],$h1);
  if(isset($h1[1])){
    $contenterrors++;
  }
}

if($pageerrors>0 || $contenterrors>0){
  echo'<div class="alert alert-warning">'.
    ($pageerrors>0?'There are <strong>'.$pageerrors.'</strong> SEO issues with various Pages that could affect their ranking!!!':'').
    ($contenterrors>0?($pageerrors>0?'<br>':'').'There are <strong>'.$contenterrors.'</strong> SEO issues with various Content items that could affect their ranking!!!':'').
  '</div>';
}
?>
        <div class="row" id="dashboardview">
<?php $sw=$db->prepare("SELECT * FROM `".$prefix."widgets` WHERE `ref`='dashboard' AND `active`=1 ORDER BY `ord` ASC");
$sw->execute();
while($rw=$sw->fetch(PDO::FETCH_ASSOC)){
  if(file_exists('core/layout/widget-'.$rw['file'])){
    include'core/layout/widget-'.$rw['file'];
  }
}?>
        <div class="ghost hidden"></div>
      </div>
      <script>
        $('#dashboardview').sortable({
          items:".item",
          handle:'.handle',
          placeholder:".ghost",
          helper:fixWidthHelper,
          update:function(e,ui){
            var order=$("#dashboardview").sortable("serialize");
            $.ajax({
              type:"POST",
              dataType:"json",
              url:"core/reorderwidgets.php",
              data:order
            });
          }
        }).disableSelection();
        function fixWidthHelper(e,ui){
          ui.children().each(function(){
            $(this).width($(this).width());
          });
          return ui;
        }
        $(document).on(
          "mouseup",
          ".resize",function(){
            var pWidth=$('#dashboardview').offsetParent().width();
            var elWidth=$(this).width();
            var percent = 100 * elWidth / pWidth;
            var minWidth=$(this).attr('data-resizeMin');
            var maxWidth=$(this).attr('data-resizeMax');
            var newWidthStyle=12;
            var newWidthCSS=100;
            if(percent > 0 && percent < 11){ //col-sm-1
              newWidthStyle=1;
              newWidthCSS=8.333333;
            }
            if(percent > 13 && percent < 19){ //col-sm-2
              newWidthStyle=2;
              newWidthCSS=16.666667;
            }
            if(percent > 20 && percent < 27){ //col-sm-3
              newWidthStyle=3;
              newWidthCSS=25;
            }
            if(percent > 28 && percent < 37){ //col-sm-4
              newWidthStyle=4;
              newWidthCSS=33.333333;
            }
            if(percent > 38 && percent < 47){ //col-sm-5
              newWidthStyle=5;
              newWidthCSS=41.666667;
            }
            if(percent > 46 && percent < 57){ //col-sm-6
              newWidthStyle=6;
              newWidthCSS=50;
            }
            if(percent > 58 && percent < 61){ //col-sm-7
              newWidthStyle=7;
              newWidthCSS=58.333333;
            }
            if(percent > 62 && percent < 67){ //col-sm-8
              newWidthStyle=8;
              newWidthCSS=66.666667;
            }
            if(percent > 68 && percent < 78){ //col-sm-9
              newWidthStyle=9;
              newWidthCSS=75;
            }
            if(percent > 79 && percent < 87){ //col-sm-10
              newWidthStyle=10;
              newWidthCSS=83.333333;
            }
            if(percent > 88 && percent < 94){ //col-sm-11
              newWidthStyle=11;
              newWidthCSS=91.666667;
            }
            if(percent > 95){ //col-sm-12
              newWidthStyle=12;
              newWidthCSS=100;
            }
            if(newWidthStyle < minWidth){
              newWidthStyle=minWidth;
              $(this).css({'width':newWidthCSS+'%','height':'auto'});
            }
            if(newWidthStyle > maxWidth){
              newWidthStyle=maxWidth;
              $(this).css({'width':newWidthCSS+'%','height':'auto'});
            }
            $(this).removeClass(function(index,css){return(css.match(/\bcol-sm-\S+/g) || []).join(' ');});
            $(this).addClass('col-sm-'+newWidthStyle);
            $(this).css({'width':newWidthCSS+'%','height':'auto'});
            $.ajax({
              type:"POST",
              url:"core/update.php",
              data:{
                id:$(this).attr('data-dbid'),
                t:'widgets',
                c:'width',
                da:newWidthStyle
              }
            }).done(function(){});
          });
        </script>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."suggestions` WHERE `popup`=1 AND `seen`=0 AND `uid`=:uid ORDER BY `ti` ASC");
$ss->execute([':uid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
if($ss->rowCount()>0){
  $rs=$ss->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("UPDATE `".$prefix."suggestions` SET `seen`=1,`sti`=:sti WHERE `id`=:id");
  $su->execute([
    ':id'=>$rs['id'],
    ':sti'=>time()
  ]);
  $su=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([':id'=>$rs['uid']]);
  $rt=$su->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([':id'=>$rs['rid']]);
  $rf=$su->fetch(PDO::FETCH_ASSOC);
  $mhtml='<div class="popupmessage col-12 col-sm-8 p-5">'.
    '<h5>To: '.$rt['username'].($rt['name']!=''?':'.$rt['name']:'').'<br>From: '.$rf['username'].($rf['name']!=''?':'.$rf['name']:'').'</h5>'.
    '<div class="mt-3 p-3">'.
      $rs['notes'].
    '</div>'.
  '</div>';?>
  <script>
  $(document).ready(function(){
    $.fancybox.open(`<?=$mhtml;?>`);
  });
  </script>
<?php }?>
</main>
<?php }
