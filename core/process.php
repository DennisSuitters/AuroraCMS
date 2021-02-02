<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Process Pages
 * @package    core/process.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/db.php';
if(isset($headerType))header($headerType);
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
if(file_exists(THEME.'/theme.ini'))
  $theme=parse_ini_file(THEME.'/theme.ini',TRUE);
else{
  echo'A Website Theme has not been set.';
  die();
}
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$ti=time();
$show=$html=$head=$content=$foot='';
$css=THEME.'/css/';
$favicon=$shareImage=FAVICON;
$noimage=NOIMAGE;
$noavatar=NOAVATAR;
if($view=='page'){
  $sp=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `contentType`=:contentType AND LOWER(`title`)=LOWER(:title)");
  $sp->execute([
    ':contentType'=>$view,
    ':title'=>str_replace('-',' ',$args[0])
  ]);
}else{
  $sp=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `contentType`=:contentType");
  $sp->execute([
    ':contentType'=>$view
  ]);
}
$page=$sp->fetch(PDO::FETCH_ASSOC);
$seoTitle=$page['seoTitle'];
$metaRobots=$page['metaRobots'];
$seoCaption=$page['seoCaption'];
$seoDescription=$page['seoDescription'];
$seoKeywords=$page['seoKeywords'];
$pu=$db->prepare("UPDATE `".$prefix."menu` SET `views`=`views`+1 WHERE `id`=:id");
$pu->execute([
  ':id'=>$page['id']
]);
if(isset($act)&&$act=='logout')
  require'core/login.php';
require'core/cart_quantity.php';
$status=isset($_SESSON['rank'])&&$_SESSION['rank']>699?"%":"published";
if($config['php_options'][4]==1){
  $sb=$db->prepare("SELECT * FROM `".$prefix."iplist` WHERE `ip`=:ip");
  $sb->execute([
    ':ip'=>$ip
  ]);
  if($sb->rowCount()>0){
    $sbr=$sb->fetch(PDO::FETCH_ASSOC);
    echo'The IP "<strong>'.$ip.'</strong>" has been Blacklisted for suspicious activity.';
    die();
  }
}
if($config['comingsoon'][0]==1&&(isset($_SESSION['rank'])&&$_SESSION['rank']<400)){
    if(file_exists(THEME.'/comingsoon.html'))
      $template=file_get_contents(THEME.'/comingsoon.html');
    else{
      require'core/view/comingsoon.php';
      die();
    }
}elseif($config['maintenance'][0]==1&&(isset($_SESSION['rank'])&&$_SESSION['rank']<400)){
  if(file_exists(THEME.'/maintenance.html'))
    $template=file_get_contents(THEME.'/maintenance.html');
  else{
  	require'core/view/maintenance.php';
    die();
  }
}elseif(file_exists(THEME.'/'.$view.'.html'))
  $template=file_get_contents(THEME.'/'.$view.'.html');
elseif(file_exists(THEME.'/default.html'))
  $template=file_get_contents(THEME.'/default.html');
else
  $template=file_get_contents(THEME.'/content.html');
$newDom=new DOMDocument();
@$newDom->loadHTML($template);
$tag=$newDom->getElementsByTagName('block');
foreach($tag as$tag1){
  $include=$tag1->getAttribute('include');
  $inbed=$tag1->getAttribute('inbed');
  if($include!=''){
    $include=rtrim($include,'.html');
    $html=file_exists(THEME.'/'.$include.'.html')?file_get_contents(THEME.'/'.$include.'.html'):'';
    if(file_exists(THEME.'view/'.$include.'.php'))
      require THEME.'view/'.$include.'.php';
    elseif(file_exists('core/view/'.$include.'.php'))
      require'core/view/'.$include.'.php';
    else
      require'core/view/content.php';
    $req=$include;
  }
  if($inbed!=''){
    preg_match('/<block inbed="'.$inbed.'">([\w\W]*?)<\/block>/',$template,$matches);
    $html=isset($matches[1])?$matches[1]:'';
    if($view=='cart')
      $inbed='cart';
    if($view=='sitemap')
      $inbed='sitemap';
    if($view=='settings')
      $inbed='settings';
    if($view=='page')
      $inbed='page';
    if(file_exists(THEME.'view/'.$inbed.'.php'))
      require THEME.'view/'.$inbed.'.php';
    elseif(file_exists('core/view/'.$inbed.'.php'))
      require'core/view/'.$inbed.'.php';
    else
      require'core/view/content.php';
    $req=$inbed;
  }
}
if(!isset($contentTime))
  $contentTime=($page['eti']>$config['ti']?$page['eti']:$config['ti']);
if(!isset($canonical)||$canonical=='')
  $canonical=($view=='index'?URL:URL.$view.'/');
if($seoTitle==''){
  if($page['seoTitle']=='')
    $seoTitle=$page['title'];
  else
    $seoTitle=$page['seoTitle'];
}
if($seoTitle=='')
  $seoTitle.=$view=='index'?'Home':'';
