<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Course
 * @package    core/layout/course.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='61'");
$sv->execute();
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
                  <?=($user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/course/settings" role="button" aria-label="Course Settings"><i class="i">settings</i></a>':'').
                  ($user['options'][0]==1?'<a data-tooltip="left" class="add" href="'.URL.$settings['system']['admin'].'/add/course" role="button" aria-label="Add Course"><i class="i">add</i></a>':'');?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section class="content mt-3 overflow-visible<?= isset($_COOKIE['contentview'])&&$_COOKIE['contentview']=='list'?' list':'';?>" id="contentview">
          <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <article class="card zebra mx-3 my-2 overflow-visible card-list shadow" id="l_<?=$r['id'];?>" data-content="course<?=' '.$r['title'];?>">
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
                <?php $week1start=strtotime("last sunday midnight this week");
                $week1end=strtotime("saturday this week");
                $sv=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='content' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                $sv->execute([
                  ':rid'=>$r['id'],
                  ':ti1'=>$week1start,
                  ':ti2'=>$week1end
                ]);
                $rv=$sv->fetch(PDO::FETCH_ASSOC);
                $previous_week = strtotime("-1 week +1 day",$ti);
                $week2start = strtotime("last sunday midnight",$previous_week);
                $week2end = strtotime("next saturday",$week2start);
                $sv2=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='content' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                $sv2->execute([
                  ':rid'=>$r['id'],
                  ':ti1'=>$week2start,
                  ':ti2'=>$week2end
                ]);
                $rv2=$sv2->fetch(PDO::FETCH_ASSOC);?>
                <div class="status incomming cursor-default">
                  <?=($rv['direct']>0?'<div data-tooltip="right" aria-label="Direct"><span class="icon pull-left"><i class="i">browser-general</i></span><span class="count">'.short_number($rv['direct']).'</span>'.($rv2['direct']>0?($rv['direct']<$rv2['direct']?'<small class="text-danger">&darr;'.short_number($rv2['direct'] - $rv['direct']).'</small>':'').($rv2['direct']<$rv['direct']?'<small class="text-success">&uarr;'.short_number($rv['direct'] - $rv2['direct']).'</small>':''):'').'</div>':'').
                  ($rv['google']>0?'<div data-tooltip="right" aria-label="Google"><span class="icon pull-left"><i class="i i-social social-google">social-google</i></span><span class="count">'.short_number($rv['google']).'</span>'.($rv2['google']>0?($rv['google']<$rv2['google']?'<small class="text-danger">&darr;'.short_number($rv2['google'] - $rv['google']).'</small>':'').($rv2['google']<$rv['google']?'<small class="text-success">&uarr;'.short_number($rv['google'] - $rv2['google']).'</small>':''):'').'</div>':'').
                  ($rv['duckduckgo']>0?'<div data-tooltip="right" aria-label="Duck Duck Go"><span class="icon pull-left"><i class="i i-social social-duckduckgo">social-duckduckgo</i></span><span class="count">'.short_number($rv['duckduckgo']).'</span>'.($rv2['duckduckgo']>0?($rv['duckduckgo']<$rv2['duckduckgo']?'<small class="text-danger">&darr;'.short_number($rv2['duckduckgo'] - $rv['duckduckgo']).'</small>':'').($rv2['duckduckgo']<$rv['duckduckgo']?'<small class="text-success">&uarr;'.short_number($rv['duckduckgo'] - $rv2['duckduckgo']).'</small>':''):'').'</div>':'').
                  ($rv['bing']>0?'<div data-tooltip="right" aria-label="Bing"><span class="icon pull-left"><i class="i i-social social-bing">social-bing</i></span><span class="count">'.short_number($rv['bing']).'</span>'.($rv2['bing']>0?($rv['bing']<$rv2['bing']?'<small class="text-danger">&darr;'.short_number($rv2['bing'] - $rv['bing']).'</small>':'').($rv2['bing']<$rv['bing']?'<small class="text-success">&uarr;'.short_number($rv['bing'] - $rv2['bing']).'</small>':''):'').'</div>':'').
                  ($rv['reddit']>0?'<div data-tooltip="right" aria-label="Reddit"><span class="icon pull-left"><i class="i i-social social-reddit">social-reddit</i></span><span class="count">'.short_number($rv['reddit']).'</span>'.($rv2['reddit']>0?($rv['reddit']<$rv2['reddit']?'<small class="text-danger">&darr;'.short_number($rv2['reddit'] - $rv['reddit']).'</small>':'').($rv2['reddit']<$rv['reddit']?'<small class="text-success">&uarr;'.short_number($rv['reddit'] - $rv2['reddit']).'</small>':''):'').'</div>':'').
                  ($rv['facebook']>0?'<div data-tooltip="right" aria-label="Facebook"><span class="icon pull-left"><i class="i i-social social-facebook">social-facebook</i></span><span class="count">'.short_number($rv['facebook']).'</span>'.($rv2['facebook']>0?($rv['facebook']<$rv2['facebook']?'<small class="text-danger">&darr;'.short_number($rv2['facebook'] - $rv['facebook']).'</small>':'').($rv2['facebook']<$rv['facebook']?'<small class="text-success">&uarr;'.short_number($rv['facebook'] - $rv2['facebook']).'</small>':''):'').'</div>':'').
                  ($rv['threads']>0?'<div data-tooltip="right" aria-label="Threads"><span class="icon pull-left"><i class="i i-social social-threads">social-threads</i></span><span class="count">'.short_number($rv['threads']).'</span>'.($rv2['threads']>0?($rv['threads']<$rv2['threads']?'<small class="text-danger">&darr;'.short_number($rv2['threads'] - $rv['threads']).'</small>':'').($rv2['threads']<$rv['threads']?'<small class="text-success">&uarr;'.short_number($rv['threads'] - $rv2['threads']).'</small>':''):'').'</div>':'').
                  ($rv['instagram']>0?'<div data-tooltip="right" aria-label="Instagram"><span class="icon pull-left"><i class="i i-social social-instagram">social-instagram</i></span><span class="count">'.short_number($rv['instagram']).'</span>'.($rv2['instagram']>0?($rv['instagram']<$rv2['instagram']?'<small class="text-danger">&darr;'.short_number($rv2['instagram'] - $rv['instagram']).'</small>':'').($rv2['instagram']<$rv['instagram']?'<small class="text-success">&uarr;'.short_number($rv['instagram'] - $rv2['instagram']).'</small>':''):'').'</div>':'').
                  ($rv['twitter']>0?'<div data-tooltip="right" aria-label="Twitter"><span class="icon pull-left"><i class="i i-social social-twitter">social-twitter</i></span><span class="count">'.short_number($rv['twitter']).'</span>'.($rv2['twitter']>0?($rv['twitter']<$rv2['twitter']?'<small class="text-danger">&darr;'.short_number($rv2['twitter'] - $rv['twitter']).'</small>':'').($rv2['twitter']<$rv['twitter']?'<small class="text-success">&uarr;'.short_number($rv['twitter'] - $rv2['twitter']).'</small>':''):'').'</div>':'').
                  ($rv['linkedin']>0?'<div data-tooltip="right" aria-label="Linkedin"><span class="icon pull-left"><i class="i i-social social-linkedin">social-linkedin</i></span><span class="count">'.short_number($rv['linkedin']).'</span>'.($rv2['linkedin']>0?($rv['linkedin']<$rv2['linkedin']?'<small class="text-danger">&darr;'.short_number($rv2['linkedin'] - $rv['linkedin']).'</small>':'').($rv2['linkedin']<$rv['linkedin']?'<small class="text-success">&uarr;'.short_number($rv['linkedin'] - $rv2['linkedin']).'</small>':''):'').'</div>':'')?>
                </div>
                <div class="image-toolbar">
                  <button class="badger badger-primary <?=($r['status']=='published'?'':' d-none');?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                </div>
              </div>
              <div class="card-header overflow-visible mt-0 pt-0 line-clamp">
                <?= !isset($args[1])?'<div class="list-hidden my-1"><a class="badger badge-success small text-white" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a></div>':'';?>
                <small class="small text-muted d-block"><small>Created: <?=date($config['dateFormat'],$r['ti']);?></small></small>
                <small class="small text-muted d-block"><small>Published: <?=date($config['dateFormat'],$r['pti']);?></small></small>
                <a data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/course/edit/'.$r['id'];?>" aria-label="Edit <?=$r['title'];?>"><?php echo$r['thumb']!=''&&file_exists($r['thumb'])?'<img src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                <?=($user['options'][1]==1&&$r['suggestions']==1?'<span data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i text-success">lightbulb</i></span><br>':'').
                '<small class="text-muted d-block" id="rank'.$r['id'].'">Available to '.($r['rank']==0?'<span class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($r['rank']).'">'.ucwords(str_replace('-',' ',rank($r['rank']))).'</span> and above').'</small>';?>
                <div class="row m-0 my-2 p-0 incomming-flat">
                  <?php
                  echo($rv['direct']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Direct"><i class="i i-2x">browser-general</i><span class="px-1">'.short_number($rv['direct']).'</span>'.($rv2['direct']>0?($rv['direct']<$rv2['direct']?'<small class="text-danger"><small>&darr;'.short_number($rv2['direct'] - $rv['direct']).'</small></small>':'').($rv2['direct']<$rv['direct']?'<small class="text-success"><small>&uarr;'.short_number($rv['direct'] - $rv2['direct']).'</small></small>':''):'').'</div>':'').
                  ($rv['google']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Google"><i class="i i-social social-google i-2x">social-google</i><span class="px-1">'.short_number($rv['google']).'</span>'.($rv2['google']>0?($rv['google']<$rv2['google']?'<small class="text-danger"><small>&darr;'.short_number($rv2['google'] - $rv['google']).'</small></small>':'').($rv2['google']<$rv['google']?'<small class="text-success"><small>&uarr;'.short_number($rv['google'] - $rv2['google']).'</small></small>':''):'').'</div>':'').
                  ($rv['duckduckgo']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Duck Duck Go"><i class="i i-2x i-social social-duckduckgo">social-duckduckgo</i><span class="px-1">'.short_number($rv['duckduckgo']).'</span>'.($rv2['duckduckgo']>0?($rv['duckduckgo']<$rv2['duckduckgo']?'<small class="text-danger"><small>&darr;'.short_number($rv2['duckduckgo'] - $rv['duckduckgo']).'</small></small>':'').($rv2['duckduckgo']<$rv['duckduckgo']?'<small class="text-success"><small>&uarr;'.short_number($rv['duckduckgo'] - $rv2['duckduckgo']).'</small></small>':''):'').'</div>':'').
                  ($rv['bing']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Bing"><i class="i i-2x i-social social-bing">social-bing</i><span class="px-1">'.short_number($rv['bing']).'</span>'.($rv2['bing']>0?($rv['bing']<$rv2['bing']?'<small class="text-danger"><small>&darr;'.short_number($rv2['bing'] - $rv['bing']).'</small></small>':'').($rv2['bing']<$rv['bing']?'<small class="text-success"><small>&uarr;'.short_number($rv['bing'] - $rv2['bing']).'</small></small>':''):'').'</div>':'').
                  ($rv['reddit']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Reddit"><i class="i i-2x i-social social-reddit">social-reddit</i><span class="px-1">'.short_number($rv['reddit']).'</span>'.($rv2['reddit']>0?($rv['reddit']<$rv2['reddit']?'<small class="text-danger"><small>&darr;'.short_number($rv2['reddit'] - $rv['reddit']).'</small></small>':'').($rv2['reddit']<$rv['reddit']?'<small class="text-success"><small>&uarr;'.short_number($rv['reddit'] - $rv2['reddit']).'</small></small>':''):'').'</div>':'').
                  ($rv['facebook']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Facebook"><i class="i i-2x i-social social-facebook">social-facebook</i><span class="px-1">'.short_number($rv['facebook']).'</span>'.($rv2['facebook']>0?($rv['facebook']<$rv2['facebook']?'<small class="text-danger"><small>&darr;'.short_number($rv2['facebook'] - $rv['facebook']).'</small></small>':'').($rv2['facebook']<$rv['facebook']?'<small class="text-success"><small>&uarr;'.short_number($rv['facebook'] - $rv2['facebook']).'</small></small>':''):'').'</div>':'').
                  ($rv['threads']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Threads"><i class="i i-2x i-social social-threads">social-threads</i><span class="px-1">'.short_number($rv['threads']).'</span>'.($rv2['threads']>0?($rv['threads']<$rv2['threads']?'<small class="text-danger"><small>&darr;'.short_number($rv2['threads'] - $rv['threads']).'</small></small>':'').($rv2['threads']<$rv['threads']?'<small class="text-success"><small>&uarr;'.short_number($rv['threads'] - $rv2['threads']).'</small></small>':''):'').'</div>':'').
                  ($rv['instagram']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Instagram"><i class="i i-2x i-social social-instagram">social-instagram</i><span class="px-1">'.short_number($rv['instagram']).'</span>'.($rv2['instagram']>0?($rv['instagram']<$rv2['instagram']?'<small class="text-danger"><small>&darr;'.short_number($rv2['instagram'] - $rv['instagram']).'</small></small>':'').($rv2['instagram']<$rv['instagram']?'<small class="text-success"><small>&uarr;'.short_number($rv['instagram'] - $rv2['instagram']).'</small></small>':''):'').'</div>':'').
                  ($rv['twitter']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Twitter"><i class="i i-2x i-social social-twitter">social-twitter</i><span class="px-1">'.short_number($rv['twitter']).'</span>'.($rv2['twitter']>0?($rv['twitter']<$rv2['twitter']?'<small class="text-danger"></small>&darr;'.short_number($rv2['twitter'] - $rv['twitter']).'</small></small>':'').($rv2['twitter']<$rv['twitter']?'<small class="text-success"><small>&uarr;'.short_number($rv['twitter'] - $rv2['twitter']).'</small></small>':''):'').'</div>':'').
                  ($rv['linkedin']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Linkedin"><i class="i i-2x i-social social-linkedin">social-linkedin</i><span class="px-1">'.short_number($rv['linkedin']).'</span>'.($rv2['linkedin']>0?($rv['linkedin']<$rv2['linkedin']?'<small class="text-danger"><small>&darr;'.short_number($rv2['linkedin'] - $rv['linkedin']).'</small></small>':'').($rv2['linkedin']<$rv['linkedin']?'<small class="text-success"><small>&uarr;'.short_number($rv['linkedin'] - $rv2['linkedin']).'</small></small>':''):'').'</div>':'');?>
                </div>
              </div>
              <div class="card-footer">
                <span class="code hidewhenempty"><?=$r['code'];?></span>
                <div id="controls_<?=$r['id'];?>">
                  <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group" role="group">
                      <button class="share <?=($r['status']=='published'?'':'d-none');?>" id="share<?=$r['id'];?>" data-social-share="<?= URL.'course/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                      <a data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/course/edit/<?=$r['id'];?>" role="button"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><i class="i"><?=$user['options'][1]==1?'edit':'view';?></i></a>
                      <?=($user['options'][0]==1?
                        '<button class="add'.($r['status']!='delete'?' d-none':'').'" id="untrash'.$r['id'].'" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons(`'.$r['id'].'`,`content`,`status`,`unpublished`);"><i class="i">untrash</i></button>'.
                        '<button class="trash'.($r['status']=='delete'?' d-none':'').'" id="delete'.$r['id'].'" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons(`'.$r['id'].'`,`content`,`status`,`delete`);"><i class="i">trash</i></button>'.
                        '<button class="purge'.($r['status']!='delete'?' d-none':'').'" id="purge'.$r['id'].'" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`content`);"><i class="i">purge</i></button>':'');?>
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
