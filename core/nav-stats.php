<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Nav Stats
 * @package    core/nav-stats.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.20
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.20 Fix SQL Reserved Word usage.
 */
$getcfg=true;
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$nous=$db->prepare("SELECT COUNT(`id`) AS cnt FROM `".$prefix."login` WHERE `lti`>:lti AND `rank`!=1000");
$nous->execute([
  ':lti'=>time()-300
]);
$nou=$nous->fetch(PDO::FETCH_ASSOC);
$nc=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."comments` WHERE `contentType`!='review' AND `status`='unapproved'")->fetch(PDO::FETCH_ASSOC);
$nr=$db->query("SELECT COUNT(`id`) AS cnt FROM `".$prefix."comments` WHERE `contentType`='review' AND  `status`='unapproved'")->fetch(PDO::FETCH_ASSOC);
$nm=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."messages` WHERE `status`='unread'")->fetch(PDO::FETCH_ASSOC);
$po=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."orders` WHERE `status`='pending'")->fetch(PDO::FETCH_ASSOC);
$nb=$db->query("SELECT COUNT(`status`) AS cnt FROM `".$prefix."content` WHERE `contentType`='booking' AND `status`!='confirmed'")->fetch(PDO::FETCH_ASSOC);
$nu=$db->query("SELECT COUNT(`id`) AS cnt FROM `".$prefix."login` WHERE `activate`!='' AND `active`=0")->fetch(PDO::FETCH_ASSOC);
$nt=$db->query("SELECT COUNT(`id`) AS cnt FROM `".$prefix."content` WHERE `contentType`='testimonials' AND `status`!='published'")->fetch(PDO::FETCH_ASSOC);
$navStat=$nc['cnt']+$nr['cnt']+$nm['cnt']+$po['cnt']+$nb['cnt']+$nu['cnt']+$nt['cnt'];
$ns=$db->prepare("UPDATE `".$prefix."config` SET `navstat`=:navstat WHERE `id`='1'");
$ns->execute([':navstat'=>$navStat]);
$navStatU=$navStat>$config['navstat']?1:0;
print$navStat.','.$navStatU.','.$nou['cnt'].','.$nc['cnt'].','.$nr['cnt'].','.$nm['cnt'].','.$po['cnt'].','.$nb['cnt'].','.$nu['cnt'].','.$nt['cnt'];
