<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content
 * @package    core/layout/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Fix incorrect Icon being fetched when displaying Contect Type Selection Fallback.
 * @changes    v0.1.2 Use PHP short codes where possible.
 * @changes    v0.1.2 Tidy up Source.
 */
$rank=0;
$show='categories';
if($args[0]=='scheduler')require'core/layout/scheduler.php';
else{
  if($view=='add'){
    $stockStatus='none';
    $ti=time();
    $schema='';
    $comments=0;
    if($args[0]=='article')$schema='blogPosting';
    if($args[0]=='inventory'){
      $schema='Offer';
      $stockStatus='quantity';
    }
    if($args[0]=='service')$schema='Service';
    if($args[0]=='gallery')$schema='ImageGallery';
    if($args[0]=='testimonial')$schema='Review';
    if($args[0]=='news')$schema='NewsArticle';
    if($args[0]=='event')$schema='Event';
    if($args[0]=='portfolio')$schema='CreativeWork';
    if($args[0]=='proof'){
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
  if($args[0]=='edit'){
    $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
    $s->execute([':id'=>$args[1]]);
    $show='item';
  }
  if($args[0]=='settings')require'core/layout/set_content.php';
  else{
    if($show=='categories'){
      if($args[0]=='type'){
        if(isset($args[2])&&($args[2]=='archived'||$args[2]=='unpublished'||$args[2]=='autopublish'||$args[2]=='published'||$args[2]=='delete'||$args[2]=='all')){
          if($args[2]=='all')$getStatus=" ";
          else$getStatus=" AND `status`='".$args[2]."' ";
        }else$getStatus=" AND `status`!='archived'";
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters'".$getStatus."ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
        $s->execute([':contentType'=>$args[1],]);
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
              <div><?= ucfirst($args[1]);?></div>
              <div class="content-title-actions">
                <?=($user['options'][7]==1?' <a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/settings" role="button" aria-label="Content Settings">'.svg2('settings').'</a>':'').($args[1]!=''&&$user['options'][0]==1?' <a class="btn add" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/add/'.$args[1].'" role="button" aria-label="Add '.ucfirst($args[1]).'">'.svg2('add').'</a>':'');?>
              </div>
            </div>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
              <?php if($args[1]!='')echo'<li class="breadcrumb-item active">'.ucfirst($args[1]).(in_array($args[1],array('article','service'))?'s':'').'</li>';?>
            </ol>
          </div>
        </div>
        <div class="container-fluid p-0">
          <div class="card border-radius-0 shadow overflow-visible">
            <?php if($args[0]==''){?>
              <div class="row p-3">
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/media';?>" aria-label="Go to Media Page">
                  <span class="h5">Media</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('picture','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/pages';?>" aria-label="Go to Pages">
                  <span class="h5">Pages</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('content','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/scheduler';?>" aria-label="Go to Scheduler">
                  <span class="h5">Scheduler</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('calendar-time','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/article';?>" aria-label="Go to Articles">
                  <span class="h5">Articles</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('content','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/portfolio';?>" aria-label="Go to Portfolio">
                  <span class="h5">Portfolio</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('portfolio','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/events';?>" aria-label="Go to Events">
                  <span class="h5">Events</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('calendar','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/news';?>" aria-label="Go to News">
                  <span class="h5">News</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('email-read','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/testimonials';?>" aria-label="Go to Testimonials">
                  <span class="h5">Testimonials</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('testimonial','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/inventory';?>" aria-label="Go to Inventory">
                  <span class="h5">Inventory</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('shipping','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/rewards';?>" aria-label="Go to Rewards">
                  <span class="h5">Rewards</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('credit-card','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/service';?>" aria-label="Go to Services">
                  <span class="h5">Services</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('service','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/proofs';?>" aria-label="Go to Proofs">
                  <span class="h5">Proofs</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('proof','i-5x');?></span>
                </a>
                <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/newsletters';?>" aria-label="Go to Newsletters">
                  <span class="h5">Newsletters</span>
                  <span class="p-0">
                    <span class="text-3x">&nbsp;</span>
                  </span>
                  <span class="icon"><?= svg2('newspaper','i-5x');?></span>
                </a>
              </div>
            <?php }else{?>
              <table class="table-zebra">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th class="col">Title</th>
                    <th class="col text-center">Code</th>
                    <th class="col text-center d-none d-sm-table-cell">Comments</th>
                    <th class="col text-center d-none d-sm-table-cell">Reviews</th>
                    <th class="col text-center d-none d-sm-table-cell">Views<?=$user['options'][1]==1?' <button class="btn-sm trash" data-tooltip="tooltip" aria-label="Clear All" onclick="$(`[data-views=\'views\']`).text(`0`);purge(`0`,`contentviews`,`'.$args[1].'`);">'.svg2('eraser').'</button>':'';?></th>
                    <th class="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr class="<?php
                    if($r['status']=='delete')echo' bg-danger';
                    elseif($r['status']=='archived')echo' bg-info';
                    elseif($r['status']=='unpublished')echo' bg-warning';?>" id="l_<?=$r['id'];?>">
                      <td class="align-middle"><button class="btn-ghost quickeditbtn" data-qeid="<?=$r['id'];?>" data-qet="content" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><?php svg('plus').svg('close','d-none');?></button></td>
                      <td class="align-middle">
                        <?php if($r['thumb']!=''&&file_exists('media/thumbs/'.basename($r['thumb'])))echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img class="avatar" src="'.$r['thumb'].'" alt="'.$r['title'].'"></a>';
                        elseif($r['file']!=''&&file_exists('media/'.basename($r['file'])))echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['file'].'"><img class="avatar" src="'.$r['file'].'" alt="'.$r['title'].'"></a>';
                        elseif($r['fileURL']!='')echo'<a data-fancybox="media" data-caption="'.$r['title'].($r['fileALT']!=''?'<br>ALT: '.$r['fileALT']:'<br>ALT: <span class=text-danger>Edit the ALT Text for SEO (Will use above Title instead)</span>').'" href="'.$r['fileURL'].'"><img class="avatar" src="'.$r['fileURL'].'" alt="'.$r['title'].'"></a>';
                        else echo'<img class="avatar" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';?>
                      </td>
                      <td class="align-middle">
                        <a href="<?= URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>" data-tooltip="tooltip" aria-label="Edit <?=$r['title'];?>"><?= $r['thumb']!=''&&file_exists($r['thumb'])?'<img class="avatar" src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                        <?php if($user['options'][1]==1){
                          echo$r['suggestions']==1?'<span data-tooltip="tooltip" aria-label="Editing Suggestions">'.svg2('lightbulb','text-success').'</span>':'';
                          if($r['contentType']=='proofs'){
                            $sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                            $sp->execute([':id'=>$r['uid']]);
                            $sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                            <div class="small">Belongs to <a href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>" data-tooltip="tooltip" aria-label="View Proofs"><?=$sr['name']!=''?$sr['name']:$sr['username'];?></a></div>
                          <?php }
                        }
                        echo'<br><small class="text-muted" id="rank'.$r['id'].'">Available to '.($r['rank']==0?'Everyone':ucfirst(rank($r['rank'])).' and above').'</small>';?>
                      </td>
                      <td class="align-middle text-center small"><small><?=$r['code'];?></small></td>
                      <td class="text-center align-middle d-none d-sm-table-cell">
                        <?php           if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
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
                          $sccc=$scc->rowCount($scc);
                          echo($cnt['cnt']>0?'<a class="btn'.($sccc>0?' add':'').'" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab-content-comments" role="button" aria-label="'.$sccc.' New Comments">'.$cnt['cnt'].'</a>':'');
                        }?>
                      </td>
                      <td class="text-center align-middle d-none d-sm-table-cell">
                        <?php $sr=$db->prepare("SELECT COUNT(`id`) as num,SUM(`cid`) as cnt FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid");
                        $sr->execute([':rid'=>$r['id']]);
                        $rr=$sr->fetch(PDO::FETCH_ASSOC);
                        $srr=$db->prepare("SELECT `id` FROM `".$prefix."comments` WHERE `contentType`='review' AND `rid`=:rid AND `status`!='approved'");
                        $srr->execute([':rid'=>$r['id']]);
                        $src=$srr->rowCount($srr);
                        echo$rr['num']>0?'<a class="btn'.($src>0?' add':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab-content-reviews"'.($src>0?' data-tooltip="tooltip"':'').' role="button" aria-label="'.$src.' New Reviews">'.$rr['num'] .'/'.$rr['cnt'].'</a>':'';?>
                      </td>
                      <td class="text-center align-middle d-none d-sm-table-cell">
                        <?=$user['options'][1]==1?'<button class="btn trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views'.$r['id'].'`).text(`0`);updateButtons(`'.$r['id'].'`,`content`,`views`,`0`);"><span id="views'.$r['id'].'" data-views="views">'.$r['views'].'</span></button>':$r['views'];?>
                      </td>
                      <td class="align-middle" id="controls_<?=$r['id'];?>">
                        <div class="btn-toolbar float-right" role="toolbar">
                          <div class="btn-group" role="group">
                            <button class="<?=($r['status']=='published'?'':'d-none');?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><?= svg2('share');?></button>
                            <a class="btn" href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$r['id'];?>" role="button" data-tooltip="tooltip"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><?=$user['options'][1]==1?svg2('edit'):svg2('view');?></a>
                            <?php if($user['options'][0]==1){?>
                              <button class="btn add <?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','content','status','unpublished');"><?= svg2('untrash');?></button>
                              <button class="btn trash<?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','content','status','delete');"><?= svg2('trash');?></button>
                              <button class="btn purge trash<?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','content');"><?= svg2('purge');?></button>
                            <?php }?>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="quickedit d-none" id="quickedit<?=$r['id'];?>"></tr>
                  <?php }?>
                </tbody>
              </table>
              <div class="col-12 mt-0 text-right">
                <small>View:
                  <a class="badger badge-<?= !isset($args[2])?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/type/'.$args[1];?>" aria-label="Display Default View">Default</a>&nbsp;
                  <a class="badger badge-<?= isset($args[2])&&$args[2]=='all'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/type/'.$args[1];?>/all" aria-label="Display All Content">All</a>&nbsp;
                  <a class="badger badge-<?= isset($args[2])&&$args[2]=='published'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/type/'.$args[1];?>/published" aria-label="Display Published Items">Published</a>&nbsp;
                  <a class="badger badge-<?= isset($args[2])&&$args[2]=='autopublish'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/type/'.$args[1];?>/autopublish" aria-label="Display Auto Published Items">Auto Published</a>&nbsp;
                  <a class="badger badge-<?= isset($args[2])&&$args[2]=='unpublished'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/type/'.$args[1];?>/unpublished" aria-label="Display Unpublished Items">Unpublished</a>&nbsp;
                  <a class="badger badge-<?= isset($args[2])&&$args[2]=='delete'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/type/'.$args[1];?>/delete" aria-label="Display Deleted Items">Deleted</a>&nbsp;
                  <a class="badger badge-<?= isset($args[2])&&$args[2]=='archived'?'success':'secondary';?>" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/content/type/'.$args[1];?>/archived" aria-label="Display Archived Items">Archived</a>&nbsp;
                </small>
              </div>
            <?php }
            require'core/layout/footer.php';?>
          </div>
        </div>
      </section>
    </main>
    <?php }
    if($show=='item')require'core/layout/edit_content.php';
  }
}
