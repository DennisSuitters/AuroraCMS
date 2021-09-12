<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Forum
 * @package    core/layout/forum.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.0
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
          <div class="content-title-icon"><?= svg2('forum','i-3x');?></div>
          <div>Forum</div>
          <div class="content-title-actions">
            <?=$user['options'][7]==1?'<a class="btn" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/forum/settings" role="button" aria-label="Forum Settings">'.svg2('settings').'</a>':'';?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Forum</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <form target="sp" method="post" action="core/add_forumdata.php">
          <input type="hidden" name="act" value="category">
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
              <option value="310">Wholesaler Silver and above</option>
              <option value="320">Wholesaler Bronze and above</option>
              <option value="330">Wholesaler Gold and above</option>
              <option value="340">Wholesaler Platinum and above</option>
              <option value="400">Contributor and above</option>
              <option value="500">Author and above</option>
              <option value="600">Editor and above</option>
              <option value="700">Moderator and above</option>
              <option value="800">Manager and above</option>
              <option value="900">Administrator and above</option>
            </select>
            <div class="input-text">
              <label for="help">Help: </label><input type="checkbox" id="help" name="help">
            </div>
            <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
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
          <div id="cats_<?=$rc['id'];?>" class="item row mb-3 border-1 bg-white">
            <div class="card col-12 border-0">
              <div class="form-row">
                <div class="input-text"><?php svg('drag','cathandle');?></div>
                <div class="input-text">Category</div>
                <input class="text-input" id="category<?=$rc['id'];?>" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="title" type="text" value="<?=$rc['title'];?>" placeholder="Enter a Category...">
                <button class="save" id="savecategory<?=$rc['id'];?>" data-tooltip="tooltip" data-dbid="category<?=$rc['id'];?>" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
                <div class="input-text">Description</div>
                <input class="text-input" id="notes<?=$rc['id'];?>" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="notes" type="text" value="<?=$rc['notes'];?>" placeholder="Enter a Description...">
                <button class="save" id="savenotes<?=$rc['id'];?>" data-tooltip="tooltip" data-dbid="notes<?=$rc['id'];?>" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
                <div class="input-text">
                  <label for="help<?=$rc['id'];?>">Help: </label><input type="checkbox" id="help<?=$rc['id'];?>"<?=$rc['help']==1?' checked':'';?> disabled>
                </div>
                <div class="input-text">
                  <label for="pin<?=$rc['id'];?>">Pin: </label><input type="checkbox" id="pin<?=$rc['id'];?>" data-dbid="<?=$rc['id'];?>" data-dbt="forumCategory" data-dbc="pin" data-dbb="0"<?=$rc['pin']==1?' checked':'';?>>
                </div>
                <form target="sp" method="post" action="core/purgeforum.php">
                  <input type="hidden" name="t" value="forumCategory">
                  <input type="hidden" name="id" value="<?=$rc['id'];?>">
                  <button class="trash" data-tooltip="tooltip" aria-label="Delte"><?= svg2('trash');?></button>
                </form>
              </div>
              <small class="badger badge-<?= rank($rc['rank']);?>">Available to <?= ucwords(($rc['rank']==0?'everyone':str_replace('-',' ',rank($rc['rank']))));?></small>
            </div>
            <div id="topics_<?=$rc['id'];?>" class="card-body ml-3 mt-3">
              <form target="sp" method="post" action="core/add_forumdata.php">
                <input type="hidden" name="act" value="topic">
                <input type="hidden" name="id" value="<?=$rc['id'];?>">
                <input type="hidden" name="rank" value="<?=$rc['rank'];?>">
                <input type="hidden" name="help" value="<?=$rc['help'];?>">
                <div class="form-row">
                  <div class="input-text">Topic</div>
                  <input name="t" placeholder="Enter a Topic Title...">
                  <div class="input-text">Description</div>
                  <input name="da" placeholder="Enter a Short Description...">
                  <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
                </div>
              </form>
<?php while($rt=$st->fetch(PDO::FETCH_ASSOC)){
$sp=$db->prepare("SELECT * FROM `".$prefix."forumPosts` WHERE `tid`=:tid");
$sp->execute([':tid'=>$rt['id']]);?>
              <div id="topic_<?=$rt['id'];?>" class="item row mt-3 bg-white">
                <div class="card col-12">
                  <div class="form-row">
                    <div class="input-text"><?php svg('drag','subhandle');?></div>
                    <div class="input-text">Topic</div>
                    <input class="text-input" id="topic<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="title" type="text" value="<?=$rt['title'];?>" placeholder="Enter a Topic...">
                    <button class="save" id="savetopic<?=$rt['id'];?>" data-tooltip="tooltip" data-dbid="topic<?=$rt['id'];?>" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
                    <div class="input-text">Description</div>
                    <input class="text-input" id="notes<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="notes" type="text" value="<?=$rt['notes'];?>" placeholder="Enter a Description...">
                    <button class="save" id="savenotes<?=$rt['id'];?>" data-tooltip="tooltip" data-dbid="notes<?=$rc['id'];?>" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
                    <div class="input-text">
                      <label for="pin<?=$rt['id'];?>">Pin: </label><input type="checkbox" id="pin<?=$rt['id'];?>" data-dbid="<?=$rt['id'];?>" data-dbt="forumTopics" data-dbc="pin" data-dbb="0"<?=$rt['pin']==1?' checked':'';?>>
                    </div>
                    <form target="sp" method="post" action="core/purgeforum.php">
                      <input type="hidden" name="t" value="forumTopics">
                      <input type="hidden" name="id" value="<?=$rt['id'];?>">
                      <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?= svg2('trash');?></button>
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
<?php }?>
<?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php }