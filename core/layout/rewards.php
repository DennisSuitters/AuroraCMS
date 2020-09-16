<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Rewards
 * @package    core/layout/rewards.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.2 Add Permissions Options
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.11 Fix Table Style Layout.
 * @changes    v0.0.11 Fix Date/Time Picker.
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active">Rewards</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-condensed table-striped table-hover">
            <?php if($user['options'][0]==1){?>
              <form target="sp" method="post" action="core/add_data.php">
                <input type="hidden" name="act" value="add_reward">
            <?php }?>
            <thead>
              <tr>
                <th class="text-center"><label for="code">Code</label></th>
                <th class="text-center"><label for="title">Title</label></th>
                <th class="text-center"><label for="method">Method</label></th>
                <th class="text-center"><label for="value">Value</label></th>
                <th class="text-center"><label for="quantity">Quantity</label></th>
                <th class="text-center"><label for="tis">Start Date</label></th>
                <th class="text-center"><label for="tie">End Date</label></th>
                <th></th>
              </tr>
            </thead>
            <?php if($user['options'][0]==1){?>
              <thead>
                <tr>
                  <td><input type="text" id="code" class="form-control input-sm" name="code" value="" placeholder="Code..."></td>
                  <td><input type="text" id="title" class="form-control input-sm" name="title" value="" placeholder="Title..."></td>
                  <td>
                    <select id="method" class="form-control input-sm" name="method">
                      <option value="0">% Off</option>
                      <option value="1">$ Off</option>
                    </select>
                  </td>
                  <td><input type="text" id="value" class="form-control input-sm" name="value" value="" placeholder="Value..."></td>
                  <td><input type="text" id="quantity" class="form-control input-sm" name="quantity" value="" placeholder="Quantity..."></td>
                  <td>
                    <div class="input-group">
                      <input type="text" id="tis" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tis" value="">
                      <input type="hidden" id="tisx" name="tisx" value="<?php echo time();?>">
                    </div>
                  </td>
                  <td>
                    <div class="input-group">
                      <input type="text" id="tie" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tie" value="">
                      <input type="hidden" id="tiex" name="tiex" value="<?php echo time();?>">
                    </div>
                  </td>
                  <td><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" data-title="Add" aria-label="Add"><?php svg('add');?></button></td>
                </tr>
              </thead>
            </form>
            <script>
              $('#tis').daterangepicker({
                singleDatePicker:true,
                linkedCalendars:false,
                autoUpdateInput:true,
                showDropdowns:true,
                showCustomRangeLabel:false,
                timePicker:true,
                startDate:"<?php echo date($config['dateFormat'],time());?>",
                locale:{
                  format:'MMM Do,YYYY h:mm A'
                }
              },function(start){
                $('#tisx').val(start.unix());
              });
              $('#tie').daterangepicker({
                singleDatePicker:true,
                linkedCalendars:false,
                autoUpdateInput:true,
                showDropdowns:true,
                showCustomRangeLabel:false,
                timePicker:true,
                startDate:"<?php echo date($config['dateFormat'],time());?>",
                locale:{
                  format:'MMM Do,YYYY h:mm A'
                }
              },function(start){
                $('#tiex').val(start.unix());
              });
            </script>
            <?php }?>
            <tbody id="rewards">
              <?php $s=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `ti` ASC, `code` ASC");
              $s->execute();
              while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <tr id="l_<?php echo$r['id'];?>">
                  <td class="text-center small"><?php echo$r['code'];?></td>
                  <td class="text-center small"><?php echo$r['title'];?></td>
                  <td class="text-center small"><?php echo$r['method']==0?'% Off':'$ Off';?></td>
                  <td class="text-center small"><?php echo $r['value'];?></td>
                  <td class="text-center small"><?php echo $r['quantity'];?></td>
                  <td class="text-center small"><?php echo$r['tis']!=0?date($config['dateFormat'],$r['tis']):'';?></td>
                  <td class="text-center small"><?php echo$r['tie']!=0?date($config['dateFormat'],$r['tie']):'';?></td>
                  <td>
                    <?php if($user['options'][0]==1){?>
                      <form target="sp" action="core/purge.php">
                        <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                        <input type="hidden" name="t" value="rewards">
                        <button class="btn btn-secondary trash" data-tooltip="tooltip" data-title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                      </form>
                    <?php }?>
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