$seoTitle.=$view=='index'?' | '.$config['business']:'';
if($metaRobots==''){
  if($page['metaRobots']=='')
    $metaRobots=$config['metaRobots'];
  elseif(in_array($view,['proofs','orders','settings'],true))
    $metaRobots='noindex,nofollow';
  else
    $metaRobots=$page['metaRobots'];
}
if($seoCaption=='')$seoCaption=$page['seoCaption'];
if($seoDescription==''){
  if($page['seoDescription']=='')
    $seoDescription=substr(strip_tags($page['notes']),0,160);
  else
    $seoDescription=$page['seoDescription'];
}
if($seoKeywords==''){
  if($page['seoKeywords']=='')
    $seoKeywords=$config['seoKeywords'];
  else
    $seoKeywords=$page['seoKeywords'];
}
$rss='';
if(isset($args[0])){
  if($args[0]!='index'||$args[0]!='bookings'||$args[0]!='contactus'||$args[0]!='cart'||$args[0]!='proofs'||$args[0]!='settings'||$args[0]!='accounts'){}else
    $rss=$view;
}
$head=preg_replace([
  '/<print config=[\"\']?business[\"\']?>/',
  '/<print theme=[\"\']?title[\"\']?>/',
  '/<print theme=[\"\']?creator[\"\']?>/',
  '/<print theme=[\"\']?creatorurl[\"\']?>/',
  '/<print meta=[\"\']?metaRobots[\"\']?>/',
  '/<print meta=[\"\']?seoTitle[\"\']?>/',
  '/<print meta=[\"\']?seoCaption[\"\']?>/',
  '/<print meta=[\"\']?seoDescription[\"\']?>/',
  '/<print meta=[\"\']?seoAbstract[\"\']?>/',
  '/<print meta=[\"\']?seoSummary[\"\']?>/',
  '/<print meta=[\"\']?seoKeywords[\"\']?>/',
  '/<print meta=[\"\']?dateAtom[\"\']?>/',
  '/<print meta=[\"\']?canonical[\"\']?>/',
  '/<print meta=[\"\']?url[\"\']?>/',
  '/<print meta=[\"\']?view[\"\']?>/',
  '/<print meta=[\"\']?rss[\"\']?>/',
  '/<print meta=[\"\']?ogType[\"\']?>/',
  '/<print meta=[\"\']?shareImage[\"\']?>/',
  '/<print meta=[\"\']?favicon[\"\']?>/',
  '/<print microid>/',
  '/<print meta=[\"\']?author[\"\']?>/',
  '/<print theme>/',
  '/<print site_verifications>/',
	'/<print geo>/',
  '/<print development>/',
  '/<meta_helper>/'
],[
  trim(htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($metaRobots,ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($seoTitle,ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($seoCaption,ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($seoDescription,ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($seoCaption,ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($seoDescription,ENT_QUOTES,'UTF-8')),
  trim(htmlspecialchars($seoKeywords,ENT_QUOTES,'UTF-8')),
  $contentTime,
  $canonical,
  URL,
  $view,
  URL.'rss/'.$rss.'/',
  $view=='inventory'?'product':$view,
  stristr($shareImage,'noimage')?FAVICON:$shareImage,
  FAVICON,
  microid($config['email'],$canonical),
  isset($r['name'])?$r['name']:$config['business'],
  THEME,
  ($config['ga_verification']!=''?'<meta name="google-site-verification" content="'.$config['ga_verification'].'">':'').
    ($config['seo_msvalidate']!='<meta name="msvalidate.01" content="'.$config['seo_msvalidate'].'">'?'':'').
    ($config['seo_yandexverification']!='<meta name="yandex-verification" content="'.$config['seo_yandexverification'].'">'?'':'').
    ($config['seo_alexaverification']!=''?'<meta name="alexaVerifyID" content="'.$config['seo_alexaverification'].'">':'').
    ($config['seo_pinterestverify']!=''?'<meta name="p:domain_verify" content="'.$config['seo_pinterestverify'].'">':''),
  ($config['geo_region']!=''?'<meta name="geo.region" content="'.$config['geo_region'].'">':'').
    ($config['geo_placename']!=''?'<meta name="geo.placename" content="'.$config['geo_placename'].'">':'').
    ($config['geo_position']!=''?'<meta name="geo.position" content="'.$config['geo_position'].'"><meta name="ICBM" content="'.$config['geo_position'].'">':''),
  ($config['development'][0]==1&&$_SESSION['rank']>999?'<div class="development">'.
    '<nav>'.
      '<ul>'.
        '<li>Meta'.
          '<ul>'.
            '<li>'.
              '<input id="showMetaTags" type="checkbox" onclick="$(`head`).toggleClass(`showMetaTags`);"><label for="showMetaTags">Show Meta Tags</label>'.
            '</li>'.
          '</ul>'.
        '</li>'.
        '<li>Images'.
          '<ul>'.
            '<li>'.
              '<input id="dev-hideImages" type="checkbox" onclick="$(`body`).toggleClass(`dev-hideImages`);"><label for="dev-hideImages">Hide Images</label><br>'.
              '<input id="dev-showImages" type="checkbox" onclick="$(`body`).toggleClass(`dev-showImages`);"><label for="dev-showImages">Show Images</label><br>'.
              '<input id="dev-showEmptyAlt" type="checkbox" onclick="$(`body`).toggleClass(`dev-showEmptyAlt`);"><label for="dev-showEmptyAlt">Highlight Images with Empty Alt Tags</label>'.
            '</li>'.
          '</ul>'.
        '</li>'.
        '<li>Forms'.
          '<ul>'.
            '<li>'.
              '<div>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form" rel="noopener nofollow" title="Moz Reference for &lt;form&gt;">?</a><input id="dev-showForm" type="checkbox" onclick="$(`body`).toggleClass(`dev-showForm`);"><label for="dev-showForm" title="&lt;form&gt;">Show Form</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button" rel="noopener nofollow" title="Moz Reference for &lt;button&gt;">?</a><input id="dev-showFormButton" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormButton`);"><label for="dev-showFormButton" title="&lt;button&gt;">Show Button</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/datalist" rel="noopener nofollow" title="Moz Reference for &lt;datalist&gt;">?</a><input id="dev-showFormDatalist" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormDatalist`);"><label for="dev-showFormDatalist" title="&lt;datalist&gt;">Show Data List</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'checkbox\'&gt;">?</a><input id="dev-showFormInputCheckbox" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputCheckbox`);"><label for="dev-showFormInputCheckbox" title="&lt;input type=\'checkbox\'&gt;">Show Checkboxes</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'color\'&gt;">?</a><input id="dev-showFormInputColor" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputColor`);"><label for="dev-showFormInputColor" title="&lt;input type=\'color\'&gt;">Show Color Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'date\'&gt;">?</a><input id="dev-showFormInputDate" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputDate`);"><label for="dev-showFormInputDate" title="&lt;input type=\'date\'&gt;">Show Date Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/datetime-local" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'datetime-local\'&gt;">?</a><input id="dev-showFormInputDateTimeLocal" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputDateTimeLocal`);"><label for="dev-showFormInputDateTimeLocal" title="&lt;input type=\'datetime-local\'&gt;">Show DateTime-Local Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/email" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'email\'&gt;">?</a><input id="dev-showFormInputEmail" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputEmail`);"><label for="dev-showFormInputEmail" title="&lt;input type=\'email\'&gt;">Show Email Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'file\'&gt;">?</a><input id="dev-showFormInputFile" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputFile`);"><label for="dev-showFormInputFile" title="&lt;input type=\'file\'&gt;">Show File Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/hidden" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'hidden\'&gt;">?</a><input id="dev-showFormInputHidden" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputHidden`);"><label for="dev-showFormInputHidden" title="&lt;input type=\'hidden\'&gt;">Show Hidden Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/image" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'image\'&gt;">?</a><input id="dev-showFormInputImage" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputImage`);"><label for="dev-showFormInputImage" title="&lt;input type=\'image\'&gt;">Show Image Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/month" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'month\'&gt;">?</a><input id="dev-showFormInputMonth" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputMonth`);"><label for="dev-showFormInputMonth" title="&lt;input type=\'month\'&gt;">Show Month Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/number" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'number\'&gt;">?</a><input id="dev-showFormInputNumber" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputNumber`);"><label for="dev-showFormInputNumber" title="&lt;input type=\'number\'&gt;">Show Number Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/radio" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'radio\'&gt;">?</a><input id="dev-showFormInputRadio" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputRadio`);"><label for="dev-showFormInputRadio" title="&lt;input type=\'radio\'&gt;">Show Radio Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/range" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'range\'&gt;">?</a><input id="dev-showFormInputRange" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputRange`);"><label for="dev-showFormInputRange" title="&lt;input type=\'range\'&gt;">Show Range Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/reset" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'reset\'&gt;">?</a><input id="dev-showFormInputReset" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputReset`);"><label for="dev-showFormInputReset" title="&lt;input type=\'reset\'&gt;">Show Reset Inputs</label>'.
              '</div>'.
              '<div>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'search\'&gt;">?</a><input id="dev-showFormInputSearch" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputSearch`);"><label for="dev-showFormInputSearch" title="&lt;input type=\'search\'&gt;">Show Search Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/submit" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'submit\'&gt;">?</a><input id="dev-showFormInputSubmit" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputSubmit`);"><label for="dev-showFormInputSubmit" title="&lt;input type=\'submit\'&gt;">Show Submit Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/tel" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'tel\'&gt;">?</a><input id="dev-showFormInputTel" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputTel`);"><label for="dev-showFormInputTel" title="&lt;input type=\'tel\'&gt;">Show Telephone Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'text\'&gt;">?</a><input id="dev-showFormInputText" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputText`);"><label for="dev-showFormInputText" title="&lt;input type=\'text\'&gt;">Show Text Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/time" rel="noopener nofollow" title="Moz Reference for &lt;input type\'time\'&gt;">?</a><input id="dev-showFormInputTime" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputTime`);"><label for="dev-showFormInputTime" title="&lt;input type=\'time\'&gt;">Show Time Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/label" rel="noopener nofollow" title="Moz Reference for &lt;label&gt;">?</a><input id="dev-showFormLabel" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormLabel`);"><label for="dev-showFormLabel" title="&lt;label&gt;">Show Labels</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meter" rel="noopener nofollow" title="Moz Reference for &lt;meter&gt;">?</a><input id="dev-showMeter" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMeter`);"><label for="dev-showMeter" title="&lt;meter&gt;">Show Meter</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/optgroup" rel="noopener nofollow" title="Moz Reference for &lt;optgroup&gt;">?</a><input id="dev-showFormOptgroup" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormOptgroup`);"><label for="dev-showFormOptgroup" title="&lt;optgroup&gt;">Show Optgroup</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/option" rel="noopener nofollow" title="Moz Reference for &lt;option&gt;">?</a><input id="dev-showFormOption" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormOption`);"><label for="dev-showFormOption" title="&lt;option&gt;">Show Option</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/output" rel="noopener nofollow" title="Moz Reference for &lt;output&gt;">?</a><input id="dev-showOutput" type="checkbox" onclick="$(`body`).toggleClass(`dev-showOutput`);"><label for="dev-showOutput" title="&lt;output&gt;">Show Output</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/progress" rel="noopener nofollow" title="Moz Reference for &lt;progress&gt;">?</a><input id="dev-showProgress" type="checkbox" onclick="$(`body`).toggleClass(`dev-showProgress`);"><label for="dev-showProgress" title="&lt;progress&gt;">Show Progress</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/select" rel="noopener nofollow" title="Moz Reference for &lt;select&gt;">?</a><input id="dev-showFormSelect" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormSelect`);"><label for="dev-showFormSelect" title="&lt;select&gt;">Show Select</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea" rel="noopener nofollow" title="Moz Reference for &lt;textarea&gt;">?</a><input id="dev-showFormTextarea" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormTextarea`);"><label for="dev-showFormTextarea" title="&lt;textarea&gt;">Show Textarea\'s</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/url" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'url\'&gt;">?</a><input id="dev-showFormInputUrl" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputUrl`);"><label for="dev-showFormInputUrl" title="&lt;input type=\'url\'&gt;">Show URL Inputs</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/week" rel="noopener nofollow" title="Moz Reference for &lt;input type=\'week\'&gt;">?</a><input id="dev-showFormInputWeek" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFormInputWeek`);"><label for="dev-showFormInputWeek" title="&lt;input type=\'week\'&gt;">Show Week Inputs</label>'.
              '</div>'.
            '</li>'.
          '</ul>'.
        '</li>'.
        '<li>Tables'.
          '<ul>'.
            '<li>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/table" rel="noopener nofollow" title="Moz Reference for &lt;table&gt;">?</a><input id="dev-showTable" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTable`);"><label for="dev-showTable" title="&lt;table&gt;">Show Table</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/caption" rel="noopener nofollow" title="Moz Reference for &lt;caption&gt;">?</a><input id="dev-showTableCaption" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableCaption`);"><label for="dev-showTableCaption" title="&lt;caption&gt;">Show Caption</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/col" rel="noopener nofollow" title="Moz Reference for &lt;col&gt;">?</a><input id="dev-showTableCol" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableCol`);"><label for="dev-showTableCol" title="&lt;col&gt;">Show Column</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/colgroup" rel="noopener nofollow" title="Moz Reference for &lt;colgroup&gt;">?</a><input id="dev-showTableColgroup" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableColgroup`);"><label for="dev-showTableColgroup" title="&lt;colgoup&gt;">Show Column Group</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/tbody" rel="noopener nofollow" title="Moz Reference for &lt;tbody&gt;">?</a><input id="dev-showTableTbody" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableTbody`);"><label for="dev-showTableTbody" title="&lt;tbody&gt;">Show Body</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/td" rel="noopener nofollow" title="Moz Reference for &lt;td&gt;">?</a><input id="dev-showTableTd" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableTd`);"><label for="dev-showTableTd" title="&lt;td&gt;">Show Data Cell</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/tfoot" rel="noopener nofollow" title="Moz Reference for &lt;tfoot&gt;">?</a><input id="dev-showTableTfoot" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableTfoot`);"><label for="dev-showTableTfoot" title="&lt;tfoot&gt;">Show Foot</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/th" rel="noopener nofollow" title="Moz Reference for &lt;th&gt;">?</a><input id="dev-showTableTh" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableTh`);"><label for="dev-showTableTh" title="&lt;th&gt;">Show Head Row</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/thead" rel="noopener nofollow" title="Moz Reference for &lt;thead&gt;">?</a><input id="dev-showTableThead" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableThead`);"><label for="dev-showTableThead" title="&lt;thead&gt;">Show Table Head</label><br>'.
              '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/tr" rel="noopener nofollow" title="Moz Reference for &lt;tr&gt;">?</a><input id="dev-showTableTr" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTableTr`);"><label for="dev-showTableTr" title="&lt;tr&gt;">Show Row</label>'.
            '</li>'.
          '</ul>'.
        '</li>'.
        '<li>Elements'.
          '<ul>'.
            '<li>'.
              '<div>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/address" rel="noopener nofollow" title="Moz Reference for &lt;address&gt;">?</a><input id="dev-showAddress" type="checkbox" onclick="$(`body`).toggleClass(`dev-showAddress`);"><label for="dev-showAddress" title="&lt;address&gt;">Show Address</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/abbr" rel="noopener nofollow" title="Moz Reference for &lt;abbr&gt;">?</a><input id="dev-showAbbr" type="checkbox" onclick="$(`body`).toggleClass(`dev-showAbbr`);"><label for="dev-showAbbr" title="&lt;abbr&gt;">Show Abbreviation</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a" rel="noopener nofollow" title="Moz Reference for &lt;a&gt;">?</a><input id="dev-showAnchor" type="checkbox" onclick="$(`body`).toggleClass(`dev-showAnchor`);"><label for="dev-showAnchor" title="&lt;a&gt;">Show Anchor (Link)</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/area" rel="noopener nofollow" title="Moz Reference for &lt;area&gt;">?</a><input id="dev-showArea" type="checkbox" onclick="$(`body`).toggleClass(`dev-showArea`);"><label for="dev-showArea" title="&lt;area&gt;">Show Area</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/article" rel="noopener nofollow" title="Moz Reference for &lt;article&gt;">?</a><input id="dev-showArticle" type="checkbox" onclick="$(`body`).toggleClass(`dev-showArticle`);"><label for="dev-showArticle" title="&lt;article&gt;">Show Article</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/aside" rel="noopener nofollow" title="Moz Reference for &lt;aside&gt;">?</a><input id="dev-showAside" type="checkbox" onclick="$(`body`).toggleClass(`dev-showAside`);"><label for="dev-showAside" title="&lt;aside&gt;">Show Aside</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/audio" rel="noopener nofollow" title="Moz Reference for &lt;audio&gt;">?</a><input id="dev-showAudio" type="checkbox" onclick="$(`body`).toggleClass(`dev-showAudio`);"><label for="dev-showAudio" title="&lt;audio&gt;">Show Audio</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/strong" rel="noopener nofollow" title="Moz Reference for &lt;strong&gt;">?</a><input id="dev-showStrong" type="checkbox" onclick="$(`body`).toggleClass(`dev-showStrong`);"><label for="dev-showBold" title="&lt;strong&gt;">Show Strong</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/bdi" rel="noopener nofollow" title="Moz Reference for &lt;bdi&gt;">?</a><input id="dev-showBdi" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBdi`);"><label for="dev-showBdi" title="&lt;bdi&gt;">Show BDI</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/bdo" rel="noopener nofollow" title="Moz Reference for &lt;bdo&gt;">?</a><input id="dev-showBdo" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBdo`);"><label for="dev-showBdo" title="&lt;bdo&gt;">Show BDO</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/blockquote" rel="noopener nofollow" title="Moz Reference for &lt;blockquote&gt;">?</a><input id="dev-showBlockquote" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBlockquote`);"><label for="dev-showBlockquote" title="&lt;blockquote&gt;">Show Blockquote</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/canvas" rel="noopener nofollow" title="Moz Reference for &lt;canvas&gt;">?</a><input id="dev-showCanvas" type="checkbox" onclick="$(`body`).toggleClass(`dev-showCanvas`);"><label for="dev-showCanvas" title="&lt;canvas&gt;">Show Canvas</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/cite" rel="noopener nofollow" title="Moz Reference for &lt;cite&gt;">?</a><input id="dev-showCite" type="checkbox" onclick="$(`body`).toggleClass(`dev-showCite`);"><label for="dev-showCite" title="&lt;cite&gt;">Show Citation</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/code" rel="noopener nofollow" title="Moz Reference for &lt;code&gt;">?</a><input id="dev-showCode" type="checkbox" onclick="$(`body`).toggleClass(`dev-showCode`);"><label for="dev-showCode" title="&lt;code&gt;">Show Code</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dd" rel="noopener nofollow" title="Moz Reference for &lt;dd&gt;">?</a><input id="dev-showDd" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDd`);"><label for="dev-showDd" title="&lt;dd&gt;">Show Description/Definition</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/del" rel="noopener nofollow" title="Moz Reference for &lt;del&gt;">?</a><input id="dev-showDel" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDel`);"><label for="dev-showDel" title="&lt;del&gt;">Show Deleted</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details" rel="noopener nofollow" title="Moz Reference for &lt;details&gt;">?</a><input id="dev-showDetails" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDetails`);"><label for="dev-showDetails" title="&lt;details&gt;">Show Details</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dfn" rel="noopener nofollow" title="Moz Reference for &lt;dfn&gt;">?</a><input id="dev-showDfn" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDfn`);"><label for="dev-showDfn" title="&lt;dfn&gt;">Show Definition</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/div" rel="noopener nofollow" title="Moz Reference for &lt;div&gt;">?</a><input id="dev-showDiv" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDiv`);"><label for="dev-showDiv" title="&lt;div&gt;">Show Div</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dl" rel="noopener nofollow" title="Moz Reference for &lt;dl&gt;">?</a><input id="dev-showDl" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDl`);"><label for="dev-showDl" title="&lt;dl&gt;">Show Description List</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dt" rel="noopener nofollow" title="Moz Reference for &lt;dt&gt;">?</a><input id="dev-showDt" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDt`);"><label for="dev-showDt" title="&lt;dt&gt;">Show Description Title</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/em" rel="noopener nofollow" title="Moz Reference for &lt;em&gt;">?</a><input id="dev-showEm" type="checkbox" onclick="$(`body`).toggleClass(`dev-showEm);"><label for="dev-showEm" title="&lt;em&gt;">Show Emphasis</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/embed" rel="noopener nofollow" title="Moz Reference for &lt;embed&gt;">?</a><input id="dev-showEmbed" type="checkbox" onclick="$(`body`).toggleClass(`dev-showEmbed`);"><label for="dev-showEmbed" title="&lt;embed&gt;">Show Embed</label>'.
              '</div>'.
              '<div>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/fieldset" rel="noopener nofollow" title="Moz Reference for &lt;fieldset&gt;">?</a><input id="dev-showFieldset" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFieldset`);"><label for="dev-showFieldset" title="&lt;fieldset&gt;">Show Fieldset</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/figcaption" rel="noopener nofollow" title="Moz Reference for &lt;figcaption&gt;">?</a><input id="dev-showFigCaption" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFigCaption`);"><label for="dev-showFigCaption" title="&lt;figcaption&gt;">Show Figure Caption</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/figure" rel="noopener nofollow" title="Moz Reference for &lt;figure&gt;">?</a><input id="dev-showFigure" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFigure`);"><label for="dev-showFigure" title="&lt;figure&gt;">Show Figure</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/footer" rel="noopener nofollow" title="Moz Reference for &lt;footer&gt;">?</a><input id="dev-showFooter" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFooter`);"><label for="dev-showFooter" title="&lt;footer&gt;">Show Footer</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/h1" rel="noopener nofollow" title="Moz Reference for &lt;h1&gt;">?</a><input id="dev-showH1" type="checkbox" onclick="$(`body`).toggleClass(`dev-showH1`);"><label for="dev-showH1" title="&lt;h1&gt;">Show Heading 1</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/h2" rel="noopener nofollow" title="Moz Reference for &lt;h2&gt;">?</a><input id="dev-showH2" type="checkbox" onclick="$(`body`).toggleClass(`dev-showH2`);"><label for="dev-showH2" title="&lt;h2&gt;">Show Heading 2</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/h3" rel="noopener nofollow" title="Moz Reference for &lt;h3&gt;">?</a><input id="dev-showH3" type="checkbox" onclick="$(`body`).toggleClass(`dev-showH3`);"><label for="dev-showH3" title="&lt;h3&gt;">Show Heading 3</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/h4" rel="noopener nofollow" title="Moz Reference for &lt;h4&gt;">?</a><input id="dev-showH4" type="checkbox" onclick="$(`body`).toggleClass(`dev-showH4`);"><label for="dev-showH4" title="&lt;h4&gt;">Show Heading 4</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/h5" rel="noopener nofollow" title="Moz Reference for &lt;h5&gt;">?</a><input id="dev-showH5" type="checkbox" onclick="$(`body`).toggleClass(`dev-showH5`);"><label for="dev-showH5" title="&lt;h5&gt;">Show Heading 5</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/h6" rel="noopener nofollow" title="Moz Reference for &lt;h6&gt;">?</a><input id="dev-showH6" type="checkbox" onclick="$(`body`).toggleClass(`dev-showH6`);"><label for="dev-showH6" title="&lt;h6&gt;">Show Heading 6</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/header" rel="noopener nofollow" title="Moz Reference for &lt;header&gt;">?</a><input id="dev-showHeader" type="checkbox" onclick="$(`body`).toggleClass(`dev-showHeader`);"><label for="dev-showHeader" title="&lt;header&gt;">Show Header</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/hr" rel="noopener nofollow" title="Moz Reference for &lt;hr&gt;">?</a><input id="dev-showHr" type="checkbox" onclick="$(`body`).toggleClass(`dev-showHr`);"><label for="dev-showHr" title="&lt;hr&gt;">Show Horizontal Rule</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/i" rel="noopener nofollow" title="Moz Reference for &lt;i&gt;">?</a><input id="dev-showI" type="checkbox" onclick="$(`body`).toggleClass(`dev-showI`);"><label for="dev-showI" title="&lt;i&gt;">Show Italic</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/iframe" rel="noopener nofollow" title="Moz Reference for &lt;iframe&gt;">?</a><input id="dev-showIframe" type="checkbox" onclick="$(`body`).toggleClass(`dev-showIframe`);"><label for="dev-showIframe" title="&lt;iframe&gt;">Show iFrame</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ins" rel="noopener nofollow" title="Moz Reference for &lt;ins&gt;">?</a><input id="dev-showIns" type="checkbox" onclick="$(`body`).toggleClass(`dev-showIns`);"><label for="dev-showIns" title="&lt;ins&gt;">Show Insert</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/kbd" rel="noopener nofollow" title="Moz Reference for &lt;kbd&gt;">?</a><input id="dev-showKbd" type="checkbox" onclick="$(`body`).toggleClass(`dev-showKbd`);"><label for="dev-showKbd" title="&lt;kbd&gt;">Show Keyboard</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/legend" rel="noopener nofollow" title="Moz Reference for &lt;legend&gt;">?</a><input id="dev-showLegend" type="checkbox" onclick="$(`body`).toggleClass(`dev-showLegend`);"><label for="dev-showLegend" title="&lt;legend&gt;">Show Legend</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ul" rel="noopener nofollow" title="Moz Reference for &lt;ul&gt;">?</a><input id="dev-showUl" type="checkbox" onclick="$(`body`).toggleClass(`dev-showUl`);"><label for="dev-showUl" title="&lt;ul&gt;">Show Unordered List</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ol" rel="noopener nofollow" title="Moz Reference for &lt;ol&gt;">?</a><input id="dev-showOl" type="checkbox" onclick="$(`body`).toggleClass(`dev-showOl`);"><label for="dev-showOl" title="&lt;ol&gt;">Show Ordered List</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/li" rel="noopener nofollow" title="Moz Reference for &lt;li&gt;">?</a><input id="dev-showLi" type="checkbox" onclick="$(`body`).toggleClass(`dev-showLi`);"><label for="dev-showLi" title="&lt;li&gt;">Show List Item</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/main" rel="noopener nofollow" title="Moz Reference for &lt;main&gt;">?</a><input id="dev-showMain" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMain`);"><label for="dev-showMain" title="&lt;main&gt;">Show Main</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/map" rel="noopener nofollow" title="Moz Reference for &lt;map&gt;">?</a><input id="dev-showMap" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMap`);"><label for="dev-showMap" title="&lt;map&gt;">Show Map</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/mark" rel="noopener nofollow" title="Moz Reference for &lt;mark&gt;">?</a><input id="dev-showMark" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMark`);"><label for="dev-showMark" title="&lt;mark&gt;">Show Mark</label>'.
              '</div>'.
              '<div>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/menu" rel="noopener nofollow" title="Moz Reference for &lt;menu&gt;">?</a><input id="dev-showMenu" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMenu`);"><label for="dev-showMenu" title="&lt;menu&gt;">Show Menu</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/nav" rel="noopener nofollow" title="Moz Reference for &lt;nav&gt;">?</a><input id="dev-showNav" type="checkbox" onclick="$(`body`).toggleClass(`dev-showNav`);"><label for="dev-showNav" title="&lt;nav&gt;">Show Nav</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/object" rel="noopener nofollow" title="Moz Reference for &lt;object&gt;">?</a><input id="dev-showObject" type="checkbox" onclick="$(`body`).toggleClass(`dev-showObject`);"><label for="dev-showObject" title="&lt;object&gt;">Show Object</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/p" rel="noopener nofollow" title="Moz Reference for &lt;p&gt;">?</a><input id="dev-showParagraph" type="checkbox" onclick="$(`body`).toggleClass(`dev-showParagraph`);"><label for="dev-showParagraph" title="&lt;p&gt;">Show Paragraph</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/pre" rel="noopener nofollow" title="Moz Reference for &lt;pre&gt;">?</a><input id="dev-showPre" type="checkbox" onclick="$(`body`).toggleClass(`dev-showPre`);"><label for="dev-showPre" title="&lt;pre&gt;">Show Preformatted Text</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/q" rel="noopener nofollow" title="Moz Reference for &lt;q&gt;">?</a><input id="dev-showQ" type="checkbox" onclick="$(`body`).toggleClass(`dev-showQ`);"><label for="dev-showQ" title="&lt;q&gt;">Show Quote</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/s" rel="noopener nofollow" title="Moz Reference for &lt;s&gt;">?</a><input id="dev-showS" type="checkbox" onclick="$(`body`).toggleClass(`dev-showS`);"><label for="dev-showS" title="&lt;s&gt;">Show Strikethrough</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/samp" rel="noopener nofollow" title="Moz Reference for &lt;samp&gt;">?</a><input id="dev-showSamp" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSamp`);"><label for="dev-showSamp" title="&lt;samp&gt;">Show Sample</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/section" rel="noopener nofollow" title="Moz Reference for &lt;section&gt;">?</a><input id="dev-showSection" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSection`);"><label for="dev-showSection" title="&lt;section&gt;">Show Section</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/slot" rel="noopener nofollow" title="Moz Reference for &lt;slot&gt;">?</a><input id="dev-showSlot" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSlot`);"><label for="dev-showSlot" title="&lt;slot&gt;">Show Slot</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/small" rel="noopener nofollow" title="Moz Reference for &lt;small&gt;">?</a><input id="dev-showSmall" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSmall`);"><label for="dev-showSmall" title="&lt;small&gt;">Show Small</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/sub" rel="noopener nofollow" title="Moz Reference for &lt;sub&gt;">?</a><input id="dev-showSub" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSub`);"><label for="dev-showSub" title="&lt;sub&gt;">Show Subscript</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/summary" rel="noopener nofollow" title="Moz Reference for &lt;summary&gt;">?</a><input id="dev-showSummary" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSummary`);"><label for="dev-showSummary" title="&lt;summary&gt;">Show Summary</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/span" rel="noopener nofollow" title="Moz Reference for &lt;span&gt;">?</a><input id="dev-showSpan" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSpan`);"><label for="dev-showSpan" title="&lt;span&gt;">Show Span</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/sup" rel="noopener nofollow" title="Moz Reference for &lt;sup&gt;">?</a><input id="dev-showSup" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSup`);"><label for="dev-showSup" title="&lt;sup&gt;">Show Superscript</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/template" rel="noopener nofollow" title="Moz Reference for &lt;template&gt;">?</a><input id="dev-showTemplate" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTemplate`);"><label for="dev-showTemplate" title="&lt;template&gt;">Show Template</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/time" rel="noopener nofollow" title="Moz Reference for &lt;time&gt;">?</a><input id="dev-showTime" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTime`);"><label for="dev-showTime" title="&lt;time&gt;">Show Time</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/track" rel="noopener nofollow" title="Moz Reference for &lt;track&gt;">?</a><input id="dev-showTrack" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTrack`);"><label for="dev-showTrack" title="&lt;track&gt;">Show Track</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/u" rel="noopener nofollow" title="Moz Reference for &lt;u&gt;">?</a><input id="dev-showU" type="checkbox" onclick="$(`body`).toggleClass(`dev-showU`);"><label for="dev-showU" title="&lt;u&gt;">Show Underline</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/var" rel="noopener nofollow" title="Moz Reference for &lt;var&gt;">?</a><input id="dev-showVar" type="checkbox" onclick="$(`body`).toggleClass(`dev-showVar`);"><label for="dev-showVar" title="&lt;var&gt;">Show Var</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/video" rel="noopener nofollow" title="Moz Reference for &lt;video&gt;">?</a><input id="dev-showVideo" type="checkbox" onclick="$(`body`).toggleClass(`dev-showVideo`);"><label for="dev-showVideo" title="&lt;video&gt;">Show Video</label>'.
              '</div>'.
            '</li>'.
          '</ul>'.
        '</li>'.
        '<li>Deprecated'.
          '<ul>'.
            '<li>'.
              '<div>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/acronym" rel="noopener nofollow" title="Moz Reference for &lt;acronym&gt;">?</a><input id="dev-showAcronym" type="checkbox" onclick="$(`body`).toggleClass(`dev-showAcronym`);"><label for="dev-showAcronym" title="&lt;acronym&gt;">Show Acronym</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/applet" rel="noopener nofollow" title="Moz Reference for &lt;applet&gt;">?</a><input id="dev-showApplet" type="checkbox" onclick="$(`body`).toggleClass(`dev-showApplet`);"><label for="dev-showApplet" title="&lt;applet&gt;">Show Applet</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/basefont" rel="noopener nofollow" title="Moz Reference for &lt;basefont&gt;">?</a><input id="dev-showBasefont" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBasefont`);"><label for="dev-showBasefont" title="&lt;basefont&gt;">Show Basefont</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/bgsound" rel="noopener nofollow" title="Moz Reference for &lt;bgsound&gt;">?</a><input id="dev-showBgsound" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBgsound`);"><label for="dev-showBgsound" title="&lt;bgsound&gt;">Show BGSound</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/bold" rel="noopener nofollow" title="Moz Reference for &lt;b&gt;">?</a><input id="dev-showBold" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBold`);"><label for="dev-showBold" title="&lt;b&gt;">Show Bold</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/big" rel="noopener nofollow" title="Moz Reference for &lt;big&gt;">?</a><input id="dev-showBig" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBig`);"><label for="dev-showBig" title="&lt;big&gt;">Show Big</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/blink" rel="noopener nofollow" title="Moz Reference for &lt;blink&gt;">?</a><input id="dev-showBlink" type="checkbox" onclick="$(`body`).toggleClass(`dev-showBlink`);"><label for="dev-showBlink" title="&lt;blink&gt;">Show Blink</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/center" rel="noopener nofollow" title="Moz Reference for &lt;center&gt;">?</a><input id="dev-showCenter" type="checkbox" onclick="$(`body`).toggleClass(`dev-showCenter`);"><label for="dev-showCenter" title="&lt;center&gt;">Show Center</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/command" rel="noopener nofollow" title="Moz Reference for &lt;command&gt;">?</a><input id="dev-showCommand" type="checkbox" onclick="$(`body`).toggleClass(`dev-showCommand`);"><label for="dev-showCommand" title="&lt;command&gt;">Show Command</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/content" rel="noopener nofollow" title="Moz Reference for &lt;content&gt;">?</a><input id="dev-showContent" type="checkbox" onclick="$(`body`).toggleClass(`dev-showContent`);"><label for="dev-showContent" title="&lt;content&gt;">Show Content</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dir" rel="noopener nofollow" title="Moz Reference for &lt;dir&gt;">?</a><input id="dev-showDir" type="checkbox" onclick="$(`body`).toggleClass(`dev-showDir`);"><label for="dev-showDir" title="&lt;dir&gt;">Show Directory</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/element" rel="noopener nofollow" title="Moz Reference for &lt;element&gt;">?</a><input id="dev-showElement" type="checkbox" onclick="$(`body`).toggleClass(`dev-showElement`);"><label for="dev-showElement" title="&lt;element&gt;">Show Element</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/font" rel="noopener nofollow" title="Moz Reference for &lt;font&gt;">?</a><input id="dev-showFont" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFont`);"><label for="dev-showFont" title="&lt;font&gt;">Show Font</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/frame" rel="noopener nofollow" title="Moz Reference for &lt;frame&gt;">?</a><input id="dev-showFrame" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFrame`);"><label for="dev-showFrame" title="&lt;frame&gt;">Show Frame</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/frameset" rel="noopener nofollow" title="Moz Reference for &lt;frameset&gt;">?</a><input id="dev-showFrameset" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFrameset`);"><label for="dev-showFrameset" title="&lt;frameset&gt;">Show Frameset</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/image" rel="noopener nofollow" title="Moz Reference for &lt;image&gt;">?</a><input id="dev-showImage" type="checkbox" onclick="$(`body`).toggleClass(`dev-showImage`);"><label for="dev-showImage" title="&lt;image&gt;">Show Image</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/frameset" rel="noopener nofollow" title="Moz Reference for &lt;frameset&gt;">?</a><input id="dev-showFrameset" type="checkbox" onclick="$(`body`).toggleClass(`dev-showFrameset`);"><label for="dev-showFrameset" title="&lt;frameset&gt;">Show Frameset</label>'.
              '</div>'.
              '<div>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/image" rel="noopener nofollow" title="Moz Reference for &lt;image&gt;">?</a><input id="dev-showImage" type="checkbox" onclick="$(`body`).toggleClass(`dev-showImage`);"><label for="dev-showImage" title="&lt;image&gt;">Show Image</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/isindex" rel="noopener nofollow" title="Moz Reference for &lt;isindex&gt;">?</a><input id="dev-showIsindex" type="checkbox" onclick="$(`body`).toggleClass(`dev-showIsindex`);"><label for="dev-showIsindex" title="&lt;isindex&gt;">Show IsIndex</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/keygen" rel="noopener nofollow" title="Moz Reference for &lt;keygen&gt;">?</a><input id="dev-showKeygen" type="checkbox" onclick="$(`body`).toggleClass(`dev-showKeygen`);"><label for="dev-showKeygen" title="&lt;keygen&gt;">Show Keygen</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/listing" rel="noopener nofollow" title="Moz Reference for &lt;listing&gt;">?</a><input id="dev-showListing" type="checkbox" onclick="$(`body`).toggleClass(`dev-showListing`);"><label for="dev-showListing" title="&lt;listing&gt;">Show Listing</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/marquee" rel="noopener nofollow" title="Moz Reference for &lt;marquee&gt;">?</a><input id="dev-showMarquee" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMarquee`);"><label for="dev-showMarquee" title="&lt;marquee&gt;">Show Marquee</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/menuitem" rel="noopener nofollow" title="Moz Reference for &lt;menuitem&gt;">?</a><input id="dev-showMenuitem" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMenuitem`);"><label for="dev-showMenuitem" title="&lt;menuitem&gt;">Show Menuitem</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/multicol" rel="noopener nofollow" title="Moz Reference for &lt;multicol&gt;">?</a><input id="dev-showMulticol" type="checkbox" onclick="$(`body`).toggleClass(`dev-showMulticol`);"><label for="dev-showMulticol" title="&lt;multicol&gt;">Show Multicol</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/nextid" rel="noopener nofollow" title="Moz Reference for &lt;nextid&gt;">?</a><input id="dev-showNextid" type="checkbox" onclick="$(`body`).toggleClass(`dev-showNextid`);"><label for="dev-showNextid" title="&lt;nextid&gt;">Show Nextid</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/nobr" rel="noopener nofollow" title="Moz Reference for &lt;nobr&gt;">?</a><input id="dev-showNobr" type="checkbox" onclick="$(`body`).toggleClass(`dev-showNobr`);"><label for="dev-showNobr" title="&lt;nobr&gt;">Show Nobr</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/noembed" rel="noopener nofollow" title="Moz Reference for &lt;noembed&gt;">?</a><input id="dev-showNoembed" type="checkbox" onclick="$(`body`).toggleClass(`dev-showNoembed`);"><label for="dev-showNoembed" title="&lt;noembed&gt;">Show Noembed</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/noframes" rel="noopener nofollow" title="Moz Reference for &lt;noframes&gt;">?</a><input id="dev-showNoframes" type="checkbox" onclick="$(`body`).toggleClass(`dev-showNoframes`);"><label for="dev-showNoframes" title="&lt;noframes&gt;">Show Noframes</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/plaintext" rel="noopener nofollow" title="Moz Reference for &lt;plaintext&gt;">?</a><input id="dev-showPlaintext" type="checkbox" onclick="$(`body`).toggleClass(`dev-showPlaintext`);"><label for="dev-showPlaintext" title="&lt;plaintext&gt;">Show Plaintext</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/shadow" rel="noopener nofollow" title="Moz Reference for &lt;shadow&gt;">?</a><input id="dev-showShadow" type="checkbox" onclick="$(`body`).toggleClass(`dev-showShadow`);"><label for="dev-showShadow" title="&lt;shadow&gt;">Show Shadow</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/spacer" rel="noopener nofollow" title="Moz Reference for &lt;spacer&gt;">?</a><input id="dev-showSpacer" type="checkbox" onclick="$(`body`).toggleClass(`dev-showSpacer`);"><label for="dev-showSpacer" title="&lt;spacer&gt;">Show Spacer</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/strike" rel="noopener nofollow" title="Moz Reference for &lt;strike&gt;">?</a><input id="dev-showStrike" type="checkbox" onclick="$(`body`).toggleClass(`dev-showStrike`);"><label for="dev-showStrike" title="&lt;strike&gt;">Show Strike</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/tt" rel="noopener nofollow" title="Moz Reference for &lt;tt&gt;">?</a><input id="dev-showTt" type="checkbox" onclick="$(`body`).toggleClass(`dev-showTt`);"><label for="dev-showTt" title="&lt;tt&gt;">Show Teletype Text</label><br>'.
                '<a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/xmp" rel="noopener nofollow" title="Moz Reference for &lt;xmp&gt;">?</a><input id="dev-showXmp" type="checkbox" onclick="$(`body`).toggleClass(`dev-showXmp`);"><label for="dev-showXmp" title="&lt;xmp&gt;">Show Xmp</label>'.
              '</div>'.
            '</li>'.
          '</ul>'.
        '</li>'.
        '<li>Information'.
          '<ul>'.
            '<li>'.
              '<input id="dev-showScript" type="checkbox" onclick="$(`body`).toggleClass(`dev-showScript`);"><label for="dev-showScript">Show Script</label><br>'.
              '<input id="dev-showStyle" type="checkbox" onclick="$(`body`).toggleClass(`dev-showStyle`);"><label for="dev-showStyle">Show Style</label><br>'.
              '<input id="dev-showJSON-LD" type="checkbox" onclick="$(`body`).toggleClass(`dev-showJSON-LD`);"><label for="dev-showJSON-LD">Show JSON-LD</label><br>'.
              '<input id="dev-topopgraphic" type="checkbox" onclick="$(`body`).toggleClass(`dev-topographic`);"><label for="dev-topopgraphic">Show Topographic</label>'.
            '</li>'.
          '</ul>'.
        '</li>'.
      '</ul>'.
    '</nav>'.
    '<div class="dropper">'.
      '<button class="development-dropdown" onclick="$(`.development,.development-dropdown svg`).toggleClass(`toggled`);" title="SEO Helper" aria-label="SEO Helper">Developer Toolbar '.
        '<svg class="devToolbarDrop" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 12.85856,5.194785 -5.52357,5.51613 Q 7.19355,10.852355 7,10.852355 q -0.19355,0 -0.33499,-0.14144 L 1.141439,5.194785 Q 1,5.053345 1,4.856075 1,4.658805 1.141439,4.517365 L 2.37717,3.289075 q 0.14144,-0.14143 0.33499,-0.14143 0.19355,0 0.33499,0.14143 L 7,7.241935 10.95285,3.289075 q 0.14144,-0.14143 0.33499,-0.14143 0.19355,0 0.33499,0.14143 l 1.23573,1.22829 Q 13,4.658805 13,4.856075 q 0,0.19727 -0.14144,0.33871 z"/></svg>'.
        '<svg class="devToolbarDrop toggled" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 12.85856,9.482625 -1.23573,1.22829 q -0.14144,0.14144 -0.33499,0.14144 -0.19355,0 -0.33499,-0.14144 L 7,6.758065 3.04715,10.710915 q -0.14144,0.14144 -0.33499,0.14144 -0.19355,0 -0.33499,-0.14144 L 1.14144,9.482625 Q 1,9.341185 1,9.143915 1,8.946645 1.14144,8.805205 L 6.66501,3.289075 Q 6.80645,3.147645 7,3.147645 q 0.19355,0 0.33499,0.14143 l 5.52357,5.51613 Q 13,8.946645 13,9.143915 q 0,0.19727 -0.14144,0.33871 z"/></svg>'.
      '</button>'.
    '</div>'.
  '</div>':''),
  (isset($_SESSION['rank'])&&$_SESSION['rank']>899?'<link rel="stylesheet" type="text/css" href="core/css/seohelper.css">':'')
],$head);
if(isset($config['ga_tracking'])&&$config['ga_tracking']!=''){
  if(!isset($_SERVER['HTTP_USER_AGENT'])||stripos($_SERVER['HTTP_USER_AGENT'],'Speed Insights')===false)
    $head=str_replace('<google_analytics>','<script async src="https://www.googletagmanager.com/gtag/js?id='.$config['ga_tracking'].'"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag(\'js\',new Date());gtag(\'config\',\''.$config['ga_tracking'].'\');</script>',$head);
}else
  $head=str_replace('<google_analytics>','',$head);
if($view=='login'){
  if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
    $content=preg_replace([
      '/<[\/]?loggedin>/',
      '~<notloggedin>.*?<\/notloggedin>~is'
    ],'',$content);
  }else{
    if(stristr($content,'<print page="terms-of-service">')){
      $cs=$db->prepare("SELECT notes FROM `".$prefix."menu` WHERE LOWER(`title`)=LOWER(:title) AND `active`=1");
      $cs->execute([
        ':title'=>'terms of service'
      ]);
      $cp=$cs->fetch(PDO::FETCH_ASSOC);
      $content=preg_replace([
        '~<loggedin>.*?<\/loggedin>~is',
        '/<[\/]?notloggedin>/',
        '/<print page=[\'\"]?terms-of-service[\'\"]?>/'
      ],[
        '',
        '',
        $cp['notes']
      ],$content);
    }
  }
}
if(isset($_SESSION['rank'])&&$_SESSION['rank']==1000&&$config['development']==1){
  $head=preg_replace([
    '/<div class="development"><\/div>/'
  ],[
    '<div class="development open"><br>Page Views: '.$page['views'].' | Memory Used: '.size_format(memory_get_usage()).' | Process Time: '.elapsed_time().' | PHPv'.(float)PHP_VERSION.'</div>'
  ],$head);
}
$content=preg_replace(
  '/<serviceworker>/',
  ($config['options'][18]==1?'<script>if(`serviceWorker` in navigator){window.addEventListener(`load`,()=>{navigator.serviceWorker.register(`core/js/service-worker.php`,{scope:`/`}).then((reg)=>{console.log(`[AuroraCMS] Service worker registered.`,reg);});});}</script>':'')
  ,$content
);
print$head.$content;
if($config['options'][11]==1){
  $current_page=PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  if(!isset($_SESSION['current_page'])||(isset($_SESSION['current_page'])&&(stristr($_SESSION['current_page'],'search')||$_SESSION['current_page']!=$current_page))){
    if(!stristr($current_page,'core/')||
      !stristr($current_page,'admin/')||
      !stristr($current_page,'layout/')||
      !stristr($current_page,'media/')||
      !stristr($current_page,'.js')||
      !stristr($current_page,'.css')||
      !stristr($current_page,'.map')||
      !stristr($current_page,'.jpg')||
      !stristr($current_page,'.jpeg')||
      !stristr($current_page,'.png')||
      !stristr($current_page,'.gif')||
      !stristr($current_page,'.svg')||
      !stristr($current_page,'.webp')
    ){
      $s=$db->prepare("INSERT IGNORE INTO `".$prefix."tracker` (`pid`,`urlDest`,`urlFrom`,`userAgent`,`keywords`,`ip`,`browser`,`os`,`sid`,`ti`) VALUES (:pid,:urlDest,:urlFrom,:userAgent,:keywords,:ip,:browser,:os,:sid,:ti)");
      $hr=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
      $s->execute([
        ':pid'=>isset($page['id'])?$page['id']:0,
        ':urlDest'=>$current_page,
        ':urlFrom'=>$hr,
        ':userAgent'=>$_SERVER['HTTP_USER_AGENT'],
        ':keywords'=>isset($search)&&($search!='%'||$search!='')?ltrim(rtrim(str_replace([' ','%'],',',$search),','),','):'',
        ':ip'=>$_SERVER["REMOTE_ADDR"],
        ':browser'=>getBrowser(),
        ':os'=>getOS(),
        ':sid'=>session_id(),
        ':ti'=>time()
      ]);
      $_SESSION['current_page']=$current_page;
    }
  }
}
function getOS(){
  $user_agent=$_SERVER['HTTP_USER_AGENT'];
  $os_platform="Unknown OS Platform";
  $os_array=[
    '/windows nt 10/i'=>'Windows',
    '/windows nt 6.3/i'=>'Windows',
    '/windows nt 6.2/i'=>'Windows',
    '/windows nt 6.1/i'=>'Windows',
    '/windows nt 6.0/i'=>'Windows',
    '/windows nt 5.2/i'=>'Windows',
    '/windows nt 5.1/i'=>'Windows',
    '/windows xp/i'=>'Windows',
    '/windows nt 5.0/i'=>'Windows',
    '/windows me/i'=>'Windows',
    '/win98/i'=>'Windows',
    '/win95/i'=>'Windows',
    '/win16/i'=>'Windows',
    '/macintosh/i'=>'Mac',
    '/mac os x/i'=>'Mac',
    '/mac_powerpc/i'=>'Mac',
    '/linux/i'=>'Linux',
    '/ubuntu/i'=>'Ubuntu',
    '/iphone/i'=>'iPhone',
    '/ipod/i'=>'iPod',
    '/ipad/i'=>'iPad',
    '/android/i'=>'Android',
    '/blackberry/i'=>'BlackBerry',
    '/webos/i'=>'Mobile'
  ];
  foreach($os_array as$regex=>$value){
    if(preg_match($regex,$user_agent))$os_platform=$value;
  }
  return$os_platform;
}
function getBrowser(){
  $user_agent=$_SERVER['HTTP_USER_AGENT'];
  $browser="Unknown Browser";
  $browser_array=[
    '/brave/i'=>'Brave',
    '/msie/i'=>'Explorer',
    '/firefox/i'=>'Firefox',
    '/safari/i'=>'Safari',
    '/chrome/i'=>'Chrome',
    '/edge/i'=>'Edge',
    '/opera/i'=>'Opera',
    '/netscape/i'=>'Netscape',
    '/maxthon/i'=>'Maxthon',
    '/konqueror/i'=>'Konqueror',
    '/mobile/i'=>'Mobile',
    '/bingbot/i'=>'Bing',
    '/duckduckbot/i'=>'DuckDuckGo',
    '/googlebot/i'=>'Google',
    '/msnbot/i'=>'MSN',
    '/slurp/i'=>'Inktomi',
    '/yahoo/i'=>'Yahoo',
    '/askjeeves/i'=>'AskJeeves',
    '/fastcrawler/i'=>'FastCrawler',
    '/infoseek/i'=>'InfoSeek',
    '/lycos/i'=>'Lycos',
    '/yandex/i'=>'Yandex',
    '/geohasher/i'=>'GeoHasher',
    '/gigablast/i'=>'Gigablast',
    '/baidu/i'=>'Baiduspider',
    '/spinn3r/i'=>'Spinn3r',
    '/sogou/i'=>'Sogou',
    '/Exabot/i'=>'Exabot',
    '/facebook/i'=>'Facebook',
    '/alexa/i'=>'Alexa'
  ];
  foreach($browser_array as$regex=>$value){
    if(preg_match($regex,$user_agent))$browser=$value;
  }
  return$browser;
}
