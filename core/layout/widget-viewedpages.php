<?php /**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Viewed ages
 * @package    core/layout/widget-viewedpages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$row=array();
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
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="12" data-mdmin="6" data-mdmax="12" data-lgmin="1" data-lgmax="12" data-xlmin="5" data-xlmax="12" data-xxlmin="4" data-xxlmax="6" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 handle">
      <?=$rw['title'].($config['development']==1?'<span id="width_'.$rw['id'].'"></span>':'');?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-9 py-1 text-muted small">Page</div>
      <div class="col-3 py-1 text-muted text-right small">Views</div>
      <?php function array_sort_by_column(&$a,$c,$d=SORT_DESC){
        $sc=array();
        foreach($a as$k=>$r)$sc[$k]=$r[$c];
        array_multisort($sc,$d,$a);
      }
      array_sort_by_column($row,'views');
      $i=1;
      foreach($row as $r){?>
        <div class="col-9 py-1 text-truncated"><?=($r['contentType']!='Page'?ucfirst($r['contentType']).' ~ ':'').$r['title'];?></div>
        <div class="col-3 py-1 text-right"><?= number_format($r['views']);?></div>
        <?php $i++;if($i>10)break;
      }?>
    </div>
  </div>
</div>
