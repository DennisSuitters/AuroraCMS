<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Tracker
 * @package    core/layout/tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sv=$db->query("UPDATE `".$prefix."sidebar` SET `views`=`views`+1 WHERE `id`='50'")->execute();
$weekstart=strtotime("last sunday midnight this week");
$weekend=strtotime("next saturday midnight this week");;?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item active">Tracker</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="form-row justify-content-end">
                <div class="input-text">
                  <input id="options11" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?=($config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][5]==1?'':' disabled');?>>
                  <label for="options11">Enable Visit Tracker</label>
                </div>
                <input id="weekstart" type="date" value="<?=date('Y-m-d',$weekstart);?>" onchange="$(`#weekstartx`).val(getTimestamp(`weekstart`));">
                <input id="weekstartx" type="hidden" value="<?=$weekstart;?>">
                <div class="input-text">to</div>
                <input id="weekend" type="date" value="<?=date('Y-m-d',$weekend);?>" onchange="$(`#weekendx`).val(getTimestamp(`weekend`));">
                <input id="weekendx" type="hidden" value="<?=$weekstart;?>">
                <button onclick="trackermore($(`#weekstartx`).val(),$(`#weekendx`).val());">Go</button>
              </div>
            </div>
          </div>
        </div>
        <section class="content overflow-visible list" id="sortable">
          <article class="card m-0 p-0 py-2 overflow-visible card-list card-list-header bg-white shadow sticky-top d-none d-sm-block">
            <div class="row">
              <div class="col-1 pl-2 pb-2"><small>Date</small></div>
              <div class="col-11 pl-2 pb-2"><span class="badger badge-secondary">contentType</span> <small>Title</small></div>
              <div class="col text-center"><i class="i">browser-general</i><div class="small font-weight-light"><small>Direct</small></div></div>
              <div class="col text-center"><i class="i i-social social-bing">social-bing</i><div class="small font-weight-light"><small>Bing</small></div></div>
              <div class="col text-center"><i class="i i-social social-duckduckgo">social-duckduckgo</i><div class="small font-weight-light"><small>Duck Duck Go</small></div></div>
              <div class="col text-center"><i class="i i-social social-facebook">social-facebook</i><div class="small font-weight-light"><small>Facebook</small></div></div>
              <div class="col text-center"><i class="i i-social social-instagram">social-instagram</i><div class="small font-weight-light"><small>Instagram</small></div></div>
              <div class="col text-center"><i class="i i-social social-google">social-google</i><div class="small font-weight-light"><small>Google</small></div></div>
              <div class="col text-center"><i class="i i-social social-linkedin">social-linkedin</i><div class="small font-weight-light"><small>Linkedin</small></div></div>
              <div class="col text-center"><i class="i i-social social-reddit">social-reddit</i><div class="small font-weight-light"><small>Reddit</small></div></div>
              <div class="col text-center"><i class="i i-social social-threads">social-threads</i><div class="small font-weight-light"><small>Threads</small></div></div>
              <div class="col text-center"><i class="i i-social social-twitter">social-twitter</i><div class="small font-weight-light"><small>Twitter/X</small></div></div>
              <div class="col pr-2"></div>
            </div>
          </article>
          <div id="tracker" class="col-12">
            <?php $sv=$db->prepare("SELECT * FROM `".$prefix."visit_tracker` WHERE `ti` >=:ti1 AND `ti` <= :ti2 ORDER BY `ti` DESC");
            $sv->execute([
              ':ti1'=>$weekstart,
              ':ti2'=>$weekend
            ]);
            while($rv=$sv->fetch(PDO::FETCH_ASSOC)){
              if($rv['type']=='page'){
                $cs=$db->prepare("SELECT `id`,`title` FROM `".$prefix."menu` WHERE `id`=:id");
              }else{
                $cs=$db->prepare("SELECT `id`,`contentType`,`title` FROM `".$prefix."content` WHERE `id`=:id");
              }
              $cs->execute([':id'=>$rv['rid']]);
              $rs=$cs->fetch(PDO::FETCH_ASSOC);?>
              <article id="l_<?=$rv['id'];?>" class="card zebra m-0 p-0 pt-2 overflow-visible card-list item shadow">
                <div class="row pb-2">
                  <div class="col-2 pl-2 pb-2"><small><?=date($config['dateFormat'],$rv['ti']);?></small></div>
                  <div class="col-10 pl-2 pb-2"><span class="badger badge-secondary"><?=($rv['type']=='page'?'Page':ucfirst($rs['contentType']));?></span> <small><?=$rs['title'];?></small></div>
                  <div class="col text-center"><button id="direct<?=$rv['id'];?>" class="btn trash" onclick="$(`#direct<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`direct`,`0`);"><?=short_number($rv['direct']);?></button></div>
                  <div class="col text-center"><button id="bing<?=$rv['id'];?>" class="btn trash" onclick="$(`#bing<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`bing`,`0`);"><?=short_number($rv['bing']);?></button></div>
                  <div class="col text-center"><button id="duckduckgo<?=$rv['id'];?>" class="btn trash" onclick="$(`#duckduckgo<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`duckduckgo`,`0`);"><?=short_number($rv['duckduckgo']);?></button></div>
                  <div class="col text-center"><button id="facebook<?=$rv['id'];?>" class="btn trash" onclick="$(`#facebook<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`facebook`,`0`);"><?=short_number($rv['facebook']);?></button></div>
                  <div class="col text-center"><button id="instagram<?=$rv['id'];?>" class="btn trash" onclick="$(`#instagram<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`instagram`,`0`);"><?=short_number($rv['instagram']);?></button></div>
                  <div class="col text-center"><button id="google<?=$rv['id'];?>" class="btn trash" onclick="$(`#google<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`google`,`0`);"><?=short_number($rv['google']);?></button></div>
                  <div class="col text-center"><button id="linkedin<?=$rv['id'];?>" class="btn trash" onclick="$(`#linkedin<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`linkedin`,`0`);"><?=short_number($rv['linkedin']);?></button></div>
                  <div class="col text-center"><button id="reddit<?=$rv['id'];?>" class="btn trash" onclick="$(`#reddit<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`reddit`,`0`);"><?=short_number($rv['reddit']);?></button></div>
                  <div class="col text-center"><button id="threads<?=$rv['id'];?>" class="btn trash" onclick="$(`#threads<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`threads`,`0`);"><?=short_number($rv['threads']);?></button></div>
                  <div class="col text-center"><button id="twitter<?=$rv['id'];?>" class="btn trash" onclick="$(`#twitter<?=$rv['id'];?>`).text(`0`);updateButtons(`<?=$rv['id'];?>`,`visit_tracker`,`twitter`,`0`);"><?=short_number($rv['twitter']);?></button></div>
                  <div class="col text-right pr-2">
                    <?=($user['options'][0]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge(\''.$rv['id'].'\',\'visit_tracker\');"><i class="i">trash</i></button>':'');?>
                  </div>
                </div>
              </article>
            <?php }?>
          </div>
        </section>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
