<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Templates
 * @package    core/layout/templates.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='templates';?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item active">Templates</li>
          </ol>
        </div>
        <legend>Templates</legend>
        <?php if($user['options'][0]==1){?>
          <form target="sp" method="post" action="core/add_template.php">
            <div class="row">
              <div class="col-12 col-sm-4 pr-md-3">
                <label fot="t">Title</label>
                <div class="form-row">
                  <input type="text" id="t" name="t" value="" placeholder="Enter a Title...">
                </div>
              </div>
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="c">contentType</label>
                <div class="form-row">
                  <select id="c" name="c">
                    <option value="all">All</option>
                    <option value="activity">Activity</option>
                    <option value="article">Article</option>
                    <option value="course">Course</option>
                    <option value="event">Event</option>
                    <option value="inventory">Inventory</option>
                    <option value="news">News</option>
                    <option value="newsletters">Newsletters</option>
                    <option value="portfolio">Portfolio</option>
                    <option value="proof">Proof</option>
                    <option value="service">Service</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="s">Type</label>
                <div class="form-row">
                  <select id="s" name="s">
                    <option value="card">Card</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="i">SVG&nbsp;Thumbnail</label>
                <div class="form-row">
                  <textarea id="i" name="i" style="height:200px;"></textarea>
                </div>
              </div>
              <div class="col-12 col-sm-4 pr-md-3">
                <label for="htm">HTML Markup</label>
                <div class="form-row">
                  <textarea id="htm" name="htm" style="height:200px;"></textarea>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <label for="da">Description</label>
                <div class="form-row">
                  <textarea id="da" name="da" style="height:200px;"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button class="add float-right" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
              </div>
            </div>
          </form>
          <hr>
        <?php }?>
        <section class="content overflow-visible" id="templates">
          <?php $s=$db->prepare("SELECT * FROM `".$prefix."templates` ORDER BY `contentType` ASC, `section` ASC");
          $s->execute();
          while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <article class="card m-1 m-sm-2 card-list" id="l_<?=$r['id'];?>">
              <div class="card-image">
                <?=$r['image'];?>
              </div>
              <div class="card-header line-clamp">
                <?=$r['title'];?>
              </div>
              <div class="card-body no-clamp">
                <p class="small"><small><?=$r['notes'];?></small></p>
              </div>
              <div class="card-footer">
                <div id="controls_<?=$r['id'];?>">
                  <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group" role="group">
                      <?=($user['options'][0]==1?'<button class="purge" id="purge'.$r['id'].'" data-tooltip="tooltip" aria-label="Delete" onclick="purge(`'.$r['id'].'`,`templates`);"><i class="i">trash</i></button>':'');?>
                    </div>
                  </div>
                </div>
              </article>
            <?php }?>
          </section>
        </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
