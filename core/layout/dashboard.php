<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard
 * @package    core/layout/dashboard.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.1 Improve Statistic Panels
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
      <div class="card mx-3">
        <div class="card-header h5">
          Shuffled Website Suggestions
          <span class="float-right">
            <button class="btn btn-secondary btn-sm" onclick="$('.webseo').removeClass('hidden').addClass('animated fadeIn');$(this).addClass('hidden');">Show All</button>
          </span>
        </div>
        <div class="card-body">
          <div class="card-text small text-muted">
            Note: The information provided here, are only suggestions, mileage will vary depending on numberous factors, for e.g. Industry, Content, Geographic Location, and so on. The suggestions have been gathered from many sources, and used if they make the most sense to help improve visitor interaction and hopefully converting visits to sales.
          </div>
<?php $webseo=rand(0,9);
/*
https://therecipeforseosuccess.com/ecommerce-seo-6-silly-mistakes/
https://therecipeforseosuccess.com/pr-using-media-boost-seo/
*/
?>
          <div class="webseo card-text my-3<?php echo($webseo==0?'':' hidden');?>">
            Do you have a slider? Get rid of it, they slow sites down and heat map studies show that no one looks at them. - via <a target="_blank" href="https://www.katetoon.com/">Kate Toon</a><br>
            We suggest that if you do indeed need to have a slider, make sure to optimise images if used, or consider using a text based Slider with an optimised background image.
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==1?'':' hidden');?>">
            Have you setup a <strong>Google My Business</strong> yet? This can greatly help with exposure for your website, as not only will it improve visbility for search's, it will also help finding your business using Google Maps. You can do it here <a target="_blank" href="https://www.google.com.au/business/">Google My Business</a>
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==2?'':' hidden');?>">
            Do you have the word <strong>Us</strong> about <strong>About</strong> and <strong>Contact</strong>, get rid of it, it's not necessary. Remove the pronoun from your navigation and just have <strong>ABOUT</strong> and <strong>CONTACT</strong>. A cleaner nav is a better nav. - via <a target="_blank" href="https://www.katetoon.com/">Kate Toon</a>
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==3?'':' hidden');?>">
            Do you have light grey font instead of black, change it to black, contrast is really important for readability. - via <a target="_blank" href="https://www.katetoon.com/">Kate Toon</a>
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==4?'':' hidden');?>">
            Don't use CAPITALS for your text descriptions, it looks shouty. While it shouldn't affect how Search Engines index capitalized content, it doesn't look good to readers.
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==5?'':' hidden');?>">
            Can I tell what you do and who you do it for with in 10 seconds of visiting your page? If not add some clear copy that explains this. - via <a target="_blank" href="https://www.katetoon.com/">Kate Toon</a>
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==6?'':' hidden');?>">
            Do you have a clear call to action button somewhere near the top of your page? Book now, shop now, get in touch, check out services...? Is the CTA button in a contrasting colour so it really pops? - via <a target="_blank" href="https://www.katetoon.com/">Kate Toon</a>
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==7?'':' hidden');?>">
            Be sure to use descriptive filenames for images, and to fill in the <strong>imageALT</strong> field for images where available. AuroraCMS will however automatically use the <strong>title</strong> text if the <strong>imageALT</strong> is left empty, but may not be optimal.
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==8?'':' hidden');?>">
            Do you have a pop up? Does it launch really quickly Slow it down to 45 seconds or on exit, and Limit the text on your pop up to max 20 words, and only ask for first name and email address. - via <a target="_blank" href="https://www.katetoon.com/">Kate Toon</a>
          </div>
          <div class="webseo card-text my-3<?php echo($webseo==9?'':' hidden');?>">
            Ensure your site passes the 'we we' test, is it all about you? Or all about your customers. Try to change as many we statements to You statements. - via <a target="_blank" href="https://www.katetoon.com/">Kate Toon</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/messages';?>">
        <span class="card">
          <span class="card-header h5">Messages</span>
          <span class="card-body card-text">
            <span id="stats-messages">0</span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('inbox','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">
        <span class="card">
          <span class="card-header h5">Bookings</span>
          <span class="card-body card-text">
            <span id="stats-bookings">0</span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('calendar','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/comments';?>">
        <span class="card">
          <span class="card-header h5">Comments</span>
          <span class="card-body card-text">
            <span id="stats-comments">0</span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('comments','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/reviews';?>">
        <span class="card">
          <span class="card-header h5">Reviews</span>
          <span class="card-body card-text">
            <span id="stats-reviews">0</span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('review','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>">
        <span class="card">
          <span class="card-header h5">Testimonials</span>
          <span class="card-body card-text">
            <span id="stats-testimonials">0</span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('testimonial','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/orders';?>">
        <span class="card">
          <span class="card-header h5">Orders</span>
          <span class="card-body card-text">
            <span id="stats-orders">0</span><br>
            <small>New</small>
          </span>
          <span class="icon"><?php svg('order','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/security#tab-security-blacklist';?>">
        <span class="card">
          <span class="card-header h5">Blacklist</span>
          <span class="card-body card-text">
            <span id="browser-blacklist">0</span><br>
            <small>Added Last 7 Days</small>
          </span>
          <span class="icon"><?php svg('security','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/google';?>">
        <span class="card">
          <span class="card-header h5">Google</span>
          <span class="card-body card-text">
            <span id="browser-google">0</span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('brand-google','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/yahoo';?>">
        <span class="card">
          <span class="card-header h5">Yahoo</span>
          <span class="card-body card-text">
            <span id="browser-yahoo">0</span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('social-yahoo','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/bing';?>">
        <span class="card">
          <span class="card-header h5">Bing</span>
          <span class="card-body card-text">
            <span id="browser-bing">0</span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('brand-bing','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/duckduckgo';?>">
        <span class="card">
          <span class="card-header h5">DuckDuckGo</span>
          <span class="card-body card-text">
            <span id="browser-duckduckgo">0</span><br>
            <small>Bots Visits</small>
          </span>
          <span class="icon"><?php svg('brand-duckduckgo','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/facebook';?>">
        <span class="card">
          <span class="card-header h5">Facebook</span>
          <span class="card-body card-text">
            <span id="browser-facebook">0</span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('social-facebook','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/chrome';?>">
        <span class="card">
          <span class="card-header h5">Chrome</span>
          <span class="card-body card-text">
            <span id="browser-chrome">0</span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-chrome','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/edge';?>">
        <span class="card">
          <span class="card-header h5">Edge</span>
          <span class="card-body card-text">
            <span id="browser-edge">0</span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-edge','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/explorer';?>">
        <span class="card">
          <span class="card-header h5">Explorer</span>
          <span class="card-body card-text">
            <span id="browser-explorer">0</span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-explorer','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/firefox';?>">
        <span class="card">
          <span class="card-header h5">Firefox</span>
          <span class="card-body card-text">
            <span id="browser-firefox">0</span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-firefox','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/opera';?>">
        <span class="card">
          <span class="card-header h5">Opera</span>
          <span class="card-body card-text">
            <span id="browser-opera">0</span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-opera','i-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker/safari';?>">
        <span class="card">
          <span class="card-header h5">Safari</span>
          <span class="card-body card-text">
            <span id="browser-safari">0</span><br>
            <small>Views</small>
          </span>
          <span class="icon"><?php svg('browser-safari','i-5x');?></span>
        </span>
      </a>
    </div>
    <script>
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
  $sy=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Yahoo'")->fetch(PDO::FETCH_ASSOC);?>
      document.addEventListener("DOMContentLoaded",function(event){
        $('#stats-messages').countTo({from:0,to:<?php echo$nm['cnt'];?>});
        $('#stats-bookings').countTo({from:0,to:<?php echo$nb['cnt'];?>});
        $('#stats-comments').countTo({from:0,to:<?php echo$nc['cnt'];?>});
        $('#stats-reviews').countTo({from:0,to:<?php echo$nr['cnt'];?>});
        $('#stats-testimonials').countTo({from:0,to:<?php echo$nt['cnt'];?>});
        $('#stats-orders').countTo({from:0,to:<?php echo$po['cnt'];?>});
        $('#browser-chrome').countTo({from:0,to:<?php echo$bc['cnt'];?>});
        $('#browser-explorer').countTo({from:0,to:<?php echo$bie['cnt'];?>});
        $('#browser-edge').countTo({from:0,to:<?php echo$be['cnt'];?>});
        $('#browser-firefox').countTo({from:0,to:<?php echo$bf['cnt'];?>});
        $('#browser-opera').countTo({from:0,to:<?php echo$bo['cnt'];?>});
        $('#browser-safari').countTo({from:0,to:<?php echo$bs['cnt'];?>});
        $('#browser-bing').countTo({from:0,to:<?php echo$sb['cnt'];?>});
        $('#browser-duckduckgo').countTo({from:0,to:<?php echo$sd['cnt'];?>});
        $('#browesr-google').countTo({from:0,to:<?php echo$sg['cnt'];?>});
        $('#browser-yahoo').countTo({from:0,to:<?php echo$sy['cnt'];?>});
        $('#browser-facebook').countTo({from:0,to:<?php echo$sf['cnt'];?>});
        $('#browser-blacklist').countTo({from:0,to:<?php echo$sa['cnt'];?>});
      });
    </script>
    <div class="row">
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
<?php $s=$db->query("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC LIMIT 10");
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
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
      <div class="col-12 col-sm-6">
        <div class="card">
          <div class="card-header"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>">Highest Viewed Pages</a></div>
          <div id="seostats-pageviews" class="card-body">
<?php $s=$db->query("SELECT urlDest,count(*) count FROM `".$prefix."tracker` GROUP BY urlDest ORDER BY count DESC LIMIT 10");?>
            <table class="table table-responsive-sm table-striped table-sm table-hover">
              <thead>
                <tr>
                  <th>Page</th>
                  <th class="col text-center">Tracked Views</th>
                </tr>
              </thead>
              <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $sc=$db->prepare("SELECT COUNT(urlDest) AS cnt FROM `".$prefix."tracker` WHERE urlDest=:urlDest");
  $sc->execute([':urlDest'=>$r['urlDest']]);
  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
                <tr>
                  <td class="small text-truncated"><?php echo$r['urlDest'];?></td>
                  <td class="text-center"><?php echo$c['cnt'];?></td>
                </tr>
<?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
<?php if(file_exists('CHANGELOG.md')){?>
    <div class="row">
      <div class="col-12 col-sm-6">
        <div class="card">
          <div class="card-header"><a target="_blank" href="https://github.com/DiemenDesign/AuroraCMS">Latest Github Project Updates</a></div>
          <div class="card-body">
            <pre>
<?php include'CHANGELOG.md';?>
            </pre>
          </div>
        </div>
<?php }?>
      </div>
    </div>
  </div>
</main>
<?php }
