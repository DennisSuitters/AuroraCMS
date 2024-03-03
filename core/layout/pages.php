<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages
 * @package    core/layout/pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='35'")->execute();
$rank=0;
$show='pages';
if(isset($args[0])&&$args[0]=='add'){
  $ti=time();
  $q=$db->prepare("INSERT IGNORE INTO `".$prefix."menu` (`rank`,`uid`,`mid`,`login_user`,`title`,`seoTitle`,`file`,`contentType`,`schemaType`,`menu`,`active`,`ord`,`eti`) VALUES ('0',:uid,'0',:login_user,:title,'','page','page','Article','other','0',:ord,:eti)");
  $q->execute([
    ':uid'=>$user['id'],
    ':login_user'=>(isset($user['name'])?$user['name']:$user['username']),
    ':title'=>'New Page '.$ti.'',
    ':ord'=>$ti,
    ':eti'=>$ti]);
  $id=$db->lastInsertId();
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;?>
  <script>history.replaceState('','','<?= URL.$settings['system']['admin'].'/pages/edit/'.$args[1];?>');</script>
<?php }
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_pages.php';
else{
  if(isset($args[0])&&$args[0]=='edit')$show='item';
  if($show=='pages'){?>
    <main>
      <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
        <div class="container-fluid">
          <div class="card mt-3 border-0 bg-transparent overflow-visible">
            <div class="card-actions">
              <div class="row">
                <div class="col-12 col-sm">
                  <ol class="breadcrumb m-0 pl-0 pt-0">
                    <li class="breadcrumb-item active">Pages</li>
                  </ol>
                </div>
                <div class="col-12 col-sm-2 text-right">
                  <div class="btn-group d-inline">
                    <?=($user['options'][7]==1?'<a href="'.URL.$settings['system']['admin'].'/pages/settings" role="button" data-tooltip="left" aria-label="Pages Settings"><i class="i">settings</i></a>':'').
                    ($user['options'][0]==1?'<a class="add" href="'.URL.$settings['system']['admin'].'/pages/add" role="button" data-tooltip="left" aria-label="Add Page"><i class="i">add</i></a>':'');?>
                  </div>
                </div>
              </div>
            </div>
            <section class="content overflow-visible list" id="sortable">
              <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header bg-white shadow sticky-top d-none d-sm-block">
                <div class="row">
                  <div class="col-12 col-md pl-2">Page Title</div>
                  <div class="col-12 col-md-1 text-center">Menu</div>
                  <div class="col-12 col-md-1 text-center mx-4">Active</div>
                  <div class="col-12 col-md-2"></div>
                </div>
              </article>
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `mid`=0 AND `menu`!='none' AND `file`!='notification' ORDER BY FIELD(`menu`,'head','footer','account','other'), `ord` ASC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                $seoerrors=0;
                if(strlen((string)$r['seoTitle'])<20||strlen((string)$r['seoTitle'])>70)$seoerrors++;
                if(strlen((string)$r['seoDescription'])<70||strlen((string)$r['seoDescription'])>160)$seoerrors++;
                if($r['cover']!=''){
                  if(strlen((string)$r['fileALT'])<1)$seoerrors++;
                }
                if($r['heading']=='')$seoerrors++;
                if(strlen(strip_tags((string)$r['notes']))<100)$seoerrors++;
                preg_match('~<h1>([^{]*)</h1>~i',(string)$r['notes'],$h1);
                if(isset($h1[1]))$seoerrors++;?>
                <article id="l_<?=$r['id'];?>" class="card zebra m-0 p-0 pt-2 overflow-visible card-list item shadow subsortable<?=($seoerrors>0?' badge" data-badge="There are '.$seoerrors.' SEO issues!':'');?>">
                  <div class="row">
                    <div class="col-12 col-md pt-3 pb-1 pl-2">
                      <?php if($user['options'][1]==1){
                        $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=:id");
                        $ss->execute([':id'=>$r['id']]);
                        $rs=$ss->fetch(PDO::FETCH_ASSOC);
                        echo$rs['cnt']>0?'<span class="text-info" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions"><i class="i">lightbulb</i></span>':'';
                      }
                      echo'<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'">'.$r['title'].'</a>'.
                      '<small class="d-block text-muted">Available to '.($r['rank']==0?'<span class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($r['rank']).'">'.ucfirst(rank((string)$r['rank'])).'</span> and above').'</small>';?>
                    </div>
                    <div class="col-2 col-md-1 text-center pt-0 pt-sm-3 small">
                      <div class="d-block d-sm-none"><strong>Menu</strong></div>
                      <?=ucfirst((string)$r['menu']);?>
                    </div>
                    <div class="col-2 col-md-1 text-center m-0 mt-sm-4 mx-2 mx-sm-4" id="menuactive0<?=$r['id'];?>">
                      <div class="d-block d-sm-none"><strong>Active</strong></div>
                      <?='<input id="active'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($r['contentType']=='index'?' disabled':'').($user['options'][1]==1?'':' disabled').'>';?>
                    </div>
                    <div class="col-2 col-md-2 pt-3 pr-2 text-right" id="controls_<?=$r['id'];?>">
                      <div class="btn-group d-inline" role="group">
                        <?=($r['active']==1?'<button data-social-share="'.URL.($r['contentType']=='index'?'':$r['contentType'].($r['contentType']=='page'?'/'.strtolower(str_replace(' ','-',$r['title'])):'').'/').'" data-social-desc="'.($r['seoDescription']?$r['seoDescription']:$r['title']).'" data-tooltip="tooltip" aria-label="Share on Social Media"><i class="i">share</i></button>':'').
                        '<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'"'.($user['options'][1]==1?' role="button" data-tooltip="tooltip" aria-label="Edit"':' role="button" data-tooltip="tooltip" aria-label="View"').'">'.($user['options'][1]==1?'<i class="i">edit</i>':'<i class="i">view</i>').'</a>'.($user['options'][0]==1&&$r['contentType']=='page'?'<button class="purge" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$r['id'].'\',\'menu\');"><i class="i">trash</i></button>':'').
                        ($user['options'][1]==1?'<span class="btn orderhandle"><i class="i">drag</i></span>':'');?>
                      </div>
                    </div>
                    <?php $sm=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `mid`=:mid ORDER BY `ord` ASC");
                    $sm->execute([':mid'=>$r['id']]);
                    if($sm->rowCount()>0){?>
                      <div id="subsortable_<?=$r['id'];?>">
                        <?php while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                          $seoerrors=0;
                          if(strlen($rm['seoTitle'])<20)$seoerrors++;elseif(strlen($rm['seoTitle'])>70)$seoerrors++;
                          if(strlen($rm['seoDescription'])<70)$seoerrors++;elseif(strlen($rm['seoDescription'])>160)$seoerrors++;
                          if($rm['cover']!=''&&strlen($rm['fileALT'])<1)$seoerrors++;
                          if(strlen(strip_tags($rm['notes']))<100)$seoerrors++;
                          preg_match('~<h1>([^{]*)</h1>~i',$rm['notes'],$h1);
                          if(isset($h1[1]))$seoerrors++;
                          if($rm['heading']=='')$seoerrors++;?>
                          <article id="l_<?=$rm['id'];?>" class="card item m-0 p-0 pt-2 border-0 bg-transparent overflow-visible<?=($seoerrors>0?' badge" data-badge="There are '.$seoerrors.' SEO issues!':'');?>">
                            <div class="row">
                              <div class="col-12 col-sm pt-3 pb-1 pl-2 align-top">
                                <span class="pr-2 text-center text-muted i-2x">&rdsh;</span>
                                <?php if($user['options'][1]==1){
                                  $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=:id");
                                  $ss->execute([':id'=>$rm['id']]);
                                  $rs=$ss->fetch(PDO::FETCH_ASSOC);
                                  echo$rs['cnt']>0?'<span class="text-info" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions"><i class="i">lightbulb</i></span>':'';
                                }
                                echo'<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'].'">'.$rm['title'].'</a>'.
                                '<small class="d-block text-muted">Available to '.($rm['rank']==0?'<spam class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($rm['rank']).'">'.ucfirst(rank($rm['rank'])).'</span> and above').'</small>';?>
                              </div>
                              <div class="col-1">&nbsp;</div>
                              <div class="col-2 align-middle text-center pt-3">
                                <?=$user['options'][0]==1?'<button class="trash align-top" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views'.$rm['id'].'`).text(`0`);update(`'.$rm['id'].'`,`menu`,`views`,`0`);"><span id="views'.$rm['id'].'">'.$rm['views'].'</span></button>':$rm['views'];?>
                              </div>
                              <div class="col-1 align-middle text-center m-0 mt-sm-4 mx-2 mx-sm-4" id="menuactive0<?=$rm['id'];?>">
                                <?=$r['contentType']!='index'?'<input id="active'.$rm['id'].'" data-dbid="'.$rm['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($rm['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled').'>':'';?>
                              </div>
                              <div class="col-2 align-middle pt-3 pr-2 text-right" id="controls_<?=$rm['id'];?>">
                                <div class="btn-group" role="group">
                                  <?php echo$user['options'][1]==1?'<a role="button" data-tooltip="tooltip" aria-label="Edit" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'].'"><i class="i">edit</i></a>':'<a role="button" data-tooltip="tooltip" aria-label="View" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'].'"><i class="i">view</i>';
                                  echo$user['options'][0]==1&&$rm['contentType']=='page'?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$rm['id'].'\',\'menu\');"><i class="i">trash</i></button>':'';?>
                                  <span class="btn subhandle"><i class="i">drag</i></span>
                                </div>
                              </div>
                            </div>
                            <?php if($config['options'][11]==1){
                              echo'<div class="row m-0 p-0 pb-2">';
                                $week1start=strtotime("last sunday midnight this week");
                                $week1end=strtotime("saturday this week");
                                $sv=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='page' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                                $sv->execute([
                                  ':rid'=>$r['id'],
                                  ':ti1'=>$week1start,
                                  ':ti2'=>$week1end
                                ]);
                                $rv=$sv->fetch(PDO::FETCH_ASSOC);
                                $prevweek=strtotime("-1 week +1 day",$ti);
                                $week2start=strtotime("last sunday midnight",$prevweek);
                                $week2end=strtotime("next saturday",$week2start);
                                $sv2=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='page' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                                $sv2->execute([
                                  ':rid'=>$r['id'],
                                  ':ti1'=>$week2start,
                                  ':ti2'=>$week2end
                                ]);
                                $rv2=$sv2->fetch(PDO::FETCH_ASSOC);
                                echo($rv['direct']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Direct"><i class="i i-2x">browser-general</i><span class="count px-1">'.short_number($rv['direct']).'</span>'.($rv2['direct']>0?($rv['direct']<$rv2['direct']?'<small class="text-danger">&darr;'.short_number($rv2['direct'] - $rv['direct']).'</small>':'').($rv2['direct']<$rv['direct']?'<small class="text-success">&uarr;'.short_number($rv['direct'] - $rv2['direct']).'</small>':''):'').'</div>':'').
                                ($rv['google']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Google"><i class="i i-social social-google i-2x">social-google</i><span class="count px-1">'.short_number($rv['google']).'</span>'.($rv2['google']>0?($rv['google']<$rv2['google']?'<small class="text-danger">&darr;'.short_number($rv2['google'] - $rv['google']).'</small>':'').($rv2['google']<$rv['google']?'<small class="text-success">&uarr;'.short_number($rv['google'] - $rv2['google']).'</small>':''):'').'</div>':'').
                                ($rv['duckduckgo']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Duck Duck Go"><i class="i i-2x i-social social-duckduckgo">social-duckduckgo</i><span class="count px-1">'.short_number($rv['duckduckgo']).'</span>'.($rv2['duckduckgo']>0?($rv['duckduckgo']<$rv2['duckduckgo']?'<small class="text-danger">&darr;'.short_number($rv2['duckduckgo'] - $rv['duckduckgo']).'</small>':'').($rv2['duckduckgo']<$rv['duckduckgo']?'<small class="text-success">&uarr;'.short_number($rv['duckduckgo'] - $rv2['duckduckgo']).'</small>':''):'').'</div>':'').
                                ($rv['bing']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Bing"><i class="i i-2x i-social social-bing">social-bing</i><span class="count px-1">'.short_number($rv['bing']).'</span>'.($rv2['bing']>0?($rv['bing']<$rv2['bing']?'<small class="text-danger">&darr;'.short_number($rv2['bing'] - $rv['bing']).'</small>':'').($rv2['bing']<$rv['bing']?'<small class="text-success">&uarr;'.short_number($rv['bing'] - $rv2['bing']).'</small>':''):'').'</div>':'').
                                ($rv['reddit']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Reddit"><i class="i i-2x i-social social-reddit">social-reddit</i><span class="count px-1">'.short_number($rv['reddit']).'</span>'.($rv2['reddit']>0?($rv['reddit']<$rv2['reddit']?'<small class="text-danger">&darr;'.short_number($rv2['reddit'] - $rv['reddit']).'</small>':'').($rv2['reddit']<$rv['reddit']?'<small class="text-success">&uarr;'.short_number($rv['reddit'] - $rv2['reddit']).'</small>':''):'').'</div>':'').
                                ($rv['facebook']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Facebook"><i class="i i-2x i-social social-facebook">social-facebook</i><span class="count px-1">'.short_number($rv['facebook']).'</span>'.($rv2['facebook']>0?($rv['facebook']<$rv2['facebook']?'<small class="text-danger">&darr;'.short_number($rv2['facebook'] - $rv['facebook']).'</small>':'').($rv2['facebook']<$rv['facebook']?'<small class="text-success">&uarr;'.short_number($rv['facebook'] - $rv2['facebook']).'</small>':''):'').'</div>':'').
                                ($rv['threads']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Threads"><i class="i i-2x i-social social-threads">social-threads</i><span class="count px-1">'.short_number($rv['threads']).'</span>'.($rv2['threads']>0?($rv['threads']<$rv2['threads']?'<small class="text-danger">&darr;'.short_number($rv2['threads'] - $rv['threads']).'</small>':'').($rv2['threads']<$rv['threads']?'<small class="text-success">&uarr;'.short_number($rv['threads'] - $rv2['threads']).'</small>':''):'').'</div>':'').
                                ($rv['instagram']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Instagram"><i class="i i-2x i-social social-instagram">social-instagram</i><span class="count px-1">'.short_number($rv['instagram']).'</span>'.($rv2['instagram']>0?($rv['instagram']<$rv2['instagram']?'<small class="text-danger">&darr;'.short_number($rv2['instagram'] - $rv['instagram']).'</small>':'').($rv2['instagram']<$rv['instagram']?'<small class="text-success">&uarr;'.short_number($rv['instagram'] - $rv2['instagram']).'</small>':''):'').'</div>':'').
                                ($rv['twitter']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Twitter"><i class="i i-2x i-social social-twitter">social-twitter</i><span class="count px-1">'.short_number($rv['twitter']).'</span>'.($rv2['twitter']>0?($rv['twitter']<$rv2['twitter']?'<small class="text-danger">&darr;'.short_number($rv2['twitter'] - $rv['twitter']).'</small>':'').($rv2['twitter']<$rv['twitter']?'<small class="text-success">&uarr;'.short_number($rv['twitter'] - $rv2['twitter']).'</small>':''):'').'</div>':'').
                                ($rv['linkedin']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Linkedin"><i class="i i-2x i-social social-linkedin">social-linkedin</i><span class="count px-1">'.short_number($rv['linkedin']).'</span>'.($rv2['linkedin']>0?($rv['linkedin']<$rv2['linkedin']?'<small class="text-danger">&darr;'.short_number($rv2['linkedin'] - $rv['linkedin']).'</small>':'').($rv2['linkedin']<$rv['linkedin']?'<small class="text-success">&uarr;'.short_number($rv['linkedin'] - $rv2['linkedin']).'</small>':''):'').'</div>':'').
                              '</div>';
                            }?>
                          </article>
                        <?php }?>
                      </div>
                      <div class="ghost2 hidden"></div>
                    </div>
                  </div>
                  <?php if($user['options'][1]==1){?>
                    <script>
                      $('#subsortable_<?=$r['id'];?>').sortable({
                        items:"article.item",
                        handle:".subhandle",
                        placeholder:".ghost2",
                        helper:fixWidthHelper,
                        axis:"y",
                        update:function(e,ui){
                          var order=$("#subsortable_<?=$r['id'];?>").sortable("serialize");
                          $.ajax({
                            type:"POST",
                            dataType:"json",
                            url:"core/reordersub.php",
                            data:order
                          });
                        }
                      }).disableSelection();
                      function fixWidthHelper(e,ui){
                        ui.children().each(function(){
                          $(this).width($(this).width());
                        });
                        return ui;
                      }
                    </script>
                  <?php }
                  }
                  if($config['options'][11]==1){
                    echo'<div class="row m-0 p-0 pb-2">';
                      $week1start=strtotime("last sunday midnight this week");
                      $week1end=strtotime("saturday this week");
                      $sv=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='page' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                      $sv->execute([
                        ':rid'=>$r['id'],
                        ':ti1'=>$week1start,
                        ':ti2'=>$week1end
                      ]);
                      $rv=$sv->fetch(PDO::FETCH_ASSOC);
                      $prevweek=strtotime("-1 week +1 day",$ti);
                      $week2start=strtotime("last sunday midnight",$prevweek);
                      $week2end=strtotime("next saturday",$week2start);
                      $sv2=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='page' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                      $sv2->execute([
                        ':rid'=>$r['id'],
                        ':ti1'=>$week2start,
                        ':ti2'=>$week2end
                      ]);
                      $rv2=$sv2->fetch(PDO::FETCH_ASSOC);
                      echo($rv['direct']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Direct"><i class="i i-2x">browser-general</i><span class="count px-1">'.short_number($rv['direct']).'</span>'.($rv2['direct']>0?($rv['direct']<$rv2['direct']?'<small class="text-danger">&darr;'.short_number($rv2['direct'] - $rv['direct']).'</small>':'').($rv2['direct']<$rv['direct']?'<small class="text-success">&uarr;'.short_number($rv['direct'] - $rv2['direct']).'</small>':''):'').'</div>':'').
                      ($rv['google']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Google"><i class="i i-social social-google i-2x">social-google</i><span class="count px-1">'.short_number($rv['google']).'</span>'.($rv2['google']>0?($rv['google']<$rv2['google']?'<small class="text-danger">&darr;'.short_number($rv2['google'] - $rv['google']).'</small>':'').($rv2['google']<$rv['google']?'<small class="text-success">&uarr;'.short_number($rv['google'] - $rv2['google']).'</small>':''):'').'</div>':'').
                      ($rv['duckduckgo']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Duck Duck Go"><i class="i i-2x i-social social-duckduckgo">social-duckduckgo</i><span class="count px-1">'.short_number($rv['duckduckgo']).'</span>'.($rv2['duckduckgo']>0?($rv['duckduckgo']<$rv2['duckduckgo']?'<small class="text-danger">&darr;'.short_number($rv2['duckduckgo'] - $rv['duckduckgo']).'</small>':'').($rv2['duckduckgo']<$rv['duckduckgo']?'<small class="text-success">&uarr;'.short_number($rv['duckduckgo'] - $rv2['duckduckgo']).'</small>':''):'').'</div>':'').
                      ($rv['bing']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Bing"><i class="i i-2x i-social social-bing">social-bing</i><span class="count px-1">'.short_number($rv['bing']).'</span>'.($rv2['bing']>0?($rv['bing']<$rv2['bing']?'<small class="text-danger">&darr;'.short_number($rv2['bing'] - $rv['bing']).'</small>':'').($rv2['bing']<$rv['bing']?'<small class="text-success">&uarr;'.short_number($rv['bing'] - $rv2['bing']).'</small>':''):'').'</div>':'').
                      ($rv['reddit']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Reddit"><i class="i i-2x i-social social-reddit">social-reddit</i><span class="count px-1">'.short_number($rv['reddit']).'</span>'.($rv2['reddit']>0?($rv['reddit']<$rv2['reddit']?'<small class="text-danger">&darr;'.short_number($rv2['reddit'] - $rv['reddit']).'</small>':'').($rv2['reddit']<$rv['reddit']?'<small class="text-success">&uarr;'.short_number($rv['reddit'] - $rv2['reddit']).'</small>':''):'').'</div>':'').
                      ($rv['facebook']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Facebook"><i class="i i-2x i-social social-facebook">social-facebook</i><span class="count px-1">'.short_number($rv['facebook']).'</span>'.($rv2['facebook']>0?($rv['facebook']<$rv2['facebook']?'<small class="text-danger">&darr;'.short_number($rv2['facebook'] - $rv['facebook']).'</small>':'').($rv2['facebook']<$rv['facebook']?'<small class="text-success">&uarr;'.short_number($rv['facebook'] - $rv2['facebook']).'</small>':''):'').'</div>':'').
                      ($rv['threads']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Threads"><i class="i i-2x i-social social-threads">social-threads</i><span class="count px-1">'.short_number($rv['threads']).'</span>'.($rv2['threads']>0?($rv['threads']<$rv2['threads']?'<small class="text-danger">&darr;'.short_number($rv2['threads'] - $rv['threads']).'</small>':'').($rv2['threads']<$rv['threads']?'<small class="text-success">&uarr;'.short_number($rv['threads'] - $rv2['threads']).'</small>':''):'').'</div>':'').
                      ($rv['instagram']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Instagram"><i class="i i-2x i-social social-instagram">social-instagram</i><span class="count px-1">'.short_number($rv['instagram']).'</span>'.($rv2['instagram']>0?($rv['instagram']<$rv2['instagram']?'<small class="text-danger">&darr;'.short_number($rv2['instagram'] - $rv['instagram']).'</small>':'').($rv2['instagram']<$rv['instagram']?'<small class="text-success">&uarr;'.short_number($rv['instagram'] - $rv2['instagram']).'</small>':''):'').'</div>':'').
                      ($rv['twitter']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Twitter"><i class="i i-2x i-social social-twitter">social-twitter</i><span class="count px-1">'.short_number($rv['twitter']).'</span>'.($rv2['twitter']>0?($rv['twitter']<$rv2['twitter']?'<small class="text-danger">&darr;'.short_number($rv2['twitter'] - $rv['twitter']).'</small>':'').($rv2['twitter']<$rv['twitter']?'<small class="text-success">&uarr;'.short_number($rv['twitter'] - $rv2['twitter']).'</small>':''):'').'</div>':'').
                      ($rv['linkedin']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Linkedin"><i class="i i-2x i-social social-linkedin">social-linkedin</i><span class="count px-1">'.short_number($rv['linkedin']).'</span>'.($rv2['linkedin']>0?($rv['linkedin']<$rv2['linkedin']?'<small class="text-danger">&darr;'.short_number($rv2['linkedin'] - $rv['linkedin']).'</small>':'').($rv2['linkedin']<$rv['linkedin']?'<small class="text-success">&uarr;'.short_number($rv['linkedin'] - $rv2['linkedin']).'</small>':''):'').'</div>':'').
                    '</div>';
                  }?>
                </article>
              <?php }?>
              <article class="ghost hidden">&nbsp;</article>
              <?php $so=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `menu`='none' AND `contentType`!='notification' ORDER BY `title` ASC");
              $so->execute();
              while($ro=$so->fetch(PDO::FETCH_ASSOC)){
                $seoerrors=0;
                if(strlen($ro['seoTitle'])<20)$seoerrors++;elseif(strlen($ro['seoTitle'])>70)$seoerrors++;
                if(strlen($ro['seoDescription'])<70)$seoerrors++;elseif(strlen($ro['seoDescription'])>160)$seoerrors++;
                if($ro['cover']!=''&&strlen($ro['fileALT'])<1)$seoerrors++;
                if(strlen(strip_tags($ro['notes']))<100)$seoerrors++;
                preg_match('~<h1>([^{]*)</h1>~i',$ro['notes'],$h1);
                if(isset($h1[1]))$seoerrors++;
                if($ro['heading']=='')$seoerrors++;?>
                <article id="<?=$ro['id'];?>" class="card zebra m-0 p-0 pt-2 overflow-visible card-list shadow item<?=($seoerrors>0?' badge" data-badge="There are '.$seoerrors.' SEO isses!':'');?>">
                  <div class="row">
                    <div class="col-12 col-md p-2 pb-0 pt-3">
                      <?php if($user['options'][1]==1){
                        $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=:id");
                        $ss->execute([':id'=>$ro['id']]);
                        $rs=$ss->fetch(PDO::FETCH_ASSOC);
                        echo$rs['cnt']>0?'<span class="text-info" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions"><i class="i">lightbulb</i></span>':'';
                      }
                      echo'<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'">'.$ro['title'].'</a>'.
                      '<small class="d-block text-muted">Available to '.($ro['rank']==0?'<span class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($ro['rank']).'">'.ucfirst(rank($ro['rank'])).'</span> and above').'</small>';?>
                    </div>
                    <div class="col-2 col-md-1 text-center pt-0 pt-sm-3 small">&nbsp;</div>
                    <div class="col-2 col-md-1 text-center m-0 mt-sm-4 mx-2 mx-sm-4" id="menuactive0<?=$ro['id'];?>">
                      <?=$ro['contentType']!='index'?'<input id="active'.$ro['id'].'" data-dbid="'.$ro['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($ro['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled').'>':'';?>
                    </div>
                    <div class="col-2 col-md-2 pt-3 pr-2 text-right" id="controls_<?=$ro['id'];?>">
                      <div class="btn-group d-inline" role="group">
                        <?='<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'"'.($user['options'][1]==1?' role="button" data-tooltip="tooltip" aria-label="Edit"':' role="button" data-tooltip="tooltip" aria-label="View"').'">'.($user['options'][1]==1?'<i class="i">edit</i>':'<i class="i">view</i>').'</a>';?>
                      </div>
                    </div>
                  </div>
                  <?php if($config['options'][11]==1){
                    echo'<div class="row m-0 p-0 pb-2">';
                      $week1start=strtotime("last sunday midnight this week");
                      $week1end=strtotime("saturday this week");
                      $sv=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='page' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                      $sv->execute([
                        ':rid'=>$ro['id'],
                        ':ti1'=>$week1start,
                        ':ti2'=>$week1end
                      ]);
                      $rv=$sv->fetch(PDO::FETCH_ASSOC);
                      $prevweek=strtotime("-1 week +1 day",$ti);
                      $week2start=strtotime("last sunday midnight",$prevweek);
                      $week2end=strtotime("next saturday",$week2start);
                      $sv2=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `type`='page' AND `rid`=:rid AND `ti` >=:ti1 AND `ti` <= :ti2");
                      $sv2->execute([
                        ':rid'=>$ro['id'],
                        ':ti1'=>$week2start,
                        ':ti2'=>$week2end
                      ]);
                      $rv2=$sv2->fetch(PDO::FETCH_ASSOC);
                      echo($rv['direct']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Direct"><i class="i i-2x">browser-general</i><span class="count px-1">'.short_number($rv['direct']).'</span>'.($rv2['direct']>0?($rv['direct']<$rv2['direct']?'<small class="text-danger">&darr;'.short_number($rv2['direct'] - $rv['direct']).'</small>':'').($rv2['direct']<$rv['direct']?'<small class="text-success">&uarr;'.short_number($rv['direct'] - $rv2['direct']).'</small>':''):'').'</div>':'').
                      ($rv['google']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Google"><i class="i i-social social-google i-2x">social-google</i><span class="count px-1">'.short_number($rv['google']).'</span>'.($rv2['google']>0?($rv['google']<$rv2['google']?'<small class="text-danger">&darr;'.short_number($rv2['google'] - $rv['google']).'</small>':'').($rv2['google']<$rv['google']?'<small class="text-success">&uarr;'.short_number($rv['google'] - $rv2['google']).'</small>':''):'').'</div>':'').
                      ($rv['duckduckgo']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Duck Duck Go"><i class="i i-2x i-social social-duckduckgo">social-duckduckgo</i><span class="count px-1">'.short_number($rv['duckduckgo']).'</span>'.($rv2['duckduckgo']>0?($rv['duckduckgo']<$rv2['duckduckgo']?'<small class="text-danger">&darr;'.short_number($rv2['duckduckgo'] - $rv['duckduckgo']).'</small>':'').($rv2['duckduckgo']<$rv['duckduckgo']?'<small class="text-success">&uarr;'.short_number($rv['duckduckgo'] - $rv2['duckduckgo']).'</small>':''):'').'</div>':'').
                      ($rv['bing']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Bing"><i class="i i-2x i-social social-bing">social-bing</i><span class="count px-1">'.short_number($rv['bing']).'</span>'.($rv2['bing']>0?($rv['bing']<$rv2['bing']?'<small class="text-danger">&darr;'.short_number($rv2['bing'] - $rv['bing']).'</small>':'').($rv2['bing']<$rv['bing']?'<small class="text-success">&uarr;'.short_number($rv['bing'] - $rv2['bing']).'</small>':''):'').'</div>':'').
                      ($rv['reddit']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Reddit"><i class="i i-2x i-social social-reddit">social-reddit</i><span class="count px-1">'.short_number($rv['reddit']).'</span>'.($rv2['reddit']>0?($rv['reddit']<$rv2['reddit']?'<small class="text-danger">&darr;'.short_number($rv2['reddit'] - $rv['reddit']).'</small>':'').($rv2['reddit']<$rv['reddit']?'<small class="text-success">&uarr;'.short_number($rv['reddit'] - $rv2['reddit']).'</small>':''):'').'</div>':'').
                      ($rv['facebook']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Facebook"><i class="i i-2x i-social social-facebook">social-facebook</i><span class="count px-1">'.short_number($rv['facebook']).'</span>'.($rv2['facebook']>0?($rv['facebook']<$rv2['facebook']?'<small class="text-danger">&darr;'.short_number($rv2['facebook'] - $rv['facebook']).'</small>':'').($rv2['facebook']<$rv['facebook']?'<small class="text-success">&uarr;'.short_number($rv['facebook'] - $rv2['facebook']).'</small>':''):'').'</div>':'').
                      ($rv['threads']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Threads"><i class="i i-2x i-social social-threads">social-threads</i><span class="count px-1">'.short_number($rv['threads']).'</span>'.($rv2['threads']>0?($rv['threads']<$rv2['threads']?'<small class="text-danger">&darr;'.short_number($rv2['threads'] - $rv['threads']).'</small>':'').($rv2['threads']<$rv['threads']?'<small class="text-success">&uarr;'.short_number($rv['threads'] - $rv2['threads']).'</small>':''):'').'</div>':'').
                      ($rv['instagram']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Instagram"><i class="i i-2x i-social social-instagram">social-instagram</i><span class="count px-1">'.short_number($rv['instagram']).'</span>'.($rv2['instagram']>0?($rv['instagram']<$rv2['instagram']?'<small class="text-danger">&darr;'.short_number($rv2['instagram'] - $rv['instagram']).'</small>':'').($rv2['instagram']<$rv['instagram']?'<small class="text-success">&uarr;'.short_number($rv['instagram'] - $rv2['instagram']).'</small>':''):'').'</div>':'').
                      ($rv['twitter']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Twitter"><i class="i i-2x i-social social-twitter">social-twitter</i><span class="count px-1">'.short_number($rv['twitter']).'</span>'.($rv2['twitter']>0?($rv['twitter']<$rv2['twitter']?'<small class="text-danger">&darr;'.short_number($rv2['twitter'] - $rv['twitter']).'</small>':'').($rv2['twitter']<$rv['twitter']?'<small class="text-success">&uarr;'.short_number($rv['twitter'] - $rv2['twitter']).'</small>':''):'').'</div>':'').
                      ($rv['linkedin']>0?'<div class="col-1 text-center" data-tooltip="tooltip" aria-label="Linkedin"><i class="i i-2x i-social social-linkedin">social-linkedin</i><span class="count px-1">'.short_number($rv['linkedin']).'</span>'.($rv2['linkedin']>0?($rv['linkedin']<$rv2['linkedin']?'<small class="text-danger">&darr;'.short_number($rv2['linkedin'] - $rv['linkedin']).'</small>':'').($rv2['linkedin']<$rv['linkedin']?'<small class="text-success">&uarr;'.short_number($rv['linkedin'] - $rv2['linkedin']).'</small>':''):'').'</div>':'').
                    '</div>';
                  }?>
                </article>
              <?php }?>
            </section>
          </div>
          <?php require'core/layout/footer.php';?>
        </div>
      </section>
    </main>
    <?php if($user['options'][1]==1){?>
      <script>
        $('#sortable').sortable({
          items:".item",
          handle:'.orderhandle',
          placeholder:".ghost",
          helper:fixWidthHelper,
          axis:"y",
          update:function(e,ui){
            var order=$("#sortable").sortable("serialize");
            $.ajax({
              type:"POST",
              dataType:"json",
              url:"core/reorderpages.php",
              data:order
            });
          }
        }).disableSelection();
        function fixWidthHelper(e,ui){
          ui.children().each(function(){
            $(this).width($(this).width());
          });
          return ui;
        }
      </script>
    <?php }
    }
  }
  if($show=='item')require'core/layout/edit_pages.php';
