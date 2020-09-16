<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Tracker
 * @package    core/layout/pref_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Switch to Enable/Disable Visitor Tracking.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Tracker</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options11" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11"<?php echo$config['options'][11]==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="development0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Visitor Tracking</label>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Page</th>
                <th>Origin</th>
                <th class="text-center">IP</th>
                <th class="text-center">Browser</th>
                <th class="text-center">System</th>
                <th class="text-center">Date</th>
                <th><div class="btn-group float-right" data-tooltip="tooltip" data-placement="left" data-title="Purge All"><button class="btn btn-secondary btn-sm trash" onclick="purge('0','tracker');return false;" aria-label="Purge All"><?php svg('purge');?></button></th>
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
                <tr id="l_<?php echo$r['id'];?>" data-ip="<?php echo$r['ip'];?>" class="small">
                  <td class="text-wrap align-middle" style="min-width:200px;max-width:250px;"><?php echo trim($r['urlDest']);?></td>
                  <td class="text-wrap align-middle" style="min-width:200px;max-width:250px;"><?php echo trim($r['urlFrom']);?></td>
                  <td class="text-center align-middle">
                    <a target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>"><?php echo$r['ip'];?></a>
                    <button class="btn btn-secondary btn-sm trash" data-tooltip="tooltip" data-title="Remove all of this IP" onclick="purge('<?php echo$r['ip'];?>','clearip')" aria-label="Remove all of this IP"><?php svg('eraser');?></button>
                  </td>
                  <td class="text-center align-middle"><?php echo ucfirst($r['browser']);?></td>
                  <td class="text-center align-middle"><?php echo ucfirst($r['os']);?></td>
                  <td class="text-center align-middle"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                  <td class="align-middle">
                    <div class="btn-group float-right">
                      <button class="btn btn-secondary pathviewer" data-tooltip="tooltip" data-data-title="View Visitor Path" data-toggle="popover" data-dbid="<?php echo$r['id'];?>" aria-label="View Visitor Path"><?php svg('seo-path');?></button>
                      <?php if($config['php_options'][0]==1){?>
                        <button class="btn btn-secondary phpviewer" data-tooltip="tooltip" data-title="Check IP with Project Honey Pot" data-toggle="popover" data-dbid="<?php echo$r['id'];?>" data-dbt="tracker" aria-label="Check IP with Project Honey Pot"><?php svg('brand-projecthoneypot');?></button>
                      <?php }?>
                      <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','tracker')" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                    </div>
                  </td>
                </tr>
              <?php }
              if($cnt>20){?>
                <tr id="more_20">
                  <td colspan="7">
                    <div class="form-group">
                      <div class="input-group">
                        <button class="btn btn-secondary btn-block" onclick="more('tracker','20','<?php echo(isset($args[1])&&$args[1]!=''?$args[1]:'');?>');">More</button>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
