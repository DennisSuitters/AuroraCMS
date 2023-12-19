<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Newsletters - Edit
 * @package    core/layout/edit_newsletters.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="row">
        <div class="card col-12 col-sm mt-3 bg-transparent border-0 overflow-visible order-2 order-sm-1">
          <div class="card-actions">
            <div class="row">
              <div class="col-12 col-sm">
                <ol class="breadcrumb m-0 pl-0 pt-0">
                  <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/newsletters';?>">Newsletters</a></li>
                  <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
                  <li class="breadcrumb-item active"><span id="titleupdate"><?=$r['title'];?></span></li>
                </ol>
              </div>
              <div class="col-12 col-sm-2 text-right">
                <div class="btn-group">
                  <?=(isset($_SERVER['HTTP_REFERER'])?'<a href="'.$_SERVER['HTTP_REFERER'].'" role="button" data-tooltip="left" aria-label="Back"><i class="i">back</i></a>':'').
                  ($user['options'][1]==1?'<button class="email" data-tooltip="left" aria-label="Send Newsletters" onclick="$(`#sp`).load(`core/newsletter.php?id='.$r['id'].'&act=`);return false;"><i class="i">email-send</i></button>'.
                  '<button class="btn saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></button>':'');?>
                </div>
              </div>
            </div>
          </div>
          <div class="tabs" role="tablist">
            <input class="tab-control" id="tab1-1" name="tabs" type="radio" checked>
            <label for="tab1-1">General</label>
            <input class="tab-control" id="tab1-2" name="tabs" type="radio">
            <label for="tab1-2">Settings</label>
<?php /* General */ ?>
            <div class="tab1-1 border p-3" data-tabid="tab1-1" role="tabpanel">
              <div id="notification" role="alert"></div>
              <label for="title" class="mt-0">Title</label>
              <div class="form-row">
                <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="title" type="text" value="<?=$r['title'];?>" onkeyup="$('#titleupdate').text($(this).val());"<?=($user['options'][1]==1?' placeholder="Enter a Title (Used as the Email Subject)..."':' disabled');?>>
                <?=($user['options'][1]==1?'<button class="save" id="savetitle" data-dbid="title" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
              </div>
              <label for="ti">Created</label>
              <div class="form-row">
                <input id="ti" type="text" value="<?= date($config['dateFormat'],$r['ti']);?>" disabled>
              </div>
              <div class="row">
                <label for="tags">Tags</label>
                <div class="form-row">
                  <input class="textinput" id="tags" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="tags" type="text" value="<?=$r['tags'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Tag or Select from List..."':' disabled';?>>
                  <?=($user['options'][1]==1?'<button class="save" id="savetags"  data-dbid="tags" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
                </div>
                <script>
                  var input = document.querySelector('#tags');
                  tagify = new Tagify(input, {
                    whitelist: [
                      <?php if($user['options'][1]==1){
                        $tags=array();
                        $st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
                        if($st->rowCount()>0){
                          while($rt=$st->fetch(PDO::FETCH_ASSOC)){
                            $tagslist=explode(",",$rt['tags']);
                            foreach($tagslist as $t)$tgs[]=$t;
                          }
                        }
                        if(isset($tgs)&&$tgs!='')$tags=array_unique($tgs);
                        asort($tags);
                        foreach($tags as $t)echo'"'.$t.'",';
                      }?>
                    ],
                    maxTags: 10,
                    dropdown: {
                      maxItems: 20,           // <- mixumum allowed rendered suggestions
                      classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                      enabled: 0,             // <- show suggestions on focus
                      closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
                    },
                    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
                  });
                </script>
              </div>
              <div class="row mt-3">
                <?php if($user['options'][1]==1){?>
                  <div class="form-text">Tokens:
                    <a class="badge badge-secondary" href="#" onclick="$('#notes').summernote('insertText','{name}');return false;">{name}</a>
                  </div>
                  <div id="notesda" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                  <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="content">
                    <input name="c" type="hidden" value="notes">
                    <textarea class="summernote" id="notes" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?= rawurldecode($r['notes']);?></textarea>
                  </form>
                <?php }else{?>
                  <div class="note-admin">
                    <div class="note-editor note-frame">
                      <div class="note-editing-area">
                        <div class="note-viewport-area">
                          <div class="note-editable">
                            <?= rawurldecode($r['notes']);?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }?>
              </div>
            </div>
            <div class="tab1-2 border p-3" data-tabid="tab1-2" role="tabpanel">
              <div class="form-row">
                <input id="matchTags" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="8" type="checkbox"<?=($r['options'][8]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                <label class="p-0 mt-0 ml-3" for="matchTags">Match Tags to Subscribers</label>
              </div>
              <label for="status">Status</label>
              <div class="form-row">
                <select id="status" onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');"<?=$user['options'][1]==1?'':' disabled';?>>
                  <option value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                  <option value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
                  <option value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
