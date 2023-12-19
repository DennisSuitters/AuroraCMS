<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - FAQ
 * @package    core/layout/faq.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='6'");
$sv->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item active">Frequently Asked Questions (FAQ's)</li>
          </ol>
        </div>
        <div class="sticky-top">
          <div class="row">
            <article class="card mb-0 p-0 overflow-visible card-list card-list-header shadow">
              <div class="row py-2">
                <div class="col-12 col-md pl-2">Category</div>
                <div class="col-12 col-md pl-2">Question</div>
                <div class="col-12 col-md-1 text-center">Open</div>
              </div>
              <?php if($user['options'][1]==1){?>
                <form target="sp" method="post" action="core/add_faq.php">
                  <div class="row">
                    <div class="col-12 col-md">
                      <input id="c" name="c" type="text" placeholder="Enter a Category...">
                    </div>
                    <div class="col-12 col-md">
                      <input id="title" name="t" type="text" placeholder="Enter FAQ Title/Question...">
                    </div>
                    <div class="col-12 col-md-1 py-2 text-center">
                      <input id="open" name="open" type="checkbox" value="1" checked>
                    </div>
                  </div>
                  <div class="row py-2">
                    <div class="col-12 col-md pl-2">Answer</div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md">
                      <textarea class="summernote" id="da" name="da"></textarea>
                    </div>
                    <div class="col-12 col-md-1 text-right align-bottom">
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
              <?php }?>
            </article>
          </div>
          <hr>
        <div id="faqs">
          <?php $sf=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='faq' ORDER BY `category_1` ASC, `title` ASC");
          $sf->execute();
          while($rf=$sf->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?=$rf['id'];?>">
              <div class="row p-2">
                <h5><?=$rf['category_1'];?></h5>
                <details<?=$rf['options'][9]==1?' open':'';?>>
                  <summary>
                    <?=$rf['title'];?>
                    <div class="col-3 float-right text-right">
                      <input id="faqoptions9<?=$rf['id'];?>" data-dbid="<?=$rf['id'];?>" data-dbt="content" data-dbc="options" data-dbb="9" type="checkbox"<?=($rf['options'][9]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][1]==1?'':' disabled');?>>
                      <label for="faqoptions9<?=$rf['id'];?>">Display as Open</label>
                      <?=$user['options'][1]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$rf['id'].'`,`content`);"><i class="i">trash</i></button>':'';?>
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
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
