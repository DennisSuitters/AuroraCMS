<?php
/**
* AuroraCMS - Copyright (C) Diemen Design 2019
*
* @category   Administration - Preferences - Cart
* @package    core/layout/pref_cart.php
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
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('shop-cart','i-3x');?></div>
          <div>Preferences - Cart</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Cart</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-0 overflow-visible">
        <table class="table-zebra">
          <thead>
            <tr>
              <th>ID</th>
              <th>SID</th>
              <th class="text-center">Item</th>
              <th>Quantity</th>
              <th>Cost</th>
              <th>Date</th>
              <th>
                <div class="btn-group float-right">
                  <button class="purge trash" data-tooltip="tooltip" aria-label="Purge All" onclick="purge('0','cart');return false;"><?= svg2('purge');?></button>
                </div>
              </th>
            </tr>
          </thead>
          <tbody id="l_cart">
            <?php $s=$db->prepare("SELECT * FROM `".$prefix."cart` ORDER BY `ti` DESC");
            $s->execute();
            while($r=$s->fetch(PDO::FETCH_ASSOC)){
              $ci=$db->prepare("SELECT `id`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
              $ci->execute([
                ':id'=>$r['iid']
              ]);
              $cr=$ci->fetch(PDO::FETCH_ASSOC);?>
              <tr id="l_<?=$r['id'];?>">
                <td class="text-wrap align-middle"><?= trim($r['id']);?></td>
                <td class="text-wrap align-middle"><?= trim($r['si']);?></td>
                <td class="text-center align-middle"><?=($cr['code']!=''?$cr['code'].' | ':'').$cr['title'];?></td>
                <td class="text-center align-middle"><?=$r['quantity'];?></td>
                <td class="text-center align-middle"><?=$r['cost'];?></td>
                <td class="text-center align-middle"><?= date($config['dateFormat'],$r['ti']);?></td>
                <td class="align-middle">
                  <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','cart');"><?= svg2('trash');?></button>
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
