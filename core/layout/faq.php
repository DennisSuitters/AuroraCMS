<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - FAQ
 * @package    core/layout/faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">faq</i></div>
          <div>FAQ's</div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">FAQ's</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <legend>Frequently Asked Questions</legend>
        <form target="sp" method="post" action="core/add_faq.php">
          <label for="c">Category</label>
          <input id="c" name="c" type="text" placeholder="Enter a Category...">
          <label for="title">Question</label>
          <input id="title" name="t" type="text" placeholder="Enter FAQ Title/Question...">
          <div class="row">
            <div class="col-sm">
              <label for="da">Answer</label>
            </div>
            <div class="col-sm-11">
              <input id="open" name="open" type="checkbox" value="1" checked>
              <label for="open">Open By Default</label>
            </div>
          </div>
          <div class="form-row">
            <div class="col-11">
              <textarea class="summernote" id="da" name="da"></textarea>
            </div>
            <div class="col-1">
              <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
            </div>
          </div>
        </form>
        <script>
          document.addEventListener("DOMContentLoaded",function(event){
            $('.summernote').summernote({
              toolbar:[
                ['insert',['link']],
              ],
              linkList:[
<?php $sl=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `mid`=0 AND `menu`!='none' AND `active`=1 ORDER BY FIELD(`menu`,'head','footer','account','other'), `ord` ASC");
$sl->execute();
while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
              echo'['.
                '"'.$rl['title'].'",'.
                '"'.URL.$rl['contentType'].'/'.$rl['url'].'",'.
                '"'.ucwords($rl['contentType']).' - '.$rl['title'].'",'.
              '],';
}
$sl=$db->query("SELECT `id`,`title`,`urlSlug`,`contentType` FROM `".$prefix."content` WHERE `contentType`!='testimonials' AND `contentType`!='faq' AND `contentType`!='booking' AND `status`='published' ORDER BY `contentType` ASC");
$sl->execute();
while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
                echo'['.
                  '"'.$rl['title'].'",'.
                  '"'.URL.$rl['contentType'].'/'.$rl['urlSlug'].'/",'.
                  '"'.ucwords($rl['contentType']).' - '.$rl['title'].'",'.
                '],';
}?>
              ],
              callbacks:{
                onInit:function(){
                  $('body > .note-popover').appendTo(".note-editing-area");
                }
              }
            })
          });
        </script>
        <hr>
        <div id="faqs">
<?php $sf=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='faq' ORDER BY `category_1` ASC, `title` ASC");
$sf->execute();
while($rf=$sf->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?=$rf['id'];?>">
            <div class="row">
              <h5><?=$rf['category_1'];?></h5>
              <details<?=$rf['options'][9]==1?' open':'';?>>
                <summary>
                  <?=$rf['title'];?>
                  <div class="col-3 float-right text-right">
                    <input id="faqoptions9<?=$rf['id'];?>" data-dbid="<?=$rf['id'];?>" data-dbt="content" data-dbc="options" data-dbb="9" type="checkbox"<?=($rf['options'][9]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                    <label for="faqoptions9<?=$rf['id'];?>">Display as Open</label>
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?=$rf['id'];?>`,'content');"><i class="i">trash</i></button>
                  </div>
                </summary>
                <div class="ml-4">
                  <?=$rf['notes'];?>
                </div>
              </details>
            </div>
          </div>
          <hr>
<?php }?>
        </div>
<?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
