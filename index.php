<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Index - The Beginning
 * @package    index.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");
ini_set('session.use_trans_sid',0);
ini_set('session.use_cookies',1);
ini_set('session.use_only_cookies',1);
define('ROOT_DIR',realpath(__DIR__));
require'core/core.php';
