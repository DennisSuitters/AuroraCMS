<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Cart
 * @package    core/layout/pref_cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Cart</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>SID</th>
                <th class="text-center">Item</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Date</th>
                <th><div class="btn-group float-right" data-tooltip="tooltip" data-placement="left" data-title="Purge All"><button class="btn btn-secondary btn-sm trash" onclick="purge('0','cart');return false;" aria-label="Purge All"><?php svg('purge');?></button></th>
              </tr>
            </thead>
            <tbody id="l_cart">
              <?php $sc=$db->prepare("SELECT DISTINCT `si` FROM `".$prefix."cart` ORDER BY `ti` DESC,`si` ASC");
              $sc->execute();
              $zeb=1;
              while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
                $s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si ORDER BY `ti` DESC");
                $s->execute([
                  ':si'=>$rc['si']
                ]);
                while($r=$s->fetch(PDO::FETCH_ASSOC)){
                  $ci=$db->prepare("SELECT `id`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $ci->execute([
                    ':id'=>$r['iid']
                  ]);
                  $cr=$ci->fetch(PDO::FETCH_ASSOC);?>
                  <tr id="l_<?php echo$r['id'];?>" class="cartzebra<?php echo$zeb;?>">
                    <td class="text-wrap align-middle"><?php echo trim($r['id']);?></td>
                    <td class="text-wrap align-middle"><?php echo trim($r['si']);?></td>
                    <td class="text-center align-middle"><?php echo($cr['code']!=''?$cr['code'].' | ':'').$cr['title'];?></td>
                    <td class="text-center align-middle"><?php echo$r['quantity'];?></td>
                    <td class="text-center align-middle"><?php echo$r['cost'];?></td>
                    <td class="text-center align-middle"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="align-middle">
                      <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','cart')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                    </td>
                  </tr>
                <?php }
                $zeb=$zeb==2?$zeb=1:$zeb=2;
              }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
