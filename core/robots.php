<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Robots Generator
 * @package    core/robots.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.2
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type:text/plain');
if(file_exists('../../core/config.ini'))$settings=parse_ini_file('../../core/config.ini',TRUE);
elseif(file_exists('../core/config.ini'))$settings=parse_ini_file('../core/config.ini',TRUE);
elseif(file_exists('core/config.ini'))$settings=parse_ini_file('core/config.ini',TRUE);
elseif(file_exists('config.ini'))$settings=parse_ini_file('config.ini',TRUE);?>
User-agent: *
Disallow: /<?=$settings['system']['admin'];?>/
Disallow: /cart/
Disallow: /checkout/
Disallow: /comingsoon/
Disallow: /maintenance/
Disallow: /offline/
Disallow: /orders/
Disallow: /proofs/
Disallow: /settings/
Sitemap: <?= URL.'sitemap.xml';?>
