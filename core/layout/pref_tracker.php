<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Tracker
 * @package    core/layout/pref_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$find=isset($_POST['find'])?$_POST['find']:'';
if($find=='')$find=isset($_GET['find'])?$_GET['find']:'';
function desiminateVisit($u){
  $status='ok';
  if(stristr($u,'aws/'))$status='Suspicious';
  if(stristr($u,'/wp'))$status='Suspicious';
  if(stristr($u,'/wordpress/'))$status='Suspicious';
  if(stristr($u,'old-wp'))$status='Suspicious';
  if(stristr($u,'xmlrpc.php'))$status='Suspicious';
  if(stristr($u,'dup-installer'))$status='Suspicious';
  if(stristr($u,'eval-stdin.php'))$status='Suspicious';
  if(stristr($u,'panels.txt'))$status='Suspicious';
  if(stristr($u,'?author='))$status='Suspicious';
  if(stristr($u,'.php'))$status='Suspicious';
  if(stristr($u,'.asp'))$status='Suspicious';
  if(stristr($u,'.aspx'))$status='Suspicious';
  if(stristr($u,'magento'))$status='Suspicious';
  if(stristr($u,'/modules/'))$status='Suspicious';
  if(stristr($u,'plesk'))$status='Suspicious';
  if(stristr($u,'/system/'))$status='Suspicious';
  if(stristr($u,'/umbraco'))$status='Suspicious';
  if(stristr($u,'/joomla'))$status='Suspicious';
  if(stristr($u,'wp-login'))$status='Suspicious';
	if(stristr($u,'/staging/'))$status='Suspicious';
  return($status=='ok'?'<span class="badger badge-success">OK</span>':'<span class="badger badge-danger">'.$status.'</span>');
}
function deseminateReferer($u){
  if($u==''){
    $out='<span class="badger badge-success">Direct</span>';
  }else{
    $pu=parse_url($u);
    $out=(isset($pu['host'])?$pu['host']:'<small>'.$u.'</small>').'<br>';
    if(stristr($u,'500px'))$out='<i class="i d-inline-table i-3x i-social 500px">social-500px</i><small class="d-flex pt-1 justify-content-center">500px</small>';
    if(stristr($u,'amazon'))$out='<i class="i d-inline-table i-3x i-social amazon">social-amazon</i><small class="d-flex pt-1 justify-content-center">Amazon</small>';
    if(stristr($u,'ahref')||stristr($u,'as16276'))$out='<i class="i d-inline-table i-3x i-social ahrefs">social-ahrefs</i><small class="d-flex pt-1 justify-content-center">AHrefs</small>';
    if(stristr($u,'aws'))$out='<i class="i d-inline-table i-3x i-social amazon">social-amazon</i><small class="d-flex pt-1 justify-content-center">Amazon</small>';
    if(stristr($u,'bing'))$out='<i class="i d-inline-table i-3x i-social bing">social-bing</i><small class="d-flex pt-1 justify-content-center">Bing</small>';
    if(stristr($u,'facebook'))$out='<i class="i d-inline-table i-3x i-social facebook">social-facebook</i><small class="d-flex pt-1 justify-content-center">Facebook</small>';
    if(stristr($u,'fbclid='))$out='<i class="i d-inline-table i-3x i-social facebook">social-facebook</i><small class="d-flex pt-1 justify-content-center">Facebook</small>';
    if(stristr($u,'msclkid='))$out='<i class="i d-inline-table i-3x i-social bing">social-bing</i><small class="d-flex pt-1 justify-content-center">Bing</small>';
    if(stristr($u,'github'))$out='<i class="i d-inline-table i-3x i-social github">social-github</i><small class="d-flex pt-1 justify-content-center">GitHub</small>';
    if(stristr($u,'google'))$out='<i class="i d-inline-table i-3x i-social google">social-google</i><small class="d-flex pt-1 justify-content-center">Google</small>';
    if(stristr($u,'gclid='))$out='<i class="i d-inline-table i-3x i-social google">social-google</i><small class="d-flex pt-1 justify-content-center">Google</small>';
    if(stristr($u,'instagram'))$out='<i class="i d-inline-table i-3x i-social instagram">social-instagram</i><small class="d-flex pt-1 justify-content-center">Instagram</small>';
    if(stristr($u,'duckduckgo'))$out='<i class="i d-inline-table i-3x i-social duckduckgo">social-duckduckgo</i><small class="d-flex pt-1 justify-content-center">DuckDuckGo</small>';
    if(stristr($u,'Host Royale')||stristr($u,'as203020'))$out='<i class="i d-inline-table i-3x i-social border-danger fraud">social-fraud</i><small class="d-flex pt-1 justify-content-center text-danger">Potential Fraud</small>';
    if(stristr($u,'linkedin'))$out='<i class="i d-inline-table i-3x i-social linkedin">social-linkedin</i><small class="d-flex pt-1 justify-content-center">LinkedIn</small>';
    if(stristr($u,'reddit'))$out='<i class="i d-inline-table i-3x i-social reddit">social-reddit</i><small class="d-flex pt-1 justify-content-center">Reddit</small>';
    if(stristr($u,'telstra')||stristr($u,'as1221'))$out='<i class="i d-inline-table i-3x i-social telstra">social-telstra</i><small class="d-flex pt-1 justify-content-center">Telstra</small>';
    if(stristr($u,'youtube'))$out='<i class="i d-inline-table i-3x i-social youtube">social-youtube</i><small class="d-flex pt-1 justify-content-center">YouTube</small>';
    if(stristr($u,'twitter')||stristr($u,'t.co/'))$out='<i class="i d-inline-table i-3x i-social twitter">social-twitter</i><small class="d-flex pt-1 justify-content-center">Twitter</small>';
  }
  if($u=='Unknown')$out='<span class="badger badge-dark">'.$u.'</span><br>';
  return$out;
}
function getOSIcon($i){
  if(in_array($i,
    ['android',
    'apple',
    'beos',
    'bsd',
    'linux',
    'microsoft',
    'windows7',
    'windows8',
    'windows95',
    'windows98',
    'windows2000',
    'windowsme',
    'windowsvista',
    'windowsxp'],true
  ))return'<i class="i d-inline-table i-3x">os-'.$i.'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>';
  else
    return'<i class="i d-inline-table i-3x i-color-muted">os-general</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>';
}
function getBrowser($ua){
  $b='Unknown';
  $ba=[
    '/alexa/i'=>'Alexa',
    '/amaya/i'=>'Amaya',
    '/arora/i'=>'Arora',
    '/askjeeves/i'=>'AskJeeves',
    '/avant browser/i'=>'AvantBrowser',
    '/baidu/i'=>'Baiduspider',
    '/beamrise/i'=>'Beamrise',
    '/bingbot/i'=>'Bing',
    '/bolt/i'=>'BOLT',
    '/brave/i'=>'Brave',
    '/camino/i'=>'Camino',
    '/chimera/i'=>'Chimera',
    '/chrome/i'=>'Chrome',
    '/dillo/i'=>'Dillo',
    '/duckduckbot/i'=>'DuckDuckGo',
    '/edg/i'=>'Edge',
    '/epiphany/i'=>'Epiphany',
    '/eudoraWeb/i'=>'EudoraWeb',
    '/exabot/i'=>'Exabot',
    '/explorer/i'=>'Explorer',
    '/facebook/i'=>'Facebook',
    '/fastcrawler/i'=>'FastCrawler',
    '/firebird/i'=>'Firebird',
    '/firefox/i'=>'Firefox',
    '/galeon/i'=>'Galeon',
    '/geohasher/i'=>'GeoHasher',
    '/gigablast/i'=>'Gigablast',
    '/googlebot/i'=>'Google',
    '/hotjava/i'=>'HotJava',
    '/ibrowse/i'=>'IBrowse',
    '/icab/i'=>'iCab',
    '/iceape/i'=>'Iceape',
    '/iceweasel/i'=>'Iceweasel',
    '/infoseek/i'=>'InfoSeek',
    '/itunes/i'=>'iTunes',
    '/kindle/i'=>'Kindle',
    '/konqueror/i'=>'Konqueror',
    '/lynx/i'=>'Lynx',
    '/links/i'=>'Links',
    '/lycos/i'=>'Lycos',
    '/maxthon/i'=>'Maxthon',
    '/midori/i'=>'Midori',
    '/mobile/i'=>'Mobile',
    '/msie/i'=>'Explorer',
    '/msnbot/i'=>'MSN',
    '/namoroka/i'=>'Namoroka',
    '/netscape/i'=>'Netscape',
    '/netsurf/i'=>'NetSurf',
    '/omniWeb/i'=>'OmniWeb',
    '/opera/i'=>'Opera',
    '/opr/i'=>'Opera',
    '/phoenix/i'=>'Phoenix',
    '/qupzilla/i'=>'QupZilla',
    '/safari/i'=>'Safari',
    '/seamonkey/i'=>'Sea Monkey',
    '/shadowfox/i'=>'ShadowFox',
    '/shiira/i'=>'Shiira',
    '/silk/i'=>'Silk',
    '/slurp/i'=>'Inktomi',
    '/sogou/i'=>'Sogou',
    '/spinn3r/i'=>'Spinn3r',
    '/swiftfox/i'=>'Swiftfox',
    '/trident\/7.0/i'=>'Explorer',
    '/ucbrowser/i'=>'UCBrowser',
    '/uzbl/i'=>'Uzbl',
    '/vivaldi/i'=>'Vivaldi',
    '/wosbrowser/i'=>'wOSBrowser',
    '/yahoo/i'=>'Yahoo',
    '/yandex/i'=>'Yandex'
  ];
  foreach($ba as$r=>$v){
    if(preg_match($r,$ua)){
      $b=$v;
      break;
    }
  }
  return$b;
}
function getBrowserIcon($i){
  if(in_array($i,
    ['brave',
    'chrome',
    'edge',
    'explorer',
    'firefox',
    'opera',
    'safari'],true))return'<i class="i d-inline-table i-3x">browser-'.$i.'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>';
  else
    return'<i class="i d-inline-table i-3x i-color-muted">browser-general</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>';
}
function getDevice($ua){
  $osd='Unknown';
  $osa=[
    '/android/i'=>'Android',
    '/blackberry/i'=>'BlackBerry',
    '/ipad/i'=>'iPad',
    '/iphone/i'=>'iPhone',
    '/ipod/i'=>'iPod',
    '/iphone/i'=>'iPhone',
    '/nokia/i'=>'Nokia',
    '/webos/i'=>'Mobile',
  ];
  foreach($osa as$r=>$v){
    if(preg_match($r,$ua)){
      $osd=$v;
      break;
    }
  }
  return$osd;
}
function getDeviceIcon($i,$w){
  if($i!=''&&$i!='unknown'&&in_array($i,
    [
      'android',
      'desktop',
      'ipad',
      'iphone',
      'laptop',
      'mobile',
      'smartwatch',
      'tablet',
      'television'
    ],true))
    return'<i class="i d-inline-table i-3x">tech-'.$i.'</i><small class="d-flex pt-1 justify-content-center">'.ucfirst($i).'</small>'.(is_numeric($w)?'<span class="m-0 p-0" style="font-size:9px">'.$w.'</span><br>':'');
  else
    return'<i class="i d-inline-table i-3x i-color-muted">tech-unknown</i><small class="d-flex pt-1 justify-content-center i-color-muted">Unknown</small>'.(is_numeric($w)?'<span class="m-0 p-0" style="font-size:9px">'.$w.'</span><br>':'');
}
function getLocationInfoByIp($ip){
  $result=array(
    'countryCode'=>'',
    'countryName'=>'',
    'city'=>'',
    'region'=>'',
    'regionCode'=>''
  );
  if($ip=='127.0.0.1'){
    $result['countryCode']='localhost';
    $result['countryName']='localhost';
    $result['city']='dev';
    $result['region']='dev';
    $result['regionCode']='dev';
  }else{
    $ip_data=@json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
    if($ip_data && $ip_data->geoplugin_countryName!=null){
        $result['countryName']=$ip_data->geoplugin_countryName; //
        $result['countryCode']=$ip_data->geoplugin_countryCode; // AU
        $result['city']=$ip_data->geoplugin_city; // Launcestion
        $result['region']=$ip_data->geoplugin_region; // Tasmania
        $result['regionCode']=$ip_data->geoplugin_regionCode; // TAS
    }
  }
  return$result;
}
function getIspInfo($ip) {
  $ipinfo = file_get_contents("https://ipinfo.io/" . $ip);
  $ipinfo_json = json_decode($ipinfo, true);
  return $ipinfo_json;
}?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><i class="i i-4x">tracker</i></div>
          <div>Preferences - Tracker</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Tracker</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 overflow-visible">
        <div class="row p-3">
          <div class="col-12 col-sm-6">
            <input id="options11" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?=$config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
            <label for="options11" id="configoptions111">Visitor Tracking</label>
            <span class="small text-muted">Collected Data is Purged after 30 Days.</span>
          </div>
          <div class="col-12 col-sm-6">
            <form action="" method="post">
              <div class="form-row">
                <input type="text" name="find" value="<?=$find;?>" placeholder="Enter text to search in URLs...">
                <button type="submit">Go</button>
              </div>
            </form>
          </div>
        </div>
        <table class="table-zebra">
          <thead>
            <tr class="sticky-header small">
              <th class="text-center align-middle text-uppercase" data-tooltip="bottom" aria-label="The total visits from the same IP over time, the number is not an indicator of visits during a single session.">Visits</th>
              <th class="text-center align-middle text-uppercase">Status</th>
              <th class="text-center align-middle text-uppercase">Referrer</th>
              <th class="text-center align-middle text-uppercase">Activity</th>
              <th class="text-center align-middle text-uppercase">Origin</th>
              <th class="text-center align-middle text-uppercase">OS</th>
              <th class="text-center align-middle text-uppercase">Browser</th>
              <th class="text-center align-middle text-uppercase">Device</th>
              <th class="text-center align-middle text-uppercase">
                <div class="btn-group float-right">
                  <?php if($find){?>
                    <button class="btn-sm trash trashall" data-tooltip="left" aria-label="Remove All Listed Results"><i class="i">purge</i></button>
                  <?php }else{?>
                    <button class="btn-sm purge trash" data-tooltip="left" aria-label="Purge All" onclick="purge('0','tracker');return false;"><i class="i">purge</i></button>
                  <?php }?>
                </div>
              </th>
            </tr>
          </thead>
          <?php
            if($find!=''){
              $s=$db->prepare("SELECT *, MAX(`ti`) AS `cti`, COUNT(`ip`) AS `v` FROM `".$prefix."tracker` WHERE LOWER(`urlDest`) LIKE LOWER(:find) OR LOWER(`urlFrom`) LIKE LOWER(:find) OR LOWER(`action`) LIKE LOWER(:find) GROUP BY `ip` ORDER BY `cti` DESC");
              $s->execute([':find'=>'%'.strtolower($find).'%']);
            }else{
              $s=$db->prepare("SELECT *, MAX(`ti`) AS `cti`, COUNT(`ip`) AS `v` FROM `".$prefix."tracker` GROUP BY `ip` ORDER BY `cti` DESC LIMIT 20");
              $s->execute();
            }
            $trackercnt=$s->rowCount();
            $cnt=$s->rowCount();?>
            <tbody id="l_tracker"<?=($trackercnt>0?' data-dbtot="'.$trackercnt.'"':'');?>>
              <?php
            while($r=$s->fetch(PDO::FETCH_ASSOC)){
              if($r['countryName']==''){
                $result=getLocationInfoByIp($r['ip']);
                $sc=$db->prepare("UPDATE `".$prefix."tracker` SET `countryName`=:cN,`countryCode`=:cC,`city`=:c,`region`=:r,`regionCode`=:rC WHERE `ip`=:ip");
                $sc->execute([
                  ':cN'=>$result['countryName'],
                  ':cC'=>$result['countryCode'],
                  ':c'=>$result['city'],
                  ':r'=>$result['region'],
                  ':rC'=>$result['regionCode'],
                  ':ip'=>$r['ip']
                ]);
                $r['countryName']=$result['countryName']; // Australia
                $r['countryCode']=$result['countryCode']; // AU
                $r['city']=$result['city']; // Launceston
                $r['region']=$result['region']; // Tasmania
                $r['regionCode']=$result['regionCode']; // TAS
              }
              if($r['isp']==''){
                $isp=getIspInfo($r['ip']);
                $r['isp']=$isp['org']==''?'Unknown':$isp['org'];
                $si=$db->prepare("UPDATE `".$prefix."tracker` SET `isp`=:isp WHERE `ip`=:ip");
                $si->execute([
                  ':isp'=>$r['isp'],
                  ':ip'=>$r['ip']
                ]);
              }
              if($r['browser']==''||$r['browser']=='Unknown'){
                $r['browser']=getBrowser($r['userAgent']);
                $sb=$db->prepare("UPDATE `".$prefix."tracker` SET `browser`=:browser WHERE `ip`=:ip");
                $sb->execute([
                  ':browser'=>$r['browser'],
                  ':ip'=>$r['ip']
                ]);
              }
              if($r['device']==''||$r['device']=='Unknown'){
                $r['device']=getDevice($r['userAgent']);
                $sd=$db->prepare("UPDATE `".$prefix."tracker` SET `device`=:device WHERE `ip`=:ip");
                $sd->execute([
                  ':device'=>$r['device'],
                  ':ip'=>$r['ip']
                ]);
              }?>
              <tr class="small <?=(isset($find)&&$find!=''?' findtracker':'');?>" data-dbid="<?=$r['id'];?>" id="l_<?=$r['id'];?>" data-ip="<?=$r['ip'];?>">
                <td class="text-center align-middle">
                  <?= $r['v'].'<br><small>'.date('D M d Y',$r['cti']).'<br>'.date('h:i:s A',$r['cti']).'</small>';?>
                </td>
                <td class="text-center align-middle tracker-status">
                  <?=($r['status']=='blacklisted'?'<span class="badger badge-dark">Blacklisted</span>':desiminateVisit($r['urlDest']));?>
                </td>
                <td class="text-center align-middle">
                  <?=($r['isp']!='Unkown'?deseminateReferer($r['isp']):'').deseminateReferer($r['urlFrom']);?>
                </td>
                <td class="text-center align-middle">
                  <?='<small>'._ago($r['cti']),'</small>'.($r['action']=='Visit Click'||$r['action']=='Call Click'?'<br><span class="badger badge-success">Called from Site</span>':'');?>
                </td>
                <td class="align-middle pt-2 text-wrap">
                  <div class="mr-2 flag">
                    <img src="core/images/flags/<?=($r['countryCode']==''?'localhost':strtolower($r['countryCode']));?>.png" alt="<?=$r['countryName'];?>">
                  </div>
                  <div class="d-inline-block">
                    <small><?=($r['countryName']==''?'Unresolved':$r['countryName']).' - <a target="_blank" href="https://dnschecker.org/ip-location.php?ip='.$r['ip'].'">'.$r['ip'].'</a>';?></small>
                    <?=($r['city']!=''?'<br><small>'.$r['city'].($r['city']!=''&&$r['region']!=''?' - ':'').$r['region'].'</small>':'<br>').
                    ($r['isp']!='Unknown'?'<br><small>'.$r['isp'].'</small>':'');?>
                  </div>
                </td>
                <td class="text-center align-middle">
                  <div class="d-inline-block justify-content-center p-1 mr-1">
                    <?= getOSIcon(strtolower($r['os']));?>
                  </div>
                </td>
                <td class="text-center align-middle">
                  <div class="d-inline-block justify-content-center p-1 ml-1">
                    <?= getBrowserIcon(strtolower($r['browser']));?>
                  </div>
                </td>
                <td class="text-center align-middle">
                  <?= getDeviceIcon(strtolower($r['device']),$r['viewportwidth']);?>
                </td>
                <td class="align-middle">
                  <div class="btn-group float-right">
                    <button data-fancybox data-type="ajax" data-src="core/layout/pathviewer.php?id=<?=$r['id'];?>" data-tooltip="left" aria-label="View Visitor Path"><i class="i">seo-path</i></button>
                    <?php if($config['php_options'][0]==1){?>
                      <a class="btn" target="_blank" href="https://www.projecthoneypot.org/ip_<?=$r['ip'];?>" role="button" data-tooltip="left" aria-label="Lookup IP using Project Honey Pot (Opens in New Page)"><i class="i">brand-projecthoneypot</i></a>
                    <?php }
                    if($r['status']!='blacklisted'){?>
                      <button class="btn btn-dark" data-btnip="<?=$r['ip'];?>" data-tooltip="left" aria-label="Add to Blacklist" onclick="trackertoblacklist('<?=$r['ip'];?>');"><i class="i">security</i></button>
                    <?php }?>
                    <button class="trash" data-tooltip="left" aria-label="Remove all of this IP" onclick="purge('<?=$r['ip'];?>','clearip');"><i class="i">trash</i></button>
                  </div>
                </td>
              </tr>
            <?php }
            if($cnt>19&&$find==''){?>
              <tr id="more_20">
                <td colspan="9">
                  <div class="form-row load-more justify-content-center">
                    <button class="btn-block btn-more" onclick="more('tracker','20','<?=(isset($args[1])&&$args[1]!=''?$args[1]:'');?>');">More</button>
                  </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
