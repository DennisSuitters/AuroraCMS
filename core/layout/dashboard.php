<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard
 * @package    core/layout/dashboard.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Improve Statistic Panels
 * @changes    v0.0.2 Change Stats Panels to only be displayed when their values
 *             are greater than 0.
 * @changes    v0.0.3 Change Pages Views to show Actual Page and Content Views.
 * @changes    v0.0.4 Fix Tooltips.
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_dashboard.php';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <div class="container-fluid">
<?php echo$config['maintenance']{0}==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Maintenance Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#maintenance">Set Now</a></div>':'';
  echo$config['comingsoon']{0}==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Coming Soon Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#comingsoon">Set Now</a></div>':'';
  if(!file_exists('layout'.DS.$config['theme'].DS.'theme.ini'))
    echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
  $tid=$ti-2592000;
  echo$config['business']==''?'<div class="alert alert-danger" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Booking will NOT function currectly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#business">Set Now</a></div>':'';
  echo$config['email']==''?'<div class="alert alert-danger" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#email">Set Now</a></div>':'';?>
    <div class="row">
<?php
$ss=$db->prepare("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."iplist` WHERE ti >= :ti");
$ss->execute(['ti'=>time()-604800]);
$sa=$ss->fetch(PDO::FETCH_ASSOC);
$bc=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Chrome'")->fetch(PDO::FETCH_ASSOC);
$bie=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Explorer'")->fetch(PDO::FETCH_ASSOC);
$be=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Edge'")->fetch(PDO::FETCH_ASSOC);
$bf=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Firefox'")->fetch(PDO::FETCH_ASSOC);
$bo=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Opera'")->fetch(PDO::FETCH_ASSOC);
$bs=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Safari'")->fetch(PDO::FETCH_ASSOC);
$sb=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Bing'")->fetch(PDO::FETCH_ASSOC);
$sd=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='DuckDuckGo'")->fetch(PDO::FETCH_ASSOC);
$sf=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Facebook' OR urlDest LIKE '%fbclid=%'")->fetch(PDO::FETCH_ASSOC);
$sg=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Google'")->fetch(PDO::FETCH_ASSOC);
$sy=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Yahoo'")->fetch(PDO::FETCH_ASSOC);
if($user['options']{3}==1){
  if($nm['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/messages';?>">
        <span class="card">
          <span class="card-header h5">Messages</span>
          <span class="card-body card-text">
            <span id="stats-messages"><?php echo$nm['cnt'];?></span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('inbox','i-5x');?></span>
        </span>
      </a>
<?php }
}
if($nb['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">
        <span class="card">
          <span class="card-header h5">Bookings</span>
          <span class="card-body card-text">
            <span id="stats-bookings"><?php echo$nb['cnt'];?></span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('calendar','i-5x');?></span>
        </span>
      </a>
<?php }
if($nc['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/comments';?>">
        <span class="card">
          <span class="card-header h5">Comments</span>
          <span class="card-body card-text">
            <span id="stats-comments"><?php echo$nc['cnt'];?></span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('comments','i-5x');?></span>
        </span>
      </a>
<?php }
if($nr['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/reviews';?>">
        <span class="card">
          <span class="card-header h5">Reviews</span>
          <span class="card-body card-text">
            <span id="stats-reviews"><?php echo$nr['cnt'];?></span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('review','i-5x');?></span>
        </span>
      </a>
<?php }
if($nt['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>">
        <span class="card">
          <span class="card-header h5">Testimonials</span>
          <span class="card-body card-text">
            <span id="stats-testimonials"><?php echo$nt['cnt'];?></span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('testimonial','i-5x');?></span>
        </span>
      </a>
<?php }
if($user['options']{4}==1){
  if($po['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/orders';?>">
        <span class="card">
          <span class="card-header h5">Orders</span>
          <span class="card-body card-text">
            <span id="stats-orders"><?php echo$po['cnt'];?></span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('order','i-5x');?></span>
        </span>
      </a>
<?php }
}
if($sa['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/security#tab-security-blacklist';?>">
        <span class="card">
          <span class="card-header h5">Blacklist</span>
          <span class="card-body card-text">
            <span id="browser-blacklist"><?php echo$sa['cnt'];?></span><br>
            <small>Added Last 7 Days</small>
          </span>
          <span class="icon"><?php svg('security','i-5x');?></span>
        </span>
      </a>
<?php }
if($sg['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/google';?>">
        <span class="card">
          <span class="card-header h5">Google</span>
          <span class="card-body card-text">
            <span id="browser-google"><?php echo$sg['cnt'];?></span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('brand-google','i-5x');?></span>
        </span>
      </a>
<?php }
if($sy['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/yahoo';?>">
        <span class="card">
          <span class="card-header h5">Yahoo</span>
          <span class="card-body card-text">
            <span id="browser-yahoo"><?php echo$sy['cnt'];?></span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('social-yahoo','i-5x');?></span>
        </span>
      </a>
<?php }
if($sb['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/bing';?>">
        <span class="card">
          <span class="card-header h5">Bing</span>
          <span class="card-body card-text">
            <span id="browser-bing"><?php echo$sb['cnt'];?></span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('brand-bing','i-5x');?></span>
        </span>
      </a>
<?php }
if($sd['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/duckduckgo';?>">
        <span class="card">
          <span class="card-header h5">DuckDuckGo</span>
          <span class="card-body card-text">
            <span id="browser-duckduckgo"><?php echo$sd['cnt'];?></span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('brand-duckduckgo','i-5x');?></span>
        </span>
      </a>
<?php }
if($sf['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/facebook';?>">
        <span class="card">
          <span class="card-header h5">Facebook</span>
          <span class="card-body card-text">
            <span id="browser-facebook"><?php echo$sf['cnt'];?></span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('social-facebook','i-5x');?></span>
        </span>
      </a>
<?php }
if($bc['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/chrome';?>">
        <span class="card">
          <span class="card-header h5">Chrome</span>
          <span class="card-body card-text">
            <span id="browser-chrome"><?php echo$bc['cnt'];?></span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-chrome','i-5x');?></span>
        </span>
      </a>
<?php }
if($be['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/edge';?>">
        <span class="card">
          <span class="card-header h5">Edge</span>
          <span class="card-body card-text">
            <span id="browser-edge"><?php echo$be['cnt'];?></span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-edge','i-5x');?></span>
        </span>
      </a>
<?php }
if($bie['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/explorer';?>">
        <span class="card">
          <span class="card-header h5">Explorer</span>
          <span class="card-body card-text">
            <span id="browser-explorer"><?php echo$bie['cnt'];?></span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-explorer','i-5x');?></span>
        </span>
      </a>
<?php }
if($bf['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/firefox';?>">
        <span class="card">
          <span class="card-header h5">Firefox</span>
          <span class="card-body card-text">
            <span id="browser-firefox"><?php echo$bf['cnt'];?></span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-firefox','i-5x');?></span>
        </span>
      </a>
<?php }
if($bo['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/opera';?>">
        <span class="card">
          <span class="card-header h5">Opera</span>
          <span class="card-body card-text">
            <span id="browser-opera"><?php echo$bo['cnt'];?></span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-opera','i-5x');?></span>
        </span>
      </a>
<?php }
if($bs['cnt']>0){?>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/safari';?>">
        <span class="card">
          <span class="card-header h5">Safari</span>
          <span class="card-body card-text">
            <span id="browser-safari"><?php echo$bs['cnt'];?></span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-safari','i-5x');?></span>
        </span>
      </a>
<?php } ?>
    </div>
    <div class="row">
<?php $s=$db->query("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC LIMIT 10");
if($s->rowCount()>0){?>
      <div class="col-12 col-sm-6">
        <div class="card">
          <div class="card-header"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>">Recent Admin Activity</a></div>
          <div id="seostats-activity" class="card-body">
            <table class="table table-responsive-sm table-stripe table-sm table-hover">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>User</th>
                  <th>Activity</th>
                </tr>
              </thead>
              <tbody>
<?php  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <tr>
                  <td class="small"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                  <td class="small"><?php echo$r['username'].':'.$r['name'];?></td>
                  <td class="small"><?php echo$r['action'].' > '.$r['refTable'].' > '.$r['refColumn'];?></td>
                </tr>
<?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
<?php }
$row=array();;
$s=$db->query("SELECT title,views FROM menu WHERE active='1' AND views!=0");
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $row[]=[
      'contentType'=>'Page',
      'title'=>$r['title'],
      'views'=>$r['views']
    ];
  }
}
$s=$db->query("SELECT contentType,title,views FROM content WHERE views!=0");
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $row[]=[
      'contentType'=>$r['contentType'],
      'title'=>$r['title'],
      'views'=>$r['views']
    ];
  }
}?>
      <div class="col-12 col-sm-6">
        <div class="card">
          <div class="card-header">Top Ten Highest Viewed Pages</div>
          <div id="seostats-pageviews" class="card-body">
            <table class="table table-responsive-sm table-striped table-sm table-hover">
              <thead>
                <tr>
                  <th class="col">Page</th>
                  <th class="col text-center">Views</th>
                </tr>
              </thead>
              <tbody>
<?php
function array_sort_by_column(&$a,$c,$d=SORT_DESC){
  $sc=array();
  foreach($a as$k=>$r){
    $sc[$k]=$r[$c];
  }
  array_multisort($sc,$d,$a);
}
array_sort_by_column($row, 'views');
$i=1;
foreach($row as $r){?>
                <tr>
                  <td class="small text-truncated"><?php echo($r['contentType']!='Page'?ucfirst($r['contentType']).' ~ ':'').$r['title'];?></td>
                  <td class="text-center"><?php echo$r['views'];?></td>
                </tr>
<?php $i++;if($i>10)break;
}?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
<?php if(file_exists('CHANGELOG.md')){?>
      <div class="col-12 col-sm-6">
        <div class="card">
          <div class="card-header"><a target="_blank" href="https://github.com/DiemenDesign/AuroraCMS">Latest Project Updates</a></div>
          <div class="card-body">
            <pre>
<?php include'CHANGELOG.md';?>
            </pre>
          </div>
        </div>
      </div>
<?php }?>
    </div>
  </div>
</main>
<?php }
