<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media
 * @package    core/layout/media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_media.php';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active">Media</li>
  </ol>
  <div class="container m-0 p-0">
    <div class="row m-0 p-0">
      <div class="card col m-0 p-0">
        <div class="card-body m-0 p-0">
          <div id="elfinder" style="width:50vw;height:40vh;"></div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php }
