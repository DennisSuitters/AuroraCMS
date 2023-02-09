<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Latest Orders
 * @package    core/layout/widget-dashboardlatestorders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$so=$db->prepare("SELECT * FROM `".$prefix."orders` ORDER BY `ti` DESC LIMIT 7");
$so->execute();?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width'];?>" data-dbid="<?=$rw['id'];?>" data-resizeMin="6" resizeMax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 handle">
      <?=$rw['title'];?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="mx-2 my-1 small" style="min-height:240px;height:240px;max-height:240px;max-width:100%;">
      <table class="table-zebra m-0 p-0">
        <thead>
          <tr>
            <th>Date</th>
            <th>Order #</th>
            <th class="text-center">Status</th>
          </tr>
        </thead>
        <tbody>
<?php while($ro=$so->fetch(PDO::FETCH_ASSOC)){?>
          <tr>
            <td class="px-2 py-1 small align-middle"><?= date($config['dateFormat'],$ro['ti']);?></td>
            <td class="px-2 py-1 small align-middle"><a href="<?= URL.$settings['system']['admin'].'/orders/edit/'.$ro['id'];?>"><?=$ro['iid']!=''?$ro['iid']:$ro['qid'];?></a></td>
            <td class="px-2 py-1 text-center align-middle"><span class="badger badge-<?=$ro['status'];?>"><?=$ro['status'];?></span></td>
          </tr>
<?php }?>
        </tbody>
        <tfoot>
          <tr>
            <td class="m-0 p-0 py-1 text-right" colspan="3"><a class="btn btn-sm" href="<?= URL.$settings['system']['admin'];?>/orders/all">View All Orders</a></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
