<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Referrers
 * @package    core/layout/widget-referrers.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.25
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="6" data-mdmin="4" data-mdmax="6" data-lgmin="3" data-lgmax="6" data-xlmin="3" data-xlmax="3" data-xxlmin="2" data-xxlmax="2" id="l_<?=$rw['id'];?>">
  <div class="alert widget widget-limit m-3 p-0" id="widgetreferrers<?=$rw['id'];?>">
    <div class="toolbar px-2 py-1 handle">
      <?=$rw['title'].($config['development']==1?'<span id="width_'.$rw['id'].'"></span>':'');?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-9 py-1 text-muted small">Referrers</div><div class="col-3 py-1 text-muted text-right small">Visitors</div>
      <?php $currentMonthStart=mktime(0, 0, 0, date("n"), 1);
      $sr=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE `ti`>:sD");
      $sr->execute([':sD'=>$currentMonthStart - 1]);
      $out=[
        'Bing'=>0,
        'Facebook'=>0,
        'Github'=>0,
        'Google'=>0,
        'Instagram'=>0,
        'DuckDuckGo'=>0,
        'Linkedin'=>0,
        'Reddit'=>0,
        'Yahoo'=>0,
        'YouTube'=>0,
        'Twitter'=>0
      ];
      krsort($out);
      while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
        if(stristr($rr['browser'],'bing')||stristr($rr['urlFrom'],'msclkid=')||stristr($rr['urlDest'],'msclkid='))$out['Bing']+=1;
        if(stristr($rr['browser'],'duckduckgo'))$out['DuckDuckGo']+=1;
        if(stristr($rr['browser'],'facebook')||stristr($rr['urlFrom'],'fbclid=')||stristr($rr['urlDest'],'fbclid='))$out['Facebook']+=1;
        if(stristr($rr['urlFrom'],'github'))$out['Github']+=1;
        if(stristr($rr['browser'],'google')||stristr($rr['urlFrom'],'gclid=')||stristr($rr['urlDest'],'gclid='))$out['Google']+=1;
        if(stristr($rr['urlFrom'],'instagram'))$out['Instagram']+=1;
        if(stristr($rr['urlFrom'],'linkedin'))$out['Linkedin']+=1;
        if(stristr($rr['urlFrom'],'reddit'))$out['Reddit']+=1;
        if(stristr($rr['urlFrom'],'twitter')||stristr($rr['urlFrom'],'t.co/'))$out['Twitter']+=1;
        if(stristr($rr['browser'],'yahoo'))$out['Yahoo']+=1;
        if(stristr($rr['urlFrom'],'youtube'))$out['YouTube']+=1;
      };
      arsort($out);
      $cnt=0;
      foreach($out as $key => $value){
        if($value==0)continue;
        $cnt++;?>
        <div class="row widget-items">
          <div class="col-9 py-1"><?=$key;?></div>
          <div class="col-3 py-1 text-right"><?= number_format($value);?></div>
        </div>
      <?php }?>
    </div>
    <?php if($cnt>5){?>
      <div class="row widget-more">
        <button class="widget-more-btn" data-tooltip="tooltip" aria-label="Show/Hide Extra Items"  onclick="$(`#widgetreferrers<?=$rw['id'];?>`).toggleClass('widget-limit');$(`.widgetreferrers`).toggleClass('d-none');return false;"><i class="i widgetreferrers">down</i><i class="i widgetreferrers d-none">up</i></button>
      </div>
    <?php }?>
  </div>
</div>
