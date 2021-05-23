<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Rewards
 * @package    core/layout/rewards.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('credit-card','i-3x');?></div>
          <div>Reviews</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item active">Rewards</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow overflow-visible">
        <table class="table-zebra">
          <thead>
            <tr>
              <th class="text-center"><label for="code">Code</label></th>
              <th class="text-center"><label for="title">Title</label></th>
              <th class="text-center"><label for="method">Method</label></th>
              <th class="text-center"><label for="value">Value</label></th>
              <th class="text-center"><label for="quantity">Quantity</label></th>
              <th class="text-center"><label for="tis">Start Date</label></th>
              <th class="text-center"><label for="tie">End Date</label></th>
              <th></th>
            </tr>
          </thead>
          <tbody id="rewards">
          <?php if($user['options'][0]==1){?>
            <form target="sp" method="post" action="core/add_reward.php">
              <input name="act" type="hidden" value="add_reward">
                <tr>
                  <td><input id="code" name="code" type="text" value="" placeholder="Code..."></td>
                  <td><input id="title" name="title" type="text" value="" placeholder="Title..."></td>
                  <td>
                    <select id="method" name="method">
                      <option value="0">% Off</option>
                      <option value="1">$ Off</option>
                    </select>
                  </td>
                  <td><input id="value" name="value" type="text" value="" placeholder="Value..."></td>
                  <td><input id="quantity" name="quantity" type="text" value="" placeholder="Quantity..."></td>
                  <td>
                    <input id="tis" name="tis" type="date" value="" onchange="$(`#tisx`).val(getTimestamp(`tis`));">
                    <input id="tisx" name="tisx" type="hidden" value="<?= time();?>">
                  </td>
                  <td>
                    <input id="tie" name="tie" type="date" value="" onchange="$(`#tiex`).val(getTimestamp(`tie`));">
                    <input id="tiex" name="tiex" type="hidden" value="<?= time();?>">
                  </td>
                  <td><button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?= svg2('add');?></button></td>
                </tr>
            </form>
          <?php }
          $s=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `ti` ASC, `code` ASC");
          $s->execute();
          while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <tr id="l_<?=$r['id'];?>">
              <td class="text-center small"><?=$r['code'];?></td>
              <td class="text-center small"><?=$r['title'];?></td>
              <td class="text-center small"><?=$r['method']==0?'% Off':'$ Off';?></td>
              <td class="text-center small"><?=$r['value'];?></td>
              <td class="text-center small"><?=$r['quantity'];?></td>
              <td class="text-center small"><?=$r['tis']!=0?date($config['dateFormat'],$r['tis']):'';?></td>
              <td class="text-center small"><?=$r['tie']!=0?date($config['dateFormat'],$r['tie']):'';?></td>
              <td>
                <?php if($user['options'][0]==1){?>
                  <form target="sp" action="core/purge.php">
                    <input name="id" type="hidden" value="<?=$r['id'];?>">
                    <input name="t" type="hidden" value="rewards">
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?= svg2('trash');?></button>
                  </form>
                <?php }?>
              </td>
            </tr>
          <?php }?>
        </tbody>
      </table>
      <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
