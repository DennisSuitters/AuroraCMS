<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - SEO Unsolicited
 * @package    core/layout/widget-seounsolicted.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`='seotips' ORDER BY rand() LIMIT 1");
$sc->execute();
if($sc->rowCount()>0){
  $rc=$sc->fetch(PDO::FETCH_ASSOC);?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width'];?>" data-dbid="<?=$rw['id'];?>" data-resizeMin="2" resizeMax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 bg-white handle">
      <?=$rw['title'];?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><?= svg2('close');?></button>
      </div>
    </div>
    <p class="mx-3 my-1 mt-2 small">
      <span id="seotip"><strong>Unsolicited SEO Tip:</strong> <?=$rc['notes'];?></span>
    </p>
    <p class="mx-3 small">
      <a href="#" data-fancybox data-type="ajax" data-src="core/seolist.php">Read them all.</a>
    </p>
  </div>
</div>
<?php }?>
