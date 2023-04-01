<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Rewards
 * @package    core/layout/rewards.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
            <li class="breadcrumb-item active">Rewards</li>
          </ol>
        </div>
        <table class="table-zebra">
          <thead>
            <tr>
              <th class="text-center">Code</th>
              <th class="text-center">Title</th>
              <th class="text-center">Method</th>
              <th class="text-center">Value</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Start Date</th>
              <th class="text-center">End Date</th>
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
                    <td><button class="add" type="submit" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button></td>
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
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                      </form>
                    <?php }?>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
