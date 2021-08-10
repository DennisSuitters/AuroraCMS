<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - FAQ
 * @package    core/layout/faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('faq','i-3x');?></div>
          <div>FAQ's</div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">FAQ's</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <legend>Frequently Asked Questions</legend>
        <form target="sp" method="post" action="core/add_faq.php">
          <label for="title">Question</label>
          <input id="title" name="t" placeholder="Enter FAQ Title/Question...">
          <label for="da">Answer</label>
          <div class="form-row">
            <div class="col-11">
              <textarea class="summernote" id="da" name="da"></textarea>
            </div>
            <div class="col-1">
              <button class="add" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
            </div>
          </div>
        </form>
        <script>
          document.addEventListener("DOMContentLoaded",function(event){
            $('.summernote').summernote({
              toolbar:[
                ['insert',['link']],
              ],
              linkList: [
<?php $sl=$db->query("SELECT `id`,`title`,`urlSlug`,`contentType` FROM `".$prefix."content` WHERE `contentType`!='testimonials' AND `contentType`!='faq' AND `contentType`!='booking' AND `status`='published' ORDER BY `contentType` ASC");
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
<?php $sf=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='faq' ORDER BY `title` ASC");
$sf->execute();
while($rf=$sf->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?=$rf['id'];?>">
            <div class="row">
              <details open>
                <summary>
                  <?=$rf['title'];?>
                  <button class="float-right trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`<?=$rf['id'];?>`,'content');"><?= svg2('trash');?></button>
                </summary>
                <p><?=$rf['notes'];?></p>
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
