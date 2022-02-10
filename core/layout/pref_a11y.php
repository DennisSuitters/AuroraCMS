<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Accessibility
 * @package    core/layout/pref_a11y.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('a11y','i-3x');?></div>
          <div>Preferences - Accessibility</div>
          <div class="content-title-actions">
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></a>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Accessibility</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 px-4 py-3 overflow-visible">
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/a11y#prefEnablea11y" data-tooltip="tooltip" aria-label="PermaLink to Preferences Enable Accessibility Checkbox">&#128279;</a>':'';?>
          <input id="prefBusinessHours" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="1" type="checkbox"<?=$config['options'][1]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label for="prefEnablea11y" id="configoptions11">Enable Widget</label>
        </div>
        <label id="prefa11yPosition" for="a11yPosition"><?=$user['rank']>899?'<a class="permalink" href="'.URL.$settings['system']['admin'].'/preferences/a11y#prefa11yPosition" data-tooltip="tooltip" aria-label="PermaLink to Preferences A11Y Position Selector">&#128279;</a>':'';?>Widget Position</label>
        <div class="form-row">
          <select id="a11yPosition" data-dbid="1" data-dbt="config" data-dbc="a11yPosition" onchange="update('1','config','a11yPosition',$(this).val(),'select');">
            <option value="left top"<?=$config['a11yPosition']=='left top'?' selected':'';?>>Top Left</option>
            <option value="right top"<?=$config['a11yPosition']=='right top'?' selected':'';?>>Top Right</option>
            <option value="right bottom"<?=$config['a11yPosition']=='right bottom'?' selected':'';?>>Bottom Right</option>
            <option value="left bottom"<?=$config['a11yPosition']=='left bottom'?' selected':'';?>>Bottom Left</option>
          </select>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
