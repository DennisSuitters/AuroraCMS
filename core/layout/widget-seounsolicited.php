<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - SEO Unsolicited
 * @package    core/layout/widget-seounsolicted.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`='seotips' ORDER BY rand() LIMIT 1");
$sc->execute();
if($sc->rowCount()>0){
  $rc=$sc->fetch(PDO::FETCH_ASSOC);?>
  <div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="12" data-mdmin="3" data-mdmax="12" data-lgmin="1" data-lgmax="12" data-xlmin="5" data-xlmax="12" data-xxlmin="3" data-xxlmax="12" id="l_<?=$rw['id'];?>">
    <div class="alert widget m-3 p-0">
      <div class="toolbar px-2 py-1 handle">
        <?=$rw['title'];?> | seounsolicited.php
        <div class="btn-group">
          <button class="btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
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
