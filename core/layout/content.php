<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content
 * @package    core/layout/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Adjust Links Layout Items
 * @changes    v0.0.2 Add Permissions Options
 */
$rank=0;
$show='categories';
if($args[0]=='scheduler'){
  include'core'.DS.'layout'.DS.'scheduler.php';
}else{
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
    $q=$db->prepare("INSERT INTO `".$prefix."content` (options,uid,login_user,contentType,schemaType,status,active,stockStatus,ti,eti,pti) VALUES ('00000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:stockStatus,:ti,:ti,:ti)");
    $uid=isset($user['id'])?$user['id']:0;
    $login_user=$user['name']!=''?$user['name']:$user['username'];
    $q->execute([':contentType'=>$args[0],':uid'=>$uid,':login_user'=>$login_user,':schemaType'=>$schema,':stockStatus'=>$stockStatus,':ti'=>$ti]);
    $id=$db->lastInsertId();
    $args[0]=ucfirst($args[0]).' '.$id;
    $s=$db->prepare("UPDATE `".$prefix."content` SET title=:title,urlSlug=:urlslug WHERE id=:id");
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
    $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
    $s->execute([':id'=>$args[1]]);
    $show='item';
  }
  if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_content.php';
  else{
    if($show=='categories'){
      if($args[0]=='type'){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType=:contentType AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
        $s->execute([':contentType'=>$args[1]]);
      }else{
        if(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND LOWER(category_3) LIKE LOWER(:category_3) AND LOWER(category_4) LIKE LOWER(:category_4) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1]),
            ':category_3'=>str_replace('-',' ',$args[2]),
            ':category_4'=>str_replace('-',' ',$args[3])
          ]);
        }elseif(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND LOWER(category_3) LIKE LOWER(:category_3) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1]),
            ':category_3'=>str_replace('-',' ',$args[2])
          ]);
        }elseif(isset($args[1])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1])
          ]);
        }elseif(isset($args[0])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti ASC,title ASC");
          $s->execute([':category_1'=>str_replace('-',' ',$args[0])]);
        }else{
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType!='booking' AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute();
        }
      }?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
