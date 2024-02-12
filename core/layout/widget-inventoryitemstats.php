<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Inventory Item Statistics
 * @package    core/layout/widget-inventoryitemstats.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(isset($r['contentType'])&&$r['contentType']!=''){
  if($r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='course'){
    $times=array();
    for($m=1;$m<=12;$m++){
      $fm=mktime(0,0,0,$m,1);
      $fmy=strtotime('-1 year',$fm);
      $lm=mktime(23,59,0,$m,date('t',$fm));
      $lmy=strtotime('-1 year',$lm);
      $times[$m]=array($fm,$lm,$fmy,$lmy);
    }
    $m1s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m1s->execute([':rid'=>$r['id'],':tis'=>$times[1][0],':tie'=>$times[1][1]]);
    $m1r=$m1s->fetch(PDO::FETCH_ASSOC);
    $my1s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my1s->execute([':rid'=>$r['id'],':tis'=>$times[1][2],':tie'=>$times[1][3]]);
    $my1r=$my1s->fetch(PDO::FETCH_ASSOC);
    $m2s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m2s->execute([':rid'=>$r['id'],':tis'=>$times[2][0],':tie'=>$times[2][1]]);
    $m2r=$m2s->fetch(PDO::FETCH_ASSOC);
    $my2s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my2s->execute([':rid'=>$r['id'],':tis'=>$times[2][2],':tie'=>$times[2][3]]);
    $my2r=$my2s->fetch(PDO::FETCH_ASSOC);
    $m3s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m3s->execute([':rid'=>$r['id'],':tis'=>$times[3][0],':tie'=>$times[3][1]]);
    $m3r=$m3s->fetch(PDO::FETCH_ASSOC);
    $my3s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my3s->execute([':rid'=>$r['id'],':tis'=>$times[3][2],':tie'=>$times[3][3]]);
    $my3r=$my3s->fetch(PDO::FETCH_ASSOC);
    $m4s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m4s->execute([':rid'=>$r['id'],':tis'=>$times[4][0],':tie'=>$times[4][1]]);
    $m4r=$m4s->fetch(PDO::FETCH_ASSOC);
    $my4s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my4s->execute([':rid'=>$r['id'],':tis'=>$times[4][2],':tie'=>$times[4][3]]);
    $my4r=$my4s->fetch(PDO::FETCH_ASSOC);
    $m5s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m5s->execute([':rid'=>$r['id'],':tis'=>$times[5][0],':tie'=>$times[5][1]]);
    $m5r=$m5s->fetch(PDO::FETCH_ASSOC);
    $my5s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my5s->execute([':rid'=>$r['id'],':tis'=>$times[5][2],':tie'=>$times[5][3]]);
    $my5r=$my5s->fetch(PDO::FETCH_ASSOC);
    $m6s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m6s->execute([':rid'=>$r['id'],':tis'=>$times[6][0],':tie'=>$times[6][1]]);
    $m6r=$m6s->fetch(PDO::FETCH_ASSOC);
    $my6s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my6s->execute([':rid'=>$r['id'],':tis'=>$times[6][2],':tie'=>$times[6][3]]);
    $my6r=$my6s->fetch(PDO::FETCH_ASSOC);
    $m7s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m7s->execute([':rid'=>$r['id'],':tis'=>$times[7][0],':tie'=>$times[7][1]]);
    $m7r=$m7s->fetch(PDO::FETCH_ASSOC);
    $my7s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my7s->execute([':rid'=>$r['id'],':tis'=>$times[7][2],':tie'=>$times[7][3]]);
    $my7r=$my7s->fetch(PDO::FETCH_ASSOC);
    $m8s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m8s->execute([':rid'=>$r['id'],':tis'=>$times[8][0],':tie'=>$times[8][1]]);
    $m8r=$m8s->fetch(PDO::FETCH_ASSOC);
    $my8s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my8s->execute([':rid'=>$r['id'],':tis'=>$times[8][2],':tie'=>$times[8][3]]);
    $my8r=$my8s->fetch(PDO::FETCH_ASSOC);
    $m9s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m9s->execute([':rid'=>$r['id'],':tis'=>$times[9][0],':tie'=>$times[9][1]]);
    $m9r=$m9s->fetch(PDO::FETCH_ASSOC);
    $my9s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my9s->execute([':rid'=>$r['id'],':tis'=>$times[9][2],':tie'=>$times[9][3]]);
    $my9r=$my9s->fetch(PDO::FETCH_ASSOC);
    $m10s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m10s->execute([':rid'=>$r['id'],':tis'=>$times[10][0],':tie'=>$times[10][1]]);
    $m10r=$m10s->fetch(PDO::FETCH_ASSOC);
    $my10s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my10s->execute([':rid'=>$r['id'],':tis'=>$times[10][2],':tie'=>$times[10][3]]);
    $my10r=$my10s->fetch(PDO::FETCH_ASSOC);
    $m11s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m11s->execute([':rid'=>$r['id'],':tis'=>$times[11][0],':tie'=>$times[11][1]]);
    $m11r=$m11s->fetch(PDO::FETCH_ASSOC);
    $my11s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my11s->execute([':rid'=>$r['id'],':tis'=>$times[11][2],':tie'=>$times[11][3]]);
    $my11r=$my11s->fetch(PDO::FETCH_ASSOC);
    $m12s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $m12s->execute([':rid'=>$r['id'],':tis'=>$times[12][0],':tie'=>$times[12][1]]);
    $m12r=$m12s->fetch(PDO::FETCH_ASSOC);
    $my12s=$db->prepare("SELECT SUM(`sales`) AS `cnt` FROM `".$prefix."contentStats` WHERE `rid`=:rid AND `ti`>:tis AND `ti`<:tie");
    $my12s->execute([':rid'=>$r['id'],':tis'=>$times[12][2],':tie'=>$times[12][3]]);
    $my12r=$my12s->fetch(PDO::FETCH_ASSOC);?>
    <div class="card bg-white">
      <canvas id="salesChart" style="min-height:225px;height:225px;max-height:225px;max-width:100%;"></canvas>
    </div>
    <script>
      var salesChartData={
        labels:[
          '<?= date("M",$times[1][0]);?>',
          '<?= date("M",$times[2][0]);?>',
          '<?= date("M",$times[3][0]);?>',
          '<?= date("M",$times[4][0]);?>',
          '<?= date("M",$times[5][0]);?>',
          '<?= date("M",$times[6][0]);?>',
          '<?= date("M",$times[7][0]);?>',
          '<?= date("M",$times[8][0]);?>',
          '<?= date("M",$times[9][0]);?>',
          '<?= date("M",$times[10][0]);?>',
          '<?= date("M",$times[11][0]);?>',
          '<?= date("M",$times[12][0]);?>'
        ],
        datasets:[
          {
            label: 'This Year',
            data:[
              <?=$m1r['cnt']>0?$m1r['cnt']:0;?>,
              <?=$m2r['cnt']>0?$m2r['cnt']:0;?>,
              <?=$m3r['cnt']>0?$m3r['cnt']:0;?>,
              <?=$m4r['cnt']>0?$m4r['cnt']:0;?>,
              <?=$m5r['cnt']>0?$m5r['cnt']:0;?>,
              <?=$m6r['cnt']>0?$m6r['cnt']:0;?>,
              <?=$m7r['cnt']>0?$m7r['cnt']:0;?>,
              <?=$m8r['cnt']>0?$m8r['cnt']:0;?>,
              <?=$m9r['cnt']>0?$m9r['cnt']:0;?>,
              <?=$m10r['cnt']>0?$m10r['cnt']:0;?>,
              <?=$m11r['cnt']>0?$m11r['cnt']:0;?>,
              <?=$m12r['cnt']>0?$m12r['cnt']:0;?>
            ]
          },
          {
            label: 'Last Year',
            data:[
              <?=$my1r['cnt']>0?$my1r['cnt']:0;?>,
              <?=$my2r['cnt']>0?$my2r['cnt']:0;?>,
              <?=$my3r['cnt']>0?$my3r['cnt']:0;?>,
              <?=$my4r['cnt']>0?$my4r['cnt']:0;?>,
              <?=$my5r['cnt']>0?$my5r['cnt']:0;?>,
              <?=$my6r['cnt']>0?$my6r['cnt']:0;?>,
              <?=$my7r['cnt']>0?$my7r['cnt']:0;?>,
              <?=$my8r['cnt']>0?$my8r['cnt']:0;?>,
              <?=$my9r['cnt']>0?$my9r['cnt']:0;?>,
              <?=$my10r['cnt']>0?$my10r['cnt']:0;?>,
              <?=$my11r['cnt']>0?$my11r['cnt']:0;?>,
              <?=$my12r['cnt']>0?$my12r['cnt']:0;?>
            ]
          }
        ]
      }
      var salesChartCanvas=$('#salesChart').get(0).getContext('2d');
      var salesChartData=$.extend(true,{},salesChartData);
      new Chart(salesChartCanvas,{
        type:'bar',
        data:salesChartData,
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Sales per Month'
            }
          },
        },
      });
    </script>
<?php }
}
