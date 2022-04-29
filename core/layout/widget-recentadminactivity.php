<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Recent Admin Activity
 * @package    core/layout/widget-recentadminactivity.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->query("SELECT * FROM `".$prefix."logs` ORDER BY `ti` DESC LIMIT 10");?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width'];?>" data-dbid="<?=$rw['id'];?>" data-resizeMin="2" data-resizeMax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 bg-white handle">
      <a href="<?= URL.$settings['system']['admin'].'/preferences/activity';?>"><?=$rw['title'];?></a>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><?= svg2('close');?></button>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-3 py-1 text-muted small">Date</div>
      <div class="col-3 py-1 text-muted small">User</div>
      <div class="col-6 py-1 text-muted small">Activity</div>
      <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
        <div class="col-3 py-1"><?= date($config['dateFormat'],$r['ti']);?></div>
        <div class="col-3 py-1"><?=$r['username'].':'.$r['name'];?></div>
        <div class="col-6 py-1"><?=$r['action'].' > '.$r['refTable'].' > '.$r['refColumn'];?></div>
      <?php }?>
    </div>
  </div>
</div>
