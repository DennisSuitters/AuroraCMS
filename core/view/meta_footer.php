<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Meta Footer
 * @package    core/view/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.5 Add Live Chat
 * @changes    v0.0.6 Add GDPR
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
  			$footer=preg_replace(
          '~<chatscript>.*?<\/chatscript>~is',
          '<div id="fb-root"></div><script>window.fbAsyncInit=function(){FB.init({xfbml:true,version:\'v5.0\'});};(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src=\'https://connect.facebook.net/en_GB/sdk/xfbml.customerchat.js\';fjs.parentNode.insertBefore(js,fjs);}(document,\'script\',\'facebook-jssdk\'));</script><div class="fb-customerchat" attribution=setup_tool page_id="'.$config['messengerFBCode'].'" theme_color="'.$config['messengerFBColor'].'"'.($config['messengerFBGreeting']!=''?' logged_in_greeting="'.$config['messengerFBGreeting'].'" logged_out_greeting="'.$config['messengerFBGreeting'].'"':'').'></div>',
          $footer,1);
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
  if($config['options']{8}==1){
    $footer=preg_replace([
      '/<gdpr>/'
    ],[
      '<link rel="stylesheet" type="text/css" href="core/css/gdpr.css">'.
      '<script src="core/js/gdpr.js"></script>'.
      '<script>'.
        'gdprCookieNotice({'.
          'locale:`en`,'.
          'timeout:500,'.
          'expiration:30,'.
          'domain:`'.getDomain(URL).'`,'.
          'implicit:true,'.
          'statement:`'.URL.'page/Privacy-Policy/`,'.
          'performance:[`JSESSIONID`],'.
          'analytics:[`ga`]'.
        '});'.
      '</script>'
    ],$footer);
  }else
    $footer=preg_replace('~<gdpr>~is','',$footer,1);
}else
  $footer='You MUST include a meta_footer template';
$content.=$footer;
