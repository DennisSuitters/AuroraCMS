<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Sidebar Menu
 * @package    core/layout/set_sidebar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<aside class="'.(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?' navsmall':'').'" id="sidebar">'.
  '<nav>'.
    '<ul>';
$sm1=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=0 AND `active`=1 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
$sm1->execute([':r'=>$user['rank']]);
while($rm1=$sm1->fetch(PDO::FETCH_ASSOC)){
  if($rm1['contentType']=='dropdown'){
    echo'<li class="'.($view==$rm1['view']?'open':'').'">'.
      '<a class="opener" href="'.URL.$settings['system']['admin'].'/'.$rm1['view'].'" aria-label="'.$rm1['title'].'">'.svg2($rm1['icon'],'i-2x mr-4').' '.$rm1['title'].'</a>'.
      '<span class="arrow'.($view==$rm1['view']?' open':'').'">'.svg2('arrow-up').'</span>'.
      '<ul>';
    $sm2=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=:mid AND `active`=1 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
    $sm2->execute([
      ':mid'=>$rm1['id'],
      ':r'=>$user['rank']
    ]);
    while($rm2=$sm2->fetch(PDO::FETCH_ASSOC)){
      echo'<li class="'.($rm1['contentType']=='dropdown'&&$view==$rm2['contentType']?'active':'').'">';
      if($rm2['view']=='settings')
        echo'<a href="'.URL.$settings['system']['admin'].'/'.$rm2['contentType'].'/'.$rm2['view'].'" aria-label="'.$rm2['title'].'">'.svg2($rm2['icon'],'i-2x mr-4').' '.$rm2['title'].'</a>';
      else
        echo'<a href="'.URL.$settings['system']['admin'].'/'.$rm2['view'].'/'.($rm2['view']=='content'?'type/':'').$rm2['contentType'].'" aria-label="'.$rm2['title'].'">'.svg2($rm2['icon'],'i-2x mr-4').' '.$rm2['title'].'</a>';
      echo'</li>';
    }
    echo'</ul>';
  }else
    echo'<li class="'.($rm1['contentType']!='dropdown'&&$view==$rm1['view']?'active':'').'"><a href="'.URL.$settings['system']['admin'].'/'.$rm1['view'].'" aria-label="'.$rm1['title'].'">'.svg2($rm1['icon'],'i-2x mr-4').' '.$rm1['title'].'</a></li>';
}
    echo'</ul>'.
  '</nav>'.
'</aside>';
