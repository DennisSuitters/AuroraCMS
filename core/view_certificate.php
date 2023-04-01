<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Certificate
 * @package    core/view/view_certificate.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
$id=isset($_GET['id'])?$_GET['id']:0;
$uid=isset($_GET['uid'])?$_GET['uid']:0;
if($uid==0){
  $user=[
    'id'=>0,
    'username'=>'Anonymous',
    'name'=>'Anonymous'
  ];
}else{
  $su=$db->prepare("SELECT `id`,`username`,`name` FROM `".$prefix."login` WHERE `id`=:id");
  $su->execute([':id'=>$uid]);
  $user=$su->fetch(PDO::FETCH_ASSOC);
}
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
if(file_exists('../media/certificate/certificate-'.$r['cid'].'.html')){
  $html=file_get_contents('../media/certificate/certificate-'.$r['cid'].'.html');
  $html=preg_replace([
    '/<print config=[\"\']?business[\"\']?>/',
    '/<print course=[\"\']?title[\"\']?>/',
    '/<print date>/',
    '/<print user=[\"\']?username[\"\']?>/',
    '/<print user=[\"\']?name[\"\']?>/'
  ],[
    $config['business'],
    $r['title'],
    date('jS F Y',time()), // 22nd October 2020
    $user['username'],
    $user['name']!=''?$user['name']:$user['username']
  ],$html);
  print$html;
}else
  echo'Template file for Certificate '.$r['cid'].' does not exist!';
