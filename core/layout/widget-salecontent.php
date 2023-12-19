<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - Holiday Content
 * @package    core/layout/widget-holidaycontent.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($config['options'][28]==1){
  $ssa=$db->prepare("SELECT `code`,`type`,`title`,`tis`,`tie` FROM `".$prefix."choices` WHERE `contentType`='sales' AND :ti BETWEEN `tis` AND `tie`");
	$ssa->execute([
		':ti'=>time()
	]);
  if($ssa->rowCount()>0){
    $rsa=$ssa->fetch(PDO::FETCH_ASSOC);
    $so=$db->prepare("SELECT DISTINCT(`iid`) FROM `".$prefix."orderitems` WHERE `ti`>:tis AND `ti`<:tie");
    $so->execute([
      ':tis'=>$rsa['tis'],
      ':tie'=>$rsa['tie']
    ]);
    if($so->rowCount()>0){?>
      <div class="item m-0 p-0 col-12" id="l_<?=$rw['id'];?>">
        <div class="alert widget m-3 p-0">
          <div class="toolbar px-2 py-1 handle">
            Sale Content Suggestions <small>(Items that sold during this Sales Period that aren't included in the current Sale)</small>
            <div class="btn-group">
              <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
            </div>
          </div>
          <div class="row p-2 justify-content-center">
            <?php
            while($ro=$so->fetch(PDO::FETCH_ASSOC)){
              $ss=$db->prepare("SELECT `id`,`thumb`,`title` FROM `".$prefix."content` WHERE `contentType`='inventory' AND `id`=:id AND `sale`!=:sale ORDER BY `views` DESC LIMIT 4");
              $ss->execute([
                ':id'=>$ro['iid'],
                ':sale'=>$rsa['code']
              ]);
              while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div class="col-12 col-sm-4 col-md-5 col-lg-4 col-xl-3 col-xxl-2 mx-2 my-3">
                  <div class="card">
                    <figure class="card-image">
                      <a href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$rs['id'];?>"><img src="<?=($rs['thumb']!=''?$rs['thumb']:NOIMAGE);?>"></a>
                    </figure>
                    <h2 class="card-title text-center py-3 noclamp">
                      <a href="<?= URL.$settings['system']['admin'];?>/content/edit/<?=$rs['id'];?>" data-tooltip="tooltip"<?=$user['options'][1]==1?' aria-label="Edit"':' aria-label="View"';?>><?=$rs['title'];?></a>
                    </h2>
                  </div>
                </div>
              <?php }
            }?>
          </div>
        </div>
      </div>
    <?php }
  }
}
