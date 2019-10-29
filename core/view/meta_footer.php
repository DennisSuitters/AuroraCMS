<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Meta Footer
 * @package    core/view/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.5 Add Live Chat
 */
if(preg_match('/<block include=[\"\']?meta_footer.html[\"\']?>/',$template)&&file_exists(THEME.DS.'meta_footer.html')){
  $footer=file_get_contents(THEME.DS.'meta_footer.html');
  $footer=preg_replace([
    '/<print theme>/'
  ],[
    THEME
  ],$footer);
  if(isset($_SESSION['rank'])&&$_SESSION['rank']<100){
    if($config['options']{13}==1){
  		if($config['options']{14}==1&&$config['messengerFBCode']!='')
  			$footer=preg_replace('~<chatscript>.*?<\/chatscript>~is',$config['messengerFBCode'],$footer,1);
  		else{
  			$footer=preg_replace([
  				'/<chatscript>/',
  				'/<\/chatscript>/'
  			],'',$footer);
  		}
  	}else
  		$footer=preg_replace('~<chatscript>.*?<\/chatscript>~is','',$footer,1);
  }else
    $footer=preg_replace('~<chatscript>.*?<\/chatscript>~is','',$footer,1);
}else
  $footer='You MUST include a meta_footer template';
$content.=$footer;
