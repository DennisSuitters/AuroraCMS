<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Get Email Messages
 * @package    core/get_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=isset($_POST['id'])?$_POST['id']:0;
$questions='';
if($id!=0){
  $scq=$db->prepare("SELECT * FROM `".$prefix."contentQuestions` WHERE `rid`=:rid ORDER BY `ti` ASC");
  $scq->execute([':rid'=>$id]);
  if($scq->rowCount()>0){
    while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
      $questions.='<div class="col-12"><label for="question'.$rcq['id'].'">'.$rcq['question'].'</div>'.
      '<div class="row">'.
        '<input id="question'.$rcq['id'].'" name="answer'.$rcq['id'].'" type="text" value="" placeholder="'.$rcq['question'].'">'.
      '</div></div>';
    }
  }else
    $questions='<input type="hidden" name="answer" value="none">';
}
echo$questions;
