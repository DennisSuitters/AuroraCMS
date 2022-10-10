<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Theme
 * @package    core/layout/pref_theme.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid p-2">
      <div class="card mt-3 p-4 border-radius-0 bg-white border-0 shadow overflow-visible">
        <div class="card-actions text-right">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
                <li class="breadcrumb-item active">Theme</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?= ($user['options'][0]==1?'<form target="sp" method="post" action="core/upload_theme.php" enctype="multipart/form-data"><div class="custom-file" data-tooltip="left" aria-label="Add Theme (Overwrites Existing)"><input class="custom-file-input hidden" id="fu" type="file" name="fu" onchange="$(`.page-block`).addClass(`d-block`);form.submit();"><label for="fu" class="btn add pb-0" role="button"><i class="i">upload</i></label></div></form>':'');?>
              </div>
            </div>
          </div>
        </div>
        <?='<div class="alert alert-danger'.(file_exists(THEME.'/theme.ini')?' hidden':'').'" id="notheme" role="alert">A Website Theme has not been set.</div>';?>
        <section class="content overflow-visible theme-chooser" id="preference-theme">
          <?php $folders=preg_grep('/^([^.])/',scandir("layout"));
          foreach($folders as$folder){
            if(!file_exists('layout/'.$folder.'/theme.ini'))continue;
            $theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
            <article class="card col-12 col-sm-5 mx-3 mt-4 mb-0 overflow-visible theme<?=$config['theme']==$folder?' theme-selected':'';?>" data-theme="<?=$folder;?>">
              <figure class="card-image position-relative overflow-visible">
                <img src="<?php if(file_exists('layout/'.$folder.'/theme.jpg'))echo'layout/'.$folder.'/theme.jpg';elseif(file_exists('layout/'.$folder.'/theme.png'))echo'layout/'.$folder.'/theme.png';else echo ADMINNOIMAGE;?>" alt="<?=$theme['title'];?>">
                <div class="image-toolbar overflow-visible">
                  <i class="i icon enable text-white i-4x pt-2 pr-1">approve</i>
                </div>
              </figure>
              <div class="card-body pt-0 mt-2 mb-0 text-center">
                <?= isset($theme['title'])&&$theme['title']!=''?$theme['title']:'No Title Assigned';?><br>
                <small>Version <?=$theme['version'];?> created by <?=(isset($theme['creator_url'])&&$theme['creator_url']!=''?'<a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>':$theme['creator']);?><br>
                using the <?=(isset($theme['framework_url'])&&$theme['framework_url']!=''?'<a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>':$theme['framework_name']);?> CSS Framework</small>
                <button class="theme-extra-info" data-fancybox data-type="ajax" data-src="core/theme-info.php?theme=<?=$folder;?>" data-tooltip="tooltip" aria-label="View Theme Changelog"><i class="i i-3x">info</i></button>
              </div>
            </article>
          <?php }?>
        </section>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
    <script>
      $(".theme-chooser").not(".disabled").find("figure.card-image").on("click",function(){
        $('#preference-theme .theme').removeClass("theme-selected");
        $(this).parent('article').addClass("theme-selected");
        $('#notheme').addClass("hidden");
        $.ajax({
          type:"GET",
          url:"core/update.php",
          data:{
            id:"1",
            t:"config",
            c:"theme",
            da:$(this).parent('article').attr("data-theme")
          }
        });
      });
    </script>
  </section>
</main>
