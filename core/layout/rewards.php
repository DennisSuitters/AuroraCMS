<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Rewards
 * @package    core/layout/rewards.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item active">Rewards</li>
          </ol>
        </div>
        <div class="sticky-top">
          <div class="row">
            <article class="card m-0 p-0 overflow-visible card-list card-list-header shadow">
              <div class="row py-2">
                <div class="col-12 col-md text-center">Code</div>
                <div class="col-12 col-md text-center">Title</div>
                <div class="col-12 col-md text-center">Method</div>
                <div class="col-12 col-md text-center">Value</div>
                <div class="col-12 col-md text-center">Quantity</div>
                <div class="col-12 col-md-2 text-center">Start Date</div>
                <div class="col-12 col-md-2 text-center">End Date</div>
                <div class="col-12 col-md-1">&nbsp;</div>
              </div>
              <?php if($user['options'][0]==1){?>
                <form class="row m-0 p-0" target="sp" method="post" action="core/add_reward.php">
                  <input name="act" type="hidden" value="add_reward">
                  <div class="col-12 col-md">
                    <input id="code" name="code" type="text" value="" placeholder="Code...">
                  </div>
                  <div class="col-12 col-md">
                    <input id="title" name="title" type="text" value="" placeholder="Title...">
                  </div>
                  <div class="col-12 col-md">
                    <select id="method" name="method">
                      <option value="0">% Off</option>
                      <option value="1">$ Off</option>
                    </select>
                  </div>
                  <div class="col-12 col-md">
                    <input id="value" name="value" type="text" value="" placeholder="Value...">
                  </div>
                  <div class="col-12 col-md">
                    <input id="quantity" name="quantity" type="text" value="" placeholder="Quantity...">
                  </div>
                  <div class="col-12 col-md-2">
                    <input id="tis" name="tis" type="date" value="" onchange="$(`#tisx`).val(getTimestamp(`tis`));">
                    <input id="tisx" name="tisx" type="hidden" value="<?= time();?>">
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="form-row">
                      <input id="tie" name="tie" type="date" value="" onchange="$(`#tiex`).val(getTimestamp(`tie`));">
                      <input id="tiex" name="tiex" type="hidden" value="<?= time();?>">
                      <button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                    </div>
                  </div>
                </form>
              <?php }?>
            </article>
          </div>
        </div>
        <div id="rewards">
          <?php $s=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `ti` ASC, `code` ASC");
          $s->execute();
          while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <div class="row" id="l_<?=$r['id'];?>">
              <article class="card zebra m-0 p-0 py-3 small overflow-visible card-list item shadow">
                <div class="row">
                  <div class="col-12 col-md text-center"><?=$r['code'];?></div>
                  <div class="col-12 col-md text-center"><?=$r['title'];?></div>
                  <div class="col-12 col-md text-center"><?=$r['method']==0?'% Off':'$ Off';?></div>
                  <div class="col-12 col-md text-center"><?=$r['value'];?></div>
                  <div class="col-12 col-md text-center"><?=$r['quantity'];?></div>
                  <div class="col-12 col-md-2 text-center"><?=$r['tis']!=0?date($config['dateFormat'],$r['tis']):'';?></div>
                  <div class="col-12 col-md-2 text-center"><?=$r['tie']!=0?date($config['dateFormat'],$r['tie']):'';?></div>
                  <div class="col-12 col-md-1 pr-2 text-right">
                    <?php if($user['options'][0]==1){?>
                      <form target="sp" action="core/purge.php">
                        <input name="id" type="hidden" value="<?=$r['id'];?>">
                        <input name="t" type="hidden" value="rewards">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    <?php }?>
                  </div>
                </div>
              </article>
            </div>
          <?php }?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
