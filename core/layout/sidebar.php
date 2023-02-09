<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Sidebar Menu
 * @package    core/layout/set_sidebar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.22
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<aside id="sidebar" class="'.(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?' navsmall':'').'">'.
  '<nav class="mt-3">'.
    '<ul>';
$sm1=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=0 AND `active`=1 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
$sm1->execute([':r'=>$user['rank']]);
while($rm1=$sm1->fetch(PDO::FETCH_ASSOC)){
  if($rm1['contentType']=='dropdown'){
    $acheck1=isset($args[0])?$args[0]:'';
    echo'<li class="'.($view==$rm1['view']||$acheck1==$rm1['view']?'open':'').'">'.
      '<a class="opener" href="'.URL.$settings['system']['admin'].'/'.$rm1['view'].'" aria-label="'.$rm1['title'].'"><i class="i i-2x mr-2">'.$rm1['icon'].'</i> '.$rm1['title'].'</a>'.
      '<span class="arrow'.($view==$rm1['view']||$acheck1==$rm1['view']?' open':'').'"><i class="i">chevron-up</i></span>'.
      '<ul class="shadow-0">';
    $sm2=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=:mid AND `active`=1 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
    $sm2->execute([
      ':mid'=>$rm1['id'],
      ':r'=>$user['rank']
    ]);
    while($rm2=$sm2->fetch(PDO::FETCH_ASSOC)){
      $acheck=isset($args[1])?$args[1]:(isset($args[0])?$args[0]:$view);
      echo'<li class="pl-2 '.($rm1['contentType']=='dropdown'&&$acheck==$rm2['contentType']||$view==$rm2['contentType']?'active':'').'">';
      if($rm2['view']=='settings')
        echo'<a href="'.URL.$settings['system']['admin'].'/'.$rm2['contentType'].'/'.$rm2['view'].'" aria-label="'.$rm2['title'].'"><i class="i i-2x mr-2">'.$rm2['icon'].'</i> '.$rm2['title'].'</a>';
      else
        echo'<a href="'.URL.$settings['system']['admin'].'/'.$rm2['view'].'/'.($rm2['view']=='content'&&$rm2['contentType']!='scheduler'?'type/':'').$rm2['contentType'].'" aria-label="'.$rm2['title'].'"><i class="i i-2x mr-2">'.$rm2['icon'].'</i> '.$rm2['title'].'</a>';
      echo'</li>';
    }
    echo'</ul>';
  }else{
    $acheck3=isset($args[0])?$args[0]:'';
    echo'<li class="'.($acheck3!='settings'&&$view==$rm1['view']?'active':'').'"><a href="'.URL.$settings['system']['admin'].'/'.$rm1['view'].'" aria-label="'.$rm1['title'].'"><i class="i i-2x mr-2">'.$rm1['icon'].'</i> '.$rm1['title'].'</a></li>';
  }
}
    echo'</ul>'.
  '</nav>'.
'</aside>';
