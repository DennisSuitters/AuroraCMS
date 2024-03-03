<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard
 * @package    core/layout/dashboard.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_dashboard.php';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card border-radius-0 bg-transparent border-0 mt-3 overflow-visible">
          <div class="row">
            <div class="card col-12 mb-3 p-3">
              <div class="row">
                <?php if($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar'])){?>
                  <div class="col-1 mr-2">
                    <img class="rounded border-1 border-default p-1 float-left" style="width:80px;max-height:80px;" src="<?='media/avatar/'.$user['avatar'];?>">
                  </div>
                <?php }?>
                <div class="col">
                  <?php $curHr=date('G');
                  $msg='';
                  if($curHr<12)
                    $msg.='Good Morning ';
                  elseif($curHr<18)
                    $msg.='Good Afternoon ';
                  else
                    $msg.='Good Evening ';
                  $quotes=file("core/insp-quotes.txt");
                  $line=$quotes[rand(0,count($quotes)-1)];
                  echo'<h5 class="welcome-message mb-0">'.$msg.($user['name']!=''?strtok($user['name'], " "):$user['username']).'!</h5>'.
                  '<h6 class="text-muted">'.date($config['dateFormat']).'</h6>'.
                  '<div class="text-muted">'.$line.'</div>';?>
                </div>
              </div>
            </div>
          </div>
          <div class="alert alert-info hidewhenempty" id="updatecheck"></div>
          <?php if($user['accountsContact']==1&&$config['hosterURL']!='')echo'<div id="hostinginfo"></div>';
          echo($config['maintenance']==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Maintenance Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#maintenance">Set Now</a></div>':'').
          ($config['comingsoon']==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Coming Soon Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#comingsoon">Set Now</a></div>':'');
          if(!file_exists('layout/'.$config['theme'].'/theme.ini'))
            echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
          $tid=$ti-2592000;
          if($config['business']=='')
            echo'<div class="alert alert-danger" role="alert">The Business Name has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#business">Set Now</a></div>';
          if($config['email']=='')
            echo$config['email']==''?'<div class="alert alert-danger" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#email">Set Now</a></div>':'';
          $seopageerrors=$seocontenterrors=0;
          $sseo=$db->prepare("SELECT `id`,`cover`,`fileALT`,`seoTitle`,`seoDescription`,`heading`,`notes` FROM `".$prefix."menu`");
          $sseo->execute();
          while($rseo=$sseo->fetch(PDO::FETCH_ASSOC)){
            if(strlen((string)$rseo['seoTitle'])<50||strlen((string)$rseo['seoTitle'])>70)$seopageerrors++;
            if(strlen((string)$rseo['seoDescription'])<1||strlen((string)$rseo['seoDescription'])>70)$seopageerrors++;
            if($rseo['cover']!=''){
              if(strlen((string)$rseo['fileALT'])<1)$seopageerrors++;
            }
            if($rseo['heading']=='')$seopageerrors++;
            if(strlen((string)strip_tags((string)$rseo['notes']))<100)$seopageerrors++;
            preg_match('~<h1>([^{]*)</h1>~i',$rseo['notes'],$h1);
            if(isset($h1[1]))$seopageerrors++;
          }
          $sseo=$db->prepare("SELECT `file`,`fileALT`,`seoTitle`,`seoDescription`,`notes` FROM `".$prefix."content` WHERE `contentType` NOT LIKE 'testimonial%' AND `contentType` NOT LIKE 'newsletter%' AND `contentType`!='list' AND `contentType`!='advert' AND `contentType`!='booking'");
          $sseo->execute();
          while($rseo=$sseo->fetch(PDO::FETCH_ASSOC)){
            if(strlen((string)$rseo['seoTitle'])<50||strlen((string)$rseo['seoTitle'])>70)$seocontenterrors++;
            if(strlen((string)$rseo['seoDescription'])<1||strlen((string)$rseo['seoDescription'])>70)$seocontenterrors++;
            if($rseo['file']!=''){
              if(strlen((string)$rseo['fileALT'])<1)$seocontenterrors++;
            }
            if(strlen(strip_tags((string)$rseo['notes']))<100)$seocontenterrors++;
            preg_match('~<h1>([^{]*)</h1>~i',$rseo['notes'],$h1);
            if(isset($h1[1]))$seocontenterrors++;
          }
          if($seopageerrors>0||$seocontenterrors>0){
            echo'<div class="alert alert-warning">'.
              ($seopageerrors>0?'<div>There are <a href="'.URL.$settings['system']['admin'].'/pages">'.$seopageerrors.'</a> SEO issues with various <a href="'.URL.$settings['system']['admin'].'/pages">Pages</a> that can adversely affect their ranking!!!</div>':'').
              ($seocontenterrors>0?'<div>There are <a href="'.URL.$settings['system']['admin'].'/content">'.$seocontenterrors.'</a> SEO issues with various <a href="'.URL.$settings['system']['admin'].'/content">Content</a> items that could adversely affect their ranking!!!</div>':'').
            '</div>';
          }?>
        <div class="row" id="dashboardview">
          <?php $sw=$db->prepare("SELECT * FROM `".$prefix."widgets` WHERE `ref`='dashboard' AND `active`=1 ORDER BY `ord` ASC");
          $sw->execute();
          while($rw=$sw->fetch(PDO::FETCH_ASSOC)){
            if(file_exists('core/layout/widget-'.$rw['file']))include'core/layout/widget-'.$rw['file'];
          }?>
          <div class="ghost hidden"></div>
        </div>
        <script>
          $('#dashboardview').sortable({
            items:".item",
            handle:'.handle',
            placeholder:"ghost",
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
              var wid=$(this).attr('data-dbid');
              var elWidth=$(this).width();
              var screenWidth=$(window).width();
              var col='sm';
              var percent=100 * elWidth / pWidth;
              var minSMWidth=$(this).attr('data-smmin');
              var maxSMWidth=$(this).attr('data-smmax');
              var minMDWidth=$(this).attr('data-mdmin');
              var maxMDWidth=$(this).attr('data-mdmax');
              var minLGWidth=$(this).attr('data-lgmin');
              var maxLGWidth=$(this).attr('data-lgmax');
              var minXLWidth=$(this).attr('data-xlmin');
              var maxXLWidth=$(this).attr('data-xlmax');
              var minXXLWidth=$(this).attr('data-xxlmin');
              var maxXXLWidth=$(this).attr('data-xxlmax');
              var newWidthStyle=12;
              var newWidthCSS=100;
              if(percent > 0 && percent < 13){
                newWidthStyle=1;
                newWidthCSS=8.333333;
              }
              if(percent > 13 && percent < 20){
                newWidthStyle=2;
                newWidthCSS=16.666667;
              }
              if(percent > 20 && percent < 28){
                newWidthStyle=3;
                newWidthCSS=25;
              }
              if(percent > 28 && percent < 38){
                newWidthStyle=4;
                newWidthCSS=33.333333;
              }
              if(percent > 38 && percent < 46){
                newWidthStyle=5;
                newWidthCSS=41.666667;
              }
              if(percent > 46 && percent < 58){
                newWidthStyle=6;
                newWidthCSS=50;
              }
              if(percent > 58 && percent < 61){
                newWidthStyle=7;
                newWidthCSS=58.333333;
              }
              if(percent > 62 && percent < 68){
                newWidthStyle=8;
                newWidthCSS=66.666667;
              }
              if(percent > 68 && percent < 79){
                newWidthStyle=9;
                newWidthCSS=75;
              }
              if(percent > 79 && percent < 88){
                newWidthStyle=10;
                newWidthCSS=83.333333;
              }
              if(percent > 88 && percent < 95){
                newWidthStyle=11;
                newWidthCSS=91.666667;
              }
              if(percent > 95){
                newWidthStyle=12;
                newWidthCSS=100;
              }
              if(screenWidth > 576){
                col='sm';
                minWidth=minSMWidth;
                maxWidth=maxSMWidth;
              }
              if(screenWidth > 768){
                col='md';
                minWidth=minMDWidth;
                maxWidth=maxMDWidth;
              }
              if(screenWidth > 992){
                col='lg';
                minWidth=minLGWidth;
                maxWidth=maxLGWidth;
              }
              if(screenWidth > 1200){
                col='xl';
                minWidth=minXLWidth;
                maxWidth=maxXLWidth;
              }
              if(screenWidth > 1400){
                col='xxl';
                minWidth=minXXLWidth;
                maxWidth=maxXXLWidth;
              }
              if(newWidthStyle < minWidth){
                newWidthStyle=minWidth;
                $(this).css({'width':newWidthCSS+'%','height':'auto'});
              }
              if(newWidthStyle > maxWidth){
                newWidthStyle=maxWidth;
                $(this).css({'width':newWidthCSS+'%','height':'auto'});
              }
              $(this).removeClass(function(index,css){
                return(css.match(/\bcol-s\S+/g) || []).join(' ');
              });
              $(this).removeClass(function(index,css){
                return(css.match(/\bcol-m\S+/g) || []).join(' ');
              });
              $(this).removeClass(function(index,css){
                return(css.match(/\bcol-l\S+/g) || []).join(' ');
              });
              $(this).removeClass(function(index,css){
                return(css.match(/\bcol-x\S+/g) || []).join(' ');
              });
              $(this).addClass('col-'+col+'-'+newWidthStyle);
              $(this).css({'width':newWidthCSS+'%','height':'auto'});
              $.ajax({
                type:"POST",
                url:"core/update.php",
                data:{
                  id:wid,
                  t:'widgets',
                  c:'width_'+col,
                  da:newWidthStyle
                }
              }).done(function(){});
          });
        </script>
      </div>
      <?php require'core/layout/footer.php';
      $currentversion=file_get_contents('VERSION');
      $repoversion=file_get_contents('https://raw.githubusercontent.com/DiemenDesign/AuroraCMS/master/VERSION');
      if($repoversion>$currentversion){?>
        <script>
          $('#updatecheck').html(`<?=$repoversion;?> of <a href="https://github.com/DiemenDesign/AuroraCMS">AuroraCMS</a> is available to update to, you are currently using <?=$currentversion;?>`);
        </script>
      <?php }?>
    </div>
  </section>
</main>
<?php }
