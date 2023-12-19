<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Contacts
 * @package    core/layout/contacts.php
 * @author     Dennis Suitters <dennis@diemendesign.com.au>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
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
          </div>
        </div>
        <div class="row mt-3">
          <div class="messages-menu col-12 col-sm-5 col-lg-4 col-xl-4 col-xxl-2 border">
            <div class="p-3">
              <?=$user['options'][0]==1?'<div class="mb-3"><a class="btn-block" href="'.URL.$settings['system']['admin'].'/accounts/add" role="button">Add Contact</a></div>':'';?>
              <input class="" id="filter-input" type="text" value="" placeholder="Search..." onkeyup="filterTextInput2();">
            </div>
            <nav class="mt-3">
              <ul>
                <?php $sc=$db->prepare("SELECT * FROM `".$prefix."login` ORDER BY `name` ASC, `username` ASC, `email` ASC");
                $sc->execute();
                while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                  <li class="card chatListItem zebra border-1 border-light m-0 px-4 py-3 cursor-default" id="contactListItem<?=$rc['id'];?>" data-rank="<?=$rc['rank'];?>" data-content="<?=$rc['username'].' '.$rc['name'].' '.$rc['email'].' '.$rc['business'].' '.$rc['phone'].' '.$rc['mobile'];?>" onclick="getContact(`<?=$rc['id'];?>`);">
                    <div class="row">
                      <div class="col-2 d-inline-block">
                        <img class="rounded" style="width:40px;max-height:40px" src="<?=($rc['avatar']==''?NOAVATAR:'media/avatar/'.$rc['avatar']);?>">
                      </div>
                      <div class="col ml-2 d-inline-block">
                        <div class="small text-black"><?=$rc['name'];?></div>
                        <div class="small text-muted hidewhenempty"><?=($rc['business']!=''?$rc['business'].($rc['jobtitle']!=''?'<span class="badger badge-default pl-2">'.$rc['jobtitle'].'</span>':''):'');?></div>
                        <?=($rc['email']!=''?'<div class="small text-muted">'.$rc['email'].'</div>':'').
                        ($rc['phone']!=''?'<div class="small text-muted">'.$rc['phone'].'</div>':'').
                        ($rc['mobile']!=''?'<div class="small text-muted">'.$rc['mobile'].'</div>':'');?>
                      </div>
                    </div>
                  </li>
                <?php }?>
              </ul>
            </nav>
            <script>
              function getContact(id){
                if(!$('#contactListItem'+id).hasClass('border-success')){
                  $('.chatListItem').removeClass("border-success");
                  $('#contactListItem'+id).addClass("border-success");
                  $('#contactsScreen').fadeOut('slow',function(){
                    $.ajax({
                      type:"GET",
                      url:"core/get_contact.php",
                      data:{
                        id:id,
                        edit:<?=($user['options'][1]==1?1:0);?>,
                        del:<?=($user['rank']<1000?($user['options'][0]==1?1:0):0);?>
                      }
                    }).done(function(msg){
                      if(msg!='failed'){
                        $('#contactsScreen').html(msg);
                        $('#contactsScreen').fadeIn('slow');
                      }else{
                        toastr["error"]("There was an issue processing the request!");
                      }
                    });
                  });
                }
              }
            </script>
          </div>
          <section class="col-12 col-sm ml-3 overflow-visible list">
            <article class="card overflow-visible" id="contactsview">
              <div id="contactsScreen" style="width:100%;min-height:54vh;" data-empty="Select a Contact to view on the left!"></div>
            </article>
          </section>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
