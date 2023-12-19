<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Countries
 * @package    core/layout/widget-countries.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="6" data-mdmin="4" data-mdmax="6" data-lgmin="3" data-lgmax="6" data-xlmin="3" data-xlmax="3" data-xxlmin="2" data-xxlmax="2" id="l_<?=$rw['id'];?>">
  <div class="alert widget widget-limit m-3 p-0" id="widgetcountries<?=$rw['id'];?>">
    <div class="toolbar px-2 py-1 handle">
      <?=$rw['title'];?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-9 py-1 text-muted small">Country</div><div class="col-3 py-1 text-muted text-right small">Visitors</div>
      <?php $sc=$db->prepare("SELECT `countryName`,COUNT(DISTINCT `countryName`) AS `cnt` FROM `".$prefix."tracker` WHERE `ti`>:sD ORDER BY `cnt` DESC");
      $sc->execute([':sD'=>$currentMonthStart - 1]);
      $cnt=$sc->rowCount();
      while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
        if($rc['countryName']=='')continue;?>
        <div class="row widget-items">
          <div class="col-9 py-1"><?=$rc['countryName'];?></div>
          <div class="col-3 py-1 text-right"><?= number_format($rc['cnt']);?></div>
        </div>
      <?php }?>
    </div>
    <?php if($cnt>5){?>
      <div class="row widget-more">
        <button class="widget-more-btn btn-ghost" data-tooltip="tooltip" aria-label="Show/Hide Extra Items"  onclick="$(`#widgetcountries<?=$rw['id'];?>`).toggleClass('widget-limit');$(`.widgetcountries`).toggleClass('d-none');return false;"><i class="i widgetcountries">down</i><i class="i widgetcountries d-none">up</i></button>
      </div>
    <?php }?>
  </div>
</div>
