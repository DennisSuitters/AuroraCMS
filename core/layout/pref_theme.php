<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Theme
 * @package    core/layout/pref_theme.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">theme</i></div>
          <div>Preferences - Theme</div>
          <div class="content-title-actions">
            <?= ($user['options'][0]==1?'<form target="sp" method="post" action="core/upload_theme.php" enctype="multipart/form-data"><div class="custom-file" data-tooltip="tooltip" aria-label="Add Theme (Overwrites Existing)"><input class="custom-file-input hidden" id="fu" type="file" name="fu" onchange="$(`.page-block`).addClass(`d-block`);form.submit();"><label for="fu" class="btn add"><i class="i">add</i></label></div></form>':'');?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Theme</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 overflow-visible">
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
              </div>

            </article>
          <?php }?>
        </section>
        <?php require'core/layout/footer.php';?>
      </div>
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
