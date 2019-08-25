<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update Blacklist
 * @package    core/updateblacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
define('DS',DIRECTORY_SEPARATOR);
$file=$_POST['file'];
$code=$_POST['code'];
$fp=fopen('..'.DS.$file,'w');
fwrite($fp,$code);
fclose($fp);
echo'<script>window.top.window.Pace.stop();</script>';
