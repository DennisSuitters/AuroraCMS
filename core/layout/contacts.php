<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Contacts
 * @package    core/layout/contacts.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
*/
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='38'")->execute();?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item active">Contacts</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="form-row justify-content-end">
                <input class="" id="filter-input" type="text" value="" placeholder="Search..." onkeyup="filterTextInput2();">
                <div class="btn-group">
                  <?=$user['options'][0]==1?'<a class="add" data-tooltip="left" href="'.URL.$settings['system']['admin'].'/accounts/add" role="button" aria-label="Add Contact"><i class="i">add</i></a>':'';?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section class="content mt-3 overflow-visible list" id="contentview">
          <article class="card mt-2 mb-0 p-0 py-2 overflow-visible card-list card-list-header shadow sticky-top d-none d-md-block">
            <div class="row">
              <div class="col-12 col-md-1">&nbsp;</div>
              <div class="col-12 col-md">Name</div>
              <div class="col-12 col-md">Email</div>
              <div class="col-12 col-md">Phone Number/s</div>
              <div class="col-12 col-md">Company</div>
              <div class="col-12 col-md-1">&nbsp;</div>
            </div>
          </article>
          <?php $sc=$db->prepare("SELECT * FROM `".$prefix."login` ORDER BY `name` ASC, `username` ASC, `email` ASC");
          $sc->execute();
          while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
            <article class="card list zebra my-2 p-2 border-0 overflow-visible shadow" id="l_<?=$rc['id'];?>" data-content="<?=$rc['username'].' '.$rc['name'].' '.$rc['email'].' '.$rc['business'].' '.$rc['phone'].' '.$rc['mobile'];?>">
              <div class="row">
                <div class="col-1 align-middle">
                  <img class="rounded align-top" src="<?=($rc['avatar']!=''?'media/avatar/'.$rc['avatar']:NOAVATAR);?>" style="width:50px;max-height:50px">
                </div>
                <div class="col col-md small align-middle pl-2 pl-md-0">
                  <div>
                    <?=$rc['name'];?><span class="badger badge-<?=rank($rc['rank']);?> ml-2 d-inline d-md-none"><?=ucwords(rank($rc['rank']));?></span>
                  </div>
                  <div class="badger badge-<?=rank($rc['rank']);?> d-none d-md-block">
                    <?=rank($rc['rank']);?>
                  </div>
                  <div class="d-block d-md-none">
                    <?=($rc['email']!=''?'<a href="mailto:'.$rc['email'].'">'.$rc['email'].'</a>':'');?>
                  </div>
                  <div class="d-block d-md-none">
                    <?=($rc['phone']!=''?'<div><a href="tel:'.$rc['phone'].'">'.$rc['phone'].'</a></div>':'').
                    ($rc['mobile']!=''?'<div><a href="tel:'.$rc['mobile'].'">'.$rc['mobile'].'</a></div>':'');?>
                  </div>
                  <div class="d-block d-md-none">
                    <?=($rc['business']!=''?'<div>'.$rc['business'].($rc['jobtitle']!=''?'<span class="pl-1 text-muted">'.$rc['jobtitle'].'</span>':'').'</div>':'');?>
                  </div>
                </div>
                <div class="col-md small align-middle d-none d-md-flex">
                  <?=($rc['email']!=''?'<a href="mailto:'.$rc['email'].'">'.$rc['email'].'</a>':'');?>
                </div>
                <div class="col-md small align-middle d-none d-md-flex">
                  <?=($rc['phone']!=''?'<div><a href="tel:'.$rc['phone'].'">'.$rc['phone'].'</a></div>':'').
                  ($rc['mobile']!=''?'<div><a href="tel:'.$rc['mobile'].'">'.$rc['mobile'].'</a></div>':'');?>
                </div>
                <div class="col-md small align-middle d-none d-md-flex">
                  <?=($rc['business']!=''?'<div>'.$rc['business'].'</div>':'');?>
                  <?=($rc['jobtitle']!=''?'<div class="text-muted">'.$rc['jobtitle'].'</div>':'');?>
                </div>
                <div class="col align-middle align-content-end">
                  <button class="quickeditbtn" data-qeid="<?=$rc['id'];?>" data-qet="contacts" data-tooltip="left" aria-label="Open/Close Contact Details"><i class="i">chevron-down</i><i class="i d-none">chevron-up</i></button>
                </div>
              </div>
            </article>
            <div class="quickedit" id="quickedit<?=$rc['id'];?>"></div>
          <?php }?>
        </section>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
