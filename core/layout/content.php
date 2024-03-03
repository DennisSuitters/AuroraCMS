<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content
 * @package    core/layout/content.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='3'")->execute();
$rank=0;
$show='categories';
if(isset($args[0])&&$args[0]=='scheduler')require'core/layout/scheduler.php';
else{
  if($view=='copy'){
    $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $sc->execute([':id'=>$args[1]]);
    $rc=$sc->fetch(PDO::FETCH_ASSOC);
    unset($rc['id']);
    $columns=array_keys($rc);
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content`  (`".implode('`, `', $columns)."`) SELECT `".implode('`, `', $columns)."` from `".$prefix."content` WHERE `id` = ".$args[1].";");
    $q->execute();
    $id=$db->lastInsertId();
    $args[0]=ucfirst($rc['title'].' '.$id);
    $s=$db->prepare("UPDATE `".$prefix."content` SET `title`=:title,`urlSlug`=:urlslug,`status`='unpublished',`ti`=:ti WHERE `id`=:id");
    $s->execute([
      ':id'=>$id,
      ':title'=>$args[0],
      ':urlslug'=>str_replace(' ','-',$args[0]),
      ':ti'=>$ti
    ]);
    if($view!='bookings')$show='item';
    $rank=0;
    $args[0]='edit';
    $args[1]=$id;
    echo'<script>/*<![CDATA[*/window.location.replace("'.URL.$settings['system']['admin'].'/content/edit/'.$args[1].'");/*]]>*/</script>';
  }
  if($view=='add'){
    $stockStatus='none';
    $ti=time();
    $schema='';
    $comments=0;
    if(isset($args[0])&&$args[0]=='article')$schema='blogPosting';
    if(isset($args[0])&&$args[0]=='inventory'){
      $schema='Product';
      $stockStatus='quantity';
    }
    if(isset($args[0])&&$args[0]=='service')$schema='Service';
    if(isset($args[0])&&$args[0]=='gallery')$schema='ImageGallery';
    if(isset($args[0])&&$args[0]=='testimonial')$schema='Review';
    if(isset($args[0])&&$args[0]=='news')$schema='NewsArticle';
    if(isset($args[0])&&$args[0]=='event')$schema='Event';
    if(isset($args[0])&&$args[0]=='portfolio')$schema='CreativeWork';
    if(isset($args[0])&&$args[0]=='proof'){
      $schema='CreativeWork';
      $comments=1;
    }
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`options`,`uid`,`login_user`,`contentType`,`schemaType`,`status`,`active`,`stockStatus`,`ti`,`eti`,`pti`) VALUES ('0000000000000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:stockStatus,:ti,:ti,:ti)");
    $uid=isset($user['id'])?$user['id']:0;
    $login_user=$user['name']!=''?$user['name']:$user['username'];
    $q->execute([
      ':contentType'=>$args[0],
      ':uid'=>$uid,
      ':login_user'=>$login_user,
      ':schemaType'=>$schema,
      ':stockStatus'=>$stockStatus,
      ':ti'=>$ti
    ]);
    $id=$db->lastInsertId();
    $args[0]=ucfirst($args[0]).' '.$id;
    $s=$db->prepare("UPDATE `".$prefix."content` SET `title`=:title,`urlSlug`=:urlslug WHERE `id`=:id");
    $s->execute([
      ':title'=>$args[0],
      ':urlslug'=>str_replace(' ','-',$args[0]),
      ':id'=>$id
    ]);
    if($view!='bookings')$show='item';
    $rank=0;
    $args[0]='edit';
    $args[1]=$id;
    echo'<script>/*<![CDATA[*/window.location.replace("'.URL.$settings['system']['admin'].'/content/edit/'.$args[1].'");/*]]>*/</script>';
  }
  if(isset($args[0])&&$args[0]=='edit'){
    $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $s->execute([':id'=>$args[1]]);
    $show='item';
  }
  if(isset($args[0])&&$args[0]=='settings')
    require'core/layout/set_content.php';
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
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list'".$getStatus."ORDER BY `title` ASC");
          $s->execute([
            ':category_1'=>isset($args[3])&&$args[3]!=''?'%'.str_replace('-','%',$args[3]).'%':'%',
            ':category_2'=>isset($args[4])&&$args[4]!=''?'%'.str_replace('-','%',$args[4]).'%':'%',
            ':category_3'=>isset($args[5])&&$args[5]!=''?'%'.str_replace('-','%',$args[5]).'%':'%',
            ':category_4'=>isset($args[6])&&$args[6]!=''?'%'.str_replace('-','%',$args[6]).'%':'%',
            ':contentType'=>$args[1]
          ]);
        }else{
          if($args[1]=='events'){
            if(isset($_GET['field'])&&($_GET['field']=='tis'||$_GET['field']=='tie'||$_GET['field']=='ti'))
              $eventsort='`'.$_GET['field'].'` '.(isset($_GET['by'])&&$_GET['by']=='ASC'?'ASC':'DESC');
            else
              $eventsort='`pin` DESC, `ti` DESC, `title` ASC';
            $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType ".$getStatus."ORDER BY ".$eventsort);
          }else{
            $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list'".$getStatus."ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
          }
          $s->execute([':contentType'=>$args[1]]);
        }
      }elseif(isset($args[1])&&($args[1]=='archived'||$args[1]=='unpublished'||$args[1]=='autopublish'||$args[1]=='published'||$args[1]=='delete'||$args[1]=='all')){
        $getStatus=" AND `status`!='archived'";
        if($args[1]=='all')
          $getStatus=" ";
        else
          $getStatus=" AND `status`='".$args[1]."' ";
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list'".$getStatus."ORDER BY `title` ASC");
        $s->execute([':contentType'=>$view]);
      }else{
        if(isset($args[5])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list' ORDER BY `title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2])),
            ':category_2'=>str_replace('-',' ',strtolower($args[3])),
            ':category_3'=>str_replace('-',' ',strtolower($args[4])),
            ':category_4'=>str_replace('-',' ',strtolower($args[5]))
          ]);
        }elseif(isset($args[4])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list' ORDER BY `title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2])),
            ':category_2'=>str_replace('-',' ',strtolower($args[3])),
            ':category_3'=>str_replace('-',' ',strtolower($args[4]))
          ]);
        }elseif(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list' ORDER BY `title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2])),
            ':category_2'=>str_replace('-',' ',strtolower($args[3]))
          ]);
        }elseif(isset($args[2])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list' ORDER BY `title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2]))
          ]);
        }else{
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`!='booking' AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list' ORDER BY `title` ASC");
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
                      <li class="breadcrumb-item active">
                        <a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a>
                      </li>
                      <li class="breadcrumb-item active breadcrumb-dropdown">
                        <?= isset($args[1])&&$args[1]!=''?ucfirst($args[1]):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                        <ul class="breadcrumb-dropper">
                          <li><a href="<?= URL.$settings['system']['admin'].'/content';?>">All</a></li>
                          <?php $sc=$db->prepare("SELECT DISTINCT `contentType` FROM `".$prefix."content` WHERE `contentType`!=''AND`contentType`!='booking' AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' AND `contentType`!='course' AND `contentType`!='advert' AND `contentType`!='list' AND `contentType`!=:cT ORDER BY `contentType` ASC");
                          $sc->execute([':cT'=>isset($args[1])&&$args[1]!=''?$args[1]:'%']);
                          while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
                            echo'<li><a href="'.URL.$settings['system']['admin'].'/content/type/'.$rc['contentType'].'">'.ucfirst($rc['contentType']).'</a></li>';
                          }?>
                        </ul>
                      </ol>
                      <div class="text-left mt-0 pt-0">
                        View:
                        <a class="badger badge-secondary" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1]);?>" aria-label="Display All Content">All</a>&nbsp;
                        <a class="badger badge-success" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>published" aria-label="Display Published Items">Published</a>&nbsp;
                        <a class="badger badge-info" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>autopublish" aria-label="Display Auto Published Items">Auto Published</a>&nbsp;
                        <a class="badger badge-warning" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>unpublished" aria-label="Display Unpublished Items">Unpublished</a>&nbsp;
                        <a class="badger badge-danger" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>delete" aria-label="Display Deleted Items">Deleted</a>&nbsp;
                        <a class="badger badge-secondary" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>archived" aria-label="Display Archived Items">Archived</a>
                      </div>
                      <ol class="breadcrumb pl-0 bg-transparent">
                        <li class="breadcrumb-item">Categories</li>
                        <li class="breadcrumb-item breadcrumb-dropdown">
                          <?= isset($args[3])&&$args[3]!=''?ucwords(str_replace('-',' ',$args[3])):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                          <ul class="breadcrumb-dropper">
                            <li><a href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1]);?>">All</a></li>
                            <?php $sc1=$db->prepare("SELECT DISTINCT `category_1` FROM `".$prefix."content` WHERE `contentType`!='' AND `contentType`=:cT AND `category_1`!='' ORDER BY `category_1` ASC");
                            $sc1->execute([':cT'=>isset($args[1])&&$args[1]!=''?$args[1]:'%']);
                            while($rc1=$sc1->fetch(PDO::FETCH_ASSOC)){
                              echo'<li><a href="'.URL.$settings['system']['admin'].'/content/type/'.$args[1].'/cat/'.str_replace(' ','-',strtolower($rc1['category_1'])).'">'.ucfirst($rc1['category_1']).'</a></li>';
                            }?>
                          </ul>
                        </li>
                        <?php if(isset($args[3])&&$args[3]!=''){?>
                          <li class="breadcrumb-item breadcrumb-dropdown">
                            <?= isset($args[4])&&$args[4]!=''?ucwords(str_replace('-',' ',$args[4])):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                            <ul class="breadcrumb-dropper">
                              <li><a href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1]).'/cat/'.$args[3];?>">All</a></li>
                              <?php $sc2=$db->prepare("SELECT DISTINCT `category_2` FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:cat1) AND `contentType`=:cT AND `category_2`!='' ORDER BY `category_2` ASC");
                              $sc2->execute([
                                ':cT'=>isset($args[1])&&$args[1]!=''?$args[1]:'%',
                                ':cat1'=>isset($args[3])&&$args[3]!=''?'%'.str_replace('-',' ',$args[3]).'%':'%'
                              ]);
                              while($rc2=$sc2->fetch(PDO::FETCH_ASSOC)){
                                echo'<li><a href="'.URL.$settings['system']['admin'].'/content/type/'.$args[1].'/cat/'.$args[3].'/'.str_replace(' ','-',strtolower($rc2['category_2'])).'">'.ucfirst($rc2['category_2']).'</a></li>';
                              }?>
                            </ul>
                          </li>
                        <?php }
                        if(isset($args[4])&&$args[4]!=''){?>
                          <li class="breadcrumb-item breadcrumb-dropdown">
                            <?= isset($args[5])&&$args[5]!=''?ucwords(str_replace('-',' ',$args[5])):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                            <ul class="breadcrumb-dropper">
                              <li><a href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1]).'/cat/'.$args[3].'/'.$args[4];?>">All</a></li>
                              <?php $sc3=$db->prepare("SELECT DISTINCT `category_3` FROM `".$prefix."content` WHERE LOWER(`category_2`) LIKE LOWER(:cat2) AND `contentType`=:cT AND `category_3`!='' ORDER BY `category_3` ASC");
                              $sc3->execute([
                                ':cT'=>isset($args[1])&&$args[1]!=''?$args[1]:'%',
                                ':cat2'=>isset($args[4])&&$args[4]!=''?'%'.str_replace('-',' ',$args[4]).'%':'%'
                              ]);
                              while($rc3=$sc3->fetch(PDO::FETCH_ASSOC)){
                                echo'<li><a href="'.URL.$settings['system']['admin'].'/content/type/'.$args[1].'/cat/'.$args[3].'/'.$args[4].'/'.str_replace(' ','-',strtolower($rc3['category_3'])).'">'.ucfirst($rc3['category_3']).'</a></li>';
                              }?>
                            </ul>
                          </li>
                        <?php }
                        if(isset($args[5])&&$args[5]!=''){?>
                          <li class="breadcrumb-item breadcrumb-dropdown">
                            <?= isset($args[6])&&$args[6]!=''?ucwords(str_replace('-',' ',$args[6])):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                            <ul class="breadcrumb-dropper">
                              <li><a href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1]).'/cat/'.$args[3].'/'.$args[4].'/'.$args[5];?>">All</a></li>
                              <?php $sc4=$db->prepare("SELECT DISTINCT `category_4` FROM `".$prefix."content` WHERE LOWER(`category_3`) LIKE LOWER(:cat3) AND `contentType`=:cT AND `category_4`!='' ORDER BY `category_4` ASC");
                              $sc4->execute([
                                ':cT'=>isset($args[1])&&$args[1]!=''?$args[1]:'%',
                                ':cat3'=>isset($args[5])&&$args[5]!=''?'%'.str_replace('-',' ',$args[5]).'%':'%'
                              ]);
                              while($rc4=$sc4->fetch(PDO::FETCH_ASSOC)){
                                echo'<li><a href="'.URL.$settings['system']['admin'].'/content/type/'.$args[1].'/cat/'.$args[3].'/'.$args[4].'/'.$args[5].'/'.str_replace(' ','-',strtolower($rc4['category_4'])).'">'.ucfirst($rc4['category_4']).'</a></li>';
                              }?>
                            </ul>
                          </li>
                        <?php }?>
                      </ol>
                    </div>
                    <div class="col-12 col-sm-6 text-right">
                      <?php if(isset($args[1])&&$args[1]=='events'){?>
                        <form class="form-row justify-content-end mr-4" method="get" action="">
                          <div class="input-text">Display&nbsp;Events&nbsp;By</div>
                          <select id="eventfield" name="field">
                            <option value="tis"<?=(isset($_GET['field'])&&$_GET['field']=='tis'?' selected':'');?>>Start Date</option>
                            <option value="tie"<?=(isset($_GET['field'])&&$_GET['field']=='tie'?' selected':'');?>>End Date</option>
                            <option value="ti"<?=(isset($_GET['field'])&&$_GET['field']=='ti'?' selected':'');?>>Created</option>
                          </select>
                          <select id="eventdirection" name="by">
                            <option value="DESC"<?=(isset($_GET['by'])&&$_GET['by']=='DESC'?' selected':'');?>>Descending</option>
                            <option value="ASC"<?=(isset($_GET['by'])&&$_GET['by']=='ASC'?' selected':'');?>>Ascending</option>
                          </select>
                          <button type="submit">Go</button>
                        </form>
                      <?php }?>
                      <div class="form-row justify-content-end mr-4">
                        <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
                        <div class="btn-group">
                          <button class="contentview" data-tooltip="left" aria-label="View Content as Cards or List" onclick="toggleContentView();return false;"><i class="i<?=($_COOKIE['contentview']=='list'?' d-none':'');?>">list</i><i class="i<?=($_COOKIE['contentview']=='cards'?' d-none':'');?>">cards</i></button>
                          <?=($user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/content/settings" role="button" aria-label="Content Settings"><i class="i">settings</i></a>':'').
                          (isset($args[1])&&$args[1]!=''&&$user['options'][0]==1?'<a class="add" data-tooltip="left" href="'.URL.$settings['system']['admin'].'/add/'.$args[1].'" role="button" aria-label="Add '.ucfirst($args[1]).'"><i class="i">add</i></a>':'');?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <section class="content overflow-visible<?= isset($_COOKIE['contentview'])&&$_COOKIE['contentview']=='list'?' list':'';?>" id="contentview">
                  <?php
                  $jump=['num'=>0,'a'=>0,'b'=>0,'c'=>0,'d'=>0,'e'=>0,'f'=>0,'g'=>0,'h'=>0,'i'=>0,'j'=>0,'k'=>0,'l'=>0,'m'=>0,'n'=>0,'o'=>0,'p'=>0,'q'=>0,'r'=>0,'s'=>0,'t'=>0,'u'=>0,'v'=>0,'w'=>0,'x'=>0,'y'=>0,'z'=>0];
                  while($r=$s->fetch(PDO::FETCH_ASSOC)){
                    $seoerrors=0;
                    if($r['contentType']!='testimonials'||$r['contentType']!='list'){
                      if(strlen($r['seoTitle'])<20||strlen($r['seoTitle'])>70)$seoerrors++;
                      if(strlen($r['seoDescription'])<70||strlen($r['seoDescription'])>160)$seoerrors++;
                      if($r['file']!=''){
                        if(strlen($r['fileALT'])<1)$seoerrors++;
                      }
                      if(strlen(strip_tags($r['notes']))<100)$seoerrors++;
                      preg_match('~<h1>([^{]*)</h1>~i',$r['notes'],$h1);
                      if(isset($h1[1]))$seoerrors++;
                    }
                    $sr=$db->prepare("SELECT COUNT(`id`) as num,SUM(`cid`) as cnt FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid");
                    $sr->execute([':rid'=>$r['id']]);
                    $rr=$sr->fetch(PDO::FETCH_ASSOC);
                    if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
                      $sc=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."comments` WHERE `rid`=:id AND `contentType`=:contentType");
                      $sc->execute([
                        ':id'=>$r['id'],
                        ':contentType'=>$r['contentType']
                      ]);
                      $cnt=$sc->fetch(PDO::FETCH_ASSOC);
                      $scc=$db->prepare("SELECT `id` FROM `".$prefix."comments` WHERE `rid`=:id AND `contentType`=:contentType AND `status`='unapproved'");
                      $scc->execute([
                        ':id'=>$r['id'],
                        'contentType'=>$r['contentType']
                      ]);
                      $sccc=$scc->rowCount();
                    }
                    $jumpcheck=strtolower($r['title'][0]);
                    if(is_numeric($jumpcheck)&&$jump['num']==0){
                      echo'<div id="jumpnum"></div>';
                      $jump['num']=1;
                    }
                    if(isset($jump[$jumpcheck])&&$jump[$jumpcheck]==0){
                      echo'<div id="jump'.$jumpcheck.'"></div>';
                      $jump[$jumpcheck]=1;
                    }?>
                    <article class="card zebra mx-3 my-2 overflow-visible card-list shadow" id="l_<?=$r['id'];?>" data-content="<?=$r['contentType'].' '.$r['title'];?>">
                      <div class="card-image overflow-visible">
                        <?php if($r['thumb']!='')
                          echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'"><img src="'.$r['thumb'].'" alt="'.$r['title'].'"></a>';
                        elseif($r['file']!='')
                          echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'"><img src="'.$r['file'].'" alt="'.$r['title'].'"></a>';
                        elseif($r['fileURL']!='')
                          echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'"><img src="'.$r['fileURL'].'" alt="'.$r['title'].'"></a>';
                        else
                          echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'"><img src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'"></a>';?>
                        <select class="status <?=$r['status'];?>" onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');$(this).removeClass().addClass('status '+$(this).val());changeShareStatus($(this).val());"<?=$user['options'][1]==1?'':' disabled';?>>
                          <option class="unpublished" value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                          <option class="autopublish" value="autopublish"<?=$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                          <option class="published" value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                          <option class="delete" value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
                          <option class="archived" value="archived"<?=$r['status']=='archived'?' selected':'';?>>Archived</option>
                        </select>
                        <?php if($r['contentType']=='inventory'){?>
                          <select class="stock status" data-tooltip="tooltip" onchange="update('<?=$r['id'];?>','content','stockStatus',$(this).val(),'select');" aria-label="Stock Status"<?=$user['options'][1]==1?'':' disabled';?>>
                            <option value="quantity"<?=$r['stockStatus']=='quantity'?' selected':''?>>Dependant on Quantity</option>
                            <option value="in stock"<?=$r['stockStatus']=='in stock'?' selected':'';?>>In Stock</option>
                            <option value="in store only"<?=$r['stockStatus']=='in store only'?' selected':'';?>>In Store Only</option>
                            <option value="online only"<?=$r['stockStatus']=='online only'?' selected':'';?>>Online Only</option>
                            <option value="limited availability"<?=$r['stockStatus']=='limited availability'?' selected':'';?>>Limited Availability</option>
                            <option value="out of stock"<?=$r['stockStatus']=='out of stock'?' selected':'';?>>Out Of Stock</option>
                            <option value="back order"<?=$r['stockStatus']=='back order'?' selected':'';?>>Back Order</option>
                            <option value="pre order"<?=$r['stockStatus']=='pre order'?' selected':'';?>>Pre Order</option>
                            <option value="pre sale"<?=$r['stockStatus']=='pre sale'?' selected':'';?>>Pre Sale</option>
                            <option value="available"<?=$r['stockStatus']=='available'?' selected':'';?>>Available</option>
                            <option value="sold out"<?=$r['stockStatus']=='sold out'?' selected':'';?>>Sold Out</option>
                            <option value="discontinued"<?=$r['stockStatus']=='discontinued'?' selected':'';?>>Discontinued</option>
                            <option value="none"<?=($r['stockStatus']=='none'||$r['stockStatus']==''?' selected':'');?>>No Display</option>
                          </select>
                        <?php }
                        if($config['options'][11]==1){
                          $week1start=strtotime("last sunday midnight this week");
                          $week1end=strtotime("saturday this week");
                          $sv=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='content' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                          $sv->execute([
                            ':rid'=>$r['id'],
                            ':ti1'=>$week1start,
                            ':ti2'=>$week1end
                          ]);
                          $rv=$sv->fetch(PDO::FETCH_ASSOC);
                          $previous_week=strtotime("-1 week +1 day",$ti);
                          $week2start=strtotime("last sunday midnight",$previous_week);
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
                        <?php }?>
                        <div class="image-toolbar">
                          <?php echo(!isset($args[1])?'<a class="badger badge-success small text-white" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a><br>':'').
                          ($r['pin']==1?'<a class="badger badge-primary small text-white" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#pin">Pinned</a><br>':'');
                          $sss=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:ti");
                          $currentMonthStart=mktime(0, 0, 0, date("n"), 1);
                          $sss->execute([
                            ':rid'=>$r['id'],
                            ':ti'=>$currentMonthStart -1
                          ]);
                          if($sss->rowCount()>0){
                            $rss=$sss->fetch(PDO::FETCH_ASSOC);
                            echo$rss['cnt']>0?'<button class="badger" data-tooltip="tooltip" aria-label="'.$rss['cnt'].' Sales this Month">'.$rss['cnt'].' <i class="i">shipping</i></button><br>':'';
                          }
                          echo(isset($sccc)&&$sccc>0?($user['options'][1]==1?'<a class="comments badger" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-5" role="button" aria-label="'.$sccc.' New Comments">'.$cnt['cnt'].' <i class="i">comments</i></a><br>':'<span class="btn comments badger" data-tooltip="tooltip" aria-label="'.$sccc.' New Comments">'.$cnt['cnt'].' <i class="i">comments</i></span><br>'):'').
                          ($rr['num']>0?'<a class="badger" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-6" role="button" aria-label="'.$rr['num'].' New Reviews">'.$rr['num'].' <i class="i">review</i></a><br>':'').
                          '<button class="badger '.($r['status']=='published'?'':' d-none').'" data-social-share="'.URL.$r['contentType'].'/'.$r['urlSlug'].'" data-social-desc="'.($r['seoDescription']?$r['seoDescription']:$r['title']).'" id="share'.$r['id'].'" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>';?>
                        </div>
                      </div>
                      <div class="card-header overflow-visible mt-0 pt-0 line-clamp<?=($seoerrors>0?' pt-3 badge" data-badge="There are '.$seoerrors.' SEO issues!':'');?>">
                        <div class="code small hidewhenempty"><?=$r['code'];?></div>
                        <?= !isset($args[1])?'<span class="d-block"><a class="badger badge-success small text-white" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a></span>':'';?>
                        <a data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>" aria-label="Edit <?=$r['title'];?>"><?= $r['thumb']!=''&&file_exists($r['thumb'])?'<img src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                        <?php if($user['options'][1]==1){
                          echo$r['suggestions']==1?'<span data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i text-success">lightbulb</i></span>':'';
                          if($r['contentType']=='proofs'){
                            $sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                            $sp->execute([':id'=>$r['uid']]);
                            $sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                            <div class="small">Belongs to <a data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>" aria-label="View Proofs"><?=$sr['name']!=''?$sr['name']:$sr['username'];?></a></div>
                          <?php }
                        }
                        echo'<div class="text-muted small d-block" id="rank'.$r['id'].'">Available to '.($r['rank']==0?'<span class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($r['rank']).'">'.ucwords(str_replace('-',' ',rank($r['rank']))).'</span> and above').'</div>';
                        if($config['options'][11]==1){
                        echo'<div class="row m-0 my-2 p-0 incomming-flat">'.
                          ($rv['direct']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Direct"><i class="i i-2x">browser-general</i><span class="px-1">'.short_number($rv['direct']).'</span>'.($rv2['direct']>0?($rv['direct']<$rv2['direct']?'<small class="text-danger"><small>&darr;'.short_number($rv2['direct'] - $rv['direct']).'</small></small>':'').($rv2['direct']<$rv['direct']?'<small class="text-success"><small>&uarr;'.short_number($rv['direct'] - $rv2['direct']).'</small></small>':''):'').'</div>':'').
                          ($rv['google']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Google"><i class="i i-social social-google i-2x">social-google</i><span class="px-1">'.short_number($rv['google']).'</span>'.($rv2['google']>0?($rv['google']<$rv2['google']?'<small class="text-danger"><small>&darr;'.short_number($rv2['google'] - $rv['google']).'</small></small>':'').($rv2['google']<$rv['google']?'<small class="text-success"><small>&uarr;'.short_number($rv['google'] - $rv2['google']).'</small></small>':''):'').'</div>':'').
                          ($rv['duckduckgo']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Duck Duck Go"><i class="i i-2x i-social social-duckduckgo">social-duckduckgo</i><span class="px-1">'.short_number($rv['duckduckgo']).'</span>'.($rv2['duckduckgo']>0?($rv['duckduckgo']<$rv2['duckduckgo']?'<small class="text-danger"><small>&darr;'.short_number($rv2['duckduckgo'] - $rv['duckduckgo']).'</small></small>':'').($rv2['duckduckgo']<$rv['duckduckgo']?'<small class="text-success"><small>&uarr;'.short_number($rv['duckduckgo'] - $rv2['duckduckgo']).'</small></small>':''):'').'</div>':'').
                          ($rv['bing']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Bing"><i class="i i-2x i-social social-bing">social-bing</i><span class="px-1">'.short_number($rv['bing']).'</span>'.($rv2['bing']>0?($rv['bing']<$rv2['bing']?'<small class="text-danger"><small>&darr;'.short_number($rv2['bing'] - $rv['bing']).'</small></small>':'').($rv2['bing']<$rv['bing']?'<small class="text-success"><small>&uarr;'.short_number($rv['bing'] - $rv2['bing']).'</small></small>':''):'').'</div>':'').
                          ($rv['reddit']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Reddit"><i class="i i-2x i-social social-reddit">social-reddit</i><span class="px-1">'.short_number($rv['reddit']).'</span>'.($rv2['reddit']>0?($rv['reddit']<$rv2['reddit']?'<small class="text-danger"><small>&darr;'.short_number($rv2['reddit'] - $rv['reddit']).'</small></small>':'').($rv2['reddit']<$rv['reddit']?'<small class="text-success"><small>&uarr;'.short_number($rv['reddit'] - $rv2['reddit']).'</small></small>':''):'').'</div>':'').
                          ($rv['facebook']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Facebook"><i class="i i-2x i-social social-facebook">social-facebook</i><span class="px-1">'.short_number($rv['facebook']).'</span>'.($rv2['facebook']>0?($rv['facebook']<$rv2['facebook']?'<small class="text-danger"><small>&darr;'.short_number($rv2['facebook'] - $rv['facebook']).'</small></small>':'').($rv2['facebook']<$rv['facebook']?'<small class="text-success"><small>&uarr;'.short_number($rv['facebook'] - $rv2['facebook']).'</small></small>':''):'').'</div>':'').
                          ($rv['threads']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Threads"><i class="i i-2x i-social social-threads">social-threads</i><span class="px-1">'.short_number($rv['threads']).'</span>'.($rv2['threads']>0?($rv['threads']<$rv2['threads']?'<small class="text-danger"><small>&darr;'.short_number($rv2['threads'] - $rv['threads']).'</small></small>':'').($rv2['threads']<$rv['threads']?'<small class="text-success"><small>&uarr;'.short_number($rv['threads'] - $rv2['threads']).'</small></small>':''):'').'</div>':'').
                          ($rv['instagram']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Instagram"><i class="i i-2x i-social social-instagram">social-instagram</i><span class="px-1">'.short_number($rv['instagram']).'</span>'.($rv2['instagram']>0?($rv['instagram']<$rv2['instagram']?'<small class="text-danger"><small>&darr;'.short_number($rv2['instagram'] - $rv['instagram']).'</small></small>':'').($rv2['instagram']<$rv['instagram']?'<small class="text-success"><small>&uarr;'.short_number($rv['instagram'] - $rv2['instagram']).'</small></small>':''):'').'</div>':'').
                          ($rv['twitter']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Twitter"><i class="i i-2x i-social social-twitter">social-twitter</i><span class="px-1">'.short_number($rv['twitter']).'</span>'.($rv2['twitter']>0?($rv['twitter']<$rv2['twitter']?'<small class="text-danger"></small>&darr;'.short_number($rv2['twitter'] - $rv['twitter']).'</small></small>':'').($rv2['twitter']<$rv['twitter']?'<small class="text-success"><small>&uarr;'.short_number($rv['twitter'] - $rv2['twitter']).'</small></small>':''):'').'</div>':'').
                          ($rv['linkedin']>0?'<div class="col text-center" data-tooltip="tooltip" aria-label="Linkedin"><i class="i i-2x i-social social-linkedin">social-linkedin</i><span class="px-1">'.short_number($rv['linkedin']).'</span>'.($rv2['linkedin']>0?($rv['linkedin']<$rv2['linkedin']?'<small class="text-danger"><small>&darr;'.short_number($rv2['linkedin'] - $rv['linkedin']).'</small></small>':'').($rv2['linkedin']<$rv['linkedin']?'<small class="text-success"><small>&uarr;'.short_number($rv['linkedin'] - $rv2['linkedin']).'</small></small>':''):'').'</div>':'').
                        '</div>';
                      }?>
                      </div>
                      <div class="card-footer p-2">
                        <div class="btn-toolbar" id="controls_<?=$r['id'];?>" role="toolbar">
                          <div class="btn-group">
                            <?=($rr['num']>0?($user['options'][1]==1?'<span class="reviews"><a data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-6" role="button" aria-label="'.$rr['num'].' New Reviews">'.$rr['num'].'&nbsp;<i class="i">review</i></a></span>':'<span class="btn" data-tooltip="tooltip" aria-label="'.$rr['name'].'&nbsp;New Reviews">'.$rr['name'].'&nbsp;<i class="i">review</i></span>'):'').
                            (isset($sccc)&& $sccc>0?($user['options'][1]==1?'<a data-tooltip="tooltip" class="views'.($sccc>0?' add':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-5" role="button" aria-label="'.$sccc.' New Comments">'.$sccc.'&nbsp;<i class="i">comments</i></a>':'<span class="btn views" data-tooltip="tooltip" aria-label="'.$sccc.' New Comments">'.$sccc.'&nbsp;<i class="i">comments</i></span>'):'').
                            ($rss['cnt']>0?'<span class="btn views" data-tooltip="tooltip" aria-label="'.$rss['cnt'].' Sales this Month">'.$rss['cnt'].'&nbsp;<i class="i">shipping</i></span>':'');?>
                            <button class="share <?=($r['status']=='published'?'':'d-none');?>" id="share<?=$r['id'];?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                            <a data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$r['id'];?>" role="button"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><i class="i"><?=$user['options'][1]==1?'edit':'view';?></i></a>
                            <a data-tooltip="tooltip" href="javascript:;" class="btn quickitemsbtn" data-fancybox="quickitems" data-type="ajax" data-src="core/quickedit.php?id=<?=$r['id'];?>&t=content&o=modal" aria-label="View Quick Edit Modal"><i class="i">view</i></a>
                            <?php if($user['options'][0]==1){?>
                              <button class="add <?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','content','status','unpublished');"><i class="i">untrash</i></button>
                              <button class="trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','content','status','delete');"><i class="i">trash</i></button>
                              <button class="purge<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','content');"><i class="i">purge</i></button>
                              <button class="quickeditbtn" data-qeid="<?=$r['id'];?>" data-qet="content" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>
                            <?php }?>
                          </div>
                        </div>
                      </div>
                    </article>
                    <div class="quickedit shadow" id="quickedit<?=$r['id'];?>"></div>
                  <?php }?>
                </section>
                <div class="jumpBar">
                  <a class="jumpBar-character" href="<?=$_SERVER['REQUEST_URI'];?>#back-to-top"><i class="i">arrow-up</i></a>
                  <?php
                  foreach($jump as $jumplink => $val) {
                    if($jumplink=='num'&&$val==1){
                      echo'<a class="jumpBar-character" href="'.$_SERVER['REQUEST_URI'].'#jumpnum">#</a>';
                    }else
                    if(!is_numeric($jumplink)&&$val==1){
                      echo'<a class="jumpBar-character" href="'.$_SERVER['REQUEST_URI'].'#jump'.$jumplink.'">'.$jumplink.'</a>';
                    }
                  }?>
                  <a class="jumpBar-character" href="<?=$_SERVER['REQUEST_URI'];?>#jumpbottom"><i class="i rotate-180">arrow-up</i></a>
                </div>
              <?php require'core/layout/footer.php';?>
            </div>
          </section>
          <div id="jumpbottom"></div>
        </main>
      <?php }
      if($show=='item')require'core/layout/edit_content.php';
    }
  }
