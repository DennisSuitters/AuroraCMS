<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages
 * @package    core/layout/pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
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
                  <div class="col-12 col-md-2 text-center">Views</div>
                  <div class="col-12 col-md-1 text-center mx-4">Active</div>
                  <div class="col-12 col-md-2"></div>
                </div>
              </article>
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `mid`=0 AND `menu`!='none' AND `file`!='notification' ORDER BY FIELD(`menu`,'head','footer','account','other'), `ord` ASC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                $seoerrors=0;
                if(strlen($r['seoTitle'])<50||strlen($r['seoTitle'])>70)$seoerrors++;
                if(strlen($r['seoDescription'])<1||strlen($r['seoDescription'])>70)$seoerrors++;
                if($r['cover']!=''){
                  if(strlen($r['fileALT'])<1)$seoerrors++;
                  list($width,$height,$type,$attr)=@getimagesize($r['cover']);
                  if($width==null||$height==null)$seoerrors++;
                }
                if($r['heading']=='')$seoerrors++;
                if(strlen(strip_tags($r['notes']))<100)$seoerrors++;
                preg_match('~<h1>([^{]*)</h1>~i',$r['notes'],$h1);
                if(isset($h1[1]))$seoerrors++;
                preg_match_all('~src="\K[^"]+~',$r['notes'],$imgs);
                if($imgs!=''){
                  foreach($imgs[0] as $img){
                    list($width,$height,$type,$attr)=@getimagesize($img);
                    if($width==null||$height==null){
                      $seoerrors++;
                    }
                  }
                }?>
                <article id="l_<?=$r['id'];?>" class="card zebra m-0 p-0 pt-2 overflow-visible card-list item shadow subsortable<?=($seoerrors>0?' badge" data-badge="There are '.$seoerrors.' SEO issues!':'');?>">
                  <div class="row">
                    <div class="col-12 col-md p-2 pb-0 pt-3">
                      <?php if($user['options'][1]==1){
                        $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=:id");
                        $ss->execute([':id'=>$r['id']]);
                        $rs=$ss->fetch(PDO::FETCH_ASSOC);
                        echo$rs['cnt']>0?'<span class="text-info" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions"><i class="i">lightbulb</i></span>':'';
                      }
                      echo'<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$r['id'].'">'.$r['title'].'</a>'.
                      '<small class="d-block text-muted">Available to '.($r['rank']==0?'<span class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($r['rank']).'">'.ucfirst(rank($r['rank'])).'</span> and above').'</small>';?>
                    </div>
                    <div class="col-2 col-md-1 text-center pt-0 pt-sm-3 small">
                      <div class="d-block d-sm-none"><strong>Menu</strong></div>
                      <?=ucfirst($r['menu']);?>
                    </div>
                    <div class="col-2 col-md-2 text-center pt-0 pt-sm-3">
                      <div class="d-block d-sm-none"><strong>Views</strong></div>
                      <?=$user['options'][1]==1?'<button id="views'.$r['id'].'" class="trash" data-tooltip="tooltip" aria-label="Click to Clear" onclick="$(`#views'.$r['id'].'`).text(`0`);updateButtons(`'.$r['id'].'`,`menu`,`views`,`0`);">'.$r['views'].'</button>':'<span class="badger badge-secondary">'.$r['views'].'</span>';?>
                    </div>
                    <div class="col-2 col-md-1 text-center m-0 m-sm-4 mx-2 mx-sm-4" id="menuactive0<?=$r['id'];?>">
                      <div class="d-block d-sm-none"><strong>Active</strong></div>
                      <?='<input id="active'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').($r['contentType']=='index'?' disabled':'').($user['options'][1]==1?'':' disabled').'>';?>
                    </div>
                    <div class="col-2 col-md-2 pt-3 pr-2 text-right" id="controls_<?=$r['id'];?>">
                      <div class="btn-group" role="group">
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
                          if(strlen($rm['seoTitle'])<50)$seoerrors++;elseif(strlen($rm['seoTitle'])>70)$seoerrors++;
                          if(strlen($rm['seoDescription'])<1)$seoerrors++;elseif(strlen($rm['seoDescription'])>70)$seoerrors++;
                          if($rm['cover']!=''&&strlen($rm['fileALT'])<1)$seoerrors++;
                          if(strlen(strip_tags($rm['notes']))<100)$seoerrors++;
                          preg_match('~<h1>([^{]*)</h1>~i',$rm['notes'],$h1);
                          if(isset($h1[1]))$seoerrors++;
                          if($rm['heading']=='')$seoerrors++;?>
                          <article id="l_<?=$rm['id'];?>" class="card item m-0 p-0 pt-2 border-0 bg-transparent overflow-visible<?=($seoerrors>0?' badge" data-badge="There are '.$seoerrors.' SEO issues!':'');?>">
                            <div class="row">
                              <div class="col-12 col-sm p-2 pb-0 pt-3 align-top">
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
                              <div class="col-1 align-middle text-center m-4">
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
                          </article>
                        <?php }?>
                      </div>
                      <div class="ghost2 hidden"></div>
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
                  }?>
                </article>
              <?php }?>
              <article class="ghost hidden">&nbsp;</article>
              <?php $so=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `menu`='none' AND `contentType`!='notification' ORDER BY `title` ASC");
              $so->execute();
              while($ro=$so->fetch(PDO::FETCH_ASSOC)){
                $seoerrors=0;
                if(strlen($ro['seoTitle'])<50)$seoerrors++;elseif(strlen($ro['seoTitle'])>70)$seoerrors++;
                if(strlen($ro['seoDescription'])<1)$seoerrors++;elseif(strlen($ro['seoDescription'])>70)$seoerrors++;
                if($ro['cover']!=''&&strlen($ro['fileALT'])<1)$seoerrors++;
                if(strlen(strip_tags($ro['notes']))<100)$seoerrors++;
                preg_match('~<h1>([^{]*)</h1>~i',$ro['notes'],$h1);
                if(isset($h1[1]))$seoerrors++;
                if($ro['heading']=='')$seoerrors++;?>
                <article id="<?=$ro['id'];?>" class="card zebra mx-2 mt-2 mb-0 p-0 overflow-visible card-list shadow item<?=($seoerrors>0?' badge" data-badge="There are '.$seoerrors.' SEO isses!':'');?>">
                  <div class="row">
                    <div class="col-12 col-sm p-2 pb-0 pt-3 align-top">
                      <?php if($user['options'][1]==1){
                        $ss=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."suggestions` WHERE `rid`=:id");
                        $ss->execute([':id'=>$ro['id']]);
                        $rs=$ss->fetch(PDO::FETCH_ASSOC);
                        echo$rs['cnt']>0?'<span class="text-info" data-tooltip="tooltip" aria-label="'.$rs['cnt'].' Editing Suggestions"><i class="i">lightbulb</i></span>':'';
                      }
                      echo'<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'">'.$ro['title'].'</a>'.
                      '<small class="d-block text-muted">Available to '.($ro['rank']==0?'<span class="badger badge-secondary">Everyone</span>':'<span class="badger badge-'.rank($ro['rank']).'">'.ucfirst(rank($ro['rank'])).'</span> and above').'</small>';?>
                    </div>
                    <div class="col-2 col-sm-1 align-middle text-center pt-3 small">&nbsp;</div>
                    <div class="col-2 align-middle text-center pt-3">
                      <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Clear" onclick="$(`#views'.$ro['id'].'`).text(`0`);updateButtons(`'.$ro['id'].'`,`menu`,`views`,`0`);"><span id="views'.$ro['id'].'" data-views="views">'.$ro['views'].'</span></button>':'<span class="badger badge-danger">'.$ro['views'].'</span>';?>
                    </div>
                    <div class="col-1 align-middle text-center m-4" id="menuactive0<?=$ro['id'];?>">
                      <?=$ro['contentType']!='index'?'<input id="active'.$ro['id'].'" data-dbid="'.$ro['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0" type="checkbox"'.($ro['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled').'>':'';?>
                    </div>
                    <div class="col-2 align-middle pt-3 pr-2 text-right" id="controls_<?=$ro['id'];?>">
                      <div class="btn-group" role="group">
                        <?='<a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'"'.($user['options'][1]==1?' role="button" data-tooltip="tooltip" aria-label="Edit"':' role="button" data-tooltip="tooltip" aria-label="View"').'">'.($user['options'][1]==1?'<i class="i">edit</i>':'<i class="i">view</i>').'</a>';?>
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
