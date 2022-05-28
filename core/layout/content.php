<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content
 * @package    core/layout/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.15
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
        }elseif(isset($args[2])&&$args[2]!='cat'){
          $getStatus=" ";
        }else$getStatus=" AND `status`!='archived'";
        if(isset($args[2])&&$args[2]=='cat'){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq'".$getStatus."ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
          $s->execute([
            ':category_1'=>isset($args[3])&&$args[3]!=''?'%'.str_replace('-','%',$args[3]).'%':'%',
            ':category_2'=>isset($args[4])&&$args[4]!=''?'%'.str_replace('-','%',$args[4]).'%':'%',
            ':category_3'=>isset($args[5])&&$args[5]!=''?'%'.str_replace('-','%',$args[5]).'%':'%',
            ':category_4'=>isset($args[6])&&$args[6]!=''?'%'.str_replace('-','%',$args[6]).'%':'%',
            ':contentType'=>$args[1]
          ]);
        }else{
//          if($args[1]=='events'){
            if(isset($_GET['field'])&&($_GET['field']=='tis'||$_GET['field']=='tie'||$_GET['field']=='ti'))
              $eventsort='`'.$_GET['field'].'` '.(isset($_GET['by'])&&$_GET['by']=='ASC'?'ASC':'DESC');
            else
              $eventsort='`pin` DESC, `ti` DESC, `title` ASC';
            $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType ".$getStatus."ORDER BY ".$eventsort);
            $s->execute([':contentType'=>$args[1]]);
//          }
        }
      }elseif(isset($args[1])&&($args[1]=='archived'||$args[1]=='unpublished'||$args[1]=='autopublish'||$args[1]=='published'||$args[1]=='delete'||$args[1]=='all')){
        $getStatus=" AND `status`!='archived'";
        if($args[1]=='all')
          $getStatus=" ";
        else
          $getStatus=" AND `status`='".$args[1]."' ";
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq'".$getStatus."ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
        $s->execute([':contentType'=>$view]);
      }else{
        if(isset($args[5])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND LOWER(`category_4`) LIKE LOWER(:category_4) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' ORDER BY `pin` DESC,`ti` DESC,`title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2])),
            ':category_2'=>str_replace('-',' ',strtolower($args[3])),
            ':category_3'=>str_replace('-',' ',strtolower($args[4])),
            ':category_4'=>str_replace('-',' ',strtolower($args[5]))
          ]);
        }elseif(isset($args[4])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND LOWER(`category_3`) LIKE LOWER(:category_3) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2])),
            ':category_2'=>str_replace('-',' ',strtolower($args[3])),
            ':category_3'=>str_replace('-',' ',strtolower($args[4]))
          ]);
        }elseif(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND LOWER(`category_2`) LIKE LOWER(:category_2) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2])),
            ':category_2'=>str_replace('-',' ',strtolower($args[3]))
          ]);
        }elseif(isset($args[2])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(`category_1`) LIKE LOWER(:category_1) AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' ORDER BY `pin` DESC, `ti` ASC, `title` ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',strtolower($args[2]))
          ]);
        }else{
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`!='booking' AND `contentType`!='message_primary' AND `contentType`!='newsletters' AND `contentType`!='job' AND `contentType`!='faq' ORDER BY `pin` DESC, `ti` DESC, `title` ASC");
          $s->execute();
        }
      }?>
    <main>
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
        <div class="container-fluid p-2">
          <div class="card mt-3 p-4 border-radius-0 bg-white border-0 shadow overflow-visible">
            <div class="card-actions">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <ol class="breadcrumb m-0 pl-0 pt-0">
                    <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
                    <li class="breadcrumb-item active breadcrumb-dropdown">
                      <?= isset($args[1])&&$args[1]!=''?ucfirst($args[1]):'All';?><span class="breadcrumb-dropdown ml-2"><i class="i">chevron-down</i></span>
                      <ul class="breadcrumb-dropper">
                        <li><a href="<?= URL.$settings['system']['admin'].'/content';?>">All</a></li>
                        <?php $sc=$db->prepare("SELECT DISTINCT `contentType` FROM `".$prefix."content` WHERE `contentType`!='' AND `contentType`!=:cT ORDER BY `contentType` ASC");
                        $sc->execute([':cT'=>isset($args[1])&&$args[1]!=''?$args[1]:'%']);
                        while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
                          echo'<li><a href="'.URL.$settings['system']['admin'].'/content/type/'.$rc['contentType'].'">'.ucfirst($rc['contentType']).'</a></li>';
                        }?>
                      </ul>
                  </ol>
                  <div class="text-left mt-0 pt-0">
                  View:
                    <a class="badger badge-secondary" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1]);?>" data-tooltip="tooltip" aria-label="Display All Content">All</a>&nbsp;
                    <a class="badger badge-success" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>published" data-tooltip="tooltip" aria-label="Display Published Items">Published</a>&nbsp;
                    <a class="badger badge-info" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>autopublish" data-tooltip="tooltip" aria-label="Display Auto Published Items">Auto Published</a>&nbsp;
                    <a class="badger badge-warning" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>unpublished" data-tooltip="tooltip" aria-label="Display Unpublished Items">Unpublished</a>&nbsp;
                    <a class="badger badge-danger" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>delete" data-tooltip="tooltip" aria-label="Display Deleted Items">Deleted</a>&nbsp;
                    <a class="badger badge-secondary" href="<?= URL.$settings['system']['admin'].'/content/'.(!isset($args[1])?'':'type/'.$args[1].'/');?>archived" data-tooltip="tooltip" aria-label="Display Archived Items">Archived</a>
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
                  <?php if($args[1]=='events'){?>
                      <form class="form-row justify-content-end" method="get" action="">
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
                  <div class="form-row justify-content-end">
                    <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
                    <div class="btn-group">
                      <button class="btn contentview" data-tooltip="left" aria-label="View Content as Cards or List" onclick="toggleContentView();return false;"><i class="i<?=($_COOKIE['contentview']=='list'?' d-none':'');?>">list</i><i class="i<?=($_COOKIE['contentview']=='cards'?' d-none':'');?>">cards</i></button>
                      <a class="btn" href="<?= URL.$settings['system']['admin'].'/content/settings';?>" role="button" data-tooltip="left" aria-label="Content Settings"><i class="i">settings</i></a>
                      <?=(isset($args[1])&&$args[1]!=''&&$user['options'][0]==1?'<a class="btn add" href="'.URL.$settings['system']['admin'].'/add/'.$args[1].'" role="button" data-tooltip="left" aria-label="Add '.ucfirst($args[1]).'"><i class="i">add</i></a>':'');?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <section class="content overflow-visible<?= isset($_COOKIE['contentview'])&&$_COOKIE['contentview']=='list'?' list':'';?>" id="contentview">
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
              <article class="card m-2 overflow-visible card-list" data-content="<?=$r['contentType'].' '.$r['title'];?>" id="l_<?=$r['id'];?>">
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
<?php if($r['contentType']=='inventory'){?>
                  <select class="stock status"
                  onchange="update('<?=$r['id'];?>','content','stockStatus',$(this).val(),'select');" data-tooltip="tooltip" aria-label="Stock Status">
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
<?php }?>
                  <div class="image-toolbar">
                    <?php echo !isset($args[1])?'<a class="badger badge-success small text-white" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a><br>':'';
                    echo($r['pin'][0]==1?'<a class="badger badge-primary small text-white" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#pin">Pinned</a><br>':'');
                    echo$r['views']>0?'<button class="views badger badge-danger trash" data-tooltip="tooltip" aria-label="Content Viewed '.$r['views'].' times, click to Clear" onclick="$(`[data-views=\''.$r['id'].'\']`).text(`0`);updateButtons(`'.$r['id'].'`,`content`,`views`,`0`);"><span data-views="'.$r['id'].'">'.$r['views'].'</span> <i class="i">view</i></button><br>':'';
                    echo(isset($cnt['cnt'])&&$cnt['cnt']>0?'<a class="comments badger badge-'.($sccc>0?'success':'default').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-5" role="button" data-tooltip="tooltip" aria-label="'.$sccc.' New Comments">'.$cnt['cnt'].' <i class="i">comments</i></a><br>':'');
                    echo$rr['num']>0?'<a class="badger badge-success add" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-6" role="button" data-tooltip="tooltip" aria-label="'.$rr['num'].' New Reviews">'.$rr['num'].' <i class="i">review</i></a><br>':'';?>
                    <button class="badger badger-primary <?=($r['status']=='published'?'':' d-none');?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                  </div>
                </div>
                <div class="card-header overflow-visible pt-2 line-clamp">
                  <?= !isset($args[1])?'<span class="d-block"><a class="badger badge-success small text-white" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a></span>':'';?>
                  <a href="<?= URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>" data-tooltip="tooltip" aria-label="Edit <?=$r['title'];?>"><?= $r['thumb']!=''&&file_exists($r['thumb'])?'<img src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                  <?php if($user['options'][1]==1){
                    echo$r['suggestions']==1?'<span data-tooltip="tooltip" aria-label="Editing Suggestions"><i class="i text-success">lightbulb</i></span>':'';
                    if($r['contentType']=='proofs'){
                      $sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
                      $sp->execute([':id'=>$r['uid']]);
                      $sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                  <div class="small">Belongs to <a href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>" data-tooltip="tooltip" aria-label="View Proofs"><?=$sr['name']!=''?$sr['name']:$sr['username'];?></a></div>
                    <?php }
                  }
                  echo'<br><small class="text-muted" id="rank'.$r['id'].'">Available to '.($r['rank']==0?'Everyone':'<span class="badge badge-'.rank($r['rank']).' p-0 px-1 text-white">'.ucwords(str_replace('-',' ',rank($r['rank']))).'</span> and above').'</small>';?>
                </div>
                <div class="card-footer">
                  <span class="code hidewhenempty"><?=$r['code'];?></span>
                  <span class="reviews hidewhenempty"><?php echo$rr['num']>0?'<a class="btn add" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-6" role="button" data-tooltip="tooltip" aria-label="'.$rr['num'].' New Reviews">'.$rr['num'].' <i class="i">review</i></a>':'';?></span>
                  <span class="comments hidewhenempty"><?=(isset($cnt['cnt'])&&$cnt['cnt']>0?'<a class="btn'.($sccc>0?' add':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#tab1-5" role="button" data-tooltip="tooltip" aria-label="'.$sccc.' New Comments">'.$cnt['cnt'].' <i class="i">comments</i></a>':'');?></span>
                  <?=$r['views']>0?'<button class="btn views trash" data-tooltip="tooltip" aria-label="Content Viewed '.$r['views'].' times, click to Clear" onclick="$(`[data-views=\''.$r['id'].'\'`).text(`0`);updateButtons(`'.$r['id'].'`,`content`,`views`,`0`);"><span data-views="'.$r['id'].'">'.$r['views'].'</span> <i class="i">view</i></button>':'';?>
                  <div id="controls_<?=$r['id'];?>">
                    <div class="btn-toolbar float-right" role="toolbar">
                      <div class="btn-group" role="group">
                        <button class="share <?=($r['status']=='published'?'':'d-none');?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" id="share<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                        <a class="btn" href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$r['id'];?>" role="button" data-tooltip="tooltip"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><i class="i"><?=$user['options'][1]==1?'edit':'view';?></i></a>
                        <?php if($user['options'][0]==1){?>
                          <button class="btn add <?=$r['status']!='delete'?' d-none':'';?>" id="untrash<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons('<?=$r['id'];?>','content','status','unpublished');"><i class="i">untrash</i></button>
                          <button class="btn trash <?=$r['status']=='delete'?' d-none':'';?>" id="delete<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons('<?=$r['id'];?>','content','status','delete');"><i class="i">trash</i></button>
                          <button class="btn purge trash <?=$r['status']!='delete'?' d-none':'';?>" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Purge" onclick="purge('<?=$r['id'];?>','content');"><i class="i">purge</i></button>
                          <button class="btn-ghost quickeditbtn" data-qeid="<?=$r['id'];?>" data-qet="content" data-tooltip="tooltip" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>
                        <?php }?>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
              <div class="quickedit d-none" id="quickedit<?=$r['id'];?>"></div>
            <?php }?>
          </section>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
  <?php }
    if($show=='item')require'core/layout/edit_content.php';
  }
}
