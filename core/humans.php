<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Generate Humans Text
 * @package    core/humans.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.7 Fix old CMS references.
 */
header("Content-Type:text/plain");
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'core'.DS.'db.php';
$config=$db->query("SELECT development,seoTitle,theme FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$theme=parse_ini_file('layout'.DS.$config['theme'].DS.'theme.ini',true);
$siteTitle=$config['seoTitle']!=''?$config['seoTitle']:URL;
$themeTitle=$theme['title'];
$themeCreator=$theme['creator'];
$themeURL=$theme['creator_url'];
echo <<< "OUT"
$siteTitle is powered by AuroraCMS [https://github.com/DiemenDesign/AuroraCMS]
Theme "$themeTitle" by $themeCreator [$themeURL]

/* TEAM */
Developer: Dennis Suitters
Site: https://github.com/DiemenDesign/
Location: Nirvana, Earth

Help: You, are you interested in helping develop AuroraCMS further?
Site: Jump into the GitHub Repo. https://github.com/DiemenDesign/AuroraCMS
Location: Your Work Station

/* THANKS */
Name: Alan Raycraft, [http://www.raycraft.com.au/]
For: Patience, Suggestions.

/* SITE */
Standards: ARIA/A11Y, HTML5, CSS3, PHP, jQuery, Vanilla Javascript
Backend Components: PHP, PDO, jQuery, Javascript, Bootstrap (Administration)
Frontend Componenets: Dependant on theme
Software: A FOSS Editor
OUT;
