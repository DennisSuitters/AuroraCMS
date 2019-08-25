<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Rewards
 * @package    core/layout/rewards.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
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
            <form target="sp" method="post" action="core/add_data.php">
              <input type="hidden" name="act" value="add_reward">
              <thead>
                <tr>
                  <th class="col-xs-1 text-center"><label for="code">Code</label></th>
                  <th class="col-xs-4 text-center"><label for="title">Title</label></th>
                  <th class="col-xs-1 text-center"><label for="method">Method</label></th>
                  <th class="col-xs-1 text-center"><label for="value">Value</label></th>
                  <th class="col-xs-1 text-center"><label for="quantity">Quantity</label></th>
                  <th class="col-xs-2 text-center"><label for="tis">Start Date</label></th>
                  <th class="col-xs-2 text-center"><label for="tie">End Date</label></th>
                  <th></th>
                </tr>
              </thead>
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
                  <td><div class="input-group"><input type="text" id="tis" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tis" value=""></div></td>
                  <td><div class="input-group"><input type="text" id="tie" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tie" value=""></div></td>
                  <td><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="Add" aria-label="Add"><?php svg('add');?></button></td>
                </tr>
              </thead>
            </form>
            <tbody id="rewards">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY ti ASC, code ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>">
                <td class="col-xs-1 text-center small"><?php echo$r['code'];?></td>
                <td class="col-xs-4 text-center small"><?php echo$r['title'];?></td>
                <td class="col-xs-1 text-center small"><?php echo$r['method']==0?'% Off':'$ Off';?></td>
                <td class="col-xs-1 text-center small"><?php echo $r['value'];?></td>
                <td class="col-xs-1 text-center small"><?php echo $r['quantity'];?></td>
                <td class="col-xs-2 text-center small"><?php echo$r['tis']!=0?date($config['dateFormat'],$r['tis']):'';?></td>
                <td class="col-xs-2 text-center small"><?php echo$r['tie']!=0?date($config['dateFormat'],$r['tie']):'';?></td>
                <td role="cell">
                  <form target="sp" action="core/purge.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="t" value="rewards">
                    <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" aria-label="Delete"><?php svg('trash');?></button>
                  </form>
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
