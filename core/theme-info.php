<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Theme Information
 * @package    core/theme-info.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$theme=isset($_GET['theme'])?filter_input(INPUT_GET,'theme',FILTER_UNSAFE_RAW):filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW);
echo'<div class="col-12 p-3">';
if($theme!=''){
  if(file_exists('../layout/'.$theme.'/theme.md')){
    require'parsedown/class.parsedown.php';
    $Parsedown=new Parsedown();
    echo$Parsedown->text(file_get_contents('../layout/'.$theme.'/theme.md'));
  }else
    echo ucwords($theme).' Changelog not found!!!';
}else
  echo'Theme value is empty!!!';
echo'</div>';
