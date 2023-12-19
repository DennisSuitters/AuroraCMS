<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Interface
 * @package    core/layout/interface.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='47'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/settings';?>">Settings</a></li>
                <li class="breadcrumb-item active">Interface</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=($user['options'][7]==1?'<button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs" role="tablist">
          <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
          <label for="tab1-1">General</label>
          <input class="tab-control" id="tab1-5" name="tabs" type="radio">
          <label for="tab1-5">Accessibility</label>
          <input class="tab-control" id="tab1-2" name="tabs" type="radio">
          <label for="tab1-2">Sidebar Menu</label>
          <input class="tab-control" id="tab1-3" name="tabs" type="radio">
          <label for="tab1-3">Widgets</label>
          <input class="tab-control" id="tab1-4" name="tabs" type="radio">
          <label for="tab1-4">Login</label>
          <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
            <div class="form-row">
              <input id="prefGDPR" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="8" type="checkbox"<?=($config['options'][8]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefGDPR">Display GDPR Banner.</label>
            </div>
            <div class="form-row">
              <input id="prefTooltips" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4" type="checkbox"<?=($config['options'][4]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?> onchange="$('body').toggleClass('no-tooltip');">
              <label for="prefTooltips">Enable Tooltips</label>
            </div>

          </div>
          <?php if($user['options'][7]==1){?>
            <div class="tab1-2 border" data-tabid="tab1-2" role="tabpanel">
              <div class="p-3">
                <div class="form-row">
                  <input id="prefmediaOptions3" data-dbid="1" data-dbt="config" data-dbc="mediaOptions" data-dbb="3" type="checkbox"<?=($config['mediaOptions'][3]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
                  <label for="prefmediaOptions3">Sort Sidebar based on Usage.</label>
                </div>
              </div>
              <?php $sm1=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=0 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
              $sm1->execute([':r'=>$user['rank']]);?>
              <div class="sticky-top">
                <div class="row">
                  <article class="card py-2 overflow-visible card-list card-list-header shadow">
                    <div class="row">
                      <div class="col-12 col-md-1 text-center">Icon</div>
                      <div class="col-12 col-md pl-2">Title</div>
                      <div class="col-12 col-md-2 text-center">Available To</div>
                      <div class="col-12 col-md-1 text-center">Active</div>
                      <div class="col-12 col-md-1 text-center">Default</div>
                      <div class="col-12 col-md-1 text-center">Pin</div>
                      <div class="col-12 col-md-2">&nbsp;</div>
                    </div>
                  </article>
                </div>
              </div>
              <div id="sortable">
                <?php while($rm1=$sm1->fetch(PDO::FETCH_ASSOC)){?>
                  <article class="card col-12 zebra m-0 p-0 border-0 overflow-visible card-list item shadow subsortable" id="l_<?=$rm1['id'];?>">
                    <div class="row py-2">
                      <div class="col-12 col-md-1 text-center"><i class="i i-3x"><?=$rm1['icon'];?></i></div>
                      <div class="col-12 col-md pl-2"><?php echo$rm1['title'];?></div>
                      <div class="col-12 col-md-2">
                        <select data-dbid="<?=$rm1['id'];?>" data-dbt="sidebar" data-dbc="rank"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$rm1['id'];?>','sidebar','rank',$(this).val(),'select');">
                          <option value="400"<?=$rm1['rank']==400?' selected':'';?>>Contributor</option>
                          <option value="500"<?=$rm1['rank']==500?' selected':'';?>>Author</option>
                          <option value="600"<?=$rm1['rank']==600?' selected':'';?>>Editor</option>
                          <option value="700"<?=$rm1['rank']==700?' selected':'';?>>Moderator</option>
                          <option value="800"<?=$rm1['rank']==800?' selected':'';?>>Manager</option>
                          <option value="900"<?=$rm1['rank']==900?' selected':'';?>>Administrator</option>
                          <?=$user['rank']==1000?'<option value="1000"'.($rm1['rank']==1000?' selected':'').'>Developer</option>':'';?>
                        </select>
                      </div>
                      <div class="col-12 col-md-1 pt-3 text-center">
                        <?php if($rm1['contentType']!='dashboard'){?>
                          <input id="active<?=$rm1['id'];?>" data-dbid="<?=$rm1['id'];?>" data-dbt="sidebar" data-dbc="active" data-dbb="0" type="checkbox"<?=($rm1['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                        <?php }?>
                      </div>
                      <div class="col-12 col-md-1 pt-3 text-center">
                        <input class="defaultPage" id="default<?=$rm1['id'];?>" data-default="<?=$rm1['view'];?>" type="radio" name="default[]"<?=($config['defaultPage']==$rm1['view']?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      </div>
                      <div class="col-12 col-md-1 pt-3 text-center">
                        <?php if($rm1['contentType']!='dashboard'){?>
                          <input id="pin<?=$rm1['id'];?>" data-dbid="<?=$rm1['id'];?>" data-dbt="sidebar" data-dbc="pin" data-dbb="0" type="checkbox"<?=($rm1['pin']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                        <?php }?>
                      </div>
                      <div class="col-12 col-md-2 pr-2 text-right">
                        <?php if($rm1['contentType']=='dropdown'){?>
                        <button class="sidebardropdownbtn" data-sdid="<?=$rm1['id'];?>" data-tooltip="tooltip" aria-label="Open/Close Dropdown"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>
                        <?php }?>
                        <span class="btn"><i class="i orderhandle">drag</i></span>
                      </div>
                    </div>
                    <?php $sm2=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=:mid ORDER BY `ord` ASC");
                    $sm2->execute([':mid'=>$rm1['id']]);
                    if($sm2->rowCount()>0){?>
                      <div class="row m-0 p-0 d-none" id="sidebardropdown<?=$rm1['id'];?>">
                        <div id="subsortable_<?=$rm1['id'];?>">
                          <?php while($rm2=$sm2->fetch(PDO::FETCH_ASSOC)){?>
                            <article class="item zebra m-0 p-0 py-2 col-12 position-relative" style="position:relative;" id="l_<?=$rm2['id'];?>">
                              <div class="row">
                                <div class="col-12 col-md-1 text-center">
                                  <span class="pr-2 text-muted i-2x">&rdsh;</span>
                                  <i class="i i-3x"><?=$rm2['icon'];?></i>
                                </div>
                                <div class="col-12 col-md pl-2 pt-2">
                                  <?=$rm2['title'];?>
                                </div>
                                <div class="col-12 col-md-2 py-2">
                                  <select data-dbid="<?=$rm2['id'];?>" data-dbt="sidebar" data-dbc="rank"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('<?=$rm2['id'];?>','sidebar','rank',$(this).val(),'select');">
                                    <option value="400"<?=$rm2['rank']==400?' selected':'';?>>Contributor</option>
                                    <option value="500"<?=$rm2['rank']==500?' selected':'';?>>Author</option>
                                    <option value="600"<?=$rm2['rank']==600?' selected':'';?>>Editor</option>
                                    <option value="700"<?=$rm2['rank']==700?' selected':'';?>>Moderator</option>
                                    <option value="800"<?=$rm2['rank']==800?' selected':'';?>>Manager</option>
                                    <option value="900"<?=$rm2['rank']==900?' selected':'';?>>Administrator</option>
                                    <?=$user['rank']==1000?'<option value="1000"'.($rm2['rank']==1000?' selected':'').'>Developer</option>':'';?>
                                  </select>
                                </div>
                                <div class="col-12 col-md-1 pt-3 text-center">
                                  <input id="active<?=$rm2['id'];?>" data-dbid="<?=$rm2['id'];?>" data-dbt="sidebar" data-dbc="active" data-dbb="0" type="checkbox"<?=($rm2['active']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                                </div>
                                <div class="col-12 col-md-1">&nbsp;</div>
                                <div class="col-12 col-md-1 pt-3 text-center">
                                  <input id="pin<?=$rm2['id'];?>" data-dbid="<?=$rm2['id'];?>" data-dbt="sidebar" data-dbc="pin" data-dbb="0" type="checkbox"<?=($rm2['pin']==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                                </div>
                                <div class="col-12 col-md-2 pr-2 pt-2 text-right">
                                  <span class="btn"><i class="i subhandle">drag</i></span>
                                </div>
                              </div>
                            </article>
                          <?php }?>
                          <article class="ghost2 hidden"></article>
                        </div>
                      </div>
                      <?php if($user['options'][1]==1){?>
                        <script>
                          $('#subsortable_<?=$rm1['id'];?>').sortable({
                            items:"article.item",
                            handle:".subhandle",
                            placeholder:".ghost2",
                            helper:fixWidthHelper,
                            axis:"y",
                            update:function(e,ui){
                              var order=$("#subsortable_<?=$rm1['id'];?>").sortable("serialize");
                              $.ajax({
                                type:"POST",
                                dataType:"json",
                                url:"core/reordersidebarsub.php",
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
                <article class="ghost hidden"></article>
                <?php if($user['options'][1]==1){?>
                  <script>
                    $('#sortable').sortable({
                      items:"article.item",
                      handle:'.orderhandle',
                      placeholder:".ghost",
                      helper:fixWidthHelper,
                      axis:"y",
                      update:function(e,ui){
                        var order=$("#sortable").sortable("serialize");
                        $.ajax({
                          type:"POST",
                          dataType:"json",
                          url:"core/reordersidebar.php",
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
                <?php }?>
              </div>
            </div>
            <div class="tab1-3 border" data-tabid="tab1-3" role="tabpanel">
              <div class="sticky-top">
                <div class="row">
                  <article class="card py-2 overflow-visible card-list card-list-header shadow">
                    <div class="row">
                      <div class="col-12 col-md pl-2">Widget</div>
                      <div class="col-12 col-md pl-2">Interface</div>
                      <div class="col-12 col-md-1 text-center">Active</div>
                      <div class="col-12 col-md-1">&nbsp;</div>
                    </div>
                  </article>
                </div>
              </div>
              <?php $sw=$db->prepare("SELECT * FROM `".$prefix."widgets` ORDER BY `ref` ASC, `ord` ASC");
              $sw->execute();
              while($rw=$sw->fetch(PDO::FETCH_ASSOC)){?>
                <article class="card col-12 zebra m-0 p-0 py-2 border-0 overflow-visible card-list item shadow">
                  <div class="row">
                    <div class="col-12 col-md pl-2 py-2">
                      <?=$rw['title'];?>
                    </div>
                    <div class="col-12 col-md pl-2 py-2">
                      <?= ucfirst($rw['ref']);?>
                    </div>
                    <div class="col-12 col-md-1 py-2 text-center">
                      <input id="widget<?=$rw['id'];?>" data-dbid="<?=$rw['id'];?>" data-dbt="widgets" data-dbc="active" data-dbb="0" type="checkbox"<?=$rw['active']==1?' checked aria-checked="true"':' aria-checked="false"';?>>
                    </div>
                    <div class="col-12 col-md-1 text-right pr-2">
                      <?php if($rw['id']==17){?>
                        <button class="widgetdropdownbtn" data-sdid="<?=$rw['id'];?>" data-tooltip="left" aria-label="Open/Close Settings"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>
                      <?php }?>
                    </div>
                  </div>
                  <div class="row m-0 p-0 d-none" id="widgetdropdown<?=$rw['id'];?>">
                    <div class="item zebra m-0 p-2 col-12 position-relative">
                      <?php if($rw['id']==17){?>
                        <label for="geo_weatherAPI">Open Weather API Key</label>
                        <?=($user['options'][7]==1?'<div class="form-text">Visit <a target="_blank" href="https://openweatermap.org/">Open Weather Map</a> for an API Key.</div>':'');?>
                        <div class="form-row">
                          <input class="textinput" id="geo_weatherAPI" data-dbid="1" data-dbt="config" data-dbc="geo_weatherAPI" type="text" value="<?=$config['geo_weatherAPI'];?>"<?=($user['options'][7]==1?' placeholder="Enter an API Key from Open Weather..."':' disabled');?>>
                          <?=($user['options'][7]==1?'<button class="save" id="savegeo_weatherAPI" data-dbid="geo_weatherAPI" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                        </div>
                      <?php }?>
                    </div>
                  </div>
                </article>
              <?php }?>
            </div>
            <div class="tab1-4 p-3 border" data-tabid="tab1-4" role="tabpanel">
              <label id="LoginImage" for="file" class="mt-0">Login Images</label>
              <form target="sp" method="post" action="core/add_loginimages.php">
                <div class="row">
                  <div class="col-2">
                    <label for="limage" class="m-2">Image</label>
                  </div>
                  <div class="col-10">
                    <div class="form-row">
                      <input id="limage" name="li" type="text" value="" placeholder="Image...">
                      <?=($user['options'][1]==1?
                        '<button data-tooltip="tooltip" aria-label="Open Media Manager" onclick="elfinderDialog(`0`,`widgets`,`limage`);return false;"><i class="i">browse-media</i></button>'.
                        ($config['mediaOptions'][0]==1?'<button data-fancybox data-type="ajax" data-src="core/browse_unsplash.php?id=0&t=loginimage" data-tooltip="tooltip" aria-label="Browse Unsplash for Image"><i class="i">social-unsplash</i></button>':'')
                      :'');?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-2">
                    <label for="lit" class="m-2">Title</label>
                  </div>
                  <div class="col-10">
                    <input id="lit" name="lit" type="text" value="" placeholder="Image Title...">
                  </div>
                </div>
                <div class="row">
                  <div class="col-2">
                    <label for="lia" class="m-2">Author Name</label>
                  </div>
                  <div class="col-10">
                    <input id="lia" name="lia" type="text" value="" placeholder="Author Name...">
                  </div>
                </div>
                <div class="row">
                  <div class="col-2">
                    <label for="liau" class="m-2">Author URL</label>
                  </div>
                  <div class="col-10">
                    <input id="liau" name="liau" type="text" value="" placeholder="Author URL...">
                  </div>
                </div>
                <div class="row">
                  <div class="col-2">
                    <label for="lis" class="m-2">Service</label>
                  </div>
                  <div class="col-10">
                    <input id="lis" name="lis" type="text" value="" placeholder="Image Service...">
                  </div>
                </div>
                <div class="row">
                  <div class="col-2">
                    <label for="lisu" class="m-2">Service URL</label>
                  </div>
                  <div class="col-10">
                    <input id="lisu" name="lisu" type="text" value="" placeholder="Image Service URL...">
                  </div>
                </div>
                <div class="text-right">
                  <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                </div>
              </form>
              <section id="loginimages" class="row m-1">
                <?php $sl=$db->prepare("SELECT * FROM `".$prefix."widgets` WHERE `ref`='loginimage' ORDER BY `ord` ASC");
                $sl->execute();
                if($sl->rowCount()>0){
                  while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
                    echo'<div id="li_'.$rl['id'].'" class="card stats gallery col-12 col-sm-3 m-0 border-0"><a data-fancybox="loginimage" href="'.$rl['file'].'"><img src="'.$rl['file'].'" alt="'.$rl['title'].'"></a><div class="btn-group tools">'.($user['options'][1]==1?'<button class="trash" onclick="purge(`'.$rl['id'].'`,`widgets`)" data-tooltip="right" aria-label="Delete"><i class="i">trash</i></button><div class="btn handle" data-tooltip="left" aria-label="Drag to Reorder"><i class="i">drag</i></div>':'').'</div></div>';
                  }
                }?>
              </section>
            </div>
          <?php }?>
          <div class="tab1-5 p-3 border" data-tabid="tab1-5" role="tabpanel">
            <div class="form-row">
              <input id="prefEnablea11y" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="1" type="checkbox"<?=($config['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefEnablea11y">Enable Accessibility Widget</label>
            </div>
            <label for="a11yPosition">Accessibility Widget Position</label>
            <div class="form-row">
              <select id="a11yPosition" data-dbid="1" data-dbt="config" data-dbc="a11yPosition"<?=($user['options'][7]==1?' onchange="update(`1`,`config`,`a11yPosition`,$(this).val(),`select`);"':' disabled');?>>
                <option value="left top"<?=$config['a11yPosition']=='left top'?' selected':'';?>>Top Left</option>
                <option value="right top"<?=$config['a11yPosition']=='right top'?' selected':'';?>>Top Right</option>
                <option value="right bottom"<?=$config['a11yPosition']=='right bottom'?' selected':'';?>>Bottom Right</option>
                <option value="left bottom"<?=$config['a11yPosition']=='left bottom'?' selected':'';?>>Bottom Left</option>
              </select>
            </div>
          </div>
        </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
