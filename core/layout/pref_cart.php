<?php
/**
* AuroraCMS - Copyright (C) Diemen Design 2019
*
* @category   Administration - Preferences - Cart
* @package    core/layout/pref_cart.php
* @author     Dennis Suitters <dennis@diemen.design>
* @copyright  2014-2019 Diemen Design
* @license    http://opensource.org/licenses/MIT  MIT License
* @version    0.2.22
* @link       https://github.com/DiemenDesign/AuroraCMS
* @notes      This PHP Script is designed to be executed using PHP 7+
*/?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb m-0 pl-0 pt-0">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
            <li class="breadcrumb-item active">Cart</li>
          </ol>
        </div>
        <div class="m-4">
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
                    <button class="btn-sm purge trash" data-tooltip="left" aria-label="Purge All" onclick="purge('0','cart');return false;"><i class="i">purge</i></button>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody id="l_cart">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."cart` ORDER BY `ti` DESC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){
                $ci=$db->prepare("SELECT `id`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                $ci->execute([':id'=>$r['iid']]);
                $cr=$ci->fetch(PDO::FETCH_ASSOC);?>
                <tr id="l_<?=$r['id'];?>">
                  <td class="text-wrap align-middle"><?= trim($r['id']);?></td>
                  <td class="text-wrap align-middle"><?= trim($r['si']);?></td>
                  <td class="text-center align-middle"><?=($cr['code']!=''?$cr['code'].' | ':'').$cr['title'];?></td>
                  <td class="text-center align-middle"><?=$r['quantity'];?></td>
                  <td class="text-center align-middle"><?=$r['cost'];?></td>
                  <td class="text-center align-middle"><?= date($config['dateFormat'],$r['ti']);?></td>
                  <td class="align-middle">
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','cart');"><i class="i">trash</i></button>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
