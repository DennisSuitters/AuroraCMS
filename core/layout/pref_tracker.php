<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Tracker
 * @package    core/layout/pref_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.1.2 Use PHP short codes where possible.
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('tracker','i-3x');?></div>
          <div>Preferences - Tracker</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Tracker</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow overflow-visible">
        <div class="row p-3">
          <input id="options11" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11" type="checkbox"<?=$config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="options11" id="configoptions111">Visitor Tracking</label>
        </div>
        <table class="table-zebra">
          <thead>
            <tr>
              <th>Page</th>
              <th>Origin</th>
              <th class="text-center">IP</th>
              <th class="text-center">Browser</th>
              <th class="text-center">System</th>
              <th class="text-center">Date</th>
              <th>
                <div class="btn-group float-right">
                  <button class="btn-sm purge trash" data-tooltip="tooltip" data-placement="left" aria-label="Purge All" onclick="purge('0','tracker');return false;"><?= svg2('purge');?></button>
                </div>
              </th>
            </tr>
          </thead>
          <tbody id="l_tracker">
            <?php if(isset($args[1])&&$args[1]!=''){
              $s=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE LOWER(`browser`) LIKE LOWER (:browser) ORDER BY `ti` DESC LIMIT 20");
              $s->execute([
                ':browser'=>strtolower($args[1])
              ]);
            }else{
              $s=$db->prepare("SELECT * FROM `".$prefix."tracker` ORDER BY `ti` DESC LIMIT 20");
              $s->execute();
            }
            $cnt=$s->rowCount();
            while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr class="small" id="l_<?=$r['id'];?>" data-ip="<?=$r['ip'];?>">
                <td class="text-wrap align-middle" style="min-width:200px;max-width:250px;"><?= trim($r['urlDest']);?></td>
                <td class="text-wrap align-middle" style="min-width:200px;max-width:250px;"><?= trim($r['urlFrom']);?></td>
                <td class="text-center align-middle">
                  <a target="_blank" href="http://www.ipaddress-finder.com/?ip=<?=$r['ip'];?>"><?=$r['ip'];?></a>&nbsp;<button class="trash" data-tooltip="tooltip" aria-label="Remove all of this IP" onclick="purge('<?=$r['ip'];?>','clearip');"><?= svg2('eraser');?></button>
                </td>
                <td class="text-center align-middle"><?= ucfirst($r['browser']);?></td>
                <td class="text-center align-middle"><?= ucfirst($r['os']);?></td>
                <td class="text-center align-middle"><?= date($config['dateFormat'],$r['ti']);?></td>
                <td class="align-middle">
                  <div class="btn-group float-right">
                    <button data-fancybox data-type="ajax" data-src="core/layout/pathviewer.php?id=<?=$r['id'];?>" data-tooltip="tooltip" aria-label="View Visitor Path"><?= svg2('seo-path');?></button>
                    <?php if($config['php_options'][0]==1){?>
                      <button data-fancybox data-type="ajax" data-src="core/layout/phpviewer.php?id=<?=$r['id'];?>&t=tracker" data-tooltip="tooltip" aria-label="Check IP with Project Honey Pot"><?= svg2('brand-projecthoneypot');?></button>
                    <?php }?>
                    <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?=$r['id'];?>','tracker');"><?= svg2('trash');?></button>
                  </div>
                </td>
              </tr>
            <?php }
            if($cnt>20){?>
              <tr id="more_20">
                <td colspan="7">
                  <div class="form-row">
                    <button class="btn-block" onclick="more('tracker','20','<?=(isset($args[1])&&$args[1]!=''?$args[1]:'');?>');">More</button>
                  </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
