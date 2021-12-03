<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Templates
 * @package    core/layout/templates.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='templates';?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('templates','i-3x');?></div>
          <div>Templates</div>
          <div class="content-title-actions">
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Templates</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <legend>Templates</legend>
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
                  <option value="article">Article</option>
                  <option value="event">Event</option>
                  <option value="inventory">Inventory</option>
                  <option value="news">News</option>
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
              <button class="add float-right" data-tooltip="tooltip" aria-label="Add"><?= svg2('add');?></button>
            </div>
          </div>
        </form>
        <hr>
        <section class="content overflow-visible" id="templates">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."templates` ORDER BY `contentType` ASC, `section` ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <article class="card card-list" id="l_<?=$r['id'];?>">
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
                    <button class="btn purge trash" id="purge<?=$r['id'];?>" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','templates');"><?= svg2('trash');?></button>
                  </div>
                </div>
              </div>
          </article>
<?php }?>
        </section>
<?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
