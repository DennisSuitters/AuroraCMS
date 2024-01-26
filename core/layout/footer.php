<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Edit - SEO
 * @package    core/layout/footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sl=$db->prepare("SELECT `id`,`rank`,`username`,`name` FROM `".$prefix."login` WHERE `lti`>:lti");
$sl->execute([':lti'=>time() - 300]);
$i=$sl->rowCount();?>
<footer class="footer d-block mt-5 mb-3 p-0 text-center small">
  <span class="d-block d-md-inline"><?=$i;?> Users Online</span><span class="d-none d-md-inline"> | </span><span class="d-block d-md-inline">AuroraCMS <?= VERSION;?> is hosted on <a href="https://github.com/DiemenDesign/AuroraCMS">GitHub</a></span> <span class="d-block d-md-inline">and is <a href="https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE">MIT Licensed</a>.</span><span class="d-none d-md-inline"> | </span><span class="d-block d-md-inline"><a href="https://github.com/DiemenDesign/AuroraCMS/issues">Report an Issue</a>.</span><span class="d-none d-md-inline"> | </span><span class="d-block d-md-inline"><a href="<?=$_SERVER['REQUEST_URI'];?>#back-to-top" data-tooltip="tooltip" aria-label="Back to Top">Back to Top</a></span>
</footer>
