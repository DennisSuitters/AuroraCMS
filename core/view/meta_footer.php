<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Meta Footer
 * @package    core/view/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Adjust code to use ResponsiveSlides are tiny, more versatilve Content Slider.
 * @changes    v0.1.2 Add Parsing of Google reCaptcha.
 * @changes    v0.1.2 Tidy up code and reduce footprint.
 */
if(preg_match('/<block include=[\"\']?meta_footer.html[\"\']?>/',$template)&&file_exists(THEME.'/meta_footer.html')){
  $footer=file_get_contents(THEME.'/meta_footer.html');
  $footer=preg_replace([
    '/<print theme>/',
    '/<carousel>/',
    '/<gdpr>/',
    '/<map>/',
    '/<g-recaptchascript>/'
  ],[
    THEME,
    isset($showCarousel)&&$showCarousel==true?
      '<script src="core/js/responsiveslides/responsiveslides.min.js"></script>'.
      '<script>'.
        '$(function(){'.
          '$(".slider").responsiveSlides({'.
            'auto:true,'.             // Boolean: Animate automatically, true or false
            'speed:500,'.             // Integer: Speed of the transition, in milliseconds
            'timeout:4000,'.          // Integer: Time between slide transitions, in milliseconds
            'pager:false,'.           // Boolean: Show pager, true or false
            'nav:true,'.              // Boolean: Show navigation, true or false
            'random:false,'.          // Boolean: Randomize the order of the slides, true or false
            'pause:false,'.           // Boolean: Pause on hover, true or false
            'pauseControls:true,'.    // Boolean: Pause when hovering controls, true or false
            'prevText:"Previous",'.   // String: Text for the "previous" button
            'nextText:"Next",'.       // String: Text for the "next" button
            'maxwidth:"",'.           // Integer: Max-width of the slideshow, in pixels
            'namespace:"slider-btns",'.
            'navContainer:"",'.       // Selector: Where controls should be appended to, default is after the "ul"
            'manualControls:"",'.     // Selector: Declare custom pager navigation
            'before:function(){},'.   // Function: Before callback
            'after:function(){}'.     // Function: After callback
          '});'.
        '});'.
      '</script>':'',
    $config['options'][8]==1?'<link rel="stylesheet" type="text/css" href="core/js/gdpr/gdpr.css"><script defer async src="core/js/gdpr/gdpr.js"></script><script>gdprCookieNotice({locale:`en`,timeout:500,expiration:30,domain:`'.getDomain(URL).'`,implicit:true,statement:`'.URL.'page/Privacy-Policy/`,performance:[`JSESSIONID`],analytics:[`ga`]});</script>':'',
    $config['options'][27]==1&&$config['geo_position']!=''&&$config['mapapikey']!=''&&$view=='contactus'?'<link rel="stylesheet" type="text/css" href="core/js/leaflet/leaflet.css"><script src="core/js/leaflet/leaflet.js"></script><script>var map=L.map("map").setView(['.$config['geo_position'].'],13);L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='.$config['mapapikey'].'",{attribution:`Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>`,maxZoom:18,id:"mapbox/streets-v11",tileSize:512,zoomOffset:-1,accessToken:`'.$config['mapapikey'].'`}).addTo(map);var marker=L.marker(['.$config['geo_position'].'],{draggable:false}).addTo(map);'.($config['business']==''?'':'var popupHtml=`<strong>'.$config['business'].'</strong>'.($config['address']==''?'':'<br><small>'.$config['address'].'<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country'].'</small>').'`;marker.bindPopup(popupHtml,{closeButton:false,closeOnClick:false,closeOnEscapeKey:false,autoClose:false}).openPopup();').'marker.off("click");</script>':'',
    stristr($html,'<g-recaptchascript>')&&$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<script defer async src="https://www.google.com/recaptcha/api.js"></script><script>function resizeReCaptcha(){var width=$(".g-recaptcha" ).parent().width();if(width<302){var scale=width/302;}else{var scale=1;}$(".g-recaptcha").css("transform","scale("+scale+")");$(".g-recaptcha").css("-webkit-transform","scale("+scale+")");$(".g-recaptcha").css("transform-origin","0 0");$(".g-recaptcha").css("-webkit-transform-origin","0 0");};$(document).ready(function(){$(window).on("resize",function(){resizeReCaptcha();});resizeReCaptcha();});</script>':''
  ],$footer);
  if(isset($_SESSION['rank'])&&$_SESSION['rank']<100){
    if($config['options'][13]==1){
  		if($config['options'][14]==1&&$config['messengerFBCode']!=''){
  			$footer=preg_replace(
          '/<chatscript>/',
          '<div id="fb-root"></div><script>window.fbAsyncInit=function(){FB.init({xfbml:true,version:`v5.0`});};(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src=`https://connect.facebook.net/en_GB/sdk/xfbml.customerchat.js`;fjs.parentNode.insertBefore(js,fjs);}(document,`script`,`facebook-jssdk`));</script><div class="fb-customerchat" attribution=setup_tool page_id="'.$config['messengerFBCode'].'" theme_color="'.$config['messengerFBColor'].'"'.($config['messengerFBGreeting']!=''?' logged_in_greeting="'.$config['messengerFBGreeting'].'" logged_out_greeting="'.$config['messengerFBGreeting'].'"':'').'></div>'
        ,$footer);
  		}else{
  			$footer=preg_replace(
          '/<chatscript>/',
          '<script>function updateChat(){chatTimer=null;$.ajax({type:"POST",url:"core/chat.php",data:{sid:$("#chatsid").val()}}).done(function(data){if(data!="none"){$("#chatScreen").html(data);if(data!="")$("#chatBody").removeClass("d-none");document.getElementById("chatScreen").scrollTop=9999999;}});clearTimeout(chatTimer);chatTimer=setTimeout(function(){updateChat();},2500);}function initChat(){chatTimer=null;$.ajax({type:"POST",url:"core/chat.php",data:{sid:$("#chatsid").val()}}).done(function(data){if(data!="none"){$("#chatScreen").html(data);if(data!=""){$("#chatBody").removeClass("d-none");$(".chat-close,.chat-open").toggleClass("d-none");}if($("#chatBody").hasClass("d-none")){clearTimeout(chatTimer);}else{$(".chathideme,.chatunhideme").toggleClass("d-none");clearTimeout(chatTimer);}}document.getElementById("chatScreen").scrollTop=9999999;});}$(document).ready(function(){initChat();$("#chatHeader").click(function(e){$("#chatBody,.chat-close,.chat-open").toggleClass("d-none");if($("#chatBody").hasClass("d-none"))clearTimeout(chatTimer);});$("#startChat").click(function(){$.ajax({type:"POST",url:"core/chat.php",data:{sid:$("#chatsid").val(),who:$("#chatwho").val(),name:$("#chatName").val(),email:$("#chatEmail").val(),message:"|*|*|*|*|*|"}}).done(function(data){if(data=="available"){$("#chatScreen").html(`<ul><li class="admin"><p>Hello `+$("#chatName").val()+`, how can we assist you?</p></li></ul>`);}else{$("#chatScreen").html(data);}document.getElementById("chatScreen").scrollTop=9999999;$("#chatMessage").val("");$(".chathideme,.chatunhideme").toggleClass("d-none");clearTimeout(chatTimer);});});$("#chatButton").click(function(){$.ajax({type:"POST",url:"core/chat.php",data:{sid:$("#chatsid").val(),who:$("#chatwho").val(),name:$("#chatName").val(),email:$("#chatEmail").val(),message:$("#chatMessage").val()}}).done(function(data){$("#chatScreen").html(data);document.getElementById("chatScreen").scrollTop=9999999;$("#chatMessage").val("");clearTimeout(chatTimer);chatTimer=setTimeout(function(){updateChat();},2500);});});});</script>',
        $footer);
      }
  	}else$footer=preg_replace('/<chatscript>/','',$footer);
  }else$footer=preg_replace('/<chatscript>/','',$footer,1);
}else$footer='You MUST include a meta_footer template';
$content.=$footer;
