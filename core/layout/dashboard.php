<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard
 * @package    core/layout/dashboard.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */
if(isset($args[0])&&$args[0]=='settings')
  require'core/layout/set_dashboard.php';
else{?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('dashboard','i-3x');?></div>
          <div>Dashboard</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-3">
        <?php $curHr=date('G');
        $msg='<h5 class="welcome-message my-4">';
        if($curHr<12)
          $msg.='Good Morning ';
        elseif($curHr<18)
          $msg.='Good Afternoon ';
        else
          $msg.='Good Evening ';
        $msg.=($user['name']!=''?strtok($user['name'], " "):$user['username']).'!'."<br>The date is ".date($config['dateFormat'])."</h5>";
        echo$msg.($config['maintenance'][0]==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Maintenance Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#maintenance">Set Now</a></div>':'').($config['comingsoon'][0]==1?'<div class="alert alert-info" role="alert">Note: Site is currently in Coming Soon Mode! <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#comingsoon">Set Now</a></div>':'');
        if(!file_exists('layout/'.$config['theme'].'/theme.ini')){
          echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
        }
        $tid=$ti-2592000;
        if($config['business']==''){
          echo'<div class="alert alert-danger" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Booking will NOT function currectly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#business">Set Now</a></div>';
        }
        if($config['email']==''){
          echo$config['email']==''?'<div class="alert alert-danger" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly. <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#email">Set Now</a></div>':'';
        }
        $sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`='seotips' ORDER BY rand() LIMIT 1");
        $sc->execute();
        if($sc->rowCount()>0){
          $rc=$sc->fetch(PDO::FETCH_ASSOC);
          echo'<div class="row">'.
            '<div class="alert alert-info">'.
              '<span id="seotip"><strong>Unsolicited SEO Tip:</strong> '.$rc['notes'].'</span><br>'.
              '<a href="#" data-fancybox data-type="ajax" data-src="core/seolist.php">Read them all.</a>'.
            '</div>'.
          '</div>';
        }?>
        <div class="row">
          <?php $ss=$db->prepare("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."iplist` WHERE `ti`>=:ti");
          $ss->execute([
            'ti'=>time()-604800
          ]);
          $sa=$ss->fetch(PDO::FETCH_ASSOC);
          $bc=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Chrome'")->fetch(PDO::FETCH_ASSOC);
          $bie=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Explorer'")->fetch(PDO::FETCH_ASSOC);
          $be=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Edge'")->fetch(PDO::FETCH_ASSOC);
          $bf=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Firefox'")->fetch(PDO::FETCH_ASSOC);
          $bo=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Opera'")->fetch(PDO::FETCH_ASSOC);
          $bs=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Safari'")->fetch(PDO::FETCH_ASSOC);
          $sb=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Bing'")->fetch(PDO::FETCH_ASSOC);
          $sd=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='DuckDuckGo'")->fetch(PDO::FETCH_ASSOC);
          $sf=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Facebook' OR urlDest LIKE '%fbclid=%'")->fetch(PDO::FETCH_ASSOC);
          $sg=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Google'")->fetch(PDO::FETCH_ASSOC);
          $sy=$db->query("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."tracker` WHERE `browser`='Yahoo'")->fetch(PDO::FETCH_ASSOC);
          if($user['options'][3]==1){
            if($nm['cnt']>0){?>
              <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/messages';?>">
                <span class="h5">Messages</span>
                  <span class="p-0">
                    <span class="text-3x" id="stats-messages"><?=$nm['cnt'];?></span> <small><small>New</small></small>
                  </span>
                  <span class="icon"><?= svg2('inbox','i-5x');?></span>
              </a>
            <?php }
          }
          if($nb['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/bookings';?>">
              <span class="h5">Bookings</span>
              <span class="p-0">
                <span class="text-3x" id="stats-bookings"><?=$nb['cnt'];?></span> <small><small>New</small></small>
              </span>
              <span class="icon"><?= svg2('calendar','i-5x');?></span>
            </a>
          <?php }
          if($nc['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/comments';?>">
              <span class="h5">Comments</span>
              <span class="p-0">
                <span class="text-3x" id="stats-comments"><?=$nc['cnt'];?></span> <small><small>New</small></small>
              </span>
              <span class="icon"><?= svg2('comments','i-5x');?></span>
            </a>
          <?php }
          if($nr['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/reviews';?>">
              <span class="h5">Reviews</span>
              <span class="p-0">
                <span class="text-3x" id="stats-reviews"><?=$nr['cnt'];?></span> <small><small>New</small></small>
                </span>
              <span class="icon"><?= svg2('review','i-5x');?></span>
            </a>
          <?php }
          if($nt['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/content/type/testimonials';?>">
              <span class="h5">Testimonials</span>
              <span class="p-0">
                <span class="text-3x" id="stats-testimonials"><?=$nt['cnt'];?></span> <small><small>New</small></small>
              </span>
              <span class="icon"><?= svg2('testimonial','i-5x');?></span>
            </a>
          <?php }
          if($user['options'][4]==1){
            if($po['cnt']>0){?>
              <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/orders';?>">
                <span class="h5">Orders</span>
                <span class="p-0">
                  <span class="text-3x" id="stats-orders"><?=$po['cnt'];?></span> <small><small>New</small></small>
                </span>
                <span class="icon"><?= svg2('order','i-5x');?></span>
              </a>
            <?php }
          }
          if($sa['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/security#tab-security-blacklist';?>">
              <span class="h5">Blacklist</span>
              <span class="p-0">
                <span class="text-3x" id="browser-blacklist"><?=$sa['cnt'];?></span> <small><small>Added Last 7 Days</small></small>
              </span>
              <span class="icon"><?= svg2('security','i-5x');?></span>
            </a>
          <?php }
          if($sg['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/google';?>">
              <span class="h5">Google</span>
              <span class="p-0">
                <span class="text-3x" id="browser-google"><?=$sg['cnt'];?></span> <small><small>Bots Visits</small></small>
              </span>
              <span class="icon"><?= svg2('brand-google','i-5x');?></span>
            </a>
          <?php }
          if($sy['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/yahoo';?>">
              <span class="h5">Yahoo</span>
              <span class="p-0">
                <span class="text-3x" id="browser-yahoo"><?=$sy['cnt'];?></span> <small><small>Bots Visits</small></small>
              </span>
              <span class="icon"><?= svg2('social-yahoo','i-5x');?></span>
            </a>
          <?php }
          if($sb['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/bing';?>">
              <span class="h5">Bing</span>
              <span class="p-0">
                <span class="text-3x" id="browser-bing"><?=$sb['cnt'];?></span> <small><small>Bots Visits</small></small>
              </span>
              <span class="icon"><?= svg2('brand-bing','i-5x');?></span>
            </a>
          <?php }
          if($sd['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/duckduckgo';?>">
              <span class="h5">DuckDuckGo</span>
              <span class="p-0">
                <span class="text-3x" id="browser-duckduckgo"><?=$sd['cnt'];?></span> <small><small>Bots Visits</small></small>
              </span>
              <span class="icon"><?= svg2('brand-duckduckgo','i-5x');?></span>
            </a>
          <?php }
          if($sf['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/facebook';?>">
              <span class="h5">Facebook</span>
              <span class="p-0">
                <span class="text-3x" id="browser-facebook"><?=$sf['cnt'];?></span> <small><small>Views</small></small>
              </span>
              <span class="icon"><?= svg2('social-facebook','i-5x');?></span>
            </a>
          <?php }
          if($bc['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/chrome';?>">
              <span class="h5">Chrome</span>
              <span class="p-0">
                <span class="text-3x" id="browser-chrome"><?=$bc['cnt'];?></span> <small><small>Views</small></small>
              </span>
              <span class="icon"><?= svg2('browser-chrome','i-5x');?></span>
            </a>
          <?php }
          if($be['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/edge';?>">
              <span class="h5">Edge</span>
              <span class="p-0">
                <span class="text-3x" id="browser-edge"><?=$be['cnt'];?></span> <small><small>Views</small></small>
              </span>
              <span class="icon"><?= svg2('browser-edge','i-5x');?></span>
            </a>
          <?php }
          if($bie['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/explorer';?>">
              <span class="h5">Explorer</span>
              <span class="p-0">
                <span class="text-3x" id="browser-explorer"><?=$bie['cnt'];?></span> <small><small>Views</small></small>
              </span>
              <span class="icon"><?= svg2('browser-explorer','i-5x');?></span>
            </a>
          <?php }
          if($bf['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/firefox';?>">
              <span class="h5">Firefox</span>
              <span class="p-0">
                <span class="text-3x" id="browser-firefox"><?=$bf['cnt'];?></span> <small><small>Views</small></small>
              </span>
              <span class="icon"><?= svg2('browser-firefox','i-5x');?></span>
            </a>
          <?php }
          if($bo['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/opera';?>">
              <span class="h5">Opera</span>
              <span class="p-0">
                <span class="text-3x" id="browser-opera"><?=$bo['cnt'];?></span> <small><small>Views</small></small>
              </span>
              <span class="icon"><?= svg2('browser-opera','i-5x');?></span>
            </a>
          <?php }
          if($bs['cnt']>0){?>
            <a class="card stats col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-2 m-0 m-md-1" href="<?= URL.$settings['system']['admin'].'/preferences/tracker/safari';?>">
              <span class="h5">Safari</span>
              <span class="p-0">
                <span class="text-3x" id="browser-safari"><?=$bs['cnt'];?></span> <small><small>Views</small></small>
              </span>
              <span class="icon"><?= svg2('browser-safari','i-5x');?></span>
            </a>
          <?php } ?>
        </div>
        <div class="row mt-5">
          <?php $s=$db->query("SELECT * FROM `".$prefix."logs` ORDER BY `ti` DESC LIMIT 10");
          if($s->rowCount()>0){?>
          <div class="col-12 col-md-6 p-2">
            <div class="card">
              <div class="h5 m-2"><a href="<?= URL.$settings['system']['admin'].'/preferences/activity';?>">Recent Admin Activity</a></div>
              <div id="seostats-activity">
                <table class="table-zebra small">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>User</th>
                      <th>Activity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                      <tr>
                        <td><?= date($config['dateFormat'],$r['ti']);?></td>
                        <td><?=$r['username'].':'.$r['name'];?></td>
                        <td><?=$r['action'].' > '.$r['refTable'].' > '.$r['refColumn'];?></td>
                      </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php }
          $row=array();;
          $s=$db->query("SELECT `title`,`views` FROM menu WHERE `active`='1' AND `views`!=0");
          if($s->rowCount()>0){
            while($r=$s->fetch(PDO::FETCH_ASSOC)){
              $row[]=[
                'contentType'=>'Page',
                'title'=>$r['title'],
                'views'=>$r['views']
              ];
            }
          }
          $s=$db->query("SELECT `contentType`,`title`,`views` FROM `".$prefix."content` WHERE `views`!=0");
          if($s->rowCount()>0){
            while($r=$s->fetch(PDO::FETCH_ASSOC)){
              $row[]=[
                'contentType'=>$r['contentType'],
                'title'=>$r['title'],
                'views'=>$r['views']
              ];
            }
          }?>
          <div class="col-12 col-md-6 p-2">
            <div class="card">
              <div class="h5 m-2">Top Ten Highest Viewed Pages</div>
              <div id="seostats-pageviews">
                <table class="table-zebra small">
                  <thead>
                    <tr>
                      <th>Page</th>
                      <th class="text-center">Views</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php function array_sort_by_column(&$a,$c,$d=SORT_DESC){
                      $sc=array();
                      foreach($a as$k=>$r)$sc[$k]=$r[$c];
                      array_multisort($sc,$d,$a);
                    }
                    array_sort_by_column($row,'views');
                    $i=1;
                    foreach($row as $r){?>
                      <tr>
                        <td class="text-truncated"><?=($r['contentType']!='Page'?ucfirst($r['contentType']).' ~ ':'').$r['title'];?></td>
                        <td class="text-center"><?=$r['views'];?></td>
                      </tr>
                      <?php $i++;if($i>10)break;
                    }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
<?php $s=$db->prepare("SELECT DISTINCT(`keywords`) AS `keywords` FROM `".$prefix."tracker` WHERE `keywords`!='' ORDER BY keywords DESC LIMIT 0,10");
$s->execute();
if($s->rowCount()>0){?>
          <div class="col-12 col-md-6 p-2">
            <div class="card">
              <div class="h5 m-2">Top Ten Search Keywords</div>
              <div id="seostats-pageviews">
                <table class="table-zebra small">
                  <thead>
                    <tr>
                      <th>Keywords</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
$sr=$db->prepare("SELECT COUNT(`keywords`) AS `cnt` FROM `".$prefix."tracker` WHERE `keywords` LIKE :keywords");
$sr->execute([
  ':keywords'=>$r['keywords']
]);
$rr=$sr->fetch(PDO::FETCH_ASSOC);?>
                      <tr>
                        <td class="text-truncated"><?=$r['keywords'];?></td>
                        <td class="text-right"><?=$rr['cnt'];?></td>
                      </tr>
<?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
<?php }
if(file_exists('CHANGELOG.md')){
  require'core/parsedown/class.parsedown.php';?>
          <div class="col-12 col-md-6 p-2">
            <div class="card p-2">
              <div class="h5"><a target="_blank" href="https://github.com/DiemenDesign/AuroraCMS">Latest Project Updates</a></div>
              <p>
                <?php $Parsedown=new Parsedown();echo$Parsedown->text(file_get_contents('CHANGELOG.md'));?>
              </p>
            </div>
          </div>
          <?php }?>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php }
