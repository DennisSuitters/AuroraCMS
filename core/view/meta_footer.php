<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Meta Footer
 * @package    core/view/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(preg_match('/<block include=[\"\']?meta_footer.html[\"\']?>/',$template)&&file_exists(THEME.'/meta_footer.html')){
  $footer=file_get_contents(THEME.'/meta_footer.html');
  $sb=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `file`='notification' AND `active`=1 LIMIT 1");
  $sb->execute();
  $rb=$sb->fetch(PDO::FETCH_ASSOC);
  $footer=preg_replace([
    '/<print theme>/',
    '/<lightbox>/',
    '/<carousel>/',
    '/<gdpr>/',
    '/<map>/',
    '/<g-recaptchascript>/',
    '/<countdownscript>/',
    '/<forum>/',
    '/<banner>/',
    '/<a11y>/',
    '/<fomo>/'
  ],[
    THEME,
    $config['options'][5]==1?'<script defer async src="core/js/fancybox/fancybox.umd.js"></script>':'<script>document.addEventListener(`click`,function(event){if(event.target.closest(`.gallery-image`)){event.preventDefault();var img=event.target.closest(`.gallery-image`).getAttribute(`href`);var cap=event.target.closest(`.gallery-image`).getAttribute("data-caption");document.getElementById("figureimage").src=img;document.getElementById("figcaption").innerHTML=cap;}});</script>',
    isset($showCarousel)&&$showCarousel==true?'<script src="core/js/swiper/swiper-bundle.min.js"></script><script>var swiper=new Swiper(".auroraSwiper",{enable:true,direction:"'.($page['sliderDirection']==''?'horizontal':$page['sliderDirection']).'",effect:"'.($page['sliderEffect']==''?'slide':$page['sliderEffect']).'",loop:'.($page['sliderOptions'][1]==1?'true':'false').',speed:'.($page['sliderSpeed']==0?'300':$page['sliderSpeed']).',autoplay:{delay:'.($page['sliderAutoplayDelay']==0?'3000':$page['sliderAutoplayDelay']).',disableOnInteraction:'.($page['sliderOptions'][2]==1?'true':'false').',},'.($page['sliderOptions'][3]==1?'navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev",},':'').($page['sliderOptions'][4]==1?'pagination:{el:".swiper-pagination",},':'').($page['sliderOptions'][5]==1?'scrollbar:{el:".swiper-scrollbar",},':'').'});</script>':'',
    $config['options'][8]==1?'<link rel="stylesheet preload" type="text/css" href="core/js/gdpr/gdpr.css" as="style"><script src="core/js/gdpr/gdpr.js"></script><script>gdprCookieNotice({locale:`en`,timeout:500,expiration:30,domain:`'.getDomain(URL).'`,implicit:true,statement:`'.URL.'page/Privacy-Policy/`,performance:[`JSESSIONID`],analytics:[`ga`]});</script>':'',
    $config['options'][27]==1&&$config['geo_position']!=''&&$config['mapapikey']!=''&&$view=='contactus'?'<link rel="stylesheet preload" type="text/css" href="core/js/leaflet/leaflet.css" as="style"><script src="core/js/leaflet/leaflet.js"></script><script>var map=L.map("map").setView(['.$config['geo_position'].'],13);L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='.$config['mapapikey'].'",{attribution:`Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>`,maxZoom:18,id:"mapbox/streets-v11",tileSize:512,zoomOffset:-1,accessToken:`'.$config['mapapikey'].'`}).addTo(map);var marker=L.marker(['.$config['geo_position'].'],{draggable:false}).addTo(map);'.($config['business']==''?'':'var popupHtml=`<strong>'.$config['business'].'</strong>'.($config['address']==''?'':'<br><small>'.$config['address'].'<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country'].'</small>').'`;marker.bindPopup(popupHtml,{closeButton:false,closeOnClick:false,closeOnEscapeKey:false,autoClose:false}).openPopup();').'marker.off("click");</script>':'',
    stristr($content,'g-recaptcha')&&$config['reCaptchaClient']!=''&&$config['reCaptchaServer']!=''?'<script defer async src="https://www.google.com/recaptcha/api.js"></script><script>function resizeReCaptcha(){var width=document.querySelector(".g-recaptcha").offsetWidth;if(width<302){var scale=width / 302;}else{var scale=1;}document.querySelector(".g-recaptcha").setAttribute("style","transform:scale(`"+scale+"`)");document.querySelector(".g-recaptcha").setAttribute("style","-webkit-transform:scale(`"+scale+"`)");document.querySelector(".g-recaptcha").setAttribute("style","transform-origin:0 0");document.querySelector(".g-recaptcha").setAttribute("style","-webkit-transform-origin:0 0");};window.addEventListener("resize",resizeReCaptcha);resizeReCaptcha();</script>':'',
    isset($showCountdown)&&$showCountdown==true?'<script>function countdown(){var enddate=document.getElementById("countdownDateEnd").value;enddate=enddate.replace(" ","T")+"Z";if(enddate!=""){var countDownDate=new Date(enddate).getTime();var x=setInterval(function(){var now=new Date().getTime();var distance=countDownDate - now;var days=Math.floor(distance / (1000 * 60 * 60 * 24));var hours=Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));var minutes=Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));var seconds=Math.floor((distance % (1000 * 60)) / 1000);var days=clean0(days);var hours=clean0(hours);var minutes=clean0(minutes);var seconds=clean0(seconds);document.getElementById("countdownDays").innerHTML=days+"<small>Days</small>";document.getElementById("countdownHours").innerHTML=hours+"<small>Hours</small>";document.getElementById("countdownMinutes").innerHTML=minutes+"<small>Minutes</small>";document.getElementById("countdownSeconds").innerHTML=seconds+"<small>Seconds</small>";if(distance < 0){clearInterval(x);document.getElementById("countdowninfo").innerHTML="EXPIRED";}},1000);}else document.getElementById("countdowninfo").innerHTML="EXPIRED";}countdown();</script>':'',
    $view=='forum'&&(isset($_SESSION['uid'])&&$_SESSION['uid']>0)?'<link rel="stylesheet" type="text/css" href="core/js/summernote/summernote.min.css" media="all" as="style">'.
    '<Link rel="stylesheet" type="text/css" href="core/js/summernote/forum.min.css" media="all" as="style"><script src="core/js/jquery/jquery.min.js"></script><script src="core/js/summernote/summernote.min.js"></script>'.
      '<script src="core/js/summernote/plugin/emoji/emoji.js"></script>'.
      '<script>$(document).ready(function(){$(".note").summernote({height:"250px",disableUpload:true,fileExplorer:"",'.
//    'emoji:{url:"'.URL.'core/images/emojis/",},'. WIP, replace other emoji summernote plugin
      'popover:{image:[[`remove`,[`removeMedia`]],],link:[[`link`,[`linkDialogShow`,`unlink`]],],air:[]},toolbar:[[`font`,[`bold`,`italic`,`underline`,`clear`]],[`para`,[`ul`,`ol`]],'.
//    '[`emoji`,[`emoji`]],'. WIP, replace other emoji summernote plugin
      '[`insert`,[`picture`,`video`,`audio`,`link`,`hr`]],]});$(document).on("click","#notifications input[type=checkbox]",{},function(event){var id=$(this).data("dbid");var t=$(this).data("dbt");var c=$(this).data("dbc");var b=$(this).data("dbb");$.ajax({type:"GET",url:"core/toggle.php",data:{id:id,t:t,c:c,b:b}}).done(function(msg){});});});</script>':'',
    isset($rb['id'])&&$rb['id']!=0?'<script>if(!localStorage.banner'.$rb['id'].'Closed){fetch("core/banner.php",{method:"POST",headers:{"Content-type":"application/x-www-form-urlencoded;charset=UTF-8"},body:"lS='.$rb['id'].'"}).then(function(r){return r.text();}).then(function(data){var elem=document.createElement("div");elem.setAttribute("id","banner");elem.classList.add("'.($rb['heading']!=''?$rb['heading']:'banner'.$rb['id']).'");elem.innerHTML=data;document.body.appendChild(elem);});}</script>':'',
    $config['options'][1]==1?'<link rel="stylesheet preload" type="text/css" href="core/js/a11y/a11y.css" as="style"><script async defer src="core/js/a11y/a11y.js"></script><nav id="a11y-toolbar" class="a11y-toolbar-'.$config['a11yPosition'].'"><div class="a11y-toolbar-toggle"><button class="a11y-toolbar-link a11y-toolbar-toggle-link" href="javascript:void(0);" title="Accessibility Tools" aria-label="Open to select accessibility options to help using this website easier." tabindex="0"><span class="sr-only">Open toolbar</span><i class="i i-4x">a11y</i></button></div><div class="a11y-toolbar-overlay"><p class="a11y-toolbar-title"><i class="i i-4x toolbar-icon">a11y</i>Accessibility Options<button class="a11y-toolbar-close a11y-toolbar-toggle-link" title="Close" aria-label="Close"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="20" height="20"><path d="M 12,3.007143 10.992857,2 7,5.992857 3.0071429,2 2,3.007143 5.9928571,7 2,10.992857 3.0071429,12 7,8.007143 10.992857,12 12,10.992857 8.007143,7 Z"/></svg></button></p><ul class="a11y-toolbar-items a11y-tools row"><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-resize-font a11y-btn-resize-plus" data-action="resize-plus" data-action-group="resize" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-resize-plus</i></span><span class="a11y-toolbar-text">Increase Text</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-resize-font a11y-btn-resize-minus" data-action="resize-minus" data-action-group="resize" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-resize-minus</i></span><span class="a11y-toolbar-text">Decrease Text</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-background-group a11y-btn-seizure-safe" data-action="seizure-safe" data-action-group="schema" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-seizure-safe</i></span><span class="a11y-toolbar-text">Seizure Safe</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-background-group a11y-btn-adhd-friendly" data-action="adhd-friendly" data-action-group="schema" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-adhd-friendly</i></span><span class="a11y-toolbar-text">ADHD Friendly</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-background-group a11y-btn-dyslexic-friendly" data-action="dyslexic-friendly" data-action-group="schema" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-dyslexic-friendly</i></span><span class="a11y-toolbar-text">Dyslexic Friendly</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-background-group a11y-btn-grayscale" data-action="grayscale" data-action-group="schema" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-grayscale</i></span><span class="a11y-toolbar-text">Grayscale</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-background-group a11y-btn-high-contrast" data-action="high-contrast" data-action-group="schema" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-high-contrast</i></span><span class="a11y-toolbar-text">High Contrast</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-background-group a11y-btn-negative-contrast" data-action="negative-contrast" data-action-group="schema" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-negative-contrast</i></span><span class="a11y-toolbar-text">Negative Contrast</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-background-group a11y-btn-light-background" data-action="light-background" data-action-group="schema" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-light-background</i></span><span class="a11y-toolbar-text">Light Background</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-links-underline" data-action="links-underline" data-action-group="toggle" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-links-underline</i></span><span class="a11y-toolbar-text">Links Underline</span></button></li><li class="a11y-toolbar-item col-4"><button class="a11y-toolbar-link a11y-btn-reset" data-action="reset" tabindex="0"><span class="a11y-toolbar-icon"><i class="i i-4x">a11y-reset</i></span><span class="a11y-toolbar-text">Reset</span></button></li></ul></div></nav>':'',
    (!in_array($page['contentType'],['cart','checkout','courses','forum','orders','proofs','settings'])&&$config['fomo']==1?'<div class="fomo"><div class="fomo-image hidewhenempty"></div><div class="fomo-text"><div class="fomo-who hidewhenepmty"></div><div class="fomo-heading"></div><div class="fomo-timeago hidewhenempty"></div></div></div>'.
    '<script>'.
      'function showfomo(){'.
        'var go=Math.floor((Math.random()*5)+1);'.
        'if(go<4){'.
          'fetch(`core/fomo.php`,{'.
            'method:"POST",'.
            'headers:{'.
              '"Content-type":"application/x-www-form-urlencoded;charset=UTF-8"'.
            '}'.
          '}).then('.
            'res=>res.json()'.
          ').then('.
            'rs=>{'.
              'if(rs.image!=``){'.
                'document.querySelector(`.fomo-image`).innerHTML=(rs.image!=``?`<img src="`+rs.image+`" alt="`+rs.heading+`">`:``);'.
              '}else{'.
                'document.querySelector(`.fomo-image`).innerHTML=``;'.
              '}'.
                'document.querySelector(`.fomo`).classList.remove(`fomo-rounded`,`fomo-separated`,`fomo-giant`);'.
                'document.querySelector(`.fomo`).classList.add(`fomo-`+rs.style);'.
                'document.querySelector(`.fomo`).setAttribute(`data-url`,rs.url);'.
                'document.querySelector(`.fomo-who`).innerHTML=rs.who;'.
                'document.querySelector(`.fomo-heading`).innerHTML=rs.heading;'.
                'document.querySelector(`.fomo-timeago`).innerHTML=rs.timeago;'.
                'document.querySelector(`.fomo`).classList.add(rs.in);'.
                'document.querySelector(`.fomo`).classList.remove(rs.out);'.
                'setTimeout(()=>{'.
                  'document.querySelector(`.fomo`).classList.add(rs.out);'.
                  'document.querySelector(`.fomo`).classList.remove(rs.in);'.
                  'setTimeout(showfomo,5000);'.
                '},5000);'.
//              '}else{'.
//                'setTimeout(showfomo,5000);'.
//              '}'.
            '});'.
          '}else{'.
            'setTimeout(showfomo,5000);'.
          '}'.
        '}'.
        'document.addEventListener("click",function(event){'.
          'if(event.target.closest(`.fomo`)){'.
            'location.href=`'.URL.'`+document.querySelector(`.fomo`).getAttribute(`data-url`);'.
          '}'.
        '});'.
        'setTimeout(showfomo,1000);'.
      '</script>':'')
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
          '<script>initChat();</script>',
        $footer);
      }
  	}else
      $footer=preg_replace('/<chatscript>/','',$footer);
  }else
    $footer=preg_replace('/<chatscript>/','',$footer,1);
}else
  $footer='You MUST include a meta_footer template';
$content.=$footer;
