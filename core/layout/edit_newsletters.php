<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Newsletters - Edit
 * @package    core/layout/edit_newsletters.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.1 Add Tag Editing Field as well as retreiving and sorting Tags from other Content
 * @changes    v0.1.1 Add Checkbox Option for matching tags to Subcribers
 * @changes    v0.1.2 Use PHP short codes where possible.
 */
$q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
$q->execute([
  ':id'=>$args[1]
]);
$r=$q->fetch(PDO::FETCH_ASSOC);?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('newspaper','i-3x');?></div>
          <div>Edit Newsletter: <?=$r['title'];?></div>
          <div class="content-title-actions">
            <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?= svg2('back');?></a>
            <button class="email" data-tooltip="tooltip" aria-label="Send Newsletters" onclick="$('#sp').load('core/newsletter.php?id=<?=$r['id'];?>&act=');return false;"><?= svg2('email-send');?></button>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/newsletters';?>">Newsletters</a></li>
          <li class="breadcrumb-item active"><?=$user['options'][1]==1?'Edit':'View';?></li>
          <li class="breadcrumb-item active"><span id="titleupdate"><?=$r['title'];?></span></li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <div id="notification" role="alert"></div>
        <label id="newsletterTitle" for="title"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/edit/'.$r['id'].'#newsletterTitle" aria-label="PermaLink to Newsletter Title Field">&#128279;</a>':'';?>Title</label>
        <div class="form-row">
          <input class="textinput" id="title" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="title" type="text" value="<?=$r['title'];?>" placeholder="Enter a Title (Used as the Email Subject)..." onkeyup="$('#titleupdate').text($(this).val());">
          <button class="save" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <label id="newsletterDateCreated" for="ti"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/edit/'.$r['id'].'#newsletterDateCreated" aria-label="PermaLink to Newsletter Date Created Field">&#128279;</a>':'';?>Created</label>
        <div class="form-row">
          <input id="ti" type="text" value="<?= date($config['dateFormat'],$r['ti']);?>" readonly>
        </div>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/edit/'.$r['id'].'#matchTags" aria-label="PermaLink to Newsletters Match Tags Checkbox">&#128279;</a>':'';?>
          <input id="matchTags" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="8" type="checkbox"<?=($r['options'][8]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
          <label for="matchTags" id="contentoptions8<?=$r['id'];?>">Match Tags to Subscribers</label>
        </div>
        <div class="row mt-3">
          <label id="<?=$r['contentType'];?>tags" for="tags"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/edit/'.$r['id'].'#'.$r['contentType'].'tags" aria-label="PermaLink to '.ucfirst($r['contentType']).' Tags">&#128279;</a>':'';?>Tags</label>
          <div class="form-row">
            <input class="textinput" id="tags" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="tags" type="text" value="<?=$r['tags'];?>"<?=$user['options'][1]==1?' placeholder="Enter a Tag or Select from List..."':' readonly';?>>
            <?='<button class="save" id="savetags" data-tooltip="tooltip"  data-dbid="tags" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>';?>
          </div>
          <?php if($user['options'][1]==1){
            $tags=array();
            $st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
            if($st->rowCount()>0){
              while($rt=$st->fetch(PDO::FETCH_ASSOC)){
                $tagslist=explode(",",$rt['tags']);
                foreach($tagslist as$t){
                  $tgs[]=$t;
                }
              }
            }
            $tags=array_unique($tgs);
            asort($tags);
            echo'<select id="tags_options" onchange="addTag($(this).val());">'.
              '<option value="none">Clear All</option>';
            foreach($tags as$t){
              echo'<option value="'.$t.'">'.$t.'</option>';
            }
            echo'</select>';
          }?>
        </div>
        <label id="newsletterStatus" for="status"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/edit/'.$r['id'].'#newsletterStatus" aria-label="PermaLink to Newsletter Status Selector Field">&#128279;</a>':'';?>Status</label>
        <div class="form-row">
          <select id="status" onchange="update('<?=$r['id'];?>','content','status',$(this).val(),'select');"<?=$user['options'][1]==0?' readonly':'';?>>
            <option value="unpublished"<?=$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
            <option value="published"<?=$r['status']=='published'?' selected':'';?>>Published</option>
            <option value="delete"<?=$r['status']=='delete'?' selected':'';?>>Delete</option>
          </select>
        </div>
        <div class="row mt-3">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/newsletters/edit/'.$r['id'].'#summernote" aria-label="PermaLink to Newsletter Content Field">&#128279;</a>':'';?>
          <div id="notesda" data-dbid="<?=$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
          <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="<?=$r['id'];?>">
            <input name="t" type="hidden" value="content">
            <input name="c" type="hidden" value="notes">
            <textarea class="summernote" id="notes" data-dbid="<?=$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?= rawurldecode($r['notes']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
