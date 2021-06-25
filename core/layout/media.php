<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media
 * @package    core/layout/media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]=='settings')require'core/layout/set_media.php';
elseif($args[0]=='edit')require'core/layout/edit_media.php';
else{?>
<main>
  <section id="content" class="main">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('picture','i-3x');?></div>
          <div>Media</div>
          <div class="content-title-actions">
            <?=$user['options'][7]==1?'<a class="btn" href="'.URL.$settings['system']['admin'].'/media/settings" data-tooltip="tooltip" role="button" aria-label="Media Settings">'.svg2('settings').'</a>':'';?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item active">Media</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow overflow-visible">
        <?=$user['options'][0]==1?'<div class="row"><div id="elfinder" style="width:100%;"></div></div>':'<div class="alert alert-info" role="alert">You Don\'t Have Permissions To Use This Area</div>';
        require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php }
