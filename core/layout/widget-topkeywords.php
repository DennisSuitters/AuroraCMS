<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Top Keywords
 * @package    core/layout/widget-topkeywords.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT DISTINCT(`keywords`) AS `keywords` FROM `".$prefix."tracker` WHERE `keywords`!='' ORDER BY `keywords` DESC LIMIT 0,10");
$s->execute();
if($s->rowCount()>0){?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width'];?>" data-dbid="<?=$rw['id'];?>" data-resizeMin="2" resizeMax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 bg-white handle">
      <?=$rw['title'];?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-9 py-1 text-muted small">Keywords</div><div class="col-3 py-1 text-muted text-right small">Count</div>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
$sr=$db->prepare("SELECT COUNT(`keywords`) AS `cnt` FROM `".$prefix."tracker` WHERE `keywords` LIKE :keywords");
$sr->execute([':keywords'=>$r['keywords']]);
$rr=$sr->fetch(PDO::FETCH_ASSOC);?>
          <div class="col-9 py-1"><?=$r['keywords'];?></div><div class="col-3 py-1 text-right"><?= number_format($rr['cnt']);?></div>
<?php }?>
    </div>
  </div>
</div>
<?php }
