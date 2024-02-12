<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Forum
 * @package    core/layout/forum.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='18'")->execute();
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_forum.php';
else{?>
  <main>
    <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
      <div class="container-fluid">
        <div class="card mt-3 bg-transparent border-0 overflow-visible">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item active">Forum</li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group d-inline">
                  <?=$user['options'][7]==1?'<a data-tooltip="left" href="'.URL.$settings['system']['admin'].'/forum/settings" role="button" aria-label="Forum Settings"><i class="i">settings</i></a>':'';?>
                </div>
              </div>
            </div>
          </div>
          <?php if($user['options'][0]==1){?>
            <form class="mt-3" target="sp" method="post" action="core/add_forumdata.php">
              <input name="act" type="hidden" value="category">
              <div class="form-row">
                <div class="input-text">Category</div>
                <input id="t" name="t" placeholder="Enter a Category Title...">
                <div class="input-text">Description</div>
                <input id="da" name="da" placeholder="Enter a Short Description...">
                <div class="input-text">Available to</div>
                <select id="rank" name="rank">
                  <option value="0">Everyone</option>
                  <option value="100">Subscriber and above</option>
                  <option value="200">Member and above</option>
                  <option value="210">Member Silver and above</option>
                  <option value="220">Member Bronze and above</option>
                  <option value="230">Member Gold and above</option>
                  <option value="240">Member Platinum and above</option>
                  <option value="300">Client and above</option>
                  <option value="310">Wholesaler and above</option>
                  <option value="320">Wholesaler Bronze and above</option>
                  <option value="330">Wholesaler Silver and above</option>
                  <option value="340">Wholesaler Gold and above</option>
                  <option value="350">Wholesaler Platinum and above</option>
                  <option value="400">Contributor and above</option>
                  <?=($user['rank']>400?'<option value="500">Author and above</option>':'').
                  ($user['rank']>500?'<option value="600">Editor and above</option>':'').
                  ($user['rank']>600?'<option value="700">Moderator and above</option>':'').
                  ($user['rank']>700?'<option value="800">Manager and above</option>':'').
                  ($user['rank']>800?'<option value="900">Administrator and above</option>':'');?>
                </select>
                <div class="input-text">
                  <label for="help">Help: </label><input id="help" name="help" type="checkbox">
                </div>
                <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
              </div>
            </form>
            <hr>
          <?php }?>
          <div id="cats">
            <?php $sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` ORDER BY `pin` DESC, `ord` ASC, `ti` DESC");
            $sc->execute();
            while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
              $st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `cid`=:cid ORDER BY `pin` DESC, `ord` ASC, `ti` ASC");
              $st->execute([':cid'=>$rc['id']]);?>
              <div class="card item row mb-3" id="cats_<?=$rc['id'];?>">
                <div class="card col-12 border-0">
                  <div class="form-row">
                    <?=($user['options'][1]==1?'<div class="input-text"><i class="i cathandle">drag</i></div>':'');?>
                    <div class="input-text">Category</div>
                    <input class="text-input" id="category<?=$rc['id'];?>" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="title" type="text" value="<?=$rc['title'];?>"<?=($user['options'][1]==1?' placeholder="Enter a Category..."':' disabled');?>>
                    <?=($user['options'][1]==1?'<button class="save" id="savecategory'.$rc['id'].'" data-tooltip="tooltip" data-dbid="category'.$rc['id'].'" aria-label="Save"><i class="i">save</i></button>':'');?>
                    <div class="input-text">Description</div>
                    <input class="text-input" id="notes<?=$rc['id'];?>" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="notes" type="text" value="<?=$rc['notes'];?>"<?=($user['options'][1]==1?' placeholder="Enter a Description..."':' disabled');?>>
                    <?=($user['options'][1]==1?'<button class="save" id="savenotes'.$rc['id'].'" data-tooltip="tooltip" data-dbid="notes'.$rc['id'].'" aria-label="Save"><i class="i">save</i></button>':'');?>
                    <div class="input-text">
                      <label for="help<?=$rc['id'];?>">Help:</label>&nbsp;<input id="help<?=$rc['id'];?>" type="checkbox"<?=$rc['help']==1?' checked':'';?> disabled>
                    </div>
                    <div class="input-text">
                      <label for="pin<?=$rc['id'];?>">Pin:</label>&nbsp;<input id="pin<?=$rc['id'];?>" type="checkbox" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="pin" data-dbb="0"<?=($rc['pin']==1?' checked':'').($user['options'][1]==1?'':' disabled');?>>
                    </div>
                    <?php if($user['options'][1]==1){?>
                      <form target="sp" method="post" action="core/purgeforum.php">
                        <input name="t" type="hidden" value="forumCategory">
                        <input name="id" type="hidden" value="<?=$rc['id'];?>">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delte"><i class="i">trash</i></button>
                      </form>
                    <?php }?>
                  </div>
                  <small class="badger badge-<?= rank($rc['rank']);?>">Available to <?= ucwords(($rc['rank']==0?'everyone':str_replace('-',' ',rank($rc['rank']))));?></small>
                </div>
                <div class="card-body ml-3 mt-3" id="topics_<?=$rc['id'];?>">
                  <?php if($user['options'][0]==1){?>
                    <form target="sp" method="post" action="core/add_forumdata.php">
                      <input name="act" type="hidden" value="topic">
                      <input name="id" type="hidden" value="<?=$rc['id'];?>">
                      <input name="rank" type="hidden" value="<?=$rc['rank'];?>">
                      <input name="help" type="hidden" value="<?=$rc['help'];?>">
                      <div class="form-row">
                        <div class="input-text">Topic</div>
                        <input name="t" placeholder="Enter a Topic Title...">
                        <div class="input-text">Description</div>
                        <input name="da" placeholder="Enter a Short Description...">
                        <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                      </div>
                    </form>
                  <?php }
                  while($rt=$st->fetch(PDO::FETCH_ASSOC)){
                    $sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `tid`=:tid");
                    $sp->execute([':tid'=>$rt['id']]);?>
                    <div class="item row mt-3 bg-white" id="topic_<?=$rt['id'];?>">
                      <div class="card col-12">
                        <div class="form-row">
                          <?=($user['options'][1]==1?'<div class="input-text"><i class="i subhandle">drag</i></div>':'');?>
                          <div class="input-text">Topic</div>
                          <input class="text-input" id="topic<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="title" type="text" value="<?=$rt['title'];?>"<?=($user['options'][1]==1?' placeholder="Enter a Topic..."':' disabled');?>>
                          <?=($user['options'][1]==1?'<button class="save" id="savetopic'.$rt['id'].'" data-tooltip="tooltip" data-dbid="topic'.$rt['id'].'" aria-label="Save"><i class="i">save</i></button>':'');?>
                          <div class="input-text">Description</div>
                          <input class="text-input" id="notes<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="notes" type="text" value="<?=$rt['notes'];?>"<?=($user['options'][1]==1?' placeholder="Enter a Description..."':' disabled');?>>
                          <?=($user['options'][1]==1?'<button class="save" id="savenotes'.$rt['id'].'" data-tooltip="tooltip" data-dbid="notes'.$rt['id'].'" aria-label="Save"><i class="i">save</i></button>':'');?>
                          <div class="input-text">
                            <label for="pin<?=$rt['id'];?>">Pin:</label>&nbsp;<input id="pin<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="pin" data-dbb="0" type="checkbox"<?=($rt['pin']==1?' checked':'').($user['options'][1]==1?'':' disabled');?>>
                          </div>
                          <?php if($user['options'][1]==1){?>
                            <form target="sp" method="post" action="core/purgeforum.php">
                              <input name="t" type="hidden" value="forumTopics">
                              <input name="id" type="hidden" value="<?=$rt['id'];?>">
                              <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                            </form>
                          <?php }?>
                        </div>
                      </div>
                      <div class="ghost2 hidden"></div>
                    </div>
                    <?php if($user['options'][1]==1){?>
                      <script>
                        $('#topics_<?=$rc['id'];?>').sortable({
                          items:"div.item",
                          handle:".subhandle",
                          placeholder:".ghost2",
                          helper:fixWidthHelper,
                          axis:"y",
                          update:function(e,ui){
                            var order=$("#topics_<?=$rc['id'];?>").sortable("serialize");
                            $.ajax({
                              type:"POST",
                              dataType:"json",
                              url:"core/reorderforumtopic.php",
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
                </div>
              </div>
            <?php }?>
          </div>
          <?php if($user['options'][1]==1){?>
            <script>
              $('#cats').sortable({
                items:"div.item",
                handle:'.cathandle',
                placeholder:".ghost",
                helper:fixWidthHelper,
                axis:"y",
                update:function(e,ui){
                  var order=$("#cats").sortable("serialize");
                  $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"core/reorderforumcategory.php",
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
        <?php require'core/layout/footer.php';?>
      </div>
    </section>
  </main>
<?php }
