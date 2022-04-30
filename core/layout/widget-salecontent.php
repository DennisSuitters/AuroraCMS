<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Holiday Content
 * @package    core/layout/widget-holidaycontent.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
function getSalePeriod(){
  $chkti=time();
  $sale=[
    'timestamp'=>0,
    'sale'=>'none',
    'title'=>'none',
    'class'=>''
  ];
  $year=date('Y',$chkti);
  $va=strtotime("2/14/$year - 2 weeks"); // Valentine's Day
  $ea=strtotime("last sunday of march $year - 1 month"); // Easter
  $md=strtotime("5/8/$year - 1 month"); // Mother's Day
  $fd=strtotime("9/4/$year - 1 month"); // Father's Day
  $bf=strtotime("last friday of october $year - 1 month"); // Black Friday
  $hw=strtotime("10/31/$year - 1 month"); // Halloween
  $sb=strtotime("last saturday of november $year - 1 month"); // Small Business Day
  $cd=strtotime("12/25/$year - 1 month"); // Christmas Day
  if($chkti>$va)$sale=['timestamp'=>$va,'sale'=>'valentine','title'=>'Consider editing, enabling or pinning these products for Valentine\'s Day.','class'=>'valentine'];
  if($chkti>$ea)$sale=['timestamp'=>$ea,'sale'=>'easter','title'=>'Consider editing, enabling or pinning these products for Easter.','class'=>'easter'];
  if($chkti>$md)$sale=['timestamp'=>$md,'sale'=>'mothersday','title'=>'Consider editing, enabling or pinning these products for Mother\'s Day.','class'=>'mothersday'];
  if($chkti>$fd)$sale=['timestamp'=>$fd,'sale'=>'fathersday','title'=>'Consider editing, enabling or pinning these products for Father\'s Day.','class'=>'fathersday'];
  if($chkti>$bf)$sale=['timestamp'=>$bf,'sale'=>'blackfriday','title'=>'Consider editing, enabling or pinning these products for the Black Friday Sale.','class'=>'blackfriday'];
  if($chkti>$hw)$sale=['timestamp'=>$hw,'sale'=>'halloween','title'=>'Consider editing, enabling or pinning these products for Halloween.','class'=>'halloween'];
  if($chkti>$sb)$sale=['timestamp'=>$sb,'sale'=>'smallbusinessday','title'=>'Consider editing, enabling or pinning these products for the Small Business Day sale.','class'=>'smallbusinessday'];
  if($chkti>$cd)$sale=['timestamp'=>$cd,'sale'=>'christmas','title'=>'Consider editing, enabling or pinning these products for Christmas.','class'=>'christmas'];
  return $sale;
}
$sale=getSalePeriod();
$pti=$sale['timestamp'] - 31536000;
$sty=date("Y",$pti);
$sti=strtotime("1/1/$sty - 6 months");
$ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='inventory' AND `pti` < :pti LIMIT 4");
$ss->execute([
  ':pti'=>$pti
]);
if($ss->rowCount()>0){?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width'];?>" data-dbid="<?=$rw['id'];?>" data-resizeMin="2" resizeMax="12" id="l_<?=$rw['id'];?>">
  <div class="alert widget <?=$sale['class'];?> m-3 p-0">
    <div class="toolbar px-2 py-1 handle">
      <?=$sale['title']!=''?$sale['title']:$rw['title'];?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><?= svg2('close');?></button>
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
