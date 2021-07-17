<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content
 * @package    core/layout/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='categories';
if(isset($args[0])&&$args[0]=='scheduler')require'core/layout/scheduler.php';
else{
  if($view=='add'){
    $stockStatus='none';
    $ti=time();
    $schema='';
    $comments=0;
    if(isset($args[0])&&$args[0]=='article')$schema='blogPosting';
    if(isset($args[0])&&$args[0]=='inventory'){
      $schema='Offer';
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
    $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`options`,`uid`,`login_user`,`contentType`,`schemaType`,`status`,`active`,`stockStatus`,`ti`,`eti`,`pti`) VALUES ('00000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:stockStatus,:ti,:ti,:ti)");
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
  if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_content.php';
  else{
    if($show=='categories'){
      if(isset($args[0])&&$args[0]=='type'){
        if(isset($args[2])&&($args[2]=='archived'||$args[2]=='unpublished'||$args[2]=='autopublish'||$args[2]=='published'||$args[2]=='delete'||$args[2]=='all')){
          if($args[2]=='all')$getStatus=" ";
          else$getStatus=" AND `status`='".$args[2]."' ";
        }else$getStatus=" AND `status`!='archived'";
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters'".$getStatus."ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
        $s->execute([':contentType'=>$args[1]]);
      }elseif(isset($args[1])&&($args[1]=='archived'||$args[1]=='unpublished'||$args[1]=='autopublish'||$args[1]=='published'||$args[1]=='delete'||$args[1]=='all')){
        $getStatus=" AND `status`!='archived'";
        if($args[1]=='all')
          $getStatus=" ";
        else
          $getStatus=" AND `status`='".$args[1]."' ";
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters'".$getStatus."ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
        $s->execute([':contentType'=>$view]);
      }else{
        if(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `contentType`!='message_primary' AND `contentType`!='newsletters' ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1]),
            ':category_3'=>str_replace('-',' ',$args[2]),
            ':category_4'=>str_replace('-',' ',$args[3])
          ]);
        }elseif(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND `contentType`!='message_primary' AND `contentType`!='newsletters' ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1]),
            ':category_3'=>str_replace('-',' ',$args[2])
          ]);
        }elseif(isset($args[1])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND `contentType`!='message_primary' AND `contentType`!='newsletters' ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1])
          ]);
        }elseif(isset($args[0])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND `contentType`!='message_primary' AND `contentType`!='newsletters' ORDER BY `pin` DESC,`ti` ASC,`title` ASC");
          $s->execute([':category_1'=>str_replace('-',' ',$args[0])]);
        }else{
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`!='booking' AND `contentType`!='message_primary' AND `contentType`!='newsletters' ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
          $s->execute();
        }
      }?>
    <main>
      <section id="content">
        <div class="content-title-wrapper mb-0">
          <div class="content-title">
            <div class="content-title-heading">
              <div class="content-title-icon"><?= svg2((isset($args[1])&&$args[1]!=''?$args[1]:'content'),'i-3x');?></div>
              <div><?= isset($args[1])?ucfirst($args[1]):'All';?></div>
              <div class="content-title-actions">
                <button class="contentview" data-tooltip="tooltip" aria-label="View Content as Cards or List" onclick="toggleContentView();return false;"><?= svg2('list',($_COOKIE['contentview']=='list'?'d-none':'')).svg2('cards',($_COOKIE['contentview']=='cards'?'d-none':''));?></button>
                <a class="btn" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/settings';?>" role="button" aria-label="Content Settings"><?= svg2('settings');?></a>
                <?=(isset($args[1])&&$args[1]!=''&&$user['options'][0]==1?'<a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/add/'.$args[1].'" role="button" aria-label="Add '.ucfirst($args[1]).'">'.svg2('add').'</a>':'');?>
              </div>
            </div>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
              <li class="breadcrumb-item active breadcrumb-dropdown">
                <?= isset($args[1])&&$args[1]!=''?ucfirst($args[1]):'All';?><span class="breadcrumb-dropdown ml-2"><?= svg2('chevron-down');?></span>
                <ul class="breadcrumb-dropper">
                  <li><a href="<?= URL.$settings['system']['admin'].'/content';?>">All</a></li>
                  <?php $sc=$db->prepare("SELECT DISTINCT `contentType` FROM `".$prefix."content` WHERE `contentType`!='' AND `contentType`!=:cT ORDER BY `contentType` ASC");
                  $sc->execute([
                    ':cT'=>isset($args[1])&&$args[1]!=''?$args[1]:'%'
                  ]);
                  while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
                    echo'<li><a href="'.URL.$settings['system']['admin'].'/content/type/'.$rc['contentType'].'">'.ucfirst($rc['contentType']).'</a></li>';
                  }?>
            </ol>
          </div>
        </div>
        <div class="container-fluid p-0">
          <div class="card border-radius-0 shadow overflow-visible">
            <section id="contentview" class="content overflow-visible<?= isset($_COOKIE['contentview'])&&$_COOKIE['contentview']=='list'?' list':'';?>">
            <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
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
              }?>
              <article class="card overflow-visible" id="l_<?=$r['id'];?>">
                <div class="card-image overflow-visible">
                  <?php if($r['thumb']!=''&&file_exists('media/thumbs/'.basename($r['thumb'])))
                    echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img src="'.$r['thumb'].'" alt="'.$r['title'].'"></a>';
                  elseif($r['file']!=''&&file_exists('media/'.basename($r['file'])))
                    echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img src="media/sm/'.basename($r['file']).'" alt="'.$r['title'].'"></a>';
                  elseif($r['fileURL']!='')
                    echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['fileURL'].'"><img src="'.$r['fileURL'].'" alt="'.$r['title'].'"></a>';
                  else
                    echo'<img src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';?>
                  <select class="status <?=$r['status'];?>" onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');$(this).removeClass().addClass('status '+$(this).val());changeShareStatus($(this).val());">
                    <option class="unpublished" value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                    <option class="autopublish" value="autopublish"<?=$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                    <option class="published" value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                    <option class="delete" value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
                    <option class="archived" value="archived"<?=$r['status']=='archived'?' selected':'';?>>Archived</option>
                  </select>
                  <div class="image-toolbar">
                    <?= !isset($args[1])?'<a class="badger badge-success small text-white" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a><br>':'';
                    echo$r['views']>0?'<button class="views badger badge-danger trash" data-tooltip="tooltip" aria-label="Content Viewed '.$r['views'].' times, click to Clear" onclick="$(`[data-views=\''.$r['id'].'\']`).text(`0`);updateButtons(`'.$r['id'].'`,`content`,`views`,`0`);"><span data-views="'.$r['id'].'">'.$r['views'].'</span> '.svg2('view').'</button><br>':'';
                    echo(isset($cnt['cnt'])&&$cnt['cnt']>0?'<a class="comments badger badge-'.($sccc>0?'success':'default').'" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-5" role="button" aria-label="'.$sccc.' New Comments">'.$cnt['cnt'].' '.svg2('comments').'</a><br>':'');
                    echo$rr['num']>0?'<a class="badger badge-success add" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-6" data-tooltip="tooltip" role="button" aria-label="'.$rr['num'].' New Reviews">'.$rr['num'].' '.svg2('review').'</a><br>':'';?>
                    <button class="badger badger-primary <?=($r['status']=='published'?'':'d-none');?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media">Share</button>
                  </div>
                </div>
                <div class="card-header overflow-visible pt-2 line-clamp">
                  <?= !isset($args[1])?'<span class="d-block"><a class="badger badge-success small text-white" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a></span>':'';?>
                  <a href="<?= URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>" data-tooltip="tooltip" aria-label="Edit <?=$r['title'];?>"><?= $r['thumb']!=''&&file_exists($r['thumb'])?'<img src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                  <?php if($user['options'][1]==1){
                    echo$r['suggestions']==1?'<span data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb','text-success').'</span>':'';
                    if($r['contentType']=='proofs'){
                      $sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                      $sp->execute([':id'=>$r['uid']]);
                      $sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                  <div class="small">Belongs to <a href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>" data-tooltip="tooltip" aria-label="View Proofs"><?=$sr['name']!=''?$sr['name']:$sr['username'];?></a></div>
                    <?php }
                  }
                  echo'<br><small class="text-muted" id="rank'.$r['id'].'">Available to '.($r['rank']==0?'Everyone':ucwords(str_replace('-',' ',rank($r['rank']))).' and above').'</small>';?>
                </div>
                <div class="card-footer">
                  <span class="code hidewhenempty"><?=$r['code'];?></span>
                  <span class="reviews hidewhenempty">
                    <?php echo$rr['num']>0?'<a class="btn add" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-6" data-tooltip="tooltip" role="button" aria-label="'.$rr['num'].' New Reviews">'.$rr['num'].' '.svg2('review').'</a>':'';?>
                  </span>
                  <span class="comments hidewhenempty">
                    <?=(isset($cnt['cnt'])&&$cnt['cnt']>0?'<a class="btn'.($sccc>0?' add':'').'" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-5" role="button" aria-label="'.$sccc.' New Comments">'.$cnt['cnt'].' '.svg2('comments').'</a>':'');?>
                  </span>
                  <?=$r['views']>0?'<button class="btn views trash" data-tooltip="tooltip" aria-label="Content Viewed '.$r['views'].' times, click to Clear" onclick="$(`[data-views=\''.$r['id'].'\'`).text(`0`);updateButtons(`'.$r['id'].'`,`content`,`views`,`0`);"><span data-views="'.$r['id'].'">'.$r['views'].'</span> '.svg2('view').'</button>':'';?>
                  <div id="controls_<?=$r['id'];?>">
                    <div class="btn-toolbar float-right" role="toolbar">
                      <div class="btn-group" role="group">
                        <button class="share <?=($r['status']=='published'?'':'d-none');?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><?= svg2('share');?></button>
                        <a class="btn" href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$r['id'];?>" role="button" data-tooltip="tooltip"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                        <?php if($user['options'][0]==1){?>
                          <button class="btn add <?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','content','status','unpublished');"><?= svg2('untrash');?></button>
                          <button class="btn trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','content','status','delete');"><?= svg2('trash');?></button>
                          <button class="btn purge trash<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','content');"><?= svg2('purge');?></button>
                          <button class="btn-ghost quickeditbtn" data-qeid="<?=$r['id'];?>" data-qet="content" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><?php svg('chevron-down').svg('chevron-up','d-none');?></button>
                        <?php }?>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
              <div class="quickedit col-12 d-none" id="quickedit<?=$r['id'];?>"></div>
            <?php }?>
          </section>
          <div class="col-12 mt-0 text-right">
            <small>View:
              <a class="badger badge-light" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1]);?>" aria-label="Display All Content">All</a>&nbsp;
              <a class="badger badge-published" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>published" aria-label="Display Published Items">Published</a>&nbsp;
              <a class="badger badge-autopublish" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>autopublish" aria-label="Display Auto Published Items">Auto Published</a>&nbsp;
              <a class="badger badge-unpublished" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>unpublished" aria-label="Display Unpublished Items">Unpublished</a>&nbsp;
              <a class="badger badge-delete" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>delete" aria-label="Display Deleted Items">Deleted</a>&nbsp;
              <a class="badger badge-archived" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>archived" aria-label="Display Archived Items">Archived</a>&nbsp;
            </small>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </div>
    </section>
  </main>
  <?php }
    if($show=='item')require'core/layout/edit_content.php';
  }
}
