<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Popup - PHPViewer
 * @package    core/layout/phpviewer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'../db.php';
require'../projecthoneypot/class.projecthoneypot.php';
$idh=time();
echo'<div class="fancybox-ajax">'.
      '<h6 class="bg-dark p-2">Project Honey Pot IP Checker</h6>'.
      '<div id="phpviewer'.$idh.'">';
if(!isset($config['php_APIkey'])||$config['php_APIkey']=='')echo'<div class="alert alert-info" role="alert">The Project Honey Pot API Key has not been entered in the Security Settings.</div>';
else{
  function svg2($svg,$class=null,$size=null){
  	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('../images/i-'.$svg.'.svg').'</i>';
  }
  $id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
  $t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
  define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
  define('UNICODE','UTF-8');
  if($t=='comments')$s=$db->prepare("SELECT `ip` FROM `".$prefix."comments` WHERE `id`=:id");
  else$s=$db->prepare("SELECT `ip` FROM `".$prefix."tracker` WHERE `id`=:id");
  $s->execute([':id'=>$id]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    if(filter_var($r['ip'],FILTER_VALIDATE_IP,FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
      $h=new ProjectHoneyPot($r['ip'],$config['php_APIkey']);
      if($h->hasRecord()==1){
        if($h->isSuspicious()==1){
          echo'<strong>'.$r['ip'].'</strong> is listed as';
          if($h->isCommentSpammer()==1)echo'a Comment Spammer';
          if($h->isHarvester()==1)echo'an Email Harvester';
          if($h->isSearchEngine()==1)echo', but could be a Search Engine.<br>';else echo'.<br>';
          if($h->getThreatScore()>0)echo'The Threat Score for this record is <strong>'.$h->getThreatScore().'</strong> <a target="_blank" href="https://www.projecthoneypot.org/threat_info.php" data-tooltip="tooltip" aria-label="Information about what this value represents.">?</a>.';
        }
      }else echo'No Recorded Incidents were found...';
      $sql=$db->prepare("SELECT COUNT(`id`) as cnt FROM `".$prefix."iplist` WHERE `ip`=:ip");
      $sql->execute([':ip'=>$r['ip']]);
      $row=$sql->fetch(PDO::FETCH_ASSOC);
      if($row['cnt']<1){?>
  <div class="btn-group pull-right" id="phpbuttons" role="group">
    <form id="blacklist<?=$idh;?>" method="post" action="core/add_blacklist.php">
      <input name="id" type="hidden" value="<?=$id;?>">
      <input name="t" type="hidden" value="<?=$t;?>">
      <button data-tooltip="tooltip" aria-label="Add Oringinators IP to Blacklist"><?= svg2('security');?></button>
    </form>
  </div>
  </div>
  <script>
    $("#blacklist<?=$idh;?>").submit(function(){
        $.post($(this).attr("action"),$(this).serialize(),function(data){
          $('#phpviewer<?=$idh;?>').html(data);
        });
        return false;
    });
<?php if($config['options'][4]==1){?>
        $('[data-tooltip="tooltip"]').tooltip();
<?php }?>
  </script>
<?php }
    }else echo'The IP Recorded isn\'t valid.';
  }else echo'No Results Found.';
}
echo'</div>';
