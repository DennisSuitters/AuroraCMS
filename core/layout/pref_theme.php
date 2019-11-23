<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Theme
 * @package    core/layout/pref_theme.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Theme</li>
  </ol>
  <div id="preference-theme" class="container-fluid">
<?php echo'<div id="notheme" class="alert alert-danger'.(file_exists(THEME.DS.'theme.ini')?' hidden':'').'" role="alert">A Website Theme has not been set.</div>';?>
    <div class="row theme-chooser">
<?php $folders=preg_grep('/^([^.])/',scandir("layout"));
foreach($folders as$folder){
  if(!file_exists('layout'.DS.$folder.DS.'theme.ini'))continue;
  $theme=parse_ini_file('layout'.DS.$folder.DS.'theme.ini',true);?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
        <div class="card text-white p-0<?php echo$config['theme']==$folder?' bg-success':'';?>" data-theme="<?php echo$folder;?>">
          <img class="img-fluid" src="<?php if(file_exists('layout'.DS.$folder.DS.'theme.jpg'))echo'layout'.DS.$folder.DS.'theme.jpg';elseif(file_exists('layout'.DS.$folder.DS.'theme.png'))echo'layout'.DS.$folder.DS.'theme.png';else echo ADMINNOIMAGE;?>" alt="<?php echo $theme['title'];?>">
          <div class="card-body">
            <div class="card-title"><?php echo isset($theme['title'])&&$theme['title']!=''?$theme['title']:'No Title Assigned';?></div>
            <p>
<?php echo isset($theme['version'])&&$theme['version']!=''?'<small class="version">Version: '.$theme['version'].'</small><br>':'';
  if(isset($theme['creator'])&&$theme['creator']!='')
    echo'<small class="creator">Creator'.(isset($theme['creator_url'])&&$theme['creator_url']!=''?': <a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>':$theme['creator']).'</small><br>';
  if(isset($theme['framework_name'])&&$theme['framework_name']!='')
    echo'<small class="creator">Framework'.(isset($theme['framework_url'])&&$theme['framework_url']!=''?': <a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>':$theme['framework_name']).'</small><br>';?>
            </p>
          </div>
        </div>
      </div>
<?php }?>
    </div>
  </div>
  <script>
    $("div.theme-chooser").not(".disabled").find("div.card").on("click",function(){
      $('#preference-theme .card').removeClass("bg-success");
      $(this).addClass("bg-success");
      $('#notheme').addClass("hidden");
      $.ajax({
        type:"GET",
        url:"core/update.php",
        data:{
          id:"1",
          t:"config",
          c:"theme",
          da:$(this).attr("data-theme")
        }
      });
    });
  </script>
</main>
