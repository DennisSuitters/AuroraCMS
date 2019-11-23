<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Robots Generator
 * @package    core/robots.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.7 Remove Disallow for cgi-bin.
 */
header('Content-Type:text/plain');?>
# As always, Asimov\'s Three Laws are in effect:
# 1. A robot may not injure a human being or, through inaction, allow a human being to come to harm.
# 2. A robot must obey orders given it by human beings except where such orders would conflict with the First Law.
# 3. A robot must protect its own existence as long as such protection does not conflict with the First or Second Law.

User-agent: *
Disallow: /harm/to/humans
Disallow: /ignoring/human/orders
Disallow: /harm/to/self
Disallow: /admin/

User-Agent: Samsung NaviBot
Disallow: /outdoor/areas

User-agent: T-800
User-agent: Skynet
User-agent: voltron
User-agent: Sentinels
User-agent: Ultron
Disallow: /

User-Agent: bender
Disallow: /my_shiny_metal_ass

User-Agent: Gort
Disallow: /earth

Sitemap: <?php echo URL.'sitemap.xml';?>
