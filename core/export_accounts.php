<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Export Accounts
 * @package    core/export_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT `dateFormat` FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):0;
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_NUMBER_INT):0;
$dte=isset($_POST['dte'])?filter_input(INPUT_POST,'dte',FILTER_SANITIZE_NUMBER_INT):0;
$rnk=isset($_POST['rnk'])?filter_input(INPUT_POST,'rnk',FILTER_SANITIZE_NUMBER_INT):0;
$usr=isset($_POST['usr'])?filter_input(INPUT_POST,'usr',FILTER_SANITIZE_NUMBER_INT):0;
$nme=isset($_POST['nme'])?filter_input(INPUT_POST,'nme',FILTER_SANITIZE_NUMBER_INT):0;
$eml=isset($_POST['eml'])?filter_input(INPUT_POST,'eml',FILTER_SANITIZE_NUMBER_INT):0;
$phn=isset($_POST['phn'])?filter_input(INPUT_POST,'phn',FILTER_SANITIZE_NUMBER_INT):0;
$mob=isset($_POST['mob'])?filter_input(INPUT_POST,'mob',FILTER_SANITIZE_NUMBER_INT):0;
$url=isset($_POST['url'])?filter_input(INPUT_POST,'url',FILTER_SANITIZE_NUMBER_INT):0;
$bus=isset($_POST['bus'])?filter_input(INPUT_POST,'bus',FILTER_SANITIZE_NUMBER_INT):0;
$abn=isset($_POST['abn'])?filter_input(INPUT_POST,'abn',FILTER_SANITIZE_NUMBER_INT):0;
$adr=isset($_POST['adr'])?filter_input(INPUT_POST,'adr',FILTER_SANITIZE_NUMBER_INT):0;
$spnt=isset($_POST['spnt'])?filter_input(INPUT_POST,'spnt',FILTER_SANITIZE_NUMBER_INT):0;
$pnts=isset($_POST['pnts'])?filter_input(INPUT_POST,'pnts',FILTER_SANITIZE_NUMBER_INT):0;
$nws=isset($_POST['nws'])?filter_input(INPUT_POST,'nws',FILTER_SANITIZE_NUMBER_INT):0;
$d=isset($_POST['d'])?filter_input(INPUT_POST,'d',FILTER_SANITIZE_NUMBER_INT):0;
if($d==0)$d=',';
if($d==1)$d='|';
if($d==2)$d=';';
$f=isset($_POST['f'])?filter_input(INPUT_POST,'f',FILTER_SANITIZE_NUMBER_INT):0;
if($f==0){
  header('Content-Type: text/csv');
  header("Content-Transfer-Encoding: UTF-8");
  header('Content-Disposition: attachment; filename=accounts-'.time().'.csv');
  header('Pragma: no-cache');
  header("Expires: 0");
}
$s=$db->query("SELECT * FROM `".$prefix."login` ORDER BY `username` ASC");
$s->execute();
$result='';
if($f==0){
  $result.=
    ($id==1?'ID':'').
    ($act==1?($id==1?$d:'').'Active':'').
    ($dte==1?($act==1?$d:'').'Date':'').
    ($rnk==1?($dte==1?$d:'').'Rank':'').
    ($usr==1?($rnk==1?$d:'').'Username':'').
    ($nme==1?($usr==1?$d:'').'Name':'').
    ($eml==1?($nme==1?$d:'').'Email':'').
    ($phn==1?($eml==1?$d:'').'Phone':'').
    ($mob==1?($phn==1?$d:'').'Mobile':'').
    ($url==1?($mob==1?$d:'').'URL':'').
    ($bus==1?($url==1?$d:'').'Business':'').
    ($abn==1?($bus==1?$d:'').'ABN':'').
    ($adr==1?($abn==1?$d:'').'Address':'').
    ($spnt==1?($adr==1?$d:'').'Spent':'').
    ($pnts==1?($spnt==1?$d:'').'Points':'').
    ($nws==1?($pnts==1?$d:'').'Subscriber':'')."\n";
}
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  if($f==0){
    $result.=
      ($id==1?$r['id']:'').
      ($act==1?($id==1?$d:'').($r['active'][0]==1?'Yes':'No'):'').
      ($dte==1?($act==1?$d:'').'"'.date($config['dateFormat'],$r['ti']).'"':'').
      ($rnk==1?($dte==1?$d:'').$r['rank']:'').
      ($usr==1?($rnk==1?$d:'').'"'.$r['username'].'"':'').
      ($nme==1?($usr==1?$d:'').'"'.$r['name'].'"':'').
      ($eml==1?($nme==1?$d:'').$r['email']:'').
      ($phn==1?($eml==1?$d:'').$r['phone']:'').
      ($mob==1?($phn==1?$d:'').$r['mobile']:'').
      ($url==1?($mob==1?$d:'').$r['url']:'').
      ($bus==1?($url==1?$d:'').'"'.$r['business'].'"':'').
      ($abn==1?($bus==1?$d:'').$r['abn']:'').
      ($adr==1?($abn==1?$d:'').'"'.
        ($r['address']!=''?$r['address']:'').
        ($r['suburb']!=''?', '.$r['suburb']:'').
        ($r['city']!=''?', '.$r['city']:'').
        ($r['state']!=''?', '.$r['state']:'').
        ($r['postcode']!=0?', '.$r['postcode']:'').
        ($r['country']!=''?', '.$r['country']:'').
      '"':'').
      ($spnt==1?($adr==1?$d:'').$r['spent']:'').
      ($pnts==1?($spnt==1?$d:'').$r['points']:'').
      ($nws==1?($nws==1?$d:'').($r['newsletter'][0]==1?'Yes':'No'):'')."\n";
  }
  echo$result;
}
