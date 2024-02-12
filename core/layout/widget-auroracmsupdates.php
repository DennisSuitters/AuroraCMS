<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - AuroraCMS Updates
 * @package    core/layout/widget-auroracmsupdates.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(file_exists('CHANGELOG.md')){
  if(!class_exists('Parsedown')){
    require'core/parsedown/class.parsedown.php';
  }?>
  <div class="card p-3">
    <?php $Parsedown=new Parsedown();
    echo$Parsedown->text(file_get_contents('CHANGELOG.md'));?>
  </div>
  </div>
<?php }?>
