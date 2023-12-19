<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Agronomy - Edit Livestock
 * @package    core/layout/edit_agronomylivestock.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_agronomy.php';
else{
  $sl=$db->prepare("SELECT * FROM `".$prefix."agronomy_livestock` WHERE `id`=:id");
  $sl->execute([':id'=>$args[1]]);
  $rl=$sl->fetch(PDO::FETCH_ASSOC);?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active"><a href="<?= URL.$settings['system']['admin'].'/agronomy';?>">Agronomy</a></li>
                  <li class="breadcrumb-item active">Edit</i>
                  <li class="breadcrumb-item active breadcrumb-dropdown p-0 pl-3 m-0">
                    <?php $ss=$db->prepare("SELECT `id`,`name`,`species`,`breed` FROM `".$prefix."agronomy_livestock` WHERE `id`!=:id ORDER BY `id` ASC");
                    $ss->execute([':id'=>$rl['id']]);
                    echo$rl['name'].' ('.$rl['species'].':'.$rl['breed'].')'.
                    '<span class="breadcrumb-dropdown mx-2"><i class="i pt-1">chevron-down</i></span>'.
                    '<ol class="breadcrumb-dropper">';
                      while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
                        echo'<li><a href="'.URL.$settings['system']['admin'].'/agronomy/livestock/'.$rs['id'].'">'.$rs['name'].' ('.$rs['species'].':'.$rs['breed'].')</a></li>';
                      }
                    echo'</ol>';
                    $sp=$db->prepare("SELECT `id` AS `prev` FROM `".$prefix."agronomy_livestock` WHERE `id`<:id ORDER BY `id` DESC LIMIT 1");
                    $sp->execute([':id'=>$rl['id']]);
                    $prev=$sp->fetch(PDO::FETCH_ASSOC);
                    $sn=$db->prepare("SELECT `id` AS `next` FROM `".$prefix."agronomy_livestock` WHERE `id`>:id ORDER BY `id` ASC LIMIT 1");
                    $sn->execute([':id'=>$rl['id']]);
                    $next=$sn->fetch(PDO::FETCH_ASSOC);
                    echo'<a class="btn btn-sm btn-ghost"'.($sp->rowCount()>0?' href="'.URL.$settings['system']['admin'].'/agronomy/livestock/'.$prev['prev'].'" data-tooltip="tooltip" aria-label="Go to previous Livestock."':' disabled="true"').'><i class="i'.($sp->rowCount()>0?'':' text-muted').'">arrow-left</i></a>'.
                    '<a class="btn btn-sm btn-ghost"'.($sn->rowCount()>0?' href="'.URL.$settings['system']['admin'].'/agronomy/livestock/'.$next['next'].'" data-tooltip="tooltip" aria-label="Go to next Livestock."':' disabled="true"').'><i class="i'.($sn->rowCount()>0?'':' text-muted').'">arrow-right</i></a>';?>
                  </li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                  ($user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/agronomy/settings" role="button" aria-label="Agronomy Settings"><i class="i">settings</i></a>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">Details</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Activity</label>
<?php /* Details */ ?>
            <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
              <div class="row">
                <div class="col-12 col-sm-6 pr-sm-3">
                  <label for="name" class="mt-0">Name</label>
                  <div class="form-row">
                    <input class="textinput" id="name" data-dbid="<?=$rl['id'];?>" data-dbt="agronomy_livestock" data-dbc="name" type="text" value="<?=$rl['name'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Name..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="savename" data-dbid="name" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="code" class="mt-0">Code</label>
                  <div class="form-row">
                    <input class="textinput" id="code" data-dbid="<?=$rl['id'];?>" data-dbt="agronomy_livestock" data-dbc="code" type="text" value="<?=$rl['code'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Code..."':' readonly';?>>
                    <?=$user['options'][1]==1?'<button class="save" id="savecode" data-dbid="code" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'';?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-sm-3">
                  <label for="type">Species</label>
                  <div class="form-row">
                    <input class="textinput" id="type" list="agronomy_livestock" data-dbid="<?=$rl['id'];?>" data-dbt="agronomy_livestock" data-dbc="species" type="text" value="<?=$rl['species'];?>" readonly>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="type">Breed</label>
                  <div class="form-row">
                    <input class="textinput" id="type" data-dbid="<?=$rl['id'];?>" type="text" value="<?=$rl['breed'];?>" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 pr-sm-3">
                  <label for="mother">Mother</label>
                  <div class="form-row">
                    <select id="mother" data-dbid="<?=$rl['id'];?>" data-dbt="agronomy_livestock" data-dbc="mother"<?=$user['options'][2]==0?' disabled':'';?> onchange="update('<?=$rl['id'];?>','agronomy_livestock','mother',$(this).val(),'select');">
                      <option value="unknown">Unknown</option>
                      <?php $sm=$db->prepare("SELECT `id`,`name`,`code` FROM `".$prefix."agronomy_livestock` WHERE `id`!=:id AND `sex`='f' AND `species`=:species ORDER BY `name` ASC");
                      $sm->execute([
                        ':id'=>$rl['id'],
                        ':species'=>$rl['species']
                      ]);
                      while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
                        echo'<option value="'.$rm['id'].'"'.($rm['id']==$rl['mother']?' selected="selected"':'').'>'.$rm['name'].($rm['code']!=''?' ('.$rm['code'].')':'').'</option>';
                      }?>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-sm-6 pr-sm-3">
                  <label for="father">Father</label>
                  <div class="form-row">
                    <select id="father" data-dbid="<?=$rl['id'];?>" data-dbt="agronomy_livestock" data-dbc="father"<?=$user['options'][2]==0?' disabled':'';?> onchange="update('<?=$rl['id'];?>','agronomy_livestock','father',$(this).val(),'select');">
                      <option value="0"<?=($rl['father']==0?' selected="selected"':'');?>>Unkown</option>
                      <option value="-1"<?=($rl['father']== -1 ?' selected="selected"':'');?>>Artificial Insemination</option>
                      <?php $sf=$db->prepare("SELECT `id`,`name`,`code` FROM `".$prefix."agronomy_livestock` WHERE `id`!=:id AND `sex`='m' AND `species`=:species ORDER BY `name` ASC");
                      $sf->execute([
                        ':id'=>$rl['id'],
                        ':species'=>$rl['species']
                      ]);
                      while($rf=$sf->fetch(PDO::FETCH_ASSOC)){
                        echo'<option value="'.$rf['id'].'"'.($rf['id']==$rl['mother']?' selected="selected"':'').'>'.$rf['name'].($rf['code']!=''?' ('.$rf['code'].')':'').'</option>';
                      }?>
                    </select>
                  </div>
                </div>
              </div>
              <label for="notes">Notes</label>
              <div class="form-row">
                <div class="input-text" data-el="notes" contenteditable="<?=$user['options'][1]==1?'true':'false';?>" data-placeholder="Enter Notes..."><?=$rl['notes'];?></div>
                <input class="textinput d-none" id="notes" data-dbid="<?=$rl['id'];?>" data-dbt="agronomy_livestock" data-dbc="notes" type="text" value="<?=$rl['notes'];?>">
                <button class="save" id="savenotes" data-dbid="notes" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>
              </div>
            </div>
