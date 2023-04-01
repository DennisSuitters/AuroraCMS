<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Accessibility
 * @package    core/layout/pref_a11y.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <div class="row">
            <div class="col-12 col-sm">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
                <li class="breadcrumb-item active">Accessibility</li>
              </ol>
            </div>
          </div>
        </div>
        <div class="m-4">
          <div class="row">
            <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/a11y#prefEnablea11y" data-tooltip="tooltip" aria-label="PermaLink to Preferences Enable Accessibility Checkbox">&#128279;</a>':'';?>
            <input id="prefEnablea11y" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="1" type="checkbox"<?=($config['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
            <label for="prefEnablea11y" id="configoptions11">Enable Widget</label>
          </div>
          <label id="prefa11yPosition" for="a11yPosition"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/a11y#prefa11yPosition" data-tooltip="tooltip" aria-label="PermaLink to Preferences A11Y Position Selector">&#128279;</a>':'';?>Widget Position</label>
          <div class="form-row">
            <select id="a11yPosition" data-dbid="1" data-dbt="config" data-dbc="a11yPosition"<?=($user['options'][7]==1?' onchange="update(`1`,`config`,`a11yPosition`,$(this).val(),`select`);"':' disabled');?>>
              <option value="left top"<?=$config['a11yPosition']=='left top'?' selected':'';?>>Top Left</option>
              <option value="right top"<?=$config['a11yPosition']=='right top'?' selected':'';?>>Top Right</option>
              <option value="right bottom"<?=$config['a11yPosition']=='right bottom'?' selected':'';?>>Bottom Right</option>
              <option value="left bottom"<?=$config['a11yPosition']=='left bottom'?' selected':'';?>>Bottom Left</option>
            </select>
          </div>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
