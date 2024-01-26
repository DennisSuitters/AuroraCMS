<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Adverts
 * @package    core/layout/adverts.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='62'");
$sv->execute();
$rank=0;
$show='categories';
if($view=='add'){
  $stockStatus='none';
  $ti=time();
  $schema='';
  $comments=0;
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`cid`,`contentType`,`schemaType`,`length`,`status`,`options`,`rank`,`ti`) VALUES (0,'advert','Advertisement','h','unpublished','00000000','0',:ti)");
  $q->execute([':ti'=>$ti]);
  $id=$db->lastInsertId();
  $s=$db->prepare("UPDATE `".$prefix."content` SET `title`=:title WHERE `id`=:id");
  $s->execute([
    ':title'=>'Advertisement '.$id,
    ':id'=>$id
  ]);
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;
  echo'<script>/*<![CDATA[*/window.location.replace("'.URL.$settings['system']['admin'].'/adverts/edit/'.$args[1].'");/*]]>*/</script>';
}
if(isset($args[0])&&$args[0]=='edit'){
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='advert' AND `id`=:id");
  $s->execute([':id'=>$args[1]]);
  $show='item';
}else{
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='advert' ORDER BY `ti` DESC, `title` ASC");
  $s->execute();
}
if($show=='item')
  require'core/layout/edit_adverts.php';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 border-radius-0 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm-6">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active">Adverts</li>
                </ol>
              </div>
              <div class="col-12 col-sm-6 text-right">
                <div class="form-row justify-content-end">
                  <input id="filter-input" type="text" value="" placeholder="Type to Filter Items" onkeyup="filterTextInput();">
                  <div class="btn-group">
                    <?=($user['options'][0]==1?'<a class="add" data-tooltip="left" href="'.URL.$settings['system']['admin'].'/add/adverts" role="button" aria-label="Add Advertisement"><i class="i">add</i></a>':'');?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <section class="content mt-3 overflow-visible list" id="contentview">
            <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <article class="card zebra my-2 overflow-visible card-list" id="l_<?=$r['id'];?>" data-content="advert<?=' '.$r['title'];?>">
                <div class="card-image overflow-visible">
                  <?php if($r['thumb']!=''&&file_exists('media/sm/'.basename($r['thumb'])))
                    echo'<a href="'.URL.$settings['system']['admin'].'/adverts/edit/'.$r['id'].'"><img src="'.$r['thumb'].'" alt="'.$r['title'].'"></a>';
                  elseif($r['file']!=''&&file_exists('media/'.basename($r['file'])))
                    echo'<a href="'.URL.$settings['system']['admin'].'/adverts/edit/'.$r['id'].'"><img src="media/sm/'.basename($r['file']).'" alt="'.$r['title'].'"></a>';
                  elseif($r['fileURL']!='')
                    echo'<a href="'.URL.$settings['system']['admin'].'/adverts/edit/'.$r['id'].'"><img src="'.$r['fileURL'].'" alt="'.$r['title'].'"></a>';
                  else
                    echo'<a href="'.URL.$settings['system']['admin'].'/adverts/edit/'.$r['id'].'"><img src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'"></a>';?>
                  <select class="status <?=$r['status'];?>" onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');$(this).removeClass().addClass('status '+$(this).val());changeShareStatus($(this).val());"<?=$user['options'][0]!=1?' disabled':'';?>>
                    <option class="unpublished" value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                    <option class="autopublish" value="autopublish"<?=$r['status']=='autopublish'?' selected':'';?>>AutoPublish</option>
                    <option class="published" value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                    <option class="delete" value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
                    <option class="archived" value="archived"<?=$r['status']=='archived'?' selected':'';?>>Archived</option>
                  </select>
                  <div class="image-toolbar">
                    <button class="badger badger-primary <?=($r['status']=='published'?'':' d-none');?>" id="share<?=$r['id'];?>" data-social-share="<?= URL.$r['contentType'].'/'.$r['urlSlug'];?>" data-social-desc="<?=$r['seoDescription']?$r['seoDescription']:$r['title'];?>" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>
                  </div>
                </div>
                <div class="card-header overflow-visible mt-0 pt-0 align-middle line-clamp">
                  <a class="d-block" data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'].'/adverts/edit/'.$r['id'];?>" aria-label="Edit <?=$r['title'];?>"><?= $r['thumb']!=''&&file_exists($r['thumb'])?'<img src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                  <?php echo'<small class="text-muted" id="rank'.$r['id'].'">Available to '.($r['rank']==0?'<span class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($r['rank']).' p-0 px-1 text-white">'.ucwords(str_replace('-',' ',rank($r['rank']))).'</span> and above').'</small>';?>
                </div>
                <div class="card-footer">
                  <div class="btn-toolbar float-right" id="controls_<?=$r['id'];?>" role="toolbar">
                    <div class="btn-group" role="group">
                      <span class="code hidewhenempty"><?=$r['code'];?></span>
                      <?=($r['views']>0?($user['options'][0]==1?'<button class="btn views" data-tooltip="tooltip" aria-label="'.$r['views'].' impressions. Click to Clear" onclick="$(`[data-views=\''.$r['id'].'\'`).text(`0`);updateButtons(`'.$r['id'].'`,`content`,`views`,`0`);"><span data-views="'.$r['id'].'">'.$r['views'].'</span>'.($r['quantity']>0?' of '.$r['quantity']:'').' <i class="i">view</i></button>':'<span class="btn" data-tooltip="tooltip" aria-label="'.$r['lti'].' Views">'.$r['lti'].' <i class="i">view</i></span>'):'');?>
                      <span class="btn" data-tooltip="tooltip" aria-label="<?=$r['lti'];?> Clicks"><?=$r['lti'];?> <i class="i">opennew</i></span>
                      <a data-tooltip="tooltip" href="<?= URL.$settings['system']['admin'];?>/adverts/edit/<?=$r['id'];?>" role="button"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><i class="i"><?=$user['options'][1]==1?'edit':'view';?></i></a>
                      <?=($user['options'][0]==1?'<button class="add'.($r['status']!='delete'?' d-none':'').'" id="untrash'.$r['id'].'" data-tooltip="tooltip" aria-label="Restore" onclick="updateButtons(`'.$r['id'].'`,`content`,`status`,`unpublished`);"><i class="i">untrash</i></button><button class="trash'.($r['status']=='delete'?' d-none':'').'" id="delete'.$r['id'].'" data-tooltip="tooltip" aria-label="Delete" onclick="updateButtons(`'.$r['id'].'`,`content`,`status`,`delete`);"><i class="i">trash</i></button><button class="purge'.($r['status']!='delete'?' d-none':'').'" id="purge'.$r['id'].'" data-tooltip="tooltip" aria-label="Purge" onclick="purge(`'.$r['id'].'`,`content`);"><i class="i">purge</i></button>':'');?>
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
