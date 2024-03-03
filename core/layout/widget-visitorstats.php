<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Visitor Stats
 * @package    core/layout/widget-visitorstats.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($config['options'][11]==1){
  $week1start=strtotime("last sunday midnight this week");
  $week1end=strtotime("saturday this week");
  $sm=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `ti` >= :ti1 AND `ti` <= :ti2");
  $sm->execute([
    ':ti1'=>$week1start,
    ':ti2'=>$week1end
  ]);
  $rm=$sm->fetch(PDO::FETCH_ASSOC);
  $previous_week = strtotime("-1 week +1 day",$ti);
  $week2start = strtotime("last sunday midnight",$previous_week);
  $week2end = strtotime("next saturday",$week2start);
  $sm2=$db->prepare("SELECT SUM(`direct`) AS `direct`, SUM(`google`) AS `google`, SUM(`reddit`) AS `reddit`, SUM(`facebook`) AS `facebook`, SUM(`instagram`) AS `instagram`, SUM(`threads`) AS `threads`, SUM(`twitter`) AS `twitter`, SUM(`linkedin`) AS `linkedin`, SUM(`duckduckgo`) AS `duckduckgo`, SUM(`bing`) AS `bing` FROM `".$prefix."visit_tracker` WHERE `ti` >= :ti1 AND `ti` <= :ti2");
  $sm2->execute([
    ':ti1'=>$week2start,
    ':ti2'=>$week2end
  ]);
  $rm2=$sm2->fetch(PDO::FETCH_ASSOC);?>
  <div class="row justify-content-center">
    <div class="card stats col-11 col-sm-5 p-1 m-1">
      <div class="h6 text-muted text-center">Incoming Links (this week)</div>
      <div class="row">
        <div class="col-12 col-sm zebra">
          <div class="row p-2">
            <div class="col-1"><i class="i i-3x">browser-general</i></div>
            <div class="col-5 pl-3 py-1">Direct</div>
            <div class="col-6 text-right py-1">
              <?=($rm2['direct']>0?($rm['direct']<$rm2['direct']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['direct'] - $rm['direct']).'</small>':'').($rm2['direct']<$rm['direct']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['direct'] - $rm2['direct']).'</small>':''):'').short_number($rm['direct']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-google i-3x">social-google</i></div>
            <div class="col pl-3 py-1">Google</div>
            <div class="col text-right py-1">
              <?=($rm2['google']>0?($rm['google']<$rm2['google']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['google'] - $rm['google']).'</small>':'').($rm2['google']<$rm['google']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['google'] - $rm2['google']).'</small>':''):'').short_number($rm['google']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-duckduckgo i-3x">social-duckduckgo</i></div>
            <div class="col pl-3 py-1">DuckDuckGo</div>
            <div class="col text-right py-1">
              <?=($rm2['duckduckgo']>0?($rm['duckduckgo']<$rm2['duckduckgo']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['duckduckgo'] - $rm['duckduckgo']).'</small>':'').($rm2['duckduckgo']<$rm['duckduckgo']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['duckduckgo'] - $rm2['duckduckgo']).'</small>':''):'').short_number($rm['duckduckgo']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-bing i-3x">social-bing</i></div>
            <div class="col pl-3 py-1">Bing</div>
            <div class="col text-right py-1">
              <?=($rm2['bing']>0?($rm['bing']<$rm2['bing']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['bing'] - $rm['bing']).'</small>':'').($rm2['bing']<$rm['bing']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['bing'] - $rm2['bing']).'</small>':''):'').short_number($rm['bing']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-reddit i-3x">social-reddit</i></div>
            <div class="col pl-3 py-1">Reddit</div>
            <div class="col text-right py-1">
              <?=($rm2['reddit']>0?($rm['reddit']<$rm2['reddit']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['reddit'] - $rm['reddit']).'</small>':'').($rm2['reddit']<$rm['reddit']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['reddit'] - $rm2['reddit']).'</small>':''):'').short_number($rm['reddit']);?>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm zebra">
          <div class="d-none"></div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-facebook i-3x">social-facebook</i></div>
            <div class="col pl-3 py-1">Facebook</div>
            <div class="col text-right py-1">
              <?=($rm2['facebook']>0?($rm['facebook']<$rm2['facebook']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['facebook'] - $rm['facebook']).'</small>':'').($rm2['facebook']<$rm['facebook']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['facebook'] - $rm2['facebook']).'</small>':''):'').short_number($rm['facebook']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-threads i-3x">social-threads</i></div>
            <div class="col pl-3 py-1">Threads</div>
            <div class="col text-right py-1">
              <?=($rm2['threads']>0?($rm['threads']<$rm2['threads']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['threads'] - $rm['threads']).'</small>':'').($rm2['threads']<$rm['threads']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['threads'] - $rm2['threads']).'</small>':''):'').short_number($rm['threads']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-instagram i-3x">social-instagram</i></div>
            <div class="col pl-3 py-1">Instagram</div>
            <div class="col text-right py-1">
              <?=($rm2['instagram']>0?($rm['instagram']<$rm2['instagram']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['instagram'] - $rm['instagram']).'</small>':'').($rm2['instagram']<$rm['instagram']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['instagram'] - $rm2['instagram']).'</small>':''):'').short_number($rm['instagram']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-twitter i-3x">social-twitter</i></div>
            <div class="col pl-3 pt-1">Twitter</div>
            <div class="col text-right py-1">
              <?=($rm2['twitter']>0?($rm['twitter']<$rm2['twitter']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['twitter'] - $rm['twitter']).'</small>':'').($rm2['twitter']<$rm['twitter']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['twitter'] - $rm2['twitter']).'</small>':''):'').short_number($rm['twitter']);?>
            </div>
          </div>
          <div class="row p-2">
            <div class="col-1"><i class="i i-social social-linkedin i-3x">social-linkedin</i></div>
            <div class="col pl-3 pt-1">Linkedin</div>
            <div class="col text-right py-1">
              <?=($rm2['linkedin']>0?($rm['linkedin']<$rm2['linkedin']?'<small class="pr-2 text-danger">&darr;'.short_number($rm2['linkedin'] - $rm['linkedin']).'</small>':'').($rm2['linkedin']<$rm['linkedin']?'<small class="pr-2 text-success">&uarr;'.short_number($rm['linkedin'] - $rm2['linkedin']).'</small>':''):'').short_number($rm['linkedin']);?>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php }?>
  <div class="col-12 col-sm">
    <div class="row justify-content-center">
      <?php $ss=$db->prepare("SELECT COUNT(DISTINCT `ip`) AS cnt FROM `".$prefix."iplist` WHERE `ti`>=:ti");
      $ss->execute(['ti'=>time()-604800]);
      $sa=$ss->fetch(PDO::FETCH_ASSOC);
      $currentMonthStart=mktime(0, 0, 0, date("n"), 1);
      if($user['options'][3]==1){?>
        <a class="card stats col-11 col-sm p-1 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/messages';?>">
          <span class="h6 text-muted">Messages</span>
          <span class="px-0 py-2">
            <span class="text-3x" id="stats-messages"><?=(isset($nm['cnt'])?short_number($nm['cnt']):0);?></span>
            <small class="d-block text-muted"><small>New</small></small>
          </span>
          <span class="icon"><i class="i i-5x">inbox</i></span>
        </a>
      <?php }?>
      <a class="card stats col-11 col-sm p-1 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/bookings';?>">
        <span class="h6 text-muted">Bookings</span>
        <span class="px-0 py-2">
          <span class="text-3x" id="stats-bookings"><?=(isset($nb['cnt'])?short_number($nb['cnt']):0);?></span>
          <small class="d-block text-muted"><small>New</small></small>
        </span>
        <span class="icon"><i class="i i-5x">calendar</i></span>
      </a>
      <a class="card stats col-11 col-sm p-1 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/comments';?>">
        <span class="h6 text-muted">Comments</span>
        <span class="px-0 py-2">
          <span class="text-3x" id="stats-comments"><?=(isset($nc['cnt'])?short_number($nc['cnt']):0);?></span>
          <small class="d-block text-muted"><small>New</small></small>
        </span>
        <span class="icon"><i class="i i-5x">comments</i></span>
      </a>
      <a class="card stats col-11 col-sm p-1 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/reviews';?>">
        <span class="h6 text-muted">Reviews</span>
        <span class="px-0 py-2">
          <span class="text-3x" id="stats-reviews"><?=(isset($nr['cnt'])?short_number($nr['cnt']):0);?></span>
          <small class="d-block text-muted"><small>New</small></small>
        </span>
        <span class="icon"><i class="i i-5x">review</i></span>
      </a>
    </div>
    <div class="col-12 col-sm">
      <div class="row justify-content-center">
        <a class="card stats col-11 col-sm p-1 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/content/type/testimonials';?>">
          <span class="h6 text-muted">Testimonials</span>
          <span class="px-0 py-2">
            <span class="text-3x" id="stats-testimonials"><?=(isset($nt['cnt'])?short_number($nt['cnt']):0);?></span>
            <small class="d-block text-muted"><small>New</small></small>
          </span>
          <span class="icon"><i class="i i-5x">testimonial</i></span>
        </a>
        <?php if($user['options'][4]==1){?>
          <a class="card stats col-11 col-sm p-1 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/orders';?>">
            <span class="h6 text-muted">Orders</span>
            <span class="px-0 py-2">
              <span class="text-3x" id="stats-orders"><?=(isset($po['cnt'])?short_number($po['cnt']):0);?></span>
              <small class="d-block text-muted"><small>New</small></small>
            </span>
            <span class="icon"><i class="i i-5x">order</i></span>
          </a>
        <?php }?>
        <a class="card stats col-11 col-sm p-1 m-1 text-center" href="<?= URL.$settings['system']['admin'].'/security/settings#tab1-3';?>">
          <span class="h6 text-muted">Blacklist</span>
          <span class="px-0 py-2">
            <span class="text-3x" id="browser-blacklist"><?=(isset($sa['cnt'])?short_number($sa['cnt']):0);?></span>
            <small class="d-block text-muted"><small>Added Last 7 Days</small></small>
          </span>
          <span class="icon"><i class="i i-5x">security</i></span>
        </a>
      </div>
    </div>
  </div>
</div>
