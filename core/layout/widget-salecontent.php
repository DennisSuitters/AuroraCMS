<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Holiday Content
 * @package    core/layout/widget-holidaycontent.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
function getSalePeriod(){
  $chkti=time();
  $sale=[
    'tis'=>0,
    'tie'=>0,
    'sale'=>'none',
    'title'=>'none',
    'class'=>''
  ];
  $year=date('Y',$chkti) - 1;
  $month=strtotime("1 month");
  $vatis=strtotime("2/14/$year"); // Valentine's Day
	$vatie=$vatis - $month;
  $eatis=strtotime("last sunday of march $year"); // Easter
	$eatie=$eatis - $month;
  $mdtis=strtotime("5/8/$year"); // Mother's Day
	$mdtie=$mdtis - $month;
  $fdtis=strtotime("9/4/$year"); // Father's Day
	$fdtie=$fdtis - $month;
  $bftis=strtotime("last friday of october $year"); // Black Friday
	$bftie=$bftis - $month;
  $hwtis=strtotime("10/31/$year"); // Halloween
	$hwtie=$hwtis - $month;
  $sbtis=strtotime("last saturday of november $year"); // Small Business Day
	$sbtie=$sbtis - $month;
  $cdtis=strtotime("12/25/$year"); // Christmas Day
	$cdtie=$cdtis - $month;
  if($chkti>$vatis&&$chkti<$vatie)$sale=['tis'=>$vatis,'tie'=>$vatie,'sale'=>'valentine','title'=>'Consider editing, enabling or pinning these products for Valentine\'s Day.','class'=>'valentine'];
  if($chkti>$eatis&&$chkti<$eatie)$sale=['tis'=>$eatis,'tie'=>$eatie,'sale'=>'easter','title'=>'Consider editing, enabling or pinning these products for Easter.','class'=>'easter'];
  if($chkti>$mdtis&&$chkti<$mdtie)$sale=['tis'=>$mdtis,'tie'=>$mdtie,'sale'=>'mothersday','title'=>'Consider editing, enabling or pinning these products for Mother\'s Day.','class'=>'mothersday'];
  if($chkti>$fdtis&&$chkti<$fdtie)$sale=['tis'=>$fdtis,'tie'=>$fdtie,'sale'=>'fathersday','title'=>'Consider editing, enabling or pinning these products for Father\'s Day.','class'=>'fathersday'];
  if($chkti>$bftis&&$chkti<$bftie)$sale=['tis'=>$bftis,'tie'=>$bftie,'sale'=>'blackfriday','title'=>'Consider editing, enabling or pinning these products for the Black Friday Sale.','class'=>'blackfriday'];
  if($chkti>$hwtis&&$chkti<$hwtie)$sale=['tis'=>$hwtis,'tie'=>$hwtie,'sale'=>'halloween','title'=>'Consider editing, enabling or pinning these products for Halloween.','class'=>'halloween'];
  if($chkti>$sbtis&&$chkti<$sbtie)$sale=['tis'=>$sbtis,'tie'=>$sbtie,'sale'=>'smallbusinessday','title'=>'Consider editing, enabling or pinning these products for the Small Business Day sale.','class'=>'smallbusinessday'];
  if($chkti>$cdtis&&$chkti<$cdtie)$sale=['tis'=>$cdtis,'tie'=>$cdtie,'sale'=>'christmas','title'=>'Consider editing, enabling or pinning these products for Christmas.','class'=>'christmas'];
  return $sale;
}
$sale=getSalePeriod();
$tis=$sale['tie'] - 31536000;
$tie=$sale['tie'] - 31536000;
$ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='inventory' AND `pti` < :tis AND `pti` > :tie LIMIT 4");
$ss->execute([
  ':tis'=>$tis,
  ':tie'=>$tie
]);
if($ss->rowCount()>0){?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="12" data-mdmin="3" data-mdmax="12" data-lgmin="1" data-lgmax="12" data-xlmin="5" data-xlmax="12" data-xxlmin="3" data-xxlmax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget <?=$sale['class'];?> m-3 p-0">
    <div class="toolbar px-2 py-1 handle">
      <?=$sale['title']!=''?$sale['title']:$rw['title'];?> | salecontent.php
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <div class="row p-2">
      <?php while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
        <div class="card col-6 col-sm-2-5 m-0 m-sm-3">
          <figure class="card-image">
            <img src="<?=($rs['thumb']!=''?$rs['thumb']:NOIMAGE);?>">
          </figure>
          <h2 class="card-title text-center py-3 noclamp">
            <a href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$rs['id'];?>" data-tooltip="tooltip"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><?=$rs['title'];?></a>
          </h2>
        </div>
      <?php }?>
    </div>
  </div>
</div>
<?php }
