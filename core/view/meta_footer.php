<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Meta Footer
 * @package    core/view/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(preg_match('/<block include=[\"\']?meta_footer.html[\"\']?>/',$template)&&file_exists(THEME.DS.'meta_footer.html')){
  $footer=file_get_contents(THEME.DS.'meta_footer.html');
  $footer=preg_replace([
    '/<print theme>/'
  ],[
    THEME
  ],$footer);
}else
  $footer='You MUST include a meta_footer template';
$content.=$footer;
