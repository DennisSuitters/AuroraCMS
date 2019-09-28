<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Activity
 * @package    core/layout/pref_activity.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Activity</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a href="#" class="btn btn-ghost-normal trash" onclick="purge('0','logs');return false;" data-tooltip="tooltip" data-placement="left" title="Purge All" aria-label="Purge All"><?php svg('purge');?></a>
        <a href="#" class="btn btn-ghost-normal dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" data-placement="left" title="Show Items" aria-label="Show Items"><?php svg('view');?></a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>">All</a>
<?php $st=$db->query("SELECT DISTINCT action FROM `".$prefix."logs` ORDER BY action ASC");
while($sr=$st->fetch(PDO::FETCH_ASSOC))
  echo'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/preferences/activity/action/'.$sr['action'].'">'.ucfirst($sr['action']).'</a>';?>
        </div>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div id="l_logs" class="row">
      <div class="col">
        <div class="activities card">
          <div class="card-body">
<?php if($config['options']{12}!=1){?>
            <div class="alert alert-info">Administration Activity Tracking is Disabled.</div>
<?php }
$s=$db->prepare("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC");
  $s->execute();
  $i=1;
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $action='';
    if($r['refTable']=='content'){
      $sql=$db->prepare("SELECT * FROM ".$prefix.$r['refTable']." WHERE id=:rid");
      $sql->execute([':rid'=>$r['rid']]);
      $c=$sql->fetch(PDO::FETCH_ASSOC);
    }
    if($r['uid']!=0){
      $su=$db->prepare("SELECT id,username,avatar,gravatar,name,rank FROM `".$prefix."login` WHERE id=:id");
      $su->execute([':id'=>$r['uid']]);
      $u=$su->fetch(PDO::FETCH_ASSOC);
    }else{
      $u=['id'=>0,'username'=>'Anonymous','avatar'=>'','gravatar'=>'','name'=>'Anonymous','rank'=>1000];
    }
    if($r['action']=='create')$action.=' <span class="badge badge-success">Created</span><br>';
    if($r['action']=='update')$action.=' <span class="badge badge-success">Updated</span><br>';
    if($r['action']=='purge')$action.=' <span class="badge badge-danger">Purged</span><br>';
    if(isset($c['title'])&&$c['title']!=''){
      $action.='<strong>Title:</strong> '.$c['title'].'<br>'.($r['action']=='update'?'<strong>Table:</strong> '.$r['refTable'].'<br>':'').'<strong>Column:</strong> '.$r['refColumn'].'<br>'.'<strong>Data:</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>'.'<strong>Changed To:</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
    }
    $action.='<strong>by</strong> '.$u['username'].':'.$u['name'];
    if(isset($u['avatar'])&&$u['avatar']!='')
      $image=file_exists('media'.DS.'avatar'.DS.basename($u['avatar']))?'media'.DS.'avatar'.DS.basename($u['avatar']):NOAVATAR;
    elseif(isset($u['gravatar'])&&$u['gravatar']!='')
      $image=$u['gravatar'];
    else
      $image=NOAVATAR;?>
            <div id="l_<?php echo$r['id'];?>" class="item">
              <div class="row">
                <div class="col-2 date-holder">
                  <div class="icon"><img class="img-circle" src="<?php echo$image;?>" alt="Picture"></div>
                  <div class="date"><?php echo _ago($r['ti']);?></div>
                </div>
                <div class="col-10 content">
                  <h5></h5>
                  <p>
                    <?php echo$action;?>
                  </p>
                  <div class="btn-group float-right">
                    <?php echo$r['action']=='update'?'<button class="btn btn-secondary" onclick="restore(\''.$r['id'].'\');" data-tooltip="tooltip" title="Restore" aria-label="Restore">'.svg2('undo').'</button>':'';?>
                    <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','logs')" data-tooltip="tooltip" title="Purge" aria-label="Purge"><?php svg('trash');?></button>
                  </div>
                </div>
              </div>
            </div>
            <hr>
<?php $i++;
}?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  $(window).scroll(function(){
  	$('.timeline-block').each(function(){
  		if($(this).offset().top<=$(window).scrollTop()+$(window).height()*.75&&$(this).find('.timeline-img').hasClass('hidden')){
  			$(this).find('.timeline-img,.timeline-content').removeClass('hidden').addClass('animated zoomIn');
  		}
  	});
  });
</script>
