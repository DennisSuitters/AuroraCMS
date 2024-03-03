<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Theme Updates
 * @package    core/layout/widget-themeupdates.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(file_exists(THEME.'/theme.md')){
  if(!class_exists('Parsedown')){
    require'core/parsedown/class.parsedown.php';
  }?>
  <div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="12" data-mdmin="6" data-mdmax="12" data-lgmin="1" data-lgmax="12" data-xlmin="5" data-xlmax="12" data-xxlmin="4" data-xxlmax="6" id="l_<?=$rw['id'];?>">
    <div class="alert widget widget-limit m-1 p-0" id="widgetthemeupdates<?=$rw['id'];?>">
      <div class="toolbar px-2 py-1 handle"><?=$rw['title'];?>.
        <div class="btn-group">
          <button class="btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
        </div>
      </div>
      <div class="small text-muted px-2">last update <?=date ($config['dateFormat'],filemtime(THEME.'/theme.md'));?>.</div>
      <div class="widget-items m-3">
        <?php $Parsedown=new Parsedown();
        echo$Parsedown->text(file_get_contents(THEME.'/theme.md'));?>
      </div>
      <div class="row widget-more">
        <button class="widget-more-btn btn-ghost" data-tooltip="tooltip" aria-label="Show/Hide Extra Items"  onclick="$(`#widgetthemeupdates<?=$rw['id'];?>`).toggleClass('widget-limit');$(`.widgetthemeupdates`).toggleClass('d-none');return false;"><i class="i widgetthemeupdates">down</i><i class="i widgetthemeupdates d-none">up</i></button>
      </div>
    </div>
  </div>
<?php }?>
