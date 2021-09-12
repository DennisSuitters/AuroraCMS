<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Suggestion
 * @package    core/layout/pref_suggestion.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('idea','i-3x');?></div>
          <div>Preferences - Suggestions</div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Suggestions</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <div class="alert alert-info" role="alert">The Suggestions are for notifying other User's of the Administration area with information, or to pass notes, for e.g. editing suggestions, or just to let them know an issue has been resolved. Can also be use to set reminders for yourself when you Login next.</div>
        <form target="sp" method="post" action="core/add_adminsuggestion.php">
          <div class="form-row">
            <div class="input-text">For</div>
            <select id="for" name="u">
              <option value="0">Select a User...</option>
<?php $suu=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `rank`>699 ORDER BY username ASC");
$suu->execute();
while($ruu=$suu->fetch(PDO::FETCH_ASSOC)){
  echo'<option value="'.$ruu['id'].'">'.$ruu['username'].($ruu['name']!=''?' : '.$ruu['name']:'').'</option>';
}?>
            </select>
          </div>
          <div class="row">
            <div class="col-12 col-sm">
              <textarea class="note" id="da" name="da" placeholder="Enter a Short Description..."></textarea>
            </div>
            <div class="col-1 col-sm--5">
              <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
            </div>
          </div>
        </form>
        <hr>
        <div id="suggestions">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."suggestions` WHERE `popup`=1 ORDER BY `ti` DESC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $su=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([
    ':id'=>$r['uid']
  ]);
  $rt=$su->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([
    ':id'=>$r['rid']
  ]);
  $rf=$su->fetch(PDO::FETCH_ASSOC);?>
          <div id="l_<?=$r['id'];?>">
						<div class="row">
              <h6 class="m-0 p-0">To: <?=$rt['username'].($rt['name']!=''?':'.$rt['name']:'').' - From: '.$rf['username'].($rf['name']!=''?':'.$rf['name']:'');?></h6>
							<details class="m-0">
								<summary>
									Created on <?= date($config['dateFormat'],$r['ti']);?> and has <?=($r['seen']==1?'':'<strong>NOT</strong>');?> been seen<?=($r['sti']==0?'':' on '.date($config['dateFormat']));?>.
									<form class="float-right" target="sp" action="core/purge.php">
										<input name="id" type="hidden" value="<?=$r['id'];?>">
										<input name="t" type="hidden" value="suggestions">
										<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><?= svg2('trash');?></button>
									</form>
								</summary>
								<?=$r['notes'];?>
							</details>
						</div>
						<hr>
					</div>
<?php }?>
        </div>
<?php require'core/layout/footer.php';?>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $(".note").summernote({
        height:"100px",
        disableUpload:true,
        fileExplorer:"",
        popover:{
          image:[
            [`remove`,[`removeMedia`]],
          ],
          link:[
            [`link`,[`linkDialogShow`,`unlink`]],
          ],
          air:[]
        },
        toolbar:[
          [`font`,[`bold`,`italic`,`underline`,`clear`]],
          [`para`,[`ul`,`ol`]],
          [`insert`,[`picture`,`video`,`audio`,`link`,`hr`]],
        ]
        });
      });
    </script>
  </section>
</main>
