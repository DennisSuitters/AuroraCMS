<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Holiday Content
 * @package    core/layout/widget-holidaycontent.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
function getSaleTime2(){
  $chkti=time();
  $sale=[
    'tis'=>0,
    'tie'=>0,
    'sale'=>'',
    'class'=>'',
    'title'=>'',
  ];
  $year=date('Y',$chkti);
  $month=strtotime("1 month");
  $vatis=strtotime("2/14/$year"); // Valentine's Day
  $vatie=$vatis - $month;
  if($chkti>$vatis&&$chkti<$vatie)
    $sale=['tis'=>$vatis,'tie'=>$vatie,'sale'=>'valentine','class'=>'valentine','title'=>'Checkout our products in our Valentine\'s Day Sale!'];
  $eatis=strtotime("last sunday of march $year"); // Easter
  $eatie=$eatis - $month;
  if($chkti>$eatis&&$chkti<$eatie)
    $sale=['tis'=>$eatis,'tie'=>$eatie,'sale'=>'easter','class'=>'easter','title'=>'Checkout our products in our Easter Sale!'];
  $mdtis=strtotime("5/8/$year"); // Mother's Day
  $mdtie=$mdtis - $month;
  if($chkti>$mdtis&&$chkti<$mdtie)
    $sale=['tis'=>$mdtis,'tie'=>$mdtie,'sale'=>'mothersday','class'=>'mothersday','title'=>'Spoil your Mother with something from our Mother\'s Day Sale!'];
  $fdtis=strtotime("9/4/$year"); // Father's Day
  $fdtie=$fdtis - $month;
  if($chkti>$fdtis&&$chkti<$fdtie)
    $sale=['tis'=>$fdtis,'tie'=>$fdtie,'sale'=>'fathersday','class'=>'fathersday','title'=>'Spoil your Father with something from our Father\'s Day Sale!'];
  $bftis=strtotime("last friday of october $year"); // Black Friday
  $bftie=$bftis - $month;
  if($chkti>$bftis&&$chkti<$bftie)
    $sale=['tis'=>$bftis,'tie'=>$bftie,'sale'=>'blackfriday','class'=>'blackfriday','title'=>'Get something from our Black Friday Sale!'];
  $hwtis=strtotime("10/31/$year"); // Halloween
  $hwtie=$hwtis - $month;
  if($chkti>$hwtis&&$chkti<$hwtie)
    $sale=['tis'=>$hwtis,'tie'=>$hwtie,'sale'=>'halloween','class'=>'halloween','title'=>'Get something spooky from our Halloween Sale!'];
  $sbtis=strtotime("last saturday of november $year"); // Small Business Day
  $sbtie=$sbtis - $month;
  if($chkti>$sbtis&&$chkti<$sbtie)
    $sale=['tis'=>$sbtis,'tie'=>$sbtie,'sale'=>'smallbusinessday','class'=>'smallbusinessday','title'=>'Support our business by getting something from our Small Business Day Sale!'];
  $cdtis=strtotime("12/25/$year"); // Christmas Day
  $cdtie=$cdtis - $month;
  if($chkti>$cdtis&&$chkti<$cdtie)
    $sale=['tis'=>$cdtis,'tie'=>$cdtie,'sale'=>'christmas','class'=>'christmas','title'=>'Get something Jolly from a Christmas Sale!'];
  $eofytie=strtotime("7/30/$year"); // End Of Financial Year
  $eofytis=$eofytie - $month;
  if($chkti>$eofytis&&$chkti<$eofytie)
    $sale=['tis'=>$eofytis,'tie'=>$eofytie,'sale'=>'eofy','class'=>'eofy','title'=>'Consider editing, enabling or pinning these products for End Of Financial Year.'];
  return$sale;
}
if($config['options'][28]==1){
  $sale=getSaleTime2();
  $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `contentType`='inventory' AND `sale`!=:sale ORDER BY `views` ASC LIMIT 4");
  $ss->execute([':sale'=>$sale['sale']]);
  if($ss->rowCount()>0){?>
    <div class="item m-0 p-0 col-12" id="l_<?=$rw['id'];?>">
      <div class="alert widget <?=$sale['class'];?> m-3 p-0">
        <div class="toolbar px-2 py-1 handle">
          <?=$sale['title']!=''?$sale['title']:$rw['title'];?>
          <div class="btn-group">
            <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
          </div>
        </div>
        <div class="row p-2 justify-content-center">
          <?php while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div class="col-12 col-sm-4 col-md-5 col-lg-4 col-xl-3 col-xxl-2 mx-2 my-3">
              <div class="card">
                <figure class="card-image">
                  <a href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$rs['id'];?>"><img src="<?=($rs['thumb']!=''?$rs['thumb']:NOIMAGE);?>"></a>
                </figure>
                <h2 class="card-title text-center py-3 noclamp">
                  <a href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$rs['id'];?>" data-tooltip="tooltip"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><?=$rs['title'];?></a>
                </h2>
              </div>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
<?php }
}