<?php /* Activity */ ?>
            <div class="tab1-2 border" data-tabid="tab1-2" role="tabpanel">
              <div class="row sticky-top">
                <article class="card mb-0 p-0 overflow-visible card-list card-list-header bg-white shadow">
                  <div class="row py-2">
                    <div class="col-12 col-md pl-2">Area</div>
                    <div class="col-12 col-md pl-2">Activity</div>
                    <div class="col-12 col-md pl-2">Medication</div>
                    <div class="col-12 col-md pl-2">Weight</div>
                    <div class="col-12 col-md pl-2">Height</div>
                    <div class="col-12 col-md pl-2">Length</div>
                    <div class="col-12 col-md pl-2">Behaviour</div>
                    <div class="col-12 col-md pl-2">Condition Score</div>
                  </div>
                  <?php if($user['options'][0]==1){?>
                    <form class="m-0 p-0" target="sp" method="post" action="core/add_livestockdata.php">
                      <div class="row">
                        <input name="lid" type="hidden" value="<?=$rl['id'];?>">
                        <div class="col-12 col-md">
                          <select name="aid">
                            <option value="0">Select an Area...</option>
                            <?php $sa=$db->prepare("SELECT `id`,`name` FROM `".$prefix."agronomy_areas` ORDER BY `name` ASC");
                            $sa->execute();
                            while($ra=$sa->fetch(PDO::FETCH_ASSOC)){
                              echo'<option value="'.$ra['id'].'">'.$ra['name'].'</option>';
                            }?>
                          </select>
                        </div>
                        <div class="col-12 col-md">
                          <input type="text" name="activity" value="" placeholder="Activity...">
                        </div>
                        <div class="col-12 col-md">
                          <input type="text" name="med" value="" placeholder="Medication...">
                        </div>
                        <div class="col-12 col-md">
                          <input type="text" name="weight" value="" placeholder="Weight...">
                        </div>
                        <div class="col-12 col-md">
                          <input type="text" name="height" value="" placeholder="Height...">
                        </div>
                        <div class="col-12 col-md">
                          <input type="text" name="length" value="" placeholder="Length...">
                        </div>
                        <div class="col-12 col-md">
                          <input type="text" name="behaviour" value="" placeholder="Behaviour...">
                        </div>
                        <div class="col-12 col-md">
                          <input type="text" name="cs" value="" placeholder="Condition Score...">
                        </div>
                      </div>
                      <div class="row m-0 p-0">
                        <div class="col-12 col-md-3">
                          <input id="lti" name="lti" type="datetime-local" value="<?= date('Y-m-d\TH:i',time());?>" onchange="$(`#ltix`).val(getTimestamp(`lti`));">
                          <input id="ltix" name="ltix" type="hidden" value="<?= time();?>">
                        </div>
                        <div class="col-12 col-md">
                          <div class="form-row">
                            <input type="text" name="notes" value="" placeholder="Notes...">
                            <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">plus</i></button>
                          </div>
                        </div>
                      </div>
                    </form>
                  <?php }?>
                </article>
              </div>
              <div id="agronomy_data">
                <?php $sd=$db->prepare("SELECT * FROM `".$prefix."agronomy_data` WHERE `lid`=:lid ORDER BY `lti` DESC");
                $sd->execute([':lid'=>$rl['id']]);
                while($rd=$sd->fetch(PDO::FETCH_ASSOC)){?>
                  <article id="l_<?=$rd['id'];?>" class="card col-12 zebra mt-2 mb-0 p-2 border-0 overflow-visible shadow">
                    <div class="row">
                      <div class="col-10 pl-2"><?= date($config['dateFormat'],$rd['lti']);?></div>
                      <div class="col-2 mt-0 pt-0">
                        <?='<div class="float-right">'.
                          '<button class="quickeditbtn" data-qeid="'.$rd['id'].'" data-qet="agronomy_data" data-tooltip="left" aria-label="Open/Close Quick Edit Options"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>'.
                        '</div>';?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-md pl-2 pt-1"><?=$rd['area'];?></div>
                      <div class="col-12 col-md pl-2 pt-1"><?=str_replace(',',',<br>',$rd['activity']);?></div>
                      <div class="col-12 col-md pl-2 pt-1"><?=str_replace(',',',<br>',$rd['medication']);?></div>
                      <div class="col-12 col-md pl-2 pt-1"><?=$rd['weight'];?></div>
                      <div class="col-12 col-md pl-2 pt-1"><?=$rd['height'];?></div>
                      <div class="col-12 col-md pl-2 pt-1"><?=$rd['length'];?></div>
                      <div class="col-12 col-md pl-2 pt-1"><?=$rd['behaviour'];?></div>
                      <div class="col-12 col-md pl-2 pt-1"><?=$rd['condition_score'];?></div>
                    </div>
                    <div class="quickedit p-0" id="quickedit<?=$rd['id'];?>"></div>
                  </article>
                <?php }?>
              </div>
            </div>
          </div>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
