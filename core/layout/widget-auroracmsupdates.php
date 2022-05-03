<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - AuroraCMS Updates
 * @package    core/layout/widget-auroracmsupdates.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(file_exists('CHANGELOG.md')){
  require'core/parsedown/class.parsedown.php';?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width'];?>" data-dbid="<?=$rw['id'];?>" data-resizeMin="2" resizeMax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 bg-white handle">
      <a target="_blank" href="https://github.com/DiemenDesign/AuroraCMS"><?=$rw['title'];?></a>.
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="small text-muted px-2">last update <?=date ($config['dateFormat'],filemtime('CHANGELOG.md'));?>.</div>
    <div class="m-3">
      <?php $Parsedown=new Parsedown();
      echo$Parsedown->text(file_get_contents('CHANGELOG.md'));?>
    </div>
  </div>
</div>
<?php }?>
