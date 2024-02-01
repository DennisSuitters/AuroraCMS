<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Save Base64Image
 * @package    core/savebase64.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2021 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23-4
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$f=isset($_POST['filename'])?filter_input(INPUT_POST,'filename',FILTER_UNSAFE_RAW):'';
if($f!=''){
  $w=isset($_POST['where'])?filter_input(INPUT_POST,'where',FILTER_UNSAFE_RAW)."/":"";
  $f=substr($f,0,strrpos($f,'.'));
  $d=isset($_POST['imgBase64'])?filter_input(INPUT_POST,'imgBase64',FILTER_UNSAFE_RAW):'';
  if($d!=''){
    if(preg_match('/^data:image\/(\w+);base64,/',$d,$t)){
      $d=substr($d,strpos($d,',')+1);
      $t=strtolower($t[1]);
      if(!in_array($t,['gif','jpg','jpeg','png','webp'])){
        throw new \Exception('invalid image type');
      }
      $d=str_replace(' ','+',$d);
      $d=base64_decode($d);
      if($d===false){
        throw new \Exception('base64_decode failed');
      }
    }else{
      throw new \Exception('did not match data URI with image data');
    }
    if($t=='jpeg')$t='jpg';
    file_put_contents("../media/{$w}{$f}.{$t}",$d);
  }
}
