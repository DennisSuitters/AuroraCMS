<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Upload Theme
 * @package    core/upload_theme.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.8
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
echo'<script>';
if(isset($_FILES['fu'])){
  $tp='../layout/'.basename($_FILES['fu']['name']);
  if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
    if(is_file_Zip($tp)){
      $path=pathinfo(realpath($tp),PATHINFO_DIRNAME);
      $zip=new ZipArchive;
      $res=$zip->open($tp);
      if($res===TRUE){
        $zip->extractTo($path);
        $zip->close();
        unlink($tp);
        $folders=preg_grep('/^([^.])/',scandir("../layout"));
        $html='';
        foreach($folders as$folder){
          if(!file_exists('../layout/'.$folder.'/theme.ini'))continue;
          $theme=parse_ini_file('../layout/'.$folder.'/theme.ini',true);
          $html.='<article class="card col-12 col-sm-5 mx-3 mt-4 mb-0 overflow-visible theme'.($config['theme']==$folder?' theme-selected':'').'" data-theme="'.$folder.'">'.
            '<figure class="card-image position-relative overflow-visible">'.
              '<img src="layout/'.$folder.'/theme.jpg" alt="'.$theme['title'].'">'.
              '<div class="image-toolbar overflow-visible">'.
                '<span class="badger badge-success enable" data-tooltip="tooltip" aria-label="Theme Enabled"><i class="i">approve</i></span>'.
              '</div>'.
            '</figure>'.
            '<div class="card-body pt-0 mt-2 mb-0 text-center">'.
              (isset($theme['title'])&&$theme['title']!=''?$theme['title']:'No Title Assigned').'<br>'.
              '<small>Version '.$theme['version'].' created by '.(isset($theme['creator_url'])&&$theme['creator_url']!=''?'<a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>':$theme['creator']).'<br>'.
              'using the '.(isset($theme['framework_url'])&&$theme['framework_url']!=''?'<a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>':$theme['framework_name']).' CSS Framework</small>'.
            '</div>'.
          '</article>';
        }
        echo'window.top.window.$("#preference-theme").html(`'.$html.'`);';
        echo'window.top.window.$(".theme-chooser").not(".disabled").find("figure.card-image").on("click",function(){'.
          'window.top.window.$("#preference-theme .theme").removeClass("theme-selected");'.
          'window.top.window.$(this).parent("article").addClass("theme-selected");'.
          'window.top.window.$("#notheme").addClass("hidden");'.
          'window.top.window.$.ajax({'.
            'type:"GET",'.
            'url:"core/update.php",'.
            'data:{'.
              'id:"1",'.
              't:"config",'.
              'c:"theme",'.
              'da:window.top.window.$(this).parent("article").attr("data-theme")'.
            '}'.
          '});'.
        '});';
        echo'window.top.window.$(".page-block").removeClass("d-block");';
      }else{
        echo'window.top.window.$(".page-block").removeClass("d-block");';
        echo'window.top.window.alert("Doh! I couldn\'t open '.$file.'");';
      }
    }else{
      echo'window.top.window.$(".page-block").removeClass("d-block");';
      echo'window.top.window.alert("Only ZIP files are allowed to be uploaded!");';
    }
  }else{
    echo'window.top.window.$(".page-block").removeClass("d-block");';
    echo'window.top.window.alert("Something went wrong!");';
  }
}
echo'</script>';
function is_file_Zip($filename){
	if(is_file($filename)==false)return false;
	if(pathinfo($filename,PATHINFO_EXTENSION )!='zip')return false;
	$fileHeader="\x50\x4b\x03\x04";
	$data=file_get_contents($filename);
	if(strpos($data,$fileHeader)===false)return false;
	return true;
}
