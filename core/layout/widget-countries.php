<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Countries
 * @package    core/layout/widget-countries.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width'];?>" data-dbid="<?=$rw['id'];?>" data-resizeMin="2" resizeMax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 bg-white handle">
      <?=$rw['title'];?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-9 py-1 text-muted small">Country</div><div class="col-3 py-1 text-muted text-right small">Visitors</div>
<?php
  $sc=$db->prepare("SELECT `countryName`,COUNT(DISTINCT `countryName`) AS `cnt` FROM `".$prefix."tracker` WHERE `ti`>:sD ORDER BY `cnt` DESC");
  $sc->execute([':sD'=>$currentMonthStart - 1]);
  while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
    if($rc['countryName']=='')continue;?>
      <div class="col-9 py-1"><?=$rc['countryName'];?></div><div class="col-3 py-1 text-right"><?= number_format($rc['cnt']);?></div>
<?php }?>
    </div>
  </div>
</div>