<?php if($args[1]!=''){?>
    <li class="breadcrumb-item active"><?php echo ucfirst($args[1]).(in_array($args[1],array('article','service'))?'s':'');?></li>
<?php }?>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
<?php if($args[1]!=''){
  if($user['options']{0}==1){?>
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'];?>/add/<?php echo$args[1];?>" data-tooltip="tooltip" data-placement="left" title="Add <?php echo ucfirst($args[1]);?>" role="button" aria-label="Add"><?php svg('add');?></a>
<?php }
}?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
<?php if($args[0]==''){?>
    <div class="row">
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/media';?>" aria-label="Go to Media Page">
        <span class="card">
          <span class="card-header h5">Media</span>
          <span class="card-body card-text text-center pt-0"><?php svg('picture','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/pages';?>" aria-label="Go to Pages">
        <span class="card">
          <span class="card-header h5">Pages</span>
          <span class="card-body card-text text-center pt-0"><?php svg('content','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>" aria-label="Go to Scheduler">
        <span class="card">
          <span class="card-header h5">Scheduler</span>
          <span class="card-body card-text text-center pt-0"><?php svg('calendar-time','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/article';?>" aria-label="Go to Articles">
        <span class="card">
          <span class="card-header h5">Articles</span>
          <span class="card-body card-text text-center pt-0"><?php svg('content','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/portfolio';?>" aria-label="Go to Portfolio">
        <span class="card">
          <span class="card-header h5">Portfolio</span>
          <span class="card-body card-text text-center pt-0"><?php svg('portfolio','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/events';?>" aria-label="Go to Events">
        <span class="card">
          <span class="card-header h5">Events</span>
          <span class="card-body card-text text-center pt-0"><?php svg('calendar','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/news';?>" aria-label="Go to News">
        <span class="card">
          <span class="card-header h5">News</span>
          <span class="card-body card-text text-center pt-0"><?php svg('email-read','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>" aria-label="Go to Testimonials">
        <span class="card">
          <span class="card-header h5">Testimonials</span>
          <span class="card-body card-text text-center pt-0"><?php svg('testimonial','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/inventory';?>" aria-label="Go to Inventory">
        <span class="card">
          <span class="card-header h5">Inventory</span>
          <span class="card-body card-text text-center pt-0"><?php svg('shipping','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/rewards';?>" aria-label="Go to Rewards">
        <span class="card">
          <span class="card-header h5">Rewards</span>
          <span class="card-body card-text text-center pt-0"><?php svg('credit-card','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/service';?>" aria-label="Go to Services">
        <span class="card">
          <span class="card-header h5">Services</span>
          <span class="card-body card-text text-center pt-0"><?php svg('service','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/proofs';?>" aria-label="Go to Proofs">
        <span class="card">
          <span class="card-header h5">Proofs</span>
          <span class="card-body card-text text-center pt-0"><?php svg('proof','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 m-1 p-0" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>" aria-label="Go to Newsletters">
        <span class="card">
          <span class="card-header h5">Newsletters</span>
          <span class="card-body card-text text-center pt-0"><?php svg('newspaper','i-5x');?></span>
        </span>
      </a>
    </div>
<?php }else{?>
    <div class="card">
      <div class="card-body">
        <table class="table table-condensed table-striped table-hover">
          <thead>
            <tr>
              <th></th>
              <th class="col">Title</th>
              <th class="col-sm-1 text-center">Comments</th>
              <th class="col-sm-1 text-center" data-tooltip="tooltip" title="Reviews/Score">Reviews</th>
              <th class="col-3 text-center"><span class="d-inline">Views&nbsp;</span><?php echo$user['options']{1}==1?'<button class="btn btn-secondary btn-xs d-inline" onclick="$(`[data-views=\'views\']`).text(`0`);purge(`0`,`contentviews`,`'.$args[1].'`);" data-tooltip="tooltip" title="Clear All" aria-label="Clear All">'.svg2('eraser').'</button>':'';?></th>
              <th class="col-sm-2"></th>
            </tr>
          </thead>
          <tbody id="listtype" class="list" data-t="menu" data-c="ord">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo' danger';elseif($r['status']!='published')echo' warning';?>">
              <td class="align-middle">
<?php           if($r['thumb']!=''&&file_exists('media'.DS.'thumbs'.basename($r['thumb'])))
                  echo'<a href="'.$r['file'].'" data-fancybox="lightbox'.$r['id'].'" data-max-width="700"><img class="img-rounded" style="max-width:32px;" src="'.$r['thumb'].'" alt="'.$r['title'].'"></a>';
                elseif($r['file']!=''&&file_exists('media'.DS.basename($r['file'])))
                  echo'<a href="'.$r['file'].'" data-fancybox="lightbox'.$r['id'].'" data-max-width="700"><img class="img-rounded" style="max-width:32px;" src="'.$r['file'].'" alt="'.$r['title'].'"></a>';
                elseif($r['fileURL']!='')
                  echo'<a href="'.$r['fileURL'].'" data-fancybox="lightbox'.$r['id'].'" data-max-width="700"><img class="img-rounded" style="max-width:32px;" src="'.$r['fileURL'].'" alt="'.$r['title'].'"></a>';
                else
                  echo'';?>
              </td>
              <td class="align-middle">
                <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>" aria-label="Edit <?php echo$r['title'];?>"><?php echo $r['thumb']!=''&&file_exists($r['thumb'])?'<img class="table-thumb" src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
<?php if($user['options']{1}==1){
        echo$r['suggestions']==1?'<span data-tooltip="tooltip" title="Editing Suggestions" aria-label="Editing Suggestions">'.svg2('lightbulb','text-success').'</span>':'';
                if($r['contentType']=='proofs'){
                  $sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
                  $sp->execute([':id'=>$r['uid']]);
                  $sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                  <div class="small">Belongs to <a href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>" aria-label="View Proofs"><?php echo$sr['name']!=''?$sr['name']:$sr['username'];?></a></div>
<?php           }
}?>
              </td>
              <td class="text-center align-middle">
<?php           if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
                  $sc=$db->prepare("SELECT COUNT(id) as cnt FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType");
                  $sc->execute([':id'=>$r['id'],':contentType'=>$r['contentType']]);
                  $cnt=$sc->fetch(PDO::FETCH_ASSOC);
                  $scc=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType AND status='unapproved'");
                  $scc->execute([':id'=>$r['id'],'contentType'=>$r['contentType']]);
                  $sccc=$scc->rowCount($scc);
                  echo'<a class="btn btn-secondary'.($sccc>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab-content-comments" data-tooltip="tooltip" title="'.$sccc.' New Comments" role="button" aria-label="New Comments">'.svg2('comments').'&nbsp;&nbsp;'.$cnt['cnt'].'</a>';
                }?>
              </td>
              <td class="text-center align-middle">
<?php           $sr=$db->prepare("SELECT COUNT(id) as num,SUM(cid) as cnt FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid");
                $sr->execute([':rid'=>$r['id']]);
                $rr=$sr->fetch(PDO::FETCH_ASSOC);
                $srr=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid AND status!='approved'");
                $srr->execute([':rid'=>$r['id']]);
                $src=$srr->rowCount($srr);
                echo$rr['num']>0?'<a class="btn btn-secondary'.($src>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab-content-reviews"'.($src>0?' data-tooltip="tooltip" title="'.$src.' New Reviews':'').' role="button" aria-label="New Reviews">'.$rr['num'] .'/'.$rr['cnt'].'</a>':'';?>
              </td>
              <td class="text-center align-middle">
                <?php echo$user['options']{1}==1?'<button class="btn btn-secondary trash" onclick="$(`#views'.$r['id'].'`).text(`0`);updateButtons(`'.$r['id'].'`,`content`,`views`,`0`);" data-tooltip="tooltip" title="Clear" aria-label="Clear">'.svg2('eraser').'&nbsp;&nbsp;<span id="views'.$r['id'].'" data-views="views">'.$r['views'].'</span></button>':$r['views'];?>
              </td>
              <td id="controls_<?php echo$r['id'];?>" class="align-middle">
                <div class="btn-group float-right">
                  <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/content/edit/<?php echo$r['id'];?>" role="button" data-tooltip="tooltip"<?php echo$user['options']{1}==1?' title="Edit" aria-label="Edit"':' title="View" aria-label="View"';?>><?php echo$user['options']{1}==1?svg2('edit'):svg2('view');?></a>
<?php   if($user['options']{0}==1){?>
                  <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="Restore" aria-label="Restore"><?php svg('untrash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-tooltip="tooltip" title="Purge" aria-label="Purge"><?php svg('purge');?></button>
<?php   }?>
                </div>
              </td>
            </tr>
<?php }?>
          </tbody>
        </table>
      </div>
    </div>
<?php }?>
  </div>
</main>
<?php }
    if($show=='item')
      include'core'.DS.'layout'.DS.'edit_content.php';
  }
}
