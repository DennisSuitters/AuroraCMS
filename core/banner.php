<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Banner
 * @package    core/banner.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$lS=isset($_GET['lS'])?filter_input(INPUT_GET,'lS',FILTER_SANITIZE_NUMBER_INT):0;
if(is_numeric($lS)&&$lS!=0){
  $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE `id`=:lS AND `file`='notification' AND `active`=1 LIMIT 1");
  $s->execute([':lS'=>$lS]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    echo'<div class="banner px-3 py-3 '.$r['heading'].'" style="background-image:url('.$r['cover'].');">'.
  		'<h3>'.$r['title'].'</h3>'.
  	  $r['notes'].
  		'<a class="banner-dismiss align-middle" href="#" title="Close Notification" aria-label="Close Notification"><i class="i i-3x"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 12,10.047142 q 0,0.3367 -0.235692,0.572383 l -1.144783,1.144783 Q 10.383842,12 10.047142,12 9.7104417,12 9.47475,11.764308 L 7,9.289558 4.52525,11.764308 Q 4.2895583,12 3.9528583,12 3.6161583,12 3.380475,11.764308 L 2.2356917,10.619525 Q 2,10.383842 2,10.047142 2,9.710442 2.2356917,9.47475 L 4.7104417,7 2.2356917,4.52525 Q 2,4.2895583 2,3.9528583 2,3.6161583 2.2356917,3.380475 L 3.380475,2.2356917 Q 3.6161583,2 3.9528583,2 4.2895583,2 4.52525,2.2356917 L 7,4.7104417 9.47475,2.2356917 Q 9.7104417,2 10.047142,2 q 0.3367,0 0.572383,0.2356917 L 11.764308,3.380475 Q 12,3.6161583 12,3.9528583 12,4.2895583 11.764308,4.52525 L 9.2895583,7 11.764308,9.47475 Q 12,9.710442 12,10.047142 z"/></svg></i></a>'.
  	'</div>'.
    '<script>'.
      '$(`.banner-dismiss`).click(function(){'.
        '$(`.banner`).addClass(`slide-out-bottom`);'.
        'localStorage.banner'.$r['id'].'Closed=`true`;'.
      '});'.
    '</script>';
  }
}
