<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Edit - SEO
 * @package    core/layout/footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.12
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sl=$db->prepare("SELECT `id`,`rank`,`username`,`name` FROM `".$prefix."login` WHERE `lti`>:lti");
$sl->execute([':lti'=>time() - 300]);
$i=$sl->rowCount();?>
<hr class="m-3 mt-5 mb-1">
<footer class="footer d-block mb-3 p-0 text-center small">
  <?=$i;?> Users Online | AuroraCMS <?= VERSION;?> is hosted on <a href="https://github.com/DiemenDesign/AuroraCMS">GitHub</a> and is <a href="https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE">MIT Licensed</a>. | <a href="https://github.com/DiemenDesign/AuroraCMS/issues">Report an Issue.</a> | <a href="<?=$_SERVER['REQUEST_URI'];?>#back-to-top" data-tooltip="tooltip" aria-label="Back to Top">Back to Top</a>
</footer>
