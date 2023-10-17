<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Sidebar Menu
 * @package    core/layout/set_sidebar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<aside id="sidebar" class="'.(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?' navsmall':'').' shadow">'.
  '<nav>'.
    '<ul>';
      $sb1=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=0 AND `active`=1 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
      $sb1->execute([':r'=>$user['rank']]);
      while($rb1=$sb1->fetch(PDO::FETCH_ASSOC)){
        if($rb1['contentType']=='dropdown'){
          $acheck1=isset($args[0])?$args[0]:'';
          echo'<li class="'.($view==$rb1['view']||$acheck1==$rb1['view']?'open':'').'" data-tooltip="right" aria-label="'.$rb1['title'].'">'.
            '<a class="opener" href="'.URL.$settings['system']['admin'].'/'.$rb1['view'].'"><i class="i i-3x mr-3">'.$rb1['icon'].'</i> <span>'.$rb1['title'].'</span></a>'.
            '<span class="arrow'.($view==$rb1['view']||$acheck1==$rb1['view']?' open':'').'"><i class="i">chevron-up</i></span>'.
            '<ul class="shadow-0">';
              $sb2=$db->prepare("SELECT * FROM `".$prefix."sidebar` WHERE `mid`=:mid AND `active`=1 AND `rank`<=:r ORDER BY `ord` ASC, `title` ASC");
              $sb2->execute([
                ':mid'=>$rb1['id'],
                ':r'=>$user['rank']
              ]);
              while($rb2=$sb2->fetch(PDO::FETCH_ASSOC)){
                $acheck=isset($args[1])?$args[1]:(isset($args[0])?$args[0]:$view);
                echo'<li class="'.($rb1['contentType']=='dropdown'&&$acheck==$rb2['contentType']||$view==$rb2['contentType']?'active':'').'" data-tooltip="right" aria-label="'.$rb2['title'].'">'.
                  ($rb2['view']=='settings'?
                    '<a href="'.URL.$settings['system']['admin'].'/'.$rb2['contentType'].'/'.$rb2['view'].'"><i class="i i-3x ml-3 mr-3">'.$rb2['icon'].'</i> <span>'.$rb2['title'].'</span></a>'
                  :
                    '<a href="'.URL.$settings['system']['admin'].'/'.$rb2['view'].'/'.($rb2['view']=='content'&&$rb2['contentType']!='scheduler'?'type/':'').$rb2['contentType'].'"><i class="i i-3x mr-3">'.$rb2['icon'].'</i> <span>'.$rb2['title'].'</span></a>'
                  ).
                '</li>';
              }
            echo'</ul>';
        }else{
          $acheck3=isset($args[0])?$args[0]:'';
          echo'<li class="'.($acheck3!='settings'&&$view==$rb1['view']?'active':'').'" data-tooltip="right" aria-label="'.$rb1['title'].'"><a href="'.URL.$settings['system']['admin'].'/'.$rb1['view'].'"><i class="i i-3x mr-3">'.$rb1['icon'].'</i> <span>'.$rb1['title'].'</span></a></li>';
        }
      }
    echo'</ul>'.
  '</nav>'.
'</aside>';
