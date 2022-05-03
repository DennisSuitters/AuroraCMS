<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Forum
 * @package    core/layout/forum.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($args[0])&&$args[0]=='settings')require'core/layout/set_forum.php';
else{?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i">forum</i></div>
          <div>Forum</div>
          <div class="content-title-actions">
            <?=$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/forum/settings" role="button" aria-label="Forum Settings"><i class="i">settings</i></a>':'';?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Forum</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <form target="sp" method="post" action="core/add_forumdata.php">
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
              <option value="500">Author and above</option>
              <option value="600">Editor and above</option>
              <option value="700">Moderator and above</option>
              <option value="800">Manager and above</option>
              <option value="900">Administrator and above</option>
            </select>
            <div class="input-text">
              <label for="help">Help: </label><input id="help" name="help" type="checkbox">
            </div>
            <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
          </div>
        </form>
        <hr>
        <div id="cats">
<?php
$sc=$db->prepare("SELECT * FROM `".$prefix."forumCategory` ORDER BY `pin` DESC, `ord` ASC, `ti` DESC");
$sc->execute();
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
  $st=$db->prepare("SELECT * FROM `".$prefix."forumTopics` WHERE `cid`=:cid ORDER BY `pin` DESC, `ord` ASC, `ti` ASC");
  $st->execute([':cid'=>$rc['id']]);?>
          <div class="item row mb-3 border-1 bg-white" id="cats_<?=$rc['id'];?>">
            <div class="card col-12 border-0">
              <div class="form-row">
                <div class="input-text"><i class="i cathandle">drag</i></div>
                <div class="input-text">Category</div>
                <input class="text-input" id="category<?=$rc['id'];?>" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="title" type="text" value="<?=$rc['title'];?>" placeholder="Enter a Category...">
                <button class="save" id="savecategory<?=$rc['id'];?>" data-tooltip="tooltip" data-dbid="category<?=$rc['id'];?>" data-style="zoom-in" aria-label="Save"><i class="i">save</i></button>
                <div class="input-text">Description</div>
                <input class="text-input" id="notes<?=$rc['id'];?>" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="notes" type="text" value="<?=$rc['notes'];?>" placeholder="Enter a Description...">
                <button class="save" id="savenotes<?=$rc['id'];?>" data-tooltip="tooltip" data-dbid="notes<?=$rc['id'];?>" data-style="zoom-in" aria-label="Save"><i class="i">save</i></button>
                <div class="input-text">
                  <label for="help<?=$rc['id'];?>">Help:</label>&nbsp;<input id="help<?=$rc['id'];?>" type="checkbox"<?=$rc['help']==1?' checked':'';?> disabled>
                </div>
                <div class="input-text">
                  <label for="pin<?=$rc['id'];?>">Pin:</label>&nbsp;<input id="pin<?=$rc['id'];?>" type="checkbox" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="pin" data-dbb="0"<?=$rc['pin']==1?' checked':'';?>>
                </div>
                <form target="sp" method="post" action="core/purgeforum.php">
                  <input name="t" type="hidden" value="forumCategory">
                  <input name="id" type="hidden" value="<?=$rc['id'];?>">
                  <button class="trash" data-tooltip="tooltip" aria-label="Delte"><i class="i">trash</i></button>
                </form>
              </div>
              <small class="badger badge-<?= rank($rc['rank']);?>">Available to <?= ucwords(($rc['rank']==0?'everyone':str_replace('-',' ',rank($rc['rank']))));?></small>
            </div>
            <div class="card-body ml-3 mt-3" id="topics_<?=$rc['id'];?>">
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
<?php while($rt=$st->fetch(PDO::FETCH_ASSOC)){
$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `tid`=:tid");
$sp->execute([':tid'=>$rt['id']]);?>
              <div class="item row mt-3 bg-white" id="topic_<?=$rt['id'];?>">
                <div class="card col-12">
                  <div class="form-row">
                    <div class="input-text"><i class="i subhandle">drag</i></div>
                    <div class="input-text">Topic</div>
                    <input class="text-input" id="topic<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="title" type="text" value="<?=$rt['title'];?>" placeholder="Enter a Topic...">
                    <button class="save" id="savetopic<?=$rt['id'];?>" data-tooltip="tooltip" data-dbid="topic<?=$rt['id'];?>" data-style="zoom-in" aria-label="Save"><i class="i">save</i></button>
                    <div class="input-text">Description</div>
                    <input class="text-input" id="notes<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="notes" type="text" value="<?=$rt['notes'];?>" placeholder="Enter a Description...">
                    <button class="save" id="savenotes<?=$rt['id'];?>" data-tooltip="tooltip" data-dbid="notes<?=$rc['id'];?>" data-style="zoom-in" aria-label="Save"><i class="i">save</i></button>
                    <div class="input-text">
                      <label for="pin<?=$rt['id'];?>">Pin:</label>&nbsp;<input id="pin<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="pin" data-dbb="0" type="checkbox"<?=$rt['pin']==1?' checked':'';?>>
                    </div>
                    <form target="sp" method="post" action="core/purgeforum.php">
                      <input name="t" type="hidden" value="forumTopics">
                      <input name="id" type="hidden" value="<?=$rt['id'];?>">
                      <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                    </form>
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
<?php }
require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php }
