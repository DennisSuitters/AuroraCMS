<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Course
 * @package    core/layout/course.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='categories';
if($view=='add'){
  $stockStatus='none';
  $ti=time();
  $schema='';
  $comments=0;
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`cid`,`contentType`,`schemaType`,`status`,`options`,`rank`,`ti`) VALUES (0,'course','Course','unpublished','00000000','100',:ti)");
  $q->execute([':ti'=>$ti]);
  $id=$db->lastInsertId();
  $s=$db->prepare("UPDATE `".$prefix."content` SET `title`=:title,`urlSlug`=:urlslug WHERE `id`=:id");
  $s->execute([
    ':title'=>'Course '.$id,
    ':urlslug'=>'course-'.$id,
    ':id'=>$id
  ]);
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;
  echo'<script>/*<![CDATA[*/window.location.replace("'.URL.$settings['system']['admin'].'/course/edit/'.$args[1].'");/*]]>*/</script>';
}
if(isset($args[0])&&$args[0]=='edit'){
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='course' AND `id`=:id");
  $s->execute([':id'=>$args[1]]);
  $show='item';
}
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_course.php';
elseif(isset($args[0])&&$args[0]=='module')
  require'core/layout/edit_module.php';
else{
  if($show=='categories'){
    if(isset($args[0])&&$args[0]=='type'){
      if(isset($args[2])&&($args[2]=='archived'||$args[2]=='unpublished'||$args[2]=='autopublish'||$args[2]=='published'||$args[2]=='delete'||$args[2]=='all')){
        if($args[2]=='all')$getStatus=" ";
        else$getStatus=" AND `status`='".$args[2]."' ";
      }elseif(isset($args[2])&&$args[2]!='cat'){
        $getStatus=" ";
      }else$getStatus=" AND `status`!='archived'";
      if(isset($args[2])&&$args[2]=='cat'){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='course' AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2)".$getStatus."ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
        $s->execute([
          ':category_1'=>isset($args[3])&&$args[3]!=''?'%'.str_replace('-','%',$args[3]).'%':'%',
          ':category_2'=>isset($args[4])&&$args[4]!=''?'%'.str_replace('-','%',$args[4]).'%':'%',
        ]);
      }else{
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='course' AND ".$getStatus."ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
        $s->execute();
      }
    }elseif(isset($args[1])&&($args[1]=='archived'||$args[1]=='unpublished'||$args[1]=='autopublish'||$args[1]=='published'||$args[1]=='delete'||$args[1]=='all')){
      $getStatus=" AND `status`!='archived'";
      if($args[1]=='all')
        $getStatus=" ";
      else
        $getStatus=" AND `status`='".$args[1]."' ";
      $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='course' AND ".$getStatus."ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
      $s->execute();
    }else{
      if(isset($args[3])){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='course' AND LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
        $s->execute([
          ':category_1'=>str_replace('-',' ',strtolower($args[2])),
          ':category_2'=>str_replace('-',' ',strtolower($args[3]))
        ]);
      }elseif(isset($args[2])){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='course' AND LOWER(`category_1`) LIKE LOWER(:category_1) ORDER BY `pin` DESC, `ti` ASC, `title` ASC");
        $s->execute([
          ':category_1'=>str_replace('-',' ',strtolower($args[2]))
        ]);
      }else{
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='course' ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
        $s->execute();
      }
    }?>
    <main>
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
        <div class="container-fluid">
          <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
            <div class="card-actions">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <ol class="breadcrumb m-0 pl-0 pt-0">
                    <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/course';?>">Courses</a></li>
                  </ol>
                  <div class="text-left mt-0 pt-0">
                    View:
                    <a class="badger badge-secondary" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1]);?>" aria-label="Display All Content">All</a>&nbsp;
                    <a class="badger badge-success" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>published" aria-label="Display Published Items">Published</a>&nbsp;
                    <a class="badger badge-info" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>autopublish" aria-label="Display Auto Published Items">Auto Published</a>&nbsp;
                    <a class="badger badge-warning" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>unpublished" aria-label="Display Unpublished Items">Unpublished</a>&nbsp;
                    <a class="badger badge-danger" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>delete" aria-label="Display Deleted Items">Deleted</a>&nbsp;
                    <a class="badger badge-secondary" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>archived" aria-label="Display Archived Items">Archived</a>
                  </div>
                  <ol class="breadcrumb pl-0 bg-transparent">
                    <li class="breadcrumb-item">Categories</li>
                    <li class="breadcrumb-item breadcrumb-dropdown">
                      <?= isset($args[3])&&$args[3]!=''?ucwords(str_replace('-',' ',$args[3])):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                      <ul class="breadcrumb-dropper">
                        <li><a href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1]);?>">All</a></li>
                        <?php $sc1=$db->prepare("SELECT DISTINCT `category_1` FROM `".$prefix."content` WHERE `contentType`='course' AND `category_1`!='' ORDER BY `category_1` ASC");
                        $sc1->execute();
                        while($rc1=$sc1->fetch(PDO::FETCH_ASSOC)){
                          echo'<li><a href="'.URL.$settings['system']['admin'].'/course/type/'.$args[1].'/cat/'.str_replace(' ','-',strtolower($rc1['category_1'])).'">'.ucfirst($rc1['category_1']).'</a></li>';
                        }?>
                      </ul>
                    </li>
                    <?php if(isset($args[3])&&$args[3]!=''){?>
                      <li class="breadcrumb-item breadcrumb-dropdown">
                        <?= isset($args[4])&&$args[4]!=''?ucwords(str_replace('-',' ',$args[4])):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                        <ul class="breadcrumb-dropper">
                          <li><a href="<?= URL.$settings['system']['admin'].'/course/'.(!isset($args[1])?'':'type/'.$args[1]).'/cat/'.$args[3];?>">All</a></li>
                          <?php $sc2=$db->prepare("SELECT DISTINCT `category_2` FROM `".$prefix."content` WHERE `contentType`='course' AND LOWER(`category_1`) LIKE LOWER(:cat1) AND `contentType`=:cT AND `category_2`!='' ORDER BY `category_2` ASC");
                          $sc2->execute([
                            ':cat1'=>isset($args[3])&&$args[3]!=''?'%'.str_replace('-',' ',$args[3]).'%':'%'
                          ]);
                          while($rc2=$sc2->fetch(PDO::FETCH_ASSOC)){
                            echo'<li><a href="'.URL.$settings['system']['admin'].'/course/type/'.$args[1].'/cat/'.$args[3].'/'.str_replace(' ','-',strtolower($rc2['category_2'])).'">'.ucfirst($rc2['category_2']).'</a></li>';
                          }?>
                        </ul>
                      </li>
                    </ul>
                  </li>
                <?php }?>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="form-row justify-content-end">
                <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
                <div class="btn-group">
                  <button class="contentview" data-tooltip="left" aria-label="View Courses as Cards or List" onclick="toggleContentView();return false;"><i class="i<?=($_COOKIE['contentview']=='list'?' d-none':'');?>">list</i><i class="i<?=($_COOKIE['contentview']=='cards'?' d-none':'');?>">cards</i></button>
                  <?=($user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/course/settings" role="button" data-tooltip="left" aria-label="Course Settings"><i class="i">settings</i></a>':'').
                  ($user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/add/course" role="button" data-tooltip="left" aria-label="Add Course"><i class="i">add</i></a>':'');?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section class="content mt-3 overflow-visible<?= isset($_COOKIE['contentview'])&&$_COOKIE['contentview']=='list'?' list':'';?>" id="contentview">
          <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <article class="card zebra mx-2 mb-0 overflow-visible card-list" data-content="course<?=' '.$r['title'];?>" id="l_<?=$r['id'];?>">
              <div class="card-image overflow-visible">
                <?php if($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb'])))
                  echo'<a href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'"><img src="'.$r['thumb'].'" alt="'.$r['title'].'"></a>';
                elseif($r['file']!=''&&file_exists('media/'.basename($r['file'])))
                  echo'<a href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'"><img src="media/sm/'.basename($r['file']).'" alt="'.$r['title'].'"></a>';
                elseif($r['fileURL']!='')
                  echo'<a href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'"><img src="'.$r['fileURL'].'" alt="'.$r['title'].'"></a>';
                else
                  echo'<a href="'.URL.$settings['system']['admin'].'/course/edit/'.$r['id'].'"><img src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'"></a>';?>
                <select class="status <?=$r['status'];?>" onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');$(this).removeClass().addClass('status '+$(this).val());changeShareStatus($(this).val());"<?=$user['options'][1]==1?'':' disabled';?>>
                  <option class="unpublished" value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                  <option class="autopublish" value="autopublish"<?=$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                  <option class="published" value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                  <option class="delete" value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
                  <option class="archived" value="archived"<?=$r['status']=='archived'?' selected':'';?>>Archived</option>
                </select>
                <div class="image-toolbar">
                  <button class="badger badger-primary <?=($r['status']=='published'?'':' d-none');?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                </div>
              </div>
              <div class="card-header overflow-visible mt-0 pt-0 line-clamp">
                <a href="<?= URL.$settings['system']['admin'].'/course/edit/'.$r['id'];?>" data-tooltip="tooltip" aria-label="Edit <?=$r['title'];?>"><?php echo$r['thumb']!=''&&file_exists($r['thumb'])?'<img src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                <?=($user['options'][1]==1&&$r['suggestions']==1?'<span data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i text-success">lightbulb</i></span><br>':'').
                '<small class="text-muted d-block" id="rank'.$r['id'].'">Available to '.($r['rank']==0?'Everyone':'<span class="badge badge-'.rank($r['rank']).'">'.ucwords(str_replace('-',' ',rank($r['rank']))).'</span> and above').'</small>';?>
              </div>
              <div class="card-footer">
                <span class="code hidewhenempty"><?=$r['code'];?></span>
                <div id="controls_<?=$r['id'];?>">
                  <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group" role="group">
                      <button class="share <?=($r['status']=='published'?'':'d-none');?>" data-social-share="<?= URL.'course/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                      <a href="<?= URL.$settings['system']['admin'];?>/course/edit/<?=$r['id'];?>" role="button" data-tooltip="tooltip"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><i class="i"><?=$user['options'][1]==1?'edit':'view';?></i></a>
                      <?php if($user['options'][0]==1){?>
                        <button class="add <?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','content','status','unpublished');"><i class="i">untrash</i></button>
                        <button class="trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','content','status','delete');"><i class="i">trash</i></button>
                        <button class="purge<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','content');"><i class="i">purge</i></button>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          <?php }?>
        </section>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
<?php }
  if($show=='item')require'core/layout/edit_course.php';
}
