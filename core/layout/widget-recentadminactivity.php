<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Recent Admin Activity
 * @package    core/layout/widget-recentadminactivity.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->query("SELECT * FROM `".$prefix."logs` ORDER BY `ti` DESC LIMIT 10");
$cnt=$s->rowCount();?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="12" data-mdmin="6" data-mdmax="12" data-lgmin="1" data-lgmax="12" data-xlmin="5" data-xlmax="12" data-xxlmin="4" data-xxlmax="6" id="l_<?=$rw['id'];?>">
  <div class="alert widget widget-limit m-3 p-0" id="widgetrecentadminactivity<?=$rw['id'];?>">
    <div class="toolbar px-2 py-1 handle">
      <a href="<?= URL.$settings['system']['admin'].'/preferences/activity';?>"><?=$rw['title'];?></a><?=($config['development']==1?'<span id="width_'.$rw['id'].'"></span>':'');?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-3 py-1 text-muted small">Date</div>
      <div class="col-3 py-1 text-muted small">User</div>
      <div class="col-6 py-1 text-muted small">Activity</div>
      <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
        <div class="row widget-items">
          <div class="col-3 py-1"><?= date($config['dateFormat'],$r['ti']);?></div>
          <div class="col-3 py-1"><?=$r['username'].':'.$r['name'];?></div>
          <div class="col-6 py-1"><?=$r['action'].' > '.$r['refTable'].' > '.$r['refColumn'];?></div>
        </div>
      <?php }?>
    </div>
    <?php if($cnt>5){?>
      <div class="row widget-more">
        <button class="widget-more-btn" data-tooltip="tooltip" aria-label="Show/Hide Extra Items"  onclick="$(`#widgetrecentadminactivity<?=$rw['id'];?>`).toggleClass('widget-limit');$(`.widgetrecentadminactivity`).toggleClass('d-none');return false;"><i class="i widgetrecentadminactivity">down</i><i class="i widgetrecentadminactivity d-none">up</i></button>
      </div>
    <?php }?>
  </div>
</div>
